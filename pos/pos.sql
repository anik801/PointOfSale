-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2014 at 10:24 PM
-- Server version: 5.6.11
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pos`
--
CREATE DATABASE IF NOT EXISTS `pos` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `pos`;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `employee_no`, `employee_name`, `employee_phone`, `employee_address`, `employee_national_id`, `password`, `is_admin`) VALUES
(1, '1', 'admin', '01234567891', 'Dhaka', '12344311324', '12345678', 1),
(2, NULL, 'kamal', '13245678', 'Rajshahi', '1234', '1234qwer', 0),
(3, NULL, 'Hasan', '0123123123', 'hasan@b.com', '132413241324', '12345678', 2),
(4, NULL, 'Rasel', '123123123', 'Gulshan', '123123123', '123123123', 3),
(5, NULL, 'Arif', '123123123', 'Johurabad', '123123123', '123123123', 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Foot Wear'),
(3, 'Furnitures'),
(4, 'Electronics'),
(5, 'Dressing');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(50) NOT NULL,
  `company_logo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`company_id`, `company_name`, `company_logo`) VALUES
(1, 'XYZ Crafts', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(50) NOT NULL,
  `customer_contact` varchar(15) NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_name`, `customer_contact`) VALUES
(7, 'Anik', '1234'),
(8, 'Fuad', '12345678'),
(9, 'Hemel', '1324442342'),
(10, 'Rafiq', '01234567');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `invoices`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`products_pk`, `product_id`, `product_name`, `product_type`, `product_category`, `product_size`, `product_price`, `buying_price`) VALUES
(3, '1', 'Bata', 3, 1, '11', 800, 700),
(4, 'E1', 'Buzzer', 0, 4, '', 10, 5),
(5, 'E2', 'LED', 0, 0, '', 2, 0.3),
(6, 'E3', 'Red LED', 0, 4, '', 2, 0.3),
(7, 'P1', 'Panjabi', 5, 5, '41', 1500, 500);

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE IF NOT EXISTS `returns` (
  `return_id` int(11) NOT NULL AUTO_INCREMENT,
  `return_date` datetime NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `product_id` varchar(15) NOT NULL,
  `quantity` int(11) NOT NULL,
  `amount` double NOT NULL,
  `refund_invoice_id` int(11) NOT NULL,
  PRIMARY KEY (`return_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `returns`
--

INSERT INTO `returns` (`return_id`, `return_date`, `invoice_id`, `product_id`, `quantity`, `amount`, `refund_invoice_id`) VALUES
(1, '2014-08-12 21:44:46', 9, 'E2', 10, 20, 18);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE IF NOT EXISTS `sales` (
  `sales_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `product_id` varchar(15) NOT NULL,
  `quantity` int(11) NOT NULL,
  `return_quantity` int(11) NOT NULL,
  PRIMARY KEY (`sales_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `sales`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE IF NOT EXISTS `stocks` (
  `stocks_pk` int(11) NOT NULL AUTO_INCREMENT,
  `stock_id` varchar(15) NOT NULL,
  `product_id` varchar(15) NOT NULL,
  `import_quantity` int(11) NOT NULL,
  `current_quantity` int(11) NOT NULL,
  `import_date` datetime NOT NULL,
  `is_deleted` int(1) NOT NULL,
  PRIMARY KEY (`stocks_pk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`stocks_pk`, `stock_id`, `product_id`, `import_quantity`, `current_quantity`, `import_date`, `is_deleted`) VALUES
(3, '1', '1', 10, 6, '2014-08-04 14:50:40', 0),
(4, '1', 'E1', 100, 80, '2014-08-04 14:53:09', 0),
(5, '1', 'E2', 1000, 860, '2014-08-04 14:54:03', 0),
(6, '1', 'E3', 10, 8, '2014-08-04 15:01:11', 0),
(7, '2', 'P1', 20, 15, '2014-08-07 01:19:51', 0);

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE IF NOT EXISTS `types` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(50) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`type_id`, `type_name`, `category_id`) VALUES
(2, 'Table 4 Legged', 3),
(3, 'Sandal', 1),
(4, 'Boot', 1),
(5, 'Men upper', 5);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
