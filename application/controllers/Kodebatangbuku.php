<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bukubarcode extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Buku_m');
        $this->load->model('Itembuku_m');
        $this->load->model('Kategoribuku_m');
        $this->load->library('barcode');
        $this->load->library('pdf');

        $lang = 'indonesia';
        $this->lang->load('bookbarcode', $lang);
    }

    public function index()
    {
        $this->data['headerassets'] = array(
            'js' => array(
                'assets/custom/js/bookbarcode.js',
            ),
        );
		
		$this->data['get_title'] = 'Barcode Buku | '.$this->data['pengaturan_umum']->sitename;

        $this->data['flag']           = 0;
        $this->data['bookcategoryID'] = 0;
        $this->data['id_buku']         = 0;

        $this->data['books']         = [];
        $this->data['bookcategorys'] = pluck($this->kategoribuku_m->get_bookcategory(), 'obj', 'bookcategoryID');
        unset($_SESSION['error']);
        if ($_POST) {
            $bookcategoryID = $this->input->post('bookcategoryID');
            $bookID         = $this->input->post('id_buku');

            $array['status']         = 0;
            $array['dihapus_pada']     = 0;
            $array['bookcategoryID'] = $bookcategoryID;
            if ((int) $bookcategoryID) {
                $this->data['books'] = $this->buku_m->get_order_by_book($array, array('id_buku', 'nama', 'codeno'));
            }

            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $message = implode('<br/>', $this->form_validation->error_array());
                $this->session->set_flashdata('error', $message);
                $this->data["subview"] = "kodebatangbuku/index";
            } else {

                $this->_queryArray(['bookcategoryID' => $bookcategoryID, 'id_buku' => $bookID]);

                $this->data["subview"] = "kodebatangbuku/index";
            }
        } else {
            $this->data["subview"] = "kodebatangbuku/index";
        }
        $this->load->view('_main_layout', $this->data);
    }

    public function pdf()
    {
        $bookcategoryID = htmlentities(escapeString($this->uri->segment(3)));
        $bookID         = htmlentities(escapeString($this->uri->segment(4)));

        if (((int) $bookcategoryID || $bookcategoryID == 0) && ((int) $bookID || $bookID == 0)) {

            $this->_queryArray(['bookcategoryID' => $bookcategoryID, 'id_buku' => $bookID]);

            $this->pdf->create(['stylesheet' => 'bookbarcode.css', 'view' => 'kodebatangbuku/pdf.php', 'data' => $this->data]);
        } else {
            $this->data["subview"] = "_not_found";
            $this->load->view('_main_layout', $this->data);
        }
    }

    private function _queryArray($queryArr)
    {
        extract($queryArr);

        $queryArray = [];
        if ((int) $bookID) {
            $queryArray['id_buku'] = $bookID;
        }
        $queryArray['status !=']  = 2;
        $queryArray['dihapus_pada'] = 0;

        $buku      = $this->buku_m->get_single_book(['id_buku' => $bookID]);
        $bookitems = $this->itembuku_m->get_order_by_bookitem($queryArray);

        $this->generatebarcode($buku, $bookitems);

        $this->data['flag']           = 1;
        $this->data['bookcategoryID'] = $bookcategoryID;
        $this->data['id_buku']         = $bookID;
        $this->data['buku']           = $buku;
        $this->data['bookitems']      = $bookitems;
    }

    public function get_book()
    {
        echo "<option value='0'>" . $this->lang->line('bookbarcode_please_select') . "</option>";
        if ($_POST && permissionChecker('bookbarcode')) {
            $bookcategoryID          = $this->input->post('bookcategoryID');
            $array['status']         = 0;
            $array['dihapus_pada']     = 0;
            $array['bookcategoryID'] = $bookcategoryID;

            if ((int) $bookcategoryID) {
                $books = $this->buku_m->get_order_by_book($array, array('id_buku', 'nama', 'codeno'));
                if (calculate($books)) {
                    foreach ($books as $buku) {
                        echo "<option value='" . $buku->id_buku . "'>" . $buku->nama . ' - ' . $buku->codeno . "</option>";
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
                'label' => $this->lang->line('bookbarcode_book_category'),
                'rules' => 'trim|xss_clean|required|numeric|required_no_zero',
            ),
            array(
                'field' => 'id_buku',
                'label' => $this->lang->line('bookbarcode_book'),
                'rules' => 'trim|xss_clean|required|numeric|required_no_zero',
            ),
        );
        return $rules;
    }

    private function generatebarcode($buku, $bookitems)
    {
        if(!calculate($buku)) {
            $this->session->set_flashdata('error', 'Some Thing Wrong');
            redirect(base_url('Kodebatangbuku/index'));
        }

        if (calculate($bookitems)) {
            foreach ($bookitems as $item_buku) {
                $bookitembarcode = $buku->codeno.'-'.$item_buku->bookno;
                $this->barcode->generate($bookitembarcode, $bookitembarcode, 'uploads/Kodebatangbuku/');
            }
        }
    }

}
