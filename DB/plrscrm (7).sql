-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2015 at 07:28 PM
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
-- Table structure for table `plrs_caller_type`
--

CREATE TABLE IF NOT EXISTS `plrs_caller_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caller_type` varchar(255) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `plrs_caller_type`
--

INSERT INTO `plrs_caller_type` (`id`, `caller_type`, `status`) VALUES
(1, 'Domestic', '1'),
(2, 'NRI', '1');

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
  `city` varchar(255) NOT NULL,
  `district` int(11) NOT NULL,
  `tehsil` int(11) NOT NULL,
  `sub_tehsil` int(11) NOT NULL,
  `country` int(11) NOT NULL,
  `complaint_type` tinyint(10) NOT NULL,
  `caller_type` int(11) NOT NULL,
  `ticket_no` varchar(30) NOT NULL,
  `complaint_remarks` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `add_date` datetime NOT NULL,
  `closed_by` int(11) NOT NULL,
  `update_date` datetime NOT NULL,
  `callcenter_id` int(11) NOT NULL,
  `counseller_stateco_id` int(11) NOT NULL,
  `sdm_id` int(11) NOT NULL,
  `is_counseller` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '''1''=>''counseller'',''2''=>''State Coordinator''',
  `status` enum('0','1','2','3','4') NOT NULL DEFAULT '0' COMMENT '''0''=>open,''1''=>''close'',''2''=>''Forwarded'',''3''=>''Assign/Under Process'',''4''=>''Completed''',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `plrs_complaint`
--

INSERT INTO `plrs_complaint` (`id`, `name`, `email`, `contactno`, `address`, `city`, `district`, `tehsil`, `sub_tehsil`, `country`, `complaint_type`, `caller_type`, `ticket_no`, `complaint_remarks`, `created_by`, `add_date`, `closed_by`, `update_date`, `callcenter_id`, `counseller_stateco_id`, `sdm_id`, `is_counseller`, `status`) VALUES
(1, 'Manish', 'manish@gmail.com', '7845123695', 'Barnala', 'Alwar', 14, 54, 0, 99, 3, 1, '150207PLRS0001', 'Enquiry Only', 11, '2015-02-07 19:50:29', 0, '0000-00-00 00:00:00', 0, 0, 0, '0', '1'),
(2, 'John', 'john@gmail.com', '7894561236', 'Nawanshahr', 'CA', 8, 26, 0, 14, 2, 2, '150207PLRS0002', ' Feedback Updated.', 11, '2015-02-07 20:10:31', 0, '0000-00-00 00:00:00', 0, 0, 0, '0', '0'),
(3, 'Ritesh', 'ritesh.chippa@cyfuture.com', '7845123695', 'Sanganer', 'Sanganer', 9, 30, 0, 99, 1, 1, '150209PLRS0001', ' Testing COmplaints', 11, '2015-02-09 13:37:59', 0, '0000-00-00 00:00:00', 11, 9, 8, '2', '1'),
(4, 'sdfge', 'sdgd@gsdj.com', '4645756786', 'jkbhjmv', 'ngjh', 1, 0, 0, 6, 2, 2, '150209PLRS0002', ' dfhb', 11, '2015-02-09 20:40:06', 0, '0000-00-00 00:00:00', 0, 0, 0, '0', '0'),
(5, 'Manish', 'manish@gmail.com', '9636359963', 'Jaipur', 'Jaipur', 1, 1, 0, 99, 1, 1, '150210PLRS0001', ' Testting', 11, '2015-02-10 11:07:12', 0, '0000-00-00 00:00:00', 11, 9, 8, '2', '1'),
(6, 'Manis', 'manish@gmail.com', '7845613665', 'Tester', 'Jaipur', 3, 10, 10, 99, 1, 1, '150216PLRS0001', ' Tester', 11, '2015-02-16 13:15:21', 0, '0000-00-00 00:00:00', 11, 4, 8, '2', '1'),
(7, 'Manish', 'aroramanish63@gmail.com', '7845125555', 'Jaipur', 'Japur', 1, 1, 1, 15, 1, 2, '150216PLRS0002', ' Test', 11, '2015-02-16 14:52:05', 0, '0000-00-00 00:00:00', 11, 4, 0, '2', '2'),
(8, 'dfg', 'sdgh@fh.cb', '3245646547', 'ghjk', 'gfjf', 12, 42, 50, 99, 1, 1, '150216PLRS0003', ' j', 11, '2015-02-16 14:57:47', 0, '0000-00-00 00:00:00', 0, 0, 0, '0', '0'),
(9, 'fgh', 'tester@tester.com', '4561236958', 'Jaipur', 'Alwar', 1, 1, 1, 99, 1, 1, '150219PLRS0001', ' Tester', 11, '2015-02-19 12:23:56', 0, '0000-00-00 00:00:00', 0, 0, 0, '0', '0'),
(10, 'dfh', 'fdh@fh.com', '3456465657', 'Jaipur', 'Amritsar', 4, 14, 17, 16, 1, 2, '150219PLRS0002', ' Testr', 11, '2015-02-19 12:39:32', 0, '0000-00-00 00:00:00', 0, 0, 0, '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `plrs_complaint_subtype`
--

CREATE TABLE IF NOT EXISTS `plrs_complaint_subtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comp_type_id` int(11) NOT NULL,
  `subtype_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `plrs_complaint_subtype`
--

INSERT INTO `plrs_complaint_subtype` (`id`, `comp_type_id`, `subtype_name`) VALUES
(1, 1, 'Land Records'),
(2, 1, 'Registration'),
(3, 1, 'Court Cases'),
(4, 2, 'Patwaris'),
(5, 2, 'Kanungos'),
(6, 2, 'Tehsildars/Naib Tehsildars'),
(7, 2, 'Khasra Girdawri'),
(8, 2, 'Mutation'),
(9, 3, 'Land Records'),
(10, 3, 'Registration');

-- --------------------------------------------------------

--
-- Table structure for table `plrs_complaint_subtype_nested`
--

CREATE TABLE IF NOT EXISTS `plrs_complaint_subtype_nested` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subtype_id` int(11) NOT NULL,
  `nested_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `plrs_complaint_subtype_nested`
--

INSERT INTO `plrs_complaint_subtype_nested` (`id`, `subtype_id`, `nested_name`) VALUES
(1, 1, 'Record of rights'),
(2, 1, 'Demarkation of land'),
(3, 1, 'Mutation'),
(4, 1, 'Website'),
(5, 1, 'Change of Girdawari'),
(6, 2, 'Stamp Duty'),
(7, 2, 'Registration Fees'),
(8, 2, 'Other Fees'),
(9, 3, 'Tehsildar Court'),
(10, 3, 'SDM Court'),
(11, 3, 'DC Court'),
(12, 3, 'Commissioner Court'),
(13, 3, 'DLR Court'),
(14, 3, 'FCR Court'),
(15, 9, 'Shajra Nasab'),
(16, 9, 'Old Records'),
(17, 9, 'Previously registered Docs'),
(18, 9, 'Mortgage'),
(19, 10, 'All Fees'),
(20, 10, 'Collector Rates'),
(21, 10, 'Documentation'),
(22, 10, 'List/Location of all DCs/SDMs/SROs/JSROs'),
(23, 10, 'Contact Details of all DCs/SDMs/SROs/JSROs');

-- --------------------------------------------------------

--
-- Table structure for table `plrs_complaint_type`
--

CREATE TABLE IF NOT EXISTS `plrs_complaint_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `complaint_type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `plrs_complaint_type`
--

INSERT INTO `plrs_complaint_type` (`id`, `complaint_type`) VALUES
(1, 'Complaint'),
(2, 'Feedback'),
(3, 'Enquiry'),
(4, 'Miscellaneous');

-- --------------------------------------------------------

--
-- Table structure for table `plrs_countries`
--

CREATE TABLE IF NOT EXISTS `plrs_countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(500) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=244 ;

--
-- Dumping data for table `plrs_countries`
--

INSERT INTO `plrs_countries` (`id`, `country_name`, `status`) VALUES
(1, 'Abkhazia', '1'),
(2, 'Afghanistan', '1'),
(3, 'Albania', '1'),
(4, 'Algeria', '1'),
(5, 'American Samoa', '1'),
(6, 'Andorra', '1'),
(7, 'Angola', '1'),
(8, 'Anguilla', '1'),
(9, 'Antigua and Barbuda', '1'),
(10, 'Argentina', '1'),
(11, 'Armenia', '1'),
(12, 'Aruba', '1'),
(13, 'Australia', '1'),
(14, 'Austria', '1'),
(15, 'Azerbaijan', '1'),
(16, 'The Bahamas', '1'),
(17, 'Bahrain', '1'),
(18, 'Bangladesh', '1'),
(19, 'Barbados', '1'),
(20, 'Belarus', '1'),
(21, 'Belgium', '1'),
(22, 'Belize', '1'),
(23, 'Benin', '1'),
(24, 'Bermuda', '1'),
(25, 'Bhutan', '1'),
(26, 'Bolivia', '1'),
(27, 'Bosnia and Herzegovina', '1'),
(28, 'Botswana', '1'),
(29, 'Brazil', '1'),
(30, 'British Virgin Islands', '1'),
(31, 'Brunei', '1'),
(32, 'Bulgaria', '1'),
(33, 'Burkina Faso', '1'),
(34, 'Burma', '1'),
(35, 'Burundi', '1'),
(36, 'Cambodia', '1'),
(37, 'Cameroon', '1'),
(38, 'Canada', '1'),
(39, 'Cape Verde', '1'),
(40, 'Cayman Islands', '1'),
(41, 'Central African Republic', '1'),
(42, 'Chad', '1'),
(43, 'Chile', '1'),
(44, 'China?(People''s Republic of China)', '1'),
(45, 'Christmas Island', '1'),
(46, 'Cocos Islands', '1'),
(47, 'Colombia', '1'),
(48, 'Comoros', '1'),
(49, 'Cook Islands', '1'),
(50, 'Costa Rica', '1'),
(51, 'Cte d''Ivoire', '1'),
(52, 'Croatia', '1'),
(53, 'Cuba', '1'),
(54, 'Cura?ao', '1'),
(55, 'Cyprus', '1'),
(56, 'Czech Republic', '1'),
(57, 'Democratic Republic of the Congo', '1'),
(58, 'Denmark', '1'),
(59, 'Djibouti', '1'),
(60, 'Dominica', '1'),
(61, 'Dominican Republic', '1'),
(62, 'East Timor', '1'),
(63, 'Ecuador', '1'),
(64, 'Egypt', '1'),
(65, 'El Salvador', '1'),
(66, 'Equatorial Guinea', '1'),
(67, 'Eritrea', '1'),
(68, 'Estonia', '1'),
(69, 'Ethiopia', '1'),
(70, 'Falkland Islands', '1'),
(71, 'Faroe Islands', '1'),
(72, 'Fiji', '1'),
(73, 'Finland', '1'),
(74, 'France', '1'),
(75, 'French Guiana', '1'),
(76, 'French Polynesia', '1'),
(77, 'Country (exonym)', '1'),
(78, 'Gabon', '1'),
(79, 'The Gambia', '1'),
(80, 'Georgia', '1'),
(81, 'Germany', '1'),
(82, 'Ghana', '1'),
(83, 'Gibraltar', '1'),
(84, 'Greece', '1'),
(85, 'Greenland', '1'),
(86, 'Grenada', '1'),
(87, 'Guadeloupe', '1'),
(88, 'Guam', '1'),
(89, 'Guatemala', '1'),
(90, 'Guernsey', '1'),
(91, 'Guinea', '1'),
(92, 'Guinea-Bissau', '1'),
(93, 'Guyana', '1'),
(94, 'Haiti', '1'),
(95, 'Honduras', '1'),
(96, 'Hong Kong', '1'),
(97, 'Hungary', '1'),
(98, 'Iceland', '1'),
(99, 'India', '1'),
(100, 'Indonesia', '1'),
(101, 'Iran', '1'),
(102, 'Iraq', '1'),
(103, 'Ireland', '1'),
(104, 'Isle of Man', '1'),
(105, 'Israel', '1'),
(106, 'Italy', '1'),
(107, 'Jamaica', '1'),
(108, 'Japan', '1'),
(109, 'Jersey', '1'),
(110, 'Jordan', '1'),
(111, 'Kazakhstan', '1'),
(112, 'Kenya', '1'),
(113, 'Kiribati', '1'),
(114, 'Kosovo', '1'),
(115, 'Kuwait', '1'),
(116, 'Kyrgyzstan', '1'),
(117, 'Latvia', '1'),
(118, 'Lebanon', '1'),
(119, 'Lesotho', '1'),
(120, 'Liberia', '1'),
(121, 'Libya', '1'),
(122, 'Liechtenstein', '1'),
(123, 'Lithuania', '1'),
(124, 'Luxembourg', '1'),
(125, 'Macedonia', '1'),
(126, 'Madagascar', '1'),
(127, 'Malawi', '1'),
(128, 'Malaysia', '1'),
(129, 'Maldives', '1'),
(130, 'Mali', '1'),
(131, 'Malta', '1'),
(132, 'Marshall Islands', '1'),
(133, 'Martinique', '1'),
(134, 'Mauritania', '1'),
(135, 'Mauritius', '1'),
(136, 'Mayotte', '1'),
(137, 'Mexico', '1'),
(138, 'Federated States of Micronesia', '1'),
(139, 'Moldova', '1'),
(140, 'Monaco', '1'),
(141, 'Mongolia', '1'),
(142, 'Montenegro', '1'),
(143, 'Montserrat', '1'),
(144, 'Morocco', '1'),
(145, 'Mozambique', '1'),
(146, 'Nagorno-Karabakh', '1'),
(147, 'Namibia', '1'),
(148, 'Nauru', '1'),
(149, 'Nepal', '1'),
(150, 'Netherlands', '1'),
(151, 'New Caledonia', '1'),
(152, 'New Zealand', '1'),
(153, 'Nicaragua', '1'),
(154, 'Niger', '1'),
(155, 'Nigeria', '1'),
(156, 'Niue', '1'),
(157, 'Norfolk Island', '1'),
(158, 'North Korea', '1'),
(159, 'Northern Cyprus', '1'),
(160, 'Northern Mariana Islands', '1'),
(161, 'Norway', '1'),
(162, 'Oman', '1'),
(163, 'Pakistan', '1'),
(164, 'Palau', '1'),
(165, 'Palestinian National Authority', '1'),
(166, 'Panama', '1'),
(167, 'Papua New Guinea', '1'),
(168, 'Paraguay', '1'),
(169, 'Peru', '1'),
(170, 'Philippines', '1'),
(171, 'Pitcairn Islands', '1'),
(172, 'Poland', '1'),
(173, 'Portugal', '1'),
(174, 'Puerto Rico', '1'),
(175, 'Qatar', '1'),
(176, 'Republic of the Congo', '1'),
(177, 'R?union', '1'),
(178, 'Romania', '1'),
(179, 'Russia', '1'),
(180, 'Rwanda', '1'),
(181, 'Sahrawi Arab Democratic Republic', '1'),
(182, 'Saint Barth?lemy', '1'),
(183, 'Saint Helena, Ascension and Tristan da Cunha', '1'),
(184, 'Saint Kitts and Nevis', '1'),
(185, 'Saint Martin', '1'),
(186, 'Saint Lucia', '1'),
(187, 'Saint Pierre and Miquelon', '1'),
(188, 'Saint Vincent and the Grenadines', '1'),
(189, 'Samoa', '1'),
(190, 'San Marino', '1'),
(191, 'Sao Tome and Pr?ncipe', '1'),
(192, 'Saudi Arabia', '1'),
(193, 'Senegal', '1'),
(194, 'Serbia', '1'),
(195, 'Seychelles', '1'),
(196, 'Sierra Leone', '1'),
(197, 'Singapore', '1'),
(198, 'Sint Maarten', '1'),
(199, 'Slovakia', '1'),
(200, 'Slovenia', '1'),
(201, 'Solomon Islands', '1'),
(202, 'Somalia', '1'),
(203, 'Somaliland', '1'),
(204, 'South Africa', '1'),
(205, 'South Korea', '1'),
(206, 'South Sudan', '1'),
(207, 'South Ossetia', '1'),
(208, 'Spain', '1'),
(209, 'Sri Lanka', '1'),
(210, 'Sudan', '1'),
(211, 'Suriname', '1'),
(212, 'Svalbard', '1'),
(213, 'Swaziland', '1'),
(214, 'Sweden', '1'),
(215, 'Switzerland', '1'),
(216, 'Syria', '1'),
(217, 'Taiwan?(Republic of China)', '1'),
(218, 'Tajikistan', '1'),
(219, 'Tanzania', '1'),
(220, 'Thailand', '1'),
(221, 'Togo', '1'),
(222, 'Tonga', '1'),
(223, 'Transnistria', '1'),
(224, 'Trinidad and Tobago', '1'),
(225, 'Tunisia', '1'),
(226, 'Turkey', '1'),
(227, 'Turkmenistan', '1'),
(228, 'Turks and Caicos Islands', '1'),
(229, 'Tuvalu', '1'),
(230, 'Uganda', '1'),
(231, 'Ukraine', '1'),
(232, 'United Arab Emirates', '1'),
(233, 'United Kingdom', '1'),
(234, 'United States', '1'),
(235, 'United States Virgin Islands', '1'),
(236, 'Uruguay', '1'),
(237, 'Uzbekistan', '1'),
(238, 'Vanuatu', '1'),
(239, 'Vatican City', '1'),
(240, 'Venezuela', '1'),
(241, 'Vietnam', '1'),
(242, 'Zambia', '1'),
(243, 'Zimbabwe', '1');

-- --------------------------------------------------------

--
-- Table structure for table `plrs_district_mstr`
--

CREATE TABLE IF NOT EXISTS `plrs_district_mstr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `district_name` varchar(255) NOT NULL,
  `division_id` int(11) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '''0''=>''Inactive'',''1''=>''Active''',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `plrs_district_mstr`
--

INSERT INTO `plrs_district_mstr` (`id`, `district_name`, `division_id`, `status`) VALUES
(1, 'Jalandhar', 1, '1'),
(2, 'Kapurthala', 1, '1'),
(3, 'Hoshiarpur', 1, '1'),
(4, 'Amritsar', 1, '1'),
(5, 'Tarn Taran', 1, '1'),
(6, 'Gurdaspur', 1, '1'),
(7, 'Pathankot', 1, '1'),
(8, 'Shahid Bhagat singh Nagar', 1, '1'),
(9, 'RoopNagar', 2, '1'),
(10, 'S.A.S.Nagar', 2, '1'),
(11, 'Patiala', 3, '1'),
(12, 'Ludhiana', 3, '1'),
(13, 'Sangrur', 3, '1'),
(14, 'Barnala', 3, '1'),
(15, 'Fathegarh Sahib', 3, '1'),
(16, 'Ferozepur', 4, '1'),
(17, 'Moga', 4, '1'),
(18, 'Mukatsar', 4, '1'),
(19, 'Fazlika', 4, '1'),
(20, 'Faridkot', 5, '1'),
(21, 'Bathinda', 5, '1'),
(22, 'Mansa', 5, '1');

-- --------------------------------------------------------

--
-- Table structure for table `plrs_division_mstr`
--

CREATE TABLE IF NOT EXISTS `plrs_division_mstr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `division_name` varchar(255) NOT NULL,
  `description` varchar(500) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '''0''=>''Inactive'',''1''=>''Active''',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `plrs_division_mstr`
--

INSERT INTO `plrs_division_mstr` (`id`, `division_name`, `description`, `status`) VALUES
(1, 'Jalandhar Division', 'Jalandhar Division', '1'),
(2, 'RoopNagar Division', 'RoopNagar Division', '1'),
(3, 'Patiala Division', 'Patiala Division', '1'),
(4, 'Ferozepur Division', 'Ferozepur Division', '1'),
(5, 'Faridkot Division', 'Faridkot Division', '1');

-- --------------------------------------------------------

--
-- Table structure for table `plrs_sms_content`
--

CREATE TABLE IF NOT EXISTS `plrs_sms_content` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `complaint_id` int(11) NOT NULL,
  `is_sms` enum('1','2') NOT NULL COMMENT '''1''=>''SMS'',''2''=>''Email''',
  `content` text NOT NULL,
  `add_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `plrs_state_mstr`
--

CREATE TABLE IF NOT EXISTS `plrs_state_mstr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state_name` varchar(100) NOT NULL,
  `state_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `state_id` (`state_id`),
  KEY `state_name` (`state_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `plrs_state_mstr`
--

INSERT INTO `plrs_state_mstr` (`id`, `state_name`, `state_id`) VALUES
(1, 'Andhra Pradesh', 2169),
(2, 'Assam', 2170),
(3, 'Bihar', 2171),
(4, 'Delhi', 2174),
(5, 'Gujarat', 2175),
(6, 'Haryana', 2176),
(7, 'Himachal Pradesh', 2177),
(8, 'Jammu and Kashmir', 2178),
(9, 'Kerala', 2179),
(10, 'Madhya Pradesh', 2181),
(11, 'Maharashtra', 2182),
(12, 'Manipur', 2183),
(13, 'Meghalaya', 2184),
(14, 'Karnataka', 2185),
(15, 'Nagaland', 2186),
(16, 'Odisha', 2187),
(17, 'Punjab', 2189),
(18, 'Rajasthan', 2190),
(19, 'Tamil Nadu', 2191),
(20, 'Tripura', 2192),
(21, 'Uttar Pradesh', 2193),
(22, 'West Bengal', 2194),
(23, 'Sikkim', 2195),
(24, 'Arunachal Pradesh', 2196),
(25, 'Mizoram', 2197),
(26, 'Goa', 2199),
(27, 'Uttarakhand', 5259),
(28, 'Chhattisgarh', 5267),
(29, 'Jharkhand', 5268),
(30, 'UNION TERRITORY', 5269),
(31, 'TELANGANA', 5270);

-- --------------------------------------------------------

--
-- Table structure for table `plrs_subtehsil_mastr`
--

CREATE TABLE IF NOT EXISTS `plrs_subtehsil_mastr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `division_id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `tehsil_id` int(11) NOT NULL,
  `kanungo_count` int(11) NOT NULL,
  `patwar_count` int(11) NOT NULL,
  `villages_count` int(11) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=89 ;

--
-- Dumping data for table `plrs_subtehsil_mastr`
--

INSERT INTO `plrs_subtehsil_mastr` (`id`, `name`, `division_id`, `district_id`, `tehsil_id`, `kanungo_count`, `patwar_count`, `villages_count`, `status`) VALUES
(1, 'Adampur', 1, 1, 1, 7, 68, 167, '1'),
(2, 'Kartarpur', 1, 1, 2, 9, 89, 266, '1'),
(3, 'Bhogpur', 1, 1, 2, 9, 89, 266, '1'),
(4, 'Nurmahal', 1, 1, 3, 11, 113, 242, '1'),
(5, 'Goraya', 1, 1, 3, 11, 113, 242, '1'),
(6, 'Mehat pur', 1, 1, 4, 7, 66, 147, '1'),
(7, 'Lohian', 1, 1, 5, 5, 58, 183, '1'),
(8, 'Dhilwan', 1, 2, 6, 7, 74, 263, '1'),
(9, 'Talwandi Chaudhrian', 1, 2, 7, 5, 52, 215, '1'),
(10, 'Bhunga', 1, 3, 10, 14, 137, 429, '1'),
(11, 'Tanda', 1, 3, 11, 11, 115, 404, '1'),
(12, 'Gardhiwala', 1, 3, 11, 11, 115, 404, '1'),
(13, 'Mahilpur', 1, 3, 12, 10, 103, 302, '1'),
(14, 'Bine Wal', 1, 3, 12, 10, 103, 302, '1'),
(15, 'Talwara', 1, 3, 13, 7, 69, 314, '1'),
(16, 'Hajipur', 1, 3, 13, 7, 69, 314, '1'),
(17, 'Majitha', 1, 4, 14, 6, 64, 149, '1'),
(18, 'Attari', 1, 4, 15, 6, 60, 123, '1'),
(19, 'Tarsikka', 1, 4, 16, 6, 61, 157, '1'),
(20, 'Ramdas', 1, 4, 17, 12, 124, 347, '1'),
(21, 'Lopoke', 1, 4, 17, 12, 124, 347, '1'),
(22, 'Jhabal', 1, 5, 18, 9, 87, 200, '1'),
(23, 'Chohla Sahib', 1, 5, 18, 9, 87, 200, '1'),
(24, 'Naushehra Pannuan', 1, 5, 18, 9, 87, 200, '1'),
(25, 'Harike', 1, 5, 18, 9, 87, 200, '1'),
(26, 'Khemkaran', 1, 5, 19, 10, 99, 198, '1'),
(27, 'Bhikhiwind', 1, 5, 19, 10, 99, 198, '1'),
(28, 'Goindwal Sahib', 1, 5, 20, 4, 38, 96, '1'),
(29, 'Kahnuwan', 1, 6, 21, 17, 168, 724, '1'),
(30, 'Kalanaur', 1, 6, 21, 17, 168, 724, '1'),
(31, 'Dinanagar', 1, 6, 21, 17, 168, 724, '1'),
(32, 'Naushehra Majha Singh', 1, 6, 21, 17, 168, 724, '1'),
(33, 'Dhariwal', 1, 6, 21, 17, 168, 724, '1'),
(34, 'Shri Hargobindpur', 1, 6, 22, 12, 122, 375, '1'),
(35, 'Fathegarh Churian', 1, 6, 22, 12, 122, 375, '1'),
(36, 'Qudian', 1, 6, 22, 12, 122, 375, '1'),
(37, 'Narot Jaimal Singh', 1, 7, 24, 8, 76, 394, '1'),
(38, 'Bamyal', 1, 7, 24, 8, 76, 394, '1'),
(39, 'Morinda', 2, 9, 30, 6, 55, 195, '1'),
(40, 'Nurpur Bedi', 2, 9, 31, 4, 40, 192, '1'),
(41, 'Banur', 2, 10, 33, 4, 36, 114, '1'),
(42, 'Zirakpur', 2, 10, 34, 4, 35, 149, '1'),
(43, 'Majri', 2, 10, 35, 6, 65, 203, '1'),
(44, 'Dudhan Sadhan', 3, 11, 36, 9, 87, 367, '1'),
(45, 'Ghanaur', 3, 11, 37, 6, 61, 250, '1'),
(46, 'Bhadson', 3, 11, 38, 5, 49, 175, '1'),
(47, 'Delhon', 3, 12, 41, 7, 71, 210, '1'),
(48, 'Kumkalan', 3, 12, 41, 7, 71, 210, '1'),
(49, 'Sahnewal', 3, 12, 41, 7, 71, 210, '1'),
(50, 'Mullapur Dhaka', 3, 12, 42, 8, 74, 149, '1'),
(51, 'Sidwan Bet', 3, 12, 43, 10, 102, 141, '1'),
(52, 'Machhiwara', 3, 12, 44, 6, 59, 202, '1'),
(53, 'Malaud', 3, 12, 46, 5, 55, 114, '1'),
(54, 'Bhawanigarh', 3, 13, 48, 7, 62, 127, '1'),
(55, 'Longowal', 3, 13, 48, 7, 62, 127, '1'),
(56, 'Ahmedgarh', 3, 13, 49, 6, 63, 192, '1'),
(57, 'Amargarh', 3, 13, 49, 6, 63, 192, '1'),
(58, 'Dirba', 3, 13, 50, 5, 53, 85, '1'),
(59, 'Cheema', 3, 13, 50, 5, 53, 85, '1'),
(60, 'Khanauri', 3, 13, 51, 2, 22, 48, '1'),
(61, 'Sherpur', 3, 13, 52, 5, 51, 97, '1'),
(62, 'Dhaunala', 3, 14, 54, 7, 70, 79, '1'),
(63, 'Mehal Kalan', 3, 14, 54, 7, 70, 79, '1'),
(64, 'Bhadaur', 3, 14, 55, 5, 46, 51, '1'),
(65, 'MandiGobindgarh', 3, 15, 58, 2, 23, 103, '1'),
(66, 'Mamdot', 4, 16, 60, 7, 66, 311, '1'),
(67, 'TalwandiBhai', 4, 16, 60, 7, 66, 311, '1'),
(68, 'Makhu', 4, 16, 61, 5, 51, 222, '1'),
(69, 'Badni Kalan', 4, 17, 64, 4, 35, 40, '1'),
(70, 'Kot Ise Khan', 4, 17, 65, 4, 43, 151, '1'),
(71, 'Lakhewali', 4, 18, 67, 5, 41, 97, '1'),
(72, 'Bariwala', 4, 18, 67, 5, 41, 97, '1'),
(73, 'Lambi', 4, 18, 68, 5, 47, 91, '1'),
(74, 'Doda', 4, 18, 69, 3, 31, 48, '1'),
(75, 'Arniwala Sheikh Subhan', 4, 19, 70, 6, 60, 149, '1'),
(76, 'Khuian Sarwar', 4, 19, 71, 7, 64, 76, '1'),
(77, 'Sito Guno', 4, 19, 71, 7, 64, 76, '1'),
(78, 'Sadiq', 5, 20, 73, 4, 39, 96, '1'),
(79, 'Nathana', 5, 21, 76, 7, 21, 125, '1'),
(80, 'Sangat', 5, 21, 76, 7, 71, 125, '1'),
(81, 'Goniana Mandi', 5, 21, 76, 7, 21, 125, '1'),
(82, 'Bhagta Bhaika', 5, 21, 77, 5, 51, 76, '1'),
(83, 'Ballan Wali', 5, 21, 77, 5, 51, 76, '1'),
(84, 'Maur', 5, 21, 78, 4, 41, 91, '1'),
(85, 'Bhikhi', 5, 22, 79, 5, 51, 86, '1'),
(86, 'Joga', 5, 22, 79, 5, 51, 86, '1'),
(87, 'Bareta', 5, 22, 80, 4, 40, 88, '1'),
(88, 'Jhunir', 5, 22, 81, 4, 35, 70, '1');

-- --------------------------------------------------------

--
-- Table structure for table `plrs_tehsil_mstr`
--

CREATE TABLE IF NOT EXISTS `plrs_tehsil_mstr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tehsil_name` varchar(255) NOT NULL,
  `division_id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `kanungo_circle` int(11) NOT NULL,
  `patwar_circle` int(11) NOT NULL,
  `vilages` int(11) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '''0''=>''Inactive'',''1''=>''Active''',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=82 ;

--
-- Dumping data for table `plrs_tehsil_mstr`
--

INSERT INTO `plrs_tehsil_mstr` (`id`, `tehsil_name`, `division_id`, `district_id`, `kanungo_circle`, `patwar_circle`, `vilages`, `status`) VALUES
(1, 'Jalandhar-1', 1, 1, 7, 68, 167, '1'),
(2, 'Jalandhar-11', 1, 1, 9, 89, 266, '1'),
(3, 'Phillaur', 1, 1, 11, 113, 242, '1'),
(4, 'Nakodar', 1, 1, 7, 66, 147, '1'),
(5, 'Shahkot', 1, 1, 5, 58, 184, '1'),
(6, 'Kapurthala', 1, 2, 7, 74, 263, '1'),
(7, 'Sultanpur Lodhi', 1, 2, 5, 52, 215, '1'),
(8, 'Phagwara', 1, 2, 3, 28, 116, '1'),
(9, 'Bholath', 1, 2, 3, 30, 107, '1'),
(10, 'Hoshiarpur', 1, 3, 14, 137, 429, '1'),
(11, 'Dasuya', 1, 3, 11, 115, 404, '1'),
(12, 'GarhShankar', 1, 3, 10, 103, 302, '1'),
(13, 'Mukarian', 1, 3, 7, 69, 314, '1'),
(14, 'Amritsar-1', 1, 4, 6, 64, 149, '1'),
(15, 'Amritsar-11', 1, 4, 6, 60, 123, '1'),
(16, 'Baba Bakala', 1, 4, 6, 61, 157, '1'),
(17, 'Ajnala', 1, 4, 12, 124, 347, '1'),
(18, 'Tarn Taran', 1, 5, 9, 87, 200, '1'),
(19, 'Patti', 1, 5, 10, 99, 198, '1'),
(20, 'Khaudar Sahib', 1, 5, 4, 38, 96, '1'),
(21, 'Gurdaspur', 1, 6, 17, 168, 724, '1'),
(22, 'Batala', 1, 6, 12, 122, 375, '1'),
(23, 'Dera Baba Nanak', 1, 6, 4, 39, 123, '1'),
(24, 'Pathankot', 1, 7, 8, 76, 394, '1'),
(25, 'Dharkalan', 1, 7, 2, 22, 27, '1'),
(26, 'Nawanshahr', 1, 8, 9, 83, 178, '1'),
(27, 'Balachaur', 1, 8, 5, 48, 186, '1'),
(28, 'Banga', 1, 8, 4, 44, 110, '1'),
(29, 'RoopNagar', 2, 9, 4, 39, 178, '1'),
(30, 'Chamkaur Sahib', 2, 9, 6, 55, 195, '1'),
(31, 'Anandpur Sahib', 2, 9, 4, 40, 192, '1'),
(32, 'Nangal', 2, 9, 2, 16, 70, '1'),
(33, 'Mohali', 2, 10, 4, 36, 114, '1'),
(34, 'DeraBassi', 2, 10, 3, 35, 149, '1'),
(35, 'Kharar', 2, 10, 6, 65, 203, '1'),
(36, 'Pataila', 3, 11, 9, 87, 367, '1'),
(37, 'Rajpura', 3, 11, 6, 61, 249, '1'),
(38, 'Nabha', 3, 11, 5, 49, 175, '1'),
(39, 'Samana', 3, 11, 2, 23, 73, '1'),
(40, 'Patran', 3, 11, 3, 30, 69, '1'),
(41, 'Ludhiana East', 3, 12, 7, 71, 210, '1'),
(42, 'Ludhiana West', 3, 12, 8, 74, 149, '1'),
(43, 'Jagraon', 3, 12, 10, 102, 141, '1'),
(44, 'Samrala', 3, 12, 6, 59, 202, '1'),
(45, 'Khanna', 3, 12, 3, 26, 76, '1'),
(46, 'Payal', 3, 12, 5, 55, 114, '1'),
(47, 'Raikot', 3, 12, 5, 54, 77, '1'),
(48, 'Sangrur', 3, 13, 7, 62, 127, '1'),
(49, 'Malerkotla', 3, 13, 6, 63, 192, '1'),
(50, 'Sunam', 3, 13, 5, 53, 85, '1'),
(51, 'Moonak', 3, 13, 2, 22, 48, '1'),
(52, 'Dhuri', 3, 13, 5, 51, 97, '1'),
(53, 'Lehra', 3, 13, 2, 20, 40, '1'),
(54, 'Barnala', 3, 14, 7, 70, 79, '1'),
(55, 'Tapa', 3, 14, 5, 46, 51, '1'),
(56, 'Fathegarh Sahib', 3, 15, 4, 41, 176, '1'),
(57, 'Bassi Pathana', 3, 15, 2, 21, 100, '1'),
(58, 'Amloh', 3, 15, 2, 23, 103, '1'),
(59, 'Khamanon', 3, 15, 3, 25, 76, '1'),
(60, 'Ferozepur', 4, 16, 7, 66, 311, '1'),
(61, 'Zira', 4, 16, 5, 51, 222, '1'),
(62, 'Guru Har Sahai', 4, 16, 3, 28, 119, '1'),
(63, 'Moga', 4, 17, 6, 60, 84, '1'),
(64, 'Nihal Singh Wala', 4, 17, 4, 35, 40, '1'),
(65, 'Dharmakot', 4, 17, 4, 43, 151, '1'),
(66, 'Bagha Purana', 4, 17, 5, 51, 56, '1'),
(67, 'Bagha Purana', 4, 18, 5, 41, 97, '1'),
(68, 'Malout', 4, 18, 5, 47, 91, '1'),
(69, 'GiddarBaha', 4, 18, 3, 31, 48, '1'),
(70, 'Fazilaka', 4, 19, 6, 60, 149, '1'),
(71, 'Abohar', 4, 19, 7, 64, 76, '1'),
(72, 'Jalalabad', 4, 19, 3, 29, 134, '1'),
(73, 'Faridkot', 5, 20, 4, 39, 96, '1'),
(74, 'Jaito', 5, 20, 2, 26, 41, '1'),
(75, 'Kotkapura', 5, 20, 2, 23, 34, '1'),
(76, 'Bathinda', 5, 21, 7, 71, 125, '1'),
(77, 'Rampuraphul', 5, 21, 5, 51, 76, '1'),
(78, 'Talwandi Sabo', 5, 21, 4, 41, 91, '1'),
(79, 'Mansa', 5, 22, 5, 51, 86, '1'),
(80, 'Budlada', 5, 22, 4, 40, 88, '1'),
(81, 'Sardulgarh', 5, 22, 4, 35, 70, '1');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `plrs_user_comment`
--

INSERT INTO `plrs_user_comment` (`id`, `created_by`, `user_group`, `complaint_id`, `remarks`, `is_open`, `add_date`) VALUES
(1, 11, 0, 1, 'Enquiry Closed', '1', '2015-02-07 20:04:25'),
(2, 11, 7, 3, 'Testing Manish', '1', '2015-02-09 17:53:38'),
(3, 9, 4, 3, 'Transfer to SDM', '1', '2015-02-09 18:26:28'),
(4, 8, 6, 3, 'Investigate and fulfill requests', '1', '2015-02-09 18:28:47'),
(5, 11, 7, 5, 'Transfer to call center staff', '1', '2015-02-10 11:08:39'),
(6, 9, 4, 5, 'transfer to SDM', '', '2015-02-10 11:47:00'),
(8, 8, 6, 5, 'Investigated Properly', '', '2015-02-10 12:23:42'),
(9, 11, 7, 6, 'Testing complaint transfer to state coordinator.', '1', '2015-02-16 13:31:19'),
(10, 4, 4, 3, 'Testing transfer to SDM2', '', '2015-02-16 13:32:46'),
(11, 4, 4, 6, 'Testing transfer to SDM', '', '2015-02-16 13:37:10'),
(12, 8, 6, 6, 'Investigated', '', '2015-02-16 13:40:46'),
(13, 11, 7, 7, 'Transfer to stateco', '1', '2015-02-16 14:56:04');

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
  `login_attempts` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `username`, `password`, `user_group`, `name`, `email`, `mobile_no`, `address`, `pass_changed`, `pass_modified_date`, `add_date`, `update_date`, `status`, `login_attempts`) VALUES
(1, 'manish', '59c95189ac895fcc1c6e1c38d067e244', 1, 'Manish Arora', 'manish.arora@cyfuture.com', '1234567890', 'Jaipur', 0, '2015-01-10 14:17:47', '2014-10-30 03:20:11', '2015-01-10 16:18:08', '1', 0),
(2, 'admin', '21232f297a57a5a743894a0e4a801fc3', 2, 'Admin', 'admin@cyfuture.com', '7845123695', 'Opposite Jaipur National University1', 0, '0000-00-00 00:00:00', '2014-10-30 02:21:27', '2015-01-23 15:35:40', '1', 0),
(3, 'Counsellor1', '59c95189ac895fcc1c6e1c38d067e244', 3, 'Counsellor1', 'aroramanish63@gmail.com', '7845123695', 'Cyfuture', 1, '2015-01-12 15:19:03', '2014-10-31 18:25:16', '2015-01-29 19:57:55', '1', 0),
(4, 'stateco', '59c95189ac895fcc1c6e1c38d067e244', 4, 'stateco', 'tester@gmail.com', '7845123695', 'Jaipur\r\n', 0, '2015-01-10 14:18:21', '2014-10-31 20:18:45', '2015-01-12 13:03:57', '1', 0),
(5, 'caseco2', '59c95189ac895fcc1c6e1c38d067e244', 5, 'caseco2', 'aroramanish63@gmail.com', '7845123695', 'Jaipur', 0, '0000-00-00 00:00:00', '2014-10-31 20:33:48', '2015-01-12 13:04:22', '1', 0),
(6, 'testverifier', '59c95189ac895fcc1c6e1c38d067e244', 3, 'testverifier', 'manish.arora@cyfuture.com', '4561239635', 'Jaipur', 3, '2015-01-12 15:20:33', '2014-11-04 20:18:39', '2015-01-09 12:54:05', '1', 0),
(7, 'casecoordinator1', '59c95189ac895fcc1c6e1c38d067e244', 5, 'casecoordinator1', 'case@cyfuture.com', '1234567895', 'Jaipur', 0, '0000-00-00 00:00:00', '2015-01-12 13:02:49', '0000-00-00 00:00:00', '1', 0),
(8, 'sdm1', '59c95189ac895fcc1c6e1c38d067e244', 6, 'sdm', 'sdm@gmail.com', '4561239875', 'Jaipur', 0, '0000-00-00 00:00:00', '2015-01-12 13:05:15', '0000-00-00 00:00:00', '1', 0),
(9, 'stateco2', '59c95189ac895fcc1c6e1c38d067e244', 4, 'stateco2', 'state@gmail.com', '1236547895', 'Jaipur', 0, '0000-00-00 00:00:00', '2015-01-12 13:07:50', '0000-00-00 00:00:00', '1', 0),
(10, 'sdm2', '59c95189ac895fcc1c6e1c38d067e244', 6, 'sdm2', 'sdm2@gmail.com', '3625147895', 'Jaipur', 0, '0000-00-00 00:00:00', '2015-01-12 13:08:37', '0000-00-00 00:00:00', '1', 0),
(11, 'callcenter1', '59c95189ac895fcc1c6e1c38d067e244', 7, 'call center', 'callcenter@gmail.com', '4512369578', 'Jaipur', 0, '0000-00-00 00:00:00', '2015-01-14 12:26:52', '0000-00-00 00:00:00', '1', 0);

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
(1, 'Super Admin', 'Manage all modules', '1,2,3,4,5,6,7,8,9,10,11,12,13,21', '0', -1, '1', '2014-10-30', '0', '1'),
(2, 'Admin', 'Right to upload bills and other documents and send it to particular verifier PENDING', '1,2,7,8,10,11', '2', 0, '1', '2014-10-30', '0', '1'),
(3, 'Counsellor', 'View the open complaints and feedback', '7,8,10', '6', 1, '1', '2014-10-30', '0', '1'),
(4, 'State Co-ordinator', 'Forward Complaints to case co-ordinator or SDM', '7,8,10', '6', 1, '1', '2014-10-30', '0', '1'),
(5, 'Case Co-ordinator', 'Case Co-ordinator reads the complaint and forward to concerned SDM.\r\n', '7,8,10', '6', 2, '1', '2014-10-30', '0', '1'),
(6, 'SDM', 'After Investigation, SDM enters findings in the System using his/her login id.\r\nSend information status to case co-ordinator.', '7,8,10', '5', 3, '1', '2015-01-12', '0', '1'),
(7, 'Call Centre Staff', 'Fills the form related to feedback / complaint.\r\nGet Complaint Status and update to customer.', '7,8,9,10', '4', 4, '1', '2015-01-12', '0', '1'),
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
