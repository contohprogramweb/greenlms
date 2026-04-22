<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ebook extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ebook_m');

        $lang = 'indonesia';
        $this->lang->load('buku_elektronik', $lang);
    }

    public function index()
    {
        $this->data['headerassets'] = array(
            'css' => array(
                'assets/custom/css/buku_elektronik.css',
            ),
        );
		
		$this->data['get_title'] = 'Kelola Ebook | '.$this->data['pengaturan_umum']->sitename;
		
        $this->load->library('pagination');

        $config['base_url']       = base_url('buku_elektronik/index');
        $config['total_rows']     = calculate($this->ebook_m->get_ebook());
        $config['per_page']       = 12;
        $config['num_links']      = 1;
        $config['full_tag_open']  = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link']     = false;
        $config['last_link']      = false;
        $config['prev_link']      = '&lt; Previous';
        $config['prev_tag_open']  = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['last_link']      = false;
        $config['next_link']      = 'Next &gt;';
        $config['next_tag_open']  = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['num_tag_open']   = '<li>';
        $config['num_tag_close']  = '</li>';
        $config['cur_tag_open']   = '<li class='aktif'><a>';
        $config['cur_tag_close']  = '</a></li>';
        $this->pagination->initialize($config);

        $ebookID              = htmlentities(escapeString($this->uri->segment(3)));
        $this->data["ebooks"] = $this->ebook_m->get_order_by_ebook_limit($config['per_page'], $ebookID);

        $this->data["subview"] = "buku_elektronik/index";
        $this->load->view('_main_layout', $this->data);
    }

    public function add()
    {
        $this->data['headerassets'] = array(
            'js' => array(
                'assets/custom/js/fileupload.js',
            ),
        );
		
		$this->data['get_title'] = 'Tambah Ebook | '.$this->data['pengaturan_umum']->sitename;
		
        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->data["subview"] = "buku_elektronik/add";
                $this->load->view('_main_layout', $this->data);
            } else {
                $array                       = [];
                $array['nama']               = $this->input->post('nama');
                $array['penulis']             = $this->input->post('penulis');
                $array['coverphoto']         = $this->upload_data['coverphoto']['file_name'];
                $array['file']               = $this->upload_data['file']['file_name'];
                $array['file_original_name'] = $this->upload_data['file']['client_name'];
                $array['notes']              = $this->input->post('notes');
                $array['tanggal_dibuat']        = date('Y-m-d H:i:s');
                $array['create_memberID']    = $this->session->userdata('loginmemberID');
                $array['create_roleID']      = $this->session->userdata('id_peran');
                $array['modify_date']        = date('Y-m-d H:i:s');
                $array['modify_memberID']    = $this->session->userdata('loginmemberID');
                $array['modify_roleID']      = $this->session->userdata('id_peran');

                $this->ebook_m->insert_ebook($array);
                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('buku_elektronik/index'));
            }
        } else {
            $this->data["subview"] = "buku_elektronik/add";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function edit()
    {
        $this->data['headerassets'] = array(
            'js' => array(
                'assets/custom/js/fileupload.js',
            ),
        );
		$this->data['get_title'] = 'Edit Ebook | '.$this->data['pengaturan_umum']->sitename;
		
		
        $ebookID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $ebookID) {
            $this->data['buku_elektronik'] = $this->ebook_m->get_single_ebook(array('id_buku_elektronik' => $ebookID));
            if (calculate($this->data['buku_elektronik'])) {
                if ($_POST) {
                    $rules = $this->rules();
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == false) {
                        $this->data["subview"] = "buku_elektronik/edit";
                        $this->load->view('_main_layout', $this->data);
                    } else {
                        $array                       = [];
                        $array['nama']               = $this->input->post('nama');
                        $array['penulis']             = $this->input->post('penulis');
                        $array['coverphoto']         = $this->upload_data['coverphoto']['file_name'];
                        $array['file']               = $this->upload_data['file']['file_name'];
                        $array['file_original_name'] = $this->upload_data['file']['client_name'];
                        $array['notes']              = $this->input->post('notes');
                        $array['modify_date']        = date('Y-m-d H:i:s');
                        $array['modify_memberID']    = $this->session->userdata('loginmemberID');
                        $array['modify_roleID']      = $this->session->userdata('id_peran');

                        $this->ebook_m->update_ebook($array, $ebookID);
                        $this->session->set_flashdata('success', 'Success');
                        redirect(base_url('buku_elektronik/index'));
                    }
                } else {
                    $this->data["subview"] = "buku_elektronik/edit";
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
        $ebookID = htmlentities(escapeString($this->uri->segment(3)));
		$this->data['get_title'] = 'Lihat Data Ebook | '.$this->data['pengaturan_umum']->sitename;
		
        if ((int) $ebookID) {
            $this->data['buku_elektronik'] = $this->ebook_m->get_single_ebook(array('id_buku_elektronik' => $ebookID));
            if (calculate($this->data['buku_elektronik'])) {
                $fileimg = FCPATH . '/uploads/buku_elektronik/' . $this->data['buku_elektronik']->file;
                if (!file_exists($fileimg)) {
                    $this->session->set_flashdata('error', 'The Book file is not found');
                    redirect(base_url('buku_elektronik/index'));
                } else {
                    $this->data['headerassets'] = array(
                        'headerjs' => array(
                            'assets/custom/js/pdfobject.min.js',
                        ),
                    );
                    $this->data["subview"] = "buku_elektronik/view";
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

    public function delete()
    {
        $ebookID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $ebookID) {
            $buku_elektronik = $this->ebook_m->get_single_ebook(array('id_buku_elektronik' => $ebookID));
            if (calculate($buku_elektronik)) {
                if ($buku_elektronik->coverphoto != 'buku_elektronik.jpg') {
                    $deleleteimg = FCPATH . '/uploads/buku_elektronik/' . $buku_elektronik->coverphoto;
                    if (file_exists($deleleteimg)) {
                        unlink($deleleteimg);
                    }
                }

                $deleleteimg = FCPATH . '/uploads/buku_elektronik/' . $buku_elektronik->file;
                if (file_exists($deleleteimg)) {
                    unlink($deleleteimg);
                }

                $this->ebook_m->delete_ebook($ebookID);
                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('buku_elektronik/index'));
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
        if($this->data['pengaturan_umum']->ebook_download != 1) {
            $this->session->set_flashdata('error', "You dont have permission to download this buku_elektronik.");
            redirect(base_url('buku_elektronik/index'));
        }
        if (permissionChecker('ebook_view')) {
            $ebookID = htmlentities(escapeString($this->uri->segment(3)));
            if ((int) $ebookID) {
                $buku_elektronik = $this->ebook_m->get_single_ebook(array('id_buku_elektronik' => $ebookID));
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
                        redirect(base_url('buku_elektronik/index'));
                    }
                } else {
                    redirect(base_url('buku_elektronik/index'));
                }
            } else {
                redirect(base_url('buku_elektronik/index'));
            }
        } else {
            redirect(base_url('buku_elektronik/index'));
        }
    }

    private function rules()
    {
        $rules = array(
            array(
                'field' => 'nama',
                'label' => $this->lang->line('ebook_name'),
                'rules' => 'trim|xss_clean|required|max_length[100]|callback_check_unique_ebook',
            ),
            array(
                'field' => 'penulis',
                'label' => $this->lang->line('ebook_author'),
                'rules' => 'trim|xss_clean|required|max_length[100]',
            ),
            array(
                'field' => 'coverphoto',
                'label' => $this->lang->line('ebook_cover_photo'),
                'rules' => 'trim|xss_clean|max_length[200]|callback_coverphoto_upload',
            ),
            array(
                'field' => 'file',
                'label' => $this->lang->line('ebook_file'),
                'rules' => 'trim|xss_clean|max_length[200]|callback_file_upload',
            ),
            array(
                'field' => 'notes',
                'label' => $this->lang->line('ebook_notes'),
                'rules' => 'trim',
            ),
        );
        return $rules;
    }

    public function coverphoto_upload()
    {
        $ebookID = htmlentities(escapeString($this->uri->segment(3)));
        $buku_elektronik   = array();
        if ((int) $ebookID) {
            $buku_elektronik = $this->ebook_m->get_single_ebook(array('id_buku_elektronik' => $ebookID));
        }

        $new_file = "buku_elektronik.jpg";
        if ($_FILES["coverphoto"]['nama'] != "") {
            $file_name        = $_FILES["coverphoto"]['nama'];
            $random           = rand(1, 10000000000000000);
            $file_name_rename = hash('sha512', $random . config_item("encryption_key"));
            $explode          = explode('.', $file_name);
            if (calculate($explode) >= 2) {
                $new_file                = $file_name_rename . '.' . end($explode);
                $config['upload_path']   = "./uploads/buku_elektronik";
                $config['allowed_types'] = "gif|jpg|png|jpeg";
                $config['file_name']     = $new_file;
                $config['max_size']      = '2048';
                $config['max_width']     = '2000';
                $config['max_height']    = '2000';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload("coverphoto")) {
                    $this->form_validation->set_message("coverphoto_upload", $this->upload->display_errors());
                    return false;
                } else {
                    $this->upload_data['coverphoto'] = $this->upload->data();
                    return true;
                }
            } else {
                $this->form_validation->set_message("coverphoto_upload", "Invalid file");
                return false;
            }
        } else {
            if (calculate($buku_elektronik)) {
                $this->upload_data['coverphoto'] = array('file_name' => $buku_elektronik->coverphoto);
                return true;
            } else {
                $this->form_validation->set_message("coverphoto_upload", "The %s field is required.");
                return false;
            }
        }
    }

    public function file_upload()
    {
        $ebookID = htmlentities(escapeString($this->uri->segment(3)));
        $buku_elektronik   = array();
        if ((int) $ebookID) {
            $buku_elektronik = $this->ebook_m->get_single_ebook(array('id_buku_elektronik' => $ebookID));
        }

        $new_file = "";
        if ($_FILES['file']['nama'] != "") {
            $file_name        = $_FILES['file']['nama'];
            $random           = rand(1, 10000000000000000);
            $file_name_rename = hash('sha512', $random . config_item("encryption_key"));
            $explode          = explode('.', $file_name);
            if (calculate($explode) >= 2) {
                $new_file                = $file_name_rename . '.' . end($explode);
                $config['upload_path']   = "./uploads/buku_elektronik";
                $config['allowed_types'] = "pdf";
                $config['file_name']     = $new_file;
                $config['max_size']      = '51200';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

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
            if (calculate($buku_elektronik)) {
                $this->upload_data['file'] = array('file_name' => $buku_elektronik->file);
                return true;
            } else {
                $this->form_validation->set_message("file_upload", "The %s field is required.");
                return false;
            }
        }
    }

    public function check_unique_ebook($name)
    {
        $ebookID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $ebookID) {
            $buku_elektronik = $this->ebook_m->get_single_ebook(array('nama' => $name, 'ebookID !=' => $ebookID));
            if (calculate($buku_elektronik)) {
                $this->form_validation->set_message("check_unique_ebook", "The %s is already exits.");
                return false;
            }
            return true;
        } else {
            $buku_elektronik = $this->ebook_m->get_single_ebook(array('nama' => $name));
            if (calculate($buku_elektronik)) {
                $this->form_validation->set_message("check_unique_ebook", "The %s is already exits.");
                return false;
            }
            return true;
        }
    }
}
