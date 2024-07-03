-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2024 at 06:20 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_irreg_stud_advicing`
--

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` int(11) NOT NULL,
  `studentName` varchar(255) NOT NULL,
  `studentNumber` varchar(50) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `deadline` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `studentName`, `studentNumber`, `file_path`, `deadline`) VALUES
(1, '', '1001', '../uploads/Screenshot 2023-12-17 220129.png', '2024-01-31 04:41:00'),
(2, '', '1001', '../uploads/Screenshot 2023-12-17 220129.png', '2024-01-31 04:41:00'),
(3, '', '1001', '../uploads/Screenshot 2023-12-17 220129.png', '2024-01-31 04:41:00'),
(6, '', '123', '../uploads/herring.jpg', NULL),
(7, '', '123', '../uploads/herring.jpg', NULL),
(8, '', '123', '../uploads/herring.jpg', NULL),
(9, '', '123', '../uploads/herring.jpg', NULL),
(10, '', '123', '../uploads/COM-SHARE-ARCHI-DESIGN.pdf', NULL),
(11, '', '', '../uploads/COM-SHARE-ARCHI-DESIGN.pdf', NULL),
(12, '', '123', '../uploads/COM-SHARE-ARCHI-DESIGN.pdf', NULL),
(13, '', '123', '../uploads/image1.png', NULL),
(14, '', '123', '../uploads/image1.png', NULL),
(15, '', '123', '../uploads/image1.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `registration adviser`
--

CREATE TABLE `registration adviser` (
  `ID` int(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `verification_code` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration adviser`
--

INSERT INTO `registration adviser` (`ID`, `username`, `password`, `email`, `verification_code`) VALUES
(1, 'Miss John Doe', '$2y$10$a/GfLiCOSg.rAApOh07RhOdq7M9CkYt5rqMIfqth2SMGOPL59XXX2', '123', 0),
(2, 'Miss John Doe5', '$2y$10$8X81KG13XJ9vNlJEeKdg2.JfzRKmqDzb0oYWbrv9suF8xUsNlOtYm', '123', 0),
(3, '1234', '$2y$10$YE/BUspC/DzOXBivfVHu5OfPag3N2xxCxsXThyLt8po8EnG.KVo0m', '1234', 0);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `studNum` varchar(50) NOT NULL,
  `Year` int(10) NOT NULL,
  `adviser` text NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `verification_code` int(100) NOT NULL,
  `Course` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`studNum`, `Year`, `adviser`, `password`, `email`, `name`, `verification_code`, `Course`) VALUES
('100', 1, '', '$2y$10$.O604Lanxvla216bj98SauPZ2bPd0ca5gA9WMesrRjd8evjNLBQXu', 'doe@gmail.com', 'Jason Tatu', 0, 'BSCS'),
('1001', 1, '', '$2y$10$UEUByDyp5sRjUK7rBFuKM./P3S670eaNCpGvtfFkHR1', 'hello@gmail.com', '', 0, ''),
('1002', 1, 'Miss John Doe', '$2y$10$w.BdRyFea7uQ7aaHSgkSN.WRqrDX4eY.CUGkzS0tnxS', 'hello@gmail.com', '', 0, ''),
('1003', 1, 'Miss John Doe', '$2y$10$y9scmoHmchuKPzpyFfnqiuJUgzYKBeIwWb1PFX8Y0fr', 'hello@gmail.com', '', 0, ''),
('1004', 2, '', '$2y$10$j/VFZ.Z9dajDwn/NFsMF2.gUhsycnOStSp0JJPBqpUo', 'hello@gmail.com', 'John Doe', 0, ''),
('1009', 1, '', '$2y$10$g5htIK1cTHJKhTbz0NwclOGLjZ/wiLychuP7fBAfiwW', '123', '123', 0, ''),
('1100', 1, '', '$2y$10$S7G.h6Q/prWKUAnRgHXPk.CxGI9ngZ1umVQ7ev57jCF8pJ00QY0Im', '123', '123', 0, ''),
('123', 2, 'Miss John Doe', '$2y$10$BaNRB173PwMDzPCZ.QkmYuXVcjzGIs2N6vvIoIarw86z.4m0KANJa', 'chanre@gmail.com', '123', 0, 'BSCS'),
('12312', 0, '', '$2y$10$M2NKTqXIsFXG0O/Ut/tnpODH.7JUaLP6w88cEKkZ445tZtWAKHgL.', 'asdawd@gmail.com', 'aijdasd', 0, ''),
('123123', 0, '', '$2y$10$tqO4NCcYDw5u7efUdIdekepg/gP79zfEA85ldPSZvcSAtr/Rv3p8.', 'asdawd@gmail.com', 'Troy123', 0, ''),
('201234123', 0, '', '$2y$10$ObXmekL.Cdl/rt69bT5qSOCNtRxcJ0rPK/W8SeL1/bY/QCpduXGLe', 'world@gmail.com', 'John Doe 2', 0, ''),
('2021', 1, '', '$2y$10$NFvp0JS26.ACr8imJMeuyeQ7v0ALtRHgVoZieu4SaqMrgzaZ8uA3G', '123@gmail.com', '123', 0, ''),
('202101234', 1, '', '$2y$10$kBbwHwZunjJS0Snsa80vmOWPyx5uQPWUEwZ8uX.CnASTZe4A9c/Py', '08chiisanainochi.vaughn21@gmail.com', 'Vivi', 663425, 'BSCS'),
('202103513', 1, '', '$2y$10$ft4g4NdtfC2MVV31frLrGu4j6549Sy0nCZoCMk3tu3tb.8iVmdvGC', 'xyp@gmail.com', 'xyp', 0, ''),
('2021035134', 1, '', '$2y$10$fIC3X71Tf492kvcuJGiTVe9GyW1gbnxVBBgsAMYXYakbHDJG6pFKG', 'xyp@gmail.com', 'xyp', 0, ''),
('202106734', 3, '', '$2y$10$XpQAGdmU4a8onrJtCjWegehf082PVdC7kYeN1RMYcrJfaoAwE2z/a', 'vzsantillan@gmail.com', 'Zoeie', 900173, ''),
('202107413', 3, '', '$2y$10$2ysSgMlafOUtAAUJ5/BU9uIqQkdwpt9eqrsuwnW9biiVXLOV.QwyK', 'jayarlcruzada@gmail.com', 'Jay Ar L. Cruzada', 0, ''),
('2021123123', 0, '', '$2y$10$OreJn18qBXivnVTMBnb84.FqDVwKWeAD000HwKK7qkiDce9PA1v0C', 'jay@gmai.com', 'bob', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subjectCode` varchar(10) NOT NULL,
  `description` varchar(255) NOT NULL,
  `prerequisites` varchar(255) DEFAULT NULL,
  `units` int(10) NOT NULL,
  `Year` int(10) NOT NULL,
  `Course` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subjectCode`, `description`, `prerequisites`, `units`, `Year`, `Course`) VALUES
('COSC 50', 'Discrete Structures', NULL, 3, 2, 'BSCS'),
('COSC 55', 'Discrete Structures 2', 'COSC 50', 3, 2, 'BSCS'),
('COSC 60', 'Digital Logic Design', 'COSC 50, DCIT 23', 3, 2, 'BSCS'),
('COSC 70', 'Software Engineering 1', 'DCIT 50, DCIT 24', 3, 2, 'BSCS'),
('COSC 75', 'Software Engineering 2', 'COSC 70', 3, 3, 'BSCS'),
('COSC 80', 'Operating Systems', 'DCIT 25', 3, 3, 'BSCS'),
('COSC 85', 'Networking and Communication', 'ITEC 25', 3, 3, 'BSCS'),
('COSC101', 'CS Elective 1', 'DCIT 23', 3, 1, 'BSCS'),
('DCIT 21', 'Introduction to Computing', NULL, 3, 1, 'BSCS'),
('DCIT 22', 'Computer Programming 1', NULL, 3, 1, 'BSCS'),
('DCIT 23', 'Computer Programming 2', 'DCIT 22', 3, 1, 'BSCS'),
('DCIT 25', 'Data Structures and Algorithms', 'DCIT 23', 3, 1, 'BSCS'),
('DCIT 26', 'Application Dev\'t and Emerging Technologies', 'ITEC 50', 3, 3, 'BSCS'),
('DCIT 50', 'Object Oriented Programming', 'DCIT 23', 3, 1, 'BSCS'),
('DCIT 55', 'Advanced Database and Management System', 'DCIT 24', 3, 2, 'BSCS'),
('DCIT 65', 'Social and Professional Issues', NULL, 3, 3, 'BSCS'),
('FITT 1', 'Movement Enhancement', NULL, 3, 1, 'BSCS'),
('FITT 2', 'Fitness Exercises', 'FITT 1', 3, 1, 'BSCS'),
('FITT 3', 'Physical Activities towards Health and Fitness 1', 'FITT 1', 3, 2, 'BSCS'),
('FITT 4', 'Physical Activities towards Health and Fitness 2', 'FITT 1', 3, 2, 'BSCS'),
('GNED 01', 'Art Appreciation', NULL, 3, 1, 'BSCS'),
('GNED 02', 'Ethics', NULL, 3, 1, 'BSCS'),
('GNED 03', 'Mathematics in the Modern World', NULL, 3, 1, 'BSCS'),
('GNED 04', 'Mga Babasahin Hinggil sa Kasaysayan ng Pilipinas', NULL, 3, 2, 'BSCS'),
('GNED 05', 'Purposive Communication', NULL, 3, 2, 'BSCS'),
('GNED 06', 'Science, Technology and Society', NULL, 3, 1, 'BSCS'),
('GNED 08', 'Understanding the Self', NULL, 3, 1, 'BSCS'),
('GNED 11', 'Kontesktwalisadong Komunikasyon sa Filipino', NULL, 3, 1, 'BSCS'),
('GNED 12', 'Dalumat ng/Sa Filipino', 'GNED 11', 3, 1, 'BSCS'),
('GNED 14', 'Panitikang Panlipunan', NULL, 3, 2, 'BSCS'),
('INSY50', 'Fundamentals of Information Systems', 'DCIT 21', 3, 1, 'BSCS'),
('ITEC 50', 'Web Systems and Technologies', 'DCIT 21', 3, 1, 'BSCS'),
('MATH 1', 'Analytic Geometry', 'GNED 03', 3, 1, 'BSCS'),
('MATH 2', 'Calculus', 'MATH 1', 3, 2, 'BSCS'),
('MATH 3', 'Linear Algebra', 'MATH 2', 3, 3, 'BSCS'),
('NSTP 1', 'National Service Training Program 1', NULL, 3, 1, 'BSCS'),
('NSTP 2', 'National Service Training Program 2', 'NSTP 1', 3, 1, 'BSCS');

-- --------------------------------------------------------

--
-- Table structure for table `taken_subjects`
--

CREATE TABLE `taken_subjects` (
  `enrollmentID` int(11) NOT NULL,
  `studNum` varchar(50) DEFAULT NULL,
  `subjectCode` varchar(10) DEFAULT NULL,
  `status` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `taken_subjects`
--

INSERT INTO `taken_subjects` (`enrollmentID`, `studNum`, `subjectCode`, `status`) VALUES
(16, '202101234', 'DCIT 21', 'PASSED'),
(25, '123', 'COSC 60', 'FAILED'),
(31, '100', 'DCIT 21', 'PASSED'),
(32, '123', 'DCIT 22', 'PASSED');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `ID` int(11) NOT NULL,
  `Max Units` int(50) NOT NULL,
  `Year` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`ID`, `Max Units`, `Year`) VALUES
(1, 20, 1),
(2, 20, 2),
(3, 20, 3),
(4, 20, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registration adviser`
--
ALTER TABLE `registration adviser`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`studNum`),
  ADD KEY `idx_studNum` (`studNum`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subjectCode`);

--
-- Indexes for table `taken_subjects`
--
ALTER TABLE `taken_subjects`
  ADD PRIMARY KEY (`enrollmentID`),
  ADD KEY `studentNumber` (`studNum`),
  ADD KEY `subjectCode` (`subjectCode`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `registration adviser`
--
ALTER TABLE `registration adviser`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `taken_subjects`
--
ALTER TABLE `taken_subjects`
  MODIFY `enrollmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `taken_subjects`
--
ALTER TABLE `taken_subjects`
  ADD CONSTRAINT `taken_subjects_ibfk_2` FOREIGN KEY (`subjectCode`) REFERENCES `subjects` (`subjectCode`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
