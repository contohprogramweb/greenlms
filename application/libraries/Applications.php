<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Applications
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();

        //Load email library
        $this->CI->load->library('parser');
        $this->CI->load->library('surel');
        $this->CI->load->model('Pengaturanemail_m');
    }

    public function sendemails($users, $message, $subject, $fromemail = 'no-reply@admin.com')
    {
        $this->_configure_email_setting();

        $sendemails       = $this->convert_tag($users, $message);
        $notsendemailuser = [];
        if (calculate($sendemails)) {
            foreach ($sendemails as $senduserID => $sendemail) {
                $viewload = $this->CI->load->view('_template/sendmail', $sendemail, true);
                $this->CI->surel->to($sendemail['surel']);
                $this->CI->surel->from($fromemail, 'Portfolio');
                $this->CI->surel->subjek($subject);
                $this->CI->surel->pesan($viewload);
                //Send email
                if (!$this->CI->surel->send()) {
                    $notsendemailuser[$senduserID] = $senduserID;
                }
            }
        }
        echo $notsendemailuser;
    }

    // kirim_email
    public function sendemail($email, $message, $subject, $name, $fromemail = 'no-reply@admin.com')
    {
        $this->_configure_email_setting();

        $passArray['pesan'] = $message;
        $viewload             = $this->CI->load->view('_template/sendmail', $passArray, true);
        $this->CI->surel->to($email);
        $this->CI->surel->from($fromemail, $name);
        $this->CI->surel->subjek($subject);
        $this->CI->surel->pesan($viewload);
        //Send email
        return $this->CI->surel->send();
    }

    public function sendmail($email, $message, $subject, $name, $fromemail = 'no-reply@admin.com')
    {
        $this->_configure_email_setting();

        $this->CI->surel->to($email);
        $this->CI->surel->from($fromemail, $name);
        $this->CI->surel->subjek($subject);
        $this->CI->surel->pesan($message);
        //Send email
        return $this->CI->surel->send();
    }

    private function convert_tag($memebers, $message)
    {
        $retArray = [];
        if (calculate($memebers)) {
            foreach ($memebers as $memeber) {
                $message = str_replace('[memberID]', "memeber ID " . $memeber->id_anggota, $message);
                $message = str_replace('[name]', $memeber->nama, $message);
                $message = str_replace('[dateofbirth]', date('d m Y H:i:s', strtotime($memeber->dateofbirth)), $message);
                $message = str_replace('[gender]', $memeber->jenis_kelamin, $message);
                $message = str_replace('[religion]', $memeber->agama, $message);
                $message = str_replace('[email]', $memeber->surel, $message);
                $message = str_replace('[phone]', $memeber->telepon, $message);
                $message = str_replace('[address]', $memeber->alamat, $message);
                $message = str_replace('[joinningdate]', date('d m Y H:i:s', strtotime($memeber->joiningdate)), $message);
                if ($memeber->foto) {
                    $imageurl = "<img src='" . profile_img($memeber->foto) . "'/>";
                    $message  = str_replace('[photo]', $imageurl, $message);
                }
                $message                                 = str_replace('[username]', $memeber->nama_pengguna, $message);
                $message                                 = str_replace('[current_date]', date('d m Y H:i:s'), $message);
                $retArray[$memeber->id_anggota]['pesan'] = $message;
                $retArray[$memeber->id_anggota]['surel']   = $memeber->surel;
            }
        }
        return $retArray;
    }

    // SMTP & mail configuration
    private function _configure_email_setting()
    {
        $pengaturan_surel = (object) pluck($this->CI->emailsetting_m->get_emailsetting(), 'optionvalue', 'optionkey');
        if (calculate($pengaturan_surel)) {
            $config = array(
                'protocol'  => $pengaturan_surel->mail_driver,
                'smtp_host' => $pengaturan_surel->mail_host,
                'smtp_port' => $pengaturan_surel->mail_port,
                'smtp_user' => $pengaturan_surel->mail_username,
                'smtp_pass' => $pengaturan_surel->mail_password,
                'mailtype'  => 'html',
                'charset'   => 'utf-8',
            );
            $this->CI->surel->initialize($config);
            $this->CI->surel->set_mailtype("html");
            $this->CI->surel->set_newline("\r\n");
        }
    }

}
