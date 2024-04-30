-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2024 at 08:14 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rwsdb`
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
-- Table structure for table `bookinorders`
--

CREATE TABLE `bookinorders` (
  `order_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `arrival_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `batch_number` varchar(50) NOT NULL,
  `expiry_date` date NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
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
  `orderStatus` enum('Completed','Processing') DEFAULT 'Processing',
  `orderDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productName` varchar(255) NOT NULL,
  `productCode` varchar(50) DEFAULT NULL,
  `skuCode` varchar(50) DEFAULT NULL,
  `productImage` blob DEFAULT NULL,
  `productDescription` text DEFAULT NULL,
  `productQuantity` int(11) DEFAULT NULL,
  `price` mediumtext DEFAULT NULL,
  `bestBeforeDate` date DEFAULT NULL,
  `orderStatus` enum('In Stock','Out Of Stock') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productName`, `productCode`, `skuCode`, `productImage`, `productDescription`, `productQuantity`, `price`, `bestBeforeDate`, `orderStatus`) VALUES
('Basmati Rice', 'RIC002', 'SKU004', NULL, 'Aromatic and long-grain Basmati rice, 10 lb', 10, '0', '2024-04-29', 'In Stock'),
('Sliced Bread', 'BRD001', 'SKU001', NULL, 'Freshly baked sliced white bread', 100, '£2.49', '2024-04-20', 'In Stock'),
('White Rice', 'RIC001', 'SKU003', NULL, 'Premium quality long-grain white rice, 5 lb', 80, '£5.99', '2024-04-25', 'In Stock');

-- --------------------------------------------------------

--
-- Table structure for table `rawingredients`
--

CREATE TABLE `rawingredients` (
  `ingredient_id` int(11) NOT NULL,
  `ingredient_name` varchar(100) NOT NULL,
  `supplier_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `arrival_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `batch_number` varchar(50) NOT NULL,
  `expiry_date` date NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
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
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `role` enum('Manager','Employee','Vendor') DEFAULT 'Employee',
  `vendor_id` int(11) DEFAULT NULL,
  `approval_status` enum('Pending','Disapproved','Approved') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `password`, `phone_number`, `role`, `vendor_id`, `approval_status`) VALUES
(1, 'Nam', 'nam@email.com', '$2y$10$Lk58cgGIblxqDX5YD.G.PeBa.2N7unYa5/MfKj7wEWowHD7rGerYq', '', 'Manager', NULL, 'Approved'),
(2, 'Will Smith', 'Iamlegend@fchrisrock.com', '$2y$10$E8bPLpEMmxgZ9vMnMGlGleB6y/g4.ZJXtoQTZxeqfN6Zngtql/MLS', '07474372247', 'Vendor', 1, 'Approved');

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
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`vendorID`, `vendorName`, `vendorEmail`, `vendorPhone`, `vendorAddress`) VALUES
(1, 'Tesco Express', 'TescoExpressManningham@Gmail.com', '0345 026 9840', 'Manningham Ln, Bradford BD8 7HY'),
(2, 'Lidl ', 'LidlBarkerend@Gmail.com', ' 020 3966 5566', ' Barkerend Rd, Bradford BD3 9BN'),
(3, 'Morrisons', 'MorrisonsVictoria@Gmail.com', ' 01274 498218', 'Victoria Shopping Centre, Young St, Bradford BD8 9BN');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookinorders`
--
ALTER TABLE `bookinorders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `ingredient_id` (`ingredient_id`);

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
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productName`);

--
-- Indexes for table `rawingredients`
--
ALTER TABLE `rawingredients`
  ADD PRIMARY KEY (`ingredient_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`saleID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `vendorID` (`vendor_id`);

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
-- AUTO_INCREMENT for table `bookinorders`
--
ALTER TABLE `bookinorders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rawingredients`
--
ALTER TABLE `rawingredients`
  MODIFY `ingredient_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `saleID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vendororders`
--
ALTER TABLE `vendororders`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `vendorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookinorders`
--
ALTER TABLE `bookinorders`
  ADD CONSTRAINT `bookinorders_ibfk_1` FOREIGN KEY (`ingredient_id`) REFERENCES `rawingredients` (`ingredient_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`vendorID`);

--
-- Constraints for table `vendororders`
--
ALTER TABLE `vendororders`
  ADD CONSTRAINT `vendororders_ibfk_1` FOREIGN KEY (`vendorID`) REFERENCES `vendors` (`vendorID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
