-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-10-2022 a las 23:09:53
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
(1, 'albergue1', 'Carrera 18 calle 55', '222222', 1);

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
(1, 'Pinpon', '2019', '1665946249_4f83f853.jpg', 'pinpon es un muñeco', '0000-00-00', 2, 1, 1, 1),
(2, 'Pinpon', '2019', '1665946339_4f83f853.jpg', 'pinpon es un muñeco', '0000-00-00', 2, 1, 1, 1),
(3, 'Pinpon', '2019', '1665946459_4f83f853.jpg', 'pinpon es un muñeco', '0000-00-00', 2, 1, 1, 1),
(4, 'Merry', '2019', '1665947240_0f10aa96.jpg', 'pinpon es un muñeco', '2022-10-16', 2, 2, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacoras`
--

CREATE TABLE `bitacoras` (
  `id_bitacora` int(11) NOT NULL,
  `usuario_bit` varchar(11) NOT NULL,
  `modulo_afectado` varchar(25) NOT NULL,
  `accion_realizada` varchar(25) NOT NULL,
  `valor_anterior` varchar(255) DEFAULT NULL,
  `valor_actual` varchar(255) NOT NULL,
  `fecha_accion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `img` varchar(1000) NOT NULL,
  `tipo_producto_id` int(11) NOT NULL,
  `tienda_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(3, 'bulldog', 2),
(4, 'Persa', 3),
(5, 'Kohana', 3);

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
-- Estructura de tabla para la tabla `tienda`
--

CREATE TABLE `tienda` (
  `id_tienda` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `rif` varchar(255) NOT NULL,
  `cedula_usuarios` varchar(9) NOT NULL,
  `img` varchar(1000) NOT NULL,
  `contacto` varchar(255) NOT NULL,
  `fecha_ingreso` date NOT NULL DEFAULT current_timestamp(),
  `visible` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(5, 'Cocodrilo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_estado_adopcion`
--

CREATE TABLE `tipo_estado_adopcion` (
  `id_tipo_estado` int(11) NOT NULL,
  `nombre_estado` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_producuto`
--

CREATE TABLE `tipo_producuto` (
  `id_tipo_producto` int(11) NOT NULL,
  `nombre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `cedula` varchar(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `contrasenia` varchar(20) NOT NULL,
  `activo` int(1) NOT NULL,
  `telefono` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`cedula`, `nombre`, `rol_id`, `direccion`, `contrasenia`, `activo`, `telefono`) VALUES
('12345678', 'Merry', 2, 'donde sea', '123456789', 1, ''),
('123456789', 'Merry', 2, 'donde sea', '123456789', 1, ''),
('15597525', 'Anavilera', 2, 'Cabudare', '123456', 1, ''),
('222222', 'Polipropeludos', 3, 'no se', 'fundacion', 1, ''),
('26976183', 'David', 2, 'Carr 18 calle 55', 'chicho', 0, ''),
('29517402', 'Douglas', 1, 'Carr 18 con calle 55', 'lolcoptero', 1, ''),
('456456456', 'Torres', 2, 'vargas', '123456', 1, '04245936421'),
('9624925', 'Javier', 2, 'Carr 18', '123456789', 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `veterinario`
--

CREATE TABLE `veterinario` (
  `id_veterinario` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `tlf` int(11) NOT NULL,
  `direccion` int(11) NOT NULL,
  `img` varchar(1000) NOT NULL,
  `visible` int(1) NOT NULL,
  `usuario_Rveterinario` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `tipo_producto_id` (`tipo_producto_id`),
  ADD KEY `tienda_id` (`tienda_id`);

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
-- Indices de la tabla `tienda`
--
ALTER TABLE `tienda`
  ADD PRIMARY KEY (`id_tienda`),
  ADD KEY `cedula_usuarios` (`cedula_usuarios`);

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
-- Indices de la tabla `tipo_producuto`
--
ALTER TABLE `tipo_producuto`
  ADD PRIMARY KEY (`id_tipo_producto`);

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
  MODIFY `id_adopcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `albergue`
--
ALTER TABLE `albergue`
  MODIFY `id_albergue` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `animal`
--
ALTER TABLE `animal`
  MODIFY `id_animal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `bitacoras`
--
ALTER TABLE `bitacoras`
  MODIFY `id_bitacora` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `raza`
--
ALTER TABLE `raza`
  MODIFY `id_raza` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- AUTO_INCREMENT de la tabla `tienda`
--
ALTER TABLE `tienda`
  MODIFY `id_tienda` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_animal`
--
ALTER TABLE `tipo_animal`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipo_estado_adopcion`
--
ALTER TABLE `tipo_estado_adopcion`
  MODIFY `id_tipo_estado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_producuto`
--
ALTER TABLE `tipo_producuto`
  MODIFY `id_tipo_producto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `veterinario`
--
ALTER TABLE `veterinario`
  MODIFY `id_veterinario` int(11) NOT NULL AUTO_INCREMENT;

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
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`tipo_producto_id`) REFERENCES `tipo_producuto` (`id_tipo_producto`) ON UPDATE CASCADE,
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`tienda_id`) REFERENCES `tienda` (`id_tienda`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `raza`
--
ALTER TABLE `raza`
  ADD CONSTRAINT `raza_ibfk_1` FOREIGN KEY (`id_tipo_animal`) REFERENCES `tipo_animal` (`id_tipo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `tienda`
--
ALTER TABLE `tienda`
  ADD CONSTRAINT `tienda_ibfk_1` FOREIGN KEY (`cedula_usuarios`) REFERENCES `usuarios` (`cedula`) ON DELETE CASCADE ON UPDATE CASCADE;

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
