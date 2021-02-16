<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Work_orders_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }


  public function read($where = null, $limit = null)
  {
    $this->db->select('
      details_work_order.id_master AS id_master,
      master_work_order.dealerID AS dealerID,
      master_work_order.alamat_kantor AS alamat_kantor,
      master_work_order.kota_kantor AS kota_kantor,
      master_work_order.telp_kantor AS telp_kantor,
      master_work_order.npwp_kantor AS npwp_kantor,
      master_work_order.no_invoice AS no_invoice,
      master_work_order.no_wo AS no_wo,
      master_work_order.service_category AS service_category,
      master_work_order.no_pelanggan AS no_pelanggan,
      master_work_order.nik AS nik,
      master_work_order.nm_pelanggan AS nm_pelanggan,
      master_work_order.alamat_pelanggan AS alamat_pelanggan,
      master_work_order.th_produksi AS th_produksi,
      master_work_order.no_telp AS no_telp,
      master_work_order.CurrentMileageWOValue AS CurrentMileageWOValue,
      master_work_order.no_polisi AS no_polisi,
      master_work_order.tgl_masuk AS tgl_masuk,
      master_work_order.tgl_keluar AS tgl_keluar,
      master_work_order.model AS model,
      master_work_order.no_rangka AS no_rangka,
      master_work_order.MethodOfPayment7 AS MethodOfPayment7,
      master_work_order.dpp AS dpp,
      master_work_order.ppn AS ppn,
      master_work_order.BeaMaterai AS BeaMaterai,
      master_work_order.grand_total AS grand_total,
      master_work_order.terbilang AS terbilang,
      master_work_order.keterangan AS keterangan,
      master_work_order.dicetak_oleh AS dicetak_oleh,
      master_work_order.created_by AS created_by,
      master_work_order.created_at AS created_at,

      details_work_order.id_details AS id_details,
      details_work_order.kode AS kode,
      details_work_order.keterangan AS keterangan,
      details_work_order.harga_satuan AS harga_satuan,
      details_work_order.qty AS qty,
      details_work_order.sub_total_before AS sub_total_before,
      details_work_order.discount AS discount,
      details_work_order.sub_total_after AS sub_total_after,
      details_work_order.urutan AS urutan,
      details_work_order.kategori AS kategori
    ');
    $this->db->from('details_work_order');
    if (!empty($where)) {
      $this->db->where($where);
    }
    if (!empty($limit)) {
      $this->db->limit($limit);
    }
    $this->db->order_by('details_work_order.urutan','ASC');
    $this->db->order_by('master_work_order.created_at','DESC');
    $this->db->order_by('details_work_order.created_at','ASC');
    $this->db->join('master_work_order','master_work_order.id_master = details_work_order.id_master');
    $this->db->group_by('details_work_order.id_details');
    $query = $this->db->get();
    return $query;
  }
}
