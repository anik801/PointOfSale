<?php
	ob_start();
	require 'mask.php';	
	require 'loginCheck.php';
	require 'supervisorCheck.php';

	if(isset($_GET['type']) && isset($_GET['d1']) && isset($_GET['d2'])){
		$type=$_GET['type'];
		$startingDate=$_GET['d1'];
		$endingeDate=$_GET['d2'];

		//echo $type." ".$startingDate." ".$endingeDate;
		if($type==="sales"){
			$sql="SELECT invoices.invoice_id,invoices.selling_date, products.product_id,products.product_name,products.product_price,products.buying_price,sales.quantity FROM sales JOIN invoices ON sales.invoice_id=invoices.invoice_id JOIN products ON sales.product_id=products.product_id WHERE invoices.selling_date>='$startingDate' AND invoices.selling_date<='$endingeDate'";
			$result=mysql_query($sql);
			if (!$result) {
			    die('Invalid query: ' . mysql_error());		
			}
			if(mysql_num_rows($result)){
				echo "
				<div id='tableTitleDiv'>
				Sales Report
				</div>
				";
				echo "
				<table class='table table-responsive sortable'>
					<thead>
						<tr>
							<td>Bill No.</td>
							<td>Date</td>
							<td>Product ID</td>
							<td>Product Name</td>
							<td>Quantity</td>	
							<td>Buying Price</td>
							<td>Total Buy</td>												
							<td>Sold Price</td>
							<td>Total Sale</td>							
						</tr>
					</thead>
					<tbody>
				";
				$sumBuy=0;
				$sumSold=0;
				while($row=mysql_fetch_array($result)){
					$invoiceId=$row['invoice_id'];
					$sellingDate=$row['selling_date'];
					$productId=$row['product_id'];
					$productName=$row['product_name'];										
					$quantity=$row['quantity'];

					$buyingPrice=$row['buying_price'];
					$sellingPrice=$row['product_price'];
					$totalBuy=$buyingPrice*$quantity;
					$totalSold=$sellingPrice*$quantity;
					$sumBuy+=$totalBuy;
					$sumSold+=$totalSold;
										
					echo "
						<tr>
							<td><a href='showBill.php?x=$invoiceId'>$invoiceId</a></td>
							<td>$sellingDate</td>
							<td><a href='showProduct.php?x=$productId'>$productId</a></td>
							<td>$productName</td>
							<td>$quantity</td>											
							<td>$buyingPrice</td>							
							<td>$totalBuy</td>	
							<td>$sellingPrice</td>							
							<td>$totalSold</td>	
						</tr>
					";
				}
				
				$sql2="SELECT  sum(`amount`*`discount`/100) AS total_discount,sum((`amount`-(`amount`*`discount`/100))*`vat`/100) AS total_vat FROM `invoices`  WHERE invoices.selling_date>='$startingDate' AND invoices.selling_date<='$endingeDate'";
				$result2=mysql_query($sql2);
				if (!$result2) {
				    die('Invalid query: ' . mysql_error());		
				}
				$row2=mysql_fetch_array($result2);
				//$totalDiscount=ceil($row2['total_discount']);
				//$totalVat=ceil($row2['total_vat']);		
				$totalDiscount=($row2['total_discount']);
				$totalVat=($row2['total_vat']);	

				$net=$sumSold-$sumBuy-$totalDiscount+$totalVat;
				$afterVat=$net-$totalVat;
				echo "
					</tbody>
				</table>
				<div id='customerTotalText'>
				Total Product Cost: $sumBuy<br>
				Total Sold Price: $sumSold<br>
				Total Discount Given: $totalDiscount<br>
				Total VAT Taken: $totalVat<br>
				Net Cash: $net<br><hr>
				After VAT given: $afterVat
				</div>
				";
			}else{
				echo "No entry in the given date range.";
			}
		}else if($type==="stocks"){
			$sql="SELECT * FROM stocks WHERE import_date>='$startingDate' AND import_date<='$endingeDate'";
			$result=mysql_query($sql);
			if (!$result) {
			    die('Invalid query: ' . mysql_error());
			}
			if(mysql_num_rows($result)){
				echo "
				<div id='tableTitleDiv'>
				Stocks Report
				</div>
				";
				echo"
				<table class='sortable table table-responsive '>
					<thead>
						<tr>
							<td>Stock No.</td>
							<td>Product No.</td>
							<td>In Stock Quantity</td>
							<td>Unit Price (Buy)</td>
							<td>Total Quantity</td>
							<td>Total Buy Cost</td>		
							<td>Sold Quantity</td>
							<td>Total Sold Income</td>
							<td>Import Date</td>					
						</tr>
					</thead>
					<tbody>
				";
				$sumBuy=0;
				$sumSold=0;
				while($row=mysql_fetch_array($result)){
					$stockID=$row['stock_id'];
					$productId=$row['product_id'];
					$totalQuantity=$row['import_quantity'];
					$currentQuantity=$row['current_quantity'];
					$importDate=$row['import_date'];
					$soldQuantity=$totalQuantity-$currentQuantity;

					$sql2="SELECT buying_price,product_price FROM products WHERE product_id='$productId'";
					$result2=mysql_query($sql2);
					if (!$result2) {
					    die('Invalid query: ' . mysql_error());
					}
					$row2=mysql_fetch_array($result2);
					$buyingPrice=$row2['buying_price'];
					$sellingPrice=$row2['product_price'];
					$totalBuy=$buyingPrice*$totalQuantity;
					$totalSold=$sellingPrice*$soldQuantity;
					$sumBuy+=$totalBuy;
					$sumSold+=$totalSold;
					echo "
						<tr>
							<td>$stockID</td>
							<td>$productId</td>
							<td>$currentQuantity</td>							
							<td>$buyingPrice</td>
							<td>$totalQuantity</td>	
							<td>$totalBuy</td>
							<td>$soldQuantity</td>								
							<td>$totalSold</td>							
							<td>$importDate</td>
						</tr>
					";
				}
				
				$sql2="SELECT  sum(`amount`*`discount`/100) AS total_discount,sum((`amount`-(`amount`*`discount`/100))*`vat`/100) AS total_vat FROM `invoices`  WHERE invoices.selling_date>='$startingDate' AND invoices.selling_date<='$endingeDate'";
				$result2=mysql_query($sql2);
				if (!$result2) {
				    die('Invalid query: ' . mysql_error());		
				}
				$row2=mysql_fetch_array($result2);
				//$totalDiscount=ceil($row2['total_discount']);
				//$totalVat=ceil($row2['total_vat']);		
				$totalDiscount=($row2['total_discount']);
				$totalVat=($row2['total_vat']);		

				$net=$sumSold-$sumBuy-$totalDiscount+$totalVat;
				$afterVat=$net-$totalVat;
				echo "
					</tbody>
				</table>
				<div id='customerTotalText'>
				Total Product Cost: $sumBuy<br>
				Total Sold Price: $sumSold<br>
				Total Discount Given: $totalDiscount<br>
				Total VAT Taken: $totalVat<br>
				Net Cash: $net<br><hr>
				After VAT given: $afterVat
				</div>
				";
			}else{
				echo "No stocks available currently.";
			}
		}else{
			session_destroy();
			echo"
			<script>
			alert('Invalid Query.');			
			window.location.href='login.php';
			</script>";	
		}
	}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Report Query</title>  
</head>

<body>	
	<div id="tableButtons">
		<a href="javascript:history.back()" class="btn btn-warning btn-sm">Back</a>
	</div>	
</body>

</html>