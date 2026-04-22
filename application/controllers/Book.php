<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Book extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('book_m');
        $this->load->model('bookitem_m');
        $this->load->model('rack_m');
        $this->load->model('bookcategory_m');

        $lang = 'indonesia';
        $this->lang->load('buku', $lang);
    }

    public function index()
    {
        $this->data['headerassets'] = array(
            'css' => array(
                'assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css',
                'assets/custom/css/hidetable.css',
            ),
            'js'  => array(
                'assets/plugins/datatables.net/js/jquery.dataTables.min.js',
                'assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js',
            ),
        );
		
		
		$this->data['get_title'] = 'Kelola Buku | '.$this->data['pengaturan_umum']->sitename;
		  
        $this->data['books']   = $this->book_m->get_order_by_book(['dihapus_pada'=> 0]);
        $this->data["subview"] = "buku/index";
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
                'assets/custom/js/fileupload.js',
            ),
        );
		$this->data['get_title'] = 'Tambah Buku | '.$this->data['pengaturan_umum']->sitename;
		
        $this->data['racks']         = $this->rack_m->get_rack();
        $this->data['bookcategorys'] = $this->bookcategory_m->get_order_by_bookcategory(array('status' => 1));
        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->data["subview"] = "buku/add";
                $this->load->view('_main_layout', $this->data);
            } else {
                $array                    = [];
                $array['nama']            = $this->input->post('nama');
                $array['penulis']          = $this->input->post('penulis');
                $array['bookcategoryID']  = $this->input->post('bookcategoryID');
                $array['jumlah']        = $this->input->post('jumlah');
                $array['harga']           = $this->input->post('harga');
                $array['codeno']          = $this->input->post('codeno');
                $array['coverphoto']      = $this->upload_data['coverphoto']['file_name'];
                $array['isbnno']          = $this->input->post('isbnno');
                $array['rackID']          = ($this->input->post('rackID')) ? $this->input->post('rackID') : null;
                $array['editionnumber']   = $this->input->post('editionnumber');
                $array['editiondate']     = (($this->input->post('editiondate')) ? date('Y-m-d', strtotime($this->input->post('editiondate'))) : null);
                $array['penerbit']       = $this->input->post('penerbit');
                $array['publisheddate']   = (($this->input->post('publisheddate')) ? date('Y-m-d', strtotime($this->input->post('publisheddate'))) : null);
                $array['notes']           = $this->input->post('notes');
                $array['tanggal_dibuat']     = date('Y-m-d H:i:s');
                $array['create_memberID'] = $this->session->userdata('loginmemberID');
                $array['create_roleID']   = $this->session->userdata('id_peran');
                $array['modify_date']     = date('Y-m-d H:i:s');
                $array['modify_memberID'] = $this->session->userdata('loginmemberID');
                $array['modify_roleID']   = $this->session->userdata('id_peran');
                $this->book_m->insert_book($array);
                $bookID = $this->db->insert_id();

                $bookitemArray = [];
                for ($i = 1; $i <= $array['jumlah']; $i++) {
                    $bookitemArray[$i]['id_buku']     = $bookID;
                    $bookitemArray[$i]['bookno']     = $i;
                    $bookitemArray[$i]['status']     = 0;
                    $bookitemArray[$i]['dihapus_pada'] = 0;
                }
                $this->bookitem_m->insert_bookitem_batch($bookitemArray);

                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('buku/index'));
            }
        } else {
            $this->data["subview"] = "buku/add";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function edit()
    {
        $bookID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $bookID) {
            $buku = $this->book_m->get_single_book(array('id_buku' => $bookID, 'dihapus_pada' => 0));
            if (calculate($buku)) {
                $this->data['headerassets'] = array(
                    'css'      => array(
                        'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
                    ),
                    'headerjs' => array(
                        'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
                    ),
                    'js'       => array(
                        'assets/custom/js/fileupload.js',
                    ),
                );
				
				$this->data['get_title'] = 'Edit Buku | '.$this->data['pengaturan_umum']->sitename;
				
                $this->data['buku']          = $buku;
                $this->data['racks']         = $this->rack_m->get_rack();
                $this->data['bookcategorys'] = $this->bookcategory_m->get_order_by_bookcategory(array('status' => 1));
                if ($_POST) {
                    $rules = $this->rules();
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == false) {
                        $this->data["subview"] = "buku/edit";
                        $this->load->view('_main_layout', $this->data);
                    } else {
                        $array                    = [];
                        $array['nama']            = $this->input->post('nama');
                        $array['penulis']          = $this->input->post('penulis');
                        $array['bookcategoryID']  = $this->input->post('bookcategoryID');
                        $array['jumlah']        = $this->input->post('jumlah');
                        $array['harga']           = $this->input->post('harga');
                        $array['codeno']          = $this->input->post('codeno');
                        $array['coverphoto']      = $this->upload_data['coverphoto']['file_name'];
                        $array['isbnno']          = $this->input->post('isbnno');
                        $array['rackID']          = ($this->input->post('rackID')) ? $this->input->post('rackID') : null;
                        $array['editionnumber']   = $this->input->post('editionnumber');
                        $array['editiondate']     = (($this->input->post('editiondate')) ? date('Y-m-d', strtotime($this->input->post('editiondate'))) : null);
                        $array['penerbit']       = $this->input->post('penerbit');
                        $array['publisheddate']   = (($this->input->post('publisheddate')) ? date('Y-m-d', strtotime($this->input->post('publisheddate'))) : null);
                        $array['notes']           = $this->input->post('notes');
                        $array['modify_date']     = date('Y-m-d H:i:s');
                        $array['modify_memberID'] = $this->session->userdata('loginmemberID');
                        $array['modify_roleID']   = $this->session->userdata('id_peran');

                        if ($array['jumlah'] >= $buku->jumlah) {
                            $bookitems           = pluck($this->bookitem_m->get_order_by_bookitem(['id_buku' => $bookID]), 'bookitemID', 'bookno');
                            $insertbookitemArray = [];
                            $updatebookitemArray = [];
                            for ($i = ($buku->jumlah + 1); $i <= $array['jumlah']; $i++) {
                                if (isset($bookitems[$i])) {
                                    $updatebookitemArray[$i]['id_buku']     = $bookID;
                                    $updatebookitemArray[$i]['bookitemID'] = $bookitems[$i];
                                    $updatebookitemArray[$i]['bookno']     = $i;
                                    $updatebookitemArray[$i]['status']     = 0;
                                    $updatebookitemArray[$i]['dihapus_pada'] = 0;
                                } else {
                                    $insertbookitemArray[$i]['id_buku']     = $bookID;
                                    $insertbookitemArray[$i]['bookno']     = $i;
                                    $insertbookitemArray[$i]['status']     = 0;
                                    $insertbookitemArray[$i]['dihapus_pada'] = 0;
                                }
                            }

                            if (calculate($insertbookitemArray)) {
                                $this->bookitem_m->insert_bookitem_batch($insertbookitemArray);
                            }
                            if (calculate($updatebookitemArray)) {
                                $this->bookitem_m->update_bookitem_batch($updatebookitemArray, 'bookitemID');
                            }
                        } else {
                            $bookitems = pluck($this->bookitem_m->get_order_by_bookitem(array('id_buku' => $bookID)), 'bookitemID', 'bookno');

                            $bookno              = $array['jumlah'];
                            $deletebookitemArray = [];
                            for ($i = ($bookno + 1); $i <= $buku->jumlah; $i++) {
                                $deletebookitemArray[$i]['bookitemID'] = isset($bookitems[$i]) ? $bookitems[$i] : '';
                                $deletebookitemArray[$i]['id_buku']     = $bookID;
                                $deletebookitemArray[$i]['bookno']     = $i;
                                $deletebookitemArray[$i]['dihapus_pada'] = 1;
                            }

                            $this->bookitem_m->update_bookitem_batch($deletebookitemArray, 'bookitemID');
                        }
                        $this->book_m->update_book($array, $bookID);
                        $this->session->set_flashdata('success', 'Success');
                        redirect(base_url('buku/index'));
                    }
                } else {
                    $this->data["subview"] = "buku/edit";
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
        $bookID = htmlentities(escapeString($this->uri->segment(3)));
		$this->data['get_title'] = 'Lihat Data Buku | '.$this->data['pengaturan_umum']->sitename;
		
        if ((int) $bookID) {
            $buku = $this->book_m->get_single_book(array('id_buku' => $bookID));
            if (calculate($buku)) {
                $this->data['buku'] = $buku;

                $this->data['kategori_buku'] = [];
                if ((int) $buku->bookcategoryID) {
                    $this->data['kategori_buku'] = $this->bookcategory_m->get_single_bookcategory(['bookcategoryID' => $buku->bookcategoryID]);
                }
                $this->data['rak'] = [];
                if ((int) $buku->rackID) {
                    $this->data['rak'] = $this->rack_m->get_single_rack(['rackID' => $buku->rackID]);
                }

                $this->data['racks']         = $this->rack_m->get_rack();
                $this->data['bookcategorys'] = $this->bookcategory_m->get_order_by_bookcategory(array('status' => 1));

                $this->data["subview"] = "buku/view";
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
        $bookID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $bookID) {
            $buku = $this->book_m->get_single_book(array('id_buku' => $bookID, 'deleted_at !=' => 1));
            if (calculate($buku)) {
                $this->book_m->update_book(['dihapus_pada' => 1], $bookID);
                $this->bookitem_m->update_bookitem_by_bookID(['dihapus_pada' => 1], $bookID);
                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('buku/index'));
            } else {
                $this->data["subview"] = "_not_found";
                $this->load->view('_main_layout', $this->data);
            }
        } else {
            $this->data["subview"] = "_not_found";
            $this->load->view('_main_layout', $this->data);
        }
    }

    private function rules()
    {
        $rules = array(
            array(
                'field' => 'nama',
                'label' => $this->lang->line('book_name'),
                'rules' => 'trim|xss_clean|required|max_length[100]',
            ),
            array(
                'field' => 'penulis',
                'label' => $this->lang->line('book_author'),
                'rules' => 'trim|xss_clean|required|max_length[100]',
            ),
            array(
                'field' => 'jumlah',
                'label' => $this->lang->line('book_quantity'),
                'rules' => 'trim|xss_clean|required|numeric',
            ),
            array(
                'field' => 'harga',
                'label' => $this->lang->line('book_price'),
                'rules' => 'trim|xss_clean|required|max_length[100]|numeric',
            ),
            array(
                'field' => 'codeno',
                'label' => $this->lang->line('book_code_no'),
                'rules' => 'trim|xss_clean|required|max_length[100]',
            ),
            array(
                'field' => 'coverphoto',
                'label' => $this->lang->line('book_cover_photo'),
                'rules' => 'trim|xss_clean|callback_coverphoto_upload',
            ),
            array(
                'field' => 'bookcategoryID',
                'label' => $this->lang->line('book_book_category'),
                'rules' => 'trim|xss_clean|required|numeric|required_no_zero',
            ),
            array(
                'field' => 'isbnno',
                'label' => $this->lang->line('book_isbn_no'),
                'rules' => 'trim|xss_clean|max_length[100]',
            ),
            array(
                'field' => 'rackID',
                'label' => $this->lang->line('book_rack'),
                'rules' => 'trim|xss_clean|numeric',
            ),
            array(
                'field' => 'editionnumber',
                'label' => $this->lang->line('book_edition_number'),
                'rules' => 'trim|xss_clean|max_length[100]',
            ),
            array(
                'field' => 'editiondate',
                'label' => $this->lang->line('book_edition_date'),
                'rules' => 'trim|xss_clean|valid_date',
            ),
            array(
                'field' => 'penerbit',
                'label' => $this->lang->line('book_publisher'),
                'rules' => 'trim|xss_clean|max_length[200]',
            ),
            array(
                'field' => 'publisheddate',
                'label' => $this->lang->line('book_published_date'),
                'rules' => 'trim|xss_clean|valid_date',
            ),
            array(
                'field' => 'notes',
                'label' => $this->lang->line('book_notes'),
                'rules' => 'trim|xss_clean|max_length[1000]',
            ),
        );
        return $rules;
    }

    public function coverphoto_upload()
    {
        $bookID = htmlentities(escapeString($this->uri->segment(3)));
        $buku   = array();
        if ((int) $bookID) {
            $buku = $this->book_m->get_single_book(array('id_buku' => $bookID));
        }

        $new_file = "";
        if ($_FILES["coverphoto"]['nama'] != "") {
            $file_name        = $_FILES["coverphoto"]['nama'];
            $random           = rand(1, 10000000000000000);
            $file_name_rename = hash('sha512', $random . config_item("encryption_key"));
            $explode          = explode('.', $file_name);
            if (calculate($explode) >= 2) {
                $new_file                = $file_name_rename . '.' . end($explode);
                $config['upload_path']   = "./uploads/buku";
                $config['allowed_types'] = "gif|jpg|png|jpeg";
                $config['file_name']     = $new_file;
                $config['max_size']      = "2048";
                $config['max_width']     = "2000";
                $config['max_height']    = "2000";
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload("coverphoto")) {
                    $this->form_validation->set_message("coverphoto_upload", $this->upload->display_errors());
                    return false;
                } else {
                    $this->upload_data['coverphoto'] = $this->upload->data();
                    return true;
                }
            } else {
                $this->form_validation->set_message("coverphoto_upload", "Invalid file");
                return false;
            }
        } else {
            if (calculate($buku)) {
                $this->upload_data['coverphoto'] = array('file_name' => $buku->coverphoto);
                return true;
            } else {
                $this->form_validation->set_message("coverphoto_upload", "The %s field is required.");
                return false;
            }
        }
    }

}
