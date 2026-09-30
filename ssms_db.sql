-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2026 at 04:20 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ssms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_years`
--

CREATE TABLE `academic_years` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `year_label` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'Upcoming',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_code` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `scholarship_id` bigint(20) UNSIGNED NOT NULL,
  `officer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `registrar_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `remarks` text DEFAULT NULL,
  `registrar_remarks` text DEFAULT NULL,
  `admin_remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `application_code`, `user_id`, `scholarship_id`, `officer_id`, `registrar_id`, `status`, `remarks`, `registrar_remarks`, `admin_remarks`, `created_at`, `updated_at`) VALUES
(1, 'APP-MOIOM2KS', 3, 1, NULL, 5, 'Approved', NULL, 'asda', 'nice', '2026-09-30 06:05:50', '2026-09-30 06:12:23');

-- --------------------------------------------------------

--
-- Table structure for table `application_documents`
--

CREATE TABLE `application_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_id` bigint(20) UNSIGNED NOT NULL,
  `document_requirement_id` bigint(20) UNSIGNED NOT NULL,
  `student_file_path` varchar(255) DEFAULT NULL,
  `student_original_name` varchar(255) DEFAULT NULL,
  `student_uploaded_at` timestamp NULL DEFAULT NULL,
  `registrar_file_path` varchar(255) DEFAULT NULL,
  `registrar_original_name` varchar(255) DEFAULT NULL,
  `registrar_uploaded_at` timestamp NULL DEFAULT NULL,
  `registrar_uploader_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_complete` tinyint(1) NOT NULL DEFAULT 0,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `application_documents`
--

INSERT INTO `application_documents` (`id`, `application_id`, `document_requirement_id`, `student_file_path`, `student_original_name`, `student_uploaded_at`, `registrar_file_path`, `registrar_original_name`, `registrar_uploaded_at`, `registrar_uploader_id`, `is_complete`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'applications/1/assessment-form_CUrPPO.png', '1becca53-403f-424b-b101-d2e928f2de0a.png', '2026-09-30 06:05:50', NULL, NULL, NULL, NULL, 1, NULL, '2026-09-30 06:05:50', '2026-09-30 06:05:50'),
(2, 1, 2, 'applications/1/grade-slip_GRlEYq.jpg', '25b261fe-5d4a-4b1d-b9e6-9e0d763dcd3d.jpg', '2026-09-30 06:05:50', NULL, NULL, NULL, NULL, 1, NULL, '2026-09-30 06:05:50', '2026-09-30 06:05:50'),
(3, 1, 3, 'applications/1/prospectus_pijkqK.png', '39312899-b54e-4c81-ae7f-c70c290cca90.png', '2026-09-30 06:05:50', NULL, NULL, NULL, NULL, 1, NULL, '2026-09-30 06:05:50', '2026-09-30 06:05:50'),
(4, 1, 4, 'applications/1/certificate-of-non-availment_Uk3P6w.jpg', '723118627_1554484462751389_3330810324638797362_n.jpg', '2026-09-30 06:05:50', NULL, NULL, NULL, NULL, 1, NULL, '2026-09-30 06:05:50', '2026-09-30 06:05:50');

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 1, 'Created Scholarship Admin', 'Ched Scholarship assigned to \"Ched Scholarship\"', '127.0.0.1', '2026-09-30 06:01:07', '2026-09-30 06:01:07'),
(2, 1, 'Created Scholarship', 'Ched Scholarship (via Super Admin)', '127.0.0.1', '2026-09-30 06:01:07', '2026-09-30 06:01:07'),
(3, 5, 'Registrar Endorse', 'Application #1 for Joshua Atis — Remarks: asda', '127.0.0.1', '2026-09-30 06:07:02', '2026-09-30 06:07:02'),
(4, 4, 'Application Approved', 'Approved application #1 for Joshua Atis — Remarks: nice', '127.0.0.1', '2026-09-30 06:12:23', '2026-09-30 06:12:23');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_requirements`
--

CREATE TABLE `document_requirements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `copy_type` varchar(255) NOT NULL DEFAULT 'Original Copy',
  `is_required` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `document_requirements`
--

INSERT INTO `document_requirements` (`id`, `name`, `description`, `copy_type`, `is_required`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Assessment Form', 'Original Copy w/ Signature', 'Original Copy', 1, 1, 1, '2026-09-05 07:54:52', '2026-09-05 07:54:52'),
(2, 'Grade Slip', 'Original Copy w/ GWA', 'Original Copy', 1, 2, 1, '2026-09-05 07:54:52', '2026-09-05 07:54:52'),
(3, 'Prospectus', 'Photocopy of the approved/official prospectus', 'Photocopy', 1, 3, 1, '2026-09-05 07:54:52', '2026-09-05 07:54:52'),
(4, 'Certificate of Non-availment', 'Certificate stating non-availment of other scholarship benefits', 'Original Copy', 1, 4, 1, '2026-09-05 07:54:52', '2026-09-05 07:54:52');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_07_15_131334_add_student_fields_to_users_table', 1),
(5, '2026_07_16_001808_create_scholarships_table', 1),
(6, '2026_07_16_102131_create_applications_table', 1),
(7, '2026_07_16_103552_create_notifications_table', 1),
(8, '2026_07_18_124454_add_scholarship_admin_fields_to_users_table', 1),
(9, '2026_07_19_090000_add_program_fields_to_scholarships_table', 1),
(10, '2026_07_19_090100_create_announcements_table', 1),
(11, '2026_07_20_100000_create_academic_years_table', 1),
(12, '2026_07_20_100100_create_audit_logs_table', 1),
(13, '2026_08_04_000000_add_username_to_users_table', 1),
(14, '2026_08_17_051332_add_scholarship_id_to_users_table', 1),
(15, '2026_08_31_000000_add_registrar_fields_to_applications_table', 1),
(16, '2026_08_31_010000_create_document_requirements_table', 1),
(17, '2026_08_31_010100_create_application_documents_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'info',
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `title`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 3, 'application_submitted', 'Application submitted', 'Your application for \"Ched Scholarship\" has been submitted with all required documents. It is now awaiting the registrar\'s review.', 1, '2026-09-30 06:05:50', '2026-09-30 06:13:15'),
(2, 3, 'application_registrar', 'Registrar endorsed your application', 'Your application for \"Ched Scholarship\" has been endorsed by the registrar and is now awaiting the scholarship admin\'s final decision.', 1, '2026-09-30 06:07:01', '2026-09-30 06:13:15'),
(3, 3, 'application_admin', 'Congratulations — your scholarship was approved!', 'Your application for \"Ched Scholarship\" was approved by the scholarship office. You are now officially a scholar.', 1, '2026-09-30 06:12:23', '2026-09-30 06:13:15');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `scholarships`
--

CREATE TABLE `scholarships` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `provider` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `benefits` varchar(255) NOT NULL,
  `eligibility` text DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `slots_total` int(11) NOT NULL,
  `slots_left` int(11) NOT NULL,
  `min_gpa` decimal(5,2) NOT NULL,
  `deadline` date NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Open',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `scholarships`
--

INSERT INTO `scholarships` (`id`, `title`, `description`, `provider`, `type`, `benefits`, `eligibility`, `requirements`, `slots_total`, `slots_left`, `min_gpa`, `deadline`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Ched Scholarship', 'w', 'Higher Education', 'General', 'w', 'w', 'w', 100, 99, 0.00, '2026-10-12', 'Open', 1, '2026-09-30 06:01:07', '2026-09-30 06:05:50');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('8IRXE9MKL5Fvq248JNzwUHbBj0z9ZT3hp1eVtUGa', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNjg3TFYwdUMydlVjOHJMeThvbmFMZlF1eTA1R3hxc1NkQ2tGb1czMCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zY2hvbGFyc2hpcGFkbWluL3JlcG9ydHMvZXhwb3J0IjtzOjU6InJvdXRlIjtzOjMxOiJzY2hvbGFyc2hpcGFkbWluLnJlcG9ydHMuZXhwb3J0Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDt9', 1790777941),
('YqXqedF0bbWp1xC00kQkaP7qs7006K1l6CCHCq32', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.139.1 Chrome/150.0.7871.250 Electron/43.6.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiblpKUWhONkRUMlpQakNqM0xlVld5Z0ZUVWQyQ0loemlHVlFTZG8yWiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zY2hvbGFyc2hpcGFkbWluL3N0dWRlbnRzIjtzOjU6InJvdXRlIjtzOjI1OiJzY2hvbGFyc2hpcGFkbWluLnN0dWRlbnRzIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDt9', 1790777566);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `school` varchar(255) DEFAULT NULL,
  `student_number` varchar(255) DEFAULT NULL,
  `course` varchar(255) DEFAULT NULL,
  `gpa` decimal(3,2) DEFAULT NULL,
  `year_level` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'student',
  `scholarship_id` bigint(20) UNSIGNED DEFAULT NULL,
  `scholarship_name` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `dob`, `phone`, `school`, `student_number`, `course`, `gpa`, `year_level`, `name`, `email`, `username`, `email_verified_at`, `password`, `role`, `scholarship_id`, `scholarship_name`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super', 'Admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Super Admin', 'admin@scholarhub.com', NULL, NULL, '$2y$12$ETf5vE58Wp3TNnhy.Xl4sO9nXnpXquKMEo.lPIvV7wgsMCJRY0pcO', 'superadmin', NULL, NULL, 'Active', NULL, '2026-09-05 07:54:52', '2026-09-05 07:54:52'),
(2, 'registrar', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 'ckcregistrar@ckcgingoog.edu.ph', 'ckcregistrar', NULL, 'password', 'registrar', NULL, NULL, 'Active', NULL, NULL, NULL),
(3, 'Joshua', 'Atis', '2005-09-17', '09924895282', NULL, 'C23-0033', 'BSIT', NULL, '4th Year', 'Joshua Atis', 'jatis@ckcgingoog.edu.ph', NULL, NULL, '$2y$12$P8Tl1UOUdeQKj8uL4cRgpO26Mw90AwACVg6/oqqtitqSGfD0ER.mG', 'student', NULL, NULL, 'Active', NULL, '2026-09-30 05:58:15', '2026-09-30 05:58:15'),
(4, 'Ched', 'Scholarship', NULL, '09123456789', NULL, NULL, NULL, NULL, NULL, 'Ched Scholarship', 'ched@gmail.com', 'ched_admin', NULL, '$2y$12$KAU8dXBYRcJr7OcllHN7DeehFmdyAbeuiGnmntUWFJmZ0a6AUpJMu', 'Scholarship Admin', 1, 'Ched Scholarship', 'Active', NULL, '2026-09-30 06:01:07', '2026-09-30 06:01:07'),
(5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Registrar', 'registrar@scholarhub.com', NULL, NULL, '$2y$12$vUvierpnDmx3dsbU8Eyt7.xTliCj5F4CSCglPX5p5a2wD6wVRHv9S', 'registrar', NULL, NULL, 'Active', NULL, '2026-09-30 06:03:59', '2026-09-30 06:03:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_years`
--
ALTER TABLE `academic_years`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcements_created_by_foreign` (`created_by`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applications_user_id_foreign` (`user_id`),
  ADD KEY `applications_scholarship_id_foreign` (`scholarship_id`),
  ADD KEY `applications_officer_id_foreign` (`officer_id`),
  ADD KEY `applications_registrar_id_foreign` (`registrar_id`);

--
-- Indexes for table `application_documents`
--
ALTER TABLE `application_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_documents_application_id_foreign` (`application_id`),
  ADD KEY `application_documents_document_requirement_id_foreign` (`document_requirement_id`),
  ADD KEY `application_documents_registrar_uploader_id_foreign` (`registrar_uploader_id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `document_requirements`
--
ALTER TABLE `document_requirements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `scholarships`
--
ALTER TABLE `scholarships`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scholarships_created_by_foreign` (`created_by`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_scholarship_id_foreign` (`scholarship_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_years`
--
ALTER TABLE `academic_years`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `application_documents`
--
ALTER TABLE `application_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `document_requirements`
--
ALTER TABLE `document_requirements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `scholarships`
--
ALTER TABLE `scholarships`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_officer_id_foreign` FOREIGN KEY (`officer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `applications_registrar_id_foreign` FOREIGN KEY (`registrar_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `applications_scholarship_id_foreign` FOREIGN KEY (`scholarship_id`) REFERENCES `scholarships` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `applications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `application_documents`
--
ALTER TABLE `application_documents`
  ADD CONSTRAINT `application_documents_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `application_documents_document_requirement_id_foreign` FOREIGN KEY (`document_requirement_id`) REFERENCES `document_requirements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `application_documents_registrar_uploader_id_foreign` FOREIGN KEY (`registrar_uploader_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `scholarships`
--
ALTER TABLE `scholarships`
  ADD CONSTRAINT `scholarships_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_scholarship_id_foreign` FOREIGN KEY (`scholarship_id`) REFERENCES `scholarships` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
