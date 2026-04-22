<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Templatemail extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Templatemail_m');

        $lang = 'indonesia';
        $this->lang->load('templat_surel', $lang);
    }

    public function index()
    {
        $this->data['headerassets'] = array(
            'css' => array(
                'assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css',
                'assets/custom/css/hidetable.css',
            ),
            'js'  => array(
                'assets/plugins/datatables.net/js/jquery.dataTables.min.js',
                'assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js',
            ),
        );
		
		$this->data['get_title'] = 'Kelola Template Email | '.$this->data['pengaturan_umum']->sitename;
		
        $this->data['emailtemplates'] = $this->templatemail_m->get_emailtemplate();
        $this->data["subview"]        = "templat_surel/index";
        $this->load->view('_main_layout', $this->data);
    }

    public function add()
    {
        $this->data['headerassets'] = array(
            'css' => array(
                'assets/plugins/summernote/summernote.css',
            ),
            'js'  => array(
                'assets/plugins/summernote/summernote.min.js',
                'assets/custom/js/templat_surel.js',
            ),
        );
		
		$this->data['get_title'] = 'Tambah Template Email | '.$this->data['pengaturan_umum']->sitename;
		
        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->data["subview"] = "templat_surel/add";
                $this->load->view('_main_layout', $this->data);
            } else {
                $array                    = [];
                $array['nama']            = $this->input->post('nama');
                $array['templat']        = $this->input->post('templat');
                $array['status']          = $this->input->post('status');
                $array['tanggal_dibuat']     = date('Y-m-d H:i:s');
                $array['create_memberID'] = $this->session->userdata('loginmemberID');
                $array['create_roleID']   = $this->session->userdata('id_peran');
                $array['modify_date']     = date('Y-m-d H:i:s');
                $array['modify_memberID'] = $this->session->userdata('loginmemberID');
                $array['modify_roleID']   = $this->session->userdata('id_peran');

                $this->templatemail_m->insert_emailtemplate($array);
                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('templat_surel/index'));
            }
        } else {
            $this->data["subview"] = "templat_surel/add";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function edit()
    {
        $this->data['headerassets'] = array(
            'css' => array(
                'assets/plugins/summernote/summernote.css',
            ),
            'js'  => array(
                'assets/plugins/summernote/summernote.min.js',
                'assets/custom/js/templat_surel.js',
            ),
        );
		
		$this->data['get_title'] = 'Edit Template Email | '.$this->data['pengaturan_umum']->sitename;
		
		
        $emailtemplateID = htmlentities(escapeString($this->uri->segment('3')));
        if ((int) $emailtemplateID) {
            $this->data['templat_surel'] = $this->templatemail_m->get_single_emailtemplate($emailtemplateID);
            if (calculate($this->data['templat_surel'])) {
                if ($_POST) {
                    $rules = $this->rules();
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == false) {
                        $this->data["subview"] = "templat_surel/edit";
                        $this->load->view('_main_layout', $this->data);
                    } else {
                        $array                    = [];
                        $array['nama']            = $this->input->post('nama');
                        $array['templat']        = $this->input->post('templat');
                        $array['status']          = $this->input->post('status');
                        $array['modify_date']     = date('Y-m-d H:i:s');
                        $array['modify_memberID'] = $this->session->userdata('loginmemberID');
                        $array['modify_roleID']   = $this->session->userdata('id_peran');

                        $this->templatemail_m->update_emailtemplate($array, $emailtemplateID);
                        $this->session->set_flashdata('msg', 'Success');
                        redirect(base_url('templat_surel/index'));
                    }
                } else {
                    $this->data["subview"] = "templat_surel/edit";
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

    public function view()
    {
        $emailtemplateID = escapeString($this->uri->segment('3'));
		$this->data['get_title'] = 'Edit Template Email | '.$this->data['pengaturan_umum']->sitename;
		
        if ((int) $emailtemplateID) {
            $templat_surel = $this->templatemail_m->get_single_emailtemplate($emailtemplateID);
            if (calculate($templat_surel)) {
                $this->data['templat_surel'] = $templat_surel;
                $this->data["subview"]       = "templat_surel/view";
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

    public function delete()
    {
        $emailtemplateID = escapeString($this->uri->segment('3'));
        if ((int) $emailtemplateID) {
            $templat_surel = $this->templatemail_m->get_single_emailtemplate($emailtemplateID);
            if (calculate($templat_surel)) {
                $this->templatemail_m->delete_emailtemplate($emailtemplateID);
                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('templat_surel/index'));
            } else {
                $this->data["subview"] = "_not_found";
                $this->load->view('_main_layout', $this->data);
            }
        } else {
            $this->data["subview"] = "_not_found";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function uploads()
    {
        $retArray           = [];
        $retArray['status'] = false;
        if ($_FILES['foto']['nama'] != "") {
            $file_name        = $_FILES['foto']['nama'];
            $random           = rand(1, 10000000000000000);
            $file_name_rename = hash('sha512', $random . config_item("encryption_key"));
            $explode          = explode('.', $file_name);
            if (calculate($explode) >= 2) {
                $new_file                = $file_name_rename . '.' . end($explode);
                $config['upload_path']   = "./uploads/summernote";
                $config['allowed_types'] = "gif|jpg|png|jpeg";
                $config['file_name']     = $new_file;
                $config['max_size']      = '2048';
                $config['max_width']     = '2000';
                $config['max_height']    = '2000';
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('foto')) {
                    $retArray['pesan'] = $this->upload->display_errors();
                } else {
                    $imagename          = $this->upload->data()['file_name'];
                    $retArray['foto']  = base_url('uploads/summernote/' . $imagename);
                    $retArray['status'] = true;
                }
            } else {
                $retArray['pesan'] = "Invalid File";
            }
        } else {
            $retArray['pesan'] = "Please Select File";
        }
        echo json_encode($retArray);
    }

    protected function rules()
    {
        $rules = array(
            array(
                'field' => 'nama',
                'label' => $this->lang->line('emailtemplate_name'),
                'rules' => 'trim|xss_clean|required|min_length[4]|max_length[60]',
            ),
            array(
                'field' => 'templat',
                'label' => $this->lang->line('emailtemplate_template'),
                'rules' => 'trim|xss_clean|required|min_length[10]',
            ),
            array(
                'field' => 'status',
                'label' => $this->lang->line('emailtemplate_status'),
                'rules' => 'trim|xss_clean|required|required_no_zero',
            ),
        );
        return $rules;
    }

}
