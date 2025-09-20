-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 20, 2025 at 01:38 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stockynew`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int NOT NULL,
  `account_num` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `account_name` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `initial_balance` double NOT NULL,
  `balance` double NOT NULL,
  `note` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `account_num`, `account_name`, `initial_balance`, `balance`, `note`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1234567890', 'Koppi', 500000000, 499785000, NULL, '2024-05-27 06:29:37.000000', '2024-05-27 07:06:52.000000', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `adjustments`
--

CREATE TABLE `adjustments` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `date` date NOT NULL,
  `Ref` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `warehouse_id` int NOT NULL,
  `items` double DEFAULT '0',
  `notes` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adjustments`
--

INSERT INTO `adjustments` (`id`, `user_id`, `date`, `Ref`, `warehouse_id`, `items`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '2024-05-27', 'AD_1111', 1, 1, 'TEST', '2024-05-27 06:50:25.000000', '2024-05-27 06:50:25.000000', NULL),
(2, 1, '2024-05-27', 'AD_1112', 1, 1, 'Add 2 Product Adjustment', '2024-05-27 06:57:26.000000', '2024-05-27 06:57:26.000000', NULL),
(6, 129, '2024-10-04', 'AD_1113', 7, 1, 'TEST Adjustments', '2024-10-04 04:27:54.000000', '2024-10-04 04:27:54.000000', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `adjustment_details`
--

CREATE TABLE `adjustment_details` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `adjustment_id` int NOT NULL,
  `warehouse_id` int UNSIGNED DEFAULT NULL,
  `product_variant_id` int DEFAULT NULL,
  `quantity` double NOT NULL,
  `type` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adjustment_details`
--

INSERT INTO `adjustment_details` (`id`, `product_id`, `adjustment_id`, `warehouse_id`, `product_variant_id`, `quantity`, `type`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 1, NULL, 3, 'add', NULL, '2024-05-27 06:54:08.000000'),
(2, 3, 2, 1, NULL, 2, 'add', NULL, NULL),
(3, 24, 6, 7, NULL, 6, 'add', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `company_id` int NOT NULL,
  `employee_id` int NOT NULL,
  `date` date NOT NULL,
  `clock_in` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `clock_in_ip` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `clock_out` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `clock_out_ip` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `clock_in_out` tinyint(1) NOT NULL,
  `depart_early` varchar(191) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '00:00',
  `late_time` varchar(191) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '00:00',
  `overtime` varchar(191) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '00:00',
  `total_work` varchar(191) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '00:00',
  `total_rest` varchar(191) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '00:00',
  `status` varchar(191) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'present',
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int NOT NULL,
  `name` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(192) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` varchar(192) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `description`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Vention', NULL, 'no-image.png', '2024-10-03 09:24:38.000000', '2024-10-03 09:24:38.000000', NULL),
(2, 'brand1', NULL, 'no-image.png', '2025-09-19 09:33:33.000000', '2025-09-19 09:33:33.000000', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `code` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `code`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Oil-1', 'Oil', '2024-05-17 10:01:52.000000', '2024-05-17 10:01:52.000000', NULL),
(2, 'P11111', 'Laptop', '2024-08-20 06:24:48.000000', '2024-08-20 06:24:48.000000', NULL),
(3, 'DE0', 'Default', '2024-09-05 07:24:43.000000', '2024-09-05 07:24:43.000000', NULL),
(4, 'Kabel', 'Kabel', '2024-10-03 09:24:57.000000', '2024-10-03 09:24:57.000000', NULL),
(5, '89708-', 'category1', '2025-09-19 09:01:47.000000', '2025-09-19 09:01:47.000000', NULL),
(6, '76234', 'category2', '2025-09-19 09:31:55.000000', '2025-09-19 09:31:55.000000', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `code` int NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tax_number` varchar(192) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `adresse` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `code`, `email`, `country`, `city`, `phone`, `tax_number`, `adresse`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'walk-in-customer', 1, 'walk-in-customer@example.com', 'bangladesh', 'dhaka', '123456780', NULL, 'N45 , Dhaka', NULL, NULL, NULL),
(2, 'Malih Sitepuh', 2, 'awokwokmalih@malih.com', 'Espanola', 'Gwennchanna', '08128281293', NULL, NULL, '2024-06-12 09:30:23.000000', '2024-06-12 09:30:23.000000', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `count_stock`
--

CREATE TABLE `count_stock` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `date` date NOT NULL,
  `warehouse_id` int NOT NULL,
  `file_stock` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `count_stock`
--

INSERT INTO `count_stock` (`id`, `user_id`, `date`, `warehouse_id`, `file_stock`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '2024-05-20', 1, 'stock_export_20240520165733.xlsx', '2024-05-20 09:57:34.000000', '2024-05-20 09:57:34.000000', NULL),
(2, 1, '2024-05-27', 1, 'stock_export_20240527114712.xlsx', '2024-05-27 04:47:12.000000', '2024-05-27 04:47:12.000000', NULL),
(3, 1, '2024-08-22', 1, 'stock_export_20240822130606.xlsx', '2024-08-22 06:06:07.000000', '2024-08-22 06:06:07.000000', NULL),
(4, 1, '2024-09-13', 7, 'stock_export_20240913133022.xlsx', '2024-09-13 06:30:22.000000', '2024-09-13 06:30:22.000000', NULL),
(5, 1, '2024-09-13', 8, 'stock_export_20240913133049.xlsx', '2024-09-13 06:30:49.000000', '2024-09-13 06:30:49.000000', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int NOT NULL,
  `code` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `symbol` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `code`, `name`, `symbol`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'USD', 'US Dollar', '$', NULL, NULL, NULL),
(2, 'IDR', 'Rupiah', 'Rp.', '2024-05-20 04:05:34.000000', '2024-05-20 04:05:34.000000', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int NOT NULL,
  `department` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `company_id` int NOT NULL,
  `department_head` int DEFAULT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `date` date NOT NULL,
  `deposit_ref` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `account_id` int DEFAULT NULL,
  `deposit_category_id` int NOT NULL,
  `amount` double NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposit_categories`
--

CREATE TABLE `deposit_categories` (
  `id` int NOT NULL,
  `title` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` int NOT NULL,
  `company_id` int NOT NULL,
  `department_id` int NOT NULL,
  `designation` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `draft_sales`
--

CREATE TABLE `draft_sales` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `date` date NOT NULL,
  `Ref` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `client_id` int NOT NULL,
  `warehouse_id` int NOT NULL,
  `tax_rate` double DEFAULT '0',
  `TaxNet` double DEFAULT '0',
  `discount` double DEFAULT '0',
  `shipping` double DEFAULT '0',
  `GrandTotal` double NOT NULL DEFAULT '0',
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `draft_sales`
--

INSERT INTO `draft_sales` (`id`, `user_id`, `date`, `Ref`, `client_id`, `warehouse_id`, `tax_rate`, `TaxNet`, `discount`, `shipping`, `GrandTotal`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '2024-06-12', 'DR_1111', 2, 1, 10000, 51000000, 10000, 0, 51510000, '2024-06-12 10:18:43.000000', '2024-06-12 10:18:52.000000', '2024-06-12 10:18:52');

-- --------------------------------------------------------

--
-- Table structure for table `draft_sale_details`
--

CREATE TABLE `draft_sale_details` (
  `id` int NOT NULL,
  `date` date NOT NULL,
  `draft_sale_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_variant_id` int DEFAULT NULL,
  `imei_number` text COLLATE utf8mb4_general_ci,
  `price` double NOT NULL,
  `sale_unit_id` int DEFAULT NULL,
  `TaxNet` double DEFAULT NULL,
  `tax_method` varchar(192) COLLATE utf8mb4_general_ci DEFAULT '1',
  `discount` double DEFAULT NULL,
  `discount_method` varchar(192) COLLATE utf8mb4_general_ci DEFAULT '1',
  `total` double NOT NULL,
  `quantity` double NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ecommerce_clients`
--

CREATE TABLE `ecommerce_clients` (
  `id` int NOT NULL,
  `client_id` int NOT NULL,
  `username` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_messages`
--

CREATE TABLE `email_messages` (
  `id` int NOT NULL,
  `name` text COLLATE utf8mb4_general_ci,
  `subject` text COLLATE utf8mb4_general_ci,
  `body` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `email_messages`
--

INSERT INTO `email_messages` (`id`, `name`, `subject`, `body`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'sale', 'Thank you for your purchase!', '<h1><b><span style=\'font-size:14px;\'>Dear</span><span style=\'font-size:14px;\'>  </span></b><span style=\'font-size:14px;\'><b>{contact_name},</b></span></h1><p><span style=\'font-size:14px;\'>Thank you for your purchase! Your invoice number is {invoice_number}.</span></p><p><span style=\'font-size:14px;\'>If you have any questions or concerns, please don\'t hesitate to reach out to us. We are here to help!</span></p><p><span style=\'font-size:14px;\'>Best regards,</span></p><p><b>{business_name}</b></p>', NULL, NULL, NULL),
(2, 'quotation', 'Thank you for your interest in our products !', '<p><b><span style=\"font-size:14px;\">Dear {contact_name},</span></b></p><p>Thank you for your interest in our products. Your quotation number is {quotation_number}.</p><p>Please let us know if you have any questions or concerns regarding your quotation. We are here to assist you.</p><p>Best regards,</p><p><b><span style=\"font-size:14px;\">{business_name}</span></b></p>', NULL, NULL, NULL),
(3, 'payment_received', 'Payment Received - Thank You', '<p><b><span style=\"font-size:14px;\">Dear {contact_name},</span></b></p><p>Thank you for making your payment. We have received it and it has been processed successfully.</p><p>If you have any further questions or concerns, please don\'t hesitate to reach out to us. We are always here to help.</p><p>Best regards,</p><p><b><span style=\"font-size:14px;\">{business_name}</span></b></p>', NULL, NULL, NULL),
(4, 'purchase', 'Thank You for Your Cooperation and Service', '<p><b><span style=\"font-size:14px;\">Dear {contact_name},</span></b></p><p>I recently made a purchase from your company and I wanted to thank you for your cooperation and service. My invoice number is {invoice_number} .</p><p>If you have any questions or concerns regarding my purchase, please don\'t hesitate to contact me. I am here to make sure I have a positive experience with your company.</p><p>Best regards,</p><p><b><span style=\"font-size:14px;\">{business_name}</span></b></p>', NULL, NULL, NULL),
(5, 'payment_sent', 'Payment Sent - Thank You for Your Service', '<p><b><span style=\"font-size:14px;\">Dear {contact_name},</span></b></p><p>We have just sent the payment . We appreciate your prompt attention to this matter and the high level of service you provide.</p><p>If you need any further information or clarification, please do not hesitate to reach out to us. We are here to help.</p><p>Best regards,</p><p><b><span style=\"font-size:14px;\">{business_name}</span></b></p>', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int NOT NULL,
  `firstname` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(192) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(192) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `country` varchar(192) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `city` varchar(192) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `province` varchar(192) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `zipcode` varchar(192) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(192) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gender` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `resume` varchar(192) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `avatar` varchar(192) COLLATE utf8mb4_general_ci DEFAULT 'no_avatar.png',
  `document` varchar(192) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `company_id` int NOT NULL,
  `department_id` int NOT NULL,
  `designation_id` int NOT NULL,
  `office_shift_id` int NOT NULL,
  `remaining_leave` tinyint(1) DEFAULT '0',
  `total_leave` tinyint(1) DEFAULT '0',
  `hourly_rate` decimal(10,2) DEFAULT '0.00',
  `basic_salary` decimal(10,2) DEFAULT '0.00',
  `employment_type` varchar(192) COLLATE utf8mb4_general_ci DEFAULT 'full_time',
  `leaving_date` date DEFAULT NULL,
  `marital_status` varchar(192) COLLATE utf8mb4_general_ci DEFAULT 'single',
  `facebook` varchar(192) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `skype` varchar(192) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `whatsapp` varchar(192) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `twitter` varchar(192) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `linkedin` varchar(192) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_accounts`
--

CREATE TABLE `employee_accounts` (
  `id` int NOT NULL,
  `employee_id` int NOT NULL,
  `bank_name` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `bank_branch` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `account_no` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `note` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_experiences`
--

CREATE TABLE `employee_experiences` (
  `id` int NOT NULL,
  `employee_id` int NOT NULL,
  `title` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `company_name` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `location` varchar(192) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `employment_type` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int NOT NULL,
  `date` date NOT NULL,
  `Ref` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int NOT NULL,
  `expense_category_id` int NOT NULL,
  `warehouse_id` int NOT NULL,
  `account_id` int DEFAULT NULL,
  `details` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `amount` double NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expense_categories`
--

CREATE TABLE `expense_categories` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` int NOT NULL,
  `title` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `company_id` int NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` int NOT NULL,
  `employee_id` int NOT NULL,
  `company_id` int NOT NULL,
  `department_id` int NOT NULL,
  `leave_type_id` int NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `days` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `reason` text COLLATE utf8mb4_general_ci,
  `attachment` varchar(192) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `half_day` tinyint(1) DEFAULT NULL,
  `status` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` int NOT NULL,
  `title` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(2, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(3, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(4, '2016_06_01_000004_create_oauth_clients_table', 1),
(5, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(6, '2021_03_08_020247_create_adjustment_details_table', 1),
(7, '2021_03_08_020247_create_adjustments_table', 1),
(8, '2021_03_08_020247_create_brands_table', 1),
(9, '2021_03_08_020247_create_categories_table', 1),
(10, '2021_03_08_020247_create_clients_table', 1),
(11, '2021_03_08_020247_create_currencies_table', 1),
(12, '2021_03_08_020247_create_expense_categories_table', 1),
(13, '2021_03_08_020247_create_expenses_table', 1),
(14, '2021_03_08_020247_create_password_resets_table', 1),
(15, '2021_03_08_020247_create_payment_purchase_returns_table', 1),
(16, '2021_03_08_020247_create_payment_purchases_table', 1),
(17, '2021_03_08_020247_create_payment_sale_returns_table', 1),
(18, '2021_03_08_020247_create_payment_sales_table', 1),
(19, '2021_03_08_020247_create_payment_with_credit_card_table', 1),
(20, '2021_03_08_020247_create_permission_role_table', 1),
(21, '2021_03_08_020247_create_permissions_table', 1),
(22, '2021_03_08_020247_create_product_variants_table', 1),
(23, '2021_03_08_020247_create_product_warehouse_table', 1),
(24, '2021_03_08_020247_create_products_table', 1),
(25, '2021_03_08_020247_create_providers_table', 1),
(26, '2021_03_08_020247_create_purchase_details_table', 1),
(27, '2021_03_08_020247_create_purchase_return_details_table', 1),
(28, '2021_03_08_020247_create_purchase_returns_table', 1),
(29, '2021_03_08_020247_create_purchases_table', 1),
(30, '2021_03_08_020247_create_quotation_details_table', 1),
(31, '2021_03_08_020247_create_quotations_table', 1),
(32, '2021_03_08_020247_create_role_user_table', 1),
(33, '2021_03_08_020247_create_roles_table', 1),
(34, '2021_03_08_020247_create_sale_details_table', 1),
(35, '2021_03_08_020247_create_sale_return_details_table', 1),
(36, '2021_03_08_020247_create_sale_returns_table', 1),
(37, '2021_03_08_020247_create_sales_table', 1),
(38, '2021_03_08_020247_create_serveurs_table', 1),
(39, '2021_03_08_020247_create_settings_table', 1),
(40, '2021_03_08_020247_create_transfer_details_table', 1),
(41, '2021_03_08_020247_create_transfers_table', 1),
(42, '2021_03_08_020247_create_units_table', 1),
(43, '2021_03_08_020247_create_users_table', 1),
(44, '2021_03_08_020247_create_warehouses_table', 1),
(45, '2021_03_08_020248_add_status_to_roles_table', 1),
(46, '2021_03_08_020251_add_foreign_keys_to_adjustment_details_table', 1),
(47, '2021_03_08_020251_add_foreign_keys_to_adjustments_table', 1),
(48, '2021_03_08_020251_add_foreign_keys_to_expense_categories_table', 1),
(49, '2021_03_08_020251_add_foreign_keys_to_expenses_table', 1),
(50, '2021_03_08_020251_add_foreign_keys_to_payment_purchase_returns_table', 1),
(51, '2021_03_08_020251_add_foreign_keys_to_payment_purchases_table', 1),
(52, '2021_03_08_020251_add_foreign_keys_to_payment_sale_returns_table', 1),
(53, '2021_03_08_020251_add_foreign_keys_to_payment_sales_table', 1),
(54, '2021_03_08_020251_add_foreign_keys_to_permission_role_table', 1),
(55, '2021_03_08_020251_add_foreign_keys_to_product_variants_table', 1),
(56, '2021_03_08_020251_add_foreign_keys_to_product_warehouse_table', 1),
(57, '2021_03_08_020251_add_foreign_keys_to_products_table', 1),
(58, '2021_03_08_020251_add_foreign_keys_to_purchase_details_table', 1),
(59, '2021_03_08_020251_add_foreign_keys_to_purchase_return_details_table', 1),
(60, '2021_03_08_020251_add_foreign_keys_to_purchase_returns_table', 1),
(61, '2021_03_08_020251_add_foreign_keys_to_purchases_table', 1),
(62, '2021_03_08_020251_add_foreign_keys_to_quotation_details_table', 1),
(63, '2021_03_08_020251_add_foreign_keys_to_quotations_table', 1),
(64, '2021_03_08_020251_add_foreign_keys_to_role_user_table', 1),
(65, '2021_03_08_020251_add_foreign_keys_to_sale_details_table', 1),
(66, '2021_03_08_020251_add_foreign_keys_to_sale_return_details_table', 1),
(67, '2021_03_08_020251_add_foreign_keys_to_sale_returns_table', 1),
(68, '2021_03_08_020251_add_foreign_keys_to_sales_table', 1),
(69, '2021_03_08_020251_add_foreign_keys_to_settings_table', 1),
(70, '2021_03_08_020251_add_foreign_keys_to_transfer_details_table', 1),
(71, '2021_03_08_020251_add_foreign_keys_to_transfers_table', 1),
(72, '2021_03_08_020251_add_foreign_keys_to_units_table', 1),
(73, '2021_04_11_221536_add_footer_to_settings_table', 1),
(74, '2021_04_30_040505_add_devopped_by_to_settings', 1),
(75, '2021_05_07_140933_add_client_id_to_settings_table', 1),
(76, '2021_05_07_141034_add_warehouse_id_to_settings_table', 1),
(77, '2021_05_07_141303_add_foreign_keys_clients_to_settings', 1),
(78, '2021_07_19_141906_add_sale_unit_id_to_sale_details', 1),
(79, '2021_07_22_013045_add_sale_unit_id_to_quotation_details_table', 1),
(80, '2021_07_22_032512_add_purchase_unit_id_to_purchase_details_table', 1),
(81, '2021_07_22_052330_add_sale_unit_id_to_sale_return_details_table', 1),
(82, '2021_07_22_052447_add_purchase_unit_id_to_purchase_return_details_table', 1),
(83, '2021_07_22_052713_add_purchase_unit_id_to_transfer_details_table', 1),
(84, '2021_07_26_155038_change_cost_column_type_return_details', 1),
(85, '2021_07_30_142441_add_change_to_payment_sales', 1),
(86, '2021_07_31_122946_add_change_to_payment_purchases_table', 1),
(87, '2021_07_31_123105_add_change_to_payment_sale_returns_table', 1),
(88, '2021_07_31_123135_add_change_to_payment_purchase_returns_table', 1),
(89, '2021_09_23_003640_add_default_language_to_settings_table', 1),
(90, '2021_09_24_000547_create_pos_settings', 1),
(91, '2022_02_18_161351_create_attendances_table', 1),
(92, '2022_02_18_161351_create_companies_table', 1),
(93, '2022_02_18_161351_create_departments_table', 1),
(94, '2022_02_18_161351_create_designations_table', 1),
(95, '2022_02_18_161351_create_employee_accounts_table', 1),
(96, '2022_02_18_161351_create_employee_experiences_table', 1),
(97, '2022_02_18_161351_create_employees_table', 1),
(98, '2022_02_18_161351_create_holidays_table', 1),
(99, '2022_02_18_161351_create_leave_types_table', 1),
(100, '2022_02_18_161351_create_leaves_table', 1),
(101, '2022_02_18_161351_create_office_shifts_table', 1),
(102, '2022_02_18_161355_add_foreign_keys_to_attendances_table', 1),
(103, '2022_02_18_161355_add_foreign_keys_to_departments_table', 1),
(104, '2022_02_18_161355_add_foreign_keys_to_designations_table', 1),
(105, '2022_02_18_161355_add_foreign_keys_to_employee_accounts_table', 1),
(106, '2022_02_18_161355_add_foreign_keys_to_employee_experiences_table', 1),
(107, '2022_02_18_161355_add_foreign_keys_to_employees_table', 1),
(108, '2022_02_18_161355_add_foreign_keys_to_holidays_table', 1),
(109, '2022_02_18_161355_add_foreign_keys_to_leaves_table', 1),
(110, '2022_02_18_161355_add_foreign_keys_to_office_shifts_table', 1),
(111, '2022_04_06_155633_create_user_warehouse_table', 1),
(112, '2022_04_06_155635_add_foreign_keys_to_user_warehouse_table', 1),
(113, '2022_04_08_001056_change_type_of_columns__clients__table', 1),
(114, '2022_04_08_002126_change_type_of_columns__providers__table', 1),
(115, '2022_04_26_163039_add_imei_to_product_table', 1),
(116, '2022_04_26_163314_add_imei_number_to_purchase_details', 1),
(117, '2022_04_26_163516_add_imei_number_to_quotation_details', 1),
(118, '2022_04_26_163600_add_imei_number_to_sale_details', 1),
(119, '2022_04_26_163653_add_imei_number_to_sale_return_details', 1),
(120, '2022_04_26_163741_add_imei_number_to_purchase_return_details', 1),
(121, '2022_05_01_005644_add_shipping_status_to_sales', 1),
(122, '2022_05_11_010241_add_is_all_warehouses_to_users', 1),
(123, '2022_05_14_191716_create_shipments_table', 1),
(124, '2022_05_14_191718_add_foreign_keys_to_shipments_table', 1),
(125, '2022_06_15_021609_create_sms_gateway_table', 1),
(126, '2022_06_15_023409_add_sms_gateway_to_settings', 1),
(127, '2022_06_18_145901_add_not_selling_to_product_table', 1),
(128, '2022_06_19_011630_add_sale_id_to_sale__return_table', 1),
(129, '2022_06_19_125137_add_sender_name_to_servers_table', 1),
(130, '2022_06_19_131645_add_purchase_id_to_purchase_return_table', 1),
(131, '2022_06_23_000019_add_invoice_footer_to_settings_table', 1),
(132, '2022_08_04_172721_add_tax_number_to_clients_table', 1),
(133, '2022_08_04_172905_add_tax_number_to_providers_table', 1),
(134, '2023_01_04_140439_make_email_clients_nullable', 1),
(135, '2023_01_04_140547_make_email_providers_nullable', 1),
(136, '2023_01_21_100532_add_is_printable_topos_settings_table', 1),
(137, '2023_02_04_213317_show_warehouse_to_table_pos_settings', 1),
(138, '2023_02_07_001309_create_sms_messages_table', 1),
(139, '2023_04_03_164423_create_table_email_messages', 1),
(140, '2023_04_12_141222_add_option_create_quotation_in_settings', 1),
(141, '2023_04_13_142815_add_fileds_to_product_variants', 1),
(142, '2023_04_13_155131_add_type_to_products', 1),
(143, '2023_04_14_150505_add_column_manage_stock', 1),
(144, '2023_09_02_010523_create_ecommerce_clients_table', 1),
(145, '2023_09_02_010524_add_foreign_keys_to_ecommerce_clients_table', 1),
(146, '2023_12_12_235150_create_count_stock_table', 1),
(147, '2023_12_12_235152_add_foreign_keys_to_count_stock_table', 1),
(148, '2023_12_14_001459_create_accounts_table', 1),
(149, '2023_12_14_001459_create_deposit_categories_table', 1),
(150, '2023_12_14_001459_create_deposits_table', 1),
(151, '2023_12_14_001501_add_foreign_keys_to_deposits_table', 1),
(152, '2023_12_14_232125_create_account_id_to_expenses', 1),
(153, '2023_12_15_203807_add_account_id_to_payment_sales', 1),
(154, '2023_12_15_203914_add_account_id_to_payment_purchases', 1),
(155, '2023_12_15_204046_add_account_id_to_payment_purchase_returns', 1),
(156, '2023_12_15_204302_add_account_id_to_payment_sale_returns', 1),
(157, '2023_12_16_193712_create_draft_sale_details_table', 1),
(158, '2023_12_16_193712_create_draft_sales_table', 1),
(159, '2023_12_16_193713_add_foreign_keys_to_draft_sale_details_table', 1),
(160, '2023_12_16_193713_add_foreign_keys_to_draft_sales_table', 1),
(161, '2024_02_01_001414_create_transfer_money_table', 1),
(162, '2024_02_01_001416_add_foreign_keys_to_transfer_money_table', 1),
(163, '2024_02_02_143558_create_payrolls_table', 1),
(164, '2024_02_02_143600_add_foreign_keys_to_payrolls_table', 1),
(165, '2024_08_20_113642_update_column_in_product_variants', 2),
(166, '2024_08_26_101214_add_parent_id_to_warehouses', 3),
(167, '2024_09_03_170619_remove_foreign_key_from_user_id_in_transfers', 4),
(168, '2024_09_04_134544_remove_foreign_key_from_user_id_in_purchases', 5),
(169, '2025_09_19_154507_add_image_to_purchases_table', 6),
(170, '0001_01_01_000001_create_cache_table', 7),
(171, '0001_01_01_000002_create_jobs_table', 7),
(172, '2025_09_18_000001_add_warehouse_id_to_adjustment_details', 7),
(174, '2025_09_19_000010_add_image_to_purchases_table', 8),
(175, '2025_09_19_103534_add_category_id_to_purchases_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_general_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_general_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `provider` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_general_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `office_shifts`
--

CREATE TABLE `office_shifts` (
  `id` int NOT NULL,
  `company_id` int NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `monday_in` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `monday_out` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tuesday_in` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tuesday_out` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `wednesday_in` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `wednesday_out` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `thursday_in` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `thursday_out` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `friday_in` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `friday_out` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `saturday_in` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `saturday_out` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sunday_in` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sunday_out` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_purchases`
--

CREATE TABLE `payment_purchases` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `date` date NOT NULL,
  `Ref` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `purchase_id` int NOT NULL,
  `account_id` int DEFAULT NULL,
  `montant` double NOT NULL,
  `change` double NOT NULL DEFAULT '0',
  `Reglement` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `notes` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_purchases`
--

INSERT INTO `payment_purchases` (`id`, `user_id`, `date`, `Ref`, `purchase_id`, `account_id`, `montant`, `change`, `Reglement`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '2024-05-27', 'INV/PR_1111', 1, 1, 215000, 0, 'Cash', NULL, '2024-05-27 07:06:52.000000', '2024-05-27 07:06:52.000000', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment_purchase_returns`
--

CREATE TABLE `payment_purchase_returns` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `date` date NOT NULL,
  `Ref` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `purchase_return_id` int NOT NULL,
  `account_id` int DEFAULT NULL,
  `montant` double NOT NULL,
  `change` double NOT NULL DEFAULT '0',
  `Reglement` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `notes` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_sales`
--

CREATE TABLE `payment_sales` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `date` date NOT NULL,
  `Ref` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `sale_id` int NOT NULL,
  `account_id` int DEFAULT NULL,
  `montant` double NOT NULL,
  `change` double NOT NULL DEFAULT '0',
  `Reglement` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `notes` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_sales`
--

INSERT INTO `payment_sales` (`id`, `user_id`, `date`, `Ref`, `sale_id`, `account_id`, `montant`, `change`, `Reglement`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '2024-06-12', 'INV/SL_1111', 1, NULL, 130000, 0, 'Cash', NULL, '2024-06-12 09:37:34.000000', '2024-06-12 09:37:34.000000', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment_sale_returns`
--

CREATE TABLE `payment_sale_returns` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `date` date NOT NULL,
  `Ref` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `sale_return_id` int NOT NULL,
  `account_id` int DEFAULT NULL,
  `montant` double NOT NULL,
  `change` double NOT NULL DEFAULT '0',
  `Reglement` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `notes` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_with_credit_card`
--

CREATE TABLE `payment_with_credit_card` (
  `id` int NOT NULL,
  `payment_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `customer_stripe_id` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `charge_id` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payrolls`
--

CREATE TABLE `payrolls` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `Ref` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `date` date NOT NULL,
  `employee_id` int NOT NULL,
  `account_id` int DEFAULT NULL,
  `amount` double NOT NULL,
  `payment_method` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `payment_status` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int NOT NULL,
  `name` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `label` varchar(192) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `label`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'users_view', NULL, NULL, NULL, NULL, NULL),
(2, 'users_edit', NULL, NULL, NULL, NULL, NULL),
(3, 'record_view', NULL, NULL, NULL, NULL, NULL),
(4, 'users_delete', NULL, NULL, NULL, NULL, NULL),
(5, 'users_add', NULL, NULL, NULL, NULL, NULL),
(6, 'permissions_edit', NULL, NULL, NULL, NULL, NULL),
(7, 'permissions_view', NULL, NULL, NULL, NULL, NULL),
(8, 'permissions_delete', NULL, NULL, NULL, NULL, NULL),
(9, 'permissions_add', NULL, NULL, NULL, NULL, NULL),
(10, 'products_delete', NULL, NULL, NULL, NULL, NULL),
(11, 'products_view', NULL, NULL, NULL, NULL, NULL),
(12, 'barcode_view', NULL, NULL, NULL, NULL, NULL),
(13, 'products_edit', NULL, NULL, NULL, NULL, NULL),
(14, 'products_add', NULL, NULL, NULL, NULL, NULL),
(15, 'expense_add', NULL, NULL, NULL, NULL, NULL),
(16, 'expense_delete', NULL, NULL, NULL, NULL, NULL),
(17, 'expense_edit', NULL, NULL, NULL, NULL, NULL),
(18, 'expense_view', NULL, NULL, NULL, NULL, NULL),
(19, 'transfer_delete', NULL, NULL, NULL, NULL, NULL),
(20, 'transfer_add', NULL, NULL, NULL, NULL, NULL),
(21, 'transfer_view', NULL, NULL, NULL, NULL, NULL),
(22, 'transfer_edit', NULL, NULL, NULL, NULL, NULL),
(23, 'adjustment_delete', NULL, NULL, NULL, NULL, NULL),
(24, 'adjustment_add', NULL, NULL, NULL, NULL, NULL),
(25, 'adjustment_edit', NULL, NULL, NULL, NULL, NULL),
(26, 'adjustment_view', NULL, NULL, NULL, NULL, NULL),
(27, 'Sales_edit', NULL, NULL, NULL, NULL, NULL),
(28, 'Sales_view', NULL, NULL, NULL, NULL, NULL),
(29, 'Sales_delete', NULL, NULL, NULL, NULL, NULL),
(30, 'Sales_add', NULL, NULL, NULL, NULL, NULL),
(31, 'Purchases_edit', NULL, NULL, NULL, NULL, NULL),
(32, 'Purchases_view', NULL, NULL, NULL, NULL, NULL),
(33, 'Purchases_delete', NULL, NULL, NULL, NULL, NULL),
(34, 'Purchases_add', NULL, NULL, NULL, NULL, NULL),
(35, 'Quotations_edit', NULL, NULL, NULL, NULL, NULL),
(36, 'Quotations_delete', NULL, NULL, NULL, NULL, NULL),
(37, 'Quotations_add', NULL, NULL, NULL, NULL, NULL),
(38, 'Quotations_view', NULL, NULL, NULL, NULL, NULL),
(39, 'payment_sales_delete', NULL, NULL, NULL, NULL, NULL),
(40, 'payment_sales_add', NULL, NULL, NULL, NULL, NULL),
(41, 'payment_sales_edit', NULL, NULL, NULL, NULL, NULL),
(42, 'payment_sales_view', NULL, NULL, NULL, NULL, NULL),
(43, 'Purchase_Returns_delete', NULL, NULL, NULL, NULL, NULL),
(44, 'Purchase_Returns_add', NULL, NULL, NULL, NULL, NULL),
(45, 'Purchase_Returns_view', NULL, NULL, NULL, NULL, NULL),
(46, 'Purchase_Returns_edit', NULL, NULL, NULL, NULL, NULL),
(47, 'Sale_Returns_delete', NULL, NULL, NULL, NULL, NULL),
(48, 'Sale_Returns_add', NULL, NULL, NULL, NULL, NULL),
(49, 'Sale_Returns_edit', NULL, NULL, NULL, NULL, NULL),
(50, 'Sale_Returns_view', NULL, NULL, NULL, NULL, NULL),
(51, 'payment_purchases_edit', NULL, NULL, NULL, NULL, NULL),
(52, 'payment_purchases_view', NULL, NULL, NULL, NULL, NULL),
(53, 'payment_purchases_delete', NULL, NULL, NULL, NULL, NULL),
(54, 'payment_purchases_add', NULL, NULL, NULL, NULL, NULL),
(55, 'payment_returns_edit', NULL, NULL, NULL, NULL, NULL),
(56, 'payment_returns_view', NULL, NULL, NULL, NULL, NULL),
(57, 'payment_returns_delete', NULL, NULL, NULL, NULL, NULL),
(58, 'payment_returns_add', NULL, NULL, NULL, NULL, NULL),
(59, 'Customers_edit', NULL, NULL, NULL, NULL, NULL),
(60, 'Customers_view', NULL, NULL, NULL, NULL, NULL),
(61, 'Customers_delete', NULL, NULL, NULL, NULL, NULL),
(62, 'Customers_add', NULL, NULL, NULL, NULL, NULL),
(63, 'unit', NULL, NULL, NULL, NULL, NULL),
(64, 'currency', NULL, NULL, NULL, NULL, NULL),
(65, 'category', NULL, NULL, NULL, NULL, NULL),
(66, 'backup', NULL, NULL, NULL, NULL, NULL),
(67, 'warehouse', NULL, NULL, NULL, NULL, NULL),
(68, 'brand', NULL, NULL, NULL, NULL, NULL),
(69, 'setting_system', NULL, NULL, NULL, NULL, NULL),
(70, 'Warehouse_report', NULL, NULL, NULL, NULL, NULL),
(72, 'Reports_quantity_alerts', NULL, NULL, NULL, NULL, NULL),
(73, 'Reports_profit', NULL, NULL, NULL, NULL, NULL),
(74, 'Reports_suppliers', NULL, NULL, NULL, NULL, NULL),
(75, 'Reports_customers', NULL, NULL, NULL, NULL, NULL),
(76, 'Reports_purchase', NULL, NULL, NULL, NULL, NULL),
(77, 'Reports_sales', NULL, NULL, NULL, NULL, NULL),
(78, 'Reports_payments_purchase_Return', NULL, NULL, NULL, NULL, NULL),
(79, 'Reports_payments_Sale_Returns', NULL, NULL, NULL, NULL, NULL),
(80, 'Reports_payments_Purchases', NULL, NULL, NULL, NULL, NULL),
(81, 'Reports_payments_Sales', NULL, NULL, NULL, NULL, NULL),
(82, 'Suppliers_delete', NULL, NULL, NULL, NULL, NULL),
(83, 'Suppliers_add', NULL, NULL, NULL, NULL, NULL),
(84, 'Suppliers_edit', NULL, NULL, NULL, NULL, NULL),
(85, 'Suppliers_view', NULL, NULL, NULL, NULL, NULL),
(86, 'Pos_view', NULL, NULL, NULL, NULL, NULL),
(87, 'product_import', NULL, NULL, NULL, NULL, NULL),
(88, 'customers_import', NULL, NULL, NULL, NULL, NULL),
(89, 'Suppliers_import', NULL, NULL, NULL, NULL, NULL),
(90, 'view_employee', NULL, NULL, NULL, NULL, NULL),
(91, 'add_employee', NULL, NULL, NULL, NULL, NULL),
(92, 'edit_employee', NULL, NULL, NULL, NULL, NULL),
(93, 'delete_employee', NULL, NULL, NULL, NULL, NULL),
(94, 'company', NULL, NULL, NULL, NULL, NULL),
(95, 'department', NULL, NULL, NULL, NULL, NULL),
(96, 'designation', NULL, NULL, NULL, NULL, NULL),
(97, 'office_shift', NULL, NULL, NULL, NULL, NULL),
(98, 'attendance', NULL, NULL, NULL, NULL, NULL),
(99, 'leave', NULL, NULL, NULL, NULL, NULL),
(100, 'holiday', NULL, NULL, NULL, NULL, NULL),
(101, 'Top_products', NULL, NULL, NULL, NULL, NULL),
(102, 'Top_customers', NULL, NULL, NULL, NULL, NULL),
(103, 'shipment', NULL, NULL, NULL, NULL, NULL),
(104, 'users_report', NULL, NULL, NULL, NULL, NULL),
(105, 'stock_report', NULL, NULL, NULL, NULL, NULL),
(106, 'sms_settings', NULL, NULL, NULL, NULL, NULL),
(107, 'pos_settings', NULL, NULL, NULL, NULL, NULL),
(108, 'payment_gateway', NULL, NULL, NULL, NULL, NULL),
(109, 'mail_settings', NULL, NULL, NULL, NULL, NULL),
(110, 'dashboard', NULL, NULL, NULL, NULL, NULL),
(111, 'pay_due', NULL, NULL, NULL, NULL, NULL),
(112, 'pay_sale_return_due', NULL, NULL, NULL, NULL, NULL),
(113, 'pay_supplier_due', NULL, NULL, NULL, NULL, NULL),
(114, 'pay_purchase_return_due', NULL, NULL, NULL, NULL, NULL),
(115, 'product_report', NULL, NULL, NULL, NULL, NULL),
(116, 'product_sales_report', NULL, NULL, NULL, NULL, NULL),
(117, 'product_purchases_report', NULL, NULL, NULL, NULL, NULL),
(118, 'notification_template', NULL, NULL, NULL, NULL, NULL),
(119, 'edit_product_sale', NULL, NULL, NULL, NULL, NULL),
(120, 'edit_product_purchase', NULL, NULL, NULL, NULL, NULL),
(121, 'edit_product_quotation', NULL, NULL, NULL, NULL, NULL),
(122, 'edit_tax_discount_shipping_sale', NULL, NULL, NULL, NULL, NULL),
(123, 'edit_tax_discount_shipping_purchase', NULL, NULL, NULL, NULL, NULL),
(124, 'edit_tax_discount_shipping_quotation', NULL, NULL, NULL, NULL, NULL),
(125, 'module_settings', NULL, NULL, NULL, NULL, NULL),
(126, 'count_stock', NULL, NULL, NULL, NULL, NULL),
(127, 'deposit_add', NULL, NULL, NULL, NULL, NULL),
(128, 'deposit_delete', NULL, NULL, NULL, NULL, NULL),
(129, 'deposit_edit', NULL, NULL, NULL, NULL, NULL),
(130, 'deposit_view', NULL, NULL, NULL, NULL, NULL),
(131, 'account', NULL, NULL, NULL, NULL, NULL),
(132, 'inventory_valuation', NULL, NULL, NULL, NULL, NULL),
(133, 'expenses_report', NULL, NULL, NULL, NULL, NULL),
(134, 'deposits_report', NULL, NULL, NULL, NULL, NULL),
(135, 'transfer_money', NULL, NULL, NULL, NULL, NULL),
(136, 'payroll', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` int NOT NULL,
  `permission_id` int NOT NULL,
  `role_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `permission_id`, `role_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 7, 1),
(8, 8, 1),
(9, 9, 1),
(10, 10, 1),
(11, 11, 1),
(12, 12, 1),
(13, 13, 1),
(14, 14, 1),
(15, 15, 1),
(16, 16, 1),
(17, 17, 1),
(18, 18, 1),
(19, 19, 1),
(20, 20, 1),
(21, 21, 1),
(22, 22, 1),
(23, 23, 1),
(24, 24, 1),
(25, 25, 1),
(26, 26, 1),
(27, 27, 1),
(28, 28, 1),
(29, 29, 1),
(30, 30, 1),
(31, 31, 1),
(32, 32, 1),
(33, 33, 1),
(34, 34, 1),
(35, 35, 1),
(36, 36, 1),
(37, 37, 1),
(38, 38, 1),
(39, 39, 1),
(40, 40, 1),
(41, 41, 1),
(42, 42, 1),
(43, 43, 1),
(44, 44, 1),
(45, 45, 1),
(46, 46, 1),
(47, 47, 1),
(48, 48, 1),
(49, 49, 1),
(50, 50, 1),
(51, 51, 1),
(52, 52, 1),
(53, 53, 1),
(54, 54, 1),
(55, 55, 1),
(56, 56, 1),
(57, 57, 1),
(58, 58, 1),
(59, 59, 1),
(60, 60, 1),
(61, 61, 1),
(62, 62, 1),
(63, 63, 1),
(64, 64, 1),
(65, 65, 1),
(66, 66, 1),
(67, 67, 1),
(68, 68, 1),
(69, 69, 1),
(70, 70, 1),
(72, 72, 1),
(73, 73, 1),
(74, 74, 1),
(75, 75, 1),
(76, 76, 1),
(77, 77, 1),
(78, 78, 1),
(79, 79, 1),
(80, 80, 1),
(81, 81, 1),
(82, 82, 1),
(83, 83, 1),
(84, 84, 1),
(85, 85, 1),
(86, 86, 1),
(87, 87, 1),
(88, 88, 1),
(89, 89, 1),
(90, 90, 1),
(91, 91, 1),
(92, 92, 1),
(93, 93, 1),
(94, 94, 1),
(95, 95, 1),
(96, 96, 1),
(97, 97, 1),
(98, 98, 1),
(99, 99, 1),
(100, 100, 1),
(101, 101, 1),
(102, 102, 1),
(103, 103, 1),
(104, 104, 1),
(105, 105, 1),
(106, 106, 1),
(107, 107, 1),
(108, 108, 1),
(109, 109, 1),
(110, 110, 1),
(111, 111, 1),
(112, 112, 1),
(113, 113, 1),
(114, 114, 1),
(115, 115, 1),
(116, 116, 1),
(117, 117, 1),
(118, 118, 1),
(119, 119, 1),
(120, 120, 1),
(121, 121, 1),
(122, 122, 1),
(123, 123, 1),
(124, 124, 1),
(125, 125, 1),
(126, 126, 1),
(127, 127, 1),
(128, 128, 1),
(129, 129, 1),
(130, 130, 1),
(131, 131, 1),
(132, 132, 1),
(133, 133, 1),
(134, 134, 1),
(135, 135, 1),
(136, 136, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pos_settings`
--

CREATE TABLE `pos_settings` (
  `id` int NOT NULL,
  `note_customer` varchar(192) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Thank You For Shopping With Us . Please Come Again',
  `show_note` tinyint(1) NOT NULL DEFAULT '1',
  `show_barcode` tinyint(1) NOT NULL DEFAULT '1',
  `show_discount` tinyint(1) NOT NULL DEFAULT '1',
  `show_customer` tinyint(1) NOT NULL DEFAULT '1',
  `show_email` tinyint(1) NOT NULL DEFAULT '1',
  `show_phone` tinyint(1) NOT NULL DEFAULT '1',
  `show_address` tinyint(1) NOT NULL DEFAULT '1',
  `is_printable` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `show_Warehouse` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pos_settings`
--

INSERT INTO `pos_settings` (`id`, `note_customer`, `show_note`, `show_barcode`, `show_discount`, `show_customer`, `show_email`, `show_phone`, `show_address`, `is_printable`, `created_at`, `updated_at`, `deleted_at`, `show_Warehouse`) VALUES
(1, 'Thank You For Shopping With Us . Please Come Again', 1, 1, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `code` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `Type_barcode` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `cost` double DEFAULT NULL,
  `price` double DEFAULT NULL,
  `category_id` int NOT NULL,
  `brand_id` int DEFAULT NULL,
  `unit_id` int DEFAULT NULL,
  `unit_sale_id` int DEFAULT NULL,
  `unit_purchase_id` int DEFAULT NULL,
  `TaxNet` double DEFAULT '0',
  `tax_method` varchar(192) COLLATE utf8mb4_general_ci DEFAULT '0',
  `image` text COLLATE utf8mb4_general_ci,
  `note` text COLLATE utf8mb4_general_ci,
  `stock_alert` double DEFAULT '0',
  `is_variant` tinyint(1) NOT NULL DEFAULT '0',
  `is_imei` tinyint(1) NOT NULL DEFAULT '0',
  `not_selling` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `type`, `code`, `Type_barcode`, `name`, `cost`, `price`, `category_id`, `brand_id`, `unit_id`, `unit_sale_id`, `unit_purchase_id`, `TaxNet`, `tax_method`, `image`, `note`, `stock_alert`, `is_variant`, `is_imei`, `not_selling`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'is_single', '47120259', 'CODE128', 'Shell Rimulla', 130000, 130000, 1, NULL, 1, 1, 1, 0, '1', 'no-image.png', 'Oli Shell rimulla Truck Edun', 0, 0, 0, 0, 1, '2024-05-20 03:44:38.000000', '2024-05-20 03:44:38.000000', NULL),
(2, 'is_variant', '93892715', 'CODE39', 'Shell Super', 0, 0, 1, NULL, 1, 1, 1, 2, '2', 'no-image.png', 'Shell Super', 0, 1, 0, 0, 1, '2024-05-20 10:08:14.000000', '2024-05-20 10:08:40.000000', NULL),
(3, 'is_single', '84986327', 'EAN13', 'New Product #1', 1500, 10000, 1, NULL, 1, 1, 1, 0, '2', '83096414car rzl.png,27170165edit car request rzl.png,32242545driver rzl.png,73287204dashboard rzl.png,23754042edit request rzl.png', 'description of the product', 10, 0, 0, 0, 1, '2024-05-27 04:41:46.000000', '2024-05-27 04:41:46.000000', NULL),
(4, 'is_single', '56272317', 'CODE128', 'Macbook Pro 2019', NULL, NULL, 2, NULL, 2, 2, 2, 0, '1', 'no-image.png', 'Spesifikasi:\r\nIntel Core I5 Gen 8\r\nRTX4090 TI\r\nOS Ventura', 0, 0, 0, 0, 1, '2024-08-20 06:38:01.000000', '2024-08-20 07:03:44.000000', NULL),
(5, 'is_service', '75792392', 'CODE128', 'Tiket Hotel', 0, NULL, 1, NULL, 2, NULL, NULL, 0, '1', 'no-image.png', 'Tiket hotel untuk nginap', 0, 0, 0, 0, 1, '2024-08-20 07:29:00.000000', '2024-08-20 07:29:00.000000', NULL),
(6, 'is_service', '-', 'CODE128', 'Tiket pesawat terbang', 0, NULL, 2, NULL, 2, 2, 2, 0, '1', 'no-image.png', 'tiket pesawat garuda indonesia', 0, 0, 0, 0, 1, '2024-08-20 08:00:47.000000', '2024-08-23 02:51:42.000000', NULL),
(7, 'is_single', '29813387', 'CODE128', 'Kabel type c', NULL, NULL, 2, NULL, 2, 2, 2, 0, '1', 'no-image.png', 'Kabel usb to type c, panjang 2 m, tebal 1 cm', 0, 0, 0, 0, 1, '2024-09-02 04:51:59.000000', '2024-09-02 04:51:59.000000', NULL),
(19, 'is_service', '000048450924', 'CODE128', 'Tiket Penerbangan A.N Ahmad Hidayat Asrori', NULL, NULL, 3, NULL, 33, 33, 33, 0, '0', NULL, NULL, 0, 0, 0, 0, 1, '2024-09-09 07:03:53.000000', '2024-09-09 07:03:53.000000', NULL),
(20, 'is_service', '000048460924', 'CODE128', 'Tiket Penerbangan A.N\r\nRiky Siswanto', NULL, NULL, 3, NULL, 34, 34, 34, 0, '0', NULL, NULL, 0, 0, 0, 0, 1, '2024-09-09 07:03:53.000000', '2024-09-09 07:03:53.000000', NULL),
(21, 'is_service', '000048470924', 'CODE128', 'Tiket Penerbangan A.N\r\nSatria Adi Nugraha', NULL, NULL, 3, NULL, 35, 35, 35, 0, '0', NULL, NULL, 0, 0, 0, 0, 1, '2024-09-09 07:03:53.000000', '2024-09-09 07:03:53.000000', NULL),
(22, 'is_service', '000048480924', 'CODE128', 'Tiket Kereta Whoosh', NULL, NULL, 3, NULL, 38, 38, 38, 0, '0', NULL, NULL, 0, 0, 0, 0, 1, '2024-09-11 08:56:30.000000', '2024-09-11 08:56:30.000000', NULL),
(23, 'is_service', '000048490924', 'CODE128', 'pisang ambon', NULL, NULL, 3, NULL, 39, 39, 39, 0, '0', NULL, NULL, 0, 0, 0, 0, 1, '2024-09-11 08:56:30.000000', '2024-09-11 08:56:30.000000', NULL),
(24, 'is_single', 'WO000001', 'CODE128', 'Kabel HDMI to HDMI', NULL, NULL, 4, 1, 28, 28, 28, 0, '1', 'no-image.png', 'Kabel HDMI to HDMI 1m', 10, 0, 0, 0, 1, '2024-10-03 09:26:24.000000', '2024-10-03 09:26:24.000000', NULL),
(25, 'is_single', '000048501024', 'CODE128', 'Monitor Buat Programmer', NULL, NULL, 3, NULL, 28, 28, 28, 0, '0', 'no-image.png', NULL, 0, 0, 0, 0, 1, '2024-10-04 03:41:21.000000', '2024-10-04 03:41:21.000000', NULL),
(26, 'service', '12903812', 'CODE128', 'product test', NULL, NULL, 2, 1, 2, NULL, NULL, 0, '0', NULL, NULL, 4, 0, 0, 0, 1, '2025-09-19 08:24:14.000000', '2025-09-19 08:24:14.000000', NULL),
(27, 'service', '12903812', 'CODE128', 'product test', NULL, NULL, 2, 1, 2, NULL, NULL, 0, '0', NULL, NULL, 4, 0, 0, 0, 1, '2025-09-19 08:24:15.000000', '2025-09-19 08:24:15.000000', NULL),
(28, 'service', '12903812', 'CODE128', 'product test2', NULL, NULL, 2, 1, 16, NULL, NULL, 0, '0', '1758295536_68cd75f02447f.png', NULL, 4, 0, 0, 0, 1, '2025-09-19 08:24:16.000000', '2025-09-19 08:25:36.000000', NULL),
(33, 'standard', '76099078', 'CODE128', 'testproductbaru', NULL, NULL, 1, 1, 17, NULL, NULL, 0, '0', 'prod_68cd763e7ca90.png', NULL, 6, 0, 0, 0, 1, '2025-09-19 08:26:54.000000', '2025-09-19 08:26:54.000000', NULL),
(34, 'service', '79068', 'EAN13', 'testpesawatt', NULL, NULL, 2, NULL, 19, NULL, NULL, 0, '0', 'prod_68cd7bbf8b074.png', NULL, 6, 0, 0, 0, 1, '2025-09-19 08:50:23.000000', '2025-09-19 09:14:46.000000', NULL),
(39, 'service', '5798', 'CODE128', 'test21', NULL, NULL, 1, 1, 28, NULL, NULL, 0, '0', 'prod_68cde9fe69be2.png', NULL, 4, 0, 0, 0, 1, '2025-09-19 16:40:46.000000', '2025-09-19 16:40:46.000000', NULL),
(40, 'service', '1298370', 'CODE128', 'product test 21', NULL, NULL, 1, 1, 21, NULL, NULL, 0, '0', 'prod_68cdff0240e83.png', NULL, 4, 0, 0, 0, 1, '2025-09-19 18:10:26.000000', '2025-09-19 18:10:26.000000', NULL),
(41, 'service', '81923790', 'CODE128', 'producttest22', NULL, NULL, 2, 1, 28, NULL, NULL, 0, '0', 'prod_68cdff5d521b9.png', NULL, 10, 0, 0, 0, 1, '2025-09-19 18:11:57.000000', '2025-09-19 18:11:57.000000', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `name` varchar(192) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cost` double DEFAULT NULL,
  `price` double DEFAULT NULL,
  `code` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'no-image.png',
  `qty` decimal(8,2) DEFAULT '0.00',
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `name`, `cost`, `price`, `code`, `image`, `qty`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 'Keju', 2000, 2000, '12o10', 'no-image.png', 0.00, NULL, '2024-05-20 10:08:40.000000', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_warehouse`
--

CREATE TABLE `product_warehouse` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `warehouse_id` int NOT NULL,
  `product_variant_id` int DEFAULT NULL,
  `qte` double NOT NULL,
  `manage_stock` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_warehouse`
--

INSERT INTO `product_warehouse` (`id`, `product_id`, `warehouse_id`, `product_variant_id`, `qte`, `manage_stock`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, NULL, 24, 1, NULL, '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(2, 2, 1, 1, 105, 1, NULL, '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(3, 3, 1, NULL, 45, 1, NULL, '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(4, 4, 1, NULL, 1, 1, NULL, '2025-09-19 10:30:13.000000', '2024-09-02 03:42:09'),
(5, 5, 1, NULL, 2, 0, NULL, '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(6, 6, 1, NULL, 2, 0, NULL, '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(7, 1, 2, NULL, 0, 1, NULL, '2024-08-26 03:43:32.000000', '2024-08-26 03:43:32'),
(8, 2, 2, 1, 0, 1, NULL, '2024-08-26 03:43:32.000000', '2024-08-26 03:43:32'),
(9, 3, 2, NULL, 0, 1, NULL, '2024-08-26 03:43:32.000000', '2024-08-26 03:43:32'),
(10, 4, 2, NULL, 0, 1, NULL, '2024-08-26 03:43:32.000000', '2024-08-26 03:43:32'),
(11, 5, 2, NULL, 0, 0, NULL, '2024-08-26 03:43:32.000000', '2024-08-26 03:43:32'),
(12, 6, 2, NULL, 0, 0, NULL, '2024-08-26 03:43:32.000000', '2024-08-26 03:43:32'),
(13, 1, 3, NULL, 0, 1, NULL, '2025-09-19 10:30:36.000000', '2024-09-02 03:42:09'),
(14, 2, 3, 1, 0, 1, NULL, '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(15, 3, 3, NULL, 0, 1, NULL, '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(16, 4, 3, NULL, 0, 1, NULL, '2025-09-19 10:30:36.000000', '2024-09-02 03:42:09'),
(17, 5, 3, NULL, 0, 0, NULL, '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(18, 6, 3, NULL, 0, 0, NULL, '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(19, 1, 4, NULL, 0, 1, NULL, '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(20, 2, 4, 1, 0, 1, NULL, '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(21, 3, 4, NULL, 0, 1, NULL, '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(22, 4, 4, NULL, 0, 1, NULL, '2025-09-19 10:30:13.000000', '2024-09-02 03:42:09'),
(23, 5, 4, NULL, 0, 0, NULL, '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(24, 6, 4, NULL, 0, 0, NULL, '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(25, 1, 5, NULL, 0, 1, NULL, '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(26, 2, 5, 1, 0, 1, NULL, '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(27, 3, 5, NULL, 0, 1, NULL, '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(28, 4, 5, NULL, 0, 1, NULL, '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(29, 5, 5, NULL, 0, 0, NULL, '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(30, 6, 5, NULL, 0, 0, NULL, '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(31, 1, 6, NULL, 0, 1, NULL, '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(32, 2, 6, 1, 0, 1, NULL, '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(33, 3, 6, NULL, 0, 1, NULL, '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(34, 4, 6, NULL, 0, 1, NULL, '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(35, 5, 6, NULL, 0, 0, NULL, '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(36, 6, 6, NULL, 0, 0, NULL, '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(37, 1, 7, NULL, 0, 1, NULL, NULL, NULL),
(38, 2, 7, 1, 0, 1, NULL, NULL, NULL),
(39, 3, 7, NULL, 0, 1, NULL, NULL, NULL),
(40, 4, 7, NULL, 0, 1, NULL, NULL, NULL),
(41, 5, 7, NULL, 0, 0, NULL, NULL, NULL),
(42, 6, 7, NULL, 0, 0, NULL, NULL, NULL),
(43, 7, 7, NULL, 2, 1, NULL, NULL, NULL),
(44, 1, 8, NULL, 1, 1, NULL, '2025-09-19 10:30:36.000000', NULL),
(45, 2, 8, 1, 0, 1, NULL, NULL, NULL),
(46, 3, 8, NULL, 0, 1, NULL, NULL, NULL),
(47, 4, 8, NULL, 1, 1, NULL, '2025-09-19 10:30:36.000000', NULL),
(48, 5, 8, NULL, 0, 0, NULL, NULL, NULL),
(49, 6, 8, NULL, 0, 0, NULL, NULL, NULL),
(50, 7, 8, NULL, 0, 1, NULL, NULL, NULL),
(51, 7, 7, NULL, 2, 1, NULL, NULL, NULL),
(103, 7, 7, NULL, 10, 1, '2024-09-05 11:24:50.000000', '2024-09-05 11:24:50.000000', NULL),
(104, 1, 1, NULL, 10, 1, '2024-09-05 11:24:50.000000', '2024-09-05 11:24:50.000000', NULL),
(105, 6, 1, NULL, 2, 1, '2024-09-05 11:24:50.000000', '2024-09-05 11:24:50.000000', NULL),
(109, 7, 7, NULL, 10, 1, '2024-09-09 03:13:39.000000', '2024-09-09 03:13:39.000000', NULL),
(110, 1, 1, NULL, 10, 1, '2024-09-09 03:13:39.000000', '2024-09-09 03:13:39.000000', NULL),
(111, 6, 1, NULL, 2, 1, '2024-09-09 03:13:39.000000', '2024-09-09 03:13:39.000000', NULL),
(112, 1, 7, NULL, 1, 1, '2024-09-09 04:33:21.000000', '2024-09-09 04:33:21.000000', NULL),
(113, 1, 7, NULL, 1, 1, '2024-09-09 04:33:21.000000', '2024-09-09 04:33:21.000000', NULL),
(114, 1, 7, NULL, 1, 1, '2024-09-09 06:24:23.000000', '2024-09-09 06:24:23.000000', NULL),
(115, 1, 7, NULL, 1, 1, '2024-09-09 06:24:23.000000', '2024-09-09 06:24:23.000000', NULL),
(116, 19, 7, NULL, 1, 1, '2024-09-09 07:03:53.000000', '2024-09-09 07:03:53.000000', NULL),
(117, 20, 7, NULL, 1, 1, '2024-09-09 07:03:53.000000', '2024-09-09 07:03:53.000000', NULL),
(118, 21, 7, NULL, 1, 1, '2024-09-09 07:03:53.000000', '2024-09-09 07:03:53.000000', NULL),
(119, 1, 7, NULL, 1, 1, '2024-09-09 07:57:41.000000', '2024-09-09 07:57:41.000000', NULL),
(120, 1, 7, NULL, 1, 1, '2024-09-09 07:57:41.000000', '2024-09-09 07:57:41.000000', NULL),
(121, 22, 7, NULL, 2, 1, '2024-09-11 08:56:30.000000', '2024-10-07 04:18:18.000000', NULL),
(122, 23, 7, NULL, 0, 1, '2024-09-11 08:56:30.000000', '2024-09-13 04:20:50.000000', NULL),
(123, 1, 9, NULL, 0, 1, NULL, NULL, NULL),
(124, 2, 9, 1, 0, 1, NULL, NULL, NULL),
(125, 3, 9, NULL, 0, 1, NULL, NULL, NULL),
(126, 4, 9, NULL, 0, 1, NULL, NULL, NULL),
(127, 5, 9, NULL, 0, 0, NULL, NULL, NULL),
(128, 6, 9, NULL, 0, 0, NULL, NULL, NULL),
(129, 7, 9, NULL, 0, 1, NULL, NULL, NULL),
(130, 19, 9, NULL, 0, 0, NULL, NULL, NULL),
(131, 20, 9, NULL, 0, 0, NULL, NULL, NULL),
(132, 21, 9, NULL, 0, 0, NULL, NULL, NULL),
(133, 22, 9, NULL, 0, 0, NULL, NULL, NULL),
(134, 23, 9, NULL, 0, 0, NULL, NULL, NULL),
(135, 1, 10, NULL, 0, 1, NULL, NULL, NULL),
(136, 2, 10, 1, 0, 1, NULL, NULL, NULL),
(137, 3, 10, NULL, 0, 1, NULL, NULL, NULL),
(138, 4, 10, NULL, 0, 1, NULL, NULL, NULL),
(139, 5, 10, NULL, 0, 0, NULL, NULL, NULL),
(140, 6, 10, NULL, 0, 0, NULL, NULL, NULL),
(141, 7, 10, NULL, 0, 1, NULL, NULL, NULL),
(142, 19, 10, NULL, 0, 0, NULL, NULL, NULL),
(143, 20, 10, NULL, 0, 0, NULL, NULL, NULL),
(144, 21, 10, NULL, 0, 0, NULL, NULL, NULL),
(145, 22, 10, NULL, 0, 0, NULL, NULL, NULL),
(146, 23, 10, NULL, 0, 0, NULL, NULL, NULL),
(147, 1, 11, NULL, 0, 1, NULL, NULL, NULL),
(148, 2, 11, 1, 0, 1, NULL, NULL, NULL),
(149, 3, 11, NULL, 0, 1, NULL, NULL, NULL),
(150, 4, 11, NULL, 0, 1, NULL, NULL, NULL),
(151, 5, 11, NULL, 0, 0, NULL, NULL, NULL),
(152, 6, 11, NULL, 0, 0, NULL, NULL, NULL),
(153, 7, 11, NULL, 0, 1, NULL, NULL, NULL),
(154, 19, 11, NULL, 0, 0, NULL, NULL, NULL),
(155, 20, 11, NULL, 0, 0, NULL, NULL, NULL),
(156, 21, 11, NULL, 0, 0, NULL, NULL, NULL),
(157, 22, 11, NULL, 0, 0, NULL, NULL, NULL),
(158, 23, 11, NULL, 0, 0, NULL, NULL, NULL),
(159, 1, 12, NULL, 0, 1, NULL, NULL, NULL),
(160, 2, 12, 1, 0, 1, NULL, NULL, NULL),
(161, 3, 12, NULL, 0, 1, NULL, NULL, NULL),
(162, 4, 12, NULL, 0, 1, NULL, NULL, NULL),
(163, 5, 12, NULL, 0, 0, NULL, NULL, NULL),
(164, 6, 12, NULL, 0, 0, NULL, NULL, NULL),
(165, 7, 12, NULL, 0, 1, NULL, NULL, NULL),
(166, 19, 12, NULL, 0, 0, NULL, NULL, NULL),
(167, 20, 12, NULL, 0, 0, NULL, NULL, NULL),
(168, 21, 12, NULL, 0, 0, NULL, NULL, NULL),
(169, 22, 12, NULL, 0, 0, NULL, NULL, NULL),
(170, 23, 12, NULL, 0, 0, NULL, NULL, NULL),
(171, 1, 13, NULL, 0, 1, NULL, NULL, NULL),
(172, 2, 13, 1, 0, 1, NULL, NULL, NULL),
(173, 3, 13, NULL, 0, 1, NULL, NULL, NULL),
(174, 4, 13, NULL, 0, 1, NULL, NULL, NULL),
(175, 5, 13, NULL, 0, 0, NULL, NULL, NULL),
(176, 6, 13, NULL, 0, 0, NULL, NULL, NULL),
(177, 7, 13, NULL, 0, 1, NULL, NULL, NULL),
(178, 19, 13, NULL, 0, 0, NULL, NULL, NULL),
(179, 20, 13, NULL, 0, 0, NULL, NULL, NULL),
(180, 21, 13, NULL, 0, 0, NULL, NULL, NULL),
(181, 22, 13, NULL, 0, 0, NULL, NULL, NULL),
(182, 23, 13, NULL, 0, 0, NULL, NULL, NULL),
(183, 1, 14, NULL, 0, 1, NULL, NULL, NULL),
(184, 2, 14, 1, 0, 1, NULL, NULL, NULL),
(185, 3, 14, NULL, 0, 1, NULL, NULL, NULL),
(186, 4, 14, NULL, 0, 1, NULL, NULL, NULL),
(187, 5, 14, NULL, 0, 0, NULL, NULL, NULL),
(188, 6, 14, NULL, 0, 0, NULL, NULL, NULL),
(189, 7, 14, NULL, 0, 1, NULL, NULL, NULL),
(190, 19, 14, NULL, 0, 0, NULL, NULL, NULL),
(191, 20, 14, NULL, 0, 0, NULL, NULL, NULL),
(192, 21, 14, NULL, 0, 0, NULL, NULL, NULL),
(193, 22, 14, NULL, 0, 0, NULL, NULL, NULL),
(194, 23, 14, NULL, 0, 0, NULL, NULL, NULL),
(195, 1, 15, NULL, 0, 1, NULL, NULL, NULL),
(196, 2, 15, 1, 0, 1, NULL, NULL, NULL),
(197, 3, 15, NULL, 0, 1, NULL, NULL, NULL),
(198, 4, 15, NULL, 0, 1, NULL, NULL, NULL),
(199, 5, 15, NULL, 0, 0, NULL, NULL, NULL),
(200, 6, 15, NULL, 0, 0, NULL, NULL, NULL),
(201, 7, 15, NULL, 0, 1, NULL, NULL, NULL),
(202, 19, 15, NULL, 0, 0, NULL, NULL, NULL),
(203, 20, 15, NULL, 0, 0, NULL, NULL, NULL),
(204, 21, 15, NULL, 0, 0, NULL, NULL, NULL),
(205, 22, 15, NULL, 0, 0, NULL, NULL, NULL),
(206, 23, 15, NULL, 1, 0, NULL, '2024-09-13 04:20:50.000000', NULL),
(207, 23, 8, NULL, 0, 1, '2024-09-13 03:46:52.000000', '2024-09-13 03:47:57.000000', NULL),
(208, 1, 16, NULL, 0, 1, NULL, NULL, NULL),
(209, 2, 16, 1, 0, 1, NULL, NULL, NULL),
(210, 3, 16, NULL, 0, 1, NULL, NULL, NULL),
(211, 4, 16, NULL, 0, 1, NULL, NULL, NULL),
(212, 5, 16, NULL, 0, 0, NULL, NULL, NULL),
(213, 6, 16, NULL, 0, 0, NULL, NULL, NULL),
(214, 7, 16, NULL, 0, 1, NULL, NULL, NULL),
(215, 19, 16, NULL, 0, 0, NULL, NULL, NULL),
(216, 20, 16, NULL, 0, 0, NULL, NULL, NULL),
(217, 21, 16, NULL, 0, 0, NULL, NULL, NULL),
(218, 22, 16, NULL, 0, 0, NULL, NULL, NULL),
(219, 23, 16, NULL, 0, 0, NULL, NULL, NULL),
(220, 24, 7, NULL, 6, 1, NULL, '2024-10-04 04:27:54.000000', NULL),
(221, 24, 8, NULL, 0, 1, NULL, NULL, NULL),
(222, 24, 9, NULL, 0, 1, NULL, NULL, NULL),
(223, 24, 10, NULL, 0, 1, NULL, NULL, NULL),
(224, 24, 11, NULL, 0, 1, NULL, NULL, NULL),
(225, 24, 12, NULL, 0, 1, NULL, NULL, NULL),
(226, 24, 13, NULL, 0, 1, NULL, NULL, NULL),
(227, 24, 14, NULL, 0, 1, NULL, NULL, NULL),
(228, 24, 15, NULL, 0, 1, NULL, NULL, NULL),
(229, 24, 16, NULL, 0, 1, NULL, NULL, NULL),
(230, 25, 8, NULL, 8, 1, '2024-10-04 03:41:21.000000', '2024-10-04 03:53:42.000000', NULL),
(231, 25, 1, NULL, 0, 1, '2024-10-04 03:41:21.000000', '2024-10-04 03:41:21.000000', NULL),
(232, 25, 2, NULL, 0, 1, '2024-10-04 03:41:21.000000', '2024-10-04 03:41:21.000000', NULL),
(233, 25, 3, NULL, 0, 1, '2024-10-04 03:41:21.000000', '2024-10-04 03:41:21.000000', NULL),
(234, 25, 4, NULL, 0, 1, '2024-10-04 03:41:21.000000', '2024-10-04 03:41:21.000000', NULL),
(235, 25, 5, NULL, 0, 1, '2024-10-04 03:41:21.000000', '2024-10-04 03:41:21.000000', NULL),
(236, 25, 6, NULL, 0, 1, '2024-10-04 03:41:21.000000', '2024-10-04 03:41:21.000000', NULL),
(243, 25, 7, NULL, 0, 1, '2024-10-07 04:18:18.000000', '2024-10-07 04:20:38.000000', NULL),
(244, 25, 1, NULL, 0, 1, '2024-10-07 04:18:18.000000', '2024-10-07 04:18:18.000000', NULL),
(245, 25, 2, NULL, 0, 1, '2024-10-07 04:18:18.000000', '2024-10-07 04:18:18.000000', NULL),
(246, 25, 3, NULL, 0, 1, '2024-10-07 04:18:18.000000', '2024-10-07 04:18:18.000000', NULL),
(247, 25, 4, NULL, 0, 1, '2024-10-07 04:18:18.000000', '2024-10-07 04:18:18.000000', NULL),
(248, 25, 5, NULL, 0, 1, '2024-10-07 04:18:18.000000', '2024-10-07 04:18:18.000000', NULL),
(249, 25, 6, NULL, 0, 1, '2024-10-07 04:18:18.000000', '2024-10-07 04:18:18.000000', NULL),
(250, 25, 16, NULL, 5, 1, '2024-10-07 04:20:38.000000', '2024-10-07 04:20:38.000000', NULL),
(251, 1, 17, NULL, 0, 1, NULL, NULL, NULL),
(252, 2, 17, 1, 0, 1, NULL, NULL, NULL),
(253, 3, 17, NULL, 0, 1, NULL, NULL, NULL),
(254, 4, 17, NULL, 0, 1, NULL, NULL, NULL),
(255, 5, 17, NULL, 0, 0, NULL, NULL, NULL),
(256, 6, 17, NULL, 0, 0, NULL, NULL, NULL),
(257, 7, 17, NULL, 0, 1, NULL, NULL, NULL),
(258, 19, 17, NULL, 0, 0, NULL, NULL, NULL),
(259, 20, 17, NULL, 0, 0, NULL, NULL, NULL),
(260, 21, 17, NULL, 0, 0, NULL, NULL, NULL),
(261, 22, 17, NULL, 0, 0, NULL, NULL, NULL),
(262, 23, 17, NULL, 0, 0, NULL, NULL, NULL),
(263, 24, 17, NULL, 0, 1, NULL, NULL, NULL),
(264, 25, 17, NULL, 0, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `providers`
--

CREATE TABLE `providers` (
  `id` int NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `code` int NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tax_number` varchar(192) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `adresse` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `providers`
--

INSERT INTO `providers` (`id`, `name`, `code`, `email`, `phone`, `tax_number`, `country`, `city`, `adresse`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Toko Kelontong', 1, 'kelontong@gmail.com', '081208311278', '12222', 'Indonesia', 'Jakarta', 'Jl. Jalan Jalan Jalan Kaki', '2024-05-27 06:21:41.000000', '2024-05-27 06:21:41.000000', NULL),
(18, 'Tiki Jalur Nugraha Ekakurir, PT (JNE)', 192, 'customercare@jne.co.id', '(021) 566 5262', NULL, NULL, NULL, NULL, '2024-09-05 08:52:15.000000', '2024-09-05 08:52:15.000000', NULL),
(20, 'Angkasa Travel International, PT', 203, '123@gmail.com', '061-4532188', NULL, NULL, NULL, NULL, '2024-09-09 07:03:53.000000', '2024-09-09 07:03:53.000000', NULL),
(21, 'Agres Info Teknologi, PT', 207, 'info@agres.co.id', '0812-9700-9700', NULL, NULL, NULL, NULL, '2024-10-04 03:41:21.000000', '2024-10-04 03:41:21.000000', NULL),
(22, 'Tokopedia', 1, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-04 03:44:46.000000', '2024-10-04 03:44:46.000000', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `creator_name` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Ref` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `date` date NOT NULL,
  `provider_id` int NOT NULL,
  `warehouse_id` int NOT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `tax_rate` double DEFAULT '0',
  `TaxNet` double DEFAULT '0',
  `discount` double DEFAULT '0',
  `shipping` double DEFAULT '0',
  `GrandTotal` double NOT NULL,
  `paid_amount` double NOT NULL DEFAULT '0',
  `statut` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `payment_statut` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `notes` text COLLATE utf8mb4_general_ci,
  `image` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `user_id`, `creator_name`, `Ref`, `date`, `provider_id`, `warehouse_id`, `category_id`, `tax_rate`, `TaxNet`, `discount`, `shipping`, `GrandTotal`, `paid_amount`, `statut`, `payment_statut`, `notes`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, NULL, 'PR_1111', '2024-05-27', 1, 1, NULL, 0, 0, 0, 0, 215000, 215000, 'received', 'paid', 'testing untuk tambah qty', NULL, '2024-05-27 06:27:00.000000', '2024-05-27 07:06:52.000000', NULL),
(7, 42, 'Wahyu', '02715/PO/SII/09/24', '2024-09-05', 18, 1, NULL, 0, 0, 0, 0, 3950000, 0, 'received', 'unpaid', NULL, NULL, '2024-09-05 11:24:50.000000', '2024-09-05 11:24:50.000000', NULL),
(9, 4, 'Purchasing', '02715/PO/SII/09/24', '2024-09-09', 18, 1, NULL, NULL, NULL, 0, 0, 3950000, 3950000, 'received', 'unpaid', NULL, NULL, '2024-09-09 03:13:39.000000', '2024-09-09 03:13:39.000000', NULL),
(11, 42, 'Wahyu', '02717/PO/SII/09/24', '2024-09-09', 18, 7, NULL, 0, 0, 0, 0, 305000, 305000, 'received', 'unpaid', NULL, NULL, '2024-09-09 06:24:23.000000', '2024-09-09 06:24:23.000000', NULL),
(13, 42, 'Wahyu', '02719/PO/SII/09/24', '2024-09-09', 20, 7, NULL, 0, 0, 100000, 0, 3989900, 3989900, 'received', 'unpaid', NULL, NULL, '2024-09-09 07:03:53.000000', '2024-09-09 07:03:53.000000', NULL),
(14, 4, 'Purchasing', '02717/PO/SII/09/24', '2024-09-09', 18, 7, NULL, 0, 0, 0, 0, 305000, 305000, 'received', 'unpaid', NULL, NULL, '2024-09-09 07:57:41.000000', '2024-09-09 07:57:41.000000', NULL),
(15, 4, 'Purchasing', '02720/PO/SII/09/24', '2024-09-11', 18, 7, NULL, 0, 0, 0, 0, 320000, 320000, 'received', 'unpaid', NULL, NULL, '2024-09-11 08:56:30.000000', '2024-09-11 08:56:30.000000', NULL),
(16, 42, 'Wahyu', '02721/PO/SII/10/24', '2024-10-04', 21, 8, NULL, 0, 0, 0, 25000, 25026000, 25026000, 'received', 'unpaid', NULL, NULL, '2024-10-04 03:41:21.000000', '2024-10-04 03:41:21.000000', NULL),
(17, 42, 'Wahyu', '02722/PO/SII/10/24', '2024-10-04', 22, 8, NULL, 0, 0, 100000, 20000, 7930000, 7930000, 'received', 'unpaid', NULL, NULL, '2024-10-04 03:44:46.000000', '2024-10-04 03:44:46.000000', NULL),
(18, 42, 'Wahyu', '02722/PO/SII/10/24', '2024-10-04', 22, 8, NULL, 0, 0, 100000, 20000, 7930000, 7930000, 'received', 'unpaid', NULL, NULL, '2024-10-04 03:53:42.000000', '2024-10-04 03:53:42.000000', NULL),
(19, 4, 'Purchasing', '02723/PO/SII/10/24', '2024-10-07', 18, 7, NULL, 0, 0, 0, 0, 7900000, 7900000, 'received', 'unpaid', NULL, NULL, '2024-10-07 04:18:17.000000', '2024-10-07 04:18:17.000000', NULL),
(20, NULL, NULL, 'PR_79f375', '2025-09-19', 20, 2, NULL, 0, 0, 0, 0, 0, 0, 'received', 'unpaid', 'oil new', NULL, '2025-09-19 06:58:47.000000', '2025-09-19 06:58:47.000000', NULL),
(21, NULL, NULL, 'PR_fe30a9', '2025-09-19', 21, 16, 5, 0, 0, 0, 0, 0, 0, 'received', 'unpaid', 'oil 20', '1758330529_68cdfea1d27a9.png', '2025-09-19 06:59:43.000000', '2025-09-19 18:08:49.000000', NULL),
(22, NULL, NULL, 'PR_191fcf', '2025-09-19', 21, 15, NULL, 0, 0, 0, 0, 0, 0, 'received', 'unpaid', NULL, NULL, '2025-09-19 08:40:01.000000', '2025-09-19 08:49:19.000000', NULL),
(23, NULL, NULL, 'PR_8e8ec9', '2025-09-19', 21, 15, 5, 0, 0, 0, 0, 0, 0, 'received', 'unpaid', NULL, '1758299176_68cd8428e84c5.png', '2025-09-19 09:26:16.000000', '2025-09-19 15:55:37.000000', NULL),
(24, NULL, NULL, 'PR_cb27b1', '2025-09-20', 21, 16, NULL, 0, 0, 0, 0, 0, 0, 'received', 'unpaid', NULL, '1758330892_68ce000cb2171.png', '2025-09-19 18:14:52.000000', '2025-09-19 18:14:52.000000', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `id` int NOT NULL,
  `cost` double NOT NULL,
  `purchase_unit_id` int DEFAULT NULL,
  `TaxNet` double DEFAULT '0',
  `tax_method` varchar(192) COLLATE utf8mb4_general_ci DEFAULT '1',
  `discount` double DEFAULT '0',
  `discount_method` varchar(192) COLLATE utf8mb4_general_ci DEFAULT '1',
  `purchase_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_variant_id` int DEFAULT NULL,
  `imei_number` text COLLATE utf8mb4_general_ci,
  `total` double NOT NULL,
  `quantity` double NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_details`
--

INSERT INTO `purchase_details` (`id`, `cost`, `purchase_unit_id`, `TaxNet`, `tax_method`, `discount`, `discount_method`, `purchase_id`, `product_id`, `product_variant_id`, `imei_number`, `total`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1500, 1, 0, '2', 0, '2', 1, 3, NULL, NULL, 15000, 10, NULL, NULL),
(2, 2000, 1, 2, '2', 0, '2', 1, 2, 1, NULL, 200000, 100, NULL, NULL),
(18, 15000, 19, NULL, NULL, NULL, NULL, 7, 7, NULL, NULL, 150000, 10, NULL, NULL),
(19, 80000, 20, NULL, NULL, NULL, NULL, 7, 1, NULL, NULL, 800000, 10, NULL, NULL),
(20, 1500000, 21, NULL, NULL, NULL, NULL, 7, 6, NULL, NULL, 3000000, 2, NULL, NULL),
(21, 15000, 25, 0, '0', 0, NULL, 9, 7, NULL, NULL, 150000, 10, NULL, NULL),
(22, 80000, 26, 0, '0', 0, NULL, 9, 1, NULL, NULL, 800000, 10, NULL, NULL),
(23, 1500000, 27, 0, '0', 0, NULL, 9, 6, NULL, NULL, 3000000, 2, NULL, NULL),
(26, 300000, 30, 0, '0', 0, NULL, 11, 1, NULL, NULL, 300000, 1, NULL, NULL),
(27, 5000, 31, 0, '0', 0, NULL, 11, 1, NULL, NULL, 5000, 1, NULL, NULL),
(28, 1230000, 33, 0, '0', 0, NULL, 13, 19, NULL, NULL, 1230000, 1, NULL, NULL),
(29, 1230000, 34, 0, '0', 0, NULL, 13, 20, NULL, NULL, 1230000, 1, NULL, NULL),
(30, 1230000, 35, 0, '0', 0, NULL, 13, 21, NULL, NULL, 1230000, 1, NULL, NULL),
(31, 300000, 36, 0, '0', 0, NULL, 14, 1, NULL, NULL, 300000, 1, NULL, NULL),
(32, 5000, 37, 0, '0', 0, NULL, 14, 1, NULL, NULL, 5000, 1, NULL, NULL),
(33, 300000, 38, 0, '0', 0, NULL, 15, 22, NULL, NULL, 300000, 1, NULL, NULL),
(34, 20000, 39, 0, '0', 0, NULL, 15, 23, NULL, NULL, 20000, 1, NULL, NULL),
(35, 5000000, 28, 0, '0', 0, NULL, 16, 25, NULL, NULL, 25000000, 5, NULL, NULL),
(36, 2000000, 28, 0, '0', 0, NULL, 17, 25, NULL, NULL, 8000000, 4, NULL, NULL),
(37, 2000000, 28, 0, '0', 0, NULL, 18, 25, NULL, NULL, 8000000, 4, NULL, NULL),
(38, 1500000, 28, 0, '0', 0, NULL, 19, 25, NULL, NULL, 7500000, 5, NULL, NULL),
(39, 400000, 28, 0, '0', 0, NULL, 19, 22, NULL, NULL, 400000, 1, NULL, NULL),
(40, 0, NULL, 0, '1', 0, '1', 21, 2, NULL, NULL, 0, 1, '2025-09-19 06:59:43.000000', '2025-09-19 06:59:43.000000'),
(41, 0, NULL, 0, '1', 0, '1', 22, 24, NULL, NULL, 0, 1, '2025-09-19 08:40:01.000000', '2025-09-19 08:40:01.000000'),
(42, 0, NULL, 0, '1', 0, '1', 23, 5, NULL, NULL, 0, 1, '2025-09-19 09:26:16.000000', '2025-09-19 09:26:16.000000'),
(43, 0, NULL, 0, '1', 0, '1', 24, 1, NULL, NULL, 0, 1, '2025-09-19 18:14:52.000000', '2025-09-19 18:14:52.000000');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_returns`
--

CREATE TABLE `purchase_returns` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `date` date NOT NULL,
  `Ref` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `purchase_id` int DEFAULT NULL,
  `provider_id` int NOT NULL,
  `warehouse_id` int NOT NULL,
  `tax_rate` double DEFAULT '0',
  `TaxNet` double DEFAULT '0',
  `discount` double DEFAULT '0',
  `shipping` double DEFAULT '0',
  `GrandTotal` double NOT NULL,
  `paid_amount` double NOT NULL DEFAULT '0',
  `payment_statut` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `statut` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `notes` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return_details`
--

CREATE TABLE `purchase_return_details` (
  `id` int NOT NULL,
  `cost` decimal(16,3) NOT NULL,
  `purchase_unit_id` int DEFAULT NULL,
  `TaxNet` double DEFAULT '0',
  `tax_method` varchar(192) COLLATE utf8mb4_general_ci DEFAULT '1',
  `discount` double DEFAULT '0',
  `discount_method` varchar(192) COLLATE utf8mb4_general_ci DEFAULT '1',
  `total` double NOT NULL,
  `quantity` double NOT NULL,
  `purchase_return_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_variant_id` int DEFAULT NULL,
  `imei_number` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE `quotations` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `date` date NOT NULL,
  `Ref` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `client_id` int NOT NULL,
  `warehouse_id` int NOT NULL,
  `tax_rate` double DEFAULT '0',
  `TaxNet` double DEFAULT '0',
  `discount` double DEFAULT '0',
  `shipping` double DEFAULT '0',
  `GrandTotal` double NOT NULL,
  `statut` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `notes` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quotation_details`
--

CREATE TABLE `quotation_details` (
  `id` int NOT NULL,
  `price` double NOT NULL,
  `sale_unit_id` int DEFAULT NULL,
  `TaxNet` double DEFAULT '0',
  `tax_method` varchar(192) COLLATE utf8mb4_general_ci DEFAULT '1',
  `discount` double DEFAULT '0',
  `discount_method` varchar(192) COLLATE utf8mb4_general_ci DEFAULT '1',
  `total` double NOT NULL,
  `quantity` double NOT NULL,
  `product_id` int NOT NULL,
  `product_variant_id` int DEFAULT NULL,
  `imei_number` text COLLATE utf8mb4_general_ci,
  `quotation_id` int NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int NOT NULL,
  `name` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `label` varchar(192) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `label`, `description`, `created_at`, `updated_at`, `deleted_at`, `status`) VALUES
(1, 'Owner', 'Owner', 'Owner', NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `role_id` int NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `date` date NOT NULL,
  `Ref` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `is_pos` tinyint(1) DEFAULT '0',
  `client_id` int NOT NULL,
  `warehouse_id` int NOT NULL,
  `tax_rate` double DEFAULT '0',
  `TaxNet` double DEFAULT '0',
  `discount` double DEFAULT '0',
  `shipping` double DEFAULT '0',
  `GrandTotal` double NOT NULL DEFAULT '0',
  `paid_amount` double NOT NULL DEFAULT '0',
  `payment_statut` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `statut` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `shipping_status` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `user_id`, `date`, `Ref`, `is_pos`, `client_id`, `warehouse_id`, `tax_rate`, `TaxNet`, `discount`, `shipping`, `GrandTotal`, `paid_amount`, `payment_statut`, `statut`, `shipping_status`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '2024-06-12', 'SL_1111', 1, 2, 1, 0, 0, 0, 0, 130000, 130000, 'paid', 'completed', NULL, NULL, '2024-06-12 09:37:34.000000', '2024-06-12 09:37:34.000000', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sale_details`
--

CREATE TABLE `sale_details` (
  `id` int NOT NULL,
  `date` date NOT NULL,
  `sale_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_variant_id` int DEFAULT NULL,
  `imei_number` text COLLATE utf8mb4_general_ci,
  `price` double NOT NULL,
  `sale_unit_id` int DEFAULT NULL,
  `TaxNet` double DEFAULT NULL,
  `tax_method` varchar(192) COLLATE utf8mb4_general_ci DEFAULT '1',
  `discount` double DEFAULT NULL,
  `discount_method` varchar(192) COLLATE utf8mb4_general_ci DEFAULT '1',
  `total` double NOT NULL,
  `quantity` double NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sale_details`
--

INSERT INTO `sale_details` (`id`, `date`, `sale_id`, `product_id`, `product_variant_id`, `imei_number`, `price`, `sale_unit_id`, `TaxNet`, `tax_method`, `discount`, `discount_method`, `total`, `quantity`, `created_at`, `updated_at`) VALUES
(1, '2024-06-12', 1, 1, NULL, NULL, 130000, 1, 0, '1', 0, '2', 130000, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sale_returns`
--

CREATE TABLE `sale_returns` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `date` date NOT NULL,
  `Ref` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `sale_id` int DEFAULT NULL,
  `client_id` int NOT NULL,
  `warehouse_id` int NOT NULL,
  `tax_rate` double DEFAULT '0',
  `TaxNet` double DEFAULT '0',
  `discount` double DEFAULT '0',
  `shipping` double DEFAULT '0',
  `GrandTotal` double NOT NULL,
  `paid_amount` double NOT NULL DEFAULT '0',
  `payment_statut` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `statut` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `notes` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_return_details`
--

CREATE TABLE `sale_return_details` (
  `id` int NOT NULL,
  `sale_return_id` int NOT NULL,
  `product_id` int NOT NULL,
  `price` double NOT NULL,
  `sale_unit_id` int DEFAULT NULL,
  `TaxNet` double DEFAULT '0',
  `tax_method` varchar(192) COLLATE utf8mb4_general_ci DEFAULT '1',
  `discount` double DEFAULT '0',
  `discount_method` varchar(192) COLLATE utf8mb4_general_ci DEFAULT '1',
  `product_variant_id` int DEFAULT NULL,
  `imei_number` text COLLATE utf8mb4_general_ci,
  `quantity` double NOT NULL,
  `total` double NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `servers`
--

CREATE TABLE `servers` (
  `id` int NOT NULL,
  `mail_mailer` varchar(191) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'smtp',
  `host` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `port` int NOT NULL,
  `sender_name` varchar(191) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Admin',
  `username` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `encryption` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `servers`
--

INSERT INTO `servers` (`id`, `mail_mailer`, `host`, `port`, `sender_name`, `username`, `password`, `encryption`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'smtp', 'mailtrap.io', 2525, 'Admin', 'test', 'test', 'tls', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `currency_id` int DEFAULT NULL,
  `CompanyName` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `CompanyPhone` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `CompanyAdress` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `logo` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_invoice_footer` tinyint(1) NOT NULL DEFAULT '0',
  `invoice_footer` varchar(192) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `footer` varchar(192) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Stocky - Ultimate Inventory With POS',
  `developed_by` varchar(192) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Stocky',
  `client_id` int DEFAULT NULL,
  `warehouse_id` int DEFAULT NULL,
  `default_language` varchar(192) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'en',
  `sms_gateway` int DEFAULT '1',
  `quotation_with_stock` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `email`, `currency_id`, `CompanyName`, `CompanyPhone`, `CompanyAdress`, `logo`, `is_invoice_footer`, `invoice_footer`, `footer`, `developed_by`, `client_id`, `warehouse_id`, `default_language`, `sms_gateway`, `quotation_with_stock`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'solusi@intek.co.id', 2, 'Solusi Intek Indonesia', '6315996770', 'Jl. Cikunir Raya No.08, RT.004/RW.001, Jaka Mulya, Kec. Bekasi Sel., Kota Bks, Jawa Barat 17146', 'logo-default.png', 0, 'null', 'SII - Ultimate Inventory With POS', 'SII', 1, NULL, 'en', 1, 0, NULL, '2024-09-09 07:27:14.000000', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shipments`
--

CREATE TABLE `shipments` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Ref` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `sale_id` int NOT NULL,
  `delivered_to` varchar(192) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `shipping_address` text COLLATE utf8mb4_general_ci,
  `status` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `shipping_details` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sms_gateway`
--

CREATE TABLE `sms_gateway` (
  `id` int NOT NULL,
  `title` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sms_gateway`
--

INSERT INTO `sms_gateway` (`id`, `title`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'twilio', NULL, NULL, NULL),
(2, 'nexmo', NULL, NULL, NULL),
(3, 'infobip', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sms_messages`
--

CREATE TABLE `sms_messages` (
  `id` int NOT NULL,
  `name` text COLLATE utf8mb4_general_ci,
  `text` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sms_messages`
--

INSERT INTO `sms_messages` (`id`, `name`, `text`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'sale', 'Dear {contact_name},\nThank you for your purchase! Your invoice number is {invoice_number}.\nIf you have any questions or concerns, please don\'t hesitate to reach out to us. We are here to help!\nBest regards,\n{business_name}', NULL, NULL, NULL),
(2, 'purchase', 'Dear {contact_name},\nI recently made a purchase from your company and I wanted to thank you for your cooperation and service. My invoice number is {invoice_number} .\nIf you have any questions or concerns regarding my purchase, please don\'t hesitate to contact me. I am here to make sure I have a positive experience with your company.\nBest regards,\n{business_name}', NULL, NULL, NULL),
(3, 'quotation', 'Dear {contact_name},\nThank you for your interest in our products. Your quotation number is {quotation_number}.\nPlease let us know if you have any questions or concerns regarding your quotation. We are here to assist you.\nBest regards,\n{business_name}', NULL, NULL, NULL),
(4, 'payment_received', 'Dear {contact_name},\nThank you for making your payment. We have received it and it has been processed successfully.\nIf you have any further questions or concerns, please don\'t hesitate to reach out to us. We are always here to help.\nBest regards,\n{business_name}', NULL, NULL, NULL),
(5, 'payment_sent', 'Dear {contact_name},\nWe have just sent the payment . We appreciate your prompt attention to this matter and the high level of service you provide.\nIf you need any further information or clarification, please do not hesitate to reach out to us. We are here to help.\nBest regards,\n{business_name}', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `id` int NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `creator_name` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Ref` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `date` date NOT NULL,
  `from_warehouse_id` int NOT NULL,
  `to_warehouse_id` int NOT NULL,
  `items` double NOT NULL,
  `tax_rate` double DEFAULT '0',
  `TaxNet` double DEFAULT '0',
  `discount` double DEFAULT '0',
  `shipping` double DEFAULT '0',
  `GrandTotal` double NOT NULL DEFAULT '0',
  `statut` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `notes` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transfers`
--

INSERT INTO `transfers` (`id`, `user_id`, `creator_name`, `Ref`, `date`, `from_warehouse_id`, `to_warehouse_id`, `items`, `tax_rate`, `TaxNet`, `discount`, `shipping`, `GrandTotal`, `statut`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 129, NULL, 'TR_1111', '2024-09-03', 5, 8, 1, 0, 0, 0, 0, 0, 'pending', NULL, '2024-09-03 11:19:14.000000', '2025-09-19 10:05:11.000000', NULL),
(6, 1, NULL, 'TR_1112', '2024-09-12', 7, 15, 1, 0, 0, 0, 0, 0, 'completed', NULL, '2024-09-12 09:54:35.000000', '2024-09-12 09:54:35.000000', NULL),
(7, 1, NULL, 'TR_1113', '2024-09-12', 7, 15, 1, 0, 0, 0, 0, 0, 'completed', NULL, '2024-09-12 09:58:45.000000', '2024-09-12 09:58:45.000000', NULL),
(12, 129, NULL, 'TR_1114', '2024-09-13', 7, 8, 1, 0, 0, 0, 0, 0, 'completed', 'TEST', '2024-09-13 03:46:52.000000', '2024-09-13 03:46:52.000000', NULL),
(13, 129, NULL, 'TR_1115', '2024-09-13', 8, 7, 1, 0, 0, 0, 0, 0, 'completed', 'TEST 689 -> 08', '2024-09-13 03:47:57.000000', '2024-09-13 03:47:57.000000', NULL),
(14, 1, NULL, 'TR_1116', '2024-09-13', 7, 15, 1, 0, 0, 0, 0, 0, 'completed', NULL, '2024-09-13 04:20:50.000000', '2024-09-13 04:20:50.000000', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transfer_details`
--

CREATE TABLE `transfer_details` (
  `id` int NOT NULL,
  `transfer_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_variant_id` int DEFAULT NULL,
  `cost` double NOT NULL,
  `purchase_unit_id` int DEFAULT NULL,
  `TaxNet` double DEFAULT NULL,
  `tax_method` varchar(192) COLLATE utf8mb4_general_ci DEFAULT '1',
  `discount` double DEFAULT NULL,
  `discount_method` varchar(192) COLLATE utf8mb4_general_ci DEFAULT '1',
  `quantity` double NOT NULL,
  `total` double NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transfer_details`
--

INSERT INTO `transfer_details` (`id`, `transfer_id`, `product_id`, `product_variant_id`, `cost`, `purchase_unit_id`, `TaxNet`, `tax_method`, `discount`, `discount_method`, `quantity`, `total`, `created_at`, `updated_at`) VALUES
(1, 5, 7, NULL, 0, 2, 0, '1', 0, '2', 1, 0, NULL, NULL),
(7, 12, 23, NULL, 0, 39, 0, '0', 0, '2', 1, 0, NULL, NULL),
(8, 13, 23, NULL, 0, 39, 0, '0', 0, '2', 1, 0, NULL, NULL),
(9, 14, 23, NULL, 0, 39, 0, '0', 0, '2', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transfer_money`
--

CREATE TABLE `transfer_money` (
  `id` int NOT NULL,
  `from_account_id` int NOT NULL,
  `to_account_id` int NOT NULL,
  `date` date NOT NULL,
  `amount` double NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int NOT NULL,
  `name` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `ShortName` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `base_unit` int DEFAULT NULL,
  `operator` char(192) COLLATE utf8mb4_general_ci DEFAULT '*',
  `operator_value` double DEFAULT '1',
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `ShortName`, `base_unit`, `operator`, `operator_value`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Liter', 'Ltr', NULL, '*', 1, '2024-05-17 10:04:08.000000', '2024-05-17 10:04:08.000000', NULL),
(2, 'Piece', 'Pcs', NULL, '*', 1, '2024-08-20 06:28:19.000000', '2024-08-20 06:28:19.000000', NULL),
(10, 'Piece', 'Pee', NULL, '*', 1, '2024-09-05 08:52:15.000000', '2024-09-05 08:52:15.000000', NULL),
(11, 'Batang', 'Btg', NULL, '*', 1, '2024-09-05 08:52:15.000000', '2024-09-05 08:52:15.000000', NULL),
(12, 'Batang', 'Btg', NULL, '*', 1, '2024-09-05 08:52:15.000000', '2024-09-05 08:52:15.000000', NULL),
(13, 'Piece', 'Pee', NULL, '*', 1, '2024-09-05 09:06:21.000000', '2024-09-05 09:06:21.000000', NULL),
(14, 'Batang', 'Btg', NULL, '*', 1, '2024-09-05 09:06:21.000000', '2024-09-05 09:06:21.000000', NULL),
(15, 'Batang', 'Btg', NULL, '*', 1, '2024-09-05 09:06:21.000000', '2024-09-05 09:06:21.000000', NULL),
(16, 'Piece', 'Pee', NULL, '*', 1, '2024-09-05 10:58:16.000000', '2024-09-05 10:58:16.000000', NULL),
(17, 'Batang', 'Btg', NULL, '*', 1, '2024-09-05 10:58:16.000000', '2024-09-05 10:58:16.000000', NULL),
(18, 'Batang', 'Btg', NULL, '*', 1, '2024-09-05 10:58:16.000000', '2024-09-05 10:58:16.000000', NULL),
(19, 'Piece', 'Pee', NULL, '*', 1, '2024-09-05 11:24:50.000000', '2024-09-05 11:24:50.000000', NULL),
(20, 'Batang', 'Btg', NULL, '*', 1, '2024-09-05 11:24:50.000000', '2024-09-05 11:24:50.000000', NULL),
(21, 'Batang', 'Btg', NULL, '*', 1, '2024-09-05 11:24:50.000000', '2024-09-05 11:24:50.000000', NULL),
(25, 'Piece', 'Pee', NULL, '*', 1, '2024-09-09 03:13:39.000000', '2024-09-09 03:13:39.000000', NULL),
(26, 'Batang', 'Btg', NULL, '*', 1, '2024-09-09 03:13:39.000000', '2024-09-09 03:13:39.000000', NULL),
(27, 'Batang', 'Btg', NULL, '*', 1, '2024-09-09 03:13:39.000000', '2024-09-09 03:13:39.000000', NULL),
(28, 'Pcs', 'Pcs', NULL, '*', 1, '2024-09-09 04:33:21.000000', '2024-09-09 04:33:21.000000', NULL),
(29, 'Dus', 'Dus', NULL, '*', 1, '2024-09-09 04:33:21.000000', '2024-09-09 04:33:21.000000', NULL),
(30, 'Pcs', 'Pcs', NULL, '*', 1, '2024-09-09 06:24:23.000000', '2024-09-09 06:24:23.000000', NULL),
(31, 'Dus', 'Dus', NULL, '*', 1, '2024-09-09 06:24:23.000000', '2024-09-09 06:24:23.000000', NULL),
(33, 'Pax', 'Pax', NULL, '*', 1, '2024-09-09 07:03:53.000000', '2024-09-09 07:03:53.000000', NULL),
(34, 'Pax', 'Pax', NULL, '*', 1, '2024-09-09 07:03:53.000000', '2024-09-13 06:35:46.000000', '2024-09-13 06:35:46'),
(35, 'Pax', 'Pax', NULL, '*', 1, '2024-09-09 07:03:53.000000', '2024-09-13 06:35:28.000000', '2024-09-13 06:35:28'),
(36, 'Pcs', 'Pcs', NULL, '*', 1, '2024-09-09 07:57:41.000000', '2024-09-13 06:35:20.000000', '2024-09-13 06:35:20'),
(37, 'Dus', 'Dus', NULL, '*', 1, '2024-09-09 07:57:41.000000', '2024-09-09 07:57:41.000000', NULL),
(38, 'Pcs', 'Pcs', NULL, '*', 1, '2024-09-11 08:56:30.000000', '2024-09-11 08:56:30.000000', NULL),
(39, 'Pcs', 'Pcs', NULL, '*', 1, '2024-09-11 08:56:30.000000', '2024-09-13 06:35:12.000000', '2024-09-13 06:35:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `firstname` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `role_id` int NOT NULL,
  `statut` tinyint(1) NOT NULL DEFAULT '1',
  `is_all_warehouses` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `email`, `password`, `avatar`, `phone`, `role_id`, `statut`, `is_all_warehouses`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'William', 'Castillo', 'William Castillo', 'admin@example.com', '$2y$10$IFj6SwqC0Sxrsiv4YkCt.OJv1UV4mZrWuyLoRG7qt47mseP9mJ58u', 'no_avatar.png', '0123456789', 1, 1, 1, NULL, NULL, NULL),
(2, 'Admin', 'Admin Wow', 'Admin', 'admin@admin.com', '$2y$10$2QY4rCaf6UXPeTx9sicaJuHfRTArXToHecwGGKiUivMT5381ds6VC', 'no_avatar.png', '0123456789', 1, 1, 1, NULL, NULL, NULL),
(3, 'Admin', 'Super', 'admin', 'admin2@example.com', '$2y$10$9ZIXUNpkj0Qr0Q5byMi.Ye4oKoEa3Ro91lC/.og/at2.uheWG/igi', NULL, '08123456789', 1, 1, 1, '2025-09-19 22:40:51.000000', '2025-09-19 22:40:51.000000', NULL),
(4, 'Admin', 'Super', 'admin', 'admin1@example.com', '$2y$12$95Jz0Ac2wqYYl2jc5PpSEehaZ78MSYiqV7byUWSRUA0aCaD/Nz6Da', NULL, '08123456789', 1, 1, 1, '2025-09-19 15:44:12.000000', '2025-09-19 15:44:12.000000', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_warehouse`
--

CREATE TABLE `user_warehouse` (
  `user_id` int NOT NULL,
  `warehouse_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_warehouse`
--

INSERT INTO `user_warehouse` (`user_id`, `warehouse_id`) VALUES
(1, 1),
(2, 1),
(1, 1),
(2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` int NOT NULL,
  `parent_id` int DEFAULT NULL,
  `name` varchar(192) COLLATE utf8mb4_general_ci NOT NULL,
  `city` varchar(192) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mobile` varchar(192) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `zip` varchar(192) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(192) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `country` varchar(192) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `parent_id`, `name`, `city`, `mobile`, `zip`, `email`, `country`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 'Default Warehouse', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(2, NULL, 'Warehouse 1', NULL, NULL, NULL, NULL, NULL, '2024-08-26 03:40:22.000000', '2024-08-26 03:43:32.000000', '2024-08-26 03:43:32'),
(3, NULL, 'D Warehouse 1', 'Bekasi', '0812828281', '12112', 'cikunir@anjay.mabar', 'Indonesia', '2024-08-26 03:45:06.000000', '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(4, 1, 'D Warehouse 2', NULL, NULL, NULL, NULL, NULL, '2024-08-26 03:50:39.000000', '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(5, 1, 'DW 2 1A', 'Jakarta', '0812828281', '12402', 'cikunir@mantap.mabar', 'Indonesia', '2024-08-26 04:27:49.000000', '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(6, 3, 'Gudang Tebet', 'Jakarta', '08128271114', '12530', 'anjay@duar.como', 'Indonesia', '2024-08-27 06:43:49.000000', '2024-09-02 03:42:09.000000', '2024-09-02 03:42:09'),
(7, NULL, 'CKR 08', NULL, NULL, NULL, NULL, NULL, '2024-09-03 07:23:54.000000', '2024-09-12 03:44:29.000000', NULL),
(8, NULL, 'CKR 689', NULL, NULL, NULL, NULL, NULL, '2024-09-03 09:37:59.000000', '2024-09-03 09:37:59.000000', NULL),
(9, 7, 'gudang depan', NULL, NULL, NULL, NULL, NULL, '2024-09-11 08:58:34.000000', '2024-09-11 08:58:34.000000', NULL),
(10, 9, 'rak 1', NULL, NULL, NULL, NULL, NULL, '2024-09-11 08:58:50.000000', '2024-09-11 08:58:50.000000', NULL),
(11, 7, 'gudang belakang', NULL, NULL, NULL, NULL, NULL, '2024-09-11 08:59:07.000000', '2024-09-11 08:59:07.000000', NULL),
(12, 11, 'rak 1', NULL, NULL, NULL, NULL, NULL, '2024-09-11 08:59:18.000000', '2024-09-11 08:59:18.000000', NULL),
(13, 12, 'row 1', NULL, NULL, NULL, NULL, NULL, '2024-09-11 08:59:37.000000', '2025-09-19 18:35:38.000000', '2025-09-19 18:35:38'),
(14, 12, 'row 2', NULL, NULL, NULL, NULL, NULL, '2024-09-11 08:59:46.000000', '2024-09-11 08:59:46.000000', NULL),
(15, 14, 'cb 5', NULL, NULL, NULL, NULL, NULL, '2024-09-11 09:00:04.000000', '2025-09-19 18:26:08.000000', '2025-09-19 18:26:08'),
(16, 13, 'cb 5', NULL, NULL, NULL, NULL, NULL, '2024-10-03 09:14:45.000000', '2024-10-03 09:14:45.000000', NULL),
(17, 7, 'gudang depan', NULL, NULL, NULL, NULL, NULL, '2024-10-18 07:05:37.000000', '2024-10-18 07:05:37.000000', NULL),
(18, NULL, 'gudang garam', NULL, NULL, NULL, NULL, NULL, '2025-09-19 18:25:54.000000', '2025-09-19 18:25:54.000000', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adjustments`
--
ALTER TABLE `adjustments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `warehouse_id_adjustment` (`warehouse_id`);

--
-- Indexes for table `adjustment_details`
--
ALTER TABLE `adjustment_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adjust_product_id` (`product_id`),
  ADD KEY `adjust_adjustment_id` (`adjustment_id`),
  ADD KEY `adjust_product_variant` (`product_variant_id`),
  ADD KEY `adjustment_details_warehouse_id_index` (`warehouse_id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendances_user_id` (`user_id`),
  ADD KEY `attendances_company_id` (`company_id`),
  ADD KEY `attendances_employee_id` (`employee_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `count_stock`
--
ALTER TABLE `count_stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `count_stock_user_id` (`user_id`),
  ADD KEY `count_stock_warehouse_id` (`warehouse_id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_company_id` (`company_id`),
  ADD KEY `department_department_head` (`department_head`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deposit_user_id` (`user_id`),
  ADD KEY `deposit_account_id` (`account_id`),
  ADD KEY `deposit_category_id` (`deposit_category_id`);

--
-- Indexes for table `deposit_categories`
--
ALTER TABLE `deposit_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `designation_company_id` (`company_id`),
  ADD KEY `designation_departement_id` (`department_id`);

--
-- Indexes for table `draft_sales`
--
ALTER TABLE `draft_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `draft_sales_user_id` (`user_id`),
  ADD KEY `draft_sales_client_id` (`client_id`),
  ADD KEY `draft_sales_warehouse_id` (`warehouse_id`);

--
-- Indexes for table `draft_sale_details`
--
ALTER TABLE `draft_sale_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `draft_sale_details_draft_sale_id` (`draft_sale_id`),
  ADD KEY `draft_sale_details_product_id` (`product_id`),
  ADD KEY `draft_sale_details_product_variant_id` (`product_variant_id`),
  ADD KEY `draft_sale_details_sale_unit_id` (`sale_unit_id`);

--
-- Indexes for table `ecommerce_clients`
--
ALTER TABLE `ecommerce_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ecommerce_clients_client_id` (`client_id`);

--
-- Indexes for table `email_messages`
--
ALTER TABLE `email_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employees_company_id` (`company_id`),
  ADD KEY `employees_department_id` (`department_id`),
  ADD KEY `employees_designation_id` (`designation_id`),
  ADD KEY `employees_office_shift_id` (`office_shift_id`);

--
-- Indexes for table `employee_accounts`
--
ALTER TABLE `employee_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_accounts_employee_id` (`employee_id`);

--
-- Indexes for table `employee_experiences`
--
ALTER TABLE `employee_experiences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_experience_employee_id` (`employee_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expense_user_id` (`user_id`),
  ADD KEY `expense_category_id` (`expense_category_id`),
  ADD KEY `expense_warehouse_id` (`warehouse_id`),
  ADD KEY `expense_account_id` (`account_id`);

--
-- Indexes for table `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expense_category_user_id` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `holidays_company_id` (`company_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_employee_id` (`employee_id`),
  ADD KEY `leave_company_id` (`company_id`),
  ADD KEY `leave_department_id` (`department_id`),
  ADD KEY `leave_leave_type_id` (`leave_type_id`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `office_shifts`
--
ALTER TABLE `office_shifts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `office_shift_company_id` (`company_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `token` (`token`);

--
-- Indexes for table `payment_purchases`
--
ALTER TABLE `payment_purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_payment_purchases` (`user_id`),
  ADD KEY `payments_purchase_id` (`purchase_id`),
  ADD KEY `payment_purchases_account_id` (`account_id`);

--
-- Indexes for table `payment_purchase_returns`
--
ALTER TABLE `payment_purchase_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_payment_return_purchase` (`user_id`),
  ADD KEY `supplier_id_payment_return_purchase` (`purchase_return_id`),
  ADD KEY `payment_purchase_returns_account_id` (`account_id`);

--
-- Indexes for table `payment_sales`
--
ALTER TABLE `payment_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_payments_sale` (`user_id`),
  ADD KEY `payment_sale_id` (`sale_id`),
  ADD KEY `payment_sales_account_id` (`account_id`);

--
-- Indexes for table `payment_sale_returns`
--
ALTER TABLE `payment_sale_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `factures_sale_return_user_id` (`user_id`),
  ADD KEY `factures_sale_return` (`sale_return_id`),
  ADD KEY `payment_sale_returns_account_id` (`account_id`);

--
-- Indexes for table `payment_with_credit_card`
--
ALTER TABLE `payment_with_credit_card`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payrolls_user_id` (`user_id`),
  ADD KEY `payrolls_employee_id` (`employee_id`),
  ADD KEY `payrolls_account_id` (`account_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_role_permission_id` (`permission_id`),
  ADD KEY `permission_role_role_id` (`role_id`);

--
-- Indexes for table `pos_settings`
--
ALTER TABLE `pos_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `brand_id_products` (`brand_id`),
  ADD KEY `unit_id_products` (`unit_id`),
  ADD KEY `unit_id_sales` (`unit_sale_id`),
  ADD KEY `unit_purchase_products` (`unit_purchase_id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id_variant` (`product_id`);

--
-- Indexes for table `product_warehouse`
--
ALTER TABLE `product_warehouse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_warehouse_id` (`product_id`),
  ADD KEY `warehouse_id` (`warehouse_id`),
  ADD KEY `product_variant_id` (`product_variant_id`);

--
-- Indexes for table `providers`
--
ALTER TABLE `providers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `provider_id` (`provider_id`),
  ADD KEY `warehouse_id_purchase` (`warehouse_id`);

--
-- Indexes for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_id` (`purchase_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `purchase_product_variant_id` (`product_variant_id`),
  ADD KEY `purchase_unit_id_purchase` (`purchase_unit_id`);

--
-- Indexes for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_returns` (`user_id`),
  ADD KEY `provider_id_return` (`provider_id`),
  ADD KEY `purchase_return_warehouse_id` (`warehouse_id`),
  ADD KEY `purchase_id_purchase_returns` (`purchase_id`);

--
-- Indexes for table `purchase_return_details`
--
ALTER TABLE `purchase_return_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_return_id_return` (`purchase_return_id`),
  ADD KEY `product_id_details_purchase_return` (`product_id`),
  ADD KEY `purchase_return_product_variant_id` (`product_variant_id`),
  ADD KEY `unit_id_purchase_return_details` (`purchase_unit_id`);

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_quotation` (`user_id`),
  ADD KEY `client_id_quotation` (`client_id`),
  ADD KEY `warehouse_id_quotation` (`warehouse_id`);

--
-- Indexes for table `quotation_details`
--
ALTER TABLE `quotation_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id_quotation_details` (`product_id`),
  ADD KEY `quote_product_variant_id` (`product_variant_id`),
  ADD KEY `quotation_id` (`quotation_id`),
  ADD KEY `sale_unit_id_quotation` (`sale_unit_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_user_user_id` (`user_id`),
  ADD KEY `role_user_role_id` (`role_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_sales` (`user_id`),
  ADD KEY `sale_client_id` (`client_id`),
  ADD KEY `warehouse_id_sale` (`warehouse_id`);

--
-- Indexes for table `sale_details`
--
ALTER TABLE `sale_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Details_Sale_id` (`sale_id`),
  ADD KEY `sale_product_id` (`product_id`),
  ADD KEY `sale_product_variant_id` (`product_variant_id`),
  ADD KEY `sales_sale_unit_id` (`sale_unit_id`);

--
-- Indexes for table `sale_returns`
--
ALTER TABLE `sale_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_returns` (`user_id`),
  ADD KEY `client_id_returns` (`client_id`),
  ADD KEY `warehouse_id_sale_return_id` (`warehouse_id`),
  ADD KEY `sale_id_return_sales` (`sale_id`);

--
-- Indexes for table `sale_return_details`
--
ALTER TABLE `sale_return_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `return_id` (`sale_return_id`),
  ADD KEY `product_id_details_returns` (`product_id`),
  ADD KEY `sale_return_id_product_variant_id` (`product_variant_id`),
  ADD KEY `sale_unit_id_return_details` (`sale_unit_id`);

--
-- Indexes for table `servers`
--
ALTER TABLE `servers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `warehouse_id` (`warehouse_id`);

--
-- Indexes for table `shipments`
--
ALTER TABLE `shipments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipment_user_id` (`user_id`),
  ADD KEY `shipment_sale_id` (`sale_id`);

--
-- Indexes for table `sms_gateway`
--
ALTER TABLE `sms_gateway`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_messages`
--
ALTER TABLE `sms_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_warehouse_id` (`from_warehouse_id`),
  ADD KEY `to_warehouse_id` (`to_warehouse_id`);

--
-- Indexes for table `transfer_details`
--
ALTER TABLE `transfer_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transfer_id` (`transfer_id`),
  ADD KEY `product_id_transfers` (`product_id`),
  ADD KEY `product_variant_id_transfer` (`product_variant_id`),
  ADD KEY `unit_sale_id_transfer` (`purchase_unit_id`);

--
-- Indexes for table `transfer_money`
--
ALTER TABLE `transfer_money`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_account_id` (`from_account_id`),
  ADD KEY `to_account_id` (`to_account_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `base_unit` (`base_unit`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_warehouse`
--
ALTER TABLE `user_warehouse`
  ADD KEY `user_warehouse_user_id` (`user_id`),
  ADD KEY `user_warehouse_warehouse_id` (`warehouse_id`);

--
-- Indexes for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `adjustments`
--
ALTER TABLE `adjustments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `adjustment_details`
--
ALTER TABLE `adjustment_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `count_stock`
--
ALTER TABLE `count_stock`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deposit_categories`
--
ALTER TABLE `deposit_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `draft_sales`
--
ALTER TABLE `draft_sales`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `draft_sale_details`
--
ALTER TABLE `draft_sale_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ecommerce_clients`
--
ALTER TABLE `ecommerce_clients`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_messages`
--
ALTER TABLE `email_messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_accounts`
--
ALTER TABLE `employee_accounts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_experiences`
--
ALTER TABLE `employee_experiences`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_categories`
--
ALTER TABLE `expense_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `office_shifts`
--
ALTER TABLE `office_shifts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_purchases`
--
ALTER TABLE `payment_purchases`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_purchase_returns`
--
ALTER TABLE `payment_purchase_returns`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_sales`
--
ALTER TABLE `payment_sales`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_sale_returns`
--
ALTER TABLE `payment_sale_returns`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_with_credit_card`
--
ALTER TABLE `payment_with_credit_card`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payrolls`
--
ALTER TABLE `payrolls`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `pos_settings`
--
ALTER TABLE `pos_settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_warehouse`
--
ALTER TABLE `product_warehouse`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=265;

--
-- AUTO_INCREMENT for table `providers`
--
ALTER TABLE `providers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_return_details`
--
ALTER TABLE `purchase_return_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quotation_details`
--
ALTER TABLE `quotation_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sale_details`
--
ALTER TABLE `sale_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sale_returns`
--
ALTER TABLE `sale_returns`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_return_details`
--
ALTER TABLE `sale_return_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `servers`
--
ALTER TABLE `servers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shipments`
--
ALTER TABLE `shipments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms_gateway`
--
ALTER TABLE `sms_gateway`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sms_messages`
--
ALTER TABLE `sms_messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `transfer_details`
--
ALTER TABLE `transfer_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `transfer_money`
--
ALTER TABLE `transfer_money`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adjustments`
--
ALTER TABLE `adjustments`
  ADD CONSTRAINT `warehouse_id_adjustment` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`);

--
-- Constraints for table `adjustment_details`
--
ALTER TABLE `adjustment_details`
  ADD CONSTRAINT `adjust_adjustment_id` FOREIGN KEY (`adjustment_id`) REFERENCES `adjustments` (`id`),
  ADD CONSTRAINT `adjust_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `adjust_product_variant` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`);

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_company_id` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  ADD CONSTRAINT `attendances_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `attendances_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `count_stock`
--
ALTER TABLE `count_stock`
  ADD CONSTRAINT `count_stock_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `count_stock_warehouse_id` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`);

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `department_company_id` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  ADD CONSTRAINT `department_department_head` FOREIGN KEY (`department_head`) REFERENCES `employees` (`id`);

--
-- Constraints for table `deposits`
--
ALTER TABLE `deposits`
  ADD CONSTRAINT `deposit_account_id` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `deposit_category_id` FOREIGN KEY (`deposit_category_id`) REFERENCES `deposit_categories` (`id`),
  ADD CONSTRAINT `deposit_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `designations`
--
ALTER TABLE `designations`
  ADD CONSTRAINT `designation_company_id` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  ADD CONSTRAINT `designation_departement_id` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `draft_sales`
--
ALTER TABLE `draft_sales`
  ADD CONSTRAINT `draft_sales_client_id` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `draft_sales_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `draft_sales_warehouse_id` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`);

--
-- Constraints for table `draft_sale_details`
--
ALTER TABLE `draft_sale_details`
  ADD CONSTRAINT `draft_sale_details_draft_sale_id` FOREIGN KEY (`draft_sale_id`) REFERENCES `draft_sales` (`id`),
  ADD CONSTRAINT `draft_sale_details_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `draft_sale_details_product_variant_id` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`),
  ADD CONSTRAINT `draft_sale_details_sale_unit_id` FOREIGN KEY (`sale_unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `ecommerce_clients`
--
ALTER TABLE `ecommerce_clients`
  ADD CONSTRAINT `ecommerce_clients_client_id` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`);

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_company_id` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  ADD CONSTRAINT `employees_department_id` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `employees_designation_id` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`),
  ADD CONSTRAINT `employees_office_shift_id` FOREIGN KEY (`office_shift_id`) REFERENCES `office_shifts` (`id`);

--
-- Constraints for table `employee_accounts`
--
ALTER TABLE `employee_accounts`
  ADD CONSTRAINT `employee_accounts_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `employee_experiences`
--
ALTER TABLE `employee_experiences`
  ADD CONSTRAINT `employee_experience_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expense_account_id` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `expense_category_id` FOREIGN KEY (`expense_category_id`) REFERENCES `expense_categories` (`id`),
  ADD CONSTRAINT `expense_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `expense_warehouse_id` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`);

--
-- Constraints for table `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD CONSTRAINT `expense_category_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `holidays`
--
ALTER TABLE `holidays`
  ADD CONSTRAINT `holidays_company_id` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);

--
-- Constraints for table `leaves`
--
ALTER TABLE `leaves`
  ADD CONSTRAINT `leave_company_id` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  ADD CONSTRAINT `leave_department_id` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `leave_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `leave_leave_type_id` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`);

--
-- Constraints for table `office_shifts`
--
ALTER TABLE `office_shifts`
  ADD CONSTRAINT `office_shift_company_id` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);

--
-- Constraints for table `payment_purchases`
--
ALTER TABLE `payment_purchases`
  ADD CONSTRAINT `factures_purchase_id` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`),
  ADD CONSTRAINT `payment_purchases_account_id` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `user_id_factures_achat` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `payment_purchase_returns`
--
ALTER TABLE `payment_purchase_returns`
  ADD CONSTRAINT `payment_purchase_returns_account_id` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `supplier_id_payment_return_purchase` FOREIGN KEY (`purchase_return_id`) REFERENCES `purchase_returns` (`id`),
  ADD CONSTRAINT `user_id_payment_return_purchase` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `payment_sales`
--
ALTER TABLE `payment_sales`
  ADD CONSTRAINT `facture_sale_id` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`),
  ADD CONSTRAINT `payment_sales_account_id` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `user_id_factures_ventes` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `payment_sale_returns`
--
ALTER TABLE `payment_sale_returns`
  ADD CONSTRAINT `factures_sale_return` FOREIGN KEY (`sale_return_id`) REFERENCES `sale_returns` (`id`),
  ADD CONSTRAINT `factures_sale_return_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `payment_sale_returns_account_id` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`);

--
-- Constraints for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD CONSTRAINT `payrolls_account_id` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `payrolls_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `payrolls_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`),
  ADD CONSTRAINT `permission_role_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `brand_id_products` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `unit_id_products` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`),
  ADD CONSTRAINT `unit_id_sales` FOREIGN KEY (`unit_sale_id`) REFERENCES `units` (`id`),
  ADD CONSTRAINT `unit_purchase_products` FOREIGN KEY (`unit_purchase_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_id_variant` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `product_warehouse`
--
ALTER TABLE `product_warehouse`
  ADD CONSTRAINT `art_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `mag_id` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`),
  ADD CONSTRAINT `product_variant_id` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`);

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `provider_id` FOREIGN KEY (`provider_id`) REFERENCES `providers` (`id`),
  ADD CONSTRAINT `warehouse_id_purchase` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`);

--
-- Constraints for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD CONSTRAINT `product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `purchase_id` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`),
  ADD CONSTRAINT `purchase_product_variant_id` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`),
  ADD CONSTRAINT `purchase_unit_id_purchase` FOREIGN KEY (`purchase_unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  ADD CONSTRAINT `provider_id_return` FOREIGN KEY (`provider_id`) REFERENCES `providers` (`id`),
  ADD CONSTRAINT `purchase_id_purchase_returns` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`),
  ADD CONSTRAINT `purchase_return_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `purchase_return_warehouse_id` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`);

--
-- Constraints for table `purchase_return_details`
--
ALTER TABLE `purchase_return_details`
  ADD CONSTRAINT `product_id_details_purchase_return` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `purchase_return_id_return` FOREIGN KEY (`purchase_return_id`) REFERENCES `purchase_returns` (`id`),
  ADD CONSTRAINT `purchase_return_product_variant_id` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`),
  ADD CONSTRAINT `unit_id_purchase_return_details` FOREIGN KEY (`purchase_unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `quotations`
--
ALTER TABLE `quotations`
  ADD CONSTRAINT `client_id _quotation` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `user_id_quotation` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `warehouse_id_quotation` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`);

--
-- Constraints for table `quotation_details`
--
ALTER TABLE `quotation_details`
  ADD CONSTRAINT `product_id_quotation_details` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `quotation_id` FOREIGN KEY (`quotation_id`) REFERENCES `quotations` (`id`),
  ADD CONSTRAINT `quote_product_variant_id` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`),
  ADD CONSTRAINT `sale_unit_id_quotation` FOREIGN KEY (`sale_unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `role_user_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sale_client_id` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `user_id_sales` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `warehouse_id_sale` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`);

--
-- Constraints for table `sale_details`
--
ALTER TABLE `sale_details`
  ADD CONSTRAINT `Details_Sale_id` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`),
  ADD CONSTRAINT `sale_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `sale_product_variant_id` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`),
  ADD CONSTRAINT `sales_sale_unit_id` FOREIGN KEY (`sale_unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `sale_returns`
--
ALTER TABLE `sale_returns`
  ADD CONSTRAINT `client_id_returns` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `sale_id_return_sales` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`),
  ADD CONSTRAINT `user_id_returns` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `warehouse_id_sale_return_id` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`);

--
-- Constraints for table `sale_return_details`
--
ALTER TABLE `sale_return_details`
  ADD CONSTRAINT `product_id_details_returns` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `sale_return_id` FOREIGN KEY (`sale_return_id`) REFERENCES `sale_returns` (`id`),
  ADD CONSTRAINT `sale_return_id_product_variant_id` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`),
  ADD CONSTRAINT `sale_unit_id_return_details` FOREIGN KEY (`sale_unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `currency_id` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  ADD CONSTRAINT `settings_client_id` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `settings_warehouse_id` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`);

--
-- Constraints for table `shipments`
--
ALTER TABLE `shipments`
  ADD CONSTRAINT `shipment_sale_id` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`),
  ADD CONSTRAINT `shipment_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `transfers`
--
ALTER TABLE `transfers`
  ADD CONSTRAINT `from_warehouse_id` FOREIGN KEY (`from_warehouse_id`) REFERENCES `warehouses` (`id`),
  ADD CONSTRAINT `to_warehouse_id` FOREIGN KEY (`to_warehouse_id`) REFERENCES `warehouses` (`id`);

--
-- Constraints for table `transfer_details`
--
ALTER TABLE `transfer_details`
  ADD CONSTRAINT `product_id_transfers` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `product_variant_id_transfer` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`),
  ADD CONSTRAINT `transfer_id` FOREIGN KEY (`transfer_id`) REFERENCES `transfers` (`id`),
  ADD CONSTRAINT `unit_sale_id_transfer` FOREIGN KEY (`purchase_unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `transfer_money`
--
ALTER TABLE `transfer_money`
  ADD CONSTRAINT `from_account_id` FOREIGN KEY (`from_account_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `to_account_id` FOREIGN KEY (`to_account_id`) REFERENCES `accounts` (`id`);

--
-- Constraints for table `units`
--
ALTER TABLE `units`
  ADD CONSTRAINT `base_unit` FOREIGN KEY (`base_unit`) REFERENCES `units` (`id`);

--
-- Constraints for table `user_warehouse`
--
ALTER TABLE `user_warehouse`
  ADD CONSTRAINT `user_warehouse_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_warehouse_warehouse_id` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
