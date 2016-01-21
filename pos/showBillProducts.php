<?php
	session_start();
	$invoiceId = $_GET['q'];
	require 'myConnection.php';	
	$sql="SELECT * FROM products JOIN sales ON products.product_id=sales.product_id JOIN invoices ON invoices.invoice_id=sales.invoice_id WHERE sales.invoice_id = '$invoiceId'";
	$result=mysql_query($sql);
	if (!$result) {
	    die('Invalid query: ' . mysql_error());
	}
	if(mysql_num_rows($result)){
		echo"
		<table class='table table-responsive'>
			<thead>
				<tr>
					<td>Product No.</td>
					<td>Product Name</td>
					<td>Date</td>
					<td>Type</td>
					<td>Category</td>
					<td>Size</td>
					<td>Price</td>
					<td>Return Quantity</td>
					<td>Action</td>
				</tr>
			</thead>
			<tbody>
		";
		while($row=mysql_fetch_array($result)){		
			$productId=$row['product_id'];
			$productName=$row['product_name'];
			$productType=$row['product_type'];
			$productCategory=$row['product_category'];
			$productSize=$row['product_size'];
			$productPrice=$row['product_price'];
			$date=$row['selling_date'];
			$quantity=$row['quantity'];
			$returnQuantity=$row['return_quantity'];
			$quantity-=$returnQuantity;
			if($productSize===""){
				$productSize="N/A";
			}
			
			$sql2="SELECT type_name FROM types WHERE type_id='$productType'";
			$result2=mysql_query($sql2);
			if (!$result2) {
				die('Invalid query: ' . mysql_error());
			}
			$row2=mysql_fetch_array($result2);
			$productTypeName=$row2['type_name'];
			if($productTypeName===null)
				$productTypeName="N/A";

			$sql2="SELECT category_name FROM categories WHERE category_id='$productCategory'";
			$result2=mysql_query($sql2);
			if (!$result2) {
				die('Invalid query: ' . mysql_error());
			}
			$row2=mysql_fetch_array($result2);
			$productCategoryName=$row2['category_name'];
			if($productCategoryName===null)
				$productCategoryName="N/A";
			$returnSelectId="returnSelect".$productId;
			echo "
				<tr>
					<td>$productId</td>
					<td>$date</td>
					<td>$productName</td>
					<td>$productTypeName</td>
					<td>$productCategoryName</td>
					<td>$productSize</td>
					<td>$productPrice</td>
					
					<td>
						<select id='$returnSelectId' class='form-control'>
						";
						for($i=0;$i<=$quantity;$i++){
							echo"<option value='$i'>$i</option>";
						}
					echo "
						</select>
					</td>
					<td><input type='button' class='btn btn-sm btn-info' name='reutrnButton' id='reutrnButton' value='RETURN' onclick='checkReturn($invoiceId,\"$productId\");'></td>
				</tr>
			";
		}
		echo"
			</tbody>
		</table>
		";
	}else{
		echo "No products found by this Bill No.";
	}

?>