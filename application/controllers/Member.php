<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Member extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('role_m');
        $this->load->model('member_m');
        $this->load->model('bookcategory_m');
        $this->load->model('book_m');
        $this->load->model('bookissue_m');

        $lang = 'indonesia';
        $this->lang->load('anggota', $lang);
    }

    public function index()
    {
        $setroleID = htmlentities(escapeString($this->uri->segment(3)));
        $setroleID = $setroleID ? $setroleID : 3;

        $this->data['headerassets'] = array(
            'css'      => array(
                'assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css',
                'assets/custom/css/hidetable.css',
            ),
            'headerjs' => array(
                'assets/plugins/datatables.net/js/jquery.dataTables.min.js',
                'assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js',
                'assets/custom/js/anggota.js',
            ),
        );
		
		$this->data['get_title'] = 'Kelola Anggota | '.$this->data['pengaturan_umum']->sitename;
		
		
        $this->data['members']   = $this->member_m->get_order_by_member(['dihapus_pada' => 0, 'id_peran' => $setroleID]);
        $this->data['roles']     = pluck($this->role_m->get_role(), 'peran', 'id_peran');
        $this->data['setroleID'] = $setroleID;
        $this->data["subview"]   = "anggota/index";
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
                'assets/custom/js/anggota.js',
                'assets/custom/js/fileupload.js',
            ),
        );
		
		$this->data['get_title'] = 'Tambah Anggota | '.$this->data['pengaturan_umum']->sitename;
		
        $this->data['roles'] = $this->role_m->get_role(array('id_peran', 'peran'));
        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->data["subview"] = "anggota/add";
                $this->load->view('_main_layout', $this->data);
            } else {
                $array                    = [];
                $array['nama']            = $this->input->post('nama');
                $array['jenis_kelamin']          = $this->input->post('jenis_kelamin');
                $array['agama']        = $this->input->post('agama');
                $array['surel']           = $this->input->post('surel');
                $array['telepon']           = $this->input->post('telepon');
                $array['bloodgroup']      = $this->input->post('bloodgroup');
                $array['alamat']         = $this->input->post('alamat');
                $array['dateofbirth']     = date('Y-m-d', strtotime($this->input->post('dateofbirth')));
                $array['joinningdate']    = date('Y-m-d', strtotime($this->input->post('joinningdate')));
                $array['foto']           = $this->upload_data['file']['file_name'];
                $array['id_peran']          = $this->input->post('id_peran');
                $array['status']          = $this->input->post('status');
                $array['nama_pengguna']        = $this->input->post('nama_pengguna');
                $array['kata_sandi']        = $this->password_hash($this->input->post('kata_sandi'));
                $array['tanggal_dibuat']     = date('Y-m-d H:i:s');
                $array['create_memberID'] = $this->session->userdata('loginmemberID');
                $array['create_roleID']   = $this->session->userdata('id_peran');
                $array['modify_date']     = date('Y-m-d H:i:s');
                $array['modify_memberID'] = $this->session->userdata('loginmemberID');
                $array['modify_roleID']   = $this->session->userdata('id_peran');

                $this->member_m->insert_member($array);
                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('anggota/index'));
            }
        } else {
            $this->data["subview"] = "anggota/add";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function edit()
    {
        $memberID = htmlentities(escapeString($this->uri->segment(3)));
		$this->data['get_title'] = 'Edit Anggota | '.$this->data['pengaturan_umum']->sitename;
		
        if ((int) $memberID) {
            $anggota = $this->member_m->get_single_member(array('id_anggota' => $memberID, 'dihapus_pada' => 0));
            if (calculate($anggota)) {
                $this->data['headerassets'] = array(
                    'css'      => array(
                        'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
                    ),
                    'headerjs' => array(
                        'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
                    ),
                    'js'       => array(
                        'assets/custom/js/anggota.js',
                        'assets/custom/js/fileupload.js',
                    ),
                );
                $this->data['anggota'] = $anggota;
                $this->data['roles']  = $this->role_m->get_role(array('id_peran', 'peran'));
                if ($_POST) {
                    $rules = $this->rules();
                    unset($rules['12']);
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == false) {
                        $this->data["subview"] = "anggota/edit";
                        $this->load->view('_main_layout', $this->data);
                    } else {
                        $array                 = [];
                        $array['nama']         = $this->input->post('nama');
                        $array['dateofbirth']  = date('Y-m-d', strtotime($this->input->post('dateofbirth')));
                        $array['jenis_kelamin']       = $this->input->post('jenis_kelamin');
                        $array['agama']     = $this->input->post('agama');
                        $array['surel']        = $this->input->post('surel');
                        $array['telepon']        = $this->input->post('telepon');
                        $array['bloodgroup']   = $this->input->post('bloodgroup');
                        $array['alamat']      = $this->input->post('alamat');
                        $array['joinningdate'] = date('Y-m-d', strtotime($this->input->post('joinningdate')));
                        $array['foto']        = $this->upload_data['file']['file_name'];
                        $array['id_peran']       = $this->input->post('id_peran');
                        $array['status']       = $this->input->post('status');
                        $array['nama_pengguna']     = $this->input->post('nama_pengguna');
                        if ($this->input->post('kata_sandi') != '') {
                            $array['kata_sandi'] = $this->password_hash($this->input->post('kata_sandi'));
                        }
                        $array['modify_date']     = date('Y-m-d H:i:s');
                        $array['modify_memberID'] = $this->session->userdata('loginmemberID');
                        $array['modify_roleID']   = $this->session->userdata('id_peran');

                        $this->member_m->update_member($array, $memberID);
                        $this->session->set_flashdata('success', 'Success');
                        redirect(base_url('anggota/index'));
                    }
                } else {
                    $this->data["subview"] = "anggota/edit";
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
        $memberID = htmlentities(escapeString($this->uri->segment(3)));
		
		$this->data['get_title'] = 'Lihat Data Anggota | '.$this->data['pengaturan_umum']->sitename;
		
        if ((int) $memberID) {
            $anggota = $this->member_m->get_single_member(array('id_anggota' => $memberID));
            if (calculate($anggota)) {
                $this->data['anggota']       = $anggota;
                $this->data['kategori_buku'] = pluck($this->bookcategory_m->get_bookcategory(), 'nama', 'bookcategoryID');
                $this->data['buku']         = pluck($this->book_m->get_book(), 'nama', 'id_buku');
                $this->data['bookissues']   = $this->bookissue_m->get_order_by_bookissue(['dihapus_pada' => 0, 'id_anggota' => $memberID]);
                $this->data['peran']         = $this->role_m->get_single_role(array('id_peran' => $anggota->id_peran));
                $this->data["subview"]      = "anggota/view";
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
        $memberID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $memberID) {
            $anggota = $this->member_m->get_single_member(array('id_anggota' => $memberID));
            if (calculate($anggota)) {
                $this->member_m->update_member(['dihapus_pada' => 1], $memberID);
                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('anggota/index'));
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
                'label' => $this->lang->line('member_name'),
                'rules' => 'trim|xss_clean|required|max_length[60]',
            ),
            array(
                'field' => 'dateofbirth',
                'label' => $this->lang->line('member_date_of_birth'),
                'rules' => 'trim|xss_clean|required|valid_date',
            ),
            array(
                'field' => 'jenis_kelamin',
                'label' => $this->lang->line('member_gender'),
                'rules' => 'trim|xss_clean|required|required_no_zero',
            ),
            array(
                'field' => 'agama',
                'label' => $this->lang->line('member_religion'),
                'rules' => 'trim|xss_clean|required|max_length[30]',
            ),
            array(
                'field' => 'surel',
                'label' => $this->lang->line('member_email'),
                'rules' => 'trim|xss_clean|required|max_length[60]|valid_email|callback_check_unique_email',
            ),
            array(
                'field' => 'telepon',
                'label' => $this->lang->line('member_phone'),
                'rules' => 'trim|xss_clean|required|max_length[15]',
            ),
            array(
                'field' => 'bloodgroup',
                'label' => $this->lang->line('member_blood_group'),
                'rules' => 'trim|xss_clean|max_length[15]|required_no_zero',
            ),
            array(
                'field' => 'alamat',
                'label' => $this->lang->line('member_address'),
                'rules' => 'trim|xss_clean|required',
            ),
            array(
                'field' => 'joinningdate',
                'label' => $this->lang->line('member_joinning_date'),
                'rules' => 'trim|xss_clean|required|valid_date',
            ),
            array(
                'field' => 'foto',
                'label' => $this->lang->line('member_photo'),
                'rules' => 'trim|xss_clean|max_length[200]|callback_photo_upload',
            ),
            array(
                'field' => 'status',
                'label' => $this->lang->line('member_status'),
                'rules' => 'trim|xss_clean|required|numeric|required_no_zero',
            ),
            array(
                'field' => 'id_peran',
                'label' => $this->lang->line('member_role'),
                'rules' => 'trim|xss_clean|required|numeric|required_no_zero',
            ),
            array(
                'field' => 'nama_pengguna',
                'label' => $this->lang->line('member_username'),
                'rules' => 'trim|xss_clean|required|min_length[4]|max_length[60]|valid_username|callback_check_unique_username',
            ),
            array(
                'field' => 'kata_sandi',
                'label' => $this->lang->line('member_password'),
                'rules' => 'trim|xss_clean|max_length[128]|callback_password_required_check',
            ),
        );
        return $rules;
    }

    public function photo_upload()
    {
        $memberID = htmlentities(escapeString($this->uri->segment(3)));
        $anggota   = array();
        if ((int) $memberID) {
            $anggota = $this->member_m->get_single_member(array('id_anggota' => $memberID));
        }

        $new_file = "default.png";
        if ($_FILES['foto']['nama'] != "") {
            $file_name        = $_FILES['foto']['nama'];
            $random           = rand(1, 10000000000000000);
            $file_name_rename = hash('sha512', $random . $this->input->post('nama_pengguna') . config_item("encryption_key"));
            $explode          = explode('.', $file_name);
            if (calculate($explode) >= 2) {
                $new_file                = $file_name_rename . '.' . end($explode);
                $config['upload_path']   = "./uploads/anggota";
                $config['allowed_types'] = "gif|jpg|png|jpeg";
                $config['file_name']     = $new_file;
                $config['max_size']      = '2048';
                $config['max_width']     = '2000';
                $config['max_height']    = '2000';
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('foto')) {
                    $this->form_validation->set_message("photo_upload", $this->upload->display_errors());
                    return false;
                } else {
                    $this->upload_data['file'] = $this->upload->data();
                    return true;
                }
            } else {
                $this->form_validation->set_message("photo_upload", "Invalid file");
                return false;
            }
        } else {
            if (calculate($anggota)) {
                $this->upload_data['file'] = array('file_name' => $anggota->foto);
                return true;
            } else {
                $this->upload_data['file'] = array('file_name' => $new_file);
                return true;
            }
        }
    }

    public function check_unique_email($email)
    {
        $memberID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $memberID) {
            $anggota = $this->member_m->get_single_member(array('surel' => $email, 'memberID !=' => $memberID));
            if (calculate($anggota)) {
                $this->form_validation->set_message("check_unique_email", "The %s is already exits.");
                return false;
            }
            return true;
        } else {
            $anggota = $this->member_m->get_single_member(array('surel' => $email));
            if (calculate($anggota)) {
                $this->form_validation->set_message("check_unique_email", "The %s is already exits.");
                return false;
            }
            return true;
        }
    }

    public function check_unique_username($username)
    {
        $memberID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $memberID) {
            $anggota = $this->member_m->get_single_member(array('nama_pengguna' => $username, 'memberID !=' => $memberID));
            if (calculate($anggota)) {
                $this->form_validation->set_message("check_unique_username", "The %s is already exits.");
                return false;
            }
            return true;
        } else {
            $anggota = $this->member_m->get_single_member(array('nama_pengguna' => $username));
            if (calculate($anggota)) {
                $this->form_validation->set_message("check_unique_username", "The %s is already exits.");
                return false;
            }
            return true;
        }
    }

    public function password_required_check($password)
    {
        $memberID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $memberID) {
            return true;
        } else {
            if ($password == '') {
                $this->form_validation->set_message("password_required_check", "The %s is already exits.");
                return false;
            }
            return true;
        }
    }

}
