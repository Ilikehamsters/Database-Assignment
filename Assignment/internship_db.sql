-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 24, 2026 at 04:29 AM
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
  `User_ID` int(11) NOT NULL,
  `Full_Name` varchar(60) NOT NULL,
  `Email_Addr` varchar(50) NOT NULL,
  `Contact_No.` varchar(25) NOT NULL,
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
  `Status` enum('Ungraded','Graded') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `Prog_Code` varchar(5) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Full_Name` varchar(60) NOT NULL,
  `Contact_No.` varchar(25) NOT NULL,
  `Enroll_Date` date NOT NULL,
  `Email_Addr` varchar(50) NOT NULL,
  `Gender` enum('Male','Female') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`Student_ID`, `Prog_Code`, `User_ID`, `Full_Name`, `Contact_No.`, `Enroll_Date`, `Email_Addr`, `Gender`) VALUES
(1, 'PC01', 1, 'Yee Grace Shuang', '+601163742608', '2025-01-01', 'Grace@gmail.com', 'Female'),
(2, 'PC02', 2, 'Brian Yang Shunxi', '+601163742049', '2025-01-15', 'Brian@gmail.com', 'Male'),
(3, 'PC04', 15, 'Valerie', '+602323855900', '2025-02-01', 'Valerie@gmail.com', 'Female'),
(4, 'PC05', 16, 'Valiant', '+602319855317', '2025-03-15', 'Valiant@gmail.com', 'Female'),
(5, 'PC03', 17, 'Ben', '+601123445902', '2025-02-01', 'Ben@gmail.com', 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `uni_staff`
--

CREATE TABLE `uni_staff` (
  `Staff_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Position_Code` varchar(5) NOT NULL,
  `Full_Name` varchar(60) NOT NULL,
  `Email_Addr` varchar(50) NOT NULL,
  `Contact_No.` varchar(25) NOT NULL,
  `Employ_Date` date NOT NULL,
  `Gender` enum('Male','Female') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student`
--

Insert INTO `uni_staff` (`Staff_ID`, `User_ID`, `Position_Code`, `Full_Name`, `Email_Addr`, `Contact_No.`, `Employ_Date`, `Gender`) VALUES
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
  `Username` varchar(8) NOT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Role` enum('Student','Admin','uniAssessor','indSuperv') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`User_ID`, `Username`, `Password`, `Role`) VALUES
(1, 'Hi', '$2y$10$R8bwVxUEBnygClk4GXvNMerqmMbFeITCMp3z46PcmC/TlSwp6ad.K', 'Student'),
(2, 'Hi1', '$2y$10$TujIS2nR7LdATcF0aoh9ae9VmkRm6g4KSqCKFUlU.lGnonSHSrou2', 'Student'),
(3, 'Hi2', '$2y$10$NJHIhoCf9IUSpA0i5fWZguqK7JEpjBgRSZEawmctFOXsV8yTP330a', 'Admin'),
(4, 'Hi5', '$2y$10$lkmwHirBM6stOjiwaySNq.9iSkVqwGqzSyrwXTEX4Fb3RpL57dBN2', 'uniAssessor'),
(5, 'Hi3', '$2y$10$vRu9a29lEm1zSXcNXBl7OueSjbe19s.W7ShUyBNif20q0jXHYCeje', 'indSuperv'),
(6, 'student1', '$2y$10$Pqrhaqf2ml0ilQt7bSotU.5F2PYOgH75Rd4j.TVye12YejUTZ3UWG', 'Student'),
(7, 'student2', '$2y$10$wQibcJ0uNMWVgF4amxTH8u1Pbj7XHSUKhWzYdql6WqGHtZvGESNK.', 'Student'),
(8, 'student3', '$2y$10$9WMi09N3IGQgqITLTtX3IeBXRa43eFcodlyerRwkYMYk9.Uxi7PX.', 'Student'),
(9, 'skswoqa1', '$2y$10$lT38RlWzktQHtFAuWMbNMOmYLRqdzzftE1JufE/MvsaLtXsHtKZXy', 'Admin'),
(10, 'admin1', '$2y$10$/ZK75CFQxN/TizVECpBaJOhezOur0i8OC3eCSqlGPhMa8JW1IAmsm', 'Admin'),
(11, 'ioee1', '$2y$10$ZimoIcYvr/1ahYbHXOD6xuPP64dGQj7x2zU7UkSUyF1khLQyuA4Ve', 'Admin'),
(12, 'admin2', '$2y$10$3Pd6LxUE2yliE.ceRWEJNeunDaM6nmkW7pKlcWwXbal/oAS0elgSG', 'Admin'),
(13, 'efhwf', '$2y$10$Ufd84KaqkYgSkxSNj7FQqudk7r13E1iipkKZfYBxToKyK35rTzpLW', 'uniAssessor'),
(14, 'fulge1', '$2y$10$hM1/n44bJxAAf85K6rdJoebwhZvPwgRdPjYW1zzJODCXSaSExQDwe', 'uniAssessor'),
(15, 'hifuh9', '$2y$10$lK96hJbNkSwln8M.ugTZU.7hzmz0wMIR9OEZq.hQ2vVBfCz20G.g2', 'uniAssessor'),
(16, 'fghae7', '$2y$10$hXw1Zzl0gtGXP1m/RC9hreKXsBHiS9TfssWCMpnQF2N3Wc3DF5v5.', 'uniAssessor'),
(17, 'eriu5', '$2y$10$H5c.vqw8DsCcxCISXsxwTeNRU/pL1vtesCNuh9MwjB3lCIXzSmy/u', 'indSuperv'),
(18, 'kjfhw4', '$2y$10$ZsNBozxewxnPvBzaWVljyO5LtTFgbYdxA8HIeHCfvN8EgdpkZm9Ha', 'indSuperv'),
(19, 'rteg4', '$2y$10$PbgYzhjd7eqSpavyDKGnae4MgfhZx8VGOYLzggtxk/eKDsn5o2ENu', 'indSuperv'),
(20, 'fkg84', '$2y$10$z55qjJnAG1KFuz5CcpAUlOGFrXA8g//5wXJGIr2Xbs3nJE1nlK4wa', 'indSuperv');

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
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for table `assessment`
--
ALTER TABLE `assessment`
  ADD CONSTRAINT `ASS_internID_fk` FOREIGN KEY (`Internship_ID`) REFERENCES `internship` (`Internship_ID`);

--
-- Constraints for table `inds_supervisor`
--
ALTER TABLE `inds_supervisor`
  ADD CONSTRAINT `superv_compID_fk` FOREIGN KEY (`Company_ID`) REFERENCES `company` (`Company_ID`),
  ADD CONSTRAINT `superv_userID_fk` FOREIGN KEY (`User_ID`) REFERENCES `user_login` (`User_ID`) ON UPDATE CASCADE;

--
-- Constraints for table `internship`
--
ALTER TABLE `internship`
  ADD CONSTRAINT `intern_studID_fk` FOREIGN KEY (`Student_ID`) REFERENCES `student` (`Student_ID`),
  ADD CONSTRAINT `intern_staffID_fk` FOREIGN KEY (`Staff_ID`) REFERENCES `uni_staff` (`Staff_ID`),
  ADD CONSTRAINT `intern_compID_fk` FOREIGN KEY (`Company_ID`) REFERENCES `company` (`Company_ID`),
  ADD CONSTRAINT `intern_supvrID_fk` FOREIGN KEY (`Supvr_ID`) REFERENCES `inds_supervisor` (`Supvr_ID`);

--
-- Constraints for table `uni_staff`
--
ALTER TABLE `uni_staff`
  ADD CONSTRAINT `Staff_userID_fk` FOREIGN KEY (`User_ID`) REFERENCES `user_login` (`User_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
