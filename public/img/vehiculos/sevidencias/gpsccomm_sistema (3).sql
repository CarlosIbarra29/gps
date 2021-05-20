-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 19-05-2021 a las 17:10:29
-- Versión del servidor: 5.7.23-23
-- Versión de PHP: 7.3.27

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
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id_vehiculos` int(11) NOT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `submarca` varchar(100) DEFAULT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `placas` varchar(100) DEFAULT NULL,
  `color` varchar(100) DEFAULT NULL,
  `id_status` int(11) DEFAULT '0',
  `id_grupo` int(11) DEFAULT '0',
  `imagen` varchar(100) DEFAULT NULL,
  `tarjeta_circulacion` varchar(200) DEFAULT NULL,
  `comentarios` varchar(100) DEFAULT NULL,
  `id_responsable` int(11) DEFAULT '0',
  `fecha` varchar(200) DEFAULT NULL,
  `fechar` varchar(200) DEFAULT NULL,
  `fechab` varchar(200) DEFAULT NULL,
  `comentarior` varchar(200) DEFAULT NULL,
  `comentariob` varchar(200) DEFAULT NULL,
  `evidenciab` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`id_vehiculos`, `marca`, `submarca`, `modelo`, `placas`, `color`, `id_status`, `id_grupo`, `imagen`, `tarjeta_circulacion`, `comentarios`, `id_responsable`, `fecha`, `fechar`, `fechab`, `comentarior`, `comentariob`, `evidenciab`, `created_at`) VALUES
(1, 'HYUNDAY', 'TUCSON', '2018', 'D69AXY', 'BLANCO', 0, 1, 'img/vehiculos/autos/TUCSON.jpeg', NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-27 21:18:18'),
(2, 'HILUX', 'DOBLE CABINA', '2018', 'F15AWY', 'BLANCO', 0, 1, 'img/vehiculos/autos/F15AWY.jpeg', NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-16 17:57:03'),
(3, 'HILUX', 'DOBLE CABINA', '2016', 'SS0303E', 'GRIS', 1, 2, 'img/vehiculos/autos/WhatsApp Image 2021-03-10 at 12.52.06 PM.jpeg', 'img/vehiculos/tarjetas_circulacion/TC SS0303E HILUX GRIS.jpeg', 'RESPONSABLE Pablo Vidal  a partir de 12/06/2021 llanta de refacción, gato y llave de cruz correctos ', 50, '18-05-2021', '', NULL, '', NULL, NULL, '2021-05-18 19:38:56'),
(4, 'HILUX', 'CHASIS CABINA', '2020', 'W72BED', 'BLANCO', 2, 2, '', 'img/vehiculos/tarjetas_circulacion/TC W72BED.jpeg', 'VEHICULO LO TRAE PABLO VIDAL, SE LO LLEVO DE TALLER POLI EMILIO PARA ENTREGARSE A GUILLERMO ARREOLA,', 59, '19-04-2021', '2021-05-13', NULL, 'reparar fuera de la agencia costo en agencia  $7248.81', NULL, NULL, '2021-05-13 17:01:40'),
(5, 'HILUX', 'DOBLE CABINA', '2013', 'NCZ7230', 'BLANCO', 1, 2, 'img/vehiculos/autos/FOTO CAMIONETA NCZ7230.jpeg', 'img/vehiculos/tarjetas_circulacion/Constancia General de Extravio.pdf', 'reporta Juan Carlos hidalgo robo de tarjeta de circulación el 26/04/2021 hacer tramite de reposición', 27, '23-04-2021', NULL, NULL, NULL, NULL, NULL, '2021-05-03 20:23:13'),
(6, 'HILUX', 'CHASIS CABINA', '2019', 'U45BBL', 'BLANCO', 2, 2, NULL, 'img/vehiculos/tarjetas_circulacion/TC U45BBL  K1405692.jpeg', 'JORGE CISNEROS', 0, '01-04-2021', '2021-05-03', NULL, 'VALUAR DAÑO', NULL, NULL, '2021-05-10 21:13:33'),
(7, 'HILUX', 'CHASIS CABINA', '2019', 'U08BCY', 'GRIS', 1, 2, 'img/vehiculos/autos/WhatsApp Image 2021-03-13 at 11.54.08 PM.jpeg', '', 'KEVIN BARRON 04/05/2021', 33, '04-05-2021', NULL, NULL, NULL, NULL, NULL, '2021-05-04 19:38:09'),
(8, 'HILUX', 'CHASIS CABINA', '2020', 'T68BHF', 'BLANCO', 1, 2, 'img/vehiculos/autos/T68BHF.jpeg', NULL, 'JUAN MAGAÑA', 28, '17-04-2021', '', NULL, '', NULL, NULL, '2021-04-17 16:21:16'),
(9, 'NISSAN', 'NP 300 ', '2018', 'T25ASL', 'BLANCO', 1, 2, '', NULL, 'FERNANDO GONZALEZ', 35, '23-04-2021', NULL, NULL, NULL, NULL, NULL, '2021-04-23 21:12:48'),
(10, 'HILUX', 'CHASIS CABINA', '2020', 'W97BED', 'BLANCO', 1, 2, '', NULL, '26/04/2021 SE LA LLEVA OCTAVIO AVILA PARA ENTREGA A FERNANDO GONZALEZ, EFECTICARD PENDIENTE', 95, '03-05-2021', NULL, NULL, NULL, NULL, NULL, '2021-05-03 18:01:26'),
(12, 'HILUX', 'DOBLE CABINA', '2014', 'MRJ9237', 'BLANCO', 2, 2, '', NULL, 'ASIGNADO A FERNANDO GONZALEZ 04 ABRIL 2021', 0, '08-04-2021', '', NULL, ' ', NULL, NULL, '2021-05-03 17:56:57'),
(13, 'FORD', 'F-350', '2017', 'NZ1052A', 'BLANCO', 0, 3, 'img/vehiculos/autos/F350 2017.jpeg', NULL, 'TALLER POLI', 0, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-27 21:02:27'),
(14, 'CAMION INTERNACIONAL', '4300', '2020', 'LD48340', 'BLANCO', 1, 3, 'img/vehiculos/autos/camion 2020.jpeg', NULL, 'TALLER LA RAZA', 9, '19-05-2021', NULL, NULL, NULL, NULL, NULL, '2021-05-19 18:34:26'),
(15, 'CAMION INTERNACIONAL', '4300', '2018', 'A543AB', 'BLANCO', 0, 3, 'img/vehiculos/autos/CAMION 2018.jpeg', '', 'SITIO LLANETES CHOFER OCTAVIO AVILA 05/05/2020', 0, '18-05-2021', NULL, NULL, NULL, NULL, NULL, '2021-05-19 18:33:36'),
(16, 'FORD', 'F-350', '2003', 'LE21129', 'BLANCO', 0, 3, 'img/vehiculos/autos/L21129.jpeg', NULL, 'TALLER', 0, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-19 19:29:16'),
(17, 'HILUX', 'DOBLE CABINA', '2020', 'W76BED', 'BLANCO', 1, 1, 'img/vehiculos/autos/W76BED.jpeg', NULL, 'TALLER', 21, '19-05-2021', NULL, NULL, NULL, NULL, NULL, '2021-05-19 18:32:25'),
(18, 'NISSAN', 'ESTACAS', '2011', '974ZXV', 'BLANCO', 1, 3, 'img/vehiculos/autos/ESTACAS 2011.jpeg', NULL, 'TALLER', 184, '19-05-2021', NULL, NULL, NULL, NULL, NULL, '2021-05-19 15:25:59'),
(19, 'RAM', 'RAPID PROMASTER', '2019', 'SY4029A', 'BLANCO', 1, 3, 'img/vehiculos/autos/SY4029A.jpeg', NULL, 'TALLER POLI', 50, '11-05-2021', NULL, NULL, NULL, NULL, NULL, '2021-05-11 15:03:00'),
(20, 'RAM', 'RAPID PROMASTER', '2019', 'NKW8185', 'BLANCO', 0, 3, 'img/vehiculos/autos/NKW8185.jpeg', 'img/vehiculos/tarjetas_circulacion/RAM NKW8185.jpeg', 'TALLER LA RAZA', 0, '12-05-2021', NULL, NULL, NULL, NULL, NULL, '2021-05-12 22:18:58'),
(21, 'VW', 'VENTO', '2014', 'MXG1288', 'BLANCO', 0, 1, 'img/vehiculos/autos/VENTO.jpeg', NULL, 'REALIZAR TRAMITE DE REEMPLACAMIENTO ESTADO DE MEXICO MAYO 2021', 0, '27-04-2021', NULL, NULL, NULL, NULL, NULL, '2021-05-10 20:18:53'),
(22, 'TOYOTA', 'HILUX CHASIS CABINA', '2021', 'L14BHN', 'GRIS', 1, 2, 'img/vehiculos/autos/Hilux 2021.jpeg', 'img/vehiculos/tarjetas_circulacion/HILUX 2021  L14BHN.jpeg', 'DOCUMENTOS Y ACCESORIOS COMPLETOS A SU SALIDA 15/05/2021 PABLO REYES', 30, '15-05-2021', '', NULL, '', NULL, NULL, '2021-05-15 17:56:03'),
(23, 'TOYOTA', 'HILUX CHASIS CABINA', '2020', 'P47BFX', 'BLANCA', 3, 2, '', NULL, 'SINIESTRO PERDIDA TOTAL', 0, NULL, NULL, '19-04-2021', NULL, 'PERDIDA TOTAL POR CHOQUE CHIHUAHUA, DEMANDA A FINANCIERA', 'img/vehiculos/baja/CARTA TRAMITE TOYOTA.docx', '2021-04-21 21:12:47'),
(24, 'TOYOTA', 'HILUX CHASIS CABINA', '2019', 'U36BBL', 'GRIS', 3, 2, '', NULL, '', 0, NULL, NULL, '21-04-2021', NULL, 'CHOQUE PERDIDA TOTAL USUARIO JORGE CISNEROS', 'img/vehiculos/baja/FACTURA HILUX SINIESTRO.pdf', '2021-04-21 21:25:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos_documentacion`
--

CREATE TABLE `vehiculos_documentacion` (
  `id` int(11) NOT NULL,
  `tipo_doc` int(11) DEFAULT '0',
  `id_vehiculo` int(11) DEFAULT '0',
  `nombre_doc` varchar(90) DEFAULT NULL,
  `fecha` varchar(90) DEFAULT NULL,
  `vigencia` varchar(90) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `comentarios` varchar(200) DEFAULT NULL,
  `documento` varchar(200) DEFAULT NULL,
  `id_sol` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `vehiculos_documentacion`
--

INSERT INTO `vehiculos_documentacion` (`id`, `tipo_doc`, `id_vehiculo`, `nombre_doc`, `fecha`, `vigencia`, `status`, `comentarios`, `documento`, `id_sol`, `created_at`) VALUES
(3, 2, 16, 'Póliza de Seguro ', '2021-03-07', '2022-03-07', 0, 'RENOVACION DE POLIZA', 'pdf/vehiculosdoc/uv0728360002284746aa.pdf', NULL, '2021-04-21 22:58:13'),
(4, 2, 15, 'Póliza de Seguro ', '2021-03-22', '2022-03-22', 0, 'RENOVACION DE POLIZA GRUPO ORDAZ', 'pdf/vehiculosdoc/poliza camion 2018.pdf', NULL, '2021-04-22 16:04:57'),
(6, 2, 20, 'Póliza de Seguro ', '2020-11-24', '2021-11-24', 0, 'Primer poliza', 'pdf/vehiculosdoc/ram placas NKW.pdf', NULL, '2021-04-22 17:34:49'),
(7, 2, 19, 'Póliza de Seguro ', '2020-12-07', '2021-11-07', 0, 'PRIMER POLIZA ', 'pdf/vehiculosdoc/POLIZA   SY4029A 9BD265553K9133356.pdf', NULL, '2021-04-22 17:37:58'),
(8, 1, 1, 'Tenencia', '2021-03-19', '2021-03-19', 0, 'REFRENDO ANUAL', 'pdf/vehiculosdoc/T 2021 D69AXY TUCSON.pdf', NULL, '2021-04-22 19:16:25'),
(9, 1, 14, 'Tenencia', '2021-03-30', '2021-03-30', 0, 'REFRENDO ANUAL', 'pdf/vehiculosdoc/T 2021 LD48340.pdf', 16, '2021-04-22 19:19:04'),
(10, 1, 15, 'Tenencia', '2021-03-30', '2021-03-30', 0, 'REFRENDO ANUAL', 'pdf/vehiculosdoc/T 2021 A543AB.pdf', 17, '2021-04-22 19:20:27'),
(13, 1, 13, 'Tenencia', '2021-03-30', '2022-01-01', 0, 'REFRENDO 2021', 'pdf/vehiculosdoc/T 2021 NZ1052A.pdf', 15, '2021-04-22 20:09:28'),
(14, 1, 3, 'Tenencia', '2021-03-30', '2022-01-01', 0, 'REFRENDO 2021', 'pdf/vehiculosdoc/T 2021 SS0303E.pdf', NULL, '2021-04-22 20:13:55'),
(15, 1, 17, 'Tenencia', '2021-03-30', '2022-01-01', 0, 'REFRENDO 2021', 'pdf/vehiculosdoc/T 2021 W76BED.pdf', 18, '2021-04-22 20:15:12'),
(16, 1, 10, 'Tenencia', '2021-03-30', '2022-01-01', 0, 'REFRENDO 2021', 'pdf/vehiculosdoc/T 2021 W97BED.pdf', 13, '2021-04-22 20:17:59'),
(17, 1, 8, 'Tenencia', '2021-03-30', '2022-01-01', 0, 'REFRENDO 2021', 'pdf/vehiculosdoc/T 2021 T68BHF.pdf', 11, '2021-04-22 20:18:55'),
(18, 1, 6, 'Tenencia', '2021-03-30', '2022-01-01', 0, 'REFRENDO 2021', 'pdf/vehiculosdoc/T 2021 U45BBL.pdf', 9, '2021-04-22 20:20:04'),
(20, 1, 4, 'Tenencia', '2021-03-30', '2022-01-01', 0, 'REFRENDO 2021', 'pdf/vehiculosdoc/T 2021 W72BED.pdf', 7, '2021-04-22 20:22:19'),
(21, 1, 2, 'Tenencia', '2021-03-30', '2022-01-01', 0, 'REFRENDO 2021', 'pdf/vehiculosdoc/T 2021 F15AWY.pdf', 5, '2021-04-22 20:23:29'),
(22, 1, 12, 'Tenencia', '2021-03-30', '2020-01-01', 0, 'REFRENDO 2021', 'pdf/vehiculosdoc/T 2021 MRJ9237.pdf', 14, '2021-04-22 20:24:30'),
(23, 1, 7, 'Tenencia', '2021-03-30', '2022-01-01', 0, 'REFRENDO 2021', 'pdf/vehiculosdoc/T 2021 U08BCY.pdf', 10, '2021-04-22 20:27:12'),
(24, 1, 5, 'Tenencia', '2021-03-30', '2022-01-01', 0, 'REFRENDO 2021', 'pdf/vehiculosdoc/T 2021 NCZ7230.pdf', 8, '2021-04-22 20:29:22'),
(25, 1, 18, 'Tenencia', '2021-03-30', '2022-01-01', 0, 'REFRENDO 2021', 'pdf/vehiculosdoc/T 2021 P47BFX.pdf', 19, '2021-04-22 20:30:58'),
(26, 1, 9, 'Tenencia', '2021-03-30', '2022-01-01', 0, 'REFRENDO 2021', 'pdf/vehiculosdoc/T 2021 T25ASL.pdf', 12, '2021-04-22 20:31:59'),
(27, 1, 20, 'Tenencia', '2021-03-30', '2022-01-01', 0, 'REFRENDO 2021', 'pdf/vehiculosdoc/T 2021 NKW8185.pdf', 21, '2021-04-22 20:40:53'),
(28, 1, 19, 'Tenencia', '2021-03-30', '2022-01-01', 0, 'REFRENDO 2021', 'pdf/vehiculosdoc/T 2021 SY4029A.pdf', 20, '2021-04-22 20:41:45'),
(29, 1, 24, 'Tenencia', '2021-03-30', '2022-01-01', 0, 'REFRENDO 2021', 'pdf/vehiculosdoc/T 2021 U36BBL.pdf', NULL, '2021-04-22 20:42:45'),
(30, 1, 22, 'Tenencia', '2021-03-30', '2022-01-01', 0, 'ALTA DE PLACAS 2021', 'pdf/vehiculosdoc/L14BHN.jpeg', NULL, '2021-04-22 20:52:05'),
(31, 1, 23, 'Tenencia', '2021-03-30', '2022-01-01', 0, 'REFRENDO 2021', 'pdf/vehiculosdoc/T 2021 P47BFX.pdf', NULL, '2021-04-22 20:57:31'),
(32, 1, 21, 'Tenencia', '2021-03-30', '2022-01-01', 0, 'REFRENDO 2021', 'pdf/vehiculosdoc/T 2021 MXG1288.pdf', 22, '2021-04-22 20:58:33'),
(33, 3, 22, 'Verificación', '2021-04-19', '2021-10-15', 0, 'VERIFICACION PRIMER SEMETRE 2021 SIGUIENTE EN OCTUBRE 2021', 'pdf/vehiculosdoc/VERIFICACION 1 SEMESTRE L14BHN.jpeg', NULL, '2021-04-22 21:11:05'),
(34, 2, 10, 'Póliza de Seguro ', '2019-09-16', '2021-10-01', 0, 'POLIZA HILUX EN ARRENDAMIENTO TOYOTA UNIVERSIDAD', 'pdf/vehiculosdoc/POLIZA W97BED HILUX.jpeg', NULL, '2021-04-23 16:14:26'),
(35, 2, 13, 'Póliza de Seguro ', '2020-06-05', '2021-06-05', 0, 'PRIMER POLIZA', 'pdf/vehiculosdoc/POLIZA FORD 2017.pdf', NULL, '2021-04-23 17:01:37'),
(36, 2, 3, 'Póliza de Seguro ', '2020-10-14', '2021-10-14', 0, 'RENOVACION DE POLIZA', 'pdf/vehiculosdoc/POLIZA SS0303E HILUX 2016.pdf', NULL, '2021-04-23 17:06:14'),
(37, 2, 5, 'Póliza de Seguro ', '2020-12-27', '2021-12-27', 0, 'RENOVACION', 'pdf/vehiculosdoc/Doble cabina 2013 Hilux.pdf', NULL, '2021-04-23 19:26:04'),
(39, 2, 12, 'Póliza de Seguro ', '2020-08-17', '2021-08-17', 0, 'RENOVACION DE POLIZA', 'pdf/vehiculosdoc/RENOVACION POLIZA MRJ9237.pdf', NULL, '2021-04-23 20:24:50'),
(40, 2, 17, 'Póliza de Seguro ', '2019-09-16', '2021-10-01', 0, 'crédito finaliza 30/09/2021 renovar poliza', 'pdf/vehiculosdoc/POLIZA HILUX L0002138.jpeg', NULL, '2021-04-23 22:09:30'),
(41, 2, 9, 'Póliza de Seguro ', '2020-11-05', '2021-11-05', 0, 'RENOVACION', 'pdf/vehiculosdoc/POLIZA NP300.jpeg', NULL, '2021-04-24 14:55:52'),
(42, 2, 21, 'Póliza de Seguro ', '2020-06-27', '2021-06-27', 0, 'RENOVACION', 'pdf/vehiculosdoc/POLIZA VENTO.jpeg', NULL, '2021-05-10 20:45:08'),
(43, 5, 15, 'Permiso SCT', '2020-01-01', '2021-12-01', 0, 'PERMISO VIGENTE', 'pdf/vehiculosdoc/permiso camion 2018.jpeg', NULL, '2021-04-26 23:27:28'),
(44, 3, 14, 'Verificación', '2020-01-20', '2021-05-01', 0, 'VERIFICA MAYO JUNIO 2021', 'pdf/vehiculosdoc/VERIFICACION CAMION 2020 .jpeg', NULL, '2021-04-27 17:49:59'),
(45, 3, 15, 'Verificación', '2021-04-21', '2021-09-01', 0, 'VERIFICA SEPTIEMBRE OCTUBRE 2021', 'pdf/vehiculosdoc/VERIFICACION CAMION 2018.jpeg', NULL, '2021-04-27 17:53:18'),
(47, 1, 16, 'Tenencia', '2021-03-30', '2022-01-01', 0, 'REFRENDO', 'pdf/vehiculosdoc/TENENCIA LE2119 FORD 2013.jpeg', NULL, '2021-04-27 19:48:25'),
(48, 3, 16, 'Verificación', '2020-01-20', '2021-05-01', 0, 'Verifica MAYO Y JUNIO 2021', 'pdf/vehiculosdoc/VERIFICACION F350 2003.jpeg', NULL, '2021-04-27 20:05:43'),
(49, 3, 13, 'Verificación', '2021-03-17', '2021-10-01', 0, 'VERIFICA OCTUBRE Y NOVIEMBRE 2021', 'pdf/vehiculosdoc/VERIFICACION F350 2017 - copia.jpeg', NULL, '2021-04-27 20:08:54'),
(51, 3, 3, 'Verificación', '2020-12-31', '2021-05-01', 0, 'PLACAS DE QUERETARO NO VERIFICAN, HACER VERIFICACION VOLUNTARIA EN MAYO-JUNIO EN CDMX PARA EVITAR MULTAS EN CDMX O ESTADO DE MEXICO', 'pdf/vehiculosdoc/VERIFICACIÓN SS0303 QUERETARO HILYX GRIS.png', NULL, '2021-04-27 20:14:59'),
(52, 3, 17, 'Verificación', '2019-10-29', '2022-01-15', 0, 'FECHA LIMITE PARA VERIFICAR 28/02/2022', 'pdf/vehiculosdoc/W76 BED VERIFICACION.jpeg', NULL, '2021-04-27 20:17:01'),
(53, 3, 10, 'Verificación', '2019-11-08', '2021-09-01', 0, 'VERIFICAR EN SEPTIEMBRE 2021', 'pdf/vehiculosdoc/W97BED VERIFICACION.jpeg', NULL, '2021-04-27 20:20:14'),
(54, 3, 6, 'Verificación', '2019-04-24', '2021-08-01', 0, 'VERIFICAR EN AGOSTO 2021', 'pdf/vehiculosdoc/U45 BBL VERIFICACION.jpeg', NULL, '2021-04-27 20:22:59'),
(55, 3, 4, 'Verificación', '2019-11-19', '2021-11-01', 0, 'VERIFICAR EN NOVIEMBRE 2021', 'pdf/vehiculosdoc/W72BED VERIFICACION.jpeg', NULL, '2021-04-27 20:24:37'),
(56, 3, 7, 'Verificación', '2019-07-25', '2021-09-01', 0, 'VERIFICAR EN SEPTIEMBRE 2021', 'pdf/vehiculosdoc/U08BCY VERIFICACION.jpeg', NULL, '2021-04-27 20:27:11'),
(57, 3, 23, 'Verificación', '2020-01-01', '2021-06-30', 0, 'PERDIDA TOTAL EN CHIHUAHUA / NO VERIFICA ', 'pdf/vehiculosdoc/VERIFICACION P47BF.png', NULL, '2021-04-27 20:32:54'),
(58, 3, 21, 'Verificación', '2021-05-01', '2021-08-01', 0, 'REALIZAR REEMPLACAMIENTO EN ESTADO DE MEXICO MAYO 2021', 'pdf/vehiculosdoc/VERIFICACION VENTO.jpeg', NULL, '2021-05-10 20:42:57'),
(59, 2, 1, 'Póliza de Seguro ', '2020-06-19', '2021-07-01', 0, 'RENOVACION', 'pdf/vehiculosdoc/POLIZA TUCSON.pdf', NULL, '2021-04-27 21:37:25'),
(60, 2, 8, 'Póliza de Seguro ', '2020-06-16', '2022-07-01', 0, 'EN CREDITO', 'pdf/vehiculosdoc/POLIZA HILUX L1410758.jpeg', NULL, '2021-04-27 21:40:53'),
(61, 2, 22, 'Póliza de Seguro ', '2021-03-17', '2024-03-16', 0, 'PRIMER POLIZA CREDITO TOYOTA VALLEJO', 'pdf/vehiculosdoc/POLIZA HILUX 2021.jpeg', NULL, '2021-05-11 14:41:45'),
(62, 2, 2, 'Póliza de Seguro ', '2018-06-01', '2021-06-01', 0, 'RENOVAR POLIZA FIN DE CREDITO JUNIO 2021', 'pdf/vehiculosdoc/POLIZA DOBLE CABINA F15AWY.pdf', NULL, '2021-04-27 22:14:57'),
(63, 3, 2, 'Verificación', '2021-02-26', '2021-08-01', 0, 'VERIFICAR EN AGOSTO 2021', 'pdf/vehiculosdoc/VERIFICACION F15AWY ING JAVIER.jpeg', NULL, '2021-04-27 22:17:22'),
(64, 3, 18, 'Verificación', '2021-04-28', '2022-10-01', 0, 'VERIFICA EN OCTUBRE 2021', 'pdf/vehiculosdoc/verificacion estaquitas 2011.jpeg', NULL, '2021-04-28 22:15:57'),
(65, 2, 7, 'Póliza de Seguro ', '2020-07-04', '2021-07-04', 0, 'VIGENTE', 'pdf/vehiculosdoc/POLIZA U08BCY.jpeg', NULL, '2021-05-04 19:44:11'),
(66, 2, 14, 'Póliza de Seguro ', '2021-05-05', '2022-05-05', 0, 'RENOVACION GRUPO ORDAZ', 'pdf/vehiculosdoc/POLIZA CAMION 2020.pdf', NULL, '2021-05-04 21:48:00'),
(67, 6, 21, 'Placas', '2021-01-01', '2021-05-31', 0, 'REALIZAR RENOVACION DE PLACAS EN MAYIO 2021', 'pdf/vehiculosdoc/PACAS VENTO.png', NULL, '2021-05-10 20:28:09'),
(68, 3, 20, 'Verificación', '11-05-2021', '2021-08-01', 0, 'VERIFICAR EN AGOSTO SEPTIEMBRE 2021', 'pdf/vehiculosdoc/VERIFICACION RAM NKZ8185.jpeg', NULL, '2021-05-11 21:37:51'),
(69, 3, 19, 'Verificación', '11-05-2021', '2021-11-01', 0, 'VERIFICACION VOLUNTARIA CDMX, HACER CAMBIO DE PROPIETARIO', 'pdf/vehiculosdoc/VERIFICACIÓN SS0303 QUERETARO HILYX GRIS.png', NULL, '2021-05-11 22:02:18'),
(70, 2, 18, 'Póliza de Seguro ', '14-05-2021', '2021-08-05', 0, 'RENOVACION', 'pdf/vehiculosdoc/uv7761320000015705aa.pdf', NULL, '2021-05-14 20:49:39'),
(71, 2, 6, 'Póliza de Seguro ', '18-05-2021', '2021-05-16', 0, 'RENOVAR POLIZA POR FIN DE CREDITO', 'pdf/vehiculosdoc/POLIZA U45BBL.jpeg', NULL, '2021-05-18 18:05:46'),
(72, 2, 4, 'Póliza de Seguro ', '18-05-2021', '2021-09-20', 0, 'CREDITO TOYOTA UNIVERSIDAD', 'pdf/vehiculosdoc/SEGURO HILUX MR0EX8CB6L1408063.pdf', NULL, '2021-05-18 21:36:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos_grupo`
--

CREATE TABLE `vehiculos_grupo` (
  `id_grupo` int(11) NOT NULL,
  `nombre` varchar(90) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `vehiculos_grupo`
--

INSERT INTO `vehiculos_grupo` (`id_grupo`, `nombre`, `created_at`) VALUES
(1, 'Dirección', '2021-03-02 17:38:48'),
(2, 'Residentes', '2021-03-02 17:39:31'),
(3, 'Logistica', '2021-03-03 00:22:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos_incidentes`
--

CREATE TABLE `vehiculos_incidentes` (
  `id_incidente` int(11) NOT NULL,
  `status_veh` int(11) DEFAULT '0',
  `nombre_incidente` varchar(100) DEFAULT NULL,
  `id_vehiculo` int(11) DEFAULT '0',
  `id_personal` int(11) DEFAULT '0',
  `status_incidente` int(11) DEFAULT '0',
  `imagen_veh` varchar(200) DEFAULT NULL,
  `imagen_incidente` varchar(200) DEFAULT NULL,
  `accion` varchar(200) DEFAULT NULL,
  `costo` varchar(100) DEFAULT NULL,
  `fecha_incidente` varchar(100) DEFAULT NULL,
  `fecha_reparado` varchar(100) DEFAULT NULL,
  `comentarios` varchar(200) DEFAULT NULL,
  `id_sol` int(11) DEFAULT '0',
  `veh_rep` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `vehiculos_incidentes`
--

INSERT INTO `vehiculos_incidentes` (`id_incidente`, `status_veh`, `nombre_incidente`, `id_vehiculo`, `id_personal`, `status_incidente`, `imagen_veh`, `imagen_incidente`, `accion`, `costo`, `fecha_incidente`, `fecha_reparado`, `comentarios`, `id_sol`, `veh_rep`, `created_at`) VALUES
(1, 1, 'ESTRIBO TRASERO DAÑADO', 6, 24, 1, 'img/vehiculos/incidentes/HILUX BCA CISNEROS.jpeg', 'img/vehiculos/incidentes/INCIDENTE CISNEROS.jpeg', 'VALUAR DAÑO', '2000.00', '2021-05-03', NULL, 'JORGE CISNEROS RESPONSABLE DEL 50% DEL DAÑO', 0, NULL, '2021-05-10 21:09:24'),
(2, 1, 'Calavera derecha rota, facia dañada', 4, 59, 1, 'img/vehiculos/incidentes/W72BED.jpeg', 'img/vehiculos/incidentes/incidente Guillermo.png', 'reparar fuera de la agencia costo en agencia  $7248.81', '7248.81', '2021-05-13', NULL, 'SE ESTA BUSCANDO LA PIEZA EN GENERICA YA QUE EN AGENCIA ES MUY CARA, NO SE HA LOCALIZADO YA QUE ES AÑO 2020 Y NO HAY TODAVIA EN EL MERCADO EXTERNO', 0, NULL, '2021-05-13 17:00:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos_manto`
--

CREATE TABLE `vehiculos_manto` (
  `id_manto` int(11) NOT NULL,
  `status_veh` int(11) DEFAULT '0',
  `id_vehiculo` int(11) DEFAULT '0',
  `tipo_manto` int(11) DEFAULT '0',
  `fecha_manto` varchar(45) DEFAULT NULL,
  `fecha_rep` varchar(90) DEFAULT NULL,
  `kilometraje` varchar(100) DEFAULT NULL,
  `servicio_realizado` varchar(250) DEFAULT NULL,
  `costo` varchar(95) DEFAULT NULL,
  `comprobante_servicio` varchar(90) DEFAULT NULL,
  `imagen_servicio` varchar(90) DEFAULT NULL,
  `id_sol` int(11) DEFAULT '0',
  `veh_rep` varchar(90) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `vehiculos_manto`
--

INSERT INTO `vehiculos_manto` (`id_manto`, `status_veh`, `id_vehiculo`, `tipo_manto`, `fecha_manto`, `fecha_rep`, `kilometraje`, `servicio_realizado`, `costo`, `comprobante_servicio`, `imagen_servicio`, `id_sol`, `veh_rep`, `created_at`) VALUES
(1, 0, 3, 2, '2021-04-15', '16-04-2021', '249.730', 'CAMBIO DE CLUTH REALIZADO EN CULIACAN', '8300.00', NULL, 'img/vehiculos/manto/TALLER HILUX CLUTCH.jpeg', 0, NULL, '2021-04-16 21:32:56'),
(2, 0, 4, 1, '2021-04-15', '16-04-2021', '68051', ' Mantenimiento Preventivo.', ' 3100', NULL, NULL, 24, 'img/vehiculos/manto/Mantenimiento Hilux W72BED.pdf', '2021-04-21 21:05:48'),
(3, 0, 8, 1, '2021-04-16', '17-04-2021', '17611', '1.- Cambio de aceite sintético\r\n2.- Cambio de filtro de aceite\r\n3.- Cambio de filtro de aire de motor\r\n4.- Cambio de filtro de gasolina\r\n5.- Lavado de inyectores\r\n6.- Cambio de bujías\r\n7.- Lavado de cuerpo de aceleración\r\n8.- Cambio de focos convenci', '3596.00', NULL, 'img/vehiculos/manto/Toyota Hilux servicio presupuesto.docx', 25, 'img/vehiculos/manto/mantenimiento Hilux T68HF.pdf', '2021-04-21 21:01:30'),
(4, 0, 22, 1, '2021-04-27', '03-05-2021', ' 00015', ' vehículo nuevo, colocar caballete a redilas programado para el martes 27 abril', ' 1115.00', NULL, 'img/vehiculos/manto/CARROCFERIAS HERNANDEZ.pdf', 0, NULL, '2021-05-03 17:50:14'),
(5, 1, 12, 1, '', NULL, ' 198755', ' ', ' 1.00', NULL, NULL, 0, NULL, '2021-05-03 17:56:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos_operadores`
--

CREATE TABLE `vehiculos_operadores` (
  `id` int(11) NOT NULL,
  `id_responsable` int(11) DEFAULT '0',
  `status_veh` int(11) DEFAULT '0',
  `fecha_asignacion` varchar(45) DEFAULT NULL,
  `fecha_entrega` varchar(45) DEFAULT NULL,
  `id_vehiculo` int(11) DEFAULT '0',
  `archivo` varchar(200) DEFAULT NULL,
  `archivo2` varchar(200) DEFAULT NULL,
  `tarjeta_efecticard` varchar(90) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `vehiculos_operadores`
--

INSERT INTO `vehiculos_operadores` (`id`, `id_responsable`, `status_veh`, `fecha_asignacion`, `fecha_entrega`, `id_vehiculo`, `archivo`, `archivo2`, `tarjeta_efecticard`, `created_at`) VALUES
(1, 30, 2, '01-04-2021', '07-05-2021', 3, NULL, NULL, '1100372', '2021-05-07 16:02:18'),
(2, 59, 2, '01-04-2021', '15-04-2021', 4, NULL, NULL, '1004374', '2021-04-15 22:24:02'),
(3, 24, 2, '01-04-2021', '10-05-2021', 6, NULL, NULL, '939844', '2021-05-10 21:04:02'),
(4, 95, 2, '01-04-2021', '19-04-2021', 18, NULL, NULL, '976375', '2021-04-19 19:35:10'),
(5, 35, 2, '01-04-2021', '01-04-2021', 7, NULL, NULL, '1142851', '2021-04-01 15:05:28'),
(6, 28, 1, '01-04-2021', NULL, 8, NULL, NULL, '797327', '2021-04-01 15:03:41'),
(7, 35, 2, '01-04-2021', '19-04-2021', 9, NULL, NULL, '1142851', '2021-04-19 19:42:30'),
(8, 115, 2, '01-04-2021', '16-04-2021', 7, NULL, NULL, NULL, '2021-04-16 18:02:30'),
(9, 33, 2, '01-04-2021', '26-04-2021', 10, NULL, NULL, '1004375', '2021-04-26 15:06:48'),
(10, 3, 2, '07-04-2021', '15-04-2021', 21, NULL, NULL, '877124', '2021-04-15 22:38:21'),
(11, 95, 2, '08-04-2021', '03-05-2021', 12, NULL, NULL, '976375', '2021-05-03 17:50:39'),
(12, 21, 2, '16-04-2021', '19-04-2021', 15, NULL, NULL, NULL, '2021-04-19 14:17:00'),
(13, 28, 1, '17-04-2021', NULL, 8, NULL, NULL, '797327', '2021-04-17 16:21:16'),
(15, 59, 1, '19-04-2021', NULL, 4, NULL, NULL, '1004374', '2021-04-19 19:37:02'),
(17, 21, 2, '23-04-2021', '26-04-2021', 15, NULL, NULL, '1142852', '2021-04-26 14:45:03'),
(18, 27, 1, '23-04-2021', NULL, 5, NULL, NULL, '877124', '2021-04-23 19:25:04'),
(19, 30, 2, '23-04-2021', '07-05-2021', 3, NULL, NULL, '1100372', '2021-05-07 16:02:18'),
(20, 35, 1, '23-04-2021', NULL, 9, NULL, NULL, '1142851', '2021-04-23 21:12:48'),
(21, 21, 2, '26-04-2021', '03-05-2021', 10, NULL, NULL, '976375', '2021-05-03 18:01:05'),
(22, 177, 2, '27-04-2021', '10-05-2021', 21, NULL, NULL, '1005349', '2021-05-10 20:18:53'),
(23, 178, 2, '30-04-2021', '30-04-2021', 20, NULL, 'img/vehiculos/operadores/ram NKW8185 VIAJE TEMIXCO.pdf', NULL, '2021-04-30 21:19:57'),
(24, 95, 1, '03-05-2021', NULL, 10, NULL, NULL, '877125', '2021-05-03 18:01:26'),
(25, 9, 2, '03-05-2021', '03-05-2021', 14, 'img/vehiculos/operadores/SOLICITUD VIAJE TERMOELECTRICA.jpeg', NULL, '1160956', '2021-05-03 19:47:08'),
(26, 9, 2, '03-05-2021', '03-05-2021', 15, 'img/vehiculos/operadores/SOLICITUD VIAJE TERMOELECTRICA.jpeg', NULL, '1160956', '2021-05-03 20:17:32'),
(27, 33, 1, '04-05-2021', NULL, 7, NULL, NULL, '1100372', '2021-05-04 19:38:09'),
(28, 21, 2, '07-05-2021', '08-05-2021', 15, NULL, NULL, '976375', '2021-05-08 15:42:43'),
(29, 21, 2, '08-05-2021', '11-05-2021', 15, 'img/vehiculos/operadores/Viaje OCTAVIO sitio Mandarinas.jpeg', NULL, '976375', '2021-05-11 15:02:15'),
(30, 9, 2, '08-05-2021', '11-05-2021', 14, 'img/vehiculos/operadores/viaje Eduardo Sitio Mandarinas.jpeg', NULL, '1142852', '2021-05-11 15:02:03'),
(31, 58, 2, '10-05-2021', '10-05-2021', 22, NULL, NULL, NULL, '2021-05-10 20:52:47'),
(32, 52, 2, '10-05-2021', '12-05-2021', 3, NULL, NULL, NULL, '2021-05-12 19:54:52'),
(33, 50, 2, '10-05-2021', '11-05-2021', 22, NULL, NULL, NULL, '2021-05-11 15:03:23'),
(34, 50, 1, '11-05-2021', NULL, 19, NULL, NULL, NULL, '2021-05-11 15:03:00'),
(35, 52, 2, '12-05-2021', '12-05-2021', 20, NULL, NULL, NULL, '2021-05-12 22:18:58'),
(36, 30, 2, '12-05-2021', '14-05-2021', 3, 'img/vehiculos/operadores/ENTREGA VEHICULO PABLO HILUX GRIS.jpeg', NULL, NULL, '2021-05-14 23:26:15'),
(37, 21, 2, '14-05-2021', '18-05-2021', 3, NULL, NULL, '976375', '2021-05-18 19:38:41'),
(38, 30, 1, '15-05-2021', NULL, 22, 'img/vehiculos/operadores/responsiva pablo.jpeg', NULL, NULL, '2021-05-15 17:30:57'),
(39, 21, 2, '18-05-2021', '19-05-2021', 14, NULL, NULL, '976375', '2021-05-19 18:34:05'),
(40, 9, 2, '18-05-2021', '19-05-2021', 15, NULL, NULL, '1142852', '2021-05-19 18:33:36'),
(41, 50, 1, '18-05-2021', NULL, 3, NULL, NULL, NULL, '2021-05-18 19:38:56'),
(42, 184, 1, '19-05-2021', NULL, 18, NULL, NULL, NULL, '2021-05-19 15:25:59'),
(43, 21, 1, '19-05-2021', NULL, 17, NULL, NULL, '976375', '2021-05-19 18:32:25'),
(44, 9, 1, '19-05-2021', NULL, 14, NULL, NULL, '1142852', '2021-05-19 18:34:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos_pagos`
--

CREATE TABLE `vehiculos_pagos` (
  `id` int(11) NOT NULL,
  `id_solicitud` int(11) DEFAULT '0',
  `fecha_pago` varchar(100) DEFAULT NULL,
  `user_pago` varchar(100) DEFAULT NULL,
  `comprobante_pago` varchar(200) DEFAULT NULL,
  `monto` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `vehiculos_pagos`
--

INSERT INTO `vehiculos_pagos` (`id`, `id_solicitud`, `fecha_pago`, `user_pago`, `comprobante_pago`, `monto`, `created_at`) VALUES
(1, 23, '15-04-2021', 'Yasmin Garcia', 'pdf/sol_vehiculos/PAGO SERGIO ARAGON (SERVICIO HILUX SS0303E) 150421.pdf', '8300', '2021-04-15 20:18:41'),
(2, 25, '16-04-2021', 'Yasmin Garcia', 'pdf/sol_vehiculos/PAGO VIDAL GOMEZ (SERVICIO HILUX 2020 T68BHF) 160421.pdf', '3596', '2021-04-16 15:19:03'),
(3, 24, '16-04-2021', 'Yasmin Garcia', 'pdf/sol_vehiculos/PAGO VIDAL GOMEZ (SERVICIO HILUX 2020 W72BED) 160421.pdf', '3596', '2021-04-16 15:25:01'),
(4, 13, '17-04-2021', 'Yasmin Garcia', 'pdf/sol_vehiculos/T 2021 W97BED.pdf', '1205', '2021-04-17 18:42:55'),
(5, 7, '19-04-2021', 'Yasmin Garcia', 'pdf/sol_vehiculos/T 2021 W72BED.pdf', '1205', '2021-04-19 16:54:15'),
(6, 17, '19-04-2021', 'Yasmin Garcia', 'pdf/sol_vehiculos/T 2021 A543AB.pdf', '3029', '2021-04-19 16:56:09'),
(7, 10, '19-04-2021', 'Yasmin Garcia', 'pdf/sol_vehiculos/T 2021 U08BCY.pdf', '1161', '2021-04-19 16:57:27'),
(8, 9, '19-04-2021', 'Yasmin Garcia', 'pdf/sol_vehiculos/T 2021 U45BBL.pdf', '1161', '2021-04-19 16:59:04'),
(9, 6, '19-04-2021', 'Yasmin Garcia', 'pdf/sol_vehiculos/T 2021 SS0303E.pdf', '1062', '2021-04-19 17:00:13'),
(10, 14, '19-04-2021', 'Yasmin Garcia', 'pdf/sol_vehiculos/T 2021 MRJ9237.pdf', '921', '2021-04-19 17:01:18'),
(11, 8, '19-04-2021', 'Yasmin Garcia', 'pdf/sol_vehiculos/T 2021 NCZ7230.pdf', '700', '2021-04-19 17:02:30'),
(12, 16, '19-04-2021', 'Yasmin Garcia', 'pdf/sol_vehiculos/T 2021 LD48340.pdf', '5465', '2021-04-19 17:03:56'),
(13, 5, '19-04-2021', 'Yasmin Garcia', 'pdf/sol_vehiculos/T 2021 F15AWY.pdf', '1547', '2021-04-19 17:04:48'),
(14, 11, '19-04-2021', 'Yasmin Garcia', 'pdf/sol_vehiculos/T 2021 T68BHF.pdf', '1230', '2021-04-19 17:13:00'),
(15, 12, '19-04-2021', 'Yasmin Garcia', 'pdf/sol_vehiculos/T 2021 T25ASL.pdf', '1124', '2021-04-19 17:14:22'),
(16, 22, '19-04-2021', 'Yasmin Garcia', 'pdf/sol_vehiculos/T 2021 MXG1288.pdf', '2167', '2021-04-19 17:15:51'),
(17, 18, '19-04-2021', 'Yasmin Garcia', 'pdf/sol_vehiculos/T 2021 W76BED.pdf', '1319', '2021-04-19 17:18:27'),
(18, 20, '19-04-2021', 'Yasmin Garcia', 'pdf/sol_vehiculos/T 2021 SY4029A.pdf', '1077', '2021-04-19 17:20:09'),
(19, 21, '19-04-2021', 'Yasmin Garcia', 'pdf/sol_vehiculos/T 2021 NKW8185.pdf', '1094', '2021-04-19 17:21:08'),
(20, 19, '19-04-2021', 'Yasmin Garcia', 'pdf/sol_vehiculos/T 2021 974ZXV.pdf', '722', '2021-04-19 17:22:13'),
(21, 15, '19-04-2021', 'Yasmin Garcia', 'pdf/sol_vehiculos/T 2021 NZ1052A.pdf', '583', '2021-04-19 17:50:49'),
(22, 36, '17-05-2021', 'Yasmin Garcia', 'pdf/sol_vehiculos/PAGO EFECTIVALE PEDIDO COMBUSTIBLE 170521.pdf', '47088', '2021-05-17 17:10:22'),
(23, 34, '17-05-2021', 'Yasmin Garcia', 'pdf/sol_vehiculos/PAGO QUALITAS POL ESTAQUITAS 2018 140521.jpeg', '7825.02', '2021-05-17 20:51:04'),
(24, 35, '19-05-2021', 'Yasmin Garcia', 'pdf/sol_vehiculos/PAGO 11 MULTAS TUCSON 170521 Y 2 DEL 190521.pdf', '5656', '2021-05-19 20:55:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos_solicitudes`
--

CREATE TABLE `vehiculos_solicitudes` (
  `id` int(11) NOT NULL,
  `id_responsable` int(11) DEFAULT '0',
  `id_usuario` int(11) DEFAULT '0',
  `id_vehiculo` int(11) DEFAULT '0',
  `id_servicios` int(11) DEFAULT '0',
  `id_sitio` int(11) DEFAULT '0',
  `referencia` varchar(100) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT '0',
  `status_solicitud` int(11) DEFAULT '0',
  `step_veh` int(11) DEFAULT '0',
  `fecha_sol` varchar(90) DEFAULT NULL,
  `fecha_pagada` varchar(100) DEFAULT NULL,
  `facturable` int(11) DEFAULT '0',
  `monto` varchar(90) DEFAULT NULL,
  `iva` varchar(90) DEFAULT NULL,
  `total` varchar(90) DEFAULT NULL,
  `motivos` varchar(200) DEFAULT NULL,
  `datouno` varchar(200) DEFAULT NULL,
  `statusuno` int(11) DEFAULT '0',
  `tipouno` int(11) DEFAULT '0',
  `datodos` varchar(200) DEFAULT NULL,
  `statusdos` int(11) DEFAULT '0',
  `tipodos` int(11) DEFAULT '0',
  `datotres` varchar(200) DEFAULT NULL,
  `statustres` int(11) DEFAULT '0',
  `tipotres` int(11) DEFAULT '0',
  `datocuatro` varchar(200) DEFAULT NULL,
  `statuscuatro` int(11) DEFAULT '0',
  `tipocuatro` int(11) DEFAULT '0',
  `datocinco` varchar(200) DEFAULT NULL,
  `statuscinco` int(11) DEFAULT '0',
  `tipocinco` int(11) DEFAULT '0',
  `datoseis` varchar(200) DEFAULT NULL,
  `statusseis` int(11) DEFAULT '0',
  `tiposeis` int(11) DEFAULT '0',
  `datosiete` varchar(200) DEFAULT NULL,
  `statussiete` int(11) DEFAULT '0',
  `tiposiete` int(11) DEFAULT '0',
  `user_pago` int(11) DEFAULT '0',
  `status_comprobante` int(11) DEFAULT '0',
  `user_val` int(11) DEFAULT '0',
  `fecha_validacion` varchar(45) DEFAULT NULL,
  `fecha_cancelacion` varchar(45) DEFAULT NULL,
  `motivo_rechazo` varchar(150) DEFAULT NULL,
  `fecha_creacion` varchar(100) DEFAULT NULL,
  `status_asignada` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `vehiculos_solicitudes`
--

INSERT INTO `vehiculos_solicitudes` (`id`, `id_responsable`, `id_usuario`, `id_vehiculo`, `id_servicios`, `id_sitio`, `referencia`, `id_proveedor`, `status_solicitud`, `step_veh`, `fecha_sol`, `fecha_pagada`, `facturable`, `monto`, `iva`, `total`, `motivos`, `datouno`, `statusuno`, `tipouno`, `datodos`, `statusdos`, `tipodos`, `datotres`, `statustres`, `tipotres`, `datocuatro`, `statuscuatro`, `tipocuatro`, `datocinco`, `statuscinco`, `tipocinco`, `datoseis`, `statusseis`, `tiposeis`, `datosiete`, `statussiete`, `tiposiete`, `user_pago`, `status_comprobante`, `user_val`, `fecha_validacion`, `fecha_cancelacion`, `motivo_rechazo`, `fecha_creacion`, `status_asignada`, `created_at`) VALUES
(1, 0, 31, 6, 10, 0, '84CXU45BBLWQJ253JAFAF', 234, 3, 1, '08/04/2021', NULL, 0, '1161.00', NULL, '1161.00', 'PAGO DE TENENCIA 2021', 'img/vehiculos/sevidencias/T 2021 U45BBL.pdf', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 0, 0, 14, '12-04-2021', '19-04-2021', 'Placas Duplicadas. ', '08-04-2021', 0, '2021-04-19 17:44:15'),
(2, 0, 31, 15, 1, 0, '', 40, 2, 1, '09/04/2021', NULL, 0, '9860.00', NULL, '9860.00', 'SERVICIO DE MANTENIMIENTO PREVENTIVO CAMBIO DE ACEITE, FILTROS, LIMPIEZA DEL SISTEMA DE COMBUSTION PLACAS A543AB', '226,806', 1, 2, 'Cambio de aceite 2.- Cambio de filtro de aceite 3.- Cambio de filtro de aire 4.- Cambio de filtro de gasolina 5.- Lavado de inyectores 6.- Cambio de bujías 7.- Lavado de cuerpo de aceleración 8.- Revi', 1, 2, 'img/vehiculos/sevidencias/_img_solicitud_ordencompra_HISTORICO MANTENIMIENTO CAMION 2018.xlsx', 1, 3, 'img/vehiculos/sevidencias/_img_solicitud_ordencompra_MANTENIMIENTO CAMION INTERNACIONAL 2018.pdf', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 0, 0, 47, NULL, '21-04-2021', 'Por que el servicio no es facturable? Pf Adjuntar cotización del servicio en la agencia.\n', '09-04-2021', 0, '2021-04-22 03:44:12'),
(3, 0, 31, 7, 1, 0, '', 40, 2, 1, '09/04/2021', NULL, 0, '3596.00', NULL, '3596.00', 'PREVENTIVO POR KILOMETRAJE RECORRIDO', '94,271', 1, 2, '1.- Cambio de aceite  2.- Cambio de filtro de aceite 3.- Cambio de filtro de aire 4.- Cambio de filtro de gasolina 5.- Lavado de inyectores 6.- Cambio de bujías 7.- Lavado de cuerpo de aceleración 8.-', 1, 2, 'img/vehiculos/sevidencias/MANTENIMIENTO PREVENTIVO TOYOTA GRIS U08BCY.docx', 1, 3, 'img/vehiculos/sevidencias/172171f8-d836-4824-bab2-ed2215533104(706).pdf', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 0, 0, 47, NULL, '05-05-2021', 'corregir los montos. no esta separado el iva', '09-04-2021', 0, '2021-05-05 05:39:31'),
(4, 0, 31, 7, 1, 0, '', 40, 2, 1, '09/04/2021', NULL, 0, '1856.00', NULL, '1856.00', 'CAMBIO DE BALATAS DELANTERAS DESGASTADAS POR USO NORMAL', '94,271', 1, 2, 'CAMBIO DE BALATAS DELANTERAS, LIMPIEZA Y AJUSTE DE FRENOS', 1, 2, 'img/vehiculos/sevidencias/MANTENIMIENTO FRENOS TOYOTA U08BCY.docx', 1, 3, 'img/vehiculos/sevidencias/MANTENIMIENTO FRENOS TOYOTA U08BCY.docx', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 0, 0, 47, NULL, '05-05-2021', 'corregir montos, no esta separado el iva', '09-04-2021', 0, '2021-05-05 05:40:29'),
(5, 0, 31, 2, 10, 0, '841118XXF15AWY253RE6H', 234, 1, 1, '09/04/2021', '19-04-2021', 0, '1547.00', NULL, '1547.00', 'PAGO DE TENENCIA 2021', 'img/vehiculos/sevidencias/T 2021 F15AWY.pdf', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 32, 1, 14, '12-04-2021', NULL, NULL, '09-04-2021', 1, '2021-04-22 20:23:29'),
(6, 0, 31, 3, 10, 0, '002159516820210316', 236, 1, 1, '09/04/2021', '19-04-2021', 0, '1062.00', NULL, '1062.00', 'PAGO DE TENENCIA 2021', 'img/vehiculos/sevidencias/T 2021 SS0303E.pdf', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 32, 1, 14, '12-04-2021', NULL, NULL, '09-04-2021', 1, '2021-04-19 17:00:13'),
(7, 0, 31, 4, 10, 0, '84120XXW72BED253C2UT', 234, 1, 1, '09/04/2021', '19-04-2021', 0, '1205.00', NULL, '1205.00', 'PAGO DE TENENCIA 2021', 'img/vehiculos/sevidencias/T 2021 W72BED.pdf', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 32, 1, 14, '19-04-2021', NULL, NULL, '09-04-2021', 1, '2021-04-22 20:22:19'),
(8, 0, 31, 5, 10, 0, '102002000018545561211', 236, 1, 1, '09/04/2021', '19-04-2021', 0, '700.00', NULL, '700.00', 'PAGO DE TENENCIA 2021', 'img/vehiculos/sevidencias/T 2021 NCZ7230.pdf', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 32, 1, 14, '12-04-2021', NULL, NULL, '09-04-2021', 1, '2021-04-22 20:29:22'),
(9, 0, 31, 6, 10, 0, '84cxu45BBLWQJ253AFAF', 234, 1, 1, '09/04/2021', '19-04-2021', 0, '1161.00', NULL, '1161.00', 'PAGO DE TENENCIA 2021', 'img/vehiculos/sevidencias/T 2021 U45BBL.pdf', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 32, 1, 14, '12-04-2021', NULL, NULL, '09-04-2021', 1, '2021-04-22 20:20:04'),
(10, 0, 31, 7, 10, 0, '84CXU08BCYVXZ253AFVV', 234, 1, 1, '09/04/2021', '19-04-2021', 0, '1161.00', NULL, '1161.00', 'PAGO DE TENENCIA 2021', 'img/vehiculos/sevidencias/T 2021 U08BCY.pdf', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 32, 1, 14, '12-04-2021', NULL, NULL, '09-04-2021', 1, '2021-04-22 20:27:12'),
(11, 0, 31, 8, 10, 0, 'T68BHF', 234, 1, 1, '09/04/2021', '19-04-2021', 0, '1230.00', NULL, '1230.00', 'PAGO DE TENENCIA 2021 REFERENCIA PAGO DE TENENCIA 2021', 'img/vehiculos/sevidencias/T 2021 T68BHF.pdf', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 32, 1, 14, '19-04-2021', NULL, NULL, '09-04-2021', 1, '2021-04-22 20:18:55'),
(12, 0, 31, 9, 10, 0, '84CTX25ASL5S62539826', 234, 1, 1, '09/04/2021', '19-04-2021', 0, '1124.00', NULL, '1124.00', 'PAGO DE TENENCIA 2021', 'img/vehiculos/sevidencias/T 2021 T25ASL.pdf', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 32, 1, 14, '19-04-2021', NULL, NULL, '09-04-2021', 1, '2021-04-22 20:31:59'),
(13, 0, 31, 10, 10, 0, '84120XXW97BED253C20X', 234, 1, 1, '09/04/2021', '17-04-2021', 0, '1205.00', NULL, '1205.00', 'PAGO DE TENENCIA 2021', 'img/vehiculos/sevidencias/T 2021 W97BED.pdf', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 32, 1, 14, '12-04-2021', NULL, NULL, '09-04-2021', 1, '2021-04-22 20:17:59'),
(14, 0, 31, 12, 10, 0, '102002000018451088245562274', 236, 1, 1, '09/04/2021', '19-04-2021', 0, '921.00', NULL, '921.00', 'PAGO TENENCIA 2021', 'img/vehiculos/sevidencias/T 2021 MRJ9237.pdf', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 32, 1, 14, '12-04-2021', NULL, NULL, '09-04-2021', 1, '2021-04-22 20:24:30'),
(15, 0, 31, 13, 10, 0, '93000779297430684283', 236, 1, 1, '09/04/2021', '19-04-2021', 0, '583.00', NULL, '583.00', 'PAGO TENENCIA 2021', 'img/vehiculos/sevidencias/T 2021 NZ1052A.pdf', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 32, 1, 14, '12-04-2021', NULL, NULL, '09-04-2021', 1, '2021-04-22 20:09:28'),
(16, 0, 31, 14, 10, 0, '102002000018403033645564226', 236, 1, 1, '09/04/2021', '19-04-2021', 0, '5465.00', NULL, '5465.00', 'PAGO TENENCIA 2021', 'img/vehiculos/sevidencias/T 2021 LD48340.pdf', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 32, 1, 14, '12-04-2021', NULL, NULL, '10-04-2021', 1, '2021-04-22 19:19:04'),
(17, 0, 31, 15, 10, 0, '84CXA543AB2ZZ255CRA8', 234, 1, 1, '09/04/2021', '19-04-2021', 0, '3029.00', NULL, '3029.00', 'PAGO TENENCIA 2020', 'img/vehiculos/sevidencias/T 2021 A543AB.pdf', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 32, 1, 14, '12-04-2021', NULL, NULL, '10-04-2021', 1, '2021-04-22 19:20:27'),
(18, 0, 31, 17, 10, 0, '84120XXW76BED253FVXA', 234, 1, 1, '09/04/2021', '19-04-2021', 0, '1319.00', NULL, '1319.00', 'PAGO DE TENENCIA 2021', 'img/vehiculos/sevidencias/T 2021 W76BED.pdf', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 32, 1, 14, '19-04-2021', NULL, NULL, '10-04-2021', 1, '2021-04-22 20:15:12'),
(19, 0, 31, 18, 10, 0, '84111XX974ZXV252UYJB', 234, 1, 1, '09/04/2021', '19-04-2021', 0, '722.00', NULL, '722.00', 'PAGO DE TENENCIA 2021', 'img/vehiculos/sevidencias/T 2021 974ZXV.pdf', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 32, 1, 14, '12-04-2021', NULL, NULL, '10-04-2021', 1, '2021-04-22 20:30:58'),
(20, 0, 31, 19, 10, 0, '002159518420210316', 236, 1, 1, '09/04/2021', '19-04-2021', 0, '1077.00', NULL, '1077.00', 'PAGO DE TENENCIA 2021', 'img/vehiculos/sevidencias/T 2021 SY4029A.pdf', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 32, 1, 14, '12-04-2021', NULL, NULL, '10-04-2021', 1, '2021-04-22 20:41:45'),
(21, 0, 31, 20, 10, 0, '10200200001813350544', 236, 1, 1, '09/04/2021', '19-04-2021', 0, '1094.00', NULL, '1094.00', 'PAGO DE TENENCIA 2021', 'img/vehiculos/sevidencias/T 2021 NKW8185.pdf', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 32, 1, 14, '12-04-2021', NULL, NULL, '10-04-2021', 1, '2021-04-22 20:40:53'),
(22, 0, 31, 21, 10, 0, '10200200001845143614', 236, 1, 1, '09/04/2021', '19-04-2021', 0, '2167.00', NULL, '2167.00', 'PAGO DE TENENCIA 2021', 'img/vehiculos/sevidencias/T 2021 MXG1288.pdf', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 32, 1, 14, '12-04-2021', NULL, NULL, '10-04-2021', 1, '2021-04-22 20:58:33'),
(23, 0, 14, 3, 2, 0, '', 309, 1, 1, '14/04/2021', '15-04-2021', 0, '8300.00', NULL, '8300.00', 'Cambio de Clutch, aceite y rectificación del volante. ', '249435', 1, 2, 'Cambio de Clutch, Aceite y Rectificación de Volante. ', 1, 2, 'img/vehiculos/sevidencias/WhatsApp Image 2021-04-13 at 12.41.21 PM.jpeg', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 32, 1, 47, '14-04-2021', NULL, NULL, '14-04-2021', 0, '2021-04-15 22:26:55'),
(24, 0, 14, 4, 1, 0, 'Residente: Guillermo Arreola', 40, 1, 1, '15/04/2021', '16-04-2021', 1, '3100.00', '496.00', '3596.00', 'Servicio de Mantenimiento Preventivo. ', '68051', 1, 2, 'Detallado en Carta de Servicio. Se presentará reporte fotografico. ', 1, 2, 'img/vehiculos/sevidencias/Toyota Hilux servicio presupuesto.docx', 1, 3, 'img/vehiculos/sevidencias/Toyota Hilux servicio presupuesto.docx', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 32, 1, 47, '15-04-2021', NULL, NULL, '15-04-2021', 1, '2021-04-21 21:05:48'),
(25, 0, 14, 8, 1, 0, 'Residente: Juan Magaña.', 40, 1, 1, '15/04/2021', '16-04-2021', 1, '3100.00', '496.00', '3596.00', 'Servicio de Mantenimiento Preventivo.', '17306', 1, 2, 'Detallado en Carta de Servicio. Se presentará reporte fotografico. ', 1, 2, 'img/vehiculos/sevidencias/Toyota Hilux servicio presupuesto.docx', 1, 3, 'img/vehiculos/sevidencias/Toyota Hilux servicio presupuesto.docx', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 32, 1, 47, '15-04-2021', NULL, NULL, '15-04-2021', 1, '2021-04-21 21:01:30'),
(26, 0, 31, 8, 1, 0, '', 40, 2, 1, '16/04/2021', NULL, 1, '3100.00', '496.00', '3596.00', 'MANTENIMIENTO PREVENTIVO', '17611', 1, 2, '1.- Cambio de aceite sintético 2.- Cambio de filtro de aceite 3.- Cambio de filtro de aire de motor 4.- Cambio de filtro de gasolina 5.- Lavado de inyectores 6.- Cambio de bujías 7.- Lavado de cuerpo ', 1, 2, 'img/vehiculos/sevidencias/SERVICIO 160ABRIL 2021 TOYOTA HILUX 2020 PLACAS T68BHF.pdf', 1, 3, 'img/vehiculos/sevidencias/Toyota Hilux servicio presupuesto.docx', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 0, 0, 47, NULL, '21-04-2021', 'Adjuntar presupuesto de agencia. Revisar tema de garantía por kilométraje.', '17-04-2021', 0, '2021-04-22 03:41:04'),
(27, 0, 31, 4, 1, 0, '', 40, 2, 1, '16/04/2021', NULL, 1, '3100.00', '496.00', '3596.00', 'SERVICIO PREVENTIVO 68,278 KILOMETROS', '68,272', 1, 2, '1.- Cambio de aceite sintético 2.- Cambio de filtro de aceite 3.- Cambio de filtro de aire de motor 4.- Cambio de filtro de gasolina 5.- Lavado de inyectores 6.- Cambio de bujías 7.- Lavado de cuerpo ', 1, 2, 'img/vehiculos/sevidencias/SERVICIO TOYOTA HILUX 2020 PLACAS W72BED.pdf', 1, 3, 'img/vehiculos/sevidencias/Toyota Hilux servicio presupuesto.docx', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 0, 0, 14, NULL, '19-04-2021', 'Duplicada. Ya se habia pagado.', '17-04-2021', 0, '2021-04-19 21:15:09'),
(28, 0, 31, 7, 2, 0, '', 326, 1, 1, '22/04/2021', NULL, 1, '550.00', '88.00', '638.00', 'SE REQUIERE ALINEACION Y BALANCEO PARA CORREGIR VIBRACION DE VOLANTE', '94755', 1, 2, 'ALINEACION DELANTERA Y BALANCEO 4 LLANTAS', 1, 2, 'img/vehiculos/sevidencias/ALINEACION Y BALANCEO LLANTI AZCAPOTZALCO.png', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 0, 0, 47, '23-04-2021', NULL, NULL, '21-04-2021', 0, '2021-04-23 19:31:34'),
(29, 0, 31, 15, 2, 0, '', 326, 1, 1, '23/04/2021', NULL, 1, '330.00', '52.80', '382.80', 'MONTAJE DE 2 LLANTAS NUEVAS, USRTITUCION POR DESGASTE', '227461', 1, 2, 'MONTAJE DE 2 LLANTAS NUEVAS', 1, 2, 'img/vehiculos/sevidencias/MONTAJE LLANTA 11R22.5 CAMION 2019.png', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 0, 0, 47, '23-04-2021', NULL, NULL, '21-04-2021', 0, '2021-04-23 19:31:04'),
(30, 0, 31, 18, 3, 0, '03 INFRACCIONES $869 CAD,A UNA POR EXCESO DE VELOCIDAD EN 2020 EN LA CDMX', 234, 2, 1, '29/04/2021', NULL, 2, '2607.00', '', '2607.00', '03 INFRACCIONES POR EXCESO DE VELOCIDAD POR $869 CADA UNA', 'NINGUNO', 1, 2, 'img/vehiculos/sevidencias/03 INFRACCIONES ESTAQUITAS 2011 974ZXV.pdf', 1, 1, 'img/vehiculos/sevidencias/ESTACAS 2011.jpeg', 1, 1, 'Ninguno', 1, 2, 'INFRACCION', 1, 2, ' ', 0, 0, ' ', 0, 0, 0, 0, 47, NULL, '05-05-2021', 'no trae soporte adjunto', '30-04-2021', 0, '2021-05-05 05:41:17'),
(31, 0, 31, 9, 7, 0, 'PÓLIZA 3190282920 ENDOSO 000000 FECHA DE VENCIMIENTO 05/05/2021 NÚMERO CONTROL 0178463883', 10, 2, 1, '05/05/2021', NULL, 1, '6745.71', '1079.31', '7825.02', 'PÓLIZA 3190282920 ENDOSO 000000 FECHA DE VENCIMIENTO 05/05/2021 NÚMERO CONTROL 0178463883\r\nPAGO 2 POLIZA SEMESTRAL', 'img/vehiculos/sevidencias/Recibos Poliza 043190282920000000.pdf', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 0, 0, 47, NULL, '05-05-2021', 'cual es el periodo que cubre el pago? de que fecha a que fecha? no es clara la descripcion', '05-05-2021', 0, '2021-05-05 22:39:27'),
(32, 0, 56, 14, 1, 0, '', 300, 1, 1, '08/05/2021', NULL, 1, '991.38', '158.62', '1150.00', 'REPOSICION DE LODERAS, NO PORTARLAS ES INFRACCION', '32359', 1, 2, 'SUSTITUCION DE LODERAS', 1, 2, 'img/vehiculos/sevidencias/LODERAS CAMION 2020.png', 1, 3, 'img/vehiculos/sevidencias/LODERAS CAMION 2020.png', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 0, 0, 47, '08-05-2021', NULL, NULL, '08-05-2021', 0, '2021-05-08 16:19:53'),
(33, 0, 56, 15, 1, 0, '', 300, 1, 1, '08/05/2021', NULL, 1, '2241.37', '358.62', '2600.00', 'COMPRA DE ADITIVO PARA CAMION DIESEL DEF AZUL', '232690', 1, 2, 'ADITIVO PARA CAMION DIESEL DEF AZUL USO CONTINUO REQUERIDO', 1, 2, 'img/vehiculos/sevidencias/adituvo DEF camion 2018.png', 1, 3, 'img/vehiculos/sevidencias/adituvo DEF camion 2018.png', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 0, 0, 47, '08-05-2021', NULL, NULL, '08-05-2021', 0, '2021-05-08 16:18:54'),
(34, 0, 56, 9, 7, 0, '0178463833', 10, 1, 1, '12/05/2021', '17-05-2021', 1, '6745.71', '1079.31', '7825.02', 'Pago 2 de 2 de Póliza numero 3190282920 con forma de pago semestral, fecha de cobertura del segundo pago del 05/05/2021 al 05/11/2021 Numero de control 0178463883 \r\nVigencia de la póliza del 05/11/202', 'img/vehiculos/sevidencias/Recibos Poliza 043190282920000000.pdf', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 32, 1, 47, '14-05-2021', NULL, NULL, '12-05-2021', 0, '2021-05-17 20:51:04'),
(35, 0, 56, 1, 15, 0, '', 234, 1, 1, '17/05/2021', '19-05-2021', 2, '5510.00', '', '5510.00', 'PAGO DE 23 MULTAS POR EXCESO DE VELOCIDAD, SE PAGAN EN BANCO CON FORMATO MULTIPLE DE LA TESORERIA', 'img/vehiculos/sevidencias/multas camioneta Ing Ruben.rar', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 32, 1, 47, '15-05-2021', NULL, NULL, '15-05-2021', 0, '2021-05-19 20:55:58'),
(36, 0, 56, 0, 13, 0, '', 34, 1, 1, '17/05/2021', '17-05-2021', 1, '40593.10', '6494.90', '47088.00', 'ABONO SALDO EFECTICARD COMBUSTIBLE USO INTERNO', 'img/vehiculos/sevidencias/EFECTICARD PEDIDO 15 MAYO.png', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 32, 1, 47, '17-05-2021', NULL, NULL, '15-05-2021', 0, '2021-05-17 17:10:22'),
(37, 0, 56, 14, 9, 0, '', 234, 1, 1, '19/05/2021', NULL, 2, '772.00', '', '772.00', 'DERECHOS EN SCT PARA PERMISO CAMION INTERNACIONAL  AÑO 2020', 'img/vehiculos/sevidencias/HOJA DE AYUDA GERENCIA DE PROYECTOS 8128696 (2).pdf', 1, 1, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 0, 0, 47, '19-05-2021', NULL, NULL, '19-05-2021', 0, '2021-05-19 17:39:50'),
(38, 0, 56, 14, 9, 0, '', 234, 1, 1, '19/05/2021', NULL, 2, '1254.00', '', '1254.00', 'APROVECHAMIENTOS POR CONCEPTO DE PERMISO SCT PARA CAMION INTERNACIONAL AÑO 2020', 'img/vehiculos/sevidencias/HOJA DE AYUDA GERENCIA DE PROYECTOS 8128696 (1).pdf', 1, 1, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 0, 0, 47, '19-05-2021', NULL, NULL, '19-05-2021', 0, '2021-05-19 17:39:33'),
(39, 0, 56, 6, 1, 0, '', 380, 0, 1, '19/05/2021', NULL, 1, '1706.90', '273.10', '1980.00', 'SERVICIO POR JKILOMETRAJE RECORRIDO DE 100,000 KMS', '98539', 1, 2, 'Afinación con Bujías Platino (Incluye Filtros De Aire, Gasolina, Lavado De  Inyectores y Cuerpo De Aceleración, Escaneo y Mano De Obra)', 1, 2, 'img/vehiculos/sevidencias/SUPER SERVICIO POTRERO.pdf', 1, 3, 'img/vehiculos/sevidencias/SUPER SERVICIO POTRERO.pdf', 1, 3, ' ', 0, 0, ' ', 0, 0, ' ', 0, 0, 0, 0, 0, NULL, NULL, NULL, '19-05-2021', 0, '2021-05-19 17:56:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos_tpodoc`
--

CREATE TABLE `vehiculos_tpodoc` (
  `id` int(11) NOT NULL,
  `nombredoc` varchar(90) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `vehiculos_tpodoc`
--

INSERT INTO `vehiculos_tpodoc` (`id`, `nombredoc`, `created_at`) VALUES
(1, 'Tenencia', '2021-04-13 16:58:47'),
(2, 'Póliza de Seguro ', '2021-04-13 17:13:08'),
(3, 'Verificación', '2021-04-13 17:13:23'),
(4, 'Permiso ANTRA', '2021-04-13 17:13:47'),
(5, 'Permiso SCT', '2021-04-13 17:14:06'),
(6, 'Placas', '2021-05-10 20:18:21'),
(7, 'Tarjeta de Circulación', '2021-05-10 21:44:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo_servicios`
--

CREATE TABLE `vehiculo_servicios` (
  `id` int(11) NOT NULL,
  `nombre_servicio` varchar(90) DEFAULT NULL,
  `evidencia_uno` varchar(90) DEFAULT NULL,
  `status_uno` int(11) DEFAULT '0',
  `tipo_uno` int(11) DEFAULT '0',
  `evidencia_dos` varchar(90) DEFAULT NULL,
  `status_dos` int(11) DEFAULT '0',
  `tipo_dos` int(11) DEFAULT '0',
  `evidencia_tres` varchar(90) DEFAULT NULL,
  `status_tres` int(11) DEFAULT '0',
  `tipo_tres` int(11) DEFAULT '0',
  `evidencia_cuatro` varchar(90) DEFAULT NULL,
  `status_cuatro` int(11) DEFAULT '0',
  `tipo_cuatro` int(11) DEFAULT '0',
  `evidencia_cinco` varchar(90) DEFAULT NULL,
  `status_cinco` int(11) DEFAULT '0',
  `tipo_cinco` int(11) DEFAULT '0',
  `evidencia_seis` varchar(90) DEFAULT NULL,
  `status_seis` int(11) DEFAULT '0',
  `tipo_seis` int(11) DEFAULT '0',
  `evidencia_siete` varchar(90) DEFAULT NULL,
  `status_siete` int(11) DEFAULT '0',
  `tipo_siete` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `vehiculo_servicios`
--

INSERT INTO `vehiculo_servicios` (`id`, `nombre_servicio`, `evidencia_uno`, `status_uno`, `tipo_uno`, `evidencia_dos`, `status_dos`, `tipo_dos`, `evidencia_tres`, `status_tres`, `tipo_tres`, `evidencia_cuatro`, `status_cuatro`, `tipo_cuatro`, `evidencia_cinco`, `status_cinco`, `tipo_cinco`, `evidencia_seis`, `status_seis`, `tipo_seis`, `evidencia_siete`, `status_siete`, `tipo_siete`, `created_at`) VALUES
(1, 'Mantenimiento Preventivo', 'Kilometraje', 1, 2, 'Servicio detallados', 1, 2, 'Carta de Servicios', 1, 3, 'Cotización', 1, 3, '', 0, NULL, '', 0, NULL, '', 0, NULL, '2021-03-16 23:01:54'),
(2, 'Mantenimiento Correctivo', 'Kilometraje', 1, 2, 'Detalle de Actividades', 1, 2, 'Cotizacion', 1, 3, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '2021-03-16 23:03:06'),
(3, 'Incidente', 'Daño', 1, 2, 'Foto Daño', 1, 1, 'Foto Completa Vehiculo', 1, 1, 'Detalle Daño', 1, 2, 'Tipo Cobro', 1, 2, '', 0, NULL, '', 0, NULL, '2021-03-16 23:05:22'),
(4, 'Gestorias', 'Cotizacion', 1, 3, 'Tipo de Gestor', 1, 2, 'Descripcion de Gestoria', 1, 2, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '2021-03-16 23:06:49'),
(5, 'Verificación', 'Cotizacion', 1, 3, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '2021-03-16 23:08:29'),
(6, 'Cambio Placas', 'Foto Placas Actuales', 1, 1, 'Cotización', 1, 3, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '2021-03-16 23:10:35'),
(7, 'Póliza de Seguro ', 'Cotización', 1, 3, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '2021-03-16 23:11:55'),
(8, 'Permiso Antra', 'Captura Costo Derechos', 1, 1, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '2021-03-16 23:12:27'),
(9, 'Permiso SCT', 'Captura Costo Derechos', 1, 1, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '2021-03-16 23:13:12'),
(10, 'Tenencia', 'Linea de Captura', 1, 3, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '2021-04-12 16:29:49'),
(11, 'Renovación de Tarjeta de Circulación', 'Linea de Captura', 1, 3, 'Tarjeta Vencida', 1, 1, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '2021-05-10 21:52:32'),
(12, 'Anuncios Clasificados', 'Cotización', 1, 3, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '2021-05-10 23:06:13'),
(13, 'Combustible', 'Ultimas Cargas (5 semanas)', 1, 3, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '2021-05-10 23:07:57'),
(14, 'Carga Televia', 'Ultimas Cargas (5 semanas)', 1, 3, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '2021-05-10 23:08:30'),
(15, 'Multas de tránsito', 'Linea de Captura', 1, 3, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '2021-05-15 16:35:34'),
(16, 'Multa Por Verificación Extemporánea ', 'Linea de Captura', 1, 3, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '', 0, NULL, '2021-05-15 16:36:17');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`id_vehiculos`);

--
-- Indices de la tabla `vehiculos_documentacion`
--
ALTER TABLE `vehiculos_documentacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `vehiculos_grupo`
--
ALTER TABLE `vehiculos_grupo`
  ADD PRIMARY KEY (`id_grupo`);

--
-- Indices de la tabla `vehiculos_incidentes`
--
ALTER TABLE `vehiculos_incidentes`
  ADD PRIMARY KEY (`id_incidente`);

--
-- Indices de la tabla `vehiculos_manto`
--
ALTER TABLE `vehiculos_manto`
  ADD PRIMARY KEY (`id_manto`);

--
-- Indices de la tabla `vehiculos_operadores`
--
ALTER TABLE `vehiculos_operadores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `vehiculos_pagos`
--
ALTER TABLE `vehiculos_pagos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `vehiculos_solicitudes`
--
ALTER TABLE `vehiculos_solicitudes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `vehiculos_tpodoc`
--
ALTER TABLE `vehiculos_tpodoc`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `vehiculo_servicios`
--
ALTER TABLE `vehiculo_servicios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id_vehiculos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `vehiculos_documentacion`
--
ALTER TABLE `vehiculos_documentacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `vehiculos_grupo`
--
ALTER TABLE `vehiculos_grupo`
  MODIFY `id_grupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `vehiculos_incidentes`
--
ALTER TABLE `vehiculos_incidentes`
  MODIFY `id_incidente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `vehiculos_manto`
--
ALTER TABLE `vehiculos_manto`
  MODIFY `id_manto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `vehiculos_operadores`
--
ALTER TABLE `vehiculos_operadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `vehiculos_pagos`
--
ALTER TABLE `vehiculos_pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `vehiculos_solicitudes`
--
ALTER TABLE `vehiculos_solicitudes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `vehiculos_tpodoc`
--
ALTER TABLE `vehiculos_tpodoc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `vehiculo_servicios`
--
ALTER TABLE `vehiculo_servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
