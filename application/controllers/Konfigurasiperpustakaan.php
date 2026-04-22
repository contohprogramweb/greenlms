<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Konfigurasiperpustakaan extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Peran_m');
        $this->load->model('Konfigurasiperpustakaan_m');

        $lang = 'indonesia';
        $this->lang->load('konfigurasi_perpustakaan', $lang);
    }

    public function index()
    {
        $this->data['roles']        = pluck($this->peran_m->get_role(), 'peran', 'id_peran');
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
		
		$this->data['get_title'] = 'Pengaturan Perpustakaan | '.$this->data['pengaturan_umum']->sitename;
		
        $this->data['libraryconfigures'] = $this->konfigurasiperpustakaan_m->get_libraryconfigure();
        $this->data["subview"]           = "konfigurasi_perpustakaan/index";
        $this->load->view('_main_layout', $this->data);
    }

    public function add()
    {
        $this->data['roles'] = $this->peran_m->get_role();
		$this->data['get_title'] = 'Tambah Pengaturan Perpustakaan | '.$this->data['pengaturan_umum']->sitename;
		
        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->data["subview"] = "konfigurasi_perpustakaan/add";
                $this->load->view('_main_layout', $this->data);
            } else {
                $array                           = [];
                $array['id_peran']                 = $this->input->post('id_peran');
                $array['max_issue_book']         = $this->input->post('max_issue_book');
                $array['max_renewed_limit']      = $this->input->post('max_renewed_limit');
                $array['per_renew_limit_day']    = $this->input->post('per_renew_limit_day');
                $array['book_fine_per_day']      = $this->input->post('book_fine_per_day');
                $array['issue_off_limit_amount'] = $this->input->post('issue_off_limit_amount');
                $this->konfigurasiperpustakaan_m->insert_libraryconfigure($array);

                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('konfigurasi_perpustakaan/index'));
            }
        } else {
            $this->data["subview"] = "konfigurasi_perpustakaan/add";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function edit()
    {
        $libraryconfigureID = htmlentities(escapeString($this->uri->segment(3)));
		$this->data['get_title'] = 'Edit Pengaturan Perpustakaan | '.$this->data['pengaturan_umum']->sitename;
		
        if ((int) $libraryconfigureID) {
            $this->data['konfigurasi_perpustakaan'] = $this->konfigurasiperpustakaan_m->get_single_libraryconfigure(array('libraryconfigureID' => $libraryconfigureID));
            if (calculate($this->data['konfigurasi_perpustakaan'])) {
                $this->data['roles'] = $this->peran_m->get_role();
                if ($_POST) {
                    $rules = $this->rules();
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == false) {
                        $this->data["subview"] = "konfigurasi_perpustakaan/edit";
                        $this->load->view('_main_layout', $this->data);
                    } else {
                        $array                           = [];
                        $array['id_peran']                 = $this->input->post('id_peran');
                        $array['max_issue_book']         = $this->input->post('max_issue_book');
                        $array['max_renewed_limit']      = $this->input->post('max_renewed_limit');
                        $array['per_renew_limit_day']    = $this->input->post('per_renew_limit_day');
                        $array['book_fine_per_day']      = $this->input->post('book_fine_per_day');
                        $array['issue_off_limit_amount'] = $this->input->post('issue_off_limit_amount');
                        $this->konfigurasiperpustakaan_m->update_libraryconfigure($array, $libraryconfigureID);

                        $this->session->set_flashdata('success', 'Success');
                        redirect(base_url('konfigurasi_perpustakaan/index'));
                    }
                } else {
                    $this->data["subview"] = "konfigurasi_perpustakaan/edit";
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
        $libraryconfigureID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $libraryconfigureID) {
            $konfigurasi_perpustakaan = $this->konfigurasiperpustakaan_m->get_single_libraryconfigure(array('libraryconfigureID' => $libraryconfigureID));
            if (calculate($konfigurasi_perpustakaan)) {
                $this->konfigurasiperpustakaan_m->delete_libraryconfigure($libraryconfigureID);
                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('konfigurasi_perpustakaan/index'));
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
                'field' => 'id_peran',
                'label' => $this->lang->line('libraryconfigure_role'),
                'rules' => 'trim|xss_clean|required|numeric|required_no_zero|callback_check_unique_role',
            ),
            array(
                'field' => 'max_issue_book',
                'label' => $this->lang->line('libraryconfigure_max_issue_book'),
                'rules' => 'trim|xss_clean|required|integer',
            ),
            array(
                'field' => 'max_renewed_limit',
                'label' => $this->lang->line('libraryconfigure_max_renewed_limit'),
                'rules' => 'trim|xss_clean|required|integer',
            ),
            array(
                'field' => 'per_renew_limit_day',
                'label' => $this->lang->line('libraryconfigure_per_renew_limit_day'),
                'rules' => 'trim|xss_clean|required|integer',
            ),
            array(
                'field' => 'book_fine_per_day',
                'label' => $this->lang->line('libraryconfigure_book_fine_per_day'),
                'rules' => 'trim|xss_clean|required|numeric',
            ),
            array(
                'field' => 'issue_off_limit_amount',
                'label' => $this->lang->line('libraryconfigure_issue_off_limit_amount'),
                'rules' => 'trim|xss_clean|required|numeric',
            ),
        );
        return $rules;
    }

    public function check_unique_role($roleID)
    {
        $libraryconfigureID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $libraryconfigureID) {
            $konfigurasi_perpustakaan = $this->konfigurasiperpustakaan_m->get_single_libraryconfigure(array('id_peran' => $roleID, 'libraryconfigureID !=' => $libraryconfigureID));
            if (calculate($konfigurasi_perpustakaan)) {
                $this->form_validation->set_message("check_unique_role", "The %s is already exits.");
                return false;
            }
            return true;
        } else {
            $konfigurasi_perpustakaan = $this->konfigurasiperpustakaan_m->get_single_libraryconfigure(array('id_peran' => $roleID));
            if (calculate($konfigurasi_perpustakaan)) {
                $this->form_validation->set_message("check_unique_role", "The %s is already exits.");
                return false;
            }
            return true;
        }
    }

}
