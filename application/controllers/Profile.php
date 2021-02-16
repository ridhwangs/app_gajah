<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        if(empty($this->session->username)){
            redirect('identifikasi');
        }
    }

    public function index(){
        $data = [
            'row_user' => $this->crud_model->read('app_identifikasi', ['username' => $this->session->username])->row()
        ];
        $this->load->view('profile/profile_index', $data);
    }

    public function update($param)
    {
        switch ($param) {
            case 'identifikasi':
                $data = [
                    'nama' => $this->input->post('nama'),
                    'password' => $this->input->post('password')
                ];
                $where = [
                    'username' => $this->input->post('username')
                ];
                $this->crud_model->update('app_identifikasi', $where, $data);
                $this->session->set_flashdata('msg', 'user <b>'.$this->input->post('username').'</b> Berhasil di Update');
                redirect($this->agent->referrer());
                break;
            
            default:
                show_404();
                break;
        }
    }

}
