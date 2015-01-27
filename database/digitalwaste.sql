-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 27 jan 2015 om 04:09
-- Serverversie: 5.5.40-0ubuntu0.14.04.1
-- PHP-versie: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `digitalwaste`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `dropbox_files`
--

CREATE TABLE IF NOT EXISTS `dropbox_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `path` text NOT NULL,
  `filename` varchar(255) NOT NULL,
  `extension` varchar(20) NOT NULL,
  `folder` varchar(100) NOT NULL,
  `bytes` int(11) NOT NULL,
  `size` varchar(30) NOT NULL,
  `mime_type` varchar(100) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `created` varchar(100) NOT NULL,
  `updated` varchar(100) NOT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  `write_path` varchar(255) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=545 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `dropbox_results`
--

CREATE TABLE IF NOT EXISTS `dropbox_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `verd_extensies` text NOT NULL,
  `gem_bestandsgrootte` float NOT NULL,
  `eerst_geupload` varchar(255) NOT NULL,
  `gem_rating` float NOT NULL,
  `verd_rating` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Gegevens worden uitgevoerd voor tabel `dropbox_results`
--

INSERT INTO `dropbox_results` (`id`, `user_id`, `verd_extensies`, `gem_bestandsgrootte`, `eerst_geupload`, `gem_rating`, `verd_rating`) VALUES
(0, 0, '{"document":0,"image":0,"video":0}', 0, '', 0, '{"document":0,"image":0,"video":0}');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `dropbox_users`
--

CREATE TABLE IF NOT EXISTS `dropbox_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=114 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
