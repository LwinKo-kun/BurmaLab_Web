<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Use the clean URL from the router instead of PHP_SELF (which is always index.php)
$current_page = isset($_GET['url']) ? trim($_GET['url'], '/') : '';
$current_page = preg_replace('/\.php$/', '', $current_page); // strip .php if present
$is_logged_in = isset($_SESSION['user_id']);

// Guest Header on index landing page
if (($current_page === '' || $current_page === 'index') && !$is_logged_in):
?>
<nav class="w-full bg-white/85 backdrop-blur-md border-b border-[#CEB5EF]/40 sticky top-0 z-50">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 h-20 flex items-center justify-between">
        <a href="/" class="flex items-center gap-2">
            <span class="bg-indigo-600 text-white p-2 rounded-xl text-sm font-black shadow-md shadow-indigo-200">⚛</span>
            <span class="text-2xl font-black bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent select-none">BurmaLab</span>
        </a>

        <div class="flex items-center gap-3 sm:gap-4">
            <a href="/login" class="text-sm font-bold text-slate-700 hover:text-indigo-600 px-3 py-2 transition rounded-xl">Login</a>
            <a href="/signup" class="px-4 py-2.5 text-sm font-extrabold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 active:scale-95">Get Started</a>
        </div>
    </div>
</nav>
<?php 
else:
    // Standard navigation bar
    $lab_slugs = ['lab', 'lab/projectile', 'lab/collisions', 'lab/friction', 'lab/newtons-second-law', 'lab/atwood-incline', 'lab/double-pulley', 'lab/incline'];
    $is_lab_active = in_array($current_page, $lab_slugs, true) || strpos($current_page, 'lab/') === 0;
?>
<nav class="w-full bg-white/85 backdrop-blur-md border-b border-[#CEB5EF]/40 sticky top-0 z-50">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 h-20 flex items-center justify-between">
        <a href="/home" class="flex items-center gap-2.5 group">
            <span class="bg-indigo-600 text-white p-2 rounded-xl text-sm font-black shadow-md shadow-indigo-200 group-hover:scale-105 transition-transform">⚛</span>
            <span class="text-2xl font-black bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">BurmaLab</span>
        </a>

        <!-- Desktop Navigation Links -->
        <div class="hidden md:flex items-center gap-8 font-semibold text-sm text-slate-600">
            <a href="/home" class="transition hover:text-indigo-600 <?php echo ($current_page === 'home') ? 'text-indigo-600 font-extrabold' : ''; ?>">Home</a>
            <?php if ($is_logged_in): ?>
                <a href="/lab" class="transition hover:text-indigo-600 <?php echo $is_lab_active ? 'text-indigo-600 font-extrabold' : ''; ?>">Labs</a>
                <a href="/theory" class="transition hover:text-indigo-600 <?php echo ($current_page === 'theory') ? 'text-indigo-600 font-extrabold' : ''; ?>">Theory</a>
            <?php endif; ?>
            <a href="/about" class="transition hover:text-indigo-600 <?php echo ($current_page === 'about') ? 'text-indigo-600 font-extrabold' : ''; ?>">About</a>
        </div>

        <!-- Desktop User Controls -->
        <div class="hidden md:flex items-center gap-4">
            <?php if ($is_logged_in): ?>
                <div class="flex items-center gap-2 bg-indigo-50 border border-indigo-100 px-3 py-1.5 rounded-full">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-mono font-bold text-indigo-950 max-w-[120px] truncate"><?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?></span>
                </div>
                <a href="/settings" class="text-sm font-bold text-slate-700 hover:text-indigo-600 transition <?php echo ($current_page === 'settings') ? 'text-indigo-600 font-extrabold' : ''; ?>">Settings</a>
                <a href="/logout" class="px-4 py-2 text-sm font-extrabold text-white bg-rose-500 rounded-xl hover:bg-rose-600 transition shadow-md shadow-rose-100 active:scale-95">Logout</a>
            <?php else: ?>
                <a href="/login" class="text-sm font-bold text-slate-700 hover:text-indigo-600 px-3 py-2 transition">Login</a>
                <a href="/signup" class="px-4 py-2.5 text-sm font-extrabold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 active:scale-95">Get Started</a>
            <?php endif; ?>
        </div>

        <!-- Mobile Hamburger Button -->
        <button onclick="toggleMobileMenu()" aria-label="Toggle Menu" class="md:hidden p-2 text-slate-700 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 rounded-xl transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>
</nav>

<!-- Mobile Slide-out Drawer -->
<div id="mobileMenu" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300 md:hidden">
    <div id="mobileDrawer" class="absolute right-0 top-0 bottom-0 w-4/5 max-w-xs bg-white shadow-2xl p-6 flex flex-col justify-between transform translate-x-full transition-transform duration-300">
        <div>
            <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-100">
                <span class="text-xl font-black bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">Menu</span>
                <button onclick="toggleMobileMenu()" aria-label="Close menu" class="p-2 text-slate-400 hover:text-slate-800 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20">✕</button>
            </div>
            
            <?php if ($is_logged_in): ?>
                <div class="mb-6 p-3 bg-indigo-50 border border-indigo-100 rounded-2xl flex items-center gap-3">
                    <div class="w-8 h-8 bg-indigo-600 text-white font-bold rounded-xl flex items-center justify-center text-xs">
                        <?php echo strtoupper(substr($_SESSION['username'] ?? 'U', 0, 1)); ?>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-mono">Logged in as</p>
                        <p class="text-sm font-bold text-slate-900 truncate max-w-[140px]"><?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <div class="flex flex-col gap-3 font-bold text-slate-700">
                <a href="/home" class="p-3 rounded-xl transition hover:bg-indigo-50 hover:text-indigo-600 <?php echo ($current_page === 'home') ? 'bg-indigo-50 text-indigo-600' : ''; ?>">Home</a>
                <?php if ($is_logged_in): ?>
                    <a href="/lab" class="p-3 rounded-xl transition hover:bg-indigo-50 hover:text-indigo-600 <?php echo $is_lab_active ? 'bg-indigo-50 text-indigo-600' : ''; ?>">Labs</a>
                    <a href="/theory" class="p-3 rounded-xl transition hover:bg-indigo-50 hover:text-indigo-600 <?php echo ($current_page === 'theory') ? 'bg-indigo-50 text-indigo-600' : ''; ?>">Theory</a>
                    <a href="/settings" class="p-3 rounded-xl transition hover:bg-indigo-50 hover:text-indigo-600 <?php echo ($current_page === 'settings') ? 'bg-indigo-50 text-indigo-600' : ''; ?>">Settings</a>
                <?php endif; ?>
                <a href="/about" class="p-3 rounded-xl transition hover:bg-indigo-50 hover:text-indigo-600 <?php echo ($current_page === 'about') ? 'bg-indigo-50 text-indigo-600' : ''; ?>">About</a>
            </div>
        </div>

        <div class="pt-6 border-t border-slate-100 flex flex-col gap-3">
            <?php if ($is_logged_in): ?>
                <a href="/logout" class="w-full py-3 text-center text-sm font-extrabold text-white bg-rose-500 rounded-xl shadow-md hover:bg-rose-600 transition">Logout</a>
            <?php else: ?>
                <a href="/login" class="w-full py-3 text-center text-sm font-extrabold text-indigo-600 border border-indigo-200 rounded-xl hover:bg-indigo-50 transition">Login</a>
                <a href="/signup" class="w-full py-3 text-center text-sm font-extrabold text-white bg-indigo-600 rounded-xl shadow-md hover:bg-indigo-700 transition">Get Started</a>
            <?php endif; ?>
        </div>
    </div>
</div>

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
        setTimeout(() => menu.classList.add('hidden'), 300);
    }
}
</script>
<?php endif; ?>