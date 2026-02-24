<?php 
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$nama = $_POST['nama'] ?? '';
$nis = $_POST['nis'] ?? '';
$tempat_lahir = $_POST['tempat_lahir'] ?? '';
$tanggal_lahir = $_POST['tanggal_lahir'] ?? '';
$jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
$agama = $_POST['agama'] ?? '';
$alamat = $_POST['alamat'] ?? '';

try {
    $stmt = $pdo->prepare("INSERT INTO data_siswa (nama, nis, tempat_lahir, tanggal_lahir, jenis_kelamin, agama, alamat, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nama, $nis, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $agama, $alamat, $_SESSION['user_id']]);
    $success_msg = "Data siswa berhasil didaftarkan ke sistem cloud.";
} catch (PDOException $e) {
    $error_msg = "Gagal menyimpan data: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sukses - Formulir Siswa</title>
    <link rel="stylesheet" href="dist/output.css">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap");
        * { font-family: "Plus Jakarta Sans", sans-serif; }
    </style>
</head>
<body class="bg-[#fcfdfe] min-h-screen flex items-center justify-center p-4 md:p-6 text-slate-800">

<div class="w-full max-w-lg">
    <div class="bg-white rounded-3xl md:rounded-[3rem] border border-slate-100 shadow-2xl shadow-indigo-50/50 p-8 md:p-10 text-center relative overflow-hidden">
        <div class="absolute -top-20 -left-20 w-40 h-40 bg-indigo-50 rounded-full blur-3xl opacity-50"></div>
        
        <div class="relative inline-flex mb-6 md:mb-8">
            <div class="w-20 h-20 md:w-24 md:h-24 bg-indigo-600 rounded-2xl md:rounded-[2.5rem] flex items-center justify-center shadow-2xl shadow-indigo-200 rotate-6 transform transition-all hover:rotate-0 duration-500">
                <svg class="w-10 h-10 md:w-12 md:h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div class="absolute -top-1 -right-1 md:-top-2 md:-right-2 w-6 h-6 md:w-8 md:h-8 bg-indigo-400 rounded-full border-2 md:border-4 border-white"></div>
        </div>

        <h1 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight mb-2 md:mb-3 italic">Berhasil!</h1>
        <p class="text-slate-400 font-medium text-xs md:text-sm mb-8 md:mb-10 leading-tight"><?= $success_msg ?? 'Data telah diproses.' ?></p>

        <div class="bg-slate-50 border border-slate-100 rounded-2xl md:rounded-3xl p-6 md:p-8 mb-8 md:mb-10 text-left space-y-4 shadow-sm">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-slate-200 pb-3 gap-1">
                <span class="text-[9px] md:text-[10px] font-black uppercase text-slate-400 tracking-widest leading-none">Nama Siswa</span>
                <span class="text-sm font-bold text-slate-800 leading-none truncate w-full sm:w-auto sm:text-right"><?= htmlspecialchars($nama) ?></span>
            </div>
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-slate-200 pb-3 gap-1">
                <span class="text-[9px] md:text-[10px] font-black uppercase text-slate-400 tracking-widest leading-none">Nomor Induk (NIS)</span>
                <span class="text-sm font-bold text-slate-800 leading-none"><?= htmlspecialchars($nis) ?></span>
            </div>
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-1">
                <span class="text-[9px] md:text-[10px] font-black uppercase text-slate-400 tracking-widest leading-none">Ditambahkan Oleh</span>
                <span class="text-xs font-black text-indigo-600 leading-none uppercase">@<?= htmlspecialchars($_SESSION['username']) ?></span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-4">
            <a href="index.php" class="py-4 md:py-5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl font-black text-[9px] md:text-[10px] uppercase tracking-widest transition-all">Input Lagi</a>
            <a href="list_data.php" class="py-4 md:py-5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-[9px] md:text-[10px] uppercase tracking-widest transition-all shadow-lg shadow-indigo-100">Lihat Database</a>
        </div>
    </div>
</div>

</body>
</html>