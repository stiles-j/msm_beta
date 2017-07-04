-- MySQL dump 10.13  Distrib 5.5.55, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: members
-- ------------------------------------------------------
-- Server version	5.5.55-0ubuntu0.14.04.1

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
-- Temporary table structure for view `ALL_ENROLLMENTS`
--

DROP TABLE IF EXISTS `ALL_ENROLLMENTS`;
/*!50001 DROP VIEW IF EXISTS `ALL_ENROLLMENTS`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `ALL_ENROLLMENTS` (
  `MemberID` tinyint NOT NULL,
  `ReferenceNumber` tinyint NOT NULL,
  `Name` tinyint NOT NULL,
  `Date` tinyint NOT NULL,
  `PaymentReferenceNumber` tinyint NOT NULL,
  `Type` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

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
  `ClassDate` datetime DEFAULT NULL,
  `CourseID` int(11) NOT NULL,
  PRIMARY KEY (`ClassReferenceNumber`),
  KEY `CourseID` (`CourseID`),
  CONSTRAINT `CLASS_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `COURSE` (`CourseID`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;
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
-- Table structure for table `CLASS_TAKEN`
--

DROP TABLE IF EXISTS `CLASS_TAKEN`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CLASS_TAKEN` (
  `ClassReferenceNumber` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `LoginReferenceNumber` int(11) DEFAULT NULL,
  PRIMARY KEY (`ClassReferenceNumber`,`MemberID`),
  KEY `MemberID` (`MemberID`),
  KEY `LoginReferenceNumber` (`LoginReferenceNumber`),
  CONSTRAINT `CLASS_TAKEN_ibfk_1` FOREIGN KEY (`ClassReferenceNumber`) REFERENCES `CLASS` (`ClassReferenceNumber`),
  CONSTRAINT `CLASS_TAKEN_ibfk_2` FOREIGN KEY (`MemberID`) REFERENCES `MEMBER` (`MemberID`),
  CONSTRAINT `CLASS_TAKEN_ibfk_3` FOREIGN KEY (`LoginReferenceNumber`) REFERENCES `LOGIN` (`LoginReferenceNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CLASS_TAKEN`
--

LOCK TABLES `CLASS_TAKEN` WRITE;
/*!40000 ALTER TABLE `CLASS_TAKEN` DISABLE KEYS */;
/*!40000 ALTER TABLE `CLASS_TAKEN` ENABLE KEYS */;
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
-- Temporary table structure for view `CLASS_WITH_COURSE_NAME`
--

DROP TABLE IF EXISTS `CLASS_WITH_COURSE_NAME`;
/*!50001 DROP VIEW IF EXISTS `CLASS_WITH_COURSE_NAME`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `CLASS_WITH_COURSE_NAME` (
  `ClassReferenceNumber` tinyint NOT NULL,
  `ClassDate` tinyint NOT NULL,
  `CourseName` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

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
  `Duration` time DEFAULT NULL,
  PRIMARY KEY (`CourseID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
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
-- Table structure for table `COURSE_FACILITY`
--

DROP TABLE IF EXISTS `COURSE_FACILITY`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `COURSE_FACILITY` (
  `CourseID` int(11) NOT NULL,
  `FacilityID` int(11) NOT NULL,
  PRIMARY KEY (`CourseID`,`FacilityID`),
  KEY `FacilityID` (`FacilityID`),
  CONSTRAINT `COURSE_FACILITY_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `COURSE` (`CourseID`),
  CONSTRAINT `COURSE_FACILITY_ibfk_2` FOREIGN KEY (`FacilityID`) REFERENCES `FACILITY` (`FacilityID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `COURSE_FACILITY`
--

LOCK TABLES `COURSE_FACILITY` WRITE;
/*!40000 ALTER TABLE `COURSE_FACILITY` DISABLE KEYS */;
/*!40000 ALTER TABLE `COURSE_FACILITY` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `COURSE_FACILITY_WITH_NAME`
--

DROP TABLE IF EXISTS `COURSE_FACILITY_WITH_NAME`;
/*!50001 DROP VIEW IF EXISTS `COURSE_FACILITY_WITH_NAME`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `COURSE_FACILITY_WITH_NAME` (
  `CourseID` tinyint NOT NULL,
  `FacilityID` tinyint NOT NULL,
  `FacilityName` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `EVENT`
--

DROP TABLE IF EXISTS `EVENT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `EVENT` (
  `EventReferenceNumber` int(11) NOT NULL AUTO_INCREMENT,
  `EventDate` datetime DEFAULT NULL,
  `EventName` varchar(50) NOT NULL,
  `EventDescription` text,
  `EventMemberFee` decimal(6,2) DEFAULT NULL,
  `EventNonMemberFee` decimal(6,2) DEFAULT NULL,
  `Duration` time DEFAULT NULL,
  PRIMARY KEY (`EventReferenceNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `EVENT`
--

LOCK TABLES `EVENT` WRITE;
/*!40000 ALTER TABLE `EVENT` DISABLE KEYS */;
/*!40000 ALTER TABLE `EVENT` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `EVENT_ATTENDED`
--

DROP TABLE IF EXISTS `EVENT_ATTENDED`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `EVENT_ATTENDED` (
  `EventReferenceNumber` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `LoginReferenceNumber` int(11) DEFAULT NULL,
  PRIMARY KEY (`EventReferenceNumber`,`MemberID`),
  KEY `MemberID` (`MemberID`),
  KEY `LoginReferenceNumber` (`LoginReferenceNumber`),
  CONSTRAINT `EVENT_ATTENDED_ibfk_1` FOREIGN KEY (`EventReferenceNumber`) REFERENCES `EVENT` (`EventReferenceNumber`),
  CONSTRAINT `EVENT_ATTENDED_ibfk_2` FOREIGN KEY (`MemberID`) REFERENCES `MEMBER` (`MemberID`),
  CONSTRAINT `EVENT_ATTENDED_ibfk_3` FOREIGN KEY (`LoginReferenceNumber`) REFERENCES `LOGIN` (`LoginReferenceNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `EVENT_ATTENDED`
--

LOCK TABLES `EVENT_ATTENDED` WRITE;
/*!40000 ALTER TABLE `EVENT_ATTENDED` DISABLE KEYS */;
/*!40000 ALTER TABLE `EVENT_ATTENDED` ENABLE KEYS */;
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
-- Table structure for table `EVENT_FACILITY`
--

DROP TABLE IF EXISTS `EVENT_FACILITY`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `EVENT_FACILITY` (
  `EventReferenceNumber` int(11) NOT NULL,
  `FacilityID` int(11) NOT NULL,
  PRIMARY KEY (`EventReferenceNumber`,`FacilityID`),
  KEY `FacilityID` (`FacilityID`),
  CONSTRAINT `EVENT_FACILITY_ibfk_1` FOREIGN KEY (`EventReferenceNumber`) REFERENCES `EVENT` (`EventReferenceNumber`),
  CONSTRAINT `EVENT_FACILITY_ibfk_2` FOREIGN KEY (`FacilityID`) REFERENCES `FACILITY` (`FacilityID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `EVENT_FACILITY`
--

LOCK TABLES `EVENT_FACILITY` WRITE;
/*!40000 ALTER TABLE `EVENT_FACILITY` DISABLE KEYS */;
/*!40000 ALTER TABLE `EVENT_FACILITY` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `EVENT_FACILITY_WITH_NAME`
--

DROP TABLE IF EXISTS `EVENT_FACILITY_WITH_NAME`;
/*!50001 DROP VIEW IF EXISTS `EVENT_FACILITY_WITH_NAME`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `EVENT_FACILITY_WITH_NAME` (
  `EventReferenceNumber` tinyint NOT NULL,
  `FacilityID` tinyint NOT NULL,
  `FacilityName` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

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
-- Table structure for table `FACILITY`
--

DROP TABLE IF EXISTS `FACILITY`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `FACILITY` (
  `FacilityID` int(11) NOT NULL AUTO_INCREMENT,
  `FacilityName` varchar(50) DEFAULT NULL,
  `FacilityDescription` text,
  PRIMARY KEY (`FacilityID`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `FACILITY`
--

LOCK TABLES `FACILITY` WRITE;
/*!40000 ALTER TABLE `FACILITY` DISABLE KEYS */;
/*!40000 ALTER TABLE `FACILITY` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `FACILITY_SCHEDULE`
--

DROP TABLE IF EXISTS `FACILITY_SCHEDULE`;
/*!50001 DROP VIEW IF EXISTS `FACILITY_SCHEDULE`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `FACILITY_SCHEDULE` (
  `ReferenceNumber` tinyint NOT NULL,
  `StartTime` tinyint NOT NULL,
  `EndTime` tinyint NOT NULL,
  `FacilityID` tinyint NOT NULL,
  `Type` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

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
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=latin1;
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
  `MemberID` int(11) NOT NULL,
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
  UNIQUE KEY `MemberID` (`MemberID`),
  KEY `ReferredBy` (`ReferredBy`),
  CONSTRAINT `MEMBER_ibfk_1` FOREIGN KEY (`ReferredBy`) REFERENCES `MEMBER` (`MemberID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MEMBER`
--

LOCK TABLES `MEMBER` WRITE;
/*!40000 ALTER TABLE `MEMBER` DISABLE KEYS */;
INSERT INTO `MEMBER` VALUES (0,'NULL','NULL',NULL,'0000-00-00 00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL);
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
-- Temporary table structure for view `MEMBER_CLASS_HISTORY`
--

DROP TABLE IF EXISTS `MEMBER_CLASS_HISTORY`;
/*!50001 DROP VIEW IF EXISTS `MEMBER_CLASS_HISTORY`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `MEMBER_CLASS_HISTORY` (
  `MemberID` tinyint NOT NULL,
  `FirstName` tinyint NOT NULL,
  `LastName` tinyint NOT NULL,
  `CourseName` tinyint NOT NULL,
  `ClassDate` tinyint NOT NULL,
  `ClassReferenceNumber` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

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
  `Reason` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`PaymentReferenceNumber`),
  KEY `MemberID` (`MemberID`),
  CONSTRAINT `PAYMENT_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `MEMBER` (`MemberID`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PAYMENT`
--

LOCK TABLES `PAYMENT` WRITE;
/*!40000 ALTER TABLE `PAYMENT` DISABLE KEYS */;
/*!40000 ALTER TABLE `PAYMENT` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `PAYMENT_WITH_NAME`
--

DROP TABLE IF EXISTS `PAYMENT_WITH_NAME`;
/*!50001 DROP VIEW IF EXISTS `PAYMENT_WITH_NAME`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `PAYMENT_WITH_NAME` (
  `PaymentReferenceNumber` tinyint NOT NULL,
  `PaymentDate` tinyint NOT NULL,
  `MemberID` tinyint NOT NULL,
  `Amount` tinyint NOT NULL,
  `Reason` tinyint NOT NULL,
  `Name` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `PENDING_ALL`
--

DROP TABLE IF EXISTS `PENDING_ALL`;
/*!50001 DROP VIEW IF EXISTS `PENDING_ALL`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `PENDING_ALL` (
  `ReferenceNumber` tinyint NOT NULL,
  `Date` tinyint NOT NULL,
  `Name` tinyint NOT NULL,
  `MemberFee` tinyint NOT NULL,
  `NonMemberFee` tinyint NOT NULL,
  `Type` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `PENDING_CLASSES`
--

DROP TABLE IF EXISTS `PENDING_CLASSES`;
/*!50001 DROP VIEW IF EXISTS `PENDING_CLASSES`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `PENDING_CLASSES` (
  `ReferenceNumber` tinyint NOT NULL,
  `Date` tinyint NOT NULL,
  `Name` tinyint NOT NULL,
  `MemberFee` tinyint NOT NULL,
  `NonMemberFee` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `PENDING_ENROLLMENTS`
--

DROP TABLE IF EXISTS `PENDING_ENROLLMENTS`;
/*!50001 DROP VIEW IF EXISTS `PENDING_ENROLLMENTS`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `PENDING_ENROLLMENTS` (
  `MemberID` tinyint NOT NULL,
  `ReferenceNumber` tinyint NOT NULL,
  `Name` tinyint NOT NULL,
  `Date` tinyint NOT NULL,
  `Type` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `PENDING_EVENTS`
--

DROP TABLE IF EXISTS `PENDING_EVENTS`;
/*!50001 DROP VIEW IF EXISTS `PENDING_EVENTS`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `PENDING_EVENTS` (
  `ReferenceNumber` tinyint NOT NULL,
  `Date` tinyint NOT NULL,
  `Name` tinyint NOT NULL,
  `MemberFee` tinyint NOT NULL,
  `NonMemberFee` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `SUB_FACILITY`
--

DROP TABLE IF EXISTS `SUB_FACILITY`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SUB_FACILITY` (
  `PrimaryFacilityID` int(11) NOT NULL,
  `SubFacilityID` int(11) NOT NULL,
  PRIMARY KEY (`PrimaryFacilityID`,`SubFacilityID`),
  KEY `SubFacilityID` (`SubFacilityID`),
  CONSTRAINT `SUB_FACILITY_ibfk_1` FOREIGN KEY (`PrimaryFacilityID`) REFERENCES `FACILITY` (`FacilityID`),
  CONSTRAINT `SUB_FACILITY_ibfk_2` FOREIGN KEY (`SubFacilityID`) REFERENCES `FACILITY` (`FacilityID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SUB_FACILITY`
--

LOCK TABLES `SUB_FACILITY` WRITE;
/*!40000 ALTER TABLE `SUB_FACILITY` DISABLE KEYS */;
/*!40000 ALTER TABLE `SUB_FACILITY` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `VOLUNTEER_HISTORY`
--

DROP TABLE IF EXISTS `VOLUNTEER_HISTORY`;
/*!50001 DROP VIEW IF EXISTS `VOLUNTEER_HISTORY`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `VOLUNTEER_HISTORY` (
  `MemberID` tinyint NOT NULL,
  `Date` tinyint NOT NULL,
  `Name` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `ALL_ENROLLMENTS`
--

/*!50001 DROP TABLE IF EXISTS `ALL_ENROLLMENTS`*/;
/*!50001 DROP VIEW IF EXISTS `ALL_ENROLLMENTS`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `ALL_ENROLLMENTS` AS select `A`.`MemberID` AS `MemberID`,`B`.`ClassReferenceNumber` AS `ReferenceNumber`,`C`.`CourseName` AS `Name`,`B`.`ClassDate` AS `Date`,`A`.`PaymentReferenceNumber` AS `PaymentReferenceNumber`,'CLASS' AS `Type` from ((`CLASS_ENROLLMENT` `A` join `CLASS` `B`) join `COURSE` `C`) where ((`A`.`ClassReferenceNumber` = `B`.`ClassReferenceNumber`) and (`B`.`CourseID` = `C`.`CourseID`)) union select `A`.`MemberID` AS `MemberID`,`B`.`EventReferenceNumber` AS `ReferenceNumber`,`B`.`EventName` AS `Name`,`B`.`EventDate` AS `Date`,`A`.`PaymentReferenceNumber` AS `PaymentReferenceNumber`,'EVENT' AS `Type` from (`EVENT_ENROLLMENT` `A` join `EVENT` `B`) where (`A`.`EventReferenceNumber` = `B`.`EventReferenceNumber`) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `CLASS_WITH_COURSE_NAME`
--

/*!50001 DROP TABLE IF EXISTS `CLASS_WITH_COURSE_NAME`*/;
/*!50001 DROP VIEW IF EXISTS `CLASS_WITH_COURSE_NAME`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `CLASS_WITH_COURSE_NAME` AS select `A`.`ClassReferenceNumber` AS `ClassReferenceNumber`,`A`.`ClassDate` AS `ClassDate`,`B`.`CourseName` AS `CourseName` from (`CLASS` `A` join `COURSE` `B` on((`A`.`CourseID` = `B`.`CourseID`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `COURSE_FACILITY_WITH_NAME`
--

/*!50001 DROP TABLE IF EXISTS `COURSE_FACILITY_WITH_NAME`*/;
/*!50001 DROP VIEW IF EXISTS `COURSE_FACILITY_WITH_NAME`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `COURSE_FACILITY_WITH_NAME` AS select `A`.`CourseID` AS `CourseID`,`A`.`FacilityID` AS `FacilityID`,`B`.`FacilityName` AS `FacilityName` from (`COURSE_FACILITY` `A` join `FACILITY` `B` on((`A`.`FacilityID` = `B`.`FacilityID`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `EVENT_FACILITY_WITH_NAME`
--

/*!50001 DROP TABLE IF EXISTS `EVENT_FACILITY_WITH_NAME`*/;
/*!50001 DROP VIEW IF EXISTS `EVENT_FACILITY_WITH_NAME`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `EVENT_FACILITY_WITH_NAME` AS select `A`.`EventReferenceNumber` AS `EventReferenceNumber`,`A`.`FacilityID` AS `FacilityID`,`B`.`FacilityName` AS `FacilityName` from (`EVENT_FACILITY` `A` join `FACILITY` `B` on((`A`.`FacilityID` = `B`.`FacilityID`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `FACILITY_SCHEDULE`
--

/*!50001 DROP TABLE IF EXISTS `FACILITY_SCHEDULE`*/;
/*!50001 DROP VIEW IF EXISTS `FACILITY_SCHEDULE`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `FACILITY_SCHEDULE` AS select `A`.`ClassReferenceNumber` AS `ReferenceNumber`,`A`.`ClassDate` AS `StartTime`,addtime(`A`.`ClassDate`,`B`.`Duration`) AS `EndTime`,`C`.`FacilityID` AS `FacilityID`,'CLASS' AS `Type` from ((`CLASS` `A` join `COURSE` `B` on((`A`.`CourseID` = `B`.`CourseID`))) join `COURSE_FACILITY` `C` on((`B`.`CourseID` = `C`.`CourseID`))) union select `A`.`EventReferenceNumber` AS `ReferenceNumber`,`A`.`EventDate` AS `StartTime`,addtime(`A`.`EventDate`,`A`.`Duration`) AS `EndTime`,`B`.`FacilityID` AS `FacilityID`,'EVENT' AS `Type` from (`EVENT` `A` join `EVENT_FACILITY` `B` on((`A`.`EventReferenceNumber` = `B`.`EventReferenceNumber`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `MEMBER_CLASS_HISTORY`
--

/*!50001 DROP TABLE IF EXISTS `MEMBER_CLASS_HISTORY`*/;
/*!50001 DROP VIEW IF EXISTS `MEMBER_CLASS_HISTORY`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `MEMBER_CLASS_HISTORY` AS select `A`.`MemberID` AS `MemberID`,`D`.`FirstName` AS `FirstName`,`D`.`LastName` AS `LastName`,`B`.`CourseName` AS `CourseName`,`C`.`ClassDate` AS `ClassDate`,`C`.`ClassReferenceNumber` AS `ClassReferenceNumber` from (((`CLASS_TAKEN` `A` join `COURSE` `B`) join `CLASS` `C`) join `MEMBER` `D`) where ((`A`.`ClassReferenceNumber` = `C`.`ClassReferenceNumber`) and (`C`.`CourseID` = `B`.`CourseID`) and (`A`.`MemberID` = `D`.`MemberID`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `PAYMENT_WITH_NAME`
--

/*!50001 DROP TABLE IF EXISTS `PAYMENT_WITH_NAME`*/;
/*!50001 DROP VIEW IF EXISTS `PAYMENT_WITH_NAME`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `PAYMENT_WITH_NAME` AS select `A`.`PaymentReferenceNumber` AS `PaymentReferenceNumber`,`A`.`PaymentDate` AS `PaymentDate`,`A`.`MemberID` AS `MemberID`,`A`.`Amount` AS `Amount`,`A`.`Reason` AS `Reason`,`B`.`Name` AS `Name` from (`PAYMENT` `A` left join `ALL_ENROLLMENTS` `B` on((`B`.`PaymentReferenceNumber` = `A`.`PaymentReferenceNumber`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `PENDING_ALL`
--

/*!50001 DROP TABLE IF EXISTS `PENDING_ALL`*/;
/*!50001 DROP VIEW IF EXISTS `PENDING_ALL`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `PENDING_ALL` AS select `PENDING_CLASSES`.`ReferenceNumber` AS `ReferenceNumber`,`PENDING_CLASSES`.`Date` AS `Date`,`PENDING_CLASSES`.`Name` AS `Name`,`PENDING_CLASSES`.`MemberFee` AS `MemberFee`,`PENDING_CLASSES`.`NonMemberFee` AS `NonMemberFee`,'CLASS' AS `Type` from `PENDING_CLASSES` union select `PENDING_EVENTS`.`ReferenceNumber` AS `ReferenceNumber`,`PENDING_EVENTS`.`Date` AS `Date`,`PENDING_EVENTS`.`Name` AS `Name`,`PENDING_EVENTS`.`MemberFee` AS `MemberFee`,`PENDING_EVENTS`.`NonMemberFee` AS `NonMemberFee`,'EVENT' AS `Type` from `PENDING_EVENTS` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `PENDING_CLASSES`
--

/*!50001 DROP TABLE IF EXISTS `PENDING_CLASSES`*/;
/*!50001 DROP VIEW IF EXISTS `PENDING_CLASSES`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `PENDING_CLASSES` AS select `A`.`ClassReferenceNumber` AS `ReferenceNumber`,`A`.`ClassDate` AS `Date`,`B`.`CourseName` AS `Name`,`B`.`CourseMemberFee` AS `MemberFee`,`B`.`CourseNonMemberFee` AS `NonMemberFee` from (`CLASS` `A` join `COURSE` `B`) where ((`A`.`CourseID` = `B`.`CourseID`) and (`A`.`ClassDate` >= curdate())) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `PENDING_ENROLLMENTS`
--

/*!50001 DROP TABLE IF EXISTS `PENDING_ENROLLMENTS`*/;
/*!50001 DROP VIEW IF EXISTS `PENDING_ENROLLMENTS`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `PENDING_ENROLLMENTS` AS select `A`.`MemberID` AS `MemberID`,`B`.`ClassReferenceNumber` AS `ReferenceNumber`,`C`.`CourseName` AS `Name`,`B`.`ClassDate` AS `Date`,'CLASS' AS `Type` from ((`CLASS_ENROLLMENT` `A` join `CLASS` `B`) join `COURSE` `C`) where ((`A`.`ClassReferenceNumber` = `B`.`ClassReferenceNumber`) and (`B`.`CourseID` = `C`.`CourseID`) and (`B`.`ClassDate` >= curdate())) union select `A`.`MemberID` AS `MemberID`,`B`.`EventReferenceNumber` AS `ReferenceNumber`,`B`.`EventName` AS `Name`,`B`.`EventDate` AS `Date`,'EVENT' AS `Type` from (`EVENT_ENROLLMENT` `A` join `EVENT` `B`) where ((`A`.`EventReferenceNumber` = `B`.`EventReferenceNumber`) and (`B`.`EventDate` >= curdate())) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `PENDING_EVENTS`
--

/*!50001 DROP TABLE IF EXISTS `PENDING_EVENTS`*/;
/*!50001 DROP VIEW IF EXISTS `PENDING_EVENTS`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `PENDING_EVENTS` AS select `EVENT`.`EventReferenceNumber` AS `ReferenceNumber`,`EVENT`.`EventDate` AS `Date`,`EVENT`.`EventName` AS `Name`,`EVENT`.`EventMemberFee` AS `MemberFee`,`EVENT`.`EventNonMemberFee` AS `NonMemberFee` from `EVENT` where (`EVENT`.`EventDate` >= curdate()) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `VOLUNTEER_HISTORY`
--

/*!50001 DROP TABLE IF EXISTS `VOLUNTEER_HISTORY`*/;
/*!50001 DROP VIEW IF EXISTS `VOLUNTEER_HISTORY`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `VOLUNTEER_HISTORY` AS select `A`.`MemberID` AS `MemberID`,`B`.`ClassDate` AS `Date`,`C`.`CourseName` AS `Name` from ((`CLASS_VOLUNTEER` `A` join `CLASS` `B`) join `COURSE` `C`) where ((`A`.`ClassReferenceNumber` = `B`.`ClassReferenceNumber`) and (`B`.`CourseID` = `C`.`CourseID`)) union select `A`.`MemberID` AS `MemberID`,`B`.`EventDate` AS `Date`,`B`.`EventName` AS `Name` from (`EVENT_VOLUNTEER` `A` join `EVENT` `B`) where (`A`.`EventReferenceNumber` = `B`.`EventReferenceNumber`) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-07-03 21:48:30
