<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_once 'includes/curriculum.php';
require_once 'includes/progress.php';

$userId = $_SESSION['user_id'] ?? null;
$pageTitle = 'Theory Notes - BurmaLab';

include 'includes/head.php';
include 'includes/nav.php';
?>

<div class="w-full max-w-[1440px] mx-auto px-4 sm:px-10 lg:px-16 py-8 space-y-8 sm:space-y-10 flex-grow">

    <div class="bg-white p-6 sm:p-10 rounded-3xl sm:rounded-[32px] border border-[#CEB5EF]/40 shadow-xl shadow-indigo-100/30 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-gradient-to-br from-indigo-500/10 to-violet-500/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="space-y-2 z-10">
            <span class="inline-block bg-indigo-50 text-indigo-600 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider border border-indigo-200/60">Reference Manual</span>
            <h1 class="text-2xl sm:text-4xl font-black text-slate-900">Physics Theory & <span class="bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">Key Formulas</span></h1>
            <p class="text-slate-500 text-sm sm:text-base max-w-2xl leading-relaxed">Essential equations and concepts for the Myanmar High School Mechanics Curriculum — Grades 10 through 12.</p>
        </div>
        <a href="/home" class="bg-slate-50/80 border border-slate-200/60 px-5 py-3 rounded-2xl text-sm font-bold text-indigo-600 hover:bg-indigo-50 transition z-10 text-center">Full Curriculum Index &rarr;</a>
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
                    <div class="p-6 sm:p-7 bg-white rounded-2xl sm:rounded-[28px] border border-[#CEB5EF]/40 shadow-sm space-y-4">
                        <h3 class="font-bold text-slate-900 text-lg"><?php echo htmlspecialchars($topic['title']); ?></h3>
                        <ul class="space-y-2">
                            <?php foreach ($topic['formulas'] as $formula): ?>
                                <li class="font-mono text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-indigo-700"><?php echo htmlspecialchars($formula); ?></li>
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
                        <?php 
                            // Extract grade number (e.g., "Grade 11 Mechanics" -> 11)
                            preg_match('/\d+/', $section['label'], $matches);
                            $gradeNum = $matches[0] ?? '0'; 
                            
                            // Generate unique ID like 'g11_ch_1'
                            $chapterId = 'g' . $gradeNum . '_ch_' . $chapter['num'];
                            $isDone = $userId ? is_item_completed($pdo, $userId, 'chapter', $chapterId) : false;
                        ?>
                        <div class="p-5 bg-white rounded-2xl border <?php echo $isDone ? 'border-emerald-300 bg-emerald-50/20' : 'border-[#CEB5EF]/40'; ?> shadow-sm flex flex-col justify-between gap-4">
                            <div>
                                <span class="text-[10px] font-mono font-bold <?php echo $colors['chip']; ?> px-2 py-0.5 rounded border">Ch. <?php echo $chapter['num']; ?></span>
                                <h4 class="font-bold text-slate-900 mt-2"><?php echo htmlspecialchars($chapter['title']); ?></h4>
                                <p class="text-xs text-slate-500 mt-1 leading-relaxed"><?php echo htmlspecialchars($chapter['desc']); ?></p>
                            </div>

                            <?php if ($userId): ?>
                                <button onclick="markChapterRead('<?php echo $chapterId; ?>', this)" 
                                        class="w-full py-2.5 px-3 rounded-xl text-xs font-bold transition-all <?php echo $isDone ? 'bg-emerald-100 text-emerald-800 cursor-default' : 'bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white border border-indigo-200'; ?>"
                                        <?php echo $isDone ? 'disabled' : ''; ?>>
                                    <?php echo $isDone ? '✓ Completed (+20 XP)' : 'Mark as Read (+20 XP)'; ?>
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </section>

</div>

<script>
async function markChapterRead(chapterId, btn) {
    btn.disabled = true;
    btn.innerText = 'Updating...';

    try {
        // Clean URL to route through index.php
        const res = await fetch('/api/progress', { 
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ item_type: 'chapter', item_identifier: chapterId })
        });
        
        if (!res.ok) {
            throw new Error(`HTTP error! status: ${res.status}`);
        }
        
        const data = await res.json();

        if (data.success) {
            btn.className = 'w-full py-2.5 px-3 rounded-xl text-xs font-bold bg-emerald-100 text-emerald-800 cursor-default';
            btn.innerText = '✓ Completed (+20 XP)';
        } else {
            btn.innerText = 'Mark as Read (+20 XP)';
            btn.disabled = false;
            console.error('API Error:', data.message || 'Unknown error');
        }
    } catch (e) {
        console.error('Fetch failed:', e);
        btn.innerText = 'Error. Retry?';
        btn.disabled = false;
    }
}
</script>

<?php include 'includes/footer.php'; ?>