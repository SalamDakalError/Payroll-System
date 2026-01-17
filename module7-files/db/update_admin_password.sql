-- Update admin password with correct hash
UPDATE user SET password = '$2y$10$TGtDskraL18bmE8/gi407.7/l0dvKb/SuCAHcw7KL/YZzGG8PYbo.' WHERE email = 'admin@payroll.com';