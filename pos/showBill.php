<?php
	ob_start();
	require 'myConnection.php';
	echo "<div id='billTitle'>";
	showTitle();
	echo "</div>";

	if(isset($_GET['x'])){
		$invoiceId=$_GET['x'];

		$sql="SELECT amount,invoice_id,return_id FROM returns WHERE refund_invoice_id='$invoiceId'";
		$result=mysql_query($sql);
		if (!$result) {
		    die('Invalid query: ' . mysql_error());
		}
		if(mysql_num_rows($result)){
			$row=mysql_fetch_array($result);
			$returnAmount=$row['amount'];
			$returnBillId=$row['invoice_id'];
			$returnId=$row['return_id'];
		}else{
			$returnAmount=0;
		}		
		

		$sql="SELECT selling_date,discount,vat,cash_given,cash_back,customer_name,customer_contact,accounts.employee_no,employee_name,employee_phone FROM invoices JOIN customers ON invoices.customer_id=customers.customer_id JOIN accounts ON invoices.employee_no=accounts.employee_no WHERE invoices.invoice_id='$invoiceId'";
		$result=mysql_query($sql);
		if (!$result) {
		    die('Invalid query: ' . mysql_error());
		}
		$row=mysql_fetch_array($result);

		$sellingDate=$row['selling_date'];
		$customerName=$row['customer_name'];
		$customerContact=$row['customer_contact'];
		$employeeNo=$row['employee_no'];
		$employeeName=$row['employee_name'];
		$employeeContact=$row['employee_phone'];
		$discount=$row['discount'];
		$vat=$row['vat'];
		$cashGiven=$row['cash_given'];
		$cashBack=$row['cash_back'];
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
		Employee No: $employeeNo<br>
		Employee name: $employeeName<br>
		Employee contact: $employeeContact<br>
		</div>

		
		<div id='billTable'>
		<h4><p align='center'><b>Product details</b></p></h4>
		
		";

		$sql="SELECT * FROM sales JOIN products ON sales.product_id=products.product_id WHERE invoice_id='$invoiceId'";
		$result=mysql_query($sql);
		if (!$result) {
		    die('Invalid query: ' . mysql_error());		
		}
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
		while($row=mysql_fetch_array($result)){
			$productId=$row['product_id'];
			$productName=$row['product_name'];
			$productType=$row['product_type'];
			$productCategory=$row['product_category'];
			$productSize=$row['product_size'];
			$productPrice=$row['product_price'];
			$quantity=$row['quantity'];
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

<body>
	<div>
		<button onclick="printBill();" id="printButton">Print Bill</button>		
	</div>	
</body>

</html>

