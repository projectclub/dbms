-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2017 at 07:27 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ams_v002`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `class_id` int(11) NOT NULL,
  `rollno` int(11) NOT NULL,
  `proxy` enum('P','A','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`class_id`, `rollno`, `proxy`) VALUES
(1, 111051, 'A'),
(1, 111055, 'P'),
(3, 111051, 'A'),
(3, 111055, 'A'),
(4, 111051, 'A'),
(4, 111055, 'A'),
(5, 111051, 'P'),
(5, 111055, 'P');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` int(11) NOT NULL,
  `course_faculty_year_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `course_faculty_year_id`, `date`, `start_time`, `end_time`) VALUES
(1, 1, '2017-10-09', '07:00:00', '08:00:00'),
(3, 2, '2017-11-09', '09:00:00', '10:00:00'),
(4, 12, '2016-11-09', '07:00:00', '08:00:00'),
(5, 2, '2017-11-07', '07:00:00', '08:00:00'),
(6, 102, '2017-11-09', '07:00:00', '08:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` tinyint(4) NOT NULL,
  `title` varchar(40) NOT NULL,
  `semester` enum('1','2','3','4','5','6','7','8') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `title`, `semester`) VALUES
(101, 'oopd', '4'),
(102, 'math', '4'),
(103, 'em', '4'),
(104, 'dbms', '5'),
(105, 'alc', '5'),
(106, 'mpmc', '5'),
(107, 'oprating System', '5');

-- --------------------------------------------------------

--
-- Table structure for table `course_component`
--

CREATE TABLE `course_component` (
  `course_faculty_year_id` int(11) NOT NULL,
  `type` enum('lecture','lab','tutorial') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_component`
--

INSERT INTO `course_component` (`course_faculty_year_id`, `type`) VALUES
(1, 'lecture'),
(2, 'lecture');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` tinyint(4) NOT NULL,
  `name` enum('comp','it','mech','ene','etc','civil','mining') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `name`) VALUES
(1, 'comp'),
(2, 'it');

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `rollno` int(11) NOT NULL,
  `course_faculty_year_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enrollment`
--

INSERT INTO `enrollment` (`rollno`, `course_faculty_year_id`) VALUES
(111051, 1),
(111051, 2),
(111055, 1),
(111055, 2);

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `faculty_id` int(11) NOT NULL,
  `faculty_name` varchar(30) NOT NULL,
  `department_id` tinyint(4) NOT NULL,
  `faculty_office_phone` bigint(20) DEFAULT NULL,
  `faculty_mobile_no` bigint(20) DEFAULT NULL,
  `faculty_email` int(11) DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `gender` enum('m','f') DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `teaching_exp` tinyint(4) DEFAULT NULL,
  `industry_exp` tinyint(4) DEFAULT NULL,
  `permannet_address` varchar(20) DEFAULT NULL,
  `local_address` varchar(20) DEFAULT NULL,
  `ug_university` varchar(20) DEFAULT NULL,
  `pg_university` varchar(20) DEFAULT NULL,
  `pan_card_no` varchar(20) DEFAULT NULL,
  `election_card_no` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`faculty_id`, `faculty_name`, `department_id`, `faculty_office_phone`, `faculty_mobile_no`, `faculty_email`, `joining_date`, `gender`, `birthdate`, `teaching_exp`, `industry_exp`, `permannet_address`, `local_address`, `ug_university`, `pg_university`, `pan_card_no`, `election_card_no`) VALUES
(111, 'kavita', 1, NULL, NULL, NULL, '2010-06-02', 'f', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(112, 'amit', 1, NULL, NULL, NULL, NULL, 'm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(191, 'laximinarayan', 1, NULL, NULL, NULL, NULL, 'm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `login`
-- (See below for the actual view)
--
CREATE TABLE `login` (
`id` bigint(20)
,`pass` varchar(5)
,`account_type` varchar(7)
);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `rollno` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `department_id` tinyint(4) NOT NULL,
  `address` varchar(40) DEFAULT NULL,
  `gender` enum('m','f') DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `phone_no` bigint(20) DEFAULT NULL,
  `email_id` varchar(20) DEFAULT NULL,
  `joining_year` year(4) DEFAULT NULL,
  `fathers_name` varchar(20) DEFAULT NULL,
  `mothers_name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`rollno`, `name`, `department_id`, `address`, `gender`, `date_of_birth`, `phone_no`, `email_id`, `joining_year`, `fathers_name`, `mothers_name`) VALUES
(111051, 'shivam kurtarkar', 1, NULL, 'm', NULL, NULL, NULL, NULL, NULL, NULL),
(111052, 'anoop Kinlekar', 1, NULL, 'm', NULL, NULL, NULL, NULL, NULL, NULL),
(111053, 'anand kandaleka', 1, NULL, 'm', NULL, NULL, NULL, NULL, NULL, NULL),
(111054, 'shivani Kulkarni', 1, NULL, 'f', NULL, NULL, NULL, NULL, NULL, NULL),
(111055, 'shivani Nadkarni', 1, NULL, 'f', NULL, NULL, NULL, NULL, NULL, NULL),
(111056, 'rushikesh prabhudesai', 1, NULL, 'm', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teaches`
--

CREATE TABLE `teaches` (
  `course_faculty_year_id` int(11) NOT NULL,
  `course_id` tinyint(4) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `year` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teaches`
--

INSERT INTO `teaches` (`course_faculty_year_id`, `course_id`, `faculty_id`, `year`) VALUES
(1, 101, 111, 2017),
(2, 103, 112, 2017);

-- --------------------------------------------------------

--
-- Table structure for table `timetable`
--

CREATE TABLE `timetable` (
  `course_faculty_year_id` int(11) NOT NULL,
  `day` enum('mon','tue','wed','thu','fri','sat','sun') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `timetable`
--

INSERT INTO `timetable` (`course_faculty_year_id`, `day`, `start_time`, `end_time`) VALUES
(1, 'tue', '09:00:00', '10:00:00'),
(1, 'thu', '07:00:00', '08:00:00'),
(2, 'tue', '07:00:00', '08:00:00'),
(2, 'thu', '09:00:00', '10:00:00');

-- --------------------------------------------------------

--
-- Structure for view `login`
--
DROP TABLE IF EXISTS `login`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `login`  AS  select `student`.`rollno` AS `id`,left(`student`.`name`,4) AS `pass`,'student' AS `account_type` from `student` union select `faculty`.`faculty_id` AS `id`,left(`faculty`.`faculty_name`,4) AS `pass`,'faculty' AS `account_type` from `faculty` union select 0 AS `id`,'admin' AS `pass`,'admin' AS `account_type` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`class_id`,`rollno`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`),
  ADD UNIQUE KEY `course_faculty_year_id` (`course_faculty_year_id`,`date`,`start_time`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD PRIMARY KEY (`rollno`,`course_faculty_year_id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`faculty_id`),
  ADD UNIQUE KEY `faculty_name` (`faculty_name`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`rollno`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `teaches`
--
ALTER TABLE `teaches`
  ADD PRIMARY KEY (`course_faculty_year_id`);

--
-- Indexes for table `timetable`
--
ALTER TABLE `timetable`
  ADD UNIQUE KEY `course_faculty_year_id` (`course_faculty_year_id`,`day`,`start_time`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `rollno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111057;

--
-- AUTO_INCREMENT for table `teaches`
--
ALTER TABLE `teaches`
  MODIFY `course_faculty_year_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
