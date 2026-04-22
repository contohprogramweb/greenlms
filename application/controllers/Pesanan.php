<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesanan extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pesanan_m');
        $this->load->model('Anggota_m');
        $this->load->model('Itempesanan_m');
        $this->load->library('paypal_lib');

        $lang = 'indonesia';
        $this->lang->load('order', $lang);
    }

    public function index()
    {
        $this->data['headerassets'] = array(
            'css'      => array(
                'assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css',
                'assets/custom/css/hidetable.css',
            ),
            'headerjs' => array(
                'assets/plugins/datatables.net/js/jquery.dataTables.min.js',
                'assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js',
            ),
        );
		$this->data['get_title'] = 'Kelola Pesanan | '.$this->data['pengaturan_umum']->sitename;
        $this->data['pesanan']  = $this->pesanan_m->get_order_by_order();
        $this->data["subview"] = "pesanan/index";
        $this->load->view('_main_layout', $this->data);
    }

    public function view()
    {
        $orderID = htmlentities(escapeString($this->uri->segment(3)));
		$this->data['get_title'] = 'Lihat Data Pesanan | '.$this->data['pengaturan_umum']->sitename;
		
        if ((int) $orderID) {
            $order = $this->pesanan_m->get_single_order(array('id_pesanan' => $orderID));
            if (calculate($order)) {
                $this->data['order']      = $order;
                $this->data['anggota']     = $this->anggota_m->get_single_member(['id_anggota' => $order->id_anggota]);
                $this->data['item_pesanan'] = $this->itempesanan_m->get_order_by_orderitem_with_storebook(['id_pesanan' => $orderID]);
                $this->data["subview"]    = "pesanan/view";
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

    public function edit()
    {
        $orderID = htmlentities(escapeString($this->uri->segment(3)));
		$this->data['get_title'] = 'Edit Pesanan | '.$this->data['pengaturan_umum']->sitename;
		
        if ((int) $orderID) {
            $order = $this->pesanan_m->get_single_order(array('id_pesanan' => $orderID));
            if (calculate($order)) {
                $this->data['order']      = $order;
                $this->data['anggota']     = $this->anggota_m->get_single_member(['id_anggota' => $order->id_anggota]);
                $this->data['item_pesanan'] = $this->itempesanan_m->get_order_by_orderitem_with_storebook(['id_pesanan' => $orderID]);
                if ($_POST) {
                    $rules = $this->rules();
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == false) {
                        $this->data["subview"] = "pesanan/edit";
                        $this->load->view('_main_layout', $this->data);
                    } else {
                        $array['status'] = $this->input->post('status');
                        $this->pesanan_m->update_order($array, $order->id_pesanan);
                        $this->session->set_flashdata('success', 'Success');
                        redirect(base_url('Pesanan/view/' . $order->id_pesanan));
                    }
                } else {
                    $this->data["subview"] = "pesanan/edit";
                    $this->load->view('_main_layout', $this->data);
                }
            } else {
                $this->data["subview"] = "_not_found";
                $this->load->view('_main_layout', $this->data);
            }
        } else {
            $this->data["subview"] = "_not_found";
            $this->load->view('_main_layout', $this->data);
        }
    }

    private function rules()
    {
        $rules = array(
            array(
                'field' => 'status',
                'label' => $this->lang->line('order_status'),
                'rules' => 'trim|xss_clean|required|numeric|required_no_zero',
            ),
        );
        return $rules;
    }

    public function payment()
    {
        $orderID = htmlentities(escapeString($this->uri->segment(3)));
		$this->data['get_title'] = 'Pembayaran Pesanan | '.$this->data['pengaturan_umum']->sitename;
		
        if ((int) $orderID) {
            $order = $this->pesanan_m->get_single_order(array('id_pesanan' => $orderID));
            if (calculate($order)) {
                $this->data['order']      = $order;
                $this->data['anggota']     = $this->anggota_m->get_single_member(['id_anggota' => $order->id_anggota]);
                $this->data['item_pesanan'] = $this->itempesanan_m->get_order_by_orderitem_with_storebook(['id_pesanan' => $orderID]);
                if ($_POST) {
                    $rules = $this->payment_rules();
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == false) {
                        $this->data["subview"] = "pesanan/payment";
                        $this->load->view('_main_layout', $this->data);
                    } else {
                        $array['payment_method'] = $this->input->post('payment_method');
                        $this->pesanan_m->update_order($array, $orderID);

                        $this->session->set_userdata('stripeToken', $this->input->post('stripeToken'));
                        redirect(base_url('Pesanan/payments/' . $orderID));
                    }
                } else {
                    $this->data["subview"] = "pesanan/payment";
                    $this->load->view('_main_layout', $this->data);
                }
            } else {
                $this->data["subview"] = "_not_found";
                $this->load->view('_main_layout', $this->data);
            }
        } else {
            $this->data["subview"] = "_not_found";
            $this->load->view('_main_layout', $this->data);
        }
    }

    private function payment_rules()
    {
        $rules = array(
            array(
                'field' => 'payment_method',
                'label' => $this->lang->line('order_payment_method'),
                'rules' => 'trim|xss_clean|required|numeric',
            ),
        );
        return $rules;
    }

    public function payments($orderID)
    {
        $order          = $this->pesanan_m->get_single_order(['id_pesanan' => $orderID]);
        $payment_method = $order->payment_method;

        if ($payment_method == 5) {
            $updateArray['payment_status'] = 15;
            $updateArray['paid_amount']    = $order->total;
            $this->pesanan_m->update_order($updateArray, $order->id_pesanan);
            $this->session->set_flashdata('success', 'Your order payment successfully paid.');
            redirect(base_url('Pesanan/view/' . $order->id_pesanan));
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
        $returnURL = base_url('Pesanan/paypalsuccess'); //payment success url
        $failURL   = base_url('Pesanan/paypalfail'); //payment fail url
        $notifyURL = base_url('Pesanan/paypalipn'); //ipn url

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
            redirect(base_url('Pesanan/index'));
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
        redirect(base_url('Pesanan/view/' . $order->id_pesanan));
    }

    public function paypalfail()
    {
        $this->session->set_flashdata('error', 'Your order payment fail.');
        redirect(base_url('Pesanan/index'));
    }

    public function paypalipn()
    {
        $this->session->set_flashdata('error', 'Your order payment ipn info.');
        redirect(base_url('Pesanan/index'));
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
            redirect(base_url('Pesanan/view/' . $order->id_pesanan));
        } catch (Exception $e) {
            $this->session->set_flashdata('error', $e->getMessage());
            redirect(base_url('Pesanan/view/' . $order->id_pesanan));
        }
    }

}
