-- LexElite Database
CREATE DATABASE IF NOT EXISTS lexelite;
USE lexelite;

CREATE TABLE admins (
 admin_id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100) NOT NULL,
 email VARCHAR(100) UNIQUE NOT NULL,
 password VARCHAR(255) NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE customers (
 customer_id INT AUTO_INCREMENT PRIMARY KEY,
 full_name VARCHAR(100) NOT NULL,
 email VARCHAR(100) UNIQUE NOT NULL,
 phone VARCHAR(20),
 password VARCHAR(255) NOT NULL,
 gender ENUM('Male','Female','Other'),
 address TEXT,
 profile_image VARCHAR(255),
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE lawyers (
 lawyer_id INT AUTO_INCREMENT PRIMARY KEY,
 full_name VARCHAR(100) NOT NULL,
 email VARCHAR(100) UNIQUE NOT NULL,
 phone VARCHAR(20),
 password VARCHAR(255) NOT NULL,
 specialization VARCHAR(100),
 qualification VARCHAR(150),
 experience INT,
 city VARCHAR(100),
 address TEXT,
 license_no VARCHAR(100),
 bio TEXT,
 consultation_fee DECIMAL(10,2),
 profile_image VARCHAR(255),
 status ENUM('Pending','Approved','Rejected') DEFAULT 'Pending',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE services (
 service_id INT AUTO_INCREMENT PRIMARY KEY,
 service_name VARCHAR(100),
 description TEXT,
 fee DECIMAL(10,2)
);

CREATE TABLE appointments (
 appointment_id INT AUTO_INCREMENT PRIMARY KEY,
 customer_id INT NOT NULL,
 lawyer_id INT NOT NULL,
 service_id INT NOT NULL,
 appointment_date DATE,
 appointment_time TIME,
 message TEXT,
 status ENUM('Pending','Confirmed','Completed','Cancelled') DEFAULT 'Pending',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE,
 FOREIGN KEY (lawyer_id) REFERENCES lawyers(lawyer_id) ON DELETE CASCADE,
 FOREIGN KEY (service_id) REFERENCES services(service_id) ON DELETE CASCADE
);

CREATE TABLE reviews (
 review_id INT AUTO_INCREMENT PRIMARY KEY,
 customer_id INT,
 lawyer_id INT,
 rating INT,
 review TEXT,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE,
 FOREIGN KEY (lawyer_id) REFERENCES lawyers(lawyer_id) ON DELETE CASCADE
);

CREATE TABLE contact_messages (
 message_id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100),
 email VARCHAR(100),
 subject VARCHAR(150),
 message TEXT,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO admins(name,email,password)
VALUES ('Administrator','admin@gmail.com','123456');

INSERT INTO services(service_name,description,fee) VALUES
('Family Law','Family Court Cases',5000),
('Criminal Law','Criminal Cases',7000),
('Civil Law','Civil Matters',6000),
('Corporate Law','Corporate Services',10000),
('Property Law','Property Cases',6500),
('Tax Law','Tax Consultancy',8000),
('Immigration Law','Visa & Immigration',9000),
('Divorce Law','Divorce Cases',5500);
-- ============================================================
-- LexElite — Migration Fix Script
-- Run this ONLY if you already have a live "lexelite" database
-- and don't want to re-import the full lexelite.sql (data loss).
-- This safely ADDS the missing table/column used by the code
-- but never existed in the original schema.
-- ============================================================
USE lexelite;

-- 1. Add cnic_no column to lawyers (used by lawyer-register.php,
--    lawyer_edit.php, lawyerdashboard.php, admin.php)
ALTER TABLE lawyers ADD COLUMN IF NOT EXISTS cnic_no VARCHAR(50) AFTER license_no;

-- 2. Create schedules table (used by book_appointment.php,
--    lawyerdashboard.php, admin.php)
CREATE TABLE IF NOT EXISTS schedules (
 schedule_id INT AUTO_INCREMENT PRIMARY KEY,
 lawyer_id INT NOT NULL,
 day VARCHAR(20) NOT NULL,
 start_time TIME NOT NULL,
 end_time TIME,
 status ENUM('Available','Unavailable') DEFAULT 'Available',
 FOREIGN KEY (lawyer_id) REFERENCES lawyers(lawyer_id) ON DELETE CASCADE
);

