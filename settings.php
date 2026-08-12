<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - BurmaLab</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F4F4FF] text-slate-800 font-sans antialiased min-h-screen flex flex-col justify-between">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 space-y-8 flex-grow">
        
        <?php include 'includes/nav.php'; ?>

        <div class="bg-white p-6 sm:p-10 rounded-3xl border border-[#CEB5FF]/40 shadow-xl shadow-[#CEB5FF]/10 space-y-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Account Settings</h1>
                <p class="text-slate-500 text-sm mt-1">Manage your user profile credentials and sandbox configurations.</p>
            </div>

            <div class="border-t border-slate-100 pt-6 space-y-6 max-w-xl">
                <div>
                    <label class="block text-xs font-mono uppercase tracking-wider text-slate-400 mb-2">Username</label>
                    <input type="text" disabled value="<?php echo htmlspecialchars($_SESSION['username']); ?>" class="w-full bg-[#F8F7FF] border border-[#CEB5FF]/40 rounded-xl px-4 py-3 text-slate-700 text-sm focus:outline-none cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-xs font-mono uppercase tracking-wider text-slate-400 mb-2">User ID</label>
                    <input type="text" disabled value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>" class="w-full bg-[#F8F7FF] border border-[#CEB5FF]/40 rounded-xl px-4 py-3 text-slate-700 text-sm focus:outline-none cursor-not-allowed">
                </div>
            </div>
        </div>
    </div>

    <footer class="w-full px-6 py-8 border-t border-[#CEB5FF]/40 text-center bg-white/50 text-slate-400 text-xs">
        &copy; 2026 BurmaLab. Built for student exploration.
    </footer>
</body>
</html>