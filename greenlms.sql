-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table greenlms.book
CREATE TABLE IF NOT EXISTS `book` (
  `bookID` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `bookcategoryID` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `isbnno` varchar(100) NOT NULL,
  `coverphoto` varchar(200) NOT NULL,
  `codeno` varchar(100) NOT NULL,
  `rackID` int DEFAULT NULL,
  `editionnumber` varchar(100) NOT NULL,
  `editiondate` datetime DEFAULT NULL,
  `publisher` varchar(100) NOT NULL,
  `publisheddate` datetime DEFAULT NULL,
  `notes` text NOT NULL,
  `status` tinyint NOT NULL COMMENT '0= Book Available, 1= Book Not Available',
  `deleted_at` tinyint NOT NULL COMMENT '0= Book Available, 1=Book Deleted ',
  `create_date` datetime NOT NULL,
  `create_memberID` int NOT NULL,
  `create_roleID` int NOT NULL,
  `modify_date` datetime NOT NULL,
  `modify_memberID` int NOT NULL,
  `modify_roleID` int NOT NULL,
  PRIMARY KEY (`bookID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.book: ~0 rows (approximately)
INSERT INTO `book` (`bookID`, `name`, `author`, `bookcategoryID`, `quantity`, `price`, `isbnno`, `coverphoto`, `codeno`, `rackID`, `editionnumber`, `editiondate`, `publisher`, `publisheddate`, `notes`, `status`, `deleted_at`, `create_date`, `create_memberID`, `create_roleID`, `modify_date`, `modify_memberID`, `modify_roleID`) VALUES
	(1, 'Unified Modeling Language', 'Munawar', 1, 2, 50000.00, '1234567', '594b5e9a68270057b5d44939551492377d2fc44095cb53827ab0de699eb7135c6df9cd9ad3c6aa2aaedf67b013f16ab49ac004b51f803c269f05624cbf6900ed.jpg', '200.10.0001', 2, '1', '2025-01-01 00:00:00', 'Informatika', '2025-01-01 00:00:00', '-', 1, 0, '2025-01-14 11:22:38', 1, 1, '2025-01-14 11:22:38', 1, 1);

-- Dumping structure for table greenlms.bookcategory
CREATE TABLE IF NOT EXISTS `bookcategory` (
  `bookcategoryID` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `coverphoto` varchar(255) NOT NULL,
  `status` tinyint NOT NULL,
  `create_date` datetime NOT NULL,
  `create_memberID` int NOT NULL,
  `create_roleID` int NOT NULL,
  `modify_date` datetime NOT NULL,
  `modify_memberID` int NOT NULL,
  `modify_roleID` int NOT NULL,
  PRIMARY KEY (`bookcategoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.bookcategory: ~0 rows (approximately)
INSERT INTO `bookcategory` (`bookcategoryID`, `name`, `description`, `coverphoto`, `status`, `create_date`, `create_memberID`, `create_roleID`, `modify_date`, `modify_memberID`, `modify_roleID`) VALUES
	(1, 'Rekayasa Perangkat Lunak', 'Deskripsi Rekayasa Perangkat Lunak', 'bookcategory.jpg', 1, '2025-01-12 08:45:17', 1, 1, '2025-01-12 08:45:47', 1, 1);

-- Dumping structure for table greenlms.bookissue
CREATE TABLE IF NOT EXISTS `bookissue` (
  `bookissueID` int NOT NULL AUTO_INCREMENT,
  `roleID` int NOT NULL,
  `memberID` int NOT NULL,
  `bookcategoryID` int NOT NULL,
  `bookID` int NOT NULL,
  `bookno` int NOT NULL,
  `notes` varchar(255) NOT NULL,
  `issue_date` datetime NOT NULL,
  `expire_date` datetime NOT NULL,
  `renewed` tinyint NOT NULL,
  `max_renewed_limit` tinyint NOT NULL,
  `book_fine_per_day` decimal(10,2) NOT NULL,
  `fineamount` decimal(10,2) NOT NULL,
  `paymentamount` decimal(10,2) NOT NULL,
  `discountamount` decimal(10,2) NOT NULL,
  `paidstatus` tinyint NOT NULL DEFAULT '0' COMMENT '0 = due,  1 = partial, 2 = Paid',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0 = Issued,  1 = Return, 2 = Lost',
  `deleted_at` tinyint NOT NULL DEFAULT '0' COMMENT '0 = Not Deleted, 1 = Deleted',
  `create_date` datetime NOT NULL,
  `create_memberID` int NOT NULL,
  `create_roleID` int NOT NULL,
  `modify_date` datetime NOT NULL,
  `modify_memberID` int NOT NULL,
  `modify_roleID` int NOT NULL,
  PRIMARY KEY (`bookissueID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.bookissue: ~4 rows (approximately)
INSERT INTO `bookissue` (`bookissueID`, `roleID`, `memberID`, `bookcategoryID`, `bookID`, `bookno`, `notes`, `issue_date`, `expire_date`, `renewed`, `max_renewed_limit`, `book_fine_per_day`, `fineamount`, `paymentamount`, `discountamount`, `paidstatus`, `status`, `deleted_at`, `create_date`, `create_memberID`, `create_roleID`, `modify_date`, `modify_memberID`, `modify_roleID`) VALUES
	(1, 3, 4, 1, 1, 1, '-', '2025-01-01 00:00:00', '2025-01-24 00:00:00', 1, 2, 2000.00, 8000.00, 8000.00, 0.00, 2, 1, 0, '2025-01-14 15:36:45', 3, 2, '2025-01-14 15:36:45', 3, 2),
	(2, 3, 4, 1, 1, 1, '-', '2025-01-31 00:00:00', '2025-02-20 00:00:00', 1, 2, 2000.00, 50000.00, 50000.00, 0.00, 2, 2, 0, '2025-01-14 15:42:15', 3, 2, '2025-01-14 15:42:15', 3, 2),
	(3, 3, 4, 1, 1, 1, '', '2025-01-21 00:00:00', '2025-02-10 00:00:00', 1, 2, 2000.00, 0.00, 0.00, 0.00, 0, 1, 0, '2025-01-21 22:41:11', 1, 1, '2025-01-21 22:41:11', 1, 1),
	(4, 3, 4, 1, 1, 1, '', '2025-01-22 00:00:00', '2025-02-05 00:00:00', 1, 2, 2000.00, 0.00, 0.00, 0.00, 0, 0, 0, '2025-01-21 23:42:24', 1, 1, '2025-01-21 23:42:24', 1, 1),
	(5, 3, 4, 1, 1, 2, '', '2025-01-22 00:00:00', '2025-02-05 00:00:00', 1, 2, 2000.00, 0.00, 0.00, 0.00, 0, 0, 0, '2025-01-21 23:46:30', 1, 1, '2025-01-21 23:46:30', 1, 1);

-- Dumping structure for table greenlms.bookitem
CREATE TABLE IF NOT EXISTS `bookitem` (
  `bookitemID` int NOT NULL AUTO_INCREMENT,
  `bookID` int NOT NULL,
  `bookno` int NOT NULL,
  `status` tinyint NOT NULL COMMENT '0= Book Available, 1= Book Issued, 2=Book Lost',
  `deleted_at` tinyint NOT NULL COMMENT '0= Book Available, 1= Book Not Available',
  PRIMARY KEY (`bookitemID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table greenlms.bookitem: ~2 rows (approximately)
INSERT INTO `bookitem` (`bookitemID`, `bookID`, `bookno`, `status`, `deleted_at`) VALUES
	(1, 1, 1, 1, 0),
	(2, 1, 2, 1, 0);

-- Dumping structure for table greenlms.chat
CREATE TABLE IF NOT EXISTS `chat` (
  `chatID` int NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `create_date` datetime NOT NULL,
  `create_memberID` int NOT NULL,
  `create_roleID` int NOT NULL,
  `modify_date` datetime NOT NULL,
  `modify_memberID` int NOT NULL,
  `modify_roleID` int NOT NULL,
  PRIMARY KEY (`chatID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.chat: ~0 rows (approximately)
INSERT INTO `chat` (`chatID`, `message`, `create_date`, `create_memberID`, `create_roleID`, `modify_date`, `modify_memberID`, `modify_roleID`) VALUES
	(1, 'Hello', '2025-01-02 20:13:32', 1, 1, '2025-01-02 20:13:32', 1, 1),
	(2, 'Hai admin', '2025-01-13 06:50:44', 3, 2, '2025-01-13 06:50:44', 3, 2);

-- Dumping structure for table greenlms.ebook
CREATE TABLE IF NOT EXISTS `ebook` (
  `ebookID` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `coverphoto` varchar(200) NOT NULL,
  `file` varchar(200) NOT NULL,
  `file_original_name` varchar(200) NOT NULL,
  `notes` text NOT NULL,
  `create_date` datetime NOT NULL,
  `create_memberID` int NOT NULL,
  `create_roleID` int NOT NULL,
  `modify_date` datetime NOT NULL,
  `modify_memberID` int NOT NULL,
  `modify_roleID` int NOT NULL,
  PRIMARY KEY (`ebookID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table greenlms.ebook: ~0 rows (approximately)
INSERT INTO `ebook` (`ebookID`, `name`, `author`, `coverphoto`, `file`, `file_original_name`, `notes`, `create_date`, `create_memberID`, `create_roleID`, `modify_date`, `modify_memberID`, `modify_roleID`) VALUES
	(1, 'Software Engineering (Sommerville)', 'Ian Sommerville', '14101636e9d5d4c86cf2d13b5263b44e1ce72b6215cfdf2712c3b1857c9ca0df4f7161b1a1e0414b3055f582b114a1d3fad855030dbb223d39c98aa6a3efe8f5.jpg', '5382d3294fce215c6f40a0ec0f95f103bfeaa1710504a55a673d6786edc55431702220df8df5ddb35edc7c17bff0c262149c91a420abd06b829c28ab9c78dc25.pdf', '', '-', '2025-01-12 09:10:35', 1, 1, '2025-01-14 11:14:13', 1, 1);

-- Dumping structure for table greenlms.emailsend
CREATE TABLE IF NOT EXISTS `emailsend` (
  `emailsendID` int NOT NULL AUTO_INCREMENT,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `sender_name` text NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `sender_memberID` int NOT NULL,
  `sender_roleID` int NOT NULL,
  `emailtemplateID` int NOT NULL DEFAULT '0',
  `create_date` datetime NOT NULL,
  `create_memberID` int NOT NULL,
  `create_roleID` int NOT NULL,
  `on_deleted` tinyint NOT NULL DEFAULT '0' COMMENT '0=show, 1=delete',
  PRIMARY KEY (`emailsendID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.emailsend: ~0 rows (approximately)

-- Dumping structure for table greenlms.emailsetting
CREATE TABLE IF NOT EXISTS `emailsetting` (
  `optionkey` varchar(100) NOT NULL,
  `optionvalue` text NOT NULL,
  UNIQUE KEY `frontendkey` (`optionkey`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.emailsetting: ~6 rows (approximately)
INSERT INTO `emailsetting` (`optionkey`, `optionvalue`) VALUES
	('mail_driver', ''),
	('mail_encryption', ''),
	('mail_host', ''),
	('mail_password', ''),
	('mail_port', ''),
	('mail_username', '');

-- Dumping structure for table greenlms.emailtemplate
CREATE TABLE IF NOT EXISTS `emailtemplate` (
  `emailtemplateID` int NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `template` text NOT NULL,
  `priority` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '1',
  `create_date` datetime NOT NULL,
  `create_memberID` int NOT NULL,
  `create_roleID` int NOT NULL,
  `modify_date` datetime NOT NULL,
  `modify_memberID` int NOT NULL,
  `modify_roleID` int NOT NULL,
  PRIMARY KEY (`emailtemplateID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.emailtemplate: ~0 rows (approximately)

-- Dumping structure for table greenlms.expense
CREATE TABLE IF NOT EXISTS `expense` (
  `expenseID` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `file` varchar(200) DEFAULT NULL,
  `fileoriginalname` varchar(200) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `create_memberID` int NOT NULL,
  `create_roleID` int NOT NULL,
  `modify_date` datetime NOT NULL,
  `modify_memberID` int NOT NULL,
  `modify_roleID` int NOT NULL,
  PRIMARY KEY (`expenseID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.expense: ~0 rows (approximately)

-- Dumping structure for table greenlms.finehistory
CREATE TABLE IF NOT EXISTS `finehistory` (
  `finehistoryID` int NOT NULL AUTO_INCREMENT,
  `bookissueID` int NOT NULL,
  `bookstatusID` int NOT NULL COMMENT '0 = Issued,  1 = Return, 2 = Lost',
  `renewed` tinyint NOT NULL,
  `from_date` datetime DEFAULT NULL,
  `to_date` datetime DEFAULT NULL,
  `fineamount` decimal(10,2) NOT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `create_memberID` int NOT NULL,
  `create_roleID` int NOT NULL,
  `modify_date` datetime NOT NULL,
  `modify_memberID` int NOT NULL,
  `modify_roleID` int NOT NULL,
  PRIMARY KEY (`finehistoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.finehistory: ~8 rows (approximately)
INSERT INTO `finehistory` (`finehistoryID`, `bookissueID`, `bookstatusID`, `renewed`, `from_date`, `to_date`, `fineamount`, `notes`, `create_date`, `create_memberID`, `create_roleID`, `modify_date`, `modify_memberID`, `modify_roleID`) VALUES
	(1, 1, 0, 1, NULL, NULL, 0.00, NULL, '2025-01-14 15:36:45', 3, 2, '2025-01-14 15:36:45', 3, 2),
	(2, 1, 1, 1, '2025-01-12 00:00:00', '2025-01-13 00:00:00', 8000.00, '', '2025-01-14 15:38:04', 3, 2, '2025-01-14 15:38:04', 3, 2),
	(3, 2, 0, 1, NULL, NULL, 0.00, NULL, '2025-01-14 15:42:15', 3, 2, '2025-01-14 15:42:15', 3, 2),
	(4, 2, 2, 1, NULL, NULL, 50000.00, '', '2025-01-14 15:43:26', 3, 2, '2025-01-14 15:43:26', 3, 2),
	(5, 3, 0, 1, NULL, NULL, 0.00, NULL, '2025-01-21 22:41:12', 1, 1, '2025-01-21 22:41:12', 1, 1),
	(6, 3, 1, 1, NULL, NULL, 0.00, '', '2025-01-21 22:47:00', 1, 1, '2025-01-21 22:47:00', 1, 1),
	(7, 4, 0, 1, NULL, NULL, 0.00, NULL, '2025-01-21 23:42:24', 1, 1, '2025-01-21 23:42:24', 1, 1),
	(8, 5, 0, 1, NULL, NULL, 0.00, NULL, '2025-01-21 23:46:31', 1, 1, '2025-01-21 23:46:31', 1, 1);

-- Dumping structure for table greenlms.generalsetting
CREATE TABLE IF NOT EXISTS `generalsetting` (
  `optionkey` varchar(100) NOT NULL,
  `optionvalue` varchar(250) DEFAULT NULL,
  UNIQUE KEY `frontendkey` (`optionkey`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.generalsetting: ~16 rows (approximately)
INSERT INTO `generalsetting` (`optionkey`, `optionvalue`) VALUES
	('address', 'Jl Jend. Sudirman No. 21 Pedurungan Semarang Jawa Tengah'),
	('copyright_by', 'Perpustakaan'),
	('delivery_charge', '0'),
	('ebook_download', '1'),
	('email', 'admin@gmail.com'),
	('frontend', '1'),
	('logo', 'db56c739b986b678b346e00f79c8ea95dd147fe493518c7bd04aa57212f3b59e447057c9e32c4f1a763f738875c0dcd9b4a50d7d3e996bd2a8ad51551c58e1f9.png'),
	('paypal_payment_method', '0'),
	('phone', '08884018148'),
	('registration', '1'),
	('settheme', 'green'),
	('sitename', 'PERPUSTAKAAN'),
	('stripe_key', ''),
	('stripe_payment_method', '0'),
	('stripe_secret', ''),
	('web_address', 'http://localhost/greenlms/');

-- Dumping structure for table greenlms.income
CREATE TABLE IF NOT EXISTS `income` (
  `incomeID` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `file` varchar(200) DEFAULT NULL,
  `fileoriginalname` varchar(200) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `create_memberID` int NOT NULL,
  `create_roleID` int NOT NULL,
  `modify_date` datetime NOT NULL,
  `modify_memberID` int NOT NULL,
  `modify_roleID` int NOT NULL,
  PRIMARY KEY (`incomeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.income: ~2 rows (approximately)
INSERT INTO `income` (`incomeID`, `name`, `date`, `amount`, `file`, `fileoriginalname`, `note`, `create_date`, `create_memberID`, `create_roleID`, `modify_date`, `modify_memberID`, `modify_roleID`) VALUES
	(1, 'Biaya Denda', '2025-01-01 00:00:00', 8000.00, '', '', '', '2025-01-14 15:45:29', 3, 2, '2025-01-14 15:45:29', 3, 2),
	(2, 'Biaya Buku Hilang', '2025-01-01 00:00:00', 50000.00, '', '', '', '2025-01-14 15:45:50', 3, 2, '2025-01-14 15:45:50', 3, 2);

-- Dumping structure for table greenlms.libraryconfigure
CREATE TABLE IF NOT EXISTS `libraryconfigure` (
  `libraryconfigureID` int NOT NULL AUTO_INCREMENT,
  `roleID` int NOT NULL,
  `max_issue_book` int NOT NULL,
  `max_renewed_limit` int NOT NULL,
  `per_renew_limit_day` int NOT NULL,
  `book_fine_per_day` decimal(11,0) NOT NULL,
  `issue_off_limit_amount` decimal(11,0) NOT NULL,
  PRIMARY KEY (`libraryconfigureID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.libraryconfigure: ~4 rows (approximately)
INSERT INTO `libraryconfigure` (`libraryconfigureID`, `roleID`, `max_issue_book`, `max_renewed_limit`, `per_renew_limit_day`, `book_fine_per_day`, `issue_off_limit_amount`) VALUES
	(1, 1, 0, 0, 0, 0, 200),
	(2, 2, 0, 0, 0, 0, 150),
	(3, 3, 2, 2, 14, 1000, 100),
	(4, 4, 0, 0, 0, 0, 50);

-- Dumping structure for table greenlms.member
CREATE TABLE IF NOT EXISTS `member` (
  `memberID` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `dateofbirth` datetime DEFAULT NULL,
  `gender` varchar(15) DEFAULT NULL,
  `religion` varchar(30) DEFAULT NULL,
  `email` varchar(60) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `bloodgroup` varchar(20) NOT NULL,
  `address` text,
  `joinningdate` datetime DEFAULT NULL,
  `photo` varchar(200) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(128) NOT NULL,
  `roleID` int NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=New, 1=active, 2=Block',
  `deleted_at` tinyint DEFAULT '0' COMMENT '0 = Not Deleted, 1 = Deleted',
  `create_date` datetime NOT NULL,
  `create_memberID` int NOT NULL,
  `create_roleID` int NOT NULL,
  `modify_date` datetime NOT NULL,
  `modify_memberID` int NOT NULL,
  `modify_roleID` int NOT NULL,
  PRIMARY KEY (`memberID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table greenlms.member: ~4 rows (approximately)
INSERT INTO `member` (`memberID`, `name`, `dateofbirth`, `gender`, `religion`, `email`, `phone`, `bloodgroup`, `address`, `joinningdate`, `photo`, `username`, `password`, `roleID`, `status`, `deleted_at`, `create_date`, `create_memberID`, `create_roleID`, `modify_date`, `modify_memberID`, `modify_roleID`) VALUES
	(1, 'admin', '2025-01-01 00:00:00', 'Male', 'Islam', 'admin@admin.com', '08884018148', 'O+', 'Jl Gemah Kencana VI No 2 Gemah Pedurungan Semarang', '2025-01-01 00:00:00', '', 'admin', '0a030acac45b16fc1b9eaa25f8c7201cc316b70c581814c0c08cfba36720d21bd5cd636e547f079b57107df400eb186081f42b41928042a3bb18b73b4e612a68', 1, 1, 0, '2025-01-01 20:50:39', 1, 1, '2025-01-13 06:36:47', 1, 1),
	(2, 'librarian cantik', '2025-01-01 00:00:00', 'Female', 'Islam', 'librarian@gmail.com', '628884018148', 'O+', 'Semarang', '2025-01-01 00:00:00', 'default.png', 'librarian', '747fbf3a7bc7ddc272c209fc90574395517028de5b8e0f3967b55e2b4cf4fbc88e0ca483bff97a518f25df473b5e8da26ecd8efe31133cc1497631a8d11b774a', 2, 1, 0, '2025-01-01 21:51:27', 1, 1, '2025-01-01 21:51:27', 1, 1),
	(3, 'Petugas 001', '2025-01-01 00:00:00', 'Male', 'Islam', 'sasa@gmail.com', '085640565699', 'O+', '-', '2025-01-01 00:00:00', 'default.png', 'petugas', 'c99874f9b883033080cb607fbc372bf47c6a1678cc1d4eb7bc62207154e9171036c37cb73996608f739502a4e2646e26db3ddd0a4fccfbf1d7f26613e8d8866c', 2, 1, 0, '2025-01-13 06:39:48', 1, 1, '2025-01-13 06:39:48', 1, 1),
	(4, 'Susi Similikiti', '2025-01-01 00:00:00', 'Female', 'Islam', 'susi@gmail.com', '62888999111', 'O+', '-', '2025-01-01 00:00:00', '570fc63321fc07ffec6135e78030ebdf834cbb98f74853690c0570631a808962e1e531fe254affe4a564c019771b7272b02d221e94dee2d54df32adcbf271f70.png', 'susi', '5c01ca4b02065ccb46f1c5384aeec5ca99e96bc9da6af6b25676f4bf2ca872c336f163f6a0d330ec62465abab067f238b9d985ac3acc94fe983c12a4db69f850', 3, 1, 0, '2025-01-14 15:31:13', 0, 0, '2025-01-14 15:34:00', 1, 1);

-- Dumping structure for table greenlms.menu
CREATE TABLE IF NOT EXISTS `menu` (
  `menuID` int NOT NULL AUTO_INCREMENT,
  `menuname` varchar(128) NOT NULL,
  `menulink` varchar(128) NOT NULL,
  `menuicon` varchar(128) DEFAULT NULL,
  `priority` int NOT NULL DEFAULT '500',
  `parentmenuID` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`menuID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table greenlms.menu: ~39 rows (approximately)
INSERT INTO `menu` (`menuID`, `menuname`, `menulink`, `menuicon`, `priority`, `parentmenuID`, `status`) VALUES
	(1, 'dashboard', 'dashboard', 'fa fa-dashboard', 500, 0, 1),
	(2, 'bookissue', 'bookissue', 'fa lms-educational-book', 500, 0, 1),
	(3, 'member', 'member', 'fa fa-user-plus', 500, 0, 1),
	(4, 'ebook', 'ebook', 'fa lms-study', 500, 0, 1),
	(5, 'books', '#', 'fa lms-book', 500, 0, 1),
	(6, 'book', 'book', 'fa fa-book', 500, 5, 1),
	(7, 'rack', 'rack', 'fa lms-bookshelf', 500, 5, 1),
	(8, 'bookcategory', 'bookcategory', 'fa lms-notebook', 500, 5, 1),
	(9, 'bookbarcode', 'bookbarcode', 'fa fa-barcode', 500, 5, 1),
	(10, 'requestbook', 'requestbook', 'fa lms-professor', 500, 0, 1),
	(11, 'storemanagement', '#', 'fa fa-shopping-cart', 500, 0, 1),
	(12, 'order', 'order', 'fa fa-first-order', 500, 11, 1),
	(13, 'storebook', 'storebook', 'fa fa-book', 0, 11, 1),
	(14, 'storebookcategory', 'storebookcategory', 'fa lms-notebook', 0, 11, 1),
	(15, 'emailsend', 'emailsend', 'fa fa-envelope', 500, 0, 1),
	(16, 'account', '#', 'fa lms-merchant', 500, 0, 1),
	(17, 'income', 'income', 'fa lms-incomes', 500, 16, 1),
	(18, 'expense', 'expense', 'fa lms-salary', 500, 16, 1),
	(19, 'reports', '#', 'fa fa-clipboard', 500, 0, 1),
	(20, 'bookreport', 'bookreport', 'fa lms-library', 500, 19, 1),
	(21, 'bookissuereport', 'bookissuereport', 'fa lms-writing', 500, 19, 1),
	(22, 'memberreport', 'memberreport', 'fa lms-community', 500, 19, 1),
	(23, 'idcardreport', 'idcardreport', 'fa lms-id-card', 500, 19, 1),
	(24, 'transactionreport', 'transactionreport', 'fa fa-credit-card', 500, 19, 1),
	(25, 'bookbarcodereport', 'bookbarcodereport', 'fa fa-barcode', 0, 19, 1),
	(26, 'administrator', '#', 'fa fa-lock', 500, 0, 1),
	(27, 'menu', 'menu', 'fa fa-bars', 500, 26, 1),
	(28, 'role', 'role', 'fa fa-users', 500, 26, 1),
	(29, 'emailtemplate', 'emailtemplate', 'fa lms-template-design', 500, 26, 1),
	(30, 'permissions', 'permissions', 'fa fa-balance-scale', 500, 26, 1),
	(31, 'permissionlog', 'permissionlog', 'fa fa-key', 500, 26, 1),
	(32, 'update', 'update', 'fa fa-upload', 0, 26, 1),
	(33, 'backup', 'backup', 'fa fa-download', 0, 26, 1),
	(34, 'settings', '#', 'fa fa-cogs', 500, 0, 1),
	(35, 'generalsetting', 'generalsetting', 'fa fa-cog', 500, 34, 1),
	(36, 'emailsetting', 'emailsetting', 'fa lms-open-envelope', 500, 34, 1),
	(37, 'libraryconfigure', 'libraryconfigure', 'fa lms-settings', 500, 34, 1),
	(38, 'themesetting', 'themesetting', 'fa fa-paint-brush', 0, 34, 1),
	(39, 'paymentsetting', 'paymentsetting', 'fa fa-credit-card-alt', 0, 34, 1);

-- Dumping structure for table greenlms.newsletter
CREATE TABLE IF NOT EXISTS `newsletter` (
  `newsletterID` int NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `verify` int NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`newsletterID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table greenlms.newsletter: ~0 rows (approximately)

-- Dumping structure for table greenlms.orderitems
CREATE TABLE IF NOT EXISTS `orderitems` (
  `orderitemID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `orderID` bigint unsigned NOT NULL,
  `storebookID` bigint unsigned NOT NULL,
  `quantity` int unsigned NOT NULL,
  `unit_price` double(13,2) unsigned NOT NULL,
  `subtotal` double(13,2) unsigned NOT NULL,
  `create_date` timestamp NULL DEFAULT NULL,
  `modify_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`orderitemID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table greenlms.orderitems: ~0 rows (approximately)
INSERT INTO `orderitems` (`orderitemID`, `orderID`, `storebookID`, `quantity`, `unit_price`, `subtotal`, `create_date`, `modify_date`) VALUES
	(1, 1, 1, 1, 40000.00, 40000.00, '2025-01-14 04:33:07', '2025-01-14 04:33:07');

-- Dumping structure for table greenlms.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `orderID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `memberID` bigint unsigned NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_charge` double(13,2) unsigned NOT NULL,
  `subtotal` double(13,2) unsigned NOT NULL,
  `total` double(13,2) unsigned NOT NULL,
  `payment_status` tinyint unsigned NOT NULL COMMENT 'PAID=5, UNPAID=10',
  `payment_method` tinyint unsigned NOT NULL COMMENT 'CASH_ON_DELIVERY=5',
  `paid_amount` double(13,2) unsigned NOT NULL,
  `discounted_price` double(13,2) unsigned NOT NULL DEFAULT '0.00',
  `misc` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint unsigned NOT NULL COMMENT 'PENDING = 5, CANCEL = 10, REJECT = 15, ACCEPT = 20, PROCESS = 25, ON_THE_WAY = 30, COMPLETED = 35',
  `notes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_date` timestamp NULL DEFAULT NULL,
  `modify_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`orderID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table greenlms.orders: ~0 rows (approximately)
INSERT INTO `orders` (`orderID`, `memberID`, `name`, `address`, `mobile`, `email`, `delivery_charge`, `subtotal`, `total`, `payment_status`, `payment_method`, `paid_amount`, `discounted_price`, `misc`, `status`, `notes`, `create_date`, `modify_date`) VALUES
	(1, 1, 'Alex', 'Jakarta', '8884018148', 'alex@gmail.com', 0.00, 40000.00, 40000.00, 15, 5, 40000.00, 0.00, NULL, 30, '-', '2025-01-14 04:33:06', '2025-01-14 04:33:06');

-- Dumping structure for table greenlms.paymentanddiscount
CREATE TABLE IF NOT EXISTS `paymentanddiscount` (
  `paymentanddiscountID` int NOT NULL AUTO_INCREMENT,
  `bookissueID` int NOT NULL,
  `paymentamount` decimal(10,2) NOT NULL,
  `discountamount` decimal(10,2) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL,
  `create_memberID` int NOT NULL,
  `create_roleID` int NOT NULL,
  `modify_date` datetime NOT NULL,
  `modify_memberID` int NOT NULL,
  `modify_roleID` int NOT NULL,
  PRIMARY KEY (`paymentanddiscountID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.paymentanddiscount: ~2 rows (approximately)
INSERT INTO `paymentanddiscount` (`paymentanddiscountID`, `bookissueID`, `paymentamount`, `discountamount`, `notes`, `create_date`, `create_memberID`, `create_roleID`, `modify_date`, `modify_memberID`, `modify_roleID`) VALUES
	(1, 1, 8000.00, 0.00, '', '2025-01-14 15:38:59', 3, 2, '2025-01-14 15:38:59', 3, 2),
	(2, 2, 50000.00, 0.00, '', '2025-01-14 15:44:23', 3, 2, '2025-01-14 15:44:23', 3, 2);

-- Dumping structure for table greenlms.permissionlog
CREATE TABLE IF NOT EXISTS `permissionlog` (
  `permissionlogID` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `active` enum('yes','no') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`permissionlogID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table greenlms.permissionlog: ~95 rows (approximately)
INSERT INTO `permissionlog` (`permissionlogID`, `name`, `description`, `active`) VALUES
	(1, 'dashboard', 'Dashboard', 'yes'),
	(2, 'bookissue', 'Book Issue', 'yes'),
	(3, 'bookissue_add', 'Book Issue Add', 'yes'),
	(4, 'bookissue_edit', 'Book Issue Edit', 'yes'),
	(5, 'bookissue_view', 'Book Issue View', 'yes'),
	(6, 'bookissue_delete', 'Book Issue Delete', 'yes'),
	(7, 'member', 'Member', 'yes'),
	(8, 'member_add', 'Member Add', 'yes'),
	(9, 'member_edit', 'Member Edit', 'yes'),
	(10, 'member_view', 'Member View', 'yes'),
	(11, 'member_delete', 'Member Delete', 'yes'),
	(12, 'ebook', 'Ebook', 'yes'),
	(13, 'ebook_add', 'Ebook Add', 'yes'),
	(14, 'ebook_edit', 'Ebook Edit', 'yes'),
	(15, 'ebook_view', 'Ebook View', 'yes'),
	(16, 'ebook_delete', 'Ebook Delete', 'yes'),
	(17, 'book', 'Book', 'yes'),
	(18, 'book_add', 'Book Add', 'yes'),
	(19, 'book_edit', 'Book Edit', 'yes'),
	(20, 'book_delete', 'Book Delete', 'yes'),
	(21, 'book_view', 'Book View', 'yes'),
	(22, 'rack', 'Rack', 'yes'),
	(23, 'rack_add', 'Rack Add', 'yes'),
	(24, 'rack_edit', 'Rack Edit', 'yes'),
	(25, 'rack_delete', 'Rack Delete', 'yes'),
	(26, 'bookcategory', 'Bool Category', 'yes'),
	(27, 'bookcategory_add', 'Book Category Add', 'yes'),
	(28, 'bookcategory_edit', 'Book Category Edit', 'yes'),
	(29, 'bookcategory_delete', 'Book Category Delete', 'yes'),
	(30, 'requestbook', 'Request Book', 'yes'),
	(31, 'requestbook_add', 'Request Book Add', 'yes'),
	(32, 'requestbook_edit', 'Request Book Edit', 'yes'),
	(33, 'requestbook_view', 'Request Book View', 'yes'),
	(34, 'requestbook_delete', 'Request Book Delete', 'yes'),
	(35, 'emailsend', 'emailsend', 'yes'),
	(36, 'emailsend_add', 'Emailsend Add', 'yes'),
	(37, 'emailsend_view', 'Emailsend View', 'yes'),
	(38, 'emailsend_delete', 'Emailsend Delete', 'yes'),
	(39, 'income', 'Income', 'yes'),
	(40, 'income_add', 'Income Add', 'yes'),
	(41, 'income_edit', 'Income Edit', 'yes'),
	(42, 'income_delete', 'Income Delete', 'yes'),
	(43, 'expense', 'Expense', 'yes'),
	(44, 'expense_add', 'Expense Add', 'yes'),
	(45, 'expense_edit', 'Expense Edit', 'yes'),
	(46, 'expense_delete', 'Expense Delete', 'yes'),
	(47, 'bookreport', 'Book Report', 'yes'),
	(48, 'bookissuereport', 'Book Issue Report', 'yes'),
	(49, 'memberreport', 'Member Report', 'yes'),
	(50, 'idcardreport', 'ID Card Report', 'yes'),
	(51, 'transactionreport', 'Transaction Report', 'yes'),
	(52, 'menu', 'Menu', 'yes'),
	(53, 'menu_add', 'Menu Add', 'yes'),
	(54, 'menu_edit', 'Menu Edit', 'yes'),
	(55, 'menu_delete', 'Menu Delete', 'yes'),
	(56, 'role', 'Role', 'yes'),
	(57, 'role_add', 'Role Add', 'yes'),
	(58, 'role_edit', 'Role Edit', 'yes'),
	(59, 'role_delete', 'Role Delete', 'yes'),
	(60, 'emailsetting', 'Email Setting', 'yes'),
	(61, 'emailtemplate', 'Email template', 'yes'),
	(62, 'emailtemplate_add', 'Email Template Add', 'yes'),
	(63, 'emailtemplate_edit', 'Email Template Edit', 'yes'),
	(64, 'emailtemplate_delete', 'Email Template Delete', 'yes'),
	(65, 'emailtemplate_view', 'Email Template', 'yes'),
	(66, 'permissions', 'Permissions', 'yes'),
	(67, 'permissionlog', 'Permissionlog', 'yes'),
	(68, 'permissionlog_add', 'Permissionlog', 'yes'),
	(69, 'permissionlog_edit', 'Permissionlog', 'yes'),
	(70, 'permissionlog_delete', 'Permissionlog', 'yes'),
	(71, 'generalsetting', 'General Setting', 'yes'),
	(73, 'libraryconfigure', 'Library Configure', 'yes'),
	(74, 'libraryconfigure_add', 'Library Configure Add', 'yes'),
	(75, 'libraryconfigure_edit', 'Library Configure Edit', 'yes'),
	(76, 'libraryconfigure_delete', 'Library Configure Delete', 'yes'),
	(77, 'themesetting', 'Theme Setting', 'yes'),
	(78, 'backup', 'Backup', 'yes'),
	(79, 'update', 'Update', 'yes'),
	(80, 'bookbarcodereport', 'Book Barcode Report', 'yes'),
	(81, 'bookbarcode', 'Book Barcode', 'yes'),
	(82, 'smssetting', 'SMS Setting', 'yes'),
	(83, 'storebookcategory', 'Store Book Category', 'yes'),
	(84, 'storebookcategory_add', 'Store Book Category Add', 'yes'),
	(85, 'storebookcategory_edit', 'Store Book Category Edit', 'yes'),
	(86, 'storebookcategory_view', 'Store Book Category View', 'yes'),
	(87, 'storebookcategory_delete', 'Store Book Category Delete', 'yes'),
	(88, 'storebook', 'Store Book', 'yes'),
	(89, 'storebook_add', 'Store Book Add', 'yes'),
	(90, 'storebook_edit', 'Store Book Edit', 'yes'),
	(91, 'storebook_view', 'Store Book View', 'yes'),
	(92, 'storebook_delete', 'Store Book Delete', 'yes'),
	(93, 'order', 'Order', 'yes'),
	(94, 'order_view', 'Order View', 'yes'),
	(95, 'order_edit', 'Order Edit', 'yes'),
	(96, 'paymentsetting', 'Payment Setting', 'yes');

-- Dumping structure for table greenlms.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `permissionlogID` int NOT NULL,
  `roleID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table greenlms.permissions: ~186 rows (approximately)
INSERT INTO `permissions` (`permissionlogID`, `roleID`) VALUES
	(1, 1),
	(2, 1),
	(3, 1),
	(4, 1),
	(6, 1),
	(5, 1),
	(7, 1),
	(8, 1),
	(9, 1),
	(11, 1),
	(10, 1),
	(12, 1),
	(13, 1),
	(14, 1),
	(16, 1),
	(15, 1),
	(17, 1),
	(18, 1),
	(19, 1),
	(20, 1),
	(21, 1),
	(22, 1),
	(23, 1),
	(24, 1),
	(25, 1),
	(26, 1),
	(27, 1),
	(28, 1),
	(29, 1),
	(30, 1),
	(31, 1),
	(32, 1),
	(34, 1),
	(33, 1),
	(35, 1),
	(36, 1),
	(38, 1),
	(37, 1),
	(39, 1),
	(40, 1),
	(41, 1),
	(42, 1),
	(43, 1),
	(44, 1),
	(45, 1),
	(46, 1),
	(47, 1),
	(48, 1),
	(49, 1),
	(50, 1),
	(51, 1),
	(52, 1),
	(53, 1),
	(54, 1),
	(55, 1),
	(56, 1),
	(57, 1),
	(58, 1),
	(59, 1),
	(60, 1),
	(61, 1),
	(62, 1),
	(63, 1),
	(64, 1),
	(65, 1),
	(66, 1),
	(67, 1),
	(68, 1),
	(69, 1),
	(70, 1),
	(71, 1),
	(73, 1),
	(74, 1),
	(75, 1),
	(76, 1),
	(77, 1),
	(78, 1),
	(79, 1),
	(80, 1),
	(81, 1),
	(82, 1),
	(83, 1),
	(84, 1),
	(85, 1),
	(87, 1),
	(86, 1),
	(88, 1),
	(89, 1),
	(90, 1),
	(92, 1),
	(91, 1),
	(93, 1),
	(95, 1),
	(94, 1),
	(96, 1),
	(1, 2),
	(2, 2),
	(3, 2),
	(4, 2),
	(6, 2),
	(5, 2),
	(7, 2),
	(8, 2),
	(9, 2),
	(10, 2),
	(12, 2),
	(13, 2),
	(14, 2),
	(16, 2),
	(15, 2),
	(17, 2),
	(18, 2),
	(19, 2),
	(20, 2),
	(21, 2),
	(22, 2),
	(23, 2),
	(24, 2),
	(25, 2),
	(26, 2),
	(27, 2),
	(28, 2),
	(29, 2),
	(30, 2),
	(31, 2),
	(32, 2),
	(34, 2),
	(33, 2),
	(35, 2),
	(36, 2),
	(38, 2),
	(37, 2),
	(39, 2),
	(40, 2),
	(41, 2),
	(42, 2),
	(43, 2),
	(44, 2),
	(45, 2),
	(46, 2),
	(47, 2),
	(48, 2),
	(49, 2),
	(50, 2),
	(51, 2),
	(80, 2),
	(81, 2),
	(83, 2),
	(84, 2),
	(85, 2),
	(87, 2),
	(86, 2),
	(88, 2),
	(89, 2),
	(90, 2),
	(92, 2),
	(91, 2),
	(93, 2),
	(95, 2),
	(94, 2),
	(1, 3),
	(2, 3),
	(5, 3),
	(7, 3),
	(10, 3),
	(12, 3),
	(15, 3),
	(17, 3),
	(21, 3),
	(22, 3),
	(26, 3),
	(30, 3),
	(31, 3),
	(32, 3),
	(34, 3),
	(33, 3),
	(35, 3),
	(36, 3),
	(37, 3),
	(81, 3),
	(83, 3),
	(86, 3),
	(88, 3),
	(91, 3),
	(93, 3),
	(94, 3);

-- Dumping structure for table greenlms.rack
CREATE TABLE IF NOT EXISTS `rack` (
  `rackID` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `create_date` datetime NOT NULL,
  `create_memberID` int NOT NULL,
  `create_roleID` int NOT NULL,
  `modify_date` datetime NOT NULL,
  `modify_memberID` int NOT NULL,
  `modify_roleID` int NOT NULL,
  PRIMARY KEY (`rackID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.rack: ~2 rows (approximately)
INSERT INTO `rack` (`rackID`, `name`, `description`, `create_date`, `create_memberID`, `create_roleID`, `modify_date`, `modify_memberID`, `modify_roleID`) VALUES
	(1, '100', 'Filasat', '2025-01-14 11:16:15', 1, 1, '2025-01-14 11:16:15', 1, 1),
	(2, '200', 'Komputer', '2025-01-14 11:16:31', 1, 1, '2025-01-14 11:16:31', 1, 1);

-- Dumping structure for table greenlms.requestbook
CREATE TABLE IF NOT EXISTS `requestbook` (
  `requestbookID` int NOT NULL AUTO_INCREMENT,
  `memberID` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `coverphoto` varchar(200) NOT NULL,
  `bookcategoryID` int NOT NULL,
  `isbnno` varchar(100) DEFAULT NULL,
  `editionnumber` varchar(50) DEFAULT NULL,
  `editiondate` date DEFAULT NULL,
  `publisher` varchar(50) DEFAULT NULL,
  `publisheddate` date DEFAULT NULL,
  `notes` text,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0= Request Book, 1= Request Book Accepet, 2= Request Book Rejected',
  `deleted_at` tinyint NOT NULL DEFAULT '0' COMMENT '0= Request Book Not Deleted, 1=Request Book Deleted ',
  `create_date` datetime NOT NULL,
  `create_memberID` int NOT NULL,
  `create_roleID` int NOT NULL,
  `modify_date` datetime NOT NULL,
  `modify_memberID` int NOT NULL,
  `modify_roleID` int NOT NULL,
  PRIMARY KEY (`requestbookID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.requestbook: ~0 rows (approximately)

-- Dumping structure for table greenlms.resetpassword
CREATE TABLE IF NOT EXISTS `resetpassword` (
  `resetpasswordID` int NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `code` varchar(11) NOT NULL,
  `memberID` int NOT NULL,
  `roleID` int NOT NULL,
  `create_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL,
  PRIMARY KEY (`resetpasswordID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.resetpassword: ~0 rows (approximately)

-- Dumping structure for table greenlms.role
CREATE TABLE IF NOT EXISTS `role` (
  `roleID` int unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(30) NOT NULL,
  `create_date` datetime NOT NULL,
  `create_memberID` int NOT NULL,
  `create_roleID` int NOT NULL,
  `modify_date` datetime NOT NULL,
  `modify_memberID` int NOT NULL,
  `modify_roleID` int NOT NULL,
  PRIMARY KEY (`roleID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table greenlms.role: ~4 rows (approximately)
INSERT INTO `role` (`roleID`, `role`, `create_date`, `create_memberID`, `create_roleID`, `modify_date`, `modify_memberID`, `modify_roleID`) VALUES
	(1, 'Admin', '2019-09-25 20:19:22', 1, 1, '2019-09-25 20:19:22', 1, 1),
	(2, 'Librarian', '2019-09-25 20:19:32', 1, 1, '2020-01-29 23:32:27', 1, 1),
	(3, 'Member', '2019-09-25 20:19:39', 1, 1, '2019-11-03 00:03:22', 1, 1),
	(4, 'Customer', '2019-12-10 20:38:31', 1, 1, '2019-12-10 20:38:31', 1, 1);

-- Dumping structure for table greenlms.storebook
CREATE TABLE IF NOT EXISTS `storebook` (
  `storebookID` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `storebookcategoryID` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `isbnno` varchar(100) NOT NULL,
  `coverphoto` varchar(200) NOT NULL,
  `codeno` varchar(100) NOT NULL,
  `editionnumber` varchar(100) NOT NULL,
  `editiondate` datetime DEFAULT NULL,
  `publisher` varchar(100) NOT NULL,
  `publisheddate` datetime DEFAULT NULL,
  `notes` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint NOT NULL COMMENT '0= Book Available, 1= Book Not Available',
  `deleted_at` tinyint NOT NULL COMMENT '0= Book Available, 1=Book Deleted ',
  `create_date` datetime NOT NULL,
  `create_memberID` int NOT NULL,
  `modify_date` datetime NOT NULL,
  `modify_memberID` int NOT NULL,
  PRIMARY KEY (`storebookID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.storebook: ~0 rows (approximately)
INSERT INTO `storebook` (`storebookID`, `name`, `author`, `storebookcategoryID`, `quantity`, `price`, `isbnno`, `coverphoto`, `codeno`, `editionnumber`, `editiondate`, `publisher`, `publisheddate`, `notes`, `description`, `status`, `deleted_at`, `create_date`, `create_memberID`, `modify_date`, `modify_memberID`) VALUES
	(1, 'Bahasa Inggris Dasar Untuk Mahasiswa', '-', 1, 3, 40000.00, '12345677', 'c6c82b8b2fedc4f2d0c5a4bbbc8d4fdcecaa62ba6c64c053bf0e4c1684a49b8a8051e354b98f0670e18eafef426dcf5e7529904f132883d2f09f198c3bdce65d.png', '100.100.0001', '1', '2025-01-07 00:00:00', 'UN Press', '2025-01-07 00:00:00', '-', '-', 0, 0, '2025-01-14 11:31:14', 1, '2025-01-14 11:31:14', 1);

-- Dumping structure for table greenlms.storebookcategory
CREATE TABLE IF NOT EXISTS `storebookcategory` (
  `storebookcategoryID` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `coverphoto` varchar(255) NOT NULL,
  `status` tinyint NOT NULL,
  `create_date` datetime NOT NULL,
  `create_memberID` int NOT NULL,
  `modify_date` datetime NOT NULL,
  `modify_memberID` int NOT NULL,
  PRIMARY KEY (`storebookcategoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.storebookcategory: ~0 rows (approximately)
INSERT INTO `storebookcategory` (`storebookcategoryID`, `name`, `description`, `coverphoto`, `status`, `create_date`, `create_memberID`, `modify_date`, `modify_memberID`) VALUES
	(1, 'Buku Komputer', '-', 'storebookcategory.jpg', 1, '2025-01-13 06:44:41', 3, '2025-01-13 06:44:41', 3);

-- Dumping structure for table greenlms.storebookimage
CREATE TABLE IF NOT EXISTS `storebookimage` (
  `storebookimageID` int NOT NULL AUTO_INCREMENT,
  `storebookID` int NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `meta` text NOT NULL,
  PRIMARY KEY (`storebookimageID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.storebookimage: ~0 rows (approximately)

-- Dumping structure for table greenlms.updates
CREATE TABLE IF NOT EXISTS `updates` (
  `updateID` int NOT NULL AUTO_INCREMENT,
  `version` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `memberID` int NOT NULL,
  `status` tinyint NOT NULL,
  `description` text,
  PRIMARY KEY (`updateID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table greenlms.updates: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
