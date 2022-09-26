<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sales_orders_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }


  public function read($where = null, $limit = null)
  {
    $this->db->select('
      details_sales_order.id_master AS id_master,
      master_sales_order.dealerID AS dealerID,
      master_sales_order.konsumen AS konsumen,
      master_sales_order.address AS address,
      master_sales_order.kota AS kota,
      master_sales_order.telp_fax AS telp_fax,
      master_sales_order.npwp AS npwp,
      master_sales_order.no_invoice AS no_invoice,
      master_sales_order.tgl_invoice AS tgl_invoice,
      master_sales_order.jatuh_tempo AS jatuh_tempo,
      master_sales_order.xts_type AS xts_type,
      master_sales_order.invoice_reference AS invoice_reference,
      master_sales_order.xts_deliveryordernumber AS xts_deliveryordernumber,
      master_sales_order.no_do AS no_do,
      master_sales_order.total_before AS total_before,
      master_sales_order.sum_MateraiValue AS sum_MateraiValue,
      master_sales_order.sum_AdministrasiValue AS sum_AdministrasiValue,
      master_sales_order.total_after AS total_after,
      master_sales_order.terbilang AS terbilang,
      master_sales_order.note_rek AS note_rek,

      details_sales_order.id_details AS id_details,
      details_sales_order.no AS no,
      details_sales_order.xts_accountreceivableinvoice1 AS xts_accountreceivableinvoice1,
      details_sales_order.deskripsi AS deskripsi,
      details_sales_order.jumlah AS jumlah,
      details_sales_order.satuan AS satuan,
      details_sales_order.harga AS harga,
      details_sales_order.diskon AS diskon,
      details_sales_order.total AS total,
    ');
    $this->db->from('details_sales_order');
    if (!empty($where)) {
      $this->db->where($where);
    }
    if (!empty($limit)) {
      $this->db->limit($limit);
    }
    $this->db->order_by('details_sales_order.no','ASC');
    $this->db->order_by('master_sales_order.created_at','DESC');
    $this->db->join('master_sales_order','master_sales_order.id_master = details_sales_order.id_master');
    $this->db->group_by('details_sales_order.id_details');
    $query = $this->db->get();
    return $query;
  }
}
