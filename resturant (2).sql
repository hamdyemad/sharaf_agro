-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2022 at 11:09 PM
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
(10, 'المهندسيين', 'المهندسين', '45645616', '2022-02-21 14:22:11', '2022-02-21 14:22:11'),
(12, 'asdasd', 'sladklasdkl;', '5640564056', '2022-03-11 20:21:02', '2022-03-11 20:21:02'),
(13, 'askldjklaskld56456', 'asadasjkld', '456465456', '2022-03-11 20:21:06', '2022-03-11 20:21:06'),
(14, 'xlcjklzx', '4asd5as64das', '5465456456456', '2022-03-11 20:21:11', '2022-03-11 20:21:11'),
(15, 'asdasdasd456456', 'as;ldasl;dkas', '45645645', '2022-03-11 20:21:15', '2022-03-11 20:21:15'),
(16, 'asdasdas', 'as4d56asd4as56', '456465', '2022-03-11 20:21:20', '2022-03-11 20:21:20');

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
(12, 9, 'بيتزا فرع الدقى', 'uploads/categories/chicken_pizza_2_637661032197208530-1645463977.jpg', 2, 0, '2022-02-21 15:19:37', '2022-03-27 11:37:38');

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
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exchange_rate` double NOT NULL DEFAULT 1,
  `default` tinyint(1) NOT NULL DEFAULT 0,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `symbol`, `exchange_rate`, `default`, `code`, `created_at`, `updated_at`) VALUES
(1, 'جنيه مصرى', 'EGP', 0.05, 0, 'EGP', '2022-03-27 18:57:51', '2022-03-27 18:53:19'),
(2, 'دولار امريكى', '$', 0.91, 0, 'US', '2022-03-27 19:11:07', '2022-03-27 18:53:18'),
(3, 'EURO', '€', 1, 1, 'EUR', '2022-03-27 20:03:20', '2022-03-27 18:54:35');

-- --------------------------------------------------------

--
-- Table structure for table `customer_cards`
--

CREATE TABLE `customer_cards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `card_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `card_last_4` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exp_month` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exp_year` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_cards`
--

INSERT INTO `customer_cards` (`id`, `user_id`, `customer_id`, `card_id`, `card_last_4`, `brand`, `exp_month`, `exp_year`, `created_at`, `updated_at`) VALUES
(1, 31, 'cus_LMuZO7IybedXru', 'card_1KgAkILxrkjP1iZjGOZcyuTz', '4242', 'Visa', '3', '2023', '2022-03-22 14:39:46', '2022-03-22 14:39:46');

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
(9, 'ايراد النقال محسن', 12, NULL, NULL, 60, NULL, '2022-02-21 14:44:46', '2022-02-21 14:45:11'),
(10, 'ايراد المصمم محمد عماد', 8, 'mohamed ahmed', '01154065456465', 12.5, 'notes', '2022-03-25 12:25:25', '2022-03-25 12:25:25');

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
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `regional` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rtl` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `regional`, `rtl`, `created_at`, `updated_at`) VALUES
(3, 'English', 'en', 'en_GB', 0, '2022-03-23 21:44:53', '2022-03-23 21:44:53'),
(4, 'Arabic', 'ar', 'ar_AE', 1, '2022-03-23 21:45:16', '2022-03-23 21:45:16');

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
(31, '2022_02_17_235151_create_users_info_table', 14),
(32, '2022_03_20_105253_create_payments_table', 15),
(40, '2022_03_20_113346_create_payment_customers_table', 16),
(41, '2022_03_22_161612_create_customer_cards_table', 17),
(42, '2022_03_23_132138_create_languages_table', 18),
(43, '2022_03_23_132316_create_translations_table', 18),
(44, '2022_03_27_183420_create_currencies_table', 19);

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
  `paid` tinyint(1) NOT NULL DEFAULT 0,
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

INSERT INTO `orders` (`id`, `user_id`, `branch_id`, `status_id`, `city_id`, `paid`, `type`, `customer_name`, `customer_phone`, `customer_address`, `notes`, `total_discount`, `shipping`, `grand_total`, `viewed`, `client_viewed`, `client_status_viewed`, `created_at`, `updated_at`) VALUES
(124, 31, 9, 5, NULL, 0, 'inhouse', NULL, NULL, NULL, NULL, NULL, NULL, 140, 1, 1, 1, '2022-03-23 10:47:46', '2022-03-27 19:07:02'),
(125, 31, 9, 5, NULL, 1, 'inhouse', 'moza', '01551720391', 'الشهيد محمد', 'ملاحظات', NULL, NULL, 210, 1, 1, 1, '2022-03-23 11:02:38', '2022-03-27 19:07:02'),
(126, 31, 9, 5, NULL, 0, 'inhouse', 'hamdy emad', '01152059120', 'asldjasdjklasjd;l', NULL, NULL, NULL, 180, 0, 1, 1, '2022-03-27 18:56:42', '2022-03-27 19:07:02'),
(127, 31, 9, 5, NULL, 1, 'inhouse', 'hamdy emad', '01152059120', '7st ahmed shbeb', NULL, NULL, NULL, 180, 0, 1, 1, '2022-03-27 19:05:35', '2022-03-27 19:07:02');

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
(265, 124, 14, NULL, NULL, 70, 2, 140, '2022-03-23 10:47:46', '2022-03-23 10:47:46'),
(266, 125, 14, NULL, NULL, 70, 3, 210, '2022-03-23 11:02:38', '2022-03-23 11:02:38'),
(267, 126, 12, NULL, NULL, 90, 2, 180, '2022-03-27 18:56:42', '2022-03-27 18:56:42'),
(268, 127, 12, NULL, NULL, 90, 2, 180, '2022-03-27 19:05:36', '2022-03-27 19:05:36');

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `amount` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `transaction_id`, `order_id`, `amount`, `created_at`, `updated_at`) VALUES
(1, 31, 'cs_test_a1iIo4ZxyuROhdh6kYxR2dqo1kS9LbSRuNNe1bkXt36PXai1SbkejiSg2S', 125, 21000, '2022-03-23 11:02:48', '2022-03-23 11:02:48'),
(2, 31, 'cs_test_a1zumACQVRNJnTdBPOdVsBwExMTBs7nsz1dvHgJuxaB3piIrUka1d3hvbN', 127, 18000, '2022-03-27 19:05:39', '2022-03-27 19:05:39');

-- --------------------------------------------------------

--
-- Table structure for table `payment_customers`
--

CREATE TABLE `payment_customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_integration` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_customers`
--

INSERT INTO `payment_customers` (`id`, `user_id`, `customer_id`, `customer_name`, `customer_phone`, `customer_city`, `customer_country`, `payment_integration`, `created_at`, `updated_at`) VALUES
(1, 31, 'cus_LMuZO7IybedXru', 'kareem emad', '01152059120', 'cairo', 'egypt', NULL, '2022-03-22 14:39:44', '2022-03-22 14:39:44');

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
(47, 'الطلبات', 'ظهور الطلب', 'orders.show', '2022-02-18 12:09:24', '2022-02-18 12:09:24'),
(48, 'اللغات', 'كل اللغات', 'languages.index', '2022-03-23 12:32:27', '2022-03-23 12:32:27'),
(49, 'اللغات', 'انشاء لغة', 'languages.create', '2022-03-23 12:36:58', '2022-03-23 12:36:58'),
(51, 'اللغات', 'ازالة لغة', 'languages.destroy', '2022-03-23 12:37:19', '2022-03-23 12:37:19'),
(52, 'المعاملات المالية', 'العملات', 'currencies.index', '2022-03-27 17:06:28', '2022-03-27 17:06:28');

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
(15, 12, 'بيتزا بدون اضافات ولا مقاسات', NULL, ';klasdjklasdjasdadasjkdjasl', 120, 0, 120, 1, 1, '2022-02-22 10:16:01', '2022-02-22 10:16:01');

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
(5, 'project_name', 'مندازى', '2022-02-18 11:19:27', '2022-03-25 10:12:29'),
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
(119, 31, 124, 5, '2022-03-23 10:47:46', '2022-03-23 10:47:46'),
(120, 31, 125, 5, '2022-03-23 11:02:38', '2022-03-23 11:02:38'),
(121, 31, 126, 5, '2022-03-27 18:56:42', '2022-03-27 18:56:42'),
(122, 31, 127, 5, '2022-03-27 19:05:36', '2022-03-27 19:05:36');

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lang_id` bigint(20) UNSIGNED NOT NULL,
  `lang_key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang_value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `translations`
--

INSERT INTO `translations` (`id`, `lang_id`, `lang_key`, `lang_value`, `created_at`, `updated_at`) VALUES
(5, 4, 'language has been created', 'تم انشاء اللغة بنجاح', '2022-03-23 21:45:17', '2022-03-23 22:22:14'),
(6, 4, 'create new language', 'انشاء لغة جديدة', '2022-03-23 21:45:17', '2022-03-23 22:21:21'),
(7, 4, 'dashboard', 'لوحة التحكم', '2022-03-23 21:45:17', '2022-03-23 22:22:13'),
(8, 4, 'languages', 'اللغات', '2022-03-23 21:45:17', '2022-03-23 22:23:31'),
(9, 4, 'language', 'لغة', '2022-03-23 21:45:17', '2022-03-23 22:22:14'),
(10, 4, 'create', 'انشاء', '2022-03-23 21:45:17', '2022-03-23 22:21:21'),
(11, 4, 'back to languages', 'الرجوع الى اللغات', '2022-03-23 21:45:17', '2022-03-23 22:21:21'),
(12, 3, 'create new language', 'create new language', '2022-03-23 21:45:55', '2022-03-23 21:45:55'),
(13, 3, 'dashboard', 'dashboard', '2022-03-23 21:45:56', '2022-03-23 21:45:56'),
(14, 3, 'languages', 'languages', '2022-03-23 21:45:56', '2022-03-23 21:45:56'),
(15, 3, 'language', 'language', '2022-03-23 21:45:56', '2022-03-23 21:45:56'),
(16, 3, 'create', 'create', '2022-03-23 21:45:56', '2022-03-23 21:45:56'),
(17, 3, 'back to languages', 'back to languages', '2022-03-23 21:45:56', '2022-03-23 21:45:56'),
(18, 4, 'language name', 'أسم اللغة', '2022-03-23 21:46:07', '2022-03-23 22:22:14'),
(19, 4, 'translations', 'الترجمات', '2022-03-23 21:47:51', '2022-03-23 22:23:55'),
(20, 4, 'translation name', 'أسم الترجمة', '2022-03-23 21:47:51', '2022-03-23 22:23:32'),
(21, 4, 'translation code', 'كود الترجمة', '2022-03-23 21:47:51', '2022-03-23 22:23:32'),
(22, 4, 'translation region', 'اقليم الترجمة', '2022-03-23 21:47:51', '2022-03-23 22:23:32'),
(23, 4, 'creation date', 'وقت الأنشاء', '2022-03-23 21:47:51', '2022-03-23 22:22:13'),
(24, 4, 'last update date', 'وقت أخر تعديل', '2022-03-23 21:47:51', '2022-03-27 11:21:41'),
(25, 4, 'settings', 'الأعدادت', '2022-03-23 21:47:51', '2022-03-23 22:23:32'),
(26, 4, 'translations link', 'مسار الترجمات', '2022-03-23 21:48:08', '2022-03-23 22:23:55'),
(27, 3, 'language name', 'language name', '2022-03-23 21:49:21', '2022-03-23 21:49:21'),
(28, 3, 'translations link', 'translations link', '2022-03-23 21:49:21', '2022-03-23 21:49:21'),
(29, 3, 'translation name', 'translation name', '2022-03-23 21:49:21', '2022-03-23 21:49:21'),
(30, 3, 'translation code', 'translation code', '2022-03-23 21:49:21', '2022-03-23 21:49:21'),
(31, 3, 'translation region', 'translation region', '2022-03-23 21:49:21', '2022-03-23 21:49:21'),
(32, 3, 'creation date', 'creation date', '2022-03-23 21:49:21', '2022-03-23 21:49:21'),
(33, 3, 'last update date', 'last update date', '2022-03-23 21:49:22', '2022-03-23 21:49:22'),
(34, 3, 'settings', 'settings', '2022-03-23 21:49:22', '2022-03-23 21:49:22'),
(35, 3, 'delete', 'delete', '2022-03-23 21:49:38', '2022-03-23 21:49:38'),
(36, 3, 'remove item', 'remove item', '2022-03-23 21:50:28', '2022-03-23 21:50:28'),
(37, 3, 'are you sure to remove it', 'are you sure to remove it', '2022-03-23 21:50:28', '2022-03-23 21:50:28'),
(38, 3, 'no', 'no', '2022-03-23 21:50:49', '2022-03-23 21:50:49'),
(39, 3, 'yes', 'yes', '2022-03-23 21:50:49', '2022-03-23 21:50:49'),
(40, 4, 'delete', 'ازالة', '2022-03-23 21:50:55', '2022-03-23 22:22:14'),
(41, 4, 'remove item', 'ازالة العنصر', '2022-03-23 21:50:55', '2022-03-23 22:23:32'),
(42, 4, 'are you sure to remove it', 'هل أنت متأكد من ازالة ذلك', '2022-03-23 21:50:56', '2022-03-23 22:20:54'),
(43, 4, 'no', 'لا', '2022-03-23 21:50:56', '2022-03-23 22:23:32'),
(44, 4, 'yes', 'نعم', '2022-03-23 21:50:56', '2022-03-23 22:23:56'),
(45, 3, 'translations', 'translations', '2022-03-23 21:58:07', '2022-03-23 21:58:07'),
(46, 3, 'translation key', 'translation key', '2022-03-23 21:58:42', '2022-03-23 21:58:42'),
(47, 3, 'translation value', 'translation value', '2022-03-23 21:58:42', '2022-03-23 21:58:42'),
(48, 4, 'translation key', 'مفتاح الترجمة', '2022-03-23 22:13:55', '2022-03-23 22:23:32'),
(49, 4, 'translation value', 'ترجمة الترجمة', '2022-03-23 22:13:55', '2022-03-23 22:23:32'),
(50, 3, 'translations updated', 'translations updated', '2022-03-23 22:19:09', '2022-03-23 22:19:09'),
(51, 4, 'email', 'البريد الألكترونى', '2022-03-25 09:21:20', '2022-03-25 10:11:56'),
(52, 4, 'password', 'كلمة السر', '2022-03-25 09:21:21', '2022-03-25 09:28:26'),
(53, 3, 'email', 'email', '2022-03-25 09:24:08', '2022-03-25 09:24:08'),
(54, 3, 'password', 'password', '2022-03-25 09:24:09', '2022-03-25 09:24:09'),
(55, 3, 'branches', 'branches', '2022-03-25 09:31:29', '2022-03-25 09:31:29'),
(56, 3, 'categories', 'categories', '2022-03-25 09:31:29', '2022-03-25 09:31:29'),
(57, 3, 'foods', 'foods', '2022-03-25 09:31:29', '2022-03-25 09:31:29'),
(58, 3, 'orders', 'orders', '2022-03-25 09:31:29', '2022-03-25 09:31:29'),
(59, 3, 'total orders of statuses', 'total orders of statuses', '2022-03-25 09:31:29', '2022-03-25 09:31:29'),
(60, 4, 'branches', 'الفروع', '2022-03-25 09:37:30', '2022-03-25 09:38:14'),
(61, 4, 'categories', 'الأصناف', '2022-03-25 09:37:31', '2022-03-25 09:38:00'),
(62, 4, 'foods', 'الأطعمة', '2022-03-25 09:37:31', '2022-03-25 09:38:27'),
(63, 4, 'orders', 'الطلبات', '2022-03-25 09:37:31', '2022-03-25 09:38:46'),
(64, 4, 'total orders of statuses', 'العدد الكلى لطلبات الحالات', '2022-03-25 09:37:31', '2022-03-25 09:38:46'),
(65, 4, 'translations updated', 'تم تحديث الترجمات', '2022-03-25 09:38:00', '2022-03-27 11:29:29'),
(66, 3, 'the main', 'the main', '2022-03-25 09:54:41', '2022-03-25 09:54:41'),
(67, 3, 'general settings', 'general settings', '2022-03-25 09:54:41', '2022-03-25 09:54:41'),
(68, 3, 'financial transactions', 'financial transactions', '2022-03-25 09:54:41', '2022-03-25 09:54:41'),
(69, 3, 'all financial transactions', 'all financial transactions', '2022-03-25 09:54:41', '2022-03-25 09:54:41'),
(70, 3, 'revenues and expenses', 'revenues and expenses', '2022-03-25 09:54:41', '2022-03-25 09:54:41'),
(71, 3, 'all branches', 'all branches', '2022-03-25 09:54:41', '2022-03-25 09:54:41'),
(72, 3, 'create branch', 'create branch', '2022-03-25 09:54:41', '2022-03-25 09:54:41'),
(73, 3, 'all orders', 'all orders', '2022-03-25 09:54:41', '2022-03-25 09:54:41'),
(74, 3, 'create order', 'create order', '2022-03-25 09:54:41', '2022-03-25 09:54:41'),
(75, 3, 'orders statuses', 'orders statuses', '2022-03-25 09:54:41', '2022-03-25 09:54:41'),
(76, 3, 'create orders statuses', 'create orders statuses', '2022-03-25 09:54:41', '2022-03-25 09:54:41'),
(77, 3, 'all categories', 'all categories', '2022-03-25 09:54:41', '2022-03-25 09:54:41'),
(78, 3, 'create category', 'create category', '2022-03-25 09:54:41', '2022-03-25 09:54:41'),
(79, 3, 'all foods', 'all foods', '2022-03-25 09:54:41', '2022-03-25 09:54:41'),
(80, 3, 'create food', 'create food', '2022-03-25 09:54:42', '2022-03-25 09:54:42'),
(81, 3, 'shipping and countries', 'shipping and countries', '2022-03-25 09:54:42', '2022-03-25 09:54:42'),
(82, 3, 'all countries', 'all countries', '2022-03-25 09:54:42', '2022-03-25 09:54:42'),
(83, 3, 'create country', 'create country', '2022-03-25 09:54:42', '2022-03-25 09:54:42'),
(84, 3, 'staff and users', 'staff and users', '2022-03-25 09:54:42', '2022-03-25 09:54:42'),
(85, 3, 'all staff', 'all staff', '2022-03-25 09:54:43', '2022-03-25 09:54:43'),
(86, 3, 'all users', 'all users', '2022-03-25 09:54:43', '2022-03-25 09:54:43'),
(87, 3, 'permessions', 'permessions', '2022-03-25 09:54:43', '2022-03-25 09:54:43'),
(88, 3, 'all permessions', 'all permessions', '2022-03-25 09:54:43', '2022-03-25 09:54:43'),
(89, 3, 'create permession', 'create permession', '2022-03-25 09:54:43', '2022-03-25 09:54:43'),
(90, 3, 'languages ​​and translation', 'languages ​​and translation', '2022-03-25 09:54:43', '2022-03-25 09:54:43'),
(91, 4, 'the main', 'الرئيسية', '2022-03-25 09:54:51', '2022-03-25 09:55:04'),
(92, 4, 'general settings', 'الأعدادات العامة', '2022-03-25 09:54:51', '2022-03-25 09:55:20'),
(93, 4, 'financial transactions', 'المعاملات المالية', '2022-03-25 09:54:51', '2022-03-25 09:55:48'),
(94, 4, 'all financial transactions', 'كل المعاملات المالية', '2022-03-25 09:54:51', '2022-03-25 09:55:48'),
(95, 4, 'revenues and expenses', 'الأيرادات والمصروفات', '2022-03-25 09:54:51', '2022-03-25 09:56:05'),
(96, 4, 'all branches', 'كل الفروع', '2022-03-25 09:54:51', '2022-03-25 09:56:56'),
(97, 4, 'create branch', 'انشاء فرع', '2022-03-25 09:54:51', '2022-03-25 09:57:47'),
(98, 4, 'all orders', 'كل الطلبات', '2022-03-25 09:54:51', '2022-03-25 09:56:56'),
(99, 4, 'create order', 'انشاء طلب', '2022-03-25 09:54:52', '2022-03-25 09:57:47'),
(100, 4, 'orders statuses', 'حالات الطلبات', '2022-03-25 09:54:52', '2022-03-25 09:58:03'),
(101, 4, 'create orders statuses', 'انشاء حالات الطلبات', '2022-03-25 09:54:52', '2022-03-25 09:57:47'),
(102, 4, 'all categories', 'كل الأصناف', '2022-03-25 09:54:52', '2022-03-25 09:56:56'),
(103, 4, 'create category', 'انشاء صنف', '2022-03-25 09:54:52', '2022-03-25 09:57:47'),
(104, 4, 'all foods', 'كل الأطعمة', '2022-03-25 09:54:52', '2022-03-25 09:56:56'),
(105, 4, 'create food', 'انشاء طعام', '2022-03-25 09:54:52', '2022-03-25 09:57:47'),
(106, 4, 'shipping and countries', 'الشحن والدول', '2022-03-25 09:54:52', '2022-03-25 09:58:16'),
(107, 4, 'all countries', 'كل البلاد', '2022-03-25 09:54:52', '2022-03-25 09:56:56'),
(108, 4, 'create country', 'انشاء بلد', '2022-03-25 09:54:52', '2022-03-25 09:57:47'),
(109, 4, 'staff and users', 'الموظفين والمستخدمين', '2022-03-25 09:54:52', '2022-03-25 09:58:32'),
(110, 4, 'all staff', 'كل الموظفين', '2022-03-25 09:54:52', '2022-03-25 09:56:56'),
(111, 4, 'all users', 'كل المستخدمين', '2022-03-25 09:54:52', '2022-03-25 09:56:56'),
(112, 4, 'permessions', 'الصلاحيات', '2022-03-25 09:54:52', '2022-03-25 09:58:43'),
(113, 4, 'all permessions', 'كل الصلاحيات', '2022-03-25 09:54:52', '2022-03-25 09:56:56'),
(114, 4, 'create permession', 'انشاء صلاحية', '2022-03-25 09:54:52', '2022-03-25 09:57:47'),
(115, 4, 'languages ​​and translation', 'اللغات والترجمة', '2022-03-25 09:54:53', '2022-03-25 09:58:57'),
(116, 3, 'edit general settings', 'edit general settings', '2022-03-25 10:01:31', '2022-03-25 10:01:31'),
(117, 3, 'project name', 'project name', '2022-03-25 10:01:31', '2022-03-25 10:01:31'),
(118, 3, 'the logo', 'the logo', '2022-03-25 10:01:32', '2022-03-25 10:01:32'),
(119, 3, 'header title', 'header title', '2022-03-25 10:01:32', '2022-03-25 10:01:32'),
(120, 3, 'facebook link', 'facebook link', '2022-03-25 10:01:32', '2022-03-25 10:01:32'),
(121, 3, 'instagram link', 'instagram link', '2022-03-25 10:01:32', '2022-03-25 10:01:32'),
(122, 3, 'youtube channel link', 'youtube channel link', '2022-03-25 10:01:32', '2022-03-25 10:01:32'),
(123, 3, 'description', 'description', '2022-03-25 10:01:32', '2022-03-25 10:01:32'),
(124, 3, 'google search keywords', 'google search keywords', '2022-03-25 10:01:32', '2022-03-25 10:01:32'),
(125, 3, 'edit', 'edit', '2022-03-25 10:01:32', '2022-03-25 10:01:32'),
(126, 4, 'edit general settings', 'تعديل الأعدادات العامة', '2022-03-25 10:04:14', '2022-03-25 10:11:56'),
(127, 4, 'project name', 'أسم المشروع', '2022-03-25 10:04:14', '2022-03-25 10:10:38'),
(128, 4, 'the logo', 'اللوجو', '2022-03-25 10:04:14', '2022-03-25 10:10:20'),
(129, 4, 'header title', 'عنوان الهيدر', '2022-03-25 10:04:14', '2022-03-25 10:11:26'),
(130, 4, 'facebook link', 'لينك الفيسبوك', '2022-03-25 10:04:14', '2022-03-25 10:11:56'),
(131, 4, 'instagram link', 'لينك الانستجرام', '2022-03-25 10:04:14', '2022-03-25 10:11:26'),
(132, 4, 'youtube channel link', 'لينك قناه اليوتيوب', '2022-03-25 10:04:14', '2022-03-27 11:29:30'),
(133, 4, 'description', 'الوصف', '2022-03-25 10:04:14', '2022-03-25 10:11:56'),
(134, 4, 'google search keywords', 'كلمات مفتاحية البحث جوجل', '2022-03-25 10:04:14', '2022-03-25 10:11:26'),
(135, 4, 'edit', 'تعديل', '2022-03-25 10:04:14', '2022-03-25 10:11:56'),
(136, 4, 'the name is required', 'الأسم مطلوب', '2022-03-25 10:16:29', '2022-03-25 10:17:11'),
(137, 4, 'you should choose a name is not already exists', 'يجب أختيار أسم غير موجود بالفعل', '2022-03-25 10:16:29', '2022-03-25 10:17:35'),
(138, 4, 'the address is required', 'العنوان مطلوب', '2022-03-25 10:16:29', '2022-03-25 10:17:11'),
(139, 4, 'the phone is required', 'رقم الهاتف مطلوب', '2022-03-25 10:16:29', '2022-03-25 10:17:11'),
(140, 4, 'the type is required', 'النوع مطلوب', '2022-03-25 10:49:46', '2022-03-27 11:11:46'),
(141, 4, 'the name should be letters', 'الأسم يجب أن يكون حروف', '2022-03-25 10:49:47', '2022-03-27 11:26:05'),
(142, 4, 'you should enter a letters at least 255', 'يجب عليك ادخال حروف أقل من 255', '2022-03-25 10:49:47', '2022-03-27 11:29:30'),
(143, 4, 'the email is required', 'البريد الألكترونى مطلوب', '2022-03-25 10:49:47', '2022-03-27 11:24:11'),
(144, 4, 'the email sould be letters', 'البريد الألكترونى يجب أن يكون حروف', '2022-03-25 10:49:47', '2022-03-27 11:26:05'),
(145, 4, 'the email is already exists', 'البريد الألكترونى هذا مستخدم بالفعل', '2022-03-25 10:49:47', '2022-03-27 11:18:36'),
(146, 4, 'the password is required', 'الرقم السرى مطلوب', '2022-03-25 10:49:47', '2022-03-27 11:26:06'),
(147, 4, 'the password sould be letters', 'الرقم السرى يجب أن يكون حروف أو أرقام', '2022-03-25 10:49:47', '2022-03-27 11:26:06'),
(148, 4, 'you should enter a password bigger than 8 letters', 'يجب عليك ادخال رقم سرى مكون من 8 حروف على الأقل', '2022-03-25 10:49:47', '2022-03-27 11:29:30'),
(149, 4, 'the password should be matches', 'الرقم السرى يجب أن يكون مطابقا', '2022-03-25 10:49:48', '2022-03-27 11:26:06'),
(150, 4, 'you should choose branch', 'يجب عليك أختيار الفرع', '2022-03-25 10:49:48', '2022-03-27 11:12:23'),
(151, 4, 'the permessions is required', 'التصاريح مطلوبة', '2022-03-25 10:49:48', '2022-03-27 11:26:56'),
(152, 4, 'the permessions is not in the infos', 'التصاريح ليست في بقية المقال', '2022-03-25 10:49:48', '2022-03-27 11:26:56'),
(153, 4, 'there is something error', 'يوجد خطأ ما', '2022-03-25 10:49:48', '2022-03-27 11:27:44'),
(154, 3, 'remember me', 'remember me', '2022-03-25 11:33:22', '2022-03-25 11:33:22'),
(155, 3, 'login', 'login', '2022-03-25 11:33:22', '2022-03-25 11:33:22'),
(156, 4, 'remember me', 'تذكرنى', '2022-03-25 11:44:59', '2022-03-27 11:23:25'),
(157, 4, 'login', 'تسجيل الدخول', '2022-03-25 11:44:59', '2022-03-27 11:21:41'),
(158, 3, 'the email is required', 'the email is required', '2022-03-25 11:47:41', '2022-03-25 11:47:41'),
(159, 3, 'the email should be letters', 'the email should be letters', '2022-03-25 11:47:42', '2022-03-25 11:47:42'),
(160, 3, 'the email should be an email format', 'the email should be an email format', '2022-03-25 11:47:42', '2022-03-25 11:47:42'),
(161, 3, 'the email is not exists', 'the email is not exists', '2022-03-25 11:47:42', '2022-03-25 11:47:42'),
(162, 3, 'the password is required', 'the password is required', '2022-03-25 11:47:42', '2022-03-25 11:47:42'),
(163, 3, 'logined successfully', 'logined successfully', '2022-03-25 11:48:38', '2022-03-25 11:48:38'),
(164, 3, 'loged out successfully', 'loged out successfully', '2022-03-25 11:48:43', '2022-03-25 11:48:43'),
(165, 4, 'the email should be letters', 'البريد الألكترونى يجب أن يكون حروف', '2022-03-25 11:49:00', '2022-03-27 11:24:40'),
(166, 4, 'the email should be an email format', 'البريد الألكترونى يجب أن يكون صيغة البريد', '2022-03-25 11:49:00', '2022-03-27 11:24:40'),
(167, 4, 'the email is not exists', 'البريد الألكترونى خطأ', '2022-03-25 11:49:00', '2022-03-27 11:18:36'),
(168, 3, 'create financial transactions', 'create financial transactions', '2022-03-25 11:54:44', '2022-03-25 11:54:44'),
(169, 3, 'financial nam', 'financial nam', '2022-03-25 11:54:44', '2022-03-25 11:54:44'),
(170, 3, 'type', 'type', '2022-03-25 11:54:44', '2022-03-25 11:54:44'),
(171, 3, 'choose', 'choose', '2022-03-25 11:54:44', '2022-03-25 11:54:44'),
(172, 3, 'income', 'income', '2022-03-25 11:54:44', '2022-03-25 11:54:44'),
(173, 3, 'expenses', 'expenses', '2022-03-25 11:54:44', '2022-03-25 11:54:44'),
(174, 3, 'the branch', 'the branch', '2022-03-25 11:54:45', '2022-03-25 11:54:45'),
(175, 3, 'search', 'search', '2022-03-25 11:54:59', '2022-03-25 11:54:59'),
(176, 3, 'financial name', 'financial name', '2022-03-25 11:56:44', '2022-03-25 11:56:44'),
(177, 3, 'financial type', 'financial type', '2022-03-25 11:56:44', '2022-03-25 11:56:44'),
(178, 3, 'branch', 'branch', '2022-03-25 11:56:44', '2022-03-25 11:56:44'),
(179, 3, 'back to financial transactions', 'back to financial transactions', '2022-03-25 11:59:49', '2022-03-25 11:59:49'),
(180, 3, 'the name is required', 'the name is required', '2022-03-25 11:59:56', '2022-03-25 11:59:56'),
(181, 3, 'the type is required', 'the type is required', '2022-03-25 11:59:56', '2022-03-25 11:59:56'),
(182, 3, 'the branch is required', 'the branch is required', '2022-03-25 11:59:56', '2022-03-25 11:59:56'),
(183, 3, 'the branch should be exists', 'the branch should be exists', '2022-03-25 11:59:56', '2022-03-25 11:59:56'),
(184, 3, 'the transaction must be an expense or income', 'the transaction must be an expense or income', '2022-03-25 11:59:56', '2022-03-25 11:59:56'),
(185, 3, 'there is something error', 'there is something error', '2022-03-25 11:59:56', '2022-03-25 11:59:56'),
(186, 3, 'edit financial transactions', 'edit financial transactions', '2022-03-25 12:01:59', '2022-03-25 12:01:59'),
(187, 3, 'incomes', 'incomes', '2022-03-25 12:04:00', '2022-03-25 12:04:00'),
(188, 3, 'there is no incomes yet', 'there is no incomes yet', '2022-03-25 12:04:01', '2022-03-25 12:04:01'),
(189, 3, 'there is no expenses yet', 'there is no expenses yet', '2022-03-25 12:04:01', '2022-03-25 12:04:01'),
(190, 3, 'income name', 'income name', '2022-03-25 12:04:48', '2022-03-25 12:04:48'),
(191, 3, 'incomes owner\'s name', 'incomes owner\'s name', '2022-03-25 12:05:25', '2022-03-25 12:05:25'),
(192, 3, 'phone', 'phone', '2022-03-25 12:05:57', '2022-03-25 12:05:57'),
(193, 3, 'the amount', 'the amount', '2022-03-25 12:05:57', '2022-03-25 12:05:57'),
(194, 3, 'the phone', 'the phone', '2022-03-25 12:08:02', '2022-03-25 12:08:02'),
(195, 3, 'the notes', 'the notes', '2022-03-25 12:08:02', '2022-03-25 12:08:02'),
(196, 3, 'back to', 'back to', '2022-03-25 12:20:49', '2022-03-25 12:20:49'),
(197, 3, 'the price is required', 'the price is required', '2022-03-25 12:24:02', '2022-03-25 12:24:02'),
(198, 3, 'the price should be a number', 'the price should be a number', '2022-03-25 12:24:02', '2022-03-25 12:24:02'),
(199, 3, 'created successfully', 'created successfully', '2022-03-25 12:25:25', '2022-03-25 12:25:25'),
(200, 3, 'branch name', 'branch name', '2022-03-25 13:32:36', '2022-03-25 13:32:36'),
(201, 3, 'branch phone', 'branch phone', '2022-03-25 13:32:36', '2022-03-25 13:32:36'),
(202, 3, 'branch address', 'branch address', '2022-03-25 13:32:36', '2022-03-25 13:32:36'),
(203, 3, 'last update date	', 'last update date	', '2022-03-25 13:32:37', '2022-03-25 13:32:37'),
(204, 4, 'branch name', 'أسم الفرع', '2022-03-25 13:36:42', '2022-03-27 11:19:03'),
(205, 4, 'branch phone', 'هاتف الفرع', '2022-03-25 13:36:43', '2022-03-27 11:19:03'),
(206, 4, 'branch address', 'عنوان الفرع', '2022-03-25 13:36:43', '2022-03-27 11:19:03'),
(207, 4, 'search', 'بحث', '2022-03-25 13:36:43', '2022-03-27 11:13:49'),
(208, 4, 'last update date	', 'last update date	', '2022-03-25 13:36:44', '2022-03-25 13:36:44'),
(209, 3, 'create new branch', 'create new branch', '2022-03-25 13:37:14', '2022-03-25 13:37:14'),
(210, 3, 'back to branches', 'back to branches', '2022-03-25 13:38:25', '2022-03-25 13:38:25'),
(211, 3, 'edit branches', 'edit branches', '2022-03-25 13:40:03', '2022-03-25 13:40:03'),
(212, 3, 'you should choose a name is not already exists', 'you should choose a name is not already exists', '2022-03-25 13:42:03', '2022-03-25 13:42:03'),
(213, 3, 'the address is required', 'the address is required', '2022-03-25 13:42:03', '2022-03-25 13:42:03'),
(214, 3, 'the phone is required', 'the phone is required', '2022-03-25 13:42:03', '2022-03-25 13:42:03'),
(215, 3, 'customer name', 'customer name', '2022-03-25 13:44:50', '2022-03-25 13:44:50'),
(216, 3, 'customer phone', 'customer phone', '2022-03-25 13:44:50', '2022-03-25 13:44:50'),
(217, 3, 'customer address', 'customer address', '2022-03-25 13:44:50', '2022-03-25 13:44:50'),
(218, 3, 'order status', 'order status', '2022-03-25 13:44:50', '2022-03-25 13:44:50'),
(219, 3, 'order type', 'order type', '2022-03-25 13:44:50', '2022-03-25 13:44:50'),
(220, 3, 'receipt request from the branch', 'receipt request from the branch', '2022-03-25 13:44:51', '2022-03-25 13:44:51'),
(221, 3, 'online order', 'online order', '2022-03-25 13:44:51', '2022-03-25 13:44:51'),
(222, 3, 'order number', 'order number', '2022-03-25 13:49:51', '2022-03-25 13:49:51'),
(223, 3, 'city', 'city', '2022-03-25 13:49:51', '2022-03-25 13:49:51'),
(224, 3, 'paid', 'paid', '2022-03-25 13:49:51', '2022-03-25 13:49:51'),
(225, 3, 'order branch', 'order branch', '2022-03-25 13:49:51', '2022-03-25 13:49:51'),
(226, 3, 'there is no city', 'there is no city', '2022-03-25 13:49:51', '2022-03-25 13:49:51'),
(227, 3, 'show', 'show', '2022-03-25 13:49:51', '2022-03-25 13:49:51'),
(228, 3, 'name', 'name', '2022-03-25 13:49:51', '2022-03-25 13:49:51'),
(229, 3, 'price', 'price', '2022-03-25 13:49:52', '2022-03-25 13:49:52'),
(230, 3, 'quantity', 'quantity', '2022-03-25 13:49:52', '2022-03-25 13:49:52'),
(231, 3, 'total price', 'total price', '2022-03-25 13:49:52', '2022-03-25 13:49:52'),
(232, 3, 'final price', 'final price', '2022-03-25 13:49:52', '2022-03-25 13:49:52'),
(233, 3, 'there is no name', 'there is no name', '2022-03-25 13:49:52', '2022-03-25 13:49:52'),
(234, 3, 'there is no address', 'there is no address', '2022-03-25 13:49:52', '2022-03-25 13:49:52'),
(235, 3, 'there is no phone', 'there is no phone', '2022-03-25 13:49:52', '2022-03-25 13:49:52'),
(236, 3, 'order show', 'order show', '2022-03-25 13:51:10', '2022-03-25 13:51:10'),
(237, 3, 'order status history', 'order status history', '2022-03-25 13:52:25', '2022-03-25 13:52:25'),
(238, 3, 'name of the user who changed the status', 'name of the user who changed the status', '2022-03-25 13:52:25', '2022-03-25 13:52:25'),
(239, 3, 'status', 'status', '2022-03-25 13:52:26', '2022-03-25 13:52:26'),
(240, 3, 'order details', 'order details', '2022-03-25 13:53:48', '2022-03-25 13:53:48'),
(241, 3, 'notes', 'notes', '2022-03-25 13:53:57', '2022-03-25 13:53:57'),
(242, 3, 'order summary', 'order summary', '2022-03-25 13:54:52', '2022-03-25 13:54:52'),
(243, 3, 'food name', 'food name', '2022-03-25 13:54:52', '2022-03-25 13:54:52'),
(244, 3, 'the number', 'the number', '2022-03-25 13:54:52', '2022-03-25 13:54:52'),
(245, 3, 'count', 'count', '2022-03-25 13:55:12', '2022-03-25 13:55:12'),
(246, 3, 'total price withoud extras', 'total price withoud extras', '2022-03-25 13:57:17', '2022-03-25 13:57:17'),
(247, 4, 'order show', 'اظهار الطلب', '2022-03-25 13:57:38', '2022-03-27 11:22:40'),
(248, 4, 'order number', 'رقم الطلب', '2022-03-25 13:57:38', '2022-03-27 11:22:40'),
(249, 4, 'order details', 'تفاصيل الطلب', '2022-03-25 13:57:38', '2022-03-27 11:22:40'),
(250, 4, 'customer name', 'أسم الزبون', '2022-03-25 13:57:38', '2022-03-27 11:20:03'),
(251, 4, 'customer phone', 'هاتف الزبون', '2022-03-25 13:57:38', '2022-03-27 11:20:03'),
(252, 4, 'customer address', 'عنوان الزبون', '2022-03-25 13:57:39', '2022-03-27 11:20:03'),
(253, 4, 'order branch', 'فرع الطلب', '2022-03-25 13:57:39', '2022-03-27 11:22:40'),
(254, 4, 'notes', 'الملاحظات', '2022-03-25 13:57:39', '2022-03-27 11:22:40'),
(255, 4, 'order summary', 'ملخص الطلب', '2022-03-25 13:57:39', '2022-03-27 11:22:51'),
(256, 4, 'food name', 'أسم الأكلة', '2022-03-25 13:57:39', '2022-03-27 11:20:51'),
(257, 4, 'price', 'السعر', '2022-03-25 13:57:39', '2022-03-27 11:23:07'),
(258, 4, 'count', 'العدد', '2022-03-25 13:57:39', '2022-03-27 11:19:35'),
(259, 4, 'total price', 'السعر الكلى', '2022-03-25 13:57:39', '2022-03-27 11:28:08'),
(260, 4, 'total price withoud extras', 'السعر الكلى بدون الأضافات', '2022-03-25 13:57:39', '2022-03-27 11:28:08'),
(261, 4, 'final price', 'السعر النهائى', '2022-03-25 13:57:39', '2022-03-27 11:20:51'),
(262, 4, 'order status history', 'تاريخ حالات الطلبات', '2022-03-25 13:57:40', '2022-03-27 11:22:40'),
(263, 4, 'name of the user who changed the status', 'اسم المستخدم الذي قام بتغيير الحالة', '2022-03-25 13:57:40', '2022-03-27 11:18:36'),
(264, 4, 'status', 'الحالة', '2022-03-25 13:57:40', '2022-03-27 11:23:55'),
(265, 4, 'order status', 'حالة الطلب', '2022-03-25 13:59:00', '2022-03-27 11:22:40'),
(266, 4, 'choose', 'أختر', '2022-03-25 13:59:00', '2022-03-27 11:12:23'),
(267, 4, 'order type', 'نوع الطلب', '2022-03-25 13:59:00', '2022-03-27 11:11:46'),
(268, 4, 'receipt request from the branch', 'أستلام الطلب من الفرع', '2022-03-25 13:59:00', '2022-03-27 11:13:33'),
(269, 4, 'online order', 'طلب أونلاين', '2022-03-25 13:59:00', '2022-03-27 11:22:40'),
(270, 4, 'the branch', 'الفرع', '2022-03-25 13:59:00', '2022-03-27 11:13:33'),
(271, 4, 'city', 'المدينة', '2022-03-25 13:59:00', '2022-03-27 11:19:35'),
(272, 4, 'paid', 'مدفوع', '2022-03-25 13:59:00', '2022-03-27 11:31:38'),
(273, 4, 'there is no city', 'لا يوجد مدينة', '2022-03-25 13:59:00', '2022-03-27 11:26:56'),
(274, 4, 'show', 'اظهار', '2022-03-25 13:59:00', '2022-03-27 11:23:55'),
(275, 4, 'name', 'الأسم', '2022-03-25 13:59:01', '2022-03-27 11:21:41'),
(276, 4, 'quantity', 'الكمية', '2022-03-25 13:59:01', '2022-03-27 11:23:25'),
(277, 4, 'there is no name', 'لا يوجد أسم', '2022-03-25 13:59:01', '2022-03-27 11:27:43'),
(278, 4, 'there is no address', 'لا يوجد عنوان', '2022-03-25 13:59:01', '2022-03-27 11:26:56'),
(279, 4, 'there is no phone', 'لا يوجد هاتف', '2022-03-25 13:59:01', '2022-03-27 11:27:43'),
(280, 4, 'there is no foods in the branch yet', 'لا يوجد أكلات فى هذا الفرع حاليا', '2022-03-25 14:09:41', '2022-03-27 11:13:34'),
(281, 4, 'create new order', 'انشاء طلب جديد', '2022-03-25 14:10:26', '2022-03-27 11:14:14'),
(282, 4, 'order branch creation', 'طلب إنشاء فرع', '2022-03-25 14:13:09', '2022-03-27 11:22:40'),
(283, 4, 'receipt from the branch', 'أستلام من الفرع', '2022-03-25 14:13:09', '2022-03-27 11:13:33'),
(284, 4, 'products', 'الأكلات', '2022-03-25 14:13:09', '2022-03-27 11:23:25'),
(285, 3, 'create new order', 'create new order', '2022-03-25 14:13:13', '2022-03-25 14:13:13'),
(286, 3, 'order branch creation', 'order branch creation', '2022-03-25 14:13:13', '2022-03-25 14:13:13'),
(287, 3, 'receipt from the branch', 'receipt from the branch', '2022-03-25 14:13:13', '2022-03-25 14:13:13'),
(288, 3, 'products', 'products', '2022-03-25 14:13:14', '2022-03-25 14:13:14'),
(289, 3, 'there is no foods in the branch yet', 'there is no foods in the branch yet', '2022-03-25 14:13:14', '2022-03-25 14:13:14'),
(290, 3, 'summary', 'summary', '2022-03-25 14:15:28', '2022-03-25 14:15:28'),
(291, 3, 'shipping', 'shipping', '2022-03-25 14:15:29', '2022-03-25 14:15:29'),
(292, 3, 'discount', 'discount', '2022-03-25 14:15:29', '2022-03-25 14:15:29'),
(293, 3, 'price after discount', 'price after discount', '2022-03-25 14:15:29', '2022-03-25 14:15:29'),
(294, 3, 'back to orders', 'back to orders', '2022-03-25 14:15:29', '2022-03-25 14:15:29'),
(295, 3, 'deleted successfully', 'deleted successfully', '2022-03-25 14:16:16', '2022-03-25 14:16:16'),
(296, 3, 'country', 'country', '2022-03-25 14:16:47', '2022-03-25 14:16:47'),
(297, 3, 'sizes', 'sizes', '2022-03-25 14:21:21', '2022-03-25 14:21:21'),
(298, 3, 'extras', 'extras', '2022-03-25 14:21:21', '2022-03-25 14:21:21'),
(299, 3, 'size', 'size', '2022-03-25 14:21:21', '2022-03-25 14:21:21'),
(300, 3, 'extra', 'extra', '2022-03-25 14:21:21', '2022-03-25 14:21:21'),
(301, 3, 'there is no price', 'there is no price', '2022-03-25 14:21:21', '2022-03-25 14:21:21'),
(302, 3, 'there is no quantity', 'there is no quantity', '2022-03-25 14:21:21', '2022-03-25 14:21:21'),
(303, 3, 'there is no total price', 'there is no total price', '2022-03-25 14:21:21', '2022-03-25 14:21:21'),
(304, 3, 'there is no sizes', 'there is no sizes', '2022-03-25 14:21:21', '2022-03-25 14:21:21'),
(305, 3, 'there is no extras', 'there is no extras', '2022-03-25 14:21:21', '2022-03-25 14:21:21'),
(306, 3, 'you should choose a type from the stock', 'you should choose a type from the stock', '2022-03-25 14:42:00', '2022-03-25 14:42:00'),
(307, 3, 'you should choose a minmum 1 product', 'you should choose a minmum 1 product', '2022-03-25 14:42:00', '2022-03-25 14:42:00'),
(308, 3, 'edit order', 'edit order', '2022-03-25 14:51:13', '2022-03-25 14:51:13'),
(309, 4, 'logined successfully', 'تم سجيل الدخول بنجاح', '2022-03-27 11:03:54', '2022-03-27 11:21:41'),
(310, 4, 'summary', 'ملخص', '2022-03-27 11:04:26', '2022-03-27 11:23:56'),
(311, 4, 'shipping', 'الشحن', '2022-03-27 11:04:26', '2022-03-27 11:23:32'),
(312, 4, 'discount', 'الخصم', '2022-03-27 11:04:26', '2022-03-27 11:20:28'),
(313, 4, 'price after discount', 'السعر بعد الخصم', '2022-03-27 11:04:26', '2022-03-27 11:23:07'),
(314, 4, 'back to orders', 'الرجوع الى الطلبات', '2022-03-27 11:04:26', '2022-03-27 11:15:25'),
(315, 4, 'country', 'البلد', '2022-03-27 11:04:26', '2022-03-27 11:19:35'),
(316, 4, 'sizes', 'المقاسات', '2022-03-27 11:04:27', '2022-03-27 11:23:55'),
(317, 4, 'extras', 'الأضافات', '2022-03-27 11:04:27', '2022-03-27 11:20:51'),
(318, 4, 'size', 'المقاس', '2022-03-27 11:04:27', '2022-03-27 11:23:55'),
(319, 4, 'extra', 'اضافة', '2022-03-27 11:04:27', '2022-03-27 11:20:51'),
(320, 4, 'there is no price', 'لا يوجد سعر', '2022-03-27 11:04:27', '2022-03-27 11:27:43'),
(321, 4, 'there is no quantity', 'لا يوجد كمية', '2022-03-27 11:04:27', '2022-03-27 11:27:43'),
(322, 4, 'there is no total price', 'لا يوجد سعر كلى', '2022-03-27 11:04:27', '2022-03-27 11:27:43'),
(323, 4, 'there is no sizes', 'لا يوجد مقاسات', '2022-03-27 11:04:28', '2022-03-27 11:27:43'),
(324, 4, 'there is no extras', 'لا يوجد اضافات', '2022-03-27 11:04:28', '2022-03-27 11:26:56'),
(325, 4, 'the branch is required', 'الفرع مطلوب', '2022-03-27 11:04:39', '2022-03-27 11:13:34'),
(326, 4, 'the branch should be exists', 'يجب أن يكون الفرع موجود', '2022-03-27 11:04:39', '2022-03-27 11:13:34'),
(327, 4, 'you should choose a type from the stock', 'يجب عليك أختيار نوع من الموجودين', '2022-03-27 11:04:39', '2022-03-27 11:11:46'),
(328, 4, 'you should choose a minmum 1 product', 'يجب عليك أختيار منتج واحد على الأقل', '2022-03-27 11:04:39', '2022-03-27 11:12:23'),
(329, 4, 'statuses', 'الحالات', '2022-03-27 11:05:21', '2022-03-27 11:23:56'),
(330, 4, 'status name', 'أسم الحالة', '2022-03-27 11:06:11', '2022-03-27 11:23:55'),
(331, 4, 'default status', 'الحالة الأفتراضية', '2022-03-27 11:06:11', '2022-03-27 11:20:27'),
(332, 3, 'statuses', 'statuses', '2022-03-27 11:06:56', '2022-03-27 11:06:56'),
(333, 3, 'status name', 'status name', '2022-03-27 11:06:56', '2022-03-27 11:06:56'),
(334, 3, 'default status', 'default status', '2022-03-27 11:06:56', '2022-03-27 11:06:56'),
(335, 4, 'default', 'أفتراضى', '2022-03-27 11:07:52', '2022-03-27 11:20:27'),
(336, 4, 'create new status', 'انشاء حالة جديدة', '2022-03-27 11:08:31', '2022-03-27 11:14:14'),
(337, 4, 'back to statuses', 'الرجوع الى الحالات', '2022-03-27 11:09:09', '2022-03-27 11:15:25'),
(338, 4, 'the name is already exists', 'الأسم هذا موجود بالفعل', '2022-03-27 11:09:11', '2022-03-27 11:26:05'),
(339, 4, 'there is some thing error', 'يوجد خطأ ما', '2022-03-27 11:09:11', '2022-03-27 11:27:43'),
(340, 4, 'edit status', 'تعديل الحالة', '2022-03-27 11:10:29', '2022-03-27 11:15:58'),
(341, 4, 'create financial transactions', 'انشاء معاملة مالية', '2022-03-27 11:10:53', '2022-03-27 11:14:14'),
(342, 4, 'financial name', 'أسم المعاملة', '2022-03-27 11:10:53', '2022-03-27 11:11:07'),
(343, 4, 'type', 'النوع', '2022-03-27 11:10:53', '2022-03-27 11:11:46'),
(344, 4, 'income', 'ايراد', '2022-03-27 11:10:53', '2022-03-27 11:14:28'),
(345, 4, 'expenses', 'مصروفات', '2022-03-27 11:10:54', '2022-03-27 11:14:40'),
(346, 4, 'financial type', 'نوع المعاملة', '2022-03-27 11:10:54', '2022-03-27 11:11:46'),
(347, 4, 'branch', 'فرع', '2022-03-27 11:10:54', '2022-03-27 14:21:52'),
(348, 4, 'back to financial transactions', 'الرجوع الى المعاملات المالية', '2022-03-27 11:14:52', '2022-03-27 11:15:11'),
(349, 4, 'the transaction must be an expense or income', 'يجب أن تكون المعاملة مصروفًا أو ايراد', '2022-03-27 11:14:55', '2022-03-27 11:16:58'),
(350, 4, 'edit financial transactions', 'تعديل المعاملات المالية', '2022-03-27 11:15:34', '2022-03-27 11:15:58'),
(351, 4, 'incomes', 'الأيرادات', '2022-03-27 11:16:05', '2022-03-27 11:16:30'),
(352, 4, 'there is no incomes yet', 'لا يوجد ايرادات حاليا', '2022-03-27 11:16:05', '2022-03-27 11:16:30'),
(353, 4, 'there is no expenses yet', 'لا يوجد مصروفات حاليا', '2022-03-27 11:16:05', '2022-03-27 11:16:58'),
(354, 4, 'income name', 'أسم الأيراد', '2022-03-27 11:17:08', '2022-03-27 11:17:29'),
(355, 4, 'incomes owner\'s name', 'أسم صاحب الأيراد', '2022-03-27 11:17:08', '2022-03-27 11:17:30'),
(356, 4, 'phone', 'الهاتف', '2022-03-27 11:17:08', '2022-03-27 11:23:07'),
(357, 4, 'the amount', 'المبلغ', '2022-03-27 11:17:08', '2022-03-27 11:18:36'),
(358, 4, 'the phone', 'الهاتف', '2022-03-27 11:17:08', '2022-03-27 11:26:56'),
(359, 4, 'the notes', 'الملاحظات', '2022-03-27 11:17:08', '2022-03-27 11:26:05'),
(360, 3, 'create new category', 'create new category', '2022-03-27 11:35:27', '2022-03-27 11:35:27'),
(361, 3, 'category name', 'category name', '2022-03-27 11:35:27', '2022-03-27 11:35:27'),
(362, 3, 'products count', 'products count', '2022-03-27 11:35:28', '2022-03-27 11:35:28'),
(363, 3, 'available', 'available', '2022-03-27 11:35:28', '2022-03-27 11:35:28'),
(364, 3, 'appearance number', 'appearance number', '2022-03-27 11:35:28', '2022-03-27 11:35:28'),
(365, 4, 'create new category', 'انشاء صنف جديد', '2022-03-27 11:36:20', '2022-03-27 11:36:35'),
(366, 4, 'category name', 'أسم الصنف', '2022-03-27 11:36:20', '2022-03-27 11:36:34'),
(367, 4, 'products count', 'عدد المنتجات', '2022-03-27 11:36:20', '2022-03-27 11:36:52'),
(368, 4, 'available', 'مرئى', '2022-03-27 11:36:20', '2022-03-27 11:37:17'),
(369, 4, 'appearance number', 'رقم الظهور', '2022-03-27 11:36:20', '2022-03-27 11:37:05'),
(370, 4, 'updated successfully', 'updated successfully', '2022-03-27 11:37:38', '2022-03-27 11:37:38'),
(371, 4, 'not available', 'غير مرئى', '2022-03-27 11:37:43', '2022-03-27 11:37:50'),
(372, 3, 'category image', 'category image', '2022-03-27 11:40:39', '2022-03-27 11:40:39'),
(373, 3, 'back to categories', 'back to categories', '2022-03-27 11:40:39', '2022-03-27 11:40:39'),
(374, 4, 'category image', 'صورة الصنف', '2022-03-27 11:40:44', '2022-03-27 11:40:56'),
(375, 4, 'back to categories', 'الرجوع الى الأصناف', '2022-03-27 11:40:44', '2022-03-27 11:41:45'),
(376, 4, 'edit category', 'تعديل الصنف', '2022-03-27 11:42:35', '2022-03-27 11:44:27'),
(377, 3, 'create new food', 'create new food', '2022-03-27 11:47:12', '2022-03-27 11:47:12'),
(378, 3, 'category', 'category', '2022-03-27 11:47:12', '2022-03-27 11:47:12'),
(379, 4, 'create new food', 'انشاء أكلة جديدة', '2022-03-27 11:47:15', '2022-03-27 11:47:45'),
(380, 4, 'category', 'الصنف', '2022-03-27 11:47:15', '2022-03-27 11:47:25'),
(381, 3, 'choose category', 'choose category', '2022-03-27 11:59:14', '2022-03-27 11:59:14'),
(382, 3, 'not available', 'not available', '2022-03-27 11:59:15', '2022-03-27 11:59:15'),
(383, 3, 'from', 'from', '2022-03-27 11:59:15', '2022-03-27 11:59:15'),
(384, 3, 'to', 'to', '2022-03-27 11:59:15', '2022-03-27 11:59:15'),
(385, 4, 'choose category', 'أختر الصنف', '2022-03-27 11:59:18', '2022-03-27 11:59:33'),
(386, 4, 'from', 'from', '2022-03-27 11:59:18', '2022-03-27 11:59:18'),
(387, 4, 'to', 'to', '2022-03-27 11:59:18', '2022-03-27 11:59:18'),
(388, 3, 'you should choose maximum 5 images', 'you should choose maximum 5 images', '2022-03-27 13:25:56', '2022-03-27 13:25:56'),
(389, 3, 'back to foods', 'back to foods', '2022-03-27 13:25:56', '2022-03-27 13:25:56'),
(390, 3, 'add', 'add', '2022-03-27 13:25:56', '2022-03-27 13:25:56'),
(391, 3, 'remove', 'remove', '2022-03-27 13:25:57', '2022-03-27 13:25:57'),
(392, 4, 'you should choose maximum 5 images', 'you should choose maximum 5 images', '2022-03-27 13:26:21', '2022-03-27 13:26:21'),
(393, 4, 'back to foods', 'الرجوع الى الأكلات', '2022-03-27 13:26:21', '2022-03-27 13:26:37'),
(394, 4, 'add', 'اضافة', '2022-03-27 13:26:21', '2022-03-27 13:27:11'),
(395, 4, 'remove', 'ازالة', '2022-03-27 13:26:21', '2022-03-27 13:26:54'),
(396, 3, 'edit food', 'edit food', '2022-03-27 13:34:54', '2022-03-27 13:34:54'),
(397, 3, 'food images', 'food images', '2022-03-27 13:34:54', '2022-03-27 13:34:54'),
(398, 4, 'edit food', 'edit food', '2022-03-27 13:34:59', '2022-03-27 13:34:59'),
(399, 4, 'food images', 'food images', '2022-03-27 13:34:59', '2022-03-27 13:34:59'),
(400, 4, 'countries', 'البلاد', '2022-03-27 13:57:17', '2022-03-27 13:57:40'),
(401, 4, 'create new country', 'انشاء بلد جديدة', '2022-03-27 13:57:17', '2022-03-27 13:58:19'),
(402, 4, 'country name', 'أسم البلد', '2022-03-27 13:57:18', '2022-03-27 13:58:19'),
(403, 4, 'country code', 'كود البلد', '2022-03-27 13:57:18', '2022-03-27 13:58:18'),
(404, 4, 'country cities', 'مدن البلد', '2022-03-27 13:57:18', '2022-03-27 13:58:18'),
(405, 3, 'countries', 'countries', '2022-03-27 13:57:23', '2022-03-27 13:57:23'),
(406, 3, 'create new country', 'create new country', '2022-03-27 13:57:24', '2022-03-27 13:57:24'),
(407, 3, 'country name', 'country name', '2022-03-27 13:57:24', '2022-03-27 13:57:24'),
(408, 3, 'country code', 'country code', '2022-03-27 13:57:25', '2022-03-27 13:57:25'),
(409, 3, 'country cities', 'country cities', '2022-03-27 13:57:25', '2022-03-27 13:57:25'),
(410, 4, 'back to countries', 'الرجوع الى البلاد', '2022-03-27 13:59:54', '2022-03-27 14:00:07'),
(411, 4, 'edit country', 'تعديل البلد', '2022-03-27 14:01:26', '2022-03-27 14:01:35'),
(412, 4, 'cities', 'المدن', '2022-03-27 14:03:03', '2022-03-27 14:04:40'),
(413, 4, 'create new city', 'انشاء مدينة جديدة', '2022-03-27 14:04:32', '2022-03-27 14:04:57'),
(414, 4, 'city name', 'أسم المدينة', '2022-03-27 14:04:32', '2022-03-27 14:04:56'),
(415, 4, 'shipping price', 'سعر الشحن', '2022-03-27 14:04:32', '2022-03-27 14:05:08'),
(416, 4, 'back to cities', 'الرجوع الى المدن', '2022-03-27 14:15:14', '2022-03-27 14:15:27'),
(417, 4, 'edit city', 'تعديل المدينة', '2022-03-27 14:16:25', '2022-03-27 14:16:37'),
(418, 4, 'employees', 'الموظفين', '2022-03-27 14:20:27', '2022-03-27 14:20:38'),
(419, 4, 'create employee', 'انشاء موظف', '2022-03-27 14:20:27', '2022-03-27 14:20:48'),
(420, 4, 'employee name', 'أسم الموظف', '2022-03-27 14:20:28', '2022-03-27 14:20:55'),
(421, 4, 'banned', 'محظور', '2022-03-27 14:20:28', '2022-03-27 14:21:32'),
(422, 4, 'not banned', 'غير محظور', '2022-03-27 14:20:28', '2022-03-27 14:21:32'),
(423, 4, 'address', 'العنوان', '2022-03-27 14:20:28', '2022-03-27 14:22:00'),
(424, 4, 'employee in', 'موظف فى', '2022-03-27 14:20:28', '2022-03-27 14:20:49'),
(425, 4, 'create new employee', 'create new employee', '2022-03-27 14:24:58', '2022-03-27 14:24:58'),
(426, 4, 'all employees', 'كل الموظفين', '2022-03-27 14:24:58', '2022-03-27 14:28:49'),
(427, 4, 'profile picture', 'الصورة الشخصية', '2022-03-27 14:24:58', '2022-03-27 14:25:34'),
(428, 4, 'password confirmation', 'اتمام الرقم السرى', '2022-03-27 14:24:58', '2022-03-27 14:25:23'),
(429, 4, 'register', 'تسجيل الحساب', '2022-03-27 14:26:00', '2022-03-27 14:26:10'),
(430, 4, 'back to employees', 'الرجوع الى الموظفين', '2022-03-27 14:26:00', '2022-03-27 14:26:22'),
(431, 4, 'edit employee', 'تعديل الموظفين', '2022-03-27 14:28:32', '2022-03-27 14:28:41'),
(432, 3, 'employees', 'employees', '2022-03-27 14:29:10', '2022-03-27 14:29:10'),
(433, 3, 'create employee', 'create employee', '2022-03-27 14:29:10', '2022-03-27 14:29:10'),
(434, 3, 'employee name', 'employee name', '2022-03-27 14:29:10', '2022-03-27 14:29:10'),
(435, 3, 'banned', 'banned', '2022-03-27 14:29:10', '2022-03-27 14:29:10'),
(436, 3, 'not banned', 'not banned', '2022-03-27 14:29:10', '2022-03-27 14:29:10'),
(437, 3, 'address', 'address', '2022-03-27 14:29:10', '2022-03-27 14:29:10'),
(438, 3, 'employee in', 'employee in', '2022-03-27 14:29:10', '2022-03-27 14:29:10'),
(439, 4, 'users', 'المستخدمين', '2022-03-27 14:30:59', '2022-03-27 14:31:12'),
(440, 4, 'create new permession', 'انشاء صلاحية جديدة', '2022-03-27 14:33:01', '2022-03-27 14:35:18'),
(441, 4, 'permession name', 'أسم الصلاحية', '2022-03-27 14:33:01', '2022-03-27 14:33:11'),
(442, 4, 'permessions count', 'عدد الصلاحيات', '2022-03-27 14:33:01', '2022-03-27 14:33:25'),
(443, 3, 'create new permession', 'create new permession', '2022-03-27 14:33:31', '2022-03-27 14:33:31'),
(444, 3, 'permession name', 'permession name', '2022-03-27 14:33:31', '2022-03-27 14:33:31'),
(445, 3, 'permessions count', 'permessions count', '2022-03-27 14:33:31', '2022-03-27 14:33:31'),
(446, 4, 'back to permessions', 'الرجوع الى الصلاحيات', '2022-03-27 14:36:17', '2022-03-27 14:36:34'),
(447, 4, 'edit permession', 'تعديل الصلاحية', '2022-03-27 14:37:44', '2022-03-27 14:37:53'),
(448, 3, 'show orders', 'show orders', '2022-03-27 15:15:17', '2022-03-27 15:15:17'),
(449, 3, 'profile', 'profile', '2022-03-27 15:15:17', '2022-03-27 15:15:17'),
(450, 3, 'logout', 'logout', '2022-03-27 15:15:17', '2022-03-27 15:15:17'),
(451, 3, 'choose layouts', 'choose layouts', '2022-03-27 15:22:14', '2022-03-27 15:22:14'),
(452, 3, 'light mode', 'light mode', '2022-03-27 15:22:35', '2022-03-27 15:22:35'),
(453, 3, 'dark mode', 'dark mode', '2022-03-27 15:22:36', '2022-03-27 15:22:36'),
(454, 3, 'langs ​​and translation', 'langs ​​and translation', '2022-03-27 15:23:13', '2022-03-27 15:23:13'),
(455, 4, 'show orders', 'show orders', '2022-03-27 15:23:19', '2022-03-27 15:23:19'),
(456, 4, 'profile', 'profile', '2022-03-27 15:23:19', '2022-03-27 15:23:19'),
(457, 4, 'logout', 'logout', '2022-03-27 15:23:20', '2022-03-27 15:23:20'),
(458, 4, 'langs ​​and translation', 'اللغات والترجمة', '2022-03-27 15:23:20', '2022-03-27 16:07:08'),
(459, 4, 'choose layouts', 'choose layouts', '2022-03-27 15:23:20', '2022-03-27 15:23:20'),
(460, 4, 'light mode', 'light mode', '2022-03-27 15:23:20', '2022-03-27 15:23:20'),
(461, 4, 'dark mode', 'dark mode', '2022-03-27 15:23:20', '2022-03-27 15:23:20'),
(462, 3, 'edit profile', 'edit profile', '2022-03-27 16:06:45', '2022-03-27 16:06:45'),
(463, 3, 'profile picture', 'profile picture', '2022-03-27 16:06:45', '2022-03-27 16:06:45'),
(464, 3, 'back to dashboard', 'back to dashboard', '2022-03-27 16:06:45', '2022-03-27 16:06:45'),
(465, 4, 'edit profile', 'تعديل الحساب', '2022-03-27 16:07:21', '2022-03-27 16:07:44'),
(466, 4, 'back to dashboard', 'الرجوع الى لوحة التحكم', '2022-03-27 16:07:21', '2022-03-27 16:08:07'),
(467, 4, 'currencies', 'العملات', '2022-03-27 16:57:10', '2022-03-27 17:07:47'),
(468, 4, 'currency name', 'أسم العملة', '2022-03-27 17:07:19', '2022-03-27 17:08:00'),
(469, 4, 'currency code', 'كود العملة', '2022-03-27 17:07:19', '2022-03-27 17:08:07'),
(470, 4, 'symbol', 'رمز العملة', '2022-03-27 17:07:19', '2022-03-27 17:08:35'),
(471, 4, 'code', 'الكود', '2022-03-27 17:07:19', '2022-03-27 17:08:58'),
(472, 4, 'edit successfully', 'edit successfully', '2022-03-27 17:13:25', '2022-03-27 17:13:25'),
(473, 4, 'exchange to default currency', 'تحويل الى العملة الأفتراضية', '2022-03-27 17:35:43', '2022-03-27 18:04:31'),
(474, 4, 'password is incorrect', 'password is incorrect', '2022-03-27 18:35:23', '2022-03-27 18:35:23'),
(475, 4, 'loged out successfully', 'loged out successfully', '2022-03-27 18:54:44', '2022-03-27 18:54:44');

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
(27, NULL, 'mohamed hassan', 'user', NULL, NULL, 'mohamed@gmail.com', 'uploads/users/267669864_8077377025723184_5370032944555405772_n-1646075346.jpg', 0, NULL, '$2y$10$SFGBmJV1yFORF18jkl0bc.T0ACVw/l.eh7RlvDRsMtkMaM.YWs6tC', NULL, '2022-02-28 13:21:02', '2022-02-28 17:09:06'),
(28, NULL, 'test test', 'user', NULL, NULL, 'test@gmail.com', NULL, 0, NULL, '$2y$10$QqlpMZ9XuaKvxYY5nCRu3udraPZfTT3jQ98RXQnw3K6RUWFyU42Za', NULL, '2022-03-10 11:50:33', '2022-03-10 11:50:33'),
(30, 9, 'جرسون', 'sub-admin', '01152059120', 'elzamalek inter asdasdlasknda', 'test@garson.com', 'uploads/users/shirt-1646922178.png', 0, NULL, '$2y$10$AXQYJG5xYTXfOV9q3.RBsut9E0Yf1AoxFd682Xk7Iwaca2GgphPJ6', NULL, '2022-03-10 12:22:59', '2022-03-10 12:22:59'),
(31, NULL, 'hamdy emad', 'user', NULL, NULL, 'razereng0@gmail.com', NULL, 0, NULL, '$2y$10$17.fCaZBe5xCHK8IAtmOm.cLiacLzjlfGVg/h1OllTP3MF/2JU9im', NULL, '2022-03-13 10:17:10', '2022-03-13 10:17:10');

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
(23, 26, 7, '2022-02-28 10:50:45', '2022-02-28 10:50:45'),
(24, 30, 7, '2022-03-10 12:22:59', '2022-03-10 12:22:59');

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`);

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
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_cards`
--
ALTER TABLE `customer_cards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_cards_card_id_unique` (`card_id`),
  ADD KEY `customer_cards_user_id_foreign` (`user_id`);

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
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `languages_name_unique` (`name`),
  ADD UNIQUE KEY `languages_code_unique` (`code`);

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
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`order_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `payment_customers`
--
ALTER TABLE `payment_customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_customers_user_id_unique` (`user_id`);

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
  ADD KEY `statuses_histroy_order_id_foreign` (`order_id`),
  ADD KEY `statuses_histroy_status_id_foreign` (`status_id`),
  ADD KEY `statuses_histroy_user_id_foreign` (`user_id`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `translations_ibfk_1` (`lang_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer_cards`
--
ALTER TABLE `customer_cards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `orders_details`
--
ALTER TABLE `orders_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=269;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment_customers`
--
ALTER TABLE `payment_customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permessions`
--
ALTER TABLE `permessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `products_variations`
--
ALTER TABLE `products_variations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=476;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users_roles`
--
ALTER TABLE `users_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `businesses`
--
ALTER TABLE `businesses`
  ADD CONSTRAINT `businesses_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `customer_cards`
--
ALTER TABLE `customer_cards`
  ADD CONSTRAINT `customer_cards_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `payment_customers`
--
ALTER TABLE `payment_customers`
  ADD CONSTRAINT `payment_customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `statuses_histroy_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `statuses_histroy_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`),
  ADD CONSTRAINT `statuses_histroy_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `translations`
--
ALTER TABLE `translations`
  ADD CONSTRAINT `translations_ibfk_1` FOREIGN KEY (`lang_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
