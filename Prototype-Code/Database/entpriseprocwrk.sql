-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2024 at 01:33 AM
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
  `productName` varchar(255) NOT NULL,
  `productCode` varchar(50) DEFAULT NULL,
  `skuCode` varchar(50) DEFAULT NULL,
  `productImage` blob DEFAULT NULL,
  `productDescription` text DEFAULT NULL,
  `productQuantity` int(11) DEFAULT NULL,
  `price` mediumtext DEFAULT NULL,
  `bestBeforeDate` date DEFAULT NULL,
  `orderStatus` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productName`, `productCode`, `skuCode`, `productImage`, `productDescription`, `productQuantity`, `price`, `bestBeforeDate`, `orderStatus`) VALUES
('Basmati Rice', 'RIC002', 'SKU004', NULL, 'Aromatic and long-grain Basmati rice, 10 lb', 60, '£8.49', '2024-04-29', 'In Stock'),
('Eggs (Large)', 'EGG001', 'SKU005', NULL, 'Farm-fresh large eggs, pack of 12', 50, '£3.79', '2024-04-23', 'In Stock'),
('Ground Beef', 'BEEF001', 'SKU006', NULL, 'Premium quality ground beef, 1 lb', 40, '£6.99', '2024-04-26', 'In Stock'),
('Orange Juice', 'JUC001', 'SKU007', NULL, 'Freshly squeezed orange juice, 64 oz', 70, '£4.29', '2024-03-25', 'In Stock'),
('Sliced Bread', 'BRD001', 'SKU001', NULL, 'Freshly baked sliced white bread', 100, '£2.49', '2024-04-20', 'In Stock'),
('White Rice', 'RIC001', 'SKU003', NULL, 'Premium quality long-grain white rice, 5 lb', 80, '£5.99', '2024-04-25', 'In Stock'),
('Whole Wheat Bread', 'BRD002', 'SKU002', NULL, 'Nutritious whole wheat bread made with whole grain flour', 120, '£2.99', '2024-04-21', 'In Stock');

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
  `fullName` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phoneNumber` varchar(20) DEFAULT NULL,
  `role` enum('Manager','Employee','Vendor') DEFAULT 'Employee',
  `vendorID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`fullName`, `email`, `password`, `phoneNumber`, `role`, `vendorID`) VALUES
('Edwards Jackson', 'EdwardsJackson@Gmail.com', '$2y$10$5UeOY8Tw1NXWIDVcPcB/duNq2SuIcIbN97juF85uoMnAPkxdGIxqC', '07263527338', 'Manager', NULL);

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
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`saleID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`fullName`),
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
  MODIFY `vendorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
