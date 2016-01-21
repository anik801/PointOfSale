<?php
  ob_start();
	require 'myConnection.php';

$sql="
DELETE FROM `categories` WHERE 1;
  ";
$result=mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}

$sql="
DELETE FROM `customers` WHERE 1;
  ";
$result=mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}

$sql="
DELETE FROM `invoices` WHERE 1;
  ";
$result=mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}

$sql="
DELETE FROM `products` WHERE 1;
  ";
$result=mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}

$sql="
DELETE FROM `returns` WHERE 1;
  ";
$result=mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}

$sql="
DELETE FROM `sales` WHERE 1;
  ";
$result=mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}

$sql="
DELETE FROM `stocks` WHERE 1;
  ";
$result=mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}

$sql="
DELETE FROM `types` WHERE 1;
  ";
$result=mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}else{
	header('Location: index.php');	
}



?>