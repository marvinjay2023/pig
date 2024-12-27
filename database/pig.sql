-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2024 at 04:09 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pig`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `admin_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `email`, `admin_id`) VALUES
(22, 'tine', '8cb2237d0679ca88db6464eac60da96345513964', 'cristinehaylo@gmail.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `breed`
--

CREATE TABLE `breed` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `admin_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `breed`
--

INSERT INTO `breed` (`id`, `name`, `date`, `created_at`, `admin_id`) VALUES
(2, 'Large White pig', NULL, '2024-12-02 02:18:22', 0),
(3, 'American Yorkshire', NULL, '2024-12-02 02:18:33', 0),
(6, 'Landrace pig', NULL, '2024-12-02 02:19:36', 0),
(34, 'Hampshire pig', NULL, '2024-12-15 13:05:32', 22),
(35, 'American Landrace', NULL, '2024-12-15 13:05:39', 22),
(36, 'Piétrain', NULL, '2024-12-15 13:05:47', 22);

-- --------------------------------------------------------

--
-- Table structure for table `pigs`
--

CREATE TABLE `pigs` (
  `weight` decimal(10,2) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `remark` text NOT NULL,
  `breed_id` int(11) NOT NULL,
  `health_status` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `pigno` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `date` date DEFAULT NULL,
  `admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pigs`
--

INSERT INTO `pigs` (`weight`, `gender`, `remark`, `breed_id`, `health_status`, `img`, `pigno`, `is_deleted`, `date`, `admin_id`) VALUES
(70.00, 'male', 'Batik batik', 2, 'active', 'uploadfolder/pig1.png', 2, 1, '2024-12-15', 22),
(60.00, 'male', 'ehdjjds', 5, 'inactive', 'uploadfolder/pig.png', 6, 0, '2024-12-15', 21),
(80.00, 'female', 'dhddh', 5, 'on treatment', 'uploadfolder/pig.png', 8, 0, '2024-12-16', 21),
(55.00, 'male', 'hfghfghh', 34, 'sick', 'uploadfolder/pig1.png', 13, 0, '2024-12-05', 22),
(65.00, 'female', 'taetae', 34, 'sick', 'uploadfolder/images.jfif', 21, 0, '2024-12-17', 22);

-- --------------------------------------------------------

--
-- Table structure for table `quarantine`
--

CREATE TABLE `quarantine` (
  `id` int(11) NOT NULL,
  `pigno` int(255) NOT NULL,
  `date` date NOT NULL,
  `reason` text NOT NULL,
  `breed` varchar(50) NOT NULL,
  `vaccine` varchar(255) NOT NULL,
  `admin_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `quarantine`
--

INSERT INTO `quarantine` (`id`, `pigno`, `date`, `reason`, `breed`, `vaccine`, `admin_id`) VALUES
(38, 9, '2024-12-16', 'sipon', 'Landrace pig', 'CIRCUMVENT CML 50DS', 0),
(37, 10, '2024-12-16', 'Ubo', 'Piétrain', 'd-FENSE PCV2D - 100ML/100DS', 0),
(39, 11, '2024-12-16', 'tatae', 'Hampshire pig', 'Prevacent PRRS 50ds', 0),
(40, 20, '2024-12-17', 'sipon', 'Large White pig', 'CIRCUMVENT CML 50DS', 0),
(41, 21, '2024-12-17', 'UBO', 'Hampshire pig', 'd-FENSE PCV2D - 100ML/100DS', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sensor_data`
--

CREATE TABLE `sensor_data` (
  `id` int(11) NOT NULL,
  `temperature` float NOT NULL,
  `humidity` float NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sold_pigs`
--

CREATE TABLE `sold_pigs` (
  `breed_id` int(11) NOT NULL,
  `pigno` int(11) NOT NULL,
  `weight` float NOT NULL,
  `gender` enum('''Male'', ''Female''','','','') NOT NULL,
  `health_status` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `remark` text NOT NULL,
  `img` varchar(255) NOT NULL,
  `admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sold_pigs`
--

INSERT INTO `sold_pigs` (`breed_id`, `pigno`, `weight`, `gender`, `health_status`, `date`, `remark`, `img`, `admin_id`) VALUES
(34, 0, 70, '', 'inactive', '2024-12-18', 'maluyahon', 'uploadfolder/pig.png', 0),
(35, 12, 50, '', 'on treatment', '2024-12-20', 'maaringasa', 'uploadfolder/pig1.png', 0),
(2, 20, 50, '', 'inactive', '2024-12-17', 'maaringasa', 'uploadfolder/images.jfif', 0);

-- --------------------------------------------------------

--
-- Table structure for table `thermal_data`
--

CREATE TABLE `thermal_data` (
  `id` int(11) NOT NULL,
  `temperature` double NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `week1_data`
--

CREATE TABLE `week1_data` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `pigs_added` int(11) NOT NULL,
  `vaccine_given` int(11) NOT NULL,
  `pigs_quarantined` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `week2_data`
--

CREATE TABLE `week2_data` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `pigs_added` int(11) NOT NULL,
  `vaccine_given` int(11) NOT NULL,
  `pigs_quarantined` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `week3_data`
--

CREATE TABLE `week3_data` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `pigs_added` int(11) NOT NULL,
  `vaccine_given` int(11) NOT NULL,
  `pigs_quarantined` int(11) NOT NULL,
  `pigs_sold` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `week4_data`
--

CREATE TABLE `week4_data` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `pigs_added` int(11) NOT NULL,
  `vaccine_given` int(11) NOT NULL,
  `pigs_quarantined` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `breed`
--
ALTER TABLE `breed`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pigs`
--
ALTER TABLE `pigs`
  ADD PRIMARY KEY (`pigno`);

--
-- Indexes for table `quarantine`
--
ALTER TABLE `quarantine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sensor_data`
--
ALTER TABLE `sensor_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sold_pigs`
--
ALTER TABLE `sold_pigs`
  ADD PRIMARY KEY (`pigno`);

--
-- Indexes for table `thermal_data`
--
ALTER TABLE `thermal_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `week1_data`
--
ALTER TABLE `week1_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `week2_data`
--
ALTER TABLE `week2_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `week3_data`
--
ALTER TABLE `week3_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `week4_data`
--
ALTER TABLE `week4_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `breed`
--
ALTER TABLE `breed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `pigs`
--
ALTER TABLE `pigs`
  MODIFY `pigno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=441;

--
-- AUTO_INCREMENT for table `quarantine`
--
ALTER TABLE `quarantine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `sensor_data`
--
ALTER TABLE `sensor_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1022;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
