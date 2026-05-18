<?php
require 'config.php';

try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('owner', 'admin', 'petugas', 'user') DEFAULT 'user'
    )");

    $pdo->exec("ALTER TABLE users MODIFY COLUMN role ENUM('owner', 'admin', 'petugas', 'user') DEFAULT 'user'");
    try {
        $pdo->exec("ALTER TABLE users ADD COLUMN email VARCHAR(100) UNIQUE AFTER username");
    } catch (Exception $e) {}

    $pdo->exec("CREATE TABLE IF NOT EXISTS data_siswa (
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
    )");

    try {
        $pdo->exec("ALTER TABLE data_siswa ADD COLUMN created_by INT AFTER alamat");
        $pdo->exec("ALTER TABLE data_siswa ADD CONSTRAINT fk_created_by FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL");
    } catch (Exception $e) {}

    $pass = password_hash('password123', PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare("INSERT IGNORE INTO users (username, email, password, role) VALUES (?, ?, ?, ?), (?, ?, ?, ?), (?, ?, ?, ?), (?, ?, ?, ?)");
    $stmt->execute([
        'pemilik', 'pemilik@formsiswa.local', $pass, 'owner',
        'owner', 'owner@formsiswa.local', $pass, 'owner',
        'admin', 'admin@formsiswa.local', $pass, 'admin',
        'petugas', 'petugas@formsiswa.local', $pass, 'petugas'
    ]);

    $pdo->exec("UPDATE users SET email = CONCAT(username, '@formsiswa.local') WHERE email IS NULL OR email = ''");

    echo "<div style='font-family:sans-serif; text-align:center; margin-top:50px; background:#f0fdf4; padding:40px; border-radius:20px; max-width:500px; margin-left:auto; margin-right:auto; border:1px solid #bbf7d0;'>
            <h1 style='color:#16a34a; font-size:2rem;'>✅ DATABASE UPDATED!</h1>
            <p style='color:#166534;'>Tabel dan Role sudah siap.</p>
            <a href='login.php' style='display:inline-block; padding:12px 25px; background:#2563eb; color:white; text-decoration:none; border-radius:10px; font-weight:bold; transition:0.3s;'>Ke Halaman Login</a>
          </div>";

} catch (PDOException $e) {
    die("Setup Gagal: " . $e->getMessage());
}
?>
