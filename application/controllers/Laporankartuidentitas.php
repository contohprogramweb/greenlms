<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporankartuidentitas extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Peran_m');
        $this->load->model('Anggota_m');
        $this->load->library('barcode');
        $this->load->library('pdf');

        $lang = 'indonesia';
        $this->lang->load('idcardreport', $lang);
    }

    public function index()
    {
        $this->data['headerassets'] = array(
            'js' => array(
                'assets/custom/js/idcardreport.js',
            ),
        );
		
		$this->data['get_title'] = 'Laporan Kartu Anggota | '.$this->data['pengaturan_umum']->sitename;
		
		
        $this->data['flag']     = 0;
        $this->data['type']     = 0;
        $this->data['id_peran']   = 0;
        $this->data['id_anggota'] = 0;
        $this->data['members']  = [];
        $this->data['roles']    = $this->peran_m->get_role();
        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $message = implode('<br/>', $this->form_validation->error_array());
                $this->session->set_flashdata('error', $message);
                $this->data["subview"] = "laporan/idcard/index";
                $this->load->view('_main_layout', $this->data);
            } else {
                $roleID   = $this->input->post('id_peran');
                $memberID = $this->input->post('id_anggota');
                $type     = $this->input->post('type');

                $queryArray['id_peran'] = $roleID;
                if ((int) $memberID) {
                    $queryArray['id_anggota'] = $memberID;
                }
                $queryArray['status']     = 1;
                $queryArray['dihapus_pada'] = 0;
                $members                  = $this->anggota_m->get_order_by_member($queryArray);
                if ($type == 2) {
                    $this->generatebarcode($members);
                }

                $this->data['flag']     = 1;
                $this->data['type']     = $type;
                $this->data['id_peran']   = $roleID;
                $this->data['id_anggota'] = $memberID;
                $this->data['members']  = $members;
                $this->data["subview"]  = "laporan/idcard/index";
                $this->load->view('_main_layout', $this->data);
            }
        } else {
            $this->data["subview"] = "laporan/idcard/index";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function pdf()
    {
        $roleID   = htmlentities(escapeString($this->uri->segment(3)));
        $memberID = htmlentities(escapeString($this->uri->segment(4)));
        $type     = htmlentities(escapeString($this->uri->segment(5)));

        if ((int) $roleID && ((int) $memberID || $memberID == 0) && (int) $type) {
            $queryArray['id_peran'] = $roleID;
            if ((int) $memberID) {
                $queryArray['id_anggota'] = $memberID;
            }
            $queryArray['status']     = 1;
            $queryArray['dihapus_pada'] = 0;
            $members                  = $this->anggota_m->get_order_by_member($queryArray);
            if ($type == 2) {
                $this->generatebarcode($members);
            }

            $this->data['type']     = $type;
            $this->data['id_peran']   = $roleID;
            $this->data['id_anggota'] = $memberID;
            $this->data['members']  = $members;

            $this->pdf->create(['stylesheet' => 'idcardreport.css', 'view' => 'laporan/idcard/pdf.php', 'data' => $this->data]);
        } else {
            $this->data["subview"] = "_not_found";
            $this->load->view('_main_layout', $this->data);
        }
    }

    private function generatebarcode($members)
    {
        if (calculate($members)) {
            foreach ($members as $anggota) {
                $memberID = generate_memberID($anggota->id_anggota);
                $this->barcode->generate($memberID, $memberID);
            }
        }
    }

    public function get_member()
    {
        echo "<option value='0'>" . $this->lang->line('idcardreport_please_select') . "</option>";
        if ($_POST && permissionChecker('idcardreport')) {
            $roleID = $this->input->post('id_peran');
            if ((int) $roleID) {
                $members = $this->anggota_m->get_order_by_member(array('id_peran' => $roleID, 'status' => 1, 'dihapus_pada' => 0), array('id_anggota', 'nama'));
                if (calculate($members)) {
                    foreach ($members as $anggota) {
                        echo "<option value='" . $anggota->id_anggota . "'>" . $anggota->nama . "</option>";
                    }
                }
            }
        }
    }

    private function rules()
    {
        $rules = array(
            array(
                'field' => 'id_peran',
                'label' => $this->lang->line('idcardreport_role'),
                'rules' => 'trim|xss_clean|required|numeric|required_no_zero',
            ),
            array(
                'field' => 'id_anggota',
                'label' => $this->lang->line('idcardreport_member'),
                'rules' => 'trim|xss_clean|required|numeric',
            ),
            array(
                'field' => 'type',
                'label' => $this->lang->line('idcardreport_type'),
                'rules' => 'trim|xss_clean|required|numeric|required_no_zero',
            ),
        );
        return $rules;
    }

}
