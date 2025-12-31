-- phpMyAdmin SQL Dump
-- Core1 Database Schema
-- Generated for BPM-SYSTEM
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2025
-- Server version: 10.4.6-MariaDB
-- PHP Version: 8.2+

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `core1_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `patients_core1`
--

CREATE TABLE `patients_core1` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `emergency_contact_name` varchar(255) DEFAULT NULL,
  `emergency_contact_phone` varchar(255) DEFAULT NULL,
  `blood_type` varchar(255) DEFAULT NULL,
  `allergies` text DEFAULT NULL,
  `medical_history` text DEFAULT NULL,
  `status` enum('active','inactive','deceased') NOT NULL DEFAULT 'active',
  `last_visit` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_core1`
--

CREATE TABLE `users_core1` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','doctor','nurse','patient','receptionist','billing') NOT NULL DEFAULT 'patient',
  `employee_id` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','suspended') NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointments_core1`
--

CREATE TABLE `appointments_core1` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `appointment_id` varchar(255) DEFAULT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` datetime NOT NULL,
  `type` enum('consultation','follow-up','emergency','surgery','checkup') NOT NULL DEFAULT 'consultation',
  `status` enum('scheduled','confirmed','completed','cancelled','no-show') NOT NULL DEFAULT 'scheduled',
  `notes` text DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bills_core1`
--

CREATE TABLE `bills_core1` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bill_number` varchar(255) NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `bill_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `items` json DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','paid','partial','overdue','cancelled') NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medical_records_core1`
--

CREATE TABLE `medical_records_core1` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `record_type` enum('diagnosis','treatment','prescription','lab_result','xray','surgery','other') NOT NULL DEFAULT 'diagnosis',
  `diagnosis` text DEFAULT NULL,
  `treatment` text DEFAULT NULL,
  `prescription` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `record_date` datetime NOT NULL,
  `attachments` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `patients_core1`
--
ALTER TABLE `patients_core1`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patients_core1_patient_id_unique` (`patient_id`),
  ADD UNIQUE KEY `patients_core1_email_unique` (`email`);

--
-- Indexes for table `users_core1`
--
ALTER TABLE `users_core1`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_core1_email_unique` (`email`),
  ADD UNIQUE KEY `users_core1_employee_id_unique` (`employee_id`);

--
-- Indexes for table `appointments_core1`
--
ALTER TABLE `appointments_core1`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `appointments_core1_appointment_id_unique` (`appointment_id`),
  ADD KEY `appointments_core1_patient_id_foreign` (`patient_id`),
  ADD KEY `appointments_core1_doctor_id_foreign` (`doctor_id`);

--
-- Indexes for table `bills_core1`
--
ALTER TABLE `bills_core1`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bills_core1_bill_number_unique` (`bill_number`),
  ADD KEY `bills_core1_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `medical_records_core1`
--
ALTER TABLE `medical_records_core1`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medical_records_core1_patient_id_foreign` (`patient_id`),
  ADD KEY `medical_records_core1_doctor_id_foreign` (`doctor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `patients_core1`
--
ALTER TABLE `patients_core1`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_core1`
--
ALTER TABLE `users_core1`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointments_core1`
--
ALTER TABLE `appointments_core1`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bills_core1`
--
ALTER TABLE `bills_core1`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medical_records_core1`
--
ALTER TABLE `medical_records_core1`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments_core1`
--
ALTER TABLE `appointments_core1`
  ADD CONSTRAINT `appointments_core1_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients_core1` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_core1_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `users_core1` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `bills_core1`
--
ALTER TABLE `bills_core1`
  ADD CONSTRAINT `bills_core1_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients_core1` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `medical_records_core1`
--
ALTER TABLE `medical_records_core1`
  ADD CONSTRAINT `medical_records_core1_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients_core1` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `medical_records_core1_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `users_core1` (`id`) ON DELETE SET NULL;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

