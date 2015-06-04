-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2015 at 03:51 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `partneralliance`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`c_id`, `category_name`) VALUES
(1, 'Set1');

-- --------------------------------------------------------

--
-- Table structure for table `category_question`
--

CREATE TABLE IF NOT EXISTS `category_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `category_question`
--

INSERT INTO `category_question` (`id`, `c_id`, `question_id`, `order`, `created_date`) VALUES
(1, 1, 6, 0, '2015-06-03'),
(2, 1, 7, 1, '2015-06-03'),
(3, 1, 8, 2, '2015-06-03'),
(4, 1, 10, 3, '2015-06-03'),
(5, 1, 9, 4, '2015-06-03'),
(6, 1, 12, 5, '2015-06-03'),
(7, 1, 5, 6, '2015-06-03');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CompanyId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `Rating` tinyint(4) NOT NULL,
  `DateTime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `comment_status`
--

CREATE TABLE IF NOT EXISTS `comment_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `comapny_id` int(11) NOT NULL,
  `status` tinyint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `companyinfo`
--

CREATE TABLE IF NOT EXISTS `companyinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CompanyName` varchar(255) NOT NULL,
  `CompanyWebsite` varchar(255) NOT NULL,
  `CompanyRating` float DEFAULT '0',
  `investment_status` varchar(255) DEFAULT NULL,
  `CompanyType` varchar(255) NOT NULL,
  `FinancingStatus` varchar(255) NOT NULL,
  `valuation` varchar(255) NOT NULL,
  `ThemeAlign` varchar(255) NOT NULL,
  `CompanySumm` text NOT NULL,
  `ValueProposition` text NOT NULL,
  `BicInvestment` varchar(255) NOT NULL,
  `InvestmentUSD` varchar(255) NOT NULL,
  `InvestmentType` varchar(255) NOT NULL,
  `EquityPosition` varchar(255) NOT NULL,
  `CloseDate` varchar(255) NOT NULL,
  `CompanyProgress` text NOT NULL,
  `DevelopmentPlans` text NOT NULL,
  `CustomerTarget` text NOT NULL,
  `Source` varchar(255) NOT NULL,
  `BicLead` varchar(255) NOT NULL,
  `LastUpdated` datetime NOT NULL,
  `approved_view_status` tinyint(5) NOT NULL DEFAULT '0',
  `Status` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `companyinfo`
--

INSERT INTO `companyinfo` (`id`, `CompanyName`, `CompanyWebsite`, `CompanyRating`, `investment_status`, `CompanyType`, `FinancingStatus`, `valuation`, `ThemeAlign`, `CompanySumm`, `ValueProposition`, `BicInvestment`, `InvestmentUSD`, `InvestmentType`, `EquityPosition`, `CloseDate`, `CompanyProgress`, `DevelopmentPlans`, `CustomerTarget`, `Source`, `BicLead`, `LastUpdated`, `approved_view_status`, `Status`) VALUES
(1, 'Robin', 'www.robinpowered.com', 6, 'Approved', 'private', 'private', '5000000', 'Workplace of the Future', 'Great team. Highly Flexible, Innovative and Creative', 'Low entry barrier', 'yes', '250000', 'series A', '5', '05/01/2015', 'Around 400 rooms being served; Getting ready for pilots with new customers.', 'Do successful pilots', 'SMBs', 'PlugNPlayTechCenter.com', 'Greg', '2015-05-26 21:53:38', 0, '1'),
(2, 'KnightScope', 'www.knightscope.com', 0, 'Approved', 'private', 'private', '100000000', 'Robotics', 'KnightScope', '', 'yes', '650000', 'series A', '5', '03/12/2015', '', '', '', 'PlugNPlayTechCenter.com', '', '2015-05-27 00:50:02', 1, '1'),
(3, 'CliQr', 'www.cliqr.com', 6, 'Approved', 'private', 'private', '10000000', 'Cloud', 'CliQr', '', 'no', '', '', '', '', '', '', '', 'Nats', 'Nats', '2015-05-27 00:47:10', 1, '1'),
(9, 'Wipro', 'www.wipro.com', 0, 'Not Available', '', '', '', '', 'test', '', '', '', '', '', '', '', '', '', '', '', '2015-05-28 16:56:43', 0, '1'),
(10, 'TATA', 'www.tata.com', 0, 'Not Available', '', '', '', '', 'testing', '', '', '', '', '', '', '', '', '', '', '', '2015-05-28 17:07:02', 0, '1');

-- --------------------------------------------------------

--
-- Table structure for table `company_history`
--

CREATE TABLE IF NOT EXISTS `company_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `CompanyName` varchar(255) NOT NULL,
  `CompanyWebsite` varchar(255) NOT NULL,
  `CompanyRating` float DEFAULT '0',
  `investment_status` varchar(255) DEFAULT NULL,
  `CompanyType` varchar(255) NOT NULL,
  `FinancingStatus` varchar(255) NOT NULL,
  `valuation` varchar(255) NOT NULL,
  `ThemeAlign` varchar(255) NOT NULL,
  `CompanySumm` text NOT NULL,
  `ValueProposition` text NOT NULL,
  `BicInvestment` varchar(255) NOT NULL,
  `InvestmentUSD` varchar(255) NOT NULL,
  `InvestmentType` varchar(255) NOT NULL,
  `EquityPosition` varchar(255) NOT NULL,
  `CloseDate` varchar(255) NOT NULL,
  `CompanyProgress` text NOT NULL,
  `DevelopmentPlans` text NOT NULL,
  `CustomerTarget` text NOT NULL,
  `Source` varchar(255) NOT NULL,
  `BicLead` varchar(255) NOT NULL,
  `updated_time` datetime NOT NULL,
  `edited_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `company_history`
--

INSERT INTO `company_history` (`id`, `company_id`, `CompanyName`, `CompanyWebsite`, `CompanyRating`, `investment_status`, `CompanyType`, `FinancingStatus`, `valuation`, `ThemeAlign`, `CompanySumm`, `ValueProposition`, `BicInvestment`, `InvestmentUSD`, `InvestmentType`, `EquityPosition`, `CloseDate`, `CompanyProgress`, `DevelopmentPlans`, `CustomerTarget`, `Source`, `BicLead`, `updated_time`, `edited_by`) VALUES
(1, 1, '', '', 0, NULL, '', '', '', '', '', '', '', '', '', '', '', '', 'Do successful pilots', '', '', '', '2015-05-26 21:51:52', 1),
(2, 1, '', '', 0, NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', 'SMBs', '', '', '2015-05-26 21:52:04', 1),
(3, 1, '', '', 0, NULL, '', '', '', '', '', '', '', '', '', '', '', 'Around 400 rooms being served; Getting ready for pilots with new customers.', '', '', '', '', '2015-05-26 21:52:46', 1),
(4, 1, '', '', 0, NULL, '', '', '', '', 'Great team. Highly Flexible, Innovative and Creative', '', '', '', '', '', '', '', '', '', '', '', '2015-05-26 21:53:14', 1),
(5, 1, '', '', 0, NULL, '', '', '', '', '', 'Low entry barrier', '', '', '', '', '', '', '', '', '', '', '2015-05-26 21:53:25', 1),
(6, 1, 'Robin', 'www.robinpowered.com', 6, NULL, 'private', 'private', '5000000', 'Workplace of the Future', '', '', 'yes', '250000', 'series A', '5', '05/01/2015', '', '', '', 'PlugNPlayTechCenter.com', 'Greg', '2015-05-26 21:53:38', 1),
(7, 3, '', '', 6, NULL, 'private', 'private', '10000000', 'Cloud', '', '', 'no', '', '', '', '', '', '', '', 'Nats', 'Nats', '2015-05-27 00:47:10', 1),
(8, 2, '', '', 0, NULL, '', '', '', '', '', '', 'yes', '650000', 'series A', '5', '03/12/2015', '', '', '', '', '', '2015-05-27 00:49:13', 1),
(9, 2, '', '', 0, NULL, 'private', 'private', '100000000', 'Robotics', '', '', '', '', '', '', '', '', '', '', 'PlugNPlayTechCenter.com', '', '2015-05-27 00:50:02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `company_log`
--

CREATE TABLE IF NOT EXISTS `company_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `history_id` int(11) DEFAULT NULL,
  `field_name` varchar(255) DEFAULT NULL,
  `field_value` text,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `company_users`
--

CREATE TABLE IF NOT EXISTS `company_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `company_users`
--

INSERT INTO `company_users` (`id`, `company_id`, `user_id`, `created_date`) VALUES
(1, 1, 2, '2015-05-14 07:36:59'),
(2, 2, 7, '2015-05-26 22:47:22'),
(3, 3, 8, '2015-05-27 00:45:46'),
(4, 4, 9, '2015-05-28 14:44:47'),
(5, 5, 10, '2015-05-28 15:04:44'),
(6, 6, 11, '2015-05-28 16:04:02'),
(7, 7, 12, '2015-05-28 16:08:24'),
(8, 8, 13, '2015-05-28 16:35:41'),
(9, 9, 14, '2015-05-28 16:56:43'),
(10, 10, 15, '2015-05-28 17:07:02');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `iso_code_2` varchar(2) NOT NULL,
  `iso_code_3` varchar(3) NOT NULL,
  `address_format` text NOT NULL,
  `postcode_required` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=252 ;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`country_id`, `name`, `iso_code_2`, `iso_code_3`, `address_format`, `postcode_required`, `status`) VALUES
(1, 'Afghanistan', 'AF', 'AFG', '', 0, 1),
(2, 'Albania', 'AL', 'ALB', '', 0, 1),
(3, 'Algeria', 'DZ', 'DZA', '', 0, 1),
(4, 'American Samoa', 'AS', 'ASM', '', 0, 1),
(5, 'Andorra', 'AD', 'AND', '', 0, 1),
(6, 'Angola', 'AO', 'AGO', '', 0, 1),
(7, 'Anguilla', 'AI', 'AIA', '', 0, 1),
(8, 'Antarctica', 'AQ', 'ATA', '', 0, 1),
(9, 'Antigua and Barbuda', 'AG', 'ATG', '', 0, 1),
(10, 'Argentina', 'AR', 'ARG', '', 0, 1),
(11, 'Armenia', 'AM', 'ARM', '', 0, 1),
(12, 'Aruba', 'AW', 'ABW', '', 0, 1),
(13, 'Australia', 'AU', 'AUS', '', 0, 1),
(14, 'Austria', 'AT', 'AUT', '', 0, 1),
(15, 'Azerbaijan', 'AZ', 'AZE', '', 0, 1),
(16, 'Bahamas', 'BS', 'BHS', '', 0, 1),
(17, 'Bahrain', 'BH', 'BHR', '', 0, 1),
(18, 'Bangladesh', 'BD', 'BGD', '', 0, 1),
(19, 'Barbados', 'BB', 'BRB', '', 0, 1),
(20, 'Belarus', 'BY', 'BLR', '', 0, 1),
(21, 'Belgium', 'BE', 'BEL', '{firstname} {lastname}\r\n{company}\r\n{address_1}\r\n{address_2}\r\n{postcode} {city}\r\n{country}', 0, 1),
(22, 'Belize', 'BZ', 'BLZ', '', 0, 1),
(23, 'Benin', 'BJ', 'BEN', '', 0, 1),
(24, 'Bermuda', 'BM', 'BMU', '', 0, 1),
(25, 'Bhutan', 'BT', 'BTN', '', 0, 1),
(26, 'Bolivia', 'BO', 'BOL', '', 0, 1),
(27, 'Bosnia and Herzegovina', 'BA', 'BIH', '', 0, 1),
(28, 'Botswana', 'BW', 'BWA', '', 0, 1),
(29, 'Bouvet Island', 'BV', 'BVT', '', 0, 1),
(30, 'Brazil', 'BR', 'BRA', '', 0, 1),
(31, 'British Indian Ocean Territory', 'IO', 'IOT', '', 0, 1),
(32, 'Brunei Darussalam', 'BN', 'BRN', '', 0, 1),
(33, 'Bulgaria', 'BG', 'BGR', '', 0, 1),
(34, 'Burkina Faso', 'BF', 'BFA', '', 0, 1),
(35, 'Burundi', 'BI', 'BDI', '', 0, 1),
(36, 'Cambodia', 'KH', 'KHM', '', 0, 1),
(37, 'Cameroon', 'CM', 'CMR', '', 0, 1),
(38, 'Canada', 'CA', 'CAN', '', 0, 1),
(39, 'Cape Verde', 'CV', 'CPV', '', 0, 1),
(40, 'Cayman Islands', 'KY', 'CYM', '', 0, 1),
(41, 'Central African Republic', 'CF', 'CAF', '', 0, 1),
(42, 'Chad', 'TD', 'TCD', '', 0, 1),
(43, 'Chile', 'CL', 'CHL', '', 0, 1),
(44, 'China', 'CN', 'CHN', '', 0, 1),
(45, 'Christmas Island', 'CX', 'CXR', '', 0, 1),
(46, 'Cocos (Keeling) Islands', 'CC', 'CCK', '', 0, 1),
(47, 'Colombia', 'CO', 'COL', '', 0, 1),
(48, 'Comoros', 'KM', 'COM', '', 0, 1),
(49, 'Congo', 'CG', 'COG', '', 0, 1),
(50, 'Cook Islands', 'CK', 'COK', '', 0, 1),
(51, 'Costa Rica', 'CR', 'CRI', '', 0, 1),
(52, 'Cote D''Ivoire', 'CI', 'CIV', '', 0, 1),
(53, 'Croatia', 'HR', 'HRV', '', 0, 1),
(54, 'Cuba', 'CU', 'CUB', '', 0, 1),
(55, 'Cyprus', 'CY', 'CYP', '', 0, 1),
(56, 'Czech Republic', 'CZ', 'CZE', '', 0, 1),
(57, 'Denmark', 'DK', 'DNK', '', 0, 1),
(58, 'Djibouti', 'DJ', 'DJI', '', 0, 1),
(59, 'Dominica', 'DM', 'DMA', '', 0, 1),
(60, 'Dominican Republic', 'DO', 'DOM', '', 0, 1),
(61, 'East Timor', 'TL', 'TLS', '', 0, 1),
(62, 'Ecuador', 'EC', 'ECU', '', 0, 1),
(63, 'Egypt', 'EG', 'EGY', '', 0, 1),
(64, 'El Salvador', 'SV', 'SLV', '', 0, 1),
(65, 'Equatorial Guinea', 'GQ', 'GNQ', '', 0, 1),
(66, 'Eritrea', 'ER', 'ERI', '', 0, 1),
(67, 'Estonia', 'EE', 'EST', '', 0, 1),
(68, 'Ethiopia', 'ET', 'ETH', '', 0, 1),
(69, 'Falkland Islands (Malvinas)', 'FK', 'FLK', '', 0, 1),
(70, 'Faroe Islands', 'FO', 'FRO', '', 0, 1),
(71, 'Fiji', 'FJ', 'FJI', '', 0, 1),
(72, 'Finland', 'FI', 'FIN', '', 0, 1),
(74, 'France, Metropolitan', 'FR', 'FRA', '{firstname} {lastname}\r\n{company}\r\n{address_1}\r\n{address_2}\r\n{postcode} {city}\r\n{country}', 1, 1),
(75, 'French Guiana', 'GF', 'GUF', '', 0, 1),
(76, 'French Polynesia', 'PF', 'PYF', '', 0, 1),
(77, 'French Southern Territories', 'TF', 'ATF', '', 0, 1),
(78, 'Gabon', 'GA', 'GAB', '', 0, 1),
(79, 'Gambia', 'GM', 'GMB', '', 0, 1),
(80, 'Georgia', 'GE', 'GEO', '', 0, 1),
(81, 'Germany', 'DE', 'DEU', '{company}\r\n{firstname} {lastname}\r\n{address_1}\r\n{address_2}\r\n{postcode} {city}\r\n{country}', 1, 1),
(82, 'Ghana', 'GH', 'GHA', '', 0, 1),
(83, 'Gibraltar', 'GI', 'GIB', '', 0, 1),
(84, 'Greece', 'GR', 'GRC', '', 0, 1),
(85, 'Greenland', 'GL', 'GRL', '', 0, 1),
(86, 'Grenada', 'GD', 'GRD', '', 0, 1),
(87, 'Guadeloupe', 'GP', 'GLP', '', 0, 1),
(88, 'Guam', 'GU', 'GUM', '', 0, 1),
(89, 'Guatemala', 'GT', 'GTM', '', 0, 1),
(90, 'Guinea', 'GN', 'GIN', '', 0, 1),
(91, 'Guinea-Bissau', 'GW', 'GNB', '', 0, 1),
(92, 'Guyana', 'GY', 'GUY', '', 0, 1),
(93, 'Haiti', 'HT', 'HTI', '', 0, 1),
(94, 'Heard and Mc Donald Islands', 'HM', 'HMD', '', 0, 1),
(95, 'Honduras', 'HN', 'HND', '', 0, 1),
(96, 'Hong Kong', 'HK', 'HKG', '', 0, 1),
(97, 'Hungary', 'HU', 'HUN', '', 0, 1),
(98, 'Iceland', 'IS', 'ISL', '', 0, 1),
(99, 'India', 'IN', 'IND', '', 0, 1),
(100, 'Indonesia', 'ID', 'IDN', '', 0, 1),
(101, 'Iran (Islamic Republic of)', 'IR', 'IRN', '', 0, 1),
(102, 'Iraq', 'IQ', 'IRQ', '', 0, 1),
(103, 'Ireland', 'IE', 'IRL', '', 0, 1),
(104, 'Israel', 'IL', 'ISR', '', 0, 1),
(105, 'Italy', 'IT', 'ITA', '', 0, 1),
(106, 'Jamaica', 'JM', 'JAM', '', 0, 1),
(107, 'Japan', 'JP', 'JPN', '', 0, 1),
(108, 'Jordan', 'JO', 'JOR', '', 0, 1),
(109, 'Kazakhstan', 'KZ', 'KAZ', '', 0, 1),
(110, 'Kenya', 'KE', 'KEN', '', 0, 1),
(111, 'Kiribati', 'KI', 'KIR', '', 0, 1),
(112, 'North Korea', 'KP', 'PRK', '', 0, 1),
(113, 'Korea, Republic of', 'KR', 'KOR', '', 0, 1),
(114, 'Kuwait', 'KW', 'KWT', '', 0, 1),
(115, 'Kyrgyzstan', 'KG', 'KGZ', '', 0, 1),
(116, 'Lao People''s Democratic Republic', 'LA', 'LAO', '', 0, 1),
(117, 'Latvia', 'LV', 'LVA', '', 0, 1),
(118, 'Lebanon', 'LB', 'LBN', '', 0, 1),
(119, 'Lesotho', 'LS', 'LSO', '', 0, 1),
(120, 'Liberia', 'LR', 'LBR', '', 0, 1),
(121, 'Libyan Arab Jamahiriya', 'LY', 'LBY', '', 0, 1),
(122, 'Liechtenstein', 'LI', 'LIE', '', 0, 1),
(123, 'Lithuania', 'LT', 'LTU', '', 0, 1),
(124, 'Luxembourg', 'LU', 'LUX', '', 0, 1),
(125, 'Macau', 'MO', 'MAC', '', 0, 1),
(126, 'FYROM', 'MK', 'MKD', '', 0, 1),
(127, 'Madagascar', 'MG', 'MDG', '', 0, 1),
(128, 'Malawi', 'MW', 'MWI', '', 0, 1),
(129, 'Malaysia', 'MY', 'MYS', '', 0, 1),
(130, 'Maldives', 'MV', 'MDV', '', 0, 1),
(131, 'Mali', 'ML', 'MLI', '', 0, 1),
(132, 'Malta', 'MT', 'MLT', '', 0, 1),
(133, 'Marshall Islands', 'MH', 'MHL', '', 0, 1),
(134, 'Martinique', 'MQ', 'MTQ', '', 0, 1),
(135, 'Mauritania', 'MR', 'MRT', '', 0, 1),
(136, 'Mauritius', 'MU', 'MUS', '', 0, 1),
(137, 'Mayotte', 'YT', 'MYT', '', 0, 1),
(138, 'Mexico', 'MX', 'MEX', '', 0, 1),
(139, 'Micronesia, Federated States of', 'FM', 'FSM', '', 0, 1),
(140, 'Moldova, Republic of', 'MD', 'MDA', '', 0, 1),
(141, 'Monaco', 'MC', 'MCO', '', 0, 1),
(142, 'Mongolia', 'MN', 'MNG', '', 0, 1),
(143, 'Montserrat', 'MS', 'MSR', '', 0, 1),
(144, 'Morocco', 'MA', 'MAR', '', 0, 1),
(145, 'Mozambique', 'MZ', 'MOZ', '', 0, 1),
(146, 'Myanmar', 'MM', 'MMR', '', 0, 1),
(147, 'Namibia', 'NA', 'NAM', '', 0, 1),
(148, 'Nauru', 'NR', 'NRU', '', 0, 1),
(149, 'Nepal', 'NP', 'NPL', '', 0, 1),
(150, 'Netherlands', 'NL', 'NLD', '', 0, 1),
(151, 'Netherlands Antilles', 'AN', 'ANT', '', 0, 1),
(152, 'New Caledonia', 'NC', 'NCL', '', 0, 1),
(153, 'New Zealand', 'NZ', 'NZL', '', 0, 1),
(154, 'Nicaragua', 'NI', 'NIC', '', 0, 1),
(155, 'Niger', 'NE', 'NER', '', 0, 1),
(156, 'Nigeria', 'NG', 'NGA', '', 0, 1),
(157, 'Niue', 'NU', 'NIU', '', 0, 1),
(158, 'Norfolk Island', 'NF', 'NFK', '', 0, 1),
(159, 'Northern Mariana Islands', 'MP', 'MNP', '', 0, 1),
(160, 'Norway', 'NO', 'NOR', '', 0, 1),
(161, 'Oman', 'OM', 'OMN', '', 0, 1),
(162, 'Pakistan', 'PK', 'PAK', '', 0, 1),
(163, 'Palau', 'PW', 'PLW', '', 0, 1),
(164, 'Panama', 'PA', 'PAN', '', 0, 1),
(165, 'Papua New Guinea', 'PG', 'PNG', '', 0, 1),
(166, 'Paraguay', 'PY', 'PRY', '', 0, 1),
(167, 'Peru', 'PE', 'PER', '', 0, 1),
(168, 'Philippines', 'PH', 'PHL', '', 0, 1),
(169, 'Pitcairn', 'PN', 'PCN', '', 0, 1),
(170, 'Poland', 'PL', 'POL', '', 0, 1),
(171, 'Portugal', 'PT', 'PRT', '', 0, 1),
(172, 'Puerto Rico', 'PR', 'PRI', '', 0, 1),
(173, 'Qatar', 'QA', 'QAT', '', 0, 1),
(174, 'Reunion', 'RE', 'REU', '', 0, 1),
(175, 'Romania', 'RO', 'ROM', '', 0, 1),
(176, 'Russian Federation', 'RU', 'RUS', '', 0, 1),
(177, 'Rwanda', 'RW', 'RWA', '', 0, 1),
(178, 'Saint Kitts and Nevis', 'KN', 'KNA', '', 0, 1),
(179, 'Saint Lucia', 'LC', 'LCA', '', 0, 1),
(180, 'Saint Vincent and the Grenadines', 'VC', 'VCT', '', 0, 1),
(181, 'Samoa', 'WS', 'WSM', '', 0, 1),
(182, 'San Marino', 'SM', 'SMR', '', 0, 1),
(183, 'Sao Tome and Principe', 'ST', 'STP', '', 0, 1),
(184, 'Saudi Arabia', 'SA', 'SAU', '', 0, 1),
(185, 'Senegal', 'SN', 'SEN', '', 0, 1),
(186, 'Seychelles', 'SC', 'SYC', '', 0, 1),
(187, 'Sierra Leone', 'SL', 'SLE', '', 0, 1),
(188, 'Singapore', 'SG', 'SGP', '', 0, 1),
(189, 'Slovak Republic', 'SK', 'SVK', '{firstname} {lastname}\r\n{company}\r\n{address_1}\r\n{address_2}\r\n{city} {postcode}\r\n{zone}\r\n{country}', 0, 1),
(190, 'Slovenia', 'SI', 'SVN', '', 0, 1),
(191, 'Solomon Islands', 'SB', 'SLB', '', 0, 1),
(192, 'Somalia', 'SO', 'SOM', '', 0, 1),
(193, 'South Africa', 'ZA', 'ZAF', '', 0, 1),
(194, 'South Georgia &amp; South Sandwich Islands', 'GS', 'SGS', '', 0, 1),
(195, 'Spain', 'ES', 'ESP', '', 0, 1),
(196, 'Sri Lanka', 'LK', 'LKA', '', 0, 1),
(197, 'St. Helena', 'SH', 'SHN', '', 0, 1),
(198, 'St. Pierre and Miquelon', 'PM', 'SPM', '', 0, 1),
(199, 'Sudan', 'SD', 'SDN', '', 0, 1),
(200, 'Suriname', 'SR', 'SUR', '', 0, 1),
(201, 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM', '', 0, 1),
(202, 'Swaziland', 'SZ', 'SWZ', '', 0, 1),
(203, 'Sweden', 'SE', 'SWE', '{company}\r\n{firstname} {lastname}\r\n{address_1}\r\n{address_2}\r\n{postcode} {city}\r\n{country}', 1, 1),
(204, 'Switzerland', 'CH', 'CHE', '', 0, 1),
(205, 'Syrian Arab Republic', 'SY', 'SYR', '', 0, 1),
(206, 'Taiwan', 'TW', 'TWN', '', 0, 1),
(207, 'Tajikistan', 'TJ', 'TJK', '', 0, 1),
(208, 'Tanzania, United Republic of', 'TZ', 'TZA', '', 0, 1),
(209, 'Thailand', 'TH', 'THA', '', 0, 1),
(210, 'Togo', 'TG', 'TGO', '', 0, 1),
(211, 'Tokelau', 'TK', 'TKL', '', 0, 1),
(212, 'Tonga', 'TO', 'TON', '', 0, 1),
(213, 'Trinidad and Tobago', 'TT', 'TTO', '', 0, 1),
(214, 'Tunisia', 'TN', 'TUN', '', 0, 1),
(215, 'Turkey', 'TR', 'TUR', '', 0, 1),
(216, 'Turkmenistan', 'TM', 'TKM', '', 0, 1),
(217, 'Turks and Caicos Islands', 'TC', 'TCA', '', 0, 1),
(218, 'Tuvalu', 'TV', 'TUV', '', 0, 1),
(219, 'Uganda', 'UG', 'UGA', '', 0, 1),
(220, 'Ukraine', 'UA', 'UKR', '', 0, 1),
(221, 'United Arab Emirates', 'AE', 'ARE', '', 0, 1),
(222, 'United Kingdom', 'GB', 'GBR', '', 1, 1),
(223, 'United States', 'US', 'USA', '{firstname} {lastname}\r\n{company}\r\n{address_1}\r\n{address_2}\r\n{city}, {zone} {postcode}\r\n{country}', 0, 1),
(224, 'United States Minor Outlying Islands', 'UM', 'UMI', '', 0, 1),
(225, 'Uruguay', 'UY', 'URY', '', 0, 1),
(226, 'Uzbekistan', 'UZ', 'UZB', '', 0, 1),
(227, 'Vanuatu', 'VU', 'VUT', '', 0, 1),
(228, 'Vatican City State (Holy See)', 'VA', 'VAT', '', 0, 1),
(229, 'Venezuela', 'VE', 'VEN', '', 0, 1),
(230, 'Viet Nam', 'VN', 'VNM', '', 0, 1),
(231, 'Virgin Islands (British)', 'VG', 'VGB', '', 0, 1),
(232, 'Virgin Islands (U.S.)', 'VI', 'VIR', '', 0, 1),
(233, 'Wallis and Futuna Islands', 'WF', 'WLF', '', 0, 1),
(234, 'Western Sahara', 'EH', 'ESH', '', 0, 1),
(235, 'Yemen', 'YE', 'YEM', '', 0, 1),
(237, 'Democratic Republic of Congo', 'CD', 'COD', '', 0, 1),
(238, 'Zambia', 'ZM', 'ZMB', '', 0, 1),
(239, 'Zimbabwe', 'ZW', 'ZWE', '', 0, 1),
(240, 'Jersey', 'JE', 'JEY', '', 1, 1),
(241, 'Guernsey', 'GG', 'GGY', '', 1, 1),
(242, 'Montenegro', 'ME', 'MNE', '', 0, 1),
(243, 'Serbia', 'RS', 'SRB', '', 0, 1),
(244, 'Aaland Islands', 'AX', 'ALA', '', 0, 1),
(245, 'Bonaire, Sint Eustatius and Saba', 'BQ', 'BES', '', 0, 1),
(246, 'Curacao', 'CW', 'CUW', '', 0, 1),
(247, 'Palestinian Territory, Occupied', 'PS', 'PSE', '', 0, 1),
(248, 'South Sudan', 'SS', 'SSD', '', 0, 1),
(249, 'St. Barthelemy', 'BL', 'BLM', '', 0, 1),
(250, 'St. Martin (French part)', 'MF', 'MAF', '', 0, 1),
(251, 'Canary Islands', 'IC', 'ICA', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `display_status`
--

CREATE TABLE IF NOT EXISTS `display_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `history_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `status` tinyint(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `display_status`
--

INSERT INTO `display_status` (`id`, `history_id`, `company_id`, `status`) VALUES
(1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text,
  `project_id` int(11) NOT NULL,
  `sender_user_id` int(11) DEFAULT NULL,
  `receiver_user_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `last_updated_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sender_user_id` (`sender_user_id`),
  KEY `receiver_user_id` (`receiver_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(255) DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `hours` float DEFAULT NULL,
  `lead` varchar(255) DEFAULT NULL,
  `description` text,
  `project_status` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_updated_date` datetime DEFAULT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `created_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `question`, `created_date`) VALUES
(1, 'what is your branch', '2015-06-02'),
(2, 'Tell me about hobbies', '2015-06-02'),
(3, 'what is your Gender', '2015-06-02'),
(4, 'What is your qualification', '2015-06-02'),
(5, 'what is your technology', '2015-06-02'),
(6, ' Trace the odd data type', '2015-06-02'),
(7, 'Which of the folowing are valid float values', '2015-06-02'),
(8, 'Which of following are compound data type', '2015-06-02'),
(9, ' Identify the invalid identifier', '2015-06-02'),
(10, 'The left association operator % is used in PHP for', '2015-06-02'),
(11, ' Trace the function that does continue the script execution even if the file inclusion fails', '2015-06-02'),
(12, 'Which of the following functions require the allow-url-fopen must be enabled', '2015-06-02');

-- --------------------------------------------------------

--
-- Table structure for table `question_dependency`
--

CREATE TABLE IF NOT EXISTS `question_dependency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  `dependent_question_id` int(11) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `question_dependency`
--

INSERT INTO `question_dependency` (`id`, `question_id`, `option_id`, `dependent_question_id`, `created_date`) VALUES
(1, 6, 12, 8, '2015-06-03'),
(2, 6, 13, 8, '2015-06-03'),
(3, 7, 14, 10, '2015-06-03'),
(4, 7, 15, 10, '2015-06-03'),
(5, 8, 16, 9, '2015-06-03'),
(6, 8, 17, 9, '2015-06-03'),
(7, 10, 20, 12, '2015-06-03'),
(8, 10, 21, 12, '2015-06-03'),
(9, 10, 22, 12, '2015-06-03'),
(10, 9, 18, 5, '2015-06-03'),
(11, 9, 19, 5, '2015-06-03');

-- --------------------------------------------------------

--
-- Table structure for table `question_options`
--

CREATE TABLE IF NOT EXISTS `question_options` (
  `option_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) DEFAULT NULL,
  `option_value` varchar(255) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  PRIMARY KEY (`option_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `question_options`
--

INSERT INTO `question_options` (`option_id`, `question_id`, `option_value`, `created_date`) VALUES
(1, 1, 'EC', '2015-06-02'),
(2, 1, 'IT', '2015-06-02'),
(3, 2, 'Playing', '2015-06-02'),
(4, 2, 'Dancing', '2015-06-02'),
(5, 3, 'male', '2015-06-02'),
(6, 3, 'female', '2015-06-02'),
(7, 4, 'BE', '2015-06-02'),
(8, 4, 'BA', '2015-06-02'),
(9, 5, 'c++', '2015-06-02'),
(10, 5, 'java', '2015-06-02'),
(11, 5, 'php', '2015-06-02'),
(12, 6, ' floats', '2015-06-02'),
(13, 6, 'integer', '2015-06-02'),
(14, 7, ' 4.5678', '2015-06-02'),
(15, 7, '21', '2015-06-02'),
(16, 8, 'Array', '2015-06-02'),
(17, 8, 'object', '2015-06-02'),
(18, 9, 'my-function', '2015-06-02'),
(19, 9, 'size', '2015-06-02'),
(20, 10, 'percentage', '2015-06-02'),
(21, 10, 'bitwise ', '2015-06-02'),
(22, 10, 'division', '2015-06-02'),
(23, 11, ' include ()', '2015-06-02'),
(24, 11, 'require ()', '2015-06-02'),
(25, 12, 'include()', '2015-06-02'),
(26, 12, ' require()', '2015-06-02');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE IF NOT EXISTS `rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CompanyId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `rating` float NOT NULL,
  `DateTime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `RoleId` int(11) NOT NULL AUTO_INCREMENT,
  `RoleName` varchar(255) NOT NULL,
  `Status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`RoleId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`RoleId`, `RoleName`, `Status`) VALUES
(1, 'admin', 1),
(2, 'user', 1),
(3, 'partner_admin', 1),
(4, 'partner_user', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role_id` tinyint(5) NOT NULL COMMENT '1-admin, 2-user,3-partner admin,4-partner user',
  `title` varchar(255) DEFAULT NULL,
  `address` text,
  `address_line_2` text,
  `country` int(11) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_updated_date` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `role_id`, `title`, `address`, `address_line_2`, `country`, `state`, `city`, `zip_code`, `phone`, `created_date`, `last_updated_date`, `status`) VALUES
(1, 'admin', NULL, 'admin@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-05-14 10:56:00', NULL, 1),
(2, 'Neha', 'Kochar', 'partner1@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 4, 'Miss.', '', NULL, NULL, NULL, NULL, NULL, '', '2015-05-14 07:36:59', NULL, 1),
(3, 'test', 'user1', 'user2@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-05-14 07:42:04', '2015-06-02 09:49:22', 1),
(4, 'test2qew', 'user2wqe', 'user2@gmail.com', '7612a5020fa46fb6390ed4073f34fd36', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-05-14 16:54:15', '2015-05-18 08:20:41', 1),
(5, 'pooja', 'soni', 'user2@gmail.com', '687a0372dcf1c971df995949819902b0', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-05-15 15:58:24', '2015-05-15 16:04:36', 1),
(6, 'test4', 'user123', 'user3@gmail.com', '98bf55211b57ff3f5529bc6aacbb7f4d', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-05-18 08:20:23', '2015-05-18 08:20:33', 1),
(7, 'Stacy', 'Stephens', 'ss@gmail.com', '48af51b459a65a65e950cccebbac5883', 4, 'Mr.', '1234 SMART DR', NULL, NULL, NULL, NULL, NULL, '6785968322', '2015-05-26 22:47:22', NULL, 1),
(8, 'Amit', 'Gupta', 'am@gmail.com', '58f8a5a92f5763c76248c192de21e0bb', 4, 'Mr.', '1212 WONDER DR', NULL, NULL, NULL, NULL, NULL, '6788667000', '2015-05-27 00:45:46', NULL, 1),
(14, 'Huzefa', 'Ratlamwala', 'huzefa.ratlamwala@lmsin.com', '2db97208b3f66be800e46c8cb79c5dea', 4, 'Mr.', 'indore', '', 99, 'mp', 'indore', '452014', '456456', '2015-05-28 16:56:43', NULL, 1),
(15, 'Jitnedre', 'Paswan', 'paswan1234@gmail.com', 'dd5892c9bc9cf1fdb50bbbdaf7e5615e', 4, 'Mr.', 'indore', '', 99, 'mp', 'indore', '45121', '456654', '2015-05-28 17:07:02', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_comments_map`
--

CREATE TABLE IF NOT EXISTS `user_comments_map` (
  `ucmap_id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_by` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  PRIMARY KEY (`ucmap_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_company_map`
--

CREATE TABLE IF NOT EXISTS `user_company_map` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `CompanyId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_test`
--

CREATE TABLE IF NOT EXISTS `user_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user_test`
--

INSERT INTO `user_test` (`id`, `c_id`, `question_id`, `option_id`, `user_id`, `timestamp`) VALUES
(1, 1, 6, 13, 2, '2015-06-03 09:50:12'),
(2, 1, 8, 17, 2, '2015-06-03 09:50:13'),
(3, 1, 9, 18, 2, '2015-06-03 09:50:15'),
(4, 1, 5, 10, 2, '2015-06-04 04:56:59');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
