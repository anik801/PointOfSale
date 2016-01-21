<?php
	require 'myConnection.php';
	if(isset($_GET['x'])){
		$id=$_GET['x'];
		$sql="SELECT amount FROM returns WHERE return_id='$id'";
		$result=mysql_query($sql);
		if (!$result) {
		    die('Invalid query: ' . mysql_error());
		}
		if(mysql_num_rows($result)){
			$row=mysql_fetch_array($result);
			$amount=$row['amount'];
			echo $amount;
		}
	}

?>