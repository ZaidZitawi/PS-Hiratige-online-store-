-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 13 فبراير 2024 الساعة 22:26
-- إصدار الخادم: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlinestore`
--

-- --------------------------------------------------------

--
-- بنية الجدول `cartitems`
--

CREATE TABLE `cartitems` (
  `CartItemID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `customerdetails`
--

CREATE TABLE `customerdetails` (
  `CustomerID` int(11) NOT NULL,
  `Country` varchar(30) NOT NULL,
  `City` varchar(30) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `CountryID` varchar(50) NOT NULL,
  `CreditCardNumber` varchar(19) NOT NULL,
  `CreditCardExpiration` date NOT NULL,
  `CreditCardName` varchar(255) NOT NULL,
  `BankIssued` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `customerdetails`
--

INSERT INTO `customerdetails` (`CustomerID`, `Country`, `City`, `Address`, `CountryID`, `CreditCardNumber`, `CreditCardExpiration`, `CreditCardName`, `BankIssued`) VALUES
(104, '', '', 'Ramallah', '654676132', '346879842314', '0000-00-00', 'Elias M.Asbah', 'Arab Bank');

-- --------------------------------------------------------

--
-- بنية الجدول `orderdetails`
--

CREATE TABLE `orderdetails` (
  `OrderDetailID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `CustomerID` int(11) NOT NULL,
  `OrderDate` datetime NOT NULL,
  `Status` enum('Waiting for Processing','Shipped') NOT NULL,
  `TotalAmount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `productimages`
--

CREATE TABLE `productimages` (
  `ImageID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `ImagePath` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `productimages`
--

INSERT INTO `productimages` (`ImageID`, `ProductID`, `ImagePath`) VALUES
(1, 1, 'images/board.jpg'),
(2, 2, 'images/dress.jpg'),
(3, 3, 'images/download (3).jpeg'),
(4, 4, 'images/soup.jpg'),
(5, 5, 'images/kofiahh.jpeg'),
(6, 6, 'images/download.jpeg'),
(7, 7, 'images/download (1).jpeg'),
(8, 8, 'images/download (2).jpeg');

-- --------------------------------------------------------

--
-- بنية الجدول `products`
--

CREATE TABLE `products` (
  `ProductID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Category` enum('New Arrival','On Sale','Featured','High Demand','Normal') DEFAULT 'Normal',
  `Price` decimal(10,2) NOT NULL,
  `Size` varchar(100) DEFAULT NULL,
  `Remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `products`
--

INSERT INTO `products` (`ProductID`, `Name`, `Description`, `Category`, `Price`, `Size`, `Remarks`) VALUES
(1, 'Olive Wood Carvings', 'Handcrafted olive wood carvings from Bethlehem, showcasing intricate religious and cultural motifs.', '', 50.00, 'Various', 'Handmade'),
(2, 'Embroidered Dress', 'Traditional Palestinian thobe, hand-embroidered with vibrant patterns and symbols.', '', 120.00, 'M', 'Authentic pattern'),
(3, 'Hebron Glass', 'Colorful glassware from Hebron, made using ancient glassblowing techniques.', '', 30.00, 'Set of 6', 'Traditional design'),
(4, 'Olive Oil Soap', 'Pure olive oil soap from Nablus, known for its moisturizing properties.', '', 10.00, '200g', 'All-natural'),
(5, 'Keffiyeh', 'Iconic Palestinian scarf, symbolizing heritage and resistance, made in Hebron.', '', 25.00, 'One Size', '100% Cotton'),
(6, 'Palestinian Za\'atar', 'Traditional Palestinian Za\'atar mix, perfect for bread dipping and seasoning.', '', 5.00, '100g', 'Organic herbs'),
(7, 'Ceramic Pottery', 'Hand-painted ceramic pottery from the West Bank, featuring traditional motifs.', '', 40.00, 'Various Sizes', 'Each piece is unique'),
(8, 'Maftoul', 'Hand-rolled Palestinian couscous, a staple for traditional dishes.', '', 15.00, '500g', 'Organic and handmade');

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `UserType` enum('Customer','Employee','Admin') NOT NULL,
  `DateOfBirth` date NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Telephone` varchar(20) NOT NULL,
  `fullname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `UserType`, `DateOfBirth`, `Email`, `Telephone`, `fullname`) VALUES
(12, 'zaid', '0123456789', 'Employee', '2004-05-23', 'zaid@gmail.com', '0113546897', 'Zaid Mohammed Zitawi'),
(22, 'omar ', '$2y$10$V46CTlHmnuCsP8rO83xY/uxOVfZOI5BSYUiS9qSaBpPbg4eYJEh8C', 'Customer', '2002-05-17', 'omar@gmail.com', '0597857565', 'omar hasan'),
(104, 'Elias', '$2y$10$9KCsk1dByAtAcv5UKzzPmuaVHvEPFxMVh2XTTIM39iLzdlQyehJr6', 'Customer', '2000-01-26', 'elias@gmail.com', '0569874512', 'Elias Asbah');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cartitems`
--
ALTER TABLE `cartitems`
  ADD PRIMARY KEY (`CartItemID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `customerdetails`
--
ALTER TABLE `customerdetails`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`OrderDetailID`),
  ADD KEY `OrderID` (`OrderID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `CustomerID` (`CustomerID`);

--
-- Indexes for table `productimages`
--
ALTER TABLE `productimages`
  ADD PRIMARY KEY (`ImageID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cartitems`
--
ALTER TABLE `cartitems`
  MODIFY `CartItemID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `OrderDetailID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `productimages`
--
ALTER TABLE `productimages`
  MODIFY `ImageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `cartitems`
--
ALTER TABLE `cartitems`
  ADD CONSTRAINT `cartitems_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `cartitems_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`);

--
-- قيود الجداول `customerdetails`
--
ALTER TABLE `customerdetails`
  ADD CONSTRAINT `customerdetails_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `users` (`UserID`);

--
-- قيود الجداول `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`),
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`);

--
-- قيود الجداول `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customerdetails` (`CustomerID`);

--
-- قيود الجداول `productimages`
--
ALTER TABLE `productimages`
  ADD CONSTRAINT `productimages_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
