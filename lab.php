<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pageTitle = "Interactive Physics Labs - BurmaLab";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#F6F6FF] text-slate-800 antialiased min-h-screen flex flex-col justify-between selection:bg-indigo-500 selection:text-white">

    <!-- Global Navigation Header -->
    <?php include 'includes/nav.php'; ?>

    <div class="w-full max-w-[1440px] mx-auto px-6 sm:px-10 lg:px-16 py-8 space-y-12 flex-grow">
        
        <!-- Labs Banner -->
        <div class="bg-white p-6 sm:p-12 rounded-[32px] border border-[#CEB5EF]/45 shadow-xl shadow-indigo-100/30 flex flex-col md:flex-row justify-between items-start md:items-center gap-8 relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-gradient-to-br from-indigo-500/10 to-violet-500/5 rounded-full blur-3xl pointer-events-none"></div>
            <div class="space-y-3 z-10 max-w-2xl">
                <span class="inline-block bg-indigo-50 text-indigo-600 text-xs font-bold px-3.5 py-1.5 rounded-full uppercase tracking-wider border border-indigo-200/60">Virtual Simulations</span>
                <h1 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight">Interactive Physics <span class="bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">Laboratories</span></h1>
                <p class="text-slate-500 text-sm sm:text-base leading-relaxed">Launch active Matter.js simulation modules to test equations of motion, forces, and collisions in real-time.</p>
            </div>
            <div class="bg-slate-50/90 border border-slate-200/60 p-5 rounded-2xl flex items-center space-x-4 z-10 w-full md:w-auto backdrop-blur-sm shadow-sm">
                <div class="w-3.5 h-3.5 bg-emerald-500 rounded-full animate-pulse flex-shrink-0"></div>
                <div class="text-sm">
                    <p class="text-slate-400 text-xs font-medium">Engine Status</p>
                    <p class="text-slate-800 font-bold">Matter.js Ready</p>
                </div>
            </div>
        </div>

        <!-- Labs Grid -->
        <section class="space-y-6">
            <div class="flex items-center justify-between border-b border-indigo-100 pb-4">
                <div class="flex items-center gap-3">
                    <span class="bg-indigo-600 text-white font-extrabold text-xs px-3.5 py-1.5 rounded-xl uppercase tracking-wider shadow-sm">Active Labs</span>
                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Available Simulation Modules</h2>
                </div>
                <span class="text-xs font-mono font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-xl border border-indigo-200/60">7 Modules</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php
                $activeLabs = [
                    ["href" => "newtons-second-law.html", "title" => "Newton's Second Law", "desc" => "Test the mathematical relationship between force, mass, and acceleration ($F = ma$).", "badge" => "Grade 10 Ch.3", "icon" => "⚡"],
                    ["href" => "collisions.html", "title" => "Momentum & Collisions", "desc" => "Observe momentum conservation and energy transfer in 2D collision events.", "badge" => "Grade 10 Ch.3", "icon" => "💥"],
                    ["href" => "friction.html", "title" => "Friction Dynamics", "desc" => "Analyze surface resistance and motion coefficients on sliding masses.", "badge" => "Grade 10 Ch.3", "icon" => "🪵"],
                    ["href" => "projectile.html", "title" => "Projectile Motion", "desc" => "Explore 2D trajectories, launch angles, and gravitational vector components.", "badge" => "Grade 11 Ch.1", "icon" => "🎯"],
                    ["href" => "atwood-incline.html", "title" => "Atwood Machine", "desc" => "Examine string tension and system acceleration with connected hanging masses.", "badge" => "Grade 11 Ch.2", "icon" => "⚖️"],
                    ["href" => "double-pulley.html", "title" => "Double Pulley System", "desc" => "Investigate mechanical advantage and torque using multi-pulley rigs.", "badge" => "Grade 11 Ch.2", "icon" => "⚙️"],
                    ["href" => "incline.html", "title" => "Incline Plane Forces", "desc" => "Study vector force breakdowns, normal force, and slope dynamics.", "badge" => "Grade 12 Ch.1-2", "icon" => "📐"]
                ];

                foreach($activeLabs as $lab) {
                    echo '
                    <a href="'.$lab['href'].'" class="bg-white hover:bg-slate-50/80 p-7 rounded-[28px] border border-[#CEB5EF]/40 hover:border-indigo-500 transition-all duration-300 shadow-sm hover:shadow-xl group flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <div class="w-12 h-12 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 text-xl font-bold shadow-sm group-hover:scale-110 transition-transform">'.$lab['icon'].'</div>
                                <span class="text-[10px] font-mono font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg border border-indigo-100">'.$lab['badge'].'</span>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 group-hover:text-indigo-600 mb-2.5 transition-colors">'.$lab['title'].'</h3>
                            <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">'.$lab['desc'].'</p>
                        </div>
                        <div class="mt-6 flex items-center text-xs font-bold text-indigo-600 group-hover:translate-x-1.5 transition-transform">
                            Launch Lab &rarr;
                        </div>
                    </a>';
                }
                ?>
            </div>
        </section>

    </div>

    <footer class="w-full px-6 py-8 border-t border-[#CEB5EF]/40 text-center bg-white/70 backdrop-blur-md text-slate-400 text-xs font-medium">
        &copy; 2026 BurmaLab. Built for Myanmar high school student exploration.
    </footer>
</body>
</html>