-- phpMyAdmin SQL Dump
-- version 2.10.0.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jan 19, 2008 at 09:34 AM
-- Server version: 5.0.45
-- PHP Version: 4.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `itechc_classifieds`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `administrators`
-- 

CREATE TABLE `administrators` (
  `admin_id` tinyint(3) NOT NULL auto_increment,
  `username` varchar(255) default NULL,
  `password` varchar(255) default NULL,
  `level` tinyint(4) NOT NULL default '0',
  `firstname` varchar(255) default NULL,
  `lastname` varchar(255) default NULL,
  `address` text,
  `phone` varchar(50) default NULL,
  `pager` varchar(20) default NULL,
  `cell` varchar(20) default NULL,
  PRIMARY KEY  (`admin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `administrators`
-- 

INSERT INTO `administrators` VALUES (3, 'admin', 'admin', 3, 'Administrator', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `categories`
-- 

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL auto_increment,
  `sub_cat_id` int(11) default NULL,
  `name` varchar(255) default NULL,
  `weight` int(11) NOT NULL default '1',
  `count` int(10) default '0',
  `member` tinyint(3) default NULL,
  PRIMARY KEY  (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=235 ;

-- 
-- Dumping data for table `categories`
-- 

INSERT INTO `categories` VALUES (1, 0, 'Main', 1, 4, NULL);
INSERT INTO `categories` VALUES (2, 1, 'Arts & Antiques', 1, 0, NULL);
INSERT INTO `categories` VALUES (3, 1, 'Sports', 1, 0, NULL);
INSERT INTO `categories` VALUES (6, 1, 'Books', 1, 1, NULL);
INSERT INTO `categories` VALUES (7, 1, 'Office & Industrial', 1, 0, NULL);
INSERT INTO `categories` VALUES (8, 1, 'Dolls & Bears', 1, 0, NULL);
INSERT INTO `categories` VALUES (9, 1, 'Home & Garden', 1, 0, NULL);
INSERT INTO `categories` VALUES (10, 1, 'Clothing & Accessories', 1, 0, NULL);
INSERT INTO `categories` VALUES (11, 1, 'Movies & Television', 1, 0, NULL);
INSERT INTO `categories` VALUES (12, 1, 'Music', 1, 0, NULL);
INSERT INTO `categories` VALUES (13, 1, 'Photography', 1, 0, NULL);
INSERT INTO `categories` VALUES (14, 1, 'Collectibles', 1, 0, NULL);
INSERT INTO `categories` VALUES (15, 1, 'Pottery & Glass', 1, 0, NULL);
INSERT INTO `categories` VALUES (16, 1, 'Real Estate', 1, 0, NULL);
INSERT INTO `categories` VALUES (17, 1, 'Computers', 1, 2, NULL);
INSERT INTO `categories` VALUES (18, 1, 'Stamps', 1, 0, NULL);
INSERT INTO `categories` VALUES (19, 1, 'Tickets & Travel', 1, 0, NULL);
INSERT INTO `categories` VALUES (20, 1, 'Toys & Hobbies', 1, 0, NULL);
INSERT INTO `categories` VALUES (21, 1, 'Consumer Electronics', 1, 1, NULL);
INSERT INTO `categories` VALUES (23, 2, 'Antiques', 1, 0, NULL);
INSERT INTO `categories` VALUES (24, 2, 'Art', 1, 0, NULL);
INSERT INTO `categories` VALUES (25, 6, 'Antiquarian & Collectible', 1, 0, NULL);
INSERT INTO `categories` VALUES (26, 6, 'Audio', 1, 1, NULL);
INSERT INTO `categories` VALUES (27, 6, 'Childrens', 1, 0, NULL);
INSERT INTO `categories` VALUES (28, 6, 'Fictional', 1, 0, NULL);
INSERT INTO `categories` VALUES (29, 6, 'Magazines & Catalogs', 1, 0, NULL);
INSERT INTO `categories` VALUES (30, 6, 'Nonfiction', 1, 0, NULL);
INSERT INTO `categories` VALUES (31, 6, 'Bulk Lots', 1, 0, NULL);
INSERT INTO `categories` VALUES (32, 6, 'Other', 1, 0, NULL);
INSERT INTO `categories` VALUES (33, 7, 'Agriculture', 1, 0, NULL);
INSERT INTO `categories` VALUES (34, 7, 'Business for Sale', 1, 0, NULL);
INSERT INTO `categories` VALUES (35, 7, 'Construction', 1, 0, NULL);
INSERT INTO `categories` VALUES (36, 7, 'Electronic Components', 1, 0, NULL);
INSERT INTO `categories` VALUES (37, 7, 'Industrial Supply', 1, 0, NULL);
INSERT INTO `categories` VALUES (38, 7, 'Laboratory Equipment', 1, 0, NULL);
INSERT INTO `categories` VALUES (39, 7, 'Large Lots, Wholesale', 1, 0, NULL);
INSERT INTO `categories` VALUES (40, 7, 'Medical, Dental', 1, 0, NULL);
INSERT INTO `categories` VALUES (41, 7, 'Metalworking Equipment', 1, 0, NULL);
INSERT INTO `categories` VALUES (42, 7, 'Office Products', 1, 0, NULL);
INSERT INTO `categories` VALUES (43, 7, 'Printing Equipment', 1, 0, NULL);
INSERT INTO `categories` VALUES (44, 7, 'Restaraunt & Foodservice', 1, 0, NULL);
INSERT INTO `categories` VALUES (45, 7, 'Retail', 1, 0, NULL);
INSERT INTO `categories` VALUES (46, 7, 'Test, Measurement Equipment', 1, 0, NULL);
INSERT INTO `categories` VALUES (47, 7, 'Other Industries', 1, 0, NULL);
INSERT INTO `categories` VALUES (48, 10, 'Infants', 1, 0, NULL);
INSERT INTO `categories` VALUES (49, 10, 'Boys', 1, 0, NULL);
INSERT INTO `categories` VALUES (50, 10, 'Men', 1, 0, NULL);
INSERT INTO `categories` VALUES (51, 10, 'Girls', 1, 0, NULL);
INSERT INTO `categories` VALUES (52, 10, 'Women', 1, 0, NULL);
INSERT INTO `categories` VALUES (53, 10, 'Uniforms', 1, 0, NULL);
INSERT INTO `categories` VALUES (54, 10, 'Wedding Apparel', 1, 0, NULL);
INSERT INTO `categories` VALUES (55, 1, 'Coins', 1, 0, NULL);
INSERT INTO `categories` VALUES (56, 55, 'US Coins', 1, 0, NULL);
INSERT INTO `categories` VALUES (57, 55, 'World Coins', 1, 0, NULL);
INSERT INTO `categories` VALUES (58, 55, 'Exonumia', 1, 0, NULL);
INSERT INTO `categories` VALUES (59, 55, 'US Paper Money', 1, 0, NULL);
INSERT INTO `categories` VALUES (60, 55, 'World Paper Money', 1, 0, NULL);
INSERT INTO `categories` VALUES (61, 55, 'Scripophily', 1, 0, NULL);
INSERT INTO `categories` VALUES (62, 14, 'Advertising', 1, 0, NULL);
INSERT INTO `categories` VALUES (63, 14, 'Animals', 1, 0, NULL);
INSERT INTO `categories` VALUES (64, 14, 'Art, Animation & Photo Images', 1, 0, NULL);
INSERT INTO `categories` VALUES (65, 14, 'Autographs', 1, 0, NULL);
INSERT INTO `categories` VALUES (66, 14, 'Breweriana', 1, 0, NULL);
INSERT INTO `categories` VALUES (67, 14, 'Coin-Op, Banks & Casino', 1, 0, NULL);
INSERT INTO `categories` VALUES (68, 14, 'Comics', 1, 0, NULL);
INSERT INTO `categories` VALUES (69, 14, 'Cultures & Religons', 1, 0, NULL);
INSERT INTO `categories` VALUES (70, 14, 'Decorative & Holiday', 1, 0, NULL);
INSERT INTO `categories` VALUES (71, 14, 'Disneyana', 1, 0, NULL);
INSERT INTO `categories` VALUES (72, 14, 'Furnishings & Tools', 1, 0, NULL);
INSERT INTO `categories` VALUES (73, 14, 'Historical Memoribilia', 1, 0, NULL);
INSERT INTO `categories` VALUES (74, 14, 'Housewares & Kitchenwares', 1, 0, NULL);
INSERT INTO `categories` VALUES (75, 14, 'Knives & Swords', 1, 0, NULL);
INSERT INTO `categories` VALUES (76, 14, 'Metalware', 1, 0, NULL);
INSERT INTO `categories` VALUES (77, 14, 'Militaria', 1, 0, NULL);
INSERT INTO `categories` VALUES (78, 14, 'Paper & Writing Instruments', 1, 0, NULL);
INSERT INTO `categories` VALUES (79, 14, 'Pop Culture', 1, 0, NULL);
INSERT INTO `categories` VALUES (80, 14, 'Science Fiction', 1, 0, NULL);
INSERT INTO `categories` VALUES (81, 14, 'Science Medical', 1, 0, NULL);
INSERT INTO `categories` VALUES (82, 14, 'Tobacciana', 1, 0, NULL);
INSERT INTO `categories` VALUES (83, 14, 'Trading Cards', 1, 0, NULL);
INSERT INTO `categories` VALUES (84, 14, 'Transportation', 1, 0, NULL);
INSERT INTO `categories` VALUES (85, 14, 'Vintage Clothing & Accessories', 1, 0, NULL);
INSERT INTO `categories` VALUES (86, 17, 'Apple, Macintosh', 1, 0, NULL);
INSERT INTO `categories` VALUES (87, 17, 'Desktop Components', 1, 1, NULL);
INSERT INTO `categories` VALUES (88, 17, 'Desktop PCs', 1, 0, NULL);
INSERT INTO `categories` VALUES (89, 17, 'Domain Names', 1, 0, NULL);
INSERT INTO `categories` VALUES (90, 17, 'Drives, Media', 1, 0, NULL);
INSERT INTO `categories` VALUES (91, 17, 'Input Peripherals', 1, 0, NULL);
INSERT INTO `categories` VALUES (92, 17, 'Laptops & Accessories', 1, 0, NULL);
INSERT INTO `categories` VALUES (93, 17, 'Monitors', 1, 0, NULL);
INSERT INTO `categories` VALUES (94, 17, 'Networking & Telecom', 1, 0, NULL);
INSERT INTO `categories` VALUES (95, 17, 'Other Hardware', 1, 0, NULL);
INSERT INTO `categories` VALUES (96, 17, 'Printers & Supplies', 1, 0, NULL);
INSERT INTO `categories` VALUES (97, 17, 'Scanners', 1, 0, NULL);
INSERT INTO `categories` VALUES (98, 17, 'Services', 1, 0, NULL);
INSERT INTO `categories` VALUES (99, 17, 'Software', 1, 1, NULL);
INSERT INTO `categories` VALUES (100, 17, 'Technology Books', 1, 0, NULL);
INSERT INTO `categories` VALUES (101, 17, 'Video & Multimedia', 1, 0, NULL);
INSERT INTO `categories` VALUES (102, 17, 'Bulk Lots', 1, 0, NULL);
INSERT INTO `categories` VALUES (103, 21, 'Camcoders', 1, 0, NULL);
INSERT INTO `categories` VALUES (104, 21, 'Car Audio & Electronics', 1, 0, NULL);
INSERT INTO `categories` VALUES (105, 21, 'Gadgets & Other Electronics', 1, 0, NULL);
INSERT INTO `categories` VALUES (106, 21, 'Home Audio & Video', 1, 0, NULL);
INSERT INTO `categories` VALUES (107, 21, 'PDAs & Handheld PCs', 1, 0, NULL);
INSERT INTO `categories` VALUES (108, 21, 'Phones & Wireless Devices', 1, 1, NULL);
INSERT INTO `categories` VALUES (109, 21, 'Portable Audio & Video', 1, 0, NULL);
INSERT INTO `categories` VALUES (110, 21, 'Professional Video Equipment', 1, 0, NULL);
INSERT INTO `categories` VALUES (111, 21, 'Radio Equipment', 1, 0, NULL);
INSERT INTO `categories` VALUES (112, 21, 'Video Games', 1, 0, NULL);
INSERT INTO `categories` VALUES (113, 8, 'Barbies', 1, 0, NULL);
INSERT INTO `categories` VALUES (114, 8, 'Bears', 1, 0, NULL);
INSERT INTO `categories` VALUES (115, 8, 'Doll Clothes, Furniture', 1, 0, NULL);
INSERT INTO `categories` VALUES (116, 8, 'Doll Making, Patterns, Repair', 1, 0, NULL);
INSERT INTO `categories` VALUES (117, 8, 'Dolls', 1, 0, NULL);
INSERT INTO `categories` VALUES (118, 8, 'Houses & Miniatures', 1, 0, NULL);
INSERT INTO `categories` VALUES (119, 8, 'Paper Dolls', 1, 0, NULL);
INSERT INTO `categories` VALUES (120, 9, 'Baby Items', 1, 0, NULL);
INSERT INTO `categories` VALUES (121, 9, 'Bed & Bath', 1, 0, NULL);
INSERT INTO `categories` VALUES (122, 9, 'Building & Repair Materials', 1, 0, NULL);
INSERT INTO `categories` VALUES (123, 9, 'Food & Wine', 1, 0, NULL);
INSERT INTO `categories` VALUES (124, 9, 'Furniture', 1, 0, NULL);
INSERT INTO `categories` VALUES (125, 9, 'Home Decor', 1, 0, NULL);
INSERT INTO `categories` VALUES (126, 9, 'Housekeeping & Organizing', 1, 0, NULL);
INSERT INTO `categories` VALUES (127, 9, 'Kitchen & Tables', 1, 0, NULL);
INSERT INTO `categories` VALUES (128, 9, 'Lamps, Lighting & Ceiling Fans', 1, 0, NULL);
INSERT INTO `categories` VALUES (129, 9, 'Lawn & Garden', 1, 0, NULL);
INSERT INTO `categories` VALUES (130, 9, 'Major Appliances', 1, 0, NULL);
INSERT INTO `categories` VALUES (131, 9, 'Outdoor Living', 1, 0, NULL);
INSERT INTO `categories` VALUES (132, 9, 'Pet Supplies', 1, 0, NULL);
INSERT INTO `categories` VALUES (133, 9, 'Tools', 1, 0, NULL);
INSERT INTO `categories` VALUES (134, 1, 'Jewelry, Gems & Watches', 1, 0, NULL);
INSERT INTO `categories` VALUES (135, 134, 'Beads, Amulets', 1, 0, NULL);
INSERT INTO `categories` VALUES (136, 134, 'Costume Jewelry', 1, 0, NULL);
INSERT INTO `categories` VALUES (137, 134, 'Ethnic, Tribal', 1, 0, NULL);
INSERT INTO `categories` VALUES (138, 134, 'Fine', 1, 0, NULL);
INSERT INTO `categories` VALUES (139, 134, 'Hair', 1, 0, NULL);
INSERT INTO `categories` VALUES (140, 134, 'Designer, Artisan', 1, 0, NULL);
INSERT INTO `categories` VALUES (141, 134, 'Jewelry Boxes', 1, 0, NULL);
INSERT INTO `categories` VALUES (142, 134, 'Supplies', 1, 0, NULL);
INSERT INTO `categories` VALUES (143, 134, 'Loose Gemstones', 1, 0, NULL);
INSERT INTO `categories` VALUES (144, 134, 'Mens', 1, 0, NULL);
INSERT INTO `categories` VALUES (145, 134, 'Watches', 1, 0, NULL);
INSERT INTO `categories` VALUES (146, 11, 'Memorabilia', 1, 0, NULL);
INSERT INTO `categories` VALUES (147, 11, 'Video, Film', 1, 0, NULL);
INSERT INTO `categories` VALUES (148, 12, 'CDs, Records, & Tapes', 1, 0, NULL);
INSERT INTO `categories` VALUES (149, 12, 'Music Memorabilia', 1, 0, NULL);
INSERT INTO `categories` VALUES (150, 12, 'Musical Instruments', 1, 0, NULL);
INSERT INTO `categories` VALUES (151, 12, 'Sheet Music, Music Books', 1, 0, NULL);
INSERT INTO `categories` VALUES (152, 13, 'Albums & Archival Material', 1, 0, NULL);
INSERT INTO `categories` VALUES (153, 13, 'Camera Accessories', 1, 0, NULL);
INSERT INTO `categories` VALUES (154, 13, 'Darkroom Equipment & Supplies', 1, 0, NULL);
INSERT INTO `categories` VALUES (155, 13, 'Digital Cameras', 1, 0, NULL);
INSERT INTO `categories` VALUES (156, 13, 'Film', 1, 0, NULL);
INSERT INTO `categories` VALUES (157, 13, 'Film Cameras', 1, 0, NULL);
INSERT INTO `categories` VALUES (158, 13, 'Lenses', 1, 0, NULL);
INSERT INTO `categories` VALUES (159, 13, 'Projection Equipment', 1, 0, NULL);
INSERT INTO `categories` VALUES (160, 13, 'Stock Photography & Footage', 1, 0, NULL);
INSERT INTO `categories` VALUES (161, 13, 'Vintage', 1, 0, NULL);
INSERT INTO `categories` VALUES (162, 15, 'Glass', 1, 0, NULL);
INSERT INTO `categories` VALUES (163, 15, 'Pottery & China', 1, 0, NULL);
INSERT INTO `categories` VALUES (164, 16, 'Commercial', 1, 0, NULL);
INSERT INTO `categories` VALUES (165, 16, 'Land', 1, 0, NULL);
INSERT INTO `categories` VALUES (166, 16, 'Residential', 1, 0, NULL);
INSERT INTO `categories` VALUES (167, 16, 'Timeshares for Sale', 1, 0, NULL);
INSERT INTO `categories` VALUES (168, 16, 'Other Real Estate', 1, 0, NULL);
INSERT INTO `categories` VALUES (169, 3, 'Autographs', 1, 0, NULL);
INSERT INTO `categories` VALUES (170, 3, 'Fan Shop', 1, 0, NULL);
INSERT INTO `categories` VALUES (171, 3, 'Memorabilia', 1, 0, NULL);
INSERT INTO `categories` VALUES (172, 3, 'Sporting Goods', 1, 0, NULL);
INSERT INTO `categories` VALUES (173, 3, 'Trading Cards', 1, 0, NULL);
INSERT INTO `categories` VALUES (174, 18, 'United States', 1, 0, NULL);
INSERT INTO `categories` VALUES (175, 18, 'Australia', 1, 0, NULL);
INSERT INTO `categories` VALUES (176, 18, 'Canada', 1, 0, NULL);
INSERT INTO `categories` VALUES (177, 18, 'Br. Comm. Other', 1, 0, NULL);
INSERT INTO `categories` VALUES (178, 18, 'UK (Great Britain)', 1, 0, NULL);
INSERT INTO `categories` VALUES (179, 18, 'Europe', 1, 0, NULL);
INSERT INTO `categories` VALUES (180, 18, 'Latin America', 1, 0, NULL);
INSERT INTO `categories` VALUES (181, 18, 'Other', 1, 0, NULL);
INSERT INTO `categories` VALUES (182, 18, 'Philately', 1, 0, NULL);
INSERT INTO `categories` VALUES (183, 18, 'Topical', 1, 0, NULL);
INSERT INTO `categories` VALUES (184, 19, 'Tickets & Experiences', 1, 0, NULL);
INSERT INTO `categories` VALUES (185, 19, 'Travel', 1, 0, NULL);
INSERT INTO `categories` VALUES (186, 20, 'Action Figures', 1, 0, NULL);
INSERT INTO `categories` VALUES (187, 20, 'Building Toys', 1, 0, NULL);
INSERT INTO `categories` VALUES (188, 20, 'Classic Toys', 1, 0, NULL);
INSERT INTO `categories` VALUES (189, 20, 'Diecast Toys', 1, 0, NULL);
INSERT INTO `categories` VALUES (190, 20, 'Educational, Development', 1, 0, NULL);
INSERT INTO `categories` VALUES (191, 20, 'Electronic, Battery, Wind-Up', 1, 0, NULL);
INSERT INTO `categories` VALUES (192, 20, 'Fast Food, Advertising', 1, 0, NULL);
INSERT INTO `categories` VALUES (193, 20, 'Games', 1, 0, NULL);
INSERT INTO `categories` VALUES (194, 20, 'Hobbies & Crafts', 1, 0, NULL);
INSERT INTO `categories` VALUES (195, 20, 'Outdoor Toys, Structures', 1, 0, NULL);
INSERT INTO `categories` VALUES (196, 20, 'Pretend Play, Make-Believe', 1, 0, NULL);
INSERT INTO `categories` VALUES (197, 20, 'Puzzles', 1, 0, NULL);
INSERT INTO `categories` VALUES (198, 20, 'Robots, Monsters, Space Toys', 1, 0, NULL);
INSERT INTO `categories` VALUES (199, 20, 'Stuffed Animals, Beanbag', 1, 0, NULL);
INSERT INTO `categories` VALUES (200, 20, 'Toy Soldiers', 1, 0, NULL);
INSERT INTO `categories` VALUES (201, 20, 'TV, Character Toys', 1, 0, NULL);
INSERT INTO `categories` VALUES (202, 20, 'Vintage, Antique Toys', 1, 0, NULL);
INSERT INTO `categories` VALUES (203, 23, 'Antiquities', 1, 0, NULL);
INSERT INTO `categories` VALUES (204, 23, 'Architectual & Garden', 1, 0, NULL);
INSERT INTO `categories` VALUES (205, 23, 'Asian Antiques', 1, 0, NULL);
INSERT INTO `categories` VALUES (206, 23, 'Books, Manuscripts', 1, 0, NULL);
INSERT INTO `categories` VALUES (207, 23, 'Decorative Arts', 1, 0, NULL);
INSERT INTO `categories` VALUES (208, 23, 'Ethnographic', 1, 0, NULL);
INSERT INTO `categories` VALUES (209, 23, 'Furniture', 1, 0, NULL);
INSERT INTO `categories` VALUES (210, 23, 'Maps, Atlases', 1, 0, NULL);
INSERT INTO `categories` VALUES (211, 23, 'Maritime', 1, 0, NULL);
INSERT INTO `categories` VALUES (212, 23, 'Musical Intruments', 1, 0, NULL);
INSERT INTO `categories` VALUES (213, 23, 'Primitives', 1, 0, NULL);
INSERT INTO `categories` VALUES (214, 23, 'Rugs Carpets', 1, 0, NULL);
INSERT INTO `categories` VALUES (215, 24, 'Paintings', 1, 0, NULL);
INSERT INTO `categories` VALUES (216, 24, 'Drawings', 1, 0, NULL);
INSERT INTO `categories` VALUES (217, 24, 'Photographic', 1, 0, NULL);
INSERT INTO `categories` VALUES (218, 24, 'Sculptures', 1, 0, NULL);
INSERT INTO `categories` VALUES (219, 24, 'Other Art', 1, 0, NULL);
INSERT INTO `categories` VALUES (220, 25, 'First Editions', 1, 0, NULL);
INSERT INTO `categories` VALUES (221, 25, 'Antiquarian', 1, 0, NULL);
INSERT INTO `categories` VALUES (222, 26, 'CDs', 1, 0, NULL);
INSERT INTO `categories` VALUES (223, 26, 'Cassettes', 1, 0, NULL);
INSERT INTO `categories` VALUES (224, 26, 'Other', 1, 0, NULL);
INSERT INTO `categories` VALUES (225, 222, 'Children', 1, 0, NULL);
INSERT INTO `categories` VALUES (226, 222, 'Fiction', 1, 0, NULL);
INSERT INTO `categories` VALUES (227, 222, 'NonFiction', 1, 0, NULL);
INSERT INTO `categories` VALUES (228, 222, 'Other', 1, 0, NULL);
INSERT INTO `categories` VALUES (229, 223, 'Children', 1, 0, NULL);
INSERT INTO `categories` VALUES (230, 223, 'Fiction', 1, 0, NULL);
INSERT INTO `categories` VALUES (231, 223, 'NonFiction', 1, 0, NULL);
INSERT INTO `categories` VALUES (232, 223, 'Other', 1, 0, NULL);
INSERT INTO `categories` VALUES (233, 28, 'Action & Adventure', 1, 0, NULL);
INSERT INTO `categories` VALUES (234, 2, 'Software', 1, 0, NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `category_details`
-- 

CREATE TABLE `category_details` (
  `id` bigint(200) NOT NULL auto_increment,
  `cat_id` bigint(200) default '0',
  `template` tinyint(2) default '0',
  `field` tinyint(2) default '0',
  `storefront` tinyint(2) default '0',
  `pricing` tinyint(2) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `category_details`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `charges`
-- 

CREATE TABLE `charges` (
  `charge_id` int(11) NOT NULL auto_increment,
  `user_id` int(10) default NULL,
  `date` int(12) default NULL,
  `status` varchar(255) default NULL,
  `statusamount` decimal(10,2) default '0.00',
  `charge` decimal(10,2) default '0.00',
  `cause` text,
  PRIMARY KEY  (`charge_id`),
  UNIQUE KEY `acNum` (`charge_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- 
-- Dumping data for table `charges`
-- 

INSERT INTO `charges` VALUES (1, 1, 1200248889, NULL, '0.00', '0.00', '<b>Item Number:</b> 552208439<br><b>Listing Fee:</b> $0.00<br><br><b>Total:</b> $0.00');
INSERT INTO `charges` VALUES (2, 1, 1200321813, NULL, '0.00', '0.00', '<b>Item Number:</b> 977091800<br><b>Listing Fee:</b> $0.00<br><br><b>Total:</b> $0.00');
INSERT INTO `charges` VALUES (3, 1, 1200333600, NULL, '0.00', '0.00', '<b>Item Number:</b> 240203597<br><b>Listing Fee:</b> $0.00<br><br><b>Total:</b> $0.00');
INSERT INTO `charges` VALUES (4, 2, 1200672059, NULL, '0.00', '0.00', '<b>Item Number:</b> 604532037<br><b>Listing Fee:</b> $0.00<br><b>Image Upload</b> $0.25<br><br><b>FREE LISTING TOKEN USED: </b><br><a href="StartListing.php?removetoken=1">Click here to remove this token and add it back to your account</a><br><br><b>Total:</b> $0.00');
INSERT INTO `charges` VALUES (5, 2, 1200672165, NULL, '0.00', '0.00', '<b>Item Number:</b> 946112158<br><b>Listing Fee:</b> $0.00<br><b>Image Upload</b> $0.25<br><br><b>FREE LISTING TOKEN USED: </b><br><a href="StartListing.php?removetoken=1">Click here to remove this token and add it back to your account</a><br><br><b>Total:</b> $0.00');
INSERT INTO `charges` VALUES (6, 2, 1200672274, NULL, '0.00', '0.00', '<b>Item Number:</b> 555822266<br><b>Listing Fee:</b> $0.00<br><b>Image Upload</b> $0.25<br><br><b>FREE LISTING TOKEN USED: </b><br><a href="StartListing.php?removetoken=1">Click here to remove this token and add it back to your account</a><br><br><b>Total:</b> $0.00');
INSERT INTO `charges` VALUES (7, 2, 1200672364, NULL, '0.00', '0.00', '<b>Item Number:</b> 125752357<br><b>Listing Fee:</b> $0.00<br><b>Image Upload</b> $0.25<br><br><b>FREE LISTING TOKEN USED: </b><br><a href="StartListing.php?removetoken=1">Click here to remove this token and add it back to your account</a><br><br><b>Total:</b> $0.00');

-- --------------------------------------------------------

-- 
-- Table structure for table `coupons`
-- 

CREATE TABLE `coupons` (
  `id` int(10) NOT NULL auto_increment,
  `start` int(20) default NULL,
  `end` int(20) default NULL,
  `discount` decimal(10,2) default NULL,
  `code` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `coupons`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `custom_dropdown`
-- 

CREATE TABLE `custom_dropdown` (
  `id` bigint(200) NOT NULL auto_increment,
  `cat_id` bigint(200) NOT NULL default '0',
  `name` varchar(255) default NULL,
  `template_var` varchar(255) default NULL,
  `description` text,
  `searchable` tinyint(2) default '0',
  `style` tinyint(2) default '1',
  `per_row` tinyint(10) default '3',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `custom_dropdown`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `custom_dropdown_options`
-- 

CREATE TABLE `custom_dropdown_options` (
  `id` bigint(255) NOT NULL auto_increment,
  `field_id` bigint(200) NOT NULL default '0',
  `option` varchar(255) default NULL,
  `default` tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `custom_dropdown_options`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `custom_dropdown_values`
-- 

CREATE TABLE `custom_dropdown_values` (
  `id` bigint(200) NOT NULL auto_increment,
  `field_id` bigint(200) NOT NULL default '0',
  `option_id` bigint(200) NOT NULL default '0',
  `ItemNum` int(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `custom_dropdown_values`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `custom_textarea`
-- 

CREATE TABLE `custom_textarea` (
  `id` bigint(200) NOT NULL auto_increment,
  `cat_id` bigint(200) NOT NULL default '0',
  `name` varchar(255) default NULL,
  `template_var` varchar(255) default NULL,
  `description` text,
  `searchable` tinyint(2) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `custom_textarea`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `custom_textarea_values`
-- 

CREATE TABLE `custom_textarea_values` (
  `id` bigint(200) NOT NULL auto_increment,
  `field_id` bigint(200) NOT NULL default '0',
  `ItemNum` int(20) NOT NULL default '0',
  `value` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `custom_textarea_values`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `custom_textbox`
-- 

CREATE TABLE `custom_textbox` (
  `id` bigint(200) NOT NULL auto_increment,
  `cat_id` bigint(200) NOT NULL default '0',
  `name` varchar(255) default NULL,
  `template_var` varchar(255) default NULL,
  `description` text,
  `searchable` tinyint(2) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `custom_textbox`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `custom_textbox_values`
-- 

CREATE TABLE `custom_textbox_values` (
  `id` bigint(200) NOT NULL auto_increment,
  `field_id` bigint(200) NOT NULL default '0',
  `ItemNum` int(20) NOT NULL default '0',
  `value` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `custom_textbox_values`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `emails`
-- 

CREATE TABLE `emails` (
  `email_id` int(11) NOT NULL auto_increment,
  `item_id` int(11) default NULL,
  `to_user_id` int(11) default NULL,
  `from_user_id` int(11) default NULL,
  `emaildate` int(12) default NULL,
  `subject` varchar(100) default NULL,
  `message` text,
  `been_read` tinyint(3) default '0',
  PRIMARY KEY  (`email_id`),
  UNIQUE KEY `offer_id` (`email_id`),
  KEY `to_seller_id` (`to_user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- 
-- Dumping data for table `emails`
-- 

INSERT INTO `emails` VALUES (7, NULL, 2, 1000000000, 1200671619, 'Welcome to MALWARE MARKET!', 'Hello Demo,\r\n\r\nWe are glad you decided to join us! Here at MALWARE MARKET, you can effectivly buy and sell your items while in an enjoyable environment. We hope you have fun as member of our community. \r\n\r\nThank you,\r\nMALWARE MARKET Team', 0);
INSERT INTO `emails` VALUES (8, NULL, 2, 1000000000, 1200672059, 'New Listing  #604532037 created on January 18, 2008, 10:00 am', 'Hello userdemo,\r\n\r\nThank you for submitting your item! Below are the details of your new listing. You can preview your listing by clicking <a href=http://lab.demonstrationserver.com/classifieds/ViewItem.php?ItemNum=604532037>here</a>\r\n\r\nDetails\r\n--------------------------------------------------\r\nItem Number: 604532037\r\nTitle: ITechBids Gold Edition\r\nStarted: January 18, 2008, 10:00 am\r\nDays to Run: 3\r\nCloses on: January 21, 2008, 10:00 am\r\nAsking Price: 125.00   Make Offer\r\nQuantity: 1\r\nCity/Town: Cal\r\nState/Province: LA \r\n\r\nCharges\r\n----------------------------------------------------\r\nBold: Not Selected\r\nHighlighted: Not Selected\r\nCategory Featured: Not Selected\r\nGallery Listing: Not Selected\r\nImage Preview: Not Selected\r\nHome Page Featured: Not Selected\r\nImage Slide Show: Not Selected\r\nCounter: Not Selected\r\nImage One: 0.25\r\nImage Two: No Image Uploaded\r\nImage Three: No Image Uploaded\r\nImage Four: No Image Uploaded\r\nImage Five: No Image Uploaded\r\n\r\n\r\nThank you,\r\nMALWARE MARKET Team', 0);
INSERT INTO `emails` VALUES (9, NULL, 2, 1000000000, 1200672165, 'New Listing  #946112158 created on January 18, 2008, 10:02 am', 'Hello userdemo,\r\n\r\nThank you for submitting your item! Below are the details of your new listing. You can preview your listing by clicking <a href=http://lab.demonstrationserver.com/classifieds/ViewItem.php?ItemNum=946112158>here</a>\r\n\r\nDetails\r\n--------------------------------------------------\r\nItem Number: 946112158\r\nTitle: MALWARE MARKET-Listing\r\nStarted: January 18, 2008, 10:02 am\r\nDays to Run: 14\r\nCloses on: February 1, 2008, 10:02 am\r\nAsking Price: 100.00   Make Offer\r\nQuantity: 1\r\nCity/Town: Cal\r\nState/Province: LA \r\n\r\nCharges\r\n----------------------------------------------------\r\nBold: Not Selected\r\nHighlighted: Not Selected\r\nCategory Featured: Not Selected\r\nGallery Listing: Not Selected\r\nImage Preview: Not Selected\r\nHome Page Featured: Not Selected\r\nImage Slide Show: Not Selected\r\nCounter: Not Selected\r\nImage One: 0.25\r\nImage Two: No Image Uploaded\r\nImage Three: No Image Uploaded\r\nImage Four: No Image Uploaded\r\nImage Five: No Image Uploaded\r\n\r\n\r\nThank you,\r\nMALWARE MARKET', 0);
INSERT INTO `emails` VALUES (10, NULL, 2, 1000000000, 1200672274, 'New Listing  #555822266 created on January 18, 2008, 10:04 am', 'Hello userdemo,\r\n\r\nThank you for submitting your item! Below are the details of your new listing. You can preview your listing by clicking <a href=http://lab.demonstrationserver.com/classifieds/ViewItem.php?ItemNum=555822266>here</a>\r\n\r\nDetails\r\n--------------------------------------------------\r\nItem Number: 555822266\r\nTitle: MALWARE MARKET\r\nStarted: January 18, 2008, 10:04 am\r\nDays to Run: 14\r\nCloses on: February 1, 2008, 10:04 am\r\nAsking Price: 125.00   Make Offer\r\nQuantity: 1\r\nCity/Town: Cal\r\nState/Province: LA \r\n\r\nCharges\r\n----------------------------------------------------\r\nBold: Not Selected\r\nHighlighted: Not Selected\r\nCategory Featured: Not Selected\r\nGallery Listing: Not Selected\r\nImage Preview: Not Selected\r\nHome Page Featured: Not Selected\r\nImage Slide Show: Not Selected\r\nCounter: Not Selected\r\nImage One: 0.25\r\nImage Two: No Image Uploaded\r\nImage Three: No Image Uploaded\r\nImage Four: No Image Uploaded\r\nImage Five: No Image Uploaded\r\n\r\n\r\nThank you,\r\nMALWARE MARKET
 Team', 0);
INSERT INTO `emails` VALUES (11, NULL, 2, 1000000000, 1200672364, 'New Listing  #125752357 created on January 18, 2008, 10:06 am', 'Hello userdemo,\r\n\r\nThank you for submitting your item! Below are the details of your new listing. You can preview your listing by clicking <a href=http://lab.demonstrationserver.com/classifieds/ViewItem.php?ItemNum=125752357>here</a>\r\n\r\nDetails\r\n--------------------------------------------------\r\nItem Number: 125752357\r\nTitle: ITechEstate\r\nStarted: January 18, 2008, 10:06 am\r\nDays to Run: 14\r\nCloses on: February 1, 2008, 10:06 am\r\nAsking Price: 100.00   Make Offer\r\nQuantity: 1\r\nCity/Town: Cal\r\nState/Province: LA \r\n\r\nCharges\r\n----------------------------------------------------\r\nBold: Not Selected\r\nHighlighted: Not Selected\r\nCategory Featured: Not Selected\r\nGallery Listing: Not Selected\r\nImage Preview: Not Selected\r\nHome Page Featured: Not Selected\r\nImage Slide Show: Not Selected\r\nCounter: Not Selected\r\nImage One: 0.25\r\nImage Two: No Image Uploaded\r\nImage Three: No Image Uploaded\r\nImage Four: No Image Uploaded\r\nImage Five: No Image Uploaded\r\n\r\n\r\nThank you,\r\nMALWARE MARKET
 Team', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `feedback`
-- 

CREATE TABLE `feedback` (
  `id` int(20) NOT NULL auto_increment,
  `purchase_id` int(20) default NULL,
  `ItemNum` int(20) default NULL,
  `being_rated` int(20) default NULL,
  `doing_rating` int(20) default NULL,
  `rating` tinyint(2) default NULL,
  `comment` varchar(100) default NULL,
  `buysell` tinyint(2) default NULL,
  `date` int(20) NOT NULL default '0',
  `counter` int(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `feedback`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `forgottenpasswords`
-- 

CREATE TABLE `forgottenpasswords` (
  `forgot_id` int(3) NOT NULL auto_increment,
  `user_login` varchar(255) default NULL,
  `user_email` varchar(255) default NULL,
  `ip_request` varchar(20) default NULL,
  `date` int(14) default NULL,
  UNIQUE KEY `forgot_id` (`forgot_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `forgottenpasswords`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `groups`
-- 

CREATE TABLE `groups` (
  `id` bigint(200) NOT NULL auto_increment,
  `title` varchar(255) default NULL,
  `description` text,
  `listing_discount` decimal(4,3) default '0.000',
  `tokens` int(20) default '0',
  `req_approval` tinyint(2) default '0',
  `fe_admin` tinyint(2) default '0',
  `date_created` int(20) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `id` (`id`),
  KEY `listing_discount` (`listing_discount`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `groups`
-- 

INSERT INTO `groups` VALUES (1, 'Public', 'All users should be members of the public group, as well as all categories that any registed member is allowed to post items in.  This is a REQUIRED group so Please Do Not Delete It, doing so will have adverse effects on your site!', '0.000', 0, 0, 0, 1083122480);
INSERT INTO `groups` VALUES (2, 'SuperUser', 'This is a group for admins or highlevel users.  By default this user can list items in any category and receives a 100% discount (free listings).  Please Do Not Delete This Group.', '1.000', 0, 0, 0, 1083122480);

-- --------------------------------------------------------

-- 
-- Table structure for table `groups_categories`
-- 

CREATE TABLE `groups_categories` (
  `id` bigint(255) NOT NULL auto_increment,
  `cat_id` bigint(200) NOT NULL default '0',
  `group_id` bigint(200) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- 
-- Dumping data for table `groups_categories`
-- 

INSERT INTO `groups_categories` VALUES (1, 2, 1);
INSERT INTO `groups_categories` VALUES (2, 3, 1);
INSERT INTO `groups_categories` VALUES (3, 6, 1);
INSERT INTO `groups_categories` VALUES (4, 7, 1);
INSERT INTO `groups_categories` VALUES (5, 8, 1);
INSERT INTO `groups_categories` VALUES (6, 9, 1);
INSERT INTO `groups_categories` VALUES (7, 10, 1);
INSERT INTO `groups_categories` VALUES (8, 11, 1);
INSERT INTO `groups_categories` VALUES (9, 12, 1);
INSERT INTO `groups_categories` VALUES (10, 13, 1);
INSERT INTO `groups_categories` VALUES (11, 14, 1);
INSERT INTO `groups_categories` VALUES (12, 15, 1);
INSERT INTO `groups_categories` VALUES (13, 16, 1);
INSERT INTO `groups_categories` VALUES (14, 17, 1);
INSERT INTO `groups_categories` VALUES (15, 18, 1);
INSERT INTO `groups_categories` VALUES (16, 19, 1);
INSERT INTO `groups_categories` VALUES (17, 20, 1);
INSERT INTO `groups_categories` VALUES (18, 21, 1);
INSERT INTO `groups_categories` VALUES (19, 55, 1);
INSERT INTO `groups_categories` VALUES (20, 134, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `groups_users`
-- 

CREATE TABLE `groups_users` (
  `id` bigint(255) NOT NULL auto_increment,
  `user_id` bigint(200) NOT NULL default '0',
  `group_id` bigint(200) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `id` (`id`),
  KEY `user_id` (`user_id`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `groups_users`
-- 

INSERT INTO `groups_users` VALUES (3, 1, 1);
INSERT INTO `groups_users` VALUES (4, 2, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `items`
-- 

CREATE TABLE `items` (
  `itemID` int(11) NOT NULL auto_increment,
  `ItemNum` bigint(20) NOT NULL default '0',
  `category` int(10) unsigned default NULL,
  `sub_category` int(10) unsigned default NULL,
  `user_id` int(10) unsigned default NULL,
  `title` varchar(255) default NULL,
  `status` int(11) default NULL,
  `end_reason` varchar(255) default NULL,
  `started` int(12) default NULL,
  `close` int(12) default NULL,
  `closes` int(12) default NULL,
  `bold` tinyint(4) default '0',
  `background` tinyint(4) default '0',
  `cat_featured` tinyint(4) default '0',
  `home_featured` tinyint(4) default '0',
  `gallery_featured` tinyint(4) default '0',
  `image_preview` tinyint(4) default '0',
  `slide_show` tinyint(4) default '0',
  `counter` tinyint(4) default NULL,
  `make_offer` tinyint(3) default '0',
  `image_one` varchar(255) default NULL,
  `image_two` varchar(255) default NULL,
  `image_three` varchar(255) default NULL,
  `image_four` varchar(255) default NULL,
  `image_five` varchar(255) default NULL,
  `asking_price` decimal(10,2) default NULL,
  `quantity` int(11) default '1',
  `city_town` varchar(255) default NULL,
  `state_province` varchar(100) default NULL,
  `country` int(11) default NULL,
  `description` text,
  `added_description` text,
  `dateadded` varchar(255) default NULL,
  `charges_incurred` text,
  `totalcharges` decimal(10,2) default NULL,
  `hits` int(11) default '0',
  `item_paypal` varchar(100) default NULL,
  `ship1` varchar(200) default NULL,
  `shipfee1` decimal(10,2) default NULL,
  `ship2` varchar(200) default NULL,
  `shipfee2` decimal(10,2) default NULL,
  `ship3` varchar(200) default NULL,
  `shipfee3` decimal(10,2) default NULL,
  `ship4` varchar(200) default NULL,
  `shipfee4` decimal(10,2) default NULL,
  `ship5` varchar(200) default NULL,
  `shipfee5` decimal(10,2) default NULL,
  `acct_credit_used` decimal(10,2) default NULL,
  `amt_due` decimal(10,2) default NULL,
  `notified` bigint(20) default NULL,
  PRIMARY KEY  (`itemID`),
  UNIQUE KEY `PRI` (`itemID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- 
-- Dumping data for table `items`
-- 

INSERT INTO `items` VALUES (6, 946112158, 87, NULL, 2, 'ITech-Listing', 1, NULL, 1200672165, 5, 1201881765, 0, 0, 0, 1, 0, 1, 0, 0, 1, 'uploads/18Jan2008_copy.jpg', NULL, NULL, NULL, NULL, '100.00', 1, 'Cal', 'LA', 1, 'ITechListing Ver 2.0 is a premier product that allows you build a powerful Web-Indexing website such as yahoo & dmoz. ITechListing is the leader in directory services. Insertion of web directory services also helps you secure better search engine positions for your website.\r\n\r\nEnjoy higher search ranking and achieve your goals faster with ITechListing. ITechListing v2.0 is built around PHP & MySQL as backend. Available only at USD100/ domain, ITechListing v2.0 is the best value for your money. ', NULL, NULL, NULL, NULL, 0, 'admin@itechscripts.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', '0.00', NULL);
INSERT INTO `items` VALUES (7, 555822266, 26, NULL, 2, 'MALWARE MARKET', 1, NULL, 1200672274, 5, 1201881874, 0, 0, 0, 1, 1, 1, 0, 0, 1, 'uploads/18Jan2008_copy1.jpg', NULL, NULL, NULL, NULL, '125.00', 1, 'Cal', 'LA', 1, 'ITechListing Ver 2.0 is a premier product that allows you build a powerful Web-Indexing website such as yahoo & dmoz. ITechListing is the leader in directory services. Insertion of web directory services also helps you secure better search engine positions for your website.\r\n\r\nEnjoy higher search ranking and achieve your goals faster with ITechListing. ITechListing v2.0 is built around PHP & MySQL as backend. Available only at USD100/ domain, ITechListing v2.0 is the best value for your money. ', NULL, NULL, NULL, NULL, 14, 'admin@MALWAREMARKET.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', '0.00', NULL);
INSERT INTO `items` VALUES (5, 604532037, 99, NULL, 2, 'ITechBids Gold Edition', 1, NULL, 1200672059, 1, 1200931259, 0, 0, 0, 1, 1, 1, 0, 0, 1, 'uploads/18Jan2008.jpg', NULL, NULL, NULL, NULL, '125.00', 1, 'Cal', 'LA', 1, 'ITechBids Ver 3.0 (Gold Release) is a fully functional auction software product and website! With comprehensive admin controls, site owners  require nothing more to ask for. ITechBids is a complete web application coded using PHP with MYSQL as backend.\r\nFull developer API allows endless possibilities to integrate add-on features. Improved Control Panel helps manage the script with ease and precision. Dutch Auction, User Store and many more featured has been added in the recent release. Just avail yourself the best in auction.', NULL, NULL, NULL, NULL, 25, 'admin@MALWAREMARKET.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', '0.00', NULL);
INSERT INTO `items` VALUES (8, 125752357, 108, NULL, 2, 'ITechEstate', 1, NULL, 1200672364, 5, 1201881964, 0, 0, 0, 1, 0, 1, 0, 0, 1, 'uploads/18Jan2008_copy2.jpg', NULL, NULL, NULL, NULL, '100.00', 1, 'Cal', 'LA', 1, 'ITechBids Ver 3.0 (Gold Release) is a fully functional auction software product and website! With comprehensive admin controls, site owners  require nothing more to ask for. ITechBids is a complete web application coded using PHP with MYSQL as backend.\r\nFull developer API allows endless possibilities to integrate add-on features. Improved Control Panel helps manage the script with ease and precision. Dutch Auction, User Store and many more featured has been added in the recent release. Just avail yourself the best in auction.', NULL, NULL, NULL, NULL, 19, 'admin@itechscripts.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', '0.00', NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `items_preview`
-- 

CREATE TABLE `items_preview` (
  `itemID` int(11) NOT NULL auto_increment,
  `ItemNum` bigint(20) NOT NULL default '0',
  `category` int(10) unsigned default NULL,
  `sub_category` int(10) unsigned default NULL,
  `user_id` int(10) unsigned default NULL,
  `title` varchar(255) default NULL,
  `status` int(11) default '0',
  `end_reason` varchar(255) default NULL,
  `started` int(12) default NULL,
  `close` int(12) default NULL,
  `closes` int(12) default NULL,
  `bold` tinyint(4) default '0',
  `background` tinyint(4) default '0',
  `cat_featured` tinyint(4) default '0',
  `home_featured` tinyint(4) default '0',
  `gallery_featured` tinyint(4) default '0',
  `image_preview` tinyint(4) default '0',
  `slide_show` tinyint(4) default '0',
  `counter` tinyint(4) default NULL,
  `make_offer` tinyint(3) default '0',
  `image_one` varchar(255) default NULL,
  `image_two` varchar(255) default NULL,
  `image_three` varchar(255) default NULL,
  `image_four` varchar(255) default NULL,
  `image_five` varchar(255) default NULL,
  `asking_price` decimal(10,2) default NULL,
  `quantity` int(11) default '1',
  `city_town` varchar(255) default NULL,
  `state_province` varchar(100) default NULL,
  `country` int(11) default NULL,
  `description` text,
  `added_description` text,
  `dateadded` varchar(255) default NULL,
  `charges_incurred` text,
  `totalcharges` decimal(10,2) default NULL,
  `hits` int(11) default '0',
  `item_paypal` varchar(100) default NULL,
  `ship1` varchar(200) default NULL,
  `shipfee1` decimal(10,2) default NULL,
  `ship2` varchar(200) default NULL,
  `shipfee2` decimal(10,2) default NULL,
  `ship3` varchar(200) default NULL,
  `shipfee3` decimal(10,2) default NULL,
  `ship4` varchar(200) default NULL,
  `shipfee4` decimal(10,2) default NULL,
  `ship5` varchar(200) default NULL,
  `shipfee5` decimal(10,2) default NULL,
  `acct_credit_used` decimal(10,2) default NULL,
  `amt_due` decimal(10,2) default NULL,
  `notified` bigint(20) default NULL,
  PRIMARY KEY  (`itemID`),
  UNIQUE KEY `PRI` (`itemID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `items_preview`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `listing_index`
-- 

CREATE TABLE `listing_index` (
  `id` bigint(255) NOT NULL auto_increment,
  `ItemNum` int(20) default NULL,
  `value` varchar(60) default NULL,
  `pos` int(20) default NULL,
  `field_num` int(20) default NULL,
  `field_id` int(20) default NULL,
  `field_value` int(20) default NULL,
  `field_type` varchar(50) default NULL,

  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=481 ;

-- 
-- Dumping data for table `listing_index`
-- 

INSERT INTO `listing_index` VALUES (230, 946112158, 'Ver', 4, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (229, 946112158, 'ITechListing', 3, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (228, 946112158, 'Listing', 2, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (227, 946112158, 'ITech', 1, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (226, 604532037, 'LA', 89, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (225, 604532037, 'Cal', 88, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (224, 604532037, 'auction', 87, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (223, 604532037, 'in', 86, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (222, 604532037, 'best', 85, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (221, 604532037, 'the', 84, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (220, 604532037, 'yourself', 83, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (219, 604532037, 'avail', 82, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (218, 604532037, 'Just', 81, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (217, 604532037, 'release', 80, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (216, 604532037, 'recent', 79, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (215, 604532037, 'the', 78, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (214, 604532037, 'in', 77, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (213, 604532037, 'added', 76, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (212, 604532037, 'been', 75, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (211, 604532037, 'has', 74, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (210, 604532037, 'featured', 73, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (209, 604532037, 'more', 72, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (208, 604532037, 'many', 71, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (207, 604532037, 'and', 70, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (206, 604532037, 'Store', 69, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (205, 604532037, 'User', 68, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (204, 604532037, 'Auction', 67, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (203, 604532037, 'Dutch', 66, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (202, 604532037, 'precision', 65, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (201, 604532037, 'and', 64, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (200, 604532037, 'ease', 63, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (199, 604532037, 'with', 62, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (198, 604532037, 'script', 61, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (197, 604532037, 'the', 60, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (196, 604532037, 'manage', 59, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (195, 604532037, 'helps', 58, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (194, 604532037, 'Panel', 57, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (193, 604532037, 'Control', 56, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (192, 604532037, 'Improved', 55, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (191, 604532037, 'features', 54, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (190, 604532037, 'on', 53, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (189, 604532037, 'add', 52, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (188, 604532037, 'integrate', 51, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (187, 604532037, 'to', 50, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (186, 604532037, 'possibilities', 49, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (185, 604532037, 'endless', 48, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (184, 604532037, 'allows', 47, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (183, 604532037, 'API', 46, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (182, 604532037, 'developer', 45, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (181, 604532037, 'Full', 44, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (180, 604532037, 'backend', 43, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (179, 604532037, 'as', 42, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (178, 604532037, 'MYSQL', 41, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (177, 604532037, 'with', 40, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (176, 604532037, 'PHP', 39, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (175, 604532037, 'using', 38, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (174, 604532037, 'coded', 37, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (173, 604532037, 'application', 36, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (172, 604532037, 'web', 35, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (171, 604532037, 'complete', 34, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (170, 604532037, 'a', 33, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (169, 604532037, 'is', 32, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (168, 604532037, 'ITechBids', 31, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (167, 604532037, 'for', 30, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (166, 604532037, 'ask', 29, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (165, 604532037, 'to', 28, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (164, 604532037, 'more', 27, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (163, 604532037, 'nothing', 26, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (162, 604532037, 'require', 25, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (161, 604532037, 'owners', 24, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (160, 604532037, 'site', 23, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (159, 604532037, 'controls', 22, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (158, 604532037, 'admin', 21, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (157, 604532037, 'comprehensive', 20, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (156, 604532037, 'With', 19, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (155, 604532037, 'website', 18, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (154, 604532037, 'and', 17, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (153, 604532037, 'product', 16, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (152, 604532037, 'software', 15, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (151, 604532037, 'auction', 14, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (150, 604532037, 'functional', 13, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (149, 604532037, 'fully', 12, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (148, 604532037, 'a', 11, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (147, 604532037, 'is', 10, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (146, 604532037, 'Release', 9, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (145, 604532037, 'Gold', 8, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (144, 604532037, '0', 7, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (143, 604532037, '3', 6, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (142, 604532037, 'Ver', 5, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (141, 604532037, 'ITechBids', 4, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (140, 604532037, 'Edition', 3, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (139, 604532037, 'Gold', 2, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (138, 604532037, 'ITechBids', 1, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (231, 946112158, '2', 5, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (232, 946112158, '0', 6, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (233, 946112158, 'is', 7, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (234, 946112158, 'a', 8, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (235, 946112158, 'premier', 9, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (236, 946112158, 'product', 10, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (237, 946112158, 'that', 11, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (238, 946112158, 'allows', 12, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (239, 946112158, 'you', 13, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (240, 946112158, 'build', 14, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (241, 946112158, 'a', 15, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (242, 946112158, 'powerful', 16, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (243, 946112158, 'Web', 17, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (244, 946112158, 'Indexing', 18, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (245, 946112158, 'website', 19, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (246, 946112158, 'such', 20, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (247, 946112158, 'as', 21, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (248, 946112158, 'yahoo', 22, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (249, 946112158, 'dmoz', 23, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (250, 946112158, 'ITechListing', 24, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (251, 946112158, 'is', 25, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (252, 946112158, 'the', 26, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (253, 946112158, 'leader', 27, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (254, 946112158, 'in', 28, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (255, 946112158, 'directory', 29, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (256, 946112158, 'services', 30, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (257, 946112158, 'Insertion', 31, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (258, 946112158, 'of', 32, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (259, 946112158, 'web', 33, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (260, 946112158, 'directory', 34, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (261, 946112158, 'services', 35, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (262, 946112158, 'also', 36, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (263, 946112158, 'helps', 37, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (264, 946112158, 'you', 38, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (265, 946112158, 'secure', 39, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (266, 946112158, 'better', 40, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (267, 946112158, 'search', 41, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (268, 946112158, 'engine', 42, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (269, 946112158, 'positions', 43, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (270, 946112158, 'for', 44, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (271, 946112158, 'your', 45, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (272, 946112158, 'website', 46, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (273, 946112158, 'Enjoy', 47, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (274, 946112158, 'higher', 48, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (275, 946112158, 'search', 49, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (276, 946112158, 'ranking', 50, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (277, 946112158, 'and', 51, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (278, 946112158, 'achieve', 52, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (279, 946112158, 'your', 53, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (280, 946112158, 'goals', 54, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (281, 946112158, 'faster', 55, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (282, 946112158, 'with', 56, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (283, 946112158, 'ITechListing', 57, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (284, 946112158, 'ITechListing', 58, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (285, 946112158, 'v2', 59, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (286, 946112158, '0', 60, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (287, 946112158, 'is', 61, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (288, 946112158, 'built', 62, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (289, 946112158, 'around', 63, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (290, 946112158, 'PHP', 64, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (291, 946112158, 'MySQL', 65, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (292, 946112158, 'as', 66, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (293, 946112158, 'backend', 67, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (294, 946112158, 'Available', 68, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (295, 946112158, 'only', 69, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (296, 946112158, 'at', 70, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (297, 946112158, 'USD100', 71, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (298, 946112158, 'domain', 72, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (299, 946112158, 'ITechListing', 73, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (300, 946112158, 'v2', 74, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (301, 946112158, '0', 75, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (302, 946112158, 'is', 76, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (303, 946112158, 'the', 77, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (304, 946112158, 'best', 78, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (305, 946112158, 'value', 79, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (306, 946112158, 'for', 80, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (307, 946112158, 'your', 81, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (308, 946112158, 'money', 82, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (309, 946112158, 'Cal', 83, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (310, 946112158, 'LA', 84, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (311, 555822266, 'iTechClassifieds', 1, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (312, 555822266, 'ITechListing', 2, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (313, 555822266, 'Ver', 3, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (314, 555822266, '2', 4, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (315, 555822266, '0', 5, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (316, 555822266, 'is', 6, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (317, 555822266, 'a', 7, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (318, 555822266, 'premier', 8, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (319, 555822266, 'product', 9, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (320, 555822266, 'that', 10, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (321, 555822266, 'allows', 11, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (322, 555822266, 'you', 12, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (323, 555822266, 'build', 13, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (324, 555822266, 'a', 14, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (325, 555822266, 'powerful', 15, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (326, 555822266, 'Web', 16, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (327, 555822266, 'Indexing', 17, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (328, 555822266, 'website', 18, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (329, 555822266, 'such', 19, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (330, 555822266, 'as', 20, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (331, 555822266, 'yahoo', 21, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (332, 555822266, 'dmoz', 22, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (333, 555822266, 'ITechListing', 23, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (334, 555822266, 'is', 24, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (335, 555822266, 'the', 25, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (336, 555822266, 'leader', 26, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (337, 555822266, 'in', 27, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (338, 555822266, 'directory', 28, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (339, 555822266, 'services', 29, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (340, 555822266, 'Insertion', 30, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (341, 555822266, 'of', 31, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (342, 555822266, 'web', 32, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (343, 555822266, 'directory', 33, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (344, 555822266, 'services', 34, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (345, 555822266, 'also', 35, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (346, 555822266, 'helps', 36, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (347, 555822266, 'you', 37, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (348, 555822266, 'secure', 38, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (349, 555822266, 'better', 39, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (350, 555822266, 'search', 40, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (351, 555822266, 'engine', 41, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (352, 555822266, 'positions', 42, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (353, 555822266, 'for', 43, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (354, 555822266, 'your', 44, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (355, 555822266, 'website', 45, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (356, 555822266, 'Enjoy', 46, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (357, 555822266, 'higher', 47, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (358, 555822266, 'search', 48, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (359, 555822266, 'ranking', 49, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (360, 555822266, 'and', 50, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (361, 555822266, 'achieve', 51, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (362, 555822266, 'your', 52, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (363, 555822266, 'goals', 53, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (364, 555822266, 'faster', 54, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (365, 555822266, 'with', 55, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (366, 555822266, 'ITechListing', 56, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (367, 555822266, 'ITechListing', 57, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (368, 555822266, 'v2', 58, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (369, 555822266, '0', 59, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (370, 555822266, 'is', 60, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (371, 555822266, 'built', 61, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (372, 555822266, 'around', 62, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (373, 555822266, 'PHP', 63, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (374, 555822266, 'MySQL', 64, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (375, 555822266, 'as', 65, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (376, 555822266, 'backend', 66, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (377, 555822266, 'Available', 67, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (378, 555822266, 'only', 68, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (379, 555822266, 'at', 69, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (380, 555822266, 'USD100', 70, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (381, 555822266, 'domain', 71, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (382, 555822266, 'ITechListing', 72, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (383, 555822266, 'v2', 73, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (384, 555822266, '0', 74, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (385, 555822266, 'is', 75, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (386, 555822266, 'the', 76, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (387, 555822266, 'best', 77, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (388, 555822266, 'value', 78, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (389, 555822266, 'for', 79, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (390, 555822266, 'your', 80, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (391, 555822266, 'money', 81, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (392, 555822266, 'Cal', 82, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (393, 555822266, 'LA', 83, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (394, 125752357, 'ITechEstate', 1, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (395, 125752357, 'ITechBids', 2, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (396, 125752357, 'Ver', 3, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (397, 125752357, '3', 4, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (398, 125752357, '0', 5, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (399, 125752357, 'Gold', 6, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (400, 125752357, 'Release', 7, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (401, 125752357, 'is', 8, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (402, 125752357, 'a', 9, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (403, 125752357, 'fully', 10, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (404, 125752357, 'functional', 11, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (405, 125752357, 'auction', 12, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (406, 125752357, 'software', 13, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (407, 125752357, 'product', 14, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (408, 125752357, 'and', 15, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (409, 125752357, 'website', 16, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (410, 125752357, 'With', 17, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (411, 125752357, 'comprehensive', 18, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (412, 125752357, 'admin', 19, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (413, 125752357, 'controls', 20, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (414, 125752357, 'site', 21, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (415, 125752357, 'owners', 22, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (416, 125752357, 'require', 23, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (417, 125752357, 'nothing', 24, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (418, 125752357, 'more', 25, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (419, 125752357, 'to', 26, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (420, 125752357, 'ask', 27, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (421, 125752357, 'for', 28, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (422, 125752357, 'ITechBids', 29, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (423, 125752357, 'is', 30, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (424, 125752357, 'a', 31, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (425, 125752357, 'complete', 32, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (426, 125752357, 'web', 33, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (427, 125752357, 'application', 34, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (428, 125752357, 'coded', 35, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (429, 125752357, 'using', 36, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (430, 125752357, 'PHP', 37, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (431, 125752357, 'with', 38, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (432, 125752357, 'MYSQL', 39, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (433, 125752357, 'as', 40, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (434, 125752357, 'backend', 41, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (435, 125752357, 'Full', 42, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (436, 125752357, 'developer', 43, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (437, 125752357, 'API', 44, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (438, 125752357, 'allows', 45, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (439, 125752357, 'endless', 46, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (440, 125752357, 'possibilities', 47, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (441, 125752357, 'to', 48, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (442, 125752357, 'integrate', 49, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (443, 125752357, 'add', 50, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (444, 125752357, 'on', 51, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (445, 125752357, 'features', 52, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (446, 125752357, 'Improved', 53, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (447, 125752357, 'Control', 54, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (448, 125752357, 'Panel', 55, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (449, 125752357, 'helps', 56, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (450, 125752357, 'manage', 57, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (451, 125752357, 'the', 58, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (452, 125752357, 'script', 59, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (453, 125752357, 'with', 60, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (454, 125752357, 'ease', 61, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (455, 125752357, 'and', 62, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (456, 125752357, 'precision', 63, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (457, 125752357, 'Dutch', 64, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (458, 125752357, 'Auction', 65, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (459, 125752357, 'User', 66, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (460, 125752357, 'Store', 67, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (461, 125752357, 'and', 68, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (462, 125752357, 'many', 69, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (463, 125752357, 'more', 70, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (464, 125752357, 'featured', 71, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (465, 125752357, 'has', 72, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (466, 125752357, 'been', 73, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (467, 125752357, 'added', 74, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (468, 125752357, 'in', 75, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (469, 125752357, 'the', 76, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (470, 125752357, 'recent', 77, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (471, 125752357, 'release', 78, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (472, 125752357, 'Just', 79, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (473, 125752357, 'avail', 80, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (474, 125752357, 'yourself', 81, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (475, 125752357, 'the', 82, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (476, 125752357, 'best', 83, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (477, 125752357, 'in', 84, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (478, 125752357, 'auction', 85, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (479, 125752357, 'Cal', 86, NULL, NULL, NULL, 'main');
INSERT INTO `listing_index` VALUES (480, 125752357, 'LA', 87, NULL, NULL, NULL, 'main');

-- --------------------------------------------------------

-- 
-- Table structure for table `lookup_ages`
-- 

CREATE TABLE `lookup_ages` (
  `age_id` int(11) NOT NULL default '0',
  `age_desc` varchar(15) default NULL,
  PRIMARY KEY  (`age_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `lookup_ages`
-- 

INSERT INTO `lookup_ages` VALUES (1, 'less than 13');
INSERT INTO `lookup_ages` VALUES (2, '13-18');
INSERT INTO `lookup_ages` VALUES (3, '18-24');
INSERT INTO `lookup_ages` VALUES (4, '25-34');
INSERT INTO `lookup_ages` VALUES (5, '35-50');
INSERT INTO `lookup_ages` VALUES (6, '51-65');
INSERT INTO `lookup_ages` VALUES (7, 'over 65');
INSERT INTO `lookup_ages` VALUES (0, 'Unspecified');

-- --------------------------------------------------------

-- 
-- Table structure for table `lookup_countries`
-- 

CREATE TABLE `lookup_countries` (
  `country_id` int(11) NOT NULL auto_increment,
  `country_desc` varchar(40) default NULL,
  PRIMARY KEY  (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=220 ;

-- 
-- Dumping data for table `lookup_countries`
-- 

INSERT INTO `lookup_countries` VALUES (1, 'United States');
INSERT INTO `lookup_countries` VALUES (4, 'Canada');
INSERT INTO `lookup_countries` VALUES (5, 'United Kingdom');
INSERT INTO `lookup_countries` VALUES (6, 'Afghanistan');
INSERT INTO `lookup_countries` VALUES (7, 'Albania');
INSERT INTO `lookup_countries` VALUES (8, 'Algeria');
INSERT INTO `lookup_countries` VALUES (9, 'American Samoa');
INSERT INTO `lookup_countries` VALUES (10, 'Andorra');
INSERT INTO `lookup_countries` VALUES (11, 'Angola');
INSERT INTO `lookup_countries` VALUES (12, 'Anguilla');
INSERT INTO `lookup_countries` VALUES (13, 'Antigua and Barbuda');
INSERT INTO `lookup_countries` VALUES (14, 'Argentina');
INSERT INTO `lookup_countries` VALUES (15, 'Armenia');
INSERT INTO `lookup_countries` VALUES (16, 'Aruba');
INSERT INTO `lookup_countries` VALUES (17, 'Australia');
INSERT INTO `lookup_countries` VALUES (18, 'Austria');
INSERT INTO `lookup_countries` VALUES (19, 'Azerbaijan Republic');
INSERT INTO `lookup_countries` VALUES (20, 'Bahamas');
INSERT INTO `lookup_countries` VALUES (21, 'Bahrain');
INSERT INTO `lookup_countries` VALUES (22, 'Bangladesh');
INSERT INTO `lookup_countries` VALUES (23, 'Barbados');
INSERT INTO `lookup_countries` VALUES (24, 'Belarus');
INSERT INTO `lookup_countries` VALUES (25, 'Belgium');
INSERT INTO `lookup_countries` VALUES (26, 'Belize');
INSERT INTO `lookup_countries` VALUES (27, 'Benin');
INSERT INTO `lookup_countries` VALUES (28, 'Bermuda');
INSERT INTO `lookup_countries` VALUES (29, 'Bhutan');
INSERT INTO `lookup_countries` VALUES (30, 'Bolivia');
INSERT INTO `lookup_countries` VALUES (31, 'Bosnia and Herzegovina');
INSERT INTO `lookup_countries` VALUES (32, 'Botswana');
INSERT INTO `lookup_countries` VALUES (33, 'Brazil');
INSERT INTO `lookup_countries` VALUES (34, 'British Virgin Islands');
INSERT INTO `lookup_countries` VALUES (35, 'Brunei Darussalam');
INSERT INTO `lookup_countries` VALUES (36, 'Bulgaria');
INSERT INTO `lookup_countries` VALUES (37, 'Burkina Faso');
INSERT INTO `lookup_countries` VALUES (38, 'Burma');
INSERT INTO `lookup_countries` VALUES (39, 'Burundi');
INSERT INTO `lookup_countries` VALUES (40, 'Cambodia');
INSERT INTO `lookup_countries` VALUES (41, 'Cameroon');
INSERT INTO `lookup_countries` VALUES (43, 'Cape Verde Islands');
INSERT INTO `lookup_countries` VALUES (44, 'Cayman Islands');
INSERT INTO `lookup_countries` VALUES (45, 'Central African Republic');
INSERT INTO `lookup_countries` VALUES (46, 'Chad');
INSERT INTO `lookup_countries` VALUES (47, 'Chile');
INSERT INTO `lookup_countries` VALUES (48, 'China');
INSERT INTO `lookup_countries` VALUES (49, 'Colombia');
INSERT INTO `lookup_countries` VALUES (50, 'Comoros');
INSERT INTO `lookup_countries` VALUES (51, 'Congo, Democratic Republic of');
INSERT INTO `lookup_countries` VALUES (52, 'Cook Islands');
INSERT INTO `lookup_countries` VALUES (53, 'Costa Rica');
INSERT INTO `lookup_countries` VALUES (54, 'Cote d Ivoire (Ivory Coast)');
INSERT INTO `lookup_countries` VALUES (55, 'Croatia, Democratic Republic of the');
INSERT INTO `lookup_countries` VALUES (56, 'Cuba');
INSERT INTO `lookup_countries` VALUES (57, 'Cyprus');
INSERT INTO `lookup_countries` VALUES (58, 'Czech Republic');
INSERT INTO `lookup_countries` VALUES (59, 'Denmark');
INSERT INTO `lookup_countries` VALUES (60, 'Djibouti');
INSERT INTO `lookup_countries` VALUES (61, 'Dominica');
INSERT INTO `lookup_countries` VALUES (62, 'Dominican Republic');
INSERT INTO `lookup_countries` VALUES (63, 'Ecuador');
INSERT INTO `lookup_countries` VALUES (64, 'Egypt');
INSERT INTO `lookup_countries` VALUES (65, 'El Salvador');
INSERT INTO `lookup_countries` VALUES (66, 'Equatorial Guinea');
INSERT INTO `lookup_countries` VALUES (67, 'Eritrea');
INSERT INTO `lookup_countries` VALUES (68, 'Estonia');
INSERT INTO `lookup_countries` VALUES (69, 'Ethiopia');
INSERT INTO `lookup_countries` VALUES (70, 'Falkland Islands (Islas Makvinas)');
INSERT INTO `lookup_countries` VALUES (71, 'Fiji');
INSERT INTO `lookup_countries` VALUES (72, 'Finland');
INSERT INTO `lookup_countries` VALUES (73, 'France');
INSERT INTO `lookup_countries` VALUES (74, 'French Guiana');
INSERT INTO `lookup_countries` VALUES (75, 'French Polynesia');
INSERT INTO `lookup_countries` VALUES (76, 'Gabon Republic');
INSERT INTO `lookup_countries` VALUES (77, 'Gambia');
INSERT INTO `lookup_countries` VALUES (78, 'Georgia');
INSERT INTO `lookup_countries` VALUES (79, 'Germany');
INSERT INTO `lookup_countries` VALUES (80, 'Ghana');
INSERT INTO `lookup_countries` VALUES (81, 'Gibraltar');
INSERT INTO `lookup_countries` VALUES (82, 'Greece');
INSERT INTO `lookup_countries` VALUES (83, 'Greenland');
INSERT INTO `lookup_countries` VALUES (84, 'Grenada');
INSERT INTO `lookup_countries` VALUES (85, 'Guadeloupe');
INSERT INTO `lookup_countries` VALUES (86, 'Guam');
INSERT INTO `lookup_countries` VALUES (87, 'Guatemala');
INSERT INTO `lookup_countries` VALUES (88, 'Guernsey');
INSERT INTO `lookup_countries` VALUES (89, 'Guinea');
INSERT INTO `lookup_countries` VALUES (90, 'Guinea-Bissau');
INSERT INTO `lookup_countries` VALUES (91, 'Guyana');
INSERT INTO `lookup_countries` VALUES (92, 'Haiti');
INSERT INTO `lookup_countries` VALUES (93, 'Honduras');
INSERT INTO `lookup_countries` VALUES (94, 'Hong Kong');
INSERT INTO `lookup_countries` VALUES (95, 'Hungary');
INSERT INTO `lookup_countries` VALUES (96, 'Iceland');
INSERT INTO `lookup_countries` VALUES (97, 'Japan');
INSERT INTO `lookup_countries` VALUES (98, 'Jersey');
INSERT INTO `lookup_countries` VALUES (99, 'Jordan');
INSERT INTO `lookup_countries` VALUES (100, 'Kazakhstan');
INSERT INTO `lookup_countries` VALUES (101, 'Kenya Coast Republic');
INSERT INTO `lookup_countries` VALUES (102, 'Kiribati');
INSERT INTO `lookup_countries` VALUES (103, 'Korea, North');
INSERT INTO `lookup_countries` VALUES (104, 'Korea, South');
INSERT INTO `lookup_countries` VALUES (105, 'Kuwait');
INSERT INTO `lookup_countries` VALUES (106, 'Kyrgyzstan');
INSERT INTO `lookup_countries` VALUES (107, 'Laos');
INSERT INTO `lookup_countries` VALUES (108, 'Latvia');
INSERT INTO `lookup_countries` VALUES (109, 'Lebanon, South');
INSERT INTO `lookup_countries` VALUES (110, 'Lesotho');
INSERT INTO `lookup_countries` VALUES (111, 'Liberia');
INSERT INTO `lookup_countries` VALUES (112, 'Libya');
INSERT INTO `lookup_countries` VALUES (113, 'Liechtenstein');
INSERT INTO `lookup_countries` VALUES (114, 'Lithuania');
INSERT INTO `lookup_countries` VALUES (115, 'Luxembourg');
INSERT INTO `lookup_countries` VALUES (116, 'Macau');
INSERT INTO `lookup_countries` VALUES (117, 'Macedonia');
INSERT INTO `lookup_countries` VALUES (118, 'Madagascar');
INSERT INTO `lookup_countries` VALUES (119, 'Malawi');
INSERT INTO `lookup_countries` VALUES (120, 'Malaysia');
INSERT INTO `lookup_countries` VALUES (121, 'Maldives');
INSERT INTO `lookup_countries` VALUES (122, 'Mali');
INSERT INTO `lookup_countries` VALUES (123, 'Malta');
INSERT INTO `lookup_countries` VALUES (124, 'Marshall Islands');
INSERT INTO `lookup_countries` VALUES (125, 'Martinique');
INSERT INTO `lookup_countries` VALUES (126, 'Mauritania');
INSERT INTO `lookup_countries` VALUES (127, 'Mauritius');
INSERT INTO `lookup_countries` VALUES (128, 'Mayotte');
INSERT INTO `lookup_countries` VALUES (129, 'Mexico');
INSERT INTO `lookup_countries` VALUES (130, 'Moldova');
INSERT INTO `lookup_countries` VALUES (131, 'Monaco');
INSERT INTO `lookup_countries` VALUES (132, 'Mongolia');
INSERT INTO `lookup_countries` VALUES (133, 'Montserrat');
INSERT INTO `lookup_countries` VALUES (134, 'Morocco');
INSERT INTO `lookup_countries` VALUES (135, 'Mozambique');
INSERT INTO `lookup_countries` VALUES (136, 'Namibia');
INSERT INTO `lookup_countries` VALUES (137, 'Nauru');
INSERT INTO `lookup_countries` VALUES (138, 'Nepal');
INSERT INTO `lookup_countries` VALUES (139, 'Netherlands');
INSERT INTO `lookup_countries` VALUES (140, 'Netherlands Antilles');
INSERT INTO `lookup_countries` VALUES (141, 'New Caledonia');
INSERT INTO `lookup_countries` VALUES (142, 'New Zealand');
INSERT INTO `lookup_countries` VALUES (143, 'Nicaragua');
INSERT INTO `lookup_countries` VALUES (144, 'Niger');
INSERT INTO `lookup_countries` VALUES (145, 'Nigeria');
INSERT INTO `lookup_countries` VALUES (146, 'Niue');
INSERT INTO `lookup_countries` VALUES (147, 'Norway');
INSERT INTO `lookup_countries` VALUES (148, 'Oman');
INSERT INTO `lookup_countries` VALUES (149, 'Pakistan');
INSERT INTO `lookup_countries` VALUES (150, 'Palau');
INSERT INTO `lookup_countries` VALUES (151, 'Panama');
INSERT INTO `lookup_countries` VALUES (152, 'Papua New Guinea');
INSERT INTO `lookup_countries` VALUES (153, 'Paraguay');
INSERT INTO `lookup_countries` VALUES (154, 'Peru');
INSERT INTO `lookup_countries` VALUES (155, 'Philippines');
INSERT INTO `lookup_countries` VALUES (156, 'Poland');
INSERT INTO `lookup_countries` VALUES (157, 'Portugal');
INSERT INTO `lookup_countries` VALUES (158, 'Puerto Rico');
INSERT INTO `lookup_countries` VALUES (159, 'Qatar');
INSERT INTO `lookup_countries` VALUES (160, 'Romania');
INSERT INTO `lookup_countries` VALUES (161, 'Russian Federation');
INSERT INTO `lookup_countries` VALUES (162, 'Rwanda');
INSERT INTO `lookup_countries` VALUES (163, 'Saint Helena');
INSERT INTO `lookup_countries` VALUES (164, 'Saint Kitts-Nevis');
INSERT INTO `lookup_countries` VALUES (165, 'Saint Lucia');
INSERT INTO `lookup_countries` VALUES (166, 'Saint Pierre and Miquelon');
INSERT INTO `lookup_countries` VALUES (167, 'Saint Vincent and the Grenadines');
INSERT INTO `lookup_countries` VALUES (168, 'San Marino');
INSERT INTO `lookup_countries` VALUES (169, 'Saudi Arabia');
INSERT INTO `lookup_countries` VALUES (170, 'Senegal');
INSERT INTO `lookup_countries` VALUES (171, 'Seychelles');
INSERT INTO `lookup_countries` VALUES (172, 'Sierra Leone');
INSERT INTO `lookup_countries` VALUES (173, 'Singapore');
INSERT INTO `lookup_countries` VALUES (174, 'Slovakia');
INSERT INTO `lookup_countries` VALUES (175, 'Slovenia');
INSERT INTO `lookup_countries` VALUES (176, 'Solomon Islands');
INSERT INTO `lookup_countries` VALUES (177, 'Somalia');
INSERT INTO `lookup_countries` VALUES (178, 'South Africa');
INSERT INTO `lookup_countries` VALUES (179, 'Spain');
INSERT INTO `lookup_countries` VALUES (180, 'Sri Lanka');
INSERT INTO `lookup_countries` VALUES (181, 'Sudan');
INSERT INTO `lookup_countries` VALUES (182, 'Suriname');
INSERT INTO `lookup_countries` VALUES (183, 'Svalbard');
INSERT INTO `lookup_countries` VALUES (184, 'Swaziland');
INSERT INTO `lookup_countries` VALUES (185, 'Sweden');
INSERT INTO `lookup_countries` VALUES (186, 'Switzerland');
INSERT INTO `lookup_countries` VALUES (187, 'Syria');
INSERT INTO `lookup_countries` VALUES (188, 'Tahiti');
INSERT INTO `lookup_countries` VALUES (189, 'Taiwan');
INSERT INTO `lookup_countries` VALUES (190, 'Tajikistan');
INSERT INTO `lookup_countries` VALUES (191, 'Tanzania');
INSERT INTO `lookup_countries` VALUES (192, 'Thailand');
INSERT INTO `lookup_countries` VALUES (193, 'Togo');
INSERT INTO `lookup_countries` VALUES (194, 'Tonga');
INSERT INTO `lookup_countries` VALUES (195, 'Trinidad and Tobago');
INSERT INTO `lookup_countries` VALUES (196, 'Tunisia');
INSERT INTO `lookup_countries` VALUES (197, 'Turkey');
INSERT INTO `lookup_countries` VALUES (198, 'Turkmenistan');
INSERT INTO `lookup_countries` VALUES (199, 'Turks and Caicos Islands');
INSERT INTO `lookup_countries` VALUES (200, 'Tuvalu');
INSERT INTO `lookup_countries` VALUES (201, 'Uganda');
INSERT INTO `lookup_countries` VALUES (202, 'Ukraine');
INSERT INTO `lookup_countries` VALUES (203, 'United Arab Emirates');
INSERT INTO `lookup_countries` VALUES (205, 'Uruguay');
INSERT INTO `lookup_countries` VALUES (206, 'Uzbekistan');
INSERT INTO `lookup_countries` VALUES (207, 'Vanuatu');
INSERT INTO `lookup_countries` VALUES (208, 'Vatican City, State');
INSERT INTO `lookup_countries` VALUES (209, 'Venezuela');
INSERT INTO `lookup_countries` VALUES (210, 'Vietnam');
INSERT INTO `lookup_countries` VALUES (211, 'Virgin Islands (U.S.)');
INSERT INTO `lookup_countries` VALUES (212, 'Wallis and Futuna');
INSERT INTO `lookup_countries` VALUES (213, 'Western Sahara');
INSERT INTO `lookup_countries` VALUES (214, 'Western Samoa');
INSERT INTO `lookup_countries` VALUES (215, 'Yemen');
INSERT INTO `lookup_countries` VALUES (216, 'Yugoslavia');
INSERT INTO `lookup_countries` VALUES (217, 'Zambia');
INSERT INTO `lookup_countries` VALUES (218, 'Zimbabwe');
INSERT INTO `lookup_countries` VALUES (219, 'INDIA');

-- --------------------------------------------------------

-- 
-- Table structure for table `lookup_educations`
-- 

CREATE TABLE `lookup_educations` (
  `education_id` int(11) NOT NULL default '0',
  `education_desc` varchar(15) default NULL,
  PRIMARY KEY  (`education_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `lookup_educations`
-- 

INSERT INTO `lookup_educations` VALUES (1, 'High School');
INSERT INTO `lookup_educations` VALUES (2, 'College');
INSERT INTO `lookup_educations` VALUES (3, 'Graduate School');
INSERT INTO `lookup_educations` VALUES (4, 'Other');
INSERT INTO `lookup_educations` VALUES (0, 'Unspecified');

-- --------------------------------------------------------

-- 
-- Table structure for table `lookup_genders`
-- 

CREATE TABLE `lookup_genders` (
  `gender_id` int(11) NOT NULL default '0',
  `gender_desc` varchar(15) default NULL,
  PRIMARY KEY  (`gender_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `lookup_genders`
-- 

INSERT INTO `lookup_genders` VALUES (1, 'Male');
INSERT INTO `lookup_genders` VALUES (2, 'Female');
INSERT INTO `lookup_genders` VALUES (0, 'Unspecified');

-- --------------------------------------------------------

-- 
-- Table structure for table `lookup_incomes`
-- 

CREATE TABLE `lookup_incomes` (
  `income_id` int(11) NOT NULL default '0',
  `income_desc` varchar(20) default NULL,
  PRIMARY KEY  (`income_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `lookup_incomes`
-- 

INSERT INTO `lookup_incomes` VALUES (1, 'under $25,000');
INSERT INTO `lookup_incomes` VALUES (2, '$25,000 - $34,000');
INSERT INTO `lookup_incomes` VALUES (3, '$35,000 - $49,000');
INSERT INTO `lookup_incomes` VALUES (4, '$50,000 - $74,000');
INSERT INTO `lookup_incomes` VALUES (5, 'over $75,000');
INSERT INTO `lookup_incomes` VALUES (0, 'Unspecified');

-- --------------------------------------------------------

-- 
-- Table structure for table `lookup_listing_dates`
-- 

CREATE TABLE `lookup_listing_dates` (
  `date_id` bigint(20) NOT NULL auto_increment,
  `days` int(11) default NULL,
  `charge_for` tinyint(4) default NULL,
  `fee` decimal(10,2) default NULL,
  `cat_id` int(20) default '1',
  PRIMARY KEY  (`date_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- 
-- Dumping data for table `lookup_listing_dates`
-- 

INSERT INTO `lookup_listing_dates` VALUES (1, 3, NULL, NULL, 1);
INSERT INTO `lookup_listing_dates` VALUES (2, 5, NULL, NULL, 1);
INSERT INTO `lookup_listing_dates` VALUES (3, 7, NULL, NULL, 1);
INSERT INTO `lookup_listing_dates` VALUES (4, 10, NULL, NULL, 1);
INSERT INTO `lookup_listing_dates` VALUES (5, 14, NULL, NULL, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `lookup_states`
-- 

CREATE TABLE `lookup_states` (
  `state_id` varchar(50) NOT NULL default '',
  `state_desc` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`state_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `lookup_states`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `online`
-- 

CREATE TABLE `online` (
  `ip` varchar(15) NOT NULL default '',
  `datet` bigint(14) default NULL,
  `user` varchar(255) default NULL,
  `page` varchar(255) default NULL,
  KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `online`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `promos`
-- 

CREATE TABLE `promos` (
  `id` int(10) NOT NULL auto_increment,
  `start` int(20) default NULL,
  `end` int(20) default NULL,
  `amount` decimal(10,2) default NULL,
  `group` int(20) default NULL,
  `code` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `promos`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `purchases`
-- 

CREATE TABLE `purchases` (
  `id` int(20) NOT NULL auto_increment,
  `ItemNum` int(20) NOT NULL default '0',
  `date` int(20) NOT NULL default '0',
  `title` varchar(255) default NULL,
  `asking` decimal(10,2) default NULL,
  `amt_received` decimal(10,2) default NULL,
  `shipping` varchar(255) default NULL,
  `user_id` int(20) NOT NULL default '0',
  `buyer` int(20) NOT NULL default '0',
  `user_paypal` varchar(150) default NULL,
  `buyer_paypal` varchar(150) default NULL,
  `txn_id` varchar(100) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `purchases`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `search_history`
-- 

CREATE TABLE `search_history` (
  `id` bigint(200) NOT NULL auto_increment,
  `user_id` int(20) default NULL,
  `date` int(20) default NULL,
  `value` text,
  `results` text,
  `save` tinyint(2) default NULL,
  `sched` tinyint(2) default NULL,
  `frequency` int(20) default NULL,
  `nextrun` int(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `search_history`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `settings_accounting`
-- 

CREATE TABLE `settings_accounting` (
  `set_id` tinyint(3) NOT NULL default '0',
  `paypal_on` tinyint(4) default NULL,
  `paypal` varchar(255) default NULL,
  `authorizenet_on` tinyint(4) default NULL,
  `authorizenet` varchar(255) default NULL,
  `authorize_tran_key` varchar(32) default NULL,
  PRIMARY KEY  (`set_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `settings_accounting`
-- 

INSERT INTO `settings_accounting` VALUES (1, 1, 'admin@itechscripts.com', 0, 'authorize_uid', NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `settings_charges`
-- 

CREATE TABLE `settings_charges` (
  `set_id` bigint(20) NOT NULL default '0',
  `currency` varchar(5) default NULL,
  `currencycode` varchar(5) default NULL,
  `newregon` tinyint(4) default NULL,
  `newregcredit` bigint(20) default NULL,
  `newregreason` varchar(255) default NULL,
  `tokens` int(20) default '0',
  `listing_fee` decimal(10,2) default NULL,
  `home_fee` decimal(10,2) default NULL,
  `cat_fee` decimal(10,2) default NULL,
  `gallery_fee` decimal(10,2) default NULL,
  `image_pre_fee` decimal(10,2) default NULL,
  `slide_fee` decimal(10,2) default NULL,
  `counter_fee` decimal(10,2) default NULL,
  `bold_fee` decimal(10,2) default NULL,
  `high_fee` decimal(10,2) default NULL,
  `upload_fee` decimal(10,2) default NULL,
  PRIMARY KEY  (`set_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `settings_charges`
-- 

INSERT INTO `settings_charges` VALUES (1, '$', 'USD', 1, NULL, NULL, 20, '0.00', '5.00', '2.50', '2.50', '1.00', '1.00', '0.50', '1.50', '2.00', '0.25');

-- --------------------------------------------------------

-- 
-- Table structure for table `settings_froogle`
-- 

CREATE TABLE `settings_froogle` (
  `set_id` tinyint(2) NOT NULL default '1',
  `ftp_url` varchar(100) NOT NULL default 'hedwig.google.com',
  `ftpusername` varchar(50) default NULL,
  `ftppassword` varchar(50) default NULL,
  `frooglefile` varchar(50) default NULL,
  `submit_date` int(20) default NULL,
  PRIMARY KEY  (`set_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `settings_froogle`
-- 

INSERT INTO `settings_froogle` VALUES (1, 'hedwig.google.com', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `settings_general`
-- 

CREATE TABLE `settings_general` (
  `set_id` tinyint(3) NOT NULL default '0',
  `sitename` varchar(255) default '0',
  `siteemail` varchar(255) default NULL,
  `homeurl` varchar(255) default NULL,
  `secureurl` varchar(255) default NULL,
  `uploadurl` varchar(255) default NULL,
  `pagentrys` int(11) default NULL,
  `frontentrys` tinyint(4) default NULL,
  `notify` tinyint(4) default NULL,
  `notifyads` tinyint(4) default NULL,
  `notifyemail` varchar(255) default NULL,
  `bounceout` tinyint(4) default NULL,
  `bounceout_id` tinyint(4) default NULL,
  `timeout` int(10) default NULL,
  `has_gd` tinyint(4) default NULL,
  `approv_priority` tinyint(2) default '0',
  `mimemail` tinyint(2) default '0',
  PRIMARY KEY  (`set_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `settings_general`
-- 

INSERT INTO `settings_general` VALUES (1, 'malware market', 'admin@malwaremarket.com', 'http://lab.demonstrationserver.com/classifieds/', 'http://lab.malwaremarket.com/classifieds/', 'uploads/', 20, 10, 1, 1, 'admin@malwaremarket.com', 0, 1, 600, 0, 0, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `settings_images`
-- 

CREATE TABLE `settings_images` (
  `set_id` tinyint(3) NOT NULL default '0',
  `maxuploadwidth` int(11) default NULL,
  `maxuploadheight` int(11) default NULL,
  PRIMARY KEY  (`set_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `settings_images`
-- 

INSERT INTO `settings_images` VALUES (1, 800, 800);

-- --------------------------------------------------------

-- 
-- Table structure for table `subscription_plans`
-- 

CREATE TABLE `subscription_plans` (
  `id` int(20) NOT NULL auto_increment,
  `title` varchar(255) default NULL,
  `description` text,
  `group` int(20) default NULL,
  `duration` int(20) default NULL,
  `unlimited` tinyint(2) default '0',
  `price` decimal(10,2) default NULL,
  `recurring` tinyint(3) default NULL,
  `intro` tinyint(3) default NULL,
  `intro_duration` int(20) default NULL,
  `intro_price` int(20) default NULL,
  `paypal` tinyint(3) default NULL,
  `authnet` tinyint(3) default NULL,
  `co2` tinyint(3) default NULL,
  `active` tinyint(3) default NULL,
  `icon` varchar(100) default NULL,
  `date_added` int(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `subscription_plans`
-- 

INSERT INTO `subscription_plans` VALUES (1, 'Basic', NULL, 1, 30, 0, '0.00', 0, 0, NULL, NULL, 0, 0, 0, 1, NULL, 1200219123);
INSERT INTO `subscription_plans` VALUES (2, 'Gold', NULL, 1, 30, 0, '20.00', 1, 0, NULL, NULL, 1, 0, 0, 1, NULL, 1200219180);
INSERT INTO `subscription_plans` VALUES (3, 'Platinum', NULL, 1, 60, 0, '30.00', 1, 0, NULL, NULL, 1, 0, 0, 1, NULL, 1200219205);

-- --------------------------------------------------------

-- 
-- Table structure for table `templates_cat`
-- 

CREATE TABLE `templates_cat` (
  `id` bigint(200) NOT NULL auto_increment,
  `cat_id` bigint(20) NOT NULL default '0',
  `template` blob,
  `active` tinyint(2) NOT NULL default '0',
  `admin_override` tinyint(2) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `templates_cat`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `templates_emails`
-- 

CREATE TABLE `templates_emails` (
  `temp_id` tinyint(3) NOT NULL auto_increment,
  `template_name` varchar(255) default NULL,
  `from_email` varchar(100) default NULL,
  `email_subject` varchar(255) default NULL,
  `email_text` text,
  PRIMARY KEY  (`temp_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

-- 
-- Dumping data for table `templates_emails`
-- 

INSERT INTO `templates_emails` VALUES (1, 'NewRegistration', '', 'Welcome to [EMAIL:SITE_NAME]!', 'Hello [EMAIL:CURRENT_USER_FIRST_NAME],\r\n\r\nWe are glad you decided to join us! Here at [EMAIL:SITE_NAME], you can effectivly buy and sell your items while in an enjoyable environment. We hope you have fun as member of our community. \r\n\r\nThank you,\r\n[EMAIL:SITE_NAME] Team');
INSERT INTO `templates_emails` VALUES (2, 'EmailReply', '', '[EMAIL:REPLY_SUBJECT]', '[EMAIL:REPLY_FROM_USERNAME] has sent you a reply  on [EMAIL:CURRENT_TIME]\r\n\r\nMessage\r\n-------------------------------------------------------------------\r\n[EMAIL:REPLY_MESSAGE]\r\n\r\n\r\n-------------------------------------------------------------------');
INSERT INTO `templates_emails` VALUES (3, 'AskAQuestion', '', 'A question has been asked about Item#[EMAIL:AAQ_ITEM_NUMBER]', 'Hello [EMAIL:AAQ_TO_SELLER_USERNAME],\r\n\r\nThe following question was asked:\r\nFrom: [EMAIL:AAQ_FROM_BUYER_USERNAME]\r\nRegarding Item#[EMAIL:AAQ_ITEM_NUMBER]\r\n________________________________________________________\r\n\r\n[EMAIL:AAQ_MESSAGE]\r\n\r\n________________________________________________________');
INSERT INTO `templates_emails` VALUES (4, 'MakeAnOffer', '', '[EMAIL:MAO_FROM_BUYER_USERNAME] has made an offer on Item#[EMAIL:MAO_ITEM_NUMBER] has been made', '[EMAIL:MAO_TO_SELLER_USERNAME],\r\n\r\n[EMAIL:MAO_FROM_BUYER_USERNAME] has made an offer regarding Item [EMAIL:MAO_ITEM_NUMBER]\r\n\r\nBelow are the details of the offer\r\n\r\nAmount: [EMAIL:MAO_AMOUNT]\r\n________________________________________________________\r\n\r\n[EMAIL:MAO_MESSAGE]\r\n\r\n________________________________________________________');
INSERT INTO `templates_emails` VALUES (5, 'MakePayment', '', 'Your Credit Card Deposit has been received successfully', 'Hello [EMAIL:CURRENT_USER_FIRST_NAME],\r\n\r\nThis is a notice to let you know that your Credit Card Deposit in the amount of [EMAIL:PAYMENT_AMOUNT] has been received successfully.\r\n\r\nBelow are the details of the deposit:\r\n\r\nAmount: [EMAIL:PAYMENT_AMOUNT]\r\nDate Deposited: [EMAIL:CURRENT_TIME]\r\n\r\nSincerely,\r\n[EMAIL:SITE_NAME] Team');
INSERT INTO `templates_emails` VALUES (8, 'AskAQuestionNotification', '', 'A question about Item#[EMAIL:AAQ_ITEM_NUMBER] has been received at [EMAIL:SITE_NAME]', 'Hello [EMAIL:AAQ_TO_SELLER_USERNAME],\r\n\r\nThe following question was asked:\r\nFrom: [EMAIL:AAQ_FROM_BUYER_USERNAME]\r\nRegarding Item#[EMAIL:AAQ_ITEM_NUMBER]\r\n________________________________________________________\r\n\r\n[EMAIL:AAQ_MESSAGE]\r\n\r\n\r\n________________________________________________________\r\n\r\nTo reply to this message, login to your account and you can send a reply from there.\r\n\r\nSincerely,\r\n[EMAIL:SITE_NAME] Team');
INSERT INTO `templates_emails` VALUES (9, 'EmailReplyNotification', '', 'A notice that [EMAIL:REPLY_FROM_USERNAME] has replied to your email at [EMAIL:SITE_NAME]', 'Hello [EMAIL:REPLY_TO_USERNAME],\r\n\r\nThis is an automated response to inform you that [EMAIL:REPLY_FROM_USERNAME] has responded to your message on [EMAIL:CURRENT_TIME]. You can read the message in your account at [EMAIL:HOME_URL]myaccount.php\r\n\r\nSincerely,\r\n[EMAIL:SITE_NAME] Team');
INSERT INTO `templates_emails` VALUES (10, 'MakeAnOfferNotification', '', 'An offer has been made on Item#[EMAIL:MAO_ITEM_NUMBER] at [EMAIL:SITE_NAME]', 'Hello [EMAIL:MAO_TO_SELLER_USERNAME],\r\n\r\n[EMAIL:MAO_FROM_BUYER_USERNAME] has made an offer regarding Item#[EMAIL:MAO_ITEM_NUMBER]\r\n\r\nBelow are the details of the offer\r\n\r\nAmount: [EMAIL:MAO_AMOUNT]\r\n________________________________________________________\r\n\r\n[EMAIL:MAO_MESSAGE]\r\n\r\n________________________________________________________\r\n\r\nYou can reply to this message from within your account at [EMAIL:SITE_NAME]\r\n\r\n[EMAIL:HOME_URL]myaccount.php\r\n\r\nSincerely,\r\n[EMAIL:SITE_NAME] Team');
INSERT INTO `templates_emails` VALUES (11, 'NewRegistrationNotification', '', 'Thank you for registering at [EMAIL:SITE_NAME]! Here are your account details', 'Hello [EMAIL:CURRENT_USER_FIRST_NAME],\r\n\r\nYou, or someone using the email address of [EMAIL:CURRENT_USER_EMAIL], has registered at [EMAIL:SITE_NAME] on [EMAIL:CURRENT_TIME]. Below is your username and password so that you may login and start selling or buying right away.\r\n\r\nYour account details,\r\nUsername: [EMAIL:CURRENT_USERNAME]\r\nPassword: [EMAIL:CURRENT_USER_PASSWORD]\r\n\r\nYou may change your password at anytime from within your account options. To login to your account click here \r\n\r\n[EMAIL:HOME_URL]myaccount.php\r\n\r\nThank you,\r\n[EMAIL:SITE_NAME] Team');
INSERT INTO `templates_emails` VALUES (12, 'NewRegistrationAdminCopy', '', 'A New User has registered at [EMAIL:SITE_NAME] on [EMAIL:CURRENT_TIME]', 'A new user has registered on [EMAIL:CURRENT_TIME]\r\n\r\nBelow are the details of the new registration:\r\n\r\nUsername: [EMAIL:CURRENT_USERNAME]\r\nFirst name: [EMAIL:CURRENT_USER_FIRST_NAME]\r\nLast name: [EMAIL:CURRENT_USER_LAST_NAME]\r\nEmail: [EMAIL:CURRENT_USER_EMAIL]\r\nRegistered IP: [EMAIL:CURRENT_USER__REGISTERED_IP]');
INSERT INTO `templates_emails` VALUES (13, 'ForgotPassword', '', 'Forgotten Password Notice', 'Hello [EMAIL:CURRENT_USER_FIRST_NAME],\r\n\r\nThis is just a notice to inform you that you, or someone, has filled out a lost password request.\r\n\r\nSincerely,\r\n[EMAIL:SITE_NAME] Team');
INSERT INTO `templates_emails` VALUES (14, 'MakePaymentNotification', '', 'Your Credit Card Deposit has been received successfully at [EMAIL:SITE_NAME]', 'Hello [EMAIL:CURRENT_USER_FIRST_NAME],\r\n\r\nThis is a notice to let you know that your Credit Card Deposit in the amount of [EMAIL:PAYMENT_AMOUNT] has been received successfully.\r\n\r\nBelow are the details of the deposit:\r\n\r\nAmount: [EMAIL:PAYMENT_AMOUNT]\r\nDate Deposited: [EMAIL:CURRENT_TIME]\r\n\r\nYou can view your new balance at the top of your account at:\r\n[EMAIL:HOME_URL]myaccount.php\r\n\r\nSincerely,\r\n[EMAIL:SITE_NAME] Team');
INSERT INTO `templates_emails` VALUES (15, 'MakePaymentAdminCopy', '', 'A Credit Card Deposit has been made by [EMAIL:CURRENT_USERNAME] on [EMAIL:CURRENT_TIME]', 'This is a notice to let you know that [EMAIL:CURRENT_USERNAME] has made a Credit Card Deposit in the amount of [EMAIL:PAYMENT_AMOUNT].\r\n\r\nBelow are the details of the deposit:\r\n\r\nUsername: [EMAIL:CURRENT_USERNAME]\r\nFirst name: [EMAIL:CURRENT_USER_FIRST_NAME]\r\nLast name: [EMAIL:CURRENT_USER_LAST_NAME]\r\nUser''s email: [EMAIL:CURRENT_USER_EMAIL]\r\nAmount: [EMAIL:PAYMENT_AMOUNT]\r\nDate Deposited: [EMAIL:CURRENT_TIME]\r\n');
INSERT INTO `templates_emails` VALUES (16, 'MakePaymentPaypal', '', 'Your PayPal Deposit has been received successfully', 'Hello [EMAIL:CURRENT_USER_FIRST_NAME],\r\n\r\nThis is a notice to let you know that your PayPal Deposit in the amount of [EMAIL:PAYMENT_AMOUNT] has been received successfully.\r\n\r\nBelow are the details of the deposit:\r\n\r\nAmount: [EMAIL:PAYMENT_AMOUNT]\r\nDate Deposited: [EMAIL:CURRENT_TIME]\r\n\r\nSincerely,\r\n[EMAIL:SITE_NAME] Team');
INSERT INTO `templates_emails` VALUES (17, 'MakePaymentPaypalNotification', '', 'Your PayPal Deposit has been received successfully at [EMAIL:SITE_NAME]', 'Hello [EMAIL:CURRENT_USER_FIRST_NAME],\r\n\r\nThis is a notice to let you know that your PayPal Deposit in the amount of [EMAIL:PAYMENT_AMOUNT] has been received successfully.\r\n\r\nBelow are the details of the deposit:\r\n\r\nAmount: [EMAIL:PAYMENT_AMOUNT]\r\nDate Deposited: [EMAIL:CURRENT_TIME]\r\n\r\nYou can view your new balance at the top of your account at:\r\n[EMAIL:HOME_URL]myaccount.php\r\n\r\nSincerely,\r\n[EMAIL:SITE_NAME] Team');
INSERT INTO `templates_emails` VALUES (18, 'MakePaymentPaypalAdminCopy', '', 'A PayPal Deposit has been made by [EMAIL:CURRENT_USERNAME] on [EMAIL:CURRENT_TIME]', 'This is a notice to let you know that [EMAIL:CURRENT_USERNAME] has made a PayPal Deposit in the amount of [EMAIL:PAYMENT_AMOUNT].\r\n\r\nBelow are the details of the deposit:\r\n\r\nUsername: [EMAIL:CURRENT_USERNAME]\r\nFirst name: [EMAIL:CURRENT_USER_FIRST_NAME]\r\nLast name: [EMAIL:CURRENT_USER_LAST_NAME]\r\nUser''s email: [EMAIL:CURRENT_USER_EMAIL]\r\nUser''s PayPal email [EMAIL:PAYER_EMAIL]\r\nAmount: [EMAIL:PAYMENT_AMOUNT]\r\nDate Deposited: [EMAIL:CURRENT_TIME]');
INSERT INTO `templates_emails` VALUES (21, 'ForgotPasswordNotification', '', 'Your account details from [EMAIL:SITE_NAME]', 'Hello [EMAIL:CURRENT_USER_FIRST_NAME],\r\n\r\nYou or someone using this email has requested the password for the account, "[EMAIL:CURRENT_USERNAME]".\r\n\r\nAs a reminder, here are the details of your account.\r\nUsername: [EMAIL:CURRENT_USERNAME]\r\nPassword: [EMAIL:CURRENT_USER_PASSWORD]\r\n\r\nSincerely,\r\n[EMAIL:SITE_NAME] Team');
INSERT INTO `templates_emails` VALUES (22, 'NewListing', '', 'New Listing  #[EMAIL:AD_ITEM_NUMBER] created on [EMAIL:AD_STARTED]', 'Hello [EMAIL:CURRENT_USERNAME],\r\n\r\nThank you for submitting your item! Below are the details of your new listing. You can preview your listing by clicking <a href=[EMAIL:HOME_URL]ViewItem.php?ItemNum=[EMAIL:AD_ITEM_NUMBER]>here</a>\r\n\r\nDetails\r\n--------------------------------------------------\r\nItem Number: [EMAIL:AD_ITEM_NUMBER]\r\nTitle: [EMAIL:AD_TITLE]\r\nStarted: [EMAIL:AD_STARTED]\r\nDays to Run: [EMAIL:AD_DAYS_RUNNING]\r\nCloses on: [EMAIL:AD_CLOSES]\r\nAsking Price: [EMAIL:AD_ASKING_PRICE]   [EMAIL:AD_MAKE_OFFER]\r\nQuantity: [EMAIL:AD_QUANTITY]\r\nCity/Town: [EMAIL:AD_CITY]\r\nState/Province: [EMAIL:AD_STATE_PROVINCE] \r\n\r\nCharges\r\n----------------------------------------------------\r\nBold: [EMAIL:AD_BOLD_CHARGE]\r\nHighlighted: [EMAIL:AD_HIGHLIGHTED_CHARGE]\r\nCategory Featured: [EMAIL:AD_CATEGORY_FEATURED_CHARGE]\r\nGallery Listing: [EMAIL:AD_GALLERY_CHARGE]\r\nImage Preview: [EMAIL:AD_IMAGE_PREVIEW_CHARGE]\r\nHome Page Featured: [EMAIL:AD_HOME_PAGE_CHARGE]\r\nImage Slide Show: [EMAIL:AD_SLIDE_SHOW_CHARGE]\r\nCounter: [EMAIL:AD_COUNTER_CHARGE]\r\nImage One: [EMAIL:AD_IMAGE_ONE_CHARGE]\r\nImage Two: [EMAIL:AD_IMAGE_TWO_CHARGE]\r\nImage Three: [EMAIL:AD_IMAGE_THREE_CHARGE]\r\nImage Four: [EMAIL:AD_IMAGE_FOUR_CHARGE]\r\nImage Five: [EMAIL:AD_IMAGE_FIVE_CHARGE]\r\n\r\n\r\nThank you,\r\n[EMAIL:SITE_NAME] Team');
INSERT INTO `templates_emails` VALUES (23, 'NewListingNotification', '', 'Your New Listing # [EMAIL:AD_ITEM_NUMBER] at [EMAIL:SITE_NAME]', 'Hello [EMAIL:CURRENT_USERNAME],\r\n\r\nThank you for submitting your item! Below are the details of your new listing. You can preview your listing by clicking here... [EMAIL:HOME_URL]ViewItem.php?ItemNum=[EMAIL:AD_ITEM_NUMBER]\r\n\r\nDetails\r\n--------------------------------------------------\r\nItem Number: [EMAIL:AD_ITEM_NUMBER]\r\nTitle: [EMAIL:AD_TITLE]\r\nStarted: [EMAIL:AD_STARTED]\r\nDays to Run: [EMAIL:AD_DAYS_RUNNING]\r\nCloses on: [EMAIL:AD_CLOSES]\r\nAsking Price: [EMAIL:AD_ASKING_PRICE]   [EMAIL:AD_MAKE_OFFER]\r\nQuantity: [EMAIL:AD_QUANTITY]\r\nCity/Town: [EMAIL:AD_CITY]\r\nState/Province: [EMAIL:AD_STATE_PROVINCE] \r\n\r\nCharges\r\n----------------------------------------------------\r\nBold: [EMAIL:AD_BOLD_CHARGE]\r\nHighlighted: [EMAIL:AD_HIGHLIGHTED_CHARGE]\r\nCategory Featured: [EMAIL:AD_CATEGORY_FEATURED_CHARGE]\r\nGallery Listing: [EMAIL:AD_GALLERY_CHARGE]\r\nImage Preview: [EMAIL:AD_IMAGE_PREVIEW_CHARGE]\r\nHome Page Featured: [EMAIL:AD_HOME_PAGE_CHARGE]\r\nImage Slide Show: [EMAIL:AD_SLIDE_SHOW_CHARGE]\r\nCounter: [EMAIL:AD_COUNTER_CHARGE]\r\nImage One: [EMAIL:AD_IMAGE_ONE_CHARGE]\r\nImage Two: [EMAIL:AD_IMAGE_TWO_CHARGE]\r\nImage Three: [EMAIL:AD_IMAGE_THREE_CHARGE]\r\nImage Four: [EMAIL:AD_IMAGE_FOUR_CHARGE]\r\nImage Five: [EMAIL:AD_IMAGE_FIVE_CHARGE]\r\n\r\n\r\nThank you,\r\n[EMAIL:SITE_NAME] Team');
INSERT INTO `templates_emails` VALUES (24, 'NewListingAdminCopy', '', 'A new Listing has been created at [EMAIL:SITE_NAME]', 'A new listing has been created on [EMAIL:AD_STARTED]. Below are the details of the new listing. You can preview the listing by clicking here... [EMAIL:HOME_URL]ViewItem.php?ItemNum=[EMAIL:AD_ITEM_NUMBER]\r\n\r\nDetails\r\n--------------------------------------------------\r\nItem Number: [EMAIL:AD_ITEM_NUMBER]\r\nTitle: [EMAIL:AD_TITLE]\r\nStarted: [EMAIL:AD_STARTED]\r\nDays to Run: [EMAIL:AD_DAYS_RUNNING]\r\nCloses on: [EMAIL:AD_CLOSES]\r\nAsking Price: [EMAIL:AD_ASKING_PRICE]   [EMAIL:AD_MAKE_OFFER]\r\nQuantity: [EMAIL:AD_QUANTITY]\r\nCity/Town: [EMAIL:AD_CITY]\r\nState/Province: [EMAIL:AD_STATE_PROVINCE] \r\n\r\nCharges\r\n----------------------------------------------------\r\nBold: [EMAIL:AD_BOLD_CHARGE]\r\nHighlighted: [EMAIL:AD_HIGHLIGHTED_CHARGE]\r\nCategory Featured: [EMAIL:AD_CATEGORY_FEATURED_CHARGE]\r\nGallery Listing: [EMAIL:AD_GALLERY_CHARGE]\r\nImage Preview: [EMAIL:AD_IMAGE_PREVIEW_CHARGE]\r\nHome Page Featured: [EMAIL:AD_HOME_PAGE_CHARGE]\r\nImage Slide Show: [EMAIL:AD_SLIDE_SHOW_CHARGE]\r\nCounter: [EMAIL:AD_COUNTER_CHARGE]\r\nImage One: [EMAIL:AD_IMAGE_ONE_CHARGE]\r\nImage Two: [EMAIL:AD_IMAGE_TWO_CHARGE]\r\nImage Three: [EMAIL:AD_IMAGE_THREE_CHARGE]\r\nImage Four: [EMAIL:AD_IMAGE_FOUR_CHARGE]\r\nImage Five: [EMAIL:AD_IMAGE_FIVE_CHARGE]\r\n\r\n\r\n');
INSERT INTO `templates_emails` VALUES (25, 'UserPurchase', NULL, 'Purchase Made on [EMAIL:SITE_NAME]', 'Congratulations on your sale/purchase!   The next step you will want to do is to get in contact with each other and work out the finer details of your transaction, such as shipping details.\r\n\r\nTo the Seller:\r\nYou can contact the buyer at:\r\nUserName: [EMAIL:CURRENT_USERNAME]\r\n[EMAIL:CURRENT_USER_FIRST_NAME] [EMAIL:CURRENT_USER_LAST_NAME]\r\n[EMAIL:CURRENT_USER_EMAIL]\r\n\r\nTo the Buyer:\r\nYou can contact the seller at:\r\nUserName: [EMAIL:SELLER_USERNAME]\r\n[EMAIL:SELLER_FIRST_NAME] [EMAIL:SELLER_LAST_NAME]\r\n[EMAIL:SELLER_EMAIL]\r\n\r\nTransaction Details:\r\nItem: [EMAIL:ITEMNUM] "[EMAIL:ITEMTITLE]"\r\nShipping Method: [EMAIL:SHIPPING_METHOD] @ [EMAIL:SHIPPING_FEE]\r\nTotal Price: [EMAIL:PAYMENT_AMOUNT]\r\n\r\nPlease don''t forget to leave feedback for eachother after you finish this transaction.  You can leave feedback from the ''Purchase History'' page in the ''MyAccount'' area.\r\n\r\nWe hope you had an enjoyable experience with your transaction through [EMAIL:SITE_NAME], and that you will come back soon!');
INSERT INTO `templates_emails` VALUES (26, 'UserPurchaseNotification', NULL, 'Purchase Made on [EMAIL:SITE_NAME]', 'Congratulations on your sale/purchase!   The next step you will want to do is to get in contact with each other and work out the finer details of your transaction, such as shipping details.\r\n\r\nTo the Seller:\r\nYou can contact the buyer at:\r\nUserName: [EMAIL:CURRENT_USERNAME]\r\n[EMAIL:CURRENT_USER_FIRST_NAME] [EMAIL:CURRENT_USER_LAST_NAME]\r\n[EMAIL:CURRENT_USER_EMAIL]\r\n\r\nTo the Buyer:\r\nYou can contact the seller at:\r\nUserName: [EMAIL:SELLER_USERNAME]\r\n[EMAIL:SELLER_FIRST_NAME] [EMAIL:SELLER_LAST_NAME]\r\n[EMAIL:SELLER_EMAIL]\r\n\r\nTransaction Details:\r\nItem: [EMAIL:ITEMNUM] "[EMAIL:ITEMTITLE]"\r\nShipping Method: [EMAIL:SHIPPING_METHOD] @ [EMAIL:SHIPPING_FEE]\r\nTotal Price: [EMAIL:PAYMENT_AMOUNT]\r\n\r\nPlease don''t forget to leave feedback for eachother after you finish this transaction.  You can leave feedback from the ''Purchase History'' page in the ''MyAccount'' area.\r\n\r\nWe hope you had an enjoyable experience with your transaction through [EMAIL:SITE_NAME], and that you will come back soon!');
INSERT INTO `templates_emails` VALUES (27, 'NotifyRenew', '', 'Your Listing on [EMAIL:SITE_NAME] is about to expire', 'Your listing on [EMAIL:SITE_NAME] is about to expire. \r\n\r\nItem Number: [EMAIL:ITEM_NUMBER]\r\nTitle: [EMAIL:ITEM_TITLE]\r\nExpiration Date: [EMAIL:EXPIRE]');
INSERT INTO `templates_emails` VALUES (28, 'NotifyRenewNotification', '', 'Your listing on [EMAIL:SITE_NAME] is about to expire.', 'Your listing on [EMAIL:SITE_NAME] is about to expire. \r\n\r\nItem Number: [EMAIL:ITEM_NUMBER]\r\nTitle: [EMAIL:ITEM_TITLE]\r\nExpiration Date: [EMAIL:EXPIRE]');
INSERT INTO `templates_emails` VALUES (29, 'SearchNotify', NULL, 'Search Match Notification from [EMAIL:SITE_NAME]', 'New Items have been matched by your Scheduled Search on [EMAIL:SITE_NAME].  To disable or modify your search scheduling please logon to your Account, go to "My Recent and Saved Searches", find your saved search from [EMAIL:SS_DATE].  Then click on "Auto-Notification Scheduling" and uncheck the "Enable Scheduling" box.\r\n\r\nYour new matches are as follows:\r\n[EMAIL:NEW_MATCHES]');
INSERT INTO `templates_emails` VALUES (30, 'SearchNotifyNotification', NULL, 'Search Match Notification from [EMAIL:SITE_NAME]', 'New Items have been matched by your Scheduled Search on [EMAIL:SITE_NAME].  To disable or modify your search scheduling please logon to your Account, go to "My Recent and Saved Searches", find your saved search from [EMAIL:SS_DATE].  Then click on "Auto-Notification Scheduling" and uncheck the "Enable Scheduling" box.');
INSERT INTO `templates_emails` VALUES (31, 'NewListingApproval', '', 'New Listing  #[EMAIL:AD_ITEM_NUMBER] Submitted for Approval', 'Hello [EMAIL:CURRENT_USERNAME],\r\n\r\nThank you for submitting your item! Below are the details of your new listing. Your listing should go through the approval process and started very shortly.  The running time of the listing will be begin when it is approved.\r\nDetails\r\n--------------------------------------------------\r\nItem Number: [EMAIL:AD_ITEM_NUMBER]\r\nTitle: [EMAIL:AD_TITLE]\r\nStarted: [EMAIL:AD_STARTED]\r\nDays to Run: [EMAIL:AD_DAYS_RUNNING]\r\nCloses on: [EMAIL:AD_CLOSES]\r\nAsking Price: [EMAIL:AD_ASKING_PRICE]   [EMAIL:AD_MAKE_OFFER]\r\nQuantity: [EMAIL:AD_QUANTITY]\r\nCity/Town: [EMAIL:AD_CITY]\r\nState/Province: [EMAIL:AD_STATE_PROVINCE] \r\n\r\nCharges\r\n----------------------------------------------------\r\nBold: [EMAIL:AD_BOLD_CHARGE]\r\nHighlighted: [EMAIL:AD_HIGHLIGHTED_CHARGE]\r\nCategory Featured: [EMAIL:AD_CATEGORY_FEATURED_CHARGE]\r\nGallery Listing: [EMAIL:AD_GALLERY_CHARGE]\r\nImage Preview: [EMAIL:AD_IMAGE_PREVIEW_CHARGE]\r\nHome Page Featured: [EMAIL:AD_HOME_PAGE_CHARGE]\r\nImage Slide Show: [EMAIL:AD_SLIDE_SHOW_CHARGE]\r\nCounter: [EMAIL:AD_COUNTER_CHARGE]\r\nImage One: [EMAIL:AD_IMAGE_ONE_CHARGE]\r\nImage Two: [EMAIL:AD_IMAGE_TWO_CHARGE]\r\nImage Three: [EMAIL:AD_IMAGE_THREE_CHARGE]\r\nImage Four: [EMAIL:AD_IMAGE_FOUR_CHARGE]\r\nImage Five: [EMAIL:AD_IMAGE_FIVE_CHARGE]\r\n\r\n\r\nThank you,\r\n[EMAIL:SITE_NAME] Team');
INSERT INTO `templates_emails` VALUES (32, 'NewListingApprovalNotification', '', 'Your New Listing # [EMAIL:AD_ITEM_NUMBER] at [EMAIL:SITE_NAME] has been submitted for approval', 'Hello [EMAIL:CURRENT_USERNAME],\r\n\r\nThank you for submitting your item! Below are the details of your new listing. Your listing should go through the approval process and started very shortly.  The running time of the listing will be begin when it is approved.\r\n\r\nDetails\r\n--------------------------------------------------\r\nItem Number: [EMAIL:AD_ITEM_NUMBER]\r\nTitle: [EMAIL:AD_TITLE]\r\nStarted: [EMAIL:AD_STARTED]\r\nDays to Run: [EMAIL:AD_DAYS_RUNNING]\r\nCloses on: [EMAIL:AD_CLOSES]\r\nAsking Price: [EMAIL:AD_ASKING_PRICE]   [EMAIL:AD_MAKE_OFFER]\r\nQuantity: [EMAIL:AD_QUANTITY]\r\nCity/Town: [EMAIL:AD_CITY]\r\nState/Province: [EMAIL:AD_STATE_PROVINCE] \r\n\r\nCharges\r\n----------------------------------------------------\r\nBold: [EMAIL:AD_BOLD_CHARGE]\r\nHighlighted: [EMAIL:AD_HIGHLIGHTED_CHARGE]\r\nCategory Featured: [EMAIL:AD_CATEGORY_FEATURED_CHARGE]\r\nGallery Listing: [EMAIL:AD_GALLERY_CHARGE]\r\nImage Preview: [EMAIL:AD_IMAGE_PREVIEW_CHARGE]\r\nHome Page Featured: [EMAIL:AD_HOME_PAGE_CHARGE]\r\nImage Slide Show: [EMAIL:AD_SLIDE_SHOW_CHARGE]\r\nCounter: [EMAIL:AD_COUNTER_CHARGE]\r\nImage One: [EMAIL:AD_IMAGE_ONE_CHARGE]\r\nImage Two: [EMAIL:AD_IMAGE_TWO_CHARGE]\r\nImage Three: [EMAIL:AD_IMAGE_THREE_CHARGE]\r\nImage Four: [EMAIL:AD_IMAGE_FOUR_CHARGE]\r\nImage Five: [EMAIL:AD_IMAGE_FIVE_CHARGE]\r\n\r\n\r\nThank you,\r\n[EMAIL:SITE_NAME] Team');
INSERT INTO `templates_emails` VALUES (33, 'NewListingApprovalAdminCopy', '', 'A new Listing has been submitted for approval [EMAIL:SITE_NAME]', 'A new listing has been created on [EMAIL:AD_STARTED]. Below are the details of the new listing. You can preview, edit and approve (if you are a member of the ''Front-End Admin'' group)  the listing by clicking here... [EMAIL:HOME_URL]ViewItem.php?ItemNum=[EMAIL:AD_ITEM_NUMBER]\r\n\r\nDetails\r\n--------------------------------------------------\r\nItem Number: [EMAIL:AD_ITEM_NUMBER]\r\nTitle: [EMAIL:AD_TITLE]\r\nStarted: [EMAIL:AD_STARTED]\r\nDays to Run: [EMAIL:AD_DAYS_RUNNING]\r\nCloses on: [EMAIL:AD_CLOSES]\r\nAsking Price: [EMAIL:AD_ASKING_PRICE]   [EMAIL:AD_MAKE_OFFER]\r\nQuantity: [EMAIL:AD_QUANTITY]\r\nCity/Town: [EMAIL:AD_CITY]\r\nState/Province: [EMAIL:AD_STATE_PROVINCE] \r\n\r\nCharges\r\n----------------------------------------------------\r\nBold: [EMAIL:AD_BOLD_CHARGE]\r\nHighlighted: [EMAIL:AD_HIGHLIGHTED_CHARGE]\r\nCategory Featured: [EMAIL:AD_CATEGORY_FEATURED_CHARGE]\r\nGallery Listing: [EMAIL:AD_GALLERY_CHARGE]\r\nImage Preview: [EMAIL:AD_IMAGE_PREVIEW_CHARGE]\r\nHome Page Featured: [EMAIL:AD_HOME_PAGE_CHARGE]\r\nImage Slide Show: [EMAIL:AD_SLIDE_SHOW_CHARGE]\r\nCounter: [EMAIL:AD_COUNTER_CHARGE]\r\nImage One: [EMAIL:AD_IMAGE_ONE_CHARGE]\r\nImage Two: [EMAIL:AD_IMAGE_TWO_CHARGE]\r\nImage Three: [EMAIL:AD_IMAGE_THREE_CHARGE]\r\nImage Four: [EMAIL:AD_IMAGE_FOUR_CHARGE]\r\nImage Five: [EMAIL:AD_IMAGE_FIVE_CHARGE]\r\n\r\n\r\n');

-- --------------------------------------------------------

-- 
-- Table structure for table `templates_gal`
-- 

CREATE TABLE `templates_gal` (
  `id` bigint(200) NOT NULL auto_increment,
  `cat_id` bigint(20) NOT NULL default '0',
  `template` blob,
  `active` tinyint(2) NOT NULL default '0',
  `admin_override` tinyint(2) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `templates_gal`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `templates_items`
-- 

CREATE TABLE `templates_items` (
  `id` bigint(200) NOT NULL auto_increment,
  `cat_id` bigint(20) NOT NULL default '0',
  `template` blob,
  `active` tinyint(2) NOT NULL default '0',
  `admin_override` tinyint(2) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `templates_items`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `templates_newitem`
-- 

CREATE TABLE `templates_newitem` (
  `id` bigint(200) NOT NULL auto_increment,
  `cat_id` bigint(20) NOT NULL default '0',
  `template` blob,
  `active` tinyint(2) NOT NULL default '0',
  `admin_override` tinyint(2) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `templates_newitem`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `templates_pages`
-- 

CREATE TABLE `templates_pages` (
  `page_id` tinyint(3) NOT NULL auto_increment,
  `page_name` varchar(255) default NULL,
  `page_html` text,
  PRIMARY KEY  (`page_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- 
-- Dumping data for table `templates_pages`
-- 

INSERT INTO `templates_pages` VALUES (1, 'help index', 'Put your help content here...');
INSERT INTO `templates_pages` VALUES (6, 'Fees', 'Put your help content here');
INSERT INTO `templates_pages` VALUES (7, 'Terms and Conditions', 'Put your Terms and Conditions here');
INSERT INTO `templates_pages` VALUES (8, 'PowerSearch', '<table class="ft" cellspacing="0" border="0" width="100%">\r\n		<tr>\r\n      		<td class="ct" heigth="31"><strong>Power&nbsp;Search&nbsp;Explanation&nbsp;&nbsp;&nbsp;&nbsp;</strong></td></tr>\r\n      	<tr>\r\n	      	<td >The new "Power Search" box gives you flexibility to find exactly what you are looking for in one search.  \r\n	      	<br>To maximize it''s capabilities please read over the following explanation:  \r\n	      	<br><br>The Power Search field is based on a very simple model similar to Google searches.  You specify words with "modifiers" to get exactly what you are searching for and the Power Search will search the entire Listing for matches.  \r\n	      	<br>The available "modifiers" are: \r\n	      	<hr><b>+</b> The "Plus" sign says that the results <b>must</b> contain the following word \r\n	      	<hr width="25%" align="center"><b>-</b> The "Minus" sign says that the results <b>must NOT</b> contain the following word  \r\n	      	<hr width="25%" align="center"><b>*</b> The "Star" is a <b>Wild Card</b> and will match a partial word \r\n	      	<hr width="25%" align="center"><b>"</b> Putting "Quotes" around a phrase will search for that exact phrase \r\n	      	<hr width="25%" align="center"><b>No Modifier</b> The search will match any listing that contains a word with no modifier\r\n	      	<hr><b>Basic Valid Examples:</b>\r\n	      	<br><i>a b c</i> = Will match any listing that contains a or b or c\r\n	      	<br><i>+a +b +c</i> = Will only match an listing that contain all of a and b and c\r\n	      	<br><i>-a -b +c</i> = Will match any listing that does not contain a or b but does contain c\r\n	      	<br><i>"ab c"</i> = Will match the phrase "ab c"\r\n	      	<br><i>*a "b c"</i> = Will match any listings that have a word that ends in "a" and contains the phrase "b c"\r\n	      	<hr><b>Rules</b>\r\n	      	<br>--Multiple modifiers <b>can</b> be used together in 1 search, Example: <i>+ab c* -defg</i>  is valid\r\n	      	<br>--Individual search terms <b>can not</b> contain more than 1 modifier, Example: <i>+"ab c"</i>  is <b>not</b> valid\r\n	      	</td>\r\n    	</tr>\r\n  	</table>');

-- --------------------------------------------------------

-- 
-- Table structure for table `templates_storefront`
-- 

CREATE TABLE `templates_storefront` (
  `id` bigint(200) NOT NULL auto_increment,
  `cat_id` bigint(20) NOT NULL default '0',
  `template` blob,
  `active` tinyint(2) NOT NULL default '0',
  `admin_override` tinyint(2) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `templates_storefront`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `used_coupons`
-- 

CREATE TABLE `used_coupons` (
  `id` int(20) NOT NULL auto_increment,
  `user_id` int(20) default NULL,
  `coupon_id` int(20) default NULL,
  `date` int(20) NOT NULL default '0',
  `ItemNum` int(20) default NULL,
  `used` tinyint(2) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `used_coupons`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `used_promos`
-- 

CREATE TABLE `used_promos` (
  `id` int(20) NOT NULL auto_increment,
  `user_id` int(20) default NULL,
  `promo_id` int(20) default NULL,
  `date` int(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `used_promos`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `used_subscriptions`
-- 

CREATE TABLE `used_subscriptions` (
  `id` int(20) NOT NULL auto_increment,
  `user_id` int(20) default NULL,
  `date` int(12) default NULL,
  `expires` bigint(255) default NULL,
  `subsc_id` int(20) default NULL,
  `paid` decimal(10,2) default NULL,
  `group` int(20) default NULL,
  `active` tinyint(2) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `used_subscriptions`
-- 

INSERT INTO `used_subscriptions` VALUES (1, 1, 1200240584, 1202832584, 1, '0.00', 1, 1);
INSERT INTO `used_subscriptions` VALUES (2, 1, 1200241045, 1205424584, 1, '0.00', 1, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `used_tokens`
-- 

CREATE TABLE `used_tokens` (
  `id` int(20) NOT NULL auto_increment,
  `user_id` int(20) default NULL,
  `ItemNum` int(20) default NULL,
  `date` int(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `used_tokens`
-- 

INSERT INTO `used_tokens` VALUES (1, 2, 604532037, 1200672059);
INSERT INTO `used_tokens` VALUES (2, 2, 946112158, 1200672165);
INSERT INTO `used_tokens` VALUES (3, 2, 555822266, 1200672274);
INSERT INTO `used_tokens` VALUES (4, 2, 125752357, 1200672364);

-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL auto_increment,
  `first_name` varchar(20) default NULL,
  `last_name` varchar(20) default NULL,
  `user_login` varchar(15) NOT NULL default '',
  `user_password` varchar(15) NOT NULL default '',
  `email` varchar(64) default NULL,
  `country_id` int(11) NOT NULL default '0',
  `state_id` varchar(100) default NULL,
  `city` varchar(30) default NULL,
  `zip` varchar(10) default NULL,
  `address1` varchar(50) default NULL,
  `address2` varchar(50) default NULL,
  `phone_day` varchar(20) default NULL,
  `phone_evn` varchar(20) default NULL,
  `fax` varchar(20) default NULL,
  `age` int(11) default NULL,
  `gender` int(11) default NULL,
  `education` int(11) default NULL,
  `income` int(11) default NULL,
  `date_created` int(12) default NULL,
  `agreement_id` int(11) default NULL,
  `ip_insert` varchar(50) default NULL,
  `ip_update` varchar(50) default NULL,
  `balance` decimal(10,2) default NULL,
  `status` int(11) default '0',
  `code` varchar(20) default NULL,
  `verified` tinyint(4) default NULL,
  `posts` int(11) default '0',
  `newsletter` tinyint(4) default '0',
  `newstype` tinyint(4) default '0',
  `promocode` varchar(25) default NULL,
  `tokens` int(20) default '0',
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `user_login` (`user_login`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `users`
-- 

INSERT INTO `users` VALUES (1, 'Subrata', 'Das', 'subrata', 'subrata', 'subrata2006das@yahoo.com', 1, 'dfg', 'dfgsdg', '452435', 'dfgsfdg', NULL, NULL, NULL, NULL, 3, 1, 0, 0, 1198514064, 1, '59.93.166.101', '59.93.166.101', NULL, 1, NULL, NULL, 0, 1, 0, NULL, 0);
INSERT INTO `users` VALUES (2, 'Demo', 'Demo', 'userdemo', 'userdemo', 'demo@malaremarket', 1, 'Cal', 'Cal', '6546', '123 daught St', NULL, NULL, NULL, NULL, 4, 1, 1, 2, 1200671619, 1, '59.93.221.156', '59.93.221.156', NULL, 1, NULL, NULL, 0, 1, 0, NULL, 16);

-- --------------------------------------------------------

-- 
-- Table structure for table `watchlist`
-- 

CREATE TABLE `watchlist` (
  `watch_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) unsigned default NULL,
  `itemID` varchar(255) default NULL,
  `ItemTitle` varchar(255) default NULL,
  PRIMARY KEY  (`watch_id`),
  UNIQUE KEY `wlNum` (`watch_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `watchlist`
-- 

