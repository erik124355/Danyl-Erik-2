CREATE DATABASE IF NOT EXISTS retkikohteet CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE retkikohteet;

CREATE TABLE IF NOT EXISTS hiking_spots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO hiking_spots (name, location, description)
VALUES
    ('Pyhätunturi', 'Lapland', 'Famous hiking destination in northern Finland.'),
    ('Repovesi', 'Eastern Finland', 'Beautiful cliffs and lakes for hiking.'),
    ('Koli', 'North Karelia', 'Wide views and forest trails.')
ON DUPLICATE KEY UPDATE
    name = VALUES(name),
    location = VALUES(location),
    description = VALUES(description);