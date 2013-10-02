-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 11-09-2013 a las 20:52:17
-- Versión del servidor: 5.5.24-log
-- Versión de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `manteka_db`
--

START TRANSACTION;

--
--
-- Volcado de datos para la tabla `tipo_user`
--
INSERT INTO `tipo_user` (`ID_TIPO`, `NOMBRE_TIPO`) VALUES
(1, 'profesor'),
(2, 'coordinador'),
(3, 'estudiante'),
(4, 'ayudante');


-- Volcado de datos para la tabla `tipo_profesor`
--
INSERT INTO `tipo_profesor` (`ID_TIPO_PROFESOR`, `TIPO_PROFESOR`) VALUES
(1, 'Por hora'),
(2, 'Jornada completa'),
(3, 'Media jornada');


-- Volcado de datos para la tabla `dia_horario`
--
INSERT INTO `dia_horario` (`ID_DIA`, `ABREVIATURA_DIA`, `NOMBRE_DIA`) VALUES
(1, 'L', 'Lunes'),
(2, 'M', 'Martes'),
(3, 'W', 'Miercoles'),
(4, 'J', 'Jueves'),
(5, 'V', 'Viernes'),
(6, 'S', 'Sabado'),
(7, 'D', 'Domingo');


-- Volcado de datos para la tabla `modulo_horario`
--
INSERT INTO `modulo_horario` (`ID_MODULO`, `HORA_INI`, `HORA_FIN`) VALUES
(1, '08:00', '09:30'),
(2, '09:40', '11:10'),
(3, '11:20', '12:50'),
(4, '13:50', '15:20'),
(5, '15:30', '17:00'),
(6, '17:10', '18:40'),
(7, '19:00', '20:10'),
(8, '20:20', '22:00'),
(9, '22:00', '23:00');


-- Volcado de datos para la tabla `horario`
--
INSERT INTO `horario` (`ID_HORARIO`, `ID_MODULO`, `ID_DIA`) VALUES
('1', 1, 1),
('10', 1, 2),
('11', 2, 2),
('12', 3, 2),
('13', 4, 2),
('14', 5, 2),
('15', 6, 2),
('16', 7, 2),
('17', 8, 2),
('18', 9, 2),
('19', 1, 3),
('2', 2, 1),
('20', 2, 3),
('21', 3, 3),
('22', 4, 3),
('23', 5, 3),
('24', 6, 3),
('25', 7, 3),
('26', 8, 3),
('27', 9, 3),
('28', 1, 4),
('29', 2, 4),
('3', 3, 1),
('30', 3, 4),
('31', 4, 4),
('32', 5, 4),
('33', 6, 4),
('34', 7, 4),
('35', 8, 4),
('36', 9, 4),
('37', 1, 5),
('38', 2, 5),
('39', 3, 5),
('4', 4, 1),
('40', 4, 5),
('41', 5, 5),
('42', 6, 5),
('43', 7, 5),
('44', 8, 5),
('45', 9, 5),
('46', 1, 6),
('47', 2, 6),
('48', 3, 6),
('49', 4, 6),
('5', 5, 1),
('50', 5, 6),
('51', 6, 6),
('52', 7, 6),
('53', 8, 6),
('54', 9, 6),
('55', 1, 7),
('56', 2, 7),
('57', 3, 7),
('58', 4, 7),
('59', 5, 7),
('6', 6, 1),
('60', 6, 7),
('61', 7, 7),
('62', 8, 7),
('63', 9, 7),
('7', 7, 1),
('8', 8, 1),
('9', 9, 1);


-- Volcado de datos para la tabla `sala`
--
INSERT INTO `sala` (`ID_SALA`, `NUM_SALA`, `UBICACION`, `CAPACIDAD`) VALUES
(1, '711', 'MALL', 30),
(2, '712', 'MALL', 30),
(3, '565', 'EAO', 25),
(4, '564', 'EAO', 30),
(6, '254', 'CITECAMP', 40),
(7, '425', 'INDUSTRIA', 30);


-- Volcado de datos para la tabla `carrera`
--
INSERT INTO `carrera` (`COD_CARRERA`, `NOMBRE_CARRERA`, `DESCRIPCION_CARRERA`) VALUES
(1351, 'Ingenieria Civil en Metalurgia', 'Metales\r'),
(1353, 'Ingenieria Civil en Informatica', 'Computacion\r'),
(1361, 'Ingenieria Civil en Obras Civiles', 'Edificacion\r'),
(1363, 'Ingenieria Civil en Industria', 'Empresa\r');


-- Volcado de datos para la tabla `seccion`
--
INSERT INTO `seccion` (`ID_SECCION`, `LETRA_SECCION`, `NUMERO_SECCION`, `ID_HORARIO`) VALUES
(1, 'A', 1, 20),
(2, 'A', 2, 20),
(3, 'B', 1, 20),
(4, 'B', 2, 29),
(5, 'C', 1, 29),
(6, 'C', 2, 29),
(7, 'C', 3, 29),
(8, 'C', 4, 29),
(9, 'D', 1, 30),
(10, 'D', 2, 30),
(11, 'D', 3, 30),
(12, 'D', 4, 30),
(13, 'E', 1, 23),
(14, 'E', 2, 23),
(15, 'E', 3, 23),
(16, 'E', 4, 23),
(17, 'F', 1, 24),
(18, 'F', 2, 24),
(19, 'F', 3, 24),
(20, 'G', 1, 32),
(21, 'G', 2, 32),
(22, 'H', 1, 33),
(23, 'H', 2, 33);


-- Volcado de datos para la tabla `implemento`
--
INSERT INTO `implemento` (`ID_IMPLEMENTO`, `NOMBRE_IMPLEMENTO`, `DESCRIPCION_IMPLEMENTO`) VALUES
(1, 'Proyector', NULL),
(2, 'Computadores', 'Computadores disponibles para que los estudiantes los utilicen.');


-- Volcado de datos para la tabla `usuario`
--
INSERT INTO `usuario` (`RUT_USUARIO`, `ID_TIPO`, `PASSWORD_PRIMARIA`, `PASSWORD_TEMPORAL`, `CORREO1_USER`, `CORREO2_USER`, `VALIDEZ`, `NOMBRE1`, `NOMBRE2`, `APELLIDO1`, `APELLIDO2`, `TELEFONO`, `LOGUEABLE`) VALUES
(16941031, 1, '258353f17feacf272bcf36cac249df42', NULL, 'fabian.arismendi@usach.cl', NULL, '2013-10-01 18:00:38', 'Fabian', NULL, 'Arismendi', 'Ferrada', 11111111, 1),
(17242754, 4, '806b825fabc803278d5d44c4e02a5f74', NULL, 'alex.ahumada@usach.cl', NULL, '2013-09-15 22:18:50', 'Alex', 'Patricio', 'Ahumada', 'Ahumada', 22222222, 0),
(17314314, 4, '93e66e9afa9305838f72ae3c9879c03d', NULL, 'olga.gajardo@usach.cl', NULL, '2013-09-15 16:27:01', 'Olga', NULL, 'Gajardo', 'Saavedra', NULL, 0),
(17316139, 3, '5a81a2e2f5afccd323e28b855ffc1f68', NULL, 'karin.prueba@usach.cl', NULL, '2013-09-29 16:20:31', 'Karin', 'Gisselle', 'Acevedo', 'Lizana', NULL, 0),
(17419849, 3, '50b87b5f34068f04ffedfbebfff5b245', NULL, 'karina.cuevas02@gmail.com\r\n', NULL, '2013-09-29 01:13:58', 'Karina', 'Karina', 'Cuevas', 'Concha', NULL, 0),
(17490314, 1, '8e2ac88a84b995bdfec563fc93505ec2', NULL, 'gary.fuenzalida@usach.cl', NULL, '2013-09-15 15:35:57', 'Gary', NULL, 'Fuenzalida', 'Navarrete', 11111111, 1),
(17565743, 2, '202cb962ac59075b964b07152d234b70', '38f63f5000e2fd4faff655cb1b52ec90', 'victor.floress@usach.cl', NULL, '2013-10-02 19:05:52', 'VÃ­ctor', 'Manuel', 'Flores', 'SÃ¡nchez', 92656442, 1),
(17705318, 1, 'cb31dcc21d3a3ba2dc4dba8dccf0a24c', NULL, 'carlos.barrerap@usach.cl', NULL, '2013-09-29 20:44:13', 'Carlos', 'Alfredo', 'Barrera', 'Pulgar', 66666661, 1),
(17705959, 1, 'a488786e726d533f97256e3f048a0c21', NULL, 'andres.arismendi@usach.cl', NULL, '2013-10-01 18:02:04', 'Andres', NULL, 'Arismendi', 'Ferrada', 11111111, 1);


-- Volcado de datos para la tabla `coordinador`
--
INSERT INTO `coordinador` (`RUT_USUARIO`, `ID_COORDINADOR`) VALUES
(17565743, 1);


-- Volcado de datos para la tabla `profesor`
--
INSERT INTO `profesor` (`RUT_USUARIO`, `ID_TIPO_PROFESOR`, `ID_PROFESOR`) VALUES
(16941031, 2, 4),
(17490314, 2, 3),
(17705318, 1, 1),
(17705959, 1, 5);


-- Volcado de datos para la tabla `ayudante`
--
INSERT INTO `ayudante` (`RUT_USUARIO`, `ID_AYUDANTE`) VALUES
(17242754, 1);


INSERT INTO `ayu_profe` (`ID_AYU_PROFE`, `RUT_USUARIO`, `PRO_RUT_USUARIO`) VALUES
(1, 17242754, 17705318),
(3, NULL, 16941031),
(4, NULL, 17490314),
(5, NULL, 17705959);


-- Volcado de datos para la tabla `estudiante`
--
INSERT INTO `estudiante` (`RUT_USUARIO`, `COD_CARRERA`, `ID_SECCION`, `ID_ESTUDIANTE`) VALUES
(17314314, 1363, 1, 1),
(17316139, 1361, 1, 14),
(17419849, 1363, 1, 8);


INSERT INTO `modulo_tematico` (`ID_MODULO_TEM`, `NOMBRE_MODULO`, `DESCRIPCION_MODULO`) VALUES
(1, 'Comunicacion no verbal', 'bla'),
(2, 'Medios de comunicacion', 'fdsghdsfdg');


INSERT INTO `evaluacion` (`ID_EVALUACION`, `ID_MODULO_TEM`) VALUES
(1, 1),
(2, 2);


INSERT INTO `implementos_modulo_tematico` (`ID_IMPLEMENTO`, `ID_MODULO_TEM`) VALUES
(1, 1),
(1, 2),
(2, 2);


INSERT INTO `equipo_profesor` (`ID_EQUIPO`, `ID_MODULO_TEM`) VALUES
(1, 1),
(2, 2);


INSERT INTO `profe_equi_lider` (`ID_EQUIPO`, `RUT_USUARIO`, `LIDER_PROFESOR`) VALUES
(1, 17705318, 1),
(1, 17490314, 0),
(2, 16941031, 1),
(2, 17705959, 0);


INSERT INTO `sesion_de_clase` (`ID_SESION`, `ID_MODULO_TEM`, `NOMBRE_SESION`, `DESCRIPCION_SESION`) VALUES
(1, 1, 'Clase no-verbal 1', 'sdfdf'),
(2, 1, 'Clase no-verbal 2', 'sfddfsdf'),
(3, 1, 'Clase no-verbal 3', 'dfffvxvf'),
(4, 2, 'Clase medios 1', ''),
(5, 2, 'Clase medios 2', ''),
(6, 2, 'Clase medios 3', 'dfdfg');


INSERT INTO `planificacion_clase` (`ID_PLANIFICACION_CLASE`, `ID_SESION`, `ID_SALA`, `ID_AYU_PROFE`, `ID_SECCION`, `FECHA_PLANIFICADA`) VALUES
(1, 1, 6, 1, 1, '2013-10-02'),
(2, 2, 6, 1, 1, '2013-10-09'),
(3, 3, 6, 1, 1, '2013-10-16'),
(4, 1, 7, 4, 5, '2013-10-17');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
