# FormSiswa

FormSiswa adalah aplikasi web sederhana untuk mengelola data siswa. Aplikasi ini dibuat dengan PHP native, MySQL, dan Tailwind CSS.

## Fitur

- Login dan register pengguna
- Input data siswa
- Menampilkan daftar data siswa
- Edit dan hapus data siswa
- Manajemen pengguna
- Role pengguna: owner, admin, petugas, dan user
- Menampilkan user yang menginput data siswa

## Teknologi

- PHP
- MySQL
- PDO
- Tailwind CSS
- JavaScript

## Struktur Database

Database yang digunakan bernama `php_form_db`.

Tabel utama:

- `users`: menyimpan data akun, email, password, dan role
- `data_siswa`: menyimpan data siswa dan user yang menginput data

## Instalasi

1. Simpan folder project di dalam folder `htdocs`.

2. Buat database baru di phpMyAdmin dengan nama:

```sql
php_form_db
```

3. Import file:

```text
database.sql
```

4. Sesuaikan konfigurasi database di file:

```text
config.php
```

Contoh konfigurasi:

```php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "php_form_db";
```

5. Jalankan aplikasi melalui browser:

```text
http://localhost/php-form
```

## Akun Default

Password semua akun default:

```text
password123
```

Daftar akun:

```text
owner@formsiswa.local
admin@formsiswa.local
petugas@formsiswa.local
user@formsiswa.local
```

## Pengembangan CSS

Jika ingin mengubah file CSS, install dependency terlebih dahulu:

```bash
npm install
```

Jalankan mode development:

```bash
npm run dev
```

Build CSS:

```bash
npm run build
```

## File Penting

- `login.php`: halaman login
- `register.php`: halaman register
- `index.php`: form input data siswa
- `datadiri_show.php`: proses simpan data siswa
- `list_data.php`: daftar data siswa
- `edit_data.php`: edit data siswa
- `delete_data.php`: hapus data siswa
- `manage_users.php`: manajemen pengguna
- `edit_user.php`: edit pengguna
- `auto_setup.php`: setup atau update struktur database
- `config.php`: konfigurasi koneksi database

## Catatan

File `auto_setup.php` digunakan untuk membantu setup database. Setelah database selesai disiapkan, file ini sebaiknya tidak dibuka sembarangan.
