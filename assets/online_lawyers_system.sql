CREATE DATABASE IF NOT EXISTS online_lawyers_system;
USE online_lawyers_system;

CREATE TABLE admins (
  admin_id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(100) NOT NULL,
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
  city VARCHAR(100),
  profile_image VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE lawyers (
  lawyer_id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  phone VARCHAR(20),
  password VARCHAR(255) NOT NULL,
  qualification VARCHAR(150),
  experience INT,
  specialization VARCHAR(100),
  consultation_fee DECIMAL(10,2),
  office_address TEXT,
  city VARCHAR(100),
  profile_image VARCHAR(255),
  status ENUM('Pending','Approved','Rejected') DEFAULT 'Pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE services (
  service_id INT AUTO_INCREMENT PRIMARY KEY,
  service_name VARCHAR(100) NOT NULL,
  description TEXT
);

INSERT INTO services(service_name,description) VALUES
('Criminal Law','Criminal cases'),
('Civil Law','Civil matters'),
('Divorce Law','Divorce and family disputes'),
('Family Law','Family legal services'),
('Property Law','Property disputes'),
('Affidavit','Affidavit preparation'),
('Corporate Law','Corporate legal services');

CREATE TABLE appointments (
  appointment_id INT AUTO_INCREMENT PRIMARY KEY,
  customer_id INT NOT NULL,
  lawyer_id INT NOT NULL,
  appointment_date DATE NOT NULL,
  appointment_time TIME NOT NULL,
  meeting_type ENUM('Online','Office Visit') DEFAULT 'Office Visit',
  case_description TEXT,
  status ENUM('Pending','Approved','Completed','Cancelled') DEFAULT 'Pending',
  booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_app_customer FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE,
  CONSTRAINT fk_app_lawyer FOREIGN KEY (lawyer_id) REFERENCES lawyers(lawyer_id) ON DELETE CASCADE
);

CREATE TABLE schedules (
  schedule_id INT AUTO_INCREMENT PRIMARY KEY,
  lawyer_id INT NOT NULL,
  day_name VARCHAR(20),
  start_time TIME,
  end_time TIME,
  CONSTRAINT fk_schedule_lawyer FOREIGN KEY (lawyer_id) REFERENCES lawyers(lawyer_id) ON DELETE CASCADE
);

CREATE TABLE reviews (
  review_id INT AUTO_INCREMENT PRIMARY KEY,
  customer_id INT,
  lawyer_id INT,
  rating INT CHECK (rating BETWEEN 1 AND 5),
  review TEXT,
  review_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_review_customer FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE,
  CONSTRAINT fk_review_lawyer FOREIGN KEY (lawyer_id) REFERENCES lawyers(lawyer_id) ON DELETE CASCADE
);

INSERT INTO admins(full_name,email,password)
VALUES('Administrator','admin@gmail.com','admin123');
