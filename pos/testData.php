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
}


$sql="
INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Foot Wear'),
(3, 'Furnitures'),
(4, 'Electronics'),
(5, 'Dressing');
  ";
$result=mysql_query($sql);
if (!$result) {
  	die('Invalid query: ' . mysql_error());
}

$sql="
INSERT INTO `customers` (`customer_id`, `customer_name`, `customer_contact`) VALUES
(7, 'Anik', '1234'),
(8, 'Fuad', '12345678'),
(9, 'Hemel', '1324442342'),
(10, 'Rafiq', '01234567');
  ";
$result=mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}

$sql="
INSERT INTO `invoices` (`invoice_id`, `selling_date`, `customer_id`, `employee_no`, `amount`, `discount`, `vat`, `cash_given`, `cash_back`) VALUES
(8, '2014-08-05 22:05:55', 7, '1', 800, 0, 0, 1600, 0),
(9, '2014-08-05 22:08:34', 8, '1', 200, 0, 0, 200, 0),
(10, '2014-08-05 23:25:27', 7, '1', 20, 0, 0, 20, 0),
(11, '2014-08-06 15:24:02', 7, '1', 844, 0, 0, 844, 0),
(12, '2014-08-08 01:34:34', 9, '1', 50, 0, 0, 50, 0),
(13, '2014-08-09 02:58:45', 7, '1', 1500, 0, 0, 1500, 0),
(14, '2014-08-09 03:06:00', 10, '1', 3800, 0, 0, 3800, 0),
(15, '2014-08-11 04:08:14', 7, '1', 1590, 5, 1.5, 1600, 67),
(16, '2014-08-12 00:14:29', 7, '1', 1500, 10, 15, 2000, 447),
(18, '2014-08-13 00:42:35', 7, '1', 80, 5, 1.5, 100, 22);
  ";
$result=mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}

$sql="
INSERT INTO `products` (`products_pk`, `product_id`, `product_name`, `product_type`, `product_category`, `product_size`, `product_price`, `buying_price`) VALUES
(3, '1', 'Bata', 3, 1, '11', 800, 700),
(4, 'E1', 'Buzzer', 0, 4, '', 10, 5),
(5, 'E2', 'LED', 0, 0, '', 2, 0.3),
(6, 'E3', 'Red LED', 0, 4, '', 2, 0.3),
(7, 'P1', 'Panjabi', 5, 5, '41', 1500, 500);
  ";
$result=mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}

$sql="
INSERT INTO `returns` (`return_id`, `return_date`, `invoice_id`, `product_id`, `quantity`, `amount`, `refund_invoice_id`) VALUES
(1, '2014-08-12 21:44:46', 9, 'E2', 10, 20, 18);
  ";
$result=mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}

$sql="
INSERT INTO `sales` (`sales_id`, `invoice_id`, `product_id`, `quantity`, `return_quantity`) VALUES
(13, 8, '1', 2, 0),
(14, 9, 'E1', 10, 0),
(15, 9, 'E2', 50, 10),
(16, 10, 'E2', 10, 0),
(17, 11, '1', 1, 0),
(18, 11, 'E3', 2, 0),
(19, 11, 'E2', 20, 0),
(20, 12, 'E1', 5, 0),
(21, 13, 'P1', 1, 0),
(22, 14, '1', 1, 0),
(23, 14, 'P1', 2, 0),
(24, 15, 'P1', 1, 0),
(25, 15, 'E1', 5, 0),
(26, 15, 'E2', 20, 0),
(27, 16, 'P1', 1, 0),
(29, 18, 'E2', 50, 0);
  ";
$result=mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}

$sql="
INSERT INTO `stocks` (`stocks_pk`, `stock_id`, `product_id`, `import_quantity`, `current_quantity`, `import_date`, `is_deleted`) VALUES
(3, '1', '1', 10, 6, '2014-08-04 14:50:40', 0),
(4, '1', 'E1', 100, 80, '2014-08-04 14:53:09', 0),
(5, '1', 'E2', 1000, 860, '2014-08-04 14:54:03', 0),
(6, '1', 'E3', 10, 8, '2014-08-04 15:01:11', 0),
(7, '2', 'P1', 20, 15, '2014-08-07 01:19:51', 0);
  ";
$result=mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}

$sql="
INSERT INTO `types` (`type_id`, `type_name`, `category_id`) VALUES
(2, 'Table 4 Legged', 3),
(3, 'Sandal', 1),
(4, 'Boot', 1),
(5, 'Men upper', 5);
  ";
$result=mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}else{
	header('Location: index.php');	
}



?>