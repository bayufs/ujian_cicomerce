<?php

class PrintInvoice extends MY_Controller 
{

    public function __construnt()
    {
        parent::__construnt();
        $this->load->library('cart');
        $this->load->model(array('Products'));
    }

    public function invoice($order_code)
    {
        $data['cart'] = $this->Products->getInvoiceData($order_code);
        $data['total'] = $this->Products->getTotalCost();
        $data['shipping_order'] = $this->Products->getOrder($order_code);
        $mpdf = new \Mpdf\Mpdf();
        $path_to_template = $this->load->view('invoice',$data,true);
        $mpdf->WriteHTML($path_to_template);
        $mpdf->Output();

    }
}