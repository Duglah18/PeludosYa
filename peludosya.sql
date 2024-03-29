-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-12-2022 a las 07:30:09
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `peludosya`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adopcion`
--

CREATE TABLE `adopcion` (
  `id_adopcion` int(11) NOT NULL,
  `fecha_adopcion` date NOT NULL DEFAULT current_timestamp(),
  `animal_id` int(11) NOT NULL,
  `cedula_usuario` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `adopcion`
--

INSERT INTO `adopcion` (`id_adopcion`, `fecha_adopcion`, `animal_id`, `cedula_usuario`, `estado`) VALUES
(6, '2022-11-30', 2, '15597525', 1),
(7, '2022-12-08', 2, '12597125', 1),
(31, '2022-12-08', 1, '12597535', 1),
(46, '2022-12-08', 2, '15597525', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albergue`
--

CREATE TABLE `albergue` (
  `id_albergue` int(11) NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `direccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `cedula_usuario` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `activo` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `albergue`
--

INSERT INTO `albergue` (`id_albergue`, `nombre`, `direccion`, `cedula_usuario`, `activo`) VALUES
(1, 'Unexpo', ' Avenida Corpahuaico entre Avenida La Salle', '12597525', 1),
(2, 'Ucla', 'Carrera 18 entre calle 55', '26976183', 1),
(3, 'Ucla 2', 'Carrera 18 entre calle 55', '12597525', 1),
(4, 'Libertador', 'Av. Libertador con Calle 23', '26976183', 1),
(5, 'Venezuela', 'Carrera 12 entre calle 01', '12597525', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `animal`
--

CREATE TABLE `animal` (
  `id_animal` int(11) NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `anio_nac` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `img` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `fecha_ingreso` date NOT NULL DEFAULT current_timestamp(),
  `raza_id` int(11) NOT NULL,
  `tamanio_id` int(11) NOT NULL,
  `albergue_id` int(11) NOT NULL,
  `visible` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `animal`
--

INSERT INTO `animal` (`id_animal`, `nombre`, `anio_nac`, `img`, `descripcion`, `fecha_ingreso`, `raza_id`, `tamanio_id`, `albergue_id`, `visible`) VALUES
(1, 'Antonella', '2012', 'anto.jpeg', 'Obediente, pero con mucha energia', '2022-11-05', 8, 1, 2, 1),
(2, 'Dylan', '2017', 'dylan.jpeg', 'Bastante jugueton pero muy consentido', '2020-08-12', 6, 1, 2, 1),
(3, 'Juan', '2013', 'juan.jpeg', 'Bastante tranquilo, suele comer mucho', '2022-01-06', 5, 1, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacoras`
--

CREATE TABLE `bitacoras` (
  `id_bitacora` int(11) NOT NULL,
  `usuario_bit` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `modulo_afectado` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `accion_realizada` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `valor_anterior` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `valor_actual` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_accion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `bitacoras`
--

INSERT INTO `bitacoras` (`id_bitacora`, `usuario_bit`, `modulo_afectado`, `accion_realizada`, `valor_anterior`, `valor_actual`, `fecha_accion`) VALUES
(207, '29517202', 'Usuario Logueandose', 'Logueandose', NULL, '29517202; 29517202; Peludotes; Peludotes; prueba; prueba; 1; 1; 3; 3', '2022-12-01 03:22:16'),
(208, '29517202', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '29517202 Cerrando Sesion', '2022-12-01 03:24:19'),
(209, '26976183', 'Usuario Logueandose', 'Logueandose', NULL, '26976183; 26976183; Rescatitos; Rescatitos; chicho; chicho; 1; 1; 3; 3', '2022-12-01 03:24:43'),
(210, '26976183', 'Usuario Logueandose', 'Logueandose', NULL, '26976183; 26976183; Rescatitos; Rescatitos; chicho; chicho; 1; 1; 3; 3', '2022-12-01 03:24:43'),
(211, '26976183', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '26976183 Cerrando Sesion', '2022-12-01 03:27:45'),
(212, '28368716', 'Usuario Logueandose', 'Logueandose', NULL, '28368716; 28368716; Israel; Israel; prueba; prueba; 1; 1; 1; 1', '2022-12-01 03:27:51'),
(213, '28368716', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '28368716 Cerrando Sesion', '2022-12-01 03:27:54'),
(214, '26976183', 'Usuario Logueandose', 'Logueandose', NULL, '26976183; 26976183; Rescatitos; Rescatitos; chicho; chicho; 1; 1; 3; 3', '2022-12-01 03:28:20'),
(215, '26976183', 'Usuario Logueandose', 'Logueandose', NULL, '26976183; 26976183; Rescatitos; Rescatitos; chicho; chicho; 1; 1; 3; 3', '2022-12-01 03:28:20'),
(216, '26976183', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '26976183 Cerrando Sesion', '2022-12-01 04:03:59'),
(217, '28368716', 'Usuario Logueandose', 'Logueandose', NULL, '28368716; 28368716; Israel; Israel; prueba; prueba; 1; 1; 1; 1', '2022-12-01 04:07:04'),
(218, '28368716', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '28368716 Cerrando Sesion', '2022-12-01 04:07:08'),
(219, '26976183', 'Usuario Logueandose', 'Logueandose', NULL, '26976183; 26976183; Rescatitos; Rescatitos; chicho; chicho; 1; 1; 3; 3', '2022-12-01 04:07:17'),
(220, '26976183', 'Usuario Logueandose', 'Logueandose', NULL, '26976183; 26976183; Rescatitos; Rescatitos; chicho; chicho; 1; 1; 3; 3', '2022-12-01 04:07:17'),
(221, '26976183', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '26976183 Cerrando Sesion', '2022-12-01 04:07:20'),
(222, '12597535', 'Usuario Logueandose', 'Logueandose', NULL, '12597535; 12597535; Torres; Torres; 123456; 123456; 1; 1; 2; 2', '2022-12-01 04:07:31'),
(223, '12597535', 'Usuario Logueandose', 'Logueandose', NULL, '12597535; 12597535; Torres; Torres; 123456; 123456; 1; 1; 2; 2', '2022-12-01 04:07:31'),
(224, '12597535', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '12597535 Cerrando Sesion', '2022-12-01 04:08:25'),
(225, '19517202', 'Usuario Logueandose', 'Logueandose', NULL, '19517202; 19517202; Uclamascotas; Uclamascotas; prueba; prueba; 1; 1; 3; 3', '2022-12-01 04:08:39'),
(226, '19517202', 'Usuario Logueandose', 'Logueandose', NULL, '19517202; 19517202; Uclamascotas; Uclamascotas; prueba; prueba; 1; 1; 3; 3', '2022-12-01 04:08:39'),
(227, '19517202', 'Usuario Logueandose', 'Logueandose', NULL, '19517202; 19517202; Uclamascotas; Uclamascotas; prueba; prueba; 1; 1; 3; 3', '2022-12-01 04:08:55'),
(228, '19517202', 'Usuario Logueandose', 'Logueandose', NULL, '19517202; 19517202; Uclamascotas; Uclamascotas; prueba; prueba; 1; 1; 3; 3', '2022-12-01 04:08:55'),
(229, '19517202', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '19517202 Cerrando Sesion', '2022-12-01 04:09:06'),
(230, '26976183', 'Usuario Logueandose', 'Logueandose', NULL, '26976183; 26976183; Rescatitos; Rescatitos; chicho; chicho; 1; 1; 3; 3', '2022-12-01 04:09:17'),
(231, '26976183', 'Usuario Logueandose', 'Logueandose', NULL, '26976183; 26976183; Rescatitos; Rescatitos; chicho; chicho; 1; 1; 3; 3', '2022-12-01 04:09:17'),
(232, '26976183', 'Modifica Visibilidad Peludo Fundacion', 'UPDATE animal SET visible=0 WHERE id_animal = 19', '19;19;1;1', '19; 19; 0; 0', '2022-12-01 04:16:25'),
(233, '26976183', 'Modifica Visibilidad Peludo Fundacion', 'UPDATE animal SET visible=0 WHERE id_animal = 4', '4;4;1;1', '4; 4; 0; 0', '2022-12-01 04:16:34'),
(234, '26976183', 'Modifica Visibilidad Peludo Fundacion', 'UPDATE animal SET visible=0 WHERE id_animal = 19', '19;19;1;1', '19; 19; 0; 0', '2022-12-01 04:17:23'),
(235, '26976183', 'Modifica Visibilidad Albergue Fundacion', 'UPDATE albergue SET activo=0 WHERE id_albergue = 2', '2;2;1;1', '2; 2; 0; 0', '2022-12-01 04:19:26'),
(236, '26976183', 'Modifica Visibilidad Albergue Fundacion', 'UPDATE albergue SET activo=1 WHERE id_albergue = 2', '2;2;0;0', '2; 2; 1; 1', '2022-12-01 04:19:29'),
(237, '26976183', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '26976183 Cerrando Sesion', '2022-12-01 04:39:31'),
(238, '28368716', 'Usuario Logueandose', 'Logueandose', NULL, '28368716; 28368716; Israel; Israel; prueba; prueba; 1; 1; 1; 1', '2022-12-01 04:44:48'),
(239, '28368716', 'Modifica Tipo Animal admin', 'UPDATE tipo_animal SET nombre=Perro2 WHERE id_tipo = 1', 'Perro;Perro', 'Perro2; Perro2', '2022-12-01 06:39:31'),
(240, '28368716', 'Modifica Tipo Animal admin', 'UPDATE tipo_animal SET nombre=Perro WHERE id_tipo = 1', 'Perro2;Perro2', 'Perro; Perro', '2022-12-01 06:39:35'),
(241, '28368716', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '28368716 Cerrando Sesion', '2022-12-01 07:00:50'),
(242, '28368716', 'Usuario Logueandose', 'Logueandose', NULL, '28368716; 28368716; Israel; Israel; prueba; prueba; 1; 1; 1; 1', '2022-12-01 07:01:13'),
(243, '28368716', 'Modifica Veterinario Admin', 'UPDATE veterinario SET nombre=Dra. Andreina Mendez, tlf=42518859, direccion=Carrera 18 calle 55, img=imagen.jpg, visible=1 WHERE id_veterinario = &#39;1&#39;', 'Dra. Andreina Mendez;Dra. Andreina Mendez;42518859;42518859;Carrera 18 calle 55;Carrera 18 calle 55;', 'Dra. Andreina Mendez; Dra. Andreina Mendez; 42518859; 42518859; Carrera 18 calle 55; Carrera 18 call', '2022-12-01 07:15:11'),
(244, '28368716', 'Modifica Vision de Veterinario Admin', 'UPDATE veterinario SET visible=0 WHERE id_veterinario = 1', '1;1;1;1', '1; 1; 0; 0', '2022-12-01 07:15:20'),
(245, '28368716', 'Modifica Vision de Veterinario Admin', 'UPDATE veterinario SET visible=1 WHERE id_veterinario = 1', '1;1;0;0', '1; 1; 1; 1', '2022-12-01 07:15:22'),
(246, '28368716', 'Modifica Visibilidad Peludo Admin', 'UPDATE animal SET visible=0 WHERE id_animal = 20', '20;20;1;1', '20; 20; 0; 0', '2022-12-01 07:22:11'),
(247, '28368716', 'Modifica Visibilidad Peludo Admin', 'UPDATE animal SET visible=1 WHERE id_animal = 20', '20;20;0;0', '20; 20; 1; 1', '2022-12-01 07:22:14'),
(248, '28368716', 'Modifica Visibilidad Albergue Admin', 'UPDATE albergue SET activo=1 WHERE id_albergue = 1', '1;1;0;0', '1; 1; 1; 1', '2022-12-01 07:31:08'),
(249, '28368716', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '28368716 Cerrando Sesion', '2022-12-01 07:37:08'),
(250, '26976183', 'Usuario Logueandose', 'Logueandose', NULL, '26976183; 26976183; Rescatitos; Rescatitos; chicho; chicho; 1; 1; 3; 3', '2022-12-01 07:37:34'),
(251, '26976183', 'Usuario Logueandose', 'Logueandose', NULL, '26976183; 26976183; Rescatitos; Rescatitos; chicho; chicho; 1; 1; 3; 3', '2022-12-01 07:37:34'),
(252, '26976183', 'Modifica Visibilidad Albergue Fundacion', 'UPDATE albergue SET activo=0 WHERE id_albergue = 2', '2;2;1;1', '2; 2; 0; 0', '2022-12-01 07:42:59'),
(253, '26976183', 'Modifica Visibilidad Albergue Fundacion', 'UPDATE albergue SET activo=1 WHERE id_albergue = 2', '2;2;0;0', '2; 2; 1; 1', '2022-12-01 07:43:01'),
(254, '26976183', 'Modifica Visibilidad Peludo Admin', 'UPDATE animal SET visible=0 WHERE id_animal = 19', '19;19;1;1', '19; 19; 0; 0', '2022-12-01 07:47:53'),
(255, '26976183', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '26976183 Cerrando Sesion', '2022-12-01 07:52:53'),
(256, '28368716', 'Usuario Logueandose', 'Logueandose', NULL, '28368716; 28368716; Israel; Israel; prueba; prueba; 1; 1; 1; 1', '2022-12-01 07:58:22'),
(257, '28368716', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '28368716 Cerrando Sesion', '2022-12-01 08:03:10'),
(258, '26976183', 'Usuario Logueandose', 'Logueandose', NULL, '26976183; 26976183; Rescatitos; Rescatitos; chicho; chicho; 1; 1; 3; 3', '2022-12-01 08:03:20'),
(259, '26976183', 'Usuario Logueandose', 'Logueandose', NULL, '26976183; 26976183; Rescatitos; Rescatitos; chicho; chicho; 1; 1; 3; 3', '2022-12-01 08:03:20'),
(260, '26976183', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '26976183 Cerrando Sesion', '2022-12-01 08:05:19'),
(261, '28368716', 'Usuario Logueandose', 'Logueandose', NULL, '28368716; 28368716; Israel; Israel; prueba; prueba; 1; 1; 1; 1', '2022-12-01 08:05:27'),
(262, '28368716', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '28368716 Cerrando Sesion', '2022-12-01 08:05:52'),
(263, '28368716', 'Usuario Logueandose', 'Logueandose', NULL, '28368716; 28368716; Israel; Israel; prueba; prueba; 1; 1; 1; 1', '2022-12-01 13:11:20'),
(264, '28368716', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '28368716 Cerrando Sesion', '2022-12-01 13:12:07'),
(267, '28368716', 'Usuario Logueandose', 'Logueandose', NULL, '28368716; 28368716; Israel; Israel; prueba; prueba; 1; 1; 1; 1', '2022-12-07 04:20:40'),
(268, '28368716', 'Usuario Logueandose', 'Logueandose', NULL, '28368716; 28368716; Israel; Israel; prueba; prueba; 1; 1; 1; 1', '2022-12-07 04:24:38'),
(269, '28368716', 'Modifica Bloqueo de Usuario Admin', 'UPDATE usuarios SET activo=0 WHERE cedula = 123', '123;123;1;1', '123; 123; 0; 0', '2022-12-07 04:27:53'),
(270, '28368716', 'AÃ±adir Tipo Animal Admin', 'INSERT INTO tipo_animal(nombre) VALUES ( as)', NULL, 'as', '2022-12-07 04:44:14'),
(271, '28368716', 'AÃ±adir Tipo Animal Admin', 'INSERT INTO tipo_animal(nombre) VALUES ( Asss)', NULL, 'Asss', '2022-12-07 04:57:38'),
(272, '28368716', 'AÃ±adir Tipo Animal Admin', 'INSERT INTO tipo_animal(nombre) VALUES ( Hola.)', NULL, 'Hola.', '2022-12-07 05:00:49'),
(273, '28368716', 'AÃ±adir Tipo Animal Admin', 'INSERT INTO tipo_animal(nombre) VALUES ( Hola=)', NULL, 'Hola=', '2022-12-07 05:00:57'),
(274, '28368716', 'AÃ±adir Tipo Animal Admin', 'INSERT INTO tipo_animal(nombre) VALUES ( asd)', NULL, 'asd', '2022-12-07 05:07:56'),
(275, '28368716', 'AÃ±adir Tipo Animal Admin', 'INSERT INTO tipo_animal(nombre) VALUES ( asddasd)', NULL, 'asddasd', '2022-12-07 05:08:10'),
(276, '28368716', 'AÃ±adir Raza Animal Admin', 'INSERT INTO raza(nombre, id_tipo_animal) VALUES ( Chihawa, 14)', NULL, 'Chihawa; 14', '2022-12-07 05:19:32'),
(277, '28368716', 'Modifica Raza Animal Admin', 'UPDATE raza SET nombre=Perso, id_tipo_animal=2 WHERE id_raza = &#39;3&#39;', 'Persa;Persa;2;2', 'Perso; Perso; 2; 2', '2022-12-07 05:22:05'),
(278, '28368716', 'AÃ±adir Veterinario Admin', 'INSERT INTO veterinario(nombre, tlf, direccion, img, visible, usuario_Rveterinario) VALUES ( asd, 02514456441, asdasd, 1670391520_220826121112-02-dog-adoption-opinion-full-169.webp, 1, 28368716)', NULL, 'asd; 02514456441; asdasd; 1670391520_220826121112-02-dog-adoption-opinion-full-169.webp; 1; 28368716', '2022-12-07 05:38:41'),
(279, '28368716', 'Modifica Vision de Veterinario Admin', 'UPDATE veterinario SET visible=0 WHERE id_veterinario = 24', '24;24;1;1', '24; 24; 0; 0', '2022-12-07 05:44:24'),
(280, '28368716', 'Usuario Logueandose', 'Logueandose', NULL, '28368716; 28368716; Israel; Israel; prueba; prueba; 1; 1; 1; 1', '2022-12-07 20:00:50'),
(281, '28368716', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '28368716 Cerrando Sesion', '2022-12-08 05:19:55'),
(282, '28368716', 'Usuario Logueandose', 'Logueandose', NULL, '28368716; 28368716; Israel; Israel; prueba; prueba; 1; 1; 1; 1', '2022-12-08 05:28:54'),
(283, '28368716', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '28368716 Cerrando Sesion', '2022-12-08 05:29:22'),
(284, '28368716', 'Usuario Logueandose', 'Logueandose', NULL, '28368716; 28368716; Israel; Israel; prueba; prueba; 1; 1; 1; 1', '2022-12-08 05:30:59'),
(285, '28368716', 'Modifica Visibilidad Peludo Admin', 'UPDATE animal SET visible=1 WHERE id_animal = 19', '19;19;0;0', '19; 19; 1; 1', '2022-12-08 06:06:26'),
(286, '28368716', 'Modifica Visibilidad Peludo Admin', 'UPDATE animal SET visible=0 WHERE id_animal = 20', '20;20;1;1', '20; 20; 0; 0', '2022-12-08 06:06:29'),
(287, '28368716', 'Modifica Bloqueo de Usuario Admin', 'UPDATE usuarios SET activo=0 WHERE cedula = 28368716', '28368716;28368716;1;1', '28368716; 28368716; 0; 0', '2022-12-08 06:28:48'),
(288, '28368716', 'Modifica Bloqueo de Usuario Admin', 'UPDATE usuarios SET activo=0 WHERE cedula = 29517402', '29517402;29517402;1;1', '29517402; 29517402; 0; 0', '2022-12-08 06:28:50'),
(289, '28368716', 'Modifica Bloqueo de Usuario Admin', 'UPDATE usuarios SET activo=1 WHERE cedula = 28368716', '28368716;28368716;0;0', '28368716; 28368716; 1; 1', '2022-12-08 06:29:01'),
(290, '28368716', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '28368716 Cerrando Sesion', '2022-12-08 06:45:21'),
(291, '28368716', 'Usuario Logueandose', 'Logueandose', NULL, '28368716; 28368716; Israel; Israel; prueba; prueba; 1; 1; 1; 1', '2022-12-08 06:51:42'),
(292, '28368716', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '28368716 Cerrando Sesion', '2022-12-08 06:51:46'),
(293, '28368716', 'Usuario Logueandose', 'Logueandose', NULL, '28368716; 28368716; Israel; Israel; prueba; prueba; 1; 1; 1; 1', '2022-12-08 07:13:17'),
(294, '28368716', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '28368716 Cerrando Sesion', '2022-12-08 07:14:28'),
(295, '26976183', 'Usuario Logueandose', 'Logueandose', NULL, '26976183; 26976183; Rescatitos; Rescatitos; chicho; chicho; 1; 1; 3; 3', '2022-12-08 07:15:05'),
(296, '26976183', 'Usuario Logueandose', 'Logueandose', NULL, '26976183; 26976183; Rescatitos; Rescatitos; chicho; chicho; 1; 1; 3; 3', '2022-12-08 07:15:05'),
(297, '26976183', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '26976183 Cerrando Sesion', '2022-12-08 16:37:26'),
(298, '12597125', 'Usuario Logueandose', 'Logueandose', NULL, '12597125; 12597125; Javier; Javier; 123456789; 123456789; 1; 1; 2; 2', '2022-12-08 19:32:55'),
(299, '12597125', 'Usuario Logueandose', 'Logueandose', NULL, '12597125; 12597125; Javier; Javier; 123456789; 123456789; 1; 1; 2; 2', '2022-12-08 19:32:55'),
(300, '12597125', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 2, 12597125, 1)', NULL, 'Now(); 2; 12597125; 1', '2022-12-08 19:32:59'),
(301, '12597125', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597125, 1)', NULL, 'Now(); 1; 12597125; 1', '2022-12-08 19:33:08'),
(302, '12597125', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 3, 12597125, 1)', NULL, 'Now(); 3; 12597125; 1', '2022-12-08 19:33:12'),
(303, '12597125', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '12597125 Cerrando Sesion', '2022-12-08 19:33:15'),
(304, '28368716', 'Usuario Logueandose', 'Logueandose', NULL, '28368716; 28368716; Israel; Israel; prueba; prueba; 1; 1; 1; 1', '2022-12-08 19:33:23'),
(305, '28368716', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '28368716 Cerrando Sesion', '2022-12-08 19:34:07'),
(306, '26976183', 'Usuario Logueandose', 'Logueandose', NULL, '26976183; 26976183; Rescatitos; Rescatitos; chicho; chicho; 1; 1; 3; 3', '2022-12-08 19:34:19'),
(307, '26976183', 'Usuario Logueandose', 'Logueandose', NULL, '26976183; 26976183; Rescatitos; Rescatitos; chicho; chicho; 1; 1; 3; 3', '2022-12-08 19:34:19'),
(308, '26976183', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '26976183 Cerrando Sesion', '2022-12-08 19:34:32'),
(309, '12597535', 'Usuario Logueandose', 'Logueandose', NULL, '12597535; 12597535; Torres; Torres; 123456; 123456; 1; 1; 2; 2', '2022-12-08 20:38:07'),
(310, '12597535', 'Usuario Logueandose', 'Logueandose', NULL, '12597535; 12597535; Torres; Torres; 123456; 123456; 1; 1; 2; 2', '2022-12-08 20:38:08'),
(311, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 2, 12597535, 1)', NULL, 'Now(); 2; 12597535; 1', '2022-12-08 20:38:10'),
(312, '12597535', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '12597535 Cerrando Sesion', '2022-12-08 20:53:26'),
(313, '12597535', 'Usuario Logueandose', 'Logueandose', NULL, '12597535; 12597535; Torres; Torres; 123456; 123456; 1; 1; 2; 2', '2022-12-08 20:53:54'),
(314, '12597535', 'Usuario Logueandose', 'Logueandose', NULL, '12597535; 12597535; Torres; Torres; 123456; 123456; 1; 1; 2; 2', '2022-12-08 20:53:54'),
(315, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 2, 12597535, 1)', NULL, 'Now(); 2; 12597535; 1', '2022-12-08 20:57:27'),
(316, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 20:57:44'),
(317, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:00:27'),
(318, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:00:54'),
(319, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:01:04'),
(320, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:01:12'),
(321, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:01:48'),
(322, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:02:00'),
(323, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:02:28'),
(324, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:02:50'),
(325, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:03:04'),
(326, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:03:39'),
(327, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:03:52'),
(328, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:06:41'),
(329, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:06:57'),
(330, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:07:10'),
(331, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:07:39'),
(332, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:07:47'),
(333, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:08:20'),
(334, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:08:36'),
(335, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:09:20'),
(336, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:09:32'),
(337, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:10:01'),
(338, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:10:18'),
(339, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:10:29'),
(340, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:10:41'),
(341, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:10:59'),
(342, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:11:05'),
(343, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:12:51'),
(344, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:13:18'),
(345, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:13:39'),
(346, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:14:00'),
(347, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:14:16'),
(348, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:14:47'),
(349, '12597535', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 1, 12597535, 1)', NULL, 'Now(); 1; 12597535; 1', '2022-12-08 21:15:39'),
(350, '12597535', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '12597535 Cerrando Sesion', '2022-12-08 21:36:54'),
(351, '28368716', 'Usuario Logueandose', 'Logueandose', NULL, '28368716; 28368716; Israel; Israel; prueba; prueba; 1; 1; 1; 1', '2022-12-08 21:40:37'),
(352, '28368716', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '28368716 Cerrando Sesion', '2022-12-08 21:40:44'),
(353, '28368716', 'Usuario Logueandose', 'Logueandose', NULL, '28368716; 28368716; Israel; Israel; 123456789; 123456789; 1; 1; 1; 1', '2022-12-08 21:59:49'),
(354, '28368716', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '28368716 Cerrando Sesion', '2022-12-08 21:59:51'),
(355, '28368716', 'Usuario Logueandose', 'Logueandose', NULL, '28368716; 28368716; Israel; Israel; 123456789; 123456789; 1; 1; 1; 1', '2022-12-08 22:01:40'),
(356, '28368716', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '28368716 Cerrando Sesion', '2022-12-08 22:20:37'),
(357, '15597525', 'Usuario Logueandose', 'Logueandose', NULL, '15597525; 15597525; Anavilera; Anavilera; 123456789; 123456789; 1; 1; 2; 2', '2022-12-08 22:21:21'),
(358, '15597525', 'Usuario Logueandose', 'Logueandose', NULL, '15597525; 15597525; Anavilera; Anavilera; 123456789; 123456789; 1; 1; 2; 2', '2022-12-08 22:21:21'),
(359, '15597525', 'Usuario Pidiendo Adopcion', 'INSERT INTO adopcion(fecha_adopcion, animal_id, cedula_usuario, estado) VALUES (  Now(), 2, 15597525, 1)', NULL, 'Now(); 2; 15597525; 1', '2022-12-08 22:21:32'),
(360, '15597525', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '15597525 Cerrando Sesion', '2022-12-08 22:22:03'),
(361, '28368716', 'Usuario Logueandose', 'Logueandose', NULL, '28368716; 28368716; Israel; Israel; 123456789; 123456789; 1; 1; 1; 1', '2022-12-08 22:22:22'),
(362, '28368716', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '28368716 Cerrando Sesion', '2022-12-08 22:24:27'),
(363, '28368716', 'Usuario Logueandose', 'Logueandose', NULL, '28368716; 28368716; Israel; Israel; 123456789; 123456789; 1; 1; 1; 1', '2022-12-08 22:34:05'),
(364, '28368716', 'Usuario Logueandose', 'Logueandose', NULL, '28368716; 28368716; Israel; Israel; 123456789; 123456789; 1; 1; 1; 1', '2022-12-09 03:27:10'),
(365, '28368716', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '28368716 Cerrando Sesion', '2022-12-09 03:27:44'),
(366, '26976183', 'Usuario Logueandose', 'Logueandose', NULL, '26976183; 26976183; Rescatitos; Rescatitos; 123456789; 123456789; 1; 1; 3; 3', '2022-12-09 03:29:08'),
(367, '26976183', 'Usuario Logueandose', 'Logueandose', NULL, '26976183; 26976183; Rescatitos; Rescatitos; 123456789; 123456789; 1; 1; 3; 3', '2022-12-09 03:29:09'),
(368, '26976183', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '26976183 Cerrando Sesion', '2022-12-09 03:30:44'),
(369, '28368716', 'Usuario Logueandose', 'Logueandose', NULL, '28368716; 28368716; Israel; Israel; 123456789; 123456789; 1; 1; 1; 1', '2022-12-09 03:30:50'),
(370, '28368716', 'Usuario Logueandose', 'Logueandose', NULL, '28368716; 28368716; Israel; Israel; 123456789; 123456789; 1; 1; 1; 1', '2022-12-09 03:55:45'),
(371, '28368716', 'AÃ±adir Animal Admin', 'INSERT INTO animal(nombre, anio_nac, img, descripcion, fecha_ingreso, raza_id, tamanio_id, albergue_id, visible) VALUES ( asd, 1995, 1670558181_Flag_of_Venezuela.svg.png, asdasd,  Now(), 3, 1, 5, 1)', NULL, 'asd; 1995; 1670558181_Flag_of_Venezuela.svg.png; asdasd; Now(); 3; 1; 5; 1', '2022-12-09 03:56:21'),
(372, '28368716', 'Modifica Animal', 'UPDATE animal SET nombre=asd, anio_nac=1995, img=imagen.jpg, descripcion=asdasdasd, raza_id=3, tamanio_id=1, albergue_id=5, visible=1 WHERE id_animal = 21', 'asd;asd;1995;1995;1670558181_Flag_of_Venezuela.svg.png;1670558181_Flag_of_Venezuela.svg.png;asdasd;a', 'asd; asd; 1995; 1995; imagen.jpg; imagen.jpg; asdasdasd; asdasdasd; 3; 3; 1; 1; 5; 5; 1; 1', '2022-12-09 03:57:01'),
(373, '28368716', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '28368716 Cerrando Sesion', '2022-12-09 04:36:34'),
(374, '28368716', 'Usuario Logueandose', 'Logueandose', NULL, '28368716; 28368716; Israel; Israel; 123456789; 123456789; 1; 1; 1; 1', '2022-12-09 04:53:56'),
(375, '28368716', 'Cerrar Sesion', 'Cerrar Sesion', NULL, '28368716 Cerrando Sesion', '2022-12-09 04:59:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `raza`
--

CREATE TABLE `raza` (
  `id_raza` int(11) NOT NULL,
  `nombre` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_tipo_animal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `raza`
--

INSERT INTO `raza` (`id_raza`, `nombre`, `id_tipo_animal`) VALUES
(1, 'Chihuahua​', 1),
(2, 'Bulldog', 1),
(3, 'Persa', 2),
(4, 'Kohana', 2),
(5, 'Terrier', 1),
(6, 'Cazador', 1),
(8, 'Puddle', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `nombre` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre`) VALUES
(1, 'admin'),
(2, 'usuario'),
(3, 'fundacion');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tamanio`
--

CREATE TABLE `tamanio` (
  `id_tamanio` int(11) NOT NULL,
  `nombre` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tamanio`
--

INSERT INTO `tamanio` (`id_tamanio`, `nombre`) VALUES
(1, 'Pequeno'),
(2, 'Mediano'),
(3, 'Grande');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_animal`
--

CREATE TABLE `tipo_animal` (
  `id_tipo` int(11) NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_animal`
--

INSERT INTO `tipo_animal` (`id_tipo`, `nombre`) VALUES
(1, 'Perro'),
(2, 'Gato');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_estado_adopcion`
--

CREATE TABLE `tipo_estado_adopcion` (
  `id_tipo_estado` int(11) NOT NULL,
  `nombre_estado` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_estado_adopcion`
--

INSERT INTO `tipo_estado_adopcion` (`id_tipo_estado`, `nombre_estado`) VALUES
(1, 'Progreso'),
(2, 'Cancelada'),
(3, 'Completada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `cedula` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rol_id` int(11) NOT NULL,
  `direccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `contrasenia` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `activo` int(1) NOT NULL,
  `telefono` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `detalles` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Registro Usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`cedula`, `nombre`, `rol_id`, `direccion`, `contrasenia`, `activo`, `telefono`, `detalles`) VALUES
('12527525', 'Rescates Javier', 3, 'Carr 18 con calle 55', 'fundacion', 1, '04245936421', 'Registro Usuario'),
('12597123', 'Peluditos S.A', 3, 'Carr 18 con calle 55', 'fundacion', 1, '04245936421', 'Registro Usuario'),
('12597125', 'Javier', 2, 'Carr 18 con calle 55', '123456789', 1, '04245936421', 'Registro Usuario'),
('12597525', 'Uclalipeludos', 3, 'Carrera 11 con calle 01', 'fundacion', 1, '04245936421', 'Registro Usuario'),
('12597535', 'Torres', 2, 'Carr 18 con calle 55', '123456', 1, '04245936421', 'Registro Usuario'),
('15597525', 'Anavilera', 2, 'Carr 18 con calle 55', '123456789', 1, '04245936421', 'Registro Usuario'),
('19517202', 'Uclamascotas', 3, 'Carrera 12 con calle 01', 'prueba', 1, '04245936421', 'Registro Usuario'),
('26976178', 'Yummy Pets', 3, 'Carrera 25 con calle 55', 'chicho', 1, '1212121212', 'Registro Usuario'),
('26976183', 'Rescatitos', 3, 'Carrera 31 con calle 12', '123456789', 1, '1212121212', 'Registro Usuario'),
('28368716', 'Israel', 1, 'Carr 18 con calle 55', '123456789', 1, '04245936421', 'Registro Usuario'),
('29517202', 'Peludotes', 3, 'Carrera 02 con calle 13', 'prueba', 1, '04245936421', 'Registro Usuario'),
('29517295', 'Polipropeludos', 3, 'Carrera 51 con calle 04', 'prueba', 1, '04245936421', 'Registro Usuario'),
('29517402', 'Douglas', 1, 'Carr 18 con calle 55', 'lolcoptero', 0, '04245936421', 'Registro Usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `veterinario`
--

CREATE TABLE `veterinario` (
  `id_veterinario` int(11) NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tlf` int(11) NOT NULL,
  `direccion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `img` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `visible` int(1) NOT NULL,
  `usuario_Rveterinario` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `veterinario`
--

INSERT INTO `veterinario` (`id_veterinario`, `nombre`, `tlf`, `direccion`, `img`, `visible`, `usuario_Rveterinario`) VALUES
(1, 'Dra. Andreina Mendez', 42518859, 'Carrera 18 calle 55', '6.png', 1, '29517402'),
(2, 'Dra. Merry Perez', 42518859, 'Carrera 18 calle 55', '7.png', 1, '29517402'),
(3, 'Dr. David Torrealba', 42518859, 'Carrera 18 calle 55', '8.png', 1, '29517402'),
(4, 'Dr. Juan Perozo', 42518859, 'Carrera 18 calle 55', '5.png', 1, '29517402'),
(5, 'Dra. Heisy Torres', 42518859, 'Carrera 18 calle 55', '3.png', 1, '29517402'),
(6, 'Dr. Diego Blanco', 42518859, 'Carrera 18 calle 55', '23.png', 1, '29517402'),
(7, 'Dra. Stephanie Quiroz', 42518859, 'Carrera 18 calle 55', '4.png', 1, '29517402'),
(8, 'Dra. Jaiden Perez', 42518859, 'Carrera 18 calle 55', '12.png', 1, '29517402');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `adopcion`
--
ALTER TABLE `adopcion`
  ADD PRIMARY KEY (`id_adopcion`),
  ADD KEY `animal_id` (`animal_id`),
  ADD KEY `cedula_usuario` (`cedula_usuario`),
  ADD KEY `estado` (`estado`);

--
-- Indices de la tabla `albergue`
--
ALTER TABLE `albergue`
  ADD PRIMARY KEY (`id_albergue`),
  ADD KEY `cedula_usuario` (`cedula_usuario`);

--
-- Indices de la tabla `animal`
--
ALTER TABLE `animal`
  ADD PRIMARY KEY (`id_animal`),
  ADD KEY `raza_id` (`raza_id`),
  ADD KEY `tamanio_id` (`tamanio_id`),
  ADD KEY `albergue_id` (`albergue_id`);

--
-- Indices de la tabla `bitacoras`
--
ALTER TABLE `bitacoras`
  ADD PRIMARY KEY (`id_bitacora`),
  ADD KEY `usuario_bit` (`usuario_bit`);

--
-- Indices de la tabla `raza`
--
ALTER TABLE `raza`
  ADD PRIMARY KEY (`id_raza`),
  ADD KEY `id_tipo_animal` (`id_tipo_animal`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `tamanio`
--
ALTER TABLE `tamanio`
  ADD PRIMARY KEY (`id_tamanio`);

--
-- Indices de la tabla `tipo_animal`
--
ALTER TABLE `tipo_animal`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `tipo_estado_adopcion`
--
ALTER TABLE `tipo_estado_adopcion`
  ADD PRIMARY KEY (`id_tipo_estado`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`cedula`),
  ADD KEY `rol_id` (`rol_id`);

--
-- Indices de la tabla `veterinario`
--
ALTER TABLE `veterinario`
  ADD PRIMARY KEY (`id_veterinario`),
  ADD KEY `usuario_Rveterinario` (`usuario_Rveterinario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `adopcion`
--
ALTER TABLE `adopcion`
  MODIFY `id_adopcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `albergue`
--
ALTER TABLE `albergue`
  MODIFY `id_albergue` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `animal`
--
ALTER TABLE `animal`
  MODIFY `id_animal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `bitacoras`
--
ALTER TABLE `bitacoras`
  MODIFY `id_bitacora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=376;

--
-- AUTO_INCREMENT de la tabla `raza`
--
ALTER TABLE `raza`
  MODIFY `id_raza` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tamanio`
--
ALTER TABLE `tamanio`
  MODIFY `id_tamanio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_animal`
--
ALTER TABLE `tipo_animal`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tipo_estado_adopcion`
--
ALTER TABLE `tipo_estado_adopcion`
  MODIFY `id_tipo_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `veterinario`
--
ALTER TABLE `veterinario`
  MODIFY `id_veterinario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `adopcion`
--
ALTER TABLE `adopcion`
  ADD CONSTRAINT `adopcion_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`id_animal`) ON UPDATE CASCADE,
  ADD CONSTRAINT `adopcion_ibfk_2` FOREIGN KEY (`cedula_usuario`) REFERENCES `usuarios` (`cedula`) ON UPDATE CASCADE,
  ADD CONSTRAINT `adopcion_ibfk_3` FOREIGN KEY (`estado`) REFERENCES `tipo_estado_adopcion` (`id_tipo_estado`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `albergue`
--
ALTER TABLE `albergue`
  ADD CONSTRAINT `albergue_ibfk_1` FOREIGN KEY (`cedula_usuario`) REFERENCES `usuarios` (`cedula`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `animal`
--
ALTER TABLE `animal`
  ADD CONSTRAINT `animal_ibfk_1` FOREIGN KEY (`raza_id`) REFERENCES `raza` (`id_raza`) ON UPDATE CASCADE,
  ADD CONSTRAINT `animal_ibfk_2` FOREIGN KEY (`tamanio_id`) REFERENCES `tamanio` (`id_tamanio`) ON UPDATE CASCADE,
  ADD CONSTRAINT `animal_ibfk_3` FOREIGN KEY (`albergue_id`) REFERENCES `albergue` (`id_albergue`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `bitacoras`
--
ALTER TABLE `bitacoras`
  ADD CONSTRAINT `bitacoras_ibfk_1` FOREIGN KEY (`usuario_bit`) REFERENCES `usuarios` (`cedula`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `raza`
--
ALTER TABLE `raza`
  ADD CONSTRAINT `raza_ibfk_1` FOREIGN KEY (`id_tipo_animal`) REFERENCES `tipo_animal` (`id_tipo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id_rol`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `veterinario`
--
ALTER TABLE `veterinario`
  ADD CONSTRAINT `veterinario_ibfk_1` FOREIGN KEY (`usuario_Rveterinario`) REFERENCES `usuarios` (`cedula`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
