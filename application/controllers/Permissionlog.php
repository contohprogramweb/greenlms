<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permissionlog extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('permissionlog_m');

        $lang = 'indonesia';
        $this->lang->load('catatan_izin', $lang);
    }

    protected function rules()
    {
        $rules = array(
            array(
                'field' => 'nama',
                'label' => $this->lang->line('permissionlog_name'),
                'rules' => 'trim|xss_clean|required|max_length[60]|callback_check_unique_name',
            ),
            array(
                'field' => 'deskripsi',
                'label' => $this->lang->line('permissionlog_description'),
                'rules' => 'trim|xss_clean|required|max_length[255]',
            ),
            array(
                'field' => 'aktif',
                'label' => $this->lang->line('permissionlog_active'),
                'rules' => 'trim|xss_clean|required|callback_check_active_value',
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
		$this->data['get_title'] = 'Kelola Log Izin | '.$this->data['pengaturan_umum']->sitename;
		
        $this->data['permissionlogs'] = $this->permissionlog_m->get_permissionlog();

        $this->data["subview"] = "catatan_izin/index";
        $this->load->view('_main_layout', $this->data);
    }

    public function add()
    {
		$this->data['get_title'] = 'Tambah Log Izin | '.$this->data['pengaturan_umum']->sitename;
		
        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->data["subview"] = "catatan_izin/add";
                $this->load->view('_main_layout', $this->data);
            } else {
                $array                = [];
                $array['nama']        = $this->input->post('nama');
                $array['deskripsi'] = $this->input->post('deskripsi');
                $array['aktif']      = $this->input->post('aktif');

                $this->permissionlog_m->insert_permissionlog($array);
                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('catatan_izin/index'));
            }
        } else {
            $this->data["subview"] = "catatan_izin/add";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function edit()
    {
        $permissionlogID = escapeString($this->uri->segment('3'));
		$this->data['get_title'] = 'Tambah Log Izin | '.$this->data['pengaturan_umum']->sitename;
		
        if ((int) $permissionlogID) {
            $this->data['catatan_izin'] = $this->permissionlog_m->get_single_permissionlog($permissionlogID);
            if (calculate($this->data['catatan_izin'])) {
                if ($_POST) {
                    $rules = $this->rules();
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == false) {
                        $this->data["subview"] = "catatan_izin/edit";
                        $this->load->view('_main_layout', $this->data);
                    } else {
                        $array['nama']        = $this->input->post('nama');
                        $array['deskripsi'] = $this->input->post('deskripsi');
                        $array['aktif']      = $this->input->post('aktif');

                        $this->permissionlog_m->update_permissionlog($array, $permissionlogID);
                        $this->session->set_flashdata('success', 'Success');
                        redirect(base_url('catatan_izin/index'));
                    }
                } else {
                    $this->data["subview"] = "catatan_izin/edit";
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
        $permissionlogID = escapeString($this->uri->segment('3'));
        if ((int) $permissionlogID) {
            $catatan_izin = $this->permissionlog_m->get_single_permissionlog($permissionlogID);
            if (calculate($catatan_izin)) {
                $this->permissionlog_m->delete_permissionlog($permissionlogID);
                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('catatan_izin/index'));
            } else {
                $this->data["subview"] = "_not_found";
                $this->load->view('_main_layout', $this->data);
            }
        } else {
            $this->data["subview"] = "_not_found";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function check_unique_name($name)
    {
        $permissionlogID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $permissionlogID) {
            $anggota = $this->permissionlog_m->get_single_permissionlog(array('nama' => $name, 'permissionlogID !=' => $permissionlogID));
            if (calculate($anggota)) {
                $this->form_validation->set_message("check_unique_name", "The %s is already exits.");
                return false;
            }
            return true;
        } else {
            $anggota = $this->permissionlog_m->get_single_permissionlog(array('nama' => $name));
            if (calculate($anggota)) {
                $this->form_validation->set_message("check_unique_name", "The %s is already exits.");
                return false;
            }
            return true;
        }
    }

    public function check_active_value($data)
    {
        $array = array('yes', 'no');
        if (in_array($data, $array) == false) {
            $this->form_validation->set_message("check_active_value", "The %s fields only provide yes or no value.");
            return false;
        }
        return true;
    }

}
