<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Identifikasi extends CI_Controller {

    function __construct()
	{
  		parent::__construct();
        if(!empty($this->session->username)){
            redirect('work_orders');
        }
    }

    public function index(){
        $this->load->view('identifikasi/identifikasi_index');
    }

    public function read($param){
        switch ($param) {
            case 'identifikasi':
                    $post = [
                        'username' => $this->input->post('username'),
                        'password' => $this->input->post('password')
                    ];
                    $num_user = $this->crud_model->read('app_identifikasi',['username' => $post['username']])->num_rows();
                    if($num_user > 0){
                        // username ditemukan
                        $cek_password = $this->crud_model->read('app_identifikasi',['username' => $post['username'],'password' => $post['password']])->num_rows();
                        if($cek_password > 0){
                            $set_session = array(
                                    'username'  => $post['username'],
                            );
                            $this->session->set_userdata($set_session);
                        }else{
                            // password salah
                            $this->session->set_flashdata('msg', '<b>'.$post['username'].'</b> Password Salah');
                            $this->session->set_flashdata('set_input', $post['username']);
                        }
                    }else{
                        // username tidak ditemukan
                        $this->session->set_flashdata('msg', 'user <b>'.$post['username'].'</b> Tidak ditemukan');
                    }

                    redirect($this->agent->referrer());
                break;
            
            default:
                    show_404();
                break;
        }
    }

}
