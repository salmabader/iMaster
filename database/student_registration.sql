-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2022 at 11:19 PM
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
  `admin_username` varchar(10) NOT NULL,
  `image` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`courseID`, `title`, `category`, `objectives`, `requirements`, `level`, `collaborator`, `instructor_usename`, `admin_username`, `image`, `description`) VALUES
(2, 'Python', 'programming', 'jkkj', 'nj', 0, NULL, 'inst', 'admin', 'python.jpg', 'jj'),
(3, 'math', 'math', 'jhj', 'jhj', 2, NULL, 'inst', 'admin', 'math.jpg', 'hhj'),
(4, 'customer services training', 'Business', 'ghjk', 'hjkl', 2, NULL, 'inst', 'admin', 'business1.jpg', 'dfghjk'),
(5, 'C++', 'Programming', 'dfghj', 'dfghj', 0, NULL, 'inst', 'admin', 'c++.jpg', 'fghjkl;\''),
(6, 'Java', 'Programming', 'dfghjk', 'fghjk', 2, NULL, 'inst', 'admin', 'java.jpg', 'sdfghjk'),
(7, 'powerful speaking ', 'Business', 'cfgvbhnjmk', 'fgbhnjmk', 1, NULL, 'inst', 'admin', 'business2.jpg', 'dfghjkl'),
(8, 'creating 3D environments in blender', 'Design', 'sdfghjk', 'dfghjk', 0, NULL, 'inst', 'admin', 'Design.jpg', 'derftgyhujk');

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
  `IsAccepted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `instructor`
--

INSERT INTO `instructor` (`username`, `FName`, `LName`, `email`, `password`, `field`, `previous_course`, `degree`, `experience`, `bio`, `IsAccepted`) VALUES
('inst', 'Noor', 'Ahmad', 'jjh', 'jhj', 'programming', 'jh', 'b', '7', 'jjhhj', 1);

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `requestID` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `admin_username` varchar(10) NOT NULL,
  `instructor_username` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
('_noor', 'Noor', 'Ali', 'salma.ccsit@gmail.com', '$2y$10$SwA0cn/zvXKyQkmJXVyhf.REdxAcX3UX2yObvxj/oCP8.x9kt/10a');

-- --------------------------------------------------------

--
-- Table structure for table `student_course`
--

CREATE TABLE `student_course` (
  `stu_username` varchar(10) NOT NULL,
  `coID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_course`
--

INSERT INTO `student_course` (`stu_username`, `coID`) VALUES
('_noor', 2),
('_noor', 3),
('_noor', 4),
('_noor', 5),
('_noor', 6),
('_noor', 7),
('_noor', 8);

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
  ADD KEY `instructor_username` (`instructor_username`);

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
  MODIFY `chapterID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `contentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `courseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `requestID` int(11) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`admin_username`) REFERENCES `admin` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_course`
--
ALTER TABLE `student_course`
  ADD CONSTRAINT `student_course_ibfk_1` FOREIGN KEY (`coID`) REFERENCES `course` (`courseID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_course_ibfk_2` FOREIGN KEY (`stu_username`) REFERENCES `student` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_interests`
--
ALTER TABLE `student_interests`
  ADD CONSTRAINT `student_interests_ibfk_1` FOREIGN KEY (`student_username`) REFERENCES `student` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
