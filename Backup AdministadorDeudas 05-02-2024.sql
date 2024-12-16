-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-07-2024 a las 04:23:38
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `administradordeudas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deudas`
--

CREATE TABLE `deudas` (
  `id_deuda` int(11) NOT NULL,
  `valor_inicial` float NOT NULL,
  `porcentaje_interes` float NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `interes` float NOT NULL,
  `fecha_ultimo_interes` date NOT NULL,
  `credencial_usuario` varchar(30) NOT NULL,
  `fecha_inicial` date DEFAULT NULL,
  `valor_actual` float NOT NULL,
  `estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `deudas`
--

INSERT INTO `deudas` (`id_deuda`, `valor_inicial`, `porcentaje_interes`, `id_usuario`, `interes`, `fecha_ultimo_interes`, `credencial_usuario`, `fecha_inicial`, `valor_actual`, `estado`) VALUES
(1, 200000, 7.5, 5, 136350, '2020-12-15', 'Anlly', '2020-12-15', 140000, 1),
(2, 47000, 7.5, 5, 84600, '2021-08-07', 'Anlly', '2021-08-07', 47000, 1),
(3, 100000, 7.5, 5, 135000, '2021-11-03', 'Anlly', '2021-11-03', 100000, 1),
(4, 320000, 10, 5, 192000, '2024-01-16', 'Anlly', '2024-01-16', 320000, 1),
(5, 45800, 10, 5, 22900, '2024-02-14', 'Anlly', '2024-02-14', 45800, 1),
(7, 100000, 10, 6, 55000, '2023-11-06', 'Edwin Leyton', '2023-11-06', 100000, 1),
(8, 175000, 10, 6, 122500, '2023-12-10', 'Edwin Leyton', '2023-12-10', 175000, 1),
(9, 250000, 10, 6, 150000, '2024-01-03', 'Edwin Leyton', '2024-01-03', 250000, 1),
(10, 200000, 10, 6, 120000, '2024-01-16', 'Edwin Leyton', '2024-01-16', 200000, 1),
(11, 150000, 10, 6, 75000, '2021-01-10', 'Edwin Leyton', '2021-01-10', 150000, 1),
(12, 150000, 10, 6, 75000, '2021-02-15', 'Edwin Leyton', '2021-02-15', 150000, 1),
(13, 200000, 10, 6, 75000, '2021-02-17', 'Edwin Leyton', '2021-02-17', 200000, 1),
(14, 120000, 10, 6, 24000, '2021-04-23', 'Edwin Leyton', '2021-04-23', 120000, 1),
(15, 250000, 10, 6, 50000, '2021-04-23', 'Edwin Leyton', '2021-04-23', 250000, 1),
(16, 100000, 10, 6, 0, '2021-06-23', 'Edwin Leyton', '2021-06-23', 0, 0),
(17, 55000, 10, 7, 0, '0000-00-00', 'AshleyL', '0000-00-00', 0, 0),
(18, 7000, 10, 7, 0, '0000-00-00', 'AshleyL', '0000-00-00', 0, 0),
(19, 165000, 10, 7, 0, '0000-00-00', 'AshleyL', '0000-00-00', 0, 0),
(20, 33000, 10, 7, 0, '0000-00-00', 'AshleyL', '0000-00-00', 0, 0),
(21, 77000, 10, 7, 0, '0000-00-00', 'AshleyL', '0000-00-00', 12000, 1),
(22, 250000, 10, 8, 0, '0000-00-00', 'OfeliaM', '0000-00-00', 50000, 1),
(31, 30000, 10, 8, 0, '2024-06-29', 'OfeliaM', '2024-06-29', 0, 0),
(33, 11000, 0, 5, 0, '2024-06-29', 'Anlly', '2024-06-29', 0, 0),
(34, 100, 10, 3, 0, '2024-06-29', 'Heider', '2024-06-29', 0, 0),
(36, 100, 10, 3, 0, '2024-06-29', 'Heider', '2024-06-29', 0, 0),
(39, 100, 10, 3, 0, '2024-06-29', 'Heider', '2024-06-29', 0, 0),
(40, 11000, 0, 10, 0, '2024-06-30', 'Marlon', '2024-06-30', 11000, 1),
(41, 100, 10, 3, 0, '2024-06-30', 'Heider', '2024-06-30', 0, 0),
(42, 100, 10, 2, 0, '2024-07-01', 'coco', '2024-07-01', 0, 0),
(43, 110, 0, 3, 0, '2024-07-06', 'Heider', '2024-07-06', 10, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `meses`
--

CREATE TABLE `meses` (
  `numero_mes` int(2) NOT NULL,
  `id_deuda` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id_pago` int(11) NOT NULL,
  `valor_pago` float NOT NULL,
  `id_deuda` int(11) NOT NULL,
  `fecha_pago` date DEFAULT NULL,
  `estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id_pago`, `valor_pago`, `id_deuda`, `fecha_pago`, `estado`) VALUES
(1, 10000, 1, NULL, 0),
(2, 10000, 1, NULL, 0),
(3, 10000, 1, NULL, 0),
(4, 10000, 1, NULL, 0),
(5, 10000, 1, NULL, 0),
(6, 15000, 1, NULL, 0),
(7, 15000, 1, NULL, 0),
(8, 15000, 1, NULL, 0),
(9, 15000, 1, NULL, 0),
(10, 15000, 1, NULL, 0),
(11, 15000, 1, NULL, 0),
(12, 15000, 1, NULL, 0),
(13, 15000, 1, NULL, 0),
(14, 15000, 1, NULL, 0),
(15, 2200, 1, NULL, 0),
(16, 5000, 1, NULL, 0),
(17, 10000, 1, NULL, 0),
(18, 4000, 1, NULL, 0),
(19, 2500, 1, NULL, 0),
(20, 4000, 1, NULL, 0),
(21, 3000, 1, NULL, 0),
(22, 6000, 1, NULL, 0),
(23, 2000, 1, NULL, 0),
(24, 1300, 1, NULL, 0),
(25, 200000, 1, NULL, 0),
(26, 10500, 1, NULL, 0),
(27, 10500, 1, NULL, 0),
(28, 10500, 1, NULL, 0),
(29, 10500, 1, NULL, 0),
(30, 10500, 1, NULL, 0),
(31, 10500, 1, NULL, 0),
(32, 10500, 1, NULL, 0),
(33, 10500, 1, NULL, 0),
(34, 10500, 1, NULL, 0),
(35, 10500, 1, NULL, 0),
(36, 10500, 1, NULL, 0),
(37, 10500, 1, NULL, 0),
(38, 10500, 1, NULL, 0),
(39, 2350, 2, NULL, 0),
(40, 2350, 2, NULL, 0),
(41, 2350, 2, NULL, 0),
(42, 2350, 2, NULL, 0),
(43, 2350, 2, NULL, 0),
(45, 3525, 2, NULL, 0),
(46, 3525, 2, NULL, 0),
(47, 3525, 2, NULL, 0),
(48, 1175, 2, NULL, 0),
(49, 5000, 3, NULL, 0),
(50, 5000, 3, NULL, 0),
(51, 5000, 3, NULL, 0),
(52, 5000, 3, NULL, 0),
(53, 5000, 3, NULL, 0),
(54, 5000, 3, NULL, 0),
(55, 5000, 3, NULL, 0),
(56, 5000, 3, NULL, 0),
(57, 5000, 3, NULL, 0),
(58, 5000, 3, NULL, 0),
(59, 5000, 3, NULL, 0),
(60, 5000, 3, NULL, 0),
(61, 10000, 7, NULL, 0),
(62, 5000, 7, NULL, 0),
(63, 5000, 16, NULL, 0),
(64, 5000, 16, NULL, 0),
(65, 5000, 16, NULL, 0),
(66, 5000, 16, NULL, 0),
(67, 4000, 16, NULL, 0),
(68, 5000, 16, NULL, 0),
(69, 4000, 16, NULL, 0),
(70, 5000, 16, NULL, 0),
(71, 5000, 16, NULL, 0),
(72, 5000, 16, NULL, 0),
(73, 5000, 16, NULL, 0),
(74, 5000, 16, NULL, 0),
(75, 5000, 16, NULL, 0),
(76, 5000, 16, NULL, 0),
(77, 5000, 16, NULL, 0),
(78, 5000, 16, NULL, 0),
(79, 5000, 16, NULL, 0),
(80, 20000, 16, NULL, 0),
(81, 5000, 16, NULL, 0),
(82, 10000, 16, NULL, 0),
(83, 20000, 16, NULL, 0),
(84, 10000, 16, NULL, 0),
(85, 5000, 16, NULL, 0),
(86, 5000, 16, NULL, 0),
(87, 16000, 16, NULL, 0),
(88, 10000, 16, NULL, 0),
(89, 20000, 16, NULL, 0),
(90, 10000, 16, NULL, 0),
(91, 14000, 16, NULL, 0),
(92, 32000, 19, '2024-02-05', 0),
(93, 32000, 19, '2024-03-05', 0),
(94, 32000, 19, '2024-04-05', 0),
(95, 32000, 19, '2024-05-05', 0),
(96, 32000, 19, '2024-06-05', 0),
(97, 200000, 22, '2024-01-23', 0),
(98, 55000, 17, '0000-00-00', 0),
(99, 70000, 18, '0000-00-00', 0),
(121, 150, 1, '2024-06-22', 0),
(122, 30000, 20, '2024-06-25', 0),
(131, 11000, 33, '2024-06-29', 0),
(152, 100, 36, '2024-06-29', 0),
(153, 250, 36, '2024-06-29', 0),
(154, 50, 36, '2024-06-29', 0),
(155, 100, 36, '2024-06-29', 0),
(156, 150, 39, '2024-06-29', 0),
(157, 100, 39, '2024-06-29', 0),
(158, 100, 39, '2024-06-29', 0),
(159, 150, 39, '2024-06-29', 0),
(160, 100, 39, '2024-06-29', 0),
(161, 150, 39, '2024-06-29', 0),
(162, 100, 39, '2024-06-29', 0),
(163, 100, 39, '2024-06-29', 0),
(164, 100, 39, '2024-06-29', 0),
(165, 50, 39, '2024-06-29', 0),
(166, 30000, 31, '2024-06-30', 0),
(167, 50, 41, '2024-07-01', 0),
(168, 50, 36, '2024-07-01', 2),
(169, 5000, 19, '2024-07-01', 0),
(170, 3000, 20, '2024-07-01', 0),
(171, 14000, 21, '2024-07-01', 0),
(172, 1000, 21, '2024-07-01', 0),
(173, 50, 41, '2024-07-01', 0),
(174, 50, 41, '2024-07-01', 2),
(175, 50, 41, '2024-07-01', 0),
(176, 50, 41, '2024-07-01', 0),
(177, 50, 41, '2024-07-01', 2),
(178, 50, 42, '2024-07-01', 0),
(179, 50, 42, '2024-07-01', 2),
(180, 50000, 21, '2024-07-02', 0),
(181, 50, 36, '2024-07-06', 0),
(182, 50, 36, '2024-07-06', 0),
(183, 50, 43, '2024-07-06', 0),
(184, 50, 43, '2024-07-06', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `nombre_usuario` varchar(30) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `credencial_usuario` varchar(30) NOT NULL,
  `contrasena` varchar(90) NOT NULL,
  `tipo` int(11) NOT NULL,
  `palabra_segura` varchar(90) DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT 0,
  `cedula` int(11) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`nombre_usuario`, `id_usuario`, `credencial_usuario`, `contrasena`, `tipo`, `palabra_segura`, `estado`, `cedula`, `correo`) VALUES
('Heider', 1, 'adm2024', '$2y$10$r3tO5kfG2d29bf6NyPJkK.4FRBC6iaHd4Y3lWk/CuPv/Xkkjj0Eym', 1, '$2y$10$mdnobGiaIi6m5Ypx2kXbkueaBs2wosLeOnkp5zk4z7b8TbcJlEOkK', 1, 1104695776, 'heiderleyton22@gmail.com'),
('Coco', 2, 'coco', '$2y$10$t.3HWN1H8c4zV3vQpv8.DutP8CquZIOW4wsBebQqMKZjCgNjZkrfq', 0, '$2y$10$t.3HWN1H8c4zV3vQpv8.DutP8CquZIOW4wsBebQqMKZjCgNjZkrfq', 1, NULL, NULL),
('Heider', 3, 'Heider', '$2y$10$mZt54TDvssNd.VfMKZzonO5MhzHD6A7wIkQj.ajgeWJKQ1a1wMlXe', 0, '$2y$10$ttj05SrX1xvc7ok2a8ZIoOmtVlHjOvvBkUF.ZnpW39vtx8D2nIFWu', 0, 123456789, 'heiderleyton33@gmail.com'),
('Anlly', 5, 'Anlly', '$2y$10$RRiDyfQFElh6C9LKFGBsY./IASaF6TzzLdsUtwHeNTEV7NNUoTUe.', 0, '$2y$10$utii2Bv9SfQSPM/DQvaeLO3hXorYnVVmfMlIX5G.05HJlIITNkKEy', 0, 1024517826, 'anllyleyton58@gmail.com'),
('Edwin Leyton ', 6, 'Edwin Leyton ', '$2y$10$t.3HWN1H8c4zV3vQpv8.DutP8CquZIOW4wsBebQqMKZjCgNjZkrfq', 0, '$2y$10$t.3HWN1H8c4zV3vQpv8.DutP8CquZIOW4wsBebQqMKZjCgNjZkrfq', 0, NULL, NULL),
('Ashley', 7, 'AshleyL', '$2y$10$6/cS.s0KB7ekMhexl2ZEeeePkpykkvLq99ty80R2X2YrjnSdbLP/S', 0, '$2y$10$hDiLD64oIqS6CHTg37VO6ebumUw8nDsoU2/SmZbxfS1/JJ25hWvse', 0, 1104699403, 'ashleyleyton15@gmail.com'),
('Ofelia', 8, 'OfeliaM', '$2y$10$Rmusa1U0G7yaNh2RlDz6COMtuAaFZThaR4Otju3tTA95Etod2Z1ku', 0, '$2y$10$giOntvxkbqYNidhYCwO8r.WSWfcZzTI0qRnitYm8//fehPVL6QwNW', 0, 28929053, 'ofeliamontielvera@gmail.com'),
('Marlon', 10, 'Marlon', '$2y$10$t.3HWN1H8c4zV3vQpv8.DutP8CquZIOW4wsBebQqMKZjCgNjZkrfq', 0, '$2y$10$t.3HWN1H8c4zV3vQpv8.DutP8CquZIOW4wsBebQqMKZjCgNjZkrfq', 0, NULL, NULL),
('123', 16, '1234', '$2y$10$4hs.MxTRJCimZVlcw0IMwet0GnKZe2mg2C9KQDIz19P9lC/vcImZK', 0, '$2y$10$fFFqnuYFPWPlqBXQrF9BMOWLHG1u9XsBDvRSxqER1pi0AxMktvOEO', 0, NULL, NULL),
('123', 17, '123', '$2y$10$G/a7w1/Qqmm0DJJjdvQ9huqdzqGcRZlI5HZ2IXxuUDfUtdPBFfaAa', 0, '$2y$10$dOrLz/chPz6vGbDcESvT7OOpUdqv5mya4IDpsn6mB0Vvzj4xOZiwq', 0, NULL, NULL),
('345', 18, '345', '$2y$10$tAWosKVrXUiJu1MCUzRr9egEqB2jdkTO6n8BpPTVtFCxKO7gTB8Hm', 0, '$2y$10$Q04p5KUzCSAOrd3ToAqzduHU3rEVGVWf1dnJuJgHHk1d8GMCmRAwO', 0, 345, '345@gmail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `deudas`
--
ALTER TABLE `deudas`
  ADD PRIMARY KEY (`id_deuda`),
  ADD KEY `id_usuario` (`id_usuario`,`credencial_usuario`);

--
-- Indices de la tabla `meses`
--
ALTER TABLE `meses`
  ADD PRIMARY KEY (`numero_mes`,`id_deuda`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `id_deuda` (`id_deuda`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`,`credencial_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `deudas`
--
ALTER TABLE `deudas`
  MODIFY `id_deuda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `deudas`
--
ALTER TABLE `deudas`
  ADD CONSTRAINT `deudas_ibfk_1` FOREIGN KEY (`id_usuario`,`credencial_usuario`) REFERENCES `usuario` (`id_usuario`, `credencial_usuario`);

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`id_deuda`) REFERENCES `deudas` (`id_deuda`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
