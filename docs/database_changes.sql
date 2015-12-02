-- 04-03-2014 - admin type added
ALTER TABLE `users_admins` ADD `adm_type` ENUM( 'owner', 'editor' ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'owner';

-- 05-03-2014 - pdf templates
CREATE TABLE `pdf_templates` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(100) NOT NULL,
 `slug` varchar(32) NOT NULL,
 `content` text NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=6;

INSERT INTO `pdf_templates` (`id`, `name`, `slug`, `content`) VALUES
(1, 'Account summary', 'account_summary', '<h1>Account summary</h1>\r\n\r\n<table style="width: 100%;">\r\n    <tr>\r\n        <td width="60%">Name: {user_firstname} {user_middlename} {user_lastname}</td>\r\n        <td width="10%" rowspan="6"></td>\r\n        <td width="30%">&nbsp;</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Account Name: {user_account_name}</td>\r\n        <td>Date: {%date%}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Account Number: {user_uid}</td>\r\n        <td>Advisor: {advisor_names}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Address: {user_mailing_address}, {user_city}, {user_state} {user_postal} {user_country}</td>\r\n        <td>Email: {advisor_contacts}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Email: {user_email}</td>\r\n        <td>&nbsp;</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Phone: {user_phone}</td>\r\n        <td>&nbsp;</td>\r\n    </tr>\r\n</table>\r\n\r\n<br />\r\n\r\n<table width="100%" border="1" cellspacing="0" cellpadding="0">\r\n    <tr>\r\n        <th border="0">Account Balance: {user_balance}</th>\r\n    </tr>\r\n</table>'),
(2, 'Stock trade', 'stock_trade', '<h1>Stock trade confirmation</h1>\r\n\r\n<table style="width: 100%;">\r\n    <tr>\r\n        <td width="60%">Name: {user_firstname} {user_middlename} {user_lastname}</td>\r\n        <td width="10%" rowspan="6"></td>\r\n        <td width="30%">&nbsp;</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Account Name: {user_account_name}</td>\r\n        <td>Date: {%date%}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Account Number: {user_uid}</td>\r\n        <td>Advisor: {advisor_names}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Address: {user_mailing_address}, {user_city}, {user_state} {user_postal} {user_country}</td>\r\n        <td>Email: {advisor_contacts}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Email: {user_email}</td>\r\n        <td>&nbsp;</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Phone: {user_phone}</td>\r\n        <td>&nbsp;</td>\r\n    </tr>\r\n</table>\r\n\r\n<br />\r\n\r\n<table width="100%" border="1" cellspacing="0" cellpadding="0">\r\n    <tr>\r\n        <th border="0">Trade Executed: {trade_details}</th>\r\n    </tr>\r\n</table>\r\n\r\n<br />\r\n\r\n<table style="width: 100%;">\r\n    <tr>\r\n        <td width="50%">Trade Date: {trade_date}</td>\r\n        <td width="10%" rowspan="4"></td>\r\n        <td width="40%">Trade Price/Share: {trade_price_share}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Trade ID: {trade_ref}</td>\r\n        <td>Trade Shares: {trade_shares}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Type: {trade_type}</td>\r\n        <td>Trade Value: {trade_value}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Fees: {trade_fees}</td>\r\n        <td>Trade Invoiced: <strong>{trade_invoiced}</strong></td>\r\n    </tr>\r\n</table>'),
(3, 'Options trade', 'options_trade', '<h1>Options trade confirmation</h1>\r\n\r\n<table style="width: 100%;">\r\n    <tr>\r\n        <td width="60%">Name: {user_firstname} {user_middlename} {user_lastname}</td>\r\n        <td width="10%" rowspan="6"></td>\r\n        <td width="30%">&nbsp;</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Account Name: {user_account_name}</td>\r\n        <td>Date: {%date%}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Account Number: {user_uid}</td>\r\n        <td>Advisor: {advisor_names}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Address: {user_mailing_address}, {user_city}, {user_state} {user_postal} {user_country}</td>\r\n        <td>Email: {advisor_contacts}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Email: {user_email}</td>\r\n        <td>&nbsp;</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Phone: {user_phone}</td>\r\n        <td>&nbsp;</td>\r\n    </tr>\r\n</table>\r\n\r\n<br />\r\n\r\n<table width="100%" border="1" cellspacing="0" cellpadding="0">\r\n    <tr>\r\n        <th border="0">Trade Executed: {trade_details}</th>\r\n    </tr>\r\n</table>\r\n\r\n<br />\r\n\r\n<table style="width: 100%;">\r\n    <tr>\r\n        <td width="50%">Trade Date: {trade_date}</td>\r\n        <td width="10%" rowspan="5"></td>\r\n        <td width="40%">Premium: {trade_premium_price}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Trade ID: {trade_ref}</td>\r\n        <td>Contract Size: {trade_contract_size}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Kind: {trade_option}</td>\r\n        <td>Price/Contract: {trade_price_contract}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Fees: {trade_fees}</td>\r\n        <td>Trade value: {trade_value}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Strike Price: {trade_strikeprice}</td>\r\n        <td>Total Invoiced: {trade_invoiced}</td>\r\n    </tr>\r\n</table>'),
(4, 'Transfer (deposit)', 'transfer_deposit', '<h1>Deposit confirmation</h1>\r\n\r\n<table style="width: 100%;">\r\n    <tr>\r\n        <td width="60%">Name: {user_firstname} {user_middlename} {user_lastname}</td>\r\n        <td width="10%" rowspan="6"></td>\r\n        <td width="30%">&nbsp;</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Account Name: {user_account_name}</td>\r\n        <td>Date: {%date%}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Account Number: {user_uid}</td>\r\n        <td>Advisor: {advisor_names}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Address: {user_mailing_address}, {user_city}, {user_state} {user_postal} {user_country}</td>\r\n        <td>Email: {advisor_contacts}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Email: {user_email}</td>\r\n        <td>&nbsp;</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Phone: {user_phone}</td>\r\n        <td>&nbsp;</td>\r\n    </tr>\r\n</table>\r\n\r\n<br />\r\n\r\n<table width="100%" border="1" cellspacing="0" cellpadding="0">\r\n    <tr>\r\n        <th border="0">Transfer Type: {tr_type}</th>\r\n    </tr>\r\n</table>\r\n\r\n<br />\r\n\r\n<table style="width: 100%;">\r\n    <tr>\r\n        <td width="50%">Transfer date: {tr_date}</td>\r\n        <td width="10%" rowspan="3"></td>\r\n        <td width="40%">Deposit: ${tr_value}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Transfer ID: {tr_ref}</td>\r\n        <td>Fees: ${tr_fees}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>&nbsp;</td>\r\n        <td>Total deposit: ${tr_total}</td>\r\n    </tr>\r\n</table>'),
(5, 'Transfer (withdraw)', 'transfer_withdraw', '<h1>Withdraw confirmation</h1>\r\n\r\n<table style="width: 100%;">\r\n    <tr>\r\n        <td width="60%">Name: {user_firstname} {user_middlename} {user_lastname}</td>\r\n        <td width="10%" rowspan="6"></td>\r\n        <td width="30%">&nbsp;</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Account Name: {user_account_name}</td>\r\n        <td>Date: {%date%}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Account Number: {user_uid}</td>\r\n        <td>Advisor: {advisor_names}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Address: {user_mailing_address}, {user_city}, {user_state} {user_postal} {user_country}</td>\r\n        <td>Email: {advisor_contacts}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Email: {user_email}</td>\r\n        <td>&nbsp;</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Phone: {user_phone}</td>\r\n        <td>&nbsp;</td>\r\n    </tr>\r\n</table>\r\n\r\n<br />\r\n\r\n<table width="100%" border="1" cellspacing="0" cellpadding="0">\r\n    <tr>\r\n        <th border="0">Transfer Type: {tr_type}</th>\r\n    </tr>\r\n</table>\r\n\r\n<br />\r\n\r\n<table style="width: 100%;">\r\n    <tr>\r\n        <td width="50%">Transfer date: {tr_date}</td>\r\n        <td width="10%" rowspan="3"></td>\r\n        <td width="40%">Withdraw: ${tr_value}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Transfer ID: {tr_ref}</td>\r\n        <td>Fees: ${tr_fees}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>&nbsp;</td>\r\n        <td>Total withdraw: ${tr_total}</td>\r\n    </tr>\r\n</table>\r\n\r\n<h2>Bank Details</h2>\r\n\r\n<table style="width: 100%;">\r\n    <tr>\r\n        <td>Beneficiary: {tr_bank_beneficiary}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Bank Address: {tr_bank_address}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Bank Account: {tr_bank_account}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Bank Name: {tr_bank_name}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>{tr_bank_codetype}: {tr_bank_code}</td>\r\n    </tr>\r\n    <tr>\r\n        <td>More Bank Details: {tr_bank_moredetails}</td>\r\n    </tr>\r\n</table>');

-- 10-03-2014 - uLogin
CREATE TABLE IF NOT EXISTS `ul_blocked_ips` (
  `ip` varchar(39) CHARACTER SET ascii NOT NULL,
  `block_expires` varchar(26) CHARACTER SET ascii NOT NULL,
  PRIMARY KEY (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ul_log` (
  `timestamp` varchar(26) CHARACTER SET ascii NOT NULL,
  `action` varchar(20) CHARACTER SET ascii NOT NULL,
  `comment` varchar(255) CHARACTER SET ascii NOT NULL DEFAULT '',
  `user` varchar(400) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(39) CHARACTER SET ascii NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ul_logins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `block_expires` varchar(26) CHARACTER SET ascii NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`(255))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `ul_logins` (`id`, `username`, `password`, `ref`, `name`, `email`, `contacts`, `notes`, `type`, `date_created`, `last_login`, `block_expires`) VALUES
(1, 'innerspace', '$2a$11$Vyzjxhr.91p4WGir5le2S.Lxyhjn5ETHgrKfdIZwcRRTVETgn926K', 'ADM001', '', 'test@example.com', '', '', 'owner', '2014-03-07T15:52:58+01:00', '2014-03-10T11:01:03+01:00', '2014-03-09T10:41:57+01:00');

CREATE TABLE IF NOT EXISTS `ul_nonces` (
  `code` varchar(100) CHARACTER SET ascii NOT NULL,
  `action` varchar(850) CHARACTER SET ascii NOT NULL,
  `nonce_expires` varchar(26) CHARACTER SET ascii NOT NULL,
  PRIMARY KEY (`code`),
  UNIQUE KEY `action` (`action`(255))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ul_sessions` (
  `id` varchar(128) CHARACTER SET ascii NOT NULL DEFAULT '',
  `data` blob NOT NULL,
  `session_expires` varchar(26) CHARACTER SET ascii NOT NULL,
  `lock_expires` varchar(26) CHARACTER SET ascii NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;