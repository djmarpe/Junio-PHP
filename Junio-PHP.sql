-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 19-04-2021 a las 21:29:39
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
(4, 5, 1);

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
(13, 4, 'relacion', 'si'),
(14, 4, 'deporte', '5'),
(15, 4, 'arte', '8'),
(16, 4, 'politica', '5'),
(17, 4, 'hijo', 'no'),
(18, 4, 'interes', 'Mujeres'),
(19, 5, 'relacion', 'si'),
(20, 5, 'deporte', '7'),
(21, 5, 'arte', '1'),
(22, 5, 'politica', '9'),
(23, 5, 'hijo', 'no'),
(24, 5, 'interes', 'Mujeres'),
(25, 6, 'relacion', 'si'),
(26, 6, 'deporte', '10'),
(27, 6, 'arte', '8'),
(28, 6, 'politica', '8'),
(29, 6, 'hijo', 'si'),
(30, 6, 'interes', 'Mujeres');

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
(4, 2),
(6, 1),
(7, 2);

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
(4, 'Juan', 'Fernandez', 'juan_fernandez@gmail.com', 'Chubaca2020', 'Español', '1999-12-18', 'España', 'Puertollano', 1, 2, 0),
(5, 'Maki', 'Navaja', 'makina@gmail.com', 'Chubaca2020', 'Soy la máquina', '1996-05-10', 'España', 'Daimiel', 1, 2, 0),
(6, 'Alejandro', 'Martín Pérez', 'alejandro@gmail.com', 'Chubaca2020', 'Soy el administrador de la web', '1999-12-18', 'España', 'Argamasilla de Calatrava', 1, 2, 0),
(7, 'Juan', 'Mata', 'juan_mata@gmail.com', 'Chubaca2020', 'Soy madrileño', '2002-08-02', 'España', 'Madrid', 1, 1, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`idUsuarioEmitter`,`idUsuarioReceiver`);

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
-- AUTO_INCREMENT de la tabla `preferences`
--
ALTER TABLE `preferences`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
