<?php

class Products extends CI_Model
{
    public function getAllProduct()
    {
        return $this->db->order_by('product_id','DESC')->get('product')->result();
    }

    public function getLastOrder()
    {
        return $this->db->select('order_code')->order_by('id',"desc")->limit(1)->get('order')->row();
    }

    public function getInvoiceData($order_code)
    {
        $this->db->select('product.product_name,order_detail.qty, product.product_price, order_detail.sub_total');
        $this->db->from('order_detail');
        $this->db->where('order_detail.order_code', $order_code);
        $this->db->join('product', 'product.product_id  = order_detail.product_id');
        $query = $this->db->get()->result();
        return $query;

    }

    public function getTotalCost()
    {
        $this->db->select_sum('sub_total');
        $query = $this->db->get('order_detail');
        return $query->row();
    }

    public function getOrder($order_code)
    {
        return $this->db->get_where('order',array('order_code' => $order_code))->row();
    }
}