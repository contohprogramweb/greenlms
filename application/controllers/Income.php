<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Income extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('income_m');

        $lang = 'indonesia';
        $this->lang->load('pemasukan', $lang);
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
		
		$this->data['get_title'] = 'Kelola Pemasukan | '.$this->data['pengaturan_umum']->sitename;
		
        $this->data['incomes'] = $this->income_m->get_income();
        $this->data["subview"] = "pemasukan/index";
        $this->load->view('_main_layout', $this->data);
    }

    public function add()
    {
        $this->data['headerassets'] = array(
            'css'      => array(
                'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
            ),
            'headerjs' => array(
                'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
            ),
            'js'       => array(
                'assets/custom/js/fileupload.js',
            ),
        );
		
		$this->data['get_title'] = 'Tambah Pemasukan | '.$this->data['pengaturan_umum']->sitename;
		
        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->data["subview"] = "pemasukan/add";
                $this->load->view('_main_layout', $this->data);
            } else {
                $array                     = [];
                $array['nama']             = $this->input->post('nama');
                $array['tanggal']             = date('Y-m-d', strtotime($this->input->post('tanggal')));
                $array['jumlah']           = $this->input->post('jumlah');
                $array['file']             = $this->upload_data['file']['file_name'];
                $array['fileoriginalname'] = $this->upload_data['file']['client_name'];
                $array['catatan']             = $this->input->post('catatan');
                $array['tanggal_dibuat']      = date('Y-m-d H:i:s');
                $array['create_memberID']  = $this->session->userdata('loginmemberID');
                $array['create_roleID']    = $this->session->userdata('id_peran');
                $array['modify_date']      = date('Y-m-d H:i:s');
                $array['modify_memberID']  = $this->session->userdata('loginmemberID');
                $array['modify_roleID']    = $this->session->userdata('id_peran');

                $this->income_m->insert_income($array);
                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('pemasukan/index'));
            }
        } else {
            $this->data["subview"] = "pemasukan/add";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function edit()
    {
        $incomeID = htmlentities(escapeString($this->uri->segment(3)));
		$this->data['get_title'] = 'Edit Pemasukan | '.$this->data['pengaturan_umum']->sitename;
		
        if ((int) $incomeID) {
            $pemasukan = $this->income_m->get_single_income(array('id_pemasukan' => $incomeID));
            if (calculate($pemasukan)) {
                $this->data['headerassets'] = array(
                    'css'      => array(
                        'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
                    ),
                    'headerjs' => array(
                        'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
                    ),
                    'js'       => array(
                        'assets/custom/js/fileupload.js',
                    ),
                );
                $this->data['pemasukan'] = $pemasukan;
                if ($_POST) {
                    $rules = $this->rules();
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == false) {
                        $this->data["subview"] = "pemasukan/edit";
                        $this->load->view('_main_layout', $this->data);
                    } else {
                        $array                     = [];
                        $array['nama']             = $this->input->post('nama');
                        $array['tanggal']             = date('Y-m-d', strtotime($this->input->post('tanggal')));
                        $array['jumlah']           = $this->input->post('jumlah');
                        $array['file']             = $this->upload_data['file']['file_name'];
                        $array['fileoriginalname'] = $this->upload_data['file']['client_name'];
                        $array['catatan']             = $this->input->post('catatan');
                        $array['modify_date']      = date('Y-m-d H:i:s');
                        $array['modify_memberID']  = $this->session->userdata('loginmemberID');
                        $array['modify_roleID']    = $this->session->userdata('id_peran');

                        $this->income_m->update_income($array, $incomeID);
                        $this->session->set_flashdata('success', 'Success');
                        redirect(base_url('pemasukan/index'));
                    }
                } else {
                    $this->data["subview"] = "pemasukan/edit";
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

    public function download()
    {
        $incomeID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $incomeID) {
            $pemasukan = $this->income_m->get_single_income(array('id_pemasukan' => $incomeID));
            if (calculate($pemasukan)) {
                $file = realpath('uploads/document/' . $pemasukan->file);
                if ($pemasukan->file != '' && file_exists($file)) {
                    $originalname = $pemasukan->fileoriginalname;
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
                    $this->session->set_flashdata('error', 'The file is not available at this moment.');
                    redirect(base_url('pemasukan/index'));
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

    public function delete()
    {
        $incomeID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $incomeID) {
            $pemasukan = $this->income_m->get_single_income(array('id_pemasukan' => $incomeID));
            if (calculate($pemasukan)) {
                $this->income_m->delete_income($incomeID);
                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('pemasukan/index'));
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
                'field' => 'nama',
                'label' => $this->lang->line('income_name'),
                'rules' => 'trim|xss_clean|required|max_length[100]',
            ),
            array(
                'field' => 'tanggal',
                'label' => $this->lang->line('income_date'),
                'rules' => 'trim|xss_clean|required|valid_date',
            ),
            array(
                'field' => 'jumlah',
                'label' => $this->lang->line('income_amount'),
                'rules' => 'trim|xss_clean|required|max_length[10]|numeric',
            ),
            array(
                'field' => 'file',
                'label' => $this->lang->line('income_amount'),
                'rules' => 'trim|xss_clean|callback_file_upload',
            ),
            array(
                'field' => 'catatan',
                'label' => $this->lang->line('income_note'),
                'rules' => 'trim|xss_clean|max_length[255]',
            ),
        );
        return $rules;
    }

    public function file_upload()
    {
        $incomeID = htmlentities(escapeString($this->uri->segment(3)));
        $pemasukan   = [];
        if ((int) $incomeID) {
            $pemasukan = $this->income_m->get_single_income(array('id_pemasukan' => $incomeID));
        }

        $new_file = "";
        if ($_FILES['file']['nama'] != "") {
            $file_name        = $_FILES['file']['nama'];
            $random           = rand(1, 10000000000000000);
            $file_name_rename = hash('sha512', $random . config_item("encryption_key"));
            $explode          = explode('.', $file_name);
            if (calculate($explode) >= 2) {
                $new_file                = $file_name_rename . '.' . end($explode);
                $config['upload_path']   = "./uploads/document";
                $config['allowed_types'] = "gif|jpg|png|jpeg|pdf|docs";
                $config['file_name']     = $new_file;
                $config['max_size']      = '2048';
                $config['max_width']     = '2000';
                $config['max_height']    = '2000';
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('file')) {
                    $this->form_validation->set_message("file_upload", $this->upload->display_errors());
                    return false;
                } else {
                    $this->upload_data['file'] = $this->upload->data();
                    return true;
                }
            } else {
                $this->form_validation->set_message("file_upload", "Invalid file");
                return false;
            }
        } else {
            if (calculate($pemasukan)) {
                $this->upload_data['file']['file_name']   = $pemasukan->file;
                $this->upload_data['file']['client_name'] = $pemasukan->fileoriginalname;
                return true;
            } else {
                $this->upload_data['file']['file_name']   = $new_file;
                $this->upload_data['file']['client_name'] = $new_file;
                return true;
            }
        }
    }

}
