<?php
session_start();
require 'config.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Formulir Siswa</title>
    <link rel="stylesheet" href="dist/output.css">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap");
        * { font-family: "Plus Jakarta Sans", sans-serif; border-color: #f1f5f9 !important; }
        @keyframes shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-5px); } 75% { transform: translateX(5px); } }
        .animate-shake { animation: shake 0.4s ease-in-out 0s 2; }
        .error-bubble { animation: fadeInScale 0.2s ease-out forwards; filter: drop-shadow(0 10px 15px rgba(225, 29, 72, 0.1)); }
        @keyframes fadeInScale { from { opacity: 0; transform: translateY(10px) scale(0.95); } to { opacity: 1; transform: translateY(0) scale(1); } }
    </style>
</head>
<body class="bg-[#fcfdfe] min-h-screen flex items-center justify-center p-4 md:p-6 text-slate-800">
    <div class="w-full max-w-md">
        <div class="flex flex-col items-center mb-8 md:mb-10">
            <div class="w-14 h-14 md:w-16 md:h-16 bg-indigo-600 rounded-2xl md:rounded-3xl flex items-center justify-center shadow-xl shadow-indigo-100 mb-6 rotate-3 transition-transform hover:rotate-0">
                <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
            </div>
            <h1 class="text-2xl md:text-3xl font-black tracking-tight">Selamat Datang</h1>
            <p class="text-slate-400 font-medium text-xs md:text-sm mt-1 leading-tight text-center">Silakan masuk ke akun Anda</p>
        </div>

        <div class="bg-white p-8 md:p-10 rounded-3xl md:rounded-[2.5rem] border border-slate-100 shadow-2xl shadow-indigo-50/50 relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-indigo-50 rounded-full blur-3xl opacity-50 text-slate-800"></div>

            <?php if (isset($error)): ?>
                <div class="animate-shake bg-rose-50 border border-rose-100 text-rose-600 p-4 rounded-2xl mb-8 flex items-center gap-4 shadow-sm text-slate-800">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm text-rose-500 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] leading-none">Gagal</p>
                        <p class="text-xs font-bold mt-1 leading-tight text-slate-800 truncate"><?= $error ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-5 md:space-y-6 relative custom-form text-slate-800" novalidate>
                <div class="space-y-2 relative field-group">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 leading-tight text-slate-800">Username</label>
                    <input type="text" name="username" placeholder="Masukkan username" class="w-full px-5 py-4 bg-slate-50/50 border border-slate-100 rounded-2xl outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white transition-all font-medium text-slate-800" required autofocus>
                </div>
                <div class="space-y-2 relative field-group">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 leading-tight text-slate-800">Password</label>
                    <input type="password" name="password" placeholder="••••••••" class="w-full px-5 py-4 bg-slate-50/50 border border-slate-100 rounded-2xl outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white transition-all font-medium text-slate-800" required>
                </div>
                
                <button type="submit" class="w-full py-5 bg-indigo-600 text-white rounded-2xl font-black shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all active:scale-95 transform mt-4 uppercase tracking-wider text-xs md:text-sm">
                    Masuk Sekarang
                </button>
            </form>

            <div class="mt-8 md:mt-10 pt-6 md:pt-8 border-t border-slate-50 text-center">
                <p class="text-sm text-slate-500 font-medium">Belum punya akun? <a href="register.php" class="text-indigo-600 font-black hover:underline transition-all">Daftar Sekarang</a></p>
            </div>
        </div>

        <div class="mt-6 md:mt-8 flex flex-wrap justify-center gap-3 md:gap-4 text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-400">
            <a href="https://github.com/yanzyuyu">
                    <span class="px-3 py-1 bg-slate-100 rounded-full whitespace-nowrap">&copy; yanzyuyu</span>
            </a>
            <a href="https://github.com/yanzyuyu/php-form">
                    <span class="px-3 py-1 bg-slate-100 rounded-full whitespace-nowrap">repository</span>
            </a>


        </div>
    </div>

<script>
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
        const container = input.closest('.field-group');
        const bubble = document.createElement('div');
        bubble.className = 'error-bubble absolute -bottom-2 right-0 bg-rose-500 text-white text-[9px] font-black px-3 py-1.5 rounded-lg shadow-lg z-[60] flex items-center gap-1.5 uppercase tracking-tighter pointer-events-none';
        bubble.innerHTML = `<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>Wajib Diisi!`;
        container.appendChild(bubble);
        input.addEventListener('input', () => bubble.remove(), { once: true });
    }
</script>
</body>
</html>