<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bookissue extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('member_m');
        $this->load->model('role_m');
        $this->load->model('bookissue_m');
        $this->load->model('bookcategory_m');
        $this->load->model('book_m');
        $this->load->model('bookitem_m');
        $this->load->model('finehistory_m');
        $this->load->model('libraryconfigure_m');
        $this->load->model('paymentanddiscount_m');

        $lang = 'indonesia';
        $this->lang->load('peminjaman_buku', $lang);
    }

    public function index()
    {
        $loginmemberID = $this->session->userdata('loginmemberID');
        if ($_POST) {
            $memberID = $this->input->post('id_anggota');
        } else {
            $memberID = htmlentities(escapeString($this->uri->segment(3)));
        }
        $this->data['headerassets'] = array(
            'css'      => array(
                'assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css',
                'assets/custom/css/hidetable.css',
            ),
            'headerjs' => array(
                'assets/plugins/datatables.net/js/jquery.dataTables.min.js',
                'assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js',
            ),
            'js'       => array(
                'assets/custom/js/peminjaman_buku.js',
            ),
        );
		
		$this->data['get_title'] = 'Kelola Peminjaman Buku | '.$this->data['pengaturan_umum']->sitename;
		
        if ((int) $memberID) {
            $issueArray['id_anggota'] = $memberID;
        }
        if ($this->checkAdminLibrarianPermission()) {
            $issueArray['id_anggota'] = $loginmemberID;
        }
        $issueArray['dihapus_pada'] = 0;
        $this->data['bookissues'] = $this->bookissue_m->get_order_by_bookissue($issueArray);

        $this->data['id_anggota']     = $memberID;
        $this->data['roles']        = pluck($this->role_m->get_role(), 'peran', 'id_peran');
        $this->data['members']      = pluck($this->member_m->get_member(), 'nama', 'id_anggota');
        $this->data['kategori_buku'] = pluck($this->bookcategory_m->get_bookcategory(), 'nama', 'bookcategoryID');
        $this->data['buku']         = pluck($this->book_m->get_book(), 'nama', 'id_buku');
        $this->data["subview"]      = "peminjaman_buku/index";
        $this->load->view('_main_layout', $this->data);
    }

    public function add()
    {
        $this->data['headerassets'] = array(
            'css'      => array(
                'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
            ),
            'headerjs' => array(
                'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
            ),
            'js'       => array(
                'assets/custom/js/peminjaman_buku.js',
            ),
        );
		
		$this->data['get_title'] = 'Tambah Peminjaman Buku | '.$this->data['pengaturan_umum']->sitename;

        $this->data['members'] = $this->member_m->get_order_by_member(['status' => 1, 'dihapus_pada' => 0], array('id_anggota', 'nama'));
        $this->data['books']   = $this->book_m->get_order_by_book(array('status' => 0, 'dihapus_pada' => 0));

        $this->data['bookitems'] = [];
        $bookID                  = $this->input->post('id_buku');
        if ((int) $bookID) {
            $this->data['bookitems'] = $this->bookitem_m->get_order_by_bookitem(array('id_buku' => $bookID, 'status' => 0, 'dihapus_pada' => 0), array('bookno'));
        }

        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->data["subview"] = "peminjaman_buku/add";
                $this->load->view('_main_layout', $this->data);
            } else {
                $memberID = $this->input->post('id_anggota');
                $anggota   = $this->member_m->get_single_member(['id_anggota' => $memberID]);
                $buku     = $this->book_m->get_single_book(['id_buku' => $bookID]);

                $roleID           = $anggota->id_peran;
                $konfigurasi_perpustakaan = $this->libraryconfigure_m->get_single_libraryconfigure(array('id_peran' => $roleID));
                if (!calculate($konfigurasi_perpustakaan)) {
                    $konfigurasi_perpustakaan = (object) $this->libraryconfigure_m->konfigurasi_perpustakaan;
                }

                $issue_date = $this->input->post('issue_date');

                $array['id_peran']            = $anggota->id_peran;
                $array['id_anggota']          = $memberID;
                $array['bookcategoryID']    = $buku->bookcategoryID;
                $array['id_buku']            = $this->input->post('id_buku');
                $array['bookno']            = $this->input->post('bookno');
                $array['notes']             = $this->input->post('notes');
                $array['issue_date']        = date('Y-m-d', strtotime($issue_date));
                $array['expire_date']       = date('Y-m-d', strtotime($issue_date . "+ $konfigurasi_perpustakaan->per_renew_limit_day days"));
                $array['diperbarui']           = 1;
                $array['max_renewed_limit'] = $konfigurasi_perpustakaan->max_renewed_limit;
                $array['book_fine_per_day'] = $konfigurasi_perpustakaan->book_fine_per_day;
                $array['fineamount']        = 0;
                $array['status']            = 0;
                $array['dihapus_pada']        = 0;
                $array['tanggal_dibuat']       = date('Y-m-d H:i:s');
                $array['create_memberID']   = $this->session->userdata('loginmemberID');
                $array['create_roleID']     = $this->session->userdata('id_peran');
                $array['modify_date']       = date('Y-m-d H:i:s');
                $array['modify_memberID']   = $this->session->userdata('loginmemberID');
                $array['modify_roleID']     = $this->session->userdata('id_peran');
                $bookissueID                = $this->bookissue_m->insert_bookissue($array);

                $item_buku = $this->bookitem_m->get_single_bookitem(['id_buku' => $array['id_buku'], 'bookno' => $array['bookno'], 'status' => 0, 'dihapus_pada' => 0]);
                if (calculate($item_buku)) {
                    $this->bookitem_m->update_bookitem(['status' => 1], $item_buku->bookitemID);
                }
                $item_buku = $this->bookitem_m->get_order_by_bookitem(['id_buku' => $array['id_buku'], 'status' => 0, 'dihapus_pada' => 0]);
                if (!calculate($item_buku)) {
                    $this->book_m->update_book(['status' => 1], $array['id_buku']);
                }

                $fineArray                    = [];
                $fineArray['bookissueID']     = $bookissueID;
                $fineArray['bookstatusID']    = 0;
                $fineArray['diperbarui']         = 1;
                $fineArray['from_date']       = null;
                $fineArray['to_date']         = null;
                $fineArray['fineamount']      = 0;
                $fineArray['notes']           = null;
                $fineArray['tanggal_dibuat']     = date('Y-m-d H:i:s');
                $fineArray['create_memberID'] = $this->session->userdata('loginmemberID');
                $fineArray['create_roleID']   = $this->session->userdata('id_peran');
                $fineArray['modify_date']     = date('Y-m-d H:i:s');
                $fineArray['modify_memberID'] = $this->session->userdata('loginmemberID');
                $fineArray['modify_roleID']   = $this->session->userdata('id_peran');
                $this->finehistory_m->insert_finehistory($fineArray);

                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('peminjaman_buku/index'));
            }
        } else {
            $this->data["subview"] = "peminjaman_buku/add";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function edit()
    {
        $bookissueID = htmlentities(escapeString($this->uri->segment(3)));
		
		$this->data['get_title'] = 'Edit Peminjaman Buku | '.$this->data['pengaturan_umum']->sitename;
		
        if ((int) $bookissueID) {
            $peminjaman_buku = $this->bookissue_m->get_single_bookissue(array('bookissueID' => $bookissueID, 'dihapus_pada' => 0, 'status' => 0, 'diperbarui' => 1));
            if (calculate($peminjaman_buku)) {
                $this->data['peminjaman_buku']    = $peminjaman_buku;
                $this->data['headerassets'] = array(
                    'css'      => array(
                        'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
                    ),
                    'headerjs' => array(
                        'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
                    ),
                    'js'       => array(
                        'assets/custom/js/peminjaman_buku.js',
                    ),
                );

                $this->data['members'] = $this->member_m->get_order_by_member(['status' => 1, 'dihapus_pada' => 0], array('id_anggota', 'nama'));
                $this->data['books']   = $this->book_m->get_order_by_book(array('status' => 0, 'dihapus_pada' => 0));

                if ((int) $peminjaman_buku->id_buku) {
                    $bookID = $peminjaman_buku->id_buku;
                } else {
                    $bookID = $this->input->post('id_buku');
                }

                $this->data['bookitems'] = [];
                if ((int) $bookID) {
                    $this->data['bookitems'] = $this->bookitem_m->get_order_by_bookitem(array('id_buku' => $bookID, 'status' => 0, 'dihapus_pada' => 0), array('bookno'));
                }

                if ($_POST) {
                    $rules = $this->rules();
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == false) {
                        $this->data["subview"] = "peminjaman_buku/edit";
                        $this->load->view('_main_layout', $this->data);
                    } else {
                        $memberID = $this->input->post('id_anggota');
                        $anggota   = $this->member_m->get_single_member(['id_anggota' => $memberID]);
                        $buku     = $this->book_m->get_single_book(['id_buku' => $bookID]);

                        $roleID           = $anggota->id_peran;
                        $konfigurasi_perpustakaan = $this->libraryconfigure_m->get_single_libraryconfigure(array('id_peran' => $roleID));
                        if (!calculate($konfigurasi_perpustakaan)) {
                            $konfigurasi_perpustakaan = (object) $this->libraryconfigure_m->konfigurasi_perpustakaan;
                        }
                        $array['id_peran']            = $anggota->id_peran;
                        $array['id_anggota']          = $memberID;
                        $array['bookcategoryID']    = $buku->bookcategoryID;
                        $array['id_buku']            = $bookID;
                        $array['bookno']            = $this->input->post('bookno');
                        $array['notes']             = $this->input->post('notes');
                        $array['issue_date']        = date('Y-m-d', strtotime($this->input->post('issue_date')));
                        $array['expire_date']       = date('Y-m-d', strtotime($this->input->post('issue_date') . "+ $konfigurasi_perpustakaan->per_renew_limit_day days"));
                        $array['diperbarui']           = $peminjaman_buku->diperbarui;
                        $array['max_renewed_limit'] = $konfigurasi_perpustakaan->max_renewed_limit;
                        $array['book_fine_per_day'] = $konfigurasi_perpustakaan->book_fine_per_day;
                        $array['modify_date']       = date('Y-m-d H:i:s');
                        $array['modify_memberID']   = $this->session->userdata('loginmemberID');
                        $array['modify_roleID']     = $this->session->userdata('id_peran');

                        if (($peminjaman_buku->id_buku != $array['id_buku']) || ($peminjaman_buku->bookno != $array['bookno'])) {
                            $item_buku = $this->bookitem_m->get_single_bookitem(['id_buku' => $peminjaman_buku->id_buku, 'bookno' => $peminjaman_buku->bookno, 'status' => 1, 'dihapus_pada' => 0]);
                            if (calculate($item_buku)) {
                                $this->bookitem_m->update_bookitem(['status' => 0], $item_buku->bookitemID);
                            }
                        }

                        $item_buku = $this->bookitem_m->get_single_bookitem(['id_buku' => $array['id_buku'], 'bookno' => $array['bookno'], 'status' => 0, 'dihapus_pada' => 0]);
                        if (calculate($item_buku)) {
                            $this->bookitem_m->update_bookitem(['status' => 1], $item_buku->bookitemID);
                        }

                        $item_buku = $this->bookitem_m->get_single_bookitem(['id_buku' => $array['id_buku'], 'status' => 0, 'dihapus_pada' => 0]);
                        if (!calculate($item_buku)) {
                            $this->book_m->update_book(['status' => 1], $array['id_buku']);
                        }

                        $this->bookissue_m->update_bookissue($array, $bookissueID);
                        $this->session->set_flashdata('success', 'Success');
                        redirect(base_url('peminjaman_buku/index'));
                    }
                } else {
                    $this->data["subview"] = "peminjaman_buku/edit";
                    $this->load->view('_main_layout', $this->data);
                }
            } else {
                $this->data["subview"] = "_not_found";
                $this->load->view('_main_layout', $this->data);
            }
        } else {
            $this->data["subview"] = "_not_found";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function view()
    {
        $bookissueID = htmlentities(escapeString($this->uri->segment(3)));
		
		$this->data['get_title'] = 'Lihat Data Peminjaman Buku | '.$this->data['pengaturan_umum']->sitename;
		
        if ((int) $bookissueID) {
            $loginmemberID = $this->session->userdata('loginmemberID');
            if ($this->checkAdminLibrarianPermission()) {
                $issueArray['id_anggota'] = $loginmemberID;
            }
            $issueArray['bookissueID'] = $bookissueID;
            $issueArray['dihapus_pada']  = 0;
            $peminjaman_buku                 = $this->bookissue_m->get_single_bookissue($issueArray);
            if (calculate($peminjaman_buku)) {
                $this->data['peminjaman_buku'] = $peminjaman_buku;
                $this->data['anggota']    = $this->member_m->get_single_member(array('id_anggota' => $peminjaman_buku->id_anggota));
                $this->data['peran']      = $this->role_m->get_single_role(array('id_peran' => $peminjaman_buku->id_peran));
                $this->data['buku']      = $this->book_m->get_single_book(array('id_buku' => $peminjaman_buku->id_buku));
                $this->db->order_by('finehistoryID desc');
                $this->data['riwayat_denda']         = $this->finehistory_m->get_order_by_finehistory(array('bookissueID' => $bookissueID));
                $this->data['paymentanddiscounts'] = $this->paymentanddiscount_m->get_order_by_paymentanddiscount(array('bookissueID' => $bookissueID));
                $this->data["subview"]             = "peminjaman_buku/view";
                $this->load->view('_main_layout', $this->data);
            } else {
                $this->data["subview"] = "_not_found";
                $this->load->view('_main_layout', $this->data);
            }
        } else {
            $this->data["subview"] = "_not_found";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function delete()
    {
        $bookissueID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $bookissueID) {
            $peminjaman_buku = $this->bookissue_m->get_single_bookissue(array('bookissueID' => $bookissueID, 'dihapus_pada' => 0, 'status' => 0, 'diperbarui' => 1));
            if (calculate($peminjaman_buku)) {
                $item_buku = $this->bookitem_m->get_single_bookitem(['id_buku' => $peminjaman_buku->id_buku, 'bookno' => $peminjaman_buku->bookno, 'status !=' => 2, 'dihapus_pada' => 0]);
                if (calculate($item_buku)) {
                    $this->bookitem_m->update_bookitem(['status' => 0], $item_buku->bookitemID);
                    $this->book_m->update_book(['status' => 0], $array->id_buku);
                }
                $this->bookissue_m->update_bookissue(['dihapus_pada' => 1], $bookissueID);
                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('peminjaman_buku/index'));
            } else {
                $this->data["subview"] = "_not_found";
                $this->load->view('_main_layout', $this->data);
            }
        } else {
            $this->data["subview"] = "_not_found";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function renewandreturn()
    {
        $this->data['headerassets'] = array(
            'js' => array(
                'assets/custom/js/peminjaman_buku.js',
            ),
        );
		
		$this->data['get_title'] = 'Perpanjangan-Pengembalian  | '.$this->data['pengaturan_umum']->sitename;
		
        $bookissueID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $bookissueID) {
            $loginmemberID = $this->session->userdata('loginmemberID');
            if ($this->checkAdminLibrarianPermission()) {
                $issueArray['id_anggota'] = $loginmemberID;
            }
            $issueArray['bookissueID'] = $bookissueID;
            $issueArray['dihapus_pada']  = 0;
            $issueArray['status']      = 0;
            $peminjaman_buku                 = $this->bookissue_m->get_single_bookissue($issueArray);
            if (calculate($peminjaman_buku)) {
                $this->data['peminjaman_buku'] = $peminjaman_buku;
                $this->data['anggota']    = $this->member_m->get_single_member(array('id_anggota' => $peminjaman_buku->id_anggota));
                $this->data['peran']      = $this->role_m->get_single_role(array('id_peran' => $peminjaman_buku->id_peran));
                $this->data['buku']      = $this->book_m->get_single_book(array('id_buku' => $peminjaman_buku->id_buku));

                $this->db->order_by('finehistoryID desc');
                $this->data['riwayat_denda']         = $this->finehistory_m->get_order_by_finehistory(array('bookissueID' => $bookissueID));
                $this->data['paymentanddiscounts'] = $this->paymentanddiscount_m->get_order_by_paymentanddiscount(array('bookissueID' => $bookissueID));
                if ($_POST) {
                    $rules = $this->rules_renewandreturn();
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == false) {
                        $this->data["subview"] = "peminjaman_buku/renewandreturn";
                        $this->load->view('_main_layout', $this->data);
                    } else {
                        $bookstatusID          = $this->input->post('bookstatusID');
                        $array                 = [];
                        $array['bookissueID']  = $bookissueID;
                        $array['bookstatusID'] = ($bookstatusID - 1);
                        if ($bookstatusID < 2) {
                            $array['diperbarui'] = calculate($peminjaman_buku) ? ($peminjaman_buku->diperbarui + 1) : 0;
                        } else {
                            $array['diperbarui'] = calculate($peminjaman_buku) ? $peminjaman_buku->diperbarui : 0;
                        }

                        if (($this->input->post('fineamount') > 0) && (strtotime($peminjaman_buku->expire_date) < strtotime(date('Y-m-d')))) {
                            $from_date = get_increament_decrement_date(date('d-m-Y', strtotime($peminjaman_buku->expire_date)));
                            $to_date   = get_increament_decrement_date(date('d-m-Y'), '-1');

                            $array['from_date'] = $from_date;
                            $array['to_date']   = $to_date;
                        } else {
                            $array['from_date'] = null;
                            $array['to_date']   = null;
                        }
                        $array['fineamount']      = $this->input->post('fineamount');
                        $array['notes']           = $this->input->post('notes');
                        $array['tanggal_dibuat']     = date('Y-m-d H:i:s');
                        $array['create_memberID'] = $this->session->userdata('loginmemberID');
                        $array['create_roleID']   = $this->session->userdata('id_peran');
                        $array['modify_date']     = date('Y-m-d H:i:s');
                        $array['modify_memberID'] = $this->session->userdata('loginmemberID');
                        $array['modify_roleID']   = $this->session->userdata('id_peran');

                        $this->finehistory_m->insert_finehistory($array);

                        $roleID           = $peminjaman_buku->id_peran;
                        $konfigurasi_perpustakaan = $this->libraryconfigure_m->get_single_libraryconfigure(array('id_peran' => $roleID));
                        if (!calculate($konfigurasi_perpustakaan)) {
                            $konfigurasi_perpustakaan = $this->libraryconfigure_m->konfigurasi_perpustakaan;
                        }

                        if ($bookstatusID < 2) {
                            $issueArray['diperbarui'] = $peminjaman_buku->diperbarui + 1;
                        }
                        $issueArray['fineamount'] = $peminjaman_buku->fineamount + $this->input->post('fineamount');
                        $issueArray['status']     = ($bookstatusID - 1);

                        if ($peminjaman_buku->paymentamount > 0) {
                            $issueArray['paidstatus'] = 1;
                        } else {
                            $issueArray['paidstatus'] = 0;
                        }

                        if (strtotime(date('Y-m-d')) <= strtotime($peminjaman_buku->expire_date)) {
                            $issueArray['expire_date'] = date('Y-m-d', strtotime($peminjaman_buku->expire_date . "+ $konfigurasi_perpustakaan->per_renew_limit_day days"));
                        } else {
                            $issueArray['expire_date'] = date('Y-m-d', strtotime(date('d-m-Y') . "+ $konfigurasi_perpustakaan->per_renew_limit_day days"));
                        }
                        $this->bookissue_m->update_bookissue($issueArray, $bookissueID);

                        if (($bookstatusID == 2) || ($bookstatusID == 3)) {
                            $item_buku = $this->bookitem_m->get_single_bookitem(['id_buku' => $peminjaman_buku->id_buku, 'bookno' => $peminjaman_buku->bookno, 'dihapus_pada' => 0]);
                            if (calculate($item_buku)) {
                                $this->bookitem_m->update_bookitem(['status' => 0], $item_buku->bookitemID);
                                $this->book_m->update_book(['status' => 0], $peminjaman_buku->id_buku);
                            }
                        }

                        $this->session->set_flashdata('success', 'Success');
                        redirect(base_url('peminjaman_buku/view/' . $bookissueID));
                    }
                } else {
                    $this->data["subview"] = "peminjaman_buku/renewandreturn";
                    $this->load->view('_main_layout', $this->data);
                }
            } else {
                $this->data["subview"] = "_not_found";
                $this->load->view('_main_layout', $this->data);
            }
        } else {
            $this->data["subview"] = "_not_found";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function get_fineamount()
    {
        $retArr['status']  = false;
        $retArr['jumlah']  = 0;
        $retArr['pesan'] = '';

        if ($_POST && permissionChecker('bookissue_view')) {
            $bookissueID  = $this->input->post('bookissueID');
            $bookstatusID = $this->input->post('bookstatusID');

            if ((int) $bookissueID) {
                $peminjaman_buku = $this->bookissue_m->get_single_bookissue(['bookissueID' => $bookissueID]);
                if (calculate($peminjaman_buku)) {

                    $renewed           = $peminjaman_buku->diperbarui;
                    $max_renewed_limit = $peminjaman_buku->max_renewed_limit;
                    $book_fine_per_day = $peminjaman_buku->book_fine_per_day;
                    $expire_date       = $peminjaman_buku->expire_date;
                    $current_date      = date('Y-m-d');

                    if ($max_renewed_limit > calculate($peminjaman_buku->diperbarui)) {
                        $days = get_two_date_diff($peminjaman_buku->expire_date);
                        if ($days >= 1) {
                            $fineamount = $days * $book_fine_per_day;
                        } else {
                            $fineamount = 0;
                        }
                        if ($bookstatusID == 3) {
                            $buku       = $this->book_m->get_single_book(['id_buku' => $peminjaman_buku->id_buku]);
                            $fineamount = $fineamount + (calculate($buku) ? $buku->harga : 0);
                        }
                        $retArr['jumlah'] = $fineamount;
                        $retArr['status'] = true;
                    } else {
                        $retArr['pesan'] = 'You already renew this buku maximum time.';
                    }
                } else {
                    $retArr['pesan'] = 'The buku not available at this moment.';
                }
            } else {
                $retArr['pesan'] = 'The buku not available at this moment.';
            }
        } else {
            $retArr['pesan'] = 'You have not permission to access this page.';
        }
        echo json_encode($retArr);
    }

    public function set_paymentamount()
    {
        $retArray['status']  = false;
        $retArray['pesan'] = '';
        if ($_POST && permissionChecker('bookissue_add')) {
            $rules = $this->rules_paymentamount();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $retArray           = $this->form_validation->error_array();
                $retArray['status'] = false;
            } else {
                $array                    = [];
                $array['bookissueID']     = $this->input->post('bookissueID');
                $array['paymentamount']   = $this->input->post('paymentamount');
                $array['discountamount']  = ($this->input->post('discountamount')) ? $this->input->post('discountamount') : 0;
                $array['notes']           = $this->input->post('notes');
                $array['tanggal_dibuat']     = date('Y-m-d H:i:s');
                $array['create_memberID'] = $this->session->userdata('loginmemberID');
                $array['create_roleID']   = $this->session->userdata('id_peran');
                $array['modify_date']     = date('Y-m-d H:i:s');
                $array['modify_memberID'] = $this->session->userdata('loginmemberID');
                $array['modify_roleID']   = $this->session->userdata('id_peran');

                $this->paymentanddiscount_m->insert_paymentanddiscount($array);

                $bookissueID = $this->input->post('bookissueID');
                $peminjaman_buku   = $this->bookissue_m->get_single_bookissue(['bookissueID' => $bookissueID]);
                if (calculate($peminjaman_buku)) {
                    $issueArray                   = [];
                    $issueArray['paymentamount']  = $peminjaman_buku->paymentamount + $array['paymentamount'];
                    $issueArray['discountamount'] = $peminjaman_buku->discountamount + $array['discountamount'];

                    $totalfineamount       = $peminjaman_buku->fineamount;
                    $paymentdiscountamount = $issueArray['paymentamount'] + $issueArray['discountamount'];

                    if ($paymentdiscountamount == $totalfineamount) {
                        $issueArray['paidstatus'] = 2;
                    } elseif ($paymentdiscountamount <= 0) {
                        $issueArray['paidstatus'] = 0;
                    } else {
                        $issueArray['paidstatus'] = 1;
                    }
                    $this->bookissue_m->update_bookissue($issueArray, $bookissueID);
                }
                $retArray['status'] = true;
                $this->session->set_flashdata('success', 'Success');
            }
        }
        echo json_encode($retArray);
    }

    public function get_paymentamount()
    {
        $retArray['pesan']        = '';
        $retArray['status']         = false;
        $retArray['paymentamount']  = 0;
        $retArray['discountamount'] = '';
        if ($_POST && permissionChecker('bookissue_add')) {
            $bookissueID = $this->input->post('bookissueID');
            if ((int) $bookissueID) {
                $peminjaman_buku = $this->bookissue_m->get_single_bookissue(['bookissueID' => $bookissueID], array('fineamount', 'discountamount', 'paymentamount'));
                if (calculate($peminjaman_buku)) {
                    $retArray['status']        = true;
                    $retArray['paymentamount'] = ($peminjaman_buku->fineamount - ($peminjaman_buku->paymentamount + $peminjaman_buku->discountamount));
                } else {
                    $retArray['pesan'] = 'The data not found.';
                }
            } else {
                $retArray['pesan'] = 'The data not found.';
            }
        } else {
            $retArray['pesan'] = 'You have not permission to access this page.';
        }
        echo json_encode($retArray);
    }

    public function get_member()
    {
        echo "<option value='0'>" . $this->lang->line('bookissue_please_select') . "</option>";
        if ($_POST && permissionChecker('bookissue_add')) {
            $roleID = $this->input->post('id_peran');
            if ((int) $roleID) {
                $members = $this->member_m->get_order_by_member(array('id_peran' => $roleID, 'status' => 1, 'dihapus_pada' => 0), array('id_anggota', 'nama'));
                if (calculate($members)) {
                    foreach ($members as $anggota) {
                        echo "<option value='" . $anggota->id_anggota . "'>" . $anggota->nama . "</option>";
                    }
                }
            }
        }
    }

    public function get_book()
    {
        echo "<option value='0'>" . $this->lang->line('bookissue_please_select') . "</option>";
        if ($_POST && permissionChecker('bookissue_add')) {
            $bookcategoryID      = $this->input->post('bookcategoryID');
            $array['status']     = 0;
            $array['dihapus_pada'] = 0;
            if ((int) $bookcategoryID || ($bookcategoryID == 0)) {
                $array['bookcategoryID'] = $bookcategoryID;
            }
            $books = $this->book_m->get_order_by_book($array, array('id_buku', 'nama', 'codeno'));
            if (calculate($books)) {
                foreach ($books as $buku) {
                    echo "<option value='" . $buku->id_buku . "'>" . $buku->nama . ' - ' . $buku->codeno . "</option>";
                }
            }
        }
    }

    public function get_book_item()
    {
        echo "<option value='0'>" . $this->lang->line('bookissue_please_select') . "</option>";
        if ($_POST && permissionChecker('bookissue_add')) {
            $bookID = $this->input->post('id_buku');
            if ((int) $bookID) {
                $bookitems = $this->bookitem_m->get_order_by_bookitem(array('id_buku' => $bookID, 'status' => 0, 'dihapus_pada' => 0), array('bookno'));
                if (calculate($bookitems)) {
                    foreach ($bookitems as $item_buku) {
                        echo "<option value='" . $item_buku->bookno . "'>" . $item_buku->bookno . "</option>";
                    }
                }
            }
        }
    }

    private function rules()
    {
        $rules = array(
            array(
                'field' => 'id_anggota',
                'label' => $this->lang->line('bookissue_member'),
                'rules' => 'trim|xss_clean|required|numeric|required_no_zero|callback_check_eligible_for_book',
            ),
            array(
                'field' => 'id_buku',
                'label' => $this->lang->line('bookissue_book'),
                'rules' => 'trim|xss_clean|required|numeric|required_no_zero',
            ),
            array(
                'field' => 'bookno',
                'label' => $this->lang->line('bookissue_book_no'),
                'rules' => 'trim|xss_clean|required|numeric|required_no_zero|callback_check_available_book',
            ),
            array(
                'field' => 'issue_date',
                'label' => $this->lang->line('bookissue_issue_date'),
                'rules' => 'trim|xss_clean|required|valid_date',
            ),
            array(
                'field' => 'notes',
                'label' => $this->lang->line('bookissue_notes'),
                'rules' => 'trim',
            ),
        );
        return $rules;
    }

    private function rules_renewandreturn()
    {
        $rules = array(
            array(
                'field' => 'bookstatusID',
                'label' => $this->lang->line('bookissue_book_status'),
                'rules' => 'trim|xss_clean|required|required_no_zero|numeric|callback_check_renew_eligible',
            ),
            array(
                'field' => 'fineamount',
                'label' => $this->lang->line('bookissue_fine_amount'),
                'rules' => 'trim|xss_clean|required|numeric',
            ),
            array(
                'field' => 'notes',
                'label' => $this->lang->line('bookissue_notes'),
                'rules' => 'trim',
            ),
        );
        return $rules;
    }

    private function rules_paymentamount()
    {
        $rules = array(
            array(
                'field' => 'bookissueID',
                'label' => $this->lang->line('bookissue_book_issue'),
                'rules' => 'trim|xss_clean|required|numeric',
            ),
            array(
                'field' => 'paymentamount',
                'label' => $this->lang->line('bookissue_payment_amount'),
                'rules' => 'trim|xss_clean|required|numeric|callback_check_payment_amount',
            ),
            array(
                'field' => 'discountamount',
                'label' => $this->lang->line('bookissue_discount_amount'),
                'rules' => 'trim|xss_clean|numeric',
            ),
            array(
                'field' => 'notes',
                'label' => $this->lang->line('bookissue_notes'),
                'rules' => 'trim',
            ),
        );
        return $rules;
    }

    public function check_eligible_for_book($memberID)
    {
        $roleID = $this->input->post('id_peran');
        if ((int) $memberID && (int) $roleID) {
            $konfigurasi_perpustakaan = $this->libraryconfigure_m->get_single_libraryconfigure(array('id_peran' => $roleID));
            if (!calculate($konfigurasi_perpustakaan)) {
                $konfigurasi_perpustakaan = $this->libraryconfigure_m->konfigurasi_perpustakaan;
            }
            $max_issue_book    = $konfigurasi_perpustakaan->max_issue_book;
            $peminjaman_buku         = $this->bookissue_m->get_order_by_bookissue(['id_anggota' => $memberID, 'status' => 0, 'dihapus_pada' => 0]);
            $current_issuebook = calculate($peminjaman_buku);
            $bookissueID       = htmlentities(escapeString($this->uri->segment(3)));
            if ((int) $bookissueID) {
                $current_issuebook--;
            }

            if ($max_issue_book > $current_issuebook) {
                return true;
            } else {
                $this->form_validation->set_message("check_eligible_for_book", "You are not eligible to issue new buku. You have already issued maximum buku.");
                return false;
            }
        }
        return true;
    }

    public function check_available_book($bookno)
    {
        $bookID = $this->input->post('id_buku');
        if ((int) $bookno && (int) $bookID) {
            $f           = false;
            $bookissueID = htmlentities(escapeString($this->uri->segment(3)));
            if ((int) $bookissueID) {
                $peminjaman_buku = $this->bookissue_m->get_single_bookissue(array('bookissueID' => $bookissueID, 'dihapus_pada' => 0));
                if (($bookID == $peminjaman_buku->id_buku) && ($bookno == $peminjaman_buku->bookno)) {
                    $f = true;
                } else {
                    $item_buku = $this->bookitem_m->get_order_by_bookitem(['id_buku' => $bookID, 'bookno' => $bookno, 'status' => 0, 'dihapus_pada' => 0]);
                    if (calculate($item_buku)) {
                        $f = true;
                    }
                }
            } else {
                $item_buku = $this->bookitem_m->get_order_by_bookitem(['id_buku' => $bookID, 'bookno' => $bookno, 'status' => 0, 'dihapus_pada' => 0]);
                if (calculate($item_buku)) {
                    $f = true;
                }
            }
            if ($f) {
                return true;
            } else {
                $this->form_validation->set_message("check_available_book", "The Book currently not available.");
                return false;
            }
        } else {
            $this->form_validation->set_message("check_available_book", "The %s field is required.");
            return false;
        }
    }

    public function check_payment_amount()
    {
        $paymentamount  = $this->input->post('paymentamount');
        $discountamount = $this->input->post('discountamount') ? $this->input->post('discountamount') : 0;
        $bookissueID    = $this->input->post('bookissueID');

        if ($_POST && permissionChecker('bookissue_add') && (int) $bookissueID) {
            if (empty($paymentamount)) {
                $this->form_validation->set_message("check_payment_amount", "The %s field is required.");
                return false;
            } else {
                $peminjaman_buku = $this->bookissue_m->get_single_bookissue(['bookissueID' => $bookissueID, 'paidstatus !=' => 2]);
                if (calculate($peminjaman_buku)) {
                    $totalfineamount       = $peminjaman_buku->fineamount;
                    $paymentdiscountamount = $paymentamount + $discountamount;
                    if ($paymentamount <= 0) {
                        $this->form_validation->set_message("check_payment_amount", "Your payment amount are invalid.");
                        return false;
                    } elseif ($paymentdiscountamount > $totalfineamount) {
                        $this->form_validation->set_message("check_payment_amount", "Your payment or discount amount are invalid.");
                        return false;
                    }
                } else {
                    $this->form_validation->set_message("check_payment_amount", "Your issue data not fount.");
                    return false;
                }
            }
        }
        return true;
    }

    public function check_renew_eligible()
    {
        $bookissueID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $bookissueID) {
            $peminjaman_buku = $this->bookissue_m->get_single_bookissue(['bookissueID' => $bookissueID, 'status' => 0, 'dihapus_pada' => 0]);
            if (calculate($peminjaman_buku) && ($peminjaman_buku->status == 0)) {
                $bookstatusID = $this->input->post('bookstatusID');
                if (($bookstatusID == 1) && ($peminjaman_buku->diperbarui == $peminjaman_buku->max_renewed_limit)) {
                    $this->form_validation->set_message("check_renew_eligible", "You have already maximum time renewed.Please return your buku.");
                    return false;
                }
            } else {
                $this->form_validation->set_message("check_renew_eligible", "You have already return or lost this buku.");
                return false;
            }
        }
        return true;
    }

}
