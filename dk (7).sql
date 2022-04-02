-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 02, 2022 at 04:06 PM
-- Server version: 8.0.28-0ubuntu0.20.04.3
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dk`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `uuid` binary(16) NOT NULL,
  `identity` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `firstName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lastName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'inactive',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`uuid`, `identity`, `password`, `firstName`, `lastName`, `status`, `created`, `updated`) VALUES
(0x11ec9f94977f7894a8f77a4cea3b0f40, 'admin', '$2y$11$OwMimRB1aTrv.VH0uRIDFeU3eh7NNraKncCRruhW.lKOPyz/R7Fq6', 'DotKernel', 'Admin', 'active', '2022-03-09 10:35:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_role`
--

CREATE TABLE `admin_role` (
  `uuid` binary(16) NOT NULL,
  `name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_role`
--

INSERT INTO `admin_role` (`uuid`, `name`, `created`, `updated`) VALUES
(0x11ec9f949742b8dcac527a4cea3b0f40, 'superuser', '2022-03-09 10:35:08', NULL),
(0x11ec9f94977f73809bbe7a4cea3b0f40, 'admin', '2022-03-09 10:35:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_roles`
--

CREATE TABLE `admin_roles` (
  `userUuid` binary(16) NOT NULL,
  `roleUuid` binary(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_roles`
--

INSERT INTO `admin_roles` (`userUuid`, `roleUuid`) VALUES
(0x11ec9f94977f7894a8f77a4cea3b0f40, 0x11ec9f949742b8dcac527a4cea3b0f40);

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `uuid` binary(16) NOT NULL,
  `name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` enum('active','deleted') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'active',
  `year` binary(16) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`uuid`, `name`, `status`, `year`, `created`, `updated`) VALUES
(0x11eca13593a1e2aaaac0f21d708e6571, 'matematica', 'active', 0x11eca13372be298892ebf21d708e6571, '2022-03-18 12:49:36', NULL),
(0x11eca539a8a3e466a563f65e98372cfb, 'informatica', 'active', 0x11eca1336cb463d6a07cf21d708e6571, '2022-03-16 15:44:00', '2022-03-23 15:51:12'),
(0x11ecaac152f7176caf467a4eab80a2a0, 'tehnici de programare', 'active', 0x11eca1359947f31685ccf21d708e6571, '2022-03-23 15:55:14', '2022-03-25 11:15:34'),
(0x11ecaac155f4abd2912c7a4eab80a2a0, 'OOP', 'active', 0x11eca13593a1e2aaaac0f21d708e6571, '2022-03-23 15:56:43', NULL),
(0x11ecaac157d246628bf67a4eab80a2a0, 'programare paralela', 'active', 0x11eca13372be298892ebf21d708e6571, '2022-03-23 15:58:09', NULL),
(0x11ecaac159764f04a59f7a4eab80a2a0, 'ora lu Sergiu', 'active', 0x11eca13372be298892ebf21d708e6571, '2022-03-23 15:59:09', NULL),
(0x11ecaac15da8f9c8ad087a4eab80a2a0, 'programare', 'active', 0x11eca1359947f31685ccf21d708e6571, '2022-03-29 05:20:10', NULL),
(0x11ecaac15f785ea6b82d7a4eab80a2a0, 'backtracking', 'active', 0x11eca1336cb463d6a07cf21d708e6571, '2022-03-29 05:19:19', NULL),
(0x11ecaf2005f5b9babb788ecd2ecfe55e, 'lucrarea de licenta', 'active', 0x11eca13593a1e2aaaac0f21d708e6571, '2022-03-29 05:22:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contact_message`
--

CREATE TABLE `contact_message` (
  `uuid` binary(16) NOT NULL,
  `email` varchar(150) NOT NULL,
  `name` varchar(150) NOT NULL,
  `subject` text NOT NULL,
  `message` text NOT NULL,
  `messageType` enum('Bug Report','Feature','Report User','Another','new_message') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'new_message',
  `messageStatus` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'inactive',
  `platform` enum('website','designer','admin') NOT NULL DEFAULT 'website',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contact_message`
--

INSERT INTO `contact_message` (`uuid`, `email`, `name`, `subject`, `message`, `messageType`, `messageStatus`, `platform`, `created`, `updated`) VALUES
(0x11eca1336774651aa542f21d708e6571, 'natipop1@gmail.com', 'popnatanael', 'DotKernel Message 2022-03-11 14:04:28', 'asdfasdf', 'Feature', 'active', 'website', '2022-03-11 12:04:29', '2022-03-15 13:07:24'),
(0x11eca1336cb463d6a07cf21d708e6571, 'natipop2@gmail.com', 'pop natanael', 'DotKernel Message 2022-03-11 14:04:38', 'asdfasdfadfd', 'Bug Report', 'active', 'website', '2022-03-11 12:04:38', '2022-03-15 13:27:14'),
(0x11eca13372be298892ebf21d708e6571, 'natipo222@gmail.com', 'pop natanaelx', 'DotKernel Message 2022-03-11 14:04:48', ':)', 'Another', 'active', 'website', '2022-03-11 12:04:48', '2022-03-14 11:00:29'),
(0x11eca13593a1e2aaaac0f21d708e6571, 'natipop4@gmail.com', 'pop natanaelx', 'DotKernel Message 2022-03-11 14:20:02', 'asdasd', 'Report User', 'active', 'website', '2022-03-11 12:20:02', '2022-03-15 13:07:30'),
(0x11eca1359947f31685ccf21d708e6571, 'natipop4@gmail.com', 'pop natanaelx', 'DotKernel Message 2022-03-11 14:20:11', 'asdasdasdasd', 'Bug Report', 'inactive', 'website', '2022-03-11 12:20:11', '2022-03-11 12:20:11'),
(0x11eca143539db23ea7fff21d708e6571, 'natipop4@gmail.com', 'asdf', 'DotKernel Message 2022-03-11 15:58:27', 'asdfasdf', 'Report User', 'inactive', 'website', '2022-03-11 13:58:27', '2022-03-11 13:58:27'),
(0x11ecaac15abc570a942f7a4eab80a2a0, 'nat@yahoo.com', 'asd', 'DotKernel Message 2022-03-23 17:53:16', 'asdsss', 'new_message', 'inactive', 'website', '2022-03-23 15:53:16', '2022-03-23 15:53:16'),
(0x11ecaac15c67a00aa5c17a4eab80a2a0, 'nat@yahoo.com', 'asd', 'DotKernel Message 2022-03-23 17:53:19', 'asdssss', 'new_message', 'inactive', 'website', '2022-03-23 15:53:19', '2022-03-23 15:53:19'),
(0x11ecaac15da8f9c8ad087a4eab80a2a0, 'nat@yahoo.com', 'asd', 'DotKernel Message 2022-03-23 17:53:21', 'asdsssss', 'new_message', 'inactive', 'website', '2022-03-23 15:53:21', '2022-03-23 15:53:21'),
(0x11ecaac15f785ea6b82d7a4eab80a2a0, 'nat@yahoo.com', 'asd', 'DotKernel Message 2022-03-23 17:53:24', 'asdssssss', 'new_message', 'inactive', 'website', '2022-03-23 15:53:24', '2022-03-23 15:53:24'),
(0x11ecaf2005f5b9babb788ecd2ecfe55e, 'nat@yahoo.com', 'asd', 'DotKernel Message 2022-03-29 08:21:01', 'asdasd', 'new_message', 'inactive', 'website', '2022-03-29 05:21:01', '2022-03-29 05:21:01'),
(0x11ecb0025d846efa95c0126449f174d7, 'asd@gmail.com', 'asd', 'DotKernel Message 2022-03-30 11:21:14', 'asd', 'new_message', 'inactive', 'website', '2022-03-30 08:21:14', '2022-03-30 08:21:14');

-- --------------------------------------------------------

--
-- Table structure for table `grade`
--

CREATE TABLE `grade` (
  `uuid` binary(16) NOT NULL,
  `studentId` binary(16) NOT NULL,
  `classId` binary(16) NOT NULL,
  `grade` int NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grade`
--

INSERT INTO `grade` (`uuid`, `studentId`, `classId`, `grade`, `created`, `updated`) VALUES
(0x11ecaf634f0c0ef4947f92b7ca34e5d8, 0x11ecacfbcec3b3fabb34e2bb1f4ef956, 0x11ecaac15f785ea6b82d7a4eab80a2a0, 6, '2022-03-29 13:22:40', '2022-03-29 13:22:40'),
(0x11ecaf63559f76de90bf92b7ca34e5d8, 0x11ecab5feec64624903fa2cd9a54727a, 0x11ecaac152f7176caf467a4eab80a2a0, 4, '2022-03-29 13:22:51', '2022-03-29 13:22:51'),
(0x11ecaf635c71de70bbb492b7ca34e5d8, 0x11ecab74cd2851aa9099a2cd9a54727a, 0x11eca539a8a3e466a563f65e98372cfb, 1, '2022-03-29 13:23:02', '2022-03-29 13:23:02'),
(0x11ecaf636af14332af6d92b7ca34e5d8, 0x11ecaabafb56f04688c17a4eab80a2a0, 0x11ecaac152f7176caf467a4eab80a2a0, 1, '2022-03-29 13:23:27', '2022-03-29 13:23:27'),
(0x11ecaf637392bf02a33292b7ca34e5d8, 0x11eca6bb043ab4c6b2341e0c518db576, 0x11ecaac15f785ea6b82d7a4eab80a2a0, 8, '2022-03-29 13:23:41', '2022-03-29 13:23:41'),
(0x11ecaf6395de7740aa3292b7ca34e5d8, 0x11ecaabc87b7ba74b5057a4eab80a2a0, 0x11ecaac155f4abd2912c7a4eab80a2a0, 1, '2022-03-29 13:24:39', '2022-03-29 13:24:39'),
(0x11ecaf63f823f268af1f92b7ca34e5d8, 0x11ecab624a53e0e4bc6ba2cd9a54727a, 0x11ecaac159764f04a59f7a4eab80a2a0, 10, '2022-03-29 13:27:24', '2022-03-29 13:27:24'),
(0x11ecaf63fd33ea42888292b7ca34e5d8, 0x11ecab624a53e0e4bc6ba2cd9a54727a, 0x11ecaac159764f04a59f7a4eab80a2a0, 5, '2022-03-29 13:27:32', '2022-03-29 13:27:32'),
(0x11ecaf640b7c96b28f1b92b7ca34e5d8, 0x11ecab74cd2851aa9099a2cd9a54727a, 0x11eca539a8a3e466a563f65e98372cfb, 9, '2022-03-29 13:27:56', '2022-03-29 13:27:56'),
(0x11ecaf64460e762e863e92b7ca34e5d8, 0x11ecab74cd2851aa9099a2cd9a54727a, 0x11eca539a8a3e466a563f65e98372cfb, 5, '2022-03-29 13:29:34', '2022-03-29 13:29:34'),
(0x11ecaf64802ae89ca37d92b7ca34e5d8, 0x11ecab624a53e0e4bc6ba2cd9a54727a, 0x11ecaac157d246628bf67a4eab80a2a0, 6, '2022-03-29 13:31:12', '2022-03-29 13:31:12'),
(0x11ecaf648fed1034932792b7ca34e5d8, 0x11ecab74cd2851aa9099a2cd9a54727a, 0x11ecaac157d246628bf67a4eab80a2a0, 1, '2022-03-29 13:31:38', '2022-03-29 13:31:38'),
(0x11ecaf657b9b91549a0192b7ca34e5d8, 0x11ecab74cd2851aa9099a2cd9a54727a, 0x11ecaac157d246628bf67a4eab80a2a0, 8, '2022-03-29 13:38:14', '2022-03-29 13:38:14'),
(0x11ecaf6588bb9582b9d292b7ca34e5d8, 0x11ecab624a53e0e4bc6ba2cd9a54727a, 0x11ecaac159764f04a59f7a4eab80a2a0, 6, '2022-03-29 13:38:36', '2022-03-29 13:38:36'),
(0x11ecaf6fc531687a966592b7ca34e5d8, 0x11ecab74cd2851aa9099a2cd9a54727a, 0x11ecaac157d246628bf67a4eab80a2a0, 5, '2022-03-29 14:51:52', '2022-03-29 14:51:52'),
(0x11ecaf705ad3ed3a8dda92b7ca34e5d8, 0x11ecab74cd2851aa9099a2cd9a54727a, 0x11eca539a8a3e466a563f65e98372cfb, 8, '2022-03-29 14:56:03', '2022-03-29 14:56:03'),
(0x11ecaf70b9f4d7acb41392b7ca34e5d8, 0x11eca6bb043ab4c6b2341e0c518db576, 0x11ecaac15f785ea6b82d7a4eab80a2a0, 6, '2022-03-29 14:58:43', '2022-03-29 14:58:43'),
(0x11ecaf70be57f2f28f6992b7ca34e5d8, 0x11eca6bb043ab4c6b2341e0c518db576, 0x11eca539a8a3e466a563f65e98372cfb, 6, '2022-03-29 14:58:50', '2022-03-29 14:58:50'),
(0x11ecaf70cad1ab7ca64992b7ca34e5d8, 0x11eca6bb043ab4c6b2341e0c518db576, 0x11ecaac159764f04a59f7a4eab80a2a0, 10, '2022-03-29 14:59:11', '2022-03-29 14:59:11'),
(0x11ecaf70cf7d5c84bd2992b7ca34e5d8, 0x11eca6bb043ab4c6b2341e0c518db576, 0x11ecaac157d246628bf67a4eab80a2a0, 4, '2022-03-29 14:59:19', '2022-03-29 14:59:19'),
(0x11ecaf70daf92d729a4f92b7ca34e5d8, 0x11eca6bb043ab4c6b2341e0c518db576, 0x11ecaf2005f5b9babb788ecd2ecfe55e, 6, '2022-03-29 14:59:38', '2022-03-29 14:59:38'),
(0x11ecb02138b0d3ec871e9619f7232749, 0x11ecab74cd2851aa9099a2cd9a54727a, 0x11eca539a8a3e466a563f65e98372cfb, 5, '2022-03-30 12:02:07', '2022-03-30 12:02:07'),
(0x11ecb02b3b5b979e93b59619f7232749, 0x11eca6bb043ab4c6b2341e0c518db576, 0x11ecaac157d246628bf67a4eab80a2a0, 7, '2022-03-30 13:13:46', '2022-03-30 13:13:46'),
(0x11ecb02cd4935806b3e09619f7232749, 0x11eca6baef5d1616b4811e0c518db576, 0x11eca539a8a3e466a563f65e98372cfb, 9, '2022-03-30 13:25:13', '2022-03-30 13:25:13'),
(0x11ecb02cdda26f68bf879619f7232749, 0x11eca6baef5d1616b4811e0c518db576, 0x11eca539a8a3e466a563f65e98372cfb, 1, '2022-03-30 13:25:28', '2022-03-30 13:25:28'),
(0x11ecb02ceaa5ecee8f4d9619f7232749, 0x11eca6baef5d1616b4811e0c518db576, 0x11ecaac15f785ea6b82d7a4eab80a2a0, 9, '2022-03-30 13:25:50', '2022-03-30 13:25:50'),
(0x11ecb02cee884eb0a5c29619f7232749, 0x11eca6baef5d1616b4811e0c518db576, 0x11eca539a8a3e466a563f65e98372cfb, 1, '2022-03-30 13:25:56', '2022-03-30 13:25:56'),
(0x11ecb032b2a5fd1a964b9619f7232749, 0x11eca6bb043ab4c6b2341e0c518db576, 0x11ecaac157d246628bf67a4eab80a2a0, 5, '2022-03-30 14:07:13', '2022-03-30 14:07:13'),
(0x11ecb032bce1b29cb5289619f7232749, 0x11eca6baef5d1616b4811e0c518db576, 0x11eca539a8a3e466a563f65e98372cfb, 8, '2022-03-30 14:07:30', '2022-03-30 14:07:30'),
(0x11ecb033f2733858b2c49619f7232749, 0x11ecab74cd2851aa9099a2cd9a54727a, 0x11ecaac15da8f9c8ad087a4eab80a2a0, 1, '2022-03-30 14:16:09', '2022-03-30 14:16:09'),
(0x11ecb034038816f4b0f49619f7232749, 0x11ecab74cd2851aa9099a2cd9a54727a, 0x11ecaac15da8f9c8ad087a4eab80a2a0, 1, '2022-03-30 14:16:38', '2022-03-30 14:16:38'),
(0x11ecb035abf4df6aa4419619f7232749, 0x11ecab624a53e0e4bc6ba2cd9a54727a, 0x11ecaac159764f04a59f7a4eab80a2a0, 6, '2022-03-30 14:28:30', '2022-03-30 14:28:30'),
(0x11ecb035b04cb1c8984a9619f7232749, 0x11ecab624a53e0e4bc6ba2cd9a54727a, 0x11ecaac159764f04a59f7a4eab80a2a0, 1, '2022-03-30 14:28:37', '2022-03-30 14:28:37'),
(0x11ecb035b336254a82a59619f7232749, 0x11ecab624a53e0e4bc6ba2cd9a54727a, 0x11ecaac159764f04a59f7a4eab80a2a0, 1, '2022-03-30 14:28:42', '2022-03-30 14:28:42'),
(0x11ecb10023c2511aae7fee261e7be780, 0x11ecab624a53e0e4bc6ba2cd9a54727a, 0x11ecaac159764f04a59f7a4eab80a2a0, 3, '2022-03-31 14:37:49', '2022-03-31 14:37:49'),
(0x11ecb1002b2260a89e3aee261e7be780, 0x11ecab5feec64624903fa2cd9a54727a, 0x11ecaac152f7176caf467a4eab80a2a0, 5, '2022-03-31 14:38:02', '2022-03-31 14:38:02'),
(0x11ecb100389972e48e84ee261e7be780, 0x11ecab624a53e0e4bc6ba2cd9a54727a, 0x11ecaac159764f04a59f7a4eab80a2a0, 1, '2022-03-31 14:38:24', '2022-03-31 14:38:24'),
(0x11ecb1048ad75c70a463ee261e7be780, 0x11eca6bb043ab4c6b2341e0c518db576, 0x11ecaac15f785ea6b82d7a4eab80a2a0, 4, '2022-03-31 15:09:20', '2022-03-31 15:09:20'),
(0x11ecb104aec98bf88fc8ee261e7be780, 0x11ecab5feec64624903fa2cd9a54727a, 0x11ecaac152f7176caf467a4eab80a2a0, 6, '2022-03-31 15:10:21', '2022-03-31 15:10:21'),
(0x11ecb108ed548d60a108ee261e7be780, 0x11ecb10891e1a846a3ccee261e7be780, 0x11ecaac159764f04a59f7a4eab80a2a0, 8, '2022-03-31 15:40:44', '2022-03-31 15:40:44'),
(0x11ecb10945ea8290b7b2ee261e7be780, 0x11ecb10920e8db36801cee261e7be780, 0x11ecaac15f785ea6b82d7a4eab80a2a0, 4, '2022-03-31 15:43:12', '2022-03-31 15:43:12'),
(0x11ecb109bb6258729958ee261e7be780, 0x11ecb1098ea7d3a2aff0ee261e7be780, 0x11ecaf2005f5b9babb788ecd2ecfe55e, 1, '2022-03-31 15:46:29', '2022-03-31 15:46:29'),
(0x11ecb10a68020190ab0dee261e7be780, 0x11ecb10920e8db36801cee261e7be780, 0x11ecaac15f785ea6b82d7a4eab80a2a0, 1, '2022-03-31 15:51:19', '2022-03-31 15:51:19'),
(0x11ecb10a9915c35297d0ee261e7be780, 0x11ecb10a7ff550cca27bee261e7be780, 0x11ecaac15f785ea6b82d7a4eab80a2a0, 1, '2022-03-31 15:52:41', '2022-03-31 15:52:41'),
(0x11ecb10d5d402a18ab58ee261e7be780, 0x11ecb10d4e7f56988653ee261e7be780, 0x11ecaac15f785ea6b82d7a4eab80a2a0, 1, '2022-03-31 16:12:29', '2022-03-31 16:12:29'),
(0x11ecb10e654c805c8ce9ee261e7be780, 0x11ecb10dc774a51cbc8cee261e7be780, 0x11eca539a8a3e466a563f65e98372cfb, 3, '2022-03-31 16:19:52', '2022-03-31 16:19:52'),
(0x11ecb10ea036c86c8a77ee261e7be780, 0x11ecab624a53e0e4bc6ba2cd9a54727a, 0x11ecaac155f4abd2912c7a4eab80a2a0, 6, '2022-03-31 16:21:31', '2022-03-31 16:21:31'),
(0x11ecb10eaca0e1be9468ee261e7be780, 0x11ecab624a53e0e4bc6ba2cd9a54727a, 0x11ecaac15f785ea6b82d7a4eab80a2a0, 6, '2022-03-31 16:21:52', '2022-03-31 16:21:52'),
(0x11ecb10ec63518fcb531ee261e7be780, 0x11ecb10ebee7237497deee261e7be780, 0x11eca539a8a3e466a563f65e98372cfb, 10, '2022-03-31 16:22:35', '2022-03-31 16:22:35'),
(0x11ecb10ee58afec4ad41ee261e7be780, 0x11ecb10edafe1914af1cee261e7be780, 0x11ecaac15f785ea6b82d7a4eab80a2a0, 1, '2022-03-31 16:23:28', '2022-03-31 16:23:28'),
(0x11ecb110fca1a8aea077ee261e7be780, 0x11ecb10ebee7237497deee261e7be780, 0x11eca13593a1e2aaaac0f21d708e6571, 3, '2022-03-31 16:38:25', '2022-03-31 16:38:25'),
(0x11ecb11106a8be009375ee261e7be780, 0x11ecb10ebee7237497deee261e7be780, 0x11ecaac15f785ea6b82d7a4eab80a2a0, 1, '2022-03-31 16:38:42', '2022-03-31 16:38:42'),
(0x11ecb111211f1658be1bee261e7be780, 0x11eca6bb043ab4c6b2341e0c518db576, 0x11eca539a8a3e466a563f65e98372cfb, 5, '2022-03-31 16:39:26', '2022-03-31 16:39:26'),
(0x11ecb11124d03ea8b15fee261e7be780, 0x11eca6bb043ab4c6b2341e0c518db576, 0x11ecaac15f785ea6b82d7a4eab80a2a0, 1, '2022-03-31 16:39:33', '2022-03-31 16:39:33'),
(0x11ecb1112f884098bba8ee261e7be780, 0x11ecb10ebee7237497deee261e7be780, 0x11ecaac15f785ea6b82d7a4eab80a2a0, 5, '2022-03-31 16:39:51', '2022-03-31 16:39:51'),
(0x11ecb1114adbee4eb05dee261e7be780, 0x11ecab624a53e0e4bc6ba2cd9a54727a, 0x11ecaf2005f5b9babb788ecd2ecfe55e, 1, '2022-03-31 16:40:37', '2022-03-31 16:40:37'),
(0x11ecb18d98a1bb50a72dde0f01a70bdd, 0x11ec9bcabc50431a9648d25807c60349, 0x11ecaac152f7176caf467a4eab80a2a0, 4, '2022-04-01 07:30:25', '2022-04-01 07:30:25'),
(0x11ecb18e8105825aa2fade0f01a70bdd, 0x11ecb18e17bcc88a97d7de0f01a70bdd, 0x11ecaac15f785ea6b82d7a4eab80a2a0, 6, '2022-04-01 07:36:54', '2022-04-01 07:36:54'),
(0x11ecb1910d1f1754b75ade0f01a70bdd, 0x11ecab624a53e0e4bc6ba2cd9a54727a, 0x11ecaac157d246628bf67a4eab80a2a0, 5, '2022-04-01 07:55:09', '2022-04-01 07:55:09'),
(0x11ecb191d52060a0b9c2de0f01a70bdd, 0x11ecb1912d0dab34bebfde0f01a70bdd, 0x11ecaac157d246628bf67a4eab80a2a0, 7, '2022-04-01 08:00:44', '2022-04-01 08:00:44'),
(0x11ecb192381d24aeade4de0f01a70bdd, 0x11ecb1912d0dab34bebfde0f01a70bdd, 0x11ecaac157d246628bf67a4eab80a2a0, 7, '2022-04-01 08:03:30', '2022-04-01 08:03:30');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `version` bigint NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20200416084037, 'DefaultSchema', '2020-09-09 13:52:53', '2020-09-09 13:52:54', 0),
(20200416084050, 'DefaultAdminSchema', '2022-03-09 10:34:42', '2022-03-09 10:34:58', 0),
(20200416154725, 'ContactMessage', '2020-09-09 13:52:54', '2020-09-09 13:52:54', 0);

-- --------------------------------------------------------

--
-- Table structure for table `students_class`
--

CREATE TABLE `students_class` (
  `class_uuid` binary(16) NOT NULL,
  `student_uuid` binary(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students_class`
--

INSERT INTO `students_class` (`class_uuid`, `student_uuid`) VALUES
(0x11ecaac152f7176caf467a4eab80a2a0, 0x11ec9bcabc50431a9648d25807c60349),
(0x11eca539a8a3e466a563f65e98372cfb, 0x11eca6baef5d1616b4811e0c518db576),
(0x11ecaac15f785ea6b82d7a4eab80a2a0, 0x11eca6baef5d1616b4811e0c518db576),
(0x11eca539a8a3e466a563f65e98372cfb, 0x11eca6bb043ab4c6b2341e0c518db576),
(0x11ecaac15f785ea6b82d7a4eab80a2a0, 0x11eca6bb043ab4c6b2341e0c518db576),
(0x11ecaac152f7176caf467a4eab80a2a0, 0x11ecaabafb56f04688c17a4eab80a2a0),
(0x11ecaac152f7176caf467a4eab80a2a0, 0x11ecab5feec64624903fa2cd9a54727a),
(0x11ecaac157d246628bf67a4eab80a2a0, 0x11ecab624a53e0e4bc6ba2cd9a54727a),
(0x11ecaac15f785ea6b82d7a4eab80a2a0, 0x11ecb10dc774a51cbc8cee261e7be780),
(0x11ecaac15f785ea6b82d7a4eab80a2a0, 0x11ecb10edafe1914af1cee261e7be780),
(0x11ecaac15f785ea6b82d7a4eab80a2a0, 0x11ecb18e17bcc88a97d7de0f01a70bdd),
(0x11ecaac157d246628bf67a4eab80a2a0, 0x11ecb1912d0dab34bebfde0f01a70bdd);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `uuid` binary(16) NOT NULL,
  `identity` varchar(100) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `status` enum('pending','active') NOT NULL DEFAULT 'pending',
  `year` binary(16) DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT '0',
  `hash` varchar(100) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uuid`, `identity`, `slug`, `password`, `status`, `year`, `isDeleted`, `hash`, `created`, `updated`) VALUES
(0x11ec9bcabc50431a9648d25807c60349, 'natipop1@yahoo.com', NULL, '$2y$10$VyQq7Xag6mY/jQftvaJjCelyhAVANJaUsRH9G.lH5qDkUuYNUelzu', 'active', 0x11eca1359947f31685ccf21d708e6571, 0, 'f5fbcb6f7994c14ccf6ffb79d9698dce8a0b755512bbc0fbdfb498d480397a51', '2022-03-04 14:52:38', '2022-04-01 07:30:13'),
(0x11eca6baef5d1616b4811e0c518db576, 'natipop2@yahoo.com', NULL, '$2y$10$o.4qji9wI8QXdgOF74MulONM9VofUoet1d1hcQIpzPXcbQPUHC2tW', 'active', 0x11eca1336cb463d6a07cf21d708e6571, 0, '213394c7cb74df28f61014448a65e37f85e30d6cba599516a9476132937ae5f9', '2022-03-18 12:57:15', '2022-03-31 14:34:52'),
(0x11eca6baf9f14372a5221e0c518db576, 'anonymous29032022182001@dotkernel.com', NULL, '$2y$10$w2I8vro3oN9ZEDt1w8Dg7O/Sj3aVqNYOXdTrgecr/2yNcl18Q/wke', 'pending', 0x11eca1336cb463d6a07cf21d708e6571, 1, 'cf2c434c6975f57385da2f3049ed6666df0fc067dda317b1b6df04df4e2c743f', '2022-03-18 12:57:32', '2022-03-29 15:20:01'),
(0x11eca6bb043ab4c6b2341e0c518db576, 'oniboni@gmail.com', NULL, '$2y$10$lunJAhO6sUFPtfvNo1eEgO5.VM8TTWnj4bpOdOiJMOUfeeb.Qlj6a', 'active', 0x11eca1336cb463d6a07cf21d708e6571, 0, '1735247db482a86e8c78b4de57f9ed6064b4bfdcc1b47fd1a7d9e85d31f25132', '2022-03-18 12:57:50', '2022-03-31 15:09:11'),
(0x11ecaabae0fd913c84af7a4eab80a2a0, 'anonymous31032022173814@dotkernel.com', NULL, '$2y$10$hh3Eza0KT8CYOQ48RgJB9uYrB3Pivrm3fRP3/RgXKVH6JUzD6bRAW', 'pending', 0x11eca1359947f31685ccf21d708e6571, 1, '097d7d48da0fa35a7a5c140b2be18645953c99a17745d4b2aa130202dfdce837', '2022-03-23 15:06:55', '2022-03-31 14:38:14'),
(0x11ecaabafb56f04688c17a4eab80a2a0, 'anonymous31032022175526@dotkernel.com', NULL, '$2y$10$OwNmUDXUNXiC7mJgSMdThuFDdl/bTDRpgHIghtihNxwpi9tlHthtW', 'active', 0x11eca1359947f31685ccf21d708e6571, 1, 'ee1235b5281bbeb6765fc839cb9deb28a08452b687a106c896570bfeed4d301e', '2022-03-23 15:07:39', '2022-03-31 15:08:42'),
(0x11ecaabc87b7ba74b5057a4eab80a2a0, 'anonymous29032022162638@dotkernel.com', NULL, '$2y$10$F5ezhgLy117v9AX7oXssnePBnkjcJPKS3BuTGgOGp7gkTtaC7OHUq', 'pending', 0x11eca13593a1e2aaaac0f21d708e6571, 1, 'cef30a8726853dea8f81d95e3f03203e2152bfbdf474a17272054f14f770002c', '2022-03-23 15:18:44', '2022-03-29 13:26:38'),
(0x11ecab5feec64624903fa2cd9a54727a, 'anonymous31032022181155@dotkernel.com', NULL, '$2y$10$zkjIjj7wW65eWg/1tywywu/L5Z4Bk5z0gvIbEkI91ZE.6/JoLTY1O', 'active', 0x11eca1359947f31685ccf21d708e6571, 1, '72ecd8da2515b24d58d381539405377bd234533e35964b238ec563a1c67432c3', '2022-03-24 10:48:25', '2022-03-31 15:12:47'),
(0x11ecab624a53e0e4bc6ba2cd9a54727a, 'natipo2222@yahoo.com', NULL, '$2y$10$qlhzlf52Qbre3vlvqThpLuGCaeAHKfuBs0oVPLhT67Smqd19o5hOy', 'active', 0x11eca13372be298892ebf21d708e6571, 0, 'a6f763c77241eaa7c81a3368a81275f02b7a70c72eb7b92676d94414e550dcaf', '2022-03-24 11:05:18', '2022-04-01 07:55:00'),
(0x11ecab74cd2851aa9099a2cd9a54727a, 'anonymous30032022171709@dotkernel.com', NULL, '$2y$10$C7eitk1wxWpDzvpmhOFugOfBiikcio6e8UaoeITxxAujSkkKf38nq', 'pending', 0x11eca1359947f31685ccf21d708e6571, 1, '943778191964ca419f26a3b619d07a287596263259477b7fa34d4a73a0a1c9a1', '2022-03-24 13:17:48', '2022-03-30 14:17:09'),
(0x11ecacfbcec3b3fabb34e2bb1f4ef956, 'anonymous29032022162927@dotkernel.com', NULL, '$2y$10$d3uGze0BQ/858k9uq8d6T.j4dSmAhPN1AU5JaNrPbqDPg0rPNHNVa', 'pending', 0x11eca1336cb463d6a07cf21d708e6571, 1, '43cf035ac32916b4ca971e6380a5e07f3d652f18b8ddab3e5e04ff96fc30656e', '2022-03-26 11:56:44', '2022-03-29 13:29:27'),
(0x11ecb1054e5ca3bc96f2ee261e7be780, 'anonymous31032022183747@dotkernel.com', NULL, '$2y$10$FZp6zC0XGNQ8b6tdkf7u2eTMRoy8yBhNd.KgbkEGIEZn2/aLtYaui', 'pending', NULL, 1, 'f6f1c5500e99fd76a08d4031c9f3565980b91c22eb35ae909bda9a49b7b749ca', '2022-03-31 15:14:48', '2022-03-31 15:37:47'),
(0x11ecb10891e1a846a3ccee261e7be780, 'anonymous31032022190418@dotkernel.com', NULL, '$2y$10$xp27Uug9sL5Mu6Vny4cmMOL.X0EMQM2v162BDVW3S9L4TlBb0VL4S', 'pending', 0x11eca13372be298892ebf21d708e6571, 1, 'b47713f345122c2be3d35fe963a0b84084e172cda4045e8599a877fb745ff1af', '2022-03-31 15:38:10', '2022-03-31 16:04:18'),
(0x11ecb1090ca965fa97e9ee261e7be780, 'anonymous31032022184151@dotkernel.com', NULL, '$2y$10$s26Tz9mKWbnIRuUq6Encx.MRhFPFpH52shGaQkO65StggasHi9oQO', 'pending', NULL, 1, 'abf195256fed75924871960abbc3365078d6596534fdfc55039c9ca1debfb298', '2022-03-31 15:41:36', '2022-03-31 15:41:51'),
(0x11ecb10920e8db36801cee261e7be780, 'anonymous31032022185850@dotkernel.com', NULL, '$2y$10$.CPzSLIEg//uQiMJBspanu78aha3WAmIhxC0GoFR5on.RhEIdDc8S', 'pending', 0x11eca1336cb463d6a07cf21d708e6571, 1, '18056bdfe68ef3509df1765f497ece1686a951b54ef5a3981b7a958de206f6f2', '2022-03-31 15:42:10', '2022-03-31 15:58:50'),
(0x11ecb1098ea7d3a2aff0ee261e7be780, 'anonymous31032022184708@dotkernel.com', NULL, '$2y$10$l7oJ4E.ZDOl4vMjfoLFrAuFpqHmfWy4Brbrvn0HdVTldcBO/v2X/S', 'pending', 0x11eca13593a1e2aaaac0f21d708e6571, 1, 'e785b7bb0d4ead440e8e9a44e961cefa26fabbf50944e19c08162f84f37dd29f', '2022-03-31 15:45:14', '2022-03-31 15:47:08'),
(0x11ecb10a7ff550cca27bee261e7be780, 'anonymous31032022185250@dotkernel.com', NULL, '$2y$10$mPgz6E.ET9.dv1RNBKvLHeQl.CFZF94pk63v2.rw1oeqEmozsd3J2', 'pending', 0x11eca1336cb463d6a07cf21d708e6571, 1, '8b5b4d7f9032d9e511b51a6ee9287cbb8109dfa62ad42acde55c6c0fd884f8ee', '2022-03-31 15:51:59', '2022-03-31 15:52:50'),
(0x11ecb10c330e62389d5aee261e7be780, 'anonymous31032022190611@dotkernel.com', NULL, '$2y$10$tfsUThrxk8ejEtsZPDBj/OUyQJh2FPlD9VQLCqyfSUQarciHEksaG', 'pending', 0x11eca13372be298892ebf21d708e6571, 1, 'bdc7a909e76175747661452b814d4cbc1a612ee35e16eecdba86990c5654354a', '2022-03-31 16:04:09', '2022-03-31 16:06:11'),
(0x11ecb10c85387210a500ee261e7be780, 'anonymous31032022191059@dotkernel.com', NULL, '$2y$10$Rq9rEVc8VROBvV.K26GzjOCW4hdtuJn4gBk1z5uwuSVl3Dl9XXnT6', 'pending', 0x11eca1336cb463d6a07cf21d708e6571, 1, '2787ada9cd4c298999b5a6bb424fe3801af3e404b743ddc472cde7c64dde89fc', '2022-03-31 16:06:27', '2022-03-31 16:10:59'),
(0x11ecb10d1b001b548a81ee261e7be780, 'anonymous31032022191142@dotkernel.com', NULL, '$2y$10$2EMAV/oPb4DKRpeSN8Ltp.Io7/kATnSNM5/Y/NWIpIk5EAiu.TtsK', 'pending', 0x11eca1336cb463d6a07cf21d708e6571, 1, '24fc36391b3ec651147ba4abbb0aa931650efb8e13d04281ba7a7493b1caa048', '2022-03-31 16:10:38', '2022-03-31 16:11:42'),
(0x11ecb10d4e7f56988653ee261e7be780, 'anonymous31032022191321@dotkernel.com', NULL, '$2y$10$kNP9LkF0aE0tpm/F07cGHuA3H7o/.Pjx2FPq.XOjtiS0O.MEaxAae', 'pending', 0x11eca1336cb463d6a07cf21d708e6571, 1, '46a45cb2deab150ded8adde426d06ca552b2b1eb2293814bbfc8d7f62f80ae10', '2022-03-31 16:12:05', '2022-03-31 16:13:21'),
(0x11ecb10dc774a51cbc8cee261e7be780, 'anonymous31032022192102@dotkernel.com', NULL, '$2y$10$NJ2gguK5gg/mEt.lMOB0SuwbPCylzt6Egiy3Nl8/sLRYVOhs0TJ/u', 'active', 0x11eca1336cb463d6a07cf21d708e6571, 1, '16dd3a559fccad5c7e19b408e7b0a21b2c1c6b60d8359f257a730319cdbfbba4', '2022-03-31 16:15:27', '2022-03-31 16:21:02'),
(0x11ecb10ebee7237497deee261e7be780, 'anonymous31032022194016@dotkernel.com', NULL, '$2y$10$em0r8/LIR4QoRRdU7ttJUempSEpOmltLE.Rs/UGvrTtxO496Pfnfm', 'pending', 0x11eca1336cb463d6a07cf21d708e6571, 1, 'f193a6b3ab4434cd6d993d660c9a85072ee5acdb871d1333c5002301adaf8764', '2022-03-31 16:22:23', '2022-03-31 16:40:16'),
(0x11ecb10edafe1914af1cee261e7be780, 'anonymous31032022192353@dotkernel.com', NULL, '$2y$10$HiU3unIe7NipHi6MS3XRF.Y1mmFdEIYhKRnc9HOK0jwam5QtoL.mG', 'active', 0x11eca1336cb463d6a07cf21d708e6571, 1, '4dc7d3ab153faac4b959d019c758b96f07fd4d9e92c42112e3c8a0b0fe077dcf', '2022-03-31 16:23:10', '2022-03-31 16:23:53'),
(0x11ecb18e17bcc88a97d7de0f01a70bdd, 'anonymous01042022105442@dotkernel.com', NULL, '$2y$10$sA6U9wKXZKTkJlla6ZPnceSB8kUsN1FLCdjZ.lSvoo5RjFOKlaKgi', 'active', 0x11eca1336cb463d6a07cf21d708e6571, 1, '2ae95496f18e791b795b89b6aa9b9d9781185e5e094047e427bac08b0db2ad06', '2022-04-01 07:33:58', '2022-04-01 07:54:42'),
(0x11ecb18e720da0de8c2fde0f01a70bdd, 'anonymous01042022103641@dotkernel.com', NULL, '$2y$10$WRodhutPHhQfo0xtKdoFR../U1DlQ3md8meu4p/Mn8ejlH0mQJshu', 'pending', 0x11eca1336cb463d6a07cf21d708e6571, 1, '789a7f7ee2ca70014ba1b632de9f4da22a697661c53b2fd647fa903b058db140', '2022-04-01 07:36:29', '2022-04-01 07:36:41'),
(0x11ecb1912d0dab34bebfde0f01a70bdd, 'asdasdasd@gmail.com', NULL, '$2y$10$hfG8v4ddOKAnhsMoB3sfbORUsxxgUK.QEfxNVKBxLfvzNCu00sh2S', 'active', 0x11eca13372be298892ebf21d708e6571, 0, '2a3ed4a4119c95331959d45902b2cf4efbddd7cb21cc563988596ba3ff86ce47', '2022-04-01 07:56:02', '2022-04-01 07:59:56');

-- --------------------------------------------------------

--
-- Table structure for table `user_avatar`
--

CREATE TABLE `user_avatar` (
  `uuid` binary(16) NOT NULL,
  `userUuid` binary(16) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_avatar`
--

INSERT INTO `user_avatar` (`uuid`, `userUuid`, `name`, `created`, `updated`) VALUES
(0x11ec9e1d85b7ec5e8b15de8fe84e45b7, 0x11ec9bcabc50431a9648d25807c60349, 'avatar-85b7bcde-9e1d-11ec-8aee-de8fe84e45b7.jpg', '2022-03-07 13:50:17', '2022-03-07 13:50:17'),
(0x11ecb0ffb204c3288307ee261e7be780, 0x11eca6baef5d1616b4811e0c518db576, 'avatar-b20463f6-b0ff-11ec-bc9e-ee261e7be780.jpg', '2022-03-31 14:34:39', '2022-03-31 14:34:39');

-- --------------------------------------------------------

--
-- Table structure for table `user_detail`
--

CREATE TABLE `user_detail` (
  `uuid` binary(16) NOT NULL,
  `userUuid` binary(16) NOT NULL,
  `firstName` varchar(255) DEFAULT NULL,
  `lastName` varchar(255) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_detail`
--

INSERT INTO `user_detail` (`uuid`, `userUuid`, `firstName`, `lastName`, `created`, `updated`) VALUES
(0x11ec9bcabc54e7a884bdd25807c60349, 0x11ec9bcabc50431a9648d25807c60349, 'Natanael', 'Pop', '2022-03-04 14:52:38', '2022-03-04 14:52:38'),
(0x11eca6baef5d2d689d511e0c518db576, 0x11eca6baef5d1616b4811e0c518db576, 'nat', 'pop', '2022-03-18 12:57:15', '2022-03-31 14:34:15'),
(0x11eca6baf9f1696aba621e0c518db576, 0x11eca6baf9f14372a5221e0c518db576, 'anonymous29032022182001', 'anonymous29032022182001', '2022-03-18 12:57:32', '2022-03-29 15:20:01'),
(0x11eca6bb043ad1eaa5601e0c518db576, 0x11eca6bb043ab4c6b2341e0c518db576, 'onii', 'boni', '2022-03-18 12:57:50', '2022-03-19 10:31:18'),
(0x11ecaabae0fdaa14a1587a4eab80a2a0, 0x11ecaabae0fd913c84af7a4eab80a2a0, 'anonymous31032022173814', 'anonymous31032022173814', '2022-03-23 15:06:55', '2022-03-31 14:38:14'),
(0x11ecaabafb57101cb52d7a4eab80a2a0, 0x11ecaabafb56f04688c17a4eab80a2a0, 'anonymous31032022175526', 'anonymous31032022175526', '2022-03-23 15:07:39', '2022-03-31 14:55:26'),
(0x11ecaabc87b7d3a69d287a4eab80a2a0, 0x11ecaabc87b7ba74b5057a4eab80a2a0, 'anonymous29032022162638', 'anonymous29032022162638', '2022-03-23 15:18:44', '2022-03-29 13:26:38'),
(0x11ecab5feec66afa8255a2cd9a54727a, 0x11ecab5feec64624903fa2cd9a54727a, 'anonymous31032022181155', 'anonymous31032022181155', '2022-03-24 10:48:25', '2022-03-31 15:11:55'),
(0x11ecab624a540d769e2ea2cd9a54727a, 0x11ecab624a53e0e4bc6ba2cd9a54727a, 'asd', '123', '2022-03-24 11:05:18', '2022-03-24 11:05:18'),
(0x11ecab74cd285f4c90b1a2cd9a54727a, 0x11ecab74cd2851aa9099a2cd9a54727a, 'anonymous30032022171709', 'anonymous30032022171709', '2022-03-24 13:17:48', '2022-03-30 14:17:09'),
(0x11ecab75bfa8ea66b5e5a2cd9a54727a, 0x11ecab75bfa8dd789256a2cd9a54727a, 'anonymous29032022154726', 'anonymous29032022154726', '2022-03-24 13:24:35', '2022-03-29 12:47:26'),
(0x11ecac2e47863f84a4a59a962322c76e, 0x11ecac2e47863228a6039a962322c76e, 'anonymous29032022154753', 'anonymous29032022154753', '2022-03-25 11:25:31', '2022-03-29 12:47:53'),
(0x11ecacfbcec3c084aeefe2bb1f4ef956, 0x11ecacfbcec3b3fabb34e2bb1f4ef956, 'anonymous29032022162927', 'anonymous29032022162927', '2022-03-26 11:56:44', '2022-03-29 13:29:27'),
(0x11ecae9134dd4ca09b8506b048acd589, 0x11ecae9134dd400c8ba006b048acd589, 'anonymous29032022154041', 'anonymous29032022154041', '2022-03-28 12:18:42', '2022-03-29 12:40:41'),
(0x11ecb1054e5cbadca3eaee261e7be780, 0x11ecb1054e5ca3bc96f2ee261e7be780, 'anonymous31032022183747', 'anonymous31032022183747', '2022-03-31 15:14:48', '2022-03-31 15:37:47'),
(0x11ecb10891e1c2a4ab9fee261e7be780, 0x11ecb10891e1a846a3ccee261e7be780, 'anonymous31032022190418', 'anonymous31032022190418', '2022-03-31 15:38:10', '2022-03-31 16:04:18'),
(0x11ecb1090ca97d7e9e4dee261e7be780, 0x11ecb1090ca965fa97e9ee261e7be780, 'anonymous31032022184151', 'anonymous31032022184151', '2022-03-31 15:41:36', '2022-03-31 15:41:51'),
(0x11ecb10920e8f2d8a9ccee261e7be780, 0x11ecb10920e8db36801cee261e7be780, 'anonymous31032022185850', 'anonymous31032022185850', '2022-03-31 15:42:10', '2022-03-31 15:58:50'),
(0x11ecb1098ea7eb449c07ee261e7be780, 0x11ecb1098ea7d3a2aff0ee261e7be780, 'anonymous31032022184708', 'anonymous31032022184708', '2022-03-31 15:45:14', '2022-03-31 15:47:08'),
(0x11ecb10a7ff5671a95a0ee261e7be780, 0x11ecb10a7ff550cca27bee261e7be780, 'anonymous31032022185250', 'anonymous31032022185250', '2022-03-31 15:51:59', '2022-03-31 15:52:50'),
(0x11ecb10c330e7c1ea5edee261e7be780, 0x11ecb10c330e62389d5aee261e7be780, 'anonymous31032022190611', 'anonymous31032022190611', '2022-03-31 16:04:09', '2022-03-31 16:06:11'),
(0x11ecb10c85388d7283d9ee261e7be780, 0x11ecb10c85387210a500ee261e7be780, 'anonymous31032022191059', 'anonymous31032022191059', '2022-03-31 16:06:27', '2022-03-31 16:10:59'),
(0x11ecb10d1b00367098faee261e7be780, 0x11ecb10d1b001b548a81ee261e7be780, 'anonymous31032022191142', 'anonymous31032022191142', '2022-03-31 16:10:38', '2022-03-31 16:11:42'),
(0x11ecb10d4e7f7588bb6fee261e7be780, 0x11ecb10d4e7f56988653ee261e7be780, 'anonymous31032022191321', 'anonymous31032022191321', '2022-03-31 16:12:05', '2022-03-31 16:13:21'),
(0x11ecb10dc776b294ba4cee261e7be780, 0x11ecb10dc774a51cbc8cee261e7be780, 'anonymous31032022192102', 'anonymous31032022192102', '2022-03-31 16:15:28', '2022-03-31 16:21:02'),
(0x11ecb10ebee73166a736ee261e7be780, 0x11ecb10ebee7237497deee261e7be780, 'anonymous31032022194016', 'anonymous31032022194016', '2022-03-31 16:22:23', '2022-03-31 16:40:16'),
(0x11ecb10edaffbee08198ee261e7be780, 0x11ecb10edafe1914af1cee261e7be780, 'anonymous31032022192353', 'anonymous31032022192353', '2022-03-31 16:23:10', '2022-03-31 16:23:53'),
(0x11ecb18e17bd1edea045de0f01a70bdd, 0x11ecb18e17bcc88a97d7de0f01a70bdd, 'anonymous01042022105442', 'anonymous01042022105442', '2022-04-01 07:33:58', '2022-04-01 07:54:42'),
(0x11ecb18e720db01a8cd1de0f01a70bdd, 0x11ecb18e720da0de8c2fde0f01a70bdd, 'anonymous01042022103641', 'anonymous01042022103641', '2022-04-01 07:36:29', '2022-04-01 07:36:41'),
(0x11ecb1912d0db93ab408de0f01a70bdd, 0x11ecb1912d0dab34bebfde0f01a70bdd, 'nat', 'a', '2022-04-01 07:56:02', '2022-04-01 07:56:02');

-- --------------------------------------------------------

--
-- Table structure for table `user_reset_password`
--

CREATE TABLE `user_reset_password` (
  `uuid` binary(16) NOT NULL,
  `userUuid` binary(16) DEFAULT NULL,
  `hash` varchar(100) NOT NULL,
  `status` enum('completed','requested') NOT NULL DEFAULT 'requested',
  `expires` timestamp NULL DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `uuid` binary(16) NOT NULL,
  `name` varchar(150) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`uuid`, `name`, `created`, `updated`) VALUES
(0x11eaf2a3d994f820b7ee001aa006c7d1, 'admin', '2020-09-09 13:53:33', NULL),
(0x11eaf2a3d995e5aa9788001aa006c7d1, 'user', '2020-09-09 13:53:33', NULL),
(0x11eaf2a3d995e78a83c0001aa006c7d1, 'guest', '2020-09-09 13:53:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `userUuid` binary(16) NOT NULL,
  `roleUuid` binary(16) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`userUuid`, `roleUuid`, `created`, `updated`) VALUES
(0x11ec9bcabc50431a9648d25807c60349, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-04-01 07:30:13', NULL),
(0x11eca6baef5d1616b4811e0c518db576, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-03-30 13:25:39', NULL),
(0x11eca6baf9f14372a5221e0c518db576, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-03-24 13:15:15', NULL),
(0x11eca6bb043ab4c6b2341e0c518db576, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-03-31 15:09:11', NULL),
(0x11ecaabae0fd913c84af7a4eab80a2a0, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-03-26 10:55:05', NULL),
(0x11ecaabafb56f04688c17a4eab80a2a0, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-03-26 10:54:37', NULL),
(0x11ecaabc87b7ba74b5057a4eab80a2a0, 0x11eaf2a3d994f820b7ee001aa006c7d1, '2022-03-24 13:16:42', NULL),
(0x11ecaabc87b7ba74b5057a4eab80a2a0, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-03-24 13:16:42', NULL),
(0x11ecaabc87b7ba74b5057a4eab80a2a0, 0x11eaf2a3d995e78a83c0001aa006c7d1, '2022-03-24 13:16:42', NULL),
(0x11ecab5feec64624903fa2cd9a54727a, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-03-24 13:16:16', NULL),
(0x11ecab624a53e0e4bc6ba2cd9a54727a, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-04-01 07:55:00', NULL),
(0x11ecab74cd2851aa9099a2cd9a54727a, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-03-30 14:15:10', NULL),
(0x11ecab75bfa8dd789256a2cd9a54727a, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-03-28 12:14:33', NULL),
(0x11ecac2e47863228a6039a962322c76e, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-03-26 11:19:54', NULL),
(0x11ecacfbcec3b3fabb34e2bb1f4ef956, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-03-29 13:21:30', NULL),
(0x11ecae9134dd400c8ba006b048acd589, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-03-29 05:22:43', NULL),
(0x11ecb1054e5ca3bc96f2ee261e7be780, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-03-31 15:14:48', NULL),
(0x11ecb10891e1a846a3ccee261e7be780, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-03-31 15:40:36', NULL),
(0x11ecb1090ca965fa97e9ee261e7be780, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-03-31 15:41:36', NULL),
(0x11ecb10920e8db36801cee261e7be780, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-03-31 15:43:02', NULL),
(0x11ecb1098ea7d3a2aff0ee261e7be780, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-03-31 15:46:06', NULL),
(0x11ecb10a7ff550cca27bee261e7be780, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-03-31 15:52:28', NULL),
(0x11ecb10c330e62389d5aee261e7be780, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-03-31 16:05:34', NULL),
(0x11ecb10c85387210a500ee261e7be780, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-03-31 16:06:46', NULL),
(0x11ecb10d1b001b548a81ee261e7be780, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-03-31 16:11:07', NULL),
(0x11ecb10d4e7f56988653ee261e7be780, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-03-31 16:12:24', NULL),
(0x11ecb10dc774a51cbc8cee261e7be780, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-03-31 16:20:39', NULL),
(0x11ecb10ebee7237497deee261e7be780, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-03-31 16:38:33', NULL),
(0x11ecb10edafe1914af1cee261e7be780, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-03-31 16:23:23', NULL),
(0x11ecb18e17bcc88a97d7de0f01a70bdd, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-04-01 07:37:09', NULL),
(0x11ecb18e720da0de8c2fde0f01a70bdd, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-04-01 07:36:29', NULL),
(0x11ecb1912d0dab34bebfde0f01a70bdd, 0x11eaf2a3d995e5aa9788001aa006c7d1, '2022-04-01 07:59:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `uuid` binary(16) NOT NULL,
  `userUuid` binary(16) NOT NULL,
  `value` text NOT NULL,
  `expireAt` datetime NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `year`
--

CREATE TABLE `year` (
  `uuid` binary(16) NOT NULL,
  `year` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('active','deleted') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `year`
--

INSERT INTO `year` (`uuid`, `year`, `status`, `created`, `updated`) VALUES
(0x11eca1336cb463d6a07cf21d708e6571, '2', 'active', '2022-03-16 14:59:20', '2022-03-26 10:55:48'),
(0x11eca13372be298892ebf21d708e6571, '1', 'active', '2022-03-11 12:47:40', '2022-03-30 08:04:18'),
(0x11eca13593a1e2aaaac0f21d708e6571, '4', 'active', '2022-03-23 15:31:38', NULL),
(0x11eca1359947f31685ccf21d708e6571, '3', 'active', '2022-03-23 15:27:37', '2022-03-23 15:29:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `identity` (`identity`);

--
-- Indexes for table `admin_role`
--
ALTER TABLE `admin_role`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `admin_roles`
--
ALTER TABLE `admin_roles`
  ADD PRIMARY KEY (`userUuid`,`roleUuid`),
  ADD KEY `roleUuid` (`roleUuid`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `name` (`name`),
  ADD KEY `class_ibfk_1` (`year`),
  ADD KEY `name_2` (`name`);

--
-- Indexes for table `contact_message`
--
ALTER TABLE `contact_message`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `grade`
--
ALTER TABLE `grade`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `grade_ibfk_1` (`studentId`),
  ADD KEY `classId` (`classId`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `students_class`
--
ALTER TABLE `students_class`
  ADD UNIQUE KEY `student_class` (`class_uuid`,`student_uuid`),
  ADD KEY `student_uuid` (`student_uuid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `identity` (`identity`),
  ADD KEY `year` (`year`);

--
-- Indexes for table `user_avatar`
--
ALTER TABLE `user_avatar`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `userUuid` (`userUuid`);

--
-- Indexes for table `user_detail`
--
ALTER TABLE `user_detail`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `userUuid` (`userUuid`);

--
-- Indexes for table `user_reset_password`
--
ALTER TABLE `user_reset_password`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `hash` (`hash`),
  ADD KEY `userUuid` (`userUuid`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`userUuid`,`roleUuid`),
  ADD KEY `roleUuid` (`roleUuid`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `userUuid` (`userUuid`);

--
-- Indexes for table `year`
--
ALTER TABLE `year`
  ADD PRIMARY KEY (`uuid`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_roles`
--
ALTER TABLE `admin_roles`
  ADD CONSTRAINT `admin_roles_ibfk_1` FOREIGN KEY (`userUuid`) REFERENCES `admin` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `admin_roles_ibfk_2` FOREIGN KEY (`roleUuid`) REFERENCES `admin_role` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `class_ibfk_1` FOREIGN KEY (`year`) REFERENCES `year` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `grade`
--
ALTER TABLE `grade`
  ADD CONSTRAINT `grade_ibfk_1` FOREIGN KEY (`studentId`) REFERENCES `user` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `grade_ibfk_2` FOREIGN KEY (`classId`) REFERENCES `class` (`uuid`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `students_class`
--
ALTER TABLE `students_class`
  ADD CONSTRAINT `students_class_ibfk_1` FOREIGN KEY (`student_uuid`) REFERENCES `user` (`uuid`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `students_class_ibfk_2` FOREIGN KEY (`class_uuid`) REFERENCES `class` (`uuid`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`year`) REFERENCES `year` (`uuid`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `user_avatar`
--
ALTER TABLE `user_avatar`
  ADD CONSTRAINT `user_avatar_ibfk_1` FOREIGN KEY (`userUuid`) REFERENCES `user` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_detail`
--
ALTER TABLE `user_detail`
  ADD CONSTRAINT `user_detail_ibfk_1` FOREIGN KEY (`userUuid`) REFERENCES `user` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_reset_password`
--
ALTER TABLE `user_reset_password`
  ADD CONSTRAINT `user_reset_password_ibfk_1` FOREIGN KEY (`userUuid`) REFERENCES `user` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`userUuid`) REFERENCES `user` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`roleUuid`) REFERENCES `user_role` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_token`
--
ALTER TABLE `user_token`
  ADD CONSTRAINT `user_token_ibfk_1` FOREIGN KEY (`userUuid`) REFERENCES `user` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
