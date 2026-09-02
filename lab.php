<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_auth();
require_once 'includes/curriculum.php';
require_once 'includes/progress.php';

$userId = $_SESSION['user_id'] ?? null;
$pageTitle = 'Interactive Physics Labs - Physics Simulations Lab';

include 'includes/head.php';
include 'includes/nav.php';
?>

<div class="w-full max-w-[1440px] mx-auto px-4 sm:px-10 lg:px-16 py-8 space-y-8 sm:space-y-12 flex-grow">

    <div class="bg-white p-6 sm:p-12 rounded-3xl sm:rounded-[32px] border border-[#CEB5EF]/45 shadow-xl shadow-indigo-100/30 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 sm:gap-8 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-gradient-to-br from-indigo-500/10 to-violet-500/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="space-y-3 z-10 max-w-2xl">
            <span class="inline-block bg-indigo-50 text-indigo-600 text-xs font-bold px-3.5 py-1.5 rounded-full uppercase tracking-wider border border-indigo-200/60">Virtual Simulations</span>
            <h1 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight">Interactive Physics <span class="bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">Laboratories</span></h1>
            <p class="text-slate-500 text-sm sm:text-base leading-relaxed">Launch Matter.js simulation modules to test equations of motion, forces, and collisions in real time.</p>
        </div>
        <div class="bg-slate-50/90 border border-slate-200/60 p-4 sm:p-5 rounded-2xl flex items-center space-x-4 z-10 w-full md:w-auto backdrop-blur-sm shadow-sm">
            <div class="w-3.5 h-3.5 bg-emerald-500 rounded-full animate-pulse flex-shrink-0"></div>
            <div class="text-sm">
                <p class="text-slate-400 text-xs font-medium">Engine Status</p>
                <p class="text-slate-800 font-bold">Matter.js Ready</p>
            </div>
        </div>
    </div>

    <section class="space-y-6">
        <div class="flex items-center justify-between border-b border-indigo-100 pb-4">
            <div class="flex items-center gap-3">
                <span class="bg-indigo-600 text-white font-extrabold text-xs px-3.5 py-1.5 rounded-xl uppercase tracking-wider shadow-sm">Active Labs</span>
                <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Available Simulation Modules</h2>
            </div>
            <span class="text-xs font-mono font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-xl border border-indigo-200/60"><?php echo count($activeLabs); ?> Modules</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php foreach ($activeLabs as $lab): ?>
                <?php 
                    $labSlug = basename($lab['href']);
                    $isDone = $userId ? is_item_completed($pdo, $userId, 'lab', $labSlug) : false;
                ?>
                <a href="<?php echo htmlspecialchars($lab['href']); ?>" class="bg-white hover:bg-slate-50/80 p-6 sm:p-7 rounded-2xl sm:rounded-[28px] border <?php echo $isDone ? 'border-emerald-300 ring-2 ring-emerald-500/10' : 'border-[#CEB5EF]/40 hover:border-indigo-500'; ?> transition-all duration-300 shadow-sm hover:shadow-xl group flex flex-col justify-between relative overflow-hidden">
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 text-xl font-bold shadow-sm group-hover:scale-110 transition-transform"><?php echo $lab['icon']; ?></div>
                            <span class="text-[10px] font-mono font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg border border-indigo-100"><?php echo htmlspecialchars($lab['badge']); ?></span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 group-hover:text-indigo-600 mb-2.5 transition-colors"><?php echo htmlspecialchars($lab['title']); ?></h3>
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed"><?php echo htmlspecialchars($lab['desc']); ?></p>
                    </div>
                    
                    <div class="mt-6 flex items-center justify-between">
                        <?php if ($isDone): ?>
                            <span class="inline-flex items-center gap-1.5 text-xs font-extrabold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-xl border border-emerald-200">
                                ✓ Completed (+50 XP)
                            </span>
                        <?php else: ?>
                            <span class="text-xs font-bold text-indigo-600 group-hover:translate-x-1.5 transition-transform">Launch Lab &rarr;</span>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

</div>

<?php include 'includes/footer.php'; ?>