-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-09-2022 a las 22:39:55
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
  `cedula_usuario` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albergue`
--

CREATE TABLE `albergue` (
  `id_albergue` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `cedula_usuario` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `animal`
--

CREATE TABLE `animal` (
  `id_animal` int(11) NOT NULL,
  `nombre` varchar(55) NOT NULL,
  `edad` int(11) NOT NULL,
  `img` varchar(1000) NOT NULL,
  `detalles` text NOT NULL,
  `fecha_ingreso` date NOT NULL DEFAULT current_timestamp(),
  `raza_id` int(11) NOT NULL,
  `tamanio_id` int(11) NOT NULL,
  `albergue_id` int(11) NOT NULL
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
  `nombre` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tamanio`
--

CREATE TABLE `tamanio` (
  `id_tamanio` int(11) NOT NULL,
  `nombre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `fecha_ingreso` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_animal`
--

CREATE TABLE `tipo_animal` (
  `id_tipo` int(11) NOT NULL,
  `raza_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
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
  `cedula` varchar(9) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `contrasenia` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `veterinario`
--

CREATE TABLE `veterinario` (
  `id_veterinario` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `tlf` int(11) NOT NULL,
  `direccion` int(11) NOT NULL,
  `img` varchar(1000) NOT NULL
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
  ADD KEY `cedula_usuario` (`cedula_usuario`);

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
  ADD PRIMARY KEY (`id_raza`);

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
  ADD PRIMARY KEY (`id_tipo`),
  ADD KEY `raza_id` (`raza_id`);

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
  ADD PRIMARY KEY (`id_veterinario`);

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
  MODIFY `id_albergue` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `animal`
--
ALTER TABLE `animal`
  MODIFY `id_animal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `raza`
--
ALTER TABLE `raza`
  MODIFY `id_raza` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tamanio`
--
ALTER TABLE `tamanio`
  MODIFY `id_tamanio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tienda`
--
ALTER TABLE `tienda`
  MODIFY `id_tienda` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_animal`
--
ALTER TABLE `tipo_animal`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `adopcion_ibfk_2` FOREIGN KEY (`cedula_usuario`) REFERENCES `usuarios` (`cedula`) ON UPDATE CASCADE;

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
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`tipo_producto_id`) REFERENCES `tipo_producuto` (`id_tipo_producto`) ON UPDATE CASCADE,
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`tienda_id`) REFERENCES `tienda` (`id_tienda`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tienda`
--
ALTER TABLE `tienda`
  ADD CONSTRAINT `tienda_ibfk_1` FOREIGN KEY (`cedula_usuarios`) REFERENCES `usuarios` (`cedula`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tipo_animal`
--
ALTER TABLE `tipo_animal`
  ADD CONSTRAINT `tipo_animal_ibfk_1` FOREIGN KEY (`raza_id`) REFERENCES `raza` (`id_raza`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id_rol`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
