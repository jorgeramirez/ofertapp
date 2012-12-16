-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-12-2012 a las 23:59:40
-- Versión del servidor: 5.5.27-log
-- Versión de PHP: 5.4.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: 'ofertappdatabase'
--

-- --------------------------------------------------------

--
-- Volcado de datos para la tabla 'category'
--



-- --------------------------------------------------------

-- Volcado de datos para la tabla 'seller'
--

INSERT INTO seller (idSeller, sellerName, address, latitude, longitude, photo) VALUES
(1, 'Puntopy', 'Avenida Mariscal Francisco Solano López', '-25.291934000000000', '-57.601566000000000', NULL),
(2, 'Esso', 'España y Brasilia', '-25.288306000000000', '-57.602499000000000', NULL);

-- --------------------------------------------------------

--
-- Volcado de datos para la tabla 'user'
--

INSERT INTO `user` (idUser, userIDFb, mail, offersCount, rating, ratingsCount, creationDate) VALUES
(1, '4334269522120', 'nahuel.11990@gmail.com', 0, 0, 0, '2012-12-15 19:43:19'),
(2, '4419074428396', 'santiago.kenshinvaldez@gmail.com', 0, 0, 0, '2012-12-15 19:44:47'),
(3, '3507064649072', 'jorgeramirez1990@gmail.com', 0, 0, 0, '2012-12-15 19:53:24');


-- --------------------------------------------------------

--
-- Volcado de datos para la tabla 'offer'
--

INSERT INTO offer (idOffer, offerName, offerDescription, `date`, rating, ratingsCount, photo, price, currency, sellerId, categoryId, userId) VALUES
(1, 'Remeras Microsoft', 'Remeras de Microsoft en el Hackaton', '2012-12-15', 0, 0, NULL, 0, 'PYG', 1, 3, 1),
(2, 'Coca Cola Barato!', NULL, '2012-12-15', 0, 0, NULL, 9500, 'PYG', 2, 1, 2);
