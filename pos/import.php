<?php
  	ob_start();
	require 'myConnection.php';

	$sql="
CREATE TABLE IF NOT EXISTS `accounts` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_no` varchar(15) DEFAULT NULL,
  `employee_name` varchar(50) NOT NULL,
  `employee_phone` varchar(15) DEFAULT NULL,
  `employee_address` varchar(100) DEFAULT NULL,
  `employee_national_id` varchar(50) DEFAULT NULL,
  `password` varchar(50) NOT NULL,
  `is_admin` int(1) NOT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
";

$result=mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}
$sql="
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
";

$result=mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}
$sql="
CREATE TABLE IF NOT EXISTS `company` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(50) NOT NULL,
  `company_logo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
";

$result=mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}
$sql="
CREATE TABLE IF NOT EXISTS `customers` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(50) NOT NULL,
  `customer_contact` varchar(15) NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
";

$result=mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}
$sql="
CREATE TABLE IF NOT EXISTS `invoices` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `selling_date` datetime NOT NULL,
  `customer_id` int(11) NOT NULL,
  `employee_no` varchar(15) DEFAULT NULL,
  `amount` double NOT NULL,
  `discount` double NOT NULL,
  `vat` double NOT NULL,
  `cash_given` double NOT NULL,
  `cash_back` double NOT NULL,
  PRIMARY KEY (`invoice_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
";

$result=mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}
$sql="
CREATE TABLE IF NOT EXISTS `products` (
  `products_pk` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` varchar(15) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_type` int(11) NOT NULL,
  `product_category` int(11) NOT NULL,
  `product_size` varchar(15) DEFAULT NULL,
  `product_price` double NOT NULL,
  `buying_price` double NOT NULL,
  PRIMARY KEY (`products_pk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
";

$result=mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}

$sql="
CREATE TABLE IF NOT EXISTS `returns` (
  `return_id` int(11) NOT NULL AUTO_INCREMENT,
  `return_date` datetime NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `product_id` varchar(15) NOT NULL,
  `quantity` int(11) NOT NULL,
  `amount` double NOT NULL,
  `refund_invoice_id` int(11) NOT NULL,
  PRIMARY KEY (`return_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
  ";

$result=mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}

$sql="
CREATE TABLE IF NOT EXISTS `sales` (
  `sales_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `product_id` varchar(15) NOT NULL,
  `quantity` int(11) NOT NULL,
  `return_quantity` int(11) NOT NULL,
  PRIMARY KEY (`sales_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
  ";

$result=mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}

$sql="
CREATE TABLE IF NOT EXISTS `stocks` (
  `stocks_pk` int(11) NOT NULL AUTO_INCREMENT,
  `stock_id` varchar(15) NOT NULL,
  `product_id` varchar(15) NOT NULL,
  `import_quantity` int(11) NOT NULL,
  `current_quantity` int(11) NOT NULL,
  `import_date` datetime NOT NULL,
  `is_deleted` int(1) NOT NULL,
  PRIMARY KEY (`stocks_pk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
  ";

$result=mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}

$sql="
CREATE TABLE IF NOT EXISTS `types` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(50) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;
  ";

$result=mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}



$sql="
  INSERT INTO `accounts` (`account_id`, `employee_no`, `employee_name`, `employee_phone`, `employee_address`, `employee_national_id`, `password`, `is_admin`) VALUES
(1, '1', 'admin', '01234567891', NULL, NULL, '12345678', 1);
  ";

$result=mysql_query($sql);
if (!$result) {
  	die('Invalid query: ' . mysql_error());
}

$sql="
INSERT INTO `company` (`company_id`, `company_name`, `company_logo`) VALUES
(1, 'Company Name', NULL);
  ";

$result=mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}else{
	header('Location: index.php');	
}



?>