<?php
	ob_start();
	require 'mask.php';	
	require 'loginCheck.php';

	if(isset($_POST['stockSubmit'])){
		$stockId=$_POST['stockId'];
		$productId=$_POST['productId'];
		$importQuantity=$_POST['quantity'];
		$productName=$_POST['productName'];
		$productSize=$_POST['productSize'];
		$buyingPrice=$_POST['buyingPrice'];
		$productPrice=$_POST['productPrice'];
		$productCategory=$_POST['categoryName'];
		$productType=$_POST['typeName'];

		$sql="SELECT product_id FROM products WHERE product_id='$productId'";
		$result=mysql_query($sql);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		}
		if(mysql_num_rows($result)){
			echo "
				<script>
				alert('Product ID already exists.');
				</script>
			";
		}else{
			$sql="INSERT INTO products (`product_id`, `product_name`, `product_type`, `product_category`, `product_size`, `product_price`,`buying_price`) VALUES ('$productId','$productName','$productType','$productCategory','$productSize','$productPrice','$buyingPrice')";
			$result=mysql_query($sql);
			if (!$result) {
				die('Invalid query: ' . mysql_error());
			}
			$sql="INSERT INTO stocks (`stock_id`, `product_id`, `import_quantity`, `current_quantity`, `import_date`) VALUES ('$stockId','$productId','$importQuantity','$importQuantity',now())";
			$result=mysql_query($sql);
			if (!$result) {
				die('Invalid query: ' . mysql_error());
			}
		}
		
	}

	$sql="SELECT * FROM stocks WHERE is_deleted=0 ORDER BY import_date DESC";
	$result=mysql_query($sql);
	if (!$result) {
	    die('Invalid query: ' . mysql_error());
	}
	if(mysql_num_rows($result)){
		echo "
		<div id='tableTitleDiv'>
		Stocks List
		</div>
		";
		echo"
		<table class='sortable table table-responsive '>
			<thead>
				<tr>
					<td>Stock No.</td>
					<td>Product No.</td>
					<td>In Stock Quantity</td>
					<td>Sold Quantity</td>
					<td>Total Quantity</td>
					<td>Unit Price (Buy)</td>
					<td>Import Date</td>	
					<td>Action</td>				
				</tr>
			</thead>
			<tbody>
		";
		while($row=mysql_fetch_array($result)){
			$stockID=$row['stock_id'];
			$productId=$row['product_id'];
			$totalQuantity=$row['import_quantity'];
			$currentQuantity=$row['current_quantity'];
			$importDate=$row['import_date'];
			$soldQuantity=$totalQuantity-$currentQuantity;

			$sql2="SELECT buying_price FROM products WHERE product_id='$productId'";
			$result2=mysql_query($sql2);
			if (!$result2) {
			    die('Invalid query: ' . mysql_error());
			}
			$row2=mysql_fetch_array($result2);
			$buyingPrice=$row2['buying_price'];
			echo "
				<tr>
					<td>$stockID</td>
					<td>$productId</td>
					<td>$currentQuantity</td>
					<td>$soldQuantity</td>
					<td>$totalQuantity</td>		
					<td>$buyingPrice</td>
					<td>$importDate</td>
					<td><input type='button' value='DELETE FULL STOCK' onclick='deleteStock(\"$stockID\");' class='btn btn-danger btn-xs'></td>
				</tr>
			";
		}
		echo"
			</tbody>
		</table>
		";
	}else{
		echo "No stocks available currently.";
	}

?>

<!DOCTYPE html>
<html>

<head>
  <title>Stocks</title>  
  <script type="text/javascript">
  //AJAX function to dynamically display types based on categories.
  	function showType(str) {
	  if (str=="") {
	    document.getElementById("txtHint").innerHTML="";
	    return;
	  } 
	  if (window.XMLHttpRequest) {
	    // code for IE7+, Firefox, Chrome, Opera, Safari
	    xmlhttp=new XMLHttpRequest();
	  } else { // code for IE6, IE5
	    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  xmlhttp.onreadystatechange=function() {
	    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	      document.getElementById("typeDiv").innerHTML=xmlhttp.responseText;
	    }
	  }
	  xmlhttp.open("GET","getTypes.php?q="+str,true);
	  xmlhttp.send();
	}
  </script>
</head>

<body>
	<div id="tableButtons">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
			<a class="btn btn-sm btn-info" href="#stockForm" role="button" data-toggle="modal" id="newStock">Add New Product Stock</a>
			<a href="javascript:history.back()" class="btn btn-warning btn-sm">Back</a>
		</form>
		
	</div>



	<div class="modal fade" id="stockForm">
	  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	  <div class="modal-dialog" id="signinDialog">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
	          <h4 class="modal-title">Add New Product Stock</h4>
	        </div>

	        <div class="modal-body">
	          <input class="form-control" id="stockId" name="stockId" placeholder="Enter Stock No." required type="text">	        
	          <input class="form-control" id="productId" name="productId" placeholder="Enter Product No." required type="text">
	          <input class="form-control" id="quantity" name="quantity" placeholder="Enter quantity." required type="text">
	          <input class="form-control" id="productName" name="productName" placeholder="Enter Product Name." required type="text">
	          <input class="form-control" id="productSize" name="productSize" placeholder="Enter Product Size."  type="text">
	          <input class="form-control" id="buyingPrice" name="buyingPrice" placeholder="Enter Buying Price." required type="text">
	          <input class="form-control" id="productPrice" name="productPrice" placeholder="Enter Selling Price." required type="text">
	          <!--Current date is automatically added.-->

	           	<?php
	          		$sql="SELECT category_id,category_name FROM categories";
	          		$result=mysql_query($sql);
					if (!$result) {
					    die('Invalid query: ' . mysql_error());					}
					echo "<select name='categoryName' class='form-control' onchange='showType(this.value)'>";
					echo "<option value='0'>N/A</option>";
					while($row=mysql_fetch_array($result)){
						$name=$row['category_name'];
						$id=$row['category_id'];
						echo "<option value='$id'>$name</option>";
					}
					echo "</select>";
	          	?>
	    	  <div id="typeDiv">
	    	  </div>

	        </div>

	        <div class="modal-footer">
	          <a href="#" data-dismiss="modal" class="btn btn-default">Close</a>      
	          <input type="submit" class="btn btn-primary" id="stockSubmit" name ="stockSubmit" value="Create">     
	        </div>
	      </div>
	    </div>
	  </form> 
	</div>


</body>

</html>