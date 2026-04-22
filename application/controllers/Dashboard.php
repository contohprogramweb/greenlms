<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('member_m');
        $this->load->model('chat_m');
        $this->load->model('income_m');
        $this->load->model('expense_m');

        $this->load->library('applications');
        $lang = 'indonesia';
        $this->lang->load('dashboard', $lang);
    }

    public function index()
    {
        $this->data['headerassets'] = array(
            'css'      => array(
                'assets/plugins/chartjs/Chart.min.css',
            ),
            'headerjs' => array(
                'assets/plugins/chartjs/Chart.min.js',
            ),
            'js'       => array(
                'assets/custom/js/dashboard.js',
            ),
        );
		
		$this->data['get_title'] = 'Dashboard | '.$this->data['pengaturan_umum']->sitename;
		
        $this->data['members'] = pluck($this->member_m->get_member(), 'obj', 'id_anggota');

        $this->db->order_by('chatID desc');
        $chats = $this->chat_m->get_chat_by_limit(20);
        asort($chats);

        $this->_incomeAndExpense();

        $this->data['chats']   = $chats;
        $this->data["subview"] = "dashboard/index";
        $this->load->view('_main_layout', $this->data);
    }

    private function _incomeAndExpense()
    {
        $querArray['from_date'] = '01-01-' . date("Y");
        $querArray['to_date']   = '31-12-' . date("Y");

        $incomes  = $this->income_m->get_order_by_income_for_report($querArray);
        $expenses = $this->expense_m->get_order_by_expense_for_report($querArray);

        $monthArr   = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0, 12 => 0];
        $incomeArr  = $monthArr;
        $expenseArr = $monthArr;
        if (calculate($incomes)) {
            foreach ($incomes as $pemasukan) {
                $month = (int) date('m', strtotime($pemasukan->tanggal));
                if (isset($incomeArr[$month])) {
                    $incomeArr[$month] += $pemasukan->jumlah;
                }
            }
        }
        if (calculate($expenses)) {
            foreach ($expenses as $pengeluaran) {
                $month = (int) date('m', strtotime($pengeluaran->tanggal));
                if (isset($expenseArr[$month])) {
                    $expenseArr[$month] += $pengeluaran->jumlah;
                }
            }
        }

        $this->data['pemasukan']  = implode(',', $incomeArr);
        $this->data['pengeluaran'] = implode(',', $expenseArr);
    }

    public function langswitch()
    {
        $language = htmlentities(escapeString($this->uri->segment(3)));
        if ((string) $language) {
            $this->session->set_userdata('language', $language);
            $this->session->set_flashdata('success', 'Success');
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->data["subview"] = "_not_found";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function obrolan()
    {
        $retArray           = [];
        $retArray['status'] = false;
        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $retArray['pesan'] = 'Error';
            } else {
                $array                    = [];
                $array['pesan']         = $this->input->post('pesan');
                $array['tanggal_dibuat']     = date('Y-m-d H:i:s');
                $array['create_memberID'] = $this->session->userdata('loginmemberID');
                $array['create_roleID']   = $this->session->userdata('id_peran');
                $array['modify_date']     = date('Y-m-d H:i:s');
                $array['modify_memberID'] = $this->session->userdata('loginmemberID');
                $array['modify_roleID']   = $this->session->userdata('id_peran');

                $result         = $this->chat_m->insert_chat($array);
                $array['nama']  = $this->session->userdata('nama');
                $array['foto'] = profile_img($this->session->userdata('foto'));
                $array['time']  = date('d M Y H:i s');

                if ($result) {
                    $retArray           = $array;
                    $retArray['status'] = true;
                } else {
                    $retArray['pesan'] = 'Error';
                }
            }
        } else {
            $retArray['pesan'] = 'Error';
        }
        echo json_encode($retArray);
    }

    public function getchatmessage()
    {
        $retArray           = [];
        $retArray['status'] = false;
        if ($_POST) {
            $chatID = $this->input->post('id_obrolan');
            if ((int) $chatID) {

                $chatID    = $chatID - 1;
                $showitem  = 20;
                $newChatID = $chatID - $showitem;
                if ($newChatID < 0) {
                    $chatID   = 0;
                    $showitem = abs($newChatID);
                } else {
                    $chatID = $newChatID;
                }

                $members = pluck($this->member_m->get_member(), 'obj', 'id_anggota');
                $chats   = $this->chat_m->get_chat_by_limit($showitem, $chatID);

                $retArray['data'] = $this->load->view('dashboard/getchat', array('chats' => $chats, 'members' => $members), true);
                if ($retArray['data'] != '') {
                    $retArray['status'] = true;
                }
            }
        }
        echo json_encode($retArray);
    }

    public function quickmail()
    {
        if ($_POST) {
            $rules = $this->rules_quickmail();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('error', $this->lang->line('dashboard_provide_valid_info'));
            } else {
                $name      = $this->session->userdata('nama');
                $email     = $this->input->post('surel');
                $subject   = $this->input->post('subjek');
                $message   = $this->input->post('pesan');
                $fromemail = $this->session->userdata('surel');

                $sendmail = $this->applications->sendmail($email, $message, $subject, $name, $fromemail = 'no-reply@admin.com');
                if ($sendmail) {
                    $this->session->set_flashdata('success', $this->lang->line('dashboard_email_send'));
                } else {
                    $this->session->set_flashdata('error', $this->lang->line('dashboard_email_fail'));
                }
            }
        }
        redirect(base_url('dashboard/index'));
    }

    private function rules_quickmail()
    {
        $rules = array(
            array(
                'field' => 'surel',
                'label' => $this->lang->line('dashboard_email'),
                'rules' => 'trim|xss_clean|required|valid_email',
            ),
            array(
                'field' => 'subjek',
                'label' => $this->lang->line('dashboard_subject'),
                'rules' => 'trim|xss_clean|required',
            ),
            array(
                'field' => 'pesan',
                'label' => $this->lang->line('dashboard_message'),
                'rules' => 'trim|xss_clean|required',
            ),
        );
        return $rules;
    }

    private function rules()
    {
        $rules = array(
            array(
                'field' => 'pesan',
                'label' => $this->lang->line('dashboard_message'),
                'rules' => 'trim|xss_clean|required',
            ),
        );
        return $rules;
    }

}
