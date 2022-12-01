-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-12-2022 a las 02:54:48
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
  `cedula_usuario` varchar(9) NOT NULL,
  `estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `albergue`
--

INSERT INTO `albergue` (`id_albergue`, `nombre`, `direccion`, `cedula_usuario`, `activo`) VALUES
(1, 'Unexpo', ' Avenida Corpahuaico entre Avenida La Salle', '12597525', 0),
(2, 'Ucla', 'Carrera 18 entre calle 55', '26976183', 1),
(3, 'Ucla 2', 'Carrera 18 entre calle 55', '12597525', 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `animal`
--

INSERT INTO `animal` (`id_animal`, `nombre`, `anio_nac`, `img`, `descripcion`, `fecha_ingreso`, `raza_id`, `tamanio_id`, `albergue_id`, `visible`) VALUES
(1, 'Antonella', '2012', 'anto.jpeg', 'Obediente, pero tiene mucha energía así que debe se le deberia pasear bastante', '2022-11-05', 5, 1, 2, 1),
(2, 'Dylan', '2021', 'dylan.jpeg', 'oliver es muy bravo', '2022-11-05', 4, 1, 2, 1),
(3, 'Rocky', '2019', 'imagen.jpg', 'Prueba', '2022-11-05', 1, 2, 1, 0),
(4, 'Juan', '2022', 'juan.jpeg', 'Esto es otra prueba', '2022-11-12', 3, 1, 3, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bitacoras`
--

INSERT INTO `bitacoras` (`id_bitacora`, `usuario_bit`, `modulo_afectado`, `accion_realizada`, `valor_anterior`, `valor_actual`, `fecha_accion`) VALUES
(1, '29517502', 'Modifica Tipo Animal admin', 'UPDATE tipo_animal SET nombre=Perros WHERE id_tipo = 1', 'Perro;Perro', 'Perros; Perros', '2022-11-30 22:02:36'),
(2, '29517502', 'Modifica Tipo Animal admin', 'UPDATE tipo_animal SET nombre=Perro WHERE id_tipo = 1', 'Perros;Perros', 'Perro; Perro', '2022-11-30 22:02:42'),
(3, '29517502', 'AÃ±adir Raza Animal Admin', 'INSERT INTO raza(nombre, id_tipo_animal) VALUES ( Puddle, 1)', NULL, 'Puddle; 1', '2022-12-01 01:32:35'),
(4, '29517502', 'Modifica Raza Animal Admin', 'UPDATE raza SET nombre=Chihawa, id_tipo_animal=1 WHERE id_raza = &#39;1&#39;', 'Chihauha;Chihauha;1;1', 'Chihawa; Chihawa; 1; 1', '2022-12-01 01:32:44'),
(5, '29517502', 'Modifica Usuario', 'UPDATE albergue SET nombre=Unexpo, direccion=Carrera 18 calle 55, cedula_usuario=29517402j, activo=0 WHERE id_albergue = 1', 'Unexpo;Unexpo;Carrera 18 calle 55;Carrera 18 calle 55;26976183;26976183;0;0', 'Unexpo; Unexpo; Carrera 18 calle 55; Carrera 18 calle 55; 29517402j; 29517402j; 0; 0', '2022-12-01 01:36:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `raza`
--

CREATE TABLE `raza` (
  `id_raza` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `id_tipo_animal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `raza`
--

INSERT INTO `raza` (`id_raza`, `nombre`, `id_tipo_animal`) VALUES
(1, 'Chihawa', 1),
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
  `nombre` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tamanio`
--

INSERT INTO `tamanio` (`id_tamanio`, `nombre`) VALUES
(1, 'Pequeño'),
(2, 'Mediano'),
(3, 'Grande');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_animal`
--

CREATE TABLE `tipo_animal` (
  `id_tipo` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `nombre_estado` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `telefono` varchar(20) NOT NULL,
  `detalles` varchar(255) NOT NULL DEFAULT 'Registro Usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`cedula`, `nombre`, `rol_id`, `direccion`, `contrasenia`, `activo`, `telefono`, `detalles`) VALUES
('12597125', 'Javier', 2, 'Carr 18 con calle 55', '123456789', 1, '04245936421', 'Registro Usuario'),
('12597525', 'Uclalipeludos', 3, 'Carr 18 con calle 55', 'fundacion', 1, '04245936421', 'Registro Usuario'),
('12597535', 'Torres', 2, 'Carr 18 con calle 55', '123456', 1, '04245936421', 'Registro Usuario'),
('15597525', 'Anavilera', 2, 'Carr 18 con calle 55', '123456', 1, '04245936421', 'Registro Usuario'),
('26976183', 'David', 3, 'Carr 18 con calle 55', 'chicho', 1, '1212121212', 'Registro Usuario'),
('29517202', 'Polipropeludos', 3, 'Carr 18 con calle 55', 'prueba', 1, '04245936421', 'Registro Usuario'),
('29517402', 'Douglas', 1, 'Carr 18 con calle 55', 'lolcoptero', 1, '04245936421', 'Registro Usuario'),
('29517502', 'Prueba', 1, 'Carr 18 con calle 55', 'prueba', 1, '04245936421', 'Registro Usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `veterinario`
--

CREATE TABLE `veterinario` (
  `id_veterinario` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `tlf` int(15) NOT NULL,
  `direccion` varchar(55) NOT NULL,
  `img` varchar(1000) NOT NULL,
  `visible` int(1) NOT NULL,
  `usuario_Rveterinario` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `veterinario`
--

INSERT INTO `veterinario` (`id_veterinario`, `nombre`, `tlf`, `direccion`, `img`, `visible`, `usuario_Rveterinario`) VALUES
(1, 'Andreina', 42518859, 'Carrera 18 calle 55', 'imagen.jpg', 1, '29517402'),
(2, 'Merry', 42518859, 'Carrera 18 calle 55', 'imagen.jpg', 1, '29517402'),
(3, 'David', 42518859, 'Carrera 18 calle 55', 'imagen.jpg', 1, '29517402');

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
  MODIFY `id_albergue` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `animal`
--
ALTER TABLE `animal`
  MODIFY `id_animal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `bitacoras`
--
ALTER TABLE `bitacoras`
  MODIFY `id_bitacora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT de la tabla `raza`
--
ALTER TABLE `raza`
  MODIFY `id_raza` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
