-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 01-12-2018 a las 15:48:26
-- Versión del servidor: 10.1.31-MariaDB
-- Versión de PHP: 7.0.26
CREATE DATABASE energym;
CREATE USER energym identified by 'energymg7';
GRANT ALL ON energym.* TO energym;
USE energym;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `id5245865_energym`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Asistencia`
--

CREATE TABLE `Asistencia` (
  `id_asistencia` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `presente` tinyint(1) NOT NULL,
  `sucursal` tinyint(4) DEFAULT NULL,
  `usuario` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Asistencia`
--

INSERT INTO `Asistencia` (`id_asistencia`, `fecha`, `presente`, `sucursal`, `usuario`) VALUES
(1, '2018-05-30', 1, 1, 'ianv97'),
(3, '2018-05-28', 0, 1, 'ianv97'),
(4, '2018-06-22', 1, 2, 'paulasalica'),
(20, '2018-06-23', 1, 1, 'ianv97'),
(27, '2018-06-25', 1, 1, 'ianv97'),
(28, '2018-07-04', 1, 1, 'Usuario Ejemplo'),
(29, '2018-07-04', 1, 2, 'ianv97'),
(30, '2018-07-05', 1, 1, 'ianv97');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `AsistenciaEmpleado`
--

CREATE TABLE `AsistenciaEmpleado` (
  `id_asistencia` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `presente` tinyint(1) NOT NULL,
  `horaingreso` time DEFAULT NULL,
  `horasalida` time DEFAULT NULL,
  `sucursal` tinyint(4) NOT NULL,
  `usuario` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `AsistenciaEmpleado`
--

INSERT INTO `AsistenciaEmpleado` (`id_asistencia`, `fecha`, `presente`, `horaingreso`, `horasalida`, `sucursal`, `usuario`) VALUES
(1, '2018-06-04', 1, '15:00:00', '22:00:00', 1, 'rromboli'),
(2, '2018-06-23', 1, '05:11:25', '05:17:56', 1, 'rromboli'),
(4, '2018-07-04', 1, '18:55:51', '19:01:02', 1, 'mfleitas'),
(5, '2018-07-04', 1, '18:56:32', '19:21:37', 2, 'rromboli'),
(6, '2018-07-04', 1, '18:56:59', '19:26:39', 2, 'mgomez');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Categoría`
--

CREATE TABLE `Categoría` (
  `id_categoría` smallint(6) NOT NULL,
  `nombre_categoría` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ejercicio1` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ejercicio2` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ejercicio3` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ejercicio4` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ejercicio5` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ejercicio6` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Categoría`
--

INSERT INTO `Categoría` (`id_categoría`, `nombre_categoría`, `ejercicio1`, `ejercicio2`, `ejercicio3`, `ejercicio4`, `ejercicio5`, `ejercicio6`) VALUES
(1, 'Biceps', 'Barra', 'Polea', 'Martillo', 'Mancuerna', 'Supinación', 'TRX'),
(2, 'Triceps', 'Dipping', 'Barra', 'Tronco inclinado', 'Agarre invertido', 'Extensión vertical', 'Press francés'),
(3, 'Pecho', 'Dips en paralela', 'Pull-Over barra', 'Pull-Over mancuerna', 'Apertura en máquina', 'Press de banco', 'Press con mancuerna'),
(4, 'Abdominales', 'Twist', 'Crunch', 'TRX', 'Plancha', 'Elevación de piernas', 'Flexión lateral'),
(5, 'Piernas', 'Sentadillas', 'Abductores', 'Gemelos', 'Elevación de talones', 'Curl alterno', ''),
(6, 'Espalda', 'Dominadas en barra', 'Encogimiento hombros', 'Remo al cuello', 'Remo en T', 'Peso muerto', 'Extensión de tronco'),
(7, 'Glúteos', 'Elevación de pelvis', 'Abducción de cadera', 'Extensión de cadera', 'Zancadas', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Clases`
--

CREATE TABLE `Clases` (
  `id_clase` int(11) NOT NULL,
  `nombre` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `cupo` int(11) NOT NULL,
  `precio` int(11) NOT NULL,
  `horario` varchar(90) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Clases`
--

INSERT INTO `Clases` (`id_clase`, `nombre`, `cupo`, `precio`, `horario`) VALUES
(0, 'Complemento', 10000, 500, ''),
(1, 'Zumba', 40, 350, 'Martes y Jueves 15:30 - 16:30'),
(2, 'Crossfit', 25, 400, 'Martes y Jueves 17:00 - 18:30'),
(6, 'Zumba', 40, 350, 'Lunes y Miércoles 19:00 - 20:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Cuota`
--

CREATE TABLE `Cuota` (
  `id_cuota` int(11) NOT NULL,
  `usuario` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `periodo` date NOT NULL,
  `precio` int(11) NOT NULL,
  `pagada` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Cuota`
--

INSERT INTO `Cuota` (`id_cuota`, `usuario`, `periodo`, `precio`, `pagada`) VALUES
(2, 'ianv97', '2018-06-01', 900, 1),
(3, 'ianv97', '2018-05-01', 990, 1),
(5, 'Prueba N 200', '2018-06-27', 1250, 1),
(6, 'Usuario Ejemplo', '2018-06-27', 1250, 1),
(8, 'asdf', '2018-07-05', 1250, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Evento`
--

CREATE TABLE `Evento` (
  `id` int(11) NOT NULL,
  `titulo` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `inicio` datetime NOT NULL,
  `fin` datetime NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `colorf` varchar(7) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#343a40',
  `colort` varchar(7) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#FFFFFF',
  `ingresos` int(11) NOT NULL DEFAULT '0',
  `liberado` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Evento`
--

INSERT INTO `Evento` (`id`, `titulo`, `inicio`, `fin`, `descripcion`, `colorf`, `colort`, `ingresos`, `liberado`) VALUES
(8, 'Torneo de Taekwondo', '2018-06-09 16:00:00', '2018-06-09 20:00:00', 'Torneo de Taekwondo', '#343a40', '#ffffff', 0, 1),
(9, 'Charla de Suplementos Deportivos', '2018-06-15 10:00:00', '2018-06-15 12:00:00', 'Charla de Suplementos Deportivos', '#343a40', '#ffffff', 0, 0),
(37, 'Curso de alimentación', '2018-06-06 08:00:00', '2018-06-06 23:59:00', 'Curso sobre alimentación', '#00ff40', '#ffffff', 100, 1),
(38, 'Expo', '2018-07-05 08:00:00', '2018-07-05 23:59:00', 'Diseño', '#343a40', '#ffffff', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Pack`
--

CREATE TABLE `Pack` (
  `id_pack` int(11) NOT NULL,
  `usuario` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `precio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Pack`
--

INSERT INTO `Pack` (`id_pack`, `usuario`, `precio`) VALUES
(9, 'ianv97', 1250),
(10, 'paulasalica', 350),
(11, 'gdsxg', 0),
(13, 'Prueba N 200', 1250),
(14, 'Usuario Ejemplo', 0),
(16, 'asdf', 1250);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `PackClase`
--

CREATE TABLE `PackClase` (
  `id_pack` int(11) NOT NULL,
  `id_clase` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `PackClase`
--

INSERT INTO `PackClase` (`id_pack`, `id_clase`) VALUES
(9, 0),
(9, 1),
(9, 2),
(10, 1),
(13, 0),
(13, 1),
(13, 2),
(16, 0),
(16, 1),
(16, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Rutina`
--

CREATE TABLE `Rutina` (
  `usuario_rutina` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `id_rutina` smallint(6) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date DEFAULT NULL,
  `profesor` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `dia_rutina` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `categoría` smallint(6) NOT NULL,
  `ejercicio1s` smallint(6) DEFAULT NULL,
  `ejercicio1r` smallint(6) DEFAULT NULL,
  `ejercicio2s` smallint(6) DEFAULT NULL,
  `ejercicio2r` smallint(6) DEFAULT NULL,
  `ejercicio3s` smallint(6) DEFAULT NULL,
  `ejercicio3r` smallint(6) DEFAULT NULL,
  `ejercicio4s` smallint(6) DEFAULT NULL,
  `ejercicio4r` smallint(6) DEFAULT NULL,
  `ejercicio5s` smallint(6) DEFAULT NULL,
  `ejercicio5r` smallint(6) DEFAULT NULL,
  `ejercicio6s` smallint(6) DEFAULT NULL,
  `ejercicio6r` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Rutina`
--

INSERT INTO `Rutina` (`usuario_rutina`, `id_rutina`, `fecha_inicio`, `fecha_fin`, `profesor`, `dia_rutina`, `categoría`, `ejercicio1s`, `ejercicio1r`, `ejercicio2s`, `ejercicio2r`, `ejercicio3s`, `ejercicio3r`, `ejercicio4s`, `ejercicio4r`, `ejercicio5s`, `ejercicio5r`, `ejercicio6s`, `ejercicio6r`) VALUES
('paulasalica', 1, '2018-06-01', '2018-06-29', 'mgomez', 'Viernes', 1, 2, 15, NULL, NULL, 3, 20, NULL, NULL, 3, 12, NULL, NULL),
('paulasalica', 2, '2018-06-01', '2018-06-29', 'mgomez', 'Viernes', 3, 3, 15, 4, 12, NULL, NULL, 3, 20, NULL, NULL, NULL, NULL),
('paulasalica', 3, '2018-06-04', '2018-07-02', 'mgomez', 'Lunes', 2, NULL, NULL, 3, 15, NULL, NULL, 3, 15, 3, 20, NULL, NULL),
('ianv97', 4, '2018-06-04', '2018-06-27', 'mgomez', 'Lunes', 6, 4, 10, NULL, NULL, 3, 15, NULL, NULL, NULL, NULL, 2, 20),
('ianv97', 5, '2018-06-06', NULL, 'mgomez', 'Miércoles', 5, NULL, NULL, 3, 15, NULL, NULL, NULL, NULL, 4, 12, NULL, NULL),
('ianv97', 6, '2018-06-06', NULL, 'mgomez', 'Miércoles', 4, 3, 12, 4, 20, NULL, NULL, 5, 10, NULL, NULL, NULL, NULL),
('ianv97', 7, '2018-06-06', NULL, 'mgomez', 'Miércoles', 7, NULL, NULL, NULL, NULL, 2, 15, 3, 12, NULL, NULL, NULL, NULL),
('ianv97', 13, '2018-06-27', '2018-07-04', 'mgomez', 'Lunes', 6, 3, 20, 4, 12, 3, 18, 2, 15, NULL, NULL, NULL, NULL),
('sofivs', 14, '2018-06-27', NULL, 'matiasaravia52', 'Miércoles', 1, 2, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('sofivs', 15, '2018-06-27', NULL, 'paulasalica', 'Lunes', 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('ianv97', 16, '2018-06-27', '2018-07-05', 'mgomez', 'Martes', 2, 2, 4, 3, 5, 1, 8, 2, 15, 4, 10, 2, 15),
('ianv97', 17, '2018-07-04', NULL, 'mgomez', 'Martes', 4, 5, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('ianv97', 18, '2018-07-05', NULL, 'mgomez', 'Martes', 3, 3, 15, NULL, NULL, 5, 12, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuario`
--

CREATE TABLE `Usuario` (
  `usuario` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `contraseña` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `fecha_nac` date NOT NULL,
  `sexo` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `recibir_info` tinyint(1) NOT NULL,
  `foto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dni` int(11) DEFAULT NULL,
  `celular` bigint(20) DEFAULT NULL,
  `altura` smallint(6) DEFAULT NULL,
  `peso` smallint(6) DEFAULT NULL,
  `talla` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nivel_acceso` int(11) NOT NULL DEFAULT '0',
  `sucursal` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Usuario`
--

INSERT INTO `Usuario` (`usuario`, `contraseña`, `email`, `nombre`, `apellido`, `fecha_nac`, `sexo`, `recibir_info`, `foto`, `dni`, `celular`, `altura`, `peso`, `talla`, `nivel_acceso`, `sucursal`) VALUES
('administrador', '$2y$10$0Rgv9wv1enBwwsHUjkzNv.g0kZz6..xvB1xC7vGD0OaUhk9c928L2', 'administrador@gmail.com', 'Paula', 'Garcia', '2018-06-11', 'F', 0, 'anonimo.jpg', 21354654, NULL, NULL, NULL, NULL, 3, NULL),
('asdf', '$2y$10$Kre7L8tTiQPel66lKUtNheNxtk6Flwti61TRSkzx28.XLDsHEudcq', 'asd@ad', 'asd', 'asd', '2018-07-04', 'M', 0, '', 12345678, NULL, NULL, NULL, NULL, 0, NULL),
('fstorchi', '$2y$10$EhPkTsi2ZLfcUUms672yKu3zJqqgQVBPy1/0jWlRhRDNXywPUJkZy', 'fernandostorchi@gmail.com', 'Fernando', 'Storchi', '1980-05-10', 'M', 0, 'fstorchi.jpg', 40550112, NULL, NULL, NULL, NULL, 4, NULL),
('gdsxg', '$2y$10$YOdXsQFMA8LemJiuD4tWlODJt2/MDJXfHZnsn5eC8yVBm2CuH/KKa', 'qwgferty@asd', 'Joaquin', 'Martinez', '1995-05-05', 'M', 0, 'anonimo.jpg', 32578932, NULL, NULL, NULL, NULL, 0, NULL),
('ianv97', '$2y$10$5ZR8scICuv1q4OvoQqFQRupWug67Q2Tglo2XfDzs2BXvnjW0z9nFe', 'mateogarcia@hotmail.com', 'Mateo', 'García', '1997-11-17', 'M', 1, 'mgarcia.jpg', 40773512, 3624360065, 186, 56, NULL, 0, NULL),
('matiasaravia51', '$2y$10$RgRIbm2e5GL0PMOmBW.siuh2XBdhZHwGccZRI.l4ATlenmjUW7FMe', 'matiasaravia52@gmail.com', 'Andrea', 'Rios', '2000-06-13', 'F', 0, 'anonimo.jpg', 2234497, NULL, NULL, NULL, NULL, 1, NULL),
('matiasaravia52', '$2y$10$hxPTdmiILW7JLqqohT840uU5hoY6puTqKgTGiDqzlilPQ6845UF.q', 'matiasaravia52@gmail.com.ar', 'Fernando', 'Storchi', '2018-06-12', 'M', 0, 'educacion-fisica_1.jpg', 38875099, 3781459238, NULL, NULL, NULL, 4, NULL),
('mfleitas', '$2y$10$QSflhKDGRqsl5fKr3JNNd.kKc4A0WDVzyEHqpc0wqMwy4h1Ms.0dO', 'mfleitas@gmail.com', 'María', 'Fleitas', '1990-03-20', 'F', 0, 'secretaria administrativa2.jpg', 33576932, NULL, NULL, NULL, NULL, 2, 1),
('mgomez', '$2y$10$M83O5kI8IJfQXrwbKFm4jOV13Bf6f0HQuRugbPbXXzPsUadiZZIoi', 'mgomez@gmail.com', 'Mario', 'Gomez', '1982-08-07', 'M', 0, 'mgomez.jpg', 27845691, NULL, 178, 70, NULL, 1, NULL),
('paulasalica', '$2y$10$mkVXv0UJCpSthMs1VhS2beuMosZBe/5uPXaKwiJGV1xVfVJ1t/YRa', 'paulasalica@gmail.com', 'Paula', 'Salica', '1995-03-07', 'F', 0, 'anonimo.jpg', 38538104, NULL, NULL, NULL, NULL, 1, NULL),
('profesor', '$2y$10$co6IgX3q1XXzpufzYomvmufbGPmT91aTxMl/Lf6o51nTfWLvvnwAO', 'profesor@gmail.com', 'Ernesto', 'Gomez', '2018-06-11', 'M', 0, '', 12323, NULL, NULL, NULL, NULL, 1, NULL),
('Prueba N 200', '$2y$10$mZcXOIz9PAmjS8vBE.lg/OAXw7oKDwULFgvVPytglHAziDQ5sGpmm', 'cansadadecrearusuarios@gmail.c', 'Maximiliano', 'Ramirez', '6666-06-06', 'M', 0, '', 2147483647, NULL, NULL, NULL, NULL, 0, NULL),
('rromboli', '$2y$10$S.efKEDc0M16Y1rVuhyBFeYGuEU2lTWi5BBsluAPq2rCBmF0vU2Wi', 'rromboli@gmail.com', 'Roberta', 'Romboli', '1973-06-10', 'F', 0, 'romboli.jpg', 26587941, NULL, NULL, NULL, NULL, 3, NULL),
('sdominguez', '$2y$10$JAyW4ifVmDO6rvBYCA30reXJQXUgQk4VssEBKoBSENsnCr.MhytNG', 'sdominguez@gmail.com', 'Sol', 'Dominguez', '1986-04-04', 'F', 0, '', 29845173, NULL, NULL, NULL, NULL, 2, 2),
('secretaria', '$2y$10$4fewLgK9GG80.tivHAmwYejKSD57Asmyy5Lzhfm0.pEJtVdAIrLOa', 'secretaria@gmail.com', 'Micaela', 'Fernandez', '1994-06-20', 'F', 0, 'anonimo.jpg', 123456789, NULL, NULL, NULL, NULL, 2, 1),
('sofivs', '$2y$10$IWVtR6lqNxcRPkvrERO2fetd/nlb1j.OqZZ5AGeuyE/ciulSKJBce', 'sofiavs@gmail.com', 'Sofia', 'Bieber', '2020-10-10', 'M', 0, 'mapamundi.jpg', 50900899, NULL, NULL, NULL, NULL, 0, NULL),
('Usuario Ejemplo', '$2y$10$vOx6U7T5o.mbLb5.yqlyeul79avOwyYAPoO1OAHvVLVRcL1L3RY0G', 'usuarioejemplo@gmail.com', 'Usuario', 'EjemploM', '1997-12-11', 'F', 0, 'anonimo.jpg', 40673462, NULL, NULL, NULL, NULL, 0, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Asistencia`
--
ALTER TABLE `Asistencia`
  ADD PRIMARY KEY (`id_asistencia`),
  ADD KEY `usuario` (`usuario`);

--
-- Indices de la tabla `AsistenciaEmpleado`
--
ALTER TABLE `AsistenciaEmpleado`
  ADD PRIMARY KEY (`id_asistencia`),
  ADD KEY `usuario` (`usuario`);

--
-- Indices de la tabla `Categoría`
--
ALTER TABLE `Categoría`
  ADD PRIMARY KEY (`id_categoría`);

--
-- Indices de la tabla `Clases`
--
ALTER TABLE `Clases`
  ADD PRIMARY KEY (`id_clase`);

--
-- Indices de la tabla `Cuota`
--
ALTER TABLE `Cuota`
  ADD PRIMARY KEY (`id_cuota`),
  ADD KEY `cuota_usuario` (`usuario`);

--
-- Indices de la tabla `Evento`
--
ALTER TABLE `Evento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `Pack`
--
ALTER TABLE `Pack`
  ADD PRIMARY KEY (`id_pack`),
  ADD KEY `usuario` (`usuario`);

--
-- Indices de la tabla `PackClase`
--
ALTER TABLE `PackClase`
  ADD PRIMARY KEY (`id_pack`,`id_clase`),
  ADD KEY `id_clase` (`id_clase`);

--
-- Indices de la tabla `Rutina`
--
ALTER TABLE `Rutina`
  ADD PRIMARY KEY (`id_rutina`) USING BTREE,
  ADD KEY `cateogría` (`categoría`),
  ADD KEY `profesor` (`profesor`),
  ADD KEY `usuario_rutina` (`usuario_rutina`);

--
-- Indices de la tabla `Usuario`
--
ALTER TABLE `Usuario`
  ADD PRIMARY KEY (`usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Asistencia`
--
ALTER TABLE `Asistencia`
  MODIFY `id_asistencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `AsistenciaEmpleado`
--
ALTER TABLE `AsistenciaEmpleado`
  MODIFY `id_asistencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `Categoría`
--
ALTER TABLE `Categoría`
  MODIFY `id_categoría` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `Clases`
--
ALTER TABLE `Clases`
  MODIFY `id_clase` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `Cuota`
--
ALTER TABLE `Cuota`
  MODIFY `id_cuota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `Evento`
--
ALTER TABLE `Evento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `Pack`
--
ALTER TABLE `Pack`
  MODIFY `id_pack` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `Rutina`
--
ALTER TABLE `Rutina`
  MODIFY `id_rutina` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Asistencia`
--
ALTER TABLE `Asistencia`
  ADD CONSTRAINT `Asistencia_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `Usuario` (`usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `AsistenciaEmpleado`
--
ALTER TABLE `AsistenciaEmpleado`
  ADD CONSTRAINT `AsistenciaEmpleado_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `Usuario` (`usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Cuota`
--
ALTER TABLE `Cuota`
  ADD CONSTRAINT `cuota_usuario` FOREIGN KEY (`usuario`) REFERENCES `Usuario` (`usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Pack`
--
ALTER TABLE `Pack`
  ADD CONSTRAINT `usuario` FOREIGN KEY (`usuario`) REFERENCES `Usuario` (`usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `PackClase`
--
ALTER TABLE `PackClase`
  ADD CONSTRAINT `id_clase` FOREIGN KEY (`id_clase`) REFERENCES `Clases` (`id_clase`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_pack` FOREIGN KEY (`id_pack`) REFERENCES `Pack` (`id_pack`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Rutina`
--
ALTER TABLE `Rutina`
  ADD CONSTRAINT `Rutina_ibfk_2` FOREIGN KEY (`categoría`) REFERENCES `Categoría` (`id_categoría`),
  ADD CONSTRAINT `Rutina_ibfk_3` FOREIGN KEY (`profesor`) REFERENCES `Usuario` (`usuario`),
  ADD CONSTRAINT `Rutina_ibfk_4` FOREIGN KEY (`usuario_rutina`) REFERENCES `Usuario` (`usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
