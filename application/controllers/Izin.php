<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Izin extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Peran_m');
        $this->load->model('Izin_m');
        $this->load->model('Catatanizin_m');

        $lang = 'indonesia';
        $this->lang->load('izin', $lang);
    }

    protected function rules()
    {
        $rules = array(
            array(
                'field' => 'permissionsroleID',
                'label' => 'Permissions roleID',
                'rules' => 'trim|xss_clean|required|numeric',
            ),
        );
        return $rules;
    }

    public function index()
    {
        $roleID = escapeString($this->uri->segment('3'));
		$this->data['get_title'] = 'Izin | '.$this->data['pengaturan_umum']->sitename;
		
        if ((int) $roleID) {
            $this->data['urlroleID'] = $roleID;
        } else {
            $this->data['urlroleID'] = '0';
        }

        $this->data['headerassets'] = array(
            'css' => array(
                'assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css',
                'assets/custom/css/hidetable.css',
            ),
            'js'  => array(
                'assets/plugins/datatables.net/js/jquery.dataTables.min.js',
                'assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js',
                'assets/custom/js/izin.js',
            ),
        );

        $permissionlogs = $this->catatanizin_m->get_order_by_permissionlog(array('aktif' => 'yes'));

        $permissionlogsArray    = [];
        $permissionsModuleArray = [];
        if (calculate($permissionlogs)) {
            foreach ($permissionlogs as $catatan_izin) {
                if ((strpos($catatan_izin->nama, '_add') == false) && (strpos($catatan_izin->nama, '_edit') == false) && (strpos($catatan_izin->nama, '_view') == false) && (strpos($catatan_izin->nama, '_delete') == false)) {
                    $permissionsModuleArray[$catatan_izin->permissionlogID] = $catatan_izin;
                }
                $permissionlogsArray[$catatan_izin->nama] = $catatan_izin->permissionlogID;
            }
        }

        $this->data['izin'] = pluck_multi_array_key($this->izin_m->get_permissions(), 'permissionlogID', 'id_peran', 'permissionlogID');

        $this->data['permissionlogsArray']    = $permissionlogsArray;
        $this->data['permissionsModuleArray'] = $permissionsModuleArray;
        $this->data['roles']                  = $this->peran_m->get_role();
        $this->data["subview"]                = "izin/index";
        $this->load->view('_main_layout', $this->data);
    }

    public function save()
    {
        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('error', trim(validation_errors()));
                redirect(base_url("izin/index"));
            } else {
                $permissionsroleID = $_POST['permissionsroleID'];
                unset($_POST['permissionsroleID']);

                $permissionArray = [];
                if (calculate($_POST)) {
                    $i = 0;
                    foreach ($_POST as $permissionname => $permissionlogID) {
                        $permissionArray[$i]['id_peran']          = $permissionsroleID;
                        $permissionArray[$i]['permissionlogID'] = $permissionlogID;
                        $i++;
                    }
                }

                if (calculate($permissionArray)) {
                    $this->izin_m->delete_permissions_by_roleID($permissionsroleID);
                    $this->izin_m->insert_batch_permissions($permissionArray);
                }
                $this->session->set_flashdata('success', 'Success');
                redirect(base_url("izin/index/$permissionsroleID"));
            }
        } else {
            redirect(base_url('izin/index'));
        }
    }

}
