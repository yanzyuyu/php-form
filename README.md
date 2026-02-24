# 🎓 FormSiswa - Modern Student Management System

[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.0-777bb4?style=for-the-badge&logo=php)](https://www.php.net/)
[![TailwindCSS](https://img.shields.io/badge/tailwindcss-%2338B2AC.svg?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com/)
[![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)

Sistem manajemen data siswa berbasis web yang dirancang dengan **Modern UI/UX**, fitur keamanan berlapis, dan desain yang **100% Fully Responsive**.

---

## ✨ Fitur Utama

-   **🎨 Modern Glassmorphism UI**: Antarmuka bersih menggunakan TailwindCSS v4 dengan efek *glassmorphism*.
-   **📱 Fully Responsive**: Optimal diakses dari Smartphone, Tablet, maupun Desktop.
-   **🔐 Multi-level Authentication**: Sistem login untuk `Owner`, `Admin`, `Petugas`, dan `User`.
-   **📝 CRUD Operations**: Create, Read, Update, dan Delete data siswa secara *real-time*.
-   **🛡️ Security First**: Dilindungi dari SQL Injection menggunakan PDO Prepared Statements dan Password Hashing (Bcrypt).
-   **✅ Smart Validation**: Validasi form interaktif dengan *floating error bubbles*.

---

## 📸 Tampilan Dashboard

> **Note:** Sistem ini menggunakan font *Plus Jakarta Sans* untuk tipografi yang modern dan elegan.

-   **Mobile Friendly**: Menu hamburger otomatis untuk navigasi di layar kecil.
-   **Database View**: Tabel data dengan fitur horizontal scroll di perangkat mobile.

---

## 🚀 Cara Instalasi

### 1. Persiapan
Pastikan Anda sudah menginstal **XAMPP** atau web server sejenis (Apache, MySQL, PHP 8.0+).

### 2. Clone Repository
```bash
git clone https://github.com/yanzyuyu/php-form.git
cd php-form
```

### 3. Konfigurasi Database
1.  Buka **phpMyAdmin** dan buat database baru bernama `php_form_db`.
2.  Import file `database.sql` ke dalam database tersebut.
3.  Salin file konfigurasi:
    ```bash
    cp config.php.example config.php
    ```
4.  Buka `config.php` dan sesuaikan `user` serta `pass` database Anda.

### 4. Jalankan Aplikasi
Pindahkan folder project ke `htdocs` (untuk XAMPP), lalu buka di browser:
`http://localhost/php-form`

---

## 🔑 Akun Demo (Default)

| Role | Username | Password |
| :--- | :--- | :--- |
| **Owner** | `pemilik` | `password123` |
| **Admin** | `admin` | `admin123` |

---

## 🛠️ Teknologi yang Digunakan

-   **Backend**: PHP 8.1+ (PDO)
-   **Frontend**: TailwindCSS v4
-   **Database**: MySQL
-   **Icons**: Heroicons (SVG)
-   **Fonts**: Plus Jakarta Sans (Google Fonts)

---

## 📁 Struktur Folder

```text
php-form/
├── dist/               # File CSS yang sudah diproses (Tailwind)
├── src/css/            # Source CSS (Input Tailwind)
├── img/                # Aset gambar & SVG
├── config.php          # Koneksi Database (Diabaikan Git)
├── index.php           # Form Input Data (Dashboard)
├── list_data.php       # Database Siswa
└── manage_users.php    # Manajemen User (Admin/Owner)
```

---

## 📄 Lisensi
Distribusi di bawah lisensi MIT. Lihat `LICENSE` untuk informasi lebih lanjut.

---

<p align="center">
  Dibuat dengan ❤️ untuk digitalisasi pendidikan Indonesia.
</p>
