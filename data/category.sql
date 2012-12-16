-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-12-2012 a las 13:06:14
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=26 ;

--
-- Volcado de datos para la tabla `category`
--

INSERT INTO `category` (`idCategory`, `categoryName`, `smallPhoto`, `photo`) VALUES
(1, 'Autos', 'img/icono-auto.png', NULL),
(2, 'Bolsos', 'img/icono-bolsos.png', NULL),
(3, 'Celulares', 'img/icono-celulares.png', NULL),
(4, 'Cervezas', 'img/icono-cerveza.png', NULL),
(5, 'Comidas Rápidas', 'img/icono-comida-rapida.png', NULL),
(6, 'Computadoras', 'img/icono-computer.png', NULL),
(8, 'Computadoras', 'img/icono-computer.png', NULL),
(9, 'Cosméticos', 'img/icono-cosmeticos.png', NULL),
(10, 'Frutas', 'img/icono-frutas.png', NULL),
(11, 'Gaseosas', 'img/icono-gaseosa.png', NULL),
(12, 'Joyas', 'img/icono-joyas.png', NULL),
(13, 'Lentes', 'img/icono-lentes.png', NULL),
(14, 'Libros', 'img/icono-libros.png', NULL),
(15, 'Relojes', 'img/icono-relojes.png', NULL),
(16, 'Restorantes', 'img/icono-restorant.png', NULL),
(17, 'Ropas', 'img/icono-ropas.png', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
