<?php
	session_start();
	$q = $_GET['q'];
	require 'myConnection.php';	
	$sql="SELECT * FROM returns WHERE invoice_id = '$q'";
	$result=mysql_query($sql);
	if (!$result) {
	    die('Invalid query: ' . mysql_error());
	}
	if(mysql_num_rows($result)){
		echo"
		<table class='table table-responsive'>
			<thead>
				<tr>
					<td>Return ID</td>
					<td>Date</td>
					<td>Bill No.</td>
					<td>Product No.</td>
					<td>Quantity</td>
					<td>Amount</td>
					<td>Refund Bill No.</td>
				</tr>
			</thead>
			<tbody>
		";
		while($row=mysql_fetch_array($result)){		
			$reutrnId=$row['return_id'];
			$reutrnDate=$row['return_date'];
			$invoiceId=$row['invoice_id'];
			$productId=$row['product_id'];
			$quantity=$row['quantity'];
			$amount=$row['amount'];
			$refundInvoiceId=$row['refund_invoice_id'];
			if($refundInvoiceId==='0'){
				$refundIvoiceId="N/A";
			}
			echo "
				<tr>
					<td>$reutrnId</td>
					<td>$reutrnDate</td>
					<td>$invoiceId</td>
					<td>$productId</td>
					<td>$quantity</td>
					<td>$amount</td>
					<td>$refundInvoiceId</td>
				</tr>
			";
		}
		echo"
			</tbody>
		</table>
		";
	}else{
		echo "No return information found.";
	}

?>