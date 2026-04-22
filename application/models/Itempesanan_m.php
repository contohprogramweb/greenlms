<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesananitem_m extends MY_Model
{

    protected $_table_name   = 'item_pesanan';
    protected $_primary_key  = 'orderitemID';
    protected $_orderitem_by = "priority desc";

    public function __construct()
    {
        parent::__construct();
    }

    public function get_orderitem($array = null, $single = false)
    {
        return parent::get($array, $single);
    }

    public function get_orderitem_by_orderitem($warray = null, $array = null, $single = false)
    {
        return parent::get_orderitem_by($warray, $array, $single);
    }

    public function get_single_orderitem($warray = null, $array = null, $single = true)
    {
        return parent::get_single($warray, $array, $single);
    }

    public function insert_orderitem($array)
    {
        return parent::insert($array);
    }

    public function update_orderitem($data, $id = null)
    {
        return parent::update($data, $id);
    }

    public function delete_orderitem($id)
    {
        return parent::delete($id);
    }

    public function get_order_by_orderitem_with_storebook($array)
    {
        $this->db->select('item_pesanan.*, buku_toko.name, buku_toko.coverphoto');
        $this->db->from($this->_table_name);
        $this->db->join('buku_toko', 'item_pesanan.storebookID=buku_toko.storebookID');
        if (isset($array['id_pesanan'])) {
            $this->db->where('item_pesanan.orderID', $array['id_pesanan']);
        }
        return $this->db->get()->result();
    }

    public function get_order_by_orderitem_with_sum($warray = null)
    {
        $this->db->select_sum('jumlah');
        $this->db->where($warray);
        return $this->db->get($this->_table_name)->row()->jumlah;
    }

}
