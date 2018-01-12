-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Jan 12, 2018 at 04:35 PM
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
  `id` int(11) NOT NULL,
  `title_en` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_de` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Appearance`
--

INSERT INTO `Appearance` (`id`, `title_en`, `title_de`) VALUES
(0, 'not set', 'nicht gesetzt'),
(1, 'No traces of use', 'Keine Gebrauchsspuren'),
(2, 'Slight traces of use', 'Leichte Gebrauchsspuren'),
(3, 'Heavy traces of use', 'Schwere Gebrauchsspuren'),
(4, 'Extreme traces of use', 'Extreme Gebrauchsspuren');

-- --------------------------------------------------------

--
-- Table structure for table `Attachment`
--

CREATE TABLE `Attachment` (
  `id` int(11) NOT NULL,
  `typeId` int(11) NOT NULL,
  `gearId` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data` mediumblob DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `AttachmentType`
--

CREATE TABLE `AttachmentType` (
  `id` int(11) NOT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_de` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `AttachmentType`
--

INSERT INTO `AttachmentType` (`id`, `title_en`, `title_de`) VALUES
(1, 'Picture', 'Bild'),
(2, 'Receipt', 'Quittung');

-- --------------------------------------------------------

--
-- Table structure for table `Category`
--

CREATE TABLE `Category` (
  `id` int(11) NOT NULL,
  `title_en` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_de` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Category`
--

INSERT INTO `Category` (`id`, `title_en`, `title_de`) VALUES
(1, 'smart phone', 'Smartphone'),
(2, 'laptop', 'Laptop'),
(3, 'tablet computer', 'Tablet'),
(4, 'Camera Body', 'Kamera Body'),
(5, 'Camera Lens', 'Kamera Objektiv'),
(6, 'kitchen device', 'Küchengerät');

-- --------------------------------------------------------

--
-- Table structure for table `Functioning`
--

CREATE TABLE `Functioning` (
  `id` int(11) NOT NULL,
  `title_en` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_de` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Functioning`
--

INSERT INTO `Functioning` (`id`, `title_en`, `title_de`) VALUES
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
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currentOwnerId` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `purchasePrice` decimal(8,2) NOT NULL,
  `purchaseDate` date NOT NULL,
  `purchasePlace` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warranty` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `GearItem`
--

INSERT INTO `GearItem` (`id`, `name`, `currentOwnerId`, `categoryId`, `purchasePrice`, `purchaseDate`, `purchasePlace`, `warranty`) VALUES
(1, 'Lenovo X1 Carbon', 2, 2, '2213.00', '2012-01-01', 'Neptun', '2017-01-01'),
(3, 'Sony Kamera', 1, 4, '650.00', '2008-02-02', 'Digitec', '2011-02-02'),
(4, 'iPhone 6s', 2, 1, '650.00', '2008-02-02', 'Digitec', '2010-02-02'),
(5, 'Canon 50mm 1.8 STM', 1, 5, '105.00', '2015-01-10', 'Digitec', '2010-10-10');

-- --------------------------------------------------------

--
-- Table structure for table `Packaging`
--

CREATE TABLE `Packaging` (
  `id` int(11) NOT NULL,
  `title_en` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_de` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Packaging`
--

INSERT INTO `Packaging` (`id`, `title_en`, `title_de`) VALUES
(0, 'not set', 'nicht gesetzt'),
(1, 'Unopened', 'Ungeöffnet'),
(2, 'Opened and with original packaging', 'Geöffnet mit Originalverpackung'),
(3, 'Without original packaging', 'Ohne Originalverpackung');

-- --------------------------------------------------------

--
-- Table structure for table `Sale`
--

CREATE TABLE `Sale` (
  `id` int(11) NOT NULL,
  `gearId` int(11) NOT NULL,
  `salesPrice` decimal(8,2) NOT NULL,
  `salesStart` datetime NOT NULL,
  `salesEnd` datetime NOT NULL,
  `appearanceId` int(11) NOT NULL,
  `functioningId` int(11) NOT NULL,
  `packagingId` int(11) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Sale`
--

INSERT INTO `Sale` (`id`, `gearId`, `salesPrice`, `salesStart`, `salesEnd`, `appearanceId`, `functioningId`, `packagingId`, `description`) VALUES
(1, 1, '200.00', '2017-12-19 00:00:00', '2018-01-10 00:00:00', 1, 1, 2, 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.   \r\n\r\nDuis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.   \r\n\r\nUt wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.   \r\n\r\nNam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer'),
(2, 3, '149.95', '2017-12-21 22:17:50', '2018-01-31 00:00:00', 1, 1, 3, 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `id` int(11) NOT NULL,
  `userName` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip` int(11) NOT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registrationDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`id`, `userName`, `firstName`, `lastName`, `email`, `street`, `zip`, `city`, `password`, `registrationDate`) VALUES
(1, 'mkilchhofer', 'Marco', 'Kilchhofer', 'marco@kilchhofer.info', 'Seilerweg 11', 2557, 'Studen', '$2y$12$VKce9H3G3Q9JgpCBL3M6suWZDp9Dj7ONd8v9MBojCN9uy0uFrsvL6', '2017-09-17 00:00:00'),
(2, 'mschmutz', 'Manuel', 'Schmutz', '', '', 0, '', '$2y$12$Xj.3V91pDNjlojcVQpd7dewEJq79LkOh.w4rnese9jr7mGZFtSxXG', '2017-09-17 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Appearance`
--
ALTER TABLE `Appearance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Attachment`
--
ALTER TABLE `Attachment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Attachment_gearId` (`gearId`),
  ADD KEY `FK_Attachment_typeId` (`typeId`);

--
-- Indexes for table `AttachmentType`
--
ALTER TABLE `AttachmentType`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Category`
--
ALTER TABLE `Category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Functioning`
--
ALTER TABLE `Functioning`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `GearItem`
--
ALTER TABLE `GearItem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_GearItem_currentOwnerId` (`currentOwnerId`),
  ADD KEY `FK_GearItem_categoryId` (`categoryId`);

--
-- Indexes for table `Packaging`
--
ALTER TABLE `Packaging`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Sale`
--
ALTER TABLE `Sale`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Sale_gearId` (`gearId`),
  ADD KEY `FK_Sale_appearanceId` (`appearanceId`),
  ADD KEY `FK_Sale_functioningId` (`functioningId`),
  ADD KEY `FK_Sale_packagingId` (`packagingId`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Appearance`
--
ALTER TABLE `Appearance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Attachment`
--
ALTER TABLE `Attachment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `AttachmentType`
--
ALTER TABLE `AttachmentType`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Category`
--
ALTER TABLE `Category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `Functioning`
--
ALTER TABLE `Functioning`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `GearItem`
--
ALTER TABLE `GearItem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `Packaging`
--
ALTER TABLE `Packaging`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Sale`
--
ALTER TABLE `Sale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Attachment`
--
ALTER TABLE `Attachment`
  ADD CONSTRAINT `FK_Attachment_gearId` FOREIGN KEY (`gearId`) REFERENCES `GearItem` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Attachment_typeId` FOREIGN KEY (`typeId`) REFERENCES `AttachmentType` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `GearItem`
--
ALTER TABLE `GearItem`
  ADD CONSTRAINT `FK_GearItem_categoryId` FOREIGN KEY (`categoryId`) REFERENCES `Category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_GearItem_currentOwnerId` FOREIGN KEY (`currentOwnerId`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Sale`
--
ALTER TABLE `Sale`
  ADD CONSTRAINT `FK_Sale_appearanceId` FOREIGN KEY (`appearanceId`) REFERENCES `Appearance` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Sale_functioningId` FOREIGN KEY (`functioningId`) REFERENCES `Functioning` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Sale_gearId` FOREIGN KEY (`gearId`) REFERENCES `GearItem` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Sale_packagingId` FOREIGN KEY (`packagingId`) REFERENCES `Packaging` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
