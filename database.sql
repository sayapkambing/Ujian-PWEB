sql-- Buat database
CREATE DATABASE IF NOT EXISTS smart_home;
USE smart_home;

-- Tabel untuk menyimpan data ruangan
CREATE TABLE IF NOT EXISTS rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    temperature DECIMAL(5,2) DEFAULT 0,
    humidity DECIMAL(5,2) DEFAULT 65,
    energy DECIMAL(10,2) DEFAULT 2.20,
    lamp_on BOOLEAN DEFAULT FALSE,
    door_locked BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert data contoh
INSERT INTO rooms (name, temperature, humidity, energy, lamp_on, door_locked) VALUES
('Kamar Tidur', 26, 65, 2.20, TRUE, TRUE),
('Ruang Tamu', 24, 60, 1.50, FALSE, TRUE),
('Dapur', 28, 70, 3.50, TRUE, FALSE);
