<?php
	ob_start();
	session_start();
	$q = $_GET['q'];
	require 'myConnection.php';	
	$sql="SELECT * FROM products WHERE product_name LIKE '%$q%'";
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
					<td>Type</td>
					<td>Category</td>
					<td>Size</td>
					<td>Price</td>
					<td>Available Quantity</td>
					<td>Sell Quantity</td>
					<td>Add to Cart</td>
				</tr>
			</thead>
			<tbody>
		";
		while($row=mysql_fetch_array($result)){			
			$flag="false";
			$productId=$row['product_id'];
			$productName=$row['product_name'];
			$productType=$row['product_type'];
			$productCategory=$row['product_category'];
			$productSize=$row['product_size'];
			$productPrice=$row['product_price'];

			if($productSize===""){
				$productSize="N/A";
			}
			$sql2="SELECT current_quantity FROM stocks WHERE product_id='$productId'";
			$result2=mysql_query($sql2);
			if (!$result2) {
				die('Invalid query: ' . mysql_error());
			}
			$row2=mysql_fetch_array($result2);
			$currentQuantity=$row2['current_quantity'];
			if($_SESSION['cart_item']>0){
				$cartItem=$_SESSION['cart_item'];
				for($i=1;$i<=$cartItem;$i++){
					$x="productId".$i;
					$y=$_SESSION[$x];
					if($productId===$y){
						$flag="true";
						break;
					}
				}
			}
			if($flag==="true"){
				continue;
			}

			$sellQuantityName="sq".$productId;

			
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
			
			echo "
				<tr>
					<td>$productId</td>
					<td>$productName</td>
					<td>$productTypeName</td>
					<td>$productCategoryName</td>
					<td>$productSize</td>
					<td>$productPrice</td>
					<td>$currentQuantity</td>
					<td><input type='text' class='form-control' name='$sellQuantityName' id='$sellQuantityName'></td>
					<td><input type='button' class='btn btn-sm btn-info' name='sellButton' id='sellButton' value='ADD' onclick='checkProductSell($sellQuantityName.value,$currentQuantity,\"$productId\");'></td>
				</tr>
			";
		}
		echo"
			</tbody>
		</table>
		";
	}else{
		echo "No products found of this name.";
	}

?>