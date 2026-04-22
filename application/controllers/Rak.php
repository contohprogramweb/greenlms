<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rak extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Rak_m');

        $lang = 'indonesia';
        $this->lang->load('rak', $lang);
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
		$this->data['get_title'] = 'Kelola Rak | '.$this->data['pengaturan_umum']->sitename;

        $this->data['racks']   = $this->rak_m->get_rack();
        $this->data["subview"] = "rak/index";
        $this->load->view('_main_layout', $this->data);
    }

    public function add()
    {
		$this->data['get_title'] = 'Tambah Rak | '.$this->data['pengaturan_umum']->sitename;
		
        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->data["subview"] = "rak/add";
                $this->load->view('_main_layout', $this->data);
            } else {
                $array                    = [];
                $array['nama']            = $this->input->post('nama');
                $array['deskripsi']     = $this->input->post('deskripsi');
                $array['tanggal_dibuat']     = date('Y-m-d H:i:s');
                $array['create_memberID'] = $this->session->userdata('loginmemberID');
                $array['create_roleID']   = $this->session->userdata('id_peran');
                $array['modify_date']     = date('Y-m-d H:i:s');
                $array['modify_memberID'] = $this->session->userdata('loginmemberID');
                $array['modify_roleID']   = $this->session->userdata('id_peran');

                $this->rak_m->insert_rack($array);
                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('rak/index'));
            }
        } else {
            $this->data["subview"] = "rak/add";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function edit()
    {
        $rackID = htmlentities(escapeString($this->uri->segment(3)));
		$this->data['get_title'] = 'Edit Rak | '.$this->data['pengaturan_umum']->sitename;
		
        if ((int) $rackID) {
            $this->data['rak'] = $this->rak_m->get_single_rack(array('rackID' => $rackID));
            if (calculate($this->data['rak'])) {
                if ($_POST) {
                    $rules = $this->rules();
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == false) {
                        $this->data["subview"] = "rak/edit";
                        $this->load->view('_main_layout', $this->data);
                    } else {
                        $array                    = [];
                        $array['nama']            = $this->input->post('nama');
                        $array['deskripsi']     = $this->input->post('deskripsi');
                        $array['modify_date']     = date('Y-m-d H:i:s');
                        $array['modify_memberID'] = $this->session->userdata('loginmemberID');
                        $array['modify_roleID']   = $this->session->userdata('id_peran');

                        $this->rak_m->update_rack($array, $rackID);
                        $this->session->set_flashdata('success', 'Success');
                        redirect(base_url('rak/index'));
                    }
                } else {
                    $this->data["subview"] = "rak/edit";
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
        $rackID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $rackID) {
            $rak = $this->rak_m->get_single_rack(array('rackID' => $rackID));
            if (calculate($rak)) {
                $this->rak_m->delete_rack($rackID);
                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('rak/index'));
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
                'label' => $this->lang->line('rack_name'),
                'rules' => 'trim|xss_clean|required|max_length[100]|callback_check_unique_rack',
            ),
            array(
                'field' => 'deskripsi',
                'label' => $this->lang->line('rack_description'),
                'rules' => 'trim|xss_clean|required',
            ),
        );
        return $rules;
    }

    public function check_unique_rack($name)
    {
        $rackID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $rackID) {
            $rak = $this->rak_m->get_single_rack(array('nama' => $name, 'rackID !=' => $rackID));
            if (calculate($rak)) {
                $this->form_validation->set_message("check_unique_rack", "The %s is already exits.");
                return false;
            }
            return true;
        } else {
            $rak = $this->rak_m->get_single_rack(array('nama' => $name));
            if (calculate($rak)) {
                $this->form_validation->set_message("check_unique_rack", "The %s is already exits.");
                return false;
            }
            return true;
        }
    }

}
