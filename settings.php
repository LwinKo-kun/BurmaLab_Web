<?php
/**
 * BurmaLab - Account Settings & Sandbox Preferences Page
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/progress.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit();
}

$user_id = (int)$_SESSION['user_id'];
$user_stats = get_user_stats($pdo, $user_id);
$feedback_message = '';
$feedback_type = '';

// Handle Preference Updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'save_preferences') {
        $_SESSION['pref_fps_target'] = $_POST['fps_target'] ?? '60';
        $_SESSION['pref_vector_color'] = $_POST['vector_color'] ?? 'indigo';
        $feedback_message = 'Sandbox preferences updated successfully!';
        $feedback_type = 'success';
    }
}

$pageTitle = 'Account Settings - BurmaLab';
include 'includes/head.php';
include 'includes/nav.php';
?>

<div class="w-full max-w-[1440px] mx-auto px-4 sm:px-10 lg:px-16 py-10 flex-grow flex items-center justify-center">
    <div class="w-full max-w-3xl bg-white p-6 sm:p-12 rounded-3xl sm:rounded-[36px] border border-[#CEB5EF]/40 shadow-2xl shadow-indigo-100/40 space-y-8">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-6 border-b border-slate-100">
            <div>
                <span class="inline-block bg-indigo-50 text-indigo-600 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider border border-indigo-200/60 mb-2">Account Management</span>
                <h1 class="text-3xl font-black text-slate-900">Settings & Preferences</h1>
                <p class="text-slate-500 text-sm mt-1">Manage your student profile, lab rendering options, and account stats.</p>
            </div>
            <div class="flex items-center gap-3 bg-slate-50 border border-slate-200 px-4 py-2.5 rounded-2xl">
                <div class="w-9 h-9 bg-indigo-600 text-white font-black rounded-xl flex items-center justify-center text-sm shadow-md">
                    <?php echo strtoupper(substr($_SESSION['username'] ?? 'U', 0, 1)); ?>
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-mono">Student Account</p>
                    <p class="text-sm font-bold text-slate-900"><?php echo htmlspecialchars($_SESSION['username']); ?></p>
                </div>
            </div>
        </div>

        <?php if ($feedback_message): ?>
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-bold flex items-center gap-2">
                <span>✓</span> <?php echo htmlspecialchars($feedback_message); ?>
            </div>
        <?php endif; ?>

        <!-- Form Section 1: User Credentials -->
        <div class="space-y-4">
            <h2 class="text-lg font-extrabold text-slate-900">Profile Credentials</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-400 mb-2">Username</label>
                    <input type="text" disabled value="<?php echo htmlspecialchars($_SESSION['username']); ?>" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-slate-700 text-sm cursor-not-allowed font-medium">
                </div>
                <div>
                    <label class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-400 mb-2">Student ID</label>
                    <input type="text" disabled value="#BL-<?php echo str_pad((string)$user_id, 5, '0', STR_PAD_LEFT); ?>" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-slate-700 text-sm cursor-not-allowed font-medium font-mono">
                </div>
            </div>
        </div>

        <!-- Form Section 2: Gamification Stats Overview -->
        <div class="p-6 bg-gradient-to-br from-indigo-50/50 to-violet-50/30 border border-indigo-100 rounded-3xl space-y-3">
            <h2 class="text-xs font-mono font-bold uppercase text-indigo-600 tracking-wider">Gamification Summary</h2>
            <div class="grid grid-cols-3 gap-4 text-center">
                <div class="bg-white p-3 rounded-2xl border border-indigo-100">
                    <p class="text-xs text-slate-400 font-bold">XP Points</p>
                    <p class="text-xl font-black text-violet-600 mt-1"><?php echo $user_stats['xp']; ?></p>
                </div>
                <div class="bg-white p-3 rounded-2xl border border-indigo-100">
                    <p class="text-xs text-slate-400 font-bold">Streak</p>
                    <p class="text-xl font-black text-orange-500 mt-1"><?php echo $user_stats['streak']; ?>d</p>
                </div>
                <div class="bg-white p-3 rounded-2xl border border-indigo-100">
                    <p class="text-xs text-slate-400 font-bold">Labs Done</p>
                    <p class="text-xl font-black text-emerald-600 mt-1"><?php echo $user_stats['completed_labs']; ?></p>
                </div>
            </div>
        </div>

        <!-- Form Section 3: Lab Physics Simulation Preferences -->
        <form method="POST" class="space-y-6 pt-2">
            <input type="hidden" name="action" value="save_preferences">
            <h2 class="text-lg font-extrabold text-slate-900">Lab Engine Preferences</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-500 mb-2">Matter.js Frame Target</label>
                    <select name="fps_target" class="w-full bg-white border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 rounded-2xl px-4 py-3.5 text-slate-800 text-sm font-semibold transition">
                        <option value="60" <?php echo ($_SESSION['pref_fps_target'] ?? '60') === '60' ? 'selected' : ''; ?>>60 FPS (Smooth / Desktop)</option>
                        <option value="30" <?php echo ($_SESSION['pref_fps_target'] ?? '') === '30' ? 'selected' : ''; ?>>30 FPS (Battery Saver / Mobile)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-500 mb-2">Force Vector Overlay Accent</label>
                    <select name="vector_color" class="w-full bg-white border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 rounded-2xl px-4 py-3.5 text-slate-800 text-sm font-semibold transition">
                        <option value="indigo" <?php echo ($_SESSION['pref_vector_color'] ?? 'indigo') === 'indigo' ? 'selected' : ''; ?>>Indigo (Standard)</option>
                        <option value="emerald" <?php echo ($_SESSION['pref_vector_color'] ?? '') === 'emerald' ? 'selected' : ''; ?>>High-Contrast Emerald</option>
                    </select>
                </div>
            </div>

            <div class="pt-4 flex flex-col sm:flex-row gap-3">
                <button type="submit" class="w-full sm:w-auto px-6 py-3.5 rounded-2xl bg-indigo-600 text-white text-sm font-extrabold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 active:scale-95">
                    Save Preferences
                </button>
                <a href="/home" class="w-full sm:w-auto text-center px-6 py-3.5 rounded-2xl bg-slate-100 border border-slate-200 text-slate-700 text-sm font-bold hover:bg-slate-200 transition">
                    Return to Dashboard
                </a>
            </div>
        </form>

    </div>
</div>

<?php include 'includes/footer.php'; ?>