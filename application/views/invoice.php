<!DOCTYPE html>
<html>
<head>
  <title>Report Table</title>
  <style type="text/css">
    #outtable{
      padding: 20px;
      border:1px solid #e3e3e3;
      width:600px;
      border-radius: 5px;
    }
 
    .short{
      width: 50px;
    }
 
    .normal{
      width: 150px;
    }
 
    table{
      border-collapse: collapse;
      font-family: arial;
      color:#5E5B5C;
    }
 
    thead th{
      text-align: left;
      padding: 10px;
    }
 
    tbody td{
      border-top: 1px solid #e3e3e3;
      padding: 10px;
    }
 
    tbody tr:nth-child(even){
      background: #F6F5FA;
    }
 
    tbody tr:hover{
      background: #EAE9F5
    }
  </style>
</head>
<body>
	<div id="outtable">
  <h2 style="text-align:center">Invoice</h2>
	  <table>
	  	<thead>
          <tr>
           <th width="40%">Name</th>
           <th width="15%">Quantity</th>
           <th width="15%">Price</th>
           <th width="15%">Total</th>
           
          </tr>
	  	</thead>
	  	<tbody>
      <?php foreach($cart as $items) :?>
      <tr> 
          <td><?php echo $items->product_name  ?></td>
          <td><?php echo $items->qty  ?></td>
          <td><?php echo $items->product_price  ?></td>
          <td><?php echo $items->sub_total  ?></td>
         
         </tr>
        <?php endforeach;?>
       <tr>
          <td colspan="3" align="right">Total</td>
          <td><?php echo $total->sub_total ?></td>
         </tr>  		
	  	</tbody>
	  </table>

    <table>
      <tr>
        <td></td>
      </tr>
    </table>
    <ul>
        <li><span>ID ORDER : <mark><?php echo $shipping_order->order_code ?></mark></span></li>
        <li><span>Name : <?php echo $shipping_order->name ?></span></li>
        <li><span>Phone :<?php echo $shipping_order->phone ?> </span></li>
        <li><span>Destination Shipping :<?php echo $shipping_order->destination_shipping ?> </span></li>
    </ul>

	 </div>
</body>
</html>