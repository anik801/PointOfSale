<?php
	ob_start();
	require 'mask.php';	
	require 'loginCheck.php';

	if(isset($_GET['x'])){
		$productId=$_GET['x'];

		$sql="SELECT * FROM products WHERE product_id='$productId'";
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
					</tr>
				";
			}
			echo"
				</tbody>
			</table>
			";
		}else{
			echo "Error: No products found.";
		}
	}
?>


<!DOCTYPE html>
<html>

<head>
  <title>Product Specification</title>  
</head>

<body>	
</body>

</html>
