-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Dec 21, 2017 at 10:08 PM
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
-- Table structure for table `GearItem`
--

CREATE TABLE `GearItem` (
  `GearId` int(11) NOT NULL,
  `GearName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CurrentOwnerId` int(11) NOT NULL,
  `PurchasePrice` decimal(8,2) NOT NULL,
  `PurchaseDate` date NOT NULL,
  `PurchasePlace` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `GearItem`
--

INSERT INTO `GearItem` (`GearId`, `GearName`, `CurrentOwnerId`, `PurchasePrice`, `PurchaseDate`, `PurchasePlace`) VALUES
(11, 'Lenovo X1 Carbon', 2, '2213.00', '2001-01-01', 'Neptun'),
(12, 'Macbook', 1, '1199.00', '2017-11-01', 'Mediamarkt'),
(13, 'Sony Kamera', 1, '650.00', '2008-02-02', 'Digitec'),
(16, 'test gerät', 1, '2.00', '2017-10-12', 'Fust');

-- --------------------------------------------------------

--
-- Table structure for table `GearItemTag`
--

CREATE TABLE `GearItemTag` (
  `GearId` int(11) NOT NULL,
  `TagId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Picture`
--

CREATE TABLE `Picture` (
  `PictureId` int(11) NOT NULL,
  `GearId` int(11) NOT NULL,
  `PictureTypeId` int(11) NOT NULL,
  `PictureDescription` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `PictureType`
--

CREATE TABLE `PictureType` (
  `PictureTypeId` int(11) NOT NULL,
  `PictureTypeName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `PictureType`
--

INSERT INTO `PictureType` (`PictureTypeId`, `PictureTypeName`) VALUES
(1, 'UserPicture'),
(2, 'ItemPicture');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Sale`
--

INSERT INTO `Sale` (`SaleId`, `GearId`, `SalesPrice`, `SalesStart`, `SalesEnd`) VALUES
(1, 11, '200.00', '2017-12-19 00:00:00', '2017-12-30 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `Tag`
--

CREATE TABLE `Tag` (
  `TagId` int(11) NOT NULL,
  `TagName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `Password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`UserId`, `UserName`, `FirstName`, `LastName`, `EmailAddress`, `AddressStreet`, `AddressZIP`, `AddressCity`, `IsAdmin`, `Password`) VALUES
(1, 'mkilchhofer', 'Marco', 'Kilchhofer', 'marco@kilchhofer.info', 'Seilerweg 11', 2557, 'Studen', 1, '$2y$12$VKce9H3G3Q9JgpCBL3M6suWZDp9Dj7ONd8v9MBojCN9uy0uFrsvL6'),
(2, 'mschmutz', 'Manuel', 'Schmutz', '', '', 0, '', 1, '$2y$12$Xj.3V91pDNjlojcVQpd7dewEJq79LkOh.w4rnese9jr7mGZFtSxXG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `GearItem`
--
ALTER TABLE `GearItem`
  ADD PRIMARY KEY (`GearId`),
  ADD KEY `FK_GearItem_CurrentOwnerId` (`CurrentOwnerId`);

--
-- Indexes for table `GearItemTag`
--
ALTER TABLE `GearItemTag`
  ADD KEY `FK_GearItemTag_GearId` (`GearId`),
  ADD KEY `FK_GearItemTag_TagId` (`TagId`);

--
-- Indexes for table `Picture`
--
ALTER TABLE `Picture`
  ADD PRIMARY KEY (`PictureId`),
  ADD KEY `FK_Picture_GearId` (`GearId`),
  ADD KEY `FK_Picture_PictureType` (`PictureTypeId`);

--
-- Indexes for table `PictureType`
--
ALTER TABLE `PictureType`
  ADD PRIMARY KEY (`PictureTypeId`);

--
-- Indexes for table `Sale`
--
ALTER TABLE `Sale`
  ADD PRIMARY KEY (`SaleId`),
  ADD KEY `FK_Sale_GearId` (`GearId`);

--
-- Indexes for table `Tag`
--
ALTER TABLE `Tag`
  ADD PRIMARY KEY (`TagId`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`UserId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `GearItem`
--
ALTER TABLE `GearItem`
  MODIFY `GearId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `Picture`
--
ALTER TABLE `Picture`
  MODIFY `PictureId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `PictureType`
--
ALTER TABLE `PictureType`
  MODIFY `PictureTypeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Sale`
--
ALTER TABLE `Sale`
  MODIFY `SaleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Tag`
--
ALTER TABLE `Tag`
  MODIFY `TagId` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `GearItem`
--
ALTER TABLE `GearItem`
  ADD CONSTRAINT `FK_GearItem_CurrentOwnerId` FOREIGN KEY (`CurrentOwnerId`) REFERENCES `User` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `GearItemTag`
--
ALTER TABLE `GearItemTag`
  ADD CONSTRAINT `FK_GearItemTag_GearId` FOREIGN KEY (`GearId`) REFERENCES `GearItem` (`GearId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_GearItemTag_TagId` FOREIGN KEY (`TagId`) REFERENCES `Tag` (`TagId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Picture`
--
ALTER TABLE `Picture`
  ADD CONSTRAINT `FK_Picture_GearId` FOREIGN KEY (`GearId`) REFERENCES `GearItem` (`GearId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Picture_PictureType` FOREIGN KEY (`PictureTypeId`) REFERENCES `PictureType` (`PictureTypeId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Sale`
--
ALTER TABLE `Sale`
  ADD CONSTRAINT `FK_Sale_GearId` FOREIGN KEY (`GearId`) REFERENCES `GearItem` (`GearId`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
