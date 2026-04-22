<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('role_m');
        $this->load->model('login_m');
        $this->load->model('member_m');
        $this->load->model('resetpassword_m');
        $this->load->library('applications');

        $lang = 'indonesia';
        $this->lang->load('login', $lang);
    }

    public function index()
    {
		$this->data['get_title'] = 'Login | '.$this->data['pengaturan_umum']->sitename;
		
        $this->loggedCheck();
        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->data['errors'] = $this->form_validation->error_array();
                $this->load->view('login/index', $this->data);
            } else {
                $array['username_or_email'] = $this->input->post('username_or_email');
                $array['kata_sandi']          = $this->password_hash($this->input->post('kata_sandi'));

                $anggota = $this->login_m->get_single_login_by_username_or_email_and_password($array);
                if (calculate($anggota) && $anggota->status == 1 && $anggota->id_peran != 4) {
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
                    $sessionArray['language']      = 'indonesia';
                    $sessionArray['loggedin']      = true;
					
                    $this->session->set_userdata($sessionArray);
                    redirect(base_url('dashboard/index'));
					
                } elseif (calculate($anggota) && $anggota->status == 2) {
                    $this->data['errors'] = ['pesan' => "You are now blocked. Please contact our admin. Thank You"];
                } elseif (calculate($anggota) && $anggota->status == 0) {
                    $this->data['errors'] = ['pesan' => "You are a new anggota. Please wait until to approved our admin. Thank You"];
                } elseif (calculate($anggota) && $anggota->id_peran == 4) {
                    $this->data['errors'] = ['pesan' => "Customer cann't be login admin panel. Thank You"];
                } else {
                    $this->data['errors'] = ['pesan' => "You provide invalid username/email or password."];
                }
                $this->load->view('login/index', $this->data);
            }
        } else {
            $this->load->view('login/index', $this->data);
        }
    }

    public function reset_kata_sandi()
    {
		$this->data['get_title'] = 'Reset Password | '.$this->data['pengaturan_umum']->sitename;
		
        if ($_POST) {
            $rules = $this->rules_resetpassword();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->data['errors'] = $this->form_validation->error_array();
                $this->load->view('login/reset_kata_sandi', $this->data);
            } else {
                $username_or_email = $this->input->post('username_or_email');
                $anggota            = $this->login_m->get_single_login_check_by_username_or_email($username_or_email);
                if (calculate($anggota)) {
                    $resetArray['nama_pengguna']    = $anggota->nama_pengguna;
                    $resetArray['surel']       = $anggota->surel;
                    $resetArray['kode']        = mt_rand(100000, 999999);
                    $resetArray['id_peran']      = $anggota->id_peran;
                    $resetArray['id_anggota']    = $anggota->id_anggota;
                    $resetArray['tanggal_dibuat'] = date('Y-m-d H:i:s');
                    $resetArray['modify_date'] = date('Y-m-d H:i:s');
                    $this->resetpassword_m->insert_resetpassword($resetArray);

                    $passArray                      = $resetArray;
                    $passArray['anggota']            = $anggota;
                    $passArray['username_or_email'] = $username_or_email;

                    $message = $this->load->view('_template/reset_kata_sandi', $passArray, true);
                    $this->applications->sendmail($anggota->surel, $message, 'Reset Password', $anggota->nama);
                    $this->session->set_flashdata('success', $this->lang->line('login_reset_your_password_checking'));
                    redirect(base_url('login/index'));
                } else {
                    $this->data['errors'] = array('pesan' => $this->lang->line('login_username_or_email_not_found'));
                    $this->load->view('login/reset_kata_sandi', $this->data);
                }
            }
        } else {
            $this->load->view('login/reset_kata_sandi', $this->data);
        }
    }

    public function registermember()
    {
		$this->data['get_title'] = 'Register | '.$this->data['pengaturan_umum']->sitename;
		
		
        if(!$this->data['pengaturan_umum']->registration) {
            $this->session->set_flashdata('error', 'The new anggota registration is currently not allowed.');
            redirect('/');
        }
        if ($_POST) {
            $rules = $this->rules_registermember();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->data['errors'] = $this->form_validation->error_array();
                $this->load->view('login/registermember', $this->data);
            } else {
                $array                = [];
                $array['nama']        = $this->input->post('nama');
                $array['surel']       = $this->input->post('surel');
                $array['telepon']       = $this->input->post('telepon');
                $array['foto']       = $this->upload_data['file']['file_name'];
                $array['id_peran']      = 3;
                $array['status']      = 0;
                $array['nama_pengguna']    = $this->input->post('nama_pengguna');
                $array['kata_sandi']    = $this->password_hash($this->input->post('kata_sandi'));
                $array['tanggal_dibuat'] = date('Y-m-d H:i:s');
                $array['modify_date'] = date('Y-m-d H:i:s');

                $this->login_m->insert_login($array);
                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('login/index'));
            }
        } else {
            $this->load->view('login/registermember', $this->data);
        }
    }

    public function resetpasswordconfirm()
    {
		$this->data['get_title'] = 'Reset Password | '.$this->data['pengaturan_umum']->sitename;
		
        $this->data['username_or_email'] = $_SERVER['QUERY_STRING'];
        if ($_POST) {
            $rules = $this->rules_resetpasswordconfirm();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->data['errors'] = $this->form_validation->error_array();
                $this->load->view('login/resetpasswordconfirm', $this->data);
            } else {
                $anggota = $this->login_m->get_single_login_check_by_username_or_email($this->input->post('username_or_email'));
                if (calculate($anggota)) {
                    $resetArray                      = [];
                    $resetArray['username_or_email'] = $this->input->post('username_or_email');
                    $resetArray['kode']              = $this->input->post('verification_code');

                    $valid_members = $this->resetpassword_m->get_single_resetpassword_by_username_or_email_and_code($resetArray);
                    if (calculate($valid_members)) {
                        $password         = $this->input->post('kata_sandi');
                        $confirm_password = $this->input->post('confirm_password');

                        if ($password == $confirm_password) {
                            $array['kata_sandi']    = $this->password_hash($this->input->post('kata_sandi'));
                            $array['modify_date'] = date('Y-m-d H:i:s');

                            $this->member_m->update_member($array, $anggota->id_anggota);
                            $this->session->set_flashdata('success', 'Your Password Successfully updated.');
                            redirect(base_url('login/index'));
                        } else {
                            $this->session->set_flashdata('error', 'The Password and confirm password not match.');
                            redirect(base_url('login/index'));
                        }
                    } else {
                        $this->session->set_flashdata('error', 'You gived wrong code.');
                        redirect(base_url('login/index'));
                    }
                } else {
                    $this->session->set_flashdata('error', 'The Member not found.');
                    redirect(base_url('login/index'));
                }
            }
        } else {
            $this->load->view('login/resetpasswordconfirm', $this->data);
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_userdata(array('modulepermission_set' => []));
        redirect(base_url('login/index'));
    }

    public function rules()
    {
        $rules = array(
            array(
                'field' => 'username_or_email',
                'label' => $this->lang->line('login_username_or_email'),
                'rules' => 'trim|xss_clean|required|min_length[4]|max_length[60]|callback_valid_username_or_email_check',
            ),
            array(
                'field' => 'kata_sandi',
                'label' => $this->lang->line('login_password'),
                'rules' => 'trim|xss_clean|required|min_length[6]|max_length[128]',
            ),
        );
        return $rules;
    }

    public function rules_resetpassword()
    {
        $rules = array(
            array(
                'field' => 'username_or_email',
                'label' => $this->lang->line('login_username_or_email'),
                'rules' => 'trim|xss_clean|required|min_length[4]|max_length[60]|callback_valid_username_or_email_check',
            ),
        );
        return $rules;
    }

    private function rules_registermember()
    {
        $rules = array(
            array(
                'field' => 'nama',
                'label' => $this->lang->line('login_name'),
                'rules' => 'trim|xss_clean|required|max_length[60]',
            ),
            array(
                'field' => 'surel',
                'label' => $this->lang->line('login_email'),
                'rules' => 'trim|xss_clean|required|max_length[60]|valid_email|callback_check_unique_email',
            ),
            array(
                'field' => 'telepon',
                'label' => $this->lang->line('login_phone'),
                'rules' => 'trim|xss_clean|required|max_length[15]',
            ),
            array(
                'field' => 'foto',
                'label' => $this->lang->line('login_photo'),
                'rules' => 'trim|xss_clean|max_length[200]|callback_photo_upload',
            ),
            array(
                'field' => 'nama_pengguna',
                'label' => $this->lang->line('login_username'),
                'rules' => 'trim|xss_clean|required|min_length[4]|max_length[60]',
            ),
            array(
                'field' => 'kata_sandi',
                'label' => $this->lang->line('login_password'),
                'rules' => 'trim|xss_clean|required|min_length[6]|max_length[128]',
            ),
        );
        return $rules;
    }

    private function rules_resetpasswordconfirm()
    {
        $rules = array(
            array(
                'field' => 'username_or_email',
                'label' => $this->lang->line('login_username_or_email'),
                'rules' => 'trim|xss_clean|required|max_length[60]|callback_valid_username_or_email_check',
            ),
            array(
                'field' => 'verification_code',
                'label' => $this->lang->line('login_verification_code'),
                'rules' => 'trim|xss_clean|required|min_length[4]|max_length[11]',
            ),
            array(
                'field' => 'kata_sandi',
                'label' => $this->lang->line('login_password'),
                'rules' => 'trim|xss_clean|required|min_length[6]|max_length[128]',
            ),
            array(
                'field' => 'confirm_password',
                'label' => $this->lang->line('login_confirm_password'),
                'rules' => 'trim|xss_clean|required|min_length[6]|max_length[128]|matches[password]',
            ),
        );
        return $rules;
    }

    private function loggedCheck()
    {
        $logged = $this->session->userdata('loggedin');
        if ($logged) {
            redirect(base_url('dashboard/index'));
        }
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
                    $this->form_validation->set_message("valid_username_or_email_check", $this->lang->line('login_remove_whitespace_username_email'));
                    return false;
                } elseif (preg_match($username_pattern, $username_or_email)) {
                    return true;
                } else {
                    $this->form_validation->set_message("valid_username_or_email_check", $this->lang->line('login_provide_username_email'));
                    return false;
                }
            }
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

    public function check_unique_email($email)
    {
        $anggota = $this->login_m->get_single_login(array('surel' => $email));
        if (calculate($anggota)) {
            $this->form_validation->set_message("check_unique_email", $this->lang->line('login_unique_email_activate'));
            return false;
        }
        return true;
    }

}
