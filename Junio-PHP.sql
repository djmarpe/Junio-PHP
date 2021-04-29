-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 29-04-2021 a las 21:41:33
-- Versión del servidor: 8.0.23-0ubuntu0.20.04.1
-- Versión de PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `Junio-PHP`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `friends`
--

CREATE TABLE `friends` (
  `idUsuarioEmitter` int NOT NULL,
  `idUsuarioReceiver` int NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `friends`
--

INSERT INTO `friends` (`idUsuarioEmitter`, `idUsuarioReceiver`, `status`) VALUES
(6, 11, 1),
(6, 12, 1),
(13, 12, 1),
(14, 12, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensaje`
--

CREATE TABLE `mensaje` (
  `id` int NOT NULL,
  `idUsuarioEmisor` int NOT NULL,
  `idUsuarioReceptor` int NOT NULL,
  `asunto` varchar(255) NOT NULL,
  `cuerpo` varchar(2000) NOT NULL,
  `leido` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `mensaje`
--

INSERT INTO `mensaje` (`id`, `idUsuarioEmisor`, `idUsuarioReceptor`, `asunto`, `cuerpo`, `leido`) VALUES
(1, 6, 11, 'Hola', 'Hola, que tal?', 1),
(2, 6, 11, 'Prueba 2', 'Hola, este mensaje es otra prueba', 1),
(7, 6, 12, 'Hola, prueba 3', 'Esto es la tercera prueba', 1),
(8, 6, 11, 'Hola, prueba 4', 'Hola, esto es la cuarta prueba', 1),
(9, 6, 12, 'Hola, prueba 5', 'Hola, esto es la sexta prueba', 1),
(10, 6, 12, 'Hola, prueba 6', 'Hola, esta es la sexta prueba, lo de antes no estaba correcto, era la quinta', 1),
(11, 6, 11, 'Prueba 7', 'Prueba 7', 1),
(12, 6, 11, 'Prueba 8', 'Prueba 8', 1),
(13, 6, 11, 'Prueba 9', 'Prueba 10', 1),
(14, 6, 11, 'Prueba 11', 'Prueba 11', 1),
(15, 6, 11, 'Prueba 12', 'Prueba 12', 1),
(16, 6, 11, 'Prueba 13', 'Prueba 13', 1),
(17, 6, 11, 'Prueba 14', 'Prueba 14', 1),
(18, 6, 11, 'Prueba 15', 'Prueba 15', 1),
(19, 6, 11, 'Prueba 16', 'Prueba 16', 1),
(20, 6, 11, 'Prueba 17', 'Prueba 17', 1),
(21, 6, 11, 'Prueba 18', 'Prueba 18', 1),
(22, 6, 11, 'Prueba 19', 'Prueba 19', 1),
(23, 6, 11, 'Prueba 20', 'Prueba 20', 1),
(24, 6, 11, 'Prueba 21', 'Prueba 21', 1),
(25, 6, 11, 'Prueba 22', 'Prueba 22', 1),
(26, 6, 11, 'Prueba 23', 'Prueba 23', 1),
(27, 6, 11, 'Prueba 24', 'Prueba 24', 1),
(28, 6, 12, 'Hola que tal?', 'Holaa!! Como estas!!! 😀', 1),
(29, 11, 6, 'Holaa', 'Hola amigooo', 1),
(30, 11, 6, 'Hola Alejandro', 'Hola Alejandro, que tal? Esto es otra prueba mas de rendimiento de la web', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preferences`
--

CREATE TABLE `preferences` (
  `id` int NOT NULL,
  `idUsuario` int NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `preferences`
--

INSERT INTO `preferences` (`id`, `idUsuario`, `tipo`, `value`) VALUES
(25, 6, 'relacion', 'si'),
(26, 6, 'deporte', '7'),
(27, 6, 'arte', '7'),
(28, 6, 'politica', '9'),
(29, 6, 'hijo', 'si'),
(30, 6, 'interes', 'Mujeres'),
(37, 11, 'relacion', 'si'),
(38, 11, 'deporte', '9'),
(39, 11, 'arte', '8'),
(40, 11, 'politica', '7'),
(41, 11, 'hijo', 'si'),
(42, 11, 'interes', 'Hombres'),
(43, 12, 'relacion', 'si'),
(44, 12, 'deporte', '9'),
(45, 12, 'arte', '7'),
(46, 12, 'politica', '8'),
(47, 12, 'hijo', 'si'),
(48, 12, 'interes', 'Hombres'),
(49, 13, 'relacion', 'si'),
(50, 13, 'deporte', '5'),
(51, 13, 'arte', '7'),
(52, 13, 'politica', '7'),
(53, 13, 'hijo', 'si'),
(54, 13, 'interes', 'Mujeres'),
(69, 14, 'relacion', 'si'),
(70, 14, 'deporte', '7'),
(71, 14, 'arte', '7'),
(72, 14, 'politica', '7'),
(73, 14, 'hijo', 'si'),
(74, 14, 'interes', 'Ambos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idRol` tinyint(1) NOT NULL,
  `rol` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idRol`, `rol`) VALUES
(1, 'Administrador'),
(2, 'Usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rolAsignated`
--

CREATE TABLE `rolAsignated` (
  `idUsuario` int NOT NULL,
  `idRol` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `rolAsignated`
--

INSERT INTO `rolAsignated` (`idUsuario`, `idRol`) VALUES
(6, 1),
(11, 2),
(12, 2),
(13, 2),
(14, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `fecNac` date NOT NULL,
  `country` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `sex` tinyint(1) NOT NULL,
  `status` tinyint NOT NULL,
  `online` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `name`, `surname`, `email`, `passwd`, `description`, `fecNac`, `country`, `city`, `sex`, `status`, `online`) VALUES
(6, 'Alejandro', 'Martín Pérez', 'alejandro@gmail.com', 'Chubaca2020', 'Soy el administrador de la web, tengo 21 años.', '1999-12-18', 'España', 'Argamasilla de Calatrava', 1, 2, 0),
(11, 'Marta', 'Fernandez', 'marta_fernandez@gmail.com', 'Chubaca2020', 'Soy de Puertollano', '1994-03-13', 'España', 'Puertollano', 2, 2, 0),
(12, 'Maria', 'Torres', 'maria_torres@gmail.com', 'Chubaca2020', 'Soy de puertollano, me gusta mucho la música y el deporte. En mi tiempo libre me dedico a hacer streams en Twitch', '2004-05-19', 'España', 'Puertollano', 2, 2, 0),
(13, 'Roberto', 'Lopez', 'roberto_lopez@gmail.com', 'Chubaca2020', 'Soy una persona muy activa, le gusta salir a pasear.\r\nSoy una persona muy alta, mido casi 2 metros de altura, además, soy una persona que le gustan las series.', '1994-02-15', 'España', 'Madrid', 1, 2, 0),
(14, 'Juan', 'Naranjo', 'juan_naranjo@gmail.com', 'Chubaca2020', 'Soy una persona que tiene interés en todo', '1990-02-13', 'España', 'Puertollano', 1, 2, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`idUsuarioEmitter`,`idUsuarioReceiver`);

--
-- Indices de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `preferences`
--
ALTER TABLE `preferences`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `preferences`
--
ALTER TABLE `preferences`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
