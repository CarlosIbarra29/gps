-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-04-2021 a las 20:12:27
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
-- Estructura de tabla para la tabla `materiales_solicitud`
--

CREATE TABLE `materiales_solicitud` (
  `id` int(11) NOT NULL,
  `id_sitio` int(11) DEFAULT NULL,
  `name_sitio` varchar(90) DEFAULT NULL,
  `id_tipoproyecto` int(11) DEFAULT NULL,
  `user_solicitud` varchar(190) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `fecha_user` varchar(90) DEFAULT NULL,
  `fecha_solicitada` varchar(90) DEFAULT NULL,
  `step_solicitud` int(11) DEFAULT 0,
  `file` varchar(190) DEFAULT NULL,
  `comentario` varchar(190) DEFAULT NULL,
  `status_solicitud` int(11) DEFAULT 0,
  `fecha_auditoria` varchar(90) DEFAULT NULL,
  `user_auditoria` varchar(90) DEFAULT NULL,
  `auditoria_comentario` varchar(190) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `materiales_solicitud`
--

INSERT INTO `materiales_solicitud` (`id`, `id_sitio`, `name_sitio`, `id_tipoproyecto`, `user_solicitud`, `id_user`, `fecha_user`, `fecha_solicitada`, `step_solicitud`, `file`, `comentario`, `status_solicitud`, `fecha_auditoria`, `user_auditoria`, `auditoria_comentario`, `created_at`) VALUES
(1, 77, 'Naranjos', 77, 'Administrador Admin Admin', 14, '30-04-2021 12:45:41pm', '30/04/2021', 1, 'pdf/materiales/Logistica de envios 29_04_2021 (2).pdf', '', 0, NULL, NULL, NULL, '2021-04-30 17:51:37'),
(2, 77, 'Naranjos', 77, 'Administrador Admin Admin', 14, '30-04-2021 12:33:30pm', '29/04/2021', 1, 'pdf/materiales/Logistica de envios 16_04_2021.pdf', '', 0, NULL, NULL, NULL, '2021-04-30 17:51:39');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `materiales_solicitud`
--
ALTER TABLE `materiales_solicitud`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `materiales_solicitud`
--
ALTER TABLE `materiales_solicitud`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
