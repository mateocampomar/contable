-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Jan 16, 2019 at 12:14 AM
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

DROP TABLE IF EXISTS `cuentas`;
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
(1, 'Iatú Matt - Caja de Ahorros', 'UYU', 'itau-web', '68288.20', 1),
(2, 'Iatú Matt - Caja de Ahorros', 'USD', 'itau-web', '61690.98', 1),
(3, 'Pow Iatú', 'UYU', 'itau-web', '3122.32', 1),
(4, 'Pow Itaú', 'USD', 'itau-web', '234.11', 1),
(5, 'Pershing (inversión)', 'USD', '', '291070.12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cuentas_saldos_persona`
--

DROP TABLE IF EXISTS `cuentas_saldos_persona`;
CREATE TABLE `cuentas_saldos_persona` (
  `id` int(11) NOT NULL,
  `cuenta_id` int(11) NOT NULL,
  `persona_id` int(11) NOT NULL,
  `saldo` decimal(10,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cuentas_saldos_persona`
--

INSERT INTO `cuentas_saldos_persona` (`id`, `cuenta_id`, `persona_id`, `saldo`) VALUES
(9, 1, 3, '141939.30'),
(10, 1, 2, '0.00'),
(11, 1, 1, '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `moneda`
--

DROP TABLE IF EXISTS `moneda`;
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

DROP TABLE IF EXISTS `movimientos_cuentas`;
CREATE TABLE `movimientos_cuentas` (
  `id` int(11) NOT NULL,
  `cuentaId` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `concepto` varchar(150) NOT NULL,
  `debito` decimal(10,2) NOT NULL,
  `credito` decimal(10,2) NOT NULL,
  `saldo` decimal(10,2) NOT NULL,
  `saldo_cta1` decimal(10,2) DEFAULT NULL,
  `saldo_cta2` decimal(10,2) DEFAULT NULL,
  `saldo_cta3` decimal(10,2) DEFAULT NULL,
  `persona_id` int(11) DEFAULT NULL,
  `rubro_id` int(11) DEFAULT NULL,
  `fecha_auto` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1679 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `movimientos_cuentas`
--

INSERT INTO `movimientos_cuentas` (`id`, `cuentaId`, `fecha`, `concepto`, `debito`, `credito`, `saldo`, `saldo_cta1`, `saldo_cta2`, `saldo_cta3`, `persona_id`, `rubro_id`, `fecha_auto`, `status`) VALUES
(1588, 1, '2018-12-03', 'REDIVA 19210BAZAAR', '0.00', '19.34', '141958.64', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1589, 1, '2018-12-03', 'REDIVA 19210SUPERMANANTI', '0.00', '32.63', '141991.27', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1590, 1, '2018-12-03', 'REDIVA 19210farmacia bik', '0.00', '6.95', '141998.22', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1591, 1, '2018-12-03', 'COMPRA BAZAAR  ', '590.00', '0.00', '141408.22', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1592, 1, '2018-12-03', 'COMPRA SUPERMANANTI  ', '995.20', '0.00', '140413.02', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1593, 1, '2018-12-03', 'COMPRA farmacia bik  ', '212.00', '0.00', '140201.02', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1594, 1, '2018-12-03', 'DEB. VARIOS VISA-ILINK', '50000.00', '0.00', '90201.02', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1595, 1, '2018-12-04', 'REDIVA 19210ANCAP CARRAS', '0.00', '4.26', '90205.28', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1596, 1, '2018-12-04', 'REDIVA 19210FERTILAB', '0.00', '6.55', '90211.83', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1597, 1, '2018-12-04', 'REDIVA 19210legroupe', '0.00', '29.43', '90241.26', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1598, 1, '2018-12-04', 'COMPRA ANCAP CARRAS  ', '130.00', '0.00', '90111.26', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1599, 1, '2018-12-04', 'COMPRA ANCAP CARRAS  ', '2740.00', '0.00', '87371.26', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1600, 1, '2018-12-04', 'COMPRA FERTILAB  ', '180.00', '0.00', '87191.26', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1601, 1, '2018-12-04', 'COMPRA legroupe  ', '439.00', '0.00', '86752.26', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1602, 1, '2018-12-05', 'REDIVA 19210ANTEL 262900', '0.00', '21.70', '86773.96', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1603, 1, '2018-12-05', 'PAGO FACTURAANTEL 262900', '1506.00', '0.00', '85267.96', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1604, 1, '2018-12-05', 'DEB. VARIOS PAGO D.G.I.', '18903.00', '0.00', '66364.96', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1605, 1, '2018-12-06', 'DEB. CAMBIOSST....623787', '1200.00', '0.00', '65164.96', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1606, 1, '2018-12-07', 'TRASPASO A 3429076ILINK  ', '22508.00', '0.00', '42656.96', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1607, 1, '2018-12-07', 'COMPRA legroupe  ', '439.00', '0.00', '42217.96', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1608, 1, '2018-12-07', 'REDIVA 19210legroupe', '0.00', '29.43', '42247.39', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1609, 1, '2018-12-10', 'REDIVA 19210DEVOTO EXPRE', '0.00', '46.45', '42293.84', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1610, 1, '2018-12-10', 'COMPRA DEVOTO EXPRE  ', '1411.09', '0.00', '40882.75', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1611, 1, '2018-12-10', 'REDIVA 19210los reyes ma', '0.00', '65.25', '40948.00', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1612, 1, '2018-12-10', 'COMPRA los reyes ma  ', '1990.00', '0.00', '38958.00', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1613, 1, '2018-12-10', 'TRASPASO A 6336322ILINK  ', '6840.00', '0.00', '32118.00', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1614, 1, '2018-12-10', 'TRASPASO A 3851304ILINK  ', '14950.00', '0.00', '17168.00', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1615, 1, '2018-12-11', 'DEP 24 HORAS 008453111', '0.00', '44849.34', '62017.34', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1616, 1, '2018-12-11', 'COMPRA ABITAB807777  ', '325.23', '0.00', '61692.11', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1617, 1, '2018-12-11', 'DEBITO ABITAB807777', '1.13', '0.00', '61690.98', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1618, 1, '2018-12-12', 'TRASPASO A 7954 ILINK', '16900.00', '0.00', '44790.98', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1619, 1, '2018-12-13', 'TRASPASO DE 8529099', '0.00', '18618.47', '63409.45', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1620, 1, '2018-12-13', 'DEB. VARIOS VISA', '63409.45', '0.00', '0.00', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1621, 1, '2018-12-14', 'TRASPASO DE 8320010ILINK', '0.00', '150000.00', '150000.00', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1622, 1, '2018-12-14', 'TRASPASO A 3851304ILINK  ', '12411.00', '0.00', '137589.00', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1623, 1, '2018-12-14', 'TRASPASO A 9693040ILINK  ', '856.00', '0.00', '136733.00', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1624, 1, '2018-12-14', 'TRASPASO A 8245270ILINK  ', '460.00', '0.00', '136273.00', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1625, 1, '2018-12-14', 'REDIVA 19210MC DONALDS', '0.00', '18.74', '136291.74', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1626, 1, '2018-12-14', 'REDIVA 19210estilo roma', '0.00', '12.79', '136304.53', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1627, 1, '2018-12-14', 'REDIVA 19210CINE MOVIE', '0.00', '6.39', '136310.92', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1628, 1, '2018-12-14', 'COMPRA MC DONALDS  ', '254.00', '0.00', '136056.92', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1629, 1, '2018-12-14', 'COMPRA estilo roma  ', '390.00', '0.00', '135666.92', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1630, 1, '2018-12-14', 'COMPRA CINE MOVIE  ', '195.00', '0.00', '135471.92', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1631, 1, '2018-12-17', 'REDIVA 19210KINKO', '0.00', '8.69', '135480.61', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1632, 1, '2018-12-17', 'REDIVA 19210ser animal', '0.00', '9.51', '135490.12', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1633, 1, '2018-12-17', 'REDIVA 19210DEVOTO EXPRE', '0.00', '46.22', '135536.34', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1634, 1, '2018-12-17', 'COMPRA ser animal  ', '290.00', '0.00', '135246.34', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1635, 1, '2018-12-17', 'COMPRA DEVOTO EXPRE  ', '1397.48', '0.00', '133848.86', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1636, 1, '2018-12-17', 'COMPRA KINKO  ', '265.00', '0.00', '133583.86', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1637, 1, '2018-12-17', 'REDIVA 19210MC DONALDS', '0.00', '18.74', '133602.60', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1638, 1, '2018-12-17', 'REDIVA 19210DEVOTO SUPER', '0.00', '16.82', '133619.42', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1639, 1, '2018-12-17', 'COMPRA MC DONALDS  ', '368.00', '0.00', '133251.42', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1640, 1, '2018-12-17', 'COMPRA MC DONALDS  ', '254.00', '0.00', '132997.42', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1641, 1, '2018-12-17', 'COMPRA DEVOTO SUPER  ', '512.97', '0.00', '132484.45', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1642, 1, '2018-12-17', 'REDIVA 19210MC DONALDS', '0.00', '27.15', '132511.60', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1643, 1, '2018-12-18', 'REDIVA 19210KINKO', '0.00', '14.93', '132526.53', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1644, 1, '2018-12-18', 'REDIVA 19210BURGER KING', '0.00', '19.84', '132546.37', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1645, 1, '2018-12-18', 'COMPRA KINKO  ', '451.28', '0.00', '132095.09', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1646, 1, '2018-12-18', 'COMPRA BURGER KING  ', '269.00', '0.00', '131826.09', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1647, 1, '2018-12-18', 'COMPRA ART COMPUTER  ', '1650.00', '0.00', '130176.09', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1648, 1, '2018-12-19', 'REDIVA 19210UTE 795716', '0.00', '70.25', '130246.34', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1649, 1, '2018-12-19', 'PAGO FACTURAUTE 795716', '4285.00', '0.00', '125961.34', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1650, 1, '2018-12-19', 'REDIVA 19210entreacto', '0.00', '69.34', '126030.68', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1651, 1, '2018-12-19', 'COMPRA entreacto  ', '1034.00', '0.00', '124996.68', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1652, 1, '2018-12-21', 'COMPRA chelato  ', '240.00', '0.00', '124756.68', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1653, 1, '2018-12-21', 'REDIVA 19210chelato', '0.00', '7.87', '124764.55', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1654, 1, '2018-12-21', 'PAGO FACTURABPS', '13790.00', '0.00', '110974.55', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1655, 1, '2018-12-24', 'COMPRA HELADERIA FR  ', '1200.00', '0.00', '109774.55', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1656, 1, '2018-12-24', 'REDIVA 19210TIENDA INGLE', '0.00', '79.61', '109854.16', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1657, 1, '2018-12-24', 'REDIVA 19210GOURMEAT BOU', '0.00', '121.79', '109975.95', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1658, 1, '2018-12-24', 'COMPRA TIENDA INGLE  ', '2348.00', '0.00', '107627.95', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1659, 1, '2018-12-24', 'COMPRA GOURMEAT BOU  ', '3402.92', '0.00', '104225.03', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1660, 1, '2018-12-24', 'REDIVA 19210DEVOTO EXPRE', '0.00', '14.35', '104239.38', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1661, 1, '2018-12-24', 'REDIVA 19210SODIMAC', '0.00', '39.32', '104278.70', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1662, 1, '2018-12-24', 'COMPRA SODIMAC  ', '598.00', '0.00', '103680.70', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1663, 1, '2018-12-24', 'COMPRA SODIMAC  ', '1199.00', '0.00', '102481.70', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1664, 1, '2018-12-24', 'COMPRA SODIMAC  ', '179.00', '0.00', '102302.70', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1665, 1, '2018-12-24', 'COMPRA DEVOTO EXPRE  ', '437.70', '0.00', '101865.00', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1666, 1, '2018-12-24', 'REDIVA 19210HELADERIA FR', '0.00', '39.34', '101904.34', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1667, 1, '2018-12-26', 'COMPRA FRUTAS Y VER  ', '296.00', '0.00', '101608.34', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1668, 1, '2018-12-26', 'REDIVA 19210FRUTAS Y VER', '0.00', '9.70', '101618.04', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1669, 1, '2018-12-26', 'TRASPASO A 9693040ILINK  ', '8173.00', '0.00', '93445.04', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1670, 1, '2018-12-26', 'PAGO FACTURAIMMT05085591', '382.00', '0.00', '93063.04', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1671, 1, '2018-12-27', 'REDIVA 19210MVGAS 138601', '0.00', '28.85', '93091.89', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1672, 1, '2018-12-27', 'PAGO FACTURAMVGAS 138601', '1813.00', '0.00', '91278.89', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1673, 1, '2018-12-27', 'TRASPASO DE 3249071MTPAY  ', '0.00', '48445.50', '139724.39', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1674, 1, '2018-12-27', 'REDIVA 19210DEVOTO EXPRE', '0.00', '13.12', '139737.51', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1675, 1, '2018-12-27', 'COMPRA ESSO LA COS  ', '3050.00', '0.00', '136687.51', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1676, 1, '2018-12-27', 'COMPRA DEVOTO EXPRE  ', '449.31', '0.00', '136238.20', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1677, 1, '2018-12-28', 'TRASPASO A 5979609ILINK  ', '48500.00', '0.00', '87738.20', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1),
(1678, 1, '2018-12-28', 'TRASPASO A 3851304ILINK  ', '19450.00', '0.00', '68288.20', '0.00', '0.00', '141939.30', NULL, NULL, '2019-01-16 02:14:11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rubro_cuenta`
--

DROP TABLE IF EXISTS `rubro_cuenta`;
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

DROP TABLE IF EXISTS `rubro_persona`;
CREATE TABLE `rubro_persona` (
  `id` int(11) NOT NULL,
  `unique_name` varchar(10) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `color` varchar(10) NOT NULL DEFAULT 'black',
  `color_light` varchar(10) NOT NULL,
  `caracter_unico` varchar(1) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rubro_persona`
--

INSERT INTO `rubro_persona` (`id`, `unique_name`, `nombre`, `color`, `color_light`, `caracter_unico`, `status`) VALUES
(1, 'cta_pow', 'Pow', 'blue', '#99ccff', 'P', 1),
(2, 'cta_matt', 'Matt', 'orange', '#ffdb99', 'M', 1),
(3, 'cta_comun', 'Común', 'black', '#999999', 'C', 1);


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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `movimientos_cuentas`
--
ALTER TABLE `movimientos_cuentas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1679;
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