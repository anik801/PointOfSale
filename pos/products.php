<?php
	ob_start();
	require 'mask.php';	
	require 'loginCheck.php';
 
	$sql="SELECT * FROM products JOIN stocks ON products.product_id=stocks.product_id WHERE stocks.is_deleted=0";
	$result=mysql_query($sql);
	if (!$result) {
	    die('Invalid query: ' . mysql_error());
	}
	if(mysql_num_rows($result)){
		echo "
		<div id='tableTitleDiv'>
		Products List
		</div>
		";
		echo"
		<table class='table table-responsive sortable'>
			<thead>
				<tr>
					<td>Product No.</td>
					<td>Product Name</td>
					<td>Type</td>
					<td>Category</td>
					<td>Size</td>
					<td>Price</td>
					<td>Available Quantity</td>
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
					<td><input type='button' value='DELETE' onclick='deleteProduct(\"$productId\");' class='btn btn-danger btn-xs'></td>
				</tr>
			";
		}
		echo"
			</tbody>
		</table>
		<div id='customerTotalText'>Please go to <a href='stocks.php'>stocks</a> page to import new product stock.</div>
		</div>
		";
	}else{
		echo "No products available currently.";
	}

?>

<!DOCTYPE html>
<html>

<head>
  <title>Products</title>  
</head>

<body>
	<div id="tableButtons">
		<a href="javascript:history.back()" class="btn btn-warning btn-sm">Back</a>
	</div>	
</body>

</html>