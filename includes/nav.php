<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Get current file name to highlight active nav link
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : "BurmaLab | Interactive Physics Suite"; ?></title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { 50: '#f0fdf4', 500: '#22c55e', 600: '#16a34a' }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#F6F6FF] text-slate-800 antialiased selection:bg-[#CEB5EF] selection:text-white min-h-screen flex flex-col justify-between overflow-x-hidden">

    <!-- Navigation Bar -->
<nav class="w-full bg-white/80 backdrop-blur-md border-b border-[#CEB5EF]/40 sticky top-0 z-50">
    <div class="max-w-[1440px] mx-auto px-6 h-20 flex items-center justify-between">
        <!-- Logo points to landing.php -->
        <a href="landing.php" class="text-2xl font-black bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-lg">
            BurmaLab
        </a>
        
        <!-- Desktop Links -->
        <div class="hidden md:flex items-center gap-8 font-semibold text-sm text-slate-600">
            <a href="landing.php" class="transition hover:text-indigo-600 <?php echo ($current_page == 'landing.php') ? 'text-indigo-600 font-bold' : ''; ?>">Home</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="index.php" class="transition hover:text-indigo-600 <?php echo ($current_page == 'index.php') ? 'text-indigo-600 font-bold' : ''; ?>">Dashboard</a>
            <?php endif; ?>
            <a href="lab.php" class="transition hover:text-indigo-600 <?php echo ($current_page == 'projectile.html') ? 'text-indigo-600 font-bold' : ''; ?>">Labs</a>
            <a href="theory.php" class="transition hover:text-indigo-600 <?php echo ($current_page == 'theory.php') ? 'text-indigo-600 font-bold' : ''; ?>">Theory</a>
            <a href="about.php" class="transition hover:text-indigo-600 <?php echo ($current_page == 'about.php') ? 'text-indigo-600 font-bold' : ''; ?>">About</a>
        </div>

        <!-- Desktop Auth Actions -->
        <div class="hidden md:flex items-center gap-4">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="index.php" class="px-4 py-2 text-sm font-semibold text-indigo-600 bg-indigo-50 rounded-xl hover:bg-indigo-100 transition">Dashboard</a>
                <a href="settings.php" class="text-sm font-semibold text-slate-700 hover:text-indigo-600 transition <?php echo ($current_page == 'settings.php') ? 'text-indigo-600 font-bold' : ''; ?>">Settings</a>
                <a href="logout.php" class="px-4 py-2 text-sm font-semibold text-white bg-rose-500 rounded-xl hover:bg-rose-600 transition shadow-sm">Logout</a>
            <?php else: ?>
                <a href="login.php" class="text-sm font-semibold text-slate-700 hover:text-indigo-600 px-3 py-2 transition <?php echo ($current_page == 'login.php') ? 'text-indigo-600 font-bold' : ''; ?>">Login</a>
                <a href="signup.php" class="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">Get Started</a>
            <?php endif; ?>
        </div>

        <!-- Mobile Menu Button -->
        <button onclick="toggleMobileMenu()" aria-label="Toggle Menu" class="md:hidden p-2 text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
    </div>
</nav>

    <!-- Mobile Drawer Overlay & Panel -->
    <div id="mobileMenu" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300 md:hidden">
        <div id="mobileDrawer" class="absolute right-0 top-0 bottom-0 w-3/4 max-w-sm bg-white shadow-2xl p-6 flex flex-col justify-between transform translate-x-full transition-transform duration-300">
            <div>
                <div class="flex items-center justify-between mb-8">
                    <span class="text-xl font-black bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">Menu</span>
                    <button onclick="toggleMobileMenu()" class="p-2 text-slate-500 hover:text-slate-800 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">✕</button>
                </div>
                <div class="flex flex-col gap-4 font-semibold text-slate-700">
                    <a href="index.php" class="hover:text-indigo-600 transition">Home</a>
                    <a href="lab.php" class="hover:text-indigo-600 transition">Labs</a>
                    <a href="theory.php" class="hover:text-indigo-600 transition">Theory</a>
                    <a href="about.php" class="hover:text-indigo-600 transition">About</a>
                </div>
            </div>
            
            <div class="pt-6 border-t border-slate-100 flex flex-col gap-3">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="settings.php" class="w-full py-2.5 text-center text-sm font-semibold text-slate-700 bg-slate-100 rounded-xl hover:bg-slate-200 transition">Settings</a>
                    <a href="logout.php" class="w-full py-2.5 text-center text-sm font-semibold text-white bg-rose-500 rounded-xl hover:bg-rose-600 transition">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="w-full py-2.5 text-center text-sm font-semibold text-indigo-600 border border-indigo-200 rounded-xl hover:bg-indigo-50 transition">Login</a>
                    <a href="signup.php" class="w-full py-2.5 text-center text-sm font-semibold text-white bg-indigo-600 rounded-xl shadow-md hover:bg-indigo-700 transition">Get Started</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Script Logic -->
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const drawer = document.getElementById('mobileDrawer');
            
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                setTimeout(() => {
                    menu.classList.remove('opacity-0');
                    drawer.classList.remove('translate-x-full');
                }, 10);
            } else {
                menu.classList.add('opacity-0');
                drawer.classList.add('translate-x-full');
                setTimeout(() => {
                    menu.classList.add('hidden');
                }, 300);
            }
        }
    </script>