-- Create the database (if it does not exist)
CREATE DATABASE IF NOT EXISTS mental_wellness_tracker;

-- Use the created database
USE mental_wellness_tracker;

-- Create the users table (if it does not exist)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
