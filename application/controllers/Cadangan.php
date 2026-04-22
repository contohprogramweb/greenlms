<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cadangan extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();


        $lang = 'indonesia';
        $this->lang->load('backup', $lang);
    }

    public function index()
    {
		$this->data['get_title'] = 'Backup Database | '.$this->data['pengaturan_umum']->sitename;
		
        $this->data["subview"] = "cadangan/index";
        $this->load->view('_main_layout', $this->data);
    }

    public function backup()
    {
        if (config_item('demo')) {
            $this->session->set_flashdata('error', 'This backup module disable for demo version');
            redirect(base_url('Dasbor/index'));
        }
        if(permissionChecker('backup')) {
            $backup_name = 'backup-on-' . date("Y-m-d-H-i-s-A");

            $this->load->dbutil();
            $prefs = array(
                'format'   => 'zip',
                'filename' => $backup_name . '.sql',
            );
            $backup = $this->dbutil->backup($prefs);
            $this->load->helper('download');
            force_download($backup_name . '.zip', $backup);
        } else {
            redirect(base_url('Dasbor/index'));
        }
    }

}
