-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-12-2021 a las 05:33:29
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `colegio_notas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

CREATE TABLE `alumno` (
  `id_alumno` int(11) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `telefono` varchar(9) NOT NULL,
  `dni` char(8) NOT NULL,
  `clave` varchar(15) NOT NULL,
  `id_estado` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`id_alumno`, `nombres`, `apellidos`, `direccion`, `telefono`, `dni`, `clave`, `id_estado`) VALUES
(6, 'ARIANA SOLANGE', 'DURAND GARCIA', 'DESCONOCIDO', '12345678', '75641310', '111111', '0'),
(7, 'JASON FABRIZIO', 'LOZANO VASQUEZ ', 'DESCONOCIDO', '123456789', '60222187', '123456', '0'),
(8, 'ANGIE GRECIA', 'ORIHUELA RODRIGUEZ ', 'DESCONOCIDO', '123654789', '77821529', '123456', '0'),
(9, 'MAX DIEGO', 'OTINIANO EUSTAQUIO', 'DESCONOCIDO', '326541547', '73295144', '123456', '0'),
(10, 'carlos', 'alcantara', 'DESCONOCIDO', '315415478', '77327017', '123456', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area_curricular`
--

CREATE TABLE `area_curricular` (
  `id_area_curricular` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `area_curricular`
--

INSERT INTO `area_curricular` (`id_area_curricular`, `descripcion`) VALUES
(1, 'MATEMÁTICA'),
(2, 'COMUNICACIÓN'),
(3, 'IDIOMAS'),
(4, 'ED. RELIGIOSA'),
(5, 'CIENCIA Y TECNOLOGÍA'),
(6, 'ED. FÍSICA'),
(7, 'ED. PARA EL TRABAJO'),
(8, 'ARTE Y CULTURA'),
(9, 'DESARROLLO PERSONAL, CIUDADANA Y CÍVICA'),
(10, 'CIENCIAS SOCIALES'),
(11, 'TUTORÍA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacion`
--

CREATE TABLE `asignacion` (
  `id_asignacion` int(11) NOT NULL,
  `id_docente` char(8) NOT NULL,
  `id_asignatura` int(11) NOT NULL,
  `id_aula` int(11) NOT NULL,
  `periodo` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `asignacion`
--

INSERT INTO `asignacion` (`id_asignacion`, `id_docente`, `id_asignatura`, `id_aula`, `periodo`) VALUES
(10, '11111111', 1, 5, 2021),
(11, '11111111', 2, 5, 2021),
(12, '11111111', 3, 5, 2021),
(13, '11111111', 4, 5, 2021),
(14, '11111111', 5, 5, 2021),
(15, '11111111', 6, 5, 2021),
(16, '11111111', 7, 5, 2021),
(18, '11111111', 9, 9, 2021),
(19, '2222222', 11, 9, 2021);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignatura`
--

CREATE TABLE `asignatura` (
  `id_asignatura` int(11) NOT NULL,
  `id_area_curricular` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `asignatura`
--

INSERT INTO `asignatura` (`id_asignatura`, `id_area_curricular`, `descripcion`) VALUES
(1, 1, 'MATEMÁTICA (ARIT/ALG/GE/TRI)'),
(2, 1, 'RAZ. MATEMÁTICO'),
(3, 1, 'RAZ. LÓGICO'),
(4, 2, 'COMUNICACIÓN'),
(5, 2, 'RAZ. VERBAL'),
(6, 3, 'INGLÉS'),
(7, 4, 'RELIGIÓN'),
(8, 5, 'BIOLOGÍA'),
(9, 5, 'QUIMICA'),
(10, 5, 'FISICA'),
(11, 6, 'ED. FÍSICA'),
(12, 7, 'GESTIÓN EMPRESARIAL'),
(13, 8, 'ARTE Y CULTURA'),
(14, 9, 'DPCC'),
(15, 10, 'HISTORIA Y GEOGRAFÍA'),
(16, 11, 'TUTORÍA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aula`
--

CREATE TABLE `aula` (
  `id_aula` int(11) NOT NULL,
  `nivel` char(1) NOT NULL,
  `grado` char(1) NOT NULL,
  `seccion` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `aula`
--

INSERT INTO `aula` (`id_aula`, `nivel`, `grado`, `seccion`) VALUES
(5, '2', '1', 'A'),
(6, '2', '2', 'A'),
(7, '2', '3', 'A'),
(8, '2', '4', 'A'),
(9, '2', '5', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificacion`
--

CREATE TABLE `calificacion` (
  `id_estudio` int(11) NOT NULL,
  `id_asignacion` int(11) NOT NULL,
  `unidad` char(1) NOT NULL,
  `calificacion` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `calificacion`
--

INSERT INTO `calificacion` (`id_estudio`, `id_asignacion`, `unidad`, `calificacion`) VALUES
(5, 13, '1', '12'),
(5, 13, '2', '10'),
(5, 13, '3', '15'),
(6, 13, '1', '14'),
(6, 13, '2', '14'),
(6, 13, '3', '13'),
(8, 13, '1', '18'),
(8, 13, '2', '16'),
(8, 13, '3', '18'),
(5, 11, '1', '12'),
(5, 11, '2', '12'),
(5, 11, '3', '12'),
(6, 11, '1', '14'),
(6, 11, '2', '14'),
(6, 11, '3', '13'),
(7, 11, '1', '11'),
(7, 11, '2', '11'),
(7, 11, '3', '11'),
(8, 11, '1', '18'),
(8, 11, '2', '18'),
(8, 11, '3', '18'),
(5, 12, '1', '10'),
(5, 12, '2', '11'),
(5, 12, '3', '10'),
(6, 12, '1', '13'),
(6, 12, '2', '13'),
(6, 12, '3', '13'),
(7, 12, '1', '11'),
(7, 12, '2', '11'),
(7, 12, '3', '13'),
(8, 12, '1', '14'),
(8, 12, '2', '14'),
(8, 12, '3', '14'),
(9, 19, '1', '15'),
(9, 19, '2', '11'),
(9, 19, '3', '9'),
(9, 19, '4', '14'),
(5, 10, '1', '12'),
(5, 10, '2', '14'),
(5, 10, '3', '12'),
(6, 10, '1', '14'),
(6, 10, '2', '14'),
(6, 10, '3', '14'),
(7, 10, '1', '11'),
(7, 10, '2', '12'),
(7, 10, '3', '11'),
(8, 10, '1', '18'),
(8, 10, '2', '18'),
(8, 10, '3', '18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conclusion_descriptiva`
--

CREATE TABLE `conclusion_descriptiva` (
  `id_estudio` int(11) NOT NULL,
  `id_asignacion` int(11) NOT NULL,
  `conclusion` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `conclusion_descriptiva`
--

INSERT INTO `conclusion_descriptiva` (`id_estudio`, `id_asignacion`, `conclusion`) VALUES
(5, 13, ''),
(6, 13, ''),
(7, 13, ''),
(8, 13, ''),
(5, 11, 'bien hecho!'),
(6, 11, 'bien hecho!'),
(7, 11, 'bien hecho!'),
(8, 11, 'bien hecho!'),
(5, 12, 'bien hecho!'),
(6, 12, 'bien hecho!'),
(7, 12, 'bien hecho!'),
(8, 12, 'bien hecho!'),
(9, 19, 'No ha participado en algunas clases'),
(5, 10, 'bien hecho!'),
(6, 10, 'bien hecho!'),
(7, 10, 'bien hecho!'),
(8, 10, 'bien hecho!');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente`
--

CREATE TABLE `docente` (
  `id_docente` char(8) NOT NULL,
  `clave` varchar(15) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `id_estado` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `docente`
--

INSERT INTO `docente` (`id_docente`, `clave`, `nombres`, `apellidos`, `id_estado`) VALUES
('11111111', '123456', 'YODEMIT', 'GOMEZ MOZO ', '0'),
('2222222', '123456', 'Alejandro', 'Jaramillo', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id_estado` char(1) NOT NULL,
  `descripcion` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id_estado`, `descripcion`) VALUES
('0', 'ACTIVO'),
('1', 'INACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudio`
--

CREATE TABLE `estudio` (
  `id_estudio` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `id_aula` int(11) NOT NULL,
  `id_periodo` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estudio`
--

INSERT INTO `estudio` (`id_estudio`, `id_alumno`, `id_aula`, `id_periodo`) VALUES
(5, 6, 5, 2021),
(6, 7, 5, 2021),
(7, 8, 5, 2021),
(8, 9, 5, 2021),
(9, 10, 9, 2021);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestor`
--

CREATE TABLE `gestor` (
  `id_gestor` char(8) NOT NULL,
  `clave` char(15) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `id_estado` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `gestor`
--

INSERT INTO `gestor` (`id_gestor`, `clave`, `nombres`, `apellidos`, `id_estado`) VALUES
('12345678', '123456', 'JOSUE ANTONIO', 'PEREZ CORREA ', '0'),
('77327018', '123456', 'Carlo Magno', 'Socola Lozada', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodo`
--

CREATE TABLE `periodo` (
  `id_periodo` year(4) NOT NULL,
  `inicio_periodo` date NOT NULL,
  `fin_periodo` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `periodo`
--

INSERT INTO `periodo` (`id_periodo`, `inicio_periodo`, `fin_periodo`) VALUES
(2021, '2021-01-14', '2021-12-21');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD PRIMARY KEY (`id_alumno`);

--
-- Indices de la tabla `area_curricular`
--
ALTER TABLE `area_curricular`
  ADD PRIMARY KEY (`id_area_curricular`);

--
-- Indices de la tabla `asignacion`
--
ALTER TABLE `asignacion`
  ADD PRIMARY KEY (`id_asignacion`),
  ADD KEY `fk_asignacionIdAsignatura` (`id_asignatura`),
  ADD KEY `fk_asignacionIdAula` (`id_aula`),
  ADD KEY `fk_asignacionIdDocente` (`id_docente`),
  ADD KEY `fk_asignacionIdPeriodo` (`periodo`);

--
-- Indices de la tabla `asignatura`
--
ALTER TABLE `asignatura`
  ADD PRIMARY KEY (`id_asignatura`),
  ADD KEY `fk_asignaturaIdAreaCurricular` (`id_area_curricular`);

--
-- Indices de la tabla `aula`
--
ALTER TABLE `aula`
  ADD PRIMARY KEY (`id_aula`);

--
-- Indices de la tabla `calificacion`
--
ALTER TABLE `calificacion`
  ADD KEY `id_estudio` (`id_estudio`),
  ADD KEY `fk_calificacionIdAsignacion` (`id_asignacion`);

--
-- Indices de la tabla `conclusion_descriptiva`
--
ALTER TABLE `conclusion_descriptiva`
  ADD KEY `fk_conclusiondescriptivaIdEstudio` (`id_estudio`),
  ADD KEY `fk_conclusiondescriptivaIdAsignacion` (`id_asignacion`);

--
-- Indices de la tabla `docente`
--
ALTER TABLE `docente`
  ADD PRIMARY KEY (`id_docente`),
  ADD KEY `fk_docenteIdEstado` (`id_estado`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `estudio`
--
ALTER TABLE `estudio`
  ADD PRIMARY KEY (`id_estudio`),
  ADD KEY `fk_estudioIdAlumno` (`id_alumno`),
  ADD KEY `fk_estudioIdAula` (`id_aula`),
  ADD KEY `fk_estudioIdPeriodo` (`id_periodo`);

--
-- Indices de la tabla `gestor`
--
ALTER TABLE `gestor`
  ADD PRIMARY KEY (`id_gestor`),
  ADD KEY `fk_gestorIdEstado` (`id_estado`);

--
-- Indices de la tabla `periodo`
--
ALTER TABLE `periodo`
  ADD PRIMARY KEY (`id_periodo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumno`
--
ALTER TABLE `alumno`
  MODIFY `id_alumno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `area_curricular`
--
ALTER TABLE `area_curricular`
  MODIFY `id_area_curricular` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `asignacion`
--
ALTER TABLE `asignacion`
  MODIFY `id_asignacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `asignatura`
--
ALTER TABLE `asignatura`
  MODIFY `id_asignatura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `aula`
--
ALTER TABLE `aula`
  MODIFY `id_aula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `calificacion`
--
ALTER TABLE `calificacion`
  MODIFY `id_estudio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `estudio`
--
ALTER TABLE `estudio`
  MODIFY `id_estudio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignacion`
--
ALTER TABLE `asignacion`
  ADD CONSTRAINT `fk_asignacionIdAsignatura` FOREIGN KEY (`id_asignatura`) REFERENCES `asignatura` (`id_asignatura`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_asignacionIdAula` FOREIGN KEY (`id_aula`) REFERENCES `aula` (`id_aula`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_asignacionIdDocente` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_asignacionIdPeriodo` FOREIGN KEY (`periodo`) REFERENCES `periodo` (`id_periodo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `asignatura`
--
ALTER TABLE `asignatura`
  ADD CONSTRAINT `fk_asignaturaIdAreaCurricular` FOREIGN KEY (`id_area_curricular`) REFERENCES `area_curricular` (`id_area_curricular`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `calificacion`
--
ALTER TABLE `calificacion`
  ADD CONSTRAINT `fk_calificacionIdAsignacion` FOREIGN KEY (`id_asignacion`) REFERENCES `asignacion` (`id_asignacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_calificacionIdEstudio` FOREIGN KEY (`id_estudio`) REFERENCES `estudio` (`id_estudio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `conclusion_descriptiva`
--
ALTER TABLE `conclusion_descriptiva`
  ADD CONSTRAINT `fk_conclusiondescriptivaIdAsignacion` FOREIGN KEY (`id_asignacion`) REFERENCES `asignacion` (`id_asignacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_conclusiondescriptivaIdEstudio` FOREIGN KEY (`id_estudio`) REFERENCES `estudio` (`id_estudio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `docente`
--
ALTER TABLE `docente`
  ADD CONSTRAINT `fk_docenteIdEstado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `estudio`
--
ALTER TABLE `estudio`
  ADD CONSTRAINT `fk_estudioIdAlumno` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id_alumno`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_estudioIdAula` FOREIGN KEY (`id_aula`) REFERENCES `aula` (`id_aula`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_estudioIdPeriodo` FOREIGN KEY (`id_periodo`) REFERENCES `periodo` (`id_periodo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `gestor`
--
ALTER TABLE `gestor`
  ADD CONSTRAINT `fk_gestorIdEstado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
