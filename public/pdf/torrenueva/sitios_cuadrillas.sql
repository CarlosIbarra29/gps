-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-05-2021 a las 20:20:02
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
-- Estructura de tabla para la tabla `sitios_cuadrillas`
--

CREATE TABLE `sitios_cuadrillas` (
  `id` int(11) NOT NULL,
  `nombre_sitio` varchar(190) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sitios_cuadrillas`
--

INSERT INTO `sitios_cuadrillas` (`id`, `nombre_sitio`, `created_at`) VALUES
(1, 'Naranjos', '2021-05-28 17:50:18'),
(2, 'Taller', '2021-05-28 17:50:18'),
(3, 'Compensacion', '2021-05-28 17:50:18'),
(4, 'Vacaciones', '2021-05-28 17:50:18');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `sitios_cuadrillas`
--
ALTER TABLE `sitios_cuadrillas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `sitios_cuadrillas`
--
ALTER TABLE `sitios_cuadrillas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
