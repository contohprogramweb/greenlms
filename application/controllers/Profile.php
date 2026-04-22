<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('member_m');
        $this->load->model('role_m');
        $this->load->model('bookcategory_m');
        $this->load->model('book_m');
        $this->load->model('bookissue_m');
        $lang = 'indonesia';
        $this->lang->load('profile', $lang);
    }

    public function index()
    {
        $memberID = $this->session->userdata('loginmemberID');
		$this->data['get_title'] = 'Profile | '.$this->data['pengaturan_umum']->sitename;
		
		
        if ((int) $memberID) {
            $this->data['anggota'] = $this->member_m->get_single_member(array('id_anggota' => $memberID));
            if (calculate($this->data['anggota'])) {
                $this->data['kategori_buku'] = pluck($this->bookcategory_m->get_bookcategory(), 'nama', 'bookcategoryID');
                $this->data['buku']         = pluck($this->book_m->get_book(), 'nama', 'id_buku');
                $this->data['bookissues']   = $this->bookissue_m->get_order_by_bookissue(['dihapus_pada' => 0, 'id_anggota' => $memberID]);
                $this->data['peran']         = $this->role_m->get_single_role(array('id_peran' => $this->data['anggota']->id_peran));
                $this->data["subview"]      = "profile/index";
                $this->load->view('_main_layout', $this->data);
            } else {
                $this->data["subview"] = "_not_found";
                $this->load->view('_main_layout', $this->data);
            }
        } else {
            $this->data["subview"] = "_not_found";
            $this->load->view('_main_layout', $this->data);
        }
    }

}
