<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Crud_model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
    $this->spsarana_db = $this->load->database('spsarana_db', TRUE);
  }

  public function create($table, $data)
  {
    $this->db->insert($table,  $data);
  }

   public function read($table, $where = null, $order = null, $sort = null, $limit = null)
  {
    $this->db->from($table);
    if (!empty($where)) {
      $this->db->where($where);
    }
    if (!empty($order)) {
      $this->db->order_by($order, $sort);
    }
    if (!empty($limit)) {
      $this->db->limit($limit);
    }
    $query = $this->db->get();
    return $query;
  }

  public function update($table, $where, $data)
  {
    $this->db->where($where);
    $this->db->update($table, $data);
  }

  public function delete($table, $where)
  {
    $this->db->where($where)->delete($table);
  }

  public function sum($table, $sum, $where)
  {
    $this->db->select_sum($sum)
      ->where($where);
    $query = $this->db->get($table);
    return $query;
  }

  public function spsarana_read($table, $where = null, $order = null, $sort = null, $limit = null)
  {
    $this->spsarana_db->from($table);
    if ($where != null) {
      $this->spsarana_db->where($where);
    }
    if ($order != null) {
      $this->spsarana_db->order_by($order, $sort);
    }
    if ($limit != null) {
      $this->spsarana_db->limit($limit);
    }

    $query = $this->spsarana_db->get();
    return $query;
  }
}
