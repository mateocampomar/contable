-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Dec 30, 2018 at 02:36 PM
-- Server version: 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `contable`
--

-- --------------------------------------------------------

--
-- Table structure for table `cuentas`
--

CREATE TABLE `cuentas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `moneda` varchar(3) NOT NULL,
  `parser` varchar(10) NOT NULL,
  `saldo` decimal(10,2) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cuentas`
--

INSERT INTO `cuentas` (`id`, `nombre`, `moneda`, `parser`, `saldo`, `status`) VALUES
(1, 'Iatú Matt', 'UYU', 'itau-web', '45240.24', 1),
(2, 'Iatú Matt', 'USD', 'itau-web', '-123213.22', 1),
(3, 'Pow Iatú', 'UYU', 'itau-web', '3122.32', 1),
(4, 'Pow Itaú', 'USD', 'itau-web', '234.11', 1),
(5, 'Pershing (inversión)', 'USD', '', '291070.12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `moneda`
--

CREATE TABLE `moneda` (
  `moneda` varchar(3) NOT NULL,
  `simbolo` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `moneda`
--

INSERT INTO `moneda` (`moneda`, `simbolo`) VALUES
('USD', 'u$s'),
('UYU', '$');

-- --------------------------------------------------------

--
-- Table structure for table `movimientos_cuentas`
--

CREATE TABLE `movimientos_cuentas` (
  `id` int(11) NOT NULL,
  `cuentaId` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `concepto` varchar(150) NOT NULL,
  `debito` decimal(10,2) NOT NULL,
  `credito` decimal(10,2) NOT NULL,
  `saldo` decimal(10,2) NOT NULL,
  `rubro_id` int(11) DEFAULT NULL,
  `fecha_auto` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=193 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `movimientos_cuentas`
--

INSERT INTO `movimientos_cuentas` (`id`, `cuentaId`, `fecha`, `concepto`, `debito`, `credito`, `saldo`, `rubro_id`, `fecha_auto`, `status`) VALUES
(129, 2, '2018-12-03', 'REDIVA 19210BAZAAR', '19.34', '0.00', '141958.64', NULL, '0000-00-00 00:00:00', 1),
(130, 2, '2018-12-03', 'REDIVA 19210SUPERMANANTI', '32.63', '0.00', '141991.27', NULL, '0000-00-00 00:00:00', 1),
(131, 2, '2018-12-03', 'REDIVA 19210farmacia bik', '6.95', '0.00', '141998.22', NULL, '0000-00-00 00:00:00', 1),
(132, 2, '2018-12-03', 'COMPRA BAZAAR  ', '0.00', '590.00', '141408.22', NULL, '0000-00-00 00:00:00', 1),
(133, 2, '2018-12-03', 'COMPRA SUPERMANANTI  ', '0.00', '995.20', '140413.02', NULL, '0000-00-00 00:00:00', 1),
(134, 2, '2018-12-03', 'COMPRA farmacia bik  ', '0.00', '212.00', '140201.02', NULL, '0000-00-00 00:00:00', 1),
(135, 2, '2018-12-03', 'DEB. VARIOS VISA-ILINK', '0.00', '50000.00', '90201.02', NULL, '0000-00-00 00:00:00', 1),
(136, 2, '2018-12-04', 'REDIVA 19210ANCAP CARRAS', '4.26', '0.00', '90205.28', NULL, '0000-00-00 00:00:00', 1),
(137, 2, '2018-12-04', 'REDIVA 19210FERTILAB', '6.55', '0.00', '90211.83', NULL, '0000-00-00 00:00:00', 1),
(138, 2, '2018-12-04', 'REDIVA 19210legroupe', '29.43', '0.00', '90241.26', NULL, '0000-00-00 00:00:00', 1),
(139, 2, '2018-12-04', 'COMPRA ANCAP CARRAS  ', '0.00', '130.00', '90111.26', NULL, '0000-00-00 00:00:00', 1),
(140, 2, '2018-12-04', 'COMPRA ANCAP CARRAS  ', '0.00', '2740.00', '87371.26', NULL, '0000-00-00 00:00:00', 1),
(141, 2, '2018-12-04', 'COMPRA FERTILAB  ', '0.00', '180.00', '87191.26', NULL, '0000-00-00 00:00:00', 1),
(142, 2, '2018-12-04', 'COMPRA legroupe  ', '0.00', '439.00', '86752.26', NULL, '0000-00-00 00:00:00', 1),
(143, 2, '2018-12-05', 'REDIVA 19210ANTEL 262900', '21.70', '0.00', '86773.96', NULL, '0000-00-00 00:00:00', 1),
(144, 2, '2018-12-05', 'PAGO FACTURAANTEL 262900', '0.00', '1506.00', '85267.96', NULL, '0000-00-00 00:00:00', 1),
(145, 2, '2018-12-05', 'DEB. VARIOS PAGO D.G.I.', '0.00', '18903.00', '66364.96', NULL, '0000-00-00 00:00:00', 1),
(146, 2, '2018-12-06', 'DEB. CAMBIOSST....623787', '0.00', '1200.00', '65164.96', NULL, '0000-00-00 00:00:00', 1),
(147, 2, '2018-12-07', 'TRASPASO A 3429076ILINK  ', '0.00', '22508.00', '42656.96', NULL, '0000-00-00 00:00:00', 1),
(148, 2, '2018-12-07', 'COMPRA legroupe  ', '0.00', '439.00', '42217.96', NULL, '0000-00-00 00:00:00', 1),
(149, 2, '2018-12-07', 'REDIVA 19210legroupe', '29.43', '0.00', '42247.39', NULL, '0000-00-00 00:00:00', 1),
(150, 2, '2018-12-10', 'REDIVA 19210DEVOTO EXPRE', '46.45', '0.00', '42293.84', NULL, '0000-00-00 00:00:00', 1),
(151, 2, '2018-12-10', 'COMPRA DEVOTO EXPRE  ', '0.00', '1411.09', '40882.75', NULL, '0000-00-00 00:00:00', 1),
(152, 2, '2018-12-10', 'REDIVA 19210los reyes ma', '65.25', '0.00', '40948.00', NULL, '0000-00-00 00:00:00', 1),
(153, 2, '2018-12-10', 'COMPRA los reyes ma  ', '0.00', '1990.00', '38958.00', NULL, '0000-00-00 00:00:00', 1),
(154, 2, '2018-12-10', 'TRASPASO A 6336322ILINK  ', '0.00', '6840.00', '32118.00', NULL, '0000-00-00 00:00:00', 1),
(155, 2, '2018-12-10', 'TRASPASO A 3851304ILINK  ', '0.00', '14950.00', '17168.00', NULL, '0000-00-00 00:00:00', 1),
(156, 2, '2018-12-11', 'DEP 24 HORAS 008453111', '44849.34', '0.00', '62017.34', NULL, '0000-00-00 00:00:00', 1),
(157, 2, '2018-12-11', 'COMPRA ABITAB807777  ', '0.00', '325.23', '61692.11', NULL, '0000-00-00 00:00:00', 1),
(158, 2, '2018-12-11', 'DEBITO ABITAB807777', '0.00', '1.13', '61690.98', NULL, '0000-00-00 00:00:00', 1),
(159, 2, '2018-12-12', 'TRASPASO A 7954 ILINK', '0.00', '16900.00', '44790.98', NULL, '0000-00-00 00:00:00', 1),
(160, 2, '2018-12-13', 'TRASPASO DE 8529099', '18618.47', '0.00', '63409.45', NULL, '0000-00-00 00:00:00', 1),
(161, 2, '2018-12-13', 'DEB. VARIOS VISA', '0.00', '63409.45', '0.00', NULL, '0000-00-00 00:00:00', 1),
(162, 2, '2018-12-14', 'TRASPASO DE 8320010ILINK', '150000.00', '0.00', '150000.00', NULL, '0000-00-00 00:00:00', 1),
(163, 2, '2018-12-14', 'TRASPASO A 3851304ILINK  ', '0.00', '12411.00', '137589.00', NULL, '0000-00-00 00:00:00', 1),
(164, 2, '2018-12-14', 'TRASPASO A 9693040ILINK  ', '0.00', '856.00', '136733.00', NULL, '0000-00-00 00:00:00', 1),
(165, 2, '2018-12-14', 'TRASPASO A 8245270ILINK  ', '0.00', '460.00', '136273.00', NULL, '0000-00-00 00:00:00', 1),
(166, 2, '2018-12-14', 'REDIVA 19210MC DONALDS', '18.74', '0.00', '136291.74', NULL, '0000-00-00 00:00:00', 1),
(167, 2, '2018-12-14', 'REDIVA 19210estilo roma', '12.79', '0.00', '136304.53', NULL, '0000-00-00 00:00:00', 1),
(168, 2, '2018-12-14', 'REDIVA 19210CINE MOVIE', '6.39', '0.00', '136310.92', NULL, '0000-00-00 00:00:00', 1),
(169, 2, '2018-12-14', 'COMPRA MC DONALDS  ', '0.00', '254.00', '136056.92', NULL, '0000-00-00 00:00:00', 1),
(170, 2, '2018-12-14', 'COMPRA estilo roma  ', '0.00', '390.00', '135666.92', NULL, '0000-00-00 00:00:00', 1),
(171, 2, '2018-12-14', 'COMPRA CINE MOVIE  ', '0.00', '195.00', '135471.92', NULL, '0000-00-00 00:00:00', 1),
(172, 2, '2018-12-17', 'REDIVA 19210KINKO', '8.69', '0.00', '135480.61', NULL, '0000-00-00 00:00:00', 1),
(173, 2, '2018-12-17', 'REDIVA 19210ser animal', '9.51', '0.00', '135490.12', NULL, '0000-00-00 00:00:00', 1),
(174, 2, '2018-12-17', 'REDIVA 19210DEVOTO EXPRE', '46.22', '0.00', '135536.34', NULL, '0000-00-00 00:00:00', 1),
(175, 2, '2018-12-17', 'COMPRA ser animal  ', '0.00', '290.00', '135246.34', NULL, '0000-00-00 00:00:00', 1),
(176, 2, '2018-12-17', 'COMPRA DEVOTO EXPRE  ', '0.00', '1397.48', '133848.86', NULL, '0000-00-00 00:00:00', 1),
(177, 2, '2018-12-17', 'COMPRA KINKO  ', '0.00', '265.00', '133583.86', NULL, '0000-00-00 00:00:00', 1),
(178, 2, '2018-12-17', 'REDIVA 19210MC DONALDS', '18.74', '0.00', '133602.60', NULL, '0000-00-00 00:00:00', 1),
(179, 2, '2018-12-17', 'REDIVA 19210DEVOTO SUPER', '16.82', '0.00', '133619.42', NULL, '0000-00-00 00:00:00', 1),
(180, 2, '2018-12-17', 'COMPRA MC DONALDS  ', '0.00', '368.00', '133251.42', NULL, '0000-00-00 00:00:00', 1),
(181, 2, '2018-12-17', 'COMPRA MC DONALDS  ', '0.00', '254.00', '132997.42', NULL, '0000-00-00 00:00:00', 1),
(182, 2, '2018-12-17', 'COMPRA DEVOTO SUPER  ', '0.00', '512.97', '132484.45', NULL, '0000-00-00 00:00:00', 1),
(183, 2, '2018-12-17', 'REDIVA 19210MC DONALDS', '27.15', '0.00', '132511.60', NULL, '0000-00-00 00:00:00', 1),
(184, 2, '2018-12-18', 'REDIVA 19210KINKO', '14.93', '0.00', '132526.53', NULL, '0000-00-00 00:00:00', 1),
(185, 2, '2018-12-18', 'REDIVA 19210BURGER KING', '19.84', '0.00', '132546.37', NULL, '0000-00-00 00:00:00', 1),
(186, 2, '2018-12-18', 'COMPRA KINKO  ', '0.00', '451.28', '132095.09', NULL, '0000-00-00 00:00:00', 1),
(187, 2, '2018-12-18', 'COMPRA BURGER KING  ', '0.00', '269.00', '131826.09', NULL, '0000-00-00 00:00:00', 1),
(188, 2, '2018-12-18', 'COMPRA ART COMPUTER  ', '0.00', '1650.00', '130176.09', NULL, '0000-00-00 00:00:00', 1),
(189, 2, '2018-12-19', 'REDIVA 19210UTE 795716', '70.25', '0.00', '130246.34', NULL, '0000-00-00 00:00:00', 1),
(190, 2, '2018-12-19', 'PAGO FACTURAUTE 795716', '0.00', '4285.00', '125961.34', NULL, '0000-00-00 00:00:00', 1),
(191, 2, '2018-12-19', 'REDIVA 19210entreacto', '69.34', '0.00', '126030.68', NULL, '0000-00-00 00:00:00', 1),
(192, 2, '2018-12-19', 'COMPRA entreacto  ', '0.00', '1034.00', '124996.68', NULL, '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rubro_cuenta`
--

CREATE TABLE `rubro_cuenta` (
  `id` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `rubro_persona_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rubro_cuenta`
--

INSERT INTO `rubro_cuenta` (`id`, `nombre`, `rubro_persona_id`, `status`) VALUES
(1, 'Comidas Matt', 1, 1),
(4, 'Kiwi', 3, 1),
(5, 'Las Chicas', 3, 1),
(6, 'Comidas Pow', 2, 1),
(7, 'Supermercado', 3, 1),
(8, 'Colegios', 3, 1),
(9, 'De la casa', 3, 1),
(10, 'BPS', 3, 1),
(11, 'Sueldos', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rubro_persona`
--

CREATE TABLE `rubro_persona` (
  `id` int(11) NOT NULL,
  `unique_name` varchar(10) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `color` varchar(10) NOT NULL DEFAULT 'black',
  `status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rubro_persona`
--

INSERT INTO `rubro_persona` (`id`, `unique_name`, `nombre`, `color`, `status`) VALUES
(1, 'pow', 'Pow', 'blue', 1),
(2, 'comun', 'Matt', 'green', 1),
(3, 'matt', 'Común', 'black', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cuentas`
--
ALTER TABLE `cuentas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `moneda` (`moneda`);

--
-- Indexes for table `moneda`
--
ALTER TABLE `moneda`
  ADD PRIMARY KEY (`moneda`);

--
-- Indexes for table `movimientos_cuentas`
--
ALTER TABLE `movimientos_cuentas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `cuenta_ud` (`cuentaId`);

--
-- Indexes for table `rubro_cuenta`
--
ALTER TABLE `rubro_cuenta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rubro_persona_id` (`rubro_persona_id`);

--
-- Indexes for table `rubro_persona`
--
ALTER TABLE `rubro_persona`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cuentas`
--
ALTER TABLE `cuentas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `movimientos_cuentas`
--
ALTER TABLE `movimientos_cuentas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=193;
--
-- AUTO_INCREMENT for table `rubro_cuenta`
--
ALTER TABLE `rubro_cuenta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `rubro_persona`
--
ALTER TABLE `rubro_persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
