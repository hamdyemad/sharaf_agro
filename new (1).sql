-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2022 at 03:16 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `new`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers_balance`
--

CREATE TABLE `customers_balance` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `balance` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers_responsible`
--

CREATE TABLE `customers_responsible` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `firebase_tokens`
--

CREATE TABLE `firebase_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `token` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `firebase_tokens`
--

INSERT INTO `firebase_tokens` (`id`, `user_id`, `token`, `created_at`, `updated_at`) VALUES
(17, 1, 'ffce06wGWGC-NKaARc_SUW:APA91bHjsiZhFE9NrAtQSFKL8tZlg_rtvMBxixHc_IqLsWxBxDIgujIfygOaTVeo6LpX31tHrMZnSpod5euhYChKGXb9DbDF0U4Mvv0dY9KW3EBMXaUEZIJKudoFKt3pAI9_BV6-dhjP', '2022-04-30 11:59:28', '2022-04-30 11:59:28'),
(21, 1, 'dEd8mPKTq9ycNm29hsnX9a:APA91bH0G7KUzOvsM1WWvSoiV81KuLKaUGjcOpPZYq5DuMYfBpSbPcpgK5JDQ6yXnclwwOTsZysO9rzFhsbBk8sd4XQg6qugfe4010Zkk1aeRUyHaQgN1vH7jSWZbH4h8M22MNdyuwTU', '2022-05-01 10:55:41', '2022-05-01 10:55:41'),
(22, 1, 'dEd8mPKTq9ycNm29hsnX9a:APA91bF8_lj3-2gjj0ngtMYJGU7LNVDQ4h5cX6xnG0Tc_q0dDsulsJPbfwrXdhn1IP41hZ3F7H7xqOd3kwhcOHBo-d9M5fKjgC8zO1GUdhIZqSZenMuGeiJcx6016DMtow58akOkm784', '2022-05-01 10:57:02', '2022-05-01 10:57:02');

-- --------------------------------------------------------

--
-- Table structure for table `inquires_view`
--

CREATE TABLE `inquires_view` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `inquire_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `viewed` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `status_id` bigint(20) UNSIGNED NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(12, '2014_10_12_000000_create_users_table', 1),
(13, '2014_10_12_100000_create_password_resets_table', 1),
(14, '2019_08_19_000000_create_failed_jobs_table', 1),
(15, '2022_02_09_101308_create_categories_table', 1),
(16, '2022_02_09_101309_create_sub_categories_table', 1),
(17, '2022_02_10_115931_create_settings_table', 1),
(18, '2022_02_11_143944_create_permessions_table', 1),
(19, '2022_02_11_144056_create_roles_table', 1),
(20, '2022_02_11_144149_create_roles_permessions_table', 1),
(21, '2022_02_11_144255_create_users_roles_table', 1),
(22, '2022_02_15_121001_create_statuses_table', 1),
(26, '2022_04_19_144849_create_user_categories_table', 2),
(27, '2022_04_20_111015_create_user_sub_categories_table', 2),
(28, '2022_04_20_124307_create_customers_responsible_table', 3),
(30, '2022_04_20_133601_create_customers_balance_table', 4),
(33, '2022_04_21_124331_create_orders_table', 5),
(36, '2022_04_22_021421_create_orders_under_work_table', 6),
(37, '2022_04_23_134454_create_orders_under_work_viewers_table', 7),
(42, '2022_04_23_152151_create_inquiries_table', 8),
(43, '2022_04_23_175043_create_inquires_view_table', 8),
(44, '2022_04_24_002131_create_news_table', 9),
(45, '2022_04_24_015735_create_news_view_table', 10),
(46, '2022_04_25_010443_orders_view_table', 11),
(48, '2022_04_26_172836_create_firebase_tokens_table', 12);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `images` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `send_notify` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news_view`
--

CREATE TABLE `news_view` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `new_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `viewed` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `status_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `files` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submission_date` date DEFAULT NULL,
  `expected_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `expected_notify` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders_under_work`
--

CREATE TABLE `orders_under_work` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `status_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `files` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders_under_work_viewers`
--

CREATE TABLE `orders_under_work_viewers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_under_work_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `viewed` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders_view`
--

CREATE TABLE `orders_view` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `viewed` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
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
(34, 'الصلاحيات', 'عرض الكل', 'roles.index', '2022-02-11 16:29:31', '2022-02-11 16:29:31'),
(35, 'الصلاحيات', 'انشاء', 'roles.create', '2022-02-11 16:29:40', '2022-02-11 16:29:40'),
(36, 'الصلاحيات', 'تعديل', 'roles.edit', '2022-02-11 16:29:48', '2022-02-11 16:29:48'),
(37, 'الصلاحيات', 'ازالة', 'roles.destroy', '2022-02-11 16:29:56', '2022-02-11 16:29:56'),
(61, 'الأقسام', 'عرض الكل', 'categories.index', '2022-04-19 10:43:43', '2022-04-19 10:43:43'),
(62, 'الأقسام', 'انشاء', 'categories.create', '2022-04-19 10:43:53', '2022-04-19 10:43:53'),
(63, 'الأقسام', 'تعديل', 'categories.edit', '2022-04-19 10:44:00', '2022-04-19 10:44:00'),
(64, 'الأقسام', 'ازالة', 'categories.destroy', '2022-04-19 10:44:09', '2022-04-19 10:44:09'),
(65, 'الموظفين', 'عرض الكل', 'users.index', '2022-04-20 12:15:43', '2022-04-20 12:15:43'),
(66, 'الموظفين', 'انشاء', 'users.create', '2022-04-20 12:16:04', '2022-04-20 12:16:04'),
(67, 'الموظفين', 'تعديل', 'users.edit', '2022-04-20 12:16:11', '2022-04-20 12:16:11'),
(68, 'الموظفين', 'ازالة', 'users.destroy', '2022-04-20 12:16:18', '2022-04-20 12:16:18'),
(69, 'الشركات', 'عرض الكل', 'customers.index', '2022-04-20 12:16:57', '2022-04-20 12:16:57'),
(70, 'الشركات', 'انشاء', 'customers.create', '2022-04-20 12:17:08', '2022-04-20 12:17:08'),
(71, 'الشركات', 'تعديل', 'customers.edit', '2022-04-20 12:17:16', '2022-04-20 12:17:16'),
(72, 'الشركات', 'ازالة', 'customers.destroy', '2022-04-20 12:17:26', '2022-04-20 12:17:26'),
(73, 'رصيد الشركات', 'عرض الكل', 'balances.index', '2022-04-20 12:17:56', '2022-04-20 12:17:56'),
(74, 'رصيد الشركات', 'انشاء', 'balances.create', '2022-04-20 12:18:06', '2022-04-20 12:18:06'),
(75, 'رصيد الشركات', 'تعديل', 'balances.edit', '2022-04-20 12:18:13', '2022-04-20 12:18:13'),
(76, 'رصيد الشركات', 'ازالة', 'balances.destroy', '2022-04-20 12:18:22', '2022-04-20 12:18:22'),
(77, 'الأعدادات العامة', 'الأعدادات العامة', 'settings.edit', '2022-04-20 13:56:56', '2022-04-20 13:56:56'),
(78, 'الطلبات', 'عرض الكل', 'orders.index', '2022-04-21 08:38:55', '2022-04-21 08:38:55'),
(79, 'الطلبات', 'انشاء', 'orders.create', '2022-04-21 08:39:06', '2022-04-21 08:39:06'),
(80, 'الطلبات', 'تعديل', 'orders.edit', '2022-04-21 08:39:13', '2022-04-21 08:39:13'),
(81, 'الطلبات', 'ازالة', 'orders.destroy', '2022-04-21 08:39:23', '2022-04-21 08:39:23'),
(82, 'الطلبات', 'اظهار', 'orders.show', '2022-04-21 13:46:55', '2022-04-21 13:46:55'),
(85, 'الرسائل', 'عرض الكل', 'orders_under_work.index', '2022-04-22 00:41:56', '2022-04-22 00:41:56'),
(86, 'الرسائل', 'ازالة', 'orders_under_work.destroy', '2022-04-22 00:42:37', '2022-04-22 00:42:37'),
(88, 'الرسائل', 'اظهار', 'orders_under_work.show', '2022-04-23 10:17:50', '2022-04-23 10:17:50'),
(89, 'الأخبار', 'عرض الكل', 'news.index', '2022-04-23 22:27:30', '2022-04-23 22:27:30'),
(90, 'الأخبار', 'انشاء', 'news.create', '2022-04-23 22:27:42', '2022-04-23 22:27:42'),
(91, 'الأخبار', 'تعديل', 'news.edit', '2022-04-23 22:27:53', '2022-04-23 22:27:53'),
(92, 'الأخبار', 'ازالة', 'news.destroy', '2022-04-23 22:28:01', '2022-04-23 22:28:01'),
(93, 'الأخبار', 'اظهار', 'news.show', '2022-04-24 00:10:14', '2022-04-24 00:10:14'),
(94, 'الأستفسارات', 'عرض الكل', 'inquires.index', '2022-04-25 13:10:15', '2022-04-25 13:10:15'),
(95, 'الأستفسارات', 'اظهار', 'inquires.show', '2022-04-25 13:11:03', '2022-04-25 13:11:03'),
(96, 'الأستفسارات', 'ازالة', 'inquires.destroy', '2022-04-25 13:11:24', '2022-04-25 13:11:24'),
(97, 'الأستفسارات', 'تعديل', 'inquires.edit', '2022-04-25 13:14:32', '2022-04-25 13:14:32'),
(99, 'الرسائل', 'تعديل الحالات', 'orders_under_work.update_status', '2022-04-25 13:20:46', '2022-04-25 13:20:46'),
(100, 'الأستفسارات', 'تعديل الحالات', 'inquires.update_status', '2022-04-25 13:30:48', '2022-04-25 13:30:48'),
(101, 'الرسائل', 'تعديل', 'orders_under_work.edit', '2022-04-28 11:40:36', '2022-04-28 11:40:36'),
(102, 'الطلبات', 'صفحة تنبيهات الطلبات', 'orders.alerts.index', '2022-05-01 09:42:08', '2022-05-01 09:42:08'),
(104, 'الطلبات', 'تنبيهات التجديدات', 'orders.alerts.renovations', '2022-05-01 09:55:02', '2022-05-01 09:55:02'),
(105, 'الرسائل', 'التنبيهات اليومية', 'orders_under_work.alerts', '2022-05-01 10:29:32', '2022-05-01 10:29:32');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `type`, `value`, `created_at`, `updated_at`) VALUES
(1, 'logo', 'uploads/settings/logo-1650806313.png', '2022-04-24 11:18:03', '2022-04-24 11:18:33'),
(2, 'project_name', 'مشروع زراعى', '2022-04-24 11:18:03', '2022-04-24 11:18:03'),
(3, 'expected_date', '15', '2022-04-25 00:03:03', '2022-04-28 09:41:09'),
(4, 'expiry_date', '15', '2022-05-01 10:08:15', '2022-05-01 10:08:15');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default_val` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`, `default_val`, `created_at`, `updated_at`) VALUES
(1, 'تحت الأنشاء', 1, '2022-04-21 11:31:38', '2022-04-21 11:31:41'),
(2, 'مكتمل', 0, '2022-04-21 11:31:24', '2022-04-21 11:31:24'),
(3, 'تم التقديم', 0, '2022-04-21 11:40:26', '2022-04-21 11:40:26'),
(4, 'تم القبول', 0, '2022-04-22 01:57:01', '2022-04-22 01:57:01'),
(5, 'رفض', 0, '2022-04-22 01:57:15', '2022-04-22 01:57:15'),
(6, 'معلق', 0, '2022-04-22 02:31:00', '2022-04-22 02:31:00'),
(7, 'تم التواصل', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('admin','user','sub-admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banned` tinyint(1) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `type`, `phone`, `address`, `email`, `username`, `avatar`, `banned`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', '01152059120', NULL, 'admin@admin.com', 'admin', NULL, 0, NULL, '$2y$10$jSPaRYxOyW8lAJPFqB/i6u8TcR578sqI4KZw6Wq0THaACXvy6b5hG', NULL, NULL, '2022-04-30 12:12:57');

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

-- --------------------------------------------------------

--
-- Table structure for table `user_categories`
--

CREATE TABLE `user_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_categories`
--

CREATE TABLE `user_sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `customers_balance`
--
ALTER TABLE `customers_balance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_balance_user_id_unique` (`user_id`);

--
-- Indexes for table `customers_responsible`
--
ALTER TABLE `customers_responsible`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_responsible_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `firebase_tokens`
--
ALTER TABLE `firebase_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `firebase_tokens_token_unique` (`token`) USING HASH,
  ADD KEY `firebase_tokens_user_id_foreign` (`user_id`);

--
-- Indexes for table `inquires_view`
--
ALTER TABLE `inquires_view`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inquires_view_inquire_id_user_id_unique` (`inquire_id`,`user_id`),
  ADD KEY `inquires_view_user_id_foreign` (`user_id`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inquiries_category_id_foreign` (`category_id`),
  ADD KEY `inquiries_customer_id_foreign` (`customer_id`),
  ADD KEY `inquiries_status_id_foreign` (`status_id`),
  ADD KEY `inquiries_sub_category_id_foreign` (`sub_category_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news_view`
--
ALTER TABLE `news_view`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_view_new_id_user_id_unique` (`new_id`,`user_id`),
  ADD KEY `news_view_user_id_foreign` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_category_id_foreign` (`category_id`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`),
  ADD KEY `orders_ibfk_1` (`employee_id`),
  ADD KEY `orders_status_id_foreign` (`status_id`),
  ADD KEY `orders_sub_category_id_foreign` (`sub_category_id`);

--
-- Indexes for table `orders_under_work`
--
ALTER TABLE `orders_under_work`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_under_work_category_id_foreign` (`category_id`),
  ADD KEY `orders_under_work_customer_id_foreign` (`customer_id`),
  ADD KEY `orders_under_work_status_id_foreign` (`status_id`),
  ADD KEY `orders_under_work_sub_category_id_foreign` (`sub_category_id`);

--
-- Indexes for table `orders_under_work_viewers`
--
ALTER TABLE `orders_under_work_viewers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_under_work_viewers_order_under_work_id_user_id_unique` (`order_under_work_id`,`user_id`),
  ADD KEY `orders_under_work_viewers_user_id_foreign` (`user_id`);

--
-- Indexes for table `orders_view`
--
ALTER TABLE `orders_view`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_view_order_id_user_id_unique` (`order_id`,`user_id`),
  ADD KEY `orders_view_user_id_foreign` (`user_id`);

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
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Indexes for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_roles_user_id_role_id_unique` (`user_id`,`role_id`),
  ADD KEY `users_roles_role_id_foreign` (`role_id`);

--
-- Indexes for table `user_categories`
--
ALTER TABLE `user_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_categories_user_id_category_id_unique` (`user_id`,`category_id`),
  ADD KEY `user_categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `user_sub_categories`
--
ALTER TABLE `user_sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_sub_categories_user_id_sub_category_id_unique` (`user_id`,`sub_category_id`),
  ADD KEY `user_sub_categories_sub_category_id_foreign` (`sub_category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `customers_balance`
--
ALTER TABLE `customers_balance`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `customers_responsible`
--
ALTER TABLE `customers_responsible`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `firebase_tokens`
--
ALTER TABLE `firebase_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `inquires_view`
--
ALTER TABLE `inquires_view`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `news_view`
--
ALTER TABLE `news_view`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `orders_under_work`
--
ALTER TABLE `orders_under_work`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `orders_under_work_viewers`
--
ALTER TABLE `orders_under_work_viewers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `orders_view`
--
ALTER TABLE `orders_view`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `permessions`
--
ALTER TABLE `permessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `roles_permessions`
--
ALTER TABLE `roles_permessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=474;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users_roles`
--
ALTER TABLE `users_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `user_categories`
--
ALTER TABLE `user_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `user_sub_categories`
--
ALTER TABLE `user_sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customers_balance`
--
ALTER TABLE `customers_balance`
  ADD CONSTRAINT `customers_balance_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customers_responsible`
--
ALTER TABLE `customers_responsible`
  ADD CONSTRAINT `customers_responsible_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `firebase_tokens`
--
ALTER TABLE `firebase_tokens`
  ADD CONSTRAINT `firebase_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inquires_view`
--
ALTER TABLE `inquires_view`
  ADD CONSTRAINT `inquires_view_inquire_id_foreign` FOREIGN KEY (`inquire_id`) REFERENCES `inquiries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inquires_view_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD CONSTRAINT `inquiries_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inquiries_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inquiries_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inquiries_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `news_view`
--
ALTER TABLE `news_view`
  ADD CONSTRAINT `news_view_new_id_foreign` FOREIGN KEY (`new_id`) REFERENCES `news` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `news_view_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders_under_work`
--
ALTER TABLE `orders_under_work`
  ADD CONSTRAINT `orders_under_work_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_under_work_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_under_work_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_under_work_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders_under_work_viewers`
--
ALTER TABLE `orders_under_work_viewers`
  ADD CONSTRAINT `orders_under_work_viewers_order_under_work_id_foreign` FOREIGN KEY (`order_under_work_id`) REFERENCES `orders_under_work` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_under_work_viewers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders_view`
--
ALTER TABLE `orders_view`
  ADD CONSTRAINT `orders_view_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_view_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `roles_permessions`
--
ALTER TABLE `roles_permessions`
  ADD CONSTRAINT `roles_permessions_permession_id_foreign` FOREIGN KEY (`permession_id`) REFERENCES `permessions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `roles_permessions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD CONSTRAINT `users_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_categories`
--
ALTER TABLE `user_categories`
  ADD CONSTRAINT `user_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_sub_categories`
--
ALTER TABLE `user_sub_categories`
  ADD CONSTRAINT `user_sub_categories_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_sub_categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
