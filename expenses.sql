-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 06, 2024 at 06:43 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tinkerpro`
--

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
CREATE TABLE IF NOT EXISTS `expenses` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) NOT NULL,
  `date_of_transaction` date NOT NULL,
  `billable_receipt_no` varchar(255) DEFAULT NULL,
  `expense_type` varchar(255) NOT NULL,
  `quantity` int NOT NULL DEFAULT '0',
  `supplier` bigint NOT NULL,
  `invoice_number` varchar(255) NOT NULL DEFAULT '0',
  `price` decimal(20,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(20,2) NOT NULL DEFAULT '0.00',
  `total_amount` decimal(20,2) NOT NULL DEFAULT '0.00',
  `description` longtext,
  `invoice_photo_url` varchar(455) DEFAULT NULL,
  `uom_id` int DEFAULT '0',
  `product_id` bigint NOT NULL DEFAULT '0',
  `taxable_amount` decimal(20,2) DEFAULT '0.00',
  `isTaxable` tinyint DEFAULT '0',
  `landingCost` text,
  `isLandingCostEnabled` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `item_name`, `date_of_transaction`, `billable_receipt_no`, `expense_type`, `quantity`, `supplier`, `invoice_number`, `price`, `discount`, `total_amount`, `description`, `invoice_photo_url`, `uom_id`, `product_id`, `taxable_amount`, `isTaxable`, `landingCost`, `isLandingCostEnabled`) VALUES
(5, '', '2024-06-26', NULL, 'PURCHASED ORDER', 50, 11, '10-000000006', 50.00, 0.00, 2500.00, NULL, NULL, NULL, 1, 0.00, 0, NULL, 1),
(4, '', '2024-06-26', NULL, 'PURCHASED ORDER', 900, 11, '10-000000003', 50.00, 0.00, 45000.00, NULL, NULL, NULL, 1, 0.00, 0, NULL, 1),
(3, '', '2024-06-26', NULL, 'PURCHASED ORDER', 60, 11, '10-000000001', 50.00, 0.00, 3000.00, NULL, NULL, NULL, 1, 0.00, 0, NULL, 0),
(6, '', '2024-06-26', NULL, 'PURCHASED ORDER', 25, 14, '10-000000007', 50.00, 0.00, 1250.00, NULL, NULL, NULL, 1, 0.00, 0, NULL, 0),
(7, '', '2024-06-26', NULL, 'PURCHASED ORDER', 25, 12, '10-000000008', 50.00, 0.00, 1250.00, NULL, NULL, NULL, 1, 0.00, 0, '{\"freightCharges\":\"250\",\"insuranceFees\":\"250\",\"importDuties\":\"0\",\"customsFees\":\"0\",\"vat\":\"0\",\"customBrokerFees\":\"0\",\"portHandlingFees\":\"0\",\"storageFees\":\"0\",\"inlandTransport\":\"0\",\"documentationFees\":\"0\",\"inspectionFees\":\"0\",\"bankFees\":\"0\",\"currencyConversionFees\":\"0\",\"others\":\"0\",\"totalLandingCost\":\"500.00\",\"totalLandingCostPerPiece\":\"20.00\"}', 1),
(8, '', '2024-06-26', NULL, 'PURCHASED ORDER', 960, 13, '10-000000009', 50.00, 0.00, 48000.00, NULL, NULL, NULL, 1, 0.00, 0, NULL, 1),
(9, '', '2024-06-26', NULL, 'PURCHASED ORDER', 25, 12, '10-000000010', 50.00, 0.00, 1250.00, NULL, NULL, NULL, 1, 0.00, 0, NULL, 0),
(10, '', '2024-06-26', NULL, 'PURCHASED ORDER', 25, 11, '10-000000011', 50.00, 0.00, 1250.00, NULL, NULL, NULL, 1, 0.00, 0, NULL, 0),
(11, '', '2024-06-26', NULL, 'PURCHASED ORDER', 25, 14, '10-000000012', 50.00, 0.00, 1250.00, NULL, NULL, NULL, 1, 0.00, 0, '{\"freightCharges\":\"250\",\"insuranceFees\":\"100\",\"importDuties\":\"32.36\",\"customsFees\":\"2500\",\"vat\":\"100\",\"customBrokerFees\":\"200\",\"portHandlingFees\":\"125\",\"storageFees\":\"20\",\"inlandTransport\":\"125\",\"documentationFees\":\"0\",\"inspectionFees\":\"0\",\"bankFees\":\"0\",\"currencyConversionFees\":\"0\",\"others\":\"0\",\"totalLandingCost\":\"3452.36\",\"totalLandingCostPerPiece\":\"138.09\"}', 1),
(12, '', '2024-06-26', NULL, 'PURCHASED ORDER', 25, 11, '10-000000014', 50.00, 0.00, 1250.00, NULL, NULL, NULL, 1, 0.00, 0, NULL, 0),
(13, '', '2024-06-26', NULL, 'PURCHASED ORDER', 25, 12, '10-000000015', 50.00, 0.00, 1250.00, NULL, NULL, NULL, 1, 0.00, 0, '{\"freightCharges\":\"0\",\"insuranceFees\":\"0\",\"importDuties\":\"250\",\"customsFees\":\"100\",\"vat\":\"325.23\",\"customBrokerFees\":\"0\",\"portHandlingFees\":\"0\",\"storageFees\":\"0\",\"inlandTransport\":\"0\",\"documentationFees\":\"0\",\"inspectionFees\":\"0\",\"bankFees\":\"0\",\"currencyConversionFees\":\"0\",\"others\":\"0\",\"totalLandingCost\":\"675.23\",\"totalLandingCostPerPiece\":\"27.01\"}', 1),
(14, '', '2024-06-26', NULL, 'PURCHASED ORDER', 25, 19, '10-000000017', 6500000.00, 0.00, 162500000.00, NULL, NULL, 1, 2, 0.00, 0, NULL, 0),
(15, '', '2024-06-26', NULL, 'PURCHASED ORDER', 56, 12, '10-000000001', 20.00, 0.00, 1120.00, NULL, NULL, 4, 1, 0.00, 0, NULL, 0),
(16, 'SWELDO SA TRABANTE', '2024-06-27', '', 'Salaries and Wages', 20, 0, 'KKK', 96000.00, 26.00, 1919974.00, '', NULL, 0, 0, 0.00, 0, NULL, 0),
(17, 'asdfas', '2024-06-28', '43', 'Inventory', 3, 0, 'SSS3', 34.00, 4.00, 98.00, '', NULL, 0, 0, 0.00, 0, NULL, 0),
(18, 'MOUSE', '2024-06-28', '343', 'Inventory', 34, 14, '900', 334.00, 3.00, 11353.00, '', NULL, 0, 0, 0.00, 0, NULL, 0),
(19, '', '2024-06-28', NULL, 'LOSS AND DAMAGE', -20, 0, '50-000000006', 20.00, 0.00, -400.00, NULL, NULL, 4, 1, 0.00, 0, NULL, 0),
(20, '', '2024-06-29', NULL, 'LOSS AND DAMAGE', -6, 0, '50-000000007', 20.00, 0.00, 120.00, NULL, NULL, 4, 1, 0.00, 0, NULL, 0),
(21, 'CALCULATOR', '2024-06-29', '', 'Inventory', 20, 11, '25', 300.00, 25.00, 5975.00, '', NULL, 0, 0, 6615.18, 1, NULL, 0),
(22, '', '2024-06-29', NULL, 'LOSS AND DAMAGE', -50, 0, '50-000000008', 20.00, 0.00, 1000.00, NULL, NULL, 4, 1, 0.00, 0, NULL, 0),
(23, '', '2024-07-01', NULL, 'PURCHASED ORDER', 20, 11, '10-000000105', 22.25, 0.00, 445.00, NULL, NULL, 11, 911, 0.00, 0, NULL, 0),
(24, '', '2024-07-18', NULL, 'PURCHASED ORDER', 32, 11, '10-000000001', 10.80, 0.00, 345.60, NULL, NULL, 11, 33, 0.00, 0, NULL, 0),
(25, '', '2024-07-18', NULL, 'PURCHASED ORDER', 98, 11, '10-000000001', 32.00, 0.00, 3136.00, NULL, NULL, 4, 110, 0.00, 0, NULL, 0),
(26, '', '2024-07-18', NULL, 'LOSS AND DAMAGE', -25, 0, '50-000000001', 9.50, 0.00, 237.50, NULL, NULL, 20, 29, 0.00, 0, NULL, 0),
(27, '', '2024-07-19', NULL, 'PURCHASED ORDER', 32, 11, '10-000000002', 40.80, 0.00, 1305.60, NULL, NULL, 30, 3766, 0.00, 0, NULL, 0),
(28, '', '2024-07-19', NULL, 'PURCHASED ORDER', 98, 11, '10-000000002', 56.09, 0.00, 5496.82, NULL, NULL, 16, 30, 0.00, 0, NULL, 0),
(29, '', '2024-07-20', NULL, 'PURCHASED ORDER', 36, 11, '10-000000003', 14.00, 0.00, 504.00, NULL, NULL, 23, 4, 0.00, 0, NULL, 0),
(30, '', '2024-07-20', NULL, 'LOSS AND DAMAGE', -25, 0, '50-000000002', 59.00, 0.00, 1475.00, NULL, NULL, 15, 323, 0.00, 0, NULL, 0),
(31, '', '2024-07-22', NULL, 'LOSS AND DAMAGE', -12, 0, '50-000000003', 38.00, 0.00, 456.00, NULL, NULL, 18, 7, 0.00, 0, NULL, 0),
(32, '', '2024-07-22', NULL, 'PURCHASED ORDER', 30, 22, '10-000000004', 26.00, 0.00, 780.00, NULL, NULL, 37, 101, 0.00, 0, NULL, 0),
(33, '', '2024-07-22', NULL, 'PURCHASED ORDER', 30, 22, '10-000000004', 53.00, 0.00, 1590.00, NULL, NULL, 26, 100, 0.00, 0, NULL, 0),
(34, '', '2024-07-22', NULL, 'PURCHASED ORDER', 30, 22, '10-000000004', 43.50, 0.00, 1305.00, NULL, NULL, 18, 103, 0.00, 0, NULL, 0),
(35, '', '2024-07-22', NULL, 'PURCHASED ORDER', 100, 23, '10-000000005', 1.00, 0.00, 100.00, NULL, NULL, 35, 21, 0.00, 0, NULL, 0),
(36, '', '2024-07-22', NULL, 'LOSS AND DAMAGE', -2, 0, '50-000000004', 22.75, 0.00, 45.50, NULL, NULL, 3, 7075, 0.00, 0, NULL, 0),
(37, '', '2024-07-31', NULL, 'PURCHASED ORDER', 15, 11, '10-000000006', 26.00, 0.00, 390.00, NULL, NULL, 32, 11, 0.00, 0, NULL, 0),
(38, '', '2024-07-31', NULL, 'PURCHASED ORDER', 25, 11, '10-000000006', 56.09, 0.00, 1402.25, NULL, NULL, 16, 30, 0.00, 0, NULL, 0),
(39, '', '2024-07-31', NULL, 'PURCHASED ORDER', 56, 11, '10-000000006', 19.40, 0.00, 1086.40, NULL, NULL, 33, 8, 0.00, 0, NULL, 0),
(40, '', '2024-07-31', NULL, 'PURCHASED ORDER', 25, 11, '10-000000006', 14.50, 0.00, 362.50, NULL, NULL, 10, 222, 0.00, 0, NULL, 0),
(41, '', '2024-07-31', NULL, 'PURCHASED ORDER', 15, 11, '10-000000006', 8.50, 0.00, 127.50, NULL, NULL, 20, 4970, 0.00, 0, NULL, 0),
(42, '', '2024-07-31', NULL, 'PURCHASED ORDER', 52, 11, '10-000000006', 28.00, 0.00, 1456.00, NULL, NULL, 1, 16, 0.00, 0, NULL, 0),
(43, '', '2024-07-31', NULL, 'PURCHASED ORDER', 256, 11, '10-000000006', 21.50, 0.00, 5504.00, NULL, NULL, 1, 3616, 0.00, 0, NULL, 0),
(44, '', '2024-07-31', NULL, 'PURCHASED ORDER', 15, 11, '10-000000006', 9.10, 0.00, 136.50, NULL, NULL, 8, 1363, 0.00, 0, NULL, 0),
(45, '', '2024-07-31', NULL, 'PURCHASED ORDER', 65, 11, '10-000000006', 140.00, 0.00, 9100.00, NULL, NULL, 1, 2, 0.00, 0, NULL, 0),
(46, '', '2024-07-31', NULL, 'PURCHASED ORDER', 56, 11, '10-000000006', 20.00, 0.00, 1120.00, NULL, NULL, 28, 3370, 0.00, 0, NULL, 0),
(47, '', '2024-07-31', NULL, 'PURCHASED ORDER', 988, 11, '10-000000006', 25.50, 0.00, 25194.00, NULL, NULL, 18, 3013, 0.00, 0, NULL, 0),
(48, '', '2024-07-31', NULL, 'PURCHASED ORDER', 56, 11, '10-000000006', 14.45, 0.00, 809.20, NULL, NULL, 7, 1078, 0.00, 0, NULL, 0),
(49, '', '2024-07-31', NULL, 'PURCHASED ORDER', 15, 11, '10-000000006', 70.00, 0.00, 1050.00, NULL, NULL, 29, 4368, 0.00, 0, NULL, 0),
(50, '', '2024-07-31', NULL, 'PURCHASED ORDER', 25, 11, '10-000000006', 122.00, 0.00, 3050.00, NULL, NULL, 15, 4433, 0.00, 0, NULL, 0),
(51, '', '2024-07-31', NULL, 'PURCHASED ORDER', 36, 11, '10-000000006', 11.25, 0.00, 405.00, NULL, NULL, 23, 7078, 0.00, 0, NULL, 0),
(52, '', '2024-07-31', NULL, 'PURCHASED ORDER', 25, 11, '10-000000006', 52.00, 0.00, 1300.00, NULL, NULL, 10, 102, 0.00, 0, NULL, 0),
(53, '', '2024-07-31', NULL, 'PURCHASED ORDER', 36, 11, '10-000000006', 43.50, 0.00, 1566.00, NULL, NULL, 18, 103, 0.00, 0, NULL, 0),
(54, '', '2024-07-31', NULL, 'PURCHASED ORDER', 12, 11, '10-000000006', 60.00, 0.00, 720.00, NULL, NULL, 27, 4024, 0.00, 0, NULL, 0),
(55, '', '2024-07-31', NULL, 'PURCHASED ORDER', 69, 11, '10-000000006', 50.00, 0.00, 3450.00, NULL, NULL, 13, 278, 0.00, 0, NULL, 0),
(56, '', '2024-07-31', NULL, 'PURCHASED ORDER', 25, 11, '10-000000006', 22.50, 0.00, 562.50, NULL, NULL, 23, 81, 0.00, 0, NULL, 0),
(57, '', '2024-07-31', NULL, 'PURCHASED ORDER', 36, 11, '10-000000006', 90.25, 0.00, 3249.00, NULL, NULL, 1, 83, 0.00, 0, NULL, 0),
(58, '', '2024-07-31', NULL, 'PURCHASED ORDER', 26, 11, '10-000000006', 27.05, 0.00, 703.30, NULL, NULL, 11, 4022, 0.00, 0, NULL, 0),
(59, '', '2024-07-31', NULL, 'PURCHASED ORDER', 23, 11, '10-000000006', 24.00, 0.00, 552.00, NULL, NULL, 11, 967, 0.00, 0, NULL, 0),
(60, '', '2024-07-31', NULL, 'LOSS AND DAMAGE', -5, 0, '50-000000004', 22.75, 0.00, 113.75, NULL, NULL, 3, 7075, 0.00, 0, NULL, 0),
(61, '', '2024-08-01', NULL, 'PURCHASED ORDER', 25, 11, '10-000000007', 14.00, 0.00, 350.00, NULL, NULL, 1, 1, 0.00, 0, NULL, 0),
(62, '', '2024-08-01', NULL, 'PURCHASED ORDER', 15, 11, '10-000000007', 70.00, 0.00, 1050.00, NULL, NULL, 29, 4368, 0.00, 0, NULL, 0),
(63, '', '2024-08-01', NULL, 'PURCHASED ORDER', 36, 11, '10-000000007', 28.00, 0.00, 1008.00, NULL, NULL, 1, 16, 0.00, 0, NULL, 0),
(64, '', '2024-08-01', NULL, 'PURCHASED ORDER', 78, 11, '10-000000007', 8.50, 0.00, 663.00, NULL, NULL, 20, 4970, 0.00, 0, NULL, 0),
(65, '', '2024-08-01', NULL, 'PURCHASED ORDER', 15, 11, '10-000000007', 140.00, 0.00, 2100.00, NULL, NULL, 1, 2, 0.00, 0, NULL, 0),
(66, '', '2024-08-01', NULL, 'PURCHASED ORDER', 778, 11, '10-000000007', 21.50, 0.00, 16727.00, NULL, NULL, 1, 3616, 0.00, 0, NULL, 0),
(67, '', '2024-08-01', NULL, 'PURCHASED ORDER', 78, 11, '10-000000007', 25.50, 0.00, 1989.00, NULL, NULL, 18, 3013, 0.00, 0, NULL, 0),
(68, '', '2024-08-01', NULL, 'PURCHASED ORDER', 56, 11, '10-000000007', 14.45, 0.00, 809.20, NULL, NULL, 7, 1078, 0.00, 0, NULL, 0),
(69, '', '2024-08-01', NULL, 'PURCHASED ORDER', 89, 11, '10-000000007', 20.00, 0.00, 1780.00, NULL, NULL, 28, 3370, 0.00, 0, NULL, 0),
(70, '', '2024-08-01', NULL, 'PURCHASED ORDER', 15, 11, '10-000000007', 9.10, 0.00, 136.50, NULL, NULL, 8, 1363, 0.00, 0, NULL, 0),
(71, '', '2024-08-01', NULL, 'PURCHASED ORDER', 65, 11, '10-000000007', 176.95, 0.00, 11501.75, NULL, NULL, 22, 2406, 0.00, 0, NULL, 0),
(72, '', '2024-08-01', NULL, 'PURCHASED ORDER', 56, 11, '10-000000007', 59.00, 0.00, 3304.00, NULL, NULL, 2, 3346, 0.00, 0, NULL, 0),
(73, '', '2024-08-01', NULL, 'PURCHASED ORDER', 23, 11, '10-000000007', 77.00, 0.00, 1771.00, NULL, NULL, 1, 6122, 0.00, 0, NULL, 0),
(74, '', '2024-08-01', NULL, 'PURCHASED ORDER', 89, 11, '10-000000007', 26.00, 0.00, 2314.00, NULL, NULL, 36, 507, 0.00, 0, NULL, 0),
(75, '', '2024-08-01', NULL, 'PURCHASED ORDER', 23, 11, '10-000000007', 41.00, 0.00, 943.00, NULL, NULL, 16, 1262, 0.00, 0, NULL, 0),
(76, '', '2024-08-01', NULL, 'LOSS AND DAMAGE', -5, 0, '50-000000004', 22.75, 0.00, 113.75, NULL, NULL, 3, 7075, 0.00, 0, NULL, 0),
(77, '', '2024-08-02', NULL, 'PURCHASED ORDER', 25, 11, '10-000000008', 0.00, 0.00, 0.00, NULL, NULL, 24, 1459, 0.00, 0, NULL, 0),
(78, '', '2024-08-02', NULL, 'PURCHASED ORDER', 36, 11, '10-000000008', 26.00, 0.00, 936.00, NULL, NULL, 36, 507, 0.00, 0, NULL, 0),
(79, '', '2024-08-02', NULL, 'PURCHASED ORDER', 36, 11, '10-000000009', 9.50, 0.00, 342.00, NULL, NULL, 20, 29, 0.00, 0, NULL, 0),
(80, '', '2024-08-02', NULL, 'PURCHASED ORDER', 25, 11, '10-000000009', 35.00, 0.00, 875.00, NULL, NULL, 16, 80, 0.00, 0, NULL, 0),
(81, '', '2024-08-02', NULL, 'PURCHASED ORDER', 12, 11, '10-000000010', 94.40, 0.00, 1132.80, NULL, NULL, 28, 286, 0.00, 0, NULL, 0),
(82, '', '2024-08-02', NULL, 'PURCHASED ORDER', 23, 11, '10-000000011', 5.14, 0.00, 118.22, NULL, NULL, 9, 31, 0.00, 0, NULL, 0),
(83, '', '2024-08-05', NULL, 'PURCHASED ORDER', 25, 11, '10-000000013', 7.00, 0.00, 175.00, NULL, NULL, 20, 831, 0.00, 0, NULL, 0),
(84, 'SADF', '2024-08-10', '', 'Maintenance and Repairs', 20, 12, '', 20.00, 2.00, 398.00, '', NULL, 0, 0, 440.64, 1, NULL, 0),
(85, 'KINI', '2024-07-30', '', 'Professional Services', 25, 0, '12', 254.00, 2.00, 6348.00, '', NULL, 4, 0, 6348.00, 0, 'Array', 0),
(86, 'KINI', '2024-07-30', '', 'Professional Services', 25, 0, '234234', 254.00, 2.00, 6348.00, '', NULL, 4, 0, 6348.00, 0, '{\"freightCharges\":\"0\",\"insuranceFees\":\"200\",\"importDuties\":\"500\",\"customsFees\":\"0\",\"vat\":\"0\",\"customBrokerFees\":\"0\",\"portHandlingFees\":\"0\",\"storageFees\":\"0\",\"inlandTransport\":\"0\",\"documentationFees\":\"0\",\"inspectionFees\":\"0\",\"bankFees\":\"0\",\"currencyConversionFees\":\"0\",\"others\":\"350\",\"totalLandingCost\":\"3865.00\"}', 0),
(87, 'SAKYANAN', '2024-08-10', '', 'Promotions', 20, 14, '100', 12.00, 32.00, 208.00, '', NULL, 5, 0, 0.00, 0, '{\"freightCharges\":\"250\",\"insuranceFees\":\"500\",\"importDuties\":\"900\",\"customsFees\":\"0\",\"vat\":\"0\",\"customBrokerFees\":\"0\",\"portHandlingFees\":\"0\",\"storageFees\":\"0\",\"inlandTransport\":\"0\",\"documentationFees\":\"0\",\"inspectionFees\":\"0\",\"bankFees\":\"0\",\"currencyConversionFees\":\"0\",\"others\":\"0\",\"totalLandingCost\":\"1650.00\",\"totalLandingCostPerPiece\":\"82.50\"}', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
