<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Memberreport extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('role_m');
        $this->load->model('member_m');
        $this->load->library('pdf');

        $lang = 'indonesia';
        $this->lang->load('memberreport', $lang);
    }

    public function index()
    {
        $this->data['headerassets'] = array(
            'js' => array(
                'assets/custom/js/memberreport.js',
            ),
        );
		
		$this->data['get_title'] = 'Laporan Data Anggota | '.$this->data['pengaturan_umum']->sitename;
		
        $this->data['flag']         = 0;
        $this->data['id_peran']       = 0;
        $this->data['id_anggota']     = 0;
        $this->data['bloodgroupID'] = 0;
        $this->data['status']       = 0;

        $this->data['roles']   = pluck($this->role_m->get_role(), 'obj', 'id_peran');
        $this->data['members'] = [];
        unset($_SESSION['error']);
        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $message = implode('<br/>', $this->form_validation->error_array());
                $this->session->set_flashdata('error', $message);
                $this->data["subview"] = "report/anggota/index";
                $this->load->view('_main_layout', $this->data);
            } else {
                $roleID       = $this->input->post('id_peran');
                $memberID     = $this->input->post('id_anggota');
                $bloodgroupID = $this->input->post('bloodgroupID');
                $status       = $this->input->post('status');

                $queryArray = [];
                if ((int) $roleID) {
                    $queryArray['id_peran'] = $roleID;
                }
                if ((int) $memberID) {
                    $queryArray['id_anggota'] = $memberID;
                }
                if ((int) $bloodgroupID) {
                    $queryArray['bloodgroup'] = $bloodgroupID;
                }
                if ((int) $status) {
                    $queryArray['status'] = $status;
                }
                $queryArray['dihapus_pada'] = 0;
                $members                  = $this->member_m->get_order_by_member($queryArray);

                $this->data['flag']         = 1;
                $this->data['id_peran']       = 0;
                $this->data['id_anggota']     = 0;
                $this->data['bloodgroupID'] = 0;
                $this->data['status']       = 0;
                $this->data['members']      = $members;

                $this->data["subview"] = "report/anggota/index";
                $this->load->view('_main_layout', $this->data);
            }
        } else {
            $this->data["subview"] = "report/anggota/index";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function pdf()
    {
        $roleID       = htmlentities(escapeString($this->uri->segment(3)));
        $memberID     = htmlentities(escapeString($this->uri->segment(4)));
        $bloodgroupID = htmlentities(escapeString($this->uri->segment(5)));
        $status       = htmlentities(escapeString($this->uri->segment(6)));

        if (((int) $roleID || $roleID == 0) && ((int) $memberID || $memberID == 0) && ((int) $bloodgroupID || $bloodgroupID == 0) && ((int) $status || $status == 0)) {

            $queryArray = [];
            if ((int) $roleID) {
                $queryArray['id_peran'] = $roleID;
            }
            if ((int) $memberID) {
                $queryArray['id_anggota'] = $memberID;
            }
            if ((int) $bloodgroupID) {
                $queryArray['bloodgroup'] = $bloodgroupID;
            }
            if ((int) $status) {
                $queryArray['status'] = $status;
            }
            $queryArray['dihapus_pada'] = 0;
            $members                  = $this->member_m->get_order_by_member($queryArray);

            $this->data['flag']         = 1;
            $this->data['id_peran']       = 0;
            $this->data['id_anggota']     = 0;
            $this->data['bloodgroupID'] = 0;
            $this->data['status']       = 0;
            $this->data['members']      = $members;
            $this->data['roles']        = pluck($this->role_m->get_role(), 'obj', 'id_peran');

            $this->pdf->create(['stylesheet' => 'memberreport.css', 'view' => 'report/anggota/pdf.php', 'data' => $this->data]);
        } else {
            $this->data["subview"] = "_not_found";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function get_member()
    {
        echo "<option value='0'>" . $this->lang->line('memberreport_please_select') . "</option>";
        if ($_POST && permissionChecker('memberreport')) {
            $roleID = $this->input->post('id_peran');
            if ((int) $roleID) {
                $members = $this->member_m->get_order_by_member(array('id_peran' => $roleID, 'status' => 1, 'dihapus_pada' => 0), array('id_anggota', 'nama'));
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
                'label' => $this->lang->line('memberreport_role'),
                'rules' => 'trim|xss_clean|required|numeric',
            ),
            array(
                'field' => 'id_anggota',
                'label' => $this->lang->line('memberreport_member'),
                'rules' => 'trim|xss_clean|required|numeric',
            ),
            array(
                'field' => 'bloodgroupID',
                'label' => $this->lang->line('memberreport_blood_group'),
                'rules' => 'trim|xss_clean|required',
            ),
            array(
                'field' => 'status',
                'label' => $this->lang->line('memberreport_status'),
                'rules' => 'trim|xss_clean|required|numeric',
            ),
        );
        return $rules;
    }

}
