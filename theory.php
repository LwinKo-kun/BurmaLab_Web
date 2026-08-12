<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/curriculum.php';
$pageTitle = 'Theory Notes - BurmaLab';
include 'includes/head.php';
?>

<?php include 'includes/nav.php'; ?>

<div class="w-full max-w-[1440px] mx-auto px-6 sm:px-10 lg:px-16 py-8 space-y-10 flex-grow">

    <div class="bg-white p-6 sm:p-10 rounded-[32px] border border-[#CEB5EF]/40 shadow-xl shadow-indigo-100/30 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-gradient-to-br from-indigo-500/10 to-violet-500/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="space-y-2 z-10">
            <span class="inline-block bg-indigo-50 text-indigo-600 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider border border-indigo-200/60">Reference Manual</span>
            <h1 class="text-2xl sm:text-4xl font-black text-slate-900">Physics Theory & <span class="bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">Key Formulas</span></h1>
            <p class="text-slate-500 text-sm sm:text-base max-w-2xl leading-relaxed">Essential equations and concepts for the Myanmar High School Mechanics Curriculum — Grades 10 through 12.</p>
        </div>
        <a href="index.php" class="bg-slate-50/80 border border-slate-200/60 px-5 py-3 rounded-2xl text-sm font-bold text-indigo-600 hover:bg-indigo-50 transition z-10">Full Curriculum Index &rarr;</a>
    </div>

    <?php foreach ($theoryNotes as $section): ?>
        <?php $colors = burmalab_grade_colors($section['color']); ?>
        <section class="space-y-6">
            <div class="flex items-center gap-3 border-b <?php echo $colors['border']; ?> pb-4">
                <span class="<?php echo $colors['badge']; ?> text-white font-extrabold text-xs px-3 py-1.5 rounded-xl uppercase tracking-wider shadow-sm">Grade <?php echo htmlspecialchars($section['grade']); ?></span>
                <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Core Formulas</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php foreach ($section['topics'] as $topic): ?>
                    <div class="p-7 bg-white rounded-[28px] border border-[#CEB5EF]/40 shadow-sm space-y-4">
                        <h3 class="font-bold text-slate-900 text-lg"><?php echo htmlspecialchars($topic['title']); ?></h3>
                        <ul class="space-y-2">
                            <?php foreach ($topic['formulas'] as $formula): ?>
                                <li class="font-mono text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-indigo-700"><?php echo htmlspecialchars($formula); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endforeach; ?>

    <section class="space-y-6 pt-4">
        <div class="flex items-center gap-3 border-b border-indigo-100 pb-4">
            <span class="bg-indigo-600 text-white font-extrabold text-xs px-3 py-1.5 rounded-xl uppercase tracking-wider shadow-sm">Syllabus Map</span>
            <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Chapter Overview</h2>
        </div>
        <?php foreach ($curriculum as $section): ?>
            <?php $colors = burmalab_grade_colors($section['color']); ?>
            <div class="mb-8">
                <p class="text-sm font-bold text-slate-600 mb-4"><?php echo htmlspecialchars($section['label']); ?> — Chapters <?php echo htmlspecialchars($section['chapters']); ?></p>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php foreach ($section['items'] as $chapter): ?>
                        <div class="p-5 bg-white rounded-2xl border border-[#CEB5EF]/40 shadow-sm">
                            <span class="text-[10px] font-mono font-bold <?php echo $colors['chip']; ?> px-2 py-0.5 rounded border">Ch. <?php echo $chapter['num']; ?></span>
                            <h4 class="font-bold text-slate-900 mt-2"><?php echo htmlspecialchars($chapter['title']); ?></h4>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed"><?php echo htmlspecialchars($chapter['desc']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </section>

</div>

<?php include 'includes/footer.php'; ?>
