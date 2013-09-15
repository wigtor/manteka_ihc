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

-- Volcado de datos para la tabla `carrera`
--
INSERT INTO `carrera` (`COD_CARRERA`, `NOMBRE_CARRERA`, `DESCRIPCION_CARRERA`) VALUES
(1863, 'Ingeniería civil informática', 'Ñoños'),
(1864, 'Ingeniería civil industrial', 'Jefecitos'),
(1862, 'Ingeniería civil eléctrica', 'eleutronicos');


-- Volcado de datos para la tabla `seccion`
--
INSERT INTO `seccion` (`ID_SECCION`, `LETRA_SECCION`, `NUMERO_SECCION`) VALUES
(1, 'A', 1),
(2, 'B', 2);


--
-- Volcado de datos para la tabla `usuario`
--
INSERT INTO `usuario` (`RUT_USUARIO`, `ID_TIPO`, `PASSWORD_PRIMARIA`, `PASSWORD_TEMPORAL`, `CORREO1_USER`, `CORREO2_USER`, `VALIDEZ`, `NOMBRE1`, `NOMBRE2`, `APELLIDO1`, `APELLIDO2`, `TELEFONO`, `LOGUEABLE`) VALUES
(16941031, 2, '258353f17feacf272bcf36cac249df42', NULL, 'fabian.arismendi@usach.cl', NULL, '2013-09-15 16:31:29', 'FabiÃ¡n', NULL, 'Arismendi', 'Ferrada', 11111111, 1),
(17314314, 4, '93e66e9afa9305838f72ae3c9879c03d', NULL, 'olga.gajardo@usach.cl', NULL, '2013-09-15 16:27:01', 'Olga', NULL, 'Gajardo', 'Saavedra', NULL, 0),
(17242754, 4, '806b825fabc803278d5d44c4e02a5f74', NULL, 'alex.ahumada@usach.cl', NULL, '2013-09-15 22:18:50', 'Alex', 'Patricio', 'Ahumada', 'Ahumada', 22222222, 0),
(17490314, 1, '8e2ac88a84b995bdfec563fc93505ec2', NULL, 'gary.fuenzalida@usach.cl', NULL, '2013-09-15 15:35:57', 'Gary', NULL, 'Fuenzalida', 'Navarrete', 11111111, 1),
(17565743, 2, '202cb962ac59075b964b07152d234b70', NULL, 'victor.floress@usach.cl', NULL, '2013-09-15 16:31:22', 'VÃ­ctor', 'Manuel', 'Flores', 'SÃ¡nchez', 92656442, 1),
(17705318, 1, '92fb71f6dbd626e319cfbe304e686e25', NULL, 'carlos.barrerap@usach.cl', NULL, '2013-09-15 16:31:18', 'Carlos', 'Alfredo', 'Barrera', 'Pulgar', 66666661, 1);


-- Volcado de datos para la tabla `coordinador`
--
INSERT INTO `coordinador` (`RUT_USUARIO`, `ID_COORDINADOR`) VALUES
(17565743, 1),
(16941031, 4);


-- Volcado de datos para la tabla `profesor`
--
INSERT INTO `profesor` (`RUT_USUARIO`, `ID_TIPO_PROFESOR`, `ID_PROFESOR`) VALUES
(17490314, 2, 3),
(17705318, 1, 1);


-- Volcado de datos para la tabla `ayudante`
--
INSERT INTO `ayudante` (`RUT_USUARIO`, `ID_AYUDANTE`) VALUES
(17242754, 1);


--
-- Volcado de datos para la tabla `ayu_profe`
--
INSERT INTO `ayu_profe` (`ID_SECCION`, `RUT_USUARIO`, `PRO_RUT_USUARIO`) VALUES
(NULL, 17242754, 17705318);


-- Volcado de datos para la tabla `estudiante`
--
INSERT INTO `estudiante` (`RUT_USUARIO`, `COD_CARRERA`, `ID_SECCION`, `ID_ESTUDIANTE`) VALUES
(17314314, 1863, 1, 1);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
