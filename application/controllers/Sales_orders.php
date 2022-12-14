<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sales_orders extends CI_Controller {
    function __construct()
	{
  		parent::__construct();
        if(empty($this->session->username)){
            redirect('identifikasi');
        }
        $this->userInfo = $this->crud_model->read('app_identifikasi', ['username' => $this->session->username])->row();
        $this->load->model('sales_orders_model');
        $this->load->helper('terbilang_helper');
    }

    public function index(){
 
        $where = [];
		if(!empty($this->userInfo->dealerID)){
			$where['master_sales_order.dealerID'] = $this->userInfo->dealerID;
		}
        if(!empty($this->input->get('list'))){
            $list = $this->input->get('list');
        }else{
            $list = 0;
        }
        $limit = 10 + $list;
        $query = $this->crud_model->read('master_sales_order',$where, 'created_at','DESC', $limit);
        $data = array(
            'page_header' => 'Sales Order List ',
            'list' => $list,
            'num_list' => $query->num_rows(),
            'query_master' => $query->result_array(),
            'count_wo_mmksi' => $this->crud_model->read('master_sales_order',['dealerID'=> $this->userInfo->dealerID,'no_invoice LIKE' => '%INVM%', 'DATE(created_at)' => date('Y-m-d')])->num_rows(),
            'count_wo_mftbc' => $this->crud_model->read('master_sales_order',['dealerID'=> $this->userInfo->dealerID,'no_invoice LIKE' => '%INVK%', 'DATE(created_at)' => date('Y-m-d')])->num_rows(),
        );
        $this->load->view('sales_orders/sales_orders_index', $data);
    }

    public function update($params)
    {
        switch ($params) {
            case 'master':
                $where = [
                    'id_master' => $this->input->post('id_master')
                ];
                $master = $this->crud_model->read('master_sales_order', $where)->row();
                $grand_total_after = $master->total_after + $this->input->post('ppn') + $this->input->post('sum_MateraiValue');
                $data = [
                    'tgl_invoice' => $this->input->post('tgl_invoice'),
                    'jatuh_tempo' => $this->input->post('jatuh_tempo'),
                    'no_po_konsumen' => $this->input->post("no_po_konsumen"),
                    'ppn' => $this->input->post('ppn'),
                    'sum_MateraiValue' => $this->input->post('sum_MateraiValue'),
                    'grand_total_after' => $grand_total_after,
                    'terbilang' => number_to_words($grand_total_after) .' Rupiah',
                ];
                $this->crud_model->update('master_sales_order', $where, $data);
                redirect('sales_orders/print?id_master='. $where['id_master']);
                die();
                break;
            
            default:
                # code...
                break;
        }
    }

    public function print() {
        $data = array(
            'page_header' => '',
            'id_master' => $this->input->get('id_master'),
            'row_master' => $this->crud_model->read('master_sales_order',['id_master' => $this->input->get('id_master')],'created_at','DESC')->row(),
            'query_details' => $this->sales_orders_model->read(['details_sales_order.id_master' => $this->input->get('id_master')])->result_array(),
            'count_details' => $this->sales_orders_model->read(['details_sales_order.id_master' => $this->input->get('id_master')])->num_rows(),
            'dicetak_oleh' => $this->userInfo->nama,
        );
        $this->load->view('sales_orders/sales_orders_print', $data);
    }

    public function edit() {
        $data = array(
            'page_header' => '',
            'id_master' => $this->input->get('id_master'),
            'row_master' => $this->crud_model->read('master_sales_order',['id_master' => $this->input->get('id_master')],'created_at','DESC')->row(),
            'query_details' => $this->sales_orders_model->read(['details_sales_order.id_master' => $this->input->get('id_master')])->result_array(),
            'count_details' => $this->sales_orders_model->read(['details_sales_order.id_master' => $this->input->get('id_master')])->num_rows(),
            'dicetak_oleh' => $this->userInfo->nama,
        );
        $this->load->view('sales_orders/sales_orders_edit', $data);
    }
}