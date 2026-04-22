<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Beranda extends Beranda_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Bukuelektronik_m');
        $this->load->model('Toko_buku_m');
        $this->load->model('Buletin_m');
        $this->load->model('Kategoribuku_m');
        $this->load->model('Tokokategoribuku_m');
        $this->load->model('Buku_m');
        $this->load->model('Itembuku_m');
        $this->load->model('Pesanan_m');
        $this->load->model('Itempesanan_m');
        $this->load->model('Gambar_toko_buku_m');
        $this->load->library('applications');
        $this->load->library('pagination');
        $this->load->library('paypal_lib');

        $lang = 'indonesia';
        $this->lang->load('frontend', $lang);
    }

    public function index()
    {
		$this->data['get_title'] = 'Home | '.$this->data['pengaturan_umum']->sitename;
		
        $this->data['bookcategorys']      = $this->kategoribuku_m->get_bookcategory();
        $this->data['storebookcategorys'] = $this->tokokategoribuku_m->get_storebookcategory();
        $this->data["subview"]            = "beranda/index";
        $this->load->view('_frontend_layout', $this->data);
    }

    // Ebook
    public function buku_elektronik()
    {
        $ebookID                    = htmlentities(escapeString($this->uri->segment(3)));
        $this->data['headerassets'] = array(
            'css' => array(
                'assets/custom/css/buku_elektronik.css',
            ),
        );
		
		$this->data['get_title'] = 'Ebook | '.$this->data['pengaturan_umum']->sitename;

        $search = $this->input->get('search');
        if (empty($search)) {
            $buku_elektronik = calculate($this->bukuelektronik_m->get_ebook());
        } else {
            $buku_elektronik = calculate($this->bukuelektronik_m->get_ebook_search($search));
        }

        $config['base_url']           = base_url('Beranda/buku_elektronik');
        $config['total_rows']         = $buku_elektronik;
        $config['per_page']           = 12;
        $config['num_links']          = 5;
        $config['full_tag_open']      = '<ul class="pagination">';
        $config['full_tag_close']     = '</ul>';
        $config['attributes']         = ['class' => 'page-link'];
        $config['first_link']         = false;
        $config['last_link']          = false;
        $config['first_tag_open']     = '<li class="page-item">';
        $config['first_tag_close']    = '</li>';
        $config['prev_link']          = '&laquo Previous';
        $config['prev_tag_open']      = '<li class="page-item">';
        $config['prev_tag_close']     = '</li>';
        $config['next_link']          = 'Next &raquo';
        $config['next_tag_open']      = '<li class="page-item">';
        $config['next_tag_close']     = '</li>';
        $config['last_tag_open']      = '<li class="page-item">';
        $config['last_tag_close']     = '</li>';
        $config['cur_tag_open']       = '<li class="page-item active"><a href="#" class="page-link">';
        $config['cur_tag_close']      = '<span class="sr-only">(current)</span></a></li>';
        $config['num_tag_open']       = '<li class="page-item">';
        $config['num_tag_close']      = '</li>';
        $config['reuse_query_string'] = true;

        $this->pagination->initialize($config);

        if (empty($search)) {
            $this->data["ebooks"] = $this->bukuelektronik_m->get_order_by_ebook_limit($config['per_page'], $ebookID);
        } else {
            $this->data["ebooks"] = $this->bukuelektronik_m->get_order_by_ebook_limit_search($config['per_page'], $ebookID, $search);
        }
        $this->data['search'] = $search;

        $this->data["subview"] = "beranda/buku_elektronik";
        $this->load->view('_frontend_layout', $this->data);
    }

    public function ebookview()
    {
        $ebookID = htmlentities(escapeString($this->uri->segment(3)));
		$this->data['get_title'] = 'Detail Ebook | '.$this->data['pengaturan_umum']->sitename;
		
        if ((int) $ebookID) {
            $this->data['buku_elektronik'] = $this->bukuelektronik_m->get_single_ebook(array('id_buku_elektronik' => $ebookID));
            if (calculate($this->data['buku_elektronik'])) {
                $fileimg = FCPATH . '/uploads/buku_elektronik/' . $this->data['buku_elektronik']->file;
                if (!file_exists($fileimg)) {
                    $this->session->set_flashdata('error', 'The Book file is not found');
                    redirect(base_url('Beranda/buku_elektronik'));
                } else {
                    $this->data['headerassets'] = array(
                        'headerjs' => array(
                            'assets/custom/js/pdfobject.min.js',
                        ),
                    );
                    $this->data["subview"] = "beranda/ebookview";
                    $this->load->view('_frontend_layout', $this->data);
                }
            } else {
                $this->session->set_flashdata('error', 'The Book file is not found');
                redirect(base_url('Beranda/buku_elektronik'));
            }
        } else {
            $this->session->set_flashdata('error', 'The Book file is not found');
            redirect(base_url('Beranda/buku_elektronik'));
        }
    }

    public function ebookdownload()
    {
        if ($this->data['pengaturan_umum']->ebook_download != 1) {
            $this->session->set_flashdata('error', "You dont have permission to download this buku_elektronik.");
            redirect(base_url('Beranda/buku_elektronik'));
        }
        $ebookID = htmlentities(escapeString($this->uri->segment(3)));
		
        if ((int) $ebookID) {
            $buku_elektronik = $this->bukuelektronik_m->get_single_ebook(array('id_buku_elektronik' => $ebookID));
            if (calculate($buku_elektronik)) {
                $file = realpath('uploads/buku_elektronik/' . $buku_elektronik->file);
                if (file_exists($file)) {
                    $originalname = $buku_elektronik->file_original_name;
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename="' . basename($originalname) . '"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));
                    readfile($file);
                    exit;
                } else {
                    $this->session->set_flashdata('error', 'The Book file is not found');
                    redirect(base_url('Beranda/buku_elektronik'));
                }
            } else {
                $this->session->set_flashdata('error', 'The Book file is not found');
                redirect(base_url('Beranda/buku_elektronik'));
            }
        } else {
            $this->session->set_flashdata('error', 'The Book file is not found');
            redirect(base_url('Beranda/buku_elektronik'));
        }
    }

    // Book
    public function buku()
    {
        $this->data['headerassets'] = array(
            'js' => array(
                'assets/custom/js/bookreport.js',
            ),
        );
		
		$this->data['get_title'] = 'Buku | '.$this->data['pengaturan_umum']->sitename;

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
            }
        }
        $this->data["subview"] = "beranda/buku";
        $this->load->view('_frontend_layout', $this->data);
    }
	
	
	public function book_category()
    {
        $this->data['headerassets'] = array(
            'js' => array(
                'assets/custom/js/bookreport.js',
            ),
        );
		
		$this->data['get_title'] = 'Buku | '.$this->data['pengaturan_umum']->sitename;

		 
		
        $this->data['flag']           = 0;
        $this->data['bookcategoryID'] = $this->uri->segment(3);
        $this->data['id_buku']         = 0;
        $this->data['status']         = 0;

        $this->data['books']         = [];
        $this->data['bookcategorys'] = pluck($this->kategoribuku_m->get_bookcategory(), 'obj', 'bookcategoryID');
        unset($_SESSION['error']);
         
           
		$bookcategoryID = $this->uri->segment(3);
		$bookID         = $this->input->post('id_buku');
		$status         = $this->input->post('status');

		$this->_queryArray(['bookcategoryID' => $bookcategoryID, 'id_buku' => $bookID, 'status' => $status]);
             
        
        $this->data["subview"] = "beranda/buku";
        $this->load->view('_frontend_layout', $this->data);
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
        echo "<option value='0'>" . $this->lang->line('frontend_please_select') . "</option>";
        if ($_POST) {
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

    private function rules()
    {
        $rules = array(
            array(
                'field' => 'bookcategoryID',
                'label' => $this->lang->line('frontend_book_category'),
                'rules' => 'trim|xss_clean|required|numeric',
            ),
            array(
                'field' => 'id_buku',
                'label' => $this->lang->line('frontend_book'),
                'rules' => 'trim|xss_clean|required|numeric',
            ),
            array(
                'field' => 'status',
                'label' => $this->lang->line('frontend_status'),
                'rules' => 'trim|xss_clean|required|numeric',
            ),
        );
        return $rules;
    }

    // Shop
    public function shop()
    {
		
		$this->data['get_title'] = 'Toko Buku | '.$this->data['pengaturan_umum']->sitename;
		
        $storebookID = htmlentities(escapeString($this->uri->segment(3)));
        $search      = $this->input->get('search');
        $category    = $this->input->get('category');

        $queryArray = [];
        if (!empty($search)) {
            $queryArray['search'] = $search;
        } else if (!empty($category)) {
            $queryArray['category'] = $category;
        }

        if (calculate($queryArray)) {
            $buku_toko = calculate($this->toko_buku_m->get_storebook_search($queryArray));
        } else {
            $buku_toko = calculate($this->toko_buku_m->get_storebook());
        }

        $config['base_url']           = base_url('Beranda/shop');
        $config['total_rows']         = $buku_toko;
        $config['per_page']           = 12;
        $config['num_links']          = 5;
        $config['full_tag_open']      = '<ul class="pagination">';
        $config['full_tag_close']     = '</ul>';
        $config['attributes']         = ['class' => 'page-link'];
        $config['first_link']         = false;
        $config['last_link']          = false;
        $config['first_tag_open']     = '<li class="page-item">';
        $config['first_tag_close']    = '</li>';
        $config['prev_link']          = '&laquo Previous';
        $config['prev_tag_open']      = '<li class="page-item">';
        $config['prev_tag_close']     = '</li>';
        $config['next_link']          = 'Next &raquo';
        $config['next_tag_open']      = '<li class="page-item">';
        $config['next_tag_close']     = '</li>';
        $config['last_tag_open']      = '<li class="page-item">';
        $config['last_tag_close']     = '</li>';
        $config['cur_tag_open']       = '<li class="page-item active"><a href="#" class="page-link">';
        $config['cur_tag_close']      = '<span class="sr-only">(current)</span></a></li>';
        $config['num_tag_open']       = '<li class="page-item">';
        $config['num_tag_close']      = '</li>';
        $config['reuse_query_string'] = true;

        $this->pagination->initialize($config);

        if (calculate($queryArray)) {
            $this->data["storebooks"] = $this->toko_buku_m->get_order_by_storebook_limit_search($config['per_page'], $storebookID, $queryArray);
        } else {
            $this->data["storebooks"] = $this->toko_buku_m->get_order_by_storebook_limit($config['per_page'], $storebookID);
        }
        $this->data['storebookcategorys'] = $this->tokokategoribuku_m->get_storebookcategory();

        $this->data['search']  = $search;
        $this->data["subview"] = "beranda/shop";
        $this->load->view('_frontend_layout', $this->data);
    }

    public function single($storebookID)
    {
		$this->data['get_title']	 	= 'Detail Data Buku | '.$this->data['pengaturan_umum']->sitename;
		
        $this->data['buku_toko']       = $this->toko_buku_m->get_single_storebook($storebookID);
        $this->data['storebookimages'] = $this->gambar_toko_buku_m->get_order_by_storebookimage(['storebookID' => $storebookID]);
        $this->data["subview"]         = "beranda/single";
        $this->load->view('_frontend_layout', $this->data);
    }

    // Cart
    public function cart()
    {
        if (calculate($this->data["cart_contents"])) {
            $this->data["subview"] = "beranda/cart";
            $this->load->view('_frontend_layout', $this->data);
        } else {
            $this->session->set_flashdata('error', $this->lang->line('frontend_cart_empty'));
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function addcart()
    {
        $storebookID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $storebookID) {
            $buku_toko = $this->toko_buku_m->get_single_storebook($storebookID);
            if (calculate($buku_toko)) {
                $qty = $this->input->post('qty') ? $this->input->post('qty') : 1;

                if ($this->checkOrderQuantity($buku_toko, $qty)) {
                    $data = array(
                        'id'     => $buku_toko->storebookID,
                        'nama'   => $buku_toko->nama,
                        'images' => app_image_link($buku_toko->coverphoto, 'uploads/buku_toko/', 'buku_toko.jpg'),
                        'harga'  => $buku_toko->harga,
                        'qty'    => $qty,
                    );
                    $this->cart->insert($data);
                    $this->session->set_flashdata('success', 'This product added cart successfully.');
                } else {
                    $this->session->set_flashdata('error', 'This buku are not out of stock.');
                }
            } else {
                $this->session->set_flashdata('error', 'This buku is not found.');
            }
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    private function checkOrderQuantity($buku_toko, $qty)
    {
        $orderQuantity = $this->itempesanan_m->get_order_by_orderitem_with_sum(['storebookID' => $buku_toko->storebookID]) + $qty;
        if ($orderQuantity <= $buku_toko->jumlah) {
            return true;
        }
        return false;
    }

    public function removecart()
    {

        $rowID = htmlentities(escapeString($this->uri->segment(3)));
        if (!empty($rowID)) {
            $this->cart->remove($rowID);
            $this->session->set_flashdata('success', 'This product removed from cart successfully.');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function checkout()
    {
		$this->data['get_title'] = 'Checkout | '.$this->data['pengaturan_umum']->sitename;
		
        $cart_contents = $this->cart->contents();
        if (!calculate($cart_contents)) {
            $this->session->set_flashdata('error', $this->lang->line('frontend_cart_empty'));
            redirect($_SERVER['HTTP_REFERER']);
        }

        if ($_POST) {
            $rules = $this->rules_checkout();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->data["subview"] = "beranda/checkout";
                $this->load->view('_frontend_layout', $this->data);
            } else {
                $order['id_anggota']         = $this->session->userdata('loginmemberID');
                $order['nama']             = $this->input->post('nama');
                $order['seluler']           = $this->input->post('seluler');
                $order['surel']            = $this->input->post('surel');
                $order['alamat']          = $this->input->post('alamat');
                $order['delivery_charge']  = $this->data['pengaturan_umum']->delivery_charge;
                $order['subtotal']         = $this->cart->total();
                $order['total']            = $this->cart->total() + $order['delivery_charge'];
                $order['payment_status']   = 5;
                $order['payment_method']   = $this->input->post('payment_method');
                $order['paid_amount']      = 0;
                $order['discounted_price'] = 0;
                $order['status']           = 5;
                $order['notes']            = $this->input->post('notes');
                $order['tanggal_dibuat']      = date('Y-m-d H:i:s');
                $order['modify_date']      = date('Y-m-d H:i:s');

                $this->pesanan_m->insert_order($order);
                $orderID = $this->db->insert_id();

                foreach ($cart_contents as $cart_content) {
                    $orderitem['id_pesanan']     = $orderID;
                    $orderitem['storebookID'] = $cart_content['id'];
                    $orderitem['jumlah']    = $cart_content['qty'];
                    $orderitem['unit_price']  = $cart_content['harga'];
                    $orderitem['subtotal']    = $cart_content['subtotal'];
                    $orderitem['tanggal_dibuat'] = date('Y-m-d H:i:s');
                    $orderitem['modify_date'] = date('Y-m-d H:i:s');

                    $this->itempesanan_m->insert_orderitem($orderitem);
                }
                $this->cart->destroy();
                $this->session->set_userdata('stripeToken', $this->input->post('stripeToken'));
                redirect(base_url('Beranda/payment/' . $orderID));
            }
        } else {
            $this->data["subview"] = "beranda/checkout";
            $this->load->view('_frontend_layout', $this->data);
        }
    }

    public function payment($orderID)
    {
        $order          = $this->pesanan_m->get_single_order(['id_pesanan' => $orderID]);
        $payment_method = $order->payment_method;

        if ($payment_method == 5) {
            $this->session->set_flashdata('success', 'Your order created successfully.');
            redirect(base_url('Akunsaya/orderview/' . $orderID));
        } else if ($payment_method == 10) {
            $this->paypal($order);
        } else if ($payment_method == 15) {
            // $this->paypal($order);
        } else if ($payment_method == 20) {
            $this->stripe($order);
        }
    }

    // Paypal payment
    private function paypal($order)
    {
        //Set variables for paypal form
        $returnURL = base_url('Beranda/paypalsuccess'); //payment success url
        $failURL   = base_url('Beranda/paypalfail'); //payment fail url
        $notifyURL = base_url('Beranda/paypalipn'); //ipn url

        //get particular product data
        $this->session->set_userdata('id_pesanan', $order->id_pesanan);
        $userID = $this->session->userdata('loginmemberID'); //current user id
        $logo   = app_image_link($this->data['pengaturan_umum']->logo, 'uploads/images/', 'logo.jpg');

        $this->paypal_lib->add_field('return', $returnURL);
        $this->paypal_lib->add_field('fail_return', $failURL);
        $this->paypal_lib->add_field('notify_url', $notifyURL);

        $this->paypal_lib->add_field('item_name', 'Order Item');
        $this->paypal_lib->add_field('jumlah', $order->total);
        $this->paypal_lib->add_field('item_number', $order->id_pesanan);
        $this->paypal_lib->add_field('custom', $userID);
        $this->paypal_lib->image($logo);

        $this->paypal_lib->paypal_auto_form();
    }

    public function paypalsuccess()
    {
        $paypalInfo = $this->input->get();
        if (empty($paypalInfo)) {
            $this->session->set_flashdata('error', 'Your try to access invalid url.');
            redirect(base_url('Akunsaya/order'));
        }

        $orderID = $this->session->userdata('id_pesanan');

        $miscArray['item_number']   = $orderID;
        $miscArray['txn_id']        = $paypalInfo["tx"];
        $miscArray['payment_amt']   = $paypalInfo["amt"];
        $miscArray['currency_code'] = $paypalInfo["cc"];
        $miscArray['status']        = $paypalInfo["st"];

        $order = $this->pesanan_m->get_single_order(['id_pesanan' => $orderID]);
        if (calculate($order)) {
            $updateArray['misc']           = json_encode($miscArray);
            $updateArray['paid_amount']    = $paypalInfo["amt"];
            $updateArray['payment_status'] = 10;
            if ($order->total == $updateArray['paid_amount']) {
                $updateArray['payment_status'] = 15;
            }
            $this->pesanan_m->update_order($updateArray, $orderID);
        }
        $this->session->set_flashdata('success', 'Your order payment successfully paid.');
        redirect(base_url('Akunsaya/orderview/' . $order->id_pesanan));
    }

    public function paypalfail()
    {
        $this->session->set_flashdata('error', 'Your order payment fail.');
        redirect(base_url('Akunsaya/order'));
    }

    public function paypalipn()
    {
        $this->session->set_flashdata('error', 'Your order payment ipn.');
        redirect(base_url('Akunsaya/order'));
    }

    // Paypal payment
    private function stripe($order)
    {
        try {
            require_once 'vendor/stripe/stripe-php/init.php';

            $stripeSecret = $this->config->item('stripe_secret');

            \Stripe\Stripe::setApiKey($stripeSecret);
            $charge = \Stripe\Charge::create([
                'jumlah'      => (int) $order->total,
                "currency"    => "usd",
                "source"      => $this->session->userdata('stripeToken'),
                'deskripsi' => $order->notes,
            ]);

            if (!empty($charge) && $charge['amount_refunded'] == 0 && empty($charge['failure_code']) && $charge['paid'] == 1 && $charge['captured'] == 1) {
                $paidAmount                    = $charge['jumlah'];
                $updateArray['paid_amount']    = $paidAmount;
                $updateArray['payment_status'] = 10;
                if ($order->total == $updateArray['paid_amount']) {
                    $updateArray['payment_status'] = 15;
                }
                $this->pesanan_m->update_order($updateArray, $order->id_pesanan);
            }
            $this->session->set_flashdata('success', 'Your order payment successfully paid.');
            redirect(base_url('Akunsaya/orderview/' . $order->id_pesanan));
        } catch (Exception $e) {
            $this->session->set_flashdata('error', $e->getMessage());
            redirect(base_url('Akunsaya/orderview/' . $order->id_pesanan));
        }

    }

    private function rules_checkout()
    {
        $rules = array(
            array(
                'field' => 'nama',
                'label' => $this->lang->line('frontend_name'),
                'rules' => 'trim|xss_clean|required',
            ),
            array(
                'field' => 'seluler',
                'label' => $this->lang->line('frontend_mobile'),
                'rules' => 'trim|xss_clean|required',
            ),
            array(
                'field' => 'surel',
                'label' => $this->lang->line('frontend_email'),
                'rules' => 'trim|xss_clean|required|valid_email',
            ),
            array(
                'field' => 'alamat',
                'label' => $this->lang->line('frontend_address'),
                'rules' => 'trim|xss_clean|required',
            ),
            array(
                'field' => 'notes',
                'label' => $this->lang->line('frontend_notes'),
                'rules' => 'trim|xss_clean|required',
            ),
            array(
                'field' => 'payment_method',
                'label' => $this->lang->line('frontend_payment_method'),
                'rules' => 'trim|xss_clean|required',
            ),
        );
        return $rules;
    }

    //// Contacnt Page
    public function contact()
    {
		$this->data['get_title'] = 'Kontak | '.$this->data['pengaturan_umum']->sitename;
		
        if ($_POST) {
            $rules = $this->rules_contact();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->data["subview"] = "beranda/contact";
                $this->load->view('_frontend_layout', $this->data);
            } else {
                $name      = $this->input->post('nama');
                $fromemail = $this->input->post('surel');
                $subject   = $this->input->post('subjek');
                $message   = $this->input->post('pesan');
                $toemail   = $this->session->userdata('surel');

                $sendmail = $this->applications->sendmail($toemail, $message, $subject, $name, $fromemail);
                if ($sendmail) {
                    $this->session->set_flashdata('success', $this->lang->line('frontend_email_send'));
                } else {
                    $this->session->set_flashdata('error', $this->lang->line('frontend_email_fail'));
                }
                redirect(base_url('Beranda/contact'));
            }
        } else {
            $this->data["subview"] = "beranda/contact";
            $this->load->view('_frontend_layout', $this->data);
        }
    }

    private function rules_contact()
    {
        $rules = array(
            array(
                'field' => 'nama',
                'label' => $this->lang->line('frontend_name'),
                'rules' => 'trim|xss_clean|required',
            ),
            array(
                'field' => 'surel',
                'label' => $this->lang->line('frontend_email'),
                'rules' => 'trim|xss_clean|required|valid_email',
            ),
            array(
                'field' => 'subjek',
                'label' => $this->lang->line('frontend_subject'),
                'rules' => 'trim|xss_clean|required',
            ),
            array(
                'field' => 'pesan',
                'label' => $this->lang->line('frontend_message'),
                'rules' => 'trim|xss_clean|required',
            ),
        );
        return $rules;
    }

    // Newsletter
    public function subscribe()
    {
        if ($_POST) {
            $rules = $this->rules_subscribe();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $message = implode('<br/>', $this->form_validation->error_array());
                $this->session->set_flashdata('error', $message);
            } else {
                $buletin = $this->buletin_m->get_single_newsletter(['surel' => $this->input->post('surel')]);
                if (!calculate($buletin)) {
                    $this->buletin_m->insert_newsletter(['surel' => $this->input->post('surel')]);
                }
                $this->session->set_flashdata('success', 'Success');
            }
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    private function rules_subscribe()
    {
        $rules = array(
            array(
                'field' => 'surel',
                'label' => $this->lang->line('frontend_subsciption'),
                'rules' => 'trim|xss_clean|required|valid_email',
            ),
        );
        return $rules;
    }

}
