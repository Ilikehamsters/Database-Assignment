-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 18, 2026 at 06:37 AM
-- Server version: 5.7.24
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `internship_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `assessment`
--

CREATE TABLE `assessment` (
  `Assessment_ID` int(11) NOT NULL,
  `Internship_ID` int(11) NOT NULL,
  `UTP` decimal(5,2) DEFAULT '0.00',
  `UTP_Feedback` varchar(255) DEFAULT NULL,
  `HSR` decimal(5,2) DEFAULT '0.00',
  `HSR_Feedback` varchar(255) DEFAULT NULL,
  `CUTK` decimal(5,2) DEFAULT '0.00',
  `CUTK_Feedback` varchar(255) DEFAULT NULL,
  `PR` decimal(5,2) DEFAULT '0.00',
  `PR_Feedback` varchar(255) DEFAULT NULL,
  `CLI` decimal(5,2) DEFAULT '0.00',
  `CLI_Feedback` varchar(255) DEFAULT NULL,
  `LLA` decimal(5,2) DEFAULT '0.00',
  `LLA_Feedback` varchar(255) DEFAULT NULL,
  `PM` decimal(5,2) DEFAULT '0.00',
  `PM_Feedback` varchar(255) DEFAULT NULL,
  `TM` decimal(5,2) DEFAULT '0.00',
  `TM_Feedback` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `Company_ID` int(11) NOT NULL,
  `Reg_Comp_Name` varchar(60) NOT NULL,
  `Reg_No.` varchar(50) NOT NULL,
  `Comp_Address` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `inds_supervisor`
--

CREATE TABLE `inds_supervisor` (
  `Supvr_ID` int(11) NOT NULL,
  `Company_ID` int(11) NOT NULL,
  `Full_Name` varchar(60) NOT NULL,
  `Email_Addr` varchar(50) NOT NULL,
  `Contact_No.` varchar(25) NOT NULL,
  `Salary` decimal(10,0) NOT NULL,
  `Employ_Date` date NOT NULL,
  `Gender` enum('Male','Female') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `internship`
--

CREATE TABLE `internship` (
  `Internship_ID` int(11) NOT NULL,
  `Student_ID` int(11) NOT NULL,
  `Staff_ID` int(11) NOT NULL,
  `Company_ID` int(11) NOT NULL,
  `Supvr_ID` int(11) NOT NULL,
  `Start_Intern` date NOT NULL,
  `End_Intern` date NOT NULL,
  `Status` enum('In progress','Completed') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `Position_Code` int(11) NOT NULL,
  `Position_Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `programme`
--

CREATE TABLE `programme` (
  `Prog_Code` int(11) NOT NULL,
  `Programme_Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `Student_ID` int(11) NOT NULL,
  `Prog_Code` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Full_Name` varchar(60) NOT NULL,
  `Contact_No.` varchar(25) NOT NULL,
  `Enroll_Date` date NOT NULL,
  `Email_Addr` varchar(50) NOT NULL,
  `Gender` enum('Male','Female') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `uni_staff`
--

CREATE TABLE `uni_staff` (
  `Staff_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Position_Code` int(11) NOT NULL,
  `Full_Name` varchar(60) NOT NULL,
  `Email_Addr` varchar(50) NOT NULL,
  `Contact_No.` varchar(25) NOT NULL,
  `Salary` decimal(10,0) NOT NULL,
  `Employ_Date` date NOT NULL,
  `Gender` enum('Male','Female') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `User_ID` int(11) NOT NULL,
  `Username` varchar(8) NOT NULL,
  `Password` varchar(18) NOT NULL,
  `Role` enum('Staff','Student') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`User_ID`, `Username`, `Password`, `Role`) VALUES
(1, 'skswoqa1', 'Edkwofjdos101', 'Student'),
(2, 'sssndqa1', 'Edooprewr@101', 'Student'),
(3, 'ajoelda1', 'E@#DJmdk10293', 'Staff'),
(4, 'woiejwd2', 'soDNEc203DDK', 'Staff'),
(5, 'dfsjf201', 'Edkewej349i31', 'Student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assessment`
--
ALTER TABLE `assessment`
  ADD PRIMARY KEY (`Assessment_ID`),
  ADD KEY `Internship_ID` (`Internship_ID`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`Company_ID`),
  ADD UNIQUE KEY `Reg_No.` (`Reg_No.`);

--
-- Indexes for table `inds_supervisor`
--
ALTER TABLE `inds_supervisor`
  ADD PRIMARY KEY (`Supvr_ID`),
  ADD KEY `Company_ID` (`Company_ID`);

--
-- Indexes for table `internship`
--
ALTER TABLE `internship`
  ADD PRIMARY KEY (`Internship_ID`),
  ADD KEY `Student_ID` (`Student_ID`),
  ADD KEY `Staff_ID` (`Staff_ID`),
  ADD KEY `Company_ID` (`Company_ID`),
  ADD KEY `Supvr_ID` (`Supvr_ID`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`Position_Code`);

--
-- Indexes for table `programme`
--
ALTER TABLE `programme`
  ADD PRIMARY KEY (`Prog_Code`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`Student_ID`),
  ADD KEY `Prog_Code` (`Prog_Code`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `uni_staff`
--
ALTER TABLE `uni_staff`
  ADD PRIMARY KEY (`Staff_ID`),
  ADD KEY `User_ID` (`User_ID`),
  ADD KEY `Position_Code` (`Position_Code`);

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assessment`
--
ALTER TABLE `assessment`
  MODIFY `Assessment_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `internship`
--
ALTER TABLE `internship`
  MODIFY `Internship_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_login`
--
ALTER TABLE `user_login`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assessment`
--
ALTER TABLE `assessment`
  ADD CONSTRAINT `assessment_ibfk_1` FOREIGN KEY (`Internship_ID`) REFERENCES `internship` (`Internship_ID`);

--
-- Constraints for table `inds_supervisor`
--
ALTER TABLE `inds_supervisor`
  ADD CONSTRAINT `inds_supervisor_ibfk_1` FOREIGN KEY (`Company_ID`) REFERENCES `company` (`Company_ID`);

--
-- Constraints for table `internship`
--
ALTER TABLE `internship`
  ADD CONSTRAINT `internship_ibfk_1` FOREIGN KEY (`Student_ID`) REFERENCES `student` (`Student_ID`),
  ADD CONSTRAINT `internship_ibfk_2` FOREIGN KEY (`Staff_ID`) REFERENCES `uni_staff` (`Staff_ID`),
  ADD CONSTRAINT `internship_ibfk_3` FOREIGN KEY (`Company_ID`) REFERENCES `company` (`Company_ID`),
  ADD CONSTRAINT `internship_ibfk_4` FOREIGN KEY (`Supvr_ID`) REFERENCES `inds_supervisor` (`Supvr_ID`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`Prog_Code`) REFERENCES `programme` (`Prog_Code`),
  ADD CONSTRAINT `student_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `user_login` (`User_ID`);

--
-- Constraints for table `uni_staff`
--
ALTER TABLE `uni_staff`
  ADD CONSTRAINT `uni_staff_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user_login` (`User_ID`),
  ADD CONSTRAINT `uni_staff_ibfk_2` FOREIGN KEY (`Position_Code`) REFERENCES `position` (`Position_Code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
