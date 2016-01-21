<?php
	ob_start();
	require 'myConnection.php';

	if(isset($_GET['x'])){
		$id=$_GET['x'];
		$sql="UPDATE stocks SET is_deleted='1' WHERE stock_id='$id'";
		$result=mysql_query($sql);
		if (!$result) {
		    die('Invalid query: ' . mysql_error());
		}
		
		header('Location: stocks.php');
	}

?>