<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transactionreport extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('role_m');
        $this->load->model('member_m');
        $this->load->model('income_m');
        $this->load->model('expense_m');
        $this->load->model('paymentanddiscount_m');
        $this->load->model('finehistory_m');
        $this->load->model('bookissue_m');
        $this->load->library('pdf');

        $lang = 'indonesia';
        $this->lang->load('transactionreport', $lang);
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
                'assets/custom/js/transactionreport.js',
            ),
        );
		
		$this->data['get_title'] = 'Laporan Transaksi | '.$this->data['pengaturan_umum']->sitename;
		
		
        $this->data['flag']      = 0;
        $this->data['reportfor'] = 0;
        $this->data['id_peran']    = 0;
        $this->data['id_anggota']  = 0;
        $this->data['fromdate']  = 0;
        $this->data['todate']    = 0;
        $this->data['members']   = [];
        $this->data['roles']     = $this->role_m->get_role();

        unset($_SESSION['error']);
        if ($_POST) {
            $reportfor = $this->input->post('reportfor');
            $roleID    = $this->input->post('id_peran');
            $memberID  = $this->input->post('id_anggota');
            $fromdate  = $this->input->post('fromdate');
            $todate    = $this->input->post('todate');

            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $message = implode('<br/>', $this->form_validation->error_array());
                $this->session->set_flashdata('error', $message);
                $this->data["subview"] = "report/transaction/index";
                $this->load->view('_main_layout', $this->data);
            } else {

                $this->_queryArray(['reportfor' => $reportfor, 'id_peran' => $roleID, 'id_anggota' => $memberID, 'fromdate' => $fromdate, 'todate' => $todate]);

                $this->data["subview"] = "report/transaction/index";
                $this->load->view('_main_layout', $this->data);
            }
        } else {
            $this->data["subview"] = "report/transaction/index";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function pdf()
    {
        $reportfor = htmlentities(escapeString($this->uri->segment(3)));
        $roleID    = htmlentities(escapeString($this->uri->segment(4)));
        $memberID  = htmlentities(escapeString($this->uri->segment(5)));
        $fromdate  = htmlentities(escapeString($this->uri->segment(6)));
        $todate    = htmlentities(escapeString($this->uri->segment(7)));

        if ((int) $reportfor && ((int) $roleID || $roleID == 0) && ((int) $memberID || $memberID == 0) && ((int) $fromdate || $fromdate == 0) && ((int) $todate || $todate == 0)) {

            $this->_queryArray(['reportfor' => $reportfor, 'id_peran' => $roleID, 'id_anggota' => $memberID, 'fromdate' => $fromdate, 'todate' => $todate]);

            $this->pdf->create(['stylesheet' => 'transactionreport.css', 'view' => 'report/transaction/pdf.php', 'data' => $this->data]);

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
        if ((int) $reportfor) {
            $queryArray['reportfor'] = $reportfor;
        }
        if ((int) $roleID) {
            $queryArray['id_peran'] = $roleID;
            $userArray['id_peran']  = $roleID;
            if ((int) $memberID) {
                $queryArray['id_anggota'] = $memberID;
            }
        }
        $userArray['status']     = 1;
        $userArray['dihapus_pada'] = 0;

        if (!empty($fromdate) && !empty($todate)) {
            $queryArray['fromdate'] = date('Y-m-d', strtotime($fromdate));
            $queryArray['todate']   = date('Y-m-d', strtotime($todate));
        }

        $members = [];
        if (calculate($userArray)) {
            $members = $this->member_m->get_order_by_member($userArray);
        }

        $this->data['flag']      = 1;
        $this->data['reportfor'] = $reportfor;
        $this->data['id_peran']    = $roleID;
        $this->data['id_anggota']  = $memberID;
        $this->data['fromdate']  = empty($fromdate) ? 0 : strtotime($fromdate);
        $this->data['todate']    = empty($todate) ? 0 : strtotime($todate);
        $this->data['members']   = $members;

        $this->_queryArrayDB($queryArray);
    }

    private function _queryArrayDB($queryArray)
    {
        $reportfor = $this->data['reportfor'];
        $members   = pluck($this->data['members'], 'nama', 'id_anggota');
        $roles     = pluck($this->role_m->get_role(), 'peran', 'id_peran');
        $i         = 1;
        $retArray  = [];
        if ($reportfor == 1) {
            $incomes = $this->income_m->get_order_by_income_for_report($queryArray);
            if (calculate($incomes)) {
                foreach ($incomes as $pemasukan) {
                    $retArray[$i]['type']   = 'Income';
                    $retArray[$i]['peran']   = '';
                    $retArray[$i]['anggota'] = '';
                    $retArray[$i]['tanggal']   = app_date($pemasukan->tanggal);
                    $retArray[$i]['jumlah'] = $pemasukan->jumlah;
                    $i++;
                }
            }
        } else if ($reportfor == 2) {
            $expenses = $this->expense_m->get_order_by_expense_for_report($queryArray);
            if (calculate($expenses)) {
                foreach ($expenses as $pengeluaran) {
                    $retArray[$i]['type']   = 'Expense';
                    $retArray[$i]['peran']   = '';
                    $retArray[$i]['anggota'] = '';
                    $retArray[$i]['tanggal']   = app_date($pengeluaran->tanggal);
                    $retArray[$i]['jumlah'] = $pengeluaran->jumlah;
                    $i++;
                }
            }
        } else if ($reportfor == 3) {
            $paymentanddiscounts = $this->paymentanddiscount_m->get_order_by_paymentanddiscount_for_report($queryArray);
            if (calculate($paymentanddiscounts)) {
                foreach ($paymentanddiscounts as $pembayaran_dan_diskon) {
                    $retArray[$i]['type']   = 'Collection';
                    $retArray[$i]['peran']   = isset($roles[$pembayaran_dan_diskon->id_peran]) ? $roles[$pembayaran_dan_diskon->id_peran] : '';
                    $retArray[$i]['anggota'] = isset($members[$pembayaran_dan_diskon->id_anggota]) ? $members[$pembayaran_dan_diskon->id_anggota] : '';
                    $retArray[$i]['tanggal']   = app_date($pembayaran_dan_diskon->tanggal_dibuat);
                    $retArray[$i]['jumlah'] = $pembayaran_dan_diskon->payamount;
                    $i++;
                }
            }
        } else if ($reportfor == 4) {
            $finehistorys = $this->finehistory_m->get_order_by_finehistory_for_report($queryArray);
            if (calculate($finehistorys)) {
                foreach ($finehistorys as $riwayat_denda) {
                    $retArray[$i]['type']   = 'Fine';
                    $retArray[$i]['peran']   = isset($roles[$riwayat_denda->id_peran]) ? $roles[$riwayat_denda->id_peran] : '';
                    $retArray[$i]['anggota'] = isset($members[$riwayat_denda->id_anggota]) ? $members[$riwayat_denda->id_anggota] : '';
                    $retArray[$i]['tanggal']   = app_date($riwayat_denda->tanggal_dibuat);
                    $retArray[$i]['jumlah'] = $riwayat_denda->famount;
                    $i++;
                }
            }
        } else if ($reportfor == 5) {
            $paymentanddiscounts = $this->paymentanddiscount_m->get_order_by_paymentanddiscount_for_report($queryArray);
            if (calculate($paymentanddiscounts)) {
                foreach ($paymentanddiscounts as $pembayaran_dan_diskon) {
                    $retArray[$i]['type']   = 'Discount';
                    $retArray[$i]['peran']   = isset($roles[$pembayaran_dan_diskon->id_peran]) ? $roles[$pembayaran_dan_diskon->id_peran] : '';
                    $retArray[$i]['anggota'] = isset($members[$pembayaran_dan_diskon->id_anggota]) ? $members[$pembayaran_dan_diskon->id_anggota] : '';
                    $retArray[$i]['tanggal']   = app_date($pembayaran_dan_diskon->tanggal_dibuat);
                    $retArray[$i]['jumlah'] = $pembayaran_dan_diskon->disamount;
                    $i++;
                }
            }
        } else if ($reportfor == 6) {
            $bookissues = $this->bookissue_m->get_order_by_bookissue_for_report($queryArray);
            if (calculate($bookissues)) {
                foreach ($bookissues as $peminjaman_buku) {
                    $dueamount              = $peminjaman_buku->fineamount - ($peminjaman_buku->paymentamount + $peminjaman_buku->discountamount);
                    $retArray[$i]['type']   = 'Due';
                    $retArray[$i]['peran']   = isset($roles[$peminjaman_buku->id_peran]) ? $roles[$peminjaman_buku->id_peran] : '';
                    $retArray[$i]['anggota'] = isset($members[$peminjaman_buku->id_anggota]) ? $members[$peminjaman_buku->id_anggota] : '';
                    $retArray[$i]['tanggal']   = app_date($peminjaman_buku->tanggal_dibuat);
                    $retArray[$i]['jumlah'] = $dueamount;
                    $i++;
                }
            }
        }
        $this->data['transactions'] = $retArray;
    }

    public function get_member()
    {
        echo "<option value='0'>" . $this->lang->line('transactionreport_please_select') . "</option>";
        if ($_POST && permissionChecker('transactionreport')) {
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
                'field' => 'reportfor',
                'label' => $this->lang->line('transactionreport_report_for'),
                'rules' => 'trim|xss_clean|numeric|required_no_zero',
            ),
            array(
                'field' => 'id_peran',
                'label' => $this->lang->line('transactionreport_role'),
                'rules' => 'trim|xss_clean|numeric',
            ),
            array(
                'field' => 'id_anggota',
                'label' => $this->lang->line('transactionreport_member'),
                'rules' => 'trim|xss_clean|numeric',
            ),
            array(
                'field' => 'fromdate',
                'label' => $this->lang->line('transactionreport_from_date'),
                'rules' => 'trim|xss_clean|valid_date',
            ),
            array(
                'field' => 'todate',
                'label' => $this->lang->line('transactionreport_to_date'),
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
