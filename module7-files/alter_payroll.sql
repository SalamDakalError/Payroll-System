-- Alter payroll table to add contribution fields
USE payroll_system;

ALTER TABLE payroll
ADD COLUMN gross_salary DECIMAL(12,2) DEFAULT 0.00 AFTER pay_period,
ADD COLUMN sss_employee DECIMAL(10,2) DEFAULT 0.00 AFTER gross_salary,
ADD COLUMN sss_employer DECIMAL(10,2) DEFAULT 0.00 AFTER sss_employee,
ADD COLUMN philhealth_employee DECIMAL(10,2) DEFAULT 0.00 AFTER sss_employer,
ADD COLUMN philhealth_employer DECIMAL(10,2) DEFAULT 0.00 AFTER philhealth_employee,
ADD COLUMN pagibig_employee DECIMAL(10,2) DEFAULT 0.00 AFTER philhealth_employer,
ADD COLUMN pagibig_employer DECIMAL(10,2) DEFAULT 0.00 AFTER pagibig_employee,
ADD COLUMN income_tax DECIMAL(10,2) DEFAULT 0.00 AFTER pagibig_employer,
ADD COLUMN total_deductions DECIMAL(12,2) DEFAULT 0.00 AFTER income_tax;