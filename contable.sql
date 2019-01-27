-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Jan 25, 2019 at 10:17 PM
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
  `parser_asoc` varchar(15) DEFAULT NULL,
  `saldo` decimal(10,2) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cuentas`
--

INSERT INTO `cuentas` (`id`, `nombre`, `moneda`, `parser`, `parser_asoc`, `saldo`, `status`) VALUES
(1, 'Iatú Matt - Caja de Ahorros', 'UYU', 'itau-web', NULL, '46765.96', 1),
(2, 'Iatú Matt - Caja de Ahorros', 'USD', 'itau-web', NULL, '46142.18', 1),
(3, 'Itau Matt - Cuenta Corriente', 'UYU', 'itau-web', NULL, '374817.77', 1),
(4, 'Itau Matt - Cuenta Corriente', 'USD', 'itau-web', NULL, '14264.02', 1),
(6, 'ACSA cta #110499', 'UYU', 'acsa-web', NULL, '-145191.70', 1),
(7, 'Visa', 'UYU', 'visa-itau', '7,8', '0.00', 1),
(8, 'Visa', 'USD', 'visa-itau', '7,8', '0.00', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cuentas_saldos_persona`
--

INSERT INTO `cuentas_saldos_persona` (`id`, `cuenta_id`, `persona_id`, `saldo`) VALUES
(15, 6, 3, '-136591.70'),
(16, 2, 3, '46879.43'),
(17, 1, 3, '64481.97'),
(18, 4, 3, '14264.02'),
(19, 3, 3, '374817.77'),
(20, 1, 2, '-17396.01'),
(21, 1, 1, '-320.00'),
(22, 4, 2, '0.00'),
(23, 4, 1, '0.00'),
(24, 3, 2, '0.00'),
(25, 3, 1, '0.00'),
(26, 2, 2, '-711.90'),
(27, 2, 1, '-25.35'),
(28, 6, 2, '-8600.00'),
(29, 6, 1, '0.00');

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
  `txt_otros` varchar(50) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=155 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `movimientos_cuentas`
--

INSERT INTO `movimientos_cuentas` (`id`, `cuentaId`, `fecha`, `concepto`, `txt_otros`, `debito`, `credito`, `saldo`, `saldo_cta1`, `saldo_cta2`, `saldo_cta3`, `persona_id`, `rubro_id`, `fecha_auto`, `status`) VALUES
(1, 1, '2018-12-03', 'REDIVA 19210BAZAAR', NULL, '0.00', '19.34', '141958.64', '0.00', '0.00', '141958.64', 3, 12, '2019-01-24 01:39:26', 1),
(2, 1, '2018-12-03', 'REDIVA 19210SUPERMANANTI', NULL, '0.00', '32.63', '141991.27', '0.00', '0.00', '141991.27', 3, 12, '2019-01-24 01:39:26', 1),
(3, 1, '2018-12-03', 'REDIVA 19210farmacia bik', NULL, '0.00', '6.95', '141998.22', '0.00', '0.00', '141998.22', 3, 12, '2019-01-24 01:39:26', 1),
(4, 1, '2018-12-03', 'COMPRA BAZAAR  ', NULL, '590.00', '0.00', '141408.22', '0.00', '-590.00', '141998.22', 2, 22, '2019-01-24 01:41:03', 1),
(5, 1, '2018-12-03', 'COMPRA SUPERMANANTI  ', NULL, '995.20', '0.00', '140413.02', '0.00', '-590.00', '141003.02', 3, 7, '2019-01-24 01:41:09', 1),
(6, 1, '2018-12-03', 'COMPRA farmacia bik  ', NULL, '212.00', '0.00', '140201.02', '0.00', '-590.00', '140791.02', 3, 14, '2019-01-24 01:41:13', 1),
(7, 1, '2018-12-03', 'DEB. VARIOS VISA-ILINK', NULL, '50000.00', '0.00', '90201.02', '0.00', '-590.00', '90791.02', 3, 15, '2019-01-24 01:41:22', 1),
(8, 1, '2018-12-04', 'REDIVA 19210ANCAP CARRAS', NULL, '0.00', '4.26', '90205.28', '0.00', '-590.00', '90795.28', 3, 12, '2019-01-24 01:41:22', 1),
(9, 1, '2018-12-04', 'REDIVA 19210FERTILAB', NULL, '0.00', '6.55', '90211.83', '0.00', '-590.00', '90801.83', 3, 12, '2019-01-24 01:41:22', 1),
(10, 1, '2018-12-04', 'REDIVA 19210legroupe', NULL, '0.00', '29.43', '90241.26', '0.00', '-590.00', '90831.26', 3, 12, '2019-01-24 01:41:22', 1),
(11, 1, '2018-12-04', 'COMPRA ANCAP CARRAS  ', NULL, '130.00', '0.00', '90111.26', '0.00', '-720.00', '90831.26', 2, 22, '2019-01-24 01:41:32', 1),
(12, 1, '2018-12-04', 'COMPRA ANCAP CARRAS  ', NULL, '2740.00', '0.00', '87371.26', '0.00', '-3460.00', '90831.26', 2, 16, '2019-01-24 01:41:39', 1),
(13, 1, '2018-12-04', 'COMPRA FERTILAB  ', NULL, '180.00', '0.00', '87191.26', '0.00', '-3460.00', '90651.26', 3, 14, '2019-01-24 01:41:48', 1),
(14, 1, '2018-12-04', 'COMPRA legroupe  ', NULL, '439.00', '0.00', '86752.26', '0.00', '-3899.00', '90651.26', 2, 6, '2019-01-24 01:41:52', 1),
(15, 1, '2018-12-05', 'REDIVA 19210ANTEL 262900', NULL, '0.00', '21.70', '86773.96', '0.00', '-3899.00', '90672.96', 3, 12, '2019-01-24 01:41:52', 1),
(16, 1, '2018-12-05', 'PAGO FACTURAANTEL 262900', NULL, '1506.00', '0.00', '85267.96', '0.00', '-3899.00', '89166.96', 3, 20, '2019-01-24 01:41:58', 1),
(17, 1, '2018-12-05', 'DEB. VARIOS PAGO D.G.I.', NULL, '18903.00', '0.00', '66364.96', '0.00', '-3899.00', '70263.96', 3, 17, '2019-01-24 01:42:04', 1),
(18, 1, '2018-12-06', 'Tali Plástica', NULL, '1200.00', '0.00', '65164.96', '0.00', '-3899.00', '69063.96', 3, 5, '2019-01-24 01:44:13', 1),
(19, 1, '2018-12-07', 'Gastos Comunes Casonas', NULL, '22508.00', '0.00', '42656.96', '0.00', '-3899.00', '46555.96', 3, 20, '2019-01-24 01:45:52', 1),
(20, 1, '2018-12-07', 'COMPRA legroupe  ', NULL, '439.00', '0.00', '42217.96', '0.00', '-4338.00', '46555.96', 2, 6, '2019-01-24 01:45:55', 1),
(21, 1, '2018-12-07', 'REDIVA 19210legroupe', NULL, '0.00', '29.43', '42247.39', '0.00', '-4338.00', '46585.39', 3, 12, '2019-01-24 01:45:55', 1),
(22, 1, '2018-12-10', 'REDIVA 19210DEVOTO EXPRE', NULL, '0.00', '46.45', '42293.84', '0.00', '-4338.00', '46631.84', 3, 12, '2019-01-24 01:45:55', 1),
(23, 1, '2018-12-10', 'COMPRA DEVOTO EXPRE  ', NULL, '1411.09', '0.00', '40882.75', '0.00', '-4338.00', '45220.75', 3, 7, '2019-01-24 01:45:59', 1),
(24, 1, '2018-12-10', 'REDIVA 19210los reyes ma', NULL, '0.00', '65.25', '40948.00', '0.00', '-4338.00', '45286.00', 3, 12, '2019-01-24 01:45:59', 1),
(25, 1, '2018-12-10', 'COMPRA los reyes ma  ', NULL, '1990.00', '0.00', '38958.00', '0.00', '-4338.00', '43296.00', 3, 5, '2019-01-24 01:46:03', 1),
(26, 1, '2018-12-10', 'Colegio Kiwi', NULL, '6840.00', '0.00', '32118.00', '0.00', '-4338.00', '36456.00', 3, 4, '2019-01-24 01:47:44', 1),
(27, 1, '2018-12-10', 'Regalo Bicicleta Sandra  ', NULL, '14950.00', '0.00', '17168.00', '0.00', '-4338.00', '21506.00', 3, 18, '2019-01-24 01:48:20', 1),
(28, 1, '2018-12-11', 'DEP 24 HORAS 008453111', NULL, '0.00', '44849.34', '62017.34', '0.00', '-4338.00', '66355.34', 3, 23, '2019-01-24 01:48:27', 1),
(29, 1, '2018-12-11', 'COMPRA ABITAB807777  ', NULL, '325.23', '0.00', '61692.11', '0.00', '-4338.00', '66030.11', 3, 5, '2019-01-24 01:48:33', 1),
(30, 1, '2018-12-11', 'DEBITO ABITAB807777', NULL, '1.13', '0.00', '61690.98', '0.00', '-4338.00', '66028.98', 3, 5, '2019-01-24 01:48:35', 1),
(31, 1, '2018-12-12', 'Popurrí', NULL, '16900.00', '0.00', '44790.98', '0.00', '-4338.00', '49128.98', 3, 8, '2019-01-24 01:49:01', 1),
(32, 1, '2018-12-13', 'TRASPASO DE 8529099', NULL, '0.00', '18618.47', '63409.45', '0.00', '-4338.00', '67747.45', 3, 23, '2019-01-24 01:49:11', 1),
(33, 1, '2018-12-13', 'DEB. VARIOS VISA', NULL, '63409.45', '0.00', '0.00', '0.00', '-4338.00', '4338.00', 3, 15, '2019-01-24 01:49:18', 1),
(34, 1, '2018-12-14', 'TRASPASO DE 8320010ILINK', NULL, '0.00', '150000.00', '150000.00', '0.00', '-4338.00', '154338.00', 3, 25, '2019-01-24 01:50:26', 1),
(35, 1, '2018-12-14', 'TRASPASO A 3851304ILINK  ', NULL, '12411.00', '0.00', '137589.00', '0.00', '-4338.00', '141927.00', 3, 11, '2019-01-24 01:51:20', 1),
(36, 1, '2018-12-14', 'TRASPASO A 9693040ILINK  ', NULL, '856.00', '0.00', '136733.00', '0.00', '-4338.00', '141071.00', 3, 11, '2019-01-24 01:51:34', 1),
(37, 1, '2018-12-14', 'TRASPASO A 8245270ILINK  ', NULL, '460.00', '0.00', '136273.00', '0.00', '-4798.00', '141071.00', 2, 6, '2019-01-24 01:51:50', 1),
(38, 1, '2018-12-14', 'REDIVA 19210MC DONALDS', NULL, '0.00', '18.74', '136291.74', '0.00', '-4798.00', '141089.74', 3, 12, '2019-01-24 01:51:50', 1),
(39, 1, '2018-12-14', 'REDIVA 19210estilo roma', NULL, '0.00', '12.79', '136304.53', '0.00', '-4798.00', '141102.53', 3, 12, '2019-01-24 01:51:50', 1),
(40, 1, '2018-12-14', 'REDIVA 19210CINE MOVIE', NULL, '0.00', '6.39', '136310.92', '0.00', '-4798.00', '141108.92', 3, 12, '2019-01-24 01:51:50', 1),
(41, 1, '2018-12-14', 'COMPRA MC DONALDS  ', NULL, '254.00', '0.00', '136056.92', '0.00', '-5052.00', '141108.92', 2, 6, '2019-01-24 01:51:53', 1),
(42, 1, '2018-12-14', 'COMPRA estilo roma  ', NULL, '390.00', '0.00', '135666.92', '0.00', '-5052.00', '140718.92', 3, 5, '2019-01-24 01:52:07', 1),
(43, 1, '2018-12-14', 'COMPRA CINE MOVIE  ', NULL, '195.00', '0.00', '135471.92', '0.00', '-5052.00', '140523.92', 3, 5, '2019-01-24 01:52:13', 1),
(44, 1, '2018-12-17', 'REDIVA 19210KINKO', NULL, '0.00', '8.69', '135480.61', '0.00', '-5052.00', '140532.61', 3, 12, '2019-01-24 01:52:13', 1),
(45, 1, '2018-12-17', 'REDIVA 19210ser animal', NULL, '0.00', '9.51', '135490.12', '0.00', '-5052.00', '140542.12', 3, 12, '2019-01-24 01:52:13', 1),
(46, 1, '2018-12-17', 'REDIVA 19210DEVOTO EXPRE', NULL, '0.00', '46.22', '135536.34', '0.00', '-5052.00', '140588.34', 3, 12, '2019-01-24 01:52:13', 1),
(47, 1, '2018-12-17', 'COMPRA ser animal  ', NULL, '290.00', '0.00', '135246.34', '0.00', '-5342.00', '140588.34', 2, 22, '2019-01-24 01:52:47', 1),
(48, 1, '2018-12-17', 'COMPRA DEVOTO EXPRE  ', NULL, '1397.48', '0.00', '133848.86', '0.00', '-5342.00', '139190.86', 3, 7, '2019-01-24 01:52:52', 1),
(49, 1, '2018-12-17', 'COMPRA KINKO  ', NULL, '265.00', '0.00', '133583.86', '0.00', '-5342.00', '138925.86', 3, 7, '2019-01-24 01:52:55', 1),
(50, 1, '2018-12-17', 'REDIVA 19210MC DONALDS', NULL, '0.00', '18.74', '133602.60', '0.00', '-5342.00', '138944.60', 3, 12, '2019-01-24 01:52:55', 1),
(51, 1, '2018-12-17', 'REDIVA 19210DEVOTO SUPER', NULL, '0.00', '16.82', '133619.42', '0.00', '-5342.00', '138961.42', 3, 12, '2019-01-24 01:52:55', 1),
(52, 1, '2018-12-17', 'COMPRA MC DONALDS  ', NULL, '368.00', '0.00', '133251.42', '0.00', '-5710.00', '138961.42', 2, 6, '2019-01-24 01:52:58', 1),
(53, 1, '2018-12-17', 'COMPRA MC DONALDS  ', NULL, '254.00', '0.00', '132997.42', '0.00', '-5964.00', '138961.42', 2, 6, '2019-01-24 01:53:01', 1),
(54, 1, '2018-12-17', 'COMPRA DEVOTO SUPER  ', NULL, '512.97', '0.00', '132484.45', '0.00', '-5964.00', '138448.45', 3, 7, '2019-01-24 01:53:04', 1),
(55, 1, '2018-12-17', 'REDIVA 19210MC DONALDS', NULL, '0.00', '27.15', '132511.60', '0.00', '-5964.00', '138475.60', 3, 12, '2019-01-24 01:53:04', 1),
(56, 1, '2018-12-18', 'REDIVA 19210KINKO', NULL, '0.00', '14.93', '132526.53', '0.00', '-5964.00', '138490.53', 3, 12, '2019-01-24 01:53:04', 1),
(57, 1, '2018-12-18', 'REDIVA 19210BURGER KING', NULL, '0.00', '19.84', '132546.37', '0.00', '-5964.00', '138510.37', 3, 12, '2019-01-24 01:53:04', 1),
(58, 1, '2018-12-18', 'COMPRA KINKO  ', NULL, '451.28', '0.00', '132095.09', '0.00', '-5964.00', '138059.09', 3, 7, '2019-01-24 01:53:08', 1),
(59, 1, '2018-12-18', 'COMPRA BURGER KING  ', NULL, '269.00', '0.00', '131826.09', '0.00', '-6233.00', '138059.09', 2, 6, '2019-01-24 01:53:11', 1),
(60, 1, '2018-12-18', 'COMPRA ART COMPUTER  ', NULL, '1650.00', '0.00', '130176.09', '0.00', '-7883.00', '138059.09', 2, 22, '2019-01-24 01:53:15', 1),
(61, 1, '2018-12-19', 'REDIVA 19210UTE 795716', NULL, '0.00', '70.25', '130246.34', '0.00', '-7883.00', '138129.34', 3, 12, '2019-01-24 01:53:15', 1),
(62, 1, '2018-12-19', 'PAGO FACTURAUTE 795716', NULL, '4285.00', '0.00', '125961.34', '0.00', '-7883.00', '133844.34', 3, 20, '2019-01-24 01:53:19', 1),
(63, 1, '2018-12-19', 'REDIVA 19210entreacto', NULL, '0.00', '69.34', '126030.68', '0.00', '-7883.00', '133913.68', 3, 12, '2019-01-24 01:53:19', 1),
(64, 1, '2018-12-19', 'COMPRA entreacto  ', NULL, '1034.00', '0.00', '124996.68', '0.00', '-8917.00', '133913.68', 2, 6, '2019-01-24 01:53:40', 1),
(65, 1, '2018-12-21', 'COMPRA chelato  ', NULL, '240.00', '0.00', '124756.68', '0.00', '-9157.00', '133913.68', 2, 22, '2019-01-24 01:53:46', 1),
(66, 1, '2018-12-21', 'REDIVA 19210chelato', NULL, '0.00', '7.87', '124764.55', '0.00', '-9157.00', '133921.55', 3, 12, '2019-01-24 01:53:46', 1),
(67, 1, '2018-12-21', 'PAGO FACTURABPS', NULL, '13790.00', '0.00', '110974.55', '0.00', '-9157.00', '120131.55', 3, 10, '2019-01-24 01:53:50', 1),
(68, 1, '2018-12-24', 'COMPRA HELADERIA FR  ', NULL, '1200.00', '0.00', '109774.55', '0.00', '-9157.00', '118931.55', 3, 7, '2019-01-24 01:53:58', 1),
(69, 1, '2018-12-24', 'REDIVA 19210TIENDA INGLE', NULL, '0.00', '79.61', '109854.16', '0.00', '-9157.00', '119011.16', 3, 12, '2019-01-24 01:53:58', 1),
(70, 1, '2018-12-24', 'REDIVA 19210GOURMEAT BOU', NULL, '0.00', '121.79', '109975.95', '0.00', '-9157.00', '119132.95', 3, 12, '2019-01-24 01:53:58', 1),
(71, 1, '2018-12-24', 'COMPRA TIENDA INGLE  ', NULL, '2348.00', '0.00', '107627.95', '0.00', '-9157.00', '116784.95', 3, 7, '2019-01-24 01:54:04', 1),
(72, 1, '2018-12-24', 'COMPRA GOURMEAT BOU  ', NULL, '3402.92', '0.00', '104225.03', '0.00', '-9157.00', '113382.03', 3, 7, '2019-01-24 01:54:13', 1),
(73, 1, '2018-12-24', 'REDIVA 19210DEVOTO EXPRE', NULL, '0.00', '14.35', '104239.38', '0.00', '-9157.00', '113396.38', 3, 12, '2019-01-24 01:54:13', 1),
(74, 1, '2018-12-24', 'REDIVA 19210SODIMAC', NULL, '0.00', '39.32', '104278.70', '0.00', '-9157.00', '113435.70', 3, 12, '2019-01-24 01:54:13', 1),
(75, 1, '2018-12-24', 'COMPRA SODIMAC  ', NULL, '598.00', '0.00', '103680.70', '0.00', '-9755.00', '113435.70', 2, 21, '2019-01-24 01:54:16', 1),
(76, 1, '2018-12-24', 'COMPRA SODIMAC  ', NULL, '1199.00', '0.00', '102481.70', '0.00', '-10954.00', '113435.70', 2, 21, '2019-01-24 01:54:39', 1),
(77, 1, '2018-12-24', 'COMPRA SODIMAC  ', NULL, '179.00', '0.00', '102302.70', '0.00', '-11133.00', '113435.70', 2, 21, '2019-01-24 01:54:42', 1),
(78, 1, '2018-12-24', 'COMPRA DEVOTO EXPRE  ', NULL, '437.70', '0.00', '101865.00', '0.00', '-11133.00', '112998.00', 3, 7, '2019-01-24 01:54:45', 1),
(79, 1, '2018-12-24', 'REDIVA 19210HELADERIA FR', NULL, '0.00', '39.34', '101904.34', '0.00', '-11133.00', '113037.34', 3, 12, '2019-01-24 01:54:45', 1),
(80, 1, '2018-12-26', 'COMPRA FRUTAS Y VER  ', NULL, '296.00', '0.00', '101608.34', '0.00', '-11133.00', '112741.34', 3, 7, '2019-01-24 01:54:50', 1),
(81, 1, '2018-12-26', 'REDIVA 19210FRUTAS Y VER', NULL, '0.00', '9.70', '101618.04', '0.00', '-11133.00', '112751.04', 3, 12, '2019-01-24 01:54:50', 1),
(82, 1, '2018-12-26', 'Liquidación Final Pamela Dominguez', NULL, '8173.00', '0.00', '93445.04', '0.00', '-11133.00', '104578.04', 3, 11, '2019-01-24 01:55:25', 1),
(83, 1, '2018-12-26', 'PAGO FACTURAIMMT05085591', NULL, '382.00', '0.00', '93063.04', '0.00', '-11133.00', '104196.04', 3, 20, '2019-01-24 01:55:30', 1),
(84, 1, '2018-12-27', 'REDIVA 19210MVGAS 138601', NULL, '0.00', '28.85', '93091.89', '0.00', '-11133.00', '104224.89', 3, 12, '2019-01-24 01:55:30', 1),
(85, 1, '2018-12-27', 'PAGO FACTURAMVGAS 138601', NULL, '1813.00', '0.00', '91278.89', '0.00', '-11133.00', '102411.89', 3, 20, '2019-01-24 01:55:33', 1),
(86, 1, '2018-12-27', 'TRASPASO DE 3249071MTPAY  ', NULL, '0.00', '48445.50', '139724.39', '0.00', '-11133.00', '150857.39', 3, 23, '2019-01-24 01:55:39', 1),
(87, 1, '2018-12-27', 'REDIVA 19210DEVOTO EXPRE', NULL, '0.00', '13.12', '139737.51', '0.00', '-11133.00', '150870.51', 3, 12, '2019-01-24 01:55:39', 1),
(88, 1, '2018-12-27', 'COMPRA ESSO LA COS  ', NULL, '3050.00', '0.00', '136687.51', '0.00', '-14183.00', '150870.51', 2, 16, '2019-01-24 01:55:52', 1),
(89, 1, '2018-12-27', 'COMPRA DEVOTO EXPRE  ', NULL, '449.31', '0.00', '136238.20', '0.00', '-14183.00', '150421.20', 3, 7, '2019-01-24 01:55:55', 1),
(90, 1, '2018-12-28', 'TRASPASO A 5979609ILINK  ', NULL, '48500.00', '0.00', '87738.20', '0.00', '-14183.00', '101921.20', 3, 28, '2019-01-24 02:08:38', 1),
(91, 1, '2018-12-28', 'Sueldo Sandra', NULL, '19450.00', '0.00', '68288.20', '0.00', '-14183.00', '82471.20', 3, 11, '2019-01-24 02:08:38', 1),
(92, 1, '2019-01-02', 'REDIVA 19210ANCAP JIGAMA', NULL, '0.00', '10.49', '68298.69', '0.00', '-14183.00', '82481.69', 3, 12, '2019-01-24 02:08:38', 1),
(93, 1, '2019-01-02', 'COMPRA ANCAP JIGAMA  ', NULL, '320.00', '0.00', '67978.69', '-320.00', '-14183.00', '82481.69', 1, 13, '2019-01-24 02:08:38', 1),
(94, 1, '2019-01-02', 'COMPRA ANCAP JIGAMA  ', NULL, '2050.00', '0.00', '65928.69', '-320.00', '-16233.00', '82481.69', 2, 16, '2019-01-24 02:08:38', 1),
(95, 1, '2019-01-02', 'COMPRA MC DONALDS  ', NULL, '796.00', '0.00', '65132.69', '-320.00', '-16233.00', '81685.69', 3, 27, '2019-01-24 02:08:38', 1),
(96, 1, '2019-01-02', 'REDIVA 19210MC DONALDS', NULL, '0.00', '58.72', '65191.41', '-320.00', '-16233.00', '81744.41', 3, 12, '2019-01-24 02:08:38', 1),
(97, 1, '2019-01-03', 'Sandra Machado', NULL, '0.00', '128.00', '65319.41', '-320.00', '-16233.00', '81872.41', 3, 7, '2019-01-24 02:08:38', 1),
(98, 1, '2019-01-04', 'Renta Costa Rica', NULL, '0.00', '21772.00', '87091.41', '-320.00', '-16233.00', '103644.41', 3, 23, '2019-01-24 02:08:38', 1),
(99, 1, '2019-01-07', 'REDIVA 19210ANTEL 262900', NULL, '0.00', '22.22', '87113.63', '-320.00', '-16233.00', '103666.63', 3, 12, '2019-01-24 02:08:38', 1),
(100, 1, '2019-01-07', 'PAGO FACTURAANTEL 262900', NULL, '1538.00', '0.00', '85575.63', '-320.00', '-16233.00', '102128.63', 3, 20, '2019-01-24 02:08:38', 1),
(101, 1, '2019-01-07', 'REDIVA 19210chelato', NULL, '0.00', '7.87', '85583.50', '-320.00', '-16233.00', '102136.50', 3, 12, '2019-01-24 02:08:38', 1),
(102, 1, '2019-01-07', 'COMPRA chelato  ', NULL, '240.00', '0.00', '85343.50', '-320.00', '-16473.00', '102136.50', 2, 6, '2019-01-24 02:08:38', 1),
(103, 1, '2019-01-10', 'REDIVA 19210KROSER', NULL, '0.00', '30.26', '85373.76', '-320.00', '-16473.00', '102166.76', 3, 12, '2019-01-24 02:08:38', 1),
(104, 1, '2019-01-10', 'COMPRA KROSER  ', NULL, '923.01', '0.00', '84450.75', '-320.00', '-17396.01', '102166.76', 2, 21, '2019-01-24 02:08:38', 1),
(105, 1, '2019-01-11', 'DEP 24 HORAS 008660732', NULL, '0.00', '64258.31', '148709.06', '-320.00', '-17396.01', '166425.07', 3, 23, '2019-01-24 02:08:38', 1),
(106, 1, '2019-01-11', 'REDIVA 19210ANCAP JIGAMA', NULL, '0.00', '18.49', '148727.55', '-320.00', '-17396.01', '166443.56', 3, 12, '2019-01-24 02:08:38', 1),
(107, 1, '2019-01-11', 'COMPRA ANCAP JIGAMA  ', NULL, '564.00', '0.00', '148163.55', '-320.00', '-17396.01', '165879.56', 3, 18, '2019-01-24 02:08:38', 1),
(108, 1, '2019-01-14', 'COMPRA PETROBRAS PA  ', NULL, '2850.30', '0.00', '145313.25', '-320.00', '-17396.01', '163029.26', 3, 18, '2019-01-24 02:08:38', 1),
(109, 1, '2019-01-14', 'REDIVA 19210DEVOTO EXPRE', NULL, '0.00', '15.54', '145328.79', '-320.00', '-17396.01', '163044.80', 3, 12, '2019-01-24 02:08:38', 1),
(110, 1, '2019-01-14', 'COMPRA DEVOTO EXPRE  ', NULL, '474.00', '0.00', '144854.79', '-320.00', '-17396.01', '162570.80', 3, 7, '2019-01-24 02:08:38', 1),
(111, 1, '2019-01-15', 'Colegio Kiwi', NULL, '5700.00', '0.00', '139154.79', '-320.00', '-17396.01', '156870.80', 3, 4, '2019-01-24 02:08:38', 1),
(112, 1, '2019-01-15', 'DEB. VARIOS VISA', NULL, '55332.84', '0.00', '83821.95', '-320.00', '-17396.01', '101537.96', 3, 15, '2019-01-24 02:08:38', 1),
(113, 1, '2019-01-16', 'REDIVA 19210UTE 795716', NULL, '0.00', '36.56', '83858.51', '-320.00', '-17396.01', '101574.52', 3, 12, '2019-01-24 02:08:38', 1),
(114, 1, '2019-01-16', 'PAGO FACTURAUTE 795716', NULL, '2476.00', '0.00', '81382.51', '-320.00', '-17396.01', '99098.52', 3, 20, '2019-01-24 02:08:38', 1),
(115, 1, '2019-01-17', 'Popurrí', NULL, '15365.00', '0.00', '66017.51', '-320.00', '-17396.01', '83733.52', 3, 8, '2019-01-24 02:08:38', 1),
(116, 1, '2019-01-17', 'REDIVA 19210KINKO', NULL, '0.00', '22.43', '66039.94', '-320.00', '-17396.01', '83755.95', 3, 12, '2019-01-24 02:08:38', 1),
(117, 1, '2019-01-17', 'COMPRA KINKO  ', NULL, '684.00', '0.00', '65355.94', '-320.00', '-17396.01', '83071.95', 3, 7, '2019-01-24 02:08:38', 1),
(118, 1, '2019-01-18', 'REDIVA 19210MC DONALDS', NULL, '0.00', '63.89', '65419.83', '-320.00', '-17396.01', '83135.84', 3, 12, '2019-01-24 02:08:38', 1),
(119, 1, '2019-01-18', 'COMPRA MC DONALDS  ', NULL, '866.00', '0.00', '64553.83', '-320.00', '-17396.01', '82269.84', 3, 27, '2019-01-24 02:08:38', 1),
(120, 1, '2019-01-21', 'COMPRA SUPERMANANTI  ', NULL, '290.00', '0.00', '64263.83', '-320.00', '-17396.01', '81979.84', 3, 7, '2019-01-24 02:08:38', 1),
(121, 1, '2019-01-21', 'REDIVA 19210SUPERMANANTI', NULL, '0.00', '9.51', '64273.34', '-320.00', '-17396.01', '81989.35', 3, 12, '2019-01-24 02:08:38', 1),
(122, 1, '2019-01-22', 'REDIVA 19210DEVOTO EXPRE', NULL, '0.00', '4.62', '64277.96', '-320.00', '-17396.01', '81993.97', 3, 12, '2019-01-24 02:08:38', 1),
(123, 1, '2019-01-22', 'COMPRA DEVOTO EXPRE  ', NULL, '141.00', '0.00', '64136.96', '-320.00', '-17396.01', '81852.97', 3, 7, '2019-01-24 02:08:38', 1),
(124, 1, '2019-01-22', 'PAGO FACTURABPS', NULL, '17371.00', '0.00', '46765.96', '-320.00', '-17396.01', '64481.97', 3, 10, '2019-01-24 02:08:38', 1),
(125, 4, '2018-12-26', 'TRASPASO A 8415356ILINK  ', NULL, '938.68', '0.00', '14269.59', '0.00', '0.00', '14269.59', 3, 29, '2019-01-24 02:55:33', 1),
(126, 4, '2018-12-26', 'TRASPASO A 8415356ILINK  ', NULL, '5.57', '0.00', '14264.02', '0.00', '0.00', '14264.02', 3, 29, '2019-01-24 02:55:38', 1),
(127, 3, '2018-12-14', 'TRASPASO A 9561750ILINK', NULL, '150000.00', '0.00', '49575.29', '0.00', '0.00', '49575.29', 3, 25, '2019-01-24 02:57:33', 1),
(128, 3, '2018-12-17', 'TRASPASO DE 3249071MTPAY  ', NULL, '0.00', '293395.22', '342970.51', '0.00', '0.00', '342970.51', 3, 28, '2019-01-24 02:57:48', 1),
(129, 3, '2018-12-18', 'CHEQUE 60452436', NULL, '300000.00', '0.00', '42970.51', '0.00', '0.00', '42970.51', 3, 25, '2019-01-24 02:57:57', 1),
(130, 3, '2019-01-23', 'DEB. VARIOS VISA-ILINK', NULL, '40000.00', '0.00', '2970.51', '0.00', '0.00', '2970.51', 3, 15, '2019-01-24 02:58:01', 1),
(131, 3, '2019-01-23', 'TRASPASO DE 3249071MTPAY  ', NULL, '0.00', '371847.26', '374817.77', '0.00', '0.00', '374817.77', 3, 28, '2019-01-24 02:58:08', 1),
(132, 2, '2018-12-03', 'CRED.DIRECTO10% ITAU', NULL, '0.00', '0.67', '48991.90', '0.00', '0.00', '48991.90', 3, 30, '2019-01-24 03:00:04', 1),
(133, 2, '2018-12-04', 'DEB. CAMBIOSST....604725', NULL, '25.35', '0.00', '48966.55', '-25.35', '0.00', '48991.90', 1, 13, '2019-01-24 03:00:43', 1),
(134, 2, '2018-12-07', 'DEP 24 HORAS 008430021', NULL, '0.00', '551.00', '49517.55', '-25.35', '0.00', '49542.90', 3, 29, '2019-01-24 03:00:58', 1),
(135, 2, '2018-12-13', 'Pago Contador Caro Ordoñez', NULL, '590.12', '0.00', '48927.43', '-25.35', '0.00', '48952.78', 3, 31, '2019-01-24 03:02:57', 1),
(136, 2, '2018-12-13', 'DEB. VARIOS VISA', NULL, '2022.20', '0.00', '46905.23', '-25.35', '0.00', '46930.58', 3, 15, '2019-01-24 03:03:11', 1),
(137, 2, '2018-12-14', 'DEBITO BANKING CARD', NULL, '20.00', '0.00', '46885.23', '-25.35', '0.00', '46910.58', 3, 30, '2019-01-24 03:03:19', 1),
(138, 2, '2018-12-14', 'DEBITO BANKING CARD', NULL, '20.00', '0.00', '46865.23', '-25.35', '0.00', '46890.58', 3, 30, '2019-01-24 03:03:22', 1),
(139, 2, '2018-12-14', 'DEBITO BANKING CARD', NULL, '12.00', '0.00', '46853.23', '-25.35', '0.00', '46878.58', 3, 30, '2019-01-24 03:03:26', 1),
(140, 2, '2018-12-21', 'DEB. CAMBIOSST....770791', NULL, '710.00', '0.00', '46143.23', '-25.35', '-710.00', '46878.58', 2, 22, '2019-01-24 03:04:39', 1),
(141, 2, '2018-12-21', 'DEB. CAMBIOSST....770791', NULL, '1.90', '0.00', '46141.33', '-25.35', '-711.90', '46878.58', 2, 22, '2019-01-24 03:04:45', 1),
(142, 2, '2018-12-28', 'CREDITO INTERESES', NULL, '0.00', '0.97', '46142.30', '-25.35', '-711.90', '46879.55', 3, 30, '2019-01-24 03:04:50', 1),
(143, 2, '2018-12-28', 'RETENCION IRPF', NULL, '0.12', '0.00', '46142.18', '-25.35', '-711.90', '46879.43', 3, 30, '2019-01-24 03:04:54', 1),
(144, 6, '2019-01-08', 'GASTOS COMUNES ACSA', NULL, '4451.00', '0.00', '-87909.66', '0.00', '0.00', '-87909.66', 3, 24, '2019-01-24 03:08:14', 1),
(145, 6, '2019-01-08', 'GASTOS COMUNES ACSA', NULL, '445.00', '0.00', '-88354.66', '0.00', '0.00', '-88354.66', 3, 24, '2019-01-24 03:08:18', 1),
(146, 6, '2019-01-11', 'Reintegro - Tasa General IM 11 - 12/2018', NULL, '0.00', '948.00', '-87406.66', '0.00', '0.00', '-87406.66', 3, 24, '2019-01-24 03:08:22', 1),
(147, 6, '2019-01-11', 'Reintegro - Gastos comunes 12/18', NULL, '0.00', '4451.00', '-82955.66', '0.00', '0.00', '-82955.66', 3, 24, '2019-01-24 03:08:26', 1),
(148, 6, '2019-01-11', 'Renta Alquiler Mes 12/2018', NULL, '0.00', '23770.39', '-59185.27', '0.00', '0.00', '-59185.27', 3, 24, '2019-01-24 03:08:28', 1),
(149, 6, '2019-01-11', 'Comision Alquiler', NULL, '2.38', '0.00', '-59187.65', '0.00', '0.00', '-59187.65', 3, 24, '2019-01-24 03:08:31', 1),
(150, 6, '2019-01-11', 'IVA - Comision Alquiler', NULL, '0.52', '0.00', '-59188.17', '0.00', '0.00', '-59188.17', 3, 24, '2019-01-24 03:08:40', 1),
(151, 6, '2019-01-11', 'IRPF retenido por ACSA', NULL, '1497.53', '0.00', '-60685.70', '0.00', '0.00', '-60685.70', 3, 24, '2019-01-24 03:08:43', 1),
(152, 6, '2019-01-16', 'Retiro por caja PAGO BPS JMCAMPOMAR', NULL, '7022.00', '0.00', '-67707.70', '0.00', '0.00', '-67707.70', 3, 10, '2019-01-24 03:08:52', 1),
(153, 6, '2019-01-16', 'Retiro por caja CH 933911 PAGO DGI', NULL, '68884.00', '0.00', '-136591.70', '0.00', '0.00', '-136591.70', 3, 17, '2019-01-24 03:08:56', 1),
(154, 6, '2019-01-22', 'Retiro por caja RETIRO EFECTIVO CLUB Y OTROS', NULL, '8600.00', '0.00', '-145191.70', '0.00', '-8600.00', '-136591.70', 2, 22, '2019-01-24 03:09:30', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

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
(23, 'San Quintín', 3, 1),
(24, 'Apto 801', 3, 1),
(25, 'Transferencias', 3, 1),
(26, 'Nafta', 1, 1),
(27, 'Comidas', 3, 1),
(28, 'Cobros', 3, 1),
(29, 'Blue Cross', 3, 1),
(30, 'Gastos Bancos', 3, 1),
(31, 'Honorarios Ascesores', 3, 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `movimientos_cuentas`
--
ALTER TABLE `movimientos_cuentas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=155;
--
-- AUTO_INCREMENT for table `rubro_cuenta`
--
ALTER TABLE `rubro_cuenta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `rubro_persona`
--
ALTER TABLE `rubro_persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;