<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['owner', 'admin'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'] ?? '';
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user_edit = $stmt->fetch();

if (!$user_edit) {
    header("Location: manage_users.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_SESSION['role'] === 'owner' && isset($_POST['new_role'])) {
        $new_role = $_POST['new_role'];
        $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
        $stmt->execute([$new_role, $id]);
    }

    if (isset($_POST['new_password']) && !empty($_POST['new_password'])) {
        $new_pass = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$new_pass, $id]);
    }

    header("Location: manage_users.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - FormulirSiswa</title>
    <link rel="stylesheet" href="dist/output.css">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap");
        * { font-family: "Plus Jakarta Sans", sans-serif; border-color: #f1f5f9 !important; }
        .glass-nav { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .error-bubble { animation: fadeInScale 0.2s ease-out forwards; filter: drop-shadow(0 10px 15px rgba(225, 29, 72, 0.1)); }
        @keyframes fadeInScale { from { opacity: 0; transform: translateY(10px) scale(0.95); } to { opacity: 1; transform: translateY(0) scale(1); } }
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
                <span class="text-lg md:text-xl font-bold tracking-tight text-slate-900 font-black">Form<span class="text-indigo-600">Siswa</span></span>
            </div>
            <div class="hidden md:flex items-center gap-2">
                <a href="index.php" class="px-4 py-2 text-slate-500 hover:text-indigo-600 font-bold text-sm transition-all">Input Data</a>
                <a href="list_data.php" class="px-4 py-2 text-slate-500 hover:text-indigo-600 font-bold text-sm transition-all">Database</a>
                <a href="manage_users.php" class="px-4 py-2 bg-indigo-600 text-white rounded-xl font-bold text-sm shadow-md shadow-indigo-200 transition-all">Users</a>
            </div>
        </div>
        <div class="flex items-center gap-2 md:gap-4">
            <div class="text-right hidden sm:block mr-2">
                <p class="text-sm font-bold leading-tight text-slate-900"><?= htmlspecialchars($_SESSION['username']) ?></p>
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

<main class="max-w-xl mx-auto py-8 md:py-16 px-4 md:px-6">
    <div class="mb-8 md:mb-10 text-center text-slate-800">
        <h1 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight leading-tight">Ubah Pengguna</h1>
        <p class="text-slate-400 font-medium mt-2 italic text-sm">Target: @<?= htmlspecialchars($user_edit['username']) ?></p>
    </div>

    <div class="bg-white p-6 md:p-10 rounded-3xl md:rounded-[2.5rem] border border-slate-100 shadow-2xl shadow-indigo-50/50">
        <form method="POST" class="space-y-6 md:space-y-8 relative custom-form" novalidate>
            <?php if ($_SESSION['role'] === 'owner'): ?>
            <div class="space-y-4">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1 leading-tight">Hak Akses</label>
                <div class="grid grid-cols-2 gap-3 md:gap-4">
                    <?php 
                    $roles = ['owner', 'admin', 'petugas', 'user'];
                    foreach($roles as $r): 
                    ?>
                    <label class="flex items-center gap-3 p-4 bg-slate-50/50 border border-slate-100 rounded-2xl hover:border-indigo-600 hover:bg-white transition-all cursor-pointer group">
                        <input type="radio" name="new_role" value="<?= $r ?>" <?= $user_edit['role'] == $r ? 'checked' : '' ?> class="w-4 h-4 text-indigo-600 focus:ring-indigo-600">
                        <span class="text-[10px] md:text-xs font-black text-slate-600 group-hover:text-indigo-600 uppercase"><?= $r ?></span>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="space-y-2 pt-6 border-t relative field-group">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1 leading-tight">Update Password</label>
                <input type="password" name="new_password" placeholder="••••••••" class="w-full px-5 py-4 bg-slate-50/50 border border-slate-100 rounded-2xl outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white transition-all font-medium text-slate-800">
                <p class="text-[9px] text-slate-400 italic font-bold ml-1">* Kosongkan jika tidak ingin mengubah password.</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 md:gap-4 pt-4">
                <button type="submit" class="flex-1 py-4 md:py-5 bg-indigo-600 text-white rounded-2xl font-black shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all active:scale-95 transform uppercase tracking-widest text-[10px] md:text-xs">
                    SIMPAN PERUBAHAN
                </button>
                <a href="manage_users.php" class="flex-1 py-4 md:py-5 bg-slate-100 hover:bg-slate-200 text-slate-500 rounded-2xl font-black text-center transition-all uppercase tracking-widest text-[10px] md:text-xs flex items-center justify-center">
                    BATAL
                </a>
            </div>
        </form>
    </div>
</main>

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

    document.querySelector('.custom-form').addEventListener('submit', function(e) {
        const inputs = this.querySelectorAll('[required]');
        let firstInvalid = null;
        document.querySelectorAll('.error-bubble').forEach(el => el.remove());
        inputs.forEach(input => {
            if (!input.value.trim()) {
                e.preventDefault();
                showError(input);
                if (!firstInvalid) firstInvalid = input;
            }
        });
        if (firstInvalid) firstInvalid.focus();
    });

    function showError(input) {
        const container = input.closest('.field-group') || input.closest('div');
        const bubble = document.createElement('div');
        bubble.className = 'error-bubble absolute -bottom-2 right-0 bg-rose-500 text-white text-[9px] font-black px-3 py-1.5 rounded-lg shadow-lg z-[60] flex items-center gap-1.5 uppercase tracking-tighter pointer-events-none';
        bubble.innerHTML = `<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>Wajib Diisi!`;
        container.classList.add('relative');
        container.appendChild(bubble);
        input.addEventListener('input', () => bubble.remove(), { once: true });
    }
</script>

</body>
</html>