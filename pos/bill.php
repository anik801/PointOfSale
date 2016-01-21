<?php
	ob_start();
	require 'mask.php';	
	require 'loginCheck.php';

	if(isset($_GET['x'])){
		$sql="SELECT invoice_id FROM invoices ORDER BY selling_date DESC LIMIT 1";
		$result=mysql_query($sql);
		if (!$result) {
		    die('Invalid query: ' . mysql_error());
		}
		$row=mysql_fetch_array($result);
		$invoiceId=$row['invoice_id'];
		echo "<script>OpenInNewTab($invoiceId);</script>";
	}

	$sql="SELECT * FROM invoices ORDER BY selling_date DESC";
	$result=mysql_query($sql);
	if (!$result) {
	    die('Invalid query: ' . mysql_error());
	}
	if(mysql_num_rows($result)){
		echo "
		<div id='tableTitleDiv'>
		Bills List
		</div>
		";
		echo "
		<table class='table table-responsive sortable'>
			<thead>
				<tr>
					<td>Bill No.</td>
					<td>Date of Issue</td>
					<td>Amount</td>
					<td>Action</td>
				</tr>
			</thead>
			<tbody>
		";
		while($row=mysql_fetch_array($result)){
			$invoiceId=$row['invoice_id'];
			$sellingDate=$row['selling_date'];
			$amount=$row['cash_given']-$row['cash_back'];

			$sql2="SELECT SUM(product_price*quantity) AS total FROM `sales` JOIN products ON `sales`.`product_id`=`products`.`product_id` WHERE `sales`.`invoice_id`='$invoiceId'";
			$result2=mysql_query($sql2);
			if (!$result2) {
				die('Invalid query: ' . mysql_error());
			}
			$row2=mysql_fetch_array($result2);
			$total=$row2['total'];

			echo"
				<tr>
					<td>$invoiceId</td>
					<td>$sellingDate</td>
					<td>$amount</td>
					<td><input type='button' onClick='OpenInNewTab($invoiceId);' class='btn btn-info btn-xs' value='SHOW BILL'></td>					
				<tr>
			";
		}
		echo "
			</tbody>
		</table>
		";
	}else{
		echo "No bills issued yet.";
	}

?>

<!DOCTYPE html>
<html>

<head>
  <title>Bills</title>  
</head>

<body>	
	<div id="tableButtons">
		<a href="javascript:history.back()" class="btn btn-warning btn-sm">Back</a>
	</div>
</body>

</html>