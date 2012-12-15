-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-12-2012 a las 23:06:24
-- Versión del servidor: 5.5.27-log
-- Versión de PHP: 5.4.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `ofertappdatabase`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `idCategory` int(11) NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(200) COLLATE utf8_bin NOT NULL,
  `smallPhoto` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `photo` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`idCategory`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `offert`
--

CREATE TABLE IF NOT EXISTS `offert` (
  `idOffert` int(11) NOT NULL AUTO_INCREMENT,
  `offertName` varchar(200) COLLATE utf8_bin NOT NULL,
  `offertDescription` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `date` date NOT NULL,
  `rating` int(11) NOT NULL DEFAULT '0',
  `ratingsCount` int(11) NOT NULL DEFAULT '0',
  `photo` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `price` int(11) NOT NULL,
  `currency` varchar(3) COLLATE utf8_bin NOT NULL DEFAULT 'PYG' COMMENT 'ISO 4217 Currency Codes',
  `sellerId` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  PRIMARY KEY (`idOffert`),
  KEY `sellerId` (`sellerId`),
  KEY `categoryId` (`categoryId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seller`
--

CREATE TABLE IF NOT EXISTS `seller` (
  `idSeller` int(11) NOT NULL AUTO_INCREMENT,
  `sellerName` varchar(200) COLLATE utf8_bin NOT NULL,
  `address` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `latitude` decimal(18,15) NOT NULL,
  `longitude` decimal(18,15) NOT NULL,
  `photo` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`idSeller`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `userIDFb` varchar(100) COLLATE utf8_bin NOT NULL,
  `mail` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `offertsCount` int(11) NOT NULL DEFAULT '0',
  `rating` int(11) NOT NULL DEFAULT '0',
  `ratingsCount` int(11) NOT NULL DEFAULT '0',
  `creationDate` datetime NOT NULL,
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `offert`
--
ALTER TABLE `offert`
  ADD CONSTRAINT `offert_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`idUser`),
  ADD CONSTRAINT `offert_ibfk_2` FOREIGN KEY (`categoryId`) REFERENCES `category` (`idCategory`),
  ADD CONSTRAINT `offert_ibfk_3` FOREIGN KEY (`sellerId`) REFERENCES `seller` (`idSeller`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;