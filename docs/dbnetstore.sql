-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-06-2018 a las 00:35:20
-- Versión del servidor: 10.1.29-MariaDB
-- Versión de PHP: 7.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbnetstore`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas`
--

CREATE TABLE `cuentas` (
  `id` int(11) NOT NULL,
  `nombrecuenta` varchar(45) NOT NULL,
  `ncuenta` varchar(20) NOT NULL,
  `vencemm` int(11) NOT NULL,
  `venceyy` int(11) NOT NULL,
  `fkusuario` int(11) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cuentas`
--

INSERT INTO `cuentas` (`id`, `nombrecuenta`, `ncuenta`, `vencemm`, `venceyy`, `fkusuario`, `created_at`) VALUES
(1, 'Joel 1', '4242424242424242', 2, 2020, 18, '2018-05-28 18:37:11.256385'),
(2, 'santarder', '4444444444444444', 4, 2020, 18, '2018-05-02 17:33:53.269238'),
(3, 'Master', '5555555555554444', 6, 2022, 18, '2018-05-28 18:37:11.345497'),
(4, 'Sin fondos', '4000000000000127', 5, 2025, 14, '2018-05-18 16:22:58.219211'),
(5, 'Declinada', '4000000000000002', 10, 2028, 14, '2018-05-18 16:27:29.435230'),
(6, 'Joel', '4242424242424242', 3, 2023, 19, '2018-05-24 20:31:15.965658');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE `direcciones` (
  `id` int(11) NOT NULL,
  `direccion` mediumtext NOT NULL,
  `fkusuario` int(11) NOT NULL,
  `cp` varchar(7) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `direcciones`
--

INSERT INTO `direcciones` (`id`, `direccion`, `fkusuario`, `cp`, `created_at`) VALUES
(19, 'asdasdasdasasdzwads, coyoacan', 18, '11111', '2018-05-25 18:28:13.396664'),
(20, 'Ave. insurgentes n° 225,Cuauhtémoc.', 19, '22222', '2018-05-25 18:28:13.474793'),
(21, 'coacalco,Coyoacán.', 14, '33333', '2018-05-25 18:28:13.474793'),
(22, 'Coacalco,Iztacalco.', 19, '55712', '2018-05-25 18:35:00.063300');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `flores`
--

CREATE TABLE `flores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `imagen` varchar(200) NOT NULL,
  `created_at` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `flores`
--

INSERT INTO `flores` (`id`, `nombre`, `imagen`, `created_at`) VALUES
(1, 'Orquidea', 'img/img_flower/orquidias.jpg', ''),
(2, 'Tulipanes', 'img/img_flower/tulipanes.jpg', ''),
(3, 'rosas rojas', 'img/img_flower/rosas.jpg', ''),
(4, 'rosas blancas', 'img/img_flower/rosas blancas.jpg', ''),
(5, 'Alcatraces', 'img/img_flower/alcatraces.jpg', ''),
(6, 'girasol', 'img/img_flower/girasol.jpg', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `floresxtemp`
--

CREATE TABLE `floresxtemp` (
  `id` int(11) NOT NULL,
  `fkflor` int(11) NOT NULL,
  `fktemporada` int(11) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `floresxtemp`
--

INSERT INTO `floresxtemp` (`id`, `fkflor`, `fktemporada`, `created_at`) VALUES
(16, 2, 3, '2018-04-09 16:51:37.333748');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden`
--

CREATE TABLE `orden` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `iddireccion` int(11) NOT NULL,
  `iscomplete` int(11) NOT NULL,
  `isrejected` int(11) NOT NULL,
  `isactive` int(11) NOT NULL,
  `create` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `orden`
--

INSERT INTO `orden` (`id`, `nombre`, `idusuario`, `iddireccion`, `iscomplete`, `isrejected`, `isactive`, `create`) VALUES
(54, 'Joel', 19, 20, 0, 0, 0, '2018-05-25 18:15:25.650313'),
(55, 'hola', 18, 19, 0, 0, 0, '2018-05-28 18:58:57.463264');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidosdireccion`
--

CREATE TABLE `pedidosdireccion` (
  `id` int(11) NOT NULL,
  `fechadeentrega` date NOT NULL,
  `horadeentrega` time NOT NULL,
  `fkdireccion` int(11) NOT NULL,
  `fkusuario` int(11) NOT NULL,
  `nombrerecibe` varchar(45) NOT NULL,
  `fkorden` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pedidosdireccion`
--

INSERT INTO `pedidosdireccion` (`id`, `fechadeentrega`, `horadeentrega`, `fkdireccion`, `fkusuario`, `nombrerecibe`, `fkorden`, `created_at`) VALUES
(1, '2018-05-03', '04:12:08', 19, 18, 'laura', 1, '2018-05-03 21:12:11.591389'),
(2, '2018-05-07', '05:55:52', 21, 14, 'joel', 1, '2018-05-07 22:55:53.870359'),
(3, '2018-05-24', '03:30:38', 20, 19, 'Joel', 1, '2018-05-24 20:30:40.046627'),
(4, '2018-05-24', '03:32:55', 20, 19, 'qwe', 1, '2018-05-24 20:32:56.822017'),
(5, '2018-05-25', '09:23:58', 20, 19, 'Joel', 1, '2018-05-25 14:23:59.691320'),
(6, '2018-05-25', '11:48:44', 20, 19, 'Joel', 1, '2018-05-25 16:48:46.722854'),
(7, '2018-05-25', '01:14:20', 20, 19, 'Joel', 1, '2018-05-25 18:14:21.440315'),
(8, '2018-05-28', '01:58:55', 19, 18, 'laura', 1, '2018-05-28 18:58:57.592934');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `imagen` varchar(200) NOT NULL,
  `descripcion` mediumtext NOT NULL,
  `stock` int(15) NOT NULL,
  `precio` int(11) NOT NULL,
  `ofer` varchar(3) NOT NULL DEFAULT '0',
  `timeofer` int(11) NOT NULL,
  `inicio` date NOT NULL,
  `final` date NOT NULL,
  `precioofer` int(11) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `imagen`, `descripcion`, `stock`, `precio`, `ofer`, `timeofer`, `inicio`, `final`, `precioofer`, `created_at`) VALUES
(22, 'Telefono 2000', 'img/img_pro/descarga (6).jpg', '<p>telefono con direccion ip</p>\r\n', 200, 600, '0', 23, '0000-00-00', '0000-00-00', 0, '2018-05-28 16:53:09.609974'),
(23, 'Telefono fax', 'img/img_pro/descarga.jpg', '<p>telefono ip con fax</p>\r\n', 200, 3500, '0', 23, '0000-00-00', '0000-00-00', 0, '2018-05-28 16:54:05.905370'),
(24, 'Switch 2500', 'img/img_pro/switch.jpg', '<p>sitch serie 2500&nbsp;</p>\r\n', 200, 12000, '0', 23, '0000-00-00', '0000-00-00', 0, '2018-05-28 17:15:58.453414'),
(25, 'Switch 800', 'img/img_pro/switch (1).jpg', '<p>switch serie 800 empresarial</p>\r\n', 200, 8000, '0', 23, '0000-00-00', '0000-00-00', 0, '2018-05-28 17:16:56.330303'),
(26, 'Router', 'img/img_pro/usb-hub.jpg', '<p>router usb</p>\r\n', 200, 8000, '0', 23, '0000-00-00', '0000-00-00', 0, '2018-05-28 17:24:24.931094'),
(27, 'Router 2500', 'img/img_pro/ups-apc-amazon.jpg', '<p>router empresarial serie 2500</p>\r\n', 199, 8000, '0', 23, '0000-00-00', '0000-00-00', 0, '2018-05-28 19:50:35.035291'),
(28, 'Camara IP cisco 1500', 'img/img_pro/descarga (1).jpg', '<p>camara ip cisco serie 1500 inalambrica</p>\r\n', 200, 8000, '0', 23, '0000-00-00', '0000-00-00', 0, '2018-05-28 17:30:00.456344'),
(29, 'Camara IP cisco 2500', 'img/img_pro/images.jpg', '<p>camara ip cisco serie 2500</p>\r\n', 200, 8000, '0', 23, '0000-00-00', '0000-00-00', 0, '2018-05-28 17:35:28.185331'),
(30, 'servidor empresarial', 'img/img_pro/images (1).jpg', '<p>servidor empresarias serie 23000</p>\r\n', 200, 50000, '0', 23, '0000-00-00', '0000-00-00', 0, '2018-05-28 17:36:24.833009'),
(31, 'servidor 5000', 'img/img_pro/images (2).jpg', '<p>servidores serie 5000 para cualquier uso empresarial o escolar</p>\r\n', 200, 69000, '0', 23, '0000-00-00', '0000-00-00', 0, '2018-05-28 17:38:25.680873'),
(32, 'firewall 13000', 'img/img_pro/1200px-Network_card.jpg', '<p>antena inalambreica serie 13000</p>\r\n', 200, 6000, '0', 23, '0000-00-00', '0000-00-00', 0, '2018-05-28 17:39:52.317279'),
(33, 'firewall 2500', 'img/img_pro/DLIN 1001000.jpg', '<p>firewall serie 2500</p>\r\n', 200, 6000, '0', 23, '0000-00-00', '0000-00-00', 0, '2018-05-28 17:40:40.894262');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productorecomendacion`
--

CREATE TABLE `productorecomendacion` (
  `id` int(11) NOT NULL,
  `fkpro` int(11) NOT NULL,
  `fkrecomendaciones` int(11) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productorecomendacion`
--

INSERT INTO `productorecomendacion` (`id`, `fkpro`, `fkrecomendaciones`, `created_at`) VALUES
(36, 22, 5, '2018-05-28 16:53:09.664048'),
(37, 23, 5, '2018-05-28 16:54:05.965038'),
(38, 24, 2, '2018-05-28 17:15:58.522091'),
(39, 25, 2, '2018-05-28 17:16:56.377426'),
(40, 26, 3, '2018-05-28 17:24:24.994758'),
(41, 27, 3, '2018-05-28 17:26:30.397403'),
(42, 28, 6, '2018-05-28 17:30:00.499454'),
(43, 29, 6, '2018-05-28 17:35:28.322156'),
(44, 30, 4, '2018-05-28 17:36:24.866605'),
(45, 31, 4, '2018-05-28 17:38:25.741041'),
(46, 32, 7, '2018-05-28 17:39:52.450894'),
(47, 33, 7, '2018-05-28 17:40:40.987176');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productosvendidos`
--

CREATE TABLE `productosvendidos` (
  `id` int(11) NOT NULL,
  `fkpro` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fkusuario` int(11) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_orden`
--

CREATE TABLE `producto_orden` (
  `id` int(11) NOT NULL,
  `fkpro` int(11) NOT NULL,
  `fkorden` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto_orden`
--

INSERT INTO `producto_orden` (`id`, `fkpro`, `fkorden`, `cantidad`, `created_at`) VALUES
(48, 27, 55, 1, '2018-05-28 19:50:34.868498');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recomendacion`
--

CREATE TABLE `recomendacion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` mediumtext NOT NULL,
  `imagen` varchar(200) NOT NULL,
  `ismain` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `recomendacion`
--

INSERT INTO `recomendacion` (`id`, `nombre`, `descripcion`, `imagen`, `ismain`, `created_at`) VALUES
(2, 'Switches', '', 'img/img_reco/descarga (1).jpg', 1, '2018-05-28 16:00:27.685965'),
(3, 'Routers', '', 'img/img_reco/descarga.jpg', 1, '2018-05-28 16:45:44.549107'),
(4, 'Servidores', '', 'img/img_reco/descarga (5).jpg', 1, '2018-05-28 16:45:44.552114'),
(5, 'Telefonia IP', '', 'img/img_reco/descarga (3).jpg', 0, '2018-05-28 16:46:00.870553'),
(6, 'Camaras IP', '', 'img/img_reco/descarga (4).jpg', 0, '2018-05-28 16:37:27.816724'),
(7, 'firewall', '', 'img/img_reco/descarga (2).jpg', 0, '2018-05-28 16:38:04.832217');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `created_at`) VALUES
(1, 'Administrador', '2018-04-04 21:55:42.644213'),
(2, 'Usuario', '2018-04-04 21:55:24.532373');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `slider`
--

CREATE TABLE `slider` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `imagen` varchar(200) NOT NULL,
  `fkpro` int(11) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarjetas`
--

CREATE TABLE `tarjetas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `imagen` varchar(200) NOT NULL,
  `descripcion` longtext NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tarjetas`
--

INSERT INTO `tarjetas` (`id`, `nombre`, `imagen`, `descripcion`, `created_at`) VALUES
(3, 'Tarjeta 1', 'img/img_tarjetas/images (3).jpg', '', '2018-04-26 21:49:25.936917'),
(4, 'tarjeta 2', 'img/img_tarjetas/eaf10f677b443ca2a47d26f30b4998a9.jpg', '', '2018-04-26 21:50:48.709352'),
(5, 'tarjeta 3', 'img/img_tarjetas/terrario-di-cactus-387208.jpg', '', '2018-04-26 21:48:50.955796'),
(6, 'unica', 'img/img_tarjetas/515.jpg', '', '2018-04-26 21:49:42.294929');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarpro`
--

CREATE TABLE `tarpro` (
  `id` int(11) NOT NULL,
  `fktarjeta` int(11) NOT NULL,
  `fkpro` int(11) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temporada`
--

CREATE TABLE `temporada` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` mediumtext NOT NULL,
  `fechainicial` date NOT NULL,
  `fechafinal` date NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `temporada`
--

INSERT INTO `temporada` (`id`, `nombre`, `descripcion`, `fechainicial`, `fechafinal`, `created_at`) VALUES
(3, 'Otoño', '<p>Estaci&oacute;n del a&ntilde;o comprendida entre el verano y el invierno; en el hemisferio norte, se sit&uacute;a aproximadamente entre el 21 de septiembre, equinoccio de oto&ntilde;o, y el 21 de diciembre, solsticio de invierno, y en el hemisferio sur entre el 21 de marzo y el 21 de junio.</p>\r\n\r\n<p><big><em>Las recomendaciones de esta temporada son:</em></big></p>\r\n\r\n<ul>\r\n	<li>orquideas</li>\r\n	<li>petunias</li>\r\n	<li>rosas</li>\r\n</ul>\r\n\r\n<h3><span class=\"marker\">No olvides visitar nuestas redes sociales pra obtener mas informacion de nuestros products y poder contactarnos en caso de que tengas alguna duda.</span></h3>\r\n', '2018-04-24', '2018-04-27', '2018-04-23 21:54:47.820307'),
(4, 'Invierno', '', '2018-04-02', '2018-04-24', '2018-04-23 21:55:23.484894');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temp_reco`
--

CREATE TABLE `temp_reco` (
  `id` int(11) NOT NULL,
  `fktempo` int(11) NOT NULL,
  `fkreco` int(11) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tokenusr`
--

CREATE TABLE `tokenusr` (
  `id` int(11) NOT NULL,
  `correo` varchar(200) NOT NULL,
  `token` varchar(60) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tokenusr`
--

INSERT INTO `tokenusr` (`id`, `correo`, `token`, `created_at`) VALUES
(12, 'ich-element@holi.com', 'c7endfdjwqf9rz5ial482syk7v3hg0fuam1b607opt16x5d1b', '2018-04-13 21:07:02.037541'),
(13, 'frank@ich-element.com', 'o4bry21j97v3f3c02zc6lqa0cgnds1mtike0a8wup7hx565d2', '2018-04-13 21:54:20.801844'),
(14, 'josue@hotmail.com', '1xw9jo41au4cmbh51d658kg7any2380r2b2d4vspfqize5tdl', '2018-04-16 14:24:17.155163'),
(15, 'josue@hotmail.com', 'hk4dsme4a89qyfw4ig5eu84a2t1d3j5p67zx5br0v09clenbo', '2018-04-16 14:51:10.016966'),
(16, 'ich-element@holi.com', 'n2ba5d9kcejewo350u7gx1d47zhf65pfdma0l4vbi8s8qyt1r', '2018-04-16 15:12:53.128487'),
(17, 'josue@hotmail.com', 'aciaf23gmpd4lfb9jv5dk66h06c45ud0nwa1szx9toeyqcr87', '2018-04-16 15:49:35.435412'),
(18, 'ich-element@holi.com', 'gam2dq28vkarct5scdilw51fhd53na64xoc30e68y9zubd7pj', '2018-04-17 20:28:03.836235'),
(19, 'frank@ich-element.com', '9g525pdulve94h69fzyjxft8615merbsk5cb16a7i0awoq3dn', '2018-04-17 20:29:18.762780'),
(20, 'josue@hotmail.com', 'hv2y5xbis6c33d8f5wjf0nad9kgddtp4ra816eoudqm75l9ze', '2018-04-17 20:29:49.919734');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `ap` varchar(45) NOT NULL,
  `am` varchar(45) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `telefono` varchar(25) NOT NULL,
  `correo` varchar(200) NOT NULL,
  `passw` varchar(512) NOT NULL,
  `fkroles` int(11) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `ap`, `am`, `direccion`, `telefono`, `correo`, `passw`, `fkroles`, `created_at`) VALUES
(14, 'Administrador', 'Admin', 'Admin', 'Toronto Valle Dorado', '23123123123', 'admin@ich-element.com', '263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62', 1, '2018-05-18 15:04:20.089787'),
(18, 'josue', 'asdasddsas', 'wefdsfdfsdfdf', 'sdfsdfsdfdsfsdfs', '5535362323', 'ich-element@holi.com', '263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62', 2, '2018-05-28 18:38:44.818801'),
(19, 'Joel', 'Garcia', 'Vazquez', 'coacalco', '5525724289', 'jack_kindap@hotmail.com', 'dd4bda2dae851bdc4b6d81e000bc1f52d2092828d9f1e741019b9120c5d53b7b60de4fbdd5f6e64a24b0dcd71ebd4083e2c6fb490e0eaea75d62fc83cce2cf38', 2, '2018-04-23 17:33:02.732972'),
(20, 'pepe', 'asdsdadd', 'asdasdasd', 'asdsdasdasdasdsadsadsa', '1234234234', 'pepe@hotmail.com', '263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62', 2, '2018-05-02 18:18:47.048148'),
(21, 'asdsdsad', 'asdasd', 'sddadsd', 'asdasdd', '21345', 'hola@hotmail.com', '263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62', 2, '2018-05-04 16:57:47.895570');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cu_us_idx` (`fkusuario`);

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dir_us_idx` (`fkusuario`);

--
-- Indices de la tabla `flores`
--
ALTER TABLE `flores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `floresxtemp`
--
ALTER TABLE `floresxtemp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_flores_ft_idx` (`fkflor`),
  ADD KEY `fk_temporada_ft_idx` (`fktemporada`);

--
-- Indices de la tabla `orden`
--
ALTER TABLE `orden`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkusuario_idx` (`idusuario`) USING BTREE,
  ADD KEY `fkdireccion_idx` (`iddireccion`) USING BTREE;

--
-- Indices de la tabla `pedidosdireccion`
--
ALTER TABLE `pedidosdireccion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pd_us_idx` (`fkusuario`),
  ADD KEY `fk_pd_dir_idx` (`fkdireccion`) USING BTREE;

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productorecomendacion`
--
ALTER TABLE `productorecomendacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pr_pro_idx` (`fkpro`),
  ADD KEY `fk_pr_rec_idx` (`fkrecomendaciones`);

--
-- Indices de la tabla `productosvendidos`
--
ALTER TABLE `productosvendidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pv_pro_idx` (`fkpro`),
  ADD KEY `fk_pv_us_idx` (`fkusuario`);

--
-- Indices de la tabla `producto_orden`
--
ALTER TABLE `producto_orden`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_po_pro_idx` (`fkpro`),
  ADD KEY `fk_po_or_idx` (`fkorden`);

--
-- Indices de la tabla `recomendacion`
--
ALTER TABLE `recomendacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indices de la tabla `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sl_pro_idx` (`fkpro`);

--
-- Indices de la tabla `tarjetas`
--
ALTER TABLE `tarjetas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tarpro`
--
ALTER TABLE `tarpro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tar_tp_idx` (`fktarjeta`),
  ADD KEY `fk_pro_tp_idx` (`fkpro`);

--
-- Indices de la tabla `temporada`
--
ALTER TABLE `temporada`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `temp_reco`
--
ALTER TABLE `temp_reco`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tempo_tr_idx` (`fktempo`),
  ADD KEY `fk_reco_tr_idx` (`fkreco`);

--
-- Indices de la tabla `tokenusr`
--
ALTER TABLE `tokenusr`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo_UNIQUE` (`correo`),
  ADD KEY `fk_rol_idx` (`fkroles`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `flores`
--
ALTER TABLE `flores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `floresxtemp`
--
ALTER TABLE `floresxtemp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `orden`
--
ALTER TABLE `orden`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `pedidosdireccion`
--
ALTER TABLE `pedidosdireccion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `productorecomendacion`
--
ALTER TABLE `productorecomendacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `productosvendidos`
--
ALTER TABLE `productosvendidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto_orden`
--
ALTER TABLE `producto_orden`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `recomendacion`
--
ALTER TABLE `recomendacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tarjetas`
--
ALTER TABLE `tarjetas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tarpro`
--
ALTER TABLE `tarpro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `temporada`
--
ALTER TABLE `temporada`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `temp_reco`
--
ALTER TABLE `temp_reco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tokenusr`
--
ALTER TABLE `tokenusr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cuentas`
--
ALTER TABLE `cuentas`
  ADD CONSTRAINT `fk_cu_us` FOREIGN KEY (`fkusuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD CONSTRAINT `fk_dir_us` FOREIGN KEY (`fkusuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `floresxtemp`
--
ALTER TABLE `floresxtemp`
  ADD CONSTRAINT `fk_flores_ft` FOREIGN KEY (`fkflor`) REFERENCES `flores` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_temporada_ft` FOREIGN KEY (`fktemporada`) REFERENCES `temporada` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `orden`
--
ALTER TABLE `orden`
  ADD CONSTRAINT `orden_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orden_ibfk_2` FOREIGN KEY (`iddireccion`) REFERENCES `direcciones` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedidosdireccion`
--
ALTER TABLE `pedidosdireccion`
  ADD CONSTRAINT `fk_pd_dir` FOREIGN KEY (`fkdireccion`) REFERENCES `direcciones` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pd_us` FOREIGN KEY (`fkusuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `productorecomendacion`
--
ALTER TABLE `productorecomendacion`
  ADD CONSTRAINT `fk_pr_pro` FOREIGN KEY (`fkpro`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pr_rec` FOREIGN KEY (`fkrecomendaciones`) REFERENCES `recomendacion` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `productosvendidos`
--
ALTER TABLE `productosvendidos`
  ADD CONSTRAINT `fk_pv_pro` FOREIGN KEY (`fkpro`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pv_us` FOREIGN KEY (`fkusuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `producto_orden`
--
ALTER TABLE `producto_orden`
  ADD CONSTRAINT `fk_po_or` FOREIGN KEY (`fkorden`) REFERENCES `orden` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_po_pro` FOREIGN KEY (`fkpro`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `slider`
--
ALTER TABLE `slider`
  ADD CONSTRAINT `fk_sl_pro` FOREIGN KEY (`fkpro`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tarpro`
--
ALTER TABLE `tarpro`
  ADD CONSTRAINT `fk_pro_tp` FOREIGN KEY (`fkpro`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tar_tp` FOREIGN KEY (`fktarjeta`) REFERENCES `tarjetas` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `temp_reco`
--
ALTER TABLE `temp_reco`
  ADD CONSTRAINT `fk_reco_tr` FOREIGN KEY (`fkreco`) REFERENCES `recomendacion` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tempo_tr` FOREIGN KEY (`fktempo`) REFERENCES `temporada` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_rol` FOREIGN KEY (`fkroles`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_role` FOREIGN KEY (`fkroles`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
