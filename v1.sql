-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Дек 02 2015 г., 09:16
-- Версия сервера: 5.6.24
-- Версия PHP: 5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `v1`
--

-- --------------------------------------------------------

--
-- Структура таблицы `banned_ips`
--

CREATE TABLE IF NOT EXISTS `banned_ips` (
  `banned_ips_id` int(11) NOT NULL,
  `banned_ip` varchar(15) NOT NULL DEFAULT '000.000.000.000',
  `ban_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ban_reason` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `commodities`
--

CREATE TABLE IF NOT EXISTS `commodities` (
  `commodities_id` int(11) NOT NULL,
  `commodities_groups_id` int(11) NOT NULL DEFAULT '0',
  `commodities_name` varchar(128) NOT NULL DEFAULT '',
  `commodities_symbol` varchar(8) NOT NULL DEFAULT '',
  `commodities_contract_size` int(11) NOT NULL DEFAULT '0',
  `commodities_unit` varchar(8) NOT NULL DEFAULT '',
  `commodities_status` int(11) NOT NULL DEFAULT '0',
  `commodities_order_priority` int(11) NOT NULL DEFAULT '100',
  `commodities_def_fee` float(6,2) NOT NULL DEFAULT '0.00',
  `commodities_def_prem` float(6,2) NOT NULL DEFAULT '0.00'
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `commodities`
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
-- Структура таблицы `commodities_groups`
--

CREATE TABLE IF NOT EXISTS `commodities_groups` (
  `commodities_groups_id` int(11) NOT NULL,
  `commodities_groups_name` varchar(100) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `commodities_groups`
--

INSERT INTO `commodities_groups` (`commodities_groups_id`, `commodities_groups_name`) VALUES
(1, 'Energy'),
(2, 'Metal'),
(3, 'FOREX'),
(4, 'Index');

-- --------------------------------------------------------

--
-- Структура таблицы `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `countries_id` int(11) NOT NULL,
  `country_full` varchar(255) DEFAULT NULL,
  `country_short` varchar(255) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=240 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `countries`
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
-- Структура таблицы `expiry_dates`
--

CREATE TABLE IF NOT EXISTS `expiry_dates` (
  `expiry_dates_id` int(11) NOT NULL,
  `expiry_date` date NOT NULL DEFAULT '0000-00-00',
  `expiry_short` varchar(10) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `expiry_dates`
--

INSERT INTO `expiry_dates` (`expiry_dates_id`, `expiry_date`, `expiry_short`) VALUES
(52, '2012-11-27', 'Z12'),
(53, '2013-01-16', 'G13'),
(54, '2013-03-25', 'J13'),
(55, '2013-06-25', 'N13'),
(56, '2013-08-15', 'U13'),
(57, '2014-10-23', 'X14'),
(58, '2014-11-24', 'Z14');

-- --------------------------------------------------------

--
-- Структура таблицы `global_settings`
--

CREATE TABLE IF NOT EXISTS `global_settings` (
  `global_settings_id` int(11) NOT NULL,
  `section` varchar(255) DEFAULT NULL,
  `variable` varchar(255) DEFAULT NULL,
  `variable_value` varchar(255) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `global_settings`
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
(19, 'global_settings', 'trade_type', '3'),
(20, 'mail_settings', 'mail_transport', 'smtp'),
(21, 'mail_settings', 'mail_smtp_host', 'smtp.mandrillapp.com'),
(22, 'mail_settings', 'mail_smtp_user', 'fernandovadez@gmail.com'),
(23, 'mail_settings', 'mail_smtp_password', 'phtpu0G6lKGbYiWGcv-drQ'),
(24, 'mail_settings', 'mail_smtp_port', '587'),
(25, 'mail_settings', 'mail_mandrill_host', ''),
(26, 'mail_settings', 'mail_mandrill_port', ''),
(27, 'mail_settings', 'mail_mandrill_user', ''),
(28, 'mail_settings', 'mail_mandrill_password', ''),
(29, 'pdf', 'pdf_header', '<h1 style="color:grey">XYZ Trading</h1>\r\n<h3 style="font-size: 18px;font-weight: normal">32 South Main St. Hong Kong</h3>'),
(30, 'pdf', 'pdf_footer', '<hr>\r\n<h4>Footer</h4>'),
(31, 'mail_settings', 'sendwithus_key', 'live_0880599b762d38ee14c10d48972d1c1a39d17681'),
(32, 'mail_settings', 'sendwithus_tags', '');

-- --------------------------------------------------------

--
-- Структура таблицы `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `logs_id` bigint(20) NOT NULL,
  `log_area` varbinary(100) DEFAULT NULL,
  `log_section` varbinary(100) DEFAULT NULL,
  `log_user` varchar(255) DEFAULT NULL,
  `log_admin` varchar(255) DEFAULT NULL,
  `log_details` varchar(255) DEFAULT NULL,
  `log_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `log_ip` varchar(15) NOT NULL DEFAULT '000.000.000.000'
) ENGINE=MyISAM AUTO_INCREMENT=541 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `logs`
--

INSERT INTO `logs` (`logs_id`, `log_area`, `log_section`, `log_user`, `log_admin`, `log_details`, `log_date`, `log_ip`) VALUES
(1, 0x4261636b2d656e64, 0x4c6f67696e, ' (ADM001)', ' (ADM001)', 'Successfully logged in', '2014-10-07 15:08:31', '180.183.200.46'),
(2, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-01-05 08:25:51', '119.95.43.142'),
(3, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-01-05 08:26:03', '119.95.43.142'),
(4, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2015-01-05 08:35:03', '119.95.43.142'),
(5, 0x4261636b2d656e64, 0x4c6f67696e, ' (ADM001)', ' (ADM001)', 'Successfully logged in', '2015-01-09 11:25:24', '180.183.204.35'),
(6, 0x4261636b2d656e64, 0x4c6f67696e, ' (ADM001)', ' (ADM001)', 'Successfully logged in', '2015-01-11 11:58:13', '180.183.204.35'),
(7, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-01-11 13:46:45', '183.89.191.47'),
(8, 0x4261636b2d656e64, 0x4c6f67696e, ' (ADM001)', ' (ADM001)', 'Successfully logged in', '2015-01-11 14:11:07', '180.183.204.35'),
(9, 0x4261636b2d656e64, 0x4c6f67696e, ' (ADM001)', ' (ADM001)', 'Successfully logged in', '2015-01-11 14:45:43', '180.183.204.35'),
(10, 0x4261636b2d656e64, 0x53746f636b73, 'Nutanix (NUTX)', ' (ADM001)', 'New Stock added', '2015-01-11 14:47:08', '180.183.204.35'),
(11, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2015-01-11 14:50:23', '180.183.204.35'),
(12, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-01-11 15:46:46', '183.89.191.47'),
(13, 0x4261636b2d656e64, 0x4d61696c73, '  ()', ' (ADM001)', 'Mail Sent (Other)', '2015-01-11 16:11:15', '180.183.204.35'),
(14, 0x4261636b2d656e64, 0x4c6f67696e, ' (ADM001)', ' (ADM001)', 'Successfully logged in', '2015-01-11 18:29:10', '180.183.204.35'),
(15, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-01-12 07:45:36', '183.89.190.102'),
(16, 0x4261636b2d656e64, 0x4c6f67696e, ' (ADM001)', ' (ADM001)', 'Successfully logged in', '2015-01-12 11:21:15', '204.152.214.235'),
(17, 0x4261636b2d656e64, 0x4c6f67696e, ' (ADM001)', ' (ADM001)', 'Successfully logged in', '2015-01-12 12:19:09', '204.152.214.235'),
(18, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-01-13 08:09:02', '183.89.190.102'),
(19, 0x4261636b2d656e64, 0x4c6f67696e, ' (ADM001)', ' (ADM001)', 'Successfully logged in', '2015-01-13 10:32:45', '180.183.204.35'),
(20, 0x4261636b2d656e64, 0x4d61696c73, '  ()', ' (ADM001)', 'Mail Sent (Other)', '2015-01-13 10:39:01', '180.183.204.35'),
(21, 0x4261636b2d656e64, 0x4c6f67696e, ' (ADM001)', ' (ADM001)', 'Successfully logged in', '2015-01-13 11:48:57', '180.183.204.35'),
(22, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-01-13 11:55:10', '183.89.190.102'),
(23, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2015-01-13 12:09:03', '180.183.204.35'),
(24, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-01-14 07:59:55', '183.89.190.102'),
(25, 0x4261636b2d656e64, 0x4c6f67696e, ' (ADM001)', ' (ADM001)', 'Successfully logged in', '2015-01-14 09:26:05', '180.183.157.181'),
(26, 0x4261636b2d656e64, 0x4c6f67696e, ' (ADM001)', ' (ADM001)', 'Successfully logged in', '2015-01-14 11:19:38', '180.183.157.181'),
(27, 0x4261636b2d656e64, 0x4d61696c73, '  ()', ' (ADM001)', 'Mail Sent (Other)', '2015-01-14 11:20:00', '180.183.157.181'),
(28, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2015-01-14 11:26:29', '180.183.157.181'),
(29, 0x4261636b2d656e64, 0x4163636f756e7473, 'Tommy Test (11220840763)', ' (ADM001)', 'User edited', '2015-01-14 11:27:56', '180.183.157.181'),
(30, 0x4261636b2d656e64, 0x4d61696c73, '  ()', ' (ADM001)', 'Mail Sent (Other)', '2015-01-14 11:28:59', '180.183.157.181'),
(31, 0x4261636b2d656e64, 0x4c6f67696e, ' (ADM001)', ' (ADM001)', 'Successfully logged in', '2015-01-14 17:59:18', '180.183.158.111'),
(32, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-01-15 07:56:45', '183.89.189.116'),
(33, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-01-16 07:59:42', '183.89.189.116'),
(34, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-01-19 08:15:44', '183.89.189.116'),
(35, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-01-20 08:01:32', '183.89.190.138'),
(36, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-01-20 11:46:39', '183.89.190.138'),
(37, 0x4261636b2d656e64, 0x41647669736f7273, 'James White (SRR001)', 'AD03 (AD03)', 'Advisor added', '2015-01-20 11:48:20', '183.89.190.138'),
(38, 0x4261636b2d656e64, 0x41647669736f7273, 'Tony Watson (SRR002)', 'AD03 (AD03)', 'Advisor added', '2015-01-20 11:49:26', '183.89.190.138'),
(39, 0x4261636b2d656e64, 0x41647669736f7273, 'Joshua Hoffman (SRR003)', 'AD03 (AD03)', 'Advisor added', '2015-01-20 11:50:28', '183.89.190.138'),
(40, 0x4261636b2d656e64, 0x41647669736f7273, 'Anthony Green (SRR004)', 'AD03 (AD03)', 'Advisor added', '2015-01-20 11:51:25', '183.89.190.138'),
(41, 0x4261636b2d656e64, 0x41647669736f7273, 'Bob Gorton (SRR005)', 'AD03 (AD03)', 'Advisor added', '2015-01-20 11:52:05', '183.89.190.138'),
(42, 0x4261636b2d656e64, 0x41647669736f7273, 'Edward Silver (SRR006)', 'AD03 (AD03)', 'Advisor added', '2015-01-20 11:52:50', '183.89.190.138'),
(43, 0x4261636b2d656e64, 0x41647669736f7273, 'Mike Fields (SRR007)', 'AD03 (AD03)', 'Advisor added', '2015-01-20 11:53:44', '183.89.190.138'),
(44, 0x4261636b2d656e64, 0x41647669736f7273, 'Philip Ferguson (SRR008)', 'AD03 (AD03)', 'Advisor added', '2015-01-20 11:54:31', '183.89.190.138'),
(45, 0x4261636b2d656e64, 0x41647669736f7273, 'Jack Bond (SRR009)', 'AD03 (AD03)', 'Advisor added', '2015-01-20 11:55:17', '183.89.190.138'),
(46, 0x4261636b2d656e64, 0x41647669736f7273, 'Ronald Forbes (SRR011)', 'AD03 (AD03)', 'Advisor added', '2015-01-20 11:56:28', '183.89.190.138'),
(47, 0x4261636b2d656e64, 0x41647669736f7273, 'Vincent Taylor (SRR014)', 'AD03 (AD03)', 'Advisor added', '2015-01-20 11:57:15', '183.89.190.138'),
(48, 0x4261636b2d656e64, 0x41647669736f7273, 'David Hampton (SRR015)', 'AD03 (AD03)', 'Advisor added', '2015-01-20 11:58:02', '183.89.190.138'),
(49, 0x4261636b2d656e64, 0x41647669736f7273, 'Laurie Goodwill (SRR016)', 'AD03 (AD03)', 'Advisor added', '2015-01-20 11:58:52', '183.89.190.138'),
(50, 0x4261636b2d656e64, 0x41647669736f7273, 'David H. Adam (SRR1L)', 'AD03 (AD03)', 'Advisor added', '2015-01-20 12:02:15', '183.89.190.138'),
(51, 0x4261636b2d656e64, 0x41647669736f7273, 'Michael David Ryan (SRR2L)', 'AD03 (AD03)', 'Advisor added', '2015-01-20 12:03:18', '183.89.190.138'),
(52, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-01-21 08:06:47', '183.89.190.138'),
(53, 0x4261636b2d656e64, 0x41647669736f7273, 'James Wright (SRR001)', 'AD03 (AD03)', 'Advisor edited', '2015-01-21 08:28:59', '183.89.190.138'),
(54, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-01-21 09:19:05', '183.89.190.138'),
(55, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-01-22 08:10:32', '183.89.190.138'),
(56, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-01-23 08:03:18', '183.89.190.138'),
(57, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-01-26 08:01:53', '180.183.154.22'),
(58, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-01-26 10:01:13', '180.183.154.22'),
(59, 0x4261636b2d656e64, 0x4c6f67696e, ' (ADM001)', ' (ADM001)', 'Successfully logged in', '2015-01-26 12:09:16', '180.183.156.198'),
(60, 0x4261636b2d656e64, 0x4d61696c73, '  ()', ' (ADM001)', 'Mail Sent (Other)', '2015-01-26 12:13:28', '180.183.156.198'),
(61, 0x4261636b2d656e64, 0x4163636f756e7473, 'Tommy Test (11220840763)', ' (ADM001)', 'User edited', '2015-01-26 12:14:42', '180.183.156.198'),
(62, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2015-01-26 12:32:50', '180.183.156.198'),
(63, 0x4261636b2d656e64, 0x4d61696c73, '  ()', ' (ADM001)', 'Mail Sent (Other)', '2015-01-26 12:41:04', '180.183.156.198'),
(64, 0x4261636b2d656e64, 0x4d61696c73, '  ()', ' (ADM001)', 'Mail Sent (Other)', '2015-01-26 12:42:59', '180.183.156.198'),
(65, 0x4261636b2d656e64, 0x4d61696c73, '  ()', ' (ADM001)', 'Mail Sent (Other)', '2015-01-26 12:44:31', '180.183.156.198'),
(66, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-01-26 14:04:23', '180.183.154.22'),
(67, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-01-27 07:45:18', '180.183.154.22'),
(68, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-01-27 09:08:21', '180.183.154.22'),
(69, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-01-28 08:10:22', '180.183.154.22'),
(70, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-01-29 08:01:27', '180.183.154.22'),
(71, 0x4261636b2d656e64, 0x4163636f756e7473, 'Gert  Van As ()', 'AD03 (AD03)', 'User added', '2015-01-29 08:35:36', '180.183.154.22'),
(72, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gert  Van As (17760048368)', '0', 'User successfully logged in', '2015-01-29 09:07:35', '219.89.206.2'),
(73, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gert  Van As (17760048368)', '0', 'User successfully logged out', '2015-01-29 09:09:23', '219.89.206.2'),
(74, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-01-29 11:20:20', '180.183.154.22'),
(75, 0x4261636b2d656e64, 0x53746f636b20547261646573, 'Gert  Van As (17760048368)', 'AD03 (AD03)', 'Buy added 282951298048 ( @ Open)', '2015-01-29 11:21:11', '180.183.154.22'),
(76, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-01-29 13:46:59', '49.49.2.187'),
(77, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-01-29 13:49:23', '112.209.32.239'),
(78, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-01-29 13:49:30', '49.49.2.187'),
(79, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-01-29 13:49:45', '112.209.32.239'),
(80, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gert  Van As (17760048368)', '0', 'User successfully logged in', '2015-01-29 13:50:03', '49.49.2.187'),
(81, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gert  Van As (17760048368)', '0', 'User successfully logged in', '2015-01-29 14:09:51', '118.93.212.250'),
(82, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-01-29 14:49:24', '180.183.154.22'),
(83, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gert  Van As (17760048368)', '0', 'User successfully logged out', '2015-01-29 14:49:30', '49.49.2.187'),
(84, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gert  Van As (17760048368)', '0', 'User successfully logged out', '2015-01-29 14:49:30', '118.92.116.232'),
(85, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gert  Van As (17760048368)', '0', 'User successfully logged in', '2015-01-29 14:49:46', '118.92.116.232'),
(86, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gert  Van As (17760048368)', '0', 'User successfully logged out', '2015-01-29 14:52:58', '118.92.116.232'),
(87, 0x4261636b2d656e64, 0x4c6f67696e, ' (ADM001)', ' (ADM001)', 'Successfully logged in', '2015-01-29 19:39:09', '180.183.159.149'),
(88, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gert  Van As (17760048368)', '0', 'User successfully logged in', '2015-01-30 04:12:52', '118.92.116.232'),
(89, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gert  Van As (17760048368)', '0', 'User successfully logged out', '2015-01-30 04:14:58', '118.92.116.232'),
(90, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-01-30 08:16:40', '183.88.21.133'),
(91, 0x4261636b2d656e64, 0x4c6f67696e, ' (ADM001)', ' (ADM001)', 'Successfully logged in', '2015-01-30 09:15:43', '180.183.159.149'),
(92, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-01-30 09:32:17', '183.88.21.133'),
(93, 0x4261636b2d656e64, 0x4163636f756e7473, 'Alvaro De Sousa ()', 'AD03 (AD03)', 'User added', '2015-01-30 09:36:24', '183.88.21.133'),
(94, 0x4261636b2d656e64, 0x53746f636b20547261646573, 'Alvaro De Sousa (17763742164)', 'AD03 (AD03)', 'Buy added 282971816383 ( @ Open)', '2015-01-30 09:37:01', '183.88.21.133'),
(95, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-01-30 12:42:02', '183.88.21.133'),
(96, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-02-02 08:02:58', '183.88.21.133'),
(97, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-02-02 08:56:41', '183.88.21.133'),
(98, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-02-02 13:26:25', '183.88.21.133'),
(99, 0x4261636b2d656e64, 0x4163636f756e7473, 'Wesley Maxwell ()', 'AD03 (AD03)', 'User added', '2015-02-02 13:28:37', '183.88.21.133'),
(100, 0x4261636b2d656e64, 0x53746f636b20547261646573, 'Wesley Maxwell (17774934682)', 'AD03 (AD03)', 'Buy added 283041737666 ( @ Open)', '2015-02-02 13:29:11', '183.88.21.133'),
(101, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-02-02 16:08:59', '49.49.0.151'),
(102, 0x46726f6e742d656e64, 0x4c6f67696e, 'Wesley Maxwell (17774934682)', '0', 'User successfully logged in', '2015-02-02 16:11:34', '49.49.0.151'),
(103, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gert  Van As (17760048368)', '0', 'User successfully logged in', '2015-02-02 16:17:03', '118.92.116.232'),
(104, 0x46726f6e742d656e64, 0x4c6f67696e, 'Wesley Maxwell (17774934682)', '0', 'User successfully logged in', '2015-02-02 16:17:40', '203.45.43.131'),
(105, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gert  Van As (17760048368)', '0', 'User successfully logged out', '2015-02-02 16:18:12', '118.92.116.232'),
(106, 0x46726f6e742d656e64, 0x4c6f67696e, 'Wesley Maxwell (17774934682)', '0', 'User successfully logged out', '2015-02-02 16:59:19', '203.45.43.131'),
(107, 0x46726f6e742d656e64, 0x4c6f67696e, 'Wesley Maxwell (17774934682)', '0', 'User successfully logged in', '2015-02-02 17:00:26', '203.45.43.131'),
(108, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-02-03 08:00:18', '183.88.21.133'),
(109, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-02-03 09:56:15', '183.88.21.133'),
(110, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-02-03 12:31:00', '183.88.21.133'),
(111, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-02-04 08:06:05', '180.183.202.36'),
(112, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-02-04 13:13:41', '180.183.202.36'),
(113, 0x4261636b2d656e64, 0x4163636f756e7473, 'Anthony Carter ()', 'AD03 (AD03)', 'User added', '2015-02-04 13:18:55', '180.183.202.36'),
(114, 0x4261636b2d656e64, 0x53746f636b20547261646573, 'Anthony Carter (17781980966)', 'AD03 (AD03)', 'Buy added 283085823052 ( @ Open)', '2015-02-04 13:19:19', '180.183.202.36'),
(115, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Invalid username and password used.', '2015-02-05 07:45:04', '180.183.159.64'),
(116, 0x46726f6e742d656e64, 0x4c6f67696e, 'Anthony Carter (17781980966)', '0', 'User successfully logged in', '2015-02-05 07:45:58', '180.183.159.64'),
(117, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-02-05 13:45:05', '180.183.202.36'),
(118, 0x4261636b2d656e64, 0x4163636f756e7473, 'Alvaro De Sousa (17763742164)', 'AD03 (AD03)', 'User deleted', '2015-02-05 13:45:23', '180.183.202.36'),
(119, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-02-06 08:54:24', '183.88.19.249'),
(120, 0x4261636b2d656e64, 0x5472616e7366657273, 'Gert  Van As (17760048368)', 'AD03 (AD03)', 'Deposit added 240529869 (Transfered)', '2015-02-06 08:54:47', '183.88.19.249'),
(121, 0x4261636b2d656e64, 0x5472616e7366657273, 'Wesley Maxwell (17774934682)', 'AD03 (AD03)', 'Deposit added 456256567 (Transfered)', '2015-02-06 08:58:12', '183.88.19.249'),
(122, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-02-06 13:56:00', '183.88.19.249'),
(123, 0x4261636b2d656e64, 0x4163636f756e7473, 'Brett Humble ()', 'AD03 (AD03)', 'User added', '2015-02-06 14:01:53', '183.88.19.249'),
(124, 0x4261636b2d656e64, 0x53746f636b20547261646573, 'Brett Humble (17789162800)', 'AD03 (AD03)', 'Buy added 283130722094 ( @ Open)', '2015-02-06 14:02:26', '183.88.19.249'),
(125, 0x46726f6e742d656e64, 0x4c6f67696e, 'Anthony Carter (17781980966)', '0', 'User successfully logged in', '2015-02-09 08:41:08', '149.135.10.223'),
(126, 0x46726f6e742d656e64, 0x4c6f67696e, 'Anthony Carter (17781980966)', '0', 'User successfully logged out', '2015-02-09 09:08:53', '149.135.10.223'),
(127, 0x46726f6e742d656e64, 0x4c6f67696e, 'Anthony Carter (17781980966)', '0', 'User successfully logged in', '2015-02-09 09:09:08', '149.135.10.223'),
(128, 0x46726f6e742d656e64, 0x4c6f67696e, 'Anthony Carter (17781980966)', '0', 'User successfully logged in', '2015-02-09 11:59:43', '149.135.10.223'),
(129, 0x46726f6e742d656e64, 0x4c6f67696e, 'Anthony Carter (17781980966)', '0', 'User successfully logged out', '2015-02-09 12:15:44', '149.135.10.223'),
(130, 0x46726f6e742d656e64, 0x4c6f67696e, 'Brett Humble (17789162800)', '0', 'User successfully logged in', '2015-02-09 19:54:49', '121.221.120.237'),
(131, 0x46726f6e742d656e64, 0x4c6f67696e, 'Brett Humble (17789162800)', '0', 'User successfully logged out', '2015-02-09 20:17:47', '121.221.120.237'),
(132, 0x46726f6e742d656e64, 0x4c6f67696e, 'Brett Humble (17789162800)', '0', 'User successfully logged in', '2015-02-09 20:18:02', '121.221.120.237'),
(133, 0x46726f6e742d656e64, 0x4c6f67696e, 'Brett Humble (17789162800)', '0', 'User successfully logged out', '2015-02-09 20:19:56', '121.221.120.237'),
(134, 0x4261636b2d656e64, 0x4c6f67696e, ' (ADM001)', ' (ADM001)', 'Successfully logged in', '2015-02-10 10:43:40', '183.89.185.50'),
(135, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-02-10 11:21:40', '219.89.206.2'),
(136, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gert  Van As (17760048368)', '0', 'User successfully logged in', '2015-02-10 11:23:29', '219.89.206.2'),
(137, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gert  Van As (17760048368)', '0', 'User successfully logged out', '2015-02-10 11:23:56', '219.89.206.2'),
(138, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-02-10 11:49:08', '112.209.99.245'),
(139, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-02-10 11:49:34', '112.209.99.245'),
(140, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Invalid username and password used.', '2015-02-10 11:49:36', '112.209.99.245'),
(141, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-02-10 11:49:52', '112.209.99.245'),
(142, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-02-10 11:49:58', '112.209.99.245'),
(143, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-02-10 11:50:06', '112.209.99.245'),
(144, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-02-10 11:50:12', '112.209.99.245'),
(145, 0x4261636b2d656e64, 0x4c6f67696e, ' (ADM001)', ' (ADM001)', 'Successfully logged in', '2015-02-11 13:47:57', '204.152.214.235'),
(146, 0x4261636b2d656e64, 0x4c6f67696e, ' (ADM001)', ' (ADM001)', 'Successfully logged in', '2015-02-11 15:50:00', '204.152.214.235'),
(147, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-02-12 09:05:45', '49.230.166.226'),
(148, 0x4261636b2d656e64, 0x4163636f756e7473, 'Ben Geisker ()', 'AD03 (AD03)', 'User added', '2015-02-12 09:12:02', '49.230.166.226'),
(149, 0x4261636b2d656e64, 0x53746f636b20547261646573, 'Ben Geisker (17809687372)', 'AD03 (AD03)', 'Buy added 283258980558 ( @ Open)', '2015-02-12 09:12:36', '49.230.166.226'),
(150, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-02-12 10:17:02', '49.230.166.226'),
(151, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gert  Van As (17760048368)', '0', 'User successfully logged in', '2015-02-12 10:21:56', '219.89.206.2'),
(152, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gert  Van As (17760048368)', '0', 'User successfully logged out', '2015-02-12 10:23:14', '219.89.206.2'),
(153, 0x46726f6e742d656e64, 0x4c6f67696e, 'Ben Geisker (17809687372)', '0', 'User successfully logged in', '2015-02-16 10:20:11', '203.45.153.218'),
(154, 0x46726f6e742d656e64, 0x4c6f67696e, 'Ben Geisker (17809687372)', '0', 'User successfully logged out', '2015-02-16 10:45:52', '203.45.153.218'),
(155, 0x46726f6e742d656e64, 0x4c6f67696e, 'Ben Geisker (17809687372)', '0', 'User successfully logged in', '2015-02-16 10:46:05', '203.45.153.218'),
(156, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-02-19 08:26:50', '183.89.186.71'),
(157, 0x4261636b2d656e64, 0x4163636f756e7473, 'Phillip Harris ()', 'AD03 (AD03)', 'User added', '2015-02-19 08:33:52', '183.89.186.71'),
(158, 0x4261636b2d656e64, 0x53746f636b20547261646573, 'Phillip Harris (17834361566)', 'AD03 (AD03)', 'Buy added 283413221194 ( @ Open)', '2015-02-19 08:34:18', '183.89.186.71'),
(159, 0x4261636b2d656e64, 0x4163636f756e7473, 'Brett Humble (17789162800)', 'AD03 (AD03)', 'User deleted', '2015-02-19 08:35:16', '183.89.186.71'),
(160, 0x46726f6e742d656e64, 0x4c6f67696e, 'Phillip Harris (17834361566)', '0', 'User successfully logged in', '2015-02-19 10:07:06', '207.126.248.6'),
(161, 0x46726f6e742d656e64, 0x4c6f67696e, 'Phillip Harris (17834361566)', '0', 'User successfully logged in', '2015-02-19 11:57:05', '207.126.248.6'),
(162, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-02-19 12:05:09', '183.89.186.71'),
(163, 0x46726f6e742d656e64, 0x4c6f67696e, 'Phillip Harris (17834361566)', '0', 'User successfully logged out', '2015-02-19 12:05:23', '183.89.186.71'),
(164, 0x46726f6e742d656e64, 0x4c6f67696e, 'Phillip Harris (17834361566)', '0', 'User successfully logged out', '2015-02-19 12:05:29', '183.89.186.71'),
(165, 0x46726f6e742d656e64, 0x4c6f67696e, 'Phillip Harris (17834361566)', '0', 'User successfully logged in', '2015-02-19 12:06:21', '183.89.186.71'),
(166, 0x46726f6e742d656e64, 0x4c6f67696e, 'Phillip Harris (17834361566)', '0', 'User successfully logged out', '2015-02-19 12:11:25', '183.89.186.71'),
(167, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gert  Van As (17760048368)', '0', 'User successfully logged in', '2015-02-19 12:11:51', '183.89.186.71'),
(168, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gert  Van As (17760048368)', '0', 'User successfully logged out', '2015-02-19 12:12:05', '183.89.186.71'),
(169, 0x46726f6e742d656e64, 0x4c6f67696e, 'Phillip Harris (17834361566)', '0', 'User successfully logged in', '2015-02-19 12:24:37', '183.89.186.71'),
(170, 0x46726f6e742d656e64, 0x4c6f67696e, 'Phillip Harris (17834361566)', '0', 'User successfully logged in', '2015-02-19 12:26:02', '112.209.32.239'),
(171, 0x4261636b2d656e64, 0x5472616e7366657273, 'Anthony Carter (17781980966)', 'AD03 (AD03)', 'Deposit added 23368141658 (Transfered)', '2015-02-19 12:30:55', '183.89.186.71'),
(172, 0x4261636b2d656e64, 0x5472616e7366657273, 'Ben Geisker (17809687372)', 'AD03 (AD03)', 'Deposit added 23683812348 (Transfered)', '2015-02-19 12:35:56', '183.89.186.71'),
(173, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-02-19 13:28:57', '180.183.157.152'),
(174, 0x4261636b2d656e64, 0x4c6f67696e, ' (ADM001)', ' (ADM001)', 'Successfully logged in', '2015-02-19 13:29:12', '180.183.157.152'),
(175, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-02-19 13:29:57', '180.183.157.152'),
(176, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-02-19 13:36:31', '180.183.157.152'),
(177, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-02-19 13:37:01', '183.89.186.71'),
(178, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-02-19 13:38:08', '180.183.157.152'),
(179, 0x46726f6e742d656e64, 0x4c6f67696e, 'Phillip Harris (17834361566)', '0', 'User successfully logged in', '2015-02-19 13:38:31', '112.209.32.239'),
(180, 0x4261636b2d656e64, 0x4c6f67696e, ' (ADM001)', ' (ADM001)', 'Successfully logged in', '2015-02-19 13:39:17', '180.183.157.152'),
(181, 0x4261636b2d656e64, 0x53746f636b73, 'Nutanix Class A (NUTXa)', ' (ADM001)', 'New Stock added', '2015-02-19 13:40:45', '180.183.157.152'),
(182, 0x4261636b2d656e64, 0x53746f636b20547261646573, 'Wesley Maxwell (17774934682)', 'AD03 (AD03)', 'Buy added 283417961950 ( @ Open)', '2015-02-19 13:42:57', '183.89.186.71'),
(183, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-02-19 14:31:31', '183.89.186.71'),
(184, 0x46726f6e742d656e64, 0x4c6f67696e, 'Phillip Harris (17834361566)', '0', 'User successfully logged in', '2015-02-19 14:39:15', '112.209.32.239'),
(185, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-02-20 07:36:08', '112.209.32.239'),
(186, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-02-20 13:59:01', '183.89.186.71'),
(187, 0x4261636b2d656e64, 0x4163636f756e7473, 'Iain Reynolds ()', 'AD03 (AD03)', 'User added', '2015-02-20 14:05:17', '183.89.186.71'),
(188, 0x4261636b2d656e64, 0x53746f636b20547261646573, 'Iain Reynolds (17838715529)', 'AD03 (AD03)', 'Buy added 283440429611 ( @ Open)', '2015-02-20 14:05:41', '183.89.186.71'),
(189, 0x4261636b2d656e64, 0x4163636f756e7473, 'Iain Reynolds (17838715529)', 'AD03 (AD03)', 'User edited', '2015-02-20 14:07:30', '183.89.186.71'),
(190, 0x46726f6e742d656e64, 0x4c6f67696e, 'Ben Geisker (17809687372)', '0', 'User successfully logged in', '2015-02-23 08:50:08', '203.45.153.218'),
(191, 0x46726f6e742d656e64, 0x4c6f67696e, 'Iain Reynolds (17838715529)', '0', 'User successfully logged in', '2015-02-23 09:09:11', '110.142.85.58'),
(192, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Invalid username and password used.', '2015-02-23 09:14:11', '112.209.32.239'),
(193, 0x46726f6e742d656e64, 0x4c6f67696e, 'Iain Reynolds (17838715529)', '0', 'User successfully logged out', '2015-02-23 09:32:34', '110.142.85.58'),
(194, 0x46726f6e742d656e64, 0x4c6f67696e, 'Iain Reynolds (17838715529)', '0', 'User successfully logged in', '2015-02-23 09:32:46', '110.142.85.58'),
(195, 0x46726f6e742d656e64, 0x4c6f67696e, 'Phillip Harris (17834361566)', '0', 'User successfully logged in', '2015-02-24 08:24:02', '207.126.248.6'),
(196, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-02-24 13:38:59', '183.89.186.71'),
(197, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-02-25 08:28:30', '180.183.151.220'),
(198, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-02-26 08:21:09', '180.183.151.220'),
(199, 0x4261636b2d656e64, 0x4163636f756e7473, 'Roelf Mulder ()', 'AD03 (AD03)', 'User added', '2015-02-26 08:26:49', '180.183.151.220'),
(200, 0x4261636b2d656e64, 0x53746f636b20547261646573, 'Roelf Mulder (17859119724)', 'AD03 (AD03)', 'Buy added 283567942960 ( @ Open)', '2015-02-26 08:27:20', '180.183.151.220'),
(201, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-02-27 07:34:19', '58.164.61.11'),
(202, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-02-27 07:34:53', '58.164.61.11'),
(203, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-02-27 07:36:17', '58.164.61.11'),
(204, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-02-27 07:37:32', '58.164.61.11'),
(205, 0x46726f6e742d656e64, 0x4c6f67696e, 'Roelf Mulder (17859119724)', '0', 'User successfully logged in', '2015-02-27 07:38:16', '58.164.61.11'),
(206, 0x46726f6e742d656e64, 0x4c6f67696e, 'Roelf Mulder (17859119724)', '0', 'User successfully logged in', '2015-02-27 08:14:30', '58.164.61.11'),
(207, 0x46726f6e742d656e64, 0x4c6f67696e, 'Roelf Mulder (17859119724)', '0', 'User successfully logged out', '2015-02-27 08:41:10', '58.164.61.11'),
(208, 0x46726f6e742d656e64, 0x4c6f67696e, 'Roelf Mulder (17859119724)', '0', 'User successfully logged in', '2015-02-27 08:41:29', '58.164.61.11'),
(209, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-02-27 10:12:15', '180.183.151.220'),
(210, 0x4261636b2d656e64, 0x5472616e7366657273, 'Iain Reynolds (17838715529)', 'AD03 (AD03)', 'Deposit added 52248003949 (Transfered)', '2015-02-27 10:12:37', '180.183.151.220'),
(211, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-02-27 16:17:56', '180.183.146.133'),
(212, 0x4261636b2d656e64, 0x5472616e7366657273, 'Wesley Maxwell (17774934682)', 'AD03 (AD03)', 'Deposit added 6540438194 (Transfered)', '2015-02-27 16:18:23', '180.183.146.133'),
(213, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-03-02 08:50:13', '121.211.78.11'),
(214, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-03-02 08:50:31', '121.211.78.11'),
(215, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-03-02 08:51:07', '121.211.78.11'),
(216, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-03-02 08:51:40', '121.211.78.11'),
(217, 0x46726f6e742d656e64, 0x4c6f67696e, 'Roelf Mulder ()', '0', 'Password reset request.', '2015-03-02 08:52:40', '121.211.78.11'),
(218, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-03-02 09:10:14', '180.183.146.133'),
(219, 0x4261636b2d656e64, 0x4163636f756e7473, 'Roelf Mulder (17859119724)', 'AD03 (AD03)', 'User edited', '2015-03-02 09:11:45', '180.183.146.133'),
(220, 0x4261636b2d656e64, 0x4163636f756e7473, 'Roelf Mulder (17859119724)', 'AD03 (AD03)', 'User edited', '2015-03-02 09:16:26', '180.183.146.133'),
(221, 0x46726f6e742d656e64, 0x4c6f67696e, 'Roelf Mulder (17859119724)', '0', 'User successfully logged in', '2015-03-02 09:31:58', '58.164.61.11'),
(222, 0x46726f6e742d656e64, 0x4c6f67696e, 'Roelf Mulder (17859119724)', '0', 'User successfully logged out', '2015-03-02 09:34:10', '58.164.61.11'),
(223, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-03-02 09:34:18', '58.164.61.11'),
(224, 0x46726f6e742d656e64, 0x4c6f67696e, 'Roelf Mulder (17859119724)', '0', 'User successfully logged in', '2015-03-02 09:34:50', '58.164.61.11'),
(225, 0x46726f6e742d656e64, 0x4c6f67696e, 'Roelf Mulder (17859119724)', '0', 'User successfully logged in', '2015-03-02 09:42:21', '121.211.78.11'),
(226, 0x46726f6e742d656e64, 0x4c6f67696e, 'Iain Reynolds (17838715529)', '0', 'User successfully logged in', '2015-03-02 10:29:47', '110.142.85.58'),
(227, 0x46726f6e742d656e64, 0x4c6f67696e, 'Roelf Mulder (17859119724)', '0', 'User successfully logged in', '2015-03-02 11:09:04', '58.164.61.11'),
(228, 0x46726f6e742d656e64, 0x4c6f67696e, 'Phillip Harris (17834361566)', '0', 'User successfully logged in', '2015-03-02 13:36:13', '207.126.248.6'),
(229, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-03-03 22:37:01', '180.183.148.5'),
(230, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-03-03 22:37:15', '180.183.148.5'),
(231, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-03-05 09:00:09', '180.183.146.48'),
(232, 0x4261636b2d656e64, 0x4163636f756e7473, 'Gerald McKechnie ()', 'AD03 (AD03)', 'User added', '2015-03-05 09:07:16', '180.183.146.48'),
(233, 0x4261636b2d656e64, 0x53746f636b20547261646573, 'Gerald McKechnie (17883987493)', 'AD03 (AD03)', 'Buy added 283723391324 ( @ Open)', '2015-03-05 09:07:40', '180.183.146.48'),
(234, 0x4261636b2d656e64, 0x4163636f756e7473, 'Gerald McKechnie (17883987493)', 'AD03 (AD03)', 'User edited', '2015-03-05 09:31:42', '180.183.146.48'),
(235, 0x4261636b2d656e64, 0x4163636f756e7473, 'Phillip Harris (17834361566)', 'AD03 (AD03)', 'User deleted', '2015-03-05 09:35:12', '180.183.146.48'),
(236, 0x4261636b2d656e64, 0x4163636f756e7473, 'Roelf Mulder (17859119724)', 'AD03 (AD03)', 'User deleted', '2015-03-05 09:37:13', '180.183.146.48'),
(237, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gerald McKechnie (17883987493)', '0', 'User successfully logged in', '2015-03-05 11:00:39', '120.149.24.204'),
(238, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-03-05 11:50:09', '49.49.5.66'),
(239, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gerald McKechnie (17883987493)', '0', 'User successfully logged in', '2015-03-05 13:29:48', '120.149.24.204'),
(240, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-03-05 13:48:34', '49.49.5.66'),
(241, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gerald McKechnie (17883987493)', '0', 'User successfully logged in', '2015-03-05 14:29:09', '120.149.24.204'),
(242, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-03-06 10:24:08', '180.183.146.48'),
(243, 0x4261636b2d656e64, 0x41647669736f7273, 'Daniel Holbrook (SSR018)', 'AD03 (AD03)', 'Advisor added', '2015-03-06 10:28:56', '180.183.146.48'),
(244, 0x4261636b2d656e64, 0x4163636f756e7473, 'Michael Boulattouf ()', 'AD03 (AD03)', 'User added', '2015-03-06 10:35:17', '180.183.146.48'),
(245, 0x4261636b2d656e64, 0x53746f636b20547261646573, 'Michael Boulattouf (17887744703)', 'AD03 (AD03)', 'Buy added 283746862417 ( @ Open)', '2015-03-06 10:35:44', '180.183.146.48'),
(246, 0x46726f6e742d656e64, 0x4c6f67696e, 'Michael Boulattouf (17887744703)', '0', 'User successfully logged in', '2015-03-06 10:56:06', '120.19.103.250'),
(247, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-03-06 11:06:44', '49.49.5.66'),
(248, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-03-06 11:07:04', '49.49.5.66'),
(249, 0x46726f6e742d656e64, 0x4c6f67696e, 'Michael Boulattouf (17887744703)', '0', 'User successfully logged out', '2015-03-06 11:41:47', '120.19.103.250'),
(250, 0x46726f6e742d656e64, 0x4c6f67696e, 'Michael Boulattouf (17887744703)', '0', 'User successfully logged in', '2015-03-06 11:42:00', '120.19.103.250'),
(251, 0x4261636b2d656e64, 0x4c6f67696e, ' (ADM001)', ' (ADM001)', 'Successfully logged in', '2015-03-06 14:07:27', '180.183.148.64'),
(252, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-03-09 14:59:20', '180.183.146.48'),
(253, 0x4261636b2d656e64, 0x4163636f756e7473, 'Paul  McDermott ()', 'AD03 (AD03)', 'User added', '2015-03-09 15:01:53', '180.183.146.48'),
(254, 0x4261636b2d656e64, 0x53746f636b20547261646573, 'Paul  McDermott (17899025749)', 'AD03 (AD03)', 'Buy added 283817313235 ( @ Open)', '2015-03-09 15:02:23', '180.183.146.48'),
(255, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-03-09 16:19:03', '180.183.146.48'),
(256, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gerald McKechnie (17883987493)', '0', 'User successfully logged in', '2015-03-09 20:30:33', '120.149.24.204'),
(257, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-03-10 07:59:08', '180.183.146.48'),
(258, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-03-10 08:47:26', '180.183.146.48'),
(259, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-03-10 12:24:08', '180.183.146.48'),
(260, 0x46726f6e742d656e64, 0x4c6f67696e, 'Ben Geisker (17809687372)', '0', 'User successfully logged in', '2015-03-10 17:01:29', '203.45.153.218'),
(261, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gerald McKechnie (17883987493)', '0', 'User successfully logged in', '2015-03-11 02:55:47', '120.149.24.204'),
(262, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-03-11 09:41:14', '180.183.146.48'),
(263, 0x4261636b2d656e64, 0x5472616e7366657273, 'Gerald McKechnie (17883987493)', 'AD03 (AD03)', 'Deposit added 37951063494 (Transfered)', '2015-03-11 09:41:38', '180.183.146.48'),
(264, 0x4261636b2d656e64, 0x4163636f756e7473, 'Michael Boulattouf (17887744703)', 'AD03 (AD03)', 'User edited', '2015-03-11 10:00:20', '180.183.146.48'),
(265, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gerald McKechnie (17883987493)', '0', 'User successfully logged in', '2015-03-11 16:25:02', '120.149.24.204'),
(266, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-03-13 09:32:01', '180.183.146.48'),
(267, 0x4261636b2d656e64, 0x53746f636b20547261646573, 'Iain Reynolds (17838715529)', 'AD03 (AD03)', 'Buy added 283900722045 ( @ Open)', '2015-03-13 09:32:38', '180.183.146.48'),
(268, 0x4261636b2d656e64, 0x4163636f756e7473, 'Paul  McDermott (17899025749)', 'AD03 (AD03)', 'User deleted', '2015-03-13 09:45:00', '180.183.146.48'),
(269, 0x4261636b2d656e64, 0x4163636f756e7473, 'bob jones (16667065685)', 'AD03 (AD03)', 'User deleted', '2015-03-13 09:45:29', '180.183.146.48'),
(270, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-03-13 14:24:36', '180.183.146.48'),
(271, 0x4261636b2d656e64, 0x41647669736f7273, 'Mathew Hanly (SRR019)', 'AD03 (AD03)', 'Advisor added', '2015-03-13 14:28:54', '180.183.146.48'),
(272, 0x4261636b2d656e64, 0x41647669736f7273, 'Mathew Hanley (SRR019)', 'AD03 (AD03)', 'Advisor edited', '2015-03-13 14:30:10', '180.183.146.48'),
(273, 0x4261636b2d656e64, 0x4163636f756e7473, 'Paul Brooks ()', 'AD03 (AD03)', 'User added', '2015-03-13 14:32:07', '180.183.146.48'),
(274, 0x4261636b2d656e64, 0x53746f636b20547261646573, 'Paul Brooks (17913109824)', 'AD03 (AD03)', 'Buy added 283905332276 ( @ Open)', '2015-03-13 14:32:47', '180.183.146.48'),
(275, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-03-13 18:10:44', '119.73.137.170'),
(276, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-03-13 18:10:57', '119.73.137.170'),
(277, 0x46726f6e742d656e64, 0x4c6f67696e, 'Iain Reynolds (17838715529)', '0', 'User successfully logged in', '2015-03-13 18:11:22', '119.73.137.170'),
(278, 0x46726f6e742d656e64, 0x4c6f67696e, 'Iain Reynolds (17838715529)', '0', 'User successfully logged in', '2015-03-13 19:17:18', '119.73.137.170'),
(279, 0x46726f6e742d656e64, 0x4c6f67696e, 'Iain Reynolds (17838715529)', '0', 'User successfully logged out', '2015-03-13 19:55:07', '119.73.137.170'),
(280, 0x46726f6e742d656e64, 0x4c6f67696e, 'Iain Reynolds (17838715529)', '0', 'User successfully logged in', '2015-03-14 00:37:38', '119.73.137.170'),
(281, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-03-16 09:26:31', '171.4.249.20'),
(282, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-03-16 10:38:05', '171.4.249.20'),
(283, 0x46726f6e742d656e64, 0x4c6f67696e, 'Paul Brooks (17913109824)', '0', 'User successfully logged in', '2015-03-16 10:41:13', '203.45.18.164'),
(284, 0x46726f6e742d656e64, 0x4c6f67696e, 'Paul Brooks (17913109824)', '0', 'User successfully logged in', '2015-03-16 10:45:38', '203.45.18.164'),
(285, 0x46726f6e742d656e64, 0x4c6f67696e, 'Paul Brooks (17913109824)', '0', 'User successfully logged in', '2015-03-16 10:45:56', '203.45.18.164'),
(286, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-03-16 11:07:34', '180.183.158.56'),
(287, 0x46726f6e742d656e64, 0x4c6f67696e, 'Paul Brooks (17913109824)', '0', 'User successfully logged out', '2015-03-16 11:12:09', '203.45.18.164'),
(288, 0x46726f6e742d656e64, 0x4c6f67696e, 'Paul Brooks (17913109824)', '0', 'User successfully logged in', '2015-03-16 11:12:20', '203.45.18.164'),
(289, 0x46726f6e742d656e64, 0x4c6f67696e, 'Paul Brooks (17913109824)', '0', 'User successfully logged out', '2015-03-16 11:12:36', '203.45.18.164'),
(290, 0x4261636b2d656e64, 0x4163636f756e7473, 'Paul Brooks (17913109824)', 'AD03 (AD03)', 'User edited', '2015-03-16 11:12:53', '180.183.158.56'),
(291, 0x4261636b2d656e64, 0x4c6f67696e, ' (ADM001)', ' (ADM001)', 'Successfully logged in', '2015-03-17 19:18:40', '204.152.214.235'),
(292, 0x4261636b2d656e64, 0x4163636f756e7473, 'Timothy Mason ()', ' (ADM001)', 'User added', '2015-03-17 19:49:31', '204.152.214.235'),
(293, 0x4261636b2d656e64, 0x53746f636b20547261646573, 'Timothy Mason (17928039799)', ' (ADM001)', 'Buy added 283998714275 ( @ Open)', '2015-03-17 19:52:20', '204.152.214.235'),
(294, 0x4261636b2d656e64, 0x4163636f756e7473, 'Robert Rockwell ()', ' (ADM001)', 'User added', '2015-03-17 20:00:38', '204.152.214.235'),
(295, 0x4261636b2d656e64, 0x4163636f756e7473, 'Robert Rockwell (17928062726)', ' (ADM001)', 'User edited', '2015-03-17 20:02:46', '204.152.214.235'),
(296, 0x4261636b2d656e64, 0x53746f636b20547261646573, 'Robert Rockwell (17928062726)', ' (ADM001)', 'Buy added 283998952836 ( @ Open)', '2015-03-17 20:07:52', '204.152.214.235'),
(297, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gerald McKechnie (17883987493)', '0', 'User successfully logged in', '2015-03-18 08:00:58', '120.149.24.204'),
(298, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gerald McKechnie (17883987493)', '0', 'User successfully logged in', '2015-03-18 09:19:30', '120.149.24.204'),
(299, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-03-18 09:33:44', '171.4.249.185'),
(300, 0x46726f6e742d656e64, 0x4c6f67696e, 'Timothy Mason (17928039799)', '0', 'User successfully logged in', '2015-03-18 10:23:10', '58.7.252.160'),
(301, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-03-18 10:26:15', '171.4.249.185'),
(302, 0x46726f6e742d656e64, 0x4c6f67696e, 'Timothy Mason (17928039799)', '0', 'User successfully logged out', '2015-03-18 10:52:06', '58.7.252.160'),
(303, 0x46726f6e742d656e64, 0x4c6f67696e, 'Timothy Mason (17928039799)', '0', 'User successfully logged in', '2015-03-18 10:52:21', '58.7.252.160'),
(304, 0x46726f6e742d656e64, 0x4c6f67696e, 'Timothy Mason (17928039799)', '0', 'User successfully logged out', '2015-03-18 10:57:42', '58.7.252.160'),
(305, 0x4261636b2d656e64, 0x4c6f67696e, ' (ADM001)', ' (ADM001)', 'Successfully logged in', '2015-03-18 14:07:53', '204.152.214.235'),
(306, 0x4261636b2d656e64, 0x53746f636b20547261646573, 'Iain Reynolds (17838715529)', ' (ADM001)', 'Sell added 284015596530 (Closed)', '2015-03-18 14:11:27', '204.152.214.235'),
(307, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gerald McKechnie (17883987493)', '0', 'User successfully logged in', '2015-03-20 04:00:36', '120.149.24.204'),
(308, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-03-20 16:39:59', '171.4.249.5'),
(309, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2015-03-20 16:40:27', '171.4.249.5'),
(310, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-03-20 16:40:37', '171.4.249.5'),
(311, 0x4261636b2d656e64, 0x4c6f67696e, ' (ADM001)', ' (ADM001)', 'Successfully logged in', '2015-03-23 10:40:56', '180.183.147.203'),
(312, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-03-23 10:41:08', '180.183.146.227'),
(313, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-03-24 12:52:45', '180.183.145.237'),
(314, 0x4261636b2d656e64, 0x5472616e7366657273, 'Robert Rockwell (17928062726)', 'AD03 (AD03)', 'Deposit added 61541852762 (Transfered)', '2015-03-24 13:25:08', '180.183.145.237'),
(315, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-03-24 13:37:21', '180.183.145.237'),
(316, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-03-25 13:56:44', '180.183.147.28'),
(317, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-03-25 14:27:43', '183.89.185.13'),
(318, 0x4261636b2d656e64, 0x4163636f756e7473, 'Timothy Mason (17928039799)', 'AD03 (AD03)', 'User edited', '2015-03-25 14:28:05', '183.89.185.13'),
(319, 0x4261636b2d656e64, 0x4163636f756e7473, 'Timothy Mason (17928039799)', 'AD03 (AD03)', 'User deleted', '2015-03-25 14:28:21', '183.89.185.13'),
(320, 0x4261636b2d656e64, 0x4163636f756e7473, 'Dean Polyanszky ()', 'AD03 (AD03)', 'User added', '2015-03-25 14:42:14', '183.89.185.13'),
(321, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-03-25 14:46:13', '149.129.142.125'),
(322, 0x4261636b2d656e64, 0x4c6f67696e, ' (ADM001)', ' (ADM001)', 'Successfully logged in', '2015-03-25 14:51:31', '180.183.147.28'),
(323, 0x4261636b2d656e64, 0x53746f636b73, 'Ferrari (FRRI)', ' (ADM001)', 'New Stock added', '2015-03-25 14:53:10', '180.183.147.28'),
(324, 0x4261636b2d656e64, 0x53746f636b20547261646573, 'Dean Polyanszky (17955594466)', 'AD03 (AD03)', 'Buy added 284171089213 ( @ Open)', '2015-03-25 14:54:40', '183.89.185.13'),
(325, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky (17955594466)', '0', 'User successfully logged in', '2015-03-25 15:48:00', '202.150.98.70'),
(326, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-03-25 15:53:03', '149.129.142.125'),
(327, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-03-25 16:18:23', '183.89.185.13'),
(328, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2015-03-25 16:23:10', '149.129.142.125'),
(329, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky (17955594466)', '0', 'User successfully logged out', '2015-03-25 16:23:12', '202.150.98.70'),
(330, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky (17955594466)', '0', 'User successfully logged in', '2015-03-25 16:23:34', '202.150.98.70'),
(331, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky (17955594466)', '0', 'User successfully logged out', '2015-03-25 16:35:02', '202.150.98.70'),
(332, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Invalid username and password used.', '2015-03-25 16:52:30', '120.149.24.204'),
(333, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gerald McKechnie (17883987493)', '0', 'User successfully logged in', '2015-03-25 16:52:42', '120.149.24.204'),
(334, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-03-26 08:17:44', '183.89.188.207'),
(335, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-03-27 11:14:47', '183.89.188.207'),
(336, 0x4261636b2d656e64, 0x4163636f756e7473, 'Michael Benson ()', 'AD03 (AD03)', 'User added', '2015-03-27 11:20:28', '183.89.188.207'),
(337, 0x4261636b2d656e64, 0x53746f636b20547261646573, 'Michael Benson (17962179013)', 'AD03 (AD03)', 'Buy added 284212043012 ( @ Open)', '2015-03-27 11:20:56', '183.89.188.207'),
(338, 0x4261636b2d656e64, 0x4163636f756e7473, 'Paul Brooks (17913109824)', 'AD03 (AD03)', 'User deleted', '2015-03-27 11:23:30', '183.89.188.207'),
(339, 0x46726f6e742d656e64, 0x4c6f67696e, 'Michael Benson (17962179013)', '0', 'User successfully logged in', '2015-03-27 11:23:48', '210.86.28.252'),
(340, 0x4261636b2d656e64, 0x4163636f756e7473, 'Michael Boulattouf (17887744703)', 'AD03 (AD03)', 'User deleted', '2015-03-27 11:23:53', '183.89.188.207'),
(341, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-03-27 11:28:32', '171.4.249.59'),
(342, 0x46726f6e742d656e64, 0x4c6f67696e, 'Michael Benson (17962179013)', '0', 'User successfully logged out', '2015-03-27 12:02:15', '210.86.28.252'),
(343, 0x46726f6e742d656e64, 0x4c6f67696e, 'Michael Benson (17962179013)', '0', 'User successfully logged in', '2015-03-27 12:02:25', '210.86.28.252');
INSERT INTO `logs` (`logs_id`, `log_area`, `log_section`, `log_user`, `log_admin`, `log_details`, `log_date`, `log_ip`) VALUES
(344, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Invalid username and password used.', '2015-03-27 13:11:57', '101.187.58.165'),
(345, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Invalid username and password used.', '2015-03-27 13:12:27', '101.187.58.165'),
(346, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gerald McKechnie (17883987493)', '0', 'User successfully logged in', '2015-03-28 05:25:21', '120.149.24.204'),
(347, 0x46726f6e742d656e64, 0x4c6f67696e, 'Michael Benson (17962179013)', '0', 'User successfully logged in', '2015-03-30 10:00:58', '210.86.28.252'),
(348, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gerald McKechnie (17883987493)', '0', 'User successfully logged in', '2015-03-30 20:38:46', '120.149.24.204'),
(349, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-03-31 09:01:32', '180.183.150.26'),
(350, 0x4261636b2d656e64, 0x53746f636b20547261646573, 'Michael Benson (17962179013)', 'AD03 (AD03)', 'Buy deleted 284212043012 (Open)', '2015-03-31 09:01:57', '180.183.150.26'),
(351, 0x4261636b2d656e64, 0x53746f636b20547261646573, 'Michael Benson (17962179013)', 'AD03 (AD03)', 'Buy added 284298389816 ( @ Open)', '2015-03-31 09:02:28', '180.183.150.26'),
(352, 0x46726f6e742d656e64, 0x4c6f67696e, 'Gerald McKechnie (17883987493)', '0', 'User successfully logged in', '2015-03-31 12:40:53', '120.149.24.204'),
(353, 0x4261636b2d656e64, 0x4c6f67696e, 'AD03 (AD03)', 'AD03 (AD03)', 'Successfully logged in', '2015-03-31 16:04:06', '180.183.150.26'),
(354, 0x4261636b2d656e64, 0x5472616e7366657273, 'Michael Benson (17962179013)', 'AD03 (AD03)', 'Deposit added 18549859441 (Transfered)', '2015-03-31 16:04:28', '180.183.150.26'),
(355, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-04-02 19:03:21', '::1'),
(356, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-04-02 19:03:50', '::1'),
(357, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-04-02 19:09:02', '::1'),
(358, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-04-02 19:10:28', '::1'),
(359, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-04-02 19:16:30', '::1'),
(360, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-04-02 19:16:35', '::1'),
(361, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-04-02 19:18:18', '::1'),
(362, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-04-02 19:31:08', '::1'),
(363, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2015-04-02 19:32:02', '::1'),
(364, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-04-02 19:33:40', '::1'),
(365, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-04-02 19:39:54', '::1'),
(366, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-04-02 19:40:22', '::1'),
(367, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-04-02 19:40:50', '::1'),
(368, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-04-03 16:28:42', '::1'),
(369, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2015-04-03 16:29:06', '::1'),
(370, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Invalid username and password used.', '2015-04-03 16:34:40', '::1'),
(371, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-04-28 15:50:20', '::1'),
(372, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-04-28 15:54:00', '::1'),
(373, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-05-21 10:21:38', '::1'),
(374, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Invalid username and password used.', '2015-07-07 14:06:44', '::1'),
(375, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-07-07 14:47:04', '::1'),
(376, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2015-07-07 14:54:25', '::1'),
(377, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-07-07 14:55:58', '::1'),
(378, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2015-07-07 14:56:35', '::1'),
(379, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-07-07 15:03:33', '::1'),
(380, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-07-07 15:03:47', '::1'),
(381, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-07-07 15:06:15', '::1'),
(382, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2015-07-07 15:06:35', '::1'),
(383, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-07-07 15:06:51', '::1'),
(384, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'Invalid login. Invalid username and password used.', '2015-07-07 15:32:54', '::1'),
(385, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'Invalid login. Invalid username and password used.', '2015-07-07 15:33:04', '::1'),
(386, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-07-07 15:33:33', '::1'),
(387, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2015-07-07 16:09:44', '::1'),
(388, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2015-07-07 16:09:46', '::1'),
(389, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-07-07 16:10:13', '::1'),
(390, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-10-23 12:50:09', '::1'),
(391, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2015-10-23 13:10:07', '::1'),
(392, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-10-23 13:17:29', '::1'),
(393, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2015-10-23 14:03:11', '::1'),
(394, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-10-23 14:03:27', '::1'),
(395, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2015-10-23 14:10:43', '::1'),
(396, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-10-23 14:10:56', '::1'),
(397, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-10-23 14:11:01', '::1'),
(398, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-10-23 14:11:31', '::1'),
(399, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-10-23 14:12:13', '::1'),
(400, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2015-10-23 14:30:33', '::1'),
(401, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-10-23 14:32:14', '::1'),
(402, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-10-23 14:33:02', '::1'),
(403, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-10-23 14:33:17', '::1'),
(404, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-10-23 14:33:59', '::1'),
(405, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2015-10-23 14:34:04', '::1'),
(406, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Invalid username and password used.', '2015-10-23 15:10:48', '::1'),
(407, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-10-23 15:16:26', '::1'),
(408, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-11-18 18:10:36', '127.0.0.1'),
(409, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-11-18 19:16:00', '127.0.0.1'),
(410, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-11-19 15:34:49', '127.0.0.1'),
(411, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-11-19 16:36:42', '127.0.0.1'),
(412, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-11-19 19:32:22', '127.0.0.1'),
(413, 0x4261636b2d656e64, 0x4c6f67696e, ' (ADM001)', ' (ADM001)', 'Successfully logged in', '2015-11-19 21:53:37', '127.0.0.1'),
(414, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Invalid username and password used.', '2015-11-20 15:59:27', '127.0.0.1'),
(415, 0x4261636b2d656e64, 0x4c6f67696e, ' (ADM001)', ' (ADM001)', 'Successfully logged in', '2015-11-20 15:59:36', '127.0.0.1'),
(416, 0x4261636b2d656e64, 0x53746f636b73, 'NutriSystem Inc (NTRI)', ' (ADM001)', 'New Stock added', '2015-11-20 16:20:36', '127.0.0.1'),
(417, 0x4261636b2d656e64, 0x53746f636b73, 'NutriSystem Inc (NTRI)', ' (ADM001)', 'Stock edited', '2015-11-20 16:21:36', '127.0.0.1'),
(418, 0x4261636b2d656e64, 0x53746f636b73, 'Amdocs Limited (DOX)', ' (ADM001)', 'New Stock added', '2015-11-20 16:46:29', '127.0.0.1'),
(419, 0x4261636b2d656e64, 0x53746f636b73, 'UniPixel Inc (UNXL)', ' (ADM001)', 'New Stock added', '2015-11-20 16:58:27', '127.0.0.1'),
(420, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-11-20 17:21:03', '127.0.0.1'),
(421, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-11-20 19:07:21', '127.0.0.1'),
(422, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-11-25 19:13:48', '127.0.0.1'),
(423, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Invalid username and password used.', '2015-11-26 17:18:58', '127.0.0.1'),
(424, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Invalid username and password used.', '2015-11-26 17:24:21', '127.0.0.1'),
(425, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Invalid username and password used.', '2015-11-26 17:24:27', '127.0.0.1'),
(426, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Invalid username and password used.', '2015-11-26 17:27:14', '127.0.0.1'),
(427, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-11-26 17:27:24', '127.0.0.1'),
(428, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Invalid username and password used.', '2015-11-26 17:27:52', '127.0.0.1'),
(429, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-11-26 17:28:09', '127.0.0.1'),
(430, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2015-11-26 17:28:22', '127.0.0.1'),
(431, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'User successfully logged in', '2015-11-26 17:28:33', '127.0.0.1'),
(432, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Invalid username and password used.', '2015-11-26 17:30:27', '127.0.0.1'),
(433, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Invalid username and password used.', '2015-11-26 18:52:31', '127.0.0.1'),
(434, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'User successfully logged in', '2015-11-26 18:56:22', '127.0.0.1'),
(435, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'User successfully logged in', '2015-11-26 18:56:30', '127.0.0.1'),
(436, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-11-26 18:56:47', '127.0.0.1'),
(437, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'User successfully logged out', '2015-11-26 18:57:02', '127.0.0.1'),
(438, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'User successfully logged in', '2015-11-26 18:57:03', '127.0.0.1'),
(439, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'User successfully logged in', '2015-11-26 18:57:33', '127.0.0.1'),
(440, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Invalid username and password used.', '2015-11-26 19:01:17', '127.0.0.1'),
(441, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Invalid username and password used.', '2015-11-26 19:01:22', '127.0.0.1'),
(442, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Invalid username and password used.', '2015-11-26 19:01:45', '127.0.0.1'),
(443, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Invalid username and password used.', '2015-11-26 19:07:35', '127.0.0.1'),
(444, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Invalid username and password used.', '2015-11-26 19:30:07', '127.0.0.1'),
(445, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Invalid username and password used.', '2015-11-26 19:31:53', '127.0.0.1'),
(446, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-11-26 19:32:22', '127.0.0.1'),
(447, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2015-11-26 19:32:39', '127.0.0.1'),
(448, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Invalid username and password used.', '2015-11-26 19:33:06', '127.0.0.1'),
(449, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-11-26 19:33:13', '127.0.0.1'),
(450, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2015-11-26 19:33:17', '127.0.0.1'),
(451, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2015-11-26 19:33:29', '127.0.0.1'),
(452, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-11-26 19:37:46', '127.0.0.1'),
(453, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2015-11-26 19:39:56', '127.0.0.1'),
(454, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Invalid username and password used.', '2015-11-26 19:49:17', '127.0.0.1'),
(455, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-11-26 19:49:22', '127.0.0.1'),
(456, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2015-11-26 19:51:17', '127.0.0.1'),
(457, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Invalid username and password used.', '2015-11-26 20:34:10', '127.0.0.1'),
(458, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:03:22', '127.0.0.1'),
(459, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:10:32', '127.0.0.1'),
(460, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:10:36', '127.0.0.1'),
(461, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:11:06', '127.0.0.1'),
(462, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:11:12', '127.0.0.1'),
(463, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:11:13', '127.0.0.1'),
(464, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:11:14', '127.0.0.1'),
(465, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:11:16', '127.0.0.1'),
(466, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:11:18', '127.0.0.1'),
(467, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:11:19', '127.0.0.1'),
(468, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:11:20', '127.0.0.1'),
(469, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:11:32', '127.0.0.1'),
(470, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:11:41', '127.0.0.1'),
(471, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:11:43', '127.0.0.1'),
(472, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:11:51', '127.0.0.1'),
(473, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:11:53', '127.0.0.1'),
(474, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:11:54', '127.0.0.1'),
(475, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:11:56', '127.0.0.1'),
(476, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:11:57', '127.0.0.1'),
(477, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:12:08', '127.0.0.1'),
(478, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-11-26 22:12:22', '127.0.0.1'),
(479, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-11-26 22:12:31', '127.0.0.1'),
(480, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:13:00', '127.0.0.1'),
(481, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:13:02', '127.0.0.1'),
(482, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:13:03', '127.0.0.1'),
(483, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:13:05', '127.0.0.1'),
(484, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky (17955594466)', '0', 'User successfully logged in', '2015-11-26 22:13:22', '127.0.0.1'),
(485, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky (17955594466)', '0', 'User successfully logged out', '2015-11-26 22:13:37', '127.0.0.1'),
(486, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:13:57', '127.0.0.1'),
(487, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:14:00', '127.0.0.1'),
(488, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:14:01', '127.0.0.1'),
(489, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:14:17', '127.0.0.1'),
(490, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:14:18', '127.0.0.1'),
(491, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:14:23', '127.0.0.1'),
(492, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-11-26 22:14:37', '127.0.0.1'),
(493, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky (17955594466)', '0', 'User successfully logged in', '2015-11-26 22:15:14', '127.0.0.1'),
(494, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky (17955594466)', '0', 'User successfully logged out', '2015-11-26 22:15:34', '127.0.0.1'),
(495, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:15:43', '127.0.0.1'),
(496, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:16:23', '127.0.0.1'),
(497, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:16:25', '127.0.0.1'),
(498, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:16:26', '127.0.0.1'),
(499, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky (17955594466)', '0', 'User successfully logged in', '2015-11-26 22:16:35', '127.0.0.1'),
(500, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky (17955594466)', '0', 'User successfully logged out', '2015-11-26 22:23:42', '127.0.0.1'),
(501, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky ()', '0', 'Password reset request.', '2015-11-26 22:26:57', '127.0.0.1'),
(502, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky (17955594466)', '0', 'Password reset request.', '2015-11-26 22:30:43', '127.0.0.1'),
(503, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky (17955594466)', '0', 'Password reset request.', '2015-11-26 22:33:47', '127.0.0.1'),
(504, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky (17955594466)', '0', 'Password reset request.', '2015-11-26 22:34:31', '127.0.0.1'),
(505, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky (17955594466)', '0', 'Password reset request.', '2015-11-26 22:38:09', '127.0.0.1'),
(506, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky (17955594466)', '0', 'Password reset request.', '2015-11-26 22:38:36', '127.0.0.1'),
(507, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky (17955594466)', '0', 'Password reset request.', '2015-11-26 22:40:40', '127.0.0.1'),
(508, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky (17955594466)', '0', 'Password reset request.', '2015-11-26 22:40:57', '127.0.0.1'),
(509, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky (17955594466)', '0', 'Password reset request.', '2015-11-26 22:41:29', '127.0.0.1'),
(510, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky (17955594466)', '0', 'Password reset request.', '2015-11-26 22:52:52', '127.0.0.1'),
(511, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-11-26 22:53:12', '127.0.0.1'),
(512, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2015-11-26 22:56:18', '127.0.0.1'),
(513, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-11-26 22:56:25', '127.0.0.1'),
(514, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2015-11-26 23:22:29', '127.0.0.1'),
(515, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-11-26 23:22:56', '127.0.0.1'),
(516, 0x46726f6e742d656e64, 0x4c6f67696e, 'Dean Polyanszky (17955594466)', '0', 'Password reset request.', '2015-11-27 15:36:30', '127.0.0.1'),
(517, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-11-27 15:36:50', '127.0.0.1'),
(518, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-11-27 15:37:03', '127.0.0.1'),
(519, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2015-11-27 15:45:06', '127.0.0.1'),
(520, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-11-27 15:45:17', '127.0.0.1'),
(521, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged out', '2015-11-27 15:51:21', '127.0.0.1'),
(522, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-11-27 15:51:26', '127.0.0.1'),
(523, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-11-27 19:17:00', '127.0.0.1'),
(524, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Test (11220840763)', '0', 'User successfully logged in', '2015-11-27 21:02:23', '127.0.0.1'),
(525, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Testz (11220840763)', '0', 'User successfully logged in', '2015-11-27 23:32:19', '127.0.0.1'),
(526, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-11-28 15:41:56', '127.0.0.1'),
(527, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Testz (11220840763)', '0', 'User successfully logged in', '2015-11-28 15:42:04', '127.0.0.1'),
(528, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Testz (11220840763)', '0', 'User successfully logged in', '2015-11-30 16:25:56', '127.0.0.1'),
(529, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Testz (11220840763)', '0', 'User successfully logged in', '2015-11-30 19:08:25', '127.0.0.1'),
(530, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Testz (11220840763)', '0', 'User successfully logged out', '2015-11-30 20:31:04', '127.0.0.1'),
(531, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Invalid username and password used.', '2015-11-30 20:31:10', '127.0.0.1'),
(532, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Testz (11220840763)', '0', 'User successfully logged in', '2015-11-30 20:31:16', '127.0.0.1'),
(533, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Testz (11220840763)', '0', 'User successfully logged in', '2015-11-30 23:49:05', '127.0.0.1'),
(534, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Testz (11220840763)', '0', 'User successfully logged in', '2015-12-01 16:27:59', '127.0.0.1'),
(535, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Testz (11220840763)', '0', 'User successfully logged in', '2015-12-01 16:27:59', '127.0.0.1'),
(536, 0x46726f6e742d656e64, 0x4c6f67696e, '  ()', '0', 'Invalid login. Valid username used. Invalid password used.', '2015-12-01 19:42:59', '127.0.0.1'),
(537, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Testz (11220840763)', '0', 'User successfully logged in', '2015-12-01 19:43:03', '127.0.0.1'),
(538, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Testz (11220840763)', '0', 'User successfully logged in', '2015-12-01 21:04:53', '127.0.0.1'),
(539, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Testz (11220840763)', '0', 'User successfully logged in', '2015-12-01 22:06:29', '127.0.0.1'),
(540, 0x46726f6e742d656e64, 0x4c6f67696e, 'Tommy Testz (11220840763)', '0', 'User successfully logged in', '2015-12-02 15:39:06', '127.0.0.1');

-- --------------------------------------------------------

--
-- Структура таблицы `mail_queue`
--

CREATE TABLE IF NOT EXISTS `mail_queue` (
  `mail_queue_id` bigint(20) NOT NULL,
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `time_to_send` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `sent_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `admins_id` bigint(20) NOT NULL DEFAULT '0',
  `mail_subject` text,
  `mail_from` varchar(50) NOT NULL DEFAULT '',
  `mail_from_mail` varchar(255) DEFAULT NULL,
  `mail_to` varchar(255) DEFAULT NULL,
  `mail_to_names` varchar(255) DEFAULT NULL,
  `mail_html` longtext NOT NULL,
  `mail_plain` longtext NOT NULL,
  `try_sent` tinyint(4) NOT NULL DEFAULT '0',
  `is_sent` tinyint(1) NOT NULL DEFAULT '0',
  `mail_bcc` varchar(255) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mail_queue`
--

INSERT INTO `mail_queue` (`mail_queue_id`, `create_time`, `time_to_send`, `sent_time`, `admins_id`, `mail_subject`, `mail_from`, `mail_from_mail`, `mail_to`, `mail_to_names`, `mail_html`, `mail_plain`, `try_sent`, `is_sent`, `mail_bcc`) VALUES
(32, '2014-10-03 12:46:22', '2014-10-03 12:46:22', '0000-00-00 00:00:00', 1, 'Funding Details', 'Company', 'contact@domain.com', 'moneytrendy@gmail.com', 'Tommy Test', '<p>Hello Tommy Test,<br /><br /><br /><br />Best Regards,<br /> Atlas Asia Investment Partners  <br /> http://www.sitename.com.com/</p>', 'Hello Tommy Test,\r\n\r\n\r\n\r\nBest Regards,\r\nAtlas Asia Investment Partners  \r\nhttp://www.sitename.com.com/', 2, 0, 'bcc@domain.com'),
(33, '2014-10-03 12:51:14', '2014-10-03 12:51:14', '0000-00-00 00:00:00', 1, 'Welcome to the trade platform', 'Company', 'contact@domain.com', 'moneytrendy@gmail.com', 'Tommy Test', '<table style="width: 550px; border-color: #000000; border-width: 1px;" border="0" cellspacing="0" cellpadding="6">\r\n<tbody>\r\n<tr>\r\n<td style="background-color: #660000; width: 50%;"><span style="font-family: georgia,palatino;"><span style="color: #ffffff;"><span class="style3" style="font-size: medium;"><strong>Trade Confirmation</strong></span></span></span></td>\r\n<td style="background-color: #660000; width: 50%;">\r\n<div class="style3" style="text-align: right;"><span style="font-family: georgia,palatino;"><span style="color: #ffffff;"><span style="font-size: medium;"><strong>Date: {trade_date}</strong></span></span></span></div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style="background-color: #ffc;" colspan="2">\r\n<blockquote>\r\n<p class="style1">&nbsp;</p>\r\n<p class="style1"><span style="font-family: georgia,palatino;"><span style="font-size: small;"><span style="color: #000000;">Tommy Test,</span></span></span></p>\r\n<p class="style1"><span style="font-family: georgia,palatino;"><span style="font-size: small;"><span style="color: #000000;">This is an automatic confirmation of trade email. To review this trade, please log in to your account.</span></span></span></p>\r\n<p class="style1"><span style="font-family: georgia,palatino;"><strong>Login: </strong>account.website.com</span></p>\r\n<p class="style1"><br /> <br /> <span style="font-family: georgia,palatino;"><span style="font-size: small;"><span style="color: #060;"><strong>BUY Order Trade Details:</strong><br />Positions: {trade_positions}<br />Trade: {trade_details}<br />Status: {trade_status}</span></span></span></p>\r\n<p>&nbsp;</p>\r\n</blockquote>\r\n<blockquote>\r\n<p class="style1"><span style="color: #000080;"><span style="font-size: small;"><span style="font-family: georgia,palatino;">Best Regards,<br /> Atlas Asia Investment Partners  <br /> http://www.sitename.com.com/</span></span></span></p>\r\n</blockquote>\r\n<p>&nbsp;</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style="background-color: #600;"><span style="font-family: georgia,palatino;"><span style="color: #ffffff;"><span style="font-size: medium;"><span class="style3">Reference: {trade_ref}</span></span></span></span></td>\r\n<td style="text-align: right; background-color: #600;"><span style="font-family: georgia,palatino;"><span style="font-size: medium;"><span class="style3"> <span style="color: #ffffff;">Account Number:  </span></span></span></span></td>\r\n</tr>\r\n</tbody>\r\n</table>', 'Hello Tommy Test,\r\n\r\nWelcome to RDG Trading and our online trading platform. Your account has been opened with us and you may use the following details to log in.\r\n\r\n\r\nYour account number: \r\nYour username: ttest\r\nYour password: 123456\r\n\r\nLog in here: \r\n\r\nPlease change your password after your first log in.\r\n\r\nBest Regards,\r\nAtlas Asia Investment Partners  \r\nhttp://www.sitename.com.com/', 1, 0, 'bcc@domain.com'),
(34, '2014-10-03 13:37:16', '2014-10-03 13:37:16', '0000-00-00 00:00:00', 1, 'Funding Details', 'Company', 'contact@domain.com', 'moneytrendy@gmail.com', 'Tommy Test', '<p>Hello Tommy Test,<br /><br /><br /><br />Best Regards,<br /> Atlas Asia Investment Partners  <br /> http://www.sitename.com.com/</p>', 'Hello Tommy Test,\r\n\r\n\r\n\r\nBest Regards,\r\nAtlas Asia Investment Partners  \r\nhttp://www.sitename.com.com/', 1, 0, 'bcc@domain.com');

-- --------------------------------------------------------

--
-- Структура таблицы `mail_templates`
--

CREATE TABLE IF NOT EXISTS `mail_templates` (
  `mail_templates_id` int(11) NOT NULL,
  `mail_template_title` varchar(255) DEFAULT NULL,
  `mail_from_mail` varchar(255) DEFAULT NULL,
  `mail_from` text,
  `mail_subject` text,
  `mail_html` blob,
  `mail_plain` blob,
  `mail_bcc` varchar(255) DEFAULT NULL,
  `mail_single` tinyint(3) NOT NULL DEFAULT '1',
  `mail_external_id` varchar(255) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mail_templates`
--

INSERT INTO `mail_templates` (`mail_templates_id`, `mail_template_title`, `mail_from_mail`, `mail_from`, `mail_subject`, `mail_html`, `mail_plain`, `mail_bcc`, `mail_single`, `mail_external_id`) VALUES
(2, 'Request Password', 'contact@silverridgeresources.com', 'SRR', 'Your New Password', 0x3c703e48656c6c6f207b757365725f66697273745f6e616d657d207b757365725f6c6173745f6e616d657d2c3c6272202f3e3c6272202f3e596f7520617265206365636576696e672074686973206d61696c206265636175736520796f752c206f7220736f6d656f6e652072657175657374656420796f75722070617373776f72642e3c6272202f3e3c6272202f3e596f7572206163636f756e74206e756d6265723a207b757365725f6163636f756e745f6e756d7d3c6272202f3e596f757220757365726e616d653a207b757365725f757365726e616d657d3c6272202f3e596f7572206e65772070617373776f72643a207b757365725f70617373776f72647d3c6272202f3e3c6272202f3e5765207374726f6e676c79207265636f6d6d656e6420796f7520746f206368616e676520796f75722070617373776f7264206166746572206c6f6720696e2e3c6272202f3e3c6272202f3e7b7468616e6b737d3c6272202f3e207b636f6d70616e795f6e616d657d3c6272202f3e207b736974655f75726c7d3c2f703e, '', 'bcc@silverridgeresources.com', 1, 'tem_xsZqLG9DuFBGpjjcuoeHAZ'),
(5, 'Buy Details', 'contactus@domain.com', 'Company', 'Buy Trade Confirmation', 0x3c7461626c65207374796c653d2277696474683a2035353070783b2220626f726465723d2230222063656c6c70616464696e673d2233223e0d0a3c74626f64793e0d0a3c74723e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20233939393933333b2077696474683a203530253b223e3c7370616e207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7370616e20636c6173733d227374796c6533223e3c7374726f6e673e547261646520436f6e6669726d6174696f6e3c2f7374726f6e673e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f74643e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20233939393933333b2077696474683a203530253b223e0d0a3c64697620636c6173733d227374796c653322207374796c653d22746578742d616c69676e3a2072696768743b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7374726f6e673e446174653a207b74726164655f646174657d3c2f7374726f6e673e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f6469763e0d0a3c2f74643e0d0a3c2f74723e0d0a3c74723e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20236632663961663b2220636f6c7370616e3d2232223e0d0a3c626c6f636b71756f74653e3c6272202f3e3c2f626c6f636b71756f74653e0d0a3c626c6f636b71756f74653e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e7b757365725f66697273745f6e616d657d207b757365725f6c6173745f6e616d657d2c3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c6272202f3e3c2f626c6f636b71756f74653e0d0a3c626c6f636b71756f74653e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e5468697320697320616e206175746f2067656e65726174656420636f6e6669726d6174696f6e206f6620747261646520656d61696c2e20546f2072657669657720746869732074726164652c20706c65617365206c6f6720696e20746f20796f7572206163636f756e742e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f626c6f636b71756f74653e0d0a3c626c6f636b71756f74653e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c6272202f3e3c7374726f6e673e425559204f726465722054726164652044657461696c733a3c2f7374726f6e673e3c6272202f3e506f736974696f6e733a207b74726164655f706f736974696f6e737d3c6272202f3e54726164653a207b74726164655f64657461696c737d3c6272202f3e5374617475733a207b74726164655f7374617475737d3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f626c6f636b71756f74653e0d0a3c626c6f636b71756f74653e0d0a3c7020636c6173733d227374796c6531223e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c6272202f3e3c2f7370616e3e3c2f7370616e3e3c2f703e0d0a3c7020636c6173733d227374796c6531223e3c212d2d5b696620677465206d736f20395d3e3c786d6c3e203c773a576f7264446f63756d656e743e203c773a566965773e4e6f726d616c3c2f773a566965773e203c773a5a6f6f6d3e303c2f773a5a6f6f6d3e203c773a50756e6374756174696f6e4b65726e696e67202f3e203c773a56616c6964617465416761696e7374536368656d6173202f3e203c773a536176654966584d4c496e76616c69643e66616c73653c2f773a536176654966584d4c496e76616c69643e203c773a49676e6f72654d69786564436f6e74656e743e66616c73653c2f773a49676e6f72654d69786564436f6e74656e743e203c773a416c7761797353686f77506c616365686f6c646572546578743e66616c73653c2f773a416c7761797353686f77506c616365686f6c646572546578743e203c773a436f6d7061746962696c6974793e203c773a427265616b577261707065645461626c6573202f3e203c773a536e6170546f47726964496e43656c6c202f3e203c773a4170706c79427265616b696e6752756c6573202f3e203c773a57726170546578745769746850756e6374202f3e203c773a557365417369616e427265616b52756c6573202f3e203c773a446f6e7447726f774175746f666974202f3e203c2f773a436f6d7061746962696c6974793e203c773a42726f777365724c6576656c3e4d6963726f736f6674496e7465726e65744578706c6f726572343c2f773a42726f777365724c6576656c3e203c2f773a576f7264446f63756d656e743e203c2f786d6c3e3c215b656e6469665d2d2d3e3c212d2d5b696620677465206d736f20395d3e3c786d6c3e203c773a4c6174656e745374796c6573204465664c6f636b656453746174653d2266616c736522204c6174656e745374796c65436f756e743d22313536223e203c2f773a4c6174656e745374796c65733e203c2f786d6c3e3c215b656e6469665d2d2d3e3c212d2d5b696620677465206d736f2031305d3e203c6d63653a7374796c653e3c212020202f2a205374796c6520446566696e6974696f6e73202a2f20207461626c652e4d736f4e6f726d616c5461626c6520097b6d736f2d7374796c652d6e616d653a225461626c65204e6f726d616c223b20096d736f2d747374796c652d726f7762616e642d73697a653a303b20096d736f2d747374796c652d636f6c62616e642d73697a653a303b20096d736f2d7374796c652d6e6f73686f773a7965733b20096d736f2d7374796c652d706172656e743a22223b20096d736f2d70616464696e672d616c743a30696e20352e3470742030696e20352e3470743b20096d736f2d706172612d6d617267696e3a30696e3b20096d736f2d706172612d6d617267696e2d626f74746f6d3a2e3030303170743b20096d736f2d706167696e6174696f6e3a7769646f772d6f727068616e3b2009666f6e742d73697a653a31302e3070743b2009666f6e742d66616d696c793a2254696d6573204e657720526f6d616e223b20096d736f2d616e73692d6c616e67756167653a23303430303b20096d736f2d666172656173742d6c616e67756167653a23303430303b20096d736f2d626964692d6c616e67756167653a23303430303b7d202d2d3e203c212d2d5b656e6469665d2d2d3e3c2f703e0d0a3c2f626c6f636b71756f74653e0d0a3c626c6f636b71756f74653e0d0a3c7020636c6173733d227374796c6531223e7b7468616e6b737d3c2f703e0d0a3c7020636c6173733d227374796c6531223e3c6272202f3e207b636f6d70616e795f6e616d657d3c6272202f3e207b736974655f75726c7d3c2f703e0d0a3c2f626c6f636b71756f74653e0d0a3c703e266e6273703b3c2f703e0d0a3c703e3c7370616e207374796c653d22666f6e742d66616d696c793a2076657264616e612c67656e6576613b223e3c6272202f3e3c2f7370616e3e3c2f703e0d0a3c2f74643e0d0a3c2f74723e0d0a3c74723e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20233939393933333b223e3c7370616e207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7370616e20636c6173733d227374796c6533223e5265666572656e63653a207b74726164655f7265667d3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f74643e0d0a3c7464207374796c653d22746578742d616c69676e3a2072696768743b206261636b67726f756e642d636f6c6f723a20233939393933333b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7370616e20636c6173733d227374796c6533223e203c7370616e207374796c653d22636f6c6f723a20233030303030303b223e4163636f756e74204e756d6265723a207b757365725f6163636f756e745f6e756d7d203c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f74643e0d0a3c2f74723e0d0a3c2f74626f64793e0d0a3c2f7461626c653e0d0a3c703e3c7370616e207374796c653d22666f6e742d66616d696c793a2076657264616e612c67656e6576613b223e266e6273703b3c2f7370616e3e3c2f703e0d0a3c6469762069643d225f6d6365506173746522207374796c653d22706f736974696f6e3a206162736f6c7574653b206c6566743a202d313030303070783b20746f703a203070783b2077696474683a203170783b206865696768743a203170783b206f766572666c6f773a2068696464656e3b223e3c212d2d5b696620677465206d736f20395d3e3c786d6c3e203c773a576f7264446f63756d656e743e203c773a566965773e4e6f726d616c3c2f773a566965773e203c773a5a6f6f6d3e303c2f773a5a6f6f6d3e203c773a50756e6374756174696f6e4b65726e696e67202f3e203c773a56616c6964617465416761696e7374536368656d6173202f3e203c773a536176654966584d4c496e76616c69643e66616c73653c2f773a536176654966584d4c496e76616c69643e203c773a49676e6f72654d69786564436f6e74656e743e66616c73653c2f773a49676e6f72654d69786564436f6e74656e743e203c773a416c7761797353686f77506c616365686f6c646572546578743e66616c73653c2f773a416c7761797353686f77506c616365686f6c646572546578743e203c773a436f6d7061746962696c6974793e203c773a427265616b577261707065645461626c6573202f3e203c773a536e6170546f47726964496e43656c6c202f3e203c773a4170706c79427265616b696e6752756c6573202f3e203c773a57726170546578745769746850756e6374202f3e203c773a557365417369616e427265616b52756c6573202f3e203c773a446f6e7447726f774175746f666974202f3e203c2f773a436f6d7061746962696c6974793e203c773a42726f777365724c6576656c3e4d6963726f736f6674496e7465726e65744578706c6f726572343c2f773a42726f777365724c6576656c3e203c2f773a576f7264446f63756d656e743e203c2f786d6c3e3c215b656e6469665d2d2d3e3c212d2d5b696620677465206d736f20395d3e3c786d6c3e203c773a4c6174656e745374796c6573204465664c6f636b656453746174653d2266616c736522204c6174656e745374796c65436f756e743d22313536223e203c2f773a4c6174656e745374796c65733e203c2f786d6c3e3c215b656e6469665d2d2d3e3c212d2d5b696620677465206d736f2031305d3e203c6d63653a7374796c653e3c212020202f2a205374796c6520446566696e6974696f6e73202a2f20207461626c652e4d736f4e6f726d616c5461626c6520097b6d736f2d7374796c652d6e616d653a225461626c65204e6f726d616c223b20096d736f2d747374796c652d726f7762616e642d73697a653a303b20096d736f2d747374796c652d636f6c62616e642d73697a653a303b20096d736f2d7374796c652d6e6f73686f773a7965733b20096d736f2d7374796c652d706172656e743a22223b20096d736f2d70616464696e672d616c743a30696e20352e3470742030696e20352e3470743b20096d736f2d706172612d6d617267696e3a30696e3b20096d736f2d706172612d6d617267696e2d626f74746f6d3a2e3030303170743b20096d736f2d706167696e6174696f6e3a7769646f772d6f727068616e3b2009666f6e742d73697a653a31302e3070743b2009666f6e742d66616d696c793a2254696d6573204e657720526f6d616e223b20096d736f2d616e73692d6c616e67756167653a23303430303b20096d736f2d666172656173742d6c616e67756167653a23303430303b20096d736f2d626964692d6c616e67756167653a23303430303b7d202d2d3e203c212d2d5b656e6469665d2d2d3e0d0a3c7020636c6173733d227374796c6531223e3c7370616e207374796c653d22666f6e742d66616d696c793a20417269616c3b223e3c6272202f3e203c2f7370616e3e3c2f703e0d0a3c2f6469763e, 0x7b757365725f66697273745f6e616d657d207b757365725f6c6173745f6e616d657d2c0d0a0d0a5468616e6b20796f7520666f7220796f757220726563656e742074726164652e0d0a0d0a596f7572206163636f756e74206e756d6265723a207b757365725f6163636f756e745f6e756d7d0d0a0d0a4255592054726164652044657461696c730d0a524546206e756d6265723a207b74726164655f7265667d0d0a506f736974696f6e733a207b74726164655f706f736974696f6e737d0d0a53686f727420496e666f3a207b74726164655f64657461696c737d0d0a5374617475733a207b74726164655f7374617475737d0d0a446174653a207b74726164655f646174657d0d0a0d0a0d0a7b7468616e6b737d0d0a0d0a0d0a7b636f6d70616e795f6e616d657d0d0a7b736974655f75726c7d, 'bcc@domain.com', 0, NULL),
(6, 'Sell Details', 'contact@domain.com', 'Company', 'SELL Details', 0x3c7461626c65207374796c653d2277696474683a2035353070783b2220626f726465723d2230222063656c6c70616464696e673d2233223e0d0a3c74626f64793e0d0a3c74723e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20233939393933333b2077696474683a203530253b223e3c7370616e207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7370616e20636c6173733d227374796c6533223e3c7374726f6e673e547261646520436f6e6669726d6174696f6e3c2f7374726f6e673e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f74643e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20233939393933333b2077696474683a203530253b223e0d0a3c64697620636c6173733d227374796c653322207374796c653d22746578742d616c69676e3a2072696768743b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7374726f6e673e446174653a207b74726164655f646174657d3c2f7374726f6e673e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f6469763e0d0a3c2f74643e0d0a3c2f74723e0d0a3c74723e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20236632663961663b2220636f6c7370616e3d2232223e0d0a3c626c6f636b71756f74653e3c6272202f3e3c2f626c6f636b71756f74653e0d0a3c626c6f636b71756f74653e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e7b757365725f66697273745f6e616d657d207b757365725f6c6173745f6e616d657d2c3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c6272202f3e3c2f626c6f636b71756f74653e0d0a3c626c6f636b71756f74653e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e5468697320697320616e206175746f2067656e65726174656420636f6e6669726d6174696f6e206f6620747261646520656d61696c2e20546f2072657669657720746869732074726164652c20706c65617365206c6f6720696e20746f20796f7572206163636f756e742e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f626c6f636b71756f74653e0d0a3c626c6f636b71756f74653e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c6272202f3e3c7374726f6e673e53454c4c204f726465722054726164652044657461696c733a3c2f7374726f6e673e3c6272202f3e506f736974696f6e733a207b74726164655f706f736974696f6e737d3c6272202f3e54726164653a207b74726164655f64657461696c737d3c6272202f3e5374617475733a207b74726164655f7374617475737d3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f626c6f636b71756f74653e0d0a3c626c6f636b71756f74653e0d0a3c7020636c6173733d227374796c6531223e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c6272202f3e3c2f7370616e3e3c2f7370616e3e3c2f703e0d0a3c7020636c6173733d227374796c6531223e3c212d2d5b696620677465206d736f20395d3e3c786d6c3e203c773a576f7264446f63756d656e743e203c773a566965773e4e6f726d616c3c2f773a566965773e203c773a5a6f6f6d3e303c2f773a5a6f6f6d3e203c773a50756e6374756174696f6e4b65726e696e67202f3e203c773a56616c6964617465416761696e7374536368656d6173202f3e203c773a536176654966584d4c496e76616c69643e66616c73653c2f773a536176654966584d4c496e76616c69643e203c773a49676e6f72654d69786564436f6e74656e743e66616c73653c2f773a49676e6f72654d69786564436f6e74656e743e203c773a416c7761797353686f77506c616365686f6c646572546578743e66616c73653c2f773a416c7761797353686f77506c616365686f6c646572546578743e203c773a436f6d7061746962696c6974793e203c773a427265616b577261707065645461626c6573202f3e203c773a536e6170546f47726964496e43656c6c202f3e203c773a4170706c79427265616b696e6752756c6573202f3e203c773a57726170546578745769746850756e6374202f3e203c773a557365417369616e427265616b52756c6573202f3e203c773a446f6e7447726f774175746f666974202f3e203c2f773a436f6d7061746962696c6974793e203c773a42726f777365724c6576656c3e4d6963726f736f6674496e7465726e65744578706c6f726572343c2f773a42726f777365724c6576656c3e203c2f773a576f7264446f63756d656e743e203c2f786d6c3e3c215b656e6469665d2d2d3e3c212d2d5b696620677465206d736f20395d3e3c786d6c3e203c773a4c6174656e745374796c6573204465664c6f636b656453746174653d2266616c736522204c6174656e745374796c65436f756e743d22313536223e203c2f773a4c6174656e745374796c65733e203c2f786d6c3e3c215b656e6469665d2d2d3e3c212d2d5b696620677465206d736f2031305d3e203c6d63653a7374796c653e3c212020202f2a205374796c6520446566696e6974696f6e73202a2f20207461626c652e4d736f4e6f726d616c5461626c6520097b6d736f2d7374796c652d6e616d653a225461626c65204e6f726d616c223b20096d736f2d747374796c652d726f7762616e642d73697a653a303b20096d736f2d747374796c652d636f6c62616e642d73697a653a303b20096d736f2d7374796c652d6e6f73686f773a7965733b20096d736f2d7374796c652d706172656e743a22223b20096d736f2d70616464696e672d616c743a30696e20352e3470742030696e20352e3470743b20096d736f2d706172612d6d617267696e3a30696e3b20096d736f2d706172612d6d617267696e2d626f74746f6d3a2e3030303170743b20096d736f2d706167696e6174696f6e3a7769646f772d6f727068616e3b2009666f6e742d73697a653a31302e3070743b2009666f6e742d66616d696c793a2254696d6573204e657720526f6d616e223b20096d736f2d616e73692d6c616e67756167653a23303430303b20096d736f2d666172656173742d6c616e67756167653a23303430303b20096d736f2d626964692d6c616e67756167653a23303430303b7d202d2d3e203c212d2d5b656e6469665d2d2d3e3c2f703e0d0a3c2f626c6f636b71756f74653e0d0a3c626c6f636b71756f74653e0d0a3c7020636c6173733d227374796c6531223e7b7468616e6b737d3c6272202f3e207b636f6d70616e795f6e616d657d3c6272202f3e207b736974655f75726c7d3c2f703e0d0a3c2f626c6f636b71756f74653e0d0a3c703e266e6273703b3c2f703e0d0a3c703e3c7370616e207374796c653d22666f6e742d66616d696c793a2076657264616e612c67656e6576613b223e3c6272202f3e3c2f7370616e3e3c2f703e0d0a3c2f74643e0d0a3c2f74723e0d0a3c74723e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20233939393933333b223e3c7370616e207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7370616e20636c6173733d227374796c6533223e5265666572656e63653a207b74726164655f7265667d3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f74643e0d0a3c7464207374796c653d22746578742d616c69676e3a2072696768743b206261636b67726f756e642d636f6c6f723a20233939393933333b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7370616e20636c6173733d227374796c6533223e203c7370616e207374796c653d22636f6c6f723a20233030303030303b223e4163636f756e74204e756d6265723a207b757365725f6163636f756e745f6e756d7d203c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f74643e0d0a3c2f74723e0d0a3c2f74626f64793e0d0a3c2f7461626c653e0d0a3c703e3c7370616e207374796c653d22666f6e742d66616d696c793a2076657264616e612c67656e6576613b223e266e6273703b3c2f7370616e3e3c2f703e0d0a3c6469762069643d225f6d6365506173746522207374796c653d22706f736974696f6e3a206162736f6c7574653b206c6566743a202d313030303070783b20746f703a203070783b2077696474683a203170783b206865696768743a203170783b206f766572666c6f773a2068696464656e3b223e3c212d2d5b696620677465206d736f20395d3e3c786d6c3e203c773a576f7264446f63756d656e743e203c773a566965773e4e6f726d616c3c2f773a566965773e203c773a5a6f6f6d3e303c2f773a5a6f6f6d3e203c773a50756e6374756174696f6e4b65726e696e67202f3e203c773a56616c6964617465416761696e7374536368656d6173202f3e203c773a536176654966584d4c496e76616c69643e66616c73653c2f773a536176654966584d4c496e76616c69643e203c773a49676e6f72654d69786564436f6e74656e743e66616c73653c2f773a49676e6f72654d69786564436f6e74656e743e203c773a416c7761797353686f77506c616365686f6c646572546578743e66616c73653c2f773a416c7761797353686f77506c616365686f6c646572546578743e203c773a436f6d7061746962696c6974793e203c773a427265616b577261707065645461626c6573202f3e203c773a536e6170546f47726964496e43656c6c202f3e203c773a4170706c79427265616b696e6752756c6573202f3e203c773a57726170546578745769746850756e6374202f3e203c773a557365417369616e427265616b52756c6573202f3e203c773a446f6e7447726f774175746f666974202f3e203c2f773a436f6d7061746962696c6974793e203c773a42726f777365724c6576656c3e4d6963726f736f6674496e7465726e65744578706c6f726572343c2f773a42726f777365724c6576656c3e203c2f773a576f7264446f63756d656e743e203c2f786d6c3e3c215b656e6469665d2d2d3e3c212d2d5b696620677465206d736f20395d3e3c786d6c3e203c773a4c6174656e745374796c6573204465664c6f636b656453746174653d2266616c736522204c6174656e745374796c65436f756e743d22313536223e203c2f773a4c6174656e745374796c65733e203c2f786d6c3e3c215b656e6469665d2d2d3e3c212d2d5b696620677465206d736f2031305d3e203c6d63653a7374796c653e3c212020202f2a205374796c6520446566696e6974696f6e73202a2f20207461626c652e4d736f4e6f726d616c5461626c6520097b6d736f2d7374796c652d6e616d653a225461626c65204e6f726d616c223b20096d736f2d747374796c652d726f7762616e642d73697a653a303b20096d736f2d747374796c652d636f6c62616e642d73697a653a303b20096d736f2d7374796c652d6e6f73686f773a7965733b20096d736f2d7374796c652d706172656e743a22223b20096d736f2d70616464696e672d616c743a30696e20352e3470742030696e20352e3470743b20096d736f2d706172612d6d617267696e3a30696e3b20096d736f2d706172612d6d617267696e2d626f74746f6d3a2e3030303170743b20096d736f2d706167696e6174696f6e3a7769646f772d6f727068616e3b2009666f6e742d73697a653a31302e3070743b2009666f6e742d66616d696c793a2254696d6573204e657720526f6d616e223b20096d736f2d616e73692d6c616e67756167653a23303430303b20096d736f2d666172656173742d6c616e67756167653a23303430303b20096d736f2d626964692d6c616e67756167653a23303430303b7d202d2d3e203c212d2d5b656e6469665d2d2d3e0d0a3c7020636c6173733d227374796c6531223e3c7370616e207374796c653d22666f6e742d66616d696c793a20417269616c3b20636f6c6f723a20626c61636b3b223e4265737420526567617264732c203c6272202f3e203c2f7370616e3e4672656d6f6e742054726164696e67266e6273703b3c7370616e207374796c653d22666f6e742d66616d696c793a20417269616c3b223e3c6272202f3e203c6120687265663d22687474703a2f2f7777772e72646774726164696e672e636f6d2f223e6672656d6f6e7474726164696e672e636f6d3c2f613e3c2f7370616e3e3c2f703e0d0a3c2f6469763e, 0x48656c6c6f207b757365725f66697273745f6e616d657d207b757365725f6c6173745f6e616d657d2c0d0a0d0a546865736520617265207468652064657461696c73206f6620796f757220726563656e742073656c6c206f726465722e0d0a0d0a0d0a53656c6c2054726164652044657461696c730d0a524546206e756d6265723a207b74726164655f7265667d0d0a506f736974696f6e733a207b74726164655f706f736974696f6e737d0d0a45787069727920446174653a207b74726164655f6578706972797d0d0a53686f727420496e666f3a207b74726164655f64657461696c737d0d0a5374617475733a207b74726164655f7374617475737d0d0a446174653a207b74726164655f646174657d0d0a0d0a0d0a7b7468616e6b737d0d0a7b636f6d70616e795f6e616d657d0d0a7b736974655f75726c7d, 'bcc@domain.com', 0, NULL),
(3, 'Deposit Details', 'contactus@domain.com', 'Company', 'Deposit Confirmation', 0x3c7461626c65207374796c653d2277696474683a2035373170783b206865696768743a2034313170783b2220626f726465723d2230222063656c6c70616464696e673d2233223e0d0a3c74626f64793e0d0a3c74723e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20233939393933333b2077696474683a203530253b223e3c7370616e207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7370616e20636c6173733d227374796c6533223e3c7374726f6e673e4465706f73697420436f6e6669726d6174696f6e3c2f7374726f6e673e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f74643e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20233939393933333b2077696474683a203530253b223e0d0a3c64697620636c6173733d227374796c653322207374796c653d22746578742d616c69676e3a2072696768743b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7374726f6e673e446174653a207b7472616e736665725f646174657d3c2f7374726f6e673e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f6469763e0d0a3c2f74643e0d0a3c2f74723e0d0a3c74723e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20236632663961663b2220636f6c7370616e3d2232223e0d0a3c626c6f636b71756f74653e0d0a3c7020636c6173733d227374796c6531223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e207b757365725f66697273745f6e616d657d207b757365725f6c6173745f6e616d657d2c3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f703e0d0a3c7020636c6173733d227374796c6531223e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e5468697320697320616e206175746f2067656e65726174656420636f6e6669726d6174696f6e2072656365697074206f66207061796d656e742e20546f207265766965772074686973206465706f7369742c20706c65617365203c7370616e207374796c653d22666f6e742d66616d696c793a20417269616c2c48656c7665746963612c73616e732d73657269663b20666f6e742d73697a653a20313270783b223e6c6f6720696e20746f20796f7572206163636f756e743c2f7370616e3e2e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e203c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c6120687265663d222e2e2f696e6465782e706870223e3c2f613e3c2f703e0d0a3c7020636c6173733d227374796c6531223e266e6273703b3c2f703e0d0a3c7020636c6173733d227374796c6531223e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7374726f6e673e4465706f7369742044657461696c733c2f7374726f6e673e3a3c6272202f3e56616c75653a20247b7472616e736665725f76616c75657d3c6272202f3e446174653a207b7472616e736665725f646174657d3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f703e0d0a3c7020636c6173733d227374796c6531223e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c6272202f3e3c2f7370616e3e3c2f7370616e3e3c2f703e0d0a3c7020636c6173733d227374796c6531223e3c212d2d5b696620677465206d736f20395d3e3c786d6c3e203c773a576f7264446f63756d656e743e203c773a566965773e4e6f726d616c3c2f773a566965773e203c773a5a6f6f6d3e303c2f773a5a6f6f6d3e203c773a50756e6374756174696f6e4b65726e696e67202f3e203c773a56616c6964617465416761696e7374536368656d6173202f3e203c773a536176654966584d4c496e76616c69643e66616c73653c2f773a536176654966584d4c496e76616c69643e203c773a49676e6f72654d69786564436f6e74656e743e66616c73653c2f773a49676e6f72654d69786564436f6e74656e743e203c773a416c7761797353686f77506c616365686f6c646572546578743e66616c73653c2f773a416c7761797353686f77506c616365686f6c646572546578743e203c773a436f6d7061746962696c6974793e203c773a427265616b577261707065645461626c6573202f3e203c773a536e6170546f47726964496e43656c6c202f3e203c773a4170706c79427265616b696e6752756c6573202f3e203c773a57726170546578745769746850756e6374202f3e203c773a557365417369616e427265616b52756c6573202f3e203c773a446f6e7447726f774175746f666974202f3e203c2f773a436f6d7061746962696c6974793e203c773a42726f777365724c6576656c3e4d6963726f736f6674496e7465726e65744578706c6f726572343c2f773a42726f777365724c6576656c3e203c2f773a576f7264446f63756d656e743e203c2f786d6c3e3c215b656e6469665d2d2d3e3c212d2d5b696620677465206d736f20395d3e3c786d6c3e203c773a4c6174656e745374796c6573204465664c6f636b656453746174653d2266616c736522204c6174656e745374796c65436f756e743d22313536223e203c2f773a4c6174656e745374796c65733e203c2f786d6c3e3c215b656e6469665d2d2d3e3c212d2d5b696620677465206d736f2031305d3e203c6d63653a7374796c653e3c212020202f2a205374796c6520446566696e6974696f6e73202a2f20207461626c652e4d736f4e6f726d616c5461626c6520097b6d736f2d7374796c652d6e616d653a225461626c65204e6f726d616c223b20096d736f2d747374796c652d726f7762616e642d73697a653a303b20096d736f2d747374796c652d636f6c62616e642d73697a653a303b20096d736f2d7374796c652d6e6f73686f773a7965733b20096d736f2d7374796c652d706172656e743a22223b20096d736f2d70616464696e672d616c743a30696e20352e3470742030696e20352e3470743b20096d736f2d706172612d6d617267696e3a30696e3b20096d736f2d706172612d6d617267696e2d626f74746f6d3a2e3030303170743b20096d736f2d706167696e6174696f6e3a7769646f772d6f727068616e3b2009666f6e742d73697a653a31302e3070743b2009666f6e742d66616d696c793a2254696d6573204e657720526f6d616e223b20096d736f2d616e73692d6c616e67756167653a23303430303b20096d736f2d666172656173742d6c616e67756167653a23303430303b20096d736f2d626964692d6c616e67756167653a23303430303b7d202d2d3e203c212d2d5b656e6469665d2d2d3e3c2f703e0d0a3c2f626c6f636b71756f74653e0d0a3c626c6f636b71756f74653e0d0a3c7020636c6173733d227374796c6531223e3c6272202f3e7b7468616e6b737d3c2f703e0d0a3c7020636c6173733d227374796c6531223e3c6272202f3e7b636f6d70616e795f6e616d657d3c6272202f3e7b736974655f75726c7d3c2f703e0d0a3c2f626c6f636b71756f74653e0d0a3c703e266e6273703b3c2f703e0d0a3c703e3c7370616e207374796c653d22666f6e742d66616d696c793a2076657264616e612c67656e6576613b223e3c6272202f3e3c2f7370616e3e3c2f703e0d0a3c2f74643e0d0a3c2f74723e0d0a3c74723e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20233939393933333b223e3c7370616e207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e3c7370616e20636c6173733d227374796c6533223e5265666572656e63653a207b7472616e736665725f7265667d3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f74643e0d0a3c7464207374796c653d22746578742d616c69676e3a206c6566743b206261636b67726f756e642d636f6c6f723a20233939393933333b223e3c7370616e207374796c653d22666f6e742d66616d696c793a20617269616c2c68656c7665746963612c73616e732d73657269663b223e3c7370616e207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7370616e20636c6173733d227374796c6533223e203c7370616e207374796c653d22636f6c6f723a20233030303030303b223e4163636f756e74204e756d6265723a207b757365725f6163636f756e745f6e756d7d203c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f74643e0d0a3c2f74723e0d0a3c2f74626f64793e0d0a3c2f7461626c653e0d0a3c703e3c7370616e207374796c653d22666f6e742d66616d696c793a2076657264616e612c67656e6576613b223e266e6273703b3c2f7370616e3e3c2f703e0d0a3c6469762069643d225f6d6365506173746522207374796c653d22706f736974696f6e3a206162736f6c7574653b206c6566743a202d313030303070783b20746f703a203070783b2077696474683a203170783b206865696768743a203170783b206f766572666c6f773a2068696464656e3b223e3c212d2d5b696620677465206d736f20395d3e3c786d6c3e203c773a576f7264446f63756d656e743e203c773a566965773e4e6f726d616c3c2f773a566965773e203c773a5a6f6f6d3e303c2f773a5a6f6f6d3e203c773a50756e6374756174696f6e4b65726e696e67202f3e203c773a56616c6964617465416761696e7374536368656d6173202f3e203c773a536176654966584d4c496e76616c69643e66616c73653c2f773a536176654966584d4c496e76616c69643e203c773a49676e6f72654d69786564436f6e74656e743e66616c73653c2f773a49676e6f72654d69786564436f6e74656e743e203c773a416c7761797353686f77506c616365686f6c646572546578743e66616c73653c2f773a416c7761797353686f77506c616365686f6c646572546578743e203c773a436f6d7061746962696c6974793e203c773a427265616b577261707065645461626c6573202f3e203c773a536e6170546f47726964496e43656c6c202f3e203c773a4170706c79427265616b696e6752756c6573202f3e203c773a57726170546578745769746850756e6374202f3e203c773a557365417369616e427265616b52756c6573202f3e203c773a446f6e7447726f774175746f666974202f3e203c2f773a436f6d7061746962696c6974793e203c773a42726f777365724c6576656c3e4d6963726f736f6674496e7465726e65744578706c6f726572343c2f773a42726f777365724c6576656c3e203c2f773a576f7264446f63756d656e743e203c2f786d6c3e3c215b656e6469665d2d2d3e3c212d2d5b696620677465206d736f20395d3e3c786d6c3e203c773a4c6174656e745374796c6573204465664c6f636b656453746174653d2266616c736522204c6174656e745374796c65436f756e743d22313536223e203c2f773a4c6174656e745374796c65733e203c2f786d6c3e3c215b656e6469665d2d2d3e3c212d2d5b696620677465206d736f2031305d3e203c6d63653a7374796c653e3c212020202f2a205374796c6520446566696e6974696f6e73202a2f20207461626c652e4d736f4e6f726d616c5461626c6520097b6d736f2d7374796c652d6e616d653a225461626c65204e6f726d616c223b20096d736f2d747374796c652d726f7762616e642d73697a653a303b20096d736f2d747374796c652d636f6c62616e642d73697a653a303b20096d736f2d7374796c652d6e6f73686f773a7965733b20096d736f2d7374796c652d706172656e743a22223b20096d736f2d70616464696e672d616c743a30696e20352e3470742030696e20352e3470743b20096d736f2d706172612d6d617267696e3a30696e3b20096d736f2d706172612d6d617267696e2d626f74746f6d3a2e3030303170743b20096d736f2d706167696e6174696f6e3a7769646f772d6f727068616e3b2009666f6e742d73697a653a31302e3070743b2009666f6e742d66616d696c793a2254696d6573204e657720526f6d616e223b20096d736f2d616e73692d6c616e67756167653a23303430303b20096d736f2d666172656173742d6c616e67756167653a23303430303b20096d736f2d626964692d6c616e67756167653a23303430303b7d202d2d3e203c212d2d5b656e6469665d2d2d3e0d0a3c7020636c6173733d227374796c6531223e3c7370616e207374796c653d22666f6e742d66616d696c793a20417269616c3b20636f6c6f723a20626c61636b3b223e4265737420526567617264732c203c6272202f3e203c2f7370616e3e4672656d6f6e742054726164696e67266e6273703b3c7370616e207374796c653d22666f6e742d66616d696c793a20417269616c3b223e3c6272202f3e203c6120687265663d22687474703a2f2f7777772e72646774726164696e672e636f6d2f223e6672656d6f6e7474726164696e672e636f6d3c2f613e3c2f7370616e3e3c2f703e0d0a3c2f6469763e, '', 'bcc@domain.com', 0, 'tem_kJcFrD3RazrJLbSyL4FPXn'),
(4, 'Withdraw Details', 'contact@domain.com', 'Company', 'Withdraw Details', 0x3c703e48656c6c6f207b757365725f66697273745f6e616d657d207b757365725f6c6173745f6e616d657d2c3c6272202f3e3c6272202f3e596f75206861766520726571756573742061207769746864726177616c2e203c6272202f3e3c7374726f6e673e3c6272202f3e57697468647261772044657461696c733a3c2f7374726f6e673e3c6272202f3e524546206e756d6265723a207b7472616e736665725f7265667d3c6272202f3e56616c75653a207b7472616e736665725f76616c75657d3c6272202f3e466565733a207b7472616e736665725f666565737d3c6272202f3e546f74616c3a207b7472616e736665725f746f74616c7d3c6272202f3e5374617475733a207b7472616e736665725f7374617475737d3c6272202f3e446174653a207b7472616e736665725f646174657d3c6272202f3e3c6272202f3e3c6272202f3e3c6272202f3e3c6272202f3e7b7468616e6b737d3c6272202f3e207b636f6d70616e795f6e616d657d3c6272202f3e207b736974655f75726c7d3c2f703e, 0x48656c6c6f207b757365725f66697273745f6e616d657d207b757365725f6c6173745f6e616d657d2c0d0a0d0a596f75206861766520726571756573742061207769746864726177616c2e200d0a0d0a57697468647261772044657461696c733a0d0a524546206e756d6265723a207b7472616e736665725f7265667d0d0a56616c75653a207b7472616e736665725f76616c75657d0d0a466565733a207b7472616e736665725f666565737d0d0a546f74616c3a207b7472616e736665725f746f74616c7d0d0a5374617475733a207b7472616e736665725f7374617475737d0d0a446174653a207b7472616e736665725f646174657d0d0a0d0a0d0a0d0a0d0a7b7468616e6b737d0d0a7b636f6d70616e795f6e616d657d0d0a7b736974655f75726c7d, 'contact@domain.com', 0, NULL),
(1, 'Welcome Mail', 'contact@silverridgeresources.com', 'Silver Ridge Resources', 'Welcome to the trade platform', 0x3c7461626c65207374796c653d2277696474683a2035353070783b20626f726465722d636f6c6f723a20233030303030303b20626f726465722d77696474683a203170783b2220626f726465723d2230222063656c6c73706163696e673d2230222063656c6c70616464696e673d2236223e0d0a3c74626f64793e0d0a3c74723e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20233636303030303b2077696474683a203530253b223e3c7370616e207374796c653d22666f6e742d66616d696c793a2067656f726769612c70616c6174696e6f3b223e3c7370616e207374796c653d22636f6c6f723a20236666666666663b223e3c7370616e20636c6173733d227374796c653322207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7374726f6e673e547261646520436f6e6669726d6174696f6e3c2f7374726f6e673e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f74643e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20233636303030303b2077696474683a203530253b223e0d0a3c64697620636c6173733d227374796c653322207374796c653d22746578742d616c69676e3a2072696768743b223e3c7370616e207374796c653d22666f6e742d66616d696c793a2067656f726769612c70616c6174696e6f3b223e3c7370616e207374796c653d22636f6c6f723a20236666666666663b223e3c7370616e207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7374726f6e673e446174653a207b74726164655f646174657d3c2f7374726f6e673e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f6469763e0d0a3c2f74643e0d0a3c2f74723e0d0a3c74723e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20236666633b2220636f6c7370616e3d2232223e0d0a3c626c6f636b71756f74653e0d0a3c7020636c6173733d227374796c6531223e266e6273703b3c2f703e0d0a3c7020636c6173733d227374796c6531223e3c7370616e207374796c653d22666f6e742d66616d696c793a2067656f726769612c70616c6174696e6f3b223e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e7b757365725f66697273745f6e616d657d207b757365725f6c6173745f6e616d657d2c3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f703e0d0a3c7020636c6173733d227374796c6531223e3c7370616e207374796c653d22666f6e742d66616d696c793a2067656f726769612c70616c6174696e6f3b223e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22636f6c6f723a20233030303030303b223e5468697320697320616e206175746f6d6174696320636f6e6669726d6174696f6e206f6620747261646520656d61696c2e20546f2072657669657720746869732074726164652c20706c65617365206c6f6720696e20746f20796f7572206163636f756e742e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f703e0d0a3c7020636c6173733d227374796c6531223e3c7370616e207374796c653d22666f6e742d66616d696c793a2067656f726769612c70616c6174696e6f3b223e3c7374726f6e673e4c6f67696e3a203c2f7374726f6e673e6163636f756e742e776562736974652e636f6d3c2f7370616e3e3c2f703e0d0a3c7020636c6173733d227374796c6531223e3c6272202f3e203c6272202f3e203c7370616e207374796c653d22666f6e742d66616d696c793a2067656f726769612c70616c6174696e6f3b223e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22636f6c6f723a20233036303b223e3c7374726f6e673e425559204f726465722054726164652044657461696c733a3c2f7374726f6e673e3c6272202f3e506f736974696f6e733a207b74726164655f706f736974696f6e737d3c6272202f3e54726164653a207b74726164655f64657461696c737d3c6272202f3e5374617475733a207b74726164655f7374617475737d3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f703e0d0a3c703e266e6273703b3c2f703e0d0a3c2f626c6f636b71756f74653e0d0a3c626c6f636b71756f74653e0d0a3c7020636c6173733d227374796c6531223e3c7370616e207374796c653d22636f6c6f723a20233030303038303b223e3c7370616e207374796c653d22666f6e742d73697a653a20736d616c6c3b223e3c7370616e207374796c653d22666f6e742d66616d696c793a2067656f726769612c70616c6174696e6f3b223e7b7468616e6b737d3c6272202f3e207b636f6d70616e795f6e616d657d3c6272202f3e207b736974655f75726c7d3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f703e0d0a3c2f626c6f636b71756f74653e0d0a3c703e266e6273703b3c2f703e0d0a3c2f74643e0d0a3c2f74723e0d0a3c74723e0d0a3c7464207374796c653d226261636b67726f756e642d636f6c6f723a20233630303b223e3c7370616e207374796c653d22666f6e742d66616d696c793a2067656f726769612c70616c6174696e6f3b223e3c7370616e207374796c653d22636f6c6f723a20236666666666663b223e3c7370616e207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7370616e20636c6173733d227374796c6533223e5265666572656e63653a207b74726164655f7265667d3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f74643e0d0a3c7464207374796c653d22746578742d616c69676e3a2072696768743b206261636b67726f756e642d636f6c6f723a20233630303b223e3c7370616e207374796c653d22666f6e742d66616d696c793a2067656f726769612c70616c6174696e6f3b223e3c7370616e207374796c653d22666f6e742d73697a653a206d656469756d3b223e3c7370616e20636c6173733d227374796c6533223e203c7370616e207374796c653d22636f6c6f723a20236666666666663b223e4163636f756e74204e756d6265723a207b757365725f6163636f756e745f6e756d7d203c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f7370616e3e3c2f74643e0d0a3c2f74723e0d0a3c2f74626f64793e0d0a3c2f7461626c653e, '', 'bcc@silverridgeresources.com', 1, 'tem_tTbya6vDDWxGaNrmNE3RCB'),
(7, 'Funding Details', 'contact@domain.com', 'Company', 'Funding Details', 0x3c703e48656c6c6f207b757365725f66697273745f6e616d657d207b757365725f6c6173745f6e616d657d2c3c6272202f3e3c6272202f3e3c6272202f3e3c6272202f3e7b7468616e6b737d3c6272202f3e207b636f6d70616e795f6e616d657d3c6272202f3e207b736974655f75726c7d3c2f703e, '', 'bcc@domain.com', 1, 'tem_kJcFrD3RazrJLbSyL4FPXn'),
(8, 'Statement of Account', 'contact@domain.com', 'Company', 'Statement of Account', 0x3c703e48656c6c6f207b757365725f66697273745f6e616d657d207b757365725f6c6173745f6e616d657d2c3c6272202f3e3c6272202f3e3c6272202f3e3c6272202f3e7b6163636f756e745f73746174656d656e747d3c6272202f3e3c6272202f3e3c6272202f3e7b7468616e6b737d3c6272202f3e207b636f6d70616e795f6e616d657d3c6272202f3e207b736974655f75726c7d3c2f703e, 0x48656c6c6f207b757365725f66697273745f6e616d657d207b757365725f6c6173745f6e616d657d2c0d0a0d0a0d0a0d0a7b6163636f756e745f73746174656d656e747d0d0a0d0a7b7468616e6b737d0d0a7b636f6d70616e795f6e616d657d0d0a7b736974655f75726c7d, 'bcc@domain.com', 1, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `pdf_templates`
--

CREATE TABLE IF NOT EXISTS `pdf_templates` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(32) NOT NULL,
  `content` text NOT NULL,
  `pdf_external_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pdf_templates`
--

INSERT INTO `pdf_templates` (`id`, `name`, `slug`, `content`, `pdf_external_id`) VALUES
(1, 'Account summary', 'account_summary', '<h2>Account Summary</h2>\r\n\r\n<table style="width: 100%;">\r\n    <tr>\r\n        <td width="60%">Name: {user_firstname} {user_middlename} {user_lastname}</td>\r\n        <td width="10%" rowspan="6"></td>\r\n        <td width="30%">&nbsp;</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Account Name: {user_account_name}</td>\r\n        <td>Date: {%date%}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Account Number: {user_account_num}</td>\r\n        <td>Advisor: {advisor_names}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Address: {user_mailing_address}, {user_city}, {user_state} {user_postal} {user_country}</td>\r\n        <td>Email: {advisor_contacts}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Email: {user_email}</td>\r\n        <td>&nbsp;</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Phone: {user_phone}</td>\r\n        <td>&nbsp;</td>\r\n    </tr>\r\n</table>\r\n\r\n<br />\r\n\r\n<table width="100%" border="1" cellspacing="0" cellpadding="0">\r\n    <tr>\r\n        <th border="0"><strong>Account Balance: ${user_balance}</strong></th>\r\n    </tr>\r\n</table>\r\n{account_statement}', NULL),
(2, 'Stock trade', 'stock_trade', '<h2>Stock Trade Confirmation</h2>\r\n\r\n<table style="width: 100%;">\r\n    <tr>\r\n        <td width="60%">Name: {user_firstname} {user_middlename} {user_lastname}</td>\r\n        <td width="10%" rowspan="6"></td>\r\n        <td width="30%">&nbsp;</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Account Name: {user_account_name}</td>\r\n        <td>Date: {%date%}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Account Number: {user_account_num}</td>\r\n        <td>Advisor: {advisor_names}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Address: {user_mailing_address}, {user_city}, {user_state} {user_postal} {user_country}</td>\r\n        <td>Email: {advisor_contacts}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Email: {user_email}</td>\r\n        <td>&nbsp;</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Phone: {user_phone}</td>\r\n        <td>&nbsp;</td>\r\n    </tr>\r\n</table>\r\n\r\n<br />\r\n\r\n<table width="100%" border="1" cellspacing="0" cellpadding="0">\r\n    <tr>\r\n        <th border="0">Trade Executed: {trade_details}</th>\r\n    </tr>\r\n</table>\r\n\r\n<br />\r\n\r\n<table style="width: 100%;">\r\n    <tr>\r\n        <td width="50%">Trade Date: {trade_date}</td>\r\n        <td width="10%" rowspan="4"></td>\r\n        <td width="40%">Trade Price/Share: ${trade_price_share}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Trade ID: {trade_ref}</td>\r\n        <td>Trade Shares: {trade_shares}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Type: {trade_type}</td>\r\n        <td>Trade Value: ${trade_value}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Fees: ${trade_fees}</td>\r\n        <td>Trade Invoiced: <strong>${trade_invoiced}</strong></td>\r\n    </tr>\r\n</table>', NULL),
(3, 'Options trade', 'options_trade', '<h1>Options Trade Confirmation</h1>\r\n\r\n<table style="width: 100%;">\r\n    <tr>\r\n        <td width="60%">Name: {user_firstname} {user_middlename} {user_lastname}</td>\r\n        <td width="10%" rowspan="6"></td>\r\n        <td width="30%">&nbsp;</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Account Name: {user_account_name}</td>\r\n        <td>Date: {%date%}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Account Number: {user_uid}</td>\r\n        <td>Advisor: {advisor_names}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Address: {user_mailing_address}, {user_city}, {user_state} {user_postal} {user_country}</td>\r\n        <td>Email: {advisor_contacts}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Email: {user_email}</td>\r\n        <td>&nbsp;</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Phone: {user_phone}</td>\r\n        <td>&nbsp;</td>\r\n    </tr>\r\n</table>\r\n\r\n<br />\r\n\r\n<table width="100%" border="1" cellspacing="0" cellpadding="0">\r\n    <tr>\r\n        <th border="0">Trade Executed: {trade_details}</th>\r\n    </tr>\r\n</table>\r\n\r\n<br />\r\n\r\n<table style="width: 100%;">\r\n    <tr>\r\n        <td width="50%">Trade Date: {trade_date}</td>\r\n        <td width="10%" rowspan="5"></td>\r\n        <td width="40%">Premium: {trade_premium_price}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Trade ID: {trade_ref}</td>\r\n        <td>Contract Size: {trade_contract_size}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Kind: {trade_option}</td>\r\n        <td>Price/Contract: ${trade_price_contract}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Fees: ${trade_fees}</td>\r\n        <td>Trade value: ${trade_value}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Strike Price: ${trade_strikeprice}</td>\r\n        <td><b>Total Invoiced: ${trade_invoiced}</b></td>\r\n    </tr>\r\n</table>', NULL),
(4, 'Transfer (deposit)', 'transfer_deposit', '<h2>Deposit Confirmation</h2>\r\n\r\n<table style="width: 100%;">\r\n    <tr>\r\n        <td width="60%">Name: {user_firstname} {user_middlename} {user_lastname}</td>\r\n        <td width="10%" rowspan="6"></td>\r\n        <td width="30%">&nbsp;</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Account Name: {user_account_name}</td>\r\n        <td>Date: {%date%}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Account Number: {user_account_num}</td>\r\n        <td>Advisor: {advisor_names}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Address: {user_mailing_address}, {user_city}, {user_state} {user_postal} {user_country}</td>\r\n        <td>Email: {advisor_contacts}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Email: {user_email}</td>\r\n        <td>&nbsp;</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Phone: {user_phone}</td>\r\n        <td>&nbsp;</td>\r\n    </tr>\r\n</table>\r\n\r\n<br />\r\n\r\n<table width="100%" border="1" cellspacing="0" cellpadding="0">\r\n    <tr>\r\n        <th border="0">Transfer Type: {tr_type}</th>\r\n    </tr>\r\n</table>\r\n\r\n<br />\r\n\r\n<table style="width: 100%;">\r\n    <tr>\r\n        <td width="50%">Transfer date: {tr_date}</td>\r\n        <td width="10%" rowspan="3"></td>\r\n        <td width="40%">Deposit: ${tr_value}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Transfer ID: {tr_ref}</td>\r\n        <td>Fees: ${tr_fees}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>&nbsp;</td>\r\n        <td><strong>Total deposit: ${tr_total}</strong></td>\r\n    </tr>\r\n</table>', NULL),
(5, 'Transfer (withdraw)', 'transfer_withdraw', '<h1>Withdraw confirmation</h1>\r\n\r\n<table style="width: 100%;">\r\n    <tr>\r\n        <td width="60%">Name: {user_firstname} {user_middlename} {user_lastname}</td>\r\n        <td width="10%" rowspan="6"></td>\r\n        <td width="30%">&nbsp;</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Account Name: {user_account_name}</td>\r\n        <td>Date: {%date%}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Account Number: {user_account_num}</td>\r\n        <td>Advisor: {advisor_names}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Address: {user_mailing_address}, {user_city}, {user_state} {user_postal} {user_country}</td>\r\n        <td>Email: {advisor_contacts}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Email: {user_email}</td>\r\n        <td>&nbsp;</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Phone: {user_phone}</td>\r\n        <td>&nbsp;</td>\r\n    </tr>\r\n</table>\r\n\r\n<br />\r\n\r\n<table width="100%" border="1" cellspacing="0" cellpadding="0">\r\n    <tr>\r\n        <th border="0">Transfer Type: {tr_type}</th>\r\n    </tr>\r\n</table>\r\n\r\n<br />\r\n\r\n<table style="width: 100%;">\r\n    <tr>\r\n        <td width="50%">Transfer date: {tr_date}</td>\r\n        <td width="10%" rowspan="3"></td>\r\n        <td width="40%">Withdraw: ${tr_value}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Transfer ID: {tr_ref}</td>\r\n        <td>Fees: ${tr_fees}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>&nbsp;</td>\r\n        <td>Total withdraw: ${tr_total}</td>\r\n    </tr>\r\n</table>\r\n\r\n<h2>Bank Details</h2>\r\n\r\n<table style="width: 100%;">\r\n    <tr>\r\n        <td>Beneficiary: {tr_bank_beneficiary}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Bank Address: {tr_bank_address}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Bank Account: {tr_bank_account}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Bank Name: {tr_bank_name}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>{tr_bank_codetype}: {tr_bank_code}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>More Bank Details: {tr_bank_moredetails}</td>\r\n    </tr>\r\n</table>', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `stocks`
--

CREATE TABLE IF NOT EXISTS `stocks` (
  `stocks_id` bigint(20) NOT NULL,
  `stocks_symbol` varchar(10) NOT NULL,
  `stocks_name` varchar(250) NOT NULL,
  `stocks_links` text NOT NULL,
  `checking` varchar(10) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `stocks`
--

INSERT INTO `stocks` (`stocks_id`, `stocks_symbol`, `stocks_name`, `stocks_links`, `checking`) VALUES
(1, 'AAPL', 'Apple Computer', 'http://www.google.com/finance?q=aapl', 'hourly'),
(2, 'GOOG', 'Google Inc.', 'http://www.google.com/finance?q=GOOG', 'hourly'),
(3, 'BABA', 'Alibaba', 'https://www.google.com/finance?q=baba', 'hourly'),
(4, 'NUTX', 'Nutanix', '', NULL),
(5, 'NUTXa', 'Nutanix Class A', '', NULL),
(6, 'FRRI', 'Ferrari', '', NULL),
(7, 'NTRI', 'NutriSystem Inc', 'https://www.google.com/finance?q=ntri', 'hourly'),
(8, 'DOX', 'Amdocs Limited', 'https://www.google.com/finance?q=DOX', NULL),
(9, 'UNXL', 'UniPixel Inc', 'https://www.google.com/finance?q=UNXL', 'hourly');

-- --------------------------------------------------------

--
-- Структура таблицы `stock_details`
--

CREATE TABLE IF NOT EXISTS `stock_details` (
  `details_id` bigint(20) NOT NULL,
  `details_ref` bigint(20) NOT NULL DEFAULT '0',
  `stocks_id` bigint(20) NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `volume` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `value` float(10,2) NOT NULL DEFAULT '0.00',
  `value_change` float(4,2) NOT NULL DEFAULT '0.00'
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `stock_details`
--

INSERT INTO `stock_details` (`details_id`, `details_ref`, `stocks_id`, `date`, `volume`, `value`, `value_change`) VALUES
(1, 253318200987, 1, '2011-05-30 00:00:00', NULL, 337.41, 0.00),
(2, 253319273107, 2, '2011-05-30 00:00:00', NULL, 520.90, 0.00),
(3, 253319824925, 1, '2011-05-30 00:00:00', '86.508', 337.25, -0.05),
(4, 253319824925, 2, '2011-05-30 00:00:00', '24.317', 521.40, 0.10),
(5, 253341336723, 1, '2011-05-31 00:00:00', '0', 337.25, -0.05),
(6, 253341336723, 2, '2011-05-31 00:00:00', '0', 521.40, 0.10),
(16, 279400987198, 3, '2014-08-21 00:00:00', '', 21.50, 0.47),
(15, 279391513336, 1, '2014-08-21 00:00:00', '', 434.00, -20.07),
(14, 279391508516, 1, '2014-08-20 00:00:00', '', 543.00, 61.01),
(10, 276012275934, 3, '2014-03-20 00:00:00', NULL, 21.40, -0.47),
(11, 276012278225, 3, '2014-03-19 00:00:00', NULL, 21.30, -0.93),
(12, 276012281423, 3, '2014-03-18 00:00:00', NULL, 21.20, -1.40),
(13, 276012285090, 3, '2014-03-17 00:00:00', NULL, 21.10, -1.86),
(17, 279401818504, 3, '2014-08-21 00:00:00', '', 44.00, 99.99),
(18, 279887165263, 1, '2014-09-12 00:00:00', '', 101.00, -76.73),
(19, 280342328641, 1, '2014-10-03 00:00:00', '47757828', 99.90, -1.09),
(20, 280342328641, 2, '2014-10-03 00:00:00', '1175307', 570.08, 9.34),
(21, 280342328641, 3, '2014-10-03 00:00:00', '21469688', 87.06, 99.99),
(22, 282556317387, 1, '2015-01-11 00:00:00', '53699528', 112.01, 12.12),
(23, 282556317388, 2, '2015-01-11 00:00:00', '2065715', 496.17, -12.96),
(24, 282556317388, 3, '2015-01-11 00:00:00', '10222235', 103.02, 18.33),
(25, 282556330386, 4, '2015-01-11 00:00:00', NULL, 8.00, 0.00),
(26, 283417928211, 5, '2015-02-19 00:00:00', NULL, 16.00, 0.00),
(27, 283417932320, 1, '2015-02-19 13:41:01', '44891736', 128.72, 14.91),
(28, 283417932320, 2, '2015-02-19 13:41:01', '1449089', 539.70, 8.77),
(29, 283417932320, 3, '2015-02-19 13:41:01', '7422267', 86.74, -15.80),
(30, 284171066189, 6, '2015-03-25 00:00:00', NULL, 16.00, 0.00),
(31, 284171070355, 1, '2015-03-25 14:53:26', '32842304', 126.69, -1.58),
(32, 284171070355, 2, '2015-03-25 14:53:26', '2576234', 570.19, 5.65),
(33, 284171070355, 3, '2015-03-25 14:53:26', '14545075', 83.63, -3.59),
(34, 289463834184, 1, '2015-11-19 22:41:57', '46968630', 117.29, -7.42),
(35, 289463834184, 2, '2015-11-19 22:41:57', '1685075', 740.00, 29.78),
(36, 289463834184, 3, '2015-11-19 22:41:57', '16765033', 77.69, -7.10),
(37, 289480506472, 1, '2015-11-20 17:01:07', '43295820', 118.78, 0.00),
(38, 289480506472, 2, '2015-11-20 17:01:07', '1327879', 738.41, 0.00),
(39, 289480506472, 3, '2015-11-20 17:01:07', '15692710', 77.87, 0.00),
(40, 289480825179, 7, '2015-11-19 16:33:52', '226226', 23.02, 9.51),
(41, 289481040202, 7, '2015-11-19 16:34:36', '226226', 15.02, 0.00),
(42, 289481046097, 7, '2015-11-20 17:01:07', '226226', 23.02, 0.00),
(43, 289481222767, 8, '2015-11-20 00:00:00', NULL, 3.00, 0.00),
(44, 289481406527, 9, '2015-11-20 17:01:07', '3675556', 1.22, -59.33);

-- --------------------------------------------------------

--
-- Структура таблицы `stock_trades`
--

CREATE TABLE IF NOT EXISTS `stock_trades` (
  `trades_id` bigint(20) NOT NULL DEFAULT '0',
  `user_account_num` bigint(20) NOT NULL DEFAULT '0',
  `trade_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1 - Buy, 2 - Sell, 3 - Cover, 4 - Short',
  `trade_shares` int(11) NOT NULL DEFAULT '0',
  `trade_shares_left` int(11) NOT NULL DEFAULT '0',
  `stocks_id` int(11) NOT NULL DEFAULT '0',
  `trade_ref` bigint(20) NOT NULL DEFAULT '0',
  `trade_details` varchar(255) DEFAULT NULL,
  `trade_price_share` float(16,2) NOT NULL DEFAULT '0.00',
  `trade_value` float(16,2) NOT NULL DEFAULT '0.00',
  `trade_fees` float(11,2) NOT NULL DEFAULT '0.00',
  `trade_invoiced` float(16,2) NOT NULL DEFAULT '0.00',
  `trade_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1: open, 2: pending, 3: disabled, 4: closed',
  `trade_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `trade_notes` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `stock_trades`
--

INSERT INTO `stock_trades` (`trades_id`, `user_account_num`, `trade_type`, `trade_shares`, `trade_shares_left`, `stocks_id`, `trade_ref`, `trade_details`, `trade_price_share`, `trade_value`, `trade_fees`, `trade_invoiced`, `trade_status`, `trade_date`, `trade_notes`) VALUES
(13019242814, 11220840763, 1, 10, 10, 1, 253318625006, 'BUY 10x AAPL@337.41', 337.41, 3374.10, 10.00, 3384.10, 1, '2011-05-30 07:50:42', ''),
(16664590885, 11220840763, 1, 10, 0, 2, 276102050456, 'BUY 10x GOOG@522.40', 522.40, 5224.00, 0.00, 5224.00, 4, '2014-03-24 00:00:00', ''),
(16688144274, 11220840763, 2, 10, 10, 2, 276249259135, 'SELL 10x GOOG@21.50', 21.50, 215.00, 22.00, 193.00, 1, '0000-00-00 00:00:00', ''),
(17192276220, 16667065685, 1, 10, 10, 1, 279400083796, 'BUY 10x AAPL@434.00', 434.00, 4340.00, 43.40, 4383.40, 1, '2014-08-18 00:00:00', ''),
(17760470501, 17760048368, 1, 388, 388, 4, 282951298048, 'BUY 388x NUTX@8.00', 8.00, 3104.00, 31.04, 3135.04, 1, '2015-01-29 00:00:00', ''),
(17763753434, 17763742164, 1, 1250, 1250, 4, 282971816383, 'BUY 1250x NUTX@8.00', 8.00, 10000.00, 100.00, 10100.00, 1, '2015-01-30 00:00:00', ''),
(17774940840, 17774934682, 1, 600, 600, 4, 283041737666, 'BUY 600x NUTX@8.00', 8.00, 4800.00, 48.00, 4848.00, 1, '2015-02-02 00:00:00', ''),
(17781994502, 17781980966, 1, 500, 500, 4, 283085823052, 'BUY 500x NUTX@8.00', 8.00, 4000.00, 40.00, 4040.00, 1, '2015-02-04 00:00:00', ''),
(17789178348, 17789162800, 1, 625, 625, 4, 283130722094, 'BUY 625x NUTX@8.00', 8.00, 5000.00, 50.00, 5050.00, 1, '2015-02-06 00:00:00', ''),
(17809699702, 17809687372, 1, 750, 750, 4, 283258980558, 'BUY 750x NUTX@8.00', 8.00, 6000.00, 60.00, 6060.00, 1, '2015-02-12 00:00:00', ''),
(17834378204, 17834361566, 1, 1000, 1000, 4, 283413221194, 'BUY 1000x NUTX@8.00', 8.00, 8000.00, 80.00, 8080.00, 1, '2015-02-19 00:00:00', ''),
(17835136725, 17774934682, 1, 1000, 1000, 5, 283417961950, 'BUY 1000x NUTXa@16.00', 16.00, 16000.00, 160.00, 16160.00, 1, '2015-02-19 00:00:00', ''),
(17838731551, 17838715529, 1, 1250, 0, 4, 283440429611, 'BUY 1250x NUTX@8.00', 8.00, 10000.00, 100.00, 10100.00, 4, '2015-02-20 00:00:00', ''),
(17859133687, 17859119724, 1, 1000, 1000, 4, 283567942960, 'BUY 1000x NUTX@8.00', 8.00, 8000.00, 80.00, 8080.00, 1, '2015-02-26 00:00:00', ''),
(17884005425, 17883987493, 1, 1000, 1000, 4, 283723391324, 'BUY 1000x NUTX@8.00', 8.00, 8000.00, 80.00, 8080.00, 1, '2015-03-05 00:00:00', ''),
(17887760800, 17887744703, 1, 1250, 1250, 4, 283746862417, 'BUY 1250x NUTX@8.00', 8.00, 10000.00, 100.00, 10100.00, 1, '2015-03-06 00:00:00', ''),
(17899032931, 17899025749, 1, 1250, 1250, 4, 283817313235, 'BUY 1250x NUTX@8.00', 8.00, 10000.00, 100.00, 10100.00, 1, '2015-03-09 00:00:00', ''),
(17912378340, 17838715529, 1, 2500, 2500, 5, 283900722045, 'BUY 2500x NUTXa@16.00', 16.00, 40000.00, 400.00, 40400.00, 1, '2015-03-13 00:00:00', ''),
(17913115977, 17913109824, 1, 625, 625, 4, 283905332276, 'BUY 625x NUTX@8.00', 8.00, 5000.00, 50.00, 5050.00, 1, '2015-03-13 00:00:00', ''),
(17928057097, 17928039799, 1, 500, 500, 4, 283998714275, 'BUY 500x NUTX@8.00', 8.00, 4000.00, 0.00, 4000.00, 1, '2015-03-17 00:00:00', ''),
(17928095267, 17928062726, 1, 625, 625, 4, 283998952836, 'BUY 625x NUTX@8.00', 8.00, 5000.00, 0.00, 5000.00, 1, '2015-03-17 00:00:00', ''),
(17930758257, 17838715529, 2, 1250, 1250, 4, 284015596530, 'SELL 1250x NUTX@8.61', 8.61, 10762.50, 106.38, 10656.12, 1, '2015-03-18 00:00:00', ''),
(17955637087, 17955594466, 1, 325, 325, 6, 284171089213, 'BUY 325x FRRI@16.00', 16.00, 5200.00, 52.00, 5252.00, 1, '2015-03-25 00:00:00', ''),
(17976005184, 17962179013, 1, 1250, 1250, 4, 284298389816, 'BUY 1250x NUTX@8.00', 8.00, 10000.00, 100.00, 10100.00, 1, '2015-03-31 00:00:00', '');

-- --------------------------------------------------------

--
-- Структура таблицы `stock_watchlist`
--

CREATE TABLE IF NOT EXISTS `stock_watchlist` (
  `id` int(11) unsigned NOT NULL,
  `user_account_num` bigint(20) NOT NULL,
  `stock_id` int(11) DEFAULT NULL,
  `stock_name` varchar(10) NOT NULL,
  `stock_exch` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `stock_watchlist`
--

INSERT INTO `stock_watchlist` (`id`, `user_account_num`, `stock_id`, `stock_name`, `stock_exch`) VALUES
(1, 11220840763, NULL, 'AAPL', 'NASDAQ'),
(2, 11220840763, NULL, 'QIWI', 'NASDAQ'),
(3, 11220840763, NULL, 'MSFT', 'NASDAQ'),
(5, 17774934682, NULL, 'AAPL', 'NASDAQ'),
(6, 17781980966, NULL, 'AAPL', 'NASDAQ'),
(7, 17789162800, NULL, 'AAPL', 'NASDAQ'),
(8, 17809687372, NULL, 'AAPL', 'NASDAQ'),
(15, 17838715529, NULL, 'GWPH', 'NASDAQ'),
(18, 17838715529, NULL, 'CPST', 'NASDAQ'),
(19, 17834361566, NULL, 'AAPL', 'NASDAQ'),
(20, 17859119724, NULL, 'AAPL', 'NASDAQ'),
(21, 17838715529, NULL, 'CEA', 'NYSE'),
(22, 17838715529, NULL, 'GSK', 'NYSE'),
(23, 17838715529, NULL, 'BHP', 'NYSE'),
(24, 17838715529, NULL, 'TRP', 'NYSE'),
(25, 17838715529, NULL, 'NEM', 'NYSE'),
(26, 17838715529, NULL, 'GG', 'NYSE'),
(27, 17838715529, NULL, 'EGO', 'NYSE'),
(28, 17838715529, NULL, 'EMF', 'NYSE'),
(29, 17838715529, NULL, 'ERJ', 'NYSE'),
(30, 17838715529, NULL, 'MELI', 'NASDAQ'),
(32, 17838715529, NULL, 'MWA', 'NYSE'),
(34, 17838715529, NULL, 'SILC', 'NASDAQ'),
(35, 17838715529, NULL, 'GDOT', 'NYSE'),
(36, 17838715529, NULL, 'SLF', 'NYSE'),
(37, 17883987493, NULL, 'AAPL', 'NASDAQ'),
(38, 17887744703, NULL, 'AAPL', 'NASDAQ'),
(39, 17913109824, NULL, 'AAPL', 'NASDAQ'),
(40, 17928039799, NULL, 'AAPL', 'NASDAQ'),
(41, 17955594466, NULL, 'AAPL', 'NASDAQ'),
(42, 11220840763, NULL, 'AAPL', 'NASDAQ'),
(43, 17962179013, NULL, 'TCM.L', 'London'),
(48, 11220840763, NULL, 'YHOO', 'NasdaqGS'),
(51, 11220840763, NULL, 'GOOG', 'NasdaqGS'),
(52, 11220840763, NULL, 'OIL', 'TSXV'),
(53, 11220840763, NULL, 'MASA', 'GOOG_LON');

-- --------------------------------------------------------

--
-- Структура таблицы `trades`
--

CREATE TABLE IF NOT EXISTS `trades` (
  `trades_id` bigint(20) NOT NULL DEFAULT '0',
  `user_account_num` bigint(20) NOT NULL DEFAULT '0',
  `trade_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1 - Buy, 2 - Sell',
  `trade_positions` int(11) NOT NULL DEFAULT '0',
  `trade_positions_left` int(11) NOT NULL DEFAULT '0',
  `trade_option` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1 - CALL, 2 - PUT',
  `commodities_id` int(11) NOT NULL DEFAULT '0',
  `trade_expiry_date` date NOT NULL DEFAULT '0000-00-00',
  `trade_strikeprice` float(11,2) NOT NULL DEFAULT '0.00',
  `trade_ref` bigint(20) NOT NULL DEFAULT '0',
  `trade_details` varchar(255) DEFAULT NULL,
  `trade_premium_price` float(11,4) NOT NULL DEFAULT '0.0000',
  `trade_contract_size` bigint(20) NOT NULL DEFAULT '0',
  `trade_price_contract` float(16,2) NOT NULL DEFAULT '0.00',
  `trade_value` float(16,2) NOT NULL DEFAULT '0.00',
  `trade_fees` float(11,2) NOT NULL DEFAULT '0.00',
  `trade_invoiced` float(16,2) NOT NULL DEFAULT '0.00',
  `trade_date` date NOT NULL DEFAULT '0000-00-00',
  `trade_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1: open, 2: pending, 3: disabled, 4: closed',
  `trade_action_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `trade_notes` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `trades`
--

INSERT INTO `trades` (`trades_id`, `user_account_num`, `trade_type`, `trade_positions`, `trade_positions_left`, `trade_option`, `commodities_id`, `trade_expiry_date`, `trade_strikeprice`, `trade_ref`, `trade_details`, `trade_premium_price`, `trade_contract_size`, `trade_price_contract`, `trade_value`, `trade_fees`, `trade_invoiced`, `trade_date`, `trade_status`, `trade_action_date`, `trade_notes`) VALUES
(13971455524, 11220840763, 1, 5, 5, 1, 8, '2011-05-25', 1750.00, 259269954443, 'BUY 5x CALL GCM11@950.00 SP: $1,750.00', 9.5000, 100, 950.00, 4750.00, 1250.00, 6000.00, '2012-02-23', 1, '2012-02-23 07:27:02', NULL),
(16589105588, 11220840763, 1, 10, 10, 1, 8, '2012-11-27', 0.00, 275630267343, 'BUY 10x CALL GCZ12@200.00 SP: $0.0000', 2.0000, 100, 200.00, 2000.00, 0.00, 2000.00, '2014-03-04', 1, '2014-03-04 11:31:35', ''),
(16586273638, 11220840763, 1, 10, 10, 1, 8, '2012-11-27', 0.00, 275612567655, 'BUY 10x CALL GCZ12@1,200.00 SP: $0.0000', 12.0000, 100, 1200.00, 12000.00, 0.00, 12000.00, '2014-03-03', 1, '2014-03-03 16:19:15', ''),
(16589115417, 11220840763, 1, 2, 2, 1, 4, '2012-11-27', 0.00, 275630328771, 'BUY 2x CALL NGZ12@120,000.00 SP: $0.00', 12.0000, 10000, 120000.00, 240000.00, 0.00, 240000.00, '2014-03-04', 1, '2014-04-01 11:10:00', '');

-- --------------------------------------------------------

--
-- Структура таблицы `trades_related`
--

CREATE TABLE IF NOT EXISTS `trades_related` (
  `trades_related_id` int(11) NOT NULL,
  `trade_ref` bigint(20) NOT NULL DEFAULT '0',
  `trade_ref_relatedto` bigint(20) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `trades_related`
--

INSERT INTO `trades_related` (`trades_related_id`, `trade_ref`, `trade_ref_relatedto`) VALUES
(1, 260749240766, 259270334174),
(2, 263288660665, 263288628476),
(29, 276249259135, 276102050456),
(30, 284015596530, 283440429611);

-- --------------------------------------------------------

--
-- Структура таблицы `transfers`
--

CREATE TABLE IF NOT EXISTS `transfers` (
  `transfers_id` bigint(20) NOT NULL,
  `tr_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1 - deposit, 2 - withdraw',
  `user_account_num` bigint(20) NOT NULL DEFAULT '0',
  `tr_notes` blob,
  `tr_value` float(11,2) NOT NULL DEFAULT '0.00',
  `tr_fees` float(11,2) NOT NULL DEFAULT '0.00',
  `tr_total` float(11,2) NOT NULL DEFAULT '0.00',
  `tr_ref` bigint(13) NOT NULL DEFAULT '0',
  `tr_date` date DEFAULT '0000-00-00',
  `tr_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1 - Transfered, 2 - Pending, 3 - Disabled',
  `tr_system_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tr_system_update` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tr_self_request` tinyint(3) DEFAULT '0',
  `tr_bank_online` tinyint(3) NOT NULL DEFAULT '0',
  `tr_bank_beneficiary` varbinary(100) DEFAULT NULL,
  `tr_bank_address` text,
  `tr_bank_account` varbinary(100) DEFAULT NULL,
  `tr_bank_name` varchar(255) DEFAULT NULL,
  `tr_bank_codetype` tinyint(3) NOT NULL DEFAULT '0',
  `tr_bank_code` varbinary(100) DEFAULT NULL,
  `tr_bank_moredetails` text
) ENGINE=MyISAM AUTO_INCREMENT=17977042277 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `transfers`
--

INSERT INTO `transfers` (`transfers_id`, `tr_type`, `user_account_num`, `tr_notes`, `tr_value`, `tr_fees`, `tr_total`, `tr_ref`, `tr_date`, `tr_status`, `tr_system_date`, `tr_system_update`, `tr_self_request`, `tr_bank_online`, `tr_bank_beneficiary`, `tr_bank_address`, `tr_bank_account`, `tr_bank_name`, `tr_bank_codetype`, `tr_bank_code`, `tr_bank_moredetails`) VALUES
(13971360086, 1, 11220840763, '', 40000.00, 0.00, 40000.00, 2545087432, '2012-02-23', 1, '2012-02-23 06:48:12', '2012-02-23 06:48:12', 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(16664607200, 1, 11220840763, 0x766961205454, 210000.00, 0.00, 210000.00, 24036050105, '2014-03-25', 1, '2014-03-25 19:33:16', '2014-04-01 11:18:59', 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(16589101821, 1, 11220840763, '', 1222.00, 0.00, 1222.00, 15243662083, '2014-03-03', 1, '2014-03-04 11:30:03', '2014-03-04 11:30:03', 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(17788422249, 1, 17760048368, '', 3135.04, 0.00, 3135.04, 240529869, '2015-02-06', 1, '2015-02-06 08:54:47', '2015-02-06 08:54:47', 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(17788430676, 1, 17774934682, '', 4848.00, 0.00, 4848.00, 456256567, '2015-02-06', 1, '2015-02-06 08:58:12', '2015-02-06 08:58:12', 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(17834959699, 1, 17781980966, '', 4040.00, 0.00, 4040.00, 23368141658, '2015-02-19', 1, '2015-02-19 12:30:55', '2015-02-19 12:30:55', 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(17834972030, 1, 17809687372, '', 6060.00, 0.00, 6060.00, 23683812348, '2015-02-19', 1, '2015-02-19 12:35:56', '2015-02-19 12:35:56', 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(17862931364, 1, 17838715529, '', 10100.00, 0.00, 10100.00, 52248003949, '2015-02-27', 1, '2015-02-27 10:12:37', '2015-02-27 10:12:37', 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(17863830267, 1, 17774934682, '', 16160.00, 0.00, 16160.00, 6540438194, '2015-02-27', 1, '2015-02-27 16:18:23', '2015-02-27 16:18:23', 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(17905322563, 1, 17883987493, '', 8080.00, 0.00, 8080.00, 37951063494, '2015-03-11', 1, '2015-03-11 09:41:38', '2015-03-11 09:41:38', 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(17951878106, 1, 17928062726, '', 5000.00, 0.00, 5000.00, 61541852762, '2015-03-24', 1, '2015-03-24 13:25:08', '2015-03-24 13:25:08', 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(17977042276, 1, 17962179013, '', 10100.00, 0.00, 10100.00, 18549859441, '2015-03-31', 1, '2015-03-31 16:04:28', '2015-03-31 16:04:28', 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `ul_blocked_ips`
--

CREATE TABLE IF NOT EXISTS `ul_blocked_ips` (
  `ip` varchar(39) CHARACTER SET ascii NOT NULL,
  `block_expires` varchar(26) CHARACTER SET ascii NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ul_log`
--

CREATE TABLE IF NOT EXISTS `ul_log` (
  `timestamp` varchar(26) CHARACTER SET ascii NOT NULL,
  `action` varchar(20) CHARACTER SET ascii NOT NULL,
  `comment` varchar(255) CHARACTER SET ascii NOT NULL DEFAULT '',
  `user` varchar(400) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(39) CHARACTER SET ascii NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ul_logins`
--

CREATE TABLE IF NOT EXISTS `ul_logins` (
  `id` int(11) NOT NULL,
  `username` varchar(400) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(2048) CHARACTER SET ascii NOT NULL,
  `ref` varchar(10) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `contacts` text,
  `notes` text,
  `type` enum('owner','editor') NOT NULL DEFAULT 'owner',
  `date_created` varchar(26) CHARACTER SET ascii NOT NULL,
  `last_login` varchar(26) CHARACTER SET ascii NOT NULL,
  `block_expires` varchar(26) CHARACTER SET ascii NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ul_logins`
--

INSERT INTO `ul_logins` (`id`, `username`, `password`, `ref`, `name`, `email`, `contacts`, `notes`, `type`, `date_created`, `last_login`, `block_expires`) VALUES
(1, 'innerspacesrr', '$2a$11$Vyzjxhr.91p4WGir5le2S.Lxyhjn5ETHgrKfdIZwcRRTVETgn926K', 'ADM001', '', 'test@example.com', '', '', 'owner', '2014-03-07T15:52:58+01:00', '2015-11-20T07:59:36+01:00', '2014-03-09T10:41:57+01:00'),
(2, 'greenpeace1', '$2a$11$ObfcQbWK4HrdnF3TRVtJX.xiZayUR7YEzTVJ72Df3uUQGoTUapKWq', 'AD02', 'D', 'ctm2408@yahoo.com', '', '', 'editor', '2014-03-21T09:14:42+00:00', '2014-05-23T01:39:43+00:00', '2014-05-04T12:00:08+00:00'),
(3, 'greenpeace2', '$2a$11$BC3Gd9acVouloXyUu3fCVOd408Un0WbllF8nX6vp0mE8gKQ57ppSm', 'AD03', 'AD03', 'fernandovadez@gmail.com', '', '', 'editor', '2014-03-25T11:12:02+00:00', '2015-03-31T07:04:06+00:00', '2014-08-26T04:29:18+00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `ul_nonces`
--

CREATE TABLE IF NOT EXISTS `ul_nonces` (
  `code` varchar(100) CHARACTER SET ascii NOT NULL,
  `action` varchar(850) CHARACTER SET ascii NOT NULL,
  `nonce_expires` varchar(26) CHARACTER SET ascii NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ul_sessions`
--

CREATE TABLE IF NOT EXISTS `ul_sessions` (
  `id` varchar(128) CHARACTER SET ascii NOT NULL DEFAULT '',
  `data` blob NOT NULL,
  `session_expires` varchar(26) CHARACTER SET ascii NOT NULL,
  `lock_expires` varchar(26) CHARACTER SET ascii NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ul_sessions`
--

INSERT INTO `ul_sessions` (`id`, `data`, `session_expires`, `lock_expires`) VALUES
('00ntvj48tnm9ec2fgig023qku7', 0x737365737c613a343a7b733a393a22495061646472657373223b733a303a22223b733a31303a22686f7374446f6d61696e223b733a303a22223b733a393a22757365724167656e74223b733a3130323a224d6f7a696c6c612f352e30202857696e646f7773204e5420362e3129204170706c655765624b69742f3533372e333620284b48544d4c2c206c696b65204765636b6f29204368726f6d652f33362e302e313938352e313433205361666172692f3533372e3336223b733a373a2245585049524553223b693a313430383633363531363b7d61646d696e7c613a383a7b733a31323a2273656c65637465645f746162223b693a343b733a373a2261646d696e6964223b693a313b733a383a22757365726e616d65223b733a31303a22696e6e65727370616365223b733a393a2269735f6c6f67676564223b623a313b733a363a227265666e756d223b733a363a2241444d303031223b733a343a226e616d65223b733a303a22223b733a353a22656d61696c223b733a31363a2274657374406578616d706c652e636f6d223b733a343a2274797065223b733a353a226f776e6572223b7d756c4e6f6e6365737c613a303a7b7d, '2014-08-21T15:19:16+00:00', '1014-08-21T14:55:16+00:00'),
('0mvh2mfs77vue21b469upi2s03', 0x737365737c613a343a7b733a393a22495061646472657373223b733a303a22223b733a31303a22686f7374446f6d61696e223b733a303a22223b733a393a22757365724167656e74223b733a3130323a224d6f7a696c6c612f352e30202857696e646f7773204e5420362e3129204170706c655765624b69742f3533372e333620284b48544d4c2c206c696b65204765636b6f29204368726f6d652f33372e302e323036322e313230205361666172692f3533372e3336223b733a373a2245585049524553223b693a313431313630393134323b7d61646d696e7c613a313a7b733a31323a2273656c65637465645f746162223b693a393b7d756c4e6f6e6365737c613a313a7b733a353a226c6f67696e223b613a323a7b733a343a22636f6465223b733a36343a2265656463306666383138663864643538613635663037643561353263366631666532306463373839366661303534333534343437343933626531623134326137223b733a363a22657870697265223b733a32353a22323031342d30392d32355430303a35343a30322b30303a3030223b7d7d, '2014-09-25T01:03:02+00:00', '1014-09-25T00:39:02+00:00'),
('10pr82obhlf5n71h2rpv309da5', 0x737365737c613a343a7b733a393a22495061646472657373223b733a303a22223b733a31303a22686f7374446f6d61696e223b733a303a22223b733a393a22757365724167656e74223b733a37323a224d6f7a696c6c612f352e30202857696e646f7773204e5420362e313b20574f5736343b2072763a32392e3029204765636b6f2f32303130303130312046697265666f782f32392e30223b733a373a2245585049524553223b693a313430313337353935303b7d61646d696e7c613a313a7b733a31323a2273656c65637465645f746162223b693a393b7d756c4e6f6e6365737c613a313a7b733a353a226c6f67696e223b613a323a7b733a343a22636f6465223b733a36343a2262326665386362326137323437633732303663386134303534636666643034623666376538366564326233353538393830373738396666636164636633366261223b733a363a22657870697265223b733a32353a22323031342d30352d32395431343a32303a35302b30303a3030223b7d7d, '2014-05-29T14:29:50+00:00', '1014-05-29T14:05:50+00:00'),
('5h3bgtq8rl7gf3lmrjdghmelb0', 0x737365737c613a343a7b733a393a22495061646472657373223b733a303a22223b733a31303a22686f7374446f6d61696e223b733a303a22223b733a393a22757365724167656e74223b733a3130323a224d6f7a696c6c612f352e30202857696e646f7773204e5420362e3129204170706c655765624b69742f3533372e333620284b48544d4c2c206c696b65204765636b6f29204368726f6d652f33372e302e323036322e313234205361666172692f3533372e3336223b733a373a2245585049524553223b693a313431323331323437343b7d61646d696e7c613a383a7b733a31323a2273656c65637465645f746162223b693a393b733a373a2261646d696e6964223b693a313b733a383a22757365726e616d65223b733a31303a22696e6e65727370616365223b733a393a2269735f6c6f67676564223b623a313b733a363a227265666e756d223b733a363a2241444d303031223b733a343a226e616d65223b733a303a22223b733a353a22656d61696c223b733a31363a2274657374406578616d706c652e636f6d223b733a343a2274797065223b733a353a226f776e6572223b7d756c4e6f6e6365737c613a303a7b7d, '2014-10-03T04:25:14+00:00', '1014-10-03T04:01:14+00:00'),
('a3sfes47ml9oooie6s6f6vipf4', 0x737365737c613a343a7b733a393a22495061646472657373223b733a303a22223b733a31303a22686f7374446f6d61696e223b733a303a22223b733a393a22757365724167656e74223b733a3130323a224d6f7a696c6c612f352e30202857696e646f7773204e5420362e3129204170706c655765624b69742f3533372e333620284b48544d4c2c206c696b65204765636b6f29204368726f6d652f33342e302e313834372e313337205361666172692f3533372e3336223b733a373a2245585049524553223b693a313430313933373633333b7d61646d696e7c613a383a7b733a31323a2273656c65637465645f746162223b693a343b733a373a2261646d696e6964223b693a313b733a383a22757365726e616d65223b733a31303a22696e6e65727370616365223b733a393a2269735f6c6f67676564223b623a313b733a363a227265666e756d223b733a363a2241444d303031223b733a343a226e616d65223b733a303a22223b733a353a22656d61696c223b733a31363a2274657374406578616d706c652e636f6d223b733a343a2274797065223b733a353a226f776e6572223b7d756c4e6f6e6365737c613a303a7b7d, '2014-06-05T02:31:13+00:00', '1014-06-05T02:07:13+00:00'),
('af00egpljtdf430s6mqr1ajnh7', 0x737365737c613a343a7b733a393a22495061646472657373223b733a303a22223b733a31303a22686f7374446f6d61696e223b733a303a22223b733a393a22757365724167656e74223b733a36353a224d6f7a696c6c612f352e30202857696e646f7773204e5420362e313b2072763a32372e3029204765636b6f2f32303130303130312046697265666f782f32372e30223b733a373a2245585049524553223b693a313339393239333835363b7d756c4e6f6e6365737c613a313a7b733a31343a22756c53657373696f6e546f6b656e223b613a323a7b733a343a22636f6465223b733a36343a2232373562366366646465653838323439633339376234366364656530616438663035336235626564653563353631306264336564656336663264636564656338223b733a363a22657870697265223b733a32353a22323031342d30352d30355431323a34343a31362b30303a3030223b7d7d61646d696e7c613a383a7b733a31323a2273656c65637465645f746162223b693a303b733a373a2261646d696e6964223b693a313b733a383a22757365726e616d65223b733a31303a22696e6e65727370616365223b733a393a2269735f6c6f67676564223b623a313b733a363a227265666e756d223b733a363a2241444d303031223b733a343a226e616d65223b733a303a22223b733a353a22656d61696c223b733a31363a2274657374406578616d706c652e636f6d223b733a343a2274797065223b733a353a226f776e6572223b7d, '2014-05-05T12:08:16+00:00', '1014-05-05T11:44:16+00:00'),
('an9jsh5cdsjq0ccoj0c8a5pp84', 0x737365737c613a343a7b733a393a22495061646472657373223b733a303a22223b733a31303a22686f7374446f6d61696e223b733a303a22223b733a393a22757365724167656e74223b733a3130323a224d6f7a696c6c612f352e30202857696e646f7773204e5420362e3129204170706c655765624b69742f3533372e333620284b48544d4c2c206c696b65204765636b6f29204368726f6d652f33372e302e323036322e313230205361666172692f3533372e3336223b733a373a2245585049524553223b693a313431303533323533373b7d756c4e6f6e6365737c613a303a7b7d61646d696e7c613a383a7b733a31323a2273656c65637465645f746162223b693a343b733a373a2261646d696e6964223b693a313b733a383a22757365726e616d65223b733a31303a22696e6e65727370616365223b733a393a2269735f6c6f67676564223b623a313b733a363a227265666e756d223b733a363a2241444d303031223b733a343a226e616d65223b733a303a22223b733a353a22656d61696c223b733a31363a2274657374406578616d706c652e636f6d223b733a343a2274797065223b733a353a226f776e6572223b7d, '2014-09-12T13:59:37+00:00', '1014-09-12T13:35:37+00:00'),
('d2dllbsnor8hkmv4f9coufusl4', 0x737365737c613a343a7b733a393a22495061646472657373223b733a303a22223b733a31303a22686f7374446f6d61696e223b733a303a22223b733a393a22757365724167656e74223b733a3130323a224d6f7a696c6c612f352e30202857696e646f7773204e5420362e3129204170706c655765624b69742f3533372e333620284b48544d4c2c206c696b65204765636b6f29204368726f6d652f33332e302e313735302e313534205361666172692f3533372e3336223b733a373a2245585049524553223b693a313339353832333239383b7d756c4e6f6e6365737c613a313a7b733a31343a22756c53657373696f6e546f6b656e223b613a323a7b733a343a22636f6465223b733a36343a2262316163623135373938636335343563633336613161356237373430643234613863316465323661353463313934333061666264363132336564616632623036223b733a363a22657870697265223b733a32353a22323031342d30332d32365430383a34313a33382b30303a3030223b7d7d, '2014-03-26T08:05:38+00:00', '1014-03-26T07:41:38+00:00'),
('damvsufvv23dpn9pa6kth8rmm5', 0x737365737c613a343a7b733a393a22495061646472657373223b733a303a22223b733a31303a22686f7374446f6d61696e223b733a303a22223b733a393a22757365724167656e74223b733a3130323a224d6f7a696c6c612f352e30202857696e646f7773204e5420362e3129204170706c655765624b69742f3533372e333620284b48544d4c2c206c696b65204765636b6f29204368726f6d652f33362e302e313938352e313433205361666172692f3533372e3336223b733a373a2245585049524553223b693a313430393535383438343b7d61646d696e7c613a383a7b733a31323a2273656c65637465645f746162223b693a303b733a373a2261646d696e6964223b693a313b733a383a22757365726e616d65223b733a31303a22696e6e65727370616365223b733a393a2269735f6c6f67676564223b623a313b733a363a227265666e756d223b733a363a2241444d303031223b733a343a226e616d65223b733a303a22223b733a353a22656d61696c223b733a31363a2274657374406578616d706c652e636f6d223b733a343a2274797065223b733a353a226f776e6572223b7d756c4e6f6e6365737c613a303a7b7d, '2014-09-01T07:25:24+00:00', '1014-09-01T07:01:25+00:00'),
('dhli4jg43gll2g7bof0q5v1a27', 0x737365737c613a343a7b733a393a22495061646472657373223b733a303a22223b733a31303a22686f7374446f6d61696e223b733a303a22223b733a393a22757365724167656e74223b733a3130323a224d6f7a696c6c612f352e30202857696e646f7773204e5420362e3129204170706c655765624b69742f3533372e333620284b48544d4c2c206c696b65204765636b6f29204368726f6d652f33332e302e313735302e313534205361666172692f3533372e3336223b733a373a2245585049524553223b693a313339363332323830343b7d61646d696e7c613a383a7b733a31323a2273656c65637465645f746162223b693a373b733a373a2261646d696e6964223b693a313b733a383a22757365726e616d65223b733a31303a22696e6e65727370616365223b733a393a2269735f6c6f67676564223b623a313b733a363a227265666e756d223b733a363a2241444d303031223b733a343a226e616d65223b733a303a22223b733a353a22656d61696c223b733a31363a2274657374406578616d706c652e636f6d223b733a343a2274797065223b733a353a226f776e6572223b7d756c4e6f6e6365737c613a303a7b7d, '2014-04-01T02:50:44+00:00', '1014-04-01T02:26:44+00:00'),
('iojk42bsr2s65mig4266setfn3', 0x737365737c613a343a7b733a393a22495061646472657373223b733a303a22223b733a31303a22686f7374446f6d61696e223b733a303a22223b733a393a22757365724167656e74223b733a37323a224d6f7a696c6c612f352e30202857696e646f7773204e5420362e313b20574f5736343b2072763a32382e3029204765636b6f2f32303130303130312046697265666f782f32382e30223b733a373a2245585049524553223b693a313339363235313934353b7d756c4e6f6e6365737c613a323a7b733a31343a22756c53657373696f6e546f6b656e223b613a323a7b733a343a22636f6465223b733a36343a2230626432386264376266613162626339353032306162663463383733313636346637333461316335373262623963343266343365633039353062373836356466223b733a363a22657870697265223b733a32353a22323031342d30332d33315430373a34353a34352b30303a3030223b7d733a353a226c6f67696e223b613a323a7b733a343a22636f6465223b733a36343a2238336137366362653639383739356131306130363436366566323936613937373236663765663164633362323366656639396531626363666566383639326336223b733a363a22657870697265223b733a32353a22323031342d30332d33315430373a30303a34352b30303a3030223b7d7d61646d696e7c613a313a7b733a31323a2273656c65637465645f746162223b693a393b7d, '2014-03-31T07:09:45+00:00', '1014-03-31T06:45:45+00:00'),
('lep9qr0dqarv5mluk99if87lr3', 0x737365737c613a343a7b733a393a22495061646472657373223b733a303a22223b733a31303a22686f7374446f6d61696e223b733a303a22223b733a393a22757365724167656e74223b733a3130323a224d6f7a696c6c612f352e30202857696e646f7773204e5420362e3129204170706c655765624b69742f3533372e333620284b48544d4c2c206c696b65204765636b6f29204368726f6d652f33332e302e313735302e313534205361666172692f3533372e3336223b733a373a2245585049524553223b693a313339353831343839383b7d756c4e6f6e6365737c613a313a7b733a31343a22756c53657373696f6e546f6b656e223b613a323a7b733a343a22636f6465223b733a36343a2236353964636137343135346363303665353064306234393939613337633063616561306536303361623065303338316238656133663839313566326462656261223b733a363a22657870697265223b733a32353a22323031342d30332d32365430363a32313a33382b30303a3030223b7d7d61646d696e7c613a383a7b733a31323a2273656c65637465645f746162223b693a303b733a373a2261646d696e6964223b693a313b733a383a22757365726e616d65223b733a31303a22696e6e65727370616365223b733a393a2269735f6c6f67676564223b623a313b733a363a227265666e756d223b733a363a2241444d303031223b733a343a226e616d65223b733a303a22223b733a353a22656d61696c223b733a31363a2274657374406578616d706c652e636f6d223b733a343a2274797065223b733a353a226f776e6572223b7d, '2014-03-26T05:45:38+00:00', '1014-03-26T05:21:38+00:00'),
('mbst14e966i5ne2nsfqs1n1ks3', 0x737365737c613a343a7b733a393a22495061646472657373223b733a303a22223b733a31303a22686f7374446f6d61696e223b733a303a22223b733a393a22757365724167656e74223b733a37323a224d6f7a696c6c612f352e30202857696e646f7773204e5420362e313b20574f5736343b2072763a32392e3029204765636b6f2f32303130303130312046697265666f782f32392e30223b733a373a2245585049524553223b693a313430303538343137353b7d61646d696e7c613a383a7b733a31323a2273656c65637465645f746162223b693a303b733a373a2261646d696e6964223b693a313b733a383a22757365726e616d65223b733a31303a22696e6e65727370616365223b733a393a2269735f6c6f67676564223b623a313b733a363a227265666e756d223b733a363a2241444d303031223b733a343a226e616d65223b733a303a22223b733a353a22656d61696c223b733a31363a2274657374406578616d706c652e636f6d223b733a343a2274797065223b733a353a226f776e6572223b7d756c4e6f6e6365737c613a303a7b7d, '2014-05-20T10:33:35+00:00', '1014-05-20T10:09:35+00:00'),
('tovn3nhh01c0s02bvi8q740050', 0x737365737c613a343a7b733a393a22495061646472657373223b733a303a22223b733a31303a22686f7374446f6d61696e223b733a303a22223b733a393a22757365724167656e74223b733a37323a224d6f7a696c6c612f352e30202857696e646f7773204e5420362e313b20574f5736343b2072763a32392e3029204765636b6f2f32303130303130312046697265666f782f32392e30223b733a373a2245585049524553223b693a313430313131313736343b7d61646d696e7c613a313a7b733a31323a2273656c65637465645f746162223b693a393b7d756c4e6f6e6365737c613a313a7b733a353a226c6f67696e223b613a323a7b733a343a22636f6465223b733a36343a2235316663366432336634633138613232616532633734353566356438376437653462663233643666653065653961363836363033336638616261346439333030223b733a363a22657870697265223b733a32353a22323031342d30352d32365431323a35373a34342b30303a3030223b7d7d, '2014-05-26T13:06:44+00:00', '1014-05-26T12:42:44+00:00'),
('vdc0f6ougt0as8r0cdusuub6j0', 0x737365737c613a343a7b733a393a22495061646472657373223b733a303a22223b733a31303a22686f7374446f6d61696e223b733a303a22223b733a393a22757365724167656e74223b733a37323a224d6f7a696c6c612f352e30202857696e646f7773204e5420362e313b20574f5736343b2072763a32382e3029204765636b6f2f32303130303130312046697265666f782f32382e30223b733a373a2245585049524553223b693a313339353635373537343b7d756c4e6f6e6365737c613a323a7b733a31343a22756c53657373696f6e546f6b656e223b613a323a7b733a343a22636f6465223b733a36343a2266376630653032633661613434316131393236363361363938666361356662346637316538376539386366383935643461353464323730363736666530656530223b733a363a22657870697265223b733a32353a22323031342d30332d32345431303a33393a33342b30303a3030223b7d733a353a226c6f67696e223b613a323a7b733a343a22636f6465223b733a36343a2237666134303632326565306339376334396363663339633937313038643462623065363834313133653432346238343263613963613137663435363634313037223b733a363a22657870697265223b733a32353a22323031342d30332d32345430393a35343a33342b30303a3030223b7d7d61646d696e7c613a313a7b733a31323a2273656c65637465645f746162223b693a393b7d, '2014-03-24T10:03:34+00:00', '1014-03-24T09:39:34+00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `users_id` int(11) NOT NULL,
  `user_uid` varchar(32) DEFAULT '',
  `user_ref` varbinary(8) DEFAULT NULL,
  `user_fullref` varbinary(100) DEFAULT NULL,
  `user_account_num` bigint(20) NOT NULL DEFAULT '0',
  `user_username` varchar(32) DEFAULT NULL,
  `user_password` varbinary(32) DEFAULT NULL,
  `user_status` tinyint(3) NOT NULL DEFAULT '0',
  `user_title` tinyint(3) NOT NULL DEFAULT '0',
  `user_firstname` varbinary(100) DEFAULT NULL,
  `user_middlename` varbinary(100) DEFAULT NULL,
  `user_lastname` varbinary(100) DEFAULT NULL,
  `user_account_name` varchar(255) DEFAULT NULL,
  `user_email` varbinary(100) DEFAULT NULL,
  `user_phone` varbinary(100) DEFAULT NULL,
  `user_fax` varbinary(100) DEFAULT NULL,
  `user_email2` varbinary(100) DEFAULT NULL,
  `user_company` varchar(255) DEFAULT NULL,
  `user_mailing_address` text,
  `user_postal` varbinary(100) DEFAULT NULL,
  `user_city` varbinary(100) DEFAULT NULL,
  `user_state` varbinary(100) DEFAULT NULL,
  `user_country` varbinary(100) DEFAULT NULL,
  `user_web` varchar(255) DEFAULT NULL,
  `user_app_date` date NOT NULL DEFAULT '0000-00-00',
  `user_bank_online` tinyint(3) NOT NULL DEFAULT '0',
  `user_bank_beneficiary` varbinary(100) DEFAULT NULL,
  `user_bank_address` text,
  `user_bank_account` varbinary(100) DEFAULT NULL,
  `user_bank_name` varchar(255) DEFAULT NULL,
  `user_bank_codetype` tinyint(3) NOT NULL DEFAULT '0',
  `user_bank_code` varbinary(100) DEFAULT NULL,
  `user_bank_moredetails` text,
  `user_notes` text,
  `user_advisor1` int(11) NOT NULL DEFAULT '0',
  `user_advisor2` int(11) NOT NULL DEFAULT '0',
  `user_trades` int(11) NOT NULL DEFAULT '0',
  `user_loginscount` int(11) NOT NULL DEFAULT '0',
  `user_lastupdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_lscp` float(11,3) NOT NULL DEFAULT '0.000',
  `user_hpsp` float(11,3) NOT NULL DEFAULT '0.000',
  `user_balance` float(16,2) NOT NULL DEFAULT '0.00',
  `trading_type` tinyint(1) NOT NULL DEFAULT '0',
  `user_lastlogin` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_passisset` tinyint(3) NOT NULL DEFAULT '0',
  `user_secret_question` text,
  `user_secret_answer` varchar(255) DEFAULT NULL,
  `user_lastloginip` varchar(15) DEFAULT '000.000.000.000'
) ENGINE=MyISAM AUTO_INCREMENT=98 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`users_id`, `user_uid`, `user_ref`, `user_fullref`, `user_account_num`, `user_username`, `user_password`, `user_status`, `user_title`, `user_firstname`, `user_middlename`, `user_lastname`, `user_account_name`, `user_email`, `user_phone`, `user_fax`, `user_email2`, `user_company`, `user_mailing_address`, `user_postal`, `user_city`, `user_state`, `user_country`, `user_web`, `user_app_date`, `user_bank_online`, `user_bank_beneficiary`, `user_bank_address`, `user_bank_account`, `user_bank_name`, `user_bank_codetype`, `user_bank_code`, `user_bank_moredetails`, `user_notes`, `user_advisor1`, `user_advisor2`, `user_trades`, `user_loginscount`, `user_lastupdate`, `user_lscp`, `user_hpsp`, `user_balance`, `trading_type`, `user_lastlogin`, `user_passisset`, `user_secret_question`, `user_secret_answer`, `user_lastloginip`) VALUES
(1, '0C58405DBDD86818DCB05F3C8E8FACD1', 0x41444d303031, 0x41444d3030312d3131323230383430373633, 11220840763, 'ttest', 0x313233343536, 1, 1, 0x546f6d6d79, 0x7467, 0x546573747a, 'Tommy Test', 0x6d6f6e65797472656e647940676d61696c2e636f6d, 0x313132333431323334323334, 0x736466736466, '', '', '45st st.', 0x34323533, 0x4e6577636173746c65, 0x4e5357, 0x4d6f7a616d6269717565, '', '2010-01-07', 0, 0x42656e6e79, '1 bank lane', 0x3034303439333032393439, 'Barklays', 1, '', '', ' ', 1, 0, 28, 251, '2014-04-01 11:18:59', 0.000, 0.000, -24730.10, 3, '2015-12-02 15:39:06', 1, 'How can I change?', 'Now you', '127.0.0.1'),
(81, '4037D142E8AB34FA0C46C81E8551E3CF', 0x41443033, 0x414430332d3137373630303438333638, 17760048368, 'gvanas', 0x737a317876626e3132, 1, 1, 0x4765727420, '', 0x56616e204173, 'Gert Van As', 0x67657274766140616373652e636f2e6e7a, 0x36343932373735383030, '', '', '', 'No.14 Gloaming Place', 0x32313132, 0x54616b616e696e692c20506170616b757261, 0x4175636b6c616e64, 0x4e6577205a65616c616e64, '', '2015-01-29', 0, '', '', '', '', 1, '', '', '', 9, 0, 1, 9, '2015-02-06 08:54:47', 0.000, 0.000, 0.00, 3, '2015-02-19 12:11:51', 1, 'regular password', 'existing pasword', '183.89.186.71'),
(88, '01A6A3224C53BB6CA7EE1D570892F209', 0x41443033, 0x414430332d3137383338373135353239, 17838715529, 'ireynolds', 0x4c6176657264613333, 1, 1, 0x4961696e, 0x4b65697468, 0x5265796e6f6c6473, 'Iain K. Reynolds', 0x6961696e407265796e6f6c64736d61696c2e636f6d2e6175, 0x2b3631323636383032373532, '', '', '', '100A Lillington Road', 0x43563332364c57, 0x4c65616d696e67746f6e20537061, 0x5761727769636b7368697265, 0x556e69746564204b696e67646f6d, '', '2015-02-20', 0, '', '', '', '', 1, '', '', '', 4, 0, 2, 6, '2015-03-18 14:11:27', 0.000, 0.000, -29743.88, 3, '2015-03-14 00:37:38', 1, 'Fave Motor Cycle ', 'Laverda', '119.73.137.170'),
(83, 'D5B1A9581A9D4DCBA00D42531D4BFF64', 0x41443033, 0x414430332d3137373734393334363832, 17774934682, 'wmaxwell', 0x776573346d6178, 1, 1, 0x5765736c6579, 0x53746576656e736f6e, 0x4d617877656c6c, 'Wesley S. Maxwell', 0x6d6178726164736869656c6440626967706f6e642e636f6d, 0x2b3631373332383736373930, '', '', '', 'No. 220 West mt Cotton', 0x34313330, 0x436f726e75626961, 0x517565656e736c616e64, 0x4175737472616c6961, '', '2015-02-02', 0, '', '', '', '', 1, '', '', '', 9, 0, 2, 3, '2015-02-27 16:18:23', 0.000, 0.000, 0.00, 3, '2015-02-02 17:00:26', 1, 'anderson', 'martha', '203.45.43.131'),
(84, 'E49EA348978396B4B53C9F6BB88250AE', 0x41443033, 0x414430332d3137373831393830393636, 17781980966, 'acarter', 0x49646f31393639787463, 1, 1, 0x416e74686f6e79, '', 0x436172746572, 'Anthony Carter', 0x696e666f4067656172746f727175652e636f6d2e6175, 0x2b3631373338303832303230, '', '', '', 'No1/3405 Highway Place', 0x34313237, 0x536c61636b7320437265656b, 0x517565656e736c616e64, 0x4175737472616c6961, '', '2015-02-04', 0, '', '', '', '', 1, '', '', '', 4, 0, 1, 4, '2015-02-19 12:30:55', 0.000, 0.000, 0.00, 3, '2015-02-09 11:59:43', 1, 'name of dog', 'scoobydoo', '149.135.10.223'),
(86, 'A2A296B3E806B7A55F8291BC35439485', 0x41443033, 0x414430332d3137383039363837333732, 17809687372, 'bgeisker', 0x666f696c30313031, 1, 1, 0x42656e, '', 0x476569736b6572, 'Ben Geisker', 0x62656e40626b6867726f75702e636f6d2e6175, 0x3631323936373133303731, '', '', '', 'No.185 Peninsular Road', 0x32323332, 0x477261797320506f696e74, 0x4e5357, 0x4175737472616c6961, '', '2015-02-12', 0, '', '', '', '', 1, '', '', '', 8, 0, 1, 4, '2015-02-19 12:35:56', 0.000, 0.000, 0.00, 3, '2015-03-10 17:01:29', 1, 'mothers maiden name', 'love', '203.45.153.218'),
(97, '15A67A55200B8E3D45ED4E873F2E108C', 0x41443033, 0x414430332d3137393632313739303133, 17962179013, 'mbenson', 0x4d69636b6565623732, 1, 1, 0x4d69636861656c, '', 0x42656e736f6e, 'Michael Benson', 0x6d696b6540676c796e2e636f2e6e7a, 0x36343934313539313530, '', '', '', 'No.11/14 Airborne Road', 0x30363332, 0x416c62616e79, 0x4175636b6c616e64, 0x4e6577205a65616c616e64, '', '2015-03-27', 0, '', '', '', '', 1, '', '', '', 20, 0, 2, 3, '2015-03-31 16:04:28', 0.000, 0.000, 0.00, 3, '2015-03-30 10:00:58', 1, 'Dogs name', 'Gemma', '210.86.28.252'),
(90, '5378F1DF324CCEF704BC67242C38A83C', 0x41443033, 0x414430332d3137383833393837343933, 17883987493, 'gmckechnie', 0x6d636b3266657432, 1, 1, 0x476572616c64, '', 0x4d634b6563686e6965, 'Gerald McKechnie', 0x6e737640626967706f6e642e6e65742e6175, 0x2b3631333935363931353738, '', '', '', 'No. 27 Gilsland Road', 0x33313633, 0x4d757272756d6265656e61, 0x566963746f726961, 0x4175737472616c6961, '', '2015-03-05', 0, '', '', '', '', 1, '', '', '', 9, 0, 1, 13, '2015-03-11 09:41:38', 0.000, 0.000, 0.00, 3, '2015-03-31 12:40:53', 1, 'Name of 1st Cat', 'Golly', '120.149.24.204'),
(95, '0ED5D36A6F3E1D8684B8BBECCDB88735', 0x41444d303031, 0x41444d3030312d3137393238303632373236, 17928062726, 'rrockwel', 0x78793137723839, 1, 1, 0x526f62657274, 0x4b65697468, 0x526f636b77656c6c, 'Robert K. Rockwell', 0x726b70756d7040696e7465726e6f64652e6f6e2e6e6574, 0x363120373332393835343938, '', '', '', '6 logan court', 0x35343030, 0x436c656172204d6f756e7461696e, 0x514c44, 0x4175737472616c6961, '', '2015-03-17', 0, '', '', '', '', 1, '', '', '', 0, 0, 1, 0, '2015-03-24 13:25:08', 0.000, 0.000, 0.00, 3, '0000-00-00 00:00:00', 0, '', '', '000.000.000.000'),
(96, 'E9063478D3EDF51C758996E73AB08A43', 0x41443033, 0x414430332d3137393535353934343636, 17955594466, 'dpolyanszky', 0x743531667461334e, 1, 1, 0x4465616e, '', 0x506f6c79616e737a6b79, 'Dean Polyanszky', 0x6465616e2e77656c6c696e67746f6e63656e7472616c407370656564797369676e732e636f2e6e7a, 0x36343438303136303330, '', '', '', '24 Forth Place', 0x36303138, 0x506170616b6f776861692c20506f7269727561, 0x57656c6c696e67746f6e, 0x4e6577205a65616c616e64, '', '2015-03-25', 0, '', '', '', '', 1, '', '', '', 9, 0, 1, 5, '2015-03-25 14:54:40', 0.000, 0.000, -5252.00, 3, '2015-11-26 22:16:35', 0, 'Mothers maiden name', 'pullen', '127.0.0.1');

-- --------------------------------------------------------

--
-- Структура таблицы `users_admins`
--

CREATE TABLE IF NOT EXISTS `users_admins` (
  `admins_id` int(11) NOT NULL,
  `adm_username` varchar(32) DEFAULT NULL,
  `adm_password` varbinary(100) NOT NULL DEFAULT 'invalid_password',
  `adm_ref` varchar(10) DEFAULT NULL,
  `adm_name` varchar(255) DEFAULT NULL,
  `adm_email` varchar(128) DEFAULT NULL,
  `adm_contacts` text,
  `adm_last_login` datetime DEFAULT '0000-00-00 00:00:00',
  `adm_notes` text,
  `adm_status` tinyint(3) NOT NULL DEFAULT '0',
  `adm_type` enum('owner','editor') NOT NULL DEFAULT 'owner'
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users_admins`
--

INSERT INTO `users_admins` (`admins_id`, `adm_username`, `adm_password`, `adm_ref`, `adm_name`, `adm_email`, `adm_contacts`, `adm_last_login`, `adm_notes`, `adm_status`, `adm_type`) VALUES
(1, 'innerspace', 0x3472667662677435, 'ACM00158', 'Root', 'contact@domain.com', '', '2014-03-07 20:55:10', '', 1, 'owner'),
(3, 'admin2', 0x737570657232326b6f69, 'ACM00158', 'Admin 2', 'koi@pond.com', '', '2012-06-29 03:09:56', '', 1, 'owner');

-- --------------------------------------------------------

--
-- Структура таблицы `users_admins_logs`
--

CREATE TABLE IF NOT EXISTS `users_admins_logs` (
  `users_admins_logs_id` int(11) NOT NULL,
  `users_admins_id` int(11) NOT NULL DEFAULT '0',
  `log_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `log_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1 - login, 2 - invalid password, 3 - invalid username and password, 4 - logout',
  `log_ip` varchar(15) NOT NULL DEFAULT '000.000.000.000',
  `log_tryname` varchar(255) DEFAULT NULL,
  `log_trypass` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users_advisors`
--

CREATE TABLE IF NOT EXISTS `users_advisors` (
  `users_advisors_id` int(11) NOT NULL,
  `advisor_ref` varchar(10) DEFAULT NULL,
  `advisor_names` varchar(255) DEFAULT NULL,
  `advisor_firm` varchar(255) DEFAULT NULL,
  `advisor_contacts` varchar(255) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users_advisors`
--

INSERT INTO `users_advisors` (`users_advisors_id`, `advisor_ref`, `advisor_names`, `advisor_firm`, `advisor_contacts`) VALUES
(1, 'AD001', 'John Turner', 'Casper1', 'j.turner@domain.com'),
(2, 'AD002', 'Marcus Fraser', 'Company', 'm.fraser@domain.com'),
(3, 'AD003', 'Brad Huff', 'Company', 'b.huff@domain.com'),
(4, 'SRR001', 'James Wright', 'SRR', 'j.wright@silverridgeresources.com'),
(5, 'SRR002', 'Tony Watson', 'SRR', 't.watson@silverridgeresources.com'),
(6, 'SRR003', 'Joshua Hoffman', 'SRR', 'j.hoffman@silverridgeresources.com'),
(7, 'SRR004', 'Anthony Green', 'SRR', 'a.green@silverridgeresources.com'),
(8, 'SRR005', 'Bob Gorton', 'SRR', 'b.gorton@silverridgeresources.com'),
(9, 'SRR006', 'Edward Silver', 'SRR', 'e.silver@silverridgeresources.com'),
(10, 'SRR007', 'Mike Fields', 'SRR', 'm.fields@silverridgeresources.com'),
(11, 'SRR008', 'Philip Ferguson', 'SRR', 'p.ferguson@silverridgeresources.com'),
(12, 'SRR009', 'Jack Bond', 'SRR', 'j.bond@silverridgeresources.com'),
(13, 'SRR011', 'Ronald Forbes', 'SRR', 'r.forbes@silverridgeresources.com'),
(14, 'SRR014', 'Vincent Taylor', 'SRR', 'v.taylor@silverridgeresources.com'),
(15, 'SRR015', 'David Hampton', 'SRR', 'd.hampton@silverridgeresources.com'),
(16, 'SRR016', 'Laurie Goodwill', 'SRR', 'l.goodwill@silverridgeresources.com'),
(17, 'SRR1L', 'David H. Adam', 'SRR', 'd.adam@silverridgeresources.com'),
(18, 'SRR2L', 'Michael David Ryan', 'SRR', 'm.ryan@silverridgeresources.com'),
(19, 'SSR018', 'Daniel Holbrook', 'SRR', 'd.holbrook@silverridgeresources.com'),
(20, 'SRR019', 'Mathew Hanley', 'SRR', 'm.hanley@silverridgeresources.com');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `banned_ips`
--
ALTER TABLE `banned_ips`
  ADD PRIMARY KEY (`banned_ips_id`);

--
-- Индексы таблицы `commodities`
--
ALTER TABLE `commodities`
  ADD PRIMARY KEY (`commodities_id`), ADD UNIQUE KEY `NewIndex` (`commodities_symbol`);

--
-- Индексы таблицы `commodities_groups`
--
ALTER TABLE `commodities_groups`
  ADD PRIMARY KEY (`commodities_groups_id`);

--
-- Индексы таблицы `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`countries_id`);

--
-- Индексы таблицы `expiry_dates`
--
ALTER TABLE `expiry_dates`
  ADD PRIMARY KEY (`expiry_dates_id`);

--
-- Индексы таблицы `global_settings`
--
ALTER TABLE `global_settings`
  ADD PRIMARY KEY (`global_settings_id`);

--
-- Индексы таблицы `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`logs_id`);

--
-- Индексы таблицы `mail_queue`
--
ALTER TABLE `mail_queue`
  ADD PRIMARY KEY (`mail_queue_id`);

--
-- Индексы таблицы `mail_templates`
--
ALTER TABLE `mail_templates`
  ADD PRIMARY KEY (`mail_templates_id`);

--
-- Индексы таблицы `pdf_templates`
--
ALTER TABLE `pdf_templates`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`stocks_id`), ADD KEY `stocks_symbol` (`stocks_symbol`);

--
-- Индексы таблицы `stock_details`
--
ALTER TABLE `stock_details`
  ADD PRIMARY KEY (`details_id`), ADD KEY `stock_id` (`stocks_id`);

--
-- Индексы таблицы `stock_trades`
--
ALTER TABLE `stock_trades`
  ADD PRIMARY KEY (`trades_id`), ADD KEY `trade_stock` (`stocks_id`);

--
-- Индексы таблицы `stock_watchlist`
--
ALTER TABLE `stock_watchlist`
  ADD PRIMARY KEY (`id`), ADD KEY `user_account_num` (`user_account_num`);

--
-- Индексы таблицы `trades`
--
ALTER TABLE `trades`
  ADD PRIMARY KEY (`trades_id`);

--
-- Индексы таблицы `trades_related`
--
ALTER TABLE `trades_related`
  ADD PRIMARY KEY (`trades_related_id`);

--
-- Индексы таблицы `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`transfers_id`);

--
-- Индексы таблицы `ul_blocked_ips`
--
ALTER TABLE `ul_blocked_ips`
  ADD PRIMARY KEY (`ip`);

--
-- Индексы таблицы `ul_logins`
--
ALTER TABLE `ul_logins`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`(255));

--
-- Индексы таблицы `ul_nonces`
--
ALTER TABLE `ul_nonces`
  ADD PRIMARY KEY (`code`), ADD UNIQUE KEY `action` (`action`(255));

--
-- Индексы таблицы `ul_sessions`
--
ALTER TABLE `ul_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`);

--
-- Индексы таблицы `users_admins`
--
ALTER TABLE `users_admins`
  ADD PRIMARY KEY (`admins_id`), ADD UNIQUE KEY `AdmUsername` (`adm_username`);

--
-- Индексы таблицы `users_admins_logs`
--
ALTER TABLE `users_admins_logs`
  ADD PRIMARY KEY (`users_admins_logs_id`), ADD KEY `AdminsID` (`users_admins_id`);

--
-- Индексы таблицы `users_advisors`
--
ALTER TABLE `users_advisors`
  ADD PRIMARY KEY (`users_advisors_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `banned_ips`
--
ALTER TABLE `banned_ips`
  MODIFY `banned_ips_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `commodities`
--
ALTER TABLE `commodities`
  MODIFY `commodities_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT для таблицы `commodities_groups`
--
ALTER TABLE `commodities_groups`
  MODIFY `commodities_groups_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `countries`
--
ALTER TABLE `countries`
  MODIFY `countries_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=240;
--
-- AUTO_INCREMENT для таблицы `expiry_dates`
--
ALTER TABLE `expiry_dates`
  MODIFY `expiry_dates_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT для таблицы `global_settings`
--
ALTER TABLE `global_settings`
  MODIFY `global_settings_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT для таблицы `logs`
--
ALTER TABLE `logs`
  MODIFY `logs_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=541;
--
-- AUTO_INCREMENT для таблицы `mail_queue`
--
ALTER TABLE `mail_queue`
  MODIFY `mail_queue_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT для таблицы `mail_templates`
--
ALTER TABLE `mail_templates`
  MODIFY `mail_templates_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `pdf_templates`
--
ALTER TABLE `pdf_templates`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `stocks`
--
ALTER TABLE `stocks`
  MODIFY `stocks_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT для таблицы `stock_details`
--
ALTER TABLE `stock_details`
  MODIFY `details_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT для таблицы `stock_watchlist`
--
ALTER TABLE `stock_watchlist`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT для таблицы `trades_related`
--
ALTER TABLE `trades_related`
  MODIFY `trades_related_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT для таблицы `transfers`
--
ALTER TABLE `transfers`
  MODIFY `transfers_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17977042277;
--
-- AUTO_INCREMENT для таблицы `ul_logins`
--
ALTER TABLE `ul_logins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=98;
--
-- AUTO_INCREMENT для таблицы `users_admins`
--
ALTER TABLE `users_admins`
  MODIFY `admins_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `users_admins_logs`
--
ALTER TABLE `users_admins_logs`
  MODIFY `users_admins_logs_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `users_advisors`
--
ALTER TABLE `users_advisors`
  MODIFY `users_advisors_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
