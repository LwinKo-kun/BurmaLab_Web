<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$pageTitle = 'Settings - BurmaLab';
include 'includes/head.php';
?>

<?php include 'includes/nav.php'; ?>

<div class="w-full max-w-[1440px] mx-auto px-6 sm:px-10 lg:px-16 py-8 flex-grow">
    <div class="max-w-2xl mx-auto bg-white p-6 sm:p-10 rounded-[32px] border border-[#CEB5EF]/40 shadow-xl shadow-indigo-100/30 space-y-8">
        <div>
            <span class="inline-block bg-indigo-50 text-indigo-600 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider border border-indigo-200/60 mb-3">Account</span>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900">Settings</h1>
            <p class="text-slate-500 text-sm mt-1">Manage your profile and sandbox preferences.</p>
        </div>

        <div class="border-t border-slate-100 pt-6 space-y-6">
            <div>
                <label class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-400 mb-2">Username</label>
                <input type="text" disabled value="<?php echo htmlspecialchars($_SESSION['username']); ?>" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-slate-700 text-sm cursor-not-allowed">
            </div>
            <div>
                <label class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-400 mb-2">User ID</label>
                <input type="text" disabled value="<?php echo htmlspecialchars((string) $_SESSION['user_id']); ?>" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-slate-700 text-sm cursor-not-allowed">
            </div>
        </div>

        <div class="pt-4 flex gap-3">
            <a href="index.php" class="px-5 py-3 rounded-2xl bg-indigo-600 text-white text-sm font-bold hover:bg-indigo-700 transition">Go to Dashboard</a>
            <a href="lab.php" class="px-5 py-3 rounded-2xl bg-white border border-indigo-200 text-indigo-600 text-sm font-bold hover:bg-indigo-50 transition">Open Labs</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
