-- Insert admin role if not exists
INSERT IGNORE INTO role (role_name) VALUES ('admin');

-- Insert admin user (password is hashed for 'admin123')
INSERT INTO user (name, email, password, role_id)
SELECT 'Admin User', 'admin@payroll.com', '$2y$10$TGtDskraL18bmE8/gi407.7/l0dvKb/SuCAHcw7KL/YZzGG8PYbo.', role_id
FROM role WHERE role_name = 'admin';