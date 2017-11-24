-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Erstellungszeit: 24. Nov 2017 um 14:55
-- Server-Version: 10.2.10-MariaDB-10.2.10+maria~jessie
-- PHP-Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `mygear`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `GearItem`
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
-- Daten für Tabelle `GearItem`
--

INSERT INTO `GearItem` (`GearId`, `GearName`, `CurrentOwnerId`, `PurchasePrice`, `PurchaseDate`, `PurchasePlace`) VALUES
(1, 'iPod', 2, '2.00', '2017-11-01', 'Saturn'),
(2, 'lenovo x1', 2, '500.00', '2009-01-01', 'schmudi');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Picture`
--

CREATE TABLE `Picture` (
  `PictureId` int(11) NOT NULL,
  `GearId` int(11) NOT NULL,
  `PictureTypeId` int(11) NOT NULL,
  `PictureDescription` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `Picture`
--

INSERT INTO `Picture` (`PictureId`, `GearId`, `PictureTypeId`, `PictureDescription`) VALUES
(2, 1, 2, 'Descr');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PictureType`
--

CREATE TABLE `PictureType` (
  `PictureTypeId` int(11) NOT NULL,
  `PictureTypeName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `PictureType`
--

INSERT INTO `PictureType` (`PictureTypeId`, `PictureTypeName`) VALUES
(1, 'UserPicture'),
(2, 'ItemPicture');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `User`
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
  `IsAdmin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `User`
--

INSERT INTO `User` (`UserId`, `UserName`, `FirstName`, `LastName`, `EmailAddress`, `AddressStreet`, `AddressZIP`, `AddressCity`, `IsAdmin`) VALUES
(1, 'mkilchhofer', 'Marco', 'Kilchhofer', 'marco@kilchhofer.info', 'Seilerweg 11', 2557, 'Studen', 1),
(2, 'mschmutz', 'Manuel', 'Schmutz', '', '', 0, '', 1);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `GearItem`
--
ALTER TABLE `GearItem`
  ADD PRIMARY KEY (`GearId`),
  ADD KEY `FK_CurrentOwnerId` (`CurrentOwnerId`);

--
-- Indizes für die Tabelle `Picture`
--
ALTER TABLE `Picture`
  ADD PRIMARY KEY (`PictureId`),
  ADD KEY `FK_GearId` (`GearId`) USING BTREE,
  ADD KEY `FK_PictureType` (`PictureTypeId`);

--
-- Indizes für die Tabelle `PictureType`
--
ALTER TABLE `PictureType`
  ADD PRIMARY KEY (`PictureTypeId`);

--
-- Indizes für die Tabelle `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`UserId`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `GearItem`
--
ALTER TABLE `GearItem`
  MODIFY `GearId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `Picture`
--
ALTER TABLE `Picture`
  MODIFY `PictureId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `PictureType`
--
ALTER TABLE `PictureType`
  MODIFY `PictureTypeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `GearItem`
--
ALTER TABLE `GearItem`
  ADD CONSTRAINT `FK_CurrentOwnerId` FOREIGN KEY (`CurrentOwnerId`) REFERENCES `User` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `Picture`
--
ALTER TABLE `Picture`
  ADD CONSTRAINT `FK_GearId` FOREIGN KEY (`GearId`) REFERENCES `GearItem` (`GearId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PictureType` FOREIGN KEY (`PictureTypeId`) REFERENCES `PictureType` (`PictureTypeId`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
