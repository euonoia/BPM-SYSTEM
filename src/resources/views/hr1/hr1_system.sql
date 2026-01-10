-- ============================================================================
-- HR1 System Database SQL
-- Complete database schema and sample data for HR1 system
-- ============================================================================

-- Drop existing tables if they exist (in reverse order of dependencies)
DROP TABLE IF EXISTS `user_learning_modules_hr1`;
DROP TABLE IF EXISTS `learning_modules_hr1`;
DROP TABLE IF EXISTS `applications_hr1`;
DROP TABLE IF EXISTS `onboarding_tasks_hr1`;
DROP TABLE IF EXISTS `evaluation_criteria_hr1`;
DROP TABLE IF EXISTS `award_categories_hr1`;
DROP TABLE IF EXISTS `recognitions_hr1`;
DROP TABLE IF EXISTS `job_postings_hr1`;
DROP TABLE IF EXISTS `users_hr1`;

-- ============================================================================
-- TABLE: users_hr1
-- ============================================================================
CREATE TABLE `users_hr1` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `role` enum('admin','staff','candidate') NOT NULL DEFAULT 'candidate',
  `position` varchar(255) DEFAULT NULL,
  `status` enum('Applied','Evaluation','Interviewing','Offer','Onboarding','Rejected') DEFAULT 'Applied',
  `applied_date` date DEFAULT NULL,
  `score` int(11) NOT NULL DEFAULT 0,
  `skills` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_hr1_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: job_postings_hr1
-- ============================================================================
CREATE TABLE `job_postings_hr1` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `type` enum('Full-time','Part-time','Contract') NOT NULL,
  `status` enum('Open','Closed') NOT NULL DEFAULT 'Open',
  `posted_date` date NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: applications_hr1
-- ============================================================================
CREATE TABLE `applications_hr1` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `job_posting_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('Applied','Evaluation','Interviewing','Offer','Onboarding','Rejected') NOT NULL DEFAULT 'Applied',
  `applied_date` date NOT NULL,
  `interview_date` datetime DEFAULT NULL,
  `interview_location` varchar(255) DEFAULT NULL,
  `interview_description` text DEFAULT NULL,
  `documents` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `applications_hr1_user_id_foreign` (`user_id`),
  KEY `applications_hr1_job_posting_id_foreign` (`job_posting_id`),
  CONSTRAINT `applications_hr1_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users_hr1` (`id`) ON DELETE CASCADE,
  CONSTRAINT `applications_hr1_job_posting_id_foreign` FOREIGN KEY (`job_posting_id`) REFERENCES `job_postings_hr1` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: recognitions_hr1
-- ============================================================================
CREATE TABLE `recognitions_hr1` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `from` varchar(255) NOT NULL,
  `to` varchar(255) NOT NULL,
  `reason` text NOT NULL,
  `award_type` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `congratulations` int(11) NOT NULL DEFAULT 0,
  `boosts` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: onboarding_tasks_hr1
-- ============================================================================
CREATE TABLE `onboarding_tasks_hr1` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `category` enum('Pre-onboarding','Orientation','IT Setup','Training') NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `assigned_to` enum('admin','staff','candidate') NOT NULL DEFAULT 'candidate',
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `required_for_phase` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `onboarding_tasks_hr1_user_id_foreign` (`user_id`),
  CONSTRAINT `onboarding_tasks_hr1_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users_hr1` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: learning_modules_hr1
-- ============================================================================
CREATE TABLE `learning_modules_hr1` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: user_learning_modules_hr1
-- ============================================================================
CREATE TABLE `user_learning_modules_hr1` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `learning_module_id` bigint(20) UNSIGNED NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_learning_modules_hr1_user_id_foreign` (`user_id`),
  KEY `user_learning_modules_hr1_learning_module_id_foreign` (`learning_module_id`),
  CONSTRAINT `user_learning_modules_hr1_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users_hr1` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_learning_modules_hr1_learning_module_id_foreign` FOREIGN KEY (`learning_module_id`) REFERENCES `learning_modules_hr1` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: evaluation_criteria_hr1
-- ============================================================================
CREATE TABLE `evaluation_criteria_hr1` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `section` enum('A','B','C') NOT NULL,
  `weight` int(11) NOT NULL DEFAULT 10,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: award_categories_hr1
-- ============================================================================
CREATE TABLE `award_categories_hr1` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- SAMPLE DATA: Users (for login)
-- ============================================================================
-- Password for all users: "password123"
-- Hash: $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi

INSERT INTO `users_hr1` (`id`, `name`, `email`, `password`, `phone`, `role`, `position`, `status`, `applied_date`, `score`, `skills`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@medcore.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '555-0100', 'admin', 'System Administrator', NULL, NULL, 0, NULL, NOW(), NOW()),
(2, 'HR Staff', 'staff@medcore.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '555-0200', 'staff', 'HR Manager', NULL, NULL, 0, NULL, NOW(), NOW()),
(3, 'John Doe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '555-0300', 'candidate', 'Senior Nurse', 'Applied', CURDATE() - INTERVAL 10 DAY, 85, 'Critical Care, ACLS', NOW(), NOW()),
(4, 'Jane Smith', 'jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '555-0400', 'candidate', 'Radiologist', 'Evaluation', CURDATE() - INTERVAL 5 DAY, 92, 'MRI, CT Scanning', NOW(), NOW()),
(5, 'Mike Johnson', 'mike@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '555-0500', 'candidate', 'ER Physician', 'Interviewing', CURDATE() - INTERVAL 3 DAY, 88, 'Emergency Medicine, Trauma Care', NOW(), NOW());

-- ============================================================================
-- SAMPLE DATA: Job Postings
-- ============================================================================
INSERT INTO `job_postings_hr1` (`id`, `title`, `department`, `location`, `type`, `status`, `posted_date`, `description`, `created_at`, `updated_at`) VALUES
(1, 'ER Physician', 'Emergency', 'Main Hospital', 'Full-time', 'Open', CURDATE() - INTERVAL 20 DAY, 'Emergency Room Physician position requiring board certification in Emergency Medicine. Must have ACLS and ATLS certifications.', NOW(), NOW()),
(2, 'Pediatric Nurse', 'Pediatrics', 'Wing A', 'Full-time', 'Open', CURDATE() - INTERVAL 8 DAY, 'Pediatric nursing position requiring BSN and pediatric nursing certification. Experience with pediatric critical care preferred.', NOW(), NOW()),
(3, 'Lab Technician', 'Diagnostics', 'South Wing', 'Part-time', 'Open', CURDATE() - INTERVAL 2 DAY, 'Laboratory technician position requiring MLT certification. Experience with automated lab equipment required.', NOW(), NOW()),
(4, 'Radiologist', 'Radiology', 'Main Hospital', 'Full-time', 'Open', CURDATE() - INTERVAL 15 DAY, 'Board-certified radiologist position. Must have experience with MRI, CT, and ultrasound imaging.', NOW(), NOW());

-- ============================================================================
-- SAMPLE DATA: Applications
-- ============================================================================
INSERT INTO `applications_hr1` (`id`, `user_id`, `job_posting_id`, `status`, `applied_date`, `interview_date`, `interview_location`, `interview_description`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'Applied', CURDATE() - INTERVAL 10 DAY, NULL, NULL, NULL, NOW(), NOW()),
(2, 4, 2, 'Evaluation', CURDATE() - INTERVAL 5 DAY, NULL, NULL, NULL, NOW(), NOW()),
(3, 5, 1, 'Interviewing', CURDATE() - INTERVAL 3 DAY, CURDATE() + INTERVAL 5 DAY, 'Main Hospital - Conference Room A', 'Initial screening interview', NOW(), NOW());

-- ============================================================================
-- SAMPLE DATA: Recognitions
-- ============================================================================
INSERT INTO `recognitions_hr1` (`id`, `from`, `to`, `reason`, `award_type`, `date`, `congratulations`, `boosts`, `created_at`, `updated_at`) VALUES
(1, 'Dr. Gregory', 'Nurse Sarah', 'Exceptional patient care during emergency situation.', 'Gold Star', CURDATE() - INTERVAL 12 DAY, 12, 5, NOW(), NOW()),
(2, 'HR Dept', 'Dr. Wilson', '10 years of service excellence and dedication.', 'Service Award', CURDATE() - INTERVAL 11 DAY, 45, 8, NOW(), NOW()),
(3, 'Dr. Martinez', 'Nurse Johnson', 'Outstanding teamwork during critical surgery.', 'Team Excellence', CURDATE() - INTERVAL 5 DAY, 23, 12, NOW(), NOW());

-- ============================================================================
-- SAMPLE DATA: Onboarding Tasks
-- ============================================================================
INSERT INTO `onboarding_tasks_hr1` (`id`, `title`, `department`, `category`, `completed`, `assigned_to`, `user_id`, `required_for_phase`, `created_at`, `updated_at`) VALUES
(1, 'Upload ID Documentation', 'Emergency', 'Pre-onboarding', 1, 'candidate', 3, 1, NOW(), NOW()),
(2, 'Health Safety E-Learning', 'Pediatrics', 'Training', 0, 'staff', 4, 2, NOW(), NOW()),
(3, 'Verify Medical License', 'Emergency', 'Pre-onboarding', 0, 'admin', NULL, 1, NOW(), NOW()),
(4, 'IT Account Setup', 'IT', 'IT Setup', 0, 'admin', 5, 1, NOW(), NOW()),
(5, 'Orientation Session', 'HR', 'Orientation', 0, 'staff', 3, 2, NOW(), NOW());

-- ============================================================================
-- SAMPLE DATA: Learning Modules
-- ============================================================================
INSERT INTO `learning_modules_hr1` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Basic Clinical Hygiene', NOW(), NOW()),
(2, 'EHR Mastery v2', NOW(), NOW()),
(3, 'Patient Ethics 101', NOW(), NOW()),
(4, 'Emergency Protocols', NOW(), NOW()),
(5, 'HIPAA Compliance Training', NOW(), NOW());

-- ============================================================================
-- SAMPLE DATA: User Learning Modules (Assignments)
-- ============================================================================
INSERT INTO `user_learning_modules_hr1` (`id`, `user_id`, `learning_module_id`, `completed`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 1, NOW(), NOW()),
(2, 3, 2, 0, NOW(), NOW()),
(3, 4, 3, 1, NOW(), NOW()),
(4, 4, 4, 0, NOW(), NOW()),
(5, 5, 1, 0, NOW(), NOW());

-- ============================================================================
-- SAMPLE DATA: Evaluation Criteria
-- ============================================================================
INSERT INTO `evaluation_criteria_hr1` (`id`, `label`, `section`, `weight`, `created_at`, `updated_at`) VALUES
(1, 'Clinical Precision', 'A', 40, NOW(), NOW()),
(2, 'Patient Empathy', 'B', 30, NOW(), NOW()),
(3, 'Team Collaboration', 'C', 20, NOW(), NOW()),
(4, 'Communication Skills', 'A', 25, NOW(), NOW()),
(5, 'Problem Solving', 'B', 35, NOW(), NOW());

-- ============================================================================
-- SAMPLE DATA: Award Categories
-- ============================================================================
INSERT INTO `award_categories_hr1` (`id`, `name`, `icon`, `created_at`, `updated_at`) VALUES
(1, 'Patient Choice', '🌟', NOW(), NOW()),
(2, 'Clinical Speed', '⚡', NOW(), NOW()),
(3, 'Team Support', '🤝', NOW(), NOW()),
(4, 'Innovation', '💡', NOW(), NOW()),
(5, 'Excellence', '⭐', NOW(), NOW());

-- ============================================================================
-- LOGIN CREDENTIALS SUMMARY
-- ============================================================================
-- Admin:
--   Email: admin@medcore.com
--   Password: password123
--
-- Staff:
--   Email: staff@medcore.com
--   Password: password123
--
-- Candidates:
--   Email: john@example.com
--   Password: password123
--
--   Email: jane@example.com
--   Password: password123
--
--   Email: mike@example.com
--   Password: password123
-- ============================================================================

