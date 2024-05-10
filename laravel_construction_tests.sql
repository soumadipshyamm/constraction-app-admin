-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2024 at 11:08 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel_construction_tests`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sl_no` varchar(255) DEFAULT NULL,
  `project_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subproject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `activities` varchar(255) DEFAULT NULL,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `qty` varchar(255) DEFAULT '0',
  `rate` varchar(255) DEFAULT '0',
  `amount` varchar(255) DEFAULT '0',
  `start_date` varchar(255) DEFAULT NULL,
  `end_date` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `uuid`, `parent_id`, `sl_no`, `project_id`, `subproject_id`, `type`, `activities`, `unit_id`, `qty`, `rate`, `amount`, `start_date`, `end_date`, `company_id`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'c3e7566d-e8d0-4ba6-9f09-c9f4594a4221', NULL, NULL, 1, 1, 'heading', 'heading', 1, NULL, NULL, NULL, NULL, NULL, 2, 1, '2023-10-03 08:00:17', '2023-10-03 08:00:17', NULL),
(2, 'a60ab1a3-1ece-49e2-b9f6-420b635780f9', 1, NULL, 1, 1, 'subheading', 'Sub Heading', 5, '0', '0', '0', NULL, NULL, 2, 1, '2023-10-03 08:00:37', '2023-10-03 08:00:37', NULL),
(3, 'd9c33eae-5b6f-40e3-8bd7-492a9937e900', 2, NULL, 1, 1, 'activites', 'Activites-soumadip', 1, '45', '4', '180', '2023-10-05', '2023-11-03', 2, 1, '2023-10-03 08:00:58', '2023-10-03 08:00:58', NULL),
(4, '6d0180c2-2c49-41c0-874d-c8b7f9d9a49f', NULL, '1', 2, 2, 'heading', 'activites', 1, NULL, NULL, NULL, NULL, NULL, 1, 1, '2023-10-06 06:21:09', '2023-10-06 06:21:09', NULL),
(5, '968b9c5c-388b-4ade-9bff-4f58371dfe73', 2, '1.1.2', 1, 1, 'activites', 'Activites-1', 4, '3', '2', '6', '2023-10-07', '2023-10-26', 1, 1, '2023-10-06 06:24:31', '2023-10-06 06:24:31', NULL),
(6, 'a82000de-13f5-46c3-9c47-499175df176c', NULL, NULL, 2, 2, 'heading', 'heading_2', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2023-10-06 06:34:15', '2024-01-16 02:34:36', NULL),
(7, '3390a6df-332d-4fd6-98fc-ae5be08f0370', 4, NULL, 2, 2, 'subheading', 'sub activites', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2023-10-06 06:34:28', '2023-10-06 06:34:28', NULL),
(8, 'b6db07b2-6e92-46ec-99a1-2e83000e1224', 7, NULL, 2, 2, 'activites', 'activites', 4, '3', '4', '12', '2023-10-05', '2023-10-22', 1, 1, '2023-10-06 06:34:59', '2023-10-06 06:34:59', NULL),
(9, '7cf4b655-c0ca-438d-8aee-2ae26ac9036c', 6, NULL, 2, 2, 'subheading', 'Sub Heading', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2023-10-06 06:35:25', '2023-10-06 06:35:25', NULL),
(10, '4a332696-752c-4b50-8585-67a232a93a38', NULL, '1', 2, 2, 'heading', 'Substructure', 1, NULL, NULL, NULL, NULL, NULL, 1, 1, '2023-12-04 08:00:00', '2023-12-04 08:00:00', NULL),
(11, '9204d354-9352-454d-b6a7-082e4846159b', 10, '1.2', 2, 2, 'subheading', 'Concrete', 1, NULL, NULL, NULL, NULL, NULL, 1, 1, '2023-12-04 08:00:00', '2023-12-04 08:00:00', NULL),
(12, '02c45b5d-2b03-4f3a-874c-995078ac4e75', 11, '1.2.1', 2, 2, 'activites', 'PCC 1:2:4', 7, '100', '5000', '=F4*G4', NULL, NULL, 1, 1, '2023-12-04 08:00:00', '2023-12-04 08:00:00', NULL),
(13, 'f81ff8c5-4b06-4edd-87d7-f06151d750fa', 11, '1.2.2', 2, 2, 'activites', 'RCC M20', 7, '300', '8000', '=F5*G5', NULL, NULL, 1, 1, '2023-12-04 08:00:00', '2023-12-04 08:00:00', NULL),
(14, '4f28d333-a75b-49d2-8b29-8eaea1304614', 11, '1.2.3', 2, 2, 'activites', 'RCC M30 ', 1, NULL, NULL, NULL, NULL, NULL, 1, 1, '2023-12-04 08:00:00', '2023-12-04 08:00:00', NULL),
(15, '9ae873e7-b971-4326-9ade-52c154b0e3a0', 10, '1.3', 2, 2, 'subheading', 'Steel', 1, NULL, NULL, NULL, NULL, NULL, 1, 1, '2023-12-04 08:00:00', '2023-12-04 08:00:00', NULL),
(16, 'a1c21434-48fa-4479-8dd1-f5bc352fdb96', 15, '1.3.1', 2, 2, 'activites', 'Steel work reinforcement ', 8, '12', '40000', '=F8*G8', NULL, NULL, 1, 1, '2023-12-04 08:00:00', '2023-12-04 08:00:00', NULL),
(17, 'f706cc56-5bd4-4a0e-9824-a8b88422862c', NULL, '2', 2, 2, 'heading', 'Superstructure', 1, NULL, NULL, NULL, NULL, NULL, 1, 1, '2023-12-04 08:00:00', '2023-12-04 08:00:00', NULL),
(18, 'abd9903e-4e10-4a60-ac3b-6ca00bc8da12', 17, '2.1', 2, 2, 'activites', 'Columns', 9, '2000', '300', '=F10*G10', NULL, NULL, 1, 1, '2023-12-04 08:00:00', '2023-12-04 08:00:00', NULL),
(19, 'fd5ecfe8-7a35-4370-b8ec-4d22b24b0992', 17, '2.2', 2, 2, 'activites', 'Beams', 9, '2500', '350', '=F11*G11', NULL, NULL, 1, 1, '2023-12-04 08:00:00', '2023-12-04 08:00:00', NULL),
(20, 'f906ef7d-a4d3-4fcf-b7e2-0e257d6389e1', 17, '2.3', 2, 2, 'activites', 'Slabs', 9, '4000', '300', '=F12*G12', NULL, NULL, 1, 1, '2023-12-04 08:00:00', '2023-12-04 08:00:00', NULL),
(21, '93d0abf6-e7e9-4715-b2b4-60ae534a4dab', NULL, '1', 2, 2, 'heading', 'Substructure', 1, NULL, NULL, NULL, NULL, NULL, 1, 1, '2023-12-04 08:08:42', '2023-12-04 08:08:42', NULL),
(22, '252a8481-c7b2-463e-89bb-3a1d6610ed7d', 21, '1.2', 2, 2, 'subheading', 'Concrete', 1, NULL, NULL, NULL, NULL, NULL, 1, 1, '2023-12-04 08:08:42', '2023-12-04 08:08:42', NULL),
(23, '88975d71-495d-4e27-897f-54ba7770993b', 22, '1.2.1', 2, 2, 'activites', 'PCC 1:2:4', 7, '100', '5000', '=F4*G4', NULL, NULL, 1, 1, '2023-12-04 08:08:42', '2023-12-04 08:08:42', NULL),
(24, '8ed5021f-6916-47bd-baf0-1bcbcf006827', 22, NULL, 2, 2, NULL, 'RCC M20', 7, '300', '8000', '=F5*G5', '2023-11-28', '2023-12-23', 1, 1, '2023-12-04 08:08:42', '2023-12-28 05:54:58', NULL),
(25, '2b4c4581-6e38-4550-9287-66853e2a99ec', 22, '1.2.3', 2, 2, 'activites', 'RCC M30 ', 1, NULL, NULL, NULL, NULL, NULL, 1, 1, '2023-12-04 08:08:42', '2023-12-04 08:08:42', NULL),
(26, 'f0b870c2-4f63-43e0-9b16-268e3f6bfbac', 21, '1.3', 2, 2, 'subheading', 'Steel', 1, NULL, NULL, NULL, NULL, NULL, 1, 1, '2023-12-04 08:08:42', '2023-12-04 08:08:42', NULL),
(27, 'e2cd47e8-7f5d-4362-8d32-c9bcd2fcc782', 26, '1.3.1', 2, 2, 'activites', 'Steel work reinforcement ', 8, '12', '40000', '=F8*G8', NULL, NULL, 1, 1, '2023-12-04 08:08:42', '2023-12-04 08:08:42', NULL),
(28, '06a03134-7e2e-47d6-a141-b0d88322735d', NULL, '2', 2, 2, 'heading', 'Superstructure', 1, NULL, NULL, NULL, NULL, NULL, 1, 1, '2023-12-04 08:08:42', '2023-12-04 08:08:42', NULL),
(29, '2cede5a9-bcc7-4405-81fb-fa133b3839b5', 28, '2.1', 2, 2, 'activites', 'Columns', 9, '2000', '300', '=F10*G10', NULL, NULL, 1, 1, '2023-12-04 08:08:42', '2023-12-04 08:08:42', NULL),
(30, '27590a8d-2f70-40ca-b76e-e2ec4bb557b8', 28, '2.2', 2, 2, 'activites', 'Beams', 9, '2500', '350', '=F11*G11', NULL, NULL, 1, 1, '2023-12-04 08:08:42', '2023-12-04 08:08:42', NULL),
(31, 'a9d4c84e-22f0-481d-853d-6f2f7f173e75', 28, '2.3', 2, 2, 'activites', 'Slabs', 9, '4000', '300', '=F12*G12', NULL, NULL, 1, 1, '2023-12-04 08:08:42', '2023-12-04 08:08:42', NULL),
(32, '074100f3-da18-4df0-ad75-b23e18a1bbb3', NULL, '1', 2, 2, 'heading', 'Heateee', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2024-01-12 04:33:16', '2024-01-12 04:33:16', NULL),
(33, '334fbe0c-7b58-43bf-b05f-37c354361db6', 32, '1.1', 2, 2, 'activites', 'Heateee', 4, NULL, NULL, '0', NULL, NULL, 1, 1, '2024-01-12 04:33:50', '2024-01-12 04:33:50', NULL),
(34, '71fa7dba-1147-4c0a-83c3-ed1e16d303c4', NULL, '1', 2, 2, 'heading', 'Heateee', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2024-01-15 04:55:22', '2024-01-15 04:55:22', NULL),
(35, '5fdf88fb-93f2-479d-b970-a9b658f27f63', NULL, NULL, 1, 1, 'heading', 'qwertya', NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, '2024-01-15 05:12:06', '2024-01-15 05:12:06', NULL),
(36, '947e2abd-67b0-431d-81da-05371af7b23f', NULL, NULL, 1, 1, 'heading', 'actest', NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, '2024-01-15 05:44:35', '2024-01-15 05:44:35', NULL),
(37, 'e7f86727-5fb9-478e-8796-a47e5164ab5b', NULL, NULL, 1, 3, 'heading', 'test head one', NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, '2024-01-16 00:18:45', '2024-01-16 00:18:45', NULL),
(40, '46e107b6-262a-49ec-8af3-ad8b9a0f62e7', 1, NULL, 2, 2, 'activites', 'subheading', NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, '2024-01-16 02:35:20', '2024-01-16 02:35:20', NULL),
(43, '51bd19dd-c115-4221-8320-0612d9199433', 28, NULL, 2, 2, 'activites', 'Activites', 1, NULL, '1', '12', '2023/10/23', '2023/10/23', 2, 1, '2024-01-16 02:36:35', '2024-01-16 07:42:47', '2024-01-16 07:42:47'),
(44, '999eadda-3dc8-40bd-a3f6-5bccaac45821', 2, NULL, 1, 1, 'activites', 'test acc one', 11, NULL, '10', '100', '2024/01/01', '2024/01/27', 2, 1, '2024-01-17 01:10:43', '2024-01-17 01:10:43', NULL),
(45, '31831c3d-3f00-46a0-9ab9-35c74d11f64b', NULL, NULL, 1, 1, 'heading', 'testi heading', NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, '2024-01-17 01:15:15', '2024-01-17 01:15:15', NULL),
(46, '0ae5f17a-6897-43df-82f4-af8bbfd607e1', 37, '1.1', 1, 1, 'activites', 'qwedrfgre', NULL, NULL, NULL, '0', NULL, NULL, 2, 1, '2024-01-17 01:25:43', '2024-01-17 01:25:43', NULL),
(47, '8764cb87-71ec-471e-bad8-cc60f5ad82f9', 46, '1.1', 1, 1, 'activites', 'trrrrrrrrrrrrrrrrrrrrrrrrrrr', 3, '3', '8000', '24000', NULL, NULL, 2, 1, '2024-01-17 01:26:26', '2024-01-17 01:26:26', NULL),
(48, 'c7804630-e0a9-4d51-beb9-c57b86e3eece', 1, '1.1', 1, 1, 'activites', 'Sub Heading', 3, '2500', '8000', '20000000', NULL, NULL, 2, 1, '2024-01-17 01:29:59', '2024-01-17 01:29:59', NULL),
(49, '9bb8e928-5796-4902-bfb3-1ff8bb0a9e3f', 36, NULL, 1, 1, 'activites', 'testing one', 6, NULL, '10', '100', '2024/01/09', '2024/01/20', 2, 1, '2024-01-19 00:33:23', '2024-01-19 00:33:23', NULL),
(50, 'f50cc5a1-060c-4c2e-b4d2-4a00457a351b', 36, NULL, 1, NULL, 'activites', 'testing on', 6, NULL, '10', '100', '2024/01/09', '2024/01/20', 2, 1, '2024-01-19 04:21:25', '2024-01-19 04:28:36', NULL),
(51, '3f068d50-cbb5-4c7c-9998-d947066e57bc', 36, NULL, 1, NULL, 'activites', 'testing e', 6, NULL, '10', '200', '2024/01/09', '2024/01/20', 2, 1, '2024-01-19 04:25:16', '2024-01-19 04:29:03', NULL),
(52, '65314407-57e3-48e3-994b-767f763b2feb', 36, NULL, 1, NULL, 'activites', 'testing one', 6, NULL, '10', '20', '2024/01/09', '2024/01/20', 2, 1, '2024-01-19 04:25:42', '2024-01-19 04:25:42', NULL),
(53, '9667cc93-d6d6-4ece-af38-1a5b299f7ace', NULL, NULL, 1, NULL, 'heading', 'RCC', NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, '2024-02-11 13:19:02', '2024-02-11 13:19:02', NULL),
(54, '5b68eac6-bf94-4d04-8e10-d8fb141937ad', 53, NULL, 1, NULL, 'activites', 'RCC concrete', 23, NULL, NULL, '0', 'Invalid date', 'Invalid date', 2, 1, '2024-02-11 13:19:52', '2024-02-11 13:19:52', NULL),
(55, 'acaeabd4-cc65-4521-a834-cb5c1b41667b', NULL, NULL, 5, 13, 'heading', 'Preliminary', NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, '2024-02-16 09:51:17', '2024-04-19 08:43:20', '2024-04-19 08:43:20'),
(56, '2595bfcf-d23a-4580-bae3-46b82e210c79', NULL, '1', 2, 2, 'heading', 'Brickwork', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2024-02-25 23:35:30', '2024-02-25 23:35:30', NULL),
(57, '231dc34c-45f5-43fc-91ce-9f0e1e8f06d0', NULL, NULL, 23, 15, 'heading', 'Preliminary', NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, '2024-03-04 09:54:12', '2024-03-04 09:54:12', NULL),
(58, '9b690f7e-a0f2-42ea-bb9f-fa945fa61e66', 57, NULL, 23, 15, 'activites', 'cleaning', 28, NULL, '100', '30000', '2024/03/04', '2024/03/12', 2, 1, '2024-03-04 09:55:18', '2024-03-04 09:55:18', NULL),
(59, '5a8980f9-cd14-4657-9a8b-bd33f6616e34', 57, NULL, 23, 15, 'activites', 'excavation', 27, NULL, '250', '62500', '2024/03/12', '2024/03/20', 2, 1, '2024-03-04 09:56:12', '2024-03-04 09:56:12', NULL),
(60, '7295bd79-283b-4fbd-9272-dc69947fb84e', NULL, '1', 25, 18, 'heading', 'Prelim', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2024-03-12 03:46:59', '2024-03-12 03:46:59', NULL),
(61, '12de2a67-1a86-4383-b12e-82865470e2ba', NULL, '1', 25, 18, 'heading', 'Substructure', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2024-03-12 03:47:27', '2024-03-12 03:47:27', NULL),
(62, 'e13f9be2-9c99-4603-9def-5cc0889e0874', NULL, '1', 25, 18, 'heading', 'Substructure', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2024-03-12 03:47:52', '2024-03-12 04:03:15', '2024-03-12 04:03:15'),
(63, 'f1e81a58-989a-4a2f-889d-ac496e0dbba8', NULL, '1', 26, NULL, 'heading', 'Substructure', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2024-03-12 03:49:31', '2024-03-12 03:49:31', NULL),
(64, 'f95386d3-edd6-4fbe-b09a-6854423d6cb5', NULL, '1', 26, NULL, 'heading', 'Superstructure', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2024-03-12 03:50:05', '2024-03-12 03:50:05', NULL),
(65, '31f0b8c6-4395-46f6-910b-a05637e35e87', NULL, '1', 26, NULL, 'heading', 'Superstructure', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2024-03-12 03:56:07', '2024-03-12 03:56:07', NULL),
(66, '5895af3e-6d01-4d7b-a003-32f7ad447eb0', 60, '1.1', 25, 18, 'activites', 'Cleaning work', 21, '100', '50', '5000', NULL, NULL, 1, 1, '2024-03-12 04:02:28', '2024-03-12 04:02:28', NULL),
(67, '4a1371ef-a5ca-40f1-b977-717249d33b3a', NULL, '1', 25, 18, 'heading', 'Superstructure-Rajgarh', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2024-03-12 04:03:34', '2024-03-12 04:03:34', NULL),
(68, '6d5fb323-457b-47fd-85d6-e929f7ffc539', 67, '1.1', 25, 18, 'activites', 'Steel Reinforcement', 8, '5', '60000', '300000', NULL, NULL, 1, 1, '2024-03-12 04:06:02', '2024-03-12 04:06:02', NULL),
(69, 'ab032774-4d8d-4a10-bc0e-8f4f544d7edf', 67, '1.1', 25, 18, 'activites', 'Steel Reinforcement', 8, '5', '60000', '300000', NULL, NULL, 1, 1, '2024-03-12 04:06:02', '2024-03-12 04:06:02', NULL),
(70, '063f4fe5-7e24-4a06-89cc-a11ad534a5cc', NULL, NULL, 2, 2, 'heading', 'activites', 1, NULL, NULL, NULL, NULL, NULL, 1, 1, '2024-03-12 05:22:59', '2024-03-12 05:22:59', NULL),
(71, 'e0455f1a-e72d-4f09-a29b-a1847e71b2fb', 70, NULL, 2, 2, 'heading', 'heading_2', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2024-03-12 05:22:59', '2024-03-12 05:22:59', NULL),
(72, 'aecc3ef6-e557-4f8a-b6f9-11d98a624603', 71, NULL, 2, 2, 'subheading', 'sub activites', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2024-03-12 05:22:59', '2024-03-12 05:22:59', NULL),
(73, '386d1bc4-1e8b-40a3-ad10-674ed25d8b26', 72, NULL, 2, 2, 'activites', 'activites', 4, '3', '4', '12', NULL, NULL, 1, 1, '2024-03-12 05:22:59', '2024-03-12 05:22:59', NULL),
(74, 'f37720fc-1b36-4c41-92d5-87eef8c42000', 73, NULL, 2, 2, 'subheading', 'Sub Heading', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2024-03-12 05:22:59', '2024-03-12 05:22:59', NULL),
(75, 'cd6fc48d-9905-4792-bd24-fd73b8fecb1b', 74, NULL, 2, 2, 'heading', 'Substructure', 1, NULL, NULL, NULL, NULL, NULL, 1, 1, '2024-03-12 05:22:59', '2024-03-12 05:22:59', NULL),
(76, '19d892da-c119-4958-9424-6fd20da6ad54', 75, NULL, 2, 2, 'subheading', 'Concrete', 1, NULL, NULL, NULL, NULL, NULL, 1, 1, '2024-03-12 05:22:59', '2024-03-12 05:22:59', NULL),
(77, '5dcf3a46-6f9f-4fcb-b6ed-58173bb15dde', 76, NULL, 2, 2, 'activites', 'PCC 1:2:4', 7, '100', '5000', '=F4*G4', NULL, NULL, 1, 1, '2024-03-12 05:22:59', '2024-03-12 05:22:59', NULL),
(78, '3ee38455-011b-4c60-bafa-64a7129359ab', 77, NULL, 2, 2, 'activites', 'RCC M20', 7, '300', '8000', '=F5*G5', NULL, NULL, 1, 1, '2024-03-12 05:22:59', '2024-03-12 05:22:59', NULL),
(79, 'a63b2b8e-9dcf-4392-9c94-cbf1b7379951', 78, NULL, 2, 2, 'activites', 'RCC M30 ', 1, NULL, NULL, NULL, NULL, NULL, 1, 1, '2024-03-12 05:22:59', '2024-03-12 05:22:59', NULL),
(80, '45477b89-8639-4e51-9a79-54b6490adfb9', 79, NULL, 2, 2, 'subheading', 'Steel', 1, NULL, NULL, NULL, NULL, NULL, 1, 1, '2024-03-12 05:22:59', '2024-03-12 05:22:59', NULL),
(81, 'dfa5b365-fdd2-48ac-81b7-a8e0f2e51557', 80, NULL, 2, 2, 'activites', 'Steel work reinforcement ', 8, '12', '40000', '=F8*G8', NULL, NULL, 1, 1, '2024-03-12 05:22:59', '2024-03-12 05:22:59', NULL),
(82, '03987ee9-d7ac-4123-a666-7ade60c05e51', NULL, NULL, 27, 19, 'heading', 'Prelim test 12th mar', NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, '2024-03-12 11:32:07', '2024-03-12 11:32:07', NULL),
(83, '7e4898e1-e006-4b28-abff-d934463937e3', NULL, NULL, 27, 19, 'heading', 'superstructure 12th March', NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, '2024-03-12 11:33:01', '2024-03-12 11:33:01', NULL),
(84, '869da035-50ae-4fda-ab99-a7b0d8a27ee0', 82, NULL, 27, 19, 'activites', 'cleaning activity', 28, NULL, '80', '4000', 'Invalid date', 'Invalid date', 2, 1, '2024-03-12 11:34:04', '2024-03-12 11:34:04', NULL),
(85, '4559f3be-899f-44bc-8d2c-0c2b70c30be7', 83, NULL, 27, 19, 'activites', 'RCC concrete', 27, NULL, '5500', '2750000', 'Invalid date', 'Invalid date', 2, 1, '2024-03-12 11:35:21', '2024-03-12 11:35:21', NULL),
(86, '93b5064e-6355-483c-b179-d000fa8fd766', NULL, NULL, 29, 20, 'heading', 'sub structure', NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, '2024-04-04 08:07:29', '2024-04-04 08:07:29', NULL),
(87, '7ebdeded-6251-4869-91a4-cb9c092d9d23', 86, NULL, 29, 20, 'activites', 'Excavation 4th april', 27, NULL, '100', '30000', '2024/04/04', '2024/04/04', 2, 1, '2024-04-04 08:09:27', '2024-04-04 08:09:27', NULL),
(88, '989243cb-c56d-4d56-90f8-a80b213278f8', 86, NULL, 29, 20, 'activites', 'RCC 4th april', 27, NULL, NULL, '0', 'Invalid date', 'Invalid date', 2, 1, '2024-04-04 08:10:39', '2024-04-04 08:10:39', NULL),
(89, '5aa11f77-f696-4b17-8c39-c5f4c0449e31', NULL, NULL, 22, 11, 'heading', 'Heateee', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2024-04-19 09:48:05', '2024-04-19 09:48:05', NULL),
(90, '07cf88a8-2693-4a65-a7a4-929f862672f4', 89, NULL, 22, 11, 'activites', 'Heateee', 4, NULL, NULL, '0', NULL, NULL, 1, 1, '2024-04-19 09:48:05', '2024-04-19 09:48:05', NULL),
(91, 'fe9d2cdd-75dc-442a-8ca3-f99eebeaf11b', 90, NULL, 22, 11, 'heading', 'Heateee', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2024-04-19 09:48:05', '2024-04-19 09:48:05', NULL),
(92, '23c07f64-0c6c-4b50-8ad8-3f05a8648446', 91, NULL, 22, 11, 'heading', 'Brickwork', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2024-04-19 09:48:05', '2024-04-19 09:48:05', NULL),
(93, 'e62557da-ab71-4693-8cbf-62cdea43dd0b', NULL, NULL, 25, 18, 'heading', 'activites', 1, NULL, NULL, NULL, NULL, NULL, 1, 1, '2024-04-19 09:49:31', '2024-04-19 09:49:31', NULL),
(94, 'e2ad9c59-f7d7-4c19-9025-7ca722566672', 93, NULL, 25, 18, 'heading', 'heading_2', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2024-04-19 09:49:31', '2024-04-19 09:49:31', NULL),
(95, '22756d9a-ddcf-4577-af87-e9d419a72b06', 94, NULL, 25, 18, 'subheading', 'sub activites', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2024-04-19 09:49:31', '2024-04-19 09:49:31', NULL),
(96, 'a0d86cd5-6dc4-4631-bb65-9b516c5389e3', 95, NULL, 25, 18, 'activites', 'activites', 4, '3', '4', '12', NULL, NULL, 1, 1, '2024-04-19 09:49:31', '2024-04-19 09:49:31', NULL),
(97, '4096d480-01de-48bc-a366-d409ba301d56', 96, NULL, 25, 18, 'subheading', 'Sub Heading', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2024-04-19 09:49:31', '2024-04-19 09:49:31', NULL),
(98, '4d709a03-7b89-4786-a0fd-1424863ef774', 97, NULL, 25, 18, 'heading', 'Substructure', 1, NULL, NULL, NULL, NULL, NULL, 1, 1, '2024-04-19 09:49:31', '2024-04-19 09:49:31', NULL),
(99, 'f9a15d8e-2fed-4221-b703-4597e54e46b8', 98, NULL, 25, 18, 'subheading', 'Concrete', 1, NULL, NULL, NULL, NULL, NULL, 1, 1, '2024-04-19 09:49:31', '2024-04-19 09:49:31', NULL),
(100, '4316d0e7-162a-4586-9714-1f2adaef8c08', 99, NULL, 25, 18, 'activites', 'PCC 1:2:4', 7, '100', '5000', '=F4*G4', NULL, NULL, 1, 1, '2024-04-19 09:49:31', '2024-04-19 09:49:31', NULL),
(101, '2cb211d6-4cb0-4c49-801f-08052872dcb4', 100, NULL, 25, 18, 'activites', 'RCC M20', 7, '300', '8000', '=F5*G5', NULL, NULL, 1, 1, '2024-04-19 09:49:31', '2024-04-19 09:49:31', NULL),
(102, 'cd3ab80f-62bc-4c51-ad8d-ef62afdb27ab', 101, NULL, 25, 18, 'activites', 'RCC M30 ', 1, NULL, NULL, NULL, NULL, NULL, 1, 1, '2024-04-19 09:49:31', '2024-04-19 09:49:31', NULL),
(103, 'cd846350-3efa-4f3b-9b2f-daa16c541045', 102, NULL, 25, 18, 'subheading', 'Steel', 1, NULL, NULL, NULL, NULL, NULL, 1, 1, '2024-04-19 09:49:31', '2024-04-19 09:49:31', NULL),
(104, 'e4facc91-f95a-4721-afe6-159a0c30fad6', 103, NULL, 25, 18, 'activites', 'Steel work reinforcement ', 8, '12', '40000', '=F8*G8', NULL, NULL, 1, 1, '2024-04-19 09:49:31', '2024-04-19 09:49:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `activity_histories`
--

CREATE TABLE `activity_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `activities_id` bigint(20) UNSIGNED NOT NULL,
  `qty` varchar(255) DEFAULT '0',
  `completion` int(11) DEFAULT NULL,
  `vendors_id` bigint(20) UNSIGNED DEFAULT NULL,
  `remaining_qty` varchar(255) DEFAULT '0',
  `total_qty` varchar(255) DEFAULT '0',
  `img` varchar(255) DEFAULT NULL,
  `remarkes` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `dpr_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_histories`
--

INSERT INTO `activity_histories` (`id`, `uuid`, `activities_id`, `qty`, `completion`, `vendors_id`, `remaining_qty`, `total_qty`, `img`, `remarkes`, `company_id`, `dpr_id`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'b55dc72d-89c5-4559-ae23-70baef018f42', 1, '2', 4, 1, NULL, NULL, NULL, 'testtttt', 2, 5, 1, '2024-02-02 05:19:59', '2024-02-02 05:19:59', NULL),
(2, '139e6f98-6807-4c0f-a439-895340178afb', 2, '5', 4, 1, NULL, NULL, NULL, 'testtttt', 2, 5, 1, '2024-02-02 05:19:59', '2024-02-02 05:19:59', NULL),
(3, '08896dd3-b9b5-44d3-80cc-3d9e8b1b2d28', 1, '2', 4, 1, NULL, NULL, NULL, 'testtttt', 2, 5, 1, '2024-02-02 05:20:56', '2024-02-02 05:20:56', NULL),
(4, '4e644260-c229-4d7d-860e-8ba17cd3703d', 2, '5', 4, 1, NULL, NULL, NULL, 'testtttt', 2, 5, 1, '2024-02-02 05:20:56', '2024-02-02 05:20:56', NULL),
(5, '65b542db-f292-48bd-9f00-7068b6b738d0', 1, '2', 4, 1, NULL, NULL, NULL, 'testtttt', 2, 5, 1, '2024-02-02 05:22:20', '2024-02-02 05:22:20', NULL),
(6, '2bb22f96-1c1b-4082-9b1e-0e8bb3d0650e', 2, '5', 4, 1, NULL, NULL, NULL, 'testtttt', 2, 5, 1, '2024-02-02 05:22:20', '2024-02-02 05:22:20', NULL),
(7, '14347ce9-56bc-49e2-851c-aba5e57999bc', 1, '2', 4, 1, NULL, NULL, NULL, 'testtttt', 2, 5, 1, '2024-02-02 05:25:25', '2024-02-02 05:25:25', NULL),
(8, '6c41bb73-72f9-4541-b888-76e5d5a5a601', 2, '5', 4, 1, NULL, NULL, NULL, 'testtttt', 2, 5, 1, '2024-02-02 05:25:25', '2024-02-02 05:25:25', NULL),
(12, 'ca7dd5eb-faae-49e9-9125-72f98f98cf6b', 3, '2', 4, 1, NULL, NULL, NULL, 'testtttt', 2, 5, 1, '2024-02-02 07:48:38', '2024-02-02 07:48:38', NULL),
(13, '344245e3-9f4b-40e3-88ba-9636ada11248', 1, '5', 4, 1, NULL, NULL, NULL, 'testtttt', 2, 5, 1, '2024-02-02 07:48:38', '2024-02-02 07:48:38', NULL),
(14, '9fbeeec0-de57-43ad-ba82-b15faa89dd5a', 3, '2', 4, 1, NULL, NULL, NULL, 'testtttt', 2, 5, 1, '2024-02-02 07:48:50', '2024-02-02 07:48:50', NULL),
(15, '71d29a01-60c4-4c78-91dc-0b6db6ffcc4e', 1, '5', 4, 1, NULL, NULL, NULL, 'testtttt', 2, 5, 1, '2024-02-02 07:48:50', '2024-02-02 07:48:50', NULL),
(19, '529131e3-7b56-4e50-890f-ad5ba5c90ca8', 1, '2', 4, 1, NULL, NULL, NULL, 'testtttt', 2, 5, 1, '2024-02-02 08:09:27', '2024-02-02 08:09:27', NULL),
(20, '0586036b-b5b2-4dc6-8a6a-d82aac2983e1', 3, '5', 4, 1, NULL, NULL, NULL, 'testtttt', 2, 5, 1, '2024-02-02 08:09:27', '2024-02-02 08:09:27', NULL),
(21, '668742d6-436a-4756-a974-b47d6204ab0c', 1, '2', 4, 1, NULL, NULL, NULL, 'testtttt', 2, 5, 1, '2024-02-02 08:13:59', '2024-02-02 08:13:59', NULL),
(22, 'f495a724-adf0-48a2-a4dc-77f428171c12', 3, '5', 4, 1, NULL, NULL, NULL, 'testtttt', 2, 5, 1, '2024-02-02 08:13:59', '2024-02-02 08:13:59', NULL),
(23, 'efc0a90b-4419-414b-8b25-7eb88cb87674', 1, '2', 4, 1, NULL, NULL, '', 'testtttt', 2, 5, 1, '2024-02-02 08:24:02', '2024-02-02 08:24:02', NULL),
(24, '42d51366-7e64-4916-a345-9dfdbc694ae0', 3, '5', 4, 1, NULL, NULL, '', 'testtttt', 2, 5, 1, '2024-02-02 08:24:02', '2024-02-02 08:24:02', NULL),
(25, '039354ff-91ee-4c12-9761-e01f0fde8f67', 1, '2', 4, 1, NULL, NULL, '', 'testtttt', 2, 5, 1, '2024-02-02 08:25:15', '2024-02-02 08:25:15', NULL),
(26, 'b4db6255-64e8-4136-b7fc-36143f83a5cf', 3, '5', 4, 1, NULL, NULL, '', 'testtttt', 2, 5, 1, '2024-02-02 08:25:15', '2024-02-02 08:25:15', NULL),
(27, 'e8b4ee60-9e98-416b-a306-573bd8a34d47', 1, '2', 4, 1, NULL, NULL, '', 'testtttt', 2, 5, 1, '2024-02-02 08:25:26', '2024-02-02 08:25:26', NULL),
(28, '663f3a0b-073a-4231-a40e-0c5bbb2c6246', 3, '5', 4, 1, NULL, NULL, '', 'testtttt', 2, 5, 1, '2024-02-02 08:25:26', '2024-02-02 08:25:26', NULL),
(29, '42bc27e3-9ce9-4a74-a292-e6c2f820fe74', 1, '2', 4, 1, NULL, NULL, '', 'testtttt', 2, 5, 1, '2024-02-02 08:25:49', '2024-02-02 08:25:49', NULL),
(30, '071dfa64-d5b2-4dfe-85f3-e35b8f346789', 3, '5', 4, 1, NULL, NULL, '', 'testtttt', 2, 5, 1, '2024-02-02 08:25:49', '2024-02-02 08:25:49', NULL),
(31, '553b6deb-4bd5-4761-a85e-9150d774be22', 1, '2', 4, 1, NULL, NULL, '', 'testtttt', 2, 5, 1, '2024-02-02 08:29:04', '2024-02-02 08:29:04', NULL),
(32, 'd3a6c6fe-6e70-4011-86fb-bd29e35fae54', 3, '5', 4, 1, NULL, NULL, '', 'testtttt', 2, 5, 1, '2024-02-02 08:29:04', '2024-02-02 08:29:04', NULL),
(33, 'fbc4e444-8642-4af4-8f75-7716e0a41245', 1, '2', 4, 1, NULL, NULL, '', 'testtttt', 2, 5, 1, '2024-02-02 08:29:12', '2024-02-02 08:29:12', NULL),
(34, '5ef707a2-b29d-40e6-a40b-da214f20add6', 3, '5', 4, 1, NULL, NULL, '', 'testtttt', 2, 5, 1, '2024-02-02 08:29:12', '2024-02-02 08:29:12', NULL),
(35, '251da0b4-c9e7-4778-af74-72f4401c7330', 1, '2', 4, NULL, NULL, NULL, '', 'testtttt', 2, 5, 1, '2024-02-02 08:43:59', '2024-02-02 08:43:59', NULL),
(36, '07d08b1f-a827-443c-bb64-dc916319fbd9', 3, '5', 4, NULL, NULL, NULL, '', 'testtttt', 2, 5, 1, '2024-02-02 08:43:59', '2024-02-02 08:43:59', NULL),
(37, 'de51d0f7-a721-40a7-8e86-820f7a3860cb', 1, '2', 4, NULL, NULL, NULL, '', 'testtttt', 2, 5, 1, '2024-02-02 08:59:35', '2024-02-02 08:59:35', NULL),
(38, '2ef80e0e-8585-4acf-b7cd-390a35ce3f1d', 3, '5', 4, NULL, NULL, NULL, '', 'testtttt', 2, 5, 1, '2024-02-02 08:59:35', '2024-02-02 08:59:35', NULL),
(39, '4e7cfad8-17e8-4cce-9f66-93db96517fe0', 2, '10', 10, 1, NULL, NULL, '', NULL, 2, 23, 1, '2024-02-02 09:03:32', '2024-02-02 09:03:32', NULL),
(40, 'bc4d984b-6ca1-43ac-b700-a2371d2e86f5', 3, '10', 10, 1, NULL, NULL, '', NULL, 2, 23, 1, '2024-02-02 09:03:32', '2024-02-02 09:03:32', NULL),
(41, 'd7faf342-4315-414f-b734-4919870031a8', 2, '10', 10, 1, NULL, NULL, '', NULL, 2, 24, 1, '2024-02-05 02:07:10', '2024-02-05 02:07:10', NULL),
(42, 'f63e7d81-1497-4364-ab16-2ea4cbdd31e5', 1, '10', 4, NULL, '-10', NULL, '', 'testtttt', 2, 5, 1, '2024-02-22 08:46:39', '2024-02-22 08:46:39', NULL),
(43, '06b73676-0ed9-4d68-ac69-520b19b6f5b3', 2, '10', 4, NULL, '-10', NULL, '', 'testtttt', 2, 5, 1, '2024-02-22 08:46:39', '2024-02-22 08:46:39', NULL),
(44, 'd4e50ee0-8875-4d2a-89dc-9699cc71ea5d', 2, '10', 10, 1, '-20', NULL, '', 'uuuu', 2, 63, 1, '2024-02-22 09:07:29', '2024-02-22 09:07:29', NULL),
(45, 'fddba54f-3274-4fda-9c86-5e916a1217eb', 3, '20', 20, 1, '25', '45', '', 'kkkk', 2, 63, 1, '2024-02-22 09:07:29', '2024-02-22 09:07:29', NULL),
(46, 'a80c31c2-0270-4321-8e5e-b35bd1f52d34', 54, '122', 44, 1, '', '', '', 'testtttt', 2, 12, 1, '2024-02-29 00:37:16', '2024-03-01 08:05:54', NULL),
(47, '4cea597f-e153-495d-ac84-caed20f67b1b', 55, '122', 44, 1, '', '', '', 'testtttt', 2, 12, 1, '2024-02-29 00:37:16', '2024-03-01 08:07:55', NULL),
(51, 'b735b64b-31a8-4750-baf9-7c248aebb2b0', 1, '220', 54, 1, '', '', '', 'testtttt', 2, 12, 1, '2024-03-01 06:13:38', '2024-03-01 08:07:55', NULL),
(52, '2049755c-306a-4dcd-b32f-d3cc5f771178', 3, '22', 54, 1, '', '', '', 'testtttt', 2, 99, 1, '2024-03-01 07:05:53', '2024-03-07 05:59:40', NULL),
(54, 'c9c6fffd-c4cb-45f5-96e3-79212c36c431', 43, '22', 54, 1, '', '', '', 'testtttt', 2, 12, 1, '2024-03-01 08:05:45', '2024-03-07 05:57:38', NULL),
(55, '1bf596cd-7339-4244-81bb-b9318e1f625c', 5, '122', 44, 1, '', '', '', 'testtttt', 2, 12, 1, '2024-03-01 08:06:24', '2024-03-01 08:08:13', NULL),
(56, 'ef5047ea-d22e-4fa2-9f83-a68487ee5049', 2, '12', 44, 1, '', '', '', 'testtttt', 2, 99, 1, '2024-03-06 04:51:42', '2024-03-07 05:59:40', NULL),
(57, '17d5ea16-5ca3-4827-ad37-9b53dca21038', 2, '12', 44, 1, '', '', '', 'testtttt', 2, 12, 1, '2024-03-07 05:57:38', '2024-03-07 05:57:38', NULL),
(61, 'f490d8c2-1774-4a7e-b8d0-369fe3b257d5', 3, '10', 10, 1, '', '45', '', 'Okkk', 2, 137, 1, '2024-04-22 07:02:38', '2024-04-22 07:02:38', NULL),
(62, '2a690696-9915-43f3-a200-9cb1a6cdb9d0', 1, '10', 10, 1, '', '', '', 'Ok', 2, 137, 1, '2024-04-22 09:11:26', '2024-04-22 09:11:26', NULL),
(63, '472260c2-2d73-4c71-9a4a-c11644d39fac', 2, '10', 10, NULL, '', '', '', 'Ok', 2, 138, 1, '2024-04-26 02:31:04', '2024-04-26 03:39:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `additional_features`
--

CREATE TABLE `additional_features` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `aditional_project_inr` varchar(255) DEFAULT NULL,
  `aditional_project_usd` varchar(255) DEFAULT NULL,
  `additional_users_inr` varchar(255) DEFAULT NULL,
  `additional_users_usd` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `additional_features`
--

INSERT INTO `additional_features` (`id`, `uuid`, `aditional_project_inr`, `aditional_project_usd`, `additional_users_inr`, `additional_users_usd`, `created_at`, `updated_at`) VALUES
(1, '4b8a5d00-28d5-44f7-9e4e-64f53be5e2f1', '1000', '500', '500', '400', '2023-10-13 12:54:47', '2023-10-13 13:01:32');

-- --------------------------------------------------------

--
-- Table structure for table `admin_menus`
--

CREATE TABLE `admin_menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_menus`
--

INSERT INTO `admin_menus` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Dashboard', 'dashboard', '2023-10-03 07:37:48', '2023-10-03 07:37:48'),
(2, 'Admin User', 'admin-user', '2023-10-03 07:37:48', '2023-10-03 07:37:48'),
(3, 'Admin Management Site Engineering', 'admin-management-site-engineering', '2023-10-03 07:37:48', '2023-10-03 07:37:48'),
(4, 'Admin Role Permissions', 'admin-role-permissions', '2023-10-03 07:37:48', '2023-10-03 07:37:48'),
(5, 'Admin Company', 'admin-company', '2023-10-03 07:37:48', '2023-10-03 07:37:48'),
(6, 'Admin Project', 'admin-project', '2023-10-03 07:37:48', '2023-10-03 07:37:48');

-- --------------------------------------------------------

--
-- Table structure for table `admin_permissions`
--

CREATE TABLE `admin_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_profiles`
--

CREATE TABLE `admin_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `blood_group` enum('A+','A-','B+','B-','AB+','AB-','O+','O-') DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `qualification` longtext DEFAULT NULL,
  `subjects` longtext DEFAULT NULL,
  `address` longtext DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_roles`
--

CREATE TABLE `admin_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_roles`
--

INSERT INTO `admin_roles` (`id`, `name`, `slug`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'super-admin', 1, '2023-10-03 07:37:48', '2023-10-03 07:37:48'),
(2, 'Sub Admin', 'sub-admin', 1, '2023-10-03 07:37:48', '2023-10-03 07:37:48'),
(3, 'Account Admin', 'account-admin', 1, '2023-10-03 07:37:48', '2023-10-03 07:37:48'),
(4, 'Content Manager', 'content-manager', 1, '2023-10-03 07:37:48', '2023-10-03 07:37:48');

-- --------------------------------------------------------

--
-- Table structure for table `admin_user_permissions`
--

CREATE TABLE `admin_user_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_user_roles`
--

CREATE TABLE `admin_user_roles` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `admin_role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_user_role_permissions`
--

CREATE TABLE `admin_user_role_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `project_id` bigint(20) UNSIGNED DEFAULT NULL,
  `store_warehouses_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `specification` varchar(255) DEFAULT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `uuid`, `project_id`, `store_warehouses_id`, `name`, `code`, `specification`, `unit_id`, `quantity`, `company_id`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '06c6284f-5992-486d-93ae-a9080ab69c2a', 1, 1, 'Tablee', '6651bc9a401e49', 'This is a testingg', 6, NULL, 2, 1, '2023-10-03 07:58:28', '2024-01-17 08:54:41', NULL),
(2, '35830bf8-d54d-41a0-86e3-c5d9f96dde6f', 2, 2, 'JCB', '6651bf26f7f04d', 'This is testing', 5, NULL, 1, 1, '2023-10-03 10:52:31', '2023-10-03 10:52:31', NULL),
(3, '3068253c-c465-45ee-bb62-aacd18e03b7f', NULL, NULL, 'Sample', '665a0ec8968316', 'test', 1, NULL, 2, 1, '2024-01-12 02:08:49', '2024-01-16 07:36:17', '2024-01-16 07:36:17'),
(4, '761d8f39-11cb-4d9f-ba11-1810c26f7e7f', NULL, NULL, 'JCB', '665c5d6893d42d', 'EX1043', 5, NULL, 1, 1, '2024-02-09 02:08:49', '2024-02-09 02:08:49', NULL),
(5, '2cd28406-034e-4bfe-90b9-d5d555585d54', NULL, NULL, 'JCB', '665c9161120920', 'exc902', 23, NULL, 2, 1, '2024-02-11 13:16:41', '2024-02-11 13:17:12', NULL),
(6, 'f2e246de-bc23-44d4-8326-2f64b532ea03', NULL, NULL, 'Concrete Mixer', '665e5e6b325454', 'J0234', 23, NULL, 2, 1, '2024-03-04 09:50:19', '2024-03-04 09:50:19', NULL),
(7, 'e4c69c2d-e035-46ec-9545-d0060b17a86f', NULL, NULL, 'Concrete Mixer', '665f01bc175e40', '1.5 Cum capacity', 30, NULL, 1, 1, '2024-03-12 03:39:21', '2024-03-12 03:40:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `assets_histories`
--

CREATE TABLE `assets_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `assets_id` bigint(20) UNSIGNED DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `activities_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vendors_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rate_per_unit` varchar(255) DEFAULT NULL,
  `remarkes` varchar(255) DEFAULT NULL,
  `dpr_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assets_histories`
--

INSERT INTO `assets_histories` (`id`, `uuid`, `assets_id`, `qty`, `activities_id`, `vendors_id`, `rate_per_unit`, `remarkes`, `dpr_id`, `company_id`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'd9b2d50d-8027-49f0-92be-db0d7157cbfb', 1, 2, 1, 1, '12', 'testtttt', 1, 2, 1, '2023-11-28 04:21:22', '2023-11-28 04:21:22', NULL),
(2, 'e20de304-1f48-42a9-957f-ad830592867f', 1, 2, 1, 1, '12', 'testtttt', 1, 2, 1, '2023-11-28 04:21:22', '2023-11-28 04:21:22', NULL),
(3, '199cb84a-70d9-4fcc-9305-e6f4a51a861e', 1, 2, 1, 1, '12', 'testtttt', 5, 2, 1, '2023-11-28 04:21:51', '2023-11-28 04:21:51', NULL),
(4, 'ea19f77d-856b-43d8-9a85-cdee5d1f2cda', 1, 2, 1, 1, '12', 'testtttt', 5, 2, 1, '2023-11-28 04:21:51', '2023-11-28 04:21:51', NULL),
(5, '644537c6-fa93-4649-91c5-6e45ccf4f1d4', 1, 1, 137, 1, '13', 'testtttt', 12, 2, 1, '2024-02-29 00:39:48', '2024-03-06 09:59:40', NULL),
(6, '22f940f1-cfec-47f7-ba1e-1dd96df638d1', 3, 2, 138, 1, '34', 'testtttt', 12, 2, 1, '2024-02-29 00:39:48', '2024-03-06 09:59:40', NULL),
(7, '6c26be78-2c35-4c62-8571-0223ab40596c', 1, 267, 1, 1, '122', 'testtttt', 110, 2, 1, '2024-03-06 10:25:34', '2024-03-06 10:28:47', NULL),
(8, '25bcb987-c610-44f9-90cc-488f98a40cd2', 1, 10, 1, 1, '20', 'defghjkl;\'', 99, 2, 1, '2024-03-07 01:38:29', '2024-03-07 01:38:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `assets_opening_stocks`
--

CREATE TABLE `assets_opening_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `opeing_stock_date` date DEFAULT NULL,
  `assets_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assets_opening_stocks`
--

INSERT INTO `assets_opening_stocks` (`id`, `uuid`, `project_id`, `store_id`, `opeing_stock_date`, `assets_id`, `quantity`, `company_id`, `is_active`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'c799bf75-8cce-4424-aea1-6ac77aa0f29e', 1, 1, '2023-09-29', 1, '5', 2, 1, NULL, '2023-10-03 07:58:59', '2023-10-03 07:58:59');

-- --------------------------------------------------------

--
-- Table structure for table `banner_pages`
--

CREATE TABLE `banner_pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `page_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `contented` longtext DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `is_approve` tinyint(4) DEFAULT 1 COMMENT '0:Unapproved,1:Approved',
  `is_blocked` tinyint(4) DEFAULT 0 COMMENT '0:Unblocked,1:Blocked',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banner_pages`
--

INSERT INTO `banner_pages` (`id`, `uuid`, `slug`, `page_id`, `name`, `title`, `contented`, `banner`, `is_active`, `is_approve`, `is_blocked`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '5519f5cd-1aa1-4ecd-8a5a-3acf01e37dfa', NULL, 1, NULL, 'home', '<div class=\"banner-content\">\r\n      <h1>\r\n        Field management software <br> to improve quality, safety and productivity\r\n      </h1>\r\n      <p>Lorem Ipsumsidummy text of then printin ngand typesetti dustry orem Ipsum dustry orem Ipsum.</p>\r\n      <ul class=\"banner-btn\">\r\n        <li><a href=\"\">Request a demo</a></li>\r\n        <li><a href=\"\">See Pricing Plans</a></li>\r\n      </ul>\r\n    </div>\r\n    <a class=\"chat\" href=\"\"><i class=\"fa fa-commenting\" aria-hidden=\"true\"></i></a>', '169567190480.png', 1, 1, 0, '2023-09-25 19:58:24', '2023-09-25 19:58:24', NULL),
(2, '0de33dea-a196-4cfe-a60e-3ab98ab9f28c', NULL, 2, NULL, 'about', '<div class=\"inner-banner-content\">\r\n      <h1>\r\n        Revolutionising Field Management <br> with Digitisation & Construction AI​\r\n      </h1>\r\n      <p>Lorem Ipsumsidummy text of then printin ngand typesetti dustry orem Ipsum dustry orem Ipsum.</p>\r\n      <ul class=\"inner-banner-btn\">\r\n        <li><a href=\"\">See Pricing Plans</a></li>\r\n\r\n      </ul>\r\n    </div>\r\n    <a class=\"chat\" href=\"\"><i class=\"fa fa-commenting\" aria-hidden=\"true\"></i></a>', '169567197053.png', 1, 1, 0, '2023-09-25 19:59:30', '2023-09-25 19:59:30', NULL),
(3, 'bdec777c-39a1-489a-bcbb-12d47e8663a2', NULL, 3, NULL, 'product', '<div class=\"overlay\"></div>\r\n                  <div class=\"breadcrumbs-content\">\r\n                        <p> <span><a href=\"#\">Home </a></span> / Product</p>\r\n                        <h2>Product</h2>\r\n                  </div>\r\n            </div>', '169567204557.png', 1, 1, 0, '2023-09-25 20:00:45', '2023-09-25 20:00:45', NULL),
(4, 'a964125f-9e81-4412-a549-a8a11ef64fce', NULL, 7, NULL, 'contact', '<div class=\"overlay\"></div>\r\n                  <div class=\"breadcrumbs-content\">\r\n                        <p> <span><a href=\"#\">Home </a></span> / Contact Us</p>\r\n                        <h2>Contact Us</h2>\r\n                  </div>\r\n            </div>', '169567209474.png', 1, 1, 0, '2023-09-25 20:01:34', '2023-09-25 20:01:34', NULL),
(5, '1f0f77f2-1728-47b5-b400-ba4a00a9cda1', NULL, 8, NULL, 'testt', '<p>testtttt</p>', '170118372512.jpg', 1, 1, 0, '2023-11-28 09:32:05', '2023-11-28 09:32:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `state_id` bigint(20) UNSIGNED NOT NULL,
  `state_code` text DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `country_code` char(2) DEFAULT NULL,
  `fips_code` varchar(255) DEFAULT NULL,
  `iso2` varchar(255) DEFAULT NULL,
  `type` varchar(191) DEFAULT NULL,
  `latitude` decimal(15,8) DEFAULT NULL,
  `longitude` decimal(15,8) DEFAULT NULL,
  `flag` tinyint(4) NOT NULL DEFAULT 1,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `wikiDataId` varchar(255) DEFAULT NULL COMMENT 'Rapid API GeoDB Cities',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `slug`, `state_id`, `state_code`, `country_id`, `country_code`, `fips_code`, `iso2`, `type`, `latitude`, `longitude`, `flag`, `status`, `wikiDataId`, `created_at`, `updated_at`, `deleted_at`) VALUES
(57584, 'Abhaneri', 'abhaneri', 4014, 'RJ', 101, 'IN', NULL, NULL, NULL, '27.01000000', '76.61000000', 1, 1, 'Q4667324', '2019-10-05 07:53:43', '2020-07-30 00:10:17', NULL),
(57585, 'Abhayāpuri', 'abhayapuri', 4027, 'AS', 101, 'IN', NULL, NULL, NULL, '26.32000000', '90.69000000', 1, 1, 'Q490701', '2019-10-05 07:53:43', '2020-07-30 00:10:17', NULL),
(57586, 'Abirāmam', 'abiramam', 4035, 'TN', 101, 'IN', NULL, NULL, NULL, '9.44000000', '78.44000000', 1, 1, 'Q490715', '2019-10-05 07:53:43', '2020-07-30 00:10:17', NULL),
(57587, 'Abohar', 'abohar', 4015, 'PB', 101, 'IN', NULL, NULL, NULL, '30.14000000', '74.20000000', 1, 1, 'Q490878', '2019-10-05 07:53:43', '2020-07-30 00:10:17', NULL),
(57588, 'Abrama', 'abrama', 4030, 'GJ', 101, 'IN', NULL, NULL, NULL, '20.86000000', '72.91000000', 1, 1, 'Q490916', '2019-10-05 07:53:43', '2020-07-30 00:10:17', NULL),
(57589, 'Achalpur', 'achalpur', 4008, 'MH', 101, 'IN', NULL, NULL, NULL, '21.26000000', '77.51000000', 1, 1, 'Q490886', '2019-10-05 07:53:43', '2020-07-30 00:10:17', NULL),
(57590, 'Achhnera', 'achhnera', 4022, 'UP', 101, 'IN', NULL, NULL, NULL, '27.18000000', '77.76000000', 1, 1, 'Q490739', '2019-10-05 07:53:43', '2020-07-30 00:10:17', NULL),
(57591, 'Adalaj', 'adalaj', 4030, 'GJ', 101, 'IN', NULL, NULL, NULL, '23.16000000', '72.58000000', 1, 1, 'Q2350169', '2019-10-05 07:53:43', '2020-07-30 00:10:17', NULL),
(57592, 'Adampur', 'adampur', 4015, 'PB', 101, 'IN', NULL, NULL, NULL, '31.43000000', '75.71000000', 1, 1, 'Q2350169', '2019-10-05 07:53:43', '2020-07-30 00:10:17', NULL),
(57593, 'Addanki', 'addanki', 4017, 'AP', 101, 'IN', NULL, NULL, NULL, '15.81000000', '79.97000000', 1, 1, 'Q2350169', '2019-10-05 07:53:43', '2020-07-30 00:10:17', NULL),
(57594, 'Adirampattinam', 'adirampattinam', 4035, 'TN', 101, 'IN', NULL, NULL, NULL, '10.34000000', '79.38000000', 1, 1, 'Q490694', '2019-10-05 07:53:43', '2020-07-30 00:10:17', NULL),
(57595, 'Aduthurai', 'aduthurai', 4035, 'TN', 101, 'IN', NULL, NULL, NULL, '11.02000000', '79.48000000', 1, 1, 'Q490694', '2019-10-05 07:53:43', '2020-07-30 00:10:17', NULL),
(57596, 'Adūr', 'adur', 4028, 'KL', 101, 'IN', NULL, NULL, NULL, '9.16000000', '76.73000000', 1, 1, 'Q490941', '2019-10-05 07:53:43', '2020-07-30 00:10:17', NULL),
(57597, 'Afzalgarh', 'afzalgarh', 4022, 'UP', 101, 'IN', NULL, NULL, NULL, '29.39000000', '78.67000000', 1, 1, 'Q490688', '2019-10-05 07:53:43', '2020-07-30 00:10:17', NULL),
(57598, 'Afzalpur', 'afzalpur', 4026, 'KA', 101, 'IN', NULL, NULL, NULL, '17.20000000', '76.36000000', 1, 1, 'Q490688', '2019-10-05 07:53:43', '2020-07-30 00:10:17', NULL),
(57599, 'Agar', 'agar', 4039, 'MP', 101, 'IN', NULL, NULL, NULL, '23.71000000', '76.02000000', 1, 1, 'Q490688', '2019-10-05 07:53:43', '2020-07-30 00:10:17', NULL),
(57600, 'Agartala', 'agartala', 4038, 'TR', 101, 'IN', NULL, NULL, NULL, '23.84000000', '91.28000000', 1, 1, 'Q170454', '2019-10-05 07:53:43', '2020-07-30 00:10:17', NULL),
(57601, 'Agra', 'agra', 4022, 'UP', 101, 'IN', NULL, NULL, NULL, '27.18000000', '78.02000000', 1, 1, 'Q42941', '2019-10-05 07:53:43', '2020-07-30 00:10:17', NULL),
(57602, 'Ahiri', 'ahiri', 4008, 'MH', 101, 'IN', NULL, NULL, NULL, '19.41000000', '80.00000000', 1, 1, 'Q3606967', '2019-10-05 07:53:43', '2020-07-30 00:10:17', NULL),
(57603, 'Ahmadnagar', 'ahmadnagar', 4008, 'MH', 101, 'IN', NULL, NULL, NULL, '19.09000000', '74.74000000', 1, 1, 'Q223517', '2019-10-05 07:53:43', '2020-07-30 00:10:17', NULL),
(57604, 'Ahmadpur', 'ahmadpur', 4008, 'MH', 101, 'IN', NULL, NULL, NULL, '18.71000000', '76.94000000', 1, 1, 'Q590521', '2019-10-05 07:53:43', '2020-07-30 00:10:17', NULL),
(57605, 'Ahmadābād', 'ahmadabad', 4030, 'GJ', 101, 'IN', NULL, NULL, NULL, '23.03000000', '72.58000000', 1, 1, 'Q401686', '2019-10-05 07:53:43', '2020-07-30 00:10:17', NULL),
(57606, 'Ahmedabad', 'ahmedabad', 4030, 'GJ', 101, 'IN', NULL, NULL, NULL, '23.03000000', '72.59000000', 1, 1, 'Q1070', '2019-10-05 07:53:43', '2020-07-30 00:10:17', NULL),
(57607, 'Ahraura', 'ahraura', 4022, 'UP', 101, 'IN', NULL, NULL, NULL, '25.02000000', '83.03000000', 1, 1, 'Q587150', '2019-10-05 07:53:43', '2020-07-30 00:10:17', NULL),
(57608, 'Ahwa', 'ahwa', 4030, 'GJ', 101, 'IN', NULL, NULL, NULL, '20.76000000', '73.69000000', 1, 1, 'Q1964214', '2019-10-05 07:53:43', '2020-07-30 00:10:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `client_company_name` varchar(255) DEFAULT NULL,
  `client_company_address` varchar(255) DEFAULT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `client_designation` varchar(255) DEFAULT NULL,
  `client_email` varchar(255) DEFAULT NULL,
  `client_phone` varchar(255) DEFAULT NULL,
  `client_mobile` varchar(255) DEFAULT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `uuid`, `client_company_name`, `client_company_address`, `client_name`, `client_designation`, `client_email`, `client_phone`, `client_mobile`, `project_id`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'bf28df13-8e5f-4c11-a7d9-eeda864c98ce', 'SFT client', 'Kolkata', 'Souma', 'CEO', 'aswe@aaa.com', '1234567890', NULL, 1, 1, '2023-10-03 07:55:50', '2023-10-03 07:55:50', NULL),
(2, 'd442ab31-c8e7-43a2-a3de-c83bfb319593', 'SFT client', 'Kolkata', 'Souma', 'Manager', 'souma@sft.com', '1234567890', NULL, 2, 1, '2023-10-03 10:51:06', '2023-10-03 10:51:06', NULL),
(6, '6889c3e3-01bd-4e97-86b2-c8842caca8f9', 'Mahajan Construction', 'punew', 'Niraj', 'CEO', 'niraj@gmail.com', '9688888888', '96325896523', 23, 1, '2024-03-04 09:46:20', '2024-03-04 09:46:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `registration_name` varchar(255) DEFAULT NULL,
  `company_registration_no` varchar(255) DEFAULT NULL,
  `registered_address` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `uuid`, `registration_name`, `company_registration_no`, `registered_address`, `logo`, `company_id`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '0d4e9065-67ae-4735-ba89-bd790ff50351', 'KP Builders Ltd', 'qwe3432', 'kolkata', '16963197187.jpg', 2, 1, '2023-10-03 07:55:18', '2023-10-03 07:55:18', NULL),
(2, '4f6d4177-b3ce-4596-8357-58f5bc77d798', 'KP Builders Ltd', 'qwe3432', 'kolkata', '169633015938.webp', 1, 1, '2023-10-03 10:49:19', '2023-10-03 10:49:19', NULL),
(3, '7f3dabcc-5297-45d2-8fd2-7536fe6eafd8', 'abcvvs pvtsa', 'wase234556ds', 'kolkata', '169650229092.png', 2, 1, '2023-10-05 10:38:10', '2023-10-05 10:38:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `companyuser_roles`
--

CREATE TABLE `companyuser_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `company_user_id` bigint(20) UNSIGNED NOT NULL,
  `company_role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companyuser_roles`
--

INSERT INTO `companyuser_roles` (`id`, `company_id`, `company_user_id`, `company_role_id`, `created_at`, `updated_at`) VALUES
(1, 1, 17, 2, '2023-10-13 13:06:46', '2023-10-13 13:06:46'),
(2, 1, 2, 6, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company_managments`
--

CREATE TABLE `company_managments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `registration_no` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `website_link` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `country_name` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `is_subscribed_1` tinyint(4) DEFAULT 0,
  `profile_images` varchar(255) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_subscribed` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_managments`
--

INSERT INTO `company_managments` (`id`, `uuid`, `name`, `registration_no`, `phone`, `address`, `website_link`, `country`, `country_name`, `state`, `city`, `is_subscribed_1`, `profile_images`, `is_active`, `created_at`, `updated_at`, `deleted_at`, `is_subscribed`) VALUES
(1, 'd4c0a1b2-a0ee-495b-a234-45028e34b5d6', 'KP Builders Ltd', 'KPwe3432', '1234567890', 'Kolkata', NULL, NULL, NULL, NULL, NULL, 2, NULL, 1, '2023-10-03 07:39:10', '2023-10-03 07:39:10', NULL, 2),
(2, '3378493b-fa3f-4442-8e80-b359b2ccd4b1', 'SFT', 'SR467331', '1234567890', 'Kolkata', 'www.sft.com', NULL, NULL, NULL, NULL, 2, NULL, 1, '2023-10-03 07:39:31', '2023-10-03 07:39:31', NULL, 2),
(3, '6a642c37-85c7-4d5b-a4fd-d6a32656ee5e', 'SFT', 'SR467331', '1234567890', 'Kolkata', 'www.sft.com', NULL, NULL, NULL, NULL, 0, NULL, 1, '2023-10-03 10:49:00', '2023-10-03 10:49:00', NULL, NULL),
(4, 'bc4d73fa-62f8-45ec-bd3f-bf5828c8bab6', 'SFT', 'SR467331', '1234567890', 'Kolkata', NULL, NULL, NULL, NULL, NULL, 0, NULL, 1, '2023-10-03 10:50:02', '2023-10-03 10:50:02', NULL, NULL),
(5, 'a8295992-5ab8-4bd9-b505-25d4e339ac07', 'SFT', 'SR467331', '1234567890', 'Kolkata', NULL, NULL, NULL, NULL, NULL, 0, NULL, 1, '2023-10-03 10:50:14', '2023-10-03 10:50:14', NULL, NULL),
(6, '8925bbc5-09a2-4876-a4a2-77619d7cba3b', 'AVC', '1234', '1234567890', 'Loc', NULL, NULL, NULL, NULL, NULL, 0, NULL, 1, '2023-10-03 11:30:30', '2023-10-03 11:30:30', NULL, NULL),
(7, '44b09d2b-f5d1-4b47-8d7f-27eca40db380', 'SFT', NULL, '5545464565', 'New Town', NULL, NULL, NULL, NULL, NULL, 0, NULL, 1, '2023-10-03 11:54:19', '2023-10-03 11:54:19', NULL, NULL),
(8, 'cee264ce-a5e5-4cdf-bc63-64bcfac5a9a8', 'ABC', '1234', '1234567890', 'Loc', NULL, NULL, NULL, NULL, NULL, 0, NULL, 1, '2023-10-03 11:57:55', '2023-10-03 11:57:55', NULL, NULL),
(9, '387db37a-176e-49e0-a88f-289459bfdf43', 'ABC', '1234', '1234567890', 'Loc', NULL, NULL, NULL, NULL, NULL, 0, NULL, 1, '2023-10-03 11:59:59', '2023-10-03 11:59:59', NULL, NULL),
(10, '4ec32167-2adf-4b65-b687-f097844b22eb', 'sft', 'sedfg', '1234567890', 'kolkata', 'www.sft.com', NULL, NULL, NULL, NULL, 0, NULL, 1, '2023-10-03 12:05:50', '2023-10-03 12:05:50', NULL, NULL),
(11, '4d478035-49ff-407f-8ac4-fc78b74ffd2e', 'SFT', '134324324', '6565465465', 'New Town', NULL, NULL, NULL, NULL, NULL, 0, NULL, 1, '2023-10-03 12:16:05', '2023-10-03 12:16:05', NULL, NULL),
(12, '2849e9bb-d92d-4f28-9ef9-55dd60978a3d', 'SFT', 'retert', '4565465423', 'New Town', NULL, NULL, NULL, NULL, NULL, 0, NULL, 1, '2023-10-03 12:27:03', '2023-10-03 12:27:03', NULL, NULL),
(13, 'b5d484cf-a68f-4d02-9ae2-c495a9be3d21', 'sft', 'sedfg', '1234567890', 'kolkata', 'www.sft.com', NULL, NULL, NULL, NULL, 0, NULL, 1, '2023-10-03 12:28:53', '2023-10-03 12:28:53', NULL, NULL),
(14, 'c0db7ab5-b507-4ef1-a1c5-3fa99037b85e', 'ABC', '1234', '1234567890', 'Loc', NULL, NULL, NULL, NULL, NULL, 0, NULL, 1, '2023-10-03 12:29:42', '2023-10-03 12:29:42', NULL, NULL),
(15, 'af4fdc3e-f2e5-48fe-b843-4408e2762785', 'SFT', 'ytrytryrt', '4654654645', 'SFT', NULL, NULL, NULL, NULL, NULL, 0, NULL, 1, '2023-10-03 14:23:51', '2023-10-03 14:23:51', NULL, NULL),
(16, '69d78f18-f718-436a-9cff-578b0a1fbaed', 'SFT', '122143432', '2345435435', 'New Town', NULL, NULL, NULL, NULL, NULL, 0, NULL, 1, '2023-10-05 07:40:11', '2023-10-05 07:40:11', NULL, NULL),
(17, '4e1c0423-5d0d-4340-86d8-a2e36f0359ad', 'KP Builders Ltdwwq', 'KPwe3432', '1234567890', 'Kolkata', NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, '2023-10-13 14:54:58', '2023-10-13 14:54:58', NULL, NULL),
(21, '366a8a5b-cc2a-4a87-b5b6-36ea9cb487ed', 'KP Builders Ltdwwq', 'qwe3432', '1234567890', 'Kolkata', NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, '2023-11-29 02:12:00', '2023-11-29 02:12:00', NULL, NULL),
(22, '91b446af-34dd-44db-8902-6c1e6ff823a5', 'Shobha', NULL, '9764357093', 'pune', NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, '2023-11-29 22:42:11', '2023-11-29 22:42:11', NULL, NULL),
(23, '008f3f94-3aea-4f3a-96d3-23a7592d22e8', 'Soujit', '12345678', '1234567890', 'abc,road', 'www.test.com', NULL, NULL, NULL, NULL, 1, NULL, 1, '2024-01-09 05:12:07', '2024-01-09 05:12:07', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company_permissions`
--

CREATE TABLE `company_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_permissions`
--

INSERT INTO `company_permissions` (`id`, `name`, `slug`) VALUES
(1, 'Dashboard', 'dashboard'),
(2, 'User Managment', 'user-managment'),
(3, 'Role-Permission', 'role-permission'),
(4, 'Companies', 'companies'),
(5, 'Project', 'project'),
(6, 'Sub-Project', 'sub-project');

-- --------------------------------------------------------

--
-- Table structure for table `company_roles`
--

CREATE TABLE `company_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `company_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_roles`
--

INSERT INTO `company_roles` (`id`, `name`, `slug`, `company_id`) VALUES
(1, 'Super Admin', 'super-admin', '1'),
(2, 'Sub Admin', 'sub-admin', '1'),
(3, 'Account Admin', 'account-admin', '1'),
(4, 'Content Manager', 'content-manager', '1'),
(5, 'Super Admin', 'super-admin', '1'),
(6, 'Super Admin', 'super-admin', '2'),
(7, 'Super Admin', 'super-admin', '3'),
(8, 'Super Admin', 'super-admin', '4'),
(9, 'Super Admin', 'super-admin', '5'),
(10, 'Super Admin', 'super-admin', '6'),
(11, 'Super Admin', 'super-admin', '7'),
(12, 'Super Admin', 'super-admin', '8'),
(13, 'Super Admin', 'super-admin', '9'),
(14, 'Super Admin', 'super-admin', '10'),
(15, 'Super Admin', 'super-admin', '11'),
(16, 'Super Admin', 'super-admin', '12'),
(17, 'Super Admin', 'super-admin', '13'),
(18, 'Super Admin', 'super-admin', '14'),
(19, 'Super Admin', 'super-admin', '15'),
(20, 'Super Admin', 'super-admin', '16'),
(21, 'Super Admin', 'super-admin', '17'),
(25, 'Super Admin', 'super-admin', '21'),
(26, 'Super Admin', 'super-admin', '22'),
(27, 'Super Admin', 'super-admin', '23'),
(28, 'Engineer', 'engineer', '1'),
(29, 'Project Manager', 'project-manager', '1');

-- --------------------------------------------------------

--
-- Table structure for table `company_role_managments`
--

CREATE TABLE `company_role_managments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_role_permissions`
--

CREATE TABLE `company_role_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_role_id` bigint(20) UNSIGNED NOT NULL,
  `company_permission_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_role_permissions`
--

INSERT INTO `company_role_permissions` (`id`, `company_role_id`, `company_permission_id`, `action`) VALUES
(1, 2, 2, 'add'),
(2, 2, 2, 'view'),
(3, 2, 3, 'add'),
(4, 2, 3, 'view'),
(5, 2, 4, 'add'),
(6, 2, 4, 'view'),
(7, 2, 5, 'add'),
(8, 2, 6, 'add');

-- --------------------------------------------------------

--
-- Table structure for table `company_users`
--

CREATE TABLE `company_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `alternet_phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `aadhar_no` varchar(255) DEFAULT NULL,
  `pan_no` varchar(255) DEFAULT NULL,
  `reporting_person` varchar(255) DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `otp_no` varchar(255) DEFAULT NULL,
  `otp_verify` varchar(255) DEFAULT 'no',
  `profile_images` varchar(255) DEFAULT NULL,
  `company_role_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `country` bigint(20) UNSIGNED DEFAULT NULL,
  `state` bigint(20) UNSIGNED DEFAULT NULL,
  `city` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_users`
--

INSERT INTO `company_users` (`id`, `uuid`, `name`, `email`, `password`, `phone`, `alternet_phone`, `address`, `designation`, `aadhar_no`, `pan_no`, `reporting_person`, `dob`, `otp_no`, `otp_verify`, `profile_images`, `company_role_id`, `company_id`, `is_active`, `created_at`, `updated_at`, `deleted_at`, `country`, `state`, `city`) VALUES
(1, '601c1860-8ba5-4cdf-8cc8-0dd937230266', 'soumadip', 'testcompany@titanbuilders.com', '$2y$10$XuP12.uY2GhCh3PRMsInKufauHHB7gYHotCYlqSUWamuiQVUigtZ.', '1234561890', NULL, NULL, 'Owner', NULL, NULL, NULL, '2023-09-28', NULL, 'no', '169631875042.jpg', 5, 1, 1, '2023-10-03 07:39:10', '2023-10-03 07:39:10', NULL, 101, 4018, 57608),
(2, '88e00d81-5837-4a52-8039-8ed1d422e452', 'soumadwwwwwqqqqqqtestTESAQWE', 'abcd@abc.com', '$2y$10$CqC7KprtzL24PSNBWYjMnuA5fih3Lip/oN.y3oHEwNb3cBRebLsWu', '1234567890', NULL, 'kolkata', 'Owner', '123456789890', 'dfgr45667u', NULL, '2023-10-17', NULL, 'yes', NULL, 2, 2, 1, '2023-10-03 07:39:31', '2024-01-18 09:03:34', NULL, 101, 4018, 57608),
(3, '5faa1839-7e89-4693-947b-a22707eea23a', 'ankur', 'abcd@abc.in', '$2y$10$9biTCugILQ0.PTULiNmjLegR8bw0wpHfW3bdW8gTLU0JI./sb0lii', '1234567890', NULL, NULL, 'dev', NULL, NULL, NULL, NULL, '4331', 'no', NULL, 7, 3, 1, '2023-10-03 10:49:01', '2023-10-03 10:49:01', NULL, NULL, NULL, NULL),
(4, 'a76cd917-be7a-4115-88dd-72e5eef2adc1', 'ankur', 'abcd@abc.in1', '$2y$10$70oJ.AvNIvabKV7SfhvcoeuZfZP540UYgBx63TPo8986hiFXmbbmS', '1234567890', NULL, NULL, 'dev', NULL, NULL, NULL, NULL, '6125', 'no', NULL, 8, 4, 1, '2023-10-03 10:50:03', '2023-10-03 10:50:03', NULL, NULL, NULL, NULL),
(5, '3fcabd70-0c0e-4c9b-9a80-328fc93457b0', 'ankur', 'abcd@abc.in2', '$2y$10$6FxnMhoxu33iHg2yqC1y8.Z7AQZAz5f0A8l4yiL/DTzvMTpDD7f6K', '1234567890', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9745', 'no', NULL, 9, 5, 1, '2023-10-03 10:50:14', '2023-10-03 10:50:14', NULL, NULL, NULL, NULL),
(6, '89b58373-aa7b-40e5-8f3c-d6e0b1b7c16f', 'ankur', 'abcd@ab', '$2y$10$8qlM0a6KxY/z3JHx2ZvbveUPzjI.Fw7bzCaq6wK/5EbtJb9X50oua', '1234567890', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1218', 'no', NULL, 10, 6, 1, '2023-10-03 11:30:30', '2023-10-03 11:30:30', NULL, NULL, NULL, NULL),
(7, '961626e7-8e6a-4499-b728-74bfe92aaf3c', 'Test', 'test@yopmail.com', '$2y$10$72qciFwc2aCy5DmpCN0Hh.aMNXU9La8XzsMlH6esR.4aGgoieMxC2', '2353253425', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0079', 'no', NULL, 11, 7, 1, '2023-10-03 11:54:19', '2023-10-03 11:54:19', NULL, NULL, NULL, NULL),
(8, '52da3106-1f60-4aeb-9d94-9505564cf0ff', 'ankur', 'abcd@ab.in', '$2y$10$b5rRPq2KMtVKwHZ4bjXVRuL5AUKUnNjzlsY9w8Jgm/9FAlMzPG5TO', '1234567890', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yes', NULL, 12, 8, 1, '2023-10-03 11:57:55', '2023-10-03 11:58:06', NULL, NULL, NULL, NULL),
(9, '86b35bb6-59b8-48d2-91a8-d59ca468bc98', 'ankur', 'abcd@yopmail.com', '$2y$10$YHSsq7Ln3KUpK9WTN6FM7.nYbZhdpYaOSKXaTOmwa3zub9qIrP8I.', '1234567890', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2809', 'no', NULL, 13, 9, 1, '2023-10-03 11:59:59', '2023-10-03 11:59:59', NULL, NULL, NULL, NULL),
(10, '1894a666-4748-49fc-9c38-161bea58d2a7', 'souymadip', 'abcd1@abc.sxd', '$2y$10$UXvzDCeYOYj0YqBGAfTB3udtOVlyEDfvIkrgj1nmIlfp98gVzVg9W', '1234567890', NULL, NULL, 'dev', NULL, NULL, NULL, '12/12/2021', '2255', 'no', NULL, 14, 10, 1, '2023-10-03 12:05:50', '2023-10-03 12:05:50', NULL, NULL, NULL, NULL),
(11, '6a3e5316-f929-49ec-a191-1c84416a5a1f', 'Avik', 'avik@yopmail.com', '$2y$10$QMJKrGDOtnarAvI5YFK23unOurITzepqTy9hT/w2d8rnIQdSQWDfW', '4353443243', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '5830', 'no', NULL, 15, 11, 1, '2023-10-03 12:16:05', '2023-10-03 12:18:10', NULL, NULL, NULL, NULL),
(12, 'e89d5038-92ca-4aed-83a3-66de325a6a58', 'Soumyo', 'soumyo@yopmail.com', '$2y$10$1uHcDSMATAzkz4B5Juu9M.yHtBqvSpuP9eR8jpUoxzMLI9mRZGa/a', '6576587863', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yes', NULL, 16, 12, 1, '2023-10-03 12:27:03', '2023-10-03 12:27:13', NULL, NULL, NULL, NULL),
(13, 'f28dd1a6-af44-4851-9db8-724b5fd722f8', 'souymadip', 'abcd@abc.sxd', '$2y$10$4zEOv/wsb5SLMxJdJrmQG.3FUn3w9qUr9Y/BTms9lt7ZUbgNcPsFy', '1236567891', NULL, NULL, 'dev', NULL, NULL, NULL, '12/12/2021', '1846', 'no', NULL, 17, 13, 1, '2023-10-03 12:28:53', '2023-10-04 11:10:49', NULL, NULL, NULL, NULL),
(14, 'e11f9a2f-e7cd-45f9-9c51-40fdbf499775', 'ankur', 'abcd1@yopmail.com', '$2y$10$uqkFEjLn2b8KNRP9D7b16eTow7CeU40LY3ZD81qMYlwWe7753vFHy', '1234567890', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3150', 'no', NULL, 18, 14, 1, '2023-10-03 12:29:42', '2023-10-03 12:29:46', NULL, NULL, NULL, NULL),
(15, '237dbdd1-74ba-45dc-8566-fb68d92378b7', 'Amit', 'amit@yopmail.com', '$2y$10$MbjzsU4Uv9e0Wa6K2dSgIuxtfoGiDJPX9HDr/3Mt743a0BGzUrbHW', '8979889867', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yes', NULL, 19, 15, 1, '2023-10-03 14:23:51', '2023-10-03 14:27:09', NULL, NULL, NULL, NULL),
(16, '5f65cef6-c9b7-4fbd-8f01-be342bdb7ccc', 'Joy dey', 'joy@yopmail.com', '$2y$10$2FF/zMtbFZ7v1DDaSEjCceQhJQrCO56lBQmJ7tWmBznXAn5Cm2kKi', '3253543432', NULL, NULL, NULL, NULL, NULL, NULL, '2023-06-12T07:40:00.000Z', NULL, 'yes', NULL, 20, 16, 1, '2023-10-05 07:40:11', '2023-10-05 07:42:47', NULL, NULL, NULL, NULL),
(17, 'ac6c30fc-3bb7-4f5b-bf90-ec546682aff2', 'Spumadip', 'soumatest@test.com', '$2y$10$r./NGxBLZZZP2Jin60ERM..GRfSfr1L/0lw9zcSpVmhQ0tAbwEh3a', '1234567890', NULL, 'kolkata', 'tester', '222222222222222222222', 'AXCD457GFE', NULL, '2023-10-07', NULL, 'no', '169720240657.png', 2, 1, 1, '2023-10-13 13:06:46', '2023-10-13 13:06:46', NULL, NULL, NULL, NULL),
(18, 'af0bc0aa-6476-4394-a23d-db004d4761b4', 'free test', 'freelogin@titanbuilders.com', '$2y$10$CqC7KprtzL24PSNBWYjMnuA5fih3Lip/oN.y3oHEwNb3cBRebLsWu', '1234567890', NULL, NULL, 'Owner', NULL, NULL, NULL, '2023-10-06', NULL, 'no', '169720889889.png', 21, 17, 1, '2023-10-13 14:54:58', '2023-10-13 14:54:58', NULL, NULL, NULL, NULL),
(22, '12ed111b-6ae9-4346-b8ab-ac04ecd756c5', 'labourqq', 'ankur@gmail.com', '$2y$10$FihZltQjzVhYlDEbvQYGQecxhuYWsVC.s6AGjqu0KLhWe75kaZKTm', '1234567890', NULL, NULL, 'tester', NULL, NULL, NULL, '2023-11-01', NULL, 'no', '17012437204.png', 25, 21, 1, '2023-11-29 02:12:00', '2023-11-29 02:12:00', NULL, NULL, NULL, NULL),
(23, '6727daf2-ff58-4b69-89bf-64a54f44de2b', 'mahesh', 'mahesh.max3il@gmail.com', '$2y$10$J7/Neu/cANaU9H9AiQNEOeh5QzEaSOjVX07IUjMJavTa2/Mqs5iz6', '9764357093', NULL, NULL, NULL, NULL, NULL, NULL, 'Invalid Date', '9421', 'no', NULL, 26, 22, 1, '2023-11-29 22:42:11', '2023-11-29 22:42:32', NULL, NULL, NULL, NULL),
(24, '5c47ce8d-3ffb-462e-acdd-500404b4fdcc', 'Soujit', 'soujit@yopmail.com', '$2y$10$1cpaJvLvIsDubegIa0UN7.eM0EBJS8lonbJh2TBFX/V4auOHMXJoO', '8637097878', NULL, NULL, 'asdfghjkl', NULL, NULL, NULL, '09/01/2020', NULL, 'yes', NULL, 27, 23, 1, '2024-01-09 05:12:07', '2024-01-09 05:18:16', NULL, NULL, NULL, NULL),
(29, '9bfef0fc-54ec-4604-8566-99f1bda7af46', 'ankuR', NULL, '$2y$10$5WJZ.PNB5jMbFtf1qPd7j.igO4TTR51khefONJTuP6UKkhtYx49/e', '1234567890', NULL, 'null', 'dev', 'null', 'null', 'null', NULL, NULL, 'no', '', 6, 2, 1, '2024-01-18 07:22:04', '2024-01-18 07:22:04', NULL, 101, NULL, 57602),
(30, '390272f2-6cd2-4f54-a0e4-ff03767734b9', 'soumadwwwwwqqqqqq', NULL, '$2y$10$HoTiOgU3e4utDzbweZkCXetijaFO07m7Id6ApDa/GF5RGKxVoMLeO', '1234567890', NULL, 'kolkata', 'Owner', '123456789890', 'dfgr45667u', 'null', NULL, NULL, 'no', '', 2, 2, 1, '2024-01-18 08:55:44', '2024-01-18 08:55:44', NULL, 101, 4018, 57608),
(31, 'ca357065-20d2-4451-aeec-66142cb068ce', 'sou', NULL, '$2y$10$j6t47XjDyJEEnAVhl1xgiugG/JIEuQofJEjHJPqB3GIBlded5YmXG', '1234567890', NULL, 'kolkata', 'Owner', '123456789890', 'dfgr45667u', 'Demo', NULL, NULL, 'no', '', 2, 2, 1, '2024-01-19 00:14:11', '2024-01-19 00:16:32', NULL, 101, 4018, 57608);

-- --------------------------------------------------------

--
-- Table structure for table `company_user_permissions`
--

CREATE TABLE `company_user_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_user_id` bigint(20) UNSIGNED NOT NULL,
  `company_permission_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_user_roles`
--

CREATE TABLE `company_user_roles` (
  `company_user_id` bigint(20) UNSIGNED NOT NULL,
  `company_role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_details`
--

CREATE TABLE `contact_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ph_no` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `map_loc` varchar(255) DEFAULT NULL,
  `facebook_link` varchar(255) DEFAULT NULL,
  `instagram_link` varchar(255) DEFAULT NULL,
  `twitter_link` varchar(255) DEFAULT NULL,
  `linkedin_link` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_details`
--

INSERT INTO `contact_details` (`id`, `ph_no`, `email`, `address`, `map_loc`, `facebook_link`, `instagram_link`, `twitter_link`, `linkedin_link`, `description`, `logo`, `created_at`, `updated_at`) VALUES
(1, '1234567890', 'abcd@abc.com', 'kolkata', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-11-29 02:03:29', '2023-11-29 02:03:29');

-- --------------------------------------------------------

--
-- Table structure for table `contact_reports`
--

CREATE TABLE `contact_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iso3` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numeric_code` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iso2` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phonecode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capital` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'official language',
  `native` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emoji` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emojiU` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `wikiDataId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Rapid API GeoDB Cities',
  `nationality` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `slug`, `iso3`, `numeric_code`, `iso2`, `phonecode`, `capital`, `currency`, `language`, `native`, `emoji`, `emojiU`, `status`, `wikiDataId`, `nationality`, `created_at`, `updated_at`, `deleted_at`) VALUES
(101, 'India', 'india', 'IND', NULL, 'IN', '91', 'New Delhi', 'INR', '{\"eng\":\"English\",\"hin\":\"Hindi\",\"tam\":\"Tamil\"}', 'भारत', '🇮🇳', 'U+1F1EE U+1F1F3', 1, 'Q668', 'Indian', '2018-07-20 09:11:03', '2020-09-22 23:22:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dprs`
--

CREATE TABLE `dprs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `date` date DEFAULT NULL,
  `staps` tinyint(4) DEFAULT 1 COMMENT '1:project,2:subproject,3:activity,4:materials,5:labour,6:assets,7:complete',
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `projects_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sub_projects_id` bigint(20) UNSIGNED DEFAULT NULL,
  `activities_id` bigint(20) UNSIGNED DEFAULT NULL,
  `assets_id` bigint(20) UNSIGNED DEFAULT NULL,
  `labours_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dprs`
--

INSERT INTO `dprs` (`id`, `uuid`, `name`, `date`, `staps`, `is_active`, `projects_id`, `sub_projects_id`, `activities_id`, `assets_id`, `labours_id`, `company_id`, `created_at`, `updated_at`, `user_id`) VALUES
(5, '55cbbc70-9027-4ac7-896d-e82132207c26', '2023-10-31', NULL, 4, 1, 1, 1, NULL, NULL, NULL, 2, '2023-11-28 03:13:32', '2023-11-28 03:13:32', 2),
(6, '0319af8d-0340-49f7-84c6-8327a6d03ad2', '2023-10-311', NULL, 4, 1, 1, 2, NULL, NULL, NULL, 2, '2023-11-28 06:21:41', '2023-11-28 06:21:41', NULL),
(7, '5df3f02a-6c7a-4c94-a459-a4f2bb6635f4', '2024-02-02', NULL, 2, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-02 04:31:46', '2024-02-02 05:39:48', NULL),
(8, 'db1cb630-2dcb-413c-b464-f636744d5eb7', '2024-02-02', NULL, 2, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-02 05:43:28', '2024-02-02 05:43:34', NULL),
(9, 'd1284e16-0ea6-4b9b-a70d-b563e3fbd0c1', '2024-02-02', NULL, 0, 1, NULL, NULL, NULL, NULL, NULL, 2, '2024-02-02 05:47:29', '2024-02-02 05:47:29', NULL),
(10, '40739f1c-af72-4cf2-9e5d-47a902cd768a', '2024-02-02', NULL, 2, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-02 05:47:31', '2024-02-02 05:47:35', NULL),
(11, '681a2349-9431-4422-b795-ca8fc110d3b6', '2024-02-02', NULL, 2, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-02 05:47:57', '2024-02-02 05:48:01', NULL),
(12, 'b951755a-96e3-49ae-8570-c84229c99763', '2024-02-02', NULL, 2, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-02 06:03:07', '2024-02-02 06:03:12', NULL),
(13, '10db26a6-5d69-4477-a4bf-31aa65f0d0d5', '2024-02-02', NULL, 2, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-02 06:11:49', '2024-02-02 06:11:53', NULL),
(14, 'f8378b96-d438-4b38-831a-bfc448ab66b5', '2024-02-02', NULL, 2, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-02 06:13:53', '2024-02-02 06:13:59', NULL),
(15, '0f521dbb-8dab-4bf7-ac60-356450ef21c6', '2024-02-02', NULL, 2, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-02 06:27:13', '2024-02-02 06:27:18', NULL),
(16, '9edf3db7-e0a8-4ba7-9359-4ba4508e9ba1', '2024-02-02', NULL, 2, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-02 06:41:20', '2024-02-02 06:41:24', NULL),
(17, 'd704f00b-9ce4-4218-a94c-33cfd5dee55d', '2024-02-02', NULL, 0, 1, NULL, NULL, NULL, NULL, NULL, 2, '2024-02-02 06:44:13', '2024-02-02 06:44:13', NULL),
(18, 'dee30c8e-52cb-49bd-9e48-94256f030a97', '2024-02-02', NULL, 2, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-02 06:44:15', '2024-02-02 06:44:19', NULL),
(19, 'c90f22bd-a1ac-4ed0-a2f6-710e9e953734', '2024-02-02', NULL, 2, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-02 07:09:36', '2024-02-02 07:09:41', NULL),
(20, '77070a9a-2eed-44e4-9334-77ab9ffdb8d9', '2024-02-02', NULL, 2, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-02 07:26:24', '2024-02-02 07:26:28', NULL),
(21, '96ec4aa4-063d-44cf-bd2e-0e42bafca415', '2024-02-02', NULL, 2, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-02 08:01:20', '2024-02-02 08:01:25', NULL),
(22, '67407cb4-fb94-4e55-a3f4-628559beb985', '2024-02-02', NULL, 0, 1, NULL, NULL, NULL, NULL, NULL, 2, '2024-02-02 08:50:38', '2024-02-02 08:50:38', NULL),
(23, '2a8b8788-495a-43ec-a091-7b5cd2d6f160', '2024-02-02', NULL, 2, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-02 08:51:57', '2024-02-02 08:52:01', NULL),
(24, 'dd7c825e-a751-4181-85cd-35db242b330c', '2024-02-05', NULL, 2, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-05 02:05:19', '2024-02-05 02:05:25', NULL),
(25, 'a9f5deb5-bc42-4cb2-b770-efa0b0b022e8', '2024-02-05', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-05 02:44:44', '2024-02-05 02:44:48', NULL),
(26, '74c865b8-9a8c-437b-8cb6-df3517022a19', '2024-02-05', NULL, 3, 1, NULL, 1, NULL, NULL, NULL, 2, '2024-02-05 03:45:35', '2024-02-05 04:14:56', NULL),
(27, '5080bdbf-5b28-4c95-a400-526e91a1c38f', '2024-02-05', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-05 04:46:02', '2024-02-05 04:46:06', NULL),
(28, '3f1be962-53ee-4283-ac2f-98dab3927d60', '2024-02-11', NULL, 2, 1, 5, NULL, NULL, NULL, NULL, 2, '2024-02-11 12:55:35', '2024-02-11 12:55:41', NULL),
(29, 'a3e90245-cce6-4707-b8ce-6f52c20839d1', '2024-02-12', NULL, 0, 1, NULL, NULL, NULL, NULL, NULL, 2, '2024-02-12 03:00:33', '2024-02-12 03:00:33', NULL),
(30, '01184bd2-12a3-46e6-8baf-276341aec10b', '2024-02-12', NULL, 0, 1, NULL, NULL, NULL, NULL, NULL, 2, '2024-02-12 03:01:02', '2024-02-12 03:01:02', NULL),
(31, '2127e5bf-3ce9-49c3-a5a8-98d86bb82026', '2024-02-12', NULL, 2, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-12 03:01:12', '2024-02-12 03:01:17', NULL),
(32, '43616f8c-fdd6-4453-b039-c8b72ee9b572', '2024-02-12', NULL, 2, 1, 1, 3, NULL, NULL, NULL, 2, '2024-02-12 03:05:06', '2024-02-12 03:05:09', NULL),
(33, '002d8fe3-2393-45fc-b275-9916584a22f0', '2024-02-13', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-13 01:15:26', '2024-02-13 01:15:35', NULL),
(34, '897fbd7a-da1b-4a52-bf44-8f456e40e85b', '2024-02-13', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-13 01:17:30', '2024-02-13 01:17:35', NULL),
(35, 'c42b454d-056b-4a79-9dd9-289efdb44eef', '2024-02-13', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-13 01:19:50', '2024-02-13 01:19:54', NULL),
(36, 'f97213e7-7c3e-43f0-a40a-fea959cecec1', '2024-02-15', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-15 07:11:30', '2024-02-15 07:11:38', NULL),
(37, 'b5e3d47e-0bf9-444a-92a3-97484e6d428d', '2024-02-15', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-15 08:35:22', '2024-02-15 08:39:14', NULL),
(38, '4ab9c635-ae5c-4853-9e06-7dd4ccebe148', '2024-02-15', NULL, 2, 1, 1, NULL, NULL, NULL, NULL, 2, '2024-02-15 09:44:44', '2024-02-15 09:44:46', NULL),
(39, '3d755c7d-6095-4b24-9ca7-cbaf0429cd5e', '2024-02-16', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-16 01:56:08', '2024-02-16 01:56:14', NULL),
(40, '1be30d0d-5eb3-48f7-9f52-28d3871e389a', '2024-02-16', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 2, '2024-02-16 02:21:20', '2024-02-16 02:21:20', NULL),
(41, 'f71c83c2-57d6-4e6f-baf4-0b6ef41c3830', '2024-02-16', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-16 02:26:17', '2024-02-16 02:26:22', NULL),
(42, '4b47f0be-0526-435e-90fa-c7a31f56d7ee', '2024-02-16', NULL, 2, 1, 1, NULL, NULL, NULL, NULL, 2, '2024-02-16 02:43:23', '2024-02-16 02:53:20', NULL),
(43, 'a2364d68-dde6-49fe-a725-205c388269e9', '2024-02-16', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 2, '2024-02-16 04:04:46', '2024-02-16 04:04:46', NULL),
(44, '0a59622b-f80e-475f-a20b-0f59dee0e299', '2024-02-16', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-16 04:10:06', '2024-02-16 04:10:10', NULL),
(45, '37719426-550e-400d-9df2-30c2ab1d051d', '2024-02-16', NULL, 3, 1, 5, 3, NULL, NULL, NULL, 2, '2024-02-16 08:07:10', '2024-02-16 08:13:01', NULL),
(46, 'da8d3163-a78c-4178-a6ce-d7a792ab27f4', '2024-02-16', NULL, 3, 1, 1, 4, NULL, NULL, NULL, 2, '2024-02-16 08:15:33', '2024-02-16 08:15:39', NULL),
(47, '530650be-2f9b-4932-8c77-fd7798a2d6a6', '2024-02-16', NULL, 3, 1, 1, 4, NULL, NULL, NULL, 2, '2024-02-16 08:25:03', '2024-02-16 08:25:06', NULL),
(48, 'cf5b25d9-c7eb-489a-aed1-1d6f8ddce1c5', '2024-02-16', NULL, 3, 1, 5, 13, NULL, NULL, NULL, 2, '2024-02-16 09:58:57', '2024-02-16 09:59:03', NULL),
(49, 'bd926a30-af20-4fd5-a32f-e3c785815a0c', '2024-02-16', NULL, 3, 1, 5, 3, NULL, NULL, NULL, 2, '2024-02-16 09:59:27', '2024-02-16 09:59:57', NULL),
(50, '7f7617c2-d817-4af4-9a7a-b786a12d34f5', '2024-02-17', NULL, 3, 1, 1, 8, NULL, NULL, NULL, 2, '2024-02-17 04:08:52', '2024-02-17 04:09:34', NULL),
(51, 'b2343bc4-85e6-4d7b-8734-a15ea18b8d00', '2024-02-17', NULL, 3, 1, 1, 8, NULL, NULL, NULL, 2, '2024-02-17 09:38:27', '2024-02-17 09:38:55', NULL),
(52, 'fc039068-bedb-4d32-9207-bd0eaad5ce35', '2024-02-17', NULL, 2, 1, 1, NULL, NULL, NULL, NULL, 2, '2024-02-17 09:46:02', '2024-02-17 09:46:03', NULL),
(53, '877c8341-d357-4763-98ae-5ed3afc0d351', '2024-02-17', NULL, 3, 1, 1, 8, NULL, NULL, NULL, 2, '2024-02-17 09:51:24', '2024-02-17 09:51:30', NULL),
(54, '42e1ed7e-7a73-4a18-b0ce-0e76ce126716', '2024-02-17', NULL, 3, 1, 1, 8, NULL, NULL, NULL, 2, '2024-02-17 09:53:49', '2024-02-17 09:53:52', NULL),
(55, 'c773c096-62c9-488b-b8b8-dc6a27758b0b', '2024-02-17', NULL, 3, 1, 1, 8, NULL, NULL, NULL, 2, '2024-02-17 09:53:56', '2024-02-17 09:54:00', NULL),
(56, '6dfacc50-47eb-4975-b6a6-baa9b4fcb900', '2024-02-21', NULL, 3, 1, 1, 4, NULL, NULL, NULL, 2, '2024-02-21 00:46:59', '2024-02-21 00:47:09', NULL),
(57, 'e60bafbf-a5f7-4e8b-955f-aa77a140e7e2', '2024-02-21', NULL, 7, 1, 1, 4, NULL, NULL, NULL, 2, '2024-02-21 01:22:43', '2024-02-21 01:22:49', NULL),
(58, 'd71e7475-3d3e-45ea-ba89-80d303fa6d05', '2024-02-21', NULL, 7, 1, 1, 4, NULL, NULL, NULL, 2, '2024-02-21 02:30:42', '2024-02-21 02:30:48', NULL),
(59, '59da4763-9d55-44a2-a446-d7277775fbe8', '2024-02-22', NULL, 2, 1, 1, NULL, NULL, NULL, NULL, 2, '2024-02-22 03:58:00', '2024-02-22 03:58:08', NULL),
(60, '4caa7bae-59a8-47a3-97cd-6e8f75d2b142', '2024-02-22', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 2, '2024-02-22 04:11:47', '2024-02-22 04:11:47', NULL),
(61, '65588dea-4e06-4595-a2fe-71ce35cf50b6', '2024-02-22', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-22 04:11:50', '2024-02-22 04:12:16', NULL),
(62, 'cc957c4f-bba0-4024-9b97-775256684c4e', '2024-02-22', NULL, 3, 1, 1, 3, NULL, NULL, NULL, 2, '2024-02-22 08:53:59', '2024-02-22 08:54:06', NULL),
(63, '3319ae96-3caa-45bc-83b6-79c5be104d51', '2024-02-22', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-22 08:56:34', '2024-02-22 09:06:27', NULL),
(64, 'd14ce1ca-a71e-42ad-9cbc-08ddc3186980', '2024-02-23', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-23 01:19:52', '2024-02-23 01:20:36', NULL),
(65, '15f7b776-c19c-40ac-9947-35a59941ca89', '2024-02-23', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-23 02:13:35', '2024-02-23 02:13:41', NULL),
(66, '436dd1cc-2219-476e-a6b5-fd620a9f9fa9', '2024-02-23', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-23 03:43:35', '2024-02-23 03:43:40', NULL),
(67, '5c4f1462-6b74-48b2-82e5-6a1164685f79', '2024-02-23', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-23 03:59:28', '2024-02-23 03:59:32', NULL),
(68, '6ab207af-e10e-46af-8987-8bc71a0228ca', '2024-02-23', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-23 04:13:13', '2024-02-23 04:13:19', NULL),
(69, '32190bb1-860a-4cd2-9aa8-cb034ca37bda', '2024-02-23', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-23 05:09:47', '2024-02-23 05:29:00', NULL),
(70, '58c49655-f8fe-4856-9e2d-064295ddb8ae', '2024-02-23', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-23 05:42:11', '2024-02-23 05:42:17', NULL),
(71, '44101e18-67b5-428c-b8ba-a31f1b18be6f', '2024-02-23', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-23 05:43:14', '2024-02-23 05:43:19', NULL),
(72, '55de7055-a109-4a1e-8638-5d0a6fb79a72', '2024-02-23', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-23 06:07:52', '2024-02-23 06:07:56', NULL),
(73, 'b5b053a5-e555-4fbf-975b-db20aba972ac', '2024-02-23', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-23 06:12:24', '2024-02-23 06:12:27', NULL),
(74, '094f2138-c95c-4cf4-80ca-34f146ce514d', '2024-02-23', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-23 06:16:25', '2024-02-23 06:16:29', NULL),
(75, '690a42c2-f464-4667-810e-6dd5fad860c7', '2024-02-23', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-23 06:45:23', '2024-02-23 06:45:26', NULL),
(76, '77505bf9-fea5-4c7a-adb3-736495155f77', '2024-02-23', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 2, '2024-02-23 07:02:35', '2024-02-23 07:02:35', NULL),
(77, '74e7f749-5f04-4575-b52e-f99e8a3d50a8', '2024-02-23', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-23 07:02:39', '2024-02-23 07:02:44', NULL),
(78, 'e66b03b9-817b-470f-88a7-322b7b262ff3', '2024-02-23', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-23 07:15:34', '2024-02-23 07:15:39', NULL),
(79, '0e920282-cd32-463d-86af-4a9cf3c8b034', '2024-02-23', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-23 07:51:33', '2024-02-23 07:51:38', NULL),
(80, '160d0272-d295-4253-ad95-365804c3b92e', '2024-02-23', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-23 08:52:52', '2024-02-23 08:52:59', NULL),
(81, '5b953013-e105-4446-8a18-91614ee921a5', '2024-02-23', NULL, 2, 1, 1, NULL, NULL, NULL, NULL, 2, '2024-02-23 08:57:28', '2024-02-23 08:57:30', NULL),
(82, '5988713f-7ed5-4d8b-9311-d0cbc55809fa', '2024-02-23', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-23 08:57:35', '2024-02-23 08:57:40', NULL),
(83, '2799e582-4f35-4770-83a9-bbe7615b43e0', '2024-02-23', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 2, '2024-02-23 08:58:39', '2024-02-23 08:58:39', NULL),
(84, 'f9ee89f9-69c7-483d-a5bf-76e1d621735a', '2024-02-23', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-23 08:58:43', '2024-02-23 08:58:47', NULL),
(85, '78c8deee-a469-44a0-a7e0-f6460211ea16', '2024-02-23', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-23 09:14:17', '2024-02-23 09:14:21', NULL),
(86, 'fbdf64cd-e6bb-4973-9531-60874810f5af', '2024-02-26', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-26 01:26:10', '2024-02-26 01:31:56', NULL),
(87, '577265f7-94c5-42f5-9005-e30730e37f60', '2024-02-26', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-26 02:22:24', '2024-02-26 02:22:31', NULL),
(88, '14c508ba-c09b-40eb-911e-3b6023ddd3a2', '2024-02-26', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-26 05:30:59', '2024-02-26 05:31:04', NULL),
(89, '95a22736-b78e-432b-bba2-66d991dced11', '2024-02-26', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-26 05:57:47', '2024-02-26 05:57:51', NULL),
(90, '03e6ea0d-6d03-4e68-9570-0bcbb2357127', '2024-02-26', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-26 05:58:52', '2024-02-26 05:58:56', NULL),
(91, '5d9ebd5c-0e19-4d46-93f6-c5b5187ec75c', '2024-02-26', NULL, 2, 1, 1, NULL, NULL, NULL, NULL, 2, '2024-02-26 06:00:29', '2024-02-26 06:00:30', NULL),
(92, 'f06327c7-1fc6-4c33-bd18-19feb1d8d6ba', '2024-02-26', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-26 06:00:35', '2024-02-26 06:00:39', NULL),
(93, 'f631730d-110e-489a-a92d-b07bb9adc396', '2024-02-26', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 2, '2024-02-26 06:01:11', '2024-02-26 06:01:11', NULL),
(94, 'f5533a79-31d6-4f5b-ba1b-cfa280f7329f', '2024-02-26', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-26 06:01:14', '2024-02-26 06:01:19', NULL),
(95, '997e5599-60dc-4be1-b3ae-cc5ecc09f5af', '2024-02-26', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-26 07:50:02', '2024-02-26 07:50:07', 2),
(96, '3ffe6079-1eb1-4b62-b3cd-86352d948858', '2024-02-26', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-26 08:14:01', '2024-02-26 08:14:05', 2),
(97, '479f2cec-6d78-4057-9979-d3065b7b58ad', '2024-02-26', NULL, 2, 1, 1, NULL, NULL, NULL, NULL, 2, '2024-02-26 08:27:41', '2024-02-26 08:27:42', 2),
(98, 'eff0ceca-b616-4c26-9595-45e15bf41d54', '2024-02-26', NULL, 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-02-26 08:27:45', '2024-02-26 08:27:48', 2),
(99, 'e2b89fa0-898a-4bf5-a165-25518c479586', '2024-02-26', NULL, 2, 1, 1, NULL, NULL, NULL, NULL, 2, '2024-02-26 08:29:47', '2024-02-26 08:46:33', 2),
(100, 'ae40e4c6-b38c-4eb4-80a0-7f0d99e06841', '2024-02-26', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 2, '2024-02-26 08:58:16', '2024-02-26 08:58:16', NULL),
(101, 'b696df94-b7f2-492a-9052-c9b937e7260d', '2024-02-26', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 2, '2024-02-26 09:02:54', '2024-02-26 09:02:54', NULL),
(102, 'bffaa944-2197-4893-b92e-ab7204a1667e', '2024-02-26', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 2, '2024-02-26 09:05:34', '2024-02-26 09:05:34', NULL),
(103, '319c1503-e5c0-4902-91fa-feb49079a3e4', '2024-02-26', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 2, '2024-02-26 09:06:12', '2024-02-26 09:06:12', NULL),
(104, 'f68a95b8-b073-4cb0-b4b9-332cf5709a82', '2024-02-26', NULL, 2, 1, NULL, NULL, NULL, NULL, NULL, 2, '2024-02-26 09:06:23', '2024-02-26 09:07:37', NULL),
(105, 'c6ee7554-ef16-4dd5-a485-f3e6fd7b2b80', '2024-02-26', NULL, 2, 1, NULL, NULL, NULL, NULL, NULL, 2, '2024-02-26 09:10:26', '2024-02-26 09:10:42', 3),
(106, 'a910f8e7-aaff-4f79-81ae-76828f1935e3', '2024-02-27', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 2, '2024-02-27 02:19:13', '2024-02-27 02:19:13', 1),
(109, 'c932e1ea-c7cc-49cd-b4ba-8e7fc497866b', '2023-10-31', '2024-03-01', 1, 1, NULL, NULL, NULL, NULL, NULL, 2, '2024-03-01 01:21:33', '2024-03-01 03:57:28', 1),
(110, 'a7ecc431-87ca-48ec-bdc8-5d12e7a662ae', '2024-03-06', '2024-03-06', 1, 1, NULL, NULL, NULL, NULL, NULL, 2, '2024-03-04 01:31:04', '2024-03-04 01:31:04', 2),
(111, '1cc97cd4-9f7e-4d52-bd4b-cf3a8f3f3fe7', '2024-03-06', '2024-03-06', 1, 1, NULL, NULL, NULL, NULL, NULL, 2, '2024-03-06 06:03:56', '2024-03-06 06:03:56', 2),
(112, 'fd268dd8-c492-4838-8266-5b0fdd1b93e9', '2024-03-07', '2024-03-07', 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-03-07 04:50:51', '2024-03-07 09:16:33', 2),
(113, '4f03cac7-76af-4e14-ae50-8476b542ff43', '2024-03-12', '2024-03-12', 3, 1, 27, 19, NULL, NULL, NULL, 2, '2024-03-12 04:49:32', '2024-03-12 11:36:06', 2),
(114, '6d750102-aac6-487f-9cdb-a148eaa808cc', '2024-03-13', '2024-03-13', 1, 1, NULL, NULL, NULL, NULL, NULL, 2, '2024-03-13 05:21:16', '2024-03-13 05:21:16', 2),
(115, 'bb500d09-49e1-4515-8bc4-648ae34dc4a9', '2024-03-18', '2024-03-18', 1, 1, NULL, NULL, NULL, NULL, NULL, 2, '2024-03-18 04:42:40', '2024-03-18 04:42:40', 2),
(116, '94678098-7559-4239-8261-6ea06af13720', '2024-03-20', '2024-03-20', 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-03-20 02:30:05', '2024-03-20 02:30:05', 2),
(117, '06201e10-f716-41fb-829e-b08c07667117', '2024-03-20', '2024-03-20', 3, 1, 2, 2, NULL, NULL, NULL, 1, '2024-03-20 06:07:11', '2024-03-20 06:07:11', 2),
(118, 'c3207eaa-a0cc-429c-a28c-eeb7c800a29c', '2024-03-22', '2024-03-22', 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-03-22 06:10:30', '2024-03-22 06:10:30', 2),
(120, '040ebb0b-bc2c-4361-b62d-978d395dd057', '2024-04-02', '2024-04-02', 3, 1, 1, 13, NULL, NULL, NULL, 1, '2024-04-02 07:05:15', '2024-04-02 07:05:15', 2),
(126, '155e7b50-14ec-4b4d-8e40-cb4ca93e1766', '2024-03-07', '2024-04-02', 3, 1, 1, 8, NULL, NULL, NULL, 1, '2024-04-02 09:06:50', '2024-04-02 09:06:50', 2),
(127, '9c281217-b3d7-417f-a777-545357b1bb6e', '2024-04-02', '2024-04-02', 3, 1, 2, 2, NULL, NULL, NULL, 1, '2024-04-02 09:07:19', '2024-04-02 09:07:19', 2),
(128, '6ca4c104-b6b1-40d1-9173-01a3e9debc1d', '2024-04-02', '2024-04-02', 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-04-02 09:08:16', '2024-04-02 09:08:16', 2),
(129, '310e9598-22af-47ec-b114-0e2e5fce8ec2', '2024-04-03', '2024-04-03', 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-04-03 00:12:14', '2024-04-03 00:12:14', 2),
(130, '0a6fd867-9c01-4bf1-8187-ccc58e32dbae', '2024-04-04', '2024-04-04', 3, 1, 1, 13, NULL, NULL, NULL, 2, '2024-04-04 08:04:54', '2024-04-04 08:04:54', 2),
(131, '29e0b2a9-92c3-49ad-8845-2f934f20395d', '2024-04-04', '2024-04-04', 3, 1, 29, 20, NULL, NULL, NULL, 2, '2024-04-04 08:06:52', '2024-04-04 08:06:52', 2),
(132, '81566809-6359-4eaf-a253-1182745db7e3', '2024-04-08', '2024-04-08', 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-04-08 04:53:53', '2024-04-08 04:53:53', 2),
(133, '8e69837c-decb-49e4-bc41-80abaaa5c5e3', '2024-04-08', '2024-04-08', 3, 1, 1, 8, NULL, NULL, NULL, 2, '2024-04-08 05:21:20', '2024-04-08 05:21:20', 2),
(134, '5058214d-0f07-4e72-9fc9-e4e784388d70', '2024-04-09', '2024-04-09', 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-04-08 23:33:26', '2024-04-08 23:33:26', 2),
(135, '500f2618-8e3d-41eb-b4d2-5e81ec78010f', '2024-04-17', '2024-04-17', 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-04-17 06:26:35', '2024-04-17 06:26:35', 2),
(137, '715008f1-3e4c-4372-ba5e-5f3e7eacbd3d', '2024-04-22', '2024-04-22', 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-04-22 05:51:49', '2024-04-22 05:51:49', 2),
(138, 'e154eabc-73b9-40c9-b3e0-8a989a567385', '2024-04-26', '2024-04-26', 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-04-26 02:29:45', '2024-04-26 02:29:45', 2),
(139, '8f0823e9-078c-4fb9-9d6a-a2ae780275be', '2024-04-30', '2024-04-30', 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-04-30 00:27:45', '2024-04-30 00:27:45', 2),
(140, '826adb99-de80-4787-adf3-61fa81b7a9a6', '2024-05-02', '2024-05-02', 3, 1, 1, 1, NULL, NULL, NULL, 2, '2024-05-02 08:38:20', '2024-05-02 08:38:20', 2);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flights`
--

CREATE TABLE `flights` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `goods`
--

CREATE TABLE `goods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `specification` varchar(255) DEFAULT NULL,
  `material_class` varchar(255) DEFAULT NULL,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hinderances`
--

CREATE TABLE `hinderances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `company_users_id` bigint(20) UNSIGNED DEFAULT NULL,
  `projects_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sub_projects_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `dpr_id` bigint(20) UNSIGNED DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hinderances`
--

INSERT INTO `hinderances` (`id`, `uuid`, `name`, `date`, `details`, `remarks`, `company_users_id`, `projects_id`, `sub_projects_id`, `company_id`, `dpr_id`, `img`, `is_active`, `created_at`, `updated_at`) VALUES
(4, 'eece9db5-cded-4b10-a036-667badf943d1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 5, NULL, 1, '2023-11-28 06:23:26', '2023-11-28 06:23:26'),
(5, 'ab9afc00-ab84-4078-a32d-909310cae6f6', 'test hinderance', '2024-04-02', 'Test hinderance', 'test hinderance remarks', 2, 1, 1, 2, 6, NULL, 1, '2024-02-01 08:23:23', '2024-02-01 08:23:23'),
(6, '8ce28514-a868-40fc-aec7-5a7b46e247d3', NULL, '2024-02-22', '22 one', '22 remark', 29, 1, 1, 2, 63, '17086136555.jpg', 1, '2024-02-22 09:24:15', '2024-02-22 09:24:15'),
(7, 'ca109c4f-3a28-4673-a4f2-445453b57e82', 'test hinderance', '2024-04-02', 'Test hinderance', 'test hinderance remarks', 2, 1, 1, 2, 6, NULL, 1, '2024-02-23 02:13:36', '2024-02-23 02:13:36'),
(8, '5f565c34-734d-4ee2-98f7-9fd052831ab3', 'test hinderance', '2024-04-02', '\"Test hinderance\"', '\"test hinderance remarks\"', 4, 1, 3, 2, 5, '170867528036.png', 1, '2024-02-23 02:31:20', '2024-02-23 02:31:20'),
(9, '1ae39435-3613-4662-a59b-ea4d829eab69', NULL, '2024-02-23', 'hello 23', '23 re', 29, 1, 1, 2, 65, '170867577427.jpg', 1, '2024-02-23 02:39:34', '2024-02-23 02:39:34'),
(10, 'a7379ab7-b903-46d4-82df-3ed87e4df861', NULL, '2024-03-04', 'rainfall', 'no excavation', 29, 23, 15, 2, 110, '170956639052.jpg', 1, '2024-03-04 10:03:10', '2024-03-04 10:03:10'),
(11, 'c94341b7-081b-4ba4-b127-a3c8663e0053', NULL, '2024-03-12', 'rainfall', 'excavation', 29, 27, 19, 2, 113, '171026343919.jpg', 1, '2024-03-12 11:40:39', '2024-03-12 11:40:39');

-- --------------------------------------------------------

--
-- Table structure for table `home_pages`
--

CREATE TABLE `home_pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `block_title` varchar(255) DEFAULT NULL,
  `content_title` varchar(255) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `is_approve` tinyint(4) DEFAULT 1 COMMENT '0:Unapproved,1:Approved',
  `is_blocked` tinyint(4) DEFAULT 0 COMMENT '0:Unblocked,1:Blocked',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_pages`
--

INSERT INTO `home_pages` (`id`, `uuid`, `name`, `slug`, `block_title`, `content_title`, `content`, `img`, `is_active`, `is_approve`, `is_blocked`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '5b0b39e7-724e-4387-904c-3bfd24d3e510', 'banner section', 'banner-section', NULL, NULL, NULL, NULL, 1, 1, 0, '2023-09-21 11:16:51', '2023-09-21 11:16:51', NULL),
(2, '2ba99559-5c27-472a-9c02-7e5927970892', 'section one', 'section-one', 'section 1', 'section 1', '<section class=\"common\">\n    <div class=\"row no-gutters align-items-end\">\n      <div class=\"col col-md-6\">\n        <img src=\"assets/images/one.png\" alt=\"\">\n      </div>\n\n      <div class=\"col col-md-6\">\n        <div class=\"common_sec_contnt\">\n          <h5>WELCOME TO KONCITE</h5>\n          <h2>How does it work?</h2>\n          <p>\n            sed diam voluptua vero eos Loripsum dolor stit amet coadipscing elitr,\n            rumy tinvidunt ut labore Loripsum dolor stit amet, coadipscing elitr rsed diano\n            eirmod tinvidunt ut labore et dolore magna aliquyam erat sed diam voluptua vero eos.\n          </p>\n          <a href=\"\">Learn More</a>\n        </div>\n      </div>\n    </div>\n  </section>', NULL, 1, 1, 0, '2023-09-21 11:16:51', '2023-09-22 11:45:06', NULL),
(3, 'f05c379c-25d8-495f-a1ad-f8ea9347b895', 'section two', 'section-two', 'section 2', 'section 2', '<section class=\"content-only-card\">\r\n    <div class=\"row no-gutters\">\r\n      <div class=\"col-sm-3 col-md-3\">\r\n        <div class=\"sec-card\">\r\n          <h3>Business Owners</h3>\r\n          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.\r\n            Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,</p>\r\n          <img src=\"assets/images/ribon.svg\" alt=\"\">\r\n        </div>\r\n      </div>\r\n\r\n      <div class=\"col-sm-3 col-md-3\">\r\n        <div class=\"sec-card\">\r\n          <h3>Project & Planning managers</h3>\r\n          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.\r\n            Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,</p>\r\n        </div>\r\n      </div>\r\n\r\n      <div class=\"col-sm-3 col-md-3\">\r\n        <div class=\"sec-card\">\r\n          <h3>Procurement & Purchase managers</h3>\r\n          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.\r\n            Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,</p>\r\n        </div>\r\n      </div>\r\n\r\n      <div class=\"col-sm-3 col-md-3\">\r\n        <div class=\"sec-card\">\r\n          <h3>Site Engineers & Supervisors</h3>\r\n          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.\r\n            Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,</p>\r\n        </div>\r\n      </div>\r\n    </div>\r\n  </section>', NULL, 1, 1, 0, '2023-09-21 11:16:51', '2023-09-22 11:49:46', NULL),
(4, '895c8c0d-2332-4a9b-b14a-3a89ee6dc7eb', 'section three', 'section-three', 'section 3', 'section 3', '<section class=\"common common-even\">\r\n    <div class=\"row no-gutters  justify-content-end\">\r\n\r\n      <div class=\"col col-md-6\">\r\n        <div class=\"common_sec_contnt\">\r\n          <h5>WE PROVIDE</h5>\r\n          <h2>Drive Quality Assurance</h2>\r\n          <p>\r\n            sed diam voluptua vero eos Loripsum dolor stit\r\n            amet coadipscing elitr, rumy tinvidunt ut labore\r\n            Loripsum dolor stit amet, coadipscing elitr rsed diano eirmod tinvidunt ut\r\n            labore et dolore magna aliquyam erat sed diam voluptua vero eos.\r\n          </p>\r\n          <a href=\"\">See Pricing Plans</a>\r\n        </div>\r\n      </div>\r\n\r\n\r\n      <div class=\"col col-md-6\">\r\n        <img src=\"assets/images/two.png\" alt=\"\">\r\n      </div>\r\n\r\n\r\n    </div>\r\n  </section>', NULL, 1, 1, 0, '2023-09-21 11:16:51', '2023-09-22 11:50:20', NULL),
(5, '1ecc7963-8f3c-4f3a-8228-a408a679a04c', 'section fourth ', 'section-fourth', 'section 4', 'section 4', '<section class=\"common bg-new\">\r\n    <div class=\"row no-gutters align-items-end\">\r\n      <div class=\"col col-md-6\">\r\n        <img src=\"assets/images/three.png\" alt=\"\">\r\n      </div>\r\n\r\n      <div class=\"col col-md-6\">\r\n        <div class=\"common_sec_contnt\">\r\n          <h5>CHECK YOUR</h5>\r\n          <h2>Track Progress & Resources</h2>\r\n          <p>\r\n            sed diam voluptua vero eos Loripsum dolor\r\n            stit amet coadipscing elitr, rumy tinvidunt\r\n            ut labore Loripsum dolor stit amet, coadipscing\r\n            elitr rsed diano eirmod tinvidunt ut\r\n            labore et dolore magna aliquyam erat sed diam voluptua vero eos.\r\n          </p>\r\n          <a href=\"\">Schedule a demo</a>\r\n        </div>\r\n      </div>\r\n    </div>\r\n  </section>', NULL, 1, 1, 0, '2023-09-21 11:16:51', '2023-09-22 11:50:53', NULL),
(6, '4a4c0a7f-7846-4acc-9c64-df5104a07633', 'section five', 'section-five', NULL, NULL, NULL, NULL, 1, 1, 0, '2023-09-21 11:16:51', '2023-09-21 11:16:51', NULL),
(7, 'f4d48d23-d342-441b-9ef9-e00190da3d68', 'section six', 'section-six', NULL, NULL, NULL, NULL, 1, 1, 0, '2023-09-21 11:16:51', '2023-09-21 11:16:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `projects_id` bigint(20) UNSIGNED DEFAULT NULL,
  `store_warehouses_id` bigint(20) UNSIGNED DEFAULT NULL,
  `materials_id` bigint(20) UNSIGNED DEFAULT NULL,
  `activities_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date` date DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `assets_id` bigint(20) UNSIGNED DEFAULT NULL,
  `recipt_qty` varchar(255) DEFAULT NULL,
  `reject_qty` int(11) DEFAULT NULL,
  `total_qty` int(11) DEFAULT NULL,
  `price` decimal(9,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventories`
--

INSERT INTO `inventories` (`id`, `uuid`, `projects_id`, `store_warehouses_id`, `materials_id`, `activities_id`, `user_id`, `date`, `type`, `qty`, `remarks`, `company_id`, `is_active`, `created_at`, `updated_at`, `assets_id`, `recipt_qty`, `reject_qty`, `total_qty`, `price`) VALUES
(22, '49c248ba-7fea-4f8e-bec9-c226d8a2adcc', 1, NULL, NULL, NULL, 2, '2024-04-16', 'machines', NULL, 'eeeeeeeeeeeeeeeeeeeeeeeeeeeeee', 2, 1, '2024-04-16 10:11:04', '2024-04-16 10:11:04', 1, '144', 44, 100, '5.000'),
(23, '92039019-7895-4561-8f9b-750ac8e98e2e', 2, NULL, NULL, NULL, 2, '2024-04-16', 'machines', NULL, 'eeeeeeeeeeeeeeeeeeeeeeeeeeeeee', 2, 1, '2024-04-16 10:11:04', '2024-05-04 00:15:34', 1, '144', 44, 388, '5.000'),
(24, 'a6c07fc3-f9be-4cc9-812a-392a32494605', 1, NULL, 9, NULL, 2, '2024-04-16', 'materials', NULL, 'eeeeeeeeeeeeeeeeeeeeeeeeeeeeee', 2, 1, '2024-04-16 10:11:32', '2024-05-03 08:26:43', NULL, '144', 44, 234, '12.000'),
(25, 'afefef47-137d-41d8-bcdb-62ac2a83edef', 2, NULL, 8, NULL, 2, '2024-04-16', 'materials', NULL, 'eeeeeeeeeeeeeeeeeeeeeeeeeeeeee', 2, 1, '2024-04-16 10:11:32', '2024-04-16 10:12:07', NULL, '144', 44, 224, '5.000'),
(26, 'b268647b-a30c-452b-b1f6-2b23136c2ffa', 1, NULL, 5, NULL, 2, '2024-05-03', 'materials', NULL, 'Ok', 2, 1, '2024-05-03 08:17:39', '2024-05-03 08:17:39', NULL, '10', 5, 5, '36.000'),
(27, 'e4876571-1711-447d-b415-e005613486b0', 1, NULL, 11, NULL, 2, '2024-05-04', 'materials', NULL, '', 2, 1, '2024-05-04 00:11:05', '2024-05-04 00:15:02', NULL, NULL, NULL, -30, '0.000'),
(28, '9c9c97db-f724-423a-8441-f7a6f57b875b', 1, NULL, 22, NULL, 2, '2024-05-04', 'materials', NULL, '', 2, 1, '2024-05-04 00:24:32', '2024-05-04 00:24:32', NULL, '10', NULL, NULL, '0.000'),
(29, '782c416c-24ee-4a12-8797-6449785c7058', 1, NULL, 23, NULL, 2, '2024-05-04', 'materials', NULL, '', 2, 1, '2024-05-04 00:26:04', '2024-05-04 00:26:34', NULL, '10', NULL, 10, '0.000');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_stores`
--

CREATE TABLE `inventory_stores` (
  `inventories_id` bigint(20) UNSIGNED DEFAULT NULL,
  `store_warehouses_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_stores`
--

INSERT INTO `inventory_stores` (`inventories_id`, `store_warehouses_id`) VALUES
(16, 3),
(16, 1),
(17, 4),
(18, 3),
(18, 1),
(19, 4),
(20, 3),
(20, 1),
(21, 4),
(22, 3),
(22, 1),
(23, 4),
(24, 3),
(24, 1),
(25, 4),
(26, 1),
(27, 1),
(28, 1),
(29, 1);

-- --------------------------------------------------------

--
-- Table structure for table `inv_inwards`
--

CREATE TABLE `inv_inwards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `projects_id` bigint(20) UNSIGNED DEFAULT NULL,
  `store_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inv_inwards`
--

INSERT INTO `inv_inwards` (`id`, `uuid`, `name`, `date`, `details`, `remarks`, `projects_id`, `store_id`, `user_id`, `company_id`, `is_active`, `created_at`, `updated_at`) VALUES
(16, '1c7fff65-8ec7-43b1-958f-2f9cb8ed4d27', '2024-04-17', '2024-04-17', NULL, NULL, 1, NULL, 2, 2, 1, '2024-04-17 09:08:03', '2024-04-17 09:08:03'),
(17, 'fb336ab6-daee-4396-8e47-5dc068f82386', '2024-05-01', '2024-05-01', NULL, NULL, 1, NULL, 2, 2, 1, '2024-05-01 01:46:18', '2024-05-01 01:46:18'),
(18, '795dce89-2ff1-439a-a04a-fb7b620f18fd', '2024-05-02', '2024-05-02', NULL, NULL, 1, NULL, 2, 2, 1, '2024-05-02 04:07:36', '2024-05-02 04:07:36'),
(19, 'c9fe421d-9e8a-4a6d-9d96-036e8e02e38d', '2024-05-03', '2024-05-03', NULL, NULL, 1, NULL, 2, 2, 1, '2024-05-03 05:46:30', '2024-05-03 05:46:30');

-- --------------------------------------------------------

--
-- Table structure for table `inv_inward_entry_types`
--

CREATE TABLE `inv_inward_entry_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `remarkes` varchar(255) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inv_inward_entry_types`
--

INSERT INTO `inv_inward_entry_types` (`id`, `uuid`, `name`, `slug`, `remarkes`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '83529032-7900-42c7-a18c-53f67aba37a1', 'Direct', 'direct', NULL, 1, '2024-04-08 09:06:32', '2024-04-08 09:06:32'),
(2, '28e49de4-152a-42d7-8194-85a735dcb53b', 'From PO', 'from-po', NULL, 1, '2024-04-08 09:06:32', '2024-04-08 09:06:32'),
(3, 'ff11676d-9736-40cc-aa42-0f2c00178d12', 'From PR', 'from-pr', NULL, 1, '2024-04-08 09:06:32', '2024-04-08 09:06:32'),
(4, 'b9b32e9b-bbb6-4193-b13b-c53976e0fa6b', 'From Other Project', 'from-other-project', NULL, 1, '2024-04-08 09:06:32', '2024-04-08 09:06:32'),
(5, '45afa502-bfee-4aea-8d22-652a5e2ad7fd', 'Cash Purchase', 'cash-purchase', NULL, 1, '2024-04-08 09:06:32', '2024-04-08 09:06:32'),
(6, 'ab6d0493-f1a9-456e-a19f-f1a8432edfab', 'Same project-other stores', 'same-project-other-stores', NULL, 1, '2024-04-08 09:06:32', '2024-04-08 09:06:32'),
(7, '22378f66-3093-4205-b737-8bdf8962ffad', 'From Client', 'from-client', NULL, 1, '2024-04-08 09:06:32', '2024-04-08 09:06:32'),
(8, 'bdc7d770-87d5-422d-bf0b-5cd8ad641ca6', 'Direct', 'direct-2', NULL, 1, '2024-04-10 02:16:10', '2024-04-10 02:16:10'),
(9, '5072766d-eac0-4270-ba01-beaba958f5b0', 'From PO', 'from-po-2', NULL, 1, '2024-04-10 02:16:10', '2024-04-10 02:16:10'),
(10, '9f40c010-29bb-4648-bc6f-bb5aa4cfc9d2', 'From PR', 'from-pr-2', NULL, 1, '2024-04-10 02:16:10', '2024-04-10 02:16:10'),
(11, 'cbb08a68-d643-418b-9de5-34652fe23a37', 'From Other Project', 'from-other-project-2', NULL, 1, '2024-04-10 02:16:10', '2024-04-10 02:16:10'),
(12, '601c89fd-30ba-44fc-b636-0dbd0a3391f6', 'Cash Purchase', 'cash-purchase-2', NULL, 1, '2024-04-10 02:16:10', '2024-04-10 02:16:10'),
(13, 'e810661d-7541-43ba-b2f8-adf5b44dfdd9', 'Same project-other stores', 'same-project-other-stores-2', NULL, 1, '2024-04-10 02:16:10', '2024-04-10 02:16:10'),
(14, 'bec3758f-e971-48a5-b09d-3d0b3d89c70b', 'From Client', 'from-client-2', NULL, 1, '2024-04-10 02:16:10', '2024-04-10 02:16:10');

-- --------------------------------------------------------

--
-- Table structure for table `inv_issues`
--

CREATE TABLE `inv_issues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `projects_id` bigint(20) UNSIGNED DEFAULT NULL,
  `store_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inv_issues`
--

INSERT INTO `inv_issues` (`id`, `uuid`, `name`, `date`, `details`, `remarks`, `projects_id`, `store_id`, `user_id`, `company_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '96e3cf7b-aa3c-4ab7-8f1d-28666bce89a0', '2024-03-07', '2024-03-21', NULL, NULL, 1, 1, 2, 2, 1, '2024-03-21 02:34:38', '2024-03-21 02:34:38'),
(2, '6649b09f-804e-46c0-a26c-e7efe742142a', '2024-03-07', '2024-04-05', NULL, NULL, 2, NULL, 2, 2, 1, '2024-04-05 05:56:16', '2024-04-05 05:56:16'),
(3, 'f572fb6b-f150-4816-bc4b-7cf950689556', '2024-04-10', '2024-04-10', NULL, NULL, 1, NULL, 2, 2, 1, '2024-04-10 09:02:36', '2024-04-10 09:02:36'),
(4, '0ac09180-66a7-48c6-8faa-e2c7534a601a', '2024-04-15', '2024-04-15', NULL, NULL, 1, NULL, 2, 2, 1, '2024-04-15 04:03:45', '2024-04-15 04:03:45'),
(5, '334b1f80-5c15-48a6-93ed-57cc57557c59', '2024-04-16', '2024-04-16', NULL, NULL, 1, NULL, 2, 2, 1, '2024-04-16 03:07:22', '2024-04-16 03:07:22'),
(6, '66de0b4c-1230-4f8e-b1e6-ed9ba10edb95', '2024-04-17', '2024-04-17', NULL, NULL, 1, NULL, 2, 2, 1, '2024-04-17 00:59:13', '2024-04-17 00:59:13'),
(7, 'e187cf7d-d035-4069-bf33-940cb8b7ef8e', '2024-05-01', '2024-05-01', NULL, NULL, 1, NULL, 2, 2, 1, '2024-05-01 06:57:20', '2024-05-01 06:57:20'),
(8, 'e55f8ce5-8c51-43df-b53e-78b39120e3d5', '2024-05-02', '2024-05-02', NULL, NULL, 1, NULL, 2, 2, 1, '2024-05-02 05:56:33', '2024-05-02 05:56:33'),
(9, '196908a5-15ce-43b3-bcbb-6ed8d93d256f', '2024-05-04', '2024-05-03', NULL, NULL, 1, NULL, 2, 2, 1, '2024-05-03 08:37:33', '2024-05-03 13:04:43'),
(10, '571accc6-119e-4721-a89f-fd4ad5fae2f1', '2024-05-04', '2024-05-04', NULL, NULL, 1, NULL, 2, 2, 1, '2024-05-04 00:00:48', '2024-05-04 00:00:48');

-- --------------------------------------------------------

--
-- Table structure for table `inv_issues_details`
--

CREATE TABLE `inv_issues_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `inv_issue_goods_id` bigint(20) UNSIGNED DEFAULT NULL,
  `materials_id` bigint(20) UNSIGNED DEFAULT NULL,
  `activities_id` bigint(20) UNSIGNED DEFAULT NULL,
  `issue_qty` varchar(255) DEFAULT NULL,
  `stock_qty` int(11) DEFAULT NULL,
  `remarkes` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inv_issues_details`
--

INSERT INTO `inv_issues_details` (`id`, `uuid`, `inv_issue_goods_id`, `materials_id`, `activities_id`, `issue_qty`, `stock_qty`, `remarkes`, `company_id`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, '8cd157e5-20f7-472e-97bd-a125048c3bab', NULL, 24, NULL, '33', NULL, 'eeeeeeeeeeeeeeeeeeeeeeeeeeeeee', 2, 1, '2024-04-17 07:26:30', '2024-04-17 07:26:30', NULL),
(3, '5c85ac00-9ae8-4866-ac81-c5b32d181ddc', NULL, 23, NULL, '11', NULL, 'eeeeeeeeeeeeeeeeeeeeeeeeeeeeee', 2, 1, '2024-04-17 07:26:30', '2024-04-17 07:26:30', NULL),
(4, 'bebc3937-faa3-44f0-812f-5c8a9c250191', 20, 24, NULL, '10', NULL, NULL, 2, 1, '2024-04-17 09:15:30', '2024-04-17 09:15:30', NULL),
(24, '6d492603-b4f2-4312-8cab-b6c9e9e81315', 26, 11, NULL, '10', NULL, NULL, 2, 1, '2024-05-04 00:11:05', '2024-05-04 00:11:05', NULL),
(25, '8a5f8038-4d6e-4af6-a6ff-c12e4354b638', 26, 11, NULL, '10', NULL, NULL, 2, 1, '2024-05-04 00:12:29', '2024-05-04 00:12:29', NULL),
(26, '40b88bc0-d168-4b66-b97c-967c25703b4d', 26, 11, NULL, '10', NULL, NULL, 2, 1, '2024-05-04 00:12:38', '2024-05-04 00:12:38', NULL),
(27, 'b14acb58-1cdd-4525-a621-cf903f4a7fae', 26, 11, NULL, '10', NULL, NULL, 2, 1, '2024-05-04 00:15:02', '2024-05-04 00:15:02', NULL),
(28, '975aaedb-25e4-4ab4-b005-1815b0c34bcc', 28, 22, NULL, '10', NULL, NULL, 2, 1, '2024-05-04 00:24:32', '2024-05-04 00:24:32', NULL),
(29, '7d36f638-e879-449d-9162-8133a6f75db4', 29, 23, NULL, '10', NULL, NULL, 2, 1, '2024-05-04 00:26:04', '2024-05-04 00:26:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inv_issue_goods`
--

CREATE TABLE `inv_issue_goods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `inv_issues_id` bigint(20) UNSIGNED DEFAULT NULL,
  `materials_id` bigint(20) UNSIGNED DEFAULT NULL,
  `issue_no` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `inv_issue_lists_id` bigint(20) UNSIGNED DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `remarkes` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inv_issue_goods`
--

INSERT INTO `inv_issue_goods` (`id`, `uuid`, `inv_issues_id`, `materials_id`, `issue_no`, `date`, `type`, `inv_issue_lists_id`, `img`, `remarkes`, `company_id`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, '416fb1cc-a3b9-48e2-b8ef-07564c7b6015', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, '2024-04-16 08:21:53', '2024-04-16 08:21:53', NULL),
(5, '23acb5d2-bd0a-41d5-80d0-b372efc2a5c8', 5, NULL, 'hfg678sa', '2024-04-10', '3', 8, NULL, 'ddddddddddddddddddddddddddddddddddddddddddd', 2, 1, '2024-04-16 08:23:09', '2024-04-16 08:23:09', NULL),
(6, '9ffe9ea9-4c22-449f-bd8f-dd2ee2ed6e53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, '2024-04-16 08:26:34', '2024-04-16 08:26:34', NULL),
(7, '886cacda-0b4c-483e-9de8-30cf5e537056', 5, NULL, 'hfg678sa', '2024-04-10', '3', 8, NULL, 'ddddddddddddddddddddddddddddddddddddddddddd', 2, 1, '2024-04-16 08:40:25', '2024-04-16 08:40:25', NULL),
(8, 'a0cdddf1-6d61-4ef2-8273-7833e13a6e98', 5, NULL, '876543', '2024-04-20', '29', 1, NULL, 'ddddddddddddddddddddddddddddddddddddddddddd', 2, 1, '2024-04-16 08:57:04', '2024-04-16 08:57:04', NULL),
(9, '0603d423-e0c1-4a4e-bcde-b36d0b90f552', 5, NULL, '819964', '2024-04-20', '29', 1, NULL, NULL, 2, 1, '2024-04-16 08:58:02', '2024-04-16 08:58:02', NULL),
(10, '81da00fc-94fe-4334-a4bd-39ad5bbfdcef', 5, NULL, '890396', '2024-04-20', '29', 1, NULL, NULL, 2, 1, '2024-04-16 08:58:24', '2024-04-16 08:58:24', NULL),
(11, '7ae33b89-a19d-40fa-a826-cbe7862bc5ce', 6, NULL, '956679', '2024-04-19', '29', 1, NULL, NULL, 2, 1, '2024-04-17 02:03:59', '2024-04-17 02:03:59', NULL),
(12, 'd051bab7-4a88-4c80-af88-f0b0027c1a70', 6, NULL, '389900', '2024-04-19', '29', 1, NULL, NULL, 2, 1, '2024-04-17 02:04:10', '2024-04-17 02:04:10', NULL),
(13, 'c372e1a5-a9aa-431e-8c09-56bce9e24a30', 6, NULL, '201726', '2024-04-19', '29', 1, NULL, NULL, 2, 1, '2024-04-17 07:14:21', '2024-04-17 07:14:21', NULL),
(14, '0ecca179-45da-4951-b6c9-6e36e9acdcf0', 6, NULL, '919357', '2024-04-18', '29', 1, NULL, NULL, 2, 1, '2024-04-17 07:15:53', '2024-04-17 07:15:53', NULL),
(15, 'c7bc30db-d5f8-4b65-a1e6-0e2d1e3f6cf1', 6, NULL, '482274', '2024-04-18', '29', 1, NULL, NULL, 2, 1, '2024-04-17 07:23:41', '2024-04-17 07:23:41', NULL),
(16, '4720aec8-81dd-4148-ac34-f76c1fde5bd7', 6, NULL, '766708', '2024-04-18', '29', 1, NULL, NULL, 2, 1, '2024-04-17 07:23:53', '2024-04-17 07:23:53', NULL),
(17, '86acd472-0699-432b-8577-ef9939569236', 5, NULL, '876543', '2024-04-20', '29', 1, NULL, 'ddddddddddddddddddddddddddddddddddddddddddd', 2, 1, '2024-04-17 07:36:18', '2024-04-17 07:36:18', NULL),
(18, '758a1c14-b7f8-43e7-b98a-6b17c33a8903', 5, NULL, '876543', '2024-04-20', '29', 1, NULL, 'ddddddddddddddddddddddddddddddddddddddddddd', 2, 1, '2024-04-17 09:11:26', '2024-04-17 09:11:26', NULL),
(19, '17877b18-fc43-4005-a057-59cd27c20cac', 6, NULL, '998551', '2024-04-17', '29', 1, NULL, NULL, 2, 1, '2024-04-17 09:11:34', '2024-04-17 09:11:34', NULL),
(20, 'e7fb9df7-4f2e-4a0c-9991-42f5f6e6f444', 6, NULL, '225487', '2024-04-19', '29', 1, NULL, NULL, 2, 1, '2024-04-17 09:13:26', '2024-04-17 09:13:26', NULL),
(21, '53629aa3-e2ea-4f3d-982f-213d94924dfd', 9, NULL, '385047', '2024-05-11', '2', 1, NULL, NULL, 2, 1, '2024-05-03 08:40:30', '2024-05-03 08:40:30', NULL),
(22, 'ce3acf36-130c-4ef5-9bd9-de19765e29cc', 9, NULL, '893934', '2024-05-11', '2', 1, NULL, NULL, 2, 1, '2024-05-03 08:46:14', '2024-05-03 08:46:14', NULL),
(23, 'f7875b65-14ba-4649-8458-062929bef924', 9, NULL, '764776', '2024-05-10', '29', 1, NULL, NULL, 2, 1, '2024-05-03 13:05:09', '2024-05-03 13:05:09', NULL),
(24, '1bcd266c-fbcf-4d4b-b610-3102c7d1202b', 9, NULL, '868840', '2024-05-10', '29', 1, NULL, NULL, 2, 1, '2024-05-03 13:06:52', '2024-05-03 13:06:52', NULL),
(25, '77b1b57a-d8d4-4679-8ab4-97a4d9d42843', 9, NULL, '858538', '2024-05-17', '29', 1, NULL, NULL, 2, 1, '2024-05-03 13:11:38', '2024-05-03 13:11:38', NULL),
(26, 'f6172c6b-2d87-4223-97d3-b0630b018b1b', 10, NULL, '563924', '2024-05-10', '29', 1, NULL, NULL, 2, 1, '2024-05-04 00:01:15', '2024-05-04 00:01:15', NULL),
(27, '3a29d948-05ac-408c-9dbf-e9b15aef205e', 10, NULL, '565542', '2024-05-10', '29', 1, NULL, NULL, 2, 1, '2024-05-04 00:03:48', '2024-05-04 00:03:48', NULL),
(28, '64942e11-2252-4310-9300-9035e8a61f1c', 10, NULL, '578807', '2024-05-09', '29', 1, NULL, NULL, 2, 1, '2024-05-04 00:23:45', '2024-05-04 00:23:45', NULL),
(29, '229d2b76-0525-4b9c-8531-940481894e8c', 10, NULL, '750058', '2024-05-11', '29', 1, NULL, NULL, 2, 1, '2024-05-04 00:25:33', '2024-05-04 00:25:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inv_issue_lists`
--

CREATE TABLE `inv_issue_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `remarkes` varchar(255) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inv_issue_lists`
--

INSERT INTO `inv_issue_lists` (`id`, `uuid`, `name`, `slug`, `remarkes`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'f5e415aa-4671-4ba5-80c3-aba5e88e0e76', 'Staff', 'staff', NULL, 1, '2024-04-10 02:16:10', '2024-04-10 02:16:10'),
(2, 'fbd15aeb-a0c6-4509-9b52-1402f3da6c91', 'Contractor', 'contractor', NULL, 1, '2024-04-10 02:16:10', '2024-04-10 02:16:10'),
(3, 'b21c1356-b0d1-4fa4-bb3e-9456526ad775', 'Machines or other assets', 'machines-or-other-assets', NULL, 1, '2024-04-10 02:16:10', '2024-04-10 02:16:10'),
(4, '13b24d0d-0d8b-4049-8756-01946b14ce33', 'Scrap Sell', 'scrap-sell', NULL, 1, '2024-04-10 02:16:11', '2024-04-10 02:16:11'),
(5, 'c36479e5-4c66-45bc-9bcc-e19b1da3c978', 'Damage', 'damage', NULL, 1, '2024-04-10 02:16:11', '2024-04-10 02:16:11'),
(6, '07709e36-0dae-4ada-a8ee-b748643a0b5a', 'Other Project', 'other-project', NULL, 1, '2024-04-10 02:16:11', '2024-04-10 02:16:11'),
(7, 'e3c669da-db83-4796-a426-6e695d812714', 'Same project-Other Stores', 'same-project-other-stores', NULL, 1, '2024-04-10 02:16:11', '2024-04-10 02:16:11'),
(8, 'c9497502-6451-4ece-a078-f2d7c9980c06', 'Theft', 'theft', NULL, 1, '2024-04-10 02:16:11', '2024-04-10 02:16:11');

-- --------------------------------------------------------

--
-- Table structure for table `inv_issue_stores`
--

CREATE TABLE `inv_issue_stores` (
  `inv_issues_id` bigint(20) UNSIGNED NOT NULL,
  `store_warehouses_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inv_issue_stores`
--

INSERT INTO `inv_issue_stores` (`inv_issues_id`, `store_warehouses_id`) VALUES
(2, 4),
(2, 3),
(3, 1),
(3, 3),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(8, 3),
(9, 1),
(10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `inv_returns`
--

CREATE TABLE `inv_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `projects_id` bigint(20) UNSIGNED DEFAULT NULL,
  `store_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inv_returns`
--

INSERT INTO `inv_returns` (`id`, `uuid`, `name`, `date`, `details`, `remarks`, `projects_id`, `store_id`, `user_id`, `company_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '81565ca3-6e41-49a4-b166-c9b27741f6b0', '2024-03-07', '2024-03-21', NULL, NULL, 1, 1, 2, 2, 1, '2024-03-21 02:34:48', '2024-03-21 02:34:48'),
(2, '7d0a4fe0-2788-4e9a-b21f-7066c8d46a58', '2024-03-07', '2024-04-05', NULL, NULL, 1, NULL, 2, 2, 1, '2024-04-05 01:37:57', '2024-04-05 01:37:57'),
(3, '7288e3af-a108-4a56-a1b9-00d25019c78d', '2024-04-10', '2024-04-10', NULL, NULL, 1, NULL, 2, 2, 1, '2024-04-10 09:03:02', '2024-04-10 09:03:02'),
(4, '33bfe6b1-70c0-42cb-ae0c-8945a909923e', '2024-04-15', '2024-04-15', NULL, NULL, 1, NULL, 2, 2, 1, '2024-04-15 04:06:44', '2024-04-15 04:06:44'),
(5, '20bf135d-0cd9-47a0-a00f-ebc1c33bde7b', '2024-04-16', '2024-04-16', NULL, NULL, 1, NULL, 2, 2, 1, '2024-04-16 01:36:52', '2024-04-16 01:36:52'),
(6, '94cd883f-fdb7-4201-aa23-4d1fc63caa43', '2024-04-17', '2024-04-17', NULL, NULL, 1, NULL, 2, 2, 1, '2024-04-17 00:56:08', '2024-04-17 00:56:08'),
(7, 'fc8a53ea-7aaa-4901-b933-0c630c06f097', '2024-05-01', '2024-05-01', NULL, NULL, 1, NULL, 2, 2, 1, '2024-05-01 06:58:25', '2024-05-01 06:58:25'),
(8, 'e7286323-f97d-4e72-bc0b-2c2bb7fd7a27', '2024-05-02', '2024-05-02', NULL, NULL, 1, NULL, 2, 2, 1, '2024-05-02 05:56:43', '2024-05-02 05:56:43'),
(9, '6ddd4c6c-2886-4381-8043-18d342c708bc', '2024-05-03', '2024-05-03', NULL, NULL, 1, NULL, 2, 2, 1, '2024-05-03 08:48:52', '2024-05-03 08:48:52'),
(10, '94c065f2-d218-4577-b281-101f2ddbad7b', '2024-05-04', '2024-05-04', NULL, NULL, 1, NULL, 2, 2, 1, '2024-05-04 00:26:16', '2024-05-04 00:26:16');

-- --------------------------------------------------------

--
-- Table structure for table `inv_returns_details`
--

CREATE TABLE `inv_returns_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `inv_return_goods_id` bigint(20) UNSIGNED DEFAULT NULL,
  `materials_id` bigint(20) UNSIGNED DEFAULT NULL,
  `activities_id` bigint(20) UNSIGNED DEFAULT NULL,
  `return_qty` varchar(255) DEFAULT NULL,
  `stock_qty` int(11) DEFAULT NULL,
  `remarkes` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inv_returns_details`
--

INSERT INTO `inv_returns_details` (`id`, `uuid`, `inv_return_goods_id`, `materials_id`, `activities_id`, `return_qty`, `stock_qty`, `remarkes`, `company_id`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '31b1d989-1ad6-451b-b7dd-e04cf65f79d8', NULL, 6, NULL, '10', NULL, NULL, 2, 1, '2024-04-17 09:17:52', '2024-04-17 09:17:52', NULL),
(3, '423fa7d6-f0c5-4fff-bda5-ad2debda19f7', 1, 1, NULL, '144', 44, NULL, 2, 1, '2024-05-04 00:15:34', '2024-05-04 00:15:34', NULL),
(4, '7fe151cf-2425-402a-9424-09fe40657a10', 2, 1, NULL, '144', 44, NULL, 2, 1, '2024-05-04 00:15:34', '2024-05-04 00:15:34', NULL),
(5, 'ea4d71b8-4cea-4956-9b6b-c039a32e611b', NULL, 23, NULL, '10', NULL, NULL, 2, 1, '2024-05-04 00:26:34', '2024-05-04 00:26:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inv_return_goods`
--

CREATE TABLE `inv_return_goods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `inv_returns_id` bigint(20) UNSIGNED DEFAULT NULL,
  `materials_id` bigint(20) UNSIGNED DEFAULT NULL,
  `return_no` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `inv_issue_lists_id` bigint(20) UNSIGNED DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `remarkes` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inv_return_goods`
--

INSERT INTO `inv_return_goods` (`id`, `uuid`, `inv_returns_id`, `materials_id`, `return_no`, `date`, `type`, `inv_issue_lists_id`, `img`, `remarkes`, `company_id`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '2c25d950-6906-4389-954b-f7d0a57a6e3d', 6, NULL, '389796', '2024-04-19', '29', 1, NULL, NULL, 2, 1, '2024-04-17 01:27:23', '2024-04-17 01:27:23', NULL),
(2, '9bf818a2-49ce-43e9-b01f-6ff14501f742', 6, NULL, '931015', '2024-04-20', '29', 1, NULL, NULL, 2, 1, '2024-04-17 01:35:41', '2024-04-17 01:35:41', NULL),
(3, 'cd623d48-9baf-4fa7-99a1-10ed372f93fa', 6, NULL, '457958', '2024-04-20', '29', 1, NULL, NULL, 2, 1, '2024-04-17 01:47:47', '2024-04-17 01:47:47', NULL),
(4, '9950ba9b-a704-4baa-ac42-6cd444cb9beb', 6, NULL, '557332', '2024-04-20', '29', 1, NULL, NULL, 2, 1, '2024-04-17 01:48:08', '2024-04-17 01:48:08', NULL),
(5, '64093d33-ebdd-4555-9ab6-4ac6a43fa51d', 6, NULL, '912929', '2024-04-20', '29', 1, NULL, NULL, 2, 1, '2024-04-17 02:00:08', '2024-04-17 02:00:08', NULL),
(6, '4365b799-bfa0-450a-8e6f-eeac790fe4e9', 6, NULL, '710782', '2024-04-19', '29', 1, NULL, NULL, 2, 1, '2024-04-17 02:05:18', '2024-04-17 02:05:18', NULL),
(7, 'd2a24227-8014-4b4b-9c8e-3cc5b5ce9b33', 6, NULL, '787706', '2024-04-19', '29', 1, NULL, NULL, 2, 1, '2024-04-17 02:07:24', '2024-04-17 02:07:24', NULL),
(8, '97814124-cdc4-4f08-b25d-5b63ce30e130', 6, NULL, '842539', '2024-04-19', '29', 1, NULL, NULL, 2, 1, '2024-04-17 02:07:43', '2024-04-17 02:07:43', NULL),
(9, 'b4d373e5-5b9e-454d-99f1-d6e4019d8eb8', 6, NULL, '873736', '2024-04-19', '29', 1, NULL, NULL, 2, 1, '2024-04-17 02:07:58', '2024-04-17 02:07:58', NULL),
(10, 'ed7867ee-f2fe-4a67-86c5-c8ff504bc2ef', 6, NULL, '829296', '2024-04-19', '29', 1, NULL, NULL, 2, 1, '2024-04-17 02:24:48', '2024-04-17 02:24:48', NULL),
(11, '41ba9cba-279f-4bc2-9a19-0cf2b62a9705', 6, NULL, '761195', '2024-04-19', '29', 1, NULL, NULL, 2, 1, '2024-04-17 02:24:55', '2024-04-17 02:24:55', NULL),
(12, 'f129f354-60b7-476d-878d-5d267d24c06b', 6, NULL, '602038', '2024-04-19', '29', 1, NULL, NULL, 2, 1, '2024-04-17 02:54:48', '2024-04-17 02:54:48', NULL),
(13, '410c7e81-95c9-46ea-a0aa-9e766ddebbf5', 6, NULL, '723743', '2024-04-19', '29', 1, NULL, NULL, 2, 1, '2024-04-17 02:54:56', '2024-04-17 02:54:56', NULL),
(14, 'fe0af276-1131-4d66-bda8-cdbc32d7e363', 6, NULL, '515709', '2024-04-18', '29', 1, NULL, NULL, 2, 1, '2024-04-17 04:59:16', '2024-04-17 04:59:16', NULL),
(15, 'fdd21e78-c535-4956-8827-e8c6c032570c', 6, NULL, '384490', '2024-04-18', '29', 1, NULL, NULL, 2, 1, '2024-04-17 04:59:27', '2024-04-17 04:59:27', NULL),
(16, '12beefc0-1594-4074-a95a-6475e7e297af', 6, NULL, '850445', '2024-04-18', '29', 1, NULL, NULL, 2, 1, '2024-04-17 05:39:32', '2024-04-17 05:39:32', NULL),
(17, 'd9208ff4-5224-4063-8e66-2693f5e1579a', 6, NULL, '935555', '2024-04-18', '29', 1, NULL, NULL, 2, 1, '2024-04-17 06:57:44', '2024-04-17 06:57:44', NULL),
(18, 'e9491dde-35a8-498b-b69d-9130f0621935', 6, NULL, '915463', '2024-04-18', '29', 1, NULL, NULL, 2, 1, '2024-04-17 06:59:13', '2024-04-17 06:59:13', NULL),
(19, '7abfa1c2-3fd3-4fb2-bdce-315c5ee9d934', 6, NULL, '988699', '2024-04-18', '29', 1, NULL, NULL, 2, 1, '2024-04-17 07:01:40', '2024-04-17 07:01:40', NULL),
(20, '0149f95c-484e-448d-b1cd-29ca67be54ff', 6, NULL, '623933', '2024-04-18', '29', 1, NULL, NULL, 2, 1, '2024-04-17 09:16:28', '2024-04-17 09:16:28', NULL),
(21, '3a41d026-1f06-48db-a20b-8bc4d6d1bc4b', 6, NULL, '427227', '2024-04-18', '29', 1, NULL, NULL, 2, 1, '2024-04-17 09:17:00', '2024-04-17 09:17:00', NULL),
(22, '8cf64c99-c02a-4ea1-9a3a-071face057e1', 9, NULL, '357787', '2024-05-17', '2', 1, NULL, NULL, 2, 1, '2024-05-03 08:49:44', '2024-05-03 08:49:44', NULL),
(23, '2764e357-83b6-4cb3-8646-e4d63239f546', 10, NULL, '845557', '2024-05-10', '29', 1, NULL, NULL, 2, 1, '2024-05-04 00:26:27', '2024-05-04 00:26:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inv_return_stores`
--

CREATE TABLE `inv_return_stores` (
  `inv_returns_id` bigint(20) UNSIGNED NOT NULL,
  `store_warehouses_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inv_return_stores`
--

INSERT INTO `inv_return_stores` (`inv_returns_id`, `store_warehouses_id`) VALUES
(3, 1),
(3, 3),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 3),
(9, 1),
(10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `inward_goods`
--

CREATE TABLE `inward_goods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `inv_inwards_id` bigint(20) UNSIGNED DEFAULT NULL,
  `materials_id` bigint(20) UNSIGNED DEFAULT NULL,
  `grn_no` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `inv_inward_entry_types_id` bigint(20) UNSIGNED DEFAULT NULL,
  `delivery_ref_copy_no` varchar(255) DEFAULT NULL,
  `delivery_ref_copy_date` date DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `remarkes` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `vendors_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inward_goods`
--

INSERT INTO `inward_goods` (`id`, `uuid`, `inv_inwards_id`, `materials_id`, `grn_no`, `date`, `inv_inward_entry_types_id`, `delivery_ref_copy_no`, `delivery_ref_copy_date`, `img`, `remarkes`, `company_id`, `is_active`, `created_at`, `updated_at`, `deleted_at`, `vendors_id`) VALUES
(109, '6749d842-57dc-4399-8ec0-7930eea83992', 16, NULL, '772483', '2024-04-18', 1, '256890', '2024-04-19', '171336471873.jpg', 'ftfyf', 2, 1, '2024-04-17 09:08:38', '2024-04-17 09:08:38', NULL, 1),
(113, '16c58d5b-0de2-42eb-9d25-91527c75adba', 17, NULL, 'hfg678433', '2024-04-10', 1, 'dfe3434443', '2024-04-13', '', 'ddddddddddddddddddddddddddddddddddddddddddd', 2, 1, '2024-04-30 10:20:38', '2024-04-30 10:20:38', NULL, 1),
(114, 'c9e9bca2-c0e1-41c9-8d62-c7e57e9cdca7', 19, NULL, '699504', '2024-05-04', 1, 'qfvb', '2024-05-09', '171474402957.jpg', 'ok', 2, 1, '2024-05-03 08:17:09', '2024-05-03 08:17:09', NULL, 1),
(115, '8f4889f6-b7f9-4ecb-9d2b-42f637117465', 19, NULL, '863829', '2024-05-25', 1, 'ok', '2024-05-31', '171474459950.jpg', 'ok', 2, 1, '2024-05-03 08:26:39', '2024-05-03 08:26:39', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `inward_goods_details`
--

CREATE TABLE `inward_goods_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `inward_goods_id` bigint(20) UNSIGNED DEFAULT NULL,
  `materials_id` bigint(20) UNSIGNED DEFAULT NULL,
  `recipt_qty` varchar(255) DEFAULT NULL,
  `reject_qty` int(11) DEFAULT NULL,
  `remarkes` varchar(255) DEFAULT NULL,
  `price` decimal(9,3) DEFAULT NULL,
  `po_qty` int(11) DEFAULT NULL,
  `accept_qty` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `assets_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inward_goods_details`
--

INSERT INTO `inward_goods_details` (`id`, `uuid`, `inward_goods_id`, `materials_id`, `recipt_qty`, `reject_qty`, `remarkes`, `price`, `po_qty`, `accept_qty`, `type`, `company_id`, `is_active`, `created_at`, `updated_at`, `deleted_at`, `assets_id`) VALUES
(59, '9f70b3db-92a3-4706-9821-351f436b1366', 109, 1, '20', 5, 'Ok', '12.000', NULL, 15, NULL, 2, 1, '2024-04-17 09:10:42', '2024-04-17 09:10:42', NULL, NULL),
(60, '0e1187fd-f34b-426a-a201-53c0a8a92cd2', 109, 3, '10', 5, 'Ok', '36.000', NULL, 5, NULL, 2, 1, '2024-05-03 08:17:39', '2024-05-03 08:17:39', NULL, NULL),
(61, '0692e629-63ff-4832-aeb1-3842f1326703', 109, 1, '20', 5, 'Ok', '12.000', NULL, 15, NULL, 2, 1, '2024-05-03 08:26:43', '2024-05-03 08:26:43', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inward_stores`
--

CREATE TABLE `inward_stores` (
  `inv_inwards_id` bigint(20) UNSIGNED NOT NULL,
  `store_warehouses_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inward_stores`
--

INSERT INTO `inward_stores` (`inv_inwards_id`, `store_warehouses_id`) VALUES
(4, 4),
(4, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(12, 3),
(13, 1),
(14, 1),
(16, 1),
(17, 1),
(18, 1),
(18, 3),
(19, 1);

-- --------------------------------------------------------

--
-- Table structure for table `labours`
--

CREATE TABLE `labours` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `labours`
--

INSERT INTO `labours` (`id`, `uuid`, `name`, `category`, `company_id`, `unit_id`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '811d2eae-beb0-45f6-acd6-1be1ca4a658f', 'labour', 'skilled', 2, 3, 1, '2023-10-03 07:56:54', '2023-10-03 07:56:54', NULL),
(2, '0a63a721-1c51-45d4-8049-9c12f62901a5', 'labour', 'skilled', 1, 5, 1, '2023-10-03 10:52:02', '2023-10-03 10:52:02', NULL),
(3, 'fbd92ecc-f6d8-40ac-a873-38991525fe59', 'Joy Dey', 'semiskilled', 2, 3, 1, '2023-10-05 14:43:25', '2023-10-05 14:43:25', NULL),
(4, 'c6804efb-171f-49ae-8282-087f9484be06', 'sample labour', 'skilled', 2, 1, 1, '2024-01-10 03:16:48', '2024-01-16 06:54:26', '2024-01-16 06:54:26'),
(5, 'babdb9a3-ee1a-4a83-9fd4-e963af50c5ff', 'vhhjj', 'semiskilled', 2, 3, 1, '2024-01-12 09:28:00', '2024-01-16 06:31:07', '2024-01-16 06:31:07'),
(6, '1de7db10-f821-48ad-8b75-e281c61aa29a', 'Soujit Saha', 'semiskilled', 2, 6, 1, '2024-01-17 08:11:27', '2024-01-17 08:23:32', NULL),
(7, 'fd84b880-67a8-4a33-acd5-24565da9b104', 'Jit', 'skilled', 2, 3, 1, '2024-02-01 01:44:20', '2024-02-01 01:44:20', NULL),
(8, 'bfe5f00b-6e4d-4a59-9cb7-3c872465563d', 'Mason', 'skilled', 1, 5, 1, '2024-02-09 02:07:44', '2024-02-09 02:07:44', NULL),
(9, 'bee07e56-4838-4a67-8460-e220e3eaa457', 'Carpenter', 'skilled', 2, 23, 1, '2024-02-17 09:47:33', '2024-02-17 09:50:41', '2024-02-17 09:50:41'),
(10, '1769dde2-30c0-493f-a89a-6e0cf3c4ea88', 'Mason', 'skilled', 2, 23, 1, '2024-03-04 09:49:06', '2024-03-04 09:49:06', NULL),
(11, '6630d9da-8967-4bed-8e46-2e36904ba90a', 'MC', 'semiskilled', 2, 23, 1, '2024-03-04 09:49:30', '2024-03-04 09:49:30', NULL),
(12, 'ae445ebe-6fa9-4cc4-a888-449b4c90d28e', 'FC', 'semiskilled', 2, 23, 1, '2024-03-04 09:49:45', '2024-03-04 09:49:45', NULL),
(13, 'b48d55f7-5f3b-4a62-8176-04229ebe1b0a', 'Male cooli', 'semiskilled', 1, 5, 1, '2024-03-12 03:36:04', '2024-03-12 03:36:04', NULL),
(14, '74164166-c484-411e-b8f6-d8a2f4d4e0ef', 'Male cooli', 'semiskilled', 1, 5, 1, '2024-03-12 03:36:05', '2024-03-12 03:36:13', '2024-03-12 03:36:13'),
(15, '07a8a4af-f9ba-4797-8024-656234e9ae81', 'Female Cooli', 'unskilled', 1, 5, 1, '2024-03-12 03:36:47', '2024-03-12 03:36:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `labour_histories`
--

CREATE TABLE `labour_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `labours_id` bigint(20) UNSIGNED DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `ot_qty` int(11) DEFAULT NULL,
  `activities_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vendors_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rate_per_unit` varchar(255) DEFAULT NULL,
  `remarkes` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `dpr_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `labour_histories`
--

INSERT INTO `labour_histories` (`id`, `uuid`, `labours_id`, `qty`, `ot_qty`, `activities_id`, `vendors_id`, `rate_per_unit`, `remarkes`, `company_id`, `dpr_id`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '3aa1fbfd-515e-43c1-93f9-27b1e53144ff', 1, 2, 23, 1, 1, '15', 'testtdfdddddddddddddttt', 2, 5, 1, '2023-11-28 03:13:50', '2023-11-28 03:13:50', NULL),
(2, '7d48f606-9fb3-4232-8eb6-21618973a008', 1, 2, 23, 1, 1, '12', 'testtttt', 2, 5, 1, '2023-11-28 03:13:50', '2023-11-28 03:13:50', NULL),
(3, 'f00b3462-fdda-413c-b755-293364ec4d9f', 1, 2, 23, 1, 1, '15', 'testtdfdddddddddddddttt', 2, 6, 1, '2023-11-28 06:22:06', '2023-11-28 06:22:06', NULL),
(4, 'e356dbba-dcaf-47f9-9c5a-666ad2f337fa', 1, 2, 23, 1, 1, '12', 'testtttt', 2, 5, 1, '2023-11-28 06:22:06', '2023-11-28 06:22:06', NULL),
(5, '7fa6db7b-1392-4003-bb55-9097f6177452', 1, 2, 25, 138, 1, '15', 'testtdfdddddddddddddttt', 2, 5, 1, '2024-02-26 02:36:28', '2024-02-26 02:36:28', NULL),
(6, '2e004010-64fa-4920-9a7e-7131d25ea5ed', 3, 2, 25, 137, 1, '14', 'testtttt', 2, 5, 1, '2024-02-26 02:36:28', '2024-02-26 02:36:28', NULL),
(7, 'ec03d259-a251-4d51-bf66-aa1b27e066bf', 1, 19, 15, 55, 1, '14', 'testtttt', 2, 12, 1, '2024-02-29 00:38:58', '2024-02-29 03:29:23', NULL),
(8, 'de88f974-6cb9-4e75-bcc9-f3022913e92b', 3, 21, 25, 54, 1, '15', 'testtdfdddddddddddddttt', 2, 12, 1, '2024-02-29 00:38:58', '2024-02-29 03:29:23', NULL),
(9, 'fd679f2e-fdb7-4c23-9aeb-573b9acdb6b5', 1, 21, 25, 137, 1, '15', 'testtdfdddddddddddddttt', 2, 12, 1, '2024-03-06 09:31:12', '2024-03-06 09:31:12', NULL),
(10, '07c40f45-4457-404f-b220-dcc6610d3406', 3, 19, 15, 138, 1, '14', 'testtttt', 2, 12, 1, '2024-03-06 09:31:12', '2024-03-06 09:31:12', NULL),
(11, '5ab0c0ea-1328-4029-bd6b-2a9fbb755142', 1, 21, 25, 137, 1, '15', 'testtdfdddddddddddddttt', 2, 12, 1, '2024-03-06 09:31:52', '2024-03-06 09:31:52', NULL),
(12, 'bed55734-9205-450c-8dca-70012f6b1791', 3, 19, 15, 138, 1, '14', 'testtttt', 2, 12, 1, '2024-03-06 09:31:52', '2024-03-06 09:31:52', NULL),
(13, '33b8363a-28b0-4024-8c1d-62fcd7b5e48b', 3, 10, 20, 2, 1, '20', 'asdfghjk', 2, 99, 1, '2024-03-07 04:34:37', '2024-03-07 04:34:37', NULL),
(14, 'a93e2b90-42d3-4274-80bb-3d7b59305703', 1, 21, 25, 137, 1, '15', 'testtdfdddddddddddddttt', 2, 12, 1, '2024-03-07 04:36:48', '2024-03-07 04:36:48', NULL),
(15, '3e937199-2479-4122-bbbb-2c786780e3f7', 3, 19, 15, 138, 1, '14', 'testtttt', 2, 12, 1, '2024-03-07 04:36:48', '2024-03-07 04:36:48', NULL),
(16, '5dbaec47-f5a7-4ee7-9784-8f282efbca9e', 1, 21, 25, 137, 1, '15', 'testtdfdddddddddddddttt', 2, 12, 1, '2024-03-07 04:37:33', '2024-03-07 04:37:33', NULL),
(17, '45c87924-0ab4-4656-a939-fa2c3050f723', 3, 190, 15, 138, 1, '14', 'testtttt', 2, 12, 1, '2024-03-07 04:37:33', '2024-03-07 04:37:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `specification` varchar(255) DEFAULT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `uuid`, `name`, `class`, `code`, `specification`, `unit_id`, `company_id`, `is_active`, `deleted_at`, `created_at`, `updated_at`, `type`) VALUES
(1, '5497a422-fa37-4ea4-8ca2-731ee65073bc', 'labour', 'Class-A', '6651bca645bbe4', 'Concrete is a composite material composed of aggregate bonded together with a fluid cement that cures over time.', 1, 2, 1, NULL, '2023-10-03 08:01:40', '2023-10-03 08:01:40', NULL),
(2, '1e74fb55-07d3-4d66-9a42-7f4e0baf0aca', 'aserwe', 'Class-C', '6651bf29155b1f', 'aaaaaaaaa', 1, 1, 1, NULL, '2023-10-03 10:53:05', '2024-03-20 07:44:40', NULL),
(3, '3a05157b-3e83-465c-9951-9129047680e1', 'Samplu', 'Class-B', '665a0ee190f5d4', 'test', 9, 2, 1, NULL, '2024-01-12 02:15:29', '2024-01-18 08:45:20', NULL),
(4, 'dce92dda-2902-4649-8165-2412653b47cb', 'tst', 'Class-B', '665a149e53affa', '@abc', 1, 2, 1, '2024-01-16 05:24:41', '2024-01-12 08:47:09', '2024-01-16 05:24:41', NULL),
(5, '96b0b21e-8a3f-439a-9890-dce771913a97', 'settl', 'Class-B', '665bb3f7d29a61', 'settl', 3, 2, 1, NULL, '2024-02-01 01:21:41', '2024-02-01 01:21:41', NULL),
(6, '3e14aad5-4c59-4b75-810d-8a2297545148', 'Cement', 'Class-A', '665c5d7f37f5dc', 'OPC', 4, 1, 1, NULL, '2024-02-09 02:14:51', '2024-02-09 02:14:51', NULL),
(7, '7b185261-2ebd-4a2e-8a94-e6f473bc605b', 'Fly ash', 'Class-A', '665c5d823b4433', NULL, 4, 1, 1, NULL, '2024-02-09 02:15:39', '2024-02-09 02:15:39', NULL),
(8, '70235b29-391b-416a-b165-3f085a2bd708', 'sand', 'Class-A', '665c91295a0f83', 'machine', 3, 2, 1, NULL, '2024-02-11 13:01:49', '2024-02-11 13:01:49', NULL),
(9, '96283b97-117b-4358-ad30-c686c62c8f14', 'pipe tube', 'Class-A', '665c9166a8a40c', '2x2 inch', 3, 2, 1, NULL, '2024-02-11 13:18:10', '2024-02-11 13:18:10', NULL),
(10, 'db9cf8ed-4b9a-4a2c-ab25-61a37fb6d6e7', 'stainless steel', 'Class-A', '665cf7deca1aed', 'SS314', 23, 2, 1, NULL, '2024-02-16 09:53:24', '2024-02-16 09:53:24', NULL),
(11, '52e6e913-83a0-4542-8f16-30b9a6475704', 'Flyash', 'Class-A', '665e5e6efc6817', 'NA', 29, 2, 1, NULL, '2024-03-04 09:51:19', '2024-03-04 09:51:19', NULL),
(12, '5fc296db-aa4f-42af-b032-c9e27415a7b8', 'Metal', 'Class-A', '665e5e766dec45', 'crushed', 27, 2, 1, NULL, '2024-03-04 09:53:18', '2024-03-04 09:53:18', NULL),
(13, '18b5cb1f-9e97-4aea-92ac-26fbc883323c', 'okg.', 'Class-A', '665fa8c8595143', 'unit', 3, 2, 1, NULL, '2024-03-20 01:43:09', '2024-03-20 01:43:09', NULL),
(14, '31e5d977-6808-444a-aa57-86bb5c962e8a', 'aserweq', 'Class-C', '665fae15c53f56', 'aaaaaaaaa', 1, 2, 1, NULL, '2024-03-20 07:45:08', '2024-03-20 07:45:08', NULL),
(15, '3f0a3521-7bc9-49d1-9f5b-ca56fea10da6', 'aserweqw', 'Class-C', '665fae16143e44', 'aaaaaaaaa', 1, 2, 1, NULL, '2024-03-20 07:45:13', '2024-03-20 07:45:13', NULL),
(16, 'd3cba86f-455b-4406-885c-ad7fc4b477f7', 'cement 4th april', 'Class-A', '6660eac6144d8f', '43 grade', 29, 2, 1, NULL, '2024-04-04 08:04:25', '2024-04-04 08:04:25', NULL),
(17, '77a6bf3b-e6de-4179-a7db-b0da8a8d8f3a', 'aserwss', 'Class-B', '66613988875429', 'aaaaaaaaa', 1, 2, 1, NULL, '2024-04-08 01:41:04', '2024-04-08 01:41:04', NULL),
(18, '9b54a0d9-cbdf-4fe6-8ef4-a8b1c60ac413', 'aserwsss', 'Class-B', '6661398dc67191', 'aaaaaaaaa', 1, 2, 1, NULL, '2024-04-08 01:42:28', '2024-04-08 01:42:28', NULL),
(19, '5c879f62-187b-41fc-9a9f-e81697aa2728', 'new', 'Class-A', '6661399ee12de0', 'asb', 3, 2, 1, NULL, '2024-04-08 01:47:02', '2024-04-08 01:47:02', NULL),
(20, 'bf31dde0-1825-44c8-bc13-235d3965ed94', 'abc new', 'Class-A', '66613b8b33dac4', 'new spec', 3, 2, 1, NULL, '2024-04-08 03:58:19', '2024-04-08 03:58:19', NULL),
(21, 'd03a0103-0bdc-49d2-baf7-2f9e4cf6d5dc', 'new two', 'Class-A', '66613babb52175', 'two', 3, 2, 1, NULL, '2024-04-08 04:06:59', '2024-04-08 04:06:59', NULL),
(22, 'bb994ee3-d947-4a5f-b32f-444b12137f0c', 'abc four', 'Class-A', '66613c03730f3a', 'abcd', 3, 2, 1, NULL, '2024-04-08 04:30:23', '2024-04-08 04:30:23', NULL),
(23, '6814bb5b-6e98-4ff4-98eb-9febb28a7965', 'test five', 'Class-A', '66613cf9fe344d', 'abc', 3, 2, 1, NULL, '2024-04-08 05:36:07', '2024-04-08 05:36:07', NULL),
(24, '16d67074-f730-4c71-9ab9-09e29a2085eb', 'jit one', 'Class-A', '66613e26ba09aa', 'sss', 3, 2, 1, NULL, '2024-04-08 06:56:19', '2024-04-08 06:56:19', NULL),
(25, '85f880b7-9407-4205-b37b-c22e1cf108a8', 'okk', 'Class-A', '666264300ae9bc', NULL, 3, 2, 1, NULL, '2024-04-22 05:29:12', '2024-04-22 05:29:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `materials_histories`
--

CREATE TABLE `materials_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `materials_id` bigint(20) UNSIGNED DEFAULT NULL,
  `activities_id` bigint(20) UNSIGNED DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `vendors_id` bigint(20) UNSIGNED DEFAULT NULL,
  `remarkes` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `dpr_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `materials_histories`
--

INSERT INTO `materials_histories` (`id`, `uuid`, `materials_id`, `activities_id`, `qty`, `date`, `vendors_id`, `remarkes`, `company_id`, `dpr_id`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '9cdeb99d-7c4b-4c13-800a-e9cb8e9cc338', 1, 1, 13, NULL, 1, 'rrrrrrrrrrrrrrrrrr', 2, 5, 1, '2023-11-28 04:22:44', '2023-11-28 04:22:44', NULL),
(2, '88151712-a7d6-464b-8c30-4471536069eb', 1, 1, 13, NULL, 1, 'rrrrrrrrrrrrrrrrrr', 2, 5, 1, '2023-11-28 04:22:44', '2023-11-28 04:22:44', NULL),
(3, 'd4f02b59-6087-4023-a793-43065d225495', 1, 1, 13, NULL, NULL, 'rrrrrrrrrrrrrrrrrr', 2, 5, 1, '2024-02-05 04:00:45', '2024-02-05 04:00:45', NULL),
(4, 'f41f9927-4677-4756-befa-7acef1377f35', 1, 1, 13, NULL, NULL, 'rrrrrrrrrrrrrrrrrr', 2, 5, 1, '2024-02-05 04:00:45', '2024-02-05 04:00:45', NULL),
(5, '5e404acd-0045-48ed-8eb3-70c325672723', 2, 1, 13, NULL, NULL, 'rrrrrrrrrrrrrrrrrr', 2, 5, 1, '2024-02-21 05:58:35', '2024-02-21 05:58:35', NULL),
(6, 'bb122cbd-f902-48cf-9258-7603d380c824', 1, 2, 13, NULL, NULL, 'rrrrrrrrrrrrrrrrrr', 2, 5, 1, '2024-02-21 05:58:35', '2024-02-21 05:58:35', NULL),
(7, '176c9753-6224-43dd-abe5-885ac274ddd4', 2, 1, 10, NULL, NULL, 'ok', 2, 88, 1, '2024-02-26 05:35:17', '2024-02-26 05:35:17', NULL),
(8, '8b483b33-b7ff-4069-b770-49d92cffd1ac', 2, 55, 10, NULL, NULL, 'sssssssssssssssssssswqqqqqqqqqqqqqqqqqq', 2, 12, 1, '2024-02-29 00:41:36', '2024-02-29 03:28:34', NULL),
(9, '18f9bfea-39af-4fb7-ab9f-3889360bc648', 1, 54, 120, NULL, NULL, 'rrrrrrrrrrrrrrrrrr', 2, 12, 1, '2024-02-29 00:41:36', '2024-02-29 03:28:34', NULL),
(10, 'f877385f-6fe0-4534-8f71-5839ee82ee72', 1, 1, 1, NULL, NULL, '10', 2, 109, 1, '2024-03-01 04:07:33', '2024-03-01 04:07:33', NULL),
(11, 'd28fa5e2-646d-4db1-bd0f-c63c698d5784', 2, 1, 10, NULL, NULL, '10', 2, 109, 1, '2024-03-01 04:08:02', '2024-03-01 04:08:02', NULL),
(12, '8fb4bdb1-2751-40e6-9153-527c9489b266', 2, 1, 10, NULL, NULL, '10', 2, 109, 1, '2024-03-01 04:09:44', '2024-03-01 04:09:44', NULL),
(13, 'a7a41530-ac91-470b-b941-cde9042975cc', 1, 1, 10, NULL, NULL, 'exp', 2, 132, 1, '2024-04-08 04:57:17', '2024-04-08 04:57:17', NULL),
(14, '2c930f80-990a-4d95-914d-ba1fafd3a0f2', 1, 1, 10, NULL, NULL, 'ok', 2, 137, 1, '2024-04-22 07:17:43', '2024-04-22 07:17:43', NULL),
(15, 'f90307bd-e502-4d74-9bc4-1e160010a0ff', 1, 1, 10, NULL, NULL, 'ok', 2, 138, 1, '2024-04-26 03:40:23', '2024-04-26 03:40:23', NULL),
(16, 'f9314e7d-aa60-40d5-95ad-c7c0bc85e469', 1, 1, 10, NULL, NULL, 'ghh', 2, 139, 1, '2024-04-30 08:00:17', '2024-04-30 08:00:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `materials_stock_management`
--

CREATE TABLE `materials_stock_management` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `opeing_stock_date` date DEFAULT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `materials_stock_reports`
--

CREATE TABLE `materials_stock_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `instock` varchar(255) DEFAULT NULL,
  `addstock` varchar(255) DEFAULT NULL,
  `lessstock` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `material_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) DEFAULT NULL,
  `report` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `material_issues`
--

CREATE TABLE `material_issues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `opeing_stock_date` date DEFAULT NULL,
  `material_id` bigint(20) UNSIGNED NOT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `material_issue_stocks`
--

CREATE TABLE `material_issue_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED DEFAULT NULL,
  `store_id` bigint(20) UNSIGNED DEFAULT NULL,
  `material_id` bigint(20) UNSIGNED DEFAULT NULL,
  `in_stock` varchar(255) DEFAULT NULL,
  `add_stock` varchar(255) DEFAULT NULL,
  `less_stock` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `total_qty` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) DEFAULT NULL,
  `report` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material_issue_stocks`
--

INSERT INTO `material_issue_stocks` (`id`, `project_id`, `store_id`, `material_id`, `in_stock`, `add_stock`, `less_stock`, `code`, `total_qty`, `company_id`, `action`, `report`, `type`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '0', '200', '-200', '6651bca645bbe4', '', 2, 'bulk', NULL, 'add', '2023-10-03 08:02:08', '2023-10-03 08:02:08'),
(2, 2, 2, 2, '0', '200', '-200', '6651bf29155b1f', '', 1, 'bulk', NULL, 'add', '2023-12-05 05:52:17', '2023-12-05 05:52:17'),
(3, 2, 2, 2, '200', '200', '0', '6651bf29155b1f', '', 1, 'bulk', NULL, 'edit', '2023-12-05 05:53:21', '2023-12-05 05:53:21');

-- --------------------------------------------------------

--
-- Table structure for table `material_opening_stocks`
--

CREATE TABLE `material_opening_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `opeing_stock_date` date DEFAULT NULL,
  `material_id` bigint(20) UNSIGNED NOT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material_opening_stocks`
--

INSERT INTO `material_opening_stocks` (`id`, `uuid`, `project_id`, `store_id`, `opeing_stock_date`, `material_id`, `qty`, `company_id`, `is_active`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '8a5ed8c3-1cb4-4480-ab2b-0b5dcee61818', 1, 1, '2023-10-12', 1, '200', 2, 1, NULL, '2023-10-03 08:02:08', '2023-10-03 08:02:08'),
(2, '8bd1cfac-c2f8-4b07-b14f-1af4947d71b0', 2, 2, '2023-12-08', 2, '200', 1, 1, NULL, '2023-12-05 05:52:17', '2023-12-05 05:53:21');

-- --------------------------------------------------------

--
-- Table structure for table `material_requests`
--

CREATE TABLE `material_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `projects_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sub_projects_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `request_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material_requests`
--

INSERT INTO `material_requests` (`id`, `uuid`, `name`, `date`, `details`, `remarks`, `projects_id`, `sub_projects_id`, `user_id`, `company_id`, `is_active`, `created_at`, `updated_at`, `request_id`) VALUES
(2, '01094694-b6e4-4d31-986d-1d562311491a', '2024-03-07', '2024-04-03', 'test', 'test', 1, 4, 2, 2, 1, '2024-04-03 02:02:23', '2024-04-03 02:02:23', '04461346'),
(3, '9b24a207-11ca-44d9-9022-16ca7d92af91', '2024-03-16', '2024-04-03', 'test', 'test', NULL, NULL, 2, 2, 1, '2024-04-03 02:03:06', '2024-04-03 02:03:06', NULL),
(4, '83ffccf7-d385-4220-a84c-0a27275dba41', '2024-04-07', '2024-04-04', 'test', 'test', NULL, NULL, 2, 2, 1, '2024-04-04 08:03:38', '2024-04-04 08:03:38', NULL),
(5, '58271cb1-f1fe-42bc-81a5-8e2859e426d4', '2024-04-16', '2024-04-08', 'test', 'test', NULL, NULL, 2, 2, 1, '2024-04-08 05:37:10', '2024-04-08 05:37:10', NULL),
(6, 'dab7074c-8dac-4291-a3e2-89c5cde87c16', '2024-04-16', '2024-04-16', NULL, NULL, 1, 4, 2, 2, 1, '2024-04-16 05:58:16', '2024-04-16 05:58:16', NULL),
(7, '0ba8973a-d830-43af-805c-5c643ab8205c', NULL, '2024-04-16', NULL, NULL, NULL, NULL, 2, 2, 1, '2024-04-16 06:01:45', '2024-04-16 06:01:45', NULL),
(8, '2811934a-507b-4a26-bf34-dd6dd909e84a', '2024-04-30', '2024-04-30', NULL, NULL, 1, 1, 2, 2, 1, '2024-04-30 08:22:59', '2024-04-30 08:22:59', NULL),
(9, 'd311a89c-731d-476b-b5eb-9dcd8736c122', '2024-05-01', '2024-05-01', NULL, NULL, 1, 1, 2, 2, 1, '2024-05-01 01:27:59', '2024-05-01 01:27:59', NULL),
(10, '10fcb9f2-15af-4d6f-84be-b1d48c639549', '2024-05-01', '2024-05-01', NULL, NULL, 32, NULL, 2, 2, 1, '2024-05-01 06:38:39', '2024-05-01 06:38:39', NULL),
(11, 'a90fc338-2e73-4703-9ce5-21a11019fb60', '2024-05-02', '2024-05-02', NULL, NULL, 1, 1, 2, 2, 1, '2024-05-02 04:06:53', '2024-05-02 04:06:53', NULL),
(12, 'bf7aa98a-4128-4c39-8686-1cd58c7e2b18', '2024-05-02', '2024-05-02', NULL, NULL, 32, 1, 2, 2, 1, '2024-05-02 05:10:17', '2024-05-02 05:10:17', NULL),
(13, '92b864da-6d4a-42ed-b362-255e17737b98', '2024-05-03', '2024-05-03', NULL, NULL, 1, 4, 2, 2, 1, '2024-05-03 06:08:41', '2024-05-03 06:08:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `material_request_details`
--

CREATE TABLE `material_request_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `projects_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sub_projects_id` bigint(20) UNSIGNED DEFAULT NULL,
  `materials_id` bigint(20) UNSIGNED DEFAULT NULL,
  `material_requests_id` bigint(20) UNSIGNED DEFAULT NULL,
  `activities_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date` date DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `request_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material_request_details`
--

INSERT INTO `material_request_details` (`id`, `uuid`, `projects_id`, `sub_projects_id`, `materials_id`, `material_requests_id`, `activities_id`, `date`, `qty`, `remarks`, `company_id`, `is_active`, `created_at`, `updated_at`, `request_id`) VALUES
(1, '15d42ebf-ab72-460d-973b-b64461962156', 1, 1, 3, 2, 1, '2024-04-20', 10, 'ok', 2, 1, '2024-04-16 06:04:12', '2024-04-16 06:04:12', '04461346'),
(3, '250b0018-c153-45d1-8a84-d4518b092ad7', 32, NULL, 3, 2, 1, '2024-05-10', 10, 'ok', 2, 1, '2024-05-01 06:42:06', '2024-05-01 06:42:06', '57304483'),
(4, 'dcd1d031-0914-4f9e-a922-a27ee6db4d18', 1, 1, 3, 11, 1, '2024-05-10', 20, 'ok', 2, 1, '2024-05-02 05:00:03', '2024-05-02 05:03:18', '97721100'),
(5, '4f2aa02e-a06a-4283-bb41-bdaef0f53fa3', 32, 1, 5, 12, 35, '2024-05-09', 21, 'sure', 2, 1, '2024-05-02 05:10:34', '2024-05-02 05:40:46', '97294799'),
(6, '965a780f-f81e-4c91-940b-3e501e1ae0f0', 32, NULL, 8, 12, 45, '2024-05-11', 11, 'okay', 2, 1, '2024-05-02 05:16:53', '2024-05-02 05:54:04', '41341708'),
(7, 'fefe5ec4-cfb0-43c6-9dea-5fa36fffcb63', 32, 1, 5, 11, 35, '2024-05-09', 21, 'sure', 2, 1, '2024-05-02 05:30:24', '2024-05-02 05:32:44', '35741278'),
(8, '397d4660-991a-4eb7-b334-26d823956447', 32, NULL, 9, 12, 86, '2024-05-11', 150, 'op', 2, 1, '2024-05-02 05:52:57', '2024-05-02 05:52:57', '61435857'),
(9, '9598abf5-8d69-434e-9d44-4607548b97a8', 1, 1, 3, 13, 36, '2024-05-10', 10, 'ok', 2, 1, '2024-05-03 06:20:17', '2024-05-03 08:06:15', '11547684'),
(10, '32692888-b27d-4cf7-9ff4-b06baf7b361d', 1, 1, 23, 13, 53, '2024-05-18', 10, 'ok', 2, 1, '2024-05-03 07:47:41', '2024-05-03 07:47:41', '63145873');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `mediaable_type` varchar(255) NOT NULL,
  `mediaable_id` bigint(20) UNSIGNED NOT NULL,
  `media_type` varchar(255) NOT NULL COMMENT 'Please add document or image description in this field',
  `file` varchar(255) NOT NULL,
  `alt_text` varchar(100) DEFAULT NULL,
  `is_profile_picture` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = No, 1 = Yes',
  `meta_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Meta details are use for advertisement and seo purpose' CHECK (json_valid(`meta_details`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu_managments`
--

CREATE TABLE `menu_managments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `position` varchar(255) DEFAULT NULL,
  `lable` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `site_page` varchar(255) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `is_approve` tinyint(4) DEFAULT 1 COMMENT '0:Unapproved,1:Approved',
  `is_blocked` tinyint(4) DEFAULT 0 COMMENT '0:Unblocked,1:Blocked',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_managments`
--

INSERT INTO `menu_managments` (`id`, `uuid`, `position`, `lable`, `type`, `url`, `site_page`, `is_active`, `is_approve`, `is_blocked`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'b9bfe84c-9a80-428f-af22-850d20420b8a', 'header', 'Home', 'external', NULL, 'http://3.108.121.124/koncite/construction-app-admin/', 1, 1, 0, '2023-09-22 11:48:56', '2023-09-22 11:48:56', NULL),
(2, 'b070deeb-a6ed-4ac8-88eb-431263903a14', 'header', 'About', 'internal', NULL, '2', 1, 1, 0, '2023-09-22 11:53:00', '2023-09-22 11:53:00', NULL),
(3, '6ba65562-af76-4a37-b7ab-98a3157472da', 'header', 'Product', 'internal', NULL, '3', 1, 1, 0, '2023-09-22 11:57:46', '2023-09-22 11:57:46', NULL),
(4, '10a63382-7e2d-4639-9eb1-235d7999c33e', 'header', 'Contact Us', 'internal', NULL, '7', 1, 1, 0, '2023-09-22 12:05:27', '2023-09-22 12:05:27', NULL),
(5, 'c529d7d4-eee2-4483-8be6-ee632f09aa0a', 'footer', 'Home', 'external', NULL, 'http://3.108.121.124/koncite/construction-app-admin/', 1, 1, 0, '2023-09-25 06:04:46', '2023-09-25 06:04:46', NULL),
(6, '61ad464b-b063-4b61-914c-6a26258c69ce', 'footer', 'About', 'internal', NULL, '2', 1, 1, 0, '2023-09-25 06:05:15', '2023-09-25 06:05:15', NULL),
(7, 'b12d8abe-b742-40db-9351-867eb51b2ede', 'header', 'test', 'internal', NULL, '8', 0, 1, 0, '2023-11-28 09:32:26', '2023-11-28 09:32:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_11_000000_create_admin_roles_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(4, '2014_10_12_100000_create_password_resets_table', 1),
(5, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(6, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(7, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(8, '2016_06_01_000004_create_oauth_clients_table', 1),
(9, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(10, '2019_08_19_000000_create_failed_jobs_table', 1),
(11, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(12, '2023_03_16_120005_create_admin_profiles_table', 1),
(13, '2023_03_16_120356_create_admin_menus_table', 1),
(14, '2023_03_16_120358_create_company_managments_table', 1),
(15, '2023_03_16_120358_create_company_roles_table', 1),
(16, '2023_03_16_120359_create_profile_designations_table', 1),
(17, '2023_03_16_120360_create_company_users_table', 1),
(18, '2023_07_18_080526_create_companies_table', 1),
(19, '2023_07_19_070255_create_projects_table', 1),
(20, '2023_07_19_070256_create_clients_table', 1),
(21, '2023_07_19_140942_create_sub_projects_table', 1),
(22, '2023_07_19_141136_create_store_warehouses_table', 1),
(23, '2023_07_19_141153_create_teams_table', 1),
(24, '2023_07_19_141155_create_units_table', 1),
(25, '2023_07_21_100323_create_labours_table', 1),
(26, '2023_07_21_101634_create_vendors_table', 1),
(27, '2023_07_21_102142_create_assets_table', 1),
(28, '2023_07_25_150708_create_admin_permissions_table', 1),
(29, '2023_07_25_150830_create_admin_user_roles_table', 1),
(30, '2023_07_25_150842_create_admin_user_permissions_table', 1),
(31, '2023_07_25_150854_create_admin_user_role_permissions_table', 1),
(32, '2023_07_27_204747_create_page_managments_table', 1),
(33, '2023_08_02_070256_create_banner_pages_table', 1),
(34, '2023_08_02_070301_create_home_pages_table', 1),
(35, '2023_08_02_124912_create_menu_managments_table', 1),
(36, '2023_08_05_212334_create_company_permissions_table', 1),
(37, '2023_08_05_212347_create_company_user_permissions_table', 1),
(38, '2023_08_05_212355_create_company_user_roles_table', 1),
(39, '2023_08_05_212418_create_company_role_permissions_table', 1),
(40, '2023_08_06_075456_create_media_table', 1),
(41, '2023_08_07_125827_create_company_role_managments_table', 1),
(42, '2023_08_08_150748_create_project_companies_table', 1),
(43, '2023_08_18_193325_create_companyuser_roles_table', 1),
(44, '2023_08_19_215612_create_project_subproject_table', 1),
(45, '2023_08_28_125844_create_activities_table', 1),
(46, '2023_08_28_125910_create_materials_table', 1),
(47, '2023_08_30_194800_create_opening_stocks_table', 1),
(48, '2023_09_07_080858_create_stock_managments_table', 1),
(49, '2023_09_07_080929_create_stock_reports_table', 1),
(50, '2023_09_08_125233_create_flights_table', 1),
(51, '2023_09_08_125436_create_materials_stock_management_table', 1),
(52, '2023_09_08_125451_create_materials_stock_reports_table', 1),
(53, '2023_09_15_114340_create_material_issues_table', 1),
(54, '2023_09_18_055945_create_material_issue_stocks_table', 1),
(55, '2023_09_18_055954_create_material_opening_stocks_table', 1),
(56, '2023_10_02_064500_create_assets_opening_stocks_table', 1),
(57, '2023_10_03_100438_create_countries_table', 1),
(58, '2023_10_03_100439_create_states_table', 1),
(59, '2023_10_03_100454_create_cities_table', 1),
(60, '2023_10_09_141313_create_subscription_packages_table', 1),
(61, '2023_10_09_141331_create_subscription_package_options_table', 1),
(62, '2023_10_11_074855_create_additional_features_table', 1),
(63, '2023_10_16_114224_add_field_to_company_managments_table', 1),
(72, '2023_11_21_104414_create_settings_table', 4),
(73, '2023_11_21_124132_create_contact_details_table', 4),
(74, '2023_11_21_124208_create_contact_reports_table', 4),
(77, '2023_11_22_123511_create_safeties_table', 6),
(78, '2023_11_22_123610_create_hinderances_table', 6),
(80, '2023_10_27_140922_create_assets_histories_table', 8),
(81, '2023_10_27_140948_create_activity_histories_table', 9),
(82, '2023_10_27_141006_create_labour_histories_table', 9),
(83, '2023_10_27_141020_create_materials_histories_table', 9),
(85, '2024_01_18_100544_update_company_users_table', 9),
(94, '2023_10_27_140921_create_dprs_table', 10),
(95, '2024_03_06_115022_add_user_id_to_dprs_table', 10),
(98, '2024_03_14_074701_create_quotes_table', 11),
(99, '2024_03_14_074702_create_goods_table', 11),
(101, '2024_03_21_040440_create_inv_inwards_table', 11),
(103, '2024_03_21_040450_create_inv_issues_table', 11),
(105, '2024_03_21_040503_create_inv_returns_table', 11),
(108, '2024_03_21_102119_add_type_to_materials', 13),
(109, '2024_03_20_142242_create_quotes_details_table', 14),
(120, '2024_03_06_115023_create_material_requests_table', 17),
(121, '2024_03_14_074700_create_material_request_details_table', 17),
(126, '2024_04_01_065526_create_inventories_table', 18),
(132, '2024_03_21_101451_add_request__id_to_material_request_details', 21),
(133, '2024_03_21_101451_add_request__id_to_material_requests', 22),
(134, '2024_03_26_131904_create_inward_stores_table', 22),
(136, '2024_03_26_131942_create_inv_return_stores_table', 22),
(143, '2024_03_26_131934_create_inv_issue_stores_table', 27),
(144, '2024_03_21_040439_create_inv_inward_entry_types_table', 28),
(145, '2024_03_21_040441_create_inward_goods_table', 29),
(146, '2024_03_21_040451_create_inward_goods_details_table', 29),
(148, '2024_04_02_152309_add_column_to_inward_goods', 29),
(149, '2024_03_21_040442_create_inv_issue_lists_table', 30),
(150, '2024_03_21_040452_create_inv_issue_goods_table', 30),
(151, '2024_03_21_040502_create_inv_issues_details_table', 30),
(152, '2024_03_21_040504_create_inv_return_goods_table', 30),
(153, '2024_03_21_044545_create_inv_returns_details_table', 30),
(154, '2024_04_09_132654_create_inventory_stores_table', 30),
(155, '2024_04_02_141857_add_column_to_inward_goods_details', 31),
(156, '2024_04_03_154712_add_qty_to_inventories', 32);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('00b771333b5ad1a9f7e63373241166c31936c8ab41cda5ad7201b8d3b8ec3e53d1daf996003f7eb4', 18, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 1, '2023-11-30 23:26:21', '2023-11-30 23:29:06', '2024-06-01 04:56:21'),
('03fde05d80b18e174d1e63912bedff7f0ea95d403ffdea544e54fdb8fcb1c5cb20f9085cdf8f46c4', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 1, '2023-10-05 07:43:20', '2023-10-05 14:52:52', '2024-04-05 07:43:20'),
('084d464f0b36461980d6ebc2b24814cedc8ab23c5f340698a44ddb980c98d93fb31eaf6d87d49084', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-03 14:31:26', '2023-10-03 14:31:26', '2024-04-03 14:31:26'),
('0852bf1b6c48995fce569a57e055087ca1aa7b41cbb497d4c9d3e720c92d5f2837de9b898ca41ac2', 3, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 1, '2023-10-03 13:41:04', '2023-10-03 14:22:29', '2024-04-03 13:41:04'),
('0ae4a4b3886c2845d31552485dad529483b4ee06897b36c77198eefe646b509a1a753d12c9a1bcbb', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-23 02:12:19', '2024-02-23 02:12:20', '2024-08-23 07:42:19'),
('0c6f18e477ed38bb2edb5f2a6a14a69ee717b0da1c853138944d227640796b104a56a7ae0f783dfc', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-01-25 07:46:27', '2024-01-25 07:46:27', '2024-07-25 13:16:27'),
('0c81ef9dff7278dd3fb50f2e6e62ec3a1fcb45e1c1f1044c3b38037e9dcf6d0d18756e97e1bb18b1', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-26 04:00:14', '2024-02-26 04:00:14', '2024-08-26 09:30:14'),
('0d09a1e557555cf962a95ef5248751cce79a56f30bee6e43bfd43f7d8059742613ccee01046fa4c4', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-11-21 01:28:47', '2023-11-21 01:28:47', '2024-05-21 06:58:47'),
('13bcf116dcf643857fe04d094a73313be0d2c831addde025847ae1c6581a19b5ae6e399dd7148332', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-05 07:45:41', '2023-10-05 07:45:41', '2024-04-05 07:45:41'),
('1c4ecbc88d310fcf7cd00cd40ece9a1fc6f236804ff4309fe6305c644c7391b958831e3b45439b99', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-02 07:29:06', '2024-02-02 07:29:06', '2024-08-02 12:59:06'),
('1f3e249533020cfd7fae674a06cbf92f76a855999f72b5308e867135ee67e16736e23fdc689d98d4', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-05 06:12:50', '2023-10-05 06:12:50', '2024-04-05 06:12:50'),
('1f3fa7706b73bf84a92ebe6a969c038c3b49b728899be2d654074384e21761c84bd51bdd3d80fd96', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-04 14:50:08', '2023-10-04 14:50:08', '2024-04-04 14:50:08'),
('211a19652adbe3ee43c30533c34345a890fa700becbbe2fc53059887a99fcd55aeb06e13ba3de52c', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-21 18:31:22', '2023-10-21 18:31:22', '2024-04-21 18:31:22'),
('23fb93f6e6e288347e2f13ff6193f0a984d9536f58348399c568328a95f1075d772e75f11568a477', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-04 10:47:12', '2023-10-04 10:47:12', '2024-04-04 10:47:12'),
('2689596270e0fbd418205ba85a95bf99911281b9afec7770533bb848bb7dd2ffaf94824451909d77', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-05 00:52:01', '2024-02-05 00:52:01', '2024-08-05 06:22:01'),
('27f276fc03c49596248699be839525b80fe37225b6fa8186e6a4e1033b30791b546fa7244dc14c20', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-04-16 05:04:33', '2024-04-16 05:04:33', '2024-10-16 10:34:33'),
('286b3473cbb1cb317c29c3d5f9f709eefe2ea9519b12fffe3e907be91bcdaffcaf1e670aaaf6268d', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-21 05:55:48', '2024-02-21 05:55:48', '2024-08-21 11:25:48'),
('287c088b4266306cdb28f738c14db850a9ee58ef1de7f458c2556b9d36010be72308fa011db22919', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-04-09 03:42:56', '2024-04-09 03:42:56', '2024-10-09 09:12:56'),
('2923664e34fbad78afd6c9a2849ddeef0b8995d9945a3949a259cc2bc37b63a75ae06f0449a04d68', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-01-31 08:24:07', '2024-01-31 08:24:07', '2024-07-31 13:54:07'),
('2b57fae67774449b32a30834f851927305b7b606fdeaabb191f974c39852e01dec1da6a67bbfaf4f', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-04 11:10:50', '2023-10-04 11:10:50', '2024-04-04 11:10:50'),
('2c7e09ecfc354fe9678d406bc0d6a7bd366d286d1775d0c22f8bd569d0f92d24f38436ccc81439db', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-03-01 06:12:59', '2024-03-01 06:12:59', '2024-09-01 11:42:59'),
('2def67299a064093e0b599250a8630e15f32074d36305f110689c6a59c3eb3a91cf46b75bac1bbc3', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 1, '2023-10-03 14:32:00', '2023-10-03 15:09:54', '2024-04-03 14:32:00'),
('2ec967c4992ff3c33a58d403e70d584c991288a315f3c154fd4fc00ceb822c932528e6c05c8c1887', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-03-06 06:04:49', '2024-03-06 06:04:50', '2024-09-06 11:34:49'),
('2f318330734395bbc0925e7ba262c4cc4f05d77e1ef4e15c4754ccb6c527698403da79f8aae1636a', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-04 11:14:29', '2023-10-04 11:14:29', '2024-04-04 11:14:29'),
('2f5c42b29da00e9d9fe0d7a3ece255516c2b7120d5a3db2331b129c8239c49633da3b5b5c974c95d', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-16 08:25:00', '2024-02-16 08:25:00', '2024-08-16 13:55:00'),
('2fc699e3d8a6ad0ffd1ad5d17d2927ea1c340cbc8e56b8feedc881d829ec538a20e50a86e15bbb33', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 1, '2024-02-11 13:15:23', '2024-02-11 13:20:13', '2024-08-11 18:45:23'),
('3033592bfa105ceae875190c6bc19d3e62b9e9ff09c52c8c66f340f80540fee69d23b7e07113abe6', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 1, '2024-03-13 04:41:11', '2024-03-13 04:41:18', '2024-09-13 10:11:11'),
('304ccf1d6489a1d18284e74785fb4055c8220fbd5ccd98c01611137a84a83ee966fe9323ac3c3402', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-01-30 07:53:51', '2024-01-30 07:53:51', '2024-07-30 13:23:51'),
('3194063b05f00a1d58a3c4c0f62a231748fb40fac37c0c5595616ff94eff4b5882b13a66557ba969', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 1, '2024-02-11 12:55:21', '2024-02-11 13:10:12', '2024-08-11 18:25:21'),
('31d46c84a664f2e2fcfbd2d425b4bf82475121d3d2d2a26e545be18ac2834d3963cfc5ebcaffb55a', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-05 08:19:54', '2023-10-05 08:19:54', '2024-04-05 08:19:54'),
('36222449325466d0e1b1cfffa92042ba515437f5a200ec4cbd78e25c131993d72b23d678fb98b2bf', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-01 03:58:35', '2024-02-01 03:58:35', '2024-08-01 09:28:35'),
('37a9f3ed998d27d45da4e83ffad323aa3cb78770936ba15c6fb44fbba1e9dc05b8ce2e1168e5f1b7', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-26 02:34:02', '2024-02-26 02:34:02', '2024-08-26 08:04:02'),
('3b1b7faebbc8fcf4532ed7f26830ad8daf57363898e80230a395dc55690043262b726eb256d96700', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-05-02 04:04:06', '2024-05-02 04:04:06', '2024-11-02 09:34:06'),
('3bc0834c16f823e8dffe967a3baa4be84768472eb891a0a60f8fcf580a36d34de6bb17a279a8fbb6', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-03-04 01:09:54', '2024-03-04 01:09:54', '2024-09-04 06:39:54'),
('3d642cd4010f5f6b60fbc07a44204a7b943acfd167a65024c797790f5eb0a86e551c485646872ee8', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-01-17 06:59:21', '2024-01-17 06:59:21', '2024-07-17 12:29:21'),
('41320194158f63c1548d345c9359881a0edfad786823888b0162101fa30f92f9400394c4551136a3', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-05 06:27:21', '2023-10-05 06:27:21', '2024-04-05 06:27:21'),
('41f72b659ad7d8ee498e0844873ce26d1539235aea627809c5d6e8b1b4691908ea7ecdac5a299ead', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-01-18 07:36:05', '2024-01-18 07:36:05', '2024-07-18 13:06:05'),
('42fd8c75a3a6c1d2fe6e4f803268c69bf2506749a275321e27f9cd9e68f18e62a3636fb54fbeb969', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-01-17 09:08:44', '2024-01-17 09:08:44', '2024-07-17 14:38:44'),
('45f14f5ab590e11d9081dc55dc4cfa724bb1262a4484ce6c726e2b0d947bcd6c037bde325db1061b', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-23 02:30:48', '2024-02-23 02:30:48', '2024-08-23 08:00:48'),
('479d383628cb05883ae14b275ea75416965b6ecbf3c0fb4215fcb506ed0847bd7e4a3dd975387a07', 16, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-05 14:53:49', '2023-10-05 14:53:49', '2024-04-05 14:53:49'),
('48d8809301b48e7f51a1087031fa7dc8edc5260a4146cd2b7fcbaf1e39023bd308018905fe971952', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-01-17 09:12:19', '2024-01-17 09:12:19', '2024-07-17 14:42:19'),
('491e2e85e7f3815b4051c918c56fb5ef1bf1a9145bac12dbf136bc1b43aa16d9c7d5a1a7d01837f6', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-20 08:05:39', '2023-10-20 08:05:39', '2024-04-20 08:05:39'),
('497a319b41b1f1b81d2b2a81a3f7c178133489c544fa5a42b44d053e4448d3a3c33bbcaffbca23c6', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-05-06 14:46:18', '2024-05-06 14:46:18', '2024-11-06 20:16:18'),
('49c0508a1a495296ab82dd3d5d154984dd4d48cf61c4eb5afc76ac5230744eb49d3670a7c36bb706', 12, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 1, '2023-10-03 12:27:41', '2023-10-03 13:40:50', '2024-04-03 12:27:41'),
('4a24678986166ccdd5159a15292dc8068ea89d17eef4cd0bc48ef67a0eb38e2d453592c1856ffd0d', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-01-18 05:34:09', '2024-01-18 05:34:09', '2024-07-18 11:04:09'),
('4bd23260b7d71ff03d87adb064377243c1523bdd1a04ca38a5415d6ef0110db6e45296c873bef203', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-03 14:33:25', '2023-10-03 14:33:25', '2024-04-03 14:33:25'),
('4f9fc3761e8c4617bf68affe768dc1fd9adb2a94a1830a514e2f281f24a0d433b0279ba420cd8a8b', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-02 05:07:57', '2024-02-02 05:07:57', '2024-08-02 10:37:57'),
('506abebaa3e8aee522db4c841726a6e1c57f8fa4ff875486a424456e37bca0bd3ed4156b4e757e4d', 24, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 1, '2024-01-09 05:18:40', '2024-01-10 00:48:55', '2024-07-09 10:48:40'),
('5470991b057aa115e69a3ff888159278641c35cc95bde9236bb3aba69917b299516b64f9200e0288', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-01-16 02:32:43', '2024-01-16 02:32:43', '2024-07-16 08:02:43'),
('56d1e9d35dab3140af1c96197b7b19a71911d9769fef5b193e21d6912f9b6d8b5e6144ab0de21989', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-01-16 01:58:57', '2024-01-16 01:58:57', '2024-07-16 07:28:57'),
('5a5705bf770eba55f6613290c1dcb5cd57463eb36197d9de4ed5534480e7f5cb87dd93b6b68f9ced', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-03 09:44:04', '2023-10-03 09:44:04', '2024-04-03 09:44:04'),
('5e691b5839ae147d4b02382982a759a0c549b794fa0545895c27d1d21b514658d9e98fcdfd00bb17', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 1, '2024-02-11 13:11:45', '2024-02-11 13:14:51', '2024-08-11 18:41:45'),
('623164865b652362c0ad8944faa6af7841f1bc837ff0be164e26fe24896aed1c346bd40b80cd4921', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-25 05:53:10', '2023-10-25 05:53:10', '2024-04-25 05:53:10'),
('65092defc22d7da25ec880959e84e5570f81c6048a068160f15f16a557c1c380a90766a15c8a8a05', 18, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 1, '2023-11-30 23:29:31', '2024-03-13 01:30:30', '2024-06-01 04:59:31'),
('67915963dc97b9b45fa6eeb7003e05db898dfe194af879aeede27ea77fa43d004f4ae7a83d7af117', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-04-10 01:09:10', '2024-04-10 01:09:10', '2024-10-10 06:39:10'),
('67cb847d60573fc2d0cb09d6b23933c52103250ceaba24cd8c8b7a74e99165896706a85b63f0b7a8', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-05 08:29:30', '2023-10-05 08:29:30', '2024-04-05 08:29:30'),
('67f693daea5144ccebaa020e47c16628505b96f7dde2ebbde558a109b7abb2881a3c24cf7d3fe066', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-01-30 05:39:58', '2024-01-30 05:39:58', '2024-07-30 11:09:58'),
('6818066f32b0251c3670270bea715ce46a792227f64c6ec2169cdb3de41bf27b015851968b468c8b', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-03-01 04:27:17', '2024-03-01 04:27:17', '2024-09-01 09:57:17'),
('699545f140caa46b91de1c24f03778f55c9959194ded43e4fe78f94cb35a0eb3693d06188f94d707', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-01-31 00:39:48', '2024-01-31 00:39:48', '2024-07-31 06:09:48'),
('69c7c60b1a7ff4f605beefeb0d749184f6dd47831cb2768a6e326a94dce3640f819a207ce56296b3', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-16 01:53:18', '2024-02-16 01:53:18', '2024-08-16 07:23:18'),
('6b385323cab86237f363faa2f1369db63357e156d120348cc937c114a2626ca27baa307f4bf7f8d9', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-04-01 23:02:13', '2024-04-01 23:02:13', '2024-10-02 04:32:13'),
('6e10dc9aca24e470430c1f72285f77e55002e974fa6c1308b9bab6a935c096ada9281661265b1df5', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-27 02:10:04', '2024-02-27 02:10:05', '2024-08-27 07:40:04'),
('6e5c729d957479cfe311e84a1a843ce789ca14ae6b8c158a3abc2686d4614ff886974e959fd728b6', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-09 06:02:09', '2024-02-09 06:02:09', '2024-08-09 11:32:09'),
('71a4012081902249eee536d58cda9c3634d625031dcd070e0ba62f655190bf72d7f1cad353404278', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-22 07:20:49', '2024-02-22 07:20:49', '2024-08-22 12:50:49'),
('74a0e717d6837a157076b13ad59284d07dc1a6aa883b0d246d84d9a1397036825a2c871edadc0a91', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-01-16 00:07:08', '2024-01-16 00:07:08', '2024-07-16 05:37:08'),
('76dd3c23ce687ced3419105593b570cfb16698e1a0a48e708d784e0022f7c4cd947a55fdedad97cc', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-04-16 08:09:05', '2024-04-16 08:09:05', '2024-10-16 13:39:05'),
('7732ee887a9688616c175b452bd77cbf2c34c726fe6f126683afbd10e8dee68a4b80e86c4b22ceab', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-03 09:43:15', '2023-10-03 09:43:16', '2024-04-03 09:43:15'),
('7ae0911954710a37cca14d1b29f62a02dc776b3c1fef0d8c2b5d9f2f19e38e06fb7a7efc259eef8f', 3, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-03 12:20:04', '2023-10-03 12:20:04', '2024-04-03 12:20:04'),
('7be2c5fa974b500d48fcc402913cf80c991dbe356b1584aaac6013608f991e8f49db4280693795b1', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-03 15:12:01', '2023-10-03 15:12:01', '2024-04-03 15:12:01'),
('7c444af3b8990ac92d734855536d7d9b45e2765c21658676ef5cfd140112ce32555ad11324ef8847', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-13 06:04:30', '2023-10-13 06:04:31', '2024-04-13 06:04:30'),
('7d48724170e15d9562a87ae878aa5a6b0d78e5fe115cede064320b346a9fa18c59fef2396dbc390b', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-04-02 08:26:52', '2024-04-02 08:26:53', '2024-10-02 13:56:52'),
('7f80ba355c6386b906752ea274ec02589c658cfc52f6cc709f92cda638fd5b19b94a932bda2acf46', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-04-08 04:30:07', '2024-04-08 04:30:07', '2024-10-08 10:00:07'),
('8020539c9d76c04ee69a4b8e59a299ef9eafd56c05ef220967d1a4ed880a045339c7f502fa0c601d', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-01-10 01:04:52', '2024-01-10 01:04:52', '2024-07-10 06:34:52'),
('80bf699083ec929cd60430006020903b9eb55d279e656ceaa29b549487b67a2afb2f6bd628565f60', 24, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 1, '2024-01-10 00:50:06', '2024-01-10 01:12:49', '2024-07-10 06:20:06'),
('814a5fb384140242e9f54835ae3baa269acf723fee514bb6076bcb18e5f5a99dacdcf250ce982d9b', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-03 14:17:42', '2023-10-03 14:17:42', '2024-04-03 14:17:42'),
('81c51f8a5e9f1878cb9924dc82afe90ce326d1bc4a423e608bb0cf1eb7b59bcd3b545af7ffbe5437', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-03-12 03:05:06', '2024-03-12 03:05:06', '2024-09-12 08:35:06'),
('81f9d112ede7346f49ecb07083c9d0f0889a26283e82db7cab824c738630c4673113d6e21e550834', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 1, '2024-04-08 04:06:41', '2024-04-08 04:08:45', '2024-10-08 09:36:41'),
('835829f023193a3660f205639e3e84a4611e20b885d203d50b3cb7a6d67372be917d31b7e7f137c2', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-30 11:04:56', '2023-10-30 11:04:56', '2024-04-30 11:04:56'),
('8373692d9e8f0c7a2087770f8445987d2e9b1358b93d231a0985351bb69c2ff403c59ca2fc33bdf3', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 1, '2024-01-12 08:55:11', '2024-01-12 09:01:40', '2024-07-12 14:25:11'),
('842f2036fb5c6cd2a6cde2499dc02a4f56e4db6ca579b76f52d151684ea45a0496cd037ffc9dae4b', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-30 11:39:51', '2023-10-30 11:39:51', '2024-04-30 11:39:51'),
('8569e86a3646f22a06b5c2fe84ffc721c35b1ecf149b3dff8190d97114ccd07435e462ff8aff648e', 8, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 1, '2023-10-03 14:27:57', '2023-10-03 14:31:49', '2024-04-03 14:27:57'),
('85a2dc20c0d08c87e3303eb54cbcbbec9af1be1f2b3e124ca19c414dc2b3ce85b6ab4bdef20026ce', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-12 10:14:50', '2023-10-12 10:14:50', '2024-04-12 10:14:50'),
('8815c049d5418283c5328139d414bf86b5a96b4b6c512ce4610c70c24dfaab0175754cff01f15225', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-11 06:17:48', '2023-10-11 06:17:48', '2024-04-11 06:17:48'),
('8aeefa579b84cf9ee12bef2c33d877c4f1dee45a4d7d52740d19803aad6dbe1911c22734c2aa3ec5', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-01-12 08:44:37', '2024-01-12 08:44:37', '2024-07-12 14:14:37'),
('8b2621f0b6f358c8cca1d43599ac40efe52562b73356e49cd090519cba2b218b0282918200561c25', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-13 14:46:49', '2023-10-13 14:46:49', '2024-04-13 14:46:49'),
('8eaae96dbffa312b408ffb2c5f36771f22f1b15f5b70ba591b5a665d939a3c7b77d421f9c65869f3', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-20 18:30:57', '2023-10-20 18:30:57', '2024-04-20 18:30:57'),
('907c5fe970f54143f5d8cdf180d3af9c574730be8b731df273548de197355ac6fc4636c8daa03dfe', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-03-01 07:09:45', '2024-03-01 07:09:45', '2024-09-01 12:39:45'),
('939315691f2de3a137f1f5f3e67c19f962bc07dce3832f412ad95708e2758218280282fd8d5e7a02', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-05 13:30:22', '2023-10-05 13:30:22', '2024-04-05 13:30:22'),
('96710a3985f7fd9dee06028d20299baaaf881dfbc1681dc637661437ad26db561c27c88d20328820', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-17 09:35:23', '2024-02-17 09:35:23', '2024-08-17 15:05:23'),
('96b4a71508d7f34090dd9f4f0be7c4845ce1ca8c1960969e3a8d383b8ccc277a8d5b120e08431bba', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-22 18:32:17', '2023-10-22 18:32:17', '2024-04-22 18:32:17'),
('96db6e3e696e34fa0bd61094b3400d760c17d91cb813273945b482298f7d06bfbff83212e579cab2', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-01-19 08:37:09', '2024-01-19 08:37:09', '2024-07-19 14:07:09'),
('98360179d77f3407d4dc73cadb664bcc571c6397b2a6ff458014bf4e7dfeb81dac3011170ca88e3d', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 1, '2024-02-12 03:00:22', '2024-02-12 03:05:49', '2024-08-12 08:30:22'),
('9ebf1efaa240379d4c4aa1e098401bca3cac11c1245bd40b4f9d0367cd9c93c4b7e68a11f25d4710', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-01-12 09:17:19', '2024-01-12 09:17:19', '2024-07-12 14:47:19'),
('9ec146c39643cc11700de007da2abc591fdadbea7a3465a45c24af76fad403d50198a35c9cfac217', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-01-16 00:09:59', '2024-01-16 00:09:59', '2024-07-16 05:39:59'),
('a2b169290f22a3e13305f748419a990eb14a6892e9b28aea5cb18048fdb5f4c4c39921d786631c19', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-01 08:18:28', '2024-02-01 08:18:28', '2024-08-01 13:48:28'),
('a2e514550ee2c31cf596358fd7ec0422f2e237d8f60a11f9b830a5a38c79faf11b9e7daece47c1ad', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-11-01 02:14:56', '2023-11-01 02:14:56', '2024-05-01 07:44:56'),
('a31778d9a950fbe80ddaddf239cd0866dc00e38f55fc22689e8db577783d122a357b0df4da6b9851', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-05 11:27:26', '2023-10-05 11:27:26', '2024-04-05 11:27:26'),
('a4193dd235a46b8c300f75eb88072a971a1a8790ac210731af3e48abb57d577924aadb979a85603f', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-01-17 08:17:47', '2024-01-17 08:17:47', '2024-07-17 13:47:47'),
('a545cb5eb23fc3204d61be5708281e2f9e918915d6d90e56eb80792ec4936bcd1cc7501b2668cb32', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-02 07:18:13', '2024-02-02 07:18:13', '2024-08-02 12:48:13'),
('a7a65b875e6ee476268bcd8514b9d22b776cb254b98b2c076038736c11e70626579ca86788dc0edd', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-20 08:05:49', '2023-10-20 08:05:49', '2024-04-20 08:05:49'),
('a86e6557d18ede9d9f47c24a5e5710964d7443c1452ceed748f2a271017113ba7cf144fb9cb46942', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-16 06:38:03', '2024-02-16 06:38:03', '2024-08-16 12:08:03'),
('aaf96d36a64db91ff022df2ebc0b427d7cc734d38e397900cc532c5f617e18583f46455a1c382bb9', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-01-17 08:14:43', '2024-01-17 08:14:43', '2024-07-17 13:44:43'),
('b20470a275e8101d04d5f26f77b2a35a915c2fb1f202c91530da10ff8e55ff853a25bd7fdfe68348', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-04-04 08:03:18', '2024-04-04 08:03:18', '2024-10-04 13:33:18'),
('bae614fac2e9b071b52fea4a2c8c32bfe0e3e18a8c0e792ac5ac809cf72c6879eccc2956167f96ef', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-03-06 02:34:26', '2024-03-06 02:34:27', '2024-09-06 08:04:26'),
('bbf03b51f20f2097a770b5264393edfe5c16e15a0c71feff333fc4e353b80a115782af9ccb6acf57', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-03 10:29:39', '2023-10-03 10:29:39', '2024-04-03 10:29:39'),
('bcf159d9ea15179c716380ec74e985dbaf4edc6bcbefa66d3af25ab95499ccdab324ac22ce15e236', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-01-16 07:12:55', '2024-01-16 07:12:55', '2024-07-16 12:42:55'),
('bf7806d98252bf7b00dbb64c84f002f53a5b6acb0f896813e26790431b5ddc10a015fbc66a8c18c7', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-05 01:29:07', '2024-02-05 01:29:07', '2024-08-05 06:59:07'),
('bfd54c9a8c3dd889490868cde6eb150d0e9b7ba7e8217f6a05a818f9040b79a004581808aac4b85c', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-05 00:52:32', '2024-02-05 00:52:32', '2024-08-05 06:22:32'),
('c0874caf7de51e4f812e34a2aa3fa76a69fa21d9fbf69a749ef9f16baac66dd177a6e5307618ddb9', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 1, '2024-03-04 09:43:10', '2024-03-13 05:24:11', '2024-09-04 15:13:10'),
('c1f8851f2fd421896b58c2279cb79683ff0bcb8354d04b0f54477d3a580605bb297de8717eb93848', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-09 06:03:02', '2024-02-09 06:03:02', '2024-08-09 11:33:02'),
('c238c55dbc5eb571d428340ef025ddbb1a8840d06d41cdd4317cde6fa8a6a01988b1b5f671e33b6b', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-16 01:37:09', '2024-02-16 01:37:09', '2024-08-16 07:07:09'),
('c2e7b5e19d03cdc5c30f6fa76ed02847b92cd25149e82be7732bbc9dffe1db3fdead038ef6a019c7', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-22 08:46:10', '2024-02-22 08:46:10', '2024-08-22 14:16:10'),
('c6dbdd7464666bd209513f3900d5f6294edfe1ea13037072e5a0a2cde2bbd7a6578aba91d23c7fe9', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-16 06:49:19', '2024-02-16 06:49:19', '2024-08-16 12:19:19'),
('ca5c28242cb890dfacb5d326eaa050d23dd09ded20b04b148417543494f28e7cd0bd4dfe3421d354', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-20 07:57:06', '2023-10-20 07:57:06', '2024-04-20 07:57:06'),
('cabf9c6f3e1a5c0a5d80d6f7e5009933e58164745f935570c3838aa9e5f1db5e7d5f6d3f475c9e39', 3, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 1, '2023-10-03 15:10:50', '2023-10-03 15:11:49', '2024-04-03 15:10:50'),
('cca7f5bc942e61b34acfa9c2a51402384e0feaac7626bf40d8901b2f3457cc4ac5b1ec05fd3c8e21', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-27 12:41:03', '2023-10-27 12:41:03', '2024-04-27 12:41:03'),
('ceb5d69b07ab076fa808aaeba070a8f725579a4091988bb7f561c1b1c699cdf91cb471520f513bd3', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-29 03:19:17', '2024-02-29 03:19:18', '2024-08-29 08:49:17'),
('d02b208a5faf58b1aefecc9ed037f655f2c71422517ba0a444f08415350b3c1a36b20354c5c78cbe', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-11-28 03:13:03', '2023-11-28 03:13:03', '2024-05-28 08:43:03'),
('d191d809d24e73d9f3199bf8570ed69607aedb67baf01935bf3d32aa68669aca6d9ad51c665b263a', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-16 07:47:20', '2024-02-16 07:47:20', '2024-08-16 13:17:20'),
('d317a84775c877d516bf0272c5436693a543c47d0a051f287e359370ba118f91ca47f2d76eadfad2', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-09 07:06:05', '2024-02-09 07:06:05', '2024-08-09 12:36:05'),
('d41bd80fe92d21a188d5249ee28d3f8731129a210447f623e99ddd7e5752ae9b0338ebd1a14b4dde', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 1, '2024-01-10 01:14:05', '2024-01-17 09:11:29', '2024-07-10 06:44:05'),
('d48e6de3b344a82b4f733a1659b7cdde42f4969a13bea7bff608d227e87db520d876551b237bbb68', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 1, '2024-02-16 09:46:57', '2024-02-17 04:17:50', '2024-08-16 15:16:57'),
('d63022d8df7fd35e82e5131e5653f18df2ee821117923c6d1dd02b8cae710ddd8d5948c6f9402d9c', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-01-12 09:02:03', '2024-01-12 09:02:03', '2024-07-12 14:32:03'),
('d9fac789af1ba28faa3306f47cc546b5bb50e201374dfa1e595277977cb2c07db0e05cf82c994ad9', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-16 01:15:35', '2024-02-16 01:15:35', '2024-08-16 06:45:35'),
('da1c9f156646cbb0f47920be3b2dd1bce2534761c7d371e68a97a52aa5b6179638decd097226b733', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-03 09:39:41', '2023-10-03 09:39:41', '2024-04-03 09:39:41'),
('dc9a8715410acd68d8e442175f258024ff469c0aea9456f784d4e7fcfe3a687a3ea3af8e6d8a34db', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-01-10 01:06:23', '2024-01-10 01:06:23', '2024-07-10 06:36:23'),
('df045f46d7a73ca2c1dc956131ab7098536a4ef985ead7dbe8c226247aa8bd1ef73404ca23a6e9f5', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-03-01 07:15:37', '2024-03-01 07:15:37', '2024-09-01 12:45:37'),
('df577a928c942a60903d344f5c0b794590c48726a4097d9708a7e392ef7229d834df4ae178aba152', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-29 00:34:16', '2024-02-29 00:34:16', '2024-08-29 06:04:16'),
('df8f6e0a0d830bf41399e35ce042e09ebae33b12bd11bd6dbf4ce0dfa5ac72f4e5452e8637db5241', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-01-17 09:17:47', '2024-01-17 09:17:47', '2024-07-17 14:47:47'),
('e0398c5f1ce8ca7ec607f70fd31eca79a1f232e2d9ae588ed8ba33614fc118d36f1ccaaab7bcb610', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-03 07:44:03', '2023-10-03 07:44:03', '2024-04-03 07:44:03'),
('e14c4fcd5aa28521f86bf09d3059c819a6bc0cc1f3fce42fa4000786622653e7ad44e412d3fe531b', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 1, '2023-10-14 05:45:21', '2023-11-08 20:04:25', '2024-04-14 05:45:21'),
('e2af4eb74c2087c1eb2a350b988c6c081c26b062a1c0d12f640ba3c94bfe3d8583fb7262a6af7d7d', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-04-08 00:23:05', '2024-04-08 00:23:05', '2024-10-08 05:53:05'),
('e30529a78efe2719ee3b022231cd7a6b66520b2f4af8e02fac5617a2f42e545ffb45f0f42cf231c6', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-01-17 06:40:10', '2024-01-17 06:40:10', '2024-07-17 12:10:10'),
('e4ee248315b0af0156748817af54ffd74a5e4cba231dfb6776c805ffadec32eead6925b4bf025790', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-11-28 06:21:10', '2023-11-28 06:21:10', '2024-05-28 11:51:10'),
('e901ab1308a9863e8a6915b95775b6acce586f68e4babf893c3b90106b933c46d45e5c8c451806ee', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-09 07:25:38', '2024-02-09 07:25:38', '2024-08-09 12:55:38'),
('eb3362be75e02f109b0c696c275d8e318e40d3b6bbed81fc7351c74f4fa0d9e51c1692762c3b43d2', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-03-12 11:24:57', '2024-03-12 11:24:58', '2024-09-12 16:54:57'),
('ecb97269f012d44061bf4141df26ed6108f80684fff81b67fef051c95d3dad01ade7e5d7f7bea1d9', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 1, '2024-03-13 04:42:23', '2024-04-08 01:51:05', '2024-09-13 10:12:23'),
('ee023277a385cab8ec2ea9f6f892187851f612e92981b283c00071fc539d2c2a37fbee9fe6f03a8b', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-05 09:49:21', '2023-10-05 09:49:21', '2024-04-05 09:49:21'),
('ee30695eb84618e08182ef263fef389824e7d8915ac20c7ea06de76932b3316b6f79ac0d3c367d27', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-27 12:39:28', '2023-10-27 12:39:28', '2024-04-27 12:39:28'),
('ef146d15f68b1b2cfb3d692d787311bff0d1322c20d46fd6fccb6a579f3b1c4430edcb0e66ef5501', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-05 10:37:56', '2023-10-05 10:37:56', '2024-04-05 10:37:56'),
('ef724efc209d1cc4afe7a239b5e3e824fd1b1532efdea847d1fa3d830112fe1c979806c8c4c1c138', 3, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 1, '2023-10-03 12:20:30', '2023-10-03 12:23:16', '2024-04-03 12:20:30'),
('f0bbc9a9c032327eb2036bff33d7f653bc6e631fad638ebc44c8129419fbca18e498ed139b3002b6', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-12 09:47:39', '2023-10-12 09:47:39', '2024-04-12 09:47:39'),
('f37db1d776538ccd17a136471ca2884fbf45ec36c8126831335e4afa3007261489c381cc82891c5a', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-05 06:26:28', '2023-10-05 06:26:28', '2024-04-05 06:26:28'),
('f3b859e7d3d671ab141998f14be76f679cc6908b695eb1b9f5cba4b00e3108b53b426bccd9bc3b87', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2023-10-05 06:37:29', '2023-10-05 06:37:29', '2024-04-05 06:37:29'),
('f4eb714f341a96597f9d662af63f34c0e408af67590304e79bf56927201c57d6a05cbd88a1a8f567', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-01 06:21:04', '2024-02-01 06:21:04', '2024-08-01 11:51:04'),
('f55f119443d7b9fb65124f5848867fe29fccd9d98010c3e6056ee1f458aee7f599a52db32bdbf4d8', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 1, '2024-02-09 07:14:51', '2024-02-09 07:25:14', '2024-08-09 12:44:51'),
('f6549e841c50c0abeb2e089ac726a8dd8c5921c3dd8fed00c240f2227c71d95d6827246f694ab907', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-04-08 01:51:34', '2024-04-08 01:51:34', '2024-10-08 07:21:34'),
('f7a7d2c4d66ef182544e33c06436df2a3bcd9f5eec24e60407a88b3013acd07617912157fd0fc35a', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-03-01 07:16:07', '2024-03-01 07:16:07', '2024-09-01 12:46:07'),
('faa74f0fc7f8740123efeeedb067d871ee2a328887128d7e72cb1f81f494daa680c1c7aad8bbd3c9', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 1, '2023-10-05 15:26:00', '2023-10-05 19:12:07', '2024-04-05 15:26:00'),
('fda3d3d1fdd1c159765eac83122aa5fb130f91bf789969d2e2097842c0859fd1ff175480cf72fbea', 2, '9a47815f-9573-408a-8552-4a26995299cc', 'MyApp', '[\"company\"]', 0, '2024-02-01 06:32:51', '2024-02-01 06:32:51', '2024-08-01 12:02:51');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` char(36) NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` char(36) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
('9a47815f-9573-408a-8552-4a26995299cc', NULL, 'Laravel Personal Access Client', 'wkVW671WVBIMLus8kad24fZ5x7vfHDTuuoq7wXbo', NULL, 'http://localhost', 1, 0, 0, '2023-10-03 07:43:58', '2023-10-03 07:43:58'),
('9a47815f-9f08-47fb-8279-c36fd781aec2', NULL, 'Laravel Password Grant Client', 'AYdymswFZVtDF2woZmpTea5k9Lt42TFsVZfFypFy', 'users', 'http://localhost', 0, 1, 0, '2023-10-03 07:43:58', '2023-10-03 07:43:58');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` char(36) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, '9a47815f-9573-408a-8552-4a26995299cc', '2023-10-03 07:43:58', '2023-10-03 07:43:58');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `opening_stocks`
--

CREATE TABLE `opening_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `assets` varchar(255) DEFAULT NULL,
  `specification` varchar(255) DEFAULT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `site_usage_unit` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `page_managments`
--

CREATE TABLE `page_managments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `page_name` varchar(255) DEFAULT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `page_contented` longtext DEFAULT NULL,
  `page_banner` varchar(255) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `is_approve` tinyint(4) DEFAULT 1 COMMENT '0:Unapproved,1:Approved',
  `is_blocked` tinyint(4) DEFAULT 0 COMMENT '0:Unblocked,1:Blocked',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `page_managments`
--

INSERT INTO `page_managments` (`id`, `uuid`, `slug`, `page_name`, `page_title`, `page_contented`, `page_banner`, `is_active`, `is_approve`, `is_blocked`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '7ecfa665-3682-4659-b0e0-da2e468552f1', 'home', 'Home', NULL, NULL, NULL, 1, 1, 0, '2023-09-21 11:16:51', '2023-09-21 11:16:51', NULL),
(2, 'd2ad521e-1b0c-46b2-9725-bfd785421556', 'about', 'About', 'About', '<section class=\"common\">\r\n    <div class=\"row no-gutters align-items-end\">\r\n      <div class=\"col col-md-6\">\r\n        <img alt=\"\" src=\"http://3.108.121.124/koncite/construction-app-admin/images/one_1692368423.png\" >\r\n      </div>\r\n\r\n      <div class=\"col col-md-6\">\r\n        <div class=\"common_sec_contnt_about\">\r\n          <h5>A Faster, Smarter & Safer Way of Working​​</h5>\r\n          <p>\r\n            sed diam voluptua vero eos Loripsum dolor stit amet coadipscing elitr, rumy tinvidunt\r\n            ut labore Loripsum dolor stit amet, coadipscing elitr rsed diano eirmod tinvidunt ut labore\r\n            et dolore magna aliquyam erat sed diam voluptua vero eos. <br><br> elitr rsed diano eirmod tinvidunt\r\n            ut labore et dolore magna aliquyam erat sed diam voluptua.\r\n          </p>\r\n        </div>\r\n      </div>\r\n    </div>\r\n  </section>\r\n\r\n\r\n  <section class=\"counter about-counter\">\r\n    <div class=\"container\">\r\n      <div class=\"row\">\r\n        <div class=\"col-sm-3 col-md-3\">\r\n          <div class=\"counter-card\">\r\n            <h3>1542</h3>\r\n            <p>Successfully Project</p>\r\n          </div>\r\n        </div>\r\n\r\n        <div class=\"col-sm-3 col-md-3\">\r\n          <div class=\"counter-card\">\r\n            <h3>542+</h3>\r\n            <p>Trusated Client</p>\r\n          </div>\r\n        </div>\r\n\r\n\r\n        <div class=\"col-sm-3 col-md-3\">\r\n          <div class=\"counter-card\">\r\n            <h3>42</h3>\r\n            <p>Industrial</p>\r\n          </div>\r\n        </div>\r\n\r\n        <div class=\"col-sm-3 col-md-3\">\r\n          <div class=\"counter-card\">\r\n            <h3>32</h3>\r\n            <p>Get Award</p>\r\n          </div>\r\n        </div>\r\n      </div>\r\n    </div>\r\n  </section>\r\n\r\n  <!--========meet our team==========-->\r\n  <section class=\"our-team\">\r\n    <div class=\"container\">\r\n      <h5>Meet Our Team</h5>\r\n      <div class=\"owl-carousel owl-theme about-our-team\">\r\n        <div class=\"item\">\r\n          <div class=\"team-card\">\r\n            <h4>ROBBEN</h4>\r\n            <p>Business Analyst</p>\r\n            <div class=\"team-image\">\r\n              <img src=\"assets/images/team-img1.png\" alt=\"\">\r\n            </div>\r\n            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>\r\n            <div class=\"inverted-comma\">\r\n              <img src=\"assets/images/about-quote.svg\" alt=\"\">\r\n            </div>\r\n          </div>\r\n        </div>\r\n        <div class=\"item\">\r\n          <div class=\"team-card\">\r\n            <h4>ALEX MARVIN </h4>\r\n            <p> Lead Software Engineer</p>\r\n            <div class=\"team-image\">\r\n              <img src=\"assets/images/team-img2.png\" alt=\"\">\r\n\r\n            </div>\r\n\r\n            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>\r\n            <div class=\"inverted-comma\">\r\n              <img src=\"assets/images/about-quote.svg\" alt=\"\">\r\n            </div>\r\n          </div>\r\n        </div>\r\n        <div class=\"item\">\r\n          <div class=\"team-card\">\r\n            <h4>RODRIGO PHIL</h4>\r\n            <p>Chief operations Officer</p>\r\n\r\n            <div class=\"team-image\">\r\n              <img src=\"assets/images/team-img3.png\" alt=\"\">\r\n\r\n            </div>\r\n            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>\r\n            <div class=\"inverted-comma\">\r\n              <img src=\"assets/images/about-quote.svg\" alt=\"\">\r\n            </div>\r\n          </div>\r\n        </div>\r\n        <div class=\"item\">\r\n          <div class=\"team-card\">\r\n            <h4>ROBBEN</h4>\r\n            <p>Business Analyst</p>\r\n            <div class=\"team-image\">\r\n              <img src=\"assets/images/team-img1.png\" alt=\"\">\r\n            </div>\r\n            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>\r\n            <div class=\"inverted-comma\">\r\n              <img src=\"assets/images/about-quote.svg\" alt=\"\">\r\n            </div>\r\n          </div>\r\n        </div>\r\n        <div class=\"item\">\r\n          <div class=\"team-card\">\r\n            <h4>ALEX MARVIN </h4>\r\n            <p> Lead Software Engineer</p>\r\n            <div class=\"team-image\">\r\n              <img src=\"assets/images/team-img2.png\" alt=\"\">\r\n\r\n            </div>\r\n\r\n            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>\r\n            <div class=\"inverted-comma\">\r\n              <img src=\"assets/images/about-quote.svg\" alt=\"\">\r\n            </div>\r\n          </div>\r\n        </div>\r\n        <div class=\"item\">\r\n          <div class=\"team-card\">\r\n            <h4>RODRIGO PHIL</h4>\r\n            <p>Chief operations Officer</p>\r\n\r\n            <div class=\"team-image\">\r\n              <img src=\"assets/images/team-img3.png\" alt=\"\">\r\n\r\n            </div>\r\n            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>\r\n            <div class=\"inverted-comma\">\r\n              <img src=\"assets/images/about-quote.svg\" alt=\"\">\r\n            </div>\r\n          </div>\r\n        </div>\r\n      </div>\r\n    </div>\r\n  </section>\r\n\r\n\r\n  <!-- power-play -->\r\n\r\n  <section class=\"power-play\">\r\n    <div class=\"container\">\r\n      <div class=\"power-banner\">\r\n        <div class=\"row\">\r\n          <div class=\"col-sm-6 col-md-6\">\r\n            <div class=\"power-play-content\">\r\n              <h5>Get the Powerplay mobile app</h5>\r\n              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>\r\n              <a href=\"\">Download the App Now</a>\r\n            </div>\r\n          </div>\r\n          <div class=\"col-sm-6 col-md-6\">\r\n            <div class=\"mobile-image\">\r\n              <div class=\"mobile1\">\r\n                <img alt=\"\" src=\"http://3.108.121.124/koncite/construction-app-admin/images/mobile_1692368571.png\" />                \r\n              </div>\r\n              <div class=\"mobile-2\">\r\n                <img alt=\"\" src=\"http://3.108.121.124/koncite/construction-app-admin/images/mobile-2_1692368673.png\"/>\r\n              </div>\r\n            </div>\r\n          </div>\r\n        </div>\r\n      </div>\r\n    </div>\r\n  </section>', NULL, 1, 1, 0, '2023-09-21 11:16:51', '2023-11-28 08:37:15', NULL),
(3, '5569219c-807a-4fc3-8a16-42fc134e9de6', 'product', 'Product', 'Product', '<section class=\"product_sec\">\r\n    <div class=\"container\">\r\n          <div class=\"row pt_pros\">\r\n                <div class=\"col-md-6\">\r\n                      <div class=\"products_img\">\r\n                            <img alt=\"\" src=\"http://3.108.121.124/koncite/construction-app-admin/images/pr-1_1692368792.png\" class=\"img-fluid\" />\r\n                      </div>\r\n                </div>\r\n\r\n                <div class=\"col-md-6\">\r\n                      <div class=\"products_con\">\r\n                            <h6>Construction</h6>\r\n                            <h2>For Construction</h2>\r\n                            <div class=\"productc_features\">\r\n                                  <ul>\r\n                                        <li><span><img src=\"assets/images/checked.png\" class=\"img-fluid\"\r\n                                                          alt=\"\"></span>Lorem ipsum dolor sit</li>\r\n                                        <li><span><img src=\"assets/images/checked.png\" class=\"img-fluid\"\r\n                                                          alt=\"\"></span>Lorem ipsum dolor sit</li>\r\n                                        <li><span><img src=\"assets/images/checked.png\" class=\"img-fluid\"\r\n                                                          alt=\"\"></span>Lorem ipsum dolor sit</li>\r\n                                        <li><span><img src=\"assets/images/checked.png\" class=\"img-fluid\"\r\n                                                          alt=\"\"></span>Lorem ipsum dolor sit</li>\r\n                                        <li><span><img src=\"assets/images/checked.png\" class=\"img-fluid\"\r\n                                                          alt=\"\"></span>Lorem ipsum dolor sit</li>\r\n                                        <li><span><img src=\"assets/images/checked.png\" class=\"img-fluid\"\r\n                                                          alt=\"\"></span>Lorem ipsum dolor sit</li>\r\n                                  </ul>\r\n                            </div>\r\n                      </div>\r\n                </div>\r\n\r\n          </div>\r\n\r\n          <div class=\"row pt_pros row_reverse\">\r\n                <div class=\"col-md-6\">\r\n                      <div class=\"products_con\">\r\n                            <h6>Vendor</h6>\r\n                            <h2>For Vendor</h2>\r\n                            <div class=\"productc_features\">\r\n                                  <ul>\r\n                                        <li><span><img src=\"assets/images/checked.png\" class=\"img-fluid\"\r\n                                                          alt=\"\"></span>Lorem ipsum dolor sit</li>\r\n                                        <li><span><img src=\"assets/images/checked.png\" class=\"img-fluid\"\r\n                                                          alt=\"\"></span>Lorem ipsum dolor sit</li>\r\n                                        <li><span><img src=\"assets/images/checked.png\" class=\"img-fluid\"\r\n                                                          alt=\"\"></span>Lorem ipsum dolor sit</li>\r\n                                        <li><span><img src=\"assets/images/checked.png\" class=\"img-fluid\"\r\n                                                          alt=\"\"></span>Lorem ipsum dolor sit</li>\r\n                                        <li><span><img src=\"assets/images/checked.png\" class=\"img-fluid\"\r\n                                                          alt=\"\"></span>Lorem ipsum dolor sit</li>\r\n                                        <li><span><img src=\"assets/images/checked.png\" class=\"img-fluid\"\r\n                                                          alt=\"\"></span>Lorem ipsum dolor sit</li>\r\n                                  </ul>\r\n                            </div>\r\n                      </div>\r\n                </div>\r\n\r\n                <div class=\"col-md-6\">\r\n                      <div class=\"products_img\">\r\n                            <img alt=\"\" src=\"http://3.108.121.124/koncite/construction-app-admin/images/pr-2_1692368829.png\"  class=\"img-fluid\"/>\r\n                      </div>\r\n                </div>\r\n\r\n          </div>\r\n    </div>\r\n</section>', NULL, 1, 1, 0, '2023-09-21 11:16:51', '2023-09-22 12:00:02', NULL),
(7, '9a6139a7-77f1-41f7-865d-e208bd1ca6db', 'contact-us', 'Contact Us', 'Contact', '<!-- contact Us -->\r\n      <section class=\"contact-us\">\r\n            <div class=\"container\">\r\n                  <div class=\"row\">\r\n                        <div class=\"col-md-6 col-12\">\r\n                              <div class=\"contact-us-left\">\r\n                                    <h5>Contact Us</h5>\r\n                                    <h2>Get in Touch</h2>\r\n                                    <ul>\r\n                                          <li><a href=\"tel:+1-234-567 8490  \"><span class=\"icon\"><i class=\"fa fa-phone\"\r\n                                                                  aria-hidden=\"true\"></i></span>Call us <br>\r\n                                                      <span class=\"details\">+1-234-567 8490</span> </a></li>\r\n                                          <li><a href=\"mailto: info@habitat4veterans.us\"><span class=\"icon\"><i\r\n                                                                  class=\"fa fa-envelope\"\r\n                                                                  aria-hidden=\"true\"></i></span>Mail Us <br>\r\n                                                      <span class=\"details\"> info@habitat4veterans.us</span></a></li>\r\n                                          <li><a><span class=\"icon\"><i class=\"fa fa-map-marker\"\r\n                                                                  aria-hidden=\"true\"></i></span>Visit Us\r\n                                                      <br><span class=\"details\"> Florida, USA 62639</span> </a></li>\r\n\r\n                                    </ul>\r\n                              </div>\r\n                        </div>\r\n\r\n                        <div class=\"col-md-6 col-12\">\r\n                              <div class=\"contact-us-right\">\r\n                                    <h3>Fill the Form Below</h3>\r\n                                    <form action=\"\" class=\"\">\r\n\r\n                                          <div class=\"row\">\r\n                                                <div class=\"col-md-6 col-sm-6 col-12\">\r\n                                                      <label for=\"name\">Name</label>\r\n                                                      <div class=\"form-group\">\r\n                                                            <input type=\"text\" class=\"form-control\"\r\n                                                                  placeholder=\"Your Name\">\r\n                                                      </div>\r\n                                                </div>\r\n                                                <div class=\"col-md-6 col-sm-6 col-12\">\r\n                                                      <label for=\"name\">Email</label>\r\n                                                      <div class=\"form-group\">\r\n                                                            <input type=\"email\" class=\"form-control\"\r\n                                                                  placeholder=\"Your Email\">\r\n\r\n\r\n                                                      </div>\r\n                                                </div>\r\n\r\n                                                <div class=\"col-md-6 col-sm-6 col-12\">\r\n                                                      <label for=\"name\">Phone</label>\r\n                                                      <div class=\"form-group\">\r\n                                                            <input type=\"number\" class=\"form-control\"\r\n                                                                  placeholder=\"Your Phone\">\r\n                                                      </div>\r\n                                                </div>\r\n\r\n                                                <div class=\"col-md-6 col-sm-6 col-12\">\r\n                                                      <label for=\"name\">Subject</label>\r\n                                                      <div class=\"form-group\">\r\n                                                            <input type=\"text\" class=\" form-control\"\r\n                                                                  placeholder=\"Enter Subject\"></span>\r\n\r\n\r\n                                                      </div>\r\n                                                </div>\r\n\r\n\r\n                                                <div class=\"col-md-12 col-sm-12 col-12\">\r\n                                                      <label for=\"name\">Message</label>\r\n                                                      <div class=\"form-group\">\r\n                                                            <textarea cols=\"40\" rows=\"5\" class=\" form-control\"\r\n                                                                  placeholder=\"Enter Your Message\"></textarea>\r\n\r\n                                                      </div>\r\n                                                </div>\r\n                                                <div class=\"col-md-12 col-sm-12 col-12\">\r\n                                                      <a href=\"#\">\r\n                                                            <button type=\"button\" class=\"btn btn-primary\">Submit\r\n                                                                  Now</button>\r\n                                                      </a>\r\n\r\n                                                </div>\r\n                                          </div>\r\n                                    </form>\r\n                              </div>\r\n                        </div>\r\n                  </div>\r\n            </div>\r\n      </section>\r\n\r\n      <!-- map -->\r\n      <section class=\"map\">\r\n            <iframe\r\n                  src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3684.14126976648!2d88.42939135063494!3d22.573819085109513!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a0275afcc956fd3%3A0x710c287cd8886aed!2sEn-32%20Shyam%20Tower%2C%2031%2C%20EN%20Block%2C%20Sector%20V%2C%20Bidhannagar%2C%20Kolkata%2C%20West%20Bengal%20700091!5e0!3m2!1sen!2sin!4v1656067604791!5m2!1sen!2sin\"\r\n                  width=\"100%\" height=\"600\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"\r\n                  referrerpolicy=\"no-referrer-when-downgrade\"></iframe>\r\n      </section>', NULL, 1, 1, 0, '2023-09-21 11:16:51', '2023-09-22 12:01:36', NULL),
(8, '6cd765e6-a5d4-490b-a0f6-3358e91ffaeb', 'test', 'test', 'Product', '<p>testtt pagesss</p>', NULL, 0, 1, 0, '2023-11-28 09:31:48', '2023-11-28 09:32:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profile_designations`
--

CREATE TABLE `profile_designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `project_name` varchar(255) DEFAULT NULL,
  `planned_start_date` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `planned_end_date` date DEFAULT NULL,
  `project_completed` varchar(255) DEFAULT NULL,
  `project_completed_date` date DEFAULT NULL,
  `own_project_or_contractor` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `client_company_name` varchar(255) DEFAULT NULL,
  `client_company_address` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `companies_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `uuid`, `project_name`, `planned_start_date`, `address`, `planned_end_date`, `project_completed`, `project_completed_date`, `own_project_or_contractor`, `logo`, `client_company_name`, `client_company_address`, `company_id`, `companies_id`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '5beda8df-d60e-4543-962b-b86ba539a83e', 'SFT Project', '2023-09-29', 'Newtown,kolkata', '2023-10-20', 'yes', '2024-01-27', 'no', '169631975081.jpg', NULL, NULL, 2, 1, 1, '2023-10-03 07:55:50', '2024-01-18 04:53:27', NULL),
(2, '5a2080e1-9b52-4b99-91bd-328b3e037793', 'SFT Project', '2023-10-05', 'soumaprg@abc.com', '2023-10-19', 'no', NULL, 'yes', '169633026636.png', NULL, NULL, 1, 2, 1, '2023-10-03 10:51:06', '2023-10-03 10:51:06', NULL),
(4, 'fe47be32-3b64-4c32-9f2d-5059a0c1aeca', 'sftt', '2023-09-06', 'kolkata', '2023-09-10', 'no', NULL, 'no', '', NULL, NULL, 2, 1, 1, '2023-10-05 11:27:55', '2023-10-05 11:27:55', NULL),
(5, 'bf206b74-3751-488c-b556-57f4c872967c', 'New Project', '2023-10-03', 'Kolkata', '2023-10-05', 'no', NULL, 'no', '169650874124.jpg', NULL, NULL, 2, 1, 1, '2023-10-05 12:25:41', '2023-10-05 12:25:41', NULL),
(19, 'a6929d1d-c2ee-4fec-b10e-854315c565f6', 'new demo', '2024-01-01', 'kolkata', '2024-01-27', 'no', NULL, 'no', '', NULL, NULL, 2, 1, 1, '2024-01-23 01:08:45', '2024-01-23 01:08:45', NULL),
(20, 'ebd7e3f7-1f36-4485-b76c-e38d4810f7bd', 'demo', '2024-01-01', 'kolkata', '2024-01-27', 'no', NULL, 'no', '', NULL, NULL, 2, 1, 1, '2024-01-23 01:09:31', '2024-01-23 01:09:31', NULL),
(21, '20e301cc-a27a-4ea2-9120-335a6c403560', 'new one', '2024-01-01', 'kolkaata', '2024-01-27', 'no', NULL, 'no', '', NULL, NULL, 2, 1, 1, '2024-01-23 01:36:07', '2024-01-23 01:36:07', NULL),
(22, '1bd7b6e5-75c7-4c73-8a15-4662f1b5a88a', 'Twin', '2023-02-09', 'Pune', '2026-02-09', 'no', NULL, 'no', '', NULL, NULL, 1, 2, 1, '2024-02-09 01:40:40', '2024-02-09 01:40:40', NULL),
(23, 'edba04a0-5a77-46c4-9b69-38ad7f6935c8', 'March 4-5', '2024-03-04', 'pune', '2024-03-31', 'no', NULL, 'yes', '', NULL, NULL, 2, 1, 1, '2024-03-04 09:46:19', '2024-03-04 09:46:19', NULL),
(24, '8fd37e30-4d4b-47a5-98b1-f99411ad09ab', 'Gulmohar', '2024-03-01', 'Pune', '2025-03-01', 'no', NULL, 'no', '', NULL, NULL, 1, 2, 1, '2024-03-12 02:07:41', '2024-03-12 02:07:41', NULL),
(25, '58e909b4-5326-4791-8681-7cfa539c5f62', 'Rajgarh', '2024-03-12', 'Pune', '2025-06-18', 'no', NULL, 'no', '171022947261.jpg', NULL, NULL, 1, 2, 1, '2024-03-12 02:14:32', '2024-03-12 02:14:32', NULL),
(26, 'eaff3147-fa37-4222-92b5-9fb04918e3a9', 'Amora', '2024-03-12', 'Pune', '2026-03-12', 'no', NULL, 'no', '', NULL, NULL, 1, 2, 1, '2024-03-12 03:48:57', '2024-03-12 03:48:57', NULL),
(27, 'c8888ed6-dd2b-4777-a262-8a5f46204ff6', 'test12March', '2024-03-12', 'pune', '2024-06-28', 'no', NULL, 'no', '', NULL, NULL, 2, 1, 1, '2024-03-12 11:28:07', '2024-03-12 11:28:07', NULL),
(28, '7a241cdf-6788-4019-9b24-5be64c580759', 'test 12march single', '2024-03-12', 'pune', '2024-05-31', 'no', NULL, 'no', '', NULL, NULL, 2, 1, 1, '2024-03-12 11:29:39', '2024-03-12 11:29:39', NULL),
(29, 'dc8e1dc6-068b-4951-bcdf-461f18e473d1', 'project 4th april', '2024-04-04', 'pune', '2024-04-04', 'no', NULL, 'no', '', NULL, NULL, 2, 1, 1, '2024-04-04 08:05:49', '2024-04-04 08:05:49', NULL),
(30, 'b0051911-3054-472b-87f7-0a3aaa508a85', '22test', '2024-04-23', 'kolkata', '2024-04-25', 'no', NULL, 'no', '', NULL, NULL, 2, 1, 1, '2024-04-22 05:22:23', '2024-04-22 05:22:23', NULL),
(31, '89496250-2db6-4209-a66d-6457c5059a09', 'hvkvhc', '2024-04-22', 'cjvkb', '2024-04-27', 'no', NULL, 'no', '', NULL, NULL, 2, 1, 1, '2024-04-22 05:25:28', '2024-04-22 05:25:28', NULL),
(32, '32ec6fb2-443e-4b79-a9cf-2a5bfe644903', 'ok pro', '2024-04-25', 'chccg', '2024-04-27', 'no', NULL, 'no', '171378339945.jpg', NULL, NULL, 2, 1, 1, '2024-04-22 05:26:39', '2024-04-22 05:26:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `project_companies`
--

CREATE TABLE `project_companies` (
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_subproject`
--

CREATE TABLE `project_subproject` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `subproject_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_subproject`
--

INSERT INTO `project_subproject` (`id`, `project_id`, `subproject_id`) VALUES
(2, 2, 2),
(4, 1, 4),
(5, 1, 5),
(7, 1, 7),
(8, 1, 8),
(9, 22, 11),
(15, 1, 3),
(16, 1, 12),
(17, 1, 1),
(18, 1, 13),
(19, 23, 14),
(20, 23, 15),
(21, 24, 17),
(22, 25, 18),
(23, 27, 19),
(24, 29, 20);

-- --------------------------------------------------------

--
-- Table structure for table `quotes`
--

CREATE TABLE `quotes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `projects_id` bigint(20) UNSIGNED DEFAULT NULL,
  `store_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quotes`
--

INSERT INTO `quotes` (`id`, `uuid`, `name`, `date`, `details`, `remarks`, `projects_id`, `store_id`, `user_id`, `company_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'ce1e8752-9f13-4482-a74b-68d937d37d74', '2024-03-07', '2024-03-21', NULL, NULL, 1, NULL, 2, 2, 1, '2024-03-21 02:34:06', '2024-03-21 02:34:06'),
(3, 'e8bba6aa-c54f-4eee-b468-deb4a578c8d5', NULL, '2024-03-27', NULL, NULL, NULL, NULL, 2, 2, 1, '2024-03-27 01:37:02', '2024-03-27 01:37:02'),
(4, '5350b188-4b63-4411-8f93-62d6f7083a3d', '2024-03-27', '2024-03-27', NULL, NULL, 1, NULL, 2, 2, 1, '2024-03-27 01:40:12', '2024-03-27 01:40:12'),
(5, '579b3e0f-aff5-4886-ab7b-16a62529a008', '2024-04-08', '2024-04-08', NULL, NULL, 1, NULL, 2, 2, 1, '2024-04-08 05:05:34', '2024-04-08 05:05:34'),
(6, '45ee9401-eca5-44ec-9023-f3c625f3914b', '2024-04-15', '2024-04-15', NULL, NULL, 1, NULL, 2, 2, 1, '2024-04-15 04:50:37', '2024-04-15 04:50:37'),
(7, '00008dda-f953-4bb8-ade5-3ab207648831', '2024-04-16', '2024-04-16', NULL, NULL, 1, NULL, 2, 2, 1, '2024-04-16 05:33:53', '2024-04-16 05:33:53'),
(8, '033bc56c-7b08-48e7-9eb3-5c65d9d9d6a2', '2024-05-01', '2024-05-01', NULL, NULL, 1, NULL, 2, 2, 1, '2024-05-01 06:44:13', '2024-05-01 06:44:13'),
(9, '0cf03cb0-cd26-42fa-a93a-0c15d5cc6d9c', '2024-05-02', '2024-05-02', NULL, NULL, 1, NULL, 2, 2, 1, '2024-05-02 04:32:06', '2024-05-02 04:32:06'),
(10, 'be1e755d-b0d3-431a-8490-1870001f82ea', '2024-05-02', '2024-05-02', NULL, NULL, 32, NULL, 2, 2, 1, '2024-05-02 07:31:06', '2024-05-02 07:31:06'),
(11, '9a26efbe-3df3-48ae-b083-13cb31d9b979', '2024-05-03', '2024-05-03', NULL, NULL, 1, NULL, 2, 2, 1, '2024-05-03 05:44:22', '2024-05-03 05:44:22'),
(12, 'd96bb013-2dd1-41a4-858c-1cb1c35fb991', '2024-05-06', '2024-05-06', NULL, NULL, 1, NULL, 2, 2, 1, '2024-05-06 01:29:30', '2024-05-06 01:29:30');

-- --------------------------------------------------------

--
-- Table structure for table `quotes_details`
--

CREATE TABLE `quotes_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `quotes_id` bigint(20) UNSIGNED DEFAULT NULL,
  `materials_id` bigint(20) UNSIGNED DEFAULT NULL,
  `material_requests_id` bigint(20) UNSIGNED DEFAULT NULL,
  `request_no` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `remarkes` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quotes_details`
--

INSERT INTO `quotes_details` (`id`, `uuid`, `quotes_id`, `materials_id`, `material_requests_id`, `request_no`, `date`, `img`, `remarkes`, `company_id`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '86c3b333-ad3f-4599-aa20-f846001c7fab', 1, NULL, 2, 'hdgfswe54673', '2013-11-10', NULL, NULL, 2, 1, '2024-03-26 07:13:47', '2024-03-26 07:13:47', NULL),
(7, '9fe0f936-0d04-43c1-af98-e1049b29084f', 1, NULL, 3, '201poiuytgfrds', '2024-03-27', NULL, NULL, 2, 1, '2024-03-27 03:53:16', '2024-03-27 03:53:16', NULL),
(8, '03182995-d297-499b-ad57-ad62b010aff5', 4, NULL, NULL, '201poiuytgfrds', '2024-03-27', '170808957553.png 	', NULL, 2, 1, '2024-03-27 03:53:16', '2024-03-27 03:53:16', NULL),
(10, '96bc8931-524f-4c1f-b252-40437da76f5d', 11, NULL, 3, '201poiuytgfrds', '2024-05-03', NULL, NULL, 2, 1, '2024-05-03 08:27:04', '2024-05-03 08:27:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `safeties`
--

CREATE TABLE `safeties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `company_users_id` bigint(20) UNSIGNED DEFAULT NULL,
  `projects_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sub_projects_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `dpr_id` int(10) UNSIGNED DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `safeties`
--

INSERT INTO `safeties` (`id`, `uuid`, `name`, `date`, `details`, `remarks`, `company_users_id`, `projects_id`, `sub_projects_id`, `company_id`, `dpr_id`, `img`, `is_active`, `created_at`, `updated_at`) VALUES
(3, '3030e757-25f2-4df4-a18b-7e4877a749be', 'iiiiiiiiiiiiiiiiiii', '2024-05-01', 'Safety', 'This policy Only Labours', 2, 1, 1, 2, 5, NULL, 1, '2024-02-01 08:21:40', '2024-02-01 08:21:40'),
(4, '338e08aa-7946-451f-a2a6-00f2f482a07f', 'iiiiiiiiiiiiiiiiiii', '2024-05-01', 'Safety', 'This policy Only Labours', NULL, 1, 1, 2, 5, NULL, 1, '2024-02-16 05:33:57', '2024-02-16 05:33:57'),
(5, 'f8804072-0339-4a35-8825-9f23a144dc7b', 'iiiiiiiiiiiiiiiiiii', '2024-05-01', 'Safety', 'This policy Only Labours', NULL, 1, 1, 2, 5, '170808957553.png', 1, '2024-02-16 07:49:35', '2024-02-16 07:49:35'),
(6, '02a9bedd-0b39-435b-928f-5419d7124207', 'iiiiiiiiiiiiiiiiiii', '2024-05-01', 'Safety', 'This policy Only Labours', NULL, 1, 1, 2, 5, NULL, 1, '2024-02-21 02:00:22', '2024-02-21 02:00:22'),
(7, 'd9b7afd2-7699-4f9a-8d0f-6c019f31e16e', NULL, '2024-02-21', 'abc', 'asdfghj', 29, 1, 4, 2, 58, NULL, 1, '2024-02-21 02:33:02', '2024-02-21 02:33:02'),
(8, '16e2d8b2-1db7-4df6-9db9-156882ce0ec7', 'new', '2024-02-21', 'problem', 'new problem', 29, 1, 4, 2, 58, '170850349229.jpg', 1, '2024-02-21 02:48:12', '2024-02-21 02:48:12'),
(10, 'd77efaa5-297e-43ce-84a0-9992e2819824', '22 prob', '2024-02-22', NULL, '22 re', 29, 1, 1, 2, 63, '170861272040.jpg', 1, '2024-02-22 09:08:40', '2024-02-22 09:08:40'),
(11, '7cc7791a-f1c7-42bd-8c58-494f66ec39ee', 'no helmet', '2024-03-04', NULL, 'chec', 30, 23, 15, 2, 110, '170956634822.jpg', 1, '2024-03-04 10:02:28', '2024-03-04 10:02:28'),
(12, 'bd861cf6-2cab-4881-b0d9-d68c91e2ff7a', 'no helmet', '2024-03-04', NULL, 'chec', 30, 23, 15, 2, 110, '170956634942.jpg', 1, '2024-03-04 10:02:29', '2024-03-04 10:02:29'),
(13, 'ccde5dbd-859d-49aa-8bf0-6d3d2f8cb80d', 'helmet', '2024-04-04', NULL, 'tesy', 31, 29, 20, 2, 131, NULL, 1, '2024-04-04 09:30:04', '2024-04-04 09:30:04');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `country_code` char(2) NOT NULL,
  `fips_code` varchar(255) DEFAULT NULL,
  `iso2` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(10,8) DEFAULT NULL,
  `flag` tinyint(4) NOT NULL DEFAULT 1,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `wikiDataId` varchar(255) DEFAULT NULL COMMENT 'Rapid API GeoDB Cities',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `slug`, `country_id`, `country_code`, `fips_code`, `iso2`, `latitude`, `longitude`, `flag`, `status`, `wikiDataId`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4006, 'Meghalaya', 'meghalaya', 101, 'IN', '18', 'ML', NULL, NULL, 1, 1, 'Q1195', '2019-10-05 06:48:57', '2020-07-29 23:41:30', NULL),
(4007, 'Haryana', 'haryana', 101, 'IN', '10', 'HR', NULL, NULL, 1, 1, 'Q1174', '2019-10-05 06:48:57', '2020-07-29 23:41:30', NULL),
(4008, 'Maharashtra', 'maharashtra', 101, 'IN', '16', 'MH', NULL, NULL, 1, 1, 'Q1191', '2019-10-05 06:48:57', '2020-07-29 23:41:30', NULL),
(4009, 'Goa', 'goa', 101, 'IN', '33', 'GA', NULL, NULL, 1, 1, 'Q1171', '2019-10-05 06:48:57', '2020-07-29 23:41:30', NULL),
(4010, 'Manipur', 'manipur', 101, 'IN', '17', 'MN', NULL, NULL, 1, 1, 'Q1193', '2019-10-05 06:48:57', '2020-07-29 23:41:30', NULL),
(4011, 'Puducherry', 'puducherry', 101, 'IN', '22', 'PY', NULL, NULL, 1, 1, 'Q66743', '2019-10-05 06:48:57', '2020-07-29 23:41:30', NULL),
(4012, 'Telangana', 'telangana', 101, 'IN', '40', 'TG', NULL, NULL, 1, 1, 'Q677037', '2019-10-05 06:48:57', '2020-07-29 23:41:30', NULL),
(4013, 'Odisha', 'odisha', 101, 'IN', '21', 'OR', NULL, NULL, 1, 1, 'Q22048', '2019-10-05 06:48:57', '2020-07-29 23:41:30', NULL),
(4014, 'Rajasthan', 'rajasthan', 101, 'IN', '24', 'RJ', NULL, NULL, 1, 1, 'Q1437', '2019-10-05 06:48:57', '2020-07-29 23:41:30', NULL),
(4015, 'Punjab', 'punjab', 101, 'IN', '23', 'PB', NULL, NULL, 1, 1, 'Q22424', '2019-10-05 06:48:57', '2020-07-29 23:41:30', NULL),
(4016, 'Uttarakhand', 'uttarakhand', 101, 'IN', '39', 'UT', NULL, NULL, 1, 1, 'Q1499', '2019-10-05 06:48:57', '2020-07-29 23:41:30', NULL),
(4017, 'Andhra Pradesh', 'andhra-pradesh', 101, 'IN', '02', 'AP', NULL, NULL, 1, 1, 'Q1159', '2019-10-05 06:48:57', '2020-07-29 23:41:30', NULL),
(4018, 'Nagaland', 'nagaland', 101, 'IN', '20', 'NL', NULL, NULL, 1, 1, 'Q1599', '2019-10-05 06:48:57', '2020-07-29 23:41:30', NULL),
(4019, 'Lakshadweep', 'lakshadweep', 101, 'IN', '14', 'LD', NULL, NULL, 1, 1, 'Q26927', '2019-10-05 06:48:57', '2020-07-29 23:41:30', NULL),
(4020, 'Himachal Pradesh', 'himachal-pradesh', 101, 'IN', '11', 'HP', NULL, NULL, 1, 1, 'Q1177', '2019-10-05 06:48:57', '2020-07-29 23:41:30', NULL),
(4021, 'Delhi', 'delhi', 101, 'IN', '07', 'DL', NULL, NULL, 1, 1, 'Q1353', '2019-10-05 06:48:57', '2020-07-29 23:41:30', NULL),
(4022, 'Uttar Pradesh', 'uttar-pradesh', 101, 'IN', '36', 'UP', NULL, NULL, 1, 1, 'Q1498', '2019-10-05 06:48:57', '2020-07-29 23:41:30', NULL),
(4023, 'Andaman and Nicobar Islands', 'andaman-and-nicobar-islands', 101, 'IN', '01', 'AN', NULL, NULL, 1, 1, 'Q40888', '2019-10-05 06:48:57', '2020-07-29 23:41:30', NULL),
(4024, 'Arunachal Pradesh', 'arunachal-pradesh', 101, 'IN', '30', 'AR', NULL, NULL, 1, 1, 'Q1162', '2019-10-05 06:48:57', '2020-07-29 23:41:30', NULL),
(4025, 'Jharkhand', 'jharkhand', 101, 'IN', '38', 'JH', NULL, NULL, 1, 1, 'Q1184', '2019-10-05 06:48:57', '2020-07-29 23:41:30', NULL),
(4026, 'Karnataka', 'karnataka', 101, 'IN', '19', 'KA', NULL, NULL, 1, 1, 'Q1185', '2019-10-05 06:48:57', '2020-07-29 23:41:30', NULL),
(4027, 'Assam', 'assam', 101, 'IN', '03', 'AS', NULL, NULL, 1, 1, 'Q1164', '2019-10-05 06:48:57', '2020-07-29 23:41:30', NULL),
(4028, 'Kerala', 'kerala', 101, 'IN', '13', 'KL', NULL, NULL, 1, 1, 'Q1186', '2019-10-05 06:48:57', '2020-07-29 23:41:30', NULL),
(4029, 'Jammu and Kashmir', 'jammu-and-kashmir', 101, 'IN', '12', 'JK', NULL, NULL, 1, 1, 'Q1180', '2019-10-05 06:48:57', '2020-07-29 23:41:30', NULL),
(4030, 'Gujarat', 'gujarat', 101, 'IN', '09', 'GJ', NULL, NULL, 1, 1, 'Q1061', '2019-10-05 06:48:57', '2020-07-29 23:41:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock_managments`
--

CREATE TABLE `stock_managments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `Specification` varchar(255) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_reports`
--

CREATE TABLE `stock_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `Specification` varchar(255) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `report` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `unit_id` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_warehouses`
--

CREATE TABLE `store_warehouses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `projects_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_warehouses`
--

INSERT INTO `store_warehouses` (`id`, `uuid`, `name`, `location`, `company_id`, `projects_id`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ed546e65-7893-44b4-ba27-6aa418dd795c', 'SFT store', 'kolata', 2, 1, 1, '2023-10-03 07:56:42', '2023-10-03 07:56:42', NULL),
(2, 'e8ee6f33-dd8c-4164-8392-991d0ff5b0b8', 'SFT store', 'kolata', 1, 2, 1, '2023-10-03 10:51:50', '2023-10-03 10:51:50', NULL),
(3, '03105ad0-4e02-4fb2-87a6-9d40f8da8011', 'sssssssswssssss', 'kolkata', 2, 1, 1, '2023-10-04 14:50:24', '2023-10-04 14:50:24', NULL),
(4, 'ce91758e-3527-4328-897a-1c7aa7a7b3b7', 'Main', 'Pune', 1, 22, 1, '2024-02-09 02:07:05', '2024-02-09 02:07:05', NULL),
(5, '7207b81c-b8ff-426e-af9d-168fd10c792e', 'Main store', 'Pune', 1, 25, 1, '2024-03-12 03:34:59', '2024-03-12 03:34:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subscription_packages`
--

CREATE TABLE `subscription_packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `title` varchar(255) NOT NULL,
  `free_subscription` tinyint(4) DEFAULT 0 COMMENT '0:Inactive,1:Active',
  `payment_mode` enum('month','year') DEFAULT NULL,
  `amount_inr` double(8,2) DEFAULT NULL,
  `amount_usd` double(8,2) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `trial_period` int(11) DEFAULT NULL,
  `interval` enum('day','week','month','year') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscription_packages`
--

INSERT INTO `subscription_packages` (`id`, `uuid`, `title`, `free_subscription`, `payment_mode`, `amount_inr`, `amount_usd`, `duration`, `trial_period`, `interval`, `created_at`, `updated_at`) VALUES
(1, '96c5a729-89ed-44f4-a1d8-9183c4d32af3', 'Free', 1, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-13 12:53:18', '2023-10-13 12:53:18'),
(2, '8cf452e3-27a5-46f9-b9b0-575d54b1db08', 'Paid', 0, 'month', 1000.00, 500.00, 1, 30, NULL, '2023-10-13 13:00:57', '2023-10-13 13:00:57');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_package_options`
--

CREATE TABLE `subscription_package_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `subscription_packages_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_subscription` varchar(255) DEFAULT NULL,
  `paid_subscription` varchar(255) DEFAULT NULL,
  `subscription_key` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscription_package_options`
--

INSERT INTO `subscription_package_options` (`id`, `uuid`, `subscription_packages_id`, `is_subscription`, `paid_subscription`, `subscription_key`, `created_at`, `updated_at`) VALUES
(1, '2ca4d074-5b8b-4952-a54d-0c54a1370aa5', NULL, 'yes', NULL, 'mobile_app', '2023-10-13 13:00:39', '2023-10-13 13:00:39'),
(2, 'a52aba4c-3928-4ef8-8941-c990f6b24cf3', NULL, 'no', NULL, 'web_app', '2023-10-13 13:00:39', '2023-10-13 13:00:39'),
(3, 'd284155a-d230-4334-8972-1cd5b0233435', NULL, 'no', NULL, 'po', '2023-10-13 13:00:39', '2023-10-13 13:00:39'),
(4, '00c941c0-1c56-4612-a393-d6a6e3f5bbb5', NULL, 'no', NULL, 'approvals', '2023-10-13 13:00:39', '2023-10-13 13:00:39'),
(5, '36fd5af9-71a6-4850-95a9-ee4cd23cb6b2', NULL, 'no', NULL, 'inward_multiple_option', '2023-10-13 13:00:39', '2023-10-13 13:00:39'),
(6, '840333ab-34cc-458b-9b20-6dc236f33762', NULL, 'no', NULL, 'subproject_creation', '2023-10-13 13:00:39', '2023-10-13 13:00:39'),
(7, 'bfadc105-3353-4d97-9119-a4a0a358216b', NULL, 'no', NULL, 'multistores_project', '2023-10-13 13:00:39', '2023-10-13 13:00:39'),
(8, 'e13f5b9b-35f7-428d-a7ad-348543d01025', NULL, '4', NULL, 'inventory', '2023-10-13 13:00:39', '2023-10-13 13:00:39'),
(9, '6a6008aa-a4ff-463e-b289-a0e65456b745', NULL, '5', NULL, 'activities', '2023-10-13 13:00:39', '2023-10-13 13:00:39'),
(10, '26644e34-8529-444e-ac31-96818529fd83', NULL, '5', NULL, 'material', '2023-10-13 13:00:39', '2023-10-13 13:00:39'),
(11, '892805e4-659e-4d6f-9ee3-ed9ddc45dbea', NULL, '1', NULL, 'no_of_users', '2023-10-13 13:00:39', '2023-10-13 13:00:39'),
(12, '95fa35f8-8498-4679-a96f-09542a2ee0e7', 2, 'yes', NULL, 'mobile_app', '2023-10-13 13:01:20', '2024-01-24 01:47:08'),
(13, '04106d06-bee4-42d6-be6c-0df16f419f51', 2, 'yes', NULL, 'web_app', '2023-10-13 13:01:20', '2024-01-24 01:47:08'),
(14, 'cc2ea54f-f94b-45a6-93da-0321217191f1', 2, 'yes', NULL, 'po', '2023-10-13 13:01:20', '2024-01-24 01:47:08'),
(15, 'b73862b6-6823-4844-8d08-8b0ce8adfa51', 2, 'yes', NULL, 'approvals', '2023-10-13 13:01:20', '2024-01-24 01:47:08'),
(16, '1b5cf615-5867-4923-ae66-3bcdc809c4d1', 2, 'yes', NULL, 'inward_multiple_option', '2023-10-13 13:01:20', '2024-01-24 01:47:08'),
(17, 'ca82a4b7-267e-4dc9-9fda-1dd2050dbb8e', 2, 'yes', NULL, 'subproject_creation', '2023-10-13 13:01:20', '2024-01-24 01:47:08'),
(18, '282b636b-1978-4e32-bc62-6b654ddeb926', 2, 'yes', NULL, 'multistores_project', '2023-10-13 13:01:20', '2024-01-24 01:47:08'),
(19, '5ad73a2d-50da-4789-b1a0-5b6cf9dfa9fc', 2, '40', NULL, 'inventory', '2023-10-13 13:01:20', '2024-01-24 01:47:08'),
(20, '0cd35218-3b5e-497a-bcba-e03530118e4a', 2, '50', NULL, 'activities', '2023-10-13 13:01:20', '2024-01-24 01:47:08'),
(21, 'e98b88d3-3d04-46cb-89ec-15af4c109f53', 2, '10', NULL, 'material', '2023-10-13 13:01:20', '2024-01-24 01:47:08'),
(22, '1a261af1-38f2-4479-8003-cbb58c1a3399', 2, '10', NULL, 'no_of_users', '2023-10-13 13:01:20', '2024-01-24 01:47:08'),
(23, 'a10989cc-73b8-4468-8d4c-7fe5e503aaa0', 1, 'yes', NULL, 'mobile_app', '2023-11-21 02:11:40', '2024-01-17 01:21:45'),
(24, 'a9773204-b68e-4dd8-a142-bfcc63dccbfc', 1, 'no', NULL, 'web_app', '2023-11-21 02:11:40', '2024-01-17 01:21:45'),
(25, '4e7ba17d-4569-465d-b544-e7285c1865e3', 1, 'no', NULL, 'po', '2023-11-21 02:11:40', '2024-01-17 01:21:45'),
(26, 'b78c487d-f13c-4420-a4e6-f44ca034289d', 1, 'no', NULL, 'approvals', '2023-11-21 02:11:40', '2024-01-17 01:21:45'),
(27, 'a9622e28-74ad-4451-a343-b31281d736d0', 1, 'no', NULL, 'inward_multiple_option', '2023-11-21 02:11:40', '2024-01-17 01:21:45'),
(28, '46ca4ce9-ecf7-4485-b897-632e197157c9', 1, 'no', NULL, 'subproject_creation', '2023-11-21 02:11:40', '2024-01-17 01:21:45'),
(29, '98781745-6dd5-435f-a1e4-06e8799258c6', 1, 'no', NULL, 'multistores_project', '2023-11-21 02:11:40', '2024-01-17 01:21:45'),
(30, '43bd0d21-c3d8-495d-b56a-e2d7a44bb0e5', 1, '0', NULL, 'inventory', '2023-11-21 02:11:40', '2024-01-17 01:21:45'),
(31, '6dc7eaa5-2001-40d5-9bdf-56dba37b5931', 1, '0', NULL, 'activities', '2023-11-21 02:11:40', '2024-01-17 01:21:45'),
(32, 'c1518720-2fdf-4ed5-9d18-79e026fd0f83', 1, '0', NULL, 'material', '2023-11-21 02:11:40', '2024-01-17 01:21:45'),
(33, 'cacbc461-6c63-46ca-bd52-c18db2402805', 1, '1', NULL, 'no_of_users', '2023-11-21 02:11:40', '2024-01-17 01:21:45');

-- --------------------------------------------------------

--
-- Table structure for table `sub_projects`
--

CREATE TABLE `sub_projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_projects`
--

INSERT INTO `sub_projects` (`id`, `uuid`, `name`, `start_date`, `end_date`, `company_id`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '58b931c0-c8a0-4ef7-b050-2fdbedd3848f', 'sft subproject_qqwww', '2023-09-06', '2023-09-10', 2, 1, '2023-10-03 07:56:06', '2024-02-22 04:08:47', NULL),
(2, 'c881c9d8-7063-4d1c-bbdf-bb18e82d628b', 'SFT sub project', '2023-10-04', '2023-10-19', 1, 1, '2023-10-03 10:51:24', '2024-02-16 05:13:14', NULL),
(3, 'a2256f7e-c21f-43c7-a5ca-655acb2d462d', 'sft sub one', '2023-10-03', '2023-10-05', 2, 1, '2023-10-04 10:50:26', '2024-02-22 04:07:48', NULL),
(4, '2d3878bb-5283-4e14-9d4e-2fa1c2578a70', 'sft subproject t', '2023-09-29', '2023-10-20', 2, 1, '2023-10-04 11:10:51', '2024-01-17 06:49:35', NULL),
(5, 'e84cbe97-009c-4b09-94ef-2ee28b789d4d', 'Demo', '2023-10-04', '2023-10-05', 2, 1, '2023-10-05 10:09:53', '2024-01-16 05:51:15', '2024-01-16 05:51:15'),
(6, '16f59945-088b-436e-a733-6028ba98bb2f', 'Sample sub', '2024-01-10', '2024-01-31', 2, 1, '2024-01-10 01:48:21', '2024-01-16 03:21:05', '2024-01-16 03:21:05'),
(7, '778aa84a-a172-450d-aa34-70a109d44793', 'Sub test one', '2024-01-02', '2024-01-27', 2, 1, '2024-01-16 02:02:44', '2024-01-16 03:20:36', '2024-01-16 03:20:36'),
(8, 'fda67975-53a6-4a68-95ed-1693ead2b1f4', 'Sft two', '2023-09-29', '2023-10-20', 2, 1, '2024-01-17 06:50:13', '2024-01-17 06:50:30', NULL),
(11, 'a20a742f-ac93-44dd-98e0-8068b0f2b331', 'Birijw', '2024-03-30', '2025-03-02', 1, 1, '2024-02-13 00:44:41', '2024-02-16 05:13:43', NULL),
(12, 'aaef2fdb-2fa5-4729-93a9-950ce9c69ef8', 'sft subproject_qqwww', '2023-09-06', '2023-09-10', 2, 1, '2024-02-16 02:14:33', '2024-02-22 04:08:13', NULL),
(13, '07c25fd0-ed23-46de-af21-c02a613d8631', 'A wing', '2023-10-03', '2023-10-05', 2, 1, '2024-02-16 09:49:01', '2024-02-22 04:11:32', NULL),
(14, 'a797e6de-3c7a-48dd-9a41-f73afb282538', 'A wing', '2024-03-04', '2024-03-11', 2, 1, '2024-03-04 09:47:27', '2024-03-04 09:47:27', NULL),
(15, '421bfd98-3522-40fb-8094-2bec6011e229', 'Bwing', '2024-03-04', '2024-03-30', 2, 1, '2024-03-04 09:47:54', '2024-03-04 09:47:54', NULL),
(17, '9b0786e7-d579-4d8b-a41e-b57c95ac6522', 'A wing', '2023-03-03', '2024-04-04', 1, 1, '2024-03-12 02:22:22', '2024-03-12 02:22:22', NULL),
(18, '83a86d2d-d253-4af9-990f-f7b668eeecdf', 'A wing', '2024-03-03', '2025-04-02', 1, 1, '2024-03-12 02:23:06', '2024-03-12 02:23:06', NULL),
(19, '345d80e7-f1e1-4b54-b436-149112f7c2b6', 'Awing 12th Mar', '2024-03-12', '2024-03-30', 2, 1, '2024-03-12 11:30:52', '2024-03-12 11:30:52', NULL),
(20, '4d226693-946b-4d2b-9b4e-ef8fa49a1623', 'a wing 4th apr', '2024-04-04', '2024-04-30', 2, 1, '2024-04-04 08:06:30', '2024-04-04 08:06:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `aadhar_no` varchar(255) DEFAULT NULL,
  `pan_no` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `profile_role` bigint(20) UNSIGNED NOT NULL,
  `reporting_person` bigint(20) UNSIGNED NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `unit_coversion` varchar(255) DEFAULT NULL,
  `unit_coversion_factor` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `uuid`, `unit`, `unit_coversion`, `unit_coversion_factor`, `company_id`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'e26db30b-6133-4327-9531-9e31965b3321', 'KG', NULL, NULL, 2, 1, '2023-10-03 07:56:14', '2024-01-16 06:59:34', '2024-01-16 06:59:34'),
(2, '63c88f2e-a672-480d-b7b2-e3288e1b3fea', 'KG', NULL, NULL, 2, 1, '2023-10-03 07:56:19', '2023-10-03 07:56:22', '2023-10-03 07:56:22'),
(3, '6d80fe8b-48d8-440e-9189-28502e5de9b9', 'kgs', 'kgs', 'wwwwwwwwww', 2, 1, '2023-10-03 07:56:29', '2024-01-18 04:24:29', NULL),
(4, '7effeb8a-557a-4948-8409-6f0a41a3768f', 'KG', NULL, NULL, 1, 1, '2023-10-03 10:51:33', '2023-10-03 10:51:33', NULL),
(5, '685cd124-07d3-4e2f-abfe-8511a718fc99', 'Nos', NULL, NULL, 1, 1, '2023-10-03 10:51:39', '2023-10-03 10:51:39', NULL),
(6, '5ab155bb-7d3f-44c4-81ac-f8243c39a956', 'Litter', NULL, NULL, 2, 1, '2023-10-05 10:38:57', '2023-10-05 10:38:57', NULL),
(7, '57e6258f-fda8-4dcf-afd4-1b0c9d35195f', 'Cum', NULL, NULL, 1, 1, '2023-12-04 08:00:00', '2023-12-04 08:00:00', NULL),
(8, 'd87784af-21ce-4634-96ef-29dbd3abdb29', 'Tn', NULL, NULL, 1, 1, '2023-12-04 08:00:00', '2023-12-04 08:00:00', NULL),
(9, 'd9787c84-b644-4a2a-b377-6d9019384975', 'Sft', NULL, NULL, 1, 1, '2023-12-04 08:00:00', '2023-12-04 08:00:00', NULL),
(10, 'b53dcb4e-e972-46ea-a3b8-93e1ee7ec3ba', 'assd', NULL, NULL, 1, 1, '2024-01-12 04:32:18', '2024-01-12 04:32:18', NULL),
(11, '13d435bb-9467-4c34-96e6-0ec507708406', 'KG', '3', 'I\'m', 2, 1, '2024-01-12 06:11:52', '2024-01-17 07:53:39', '2024-01-17 07:53:39'),
(12, '625e8342-8405-41b4-969a-4b16f704b150', 'Pound', 'Litter', 'qwerty', 2, 1, '2024-01-12 06:13:58', '2024-01-12 06:13:58', NULL),
(13, 'e64cc274-7d71-4802-b018-5a689616845f', 'asdfg', NULL, NULL, 2, 1, '2024-01-12 06:16:38', '2024-01-16 06:57:47', '2024-01-16 06:57:47'),
(14, 'fbadf63f-7c7a-452c-b077-0742ed2fa17e', 'hhhh', 'Pound', 'rerff', 2, 1, '2024-01-12 09:19:32', '2024-01-16 06:59:49', '2024-01-16 06:59:49'),
(15, '441b96c1-667a-48c9-8498-8494083f6bc0', 'pound', 'nos', 'soli', 2, 1, '2024-01-16 05:53:21', '2024-01-16 08:52:37', '2024-01-16 08:52:37'),
(16, '9e4e03eb-7d7f-4a8d-8b10-9021b46d3b70', 'abc', '3', 'qa', 2, 1, '2024-01-17 07:34:24', '2024-01-17 07:53:33', '2024-01-17 07:53:33'),
(17, '3ad8b1f9-f1f7-4fd6-9778-b218adb8d609', 'abcd', 'Litter', 'qwe', 2, 1, '2024-01-17 07:35:14', '2024-01-17 08:22:00', NULL),
(18, '18ba489e-c75c-4901-a5bf-e60ea29cf9a7', 'acc', NULL, NULL, 2, 1, '2024-01-17 07:38:24', '2024-01-17 07:53:31', '2024-01-17 07:53:31'),
(19, '901903d2-fb1b-4d13-adae-6cb3b86cf2da', 'abb', 'Litter', 'ddd', 2, 1, '2024-01-17 07:39:09', '2024-01-17 07:53:27', '2024-01-17 07:53:27'),
(20, 'd589ecd9-f58f-4b42-8601-09d331d3c8bd', 'jit', 'KG', 'qwertyu', 2, 1, '2024-01-17 07:45:59', '2024-01-17 07:53:24', '2024-01-17 07:53:24'),
(21, 'ee0c22a4-3eec-4a7e-855b-85faaf333a85', 'Sqm', '22', '3', 1, 1, '2024-02-09 01:29:20', '2024-02-09 01:37:27', NULL),
(22, '923617dd-1f9b-4662-868d-6544383d228a', 'Rft', NULL, NULL, 1, 1, '2024-02-09 01:32:29', '2024-02-09 01:32:29', NULL),
(23, '298fa9c5-676a-4ed5-8079-b9a7ef999f4c', 'No', NULL, NULL, 2, 1, '2024-02-11 13:16:56', '2024-02-11 13:16:56', NULL),
(24, '826181f5-03bd-4a19-a0f1-51f7ac9a6e5c', 'RMT', '21', '2', 1, 1, '2024-02-13 00:50:04', '2024-02-13 00:54:12', NULL),
(25, '11d122fa-b974-4980-b990-d50a9b12ea47', 'RFT', NULL, NULL, 1, 1, '2024-02-13 00:50:20', '2024-02-13 00:50:20', NULL),
(26, '0a3ae1b5-3d7b-4a47-807e-24cd2c584e57', 'ton', 'kgs', '1000', 2, 1, '2024-02-16 09:57:31', '2024-02-16 09:57:31', NULL),
(27, '7c13c7e9-31ef-497f-950f-883b0c1e9774', 'm3', NULL, NULL, 2, 1, '2024-03-04 09:48:18', '2024-03-04 09:48:18', NULL),
(28, 'c66f9973-9fc8-4b3a-aac0-5b63abc85515', 'Sqm', NULL, NULL, 2, 1, '2024-03-04 09:48:29', '2024-03-04 09:48:29', NULL),
(29, '494a9397-85e3-46f3-bf52-1506818fd290', 'Bags', NULL, NULL, 2, 1, '2024-03-04 09:48:38', '2024-03-04 09:48:38', NULL),
(30, '5786b5b4-bf90-43d5-8176-3b52f0eba413', 'Hrs', NULL, NULL, 1, 1, '2024-03-12 03:40:18', '2024-03-12 03:40:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `app_id` varchar(100) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL COMMENT 'Users Username',
  `type` varchar(255) NOT NULL DEFAULT '1' COMMENT 'Users Type',
  `email` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `mobile_number` bigint(20) DEFAULT NULL,
  `mobile_number_verified_at` timestamp NULL DEFAULT NULL,
  `verification_code` mediumint(9) DEFAULT NULL COMMENT 'OTP used for verifying the phone number',
  `is_twofactor` tinyint(1) NOT NULL DEFAULT 0,
  `two_factor_code` varchar(100) DEFAULT NULL,
  `two_factor_expires_at` datetime DEFAULT NULL,
  `registration_ip` varchar(100) DEFAULT NULL,
  `last_login_ip` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `last_logout_at` datetime DEFAULT NULL,
  `last_login_at` datetime DEFAULT NULL,
  `notifications` mediumtext DEFAULT NULL,
  `admin_role_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `is_online` tinyint(1) DEFAULT 0 COMMENT '0:Inactive,1:Active',
  `is_approve` tinyint(4) DEFAULT 1 COMMENT '0:Unapproved,1:Approved',
  `is_blocked` tinyint(4) DEFAULT 0 COMMENT '0:Unblocked,1:Blocked',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uuid`, `first_name`, `last_name`, `app_id`, `username`, `type`, `email`, `remember_token`, `email_verified_at`, `password`, `mobile_number`, `mobile_number_verified_at`, `verification_code`, `is_twofactor`, `two_factor_code`, `two_factor_expires_at`, `registration_ip`, `last_login_ip`, `address`, `state`, `city`, `profile_image`, `last_logout_at`, `last_login_at`, `notifications`, `admin_role_id`, `is_active`, `is_online`, `is_approve`, `is_blocked`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'a5aa5844-cb5a-3aad-a5c2-243a31bd7ee7', 'Super', 'Admin', NULL, 'superadmin', '1', 'admin@abc.com', NULL, '2008-06-22 23:08:19', '$2y$10$l37V32yuaDEN9SMkzfD5Du8rYDS/f/GSPiZqdpFvcFs4Qxlmqf8Ua', 9191244321, '1970-10-30 19:35:54', NULL, 0, NULL, NULL, '127.0.0.1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 1, 0, '2023-10-03 07:37:48', '2023-10-03 07:37:48', NULL),
(2, '29f0b839-baa8-44dd-bef8-6c8e8be21adf', 'Subadmin', NULL, NULL, NULL, '1', 'abqcdwsw@abc.com', NULL, NULL, '$2y$10$mvQmtjZK.OVxzbzRO1Sfp.Repf6HwMbgZ4bWubB05FEAbgWmSTfW2', 1234567890, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'kolkata', 'newtown', 'WB', NULL, NULL, NULL, NULL, 2, 1, 0, 1, 0, '2023-12-28 07:34:18', '2023-12-28 07:34:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `gst_no` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `contact_person_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `additional_fields` longtext DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0:Inactive,1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `uuid`, `name`, `gst_no`, `city`, `state`, `country`, `address`, `type`, `contact_person_name`, `phone`, `email`, `additional_fields`, `company_id`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '5fa52c44-d742-4a6e-a33f-05d7348c00cd', 'Vendor', NULL, NULL, NULL, NULL, 'kolkata', 'supplier', 'souma', '1234567890', 'souma@abc.com', '\"null\"', 2, 1, '2023-10-03 07:59:30', '2023-10-03 07:59:30', NULL),
(2, '3cb2f972-761c-442e-b7dc-ee203e6993f0', 'Raj Enterprises', NULL, NULL, NULL, NULL, 'Pune', 'contractor', 'Raj', '9876908761', 'mahesh.max3il@gmail.com', '\"null\"', 1, 1, '2024-02-09 02:14:18', '2024-02-09 02:14:18', NULL),
(3, '8dd622a6-76e5-4658-90d0-d287ac4ffc29', 'Hiren', NULL, NULL, NULL, NULL, 'Pune', 'contractor', 'Hiren', '9876547890', NULL, '\"null\"', 1, 1, '2024-03-12 03:46:12', '2024-03-12 03:46:12', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `activities_uuid_unique` (`uuid`),
  ADD KEY `activities_parent_id_foreign` (`parent_id`),
  ADD KEY `activities_project_id_foreign` (`project_id`),
  ADD KEY `activities_subproject_id_foreign` (`subproject_id`),
  ADD KEY `activities_unit_id_foreign` (`unit_id`),
  ADD KEY `activities_company_id_foreign` (`company_id`);

--
-- Indexes for table `activity_histories`
--
ALTER TABLE `activity_histories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `activity_histories_uuid_unique` (`uuid`),
  ADD KEY `activity_histories_activities_id_foreign` (`activities_id`),
  ADD KEY `activity_histories_vendors_id_foreign` (`vendors_id`),
  ADD KEY `activity_histories_dpr_id_foreign` (`dpr_id`),
  ADD KEY `activity_histories_company_id_foreign` (`company_id`);

--
-- Indexes for table `additional_features`
--
ALTER TABLE `additional_features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_menus`
--
ALTER TABLE `admin_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_permissions`
--
ALTER TABLE `admin_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_profiles`
--
ALTER TABLE `admin_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_profiles_uuid_unique` (`uuid`),
  ADD KEY `admin_profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `admin_roles`
--
ALTER TABLE `admin_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_user_permissions`
--
ALTER TABLE `admin_user_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_user_permissions_user_id_foreign` (`user_id`),
  ADD KEY `admin_user_permissions_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `admin_user_roles`
--
ALTER TABLE `admin_user_roles`
  ADD PRIMARY KEY (`user_id`,`admin_role_id`),
  ADD KEY `admin_user_roles_admin_role_id_foreign` (`admin_role_id`);

--
-- Indexes for table `admin_user_role_permissions`
--
ALTER TABLE `admin_user_role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_user_role_permissions_role_id_foreign` (`role_id`),
  ADD KEY `admin_user_role_permissions_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `assets_uuid_unique` (`uuid`),
  ADD KEY `assets_project_id_foreign` (`project_id`),
  ADD KEY `assets_store_warehouses_id_foreign` (`store_warehouses_id`),
  ADD KEY `assets_unit_id_foreign` (`unit_id`),
  ADD KEY `assets_company_id_foreign` (`company_id`);

--
-- Indexes for table `assets_histories`
--
ALTER TABLE `assets_histories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `assets_histories_uuid_unique` (`uuid`),
  ADD KEY `assets_histories_assets_id_foreign` (`assets_id`),
  ADD KEY `assets_histories_activities_id_foreign` (`activities_id`),
  ADD KEY `assets_histories_vendors_id_foreign` (`vendors_id`),
  ADD KEY `assets_histories_dpr_id_foreign` (`dpr_id`),
  ADD KEY `assets_histories_company_id_foreign` (`company_id`);

--
-- Indexes for table `assets_opening_stocks`
--
ALTER TABLE `assets_opening_stocks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `assets_opening_stocks_uuid_unique` (`uuid`),
  ADD KEY `assets_opening_stocks_project_id_foreign` (`project_id`),
  ADD KEY `assets_opening_stocks_store_id_foreign` (`store_id`),
  ADD KEY `assets_opening_stocks_assets_id_foreign` (`assets_id`),
  ADD KEY `assets_opening_stocks_company_id_foreign` (`company_id`);

--
-- Indexes for table `banner_pages`
--
ALTER TABLE `banner_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `banner_pages_uuid_unique` (`uuid`),
  ADD KEY `banner_pages_page_id_foreign` (`page_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_state_id_foreign` (`state_id`),
  ADD KEY `cities_country_id_foreign` (`country_id`),
  ADD KEY `cities_slug_index` (`slug`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clients_uuid_unique` (`uuid`),
  ADD KEY `clients_project_id_foreign` (`project_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `companies_uuid_unique` (`uuid`),
  ADD KEY `companies_company_id_foreign` (`company_id`);

--
-- Indexes for table `companyuser_roles`
--
ALTER TABLE `companyuser_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companyuser_roles_company_id_foreign` (`company_id`),
  ADD KEY `companyuser_roles_company_user_id_foreign` (`company_user_id`),
  ADD KEY `companyuser_roles_company_role_id_foreign` (`company_role_id`);

--
-- Indexes for table `company_managments`
--
ALTER TABLE `company_managments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `company_managments_uuid_unique` (`uuid`),
  ADD KEY `company_managments_is_subscribed_foreign` (`is_subscribed`);

--
-- Indexes for table `company_permissions`
--
ALTER TABLE `company_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_roles`
--
ALTER TABLE `company_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_role_managments`
--
ALTER TABLE `company_role_managments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_role_permissions`
--
ALTER TABLE `company_role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_role_permissions_company_role_id_foreign` (`company_role_id`),
  ADD KEY `company_role_permissions_company_permission_id_foreign` (`company_permission_id`);

--
-- Indexes for table `company_users`
--
ALTER TABLE `company_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `company_users_uuid_unique` (`uuid`),
  ADD UNIQUE KEY `company_users_email_unique` (`email`),
  ADD KEY `company_users_company_role_id_foreign` (`company_role_id`),
  ADD KEY `company_users_company_id_foreign` (`company_id`) USING BTREE,
  ADD KEY `company_users_country_foreign` (`country`),
  ADD KEY `company_users_state_foreign` (`state`),
  ADD KEY `company_users_city_foreign` (`city`);

--
-- Indexes for table `company_user_permissions`
--
ALTER TABLE `company_user_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_user_permissions_company_user_id_foreign` (`company_user_id`),
  ADD KEY `company_user_permissions_company_permission_id_foreign` (`company_permission_id`);

--
-- Indexes for table `company_user_roles`
--
ALTER TABLE `company_user_roles`
  ADD PRIMARY KEY (`company_user_id`,`company_role_id`),
  ADD KEY `company_user_roles_company_role_id_foreign` (`company_role_id`);

--
-- Indexes for table `contact_details`
--
ALTER TABLE `contact_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `countries_slug_index` (`slug`),
  ADD KEY `countries_status_index` (`status`);

--
-- Indexes for table `dprs`
--
ALTER TABLE `dprs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dprs_uuid_unique` (`uuid`),
  ADD KEY `dprs_projects_id_foreign` (`projects_id`),
  ADD KEY `dprs_sub_projects_id_foreign` (`sub_projects_id`),
  ADD KEY `dprs_activities_id_foreign` (`activities_id`),
  ADD KEY `dprs_assets_id_foreign` (`assets_id`),
  ADD KEY `dprs_labours_id_foreign` (`labours_id`),
  ADD KEY `dprs_company_id_foreign` (`company_id`),
  ADD KEY `dprs_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `goods_uuid_unique` (`uuid`),
  ADD KEY `goods_unit_id_foreign` (`unit_id`),
  ADD KEY `goods_company_id_foreign` (`company_id`);

--
-- Indexes for table `hinderances`
--
ALTER TABLE `hinderances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hinderances_uuid_unique` (`uuid`),
  ADD KEY `hinderances_company_users_id_foreign` (`company_users_id`),
  ADD KEY `hinderances_projects_id_foreign` (`projects_id`),
  ADD KEY `hinderances_sub_projects_id_foreign` (`sub_projects_id`),
  ADD KEY `hinderances_company_id_foreign` (`company_id`),
  ADD KEY `hinderances_dpr_id_foreign` (`dpr_id`);

--
-- Indexes for table `home_pages`
--
ALTER TABLE `home_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `home_pages_uuid_unique` (`uuid`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inventories_uuid_unique` (`uuid`),
  ADD KEY `inventories_projects_id_foreign` (`projects_id`),
  ADD KEY `inventories_store_warehouses_id_foreign` (`store_warehouses_id`),
  ADD KEY `inventories_materials_id_foreign` (`materials_id`),
  ADD KEY `inventories_activities_id_foreign` (`activities_id`),
  ADD KEY `inventories_user_id_foreign` (`user_id`),
  ADD KEY `inventories_company_id_foreign` (`company_id`),
  ADD KEY `inventories_assets_id_foreign` (`assets_id`);

--
-- Indexes for table `inventory_stores`
--
ALTER TABLE `inventory_stores`
  ADD KEY `inventory_stores_inventories_id_foreign` (`inventories_id`),
  ADD KEY `inventory_stores_store_warehouses_id_foreign` (`store_warehouses_id`);

--
-- Indexes for table `inv_inwards`
--
ALTER TABLE `inv_inwards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inv_inwards_uuid_unique` (`uuid`),
  ADD KEY `inv_inwards_projects_id_foreign` (`projects_id`),
  ADD KEY `inv_inwards_store_id_foreign` (`store_id`),
  ADD KEY `inv_inwards_user_id_foreign` (`user_id`),
  ADD KEY `inv_inwards_company_id_foreign` (`company_id`);

--
-- Indexes for table `inv_inward_entry_types`
--
ALTER TABLE `inv_inward_entry_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inv_inward_entry_types_uuid_unique` (`uuid`),
  ADD KEY `inv_inward_entry_types_slug_index` (`slug`);

--
-- Indexes for table `inv_issues`
--
ALTER TABLE `inv_issues`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inv_issues_uuid_unique` (`uuid`),
  ADD KEY `inv_issues_projects_id_foreign` (`projects_id`),
  ADD KEY `inv_issues_store_id_foreign` (`store_id`),
  ADD KEY `inv_issues_user_id_foreign` (`user_id`),
  ADD KEY `inv_issues_company_id_foreign` (`company_id`);

--
-- Indexes for table `inv_issues_details`
--
ALTER TABLE `inv_issues_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inv_issues_details_uuid_unique` (`uuid`),
  ADD KEY `inv_issues_details_inv_issue_goods_id_foreign` (`inv_issue_goods_id`),
  ADD KEY `inv_issues_details_materials_id_foreign` (`materials_id`),
  ADD KEY `inv_issues_details_activities_id_foreign` (`activities_id`),
  ADD KEY `inv_issues_details_company_id_foreign` (`company_id`);

--
-- Indexes for table `inv_issue_goods`
--
ALTER TABLE `inv_issue_goods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inv_issue_goods_uuid_unique` (`uuid`),
  ADD KEY `inv_issue_goods_inv_issues_id_foreign` (`inv_issues_id`),
  ADD KEY `inv_issue_goods_materials_id_foreign` (`materials_id`),
  ADD KEY `inv_issue_goods_inv_issue_lists_id_foreign` (`inv_issue_lists_id`),
  ADD KEY `inv_issue_goods_company_id_foreign` (`company_id`);

--
-- Indexes for table `inv_issue_lists`
--
ALTER TABLE `inv_issue_lists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inv_issue_lists_uuid_unique` (`uuid`),
  ADD KEY `inv_issue_lists_slug_index` (`slug`);

--
-- Indexes for table `inv_issue_stores`
--
ALTER TABLE `inv_issue_stores`
  ADD KEY `inv_issue_stores_inv_issues_id_foreign` (`inv_issues_id`),
  ADD KEY `inv_issue_stores_store_warehouses_id_foreign` (`store_warehouses_id`);

--
-- Indexes for table `inv_returns`
--
ALTER TABLE `inv_returns`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inv_returns_uuid_unique` (`uuid`),
  ADD KEY `inv_returns_projects_id_foreign` (`projects_id`),
  ADD KEY `inv_returns_store_id_foreign` (`store_id`),
  ADD KEY `inv_returns_user_id_foreign` (`user_id`),
  ADD KEY `inv_returns_company_id_foreign` (`company_id`);

--
-- Indexes for table `inv_returns_details`
--
ALTER TABLE `inv_returns_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inv_returns_details_uuid_unique` (`uuid`),
  ADD KEY `inv_returns_details_inv_return_goods_id_foreign` (`inv_return_goods_id`),
  ADD KEY `inv_returns_details_materials_id_foreign` (`materials_id`),
  ADD KEY `inv_returns_details_activities_id_foreign` (`activities_id`),
  ADD KEY `inv_returns_details_company_id_foreign` (`company_id`);

--
-- Indexes for table `inv_return_goods`
--
ALTER TABLE `inv_return_goods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inv_return_goods_uuid_unique` (`uuid`),
  ADD KEY `inv_return_goods_inv_returns_id_foreign` (`inv_returns_id`),
  ADD KEY `inv_return_goods_materials_id_foreign` (`materials_id`),
  ADD KEY `inv_return_goods_inv_issue_lists_id_foreign` (`inv_issue_lists_id`),
  ADD KEY `inv_return_goods_company_id_foreign` (`company_id`);

--
-- Indexes for table `inv_return_stores`
--
ALTER TABLE `inv_return_stores`
  ADD KEY `inv_return_stores_inv_returns_id_foreign` (`inv_returns_id`),
  ADD KEY `inv_return_stores_store_warehouses_id_foreign` (`store_warehouses_id`);

--
-- Indexes for table `inward_goods`
--
ALTER TABLE `inward_goods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inward_goods_uuid_unique` (`uuid`),
  ADD KEY `inward_goods_inv_inwards_id_foreign` (`inv_inwards_id`),
  ADD KEY `inward_goods_materials_id_foreign` (`materials_id`),
  ADD KEY `inward_goods_inv_inward_entry_types_id_foreign` (`inv_inward_entry_types_id`),
  ADD KEY `inward_goods_company_id_foreign` (`company_id`),
  ADD KEY `inward_goods_vendors_id_foreign` (`vendors_id`);

--
-- Indexes for table `inward_goods_details`
--
ALTER TABLE `inward_goods_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inward_goods_details_uuid_unique` (`uuid`),
  ADD KEY `inward_goods_details_inward_goods_id_foreign` (`inward_goods_id`),
  ADD KEY `inward_goods_details_materials_id_foreign` (`materials_id`),
  ADD KEY `inward_goods_details_company_id_foreign` (`company_id`),
  ADD KEY `inward_goods_details_assets_id_foreign` (`assets_id`);

--
-- Indexes for table `inward_stores`
--
ALTER TABLE `inward_stores`
  ADD KEY `inward_stores_inv_inwards_id_foreign` (`inv_inwards_id`),
  ADD KEY `inward_stores_store_warehouses_id_foreign` (`store_warehouses_id`);

--
-- Indexes for table `labours`
--
ALTER TABLE `labours`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `labours_uuid_unique` (`uuid`),
  ADD KEY `labours_company_id_foreign` (`company_id`),
  ADD KEY `labours_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `labour_histories`
--
ALTER TABLE `labour_histories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `labour_histories_uuid_unique` (`uuid`),
  ADD KEY `labour_histories_labours_id_foreign` (`labours_id`),
  ADD KEY `labour_histories_activities_id_foreign` (`activities_id`),
  ADD KEY `labour_histories_vendors_id_foreign` (`vendors_id`),
  ADD KEY `labour_histories_company_id_foreign` (`company_id`),
  ADD KEY `labour_histories_dpr_id_foreign` (`dpr_id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `materials_uuid_unique` (`uuid`),
  ADD KEY `materials_unit_id_foreign` (`unit_id`),
  ADD KEY `materials_company_id_foreign` (`company_id`);

--
-- Indexes for table `materials_histories`
--
ALTER TABLE `materials_histories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `materials_histories_uuid_unique` (`uuid`),
  ADD KEY `materials_histories_materials_id_foreign` (`materials_id`),
  ADD KEY `materials_histories_activities_id_foreign` (`activities_id`),
  ADD KEY `materials_histories_vendors_id_foreign` (`vendors_id`),
  ADD KEY `materials_histories_company_id_foreign` (`company_id`),
  ADD KEY `materials_histories_dpr_id_foreign` (`dpr_id`);

--
-- Indexes for table `materials_stock_management`
--
ALTER TABLE `materials_stock_management`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `materials_stock_management_code_unique` (`code`),
  ADD KEY `materials_stock_management_project_id_foreign` (`project_id`),
  ADD KEY `materials_stock_management_store_id_foreign` (`store_id`),
  ADD KEY `materials_stock_management_unit_id_foreign` (`unit_id`),
  ADD KEY `materials_stock_management_company_id_foreign` (`company_id`);

--
-- Indexes for table `materials_stock_reports`
--
ALTER TABLE `materials_stock_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `materials_stock_reports_material_id_foreign` (`material_id`),
  ADD KEY `materials_stock_reports_company_id_foreign` (`company_id`);

--
-- Indexes for table `material_issues`
--
ALTER TABLE `material_issues`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `material_issues_uuid_unique` (`uuid`),
  ADD KEY `material_issues_project_id_foreign` (`project_id`),
  ADD KEY `material_issues_store_id_foreign` (`store_id`),
  ADD KEY `material_issues_material_id_foreign` (`material_id`),
  ADD KEY `material_issues_company_id_foreign` (`company_id`);

--
-- Indexes for table `material_issue_stocks`
--
ALTER TABLE `material_issue_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `material_issue_stocks_project_id_foreign` (`project_id`),
  ADD KEY `material_issue_stocks_store_id_foreign` (`store_id`),
  ADD KEY `material_issue_stocks_material_id_foreign` (`material_id`),
  ADD KEY `material_issue_stocks_company_id_foreign` (`company_id`);

--
-- Indexes for table `material_opening_stocks`
--
ALTER TABLE `material_opening_stocks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `material_opening_stocks_uuid_unique` (`uuid`),
  ADD KEY `material_opening_stocks_project_id_foreign` (`project_id`),
  ADD KEY `material_opening_stocks_store_id_foreign` (`store_id`),
  ADD KEY `material_opening_stocks_material_id_foreign` (`material_id`),
  ADD KEY `material_opening_stocks_company_id_foreign` (`company_id`);

--
-- Indexes for table `material_requests`
--
ALTER TABLE `material_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `material_requests_uuid_unique` (`uuid`),
  ADD UNIQUE KEY `material_requests_request_id_unique` (`request_id`),
  ADD KEY `material_requests_projects_id_foreign` (`projects_id`),
  ADD KEY `material_requests_sub_projects_id_foreign` (`sub_projects_id`),
  ADD KEY `material_requests_user_id_foreign` (`user_id`),
  ADD KEY `material_requests_company_id_foreign` (`company_id`);

--
-- Indexes for table `material_request_details`
--
ALTER TABLE `material_request_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `material_request_details_uuid_unique` (`uuid`),
  ADD UNIQUE KEY `material_request_details_request_id_unique` (`request_id`),
  ADD KEY `material_request_details_projects_id_foreign` (`projects_id`),
  ADD KEY `material_request_details_sub_projects_id_foreign` (`sub_projects_id`),
  ADD KEY `material_request_details_materials_id_foreign` (`materials_id`),
  ADD KEY `material_request_details_material_requests_id_foreign` (`material_requests_id`),
  ADD KEY `material_request_details_activities_id_foreign` (`activities_id`),
  ADD KEY `material_request_details_company_id_foreign` (`company_id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_user_id_foreign` (`user_id`),
  ADD KEY `media_mediaable_type_mediaable_id_index` (`mediaable_type`,`mediaable_id`);

--
-- Indexes for table `menu_managments`
--
ALTER TABLE `menu_managments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menu_managments_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `opening_stocks`
--
ALTER TABLE `opening_stocks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `opening_stocks_uuid_unique` (`uuid`),
  ADD KEY `opening_stocks_unit_id_foreign` (`unit_id`),
  ADD KEY `opening_stocks_company_id_foreign` (`company_id`);

--
-- Indexes for table `page_managments`
--
ALTER TABLE `page_managments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `page_managments_uuid_unique` (`uuid`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `profile_designations`
--
ALTER TABLE `profile_designations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `profile_designations_uuid_unique` (`uuid`),
  ADD KEY `profile_designations_company_id_foreign` (`company_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `projects_uuid_unique` (`uuid`),
  ADD KEY `projects_company_id_foreign` (`company_id`),
  ADD KEY `projects_companies_id_foreign` (`companies_id`);

--
-- Indexes for table `project_companies`
--
ALTER TABLE `project_companies`
  ADD PRIMARY KEY (`project_id`,`company_id`),
  ADD KEY `project_companies_company_id_foreign` (`company_id`);

--
-- Indexes for table `project_subproject`
--
ALTER TABLE `project_subproject`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_subproject_project_id_foreign` (`project_id`),
  ADD KEY `project_subproject_subproject_id_foreign` (`subproject_id`);

--
-- Indexes for table `quotes`
--
ALTER TABLE `quotes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `quotes_uuid_unique` (`uuid`),
  ADD KEY `quotes_projects_id_foreign` (`projects_id`),
  ADD KEY `quotes_store_id_foreign` (`store_id`),
  ADD KEY `quotes_user_id_foreign` (`user_id`),
  ADD KEY `quotes_company_id_foreign` (`company_id`);

--
-- Indexes for table `quotes_details`
--
ALTER TABLE `quotes_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `quotes_details_uuid_unique` (`uuid`),
  ADD KEY `quotes_details_quotes_id_foreign` (`quotes_id`),
  ADD KEY `quotes_details_materials_id_foreign` (`materials_id`),
  ADD KEY `quotes_details_material_requests_id_foreign` (`material_requests_id`),
  ADD KEY `quotes_details_company_id_foreign` (`company_id`);

--
-- Indexes for table `safeties`
--
ALTER TABLE `safeties`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `safeties_uuid_unique` (`uuid`),
  ADD KEY `safeties_company_users_id_foreign` (`company_users_id`),
  ADD KEY `safeties_projects_id_foreign` (`projects_id`),
  ADD KEY `safeties_sub_projects_id_foreign` (`sub_projects_id`),
  ADD KEY `safeties_company_id_foreign` (`company_id`),
  ADD KEY `safeties_dpr_id_foreign` (`dpr_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`),
  ADD KEY `states_country_id_foreign` (`country_id`),
  ADD KEY `states_slug_index` (`slug`);

--
-- Indexes for table `stock_managments`
--
ALTER TABLE `stock_managments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stock_managments_uuid_unique` (`uuid`),
  ADD KEY `stock_managments_unit_id_foreign` (`unit_id`),
  ADD KEY `stock_managments_company_id_foreign` (`company_id`);

--
-- Indexes for table `stock_reports`
--
ALTER TABLE `stock_reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stock_reports_uuid_unique` (`uuid`),
  ADD KEY `stock_reports_company_id_foreign` (`company_id`);

--
-- Indexes for table `store_warehouses`
--
ALTER TABLE `store_warehouses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `store_warehouses_uuid_unique` (`uuid`),
  ADD KEY `store_warehouses_company_id_foreign` (`company_id`),
  ADD KEY `store_warehouses_projects_id_foreign` (`projects_id`);

--
-- Indexes for table `subscription_packages`
--
ALTER TABLE `subscription_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription_package_options`
--
ALTER TABLE `subscription_package_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscription_package_options_subscription_packages_id_foreign` (`subscription_packages_id`);

--
-- Indexes for table `sub_projects`
--
ALTER TABLE `sub_projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sub_projects_uuid_unique` (`uuid`),
  ADD KEY `sub_projects_company_id_foreign` (`company_id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teams_uuid_unique` (`uuid`),
  ADD KEY `teams_company_id_foreign` (`company_id`),
  ADD KEY `teams_profile_role_foreign` (`profile_role`),
  ADD KEY `teams_reporting_person_foreign` (`reporting_person`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `units_uuid_unique` (`uuid`),
  ADD KEY `units_company_id_foreign` (`company_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_uuid_unique` (`uuid`),
  ADD UNIQUE KEY `users_app_id_unique` (`app_id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_mobile_number_unique` (`mobile_number`),
  ADD KEY `users_admin_role_id_foreign` (`admin_role_id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vendors_uuid_unique` (`uuid`),
  ADD KEY `vendors_company_id_foreign` (`company_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `activity_histories`
--
ALTER TABLE `activity_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `additional_features`
--
ALTER TABLE `additional_features`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_menus`
--
ALTER TABLE `admin_menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `admin_permissions`
--
ALTER TABLE `admin_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_profiles`
--
ALTER TABLE `admin_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_roles`
--
ALTER TABLE `admin_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `admin_user_permissions`
--
ALTER TABLE `admin_user_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_user_role_permissions`
--
ALTER TABLE `admin_user_role_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `assets_histories`
--
ALTER TABLE `assets_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `assets_opening_stocks`
--
ALTER TABLE `assets_opening_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banner_pages`
--
ALTER TABLE `banner_pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143782;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `companyuser_roles`
--
ALTER TABLE `companyuser_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `company_managments`
--
ALTER TABLE `company_managments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `company_permissions`
--
ALTER TABLE `company_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `company_roles`
--
ALTER TABLE `company_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `company_role_managments`
--
ALTER TABLE `company_role_managments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_role_permissions`
--
ALTER TABLE `company_role_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `company_users`
--
ALTER TABLE `company_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `company_user_permissions`
--
ALTER TABLE `company_user_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_details`
--
ALTER TABLE `contact_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `dprs`
--
ALTER TABLE `dprs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flights`
--
ALTER TABLE `flights`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `goods`
--
ALTER TABLE `goods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hinderances`
--
ALTER TABLE `hinderances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `home_pages`
--
ALTER TABLE `home_pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `inv_inwards`
--
ALTER TABLE `inv_inwards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `inv_inward_entry_types`
--
ALTER TABLE `inv_inward_entry_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `inv_issues`
--
ALTER TABLE `inv_issues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `inv_issues_details`
--
ALTER TABLE `inv_issues_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `inv_issue_goods`
--
ALTER TABLE `inv_issue_goods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `inv_issue_lists`
--
ALTER TABLE `inv_issue_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `inv_returns`
--
ALTER TABLE `inv_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `inv_returns_details`
--
ALTER TABLE `inv_returns_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `inv_return_goods`
--
ALTER TABLE `inv_return_goods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `inward_goods`
--
ALTER TABLE `inward_goods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `inward_goods_details`
--
ALTER TABLE `inward_goods_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `labours`
--
ALTER TABLE `labours`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `labour_histories`
--
ALTER TABLE `labour_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `materials_histories`
--
ALTER TABLE `materials_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `materials_stock_management`
--
ALTER TABLE `materials_stock_management`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materials_stock_reports`
--
ALTER TABLE `materials_stock_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material_issues`
--
ALTER TABLE `material_issues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material_issue_stocks`
--
ALTER TABLE `material_issue_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `material_opening_stocks`
--
ALTER TABLE `material_opening_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `material_requests`
--
ALTER TABLE `material_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `material_request_details`
--
ALTER TABLE `material_request_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_managments`
--
ALTER TABLE `menu_managments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `opening_stocks`
--
ALTER TABLE `opening_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `page_managments`
--
ALTER TABLE `page_managments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profile_designations`
--
ALTER TABLE `profile_designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `project_subproject`
--
ALTER TABLE `project_subproject`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `quotes`
--
ALTER TABLE `quotes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `quotes_details`
--
ALTER TABLE `quotes_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `safeties`
--
ALTER TABLE `safeties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4860;

--
-- AUTO_INCREMENT for table `stock_managments`
--
ALTER TABLE `stock_managments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_reports`
--
ALTER TABLE `stock_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store_warehouses`
--
ALTER TABLE `store_warehouses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subscription_packages`
--
ALTER TABLE `subscription_packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subscription_package_options`
--
ALTER TABLE `subscription_package_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `sub_projects`
--
ALTER TABLE `sub_projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `company_managments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activities_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `activities` (`id`),
  ADD CONSTRAINT `activities_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `activities_subproject_id_foreign` FOREIGN KEY (`subproject_id`) REFERENCES `sub_projects` (`id`),
  ADD CONSTRAINT `activities_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `activity_histories`
--
ALTER TABLE `activity_histories`
  ADD CONSTRAINT `activity_histories_activities_id_foreign` FOREIGN KEY (`activities_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activity_histories_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `company_managments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activity_histories_dpr_id_foreign` FOREIGN KEY (`dpr_id`) REFERENCES `dprs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activity_histories_vendors_id_foreign` FOREIGN KEY (`vendors_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `admin_profiles`
--
ALTER TABLE `admin_profiles`
  ADD CONSTRAINT `admin_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `admin_user_permissions`
--
ALTER TABLE `admin_user_permissions`
  ADD CONSTRAINT `admin_user_permissions_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `admin_menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `admin_user_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `admin_user_roles`
--
ALTER TABLE `admin_user_roles`
  ADD CONSTRAINT `admin_user_roles_admin_role_id_foreign` FOREIGN KEY (`admin_role_id`) REFERENCES `admin_roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `admin_user_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `admin_user_role_permissions`
--
ALTER TABLE `admin_user_role_permissions`
  ADD CONSTRAINT `admin_user_role_permissions_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `admin_menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `admin_user_role_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `admin_roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `assets_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `company_managments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assets_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `assets_store_warehouses_id_foreign` FOREIGN KEY (`store_warehouses_id`) REFERENCES `store_warehouses` (`id`),
  ADD CONSTRAINT `assets_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `assets_opening_stocks`
--
ALTER TABLE `assets_opening_stocks`
  ADD CONSTRAINT `assets_opening_stocks_assets_id_foreign` FOREIGN KEY (`assets_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assets_opening_stocks_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `company_managments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assets_opening_stocks_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assets_opening_stocks_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `store_warehouses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `banner_pages`
--
ALTER TABLE `banner_pages`
  ADD CONSTRAINT `banner_pages_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `page_managments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `company_managments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `companyuser_roles`
--
ALTER TABLE `companyuser_roles`
  ADD CONSTRAINT `companyuser_roles_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `company_managments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `companyuser_roles_company_role_id_foreign` FOREIGN KEY (`company_role_id`) REFERENCES `company_roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `companyuser_roles_company_user_id_foreign` FOREIGN KEY (`company_user_id`) REFERENCES `company_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `company_managments`
--
ALTER TABLE `company_managments`
  ADD CONSTRAINT `company_managments_is_subscribed_foreign` FOREIGN KEY (`is_subscribed`) REFERENCES `subscription_packages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `company_role_permissions`
--
ALTER TABLE `company_role_permissions`
  ADD CONSTRAINT `company_role_permissions_company_permission_id_foreign` FOREIGN KEY (`company_permission_id`) REFERENCES `company_permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `company_role_permissions_company_role_id_foreign` FOREIGN KEY (`company_role_id`) REFERENCES `company_roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `company_users`
--
ALTER TABLE `company_users`
  ADD CONSTRAINT `company_users_city_foreign` FOREIGN KEY (`city`) REFERENCES `cities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `company_users_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `company_managments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `company_users_company_role_id_foreign` FOREIGN KEY (`company_role_id`) REFERENCES `company_roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `company_users_country_foreign` FOREIGN KEY (`country`) REFERENCES `countries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `company_users_state_foreign` FOREIGN KEY (`state`) REFERENCES `states` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `company_user_permissions`
--
ALTER TABLE `company_user_permissions`
  ADD CONSTRAINT `company_user_permissions_company_permission_id_foreign` FOREIGN KEY (`company_permission_id`) REFERENCES `company_permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `company_user_permissions_company_user_id_foreign` FOREIGN KEY (`company_user_id`) REFERENCES `company_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `company_user_roles`
--
ALTER TABLE `company_user_roles`
  ADD CONSTRAINT `company_user_roles_company_role_id_foreign` FOREIGN KEY (`company_role_id`) REFERENCES `company_roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `company_user_roles_company_user_id_foreign` FOREIGN KEY (`company_user_id`) REFERENCES `company_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dprs`
--
ALTER TABLE `dprs`
  ADD CONSTRAINT `dprs_activities_id_foreign` FOREIGN KEY (`activities_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dprs_assets_id_foreign` FOREIGN KEY (`assets_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dprs_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `company_managments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dprs_labours_id_foreign` FOREIGN KEY (`labours_id`) REFERENCES `labours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dprs_projects_id_foreign` FOREIGN KEY (`projects_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dprs_sub_projects_id_foreign` FOREIGN KEY (`sub_projects_id`) REFERENCES `sub_projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dprs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `company_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `goods`
--
ALTER TABLE `goods`
  ADD CONSTRAINT `goods_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `company_managments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `goods_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hinderances`
--
ALTER TABLE `hinderances`
  ADD CONSTRAINT `hinderances_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `company_managments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hinderances_company_users_id_foreign` FOREIGN KEY (`company_users_id`) REFERENCES `company_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hinderances_projects_id_foreign` FOREIGN KEY (`projects_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hinderances_sub_projects_id_foreign` FOREIGN KEY (`sub_projects_id`) REFERENCES `sub_projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventories`
--
ALTER TABLE `inventories`
  ADD CONSTRAINT `inventories_activities_id_foreign` FOREIGN KEY (`activities_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventories_assets_id_foreign` FOREIGN KEY (`assets_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventories_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `company_managments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventories_materials_id_foreign` FOREIGN KEY (`materials_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventories_projects_id_foreign` FOREIGN KEY (`projects_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventories_store_warehouses_id_foreign` FOREIGN KEY (`store_warehouses_id`) REFERENCES `store_warehouses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `company_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inv_inwards`
--
ALTER TABLE `inv_inwards`
  ADD CONSTRAINT `inv_inwards_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `company_managments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inv_inwards_projects_id_foreign` FOREIGN KEY (`projects_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inv_inwards_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `store_warehouses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inv_inwards_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `company_users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
