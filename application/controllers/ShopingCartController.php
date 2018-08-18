<?php 

class ShopingCartController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Products');
    }
    public function index()
    {
        $products = $this->Products->getAllProduct();
        $this->load->view('mycart', compact('products'));
    }

    public function addToCart()
    {
               
        $data = array(
        "id"     => $_POST["product_id"],
        "name"   => $_POST["product_name"],
        "qty"    => $_POST["quantity"],
        "price"  => $_POST["product_price"]
        );
        $this->cart->insert($data);
        echo $this->view();
    }

    public function remove()
    {
         $row_id = $_POST["row_id"];
         $data = array(
         'rowid'  => $row_id,
         'qty'  => 0
         );
         $this->cart->update($data);
         echo $this->view();
    }

    public function clear()
    {
       
        $this->cart->destroy();
        echo $this->view();
    }

    public function view()
    {
   
        $output = '';
        $output .= '
         <table class="table table-bordered">
          <tr>
           <th width="40%">Name</th>
           <th width="15%">Quantity</th>
           <th width="15%">Price</th>
           <th width="15%">Total</th>
           <th width="15%">Action</th>
          </tr>
      
        ';
        $count = 0;
        foreach($this->cart->contents() as $items)
        {
         $count++;
         $output .= '
         <tr> 
          <td>'.$items["name"].'</td>
          <td>'.$items["qty"].'</td>
          <td>'.$items["price"].'</td>
          <td>'.$items["subtotal"].'</td>
          <td><button type="button" name="remove" class="btn btn-danger btn-xs remove_inventory" id="'.$items["rowid"].'">Remove</button></td>
         </tr>
         ';
        }
        $output .= '
         <tr>
          <td colspan="4" align="right">Total</td>
          <td>'.$this->cart->total().'</td>
         </tr>
        </table>
      
        </div>
        ';
      
        if($count == 0)
        {
         $output = '<h3 align="center">Cart is Empty</h3>';
        }
        return $output;
       }

       public function load()
       {
           echo $this->view();
       }

      
}