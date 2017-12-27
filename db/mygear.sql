-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Dec 27, 2017 at 06:10 PM
-- Server version: 10.2.8-MariaDB
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mygear`
--

-- --------------------------------------------------------

--
-- Table structure for table `Category`
--

CREATE TABLE `Category` (
  `CategoryId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Category`
--

INSERT INTO `Category` (`CategoryId`) VALUES
(1),
(2),
(3),
(4),
(5);

-- --------------------------------------------------------

--
-- Table structure for table `CategoryTranslations`
--

CREATE TABLE `CategoryTranslations` (
  `Id` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  `Language` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CategoryDescription` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `CategoryTranslations`
--

INSERT INTO `CategoryTranslations` (`Id`, `CategoryId`, `Language`, `CategoryDescription`) VALUES
(1, 1, 'de', 'Smartphone'),
(2, 1, 'en', 'smart phone'),
(3, 2, 'de', 'Laptop'),
(4, 2, 'en', 'laptop'),
(5, 3, 'en', 'tablet computer'),
(6, 3, 'de', 'Tablet'),
(7, 4, 'de', 'Kamera Body'),
(8, 4, 'en', 'Camera Body'),
(9, 5, 'de', 'Kamera Objektiv'),
(10, 5, 'en', 'Camera Lens');

-- --------------------------------------------------------

--
-- Table structure for table `GearItem`
--

CREATE TABLE `GearItem` (
  `GearId` int(11) NOT NULL,
  `GearName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CurrentOwnerId` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  `PurchasePrice` decimal(8,2) NOT NULL,
  `PurchaseDate` date NOT NULL,
  `PurchasePlace` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Receipt` mediumblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `GearItem`
--

INSERT INTO `GearItem` (`GearId`, `GearName`, `CurrentOwnerId`, `CategoryId`, `PurchasePrice`, `PurchaseDate`, `PurchasePlace`, `Receipt`) VALUES
(1, 'Lenovo X1 Carbon', 2, 2, '2213.00', '2001-01-01', 'Neptun', NULL),
(2, 'Macbook', 1, 2, '1199.00', '2017-11-01', 'Mediamarkt', NULL),
(3, 'Sony Kamera', 1, 4, '650.00', '2008-02-02', 'Digitec', NULL),
(4, 'iPhone 6s', 2, 1, '650.00', '2008-02-02', 'Digitec', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Picture`
--

CREATE TABLE `Picture` (
  `PictureId` int(11) NOT NULL,
  `GearId` int(11) NOT NULL,
  `PictureDescription` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Image` mediumblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Sale`
--

CREATE TABLE `Sale` (
  `SaleId` int(11) NOT NULL,
  `GearId` int(11) NOT NULL,
  `SalesPrice` decimal(8,2) NOT NULL,
  `SalesStart` datetime NOT NULL,
  `SalesEnd` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Sale`
--

INSERT INTO `Sale` (`SaleId`, `GearId`, `SalesPrice`, `SalesStart`, `SalesEnd`) VALUES
(1, 1, '200.00', '2017-12-19 00:00:00', '2017-12-30 00:00:00'),
(2, 3, '149.95', '2017-12-21 22:17:50', '2017-12-31 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `UserId` int(11) NOT NULL,
  `UserName` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `FirstName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `LastName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EmailAddress` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `AddressStreet` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `AddressZIP` int(11) NOT NULL,
  `AddressCity` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IsAdmin` tinyint(1) NOT NULL DEFAULT 0,
  `Password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `RegistrationDate` datetime NOT NULL,
  `IsActive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`UserId`, `UserName`, `FirstName`, `LastName`, `EmailAddress`, `AddressStreet`, `AddressZIP`, `AddressCity`, `IsAdmin`, `Password`, `RegistrationDate`, `IsActive`) VALUES
(1, 'mkilchhofer', 'Marco', 'Kilchhofer', 'marco@kilchhofer.info', 'Seilerweg 11', 2557, 'Studen', 1, '$2y$12$VKce9H3G3Q9JgpCBL3M6suWZDp9Dj7ONd8v9MBojCN9uy0uFrsvL6', '2017-09-17 00:00:00', 1),
(2, 'mschmutz', 'Manuel', 'Schmutz', '', '', 0, '', 1, '$2y$12$Xj.3V91pDNjlojcVQpd7dewEJq79LkOh.w4rnese9jr7mGZFtSxXG', '2017-09-17 00:00:00', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Category`
--
ALTER TABLE `Category`
  ADD PRIMARY KEY (`CategoryId`);

--
-- Indexes for table `CategoryTranslations`
--
ALTER TABLE `CategoryTranslations`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `FK_CategoryTranslations_CategoryId` (`CategoryId`);

--
-- Indexes for table `GearItem`
--
ALTER TABLE `GearItem`
  ADD PRIMARY KEY (`GearId`),
  ADD KEY `FK_GearItem_CurrentOwnerId` (`CurrentOwnerId`),
  ADD KEY `FK_GearItem_CategoryId` (`CategoryId`);

--
-- Indexes for table `Picture`
--
ALTER TABLE `Picture`
  ADD PRIMARY KEY (`PictureId`),
  ADD KEY `FK_Picture_GearId` (`GearId`);

--
-- Indexes for table `Sale`
--
ALTER TABLE `Sale`
  ADD PRIMARY KEY (`SaleId`),
  ADD KEY `FK_Sale_GearId` (`GearId`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`UserId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Category`
--
ALTER TABLE `Category`
  MODIFY `CategoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `CategoryTranslations`
--
ALTER TABLE `CategoryTranslations`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `GearItem`
--
ALTER TABLE `GearItem`
  MODIFY `GearId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Picture`
--
ALTER TABLE `Picture`
  MODIFY `PictureId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Sale`
--
ALTER TABLE `Sale`
  MODIFY `SaleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `CategoryTranslations`
--
ALTER TABLE `CategoryTranslations`
  ADD CONSTRAINT `FK_CategoryTranslations_CategoryId` FOREIGN KEY (`CategoryId`) REFERENCES `Category` (`CategoryId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `GearItem`
--
ALTER TABLE `GearItem`
  ADD CONSTRAINT `FK_GearItem_CategoryId` FOREIGN KEY (`CategoryId`) REFERENCES `Category` (`CategoryId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_GearItem_CurrentOwnerId` FOREIGN KEY (`CurrentOwnerId`) REFERENCES `User` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Picture`
--
ALTER TABLE `Picture`
  ADD CONSTRAINT `FK_Picture_GearId` FOREIGN KEY (`GearId`) REFERENCES `GearItem` (`GearId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Sale`
--
ALTER TABLE `Sale`
  ADD CONSTRAINT `FK_Sale_GearId` FOREIGN KEY (`GearId`) REFERENCES `GearItem` (`GearId`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
