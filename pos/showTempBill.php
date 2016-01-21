<?php
	ob_start();
	session_start();
	require 'myConnection.php';
	echo "<div id='billTitle'>";
	showTitle();
	echo "</div>";
	if(isset($_SESSION['cart_item']))	
		$cartItem=$_SESSION['cart_item'];
	

	if(isset($_GET['x'])){		
		$invoiceId="##";	

		$sellingDate=date("Y-m-d H:i:s",time()+14400);
		$customerName=$_GET['x'];
		$customerContact=$_GET['y'];
		$discount=$_GET['p'];
		$vat=$_GET['q'];
		$cashGiven=$_GET['r'];		
		$employeeId=$_SESSION['id'];	

		$returnId=$_GET['a'];
		$sql="SELECT amount,invoice_id FROM returns WHERE return_id='$returnId'";
		$result=mysql_query($sql);
		if (!$result) {
		    die('Invalid query: ' . mysql_error());
		}
		if(mysql_num_rows($result)){
			$row=mysql_fetch_array($result);
			$returnAmount=$row['amount'];
			$returnBillId=$row['invoice_id'];
		}else{
			$returnAmount=0;
		}

		$sql="SELECT employee_name,employee_phone FROM accounts WHERE account_id='$employeeId'";
		$result=mysql_query($sql);
		if (!$result) {
		    die('Invalid query: ' . mysql_error());
		}
		$row=mysql_fetch_array($result);

		$employeeName=$row['employee_name'];
		$employeeContact=$row['employee_phone'];

		echo "
		<br>
		<div id='leftDiv'>Bill No: $invoiceId</div>
		<div id='rightDiv'>Date: $sellingDate</div>
		<hr>
		<div id='leftDiv70'>
		<b>Customer Information</b><br>
		Customer name: $customerName<br>
		Customer contact: $customerContact<br>
		</div>

		<div id='rightDiv30'>
		<b>Salesman Information</b><br>
		Employee No: $employeeId<br>
		Employee name: $employeeName<br>
		Employee contact: $employeeContact<br>
		</div>

		
		<div id='billTable'>
		<h4><p align='center'><b>Product details</b></p></h4>
		
		";

		echo "
		<table class='table table-responsive sortable'>
			<thead>
				<tr>
					<td>Product ID</td>
					<td>Product Name</td>
					<td>Size</td>
					<td>Unit Price</td>
					<td>Quantity</td>
					<td>Total Price</td>
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

			$sql="SELECT * FROM products WHERE product_id='$productId'";
			$result=mysql_query($sql);
			if (!$result) {
			    die('Invalid query: ' . mysql_error());		
			}
			$row=mysql_fetch_array($result);

			$productName=$row['product_name'];
			$productType=$row['product_type'];
			$productCategory=$row['product_category'];
			$productSize=$row['product_size'];
			$productPrice=$row['product_price'];


			$total=$productPrice*$quantity;
			$sum+=$total;
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
			
			echo "
				<tr>
					<td>$productId</td>
					<td>$productName</td>
					<td>$productSize</td>
					<td>$productPrice</td>
					<td>$quantity</td>
					<td>$total</td>					
				</tr>
			";
		}
		echo "
			</tbody>
		</table>
		<hr>
		<div id='billTotal'>";

		$subTotal=$sum;
		$sum-=$returnAmount;
		//$totalDiscount=ceil($sum*$discount/100);
		//$totalVat=ceil(($sum-$totalDiscount)*$vat/100);
		$totalDiscount=($sum*$discount/100);
		$totalVat=(($sum-$totalDiscount)*$vat/100);
		$finalSum=$sum-$totalDiscount+$totalVat;
		$cashBack=$cashGiven-$finalSum;

		if($returnAmount>0){
			echo "
			Sub total: $subTotal<br>
			Refund amount (Bill# $returnBillId): $returnAmount<br>
			";
		}else{
			echo "
			Sub total: $subTotal<br>
			";
		}

		if($totalDiscount>0 && $totalVat>0){
			echo "
			Discount: $totalDiscount<br>
			VAT: $totalVat<br>
			<hr>
			";
		}else if($totalDiscount>0){
			echo "
			Discount: $totalDiscount<br>
			<hr>
			";
		}else if($totalVat>0){
			echo "
			VAT: $totalVat<br>
			<hr>			
			";
		}

		echo "
			Total: $finalSum<br>
			<hr>
			Paid: $cashGiven<br>
			Bill: $finalSum<br>
			Return: $cashBack<br>
		</div>
		</div>
		<br><br><br><br>
		<div id='leftDiv'>
			Customers Signature & Date
		</div>
		<div id='rightDiv'>
			Emplyee's Signature & Date
		</div><br><br><br><br>
		";
	}else{
		header('Location: sale.php');
	}
	function showTitle(){
	    require 'myConnection.php';
	    $sql="SELECT company_name FROM company";
	    $result=mysql_query($sql);
	    if (!$result) {
	        die('Invalid query: ' . mysql_error());
	    }
	    $row=mysql_fetch_array($result);
	    $companyName=$row['company_name'];

	    echo $companyName;
  	}
	

	
	if(isset($_GET['z'])){
		//Selecting customer
		$sellingDate=date("Y-m-d H:i:s",time()+14400);
		$customerName=$_GET['x'];
		$customerContact=$_GET['y'];
		$employeeId=$_SESSION['id'];

		$discount=$_GET['p'];
		$vat=$_GET['q'];
		$cashGiven=$_GET['r'];
		$cashReturn=$_GET['s'];

		$returnId=$_GET['a'];
		$sql="SELECT amount,invoice_id FROM returns WHERE return_id='$returnId'";
		$result=mysql_query($sql);
		if (!$result) {
		    die('Invalid query: ' . mysql_error());
		}
		if(mysql_num_rows($result)){
			$row=mysql_fetch_array($result);
			$returnAmount=$row['amount'];
			$returnBillId=$row['invoice_id'];
		}else{
			$returnAmount=0;
		}


		$sql="SELECT customer_id FROM customers WHERE customer_name='$customerName' AND customer_contact='$customerContact'";
		$result=mysql_query($sql);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		}
		if(!mysql_num_rows($result)){
			$sql="INSERT INTO customers (customer_name,customer_contact) VALUES ('$customerName','$customerContact')";
			$result=mysql_query($sql);
			if (!$result) {
				die('Invalid query: ' . mysql_error());
			}
			$sql="SELECT customer_id FROM customers WHERE customer_name='$customerName' AND customer_contact='$customerContact'";
			$result=mysql_query($sql);
			if (!$result) {
				die('Invalid query: ' . mysql_error());
			}

		}
		$row=mysql_fetch_array($result);
		$customerId=$row['customer_id'];

		//Set current date and time
		$entryDate=$sellingDate;

		//Creating invoice
		$sql="INSERT INTO invoices (selling_date,customer_id,employee_no,discount,vat,cash_given,cash_back) VALUES ('$entryDate','$customerId','$employeeId','$discount','$vat','$cashGiven','$cashReturn')";
		$result=mysql_query($sql);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		}
		$sql="SELECT invoice_id FROM invoices WHERE selling_date='$entryDate'";
		$result=mysql_query($sql);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		}
		$row=mysql_fetch_array($result);
		$invoiceId=$row['invoice_id'];

		$sum=0;
		for($i=1;$i<=$cartItem;$i++){
			$x="productId".$i;
			$y="quantity".$i;
			$productId=$_SESSION[$x];
			$quantity=$_SESSION[$y];

			$sql="INSERT INTO sales (invoice_id,product_id,quantity) VALUES ('$invoiceId','$productId','$quantity')";
			$result=mysql_query($sql);
			if (!$result) {
				die('Invalid query: ' . mysql_error());
			}

			$sql="SELECT current_quantity FROM stocks WHERE product_id='$productId'";
			$result=mysql_query($sql);
			if (!$result) {
				die('Invalid query: ' . mysql_error());
			}
			$row=mysql_fetch_array($result);
			$currentQuantity=$row['current_quantity'];		
			$newQuantity=$currentQuantity-$quantity;

			$sql="UPDATE stocks SET current_quantity='$newQuantity' WHERE product_id='$productId'";
			$result=mysql_query($sql);
			if (!$result) {
				die('Invalid query: ' . mysql_error());
			}

			$sql="SELECT product_price FROM products WHERE product_id='$productId'";
			$result=mysql_query($sql);
			if (!$result) {
				die('Invalid query: ' . mysql_error());
			}
			$row=mysql_fetch_array($result);
			$price=$row['product_price'];
			$sum+=$quantity*$price;

		}
		$sum-=$returnAmount;
		$sql="UPDATE invoices SET amount='$sum' WHERE invoice_id='$invoiceId'";
		$result=mysql_query($sql);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		}

		$sql="UPDATE returns SET refund_invoice_id='$invoiceId' WHERE return_id='$returnId'";
		$result=mysql_query($sql);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		}

		echo "
		<script>			
			document.location.href='bill.php?x=1';
		</script>
		";
		//header("Location: bill.php");
	}
?>


<!DOCTYPE html>
<html>

<head>
  <title>Bill Copy</title>  
  <link rel="stylesheet" type="text/css" href="apiFiles/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="apiFiles/bootstrap-theme.css">
  <script type="text/javascript" src="apiFiles/jquery-1.10.2.min.js"></script>
  <script type="text/javascript" src="apiFiles/bootstrap.js"></script>
  <script type="text/javascript" src="apiFiles/bootbox.js"></script>

  <link rel="icon" href="images/icon.ico">
  <link rel="stylesheet" type="text/css" href="css/pageStyle.css">
  <script type="text/javascript" src="scripts/myscripts.js"></script>

</head>

<body id="tempBillBody">
	<div>
		<?php
			echo "<button class='btn btn-info btn-sm' onclick='finalizeCart(\"$customerName\",\"$customerContact\",$discount,$vat,$cashGiven,$cashBack,$returnId);' id='printButton'>Confirm Bill</button>";
		?>
		<a href="javascript:history.back()" class="btn btn-warning btn-sm">Back</a>

	</div>	
</body>

</html>

