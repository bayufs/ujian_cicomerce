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
}