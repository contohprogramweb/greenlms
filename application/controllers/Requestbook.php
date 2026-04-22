<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Requestbook extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('rack_m');
        $this->load->model('book_m');
        $this->load->model('bookitem_m');
        $this->load->model('requestbook_m');
        $this->load->model('bookcategory_m');

        $lang = 'indonesia';
        $this->lang->load('permintaan_buku', $lang);
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
		
		$this->data['get_title'] = 'Kelola Permintaan Buku | '.$this->data['pengaturan_umum']->sitename;
		
        $this->data['requestbooks']  = $this->requestbook_m->get_requestbook();
        $this->data['bookcategorys'] = pluck($this->bookcategory_m->get_bookcategory(), 'nama', 'bookcategoryID');
        $this->data["subview"]       = "permintaan_buku/index";
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
		$this->data['get_title'] = 'Tambah Permintaan Buku | '.$this->data['pengaturan_umum']->sitename;
		
        $this->data['bookcategorys'] = $this->bookcategory_m->get_order_by_bookcategory(array('status' => 1));
        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->data["subview"] = "permintaan_buku/add";
                $this->load->view('_main_layout', $this->data);
            } else {
                $array                    = [];
                $array['nama']            = $this->input->post('nama');
                $array['penulis']          = $this->input->post('penulis');
                $array['coverphoto']      = $this->upload_data['coverphoto']['file_name'];
                $array['bookcategoryID']  = $this->input->post('bookcategoryID');
                $array['isbnno']          = $this->input->post('isbnno');
                $array['editionnumber']   = $this->input->post('editionnumber');
                $array['editiondate']     = ($this->input->post('editiondate')) ? date('Y-m-d', strtotime($this->input->post('editiondate'))) : null;
                $array['penerbit']       = $this->input->post('penerbit');
                $array['publisheddate']   = ($this->input->post('publisheddate')) ? date('Y-m-d', strtotime($this->input->post('publisheddate'))) : null;
                $array['notes']           = $this->input->post('notes');
                $array['status']          = 0;
                $array['dihapus_pada']      = 0;
                $array['tanggal_dibuat']     = date('Y-m-d H:i:s');
                $array['create_memberID'] = $this->session->userdata('loginmemberID');
                $array['create_roleID']   = $this->session->userdata('id_peran');
                $array['modify_date']     = date('Y-m-d H:i:s');
                $array['modify_memberID'] = $this->session->userdata('loginmemberID');
                $array['modify_roleID']   = $this->session->userdata('id_peran');

                $this->requestbook_m->insert_requestbook($array);
                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('permintaan_buku/index'));
            }
        } else {
            $this->data["subview"] = "permintaan_buku/add";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function edit()
    {
        $requestbookID = htmlentities(escapeString($this->uri->segment(3)));
		$this->data['get_title'] = 'Edit Permintaan Buku | '.$this->data['pengaturan_umum']->sitename;
		
		
        if ((int) $requestbookID) {
            $permintaan_buku = $this->requestbook_m->get_single_requestbook(['requestbookID' => $requestbookID, 'status' => 0, 'dihapus_pada' => 0]);
            if (calculate($permintaan_buku)) {
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
                $this->data['permintaan_buku']   = $permintaan_buku;
                $this->data['bookcategorys'] = $this->bookcategory_m->get_order_by_bookcategory(array('status' => 1));

                if ($_POST) {
                    $rules = $this->rules();
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == false) {
                        $this->data["subview"] = "permintaan_buku/edit";
                        $this->load->view('_main_layout', $this->data);
                    } else {
                        $array                    = [];
                        $array['nama']            = $this->input->post('nama');
                        $array['penulis']          = $this->input->post('penulis');
                        $array['coverphoto']      = $this->upload_data['coverphoto']['file_name'];
                        $array['bookcategoryID']  = $this->input->post('bookcategoryID');
                        $array['isbnno']          = $this->input->post('isbnno');
                        $array['editionnumber']   = $this->input->post('editionnumber');
                        $array['editiondate']     = ($this->input->post('editiondate')) ? date('Y-m-d', strtotime($this->input->post('editiondate'))) : null;
                        $array['penerbit']       = $this->input->post('penerbit');
                        $array['publisheddate']   = ($this->input->post('publisheddate')) ? date('Y-m-d', strtotime($this->input->post('publisheddate'))) : null;
                        $array['status']          = 0;
                        $array['dihapus_pada']      = 0;
                        $array['notes']           = $this->input->post('notes');
                        $array['modify_date']     = date('Y-m-d H:i:s');
                        $array['modify_memberID'] = $this->session->userdata('loginmemberID');
                        $array['modify_roleID']   = $this->session->userdata('id_peran');

                        $this->requestbook_m->update_requestbook($array, $requestbookID);
                        $this->session->set_flashdata('success', 'Success');
                        redirect(base_url('permintaan_buku/index'));
                    }
                } else {
                    $this->data["subview"] = "permintaan_buku/edit";
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
        $requestbookID = htmlentities(escapeString($this->uri->segment(3)));
		$this->data['get_title'] = 'Lihat Data Permintaan Buku | '.$this->data['pengaturan_umum']->sitename;
		
        if ((int) $requestbookID) {
            $permintaan_buku = $this->requestbook_m->get_single_requestbook(array('requestbookID' => $requestbookID));
            if (calculate($permintaan_buku)) {
                $this->data['permintaan_buku']  = $permintaan_buku;
                $this->data['kategori_buku'] = $this->bookcategory_m->get_single_bookcategory(array('bookcategoryID' => $permintaan_buku->bookcategoryID));

                $this->data["subview"] = "permintaan_buku/view";
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
        $requestbookID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $requestbookID) {
            $permintaan_buku = $this->requestbook_m->get_single_requestbook(array('requestbookID' => $requestbookID, 'dihapus_pada' => 0));
            if (calculate($permintaan_buku)) {
                $this->requestbook_m->update_requestbook(['dihapus_pada' => 1], $requestbookID);
                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('permintaan_buku/index'));
            } else {
                $this->data["subview"] = "_not_found";
                $this->load->view('_main_layout', $this->data);
            }
        } else {
            $this->data["subview"] = "_not_found";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function rejected()
    {
        $requestbookID = htmlentities(escapeString($this->uri->segment(3)));
        if (permissionChecker('requestbook_delete') && (int) $requestbookID) {
            $permintaan_buku = $this->requestbook_m->get_single_requestbook(array('requestbookID' => $requestbookID, 'status' => 0, 'dihapus_pada' => 0));
            if (calculate($permintaan_buku)) {
                $this->requestbook_m->update_requestbook(['status' => 2], $requestbookID);
                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('permintaan_buku/index'));
            } else {
                $this->data["subview"] = "_not_found";
                $this->load->view('_main_layout', $this->data);
            }
        } else {
            $this->data["subview"] = "_not_found";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function bookadd()
    {
        $requestbookID = htmlentities(escapeString($this->uri->segment(3)));
		$this->data['get_title'] = 'Tambah Buku | '.$this->data['pengaturan_umum']->sitename;
		
        if (permissionChecker('book_add') && (int) $requestbookID) {
            $permintaan_buku = $this->requestbook_m->get_single_requestbook(array('requestbookID' => $requestbookID));
            if (calculate($permintaan_buku) && ($permintaan_buku->status == 0) && ($permintaan_buku->dihapus_pada == 0)) {
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
                $this->data['permintaan_buku']   = $permintaan_buku;
                $this->data['racks']         = $this->rack_m->get_rack();
                $this->data['bookcategorys'] = $this->bookcategory_m->get_order_by_bookcategory(array('status' => 1));
                if ($_POST) {
                    $rules = $this->rules_bookadd();
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == false) {
                        $this->data["subview"] = "permintaan_buku/bookadd";
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
                        $array['rackID']          = $this->input->post('rackID');
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

                        $this->requestbook_m->update_requestbook(['status' => 1], $requestbookID);

                        $this->session->set_flashdata('success', 'Success');
                        redirect(base_url('buku/index'));
                    }
                } else {
                    $this->data["subview"] = "permintaan_buku/bookadd";
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

    private function rules()
    {
        $rules = array(
            array(
                'field' => 'nama',
                'label' => $this->lang->line('requestbook_name'),
                'rules' => 'trim|xss_clean|required|max_length[100]',
            ),
            array(
                'field' => 'penulis',
                'label' => $this->lang->line('requestbook_author'),
                'rules' => 'trim|xss_clean|required|max_length[100]',
            ),
            array(
                'field' => 'coverphoto',
                'label' => $this->lang->line('requestbook_cover_photo'),
                'rules' => 'trim|xss_clean|callback_coverphoto_upload',
            ),
            array(
                'field' => 'bookcategoryID',
                'label' => $this->lang->line('requestbook_book_category'),
                'rules' => 'trim|xss_clean|numeric',
            ),
            array(
                'field' => 'isbnno',
                'label' => $this->lang->line('requestbook_isbn_no'),
                'rules' => 'trim|xss_clean|max_length[100]',
            ),
            array(
                'field' => 'editionnumber',
                'label' => $this->lang->line('requestbook_edition_number'),
                'rules' => 'trim|xss_clean|max_length[100]',
            ),
            array(
                'field' => 'editiondate',
                'label' => $this->lang->line('requestbook_edition_date'),
                'rules' => 'trim|xss_clean|valid_date',
            ),
            array(
                'field' => 'penerbit',
                'label' => $this->lang->line('requestbook_publisher'),
                'rules' => 'trim|xss_clean|max_length[200]',
            ),
            array(
                'field' => 'publisheddate',
                'label' => $this->lang->line('requestbook_published_date'),
                'rules' => 'trim|xss_clean|valid_date',
            ),
            array(
                'field' => 'notes',
                'label' => $this->lang->line('requestbook_notes'),
                'rules' => 'trim|xss_clean|max_length[1000]',
            ),
        );
        return $rules;
    }

    private function rules_bookadd()
    {
        $rules = array(
            array(
                'field' => 'nama',
                'label' => $this->lang->line('requestbook_name'),
                'rules' => 'trim|xss_clean|required|max_length[100]',
            ),
            array(
                'field' => 'penulis',
                'label' => $this->lang->line('requestbook_author'),
                'rules' => 'trim|xss_clean|required|max_length[100]',
            ),
            array(
                'field' => 'jumlah',
                'label' => $this->lang->line('requestbook_quantity'),
                'rules' => 'trim|xss_clean|required|numeric',
            ),
            array(
                'field' => 'harga',
                'label' => $this->lang->line('requestbook_price'),
                'rules' => 'trim|xss_clean|required|max_length[100]|numeric',
            ),
            array(
                'field' => 'codeno',
                'label' => $this->lang->line('requestbook_code_no'),
                'rules' => 'trim|xss_clean|required|max_length[100]',
            ),
            array(
                'field' => 'coverphoto',
                'label' => $this->lang->line('requestbook_cover_photo'),
                'rules' => 'trim|xss_clean|callback_book_coverphoto_upload',
            ),
            array(
                'field' => 'bookcategoryID',
                'label' => $this->lang->line('requestbook_book_category'),
                'rules' => 'trim|xss_clean|numeric',
            ),
            array(
                'field' => 'isbnno',
                'label' => $this->lang->line('requestbook_isbn_no'),
                'rules' => 'trim|xss_clean|max_length[100]',
            ),
            array(
                'field' => 'rackID',
                'label' => $this->lang->line('requestbook_rack'),
                'rules' => 'trim|xss_clean|numeric',
            ),
            array(
                'field' => 'editionnumber',
                'label' => $this->lang->line('requestbook_edition_number'),
                'rules' => 'trim|xss_clean|max_length[100]',
            ),
            array(
                'field' => 'editiondate',
                'label' => $this->lang->line('requestbook_edition_date'),
                'rules' => 'trim|xss_clean|valid_date',
            ),
            array(
                'field' => 'penerbit',
                'label' => $this->lang->line('requestbook_publisher'),
                'rules' => 'trim|xss_clean|max_length[200]',
            ),
            array(
                'field' => 'publisheddate',
                'label' => $this->lang->line('requestbook_published_date'),
                'rules' => 'trim|xss_clean|valid_date',
            ),
            array(
                'field' => 'notes',
                'label' => $this->lang->line('requestbook_notes'),
                'rules' => 'trim|xss_clean|max_length[1000]',
            ),
        );
        return $rules;
    }

    public function coverphoto_upload()
    {
        $requestbookID = htmlentities(escapeString($this->uri->segment(3)));
        $permintaan_buku   = array();
        if ((int) $requestbookID) {
            $permintaan_buku = $this->requestbook_m->get_single_requestbook(array('requestbookID' => $requestbookID));
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
            if (calculate($permintaan_buku)) {
                $this->upload_data['coverphoto'] = array('file_name' => $permintaan_buku->coverphoto);
                return true;
            } else {
                $this->form_validation->set_message("coverphoto_upload", "The %s field is required.");
                return false;
            }
        }
    }

    public function book_coverphoto_upload()
    {
        $requestbookID = htmlentities(escapeString($this->uri->segment(3)));
        $permintaan_buku   = array();
        if ((int) $requestbookID) {
            $permintaan_buku = $this->requestbook_m->get_single_requestbook(array('requestbookID' => $requestbookID));
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
            if (calculate($permintaan_buku)) {
                $this->upload_data['coverphoto'] = array('file_name' => $permintaan_buku->coverphoto);
                return true;
            } else {
                $this->form_validation->set_message("coverphoto_upload", "The %s field is required.");
                return false;
            }
        }
    }

}
