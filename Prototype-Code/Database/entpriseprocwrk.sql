-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2024 at 03:01 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `entpriseprocwrk`
--

-- --------------------------------------------------------

--
-- Table structure for table `alert_data`
--

CREATE TABLE `alert_data` (
  `Alert_ID` int(11) NOT NULL,
  `Type` varchar(255) DEFAULT NULL,
  `Product_ID` int(11) DEFAULT NULL,
  `Date_Time` datetime DEFAULT NULL,
  `Recipient_ID` varchar(255) DEFAULT NULL,
  `Alert_Sent_Time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `itemrevenue`
--

CREATE TABLE `itemrevenue` (
  `productCode` varchar(50) NOT NULL,
  `productName` varchar(255) DEFAULT NULL,
  `totalRevenue` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderID` int(11) NOT NULL,
  `productName` varchar(255) DEFAULT NULL,
  `productCode` varchar(50) DEFAULT NULL,
  `productQuantity` int(11) DEFAULT NULL,
  `bestBeforeDate` date DEFAULT NULL,
  `orderStatus` varchar(50) DEFAULT NULL,
  `orderDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_data`
--

CREATE TABLE `order_data` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date_ordered` datetime NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_data`
--

INSERT INTO `order_data` (`order_id`, `product_id`, `quantity`, `date_ordered`, `status`) VALUES
(1, 101, 2, '2024-03-10 10:00:00', 'ordered'),
(2, 102, 1, '2024-03-11 11:30:00', 'shipped'),
(3, 103, 3, '2024-03-12 12:45:00', 'delivered');

-- --------------------------------------------------------

--
-- Table structure for table `product_data`
--

CREATE TABLE `product_data` (
  `product_id` int(11) NOT NULL,
  `sku_code` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `shelf_life` date NOT NULL,
  `quantity` int(11) NOT NULL,
  `bbd` datetime DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `product_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_data`
--

INSERT INTO `product_data` (`product_id`, `sku_code`, `name`, `description`, `shelf_life`, `quantity`, `bbd`, `product_image`, `product_price`) VALUES
(1, 'SKU001', 'Chocolate Chip Cookies', 'Delicious chocolate chip cookies made with premium ingredients.', '2024-12-31', 100, '2024-12-31 23:59:59', NULL, NULL),
(2, 'SKU002', 'Crunchy Peanut Butter', 'All-natural crunchy peanut butter with no added sugars or preservatives.', '2024-12-31', 50, '2024-12-31 23:59:59', NULL, NULL),
(3, 'SKU003', 'Organic Green Tea', 'Certified organic green tea leaves with a delicate flavor and aroma.', '2025-06-30', 200, '2025-06-30 23:59:59', NULL, NULL),
(4, 'SKU004', 'Whole Grain Bread', 'Nutritious whole grain bread made with ancient grains and seeds.', '2024-12-31', 80, '2024-12-31 23:59:59', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `saleID` int(11) NOT NULL,
  `productName` varchar(255) DEFAULT NULL,
  `productCode` varchar(50) DEFAULT NULL,
  `saleDate` date DEFAULT NULL,
  `saleAmount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`username`, `password`, `role`, `name`, `email`, `phone_number`) VALUES
('janedoe', '', 'Manager', 'Jane Doe', 'janedoe@example.com', '0987654321'),
('johndoe', '', 'Rakusens staff', 'John Doe', 'johndoe@example.com', '1234567890'),
('vendor1', '', 'External Vendor', 'Vendor One', 'vendor1@example.com', '1112223333');

-- --------------------------------------------------------

--
-- Table structure for table `vendororders`
--

CREATE TABLE `vendororders` (
  `orderID` int(11) NOT NULL,
  `vendorID` int(11) DEFAULT NULL,
  `orderDate` date DEFAULT NULL,
  `deliveryAddress` varchar(255) DEFAULT NULL,
  `totalAmount` decimal(10,2) DEFAULT NULL,
  `orderStatus` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `vendorID` int(11) NOT NULL,
  `vendorName` varchar(255) DEFAULT NULL,
  `vendorEmail` varchar(255) DEFAULT NULL,
  `vendorPhone` varchar(20) DEFAULT NULL,
  `vendorAddress` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alert_data`
--
ALTER TABLE `alert_data`
  ADD PRIMARY KEY (`Alert_ID`);

--
-- Indexes for table `itemrevenue`
--
ALTER TABLE `itemrevenue`
  ADD PRIMARY KEY (`productCode`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderID`);

--
-- Indexes for table `order_data`
--
ALTER TABLE `order_data`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `product_data`
--
ALTER TABLE `product_data`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`saleID`);

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `vendororders`
--
ALTER TABLE `vendororders`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `vendorID` (`vendorID`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`vendorID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alert_data`
--
ALTER TABLE `alert_data`
  MODIFY `Alert_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_data`
--
ALTER TABLE `order_data`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_data`
--
ALTER TABLE `product_data`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `saleID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendororders`
--
ALTER TABLE `vendororders`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `vendorID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `vendororders`
--
ALTER TABLE `vendororders`
  ADD CONSTRAINT `vendororders_ibfk_1` FOREIGN KEY (`vendorID`) REFERENCES `vendors` (`vendorID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
