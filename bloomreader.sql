-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 17, 2022 at 09:53 AM
-- Server version: 8.0.21
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bloomreader`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `FULLNAME` text NOT NULL,
  `USERNAME` varchar(15) NOT NULL,
  `EMAIL` varchar(25) NOT NULL,
  `PASSWORD` varchar(300) NOT NULL,
  `LastUpdated` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ID`, `FULLNAME`, `USERNAME`, `EMAIL`, `PASSWORD`, `LastUpdated`) VALUES
(1, 'Anna Gradel', 'Anna', 'anna94@gmail.com', '$2y$10$9PxkilqEUBd9JHL5FyJ4OuUoORcNMaolIZpTWifHdrhEXfrERKGrS', '2021-11-24');

-- --------------------------------------------------------

--
-- Table structure for table `admin_resp`
--

DROP TABLE IF EXISTS `admin_resp`;
CREATE TABLE IF NOT EXISTS `admin_resp` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ADMIN` varchar(50) NOT NULL,
  `ClientID` int NOT NULL,
  `MessageID` int NOT NULL,
  `Response` varchar(500) NOT NULL,
  `RespTime` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `admin_resp`
--

INSERT INTO `admin_resp` (`ID`, `ADMIN`, `ClientID`, `MessageID`, `Response`, `RespTime`) VALUES
(1, 'Admin', 3, 1, '			Alright. Which ones do you need?						', '2021-11-26');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
CREATE TABLE IF NOT EXISTS `announcements` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ADMIN` varchar(50) NOT NULL,
  `SUBJECT` varchar(120) NOT NULL,
  `CONTENT` varchar(500) NOT NULL,
  `DATE` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`ID`, `ADMIN`, `SUBJECT`, `CONTENT`, `DATE`) VALUES
(1, 'ADMIN', 'Black Friday Deals!!!', 'You can borrow up to 7 books this FriYAY!!!', '2021-11-27');

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

DROP TABLE IF EXISTS `authors`;
CREATE TABLE IF NOT EXISTS `authors` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `AuthorName` text NOT NULL,
  `DateAdded` date NOT NULL,
  `LastUPDATED` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`ID`, `AuthorName`, `DateAdded`, `LastUPDATED`) VALUES
(1, 'Stephen Covey', '2021-11-26', '0000-00-00'),
(2, 'Chimamanda Ngozi Adichie', '2021-11-26', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `BookName` text NOT NULL,
  `ISBN` int NOT NULL,
  `AuthorID` int NOT NULL,
  `CategoryID` int NOT NULL,
  `PRICE` int NOT NULL,
  `RegDate` date NOT NULL,
  `STATUS` int NOT NULL,
  `LastUPDATED` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`ID`, `BookName`, `ISBN`, `AuthorID`, `CategoryID`, `PRICE`, `RegDate`, `STATUS`, `LastUPDATED`) VALUES
(1, 'Seven Habits of Highly Effective People', 8739123, 1, 2, 3000, '2021-11-26', 1, '0000-00-00'),
(2, 'The Thing around your Neck', 2393738, 2, 1, 2800, '2021-11-26', 1, '0000-00-00'),
(3, 'Purple Hibiscus', 2536483, 2, 1, 4000, '2021-11-26', 1, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `CategoryName` text NOT NULL,
  `CreationDate` date NOT NULL,
  `LastUPDATED` date NOT NULL,
  `STATUS` int NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`ID`, `CategoryName`, `CreationDate`, `LastUPDATED`, `STATUS`) VALUES
(1, 'Fiction', '2021-11-26', '0000-00-00', 1),
(2, 'Self Improvement', '2021-11-26', '0000-00-00', 1),
(3, 'History', '2021-11-26', '0000-00-00', 1),
(4, 'Science', '2021-11-26', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `FNAME` text NOT NULL,
  `LNAME` text NOT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `PNUMBER` varchar(16) NOT NULL,
  `PASSWORD` varchar(2400) NOT NULL,
  `RegDATE` date NOT NULL,
  `STATUS` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`ID`, `FNAME`, `LNAME`, `EMAIL`, `PNUMBER`, `PASSWORD`, `RegDATE`, `STATUS`) VALUES
(1, 'James', 'MacArthur', 'james@gmail.com', '70389303', 'qwerty1234', '2021-11-24', 1),
(2, 'Stanley', 'Francis', 'stan412@gmail.com', '234839304', 'stanley412', '2021-11-24', 1),
(3, 'Jack', 'Bauer', 'jackie34@gmail.com', '238940037', '$2y$10$zK/PNXxR63dAa9f80zhSaOQHQpq1r8yrE8cJqSo2YebmDp/pWRrwm', '2021-11-24', 1);

-- --------------------------------------------------------

--
-- Table structure for table `issuedbooks`
--

DROP TABLE IF EXISTS `issuedbooks`;
CREATE TABLE IF NOT EXISTS `issuedbooks` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `BookID` int NOT NULL,
  `ClientID` int NOT NULL,
  `DateIssued` date NOT NULL,
  `DueDate` date NOT NULL,
  `ReturnStatus` int NOT NULL DEFAULT '0',
  `ReturnDate` date NOT NULL,
  `Fine` int NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `issuedbooks`
--

INSERT INTO `issuedbooks` (`ID`, `BookID`, `ClientID`, `DateIssued`, `DueDate`, `ReturnStatus`, `ReturnDate`, `Fine`) VALUES
(1, 2, 3, '2021-11-27', '2021-12-10', 0, '0000-00-00', 0),
(3, 1, 1, '2021-11-27', '2021-11-29', 1, '0000-00-00', 0),
(4, 2, 1, '2021-11-27', '2021-11-22', 1, '2021-11-27', 0);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Subject` varchar(255) NOT NULL,
  `Message` varchar(500) NOT NULL,
  `ClientID` int NOT NULL,
  `DateTime` date NOT NULL,
  `Status` int NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`ID`, `Subject`, `Message`, `ClientID`, `DateTime`, `Status`) VALUES
(1, 'Hey', 'I need 5 books', 3, '2021-11-26', 1),
(2, 'Hey', 'I need 5 books', 3, '2021-11-27', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
