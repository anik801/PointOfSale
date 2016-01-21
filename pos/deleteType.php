<?php
	ob_start();
	require 'myConnection.php';

	if(isset($_GET['x'])){
		$id=$_GET['x'];
		$sql="DELETE FROM types WHERE type_id='$id'";
		$result=mysql_query($sql);
		if (!$result) {
		    die('Invalid query: ' . mysql_error());
		}
		header('Location: types.php');
	}

?>