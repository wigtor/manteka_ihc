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

INSERT INTO `manteka_db`.`seccion` (`ID_SECCION`, `ID_SESION`, `NOMBRE_SECCION`) VALUES (NULL, NULL, 'A-01'), (NULL, NULL, 'B-02');


INSERT INTO `tipo_user` (`ID_TIPO`, `NOMBRE_TIPO`) VALUES
(1, 'profesor'),
(2, 'coordinador'),
(3, 'estudiante'),
(4, 'ayudante');

INSERT INTO `tipo_profesor` (`ID_TIPO_PROFESOR`, `TIPO_PROFESOR`) VALUES
(1, 'Por hora'),
(2, 'Jornada completa'),
(3, 'Media jornada');

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`RUT_USUARIO`, `ID_TIPO`, `PASSWORD_PRIMARIA`, `PASSWORD_TEMPORAL`, `CORREO1_USER`, `CORREO2_USER`, `VALIDEZ`, `NOMBRE1`, `NOMBRE2`, `APELLIDO1`, `APELLIDO2`, `TELEFONO`, `LOGUEABLE`) VALUES
(17565743, 2, '202cb962ac59075b964b07152d234b70', NULL, 'victor.floress@usach.cl', NULL, '2013-09-11 20:37:50', 'Víctor', 'Manuel', 'Flores', 'Sánchez', 92656442, 1);

-- Volcado de datos para la tabla `coordinador`
--

INSERT INTO `coordinador` (`RUT_USUARIO`, `ID_COORDINADOR`) VALUES
(17565743, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
