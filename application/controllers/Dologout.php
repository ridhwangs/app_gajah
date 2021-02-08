<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dologout extends CI_Controller {

    function __construct()
	{
  		parent::__construct();
   
    }

    public function index(){
        $this->session->userdata = array();
        $this->session->sess_destroy();
        redirect($this->agent->referrer(),'refresh');
    }

}
