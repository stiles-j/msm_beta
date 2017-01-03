-- MySQL dump 10.13  Distrib 5.5.53, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: members
-- ------------------------------------------------------
-- Server version	5.5.53-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `members`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `members` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `members`;

--
-- Table structure for table `CERTIFICATION`
--

DROP TABLE IF EXISTS `CERTIFICATION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CERTIFICATION` (
  `CertName` varchar(50) NOT NULL,
  `Description` text,
  PRIMARY KEY (`CertName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CERTIFICATION`
--

LOCK TABLES `CERTIFICATION` WRITE;
/*!40000 ALTER TABLE `CERTIFICATION` DISABLE KEYS */;
/*!40000 ALTER TABLE `CERTIFICATION` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CLASS`
--

DROP TABLE IF EXISTS `CLASS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CLASS` (
  `ClassReferenceNumber` int(11) NOT NULL AUTO_INCREMENT,
  `ClassDate` date DEFAULT NULL,
  `CourseID` int(11) NOT NULL,
  PRIMARY KEY (`ClassReferenceNumber`),
  KEY `CourseID` (`CourseID`),
  CONSTRAINT `CLASS_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `COURSE` (`CourseID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CLASS`
--

LOCK TABLES `CLASS` WRITE;
/*!40000 ALTER TABLE `CLASS` DISABLE KEYS */;
/*!40000 ALTER TABLE `CLASS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CLASS_ENROLLMENT`
--

DROP TABLE IF EXISTS `CLASS_ENROLLMENT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CLASS_ENROLLMENT` (
  `MemberID` int(11) NOT NULL,
  `ClassReferenceNumber` int(11) NOT NULL,
  `PaymentReferenceNumber` int(11) DEFAULT NULL,
  PRIMARY KEY (`MemberID`,`ClassReferenceNumber`),
  KEY `ClassReferenceNumber` (`ClassReferenceNumber`),
  KEY `PaymentReferenceNumber` (`PaymentReferenceNumber`),
  CONSTRAINT `CLASS_ENROLLMENT_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `MEMBER` (`MemberID`),
  CONSTRAINT `CLASS_ENROLLMENT_ibfk_2` FOREIGN KEY (`ClassReferenceNumber`) REFERENCES `CLASS` (`ClassReferenceNumber`),
  CONSTRAINT `CLASS_ENROLLMENT_ibfk_3` FOREIGN KEY (`PaymentReferenceNumber`) REFERENCES `PAYMENT` (`PaymentReferenceNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CLASS_ENROLLMENT`
--

LOCK TABLES `CLASS_ENROLLMENT` WRITE;
/*!40000 ALTER TABLE `CLASS_ENROLLMENT` DISABLE KEYS */;
/*!40000 ALTER TABLE `CLASS_ENROLLMENT` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CLASS_VOLUNTEER`
--

DROP TABLE IF EXISTS `CLASS_VOLUNTEER`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CLASS_VOLUNTEER` (
  `ClassReferenceNumber` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `LoginReferenceNumber` int(11) DEFAULT NULL,
  PRIMARY KEY (`ClassReferenceNumber`,`MemberID`),
  KEY `MemberID` (`MemberID`),
  KEY `LoginReferenceNumber` (`LoginReferenceNumber`),
  CONSTRAINT `CLASS_VOLUNTEER_ibfk_1` FOREIGN KEY (`ClassReferenceNumber`) REFERENCES `CLASS` (`ClassReferenceNumber`),
  CONSTRAINT `CLASS_VOLUNTEER_ibfk_2` FOREIGN KEY (`MemberID`) REFERENCES `MEMBER` (`MemberID`),
  CONSTRAINT `CLASS_VOLUNTEER_ibfk_3` FOREIGN KEY (`LoginReferenceNumber`) REFERENCES `LOGIN` (`LoginReferenceNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CLASS_VOLUNTEER`
--

LOCK TABLES `CLASS_VOLUNTEER` WRITE;
/*!40000 ALTER TABLE `CLASS_VOLUNTEER` DISABLE KEYS */;
/*!40000 ALTER TABLE `CLASS_VOLUNTEER` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `COURSE`
--

DROP TABLE IF EXISTS `COURSE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `COURSE` (
  `CourseID` int(11) NOT NULL AUTO_INCREMENT,
  `CourseName` varchar(50) NOT NULL,
  `CourseDescription` text,
  `CourseMemberFee` decimal(6,2) DEFAULT NULL,
  `CourseNonMemberFee` decimal(6,2) DEFAULT NULL,
  PRIMARY KEY (`CourseID`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `COURSE`
--

LOCK TABLES `COURSE` WRITE;
/*!40000 ALTER TABLE `COURSE` DISABLE KEYS */;
/*!40000 ALTER TABLE `COURSE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `COURSE_CERTIFICATION`
--

DROP TABLE IF EXISTS `COURSE_CERTIFICATION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `COURSE_CERTIFICATION` (
  `CourseID` int(11) NOT NULL,
  `CertName` varchar(50) NOT NULL,
  PRIMARY KEY (`CourseID`,`CertName`),
  KEY `CertName` (`CertName`),
  CONSTRAINT `COURSE_CERTIFICATION_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `COURSE` (`CourseID`),
  CONSTRAINT `COURSE_CERTIFICATION_ibfk_2` FOREIGN KEY (`CertName`) REFERENCES `CERTIFICATION` (`CertName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `COURSE_CERTIFICATION`
--

LOCK TABLES `COURSE_CERTIFICATION` WRITE;
/*!40000 ALTER TABLE `COURSE_CERTIFICATION` DISABLE KEYS */;
/*!40000 ALTER TABLE `COURSE_CERTIFICATION` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `EVENT`
--

DROP TABLE IF EXISTS `EVENT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `EVENT` (
  `EventReferenceNumber` int(11) NOT NULL AUTO_INCREMENT,
  `EventDate` date DEFAULT NULL,
  `EventName` varchar(50) NOT NULL,
  `EventDescription` text,
  `EventMemberFee` decimal(6,2) DEFAULT NULL,
  `EventNonMemberFee` decimal(6,2) DEFAULT NULL,
  PRIMARY KEY (`EventReferenceNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `EVENT`
--

LOCK TABLES `EVENT` WRITE;
/*!40000 ALTER TABLE `EVENT` DISABLE KEYS */;
/*!40000 ALTER TABLE `EVENT` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `EVENT_ENROLLMENT`
--

DROP TABLE IF EXISTS `EVENT_ENROLLMENT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `EVENT_ENROLLMENT` (
  `MemberID` int(11) NOT NULL,
  `EventReferenceNumber` int(11) NOT NULL,
  `PaymentReferenceNumber` int(11) DEFAULT NULL,
  PRIMARY KEY (`MemberID`,`EventReferenceNumber`),
  KEY `EventReferenceNumber` (`EventReferenceNumber`),
  KEY `PaymentReferenceNumber` (`PaymentReferenceNumber`),
  CONSTRAINT `EVENT_ENROLLMENT_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `MEMBER` (`MemberID`),
  CONSTRAINT `EVENT_ENROLLMENT_ibfk_2` FOREIGN KEY (`EventReferenceNumber`) REFERENCES `EVENT` (`EventReferenceNumber`),
  CONSTRAINT `EVENT_ENROLLMENT_ibfk_3` FOREIGN KEY (`PaymentReferenceNumber`) REFERENCES `PAYMENT` (`PaymentReferenceNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `EVENT_ENROLLMENT`
--

LOCK TABLES `EVENT_ENROLLMENT` WRITE;
/*!40000 ALTER TABLE `EVENT_ENROLLMENT` DISABLE KEYS */;
/*!40000 ALTER TABLE `EVENT_ENROLLMENT` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `EVENT_VOLUNTEER`
--

DROP TABLE IF EXISTS `EVENT_VOLUNTEER`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `EVENT_VOLUNTEER` (
  `MemberID` int(11) NOT NULL,
  `LoginReferenceNumber` int(11) NOT NULL,
  `EventReferenceNumber` int(11) NOT NULL,
  `Role` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`MemberID`,`EventReferenceNumber`),
  KEY `LoginReferenceNumber` (`LoginReferenceNumber`),
  KEY `EventReferenceNumber` (`EventReferenceNumber`),
  CONSTRAINT `EVENT_VOLUNTEER_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `MEMBER` (`MemberID`),
  CONSTRAINT `EVENT_VOLUNTEER_ibfk_2` FOREIGN KEY (`LoginReferenceNumber`) REFERENCES `LOGIN` (`LoginReferenceNumber`),
  CONSTRAINT `EVENT_VOLUNTEER_ibfk_3` FOREIGN KEY (`EventReferenceNumber`) REFERENCES `EVENT` (`EventReferenceNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `EVENT_VOLUNTEER`
--

LOCK TABLES `EVENT_VOLUNTEER` WRITE;
/*!40000 ALTER TABLE `EVENT_VOLUNTEER` DISABLE KEYS */;
/*!40000 ALTER TABLE `EVENT_VOLUNTEER` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `LOGIN`
--

DROP TABLE IF EXISTS `LOGIN`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LOGIN` (
  `LoginReferenceNumber` int(11) NOT NULL AUTO_INCREMENT,
  `MemberID` int(11) NOT NULL,
  `LoginTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `LogoutTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`LoginReferenceNumber`),
  KEY `MemberID` (`MemberID`),
  CONSTRAINT `LOGIN_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `MEMBER` (`MemberID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LOGIN`
--

LOCK TABLES `LOGIN` WRITE;
/*!40000 ALTER TABLE `LOGIN` DISABLE KEYS */;
/*!40000 ALTER TABLE `LOGIN` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MEMBER`
--

DROP TABLE IF EXISTS `MEMBER`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MEMBER` (
  `MemberID` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(30) DEFAULT NULL,
  `LastName` varchar(30) DEFAULT NULL,
  `BirthDate` date DEFAULT NULL,
  `JoinDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `StreetAddress` varchar(50) DEFAULT NULL,
  `City` varchar(20) DEFAULT NULL,
  `State` varchar(20) DEFAULT NULL,
  `Zip` varchar(15) DEFAULT NULL,
  `HomePhone` char(12) DEFAULT NULL,
  `CellPhone` char(12) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `EmergencyContact` varchar(100) DEFAULT NULL,
  `ReferredBy` int(11) DEFAULT NULL,
  `Picture` varchar(100) DEFAULT NULL,
  `MembershipType` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`MemberID`),
  KEY `ReferredBy` (`ReferredBy`),
  CONSTRAINT `MEMBER_ibfk_1` FOREIGN KEY (`ReferredBy`) REFERENCES `MEMBER` (`MemberID`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MEMBER`
--

LOCK TABLES `MEMBER` WRITE;
/*!40000 ALTER TABLE `MEMBER` DISABLE KEYS */;
/*!40000 ALTER TABLE `MEMBER` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MEMBER_CERTIFICATION`
--

DROP TABLE IF EXISTS `MEMBER_CERTIFICATION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MEMBER_CERTIFICATION` (
  `MemberID` int(11) NOT NULL,
  `CertName` varchar(50) NOT NULL,
  PRIMARY KEY (`MemberID`,`CertName`),
  KEY `CertName` (`CertName`),
  CONSTRAINT `MEMBER_CERTIFICATION_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `MEMBER` (`MemberID`),
  CONSTRAINT `MEMBER_CERTIFICATION_ibfk_2` FOREIGN KEY (`CertName`) REFERENCES `CERTIFICATION` (`CertName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MEMBER_CERTIFICATION`
--

LOCK TABLES `MEMBER_CERTIFICATION` WRITE;
/*!40000 ALTER TABLE `MEMBER_CERTIFICATION` DISABLE KEYS */;
/*!40000 ALTER TABLE `MEMBER_CERTIFICATION` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `NOTES`
--

DROP TABLE IF EXISTS `NOTES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `NOTES` (
  `NoteTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `MemberID` int(11) NOT NULL,
  `NoteText` text,
  PRIMARY KEY (`NoteTime`,`MemberID`),
  KEY `MemberID` (`MemberID`),
  CONSTRAINT `NOTES_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `MEMBER` (`MemberID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `NOTES`
--

LOCK TABLES `NOTES` WRITE;
/*!40000 ALTER TABLE `NOTES` DISABLE KEYS */;
/*!40000 ALTER TABLE `NOTES` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PAYMENT`
--

DROP TABLE IF EXISTS `PAYMENT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PAYMENT` (
  `PaymentReferenceNumber` int(11) NOT NULL AUTO_INCREMENT,
  `PaymentDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `MemberID` int(11) NOT NULL,
  `Amount` decimal(8,2) NOT NULL,
  `Donation` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`PaymentReferenceNumber`),
  KEY `MemberID` (`MemberID`),
  CONSTRAINT `PAYMENT_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `MEMBER` (`MemberID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PAYMENT`
--

LOCK TABLES `PAYMENT` WRITE;
/*!40000 ALTER TABLE `PAYMENT` DISABLE KEYS */;
/*!40000 ALTER TABLE `PAYMENT` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-02 18:55:47
