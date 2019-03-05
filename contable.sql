-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Mar 04, 2019 at 11:14 PM
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
DROP DATABASE `contable`;

-- --------------------------------------------------------

--
-- Table structure for table `cuentas`
--

CREATE TABLE `cuentas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `moneda` varchar(3) NOT NULL,
  `parser` varchar(10) NOT NULL,
  `parser_asoc` varchar(15) DEFAULT NULL,
  `saldo` decimal(10,2) NOT NULL,
  `show_txt_otros` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cuentas`
--

INSERT INTO `cuentas` (`id`, `nombre`, `moneda`, `parser`, `parser_asoc`, `saldo`, `show_txt_otros`, `status`) VALUES
(1, 'Iatú Matt - CA', 'UYU', 'itau-web', NULL, '155504.93', '', 1),
(2, 'Iatú Matt - CA', 'USD', 'itau-web', NULL, '46142.18', '', 1),
(3, 'Itau Matt - CC', 'UYU', 'itau-web', NULL, '374817.77', '', 1),
(4, 'Itau Matt - CC', 'USD', 'itau-web', NULL, '14264.02', '', 1),
(6, 'ACSA cta #110499', 'UYU', 'acsa-web', NULL, '-145191.70', '', 1),
(7, 'Visa', 'UYU', 'visa-itau', '7,8', '-50664.70', 'Tarjeta Nro', 1),
(8, 'Visa', 'USD', 'visa-itau', '7,8', '24.39', 'Tarjeta Nro', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cuentas_saldos_persona`
--

CREATE TABLE `cuentas_saldos_persona` (
  `id` int(11) NOT NULL,
  `cuenta_id` int(11) NOT NULL,
  `persona_id` int(11) NOT NULL,
  `saldo` decimal(10,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cuentas_saldos_persona`
--

INSERT INTO `cuentas_saldos_persona` (`id`, `cuenta_id`, `persona_id`, `saldo`) VALUES
(37, 1, 4, '186859.98'),
(38, 1, 3, '-112686.00'),
(39, 1, 2, '-542.00'),
(40, 1, 1, '0.00');

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
  `txt_otros` varchar(50) DEFAULT NULL,
  `debito` decimal(10,2) NOT NULL,
  `credito` decimal(10,2) NOT NULL,
  `saldo` decimal(10,2) NOT NULL,
  `saldo_cta1` decimal(10,2) DEFAULT NULL,
  `saldo_cta2` decimal(10,2) DEFAULT NULL,
  `saldo_cta3` decimal(10,2) DEFAULT NULL,
  `saldo_cta4` decimal(10,2) NOT NULL,
  `persona_id` int(11) DEFAULT NULL,
  `rubro_id` int(11) DEFAULT NULL,
  `fecha_auto` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=325 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `movimientos_cuentas`
--

INSERT INTO `movimientos_cuentas` (`id`, `cuentaId`, `fecha`, `concepto`, `txt_otros`, `debito`, `credito`, `saldo`, `saldo_cta1`, `saldo_cta2`, `saldo_cta3`, `saldo_cta4`, `persona_id`, `rubro_id`, `fecha_auto`, `status`) VALUES
(280, 1, '2019-02-01', 'REDIVA 19210ANTEL 262900', NULL, '0.00', '23.64', '126337.12', '0.00', '0.00', '0.00', '126337.12', 4, 12, '2019-02-25 22:36:04', 1),
(281, 1, '2019-02-01', 'PAGO FACTURAANTEL 262900', NULL, '1632.00', '0.00', '124705.12', '0.00', '0.00', '-1632.00', '126337.12', 3, 20, '2019-02-25 22:36:50', 1),
(282, 1, '2019-02-01', 'DEB. VARIOS VISA-ILINK', NULL, '50000.00', '0.00', '74705.12', '0.00', '0.00', '-51632.00', '126337.12', 3, 15, '2019-02-25 22:36:55', 1),
(283, 1, '2019-02-04', 'TRASPASO A 7954 ILINK', NULL, '11560.00', '0.00', '63145.12', '0.00', '0.00', '-63192.00', '126337.12', 3, 8, '2019-02-25 22:37:03', 1),
(284, 1, '2019-02-04', 'COMPRA VETERINARIA  ', NULL, '2110.00', '0.00', '61035.12', '0.00', '0.00', '-65302.00', '126337.12', 3, 4, '2019-02-25 22:37:06', 1),
(285, 1, '2019-02-04', 'REDIVA 19210VETERINARIA', NULL, '0.00', '69.18', '61104.30', '0.00', '0.00', '-65302.00', '126406.30', 4, 12, '2019-02-25 22:37:06', 1),
(286, 1, '2019-02-05', 'DEB. CAMBIOSST....053960', NULL, '1760.00', '0.00', '59344.30', '0.00', '0.00', '-67062.00', '126406.30', 3, 9, '2019-02-25 23:27:56', 1),
(287, 1, '2019-02-06', 'REDIVA 19210MOSCA', NULL, '0.00', '19.92', '59364.22', '0.00', '0.00', '-67062.00', '126426.22', 4, 12, '2019-02-25 23:27:56', 1),
(288, 1, '2019-02-06', 'COMPRA MOSCA  ', NULL, '608.00', '0.00', '58756.22', '0.00', '0.00', '-67670.00', '126426.22', 3, 18, '2019-02-25 23:28:00', 1),
(289, 1, '2019-02-06', 'REDIVA 19210MC DONALDS', NULL, '0.00', '39.98', '58796.20', '0.00', '0.00', '-67670.00', '126466.20', 4, 12, '2019-02-25 23:28:00', 1),
(290, 1, '2019-02-06', 'COMPRA MC DONALDS  ', NULL, '542.00', '0.00', '58254.20', '0.00', '-542.00', '-67670.00', '126466.20', 2, 6, '2019-02-25 23:28:11', 1),
(291, 1, '2019-02-07', 'TRASPASO DE 8320010ILINK  ', NULL, '0.00', '60000.00', '118254.20', '0.00', '-542.00', '-67670.00', '186466.20', 4, 25, '2019-02-25 23:28:16', 1),
(292, 1, '2019-02-07', 'TRASPASO A 3429076ILINK  ', NULL, '45016.00', '0.00', '73238.20', '0.00', '-542.00', '-112686.00', '186466.20', 3, 8, '2019-02-25 23:28:21', 1),
(293, 1, '2019-02-11', 'DEB. CAMBIOSST....099720', NULL, '350.00', '0.00', '72888.20', '0.00', '-542.00', '-112686.00', '186466.20', NULL, NULL, '2019-02-25 23:30:38', 1),
(294, 1, '2019-02-12', 'DEP 24 HORAS 008859062', NULL, '0.00', '45893.81', '118782.01', '0.00', '-542.00', '-112686.00', '186466.20', NULL, NULL, '2019-02-25 23:30:38', 1),
(295, 1, '2019-02-12', 'REDIVA 19210MC DONALDS', NULL, '0.00', '19.11', '118801.12', '0.00', '-542.00', '-112686.00', '186485.31', 4, 12, '2019-02-25 23:30:38', 1),
(296, 1, '2019-02-12', 'COMPRA MC DONALDS  ', NULL, '259.00', '0.00', '118542.12', '0.00', '-542.00', '-112686.00', '186485.31', NULL, NULL, '2019-02-25 23:30:38', 1),
(297, 1, '2019-02-12', 'REDIVA 19210TIENDA INGLE', NULL, '0.00', '142.42', '118684.54', '0.00', '-542.00', '-112686.00', '186627.73', 4, 12, '2019-02-25 23:30:38', 1),
(298, 1, '2019-02-12', 'COMPRA TIENDA INGLE  ', NULL, '4200.00', '0.00', '114484.54', '0.00', '-542.00', '-112686.00', '186627.73', NULL, NULL, '2019-02-25 23:30:38', 1),
(299, 1, '2019-02-13', 'REDIVA 19210UTE 795716', NULL, '0.00', '73.74', '114558.28', '0.00', '-542.00', '-112686.00', '186701.47', 4, 12, '2019-02-25 23:30:38', 1),
(300, 1, '2019-02-13', 'PAGO FACTURAUTE 795716', NULL, '4838.00', '0.00', '109720.28', '0.00', '-542.00', '-112686.00', '186701.47', NULL, NULL, '2019-02-25 23:30:38', 1),
(301, 1, '2019-02-14', 'REDIVA 19210minimercado', NULL, '0.00', '5.87', '109726.15', '0.00', '-542.00', '-112686.00', '186707.34', 4, 12, '2019-02-26 02:07:39', 1),
(302, 1, '2019-02-14', 'COMPRA minimercado  ', NULL, '179.00', '0.00', '109547.15', '0.00', '-542.00', '-112686.00', '186707.34', NULL, NULL, '2019-02-26 02:07:39', 1),
(303, 1, '2019-02-14', 'DEB. VARIOS VISA', NULL, '52515.86', '0.00', '57031.29', '0.00', '-542.00', '-112686.00', '186707.34', NULL, NULL, '2019-02-26 02:07:39', 1),
(304, 1, '2019-02-15', 'TRASPASO A 3851304ILINK  ', NULL, '676.00', '0.00', '56355.29', '0.00', '-542.00', '-112686.00', '186707.34', NULL, NULL, '2019-02-26 02:07:39', 1),
(305, 1, '2019-02-15', 'REDIVA 19210minimercado', NULL, '0.00', '35.02', '56390.31', '0.00', '-542.00', '-112686.00', '186742.36', 4, 12, '2019-02-26 02:07:39', 1),
(306, 1, '2019-02-15', 'COMPRA minimercado  ', NULL, '1068.00', '0.00', '55322.31', '0.00', '-542.00', '-112686.00', '186742.36', NULL, NULL, '2019-02-26 02:07:39', 1),
(307, 1, '2019-02-18', 'REDIVA 19210minimercado', NULL, '0.00', '3.54', '55325.85', '0.00', '-542.00', '-112686.00', '186745.90', 4, 12, '2019-02-26 02:07:39', 1),
(308, 1, '2019-02-18', 'COMPRA ANCAP LA BAR  ', NULL, '2900.00', '0.00', '52425.85', '0.00', '-542.00', '-112686.00', '186745.90', NULL, NULL, '2019-02-26 02:07:39', 1),
(309, 1, '2019-02-18', 'COMPRA minimercado  ', NULL, '108.00', '0.00', '52317.85', '0.00', '-542.00', '-112686.00', '186745.90', NULL, NULL, '2019-02-26 02:07:39', 1),
(310, 1, '2019-02-20', 'CRED.DIRECTOSWISS MEDICA', NULL, '0.00', '2229.00', '54546.85', '0.00', '-542.00', '-112686.00', '186745.90', NULL, NULL, '2019-02-26 02:07:39', 1),
(311, 1, '2019-02-21', 'REDIVA 19210TIENDA INGLE', NULL, '0.00', '53.82', '54600.67', '0.00', '-542.00', '-112686.00', '186799.72', 4, 12, '2019-02-26 02:07:39', 1),
(312, 1, '2019-02-21', 'REDIVA 19210un altra vol', NULL, '0.00', '36.39', '54637.06', '0.00', '-542.00', '-112686.00', '186836.11', 4, 12, '2019-02-26 02:07:39', 1),
(313, 1, '2019-02-21', 'COMPRA TIENDA INGLE  ', NULL, '1540.00', '0.00', '53097.06', '0.00', '-542.00', '-112686.00', '186836.11', NULL, NULL, '2019-02-26 02:07:39', 1),
(314, 1, '2019-02-21', 'COMPRA un altra vol  ', NULL, '1110.00', '0.00', '51987.06', '0.00', '-542.00', '-112686.00', '186836.11', NULL, NULL, '2019-02-26 02:07:39', 1),
(315, 1, '2019-02-21', 'PAGO FACTURABPS', NULL, '9167.00', '0.00', '42820.06', '0.00', '-542.00', '-112686.00', '186836.11', NULL, NULL, '2019-02-26 02:07:39', 1),
(316, 1, '2019-02-22', 'TRASPASO A 8062645ILINK  ', NULL, '1276.00', '0.00', '41544.06', '0.00', '-542.00', '-112686.00', '186836.11', NULL, NULL, '2019-02-26 02:07:39', 1),
(317, 1, '2019-02-25', 'COMPRA ANCAP JOSE I  ', NULL, '531.00', '0.00', '41013.06', '0.00', '-542.00', '-112686.00', '186836.11', NULL, NULL, '2019-02-26 02:07:39', 1),
(318, 1, '2019-02-25', 'REDIVA 19210ANCAP JOSE I', NULL, '0.00', '17.41', '41030.47', '0.00', '-542.00', '-112686.00', '186853.52', 4, 12, '2019-02-26 02:07:39', 1),
(319, 1, '2019-02-25', 'TRASPASO DE 8320010ILINK  ', NULL, '0.00', '150000.00', '191030.47', '0.00', '-542.00', '-112686.00', '186853.52', NULL, NULL, '2019-02-26 02:07:39', 1),
(320, 1, '2019-02-25', 'TRASPASO A 3851304ILINK  ', NULL, '755.00', '0.00', '190275.47', '0.00', '-542.00', '-112686.00', '186853.52', NULL, NULL, '2019-02-26 02:07:39', 1),
(321, 1, '2019-02-25', 'TRASPASO A 41109 ILINK', NULL, '33900.00', '0.00', '156375.47', '0.00', '-542.00', '-112686.00', '186853.52', NULL, NULL, '2019-02-26 02:07:39', 1),
(322, 1, '2019-02-25', 'COMPRA ANCAP JOSE I  ', NULL, '680.00', '0.00', '155695.47', '0.00', '-542.00', '-112686.00', '186853.52', NULL, NULL, '2019-02-26 02:07:39', 1),
(323, 1, '2019-02-25', 'COMPRA ANCAP JOSE I  ', NULL, '197.00', '0.00', '155498.47', '0.00', '-542.00', '-112686.00', '186853.52', NULL, NULL, '2019-02-26 02:07:39', 1),
(324, 1, '2019-02-25', 'REDIVA 19210ANCAP JOSE I', NULL, '0.00', '6.46', '155504.93', '0.00', '-542.00', '-112686.00', '186859.98', 4, 12, '2019-02-26 02:07:39', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rubro_cuenta`
--

CREATE TABLE `rubro_cuenta` (
  `id` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `rubro_persona_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rubro_cuenta`
--

INSERT INTO `rubro_cuenta` (`id`, `nombre`, `rubro_persona_id`, `status`) VALUES
(1, 'Comidas Pow', 1, 1),
(4, 'Kiwi', 3, 1),
(5, 'Las Chicas', 3, 1),
(6, 'Comidas Matt', 2, 1),
(7, 'Supermercado', 3, 1),
(8, 'Colegios', 3, 1),
(9, 'De la casa', 3, 1),
(10, 'BPS', 4, 1),
(11, 'Sueldos', 4, 1),
(12, 'IVA', 4, 1),
(13, 'Otros', 1, 1),
(14, 'Farmacia', 3, 1),
(15, 'Tarjetas', 3, 1),
(16, 'Nafta', 2, 1),
(17, 'DGI', 4, 1),
(18, 'Otros', 3, 1),
(20, 'Antel/UTE/OSE', 3, 1),
(21, 'Herramientas', 2, 1),
(22, 'Otros', 2, 1),
(23, 'San Quintín', 4, 1),
(24, 'Apto 801', 4, 1),
(25, 'Transferencias', 4, 1),
(26, 'Nafta', 1, 1),
(27, 'Comidas', 3, 1),
(28, 'Cobros', 4, 1),
(29, 'Blue Cross', 3, 1),
(30, 'Gastos Bancos', 4, 1),
(31, 'Honorarios Ascesores', 4, 1),
(32, 'La Nube', 4, 1),
(33, 'De Viaje', 3, 1),
(34, 'Uber', 1, 1),
(35, 'Gastos Trabajo', 4, 1),
(36, 'Retiro Efectivo', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rubro_persona`
--

CREATE TABLE `rubro_persona` (
  `id` int(11) NOT NULL,
  `unique_name` varchar(10) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `color` varchar(10) NOT NULL DEFAULT 'black',
  `color_light` varchar(10) NOT NULL,
  `caracter_unico` varchar(1) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rubro_persona`
--

INSERT INTO `rubro_persona` (`id`, `unique_name`, `nombre`, `color`, `color_light`, `caracter_unico`, `status`) VALUES
(1, 'cta_pow', 'Pow', 'violet', '#99ccff', 'P', 1),
(2, 'cta_matt', 'Matt', 'orange', '#ffdb99', 'M', 1),
(3, 'cta_comun', 'Común', 'black', '#999999', 'C', 1),
(4, 'cta_laburo', 'Laburo', 'blue', '', 'L', 1);

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
-- Indexes for table `cuentas_saldos_persona`
--
ALTER TABLE `cuentas_saldos_persona`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cuenta_id` (`cuenta_id`),
  ADD KEY `persona_id` (`persona_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `cuentas_saldos_persona`
--
ALTER TABLE `cuentas_saldos_persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `movimientos_cuentas`
--
ALTER TABLE `movimientos_cuentas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=325;
--
-- AUTO_INCREMENT for table `rubro_cuenta`
--
ALTER TABLE `rubro_cuenta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `rubro_persona`
--
ALTER TABLE `rubro_persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
