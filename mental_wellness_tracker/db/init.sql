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

-- Create the moods table (if it does not exist)
CREATE TABLE IF NOT EXISTS moods (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    mood VARCHAR(20) NOT NULL,
    entry_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create the goals table (if it does not exist)
CREATE TABLE IF NOT EXISTS goals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    goal TEXT NOT NULL,
    status ENUM('ongoing', 'completed') DEFAULT 'ongoing',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create the self_care_suggestions table (if it does not exist)
CREATE TABLE IF NOT EXISTS self_care_suggestions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(50), -- Example: Physical, Emotional, Mental, Spiritual
    suggestion TEXT, -- The actual self-care suggestion text
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Example entries for self-care suggestions
INSERT INTO self_care_suggestions (category, suggestion) VALUES
('Physical', 'Take a short walk outside to get fresh air.'),
('Physical', 'Stay hydrated and eat a balanced meal.'),
('Emotional', 'Journal your thoughts or emotions.'),
('Emotional', 'Talk to a friend or loved one about your feelings.'),
('Mental', 'Read a book or learn something new.'),
('Spiritual', 'Practice gratitude by writing down what you are thankful for.');
