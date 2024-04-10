-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 21, 2024 at 06:29 PM
-- Server version: 5.7.23-23
-- PHP Version: 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `collesgr_ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `address_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(300) DEFAULT NULL,
  `last_name` varchar(300) DEFAULT NULL,
  `cityname` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `pincode` int(11) DEFAULT NULL,
  `email` varchar(300) DEFAULT NULL,
  `number` bigint(20) DEFAULT NULL,
  `address1` text,
  `adress2` text,
  `is_delte` tinyint(1) NOT NULL DEFAULT '0',
  `lat` text,
  `lng` text,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatd_dare` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `area_id` int(11) NOT NULL,
  `city_id` int(11) DEFAULT NULL,
  `areaname` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attribute`
--

CREATE TABLE `attribute` (
  `attribute_id` int(11) NOT NULL,
  `attribute_name` varchar(200) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attribute`
--

INSERT INTO `attribute` (`attribute_id`, `attribute_name`, `product_id`) VALUES
(7, 'Color', 1),
(8, 'Size', 1),
(9, 'Color', 12),
(10, 'Size', 13);

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `banner_id` int(11) NOT NULL,
  `banner_title` varchar(300) DEFAULT NULL,
  `banner_subtitle` varchar(255) DEFAULT NULL,
  `description` text,
  `urrl` varchar(250) DEFAULT NULL,
  `type` varchar(250) DEFAULT NULL,
  `orderby` int(11) DEFAULT NULL,
  `image` text,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`banner_id`, `banner_title`, `banner_subtitle`, `description`, `urrl`, `type`, `orderby`, `image`, `created_date`, `updated_date`) VALUES
(1, 'Hi-Res Audio Wireless Over Ear Headphones ', '30 hours time or talk time', '<p>ONLY :$89.99</p>\r\n', 'http://localhost/ecommerce/', 'banner', 1, '1709960431_7d25f0cb09270e39f7f6.jpg', '2024-03-09 10:30:31', '2024-03-09 10:30:31'),
(2, 'Hi-Res Audio Wireless Over Ear Headphones', 'Hi-Res Audio Wireless Over Ear Headphones', '', 'http://localhost/ecommerce//admin/Banner', 'banner', 2, '1710136279_4237e41270a0ede1ea72.jpg', '2024-03-11 11:21:19', '2024-03-11 11:21:19');

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `blog_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` text COLLATE utf8_unicode_ci,
  `message` text COLLATE utf8_unicode_ci,
  `category` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8_unicode_ci,
  `date` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brands_id` int(11) NOT NULL,
  `brands_name` varchar(200) DEFAULT NULL,
  `images` text,
  `status` int(11) DEFAULT NULL,
  `display_in_home` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brands_id`, `brands_name`, `images`, `status`, `display_in_home`, `created_date`, `updated_date`) VALUES
(1, 'Sony', '1709722611_76eedd1ab23b59f211cb.png', 1, NULL, '2024-03-06 16:26:51', '2024-03-06 16:26:51'),
(2, 'SAMSUNG', '1709722837_61bcba8fa4ee63392e8c.jpg', 1, NULL, '2024-03-06 16:30:37', '2024-03-06 16:30:37'),
(3, 'VIVO', '1710148815_f4370bd09d6853cc26fe.png', 1, NULL, '2024-03-11 14:50:15', '2024-03-11 14:50:15'),
(4, 'MI', '1710148825_70be9d6c4c7a588b42d3.png', 1, NULL, '2024-03-11 14:50:25', '2024-03-11 14:50:25'),
(5, 'ROG', '1710148857_9ce09f28a99c579d68c1.webp', 1, NULL, '2024-03-11 14:50:57', '2024-03-11 14:50:57'),
(6, 'APPLE', '1710153871_6a5acfed40f498e0b88a.png', 1, NULL, '2024-03-11 14:53:59', '2024-03-11 14:53:59'),
(7, 'Realme', '1710153729_66c022055ba10a0b0b42.png', 1, NULL, '2024-03-11 16:12:09', '2024-03-11 16:12:09');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `cat_img` text,
  `type` int(10) DEFAULT NULL COMMENT '1=labtest, 2=ecommerce',
  `status` int(11) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `cat_name`, `parent_id`, `cat_img`, `type`, `status`, `created_date`) VALUES
(1, 'TV', 0, '1709723077_7f4b33bd802fb2bf84d3.jpeg', 1, 1, '2024-03-06 11:04:37'),
(2, 'Mobiles', 0, '1709961198_22914ddf66ddd4fe42b6.jpg', 1, 1, '2024-03-09 05:13:18'),
(3, 'Mobile Accessories', 0, '1709961322_b1774dbfdd4afe509a53.jpg', 1, 1, '2024-03-09 05:15:22'),
(4, 'laptop', 0, '1709961438_a4794c29060f31a9e909.jpg', 1, 1, '2024-03-09 05:17:18'),
(5, 'desktop', 0, '1709961548_7fc99f8df9fe6121f5ee.jpg', 1, 1, '2024-03-09 05:19:08'),
(6, 'Smart Watch   ', 0, '1710137452_82dd237168d133d45e69.jpg', 1, 1, '2024-03-11 06:06:08'),
(7, 'Refrigerator  ', 0, '1710140302_cc8214446de269f602c1.jpg', 1, 1, '2024-03-11 06:06:08'),
(8, 'Washing Machine  ', 0, '1710140381_e522a0fcee18cbda3b47.jpg', 1, 1, '2024-03-11 06:06:08'),
(9, 'Tablate', 0, '1710140734_48f27410bb8a291cf004.jpg', 1, 1, '2024-03-11 07:05:34'),
(10, 'Gaming smartphones  ', 2, '1710147283_082d186a5ec894c499a5.webp', 1, 1, '2024-03-11 08:52:11'),
(11, '5G smartphones', 2, '1710147408_d2586313216b50b2ab3e.webp', 1, 1, '2024-03-11 08:56:48'),
(12, 'Feature phones', 2, '1710147587_544d2ab99de30e9e2b7b.webp', 1, 1, '2024-03-11 08:59:47'),
(13, 'ROG', 10, '1710147928_a61733df8625bebe3590.jpg', 1, 1, '2024-03-11 09:05:28');

-- --------------------------------------------------------

--
-- Table structure for table `center_gallery`
--

CREATE TABLE `center_gallery` (
  `center_gallery_id` int(11) NOT NULL,
  `cente_image` text,
  `center_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `center_test`
--

CREATE TABLE `center_test` (
  `center_test_id` int(11) NOT NULL,
  `center_id` int(11) DEFAULT NULL,
  `test_id` int(11) DEFAULT NULL,
  `regular_price` double DEFAULT NULL,
  `sales_price` double NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `city_id` int(11) NOT NULL,
  `city_name` varchar(200) DEFAULT NULL,
  `state_id` int(10) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`city_id`, `city_name`, `state_id`, `status`, `created_date`, `updated_date`) VALUES
(1, 'Bhubaneswar', 1, NULL, '2024-03-07 15:34:01', '2024-03-07 15:34:01');

-- --------------------------------------------------------

--
-- Table structure for table `cms`
--

CREATE TABLE `cms` (
  `id` int(11) NOT NULL,
  `page_name` varchar(300) DEFAULT NULL,
  `details` text,
  `image` text,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `iframe` text,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `page_title` varchar(250) DEFAULT NULL,
  `page_keyword` varchar(250) DEFAULT NULL,
  `page_description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms`
--

INSERT INTO `cms` (`id`, `page_name`, `details`, `image`, `address`, `phone`, `email`, `iframe`, `created_date`, `updated_date`, `page_title`, `page_keyword`, `page_description`) VALUES
(1, 'Contact Us', '<p>description</p>\r\n', '1710147377_e75615cebaf5761ea5fc.jpg', 'Bhubaneswar, Odisha', '9876543210', 'info@bigtech.com', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3742.029772394157!2d85.82607508447695!3d20.29903476391665!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a19a0ad398d0a59%3A0x43fb0f35c1f39366!2sSyflex%20Techno%20Solution%20Pvt.%20Ltd.%20Software%20Mobile%20App%20Development%20Company!5e0!3m2!1sen!2sus!4v1710148189273!5m2!1sen!2sus\" width=\"100%\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '2024-02-20 08:48:52', '2024-02-20 08:48:52', NULL, NULL, NULL),
(2, 'Home', '<p>home</p>\r\n', '', NULL, NULL, NULL, NULL, '2024-02-20 08:49:37', '2024-02-20 08:49:37', 'Big tech |Home', 'Big tech |Home', 'Big tech |Home'),
(3, 'Abouut Us', '<p>Abouut Us</p>\r\n', '1710151864_3b390ab976a0b08fef20.jpg', NULL, NULL, NULL, NULL, '2024-03-11 15:41:04', '2024-03-11 15:41:04', 'Abouut Us', 'Abouut Us', 'Abouut Us'),
(4, 'Privacypolicy', '<p>Privacypolicy</p>\r\n', '1710152156_d918192370e10352dcaf.jpg', NULL, NULL, NULL, NULL, '2024-03-11 15:45:56', '2024-03-11 15:45:56', 'Privacypolicy', 'Privacypolicy', 'Privacypolicy'),
(5, 'Term And Condition', '<p>Term And Condition</p>\r\n', '1710152218_e55fbcdde8de2bc2a772.jpg', NULL, NULL, NULL, NULL, '2024-03-11 15:46:58', '2024-03-11 15:46:58', 'Term And Condition', 'Term And Condition', 'Term And Condition'),
(6, 'FAQ', '<p>FAQ</p>\r\n', '1710152310_e656f16c2bc8e435f914.jpg', NULL, NULL, NULL, NULL, '2024-03-11 15:48:30', '2024-03-11 15:48:30', 'FAQ', 'FAQ', 'FAQ');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_code`
--

CREATE TABLE `coupon_code` (
  `coupon_code_id` int(11) NOT NULL,
  `name` varchar(300) DEFAULT NULL,
  `img` text,
  `code` varchar(300) DEFAULT NULL,
  `no_of_use_user` int(11) DEFAULT NULL,
  `discount_type` int(11) DEFAULT NULL COMMENT '1-flat,2-%',
  `discount_value` double DEFAULT NULL,
  `valid_uo_to` date DEFAULT NULL,
  `used_up_to` int(11) DEFAULT NULL,
  `price_cart` double NOT NULL DEFAULT '0',
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coupon_code`
--

INSERT INTO `coupon_code` (`coupon_code_id`, `name`, `img`, `code`, `no_of_use_user`, `discount_type`, `discount_value`, `valid_uo_to`, `used_up_to`, `price_cart`, `create_date`, `update_date`) VALUES
(1, 'test1', '1710141136_f2e3227bd9f6fd6d7cb3.jpg', 'test1', 1, 1, 5, '2024-03-06', 5, 500, '2024-03-05 16:48:52', '2024-03-05 16:48:52'),
(2, 'test2', '1710141185_bb658cbb1c539eaa50b8.jpg', 'test2', 10, 1, 500, '2024-11-30', 10, 2000, '2024-03-11 12:43:05', '2024-03-11 12:43:05'),
(3, 'Test3', '1710141231_4e0cebd02366c5ec295a.jpg', 'Test3', 10, 2, 2, '2024-08-24', 20, 5000, '2024-03-11 12:43:51', '2024-03-11 12:43:51'),
(4, 'test4', '1710141320_56163ad91014ed165692.jpg', '123654', 20, 2, 10, '2025-04-11', 20, 5000, '2024-03-11 12:45:20', '2024-03-11 12:45:20'),
(5, 'test5', '1710141386_7034ef97d0ff86280e76.jpg', '123658', 1, 1, 2000, '2025-09-12', 25, 500, '2024-03-11 12:46:26', '2024-03-11 12:46:26');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `gallery_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `image` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`gallery_id`, `product_id`, `image`) VALUES
(1, 1, '1709797342_5399dc3cae1a00d94ca7.bin'),
(2, 1, '1709798005_0262f30e9a7237a0d126.bin'),
(3, 7, '1710148584_46c1ff697313d90bd28d.jpg'),
(4, 7, '1710148584_1a513dbe4f013a775f7f.jpg'),
(5, 7, '1710148584_ac5e5c9b86b3b859aeda.jpg'),
(6, 7, '1710148584_17a5191d8a43d62e1b15.jpg'),
(7, 7, '1710148584_60a9142b8503bfb86a14.jpg'),
(8, 7, '1710148584_797d2e7c9385a75111b2.jpg'),
(9, 8, '1710149284_e23391b653063d493c1f.jpg'),
(10, 8, '1710149284_372d56571de41973e57f.jpg'),
(11, 8, '1710149284_2a3496c702d48beaa048.jpg'),
(12, 8, '1710149284_118ae1f5ae32fb116b79.jpg'),
(13, 8, '1710149284_e8a3e2992ced00fd0623.jpg'),
(14, 8, '1710149465_138749b6cae6e057c30c.jpg'),
(15, 8, '1710149465_48562f6a14848e195c2b.jpg'),
(16, 8, '1710149465_08cca66bff37d4a1115c.jpg'),
(17, 8, '1710149465_6902f8276397e3076aab.jpg'),
(18, 8, '1710149465_6e1f8ac799f5a7179e18.jpg'),
(19, 9, '1710149597_988b9e1e51eda0aaabd7.jpg'),
(20, 9, '1710149597_8a179252d492593df016.jpg'),
(21, 9, '1710149597_03569b1cf4633d841f42.jpg'),
(22, 9, '1710149597_019a1425cb043cc31403.jpg'),
(23, 9, '1710149597_fad23ef835f591a896d6.jpg'),
(24, 10, '1710149794_eb833bb27e71900c1fed.jpg'),
(25, 10, '1710149794_34eab96896c1e9faf49c.jpg'),
(26, 10, '1710149794_d86ac54edfdf5c1f8145.jpg'),
(27, 10, '1710149794_9b1011e146f49c82516c.jpg'),
(28, 10, '1710149794_12e5e5946a7862f76779.jpg'),
(29, 9, '1710150930_f7d559f023f1c2580930.jpg'),
(30, 9, '1710150930_37df4483a2a57be655c2.jpg'),
(31, 9, '1710150930_9e76149189b79b742492.jpg'),
(32, 9, '1710150930_9aafd8241b6519d61449.jpg'),
(33, 9, '1710150930_86edc7a0c9e444cc7e1c.jpg'),
(34, 9, '1710150930_e191038b6d43e2a5f96f.jpg'),
(35, 9, '1710154024_79eb0e0767c5b7cff60e.jpg'),
(36, 9, '1710154024_bc6b6ecdb7e253e34be0.jpg'),
(37, 9, '1710154024_edc5958aeefc57e2d17b.jpg'),
(38, 9, '1710154024_cff4dfed6c8cdeb08e7f.jpg'),
(39, 9, '1710154024_71818bb3d346d11d8e75.jpg'),
(40, 10, '1710154450_54cab262feea6ebe743a.jpg'),
(41, 10, '1710154450_09544d3669ae9e59341d.jpg'),
(42, 10, '1710154450_e6cc3da391e2ed832975.jpg'),
(43, 10, '1710154450_92e75a1c7a3081072374.jpg'),
(44, 10, '1710154450_9b363d5444bd79c37f22.jpg'),
(45, 10, '1710154450_0af2fdd9544a9d3a4d20.jpg'),
(46, 7, '1710154830_866bfef36d0224a8d371.jpg'),
(47, 7, '1710154830_0b86e3c0952ac83cfefe.jpg'),
(48, 7, '1710154830_f826a3ac88b4aa80a9dc.jpg'),
(49, 7, '1710154830_28feefbf9e9aa936fce7.jpg'),
(50, 7, '1710154830_f8693a22aa8437d9e932.jpg'),
(51, 7, '1710154830_e5c3e6560a64d24f6cae.jpg'),
(52, 7, '1710154830_52a64139b4f2ff2394ad.jpg'),
(53, 11, '1710155284_5fb62717b4793b206196.webp'),
(54, 11, '1710155284_f34bc5b1077a74001dcc.webp'),
(55, 11, '1710155284_410d878393fe2a7a400d.webp'),
(56, 11, '1710155284_e78076646b6894194758.webp'),
(57, 11, '1710155284_600f728e3ceb9c919ecc.webp'),
(58, 12, '1710226144_ef870d62392cbbafc324.jpeg'),
(59, 13, '1710226694_4e9ced2b126d7eaf01ae.jpeg'),
(60, 13, '1710226738_d3f69b2d4f9454bc0192.jpeg'),
(61, 13, '1710227106_dfac3571c5f8ffd67545.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orders_id` int(11) NOT NULL,
  `productname` varchar(300) DEFAULT NULL,
  `variation_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `img` varchar(400) DEFAULT NULL,
  `price` decimal(11,2) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `shipping_type` varchar(200) DEFAULT NULL,
  `shipping_charge` decimal(11,2) DEFAULT NULL,
  `order_id` varchar(200) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  `payment_mode` varchar(200) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0=New order 1=processing order  2=Completed Order 3=Canceled Order 4=Out of Delivery  5=order delivered',
  `reason` text,
  `wallet` double NOT NULL DEFAULT '0',
  `txn_id` varchar(300) DEFAULT NULL,
  `coupon_code` varchar(300) DEFAULT NULL,
  `coupon_amnt` varchar(100) NOT NULL DEFAULT '0',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pincode`
--

CREATE TABLE `pincode` (
  `pin_id` int(11) NOT NULL,
  `state_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `pincode` int(11) DEFAULT NULL,
  `status` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pincode`
--

INSERT INTO `pincode` (`pin_id`, `state_id`, `city_id`, `pincode`, `status`, `created_date`, `updated_date`) VALUES
(1, 1, 1, 752054, NULL, '2024-03-07 15:34:23', '2024-03-07 15:34:23');

-- --------------------------------------------------------

--
-- Table structure for table `price_varition`
--

CREATE TABLE `price_varition` (
  `price_varition_id` int(11) NOT NULL,
  `variation_value` varchar(100) DEFAULT NULL,
  `regular_price` double DEFAULT NULL,
  `sale_price` double DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `image` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `price_varition`
--

INSERT INTO `price_varition` (`price_varition_id`, `variation_value`, `regular_price`, `sale_price`, `product_id`, `stock`, `vendor_id`, `image`) VALUES
(8, '12,14', 130, 120, 1, NULL, 3, '1709908175_dbad6670fa60a47a6f80.jpg'),
(10, '20', 30000, 28000, 13, NULL, 3, '1710332466_a48114b26f11ab2c2b90.jpeg'),
(11, '21', 30000, 26000, 13, NULL, 3, '1710332504_e0557144f442f8064729.jpeg'),
(13, '22', 30000, 24000, 13, NULL, 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(300) DEFAULT NULL,
  `product_type` int(10) DEFAULT NULL,
  `description` text,
  `brands_id` int(10) DEFAULT NULL,
  `primary_image` text,
  `regular_price` int(11) DEFAULT NULL,
  `sales_price` int(11) DEFAULT NULL,
  `category` varchar(111) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `prodType` int(11) DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `approve` int(11) DEFAULT '0' COMMENT '0= not approve 1=approve',
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_type`, `description`, `brands_id`, `primary_image`, `regular_price`, `sales_price`, `category`, `status`, `prodType`, `createdby`, `approve`, `created_date`, `updated_date`) VALUES
(7, 'Apple iPhone 14 (Blue, 128 GB)', 1, '', 6, '1710154830_741dc4221714548dee71.jpg', NULL, NULL, NULL, 1, 0, 1, 1, '2024-03-11 14:42:51', '2024-03-11 14:42:51'),
(8, 'Redmi 13C 5G (Starlight Black, 8GB RAM, 256GB Storage) | MediaTek Dimensity 6100+ 5G | 90Hz Display', 1, '<p><br />\r\nOS&nbsp;&nbsp; &nbsp;&lrm;MIUI 14, Android 13.0<br />\r\nRAM&nbsp;&nbsp; &nbsp;&lrm;256 GB<br />\r\nProduct Dimensions&nbsp;&nbsp; &nbsp;&lrm;16.8 x 7.8 x 0.8 cm; 195 Grams<br />\r\nBatteries&nbsp;&nbsp; &nbsp;&lrm;1 Lithium Polymer batteries required. (included)<br />\r\nWireless communication technologies&nbsp;&nbsp; &nbsp;&lrm;Cellular<br />\r\nConnectivity technologies&nbsp;&nbsp; &nbsp;&lrm;Bluetooth, Wi-Fi, USB<br />\r\nGPS&nbsp;&nbsp; &nbsp;&lrm;GPS/AGPS, Glonass, Beidou, Galileo<br />\r\nSpecial features&nbsp;&nbsp; &nbsp;&lrm;Dual Camera, Gorilla Glass<br />\r\nOther display features&nbsp;&nbsp; &nbsp;&lrm;Wireless<br />\r\nDevice interface - primary&nbsp;&nbsp; &nbsp;&lrm;Touchscreen<br />\r\nOther camera features&nbsp;&nbsp; &nbsp;&lrm;Rear, Front<br />\r\nAudio Jack&nbsp;&nbsp; &nbsp;&lrm;3.5 mm<br />\r\nForm factor&nbsp;&nbsp; &nbsp;&lrm;Bar<br />\r\nColour&nbsp;&nbsp; &nbsp;&lrm;Starlight Black<br />\r\nBattery Power Rating&nbsp;&nbsp; &nbsp;&lrm;5000<br />\r\nWhats in the box&nbsp;&nbsp; &nbsp;&lrm;Power Adapter, SIM Tray Ejector, USB Cable<br />\r\nManufacturer&nbsp;&nbsp; &nbsp;&lrm;Redmi<br />\r\nCountry of Origin&nbsp;&nbsp; &nbsp;&lrm;India<br />\r\nItem Weight&nbsp;&nbsp; &nbsp;&lrm;195 g</p>\r\n', 4, '1710149284_c91ef44d3804699b8067.jpg', NULL, NULL, NULL, 1, 0, 1, 1, '2024-03-11 14:56:10', '2024-03-11 14:56:10'),
(9, 'realme narzo 60X 5G?Stellar Green,6GB,128GB Storage ? Up to 2TB External Memory | 50 MP AI Primary Camera | Segments only 33W Supervooc Charge', 1, '<table>\r\n	<tbody>\r\n		<tr>\r\n			<th>OS</th>\r\n			<td>&lrm;MIUI 14, Android 13.0</td>\r\n		</tr>\r\n		<tr>\r\n			<th>RAM</th>\r\n			<td>&lrm;256 GB</td>\r\n		</tr>\r\n		<tr>\r\n			<th>Product Dimensions</th>\r\n			<td>&lrm;16.8 x 7.8 x 0.8 cm; 195 Grams</td>\r\n		</tr>\r\n		<tr>\r\n			<th>Batteries</th>\r\n			<td>&lrm;1 Lithium Polymer batteries required. (included)</td>\r\n		</tr>\r\n		<tr>\r\n			<th>Wireless communication technologies</th>\r\n			<td>&lrm;Cellular</td>\r\n		</tr>\r\n		<tr>\r\n			<th>Connectivity technologies</th>\r\n			<td>&lrm;Bluetooth, Wi-Fi, USB</td>\r\n		</tr>\r\n		<tr>\r\n			<th>GPS</th>\r\n			<td>&lrm;GPS/AGPS, Glonass, Beidou, Galileo</td>\r\n		</tr>\r\n		<tr>\r\n			<th>Special features</th>\r\n			<td>&lrm;Dual Camera, Gorilla Glass</td>\r\n		</tr>\r\n		<tr>\r\n			<th>Other display features</th>\r\n			<td>&lrm;Wireless</td>\r\n		</tr>\r\n		<tr>\r\n			<th>Device interface - primary</th>\r\n			<td>&lrm;Touchscreen</td>\r\n		</tr>\r\n		<tr>\r\n			<th>Other camera features</th>\r\n			<td>&lrm;Rear, Front</td>\r\n		</tr>\r\n		<tr>\r\n			<th>Audio Jack</th>\r\n			<td>&lrm;3.5 mm</td>\r\n		</tr>\r\n		<tr>\r\n			<th>Form factor</th>\r\n			<td>&lrm;Bar</td>\r\n		</tr>\r\n		<tr>\r\n			<th>Colour</th>\r\n			<td>&lrm;Starlight Black</td>\r\n		</tr>\r\n		<tr>\r\n			<th>Battery Power Rating</th>\r\n			<td>&lrm;5000</td>\r\n		</tr>\r\n		<tr>\r\n			<th>Whats in the box</th>\r\n			<td>&lrm;Power Adapter, SIM Tray Ejector, USB Cable</td>\r\n		</tr>\r\n		<tr>\r\n			<th>Manufacturer</th>\r\n			<td>&lrm;Redmi</td>\r\n		</tr>\r\n		<tr>\r\n			<th>Country of Origin</th>\r\n			<td>&lrm;India</td>\r\n		</tr>\r\n		<tr>\r\n			<th>Item Weight</th>\r\n			<td>&lrm;195 g</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', 7, '1710150930_da3a091d2f666f708dfa.jpg', NULL, NULL, NULL, 1, 0, 1, 1, '2024-03-11 15:02:30', '2024-03-11 15:02:30'),
(10, 'Samsung Galaxy M04 Dark Blue, 4GB RAM, 64GB Storage | Upto 8GB RAM with RAM Plus | MediaTek Helio P35 Octa-core Processor | 5000 mAh Battery | 13MP Dual Camera', 1, '', 2, '1710154582_83745e8a22659ce5942c.jpg', NULL, NULL, NULL, 1, 0, 1, 1, '2024-03-11 15:05:53', '2024-03-11 15:05:53'),
(11, 'ASUS ROG Phone II (Black, 128 GB)  (8 GB RAM)', 1, NULL, NULL, '1710155284_3657525a86ca34e0922d.webp', NULL, NULL, NULL, 1, NULL, 1, 1, '2024-03-11 16:37:06', '2024-03-11 16:37:06'),
(13, '1.08 m CUE60 Crystal 4K UHD Smart TV', 1, '<ul>\r\n	<li>No Cost EMI starts from ? 4580.86/ month.</li>\r\n	<li>PurColor</li>\r\n	<li>Crystal Processor 4K</li>\r\n	<li>Smart Hub</li>\r\n</ul>\r\n', 0, '1710226694_55ea4792d44fc4d6832a.jpeg', NULL, NULL, NULL, 1, 1, 1, 1, '2024-03-12 12:25:41', '2024-03-12 12:25:41');

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `product_category_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`product_category_id`, `product_id`, `category_id`) VALUES
(4, 1, 1),
(9, 3, 1),
(10, 6, 1),
(17, 8, 2),
(18, 8, 11),
(29, 9, 2),
(30, 9, 11),
(41, 11, 2),
(42, 11, 10),
(43, 11, 13),
(44, 10, 2),
(45, 10, 11),
(46, 7, 2),
(47, 7, 11),
(48, 12, 1),
(52, 13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_price`
--

CREATE TABLE `product_price` (
  `product_price_id` int(11) NOT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `regular_price` double DEFAULT NULL,
  `sale_price` double DEFAULT NULL,
  `image` text,
  `vstatus` int(11) NOT NULL DEFAULT '0' COMMENT '0=deactive 1=active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_price`
--

INSERT INTO `product_price` (`product_price_id`, `vendor_id`, `product_id`, `regular_price`, `sale_price`, `image`, `vstatus`) VALUES
(3, 3, 7, 100000, 67000, '1710156461_017563c6ad4f72d82f69.jpg', 1),
(4, 3, 8, 30000, 26000, '1710156516_7265e50e37494b391fd5.jpg', 1),
(5, 3, 9, 30000, 27000, '1710156577_7fcdc68581cd6d664ae8.jpg', 1),
(6, 3, 10, 50000, 37000, '1710156667_a0e9bd29b772e2d77561.jpg', 1),
(8, 4, 7, 30000, 24000, '1710157779_ee30ff7896b2e56759f0.jpg', 1),
(9, 4, 8, 32000, 25999, '1710157840_e7eaac00e36f70ccc59b.jpg', 1),
(10, 4, 9, 37999, 32999, '1710157887_3e83ba1d866d7c6d16ef.jpg', 1),
(11, 4, 10, 13000, 10999, '1710157933_c4f8eb412b190ab29347.jpg', 1),
(12, 4, 11, 77899, 67899, '1710157972_64147e00f88cf54719eb.webp', 1),
(13, 3, 13, 30000, 25000, '1710332422_748ef8821555b7dab7c1.jpeg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `settingg`
--

CREATE TABLE `settingg` (
  `settingg_id` int(11) NOT NULL,
  `logo` text,
  `login_img` text,
  `title` varchar(300) DEFAULT NULL,
  `tagline` varchar(300) DEFAULT NULL,
  `description` text,
  `facebook` text,
  `tweeter` text,
  `google` text,
  `linkdin` text,
  `instagram` text,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settingg`
--

INSERT INTO `settingg` (`settingg_id`, `logo`, `login_img`, `title`, `tagline`, `description`, `facebook`, `tweeter`, `google`, `linkdin`, `instagram`, `created_date`, `updated_date`) VALUES
(1, '1708398050_9ac3878606efb5ec9b51.png', NULL, 'Ecommerce', 'Bigtech', '', '', '', '', '', '', '2024-02-20 08:29:05', '2024-02-20 08:29:05');

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE `shipping` (
  `shipping_id` int(11) NOT NULL,
  `name` varchar(300) DEFAULT NULL,
  `price` double NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `state_id` int(10) NOT NULL,
  `state_name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state_status` int(10) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`state_id`, `state_name`, `state_status`, `created_date`, `updated_date`) VALUES
(1, 'Odisha', NULL, '2024-03-05 16:52:16', '2024-03-05 16:52:16'),
(2, 'Andhra Pradesh', NULL, '2024-03-05 16:53:52', '2024-03-05 16:53:52');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `test_id` int(11) NOT NULL,
  `test_name` varchar(300) DEFAULT NULL,
  `description` text,
  `primary_image` text,
  `regular_price` int(11) DEFAULT NULL,
  `sales_price` int(11) DEFAULT NULL,
  `category_1` varchar(111) DEFAULT NULL,
  `type` int(10) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `full_name` varchar(200) DEFAULT NULL,
  `user_name` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `contact_no` bigint(20) DEFAULT NULL,
  `gender` int(11) DEFAULT NULL COMMENT '1=male 2=FeMale',
  `alter_cnum` bigint(20) DEFAULT NULL,
  `profile_image` text,
  `center_name` varchar(200) DEFAULT NULL,
  `details` text,
  `center_redg_proof` text,
  `gst` varchar(255) DEFAULT NULL,
  `gst_image` text,
  `adhar_font` text,
  `adhar_back` text,
  `adhar_no` varchar(255) DEFAULT NULL,
  `user_type` int(11) DEFAULT NULL COMMENT '1=admin 2=subadmin 3=vendor  4=Customer ',
  `city_id` int(11) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL,
  `state_id` int(10) DEFAULT NULL,
  `pin` varchar(255) DEFAULT NULL,
  `address1` varchar(200) DEFAULT NULL,
  `address2` varchar(200) DEFAULT NULL,
  `commition` double DEFAULT NULL,
  `banner_image` text,
  `logo_image` text,
  `hygene` int(100) DEFAULT NULL,
  `accies_type` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `reasone` text,
  `wallet` double NOT NULL DEFAULT '0',
  `otp` int(11) DEFAULT NULL,
  `lat` text,
  `lng` text,
  `roles` text,
  `account_details` varchar(250) DEFAULT NULL,
  `benef_name` varchar(250) DEFAULT NULL,
  `merchant_agrrement` varchar(250) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `full_name`, `user_name`, `password`, `email`, `contact_no`, `gender`, `alter_cnum`, `profile_image`, `center_name`, `details`, `center_redg_proof`, `gst`, `gst_image`, `adhar_font`, `adhar_back`, `adhar_no`, `user_type`, `city_id`, `area_id`, `state_id`, `pin`, `address1`, `address2`, `commition`, `banner_image`, `logo_image`, `hygene`, `accies_type`, `status`, `reasone`, `wallet`, `otp`, `lat`, `lng`, `roles`, `account_details`, `benef_name`, `merchant_agrrement`, `created_date`, `updated_date`) VALUES
(1, 'admin', 'admin', 'Y0dGemMzZHZjbVE9', '1984samirsahoo@gmail.com', 9658437202, NULL, NULL, '1708398015_09ea56fb4dd1df00d07f.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-02-20 07:59:35', '2024-02-20 07:59:35'),
(2, 'subadmin', 'subadmin', 'YzNWaVlXUnRhVzQ9', 'subadmin@gmail.com', 9685749685, NULL, NULL, '1708398263_eca3c011580f1fa2ffa1.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-02-20 08:34:23', '2024-02-20 08:34:23'),
(3, 'rajeswar1', 'rajeswar', 'Y21GcVpYTjNZWEk9', 'rajeswar@gmail.com', 8118036778, NULL, 8118036778, '1709805970_3aca94a61d98a8eee55a.jpg', NULL, '', NULL, NULL, NULL, '1709805970_e3ea07218b9a0af4a16f.jpg', '1709805970_3cae3bb17fee54d2055d.jpg', '123456789654', 3, 1, NULL, 1, NULL, 'saheed nagar', 'b6', NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-03-07 15:36:10', '2024-03-07 15:36:10'),
(4, 'dibyajyoti', 'dibyajyoti', 'WkdsaWVXRnFlVzkwYVE9PQ==', 'dibyajyoti@gmail.com', 9658438525, NULL, 9658438525, '1710156844_33d1d7fbf36e775d2aae.png', NULL, NULL, NULL, NULL, NULL, '1710156844_52ae72e88573f33821a1.png', '1710156844_a07312c373ae3857bca3.png', '123654789658', 3, 1, NULL, 1, '1', 'Saheednagar', 'megdoot', NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-03-11 17:04:04', '2024-03-11 17:04:04'),
(5, 'sunita Sahoo', 'sunita', 'YzNWdWFYUmg=', 'sunita@gmail.com', 9685968596, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-03-12 07:17:31', '2024-03-12 07:17:31');

-- --------------------------------------------------------

--
-- Table structure for table `variation`
--

CREATE TABLE `variation` (
  `variation_id` int(11) NOT NULL,
  `variation_name` varchar(300) DEFAULT NULL,
  `variation_price` varchar(255) NOT NULL,
  `attribute_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `variation`
--

INSERT INTO `variation` (`variation_id`, `variation_name`, `variation_price`, `attribute_id`, `product_id`) VALUES
(12, 'Red ', '', 7, 1),
(13, ' Green ', '', 7, 1),
(14, 'L', '', 8, 1),
(15, 'M', '', 8, 1),
(16, 'S', '', 8, 1),
(17, 'RED', '', 9, 12),
(18, 'GREEN', '', 9, 12),
(19, 'BLUE', '', 9, 12),
(20, '32', '', 10, 13),
(21, '26', '', 10, 13),
(22, '24', '', 10, 13);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`area_id`);

--
-- Indexes for table `attribute`
--
ALTER TABLE `attribute`
  ADD PRIMARY KEY (`attribute_id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`banner_id`);

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`blog_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brands_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `center_gallery`
--
ALTER TABLE `center_gallery`
  ADD PRIMARY KEY (`center_gallery_id`);

--
-- Indexes for table `center_test`
--
ALTER TABLE `center_test`
  ADD PRIMARY KEY (`center_test_id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `cms`
--
ALTER TABLE `cms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon_code`
--
ALTER TABLE `coupon_code`
  ADD PRIMARY KEY (`coupon_code_id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`gallery_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orders_id`);

--
-- Indexes for table `pincode`
--
ALTER TABLE `pincode`
  ADD PRIMARY KEY (`pin_id`);

--
-- Indexes for table `price_varition`
--
ALTER TABLE `price_varition`
  ADD PRIMARY KEY (`price_varition_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`product_category_id`);

--
-- Indexes for table `product_price`
--
ALTER TABLE `product_price`
  ADD PRIMARY KEY (`product_price_id`);

--
-- Indexes for table `settingg`
--
ALTER TABLE `settingg`
  ADD PRIMARY KEY (`settingg_id`);

--
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`shipping_id`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`state_id`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`test_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `variation`
--
ALTER TABLE `variation`
  ADD PRIMARY KEY (`variation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `area_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attribute`
--
ALTER TABLE `attribute`
  MODIFY `attribute_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `banner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `blog_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brands_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `center_gallery`
--
ALTER TABLE `center_gallery`
  MODIFY `center_gallery_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `center_test`
--
ALTER TABLE `center_test`
  MODIFY `center_test_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cms`
--
ALTER TABLE `cms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `coupon_code`
--
ALTER TABLE `coupon_code`
  MODIFY `coupon_code_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `gallery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orders_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pincode`
--
ALTER TABLE `pincode`
  MODIFY `pin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `price_varition`
--
ALTER TABLE `price_varition`
  MODIFY `price_varition_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `product_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `product_price`
--
ALTER TABLE `product_price`
  MODIFY `product_price_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `settingg`
--
ALTER TABLE `settingg`
  MODIFY `settingg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `shipping_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `state_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `test_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `variation`
--
ALTER TABLE `variation`
  MODIFY `variation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
