<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Work_orders extends CI_Controller {
    var $userInfo ;
    function __construct()
	{
  		parent::__construct();
        if(empty($this->session->username)){
            redirect('identifikasi');
        }
        $this->userInfo = $this->crud_model->read('app_identifikasi', ['username' => $this->session->username])->row();
    }



    public function index(){
        if(!empty($this->input->get('q'))){
            $where = [
                $this->input->get('on_table').' LIKE' => '%'.$this->input->get('q').'%'  
            ];
        }
        if(!empty($this->userInfo->dealerID)){
            $where['dealerID'] = $this->userInfo->dealerID;
        }else{
            $where = [];
        }
        $list = 0;
        $list = $this->input->get('list');
        $limit = 10 + $list;
        $query = $this->crud_model->read('master_work_order',$where,'created_at','DESC',$limit);
        $data = array(
            'page_header' => 'Work Order List ',
            'list' => $list,
            'num_list' => $query->num_rows(),
            'query_master' => $query->result(),
        );
        $this->load->view('work_orders/work_orders_index', $data);
    }
    
    public function edit() {
        $data = array(
            'page_header' => '',
            'id_master' => $this->input->get('id_master'),
            'row_master' => $this->crud_model->read('master_work_order',['id_master' => $this->input->get('id_master')],'created_at','DESC')->row(),
            'query_details' => $this->crud_model->read('details_work_order',['id_master' => $this->input->get('id_master')],['urutan','created_at'],'ASC')->result_array(),
        );
        $this->load->view('work_orders/work_orders_edit', $data);
    }
    
    public function print() {
        $data = array(
            'page_header' => '',
            'id_master' => $this->input->get('id_master'),
            'row_master' => $this->crud_model->read('master_work_order',['id_master' => $this->input->get('id_master')],'created_at','DESC')->row(),
            'query_details' => $this->crud_model->read('details_work_order',['id_master' => $this->input->get('id_master')],'urutan','ASC')->result_array(),
        );
        $this->load->view('work_orders/work_orders_print', $data);
    }


    public function read($param) {
        switch ($param) {
            case 'xml':
                $xml = @simplexml_load_file($this->input->get('url')) or die("Error: Cannot create object");
                
                if ($xml === false) {
                  echo "Failed loading XML: ";
                  foreach(libxml_get_errors() as $error) {
                    echo "<br>", $error->message;
                  }
                } else {
                    if($xml->Subreport1){
                          //withtax = subreport1
                        $headers = $xml->Subreport1->Report->Tablix2->Details_Collection->Details;
                        $data_master  = [
                            'dealerID' => $this->userInfo->dealerID,
                            'alamat_kantor' => (string)$headers->Tablix10->attributes()->Textbox123,
                            'kota_kantor' => (string)$headers->Tablix10->attributes()->Textbox124,
                            'telp_kantor' => str_replace('TELP: ', '', $headers->Tablix10->attributes()->Textbox130),
                            'npwp_kantor' => str_replace('NPWP: ', '', $headers->Tablix10->attributes()->Textbox138),
                            'no_invoice' => (string)$headers->attributes()->Textbox652,
                            'no_wo' => (string)$headers->Tablix7->attributes()->Textbox305,
                            'service_category' => (string)$headers->attributes()->Textbox11,
                            'no_pelanggan' => (string)$headers->attributes()->Textbox579,
                            'nik' => (string)$headers->attributes()->Textbox68,
                            'nm_pelanggan' => (string)$headers->attributes()->Textbox44,
                            'alamat_pelanggan' => (string)$headers->attributes()->Textbox50,
                            'th_produksi' => (string)$headers->attributes()->Textbox17,
                            'no_telp' => (string)$headers->attributes()->Textbox80,
                            'CurrentMileageWOValue' =>(string) $headers->attributes()->CurrentMileageWOValue,
                            'no_polisi' => (string)$headers->attributes()->Textbox26,
                            'tgl_masuk' => date("Y-m-d", strtotime(str_replace('/', '-', $headers->attributes()->Textbox36))),
                            'tgl_keluar' => date("Y-m-d", strtotime(str_replace('/', '-', $headers->attributes()->Textbox38))),
                            'model' => (string)$headers->attributes()->Textbox55,
                            'no_rangka' => (string)$headers->attributes()->Textbox74,
                            'no_mesin' => (string)$headers->attributes()->Textbox71,
                            'MethodOfPayment7' => (string)$headers->Tablix6->attributes()->MethodOfPayment6,
                            'terbilang' => str_replace('Terbilang: ', '', $headers->attributes()->Textbox153),
                            'ppn' => (string)$headers->Tablix11->attributes()->PPNValue,
                            'dpp' => (string)$headers->Tablix11->attributes()->TotalAmtBeforeDiscValue2,
                            'grand_total' => (string)$headers->Tablix11->attributes()->Textbox6,
                            'BeaMaterai' => (string)$headers->Tablix11->attributes()->BeaMaterai,
                            'keterangan' => (string)$headers->Tablix3->attributes()->Textbox284,

                        ];
                        
                        $this->crud_model->delete('master_work_order', $data_master);
                        $data_master['dicetak_oleh'] = $this->userInfo->nama;
                        $data_master['created_by'] = $this->session->username;
                        $data_master['created_at'] = date('Y-m-d H:i:s');
                        $this->crud_model->create('master_work_order', html_escape($data_master));
                        $id_master = $this->db->insert_id();
                        $data_master['id_master'] = $id_master;
                        
                        $details = $xml->Tablix2->Details_Collection->Details->Tablix11->ProductType_Collection;
                        foreach ($details->ProductType  as $rows => $content) {
                            $kategori = preg_replace("/[^a-zA-Z]+/", "", (string)$content->attributes()->Textbox43);
                            foreach ($content->Details1_Collection->Details1 as $key => $rows) {
                                if(empty($kategori)){
                                    $urutan = 0;
                                    $kategori = "JASA";
                                }else if($kategori == "Oil"){
                                    $urutan = 2;
                                    $kategori = "OLI";
                                }else if($kategori == "Part"){
                                    $urutan = 1;
                                    $kategori = "SPAREPARTS";
                                }else if($kategori == "SubMaterial"){
                                    $urutan = 3;
                                    $kategori = "SUB MATERIAL";
                                }else if($kategori == "SubOrder"){
                                    $urutan = 4;
                                    $kategori = "SUB ORDER";
                                }
                                $data = [
                                    'id_master' => $data_master['id_master'],
                                    'kode' => (string)$rows->attributes()->Textbox75,
                                    'keterangan' => (string)$rows->attributes()->Textbox74,
                                    'harga_satuan' => (string)$rows->attributes()->UnitPriceValue,
                                    'qty' => (string)$rows->attributes()->Textbox249,
                                    'sub_total_before' => (string)$rows->attributes()->Textbox107,
                                    'discount' => (string)$rows->attributes()->Textbox112,
                                    'sub_total_after' => (string)$rows->attributes()->Textbox121,
                                    'urutan' => $urutan,
                                    'kategori' => $kategori,
                                    'created_by' => $this->session->username,
                                    'created_at' => date('Y-m-d H:i:s')
                                ];
                                $this->crud_model->create('details_work_order', $data);

                            }
                        }
                    }else if($xml->Subreport2){
                        //withouttax = subreport2
                           show_404(); 
                        die();
                    }else{
                        show_404();
                    }
                    
                }
                
                unlink($this->input->get('url'));
                redirect('work_orders/print?id_master='.$data_master['id_master']);
                break;
            case 'details':
                $where = [
                  'id_details' => $this->input->post('id_details')  
                ];
                $data = $this->crud_model->read('details_work_order', $where)->row();
                echo json_encode($data);
                break;
                default:
                    show_404();
                    break;
        }
    }
    
    public function update($param) {
        switch ($param) {
            case 'kategori':
                $where = [
                  'id_details' => $this->input->post('id_details')  
                ];
                $kategori = $this->input->post('kategori');
                if($kategori == "JASA"){
                    $urutan = 0;
                }else if($kategori == "OLI"){
                    $urutan = 2;
                }else if($kategori == "SPAREPARTS"){
                    $urutan = 1;
                }else if($kategori == "SUB MATERIAL"){
                    $urutan = 3;
                }else if($kategori == "SUB ORDER"){
                    $urutan = 4;
                }
                $data = [
                    'kategori' => $kategori,
                    'urutan' => $urutan,
                ];
                
                $this->crud_model->update('details_work_order', $where, $data);
                
                redirect($this->agent->referrer());
                break;
            default:
                    show_404();
                break;
        }
    }


    public function delete($param) {
        switch ($param) {
            case 'xml':
                unlink($this->input->get('url'));
                redirect($this->agent->referrer());
                break;

            default:
                break;
        }
    }

}
