-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 30 jan 2019 om 11:01
-- Serverversie: 10.1.26-MariaDB
-- PHP-versie: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onera`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `usr`
--

CREATE TABLE `usr` (
  `idusr` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(80) NOT NULL,
  `is_admin` smallint(2) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `usr`
--

INSERT INTO `usr` (`idusr`, `username`, `password`, `is_admin`) VALUES
(3, 'oneraadmin', '$2y$10$ZdTAhNvpy9xfe5vKza.vYu12ddNqsOVUUakaYOouShgIFrbaNwvQW', 0),
(4, 'onerauser', '$2y$10$ZdTAhNvpy9xfe5vKza.vYu12ddNqsOVUUakaYOouShgIFrbaNwvQW', 0);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `usr`
--
ALTER TABLE `usr`
  ADD PRIMARY KEY (`idusr`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `usr`
--
ALTER TABLE `usr`
  MODIFY `idusr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
