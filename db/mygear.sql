-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Dec 29, 2017 at 10:59 AM
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
-- Table structure for table `Appearance`
--

CREATE TABLE `Appearance` (
  `AppearanceId` int(11) NOT NULL,
  `Title_en` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Title_de` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Appearance`
--

INSERT INTO `Appearance` (`AppearanceId`, `Title_en`, `Title_de`) VALUES
(0, 'not set', 'nicht gesetzt'),
(1, 'No traces of use', 'Keine Gebrauchsspuren'),
(2, 'Slight traces of use', 'Leichte Gebrauchsspuren'),
(3, 'Heavy traces of use', 'Schwere Gebrauchsspuren'),
(4, 'Extreme traces of use', 'Extreme Gebrauchsspuren');

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
(5),
(6);

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
(10, 5, 'en', 'Camera Lens'),
(11, 6, 'de', 'Küchengerät'),
(12, 6, 'en', 'kitchen device');

-- --------------------------------------------------------

--
-- Table structure for table `Functioning`
--

CREATE TABLE `Functioning` (
  `FunctioningId` int(11) NOT NULL,
  `Title_en` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Title_de` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Functioning`
--

INSERT INTO `Functioning` (`FunctioningId`, `Title_en`, `Title_de`) VALUES
(0, 'not set', 'nicht gesetzt'),
(1, 'Flawless functioning', 'Einwandfreie Funktion'),
(2, 'Slight functional limitations', 'Leichte Funktionseinschränkung'),
(3, 'Severe functional limitations', 'Schwere Funktionseinschränkung'),
(4, 'Defective', 'Defekter Artikel');

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
  `Warranty` date DEFAULT NULL,
  `Receipt` mediumblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `GearItem`
--

INSERT INTO `GearItem` (`GearId`, `GearName`, `CurrentOwnerId`, `CategoryId`, `PurchasePrice`, `PurchaseDate`, `PurchasePlace`, `Warranty`, `Receipt`) VALUES
(1, 'Lenovo X1 Carbon', 2, 2, '2213.00', '2001-01-01', 'Neptun', NULL, NULL),
(2, 'Macbook', 1, 2, '1199.00', '2017-11-01', 'Mediamarkt', NULL, NULL),
(3, 'Sony Kamera', 1, 4, '650.00', '2008-02-02', 'Digitec', NULL, NULL),
(4, 'iPhone 6s', 2, 1, '650.00', '2008-02-02', 'Digitec', NULL, NULL),
(5, 'Canon 50mm 1.8 STM', 1, 5, '105.00', '2015-01-10', 'Digitec', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Packaging`
--

CREATE TABLE `Packaging` (
  `PackagingId` int(11) NOT NULL,
  `Title_en` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Title_de` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Packaging`
--

INSERT INTO `Packaging` (`PackagingId`, `Title_en`, `Title_de`) VALUES
(0, 'not set', 'nicht gesetzt'),
(1, 'Unopened', 'Ungeöffnet'),
(2, 'Opened and with original packaging', 'Geöffnet mit Originalverpackung'),
(3, 'Without original packaging', 'Ohne Originalverpackung');

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
  `SalesEnd` datetime NOT NULL,
  `Appearance` int(11) NOT NULL,
  `Functioning` int(11) NOT NULL,
  `Packaging` int(11) NOT NULL,
  `Description` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Sale`
--

INSERT INTO `Sale` (`SaleId`, `GearId`, `SalesPrice`, `SalesStart`, `SalesEnd`, `Appearance`, `Functioning`, `Packaging`, `Description`) VALUES
(1, 1, '200.00', '2017-12-19 00:00:00', '2017-12-30 00:00:00', 1, 1, 2, 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.   \r\n\r\nDuis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.   \r\n\r\nUt wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.   \r\n\r\nNam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer'),
(2, 3, '149.95', '2017-12-21 22:17:50', '2017-12-31 00:00:00', 1, 1, 3, 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.');

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
-- Indexes for table `Appearance`
--
ALTER TABLE `Appearance`
  ADD PRIMARY KEY (`AppearanceId`);

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
-- Indexes for table `Functioning`
--
ALTER TABLE `Functioning`
  ADD PRIMARY KEY (`FunctioningId`);

--
-- Indexes for table `GearItem`
--
ALTER TABLE `GearItem`
  ADD PRIMARY KEY (`GearId`),
  ADD KEY `FK_GearItem_CurrentOwnerId` (`CurrentOwnerId`),
  ADD KEY `FK_GearItem_CategoryId` (`CategoryId`);

--
-- Indexes for table `Packaging`
--
ALTER TABLE `Packaging`
  ADD PRIMARY KEY (`PackagingId`);

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
  ADD KEY `FK_Sale_GearId` (`GearId`),
  ADD KEY `FK_Sale_Appearance` (`Appearance`),
  ADD KEY `FK_Sale_Functioning` (`Functioning`),
  ADD KEY `FK_Sale_Packaging` (`Packaging`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`UserId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Appearance`
--
ALTER TABLE `Appearance`
  MODIFY `AppearanceId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Category`
--
ALTER TABLE `Category`
  MODIFY `CategoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `CategoryTranslations`
--
ALTER TABLE `CategoryTranslations`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `Functioning`
--
ALTER TABLE `Functioning`
  MODIFY `FunctioningId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `GearItem`
--
ALTER TABLE `GearItem`
  MODIFY `GearId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `Packaging`
--
ALTER TABLE `Packaging`
  MODIFY `PackagingId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  ADD CONSTRAINT `FK_Sale_Appearance` FOREIGN KEY (`Appearance`) REFERENCES `Appearance` (`AppearanceId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Sale_Functioning` FOREIGN KEY (`Functioning`) REFERENCES `Functioning` (`FunctioningId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Sale_GearId` FOREIGN KEY (`GearId`) REFERENCES `GearItem` (`GearId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Sale_Packaging` FOREIGN KEY (`Packaging`) REFERENCES `Packaging` (`PackagingId`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
