-- =====================================================
-- HR1 System Database Schema
-- Concord HR1 Module - Complete Database Structure
-- =====================================================

-- =====================================================
-- 1. USERS & AUTHENTICATION
-- =====================================================

-- Admin Users Table
CREATE TABLE IF NOT EXISTS `users_hr1` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('admin', 'staff', 'candidate') NOT NULL DEFAULT 'candidate',
    `contact_no` VARCHAR(20) NULL,
    `date_of_employment` DATE NULL,
    `status` ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    `remember_token` VARCHAR(100) NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_email` (`email`),
    INDEX `idx_role` (`role`),
    INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 2. APPLICANTS MANAGEMENT
-- =====================================================

-- Applicants Table
CREATE TABLE IF NOT EXISTS `applicants_hr1` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NULL,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NULL,
    `position` VARCHAR(255) NULL,
    `contact_no` VARCHAR(20) NULL,
    `status` ENUM('applied', 'evaluating', 'interviewing', 'offered', 'onboard', 'rejected') NOT NULL DEFAULT 'applied',
    `notes` TEXT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_email` (`email`),
    INDEX `idx_status` (`status`),
    INDEX `idx_user_id` (`user_id`),
    FOREIGN KEY (`user_id`) REFERENCES `users_hr1`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 3. RECRUITMENT / JOB POSTINGS
-- =====================================================

-- Jobs Table
CREATE TABLE IF NOT EXISTS `jobs_hr1` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `department` VARCHAR(255) NOT NULL,
    `type` ENUM('Full-time', 'Part-time', 'Contract', 'Internship') NOT NULL DEFAULT 'Full-time',
    `description` TEXT NULL,
    `requirements` TEXT NULL,
    `salary_range` VARCHAR(100) NULL,
    `location` VARCHAR(255) NULL,
    `status` ENUM('active', 'closed', 'draft') NOT NULL DEFAULT 'active',
    `posted_by` BIGINT UNSIGNED NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_status` (`status`),
    INDEX `idx_department` (`department`),
    INDEX `idx_posted_by` (`posted_by`),
    FOREIGN KEY (`posted_by`) REFERENCES `users_hr1`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Job Applications Table
CREATE TABLE IF NOT EXISTS `job_applications_hr1` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `job_id` BIGINT UNSIGNED NOT NULL,
    `applicant_id` BIGINT UNSIGNED NOT NULL,
    `status` ENUM('applied', 'reviewing', 'shortlisted', 'interviewed', 'offered', 'rejected', 'accepted') NOT NULL DEFAULT 'applied',
    `cover_letter` TEXT NULL,
    `applied_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `reviewed_at` TIMESTAMP NULL,
    `interviewed_at` TIMESTAMP NULL,
    `notes` TEXT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_job_id` (`job_id`),
    INDEX `idx_applicant_id` (`applicant_id`),
    INDEX `idx_status` (`status`),
    UNIQUE KEY `unique_job_applicant` (`job_id`, `applicant_id`),
    FOREIGN KEY (`job_id`) REFERENCES `jobs_hr1`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`applicant_id`) REFERENCES `applicants_hr1`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Application Documents Table
CREATE TABLE IF NOT EXISTS `application_documents_hr1` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `application_id` BIGINT UNSIGNED NOT NULL,
    `document_type` ENUM('cv', 'resume', 'license', 'id', 'certificate', 'other') NOT NULL,
    `file_name` VARCHAR(255) NOT NULL,
    `file_path` VARCHAR(500) NOT NULL,
    `file_size` BIGINT UNSIGNED NULL,
    `mime_type` VARCHAR(100) NULL,
    `uploaded_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_application_id` (`application_id`),
    FOREIGN KEY (`application_id`) REFERENCES `job_applications_hr1`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 4. ONBOARDING & TASKS
-- =====================================================

-- Task Sets Table (Collections of tasks/requirements)
CREATE TABLE IF NOT EXISTS `task_sets_hr1` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `created_by` BIGINT UNSIGNED NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_created_by` (`created_by`),
    FOREIGN KEY (`created_by`) REFERENCES `users_hr1`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tasks Table (Individual requirements/tasks)
CREATE TABLE IF NOT EXISTS `tasks_hr1` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `task_set_id` BIGINT UNSIGNED NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `category` VARCHAR(100) NULL,
    `department` VARCHAR(255) NULL,
    `is_required` BOOLEAN NOT NULL DEFAULT TRUE,
    `order` INT UNSIGNED NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_task_set_id` (`task_set_id`),
    INDEX `idx_category` (`category`),
    FOREIGN KEY (`task_set_id`) REFERENCES `task_sets_hr1`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Job Task Sets Assignment (Which task sets are required for which jobs)
CREATE TABLE IF NOT EXISTS `job_task_sets_hr1` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `job_id` BIGINT UNSIGNED NOT NULL,
    `task_set_id` BIGINT UNSIGNED NOT NULL,
    `is_required` BOOLEAN NOT NULL DEFAULT TRUE,
    `assigned_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `assigned_by` BIGINT UNSIGNED NULL,
    INDEX `idx_job_id` (`job_id`),
    INDEX `idx_task_set_id` (`task_set_id`),
    UNIQUE KEY `unique_job_task_set` (`job_id`, `task_set_id`),
    FOREIGN KEY (`job_id`) REFERENCES `jobs_hr1`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`task_set_id`) REFERENCES `task_sets_hr1`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`assigned_by`) REFERENCES `users_hr1`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Applicant Task Completion Tracking
CREATE TABLE IF NOT EXISTS `applicant_tasks_hr1` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `applicant_id` BIGINT UNSIGNED NOT NULL,
    `task_id` BIGINT UNSIGNED NOT NULL,
    `job_id` BIGINT UNSIGNED NULL,
    `completed` BOOLEAN NOT NULL DEFAULT FALSE,
    `completed_at` TIMESTAMP NULL,
    `submitted_document` VARCHAR(500) NULL,
    `notes` TEXT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_applicant_id` (`applicant_id`),
    INDEX `idx_task_id` (`task_id`),
    INDEX `idx_job_id` (`job_id`),
    INDEX `idx_completed` (`completed`),
    UNIQUE KEY `unique_applicant_task` (`applicant_id`, `task_id`, `job_id`),
    FOREIGN KEY (`applicant_id`) REFERENCES `applicants_hr1`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`task_id`) REFERENCES `tasks_hr1`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`job_id`) REFERENCES `jobs_hr1`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 5. PERFORMANCE & ASSESSMENT
-- =====================================================

-- Question Sets / Forms Table
CREATE TABLE IF NOT EXISTS `question_sets_hr1` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `type` ENUM('assessment', 'evaluation', 'survey', 'interview') NOT NULL DEFAULT 'assessment',
    `is_active` BOOLEAN NOT NULL DEFAULT TRUE,
    `created_by` BIGINT UNSIGNED NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_type` (`type`),
    INDEX `idx_is_active` (`is_active`),
    INDEX `idx_created_by` (`created_by`),
    FOREIGN KEY (`created_by`) REFERENCES `users_hr1`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Questions Table
CREATE TABLE IF NOT EXISTS `questions_hr1` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `question_set_id` BIGINT UNSIGNED NOT NULL,
    `question_text` TEXT NOT NULL,
    `question_type` ENUM('text', 'multiple-choice', 'rating', 'yes-no', 'file-upload') NOT NULL DEFAULT 'text',
    `options` JSON NULL COMMENT 'For multiple-choice questions',
    `is_required` BOOLEAN NOT NULL DEFAULT TRUE,
    `order` INT UNSIGNED NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_question_set_id` (`question_set_id`),
    INDEX `idx_question_type` (`question_type`),
    FOREIGN KEY (`question_set_id`) REFERENCES `question_sets_hr1`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Applicant Answers / Responses
CREATE TABLE IF NOT EXISTS `applicant_responses_hr1` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `applicant_id` BIGINT UNSIGNED NOT NULL,
    `question_id` BIGINT UNSIGNED NOT NULL,
    `question_set_id` BIGINT UNSIGNED NOT NULL,
    `response_text` TEXT NULL,
    `response_value` VARCHAR(255) NULL,
    `response_file` VARCHAR(500) NULL,
    `submitted_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_applicant_id` (`applicant_id`),
    INDEX `idx_question_id` (`question_id`),
    INDEX `idx_question_set_id` (`question_set_id`),
    UNIQUE KEY `unique_applicant_question` (`applicant_id`, `question_id`),
    FOREIGN KEY (`applicant_id`) REFERENCES `applicants_hr1`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`question_id`) REFERENCES `questions_hr1`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`question_set_id`) REFERENCES `question_sets_hr1`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 6. RECOGNITION & CULTURE
-- =====================================================

-- Recognitions Table
CREATE TABLE IF NOT EXISTS `recognitions_hr1` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `candidate_id` BIGINT UNSIGNED NULL,
    `candidate_name` VARCHAR(255) NOT NULL,
    `position` VARCHAR(255) NULL,
    `description` TEXT NULL,
    `is_most_outstanding` BOOLEAN NOT NULL DEFAULT FALSE,
    `recognition_date` DATE NULL,
    `award_category` VARCHAR(255) NULL,
    `posted_by` BIGINT UNSIGNED NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_candidate_id` (`candidate_id`),
    INDEX `idx_is_most_outstanding` (`is_most_outstanding`),
    INDEX `idx_posted_by` (`posted_by`),
    FOREIGN KEY (`candidate_id`) REFERENCES `applicants_hr1`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`posted_by`) REFERENCES `users_hr1`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Award Categories Table
CREATE TABLE IF NOT EXISTS `award_categories_hr1` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `icon` VARCHAR(100) NULL,
    `color` VARCHAR(50) NULL,
    `is_active` BOOLEAN NOT NULL DEFAULT TRUE,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 7. EVALUATION CRITERIA
-- =====================================================

-- Evaluation Criteria Table
CREATE TABLE IF NOT EXISTS `evaluation_criteria_hr1` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `category` VARCHAR(100) NULL,
    `weight` DECIMAL(5,2) NULL COMMENT 'Weight for scoring (0-100)',
    `is_active` BOOLEAN NOT NULL DEFAULT TRUE,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Applicant Evaluations
CREATE TABLE IF NOT EXISTS `applicant_evaluations_hr1` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `applicant_id` BIGINT UNSIGNED NOT NULL,
    `criteria_id` BIGINT UNSIGNED NOT NULL,
    `score` DECIMAL(5,2) NULL COMMENT 'Score out of 100',
    `evaluator_id` BIGINT UNSIGNED NULL,
    `comments` TEXT NULL,
    `evaluated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_applicant_id` (`applicant_id`),
    INDEX `idx_criteria_id` (`criteria_id`),
    INDEX `idx_evaluator_id` (`evaluator_id`),
    UNIQUE KEY `unique_applicant_criteria` (`applicant_id`, `criteria_id`),
    FOREIGN KEY (`applicant_id`) REFERENCES `applicants_hr1`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`criteria_id`) REFERENCES `evaluation_criteria_hr1`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`evaluator_id`) REFERENCES `users_hr1`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 8. SYSTEM SETTINGS & CONFIGURATION
-- =====================================================

-- HR1 System Settings
CREATE TABLE IF NOT EXISTS `settings_hr1` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(255) NOT NULL UNIQUE,
    `value` TEXT NULL,
    `type` ENUM('string', 'integer', 'boolean', 'json') NOT NULL DEFAULT 'string',
    `description` TEXT NULL,
    `updated_by` BIGINT UNSIGNED NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_key` (`key`),
    FOREIGN KEY (`updated_by`) REFERENCES `users_hr1`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 9. ACTIVITY LOGS (Optional but recommended)
-- =====================================================

-- Activity Logs Table
CREATE TABLE IF NOT EXISTS `activity_logs_hr1` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NULL,
    `action` VARCHAR(100) NOT NULL,
    `model_type` VARCHAR(255) NULL,
    `model_id` BIGINT UNSIGNED NULL,
    `description` TEXT NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` TEXT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_user_id` (`user_id`),
    INDEX `idx_action` (`action`),
    INDEX `idx_model` (`model_type`, `model_id`),
    INDEX `idx_created_at` (`created_at`),
    FOREIGN KEY (`user_id`) REFERENCES `users_hr1`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- SAMPLE DATA / INITIAL RECORDS (Optional)
-- =====================================================

-- Insert default admin user (password should be hashed in production)
-- Password: 'password' (change this in production!)
INSERT INTO `users_hr1` (`name`, `email`, `password`, `role`, `contact_no`, `date_of_employment`, `status`) 
VALUES ('Admin User', 'admin@concord.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NULL, CURDATE(), 'active')
ON DUPLICATE KEY UPDATE `name` = `name`;

-- Insert default award categories
INSERT INTO `award_categories_hr1` (`name`, `description`, `icon`, `color`) VALUES
('Outstanding Performance', 'Recognizing exceptional work performance', 'trophy', 'yellow'),
('Team Player', 'Recognizing excellent collaboration', 'users', 'blue'),
('Innovation', 'Recognizing creative solutions', 'lightbulb', 'green'),
('Leadership', 'Recognizing leadership qualities', 'star', 'purple')
ON DUPLICATE KEY UPDATE `name` = `name`;

-- =====================================================
-- END OF SCHEMA
-- =====================================================

