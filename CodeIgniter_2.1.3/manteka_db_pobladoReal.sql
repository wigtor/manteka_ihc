-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 14-10-2013 a las 14:51:46
-- Versión del servidor: 5.6.12-log
-- Versión de PHP: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `manteka_db`
--
CREATE DATABASE IF NOT EXISTS `manteka_db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `manteka_db`;

--
-- Volcado de datos para la tabla `asistencia`
--

INSERT INTO `asistencia` (`ID_SESION`, `ID_SUSPENCION`, `RUT_USUARIO`, `PRESENTE_ASISTENCIA`, `JUSTIFICADO_ASISTENCIA`, `COMENTARIO_ASISTENCIA`) VALUES
(7, NULL, 17705318, 0, 0, NULL),
(8, NULL, 17705318, 0, 0, NULL),
(9, NULL, 17705318, 0, 0, NULL),
(10, NULL, 17705318, 0, 0, NULL),
(11, NULL, 17705318, 0, 0, NULL);

--
-- Volcado de datos para la tabla `ayudante`
--

INSERT INTO `ayudante` (`RUT_USUARIO`, `ID_AYUDANTE`) VALUES
(17242754, 1);

--
-- Volcado de datos para la tabla `ayu_profe`
--

INSERT INTO `ayu_profe` (`ID_AYU_PROFE`, `RUT_USUARIO`, `PRO_RUT_USUARIO`) VALUES
(7, NULL, 6784536),
(8, NULL, 12248027),
(9, NULL, 10203469),
(10, NULL, 16125230),
(11, NULL, 9218017),
(12, NULL, 13891495),
(13, NULL, 16240076),
(14, NULL, 8408132),
(15, NULL, 12446856),
(16, NULL, 7387515),
(17, NULL, 12677293),
(18, NULL, 10441662);

--
-- Volcado de datos para la tabla `carrera`
--

INSERT INTO `carrera` (`COD_CARRERA`, `NOMBRE_CARRERA`, `DESCRIPCION_CARRERA`) VALUES
(1351, 'Ingenieria Civil en Metalurgia', 'Metales\r'),
(1353, 'Ingenieria Civil en Informatica', 'Computacion\r'),
(1361, 'Ingenieria Civil en Obras Civiles', 'Edificacion\r'),
(1363, 'Ingenieria Civil en Industria', 'Empresa\r');

--
-- Volcado de datos para la tabla `coordinador`
--

INSERT INTO `coordinador` (`RUT_USUARIO`, `ID_COORDINADOR`) VALUES
(17565743, 1);

--
-- Volcado de datos para la tabla `dia_horario`
--

INSERT INTO `dia_horario` (`ID_DIA`, `NOMBRE_DIA`, `ABREVIATURA_DIA`) VALUES
(1, 'Lunes', 'L'),
(2, 'Martes', 'M'),
(3, 'Miercoles', 'W'),
(4, 'Jueves', 'J'),
(5, 'Viernes', 'V'),
(6, 'Sabado', 'S'),
(7, 'Domingo', 'D');

--
-- Volcado de datos para la tabla `equipo_profesor`
--

INSERT INTO `equipo_profesor` (`ID_EQUIPO`, `ID_MODULO_TEM`) VALUES
(3, 3),
(4, 4),
(5, 5);

--
-- Volcado de datos para la tabla `estudiante`
--

INSERT INTO `estudiante` (`RUT_USUARIO`, `COD_CARRERA`, `ID_SECCION`, `ID_ESTUDIANTE`) VALUES
(17705318, 1353, 24, 16);

--
-- Volcado de datos para la tabla `evaluacion`
--

INSERT INTO `evaluacion` (`ID_EVALUACION`, `ID_MODULO_TEM`) VALUES
(3, 3),
(4, 4),
(5, 5);

--
-- Volcado de datos para la tabla `horario`
--

INSERT INTO `horario` (`ID_HORARIO`, `ID_MODULO`, `ID_DIA`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 7, 1),
(8, 8, 1),
(9, 9, 1),
(10, 1, 2),
(11, 2, 2),
(12, 3, 2),
(13, 4, 2),
(14, 5, 2),
(15, 6, 2),
(16, 7, 2),
(17, 8, 2),
(18, 9, 2),
(19, 1, 3),
(20, 2, 3),
(21, 3, 3),
(22, 4, 3),
(23, 5, 3),
(24, 6, 3),
(25, 7, 3),
(26, 8, 3),
(27, 9, 3),
(28, 1, 4),
(29, 2, 4),
(30, 3, 4),
(31, 4, 4),
(32, 5, 4),
(33, 6, 4),
(34, 7, 4),
(35, 8, 4),
(36, 9, 4),
(37, 1, 5),
(38, 2, 5),
(39, 3, 5),
(40, 4, 5),
(41, 5, 5),
(42, 6, 5),
(43, 7, 5),
(44, 8, 5),
(45, 9, 5),
(46, 1, 6),
(47, 2, 6),
(48, 3, 6),
(49, 4, 6),
(50, 5, 6),
(51, 6, 6),
(52, 7, 6),
(53, 8, 6),
(54, 9, 6),
(55, 1, 7),
(56, 2, 7),
(57, 3, 7),
(58, 4, 7),
(59, 5, 7),
(60, 6, 7),
(61, 7, 7),
(62, 8, 7),
(63, 9, 7);

--
-- Volcado de datos para la tabla `implemento`
--

INSERT INTO `implemento` (`ID_IMPLEMENTO`, `NOMBRE_IMPLEMENTO`, `DESCRIPCION_IMPLEMENTO`) VALUES
(1, 'Proyector', NULL),
(2, 'Computadores', 'Computadores disponibles para que los estudiantes ');

--
-- Volcado de datos para la tabla `implementos_modulo_tematico`
--

INSERT INTO `implementos_modulo_tematico` (`ID_IMPLEMENTO`, `ID_MODULO_TEM`) VALUES
(1, 3),
(1, 4),
(1, 5);

--
-- Volcado de datos para la tabla `modulo_horario`
--

INSERT INTO `modulo_horario` (`ID_MODULO`, `HORA_INI`, `HORA_FIN`) VALUES
(1, '08:00:00', '09:30:00'),
(2, '09:40:00', '11:10:00'),
(3, '11:20:00', '12:50:00'),
(4, '13:50:00', '15:20:00'),
(5, '15:30:00', '17:00:00'),
(6, '17:10:00', '18:40:00'),
(7, '19:00:00', '20:10:00'),
(8, '20:20:00', '22:00:00'),
(9, '22:00:00', '23:00:00');

--
-- Volcado de datos para la tabla `modulo_tematico`
--

INSERT INTO `modulo_tematico` (`ID_MODULO_TEM`, `NOMBRE_MODULO`, `DESCRIPCION_MODULO`) VALUES
(3, 'Estrategia y Habilidades Comunicacionales', 'Estrategia y Habilidades Comunicacionales'),
(4, 'Comunicación No Verbal', 'Comunicación No Verbal'),
(5, 'Comunicación y Cultura', 'Comunicación y Cultura');

--
-- Volcado de datos para la tabla `planificacion_clase`
--

INSERT INTO `planificacion_clase` (`ID_PLANIFICACION_CLASE`, `ID_SESION`, `ID_SALA`, `ID_AYU_PROFE`, `ID_SECCION`, `FECHA_PLANIFICADA`, `NUM_SESION_SECCION`) VALUES
(5, 7, 6, 7, 24, '2013-10-09', 1),
(6, 8, 6, 7, 24, '2013-10-16', 2),
(7, 9, 6, 7, 24, '2013-10-23', 3),
(8, 10, 6, 7, 24, '2013-10-30', 4),
(9, 11, 6, 7, 24, '2013-11-06', 5),
(10, 17, 6, 8, 24, '2013-11-13', 6),
(11, 18, 6, 8, 24, '2013-11-20', 7),
(12, 19, 6, 8, 24, '2013-11-27', 8),
(13, 20, 6, 8, 24, '2013-12-04', 9),
(14, 21, 6, 8, 24, '2013-12-11', 10),
(15, 12, 7, 9, 2, '2013-10-09', 1),
(16, 13, 7, 9, 2, '2013-10-16', 2),
(17, 14, 7, 9, 2, '2013-10-23', 3),
(18, 15, 7, 9, 2, '2013-10-30', 4),
(19, 16, 7, 9, 2, '2013-11-06', 5),
(20, 7, 7, 7, 2, '2013-11-13', 6),
(21, 8, 7, 7, 2, '2013-11-20', 7),
(22, 9, 7, 7, 2, '2013-11-27', 8),
(23, 10, 7, 7, 2, '2013-12-04', 9),
(24, 11, 7, 7, 2, '2013-12-11', 10),
(25, 12, 6, 9, 24, '2013-12-18', 11),
(26, 13, 6, 9, 24, '2013-12-25', 12),
(27, 14, 6, 9, 24, '2014-01-01', 13),
(28, 15, 6, 9, 24, '2014-01-08', 14),
(29, 16, 6, 9, 24, '2014-01-15', 15);

--
-- Volcado de datos para la tabla `profesor`
--

INSERT INTO `profesor` (`RUT_USUARIO`, `ID_TIPO_PROFESOR`, `ID_PROFESOR`) VALUES
(6784536, 1, 7),
(7387515, 1, 16),
(8408132, 1, 14),
(9218017, 1, 11),
(10203469, 2, 9),
(10441662, 1, 18),
(12248027, 2, 8),
(12446856, 1, 15),
(12677293, 1, 17),
(13891495, 1, 12),
(16125230, 1, 10),
(16240076, 1, 13);

--
-- Volcado de datos para la tabla `profe_equi_lider`
--

INSERT INTO `profe_equi_lider` (`ID_EQUIPO`, `RUT_USUARIO`, `LIDER_PROFESOR`) VALUES
(3, 10203469, 1),
(3, 10441662, 0),
(3, 9218017, 0),
(3, 8408132, 0),
(3, 12446856, 0),
(4, 6784536, 1),
(4, 16240076, 0),
(4, 16125230, 0),
(5, 12248027, 1),
(5, 12677293, 0),
(5, 13891495, 0),
(5, 7387515, 0),
(5, 10203469, 0);

--
-- Volcado de datos para la tabla `sala`
--

INSERT INTO `sala` (`ID_SALA`, `NUM_SALA`, `UBICACION`, `CAPACIDAD`) VALUES
(1, 711, 'MALL', 30),
(2, 712, 'MALL', 30),
(3, 565, 'EAO', 25),
(4, 564, 'EAO', 30),
(6, 254, 'CITECAMP', 40),
(7, 425, 'INDUSTRIA', 30);

--
-- Volcado de datos para la tabla `seccion`
--

INSERT INTO `seccion` (`ID_SECCION`, `ID_SESION`, `ID_HORARIO`, `LETRA_SECCION`, `NUMERO_SECCION`) VALUES
(2, 12, 20, 'A', 2),
(3, NULL, 20, 'B', 1),
(4, NULL, 29, 'B', 2),
(5, NULL, 29, 'C', 1),
(6, NULL, 29, 'C', 2),
(7, NULL, 29, 'C', 3),
(8, NULL, 29, 'C', 4),
(9, NULL, 30, 'D', 1),
(10, NULL, 30, 'D', 2),
(11, NULL, 30, 'D', 3),
(12, NULL, 30, 'D', 4),
(13, NULL, 23, 'E', 1),
(14, NULL, 23, 'E', 2),
(15, NULL, 23, 'E', 3),
(16, NULL, 23, 'E', 4),
(17, NULL, 24, 'F', 1),
(18, NULL, 24, 'F', 2),
(19, NULL, 24, 'F', 3),
(20, NULL, 32, 'G', 1),
(21, NULL, 32, 'G', 2),
(22, NULL, 33, 'H', 1),
(23, NULL, 33, 'H', 2),
(24, 7, 20, 'A', 1);

--
-- Volcado de datos para la tabla `sesion_de_clase`
--

INSERT INTO `sesion_de_clase` (`ID_SESION`, `ID_MODULO_TEM`, `NOMBRE_SESION`, `DESCRIPCION_SESION`) VALUES
(7, 4, 'No verbal clase 1', 'No verbal clase 1'),
(8, 4, 'No verbal clase 2', 'No verbal clase 2'),
(9, 4, 'No verbal clase 3', 'No verbal clase 3'),
(10, 4, 'No verbal clase 4', 'No verbal clase 4'),
(11, 4, 'No verbal clase 5', 'No verbal clase 5'),
(12, 3, 'Estrategias clase 1', 'Estrategias clase 1'),
(13, 3, 'Estrategias clase 2', 'Estrategias clase 2'),
(14, 3, 'Estrategias clase 3', 'Estrategias clase 3'),
(15, 3, 'Estrategias clase 4', 'Estrategias clase 4'),
(16, 3, 'Estrategias clase 5', 'Estrategias clase 5'),
(17, 5, 'Cultura clase 1', 'Cultura clase 1'),
(18, 5, 'Cultura clase 2', 'Cultura clase 2'),
(19, 5, 'Cultura clase 3', 'Cultura clase 3'),
(20, 5, 'Cultura clase 4', 'Cultura clase 4'),
(21, 5, 'Cultura clase 5', 'Cultura clase 5');

--
-- Volcado de datos para la tabla `tipo_profesor`
--

INSERT INTO `tipo_profesor` (`ID_TIPO_PROFESOR`, `TIPO_PROFESOR`) VALUES
(1, 'Por hora'),
(2, 'Jornada completa'),
(3, 'Media jornada');

--
-- Volcado de datos para la tabla `tipo_user`
--

INSERT INTO `tipo_user` (`ID_TIPO`, `NOMBRE_TIPO`) VALUES
(4, 'ayudante'),
(2, 'coordinador'),
(3, 'estudiante'),
(1, 'profesor');

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`RUT_USUARIO`, `ID_TIPO`, `PASSWORD_PRIMARIA`, `PASSWORD_TEMPORAL`, `CORREO1_USER`, `CORREO2_USER`, `VALIDEZ`, `NOMBRE1`, `NOMBRE2`, `APELLIDO1`, `APELLIDO2`, `TELEFONO`, `LOGUEABLE`) VALUES
(6784536, 1, 'd7ad5616fff18d1fd910e7c8d7c3bf52', NULL, 'pobletezapata@gmail.com', NULL, '2013-10-09 13:58:33', 'Roberto', NULL, 'Poblete', 'Zapata', 11111111, 1),
(7387515, 1, '713bdd662def3b2e0c15ac4582ae03ef', NULL, 'cereyes@u.uchile.cl', NULL, '2013-10-09 13:11:35', 'Cecilia', NULL, 'Reyes', 'Madriaza', NULL, 1),
(8408132, 1, '30ff10ae2416a3e13ceaee94adcdba4e', NULL, 'dmolina@puntonorte.cl', NULL, '2013-10-09 13:09:32', 'Daniel', NULL, 'Molina', 'Pavez', NULL, 1),
(9218017, 1, 'fd2948aa6bc94fe0c0b0a9d09cb405d2', NULL, 'eliana.covarrubias@usach.cl', NULL, '2013-10-09 13:06:24', 'Eliana', 'Berta', 'Covarrubias', 'Gatica', NULL, 1),
(10203469, 1, 'e10c629e90c0dcfb2a0a4cf36aad3305', NULL, 'claudio.agurto@puntonorte.c', NULL, '2013-10-09 13:02:33', 'Claudio', 'Andres', 'Agurto', 'Spencer', NULL, 1),
(10441662, 1, '5950591aa20bc83421d6c8f7a455531b', NULL, 'caterina.alessandrini@gmail.com', NULL, '2013-10-09 13:13:17', 'Caterina', NULL, 'Alessandrini', 'Szorenyi', NULL, 1),
(12248027, 1, 'eadf2d82fdbad8d153d49a70f632c0b8', NULL, 'eottoner@u.uchile.cl', NULL, '2013-10-09 13:04:03', 'Ernesto', NULL, 'Ottone', 'Ramirez', NULL, 1),
(12446856, 1, 'be36d515790911a7fedb3d95aff99a7a', NULL, 'mcrojas3@uc.cl', NULL, '2013-10-09 13:10:37', 'Maria', 'Cristina', 'Rojas', 'Gonzalez', NULL, 1),
(12677293, 1, 'e4758c639be5462a5af92d2242301610', NULL, 'aleibarra.a@gmail.com', NULL, '2013-10-09 13:12:19', 'Alejandra', NULL, 'Ibarra', 'Arriagada', NULL, 1),
(13891495, 1, 'a067fc74a79bb6a5cbb1345ecf0513dc', NULL, 'marianamilos@gmail.com', NULL, '2013-10-09 13:07:07', 'Mariana', NULL, 'Milos', 'Montes', NULL, 1),
(16125230, 1, 'eadf2d82fdbad8d153d49a70f632c0b8', NULL, 'guerra.espinozacarlos@hotmail.com', NULL, '2013-10-09 13:05:21', 'Carlos', 'Alberto', 'Guerra', 'Espinoza', NULL, 1),
(16240076, 1, '20dee2d0600533dc6d21ac2d8020a506', NULL, 'capinojtamara@gmail.com', NULL, '2013-10-09 13:08:46', 'Andrea', 'Tamara', 'Capino', 'Jorquera', NULL, 1),
(17242754, 4, '806b825fabc803278d5d44c4e02a5f74', NULL, 'alex.ahumada@usach.cl', NULL, '2013-09-15 22:18:50', 'Alex', 'Patricio', 'Ahumada', 'Ahumada', 22222222, 0),
(17565743, 2, '202cb962ac59075b964b07152d234b70', '8969a3761653f678f117e13dee887df1', 'victor.floress@usach.cl', NULL, '2013-10-07 06:34:48', 'Víctor', 'Manuel', 'Flores', 'Sánchez', 92656442, 1),
(17705318, 3, '92fb71f6dbd626e319cfbe304e686e25', NULL, 'carlos.barrerap@usach.cl', NULL, '2013-10-09 15:21:53', 'Carlos', 'Alfredo', 'Barrera', 'Pulgar', NULL, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
