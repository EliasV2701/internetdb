-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 15. Nov 2022 um 10:15
-- Server-Version: 10.5.16-MariaDB-1:10.5.16+maria~focal-log
-- PHP-Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `d037fb66`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `locations`
--

CREATE TABLE `locations` (
  `uuid` varchar(36) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'iBeacon UUID',
  `major` int(8) NOT NULL COMMENT 'Beacon Major Value',
  `minor` int(8) NOT NULL COMMENT 'Beacon Minor Value',
  `location` mediumtext CHARACTER SET utf8 COLLATE utf8_german2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `locations`
--

INSERT INTO `locations` (`uuid`, `major`, `minor`, `location`) VALUES
('FXX18B9B-7509-4C31-A905-1A27D39C2020', 0, 0, 'Dummy Location'),
('FXX18B9B-7509-4C31-A905-1A27D39C2020', 100, 0, 'Außerhalb der Buchungszone 104'),
('FXX18B9B-7509-4C31-A905-1A27D39C2020', 100, 1000, 'BA Haupteingang'),
('FXX18B9B-7509-4C31-A905-1A27D39C2020', 100, 1001, 'BA Stockwerk 1'),
('FXX18B9B-7509-4C31-A905-1A27D39C2020', 200, 0, 'Außerhalb der Buchungszone 125'),
('FXX18B9B-7509-4C31-A905-1A27D39C2020', 200, 2000, 'Wappfactory Parkplatz'),
('FXX18B9B-7509-4C31-A905-1A27D39C2020', 200, 2001, 'Wappfactory Eingang Haus 1'),
('FXX18B9B-7509-4C31-A905-1A27D39C2020', 200, 2002, 'Wappfactory Eingang Haus 2');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`uuid`,`major`,`minor`),
  ADD UNIQUE KEY `location` (`location`) USING HASH;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
