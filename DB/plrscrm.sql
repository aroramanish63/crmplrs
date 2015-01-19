-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2015 at 07:03 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `plrscrm`
--

-- --------------------------------------------------------

--
-- Table structure for table `plrs_complaint`
--

CREATE TABLE IF NOT EXISTS `plrs_complaint` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contactno` varchar(30) NOT NULL,
  `address` varchar(500) NOT NULL,
  `complaint_type` tinyint(10) NOT NULL,
  `ticket_no` varchar(30) NOT NULL,
  `complaint_remarks` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `add_date` datetime NOT NULL,
  `closed_by` int(11) NOT NULL,
  `update_date` datetime NOT NULL,
  `counseller_stateco_id` int(11) NOT NULL,
  `case_cordinator_id` int(11) NOT NULL,
  `sdm_id` int(11) NOT NULL,
  `is_counseller` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '''1''=>''counseller'',''2''=>''State Coordinator''',
  `status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '''0''=>open,''1''=>''close''',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `plrs_complaint`
--

INSERT INTO `plrs_complaint` (`id`, `name`, `email`, `contactno`, `address`, `complaint_type`, `ticket_no`, `complaint_remarks`, `created_by`, `add_date`, `closed_by`, `update_date`, `counseller_stateco_id`, `case_cordinator_id`, `sdm_id`, `is_counseller`, `status`) VALUES
(1, 'Manish', 'aroramanish63@gmail.com', '7845123695', 'Tester', 1, '150107PLRS0001', 'Tester', 1, '2015-01-07 20:24:59', 0, '0000-00-00 00:00:00', 0, 0, 0, '0', '0'),
(2, 'Pankaj', 'pankaj.garg@cyfuture.com', '9636852412', 'Mansarovar Jaipur', 1, '150109PLRS0001', 'For Testing Only', 1, '2015-01-09 11:49:57', 0, '0000-00-00 00:00:00', 3, 7, 0, '1', '0'),
(3, 'Praveen Singh', 'praveen.singh@cyfuture.com', '9950676200', 'Uttar Pradesh', 2, '150110PLRS0001', 'Want more property', 1, '2015-01-10 17:55:37', 0, '0000-00-00 00:00:00', 0, 0, 0, '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `plrs_complaint_type`
--

CREATE TABLE IF NOT EXISTS `plrs_complaint_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `complaint_type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `plrs_complaint_type`
--

INSERT INTO `plrs_complaint_type` (`id`, `complaint_type`) VALUES
(1, 'Complaint'),
(2, 'Feedback');

-- --------------------------------------------------------

--
-- Table structure for table `plrs_user_comment`
--

CREATE TABLE IF NOT EXISTS `plrs_user_comment` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `created_by` bigint(11) NOT NULL,
  `user_group` int(11) NOT NULL,
  `complaint_id` bigint(11) NOT NULL,
  `remarks` text NOT NULL,
  `is_open` enum('0','1') NOT NULL DEFAULT '0' COMMENT '''0''=>''Open'',''1''=>''Close''',
  `add_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `plrs_user_comment`
--

INSERT INTO `plrs_user_comment` (`id`, `created_by`, `user_group`, `complaint_id`, `remarks`, `is_open`, `add_date`) VALUES
(1, 3, 3, 2, 'Testing ', '0', '2015-01-14 12:17:31'),
(2, 7, 5, 2, 'Transferred to SDM2. Please check SDM2', '0', '2015-01-14 13:01:32');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_clearance_bank`
--

CREATE TABLE IF NOT EXISTS `tbl_clearance_bank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(500) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '''0''=>''Inactive'',''1''=>''Active''',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_clearance_bills`
--

CREATE TABLE IF NOT EXISTS `tbl_clearance_bills` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `bill_description` text NOT NULL,
  `clearance_status_id` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `isThread` enum('0','1') NOT NULL DEFAULT '1' COMMENT '''0''=>''Open'',''1''=>''Close''',
  `status` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_clearance_comment`
--

CREATE TABLE IF NOT EXISTS `tbl_clearance_comment` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `created_by` bigint(11) NOT NULL,
  `user_group` int(11) NOT NULL,
  `complaint_id` bigint(11) NOT NULL,
  `comments` text NOT NULL,
  `is_approved` enum('0','1') NOT NULL DEFAULT '0',
  `add_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_clearance_payment`
--

CREATE TABLE IF NOT EXISTS `tbl_clearance_payment` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `clearance_id` int(11) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `paymentby` varchar(255) NOT NULL,
  `payment_no` varchar(200) NOT NULL COMMENT 'for dd no or cheque no',
  `amount` varchar(200) NOT NULL,
  `paymentdate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_clearance_payment_mode`
--

CREATE TABLE IF NOT EXISTS `tbl_clearance_payment_mode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mode_name` varchar(255) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '''0''=>''Inactive'',''1''=>''Active''',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_clearance_ques`
--

CREATE TABLE IF NOT EXISTS `tbl_clearance_ques` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `clearance_id` bigint(11) NOT NULL,
  `ask_by` int(11) NOT NULL,
  `remarks` text NOT NULL,
  `add_date` datetime NOT NULL,
  `thread_closed` enum('0','1') NOT NULL DEFAULT '0' COMMENT '''0''=>''Thread Open'',''1''=>''Thread Close''',
  `status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '''0''=>''Inactive Thread'',''1''=>''Active Thread''',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_clearance_status`
--

CREATE TABLE IF NOT EXISTS `tbl_clearance_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clearance_type` varchar(200) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '''0''=>''Inactive'',''1''=>''Active''',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_clearance_upload`
--

CREATE TABLE IF NOT EXISTS `tbl_clearance_upload` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `clearance_id` bigint(11) NOT NULL,
  `upload_file_path` text NOT NULL,
  `add_date` datetime NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `user_group` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile_no` varchar(12) NOT NULL,
  `address` text NOT NULL,
  `pass_changed` int(11) NOT NULL DEFAULT '0',
  `pass_modified_date` datetime NOT NULL,
  `add_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '''0''=>''Inactive'',''1''=>''Active''',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `username`, `password`, `user_group`, `name`, `email`, `mobile_no`, `address`, `pass_changed`, `pass_modified_date`, `add_date`, `update_date`, `status`) VALUES
(1, 'manish', '59c95189ac895fcc1c6e1c38d067e244', 1, 'Manish Arora', 'manish.arora@cyfuture.com', '1234567890', 'Jaipur', 0, '2015-01-10 14:17:47', '2014-10-30 03:20:11', '2015-01-10 16:18:08', '1'),
(2, 'admin', '21232f297a57a5a743894a0e4a801fc3', 2, 'Admin', 'admin@cyfuture.com', '7845123695', 'Opposite Jaipur National University1', 0, '0000-00-00 00:00:00', '2014-10-30 02:21:27', '2014-10-30 19:32:20', '1'),
(3, 'Counsellor1', '59c95189ac895fcc1c6e1c38d067e244', 3, 'Counsellor1', 'aroramanish63@gmail.com', '7845123695', 'Cyfuture', 1, '2015-01-12 15:19:03', '2014-10-31 18:25:16', '2015-01-12 15:19:59', '1'),
(4, 'stateco', '59c95189ac895fcc1c6e1c38d067e244', 4, 'stateco', 'tester@gmail.com', '7845123695', 'Jaipur\r\n', 0, '2015-01-10 14:18:21', '2014-10-31 20:18:45', '2015-01-12 13:03:57', '1'),
(5, 'caseco2', '59c95189ac895fcc1c6e1c38d067e244', 5, 'caseco2', 'aroramanish63@gmail.com', '7845123695', 'Jaipur', 0, '0000-00-00 00:00:00', '2014-10-31 20:33:48', '2015-01-12 13:04:22', '1'),
(6, 'testverifier', '59c95189ac895fcc1c6e1c38d067e244', 3, 'testverifier', 'manish.arora@cyfuture.com', '4561239635', 'Jaipur', 3, '2015-01-12 15:20:33', '2014-11-04 20:18:39', '2015-01-09 12:54:05', '1'),
(7, 'casecoordinator1', '59c95189ac895fcc1c6e1c38d067e244', 5, 'casecoordinator1', 'case@cyfuture.com', '1234567895', 'Jaipur', 0, '0000-00-00 00:00:00', '2015-01-12 13:02:49', '0000-00-00 00:00:00', '1'),
(8, 'sdm1', '59c95189ac895fcc1c6e1c38d067e244', 6, 'sdm', 'sdm@gmail.com', '4561239875', 'Jaipur', 0, '0000-00-00 00:00:00', '2015-01-12 13:05:15', '0000-00-00 00:00:00', '1'),
(9, 'stateco2', '59c95189ac895fcc1c6e1c38d067e244', 4, 'stateco2', 'state@gmail.com', '1236547895', 'Jaipur', 0, '0000-00-00 00:00:00', '2015-01-12 13:07:50', '0000-00-00 00:00:00', '1'),
(10, 'sdm2', '59c95189ac895fcc1c6e1c38d067e244', 6, 'sdm2', 'sdm2@gmail.com', '3625147895', 'Jaipur', 0, '0000-00-00 00:00:00', '2015-01-12 13:08:37', '0000-00-00 00:00:00', '1'),
(11, 'callcenter1', '59c95189ac895fcc1c6e1c38d067e244', 7, 'call center', 'callcenter@gmail.com', '4512369578', 'Jaipur', 0, '0000-00-00 00:00:00', '2015-01-14 12:26:52', '0000-00-00 00:00:00', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_usergroup`
--

CREATE TABLE IF NOT EXISTS `tbl_usergroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) NOT NULL,
  `group_description` text NOT NULL,
  `role_id` text NOT NULL,
  `transferred_to` text NOT NULL,
  `level` int(11) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` date NOT NULL,
  `is_deleted` enum('1','0') NOT NULL DEFAULT '0',
  `status` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `group_name` (`group_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tbl_usergroup`
--

INSERT INTO `tbl_usergroup` (`id`, `group_name`, `group_description`, `role_id`, `transferred_to`, `level`, `created_by`, `created_date`, `is_deleted`, `status`) VALUES
(1, 'Super Admin', 'Manage all modules', '1,2,3,4,5,6,7,8,9,10,11,12,13,15,16,17,18,19,20,21', '', -1, '1', '2014-10-30', '0', '1'),
(2, 'Admin', 'Right to upload bills and other documents and send it to particular verifier PENDING', '1,2,7,8,9,10,11', '1', 0, '1', '2014-10-30', '0', '1'),
(3, 'Counsellor', 'View the open complaints and feedback', '7,8,10', '5', 1, '1', '2014-10-30', '0', '1'),
(4, 'State Co-ordinator', 'Forward Complaints to case co-ordinator or SDM', '7,8,10', '5,6', 1, '1', '2014-10-30', '0', '1'),
(5, 'Case Co-ordinator', 'Case Co-ordinator reads the complaint and forward to concerned SDM.\r\n', '7,8,10', '6', 2, '1', '2014-10-30', '0', '1'),
(6, 'SDM', 'After Investigation, SDM enters findings in the System using his/her login id.\r\nSend information status to case co-ordinator.', '7,8,10', '', 3, '1', '2015-01-12', '0', '1'),
(7, 'Call Centre Staff', 'Fills the form related to feedback / complaint.\r\nGet Complaint Status and update to customer.', '7,8,9,10', '7', 4, '1', '2015-01-12', '0', '1'),
(8, 'tester', 'Tester', '5', '2,3,4,5,6,7', 6, '1', '2015-01-17', '0', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_userrole`
--

CREATE TABLE IF NOT EXISTS `tbl_userrole` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  `page_name` varchar(50) NOT NULL,
  `parentId` int(11) NOT NULL DEFAULT '0',
  `role_description` text NOT NULL,
  `add_date` datetime NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `tbl_userrole`
--

INSERT INTO `tbl_userrole` (`id`, `role_name`, `page_name`, `parentId`, `role_description`, `add_date`, `status`) VALUES
(1, 'User Management', 'userManagement', 0, 'Listing of User', '2014-10-09 17:36:39', '1'),
(2, 'Add User', 'addUser', 1, 'Add User in User management module', '2014-10-09 17:38:50', '1'),
(3, 'User Group', 'userGroup', 1, 'Listing of user groups', '2014-10-09 17:39:48', '1'),
(4, 'Add User Group', 'adduserGroup', 3, 'Add user groups', '2014-10-09 17:40:19', '1'),
(5, 'User Roles', 'userRole', 1, 'Listing of user roles', '2014-10-09 17:40:49', '1'),
(6, 'Add Role', 'adduserRole', 5, 'Add roles', '2014-10-09 17:42:59', '1'),
(7, 'User Profile', 'userProfile', 0, 'View and Update user profile\r\n', '2014-10-09 20:25:49', '1'),
(8, 'View Complaints', 'viewComplaints', 0, 'Display all Complaints Listings', '2014-10-10 22:02:06', '1'),
(9, 'Add Complaints', 'addComplaints', 8, 'Add Complaints', '2014-10-10 22:02:49', '1'),
(10, 'Edit Complaints', 'editComplaints', 8, 'Edit Complaints', '2014-10-10 22:04:03', '1'),
(11, 'Edit User', 'editUser', 1, 'Edit User details', '2014-10-14 20:11:00', '1'),
(12, 'Edit User Group', 'edituserGroup', 3, 'Edit User Group', '2014-10-14 20:11:41', '1'),
(13, 'Edit User Role', 'edituserRole', 5, 'Edit User Role', '2014-10-14 20:12:12', '1'),
(14, 'Report Management', 'exportreport', 0, 'For Report Management Module', '2014-10-15 12:18:21', '1'),
(15, 'Payment Mode', 'paymode', 0, 'View listing of mode of Payment', '2014-12-01 13:45:14', '1'),
(16, 'Add Payment Mode', 'addpaymode', 0, 'Add Payment Mode', '2014-12-01 13:45:42', '1'),
(17, 'Edit Payment Mode', 'editpaymode', 0, 'Edit payment mode', '2014-12-01 13:48:10', '1'),
(18, 'Banks', 'viewBanks', 0, 'View Banks Listing', '2014-12-01 13:48:56', '1'),
(19, 'Add Bank', 'addBank', 0, 'Add Bank detail', '2014-12-01 13:49:18', '1'),
(20, 'Edit Bank', 'editBank', 0, 'Edit Bank details', '2014-12-01 13:49:47', '1'),
(21, 'Reset Password', 'resetPassword', 1, 'Reset Password of any user', '2015-01-10 12:56:01', '1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
