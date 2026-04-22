<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Toko_buku extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Toko_buku_m');
        $this->load->model('Tokokategoribuku_m');
        $this->load->model('Gambar_toko_buku_m');

        $lang = 'indonesia';
        $this->lang->load('buku_toko', $lang);
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
		
		$this->data['get_title'] = 'Kelola Buku Dijual | '.$this->data['pengaturan_umum']->sitename;
		
		
        $this->data['storebooks'] = $this->toko_buku_m->get_order_by_storebook(['dihapus_pada' => 0]);
        $this->data["subview"]    = "buku_toko/index";
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
                'assets/custom/js/buku_toko.js',
            ),
        );
		
		$this->data['get_title'] = 'Tambah Buku Dijual | '.$this->data['pengaturan_umum']->sitename;
		
        $this->data['storebookcategorys'] = $this->tokokategoribuku_m->get_order_by_storebookcategory(array('status' => 1));
        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->data["subview"] = "buku_toko/add";
                $this->load->view('_main_layout', $this->data);
            } else {
                $array['nama']                = $this->input->post('nama');
                $array['penulis']              = $this->input->post('penulis');
                $array['storebookcategoryID'] = $this->input->post('storebookcategoryID');
                $array['jumlah']            = $this->input->post('jumlah');
                $array['harga']               = $this->input->post('harga');
                $array['codeno']              = $this->input->post('codeno');
                $array['coverphoto']          = $this->upload_data['coverphoto']['file_name'];
                $array['isbnno']              = $this->input->post('isbnno');
                $array['editionnumber']       = $this->input->post('editionnumber');
                $array['editiondate']         = (($this->input->post('editiondate')) ? date('Y-m-d', strtotime($this->input->post('editiondate'))) : null);
                $array['penerbit']           = $this->input->post('penerbit');
                $array['publisheddate']       = (($this->input->post('publisheddate')) ? date('Y-m-d', strtotime($this->input->post('publisheddate'))) : null);
                $array['notes']               = $this->input->post('notes');
                $array['deskripsi']         = $this->input->post('deskripsi');
                $array['tanggal_dibuat']         = date('Y-m-d H:i:s');
                $array['create_memberID']     = $this->session->userdata('loginmemberID');
                $array['modify_date']         = date('Y-m-d H:i:s');
                $array['modify_memberID']     = $this->session->userdata('loginmemberID');

                $this->toko_buku_m->insert_storebook($array);

                if ($_FILES['images']['nama'] != '') {
                    for ($i = 0; $i < count($_FILES['images']['nama']); $i++) {

                        $_FILES['image']['nama']     = $_FILES['images']['nama'][$i];
                        $_FILES['image']['type']     = $_FILES['images']['type'][$i];
                        $_FILES['image']['tmp_name'] = $_FILES['images']['tmp_name'][$i];
                        $_FILES['image']['error']    = $_FILES['images']['error'][$i];
                        $_FILES['image']['size']     = $_FILES['images']['size'][$i];

                        $file_name        = $_FILES["image"]['nama'];
                        $random           = rand(1, 10000000000000000);
                        $file_name_rename = hash('sha512', $random . config_item("encryption_key"));
                        $explode          = explode('.', $file_name);
                        if (calculate($explode) >= 2) {
                            $new_file                = $file_name_rename . '.' . end($explode);
                            $config['upload_path']   = "./uploads/buku_toko";
                            $config['allowed_types'] = "gif|jpg|png|jpeg";
                            $config['file_name']     = $new_file;
                            $config['max_size']      = "2048";
                            $config['max_width']     = "2000";
                            $config['max_height']    = "2000";

                            $this->load->library('upload', $config);
                            if ($this->upload->do_upload("image")) {
                                $image = $this->upload->data();

                            }
                        }
                    }
                }

                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('buku_toko/index'));
            }
        } else {
            $this->data["subview"] = "buku_toko/add";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function edit()
    {
        $storebookID = htmlentities(escapeString($this->uri->segment(3)));
		$this->data['get_title'] = 'Tambah Buku Dijual | '.$this->data['pengaturan_umum']->sitename;
		
		
        if ((int) $storebookID) {
            $buku_toko = $this->toko_buku_m->get_single_storebook(array('storebookID' => $storebookID, 'dihapus_pada' => 0));
            if (calculate($buku_toko)) {
                $this->data['headerassets'] = array(
                    'css'      => array(
                        'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
                    ),
                    'headerjs' => array(
                        'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
                    ),
                    'js'       => array(
                        'assets/custom/js/buku_toko.js',
                        'assets/custom/js/fileupload.js',
                    ),
                );
                $this->data['buku']               = $buku_toko;
                $this->data['storebookcategorys'] = $this->tokokategoribuku_m->get_order_by_storebookcategory(array('status' => 1));
                $this->data['storebookimages']    = $this->gambar_toko_buku_m->get_order_by_storebookimage(['storebookID' => $storebookID]);
                if ($_POST) {
                    $rules = $this->rules();
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == false) {
                        $this->data["subview"] = "buku_toko/edit";
                        $this->load->view('_main_layout', $this->data);
                    } else {
                        $array['nama']                = $this->input->post('nama');
                        $array['penulis']              = $this->input->post('penulis');
                        $array['storebookcategoryID'] = $this->input->post('storebookcategoryID');
                        $array['jumlah']            = $this->input->post('jumlah');
                        $array['harga']               = $this->input->post('harga');
                        $array['codeno']              = $this->input->post('codeno');
                        $array['coverphoto']          = $this->upload_data['coverphoto']['file_name'];
                        $array['isbnno']              = $this->input->post('isbnno');
                        $array['editionnumber']       = $this->input->post('editionnumber');
                        $array['editiondate']         = (($this->input->post('editiondate')) ? date('Y-m-d', strtotime($this->input->post('editiondate'))) : null);
                        $array['penerbit']           = $this->input->post('penerbit');
                        $array['publisheddate']       = (($this->input->post('publisheddate')) ? date('Y-m-d', strtotime($this->input->post('publisheddate'))) : null);
                        $array['notes']               = $this->input->post('notes');
                        $array['deskripsi']         = $this->input->post('deskripsi');
                        $array['modify_date']         = date('Y-m-d H:i:s');
                        $array['modify_memberID']     = $this->session->userdata('loginmemberID');

                        $this->toko_buku_m->update_storebook($array, $storebookID);

                        if ($_FILES['images']['nama'][0] != '') {
                            $this->gambar_toko_buku_m->delete_where(['storebookID' => $storebookID]);

                            for ($i = 0; $i < count($_FILES['images']['nama']); $i++) {

                                $_FILES['image']['nama']     = $_FILES['images']['nama'][$i];
                                $_FILES['image']['type']     = $_FILES['images']['type'][$i];
                                $_FILES['image']['tmp_name'] = $_FILES['images']['tmp_name'][$i];
                                $_FILES['image']['error']    = $_FILES['images']['error'][$i];
                                $_FILES['image']['size']     = $_FILES['images']['size'][$i];

                                $file_name        = $_FILES["image"]['nama'];
                                $random           = rand(1, 10000000000000000);
                                $file_name_rename = hash('sha512', $random . config_item("encryption_key"));
                                $explode          = explode('.', $file_name);
                                if (calculate($explode) >= 2) {
                                    $new_file                = $file_name_rename . '.' . end($explode);
                                    $config['upload_path']   = "./uploads/buku_toko";
                                    $config['allowed_types'] = "gif|jpg|png|jpeg";
                                    $config['file_name']     = $new_file;
                                    $config['max_size']      = "2048";
                                    $config['max_width']     = "2000";
                                    $config['max_height']    = "2000";

                                    $this->load->library('upload', $config);
                                    if ($this->upload->do_upload("image")) {
                                        $image = $this->upload->data();

                                        $retArray['storebookID'] = $storebookID;
                                        $retArray['file_name']   = $image['file_name'];
                                        $retArray['client_name'] = $image['client_name'];
                                        $retArray['meta']        = json_encode($image);

                                        $this->gambar_toko_buku_m->insert_storebookimage($retArray);
                                    }
                                }
                            }
                        }
                        $this->session->set_flashdata('success', 'Success');
                        redirect(base_url('buku_toko/index'));
                    }
                } else {
                    $this->data["subview"] = "buku_toko/edit";
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
        $storebookID = htmlentities(escapeString($this->uri->segment(3)));
		$this->data['get_title'] = 'Lihat Data Buku Dijual | '.$this->data['pengaturan_umum']->sitename;
		
        if ((int) $storebookID) {
            $buku_toko = $this->toko_buku_m->get_single_storebook(array('storebookID' => $storebookID));
            if (calculate($buku_toko)) {
                $this->data['buku_toko'] = $buku_toko;

                $this->data['kategori_buku_toko'] = [];
                if ((int) $buku_toko->storebookcategoryID) {
                    $this->data['kategori_buku_toko'] = $this->tokokategoribuku_m->get_single_storebookcategory(['storebookcategoryID' => $buku_toko->storebookcategoryID]);
                }
                $this->data["subview"] = "buku_toko/view";
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
        $storebookID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $storebookID) {
            $buku_toko = $this->toko_buku_m->get_single_storebook(array('storebookID' => $storebookID, 'deleted_at !=' => 1));
            if (calculate($buku_toko)) {
                $this->toko_buku_m->update_storebook(['dihapus_pada' => 1], $storebookID);
                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('buku_toko/index'));
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
                'label' => $this->lang->line('storebook_name'),
                'rules' => 'trim|xss_clean|required|max_length[100]',
            ),
            array(
                'field' => 'penulis',
                'label' => $this->lang->line('storebook_author'),
                'rules' => 'trim|xss_clean|required|max_length[100]',
            ),
            array(
                'field' => 'jumlah',
                'label' => $this->lang->line('storebook_quantity'),
                'rules' => 'trim|xss_clean|required|numeric',
            ),
            array(
                'field' => 'harga',
                'label' => $this->lang->line('storebook_price'),
                'rules' => 'trim|xss_clean|required|max_length[100]|numeric',
            ),
            array(
                'field' => 'codeno',
                'label' => $this->lang->line('storebook_code_no'),
                'rules' => 'trim|xss_clean|required|max_length[100]',
            ),
            array(
                'field' => 'coverphoto',
                'label' => $this->lang->line('storebook_cover_photo'),
                'rules' => 'trim|xss_clean|callback_coverphoto_upload',
            ),
            array(
                'field' => 'storebookcategoryID',
                'label' => $this->lang->line('storebook_storebook_category'),
                'rules' => 'trim|xss_clean|required|numeric|required_no_zero',
            ),
            array(
                'field' => 'isbnno',
                'label' => $this->lang->line('storebook_isbn_no'),
                'rules' => 'trim|xss_clean|max_length[100]',
            ),
            array(
                'field' => 'rackID',
                'label' => $this->lang->line('storebook_rack'),
                'rules' => 'trim|xss_clean|numeric',
            ),
            array(
                'field' => 'editionnumber',
                'label' => $this->lang->line('storebook_edition_number'),
                'rules' => 'trim|xss_clean|max_length[100]',
            ),
            array(
                'field' => 'editiondate',
                'label' => $this->lang->line('storebook_edition_date'),
                'rules' => 'trim|xss_clean|valid_date',
            ),
            array(
                'field' => 'penerbit',
                'label' => $this->lang->line('storebook_publisher'),
                'rules' => 'trim|xss_clean|max_length[200]',
            ),
            array(
                'field' => 'publisheddate',
                'label' => $this->lang->line('storebook_published_date'),
                'rules' => 'trim|xss_clean|valid_date',
            ),
            array(
                'field' => 'notes',
                'label' => $this->lang->line('storebook_notes'),
                'rules' => 'trim|xss_clean|max_length[1000]',
            ),
        );
        return $rules;
    }

    public function coverphoto_upload()
    {
        $storebookID = htmlentities(escapeString($this->uri->segment(3)));
        $buku_toko   = array();
        if ((int) $storebookID) {
            $buku_toko = $this->toko_buku_m->get_single_storebook(array('storebookID' => $storebookID));
        }

        $new_file = "";
        if ($_FILES["coverphoto"]['nama'] != "") {
            $file_name        = $_FILES["coverphoto"]['nama'];
            $random           = rand(1, 10000000000000000);
            $file_name_rename = hash('sha512', $random . config_item("encryption_key"));
            $explode          = explode('.', $file_name);
            if (calculate($explode) >= 2) {
                $new_file                = $file_name_rename . '.' . end($explode);
                $config['upload_path']   = "./uploads/buku_toko";
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
            if (calculate($buku_toko)) {
                $this->upload_data['coverphoto'] = array('file_name' => $buku_toko->coverphoto);
                return true;
            } else {
                $this->form_validation->set_message("coverphoto_upload", "The %s field is required.");
                return false;
            }
        }
    }

}
