-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2022 at 01:39 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `resturant`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `address`, `phone`, `created_at`, `updated_at`) VALUES
(9, 'الدقى', 'الدقى', '2775615156', '2022-02-21 14:21:57', '2022-02-21 14:21:57'),
(10, 'المهندسيين', 'المهندسين', '45645616', '2022-02-21 14:22:11', '2022-02-21 14:22:11');

-- --------------------------------------------------------

--
-- Table structure for table `businesses`
--

CREATE TABLE `businesses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('expense','income') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `businesses`
--

INSERT INTO `businesses` (`id`, `branch_id`, `name`, `type`, `created_at`, `updated_at`) VALUES
(8, 9, 'ايرادات الشيفات', 'income', '2022-02-21 14:24:35', '2022-02-21 14:24:35'),
(9, 10, 'ايرادات الشيفات', 'income', '2022-02-21 14:28:42', '2022-02-21 14:28:42'),
(10, 9, 'مصروفات الشيفات', 'expense', '2022-02-21 14:28:56', '2022-02-21 14:28:56'),
(11, 10, 'مصروفات الشيفات', 'expense', '2022-02-21 14:29:11', '2022-02-21 14:32:43'),
(12, 9, 'ايرادات النقاليين', 'income', '2022-02-21 14:38:38', '2022-02-21 14:38:38');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `viewed_number` int(11) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `branch_id`, `name`, `photo`, `viewed_number`, `active`, `created_at`, `updated_at`) VALUES
(10, 9, 'فطير عادى فرع الدقى', 'uploads/categories/الفطير-المشلتت-بالسمن-البلدي-1645463918.jpg', 1, 1, '2022-02-21 15:18:38', '2022-02-22 08:44:12'),
(11, 10, 'فطير تركى', 'uploads/categories/طريقة_عمل_الفطيرة_التركية-1645463959.jpg', NULL, 1, '2022-02-21 15:19:19', '2022-02-21 15:19:19'),
(12, 9, 'بيتزا فرع الدقى', 'uploads/categories/chicken_pizza_2_637661032197208530-1645463977.jpg', 2, 1, '2022-02-21 15:19:37', '2022-02-28 15:27:30');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `country_id`, `name`, `price`, `created_at`, `updated_at`) VALUES
(10, 11, 'الرتاق', 60, '2022-02-21 13:01:19', '2022-02-21 13:01:19'),
(11, 11, 'الخوض', 30, '2022-02-21 13:01:35', '2022-02-21 13:01:35');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `code`, `active`, `created_at`, `updated_at`) VALUES
(11, 'عمان', 'OM', 1, '2022-02-21 12:54:03', '2022-02-21 12:54:03');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` bigint(20) UNSIGNED NOT NULL,
  `expense_for` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `name`, `type`, `expense_for`, `phone`, `price`, `notes`, `created_at`, `updated_at`) VALUES
(8, 'ايراد النقال محمد', 12, NULL, NULL, 50, NULL, '2022-02-21 14:44:35', '2022-02-21 14:44:35'),
(9, 'ايراد النقال محسن', 12, NULL, NULL, 60, NULL, '2022-02-21 14:44:46', '2022-02-21 14:45:11');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2022_02_08_214244_create_branch_table', 2),
(6, '2022_02_09_101308_create_categories_table', 3),
(7, '2022_02_09_120301_create_products_table', 4),
(8, '2022_02_09_214049_create_expenses_table', 5),
(10, '2022_02_10_094645_create_business_table', 6),
(11, '2022_02_10_114834_create_businesses_table', 7),
(12, '2022_02_10_114844_create_expenses_table', 7),
(15, '2022_02_10_115931_create_settings_table', 8),
(16, '2022_02_10_143109_create_countries_table', 9),
(17, '2022_02_10_143302_create_cities_table', 9),
(22, '2022_02_11_143944_create_permessions_table', 10),
(23, '2022_02_11_144056_create_roles_table', 10),
(24, '2022_02_11_144149_create_roles_permessions_table', 10),
(25, '2022_02_11_144255_create_users_roles_table', 10),
(26, '2022_02_12_121908_create_products_variations_table', 11),
(27, '2022_02_15_121001_create_statuses_table', 12),
(28, '2022_02_15_121002_create_orders_table', 12),
(29, '2022_02_15_121154_create_orders_details_table', 12),
(30, '2022_02_16_102912_create_statuses_histroy_table', 13),
(31, '2022_02_17_235151_create_users_info_table', 14);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status_id` bigint(20) UNSIGNED NOT NULL,
  `city_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` enum('inhouse','online') COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_discount` double DEFAULT NULL,
  `shipping` double DEFAULT NULL,
  `grand_total` double NOT NULL,
  `viewed` tinyint(1) NOT NULL DEFAULT 0,
  `client_viewed` tinyint(1) NOT NULL DEFAULT 0,
  `client_status_viewed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `branch_id`, `status_id`, `city_id`, `type`, `customer_name`, `customer_phone`, `customer_address`, `notes`, `total_discount`, `shipping`, `grand_total`, `viewed`, `client_viewed`, `client_status_viewed`, `created_at`, `updated_at`) VALUES
(95, NULL, 9, 5, NULL, 'inhouse', 'hamdy mad', '01152059120', NULL, NULL, 10, NULL, 100, 1, 0, 0, '2022-02-28 11:14:49', '2022-02-28 13:22:51'),
(96, NULL, 9, 5, 10, 'online', 'dklasd;laskd;l', '405604565', 'asd;lask;ldk;l', NULL, NULL, 60, 140, 1, 0, 0, '2022-02-28 11:16:17', '2022-02-28 13:22:51'),
(97, NULL, 9, 5, NULL, 'inhouse', NULL, NULL, NULL, NULL, NULL, NULL, 90, 1, 0, 0, '2022-02-28 11:19:45', '2022-02-28 19:22:51'),
(98, NULL, 10, 6, NULL, 'inhouse', NULL, NULL, NULL, NULL, NULL, NULL, 90, 1, 0, 0, '2022-02-28 11:20:02', '2022-02-28 19:54:52'),
(99, NULL, 10, 7, NULL, 'inhouse', NULL, NULL, NULL, NULL, NULL, NULL, 120, 1, 0, 0, '2022-02-28 11:25:02', '2022-02-28 19:54:52'),
(100, NULL, 10, 7, NULL, 'inhouse', NULL, NULL, NULL, NULL, NULL, NULL, 90, 1, 0, 0, '2022-02-28 11:36:22', '2022-02-28 19:54:52'),
(101, NULL, 10, 6, NULL, 'inhouse', NULL, NULL, NULL, NULL, NULL, NULL, 120, 1, 0, 0, '2022-02-28 11:37:41', '2022-02-28 19:54:52'),
(102, NULL, 10, 6, NULL, 'inhouse', NULL, NULL, NULL, NULL, NULL, NULL, 210, 1, 0, 0, '2022-02-28 11:38:59', '2022-02-28 19:54:52'),
(103, NULL, 9, 5, NULL, 'inhouse', NULL, NULL, NULL, NULL, NULL, NULL, 120, 1, 0, 0, '2022-02-28 11:41:18', '2022-02-28 19:54:52'),
(104, NULL, 9, 5, NULL, 'inhouse', NULL, NULL, NULL, NULL, NULL, NULL, 95, 1, 0, 0, '2022-02-28 11:42:23', '2022-02-28 19:54:52'),
(105, NULL, 10, 5, NULL, 'inhouse', NULL, NULL, NULL, NULL, NULL, NULL, 90, 1, 0, 0, '2022-02-28 11:50:43', '2022-02-28 19:54:52'),
(106, 27, 9, 6, NULL, 'inhouse', NULL, NULL, NULL, NULL, NULL, NULL, 90, 1, 1, 1, '2022-02-28 13:22:47', '2022-03-02 10:18:43'),
(108, 27, 9, 7, NULL, 'inhouse', NULL, NULL, NULL, NULL, NULL, NULL, 90, 1, 1, 1, '2022-02-28 19:23:39', '2022-03-02 10:18:42'),
(109, 27, 9, 5, NULL, 'inhouse', NULL, NULL, NULL, NULL, NULL, NULL, 80, 0, 1, 1, '2022-03-02 10:17:56', '2022-03-02 10:18:42');

-- --------------------------------------------------------

--
-- Table structure for table `orders_details`
--

CREATE TABLE `orders_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variant` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `variant_type` enum('extra','size') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `total_price` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders_details`
--

INSERT INTO `orders_details` (`id`, `order_id`, `product_id`, `variant`, `variant_type`, `price`, `qty`, `total_price`, `created_at`, `updated_at`) VALUES
(226, 95, 14, NULL, NULL, 70, 1, 70, '2022-02-28 11:14:49', '2022-02-28 11:14:49'),
(227, 95, 14, 'سبايسى', 'extra', 20, 2, 40, '2022-02-28 11:14:49', '2022-02-28 11:14:49'),
(228, 96, 16, 'large', 'size', 80, 1, 80, '2022-02-28 11:16:18', '2022-02-28 11:16:18'),
(229, 97, 14, NULL, NULL, 70, 1, 70, '2022-02-28 11:19:45', '2022-02-28 11:19:45'),
(230, 97, 14, 'سبايسى', 'extra', 20, 1, 20, '2022-02-28 11:19:45', '2022-02-28 11:19:45'),
(231, 98, 13, 'large', 'size', 90, 1, 90, '2022-02-28 11:20:02', '2022-02-28 11:20:02'),
(232, 99, 13, 'xlarge', 'size', 120, 1, 120, '2022-02-28 11:25:02', '2022-02-28 11:25:02'),
(233, 100, 13, 'large', 'size', 90, 1, 90, '2022-02-28 11:36:22', '2022-02-28 11:36:22'),
(234, 101, 13, 'xlarge', 'size', 120, 1, 120, '2022-02-28 11:37:41', '2022-02-28 11:37:41'),
(235, 102, 13, 'xlarge', 'size', 120, 1, 120, '2022-02-28 11:38:59', '2022-02-28 11:38:59'),
(236, 102, 13, 'large', 'size', 90, 1, 90, '2022-02-28 11:39:00', '2022-02-28 11:39:00'),
(237, 103, 15, NULL, NULL, 120, 1, 120, '2022-02-28 11:41:18', '2022-02-28 11:41:18'),
(238, 104, 12, NULL, NULL, 90, 1, 90, '2022-02-28 11:42:23', '2022-02-28 11:42:23'),
(239, 104, 12, 'جبنة', 'extra', 5, 1, 5, '2022-02-28 11:42:23', '2022-02-28 11:42:23'),
(240, 105, 13, 'large', 'size', 90, 1, 90, '2022-02-28 11:50:43', '2022-02-28 11:50:43'),
(241, 106, 14, NULL, NULL, 70, 1, 70, '2022-02-28 13:22:48', '2022-02-28 13:22:48'),
(242, 106, 14, 'سبايسى', 'extra', 20, 1, 20, '2022-02-28 13:22:48', '2022-02-28 13:22:48'),
(244, 108, 16, 'large', 'size', 80, 1, 80, '2022-02-28 19:23:40', '2022-02-28 19:23:40'),
(245, 108, 16, 'فرانشيز', 'extra', 10, 1, 10, '2022-02-28 19:23:40', '2022-02-28 19:23:40'),
(246, 109, 16, 'large', 'size', 80, 1, 80, '2022-03-02 10:17:57', '2022-03-02 10:17:57');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permessions`
--

CREATE TABLE `permessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permessions`
--

INSERT INTO `permessions` (`id`, `group_by`, `name`, `key`, `created_at`, `updated_at`) VALUES
(1, 'الأعدادات العامة', 'الأعدادات العامة', 'settings.edit', '2022-02-11 12:51:23', '2022-02-11 12:51:23'),
(2, 'المعاملات المالية', 'كل المعاملات المالية', 'business.index', '2022-02-11 12:52:34', '2022-02-11 12:52:34'),
(3, 'المعاملات المالية', 'الأيرادات والمصروفات', 'business.all', '2022-02-11 12:52:55', '2022-02-11 12:52:55'),
(4, 'المعاملات المالية', 'تعديل المعاملات المالية', 'business.edit', '2022-02-11 12:53:57', '2022-02-11 12:53:57'),
(5, 'المعاملات المالية', 'انشاء المعاملات المالية', 'business.create', '2022-02-11 12:54:32', '2022-02-11 12:54:32'),
(6, 'المعاملات المالية', 'ازالة المعاملات المالية', 'business.destroy', '2022-02-11 12:54:54', '2022-02-11 12:54:54'),
(7, 'الأيرادات والمصروفات', 'كل الأيرادات والمصروفات', 'expenses.index', '2022-02-11 16:12:27', '2022-02-11 16:12:27'),
(8, 'الأيرادات والمصروفات', 'انشاء الأيرادات والمصروفات', 'expenses.create', '2022-02-11 16:13:55', '2022-02-11 16:13:55'),
(9, 'الأيرادات والمصروفات', 'تعديل الأيرادات والمصروفات', 'expenses.edit', '2022-02-11 16:14:26', '2022-02-11 16:14:26'),
(10, 'الأيرادات والمصروفات', 'ازالة الأيرادات والمصروفات', 'expenses.destroy', '2022-02-11 16:14:53', '2022-02-11 16:14:53'),
(11, 'الفروع', 'كل الفروع', 'branches.index', '2022-02-11 16:16:02', '2022-02-11 16:16:02'),
(12, 'الفروع', 'انشاء فرع', 'branches.create', '2022-02-11 16:16:32', '2022-02-11 16:16:32'),
(13, 'الفروع', 'تعديل الفرع', 'branches.edit', '2022-02-11 16:16:59', '2022-02-11 16:16:59'),
(14, 'الفروع', 'ازالة الفرع', 'branches.destroy', '2022-02-11 16:17:25', '2022-02-11 16:17:25'),
(15, 'الأصناف', 'كل الاصناف', 'categories.index', '2022-02-11 16:18:35', '2022-02-11 16:18:35'),
(16, 'الأصناف', 'انشاء الاصناف', 'categories.create', '2022-02-11 16:19:09', '2022-02-11 16:19:09'),
(17, 'الأصناف', 'اظهار الاصناف', 'categories.show', '2022-02-11 16:19:38', '2022-02-11 16:19:38'),
(18, 'الأصناف', 'تعديل الاصناف', 'categories.edit', '2022-02-11 16:19:56', '2022-02-11 16:19:56'),
(19, 'الأصناف', 'ازالة الاصناف', 'categories.destroy', '2022-02-11 16:20:21', '2022-02-11 16:20:21'),
(20, 'الأكلات', 'كل الأكلات', 'products.index', '2022-02-11 16:21:22', '2022-02-11 16:21:22'),
(22, 'الأكلات', 'انشاء الأكلات', 'products.create', '2022-02-11 16:22:26', '2022-02-11 16:22:26'),
(23, 'الأكلات', 'اظهار الأكلات', 'products.show', '2022-02-11 16:22:58', '2022-02-11 16:22:58'),
(24, 'الأكلات', 'تعديل الأكلات', 'products.edit', '2022-02-11 16:23:25', '2022-02-11 16:23:25'),
(25, 'الأكلات', 'ازالة الأكلات', 'products.destroy', '2022-02-11 16:23:46', '2022-02-11 16:23:46'),
(26, 'الشحن والدول', 'كل الشحن والدول', 'countries.index', '2022-02-11 16:24:48', '2022-02-11 16:24:48'),
(27, 'الشحن والدول', 'انشاء الشحن والدول', 'countries.create', '2022-02-11 16:25:07', '2022-02-11 16:25:07'),
(28, 'الشحن والدول', 'تعديل الشحن والدول', 'countries.edit', '2022-02-11 16:25:34', '2022-02-11 16:25:34'),
(29, 'الشحن والدول', 'ازالة الشحن والدول', 'countries.destroy', '2022-02-11 16:25:51', '2022-02-11 16:25:51'),
(30, 'المستخدمين', 'كل المستخدمين', 'users.index', '2022-02-11 16:27:22', '2022-02-11 16:27:22'),
(31, 'المستخدمين', 'انشاء المستخدمين', 'users.create', '2022-02-11 16:27:37', '2022-02-11 16:27:37'),
(32, 'المستخدمين', 'تعديل المستخدمين', 'users.edit', '2022-02-11 16:28:09', '2022-02-11 16:28:09'),
(33, 'المستخدمين', 'ازالة المستخدمين', 'users.destroy', '2022-02-11 16:28:17', '2022-02-11 16:28:17'),
(34, 'الصلاحيات', 'كل الصلاحيات', 'roles.index', '2022-02-11 16:29:31', '2022-02-11 16:29:31'),
(35, 'الصلاحيات', 'انشاء الصلاحيات', 'roles.create', '2022-02-11 16:29:40', '2022-02-11 16:29:40'),
(36, 'الصلاحيات', 'تعديل الصلاحيات', 'roles.edit', '2022-02-11 16:29:48', '2022-02-11 16:29:48'),
(37, 'الصلاحيات', 'ازالة الصلاحيات', 'roles.destroy', '2022-02-11 16:29:56', '2022-02-11 16:29:56'),
(38, 'الطلبات', 'كل الطلبات', 'orders.index', '2022-02-15 10:30:48', '2022-02-15 10:30:48'),
(39, 'الطلبات', 'انشاء الطلبات', 'orders.create', '2022-02-15 10:31:08', '2022-02-15 10:31:08'),
(40, 'الطلبات', 'تعديل الطلبات', 'orders.edit', '2022-02-15 10:31:19', '2022-02-15 10:31:19'),
(41, 'الطلبات', 'ازالة الطلبات', 'orders.destroy', '2022-02-15 10:31:30', '2022-02-15 10:31:30'),
(42, 'حالات الطلبات', 'كل الحالات', 'statuses.index', '2022-02-17 21:12:58', '2022-02-17 21:12:58'),
(43, 'حالات الطلبات', 'انشاء حالة الطلبات', 'statuses.create', '2022-02-17 21:13:22', '2022-02-17 21:13:22'),
(44, 'حالات الطلبات', 'تعديل حالة الطلبات', 'statuses.edit', '2022-02-17 21:13:35', '2022-02-17 21:13:35'),
(45, 'حالات الطلبات', 'ازالة حالة الطلبات', 'statuses.destroy', '2022-02-17 21:13:43', '2022-02-17 21:13:43'),
(47, 'الطلبات', 'ظهور الطلب', 'orders.show', '2022-02-18 12:09:24', '2022-02-18 12:09:24');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photos` text CHARACTER SET utf8 DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double NOT NULL,
  `discount` double DEFAULT NULL,
  `price_after_discount` double NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `viewed_number` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `photos`, `description`, `price`, `discount`, `price_after_discount`, `active`, `viewed_number`, `created_at`, `updated_at`) VALUES
(12, 10, 'فطيرة بلدى', NULL, 'فطيرة جميلة جدا', 90, 0, 90, 1, 1, '2022-02-21 16:01:55', '2022-02-21 16:01:55'),
(13, 11, 'فطير تركى بالقشطة', '[\"uploads\\/products\\/pug-icon-11-1645467032.jpg\"]', 'فطير تركى بالقشطةasjdiasjdkl a', 0, 0, 0, 1, 1, '2022-02-21 16:10:32', '2022-02-21 16:10:32'),
(14, 12, 'بيتزا مرجاريتا فرع الدقى', '[\"uploads\\/products\\/3c85a485ec933611a7d481af56b707226cc786c8-1645631162.jpg\",\"uploads\\/products\\/angular-icon-logo-1645631162.png\",\"uploads\\/products\\/api-1645631162.png\",\"uploads\\/products\\/chicken_pizza_2_637661032197208530-1645631162.jpg\",\"uploads\\/products\\/crossbody bags indybest copy-1645631162.jpg\"]', 'ريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة', 90, 20, 70, 1, 2, '2022-02-22 08:51:46', '2022-02-28 15:28:08'),
(15, 12, 'بيتزا بدون اضافات ولا مقاسات', NULL, ';klasdjklasdjasdadasjkdjasl', 120, 0, 120, 1, 1, '2022-02-22 10:16:01', '2022-02-22 10:16:01'),
(16, 10, 'فطير جديد :D', NULL, NULL, 0, 0, 0, 1, 1, '2022-02-22 14:00:12', '2022-02-22 14:00:12');

-- --------------------------------------------------------

--
-- Table structure for table `products_variations`
--

CREATE TABLE `products_variations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('extra','size') COLLATE utf8mb4_unicode_ci NOT NULL,
  `variant` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `discount` double DEFAULT NULL,
  `price_after_discount` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products_variations`
--

INSERT INTO `products_variations` (`id`, `product_id`, `type`, `variant`, `price`, `discount`, `price_after_discount`, `created_at`, `updated_at`) VALUES
(40, 12, 'extra', 'صوص', 10, NULL, 10, '2022-02-21 16:01:55', '2022-02-21 16:01:55'),
(41, 12, 'extra', 'جبنة', 5, NULL, 5, '2022-02-21 16:01:55', '2022-02-21 16:01:55'),
(42, 13, 'size', 'large', 90, 0, 90, '2022-02-21 16:10:32', '2022-02-21 16:10:32'),
(43, 13, 'size', 'xlarge', 120, 0, 120, '2022-02-21 16:10:33', '2022-02-21 16:10:33'),
(52, 16, 'extra', 'فرانشيز', 10, NULL, 10, '2022-02-22 14:00:12', '2022-02-22 14:00:12'),
(53, 16, 'extra', 'صلصة', 20, NULL, 20, '2022-02-22 14:00:13', '2022-02-22 14:00:13'),
(54, 16, 'size', 'large', 80, 0, 80, '2022-02-22 14:00:13', '2022-02-22 14:00:13'),
(55, 16, 'size', 'xlarge', 120, 0, 120, '2022-02-22 14:00:13', '2022-02-22 14:00:13'),
(62, 14, 'extra', 'سبايسى', 20, NULL, 20, '2022-02-28 15:29:34', '2022-02-28 15:29:34'),
(63, 14, 'extra', 'صوص', 10, NULL, 10, '2022-02-28 15:29:34', '2022-02-28 15:29:34');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(6, 'مدير', '2022-02-22 08:05:10', '2022-02-22 08:05:10'),
(7, 'منفذ طلبات', '2022-02-22 09:24:17', '2022-02-22 09:24:17'),
(9, 'منفذ منتجات', '2022-02-22 09:28:53', '2022-02-22 09:28:53');

-- --------------------------------------------------------

--
-- Table structure for table `roles_permessions`
--

CREATE TABLE `roles_permessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permession_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles_permessions`
--

INSERT INTO `roles_permessions` (`id`, `role_id`, `permession_id`, `created_at`, `updated_at`) VALUES
(213, 6, 1, '2022-02-22 08:05:10', '2022-02-22 08:05:10'),
(214, 6, 2, '2022-02-22 08:05:11', '2022-02-22 08:05:11'),
(215, 6, 3, '2022-02-22 08:05:11', '2022-02-22 08:05:11'),
(216, 6, 4, '2022-02-22 08:05:11', '2022-02-22 08:05:11'),
(217, 6, 5, '2022-02-22 08:05:11', '2022-02-22 08:05:11'),
(218, 6, 6, '2022-02-22 08:05:12', '2022-02-22 08:05:12'),
(219, 6, 7, '2022-02-22 08:05:12', '2022-02-22 08:05:12'),
(220, 6, 8, '2022-02-22 08:05:12', '2022-02-22 08:05:12'),
(221, 6, 9, '2022-02-22 08:05:12', '2022-02-22 08:05:12'),
(222, 6, 10, '2022-02-22 08:05:12', '2022-02-22 08:05:12'),
(223, 6, 11, '2022-02-22 08:05:12', '2022-02-22 08:05:12'),
(224, 6, 12, '2022-02-22 08:05:12', '2022-02-22 08:05:12'),
(225, 6, 13, '2022-02-22 08:05:13', '2022-02-22 08:05:13'),
(226, 6, 14, '2022-02-22 08:05:13', '2022-02-22 08:05:13'),
(227, 6, 15, '2022-02-22 08:05:13', '2022-02-22 08:05:13'),
(228, 6, 16, '2022-02-22 08:05:13', '2022-02-22 08:05:13'),
(229, 6, 17, '2022-02-22 08:05:13', '2022-02-22 08:05:13'),
(230, 6, 18, '2022-02-22 08:05:13', '2022-02-22 08:05:13'),
(231, 6, 19, '2022-02-22 08:05:14', '2022-02-22 08:05:14'),
(232, 6, 20, '2022-02-22 08:05:14', '2022-02-22 08:05:14'),
(233, 6, 22, '2022-02-22 08:05:14', '2022-02-22 08:05:14'),
(234, 6, 23, '2022-02-22 08:05:14', '2022-02-22 08:05:14'),
(235, 6, 24, '2022-02-22 08:05:14', '2022-02-22 08:05:14'),
(236, 6, 25, '2022-02-22 08:05:14', '2022-02-22 08:05:14'),
(237, 6, 26, '2022-02-22 08:05:14', '2022-02-22 08:05:14'),
(238, 6, 27, '2022-02-22 08:05:15', '2022-02-22 08:05:15'),
(239, 6, 28, '2022-02-22 08:05:15', '2022-02-22 08:05:15'),
(240, 6, 29, '2022-02-22 08:05:15', '2022-02-22 08:05:15'),
(241, 6, 30, '2022-02-22 08:05:15', '2022-02-22 08:05:15'),
(242, 6, 31, '2022-02-22 08:05:15', '2022-02-22 08:05:15'),
(243, 6, 32, '2022-02-22 08:05:15', '2022-02-22 08:05:15'),
(244, 6, 33, '2022-02-22 08:05:15', '2022-02-22 08:05:15'),
(245, 6, 34, '2022-02-22 08:05:15', '2022-02-22 08:05:15'),
(246, 6, 35, '2022-02-22 08:05:15', '2022-02-22 08:05:15'),
(247, 6, 36, '2022-02-22 08:05:16', '2022-02-22 08:05:16'),
(248, 6, 37, '2022-02-22 08:05:16', '2022-02-22 08:05:16'),
(249, 6, 38, '2022-02-22 08:05:16', '2022-02-22 08:05:16'),
(250, 6, 39, '2022-02-22 08:05:16', '2022-02-22 08:05:16'),
(251, 6, 40, '2022-02-22 08:05:16', '2022-02-22 08:05:16'),
(252, 6, 41, '2022-02-22 08:05:16', '2022-02-22 08:05:16'),
(253, 6, 47, '2022-02-22 08:05:16', '2022-02-22 08:05:16'),
(254, 6, 42, '2022-02-22 08:05:16', '2022-02-22 08:05:16'),
(255, 6, 43, '2022-02-22 08:05:16', '2022-02-22 08:05:16'),
(256, 6, 44, '2022-02-22 08:05:16', '2022-02-22 08:05:16'),
(257, 6, 45, '2022-02-22 08:05:16', '2022-02-22 08:05:16'),
(258, 7, 38, '2022-02-22 09:24:17', '2022-02-22 09:24:17'),
(259, 7, 39, '2022-02-22 09:24:17', '2022-02-22 09:24:17'),
(260, 7, 40, '2022-02-22 09:24:18', '2022-02-22 09:24:18'),
(261, 7, 41, '2022-02-22 09:24:18', '2022-02-22 09:24:18'),
(262, 7, 47, '2022-02-22 09:24:18', '2022-02-22 09:24:18'),
(268, 9, 20, '2022-02-22 09:28:53', '2022-02-22 09:28:53'),
(269, 9, 22, '2022-02-22 09:28:53', '2022-02-22 09:28:53'),
(270, 9, 23, '2022-02-22 09:28:53', '2022-02-22 09:28:53'),
(271, 9, 24, '2022-02-22 09:28:53', '2022-02-22 09:28:53'),
(272, 9, 25, '2022-02-22 09:28:53', '2022-02-22 09:28:53');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `type`, `value`, `created_at`, `updated_at`) VALUES
(1, 'facebook', 'https://www.freepik.com/search?dates=any&format=collections&page=1&query=ancient&sort=recent', '2022-02-10 11:04:12', '2022-02-10 11:11:54'),
(2, 'instagram', 'https://www.instagram.com', '2022-02-10 11:04:12', '2022-02-10 11:12:00'),
(3, 'youtube', 'https://www.youtube.com/channel/UC4UNlrOOnMe7FItF8SIJk2g', '2022-02-10 11:04:12', '2022-02-10 11:04:12'),
(4, 'logo', 'uploads/settings/الذوق ومندازي-1-Copy-1644502115.png', '2022-02-10 11:23:01', '2022-02-10 12:08:35'),
(5, 'project_name', 'مندازى', '2022-02-18 11:19:27', '2022-02-18 11:19:27'),
(6, 'description', 'مستخدماً وبشكله الأصلي في الطباعة والتنضيد الإلكتروني. انتشر بشكل كبير في ستينيّات هذا القرن مع إصدار رقائق \"ليتراسيت\" (Letraset) البلاستيكية تحوي مقاطع من هذا النص، وعاد لينتشر مرة أخرى مؤخراَ مع ظهور برامج النشر الإلكتروني مثل \"ألدوس بايج مايكر\" (Aldus PageMaker) والتي حوت أيضاً على نسخ', '2022-02-26 20:36:44', '2022-02-26 20:36:44'),
(7, 'keywords', 'اكلة\r\nحميلة\r\nجدا\r\nوشسةوي', '2022-02-26 20:36:44', '2022-02-26 20:36:44'),
(8, 'header', 'مندازى حارتنا تقدم لقم اروع الأشياء', '2022-03-02 10:20:42', '2022-03-02 10:20:42');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default_val` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`, `default_val`, `created_at`, `updated_at`) VALUES
(5, 'حالة جديدة', 1, '2022-02-17 21:43:28', '2022-02-17 21:43:28'),
(6, 'تم التسليم', 0, '2022-02-17 21:43:47', '2022-02-17 21:43:47'),
(7, 'جارى التجهيز', 0, '2022-02-17 21:43:59', '2022-02-17 21:43:59');

-- --------------------------------------------------------

--
-- Table structure for table `statuses_histroy`
--

CREATE TABLE `statuses_histroy` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `status_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statuses_histroy`
--

INSERT INTO `statuses_histroy` (`id`, `user_id`, `order_id`, `status_id`, `created_at`, `updated_at`) VALUES
(95, 7, 108, 5, '2022-02-28 19:54:56', '2022-02-28 19:54:56'),
(96, 7, 108, 7, '2022-02-28 20:03:56', '2022-02-28 20:03:56'),
(97, 7, 108, 5, '2022-02-28 20:04:35', '2022-02-28 20:04:35'),
(98, 7, 108, 7, '2022-02-28 20:04:50', '2022-02-28 20:04:50'),
(99, 7, 108, 6, '2022-02-28 20:06:23', '2022-02-28 20:06:23'),
(100, 7, 108, 5, '2022-02-28 20:06:59', '2022-02-28 20:06:59'),
(101, 7, 108, 7, '2022-02-28 20:07:35', '2022-02-28 20:07:35'),
(102, 27, 109, 5, '2022-03-02 10:17:56', '2022-03-02 10:17:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('admin','user','sub-admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banned` tinyint(1) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `branch_id`, `name`, `type`, `phone`, `address`, `email`, `avatar`, `banned`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(7, 0, 'admin :D', 'admin', '01152059120', '21 seka hadded helwan', 'admin@admin.com', 'uploads/users/angular-icon-logo-1646061113.png', 0, NULL, '$2y$10$1aaVXRrpYeU5LfSGtkhc3eDf2kisXRRsmMebR9Ax2TAHFfaFUM5SG', NULL, '2022-02-11 14:30:08', '2022-02-28 13:17:36'),
(18, 9, 'محمد حسن', 'sub-admin', '01152059120', NULL, 'aa@aa.com', NULL, 0, NULL, '$2y$10$4aVQBoVzkQEp3g31AHpIyOhG39lqA0gvV3sJ4iAh34naQ8d3L.apq', NULL, '2022-02-22 08:13:01', '2022-02-22 08:13:01'),
(19, 10, 'محسن', 'sub-admin', '012465456056', '7stadasdasdasj das', 'ss@ss.com', 'uploads/users/hamdy-1645524843.jpg', 0, NULL, '$2y$10$t4a55YAxXZehiDkZcWFjeOti55H7ZimM86zYYJO4DKPlrqBZshsLu', NULL, '2022-02-22 08:14:04', '2022-02-22 08:14:04'),
(20, 9, 'محمد حسن', 'sub-admin', '0123456065', 'adasdasd', 'mm@mm.com', NULL, 0, NULL, '$2y$10$ffond6G13KWKhP8xOG4GieiHM616bW9co.bv5VRPo1X5sA4puF2Aa', NULL, '2022-02-22 09:24:45', '2022-02-22 09:24:45'),
(21, 9, 'كريم حسن', 'sub-admin', '04564065', 'sakdaspldkas', 'k@k.com', NULL, 0, NULL, '$2y$10$Cn1loutNKgNs/QqjDxfEZeAPOfVXZqHHqGe8pgpvuTFGkVNaOku3e', NULL, '2022-02-22 09:29:17', '2022-02-28 10:41:38'),
(26, 10, 'asd man', 'sub-admin', '2134056456', 'skadnaklsdnaskldnklas', 'asd@asd.com', 'uploads/users/735d5228ab7cc0a0b13c1d7b10921717-1646052645.jpg', 0, NULL, '$2y$10$k2aN1EaoKj18wcRAnnq1MOxc0MsUzPoBb3Wi2l2fvTI7iwFQPSdZG', NULL, '2022-02-28 10:50:45', '2022-02-28 10:50:45'),
(27, NULL, 'mohamed hassan', 'user', NULL, NULL, 'mohamed@gmail.com', 'uploads/users/267669864_8077377025723184_5370032944555405772_n-1646075346.jpg', 0, NULL, '$2y$10$SFGBmJV1yFORF18jkl0bc.T0ACVw/l.eh7RlvDRsMtkMaM.YWs6tC', NULL, '2022-02-28 13:21:02', '2022-02-28 17:09:06');

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

CREATE TABLE `users_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_roles`
--

INSERT INTO `users_roles` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(18, 18, 6, '2022-02-22 08:13:02', '2022-02-22 08:13:02'),
(19, 19, 6, '2022-02-22 08:14:04', '2022-02-22 08:14:04'),
(20, 20, 7, '2022-02-22 09:24:46', '2022-02-22 09:24:46'),
(21, 21, 9, '2022-02-22 09:29:17', '2022-02-22 09:29:17'),
(22, 21, 7, '2022-02-22 09:29:17', '2022-02-22 09:29:17'),
(23, 26, 7, '2022-02-28 10:50:45', '2022-02-28 10:50:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `businesses`
--
ALTER TABLE `businesses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_ibfk_1` (`branch_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cities_name_unique` (`name`),
  ADD KEY `cities_country_id_foreign` (`country_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `countries_name_unique` (`name`),
  ADD UNIQUE KEY `countries_code_unique` (`code`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_type_foreign` (`type`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_status_id_foreign` (`status_id`),
  ADD KEY `orders_branch_id_foreign` (`branch_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders_details`
--
ALTER TABLE `orders_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_details_order_id_foreign` (`order_id`),
  ADD KEY `orders_details_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permessions`
--
ALTER TABLE `permessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permessions_name_key_unique` (`name`,`key`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `products_variations`
--
ALTER TABLE `products_variations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_id` (`product_id`,`variant`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `roles_permessions`
--
ALTER TABLE `roles_permessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_permessions_role_id_permession_id_unique` (`role_id`,`permession_id`),
  ADD KEY `roles_permessions_permession_id_foreign` (`permession_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_type_unique` (`type`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `statuses_histroy`
--
ALTER TABLE `statuses_histroy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `statuses_histroy_user_id_foreign` (`user_id`),
  ADD KEY `statuses_histroy_status_id_foreign` (`status_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_roles_user_id_role_id_unique` (`user_id`,`role_id`),
  ADD KEY `users_roles_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `businesses`
--
ALTER TABLE `businesses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `orders_details`
--
ALTER TABLE `orders_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `permessions`
--
ALTER TABLE `permessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `products_variations`
--
ALTER TABLE `products_variations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `roles_permessions`
--
ALTER TABLE `roles_permessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=273;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `statuses_histroy`
--
ALTER TABLE `statuses_histroy`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users_roles`
--
ALTER TABLE `users_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_type_foreign` FOREIGN KEY (`type`) REFERENCES `businesses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders_details`
--
ALTER TABLE `orders_details`
  ADD CONSTRAINT `orders_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products_variations`
--
ALTER TABLE `products_variations`
  ADD CONSTRAINT `products_variations_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `roles_permessions`
--
ALTER TABLE `roles_permessions`
  ADD CONSTRAINT `roles_permessions_permession_id_foreign` FOREIGN KEY (`permession_id`) REFERENCES `permessions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `roles_permessions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `statuses_histroy`
--
ALTER TABLE `statuses_histroy`
  ADD CONSTRAINT `statuses_histroy_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `statuses_histroy_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `statuses_histroy_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD CONSTRAINT `users_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
