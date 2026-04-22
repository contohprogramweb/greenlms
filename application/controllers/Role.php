<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role extends Admin_Controller
{
    public $notdeleteArray = [1, 2, 3];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('role_m');

        $lang = 'indonesia';
        $this->lang->load('peran', $lang);
    }

    protected function rules()
    {
        $rules = array(
            array(
                'field' => 'peran',
                'label' => $this->lang->line('role_role'),
                'rules' => 'trim|xss_clean|required|max_length[30]|callback_check_unique_role',
            ),
        );
        return $rules;
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
		$this->data['get_title'] = 'Kelola Hak Akses | '.$this->data['pengaturan_umum']->sitename;
		
        $this->data['roles'] = $this->role_m->get_role(array('id_peran', 'peran', 'tanggal_dibuat'));

        $this->data["subview"] = "peran/index";
        $this->load->view('_main_layout', $this->data);
    }

    public function add()
    {
		$this->data['get_title'] = 'Tambah Hak Akses | '.$this->data['pengaturan_umum']->sitename;
		
        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->data["subview"] = "peran/add";
                $this->load->view('_main_layout', $this->data);
            } else {
                $array                    = [];
                $array['peran']            = $this->input->post('peran');
                $array['tanggal_dibuat']     = date('Y-m-d H:i:s');
                $array['create_memberID'] = $this->session->userdata('loginmemberID');
                $array['create_roleID']   = $this->session->userdata('id_peran');
                $array['modify_date']     = date('Y-m-d H:i:s');
                $array['modify_memberID'] = $this->session->userdata('loginmemberID');
                $array['modify_roleID']   = $this->session->userdata('id_peran');

                $this->role_m->insert_role($array);
                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('peran/index'));
            }
        } else {
            $this->data["subview"] = "peran/add";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function edit()
    {
		$this->data['get_title'] = 'Edit Hak Akses | '.$this->data['pengaturan_umum']->sitename;
		
        $roleID = escapeString($this->uri->segment('3'));
        if ((int) $roleID) {
            $this->data['peran'] = $this->role_m->get_single_role($roleID);
            if (calculate($this->data['peran'])) {
                if ($_POST) {
                    $rules = $this->rules();
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == false) {
                        $this->data["subview"] = "peran/edit";
                        $this->load->view('_main_layout', $this->data);
                    } else {
                        $array                    = [];
                        $array['peran']            = $this->input->post('peran');
                        $array['modify_date']     = date('Y-m-d H:i:s');
                        $array['modify_memberID'] = $this->session->userdata('loginmemberID');
                        $array['modify_roleID']   = $this->session->userdata('id_peran');

                        $this->role_m->update_role($array, $roleID);
                        $this->session->set_flashdata('success', 'Success');
                        redirect(base_url('peran/index'));
                    }
                } else {
                    $this->data["subview"] = "peran/edit";
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
        $roleID = escapeString($this->uri->segment('3'));
        if ((int) $roleID) {
            $peran = $this->role_m->get_single_role(array('id_peran' => $roleID));
            if (calculate($peran)) {
                if (!in_array($roleID, $this->notdeleteArray)) {
                    $this->role_m->delete_role($roleID);
                    $this->session->set_flashdata('success', 'Success');
                } else {
                    $this->session->set_flashdata('error', 'The Role Can\'t delete.');
                }
                redirect(base_url('peran/index'));
            } else {
                $this->data["subview"] = "_not_found";
                $this->load->view('_main_layout', $this->data);
            }
        } else {
            $this->data["subview"] = "_not_found";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function check_unique_role($peran)
    {
        $roleID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $roleID) {
            $peran = $this->role_m->get_single_role(array('peran' => $peran, 'roleID !=' => $roleID));
            if (calculate($peran)) {
                $this->form_validation->set_message("check_unique_role", "The %s is already exits.");
                return false;
            }
            return true;
        } else {
            $peran = $this->role_m->get_single_role(array('peran' => $peran));
            if (calculate($peran)) {
                $this->form_validation->set_message("check_unique_role", "The %s is already exits.");
                return false;
            }
            return true;
        }
    }

}
