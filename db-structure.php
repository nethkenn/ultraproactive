/*      

-- DATABASE VERSION 1.1

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `rel_product_type`;
CREATE TABLE `rel_product_type` (
  `product_id` int(11) NOT NULL,
  `product_type_id` int(11) NOT NULL,
  KEY `product_id` (`product_id`),
  KEY `product_type_id` (`product_type_id`),
  CONSTRAINT `rel_product_type_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rel_product_type_ibfk_4` FOREIGN KEY (`product_type_id`) REFERENCES `tbl_product_type` (`product_type_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tblmarvin`;
CREATE TABLE `tblmarvin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text NOT NULL,
  `Position` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_cms`;
CREATE TABLE `tbl_cms` (
  `cms_id` int(11) NOT NULL AUTO_INCREMENT,
  `cms_name` varchar(250) NOT NULL,
  `cms_address` varchar(250) NOT NULL,
  `cms_contact` int(11) NOT NULL,
  PRIMARY KEY (`cms_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_customer`;
CREATE TABLE `tbl_customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(50) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `customer_email` varchar(50) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `customer_password` text CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `customer_province_id` int(11) NOT NULL,
  `customer_city_id` int(11) NOT NULL,
  `customer_barangay_id` int(11) NOT NULL,
  `customer_address` varchar(300) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `customer_contact` varchar(20) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `customer_gender` varchar(6) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `customer_birthday` date NOT NULL,
  `customer_registration_ip` int(11) NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_location`;
CREATE TABLE `tbl_location` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `location_name` varchar(255) NOT NULL,
  `location_parent` int(11) NOT NULL,
  `level_type` varchar(100) NOT NULL,
  `location_shipping_fee` double NOT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_order`;
CREATE TABLE `tbl_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_or` varchar(100) NOT NULL,
  `order_by` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `order_payment_type` varchar(100) NOT NULL,
  `order_subtotal` double NOT NULL,
  `order_total` double NOT NULL,
  `order_item_count` int(11) NOT NULL,
  `order_shipping_fee` double NOT NULL,
  `order_tax` double NOT NULL,
  `order_sent` tinyint(4) NOT NULL DEFAULT '0',
  `order_paid` tinyint(4) NOT NULL DEFAULT '0',
  `order_new` tinyint(4) NOT NULL DEFAULT '1',
  `shipping_status` varchar(20) NOT NULL DEFAULT 'pending',
  `order_ip` varchar(20) NOT NULL,
  `order_payment_status` varchar(250) NOT NULL DEFAULT 'Unpaid Yet',
  `order_shipping_method` varchar(250) NOT NULL DEFAULT 'Under Confirmation',
  `order_shipping_status` varchar(250) NOT NULL DEFAULT 'Under Confirmation',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_order_product`;
CREATE TABLE `tbl_order_product` (
  `product_id` int(11) NOT NULL,
  `variation_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `total` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `discount` double NOT NULL,
  `price` double NOT NULL,
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  KEY `variation_id` (`variation_id`),
  CONSTRAINT `tbl_order_product_ibfk_4` FOREIGN KEY (`order_id`) REFERENCES `tbl_order` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_order_product_ibfk_5` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_order_product_ibfk_6` FOREIGN KEY (`variation_id`) REFERENCES `tbl_product_variation` (`variation_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_order_shipping`;
CREATE TABLE `tbl_order_shipping` (
  `shipping_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `shipping_name` varchar(100) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `shipping_province` int(11) NOT NULL,
  `shipping_municipality` int(11) NOT NULL,
  `shipping_barangay` int(11) NOT NULL,
  `shipping_address` text CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `shipping_contact` varchar(20) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  PRIMARY KEY (`shipping_id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `tbl_order_shipping_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `tbl_order` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_product`;
CREATE TABLE `tbl_product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(250) NOT NULL,
  `product_description` text NOT NULL,
  `product_detail` longtext NOT NULL,
  `product_tags` text NOT NULL,
  `product_main_image` varchar(300) NOT NULL,
  `product_images` text NOT NULL,
  `product_brand_id` int(11) NOT NULL,
  `product_active` tinyint(4) NOT NULL DEFAULT '1',
  `product_featured` tinyint(4) NOT NULL DEFAULT '0',
  `product_collection` tinyint(4) NOT NULL,
  `product_rating` double NOT NULL,
  `product_views` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `product_brand_id` (`product_brand_id`),
  CONSTRAINT `tbl_product_ibfk_2` FOREIGN KEY (`product_brand_id`) REFERENCES `tbl_product_brand` (`brand_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_product_attribute`;
CREATE TABLE `tbl_product_attribute` (
  `attribute_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `attribute_name` varchar(200) NOT NULL,
  PRIMARY KEY (`attribute_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `tbl_product_attribute_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_product_attribute_option`;
CREATE TABLE `tbl_product_attribute_option` (
  `option_id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_id` int(11) NOT NULL,
  `option_name` varchar(250) NOT NULL,
  PRIMARY KEY (`option_id`),
  KEY `attribute_id` (`attribute_id`),
  CONSTRAINT `tbl_product_attribute_option_ibfk_3` FOREIGN KEY (`attribute_id`) REFERENCES `tbl_product_attribute` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_product_brand`;
CREATE TABLE `tbl_product_brand` (
  `brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(250) NOT NULL,
  PRIMARY KEY (`brand_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_product_collection`;
CREATE TABLE `tbl_product_collection` (
  `collection_id` int(11) NOT NULL AUTO_INCREMENT,
  `collection_name` varchar(250) NOT NULL,
  `collection_description` longtext NOT NULL,
  PRIMARY KEY (`collection_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_product_comment`;
CREATE TABLE `tbl_product_comment` (
  `product_comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_comment` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`product_comment_id`),
  KEY `product_id` (`product_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `tbl_product_comment_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`product_id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_product_comment_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `tbl_customer` (`customer_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_product_images`;
CREATE TABLE `tbl_product_images` (
  `product_id` int(11) NOT NULL,
  `product_image` varchar(100) NOT NULL,
  KEY `product_id` (`product_id`),
  CONSTRAINT `tbl_product_images_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_product_rating`;
CREATE TABLE `tbl_product_rating` (
  `product_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_rating` double NOT NULL DEFAULT '0',
  KEY `product_id` (`product_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `tbl_product_rating_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`product_id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_product_rating_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `tbl_customer` (`customer_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_product_tag`;
CREATE TABLE `tbl_product_tag` (
  `product_tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_tag_name` varchar(100) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`product_tag_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `tbl_product_tag_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_product_type`;
CREATE TABLE `tbl_product_type` (
  `product_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_type_parent_id` int(11) NOT NULL DEFAULT '0',
  `product_type_name` varchar(250) NOT NULL,
  `product_type_slug` varchar(250) NOT NULL,
  `product_type_thumbnail` varchar(100) NOT NULL DEFAULT 'default.jpg',
  `product_type_archive` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_product_variation`;
CREATE TABLE `tbl_product_variation` (
  `variation_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `variation_attribute` varchar(100) NOT NULL DEFAULT 'Simple Product',
  `variation_image` varchar(100) NOT NULL DEFAULT 'default.jpg',
  `variation_price` double NOT NULL,
  `variation_price_compare` double NOT NULL,
  `variation_sku` varchar(250) NOT NULL,
  `variation_barcode` varchar(250) NOT NULL,
  `variation_stock_qty` int(11) NOT NULL,
  `variation_weight` double NOT NULL,
  PRIMARY KEY (`variation_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `tbl_product_variation_ibfk_5` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_registration`;
CREATE TABLE `tbl_registration` (
  `registration_id` int(11) NOT NULL AUTO_INCREMENT,
  `registration_first_name` varchar(250) NOT NULL,
  `registration_last_name` varchar(250) NOT NULL,
  `registration_month` int(2) NOT NULL,
  `registration_day` int(2) NOT NULL,
  `registration_year` int(4) NOT NULL,
  `registration_male` varchar(50) NOT NULL,
  `registration_female` varchar(50) NOT NULL,
  `registration_address` varchar(250) NOT NULL,
  `registration_email` varchar(250) NOT NULL,
  `registration_contact` int(11) NOT NULL,
  `registration_password` varchar(250) NOT NULL,
  `registration_repeat` varchar(250) NOT NULL,
  PRIMARY KEY (`registration_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_sample`;
CREATE TABLE `tbl_sample` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sample_name` text NOT NULL,
  `sample_username` text NOT NULL,
  `sample_password` text NOT NULL,
  `sample_favorite` text NOT NULL,
  `sample_hobby` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_slider_image`;
CREATE TABLE `tbl_slider_image` (
  `slider_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `slider_image_name` varchar(100) NOT NULL,
  PRIMARY KEY (`slider_image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_subscribe`;
CREATE TABLE `tbl_subscribe` (
  `subscribe_id` int(11) NOT NULL AUTO_INCREMENT,
  `subscribe_email` varchar(50) NOT NULL,
  PRIMARY KEY (`subscribe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbl_user_inquiry`;
CREATE TABLE `tbl_user_inquiry` (
  `inquiry_id` int(11) NOT NULL AUTO_INCREMENT,
  `from_fname` varchar(32) NOT NULL,
  `from_lname` varchar(32) NOT NULL,
  `from_email` varchar(32) NOT NULL,
  `from_contact_num` varchar(32) NOT NULL,
  `from_subject` varchar(32) NOT NULL,
  `from_message` text NOT NULL,
  `to_email` varchar(32) NOT NULL,
  `to_name` varchar(32) NOT NULL,
  `time_sent` datetime NOT NULL,
  `replied` tinyint(4) NOT NULL DEFAULT '0',
  `archived` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`inquiry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

*/