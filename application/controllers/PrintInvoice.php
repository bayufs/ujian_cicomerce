<?php

class PrintInvoice extends MY_Controller 
{

    public function __construnt()
    {
        parent::__construnt();
        $this->load->library('cart');
    }
    public function invoice()
    {
        $data['cart'] = $this->cart->contents();
        $mpdf = new \Mpdf\Mpdf();
        $path_to_template = $this->load->view('invoice',$data,true);
        $mpdf->WriteHTML($path_to_template);
        $mpdf->Output();

    }
}