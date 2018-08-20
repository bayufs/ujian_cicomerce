<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo site_url('asset/css/my_custom.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
<?php
if(isset($_GET['successOrder'])) {
    echo "<script>alert('Your Order Is Successfull')</script>";
}
?>
<div class="container header">
    <div class="row">
        <div class="col-md-12">
            <header class="text-center">
               <h1>Dumet Store</h1>
           </header>
        </div>
    </div>
</div>

<div class="container article">
    <div class="row">
        <div class="col-md-6">
            <div class="row-eq-height">
                <div class="col-md-12">
                <?php foreach($products as $product) : ?>
                    <div class="products text-center">
                        <p><img src="<?php echo base_url('asset/images/'.$product->product_image) ?>" class="img-fluid" alt=""></p>
                        <p class="title"><?php echo $product->product_name ?></p>
                        <p class="price">IDR.<?php echo $product->product_price ?></p>
                        <p class="qty"><input type="number" id="<?php echo $product->product_id  ?>"  class="form-control " name="qty" value="" \></p>
                        <p class="btn-add"><button  class="btn btn-primary add_cart" data-productname="<?php echo $product->product_name ?>" data-price="<?php echo $product->product_price ?>" data-productid="<?php echo $product->product_id ?>">Add</button></p>
                    </div>
                    <?php endforeach; ?> 
                </div>          
            </div>
        </div>
        <div class="col-md-6">
            <div class="cart-table">
             <button type="submit" id="clear_cart" class="btn btn-warning float-right">Clear Cart</button>
            <table class="table table-bordered cart_details">
                <thead>
                    <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                    <th scope="col">Total</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead> 
        </table>
        <p><button class="btn btn-success" id="place_holder"
        <?php $a =  (count($this->cart->contents()) == 0) ?  "disabled = 'disabled'" : ""; ?>
        <?php echo $a; ?>
         >Place Order</button></p>
          
          <?php if($this->uri->segment(2) == 'finishOrder') { ?>
             <p><a href="<?php echo site_url('PrintInvoice/invoice/'.$order_code->order_code) ?>" class="btn btn-primary" id="print_invoice">Print Invoice</a></p>   
          <?php } ?>
            </div>
            <div class="shipping" id="shipping">
                <form action="" method="post">
                    <div class="form-group">
                      <label for="">Name</label>
                      <input type="text" name="" id="name" class="form-control" placeholder="" >
                    </div>
                    <div class="form-group">
                      <label for="">Phone</label>
                      <input type="text" name="" id="phone" class="form-control" placeholder="" >
                    </div>
                    <div class="form-group">
                      <label for="">Destination shipping</label>
                      <textarea class="form-control" name="" id="destination_shipping" cols="30" rows="10"></textarea>
                    </div>
                    <div class="form-group">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                    <button type="button" id="detail_order"  class="btn btn-dark" data-toggle="modal" data-target="#exampleModal">Detail Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- modal-->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Order</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?php echo site_url('CheckoutController/finishOrder') ?>" method="POST">
      <div class="modal-body detail_order">
        
      </div>
      <div class="modal-footer">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Finish Order</button>
      </form>
      </div>
    </div>
  </div>
</div>
<!-- end modal -->

<footer class="container footer text-center">
    <div class="row">
        <div class="col-md-12">
         <p>&copy;Copyright: 2018 - Bayong</p>
        </div>
    </div>
</footer>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js"></script>  

<script>


    $('#myModal').on('shown.bs.modal', function () {
    $('#myInput').trigger('focus')
    })

    

    
</script>
<script>
$(document).ready(function(){
 
 $('.add_cart').click(function(){
  var product_id = $(this).data("productid");
  var product_name = $(this).data("productname");
  var product_price = $(this).data("price");
  var quantity = $('#' + product_id).val();

  if(quantity != '' && quantity > 0)
  {
   $.ajax({
    url:"<?php echo base_url(); ?>ShopingCartController/addToCart",
    method:"POST",
    data:{'<?php echo $this->security->get_csrf_token_name();?>' :'<?php echo $this->security->get_csrf_hash();?>',product_id:product_id, product_name:product_name, product_price:product_price, quantity:quantity},
    success:function(data)
    {
     alert("Product Added into Cart");
     
     $(".cart_details").html(data);
     $('#' + product_id).val('');
     $('#place_holder').removeAttr('disabled');
    }
   });
  }
  else
  {
   alert("Please Enter quantity");
  }
 });

 $('.cart_details').load("<?php echo base_url(); ?>ShopingCartController/load");

 $(document).on('click', '.remove_inventory', function(){
  var row_id = $(this).attr("id");
  if(confirm("Are you sure you want to remove this?"))
  {
   $.ajax({
    url:"<?php echo base_url(); ?>ShopingCartController/remove",
    method:"POST",
    data:{'<?php echo $this->security->get_csrf_token_name();?>' :'<?php echo $this->security->get_csrf_hash();?>',row_id:row_id},
    success:function(data)
    {
     alert("Product removed from Cart");
     $('.cart_details').html(data);
     $('#place_holder').attr('disabled','disabled');
    }
   });
  }
  else
  {
   return false;
  }
 });

 $(document).on('click', '#clear_cart', function(){
  if(confirm("Are you sure you want to clear cart?"))
  {
   $.ajax({
    url:"<?php echo base_url(); ?>ShopingCartController/clear",
    method:'GET',
    data: {'<?php echo $this->security->get_csrf_token_name();?>' :'<?php echo $this->security->get_csrf_hash();?>'},
    success:function(data)
    {
     alert("Your cart has been clear...");
     $('.cart_details').html(data);
     $('#place_holder').attr('disabled','disabled');
    }
   });
  }
  else
  {
   return false;
  }
 });

});
</script>


<script>
$(document).ready(function(){
    $('#place_holder').click(function(){
        var data_cart = $(this).data('cart');
        if(data_cart == 0) {
            alert('Your cart is empty !');
        } else {
            $('.shipping').removeClass('shipping');
        }
    });
});
</script>


<script>
$(document).ready(function(){
    $('#detail_order').click(function(){
        var name = $('#name').val();
        var phone = $('#phone').val();
        var destination_shipping = $('#destination_shipping').val();

        $.ajax({
            url:"<?php echo base_url(); ?>CheckoutController/getDetailOrder",
            method:'POST',
            data: {'<?php echo $this->security->get_csrf_token_name();?>' :'<?php echo $this->security->get_csrf_hash();?>',
                'name':name,
                'phone':phone,
                'destination_shipping':destination_shipping,
            },
            success:function(data)
            {
            
              $('.detail_order').html(data);
        
            }
        });

    });
});
</script>
</body>
</html>