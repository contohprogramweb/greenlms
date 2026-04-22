<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profil extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Anggota_m');
        $this->load->model('Peran_m');
        $this->load->model('Kategoribuku_m');
        $this->load->model('Buku_m');
        $this->load->model('Peminjamanbuku_m');
        $lang = 'indonesia';
        $this->lang->load('profile', $lang);
    }

    public function index()
    {
        $memberID = $this->session->userdata('loginmemberID');
		$this->data['get_title'] = 'Profile | '.$this->data['pengaturan_umum']->sitename;
		
		
        if ((int) $memberID) {
            $this->data['anggota'] = $this->anggota_m->get_single_member(array('id_anggota' => $memberID));
            if (calculate($this->data['anggota'])) {
                $this->data['kategori_buku'] = pluck($this->kategoribuku_m->get_bookcategory(), 'nama', 'bookcategoryID');
                $this->data['buku']         = pluck($this->buku_m->get_book(), 'nama', 'id_buku');
                $this->data['bookissues']   = $this->peminjamanbuku_m->get_order_by_bookissue(['dihapus_pada' => 0, 'id_anggota' => $memberID]);
                $this->data['peran']         = $this->peran_m->get_single_role(array('id_peran' => $this->data['anggota']->id_peran));
                $this->data["subview"]      = "profil/index";
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
