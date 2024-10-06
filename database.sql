-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 16-09-2020 a las 16:37:17
-- Versión del servidor: 10.5.5-MariaDB-1:10.5.5+maria~focal
-- Versión de PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `database`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text NOT NULL, 
  `nan` text NOT NULL, 
  `telefonoa` int(9) NOT NULL,
  `jaiotze_data` date NOT NULL,
  `email` text NOT NULL,
  `pasahitza` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `FunkoPop` (
   `id` int(11) NOT NULL,
   `izena` text NOT NULL,
   `mota` text NOT NULL,
   `tamaina` text NOT NULL, 
   `prezioa` float NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
	

--
-- Volcado de datos para la tabla `usuarios`
--
INSERT INTO `usuarios` (nombre, nan, telefonoa, jaiotze_data, email, pasahitza) VALUES 
  ('admin', '66666666-Q', 644646464, '2004-04-02', 'admin@gmail.com', '1234');

INSERT INTO `FunkoPop` VALUES
  (101, 'Will', 'Stranger Things', 'Handia', 30.99),
  (190, 'Hange Zoe', 'Attack on Titan', 'Ertaina', 16.99),
  (333, 'Mikasa Ackerman', 'Attack on Titan', 'Txikia', 5.99),
  (495, 'Homer Simpson', 'The Simpsons', 'Ertaina', 16.99),
  (666, 'Darth Vader', 'Star Wars', 'Handia', 30.99);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
