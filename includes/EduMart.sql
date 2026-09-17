-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2026 at 07:46 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stationery_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `edu_lvls_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `icons` varchar(100) NOT NULL,
  `icon` varchar(100) DEFAULT 'fa-solid fa-box'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `edu_lvls_id`, `name`, `icons`, `icon`) VALUES
(40, 4, 'Pencil', 'fa-solid fa-pencil', 'fa-solid fa-box'),
(43, 5, 'pen', 'fa-solid fa-pen', 'fa-solid fa-box'),
(44, 6, 'calculator', 'fa-solid fa-calculator', 'fa-solid fa-box'),
(45, 4, 'Eraser', 'fa-solid fa-eraser', 'fa-solid fa-box'),
(46, 4, 'Crayons', 'fa-solid fa-palette', 'fa-solid fa-box'),
(48, 4, 'Notebooks', 'fa-solid fa-book', 'fa-solid fa-box'),
(49, 4, 'Rulers', 'fa-solid fa-ruler', 'fa-solid fa-box'),
(50, 4, 'Scissors', 'fa-solid fa-scissors', 'fa-solid fa-box'),
(51, 4, 'Bags', 'fa-solid fa-bag-shopping', 'fa-solid fa-box'),
(52, 4, 'Bottles', 'fa-solid fa-bottle-water', 'fa-solid fa-box'),
(53, 5, 'Corrections', 'fa-solid fa-eraser', 'fa-solid fa-box'),
(54, 5, 'Geometry', 'fa-solid fa-shapes', 'fa-solid fa-box'),
(55, 5, 'Highlighters', 'fa-solid fa-highlighter', 'fa-solid fa-box'),
(56, 5, 'Files & Folders', 'fa-solid fa-folder', 'fa-solid fa-box'),
(57, 6, 'Laptops', 'fa-solid fa-laptop', 'fa-solid fa-box'),
(58, 6, 'Mouses', 'fa-solid fa-computer-mouse', 'fa-solid fa-box'),
(59, 6, 'USB', 'fa-solid fa-usb', 'fa-solid fa-box');

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `fulfillment_type` varchar(30) NOT NULL DEFAULT 'Delivery',
  `region` varchar(100) DEFAULT NULL,
  `township` varchar(100) DEFAULT NULL,
  `delivery_address` text DEFAULT NULL,
  `shipping_method` varchar(100) DEFAULT NULL,
  `delivery_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery`
--

INSERT INTO `delivery` (`id`, `order_id`, `customer_name`, `fulfillment_type`, `region`, `township`, `delivery_address`, `shipping_method`, `delivery_fee`, `total_amount`, `note`, `status`, `created_at`) VALUES
(27, 29, 'Htoo Htoo', 'Delivery', 'ရန်ကုန်တိုင်းဒေသကြီး', 'လှိုင်', 'no.33', 'ရန်ကုန်', 4000.00, 19000.00, 'note', 'Done', '2026-09-14 11:25:16'),
(28, 30, 'htoo htoo', 'Delivery', 'စစ်ကိုင်းတိုင်းဒေသကြီး', 'မုံရွာ', 'no32', 'အခြားမြို့များ', 5000.00, 50000.00, 'note ok', 'Done', '2026-09-14 11:32:45'),
(29, 31, 'Hnin Hnin', 'Delivery', 'ဧရာဝတီတိုင်းဒေသကြီး', 'မအူပင်', 'no12', 'မအူပင်', 2000.00, 38400.00, 'note ok', 'Done', '2026-09-15 09:08:17'),
(30, 32, 'htoo linn', 'Pick Up', '', '', '', '', 0.00, 15000.00, 'noteok', 'Pending', '2026-09-16 02:29:00'),
(31, 33, 'yu yu maw', 'Delivery', 'ဧရာဝတီတိုင်းဒေသကြီး', 'မအူပင်', 'no.66', 'မအူပင်', 2000.00, 137000.00, 'noteok', 'Done', '2026-09-16 03:47:33'),
(32, 34, 'hnin hnin wai', 'Pick Up', '', '', '', '', 0.00, 135000.00, 'nnn', 'Pending', '2026-09-16 03:49:24');

-- --------------------------------------------------------

--
-- Table structure for table `edu_lvls`
--

CREATE TABLE `edu_lvls` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `icons` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `edu_lvls`
--

INSERT INTO `edu_lvls` (`id`, `name`, `icons`) VALUES
(4, 'primary', 'fa-solid fa-school'),
(5, 'high school', 'fa-solid fa-graduation-cap'),
(6, 'university', 'fa-solid fa-building-columns');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `customer_name` varchar(150) NOT NULL,
  `customer_phone` varchar(30) DEFAULT NULL,
  `customer_address` text DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `fulfillment_type` varchar(30) NOT NULL DEFAULT 'Delivery',
  `payment_method` varchar(50) NOT NULL DEFAULT 'Cash on Delivery',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `customer_name`, `customer_phone`, `customer_address`, `total_amount`, `status`, `fulfillment_type`, `payment_method`, `created_at`) VALUES
(29, 6, 'Htoo Htoo', '09123456789', 'no.33', 19000.00, 'Confirmed', 'Delivery', 'Cash on Delivery', '2026-09-14 11:25:16'),
(30, 6, 'htoo htoo', '09444555222', 'no32', 50000.00, 'Confirmed', 'Delivery', 'Cash on Delivery', '2026-09-14 11:32:44'),
(31, 6, 'Hnin Hnin', '09684356843', 'no12', 38400.00, 'Confirmed', 'Delivery', 'Cash on Delivery', '2026-09-15 09:08:17'),
(32, 6, 'htoo linn', '09444555222', '', 15000.00, 'Confirmed', 'Pick Up', 'Cash on Pickup', '2026-09-16 02:28:59'),
(33, 6, 'yu yu maw', '09684356843', 'no.66', 137000.00, 'Confirmed', 'Delivery', 'Cash on Delivery', '2026-09-16 03:47:33'),
(34, 6, 'hnin hnin wai', '09444555222', '', 135000.00, 'Confirmed', 'Pick Up', 'Cash on Pickup', '2026-09-16 03:49:24');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(32, 29, 119, 1, 15000.00),
(33, 30, 119, 3, 15000.00),
(34, 31, 57, 3, 5600.00),
(35, 31, 93, 2, 2300.00),
(36, 31, 117, 1, 15000.00),
(37, 32, 119, 1, 15000.00),
(38, 33, 116, 3, 45000.00),
(39, 34, 116, 3, 45000.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock`, `image`, `created_at`) VALUES
(26, 40, 'Deli HB Pencil Set', '', 5000.00, 50, 'p6.jpg', '2026-08-26 10:44:03'),
(27, 40, 'Faber-Castell Pencil Set', '', 7500.00, 50, 'p11.jpg', '2026-08-26 10:45:20'),
(28, 40, 'Maped HB Pencil Set', '', 5500.00, 50, 'p10.jpg', '2026-08-26 10:46:24'),
(29, 40, 'Stabilo Pencil Set', '', 6500.00, 50, 'p12.jpg', '2026-08-26 10:47:10'),
(30, 40, 'Dong-A HB Pencil Set', '', 8500.00, 50, 'p13.jpg', '2026-08-26 10:48:00'),
(31, 40, 'Monami Pencil', '', 1500.00, 50, 'p1.jpg', '2026-08-26 10:48:46'),
(32, 40, 'Pilot HB Pencil Set', '', 15000.00, 50, 'pm11.jpg', '2026-08-26 10:49:58'),
(33, 40, 'Pentel Pencil Set', '', 12000.00, 50, 'pm7.jpg', '2026-08-26 10:50:46'),
(34, 45, 'Faber-Castell Eraser', '', 3000.00, 50, 'E7.jpg', '2026-08-26 10:52:19'),
(35, 45, 'Deli Eraser', '', 2000.00, 50, 'E1.jpg', '2026-08-26 10:52:56'),
(36, 45, 'Maped Eraser', '', 4500.00, 50, 'E3.jpg', '2026-08-26 10:54:08'),
(37, 45, 'Staedtler Eraser', '', 1500.00, 50, '5905b47f9ea7f0ee342e187f2b928685.jpg', '2026-08-26 10:54:43'),
(38, 45, 'Pentel Eraser', '', 4000.00, 50, 'E9.jpg', '2026-08-26 10:55:22'),
(39, 45, 'Monami Eraser', '', 3500.00, 50, 'Eset.jpg', '2026-08-26 10:56:14'),
(40, 45, 'Dong-A Eraser', '', 4800.00, 50, 'Eset1.webp', '2026-08-26 10:57:01'),
(41, 51, 'Urban Pack', '', 40000.00, 50, '16.webp', '2026-08-26 10:58:28'),
(42, 51, 'Nova Backpack', '', 55000.00, 50, '1.jpg', '2026-08-26 10:59:12'),
(43, 51, 'Metro Bag', '', 43000.00, 50, '15.webp', '2026-08-26 10:59:45'),
(44, 51, 'Metro Bag', '', 44000.00, 50, '24.webp', '2026-08-26 11:00:20'),
(45, 51, 'Metro Bag', '', 30000.00, 50, '25.webp', '2026-08-26 11:00:44'),
(46, 51, 'Skybag', '', 30000.00, 50, '8.webp', '2026-08-26 11:01:17'),
(47, 51, 'Comet Backpack', '', 53000.00, 50, '2.webp', '2026-08-26 11:01:50'),
(48, 51, 'Comet Backpack', '', 53000.00, 50, '26.webp', '2026-08-26 11:02:20'),
(49, 51, 'Comet Backpack', '', 53000.00, 50, '27.jpg', '2026-08-26 11:02:40'),
(50, 51, 'Comet Backpack', '', 33000.00, 50, '29.jpg', '2026-08-26 11:03:10'),
(51, 46, 'Colorix Crayons', '', 6700.00, 80, 'cy2.jpg', '2026-08-26 11:04:53'),
(52, 46, 'Colorix Crayons', '', 6700.00, 50, 'cy6.jpg', '2026-08-26 11:05:17'),
(53, 46, 'Rainbow Crayons', '', 5500.00, 50, 'cy3.jpg', '2026-08-26 11:05:42'),
(54, 46, 'Rainbow Crayons', '', 5500.00, 50, '5dbac1cb5fba2289ee44b511e9112c49.jpg', '2026-08-26 11:06:01'),
(55, 48, 'Kokuyo Notebook Set', '', 25000.00, 50, 'exbk.jpg', '2026-08-26 11:08:33'),
(56, 48, 'Kokuyo Notebook Set', '', 25000.00, 50, 'exb2.jpg', '2026-08-26 11:08:55'),
(57, 48, 'Milan Notebook', '', 5600.00, 50, 'n5.jpg', '2026-08-26 11:09:30'),
(58, 48, 'Soft Cover Notebook', '', 5600.00, 50, 'n4.jpg', '2026-08-26 11:10:27'),
(59, 49, 'Jelly Ruler', '', 1500.00, 50, 'r1.jpg', '2026-08-26 11:11:18'),
(60, 49, 'Deli Ruler', '', 2300.00, 50, 'r4.jpg', '2026-08-26 11:11:58'),
(61, 49, 'Deli Ruler', '', 2300.00, 50, 'r2.jpg', '2026-08-26 11:12:16'),
(62, 49, 'Deli Ruler', '', 2300.00, 50, 'r9.jpg', '2026-08-26 11:12:36'),
(63, 49, 'Milan Ruler', '', 1800.00, 50, 'r6.jpg', '2026-08-26 11:13:09'),
(64, 52, 'Thermos Bottle', '', 23000.00, 50, 'kb2.jpg', '2026-08-26 11:14:26'),
(65, 52, 'Thermos Bottle', '', 23000.00, 48, 'kb5.jpg', '2026-08-26 11:14:47'),
(66, 52, 'Thermos Bottle', '', 23000.00, 50, 'kb3.jpg', '2026-08-26 11:15:09'),
(67, 52, 'CamelBak Bottle', '', 27000.00, 50, 'b9.jpg', '2026-08-26 11:15:44'),
(68, 52, 'CamelBak Bottle', '', 27000.00, 50, 'b8.jpg', '2026-08-26 11:15:59'),
(69, 52, 'CamelBak Bottle', '', 27000.00, 50, 'b6.jpg', '2026-08-26 11:16:14'),
(70, 50, 'Maped Scissors', '', 3000.00, 50, 's1.jpg', '2026-08-26 11:17:26'),
(71, 50, 'Maped Scissors', '', 3000.00, 50, 's2.jpg', '2026-08-26 11:17:45'),
(72, 50, 'Deli Scissors', '', 2000.00, 53, 's11.jpg', '2026-08-26 11:18:18'),
(73, 50, 'Deli Scissors', '', 2000.00, 50, 's10.jpg', '2026-08-26 11:18:39'),
(74, 53, 'Pilot Correction Pen', '', 6000.00, 50, 'cr5.jpg', '2026-08-26 11:19:46'),
(75, 53, 'Monami Correction Pen', '', 5000.00, 50, 'cr4.jpg', '2026-08-26 11:20:18'),
(76, 53, 'Monami Correction Pen', '', 5000.00, 50, 'cr2.jpg', '2026-08-26 11:20:48'),
(77, 53, 'Monami Correction Pen', '', 5000.00, 50, 'cr3.jpg', '2026-08-26 11:21:04'),
(78, 56, 'Deli File Folder', '', 4500.00, 50, 'ff5.jpg', '2026-08-26 11:22:08'),
(79, 56, 'Deli File Folder', '', 4500.00, 50, 'ff3.jpg', '2026-08-26 11:22:27'),
(80, 56, 'Deli File Folder', '', 4500.00, 60, 'ff4.jpg', '2026-08-26 11:22:40'),
(81, 56, 'Deli File Folder', '', 4500.00, 70, 'ff9.jpg', '2026-08-26 11:23:01'),
(82, 56, 'Deli File Folder', '', 4500.00, 50, 'ff15.jpg', '2026-08-26 11:23:29'),
(83, 54, 'Deli Geometry Set', '', 3500.00, 70, 'g3.jpg', '2026-08-26 11:24:29'),
(84, 54, 'koto Geometry Set', '', 3500.00, 80, 'g2.jpg', '2026-08-26 11:24:53'),
(85, 54, 'koto Geometry Set', '', 6500.00, 57, 'g1.jpg', '2026-08-26 11:25:16'),
(86, 54, 'koto Geometry Set', '', 2100.00, 48, 'g4.jpg', '2026-08-26 11:25:36'),
(87, 55, 'Faber-Castell Highlighter', '', 5400.00, 80, 'H6.jpg', '2026-08-26 11:26:32'),
(88, 55, 'Faber-Castell Highlighter', '', 5400.00, 70, 'H8.jpg', '2026-08-26 11:26:50'),
(89, 55, 'Castell Highlighter', '', 5400.00, 110, 'H10.jpg', '2026-08-26 11:27:16'),
(90, 55, 'Stabilo Boss', '', 4400.00, 80, 'H5.jpg', '2026-08-26 11:27:43'),
(91, 55, 'Stabilo Boss', '', 1500.00, 60, 'H4.jpg', '2026-08-26 11:28:05'),
(92, 55, 'Stabilo Boss', '', 1500.00, 69, 'H3.jpg', '2026-08-26 11:28:22'),
(93, 55, 'Zebra Mildliner', '', 2300.00, 85, 'H12.jpg', '2026-08-26 11:28:50'),
(94, 55, 'Monami Highlighter', '', 3500.00, 77, 'Hs2.jpg', '2026-08-26 11:29:22'),
(95, 43, 'Zebra Sarasa', '', 2200.00, 77, 'pen2.webp', '2026-08-26 11:30:23'),
(96, 43, 'Zebra Sarasa', '', 2200.00, 99, 'pen9.webp', '2026-08-26 11:30:37'),
(97, 43, 'Zebra Sarasa', '', 2200.00, 66, 'pen10.webp', '2026-08-26 11:30:56'),
(98, 43, 'Uni-ball Signo', '', 3300.00, 97, 'pen13.jpg', '2026-08-26 11:31:23'),
(99, 43, 'Pilot G-2', '', 6000.00, 58, 'pen17.jpg', '2026-08-26 11:31:59'),
(100, 43, 'Paper Mate InkJoy', '', 3300.00, 55, 'penset6.webp', '2026-08-26 11:32:39'),
(101, 44, 'Casio fx-991ES Plus', '', 36000.00, 77, 'ca7.jpg', '2026-08-26 11:33:37'),
(102, 44, 'Sharp EL-W531', '', 45000.00, 30, 'ca9.jpg', '2026-08-26 11:49:23'),
(103, 44, 'Sharp EL-W531', '', 45000.00, 60, 'ca6.jpg', '2026-08-26 11:49:46'),
(104, 44, 'Canon F-789SGA', '', 45000.00, 85, 'ca8.jpg', '2026-08-26 11:50:15'),
(105, 44, 'Casio fx-82MS', '', 67000.00, 50, 'ca3.jpg', '2026-08-26 11:51:02'),
(106, 44, 'Casio fx-82MS', '', 77000.00, 69, 'ca1.jpg', '2026-08-26 11:51:22'),
(107, 57, 'MacBook Air M1', '', 2800000.00, 33, 'app1.jpg', '2026-08-26 11:53:04'),
(108, 57, 'MacBook Air M2', '', 2900000.00, 30, 'app3.jpg', '2026-08-26 11:53:25'),
(109, 57, 'MacBook Air M2', '', 2900000.00, 30, 'app4.jpg', '2026-08-26 11:53:41'),
(110, 57, 'MacBook Air M2', '', 2900000.00, 20, 'app5.jpg', '2026-08-26 11:54:10'),
(112, 57, 'ASUS VivoBook 15', '', 1600000.00, 30, 'asu3.jpg', '2026-08-26 11:55:38'),
(113, 58, 'Logitech M185', '', 40000.00, 30, 'm4.jpg', '2026-08-26 11:56:28'),
(114, 58, 'HP X1000', '', 35000.00, 17, 'm2.jpg', '2026-08-26 11:56:58'),
(115, 58, 'HP X1000', '', 35000.00, 20, 'm3.jpg', '2026-08-26 11:57:17'),
(116, 58, 'Rapoo N100', '', 45000.00, 40, 'm1.jpg', '2026-08-26 11:57:42'),
(117, 59, 'SanDisk Ultra USB 3.0', '', 15000.00, 50, 'usb3.jpg', '2026-08-26 11:58:46'),
(118, 59, 'SanDisk Ultra USB 3.0', '', 15000.00, 40, 'usb5.jpg', '2026-08-26 11:59:05'),
(119, 59, 'SanDisk Ultra USB 3.0', '', 15000.00, 50, 'usb4.jpg', '2026-08-26 11:59:22'),
(120, 59, 'Transcend JetFlash 790', '', 20000.00, 0, 'usb2.jpg', '2026-08-26 12:00:03'),
(121, 59, 'ADATA UV150', '', 35000.00, 70, 'b04df5e1f5e38710d44238d6bf23ce9b.jpg', '2026-08-26 12:00:28');

-- --------------------------------------------------------

--
-- Table structure for table `staff_permissions`
--

CREATE TABLE `staff_permissions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `permission` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_in`
--

CREATE TABLE `stock_in` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock_in`
--

INSERT INTO `stock_in` (`id`, `product_id`, `quantity`, `note`, `created_at`) VALUES
(6, 51, 30, 'ABC Office Supply', '2026-09-14 16:30:48'),
(7, 118, 10, 'MDrive', '2026-09-14 16:39:58'),
(8, 121, 30, 'MDrive', '2026-09-16 03:51:36');

-- --------------------------------------------------------

--
-- Table structure for table `stock_out`
--

CREATE TABLE `stock_out` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `phone`, `email`, `address`) VALUES
(5, 'Golden Pen Trading', '09-432345678', 'goldenpen@gmail.com', 'Yangon'),
(6, 'MDrive', '09-436897644', 'mdrive.myanmar@gmail.com', 'Yangon'),
(7, 'Smart School Supplies', '09-456789012', 'smartschool@gmail.com', 'Yangon'),
(8, 'ABC Office Supply', '09-451234567', 'abcoffice@gmail.com', 'Yangon');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('customer','staff','owner') NOT NULL DEFAULT 'customer',
  `google_id` varchar(255) DEFAULT NULL,
  `email_verified` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `google_id`, `email_verified`, `created_at`, `updated_at`) VALUES
(4, 'tete', 'tawetar676@gmail.com', '$2y$10$/j9IPsAzrnyUZoYUTCORYetgq.eF.dgZgydFuHj/42CQIQslwv6z.', 'owner', NULL, 1, '2026-08-14 17:29:28', '2026-08-15 15:36:16'),
(6, 'Htoo Htoo', 'htoo111@gmail.com', '$2y$10$DZNYdkMXU/HBzJq3FU2fquld.yA7yE.VXgD2qFkCtTfjq9iwCQm9S', 'customer', NULL, 1, '2026-09-09 16:39:36', '2026-09-10 16:02:26'),
(7, 'Nwe', 'nwe@gmail.com', '$2y$10$fSRrzunpv0xyVDRr1tUVb.wn8FLo23dMJ8X.Br.Qz9uyLN8a/wVrO', 'customer', NULL, 1, '2026-09-10 06:37:06', '2026-09-10 06:37:06'),
(8, 'yoon wati', 'yoon111@gmail.com', '$2y$10$ebWVB5wJxMYdFuIxtQdX2.7DHltTXtxk2X7FFWq89W0PSToyTBYqi', 'customer', NULL, 1, '2026-09-10 12:29:35', '2026-09-16 02:31:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `edu_lvls_id` (`edu_lvls_id`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `edu_lvls`
--
ALTER TABLE `edu_lvls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `staff_permissions`
--
ALTER TABLE `staff_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_staff_permission` (`user_id`,`permission`);

--
-- Indexes for table `stock_in`
--
ALTER TABLE `stock_in`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_out`
--
ALTER TABLE `stock_out`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_stock_out_product` (`product_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `google_id` (`google_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `edu_lvls`
--
ALTER TABLE `edu_lvls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `staff_permissions`
--
ALTER TABLE `staff_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_in`
--
ALTER TABLE `stock_in`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `stock_out`
--
ALTER TABLE `stock_out`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`edu_lvls_id`) REFERENCES `edu_lvls` (`id`);

--
-- Constraints for table `delivery`
--
ALTER TABLE `delivery`
  ADD CONSTRAINT `delivery_order_fk` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `staff_permissions`
--
ALTER TABLE `staff_permissions`
  ADD CONSTRAINT `fk_staff_permissions_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_in`
--
ALTER TABLE `stock_in`
  ADD CONSTRAINT `stock_in_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stock_out`
--
ALTER TABLE `stock_out`
  ADD CONSTRAINT `stock_out_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
