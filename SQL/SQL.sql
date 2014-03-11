-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 22-02-2014 a las 18:20:36
-- Versión del servidor: 5.5.35
-- Versión de PHP: 5.3.10-1ubuntu3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `Las_reses`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrators`
--

CREATE TABLE IF NOT EXISTS `administrators` (
  `admin_id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `level` tinyint(4) NOT NULL DEFAULT '0',
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `address` text,
  `phone` varchar(50) DEFAULT NULL,
  `pager` varchar(20) DEFAULT NULL,
  `cell` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `administrators`
--

INSERT INTO `administrators` (`admin_id`, `username`, `password`, `level`, `firstname`, `lastname`, `address`, `phone`, `pager`, `cell`) VALUES
(3, 'admin', 'admin', 3, 'Administrator', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `sub_cat_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `weight` int(11) NOT NULL DEFAULT '1',
  `count` int(10) DEFAULT '0',
  `member` tinyint(3) DEFAULT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=235 ;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`cat_id`, `sub_cat_id`, `name`, `weight`, `count`, `member`) VALUES
(1, 0, 'Main', 1, 13, NULL),
(3, 1, 'Proxy server', 1, 2, NULL),
(6, 1, 'Exploits packs', 1, 0, NULL),
(8, 1, 'Crypters', 1, 2, NULL),
(9, 1, 'Binders', 1, 2, NULL),
(10, 1, 'Trojan', 1, 0, NULL),
(14, 1, 'Annonymous VPN', 1, 0, NULL),
(17, 1, 'Dedicated server', 1, 3, NULL),
(20, 1, 'Botnets DDoS service', 1, 0, NULL),
(21, 1, 'Rootkits', 1, 4, NULL),
(23, 2, 'Antiques', 1, 0, NULL),
(24, 2, 'Art', 1, 0, NULL),
(25, 6, 'Antiquarian & Collectible', 1, 0, NULL),
(26, 6, 'Audio', 1, 0, NULL),
(27, 6, 'Childrens', 1, 0, NULL),
(28, 6, 'Fictional', 1, 0, NULL),
(29, 6, 'Magazines & Catalogs', 1, 0, NULL),
(30, 6, 'Nonfiction', 1, 0, NULL),
(31, 6, 'Bulk Lots', 1, 0, NULL),
(32, 6, 'Other', 1, 0, NULL),
(33, 7, 'Agriculture', 1, 0, NULL),
(34, 7, 'Business for Sale', 1, 0, NULL),
(35, 7, 'Construction', 1, 0, NULL),
(36, 7, 'Electronic Components', 1, 0, NULL),
(37, 7, 'Industrial Supply', 1, 0, NULL),
(38, 7, 'Laboratory Equipment', 1, 0, NULL),
(39, 7, 'Large Lots, Wholesale', 1, 0, NULL),
(40, 7, 'Medical, Dental', 1, 0, NULL),
(41, 7, 'Metalworking Equipment', 1, 0, NULL),
(42, 7, 'Office Products', 1, 0, NULL),
(43, 7, 'Printing Equipment', 1, 0, NULL),
(44, 7, 'Restaraunt & Foodservice', 1, 0, NULL),
(45, 7, 'Retail', 1, 0, NULL),
(46, 7, 'Test, Measurement Equipment', 1, 0, NULL),
(47, 7, 'Other Industries', 1, 0, NULL),
(48, 10, 'Infants', 1, 0, NULL),
(49, 10, 'Boys', 1, 0, NULL),
(50, 10, 'Men', 1, 0, NULL),
(51, 10, 'Girls', 1, 0, NULL),
(52, 10, 'Women', 1, 0, NULL),
(53, 10, 'Uniforms', 1, 0, NULL),
(54, 10, 'Wedding Apparel', 1, 0, NULL),
(55, 1, 'Packers', 1, 0, NULL),
(56, 55, 'US Coins', 1, 0, NULL),
(57, 55, 'World Coins', 1, 0, NULL),
(58, 55, 'Exonumia', 1, 0, NULL),
(59, 55, 'US Paper Money', 1, 0, NULL),
(60, 55, 'World Paper Money', 1, 0, NULL),
(61, 55, 'Scripophily', 1, 0, NULL),
(65, 14, 'IPsec', 1, 0, NULL),
(66, 14, 'SSL', 1, 0, NULL),
(67, 14, 'Coin-Op, Banks & Casino', 1, 0, NULL),
(68, 14, 'Comics', 1, 0, NULL),
(69, 14, 'Cultures & Religons', 1, 0, NULL),
(70, 14, 'Decorative & Holiday', 1, 0, NULL),
(71, 14, 'Disneyana', 1, 0, NULL),
(72, 14, 'Furnishings & Tools', 1, 0, NULL),
(73, 14, 'Historical Memoribilia', 1, 0, NULL),
(74, 14, 'Housewares & Kitchenwares', 1, 0, NULL),
(75, 14, 'Knives & Swords', 1, 0, NULL),
(76, 14, 'Metalware', 1, 0, NULL),
(77, 14, 'Militaria', 1, 0, NULL),
(78, 14, 'Paper & Writing Instruments', 1, 0, NULL),
(79, 14, 'Pop Culture', 1, 0, NULL),
(80, 14, 'Science Fiction', 1, 0, NULL),
(83, 14, 'Trading Cards', 1, 0, NULL),
(84, 14, 'Transportation', 1, 0, NULL),
(85, 14, 'Vintage Clothing & Accessories', 1, 0, NULL),
(86, 17, 'Colombian Credit cards', 1, 2, NULL),
(87, 17, 'Windows server', 1, 1, NULL),
(88, 17, 'Desktop PCs', 1, 0, NULL),
(89, 17, 'Domain Names', 1, 0, NULL),
(90, 17, 'Drives, Media', 1, 0, NULL),
(91, 17, 'Input Peripherals', 1, 0, NULL),
(92, 17, 'Laptops & Accessories', 1, 0, NULL),
(93, 17, 'Monitors', 1, 0, NULL),
(94, 17, 'Networking & Telecom', 1, 0, NULL),
(95, 17, 'Other Hardware', 1, 0, NULL),
(96, 17, 'Printers & Supplies', 1, 0, NULL),
(97, 17, 'Scanners', 1, 0, NULL),
(98, 17, 'Services', 1, 0, NULL),
(100, 17, 'Technology Books', 1, 0, NULL),
(101, 17, 'Video & Multimedia', 1, 0, NULL),
(102, 17, 'Bulk Lots', 1, 0, NULL),
(103, 21, 'Linux Rootkits', 1, 2, NULL),
(104, 21, 'Car Audio & Electronics', 1, 1, NULL),
(105, 21, 'Gadgets & Other Electronics', 1, 0, NULL),
(106, 21, 'Home Audio & Video', 1, 0, NULL),
(107, 21, 'PDAs & Handheld PCs', 1, 0, NULL),
(108, 21, 'Phones & Wireless Devices', 1, 1, NULL),
(109, 21, 'Portable Audio & Video', 1, 0, NULL),
(110, 21, 'Professional Video Equipment', 1, 0, NULL),
(111, 21, 'Radio Equipment', 1, 0, NULL),
(112, 21, 'Video Games', 1, 0, NULL),
(113, 8, 'Poison Crypter', 1, 2, NULL),
(114, 8, 'Bears', 1, 0, NULL),
(115, 8, 'Doll Clothes, Furniture', 1, 0, NULL),
(116, 8, 'Doll Making, Patterns, Repair', 1, 0, NULL),
(117, 8, 'Dolls', 1, 0, NULL),
(118, 8, 'Houses & Miniatures', 1, 0, NULL),
(119, 8, 'Paper Dolls', 1, 0, NULL),
(120, 9, 'Smoke Binder ', 1, 2, NULL),
(121, 9, 'Bed & Bath', 1, 0, NULL),
(122, 9, 'Building & Repair Materials', 1, 0, NULL),
(123, 9, 'Food & Wine', 1, 0, NULL),
(124, 9, 'Furniture', 1, 0, NULL),
(125, 9, 'Home Decor', 1, 0, NULL),
(126, 9, 'Housekeeping & Organizing', 1, 0, NULL),
(127, 9, 'Kitchen & Tables', 1, 0, NULL),
(128, 9, 'Lamps, Lighting & Ceiling Fans', 1, 0, NULL),
(129, 9, 'Lawn & Garden', 1, 0, NULL),
(130, 9, 'Major Appliances', 1, 0, NULL),
(131, 9, 'Outdoor Living', 1, 0, NULL),
(132, 9, 'Pet Supplies', 1, 0, NULL),
(133, 9, 'Tools', 1, 0, NULL),
(134, 1, 'Fake money', 1, 0, NULL),
(135, 134, 'Beads, Amulets', 1, 0, NULL),
(136, 134, 'Costume Jewelry', 1, 0, NULL),
(137, 134, 'Ethnic, Tribal', 1, 0, NULL),
(138, 134, 'Fine', 1, 0, NULL),
(139, 134, 'Hair', 1, 0, NULL),
(140, 134, 'Designer, Artisan', 1, 0, NULL),
(141, 134, 'Jewelry Boxes', 1, 0, NULL),
(142, 134, 'Supplies', 1, 0, NULL),
(143, 134, 'Loose Gemstones', 1, 0, NULL),
(144, 134, 'Mens', 1, 0, NULL),
(145, 134, 'Watches', 1, 0, NULL),
(146, 11, 'Memorabilia', 1, 0, NULL),
(147, 11, 'Video, Film', 1, 0, NULL),
(148, 12, 'CDs, Records, & Tapes', 1, 0, NULL),
(149, 12, 'Music Memorabilia', 1, 0, NULL),
(150, 12, 'Musical Instruments', 1, 0, NULL),
(151, 12, 'Sheet Music, Music Books', 1, 0, NULL),
(152, 13, 'Albums & Archival Material', 1, 0, NULL),
(153, 13, 'Camera Accessories', 1, 0, NULL),
(154, 13, 'Darkroom Equipment & Supplies', 1, 0, NULL),
(155, 13, 'Digital Cameras', 1, 0, NULL),
(156, 13, 'Film', 1, 0, NULL),
(157, 13, 'Film Cameras', 1, 0, NULL),
(158, 13, 'Lenses', 1, 0, NULL),
(159, 13, 'Projection Equipment', 1, 0, NULL),
(160, 13, 'Stock Photography & Footage', 1, 0, NULL),
(161, 13, 'Vintage', 1, 0, NULL),
(162, 15, 'Glass', 1, 0, NULL),
(163, 15, 'Pottery & China', 1, 0, NULL),
(164, 16, 'Commercial', 1, 0, NULL),
(165, 16, 'Land', 1, 0, NULL),
(166, 16, 'Residential', 1, 0, NULL),
(167, 16, 'Timeshares for Sale', 1, 0, NULL),
(168, 16, 'Other Real Estate', 1, 0, NULL),
(169, 3, 'Autographs', 1, 0, NULL),
(170, 3, 'Fan Shop', 1, 0, NULL),
(171, 3, 'Memorabilia', 1, 0, NULL),
(172, 3, 'HTTP, HTTPS, SOCKS4, SOCKS5', 1, 2, NULL),
(173, 3, 'Trading Cards', 1, 0, NULL),
(174, 18, 'United States', 1, 0, NULL),
(175, 18, 'Australia', 1, 0, NULL),
(176, 18, 'Canada', 1, 0, NULL),
(177, 18, 'Br. Comm. Other', 1, 0, NULL),
(178, 18, 'UK (Great Britain)', 1, 0, NULL),
(179, 18, 'Europe', 1, 0, NULL),
(180, 18, 'Latin America', 1, 0, NULL),
(181, 18, 'Other', 1, 0, NULL),
(182, 18, 'Philately', 1, 0, NULL),
(183, 18, 'Topical', 1, 0, NULL),
(184, 19, 'Tickets & Experiences', 1, 0, NULL),
(185, 19, 'Travel', 1, 0, NULL),
(186, 20, 'Action Figures', 1, 0, NULL),
(187, 20, 'Building Toys', 1, 0, NULL),
(188, 20, 'Classic Toys', 1, 0, NULL),
(189, 20, 'Diecast Toys', 1, 0, NULL),
(190, 20, 'Educational, Development', 1, 0, NULL),
(191, 20, 'Electronic, Battery, Wind-Up', 1, 0, NULL),
(192, 20, 'Fast Food, Advertising', 1, 0, NULL),
(193, 20, 'Games', 1, 0, NULL),
(194, 20, 'Hobbies & Crafts', 1, 0, NULL),
(195, 20, 'Outdoor Toys, Structures', 1, 0, NULL),
(196, 20, 'Pretend Play, Make-Believe', 1, 0, NULL),
(197, 20, 'Puzzles', 1, 0, NULL),
(198, 20, 'Robots, Monsters, Space Toys', 1, 0, NULL),
(199, 20, 'Stuffed Animals, Beanbag', 1, 0, NULL),
(200, 20, 'Toy Soldiers', 1, 0, NULL),
(201, 20, 'TV, Character Toys', 1, 0, NULL),
(202, 20, 'Vintage, Antique Toys', 1, 0, NULL),
(203, 23, 'Antiquities', 1, 0, NULL),
(204, 23, 'Architectual & Garden', 1, 0, NULL),
(205, 23, 'Asian Antiques', 1, 0, NULL),
(206, 23, 'Books, Manuscripts', 1, 0, NULL),
(207, 23, 'Decorative Arts', 1, 0, NULL),
(208, 23, 'Ethnographic', 1, 0, NULL),
(209, 23, 'Furniture', 1, 0, NULL),
(210, 23, 'Maps, Atlases', 1, 0, NULL),
(211, 23, 'Maritime', 1, 0, NULL),
(212, 23, 'Musical Intruments', 1, 0, NULL),
(213, 23, 'Primitives', 1, 0, NULL),
(214, 23, 'Rugs Carpets', 1, 0, NULL),
(215, 24, 'Paintings', 1, 0, NULL),
(216, 24, 'Drawings', 1, 0, NULL),
(217, 24, 'Photographic', 1, 0, NULL),
(218, 24, 'Sculptures', 1, 0, NULL),
(219, 24, 'Other Art', 1, 0, NULL),
(220, 25, 'First Editions', 1, 0, NULL),
(221, 25, 'Antiquarian', 1, 0, NULL),
(222, 26, 'CDs', 1, 0, NULL),
(223, 26, 'Cassettes', 1, 0, NULL),
(224, 26, 'Other', 1, 0, NULL),
(225, 222, 'Children', 1, 0, NULL),
(226, 222, 'Fiction', 1, 0, NULL),
(227, 222, 'NonFiction', 1, 0, NULL),
(228, 222, 'Other', 1, 0, NULL),
(229, 223, 'Children', 1, 0, NULL),
(230, 223, 'Fiction', 1, 0, NULL),
(231, 223, 'NonFiction', 1, 0, NULL),
(232, 223, 'Other', 1, 0, NULL),
(233, 28, 'Action & Adventure', 1, 0, NULL),
(234, 2, 'Software', 1, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category_details`
--

CREATE TABLE IF NOT EXISTS `category_details` (
  `id` bigint(200) NOT NULL AUTO_INCREMENT,
  `cat_id` bigint(200) DEFAULT '0',
  `template` tinyint(2) DEFAULT '0',
  `field` tinyint(2) DEFAULT '0',
  `storefront` tinyint(2) DEFAULT '0',
  `pricing` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `charges`
--

CREATE TABLE IF NOT EXISTS `charges` (
  `charge_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `date` int(12) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `statusamount` decimal(10,2) DEFAULT '0.00',
  `charge` decimal(10,2) DEFAULT '0.00',
  `cause` text,
  PRIMARY KEY (`charge_id`),
  UNIQUE KEY `acNum` (`charge_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `charges`
--

INSERT INTO `charges` (`charge_id`, `user_id`, `date`, `status`, `statusamount`, `charge`, `cause`) VALUES
(1, 1, 1200248889, NULL, 0.00, 0.00, '<b>Item Number:</b> 552208439<br><b>Listing Fee:</b> $0.00<br><br><b>Total:</b> $0.00'),
(2, 1, 1200321813, NULL, 0.00, 0.00, '<b>Item Number:</b> 977091800<br><b>Listing Fee:</b> $0.00<br><br><b>Total:</b> $0.00'),
(3, 1, 1200333600, NULL, 0.00, 0.00, '<b>Item Number:</b> 240203597<br><b>Listing Fee:</b> $0.00<br><br><b>Total:</b> $0.00'),
(4, 2, 1200672059, NULL, 0.00, 0.00, '<b>Item Number:</b> 604532037<br><b>Listing Fee:</b> $0.00<br><b>Image Upload</b> $0.25<br><br><b>FREE LISTING TOKEN USED: </b><br><a href="StartListing.php?removetoken=1">Click here to remove this token and add it back to your account</a><br><br><b>Total:</b> $0.00'),
(5, 2, 1200672165, NULL, 0.00, 0.00, '<b>Item Number:</b> 946112158<br><b>Listing Fee:</b> $0.00<br><b>Image Upload</b> $0.25<br><br><b>FREE LISTING TOKEN USED: </b><br><a href="StartListing.php?removetoken=1">Click here to remove this token and add it back to your account</a><br><br><b>Total:</b> $0.00'),
(6, 2, 1200672274, NULL, 0.00, 0.00, '<b>Item Number:</b> 555822266<br><b>Listing Fee:</b> $0.00<br><b>Image Upload</b> $0.25<br><br><b>FREE LISTING TOKEN USED: </b><br><a href="StartListing.php?removetoken=1">Click here to remove this token and add it back to your account</a><br><br><b>Total:</b> $0.00'),
(7, 2, 1200672364, NULL, 0.00, 0.00, '<b>Item Number:</b> 125752357<br><b>Listing Fee:</b> $0.00<br><b>Image Upload</b> $0.25<br><br><b>FREE LISTING TOKEN USED: </b><br><a href="StartListing.php?removetoken=1">Click here to remove this token and add it back to your account</a><br><br><b>Total:</b> $0.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coupons`
--

CREATE TABLE IF NOT EXISTS `coupons` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `start` int(20) DEFAULT NULL,
  `end` int(20) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_dropdown`
--

CREATE TABLE IF NOT EXISTS `custom_dropdown` (
  `id` bigint(200) NOT NULL AUTO_INCREMENT,
  `cat_id` bigint(200) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `template_var` varchar(255) DEFAULT NULL,
  `description` text,
  `searchable` tinyint(2) DEFAULT '0',
  `style` tinyint(2) DEFAULT '1',
  `per_row` tinyint(10) DEFAULT '3',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_dropdown_options`
--

CREATE TABLE IF NOT EXISTS `custom_dropdown_options` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `field_id` bigint(200) NOT NULL DEFAULT '0',
  `option` varchar(255) DEFAULT NULL,
  `default` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_dropdown_values`
--

CREATE TABLE IF NOT EXISTS `custom_dropdown_values` (
  `id` bigint(200) NOT NULL AUTO_INCREMENT,
  `field_id` bigint(200) NOT NULL DEFAULT '0',
  `option_id` bigint(200) NOT NULL DEFAULT '0',
  `ItemNum` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_textarea`
--

CREATE TABLE IF NOT EXISTS `custom_textarea` (
  `id` bigint(200) NOT NULL AUTO_INCREMENT,
  `cat_id` bigint(200) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `template_var` varchar(255) DEFAULT NULL,
  `description` text,
  `searchable` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_textarea_values`
--

CREATE TABLE IF NOT EXISTS `custom_textarea_values` (
  `id` bigint(200) NOT NULL AUTO_INCREMENT,
  `field_id` bigint(200) NOT NULL DEFAULT '0',
  `ItemNum` int(20) NOT NULL DEFAULT '0',
  `value` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_textbox`
--

CREATE TABLE IF NOT EXISTS `custom_textbox` (
  `id` bigint(200) NOT NULL AUTO_INCREMENT,
  `cat_id` bigint(200) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `template_var` varchar(255) DEFAULT NULL,
  `description` text,
  `searchable` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_textbox_values`
--

CREATE TABLE IF NOT EXISTS `custom_textbox_values` (
  `id` bigint(200) NOT NULL AUTO_INCREMENT,
  `field_id` bigint(200) NOT NULL DEFAULT '0',
  `ItemNum` int(20) NOT NULL DEFAULT '0',
  `value` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `emails`
--

CREATE TABLE IF NOT EXISTS `emails` (
  `email_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `to_user_id` int(11) DEFAULT NULL,
  `from_user_id` int(11) DEFAULT NULL,
  `emaildate` int(12) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `message` text,
  `been_read` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`email_id`),
  UNIQUE KEY `offer_id` (`email_id`),
  KEY `to_seller_id` (`to_user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Volcado de datos para la tabla `emails`
--

INSERT INTO `emails` (`email_id`, `item_id`, `to_user_id`, `from_user_id`, `emaildate`, `subject`, `message`, `been_read`) VALUES
(7, NULL, 2, 1000000000, 1200671619, 'Welcome to ITech Classifieds!', 'Hello Demo,\r\n\r\nWe are glad you decided to join us! Here at ITech Classifieds, you can effectivly buy and sell your items while in an enjoyable environment. We hope you have fun as member of our community. \r\n\r\nThank you,\r\nITech Classifieds Team', 0),
(8, NULL, 2, 1000000000, 1200672059, 'New Listing  #604532037 created on January 18, 2008, 10:00 am', 'Hello userdemo,\r\n\r\nThank you for submitting your item! Below are the details of your new listing. You can preview your listing by clicking <a href=http://lab.demonstrationserver.com/classifieds/ViewItem.php?ItemNum=604532037>here</a>\r\n\r\nDetails\r\n--------------------------------------------------\r\nItem Number: 604532037\r\nTitle: ITechBids Gold Edition\r\nStarted: January 18, 2008, 10:00 am\r\nDays to Run: 3\r\nCloses on: January 21, 2008, 10:00 am\r\nAsking Price: 125.00   Make Offer\r\nQuantity: 1\r\nCity/Town: Cal\r\nState/Province: LA \r\n\r\nCharges\r\n----------------------------------------------------\r\nBold: Not Selected\r\nHighlighted: Not Selected\r\nCategory Featured: Not Selected\r\nGallery Listing: Not Selected\r\nImage Preview: Not Selected\r\nHome Page Featured: Not Selected\r\nImage Slide Show: Not Selected\r\nCounter: Not Selected\r\nImage One: 0.25\r\nImage Two: No Image Uploaded\r\nImage Three: No Image Uploaded\r\nImage Four: No Image Uploaded\r\nImage Five: No Image Uploaded\r\n\r\n\r\nThank you,\r\nITech Classifieds Team', 0),
(9, NULL, 2, 1000000000, 1200672165, 'New Listing  #946112158 created on January 18, 2008, 10:02 am', 'Hello userdemo,\r\n\r\nThank you for submitting your item! Below are the details of your new listing. You can preview your listing by clicking <a href=http://lab.demonstrationserver.com/classifieds/ViewItem.php?ItemNum=946112158>here</a>\r\n\r\nDetails\r\n--------------------------------------------------\r\nItem Number: 946112158\r\nTitle: ITech-Listing\r\nStarted: January 18, 2008, 10:02 am\r\nDays to Run: 14\r\nCloses on: February 1, 2008, 10:02 am\r\nAsking Price: 100.00   Make Offer\r\nQuantity: 1\r\nCity/Town: Cal\r\nState/Province: LA \r\n\r\nCharges\r\n----------------------------------------------------\r\nBold: Not Selected\r\nHighlighted: Not Selected\r\nCategory Featured: Not Selected\r\nGallery Listing: Not Selected\r\nImage Preview: Not Selected\r\nHome Page Featured: Not Selected\r\nImage Slide Show: Not Selected\r\nCounter: Not Selected\r\nImage One: 0.25\r\nImage Two: No Image Uploaded\r\nImage Three: No Image Uploaded\r\nImage Four: No Image Uploaded\r\nImage Five: No Image Uploaded\r\n\r\n\r\nThank you,\r\nITech Classifieds Team', 0),
(10, NULL, 2, 1000000000, 1200672274, 'New Listing  #555822266 created on January 18, 2008, 10:04 am', 'Hello userdemo,\r\n\r\nThank you for submitting your item! Below are the details of your new listing. You can preview your listing by clicking <a href=http://lab.demonstrationserver.com/classifieds/ViewItem.php?ItemNum=555822266>here</a>\r\n\r\nDetails\r\n--------------------------------------------------\r\nItem Number: 555822266\r\nTitle: iTechClassifieds\r\nStarted: January 18, 2008, 10:04 am\r\nDays to Run: 14\r\nCloses on: February 1, 2008, 10:04 am\r\nAsking Price: 125.00   Make Offer\r\nQuantity: 1\r\nCity/Town: Cal\r\nState/Province: LA \r\n\r\nCharges\r\n----------------------------------------------------\r\nBold: Not Selected\r\nHighlighted: Not Selected\r\nCategory Featured: Not Selected\r\nGallery Listing: Not Selected\r\nImage Preview: Not Selected\r\nHome Page Featured: Not Selected\r\nImage Slide Show: Not Selected\r\nCounter: Not Selected\r\nImage One: 0.25\r\nImage Two: No Image Uploaded\r\nImage Three: No Image Uploaded\r\nImage Four: No Image Uploaded\r\nImage Five: No Image Uploaded\r\n\r\n\r\nThank you,\r\nITech Classifieds Team', 0),
(11, NULL, 2, 1000000000, 1200672364, 'New Listing  #125752357 created on January 18, 2008, 10:06 am', 'Hello userdemo,\r\n\r\nThank you for submitting your item! Below are the details of your new listing. You can preview your listing by clicking <a href=http://lab.demonstrationserver.com/classifieds/ViewItem.php?ItemNum=125752357>here</a>\r\n\r\nDetails\r\n--------------------------------------------------\r\nItem Number: 125752357\r\nTitle: ITechEstate\r\nStarted: January 18, 2008, 10:06 am\r\nDays to Run: 14\r\nCloses on: February 1, 2008, 10:06 am\r\nAsking Price: 100.00   Make Offer\r\nQuantity: 1\r\nCity/Town: Cal\r\nState/Province: LA \r\n\r\nCharges\r\n----------------------------------------------------\r\nBold: Not Selected\r\nHighlighted: Not Selected\r\nCategory Featured: Not Selected\r\nGallery Listing: Not Selected\r\nImage Preview: Not Selected\r\nHome Page Featured: Not Selected\r\nImage Slide Show: Not Selected\r\nCounter: Not Selected\r\nImage One: 0.25\r\nImage Two: No Image Uploaded\r\nImage Three: No Image Uploaded\r\nImage Four: No Image Uploaded\r\nImage Five: No Image Uploaded\r\n\r\n\r\nThank you,\r\nITech Classifieds Team', 0),
(12, NULL, 3, 1000000000, 1391484380, 'Welcome to ITech Classifieds!', 'Hello a,\r\n\r\nWe are glad you decided to join us! Here at ITech Classifieds, you can effectivly buy and sell your items while in an enjoyable environment. We hope you have fun as member of our community. \r\n\r\nThank you,\r\nITech Classifieds Team', 0),
(13, NULL, 4, 1000000000, 1391923560, 'Welcome to ITech Classifieds!', 'Hello prueba,\r\n\r\nWe are glad you decided to join us! Here at ITech Classifieds, you can effectivly buy and sell your items while in an enjoyable environment. We hope you have fun as member of our community. \r\n\r\nThank you,\r\nITech Classifieds Team', 0),
(14, NULL, 1, 4, 1391923782, 'A question has been asked about Item#181993168', 'Hello subrata,\r\n\r\nThe following question was asked:\r\nFrom: prueba\r\nRegarding Item#181993168\r\n________________________________________________________\r\n\r\n\r\n\r\n________________________________________________________', 0),
(15, NULL, 1, 4, 1391923798, 'A question has been asked about Item#181993168', 'Hello subrata,\r\n\r\nThe following question was asked:\r\nFrom: prueba\r\nRegarding Item#181993168\r\n________________________________________________________\r\n\r\ndssf\r\n\r\n________________________________________________________', 0),
(16, NULL, 5, 1000000000, 1392604993, 'Welcome to ITech Classifieds!', 'Hello John,\r\n\r\nWe are glad you decided to join us! Here at ITech Classifieds, you can effectivly buy and sell your items while in an enjoyable environment. We hope you have fun as member of our community. \r\n\r\nThank you,\r\nITech Classifieds Team', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(20) DEFAULT NULL,
  `ItemNum` int(20) DEFAULT NULL,
  `being_rated` int(20) DEFAULT NULL,
  `doing_rating` int(20) DEFAULT NULL,
  `rating` tinyint(2) DEFAULT NULL,
  `comment` varchar(100) DEFAULT NULL,
  `buysell` tinyint(2) DEFAULT NULL,
  `date` int(20) NOT NULL DEFAULT '0',
  `counter` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forgottenpasswords`
--

CREATE TABLE IF NOT EXISTS `forgottenpasswords` (
  `forgot_id` int(3) NOT NULL AUTO_INCREMENT,
  `user_login` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `ip_request` varchar(20) DEFAULT NULL,
  `date` int(14) DEFAULT NULL,
  UNIQUE KEY `forgot_id` (`forgot_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` bigint(200) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `listing_discount` decimal(4,3) DEFAULT '0.000',
  `tokens` int(20) DEFAULT '0',
  `req_approval` tinyint(2) DEFAULT '0',
  `fe_admin` tinyint(2) DEFAULT '0',
  `date_created` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `listing_discount` (`listing_discount`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `groups`
--

INSERT INTO `groups` (`id`, `title`, `description`, `listing_discount`, `tokens`, `req_approval`, `fe_admin`, `date_created`) VALUES
(1, 'Public', 'All users should be members of the public group, as well as all categories that any registed member is allowed to post items in.  This is a REQUIRED group so Please Do Not Delete It, doing so will have adverse effects on your site!', 0.000, 0, 0, 0, 1083122480),
(2, 'SuperUser', 'This is a group for admins or highlevel users.  By default this user can list items in any category and receives a 100% discount (free listings).  Please Do Not Delete This Group.', 1.000, 0, 0, 0, 1083122480);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups_categories`
--

CREATE TABLE IF NOT EXISTS `groups_categories` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `cat_id` bigint(200) NOT NULL DEFAULT '0',
  `group_id` bigint(200) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Volcado de datos para la tabla `groups_categories`
--

INSERT INTO `groups_categories` (`id`, `cat_id`, `group_id`) VALUES
(1, 2, 1),
(2, 3, 1),
(3, 6, 1),
(4, 7, 1),
(5, 8, 1),
(6, 9, 1),
(7, 10, 1),
(8, 11, 1),
(9, 12, 1),
(10, 13, 1),
(11, 14, 1),
(12, 15, 1),
(13, 16, 1),
(14, 17, 1),
(15, 18, 1),
(16, 19, 1),
(17, 20, 1),
(18, 21, 1),
(19, 55, 1),
(20, 134, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups_users`
--

CREATE TABLE IF NOT EXISTS `groups_users` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(200) NOT NULL DEFAULT '0',
  `group_id` bigint(200) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `user_id` (`user_id`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `groups_users`
--

INSERT INTO `groups_users` (`id`, `user_id`, `group_id`) VALUES
(3, 1, 1),
(4, 2, 1),
(5, 3, 1),
(6, 4, 1),
(7, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `itemID` int(11) NOT NULL AUTO_INCREMENT,
  `ItemNum` bigint(20) NOT NULL DEFAULT '0',
  `category` int(10) unsigned DEFAULT NULL,
  `sub_category` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `end_reason` varchar(255) DEFAULT NULL,
  `started` int(12) DEFAULT NULL,
  `close` int(12) DEFAULT NULL,
  `closes` int(12) DEFAULT NULL,
  `bold` tinyint(4) DEFAULT '0',
  `background` tinyint(4) DEFAULT '0',
  `cat_featured` tinyint(4) DEFAULT '0',
  `home_featured` tinyint(4) DEFAULT '0',
  `gallery_featured` tinyint(4) DEFAULT '0',
  `image_preview` tinyint(4) DEFAULT '0',
  `slide_show` tinyint(4) DEFAULT '0',
  `counter` tinyint(4) DEFAULT NULL,
  `make_offer` tinyint(3) DEFAULT '0',
  `image_one` varchar(255) DEFAULT NULL,
  `image_two` varchar(255) DEFAULT NULL,
  `image_three` varchar(255) DEFAULT NULL,
  `image_four` varchar(255) DEFAULT NULL,
  `image_five` varchar(255) DEFAULT NULL,
  `asking_price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT '1',
  `city_town` varchar(255) DEFAULT NULL,
  `state_province` varchar(100) DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `description` text,
  `added_description` text,
  `dateadded` varchar(255) DEFAULT NULL,
  `charges_incurred` text,
  `totalcharges` decimal(10,2) DEFAULT NULL,
  `hits` int(11) DEFAULT '0',
  `item_paypal` varchar(100) DEFAULT NULL,
  `ship1` varchar(200) DEFAULT NULL,
  `shipfee1` decimal(10,2) DEFAULT NULL,
  `ship2` varchar(200) DEFAULT NULL,
  `shipfee2` decimal(10,2) DEFAULT NULL,
  `ship3` varchar(200) DEFAULT NULL,
  `shipfee3` decimal(10,2) DEFAULT NULL,
  `ship4` varchar(200) DEFAULT NULL,
  `shipfee4` decimal(10,2) DEFAULT NULL,
  `ship5` varchar(200) DEFAULT NULL,
  `shipfee5` decimal(10,2) DEFAULT NULL,
  `acct_credit_used` decimal(10,2) DEFAULT NULL,
  `amt_due` decimal(10,2) DEFAULT NULL,
  `notified` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`itemID`),
  UNIQUE KEY `PRI` (`itemID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Volcado de datos para la tabla `items`
--

INSERT INTO `items` (`itemID`, `ItemNum`, `category`, `sub_category`, `user_id`, `title`, `status`, `end_reason`, `started`, `close`, `closes`, `bold`, `background`, `cat_featured`, `home_featured`, `gallery_featured`, `image_preview`, `slide_show`, `counter`, `make_offer`, `image_one`, `image_two`, `image_three`, `image_four`, `image_five`, `asking_price`, `quantity`, `city_town`, `state_province`, `country`, `description`, `added_description`, `dateadded`, `charges_incurred`, `totalcharges`, `hits`, `item_paypal`, `ship1`, `shipfee1`, `ship2`, `shipfee2`, `ship3`, `shipfee3`, `ship4`, `shipfee4`, `ship5`, `shipfee5`, `acct_credit_used`, `amt_due`, `notified`) VALUES
(10, 527480889, 65, NULL, 1, 'IPsec TubeVPN', 1, '', 1391913303, 2, 1392777303, 1, 1, 1, 1, 0, 0, 1, 1, 1, 'uploads/08Feb2014.jpg', NULL, NULL, NULL, NULL, 100.00, 7, NULL, NULL, 49, ' Este servicio te permite conectarte de manera segura a Internet garantizando que tu identidad es anonima y sin revelar tu verdadera IP', NULL, NULL, NULL, NULL, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 181993168, 120, NULL, 1, 'Smoke Binder', 1, '', 1391913375, 3, 1393122975, 1, 1, 1, 1, 1, 0, 0, 1, 0, 'uploads/08Feb2014_copy.jpg', NULL, NULL, NULL, NULL, 8.00, 4, NULL, NULL, 1, 'Estos programas son muy interesantes para infectar inadvertidamente a la víctima con virus y troyanos. Un binder (también llamado Joiner o Juntador) es un programa que une dos o más archivos. Estos archivos pueden ser ejecutables o de cualquier otro tipo dependiendo del binder que usemos. \r\n\r\nNos podemos preguntar para qué necesitamos un binder. Bueno, es posible adosar mediante uno de estos programas varios archivos *.dll a un ejecutable con la intención de ejecutarlo todo al mismo tiempo, pero no está muy claro esto. Normalmente las compañías antivirus imaginan que debajo de un binder hay troyanos, virus o gusanos. De esa manera, tienden a identificar estos programas como malware.\r\n\r\nEsto dificulta la infección por medio de binders, pero hay posibilidades de infectar.', NULL, NULL, NULL, NULL, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 48713842, 113, NULL, 1, 'Posion Crypter', 1, NULL, 1391913842, 1, 1392173042, 1, 1, 1, 1, 1, 0, 1, 1, 0, 'uploads/08Feb2014_copy1.jpg', NULL, NULL, NULL, NULL, 8.00, 7, NULL, NULL, 209, 'Un crypter, conocido por su nombre de naturaleza inglesa, es un software que tiene como objetivo “esconder” la información de un tipo de archivo para que una persona o máquina no la pueda interpretar protegiendo la información. Mediante esta descripción genérica un crypter es una aplicación diseñada para aumentar la seguridad de los datos aunque también es utilizado para esconder malware de los antivirus.\r\n\r\nEn la orientación de crypters para malware, tenemos dos tipos de crypters según su modo de cifrar la información:\r\n\r\n    SCAN-Time – Un malware cifrado con éste tipo de crypter, podrá evadir el antivirus en un análisis pero al ejecutar-se, como debe recomponer su código interno los antivirus suelen detectarlos sin mayores complicaciones.\r\n    RUN-Time – Al ejecutarlos o analizar un ejecutable cifrado mediante un crypter de este tipo será más improbable que sea detectado por un antivirus. Este tipo son mas complejos que los anteriores en cuanto funcionamiento y diseño.\r\n\r\nEn muchas comunidades y páginas de internet se hace referencia a un tipo de crypter llamado FUD, éstos se dícen que son FUD cuando el ejecutable final cifrado es indetectable a todos los antivirus', NULL, NULL, NULL, NULL, 27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 125752357, 55, NULL, 2, 'ITechEstate', 0, '', 1391485699, 5, 1392695299, 0, 0, 0, 1, 0, 1, 1, 0, 1, 'uploads/18Jan2008_copy2.jpg', 'uploads/03Feb2014.gif', NULL, NULL, NULL, 100.00, 1, 'Cal', 'LA', 20, 'linda como ', NULL, NULL, NULL, NULL, 19, 'admin@itechscripts.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, NULL),
(14, 530557753, 103, NULL, 1, 'Linux Rootkit', 1, NULL, 1391917753, 1, 1392176953, 1, 0, 1, 1, 1, 0, 1, 1, 0, 'uploads/08Feb2014_copy3.jpg', NULL, NULL, NULL, NULL, 500.00, 4, NULL, NULL, 63, 'Un rootkit es una herramienta, o un grupo de ellas que tiene como finalidad esconderse a sí misma y esconder otros programas, procesos, archivos, directorios, claves de registro, y puertos que permiten al intruso mantener el acceso a un sistema para remotamente comandar acciones o extraer información sensible. Existen rootkits para una amplia variedad de sistemas operativos, como GNU/Linux, Solaris o Microsoft Windows.\r\n\r\nUso de los Rootkits\r\n\r\nUn rootkit se usa habitualmente para esconder algunas aplicaciones que podrían actuar en el sistema atacado. Suelen incluir backdoors (puertas traseras) para ayudar al intruso a acceder fácilmente al sistema una vez que se ha conseguido entrar por primera vez. Por ejemplo, el rootkit puede esconder una aplicación que lance una consola cada vez que el atacante se conecte al sistema a través de un determinado puerto. Los rootkits del kernel o núcleo pueden contener funcionalidades similares. Un backdoor puede permitir también que los procesos lanzados por un usuario sin privilegios de administrador ejecuten algunas funcionalidades reservadas únicamente al superusuario. Todo tipo de herramientas útiles para obtener información de forma ilícita pueden ser ocultadas mediante rootkits. ', NULL, NULL, NULL, NULL, 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 159635450, 87, NULL, 1, 'Windows server 2008', 1, '', 1392489271, 1, 1393007671, 1, 1, 1, 1, 1, 0, 0, 0, 1, 'uploads/09Feb2014.jpg', 'uploads/15Feb2014_copy.jpg', NULL, NULL, NULL, 40.00, 8, NULL, NULL, 49, 'A dedicated server [\r\n&#1044;&#1077;&#1076;&#1080;&#1082;&#1080;\r\n] is one that a user does not\r\nshare with others. It can be used for various malicious\r\nactivities, ranging from brute forcing to carding, that\r\na hacker would prefer not to do on his own machine.\r\nHackers typically connect to a dedicated server via VPN,\r\nwhich provides them anonymity. Dedicated servers are\r\namong the most popular goods in the underground\r\nmarket. These are considered unique consumables with\r\nmore or less constant demand. Dedicated servers are\r\nusually sold by the tens or hundreds with prices depending\r\non their processing power and, to a larger extent, Internet\r\naccess speed.</BR></BR>\r\nServers are a must in a cybercriminal operation,\r\nparticularly for brute force attacks on wide ranges of\r\nIP addresses. Hackers also offer brute-forcing services\r\nbecause dedicated servers have so-called “lifetimes,”\r\ndepending on several factors, the most important of which\r\nare what measures an administrator implements to ensure\r\nserver security.</BR></BR>\r\nBulletproof-hosting services [\r\n&#1072;&#1073;&#1091;&#1079;&#1086;&#1091;&#1089;&#1090;&#1086;&#1081;&#1095;&#1080;&#1074;&#1099;&#1077;\r\n], which\r\nallow cybercriminals to host any kind of material on a\r\nsite or page without worrying about it being taken down\r\ndue to abuse complaints, are also widely available in the\r\nunderground market.\r\n\r\n</BR></BR></BR>\r\nBulletproof-hosting service\r\nwith distributed denial-of-\r\nservice (DDoS) protection, a\r\n1Gb Internet connection, and\r\nother extra features  US$2,000 per month\r\n\r\n\r\n</BR></BR></BR>\r\nBulletproof-hosting service\r\n(i.e., VPS/virtual dedicated\r\nserver [VDS] US$15–250 per month', NULL, NULL, NULL, NULL, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 250247607, 172, NULL, 1, 'Proxy service    HTTP, HTTPS, SOCKS4, SOCKS5', 1, '', 1392487967, 1, 1393006367, 1, 1, 1, 1, 1, 0, 0, 1, 0, 'uploads/15Feb2014.jpg', NULL, NULL, NULL, NULL, 0.00, 2, NULL, NULL, 8, 'A proxy server [&#1055;&#1088;&#1086;&#1082;&#1089;&#1103;] is an intermediate computer that acts as a “proxy” or mediator between a computer and the Internet. Proxy servers are used for various purposes like accelerating data transmission and filtering traffic but their main purpose, which makes them popular among\r\nhackers, is to ensure anonymity. Anonymity, in this case,comes from the fact that the destination server sees the IP address of the proxy server and not that of the hacker’s computer. Even hackers, however, frequently noted that\r\ndespite the assurance of proxy server operators, all such servers, even paid ones, keep logs and cannot provide\r\ncomplete anonymity.</BR></BR>\r\nThe main types of proxy servers are:\r\n</BR></BR>\r\n•\r\nHTTP proxy server:\r\nThe most prevalent form of proxy\r\nserver. In fact, a proxy server most often refers to this type of server. In the past, this kind of server only\r\nallowed users to view web pages and images as well as to download files. The latest versions of applications\r\n(e.g., ICQ, etc.) can run via an HTTP proxy server. Any browser version also runs via this type of proxy server.\r\n</BR></BR>\r\n•\r\nSOCKS proxy server:\r\nThis kind of proxy server works\r\nwith practically every kind of information available on the Internet (i.e., TCP/IP). To use SOCKS proxy servers, however, programs must explicitly be made able to work with them. Additional programs are required\r\nfor a browser to use a SOCKS proxy server. Browsers cannot work on SOCKS proxy servers on their own but\r\nany version of ICQ and several other popular programs work very well on them. When working with SOCKS proxy servers, their versions (i.e., SOCKS4 or SOCKS5)must be specified</BR></BR>\r\n</BR>\r\n\r\n\r\n\r\nProxy service: HTTP, HTTPS, SOCKS4, SOCKS5; prices: \r\n5 days =  US$4;\r\n10 days = US$8; \r\n30 days = US$20; \r\n90 days = US$55', NULL, NULL, NULL, NULL, 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items_preview`
--

CREATE TABLE IF NOT EXISTS `items_preview` (
  `itemID` int(11) NOT NULL AUTO_INCREMENT,
  `ItemNum` bigint(20) NOT NULL DEFAULT '0',
  `category` int(10) unsigned DEFAULT NULL,
  `sub_category` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `end_reason` varchar(255) DEFAULT NULL,
  `started` int(12) DEFAULT NULL,
  `close` int(12) DEFAULT NULL,
  `closes` int(12) DEFAULT NULL,
  `bold` tinyint(4) DEFAULT '0',
  `background` tinyint(4) DEFAULT '0',
  `cat_featured` tinyint(4) DEFAULT '0',
  `home_featured` tinyint(4) DEFAULT '0',
  `gallery_featured` tinyint(4) DEFAULT '0',
  `image_preview` tinyint(4) DEFAULT '0',
  `slide_show` tinyint(4) DEFAULT '0',
  `counter` tinyint(4) DEFAULT NULL,
  `make_offer` tinyint(3) DEFAULT '0',
  `image_one` varchar(255) DEFAULT NULL,
  `image_two` varchar(255) DEFAULT NULL,
  `image_three` varchar(255) DEFAULT NULL,
  `image_four` varchar(255) DEFAULT NULL,
  `image_five` varchar(255) DEFAULT NULL,
  `asking_price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT '1',
  `city_town` varchar(255) DEFAULT NULL,
  `state_province` varchar(100) DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `description` text,
  `added_description` text,
  `dateadded` varchar(255) DEFAULT NULL,
  `charges_incurred` text,
  `totalcharges` decimal(10,2) DEFAULT NULL,
  `hits` int(11) DEFAULT '0',
  `item_paypal` varchar(100) DEFAULT NULL,
  `ship1` varchar(200) DEFAULT NULL,
  `shipfee1` decimal(10,2) DEFAULT NULL,
  `ship2` varchar(200) DEFAULT NULL,
  `shipfee2` decimal(10,2) DEFAULT NULL,
  `ship3` varchar(200) DEFAULT NULL,
  `shipfee3` decimal(10,2) DEFAULT NULL,
  `ship4` varchar(200) DEFAULT NULL,
  `shipfee4` decimal(10,2) DEFAULT NULL,
  `ship5` varchar(200) DEFAULT NULL,
  `shipfee5` decimal(10,2) DEFAULT NULL,
  `acct_credit_used` decimal(10,2) DEFAULT NULL,
  `amt_due` decimal(10,2) DEFAULT NULL,
  `notified` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`itemID`),
  UNIQUE KEY `PRI` (`itemID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `listing_index`
--

CREATE TABLE IF NOT EXISTS `listing_index` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `ItemNum` int(20) DEFAULT NULL,
  `value` varchar(60) DEFAULT NULL,
  `pos` int(20) DEFAULT NULL,
  `field_num` int(20) DEFAULT NULL,
  `field_id` int(20) DEFAULT NULL,
  `field_value` int(20) DEFAULT NULL,
  `field_type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2621 ;

--
-- Volcado de datos para la tabla `listing_index`
--

INSERT INTO `listing_index` (`id`, `ItemNum`, `value`, `pos`, `field_num`, `field_id`, `field_value`, `field_type`) VALUES
(230, 946112158, 'Ver', 4, NULL, NULL, NULL, 'main'),
(229, 946112158, 'ITechListing', 3, NULL, NULL, NULL, 'main'),
(228, 946112158, 'Listing', 2, NULL, NULL, NULL, 'main'),
(227, 946112158, 'ITech', 1, NULL, NULL, NULL, 'main'),
(226, 604532037, 'LA', 89, NULL, NULL, NULL, 'main'),
(225, 604532037, 'Cal', 88, NULL, NULL, NULL, 'main'),
(224, 604532037, 'auction', 87, NULL, NULL, NULL, 'main'),
(223, 604532037, 'in', 86, NULL, NULL, NULL, 'main'),
(222, 604532037, 'best', 85, NULL, NULL, NULL, 'main'),
(221, 604532037, 'the', 84, NULL, NULL, NULL, 'main'),
(220, 604532037, 'yourself', 83, NULL, NULL, NULL, 'main'),
(219, 604532037, 'avail', 82, NULL, NULL, NULL, 'main'),
(218, 604532037, 'Just', 81, NULL, NULL, NULL, 'main'),
(217, 604532037, 'release', 80, NULL, NULL, NULL, 'main'),
(216, 604532037, 'recent', 79, NULL, NULL, NULL, 'main'),
(215, 604532037, 'the', 78, NULL, NULL, NULL, 'main'),
(214, 604532037, 'in', 77, NULL, NULL, NULL, 'main'),
(213, 604532037, 'added', 76, NULL, NULL, NULL, 'main'),
(212, 604532037, 'been', 75, NULL, NULL, NULL, 'main'),
(211, 604532037, 'has', 74, NULL, NULL, NULL, 'main'),
(210, 604532037, 'featured', 73, NULL, NULL, NULL, 'main'),
(209, 604532037, 'more', 72, NULL, NULL, NULL, 'main'),
(208, 604532037, 'many', 71, NULL, NULL, NULL, 'main'),
(207, 604532037, 'and', 70, NULL, NULL, NULL, 'main'),
(206, 604532037, 'Store', 69, NULL, NULL, NULL, 'main'),
(205, 604532037, 'User', 68, NULL, NULL, NULL, 'main'),
(204, 604532037, 'Auction', 67, NULL, NULL, NULL, 'main'),
(203, 604532037, 'Dutch', 66, NULL, NULL, NULL, 'main'),
(202, 604532037, 'precision', 65, NULL, NULL, NULL, 'main'),
(201, 604532037, 'and', 64, NULL, NULL, NULL, 'main'),
(200, 604532037, 'ease', 63, NULL, NULL, NULL, 'main'),
(199, 604532037, 'with', 62, NULL, NULL, NULL, 'main'),
(198, 604532037, 'script', 61, NULL, NULL, NULL, 'main'),
(197, 604532037, 'the', 60, NULL, NULL, NULL, 'main'),
(196, 604532037, 'manage', 59, NULL, NULL, NULL, 'main'),
(195, 604532037, 'helps', 58, NULL, NULL, NULL, 'main'),
(194, 604532037, 'Panel', 57, NULL, NULL, NULL, 'main'),
(193, 604532037, 'Control', 56, NULL, NULL, NULL, 'main'),
(192, 604532037, 'Improved', 55, NULL, NULL, NULL, 'main'),
(191, 604532037, 'features', 54, NULL, NULL, NULL, 'main'),
(190, 604532037, 'on', 53, NULL, NULL, NULL, 'main'),
(189, 604532037, 'add', 52, NULL, NULL, NULL, 'main'),
(188, 604532037, 'integrate', 51, NULL, NULL, NULL, 'main'),
(187, 604532037, 'to', 50, NULL, NULL, NULL, 'main'),
(186, 604532037, 'possibilities', 49, NULL, NULL, NULL, 'main'),
(185, 604532037, 'endless', 48, NULL, NULL, NULL, 'main'),
(184, 604532037, 'allows', 47, NULL, NULL, NULL, 'main'),
(183, 604532037, 'API', 46, NULL, NULL, NULL, 'main'),
(182, 604532037, 'developer', 45, NULL, NULL, NULL, 'main'),
(181, 604532037, 'Full', 44, NULL, NULL, NULL, 'main'),
(180, 604532037, 'backend', 43, NULL, NULL, NULL, 'main'),
(179, 604532037, 'as', 42, NULL, NULL, NULL, 'main'),
(178, 604532037, 'MYSQL', 41, NULL, NULL, NULL, 'main'),
(177, 604532037, 'with', 40, NULL, NULL, NULL, 'main'),
(176, 604532037, 'PHP', 39, NULL, NULL, NULL, 'main'),
(175, 604532037, 'using', 38, NULL, NULL, NULL, 'main'),
(174, 604532037, 'coded', 37, NULL, NULL, NULL, 'main'),
(173, 604532037, 'application', 36, NULL, NULL, NULL, 'main'),
(172, 604532037, 'web', 35, NULL, NULL, NULL, 'main'),
(171, 604532037, 'complete', 34, NULL, NULL, NULL, 'main'),
(170, 604532037, 'a', 33, NULL, NULL, NULL, 'main'),
(169, 604532037, 'is', 32, NULL, NULL, NULL, 'main'),
(168, 604532037, 'ITechBids', 31, NULL, NULL, NULL, 'main'),
(167, 604532037, 'for', 30, NULL, NULL, NULL, 'main'),
(166, 604532037, 'ask', 29, NULL, NULL, NULL, 'main'),
(165, 604532037, 'to', 28, NULL, NULL, NULL, 'main'),
(164, 604532037, 'more', 27, NULL, NULL, NULL, 'main'),
(163, 604532037, 'nothing', 26, NULL, NULL, NULL, 'main'),
(162, 604532037, 'require', 25, NULL, NULL, NULL, 'main'),
(161, 604532037, 'owners', 24, NULL, NULL, NULL, 'main'),
(160, 604532037, 'site', 23, NULL, NULL, NULL, 'main'),
(159, 604532037, 'controls', 22, NULL, NULL, NULL, 'main'),
(158, 604532037, 'admin', 21, NULL, NULL, NULL, 'main'),
(157, 604532037, 'comprehensive', 20, NULL, NULL, NULL, 'main'),
(156, 604532037, 'With', 19, NULL, NULL, NULL, 'main'),
(155, 604532037, 'website', 18, NULL, NULL, NULL, 'main'),
(154, 604532037, 'and', 17, NULL, NULL, NULL, 'main'),
(153, 604532037, 'product', 16, NULL, NULL, NULL, 'main'),
(152, 604532037, 'software', 15, NULL, NULL, NULL, 'main'),
(151, 604532037, 'auction', 14, NULL, NULL, NULL, 'main'),
(150, 604532037, 'functional', 13, NULL, NULL, NULL, 'main'),
(149, 604532037, 'fully', 12, NULL, NULL, NULL, 'main'),
(148, 604532037, 'a', 11, NULL, NULL, NULL, 'main'),
(147, 604532037, 'is', 10, NULL, NULL, NULL, 'main'),
(146, 604532037, 'Release', 9, NULL, NULL, NULL, 'main'),
(145, 604532037, 'Gold', 8, NULL, NULL, NULL, 'main'),
(144, 604532037, '0', 7, NULL, NULL, NULL, 'main'),
(143, 604532037, '3', 6, NULL, NULL, NULL, 'main'),
(142, 604532037, 'Ver', 5, NULL, NULL, NULL, 'main'),
(141, 604532037, 'ITechBids', 4, NULL, NULL, NULL, 'main'),
(140, 604532037, 'Edition', 3, NULL, NULL, NULL, 'main'),
(139, 604532037, 'Gold', 2, NULL, NULL, NULL, 'main'),
(138, 604532037, 'ITechBids', 1, NULL, NULL, NULL, 'main'),
(231, 946112158, '2', 5, NULL, NULL, NULL, 'main'),
(232, 946112158, '0', 6, NULL, NULL, NULL, 'main'),
(233, 946112158, 'is', 7, NULL, NULL, NULL, 'main'),
(234, 946112158, 'a', 8, NULL, NULL, NULL, 'main'),
(235, 946112158, 'premier', 9, NULL, NULL, NULL, 'main'),
(236, 946112158, 'product', 10, NULL, NULL, NULL, 'main'),
(237, 946112158, 'that', 11, NULL, NULL, NULL, 'main'),
(238, 946112158, 'allows', 12, NULL, NULL, NULL, 'main'),
(239, 946112158, 'you', 13, NULL, NULL, NULL, 'main'),
(240, 946112158, 'build', 14, NULL, NULL, NULL, 'main'),
(241, 946112158, 'a', 15, NULL, NULL, NULL, 'main'),
(242, 946112158, 'powerful', 16, NULL, NULL, NULL, 'main'),
(243, 946112158, 'Web', 17, NULL, NULL, NULL, 'main'),
(244, 946112158, 'Indexing', 18, NULL, NULL, NULL, 'main'),
(245, 946112158, 'website', 19, NULL, NULL, NULL, 'main'),
(246, 946112158, 'such', 20, NULL, NULL, NULL, 'main'),
(247, 946112158, 'as', 21, NULL, NULL, NULL, 'main'),
(248, 946112158, 'yahoo', 22, NULL, NULL, NULL, 'main'),
(249, 946112158, 'dmoz', 23, NULL, NULL, NULL, 'main'),
(250, 946112158, 'ITechListing', 24, NULL, NULL, NULL, 'main'),
(251, 946112158, 'is', 25, NULL, NULL, NULL, 'main'),
(252, 946112158, 'the', 26, NULL, NULL, NULL, 'main'),
(253, 946112158, 'leader', 27, NULL, NULL, NULL, 'main'),
(254, 946112158, 'in', 28, NULL, NULL, NULL, 'main'),
(255, 946112158, 'directory', 29, NULL, NULL, NULL, 'main'),
(256, 946112158, 'services', 30, NULL, NULL, NULL, 'main'),
(257, 946112158, 'Insertion', 31, NULL, NULL, NULL, 'main'),
(258, 946112158, 'of', 32, NULL, NULL, NULL, 'main'),
(259, 946112158, 'web', 33, NULL, NULL, NULL, 'main'),
(260, 946112158, 'directory', 34, NULL, NULL, NULL, 'main'),
(261, 946112158, 'services', 35, NULL, NULL, NULL, 'main'),
(262, 946112158, 'also', 36, NULL, NULL, NULL, 'main'),
(263, 946112158, 'helps', 37, NULL, NULL, NULL, 'main'),
(264, 946112158, 'you', 38, NULL, NULL, NULL, 'main'),
(265, 946112158, 'secure', 39, NULL, NULL, NULL, 'main'),
(266, 946112158, 'better', 40, NULL, NULL, NULL, 'main'),
(267, 946112158, 'search', 41, NULL, NULL, NULL, 'main'),
(268, 946112158, 'engine', 42, NULL, NULL, NULL, 'main'),
(269, 946112158, 'positions', 43, NULL, NULL, NULL, 'main'),
(270, 946112158, 'for', 44, NULL, NULL, NULL, 'main'),
(271, 946112158, 'your', 45, NULL, NULL, NULL, 'main'),
(272, 946112158, 'website', 46, NULL, NULL, NULL, 'main'),
(273, 946112158, 'Enjoy', 47, NULL, NULL, NULL, 'main'),
(274, 946112158, 'higher', 48, NULL, NULL, NULL, 'main'),
(275, 946112158, 'search', 49, NULL, NULL, NULL, 'main'),
(276, 946112158, 'ranking', 50, NULL, NULL, NULL, 'main'),
(277, 946112158, 'and', 51, NULL, NULL, NULL, 'main'),
(278, 946112158, 'achieve', 52, NULL, NULL, NULL, 'main'),
(279, 946112158, 'your', 53, NULL, NULL, NULL, 'main'),
(280, 946112158, 'goals', 54, NULL, NULL, NULL, 'main'),
(281, 946112158, 'faster', 55, NULL, NULL, NULL, 'main'),
(282, 946112158, 'with', 56, NULL, NULL, NULL, 'main'),
(283, 946112158, 'ITechListing', 57, NULL, NULL, NULL, 'main'),
(284, 946112158, 'ITechListing', 58, NULL, NULL, NULL, 'main'),
(285, 946112158, 'v2', 59, NULL, NULL, NULL, 'main'),
(286, 946112158, '0', 60, NULL, NULL, NULL, 'main'),
(287, 946112158, 'is', 61, NULL, NULL, NULL, 'main'),
(288, 946112158, 'built', 62, NULL, NULL, NULL, 'main'),
(289, 946112158, 'around', 63, NULL, NULL, NULL, 'main'),
(290, 946112158, 'PHP', 64, NULL, NULL, NULL, 'main'),
(291, 946112158, 'MySQL', 65, NULL, NULL, NULL, 'main'),
(292, 946112158, 'as', 66, NULL, NULL, NULL, 'main'),
(293, 946112158, 'backend', 67, NULL, NULL, NULL, 'main'),
(294, 946112158, 'Available', 68, NULL, NULL, NULL, 'main'),
(295, 946112158, 'only', 69, NULL, NULL, NULL, 'main'),
(296, 946112158, 'at', 70, NULL, NULL, NULL, 'main'),
(297, 946112158, 'USD100', 71, NULL, NULL, NULL, 'main'),
(298, 946112158, 'domain', 72, NULL, NULL, NULL, 'main'),
(299, 946112158, 'ITechListing', 73, NULL, NULL, NULL, 'main'),
(300, 946112158, 'v2', 74, NULL, NULL, NULL, 'main'),
(301, 946112158, '0', 75, NULL, NULL, NULL, 'main'),
(302, 946112158, 'is', 76, NULL, NULL, NULL, 'main'),
(303, 946112158, 'the', 77, NULL, NULL, NULL, 'main'),
(304, 946112158, 'best', 78, NULL, NULL, NULL, 'main'),
(305, 946112158, 'value', 79, NULL, NULL, NULL, 'main'),
(306, 946112158, 'for', 80, NULL, NULL, NULL, 'main'),
(307, 946112158, 'your', 81, NULL, NULL, NULL, 'main'),
(308, 946112158, 'money', 82, NULL, NULL, NULL, 'main'),
(309, 946112158, 'Cal', 83, NULL, NULL, NULL, 'main'),
(310, 946112158, 'LA', 84, NULL, NULL, NULL, 'main'),
(311, 555822266, 'iTechClassifieds', 1, NULL, NULL, NULL, 'main'),
(312, 555822266, 'ITechListing', 2, NULL, NULL, NULL, 'main'),
(313, 555822266, 'Ver', 3, NULL, NULL, NULL, 'main'),
(314, 555822266, '2', 4, NULL, NULL, NULL, 'main'),
(315, 555822266, '0', 5, NULL, NULL, NULL, 'main'),
(316, 555822266, 'is', 6, NULL, NULL, NULL, 'main'),
(317, 555822266, 'a', 7, NULL, NULL, NULL, 'main'),
(318, 555822266, 'premier', 8, NULL, NULL, NULL, 'main'),
(319, 555822266, 'product', 9, NULL, NULL, NULL, 'main'),
(320, 555822266, 'that', 10, NULL, NULL, NULL, 'main'),
(321, 555822266, 'allows', 11, NULL, NULL, NULL, 'main'),
(322, 555822266, 'you', 12, NULL, NULL, NULL, 'main'),
(323, 555822266, 'build', 13, NULL, NULL, NULL, 'main'),
(324, 555822266, 'a', 14, NULL, NULL, NULL, 'main'),
(325, 555822266, 'powerful', 15, NULL, NULL, NULL, 'main'),
(326, 555822266, 'Web', 16, NULL, NULL, NULL, 'main'),
(327, 555822266, 'Indexing', 17, NULL, NULL, NULL, 'main'),
(328, 555822266, 'website', 18, NULL, NULL, NULL, 'main'),
(329, 555822266, 'such', 19, NULL, NULL, NULL, 'main'),
(330, 555822266, 'as', 20, NULL, NULL, NULL, 'main'),
(331, 555822266, 'yahoo', 21, NULL, NULL, NULL, 'main'),
(332, 555822266, 'dmoz', 22, NULL, NULL, NULL, 'main'),
(333, 555822266, 'ITechListing', 23, NULL, NULL, NULL, 'main'),
(334, 555822266, 'is', 24, NULL, NULL, NULL, 'main'),
(335, 555822266, 'the', 25, NULL, NULL, NULL, 'main'),
(336, 555822266, 'leader', 26, NULL, NULL, NULL, 'main'),
(337, 555822266, 'in', 27, NULL, NULL, NULL, 'main'),
(338, 555822266, 'directory', 28, NULL, NULL, NULL, 'main'),
(339, 555822266, 'services', 29, NULL, NULL, NULL, 'main'),
(340, 555822266, 'Insertion', 30, NULL, NULL, NULL, 'main'),
(341, 555822266, 'of', 31, NULL, NULL, NULL, 'main'),
(342, 555822266, 'web', 32, NULL, NULL, NULL, 'main'),
(343, 555822266, 'directory', 33, NULL, NULL, NULL, 'main'),
(344, 555822266, 'services', 34, NULL, NULL, NULL, 'main'),
(345, 555822266, 'also', 35, NULL, NULL, NULL, 'main'),
(346, 555822266, 'helps', 36, NULL, NULL, NULL, 'main'),
(347, 555822266, 'you', 37, NULL, NULL, NULL, 'main'),
(348, 555822266, 'secure', 38, NULL, NULL, NULL, 'main'),
(349, 555822266, 'better', 39, NULL, NULL, NULL, 'main'),
(350, 555822266, 'search', 40, NULL, NULL, NULL, 'main'),
(351, 555822266, 'engine', 41, NULL, NULL, NULL, 'main'),
(352, 555822266, 'positions', 42, NULL, NULL, NULL, 'main'),
(353, 555822266, 'for', 43, NULL, NULL, NULL, 'main'),
(354, 555822266, 'your', 44, NULL, NULL, NULL, 'main'),
(355, 555822266, 'website', 45, NULL, NULL, NULL, 'main'),
(356, 555822266, 'Enjoy', 46, NULL, NULL, NULL, 'main'),
(357, 555822266, 'higher', 47, NULL, NULL, NULL, 'main'),
(358, 555822266, 'search', 48, NULL, NULL, NULL, 'main'),
(359, 555822266, 'ranking', 49, NULL, NULL, NULL, 'main'),
(360, 555822266, 'and', 50, NULL, NULL, NULL, 'main'),
(361, 555822266, 'achieve', 51, NULL, NULL, NULL, 'main'),
(362, 555822266, 'your', 52, NULL, NULL, NULL, 'main'),
(363, 555822266, 'goals', 53, NULL, NULL, NULL, 'main'),
(364, 555822266, 'faster', 54, NULL, NULL, NULL, 'main'),
(365, 555822266, 'with', 55, NULL, NULL, NULL, 'main'),
(366, 555822266, 'ITechListing', 56, NULL, NULL, NULL, 'main'),
(367, 555822266, 'ITechListing', 57, NULL, NULL, NULL, 'main'),
(368, 555822266, 'v2', 58, NULL, NULL, NULL, 'main'),
(369, 555822266, '0', 59, NULL, NULL, NULL, 'main'),
(370, 555822266, 'is', 60, NULL, NULL, NULL, 'main'),
(371, 555822266, 'built', 61, NULL, NULL, NULL, 'main'),
(372, 555822266, 'around', 62, NULL, NULL, NULL, 'main'),
(373, 555822266, 'PHP', 63, NULL, NULL, NULL, 'main'),
(374, 555822266, 'MySQL', 64, NULL, NULL, NULL, 'main'),
(375, 555822266, 'as', 65, NULL, NULL, NULL, 'main'),
(376, 555822266, 'backend', 66, NULL, NULL, NULL, 'main'),
(377, 555822266, 'Available', 67, NULL, NULL, NULL, 'main'),
(378, 555822266, 'only', 68, NULL, NULL, NULL, 'main'),
(379, 555822266, 'at', 69, NULL, NULL, NULL, 'main'),
(380, 555822266, 'USD100', 70, NULL, NULL, NULL, 'main'),
(381, 555822266, 'domain', 71, NULL, NULL, NULL, 'main'),
(382, 555822266, 'ITechListing', 72, NULL, NULL, NULL, 'main'),
(383, 555822266, 'v2', 73, NULL, NULL, NULL, 'main'),
(384, 555822266, '0', 74, NULL, NULL, NULL, 'main'),
(385, 555822266, 'is', 75, NULL, NULL, NULL, 'main'),
(386, 555822266, 'the', 76, NULL, NULL, NULL, 'main'),
(387, 555822266, 'best', 77, NULL, NULL, NULL, 'main'),
(388, 555822266, 'value', 78, NULL, NULL, NULL, 'main'),
(389, 555822266, 'for', 79, NULL, NULL, NULL, 'main'),
(390, 555822266, 'your', 80, NULL, NULL, NULL, 'main'),
(391, 555822266, 'money', 81, NULL, NULL, NULL, 'main'),
(392, 555822266, 'Cal', 82, NULL, NULL, NULL, 'main'),
(393, 555822266, 'LA', 83, NULL, NULL, NULL, 'main'),
(394, 125752357, 'ITechEstate', 1, NULL, NULL, NULL, 'main'),
(395, 125752357, 'ITechBids', 2, NULL, NULL, NULL, 'main'),
(396, 125752357, 'Ver', 3, NULL, NULL, NULL, 'main'),
(397, 125752357, '3', 4, NULL, NULL, NULL, 'main'),
(398, 125752357, '0', 5, NULL, NULL, NULL, 'main'),
(399, 125752357, 'Gold', 6, NULL, NULL, NULL, 'main'),
(400, 125752357, 'Release', 7, NULL, NULL, NULL, 'main'),
(401, 125752357, 'is', 8, NULL, NULL, NULL, 'main'),
(402, 125752357, 'a', 9, NULL, NULL, NULL, 'main'),
(403, 125752357, 'fully', 10, NULL, NULL, NULL, 'main'),
(404, 125752357, 'functional', 11, NULL, NULL, NULL, 'main'),
(405, 125752357, 'auction', 12, NULL, NULL, NULL, 'main'),
(406, 125752357, 'software', 13, NULL, NULL, NULL, 'main'),
(407, 125752357, 'product', 14, NULL, NULL, NULL, 'main'),
(408, 125752357, 'and', 15, NULL, NULL, NULL, 'main'),
(409, 125752357, 'website', 16, NULL, NULL, NULL, 'main'),
(410, 125752357, 'With', 17, NULL, NULL, NULL, 'main'),
(411, 125752357, 'comprehensive', 18, NULL, NULL, NULL, 'main'),
(412, 125752357, 'admin', 19, NULL, NULL, NULL, 'main'),
(413, 125752357, 'controls', 20, NULL, NULL, NULL, 'main'),
(414, 125752357, 'site', 21, NULL, NULL, NULL, 'main'),
(415, 125752357, 'owners', 22, NULL, NULL, NULL, 'main'),
(416, 125752357, 'require', 23, NULL, NULL, NULL, 'main'),
(417, 125752357, 'nothing', 24, NULL, NULL, NULL, 'main'),
(418, 125752357, 'more', 25, NULL, NULL, NULL, 'main'),
(419, 125752357, 'to', 26, NULL, NULL, NULL, 'main'),
(420, 125752357, 'ask', 27, NULL, NULL, NULL, 'main'),
(421, 125752357, 'for', 28, NULL, NULL, NULL, 'main'),
(422, 125752357, 'ITechBids', 29, NULL, NULL, NULL, 'main'),
(423, 125752357, 'is', 30, NULL, NULL, NULL, 'main'),
(424, 125752357, 'a', 31, NULL, NULL, NULL, 'main'),
(425, 125752357, 'complete', 32, NULL, NULL, NULL, 'main'),
(426, 125752357, 'web', 33, NULL, NULL, NULL, 'main'),
(427, 125752357, 'application', 34, NULL, NULL, NULL, 'main'),
(428, 125752357, 'coded', 35, NULL, NULL, NULL, 'main'),
(429, 125752357, 'using', 36, NULL, NULL, NULL, 'main'),
(430, 125752357, 'PHP', 37, NULL, NULL, NULL, 'main'),
(431, 125752357, 'with', 38, NULL, NULL, NULL, 'main'),
(432, 125752357, 'MYSQL', 39, NULL, NULL, NULL, 'main'),
(433, 125752357, 'as', 40, NULL, NULL, NULL, 'main'),
(434, 125752357, 'backend', 41, NULL, NULL, NULL, 'main'),
(435, 125752357, 'Full', 42, NULL, NULL, NULL, 'main'),
(436, 125752357, 'developer', 43, NULL, NULL, NULL, 'main'),
(437, 125752357, 'API', 44, NULL, NULL, NULL, 'main'),
(438, 125752357, 'allows', 45, NULL, NULL, NULL, 'main'),
(439, 125752357, 'endless', 46, NULL, NULL, NULL, 'main'),
(440, 125752357, 'possibilities', 47, NULL, NULL, NULL, 'main'),
(441, 125752357, 'to', 48, NULL, NULL, NULL, 'main'),
(442, 125752357, 'integrate', 49, NULL, NULL, NULL, 'main'),
(443, 125752357, 'add', 50, NULL, NULL, NULL, 'main'),
(444, 125752357, 'on', 51, NULL, NULL, NULL, 'main'),
(445, 125752357, 'features', 52, NULL, NULL, NULL, 'main'),
(446, 125752357, 'Improved', 53, NULL, NULL, NULL, 'main'),
(447, 125752357, 'Control', 54, NULL, NULL, NULL, 'main'),
(448, 125752357, 'Panel', 55, NULL, NULL, NULL, 'main'),
(449, 125752357, 'helps', 56, NULL, NULL, NULL, 'main'),
(450, 125752357, 'manage', 57, NULL, NULL, NULL, 'main'),
(451, 125752357, 'the', 58, NULL, NULL, NULL, 'main'),
(452, 125752357, 'script', 59, NULL, NULL, NULL, 'main'),
(453, 125752357, 'with', 60, NULL, NULL, NULL, 'main'),
(454, 125752357, 'ease', 61, NULL, NULL, NULL, 'main'),
(455, 125752357, 'and', 62, NULL, NULL, NULL, 'main'),
(456, 125752357, 'precision', 63, NULL, NULL, NULL, 'main'),
(457, 125752357, 'Dutch', 64, NULL, NULL, NULL, 'main'),
(458, 125752357, 'Auction', 65, NULL, NULL, NULL, 'main'),
(459, 125752357, 'User', 66, NULL, NULL, NULL, 'main'),
(460, 125752357, 'Store', 67, NULL, NULL, NULL, 'main'),
(461, 125752357, 'and', 68, NULL, NULL, NULL, 'main'),
(462, 125752357, 'many', 69, NULL, NULL, NULL, 'main'),
(463, 125752357, 'more', 70, NULL, NULL, NULL, 'main'),
(464, 125752357, 'featured', 71, NULL, NULL, NULL, 'main'),
(465, 125752357, 'has', 72, NULL, NULL, NULL, 'main'),
(466, 125752357, 'been', 73, NULL, NULL, NULL, 'main'),
(467, 125752357, 'added', 74, NULL, NULL, NULL, 'main'),
(468, 125752357, 'in', 75, NULL, NULL, NULL, 'main'),
(469, 125752357, 'the', 76, NULL, NULL, NULL, 'main'),
(470, 125752357, 'recent', 77, NULL, NULL, NULL, 'main'),
(471, 125752357, 'release', 78, NULL, NULL, NULL, 'main'),
(472, 125752357, 'Just', 79, NULL, NULL, NULL, 'main'),
(473, 125752357, 'avail', 80, NULL, NULL, NULL, 'main'),
(474, 125752357, 'yourself', 81, NULL, NULL, NULL, 'main'),
(475, 125752357, 'the', 82, NULL, NULL, NULL, 'main'),
(476, 125752357, 'best', 83, NULL, NULL, NULL, 'main'),
(477, 125752357, 'in', 84, NULL, NULL, NULL, 'main'),
(478, 125752357, 'auction', 85, NULL, NULL, NULL, 'main'),
(479, 125752357, 'Cal', 86, NULL, NULL, NULL, 'main'),
(480, 125752357, 'LA', 87, NULL, NULL, NULL, 'main'),
(481, 534537331, 'famili', 1, NULL, NULL, NULL, 'main'),
(482, 534537331, 'foto', 2, NULL, NULL, NULL, 'main'),
(483, 534537331, 'b', 3, NULL, NULL, NULL, 'main'),
(484, 534537331, 'bb', 4, NULL, NULL, NULL, 'main'),
(708, 527480889, 'tu', 22, NULL, NULL, NULL, 'main'),
(707, 527480889, 'revelar', 21, NULL, NULL, NULL, 'main'),
(706, 527480889, 'sin', 20, NULL, NULL, NULL, 'main'),
(705, 527480889, 'y', 19, NULL, NULL, NULL, 'main'),
(704, 527480889, 'anonima', 18, NULL, NULL, NULL, 'main'),
(703, 527480889, 'es', 17, NULL, NULL, NULL, 'main'),
(702, 527480889, 'identidad', 16, NULL, NULL, NULL, 'main'),
(701, 527480889, 'tu', 15, NULL, NULL, NULL, 'main'),
(700, 527480889, 'que', 14, NULL, NULL, NULL, 'main'),
(699, 527480889, 'garantizando', 13, NULL, NULL, NULL, 'main'),
(698, 527480889, 'Internet', 12, NULL, NULL, NULL, 'main'),
(697, 527480889, 'a', 11, NULL, NULL, NULL, 'main'),
(696, 527480889, 'segura', 10, NULL, NULL, NULL, 'main'),
(695, 527480889, 'manera', 9, NULL, NULL, NULL, 'main'),
(694, 527480889, 'de', 8, NULL, NULL, NULL, 'main'),
(693, 527480889, 'conectarte', 7, NULL, NULL, NULL, 'main'),
(692, 527480889, 'permite', 6, NULL, NULL, NULL, 'main'),
(691, 527480889, 'te', 5, NULL, NULL, NULL, 'main'),
(690, 527480889, 'servicio', 4, NULL, NULL, NULL, 'main'),
(689, 527480889, 'Este', 3, NULL, NULL, NULL, 'main'),
(688, 527480889, 'TubeVPN', 2, NULL, NULL, NULL, 'main'),
(687, 527480889, 'IPsec', 1, NULL, NULL, NULL, 'main'),
(952, 181993168, 'identificar', 112, NULL, NULL, NULL, 'main'),
(951, 181993168, 'a', 111, NULL, NULL, NULL, 'main'),
(950, 181993168, 'tienden', 110, NULL, NULL, NULL, 'main'),
(949, 181993168, 'manera', 109, NULL, NULL, NULL, 'main'),
(948, 181993168, 'esa', 108, NULL, NULL, NULL, 'main'),
(947, 181993168, 'De', 107, NULL, NULL, NULL, 'main'),
(946, 181993168, 'gusanos', 106, NULL, NULL, NULL, 'main'),
(945, 181993168, 'o', 105, NULL, NULL, NULL, 'main'),
(944, 181993168, 'virus', 104, NULL, NULL, NULL, 'main'),
(943, 181993168, 'troyanos', 103, NULL, NULL, NULL, 'main'),
(942, 181993168, 'hay', 102, NULL, NULL, NULL, 'main'),
(941, 181993168, 'binder', 101, NULL, NULL, NULL, 'main'),
(940, 181993168, 'un', 100, NULL, NULL, NULL, 'main'),
(939, 181993168, 'de', 99, NULL, NULL, NULL, 'main'),
(938, 181993168, 'debajo', 98, NULL, NULL, NULL, 'main'),
(937, 181993168, 'que', 97, NULL, NULL, NULL, 'main'),
(936, 181993168, 'imaginan', 96, NULL, NULL, NULL, 'main'),
(935, 181993168, 'antivirus', 95, NULL, NULL, NULL, 'main'),
(934, 181993168, 'as', 94, NULL, NULL, NULL, 'main'),
(933, 181993168, 'compa', 93, NULL, NULL, NULL, 'main'),
(932, 181993168, 'las', 92, NULL, NULL, NULL, 'main'),
(931, 181993168, 'Normalmente', 91, NULL, NULL, NULL, 'main'),
(930, 181993168, 'esto', 90, NULL, NULL, NULL, 'main'),
(929, 181993168, 'claro', 89, NULL, NULL, NULL, 'main'),
(928, 181993168, 'muy', 88, NULL, NULL, NULL, 'main'),
(927, 181993168, 'est', 87, NULL, NULL, NULL, 'main'),
(926, 181993168, 'no', 86, NULL, NULL, NULL, 'main'),
(925, 181993168, 'pero', 85, NULL, NULL, NULL, 'main'),
(924, 181993168, 'tiempo', 84, NULL, NULL, NULL, 'main'),
(923, 181993168, 'mismo', 83, NULL, NULL, NULL, 'main'),
(922, 181993168, 'al', 82, NULL, NULL, NULL, 'main'),
(921, 181993168, 'todo', 81, NULL, NULL, NULL, 'main'),
(920, 181993168, 'ejecutarlo', 80, NULL, NULL, NULL, 'main'),
(919, 181993168, 'de', 79, NULL, NULL, NULL, 'main'),
(918, 181993168, 'n', 78, NULL, NULL, NULL, 'main'),
(917, 181993168, 'intenci', 77, NULL, NULL, NULL, 'main'),
(916, 181993168, 'la', 76, NULL, NULL, NULL, 'main'),
(915, 181993168, 'con', 75, NULL, NULL, NULL, 'main'),
(914, 181993168, 'ejecutable', 74, NULL, NULL, NULL, 'main'),
(913, 181993168, 'un', 73, NULL, NULL, NULL, 'main'),
(912, 181993168, 'a', 72, NULL, NULL, NULL, 'main'),
(911, 181993168, 'dll', 71, NULL, NULL, NULL, 'main'),
(910, 181993168, 'archivos', 70, NULL, NULL, NULL, 'main'),
(909, 181993168, 'varios', 69, NULL, NULL, NULL, 'main'),
(908, 181993168, 'programas', 68, NULL, NULL, NULL, 'main'),
(907, 181993168, 'estos', 67, NULL, NULL, NULL, 'main'),
(906, 181993168, 'de', 66, NULL, NULL, NULL, 'main'),
(905, 181993168, 'uno', 65, NULL, NULL, NULL, 'main'),
(904, 181993168, 'mediante', 64, NULL, NULL, NULL, 'main'),
(903, 181993168, 'adosar', 63, NULL, NULL, NULL, 'main'),
(902, 181993168, 'posible', 62, NULL, NULL, NULL, 'main'),
(901, 181993168, 'es', 61, NULL, NULL, NULL, 'main'),
(900, 181993168, 'Bueno', 60, NULL, NULL, NULL, 'main'),
(899, 181993168, 'binder', 59, NULL, NULL, NULL, 'main'),
(898, 181993168, 'un', 58, NULL, NULL, NULL, 'main'),
(897, 181993168, 'necesitamos', 57, NULL, NULL, NULL, 'main'),
(896, 181993168, 'qu', 56, NULL, NULL, NULL, 'main'),
(895, 181993168, 'para', 55, NULL, NULL, NULL, 'main'),
(894, 181993168, 'preguntar', 54, NULL, NULL, NULL, 'main'),
(893, 181993168, 'podemos', 53, NULL, NULL, NULL, 'main'),
(892, 181993168, 'Nos', 52, NULL, NULL, NULL, 'main'),
(891, 181993168, 'usemos', 51, NULL, NULL, NULL, 'main'),
(890, 181993168, 'que', 50, NULL, NULL, NULL, 'main'),
(889, 181993168, 'binder', 49, NULL, NULL, NULL, 'main'),
(888, 181993168, 'del', 48, NULL, NULL, NULL, 'main'),
(887, 181993168, 'dependiendo', 47, NULL, NULL, NULL, 'main'),
(886, 181993168, 'tipo', 46, NULL, NULL, NULL, 'main'),
(885, 181993168, 'otro', 45, NULL, NULL, NULL, 'main'),
(884, 181993168, 'cualquier', 44, NULL, NULL, NULL, 'main'),
(883, 181993168, 'de', 43, NULL, NULL, NULL, 'main'),
(882, 181993168, 'o', 42, NULL, NULL, NULL, 'main'),
(881, 181993168, 'ejecutables', 41, NULL, NULL, NULL, 'main'),
(880, 181993168, 'ser', 40, NULL, NULL, NULL, 'main'),
(879, 181993168, 'pueden', 39, NULL, NULL, NULL, 'main'),
(878, 181993168, 'archivos', 38, NULL, NULL, NULL, 'main'),
(877, 181993168, 'Estos', 37, NULL, NULL, NULL, 'main'),
(876, 181993168, 'archivos', 36, NULL, NULL, NULL, 'main'),
(875, 181993168, 's', 35, NULL, NULL, NULL, 'main'),
(874, 181993168, 'm', 34, NULL, NULL, NULL, 'main'),
(873, 181993168, 'o', 33, NULL, NULL, NULL, 'main'),
(872, 181993168, 'dos', 32, NULL, NULL, NULL, 'main'),
(871, 181993168, 'une', 31, NULL, NULL, NULL, 'main'),
(870, 181993168, 'que', 30, NULL, NULL, NULL, 'main'),
(869, 181993168, 'programa', 29, NULL, NULL, NULL, 'main'),
(868, 181993168, 'un', 28, NULL, NULL, NULL, 'main'),
(867, 181993168, 'es', 27, NULL, NULL, NULL, 'main'),
(866, 181993168, 'Juntador', 26, NULL, NULL, NULL, 'main'),
(865, 181993168, 'o', 25, NULL, NULL, NULL, 'main'),
(864, 181993168, 'Joiner', 24, NULL, NULL, NULL, 'main'),
(709, 527480889, 'verdadera', 23, NULL, NULL, NULL, 'main'),
(710, 527480889, 'IP', 24, NULL, NULL, NULL, 'main'),
(863, 181993168, 'llamado', 23, NULL, NULL, NULL, 'main'),
(862, 181993168, 'n', 22, NULL, NULL, NULL, 'main'),
(861, 181993168, 'tambi', 21, NULL, NULL, NULL, 'main'),
(860, 181993168, 'binder', 20, NULL, NULL, NULL, 'main'),
(859, 181993168, 'Un', 19, NULL, NULL, NULL, 'main'),
(858, 181993168, 'troyanos', 18, NULL, NULL, NULL, 'main'),
(857, 181993168, 'y', 17, NULL, NULL, NULL, 'main'),
(856, 181993168, 'virus', 16, NULL, NULL, NULL, 'main'),
(855, 181993168, 'con', 15, NULL, NULL, NULL, 'main'),
(854, 181993168, 'ctima', 14, NULL, NULL, NULL, 'main'),
(853, 181993168, 'v', 13, NULL, NULL, NULL, 'main'),
(852, 181993168, 'la', 12, NULL, NULL, NULL, 'main'),
(851, 181993168, 'a', 11, NULL, NULL, NULL, 'main'),
(850, 181993168, 'inadvertidamente', 10, NULL, NULL, NULL, 'main'),
(849, 181993168, 'infectar', 9, NULL, NULL, NULL, 'main'),
(848, 181993168, 'para', 8, NULL, NULL, NULL, 'main'),
(847, 181993168, 'interesantes', 7, NULL, NULL, NULL, 'main'),
(846, 181993168, 'muy', 6, NULL, NULL, NULL, 'main'),
(845, 181993168, 'son', 5, NULL, NULL, NULL, 'main'),
(844, 181993168, 'programas', 4, NULL, NULL, NULL, 'main'),
(843, 181993168, 'Estos', 3, NULL, NULL, NULL, 'main'),
(842, 181993168, 'Binder', 2, NULL, NULL, NULL, 'main'),
(841, 181993168, 'Smoke', 1, NULL, NULL, NULL, 'main'),
(953, 181993168, 'estos', 113, NULL, NULL, NULL, 'main'),
(954, 181993168, 'programas', 114, NULL, NULL, NULL, 'main'),
(955, 181993168, 'como', 115, NULL, NULL, NULL, 'main'),
(956, 181993168, 'malware', 116, NULL, NULL, NULL, 'main'),
(957, 181993168, 'Esto', 117, NULL, NULL, NULL, 'main'),
(958, 181993168, 'dificulta', 118, NULL, NULL, NULL, 'main'),
(959, 181993168, 'la', 119, NULL, NULL, NULL, 'main'),
(960, 181993168, 'infecci', 120, NULL, NULL, NULL, 'main'),
(961, 181993168, 'n', 121, NULL, NULL, NULL, 'main'),
(962, 181993168, 'por', 122, NULL, NULL, NULL, 'main'),
(963, 181993168, 'medio', 123, NULL, NULL, NULL, 'main'),
(964, 181993168, 'de', 124, NULL, NULL, NULL, 'main'),
(965, 181993168, 'binders', 125, NULL, NULL, NULL, 'main'),
(966, 181993168, 'pero', 126, NULL, NULL, NULL, 'main'),
(967, 181993168, 'hay', 127, NULL, NULL, NULL, 'main'),
(968, 181993168, 'posibilidades', 128, NULL, NULL, NULL, 'main'),
(969, 181993168, 'de', 129, NULL, NULL, NULL, 'main'),
(970, 181993168, 'infectar', 130, NULL, NULL, NULL, 'main'),
(971, 48713842, 'Posion', 1, NULL, NULL, NULL, 'main'),
(972, 48713842, 'Crypter', 2, NULL, NULL, NULL, 'main'),
(973, 48713842, 'Un', 3, NULL, NULL, NULL, 'main'),
(974, 48713842, 'crypter', 4, NULL, NULL, NULL, 'main'),
(975, 48713842, 'conocido', 5, NULL, NULL, NULL, 'main'),
(976, 48713842, 'por', 6, NULL, NULL, NULL, 'main'),
(977, 48713842, 'su', 7, NULL, NULL, NULL, 'main'),
(978, 48713842, 'nombre', 8, NULL, NULL, NULL, 'main'),
(979, 48713842, 'de', 9, NULL, NULL, NULL, 'main'),
(980, 48713842, 'naturaleza', 10, NULL, NULL, NULL, 'main'),
(981, 48713842, 'inglesa', 11, NULL, NULL, NULL, 'main'),
(982, 48713842, 'es', 12, NULL, NULL, NULL, 'main'),
(983, 48713842, 'un', 13, NULL, NULL, NULL, 'main'),
(984, 48713842, 'software', 14, NULL, NULL, NULL, 'main'),
(985, 48713842, 'que', 15, NULL, NULL, NULL, 'main'),
(986, 48713842, 'tiene', 16, NULL, NULL, NULL, 'main'),
(987, 48713842, 'como', 17, NULL, NULL, NULL, 'main'),
(988, 48713842, 'objetivo', 18, NULL, NULL, NULL, 'main'),
(989, 48713842, 'esconder', 19, NULL, NULL, NULL, 'main'),
(990, 48713842, 'la', 20, NULL, NULL, NULL, 'main'),
(991, 48713842, 'informaci', 21, NULL, NULL, NULL, 'main'),
(992, 48713842, 'n', 22, NULL, NULL, NULL, 'main'),
(993, 48713842, 'de', 23, NULL, NULL, NULL, 'main'),
(994, 48713842, 'un', 24, NULL, NULL, NULL, 'main'),
(995, 48713842, 'tipo', 25, NULL, NULL, NULL, 'main'),
(996, 48713842, 'de', 26, NULL, NULL, NULL, 'main'),
(997, 48713842, 'archivo', 27, NULL, NULL, NULL, 'main'),
(998, 48713842, 'para', 28, NULL, NULL, NULL, 'main'),
(999, 48713842, 'que', 29, NULL, NULL, NULL, 'main'),
(1000, 48713842, 'una', 30, NULL, NULL, NULL, 'main'),
(1001, 48713842, 'persona', 31, NULL, NULL, NULL, 'main'),
(1002, 48713842, 'o', 32, NULL, NULL, NULL, 'main'),
(1003, 48713842, 'm', 33, NULL, NULL, NULL, 'main'),
(1004, 48713842, 'quina', 34, NULL, NULL, NULL, 'main'),
(1005, 48713842, 'no', 35, NULL, NULL, NULL, 'main'),
(1006, 48713842, 'la', 36, NULL, NULL, NULL, 'main'),
(1007, 48713842, 'pueda', 37, NULL, NULL, NULL, 'main'),
(1008, 48713842, 'interpretar', 38, NULL, NULL, NULL, 'main'),
(1009, 48713842, 'protegiendo', 39, NULL, NULL, NULL, 'main'),
(1010, 48713842, 'la', 40, NULL, NULL, NULL, 'main'),
(1011, 48713842, 'informaci', 41, NULL, NULL, NULL, 'main'),
(1012, 48713842, 'n', 42, NULL, NULL, NULL, 'main'),
(1013, 48713842, 'Mediante', 43, NULL, NULL, NULL, 'main'),
(1014, 48713842, 'esta', 44, NULL, NULL, NULL, 'main'),
(1015, 48713842, 'descripci', 45, NULL, NULL, NULL, 'main'),
(1016, 48713842, 'n', 46, NULL, NULL, NULL, 'main'),
(1017, 48713842, 'gen', 47, NULL, NULL, NULL, 'main'),
(1018, 48713842, 'rica', 48, NULL, NULL, NULL, 'main'),
(1019, 48713842, 'un', 49, NULL, NULL, NULL, 'main'),
(1020, 48713842, 'crypter', 50, NULL, NULL, NULL, 'main'),
(1021, 48713842, 'es', 51, NULL, NULL, NULL, 'main'),
(1022, 48713842, 'una', 52, NULL, NULL, NULL, 'main'),
(1023, 48713842, 'aplicaci', 53, NULL, NULL, NULL, 'main'),
(1024, 48713842, 'n', 54, NULL, NULL, NULL, 'main'),
(1025, 48713842, 'dise', 55, NULL, NULL, NULL, 'main'),
(1026, 48713842, 'ada', 56, NULL, NULL, NULL, 'main'),
(1027, 48713842, 'para', 57, NULL, NULL, NULL, 'main'),
(1028, 48713842, 'aumentar', 58, NULL, NULL, NULL, 'main'),
(1029, 48713842, 'la', 59, NULL, NULL, NULL, 'main'),
(1030, 48713842, 'seguridad', 60, NULL, NULL, NULL, 'main'),
(1031, 48713842, 'de', 61, NULL, NULL, NULL, 'main'),
(1032, 48713842, 'los', 62, NULL, NULL, NULL, 'main'),
(1033, 48713842, 'datos', 63, NULL, NULL, NULL, 'main'),
(1034, 48713842, 'aunque', 64, NULL, NULL, NULL, 'main'),
(1035, 48713842, 'tambi', 65, NULL, NULL, NULL, 'main'),
(1036, 48713842, 'n', 66, NULL, NULL, NULL, 'main'),
(1037, 48713842, 'es', 67, NULL, NULL, NULL, 'main'),
(1038, 48713842, 'utilizado', 68, NULL, NULL, NULL, 'main'),
(1039, 48713842, 'para', 69, NULL, NULL, NULL, 'main'),
(1040, 48713842, 'esconder', 70, NULL, NULL, NULL, 'main'),
(1041, 48713842, 'malware', 71, NULL, NULL, NULL, 'main'),
(1042, 48713842, 'de', 72, NULL, NULL, NULL, 'main'),
(1043, 48713842, 'los', 73, NULL, NULL, NULL, 'main'),
(1044, 48713842, 'antivirus', 74, NULL, NULL, NULL, 'main'),
(1045, 48713842, 'En', 75, NULL, NULL, NULL, 'main'),
(1046, 48713842, 'la', 76, NULL, NULL, NULL, 'main'),
(1047, 48713842, 'orientaci', 77, NULL, NULL, NULL, 'main'),
(1048, 48713842, 'n', 78, NULL, NULL, NULL, 'main'),
(1049, 48713842, 'de', 79, NULL, NULL, NULL, 'main'),
(1050, 48713842, 'crypters', 80, NULL, NULL, NULL, 'main'),
(1051, 48713842, 'para', 81, NULL, NULL, NULL, 'main'),
(1052, 48713842, 'malware', 82, NULL, NULL, NULL, 'main'),
(1053, 48713842, 'tenemos', 83, NULL, NULL, NULL, 'main'),
(1054, 48713842, 'dos', 84, NULL, NULL, NULL, 'main'),
(1055, 48713842, 'tipos', 85, NULL, NULL, NULL, 'main'),
(1056, 48713842, 'de', 86, NULL, NULL, NULL, 'main'),
(1057, 48713842, 'crypters', 87, NULL, NULL, NULL, 'main'),
(1058, 48713842, 'seg', 88, NULL, NULL, NULL, 'main'),
(1059, 48713842, 'n', 89, NULL, NULL, NULL, 'main'),
(1060, 48713842, 'su', 90, NULL, NULL, NULL, 'main'),
(1061, 48713842, 'modo', 91, NULL, NULL, NULL, 'main'),
(1062, 48713842, 'de', 92, NULL, NULL, NULL, 'main'),
(1063, 48713842, 'cifrar', 93, NULL, NULL, NULL, 'main'),
(1064, 48713842, 'la', 94, NULL, NULL, NULL, 'main'),
(1065, 48713842, 'informaci', 95, NULL, NULL, NULL, 'main'),
(1066, 48713842, 'n', 96, NULL, NULL, NULL, 'main'),
(1067, 48713842, 'SCAN', 97, NULL, NULL, NULL, 'main'),
(1068, 48713842, 'Time', 98, NULL, NULL, NULL, 'main'),
(1069, 48713842, 'Un', 99, NULL, NULL, NULL, 'main'),
(1070, 48713842, 'malware', 100, NULL, NULL, NULL, 'main'),
(1071, 48713842, 'cifrado', 101, NULL, NULL, NULL, 'main'),
(1072, 48713842, 'con', 102, NULL, NULL, NULL, 'main'),
(1073, 48713842, 'ste', 103, NULL, NULL, NULL, 'main'),
(1074, 48713842, 'tipo', 104, NULL, NULL, NULL, 'main'),
(1075, 48713842, 'de', 105, NULL, NULL, NULL, 'main'),
(1076, 48713842, 'crypter', 106, NULL, NULL, NULL, 'main'),
(1077, 48713842, 'podr', 107, NULL, NULL, NULL, 'main'),
(1078, 48713842, 'evadir', 108, NULL, NULL, NULL, 'main'),
(1079, 48713842, 'el', 109, NULL, NULL, NULL, 'main'),
(1080, 48713842, 'antivirus', 110, NULL, NULL, NULL, 'main'),
(1081, 48713842, 'en', 111, NULL, NULL, NULL, 'main'),
(1082, 48713842, 'un', 112, NULL, NULL, NULL, 'main'),
(1083, 48713842, 'an', 113, NULL, NULL, NULL, 'main'),
(1084, 48713842, 'lisis', 114, NULL, NULL, NULL, 'main'),
(1085, 48713842, 'pero', 115, NULL, NULL, NULL, 'main'),
(1086, 48713842, 'al', 116, NULL, NULL, NULL, 'main'),
(1087, 48713842, 'ejecutar', 117, NULL, NULL, NULL, 'main'),
(1088, 48713842, 'se', 118, NULL, NULL, NULL, 'main'),
(1089, 48713842, 'como', 119, NULL, NULL, NULL, 'main'),
(1090, 48713842, 'debe', 120, NULL, NULL, NULL, 'main'),
(1091, 48713842, 'recomponer', 121, NULL, NULL, NULL, 'main'),
(1092, 48713842, 'su', 122, NULL, NULL, NULL, 'main'),
(1093, 48713842, 'c', 123, NULL, NULL, NULL, 'main'),
(1094, 48713842, 'digo', 124, NULL, NULL, NULL, 'main'),
(1095, 48713842, 'interno', 125, NULL, NULL, NULL, 'main'),
(1096, 48713842, 'los', 126, NULL, NULL, NULL, 'main'),
(1097, 48713842, 'antivirus', 127, NULL, NULL, NULL, 'main'),
(1098, 48713842, 'suelen', 128, NULL, NULL, NULL, 'main'),
(1099, 48713842, 'detectarlos', 129, NULL, NULL, NULL, 'main'),
(1100, 48713842, 'sin', 130, NULL, NULL, NULL, 'main'),
(1101, 48713842, 'mayores', 131, NULL, NULL, NULL, 'main'),
(1102, 48713842, 'complicaciones', 132, NULL, NULL, NULL, 'main'),
(1103, 48713842, 'RUN', 133, NULL, NULL, NULL, 'main'),
(1104, 48713842, 'Time', 134, NULL, NULL, NULL, 'main'),
(1105, 48713842, 'Al', 135, NULL, NULL, NULL, 'main'),
(1106, 48713842, 'ejecutarlos', 136, NULL, NULL, NULL, 'main'),
(1107, 48713842, 'o', 137, NULL, NULL, NULL, 'main'),
(1108, 48713842, 'analizar', 138, NULL, NULL, NULL, 'main'),
(1109, 48713842, 'un', 139, NULL, NULL, NULL, 'main'),
(1110, 48713842, 'ejecutable', 140, NULL, NULL, NULL, 'main'),
(1111, 48713842, 'cifrado', 141, NULL, NULL, NULL, 'main'),
(1112, 48713842, 'mediante', 142, NULL, NULL, NULL, 'main'),
(1113, 48713842, 'un', 143, NULL, NULL, NULL, 'main'),
(1114, 48713842, 'crypter', 144, NULL, NULL, NULL, 'main'),
(1115, 48713842, 'de', 145, NULL, NULL, NULL, 'main'),
(1116, 48713842, 'este', 146, NULL, NULL, NULL, 'main'),
(1117, 48713842, 'tipo', 147, NULL, NULL, NULL, 'main'),
(1118, 48713842, 'ser', 148, NULL, NULL, NULL, 'main'),
(1119, 48713842, 'm', 149, NULL, NULL, NULL, 'main'),
(1120, 48713842, 's', 150, NULL, NULL, NULL, 'main'),
(1121, 48713842, 'improbable', 151, NULL, NULL, NULL, 'main'),
(1122, 48713842, 'que', 152, NULL, NULL, NULL, 'main'),
(1123, 48713842, 'sea', 153, NULL, NULL, NULL, 'main'),
(1124, 48713842, 'detectado', 154, NULL, NULL, NULL, 'main'),
(1125, 48713842, 'por', 155, NULL, NULL, NULL, 'main'),
(1126, 48713842, 'un', 156, NULL, NULL, NULL, 'main'),
(1127, 48713842, 'antivirus', 157, NULL, NULL, NULL, 'main'),
(1128, 48713842, 'Este', 158, NULL, NULL, NULL, 'main'),
(1129, 48713842, 'tipo', 159, NULL, NULL, NULL, 'main'),
(1130, 48713842, 'son', 160, NULL, NULL, NULL, 'main'),
(1131, 48713842, 'mas', 161, NULL, NULL, NULL, 'main'),
(1132, 48713842, 'complejos', 162, NULL, NULL, NULL, 'main'),
(1133, 48713842, 'que', 163, NULL, NULL, NULL, 'main'),
(1134, 48713842, 'los', 164, NULL, NULL, NULL, 'main'),
(1135, 48713842, 'anteriores', 165, NULL, NULL, NULL, 'main'),
(1136, 48713842, 'en', 166, NULL, NULL, NULL, 'main'),
(1137, 48713842, 'cuanto', 167, NULL, NULL, NULL, 'main'),
(1138, 48713842, 'funcionamiento', 168, NULL, NULL, NULL, 'main'),
(1139, 48713842, 'y', 169, NULL, NULL, NULL, 'main'),
(1140, 48713842, 'dise', 170, NULL, NULL, NULL, 'main'),
(1141, 48713842, 'o', 171, NULL, NULL, NULL, 'main'),
(1142, 48713842, 'En', 172, NULL, NULL, NULL, 'main'),
(1143, 48713842, 'muchas', 173, NULL, NULL, NULL, 'main'),
(1144, 48713842, 'comunidades', 174, NULL, NULL, NULL, 'main'),
(1145, 48713842, 'y', 175, NULL, NULL, NULL, 'main'),
(1146, 48713842, 'p', 176, NULL, NULL, NULL, 'main'),
(1147, 48713842, 'ginas', 177, NULL, NULL, NULL, 'main'),
(1148, 48713842, 'de', 178, NULL, NULL, NULL, 'main'),
(1149, 48713842, 'internet', 179, NULL, NULL, NULL, 'main'),
(1150, 48713842, 'se', 180, NULL, NULL, NULL, 'main'),
(1151, 48713842, 'hace', 181, NULL, NULL, NULL, 'main'),
(1152, 48713842, 'referencia', 182, NULL, NULL, NULL, 'main'),
(1153, 48713842, 'a', 183, NULL, NULL, NULL, 'main'),
(1154, 48713842, 'un', 184, NULL, NULL, NULL, 'main'),
(1155, 48713842, 'tipo', 185, NULL, NULL, NULL, 'main'),
(1156, 48713842, 'de', 186, NULL, NULL, NULL, 'main'),
(1157, 48713842, 'crypter', 187, NULL, NULL, NULL, 'main'),
(1158, 48713842, 'llamado', 188, NULL, NULL, NULL, 'main'),
(1159, 48713842, 'FUD', 189, NULL, NULL, NULL, 'main'),
(1160, 48713842, 'stos', 190, NULL, NULL, NULL, 'main'),
(1161, 48713842, 'se', 191, NULL, NULL, NULL, 'main'),
(1162, 48713842, 'd', 192, NULL, NULL, NULL, 'main'),
(1163, 48713842, 'cen', 193, NULL, NULL, NULL, 'main'),
(1164, 48713842, 'que', 194, NULL, NULL, NULL, 'main'),
(1165, 48713842, 'son', 195, NULL, NULL, NULL, 'main'),
(1166, 48713842, 'FUD', 196, NULL, NULL, NULL, 'main'),
(1167, 48713842, 'cuando', 197, NULL, NULL, NULL, 'main'),
(1168, 48713842, 'el', 198, NULL, NULL, NULL, 'main'),
(1169, 48713842, 'ejecutable', 199, NULL, NULL, NULL, 'main'),
(1170, 48713842, 'final', 200, NULL, NULL, NULL, 'main'),
(1171, 48713842, 'cifrado', 201, NULL, NULL, NULL, 'main'),
(1172, 48713842, 'es', 202, NULL, NULL, NULL, 'main'),
(1173, 48713842, 'indetectable', 203, NULL, NULL, NULL, 'main'),
(1174, 48713842, 'a', 204, NULL, NULL, NULL, 'main'),
(1175, 48713842, 'todos', 205, NULL, NULL, NULL, 'main'),
(1176, 48713842, 'los', 206, NULL, NULL, NULL, 'main'),
(1177, 48713842, 'antivirus', 207, NULL, NULL, NULL, 'main'),
(2402, 159635450, 'ranging', 31, NULL, NULL, NULL, 'main'),
(2401, 159635450, 'activities', 30, NULL, NULL, NULL, 'main'),
(2400, 159635450, 'malicious', 29, NULL, NULL, NULL, 'main'),
(2399, 159635450, 'various', 28, NULL, NULL, NULL, 'main'),
(2398, 159635450, 'for', 27, NULL, NULL, NULL, 'main'),
(2397, 159635450, 'used', 26, NULL, NULL, NULL, 'main'),
(2396, 159635450, 'be', 25, NULL, NULL, NULL, 'main'),
(2395, 159635450, 'can', 24, NULL, NULL, NULL, 'main'),
(2394, 159635450, 'It', 23, NULL, NULL, NULL, 'main'),
(2393, 159635450, 'others', 22, NULL, NULL, NULL, 'main'),
(2392, 159635450, 'with', 21, NULL, NULL, NULL, 'main'),
(2391, 159635450, 'share', 20, NULL, NULL, NULL, 'main'),
(2390, 159635450, 'not', 19, NULL, NULL, NULL, 'main'),
(2389, 159635450, 'does', 18, NULL, NULL, NULL, 'main'),
(2388, 159635450, 'user', 17, NULL, NULL, NULL, 'main'),
(2387, 159635450, 'a', 16, NULL, NULL, NULL, 'main'),
(2386, 159635450, 'that', 15, NULL, NULL, NULL, 'main'),
(2385, 159635450, 'one', 14, NULL, NULL, NULL, 'main'),
(2384, 159635450, 'is', 13, NULL, NULL, NULL, 'main'),
(2383, 159635450, '1080', 12, NULL, NULL, NULL, 'main'),
(2382, 159635450, '1082', 11, NULL, NULL, NULL, 'main'),
(2381, 159635450, '1080', 10, NULL, NULL, NULL, 'main'),
(2380, 159635450, '1076', 9, NULL, NULL, NULL, 'main'),
(2379, 159635450, '1077', 8, NULL, NULL, NULL, 'main'),
(2378, 159635450, '1044', 7, NULL, NULL, NULL, 'main'),
(1214, 530557753, 'Linux', 1, NULL, NULL, NULL, 'main'),
(1215, 530557753, 'Rootkit', 2, NULL, NULL, NULL, 'main'),
(1216, 530557753, 'Un', 3, NULL, NULL, NULL, 'main'),
(1217, 530557753, 'rootkit', 4, NULL, NULL, NULL, 'main'),
(1218, 530557753, 'es', 5, NULL, NULL, NULL, 'main'),
(1219, 530557753, 'una', 6, NULL, NULL, NULL, 'main'),
(1220, 530557753, 'herramienta', 7, NULL, NULL, NULL, 'main'),
(1221, 530557753, 'o', 8, NULL, NULL, NULL, 'main'),
(1222, 530557753, 'un', 9, NULL, NULL, NULL, 'main'),
(1223, 530557753, 'grupo', 10, NULL, NULL, NULL, 'main'),
(1224, 530557753, 'de', 11, NULL, NULL, NULL, 'main'),
(1225, 530557753, 'ellas', 12, NULL, NULL, NULL, 'main'),
(1226, 530557753, 'que', 13, NULL, NULL, NULL, 'main'),
(1227, 530557753, 'tiene', 14, NULL, NULL, NULL, 'main'),
(1228, 530557753, 'como', 15, NULL, NULL, NULL, 'main'),
(1229, 530557753, 'finalidad', 16, NULL, NULL, NULL, 'main'),
(1230, 530557753, 'esconderse', 17, NULL, NULL, NULL, 'main'),
(1231, 530557753, 'a', 18, NULL, NULL, NULL, 'main'),
(1232, 530557753, 's', 19, NULL, NULL, NULL, 'main'),
(1233, 530557753, 'misma', 20, NULL, NULL, NULL, 'main'),
(1234, 530557753, 'y', 21, NULL, NULL, NULL, 'main'),
(1235, 530557753, 'esconder', 22, NULL, NULL, NULL, 'main'),
(1236, 530557753, 'otros', 23, NULL, NULL, NULL, 'main'),
(1237, 530557753, 'programas', 24, NULL, NULL, NULL, 'main'),
(1238, 530557753, 'procesos', 25, NULL, NULL, NULL, 'main'),
(1239, 530557753, 'archivos', 26, NULL, NULL, NULL, 'main'),
(1240, 530557753, 'directorios', 27, NULL, NULL, NULL, 'main'),
(1241, 530557753, 'claves', 28, NULL, NULL, NULL, 'main'),
(1242, 530557753, 'de', 29, NULL, NULL, NULL, 'main'),
(1243, 530557753, 'registro', 30, NULL, NULL, NULL, 'main'),
(1244, 530557753, 'y', 31, NULL, NULL, NULL, 'main'),
(1245, 530557753, 'puertos', 32, NULL, NULL, NULL, 'main'),
(1246, 530557753, 'que', 33, NULL, NULL, NULL, 'main'),
(1247, 530557753, 'permiten', 34, NULL, NULL, NULL, 'main'),
(1248, 530557753, 'al', 35, NULL, NULL, NULL, 'main'),
(1249, 530557753, 'intruso', 36, NULL, NULL, NULL, 'main'),
(1250, 530557753, 'mantener', 37, NULL, NULL, NULL, 'main'),
(1251, 530557753, 'el', 38, NULL, NULL, NULL, 'main'),
(1252, 530557753, 'acceso', 39, NULL, NULL, NULL, 'main'),
(1253, 530557753, 'a', 40, NULL, NULL, NULL, 'main'),
(1254, 530557753, 'un', 41, NULL, NULL, NULL, 'main'),
(1255, 530557753, 'sistema', 42, NULL, NULL, NULL, 'main'),
(1256, 530557753, 'para', 43, NULL, NULL, NULL, 'main'),
(1257, 530557753, 'remotamente', 44, NULL, NULL, NULL, 'main'),
(1258, 530557753, 'comandar', 45, NULL, NULL, NULL, 'main'),
(1259, 530557753, 'acciones', 46, NULL, NULL, NULL, 'main'),
(1260, 530557753, 'o', 47, NULL, NULL, NULL, 'main'),
(1261, 530557753, 'extraer', 48, NULL, NULL, NULL, 'main'),
(1262, 530557753, 'informaci', 49, NULL, NULL, NULL, 'main'),
(1263, 530557753, 'n', 50, NULL, NULL, NULL, 'main'),
(1264, 530557753, 'sensible', 51, NULL, NULL, NULL, 'main'),
(1265, 530557753, 'Existen', 52, NULL, NULL, NULL, 'main'),
(1266, 530557753, 'rootkits', 53, NULL, NULL, NULL, 'main'),
(1267, 530557753, 'para', 54, NULL, NULL, NULL, 'main'),
(1268, 530557753, 'una', 55, NULL, NULL, NULL, 'main'),
(1269, 530557753, 'amplia', 56, NULL, NULL, NULL, 'main'),
(1270, 530557753, 'variedad', 57, NULL, NULL, NULL, 'main'),
(1271, 530557753, 'de', 58, NULL, NULL, NULL, 'main'),
(1272, 530557753, 'sistemas', 59, NULL, NULL, NULL, 'main'),
(1273, 530557753, 'operativos', 60, NULL, NULL, NULL, 'main'),
(1274, 530557753, 'como', 61, NULL, NULL, NULL, 'main'),
(1275, 530557753, 'GNU', 62, NULL, NULL, NULL, 'main'),
(1276, 530557753, 'Linux', 63, NULL, NULL, NULL, 'main'),
(1277, 530557753, 'Solaris', 64, NULL, NULL, NULL, 'main'),
(1278, 530557753, 'o', 65, NULL, NULL, NULL, 'main'),
(1279, 530557753, 'Microsoft', 66, NULL, NULL, NULL, 'main'),
(1280, 530557753, 'Windows', 67, NULL, NULL, NULL, 'main'),
(1281, 530557753, 'Uso', 68, NULL, NULL, NULL, 'main'),
(1282, 530557753, 'de', 69, NULL, NULL, NULL, 'main'),
(1283, 530557753, 'los', 70, NULL, NULL, NULL, 'main'),
(1284, 530557753, 'Rootkits', 71, NULL, NULL, NULL, 'main'),
(1285, 530557753, 'Un', 72, NULL, NULL, NULL, 'main'),
(1286, 530557753, 'rootkit', 73, NULL, NULL, NULL, 'main'),
(1287, 530557753, 'se', 74, NULL, NULL, NULL, 'main'),
(1288, 530557753, 'usa', 75, NULL, NULL, NULL, 'main'),
(1289, 530557753, 'habitualmente', 76, NULL, NULL, NULL, 'main'),
(1290, 530557753, 'para', 77, NULL, NULL, NULL, 'main'),
(1291, 530557753, 'esconder', 78, NULL, NULL, NULL, 'main'),
(1292, 530557753, 'algunas', 79, NULL, NULL, NULL, 'main'),
(1293, 530557753, 'aplicaciones', 80, NULL, NULL, NULL, 'main'),
(1294, 530557753, 'que', 81, NULL, NULL, NULL, 'main'),
(1295, 530557753, 'podr', 82, NULL, NULL, NULL, 'main'),
(1296, 530557753, 'an', 83, NULL, NULL, NULL, 'main'),
(1297, 530557753, 'actuar', 84, NULL, NULL, NULL, 'main'),
(1298, 530557753, 'en', 85, NULL, NULL, NULL, 'main'),
(1299, 530557753, 'el', 86, NULL, NULL, NULL, 'main'),
(1300, 530557753, 'sistema', 87, NULL, NULL, NULL, 'main'),
(1301, 530557753, 'atacado', 88, NULL, NULL, NULL, 'main'),
(1302, 530557753, 'Suelen', 89, NULL, NULL, NULL, 'main'),
(1303, 530557753, 'incluir', 90, NULL, NULL, NULL, 'main'),
(1304, 530557753, 'backdoors', 91, NULL, NULL, NULL, 'main'),
(1305, 530557753, 'puertas', 92, NULL, NULL, NULL, 'main'),
(1306, 530557753, 'traseras', 93, NULL, NULL, NULL, 'main'),
(1307, 530557753, 'para', 94, NULL, NULL, NULL, 'main'),
(1308, 530557753, 'ayudar', 95, NULL, NULL, NULL, 'main'),
(1309, 530557753, 'al', 96, NULL, NULL, NULL, 'main'),
(1310, 530557753, 'intruso', 97, NULL, NULL, NULL, 'main'),
(1311, 530557753, 'a', 98, NULL, NULL, NULL, 'main'),
(1312, 530557753, 'acceder', 99, NULL, NULL, NULL, 'main'),
(1313, 530557753, 'f', 100, NULL, NULL, NULL, 'main'),
(1314, 530557753, 'cilmente', 101, NULL, NULL, NULL, 'main'),
(1315, 530557753, 'al', 102, NULL, NULL, NULL, 'main'),
(1316, 530557753, 'sistema', 103, NULL, NULL, NULL, 'main'),
(1317, 530557753, 'una', 104, NULL, NULL, NULL, 'main'),
(1318, 530557753, 'vez', 105, NULL, NULL, NULL, 'main'),
(1319, 530557753, 'que', 106, NULL, NULL, NULL, 'main'),
(1320, 530557753, 'se', 107, NULL, NULL, NULL, 'main'),
(1321, 530557753, 'ha', 108, NULL, NULL, NULL, 'main'),
(1322, 530557753, 'conseguido', 109, NULL, NULL, NULL, 'main'),
(1323, 530557753, 'entrar', 110, NULL, NULL, NULL, 'main'),
(1324, 530557753, 'por', 111, NULL, NULL, NULL, 'main'),
(1325, 530557753, 'primera', 112, NULL, NULL, NULL, 'main'),
(1326, 530557753, 'vez', 113, NULL, NULL, NULL, 'main'),
(1327, 530557753, 'Por', 114, NULL, NULL, NULL, 'main'),
(1328, 530557753, 'ejemplo', 115, NULL, NULL, NULL, 'main'),
(1329, 530557753, 'el', 116, NULL, NULL, NULL, 'main'),
(1330, 530557753, 'rootkit', 117, NULL, NULL, NULL, 'main'),
(1331, 530557753, 'puede', 118, NULL, NULL, NULL, 'main'),
(1332, 530557753, 'esconder', 119, NULL, NULL, NULL, 'main'),
(1333, 530557753, 'una', 120, NULL, NULL, NULL, 'main'),
(1334, 530557753, 'aplicaci', 121, NULL, NULL, NULL, 'main'),
(1335, 530557753, 'n', 122, NULL, NULL, NULL, 'main'),
(1336, 530557753, 'que', 123, NULL, NULL, NULL, 'main'),
(1337, 530557753, 'lance', 124, NULL, NULL, NULL, 'main'),
(1338, 530557753, 'una', 125, NULL, NULL, NULL, 'main'),
(1339, 530557753, 'consola', 126, NULL, NULL, NULL, 'main'),
(1340, 530557753, 'cada', 127, NULL, NULL, NULL, 'main'),
(1341, 530557753, 'vez', 128, NULL, NULL, NULL, 'main'),
(1342, 530557753, 'que', 129, NULL, NULL, NULL, 'main'),
(1343, 530557753, 'el', 130, NULL, NULL, NULL, 'main'),
(1344, 530557753, 'atacante', 131, NULL, NULL, NULL, 'main'),
(1345, 530557753, 'se', 132, NULL, NULL, NULL, 'main'),
(1346, 530557753, 'conecte', 133, NULL, NULL, NULL, 'main'),
(1347, 530557753, 'al', 134, NULL, NULL, NULL, 'main'),
(1348, 530557753, 'sistema', 135, NULL, NULL, NULL, 'main'),
(1349, 530557753, 'a', 136, NULL, NULL, NULL, 'main'),
(1350, 530557753, 'trav', 137, NULL, NULL, NULL, 'main'),
(1351, 530557753, 's', 138, NULL, NULL, NULL, 'main'),
(1352, 530557753, 'de', 139, NULL, NULL, NULL, 'main'),
(1353, 530557753, 'un', 140, NULL, NULL, NULL, 'main'),
(1354, 530557753, 'determinado', 141, NULL, NULL, NULL, 'main'),
(1355, 530557753, 'puerto', 142, NULL, NULL, NULL, 'main'),
(1356, 530557753, 'Los', 143, NULL, NULL, NULL, 'main'),
(1357, 530557753, 'rootkits', 144, NULL, NULL, NULL, 'main'),
(1358, 530557753, 'del', 145, NULL, NULL, NULL, 'main'),
(1359, 530557753, 'kernel', 146, NULL, NULL, NULL, 'main'),
(1360, 530557753, 'o', 147, NULL, NULL, NULL, 'main'),
(1361, 530557753, 'n', 148, NULL, NULL, NULL, 'main'),
(1362, 530557753, 'cleo', 149, NULL, NULL, NULL, 'main'),
(1363, 530557753, 'pueden', 150, NULL, NULL, NULL, 'main'),
(1364, 530557753, 'contener', 151, NULL, NULL, NULL, 'main'),
(1365, 530557753, 'funcionalidades', 152, NULL, NULL, NULL, 'main'),
(1366, 530557753, 'similares', 153, NULL, NULL, NULL, 'main'),
(1367, 530557753, 'Un', 154, NULL, NULL, NULL, 'main'),
(1368, 530557753, 'backdoor', 155, NULL, NULL, NULL, 'main'),
(1369, 530557753, 'puede', 156, NULL, NULL, NULL, 'main'),
(1370, 530557753, 'permitir', 157, NULL, NULL, NULL, 'main'),
(1371, 530557753, 'tambi', 158, NULL, NULL, NULL, 'main'),
(1372, 530557753, 'n', 159, NULL, NULL, NULL, 'main'),
(1373, 530557753, 'que', 160, NULL, NULL, NULL, 'main'),
(1374, 530557753, 'los', 161, NULL, NULL, NULL, 'main'),
(1375, 530557753, 'procesos', 162, NULL, NULL, NULL, 'main'),
(1376, 530557753, 'lanzados', 163, NULL, NULL, NULL, 'main'),
(1377, 530557753, 'por', 164, NULL, NULL, NULL, 'main'),
(1378, 530557753, 'un', 165, NULL, NULL, NULL, 'main'),
(1379, 530557753, 'usuario', 166, NULL, NULL, NULL, 'main'),
(1380, 530557753, 'sin', 167, NULL, NULL, NULL, 'main'),
(1381, 530557753, 'privilegios', 168, NULL, NULL, NULL, 'main'),
(1382, 530557753, 'de', 169, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` (`id`, `ItemNum`, `value`, `pos`, `field_num`, `field_id`, `field_value`, `field_type`) VALUES
(1383, 530557753, 'administrador', 170, NULL, NULL, NULL, 'main'),
(1384, 530557753, 'ejecuten', 171, NULL, NULL, NULL, 'main'),
(1385, 530557753, 'algunas', 172, NULL, NULL, NULL, 'main'),
(1386, 530557753, 'funcionalidades', 173, NULL, NULL, NULL, 'main'),
(1387, 530557753, 'reservadas', 174, NULL, NULL, NULL, 'main'),
(1388, 530557753, 'nicamente', 175, NULL, NULL, NULL, 'main'),
(1389, 530557753, 'al', 176, NULL, NULL, NULL, 'main'),
(1390, 530557753, 'superusuario', 177, NULL, NULL, NULL, 'main'),
(1391, 530557753, 'Todo', 178, NULL, NULL, NULL, 'main'),
(1392, 530557753, 'tipo', 179, NULL, NULL, NULL, 'main'),
(1393, 530557753, 'de', 180, NULL, NULL, NULL, 'main'),
(1394, 530557753, 'herramientas', 181, NULL, NULL, NULL, 'main'),
(1395, 530557753, 'tiles', 182, NULL, NULL, NULL, 'main'),
(1396, 530557753, 'para', 183, NULL, NULL, NULL, 'main'),
(1397, 530557753, 'obtener', 184, NULL, NULL, NULL, 'main'),
(1398, 530557753, 'informaci', 185, NULL, NULL, NULL, 'main'),
(1399, 530557753, 'n', 186, NULL, NULL, NULL, 'main'),
(1400, 530557753, 'de', 187, NULL, NULL, NULL, 'main'),
(1401, 530557753, 'forma', 188, NULL, NULL, NULL, 'main'),
(1402, 530557753, 'il', 189, NULL, NULL, NULL, 'main'),
(1403, 530557753, 'cita', 190, NULL, NULL, NULL, 'main'),
(1404, 530557753, 'pueden', 191, NULL, NULL, NULL, 'main'),
(1405, 530557753, 'ser', 192, NULL, NULL, NULL, 'main'),
(1406, 530557753, 'ocultadas', 193, NULL, NULL, NULL, 'main'),
(1407, 530557753, 'mediante', 194, NULL, NULL, NULL, 'main'),
(1408, 530557753, 'rootkits', 195, NULL, NULL, NULL, 'main'),
(2377, 159635450, 'server', 6, NULL, NULL, NULL, 'main'),
(2376, 159635450, 'dedicated', 5, NULL, NULL, NULL, 'main'),
(2375, 159635450, 'A', 4, NULL, NULL, NULL, 'main'),
(2374, 159635450, '2008', 3, NULL, NULL, NULL, 'main'),
(2373, 159635450, 'server', 2, NULL, NULL, NULL, 'main'),
(2372, 159635450, 'Windows', 1, NULL, NULL, NULL, 'main'),
(2334, 250247607, 'working', 272, NULL, NULL, NULL, 'main'),
(2333, 250247607, 'When', 271, NULL, NULL, NULL, 'main'),
(2332, 250247607, 'them', 270, NULL, NULL, NULL, 'main'),
(2331, 250247607, 'on', 269, NULL, NULL, NULL, 'main'),
(2330, 250247607, 'well', 268, NULL, NULL, NULL, 'main'),
(2329, 250247607, 'very', 267, NULL, NULL, NULL, 'main'),
(2328, 250247607, 'work', 266, NULL, NULL, NULL, 'main'),
(2327, 250247607, 'programs', 265, NULL, NULL, NULL, 'main'),
(2326, 250247607, 'popular', 264, NULL, NULL, NULL, 'main'),
(2325, 250247607, 'other', 263, NULL, NULL, NULL, 'main'),
(2324, 250247607, 'several', 262, NULL, NULL, NULL, 'main'),
(2323, 250247607, 'and', 261, NULL, NULL, NULL, 'main'),
(2322, 250247607, 'ICQ', 260, NULL, NULL, NULL, 'main'),
(2321, 250247607, 'of', 259, NULL, NULL, NULL, 'main'),
(2320, 250247607, 'version', 258, NULL, NULL, NULL, 'main'),
(2319, 250247607, 'any', 257, NULL, NULL, NULL, 'main'),
(2318, 250247607, 'but', 256, NULL, NULL, NULL, 'main'),
(2317, 250247607, 'own', 255, NULL, NULL, NULL, 'main'),
(2316, 250247607, 'their', 254, NULL, NULL, NULL, 'main'),
(2315, 250247607, 'on', 253, NULL, NULL, NULL, 'main'),
(2314, 250247607, 'servers', 252, NULL, NULL, NULL, 'main'),
(2313, 250247607, 'proxy', 251, NULL, NULL, NULL, 'main'),
(2312, 250247607, 'SOCKS', 250, NULL, NULL, NULL, 'main'),
(2311, 250247607, 'on', 249, NULL, NULL, NULL, 'main'),
(2310, 250247607, 'work', 248, NULL, NULL, NULL, 'main'),
(2309, 250247607, 'cannot', 247, NULL, NULL, NULL, 'main'),
(2308, 250247607, 'Browsers', 246, NULL, NULL, NULL, 'main'),
(2307, 250247607, 'server', 245, NULL, NULL, NULL, 'main'),
(2306, 250247607, 'proxy', 244, NULL, NULL, NULL, 'main'),
(2305, 250247607, 'SOCKS', 243, NULL, NULL, NULL, 'main'),
(2304, 250247607, 'a', 242, NULL, NULL, NULL, 'main'),
(2303, 250247607, 'use', 241, NULL, NULL, NULL, 'main'),
(2302, 250247607, 'to', 240, NULL, NULL, NULL, 'main'),
(2301, 250247607, 'browser', 239, NULL, NULL, NULL, 'main'),
(2300, 250247607, 'a', 238, NULL, NULL, NULL, 'main'),
(2299, 250247607, 'for', 237, NULL, NULL, NULL, 'main'),
(2298, 250247607, 'required', 236, NULL, NULL, NULL, 'main'),
(2297, 250247607, 'are', 235, NULL, NULL, NULL, 'main'),
(2296, 250247607, 'programs', 234, NULL, NULL, NULL, 'main'),
(2295, 250247607, 'Additional', 233, NULL, NULL, NULL, 'main'),
(2294, 250247607, 'them', 232, NULL, NULL, NULL, 'main'),
(2293, 250247607, 'with', 231, NULL, NULL, NULL, 'main'),
(2292, 250247607, 'work', 230, NULL, NULL, NULL, 'main'),
(2291, 250247607, 'to', 229, NULL, NULL, NULL, 'main'),
(2290, 250247607, 'able', 228, NULL, NULL, NULL, 'main'),
(2289, 250247607, 'made', 227, NULL, NULL, NULL, 'main'),
(2288, 250247607, 'be', 226, NULL, NULL, NULL, 'main'),
(2287, 250247607, 'explicitly', 225, NULL, NULL, NULL, 'main'),
(2286, 250247607, 'must', 224, NULL, NULL, NULL, 'main'),
(2285, 250247607, 'programs', 223, NULL, NULL, NULL, 'main'),
(2284, 250247607, 'however', 222, NULL, NULL, NULL, 'main'),
(2283, 250247607, 'servers', 221, NULL, NULL, NULL, 'main'),
(2282, 250247607, 'proxy', 220, NULL, NULL, NULL, 'main'),
(2281, 250247607, 'SOCKS', 219, NULL, NULL, NULL, 'main'),
(2280, 250247607, 'use', 218, NULL, NULL, NULL, 'main'),
(2279, 250247607, 'To', 217, NULL, NULL, NULL, 'main'),
(2278, 250247607, 'IP', 216, NULL, NULL, NULL, 'main'),
(2277, 250247607, 'TCP', 215, NULL, NULL, NULL, 'main'),
(2276, 250247607, 'e', 214, NULL, NULL, NULL, 'main'),
(2275, 250247607, 'i', 213, NULL, NULL, NULL, 'main'),
(2274, 250247607, 'Internet', 212, NULL, NULL, NULL, 'main'),
(2273, 250247607, 'the', 211, NULL, NULL, NULL, 'main'),
(2272, 250247607, 'on', 210, NULL, NULL, NULL, 'main'),
(2271, 250247607, 'available', 209, NULL, NULL, NULL, 'main'),
(2270, 250247607, 'information', 208, NULL, NULL, NULL, 'main'),
(2269, 250247607, 'of', 207, NULL, NULL, NULL, 'main'),
(2268, 250247607, 'kind', 206, NULL, NULL, NULL, 'main'),
(2267, 250247607, 'every', 205, NULL, NULL, NULL, 'main'),
(2266, 250247607, 'practically', 204, NULL, NULL, NULL, 'main'),
(2265, 250247607, 'with', 203, NULL, NULL, NULL, 'main'),
(2264, 250247607, 'works', 202, NULL, NULL, NULL, 'main'),
(2263, 250247607, 'server', 201, NULL, NULL, NULL, 'main'),
(2262, 250247607, 'proxy', 200, NULL, NULL, NULL, 'main'),
(2261, 250247607, 'of', 199, NULL, NULL, NULL, 'main'),
(2260, 250247607, 'kind', 198, NULL, NULL, NULL, 'main'),
(2259, 250247607, 'This', 197, NULL, NULL, NULL, 'main'),
(2258, 250247607, 'server', 196, NULL, NULL, NULL, 'main'),
(2257, 250247607, 'proxy', 195, NULL, NULL, NULL, 'main'),
(2256, 250247607, 'SOCKS', 194, NULL, NULL, NULL, 'main'),
(2255, 250247607, 'server', 193, NULL, NULL, NULL, 'main'),
(2254, 250247607, 'proxy', 192, NULL, NULL, NULL, 'main'),
(2253, 250247607, 'of', 191, NULL, NULL, NULL, 'main'),
(2252, 250247607, 'type', 190, NULL, NULL, NULL, 'main'),
(2251, 250247607, 'this', 189, NULL, NULL, NULL, 'main'),
(2250, 250247607, 'via', 188, NULL, NULL, NULL, 'main'),
(2249, 250247607, 'runs', 187, NULL, NULL, NULL, 'main'),
(2248, 250247607, 'also', 186, NULL, NULL, NULL, 'main'),
(2247, 250247607, 'version', 185, NULL, NULL, NULL, 'main'),
(2246, 250247607, 'browser', 184, NULL, NULL, NULL, 'main'),
(2245, 250247607, 'Any', 183, NULL, NULL, NULL, 'main'),
(2244, 250247607, 'server', 182, NULL, NULL, NULL, 'main'),
(2243, 250247607, 'proxy', 181, NULL, NULL, NULL, 'main'),
(2242, 250247607, 'HTTP', 180, NULL, NULL, NULL, 'main'),
(2241, 250247607, 'an', 179, NULL, NULL, NULL, 'main'),
(2240, 250247607, 'via', 178, NULL, NULL, NULL, 'main'),
(2239, 250247607, 'run', 177, NULL, NULL, NULL, 'main'),
(2238, 250247607, 'can', 176, NULL, NULL, NULL, 'main'),
(2237, 250247607, 'etc', 175, NULL, NULL, NULL, 'main'),
(2236, 250247607, 'ICQ', 174, NULL, NULL, NULL, 'main'),
(2235, 250247607, 'g', 173, NULL, NULL, NULL, 'main'),
(2234, 250247607, 'e', 172, NULL, NULL, NULL, 'main'),
(2233, 250247607, 'applications', 171, NULL, NULL, NULL, 'main'),
(2232, 250247607, 'of', 170, NULL, NULL, NULL, 'main'),
(2231, 250247607, 'versions', 169, NULL, NULL, NULL, 'main'),
(2230, 250247607, 'latest', 168, NULL, NULL, NULL, 'main'),
(2229, 250247607, 'The', 167, NULL, NULL, NULL, 'main'),
(2228, 250247607, 'files', 166, NULL, NULL, NULL, 'main'),
(2227, 250247607, 'download', 165, NULL, NULL, NULL, 'main'),
(2226, 250247607, 'to', 164, NULL, NULL, NULL, 'main'),
(2225, 250247607, 'as', 163, NULL, NULL, NULL, 'main'),
(2224, 250247607, 'well', 162, NULL, NULL, NULL, 'main'),
(2223, 250247607, 'as', 161, NULL, NULL, NULL, 'main'),
(2222, 250247607, 'images', 160, NULL, NULL, NULL, 'main'),
(2221, 250247607, 'and', 159, NULL, NULL, NULL, 'main'),
(2220, 250247607, 'pages', 158, NULL, NULL, NULL, 'main'),
(2219, 250247607, 'web', 157, NULL, NULL, NULL, 'main'),
(2218, 250247607, 'view', 156, NULL, NULL, NULL, 'main'),
(2217, 250247607, 'to', 155, NULL, NULL, NULL, 'main'),
(2216, 250247607, 'users', 154, NULL, NULL, NULL, 'main'),
(2215, 250247607, 'allowed', 153, NULL, NULL, NULL, 'main'),
(2214, 250247607, 'only', 152, NULL, NULL, NULL, 'main'),
(2213, 250247607, 'server', 151, NULL, NULL, NULL, 'main'),
(2212, 250247607, 'of', 150, NULL, NULL, NULL, 'main'),
(2211, 250247607, 'kind', 149, NULL, NULL, NULL, 'main'),
(2210, 250247607, 'this', 148, NULL, NULL, NULL, 'main'),
(2209, 250247607, 'past', 147, NULL, NULL, NULL, 'main'),
(2208, 250247607, 'the', 146, NULL, NULL, NULL, 'main'),
(2207, 250247607, 'In', 145, NULL, NULL, NULL, 'main'),
(2206, 250247607, 'server', 144, NULL, NULL, NULL, 'main'),
(2205, 250247607, 'of', 143, NULL, NULL, NULL, 'main'),
(2204, 250247607, 'type', 142, NULL, NULL, NULL, 'main'),
(2203, 250247607, 'this', 141, NULL, NULL, NULL, 'main'),
(2202, 250247607, 'to', 140, NULL, NULL, NULL, 'main'),
(2201, 250247607, 'refers', 139, NULL, NULL, NULL, 'main'),
(2200, 250247607, 'often', 138, NULL, NULL, NULL, 'main'),
(2199, 250247607, 'most', 137, NULL, NULL, NULL, 'main'),
(2198, 250247607, 'server', 136, NULL, NULL, NULL, 'main'),
(2197, 250247607, 'proxy', 135, NULL, NULL, NULL, 'main'),
(2196, 250247607, 'a', 134, NULL, NULL, NULL, 'main'),
(2195, 250247607, 'fact', 133, NULL, NULL, NULL, 'main'),
(2194, 250247607, 'In', 132, NULL, NULL, NULL, 'main'),
(2193, 250247607, 'server', 131, NULL, NULL, NULL, 'main'),
(2192, 250247607, 'proxy', 130, NULL, NULL, NULL, 'main'),
(2191, 250247607, 'of', 129, NULL, NULL, NULL, 'main'),
(2190, 250247607, 'form', 128, NULL, NULL, NULL, 'main'),
(2189, 250247607, 'prevalent', 127, NULL, NULL, NULL, 'main'),
(2188, 250247607, 'most', 126, NULL, NULL, NULL, 'main'),
(2187, 250247607, 'The', 125, NULL, NULL, NULL, 'main'),
(2186, 250247607, 'server', 124, NULL, NULL, NULL, 'main'),
(2185, 250247607, 'proxy', 123, NULL, NULL, NULL, 'main'),
(2184, 250247607, 'HTTP', 122, NULL, NULL, NULL, 'main'),
(2183, 250247607, 'are', 121, NULL, NULL, NULL, 'main'),
(2182, 250247607, 'servers', 120, NULL, NULL, NULL, 'main'),
(2181, 250247607, 'proxy', 119, NULL, NULL, NULL, 'main'),
(2180, 250247607, 'of', 118, NULL, NULL, NULL, 'main'),
(2179, 250247607, 'types', 117, NULL, NULL, NULL, 'main'),
(2178, 250247607, 'main', 116, NULL, NULL, NULL, 'main'),
(2177, 250247607, 'The', 115, NULL, NULL, NULL, 'main'),
(2176, 250247607, 'anonymity', 114, NULL, NULL, NULL, 'main'),
(2175, 250247607, 'complete', 113, NULL, NULL, NULL, 'main'),
(2174, 250247607, 'provide', 112, NULL, NULL, NULL, 'main'),
(2173, 250247607, 'cannot', 111, NULL, NULL, NULL, 'main'),
(2172, 250247607, 'and', 110, NULL, NULL, NULL, 'main'),
(2171, 250247607, 'logs', 109, NULL, NULL, NULL, 'main'),
(2170, 250247607, 'keep', 108, NULL, NULL, NULL, 'main'),
(2169, 250247607, 'ones', 107, NULL, NULL, NULL, 'main'),
(2168, 250247607, 'paid', 106, NULL, NULL, NULL, 'main'),
(2167, 250247607, 'even', 105, NULL, NULL, NULL, 'main'),
(2166, 250247607, 'servers', 104, NULL, NULL, NULL, 'main'),
(2165, 250247607, 'such', 103, NULL, NULL, NULL, 'main'),
(2164, 250247607, 'all', 102, NULL, NULL, NULL, 'main'),
(2163, 250247607, 'operators', 101, NULL, NULL, NULL, 'main'),
(2162, 250247607, 'server', 100, NULL, NULL, NULL, 'main'),
(2161, 250247607, 'proxy', 99, NULL, NULL, NULL, 'main'),
(2160, 250247607, 'of', 98, NULL, NULL, NULL, 'main'),
(2159, 250247607, 'assurance', 97, NULL, NULL, NULL, 'main'),
(2158, 250247607, 'the', 96, NULL, NULL, NULL, 'main'),
(2157, 250247607, 'despite', 95, NULL, NULL, NULL, 'main'),
(2156, 250247607, 'that', 94, NULL, NULL, NULL, 'main'),
(2155, 250247607, 'noted', 93, NULL, NULL, NULL, 'main'),
(2154, 250247607, 'frequently', 92, NULL, NULL, NULL, 'main'),
(2153, 250247607, 'however', 91, NULL, NULL, NULL, 'main'),
(2152, 250247607, 'hackers', 90, NULL, NULL, NULL, 'main'),
(2151, 250247607, 'Even', 89, NULL, NULL, NULL, 'main'),
(2150, 250247607, 'computer', 88, NULL, NULL, NULL, 'main'),
(2149, 250247607, 's', 87, NULL, NULL, NULL, 'main'),
(2148, 250247607, 'hacker', 86, NULL, NULL, NULL, 'main'),
(2147, 250247607, 'the', 85, NULL, NULL, NULL, 'main'),
(2146, 250247607, 'of', 84, NULL, NULL, NULL, 'main'),
(2145, 250247607, 'that', 83, NULL, NULL, NULL, 'main'),
(2144, 250247607, 'not', 82, NULL, NULL, NULL, 'main'),
(2143, 250247607, 'and', 81, NULL, NULL, NULL, 'main'),
(2142, 250247607, 'server', 80, NULL, NULL, NULL, 'main'),
(2141, 250247607, 'proxy', 79, NULL, NULL, NULL, 'main'),
(2140, 250247607, 'the', 78, NULL, NULL, NULL, 'main'),
(2139, 250247607, 'of', 77, NULL, NULL, NULL, 'main'),
(2138, 250247607, 'address', 76, NULL, NULL, NULL, 'main'),
(2137, 250247607, 'IP', 75, NULL, NULL, NULL, 'main'),
(2136, 250247607, 'the', 74, NULL, NULL, NULL, 'main'),
(2135, 250247607, 'sees', 73, NULL, NULL, NULL, 'main'),
(2134, 250247607, 'server', 72, NULL, NULL, NULL, 'main'),
(2133, 250247607, 'destination', 71, NULL, NULL, NULL, 'main'),
(2132, 250247607, 'the', 70, NULL, NULL, NULL, 'main'),
(2131, 250247607, 'that', 69, NULL, NULL, NULL, 'main'),
(2130, 250247607, 'fact', 68, NULL, NULL, NULL, 'main'),
(2129, 250247607, 'the', 67, NULL, NULL, NULL, 'main'),
(2128, 250247607, 'from', 66, NULL, NULL, NULL, 'main'),
(2127, 250247607, 'comes', 65, NULL, NULL, NULL, 'main'),
(2126, 250247607, 'case', 64, NULL, NULL, NULL, 'main'),
(2125, 250247607, 'this', 63, NULL, NULL, NULL, 'main'),
(2124, 250247607, 'in', 62, NULL, NULL, NULL, 'main'),
(2123, 250247607, 'Anonymity', 61, NULL, NULL, NULL, 'main'),
(2122, 250247607, 'anonymity', 60, NULL, NULL, NULL, 'main'),
(2121, 250247607, 'ensure', 59, NULL, NULL, NULL, 'main'),
(2120, 250247607, 'to', 58, NULL, NULL, NULL, 'main'),
(2119, 250247607, 'is', 57, NULL, NULL, NULL, 'main'),
(2118, 250247607, 'hackers', 56, NULL, NULL, NULL, 'main'),
(2117, 250247607, 'among', 55, NULL, NULL, NULL, 'main'),
(2116, 250247607, 'popular', 54, NULL, NULL, NULL, 'main'),
(2115, 250247607, 'them', 53, NULL, NULL, NULL, 'main'),
(2114, 250247607, 'makes', 52, NULL, NULL, NULL, 'main'),
(2113, 250247607, 'which', 51, NULL, NULL, NULL, 'main'),
(2112, 250247607, 'purpose', 50, NULL, NULL, NULL, 'main'),
(2111, 250247607, 'main', 49, NULL, NULL, NULL, 'main'),
(2110, 250247607, 'their', 48, NULL, NULL, NULL, 'main'),
(2109, 250247607, 'but', 47, NULL, NULL, NULL, 'main'),
(2108, 250247607, 'traffic', 46, NULL, NULL, NULL, 'main'),
(2107, 250247607, 'filtering', 45, NULL, NULL, NULL, 'main'),
(2106, 250247607, 'and', 44, NULL, NULL, NULL, 'main'),
(2105, 250247607, 'transmission', 43, NULL, NULL, NULL, 'main'),
(2104, 250247607, 'data', 42, NULL, NULL, NULL, 'main'),
(2103, 250247607, 'accelerating', 41, NULL, NULL, NULL, 'main'),
(2102, 250247607, 'like', 40, NULL, NULL, NULL, 'main'),
(2101, 250247607, 'purposes', 39, NULL, NULL, NULL, 'main'),
(2100, 250247607, 'various', 38, NULL, NULL, NULL, 'main'),
(2099, 250247607, 'for', 37, NULL, NULL, NULL, 'main'),
(2098, 250247607, 'used', 36, NULL, NULL, NULL, 'main'),
(2097, 250247607, 'are', 35, NULL, NULL, NULL, 'main'),
(2096, 250247607, 'servers', 34, NULL, NULL, NULL, 'main'),
(2095, 250247607, 'Proxy', 33, NULL, NULL, NULL, 'main'),
(2094, 250247607, 'Internet', 32, NULL, NULL, NULL, 'main'),
(2093, 250247607, 'the', 31, NULL, NULL, NULL, 'main'),
(2092, 250247607, 'and', 30, NULL, NULL, NULL, 'main'),
(2091, 250247607, 'computer', 29, NULL, NULL, NULL, 'main'),
(2090, 250247607, 'a', 28, NULL, NULL, NULL, 'main'),
(2089, 250247607, 'between', 27, NULL, NULL, NULL, 'main'),
(2088, 250247607, 'mediator', 26, NULL, NULL, NULL, 'main'),
(2087, 250247607, 'or', 25, NULL, NULL, NULL, 'main'),
(2086, 250247607, 'proxy', 24, NULL, NULL, NULL, 'main'),
(2085, 250247607, 'a', 23, NULL, NULL, NULL, 'main'),
(2084, 250247607, 'as', 22, NULL, NULL, NULL, 'main'),
(2083, 250247607, 'acts', 21, NULL, NULL, NULL, 'main'),
(2082, 250247607, 'that', 20, NULL, NULL, NULL, 'main'),
(2081, 250247607, 'computer', 19, NULL, NULL, NULL, 'main'),
(2080, 250247607, 'intermediate', 18, NULL, NULL, NULL, 'main'),
(2079, 250247607, 'an', 17, NULL, NULL, NULL, 'main'),
(2078, 250247607, 'is', 16, NULL, NULL, NULL, 'main'),
(2077, 250247607, '1103', 15, NULL, NULL, NULL, 'main'),
(2076, 250247607, '1089', 14, NULL, NULL, NULL, 'main'),
(2075, 250247607, '1082', 13, NULL, NULL, NULL, 'main'),
(2074, 250247607, '1086', 12, NULL, NULL, NULL, 'main'),
(2073, 250247607, '1088', 11, NULL, NULL, NULL, 'main'),
(2072, 250247607, '1055', 10, NULL, NULL, NULL, 'main'),
(2071, 250247607, 'server', 9, NULL, NULL, NULL, 'main'),
(2070, 250247607, 'proxy', 8, NULL, NULL, NULL, 'main'),
(2069, 250247607, 'A', 7, NULL, NULL, NULL, 'main'),
(2068, 250247607, 'SOCKS5', 6, NULL, NULL, NULL, 'main'),
(2067, 250247607, 'SOCKS4', 5, NULL, NULL, NULL, 'main'),
(2066, 250247607, 'HTTPS', 4, NULL, NULL, NULL, 'main'),
(2065, 250247607, 'HTTP', 3, NULL, NULL, NULL, 'main'),
(2064, 250247607, 'service', 2, NULL, NULL, NULL, 'main'),
(2063, 250247607, 'Proxy', 1, NULL, NULL, NULL, 'main'),
(2335, 250247607, 'with', 273, NULL, NULL, NULL, 'main'),
(2336, 250247607, 'SOCKS', 274, NULL, NULL, NULL, 'main'),
(2337, 250247607, 'proxy', 275, NULL, NULL, NULL, 'main'),
(2338, 250247607, 'servers', 276, NULL, NULL, NULL, 'main'),
(2339, 250247607, 'their', 277, NULL, NULL, NULL, 'main'),
(2340, 250247607, 'versions', 278, NULL, NULL, NULL, 'main'),
(2341, 250247607, 'i', 279, NULL, NULL, NULL, 'main'),
(2342, 250247607, 'e', 280, NULL, NULL, NULL, 'main'),
(2343, 250247607, 'SOCKS4', 281, NULL, NULL, NULL, 'main'),
(2344, 250247607, 'or', 282, NULL, NULL, NULL, 'main'),
(2345, 250247607, 'SOCKS5', 283, NULL, NULL, NULL, 'main'),
(2346, 250247607, 'must', 284, NULL, NULL, NULL, 'main'),
(2347, 250247607, 'be', 285, NULL, NULL, NULL, 'main'),
(2348, 250247607, 'specified', 286, NULL, NULL, NULL, 'main'),
(2349, 250247607, 'Proxy', 287, NULL, NULL, NULL, 'main'),
(2350, 250247607, 'service', 288, NULL, NULL, NULL, 'main'),
(2351, 250247607, 'HTTP', 289, NULL, NULL, NULL, 'main'),
(2352, 250247607, 'HTTPS', 290, NULL, NULL, NULL, 'main'),
(2353, 250247607, 'SOCKS4', 291, NULL, NULL, NULL, 'main'),
(2354, 250247607, 'SOCKS5', 292, NULL, NULL, NULL, 'main'),
(2355, 250247607, 'prices', 293, NULL, NULL, NULL, 'main'),
(2356, 250247607, '5', 294, NULL, NULL, NULL, 'main'),
(2357, 250247607, 'days', 295, NULL, NULL, NULL, 'main'),
(2358, 250247607, 'US', 296, NULL, NULL, NULL, 'main'),
(2359, 250247607, '4', 297, NULL, NULL, NULL, 'main'),
(2360, 250247607, '10', 298, NULL, NULL, NULL, 'main'),
(2361, 250247607, 'days', 299, NULL, NULL, NULL, 'main'),
(2362, 250247607, 'US', 300, NULL, NULL, NULL, 'main'),
(2363, 250247607, '8', 301, NULL, NULL, NULL, 'main'),
(2364, 250247607, '30', 302, NULL, NULL, NULL, 'main'),
(2365, 250247607, 'days', 303, NULL, NULL, NULL, 'main'),
(2366, 250247607, 'US', 304, NULL, NULL, NULL, 'main'),
(2367, 250247607, '20', 305, NULL, NULL, NULL, 'main'),
(2368, 250247607, '90', 306, NULL, NULL, NULL, 'main'),
(2369, 250247607, 'days', 307, NULL, NULL, NULL, 'main'),
(2370, 250247607, 'US', 308, NULL, NULL, NULL, 'main'),
(2371, 250247607, '55', 309, NULL, NULL, NULL, 'main'),
(2403, 159635450, 'from', 32, NULL, NULL, NULL, 'main'),
(2404, 159635450, 'brute', 33, NULL, NULL, NULL, 'main'),
(2405, 159635450, 'forcing', 34, NULL, NULL, NULL, 'main'),
(2406, 159635450, 'to', 35, NULL, NULL, NULL, 'main'),
(2407, 159635450, 'carding', 36, NULL, NULL, NULL, 'main'),
(2408, 159635450, 'that', 37, NULL, NULL, NULL, 'main'),
(2409, 159635450, 'a', 38, NULL, NULL, NULL, 'main'),
(2410, 159635450, 'hacker', 39, NULL, NULL, NULL, 'main'),
(2411, 159635450, 'would', 40, NULL, NULL, NULL, 'main'),
(2412, 159635450, 'prefer', 41, NULL, NULL, NULL, 'main'),
(2413, 159635450, 'not', 42, NULL, NULL, NULL, 'main'),
(2414, 159635450, 'to', 43, NULL, NULL, NULL, 'main'),
(2415, 159635450, 'do', 44, NULL, NULL, NULL, 'main'),
(2416, 159635450, 'on', 45, NULL, NULL, NULL, 'main'),
(2417, 159635450, 'his', 46, NULL, NULL, NULL, 'main'),
(2418, 159635450, 'own', 47, NULL, NULL, NULL, 'main'),
(2419, 159635450, 'machine', 48, NULL, NULL, NULL, 'main'),
(2420, 159635450, 'Hackers', 49, NULL, NULL, NULL, 'main'),
(2421, 159635450, 'typically', 50, NULL, NULL, NULL, 'main'),
(2422, 159635450, 'connect', 51, NULL, NULL, NULL, 'main'),
(2423, 159635450, 'to', 52, NULL, NULL, NULL, 'main'),
(2424, 159635450, 'a', 53, NULL, NULL, NULL, 'main'),
(2425, 159635450, 'dedicated', 54, NULL, NULL, NULL, 'main'),
(2426, 159635450, 'server', 55, NULL, NULL, NULL, 'main'),
(2427, 159635450, 'via', 56, NULL, NULL, NULL, 'main'),
(2428, 159635450, 'VPN', 57, NULL, NULL, NULL, 'main'),
(2429, 159635450, 'which', 58, NULL, NULL, NULL, 'main'),
(2430, 159635450, 'provides', 59, NULL, NULL, NULL, 'main'),
(2431, 159635450, 'them', 60, NULL, NULL, NULL, 'main'),
(2432, 159635450, 'anonymity', 61, NULL, NULL, NULL, 'main'),
(2433, 159635450, 'Dedicated', 62, NULL, NULL, NULL, 'main'),
(2434, 159635450, 'servers', 63, NULL, NULL, NULL, 'main'),
(2435, 159635450, 'are', 64, NULL, NULL, NULL, 'main'),
(2436, 159635450, 'among', 65, NULL, NULL, NULL, 'main'),
(2437, 159635450, 'the', 66, NULL, NULL, NULL, 'main'),
(2438, 159635450, 'most', 67, NULL, NULL, NULL, 'main'),
(2439, 159635450, 'popular', 68, NULL, NULL, NULL, 'main'),
(2440, 159635450, 'goods', 69, NULL, NULL, NULL, 'main'),
(2441, 159635450, 'in', 70, NULL, NULL, NULL, 'main'),
(2442, 159635450, 'the', 71, NULL, NULL, NULL, 'main'),
(2443, 159635450, 'underground', 72, NULL, NULL, NULL, 'main'),
(2444, 159635450, 'market', 73, NULL, NULL, NULL, 'main'),
(2445, 159635450, 'These', 74, NULL, NULL, NULL, 'main'),
(2446, 159635450, 'are', 75, NULL, NULL, NULL, 'main'),
(2447, 159635450, 'considered', 76, NULL, NULL, NULL, 'main'),
(2448, 159635450, 'unique', 77, NULL, NULL, NULL, 'main'),
(2449, 159635450, 'consumables', 78, NULL, NULL, NULL, 'main'),
(2450, 159635450, 'with', 79, NULL, NULL, NULL, 'main'),
(2451, 159635450, 'more', 80, NULL, NULL, NULL, 'main'),
(2452, 159635450, 'or', 81, NULL, NULL, NULL, 'main'),
(2453, 159635450, 'less', 82, NULL, NULL, NULL, 'main'),
(2454, 159635450, 'constant', 83, NULL, NULL, NULL, 'main'),
(2455, 159635450, 'demand', 84, NULL, NULL, NULL, 'main'),
(2456, 159635450, 'Dedicated', 85, NULL, NULL, NULL, 'main'),
(2457, 159635450, 'servers', 86, NULL, NULL, NULL, 'main'),
(2458, 159635450, 'are', 87, NULL, NULL, NULL, 'main'),
(2459, 159635450, 'usually', 88, NULL, NULL, NULL, 'main'),
(2460, 159635450, 'sold', 89, NULL, NULL, NULL, 'main'),
(2461, 159635450, 'by', 90, NULL, NULL, NULL, 'main'),
(2462, 159635450, 'the', 91, NULL, NULL, NULL, 'main'),
(2463, 159635450, 'tens', 92, NULL, NULL, NULL, 'main'),
(2464, 159635450, 'or', 93, NULL, NULL, NULL, 'main'),
(2465, 159635450, 'hundreds', 94, NULL, NULL, NULL, 'main'),
(2466, 159635450, 'with', 95, NULL, NULL, NULL, 'main'),
(2467, 159635450, 'prices', 96, NULL, NULL, NULL, 'main'),
(2468, 159635450, 'depending', 97, NULL, NULL, NULL, 'main'),
(2469, 159635450, 'on', 98, NULL, NULL, NULL, 'main'),
(2470, 159635450, 'their', 99, NULL, NULL, NULL, 'main'),
(2471, 159635450, 'processing', 100, NULL, NULL, NULL, 'main'),
(2472, 159635450, 'power', 101, NULL, NULL, NULL, 'main'),
(2473, 159635450, 'and', 102, NULL, NULL, NULL, 'main'),
(2474, 159635450, 'to', 103, NULL, NULL, NULL, 'main'),
(2475, 159635450, 'a', 104, NULL, NULL, NULL, 'main'),
(2476, 159635450, 'larger', 105, NULL, NULL, NULL, 'main'),
(2477, 159635450, 'extent', 106, NULL, NULL, NULL, 'main'),
(2478, 159635450, 'Internet', 107, NULL, NULL, NULL, 'main'),
(2479, 159635450, 'access', 108, NULL, NULL, NULL, 'main'),
(2480, 159635450, 'speed', 109, NULL, NULL, NULL, 'main'),
(2481, 159635450, 'Servers', 110, NULL, NULL, NULL, 'main'),
(2482, 159635450, 'are', 111, NULL, NULL, NULL, 'main'),
(2483, 159635450, 'a', 112, NULL, NULL, NULL, 'main'),
(2484, 159635450, 'must', 113, NULL, NULL, NULL, 'main'),
(2485, 159635450, 'in', 114, NULL, NULL, NULL, 'main'),
(2486, 159635450, 'a', 115, NULL, NULL, NULL, 'main'),
(2487, 159635450, 'cybercriminal', 116, NULL, NULL, NULL, 'main'),
(2488, 159635450, 'operation', 117, NULL, NULL, NULL, 'main'),
(2489, 159635450, 'particularly', 118, NULL, NULL, NULL, 'main'),
(2490, 159635450, 'for', 119, NULL, NULL, NULL, 'main'),
(2491, 159635450, 'brute', 120, NULL, NULL, NULL, 'main'),
(2492, 159635450, 'force', 121, NULL, NULL, NULL, 'main'),
(2493, 159635450, 'attacks', 122, NULL, NULL, NULL, 'main'),
(2494, 159635450, 'on', 123, NULL, NULL, NULL, 'main'),
(2495, 159635450, 'wide', 124, NULL, NULL, NULL, 'main'),
(2496, 159635450, 'ranges', 125, NULL, NULL, NULL, 'main'),
(2497, 159635450, 'of', 126, NULL, NULL, NULL, 'main'),
(2498, 159635450, 'IP', 127, NULL, NULL, NULL, 'main'),
(2499, 159635450, 'addresses', 128, NULL, NULL, NULL, 'main'),
(2500, 159635450, 'Hackers', 129, NULL, NULL, NULL, 'main'),
(2501, 159635450, 'also', 130, NULL, NULL, NULL, 'main'),
(2502, 159635450, 'offer', 131, NULL, NULL, NULL, 'main'),
(2503, 159635450, 'brute', 132, NULL, NULL, NULL, 'main'),
(2504, 159635450, 'forcing', 133, NULL, NULL, NULL, 'main'),
(2505, 159635450, 'services', 134, NULL, NULL, NULL, 'main'),
(2506, 159635450, 'because', 135, NULL, NULL, NULL, 'main'),
(2507, 159635450, 'dedicated', 136, NULL, NULL, NULL, 'main'),
(2508, 159635450, 'servers', 137, NULL, NULL, NULL, 'main'),
(2509, 159635450, 'have', 138, NULL, NULL, NULL, 'main'),
(2510, 159635450, 'so', 139, NULL, NULL, NULL, 'main'),
(2511, 159635450, 'called', 140, NULL, NULL, NULL, 'main'),
(2512, 159635450, 'lifetimes', 141, NULL, NULL, NULL, 'main'),
(2513, 159635450, 'depending', 142, NULL, NULL, NULL, 'main'),
(2514, 159635450, 'on', 143, NULL, NULL, NULL, 'main'),
(2515, 159635450, 'several', 144, NULL, NULL, NULL, 'main'),
(2516, 159635450, 'factors', 145, NULL, NULL, NULL, 'main'),
(2517, 159635450, 'the', 146, NULL, NULL, NULL, 'main'),
(2518, 159635450, 'most', 147, NULL, NULL, NULL, 'main'),
(2519, 159635450, 'important', 148, NULL, NULL, NULL, 'main'),
(2520, 159635450, 'of', 149, NULL, NULL, NULL, 'main'),
(2521, 159635450, 'which', 150, NULL, NULL, NULL, 'main'),
(2522, 159635450, 'are', 151, NULL, NULL, NULL, 'main'),
(2523, 159635450, 'what', 152, NULL, NULL, NULL, 'main'),
(2524, 159635450, 'measures', 153, NULL, NULL, NULL, 'main'),
(2525, 159635450, 'an', 154, NULL, NULL, NULL, 'main'),
(2526, 159635450, 'administrator', 155, NULL, NULL, NULL, 'main'),
(2527, 159635450, 'implements', 156, NULL, NULL, NULL, 'main'),
(2528, 159635450, 'to', 157, NULL, NULL, NULL, 'main'),
(2529, 159635450, 'ensure', 158, NULL, NULL, NULL, 'main'),
(2530, 159635450, 'server', 159, NULL, NULL, NULL, 'main'),
(2531, 159635450, 'security', 160, NULL, NULL, NULL, 'main'),
(2532, 159635450, 'Bulletproof', 161, NULL, NULL, NULL, 'main'),
(2533, 159635450, 'hosting', 162, NULL, NULL, NULL, 'main'),
(2534, 159635450, 'services', 163, NULL, NULL, NULL, 'main'),
(2535, 159635450, '1072', 164, NULL, NULL, NULL, 'main'),
(2536, 159635450, '1073', 165, NULL, NULL, NULL, 'main'),
(2537, 159635450, '1091', 166, NULL, NULL, NULL, 'main'),
(2538, 159635450, '1079', 167, NULL, NULL, NULL, 'main'),
(2539, 159635450, '1086', 168, NULL, NULL, NULL, 'main'),
(2540, 159635450, '1091', 169, NULL, NULL, NULL, 'main'),
(2541, 159635450, '1089', 170, NULL, NULL, NULL, 'main'),
(2542, 159635450, '1090', 171, NULL, NULL, NULL, 'main'),
(2543, 159635450, '1086', 172, NULL, NULL, NULL, 'main'),
(2544, 159635450, '1081', 173, NULL, NULL, NULL, 'main'),
(2545, 159635450, '1095', 174, NULL, NULL, NULL, 'main'),
(2546, 159635450, '1080', 175, NULL, NULL, NULL, 'main'),
(2547, 159635450, '1074', 176, NULL, NULL, NULL, 'main'),
(2548, 159635450, '1099', 177, NULL, NULL, NULL, 'main'),
(2549, 159635450, '1077', 178, NULL, NULL, NULL, 'main'),
(2550, 159635450, 'which', 179, NULL, NULL, NULL, 'main'),
(2551, 159635450, 'allow', 180, NULL, NULL, NULL, 'main'),
(2552, 159635450, 'cybercriminals', 181, NULL, NULL, NULL, 'main'),
(2553, 159635450, 'to', 182, NULL, NULL, NULL, 'main'),
(2554, 159635450, 'host', 183, NULL, NULL, NULL, 'main'),
(2555, 159635450, 'any', 184, NULL, NULL, NULL, 'main'),
(2556, 159635450, 'kind', 185, NULL, NULL, NULL, 'main'),
(2557, 159635450, 'of', 186, NULL, NULL, NULL, 'main'),
(2558, 159635450, 'material', 187, NULL, NULL, NULL, 'main'),
(2559, 159635450, 'on', 188, NULL, NULL, NULL, 'main'),
(2560, 159635450, 'a', 189, NULL, NULL, NULL, 'main'),
(2561, 159635450, 'site', 190, NULL, NULL, NULL, 'main'),
(2562, 159635450, 'or', 191, NULL, NULL, NULL, 'main'),
(2563, 159635450, 'page', 192, NULL, NULL, NULL, 'main'),
(2564, 159635450, 'without', 193, NULL, NULL, NULL, 'main'),
(2565, 159635450, 'worrying', 194, NULL, NULL, NULL, 'main'),
(2566, 159635450, 'about', 195, NULL, NULL, NULL, 'main'),
(2567, 159635450, 'it', 196, NULL, NULL, NULL, 'main'),
(2568, 159635450, 'being', 197, NULL, NULL, NULL, 'main'),
(2569, 159635450, 'taken', 198, NULL, NULL, NULL, 'main'),
(2570, 159635450, 'down', 199, NULL, NULL, NULL, 'main'),
(2571, 159635450, 'due', 200, NULL, NULL, NULL, 'main'),
(2572, 159635450, 'to', 201, NULL, NULL, NULL, 'main'),
(2573, 159635450, 'abuse', 202, NULL, NULL, NULL, 'main'),
(2574, 159635450, 'complaints', 203, NULL, NULL, NULL, 'main'),
(2575, 159635450, 'are', 204, NULL, NULL, NULL, 'main'),
(2576, 159635450, 'also', 205, NULL, NULL, NULL, 'main'),
(2577, 159635450, 'widely', 206, NULL, NULL, NULL, 'main'),
(2578, 159635450, 'available', 207, NULL, NULL, NULL, 'main'),
(2579, 159635450, 'in', 208, NULL, NULL, NULL, 'main'),
(2580, 159635450, 'the', 209, NULL, NULL, NULL, 'main'),
(2581, 159635450, 'underground', 210, NULL, NULL, NULL, 'main'),
(2582, 159635450, 'market', 211, NULL, NULL, NULL, 'main'),
(2583, 159635450, 'Bulletproof', 212, NULL, NULL, NULL, 'main'),
(2584, 159635450, 'hosting', 213, NULL, NULL, NULL, 'main'),
(2585, 159635450, 'service', 214, NULL, NULL, NULL, 'main'),
(2586, 159635450, 'with', 215, NULL, NULL, NULL, 'main'),
(2587, 159635450, 'distributed', 216, NULL, NULL, NULL, 'main'),
(2588, 159635450, 'denial', 217, NULL, NULL, NULL, 'main'),
(2589, 159635450, 'of', 218, NULL, NULL, NULL, 'main'),
(2590, 159635450, 'service', 219, NULL, NULL, NULL, 'main'),
(2591, 159635450, 'DDoS', 220, NULL, NULL, NULL, 'main'),
(2592, 159635450, 'protection', 221, NULL, NULL, NULL, 'main'),
(2593, 159635450, 'a', 222, NULL, NULL, NULL, 'main'),
(2594, 159635450, '1Gb', 223, NULL, NULL, NULL, 'main'),
(2595, 159635450, 'Internet', 224, NULL, NULL, NULL, 'main'),
(2596, 159635450, 'connection', 225, NULL, NULL, NULL, 'main'),
(2597, 159635450, 'and', 226, NULL, NULL, NULL, 'main'),
(2598, 159635450, 'other', 227, NULL, NULL, NULL, 'main'),
(2599, 159635450, 'extra', 228, NULL, NULL, NULL, 'main'),
(2600, 159635450, 'features', 229, NULL, NULL, NULL, 'main'),
(2601, 159635450, 'US', 230, NULL, NULL, NULL, 'main'),
(2602, 159635450, '2', 231, NULL, NULL, NULL, 'main'),
(2603, 159635450, '000', 232, NULL, NULL, NULL, 'main'),
(2604, 159635450, 'per', 233, NULL, NULL, NULL, 'main'),
(2605, 159635450, 'month', 234, NULL, NULL, NULL, 'main'),
(2606, 159635450, 'Bulletproof', 235, NULL, NULL, NULL, 'main'),
(2607, 159635450, 'hosting', 236, NULL, NULL, NULL, 'main'),
(2608, 159635450, 'service', 237, NULL, NULL, NULL, 'main'),
(2609, 159635450, 'i', 238, NULL, NULL, NULL, 'main'),
(2610, 159635450, 'e', 239, NULL, NULL, NULL, 'main'),
(2611, 159635450, 'VPS', 240, NULL, NULL, NULL, 'main'),
(2612, 159635450, 'virtual', 241, NULL, NULL, NULL, 'main'),
(2613, 159635450, 'dedicated', 242, NULL, NULL, NULL, 'main'),
(2614, 159635450, 'server', 243, NULL, NULL, NULL, 'main'),
(2615, 159635450, 'VDS', 244, NULL, NULL, NULL, 'main'),
(2616, 159635450, 'US', 245, NULL, NULL, NULL, 'main'),
(2617, 159635450, '15', 246, NULL, NULL, NULL, 'main'),
(2618, 159635450, '250', 247, NULL, NULL, NULL, 'main'),
(2619, 159635450, 'per', 248, NULL, NULL, NULL, 'main'),
(2620, 159635450, 'month', 249, NULL, NULL, NULL, 'main');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lookup_ages`
--

CREATE TABLE IF NOT EXISTS `lookup_ages` (
  `age_id` int(11) NOT NULL DEFAULT '0',
  `age_desc` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`age_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `lookup_ages`
--

INSERT INTO `lookup_ages` (`age_id`, `age_desc`) VALUES
(1, 'less than 13'),
(2, '13-18'),
(3, '18-24'),
(4, '25-34'),
(5, '35-50'),
(6, '51-65'),
(7, 'over 65'),
(0, 'Unspecified');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lookup_countries`
--

CREATE TABLE IF NOT EXISTS `lookup_countries` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_desc` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=220 ;

--
-- Volcado de datos para la tabla `lookup_countries`
--

INSERT INTO `lookup_countries` (`country_id`, `country_desc`) VALUES
(1, 'United States'),
(4, 'Canada'),
(5, 'United Kingdom'),
(6, 'Afghanistan'),
(7, 'Albania'),
(8, 'Algeria'),
(9, 'American Samoa'),
(10, 'Andorra'),
(11, 'Angola'),
(12, 'Anguilla'),
(13, 'Antigua and Barbuda'),
(14, 'Argentina'),
(15, 'Armenia'),
(16, 'Aruba'),
(17, 'Australia'),
(18, 'Austria'),
(19, 'Azerbaijan Republic'),
(20, 'Bahamas'),
(21, 'Bahrain'),
(22, 'Bangladesh'),
(23, 'Barbados'),
(24, 'Belarus'),
(25, 'Belgium'),
(26, 'Belize'),
(27, 'Benin'),
(28, 'Bermuda'),
(29, 'Bhutan'),
(30, 'Bolivia'),
(31, 'Bosnia and Herzegovina'),
(32, 'Botswana'),
(33, 'Brazil'),
(34, 'British Virgin Islands'),
(35, 'Brunei Darussalam'),
(36, 'Bulgaria'),
(37, 'Burkina Faso'),
(38, 'Burma'),
(39, 'Burundi'),
(40, 'Cambodia'),
(41, 'Cameroon'),
(43, 'Cape Verde Islands'),
(44, 'Cayman Islands'),
(45, 'Central African Republic'),
(46, 'Chad'),
(47, 'Chile'),
(48, 'China'),
(49, 'Colombia'),
(50, 'Comoros'),
(51, 'Congo, Democratic Republic of'),
(52, 'Cook Islands'),
(53, 'Costa Rica'),
(54, 'Cote d Ivoire (Ivory Coast)'),
(55, 'Croatia, Democratic Republic of the'),
(56, 'Cuba'),
(57, 'Cyprus'),
(58, 'Czech Republic'),
(59, 'Denmark'),
(60, 'Djibouti'),
(61, 'Dominica'),
(62, 'Dominican Republic'),
(63, 'Ecuador'),
(64, 'Egypt'),
(65, 'El Salvador'),
(66, 'Equatorial Guinea'),
(67, 'Eritrea'),
(68, 'Estonia'),
(69, 'Ethiopia'),
(70, 'Falkland Islands (Islas Makvinas)'),
(71, 'Fiji'),
(72, 'Finland'),
(73, 'France'),
(74, 'French Guiana'),
(75, 'French Polynesia'),
(76, 'Gabon Republic'),
(77, 'Gambia'),
(78, 'Georgia'),
(79, 'Germany'),
(80, 'Ghana'),
(81, 'Gibraltar'),
(82, 'Greece'),
(83, 'Greenland'),
(84, 'Grenada'),
(85, 'Guadeloupe'),
(86, 'Guam'),
(87, 'Guatemala'),
(88, 'Guernsey'),
(89, 'Guinea'),
(90, 'Guinea-Bissau'),
(91, 'Guyana'),
(92, 'Haiti'),
(93, 'Honduras'),
(94, 'Hong Kong'),
(95, 'Hungary'),
(96, 'Iceland'),
(97, 'Japan'),
(98, 'Jersey'),
(99, 'Jordan'),
(100, 'Kazakhstan'),
(101, 'Kenya Coast Republic'),
(102, 'Kiribati'),
(103, 'Korea, North'),
(104, 'Korea, South'),
(105, 'Kuwait'),
(106, 'Kyrgyzstan'),
(107, 'Laos'),
(108, 'Latvia'),
(109, 'Lebanon, South'),
(110, 'Lesotho'),
(111, 'Liberia'),
(112, 'Libya'),
(113, 'Liechtenstein'),
(114, 'Lithuania'),
(115, 'Luxembourg'),
(116, 'Macau'),
(117, 'Macedonia'),
(118, 'Madagascar'),
(119, 'Malawi'),
(120, 'Malaysia'),
(121, 'Maldives'),
(122, 'Mali'),
(123, 'Malta'),
(124, 'Marshall Islands'),
(125, 'Martinique'),
(126, 'Mauritania'),
(127, 'Mauritius'),
(128, 'Mayotte'),
(129, 'Mexico'),
(130, 'Moldova'),
(131, 'Monaco'),
(132, 'Mongolia'),
(133, 'Montserrat'),
(134, 'Morocco'),
(135, 'Mozambique'),
(136, 'Namibia'),
(137, 'Nauru'),
(138, 'Nepal'),
(139, 'Netherlands'),
(140, 'Netherlands Antilles'),
(141, 'New Caledonia'),
(142, 'New Zealand'),
(143, 'Nicaragua'),
(144, 'Niger'),
(145, 'Nigeria'),
(146, 'Niue'),
(147, 'Norway'),
(148, 'Oman'),
(149, 'Pakistan'),
(150, 'Palau'),
(151, 'Panama'),
(152, 'Papua New Guinea'),
(153, 'Paraguay'),
(154, 'Peru'),
(155, 'Philippines'),
(156, 'Poland'),
(157, 'Portugal'),
(158, 'Puerto Rico'),
(159, 'Qatar'),
(160, 'Romania'),
(161, 'Russian Federation'),
(162, 'Rwanda'),
(163, 'Saint Helena'),
(164, 'Saint Kitts-Nevis'),
(165, 'Saint Lucia'),
(166, 'Saint Pierre and Miquelon'),
(167, 'Saint Vincent and the Grenadines'),
(168, 'San Marino'),
(169, 'Saudi Arabia'),
(170, 'Senegal'),
(171, 'Seychelles'),
(172, 'Sierra Leone'),
(173, 'Singapore'),
(174, 'Slovakia'),
(175, 'Slovenia'),
(176, 'Solomon Islands'),
(177, 'Somalia'),
(178, 'South Africa'),
(179, 'Spain'),
(180, 'Sri Lanka'),
(181, 'Sudan'),
(182, 'Suriname'),
(183, 'Svalbard'),
(184, 'Swaziland'),
(185, 'Sweden'),
(186, 'Switzerland'),
(187, 'Syria'),
(188, 'Tahiti'),
(189, 'Taiwan'),
(190, 'Tajikistan'),
(191, 'Tanzania'),
(192, 'Thailand'),
(193, 'Togo'),
(194, 'Tonga'),
(195, 'Trinidad and Tobago'),
(196, 'Tunisia'),
(197, 'Turkey'),
(198, 'Turkmenistan'),
(199, 'Turks and Caicos Islands'),
(200, 'Tuvalu'),
(201, 'Uganda'),
(202, 'Ukraine'),
(203, 'United Arab Emirates'),
(205, 'Uruguay'),
(206, 'Uzbekistan'),
(207, 'Vanuatu'),
(208, 'Vatican City, State'),
(209, 'Venezuela'),
(210, 'Vietnam'),
(211, 'Virgin Islands (U.S.)'),
(212, 'Wallis and Futuna'),
(213, 'Western Sahara'),
(214, 'Western Samoa'),
(215, 'Yemen'),
(216, 'Yugoslavia'),
(217, 'Zambia'),
(218, 'Zimbabwe'),
(219, 'INDIA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lookup_educations`
--

CREATE TABLE IF NOT EXISTS `lookup_educations` (
  `education_id` int(11) NOT NULL DEFAULT '0',
  `education_desc` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`education_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `lookup_educations`
--

INSERT INTO `lookup_educations` (`education_id`, `education_desc`) VALUES
(1, 'High School'),
(2, 'College'),
(3, 'Graduate School'),
(4, 'Other'),
(0, 'Unspecified');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lookup_genders`
--

CREATE TABLE IF NOT EXISTS `lookup_genders` (
  `gender_id` int(11) NOT NULL DEFAULT '0',
  `gender_desc` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`gender_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `lookup_genders`
--

INSERT INTO `lookup_genders` (`gender_id`, `gender_desc`) VALUES
(1, 'Male'),
(2, 'Female'),
(0, 'Unspecified');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lookup_incomes`
--

CREATE TABLE IF NOT EXISTS `lookup_incomes` (
  `income_id` int(11) NOT NULL DEFAULT '0',
  `income_desc` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`income_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `lookup_incomes`
--

INSERT INTO `lookup_incomes` (`income_id`, `income_desc`) VALUES
(1, 'under $25,000'),
(2, '$25,000 - $34,000'),
(3, '$35,000 - $49,000'),
(4, '$50,000 - $74,000'),
(5, 'over $75,000'),
(0, 'Unspecified');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lookup_listing_dates`
--

CREATE TABLE IF NOT EXISTS `lookup_listing_dates` (
  `date_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `days` int(11) DEFAULT NULL,
  `charge_for` tinyint(4) DEFAULT NULL,
  `fee` decimal(10,2) DEFAULT NULL,
  `cat_id` int(20) DEFAULT '1',
  PRIMARY KEY (`date_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `lookup_listing_dates`
--

INSERT INTO `lookup_listing_dates` (`date_id`, `days`, `charge_for`, `fee`, `cat_id`) VALUES
(1, 3, NULL, NULL, 1),
(2, 5, NULL, NULL, 1),
(3, 7, NULL, NULL, 1),
(4, 10, NULL, NULL, 1),
(5, 14, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lookup_states`
--

CREATE TABLE IF NOT EXISTS `lookup_states` (
  `state_id` varchar(50) NOT NULL DEFAULT '',
  `state_desc` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`state_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `online`
--

CREATE TABLE IF NOT EXISTS `online` (
  `ip` varchar(15) NOT NULL DEFAULT '',
  `datet` bigint(14) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `page` varchar(255) DEFAULT NULL,
  KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `online`
--

INSERT INTO `online` (`ip`, `datet`, `user`, `page`) VALUES
('192.168.0.12', 1393111613, 'Guest', 'On Main Page');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promos`
--

CREATE TABLE IF NOT EXISTS `promos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `start` int(20) DEFAULT NULL,
  `end` int(20) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `group` int(20) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchases`
--

CREATE TABLE IF NOT EXISTS `purchases` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `ItemNum` int(20) NOT NULL DEFAULT '0',
  `date` int(20) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `asking` decimal(10,2) DEFAULT NULL,
  `amt_received` decimal(10,2) DEFAULT NULL,
  `shipping` varchar(255) DEFAULT NULL,
  `user_id` int(20) NOT NULL DEFAULT '0',
  `buyer` int(20) NOT NULL DEFAULT '0',
  `user_paypal` varchar(150) DEFAULT NULL,
  `buyer_paypal` varchar(150) DEFAULT NULL,
  `txn_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `search_history`
--

CREATE TABLE IF NOT EXISTS `search_history` (
  `id` bigint(200) NOT NULL AUTO_INCREMENT,
  `user_id` int(20) DEFAULT NULL,
  `date` int(20) DEFAULT NULL,
  `value` text,
  `results` text,
  `save` tinyint(2) DEFAULT NULL,
  `sched` tinyint(2) DEFAULT NULL,
  `frequency` int(20) DEFAULT NULL,
  `nextrun` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `settings_accounting`
--

CREATE TABLE IF NOT EXISTS `settings_accounting` (
  `set_id` tinyint(3) NOT NULL DEFAULT '0',
  `paypal_on` tinyint(4) DEFAULT NULL,
  `paypal` varchar(255) DEFAULT NULL,
  `authorizenet_on` tinyint(4) DEFAULT NULL,
  `authorizenet` varchar(255) DEFAULT NULL,
  `authorize_tran_key` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`set_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `settings_accounting`
--

INSERT INTO `settings_accounting` (`set_id`, `paypal_on`, `paypal`, `authorizenet_on`, `authorizenet`, `authorize_tran_key`) VALUES
(1, 1, 'hola@gmail.com', 0, 'authorize_uid', 'bhh');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `settings_charges`
--

CREATE TABLE IF NOT EXISTS `settings_charges` (
  `set_id` bigint(20) NOT NULL DEFAULT '0',
  `currency` varchar(5) DEFAULT NULL,
  `currencycode` varchar(5) DEFAULT NULL,
  `newregon` tinyint(4) DEFAULT NULL,
  `newregcredit` bigint(20) DEFAULT NULL,
  `newregreason` varchar(255) DEFAULT NULL,
  `tokens` int(20) DEFAULT '0',
  `listing_fee` decimal(10,2) DEFAULT NULL,
  `home_fee` decimal(10,2) DEFAULT NULL,
  `cat_fee` decimal(10,2) DEFAULT NULL,
  `gallery_fee` decimal(10,2) DEFAULT NULL,
  `image_pre_fee` decimal(10,2) DEFAULT NULL,
  `slide_fee` decimal(10,2) DEFAULT NULL,
  `counter_fee` decimal(10,2) DEFAULT NULL,
  `bold_fee` decimal(10,2) DEFAULT NULL,
  `high_fee` decimal(10,2) DEFAULT NULL,
  `upload_fee` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`set_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `settings_charges`
--

INSERT INTO `settings_charges` (`set_id`, `currency`, `currencycode`, `newregon`, `newregcredit`, `newregreason`, `tokens`, `listing_fee`, `home_fee`, `cat_fee`, `gallery_fee`, `image_pre_fee`, `slide_fee`, `counter_fee`, `bold_fee`, `high_fee`, `upload_fee`) VALUES
(1, '$', 'USD', 1, NULL, NULL, 20, 0.00, 5.00, 2.50, 2.50, 1.00, 1.00, 0.50, 1.50, 2.00, 0.25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `settings_froogle`
--

CREATE TABLE IF NOT EXISTS `settings_froogle` (
  `set_id` tinyint(2) NOT NULL DEFAULT '1',
  `ftp_url` varchar(100) NOT NULL DEFAULT 'hedwig.google.com',
  `ftpusername` varchar(50) DEFAULT NULL,
  `ftppassword` varchar(50) DEFAULT NULL,
  `frooglefile` varchar(50) DEFAULT NULL,
  `submit_date` int(20) DEFAULT NULL,
  PRIMARY KEY (`set_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `settings_froogle`
--

INSERT INTO `settings_froogle` (`set_id`, `ftp_url`, `ftpusername`, `ftppassword`, `frooglefile`, `submit_date`) VALUES
(1, 'hedwig.google.com', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `settings_general`
--

CREATE TABLE IF NOT EXISTS `settings_general` (
  `set_id` tinyint(3) NOT NULL DEFAULT '0',
  `sitename` varchar(255) DEFAULT '0',
  `siteemail` varchar(255) DEFAULT NULL,
  `homeurl` varchar(255) DEFAULT NULL,
  `secureurl` varchar(255) DEFAULT NULL,
  `uploadurl` varchar(255) DEFAULT NULL,
  `pagentrys` int(11) DEFAULT NULL,
  `frontentrys` tinyint(4) DEFAULT NULL,
  `notify` tinyint(4) DEFAULT NULL,
  `notifyads` tinyint(4) DEFAULT NULL,
  `notifyemail` varchar(255) DEFAULT NULL,
  `bounceout` tinyint(4) DEFAULT NULL,
  `bounceout_id` tinyint(4) DEFAULT NULL,
  `timeout` int(10) DEFAULT NULL,
  `has_gd` tinyint(4) DEFAULT NULL,
  `approv_priority` tinyint(2) DEFAULT '0',
  `mimemail` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`set_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `settings_general`
--

INSERT INTO `settings_general` (`set_id`, `sitename`, `siteemail`, `homeurl`, `secureurl`, `uploadurl`, `pagentrys`, `frontentrys`, `notify`, `notifyads`, `notifyemail`, `bounceout`, `bounceout_id`, `timeout`, `has_gd`, `approv_priority`, `mimemail`) VALUES
(1, 'ITech Classifieds', 'admin@itechscripts.com', 'http://lab.demonstrationserver.com/classifieds/', 'http://lab.demonstrationserver.com/classifieds/', 'uploads/', 20, 10, 1, 1, 'admin@itechscripts.com', 0, 1, 600, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `settings_images`
--

CREATE TABLE IF NOT EXISTS `settings_images` (
  `set_id` tinyint(3) NOT NULL DEFAULT '0',
  `maxuploadwidth` int(11) DEFAULT NULL,
  `maxuploadheight` int(11) DEFAULT NULL,
  PRIMARY KEY (`set_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `settings_images`
--

INSERT INTO `settings_images` (`set_id`, `maxuploadwidth`, `maxuploadheight`) VALUES
(1, 800, 800);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subscription_plans`
--

CREATE TABLE IF NOT EXISTS `subscription_plans` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `group` int(20) DEFAULT NULL,
  `duration` int(20) DEFAULT NULL,
  `unlimited` tinyint(2) DEFAULT '0',
  `price` decimal(10,2) DEFAULT NULL,
  `recurring` tinyint(3) DEFAULT NULL,
  `intro` tinyint(3) DEFAULT NULL,
  `intro_duration` int(20) DEFAULT NULL,
  `intro_price` int(20) DEFAULT NULL,
  `paypal` tinyint(3) DEFAULT NULL,
  `authnet` tinyint(3) DEFAULT NULL,
  `co2` tinyint(3) DEFAULT NULL,
  `active` tinyint(3) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `date_added` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `subscription_plans`
--

INSERT INTO `subscription_plans` (`id`, `title`, `description`, `group`, `duration`, `unlimited`, `price`, `recurring`, `intro`, `intro_duration`, `intro_price`, `paypal`, `authnet`, `co2`, `active`, `icon`, `date_added`) VALUES
(1, 'Basic', NULL, 1, 30, 0, 0.00, 0, 0, NULL, NULL, 0, 0, 0, 1, NULL, 1200219123),
(2, 'Gold', NULL, 1, 30, 0, 20.00, 1, 0, NULL, NULL, 1, 0, 0, 1, NULL, 1200219180),
(3, 'Platinum', NULL, 1, 60, 0, 30.00, 1, 0, NULL, NULL, 1, 0, 0, 1, NULL, 1200219205);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `templates_cat`
--

CREATE TABLE IF NOT EXISTS `templates_cat` (
  `id` bigint(200) NOT NULL AUTO_INCREMENT,
  `cat_id` bigint(20) NOT NULL DEFAULT '0',
  `template` blob,
  `active` tinyint(2) NOT NULL DEFAULT '0',
  `admin_override` tinyint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `templates_emails`
--

CREATE TABLE IF NOT EXISTS `templates_emails` (
  `temp_id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `template_name` varchar(255) DEFAULT NULL,
  `from_email` varchar(100) DEFAULT NULL,
  `email_subject` varchar(255) DEFAULT NULL,
  `email_text` text,
  PRIMARY KEY (`temp_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Volcado de datos para la tabla `templates_emails`
--

INSERT INTO `templates_emails` (`temp_id`, `template_name`, `from_email`, `email_subject`, `email_text`) VALUES
(1, 'NewRegistration', '', 'Welcome to [EMAIL:SITE_NAME]!', 'Hello [EMAIL:CURRENT_USER_FIRST_NAME],\r\n\r\nWe are glad you decided to join us! Here at [EMAIL:SITE_NAME], you can effectivly buy and sell your items while in an enjoyable environment. We hope you have fun as member of our community. \r\n\r\nThank you,\r\n[EMAIL:SITE_NAME] Team'),
(2, 'EmailReply', '', '[EMAIL:REPLY_SUBJECT]', '[EMAIL:REPLY_FROM_USERNAME] has sent you a reply  on [EMAIL:CURRENT_TIME]\r\n\r\nMessage\r\n-------------------------------------------------------------------\r\n[EMAIL:REPLY_MESSAGE]\r\n\r\n\r\n-------------------------------------------------------------------'),
(3, 'AskAQuestion', '', 'A question has been asked about Item#[EMAIL:AAQ_ITEM_NUMBER]', 'Hello [EMAIL:AAQ_TO_SELLER_USERNAME],\r\n\r\nThe following question was asked:\r\nFrom: [EMAIL:AAQ_FROM_BUYER_USERNAME]\r\nRegarding Item#[EMAIL:AAQ_ITEM_NUMBER]\r\n________________________________________________________\r\n\r\n[EMAIL:AAQ_MESSAGE]\r\n\r\n________________________________________________________'),
(4, 'MakeAnOffer', '', '[EMAIL:MAO_FROM_BUYER_USERNAME] has made an offer on Item#[EMAIL:MAO_ITEM_NUMBER] has been made', '[EMAIL:MAO_TO_SELLER_USERNAME],\r\n\r\n[EMAIL:MAO_FROM_BUYER_USERNAME] has made an offer regarding Item [EMAIL:MAO_ITEM_NUMBER]\r\n\r\nBelow are the details of the offer\r\n\r\nAmount: [EMAIL:MAO_AMOUNT]\r\n________________________________________________________\r\n\r\n[EMAIL:MAO_MESSAGE]\r\n\r\n________________________________________________________'),
(5, 'MakePayment', '', 'Your Credit Card Deposit has been received successfully', 'Hello [EMAIL:CURRENT_USER_FIRST_NAME],\r\n\r\nThis is a notice to let you know that your Credit Card Deposit in the amount of [EMAIL:PAYMENT_AMOUNT] has been received successfully.\r\n\r\nBelow are the details of the deposit:\r\n\r\nAmount: [EMAIL:PAYMENT_AMOUNT]\r\nDate Deposited: [EMAIL:CURRENT_TIME]\r\n\r\nSincerely,\r\n[EMAIL:SITE_NAME] Team'),
(8, 'AskAQuestionNotification', '', 'A question about Item#[EMAIL:AAQ_ITEM_NUMBER] has been received at [EMAIL:SITE_NAME]', 'Hello [EMAIL:AAQ_TO_SELLER_USERNAME],\r\n\r\nThe following question was asked:\r\nFrom: [EMAIL:AAQ_FROM_BUYER_USERNAME]\r\nRegarding Item#[EMAIL:AAQ_ITEM_NUMBER]\r\n________________________________________________________\r\n\r\n[EMAIL:AAQ_MESSAGE]\r\n\r\n\r\n________________________________________________________\r\n\r\nTo reply to this message, login to your account and you can send a reply from there.\r\n\r\nSincerely,\r\n[EMAIL:SITE_NAME] Team'),
(9, 'EmailReplyNotification', '', 'A notice that [EMAIL:REPLY_FROM_USERNAME] has replied to your email at [EMAIL:SITE_NAME]', 'Hello [EMAIL:REPLY_TO_USERNAME],\r\n\r\nThis is an automated response to inform you that [EMAIL:REPLY_FROM_USERNAME] has responded to your message on [EMAIL:CURRENT_TIME]. You can read the message in your account at [EMAIL:HOME_URL]myaccount.php\r\n\r\nSincerely,\r\n[EMAIL:SITE_NAME] Team'),
(10, 'MakeAnOfferNotification', '', 'An offer has been made on Item#[EMAIL:MAO_ITEM_NUMBER] at [EMAIL:SITE_NAME]', 'Hello [EMAIL:MAO_TO_SELLER_USERNAME],\r\n\r\n[EMAIL:MAO_FROM_BUYER_USERNAME] has made an offer regarding Item#[EMAIL:MAO_ITEM_NUMBER]\r\n\r\nBelow are the details of the offer\r\n\r\nAmount: [EMAIL:MAO_AMOUNT]\r\n________________________________________________________\r\n\r\n[EMAIL:MAO_MESSAGE]\r\n\r\n________________________________________________________\r\n\r\nYou can reply to this message from within your account at [EMAIL:SITE_NAME]\r\n\r\n[EMAIL:HOME_URL]myaccount.php\r\n\r\nSincerely,\r\n[EMAIL:SITE_NAME] Team'),
(11, 'NewRegistrationNotification', '', 'Thank you for registering at [EMAIL:SITE_NAME]! Here are your account details', 'Hello [EMAIL:CURRENT_USER_FIRST_NAME],\r\n\r\nYou, or someone using the email address of [EMAIL:CURRENT_USER_EMAIL], has registered at [EMAIL:SITE_NAME] on [EMAIL:CURRENT_TIME]. Below is your username and password so that you may login and start selling or buying right away.\r\n\r\nYour account details,\r\nUsername: [EMAIL:CURRENT_USERNAME]\r\nPassword: [EMAIL:CURRENT_USER_PASSWORD]\r\n\r\nYou may change your password at anytime from within your account options. To login to your account click here \r\n\r\n[EMAIL:HOME_URL]myaccount.php\r\n\r\nThank you,\r\n[EMAIL:SITE_NAME] Team'),
(12, 'NewRegistrationAdminCopy', '', 'A New User has registered at [EMAIL:SITE_NAME] on [EMAIL:CURRENT_TIME]', 'A new user has registered on [EMAIL:CURRENT_TIME]\r\n\r\nBelow are the details of the new registration:\r\n\r\nUsername: [EMAIL:CURRENT_USERNAME]\r\nFirst name: [EMAIL:CURRENT_USER_FIRST_NAME]\r\nLast name: [EMAIL:CURRENT_USER_LAST_NAME]\r\nEmail: [EMAIL:CURRENT_USER_EMAIL]\r\nRegistered IP: [EMAIL:CURRENT_USER__REGISTERED_IP]'),
(13, 'ForgotPassword', '', 'Forgotten Password Notice', 'Hello [EMAIL:CURRENT_USER_FIRST_NAME],\r\n\r\nThis is just a notice to inform you that you, or someone, has filled out a lost password request.\r\n\r\nSincerely,\r\n[EMAIL:SITE_NAME] Team'),
(14, 'MakePaymentNotification', '', 'Your Credit Card Deposit has been received successfully at [EMAIL:SITE_NAME]', 'Hello [EMAIL:CURRENT_USER_FIRST_NAME],\r\n\r\nThis is a notice to let you know that your Credit Card Deposit in the amount of [EMAIL:PAYMENT_AMOUNT] has been received successfully.\r\n\r\nBelow are the details of the deposit:\r\n\r\nAmount: [EMAIL:PAYMENT_AMOUNT]\r\nDate Deposited: [EMAIL:CURRENT_TIME]\r\n\r\nYou can view your new balance at the top of your account at:\r\n[EMAIL:HOME_URL]myaccount.php\r\n\r\nSincerely,\r\n[EMAIL:SITE_NAME] Team'),
(15, 'MakePaymentAdminCopy', '', 'A Credit Card Deposit has been made by [EMAIL:CURRENT_USERNAME] on [EMAIL:CURRENT_TIME]', 'This is a notice to let you know that [EMAIL:CURRENT_USERNAME] has made a Credit Card Deposit in the amount of [EMAIL:PAYMENT_AMOUNT].\r\n\r\nBelow are the details of the deposit:\r\n\r\nUsername: [EMAIL:CURRENT_USERNAME]\r\nFirst name: [EMAIL:CURRENT_USER_FIRST_NAME]\r\nLast name: [EMAIL:CURRENT_USER_LAST_NAME]\r\nUser''s email: [EMAIL:CURRENT_USER_EMAIL]\r\nAmount: [EMAIL:PAYMENT_AMOUNT]\r\nDate Deposited: [EMAIL:CURRENT_TIME]\r\n'),
(16, 'MakePaymentPaypal', '', 'Your PayPal Deposit has been received successfully', 'Hello [EMAIL:CURRENT_USER_FIRST_NAME],\r\n\r\nThis is a notice to let you know that your PayPal Deposit in the amount of [EMAIL:PAYMENT_AMOUNT] has been received successfully.\r\n\r\nBelow are the details of the deposit:\r\n\r\nAmount: [EMAIL:PAYMENT_AMOUNT]\r\nDate Deposited: [EMAIL:CURRENT_TIME]\r\n\r\nSincerely,\r\n[EMAIL:SITE_NAME] Team'),
(17, 'MakePaymentPaypalNotification', '', 'Your PayPal Deposit has been received successfully at [EMAIL:SITE_NAME]', 'Hello [EMAIL:CURRENT_USER_FIRST_NAME],\r\n\r\nThis is a notice to let you know that your PayPal Deposit in the amount of [EMAIL:PAYMENT_AMOUNT] has been received successfully.\r\n\r\nBelow are the details of the deposit:\r\n\r\nAmount: [EMAIL:PAYMENT_AMOUNT]\r\nDate Deposited: [EMAIL:CURRENT_TIME]\r\n\r\nYou can view your new balance at the top of your account at:\r\n[EMAIL:HOME_URL]myaccount.php\r\n\r\nSincerely,\r\n[EMAIL:SITE_NAME] Team'),
(18, 'MakePaymentPaypalAdminCopy', '', 'A PayPal Deposit has been made by [EMAIL:CURRENT_USERNAME] on [EMAIL:CURRENT_TIME]', 'This is a notice to let you know that [EMAIL:CURRENT_USERNAME] has made a PayPal Deposit in the amount of [EMAIL:PAYMENT_AMOUNT].\r\n\r\nBelow are the details of the deposit:\r\n\r\nUsername: [EMAIL:CURRENT_USERNAME]\r\nFirst name: [EMAIL:CURRENT_USER_FIRST_NAME]\r\nLast name: [EMAIL:CURRENT_USER_LAST_NAME]\r\nUser''s email: [EMAIL:CURRENT_USER_EMAIL]\r\nUser''s PayPal email [EMAIL:PAYER_EMAIL]\r\nAmount: [EMAIL:PAYMENT_AMOUNT]\r\nDate Deposited: [EMAIL:CURRENT_TIME]'),
(21, 'ForgotPasswordNotification', '', 'Your account details from [EMAIL:SITE_NAME]', 'Hello [EMAIL:CURRENT_USER_FIRST_NAME],\r\n\r\nYou or someone using this email has requested the password for the account, "[EMAIL:CURRENT_USERNAME]".\r\n\r\nAs a reminder, here are the details of your account.\r\nUsername: [EMAIL:CURRENT_USERNAME]\r\nPassword: [EMAIL:CURRENT_USER_PASSWORD]\r\n\r\nSincerely,\r\n[EMAIL:SITE_NAME] Team'),
(22, 'NewListing', '', 'New Listing  #[EMAIL:AD_ITEM_NUMBER] created on [EMAIL:AD_STARTED]', 'Hello [EMAIL:CURRENT_USERNAME],\r\n\r\nThank you for submitting your item! Below are the details of your new listing. You can preview your listing by clicking <a href=[EMAIL:HOME_URL]ViewItem.php?ItemNum=[EMAIL:AD_ITEM_NUMBER]>here</a>\r\n\r\nDetails\r\n--------------------------------------------------\r\nItem Number: [EMAIL:AD_ITEM_NUMBER]\r\nTitle: [EMAIL:AD_TITLE]\r\nStarted: [EMAIL:AD_STARTED]\r\nDays to Run: [EMAIL:AD_DAYS_RUNNING]\r\nCloses on: [EMAIL:AD_CLOSES]\r\nAsking Price: [EMAIL:AD_ASKING_PRICE]   [EMAIL:AD_MAKE_OFFER]\r\nQuantity: [EMAIL:AD_QUANTITY]\r\nCity/Town: [EMAIL:AD_CITY]\r\nState/Province: [EMAIL:AD_STATE_PROVINCE] \r\n\r\nCharges\r\n----------------------------------------------------\r\nBold: [EMAIL:AD_BOLD_CHARGE]\r\nHighlighted: [EMAIL:AD_HIGHLIGHTED_CHARGE]\r\nCategory Featured: [EMAIL:AD_CATEGORY_FEATURED_CHARGE]\r\nGallery Listing: [EMAIL:AD_GALLERY_CHARGE]\r\nImage Preview: [EMAIL:AD_IMAGE_PREVIEW_CHARGE]\r\nHome Page Featured: [EMAIL:AD_HOME_PAGE_CHARGE]\r\nImage Slide Show: [EMAIL:AD_SLIDE_SHOW_CHARGE]\r\nCounter: [EMAIL:AD_COUNTER_CHARGE]\r\nImage One: [EMAIL:AD_IMAGE_ONE_CHARGE]\r\nImage Two: [EMAIL:AD_IMAGE_TWO_CHARGE]\r\nImage Three: [EMAIL:AD_IMAGE_THREE_CHARGE]\r\nImage Four: [EMAIL:AD_IMAGE_FOUR_CHARGE]\r\nImage Five: [EMAIL:AD_IMAGE_FIVE_CHARGE]\r\n\r\n\r\nThank you,\r\n[EMAIL:SITE_NAME] Team'),
(23, 'NewListingNotification', '', 'Your New Listing # [EMAIL:AD_ITEM_NUMBER] at [EMAIL:SITE_NAME]', 'Hello [EMAIL:CURRENT_USERNAME],\r\n\r\nThank you for submitting your item! Below are the details of your new listing. You can preview your listing by clicking here... [EMAIL:HOME_URL]ViewItem.php?ItemNum=[EMAIL:AD_ITEM_NUMBER]\r\n\r\nDetails\r\n--------------------------------------------------\r\nItem Number: [EMAIL:AD_ITEM_NUMBER]\r\nTitle: [EMAIL:AD_TITLE]\r\nStarted: [EMAIL:AD_STARTED]\r\nDays to Run: [EMAIL:AD_DAYS_RUNNING]\r\nCloses on: [EMAIL:AD_CLOSES]\r\nAsking Price: [EMAIL:AD_ASKING_PRICE]   [EMAIL:AD_MAKE_OFFER]\r\nQuantity: [EMAIL:AD_QUANTITY]\r\nCity/Town: [EMAIL:AD_CITY]\r\nState/Province: [EMAIL:AD_STATE_PROVINCE] \r\n\r\nCharges\r\n----------------------------------------------------\r\nBold: [EMAIL:AD_BOLD_CHARGE]\r\nHighlighted: [EMAIL:AD_HIGHLIGHTED_CHARGE]\r\nCategory Featured: [EMAIL:AD_CATEGORY_FEATURED_CHARGE]\r\nGallery Listing: [EMAIL:AD_GALLERY_CHARGE]\r\nImage Preview: [EMAIL:AD_IMAGE_PREVIEW_CHARGE]\r\nHome Page Featured: [EMAIL:AD_HOME_PAGE_CHARGE]\r\nImage Slide Show: [EMAIL:AD_SLIDE_SHOW_CHARGE]\r\nCounter: [EMAIL:AD_COUNTER_CHARGE]\r\nImage One: [EMAIL:AD_IMAGE_ONE_CHARGE]\r\nImage Two: [EMAIL:AD_IMAGE_TWO_CHARGE]\r\nImage Three: [EMAIL:AD_IMAGE_THREE_CHARGE]\r\nImage Four: [EMAIL:AD_IMAGE_FOUR_CHARGE]\r\nImage Five: [EMAIL:AD_IMAGE_FIVE_CHARGE]\r\n\r\n\r\nThank you,\r\n[EMAIL:SITE_NAME] Team'),
(24, 'NewListingAdminCopy', '', 'A new Listing has been created at [EMAIL:SITE_NAME]', 'A new listing has been created on [EMAIL:AD_STARTED]. Below are the details of the new listing. You can preview the listing by clicking here... [EMAIL:HOME_URL]ViewItem.php?ItemNum=[EMAIL:AD_ITEM_NUMBER]\r\n\r\nDetails\r\n--------------------------------------------------\r\nItem Number: [EMAIL:AD_ITEM_NUMBER]\r\nTitle: [EMAIL:AD_TITLE]\r\nStarted: [EMAIL:AD_STARTED]\r\nDays to Run: [EMAIL:AD_DAYS_RUNNING]\r\nCloses on: [EMAIL:AD_CLOSES]\r\nAsking Price: [EMAIL:AD_ASKING_PRICE]   [EMAIL:AD_MAKE_OFFER]\r\nQuantity: [EMAIL:AD_QUANTITY]\r\nCity/Town: [EMAIL:AD_CITY]\r\nState/Province: [EMAIL:AD_STATE_PROVINCE] \r\n\r\nCharges\r\n----------------------------------------------------\r\nBold: [EMAIL:AD_BOLD_CHARGE]\r\nHighlighted: [EMAIL:AD_HIGHLIGHTED_CHARGE]\r\nCategory Featured: [EMAIL:AD_CATEGORY_FEATURED_CHARGE]\r\nGallery Listing: [EMAIL:AD_GALLERY_CHARGE]\r\nImage Preview: [EMAIL:AD_IMAGE_PREVIEW_CHARGE]\r\nHome Page Featured: [EMAIL:AD_HOME_PAGE_CHARGE]\r\nImage Slide Show: [EMAIL:AD_SLIDE_SHOW_CHARGE]\r\nCounter: [EMAIL:AD_COUNTER_CHARGE]\r\nImage One: [EMAIL:AD_IMAGE_ONE_CHARGE]\r\nImage Two: [EMAIL:AD_IMAGE_TWO_CHARGE]\r\nImage Three: [EMAIL:AD_IMAGE_THREE_CHARGE]\r\nImage Four: [EMAIL:AD_IMAGE_FOUR_CHARGE]\r\nImage Five: [EMAIL:AD_IMAGE_FIVE_CHARGE]\r\n\r\n\r\n'),
(25, 'UserPurchase', NULL, 'Purchase Made on [EMAIL:SITE_NAME]', 'Congratulations on your sale/purchase!   The next step you will want to do is to get in contact with each other and work out the finer details of your transaction, such as shipping details.\r\n\r\nTo the Seller:\r\nYou can contact the buyer at:\r\nUserName: [EMAIL:CURRENT_USERNAME]\r\n[EMAIL:CURRENT_USER_FIRST_NAME] [EMAIL:CURRENT_USER_LAST_NAME]\r\n[EMAIL:CURRENT_USER_EMAIL]\r\n\r\nTo the Buyer:\r\nYou can contact the seller at:\r\nUserName: [EMAIL:SELLER_USERNAME]\r\n[EMAIL:SELLER_FIRST_NAME] [EMAIL:SELLER_LAST_NAME]\r\n[EMAIL:SELLER_EMAIL]\r\n\r\nTransaction Details:\r\nItem: [EMAIL:ITEMNUM] "[EMAIL:ITEMTITLE]"\r\nShipping Method: [EMAIL:SHIPPING_METHOD] @ [EMAIL:SHIPPING_FEE]\r\nTotal Price: [EMAIL:PAYMENT_AMOUNT]\r\n\r\nPlease don''t forget to leave feedback for eachother after you finish this transaction.  You can leave feedback from the ''Purchase History'' page in the ''MyAccount'' area.\r\n\r\nWe hope you had an enjoyable experience with your transaction through [EMAIL:SITE_NAME], and that you will come back soon!'),
(26, 'UserPurchaseNotification', NULL, 'Purchase Made on [EMAIL:SITE_NAME]', 'Congratulations on your sale/purchase!   The next step you will want to do is to get in contact with each other and work out the finer details of your transaction, such as shipping details.\r\n\r\nTo the Seller:\r\nYou can contact the buyer at:\r\nUserName: [EMAIL:CURRENT_USERNAME]\r\n[EMAIL:CURRENT_USER_FIRST_NAME] [EMAIL:CURRENT_USER_LAST_NAME]\r\n[EMAIL:CURRENT_USER_EMAIL]\r\n\r\nTo the Buyer:\r\nYou can contact the seller at:\r\nUserName: [EMAIL:SELLER_USERNAME]\r\n[EMAIL:SELLER_FIRST_NAME] [EMAIL:SELLER_LAST_NAME]\r\n[EMAIL:SELLER_EMAIL]\r\n\r\nTransaction Details:\r\nItem: [EMAIL:ITEMNUM] "[EMAIL:ITEMTITLE]"\r\nShipping Method: [EMAIL:SHIPPING_METHOD] @ [EMAIL:SHIPPING_FEE]\r\nTotal Price: [EMAIL:PAYMENT_AMOUNT]\r\n\r\nPlease don''t forget to leave feedback for eachother after you finish this transaction.  You can leave feedback from the ''Purchase History'' page in the ''MyAccount'' area.\r\n\r\nWe hope you had an enjoyable experience with your transaction through [EMAIL:SITE_NAME], and that you will come back soon!'),
(27, 'NotifyRenew', '', 'Your Listing on [EMAIL:SITE_NAME] is about to expire', 'Your listing on [EMAIL:SITE_NAME] is about to expire. \r\n\r\nItem Number: [EMAIL:ITEM_NUMBER]\r\nTitle: [EMAIL:ITEM_TITLE]\r\nExpiration Date: [EMAIL:EXPIRE]'),
(28, 'NotifyRenewNotification', '', 'Your listing on [EMAIL:SITE_NAME] is about to expire.', 'Your listing on [EMAIL:SITE_NAME] is about to expire. \r\n\r\nItem Number: [EMAIL:ITEM_NUMBER]\r\nTitle: [EMAIL:ITEM_TITLE]\r\nExpiration Date: [EMAIL:EXPIRE]'),
(29, 'SearchNotify', NULL, 'Search Match Notification from [EMAIL:SITE_NAME]', 'New Items have been matched by your Scheduled Search on [EMAIL:SITE_NAME].  To disable or modify your search scheduling please logon to your Account, go to "My Recent and Saved Searches", find your saved search from [EMAIL:SS_DATE].  Then click on "Auto-Notification Scheduling" and uncheck the "Enable Scheduling" box.\r\n\r\nYour new matches are as follows:\r\n[EMAIL:NEW_MATCHES]'),
(30, 'SearchNotifyNotification', NULL, 'Search Match Notification from [EMAIL:SITE_NAME]', 'New Items have been matched by your Scheduled Search on [EMAIL:SITE_NAME].  To disable or modify your search scheduling please logon to your Account, go to "My Recent and Saved Searches", find your saved search from [EMAIL:SS_DATE].  Then click on "Auto-Notification Scheduling" and uncheck the "Enable Scheduling" box.'),
(31, 'NewListingApproval', '', 'New Listing  #[EMAIL:AD_ITEM_NUMBER] Submitted for Approval', 'Hello [EMAIL:CURRENT_USERNAME],\r\n\r\nThank you for submitting your item! Below are the details of your new listing. Your listing should go through the approval process and started very shortly.  The running time of the listing will be begin when it is approved.\r\nDetails\r\n--------------------------------------------------\r\nItem Number: [EMAIL:AD_ITEM_NUMBER]\r\nTitle: [EMAIL:AD_TITLE]\r\nStarted: [EMAIL:AD_STARTED]\r\nDays to Run: [EMAIL:AD_DAYS_RUNNING]\r\nCloses on: [EMAIL:AD_CLOSES]\r\nAsking Price: [EMAIL:AD_ASKING_PRICE]   [EMAIL:AD_MAKE_OFFER]\r\nQuantity: [EMAIL:AD_QUANTITY]\r\nCity/Town: [EMAIL:AD_CITY]\r\nState/Province: [EMAIL:AD_STATE_PROVINCE] \r\n\r\nCharges\r\n----------------------------------------------------\r\nBold: [EMAIL:AD_BOLD_CHARGE]\r\nHighlighted: [EMAIL:AD_HIGHLIGHTED_CHARGE]\r\nCategory Featured: [EMAIL:AD_CATEGORY_FEATURED_CHARGE]\r\nGallery Listing: [EMAIL:AD_GALLERY_CHARGE]\r\nImage Preview: [EMAIL:AD_IMAGE_PREVIEW_CHARGE]\r\nHome Page Featured: [EMAIL:AD_HOME_PAGE_CHARGE]\r\nImage Slide Show: [EMAIL:AD_SLIDE_SHOW_CHARGE]\r\nCounter: [EMAIL:AD_COUNTER_CHARGE]\r\nImage One: [EMAIL:AD_IMAGE_ONE_CHARGE]\r\nImage Two: [EMAIL:AD_IMAGE_TWO_CHARGE]\r\nImage Three: [EMAIL:AD_IMAGE_THREE_CHARGE]\r\nImage Four: [EMAIL:AD_IMAGE_FOUR_CHARGE]\r\nImage Five: [EMAIL:AD_IMAGE_FIVE_CHARGE]\r\n\r\n\r\nThank you,\r\n[EMAIL:SITE_NAME] Team'),
(32, 'NewListingApprovalNotification', '', 'Your New Listing # [EMAIL:AD_ITEM_NUMBER] at [EMAIL:SITE_NAME] has been submitted for approval', 'Hello [EMAIL:CURRENT_USERNAME],\r\n\r\nThank you for submitting your item! Below are the details of your new listing. Your listing should go through the approval process and started very shortly.  The running time of the listing will be begin when it is approved.\r\n\r\nDetails\r\n--------------------------------------------------\r\nItem Number: [EMAIL:AD_ITEM_NUMBER]\r\nTitle: [EMAIL:AD_TITLE]\r\nStarted: [EMAIL:AD_STARTED]\r\nDays to Run: [EMAIL:AD_DAYS_RUNNING]\r\nCloses on: [EMAIL:AD_CLOSES]\r\nAsking Price: [EMAIL:AD_ASKING_PRICE]   [EMAIL:AD_MAKE_OFFER]\r\nQuantity: [EMAIL:AD_QUANTITY]\r\nCity/Town: [EMAIL:AD_CITY]\r\nState/Province: [EMAIL:AD_STATE_PROVINCE] \r\n\r\nCharges\r\n----------------------------------------------------\r\nBold: [EMAIL:AD_BOLD_CHARGE]\r\nHighlighted: [EMAIL:AD_HIGHLIGHTED_CHARGE]\r\nCategory Featured: [EMAIL:AD_CATEGORY_FEATURED_CHARGE]\r\nGallery Listing: [EMAIL:AD_GALLERY_CHARGE]\r\nImage Preview: [EMAIL:AD_IMAGE_PREVIEW_CHARGE]\r\nHome Page Featured: [EMAIL:AD_HOME_PAGE_CHARGE]\r\nImage Slide Show: [EMAIL:AD_SLIDE_SHOW_CHARGE]\r\nCounter: [EMAIL:AD_COUNTER_CHARGE]\r\nImage One: [EMAIL:AD_IMAGE_ONE_CHARGE]\r\nImage Two: [EMAIL:AD_IMAGE_TWO_CHARGE]\r\nImage Three: [EMAIL:AD_IMAGE_THREE_CHARGE]\r\nImage Four: [EMAIL:AD_IMAGE_FOUR_CHARGE]\r\nImage Five: [EMAIL:AD_IMAGE_FIVE_CHARGE]\r\n\r\n\r\nThank you,\r\n[EMAIL:SITE_NAME] Team'),
(33, 'NewListingApprovalAdminCopy', '', 'A new Listing has been submitted for approval [EMAIL:SITE_NAME]', 'A new listing has been created on [EMAIL:AD_STARTED]. Below are the details of the new listing. You can preview, edit and approve (if you are a member of the ''Front-End Admin'' group)  the listing by clicking here... [EMAIL:HOME_URL]ViewItem.php?ItemNum=[EMAIL:AD_ITEM_NUMBER]\r\n\r\nDetails\r\n--------------------------------------------------\r\nItem Number: [EMAIL:AD_ITEM_NUMBER]\r\nTitle: [EMAIL:AD_TITLE]\r\nStarted: [EMAIL:AD_STARTED]\r\nDays to Run: [EMAIL:AD_DAYS_RUNNING]\r\nCloses on: [EMAIL:AD_CLOSES]\r\nAsking Price: [EMAIL:AD_ASKING_PRICE]   [EMAIL:AD_MAKE_OFFER]\r\nQuantity: [EMAIL:AD_QUANTITY]\r\nCity/Town: [EMAIL:AD_CITY]\r\nState/Province: [EMAIL:AD_STATE_PROVINCE] \r\n\r\nCharges\r\n----------------------------------------------------\r\nBold: [EMAIL:AD_BOLD_CHARGE]\r\nHighlighted: [EMAIL:AD_HIGHLIGHTED_CHARGE]\r\nCategory Featured: [EMAIL:AD_CATEGORY_FEATURED_CHARGE]\r\nGallery Listing: [EMAIL:AD_GALLERY_CHARGE]\r\nImage Preview: [EMAIL:AD_IMAGE_PREVIEW_CHARGE]\r\nHome Page Featured: [EMAIL:AD_HOME_PAGE_CHARGE]\r\nImage Slide Show: [EMAIL:AD_SLIDE_SHOW_CHARGE]\r\nCounter: [EMAIL:AD_COUNTER_CHARGE]\r\nImage One: [EMAIL:AD_IMAGE_ONE_CHARGE]\r\nImage Two: [EMAIL:AD_IMAGE_TWO_CHARGE]\r\nImage Three: [EMAIL:AD_IMAGE_THREE_CHARGE]\r\nImage Four: [EMAIL:AD_IMAGE_FOUR_CHARGE]\r\nImage Five: [EMAIL:AD_IMAGE_FIVE_CHARGE]\r\n\r\n\r\n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `templates_gal`
--

CREATE TABLE IF NOT EXISTS `templates_gal` (
  `id` bigint(200) NOT NULL AUTO_INCREMENT,
  `cat_id` bigint(20) NOT NULL DEFAULT '0',
  `template` blob,
  `active` tinyint(2) NOT NULL DEFAULT '0',
  `admin_override` tinyint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `templates_items`
--

CREATE TABLE IF NOT EXISTS `templates_items` (
  `id` bigint(200) NOT NULL AUTO_INCREMENT,
  `cat_id` bigint(20) NOT NULL DEFAULT '0',
  `template` blob,
  `active` tinyint(2) NOT NULL DEFAULT '0',
  `admin_override` tinyint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `templates_newitem`
--

CREATE TABLE IF NOT EXISTS `templates_newitem` (
  `id` bigint(200) NOT NULL AUTO_INCREMENT,
  `cat_id` bigint(20) NOT NULL DEFAULT '0',
  `template` blob,
  `active` tinyint(2) NOT NULL DEFAULT '0',
  `admin_override` tinyint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `templates_pages`
--

CREATE TABLE IF NOT EXISTS `templates_pages` (
  `page_id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(255) DEFAULT NULL,
  `page_html` text,
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `templates_pages`
--

INSERT INTO `templates_pages` (`page_id`, `page_name`, `page_html`) VALUES
(1, 'help index', 'Put your help content here...'),
(6, 'Fees', 'Put your help content here'),
(7, 'Terms and Conditions', 'Este sitio esta diseñado para el aprendizaje, lo ofrecido no es real.'),
(8, 'PowerSearch', '<table class="ft" cellspacing="0" border="0" width="100%">\r\n		<tr>\r\n      		<td class="ct" heigth="31"><strong>Power&nbsp;Search&nbsp;Explanation&nbsp;&nbsp;&nbsp;&nbsp;</strong></td></tr>\r\n      	<tr>\r\n	      	<td >The new "Power Search" box gives you flexibility to find exactly what you are looking for in one search.  \r\n	      	<br>To maximize it''s capabilities please read over the following explanation:  \r\n	      	<br><br>The Power Search field is based on a very simple model similar to Google searches.  You specify words with "modifiers" to get exactly what you are searching for and the Power Search will search the entire Listing for matches.  \r\n	      	<br>The available "modifiers" are: \r\n	      	<hr><b>+</b> The "Plus" sign says that the results <b>must</b> contain the following word \r\n	      	<hr width="25%" align="center"><b>-</b> The "Minus" sign says that the results <b>must NOT</b> contain the following word  \r\n	      	<hr width="25%" align="center"><b>*</b> The "Star" is a <b>Wild Card</b> and will match a partial word \r\n	      	<hr width="25%" align="center"><b>"</b> Putting "Quotes" around a phrase will search for that exact phrase \r\n	      	<hr width="25%" align="center"><b>No Modifier</b> The search will match any listing that contains a word with no modifier\r\n	      	<hr><b>Basic Valid Examples:</b>\r\n	      	<br><i>a b c</i> = Will match any listing that contains a or b or c\r\n	      	<br><i>+a +b +c</i> = Will only match an listing that contain all of a and b and c\r\n	      	<br><i>-a -b +c</i> = Will match any listing that does not contain a or b but does contain c\r\n	      	<br><i>"ab c"</i> = Will match the phrase "ab c"\r\n	      	<br><i>*a "b c"</i> = Will match any listings that have a word that ends in "a" and contains the phrase "b c"\r\n	      	<hr><b>Rules</b>\r\n	      	<br>--Multiple modifiers <b>can</b> be used together in 1 search, Example: <i>+ab c* -defg</i>  is valid\r\n	      	<br>--Individual search terms <b>can not</b> contain more than 1 modifier, Example: <i>+"ab c"</i>  is <b>not</b> valid\r\n	      	</td>\r\n    	</tr>\r\n  	</table>');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `templates_storefront`
--

CREATE TABLE IF NOT EXISTS `templates_storefront` (
  `id` bigint(200) NOT NULL AUTO_INCREMENT,
  `cat_id` bigint(20) NOT NULL DEFAULT '0',
  `template` blob,
  `active` tinyint(2) NOT NULL DEFAULT '0',
  `admin_override` tinyint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `used_coupons`
--

CREATE TABLE IF NOT EXISTS `used_coupons` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(20) DEFAULT NULL,
  `coupon_id` int(20) DEFAULT NULL,
  `date` int(20) NOT NULL DEFAULT '0',
  `ItemNum` int(20) DEFAULT NULL,
  `used` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `used_promos`
--

CREATE TABLE IF NOT EXISTS `used_promos` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(20) DEFAULT NULL,
  `promo_id` int(20) DEFAULT NULL,
  `date` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `used_subscriptions`
--

CREATE TABLE IF NOT EXISTS `used_subscriptions` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(20) DEFAULT NULL,
  `date` int(12) DEFAULT NULL,
  `expires` bigint(255) DEFAULT NULL,
  `subsc_id` int(20) DEFAULT NULL,
  `paid` decimal(10,2) DEFAULT NULL,
  `group` int(20) DEFAULT NULL,
  `active` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `used_subscriptions`
--

INSERT INTO `used_subscriptions` (`id`, `user_id`, `date`, `expires`, `subsc_id`, `paid`, `group`, `active`) VALUES
(1, 1, 1200240584, 1391393748, 1, 0.00, 1, 0),
(2, 1, 1200241045, 1391393748, 1, 0.00, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `used_tokens`
--

CREATE TABLE IF NOT EXISTS `used_tokens` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(20) DEFAULT NULL,
  `ItemNum` int(20) DEFAULT NULL,
  `date` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `used_tokens`
--

INSERT INTO `used_tokens` (`id`, `user_id`, `ItemNum`, `date`) VALUES
(1, 2, 604532037, 1200672059),
(2, 2, 946112158, 1200672165),
(3, 2, 555822266, 1200672274),
(4, 2, 125752357, 1200672364);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(20) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `user_login` varchar(15) NOT NULL DEFAULT '',
  `user_password` varchar(15) NOT NULL DEFAULT '',
  `email` varchar(64) DEFAULT NULL,
  `country_id` int(11) NOT NULL DEFAULT '0',
  `state_id` varchar(100) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `address1` varchar(50) DEFAULT NULL,
  `address2` varchar(50) DEFAULT NULL,
  `phone_day` varchar(20) DEFAULT NULL,
  `phone_evn` varchar(20) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `education` int(11) DEFAULT NULL,
  `income` int(11) DEFAULT NULL,
  `date_created` int(12) DEFAULT NULL,
  `agreement_id` int(11) DEFAULT NULL,
  `ip_insert` varchar(50) DEFAULT NULL,
  `ip_update` varchar(50) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `code` varchar(20) DEFAULT NULL,
  `verified` tinyint(4) DEFAULT NULL,
  `posts` int(11) DEFAULT '0',
  `newsletter` tinyint(4) DEFAULT '0',
  `newstype` tinyint(4) DEFAULT '0',
  `promocode` varchar(25) DEFAULT NULL,
  `tokens` int(20) DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_login` (`user_login`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `user_login`, `user_password`, `email`, `country_id`, `state_id`, `city`, `zip`, `address1`, `address2`, `phone_day`, `phone_evn`, `fax`, `age`, `gender`, `education`, `income`, `date_created`, `agreement_id`, `ip_insert`, `ip_update`, `balance`, `status`, `code`, `verified`, `posts`, `newsletter`, `newstype`, `promocode`, `tokens`) VALUES
(1, 'Elias Manuel ', 'Concha Gaviria', 'Cuchillo', 'subrata', 'eliasmanuelconcha1977@yahoo.com', 49, 'Antioquia', 'Medellin', '452435', 'calle 45#42-30', 'Calle 25 #12-10', '30077427923', NULL, NULL, 3, 1, 3, 2, 1198514064, 1, '59.93.166.101', '59.93.166.101', NULL, 1, NULL, NULL, 0, 1, 0, NULL, 0),
(5, 'John', 'John', 'John8212', 'disarm33engine', 'w3af@email.com', 219, 'AK', 'Buenos Aires', '90210', 'Bonsai Street 123', 'Bonsai Street 123', '55550178', '55550178', '55550178', 0, 0, 0, 0, 1392604993, 1, '192.168.0.16', '192.168.0.16', NULL, 1, NULL, NULL, 0, 1, 0, NULL, 20),
(4, 'prueba', 'prueba2', 'prueba', 'prueba', 'callefalsa@gmail.com', 1, 'California', 'Springfield', '0000', 'calle falsa 123', NULL, NULL, NULL, NULL, 4, 1, 2, 1, 1391923560, 1, '192.168.1.3', '192.168.1.3', NULL, 1, NULL, NULL, 0, 1, 0, NULL, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `watchlist`
--

CREATE TABLE IF NOT EXISTS `watchlist` (
  `watch_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `itemID` varchar(255) DEFAULT NULL,
  `ItemTitle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`watch_id`),
  UNIQUE KEY `wlNum` (`watch_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
