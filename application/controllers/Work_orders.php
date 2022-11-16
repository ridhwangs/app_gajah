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
        $this->load->model('work_orders_model');
        $this->load->helper('terbilang_helper');
    }

    public function index(){
 
        $where = [];
		if(!empty($this->userInfo->dealerID)){
			$where['master_work_order.dealerID'] = $this->userInfo->dealerID;
		}
        if(!empty($this->input->get('list'))){
            $list = $this->input->get('list');
        }else{
            $list = 0;
        }
        $limit = 10 + $list;
        $query = $this->crud_model->read('master_work_order',$where, 'created_at','DESC', $limit);
        $data = array(
            'page_header' => 'Work Order List ',
            'list' => $list,
            'num_list' => $query->num_rows(),
            'query_master' => $query->result_array(),
            'count_wo_mmksi' => $this->crud_model->read('master_work_order',['dealerID'=> $this->userInfo->dealerID,'no_wo LIKE' => '%WOM%', 'DATE(created_at)' => date('Y-m-d')])->num_rows(),
            'count_wo_mftbc' => $this->crud_model->read('master_work_order',['dealerID'=> $this->userInfo->dealerID,'no_wo LIKE' => '%WOK%', 'DATE(created_at)' => date('Y-m-d')])->num_rows(),
        );
        $this->load->view('work_orders/work_orders_index', $data);
    }

    public function doCari()
    {
        $post = [
            'tgl_awal' => $this->input->post('tgl_awal'),
            'tgl_akhir' => $this->input->post('tgl_akhir'),
            'on_table' => $this->input->post('on_table'),
            'q' => $this->input->post('q'),
        ];
        redirect('work_orders/cari?'.http_build_query($post));
    }

    public function cari()
    {
        $where = [];
        if(!empty($this->input->get('q'))){
            $where = [
                'master_work_order.'.$this->input->get('on_table').' LIKE' => '%'.$this->input->get('q').'%'  
            ];
        }
        if(!empty($this->userInfo->dealerID)){
            $where['master_work_order.dealerID'] = $this->userInfo->dealerID;
        }

        if(!empty($this->input->get('tgl_awal'))){
            $where['master_work_order.tgl_masuk >='] = $this->input->get('tgl_awal');
        }
        if(!empty($this->input->get('tgl_akhir'))){
            $where['master_work_order.tgl_masuk <='] = $this->input->get('tgl_akhir');
        }
      
        $query = $this->crud_model->read('master_work_order',$where, 'created_at','DESC','128');
        $data = array(
            'page_header' => 'Work Order Cari ',
            'query_master' => $query->result_array(),
            'count_wo_mmksi' => $this->crud_model->read('master_work_order',['dealerID'=> $this->userInfo->dealerID,'no_wo LIKE' => '%WOM%', 'DATE(created_at)' => date('Y-m-d')])->num_rows(),
            'count_wo_mftbc' => $this->crud_model->read('master_work_order',['dealerID'=> $this->userInfo->dealerID,'no_wo LIKE' => '%WOK%', 'DATE(created_at)' => date('Y-m-d')])->num_rows(),
        );
        if(!empty($this->input->get('id_master'))){
            $data['row_master'] = $this->crud_model->read('master_work_order',['id_master' => $this->input->get('id_master')],'created_at','DESC')->row();
            $data['query_details'] = $this->work_orders_model->read(['details_work_order.id_master' => $this->input->get('id_master')])->result_array();
        }
        $this->load->view('work_orders/work_orders_cari', $data);
    }
    
    public function edit() {
        $data = array(
            'page_header' => 'Work Order Edit '. $this->input->get('id_master'),
            'id_master' => $this->input->get('id_master'),
            'row_master' => $this->crud_model->read('master_work_order',['id_master' => $this->input->get('id_master')],'created_at','DESC')->row(),
            'query_details' => $this->work_orders_model->read(['details_work_order.id_master' => $this->input->get('id_master')])->result_array(),
        );
        $this->load->view('work_orders/work_orders_edit', $data);
    }
    
    public function print() {
        $data = array(
            'page_header' => '',
            'id_master' => $this->input->get('id_master'),
            'row_master' => $this->crud_model->read('master_work_order',['id_master' => $this->input->get('id_master')],'created_at','DESC')->row(),
            'query_details' => $this->work_orders_model->read(['details_work_order.id_master' => $this->input->get('id_master')])->result_array(),
            'count_details' => $this->work_orders_model->read(['details_work_order.id_master' => $this->input->get('id_master')])->num_rows(),
            'dicetak_oleh' => $this->userInfo->nama,
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
                        $tipe = 'work_orders';
                          //withtax = subreport1
                        $headers = $xml->Subreport1->Report->Tablix2->Details_Collection->Details;
                        $data_master  = [
                            'alamat_kantor' => (string)$headers->Tablix10->attributes()->Textbox123,
                            'kota_kantor' => (string)$headers->Tablix10->attributes()->Textbox124,
                            'telp_kantor' => str_replace('TELP: ', '', $headers->Tablix10->attributes()->Textbox130),
                            'npwp_kantor' => str_replace('NPWP: ', '', $headers->Tablix10->attributes()->Textbox138),
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
                        
                        $this->crud_model->delete('master_work_order', ['no_wo' => $data_master['no_wo']]);

                        $data_master['dealerID'] = substr($data_master['no_wo'],0,6);
                        $data_master['no_invoice'] = (string)$headers->attributes()->Textbox652;
                        $data_master['tgl_keluar'] = date("Y-m-d", strtotime(str_replace('/', '-', $headers->attributes()->Textbox38)));
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
                                }else if($kategori == "Equipment"){
                                    $urutan = 5;
                                    $kategori = "EQUIPMENT";
                                }else if($kategori == "Accessories"){
                                    $urutan = 6;
                                    $kategori = "ACCESSORIES";
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
                        $tipe = 'work_orders';
                        //withouttax = subreport2
						$headers = $xml->Subreport2->Report->Tablix2->Details_Collection->Details;

						$data_master  = [
							'alamat_kantor' => (string)$headers->Tablix10->attributes()->Textbox123,
							'kota_kantor' => (string)$headers->Tablix10->attributes()->Textbox124,
							'telp_kantor' => str_replace('TELP: ', '', $headers->Tablix10->attributes()->Textbox130),
							'npwp_kantor' => str_replace('NPWP: ', '', $headers->Tablix10->attributes()->Textbox142),
							'no_wo' => (string)$headers->Tablix7->attributes()->Textbox304,
							'service_category' => (string)$headers->attributes()->Textbox15,
							'no_pelanggan' => (string)$headers->attributes()->Textbox26,
							'nik' => (string)$headers->attributes()->Textbox92,
							'nm_pelanggan' => (string)$headers->attributes()->Textbox33,
							'alamat_pelanggan' => (string)$headers->attributes()->Textbox74,
							'th_produksi' => (string)$headers->attributes()->Textbox20,
							'no_telp' => (string)$headers->attributes()->Textbox84,
							'CurrentMileageWOValue' =>(string) $headers->attributes()->CurrentMileageWOValue2,
							'no_polisi' => (string)$headers->attributes()->Textbox79,
							'tgl_masuk' => date("Y-m-d", strtotime(str_replace('/', '-', $headers->attributes()->Textbox72))),
							'model' => (string)$headers->attributes()->Textbox91,
							'no_rangka' => (string)$headers->attributes()->Textbox96,
							'no_mesin' => (string)$headers->attributes()->Textbox99,
							'MethodOfPayment7' => (string)$headers->Tablix6->attributes()->MethodOfPayment6,
							'terbilang' => str_replace('Terbilang: ', '', $headers->attributes()->Textbox155),
							'dpp' => (string)$headers->Tablix11->attributes()->Textbox70,
							'ppn' => "0",
							'grand_total' => (string)$headers->Tablix11->attributes()->Textbox70,
							'BeaMaterai' => (integer)$headers->Tablix11->attributes()->Textbox1,
							'keterangan' => (string)$headers->attributes()->Textbox284,
							'jenis_wo' => "WITHOUT TAX",
						];

						$this->crud_model->delete('master_work_order', ['no_wo' => $data_master['no_wo']]);

						$data_master['dealerID'] = substr($data_master['no_wo'],0,6);
						$data_master['no_invoice'] = (string)$headers->attributes()->Textbox652;
						$data_master['tgl_keluar'] = date("Y-m-d", strtotime(str_replace('/', '-', $headers->attributes()->Textbox75)));
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
								}else if($kategori == "Equipment"){
									$urutan = 5;
									$kategori = "EQUIPMENT";
								}else if($kategori == "Accessories"){
									$urutan = 6;
									$kategori = "ACCESSORIES";
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
                    }else if($xml->Tablix1){
                        $tipe = 'sales_orders';
                        $total_after = preg_replace( '/[^0-9]/', '', $xml->Tablix8->attributes()->Textbox139);
                        $ppn = $total_after * 11 / 100;
                        $masterai = 0;
                        if($total_after >= 5000000){
                            $masterai = 10000;
                        }
                        $grand_total_after = $total_after + $ppn + $materai;
                        $terbilang = number_to_words($grand_total_after);
                        $data_master = [
                            'konsumen' => (string)$xml->Tablix1->xts_accountreceivableinvoice_Collection->xts_accountreceivableinvoice->Tablix6->attributes()->Textbox117,
                            'address' => (string)$xml->Tablix1->xts_accountreceivableinvoice_Collection->xts_accountreceivableinvoice->Tablix6->attributes()->CUST_address1_line1,
                            'kota' => (string)$xml->Tablix1->xts_accountreceivableinvoice_Collection->xts_accountreceivableinvoice->Tablix6->attributes()->Textbox125,
                            'telp_fax' => (string)$xml->Tablix1->xts_accountreceivableinvoice_Collection->xts_accountreceivableinvoice->Tablix6->attributes()->Textbox119,
                            'no_invoice' => (string)$xml->Tablix2->attributes()->xts_accountreceivableinvoice,
                            'tgl_invoice' => date("Y-m-d", strtotime($xml->Tablix2->attributes()->Textbox164)),
                            'jatuh_tempo' => date("Y-m-d", strtotime($xml->Tablix2->attributes()->Textbox166)),
                            'xts_type' => (string)$xml->Tablix2->attributes()->xts_type,
                            'invoice_reference' => (string)$xml->Tablix2->attributes()->Textbox75,
                            'xts_deliveryordernumber' => (string)$xml->Tablix2->attributes()->xts_deliveryordernumber,
                            'no_do' => (string)$xml->Tablix2->attributes()->Textbox78,
                            'total_before' => preg_replace( '/[^0-9]/', '', $xml->Tablix8->attributes()->Textbox134),
                            'sum_MateraiValue' => $masterai,
                            'sum_AdministrasiValue' => preg_replace( '/[^0-9]/', '', $xml->Tablix8->attributes()->sum_AdministrasiValue),
                            'total_after' => $total_after,
                            'ppn' => $ppn,
                            'grand_total_after' => $grand_total_after,
                            'terbilang' => $terbilang,
                            'note_rek' => (string)$xml->Tablix10->attributes()->Textbox140,
                            'kasir' => 'FALSE',
                            'jenis_so' => 'WITH TAX',
                            'created_by' => $this->session->username,
                            'created_at' => date('Y-m-d H:i:s')
                        ];
                        // echo "<pre>";
                        // print_r($data_master);
                        // die();
                        $this->crud_model->delete('master_sales_order', ['no_invoice' => $data_master['no_invoice']]);
                        $data_master['dealerID'] = substr($data_master['no_invoice'],0,6);
                        $this->crud_model->create('master_sales_order', html_escape($data_master));
						$id_master = $this->db->insert_id();
						$data_master['id_master'] = $id_master;

                        $details = $xml->Tablix8->xts_accountreceivableinvoice1_Collection->xts_accountreceivableinvoice1->Details1_Collection;
                        foreach ($details->Details1 as $rows => $content) {
                            $details_sales_order = [
                                'id_master' => $data_master['id_master'],
                                'no' => (string)$content->attributes()->Textbox251,
                                'xts_accountreceivableinvoice1' => (string)$content->attributes()->xts_accountreceivableinvoice1,
                                'deskripsi' => (string)$content->attributes()->Textbox5,
                                'jumlah'=> (double)$content->attributes()->Textbox8,
                                'satuan' => (string)$content->attributes()->Textbox74,
                                'harga' => (double)preg_replace( '/[^0-9]/', '', $content->attributes()->Textbox14),
                                'diskon' => (double)$content->attributes()->Textbox19,
                                'total' => (double)preg_replace( '/[^0-9]/', '', $content->attributes()->Textbox21),
                            ];
                            // print_r($details_sales_order);
                            $this->crud_model->create('details_sales_order', $details_sales_order);
                        }
                        
                    }else{
                        show_404();
                    }
                    
                }
                
                unlink($this->input->get('url'));
                redirect($tipe.'/print?id_master='.$data_master['id_master']);
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
            case 'details':
                $where = [
                  'id_details' => $this->input->post('id_details'),
                  'id_master' => $this->input->post('id_master')  
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
                }else if($kategori == "EQUIPMENT"){
                    $urutan = 5;
                }else if($kategori == "ACCESSORIES"){
                    $urutan = 6;
                }
                $sub_total_before = $this->input->post('harga_satuan') * $this->input->post('qty');
                $sub_total_after = $sub_total_before - $this->input->post('discount');
                $data = [
                    'kategori' => $kategori,
                    'urutan' => $urutan,
                    'harga_satuan' => $this->input->post('harga_satuan'),
                    'qty' => $this->input->post('qty'),
                    'sub_total_before' => $sub_total_before,
                    'discount' => $this->input->post('discount'),
                    'sub_total_after' => $sub_total_after,
                ];
                
                $this->crud_model->update('details_work_order', $where, $data);

                $dpp = $this->crud_model->sum('details_work_order','sub_total_after',['id_master' => $where['id_master']])->row();
                $ppn = $dpp->sub_total_after * 11 / 100;
                $grand_total = $dpp->sub_total_after + $ppn;
                $BeaMaterai = 0;
                if($grand_total > 5000000){
                    $BeaMaterai = 10000;
                    $grand_total = $grand_total + $BeaMaterai;
                }
                $data_master = [
                    'dpp' => intval($dpp->sub_total_after),
                    'ppn' => intval($ppn),
                    'BeaMaterai' => $BeaMaterai,
                    'grand_total' => intval($grand_total),
                    'terbilang' => number_to_words($grand_total).' Rupiah',
                ];
                $this->crud_model->update('master_work_order', ['id_master' => $where['id_master']], $data_master);
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
