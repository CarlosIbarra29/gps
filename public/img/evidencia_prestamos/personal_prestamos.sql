-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-06-2021 a las 20:39:52
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
-- Estructura de tabla para la tabla `personal_prestamos`
--

CREATE TABLE `personal_prestamos` (
  `id` int(11) NOT NULL,
  `id_personal` int(11) DEFAULT NULL,
  `nombre_personal` varchar(120) DEFAULT NULL,
  `fecha_prestamo` varchar(120) DEFAULT NULL,
  `monto` varchar(120) DEFAULT NULL,
  `cantidad_pagos` int(11) DEFAULT 0,
  `motivo` varchar(190) DEFAULT NULL,
  `evidencia` varchar(190) DEFAULT NULL,
  `status_prestamo` int(11) DEFAULT 0,
  `cantidad_saldada` int(11) DEFAULT 0,
  `fecha_liquidacion` varchar(120) DEFAULT NULL,
  `user_prestamo` varchar(190) DEFAULT NULL,
  `user_fecha` varchar(190) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `personal_prestamos`
--

INSERT INTO `personal_prestamos` (`id`, `id_personal`, `nombre_personal`, `fecha_prestamo`, `monto`, `cantidad_pagos`, `motivo`, `evidencia`, `status_prestamo`, `cantidad_saldada`, `fecha_liquidacion`, `user_prestamo`, `user_fecha`, `created_at`) VALUES
(1, 160, 'Abel DE JESÚS Robles', '30-06-2021', '1000', 5, 'Motivo del prestamo', 'img/evidencia_prestamos/cortadora de madera reparacion.JPG', 0, 0, NULL, 'Administrador Admin Admin', '25-06-2021', '2021-06-25 17:50:10');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `personal_prestamos`
--
ALTER TABLE `personal_prestamos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `personal_prestamos`
--
ALTER TABLE `personal_prestamos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
