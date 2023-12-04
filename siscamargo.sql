-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-09-2023 a las 17:40:56
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
-- Base de datos: `siscamargo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acceso`
--

CREATE TABLE `acceso` (
  `idperfil` int(11) NOT NULL,
  `idopcion` int(11) NOT NULL,
  `estado` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `acceso`
--

INSERT INTO `acceso` (`idperfil`, `idopcion`, `estado`) VALUES
(1, 1, 1),
(1, 2, 1),
(1, 3, 1),
(1, 4, 1),
(1, 5, 1),
(1, 6, 1),
(1, 7, 1),
(2, 5, 1),
(2, 6, 1),
(2, 7, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitacion`
--

CREATE TABLE `habitacion` (
  `id_habitacion` int(11) NOT NULL,
  `codigohabitacion` varchar(10) NOT NULL,
  `id_tipohabitacion` tinyint(4) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `habitacion`
--

INSERT INTO `habitacion` (`id_habitacion`, `codigohabitacion`, `id_tipohabitacion`, `estado`) VALUES
(1, '1A', 1, 1),
(2, '2B', 2, 1),
(3, '3C', 3, 1),
(4, '4D', 1, 1),
(5, '5E', 2, 1),
(6, '6A', 3, 1),
(7, '7B', 1, 1),
(8, '8C', 3, 1),
(9, '9D', 1, 1),
(10, '10E', 2, 1),
(11, '11A', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hospedaje`
--

CREATE TABLE `hospedaje` (
  `id_hospedaje` int(11) NOT NULL,
  `fechaingreso` date NOT NULL,
  `fechasalida` date NOT NULL,
  `horaingreso` time NOT NULL,
  `horasalida` time NOT NULL,
  `id_habitacion` int(11) NOT NULL,
  `observacion` text NOT NULL,
  `estado` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `hospedaje`
--

INSERT INTO `hospedaje` (`id_hospedaje`, `fechaingreso`, `fechasalida`, `horaingreso`, `horasalida`, `id_habitacion`, `observacion`, `estado`) VALUES
(1, '2023-09-10', '2023-09-19', '20:45:00', '20:45:00', 1, '', 1),
(3, '2023-09-09', '2023-09-11', '13:00:00', '13:00:00', 2, '', 1),
(5, '2023-09-09', '2023-09-12', '10:30:00', '10:30:00', 3, '', 1),
(6, '2023-09-11', '2023-09-12', '15:00:00', '15:00:00', 1, '', 0),
(7, '2023-09-19', '2023-09-22', '10:00:00', '10:00:00', 1, 'La habitación no fue cancelada ', 1),
(8, '2023-09-19', '2023-09-22', '16:00:00', '16:00:00', 4, 'El huésped no recogió una mochila', 1),
(9, '2023-09-21', '2023-09-24', '09:09:00', '09:09:00', 2, 'Ninguna', 1),
(10, '2023-09-21', '2023-09-23', '20:46:00', '20:46:00', 3, 'Ninguna', 1),
(11, '2023-09-21', '2023-09-23', '20:50:00', '20:50:00', 6, 'Ninguna', 1),
(12, '2023-09-21', '2023-09-22', '20:50:00', '20:51:00', 7, 'Ninguna', 1),
(13, '2023-09-22', '2023-09-24', '12:25:00', '12:25:00', 8, 'Ninguna', 1),
(14, '2023-09-24', '2023-09-26', '10:04:00', '10:04:00', 1, 'Ninguna', 1),
(15, '2023-09-23', '2023-09-27', '10:05:00', '10:05:00', 2, 'Ninguna', 1),
(16, '2023-09-24', '2023-09-29', '15:07:00', '15:07:00', 3, 'Sin obervaciones', 1),
(17, '2023-09-22', '2023-09-25', '14:10:00', '14:10:00', 4, 'No hay', 1),
(18, '2023-09-26', '2023-09-28', '18:54:00', '18:54:00', 1, '', 1),
(19, '2023-09-26', '2023-09-29', '22:27:00', '22:27:00', 5, '', 1),
(20, '2023-09-26', '2023-09-26', '06:30:00', '06:30:00', 6, 'No hay', 1),
(21, '2023-09-27', '2023-09-28', '10:24:00', '10:24:00', 7, 'Ninguna', 1),
(22, '2023-09-28', '2023-09-30', '05:30:00', '11:00:00', 1, 'No hay', 1),
(23, '2023-09-28', '2023-10-01', '11:00:00', '11:00:00', 2, '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hospedar`
--

CREATE TABLE `hospedar` (
  `id_hospedar` int(11) NOT NULL,
  `id_huesped` smallint(6) NOT NULL,
  `procedencia` varchar(200) NOT NULL,
  `id_hospedaje` smallint(6) NOT NULL,
  `estado` smallint(6) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `hospedar`
--

INSERT INTO `hospedar` (`id_hospedar`, `id_huesped`, `procedencia`, `id_hospedaje`, `estado`) VALUES
(1, 1, 'Santa cruz', 1, 2),
(2, 1, 'Tarija', 5, 1),
(3, 5, 'Lima, peru', 5, 1),
(5, 2, 'Brasileia', 3, 1),
(6, 4, 'Cochabamba', 1, 1),
(7, 1, 'La paz', 6, 1),
(8, 3, 'Cochabamba', 1, 1),
(9, 1, 'La paz', 1, 2),
(10, 1, 'Cochabamba', 1, 1),
(11, 9, 'Santa cruz', 7, 1),
(12, 6, 'La paz', 8, 1),
(13, 10, 'Beni', 9, 1),
(14, 14, 'Beni', 9, 1),
(15, 17, 'La paz', 10, 1),
(16, 16, 'La paz', 10, 1),
(17, 20, 'Beni', 11, 1),
(18, 19, 'Beni', 11, 1),
(19, 18, 'Santa cruz', 12, 1),
(20, 22, 'Cochabamba', 13, 1),
(21, 21, 'Cochabamba', 13, 1),
(22, 22, 'La paz', 14, 1),
(23, 21, 'Santa cruz', 15, 1),
(24, 20, 'Beni', 16, 1),
(25, 19, 'Tarija', 17, 1),
(26, 18, 'Tarija', 17, 1),
(27, 2, 'Lima', 18, 1),
(28, 1, 'La paz', 18, 1),
(29, 12, 'La paz', 19, 1),
(30, 10, 'La paz', 19, 1),
(31, 3, 'Brasileia', 20, 1),
(32, 23, 'Santa cruz', 21, 1),
(33, 23, 'La paz', 22, 1),
(34, 22, 'La paz', 22, 1),
(35, 19, 'La paz', 23, 1),
(36, 18, 'La paz', 23, 1),
(37, 15, 'La paz', 23, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `huesped`
--

CREATE TABLE `huesped` (
  `id_huesped` int(11) NOT NULL,
  `nombcomp` varchar(100) NOT NULL,
  `nrodocumento` int(10) NOT NULL,
  `id_tipodocumento` tinyint(1) NOT NULL,
  `fenac` date NOT NULL,
  `id_nacionalidad` smallint(6) NOT NULL,
  `profesion` varchar(50) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `huesped`
--

INSERT INTO `huesped` (`id_huesped`, `nombcomp`, `nrodocumento`, `id_tipodocumento`, `fenac`, `id_nacionalidad`, `profesion`, `estado`) VALUES
(1, 'Patricia Fernández', 8569743, 1, '2000-09-17', 1, 'Medico', 1),
(2, 'Ana Martínez', 2038176, 2, '2003-09-10', 2, 'Medico', 1),
(3, 'Manuel Torres', 987654321, 3, '2001-09-06', 3, 'Ing. Ambiental', 1),
(4, 'Carmen García', 7123456, 1, '2000-07-06', 1, 'Profesora', 1),
(5, 'Juan Pérez', 8690327, 3, '1997-04-16', 2, 'Chofer', 1),
(6, 'María Rodríguez Pérez', 4251768, 1, '1990-08-15', 1, 'Profesora', 1),
(7, 'Juan García López', 9384021, 1, '1983-12-08', 1, 'Medico', 1),
(8, 'Ana Martínez Fernández', 5678910, 1, '1986-11-12', 1, 'Ing. Comercial', 1),
(9, 'Carlos Sánchez González', 6543201, 1, '1977-05-18', 1, 'Ing. Civil', 1),
(10, 'Laura López Ruiz', 7894561, 1, '1976-07-08', 1, 'Medico', 1),
(11, 'Alejandro José Martínez Ramírez', 9876543, 1, '1890-04-25', 1, 'Abogado', 1),
(12, 'María Fernanda Rodríguez López', 8765432, 1, '1978-12-17', 1, 'Médico', 1),
(13, 'Ana Isabel López Sánchez', 7654321, 1, '1993-03-07', 1, 'Contador', 1),
(14, 'Luis Antonio Torres Mendoza', 3456789, 1, '1999-02-19', 1, 'Arquitecto', 1),
(15, 'Carmen Elena Ortiz Jiménez', 4567890, 1, '1985-05-23', 1, 'Policía', 1),
(16, 'Juan Carlos Rodríguez', 9876500, 1, '1990-07-11', 1, 'Médico', 1),
(17, 'Ana María Pérez', 4567110, 1, '1988-09-20', 1, 'Ingeniero de Software', 1),
(18, 'Luis García Martínez', 4328765, 1, '1978-04-05', 1, 'Profesor de Historia', 1),
(19, 'Laura González López', 2345678, 1, '1991-09-07', 1, 'Chef de Cocina', 1),
(20, 'Pedro Sánchez Fernández', 4321765, 1, '1984-05-29', 1, 'Abogado', 1),
(21, 'María García Pérez', 5789234, 1, '1979-06-15', 1, 'Médico', 1),
(22, 'Juan Rodríguez López', 9876540, 1, '1990-02-01', 1, 'Ingeniero de software', 1),
(23, 'Rosa Jiménez Martín', 5916770, 1, '2023-09-28', 1, 'Contadora', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nacionalidad`
--

CREATE TABLE `nacionalidad` (
  `id_nacionalidad` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `estado` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `nacionalidad`
--

INSERT INTO `nacionalidad` (`id_nacionalidad`, `nombre`, `estado`) VALUES
(1, 'Bolivia', 1),
(2, 'Peru', 1),
(3, 'Brasil', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opcion`
--

CREATE TABLE `opcion` (
  `idopcion` int(11) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `icono` varchar(20) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `estado` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `opcion`
--

INSERT INTO `opcion` (`idopcion`, `descripcion`, `icono`, `url`, `estado`) VALUES
(1, 'Perfiles', 'fa-user-circle', 'vista/perfiles.php', 1),
(2, 'Usuarios', 'fa-user-lock', 'vista/usuarios.php', 1),
(3, 'Tipos de Habitacion', 'fa-tags', 'vista/tipohabitacion.php', 1),
(4, 'Habitaciones', 'fa-hotel', 'vista/habitaciones.php', 1),
(5, 'Hospedajes', 'fa-key', 'vista/hospedajes.php', 1),
(6, 'Huespedes', 'fa-id-card', 'vista/huespedes.php', 1),
(7, 'Reportes', 'fa-chart-bar', 'vista/reportes.php ', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `idperfil` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `estado` smallint(6) DEFAULT NULL COMMENT '0 -> INACTIVO \n1 -> ACTIVO\n2 -> ELIMINADO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`idperfil`, `nombre`, `estado`) VALUES
(1, 'ADMINISTRADOR', 1),
(2, 'RECEPCIONISTA', 1),
(3, 'CAJERO', 2),
(4, 'ALMACENERO', 2),
(5, 'PRUEBA', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipodocumento`
--

CREATE TABLE `tipodocumento` (
  `id_tipodocumento` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `estado` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `tipodocumento`
--

INSERT INTO `tipodocumento` (`id_tipodocumento`, `nombre`, `estado`) VALUES
(1, 'Cedula de Identidad', 1),
(2, 'Pasaporte', 1),
(3, 'DNI', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipohabitacion`
--

CREATE TABLE `tipohabitacion` (
  `id_tipohabitacion` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `precio` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipohabitacion`
--

INSERT INTO `tipohabitacion` (`id_tipohabitacion`, `nombre`, `precio`, `estado`) VALUES
(1, 'Matrimonial', 100, 1),
(2, 'Doble', 150, 1),
(3, 'Triple', 180, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `clave` text DEFAULT NULL,
  `idperfil` int(11) NOT NULL,
  `urlimagen` varchar(200) NOT NULL DEFAULT 'imagen/usuario/default.jpg',
  `estado` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `usuario`, `clave`, `idperfil`, `urlimagen`, `estado`) VALUES
(1, 'SAMUEL MAMANI', 'samuel', '96dd15ef622d7c10a9d3ad98c8619ba4733e0812', 1, 'imagen/usuario/default.jpg', 1),
(2, 'Diego Ramírez', 'diego', '8cb2237d0679ca88db6464eac60da96345513964', 2, 'imagen/usuario/IMG_2avatar5.png', 1),
(3, 'admin', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 'imagen/usuario/default.jpg', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acceso`
--
ALTER TABLE `acceso`
  ADD PRIMARY KEY (`idperfil`,`idopcion`);

--
-- Indices de la tabla `habitacion`
--
ALTER TABLE `habitacion`
  ADD PRIMARY KEY (`id_habitacion`);

--
-- Indices de la tabla `hospedaje`
--
ALTER TABLE `hospedaje`
  ADD PRIMARY KEY (`id_hospedaje`);

--
-- Indices de la tabla `hospedar`
--
ALTER TABLE `hospedar`
  ADD PRIMARY KEY (`id_hospedar`);

--
-- Indices de la tabla `huesped`
--
ALTER TABLE `huesped`
  ADD PRIMARY KEY (`id_huesped`);

--
-- Indices de la tabla `nacionalidad`
--
ALTER TABLE `nacionalidad`
  ADD PRIMARY KEY (`id_nacionalidad`);

--
-- Indices de la tabla `opcion`
--
ALTER TABLE `opcion`
  ADD PRIMARY KEY (`idopcion`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`idperfil`);

--
-- Indices de la tabla `tipodocumento`
--
ALTER TABLE `tipodocumento`
  ADD PRIMARY KEY (`id_tipodocumento`);

--
-- Indices de la tabla `tipohabitacion`
--
ALTER TABLE `tipohabitacion`
  ADD PRIMARY KEY (`id_tipohabitacion`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `habitacion`
--
ALTER TABLE `habitacion`
  MODIFY `id_habitacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `hospedaje`
--
ALTER TABLE `hospedaje`
  MODIFY `id_hospedaje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `hospedar`
--
ALTER TABLE `hospedar`
  MODIFY `id_hospedar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `huesped`
--
ALTER TABLE `huesped`
  MODIFY `id_huesped` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `nacionalidad`
--
ALTER TABLE `nacionalidad`
  MODIFY `id_nacionalidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `opcion`
--
ALTER TABLE `opcion`
  MODIFY `idopcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `idperfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipodocumento`
--
ALTER TABLE `tipodocumento`
  MODIFY `id_tipodocumento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipohabitacion`
--
ALTER TABLE `tipohabitacion`
  MODIFY `id_tipohabitacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
