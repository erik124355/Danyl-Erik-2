CREATE DATABASE IF NOT EXISTS retkikohteet CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE retkikohteet;

CREATE TABLE IF NOT EXISTS hiking_spots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    description TEXT,
    latitude DECIMAL(10, 8) NOT NULL,
    longitude DECIMAL(11, 8) NOT NULL,
    type VARCHAR(100) NOT NULL,
    difficulty VARCHAR(50) NOT NULL,
    planned_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO hiking_spots
(name, location, description, latitude, longitude, type, difficulty, planned_date)
VALUES
    ('Repovesi', 'Eastern Finland', 'Beautiful cliffs and lakes for hiking.', 61.1833, 26.3500, 'National park', 'Medium', '2026-10-01'),
    ('Koli', 'North Karelia', 'Wide views and forest trails.', 63.0950, 29.7950, 'National park', 'Easy', '2026-10-15'),
    ('PuijonTorni', 'Kuopio', 'Tower', 62.8924, 27.6782, 'Viewpoint', 'Easy', '2026-11-01');