-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 02-07-2013 a las 03:10:17
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad_masiva`
--

CREATE TABLE IF NOT EXISTS `actividad_masiva` (
  `COD_ACTIVIDAD_MASIVA` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_ACT` varchar(20) CHARACTER SET latin1 NOT NULL,
  `FECHA` date NOT NULL,
  `LUGAR_ACT` varchar(20) CHARACTER SET latin1 NOT NULL,
  `LUGAR_RETIRAR_ENTRADA` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`COD_ACTIVIDAD_MASIVA`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='El curso tiene programa 3 salidas extraprogramáticas, obre d' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `act_estudiante`
--

CREATE TABLE IF NOT EXISTS `act_estudiante` (
  `RUT_ESTUDIANTE` int(11) NOT NULL,
  `COD_ACTIVIDAD_MASIVA` int(11) NOT NULL,
  KEY `RUT_ESTUDIANTE` (`RUT_ESTUDIANTE`),
  KEY `COD_ACTIVIDAD_MASIVA` (`COD_ACTIVIDAD_MASIVA`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='Se utiliza con el fin de representar que muchos estudiantes ';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adjunto`
--

CREATE TABLE IF NOT EXISTS `adjunto` (
  `COD_ADJUNTO` int(11) NOT NULL AUTO_INCREMENT,
  `COD_CORREO` int(11) NOT NULL,
  `NOMBRE_LOGICO_ADJUNTO` varchar(70) CHARACTER SET latin1 NOT NULL,
  `NOMBRE_FISICO_ADJUNTO` varchar(70) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`COD_ADJUNTO`),
  KEY `FK_RELATIONSHIP_60` (`COD_CORREO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoria`
--

CREATE TABLE IF NOT EXISTS `auditoria` (
  `COD_AUDITORIA` int(11) NOT NULL AUTO_INCREMENT,
  `RUT_AUDITORIA` int(11) NOT NULL,
  `ASUNTO_AUDITORIA` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `TIPO_AUDITORIA` varchar(10) CHARACTER SET latin1 NOT NULL,
  `FECHA_AUDITORIA` date NOT NULL,
  `HORA_AUDITORIA` time NOT NULL,
  PRIMARY KEY (`COD_AUDITORIA`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='Se utiliza para realizar un registro de los datos que son re' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ayudante`
--

CREATE TABLE IF NOT EXISTS `ayudante` (
  `RUT_AYUDANTE` int(11) NOT NULL,
  `NOMBRE1_AYUDANTE` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `NOMBRE2_AYUDANTE` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `APELLIDO1_AYUDANTE` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `APELLIDO2_AYUDANTE` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `CORREO_AYUDANTE` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`RUT_AYUDANTE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='Las secciones cuentan con ayudante a los que el sistema debe';

--
-- Volcado de datos para la tabla `ayudante`
--

INSERT INTO `ayudante` (`RUT_AYUDANTE`, `NOMBRE1_AYUDANTE`, `NOMBRE2_AYUDANTE`, `APELLIDO1_AYUDANTE`, `APELLIDO2_AYUDANTE`, `CORREO_AYUDANTE`) VALUES
(1, 'j', 'j', 'j', 'j', 'j@j.cl'),
(12312312, 'sdasd', 'asdasd', 'asdasd', 'sadasd', 'asdkas@askdhas.c'),
(17463076, 'C?SAR', 'ANDR?S', 'VIVANCO', 'SAN MARTIN', 'cvivanco@usach.cl\r'),
(17477156, 'CARLOS', 'FRANCISCO', 'VILLALOBOS', 'AGUILERA', 'cvillalobos@usach.cl\r'),
(18030776, 'EDUARDO', 'ANTONIO', 'SOTO', 'FIGUEROA', 'esoto@usach.cl\r'),
(18171166, 'ROGER', 'PATRICIO', 'WITT', 'MONTERO', 'rwitt@usach.cl\r'),
(18245726, 'FABI?N', 'ALEXIS', 'SERRANO', 'PINOCHET', 'fserrano@usach.cl\r'),
(18413525, '?LVARO', 'HERN?N', 'ULLOA', 'RUBILAR', 'arubilar@usach.cl\r'),
(18635643, 'CAMILO', 'ANTONIO', 'VALENCIA', 'LEAL', 'cvalencia@usach.cl\r'),
(18635999, 'NICOL?S', 'ESTEBAN', 'VALLADARES', 'P?REZ', 'nvalladares@usach.cl\r'),
(111111110, 'a', '', 'a', 'a', 'a@a.cl');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ayu_profe`
--

CREATE TABLE IF NOT EXISTS `ayu_profe` (
  `RUT_USUARIO2` int(11) NOT NULL,
  `RUT_AYUDANTE` int(11) NOT NULL,
  `COD_SECCION` int(11) DEFAULT NULL,
  KEY `RUT_USUARIO2` (`RUT_USUARIO2`),
  KEY `RUT_AYUDANTE` (`RUT_AYUDANTE`),
  KEY `COD_SECCION` (`COD_SECCION`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `ayu_profe`
--

INSERT INTO `ayu_profe` (`RUT_USUARIO2`, `RUT_AYUDANTE`, `COD_SECCION`) VALUES
(8634324, 17463076, 2),
(16434566, 18030776, 1),
(8634324, 1, NULL),
(175863419, 111111110, NULL),
(175863419, 111111110, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `borrador`
--

CREATE TABLE IF NOT EXISTS `borrador` (
  `COD_BORRADOR` int(11) NOT NULL AUTO_INCREMENT,
  `COD_CORREO` int(11) NOT NULL,
  `FECHA_BORRADOR` date NOT NULL,
  `HORA_BORRADOR` time NOT NULL,
  PRIMARY KEY (`COD_BORRADOR`),
  KEY `FK_RELATIONSHIP_45` (`COD_CORREO`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `borrador`
--

INSERT INTO `borrador` (`COD_BORRADOR`, `COD_CORREO`, `FECHA_BORRADOR`, `HORA_BORRADOR`) VALUES
(1, 1, '2013-06-15', '02:51:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrera`
--

CREATE TABLE IF NOT EXISTS `carrera` (
  `COD_CARRERA` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_CARRERA` varchar(100) NOT NULL,
  `DESCRIPCION_CARRERA` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`COD_CARRERA`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Estas son las carreras pertenecientes a la Faculdad de Ingen' AUTO_INCREMENT=1364 ;

--
-- Volcado de datos para la tabla `carrera`
--

INSERT INTO `carrera` (`COD_CARRERA`, `NOMBRE_CARRERA`, `DESCRIPCION_CARRERA`) VALUES
(1351, 'Ingenieria Civil en Metalurgia', 'Metales\r'),
(1353, 'Ingenieria Civil en Informatica', 'Computacion\r'),
(1361, 'Ingenieria Civil en Obras Civiles', 'Edificacion\r'),
(1363, 'Ingenieria Civil en Industria', 'Empresa\r');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carta`
--

CREATE TABLE IF NOT EXISTS `carta` (
  `COD_CORREO` int(11) NOT NULL AUTO_INCREMENT,
  `COD_BORRADOR` int(11) DEFAULT NULL,
  `ID_PLANTILLA` int(11) DEFAULT NULL,
  `RUT_USUARIO` int(11) NOT NULL,
  `COD2_CORREO` varchar(30) NOT NULL,
  `HORA` time NOT NULL,
  `FECHA` date NOT NULL,
  `CUERPO_EMAIL` text,
  `ASUNTO` varchar(40) NOT NULL,
  `ENVIADO_CARTA` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`COD_CORREO`),
  KEY `FK_RELATIONSHIP_22` (`ID_PLANTILLA`),
  KEY `FK_RELATIONSHIP_43` (`RUT_USUARIO`),
  KEY `FK_RELATIONSHIP_44` (`COD_BORRADOR`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Esta carta representa la posibilidad de crear un mail y pode' AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `carta`
--

INSERT INTO `carta` (`COD_CORREO`, `COD_BORRADOR`, `ID_PLANTILLA`, `RUT_USUARIO`, `COD2_CORREO`, `HORA`, `FECHA`, `CUERPO_EMAIL`, `ASUNTO`, `ENVIADO_CARTA`) VALUES
(1, 1, NULL, 17586341, '20130615065124', '02:51:24', '2013-06-15', '', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cartar_ayudante`
--

CREATE TABLE IF NOT EXISTS `cartar_ayudante` (
  `COD_CORREO` int(11) NOT NULL,
  `RUT_AYUDANTE` int(11) NOT NULL,
  KEY `FK_RELATIONSHIP_35` (`RUT_AYUDANTE`),
  KEY `FK_RELATIONSHIP_36` (`COD_CORREO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Representa la posibilidad que tiene un coordinador de enviar';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cartar_estudiante`
--

CREATE TABLE IF NOT EXISTS `cartar_estudiante` (
  `RUT_ESTUDIANTE` int(11) NOT NULL,
  `COD_CORREO` int(11) NOT NULL,
  KEY `FK_RELATIONSHIP_31` (`COD_CORREO`),
  KEY `FK_RELATIONSHIP_53` (`RUT_ESTUDIANTE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Representa la posibilidad que tiene un coordinador de enviar';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cartar_persona`
--

CREATE TABLE IF NOT EXISTS `cartar_persona` (
  `COD_PERSONA` int(11) NOT NULL,
  `COD_CORREO` int(11) NOT NULL,
  KEY `FK_RELATIONSHIP_46` (`COD_PERSONA`),
  KEY `FK_RELATIONSHIP_47` (`COD_CORREO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cartar_user`
--

CREATE TABLE IF NOT EXISTS `cartar_user` (
  `COD_CORREO` int(11) NOT NULL,
  `RUT_USUARIO` int(11) NOT NULL,
  `RECIBIDO_CARTA_USER` int(1) NOT NULL DEFAULT '1',
  `NO_LEIDO_CARTA_USER` int(1) NOT NULL DEFAULT '1',
  KEY `FK_RELATIONSHIP_29` (`COD_CORREO`),
  KEY `FK_RELATIONSHIP_30` (`RUT_USUARIO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Representa la posibilidad que tiene un coordinador de enviar';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coordinador`
--

CREATE TABLE IF NOT EXISTS `coordinador` (
  `RUT_USUARIO3` int(11) NOT NULL,
  `NOMBRE1_COORDINADOR` varchar(20) NOT NULL,
  `NOMBRE2_COORDINADOR` varchar(20) DEFAULT NULL,
  `APELLIDO1_COORDINADOR` varchar(20) NOT NULL,
  `APELLIDO2_COORDINADOR` varchar(20) NOT NULL,
  `TELEFONO_COORDINADOR` int(11) DEFAULT NULL,
  PRIMARY KEY (`RUT_USUARIO3`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `coordinador`
--

INSERT INTO `coordinador` (`RUT_USUARIO3`, `NOMBRE1_COORDINADOR`, `NOMBRE2_COORDINADOR`, `APELLIDO1_COORDINADOR`, `APELLIDO2_COORDINADOR`, `TELEFONO_COORDINADOR`) VALUES
(17427647, 'Paz ', 'Alejandra', 'Bustos', 'Bustos', 4444444),
(17453543, 'Fernando ', 'Pedro', 'Contreras', 'Contreras', 6666666),
(17486324, 'Max', 'Juan', 'Chacon', 'Chacon', 7777777),
(17586341, 'Diego', 'Nicolas', 'Escobar', 'Escobar', 7467464),
(17725373, 'Matias ', 'Jose', 'Garcia', 'Garcia', 5555555);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cron_jobs`
--

CREATE TABLE IF NOT EXISTS `cron_jobs` (
  `ID_JOB` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(255) DEFAULT NULL,
  `PROXIMA_EJECUCION` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PATH_PHP_TO_EXEC` varchar(255) NOT NULL,
  `PERIODICITY_MINUTES` bigint(20) NOT NULL DEFAULT '5',
  PRIMARY KEY (`ID_JOB`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabla en que se almacenan la hora en que ciertas tareas pueden ser ejecutadas' AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `cron_jobs`
--

INSERT INTO `cron_jobs` (`ID_JOB`, `DESCRIPCION`, `PROXIMA_EJECUCION`, `PATH_PHP_TO_EXEC`, `PERIODICITY_MINUTES`) VALUES
(1, 'PHP que ejecuta borra los correos rebotados', '2013-06-29 17:37:15', 'imap.php', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dia`
--

CREATE TABLE IF NOT EXISTS `dia` (
  `COD_DIA` int(11) NOT NULL AUTO_INCREMENT,
  `COD_ABREVIACION_DIA` varchar(3) NOT NULL,
  `NOMBRE_DIA` varchar(10) NOT NULL,
  PRIMARY KEY (`COD_DIA`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Se utiliza para indicar los días que hay clases.' AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `dia`
--

INSERT INTO `dia` (`COD_DIA`, `COD_ABREVIACION_DIA`, `NOMBRE_DIA`) VALUES
(1, 'L', 'Lunes'),
(2, 'M', 'Martes'),
(3, 'W', 'Miercoles'),
(4, 'J', 'Jueves'),
(5, 'V', 'Viernes'),
(6, 'S', 'Sabado'),
(7, 'D', 'Domingo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo_profesor`
--

CREATE TABLE IF NOT EXISTS `equipo_profesor` (
  `COD_EQUIPO` int(11) NOT NULL AUTO_INCREMENT,
  `COD_MODULO_TEM` int(11) DEFAULT NULL,
  PRIMARY KEY (`COD_EQUIPO`),
  KEY `COD_MODULO_TEM` (`COD_MODULO_TEM`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Existe un equipo de profesores por cada modulo temático(Unid' AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `equipo_profesor`
--

INSERT INTO `equipo_profesor` (`COD_EQUIPO`, `COD_MODULO_TEM`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE IF NOT EXISTS `estudiante` (
  `RUT_ESTUDIANTE` int(11) NOT NULL,
  `COD_CARRERA` int(11) NOT NULL,
  `COD_SECCION` int(11) NOT NULL,
  `NOMBRE1_ESTUDIANTE` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `NOMBRE2_ESTUDIANTE` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `APELLIDO1_ESTUDIANTE` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `APELLIDO2_ESTUDIANTE` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `CORREO_ESTUDIANTE` varchar(200) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`RUT_ESTUDIANTE`),
  KEY `FK_RELATIONSHIP_51` (`COD_SECCION`),
  KEY `COD_CARRERA` (`COD_CARRERA`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `estudiante`
--

INSERT INTO `estudiante` (`RUT_ESTUDIANTE`, `COD_CARRERA`, `COD_SECCION`, `NOMBRE1_ESTUDIANTE`, `NOMBRE2_ESTUDIANTE`, `APELLIDO1_ESTUDIANTE`, `APELLIDO2_ESTUDIANTE`, `CORREO_ESTUDIANTE`) VALUES
(0, 1351, 2, 'a', 'aa', 'a', 'a', 'ADAS@ASKDNASD.CL'),
(11111111, 1351, 2, 'ÑOÑÑOÑÑASDASÁÁÁÁÉÉÍ', 'ÑOÑÑASDASÁÁÁÁÉÉÍ', 'ÑOÑÑASDASÁÁÁÁÉÉÍ', 'ÑOÑÑASDASÁÁÁÁÉÉÍ', 'ADAS@ASKDNASD.CL'),
(14644776, 1361, 1, 'KOOK', '', 'LEE', 'KIM', 'prueba@usach.cl\r'),
(16265644, 1361, 2, 'PATRICIO', 'GREGORY', 'GONZALEZ', 'GARAY', 'prueba@usach.cl\r'),
(16915876, 1353, 2, 'PAULO', 'CÉSAR', 'REYES', 'HERNÁNDEZ', 'prueba@usach.cl\r'),
(16925057, 1353, 1, 'DANIEL', 'IGNACIO', 'BROWN', 'MADARIAGA', 'prueba@usach.cl\r'),
(17032697, 1361, 2, 'GONZALO', 'EDUARDO', 'REVECO', 'OSORIO', 'prueba@usach.cl\r'),
(17316762, 1361, 1, 'ALEJANDRO', 'RENÉ', 'OLIVARES', 'MOLINA', 'prueba@usach.cl\r'),
(17488189, 1361, 1, 'LUIS', 'ALBERTO', 'RUBIO', 'PRADENAS', 'prueba@usach.cl\r'),
(17489516, 1351, 2, 'MAURICIO', 'ALEJANDRO', 'AVILÉS', 'ORELLANA', 'prueba@usach.cl\r'),
(17521342, 1363, 2, 'PABLO', 'FELIPE', 'CABALLERO', 'ACOSTA', 'prueba@usach.cl\r'),
(17590618, 1361, 2, 'DAVID', 'HERNÁN', 'GUAJARDO', 'ALEGRIA', 'prueba@usach.cl\r'),
(17786933, 1361, 2, 'ISAAC', 'ARON', 'VALDEBENITO', 'ESCOBAR', 'prueba@usach.cl\r'),
(18019407, 1361, 2, 'RASHEL', 'NICOL', 'VALENZUELA', 'CASTILLO', 'prueba@usach.cl\r'),
(18022192, 1361, 1, 'CAMILA', 'FERNANDA', 'NUÑEZ', 'NUÑEZ', 'prueba@usach.cl\r'),
(18030945, 1351, 1, 'PEDRO', 'SEBASTIÁN', 'CARTAGENA', 'FARIAS', 'prueba@usach.cl\r'),
(18056644, 1353, 1, 'CAMILO', 'IGNACIO', 'MORENO', 'SÁNCHEZ', 'prueba@usach.cl\r'),
(18082307, 1361, 2, 'CRISTOPHER', 'GIANINNI', 'RUIZ', 'PONCE', 'prueba@usach.cl\r'),
(18084284, 1361, 2, 'GABRIEL', 'ANDRÉS', 'RAMOS', 'COLOMBO', 'prueba@usach.cl\r'),
(18085034, 1361, 2, 'GABRIEL', 'HERNÁN', 'SALINAS', 'FLORES', 'prueba@usach.cl\r'),
(18117016, 1353, 1, 'CRISTIÁN', 'MANUEL', 'FERNÁNDEZ', 'VÁSQUEZ', 'prueba@usach.cl\r'),
(18119830, 1361, 1, 'CRISTIAN', 'OSVALDO', 'SEPÚLVEDA', 'ORMAZÁBAL', 'prueba@usach.cl\r'),
(18121680, 1361, 1, 'VALTER', 'ANDRÉS', 'FLORES', 'BARRÍOS', 'prueba@usach.cl\r'),
(18127100, 1361, 1, 'AMARO', 'SALVADOR', 'BENAVENTE', 'MARÍN', 'prueba@usach.cl\r'),
(18131371, 1363, 2, 'SIMÓNEI', 'ANYELINA', 'SEPULVEDA', 'QUINTANA', 'prueba@usach.cl\r'),
(18169460, 1361, 2, 'FELIPE', 'IGNACIO', 'HENRÍQUEZ', 'ENSEMEYER', 'prueba@usach.cl\r'),
(18170579, 1361, 2, 'CRISTIÁN', 'ANDRÉS', 'FIGUEROA', 'SARAVIA', 'prueba@usach.cl\r'),
(18190871, 1351, 1, 'CAMILO', 'IGNACIO', 'CONTRERAS', 'JARA', 'prueba@usach.cl\r'),
(18192200, 1351, 1, 'JULIO', 'CÉSAR', 'ARAYA', 'HERNANDEZ', 'prueba@usach.cl\r'),
(18209710, 1361, 1, 'HEDER', 'ANDRÉS', 'GAJARDO', 'VILLEGAS', 'prueba@usach.cl\r'),
(18212020, 1353, 1, 'KARLA', '', 'ROJAS', 'GODOY', 'prueba@usach.cl\r'),
(18221949, 1361, 2, 'CRISTOPHER', 'CRISTOPHER', 'ROZAS', 'LARA', 'prueba@usach.cl\r'),
(18226427, 1361, 1, 'JORGE', 'ISMAEL', 'CORTES', 'LOPEZ', 'prueba@usach.cl\r'),
(18244771, 1361, 2, 'DANIEL', 'IGNACIO', 'MILLAQUEO', 'FUENTES', 'prueba@usach.cl\r'),
(18245410, 1361, 1, 'ALEX', 'GERMAN', 'VILLAGRAN', 'GUERRERO', 'prueba@usach.cl\r'),
(18275245, 1361, 1, 'RODRIGO', 'ESTEBAN', 'SÁNCHEZ', 'AGUILERA', 'prueba@usach.cl\r'),
(18275876, 1361, 2, 'VÍCTOR', 'GABRIEL', 'ARENAS', 'DIAZ', 'prueba@usach.cl\r'),
(18278199, 1361, 2, 'SEBASTIÁN', 'ANDRÉS', 'SUAREZ', 'OLIVARES', 'prueba@usach.cl\r'),
(18293642, 1351, 2, 'FRANCISCA', 'ANDREA', 'GONZÁLEZ', 'CONTRERAS', 'prueba@usach.cl\r'),
(18294257, 1361, 2, 'FELIPE', 'ANTONIO', 'GÓMEZ', 'DANITZ', 'prueba@usach.cl\r'),
(18295036, 1361, 1, 'CRISTOBAL', 'IGNACIO', 'ZUÑIGA', 'BRAGADO', 'prueba@usach.cl\r'),
(18328885, 1351, 1, 'DIEGO', 'FELIPE', 'CARRASCO', 'AGUILERA', 'prueba@usach.cl\r'),
(18330539, 1361, 1, 'MAICOL', 'AARON', 'RODRIGUEZ', 'BRAVO', 'prueba@usach.cl\r'),
(18336247, 1351, 2, 'DAVID', 'MANUEL', 'MOLINA', 'OLATE', 'prueba@usach.cl\r'),
(18337508, 1361, 2, 'GLADYS', 'MARGARITA', 'GONZALEZ', 'CERDA', 'prueba@usach.cl\r'),
(18347761, 1361, 1, 'MANUEL', 'ANTONIO', 'VERA', 'PEIRE', 'prueba@usach.cl\r'),
(18375756, 1363, 1, 'CLAUDIO', 'ELÍAS', 'DEL PINO', 'VÁSQUEZ', 'prueba@usach.cl\r'),
(18391954, 1361, 2, 'CAMILO', 'NICOLÁS', 'PAVEZ', 'ARRIAGADA', 'prueba@usach.cl\r'),
(18393541, 1361, 1, 'RAMSES', '', 'ESTAY', 'LEAL', 'prueba@usach.cl\r'),
(18395397, 1361, 1, 'JENIFFER', 'FRANCISCA', 'MUÑOZ', 'OJEDA', 'prueba@usach.cl\r'),
(18409359, 1363, 2, 'PATRICIO', 'ENRIQUE', 'TAPIA', 'MANZANO', 'prueba@usach.cl\r'),
(18445926, 1361, 2, 'FRANCO', 'ARIEL', 'BAEZA', 'ZUÑIGA', 'prueba@usach.cl\r'),
(18452369, 1361, 2, 'NICOLÁS', 'ALEJANDRO', 'CALDERON', 'PEÑA', 'prueba@usach.cl\r'),
(18455796, 1361, 1, 'DAVID', 'ALFREDO', 'PALMA', 'MORENO', 'prueba@usach.cl\r'),
(18460875, 1361, 2, 'GONZALO', 'ANDRÉS', 'SALAS', 'PASTENE', 'prueba@usach.cl\r'),
(18464191, 1363, 2, 'RENÉ', 'IGNACIO', 'ZARATE', 'MENESES', 'prueba@usach.cl\r'),
(18464353, 1363, 1, 'ALEJANDRO', 'ESTEBAN', 'AEDO', 'ROJAS', 'prueba@usach.cl\r'),
(18466293, 1361, 2, 'FELIPE', 'ANDRÉS', 'PÉREZ', 'DUARTE', 'prueba@usach.cl\r'),
(18479122, 1361, 1, 'PAULO', 'ANDRÉS', 'ALTAMIRANO', 'VERA', 'prueba@usach.cl\r'),
(18480825, 1361, 2, 'DANIEL', 'ESTEBAN', 'CANAVES', 'FARIAS', 'prueba@usach.cl\r'),
(18512722, 1351, 1, 'DANIEL', 'ESTEBAN', 'GALDAMES', 'GONZALEZ', 'prueba@usach.cl\r'),
(18527760, 1351, 2, 'MARCELO', 'EDUARDO VALENTIN', 'ROSAS', 'ROMAN', 'prueba@usach.cl\r'),
(18528754, 1361, 1, 'CARIS', 'RAQUEL', 'SANHUEZA', 'CAMPOS', 'prueba@usach.cl\r'),
(18529087, 1361, 1, 'NICOLÁS', 'IGNACIO', 'GOMEZ', 'BENAVIDES', 'prueba@usach.cl\r'),
(18533204, 1351, 2, 'RODRIGO', 'ANTONIO', 'GAETE', 'SILVA', 'prueba@usach.cl\r'),
(18535399, 1361, 1, 'XAVIER', 'MARCOS', 'COMTE', 'RAMOS', 'prueba@usach.cl\r'),
(18536779, 1361, 2, 'MATÍAS', 'FRANCISCO', 'URIARTE', 'GONZALEZ', 'prueba@usach.cl\r'),
(18539505, 1353, 1, 'SEBASTIÁN', 'ALEJANDRO', 'MOLINA', 'GUERRERO', 'prueba@usach.cl\r'),
(18559185, 1351, 2, 'FRANCO', 'EDGARDO', 'CEA', 'GUTIERREZ', 'prueba@usach.cl\r'),
(18593637, 1361, 1, 'LUCIANO', 'ANDRE', 'MORALES', 'SOTO', 'prueba@usach.cl\r'),
(18593848, 1351, 2, 'SIMÓN', 'DANIEL', 'MIRANDA', 'VILLEGAS', 'prueba@usach.cl\r'),
(18596392, 1361, 1, 'GUSTAVO', 'IGNACIO', 'PARRA', 'GUTIERREZ', 'prueba@usach.cl\r'),
(18597078, 1361, 1, 'CAMILO', 'SALVADOR', 'VALENCIA', 'PÉREZ', 'prueba@usach.cl\r'),
(18605247, 1363, 2, 'JORGE', 'SEBASTIÁN', 'SANDOVAL', 'VALDEBENITO', 'prueba@usach.cl\r'),
(18610739, 1361, 2, 'FERNANDA', 'FRANCISCA', 'TAPIA', 'CASTILLO', 'prueba@usach.cl\r'),
(18620389, 1361, 2, 'SIMÓN', 'IGNACIO', 'CERDA', 'TORO', 'prueba@usach.cl\r'),
(18626127, 1361, 1, 'CRISTOPHER', 'EDUARDO', 'TORREBLANCA', 'MELILLAN', 'prueba@usach.cl\r'),
(18641725, 1361, 1, 'JOSÉ', 'IGNACIO', 'ARAVENA', 'CARRASCO', 'prueba@usach.cl\r'),
(18662626, 1361, 1, 'FRANCISCO', 'IGNACIO', 'MEJIAS', 'FALCON', 'prueba@usach.cl\r'),
(18662700, 1353, 1, 'MIGUEL', 'SEBASTIÁN', 'OLIVA', 'ALARCON', 'prueba@usach.cl\r'),
(18666640, 1363, 2, 'FABIÁN', 'ANDRÉS', 'GOMEZ', 'CUEVAS', 'prueba@usach.cl\r'),
(18668729, 1361, 2, 'CRISTOBAL', 'GUILLERMO ALEXA', 'MIRANDA', 'OLIVARES', 'prueba@usach.cl\r'),
(18693549, 1353, 1, 'DIEGO', 'ESTEBAN', 'SOTO', 'TRONCOSO', 'prueba@usach.cl\r'),
(18739797, 1361, 1, 'ESTEBAN', 'ALEJANDRO', 'DURAN', 'MADRID', 'prueba@usach.cl\r'),
(18777438, 1351, 1, 'MARCELO', 'IGNACIO', 'TAPIA', 'LABARCA', 'prueba@usach.cl\r'),
(18830329, 1361, 2, 'CRISTHIAN', 'FELIPE', 'BECERRA', 'MESSEN', 'prueba@usach.cl\r'),
(18830395, 1351, 1, 'PEDRO', 'PABLO', 'ZAMBRANO', 'ARANDA', 'prueba@usach.cl\r');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `filtro_contacto`
--

CREATE TABLE IF NOT EXISTS `filtro_contacto` (
  `ID_FILTRO_CONTACTO` int(11) NOT NULL AUTO_INCREMENT,
  `RUT_USUARIO` int(11) NOT NULL,
  `NOMBRE_FILTRO_CONTACTO` varchar(20) NOT NULL,
  `QUERY_FILTRO_CONTACTO` text NOT NULL,
  PRIMARY KEY (`ID_FILTRO_CONTACTO`),
  KEY `RUT_USUARIO` (`RUT_USUARIO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Cada usuario tiene la posibilidad de crear filtros con respe' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historiales_busqueda`
--

CREATE TABLE IF NOT EXISTS `historiales_busqueda` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `PALABRA` varchar(255) NOT NULL,
  `TIMESTAMP_BUSQUEDA` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TIPO_BUSQUEDA` enum('profesores','coordinadores','ayudantes','alumnos','correos','secciones','salas','modulos','sesiones') NOT NULL,
  `RUT_USUARIO` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fecha_busqueda` (`TIMESTAMP_BUSQUEDA`),
  KEY `rut_usuario` (`RUT_USUARIO`),
  KEY `tipo_usqueda` (`TIPO_BUSQUEDA`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `historiales_busqueda`
--

INSERT INTO `historiales_busqueda` (`ID`, `PALABRA`, `TIMESTAMP_BUSQUEDA`, `TIPO_BUSQUEDA`, `RUT_USUARIO`) VALUES
(1, '565', '0000-00-00 00:00:00', 'salas', 17586341),
(2, '11111111', '0000-00-00 00:00:00', 'alumnos', 17586341),
(3, '11111112', '0000-00-00 00:00:00', 'alumnos', 17586341),
(4, '111111', '2013-06-25 06:06:30', 'alumnos', 17586341);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE IF NOT EXISTS `horario` (
  `COD_HORARIO` varchar(10) NOT NULL,
  `COD_MODULO` int(11) NOT NULL,
  `COD_DIA` int(11) NOT NULL,
  `NOMBRE_HORARIO` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`COD_HORARIO`),
  KEY `COD_MODULO` (`COD_MODULO`),
  KEY `COD_DIA` (`COD_DIA`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Se usa para representar los horarios en los que se realizan ';

--
-- Volcado de datos para la tabla `horario`
--

INSERT INTO `horario` (`COD_HORARIO`, `COD_MODULO`, `COD_DIA`, `NOMBRE_HORARIO`) VALUES
('1', 1, 1, 'L1'),
('10', 1, 2, 'M1'),
('11', 2, 2, 'M2'),
('12', 3, 2, 'M3'),
('13', 4, 2, 'M4'),
('14', 5, 2, 'M5'),
('15', 6, 2, 'M6'),
('16', 7, 2, 'M7'),
('17', 8, 2, 'M8'),
('18', 9, 2, 'M9'),
('19', 1, 3, 'W1'),
('2', 2, 1, 'L2'),
('20', 2, 3, 'W2'),
('21', 3, 3, 'W3'),
('22', 4, 3, 'W4'),
('23', 5, 3, 'W5'),
('24', 6, 3, 'W6'),
('25', 7, 3, 'W7'),
('26', 8, 3, 'W8'),
('27', 9, 3, 'W9'),
('28', 1, 4, 'J1'),
('29', 2, 4, 'J2'),
('3', 3, 1, 'L3'),
('30', 3, 4, 'J3'),
('31', 4, 4, 'J4'),
('32', 5, 4, 'J5'),
('33', 6, 4, 'J6'),
('34', 7, 4, 'J7'),
('35', 8, 4, 'J8'),
('36', 9, 4, 'J9'),
('37', 1, 5, 'V1'),
('38', 2, 5, 'V2'),
('39', 3, 5, 'V3'),
('4', 4, 1, 'L4'),
('40', 4, 5, 'V4'),
('41', 5, 5, 'V5'),
('42', 6, 5, 'V6'),
('43', 7, 5, 'V7'),
('44', 8, 5, 'V8'),
('45', 9, 5, 'V9'),
('46', 1, 6, 'S1'),
('47', 2, 6, 'S2'),
('48', 3, 6, 'S3'),
('49', 4, 6, 'S4'),
('5', 5, 1, 'L5'),
('50', 5, 6, 'S5'),
('51', 6, 6, 'S6'),
('52', 7, 6, 'S7'),
('53', 8, 6, 'S8'),
('54', 9, 6, 'S9'),
('55', 1, 7, 'D1'),
('56', 2, 7, 'D2'),
('57', 3, 7, 'D3'),
('58', 4, 7, 'D4'),
('59', 5, 7, 'D5'),
('6', 6, 1, 'L6'),
('60', 6, 7, 'D6'),
('61', 7, 7, 'D7'),
('62', 8, 7, 'D8'),
('63', 9, 7, 'D9'),
('7', 7, 1, 'L7'),
('8', 8, 1, 'L8'),
('9', 9, 1, 'L9');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `implemento`
--

CREATE TABLE IF NOT EXISTS `implemento` (
  `COD_IMPLEMENTO` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_IMPLEMENTO` varchar(20) NOT NULL,
  `DESCRIPCION_IMPLEMENTO` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`COD_IMPLEMENTO`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Es utilizada con el fin de indicar los artefactos que posee ' AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `implemento`
--

INSERT INTO `implemento` (`COD_IMPLEMENTO`, `NOMBRE_IMPLEMENTO`, `DESCRIPCION_IMPLEMENTO`) VALUES
(1, 'Proyector', 'Aparato útil para imágenes.'),
(2, 'Computador', 'Aparato útil para reproducción de presentaciones.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo`
--

CREATE TABLE IF NOT EXISTS `modulo` (
  `COD_MODULO` int(11) NOT NULL AUTO_INCREMENT,
  `NUMERO_MODULO` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`COD_MODULO`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Se utiliza para representar los módulos en los que se realiz' AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `modulo`
--

INSERT INTO `modulo` (`COD_MODULO`, `NUMERO_MODULO`) VALUES
(1, '08:00'),
(2, '09:40'),
(3, '11:20'),
(4, '13:50'),
(5, '15:30'),
(6, '17:10'),
(7, '19:00'),
(8, '20:20'),
(9, '22:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo_tematico`
--

CREATE TABLE IF NOT EXISTS `modulo_tematico` (
  `COD_MODULO_TEM` int(11) NOT NULL AUTO_INCREMENT,
  `COD_EQUIPO` int(11) DEFAULT NULL,
  `NOMBRE_MODULO` varchar(50) NOT NULL,
  `DESCRIPCION_MODULO` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`COD_MODULO_TEM`),
  KEY `COD_EQUIPO` (`COD_EQUIPO`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Es la unidad temática que se le pasará a los alumnos durante' AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `modulo_tematico`
--

INSERT INTO `modulo_tematico` (`COD_MODULO_TEM`, `COD_EQUIPO`, `NOMBRE_MODULO`, `DESCRIPCION_MODULO`) VALUES
(1, 1, 'Comunicación no verbal', NULL),
(2, NULL, 'Comunicación y medios', NULL),
(3, NULL, 'Comunicación y cultura', NULL),
(4, NULL, 'Comunicación y compromisos', NULL),
(5, NULL, 'Estrategias de comunicación', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE IF NOT EXISTS `persona` (
  `COD_PERSONA` int(11) NOT NULL AUTO_INCREMENT,
  `CORREO_PERSONA` varchar(200) NOT NULL,
  PRIMARY KEY (`COD_PERSONA`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='corresponde a cualquier persona, de la que no se necesitan l' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantilla`
--

CREATE TABLE IF NOT EXISTS `plantilla` (
  `ID_PLANTILLA` int(11) NOT NULL AUTO_INCREMENT,
  `CUERPO_PLANTILLA` text NOT NULL,
  `NOMBRE_PLANTILLA` varchar(40) NOT NULL,
  `ASUNTO_PLANTILLA` varchar(40) NOT NULL,
  PRIMARY KEY (`ID_PLANTILLA`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Se refiere a las plantillas que se podrán adjuntar en la car' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor`
--

CREATE TABLE IF NOT EXISTS `profesor` (
  `RUT_USUARIO2` int(11) NOT NULL,
  `NOMBRE1_PROFESOR` varchar(20) NOT NULL,
  `NOMBRE2_PROFESOR` varchar(20) DEFAULT NULL,
  `APELLIDO1_PROFESOR` varchar(20) NOT NULL,
  `APELLIDO2_PROFESOR` varchar(20) NOT NULL,
  `TELEFONO_PROFESOR` int(11) DEFAULT NULL,
  `TIPO_PROFESOR` varchar(20) NOT NULL,
  PRIMARY KEY (`RUT_USUARIO2`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Se utiliza para guardar los datos de las personas que usarán';

--
-- Volcado de datos para la tabla `profesor`
--

INSERT INTO `profesor` (`RUT_USUARIO2`, `NOMBRE1_PROFESOR`, `NOMBRE2_PROFESOR`, `APELLIDO1_PROFESOR`, `APELLIDO2_PROFESOR`, `TELEFONO_PROFESOR`, `TIPO_PROFESOR`) VALUES
(8634324, 'Antonia', 'America', 'Carcamo', 'Briones', 6666666, 'Planta\r'),
(16434566, 'Carolina', 'Maria', 'Roth', 'Lillo', 5555555, 'Planta\r'),
(16639870, 'Felipe ', 'Camilo', 'Bello', 'Lagos', 2222222, 'Planta\r'),
(17242754, 'Edmundo ', 'Jose', 'Leiva', 'Toro', 1111111, 'Planta\r'),
(17257118, 'Monica', 'Constanza', 'Villanueva', 'Fuenzalida', 3333333, 'Planta\r'),
(17665354, 'Jose', 'Andres', 'Campusano', 'Ahumada', 4444444, 'Planta\r'),
(175863419, 'Diego', 'Diego', 'Diego', 'Diego', 17268721, '2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profe_equi_lider`
--

CREATE TABLE IF NOT EXISTS `profe_equi_lider` (
  `COD_EQUIPO` int(11) NOT NULL,
  `RUT_USUARIO2` int(11) NOT NULL,
  `LIDER_PROFESOR` tinyint(1) NOT NULL,
  KEY `COD_EQUIPO` (`COD_EQUIPO`),
  KEY `RUT_USUARIO2` (`RUT_USUARIO2`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `profe_equi_lider`
--

INSERT INTO `profe_equi_lider` (`COD_EQUIPO`, `RUT_USUARIO2`, `LIDER_PROFESOR`) VALUES
(1, 8634324, 1),
(1, 16434566, 0),
(1, 16639870, 0),
(1, 17242754, 0),
(1, 17257118, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profe_seccion`
--

CREATE TABLE IF NOT EXISTS `profe_seccion` (
  `COD_SECCION` int(11) NOT NULL,
  `RUT_USUARIO2` int(11) NOT NULL,
  KEY `FK_RELATIONSHIP_42` (`RUT_USUARIO2`),
  KEY `FK_RELATIONSHIP_48` (`COD_SECCION`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `profe_seccion`
--

INSERT INTO `profe_seccion` (`COD_SECCION`, `RUT_USUARIO2`) VALUES
(1, 8634324),
(1, 8634324);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requisito`
--

CREATE TABLE IF NOT EXISTS `requisito` (
  `COD_REQUISITO` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_REQUISITO` varchar(20) NOT NULL,
  `DESCRIPCION_REQUISITO` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`COD_REQUISITO`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Cada modulo temático tiene sus requisitos para que se pueda ' AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `requisito`
--

INSERT INTO `requisito` (`COD_REQUISITO`, `NOMBRE_REQUISITO`, `DESCRIPCION_REQUISITO`) VALUES
(1, 'proyector', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requisito_modulo`
--

CREATE TABLE IF NOT EXISTS `requisito_modulo` (
  `COD_REQUISITO` int(11) DEFAULT NULL,
  `COD_MODULO_TEM` int(11) NOT NULL,
  KEY `COD_REQUISITO` (`COD_REQUISITO`),
  KEY `COD_MODULO_TEM` (`COD_MODULO_TEM`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Es utilizada para tratar la relación n a n que existe entre ';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sala`
--

CREATE TABLE IF NOT EXISTS `sala` (
  `COD_SALA` int(11) NOT NULL AUTO_INCREMENT,
  `NUM_SALA` varchar(10) NOT NULL,
  `UBICACION` varchar(100) NOT NULL,
  `CAPACIDAD` int(11) NOT NULL,
  PRIMARY KEY (`COD_SALA`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Es el lugar físico en donde los estudiantes tendrán sus clas' AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `sala`
--

INSERT INTO `sala` (`COD_SALA`, `NUM_SALA`, `UBICACION`, `CAPACIDAD`) VALUES
(1, '711', 'MALL', 30),
(2, '712', 'MALL', 30),
(3, '565', 'EAO', 30),
(4, '564', 'EAO', 30),
(6, '254', 'CITECAMP', 40),
(7, '425', 'INDUSTRIA', 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sala_horario`
--

CREATE TABLE IF NOT EXISTS `sala_horario` (
  `ID_HORARIO_SALA` int(11) NOT NULL AUTO_INCREMENT,
  `COD_SALA` int(11) DEFAULT NULL,
  `COD_HORARIO` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`ID_HORARIO_SALA`),
  KEY `COD_SALA` (`COD_SALA`),
  KEY `COD_HORARIO` (`COD_HORARIO`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Se utiliza para representar la hora en que se realiza una se' AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `sala_horario`
--

INSERT INTO `sala_horario` (`ID_HORARIO_SALA`, `COD_SALA`, `COD_HORARIO`) VALUES
(1, 1, '13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sala_implemento`
--

CREATE TABLE IF NOT EXISTS `sala_implemento` (
  `COD_IMPLEMENTO` int(11) NOT NULL,
  `COD_SALA` int(11) NOT NULL,
  KEY `FK_RELATIONSHIP_16` (`COD_SALA`),
  KEY `FK_RELATIONSHIP_17` (`COD_IMPLEMENTO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Se utiliza para representar la relación que exite entre las ';

--
-- Volcado de datos para la tabla `sala_implemento`
--

INSERT INTO `sala_implemento` (`COD_IMPLEMENTO`, `COD_SALA`) VALUES
(1, 1),
(2, 3),
(1, 7),
(2, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seccion`
--

CREATE TABLE IF NOT EXISTS `seccion` (
  `COD_SECCION` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_SECCION` varchar(10) NOT NULL,
  PRIMARY KEY (`COD_SECCION`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Las secciones son la forma en que se organizarán los más de ' AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `seccion`
--

INSERT INTO `seccion` (`COD_SECCION`, `NOMBRE_SECCION`) VALUES
(1, 'A-20'),
(2, 'B-40'),
(3, 'c-12'),
(4, 'c-13'),
(6, 'c-15'),
(7, 'V-21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seccion_mod_tem`
--

CREATE TABLE IF NOT EXISTS `seccion_mod_tem` (
  `COD_SECCION` int(11) NOT NULL,
  `COD_MODULO_TEM` int(11) NOT NULL,
  `ID_HORARIO_SALA` int(11) NOT NULL,
  `FECHA_ASIGNACION` varchar(11) NOT NULL,
  KEY `COD_SECCION` (`COD_SECCION`),
  KEY `COD_MODULO_TEM` (`COD_MODULO_TEM`),
  KEY `ID_HORARIO_SALA` (`ID_HORARIO_SALA`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesion`
--

CREATE TABLE IF NOT EXISTS `sesion` (
  `COD_SESION` int(11) NOT NULL AUTO_INCREMENT,
  `COD_MODULO_TEM` int(11) DEFAULT NULL,
  `NOMBRE_SESION` varchar(100) NOT NULL,
  `DESCRIPCION_SESION` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`COD_SESION`),
  KEY `COD_MODULO_TEM` (`COD_MODULO_TEM`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Las sesiones son los bloques del curso, cada unidad son 3 se' AUTO_INCREMENT=29 ;

--
-- Volcado de datos para la tabla `sesion`
--

INSERT INTO `sesion` (`COD_SESION`, `COD_MODULO_TEM`, `NOMBRE_SESION`, `DESCRIPCION_SESION`) VALUES
(26, NULL, 'SESIONr56789', 'asdadsasdad'),
(28, NULL, 'sesion', 'asdasd');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_user`
--

CREATE TABLE IF NOT EXISTS `tipo_user` (
  `ID_TIPO` int(11) NOT NULL,
  `NOMBRE_TIPO` varchar(13) NOT NULL,
  PRIMARY KEY (`ID_TIPO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Existen distintos usuarios, con diferentes permisos dentro d';

--
-- Volcado de datos para la tabla `tipo_user`
--

INSERT INTO `tipo_user` (`ID_TIPO`, `NOMBRE_TIPO`) VALUES
(1, 'profesor'),
(2, 'coordinador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `RUT_USUARIO` int(11) NOT NULL,
  `ID_TIPO` int(11) NOT NULL,
  `PASSWORD_PRIMARIA` varchar(32) CHARACTER SET latin1 NOT NULL,
  `PASSWORD_TEMPORAL` varchar(32) CHARACTER SET latin1 DEFAULT NULL,
  `CORREO1_USER` varchar(200) CHARACTER SET latin1 NOT NULL,
  `CORREO2_USER` varchar(200) CHARACTER SET latin1 NOT NULL,
  `VALIDEZ` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`RUT_USUARIO`),
  KEY `FK_RELATIONSHIP_23` (`ID_TIPO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='Se utiliza para guardar los datos de las personas que usarán';

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`RUT_USUARIO`, `ID_TIPO`, `PASSWORD_PRIMARIA`, `PASSWORD_TEMPORAL`, `CORREO1_USER`, `CORREO2_USER`, `VALIDEZ`) VALUES
(8634324, 1, '202cb962ac59075b964b07152d234b70', NULL, 'prueba1@usach.cl', '', '2013-06-04 01:03:04'),
(16434566, 1, '202cb962ac59075b964b07152d234b70', NULL, 'prueba2@usach.cl', '', '2013-06-04 01:02:37'),
(16639870, 1, '202cb962ac59075b964b07152d234b70', NULL, 'bb@usach.cl', 'null', '2013-06-04 01:04:18'),
(17242754, 1, '202cb962ac59075b964b07152d234b70', NULL, 'aa@usach.cl', 'null', '2013-06-04 01:04:20'),
(17257118, 1, '202cb962ac59075b964b07152d234b70', NULL, 'cc@usach.cl', 'null', '2013-06-04 01:04:21'),
(17427647, 2, '202cb962ac59075b964b07152d234b70', NULL, 'd@usach.cl', 'null', '2013-06-04 01:04:27'),
(17453543, 2, '202cb962ac59075b964b07152d234b70', NULL, 'f@usach.cl', 'null', '2013-06-04 01:04:29'),
(17486324, 2, '202cb962ac59075b964b07152d234b70', NULL, 'g@usach.cl', 'null', '2013-06-04 01:04:33'),
(17586341, 2, '202cb962ac59075b964b07152d234b70', NULL, 'g@usach.cl', 'null', '2013-06-04 01:04:35'),
(17665354, 1, '202cb962ac59075b964b07152d234b70', NULL, 'prueba1@usach.cl', '', '2013-06-04 01:02:37'),
(17725373, 2, '202cb962ac59075b964b07152d234b70', NULL, 'e@usach.cl', 'null', '2013-06-04 01:04:38'),
(175863419, 1, '9ec158acb47c7476d3633e06b611e920', NULL, 'jashld@jashda.cl', 'jahdjas@jada.cl', '2013-06-19 04:39:18');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `act_estudiante`
--
ALTER TABLE `act_estudiante`
  ADD CONSTRAINT `act_estudiante_ibfk_1` FOREIGN KEY (`RUT_ESTUDIANTE`) REFERENCES `estudiante` (`RUT_ESTUDIANTE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `act_estudiante_ibfk_2` FOREIGN KEY (`COD_ACTIVIDAD_MASIVA`) REFERENCES `actividad_masiva` (`COD_ACTIVIDAD_MASIVA`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `adjunto`
--
ALTER TABLE `adjunto`
  ADD CONSTRAINT `adjunto_ibfk_1` FOREIGN KEY (`COD_CORREO`) REFERENCES `carta` (`COD_CORREO`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ayu_profe`
--
ALTER TABLE `ayu_profe`
  ADD CONSTRAINT `ayu_profe_ibfk_1` FOREIGN KEY (`RUT_USUARIO2`) REFERENCES `profesor` (`RUT_USUARIO2`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ayu_profe_ibfk_2` FOREIGN KEY (`RUT_AYUDANTE`) REFERENCES `ayudante` (`RUT_AYUDANTE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ayu_profe_ibfk_3` FOREIGN KEY (`COD_SECCION`) REFERENCES `seccion` (`COD_SECCION`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `borrador`
--
ALTER TABLE `borrador`
  ADD CONSTRAINT `FK_RELATIONSHIP_45` FOREIGN KEY (`COD_CORREO`) REFERENCES `carta` (`COD_CORREO`);

--
-- Filtros para la tabla `carta`
--
ALTER TABLE `carta`
  ADD CONSTRAINT `FK_RELATIONSHIP_22` FOREIGN KEY (`ID_PLANTILLA`) REFERENCES `plantilla` (`ID_PLANTILLA`),
  ADD CONSTRAINT `FK_RELATIONSHIP_43` FOREIGN KEY (`RUT_USUARIO`) REFERENCES `usuario` (`RUT_USUARIO`),
  ADD CONSTRAINT `FK_RELATIONSHIP_44` FOREIGN KEY (`COD_BORRADOR`) REFERENCES `borrador` (`COD_BORRADOR`);

--
-- Filtros para la tabla `cartar_ayudante`
--
ALTER TABLE `cartar_ayudante`
  ADD CONSTRAINT `FK_RELATIONSHIP_35` FOREIGN KEY (`RUT_AYUDANTE`) REFERENCES `ayudante` (`RUT_AYUDANTE`),
  ADD CONSTRAINT `FK_RELATIONSHIP_36` FOREIGN KEY (`COD_CORREO`) REFERENCES `carta` (`COD_CORREO`);

--
-- Filtros para la tabla `cartar_estudiante`
--
ALTER TABLE `cartar_estudiante`
  ADD CONSTRAINT `cartar_estudiante_ibfk_1` FOREIGN KEY (`RUT_ESTUDIANTE`) REFERENCES `estudiante` (`RUT_ESTUDIANTE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_RELATIONSHIP_31` FOREIGN KEY (`COD_CORREO`) REFERENCES `carta` (`COD_CORREO`);

--
-- Filtros para la tabla `cartar_persona`
--
ALTER TABLE `cartar_persona`
  ADD CONSTRAINT `FK_RELATIONSHIP_46` FOREIGN KEY (`COD_PERSONA`) REFERENCES `persona` (`COD_PERSONA`),
  ADD CONSTRAINT `FK_RELATIONSHIP_47` FOREIGN KEY (`COD_CORREO`) REFERENCES `carta` (`COD_CORREO`);

--
-- Filtros para la tabla `cartar_user`
--
ALTER TABLE `cartar_user`
  ADD CONSTRAINT `FK_RELATIONSHIP_29` FOREIGN KEY (`COD_CORREO`) REFERENCES `carta` (`COD_CORREO`),
  ADD CONSTRAINT `FK_RELATIONSHIP_30` FOREIGN KEY (`RUT_USUARIO`) REFERENCES `usuario` (`RUT_USUARIO`);

--
-- Filtros para la tabla `coordinador`
--
ALTER TABLE `coordinador`
  ADD CONSTRAINT `coordinador_ibfk_1` FOREIGN KEY (`RUT_USUARIO3`) REFERENCES `usuario` (`RUT_USUARIO`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `equipo_profesor`
--
ALTER TABLE `equipo_profesor`
  ADD CONSTRAINT `equipo_profesor_ibfk_1` FOREIGN KEY (`COD_MODULO_TEM`) REFERENCES `modulo_tematico` (`COD_MODULO_TEM`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD CONSTRAINT `estudiante_ibfk_1` FOREIGN KEY (`COD_CARRERA`) REFERENCES `carrera` (`COD_CARRERA`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_RELATIONSHIP_51` FOREIGN KEY (`COD_SECCION`) REFERENCES `seccion` (`COD_SECCION`);

--
-- Filtros para la tabla `filtro_contacto`
--
ALTER TABLE `filtro_contacto`
  ADD CONSTRAINT `filtro_contacto_ibfk_1` FOREIGN KEY (`RUT_USUARIO`) REFERENCES `usuario` (`RUT_USUARIO`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `historiales_busqueda`
--
ALTER TABLE `historiales_busqueda`
  ADD CONSTRAINT `historiales_busqueda_ibfk_1` FOREIGN KEY (`RUT_USUARIO`) REFERENCES `usuario` (`RUT_USUARIO`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `horario`
--
ALTER TABLE `horario`
  ADD CONSTRAINT `horario_ibfk_1` FOREIGN KEY (`COD_MODULO`) REFERENCES `modulo` (`COD_MODULO`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `horario_ibfk_2` FOREIGN KEY (`COD_DIA`) REFERENCES `dia` (`COD_DIA`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `modulo_tematico`
--
ALTER TABLE `modulo_tematico`
  ADD CONSTRAINT `modulo_tematico_ibfk_1` FOREIGN KEY (`COD_EQUIPO`) REFERENCES `equipo_profesor` (`COD_EQUIPO`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `profesor`
--
ALTER TABLE `profesor`
  ADD CONSTRAINT `profesor_ibfk_2` FOREIGN KEY (`RUT_USUARIO2`) REFERENCES `usuario` (`RUT_USUARIO`);

--
-- Filtros para la tabla `profe_equi_lider`
--
ALTER TABLE `profe_equi_lider`
  ADD CONSTRAINT `profe_equi_lider_ibfk_1` FOREIGN KEY (`COD_EQUIPO`) REFERENCES `equipo_profesor` (`COD_EQUIPO`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `profe_equi_lider_ibfk_2` FOREIGN KEY (`RUT_USUARIO2`) REFERENCES `profesor` (`RUT_USUARIO2`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `profe_seccion`
--
ALTER TABLE `profe_seccion`
  ADD CONSTRAINT `profe_seccion_ibfk_2` FOREIGN KEY (`COD_SECCION`) REFERENCES `seccion` (`COD_SECCION`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `profe_seccion_ibfk_1` FOREIGN KEY (`RUT_USUARIO2`) REFERENCES `profesor` (`RUT_USUARIO2`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `requisito_modulo`
--
ALTER TABLE `requisito_modulo`
  ADD CONSTRAINT `requisito_modulo_ibfk_1` FOREIGN KEY (`COD_REQUISITO`) REFERENCES `requisito` (`COD_REQUISITO`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `requisito_modulo_ibfk_2` FOREIGN KEY (`COD_MODULO_TEM`) REFERENCES `modulo_tematico` (`COD_MODULO_TEM`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `sala_horario`
--
ALTER TABLE `sala_horario`
  ADD CONSTRAINT `sala_horario_ibfk_1` FOREIGN KEY (`COD_SALA`) REFERENCES `sala` (`COD_SALA`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sala_horario_ibfk_2` FOREIGN KEY (`COD_HORARIO`) REFERENCES `horario` (`COD_HORARIO`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `sala_implemento`
--
ALTER TABLE `sala_implemento`
  ADD CONSTRAINT `FK_RELATIONSHIP_16` FOREIGN KEY (`COD_SALA`) REFERENCES `sala` (`COD_SALA`),
  ADD CONSTRAINT `FK_RELATIONSHIP_17` FOREIGN KEY (`COD_IMPLEMENTO`) REFERENCES `implemento` (`COD_IMPLEMENTO`);

--
-- Filtros para la tabla `seccion_mod_tem`
--
ALTER TABLE `seccion_mod_tem`
  ADD CONSTRAINT `seccion_mod_tem_ibfk_1` FOREIGN KEY (`COD_SECCION`) REFERENCES `seccion` (`COD_SECCION`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `seccion_mod_tem_ibfk_2` FOREIGN KEY (`COD_MODULO_TEM`) REFERENCES `modulo_tematico` (`COD_MODULO_TEM`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `seccion_mod_tem_ibfk_3` FOREIGN KEY (`ID_HORARIO_SALA`) REFERENCES `sala_horario` (`ID_HORARIO_SALA`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `sesion`
--
ALTER TABLE `sesion`
  ADD CONSTRAINT `sesion_ibfk_2` FOREIGN KEY (`COD_MODULO_TEM`) REFERENCES `modulo_tematico` (`COD_MODULO_TEM`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `FK_RELATIONSHIP_23` FOREIGN KEY (`ID_TIPO`) REFERENCES `tipo_user` (`ID_TIPO`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
