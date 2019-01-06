-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Jan 05, 2019 at 07:46 PM
-- Server version: 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

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
(1, 'Iatú Matt - Caja de Ahorros', 'UYU', 'itau-web', '141939.30', 1),
(2, 'Iatú Matt - Caja de Ahorros', 'USD', 'itau-web', '61690.98', 1),
(3, 'Pow Iatú', 'UYU', 'itau-web', '3122.32', 1),
(4, 'Pow Itaú', 'USD', 'itau-web', '234.11', 1),
(5, 'Pershing (inversión)', 'USD', '', '291070.12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cuentas_saldos_persona`
--

CREATE TABLE `cuentas_saldos_persona` (
  `id` int(11) NOT NULL,
  `cuenta_id` int(11) NOT NULL,
  `persona_id` int(11) NOT NULL,
  `saldo` decimal(10,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cuentas_saldos_persona`
--

INSERT INTO `cuentas_saldos_persona` (`id`, `cuenta_id`, `persona_id`, `saldo`) VALUES
(9, 1, 3, '141939.30');

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
  `persona_id` int(11) DEFAULT NULL,
  `rubro_id` int(11) DEFAULT NULL,
  `fecha_auto` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1588 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rubro_cuenta`
--

CREATE TABLE `rubro_cuenta` (
  `id` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `rubro_persona_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

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
(10, 'BPS', 3, 1),
(11, 'Sueldos', 3, 1),
(12, 'IVA', 3, 1),
(13, 'Otros', 1, 1),
(14, 'Farmacia', 3, 1),
(15, 'Tarjetas', 3, 1),
(16, 'Nafta', 2, 1),
(17, 'DGI', 3, 1),
(18, 'Otros', 3, 1),
(19, 'Antel/UTE/OSE', 0, 1),
(20, 'Antel/UTE/OSE', 3, 1),
(21, 'Herramientas', 2, 1),
(22, 'Otros', 2, 1),
(23, 'San Quintín', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rubro_persona`
--

CREATE TABLE `rubro_persona` (
  `id` int(11) NOT NULL,
  `unique_name` varchar(10) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `color` varchar(10) NOT NULL DEFAULT 'black',
  `caracter_unico` varchar(1) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rubro_persona`
--

INSERT INTO `rubro_persona` (`id`, `unique_name`, `nombre`, `color`, `caracter_unico`, `status`) VALUES
(1, 'cta_pow', 'Pow', 'blue', 'P', 1),
(2, 'cta_matt', 'Matt', 'green', 'M', 1),
(3, 'cta_comun', 'Común', 'black', 'C', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `cuentas_saldos_persona`
--
ALTER TABLE `cuentas_saldos_persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `movimientos_cuentas`
--
ALTER TABLE `movimientos_cuentas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1588;
--
-- AUTO_INCREMENT for table `rubro_cuenta`
--
ALTER TABLE `rubro_cuenta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `rubro_persona`
--
ALTER TABLE `rubro_persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;