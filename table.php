CREATE TABLE `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `first_name` VARCHAR(50),
    `last_name` VARCHAR(50),
    `email` VARCHAR(100) UNIQUE,
    `password` VARCHAR(255),
    `address` VARCHAR(255),
    `phone_number` VARCHAR(20),
    `gender` ENUM('male', 'female', 'other')
);
