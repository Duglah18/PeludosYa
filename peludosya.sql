-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-11-2022 a las 20:13:48
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

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
  `cedula_usuario` varchar(9) NOT NULL,
  `estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `adopcion`
--

INSERT INTO `adopcion` (`id_adopcion`, `fecha_adopcion`, `animal_id`, `cedula_usuario`, `estado`) VALUES
(3, '2022-10-22', 3, '29517402', 3),
(5, '2022-11-03', 4, '15597525', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albergue`
--

CREATE TABLE `albergue` (
  `id_albergue` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `cedula_usuario` varchar(9) NOT NULL,
  `activo` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `albergue`
--

INSERT INTO `albergue` (`id_albergue`, `nombre`, `direccion`, `cedula_usuario`, `activo`) VALUES
(1, 'albergue1115151qweq', 'Carrera 18 calle 55', '26976183', 1),
(2, 'albergue1232', 'Carrera 18 calle 55', '26976183', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `animal`
--

CREATE TABLE `animal` (
  `id_animal` int(11) NOT NULL,
  `nombre` varchar(55) NOT NULL,
  `anio_nac` varchar(5) NOT NULL,
  `img` varchar(1000) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `fecha_ingreso` date NOT NULL DEFAULT current_timestamp(),
  `raza_id` int(11) NOT NULL,
  `tamanio_id` int(11) NOT NULL,
  `albergue_id` int(11) NOT NULL,
  `visible` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `animal`
--

INSERT INTO `animal` (`id_animal`, `nombre`, `anio_nac`, `img`, `descripcion`, `fecha_ingreso`, `raza_id`, `tamanio_id`, `albergue_id`, `visible`) VALUES
(1, 'PRUEBA 501', '2019', 'imagen.jpg', 'pinpon es un mu&ntilde;eco', '0000-00-00', 5, 3, 1, 0),
(2, 'Pinpon', '2019', '1665946339_4f83f853.jpg', 'pinpon es un muñeco', '0000-00-00', 2, 1, 1, 1),
(3, 'Pinpon', '2019', '1665946459_4f83f853.jpg', 'pinpon es un muñeco', '0000-00-00', 2, 1, 1, 1),
(4, 'Merry', '2019', '1665947240_0f10aa96.jpg', 'pinpon es un muñeco', '2022-10-16', 2, 2, 1, 1),
(6, 'Pinponqwdfwqf', '2019', 'imagen.jpg', 'pinpon es un muñeco', '2022-10-28', 5, 3, 1, 1),
(7, 'Pinpon2', '2019', 'imagen.jpg', 'pinpon es un muñeco', '2022-10-28', 5, 3, 1, 1),
(8, 'Pinpon2mod8', '2019', 'imagen.jpg', 'pinpon es un mu&ntilde;eco', '2022-10-28', 5, 3, 1, 1),
(9, 'Pinpon23232', '2019', 'imagen.jpg', 'pinpon es un muñeco', '2022-10-28', 5, 3, 1, 1),
(10, 'terry', '2012', '1667688509_c1a82509.jpg', 'Terry es muy bravo', '2022-11-05', 6, 1, 2, 1),
(11, 'oliver', '2021', '1667688623_d41e08c5.jpg', 'oliver es muy bravo', '2022-11-05', 5, 1, 2, 1),
(12, 'bola de nieve', '2022', '1667689056_E9aVPwWWQAEbA_0.jpg', 'Bola de nieve', '2022-11-05', 5, 1, 1, 1),
(13, 'Rocky', '2019', '1667689195_f58e675d.jpg', 'Prueba', '2022-11-05', 2, 2, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacoras`
--

CREATE TABLE `bitacoras` (
  `id_bitacora` int(11) NOT NULL,
  `usuario_bit` varchar(11) NOT NULL,
  `modulo_afectado` varchar(40) NOT NULL,
  `accion_realizada` varchar(1000) NOT NULL,
  `valor_anterior` varchar(100) DEFAULT NULL,
  `valor_actual` varchar(100) NOT NULL,
  `fecha_accion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `bitacoras`
--

INSERT INTO `bitacoras` (`id_bitacora`, `usuario_bit`, `modulo_afectado`, `accion_realizada`, `valor_anterior`, `valor_actual`, `fecha_accion`) VALUES
(1, '26976183', 'Modifica Adopcion', 'ACTUALIZACION', 'Array', 'UPDATE adopcion SET estado=&#39;3&#39; WHERE id_adopcion = 5', '2022-11-04 23:57:15'),
(2, '26976183', 'Modifica Adopcion', 'ACTUALIZACION', 'Array', 'UPDATE adopcion SET estado=&#39;3&#39; WHERE id_adopcion = 5', '2022-11-05 00:00:23'),
(3, '26976183', 'Modifica Adopcion', 'ACTUALIZACION', 'Array', 'UPDATE adopcion SET estado=&#39;3&#39; WHERE id_adopcion = 5', '2022-11-05 00:03:49'),
(4, '26976183', 'Modifica Adopcion', 'ACTUALIZACION', 'Array', 'UPDATE adopcion SET estado=&#39;3&#39; WHERE id_adopcion = 5', '2022-11-05 00:05:11'),
(5, '26976183', 'Modifica Adopcion', 'ACTUALIZACION', 'Array', 'UPDATE adopcion SET estado=&#39;3&#39; WHERE id_adopcion = 5', '2022-11-05 00:10:45'),
(6, '26976183', 'Modifica Adopcion', 'ACTUALIZACION', '1', 'UPDATE adopcion SET estado=&#39;3&#39; WHERE id_adopcion = 5', '2022-11-05 00:11:15'),
(7, '26976183', 'Modifica Adopcion', 'UPDATE adopcion SET estado=&#39;3&#39; WHERE id_adopcion = 5', '3', '3', '2022-11-05 00:15:32'),
(8, '26976183', 'Modifica Adopcion', 'UPDATE adopcion SET estado=&#39;3&#39; WHERE id_adopcion = 5', '3', '3', '2022-11-05 00:17:14'),
(9, '26976183', 'Modifica Adopcion', 'UPDATE adopcion SET estado=&#39;3&#39; WHERE id_adopcion = 5', '3', '3', '2022-11-05 00:17:18'),
(10, '26976183', 'Modifica Adopcion', 'UPDATE adopcion SET estado=&#39;3&#39; WHERE id_adopcion = 5', '3', '1', '2022-11-05 00:19:59'),
(11, '26976183', 'Modifica Adopcion', 'UPDATE adopcion SET estado=3&#39; WHERE id_adopcion = 5', '3', '1', '2022-11-05 00:29:50'),
(12, '26976183', 'Modifica Adopcion', 'UPDATE adopcion SET estado=3&#39; WHERE id_adopcion = 5', '3', '3', '2022-11-05 00:29:53'),
(13, '26976183', 'Modifica Adopcion', 'UPDATE adopcion SET estado=&#39;&#39; WHERE id_adopcion = 5', '3', '3', '2022-11-05 00:35:54'),
(14, '26976183', 'Modifica Adopcion', 'UPDATE adopcion SET estado=3&#39; WHERE id_adopcion = 5', '3', '3', '2022-11-05 00:37:48'),
(15, '26976183', 'Modifica Adopcion', 'UPDATE adopcion SET estado=&#39;3&#39; WHERE id_adopcion = 5', '3', '3', '2022-11-05 00:39:07'),
(16, '26976183', 'Modifica Adopcion', 'UPDATE adopcion SET estado=&#39;3&#39; WHERE id_adopcion = 5', '3', '3', '2022-11-05 00:40:07'),
(17, '26976183', 'Modifica Adopcion', 'UPDATE adopcion SET estado=3 WHERE id_adopcion = 5', '3', '3', '2022-11-05 00:40:22'),
(18, '26976183', 'Modifica Adopcion', 'UPDATE adopcion SET estado=3 WHERE id_adopcion = 5', '3', '3', '2022-11-05 00:48:07'),
(19, '26976183', 'Modifica Adopcion', 'UPDATE adopcion SET estado=3 WHERE id_adopcion = 5', '3', '3', '2022-11-05 00:48:19'),
(20, '29517402', 'Añadir Usuario Admin', 'INSERT INTO usuarios(cedula, nombre, rol_id, direccion, contrasenia, activo, telefono) VALUES ( &#39;prueba 1005&#39;, &#39;1005&#39;, &#39;1&#39;, &#39;1005&#39;, &#39;1005&#39;, &#39;1&#39;, &#39;1005&#39;)', NULL, 'prueba 1005; 1005; 1; 1005; 1005; 1; 1005', '2022-11-05 19:30:07'),
(21, '29517402', 'Añadir Usuario Admin', 'INSERT INTO usuarios(cedula, nombre, rol_id, direccion, contrasenia, activo, telefono) VALUES ( 654981564, 654981564, 1, 654981564, v654981564, 1, 654981564)', NULL, '654981564; 654981564; 1; 654981564; v654981564; 1; 654981564', '2022-11-05 19:35:13'),
(22, '29517402', 'Añadir Tipo Animal Admin', 'INSERT INTO tipo_animal(nombre) VALUES ( Conejo)', NULL, 'Conejo', '2022-11-05 21:54:19'),
(23, '29517402', 'Añadir Tipo Animal Admin', 'INSERT INTO tipo_animal(nombre) VALUES ( Conejo)', NULL, 'Conejo', '2022-11-05 21:57:07'),
(24, '29517402', 'Añadir Tipo Animal Admin', 'INSERT INTO tipo_animal(nombre) VALUES ( loro)', NULL, 'loro', '2022-11-05 21:57:21'),
(25, '29517402', 'Añadir Tipo Animal Admin', 'INSERT INTO raza(nombre, id_tipo_animal) VALUES ( Terrier, 2)', NULL, 'Terrier; 2', '2022-11-05 22:26:24'),
(26, '29517402', 'Añadir Raza Animal Admin', 'INSERT INTO animal(nombre, anio_nac, img, descripcion, fecha_ingreso, raza_id, tamanio_id, albergue_id, visible) VALUES ( terry, 2012, 1667688509_c1a82509.jpg, Terry es muy bravo,  Now(), 6, 1, 2, 1)', NULL, 'terry; 2012; 1667688509_c1a82509.jpg; Terry es muy bravo; Now(); 6; 1; 2; 1', '2022-11-05 22:48:30'),
(27, '29517402', 'Añadir Raza Animal Admin', 'INSERT INTO animal(nombre, anio_nac, img, descripcion, fecha_ingreso, raza_id, tamanio_id, albergue_id, visible) VALUES ( oliver, 2021, 1667688623_d41e08c5.jpg, oliver es muy bravo,  Now(), 5, 1, 2, 1)', NULL, 'oliver; 2021; 1667688623_d41e08c5.jpg; oliver es muy bravo; Now(); 5; 1; 2; 1', '2022-11-05 22:50:23'),
(28, '29517402', 'Añadir Animal Admin', 'INSERT INTO animal(nombre, anio_nac, img, descripcion, fecha_ingreso, raza_id, tamanio_id, albergue_id, visible) VALUES ( Rocky, 2019, 1667689195_f58e675d.jpg, Prueba,  Now(), 2, 2, 1, 1)', NULL, 'Rocky; 2019; 1667689195_f58e675d.jpg; Prueba; Now(); 2; 2; 1; 1', '2022-11-05 22:59:55'),
(29, '29517402', 'Añadir Veterinario Admin', 'INSERT INTO veterinario(nombre, tlf, direccion, img, visible, usuario_Rveterinario) VALUES ( David, 042518859, donde sea, 1667689966_0b10db33eb028a04f465d52187028067.jpg, 1, 29517402)', NULL, 'David; 042518859; donde sea; 1667689966_0b10db33eb028a04f465d52187028067.jpg; 1; 29517402', '2022-11-05 23:12:46'),
(30, '29517402', 'Añadir Veterinario Admin', 'INSERT INTO veterinario(nombre, tlf, direccion, img, visible, usuario_Rveterinario) VALUES ( David, 042518859, donde sea, 1667690022_0b10db33eb028a04f465d52187028067.jpg, 1, 29517402)', NULL, 'David; 042518859; donde sea; 1667690022_0b10db33eb028a04f465d52187028067.jpg; 1; 29517402', '2022-11-05 23:13:43'),
(31, '29517402', 'Modifica Adopcion', 'UPDATE adopcion SET cedula=prueba2, nombre=prueba2, rol_id=1, direccion=Prueba, contrasenia=prueba, activo=1, telefono=prueba telf WHERE id_adopcion = prueba2', 'Array', 'Array', '2022-11-05 23:36:41'),
(32, '29517402', 'Modifica Usuario', 'UPDATE adopcion SET cedula=654981564, nombre=654981564qwfwqfq, rol_id=1, direccion=654981564, contrasenia=v654981564, activo=1, telefono=654981564 WHERE id_adopcion = 654981564', 'Array', 'Array', '2022-11-05 23:38:02'),
(33, '29517402', 'Modifica Usuario', 'UPDATE adopcion SET cedula=prueba 1002, nombre=1002 pruebafunciona, rol_id=1, direccion=1002, contrasenia=10021002, activo=1, telefono=1002 WHERE id_adopcion = prueba 1002', 'prueba 1002;prueba 1002;1002;1002;1;1;1002;1002;1;1;1002;1002', 'prueba 1002; prueba 1002; 1002 pruebafunciona; 1002 pruebafunciona; 1; 1; 1002; 1002; 1; 1; 1002; 10', '2022-11-05 23:48:03'),
(34, '29517402', 'Modifica Usuario', 'UPDATE animal SET nombre=Pinpon2mod8, anio_nac=2019, img=imagen.jpg, descripcion=pinpon es un muñeco, raza_id=5, tamanio_id=3, albergue_id=1, visible=1 WHERE id_animal = 8', 'Pinpon2;Pinpon2;2019;2019;imagen.jpg;imagen.jpg;pinpon es un muñeco;pinpon es un muñeco;5;5;3;3;1;1;', 'Pinpon2mod8; Pinpon2mod8; 2019; 2019; imagen.jpg; imagen.jpg; pinpon es un mu&ntilde;eco; pinpon es ', '2022-11-06 16:52:47'),
(35, '29517402', 'Modifica Veterinario Admi', 'UPDATE veterinario SET nombre=David id18, tlf=42518859, direccion=donde sea, img=imagen.jpg, visible=1 WHERE id_veterinario = 18', 'David;David;42518859;42518859;donde sea;donde sea;1667690022_0b10db33eb028a04f465d52187028067.jpg;16', 'David id18; David id18; 42518859; 42518859; donde sea; donde sea; imagen.jpg; imagen.jpg; 1; 1', '2022-11-06 16:56:44'),
(36, '29517402', 'Modifica Veterinario Admi', 'UPDATE veterinario SET nombre=David id18, tlf=42518859, direccion=donde sea, img=1667753835_0b10db33eb028a04f465d52187028067.jpg, visible=1 WHERE id_veterinario = 18', 'David id18;David id18;42518859;42518859;donde sea;donde sea;imagen.jpg;imagen.jpg;1;1', 'David id18; David id18; 42518859; 42518859; donde sea; donde sea; 1667753835_0b10db33eb028a04f465d52', '2022-11-06 16:57:15'),
(37, '29517402', 'Modifica Veterinario Admi', 'UPDATE veterinario SET nombre=David id18, tlf=42518859, direccion=donde sea, img=1667753852_0b10db33eb028a04f465d52187028067.jpg, visible=1 WHERE id_veterinario = 18', 'David id18;David id18;42518859;42518859;donde sea;donde sea;1667753835_0b10db33eb028a04f465d52187028', 'David id18; David id18; 42518859; 42518859; donde sea; donde sea; 1667753852_0b10db33eb028a04f465d52', '2022-11-06 16:57:33'),
(38, '29517402', 'Modifica Veterinario Admi', 'UPDATE veterinario SET nombre=David id18, tlf=42518859, direccion=donde sea, img=1667753852_0b10db33eb028a04f465d52187028067.jpg, visible=1 WHERE id_veterinario = 18', 'David id18;David id18;42518859;42518859;donde sea;donde sea;1667753852_0b10db33eb028a04f465d52187028', 'David id18; David id18; 42518859; 42518859; donde sea; donde sea; 1667753852_0b10db33eb028a04f465d52', '2022-11-06 17:01:13'),
(39, '29517402', 'Modifica Veterinario Admi', 'UPDATE veterinario SET nombre=David id18, tlf=42518859, direccion=donde sea, img=1667753852_0b10db33eb028a04f465d52187028067.jpg, visible=1 WHERE id_veterinario = 18', 'David id18;David id18;42518859;42518859;donde sea;donde sea;1667753852_0b10db33eb028a04f465d52187028', 'David id18; David id18; 42518859; 42518859; donde sea; donde sea; 1667753852_0b10db33eb028a04f465d52', '2022-11-06 17:01:23'),
(40, '29517402', 'Modifica Veterinario Admi', 'UPDATE veterinario SET nombre=David id18, tlf=42518859, direccion=donde sea, img=1667754123_0b10db33eb028a04f465d52187028067.jpg, visible=1 WHERE id_veterinario = 18', 'David id18;David id18;42518859;42518859;donde sea;donde sea;1667753852_0b10db33eb028a04f465d52187028', 'David id18; David id18; 42518859; 42518859; donde sea; donde sea; 1667754123_0b10db33eb028a04f465d52', '2022-11-06 17:02:03'),
(41, '29517402', 'Modifica Veterinario Admi', 'UPDATE veterinario SET nombre=David, tlf=42518859, direccion=donde sea, img=imagen.jpg, visible=1 WHERE id_veterinario = 17', 'David;David;42518859;42518859;donde sea;donde sea;1667689966_0b10db33eb028a04f465d52187028067.jpg;16', 'David; David; 42518859; 42518859; donde sea; donde sea; imagen.jpg; imagen.jpg; 1; 1', '2022-11-06 17:03:05'),
(42, '29517402', 'Modifica Veterinario Admi', 'UPDATE veterinario SET nombre=David id18, tlf=42518859, direccion=donde sea, img=1667754123_0b10db33eb028a04f465d52187028067.jpg, visible=1 WHERE id_veterinario = 18', 'David id18;David id18;42518859;42518859;donde sea;donde sea;1667754123_0b10db33eb028a04f465d52187028', 'David id18; David id18; 42518859; 42518859; donde sea; donde sea; 1667754123_0b10db33eb028a04f465d52', '2022-11-06 17:05:48'),
(43, '29517402', 'Modifica Veterinario Admi', 'UPDATE veterinario SET nombre=David id18, tlf=42518859, direccion=donde sea, img=1667754123_0b10db33eb028a04f465d52187028067.jpg, visible=1 WHERE id_veterinario = 18', 'David id18;David id18;42518859;42518859;donde sea;donde sea;1667754123_0b10db33eb028a04f465d52187028', 'David id18; David id18; 42518859; 42518859; donde sea; donde sea; 1667754123_0b10db33eb028a04f465d52', '2022-11-06 17:06:39'),
(44, '29517402', 'Modifica Veterinario Admi', 'UPDATE veterinario SET nombre=David id18, tlf=42518859, direccion=donde sea, img=1667754123_0b10db33eb028a04f465d52187028067.jpg, visible=1 WHERE id_veterinario = 18', 'David id18;David id18;42518859;42518859;donde sea;donde sea;1667754123_0b10db33eb028a04f465d52187028', 'David id18; David id18; 42518859; 42518859; donde sea; donde sea; 1667754123_0b10db33eb028a04f465d52', '2022-11-06 17:07:52'),
(45, '29517402', 'Modifica Veterinario Admi', 'UPDATE veterinario SET nombre=David id18, tlf=42518859, direccion=donde sea, img=1667754123_0b10db33eb028a04f465d52187028067.jpg, visible=1 WHERE id_veterinario = 18', 'David id18;David id18;42518859;42518859;donde sea;donde sea;1667754123_0b10db33eb028a04f465d52187028', 'David id18; David id18; 42518859; 42518859; donde sea; donde sea; 1667754123_0b10db33eb028a04f465d52', '2022-11-06 17:08:39'),
(46, '29517402', 'Modifica Veterinario Admi', 'UPDATE veterinario SET nombre=David id18, tlf=42518859, direccion=donde sea, img=1667754123_0b10db33eb028a04f465d52187028067.jpg, visible=1 WHERE id_veterinario = 18', 'David id18;David id18;42518859;42518859;donde sea;donde sea;1667754123_0b10db33eb028a04f465d52187028', 'David id18; David id18; 42518859; 42518859; donde sea; donde sea; 1667754123_0b10db33eb028a04f465d52', '2022-11-06 17:10:46'),
(47, '29517402', 'Modifica Veterinario Admi', 'UPDATE veterinario SET nombre=David id18, tlf=42518859, direccion=donde sea, img=1667755069_6db8fd93.jpg, visible=1 WHERE id_veterinario = 18', 'David id18;David id18;42518859;42518859;donde sea;donde sea;1667754123_0b10db33eb028a04f465d52187028', 'David id18; David id18; 42518859; 42518859; donde sea; donde sea; 1667755069_6db8fd93.jpg; 166775506', '2022-11-06 17:17:49'),
(48, '29517402', 'Modifica Veterinario Admi', 'UPDATE veterinario SET nombre=David, tlf=42518859, direccion=donde sea, img=1667755235_85d4d82f.jpg, visible=1 WHERE id_veterinario = 17', 'David;David;42518859;42518859;donde sea;donde sea;imagen.jpg;imagen.jpg;1;1', 'David; David; 42518859; 42518859; donde sea; donde sea; 1667755235_85d4d82f.jpg; 1667755235_85d4d82f', '2022-11-06 17:20:35'),
(49, '29517402', 'Modifica Veterinario Admi', 'UPDATE veterinario SET nombre=David, tlf=42518859, direccion=donde sea, img=1667755430_8c5b0c49a2b2c6ccaf9a38ed8f8565ff.jpg, visible=1 WHERE id_veterinario = 17', 'David;David;42518859;42518859;donde sea;donde sea;1667755235_85d4d82f.jpg;1667755235_85d4d82f.jpg;1;', 'David; David; 42518859; 42518859; donde sea; donde sea; 1667755430_8c5b0c49a2b2c6ccaf9a38ed8f8565ff.', '2022-11-06 17:23:50'),
(50, '29517402', 'Modifica Tipo Animal admin', 'UPDATE tipo_animal SET nombre=Conejo2 WHERE id_tipo = 7', 'Conejo;Conejo', 'Conejo2; Conejo2', '2022-11-06 17:30:23'),
(51, '29517402', 'Modifica Raza Animal Admin', 'UPDATE raza SET nombre=Persa2, id_tipo_animal=3 WHERE id_raza = 4', 'Persa;Persa;3;3', 'Persa2; Persa2; 3; 3', '2022-11-06 17:32:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `raza`
--

CREATE TABLE `raza` (
  `id_raza` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `id_tipo_animal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `raza`
--

INSERT INTO `raza` (`id_raza`, `nombre`, `id_tipo_animal`) VALUES
(2, 'chihuahua', 2),
(3, 'Bulldog', 2),
(4, 'Persa2', 3),
(5, 'Kohana', 3),
(6, 'Terrier', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tamanio`
--

INSERT INTO `tamanio` (`id_tamanio`, `nombre`) VALUES
(1, 'Pequenio'),
(2, 'Mediano'),
(3, 'Grande');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_animal`
--

CREATE TABLE `tipo_animal` (
  `id_tipo` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_animal`
--

INSERT INTO `tipo_animal` (`id_tipo`, `nombre`) VALUES
(2, 'Perro'),
(3, 'Gato'),
(4, 'Cocodrilo'),
(5, 'Ardilla'),
(6, 'Conejo'),
(7, 'Conejo2'),
(8, 'loro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_estado_adopcion`
--

CREATE TABLE `tipo_estado_adopcion` (
  `id_tipo_estado` int(11) NOT NULL,
  `nombre_estado` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `cedula` varchar(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `contrasenia` varchar(1000) NOT NULL,
  `activo` int(1) NOT NULL,
  `telefono` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`cedula`, `nombre`, `rol_id`, `direccion`, `contrasenia`, `activo`, `telefono`) VALUES
('12345678', 'Merry', 2, 'donde sea', '123456789', 0, ''),
('123456789', 'Merry', 2, 'donde sea', '123456789', 1, ''),
('15597525', 'Anavilera', 2, 'Cabudare', '123456', 1, ''),
('222222', 'Polipropeludos', 3, 'no se', 'fundacion', 1, ''),
('26976183', 'David', 3, 'Carr 18 calle 55', 'chicho', 1, '1212121212'),
('29517402', 'Douglas', 1, 'Carr 18 con calle 55', 'lolcoptero', 1, ''),
('456456456', 'Torres', 2, 'vargas', '123456', 1, '04245936421'),
('654981564', '654981564qwfwqfq', 1, '654981564', 'v654981564', 1, '654981564'),
('9624925', 'Javier', 2, 'Carr 18', '123456789', 1, ''),
('Polipropelu', 'Polipropeludos', 3, 'Prueba', 'Polipropelu', 1, '04245936421'),
('prueba', 'pruebauser', 1, 'direccion', 'prueba', 1, 'prueba'),
('prueba 1001', '1001', 1, '1001', '1001', 1, '1001'),
('prueba 1002', '1002 pruebafunciona', 1, '1002', '10021002', 1, '1002'),
('prueba 1003', '1003', 1, '1003', '100210023123', 1, '100212321'),
('prueba 1004', '1004', 1, '1004', '100210023123', 1, '100212321'),
('prueba 1005', '1005', 1, '1005', '1005', 1, '1005'),
('prueba100', 'prueba100', 1, 'prueba100', 'prueba100', 1, 'prueba100'),
('prueba1000', 'prueba100', 1, 'prueba100', 'prueba100', 1, 'prueba100'),
('prueba2', 'prueba2', 1, 'Prueba', 'prueba', 1, 'prueba telf'),
('prueba3', 'prueba3', 1, 'Prueba3', 'prueba3', 1, 'prueba3'),
('prueba4', 'prueba4', 1, 'Prueba4', 'prueba4', 1, 'prueba4'),
('prueba5', 'prueba5', 1, 'prueba5', 'prueba5', 1, 'prueba5'),
('prueba6', 'prueba6', 1, 'prueba6', 'prueba6', 1, 'prueba6');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `veterinario`
--

CREATE TABLE `veterinario` (
  `id_veterinario` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `tlf` int(11) NOT NULL,
  `direccion` varchar(55) NOT NULL,
  `img` varchar(1000) NOT NULL,
  `visible` int(1) NOT NULL,
  `usuario_Rveterinario` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `veterinario`
--

INSERT INTO `veterinario` (`id_veterinario`, `nombre`, `tlf`, `direccion`, `img`, `visible`, `usuario_Rveterinario`) VALUES
(1, 'Andreina23232', 251445645, '0', 'imagen.jpg', 1, '29517402'),
(2, 'Andreina', 251445645, '0', '1666545072_8c5b0c49a2b2c6ccaf9a38ed8f8565ff.jpg', 1, '29517402'),
(3, 'Sueter', 451, '0', 'imagen.jpg', 1, '29517402'),
(4, 'Sueter', 451, '0', 'imagen.jpg', 1, '29517402'),
(5, 'Sueter', 451, '0', 'imagen.jpg', 1, '29517402'),
(6, 'Sueter', 451, '0', 'imagen.jpg', 1, '29517402'),
(7, 'Sueter', 451, 'vargas', 'imagen.jpg', 1, '29517402'),
(8, 'Sueter', 451, 'vargas', 'imagen.jpg', 1, '29517402'),
(9, '', 451, 'vargas', 'imagen.jpg', 1, '29517402'),
(10, '', 2147483647, 'donde sea', 'imagen.jpg', 1, '29517402'),
(11, '', 2147483647, 'donde sea', 'imagen.jpg', 1, '29517402'),
(12, '', 2147483647, 'donde sea', 'imagen.jpg', 1, '29517402'),
(13, '', 2147483647, 'donde sea', 'imagen.jpg', 1, '29517402'),
(14, 'Merry', 2147483647, 'Carrera 18 calle 55', 'imagen.jpg', 1, '29517402'),
(15, 'Merry', 2147483647, 'Carrera 18 calle 55', 'imagen.jpg', 1, '29517402'),
(16, 'Merry', 2147483647, 'Carrera 18 calle 55', 'imagen.jpg', 1, '29517402'),
(17, 'David', 42518859, 'donde sea', '1667755430_8c5b0c49a2b2c6ccaf9a38ed8f8565ff.jpg', 1, '29517402'),
(18, 'David id18', 42518859, 'donde sea', '1667755069_6db8fd93.jpg', 1, '29517402');

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
  MODIFY `id_adopcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `albergue`
--
ALTER TABLE `albergue`
  MODIFY `id_albergue` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `animal`
--
ALTER TABLE `animal`
  MODIFY `id_animal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `bitacoras`
--
ALTER TABLE `bitacoras`
  MODIFY `id_bitacora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `raza`
--
ALTER TABLE `raza`
  MODIFY `id_raza` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tipo_estado_adopcion`
--
ALTER TABLE `tipo_estado_adopcion`
  MODIFY `id_tipo_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `veterinario`
--
ALTER TABLE `veterinario`
  MODIFY `id_veterinario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
