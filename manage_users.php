<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['owner', 'admin'])) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM users ORDER BY username ASC");
$users = $stmt->fetchAll();

if (isset($_GET['delete'])) {
    $id_to_delete = $_GET['delete'];
    if ($id_to_delete != $_SESSION['user_id']) {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id_to_delete]);
        header("Location: manage_users.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - FormulirSiswa</title>
    <link rel="stylesheet" href="dist/output.css">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap");
        * { font-family: "Plus Jakarta Sans", sans-serif; }
        .glass-nav { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .modal-blur { backdrop-filter: blur(4px); background: rgba(15, 23, 42, 0.4); }
    </style>
</head>
<body class="bg-[#fcfdfe] min-h-screen text-slate-800">

<nav class="glass-nav sticky top-0 z-50 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 h-20 flex items-center justify-between">
        <div class="flex items-center gap-4 md:gap-10">
            <div class="flex items-center gap-2 cursor-pointer" onclick="location.href='index.php'">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-100 rotate-3 transition-transform hover:rotate-0">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <span class="text-lg md:text-xl font-bold tracking-tight text-slate-900">Form<span class="text-indigo-600">Siswa</span></span>
            </div>
            <div class="hidden md:flex items-center gap-2">
                <a href="index.php" class="px-4 py-2 text-slate-500 hover:text-indigo-600 font-bold text-sm transition-all">Input Data</a>
                <a href="list_data.php" class="px-4 py-2 text-slate-500 hover:text-indigo-600 font-bold text-sm transition-all">Database</a>
                <a href="manage_users.php" class="px-4 py-2 bg-indigo-600 text-white rounded-xl font-bold text-sm shadow-md shadow-indigo-200 transition-all">Users</a>
            </div>
        </div>
        <div class="flex items-center gap-2 md:gap-4">
            <div class="text-right hidden sm:block mr-2">
                <p class="text-sm font-bold leading-tight"><?= htmlspecialchars($_SESSION['username']) ?></p>
                <p class="text-[10px] uppercase font-black text-indigo-500 tracking-tighter"><?= $_SESSION['role'] ?></p>
            </div>
            <a href="logout.php" class="hidden sm:flex p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            </a>
            <button onclick="toggleMobileMenu()" class="md:hidden p-2.5 bg-slate-50 text-slate-600 rounded-xl hover:bg-indigo-600 hover:text-white transition-all">
                <svg id="menuIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                <svg id="closeIcon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden border-t border-slate-50 bg-white/95 backdrop-blur-xl animate-in slide-in-from-top duration-300">
        <div class="p-6 space-y-4">
            <div class="flex items-center gap-4 pb-6 border-b border-slate-50">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center font-black text-indigo-600">
                    <?= strtoupper(substr($_SESSION['username'], 0, 1)) ?>
                </div>
                <div>
                    <p class="font-bold text-slate-900"><?= htmlspecialchars($_SESSION['username']) ?></p>
                    <p class="text-[10px] uppercase font-black text-indigo-500 tracking-tighter"><?= $_SESSION['role'] ?></p>
                </div>
            </div>
            <div class="grid gap-2">
                <a href="index.php" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 rounded-2xl font-bold transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Input Data
                </a>
                <a href="list_data.php" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 rounded-2xl font-bold transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/></svg>
                    Database
                </a>
                <a href="manage_users.php" class="flex items-center gap-3 px-4 py-3 bg-indigo-50 text-indigo-600 rounded-2xl font-bold transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Users
                </a>
                <a href="logout.php" class="flex items-center gap-3 px-4 py-3 text-rose-600 hover:bg-rose-50 rounded-2xl font-bold transition-all mt-4 border border-rose-100/50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Logout
                </a>
            </div>
        </div>
    </div>
</nav>

<main class="max-w-7xl mx-auto px-4 sm:px-6 py-8 md:py-12">
    <div class="mb-8 md:mb-10">
        <span class="text-indigo-600 font-black text-[10px] uppercase tracking-[0.2em] leading-tight">Security Control</span>
        <h1 class="text-3xl md:text-4xl font-black text-slate-900 mt-2 tracking-tight leading-tight">Manajemen Pengguna</h1>
        <p class="text-slate-400 font-medium text-sm mt-1 leading-tight">Kelola akun dan tingkat keamanan sistem.</p>
    </div>

    <div class="bg-white rounded-3xl md:rounded-[2.5rem] border border-slate-100 shadow-2xl shadow-indigo-50/50 overflow-hidden">
        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-left min-w-[700px] md:min-w-full">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-50">
                        <th class="px-6 md:px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pengguna</th>
                        <th class="px-6 md:px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Hak Akses</th>
                        <th class="px-6 md:px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php foreach ($users as $u): ?>
                    <tr class="hover:bg-slate-50/30 transition-all group">
                        <td class="px-6 md:px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center font-black text-indigo-600 text-xs border border-indigo-100 shadow-sm shrink-0">
                                    <?= strtoupper(substr($u['username'], 0, 1)) ?>
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-slate-800 tracking-tight leading-tight truncate"><?= htmlspecialchars($u['username']) ?></p>
                                    <p class="text-[9px] font-black text-slate-400 uppercase mt-0.5 tracking-wider truncate flex items-center gap-1.5">
                                        Email:
                                        <span class="text-indigo-500 font-black"><?= htmlspecialchars($u['email'] ?? '-') ?></span>
                                        <span class="px-1.5 py-0.5 bg-indigo-50 text-indigo-600 border border-indigo-100 rounded-md">
                                            <?= htmlspecialchars($u['role']) ?>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 md:px-8 py-6">
                            <?php 
                                $badgeClass = match($u['role']) {
                                    'owner' => 'bg-purple-50 text-purple-600 border-purple-100 shadow-purple-50',
                                    'admin' => 'bg-blue-50 text-blue-600 border-blue-100 shadow-blue-50',
                                    'petugas' => 'bg-orange-50 text-orange-600 border-orange-100 shadow-orange-50',
                                    default => 'bg-slate-100 text-slate-500 border-slate-200',
                                };
                            ?>
                            <div class="inline-flex items-center gap-2 px-3 md:px-4 py-1.5 md:py-2 <?= $badgeClass ?> text-[9px] md:text-[10px] font-black rounded-2xl border uppercase tracking-widest shadow-sm whitespace-nowrap">
                                <span class="w-1.5 md:w-2 h-1.5 md:h-2 rounded-full bg-current"></span>
                                <?= $u['role'] ?>
                            </div>
                        </td>
                        <td class="px-6 md:px-8 py-6">
                            <div class="flex items-center justify-center gap-2 transition-all">
                                <a href="edit_user.php?id=<?= $u['id'] ?>" class="p-2.5 bg-white border border-slate-100 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-xl transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </a>
                                <?php if ($u['id'] != $_SESSION['user_id']): ?>
                                <button onclick="openDeleteModal('<?= $u['id'] ?>', '<?= addslashes($u['username']) ?>')" class="p-2.5 bg-white border border-slate-100 text-rose-600 hover:bg-rose-600 hover:text-white rounded-xl transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                                <?php else: ?>
                                <span class="px-3 py-2 bg-slate-50 text-slate-300 text-[9px] font-black rounded-xl border border-slate-100 italic tracking-widest uppercase whitespace-nowrap">Aktif</span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<div id="deleteModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 md:p-6 modal-blur">
    <div class="bg-white w-full max-w-sm rounded-[2.5rem] p-8 md:p-10 shadow-2xl border border-slate-100 transform transition-all animate-in fade-in zoom-in duration-300">
        <div class="flex flex-col items-center text-center">
            <div class="w-16 h-16 md:w-20 md:h-20 bg-rose-50 rounded-full flex items-center justify-center mb-6">
                <svg class="w-8 h-8 md:w-10 md:h-10 text-rose-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <h3 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight leading-tight">Hapus Pengguna?</h3>
            <p class="text-slate-400 mt-2 font-medium text-sm">Akun <span id="modalUserName" class="text-indigo-600 font-black italic"></span> akan dihapus selamanya.</p>
            <div class="grid grid-cols-2 gap-4 w-full mt-8 md:mt-10">
                <button onclick="closeDeleteModal()" class="py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all">Batal</button>
                <a id="confirmDeleteBtn" href="#" class="py-4 bg-rose-600 hover:bg-rose-700 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all shadow-lg shadow-rose-200 flex items-center justify-center">Hapus</a>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        const menuIcon = document.getElementById('menuIcon');
        const closeIcon = document.getElementById('closeIcon');
        const isHidden = menu.classList.contains('hidden');
        
        if (isHidden) {
            menu.classList.remove('hidden');
            menuIcon.classList.add('hidden');
            closeIcon.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        } else {
            menu.classList.add('hidden');
            menuIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    function openDeleteModal(id, username) {
        const modal = document.getElementById('deleteModal');
        document.getElementById('modalUserName').innerText = '@' + username;
        document.getElementById('confirmDeleteBtn').href = 'manage_users.php?delete=' + id;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    window.onclick = function(event) {
        const modal = document.getElementById('deleteModal');
        if (event.target == modal) {
            closeDeleteModal();
        }
    }
</script>

</body>
</html>
