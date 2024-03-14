-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2024 at 11:07 PM
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
-- Table structure for table `alerts`
--

CREATE TABLE `alerts` (
  `productName` varchar(255) DEFAULT NULL,
  `productCode` varchar(50) DEFAULT NULL,
  `skuCode` varchar(50) DEFAULT NULL,
  `productImage` blob DEFAULT NULL,
  `productDescription` text DEFAULT NULL,
  `productQuantity` int(11) DEFAULT NULL,
  `alertType` varchar(50) DEFAULT NULL,
  `bestBeforeDate` date DEFAULT NULL
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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productName` varchar(255) DEFAULT NULL,
  `productCode` varchar(50) DEFAULT NULL,
  `skuCode` varchar(50) DEFAULT NULL,
  `productImage` blob DEFAULT NULL,
  `productDescription` text DEFAULT NULL,
  `productQuantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `bestBeforeDate` date DEFAULT NULL,
  `orderStatus` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `fullName` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phoneNumber` varchar(20) DEFAULT NULL,
  `role` enum('Manager','Employee','Vendor') DEFAULT 'Employee',
  `vendorID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`saleID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD KEY `vendorID` (`vendorID`);

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
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`vendorID`) REFERENCES `vendors` (`vendorID`);

--
-- Constraints for table `vendororders`
--
ALTER TABLE `vendororders`
  ADD CONSTRAINT `vendororders_ibfk_1` FOREIGN KEY (`vendorID`) REFERENCES `vendors` (`vendorID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
