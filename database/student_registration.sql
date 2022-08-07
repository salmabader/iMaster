-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2022 at 01:26 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_registration`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(10) NOT NULL,
  `FName` varchar(10) NOT NULL,
  `LName` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `photo` text NOT NULL DEFAULT 'default_user_img.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `FName`, `LName`, `email`, `password`, `photo`) VALUES
('admin', 'Salma', 'Ahmad', 'salmabader.cs@gmail.com', '$2y$10$k4C61T5G2Xs8VhwzCQtrDO0HJOPiqUQJla/.Pq83iSRwN3GynArLO', 'default_user_img.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `chapter`
--

CREATE TABLE `chapter` (
  `chapterID` int(11) NOT NULL,
  `courseID` int(11) NOT NULL,
  `title` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chapter`
--

INSERT INTO `chapter` (`chapterID`, `courseID`, `title`) VALUES
(1, 10, 'chapter 1'),
(2, 11, 'ch1'),
(3, 12, 'n'),
(4, 13, 'h'),
(5, 14, 'k'),
(6, 15, 'jj'),
(7, 16, 'kk'),
(8, 17, 'kk'),
(9, 18, 'kk'),
(10, 19, 'n'),
(11, 20, 'm'),
(12, 21, 'po'),
(13, 22, 'm'),
(14, 23, 'dm'),
(15, 24, 'mn'),
(16, 25, 'snd'),
(17, 26, 'j'),
(18, 27, 'jk'),
(19, 28, 'NSD'),
(20, 29, 'N'),
(21, 30, 'bn'),
(22, 31, 'sbnd'),
(23, 32, 'djf'),
(24, 33, 'jkjk'),
(25, 34, 'mkjk'),
(26, 35, 'jkdfg'),
(27, 36, 'jk'),
(28, 37, 'djkg'),
(29, 38, 'dfgn'),
(30, 39, 'fjs'),
(31, 40, 'sdkj'),
(32, 41, 'jhf'),
(33, 42, 'sdjk'),
(34, 43, 'n'),
(35, 44, 'sdnm'),
(36, 45, 'mm'),
(37, 46, 'llj'),
(38, 47, 'CH1'),
(39, 47, 'CH2 '),
(40, 48, 'klsakl'),
(41, 49, 'sakld'),
(42, 50, 'mcasd'),
(48, 55, 'CHAPTER 1 '),
(49, 55, 'CHAPTER 2'),
(50, 56, 'sdfjk'),
(51, 57, 'CH 1'),
(52, 57, 'CH 2'),
(53, 58, 'Ch1'),
(54, 58, 'Ch2');

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `contentID` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `video` text NOT NULL,
  `description` text DEFAULT NULL,
  `chapter` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`contentID`, `title`, `video`, `description`, `chapter`) VALUES
(1, 'lesson 1', '', NULL, 1),
(2, 'l1', '', NULL, 2),
(3, 'i', '', NULL, 3),
(4, 'jk', '', NULL, 4),
(5, 'o', '', NULL, 5),
(6, 'mm', '', NULL, 6),
(7, 'mm', '', NULL, 7),
(8, 'nn', '', NULL, 8),
(9, 'nn', '', NULL, 9),
(10, 'm', '', NULL, 10),
(11, 'k', '', NULL, 11),
(12, 'm', '', NULL, 12),
(13, 'k', '', NULL, 13),
(14, 'snm', '', NULL, 14),
(15, 'asdkj', '', NULL, 15),
(16, 'msd', '', NULL, 16),
(17, 'jk', '', NULL, 17),
(18, 'kjdsf', '', NULL, 18),
(19, 'HJDS', '', NULL, 19),
(20, 'J', '', NULL, 20),
(21, 'bn', '', NULL, 21),
(22, 'asndb', '', NULL, 22),
(23, 'jkdsf', '', NULL, 23),
(24, 'jsdkf', '', NULL, 24),
(25, 'jk', '', NULL, 25),
(26, 'fjk', '', NULL, 26),
(27, 'jsdkf', '', NULL, 27),
(28, 'jdkg', '', NULL, 28),
(29, 'dkfgj', '', NULL, 29),
(30, 'jksf', '', NULL, 30),
(31, 'kdlf', '', NULL, 31),
(32, 'jhf', '', NULL, 32),
(33, 'sdjk', '', NULL, 33),
(34, 'm', '', NULL, 34),
(35, 'sdjkf', '', NULL, 35),
(36, 'fk', '', NULL, 36),
(37, 'bn', '', NULL, 37),
(38, 'Less 1', '', NULL, 38),
(39, 'Less 1', '', NULL, 39),
(40, 'Less 2', '', NULL, 39),
(41, 'askdlksklas', '', NULL, 40),
(42, 'lkasd', '', NULL, 41),
(43, 'kdals', '', NULL, 42),
(49, 'LESSON 1-1', 'NEW COURSE_49.mp4', '', 48),
(50, 'LESSON 2-1', 'NEW COURSE_50.mp4', '', 49),
(51, 'LESSON 2-2', 'NEW COURSE_51.png', '', 49),
(52, 'jkdfs', 'NEW COURSE2_52.png', 'sjdkfjksdfjmmmmmmmmm', 50),
(53, 'LESSON 1-1', 'new 1_53.jpg', '', 51),
(54, 'LESSON 2-1', 'new 1_54.jpg', '', 52),
(55, 'LESSON 2-2', 'new 1_55.png', '', 52),
(56, 'lesson1', 'TITLE_56.jpg', '', 53),
(57, 'lesson 1', 'TITLE_57.jpg', '', 54);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `courseID` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `objectives` text NOT NULL,
  `requirements` text NOT NULL,
  `level` int(3) NOT NULL,
  `collaborator` varchar(10) DEFAULT NULL,
  `instructor_usename` varchar(10) NOT NULL,
  `admin_username` varchar(10) DEFAULT NULL,
  `image` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`courseID`, `title`, `category`, `objectives`, `requirements`, `level`, `collaborator`, `instructor_usename`, `admin_username`, `image`, `description`) VALUES
(10, 'title', 'mathematics', 'objectives', 'requirements', 1, 'salma_9', 'salmabader', NULL, 'title_10.png', 'description'),
(11, 'kj', 'marketing', 'njjk', 'jk', 1, '', 'salmabader', NULL, 'kj_11.jpg', 'kj'),
(12, 'kj', 'marketing', 'j', 'hj', 0, '', 'salmabader', NULL, 'kj_12.jpg', 'j'),
(13, 'course title', 'mathematics', 'jk', 'jk', 0, '', 'salmabader', NULL, 'course title_13.jpg', 'mn'),
(14, 'pusher course', 'mathematics', 'n', 'm', 1, '', 'salmabader', NULL, 'pusher course_14.jpg', 'jkjk'),
(15, 'n', 'mathematics', 'sdkj', 'sdkj', 1, '', 'salmabader', NULL, 'n_15.jpg', 'jk'),
(16, 'm', 'business', 'jkf', 'kjfs', 1, '', 'salmabader', NULL, 'm_16.jpg', 'klk'),
(17, 'dnm', 'mathematics', 'sdfkj', 'kjdfs', 0, '', 'salmabader', NULL, 'dnm_17.jpg', 'jkds'),
(18, 'dnm', 'mathematics', 'sdfkj', 'kjdfs', 0, '', 'salmabader', NULL, 'dnm_18.jpg', 'jkds'),
(19, 'jk', 'marketing', 'jk', 'jk', 0, '', 'salmabader', NULL, 'jk_19.jpg', 'mm'),
(20, 'mm', 'mathematics', 'mkjk', 'jkj', 0, '', 'salmabader', NULL, 'mm_20.jpg', 'n'),
(21, 'hi', 'marketing', 'jk', 'sdfjk', 0, '', 'salmabader', NULL, 'hi_21.jpg', 'm'),
(22, 'c++', 'marketing', 'kl', 'sdnf', 2, '', 'salmabader', NULL, 'c++_22.jpg', 'msdf'),
(23, 'HII', 'marketing', 'mmd', 'sdk', 1, '', 'salmabader', NULL, 'HII_23.jpg', 'mn'),
(24, 'mnm', 'marketing', 'sdfjk', 'jksdf', 1, '', 'salmabader', NULL, 'mnm_24.jpg', 'nm'),
(25, 'm', 'marketing', 'dnm', 'masnd', 1, '', 'salmabader', NULL, 'm_25.jpg', 'mnm'),
(26, 'm', 'marketing', 'sds', 'kjsd', 1, '', 'salmabader', NULL, 'm_26.jpg', 'm'),
(27, 'mn', 'mathematics', 'nm', 'nm', 1, '', 'salmabader', NULL, 'mn_27.jpg', 'nnm'),
(28, 'YAY', 'mathematics', 'BNB', 'BN', 1, '', 'salmabader', NULL, 'YAY_28.jpg', 'DSNB'),
(29, 'GG', 'marketing', 'JKF', 'FKJD', 0, '', 'salmabader', NULL, 'GG_29.jpg', 'N'),
(30, 'nkk', 'mathematics', 'nb', 'jh', 0, '', 'salmabader', NULL, 'nkk_30.jpg', 'mn'),
(31, 'nm', 'mathematics', 'nsmd', 'asjdh', 0, '', 'salmabader', NULL, 'nm_31.jpg', 'snbd'),
(32, 'jk', 'programming', 'fkj', 'jkrk', 0, '', 'salmabader', NULL, 'jk_32.jpg', 'nbn'),
(33, 'nfjg', 'mathematics', 'jgkdjk', 'jdskf', 0, '', 'salmabader', NULL, 'nfjg_33.jpg', 'nmdf'),
(34, 'lk', 'mathematics', 'jsdkf', 'ksdf', 1, '', 'salmabader', NULL, 'lk_34.jpg', 'n'),
(35, 'kf', 'programming', 'dfjkg', 'jkd', 0, '', 'salmabader', NULL, 'kf_35.png', 'jk'),
(36, 'OOOH', 'programming', 'jk', 'jksd', 0, '', 'salmabader', NULL, 'OOOH_36.jpg', 'sfj'),
(37, 'last course', 'IT & Software', 'jkg', 'jkgdf', 0, '', 'salmabader', NULL, 'last course_37.jpg', 'jk'),
(38, 'new one', 'mathematics', 'jkfd', 'kjdg', 1, '', 'salmabader', NULL, 'new one_38.jpg', 'jkg'),
(39, 'last', 'marketing', 'jk', 'jk', 1, '', 'salmabader', NULL, 'last_39.jpg', 'jhhj'),
(40, 'j', 'programming', 'dsj', 'dsjkf', 0, '', 'salmabader', NULL, 'j_40.jpg', 'sdfjk'),
(41, 'jh', 'marketing', 'hjd', 'jdf', 1, '', 'salmabader', NULL, 'jh_41.jpg', 'jhdf'),
(42, 'kjsd', 'marketing', 'sjkf', 'jksdf', 1, '', 'salmabader', NULL, 'kjsd_42.jpg', 'sjkf'),
(43, 'testing here', 'mathematics', 'kl', 'jk', 1, '', 'salmabader', NULL, 'testing here_43.jpg', 'mn'),
(44, 'jk', 'marketing', 'sdfk', 'sjdf', 1, '', 'salmabader', NULL, 'jk_44.jpg', 'kjf'),
(45, 'new', 'mathematics', 'jkfg', 'jdkfg', 1, '', 'salmabader', NULL, 'new_45.jpg', 'jk'),
(46, 'ok', 'mathematics', 'kl', 'jk', 1, '', 'salmabader', NULL, 'ok_46.jpg', 'jk'),
(47, 'good', 'business', 'kjk', 'sjk', 0, '', 'salmabader', NULL, 'good_47.jpg', 'this is course description'),
(48, 'dnm', 'marketing', 'sa,m', 'skad', 1, '', 'salmabader', NULL, 'dnm_48.jpg', 'ksalkldsakld'),
(49, 'sam', 'IT & Software', 'jkasd', 'askjd', 1, '', 'salmabader', NULL, 'sam_49.jpg', 'asd'),
(50, 'sdjkf', 'mathematics', 'djkfs', 'jdskf', 1, '', 'salmabader', NULL, 'sdjkf_50.jpg', 'samd'),
(55, 'NEW COURSE', 'marketing', 'OBJECTIVES', 'REQUIREMENTS', 1, '', 'salmabader', NULL, 'NEW COURSE_55.jpg', 'DESCRIPTION'),
(56, 'NEW COURSE2', 'mathematics', 'dfkfj', 'jdkfjkds', 1, 'fahad', 'salmabader', NULL, 'NEW COURSE2_56.jpg', 'skjfkjjskd'),
(57, 'new 1', 'marketing', 'OBJECTIVES HERE', 'REQUIREMENTS HERE', 2, '', 'salmabader', NULL, 'new 1_57.jpg', 'DESCRIPTION HERE'),
(58, 'TITLE', 'mathematics', 'jkjk', 'sjdkf', 0, '', 'salmabader', NULL, 'TITLE_58.jpg', 'kkj');

-- --------------------------------------------------------

--
-- Table structure for table `instructor`
--

CREATE TABLE `instructor` (
  `username` varchar(10) NOT NULL,
  `FName` varchar(10) NOT NULL,
  `LName` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `field` varchar(50) NOT NULL,
  `previous_course` text NOT NULL,
  `degree` varchar(50) NOT NULL,
  `experience` varchar(50) NOT NULL,
  `bio` varchar(200) NOT NULL,
  `isAccepted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `instructor`
--

INSERT INTO `instructor` (`username`, `FName`, `LName`, `email`, `password`, `field`, `previous_course`, `degree`, `experience`, `bio`, `isAccepted`) VALUES
('salmabader', 'Salma', 'Bader', 'salma.ccsit@gmail.com', '$2y$10$U3.bYnpPVcwdl3p5uMUksOfDvw5FzZPim6wOa/0caefk5.EKNFn5.', 'programming', '', 'bachelor', '7', 'This is a bio', 1),
('salma_', 'Salma', 'Abdulrahma', 'salma-bader-15@hotmail.com', '$2y$10$W9ZeFoOYrpBde4ZO9FisvO9Vs9xhUtzXQGqD1gwlpyXSTYUn3RBKW', 'mathematics', '', 'bachelor', '4', 'THIS IS BRIEF ABOUT ME', 0);

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `requestID` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `admin_username` varchar(10) DEFAULT NULL,
  `instructor_username` varchar(10) NOT NULL,
  `date` date DEFAULT NULL,
  `reason` text NOT NULL,
  `course_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`requestID`, `type`, `status`, `admin_username`, `instructor_username`, `date`, `reason`, `course_id`) VALUES
(66, 'course', 'waiting', NULL, 'salmabader', '2022-08-07', '', 57),
(67, 'application', 'waiting', NULL, 'salma_', '2022-08-07', '', NULL),
(68, 'course', 'accepted', 'admin', 'salmabader', '2022-08-07', '', 58);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `username` varchar(10) NOT NULL,
  `FName` varchar(10) NOT NULL,
  `LName` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`username`, `FName`, `LName`, `email`, `password`) VALUES
('_noor', 'Noor', 'Ali', 'noor@gmail.com', '$2y$10$SwA0cn/zvXKyQkmJXVyhf.REdxAcX3UX2yObvxj/oCP8.x9kt/10a');

-- --------------------------------------------------------

--
-- Table structure for table `student_course`
--

CREATE TABLE `student_course` (
  `stu_username` varchar(10) NOT NULL,
  `coID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student_favorite`
--

CREATE TABLE `student_favorite` (
  `course_id` int(11) NOT NULL,
  `stu_username` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student_interests`
--

CREATE TABLE `student_interests` (
  `interests` varchar(50) NOT NULL,
  `student_username` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_interests`
--

INSERT INTO `student_interests` (`interests`, `student_username`) VALUES
('IT & Software', '_noor'),
('programming', '_noor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `chapter`
--
ALTER TABLE `chapter`
  ADD PRIMARY KEY (`chapterID`),
  ADD KEY `courseID` (`courseID`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`contentID`),
  ADD KEY `chapter` (`chapter`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`courseID`),
  ADD KEY `instructor_usename` (`instructor_usename`,`admin_username`),
  ADD KEY `admin_username` (`admin_username`);

--
-- Indexes for table `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`requestID`),
  ADD KEY `admin_username` (`admin_username`,`instructor_username`),
  ADD KEY `instructor_username` (`instructor_username`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `student_course`
--
ALTER TABLE `student_course`
  ADD PRIMARY KEY (`stu_username`,`coID`),
  ADD KEY `courseID` (`coID`);

--
-- Indexes for table `student_favorite`
--
ALTER TABLE `student_favorite`
  ADD PRIMARY KEY (`course_id`,`stu_username`),
  ADD KEY `stu_username` (`stu_username`);

--
-- Indexes for table `student_interests`
--
ALTER TABLE `student_interests`
  ADD PRIMARY KEY (`interests`,`student_username`),
  ADD KEY `student_username` (`student_username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chapter`
--
ALTER TABLE `chapter`
  MODIFY `chapterID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `contentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `courseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `requestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chapter`
--
ALTER TABLE `chapter`
  ADD CONSTRAINT `chapter_ibfk_1` FOREIGN KEY (`courseID`) REFERENCES `course` (`courseID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `content`
--
ALTER TABLE `content`
  ADD CONSTRAINT `content_ibfk_1` FOREIGN KEY (`chapter`) REFERENCES `chapter` (`chapterID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`admin_username`) REFERENCES `admin` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_ibfk_2` FOREIGN KEY (`instructor_usename`) REFERENCES `instructor` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`instructor_username`) REFERENCES `instructor` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`admin_username`) REFERENCES `admin` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `requests_ibfk_3` FOREIGN KEY (`course_id`) REFERENCES `course` (`courseID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_course`
--
ALTER TABLE `student_course`
  ADD CONSTRAINT `student_course_ibfk_1` FOREIGN KEY (`coID`) REFERENCES `course` (`courseID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_course_ibfk_2` FOREIGN KEY (`stu_username`) REFERENCES `student` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_favorite`
--
ALTER TABLE `student_favorite`
  ADD CONSTRAINT `student_favorite_ibfk_1` FOREIGN KEY (`stu_username`) REFERENCES `student` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_favorite_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`courseID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_interests`
--
ALTER TABLE `student_interests`
  ADD CONSTRAINT `student_interests_ibfk_1` FOREIGN KEY (`student_username`) REFERENCES `student` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
