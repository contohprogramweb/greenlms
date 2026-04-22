<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bookissuereport extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('role_m');
        $this->load->model('book_m');
        $this->load->model('member_m');
        $this->load->model('bookissue_m');
        $this->load->model('bookcategory_m');
        $this->load->library('pdf');

        $lang = 'indonesia';
        $this->lang->load('bookissuereport', $lang);
    }

    public function index()
    {
        $this->data['headerassets'] = array(
            'css'      => array(
                'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
            ),
            'headerjs' => array(
                'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
            ),
            'js'       => array(
                'assets/custom/js/bookissuereport.js',
            ),
        );
		
		$this->data['get_title'] = 'Laporan Buku Dipinjam | '.$this->data['pengaturan_umum']->sitename;
		
        $this->data['flag']           = 0;
        $this->data['bookcategoryID'] = 0;
        $this->data['id_buku']         = 0;
        $this->data['id_peran']         = 0;
        $this->data['id_anggota']       = 0;
        $this->data['status']         = 0;
        $this->data['fromdate']       = 0;
        $this->data['todate']         = 0;

        $this->data['roles']         = pluck($this->role_m->get_role(), 'obj', 'id_peran');
        $this->data['bookcategorys'] = $this->bookcategory_m->get_bookcategory();
        unset($_SESSION['error']);
        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $message = implode('<br/>', $this->form_validation->error_array());
                $this->session->set_flashdata('error', $message);
                $this->data["subview"] = "report/peminjaman_buku/index";
                $this->load->view('_main_layout', $this->data);
            } else {
                $bookcategoryID = $this->input->post('bookcategoryID');
                $bookID         = $this->input->post('id_buku');
                $roleID         = $this->input->post('id_peran');
                $memberID       = $this->input->post('id_anggota');
                $status         = $this->input->post('status');
                $fromdate       = $this->input->post('fromdate');
                $todate         = $this->input->post('todate');

                $this->_queryArray(['bookcategoryID' => $bookcategoryID, 'id_buku' => $bookID, 'id_peran' => $roleID, 'id_anggota' => $memberID, 'status' => $status, 'fromdate' => $fromdate, 'todate' => $todate]);

                $this->data["subview"] = "report/peminjaman_buku/index";
                $this->load->view('_main_layout', $this->data);
            }
        } else {
            $this->data["subview"] = "report/peminjaman_buku/index";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function pdf()
    {
        $bookcategoryID = htmlentities(escapeString($this->uri->segment(3)));
        $bookID         = htmlentities(escapeString($this->uri->segment(4)));
        $roleID         = htmlentities(escapeString($this->uri->segment(5)));
        $memberID       = htmlentities(escapeString($this->uri->segment(6)));
        $status         = htmlentities(escapeString($this->uri->segment(7)));
        $fromdate       = htmlentities(escapeString($this->uri->segment(8)));
        $todate         = htmlentities(escapeString($this->uri->segment(9)));

        if (((int) $bookcategoryID || $bookcategoryID == 0) && ((int) $bookID || $bookID == 0) && ((int) $roleID || $roleID == 0) && ((int) $memberID || $memberID == 0) && ((int) $status || $status == 0) && ((int) $fromdate || $fromdate == 0) && ((int) $todate || $todate == 0)) {

            $this->_queryArray(['bookcategoryID' => $bookcategoryID, 'id_buku' => $bookID, 'id_peran' => $roleID, 'id_anggota' => $memberID, 'status' => $status, 'fromdate' => $fromdate, 'todate' => $todate]);

            $this->pdf->create(['stylesheet' => 'bookissuereport.css', 'view' => 'report/peminjaman_buku/pdf.php', 'data' => $this->data]);
        } else {
            $this->data["subview"] = "_not_found";
            $this->load->view('_main_layout', $this->data);
        }
    }

    private function _queryArray($qArray)
    {
        extract($qArray);

        $userArray  = [];
        $queryArray = [];
        if ((int) $roleID) {
            $queryArray['bookcategoryID'] = $bookcategoryID;
            if ((int) $memberID) {
                $queryArray['id_buku'] = $bookID;
            }
        }
        if ((int) $roleID) {
            $userArray['id_peran']  = $roleID;
            $queryArray['id_peran'] = $roleID;
            if ((int) $memberID) {
                $userArray['id_anggota']  = $memberID;
                $queryArray['id_anggota'] = $memberID;
            }
        }
        $userArray['status']     = 1;
        $userArray['dihapus_pada'] = 0;

        if ((int) $status) {
            $queryArray['status'] = $status - 1;
        }
        if (!empty($fromdate) && !empty($todate)) {
            $queryArray['fromdate'] = date('Y-m-d', strtotime($fromdate));
            $queryArray['todate']   = date('Y-m-d', strtotime($todate));
        }

        $members = [];
        if (calculate($userArray)) {
            $members = $this->member_m->get_order_by_member($userArray);
        }
        $bookissues = [];
        if (calculate($userArray)) {
            $bookissues = $this->bookissue_m->get_order_by_bookissue_for_bookissuereport($queryArray);
        }

        $this->data['flag']           = 1;
        $this->data['bookcategoryID'] = $bookcategoryID;
        $this->data['id_buku']         = $bookID;
        $this->data['id_peran']         = $roleID;
        $this->data['id_anggota']       = $memberID;
        $this->data['status']         = $status;
        $this->data['fromdate']       = empty($fromdate) ? 0 : strtotime($fromdate);
        $this->data['todate']         = empty($todate) ? 0 : strtotime($todate);
        $this->data['members']        = pluck($members, 'obj', 'id_anggota');
        $this->data['books']          = pluck($this->book_m->get_book(), 'nama', 'id_buku');
        $this->data['bookissues']     = $bookissues;
    }

    public function get_book()
    {
        echo "<option value='0'>" . $this->lang->line('bookissuereport_please_select') . "</option>";
        if ($_POST && permissionChecker('bookissuereport')) {
            $bookcategoryID = $this->input->post('bookcategoryID');
            if ((int) $bookcategoryID) {
                $array['dihapus_pada']     = 0;
                $array['bookcategoryID'] = $bookcategoryID;
                $books                   = $this->book_m->get_order_by_book($array, array('id_buku', 'nama', 'codeno'));
                if (calculate($books)) {
                    foreach ($books as $buku) {
                        echo "<option value='" . $buku->id_buku . "'>" . $buku->nama . ' - ' . $buku->codeno . "</option>";
                    }
                }
            }
        }
    }

    public function get_member()
    {
        echo "<option value='0'>" . $this->lang->line('bookissuereport_please_select') . "</option>";
        if ($_POST && permissionChecker('bookissuereport')) {
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
                'field' => 'bookcategoryID',
                'label' => $this->lang->line('bookissuereport_book_category'),
                'rules' => 'trim|xss_clean|required|numeric',
            ),
            array(
                'field' => 'id_buku',
                'label' => $this->lang->line('bookissuereport_book'),
                'rules' => 'trim|xss_clean|required|numeric',
            ),
            array(
                'field' => 'id_peran',
                'label' => $this->lang->line('bookissuereport_role'),
                'rules' => 'trim|xss_clean|numeric',
            ),
            array(
                'field' => 'id_anggota',
                'label' => $this->lang->line('bookissuereport_member'),
                'rules' => 'trim|xss_clean|numeric',
            ),
            array(
                'field' => 'status',
                'label' => $this->lang->line('bookissuereport_status'),
                'rules' => 'trim|xss_clean|required|numeric',
            ),
            array(
                'field' => 'fromdate',
                'label' => $this->lang->line('bookissuereport_from_date'),
                'rules' => 'trim|xss_clean|valid_date',
            ),
            array(
                'field' => 'todate',
                'label' => $this->lang->line('bookissuereport_to_date'),
                'rules' => 'trim|xss_clean|valid_date|callback_date_check',
            ),
        );
        return $rules;
    }

    public function date_check()
    {
        $fromdate = $this->input->post('fromdate');
        $todate   = $this->input->post('todate');

        if ($fromdate != '' && $todate != '') {
            if (strtotime($fromdate) > strtotime($todate)) {
                $this->form_validation->set_message("date_check", "The to date can not be lowwer than fromdate.");
                return false;
            }
        } elseif ($fromdate == '' && $todate != '') {
            $this->form_validation->set_message("date_check", "The from date can not be empty.");
            return false;
        }
        return true;
    }

}
