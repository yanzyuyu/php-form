-- Create database
CREATE DATABASE IF NOT EXISTS php_form_db;
USE php_form_db;

-- Table for users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('owner', 'admin', 'petugas', 'user') DEFAULT 'user'
);

-- Table for student data
CREATE TABLE IF NOT EXISTS data_siswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    nis VARCHAR(20) NOT NULL,
    tempat_lahir VARCHAR(100),
    tanggal_lahir DATE,
    jenis_kelamin VARCHAR(20),
    agama VARCHAR(20),
    alamat TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Insert default accounts (password: password123)
-- Admin: admin@formsiswa.local / password123
-- User: user@formsiswa.local / password123
INSERT IGNORE INTO users (username, email, password, role) VALUES
('owner', 'owner@formsiswa.local', '$2y$10$mcIjyjp6A7NE1VAUxZt5UuiLosusZJHTHQ3ft7Dh/vQfvn5mAhRSe', 'owner'),
('admin', 'admin@formsiswa.local', '$2y$10$mcIjyjp6A7NE1VAUxZt5UuiLosusZJHTHQ3ft7Dh/vQfvn5mAhRSe', 'admin'),
('petugas', 'petugas@formsiswa.local', '$2y$10$mcIjyjp6A7NE1VAUxZt5UuiLosusZJHTHQ3ft7Dh/vQfvn5mAhRSe', 'petugas'),
('user', 'user@formsiswa.local', '$2y$10$mcIjyjp6A7NE1VAUxZt5UuiLosusZJHTHQ3ft7Dh/vQfvn5mAhRSe', 'user');
