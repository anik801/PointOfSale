<?php
	ob_start();
	require 'mask.php';	
	require 'loginCheck.php';
	require 'supervisorCheck.php';
	
	$sql="SELECT * FROM customers";
	$result=mysql_query($sql);
	if (!$result) {
	    die('Invalid query: ' . mysql_error());
	}
	if(mysql_num_rows($result)){
		echo "
		<div id='tableTitleDiv'>
		Customer List
		</div>
		";
		echo"
		<table class='table table-responsive sortable'>
			<thead>
				<tr>
					<td>Customer Name</td>
					<td>Contact Number</td>
					<td>Action</td>
				</tr>
			</thead>
			<tbody>
		";
		while($row=mysql_fetch_array($result)){			
			$customerId=$row['customer_id'];
			$customerName=$row['customer_name'];
			$customerContact=$row['customer_contact'];


			
			echo "
				<tr>
					<td>$customerName</td>
					<td>$customerContact</td>
					<td><a href='showCustomer.php?x=$customerId' type='button' class='btn btn-info btn-xs'>HISTORY</a></td>
				</tr>
			";
		}
		echo"
			</tbody>
		</table>
		";
	}else{
		echo "No customer history available.";
	}

?>

<!DOCTYPE html>
<html>

<head>
  <title>Customers</title>  
</head>

<body>	
	<div id="tableButtons">
		<a href="javascript:history.back()" class="btn btn-warning btn-sm">Back</a>
	</div>
</body>

</html>