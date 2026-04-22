<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Myaccount extends Frontend_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ebook_m');
        $this->load->model('order_m');
        $this->load->model('storebook_m');
        $this->load->model('login_m');
        $this->load->model('member_m');
        $this->load->model('role_m');
        $this->load->model('orderitem_m');

        $lang = 'indonesia';
        $this->lang->load('frontend', $lang);
    }

    //Account registration
    public function index()
    {
        $memberID              = $this->session->userdata('loginmemberID');
		$this->data['get_title'] = 'My Account | '.$this->data['pengaturan_umum']->sitename;
        $this->data['anggota']  = $this->member_m->get_single_member(array('id_anggota' => $memberID));
        $this->data['peran']    = $this->role_m->get_single_role(array('id_peran' => $this->data['anggota']->id_peran));
        $this->data["subview"] = "frontend/myaccount";
        $this->load->view('_frontend_layout', $this->data);
    }

    public function login()
    {
		$this->data['get_title'] = 'Login | '.$this->data['pengaturan_umum']->sitename;
		
        $this->loggedCheck();
        if ($_POST) {
            $rules = $this->login_rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {

                $this->data['errors']  = $this->form_validation->error_array();
                $this->data["subview"] = "frontend/login";
                $this->load->view('_frontend_layout', $this->data);
            } else {
                $array['username_or_email'] = $this->input->post('username_or_email');
                $array['kata_sandi']          = $this->password_hash($this->input->post('kata_sandi'));

                $anggota = $this->login_m->get_single_login_by_username_or_email_and_password($array);
                if (calculate($anggota) && $anggota->status == 1) {
                    $peran                          = $this->role_m->get_single_role(array('id_peran' => $anggota->id_peran));
                    $sessionArray                  = [];
                    $sessionArray['nama']          = $anggota->nama;
                    $sessionArray['nama_pengguna']      = $anggota->nama_pengguna;
                    $sessionArray['id_peran']        = $anggota->id_peran;
                    $sessionArray['peran']          = calculate($peran) ? $peran->peran : '';
                    $sessionArray['loginmemberID'] = $anggota->id_anggota;
                    $sessionArray['surel']         = $anggota->surel;
                    $sessionArray['foto']         = $anggota->foto;
                    $sessionArray['joinningdate']  = $anggota->joinningdate;
                    $sessionArray['language']      = 'english';
                    $sessionArray['loggedin']      = true;
                    $this->session->set_userdata($sessionArray);

                    $this->session->set_flashdata('success', $this->lang->line('frontend_you_login_successfully'));
                    redirect(base_url('myaccount/index'));
                } elseif (calculate($anggota) && $anggota->status == 2) {
                    $this->data['errors'] = ['pesan' => "You are now blocked. Please contact our admin. Thank You"];
                } elseif (calculate($anggota) && $anggota->status == 0) {
                    $this->data['errors'] = ['pesan' => "You are a new anggota. Please wait until to approved our admin. Thank You"];
                } else {
                    $this->data['errors'] = ['pesan' => "You provide invalid username/email or password."];
                }
                $this->data["subview"] = "frontend/login";
                $this->load->view('_frontend_layout', $this->data);
            }
        } else {
            $this->data["subview"] = "frontend/login";
            $this->load->view('_frontend_layout', $this->data);
        }
    }

    public function login_rules()
    {
        $rules = array(
            array(
                'field' => 'username_or_email',
                'label' => $this->lang->line('frontend_username_or_email'),
                'rules' => 'trim|xss_clean|required|min_length[4]|max_length[60]|callback_valid_username_or_email_check',
            ),
            array(
                'field' => 'kata_sandi',
                'label' => $this->lang->line('frontend_password'),
                'rules' => 'trim|xss_clean|required|min_length[6]|max_length[128]',
            ),
        );
        return $rules;
    }

    public function valid_username_or_email_check($username_or_email)
    {
        if ($username_or_email) {
            $email_pattern    = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i";
            $username_pattern = "/^[a-z\d]{4,20}$/";
            if (preg_match($email_pattern, $username_or_email)) {
                return true;
            } else {
                $check = calculate(explode(' ', $username_or_email));
                if ($check > 1) {
                    $this->form_validation->set_message("valid_username_or_email_check", $this->lang->line('frontend_remove_whitespace_username_email'));
                    return false;
                } elseif (preg_match($username_pattern, $username_or_email)) {
                    return true;
                } else {
                    $this->form_validation->set_message("valid_username_or_email_check", $this->lang->line('frontend_provide_username_email'));
                    return false;
                }
            }
        }
        return true;
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_userdata(array('modulepermission_set' => []));
        redirect(base_url('myaccount/login'));
    }

    public function register()
    {
		$this->data['get_title'] = 'Register | '.$this->data['pengaturan_umum']->sitename;
		
        if (!$this->data['pengaturan_umum']->registration) {
            $this->session->set_flashdata('error', 'The new user registration is currently not allowed.');
            redirect('/');
        }
        if ($_POST) {
            $rules = $this->rules_registermember();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->data['errors']  = $this->form_validation->error_array();
                $this->data["subview"] = "frontend/register";
                $this->load->view('_frontend_layout', $this->data);
            } else {
                $array['nama']        = $this->input->post('nama');
                $array['surel']       = $this->input->post('surel');
                $array['telepon']       = $this->input->post('telepon');
                $array['foto']       = $this->upload_data['file']['file_name'];
                $array['id_peran']      = 4;
                $array['status']      = 0;
                $array['nama_pengguna']    = $this->input->post('nama_pengguna');
                $array['kata_sandi']    = $this->password_hash($this->input->post('kata_sandi'));
                $array['tanggal_dibuat'] = date('Y-m-d H:i:s');
                $array['modify_date'] = date('Y-m-d H:i:s');

                $this->login_m->insert_login($array);
                $this->session->set_flashdata('success', 'You successfully register your account.');
                redirect(base_url('frontend/index'));
            }
        } else {
            $this->data["subview"] = "frontend/register";
            $this->load->view('_frontend_layout', $this->data);
        }
    }

    public function rules_registermember()
    {
        $rules = array(
            array(
                'field' => 'nama',
                'label' => $this->lang->line('frontend_name'),
                'rules' => 'trim|xss_clean|required|max_length[60]',
            ),
            array(
                'field' => 'surel',
                'label' => $this->lang->line('frontend_email'),
                'rules' => 'trim|xss_clean|required|max_length[60]|valid_email|callback_check_unique_email',
            ),
            array(
                'field' => 'telepon',
                'label' => $this->lang->line('frontend_phone'),
                'rules' => 'trim|xss_clean|required|max_length[15]',
            ),
            array(
                'field' => 'foto',
                'label' => $this->lang->line('frontend_photo'),
                'rules' => 'trim|xss_clean|max_length[200]|callback_photo_upload',
            ),
            array(
                'field' => 'nama_pengguna',
                'label' => $this->lang->line('frontend_username'),
                'rules' => 'trim|xss_clean|required|min_length[4]|max_length[60]',
            ),
            array(
                'field' => 'kata_sandi',
                'label' => $this->lang->line('frontend_password'),
                'rules' => 'trim|xss_clean|required|min_length[6]|max_length[128]',
            ),
        );
        return $rules;
    }

    public function check_unique_email($email)
    {
        $anggota = $this->login_m->get_single_login(array('surel' => $email));
        if (calculate($anggota)) {
            $this->form_validation->set_message("check_unique_email", $this->lang->line('frontend_unique_email_activate'));
            return false;
        }
        return true;
    }

    public function photo_upload()
    {
        $new_file = "default.png";
        if ($_FILES['foto']['nama'] != "") {
            $file_name   = $_FILES['foto']['nama'];
            $random      = rand(1, 10000000000000000);
            $file_rename = hash('sha512', $random . $this->input->post('nama_pengguna') . config_item("encryption_key"));
            $explode     = explode('.', $file_name);
            if (calculate($explode) >= 2) {
                $new_file                = $file_rename . '.' . end($explode);
                $config['upload_path']   = "./uploads/anggota";
                $config['allowed_types'] = "gif|jpg|png|jpeg|jpeg";
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
                $this->form_validation->set_message("photo_upload", "Please upload valid supported format file.");
                return false;
            }
        } else {
            $this->form_validation->set_message("photo_upload", "Please upload any supported format file.");
            return false;
        }
    }

    //Order check
    public function order()
    {
		$this->data['get_title'] = 'My Order | '.$this->data['pengaturan_umum']->sitename;
		
        $this->data['pesanan']  = $this->order_m->get_order_by_order(['id_anggota' => $this->session->userdata('loginmemberID')]);
        $this->data["subview"] = "frontend/order";
        $this->load->view('_frontend_layout', $this->data);
    }

    public function orderview($orderID)
    {
		$this->data['get_title'] = 'Detail Data Pesanan | '.$this->data['pengaturan_umum']->sitename;
		
        $this->data['order']      = $this->order_m->get_single_order(['id_anggota' => $this->session->userdata('loginmemberID'), 'id_pesanan' => $orderID]);
        $this->data['anggota']     = $this->member_m->get_single_member(['id_anggota' => $this->session->userdata('loginmemberID')]);
        $this->data['item_pesanan'] = $this->orderitem_m->get_order_by_orderitem_with_storebook(['id_pesanan' => $orderID]);
        $this->data["subview"]    = "frontend/orderview";
        $this->load->view('_frontend_layout', $this->data);
    }
}


