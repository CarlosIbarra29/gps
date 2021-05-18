-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-01-2021 a las 00:40:05
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_gpsconstructivos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizaciones_sitios`
--

CREATE TABLE `cotizaciones_sitios` (
  `id` int(11) NOT NULL,
  `sitio_id` int(11) DEFAULT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `fecha_cotizacion` varchar(50) DEFAULT NULL,
  `fecha` varchar(50) DEFAULT NULL,
  `usuario` varchar(60) DEFAULT NULL,
  `documento` varchar(100) DEFAULT NULL,
  `total` varchar(105) DEFAULT NULL,
  `comentario` varchar(150) DEFAULT NULL,
  `status_documento` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cotizaciones_sitios`
--

INSERT INTO `cotizaciones_sitios` (`id`, `sitio_id`, `titulo`, `fecha_cotizacion`, `fecha`, `usuario`, `documento`, `total`, `comentario`, `status_documento`, `created_at`) VALUES
(1, 177, 'Nueva cotizacion', '07/01/2021', '07-01-2021', 'Fernando Herrera Admin', 'img/cotizacion_sitios/Solicitud NO 10 .pdf', '550', 'Queda pendiente documento', 0, '2021-01-07 22:12:05'),
(2, NULL, '', '', NULL, NULL, 'img/cotizacion_sitios/db_gpsconstructivos.sql', '', '', 0, '2021-01-07 23:07:47'),
(3, 177, 'Titulo de cotizacion dos', '', '07-01-2021', 'Fernando Herrera Admin', 'img/cotizacion_sitios/db_gpsconstructivos.sql', '450', 'Pendiente', 0, '2021-01-07 23:34:34');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cotizaciones_sitios`
--
ALTER TABLE `cotizaciones_sitios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cotizaciones_sitios`
--
ALTER TABLE `cotizaciones_sitios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
