<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_Controller extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Menu_m');
        $this->load->model('Izin_m');
        $this->load->model('Catatanizin_m');
        $this->load->model('Pengaturanumum_m');
        $this->load->helper('text');

        if ($this->config->item('installed') == 'NO') {
            redirect(base_url('Instalasi/index'));
        }
        $this->load->database();

        $this->data['pengaturan_umum'] = (object) pluck($this->pengaturanumum_m->get_generalsetting(), 'optionvalue', 'optionkey');
        $this->data['bloodgroups']    = $this->_bloodgroup();

        $lang = $this->session->userdata('language');
        $this->lang->load('menubar', $lang);
        $this->lang->load('default', $lang);

        $this->data['activemenu'] = $this->uri->segment(1);
        $exception_uris           = array(
            'masuk/index',
            'masuk/logout',
            'masuk/reset_kata_sandi',
            'masuk/registermember',
            'masuk/resetpasswordconfirm',
        );

        if (in_array(uri_string(), $exception_uris) == false) {
            $logged = $this->session->userdata('loggedin');
            if ($logged == false) {
                redirect(base_url('Masuk/index'));
            }
        }

        $this->_set_permission();
        $this->_url_protect();
        $this->data['sidebarmenus'] = $this->_sidebar_menu();
        $this->data['get_title']    = $this->_get_title();

    }

    private function _set_permission()
    {
        $modulepermission_set = $this->session->userdata('modulepermission_set');
        $loggedin             = $this->session->userdata('loggedin');
        if (!calculate($modulepermission_set) && $loggedin) {
            $roleID        = $this->session->userdata('id_peran');
            $loginmemberID = $this->session->userdata('loginmemberID');

            $permissionlogs   = $this->catatanizin_m->get_permissionlog();
            $permissionsArray = [];
            if ($roleID == 1 && $loginmemberID == 1) {
                if (calculate($permissionlogs)) {
                    foreach ($permissionlogs as $catatan_izin) {
                        $permissionsArray['modulepermission_set'][$catatan_izin->nama] = $catatan_izin->aktif;
                    }
                }
            } else {
                $izin = $this->izin_m->get_permissions_with_permissionlog_by_roleID($roleID);
                if (calculate($izin)) {
                    foreach ($izin as $permission) {
                        $permissionsArray['modulepermission_set'][$permission->nama] = $permission->aktif;
                    }
                }

                if (calculate($permissionlogs)) {
                    foreach ($permissionlogs as $catatan_izin) {
                        if (!isset($permissionsArray['modulepermission_set'][$catatan_izin->nama])) {
                            $permissionsArray['modulepermission_set'][$catatan_izin->nama] = 'no';
                        }
                    }
                }
            }
            if (calculate($permissionsArray)) {
                $this->session->set_userdata($permissionsArray);
            }
        }
    }

    private function _url_protect()
    {
        $module = $this->uri->segment(1);
        $action = $this->uri->segment(2);

        $permission = '';
        if ($action == 'index' || $action == false) {
            $permission = $module;
        } else {
            $permission = $module . '_' . $action;
        }

        $modulepermission_set = $this->session->userdata('modulepermission_set');
        if ((isset($modulepermission_set[$permission]))) {
            if ($modulepermission_set[$permission] != "yes") {
                redirect(base_url('Halamaneksepsi/error'));
            }
        }
    }

    private function _sidebar_menu()
    {
        $menus     = $this->menu_m->get_order_by_menu(array('status' => 1));
        $menuArray = [];
        if (calculate($menus)) {
            foreach ($menus as $menu) {
                if (visibleButtonMenu($menu->menulink) || ($menu->menulink == '#')) {
                    if ($menu->parentmenuID == 0) {
                        if (!isset($menuArray[$menu->id_menu])) {
                            $menuArray[$menu->id_menu] = (array) $menu;
                        }
                    } else {
                        if (!isset($menuArray[$menu->parentmenuID]['child'])) {
                            $menuArray[$menu->parentmenuID]['child'] = [];
                        }
                        $menuArray[$menu->parentmenuID]['child'][$menu->id_menu] = (array) $menu;
                    }
                }
            }
        }
        return $menuArray;
    }

    private function _get_title($title = null)
    {
        $get_title = '';
        if ($title) {
            $get_title = ucfirst($title) . " | " . $this->data['pengaturan_umum']->sitename;
        } else {
            $title     = empty($this->data['activemenu']) ? 'Dashboard' : $this->data['activemenu'];
            $get_title = ucfirst($title) . " | " . $this->data['pengaturan_umum']->sitename;
        }
        return $get_title;
    }

    public function password_hash($password)
    {
        return hash('sha512', $password . $this->config->item('encryption_key'));
    }

    private function _bloodgroup()
    {
        return [
            'A+'  => 'A+',
            'A-'  => 'A-',
            'B+'  => 'B+',
            'B-'  => 'B-',
            'AB+' => 'AB+',
            'AB-' => 'AB-',
            'O+'  => 'O+',
            'O-'  => 'O-',
        ];
    }

    public function checkAdminLibrarianPermission()
    {
        $roleID = $this->session->userdata('id_peran');
        if ($roleID == 1 || $roleID == 2) {
            return false;
        }
        return true;
    }

}
