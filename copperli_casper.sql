-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 30, 2011 at 03:42 AM
-- Server version: 5.0.96-community
-- PHP Version: 5.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `copperli_casper`
--

-- --------------------------------------------------------

--
-- Table structure for table `banned_ips`
--

CREATE TABLE IF NOT EXISTS `banned_ips` (
  `banned_ips_id` int(11) NOT NULL auto_increment,
  `banned_ip` varchar(15) NOT NULL default '000.000.000.000',
  `ban_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ban_reason` varchar(255) default NULL,
  PRIMARY KEY  (`banned_ips_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `commodities`
--

CREATE TABLE IF NOT EXISTS `commodities` (
  `commodities_id` int(11) NOT NULL auto_increment,
  `commodities_groups_id` int(11) NOT NULL default '0',
  `commodities_name` varchar(128) NOT NULL default '',
  `commodities_symbol` varchar(8) NOT NULL default '',
  `commodities_contract_size` int(11) NOT NULL default '0',
  `commodities_unit` varchar(8) NOT NULL default '',
  `commodities_status` int(11) NOT NULL default '0',
  `commodities_order_priority` int(11) NOT NULL default '100',
  `commodities_def_fee` float(6,2) NOT NULL default '0.00',
  `commodities_def_prem` float(6,2) NOT NULL default '0.00',
  PRIMARY KEY  (`commodities_id`),
  UNIQUE KEY `NewIndex` (`commodities_symbol`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `commodities`
--

INSERT INTO `commodities` (`commodities_id`, `commodities_groups_id`, `commodities_name`, `commodities_symbol`, `commodities_contract_size`, `commodities_unit`, `commodities_status`, `commodities_order_priority`, `commodities_def_fee`, `commodities_def_prem`) VALUES
(18, 3, 'Australian Dollar', 'AD', 100000, 'AD', 1, 100, 0.00, 12.00),
(19, 3, 'Canadian Dollar', 'CD', 100000, 'CD', 1, 100, 0.00, 12.00),
(17, 3, 'Swiss Franc', 'SF', 125000, 'SF', 1, 100, 0.00, 12.00),
(14, 3, 'Euro', 'EC', 125000, 'â‚¬', 1, 15, 0.00, 12.00),
(15, 3, 'Japanese Yen', 'JY', 12500000, 'JY', 1, 100, 0.00, 12.00),
(16, 3, 'British Pound', 'BP', 62500, 'BP', 1, 100, 0.00, 12.00),
(5, 1, 'Gasoline', 'HU', 42000, 'gal', 1, 100, 0.00, 12.00),
(1, 1, 'Heating Oil', 'HO', 42000, 'gal', 1, 100, 0.00, 12.00),
(3, 1, 'LS Crude Oil', 'CL', 1000, 'barrels', 1, 100, 0.00, 12.00),
(4, 1, 'Natural Gas', 'NG', 10000, 'MMBtu', 1, 25, 0.00, 12.00),
(2, 1, 'RBOB Gasoline', 'RB', 42000, 'gal', 1, 45, 0.00, 12.00),
(6, 1, 'Electricity', 'JM', 40, 'Mwh', 0, 100, 0.00, 12.00),
(7, 1, 'Propane', 'PN', 42000, 'gal', 0, 100, 0.00, 12.00),
(8, 2, 'Gold', 'GC', 100, 'ozt', 1, 1, 0.00, 12.00),
(9, 2, 'Silver', 'SI', 5000, 'ozt', 1, 100, 0.00, 12.00),
(10, 2, 'Copper', 'HG', 25000, 'lb', 1, 100, 0.00, 12.00),
(11, 2, 'Aluminium', 'AL', 44000, 'lb', 1, 100, 0.00, 12.00),
(12, 2, 'Platinum', 'PL', 50, 'ozt', 1, 20, 0.00, 12.00),
(13, 2, 'Palladium', 'PA', 100, 'ozt', 1, 100, 0.00, 12.00),
(20, 3, 'EuroDollar', 'ED', 1000000, 'USD', 1, 100, 0.00, 12.00),
(21, 3, 'EuroYen', 'EY', 100000000, 'JPY', 0, 100, 0.00, 12.00),
(22, 4, 'Dow Jones Ind.', 'DJ', 10, 'DJ', 0, 100, 0.00, 12.00),
(23, 4, 'NASDAQ100', 'ND', 100, 'ND', 0, 100, 0.00, 12.00),
(24, 4, 'NYSE Composite', 'YX', 500, 'YX', 1, 100, 0.00, 12.00),
(25, 4, 'S&P 500', 'SP', 50, 'SP', 1, 100, 0.00, 12.00),
(26, 4, 'Nikkei225', 'NK', 5, 'NK', 1, 100, 0.00, 12.00),
(30, 4, 'ACM strategic Commodity Fund', 'SCF', 10000, '1', 1, 5, 0.00, 1.00),
(31, 4, 'DJIA mini-sized', 'YM', 10, 'YM', 1, 55, 1.00, 10.00);

-- --------------------------------------------------------

--
-- Table structure for table `commodities_groups`
--

CREATE TABLE IF NOT EXISTS `commodities_groups` (
  `commodities_groups_id` int(11) NOT NULL auto_increment,
  `commodities_groups_name` varchar(100) default NULL,
  PRIMARY KEY  (`commodities_groups_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `commodities_groups`
--

INSERT INTO `commodities_groups` (`commodities_groups_id`, `commodities_groups_name`) VALUES
(1, 'Energy'),
(2, 'Metal'),
(3, 'FOREX'),
(4, 'Index');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `countries_id` int(11) NOT NULL auto_increment,
  `country_full` varchar(255) default NULL,
  `country_short` varchar(255) default NULL,
  PRIMARY KEY  (`countries_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=240 ;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`countries_id`, `country_full`, `country_short`) VALUES
(13, 'Australia', 'AU'),
(14, 'Austria', 'AT'),
(17, 'Bahrain', 'BH'),
(20, 'Belarus', 'BY'),
(21, 'Belgium', 'BE'),
(22, 'Belize', 'BZ'),
(25, 'Bhutan', 'BT'),
(26, 'Bolivia', 'BO'),
(30, 'Brazil', 'BR'),
(32, 'Brunei', 'BN'),
(33, 'Bulgaria', 'BG'),
(38, 'Canada', 'CA'),
(39, 'Cape Verde', 'CV'),
(40, 'Cayman Islands', 'KY'),
(42, 'Chad', 'TD'),
(43, 'Chile', 'CL'),
(44, 'China', 'CN'),
(47, 'Columbia', 'CO'),
(49, 'Congo', 'CG'),
(51, 'Costa Rica', 'CR'),
(53, 'Croatia (Hrvatska)', 'HR'),
(54, 'Cuba', 'CU'),
(55, 'Cyprus', 'CY'),
(56, 'Czech Republic', 'CZ'),
(58, 'Denmark', 'DK'),
(60, 'Dominica', 'DM'),
(63, 'Ecuador', 'EC'),
(64, 'Egypt', 'EG'),
(65, 'El Salvador', 'SV'),
(66, 'Equatorial Guinea', 'GQ'),
(67, 'Eritrea', 'ER'),
(68, 'Estonia', 'EE'),
(69, 'Ethiopia', 'ET'),
(70, 'Falkland Islands (Malvinas)', 'FK'),
(71, 'Faroe Islands', 'FO'),
(72, 'Fiji', 'FJ'),
(73, 'Finland', 'FI'),
(74, 'France', 'FR'),
(75, 'France, Metropolitan', 'FX'),
(76, 'French Guinea', 'GF'),
(77, 'French Polynesia', 'PF'),
(78, 'French Southern Territories', 'TF'),
(79, 'Gabon', 'GA'),
(80, 'Gambia', 'GM'),
(81, 'Georgia', 'GE'),
(82, 'Germany', 'DE'),
(83, 'Ghana', 'GH'),
(84, 'Gibraltar', 'GI'),
(85, 'Greece', 'GR'),
(86, 'Greenland', 'GL'),
(87, 'Grenada', 'GD'),
(88, 'Guadeloupe', 'GP'),
(89, 'Guam', 'GU'),
(90, 'Guatemala', 'GT'),
(91, 'Guinea', 'GN'),
(92, 'Guinea-Bissau', 'GW'),
(93, 'Guyana', 'GY'),
(94, 'Haiti', 'HT'),
(95, 'Heard And McDonald Islands', 'HM'),
(96, 'Honduras', 'HN'),
(97, 'Hong Kong', 'HK'),
(98, 'Hungary', 'HU'),
(99, 'Iceland', 'IS'),
(100, 'India', 'IN'),
(101, 'Indonesia', 'ID'),
(102, 'Iran', 'IR'),
(103, 'Iraq', 'IQ'),
(104, 'Ireland', 'IE'),
(105, 'Israel', 'IL'),
(106, 'Italy', 'IT'),
(107, 'Jamaica', 'JM'),
(108, 'Japan', 'JP'),
(109, 'Jordan', 'JO'),
(110, 'Kazakhstan', 'KZ'),
(111, 'Kenya', 'KE'),
(112, 'Kiribati', 'KI'),
(113, 'Kuwait', 'KW'),
(114, 'Kyrgyzstan', 'KG'),
(115, 'Laos', 'LA'),
(116, 'Latvia', 'LV'),
(117, 'Lebanon', 'LB'),
(118, 'Lesotho', 'LS'),
(119, 'Liberia', 'LR'),
(120, 'Libya', 'LY'),
(121, 'Liechtenstein', 'LI'),
(122, 'Lithuania', 'LT'),
(123, 'Luxembourg', 'LU'),
(124, 'Macau', 'MO'),
(125, 'Macedonia', 'MK'),
(126, 'Madagascar', 'MG'),
(127, 'Malawi', 'MW'),
(128, 'Malaysia', 'MY'),
(129, 'Maldives', 'MV'),
(130, 'Mali', 'ML'),
(131, 'Malta', 'MT'),
(132, 'Marshall Islands', 'MH'),
(133, 'Martinique', 'MQ'),
(134, 'Mauritania', 'MR'),
(135, 'Mauritius', 'MU'),
(136, 'Mayotte', 'YT'),
(137, 'Mexico', 'MX'),
(138, 'Micronesia', 'FM'),
(139, 'Moldova', 'MD'),
(140, 'Monaco', 'MC'),
(141, 'Mongolia', 'MN'),
(142, 'Montserrat', 'MS'),
(143, 'Morocco', 'MA'),
(144, 'Mozambique', 'MZ'),
(145, 'Myanmar (Burma)', 'MM'),
(146, 'Namibia', 'NA'),
(147, 'Nauru', 'NR'),
(148, 'Nepal', 'NP'),
(149, 'Netherlands', 'NL'),
(150, 'Netherlands Antilles', 'AN'),
(151, 'New Caledonia', 'NC'),
(152, 'New Zealand', 'NZ'),
(153, 'Nicaragua', 'NI'),
(154, 'Niger', 'NE'),
(155, 'Nigeria', 'NG'),
(156, 'Niue', 'NU'),
(157, 'Norfolk Island', 'NF'),
(158, 'North Korea', 'KP'),
(159, 'Northern Mariana Islands', 'MP'),
(160, 'Norway', 'NO'),
(161, 'Oman', 'OM'),
(162, 'Pakistan', 'PK'),
(163, 'Palau', 'PW'),
(164, 'Panama', 'PA'),
(165, 'Papua New Guinea', 'PG'),
(166, 'Paraguay', 'PY'),
(167, 'Peru', 'PE'),
(168, 'Philippines', 'PH'),
(169, 'Pitcairn', 'PN'),
(170, 'Poland', 'PL'),
(171, 'Portugal', 'PT'),
(172, 'Puerto Rico', 'PR'),
(173, 'Qatar', 'QA'),
(174, 'Reunion', 'RE'),
(175, 'Romania', 'RO'),
(176, 'Russia', 'RU'),
(177, 'Rwanda', 'RW'),
(178, 'Saint Helena', 'SH'),
(179, 'Saint Kitts And Nevis', 'KN'),
(180, 'Saint Lucia', 'LC'),
(181, 'Saint Pierre And Miquelon', 'PM'),
(182, 'Saint Vincent And The Grenadines', 'VC'),
(183, 'San Marino', 'SM'),
(184, 'Sao Tome And Principe', 'ST'),
(185, 'Saudi Arabia', 'SA'),
(186, 'Senegal', 'SN'),
(187, 'Seychelles', 'SC'),
(188, 'Sierra Leone', 'SL'),
(189, 'Singapore', 'SG'),
(190, 'Slovak Republic', 'SK'),
(191, 'Slovenia', 'SI'),
(192, 'Solomon Islands', 'SB'),
(194, 'South Africa', 'ZA'),
(196, 'South Korea', 'KR'),
(197, 'Spain', 'ES'),
(198, 'Sri Lanka', 'LK'),
(203, 'Sweden', 'SE'),
(204, 'Switzerland', 'CH'),
(205, 'Syria', 'SY'),
(206, 'Taiwan', 'TW'),
(207, 'Tajikistan', 'TJ'),
(208, 'Tanzania', 'TZ'),
(209, 'Thailand', 'TH'),
(210, 'Togo', 'TG'),
(212, 'Tonga', 'TO'),
(214, 'Tunisia', 'TN'),
(215, 'Turkey', 'TR'),
(216, 'Turkmenistan', 'TM'),
(217, 'Turks And Caicos Islands', 'TC'),
(219, 'Uganda', 'UG'),
(220, 'Ukraine', 'UA'),
(221, 'United Arab Emirates', 'AE'),
(222, 'United Kingdom', 'UK'),
(223, 'United States', 'US'),
(224, 'United States Minor Outlying Islands', 'UM'),
(225, 'Uruguay', 'UY'),
(226, 'Uzbekistan', 'UZ'),
(227, 'Vanuatu', 'VU'),
(229, 'Venezuela', 'VE'),
(230, 'Vietnam', 'VN'),
(231, 'Virgin Islands (British)', 'VG'),
(232, 'Virgin Islands (US)', 'VI'),
(236, 'Yemen', 'YE'),
(237, 'Yugoslavia', 'YU'),
(238, 'Zambia', 'ZM'),
(239, 'Zimbabwe', 'ZW');

-- --------------------------------------------------------

--
-- Table structure for table `expiry_dates`
--

CREATE TABLE IF NOT EXISTS `expiry_dates` (
  `expiry_dates_id` int(11) NOT NULL auto_increment,
  `expiry_date` date NOT NULL default '0000-00-00',
  `expiry_short` varchar(10) default NULL,
  PRIMARY KEY  (`expiry_dates_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=57 ;

--
-- Dumping data for table `expiry_dates`
--

INSERT INTO `expiry_dates` (`expiry_dates_id`, `expiry_date`, `expiry_short`) VALUES
(52, '2012-11-27', 'Z12'),
(53, '2013-01-16', 'G13'),
(54, '2013-03-25', 'J13'),
(55, '2013-06-25', 'N13'),
(56, '2013-08-15', 'U13');

-- --------------------------------------------------------

--
-- Table structure for table `global_settings`
--

CREATE TABLE IF NOT EXISTS `global_settings` (
  `global_settings_id` int(11) NOT NULL auto_increment,
  `section` varchar(255) default NULL,
  `variable` varchar(255) default NULL,
  `variable_value` varchar(255) default NULL,
  PRIMARY KEY  (`global_settings_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `global_settings`
--

INSERT INTO `global_settings` (`global_settings_id`, `section`, `variable`, `variable_value`) VALUES
(1, 'transfers', '1', 'Transferred'),
(2, 'transfers', '2', 'Pending'),
(3, 'transfers', '3', 'Disabled'),
(4, 'transfers_types', '1', 'Deposit'),
(5, 'transfers_types', '2', 'Withdraw'),
(6, 'mail_settings', 'smtp_host', 'mail.domain.com'),
(7, 'mail_settings', 'smtp_user', 'contactus@domain.com'),
(8, 'mail_settings', 'smtp_password', '1q2w3e4r'),
(9, 'mail_settings', 'smtp_port', '25'),
(11, 'mail_assigns', 'Welcome email', '1'),
(12, 'mail_assigns', 'Forgot password', '2'),
(13, 'mail_assigns', 'Deposit Confirmation', '3'),
(14, 'mail_assigns', 'Withdrawal Confirmation', '4'),
(15, 'mail_assigns', 'Buy Confirmation', '5'),
(16, 'mail_assigns', 'Sell Confirmation', '6'),
(17, 'mail_assigns', 'Funding details', '7'),
(18, 'mail_assigns', 'Statement of account', '8'),
(10, 'mail_settings', 'mails_per_cron', '50'),
(19, 'global_settings', 'trade_type', '3');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `logs_id` bigint(20) NOT NULL auto_increment,
  `log_area` varbinary(100) default NULL,
  `log_section` varbinary(100) default NULL,
  `log_user` varchar(255) default NULL,
  `log_admin` varchar(255) default NULL,
  `log_details` varchar(255) default NULL,
  `log_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `log_ip` varchar(15) NOT NULL default '000.000.000.000',
  PRIMARY KEY  (`logs_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1200 ;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`logs_id`, `log_area`, `log_section`, `log_user`, `log_admin`, `log_details`, `log_date`, `log_ip`) VALUES
(1, 'Back-end', 'Login', 'Root (FTC001)', 'Root (FTC001)', 'Admin logged out (session expired).', '2011-05-27 04:19:09', '::1'),
(945, 'Front-end', 'Login', '  ()', '0', 'Invalid login. Invalid username and password used.', '2012-11-20 02:29:33', '110.142.1.245'),
(946, 'Front-end', 'Login', '  ()', '0', 'Invalid login. Invalid username and password used.', '2012-11-20 02:30:00', '110.142.1.245'),
(957, 'Front-end', 'Login', 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2012-11-20 03:14:42', '27.55.9.127'),
(958, 'Front-end', 'Login', 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2012-11-20 03:16:49', '27.55.9.127'),
(959, 'Front-end', 'Login', 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2012-11-20 03:16:58', '27.55.9.127'),
(960, 'Front-end', 'Login', 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2012-11-20 03:17:11', '27.55.9.127'),
(961, 'Front-end', 'Login', 'Allen Mealy (14809967233)', '0', 'User successfully logged in', '2012-11-20 03:30:57', '110.142.1.245'),
(962, 'Back-end', 'Login', 'Root (ACM00158)', 'Root (ACM00158)', 'Successfully logged in', '2012-11-20 04:09:02', '180.183.98.56'),
(963, 'Back-end', 'Transfers', 'Allen Mealy (14809967233)', 'Root (ACM00158)', 'Deposit added 11497772171 (Pending)', '2012-11-20 04:09:42', '180.183.98.56'),
(964, 'Back-end', 'Transfers', '  ()', 'Root (ACM00158)', 'Deposit deleted 42855087983 (Pending)', '2012-11-20 04:10:10', '180.183.98.56'),
(965, 'Back-end', 'Back-end Settings, Commodities - exp. dates', '0', 'Root (ACM00158)', 'Commodity expiry date added (2013-01-16)', '2012-11-20 04:36:51', '180.183.98.56'),
(966, 'Back-end', 'Trades', 'Allen Mealy (14809967233)', 'Root (ACM00158)', 'Buy added 265261446760 (CALL @ Open)', '2012-11-20 04:38:09', '180.183.98.56'),
(967, 'Back-end', 'Trades', 'Allen Mealy (14809967233)', 'Root (ACM00158)', 'Buy added 265261463523 (PUT @ Open)', '2012-11-20 04:39:15', '180.183.98.56'),
(968, 'Back-end', 'Mails', '  ()', 'Root (ACM00158)', 'Mail Sent (Trade buy details)', '2012-11-20 04:42:45', '180.183.98.56'),
(969, 'Front-end', 'Login', '  ()', '0', 'Invalid login. Invalid username and password used.', '2012-11-20 07:43:48', '149.135.146.5'),
(970, 'Front-end', 'Login', 'Allen Mealy (14809967233)', '0', 'User successfully logged in', '2012-11-20 07:50:42', '149.135.146.70'),
(971, 'Front-end', 'Login', 'Allen Mealy (14809967233)', '0', 'User successfully logged out', '2012-11-20 07:54:20', '149.135.146.70'),
(972, 'Front-end', 'Login', 'Allen Mealy (14809967233)', '0', 'User successfully logged in', '2012-11-21 02:54:01', '110.142.1.245'),
(973, 'Front-end', 'Login', 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2012-11-24 01:14:00', '27.55.148.44'),
(974, 'Front-end', 'Login', '  ()', '0', 'Invalid login. Invalid username and password used.', '2012-12-27 01:29:22', '175.42.81.70'),
(975, 'Front-end', 'Login', '  ()', '0', 'Invalid login. Invalid username and password used.', '2012-12-28 05:57:16', '175.42.81.70'),
(976, 'Front-end', 'Login', '  ()', '0', 'Invalid login. Invalid username and password used.', '2013-01-03 15:48:32', '220.161.148.150'),
(977, 'Back-end', 'Login', 'Root (ACM00158)', 'Root (ACM00158)', 'Successfully logged in', '2013-01-15 02:13:32', '183.89.63.247'),
(978, 'Back-end', 'Trades', 'Allen Mealy (14809967233)', 'Root (ACM00158)', 'Sell added 266497913187 (Closed)', '2013-01-15 02:17:16', '183.89.63.247'),
(979, 'Back-end', 'Transfers', 'Allen Mealy (14809967233)', 'Root (ACM00158)', 'Deposit edited 11497772171 (Transfered)', '2013-01-15 02:21:08', '183.89.63.247'),
(980, 'Back-end', 'Trades', 'Allen Mealy (14809967233)', 'Root (ACM00158)', 'Sell edited 266497913187 (Closed)', '2013-01-15 02:25:31', '183.89.63.247'),
(981, 'Front-end', 'Login', 'Allen Mealy (14809967233)', '0', 'User successfully logged in', '2013-01-16 01:03:13', '110.142.1.245'),
(982, 'Front-end', 'Login', '  ()', '0', 'Invalid login. Invalid username and password used.', '2013-01-16 03:10:24', '110.142.1.245'),
(983, 'Front-end', 'Login', '  ()', '0', 'Invalid login. Invalid username and password used.', '2013-01-16 03:11:08', '110.142.1.245'),
(984, 'Back-end', 'Login', 'Root (ACM00158)', 'Root (ACM00158)', 'Successfully logged in', '2013-01-17 01:18:18', '180.183.101.49'),
(985, 'Back-end', 'Back-end Settings, Commodities - exp. dates', '0', 'Root (ACM00158)', 'Commodity expiry date added (2013-03-25)', '2013-01-17 01:19:18', '180.183.101.49'),
(986, 'Back-end', 'Trades', 'Allen Mealy (14809967233)', 'Root (ACM00158)', 'Buy added 266541275577 (CALL @ Open)', '2013-01-17 01:20:21', '180.183.101.49'),
(1198, 'Front-end', 'Login', 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2013-12-30 06:11:31', '183.89.149.170'),
(1199, 'Front-end', 'Login', 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2013-12-30 06:12:40', '183.89.149.170');

-- --------------------------------------------------------

--
-- Table structure for table `mail_queue`
--

CREATE TABLE IF NOT EXISTS `mail_queue` (
  `mail_queue_id` bigint(20) NOT NULL auto_increment,
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `time_to_send` datetime NOT NULL default '0000-00-00 00:00:00',
  `sent_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `admins_id` bigint(20) NOT NULL default '0',
  `mail_subject` text,
  `mail_from` varchar(50) NOT NULL default '',
  `mail_from_mail` varchar(255) default NULL,
  `mail_to` varchar(255) default NULL,
  `mail_to_names` varchar(255) default NULL,
  `mail_html` longtext NOT NULL,
  `mail_plain` longtext NOT NULL,
  `try_sent` tinyint(4) NOT NULL default '0',
  `is_sent` tinyint(1) NOT NULL default '0',
  `mail_bcc` varchar(255) default NULL,
  PRIMARY KEY  (`mail_queue_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `mail_queue`
--

INSERT INTO `mail_queue` (`mail_queue_id`, `create_time`, `time_to_send`, `sent_time`, `admins_id`, `mail_subject`, `mail_from`, `mail_from_mail`, `mail_to`, `mail_to_names`, `mail_html`, `mail_plain`, `try_sent`, `is_sent`, `mail_bcc`) VALUES
(1, '2011-05-30 07:52:13', '2011-05-30 07:52:13', '0000-00-00 00:00:00', 1, 'Buy Trade Confirmation', 'Company', 'bcc@domain.com', 'bcc@domain.com', 'Tommy Test', '<table style="width: 550px;" border="0" cellpadding="3">\r\n<tbody>\r\n<tr>\r\n<td style="background-color: #999933; width: 50%;"><span style="font-size: medium;"><span style="font-family: arial,helvetica,sans-serif;"><span style="color: #000000;"><span class="style3"><strong>Trade Confirmation</strong></span></span></span></span></td>\r\n<td style="background-color: #999933; width: 50%;">\r\n<div class="style3" style="text-align: right;"><span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: medium;"><span style="color: #000000;"><strong>Date: </strong></span></span></span></div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style="background-color: #f2f9af;" colspan="2">\r\n<blockquote><br /></blockquote>\r\n<blockquote><span style="font-size: small;"><span style="font-family: arial,helvetica,sans-serif;"><span style="color: #000000;">Tommy Test,<br /><br />This is an auto generated confirmation of trade email. To review this trade, please log in to your account.</span></span></span></blockquote>\r\n<blockquote><a style="font-family: Arial,Helvetica,sans-serif; font-size: 12px;" href="../index.php"></a></blockquote>\r\n<blockquote><br /><span style="font-size: small;"><span style="font-family: arial,helvetica,sans-serif;"><span style="color: #000000;"><br /><strong>BUY Order Trade Details:</strong><br />Positions: <br />Trade: <br />Status: </span></span></span></blockquote>\r\n<blockquote><br /></blockquote>\r\n<blockquote>\r\n<p class="style1"><!--[if gte mso 9]><xml> <w:WordDocument> <w:View>Normal</w:View> <w:Zoom>0</w:Zoom> <w:PunctuationKerning /> <w:ValidateAgainstSchemas /> <w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid> <w:IgnoreMixedContent>false</w:IgnoreMixedContent> <w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText> <w:Compatibility> <w:BreakWrappedTables /> <w:SnapToGridInCell /> <w:ApplyBreakingRules /> <w:WrapTextWithPunct /> <w:UseAsianBreakRules /> <w:DontGrowAutofit /> </w:Compatibility> <w:BrowserLevel>MicrosoftInternetExplorer4</w:BrowserLevel> </w:WordDocument> </xml><![endif]--><!--[if gte mso 9]><xml> <w:LatentStyles DefLockedState="false" LatentStyleCount="156"> </w:LatentStyles> </xml><![endif]--><!--[if gte mso 10]> <mce:style><!   /* Style Definitions */  table.MsoNormalTable 	{mso-style-name:"Table Normal"; 	mso-tstyle-rowband-size:0; 	mso-tstyle-colband-size:0; 	mso-style-noshow:yes; 	mso-style-parent:""; 	mso-padding-alt:0in 5.4pt 0in 5.4pt; 	mso-para-margin:0in; 	mso-para-margin-bottom:.0001pt; 	mso-pagination:widow-orphan; 	font-size:10.0pt; 	font-family:"Times New Roman"; 	mso-ansi-language:#0400; 	mso-fareast-language:#0400; 	mso-bidi-language:#0400;} --> <!--[endif]--></p>\r\n</blockquote>\r\n<blockquote>\r\n<p class="style1">Best Regards,<br /> Company, Inc<br /> http://www.domain.com</p>\r\n</blockquote>\r\n<p>&nbsp;</p>\r\n<p><span style="font-family: verdana,geneva;"><br /></span></p>\r\n<p class="style1"><span style="font-size: small;"><span style="font-family: arial,helvetica,sans-serif;"><br /></span></span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style="background-color: #999933;"><span style="font-size: medium;"><span style="font-family: arial,helvetica,sans-serif;"><span style="color: #000000;"><span class="style3">Refrence: </span></span></span></span></td>\r\n<td style="text-align: right; background-color: #999933;"><span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: medium;"><span class="style3"> <span style="color: #000000;">Account Number: 11220840763 </span></span></span></span></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p><span style="font-family: verdana,geneva;">&nbsp;</span></p>\r\n<div id="_mcePaste" style="position: absolute; left: -10000px; top: 0px; width: 1px; height: 1px; overflow: hidden;"><!--[if gte mso 9]><xml> <w:WordDocument> <w:View>Normal</w:View> <w:Zoom>0</w:Zoom> <w:PunctuationKerning /> <w:ValidateAgainstSchemas /> <w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid> <w:IgnoreMixedContent>false</w:IgnoreMixedContent> <w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText> <w:Compatibility> <w:BreakWrappedTables /> <w:SnapToGridInCell /> <w:ApplyBreakingRules /> <w:WrapTextWithPunct /> <w:UseAsianBreakRules /> <w:DontGrowAutofit /> </w:Compatibility> <w:BrowserLevel>MicrosoftInternetExplorer4</w:BrowserLevel> </w:WordDocument> </xml><![endif]--><!--[if gte mso 9]><xml> <w:LatentStyles DefLockedState="false" LatentStyleCount="156"> </w:LatentStyles> </xml><![endif]--><!--[if gte mso 10]> <mce:style><!   /* Style Definitions */  table.MsoNormalTable 	{mso-style-name:"Table Normal"; 	mso-tstyle-rowband-size:0; 	mso-tstyle-colband-size:0; 	mso-style-noshow:yes; 	mso-style-parent:""; 	mso-padding-alt:0in 5.4pt 0in 5.4pt; 	mso-para-margin:0in; 	mso-para-margin-bottom:.0001pt; 	mso-pagination:widow-orphan; 	font-size:10.0pt; 	font-family:"Times New Roman"; 	mso-ansi-language:#0400; 	mso-fareast-language:#0400; 	mso-bidi-language:#0400;} --> <!--[endif]-->\r\n<p class="style1"><span style="font-family: Arial; color: black;">Best Regards, <br /> </span>Company Name&nbsp;<span style="font-family: Arial;"><br /> <a href="http://www.companyname.com/">companyname.com</a></span></p>\r\n</div>', 'Tommy Test,\r\n\r\nThank you for your recent trade.\r\n\r\nYour account number: 11220840763\r\n\r\nBUY Trade Details\r\nREF number: \r\nPositions: \r\nShort Info: \r\nStatus: \r\nDate: \r\n\r\n\r\nBest Regards,\r\nKippes Commodities, Inc\r\nhttp://www.domain.com', 0, 0, 'bcc@domain.com'),
(2, '2012-02-23 07:04:14', '2012-02-23 07:04:14', '0000-00-00 00:00:00', 3, 'Deposit Comfirmation', 'Company', 'contact@domain.com', 'sortofagoodone@gmail.com', 'Tommy Test', '<table style="width: 550px;" border="0" cellpadding="3">\r\n<tbody>\r\n<tr>\r\n<td style="background-color: #999933; width: 50%;"><span style="font-size: medium;"><span style="font-family: arial,helvetica,sans-serif;"><span style="color: #000000;"><span class="style3"><strong>Deposit Confirmation</strong></span></span></span></span></td>\r\n<td style="background-color: #999933; width: 50%;">\r\n<div class="style3" style="text-align: right;"><span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: medium;"><span style="color: #000000;"><strong>Date: 2012-02-23</strong></span></span></span></div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style="background-color: #f2f9af;" colspan="2">\r\n<blockquote>\r\n<p class="style1"><span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: small;"><span style="color: #000000;"> Tommy Test,</span></span></span></p>\r\n<p class="style1"><span style="font-size: small;"><span style="font-family: arial,helvetica,sans-serif;"><span style="color: #000000;">This is an auto generated confirmation receipt of payment. To review this deposit, please <span style="font-family: Arial,Helvetica,sans-serif; font-size: 12px;">log in to your account</span>.</span></span></span><span style="font-size: small;"><span style="font-family: arial,helvetica,sans-serif;"><span style="color: #000000;"> </span></span></span><a href="../index.php"></a></p>\r\n<p class="style1"><a style="font-family: Arial,Helvetica,sans-serif; font-size: 12px;" href="../index.php">http://trading.fremonttrading.com</a></p>\r\n<p class="style1">&nbsp;</p>\r\n<p class="style1"><span style="font-size: small;"><span style="font-family: arial,helvetica,sans-serif;"><span style="color: #000000;"><strong>Deposit Details</strong>:<br />Value: 40,000.00<br />Date: 2012-02-23</span></span></span></p>\r\n<p class="style1"><span style="font-size: small;"><span style="font-family: arial,helvetica,sans-serif;"><br /></span></span></p>\r\n<p class="style1"><!--[if gte mso 9]><xml> <w:WordDocument> <w:View>Normal</w:View> <w:Zoom>0</w:Zoom> <w:PunctuationKerning /> <w:ValidateAgainstSchemas /> <w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid> <w:IgnoreMixedContent>false</w:IgnoreMixedContent> <w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText> <w:Compatibility> <w:BreakWrappedTables /> <w:SnapToGridInCell /> <w:ApplyBreakingRules /> <w:WrapTextWithPunct /> <w:UseAsianBreakRules /> <w:DontGrowAutofit /> </w:Compatibility> <w:BrowserLevel>MicrosoftInternetExplorer4</w:BrowserLevel> </w:WordDocument> </xml><![endif]--><!--[if gte mso 9]><xml> <w:LatentStyles DefLockedState="false" LatentStyleCount="156"> </w:LatentStyles> </xml><![endif]--><!--[if gte mso 10]> <mce:style><!   /* Style Definitions */  table.MsoNormalTable 	{mso-style-name:"Table Normal"; 	mso-tstyle-rowband-size:0; 	mso-tstyle-colband-size:0; 	mso-style-noshow:yes; 	mso-style-parent:""; 	mso-padding-alt:0in 5.4pt 0in 5.4pt; 	mso-para-margin:0in; 	mso-para-margin-bottom:.0001pt; 	mso-pagination:widow-orphan; 	font-size:10.0pt; 	font-family:"Times New Roman"; 	mso-ansi-language:#0400; 	mso-fareast-language:#0400; 	mso-bidi-language:#0400;} --> <!--[endif]--></p>\r\n</blockquote>\r\n<blockquote>\r\n<p class="style1">Best Regards,<br /> Company<br /> http://www.domain.com</p>\r\n</blockquote>\r\n<p>&nbsp;</p>\r\n<p><span style="font-family: verdana,geneva;"><br /></span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style="background-color: #999933;"><span style="font-size: medium;"><span style="font-family: arial,helvetica,sans-serif;"><span style="color: #000000;"><span class="style3">Refrence: 2545087432</span></span></span></span></td>\r\n<td style="text-align: right; background-color: #999933;"><span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: medium;"><span class="style3"> <span style="color: #000000;">Account Number: 11220840763 </span></span></span></span></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p><span style="font-family: verdana,geneva;">&nbsp;</span></p>\r\n<div id="_mcePaste" style="position: absolute; left: -10000px; top: 0px; width: 1px; height: 1px; overflow: hidden;"><!--[if gte mso 9]><xml> <w:WordDocument> <w:View>Normal</w:View> <w:Zoom>0</w:Zoom> <w:PunctuationKerning /> <w:ValidateAgainstSchemas /> <w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid> <w:IgnoreMixedContent>false</w:IgnoreMixedContent> <w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText> <w:Compatibility> <w:BreakWrappedTables /> <w:SnapToGridInCell /> <w:ApplyBreakingRules /> <w:WrapTextWithPunct /> <w:UseAsianBreakRules /> <w:DontGrowAutofit /> </w:Compatibility> <w:BrowserLevel>MicrosoftInternetExplorer4</w:BrowserLevel> </w:WordDocument> </xml><![endif]--><!--[if gte mso 9]><xml> <w:LatentStyles DefLockedState="false" LatentStyleCount="156"> </w:LatentStyles> </xml><![endif]--><!--[if gte mso 10]> <mce:style><!   /* Style Definitions */  table.MsoNormalTable 	{mso-style-name:"Table Normal"; 	mso-tstyle-rowband-size:0; 	mso-tstyle-colband-size:0; 	mso-style-noshow:yes; 	mso-style-parent:""; 	mso-padding-alt:0in 5.4pt 0in 5.4pt; 	mso-para-margin:0in; 	mso-para-margin-bottom:.0001pt; 	mso-pagination:widow-orphan; 	font-size:10.0pt; 	font-family:"Times New Roman"; 	mso-ansi-language:#0400; 	mso-fareast-language:#0400; 	mso-bidi-language:#0400;} --> <!--[endif]-->\r\n<p class="style1"><span style="font-family: Arial; color: black;">Best Regards, <br /> </span>Fremont Trading&nbsp;<span style="font-family: Arial;"><br /> <a href="http://www.rdgtrading.com/">fremonttrading.com</a></span></p>\r\n</div>', 'Tommy Test,\r\n\r\nThank you for your recent deposit.\r\n\r\nDeposit Details:\r\nREF number: 2545087432\r\nValue: 40,000.00\r\nDate: 2012-02-23\r\n\r\n\r\nBest Regards,\r\n\r\nCompany\r\nwww.domain.com', 1, 0, 'bcc@domain.com'),
(26, '2012-11-20 04:42:45', '2012-11-20 04:42:45', '0000-00-00 00:00:00', 1, 'Buy Trade Confirmation', 'Company', 'contactus@domain.com', 'mandpelectrical@bigpond.com', 'Allen Mealy', '<table style="width: 550px;" border="0" cellpadding="3">\r\n<tbody>\r\n<tr>\r\n<td style="background-color: #999933; width: 50%;"><span style="font-size: medium;"><span style="font-family: arial,helvetica,sans-serif;"><span style="color: #000000;"><span class="style3"><strong>Trade Confirmation</strong></span></span></span></span></td>\r\n<td style="background-color: #999933; width: 50%;">\r\n<div class="style3" style="text-align: right;"><span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: medium;"><span style="color: #000000;"><strong>Date: 2012-11-20</strong></span></span></span></div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style="background-color: #f2f9af;" colspan="2">\r\n<blockquote><br /></blockquote>\r\n<blockquote><span style="font-size: small;"><span style="color: #000000;"><span style="font-family: arial,helvetica,sans-serif;">Allen Mealy,</span></span></span><br /></blockquote>\r\n<blockquote><span style="color: #000000;"><span style="font-size: small;"><span style="font-family: arial,helvetica,sans-serif;">This is an auto generated confirmation of trade email. To review this trade, please log in to your account.</span></span></span></blockquote>\r\n<blockquote>\r\n<p class="MsoNormal"><strong><span style="font-family: &quot;Arial&quot;,&quot;sans-serif&quot;; color: black;" lang="EN-CA">BUY Order Trade Details:</span></strong><span style="font-family: &quot;Arial&quot;,&quot;sans-serif&quot;; color: black;" lang="EN-CA"><br /> Positions: 9<br /> Trade: BUY 9x CALL CLG13@1,000.00 SP: $100<br /> Status: Open</span></p>\r\n<p class="MsoNormal"><span style="font-family: &quot;Arial&quot;,&quot;sans-serif&quot;; color: black;" lang="EN-CA">Positions: 3<br /> Trade: BUY 3x PUT CLG13@1,000.00 SP: $80<br /> Status: Open</span></p>\r\n<!--[if gte mso 9]><xml> <w:LatentStyles DefLockedState="false" DefUnhideWhenUsed="true"   DefSemiHidden="true" DefQFormat="false" DefPriority="99"   LatentStyleCount="267"> <w:LsdException Locked="false" Priority="0" SemiHidden="false"    UnhideWhenUsed="false" QFormat="true" Name="Normal" /> <w:LsdException Locked="false" Priority="9" SemiHidden="false"    UnhideWhenUsed="false" QFormat="true" Name="heading 1" /> <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 2" /> <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 3" /> <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 4" /> <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 5" /> <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 6" /> <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 7" /> <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 8" /> <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 9" /> <w:LsdException Locked="false" Priority="39" Name="toc 1" /> <w:LsdException Locked="false" Priority="39" Name="toc 2" /> <w:LsdException Locked="false" Priority="39" Name="toc 3" /> <w:LsdException Locked="false" Priority="39" Name="toc 4" /> <w:LsdException Locked="false" Priority="39" Name="toc 5" /> <w:LsdException Locked="false" Priority="39" Name="toc 6" /> <w:LsdException Locked="false" Priority="39" Name="toc 7" /> <w:LsdException Locked="false" Priority="39" Name="toc 8" /> <w:LsdException Locked="false" Priority="39" Name="toc 9" /> <w:LsdException Locked="false" Priority="35" QFormat="true" Name="caption" /> <w:LsdException Locked="false" Priority="10" SemiHidden="false"    UnhideWhenUsed="false" QFormat="true" Name="Title" /> <w:LsdException Locked="false" Priority="1" Name="Default Paragraph Font" /> <w:LsdException Locked="false" Priority="11" SemiHidden="false"    UnhideWhenUsed="false" QFormat="true" Name="Subtitle" /> <w:LsdException Locked="false" Priority="22" SemiHidden="false"    UnhideWhenUsed="false" QFormat="true" Name="Strong" /> <w:LsdException Locked="false" Priority="20" SemiHidden="false"    UnhideWhenUsed="false" QFormat="true" Name="Emphasis" /> <w:LsdException Locked="false" Priority="59" SemiHidden="false"    UnhideWhenUsed="false" Name="Table Grid" /> <w:LsdException Locked="false" UnhideWhenUsed="false" Name="Placeholder Text" /> <w:LsdException Locked="false" Priority="1" SemiHidden="false"    UnhideWhenUsed="false" QFormat="true" Name="No Spacing" /> <w:LsdException Locked="false" Priority="60" SemiHidden="false"    UnhideWhenUsed="false" Name="Light Shading" /> <w:LsdException Locked="false" Priority="61" SemiHidden="false"    UnhideWhenUsed="false" Name="Light List" /> <w:LsdException Locked="false" Priority="62" SemiHidden="false"    UnhideWhenUsed="false" Name="Light Grid" /> <w:LsdException Locked="false" Priority="63" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Shading 1" /> <w:LsdException Locked="false" Priority="64" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Shading 2" /> <w:LsdException Locked="false" Priority="65" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium List 1" /> <w:LsdException Locked="false" Priority="66" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium List 2" /> <w:LsdException Locked="false" Priority="67" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 1" /> <w:LsdException Locked="false" Priority="68" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 2" /> <w:LsdException Locked="false" Priority="69" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 3" /> <w:LsdException Locked="false" Priority="70" SemiHidden="false"    UnhideWhenUsed="false" Name="Dark List" /> <w:LsdException Locked="false" Priority="71" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful Shading" /> <w:LsdException Locked="false" Priority="72" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful List" /> <w:LsdException Locked="false" Priority="73" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful Grid" /> <w:LsdException Locked="false" Priority="60" SemiHidden="false"    UnhideWhenUsed="false" Name="Light Shading Accent 1" /> <w:LsdException Locked="false" Priority="61" SemiHidden="false"    UnhideWhenUsed="false" Name="Light List Accent 1" /> <w:LsdException Locked="false" Priority="62" SemiHidden="false"    UnhideWhenUsed="false" Name="Light Grid Accent 1" /> <w:LsdException Locked="false" Priority="63" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Shading 1 Accent 1" /> <w:LsdException Locked="false" Priority="64" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Shading 2 Accent 1" /> <w:LsdException Locked="false" Priority="65" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium List 1 Accent 1" /> <w:LsdException Locked="false" UnhideWhenUsed="false" Name="Revision" /> <w:LsdException Locked="false" Priority="34" SemiHidden="false"    UnhideWhenUsed="false" QFormat="true" Name="List Paragraph" /> <w:LsdException Locked="false" Priority="29" SemiHidden="false"    UnhideWhenUsed="false" QFormat="true" Name="Quote" /> <w:LsdException Locked="false" Priority="30" SemiHidden="false"    UnhideWhenUsed="false" QFormat="true" Name="Intense Quote" /> <w:LsdException Locked="false" Priority="66" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium List 2 Accent 1" /> <w:LsdException Locked="false" Priority="67" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 1 Accent 1" /> <w:LsdException Locked="false" Priority="68" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 2 Accent 1" /> <w:LsdException Locked="false" Priority="69" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 3 Accent 1" /> <w:LsdException Locked="false" Priority="70" SemiHidden="false"    UnhideWhenUsed="false" Name="Dark List Accent 1" /> <w:LsdException Locked="false" Priority="71" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful Shading Accent 1" /> <w:LsdException Locked="false" Priority="72" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful List Accent 1" /> <w:LsdException Locked="false" Priority="73" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful Grid Accent 1" /> <w:LsdException Locked="false" Priority="60" SemiHidden="false"    UnhideWhenUsed="false" Name="Light Shading Accent 2" /> <w:LsdException Locked="false" Priority="61" SemiHidden="false"    UnhideWhenUsed="false" Name="Light List Accent 2" /> <w:LsdException Locked="false" Priority="62" SemiHidden="false"    UnhideWhenUsed="false" Name="Light Grid Accent 2" /> <w:LsdException Locked="false" Priority="63" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Shading 1 Accent 2" /> <w:LsdException Locked="false" Priority="64" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Shading 2 Accent 2" /> <w:LsdException Locked="false" Priority="65" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium List 1 Accent 2" /> <w:LsdException Locked="false" Priority="66" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium List 2 Accent 2" /> <w:LsdException Locked="false" Priority="67" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 1 Accent 2" /> <w:LsdException Locked="false" Priority="68" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 2 Accent 2" /> <w:LsdException Locked="false" Priority="69" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 3 Accent 2" /> <w:LsdException Locked="false" Priority="70" SemiHidden="false"    UnhideWhenUsed="false" Name="Dark List Accent 2" /> <w:LsdException Locked="false" Priority="71" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful Shading Accent 2" /> <w:LsdException Locked="false" Priority="72" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful List Accent 2" /> <w:LsdException Locked="false" Priority="73" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful Grid Accent 2" /> <w:LsdException Locked="false" Priority="60" SemiHidden="false"    UnhideWhenUsed="false" Name="Light Shading Accent 3" /> <w:LsdException Locked="false" Priority="61" SemiHidden="false"    UnhideWhenUsed="false" Name="Light List Accent 3" /> <w:LsdException Locked="false" Priority="62" SemiHidden="false"    UnhideWhenUsed="false" Name="Light Grid Accent 3" /> <w:LsdException Locked="false" Priority="63" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Shading 1 Accent 3" /> <w:LsdException Locked="false" Priority="64" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Shading 2 Accent 3" /> <w:LsdException Locked="false" Priority="65" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium List 1 Accent 3" /> <w:LsdException Locked="false" Priority="66" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium List 2 Accent 3" /> <w:LsdException Locked="false" Priority="67" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 1 Accent 3" /> <w:LsdException Locked="false" Priority="68" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 2 Accent 3" /> <w:LsdException Locked="false" Priority="69" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 3 Accent 3" /> <w:LsdException Locked="false" Priority="70" SemiHidden="false"    UnhideWhenUsed="false" Name="Dark List Accent 3" /> <w:LsdException Locked="false" Priority="71" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful Shading Accent 3" /> <w:LsdException Locked="false" Priority="72" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful List Accent 3" /> <w:LsdException Locked="false" Priority="73" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful Grid Accent 3" /> <w:LsdException Locked="false" Priority="60" SemiHidden="false"    UnhideWhenUsed="false" Name="Light Shading Accent 4" /> <w:LsdException Locked="false" Priority="61" SemiHidden="false"    UnhideWhenUsed="false" Name="Light List Accent 4" /> <w:LsdException Locked="false" Priority="62" SemiHidden="false"    UnhideWhenUsed="false" Name="Light Grid Accent 4" /> <w:LsdException Locked="false" Priority="63" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Shading 1 Accent 4" /> <w:LsdException Locked="false" Priority="64" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Shading 2 Accent 4" /> <w:LsdException Locked="false" Priority="65" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium List 1 Accent 4" /> <w:LsdException Locked="false" Priority="66" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium List 2 Accent 4" /> <w:LsdException Locked="false" Priority="67" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 1 Accent 4" /> <w:LsdException Locked="false" Priority="68" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 2 Accent 4" /> <w:LsdException Locked="false" Priority="69" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 3 Accent 4" /> <w:LsdException Locked="false" Priority="70" SemiHidden="false"    UnhideWhenUsed="false" Name="Dark List Accent 4" /> <w:LsdException Locked="false" Priority="71" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful Shading Accent 4" /> <w:LsdException Locked="false" Priority="72" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful List Accent 4" /> <w:LsdException Locked="false" Priority="73" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful Grid Accent 4" /> <w:LsdException Locked="false" Priority="60" SemiHidden="false"    UnhideWhenUsed="false" Name="Light Shading Accent 5" /> <w:LsdException Locked="false" Priority="61" SemiHidden="false"    UnhideWhenUsed="false" Name="Light List Accent 5" /> <w:LsdException Locked="false" Priority="62" SemiHidden="false"    UnhideWhenUsed="false" Name="Light Grid Accent 5" /> <w:LsdException Locked="false" Priority="63" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Shading 1 Accent 5" /> <w:LsdException Locked="false" Priority="64" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Shading 2 Accent 5" /> <w:LsdException Locked="false" Priority="65" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium List 1 Accent 5" /> <w:LsdException Locked="false" Priority="66" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium List 2 Accent 5" /> <w:LsdException Locked="false" Priority="67" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 1 Accent 5" /> <w:LsdException Locked="false" Priority="68" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 2 Accent 5" /> <w:LsdException Locked="false" Priority="69" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 3 Accent 5" /> <w:LsdException Locked="false" Priority="70" SemiHidden="false"    UnhideWhenUsed="false" Name="Dark List Accent 5" /> <w:LsdException Locked="false" Priority="71" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful Shading Accent 5" /> <w:LsdException Locked="false" Priority="72" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful List Accent 5" /> <w:LsdException Locked="false" Priority="73" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful Grid Accent 5" /> <w:LsdException Locked="false" Priority="60" SemiHidden="false"    UnhideWhenUsed="false" Name="Light Shading Accent 6" /> <w:LsdException Locked="false" Priority="61" SemiHidden="false"    UnhideWhenUsed="false" Name="Light List Accent 6" /> <w:LsdException Locked="false" Priority="62" SemiHidden="false"    UnhideWhenUsed="false" Name="Light Grid Accent 6" /> <w:LsdException Locked="false" Priority="63" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Shading 1 Accent 6" /> <w:LsdException Locked="false" Priority="64" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Shading 2 Accent 6" /> <w:LsdException Locked="false" Priority="65" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium List 1 Accent 6" /> <w:LsdException Locked="false" Priority="66" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium List 2 Accent 6" /> <w:LsdException Locked="false" Priority="67" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 1 Accent 6" /> <w:LsdException Locked="false" Priority="68" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 2 Accent 6" /> <w:LsdException Locked="false" Priority="69" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 3 Accent 6" /> <w:LsdException Locked="false" Priority="70" SemiHidden="false"    UnhideWhenUsed="false" Name="Dark List Accent 6" /> <w:LsdException Locked="false" Priority="71" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful Shading Accent 6" /> <w:LsdException Locked="false" Priority="72" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful List Accent 6" /> <w:LsdException Locked="false" Priority="73" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful Grid Accent 6" /> <w:LsdException Locked="false" Priority="19" SemiHidden="false"    UnhideWhenUsed="false" QFormat="true" Name="Subtle Emphasis" /> <w:LsdException Locked="false" Priority="21" SemiHidden="false"    UnhideWhenUsed="false" QFormat="true" Name="Intense Emphasis" /> <w:LsdException Locked="false" Priority="31" SemiHidden="false"    UnhideWhenUsed="false" QFormat="true" Name="Subtle Reference" /> <w:LsdException Locked="false" Priority="32" SemiHidden="false"    UnhideWhenUsed="false" QFormat="true" Name="Intense Reference" /> <w:LsdException Locked="false" Priority="33" SemiHidden="false"    UnhideWhenUsed="false" QFormat="true" Name="Book Title" /> <w:LsdException Locked="false" Priority="37" Name="Bibliography" /> <w:LsdException Locked="false" Priority="39" QFormat="true" Name="TOC Heading" /> </w:LatentStyles> </xml><![endif]--><!--[if gte mso 10]>\r\n<style>\r\n /* Style Definitions */\r\n table.MsoNormalTable\r\n	{mso-style-name:"Table Normal";\r\n	mso-tstyle-rowband-size:0;\r\n	mso-tstyle-colband-size:0;\r\n	mso-style-noshow:yes;\r\n	mso-style-priority:99;\r\n	mso-style-qformat:yes;\r\n	mso-style-parent:"";\r\n	mso-padding-alt:0in 5.4pt 0in 5.4pt;\r\n	mso-para-margin:0in;\r\n	mso-para-margin-bottom:.0001pt;\r\n	mso-pagination:widow-orphan;\r\n	font-size:11.0pt;\r\n	mso-bidi-font-size:14.0pt;\r\n	font-family:"Calibri","sans-serif";\r\n	mso-ascii-font-family:Calibri;\r\n	mso-ascii-theme-font:minor-latin;\r\n	mso-fareast-font-family:"Times New Roman";\r\n	mso-fareast-theme-font:minor-fareast;\r\n	mso-hansi-font-family:Calibri;\r\n	mso-hansi-theme-font:minor-latin;\r\n	mso-bidi-font-family:"Cordia New";\r\n	mso-bidi-theme-font:minor-bidi;}\r\n</style>\r\n<![endif]--></blockquote>\r\n<p>&nbsp;</p>\r\n<p><span style="font-family: verdana,geneva;"><br /></span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style="background-color: #999933;"><span style="font-size: medium;"><span style="font-family: arial,helvetica,sans-serif;"><span style="color: #000000;"><span class="style3">Reference: 265261463523</span></span></span></span></td>\r\n<td style="text-align: right; background-color: #999933;"><span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: medium;"><span class="style3"> <span style="color: #000000;">Account Number: 14809967233 </span></span></span></span></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p><span style="font-family: verdana,geneva;">&nbsp;</span></p>\r\n<div id="_mcePaste" style="position: absolute; left: -10000px; top: 0px; width: 1px; height: 1px; overflow: hidden;"><!--[if gte mso 9]><xml> <w:WordDocument> <w:View>Normal</w:View> <w:Zoom>0</w:Zoom> <w:PunctuationKerning /> <w:ValidateAgainstSchemas /> <w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid> <w:IgnoreMixedContent>false</w:IgnoreMixedContent> <w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText> <w:Compatibility> <w:BreakWrappedTables /> <w:SnapToGridInCell /> <w:ApplyBreakingRules /> <w:WrapTextWithPunct /> <w:UseAsianBreakRules /> <w:DontGrowAutofit /> </w:Compatibility> <w:BrowserLevel>MicrosoftInternetExplorer4</w:BrowserLevel> </w:WordDocument> </xml><![endif]--><!--[if gte mso 9]><xml> <w:LatentStyles DefLockedState="false" LatentStyleCount="156"> </w:LatentStyles> </xml><![endif]--><!--[if gte mso 10]> <mce:style><!   /* Style Definitions */  table.MsoNormalTable 	{mso-style-name:"Table Normal"; 	mso-tstyle-rowband-size:0; 	mso-tstyle-colband-size:0; 	mso-style-noshow:yes; 	mso-style-parent:""; 	mso-padding-alt:0in 5.4pt 0in 5.4pt; 	mso-para-margin:0in; 	mso-para-margin-bottom:.0001pt; 	mso-pagination:widow-orphan; 	font-size:10.0pt; 	font-family:"Times New Roman"; 	mso-ansi-language:#0400; 	mso-fareast-language:#0400; 	mso-bidi-language:#0400;} --> <!--[endif]-->\r\n<p class="style1"><span style="font-family: Arial;"><br /> </span></p>\r\n</div>', 'Allen Mealy,\r\n\r\nThank you for your recent trade.\r\n\r\nYour account number: 14809967233\r\n\r\nBUY Order Trade Details:\r\nPositions: 9\r\nTrade: BUY 9x CALL CLG13@1,000.00 SP: $100\r\nStatus: Open\r\n\r\nPositions: 3\r\nTrade: BUY 3x PUT CLG13@1,000.00 SP: $80\r\nStatus: Open\r\n\r\n\r\nBest Regards,\r\n', 1, 0, 'bcc@domain.com');

-- --------------------------------------------------------

--
-- Table structure for table `mail_templates`
--

CREATE TABLE IF NOT EXISTS `mail_templates` (
  `mail_templates_id` int(11) NOT NULL auto_increment,
  `mail_template_title` varchar(255) default NULL,
  `mail_from_mail` varchar(255) default NULL,
  `mail_from` text,
  `mail_subject` text,
  `mail_html` blob,
  `mail_plain` blob,
  `mail_bcc` varchar(255) default NULL,
  `mail_single` tinyint(3) NOT NULL default '1',
  PRIMARY KEY  (`mail_templates_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `mail_templates`
--

INSERT INTO `mail_templates` (`mail_templates_id`, `mail_template_title`, `mail_from_mail`, `mail_from`, `mail_subject`, `mail_html`, `mail_plain`, `mail_bcc`, `mail_single`) VALUES
(2, 'Request Password', 'contact@domain.com', 'Company', 'Your New Password', 0x3c703e48656c6c6f207b757365725f66697273745f6e616d657d207b757365725f6c6173745f6e616d657d2c3c6272202f3e3c6272202f3e596f7520617265206365636576696e672074686973206d61696c206265636175736520796f752c206f7220736f6d656f6e652072657175657374656420796f75722070617373776f72642e3c6272202f3e3c6272202f3e596f7572206163636f756e74206e756d6265723a207b757365725f6163636f756e745f6e756d7d3c6272202f3e596f757220757365726e616d653a207b757365725f757365726e616d657d3c6272202f3e596f7572206e65772070617373776f72643a207b757365725f70617373776f72647d3c6272202f3e3c6272202f3e5765207374726f6e676c79207265636f6d6d656e6420796f7520746f206368616e676520796f75722070617373776f7264206166746572206c6f6720696e2e3c6272202f3e3c6272202f3e7b7468616e6b737d3c6272202f3e207b636f6d70616e795f6e616d657d3c6272202f3e207b736974655f75726c7d3c2f703e, 0x48656c6c6f207b757365725f66697273745f6e616d657d207b757365725f6c6173745f6e616d657d2c0d0a0d0a596f7520617265206365636576696e672074686973206d61696c206265636175736520796f752c206f7220736f6d656f6e652072657175657374656420796f75722070617373776f72642e0d0a0d0a596f7572206163636f756e74206e756d6265723a207b757365725f6163636f756e745f6e756d7d0d0a596f757220757365726e616d653a207b757365725f757365726e616d657d0d0a596f7572206e65772070617373776f72643a207b757365725f70617373776f72647d0d0a0d0a5765207374726f6e676c79207265636f6d6d656e6420796f7520746f206368616e676520796f75722070617373776f7264206166746572206c6f6720696e2e0d0a0d0a7b7468616e6b737d0d0a7b636f6d70616e795f6e616d657d0d0a7b736974655f75726c7d, 'bcc@domain.com', 1),
(5, 'Buy Details', 'contactus@domain.com', 'Company', 'Buy Trade Confirmation', 0x3c7461626c65207374796c653d2277696474683a2035353070783b2220626f726465723d2230222063656c6c70616464696e673d2233223e0d0a3c74626f64793e0d0a3c74723e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20233939393933333b2077696474683a203530253b223e3c7370616e207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7370616e20636c6173733d227374796c6533223e3c7374726f6e673e547261646520436f6e6669726d6174696f6e3c2f7374726f6e673e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f74643e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20233939393933333b2077696474683a203530253b223e0d0a3c64697620636c6173733d227374796c653322207374796c653d22746578742d616c69676e3a2072696768743b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7374726f6e673e446174653a207b74726164655f646174657d3c2f7374726f6e673e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f6469763e0d0a3c2f74643e0d0a3c2f74723e0d0a3c74723e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20236632663961663b2220636f6c7370616e3d2232223e0d0a3c626c6f636b71756f74653e3c6272202f3e3c2f626c6f636b71756f74653e0d0a3c626c6f636b71756f74653e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e7b757365725f66697273745f6e616d657d207b757365725f6c6173745f6e616d657d2c3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c6272202f3e3c2f626c6f636b71756f74653e0d0a3c626c6f636b71756f74653e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e5468697320697320616e206175746f2067656e65726174656420636f6e6669726d6174696f6e206f6620747261646520656d61696c2e20546f2072657669657720746869732074726164652c20706c65617365206c6f6720696e20746f20796f7572206163636f756e742e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f626c6f636b71756f74653e0d0a3c626c6f636b71756f74653e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c6272202f3e3c7374726f6e673e425559204f726465722054726164652044657461696c733a3c2f7374726f6e673e3c6272202f3e506f736974696f6e733a207b74726164655f706f736974696f6e737d3c6272202f3e54726164653a207b74726164655f64657461696c737d3c6272202f3e5374617475733a207b74726164655f7374617475737d3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f626c6f636b71756f74653e0d0a3c626c6f636b71756f74653e0d0a3c7020636c6173733d227374796c6531223e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c6272202f3e3c2f7370616e3e3c2f7370616e3e3c2f703e0d0a3c7020636c6173733d227374796c6531223e3c212d2d5b696620677465206d736f20395d3e3c786d6c3e203c773a576f7264446f63756d656e743e203c773a566965773e4e6f726d616c3c2f773a566965773e203c773a5a6f6f6d3e303c2f773a5a6f6f6d3e203c773a50756e6374756174696f6e4b65726e696e67202f3e203c773a56616c6964617465416761696e7374536368656d6173202f3e203c773a536176654966584d4c496e76616c69643e66616c73653c2f773a536176654966584d4c496e76616c69643e203c773a49676e6f72654d69786564436f6e74656e743e66616c73653c2f773a49676e6f72654d69786564436f6e74656e743e203c773a416c7761797353686f77506c616365686f6c646572546578743e66616c73653c2f773a416c7761797353686f77506c616365686f6c646572546578743e203c773a436f6d7061746962696c6974793e203c773a427265616b577261707065645461626c6573202f3e203c773a536e6170546f47726964496e43656c6c202f3e203c773a4170706c79427265616b696e6752756c6573202f3e203c773a57726170546578745769746850756e6374202f3e203c773a557365417369616e427265616b52756c6573202f3e203c773a446f6e7447726f774175746f666974202f3e203c2f773a436f6d7061746962696c6974793e203c773a42726f777365724c6576656c3e4d6963726f736f6674496e7465726e65744578706c6f726572343c2f773a42726f777365724c6576656c3e203c2f773a576f7264446f63756d656e743e203c2f786d6c3e3c215b656e6469665d2d2d3e3c212d2d5b696620677465206d736f20395d3e3c786d6c3e203c773a4c6174656e745374796c6573204465664c6f636b656453746174653d2266616c736522204c6174656e745374796c65436f756e743d22313536223e203c2f773a4c6174656e745374796c65733e203c2f786d6c3e3c215b656e6469665d2d2d3e3c212d2d5b696620677465206d736f2031305d3e203c6d63653a7374796c653e3c212020202f2a205374796c6520446566696e6974696f6e73202a2f20207461626c652e4d736f4e6f726d616c5461626c6520097b6d736f2d7374796c652d6e616d653a225461626c65204e6f726d616c223b20096d736f2d747374796c652d726f7762616e642d73697a653a303b20096d736f2d747374796c652d636f6c62616e642d73697a653a303b20096d736f2d7374796c652d6e6f73686f773a7965733b20096d736f2d7374796c652d706172656e743a22223b20096d736f2d70616464696e672d616c743a30696e20352e3470742030696e20352e3470743b20096d736f2d706172612d6d617267696e3a30696e3b20096d736f2d706172612d6d617267696e2d626f74746f6d3a2e3030303170743b20096d736f2d706167696e6174696f6e3a7769646f772d6f727068616e3b2009666f6e742d73697a653a31302e3070743b2009666f6e742d66616d696c793a2254696d6573204e657720526f6d616e223b20096d736f2d616e73692d6c616e67756167653a23303430303b20096d736f2d666172656173742d6c616e67756167653a23303430303b20096d736f2d626964692d6c616e67756167653a23303430303b7d202d2d3e203c212d2d5b656e6469665d2d2d3e3c2f703e0d0a3c2f626c6f636b71756f74653e0d0a3c626c6f636b71756f74653e0d0a3c7020636c6173733d227374796c6531223e7b7468616e6b737d3c2f703e0d0a3c7020636c6173733d227374796c6531223e3c6272202f3e207b636f6d70616e795f6e616d657d3c6272202f3e207b736974655f75726c7d3c2f703e0d0a3c2f626c6f636b71756f74653e0d0a3c703e266e6273703b3c2f703e0d0a3c703e3c7370616e207374796c653d22666f6e742d66616d696c793a2076657264616e612c67656e6576613b223e3c6272202f3e3c2f7370616e3e3c2f703e0d0a3c2f74643e0d0a3c2f74723e0d0a3c74723e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20233939393933333b223e3c7370616e207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7370616e20636c6173733d227374796c6533223e5265666572656e63653a207b74726164655f7265667d3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f74643e0d0a3c7464207374796c653d22746578742d616c69676e3a2072696768743b206261636b67726f756e642d636f6c6f723a20233939393933333b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7370616e20636c6173733d227374796c6533223e203c7370616e207374796c653d22636f6c6f723a20233030303030303b223e4163636f756e74204e756d6265723a207b757365725f6163636f756e745f6e756d7d203c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f74643e0d0a3c2f74723e0d0a3c2f74626f64793e0d0a3c2f7461626c653e0d0a3c703e3c7370616e207374796c653d22666f6e742d66616d696c793a2076657264616e612c67656e6576613b223e266e6273703b3c2f7370616e3e3c2f703e0d0a3c6469762069643d225f6d6365506173746522207374796c653d22706f736974696f6e3a206162736f6c7574653b206c6566743a202d313030303070783b20746f703a203070783b2077696474683a203170783b206865696768743a203170783b206f766572666c6f773a2068696464656e3b223e3c212d2d5b696620677465206d736f20395d3e3c786d6c3e203c773a576f7264446f63756d656e743e203c773a566965773e4e6f726d616c3c2f773a566965773e203c773a5a6f6f6d3e303c2f773a5a6f6f6d3e203c773a50756e6374756174696f6e4b65726e696e67202f3e203c773a56616c6964617465416761696e7374536368656d6173202f3e203c773a536176654966584d4c496e76616c69643e66616c73653c2f773a536176654966584d4c496e76616c69643e203c773a49676e6f72654d69786564436f6e74656e743e66616c73653c2f773a49676e6f72654d69786564436f6e74656e743e203c773a416c7761797353686f77506c616365686f6c646572546578743e66616c73653c2f773a416c7761797353686f77506c616365686f6c646572546578743e203c773a436f6d7061746962696c6974793e203c773a427265616b577261707065645461626c6573202f3e203c773a536e6170546f47726964496e43656c6c202f3e203c773a4170706c79427265616b696e6752756c6573202f3e203c773a57726170546578745769746850756e6374202f3e203c773a557365417369616e427265616b52756c6573202f3e203c773a446f6e7447726f774175746f666974202f3e203c2f773a436f6d7061746962696c6974793e203c773a42726f777365724c6576656c3e4d6963726f736f6674496e7465726e65744578706c6f726572343c2f773a42726f777365724c6576656c3e203c2f773a576f7264446f63756d656e743e203c2f786d6c3e3c215b656e6469665d2d2d3e3c212d2d5b696620677465206d736f20395d3e3c786d6c3e203c773a4c6174656e745374796c6573204465664c6f636b656453746174653d2266616c736522204c6174656e745374796c65436f756e743d22313536223e203c2f773a4c6174656e745374796c65733e203c2f786d6c3e3c215b656e6469665d2d2d3e3c212d2d5b696620677465206d736f2031305d3e203c6d63653a7374796c653e3c212020202f2a205374796c6520446566696e6974696f6e73202a2f20207461626c652e4d736f4e6f726d616c5461626c6520097b6d736f2d7374796c652d6e616d653a225461626c65204e6f726d616c223b20096d736f2d747374796c652d726f7762616e642d73697a653a303b20096d736f2d747374796c652d636f6c62616e642d73697a653a303b20096d736f2d7374796c652d6e6f73686f773a7965733b20096d736f2d7374796c652d706172656e743a22223b20096d736f2d70616464696e672d616c743a30696e20352e3470742030696e20352e3470743b20096d736f2d706172612d6d617267696e3a30696e3b20096d736f2d706172612d6d617267696e2d626f74746f6d3a2e3030303170743b20096d736f2d706167696e6174696f6e3a7769646f772d6f727068616e3b2009666f6e742d73697a653a31302e3070743b2009666f6e742d66616d696c793a2254696d6573204e657720526f6d616e223b20096d736f2d616e73692d6c616e67756167653a23303430303b20096d736f2d666172656173742d6c616e67756167653a23303430303b20096d736f2d626964692d6c616e67756167653a23303430303b7d202d2d3e203c212d2d5b656e6469665d2d2d3e0d0a3c7020636c6173733d227374796c6531223e3c7370616e207374796c653d22666f6e742d66616d696c793a20417269616c3b223e3c6272202f3e203c2f7370616e3e3c2f703e0d0a3c2f6469763e, 0x7b757365725f66697273745f6e616d657d207b757365725f6c6173745f6e616d657d2c0d0a0d0a5468616e6b20796f7520666f7220796f757220726563656e742074726164652e0d0a0d0a596f7572206163636f756e74206e756d6265723a207b757365725f6163636f756e745f6e756d7d0d0a0d0a4255592054726164652044657461696c730d0a524546206e756d6265723a207b74726164655f7265667d0d0a506f736974696f6e733a207b74726164655f706f736974696f6e737d0d0a53686f727420496e666f3a207b74726164655f64657461696c737d0d0a5374617475733a207b74726164655f7374617475737d0d0a446174653a207b74726164655f646174657d0d0a0d0a0d0a4265737420526567617264732c0d0a0d0a4f7269656e74616c20467574757265732054726164696e670d0a687474703a2f2f6f662d74726164696e672e636f6d, 'bcc@domain.com', 0),
(6, 'Sell Details', 'contact@domain.com', 'Company', 'SELL Details', 0x3c7461626c65207374796c653d2277696474683a2035353070783b2220626f726465723d2230222063656c6c70616464696e673d2233223e0d0a3c74626f64793e0d0a3c74723e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20233939393933333b2077696474683a203530253b223e3c7370616e207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7370616e20636c6173733d227374796c6533223e3c7374726f6e673e547261646520436f6e6669726d6174696f6e3c2f7374726f6e673e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f74643e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20233939393933333b2077696474683a203530253b223e0d0a3c64697620636c6173733d227374796c653322207374796c653d22746578742d616c69676e3a2072696768743b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7374726f6e673e446174653a207b74726164655f646174657d3c2f7374726f6e673e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f6469763e0d0a3c2f74643e0d0a3c2f74723e0d0a3c74723e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20236632663961663b2220636f6c7370616e3d2232223e0d0a3c626c6f636b71756f74653e3c6272202f3e3c2f626c6f636b71756f74653e0d0a3c626c6f636b71756f74653e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e7b757365725f66697273745f6e616d657d207b757365725f6c6173745f6e616d657d2c3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c6272202f3e3c2f626c6f636b71756f74653e0d0a3c626c6f636b71756f74653e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e5468697320697320616e206175746f2067656e65726174656420636f6e6669726d6174696f6e206f6620747261646520656d61696c2e20546f2072657669657720746869732074726164652c20706c65617365206c6f6720696e20746f20796f7572206163636f756e742e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f626c6f636b71756f74653e0d0a3c626c6f636b71756f74653e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c6272202f3e3c7374726f6e673e53454c4c204f726465722054726164652044657461696c733a3c2f7374726f6e673e3c6272202f3e506f736974696f6e733a207b74726164655f706f736974696f6e737d3c6272202f3e54726164653a207b74726164655f64657461696c737d3c6272202f3e5374617475733a207b74726164655f7374617475737d3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f626c6f636b71756f74653e0d0a3c626c6f636b71756f74653e0d0a3c7020636c6173733d227374796c6531223e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c6272202f3e3c2f7370616e3e3c2f7370616e3e3c2f703e0d0a3c7020636c6173733d227374796c6531223e3c212d2d5b696620677465206d736f20395d3e3c786d6c3e203c773a576f7264446f63756d656e743e203c773a566965773e4e6f726d616c3c2f773a566965773e203c773a5a6f6f6d3e303c2f773a5a6f6f6d3e203c773a50756e6374756174696f6e4b65726e696e67202f3e203c773a56616c6964617465416761696e7374536368656d6173202f3e203c773a536176654966584d4c496e76616c69643e66616c73653c2f773a536176654966584d4c496e76616c69643e203c773a49676e6f72654d69786564436f6e74656e743e66616c73653c2f773a49676e6f72654d69786564436f6e74656e743e203c773a416c7761797353686f77506c616365686f6c646572546578743e66616c73653c2f773a416c7761797353686f77506c616365686f6c646572546578743e203c773a436f6d7061746962696c6974793e203c773a427265616b577261707065645461626c6573202f3e203c773a536e6170546f47726964496e43656c6c202f3e203c773a4170706c79427265616b696e6752756c6573202f3e203c773a57726170546578745769746850756e6374202f3e203c773a557365417369616e427265616b52756c6573202f3e203c773a446f6e7447726f774175746f666974202f3e203c2f773a436f6d7061746962696c6974793e203c773a42726f777365724c6576656c3e4d6963726f736f6674496e7465726e65744578706c6f726572343c2f773a42726f777365724c6576656c3e203c2f773a576f7264446f63756d656e743e203c2f786d6c3e3c215b656e6469665d2d2d3e3c212d2d5b696620677465206d736f20395d3e3c786d6c3e203c773a4c6174656e745374796c6573204465664c6f636b656453746174653d2266616c736522204c6174656e745374796c65436f756e743d22313536223e203c2f773a4c6174656e745374796c65733e203c2f786d6c3e3c215b656e6469665d2d2d3e3c212d2d5b696620677465206d736f2031305d3e203c6d63653a7374796c653e3c212020202f2a205374796c6520446566696e6974696f6e73202a2f20207461626c652e4d736f4e6f726d616c5461626c6520097b6d736f2d7374796c652d6e616d653a225461626c65204e6f726d616c223b20096d736f2d747374796c652d726f7762616e642d73697a653a303b20096d736f2d747374796c652d636f6c62616e642d73697a653a303b20096d736f2d7374796c652d6e6f73686f773a7965733b20096d736f2d7374796c652d706172656e743a22223b20096d736f2d70616464696e672d616c743a30696e20352e3470742030696e20352e3470743b20096d736f2d706172612d6d617267696e3a30696e3b20096d736f2d706172612d6d617267696e2d626f74746f6d3a2e3030303170743b20096d736f2d706167696e6174696f6e3a7769646f772d6f727068616e3b2009666f6e742d73697a653a31302e3070743b2009666f6e742d66616d696c793a2254696d6573204e657720526f6d616e223b20096d736f2d616e73692d6c616e67756167653a23303430303b20096d736f2d666172656173742d6c616e67756167653a23303430303b20096d736f2d626964692d6c616e67756167653a23303430303b7d202d2d3e203c212d2d5b656e6469665d2d2d3e3c2f703e0d0a3c2f626c6f636b71756f74653e0d0a3c626c6f636b71756f74653e0d0a3c7020636c6173733d227374796c6531223e7b7468616e6b737d3c6272202f3e207b636f6d70616e795f6e616d657d3c6272202f3e207b736974655f75726c7d3c2f703e0d0a3c2f626c6f636b71756f74653e0d0a3c703e266e6273703b3c2f703e0d0a3c703e3c7370616e207374796c653d22666f6e742d66616d696c793a2076657264616e612c67656e6576613b223e3c6272202f3e3c2f7370616e3e3c2f703e0d0a3c2f74643e0d0a3c2f74723e0d0a3c74723e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20233939393933333b223e3c7370616e207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7370616e20636c6173733d227374796c6533223e5265666572656e63653a207b74726164655f7265667d3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f74643e0d0a3c7464207374796c653d22746578742d616c69676e3a2072696768743b206261636b67726f756e642d636f6c6f723a20233939393933333b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7370616e20636c6173733d227374796c6533223e203c7370616e207374796c653d22636f6c6f723a20233030303030303b223e4163636f756e74204e756d6265723a207b757365725f6163636f756e745f6e756d7d203c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f74643e0d0a3c2f74723e0d0a3c2f74626f64793e0d0a3c2f7461626c653e0d0a3c703e3c7370616e207374796c653d22666f6e742d66616d696c793a2076657264616e612c67656e6576613b223e266e6273703b3c2f7370616e3e3c2f703e0d0a3c6469762069643d225f6d6365506173746522207374796c653d22706f736974696f6e3a206162736f6c7574653b206c6566743a202d313030303070783b20746f703a203070783b2077696474683a203170783b206865696768743a203170783b206f766572666c6f773a2068696464656e3b223e3c212d2d5b696620677465206d736f20395d3e3c786d6c3e203c773a576f7264446f63756d656e743e203c773a566965773e4e6f726d616c3c2f773a566965773e203c773a5a6f6f6d3e303c2f773a5a6f6f6d3e203c773a50756e6374756174696f6e4b65726e696e67202f3e203c773a56616c6964617465416761696e7374536368656d6173202f3e203c773a536176654966584d4c496e76616c69643e66616c73653c2f773a536176654966584d4c496e76616c69643e203c773a49676e6f72654d69786564436f6e74656e743e66616c73653c2f773a49676e6f72654d69786564436f6e74656e743e203c773a416c7761797353686f77506c616365686f6c646572546578743e66616c73653c2f773a416c7761797353686f77506c616365686f6c646572546578743e203c773a436f6d7061746962696c6974793e203c773a427265616b577261707065645461626c6573202f3e203c773a536e6170546f47726964496e43656c6c202f3e203c773a4170706c79427265616b696e6752756c6573202f3e203c773a57726170546578745769746850756e6374202f3e203c773a557365417369616e427265616b52756c6573202f3e203c773a446f6e7447726f774175746f666974202f3e203c2f773a436f6d7061746962696c6974793e203c773a42726f777365724c6576656c3e4d6963726f736f6674496e7465726e65744578706c6f726572343c2f773a42726f777365724c6576656c3e203c2f773a576f7264446f63756d656e743e203c2f786d6c3e3c215b656e6469665d2d2d3e3c212d2d5b696620677465206d736f20395d3e3c786d6c3e203c773a4c6174656e745374796c6573204465664c6f636b656453746174653d2266616c736522204c6174656e745374796c65436f756e743d22313536223e203c2f773a4c6174656e745374796c65733e203c2f786d6c3e3c215b656e6469665d2d2d3e3c212d2d5b696620677465206d736f2031305d3e203c6d63653a7374796c653e3c212020202f2a205374796c6520446566696e6974696f6e73202a2f20207461626c652e4d736f4e6f726d616c5461626c6520097b6d736f2d7374796c652d6e616d653a225461626c65204e6f726d616c223b20096d736f2d747374796c652d726f7762616e642d73697a653a303b20096d736f2d747374796c652d636f6c62616e642d73697a653a303b20096d736f2d7374796c652d6e6f73686f773a7965733b20096d736f2d7374796c652d706172656e743a22223b20096d736f2d70616464696e672d616c743a30696e20352e3470742030696e20352e3470743b20096d736f2d706172612d6d617267696e3a30696e3b20096d736f2d706172612d6d617267696e2d626f74746f6d3a2e3030303170743b20096d736f2d706167696e6174696f6e3a7769646f772d6f727068616e3b2009666f6e742d73697a653a31302e3070743b2009666f6e742d66616d696c793a2254696d6573204e657720526f6d616e223b20096d736f2d616e73692d6c616e67756167653a23303430303b20096d736f2d666172656173742d6c616e67756167653a23303430303b20096d736f2d626964692d6c616e67756167653a23303430303b7d202d2d3e203c212d2d5b656e6469665d2d2d3e0d0a3c7020636c6173733d227374796c6531223e3c7370616e207374796c653d22666f6e742d66616d696c793a20417269616c3b20636f6c6f723a20626c61636b3b223e4265737420526567617264732c203c6272202f3e203c2f7370616e3e4672656d6f6e742054726164696e67266e6273703b3c7370616e207374796c653d22666f6e742d66616d696c793a20417269616c3b223e3c6272202f3e203c6120687265663d22687474703a2f2f7777772e72646774726164696e672e636f6d2f223e6672656d6f6e7474726164696e672e636f6d3c2f613e3c2f7370616e3e3c2f703e0d0a3c2f6469763e, 0x48656c6c6f207b757365725f66697273745f6e616d657d207b757365725f6c6173745f6e616d657d2c0d0a0d0a546865736520617265207468652064657461696c73206f6620796f757220726563656e742073656c6c206f726465722e0d0a0d0a0d0a53656c6c2054726164652044657461696c730d0a524546206e756d6265723a207b74726164655f7265667d0d0a506f736974696f6e733a207b74726164655f706f736974696f6e737d0d0a45787069727920446174653a207b74726164655f6578706972797d0d0a53686f727420496e666f3a207b74726164655f64657461696c737d0d0a5374617475733a207b74726164655f7374617475737d0d0a446174653a207b74726164655f646174657d0d0a0d0a0d0a7b7468616e6b737d0d0a7b636f6d70616e795f6e616d657d0d0a7b736974655f75726c7d, 'bcc@domain.com', 0),
(3, 'Deposit Details', 'contactus@domain.com', 'Company', 'Deposit Confirmation', 0x3c7461626c65207374796c653d2277696474683a2035373170783b206865696768743a2034313170783b2220626f726465723d2230222063656c6c70616464696e673d2233223e0d0a3c74626f64793e0d0a3c74723e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20233939393933333b2077696474683a203530253b223e3c7370616e207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7370616e20636c6173733d227374796c6533223e3c7374726f6e673e4465706f73697420436f6e6669726d6174696f6e3c2f7374726f6e673e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f74643e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20233939393933333b2077696474683a203530253b223e0d0a3c64697620636c6173733d227374796c653322207374796c653d22746578742d616c69676e3a2072696768743b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7374726f6e673e446174653a207b7472616e736665725f646174657d3c2f7374726f6e673e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f6469763e0d0a3c2f74643e0d0a3c2f74723e0d0a3c74723e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20236632663961663b2220636f6c7370616e3d2232223e0d0a3c626c6f636b71756f74653e0d0a3c7020636c6173733d227374796c6531223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e207b757365725f66697273745f6e616d657d207b757365725f6c6173745f6e616d657d2c3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f703e0d0a3c7020636c6173733d227374796c6531223e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e5468697320697320616e206175746f2067656e65726174656420636f6e6669726d6174696f6e2072656365697074206f66207061796d656e742e20546f207265766965772074686973206465706f7369742c20706c65617365203c7370616e207374796c653d22666f6e742d66616d696c793a20417269616c2c48656c7665746963612c73616e732d73657269663b20666f6e742d73697a653a20313270783b223e6c6f6720696e20746f20796f7572206163636f756e743c2f7370616e3e2e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e203c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c6120687265663d222e2e2f696e6465782e706870223e3c2f613e3c2f703e0d0a3c7020636c6173733d227374796c6531223e266e6273703b3c2f703e0d0a3c7020636c6173733d227374796c6531223e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7374726f6e673e4465706f7369742044657461696c733c2f7374726f6e673e3a3c6272202f3e56616c75653a20247b7472616e736665725f76616c75657d3c6272202f3e446174653a207b7472616e736665725f646174657d3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f703e0d0a3c7020636c6173733d227374796c6531223e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c6272202f3e3c2f7370616e3e3c2f7370616e3e3c2f703e0d0a3c7020636c6173733d227374796c6531223e3c212d2d5b696620677465206d736f20395d3e3c786d6c3e203c773a576f7264446f63756d656e743e203c773a566965773e4e6f726d616c3c2f773a566965773e203c773a5a6f6f6d3e303c2f773a5a6f6f6d3e203c773a50756e6374756174696f6e4b65726e696e67202f3e203c773a56616c6964617465416761696e7374536368656d6173202f3e203c773a536176654966584d4c496e76616c69643e66616c73653c2f773a536176654966584d4c496e76616c69643e203c773a49676e6f72654d69786564436f6e74656e743e66616c73653c2f773a49676e6f72654d69786564436f6e74656e743e203c773a416c7761797353686f77506c616365686f6c646572546578743e66616c73653c2f773a416c7761797353686f77506c616365686f6c646572546578743e203c773a436f6d7061746962696c6974793e203c773a427265616b577261707065645461626c6573202f3e203c773a536e6170546f47726964496e43656c6c202f3e203c773a4170706c79427265616b696e6752756c6573202f3e203c773a57726170546578745769746850756e6374202f3e203c773a557365417369616e427265616b52756c6573202f3e203c773a446f6e7447726f774175746f666974202f3e203c2f773a436f6d7061746962696c6974793e203c773a42726f777365724c6576656c3e4d6963726f736f6674496e7465726e65744578706c6f726572343c2f773a42726f777365724c6576656c3e203c2f773a576f7264446f63756d656e743e203c2f786d6c3e3c215b656e6469665d2d2d3e3c212d2d5b696620677465206d736f20395d3e3c786d6c3e203c773a4c6174656e745374796c6573204465664c6f636b656453746174653d2266616c736522204c6174656e745374796c65436f756e743d22313536223e203c2f773a4c6174656e745374796c65733e203c2f786d6c3e3c215b656e6469665d2d2d3e3c212d2d5b696620677465206d736f2031305d3e203c6d63653a7374796c653e3c212020202f2a205374796c6520446566696e6974696f6e73202a2f20207461626c652e4d736f4e6f726d616c5461626c6520097b6d736f2d7374796c652d6e616d653a225461626c65204e6f726d616c223b20096d736f2d747374796c652d726f7762616e642d73697a653a303b20096d736f2d747374796c652d636f6c62616e642d73697a653a303b20096d736f2d7374796c652d6e6f73686f773a7965733b20096d736f2d7374796c652d706172656e743a22223b20096d736f2d70616464696e672d616c743a30696e20352e3470742030696e20352e3470743b20096d736f2d706172612d6d617267696e3a30696e3b20096d736f2d706172612d6d617267696e2d626f74746f6d3a2e3030303170743b20096d736f2d706167696e6174696f6e3a7769646f772d6f727068616e3b2009666f6e742d73697a653a31302e3070743b2009666f6e742d66616d696c793a2254696d6573204e657720526f6d616e223b20096d736f2d616e73692d6c616e67756167653a23303430303b20096d736f2d666172656173742d6c616e67756167653a23303430303b20096d736f2d626964692d6c616e67756167653a23303430303b7d202d2d3e203c212d2d5b656e6469665d2d2d3e3c2f703e0d0a3c2f626c6f636b71756f74653e0d0a3c626c6f636b71756f74653e0d0a3c7020636c6173733d227374796c6531223e3c6272202f3e7b7468616e6b737d3c2f703e0d0a3c7020636c6173733d227374796c6531223e3c6272202f3e7b636f6d70616e795f6e616d657d3c6272202f3e7b736974655f75726c7d3c2f703e0d0a3c2f626c6f636b71756f74653e0d0a3c703e266e6273703b3c2f703e0d0a3c703e3c7370616e207374796c653d22666f6e742d66616d696c793a2076657264616e612c67656e6576613b223e3c6272202f3e3c2f7370616e3e3c2f703e0d0a3c2f74643e0d0a3c2f74723e0d0a3c74723e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20233939393933333b223e3c7370616e207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7370616e20636c6173733d227374796c6533223e5265666572656e63653a207b7472616e736665725f7265667d3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f74643e0d0a3c7464207374796c653d22746578742d616c69676e3a206c6566743b206261636b67726f756e642d636f6c6f723a20233939393933333b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7370616e20636c6173733d227374796c6533223e203c7370616e207374796c653d22636f6c6f723a20233030303030303b223e4163636f756e74204e756d6265723a207b757365725f6163636f756e745f6e756d7d203c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f74643e0d0a3c2f74723e0d0a3c2f74626f64793e0d0a3c2f7461626c653e0d0a3c703e3c7370616e207374796c653d22666f6e742d66616d696c793a2076657264616e612c67656e6576613b223e266e6273703b3c2f7370616e3e3c2f703e0d0a3c6469762069643d225f6d6365506173746522207374796c653d22706f736974696f6e3a206162736f6c7574653b206c6566743a202d313030303070783b20746f703a203070783b2077696474683a203170783b206865696768743a203170783b206f766572666c6f773a2068696464656e3b223e3c212d2d5b696620677465206d736f20395d3e3c786d6c3e203c773a576f7264446f63756d656e743e203c773a566965773e4e6f726d616c3c2f773a566965773e203c773a5a6f6f6d3e303c2f773a5a6f6f6d3e203c773a50756e6374756174696f6e4b65726e696e67202f3e203c773a56616c6964617465416761696e7374536368656d6173202f3e203c773a536176654966584d4c496e76616c69643e66616c73653c2f773a536176654966584d4c496e76616c69643e203c773a49676e6f72654d69786564436f6e74656e743e66616c73653c2f773a49676e6f72654d69786564436f6e74656e743e203c773a416c7761797353686f77506c616365686f6c646572546578743e66616c73653c2f773a416c7761797353686f77506c616365686f6c646572546578743e203c773a436f6d7061746962696c6974793e203c773a427265616b577261707065645461626c6573202f3e203c773a536e6170546f47726964496e43656c6c202f3e203c773a4170706c79427265616b696e6752756c6573202f3e203c773a57726170546578745769746850756e6374202f3e203c773a557365417369616e427265616b52756c6573202f3e203c773a446f6e7447726f774175746f666974202f3e203c2f773a436f6d7061746962696c6974793e203c773a42726f777365724c6576656c3e4d6963726f736f6674496e7465726e65744578706c6f726572343c2f773a42726f777365724c6576656c3e203c2f773a576f7264446f63756d656e743e203c2f786d6c3e3c215b656e6469665d2d2d3e3c212d2d5b696620677465206d736f20395d3e3c786d6c3e203c773a4c6174656e745374796c6573204465664c6f636b656453746174653d2266616c736522204c6174656e745374796c65436f756e743d22313536223e203c2f773a4c6174656e745374796c65733e203c2f786d6c3e3c215b656e6469665d2d2d3e3c212d2d5b696620677465206d736f2031305d3e203c6d63653a7374796c653e3c212020202f2a205374796c6520446566696e6974696f6e73202a2f20207461626c652e4d736f4e6f726d616c5461626c6520097b6d736f2d7374796c652d6e616d653a225461626c65204e6f726d616c223b20096d736f2d747374796c652d726f7762616e642d73697a653a303b20096d736f2d747374796c652d636f6c62616e642d73697a653a303b20096d736f2d7374796c652d6e6f73686f773a7965733b20096d736f2d7374796c652d706172656e743a22223b20096d736f2d70616464696e672d616c743a30696e20352e3470742030696e20352e3470743b20096d736f2d706172612d6d617267696e3a30696e3b20096d736f2d706172612d6d617267696e2d626f74746f6d3a2e3030303170743b20096d736f2d706167696e6174696f6e3a7769646f772d6f727068616e3b2009666f6e742d73697a653a31302e3070743b2009666f6e742d66616d696c793a2254696d6573204e657720526f6d616e223b20096d736f2d616e73692d6c616e67756167653a23303430303b20096d736f2d666172656173742d6c616e67756167653a23303430303b20096d736f2d626964692d6c616e67756167653a23303430303b7d202d2d3e203c212d2d5b656e6469665d2d2d3e0d0a3c7020636c6173733d227374796c6531223e3c7370616e207374796c653d22666f6e742d66616d696c793a20417269616c3b20636f6c6f723a20626c61636b3b223e4265737420526567617264732c203c6272202f3e203c2f7370616e3e4672656d6f6e742054726164696e67266e6273703b3c7370616e207374796c653d22666f6e742d66616d696c793a20417269616c3b223e3c6272202f3e203c6120687265663d22687474703a2f2f7777772e72646774726164696e672e636f6d2f223e6672656d6f6e7474726164696e672e636f6d3c2f613e3c2f7370616e3e3c2f703e0d0a3c2f6469763e, 0x7b757365725f66697273745f6e616d657d207b757365725f6c6173745f6e616d657d2c0d0a0d0a5468616e6b20796f7520666f7220796f757220726563656e74206465706f7369742e0d0a0d0a4465706f7369742044657461696c733a0d0a524546206e756d6265723a207b7472616e736665725f7265667d0d0a56616c75653a20247b7472616e736665725f76616c75657d0d0a446174653a207b7472616e736665725f646174657d0d0a0d0a0d0a4265737420526567617264732c0d0a0d0a4f7269656e74616c20467574757265732054726164696e670d0a6f662d74726164696e672e636f6d, 'bcc@domain.com', 0),
(4, 'Withdraw Details', 'contact@domain.com', 'Company', 'Withdraw Details', 0x3c703e48656c6c6f207b757365725f66697273745f6e616d657d207b757365725f6c6173745f6e616d657d2c3c6272202f3e3c6272202f3e596f75206861766520726571756573742061207769746864726177616c2e203c6272202f3e3c7374726f6e673e3c6272202f3e57697468647261772044657461696c733a3c2f7374726f6e673e3c6272202f3e524546206e756d6265723a207b7472616e736665725f7265667d3c6272202f3e56616c75653a207b7472616e736665725f76616c75657d3c6272202f3e466565733a207b7472616e736665725f666565737d3c6272202f3e546f74616c3a207b7472616e736665725f746f74616c7d3c6272202f3e5374617475733a207b7472616e736665725f7374617475737d3c6272202f3e446174653a207b7472616e736665725f646174657d3c6272202f3e3c6272202f3e3c6272202f3e3c6272202f3e3c6272202f3e7b7468616e6b737d3c6272202f3e207b636f6d70616e795f6e616d657d3c6272202f3e207b736974655f75726c7d3c2f703e, 0x48656c6c6f207b757365725f66697273745f6e616d657d207b757365725f6c6173745f6e616d657d2c0d0a0d0a596f75206861766520726571756573742061207769746864726177616c2e200d0a0d0a57697468647261772044657461696c733a0d0a524546206e756d6265723a207b7472616e736665725f7265667d0d0a56616c75653a207b7472616e736665725f76616c75657d0d0a466565733a207b7472616e736665725f666565737d0d0a546f74616c3a207b7472616e736665725f746f74616c7d0d0a5374617475733a207b7472616e736665725f7374617475737d0d0a446174653a207b7472616e736665725f646174657d0d0a0d0a0d0a0d0a0d0a7b7468616e6b737d0d0a7b636f6d70616e795f6e616d657d0d0a7b736974655f75726c7d, 'contact@domain.com', 0),
(1, 'Welcome Mail', 'contact@domain.com', 'Company', 'Welcome to the trade platform', 0x3c7461626c65207374796c653d2277696474683a2035353070783b20626f726465722d636f6c6f723a20233030303030303b20626f726465722d77696474683a203170783b2220626f726465723d2230222063656c6c73706163696e673d2230222063656c6c70616464696e673d2236223e0d0a3c74626f64793e0d0a3c74723e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20233636303030303b2077696474683a203530253b223e3c7370616e207374796c653d22666f6e742d66616d696c793a2067656f726769612c70616c6174696e6f3b223e3c7370616e207374796c653d22636f6c6f723a20236666666666663b223e3c7370616e20636c6173733d227374796c653322207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7374726f6e673e547261646520436f6e6669726d6174696f6e3c2f7374726f6e673e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f74643e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20233636303030303b2077696474683a203530253b223e0d0a3c64697620636c6173733d227374796c653322207374796c653d22746578742d616c69676e3a2072696768743b223e3c7370616e207374796c653d22666f6e742d66616d696c793a2067656f726769612c70616c6174696e6f3b223e3c7370616e207374796c653d22636f6c6f723a20236666666666663b223e3c7370616e207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7374726f6e673e446174653a207b74726164655f646174657d3c2f7374726f6e673e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f6469763e0d0a3c2f74643e0d0a3c2f74723e0d0a3c74723e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20236666633b2220636f6c7370616e3d2232223e0d0a3c626c6f636b71756f74653e0d0a3c7020636c6173733d227374796c6531223e266e6273703b3c2f703e0d0a3c7020636c6173733d227374796c6531223e3c7370616e207374796c653d22666f6e742d66616d696c793a2067656f726769612c70616c6174696e6f3b223e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e7b757365725f66697273745f6e616d657d207b757365725f6c6173745f6e616d657d2c3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f703e0d0a3c7020636c6173733d227374796c6531223e3c7370616e207374796c653d22666f6e742d66616d696c793a2067656f726769612c70616c6174696e6f3b223e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e5468697320697320616e206175746f6d6174696320636f6e6669726d6174696f6e206f6620747261646520656d61696c2e20546f2072657669657720746869732074726164652c20706c65617365206c6f6720696e20746f20796f7572206163636f756e742e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f703e0d0a3c7020636c6173733d227374796c6531223e3c7370616e207374796c653d22666f6e742d66616d696c793a2067656f726769612c70616c6174696e6f3b223e3c7374726f6e673e4c6f67696e3a203c2f7374726f6e673e6163636f756e742e776562736974652e636f6d3c2f7370616e3e3c2f703e0d0a3c7020636c6173733d227374796c6531223e3c6272202f3e203c6272202f3e203c7370616e207374796c653d22666f6e742d66616d696c793a2067656f726769612c70616c6174696e6f3b223e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22636f6c6f723a20233036303b223e3c7374726f6e673e425559204f726465722054726164652044657461696c733a3c2f7374726f6e673e3c6272202f3e506f736974696f6e733a207b74726164655f706f736974696f6e737d3c6272202f3e54726164653a207b74726164655f64657461696c737d3c6272202f3e5374617475733a207b74726164655f7374617475737d3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f703e0d0a3c703e266e6273703b3c2f703e0d0a3c2f626c6f636b71756f74653e0d0a3c626c6f636b71756f74653e0d0a3c7020636c6173733d227374796c6531223e3c7370616e207374796c653d22636f6c6f723a20233030303038303b223e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a2067656f726769612c70616c6174696e6f3b223e7b7468616e6b737d3c6272202f3e207b636f6d70616e795f6e616d657d3c6272202f3e207b736974655f75726c7d3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f703e0d0a3c2f626c6f636b71756f74653e0d0a3c703e266e6273703b3c2f703e0d0a3c2f74643e0d0a3c2f74723e0d0a3c74723e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20233630303b223e3c7370616e207374796c653d22666f6e742d66616d696c793a2067656f726769612c70616c6174696e6f3b223e3c7370616e207374796c653d22636f6c6f723a20236666666666663b223e3c7370616e207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7370616e20636c6173733d227374796c6533223e5265666572656e63653a207b74726164655f7265667d3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f74643e0d0a3c7464207374796c653d22746578742d616c69676e3a2072696768743b206261636b67726f756e642d636f6c6f723a20233630303b223e3c7370616e207374796c653d22666f6e742d66616d696c793a2067656f726769612c70616c6174696e6f3b223e3c7370616e207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7370616e20636c6173733d227374796c6533223e203c7370616e207374796c653d22636f6c6f723a20236666666666663b223e4163636f756e74204e756d6265723a207b757365725f6163636f756e745f6e756d7d203c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f74643e0d0a3c2f74723e0d0a3c2f74626f64793e0d0a3c2f7461626c653e, 0x48656c6c6f207b757365725f66697273745f6e616d657d207b757365725f6c6173745f6e616d657d2c0d0a0d0a57656c636f6d6520746f205244472054726164696e6720616e64206f7572206f6e6c696e652074726164696e6720706c6174666f726d2e20596f7572206163636f756e7420686173206265656e206f70656e6564207769746820757320616e6420796f75206d6179207573652074686520666f6c6c6f77696e672064657461696c7320746f206c6f6720696e2e0d0a0d0a0d0a596f7572206163636f756e74206e756d6265723a207b757365725f6163636f756e745f6e756d7d0d0a596f757220757365726e616d653a207b757365725f757365726e616d657d0d0a596f75722070617373776f72643a207b757365725f63757272656e745f70617373776f72647d0d0a0d0a4c6f6720696e20686572653a200d0a0d0a506c65617365206368616e676520796f75722070617373776f726420616674657220796f7572206669727374206c6f6720696e2e0d0a0d0a7b7468616e6b737d0d0a7b636f6d70616e795f6e616d657d0d0a7b736974655f75726c7d, 'bcc@domain.com', 1),
(7, 'Funding Details', 'contact@domain.com', 'Company', 'Funding Details', 0x3c703e48656c6c6f207b757365725f66697273745f6e616d657d207b757365725f6c6173745f6e616d657d2c3c6272202f3e3c6272202f3e3c6272202f3e3c6272202f3e7b7468616e6b737d3c6272202f3e207b636f6d70616e795f6e616d657d3c6272202f3e207b736974655f75726c7d3c2f703e, 0x48656c6c6f207b757365725f66697273745f6e616d657d207b757365725f6c6173745f6e616d657d2c0d0a0d0a0d0a0d0a7b7468616e6b737d0d0a7b636f6d70616e795f6e616d657d0d0a7b736974655f75726c7d, 'bcc@domain.com', 1),
(8, 'Statement of Account', 'contact@domain.com', 'Company', 'Statement of Account', 0x3c703e48656c6c6f207b757365725f66697273745f6e616d657d207b757365725f6c6173745f6e616d657d2c3c6272202f3e3c6272202f3e3c6272202f3e3c6272202f3e7b6163636f756e745f73746174656d656e747d3c6272202f3e3c6272202f3e3c6272202f3e7b7468616e6b737d3c6272202f3e207b636f6d70616e795f6e616d657d3c6272202f3e207b736974655f75726c7d3c2f703e, 0x48656c6c6f207b757365725f66697273745f6e616d657d207b757365725f6c6173745f6e616d657d2c0d0a0d0a0d0a0d0a7b6163636f756e745f73746174656d656e747d0d0a0d0a7b7468616e6b737d0d0a7b636f6d70616e795f6e616d657d0d0a7b736974655f75726c7d, 'bcc@domain.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE IF NOT EXISTS `stocks` (
  `stocks_id` bigint(20) NOT NULL auto_increment,
  `stocks_symbol` varchar(10) NOT NULL,
  `stocks_name` varchar(250) NOT NULL,
  `stocks_links` text NOT NULL,
  PRIMARY KEY  (`stocks_id`),
  KEY `stocks_symbol` (`stocks_symbol`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`stocks_id`, `stocks_symbol`, `stocks_name`, `stocks_links`) VALUES
(1, 'AAPL', 'Apple Computer', 'http://www.google.com/finance?q=aapl'),
(2, 'GOOG', 'Google Inc.', 'http://www.google.com/finance?q=GOOG');

-- --------------------------------------------------------

--
-- Table structure for table `stock_details`
--

CREATE TABLE IF NOT EXISTS `stock_details` (
  `details_id` bigint(20) NOT NULL auto_increment,
  `details_ref` bigint(20) NOT NULL default '0',
  `stocks_id` bigint(20) NOT NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `volume` varchar(20) character set utf8 default NULL,
  `value` float(10,2) NOT NULL default '0.00',
  `value_change` float(4,2) NOT NULL default '0.00',
  PRIMARY KEY  (`details_id`),
  KEY `stock_id` (`stocks_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `stock_details`
--

INSERT INTO `stock_details` (`details_id`, `details_ref`, `stocks_id`, `date`, `volume`, `value`, `value_change`) VALUES
(1, 253318200987, 1, '2011-05-30 00:00:00', NULL, 337.41, 0.00),
(2, 253319273107, 2, '2011-05-30 00:00:00', NULL, 520.90, 0.00),
(3, 253319824925, 1, '2011-05-30 00:00:00', '86.508', 337.25, -0.05),
(4, 253319824925, 2, '2011-05-30 00:00:00', '24.317', 521.40, 0.10),
(5, 253341336723, 1, '2011-05-31 00:00:00', '0', 337.25, -0.05),
(6, 253341336723, 2, '2011-05-31 00:00:00', '0', 521.40, 0.10);

-- --------------------------------------------------------

--
-- Table structure for table `stock_trades`
--

CREATE TABLE IF NOT EXISTS `stock_trades` (
  `trades_id` bigint(20) NOT NULL default '0',
  `user_account_num` bigint(20) NOT NULL default '0',
  `trade_type` tinyint(3) NOT NULL default '0' COMMENT '1 - Buy, 2 - Sell, 3 - Cover, 4 - Short',
  `trade_shares` int(11) NOT NULL default '0',
  `trade_shares_left` int(11) NOT NULL default '0',
  `stocks_id` int(11) NOT NULL default '0',
  `trade_ref` bigint(20) NOT NULL default '0',
  `trade_details` varchar(255) default NULL,
  `trade_price_share` float(16,2) NOT NULL default '0.00',
  `trade_value` float(16,2) NOT NULL default '0.00',
  `trade_fees` float(11,2) NOT NULL default '0.00',
  `trade_invoiced` float(16,2) NOT NULL default '0.00',
  `trade_status` tinyint(3) NOT NULL default '0' COMMENT '1: open, 2: pending, 3: disabled, 4: closed',
  `trade_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `trade_notes` varchar(30) default NULL,
  PRIMARY KEY  (`trades_id`),
  KEY `trade_stock` (`stocks_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stock_trades`
--

INSERT INTO `stock_trades` (`trades_id`, `user_account_num`, `trade_type`, `trade_shares`, `trade_shares_left`, `stocks_id`, `trade_ref`, `trade_details`, `trade_price_share`, `trade_value`, `trade_fees`, `trade_invoiced`, `trade_status`, `trade_date`, `trade_notes`) VALUES
(13019242814, 11220840763, 1, 10, 10, 1, 253318625006, 'BUY 10x AAPL@337.41', 337.41, 3374.10, 10.00, 3384.10, 1, '2011-05-30 07:50:42', '');

-- --------------------------------------------------------

--
-- Table structure for table `trades`
--

CREATE TABLE IF NOT EXISTS `trades` (
  `trades_id` bigint(20) NOT NULL default '0',
  `user_account_num` bigint(20) NOT NULL default '0',
  `trade_type` tinyint(3) NOT NULL default '0' COMMENT '1 - Buy, 2 - Sell',
  `trade_positions` int(11) NOT NULL default '0',
  `trade_positions_left` int(11) NOT NULL default '0',
  `trade_option` tinyint(3) NOT NULL default '0' COMMENT '1 - CALL, 2 - PUT',
  `commodities_id` int(11) NOT NULL default '0',
  `trade_expiry_date` date NOT NULL default '0000-00-00',
  `trade_strikeprice` float(11,2) NOT NULL default '0.00',
  `trade_ref` bigint(20) NOT NULL default '0',
  `trade_details` varchar(255) default NULL,
  `trade_premium_price` float(11,4) NOT NULL default '0.0000',
  `trade_contract_size` bigint(20) NOT NULL default '0',
  `trade_price_contract` float(16,2) NOT NULL default '0.00',
  `trade_value` float(16,2) NOT NULL default '0.00',
  `trade_fees` float(11,2) NOT NULL default '0.00',
  `trade_invoiced` float(16,2) NOT NULL default '0.00',
  `trade_date` date NOT NULL default '0000-00-00',
  `trade_status` tinyint(3) NOT NULL default '0' COMMENT '1: open, 2: pending, 3: disabled, 4: closed',
  `trade_action_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `trade_notes` varchar(30) default NULL,
  PRIMARY KEY  (`trades_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `trades`
--

INSERT INTO `trades` (`trades_id`, `user_account_num`, `trade_type`, `trade_positions`, `trade_positions_left`, `trade_option`, `commodities_id`, `trade_expiry_date`, `trade_strikeprice`, `trade_ref`, `trade_details`, `trade_premium_price`, `trade_contract_size`, `trade_price_contract`, `trade_value`, `trade_fees`, `trade_invoiced`, `trade_date`, `trade_status`, `trade_action_date`, `trade_notes`) VALUES
(13971455524, 11220840763, 1, 5, 5, 1, 8, '2011-05-25', 1750.00, 259269954443, 'BUY 5x CALL GCM11@950.00 SP: $1,750.00', 9.5000, 100, 950.00, 4750.00, 1250.00, 6000.00, '2012-02-23', 1, '2012-02-23 07:27:02', NULL),
(14614462336, 14384421519, 1, 60, 60, 1, 8, '2012-11-27', 1840.00, 263288747022, 'BUY 60x CALL GCZ12@1,000.00 SP: $1840.00', 10.0000, 100, 1000.00, 60000.00, 0.00, 60000.00, '2012-08-23', 1, '2012-08-23 02:07:11', NULL),
(14930094295, 14809967233, 1, 9, 0, 1, 3, '2013-01-16', 100.00, 265261446760, 'BUY 9x CALL CLG13@1,000.00 SP: $100', 1.0000, 1000, 1000.00, 9000.00, 0.00, 9000.00, '2012-11-20', 4, '2012-11-20 04:38:09', NULL),
(14930096977, 14809967233, 1, 3, 0, 2, 3, '2013-01-16', 80.00, 265261463523, 'BUY 3x PUT CLG13@1,000.00 SP: $80', 1.0000, 1000, 1000.00, 3000.00, 0.00, 3000.00, '2012-11-20', 4, '2012-11-20 04:39:15', NULL),
(15127928923, 14809967233, 2, 9, 9, 1, 3, '2013-01-16', 100.00, 266497913187, 'SELL 9x  CL@2260.00 SP: $100.00', 2.2600, 1000, 2260.00, 20340.00, 417.00, 19923.00, '2013-01-15', 1, '2013-01-15 02:17:16', NULL),
(15134866905, 14809967233, 1, 15, 0, 1, 8, '2013-03-25', 1780.00, 266541275577, 'BUY 15x CALL GCJ13@1000 SP: $1780', 10.0000, 100, 1000.00, 15000.00, 0.00, 15000.00, '2013-01-17', 4, '2013-01-17 01:20:21', NULL),
(15134868425, 14809967233, 1, 5, 0, 2, 8, '2013-03-25', 1595.00, 266541285073, 'BUY 5x PUT GCJ13@1000 SP: $1595', 10.0000, 100, 1000.00, 5000.00, 0.00, 5000.00, '2013-01-17', 4, '2013-01-17 01:20:58', NULL),
(15205796564, 14809967233, 2, 15, 15, 1, 8, '2013-03-25', 1780.00, 266984585943, 'SELL 15x  GC@1320.00 SP: $1780.00', 13.2000, 100, 1320.00, 19800.00, 0.00, 19800.00, '2013-02-06', 1, '2013-02-06 02:21:42', NULL),
(15205799167, 14809967233, 2, 5, 5, 2, 8, '2013-03-25', 1595.00, 266984602215, 'SELL 5x  GC@940.00 SP: $1595.00', 9.4000, 100, 940.00, 4700.00, 225.00, 4475.00, '2013-02-06', 1, '2013-02-06 02:22:45', NULL),
(15205818093, 14809967233, 1, 5, 5, 1, 30, '2013-03-25', 0.00, 266984720500, 'BUY 5x CALL SCFJ13@10,000.00 SP: $0', 1.0000, 10000, 10000.00, 50000.00, 0.00, 50000.00, '2013-02-06', 1, '2013-02-06 02:30:27', NULL),
(15521468082, 14809967233, 2, 3, 3, 2, 3, '2013-01-16', 80.00, 268957532934, 'SELL 3x  CL@1300.00 SP: $80.00', 1.3000, 1000, 1300.00, 3900.00, 0.00, 3900.00, '2013-01-01', 1, '2013-05-06 09:08:46', NULL),
(15521470416, 14809967233, 1, 4, 0, 2, 8, '2013-03-25', 1205.00, 268957547520, 'BUY 4x PUT GCJ13@1,000.00 SP: $1205', 10.0000, 100, 1000.00, 4000.00, 0.00, 4000.00, '2013-02-04', 4, '2013-05-06 09:09:43', NULL),
(15521482159, 14809967233, 2, 4, 4, 2, 8, '2013-03-25', 1205.00, 268957620914, 'SELL 4x  GC@1531.00 SP: $1205.00', 15.3100, 100, 1531.00, 6124.00, 175.00, 5949.00, '2013-02-28', 1, '2013-05-06 09:14:30', NULL),
(15521515110, 14809967233, 1, 5, 0, 1, 8, '2013-06-25', 1550.00, 268957826858, 'BUY 5x CALL GCN13@1,000.00 SP: $1550', 10.0000, 100, 1000.00, 5000.00, 0.00, 5000.00, '2013-04-22', 4, '2013-05-06 09:27:54', NULL),
(15535346690, 14809967233, 1, 5, 0, 2, 3, '2013-08-15', 91.50, 269044274240, 'BUY 5x PUT CLU13@1500 SP: $91.50', 1.5000, 1000, 1500.00, 7500.00, 0.00, 7500.00, '2013-05-06', 4, '2013-05-10 07:15:59', NULL),
(15535349839, 14809967233, 2, 5, 5, 2, 3, '2013-08-15', 91.50, 269044293909, 'SELL 5x  CL@1906 SP: $91.50', 1.9060, 1000, 1906.00, 9530.00, 0.00, 9530.00, '2013-05-09', 1, '2013-05-10 07:17:16', NULL),
(15535369636, 14809967233, 1, 7, 0, 2, 31, '2013-08-15', 14690.00, 269044417644, 'BUY 7x PUT YMU13@2360 SP: $14690.00', 236.0000, 10, 2360.00, 16520.00, 0.00, 16520.00, '2013-05-10', 4, '2013-05-10 07:25:19', NULL),
(15560280926, 14809967233, 2, 5, 5, 1, 8, '2013-06-25', 1550.00, 269200113208, 'SELL 5x  GC@0 SP: $1550.00', 0.0000, 100, 0.00, 0.00, 0.00, 0.00, '2013-04-23', 1, '2013-05-17 08:21:45', NULL),
(15974246129, 14809967233, 2, 7, 7, 2, 31, '2013-08-15', 14690.00, 271787395723, 'SELL 7x  YM@1500 SP: $14690.00', 150.0000, 10, 1500.00, 10500.00, 0.00, 10500.00, '2013-05-03', 1, '2013-09-11 07:44:37', NULL),
(16094049856, 14809967233, 1, 7, 7, 1, 30, '2013-08-15', 0.00, 272536169020, 'BUY 7x CALL SCFU13@3,200.00 SP: $', 0.3200, 10000, 3200.00, 22400.00, 0.00, 22400.00, '2013-10-15', 1, '2013-10-15 04:12:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trades_related`
--

CREATE TABLE IF NOT EXISTS `trades_related` (
  `trades_related_id` int(11) NOT NULL auto_increment,
  `trade_ref` bigint(20) NOT NULL default '0',
  `trade_ref_relatedto` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`trades_related_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `trades_related`
--

INSERT INTO `trades_related` (`trades_related_id`, `trade_ref`, `trade_ref_relatedto`) VALUES
(1, 260749240766, 259270334174),
(2, 263288660665, 263288628476),
(21, 266497913187, 265261446760),
(22, 266984585943, 266541275577),
(23, 266984602215, 266541285073),
(24, 268957532934, 265261463523),
(25, 268957620914, 268957547520),
(26, 269044293909, 269044274240),
(27, 269200113208, 268957826858),
(28, 271787395723, 269044417644);

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE IF NOT EXISTS `transfers` (
  `transfers_id` bigint(20) NOT NULL auto_increment,
  `tr_type` tinyint(4) NOT NULL default '0' COMMENT '1 - deposit, 2 - withdraw',
  `user_account_num` bigint(20) NOT NULL default '0',
  `tr_notes` blob,
  `tr_value` float(11,2) NOT NULL default '0.00',
  `tr_fees` float(11,2) NOT NULL default '0.00',
  `tr_total` float(11,2) NOT NULL default '0.00',
  `tr_ref` bigint(13) NOT NULL default '0',
  `tr_date` date default '0000-00-00',
  `tr_status` tinyint(3) NOT NULL default '0' COMMENT '1 - Transfered, 2 - Pending, 3 - Disabled',
  `tr_system_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `tr_system_update` datetime NOT NULL default '0000-00-00 00:00:00',
  `tr_self_request` tinyint(3) default '0',
  `tr_bank_online` tinyint(3) NOT NULL default '0',
  `tr_bank_beneficiary` varbinary(100) default NULL,
  `tr_bank_address` text,
  `tr_bank_account` varbinary(100) default NULL,
  `tr_bank_name` varchar(255) default NULL,
  `tr_bank_codetype` tinyint(3) NOT NULL default '0',
  `tr_bank_code` varbinary(100) default NULL,
  `tr_bank_moredetails` text,
  PRIMARY KEY  (`transfers_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15974248489 ;

--
-- Dumping data for table `transfers`
--

INSERT INTO `transfers` (`transfers_id`, `tr_type`, `user_account_num`, `tr_notes`, `tr_value`, `tr_fees`, `tr_total`, `tr_ref`, `tr_date`, `tr_status`, `tr_system_date`, `tr_system_update`, `tr_self_request`, `tr_bank_online`, `tr_bank_beneficiary`, `tr_bank_address`, `tr_bank_account`, `tr_bank_name`, `tr_bank_codetype`, `tr_bank_code`, `tr_bank_moredetails`) VALUES
(13971360086, 1, 11220840763, '', 40000.00, 0.00, 40000.00, 2545087432, '2012-02-23', 1, '2012-02-23 06:48:12', '2012-02-23 06:48:12', 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(15208852637, 1, 14809967233, '', 27000.00, 0.00, 27000.00, 2675620761, '2013-02-06', 1, '2013-02-06 23:05:13', '2013-02-06 23:05:13', 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(14930024379, 1, 14809967233, '', 12000.00, 0.00, 12000.00, 11497772171, '2012-11-20', 1, '2012-11-20 04:09:42', '2013-01-15 02:21:08', 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(15311772398, 1, 14809967233, 0x4469766964656e64, 10585.00, 1297.33, 9287.67, 26081377998, '2013-03-08', 1, '2013-03-08 01:03:22', '2013-03-08 01:32:39', 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(15531059562, 1, 14809967233, 0x5343462066756e64206469766964656e64, 4085.00, 215.00, 3870.00, 4835683428, '2013-05-06', 1, '2013-05-09 02:11:33', '2013-05-09 02:11:33', 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(15974248488, 1, 14809967233, 0x534346204469766964656e64, 11800.00, 0.00, 11800.00, 11758530322, '2013-09-11', 1, '2013-09-11 07:45:35', '2013-09-11 07:45:35', 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `users_id` int(11) NOT NULL auto_increment,
  `user_uid` varchar(32) default '',
  `user_ref` varbinary(8) default NULL,
  `user_fullref` varbinary(100) default NULL,
  `user_account_num` bigint(20) NOT NULL default '0',
  `user_username` varchar(32) default NULL,
  `user_password` varbinary(32) default NULL,
  `user_status` tinyint(3) NOT NULL default '0',
  `user_title` tinyint(3) NOT NULL default '0',
  `user_firstname` varbinary(100) default NULL,
  `user_middlename` varbinary(100) default NULL,
  `user_lastname` varbinary(100) default NULL,
  `user_account_name` varchar(255) default NULL,
  `user_email` varbinary(100) default NULL,
  `user_phone` varbinary(100) default NULL,
  `user_fax` varbinary(100) default NULL,
  `user_email2` varbinary(100) default NULL,
  `user_company` varchar(255) default NULL,
  `user_mailing_address` text,
  `user_postal` varbinary(100) default NULL,
  `user_city` varbinary(100) default NULL,
  `user_state` varbinary(100) default NULL,
  `user_country` varbinary(100) default NULL,
  `user_web` varchar(255) default NULL,
  `user_app_date` date NOT NULL default '0000-00-00',
  `user_bank_online` tinyint(3) NOT NULL default '0',
  `user_bank_beneficiary` varbinary(100) default NULL,
  `user_bank_address` text,
  `user_bank_account` varbinary(100) default NULL,
  `user_bank_name` varchar(255) default NULL,
  `user_bank_codetype` tinyint(3) NOT NULL default '0',
  `user_bank_code` varbinary(100) default NULL,
  `user_bank_moredetails` text,
  `user_notes` text,
  `user_advisor1` int(11) NOT NULL default '0',
  `user_advisor2` int(11) NOT NULL default '0',
  `user_trades` int(11) NOT NULL default '0',
  `user_loginscount` int(11) NOT NULL default '0',
  `user_lastupdate` datetime NOT NULL default '0000-00-00 00:00:00',
  `user_lscp` float(11,3) NOT NULL default '0.000',
  `user_hpsp` float(11,3) NOT NULL default '0.000',
  `user_balance` float(16,2) NOT NULL default '0.00',
  `trading_type` tinyint(1) NOT NULL default '0',
  `user_lastlogin` datetime NOT NULL default '0000-00-00 00:00:00',
  `user_passisset` tinyint(3) NOT NULL default '0',
  `user_secret_question` text,
  `user_secret_answer` varchar(255) default NULL,
  `user_lastloginip` varchar(15) default '000.000.000.000',
  PRIMARY KEY  (`users_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=80 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`users_id`, `user_uid`, `user_ref`, `user_fullref`, `user_account_num`, `user_username`, `user_password`, `user_status`, `user_title`, `user_firstname`, `user_middlename`, `user_lastname`, `user_account_name`, `user_email`, `user_phone`, `user_fax`, `user_email2`, `user_company`, `user_mailing_address`, `user_postal`, `user_city`, `user_state`, `user_country`, `user_web`, `user_app_date`, `user_bank_online`, `user_bank_beneficiary`, `user_bank_address`, `user_bank_account`, `user_bank_name`, `user_bank_codetype`, `user_bank_code`, `user_bank_moredetails`, `user_notes`, `user_advisor1`, `user_advisor2`, `user_trades`, `user_loginscount`, `user_lastupdate`, `user_lscp`, `user_hpsp`, `user_balance`, `trading_type`, `user_lastlogin`, `user_passisset`, `user_secret_question`, `user_secret_answer`, `user_lastloginip`) VALUES
(1, '0C58405DBDD86818DCB05F3C8E8FACD1', 'ADM001', 'ADM001-11220840763', 11220840763, 'ttest', 'zxcvbnm', 1, 1, 'Tommy', 't', 'Test', 'Tommy Test', 'sportfish@gmail.com', '112341234234', '', '', '', '45st st.', '4253', 'Newcastle', 'NSW', 'New Zealand', '', '2010-01-07', 0, 'Benny', '1 bank lane', '04049302949', 'Barklays', 1, 'adfeasfesxxx', '', ' ', 1, 0, 24, 114, '2012-05-24 05:58:40', 1.000, 0.000, 23078.90, 3, '2013-12-30 06:12:40', 1, 'How', 'Now', '183.89.149.170');

-- --------------------------------------------------------

--
-- Table structure for table `users_admins`
--

CREATE TABLE IF NOT EXISTS `users_admins` (
  `admins_id` int(11) NOT NULL auto_increment,
  `adm_username` varchar(32) default NULL,
  `adm_password` varbinary(100) NOT NULL default 'invalid_password',
  `adm_ref` varchar(10) default NULL,
  `adm_name` varchar(255) default NULL,
  `adm_email` varchar(128) default NULL,
  `adm_contacts` text,
  `adm_last_login` datetime default '0000-00-00 00:00:00',
  `adm_notes` text,
  `adm_status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`admins_id`),
  UNIQUE KEY `AdmUsername` (`adm_username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users_admins`
--

INSERT INTO `users_admins` (`admins_id`, `adm_username`, `adm_password`, `adm_ref`, `adm_name`, `adm_email`, `adm_contacts`, `adm_last_login`, `adm_notes`, `adm_status`) VALUES
(1, 'innerspace', '7ujm,ki8', 'ACM00158', 'Root', 'contact@domain.com', '', '2013-11-12 00:34:01', '', 1),
(3, 'admin2', 'super22koi', 'ACM00158', 'Admin 2', 'koi@pond.com', '', '2012-06-29 03:09:56', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users_admins_logs`
--

CREATE TABLE IF NOT EXISTS `users_admins_logs` (
  `users_admins_logs_id` int(11) NOT NULL auto_increment,
  `users_admins_id` int(11) NOT NULL default '0',
  `log_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `log_type` tinyint(3) NOT NULL default '0' COMMENT '1 - login, 2 - invalid password, 3 - invalid username and password, 4 - logout',
  `log_ip` varchar(15) NOT NULL default '000.000.000.000',
  `log_tryname` varchar(255) default NULL,
  `log_trypass` varchar(255) default NULL,
  PRIMARY KEY  (`users_admins_logs_id`),
  KEY `AdminsID` (`users_admins_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users_advisors`
--

CREATE TABLE IF NOT EXISTS `users_advisors` (
  `users_advisors_id` int(11) NOT NULL auto_increment,
  `advisor_ref` varchar(10) default NULL,
  `advisor_names` varchar(255) default NULL,
  `advisor_firm` varchar(255) default NULL,
  `advisor_contacts` varchar(255) default NULL,
  PRIMARY KEY  (`users_advisors_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `users_advisors`
--

INSERT INTO `users_advisors` (`users_advisors_id`, `advisor_ref`, `advisor_names`, `advisor_firm`, `advisor_contacts`) VALUES
(1, 'AD001', 'John Turner', 'Company', 'j.turner@domain.com'),
(2, 'AD002', 'Marcus Fraser', 'Company', 'm.fraser@domain.com'),
(3, 'AD003', 'Brad Huff', 'Company', 'b.huff@domain.com'),
(39, 'AC104', 'Nathan Williams', 'Company', 'n.williams@domain.com');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
         