<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/curriculum.php';
$pageTitle = 'Dashboard - BurmaLab';
include 'includes/head.php';
?>

<?php include 'includes/nav.php'; ?>

<div class="w-full max-w-[1440px] mx-auto px-6 sm:px-10 lg:px-16 py-8 space-y-12 flex-grow">

    <div class="bg-white p-6 sm:p-12 rounded-[32px] border border-[#CEB5EF]/45 shadow-xl shadow-indigo-100/30 flex flex-col md:flex-row justify-between items-start md:items-center gap-8 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-gradient-to-br from-indigo-500/10 to-violet-500/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="space-y-3 z-10 max-w-2xl">
            <?php if (isset($_SESSION['user_id'])): ?>
                <span class="inline-block bg-emerald-50 text-emerald-700 text-xs font-bold px-3.5 py-1.5 rounded-full uppercase tracking-wider border border-emerald-200/60">Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
            <?php else: ?>
                <span class="inline-block bg-indigo-50 text-indigo-600 text-xs font-bold px-3.5 py-1.5 rounded-full uppercase tracking-wider border border-indigo-200/60">Myanmar High School Curriculum (Grades 10–12)</span>
            <?php endif; ?>
            <h1 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight">Physics Mechanics <span class="bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">Dashboard</span></h1>
            <p class="text-slate-500 text-sm sm:text-base leading-relaxed">Your hub for curriculum chapters, virtual labs, and theory reference across Grades 10, 11, and 12.</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 z-10 w-full md:w-auto">
            <a href="lab.php" class="inline-flex justify-center items-center px-6 py-3.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-lg shadow-indigo-200 transition-all">Open Labs &rarr;</a>
            <a href="theory.php" class="inline-flex justify-center items-center px-6 py-3.5 rounded-2xl bg-white hover:bg-slate-50 border border-indigo-200 text-slate-700 font-bold text-sm transition-all">Theory Notes &rarr;</a>
        </div>
    </div>

    <section class="space-y-6">
        <div class="flex items-center justify-between border-b border-indigo-100 pb-4">
            <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Quick Launch — Simulation Modules</h2>
            <a href="lab.php" class="text-xs font-bold text-indigo-600 hover:underline">View all &rarr;</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <?php foreach (array_slice($activeLabs, 0, 4) as $lab): ?>
                <a href="<?php echo htmlspecialchars($lab['href']); ?>" class="bg-white p-5 rounded-2xl border border-[#CEB5EF]/40 hover:border-indigo-500 transition-all shadow-sm hover:shadow-md group">
                    <span class="text-xl"><?php echo $lab['icon']; ?></span>
                    <h3 class="font-bold text-slate-900 text-sm mt-2 group-hover:text-indigo-600 transition-colors"><?php echo htmlspecialchars($lab['title']); ?></h3>
                    <p class="text-[10px] font-mono text-indigo-600 mt-1"><?php echo htmlspecialchars($lab['badge']); ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <?php foreach ($curriculum as $section): ?>
        <?php $colors = burmalab_grade_colors($section['color']); ?>
        <section class="space-y-6 <?php echo $section['grade'] !== '10' ? 'pt-4' : ''; ?>">
            <div class="flex items-center justify-between border-b <?php echo $colors['border']; ?> pb-4">
                <div class="flex items-center gap-3">
                    <span class="<?php echo $colors['badge']; ?> text-white font-extrabold text-xs px-3.5 py-1.5 rounded-xl uppercase tracking-wider shadow-sm"><?php echo htmlspecialchars($section['label']); ?></span>
                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Mechanics Curriculum Overview</h2>
                </div>
                <span class="text-xs font-mono font-bold text-slate-500">Chapters <?php echo htmlspecialchars($section['chapters']); ?></span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-<?php echo count($section['items']) === 4 ? '2' : '3'; ?> gap-6">
                <?php foreach ($section['items'] as $chapter): ?>
                    <div class="bg-white p-7 rounded-[28px] border border-[#CEB5EF]/40 shadow-sm space-y-3">
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
