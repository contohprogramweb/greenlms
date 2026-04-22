<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bukureport extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Buku_m');
        $this->load->model('Itembuku_m');
        $this->load->model('Kategoribuku_m');
        $this->load->library('pdf');

        $lang = 'indonesia';
        $this->lang->load('bookreport', $lang);
    }

    public function index()
    {
        $this->data['headerassets'] = array(
            'js' => array(
                'assets/custom/js/bookreport.js',
            ),
        );
		
		$this->data['get_title'] = 'Laporan Data Buku | '.$this->data['pengaturan_umum']->sitename;

        $this->data['flag']           = 0;
        $this->data['bookcategoryID'] = 0;
        $this->data['id_buku']         = 0;
        $this->data['status']         = 0;

        $this->data['books']         = [];
        $this->data['bookcategorys'] = pluck($this->kategoribuku_m->get_bookcategory(), 'obj', 'bookcategoryID');
        unset($_SESSION['error']);
        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $message = implode('<br/>', $this->form_validation->error_array());
                $this->session->set_flashdata('error', $message);
                $this->data["subview"] = "laporan/buku/index";
                $this->load->view('_main_layout', $this->data);
            } else {
                $bookcategoryID = $this->input->post('bookcategoryID');
                $bookID         = $this->input->post('id_buku');
                $status         = $this->input->post('status');

                $this->_queryArray(['bookcategoryID' => $bookcategoryID, 'id_buku' => $bookID, 'status' => $status]);

                $this->data["subview"] = "laporan/buku/index";
                $this->load->view('_main_layout', $this->data);
            }
        } else {
            $this->data["subview"] = "laporan/buku/index";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function pdf()
    {
        $bookcategoryID = htmlentities(escapeString($this->uri->segment(3)));
        $bookID         = htmlentities(escapeString($this->uri->segment(4)));
        $status         = htmlentities(escapeString($this->uri->segment(5)));

        if (((int) $bookcategoryID || $bookcategoryID == 0) && ((int) $bookID || $bookID == 0) && ((int) $status || $status == 0)) {

            $this->_queryArray(['bookcategoryID' => $bookcategoryID, 'id_buku' => $bookID, 'status' => $status]);
            $this->data['bookcategorys'] = pluck($this->kategoribuku_m->get_bookcategory(), 'obj', 'bookcategoryID');

            $this->pdf->create(['stylesheet' => 'bookreport.css', 'view' => 'laporan/buku/pdf.php', 'data' => $this->data]);
        } else {
            $this->data["subview"] = "_not_found";
            $this->load->view('_main_layout', $this->data);
        }
    }

    private function _queryArray($queryArr)
    {
        extract($queryArr);

        $queryArray = [];
        $itemArray  = [];
        if ((int) $bookcategoryID) {
            $queryArray['bookcategoryID'] = $bookcategoryID;
        }
        if ((int) $bookID) {
            $queryArray['id_buku'] = $bookID;
            $itemArray['id_buku']  = $bookID;
        }
        if ((int) $status) {
            $queryArray['status'] = $status - 1;
        }
        $itemArray['status']     = 0;
        $itemArray['dihapus_pada'] = 0;

        $books     = $this->buku_m->get_order_by_book_for_report($queryArray);
        $bookitems = $this->itembuku_m->get_order_by_bookitem($itemArray);

        $bookQuantity = [];
        if (calculate($bookitems)) {
            foreach ($bookitems as $item_buku) {
                if (isset($bookQuantity[$item_buku->id_buku])) {
                    $bookQuantity[$item_buku->id_buku]++;
                } else {
                    $bookQuantity[$item_buku->id_buku] = 1;
                }
            }
        }

        $this->data['flag']           = 1;
        $this->data['bookcategoryID'] = $bookcategoryID;
        $this->data['id_buku']         = $bookID;
        $this->data['status']         = $status;
        $this->data['bookQuantity']   = $bookQuantity;
        $this->data['books']          = $books;
    }

    public function get_book()
    {
        echo "<option value='0'>" . $this->lang->line('bookreport_please_select') . "</option>";
        if ($_POST && permissionChecker('bookreport')) {
            $bookcategoryID          = $this->input->post('bookcategoryID');
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
	
	
	public function get_book_depan()
    {
        echo "<option value='0'>" . $this->lang->line('bookreport_please_select') . "</option>";
        
            $bookcategoryID          = $this->input->post('bookcategoryID');
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
	

    private function rules()
    {
        $rules = array(
            array(
                'field' => 'bookcategoryID',
                'label' => $this->lang->line('bookreport_book_category'),
                'rules' => 'trim|xss_clean|required|numeric',
            ),
            array(
                'field' => 'id_buku',
                'label' => $this->lang->line('bookreport_book'),
                'rules' => 'trim|xss_clean|required|numeric',
            ),
            array(
                'field' => 'status',
                'label' => $this->lang->line('bookreport_status'),
                'rules' => 'trim|xss_clean|required|numeric',
            ),
        );
        return $rules;
    }

}
