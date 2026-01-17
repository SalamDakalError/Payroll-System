-- Payroll System schema for 7 tables
CREATE DATABASE IF NOT EXISTS payroll_system;
USE payroll_system;

CREATE TABLE IF NOT EXISTS `role` (
  `role_id` INT AUTO_INCREMENT PRIMARY KEY,
  `role_name` VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role_id` INT NOT NULL,
  FOREIGN KEY (role_id) REFERENCES role(role_id)
);

CREATE TABLE IF NOT EXISTS `department` (
  `department_id` INT AUTO_INCREMENT PRIMARY KEY,
  `department_name` VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS `employee` (
  `employee_id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `department_id` INT NOT NULL,
  `hire_date` DATE,
  `salary` DECIMAL(12,2) DEFAULT 0,
  FOREIGN KEY (user_id) REFERENCES user(user_id),
  FOREIGN KEY (department_id) REFERENCES department(department_id)
);

CREATE TABLE IF NOT EXISTS `attendance` (
  `attendance_id` INT AUTO_INCREMENT PRIMARY KEY,
  `employee_id` INT NOT NULL,
  `date` DATE NOT NULL,
  `status` ENUM('present','absent','leave') DEFAULT 'present',
  FOREIGN KEY (employee_id) REFERENCES employee(employee_id)
);

CREATE TABLE IF NOT EXISTS `payroll` (
  `payroll_id` INT AUTO_INCREMENT PRIMARY KEY,
  `employee_id` INT NOT NULL,
  `pay_period` VARCHAR(50) NOT NULL,
  `net_salary` DECIMAL(12,2) DEFAULT 0,
  FOREIGN KEY (employee_id) REFERENCES employee(employee_id)
);

CREATE TABLE IF NOT EXISTS `payslip` (
  `payslip_id` INT AUTO_INCREMENT PRIMARY KEY,
  `payroll_id` INT NOT NULL,
  `issued_date` DATE NOT NULL,
  FOREIGN KEY (payroll_id) REFERENCES payroll(payroll_id)
);
