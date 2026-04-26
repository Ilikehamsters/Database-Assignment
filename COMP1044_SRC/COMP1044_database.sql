-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 26, 2026 at 11:25 AM
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
-- Database: `comp1044_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `assessment`
--

CREATE TABLE `assessment` (
  `Assessment_ID` varchar(15) NOT NULL,
  `Internship_ID` varchar(15) NOT NULL,
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

--
-- Dumping data for table `assessment`
--

INSERT INTO `assessment` (`Assessment_ID`, `Internship_ID`, `UTP`, `UTP_Feedback`, `HSR`, `HSR_Feedback`, `CUTK`, `CUTK_Feedback`, `PR`, `PR_Feedback`, `CLI`, `CLI_Feedback`, `LLA`, `LLA_Feedback`, `PM`, `PM_Feedback`, `TM`, `TM_Feedback`) VALUES
('APRINDS32094', 'APR20394', 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL),
('APRUNI32094', 'APR20394', 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL),
('FEBINDS20394', 'FEB56732', 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL),
('FEBUNI20394', 'FEB56732', 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL),
('JANINDS32034', 'JAN10234', 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL),
('JANUNI32034', 'JAN10234', 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL),
('JULINDS30751', 'JUL30492', 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL),
('JULUNI30751', 'JUL30492', 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL),
('JUNINDS49821', 'JUN00001', 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL),
('JUNUNI49821', 'JUN00001', 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, NULL);

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

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`Company_ID`, `Reg_Comp_Name`, `Reg_No.`, `Comp_Address`) VALUES
(10445, 'Hamburger Inc', '102032', 'Los Angeles'),
(12304, 'Nissan', '234834', 'New York'),
(13424, 'Smack&Shoot', '114032', 'Texas'),
(13922, 'Toy&Play', '454032', 'Washington DC'),
(34231, 'Friendtalk', '104532', 'Florida');

-- --------------------------------------------------------

--
-- Table structure for table `inds_supervisor`
--

CREATE TABLE `inds_supervisor` (
  `Supvr_ID` int(11) NOT NULL,
  `Company_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Full_Name` varchar(60) NOT NULL,
  `Email_Addr` varchar(50) NOT NULL,
  `Contact_No` varchar(25) NOT NULL,
  `Gender` enum('Male','Female') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inds_supervisor`
--

INSERT INTO `inds_supervisor` (`Supvr_ID`, `Company_ID`, `User_ID`, `Full_Name`, `Email_Addr`, `Contact_No`, `Gender`) VALUES
(1, 10445, 5, 'Ben', 'Ben@gmail.com', '+601123439402', 'Male'),
(2, 34231, 17, 'Welt', 'Welt@gmail.com', '+602323777900', 'Male'),
(3, 12304, 18, 'Grace', 'Grace@gmail.com', '+402323777900', 'Female'),
(4, 13424, 19, 'Mia', 'Mia@gmail.com', '+749523777900', 'Female'),
(5, 13922, 20, 'Richard', 'Richard@gmail.com', '+644423777900', 'Male'),
(6, 13424, 21, 'Ada Wong', 'Ada@gmail.com', '+60192749620', 'Female');

-- --------------------------------------------------------

--
-- Table structure for table `internship`
--

CREATE TABLE `internship` (
  `Internship_ID` varchar(15) NOT NULL,
  `Student_ID` int(11) NOT NULL,
  `Staff_ID` int(11) NOT NULL,
  `Company_ID` int(11) NOT NULL,
  `Supvr_ID` int(11) NOT NULL,
  `Start_Intern` date NOT NULL,
  `End_Intern` date NOT NULL,
  `Status` enum('Ungraded','Graded') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `internship`
--

INSERT INTO `internship` (`Internship_ID`, `Student_ID`, `Staff_ID`, `Company_ID`, `Supvr_ID`, `Start_Intern`, `End_Intern`, `Status`) VALUES
('APR20394', 3, 9, 13922, 4, '2020-04-08', '2020-08-08', 'Ungraded'),
('FEB56732', 5, 8, 13424, 3, '2022-02-11', '2026-06-11', 'Ungraded'),
('JAN10234', 2, 7, 12304, 2, '2024-01-16', '2024-05-16', 'Ungraded'),
('JUL30492', 4, 10, 34231, 5, '2022-07-13', '2022-11-13', 'Ungraded'),
('JUN00001', 1, 6, 10445, 1, '2023-06-01', '2023-10-01', 'Ungraded');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `Position_Code` varchar(5) NOT NULL,
  `Position_Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`Position_Code`, `Position_Name`) VALUES
('AD', 'Admin'),
('UASS', 'University Assessor');

-- --------------------------------------------------------

--
-- Table structure for table `programme`
--

CREATE TABLE `programme` (
  `Prog_Code` varchar(5) NOT NULL,
  `Programme_Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `programme`
--

INSERT INTO `programme` (`Prog_Code`, `Programme_Name`) VALUES
('PC01', 'Computer Science'),
('PC02', 'Mathematical Science'),
('PC03', 'Electrical Engineering'),
('PC04', 'Environmental Science'),
('PC05', 'Data Science');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `Student_ID` int(11) NOT NULL,
  `Prog_Code` varchar(5) DEFAULT NULL,
  `User_ID` int(11) NOT NULL,
  `Full_Name` varchar(60) NOT NULL,
  `Contact_No` varchar(25) NOT NULL,
  `Enroll_Date` date NOT NULL,
  `Email_Addr` varchar(50) NOT NULL,
  `Gender` enum('Male','Female') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`Student_ID`, `Prog_Code`, `User_ID`, `Full_Name`, `Contact_No`, `Enroll_Date`, `Email_Addr`, `Gender`) VALUES
(1, 'PC01', 1, 'Yee Grace Shuang', '+601163742608', '2025-01-01', 'Grace@gmail.com', 'Female'),
(2, 'PC02', 2, 'Brian Yang Shunxi', '+601163742049', '2025-01-15', 'Brian@gmail.com', 'Male'),
(3, 'PC04', 15, 'Valerie', '+602323855900', '2025-02-01', 'Valerie@gmail.com', 'Female'),
(4, 'PC05', 16, 'Valiant', '+602319855317', '2025-03-15', 'Valiant@gmail.com', 'Female'),
(5, 'PC03', 17, 'Ben', '+601123445902', '2025-02-01', 'Ben@gmail.com', 'Male'),
(6, 'PC03', 22, 'Bryan Teh', '+60192340955', '2018-01-01', 'Bryan@gmail.com', 'Male'),
(7, 'PC01', 23, 'Claire Redfield', '+601927721833', '1998-09-30', 'Claire@gmail.com', 'Female'),
(8, 'PC03', 24, 'Sung Jin Woo', '+60192773094', '2015-11-10', 'Sung@gmail.com', 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `uni_staff`
--

CREATE TABLE `uni_staff` (
  `Staff_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Position_Code` varchar(5) DEFAULT NULL,
  `Full_Name` varchar(60) NOT NULL,
  `Email_Addr` varchar(50) NOT NULL,
  `Contact_No` varchar(16) NOT NULL,
  `Employ_Date` date NOT NULL,
  `Gender` enum('Male','Female') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `uni_staff`
--

INSERT INTO `uni_staff` (`Staff_ID`, `User_ID`, `Position_Code`, `Full_Name`, `Email_Addr`, `Contact_No`, `Employ_Date`, `Gender`) VALUES
(1, 3, 'AD', 'Storm', 'Storm@gmail.com', '+601123443910', '1994-01-25', 'Male'),
(2, 9, 'AD', 'Sophia', 'Sophia@gmail.com', '+601145443910', '1990-11-05', 'Female'),
(3, 10, 'AD', 'Oliver', 'Oliver@gmail.com', '+829323443910', '1991-03-12', 'Male'),
(4, 11, 'AD', 'Liam', 'Liam@gmail.com', '+946013443910', '2000-04-16', 'Male'),
(5, 12, 'AD', 'Agnes Tachyon', 'Agnes@gmail.com', '+101123745910', '1999-02-17', 'Female'),
(6, 4, 'UASS', 'Noah', 'Noah@gmail.com', '+401123494510', '1975-02-11', 'Male'),
(7, 13, 'UASS', 'Anna Myers', 'Anna@gmail.com', '+501125553910', '1994-01-10', 'Female'),
(8, 14, 'UASS', 'Aurora', 'Aurora@gmail.com', '+909993443910', '1991-07-19', 'Female'),
(9, 15, 'UASS', 'Alice', 'Alice@gmail.com', '+701100043910', '1990-04-01', 'Female'),
(10, 16, 'UASS', 'Henry', 'Henry@gmail.com', '+211223443910', '1994-01-25', 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `User_ID` int(11) NOT NULL,
  `Username` varchar(12) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` enum('Student','Admin','University Assessor','Industrial Supervisor') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`User_ID`, `Username`, `Password`, `Role`) VALUES
(1, 'Student1', '1234', 'Student'),
(2, 'Student2', '123abc', 'Student'),
(3, 'Admin1', '12345', 'Admin'),
(4, 'Assessor1', '123abcd', 'University Assessor'),
(5, 'Superv1', '123456', 'Industrial Supervisor'),
(6, 'student3', '12345678910', 'Student'),
(7, 'student4', '1234567890', 'Student'),
(8, 'student5', 'abcde', 'Student'),
(9, 'Admin2', 'abcd', 'Admin'),
(10, 'Admin3', 'abcdef', 'Admin'),
(11, 'Admin4', '12345678', 'Admin'),
(12, 'Admin5', '1234567', 'Admin'),
(13, 'Assessor2', 'justdoit', 'University Assessor'),
(14, 'Assessor3', 'justdewit', 'University Assessor'),
(15, 'Assessor4', '123boring', 'University Assessor'),
(16, 'Assessor5', 'password', 'University Assessor'),
(17, 'Superv2', 'Ok101', 'Industrial Supervisor'),
(18, 'Superv3', 'Password101', 'Industrial Supervisor'),
(19, 'Superv4', 'Sailor120', 'Industrial Supervisor'),
(20, 'Superv5', 'qwerty', 'Industrial Supervisor'),
(21, 'supervisor10', 'defaultPWD', 'Industrial Supervisor'),
(22, 'fhsoi', 'Beef101', 'Student'),
(23, 'sdkjsf', 'defaultPWD', 'Student'),
(24, 'kjdfdsd', 'defaultPWD', 'Student');

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
  ADD KEY `Company_ID` (`Company_ID`),
  ADD KEY `User_ID` (`User_ID`);

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
  ADD KEY `User_ID` (`User_ID`),
  ADD KEY `student_progCode_fk` (`Prog_Code`);

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
-- AUTO_INCREMENT for table `inds_supervisor`
--
ALTER TABLE `inds_supervisor`
  MODIFY `Supvr_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `Student_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `uni_staff`
--
ALTER TABLE `uni_staff`
  MODIFY `Staff_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_login`
--
ALTER TABLE `user_login`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assessment`
--
ALTER TABLE `assessment`
  ADD CONSTRAINT `ASS_internID_fk` FOREIGN KEY (`Internship_ID`) REFERENCES `internship` (`Internship_ID`) ON DELETE CASCADE;

--
-- Constraints for table `inds_supervisor`
--
ALTER TABLE `inds_supervisor`
  ADD CONSTRAINT `superv_compID_fk` FOREIGN KEY (`Company_ID`) REFERENCES `company` (`Company_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `superv_userID_fk` FOREIGN KEY (`User_ID`) REFERENCES `user_login` (`User_ID`) ON DELETE CASCADE;

--
-- Constraints for table `internship`
--
ALTER TABLE `internship`
  ADD CONSTRAINT `intern_compID_fk` FOREIGN KEY (`Company_ID`) REFERENCES `company` (`Company_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `intern_staffID_fk` FOREIGN KEY (`Staff_ID`) REFERENCES `uni_staff` (`Staff_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `intern_studID_fk` FOREIGN KEY (`Student_ID`) REFERENCES `student` (`Student_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `intern_supvrID_fk` FOREIGN KEY (`Supvr_ID`) REFERENCES `inds_supervisor` (`Supvr_ID`) ON DELETE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `Student_programme_fk` FOREIGN KEY (`Prog_Code`) REFERENCES `programme` (`Prog_Code`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `Student_userID_fk` FOREIGN KEY (`User_ID`) REFERENCES `user_login` (`User_ID`) ON DELETE CASCADE;

--
-- Constraints for table `uni_staff`
--
ALTER TABLE `uni_staff`
  ADD CONSTRAINT `Staff_position_fk` FOREIGN KEY (`Position_Code`) REFERENCES `position` (`Position_Code`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `Staff_userID_fk` FOREIGN KEY (`User_ID`) REFERENCES `user_login` (`User_ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
