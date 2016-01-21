<?php
	session_start();
	require 'myConnection.php';	
	$quantity = $_GET['x'];
	$id=$_GET['y'];
	$_SESSION['cart_item']++;;
	$cartItem=$_SESSION['cart_item'];

	$x="productId".$cartItem;
	$y="quantity".$cartItem;

	$_SESSION[$x]=$id;
	$_SESSION[$y]=$quantity;
	echo "Cart item: ".$cartItem;
	
?>