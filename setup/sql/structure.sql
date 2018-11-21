-- ================================================================
--
-- @version $Id: structure.sql 2016-09-01 11:12:05 gewa $
-- @package Membership Manager Pro Pro
-- @copyright 2016. wojoscripts.com
--
-- ================================================================
-- Database structure
-- ================================================================

--
-- Table structure for table `banlist`
--

DROP TABLE IF EXISTS `banlist`;
CREATE TABLE IF NOT EXISTS `banlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('IP','Email') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'IP',
  `comment` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ban_ip` (`item`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `uid` int(11) unsigned NOT NULL DEFAULT '0',
  `mid` int(11) unsigned NOT NULL DEFAULT '0',
  `cid` int(11) unsigned NOT NULL DEFAULT '0',
  `tax` decimal(13,2) unsigned NOT NULL DEFAULT '0.00',
  `totaltax` decimal(13,2) unsigned NOT NULL DEFAULT '0.00',
  `coupon` decimal(13,2) unsigned NOT NULL DEFAULT '0.00',
  `total` decimal(13,2) unsigned NOT NULL DEFAULT '0.00',
  `originalprice` decimal(13,2) unsigned NOT NULL DEFAULT '0.00',
  `totalprice` decimal(13,2) unsigned NOT NULL DEFAULT '0.00',
  `cart_id` varchar(100) DEFAULT NULL,
  `order_id` varchar(100) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`),
  KEY `idx_user` (`uid`),
  KEY `idx_membership` (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `abbr` varchar(2) NOT NULL,
  `name` varchar(70) NOT NULL,
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `home` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `vat` decimal(13,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `sorting` smallint(6) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `abbrv` (`abbr`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `abbr`, `name`, `active`, `home`, `vat`, `sorting`) VALUES
(1, 'AF', 'Afghanistan', 1, 0, '0.00', 0),
(2, 'AL', 'Albania', 1, 0, '0.00', 0),
(3, 'DZ', 'Algeria', 1, 0, '0.00', 0),
(4, 'AS', 'American Samoa', 1, 0, '0.00', 0),
(5, 'AD', 'Andorra', 1, 0, '0.00', 0),
(6, 'AO', 'Angola', 1, 0, '0.00', 0),
(7, 'AI', 'Anguilla', 1, 0, '0.00', 0),
(8, 'AQ', 'Antarctica', 1, 0, '0.00', 0),
(9, 'AG', 'Antigua and Barbuda', 1, 0, '0.00', 0),
(10, 'AR', 'Argentina', 1, 0, '0.00', 0),
(11, 'AM', 'Armenia', 1, 0, '0.00', 0),
(12, 'AW', 'Aruba', 1, 0, '0.00', 0),
(13, 'AU', 'Australia', 1, 0, '0.00', 0),
(14, 'AT', 'Austria', 1, 0, '0.00', 0),
(15, 'AZ', 'Azerbaijan', 1, 0, '0.00', 0),
(16, 'BS', 'Bahamas', 1, 0, '0.00', 0),
(17, 'BH', 'Bahrain', 1, 0, '0.00', 0),
(18, 'BD', 'Bangladesh', 1, 0, '0.00', 0),
(19, 'BB', 'Barbados', 1, 0, '0.00', 0),
(20, 'BY', 'Belarus', 1, 0, '0.00', 0),
(21, 'BE', 'Belgium', 1, 0, '0.00', 0),
(22, 'BZ', 'Belize', 1, 0, '0.00', 0),
(23, 'BJ', 'Benin', 1, 0, '0.00', 0),
(24, 'BM', 'Bermuda', 1, 0, '0.00', 0),
(25, 'BT', 'Bhutan', 1, 0, '0.00', 0),
(26, 'BO', 'Bolivia', 1, 0, '0.00', 0),
(27, 'BA', 'Bosnia and Herzegowina', 1, 0, '0.00', 0),
(28, 'BW', 'Botswana', 1, 0, '0.00', 0),
(29, 'BV', 'Bouvet Island', 1, 0, '0.00', 0),
(30, 'BR', 'Brazil', 1, 0, '0.00', 0),
(31, 'IO', 'British Indian Ocean Territory', 1, 0, '0.00', 0),
(32, 'VG', 'British Virgin Islands', 1, 0, '0.00', 0),
(33, 'BN', 'Brunei Darussalam', 1, 0, '0.00', 0),
(34, 'BG', 'Bulgaria', 1, 0, '0.00', 0),
(35, 'BF', 'Burkina Faso', 1, 0, '0.00', 0),
(36, 'BI', 'Burundi', 1, 0, '0.00', 0),
(37, 'KH', 'Cambodia', 1, 0, '0.00', 0),
(38, 'CM', 'Cameroon', 1, 0, '0.00', 0),
(39, 'CA', 'Canada', 1, 1, '13.00', 1000),
(40, 'CV', 'Cape Verde', 1, 0, '0.00', 0),
(41, 'KY', 'Cayman Islands', 1, 0, '0.00', 0),
(42, 'CF', 'Central African Republic', 1, 0, '0.00', 0),
(43, 'TD', 'Chad', 1, 0, '0.00', 0),
(44, 'CL', 'Chile', 1, 0, '0.00', 0),
(45, 'CN', 'China', 1, 0, '0.00', 0),
(46, 'CX', 'Christmas Island', 1, 0, '0.00', 0),
(47, 'CC', 'Cocos (Keeling) Islands', 1, 0, '0.00', 0),
(48, 'CO', 'Colombia', 1, 0, '0.00', 0),
(49, 'KM', 'Comoros', 1, 0, '0.00', 0),
(50, 'CG', 'Congo', 1, 0, '0.00', 0),
(51, 'CK', 'Cook Islands', 1, 0, '0.00', 0),
(52, 'CR', 'Costa Rica', 1, 0, '0.00', 0),
(53, 'CI', 'Cote D''ivoire', 1, 0, '0.00', 0),
(54, 'HR', 'Croatia', 1, 0, '0.00', 0),
(55, 'CU', 'Cuba', 1, 0, '0.00', 0),
(56, 'CY', 'Cyprus', 1, 0, '0.00', 0),
(57, 'CZ', 'Czech Republic', 1, 0, '0.00', 0),
(58, 'DK', 'Denmark', 1, 0, '0.00', 0),
(59, 'DJ', 'Djibouti', 1, 0, '0.00', 0),
(60, 'DM', 'Dominica', 1, 0, '0.00', 0),
(61, 'DO', 'Dominican Republic', 1, 0, '0.00', 0),
(62, 'TP', 'East Timor', 1, 0, '0.00', 0),
(63, 'EC', 'Ecuador', 1, 0, '0.00', 0),
(64, 'EG', 'Egypt', 1, 0, '0.00', 0),
(65, 'SV', 'El Salvador', 1, 0, '0.00', 0),
(66, 'GQ', 'Equatorial Guinea', 1, 0, '0.00', 0),
(67, 'ER', 'Eritrea', 1, 0, '0.00', 0),
(68, 'EE', 'Estonia', 1, 0, '0.00', 0),
(69, 'ET', 'Ethiopia', 1, 0, '0.00', 0),
(70, 'FK', 'Falkland Islands (Malvinas)', 1, 0, '0.00', 0),
(71, 'FO', 'Faroe Islands', 1, 0, '0.00', 0),
(72, 'FJ', 'Fiji', 1, 0, '0.00', 0),
(73, 'FI', 'Finland', 1, 0, '0.00', 0),
(74, 'FR', 'France', 1, 0, '0.00', 0),
(75, 'GF', 'French Guiana', 1, 0, '0.00', 0),
(76, 'PF', 'French Polynesia', 1, 0, '0.00', 0),
(77, 'TF', 'French Southern Territories', 1, 0, '0.00', 0),
(78, 'GA', 'Gabon', 1, 0, '0.00', 0),
(79, 'GM', 'Gambia', 1, 0, '0.00', 0),
(80, 'GE', 'Georgia', 1, 0, '0.00', 0),
(81, 'DE', 'Germany', 1, 0, '0.00', 0),
(82, 'GH', 'Ghana', 1, 0, '0.00', 0),
(83, 'GI', 'Gibraltar', 1, 0, '0.00', 0),
(84, 'GR', 'Greece', 1, 0, '0.00', 0),
(85, 'GL', 'Greenland', 1, 0, '0.00', 0),
(86, 'GD', 'Grenada', 1, 0, '0.00', 0),
(87, 'GP', 'Guadeloupe', 1, 0, '0.00', 0),
(88, 'GU', 'Guam', 1, 0, '0.00', 0),
(89, 'GT', 'Guatemala', 1, 0, '0.00', 0),
(90, 'GN', 'Guinea', 1, 0, '0.00', 0),
(91, 'GW', 'Guinea-Bissau', 1, 0, '0.00', 0),
(92, 'GY', 'Guyana', 1, 0, '0.00', 0),
(93, 'HT', 'Haiti', 1, 0, '0.00', 0),
(94, 'HM', 'Heard and McDonald Islands', 1, 0, '0.00', 0),
(95, 'HN', 'Honduras', 1, 0, '0.00', 0),
(96, 'HK', 'Hong Kong', 1, 0, '0.00', 0),
(97, 'HU', 'Hungary', 1, 0, '0.00', 0),
(98, 'IS', 'Iceland', 1, 0, '0.00', 0),
(99, 'IN', 'India', 1, 0, '0.00', 0),
(100, 'ID', 'Indonesia', 1, 0, '0.00', 0),
(101, 'IQ', 'Iraq', 1, 0, '0.00', 0),
(102, 'IE', 'Ireland', 1, 0, '0.00', 0),
(103, 'IR', 'Islamic Republic of Iran', 1, 0, '0.00', 0),
(104, 'IL', 'Israel', 1, 0, '0.00', 0),
(105, 'IT', 'Italy', 1, 0, '0.00', 0),
(106, 'JM', 'Jamaica', 1, 0, '0.00', 0),
(107, 'JP', 'Japan', 1, 0, '0.00', 0),
(108, 'JO', 'Jordan', 1, 0, '0.00', 0),
(109, 'KZ', 'Kazakhstan', 1, 0, '0.00', 0),
(110, 'KE', 'Kenya', 1, 0, '0.00', 0),
(111, 'KI', 'Kiribati', 1, 0, '0.00', 0),
(112, 'KP', 'Korea, Dem. Peoples Rep of', 1, 0, '0.00', 0),
(113, 'KR', 'Korea, Republic of', 1, 0, '0.00', 0),
(114, 'KW', 'Kuwait', 1, 0, '0.00', 0),
(115, 'KG', 'Kyrgyzstan', 1, 0, '0.00', 0),
(116, 'LA', 'Laos', 1, 0, '0.00', 0),
(117, 'LV', 'Latvia', 1, 0, '0.00', 0),
(118, 'LB', 'Lebanon', 1, 0, '0.00', 0),
(119, 'LS', 'Lesotho', 1, 0, '0.00', 0),
(120, 'LR', 'Liberia', 1, 0, '0.00', 0),
(121, 'LY', 'Libyan Arab Jamahiriya', 1, 0, '0.00', 0),
(122, 'LI', 'Liechtenstein', 1, 0, '0.00', 0),
(123, 'LT', 'Lithuania', 1, 0, '0.00', 0),
(124, 'LU', 'Luxembourg', 1, 0, '0.00', 0),
(125, 'MO', 'Macau', 1, 0, '0.00', 0),
(126, 'MK', 'Macedonia', 1, 0, '0.00', 0),
(127, 'MG', 'Madagascar', 1, 0, '0.00', 0),
(128, 'MW', 'Malawi', 1, 0, '0.00', 0),
(129, 'MY', 'Malaysia', 1, 0, '0.00', 0),
(130, 'MV', 'Maldives', 1, 0, '0.00', 0),
(131, 'ML', 'Mali', 1, 0, '0.00', 0),
(132, 'MT', 'Malta', 1, 0, '0.00', 0),
(133, 'MH', 'Marshall Islands', 1, 0, '0.00', 0),
(134, 'MQ', 'Martinique', 1, 0, '0.00', 0),
(135, 'MR', 'Mauritania', 1, 0, '0.00', 0),
(136, 'MU', 'Mauritius', 1, 0, '0.00', 0),
(137, 'YT', 'Mayotte', 1, 0, '0.00', 0),
(138, 'MX', 'Mexico', 1, 0, '0.00', 0),
(139, 'FM', 'Micronesia', 1, 0, '0.00', 0),
(140, 'MD', 'Moldova, Republic of', 1, 0, '0.00', 0),
(141, 'MC', 'Monaco', 1, 0, '0.00', 0),
(142, 'MN', 'Mongolia', 1, 0, '0.00', 0),
(143, 'MS', 'Montserrat', 1, 0, '0.00', 0),
(144, 'MA', 'Morocco', 1, 0, '0.00', 0),
(145, 'MZ', 'Mozambique', 1, 0, '0.00', 0),
(146, 'MM', 'Myanmar', 1, 0, '0.00', 0),
(147, 'NA', 'Namibia', 1, 0, '0.00', 0),
(148, 'NR', 'Nauru', 1, 0, '0.00', 0),
(149, 'NP', 'Nepal', 1, 0, '0.00', 0),
(150, 'NL', 'Netherlands', 1, 0, '0.00', 0),
(151, 'AN', 'Netherlands Antilles', 1, 0, '0.00', 0),
(152, 'NC', 'New Caledonia', 1, 0, '0.00', 0),
(153, 'NZ', 'New Zealand', 1, 0, '0.00', 0),
(154, 'NI', 'Nicaragua', 1, 0, '0.00', 0),
(155, 'NE', 'Niger', 1, 0, '0.00', 0),
(156, 'NG', 'Nigeria', 1, 0, '0.00', 0),
(157, 'NU', 'Niue', 1, 0, '0.00', 0),
(158, 'NF', 'Norfolk Island', 1, 0, '0.00', 0),
(159, 'MP', 'Northern Mariana Islands', 1, 0, '0.00', 0),
(160, 'NO', 'Norway', 1, 0, '0.00', 0),
(161, 'OM', 'Oman', 1, 0, '0.00', 0),
(162, 'PK', 'Pakistan', 1, 0, '0.00', 0),
(163, 'PW', 'Palau', 1, 0, '0.00', 0),
(164, 'PA', 'Panama', 1, 0, '0.00', 0),
(165, 'PG', 'Papua New Guinea', 1, 0, '0.00', 0),
(166, 'PY', 'Paraguay', 1, 0, '0.00', 0),
(167, 'PE', 'Peru', 1, 0, '0.00', 0),
(168, 'PH', 'Philippines', 1, 0, '0.00', 0),
(169, 'PN', 'Pitcairn', 1, 0, '0.00', 0),
(170, 'PL', 'Poland', 1, 0, '0.00', 0),
(171, 'PT', 'Portugal', 1, 0, '0.00', 0),
(172, 'PR', 'Puerto Rico', 1, 0, '0.00', 0),
(173, 'QA', 'Qatar', 1, 0, '0.00', 0),
(174, 'RE', 'Reunion', 1, 0, '0.00', 0),
(175, 'RO', 'Romania', 1, 0, '0.00', 0),
(176, 'RU', 'Russian Federation', 1, 0, '0.00', 0),
(177, 'RW', 'Rwanda', 1, 0, '0.00', 0),
(178, 'LC', 'Saint Lucia', 1, 0, '0.00', 0),
(179, 'WS', 'Samoa', 1, 0, '0.00', 0),
(180, 'SM', 'San Marino', 1, 0, '0.00', 0),
(181, 'ST', 'Sao Tome and Principe', 1, 0, '0.00', 0),
(182, 'SA', 'Saudi Arabia', 1, 0, '0.00', 0),
(183, 'SN', 'Senegal', 1, 0, '0.00', 0),
(184, 'RS', 'Serbia', 1, 0, '0.00', 0),
(185, 'SC', 'Seychelles', 1, 0, '0.00', 0),
(186, 'SL', 'Sierra Leone', 1, 0, '0.00', 0),
(187, 'SG', 'Singapore', 1, 0, '0.00', 0),
(188, 'SK', 'Slovakia', 1, 0, '0.00', 0),
(189, 'SI', 'Slovenia', 1, 0, '0.00', 0),
(190, 'SB', 'Solomon Islands', 1, 0, '0.00', 0),
(191, 'SO', 'Somalia', 1, 0, '0.00', 0),
(192, 'ZA', 'South Africa', 1, 0, '0.00', 0),
(193, 'ES', 'Spain', 1, 0, '0.00', 0),
(194, 'LK', 'Sri Lanka', 1, 0, '0.00', 0),
(195, 'SH', 'St. Helena', 1, 0, '0.00', 0),
(196, 'KN', 'St. Kitts and Nevis', 1, 0, '0.00', 0),
(197, 'PM', 'St. Pierre and Miquelon', 1, 0, '0.00', 0),
(198, 'VC', 'St. Vincent and the Grenadines', 1, 0, '0.00', 0),
(199, 'SD', 'Sudan', 1, 0, '0.00', 0),
(200, 'SR', 'Suriname', 1, 0, '0.00', 0),
(201, 'SJ', 'Svalbard and Jan Mayen Islands', 1, 0, '0.00', 0),
(202, 'SZ', 'Swaziland', 1, 0, '0.00', 0),
(203, 'SE', 'Sweden', 1, 0, '0.00', 0),
(204, 'CH', 'Switzerland', 1, 0, '0.00', 0),
(205, 'SY', 'Syrian Arab Republic', 1, 0, '0.00', 0),
(206, 'TW', 'Taiwan', 1, 0, '0.00', 0),
(207, 'TJ', 'Tajikistan', 1, 0, '0.00', 0),
(208, 'TZ', 'Tanzania, United Republic of', 1, 0, '0.00', 0),
(209, 'TH', 'Thailand', 1, 0, '0.00', 0),
(210, 'TG', 'Togo', 1, 0, '0.00', 0),
(211, 'TK', 'Tokelau', 1, 0, '0.00', 0),
(212, 'TO', 'Tonga', 1, 0, '0.00', 0),
(213, 'TT', 'Trinidad and Tobago', 1, 0, '0.00', 0),
(214, 'TN', 'Tunisia', 1, 0, '0.00', 0),
(215, 'TR', 'Turkey', 1, 0, '0.00', 0),
(216, 'TM', 'Turkmenistan', 1, 0, '0.00', 0),
(217, 'TC', 'Turks and Caicos Islands', 1, 0, '0.00', 0),
(218, 'TV', 'Tuvalu', 1, 0, '0.00', 0),
(219, 'UG', 'Uganda', 1, 0, '0.00', 0),
(220, 'UA', 'Ukraine', 1, 0, '0.00', 0),
(221, 'AE', 'United Arab Emirates', 1, 0, '0.00', 0),
(222, 'GB', 'United Kingdom (GB)', 1, 0, '23.00', 999),
(224, 'US', 'United States', 1, 0, '7.50', 998),
(225, 'VI', 'United States Virgin Islands', 1, 0, '0.00', 0),
(226, 'UY', 'Uruguay', 1, 0, '0.00', 0),
(227, 'UZ', 'Uzbekistan', 1, 0, '0.00', 0),
(228, 'VU', 'Vanuatu', 1, 0, '0.00', 0),
(229, 'VA', 'Vatican City State', 1, 0, '0.00', 0),
(230, 'VE', 'Venezuela', 1, 0, '0.00', 0),
(231, 'VN', 'Vietnam', 1, 0, '0.00', 0),
(232, 'WF', 'Wallis And Futuna Islands', 1, 0, '0.00', 0),
(233, 'EH', 'Western Sahara', 1, 0, '0.00', 0),
(234, 'YE', 'Yemen', 1, 0, '0.00', 0),
(235, 'ZR', 'Zaire', 1, 0, '0.00', 0),
(236, 'ZM', 'Zambia', 1, 0, '0.00', 0),
(237, 'ZW', 'Zimbabwe', 1, 0, '0.00', 0);

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
CREATE TABLE `coupons` (
  `id` int(1) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `code` varchar(30) NOT NULL,
  `discount` smallint(2) unsigned NOT NULL DEFAULT '0',
  `type` enum('p','a') NOT NULL DEFAULT 'p',
  `membership_id` varchar(50) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `custom_fields`
--

DROP TABLE IF EXISTS `custom_fields`;
CREATE TABLE IF NOT EXISTS `custom_fields` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(60) NOT NULL,
  `name` varchar(20) NOT NULL,
  `tooltip` varchar(100) DEFAULT NULL,
  `required` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `section` varchar(30) DEFAULT NULL,
  `sorting` int(4) UNSIGNED NOT NULL DEFAULT '0',
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `downloads`
--

DROP TABLE IF EXISTS `downloads`;
CREATE TABLE `downloads` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `alias` varchar(60) NOT NULL,
  `name` varchar(80) NOT NULL,
  `filesize` int(11) unsigned NOT NULL,
  `extension` varchar(4) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `token` varchar(32) NOT NULL,
  `fileaccess` varchar(24) NOT NULL DEFAULT '0' COMMENT '0 = all',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `email_templates`
--

DROP TABLE IF EXISTS `email_templates`;
CREATE TABLE IF NOT EXISTS `email_templates` (
  `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `help` tinytext,
  `body` text NOT NULL,
  `type` enum('news','mailer') DEFAULT 'mailer',
  `typeid` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates`(`id`,`name`,`subject`,`help`,`body`,`type`,`typeid`) VALUES 
(1,'Registration Email','Please verify your email','This template is used to send Registration Verification Email, when Configuration->Registration Verification is set to YES','<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#F0F0F0\">\n<tbody>\n<tr>\n<td style=\"background-color: #ffffff;\" align=\"center\" valign=\"top\" bgcolor=\"#ffffff\"><br />\n<table style=\"width: 600px; max-width: 600px;\" border=\"0\" width=\"600px\" cellspacing=\"0\" cellpadding=\"0\">\n<tbody>\n<tr>\n<td height=\"30\"> </td>\n</tr>\n<tr>\n<td align=\"center\">[LOGO]</td>\n</tr>\n<tr>\n<td height=\"20\"> </td>\n</tr>\n<tr>\n<td>\n<p style=\"text-align: center; margin: 0; font-family: Helvetica, Arial, sans-serif; font-size: 26px; color: #222222;\">Welcome to [COMPANY]</p>\n</td>\n</tr>\n<tr>\n<td align=\"center\"><img style=\"width: 250px;\" src=\"[SITEURL]/assets/images/line.png\" alt=\"line\" width=\"251\" height=\"43\" /></td>\n</tr>\n<tr>\n<td height=\"30\"> </td>\n</tr>\n<tr>\n<td style=\"background-color: #ffffff; padding: 12px 24px 12px 24px;\" align=\"left\"><br />\n<p class=\"title\" style=\"font-family: Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 600; color: #374550;\">Congratulations!</p>\n<br />\n<p style=\"font-family: Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; text-align: left; color: #222222;\">You are now registered member<br /> <br /> The administrator of this site has requested all new accounts to be activated by the users who created them thus your account is currently inactive. To activate your account, please visit the link below.</p>\n</td>\n</tr>\n<tr>\n<td style=\"background-color: #ffffff; padding: 12px 24px 12px 24px;\" align=\"left\">\n<p style=\"font-family: Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; text-align: left; color: #222222;\">Here are your login details. Please keep them in a safe place: <br /> <br /> Username: [USERNAME]<br /> Password: [PASSWORD]</p>\n</td>\n</tr>\n<tr>\n<td height=\"65\"> </td>\n</tr>\n<tr>\n<td align=\"center\">\n<table>\n<tbody>\n<tr>\n<td style=\"background: #289CDC; padding: 15px 18px; -webkit-border-radius: 4px; border-radius: 4px; font-family: Helvetica, Arial, sans-serif;\" align=\"center\" bgcolor=\"#289CDC\">\n<p align=\"center\"><a target=\"_blank\" href=\"[LINK]\" style=\"color: #ffffff; text-decoration: none; font-size: 16px;\">Activate your Account</a></p>\n</td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n<tr>\n<td height=\"65\"> </td>\n</tr>\n<tr>\n<td style=\"border-bottom: 1px solid #DDDDDD;\"> </td>\n</tr>\n<tr>\n<td height=\"25\"> </td>\n</tr>\n<tr>\n<td>\n<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td style=\"font-family: Helvetica, Arial, sans-serif;\" align=\"left\" valign=\"top\">\n<p style=\"text-align: left; color: #999999; font-size: 12px; font-weight: normal; line-height: 20px;\">This email is sent to you directly from <a href=\"[SITEURL]\">[COMPANY]</a> The information above is gathered from the user input. <br /> ©[DATE] <a href=\"[SITEURL]\">[COMPANY]</a>. All rights reserved.</p>\n</td>\n<td width=\"30\"> </td>\n<td valign=\"top\" width=\"52\"><a target=\"_blank\" href=\"http://facebook.com/[FB]\"><img style=\"width: 52px;\" src=\"[SITEURL]/assets/images/facebook.png\" alt=\"facebook icon\" width=\"52\" height=\"53\" /></a></td>\n<td width=\"16\"> </td>\n<td valign=\"top\" width=\"52\"><a target=\"_blank\" href=\"http://twitter.com/[TW]\"><img style=\"width: 52px;\" src=\"[SITEURL]/assets/images/twitter.png\" alt=\"twitter icon\" width=\"52\" height=\"53\" /></a></td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n</tbody>\n</table>\n<p> </p>','mailer','regMail');

INSERT INTO `email_templates`(`id`,`name`,`subject`,`help`,`body`,`type`,`typeid`) VALUES 
(2,'Welcome Mail From Admin','You have been registered','This template is used to send welcome email, when user is added by administrator','<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#F0F0F0\">\n<tbody>\n<tr>\n<td style=\"background-color: #ffffff;\" align=\"center\" valign=\"top\" bgcolor=\"#ffffff\"><br />\n<table style=\"width: 100%px; max-width: 600px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n<tbody>\n<tr>\n<td height=\"30\"> </td>\n</tr>\n<tr>\n<td align=\"center\">[LOGO]</td>\n</tr>\n<tr>\n<td height=\"20\"> </td>\n</tr>\n<tr>\n<td>\n<p style=\"text-align: center; margin: 0; font-family: Helvetica, Arial, sans-serif; font-size: 26px; color: #222222;\">Welcome to [COMPANY]</p>\n</td>\n</tr>\n<tr>\n<td align=\"center\"><img style=\"width: 250px;\" src=\"[SITEURL]/assets/images/line.png\" alt=\"line\" width=\"251\" height=\"43\" /></td>\n</tr>\n<tr>\n<td height=\"30\"> </td>\n</tr>\n<tr>\n<td style=\"background-color: #ffffff; padding: 12px 24px 12px 24px;\" align=\"left\"><br />\n<p style=\"font-family: Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 600; color: #374550;\">Hello, [NAME]</p>\n<p style=\"font-family: Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; text-align: left; color: #222222;\">You\'re now a member of [COMPANY]. <br /> Here are your login details. Please keep them in a safe place: </p>\n</td>\n</tr>\n<tr>\n<td style=\"background-color: #ffffff; padding: 12px 24px 12px 24px;\" align=\"left\">\n<p style=\"font-family: Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; text-align: left; color: #222222;\">Here are your login details. Please keep them in a safe place: <br /> <br /> Username: [USERNAME] or [EMAIL]<br /> Password: [PASSWORD]</p>\n</td>\n</tr>\n<tr>\n<td height=\"65\"> </td>\n</tr>\n<tr>\n<td align=\"center\">\n<table>\n<tbody>\n<tr>\n<td style=\"background: #289CDC; padding: 15px 18px; -webkit-border-radius: 4px; border-radius: 4px; font-family: Helvetica, Arial, sans-serif;\" align=\"center\" bgcolor=\"#289CDC\"><a target=\"_blank\" href=\"[LINK]\" style=\"color: #ffffff; text-decoration: none; font-size: 16px;\">Login</a></td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n<tr>\n<td height=\"65\"> </td>\n</tr>\n<tr>\n<td style=\"border-bottom: 1px solid #DDDDDD;\"> </td>\n</tr>\n<tr>\n<td height=\"25\"> </td>\n</tr>\n<tr>\n<td style=\"text-align: center;\" align=\"center\">\n<table border=\"0\" width=\"95%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td style=\"font-family: Helvetica, Arial, sans-serif;\" align=\"left\" valign=\"top\">\n<p style=\"text-align: left; color: #999999; font-size: 12px; font-weight: normal; line-height: 20px;\">This email is sent to you directly from <a href=\"[SITEURL]\">[COMPANY]</a> The information above is gathered from the user input. <br /> ©[DATE] <a href=\"[SITEURL]\">[COMPANY]</a>. All rights reserved.</p>\n</td>\n<td width=\"30\"> </td>\n<td valign=\"top\" width=\"52\"><a target=\"_blank\" href=\"http://facebook.com/[FB]\"><img style=\"width: 52px;\" src=\"[SITEURL]/assets/images/facebook.png\" alt=\"facebook icon\" width=\"52\" height=\"53\" /></a></td>\n<td width=\"16\"> </td>\n<td valign=\"top\" width=\"52\"><a target=\"_blank\" href=\"http://twitter.com/[TW]\"><img style=\"width: 52px;\" src=\"[SITEURL]/assets/images/twitter.png\" alt=\"twitter icon\" width=\"52\" height=\"53\" /></a></td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n</tbody>\n</table>','mailer','regMailAdmin');

INSERT INTO `email_templates`(`id`,`name`,`subject`,`help`,`body`,`type`,`typeid`) VALUES 
(3,'Default Newsletter','Newsletter','This is a default newsletter template','<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#F0F0F0\">\n<tbody>\n<tr>\n<td style=\"background-color: #ffffff;\" align=\"center\" valign=\"top\" bgcolor=\"#ffffff\"><br />\n<table style=\"width: 100%px; max-width: 600px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n<tbody>\n<tr>\n<td height=\"30\"> </td>\n</tr>\n<tr>\n<td align=\"center\">[LOGO]</td>\n</tr>\n<tr>\n<td height=\"20\"> </td>\n</tr>\n<tr>\n<td>\n<p style=\"text-align: center; margin: 0; font-family: Helvetica, Arial, sans-serif; font-size: 26px; color: #222222;\">[COMPANY] Newsletter</p>\n</td>\n</tr>\n<tr>\n<td align=\"center\"><img style=\"width: 250px;\" src=\"[SITEURL]/assets/images/line.png\" alt=\"line\" width=\"251\" height=\"43\" /></td>\n</tr>\n<tr>\n<td height=\"30\"> </td>\n</tr>\n<tr>\n<td style=\"background-color: #ffffff; padding: 12px 24px 12px 24px;\" align=\"left\"><br />\nHello, [NAME]\n<br /> <br />\n[ATTACHMENT]\n<br /> <br />\nNewsletter content goes here...: <br /> \n</td>\n</tr>\n<tr>\n<td height=\"65\"> </td>\n</tr>\n<tr>\n<td style=\"border-bottom: 1px solid #DDDDDD;\"> </td>\n</tr>\n<tr>\n<td height=\"25\"> </td>\n</tr>\n<tr>\n<td style=\"text-align: center;\" align=\"center\">\n<table border=\"0\" width=\"95%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td style=\"font-family: Helvetica, Arial, sans-serif;\" align=\"left\" valign=\"top\">\n\n<p style=\"text-align: left; color: #999999; font-size: 12px; font-weight: normal; line-height: 20px;\">This email is sent to you directly from <a href=\"[SITEURL]\">[COMPANY]</a> The information above is gathered from the user input. <br /> ©[DATE] <a href=\"[SITEURL]\">[COMPANY]</a>. All rights reserved.</p>\n\n</td>\n<td width=\"30\"> </td>\n<td valign=\"top\" width=\"52\"><a target=\"_blank\" href=\"http://facebook.com/[FB]\"><img style=\"width: 52px;\" src=\"[SITEURL]/assets/images/facebook.png\" alt=\"facebook icon\" width=\"52\" height=\"53\" /></a></td>\n<td width=\"16\"> </td>\n<td valign=\"top\" width=\"52\"><a target=\"_blank\" href=\"http://twitter.com/[TW]\"><img style=\"width: 52px;\" src=\"[SITEURL]/assets/images/twitter.png\" alt=\"twitter icon\" width=\"52\" height=\"53\" /></a></td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n</tbody>\n</table>\n<p> </p>','mailer','newsletter');

INSERT INTO `email_templates`(`id`,`name`,`subject`,`help`,`body`,`type`,`typeid`) VALUES 
(4,'Single Email','Single User Email','This template is used to email single user','<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#F0F0F0\">\n<tbody>\n<tr>\n<td style=\"background-color: #ffffff;\" align=\"center\" valign=\"top\" bgcolor=\"#ffffff\"><br />\n<table style=\"width: 100%px; max-width: 600px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n<tbody>\n<tr>\n<td height=\"30\"> </td>\n</tr>\n<tr>\n<td align=\"center\">[LOGO]</td>\n</tr>\n<tr>\n<td height=\"20\"> </td>\n</tr>\n<tr>\n<td>\n<p style=\"text-align: center; margin: 0; font-family: Helvetica, Arial, sans-serif; font-size: 26px; color: #222222;\">Hello [NAME]</p>\n</td>\n</tr>\n<tr>\n<td align=\"center\"><img style=\"width: 250px;\" src=\"[SITEURL]/assets/images/line.png\" alt=\"line\" width=\"251\" height=\"43\" /></td>\n</tr>\n<tr>\n<td height=\"30\"> </td>\n</tr>\n<tr>\n<td style=\"background-color: #ffffff; padding: 12px 24px 12px 24px;\" align=\"left\">Your message goes here...</td>\n</tr>\n<tr>\n<td style=\"background-color: #ffffff; padding: 12px 24px 12px 24px;\" align=\"left\">[ATTACHMENT]</td>\n</tr>\n<tr>\n<td height=\"65\"> </td>\n</tr>\n<tr>\n<td style=\"border-bottom: 1px solid #DDDDDD;\"> </td>\n</tr>\n<tr>\n<td height=\"25\"> </td>\n</tr>\n<tr>\n<td style=\"text-align: center;\" align=\"center\">\n<table border=\"0\" width=\"95%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td style=\"font-family: Helvetica, Arial, sans-serif;\" align=\"left\" valign=\"top\">\n<p style=\"text-align: left; color: #999999; font-size: 12px; font-weight: normal; line-height: 20px;\">This email is sent to you directly from <a href=\"[SITEURL]\">[COMPANY]</a> The information above is gathered from the user input. <br /> ©[DATE] <a href=\"[SITEURL]\">[COMPANY]</a>. All rights reserved.</p>\n</td>\n<td width=\"30\"> </td>\n<td valign=\"top\" width=\"52\"><a target=\"_blank\" href=\"http://facebook.com/[FB]\"><img style=\"width: 52px;\" src=\"[SITEURL]/assets/images/facebook.png\" alt=\"facebook icon\" width=\"52\" height=\"53\" /></a></td>\n<td width=\"16\"> </td>\n<td valign=\"top\" width=\"52\"><a target=\"_blank\" href=\"http://twitter.com/[TW]\"><img style=\"width: 52px;\" src=\"[SITEURL]/assets/images/twitter.png\" alt=\"twitter icon\" width=\"52\" height=\"53\" /></a></td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n</tbody>\n</table>\n<p> </p>','mailer','singleMail');

INSERT INTO `email_templates`(`id`,`name`,`subject`,`help`,`body`,`type`,`typeid`) VALUES 
(5,'Forgot Password Admin','Password Reset','This template is used for retrieving lost admin password','<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#F0F0F0\">\n<tbody>\n<tr>\n<td style=\"background-color: #ffffff;\" align=\"center\" valign=\"top\" bgcolor=\"#ffffff\"><br />\n<table class=\"container\" style=\"width: 100%px; max-width: 600px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n<tbody>\n<tr>\n<td height=\"30\"> </td>\n</tr>\n<tr>\n<td align=\"center\">[LOGO]</td>\n</tr>\n<tr>\n<td height=\"20\"> </td>\n</tr>\n<tr>\n<td>\n<p style=\"text-align: center; margin: 0; font-family: Helvetica, Arial, sans-serif; font-size: 26px; color: #222222;\">New password reset from [COMPANY]</p>\n</td>\n</tr>\n<tr>\n<td align=\"center\"><img style=\"width: 250px;\" src=\"[SITEURL]/assets/images/line.png\" alt=\"line\" width=\"251\" height=\"43\" /></td>\n</tr>\n<tr>\n<td height=\"30\"> </td>\n</tr>\n<tr>\n<td class=\"container-padding content\" style=\"background-color: #ffffff; padding: 12px 24px 12px 24px;\" align=\"left\"><br />\nHello, [NAME]\n<br />\nIt seems that you or someone requested a new password for you.<br /> We have generated a new password, as requested: <br /> \n</td>\n</tr>\n<tr>\n<td class=\"container-padding content\" style=\"background-color: #ffffff; padding: 12px 24px 12px 24px;\" align=\"left\">\nNew Password: [PASSWORD]\n</td>\n</tr>\n<tr>\n<td height=\"65\"> </td>\n</tr>\n<tr>\n<td align=\"center\">\n<table>\n<tbody>\n<tr>\n<td style=\"background: #289CDC; padding: 15px 18px; -webkit-border-radius: 4px; border-radius: 4px; font-family: Helvetica, Arial, sans-serif;\" align=\"center\" bgcolor=\"#289CDC\">\n<a target=\"_blank\" href=\"[LINK]\" style=\"color: #ffffff; text-decoration: none; font-size: 16px;\">Admin Panel</a>\n</td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n<tr>\n<td style=\"border-bottom: 1px solid #DDDDDD;\"> </td>\n</tr>\n<tr>\n<td height=\"25\"> </td>\n</tr>\n<tr>\n<td style=\"text-align: center;\" align=\"center\">\n<table border=\"0\" width=\"95%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td style=\"font-family: Helvetica, Arial, sans-serif;\" align=\"left\" valign=\"top\">\n\n<p style=\"text-align: left; color: #999999; font-size: 12px; font-weight: normal; line-height: 20px;\">This email is sent to you directly from <a href=\"[SITEURL]\">[COMPANY]</a> The information above is gathered from the user input. <br /> ©[DATE] <a href=\"[SITEURL]\">[COMPANY]</a>. All rights reserved.</p>\n\n</td>\n<td width=\"30\"> </td>\n<td valign=\"top\" width=\"52\"><a target=\"_blank\" href=\"http://facebook.com/[FB]\"><img style=\"width: 52px;\" src=\"[SITEURL]/assets/images/facebook.png\" alt=\"facebook icon\" width=\"52\" height=\"53\" /></a></td>\n<td width=\"16\"> </td>\n<td valign=\"top\" width=\"52\"><a target=\"_blank\" href=\"http://twitter.com/[TW]\"><img style=\"width: 52px;\" src=\"[SITEURL]/assets/images/twitter.png\" alt=\"twitter icon\" width=\"52\" height=\"53\" /></a></td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n</tbody>\n</table>\n<p> </p>','mailer','adminPassReset');

INSERT INTO `email_templates`(`id`,`name`,`subject`,`help`,`body`,`type`,`typeid`) VALUES 
(6,'Forgot Password User','Password Reset','This template is used for retrieving lost user password','<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#F0F0F0\">\n<tbody>\n<tr>\n<td style=\"background-color: #ffffff;\" align=\"center\" valign=\"top\" bgcolor=\"#ffffff\"><br />\n<table class=\"container\" style=\"width: 100%px; max-width: 600px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n<tbody>\n<tr>\n<td height=\"30\"> </td>\n</tr>\n<tr>\n<td align=\"center\">[LOGO]</td>\n</tr>\n<tr>\n<td height=\"20\"> </td>\n</tr>\n<tr>\n<td>\n<p style=\"text-align: center; margin: 0; font-family: Helvetica, Arial, sans-serif; font-size: 26px; color: #222222;\">New password reset from [COMPANY]</p>\n</td>\n</tr>\n<tr>\n<td align=\"center\"><img style=\"width: 250px;\" src=\"[SITEURL]/assets/images/line.png\" alt=\"line\" width=\"251\" height=\"43\" /></td>\n</tr>\n<tr>\n<td height=\"30\"> </td>\n</tr>\n<tr>\n<td class=\"container-padding content\" style=\"background-color: #ffffff; padding: 12px 24px 12px 24px;\" align=\"left\"><br />\nHello, [NAME]\n<br />\nIt seems that you or someone requested a new password for you.<br /> We have generated a new password, as requested: <br /> \n</td>\n</tr>\n<tr>\n<td class=\"container-padding content\" style=\"background-color: #ffffff; padding: 12px 24px 12px 24px;\" align=\"left\">\nNew Password: [PASSWORD]\n</td>\n</tr>\n<tr>\n<td height=\"65\"> </td>\n</tr>\n<tr>\n<td align=\"center\">\n<table>\n<tbody>\n<tr>\n<td style=\"background: #289CDC; padding: 15px 18px; -webkit-border-radius: 4px; border-radius: 4px; font-family: Helvetica, Arial, sans-serif;\" align=\"center\" bgcolor=\"#289CDC\">\n<a target=\"_blank\" href=\"[LINK]\" style=\"color: #ffffff; text-decoration: none; font-size: 16px;\">Login</a>\n</td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n<tr>\n<td style=\"border-bottom: 1px solid #DDDDDD;\"> </td>\n</tr>\n<tr>\n<td height=\"25\"> </td>\n</tr>\n<tr>\n<td style=\"text-align: center;\" align=\"center\">\n<table border=\"0\" width=\"95%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td style=\"font-family: Helvetica, Arial, sans-serif;\" align=\"left\" valign=\"top\">\n\n<p style=\"text-align: left; color: #999999; font-size: 12px; font-weight: normal; line-height: 20px;\">This email is sent to you directly from <a href=\"[SITEURL]\">[COMPANY]</a> The information above is gathered from the user input. <br /> ©[DATE] <a href=\"[SITEURL]\">[COMPANY]</a>. All rights reserved.</p>\n\n</td>\n<td width=\"30\"> </td>\n<td valign=\"top\" width=\"52\"><a target=\"_blank\" href=\"http://facebook.com/[FB]\"><img style=\"width: 52px;\" src=\"[SITEURL]/assets/images/facebook.png\" alt=\"facebook icon\" width=\"52\" height=\"53\" /></a></td>\n<td width=\"16\"> </td>\n<td valign=\"top\" width=\"52\"><a target=\"_blank\" href=\"http://twitter.com/[TW]\"><img style=\"width: 52px;\" src=\"[SITEURL]/assets/images/twitter.png\" alt=\"twitter icon\" width=\"52\" height=\"53\" /></a></td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n</tbody>\n</table>\n<p> </p>','mailer','userPassReset');

INSERT INTO `email_templates`(`id`,`name`,`subject`,`help`,`body`,`type`,`typeid`) VALUES 
(7,'Welcome Email','Welcome','This template is used to welcome newly registered user when Configuration->Registration Verification and Configuration->Auto Registration are both set to YES','<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#F0F0F0\">\n<tbody>\n<tr>\n<td style=\"background-color: #ffffff;\" align=\"center\" valign=\"top\" bgcolor=\"#ffffff\"><br />\n<table style=\"width: 600px; max-width: 600px;\" border=\"0\" width=\"600px\" cellspacing=\"0\" cellpadding=\"0\">\n<tbody>\n<tr>\n<td height=\"30\"> </td>\n</tr>\n<tr>\n<td align=\"center\">[LOGO]</td>\n</tr>\n<tr>\n<td height=\"20\"> </td>\n</tr>\n<tr>\n<td>\n<p style=\"text-align: center; margin: 0; font-family: Helvetica, Arial, sans-serif; font-size: 26px; color: #222222;\">Welcome to [COMPANY]</p>\n</td>\n</tr>\n<tr>\n<td align=\"center\"><img style=\"width: 250px;\" src=\"[SITEURL]/assets/images/line.png\" alt=\"line\" width=\"251\" height=\"43\" /></td>\n</tr>\n<tr>\n<td height=\"30\"> </td>\n</tr>\n<tr>\n<td style=\"background-color: #ffffff; padding: 12px 24px 12px 24px;\" align=\"left\"><br />\n<p class=\"title\" style=\"font-family: Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 600; color: #374550;\">Congratulations!</p>\n<br />\n<p style=\"font-family: Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; text-align: left; color: #222222;\">You are now registered member.</p>\n</td>\n</tr>\n<tr>\n<td style=\"background-color: #ffffff; padding: 12px 24px 12px 24px;\" align=\"left\">\n<p style=\"font-family: Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; text-align: left; color: #222222;\">Here are your login details. Please keep them in a safe place: <br /> <br /> Username: [USERNAME]<br /> Password: [PASSWORD]</p>\n</td>\n</tr>\n<tr>\n<td height=\"65\"> </td>\n</tr>\n<tr>\n<td align=\"center\">\n<table>\n<tbody>\n<tr>\n<td style=\"background: #289CDC; padding: 15px 18px; -webkit-border-radius: 4px; border-radius: 4px; font-family: Helvetica, Arial, sans-serif;\" align=\"center\" bgcolor=\"#289CDC\">\n<p align=\"center\"><a target=\"_blank\" href=\"[LINK]\" style=\"color: #ffffff; text-decoration: none; font-size: 16px;\">Login</a></p>\n</td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n<tr>\n<td height=\"65\"> </td>\n</tr>\n<tr>\n<td style=\"border-bottom: 1px solid #DDDDDD;\"> </td>\n</tr>\n<tr>\n<td height=\"25\"> </td>\n</tr>\n<tr>\n<td>\n<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td style=\"font-family: Helvetica, Arial, sans-serif;\" align=\"left\" valign=\"top\">\n<p style=\"text-align: left; color: #999999; font-size: 12px; font-weight: normal; line-height: 20px;\">This email is sent to you directly from <a href=\"[SITEURL]\">[COMPANY]</a> The information above is gathered from the user input. <br /> ©[DATE] <a href=\"[SITEURL]\">[COMPANY]</a>. All rights reserved.</p>\n</td>\n<td width=\"30\"> </td>\n<td valign=\"top\" width=\"52\"><a target=\"_blank\" href=\"http://facebook.com/[FB]\"><img style=\"width: 52px;\" src=\"[SITEURL]/assets/images/facebook.png\" alt=\"facebook icon\" width=\"52\" height=\"53\" /></a></td>\n<td width=\"16\"> </td>\n<td valign=\"top\" width=\"52\"><a target=\"_blank\" href=\"http://twitter.com/[TW]\"><img style=\"width: 52px;\" src=\"[SITEURL]/assets/images/twitter.png\" alt=\"twitter icon\" width=\"52\" height=\"53\" /></a></td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n</tbody>\n</table>\n<p> </p>','mailer','welcomeEmail');

INSERT INTO `email_templates`(`id`,`name`,`subject`,`help`,`body`,`type`,`typeid`) VALUES 
(8,'Registration Pending','Registration Verification Pending','This template is used to send Registration Verification Email, when Configuration->Auto Registration is set to NO','<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#F0F0F0\">\n<tbody>\n<tr>\n<td style=\"background-color: #ffffff;\" align=\"center\" valign=\"top\" bgcolor=\"#ffffff\"><br />\n<table style=\"width: 600px; max-width: 600px;\" border=\"0\" width=\"600px\" cellspacing=\"0\" cellpadding=\"0\">\n<tbody>\n<tr>\n<td height=\"30\"> </td>\n</tr>\n<tr>\n<td align=\"center\">[LOGO]</td>\n</tr>\n<tr>\n<td height=\"20\"> </td>\n</tr>\n<tr>\n<td>\n<p style=\"text-align: center; margin: 0; font-family: Helvetica, Arial, sans-serif; font-size: 26px; color: #222222;\">Welcome to [COMPANY]</p>\n</td>\n</tr>\n<tr>\n<td align=\"center\"><img style=\"width: 250px;\" src=\"[SITEURL]/assets/images/line.png\" alt=\"line\" width=\"251\" height=\"43\" /></td>\n</tr>\n<tr>\n<td height=\"30\"> </td>\n</tr>\n<tr>\n<td style=\"background-color: #ffffff; padding: 12px 24px 12px 24px;\" align=\"left\"><br />\n<p class=\"title\" style=\"font-family: Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 600; color: #374550;\">Congratulations!</p>\n<br />\n<p style=\"font-family: Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; text-align: left; color: #222222;\">You are now registered member<br /> <br /> The administrator of this site has requested all new accounts to be activated by the users who created them thus your account is currently pending verification process.</p>\n</td>\n</tr>\n<tr>\n<td style=\"background-color: #ffffff; padding: 12px 24px 12px 24px;\" align=\"left\">\n<p style=\"font-family: Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; text-align: left; color: #222222;\">Here are your login details. Please keep them in a safe place: <br /> <br /> Username: [USERNAME]<br /> Password: [PASSWORD]</p>\n</td>\n</tr>\n<tr>\n<td height=\"65\"> </td>\n</tr>\n<tr>\n<td style=\"border-bottom: 1px solid #DDDDDD;\"> </td>\n</tr>\n<tr>\n<td height=\"25\"> </td>\n</tr>\n<tr>\n<td>\n<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td style=\"font-family: Helvetica, Arial, sans-serif;\" align=\"left\" valign=\"top\">\n<p style=\"text-align: left; color: #999999; font-size: 12px; font-weight: normal; line-height: 20px;\">This email is sent to you directly from <a href=\"[SITEURL]\">[COMPANY]</a> The information above is gathered from the user input. <br /> ©[DATE] <a href=\"[SITEURL]\">[COMPANY]</a>. All rights reserved.</p>\n</td>\n<td width=\"30\"> </td>\n<td valign=\"top\" width=\"52\"><a target=\"_blank\" href=\"http://facebook.com/[FB]\"><img style=\"width: 52px;\" src=\"[SITEURL]/assets/images/facebook.png\" alt=\"facebook icon\" width=\"52\" height=\"53\" /></a></td>\n<td width=\"16\"> </td>\n<td valign=\"top\" width=\"52\"><a target=\"_blank\" href=\"http://twitter.com/[TW]\"><img style=\"width: 52px;\" src=\"[SITEURL]/assets/images/twitter.png\" alt=\"twitter icon\" width=\"52\" height=\"53\" /></a></td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n</tbody>\n</table>','mailer','regMailPending');

INSERT INTO `email_templates`(`id`,`name`,`subject`,`help`,`body`,`type`,`typeid`) VALUES 
(9,'Notify Admin','New User Registration','This template is used to notify admin of new registration when Configuration->Registration Notification is set to YES','<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#F0F0F0\">\n<tbody>\n<tr>\n<td style=\"background-color: #ffffff;\" align=\"center\" valign=\"top\" bgcolor=\"#ffffff\"><br />\n<table style=\"width: 100%px; max-width: 600px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n<tbody>\n<tr>\n<td height=\"30\"> </td>\n</tr>\n<tr>\n<td align=\"center\">[LOGO]</td>\n</tr>\n<tr>\n<td height=\"20\"> </td>\n</tr>\n<tr>\n<td>\n<p style=\"text-align: center; margin: 0; font-family: Helvetica, Arial, sans-serif; font-size: 26px; color: #222222;\">Hello Admin</p>\n</td>\n</tr>\n<tr>\n<td align=\"center\"><img style=\"width: 250px;\" src=\"[SITEURL]/assets/images/line.png\" alt=\"line\" width=\"251\" height=\"43\" /></td>\n</tr>\n<tr>\n<td height=\"30\"> </td>\n</tr>\n<tr>\n<td class=\"container-padding content\" style=\"background-color: #ffffff; padding: 12px 24px 12px 24px;\" align=\"left\">\nYou have a new user registration. You can login into your admin panel to view details:\n<br /> <br />\n\n<table>\n<tbody>\n<tr>\n<td style=\"width: 120px;\"><strong>Username:</strong></td>\n<td>[USERNAME]</td>\n</tr>\n<tr>\n<td><strong>Name:</strong></td>\n<td>[NAME]</td>\n</tr>\n<tr>\n<td><strong>IP:</strong></td>\n<td>[IP]</td>\n</tr>\n</tbody>\n</table>\n\n</td>\n</tr>\n<tr>\n<td height=\"65\"> </td>\n</tr>\n<tr>\n<td style=\"border-bottom: 1px solid #DDDDDD;\"> </td>\n</tr>\n<tr>\n<td height=\"25\"> </td>\n</tr>\n<tr>\n<td style=\"text-align: center;\" align=\"center\">\n<table border=\"0\" width=\"95%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td style=\"font-family: Helvetica, Arial, sans-serif;\" align=\"left\" valign=\"top\">\n\n<p style=\"text-align: left; color: #999999; font-size: 12px; font-weight: normal; line-height: 20px;\">This email is sent to you directly from <a href=\"[SITEURL]\">[COMPANY]</a> The information above is gathered from the user input. <br /> ©[DATE] <a href=\"[SITEURL]\">[COMPANY]</a>. All rights reserved.</p>\n\n</td>\n<td width=\"30\"> </td>\n<td valign=\"top\" width=\"52\"><a target=\"_blank\" href=\"http://facebook.com/[FB]\"><img style=\"width: 52px;\" src=\"[SITEURL]/assets/images/facebook.png\" alt=\"facebook icon\" width=\"52\" height=\"53\" /></a></td>\n<td width=\"16\"> </td>\n<td valign=\"top\" width=\"52\"><a target=\"_blank\" href=\"http://twitter.com/[TW]\"><img style=\"width: 52px;\" src=\"[SITEURL]/assets/images/twitter.png\" alt=\"twitter icon\" width=\"52\" height=\"53\" /></a></td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n</tbody>\n</table>','mailer','notifyAdmin');

INSERT INTO `email_templates`(`id`,`name`,`subject`,`help`,`body`,`type`,`typeid`) VALUES 
(10,'Contact Request','Contact Inquiry','This template is used to send default Contact Request Form','<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#F0F0F0\">\n<tbody>\n<tr>\n<td style=\"background-color: #ffffff;\" align=\"center\" valign=\"top\" bgcolor=\"#ffffff\"><br />\n<table style=\"width: 100%px; max-width: 600px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n<tbody>\n<tr>\n<td height=\"30\"> </td>\n</tr>\n<tr>\n<td align=\"center\">[LOGO]</td>\n</tr>\n<tr>\n<td height=\"20\"> </td>\n</tr>\n<tr>\n<td>\n<p style=\"text-align: center; margin: 0; font-family: Helvetica, Arial, sans-serif; font-size: 26px; color: #222222;\">Hello Admin</p>\n</td>\n</tr>\n<tr>\n<td align=\"center\"><img style=\"width: 250px;\" src=\"[SITEURL]/assets/images/line.png\" alt=\"line\" width=\"251\" height=\"43\" /></td>\n</tr>\n<tr>\n<td height=\"30\"> </td>\n</tr>\n<tr>\n<td class=\"container-padding content\" style=\"background-color: #ffffff; padding: 12px 24px 12px 24px;\" align=\"left\">\nYou have a new contact request:\n<br /> <br />\n\n<table>\n<tbody>\n<tr>\n<td style=\"width: 120px;\"><strong>From:</strong></td>\n<td>[NAME]</td>\n</tr>\n<tr>\n<td><strong>Subject:</strong></td>\n<td>[MAILSUBJECT]</td>\n</tr>\n<tr>\n<td><strong>IP:</strong></td>\n<td>[IP]</td>\n</tr>\n</tbody>\n</table>\n\n<br />\n[MESSAGE]\n</td>\n</tr>\n<tr>\n<td height=\"65\"> </td>\n</tr>\n<tr>\n<td style=\"border-bottom: 1px solid #DDDDDD;\"> </td>\n</tr>\n<tr>\n<td height=\"25\"> </td>\n</tr>\n<tr>\n<td style=\"text-align: center;\" align=\"center\">\n<table border=\"0\" width=\"95%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td style=\"font-family: Helvetica, Arial, sans-serif;\" align=\"left\" valign=\"top\">\n\n<p style=\"text-align: left; color: #999999; font-size: 12px; font-weight: normal; line-height: 20px;\">This email is sent to you directly from <a href=\"[SITEURL]\">[COMPANY]</a> The information above is gathered from the user input. <br /> ©[DATE] <a href=\"[SITEURL]\">[COMPANY]</a>. All rights reserved.</p>\n\n</td>\n<td width=\"30\"> </td>\n<td valign=\"top\" width=\"52\"><a target=\"_blank\" href=\"http://facebook.com/[FB]\"><img style=\"width: 52px;\" src=\"[SITEURL]/assets/images/facebook.png\" alt=\"facebook icon\" width=\"52\" height=\"53\" /></a></td>\n<td width=\"16\"> </td>\n<td valign=\"top\" width=\"52\"><a target=\"_blank\" href=\"http://twitter.com/[TW]\"><img style=\"width: 52px;\" src=\"[SITEURL]/assets/images/twitter.png\" alt=\"twitter icon\" width=\"52\" height=\"53\" /></a></td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n</tbody>\n</table>','mailer','contact');

INSERT INTO `email_templates`(`id`,`name`,`subject`,`help`,`body`,`type`,`typeid`) VALUES 
(11,'Transaction Completed Admin','Payment Completed','This template is used to notify administrator on successful payment transaction','<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#F0F0F0\">\n<tbody>\n<tr>\n<td style=\"background-color: #ffffff;\" align=\"center\" valign=\"top\" bgcolor=\"#ffffff\"><br />\n<table style=\"width: 100%px; max-width: 600px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n<tbody>\n<tr>\n<td height=\"30\"> </td>\n</tr>\n<tr>\n<td align=\"center\">[LOGO]</td>\n</tr>\n<tr>\n<td height=\"20\"> </td>\n</tr>\n<tr>\n<td>\n<p style=\"text-align: center; margin: 0; font-family: Helvetica, Arial, sans-serif; font-size: 26px; color: #222222;\">Hello Admin</p>\n</td>\n</tr>\n<tr>\n<td align=\"center\"><img style=\"width: 250px;\" src=\"[SITEURL]/assets/images/line.png\" alt=\"line\" width=\"251\" height=\"43\" /></td>\n</tr>\n<tr>\n<td height=\"30\"> </td>\n</tr>\n<tr>\n<td class=\"container-padding content\" style=\"background-color: #ffffff; padding: 12px 24px 12px 24px;\" align=\"left\">\nYou have received new payment following:\n<br />\n\n<table>\n<tbody>\n<tr>\n<td style=\"width: 120px;\"><strong>Name:</strong></td>\n<td>[NAME]</td>\n</tr>\n<tr>\n<td><strong>Membership:</strong></td>\n<td>[ITEMNAME]</td>\n</tr>\n<tr>\n<td><strong>Price:</strong></td>\n<td>[PRICE]</td>\n</tr>\n<tr>\n<td><strong>Status:</strong></td>\n<td>[STATUS]</td>\n</tr>\n<tr>\n<td><strong>Processor:</strong></td>\n<td>[PP]</td>\n</tr>\n<tr>\n<td><strong>IP:</strong></td>\n<td>[IP]</td>\n</tr>\n</tbody>\n</table>\n\n</td>\n</tr>\n<tr>\n<td height=\"65\"> </td>\n</tr>\n<tr>\n<td style=\"border-bottom: 1px solid #DDDDDD;\"> </td>\n</tr>\n<tr>\n<td height=\"25\"> </td>\n</tr>\n<tr>\n<td style=\"text-align: center;\" align=\"center\">\n<table border=\"0\" width=\"95%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td style=\"font-family: Helvetica, Arial, sans-serif;\" align=\"left\" valign=\"top\">\n\n<p style=\"text-align: left; color: #999999; font-size: 12px; font-weight: normal; line-height: 20px;\">This email is sent to you directly from <a href=\"[SITEURL]\">[COMPANY]</a> The information above is gathered from the user input. <br /> ©[DATE] <a href=\"[SITEURL]\">[COMPANY]</a>. All rights reserved.</p>\n\n</td>\n<td width=\"30\"> </td>\n<td valign=\"top\" width=\"52\"><a target=\"_blank\" href=\"http://facebook.com/[FB]\"><img style=\"width: 52px;\" src=\"[SITEURL]/assets/images/facebook.png\" alt=\"facebook icon\" width=\"52\" height=\"53\" /></a></td>\n<td width=\"16\"> </td>\n<td valign=\"top\" width=\"52\"><a target=\"_blank\" href=\"http://twitter.com/[TW]\"><img style=\"width: 52px;\" src=\"[SITEURL]/assets/images/twitter.png\" alt=\"twitter icon\" width=\"52\" height=\"53\" /></a></td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n</tbody>\n</table>\n<p> </p>','mailer','payComplete');

INSERT INTO `email_templates`(`id`,`name`,`subject`,`help`,`body`,`type`,`typeid`) VALUES 
(12,'Transaction Completed User','Payment Completed','This template is used to notify user on successful payment transaction','<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#F0F0F0\">\n<tbody>\n<tr>\n<td style=\"background-color: #ffffff;\" align=\"center\" valign=\"top\" bgcolor=\"#ffffff\"><br />\n<table style=\"width: 100%px; max-width: 600px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n<tbody>\n<tr>\n<td height=\"30\"> </td>\n</tr>\n<tr>\n<td align=\"center\">[LOGO]</td>\n</tr>\n<tr>\n<td height=\"20\"> </td>\n</tr>\n<tr>\n<td>\n<p style=\"text-align: center; margin: 0; font-family: Helvetica, Arial, sans-serif; font-size: 26px; color: #222222;\">Hello [NAME]</p>\n</td>\n</tr>\n<tr>\n<td align=\"center\"><img style=\"width: 250px;\" src=\"[SITEURL]/assets/images/line.png\" alt=\"line\" width=\"251\" height=\"43\" /></td>\n</tr>\n<tr>\n<td height=\"30\"> </td>\n</tr>\n<tr>\n<td class=\"container-padding content\" style=\"background-color: #ffffff; padding: 12px 24px 12px 24px;\" align=\"left\">\nYour payment has been completed successfuly.\n<br />\n\n<table>\n<tbody>\n<tr>\n<td style=\"width: 120px;\"><strong>Membership:</strong></td>\n<td>[ITEMNAME]</td>\n</tr>\n<tr>\n<td><strong>Discount:</strong></td>\n<td>[COUPON]</td>\n</tr>\n<tr>\n<td><strong>Vat/Tax:</strong></td>\n<td>[TAX]</td>\n</tr>\n<tr>\n<td><strong>Price:</strong></td>\n<td>[PRICE]</td>\n</tr>\n<tr>\n<td><strong>Processor:</strong></td>\n<td>[PP]</td>\n</tr>\n</tbody>\n</table>\n\n</td>\n</tr>\n<tr>\n<td height=\"65\"> </td>\n</tr>\n<tr>\n<td style=\"border-bottom: 1px solid #DDDDDD;\"> </td>\n</tr>\n<tr>\n<td height=\"25\"> </td>\n</tr>\n<tr>\n<td style=\"text-align: center;\" align=\"center\">\n<table border=\"0\" width=\"95%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td style=\"font-family: Helvetica, Arial, sans-serif;\" align=\"left\" valign=\"top\">\n\n<p style=\"text-align: left; color: #999999; font-size: 12px; font-weight: normal; line-height: 20px;\">This email is sent to you directly from <a href=\"[SITEURL]\">[COMPANY]</a> The information above is gathered from the user input. <br /> ©[DATE] <a href=\"[SITEURL]\">[COMPANY]</a>. All rights reserved.</p>\n\n</td>\n<td width=\"30\"> </td>\n<td valign=\"top\" width=\"52\"><a target=\"_blank\" href=\"http://facebook.com/[FB]\"><img style=\"width: 52px;\" src=\"[SITEURL]/assets/images/facebook.png\" alt=\"facebook icon\" width=\"52\" height=\"53\" /></a></td>\n<td width=\"16\"> </td>\n<td valign=\"top\" width=\"52\"><a target=\"_blank\" href=\"http://twitter.com/[TW]\"><img style=\"width: 52px;\" src=\"[SITEURL]/assets/images/twitter.png\" alt=\"twitter icon\" width=\"52\" height=\"53\" /></a></td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n</tbody>\n</table>\n<p> </p>','mailer','payCompleteUser');

INSERT INTO `email_templates`(`id`,`name`,`subject`,`help`,`body`,`type`,`typeid`) VALUES 
(13,'Membership Expired','Membership Has Expired','This template is used to notify user when membership is about to expire a day before. ','<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#F0F0F0\">\n<tbody>\n<tr>\n<td style=\"background-color: #ffffff;\" align=\"center\" valign=\"top\" bgcolor=\"#ffffff\"><br />\n<table style=\"width: 100%px; max-width: 600px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n<tbody>\n<tr>\n<td height=\"30\"> </td>\n</tr>\n<tr>\n<td align=\"center\">[LOGO]</td>\n</tr>\n<tr>\n<td height=\"20\"> </td>\n</tr>\n<tr>\n<td>\n<p style=\"text-align: center; margin: 0; font-family: Helvetica, Arial, sans-serif; font-size: 26px; color: #222222;\">Hello [NAME]</p>\n</td>\n</tr>\n<tr>\n<td align=\"center\"><img style=\"width: 250px;\" src=\"[SITEURL]/assets/images/line.png\" alt=\"line\" width=\"251\" height=\"43\" /></td>\n</tr>\n<tr>\n<td height=\"30\"> </td>\n</tr>\n<tr>\n<td class=\"container-padding content\" style=\"background-color: #ffffff; padding: 12px 24px 12px 24px;\" align=\"left\">\nYour membership access will soon expiere\n<br />\n\n<table>\n<tbody>\n<tr>\n<td style=\"width: 120px;\"><strong>Membership:</strong></td>\n<td>[ITEMNAME]</td>\n</tr>\n<tr>\n<td><strong>Expire:</strong></td>\n<td>[EXPIRE]</td>\n</tr>\n</tbody>\n</table>\n\n</td>\n</tr>\n<tr>\n<td height=\"65\"> </td>\n</tr>\n<tr>\n<td style=\"border-bottom: 1px solid #DDDDDD;\"> </td>\n</tr>\n<tr>\n<td height=\"25\"> </td>\n</tr>\n<tr>\n<td style=\"text-align: center;\" align=\"center\">\n<table border=\"0\" width=\"95%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td style=\"font-family: Helvetica, Arial, sans-serif;\" align=\"left\" valign=\"top\">\n\n<p style=\"text-align: left; color: #999999; font-size: 12px; font-weight: normal; line-height: 20px;\">This email is sent to you directly from <a href=\"[SITEURL]\">[COMPANY]</a> The information above is gathered from the user input. <br /> ©[DATE] <a href=\"[SITEURL]\">[COMPANY]</a>. All rights reserved.</p>\n\n</td>\n<td width=\"30\"> </td>\n<td valign=\"top\" width=\"52\"><a target=\"_blank\" href=\"http://facebook.com/[FB]\"><img style=\"width: 52px;\" src=\"[SITEURL]/assets/images/facebook.png\" alt=\"facebook icon\" width=\"52\" height=\"53\" /></a></td>\n<td width=\"16\"> </td>\n<td valign=\"top\" width=\"52\"><a target=\"_blank\" href=\"http://twitter.com/[TW]\"><img style=\"width: 52px;\" src=\"[SITEURL]/assets/images/twitter.png\" alt=\"twitter icon\" width=\"52\" height=\"53\" /></a></td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n</tbody>\n</table>','mailer','memExpired');

--
-- Table structure for table `gateways`
--

DROP TABLE IF EXISTS `gateways`;
CREATE TABLE IF NOT EXISTS `gateways` (
  `id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `displayname` varchar(50) NOT NULL,
  `dir` varchar(30) NOT NULL,
  `live` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `extra_txt` varchar(120) DEFAULT NULL,
  `extra_txt2` varchar(120) DEFAULT NULL,
  `extra_txt3` varchar(120) DEFAULT NULL,
  `extra` varchar(120) NOT NULL,
  `extra2` varchar(120) DEFAULT NULL,
  `extra3` varchar(120) DEFAULT NULL,
  `is_recurring` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gateways`
--

INSERT INTO `gateways` (`id`, `name`, `displayname`, `dir`, `live`, `extra_txt`, `extra_txt2`, `extra_txt3`, `extra`, `extra2`, `extra3`, `is_recurring`, `active`) VALUES
(1, 'paypal', 'PayPal', 'paypal', 1, 'Paypal Email Address', 'Currency Code', 'Not in Use', 'webmaster@wojoscripts.com', 'CAD', '', 1, 1),
(2, 'skrill', 'Skrill', 'skrill', 1, 'Skrill Email Address', 'Currency Code', 'Secret Passphrase', 'moneybookers@address.com', 'EUR', 'mypassphrase', 1, 1),
(3, 'stripe', 'Stripe', 'stripe', 1, 'Stripe Secret Key', 'Currency Code', '', 'sk_test_6sDE6weBXgEuHbrjZKyG5MlQ', 'CAD', 'pk_test_vRosykAcmL59P2r7H9hziwrg', 1, 1),
(4, 'payfast', 'PayFast', 'payfast', 1, 'Merchant ID', 'Merchant Key', 'PassPhrase', '', '', '', 0, 1),
(6, 'ideal', 'iDeal', 'ideal', 1, 'API Key', 'Currency Code', 'Not in Use', 'test_uFQUaDAjAygbhcpMN95DJdsVkDDKrJ', 'EUR', NULL, 0, 1),
(7, 'anet', 'Authorize.net', 'anet', 1, 'API Login Id', 'MD5 Hash Key', 'Transaction Key', '9KDgMm2mw46V', 'Simon', '5wek3X3DX5e39YAQ', 0, 1),
(9, 'offline', 'Offline', 'offline', 1, 'Currency Code', 'Not in Use', 'Not in Use', 'CAD', '', '', 0, 1);

--
-- Table structure for table `memberships`
--

DROP TABLE IF EXISTS `memberships`;
CREATE TABLE IF NOT EXISTS `memberships` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` text,
  `price` decimal(12,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `days` smallint(2) UNSIGNED NOT NULL DEFAULT '0',
  `period` varchar(1) NOT NULL DEFAULT 'D',
  `recurring` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `thumb` varchar(40) DEFAULT NULL,
  `private` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(80) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `body` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `author` varchar(55) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `txn_id` varchar(50) DEFAULT NULL,
  `membership_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `rate_amount` decimal(12,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `tax` decimal(12,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `coupon` decimal(12,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `total` decimal(12,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `currency` varchar(4) DEFAULT NULL,
  `pp` varchar(20) NOT NULL DEFAULT 'Stripe',
  `ip` varbinary(16) DEFAULT '000.000.000.000',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_membership` (`membership_id`),
  KEY `idx_user` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `privileges`
--

DROP TABLE IF EXISTS `privileges`;
CREATE TABLE IF NOT EXISTS `privileges` (
  `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(60) DEFAULT NULL,
  `mode` varchar(8) NOT NULL,
  `type` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `privileges`
--

INSERT INTO `privileges` (`id`, `code`, `name`, `description`, `mode`, `type`) VALUES
(1, 'manage_users', 'Manage Users', 'Permission to add/edit/delete users', 'manage', 'Users'),
(2, 'manage_files', 'Manage Files', 'Permission to access File Manager', 'manage', 'Files'),
(3, 'manage_pages', 'Manage Pages', 'Permission to Add/edit/delete pages', 'manage', 'Pages'),
(4, 'manage_menus', 'Manage Menus', 'Permission to Add/edit and delete menus', 'manage', 'Menus'),
(5, 'manage_email', 'Manage Email Templates', 'Permission to modify email templates', 'manage', 'Emails'),
(6, 'manage_languages', 'Manage Language Phrases', 'Permission to modify language phrases', 'manage', 'Languages'),
(7, 'manage_backup', 'Manage Database Backups', 'Permission to create backups and restore', 'manage', 'Backups'),
(8, 'manage_memberships', 'Manage Memberships', 'Permission to manage memberships', 'manage', 'Memberships'),
(9, 'edit_user', 'Edit Users', 'Permission to edit user', 'edit', 'Users'),
(10, 'add_user', 'Add User', 'Permission to add users', 'add', 'Users'),
(11, 'delete_user', 'Delete Users', 'Permission to delete users', 'delete', 'Users'),
(12, 'manage_coupons', 'Manage Coupons', 'Permission to Add/Edit and delete coupons', 'manage', 'Coupons'),
(13, 'manage_fields', 'Mange Fileds', 'Permission to Add/edit and delete custom fields', 'manage', 'Fields'),
(14, 'manage_news', 'Manage News', 'Permission to Add/edit and delete news', 'manage', 'News'),
(15, 'manage_newsletter', 'Manage Newsletter', 'Permission to send newsletter and emails', 'manage', 'Newsletter');

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` smallint(4) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `icon` varchar(20) DEFAULT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `code`, `icon`, `name`, `description`) VALUES
(1, 'owner', 'badge', 'Site Owner', 'Site Owner is the owner of the site, has all privileges and could not be removed.'),
(2, 'staff', 'trophy', 'Staff Member', 'The "Staff" members  is required to assist the Owner, has different privileges and may be created by Site Owner.'),
(3, 'editor', 'note', 'Editor', 'The &#34;Editor&#34; is required to assist the Staff Members, has different privileges and may be created by Site Owner.');

--
-- Table structure for table `role_privileges`
--

DROP TABLE IF EXISTS `role_privileges`;
CREATE TABLE IF NOT EXISTS `role_privileges` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `rid` int(6) UNSIGNED NOT NULL DEFAULT '0',
  `pid` int(6) UNSIGNED NOT NULL DEFAULT '0',
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `idx` (`rid`,`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role_privileges`
--

INSERT INTO `role_privileges` (`id`, `rid`, `pid`, `active`) VALUES
(1, 1, 1, 1),
(2, 2, 1, 1),
(3, 3, 1, 0),
(4, 1, 2, 1),
(5, 2, 2, 1),
(6, 3, 2, 1),
(7, 1, 3, 1),
(8, 2, 3, 1),
(9, 3, 3, 1),
(10, 1, 4, 1),
(11, 2, 4, 1),
(12, 3, 4, 1),
(13, 1, 5, 1),
(14, 2, 5, 1),
(15, 3, 5, 0),
(16, 1, 6, 1),
(17, 2, 6, 1),
(18, 3, 6, 1),
(19, 1, 7, 1),
(20, 2, 7, 1),
(21, 3, 7, 0),
(22, 1, 8, 1),
(23, 2, 8, 1),
(24, 3, 8, 0),
(25, 1, 9, 1),
(26, 2, 9, 1),
(27, 3, 9, 0),
(28, 1, 10, 1),
(29, 2, 10, 1),
(30, 3, 10, 0),
(31, 1, 11, 1),
(32, 2, 11, 1),
(33, 3, 11, 0),
(34, 1, 12, 1),
(35, 2, 12, 1),
(36, 3, 12, 1),
(37, 1, 13, 1),
(38, 2, 13, 1),
(39, 3, 13, 0),
(40, 1, 14, 1),
(41, 2, 14, 1),
(42, 3, 14, 1),
(43, 1, 15, 1),
(44, 2, 15, 1),
(45, 3, 15, 0);

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `company` varchar(50) NOT NULL,
  `site_email` varchar(80) NOT NULL,
  `psite_email` varchar(80) DEFAULT NULL,
  `site_dir` varchar(100) DEFAULT NULL,
  `reg_allowed` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `reg_verify` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `notify_admin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `auto_verify` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `perpage` tinyint(1) unsigned NOT NULL DEFAULT '12',
  `backup` varchar(60) DEFAULT NULL,
  `logo` varchar(40) DEFAULT NULL,
  `plogo` varchar(40) DEFAULT NULL,
  `currency` varchar(4) DEFAULT NULL,
  `enable_tax` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `long_date` varchar(50) DEFAULT NULL,
  `short_date` varchar(50) DEFAULT NULL,
  `time_format` varchar(20) DEFAULT NULL,
  `dtz` varchar(80) DEFAULT NULL,
  `locale` varchar(20) DEFAULT NULL,
  `lang` varchar(20) DEFAULT NULL,
  `weekstart` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `inv_info` text,
  `inv_note` text,
  `offline_info` text,
  `social_media` blob,
  `enable_dmembership` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `dmembership` smallint(3) unsigned NOT NULL DEFAULT '0',
  `file_dir` varchar(100) DEFAULT NULL,
  `mailer` enum('PHP','SMTP','SMAIL') NOT NULL DEFAULT 'PHP',
  `smtp_host` varchar(100) DEFAULT NULL,
  `smtp_user` varchar(50) DEFAULT NULL,
  `smtp_pass` varchar(50) DEFAULT NULL,
  `smtp_port` varchar(6) DEFAULT NULL,
  `is_ssl` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sendmail` varchar(150) DEFAULT NULL,
  `wojon` decimal(4,2) unsigned NOT NULL DEFAULT '1.00',
  `wojov` decimal(4,2) unsigned NOT NULL DEFAULT '1.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `company`, `site_email`, `psite_email`, `site_dir`, `reg_allowed`, `reg_verify`, `notify_admin`, `auto_verify`, `perpage`, `backup`, `logo`, `plogo`, `currency`, `enable_tax`, `long_date`, `short_date`, `time_format`, `dtz`, `locale`, `lang`, `weekstart`, `inv_info`, `inv_note`, `offline_info`, `social_media`, `enable_dmembership`, `dmembership`, `file_dir`, `mailer`, `smtp_host`, `smtp_user`, `smtp_pass`, `smtp_port`, `is_ssl`, `sendmail`, `wojon`, `wojov`) VALUES
(1, '', '', '', '', 1, 1, 1, 1, 12, '20-Aug-2016_16-19-03.sql', 'logo.png', 'print_logo.png', 'CAD', 1, 'MMMM dd, yyyy hh:mm a', 'dd MMM yyyy', 'HH:mm', 'America/Toronto', 'en_CA', 'en', 0, '<p><b>ABC Company Pty Ltd</b><br>123 Burke Street, Toronto ON, CANADA<br>Tel : (416) 1234-5678, Fax : (416) 1234-5679, Email : sales@abc-company.com<br>Web Site : www.abc-company.com</p>', '<p>TERMS &amp; CONDITIONS<br>1. Interest may be levied on overdue accounts. <br>2. Goods sold are not returnable or refundable</p>', '<p>Instructions for offline payments...</p>', 0x7b2266616365626f6f6b223a2266616365626f6f6b5f70616765222c2274776974746572223a22747769747465725f70616765227d, 0, 1, '/home/username/downloads/', 'PHP', '', '', '', '0', 0, 'sendmail path', '1.00', '4.10');

--
-- Table structure for table `trash`
--

DROP TABLE IF EXISTS `trash`;
CREATE TABLE IF NOT EXISTS `trash` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent` varchar(15) DEFAULT NULL,
  `parent_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `type` varchar(15) DEFAULT NULL,
  `dataset` blob,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `fname` varchar(60) DEFAULT NULL,
  `lname` varchar(60) DEFAULT NULL,
  `membership_id` int(2) UNSIGNED NOT NULL DEFAULT '0',
  `mem_expire` varchar(20) DEFAULT NULL,
  `salt` varchar(25) NOT NULL,
  `hash` varchar(70) NOT NULL,
  `token` varchar(40) NOT NULL DEFAULT '0',
  `userlevel` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `type` varchar(10) NOT NULL DEFAULT 'member',
  `trial_used` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `email` varchar(60) NOT NULL,
  `lastlogin` datetime DEFAULT NULL,
  `lastip` varbinary(16) DEFAULT '000.000.000.000',
  `avatar` varchar(50) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `country` varchar(4) DEFAULT NULL,
  `notes` tinytext,
  `newsletter` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `stripe_cus` varchar(100) DEFAULT NULL,
  `custom_fields` varchar(200) DEFAULT NULL,
  `active` enum('y','n','t','b') NOT NULL DEFAULT 'n',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `user_custom_fields`
--

DROP TABLE IF EXISTS `user_custom_fields`;
CREATE TABLE `user_custom_fields` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `field_id` int(11) unsigned NOT NULL DEFAULT '0',
  `field_name` varchar(40) DEFAULT NULL,
  `field_value` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_user` (`user_id`),
  KEY `idx_field` (`field_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `user_memberships`
--

DROP TABLE IF EXISTS `user_memberships`;
CREATE TABLE IF NOT EXISTS `user_memberships` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tid` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `uid` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `mid` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `activated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `expire` timestamp NULL DEFAULT NULL,
  `recurring` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0 = expired, 1 = active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
