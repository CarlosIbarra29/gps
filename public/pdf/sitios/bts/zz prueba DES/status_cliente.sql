-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 20-01-2021 a las 10:28:52
-- Versión del servidor: 5.7.23-23
-- Versión de PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gpsccomm_sistema`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status_cliente`
--

CREATE TABLE `status_cliente` (
  `id` int(11) NOT NULL,
  `nombre_status` varchar(45) DEFAULT NULL,
  `tipo_proyecto` varchar(45) DEFAULT NULL,
  `prioridad` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `status_cliente`
--

INSERT INTO `status_cliente` (`id`, `nombre_status`, `tipo_proyecto`, `prioridad`, `created_at`) VALUES
(1, 'TTV', '1', 1, '2020-10-13 21:10:09'),
(2, 'Proyecto Preliminar', '1', 2, '2020-10-13 21:10:24'),
(3, 'RedLines', '1', 3, '2020-10-13 21:10:33'),
(4, 'Proyecto Final', '1', 4, '2020-10-13 21:10:42'),
(5, 'Adquisición Insumos', '1', 5, '2020-10-13 21:10:55'),
(6, 'En espera de PO', '1', 6, '2020-10-13 21:11:09'),
(7, 'NTP', '1', 7, '2020-10-13 21:11:22'),
(8, 'En Ejecución', '1', 8, '2020-10-13 21:11:31'),
(9, 'Montaje', '1', 9, '2020-10-13 21:12:22'),
(10, 'Reporte Sitio Terminado', '1', 10, '2020-10-13 21:12:33'),
(11, 'Entrega a Cliente', '1', 11, '2020-10-13 21:12:46'),
(12, 'ODK Operador', '1', 12, '2020-10-13 21:13:06'),
(13, 'PunchList Operador', '1', 13, '2020-10-13 21:13:19'),
(14, 'Corrección de Detalles', '1', 14, '2020-10-13 21:13:32'),
(15, 'Protocolo Liberación', '1', 15, '2020-10-13 21:13:42'),
(16, 'Entrega de Carpeta', '1', 16, '2020-10-13 21:13:52'),
(17, 'Carta de Liberación', '1', 20, '2020-10-13 21:14:08'),
(18, 'TTV', '2', 1, '2020-10-13 21:15:57'),
(19, 'Proyecto Preliminar', '2', 2, '2020-10-13 21:16:08'),
(20, 'RedLines', '2', 3, '2020-10-13 21:16:19'),
(21, 'Proyecto Final', '2', 4, '2020-10-13 21:16:29'),
(22, 'Adquisición Insumos', '2', 5, '2020-10-13 21:16:46'),
(23, 'En espera de PO', '2', 6, '2020-10-13 21:17:01'),
(24, 'NTP', '2', 7, '2020-10-13 21:17:15'),
(25, 'En Ejecución', '2', 8, '2020-10-13 21:17:24'),
(26, 'Montaje', '2', 9, '2020-10-13 21:17:43'),
(27, 'Reporte Sitio Terminado', '2', 10, '2020-10-13 21:17:52'),
(28, 'Entrega a Cliente', '2', 11, '2020-10-13 21:18:06'),
(29, 'ODK Operador', '2', 12, '2020-10-13 21:18:14'),
(30, 'PunchList Operador', '2', 13, '2020-10-13 21:18:32'),
(31, 'Corrección de Detalles', '2', 14, '2020-10-13 21:18:42'),
(32, 'Protocolo Liberación', '2', 15, '2020-10-13 21:18:49'),
(33, 'Entrega de Carpeta', '2', 16, '2020-10-13 21:19:01'),
(34, 'Carta de Liberación', '2', 17, '2020-10-13 21:19:11'),
(35, 'En Cotización', '3', 1, '2020-10-13 21:20:02'),
(36, 'ROI', '3', 2, '2020-10-13 21:20:10'),
(37, 'Con Requisición', '3', 3, '2020-10-13 21:20:18'),
(38, 'En espera de PO', '3', 4, '2020-10-13 21:20:28'),
(39, 'Negociación', '3', 5, '2020-10-13 21:20:40'),
(40, 'En Ejecución', '3', 6, '2020-10-13 21:20:50'),
(41, 'En espera de QA', '3', 7, '2020-10-13 21:21:00'),
(42, 'Liberado', '3', 8, '2020-10-13 21:21:13'),
(43, 'Cotización', '4', 1, '2020-10-13 21:21:58'),
(44, 'En espera de PO', '4', 2, '2020-10-13 21:22:10'),
(45, 'En Ejecución', '4', 3, '2020-10-13 21:22:24'),
(46, 'Entrega de Carpeta', '4', 4, '2020-10-13 21:22:39'),
(47, 'Cancelado', '3', 9, '2020-11-30 16:08:14'),
(48, 'En Revisión', '5', 1, '2021-01-11 18:45:47'),
(49, 'Asignada', '5', 2, '2021-01-11 18:45:56'),
(50, 'No Asignada', '5', 3, '2021-01-11 18:46:07');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `status_cliente`
--
ALTER TABLE `status_cliente`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `status_cliente`
--
ALTER TABLE `status_cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
