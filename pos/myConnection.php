<?php
	$host="localhost";
	$username="root";
	$password="";
	$database="pos";
	$con=mysql_connect($host,$username,$password,$database);
	if(!$con){
		die("can not connect:".mysql_error());
	}
	mysql_select_db($database,$con);	
?>