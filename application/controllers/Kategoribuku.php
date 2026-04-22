<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bukucategory extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kategoribuku_m');

        $lang = 'indonesia';
        $this->lang->load('kategori_buku', $lang);
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
		
		$this->data['get_title'] = 'Kelola Kategori Buku | '.$this->data['pengaturan_umum']->sitename;
		
		
        $this->data['kategori_buku'] = $this->kategoribuku_m->get_bookcategory();
        $this->data["subview"]      = "kategori_buku/index";
        $this->load->view('_main_layout', $this->data);
    }

    public function add()
    {
        $this->data['headerassets'] = array(
            'js' => array(
                'assets/custom/js/fileupload.js',
            ),
        );
		
		$this->data['get_title'] = 'Tambah Kategori Buku | '.$this->data['pengaturan_umum']->sitename;
        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->data["subview"] = "kategori_buku/add";
                $this->load->view('_main_layout', $this->data);
            } else {
                $array                    = [];
                $array['nama']            = $this->input->post('nama');
                $array['deskripsi']     = $this->input->post('deskripsi');
                $array['coverphoto']      = $this->upload_data['coverphoto']['file_name'];
                $array['status']          = $this->input->post('status');
                $array['tanggal_dibuat']     = date('Y-m-d H:i:s');
                $array['create_memberID'] = $this->session->userdata('loginmemberID');
                $array['create_roleID']   = $this->session->userdata('id_peran');
                $array['modify_date']     = date('Y-m-d H:i:s');
                $array['modify_memberID'] = $this->session->userdata('loginmemberID');
                $array['modify_roleID']   = $this->session->userdata('id_peran');

                $this->kategoribuku_m->insert_bookcategory($array);
                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('kategori_buku/index'));
            }
        } else {
            $this->data["subview"] = "kategori_buku/add";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function edit()
    {
        $this->data['headerassets'] = array(
            'js' => array(
                'assets/custom/js/fileupload.js',
            ),
        );
		
		$this->data['get_title'] = 'Edit Kategori Buku | '.$this->data['pengaturan_umum']->sitename;
		
        $bookcategoryID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $bookcategoryID) {
            $this->data['kategori_buku'] = $this->kategoribuku_m->get_single_bookcategory(array('bookcategoryID' => $bookcategoryID));
            if (calculate($this->data['kategori_buku'])) {
                if ($_POST) {
                    $rules = $this->rules();
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == false) {
                        $this->data["subview"] = "kategori_buku/edit";
                        $this->load->view('_main_layout', $this->data);
                    } else {
                        $array                    = [];
                        $array['nama']            = $this->input->post('nama');
                        $array['deskripsi']     = $this->input->post('deskripsi');
                        $array['coverphoto']      = $this->upload_data['coverphoto']['file_name'];
                        $array['status']          = $this->input->post('status');
                        $array['modify_date']     = date('Y-m-d H:i:s');
                        $array['modify_memberID'] = $this->session->userdata('loginmemberID');
                        $array['modify_roleID']   = $this->session->userdata('id_peran');

                        $this->kategoribuku_m->update_bookcategory($array, $bookcategoryID);
                        $this->session->set_flashdata('success', 'Success');
                        redirect(base_url('kategori_buku/index'));
                    }
                } else {
                    $this->data["subview"] = "kategori_buku/edit";
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

    public function delete()
    {
        $bookcategoryID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $bookcategoryID) {
            $kategori_buku = $this->kategoribuku_m->get_single_bookcategory(array('bookcategoryID' => $bookcategoryID));
            if (calculate($kategori_buku)) {
                if ($kategori_buku->coverphoto != 'kategori_buku.jpg') {
                    $deleleteimg = FCPATH . '/uploads/kategori_buku/' . $kategori_buku->coverphoto;
                    if (file_exists($deleleteimg)) {
                        unlink($deleleteimg);
                    }
                }

                $this->kategoribuku_m->delete_bookcategory($bookcategoryID);
                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('kategori_buku/index'));
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
                'label' => $this->lang->line('bookcategory_name'),
                'rules' => 'trim|xss_clean|required|max_length[100]|callback_check_unique_bookcategory',
            ),
            array(
                'field' => 'deskripsi',
                'label' => $this->lang->line('bookcategory_description'),
                'rules' => 'trim|xss_clean|required',
            ),
            array(
                'field' => 'coverphoto',
                'label' => $this->lang->line('bookcategory_coverphoto'),
                'rules' => 'trim|xss_clean|max_length[200]|callback_coverphoto_upload',
            ),
            array(
                'field' => 'status',
                'label' => $this->lang->line('bookcategory_status'),
                'rules' => 'trim|xss_clean|required|numeric|required_no_zero',
            ),
        );
        return $rules;
    }

    public function coverphoto_upload()
    {
        $bookcategoryID = htmlentities(escapeString($this->uri->segment(3)));
        $kategori_buku   = array();
        if ((int) $bookcategoryID) {
            $kategori_buku = $this->kategoribuku_m->get_single_bookcategory(array('bookcategoryID' => $bookcategoryID));
        }

        $new_file = "kategori_buku.jpg";
        if ($_FILES["coverphoto"]['nama'] != "") {
            $file_name        = $_FILES["coverphoto"]['nama'];
            $random           = rand(1, 10000000000000000);
            $file_name_rename = hash('sha512', $random . config_item("encryption_key"));
            $explode          = explode('.', $file_name);
            if (calculate($explode) >= 2) {
                $new_file                = $file_name_rename . '.' . end($explode);
                $config['upload_path']   = "./uploads/kategori_buku";
                $config['allowed_types'] = "gif|jpg|png|jpeg";
                $config['file_name']     = $new_file;
                $config['max_size']      = '2048';
                $config['max_width']     = '2000';
                $config['max_height']    = '2000';
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
            if (calculate($kategori_buku)) {
                $this->upload_data['coverphoto'] = array('file_name' => $kategori_buku->coverphoto);
                return true;
            } else {
                $this->upload_data['coverphoto'] = array('file_name' => $new_file);
                return true;
            }
        }
    }

    public function check_unique_bookcategory($name)
    {
        $bookcategoryID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $bookcategoryID) {
            $kategori_buku = $this->kategoribuku_m->get_single_bookcategory(array('nama' => $name, 'bookcategoryID !=' => $bookcategoryID));
            if (calculate($kategori_buku)) {
                $this->form_validation->set_message("check_unique_bookcategory", "The %s is already exits.");
                return false;
            }
            return true;
        } else {
            $kategori_buku = $this->kategoribuku_m->get_single_bookcategory(array('nama' => $name));
            if (calculate($kategori_buku)) {
                $this->form_validation->set_message("check_unique_bookcategory", "The %s is already exits.");
                return false;
            }
            return true;
        }
    }

}
