<?php
	{
		session_start();		
		require 'myConnection.php';
		$cartItem=$_SESSION['cart_item'];
		if($cartItem>0){
			echo "
				<table class='table table-responsive'>
					<thead>
						<tr>
							<td>Product ID</td>
							<td>Product Name</td>
							<td>Quantity</td>
						</tr>
					</thead>
					<tbody>
			";
			$sum=0;
			for($i=1;$i<=$cartItem;$i++){
				$x="productId".$i;
				$y="quantity".$i;
				$productId=$_SESSION[$x];
				$quantity=$_SESSION[$y];

				$sql="SELECT product_name,product_price FROM products WHERE product_id='$productId'";
				$result=mysql_query($sql);
				if (!$result) {
				    die('Invalid query: ' . mysql_error());
				}
				$row=mysql_fetch_array($result);
				$productName=$row['product_name'];
				$price=$row['product_price'];
				$sum+=$price*$quantity;
				echo "
						<tr>
							<td>$productId</td>
							<td>$productName</td>
							<td>$quantity</td>
						</tr>
				";
			}
			echo "
					</tbody>
				</table>
			";
			echo '
						<div>
				        	<label>Name: </label><input type="text" name="name" id="name" required class="form-control" placeholder="Enter customer name here.">
				        	<label>Phone: </label><input type="text" name="contact" id="contact" required class="form-control" placeholder="Enter customer contact number here.">
				        	
				        	<label>Sale Type: </label>
				        	<select name="saleType" id="saleType" class="form-control" onchange="returnSelect(this.value)">
				        		<option value="0">New sale</option>
				        		<option value="1">Return sale</option>
				        	</select>
				        	<div id="returnIdDiv"><label>Return Id: </label><input type="text" name="returnId" id="returnId" class="form-control" placeholder="Enter the Return ID." onblur="changeMinimum(this.value)"></div>
				        	<label>Cash Given: </label><input type="text" name="cash" id="cash" required class="form-control" placeholder="Enter the amount of cash given by the customer. Minimum: '.$sum.'">
				        	<label>Discount Percentage: </label><input type="text" name="discount" id="discount" required class="form-control" placeholder="Enter discount percentage (0 to 100)." value="0">
				        	<label>VAT Percentage: </label><input type="text" name="vat" id="vat" required class="form-control" placeholder="Enter VAT percentage (0 to 100)." value="0">
							<div class="hiddenDiv">
								<input type="text" id="temp" value="'.$sum.'">
								<input type="text" id="returnCashTemp">
							</div>
				        </div>
				        <div class="modal-footer">
				          <a href="#" data-dismiss="modal" class="btn btn-default">Close</a>      
				          <input type="button" class="btn btn-primary" value="Proceed" onClick="checkCart('.$sum.');" />
				          <input type="submit" id="cartSubmit" name ="cartSubmit" style="display:none">
				        </div>
			';
		}else{
			echo "No items in the cart.";
			echo '
				        <div class="modal-footer">
				          <a href="#" data-dismiss="modal" class="btn btn-default">Close</a>          
				        </div>
			';
		}
	}
?>
