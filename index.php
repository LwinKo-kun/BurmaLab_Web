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
    <title>BurmaLab - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F4F4FF] text-slate-800 min-h-screen p-6">
    <div class="max-w-6xl mx-auto space-y-6">
        
        <!-- Include Navbar -->
        <?php include 'includes/nav.php'; ?>

        <!-- Welcome Banner -->
        <div class="bg-white p-8 rounded-2xl border border-[#CEB5FF]/50 shadow-lg shadow-[#CEB5FF]/10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900">Welcome back, <span class="text-[#5580E9]"><?php echo htmlspecialchars($_SESSION['username']); ?></span>!</h1>
                <p class="text-slate-500 mt-1">Select an interactive physics simulation module below to begin your experiment.</p>
            </div>
            <div class="bg-[#F4F4FF] border border-[#D3D3FF] px-4 py-2 rounded-xl text-sm text-[#5580E9] font-semibold">
                Status: Active Session
            </div>
        </div>

        <!-- Labs Grid Section -->
        <section id="labs" class="space-y-4 pt-4">
            <h2 class="text-xl font-bold text-slate-700">Interactive Physics Labs</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <a href="projectile.html" class="bg-white p-6 rounded-2xl border border-[#D3D3FF] hover:border-[#80A8FF] hover:shadow-xl hover:shadow-[#8EC1DE]/20 hover:-translate-y-1 transition-all group">
                    <h3 class="text-lg font-bold text-[#5580E9] group-hover:text-[#3B66DB] mb-2">Projectile Motion</h3>
                    <p class="text-sm text-slate-600">Explore trajectory, launch angles, and gravity vectors.</p>
                </a>

                <a href="friction.html" class="bg-white p-6 rounded-2xl border border-[#D3D3FF] hover:border-[#80A8FF] hover:shadow-xl hover:shadow-[#8EC1DE]/20 hover:-translate-y-1 transition-all group">
                    <h3 class="text-lg font-bold text-[#5580E9] group-hover:text-[#3B66DB] mb-2">Friction Dynamics</h3>
                    <p class="text-sm text-slate-600">Analyze surface resistance and motion coefficients.</p>
                </a>

                <a href="incline.html" class="bg-white p-6 rounded-2xl border border-[#D3D3FF] hover:border-[#80A8FF] hover:shadow-xl hover:shadow-[#8EC1DE]/20 hover:-translate-y-1 transition-all group">
                    <h3 class="text-lg font-bold text-[#5580E9] group-hover:text-[#3B66DB] mb-2">Incline Plane</h3>
                    <p class="text-sm text-slate-600">Study force breakdowns on objects sliding down slopes.</p>
                </a>

                <a href="atwood-incline.html" class="bg-white p-6 rounded-2xl border border-[#D3D3FF] hover:border-[#80A8FF] hover:shadow-xl hover:shadow-[#8EC1DE]/20 hover:-translate-y-1 transition-all group">
                    <h3 class="text-lg font-bold text-[#5580E9] group-hover:text-[#3B66DB] mb-2">Atwood Machine</h3>
                    <p class="text-sm text-slate-600">Examine tension and system acceleration with connected masses.</p>
                </a>

                <a href="double-pulley.html" class="bg-white p-6 rounded-2xl border border-[#D3D3FF] hover:border-[#80A8FF] hover:shadow-xl hover:shadow-[#8EC1DE]/20 hover:-translate-y-1 transition-all group">
                    <h3 class="text-lg font-bold text-[#5580E9] group-hover:text-[#3B66DB] mb-2">Double Pulley</h3>
                    <p class="text-sm text-slate-600">Investigate mechanical advantage using multiple pulleys.</p>
                </a>

                <a href="newtons-second-law.html" class="bg-white p-6 rounded-2xl border border-[#D3D3FF] hover:border-[#80A8FF] hover:shadow-xl hover:shadow-[#8EC1DE]/20 hover:-translate-y-1 transition-all group">
                    <h3 class="text-lg font-bold text-[#5580E9] group-hover:text-[#3B66DB] mb-2">Newton's Second Law</h3>
                    <p class="text-sm text-slate-600">Test the core mathematical relationship of force, mass, and acceleration ($F = ma$).</p>
                </a>

                <a href="collisions.html" class="bg-white p-6 rounded-2xl border border-[#D3D3FF] hover:border-[#80A8FF] hover:shadow-xl hover:shadow-[#8EC1DE]/20 hover:-translate-y-1 transition-all group">
                    <h3 class="text-lg font-bold text-[#5580E9] group-hover:text-[#3B66DB] mb-2">Collisions</h3>
                    <p class="text-sm text-slate-600">Observe momentum and energy transfer in 2D elastic/inelastic collisions.</p>
                </a>

            </div>
        </section>

    </div>
</body>
</html>