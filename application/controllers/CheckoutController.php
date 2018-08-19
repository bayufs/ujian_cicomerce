<?php

class CheckoutController extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('string');
        $this->load->library('cart');
        $this->load->model('Products');
        
    }
    public function getDetailOrder()
    {
        $name = $this->input->post('name');
        $phone = $this->input->post('phone');
        $destination_shipping = $this->input->post('destination_shipping');
       

        echo $output = "
        <ul class='alert alert-dark' id='detail_order'>
            <li><lable>Name</lable> : ".$name." <input type='hidden' name='name' value='".$name."'></li>
            <li><lable>Phone</lable> : ".$phone." <input type='hidden' name='phone' value='".$phone."'></li>
            <li><lable>Shipping Destination : </lable>".$destination_shipping." <input type='hidden' name='destination_shipping' value='".$destination_shipping."'></li>
        </ul>";

    }

    public function finishOrder()
    {
        $name = $this->input->post('name');
        $phone = $this->input->post('phone');
        $destination_shipping = $this->input->post('destination_shipping');

        $data = array(
            'order_code' => random_string('alnum', 10),
            'name' => $name,
            'phone' => $phone,
            'destination_shipping' => $destination_shipping
        );

        if($this->db->insert('order', $data)) {
            $order_code = $this->Products->getLastOrder();

            foreach($this->cart->contents() as $item){
                $data_detail_order = array(
                    'order_code' => $order_code->order_code,
                    'product_id' => $item['id'],
                    'qty' => $item['qty'],
                    'sub_total' => ($item['qty']*$item['price'])
                );
                $this->db->insert('order_detail', $data_detail_order);
            }
            
        } 
       
        return redirect('ShopingCartController/?successOrder');
    }
}