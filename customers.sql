-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 09, 2024 at 06:58 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mydata`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `data_id` int(11) NOT NULL,
  `business_type` varchar(255) DEFAULT NULL,
  `business_name` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `contact_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `line_id` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `emp_user` varchar(255) DEFAULT NULL,
  `emp_pass` varchar(255) DEFAULT NULL,
  `emp_level` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`data_id`, `business_type`, `business_name`, `company_name`, `contact_name`, `email`, `phone`, `line_id`, `facebook`, `province`, `emp_user`, `emp_pass`, `emp_level`) VALUES
(1, 'โรงแรม', 'bigfloppa', 'pumba', 'kogo', 'newtime337u@gmail.com', '1043943252', 'gosha', 'tofoyy', 'ชลบุรี', NULL, NULL, NULL),
(2, '\\\"$value\\\"', 'gogo', 'pumba', 'kogo', 'zulost47@gmail.com', '0102938434', 'GSSSSS', 'aaaaaaadsfsd', '<?php echo $province; ?>', NULL, NULL, NULL),
(3, 'เกสต์เฮาส์', 'bigfloppa1', 'pumba1', 'kogo1', 'newtime1337u@gmail.com', '1043943252', 'gosha1', 'tofoyy1', 'นครนายก', NULL, NULL, NULL),
(4, 'เกสต์เฮาส์', 'bigfloppa1', 'pumba1', 'kogo1', 'Meaksung2003@gmail.com', '3245678903', 'gosha1', 'tofoyy1', 'นครนายก', NULL, NULL, NULL),
(5, 'เกสต์เฮาส์', 'bigfloppa1', 'pumba1', 'kogo1', 'lkjhgf2@oifu.com', '3245678903', 'gosha1', 'tofoyy1', 'นครนายก', NULL, NULL, NULL),
(6, 'อพาร์ทเมนต์', 'bigfloppa17', 'pumba17', 'kogo17', 'floppakerr1017@gmail.com', '0644200443', 'gosha7', 'tofoyy1114', 'นครนายก', NULL, NULL, NULL),
(7, 'อพาร์ทเมนต์', 'bigfloppa17', 'pumba17', 'kogo17', 'floppakerr1017@gmail.com', '0644200443', 'gosha7', 'tofoyy1114', 'นครนายก', NULL, NULL, NULL),
(8, 'โคซี่โฮเต็ล', 'ปืนใหญ่', 'ปืนเกมมิ่ง', 'ปืน1234', 'gun1234@gmail.com', '1234123410', 'gosha123', 'tofo1234', 'ตาก', NULL, NULL, NULL),
(9, 'โคซี่โฮเต็ล', 'ปืนใหญ่', 'ปืนเกมมิ่ง', 'ปืน1234', 'gun1234@gmail.com', '1234123410', 'gosha123', 'tofo1234', 'ตาก', NULL, NULL, NULL),
(10, 'เซอร์วิสอพาร์ทเมนต์', 'มีด', 'มีดจำกัด', 'มาลี', 'malee243@gmail.com', '0641234567', 'maleesuperkick', 'maleesuperkicker', 'อุดรธานี', NULL, NULL, NULL),
(11, 'เซอร์วิสอพาร์ทเมนต์', 'มีด', 'มีดจำกัด', 'มาลี', 'malee243@gmail.com', '0641234567', 'maleesuperkick', 'maleesuperkicker', 'อุดรธานี', NULL, NULL, NULL),
(12, 'อพาร์ทเมนต์', 'กหฟกดเ้', 'หฏฤโฌ็๋ษศ๋', 'ฤฆฏฏโฌ็๋ษศ', 'floppakerr202@gmail.com', '1111111123', 'gosha2345678', 'aaaaaaadsfsd234567', 'นครพนม', NULL, NULL, NULL),
(14, 'บังกะโล', 'โบกาลัง', 'fffffffkkkkkkk', 'yoyoyoyo', 'johocena22@gmail.com', '4567845612', 'wewrtyui', 'qwertyui', 'สระแก้ว', NULL, NULL, NULL),
(15, 'โคซี่โฮเต็ล', 'โบกาลัง', 'fffffffkkkkkkk', 'yoyoyoyo', 'johocena22@gmail.com', '4567845612', 'wewrtyui', 'qwertyui', 'นครนายก', NULL, NULL, NULL),
(16, 'โรงแรมระดับสี่ดาว', 'cvxbnm', 'xczvbvnm', 'xzcvbn', 'cxvbxzcvb2345@gmail.com', '9867654564', 'fgdhfgjh', 'lkkkjkiujk', 'นครนายก', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`data_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `data_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
