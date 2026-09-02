<?php
/**
 * BurmaLab - Student Dashboard Page
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/curriculum.php';
require_once __DIR__ . '/includes/progress.php';

$userStats = ['streak' => 0, 'xp' => 0, 'completed_labs' => 0, 'completed_chapters' => 0];

if (isset($_SESSION['user_id'])) {
    update_user_streak_and_login($pdo, $_SESSION['user_id']);
    $userStats = get_user_stats($pdo, $_SESSION['user_id']);
}

$pageTitle = 'Dashboard - Physics Simulations Lab';
include 'includes/head.php';
include 'includes/nav.php';
?>

<div class="w-full max-w-[1440px] mx-auto px-4 sm:px-10 lg:px-16 py-8 space-y-8 sm:space-y-10 flex-grow">

    <!-- Hero Welcome Banner -->
    <div class="bg-white p-6 sm:p-12 rounded-3xl sm:rounded-[32px] border border-[#CEB5EF]/45 shadow-xl shadow-indigo-100/30 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 sm:gap-8 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-gradient-to-br from-indigo-500/10 to-violet-500/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="space-y-3 z-10 max-w-2xl">
            <?php if (isset($_SESSION['user_id'])): ?>
                <span class="inline-block bg-emerald-50 text-emerald-700 text-xs font-bold px-3.5 py-1.5 rounded-full uppercase tracking-wider border border-emerald-200/60">Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
            <?php else: ?>
                <span class="inline-block bg-indigo-50 text-indigo-600 text-xs font-bold px-3.5 py-1.5 rounded-full uppercase tracking-wider border border-indigo-200/60">Myanmar High School Curriculum (Grades 10–12)</span>
            <?php endif; ?>
            <h1 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight">Physics Mechanics <span class="bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">Dashboard</span></h1>
            <p class="text-slate-500 text-sm sm:text-base leading-relaxed">Your hub for curriculum chapters, virtual labs, and interactive theory modules.</p>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-3 z-10 w-full md:w-auto">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/settings" class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3.5 rounded-2xl bg-violet-600 hover:bg-violet-700 text-white font-bold text-sm shadow-lg shadow-violet-200 transition-all">Account Stats (<?php echo $userStats['xp']; ?> XP) &rarr;</a>
            <?php else: ?>
                <a href="/signup" class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-lg shadow-indigo-200 transition-all">Create Free Account &rarr;</a>
            <?php endif; ?>
            <a href="/lab" class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3.5 rounded-2xl bg-white hover:bg-slate-50 border border-indigo-200 text-slate-700 font-bold text-sm transition-all">Open Labs &rarr;</a>
        </div>
    </div>

    <?php if (isset($_SESSION['user_id'])): ?>
    <!-- Quick Stats Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-6 rounded-2xl border border-[#CEB5EF]/40 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-mono font-bold uppercase text-slate-400">Daily Login Streak</p>
                <p class="text-2xl font-black text-indigo-600 mt-1"><?php echo $userStats['streak']; ?> Days 🔥</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center text-xl font-bold">⚡</div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-[#CEB5EF]/40 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-mono font-bold uppercase text-slate-400">Total Earned XP</p>
                <p class="text-2xl font-black text-violet-600 mt-1"><?php echo $userStats['xp']; ?> XP</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center text-xl font-bold">⭐</div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-[#CEB5EF]/40 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-mono font-bold uppercase text-slate-400">Labs Completed</p>
                <p class="text-2xl font-black text-emerald-600 mt-1"><?php echo $userStats['completed_labs']; ?> / <?php echo count($activeLabs ?? []); ?></p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold">🧪</div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Quick Launch Labs Grid -->
    <section class="space-y-6">
        <div class="flex items-center justify-between border-b border-indigo-100 pb-4">
            <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Quick Launch — Simulation Modules</h2>
            <a href="/lab" class="text-xs font-bold text-indigo-600 hover:underline">View all labs &rarr;</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <?php foreach (array_slice($activeLabs ?? [], 0, 4) as $lab): ?>
                <a href="<?php echo htmlspecialchars($lab['href']); ?>" class="bg-white p-5 rounded-2xl border border-[#CEB5EF]/40 hover:border-indigo-500 transition-all shadow-sm hover:shadow-md group">
                    <span class="text-2xl"><?php echo $lab['icon']; ?></span>
                    <h3 class="font-bold text-slate-900 text-sm mt-3 group-hover:text-indigo-600 transition-colors"><?php echo htmlspecialchars($lab['title']); ?></h3>
                    <p class="text-[10px] font-mono text-indigo-600 mt-1 font-semibold uppercase tracking-wider"><?php echo htmlspecialchars($lab['badge']); ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Curriculum Matrix Overview -->
    <?php foreach ($curriculum ?? [] as $section): ?>
        <?php $colors = burmalab_grade_colors($section['color']); ?>
        <section class="space-y-6">
            <div class="flex items-center justify-between border-b <?php echo $colors['border']; ?> pb-4">
                <div class="flex items-center gap-3">
                    <span class="<?php echo $colors['badge']; ?> text-white font-extrabold text-xs px-3.5 py-1.5 rounded-xl uppercase tracking-wider shadow-sm"><?php echo htmlspecialchars($section['label']); ?></span>
                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Mechanics Curriculum Overview</h2>
                </div>
                <span class="text-xs font-mono font-bold text-slate-500">Chapters <?php echo htmlspecialchars($section['chapters']); ?></span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-<?php echo count($section['items']) === 4 ? '2' : '3'; ?> gap-6">
                <?php foreach ($section['items'] as $chapter): ?>
                    <div class="bg-white p-7 rounded-[28px] border border-[#CEB5EF]/40 shadow-sm space-y-3 hover:border-indigo-200 transition-all">
                        <span class="text-xs font-mono font-bold <?php echo $colors['chip']; ?> px-2.5 py-1 rounded-lg border">Chapter <?php echo $chapter['num']; ?></span>
                        <h3 class="font-bold text-slate-900 text-lg"><?php echo htmlspecialchars($chapter['title']); ?></h3>
                        <p class="text-sm text-slate-500 leading-relaxed"><?php echo htmlspecialchars($chapter['desc']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endforeach; ?>

</div>

<?php include 'includes/footer.php'; ?>