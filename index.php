<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pageTitle = "Curriculum Index - BurmaLab";
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
        
        <!-- Hero Banner -->
        <div class="bg-white p-6 sm:p-12 rounded-[32px] border border-[#CEB5EF]/45 shadow-xl shadow-indigo-100/30 flex flex-col md:flex-row justify-between items-start md:items-center gap-8 relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-gradient-to-br from-indigo-500/10 to-violet-500/5 rounded-full blur-3xl pointer-events-none"></div>
            <div class="space-y-3 z-10 max-w-2xl">
                <span class="inline-block bg-indigo-50 text-indigo-600 text-xs font-bold px-3.5 py-1.5 rounded-full uppercase tracking-wider border border-indigo-200/60">Myanmar High School Curriculum (Grades 10–12)</span>
                <h1 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight">Physics Mechanics <span class="bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">Curriculum Index</span></h1>
                <p class="text-slate-500 text-sm sm:text-base leading-relaxed">Explore the complete breakdown of chapters, principles, and foundational concepts across Grades 10, 11, and 12.</p>
            </div>
            <div class="bg-slate-50/90 border border-slate-200/60 p-5 rounded-2xl flex items-center space-x-4 z-10 w-full md:w-auto backdrop-blur-sm shadow-sm">
                <div class="w-3.5 h-3.5 bg-indigo-500 rounded-full animate-pulse flex-shrink-0"></div>
                <div class="text-sm">
                    <p class="text-slate-400 text-xs font-medium">Syllabus Scope</p>
                    <p class="text-slate-800 font-bold">Grades 10–12 Mechanics</p>
                </div>
            </div>
        </div>

        <!-- Grade 10 Mechanics -->
        <section class="space-y-6">
            <div class="flex items-center justify-between border-b border-indigo-100 pb-4">
                <div class="flex items-center gap-3">
                    <span class="bg-indigo-600 text-white font-extrabold text-xs px-3.5 py-1.5 rounded-xl uppercase tracking-wider shadow-sm">Grade 10</span>
                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Mechanics Curriculum Overview</h2>
                </div>
                <span class="text-xs font-mono font-bold text-slate-500">Chapters 1–4</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-7 rounded-[28px] border border-[#CEB5EF]/40 shadow-sm space-y-3">
                    <span class="text-xs font-mono font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg border border-indigo-100">Chapter 1</span>
                    <h3 class="font-bold text-slate-900 text-lg">Units and Measurements</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Basic and Derived Units, System of Units, Prefixes, Standards and Units, Measurement of Length, Mass, and Time.</p>
                </div>
                <div class="bg-white p-7 rounded-[28px] border border-[#CEB5EF]/40 shadow-sm space-y-3">
                    <span class="text-xs font-mono font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg border border-indigo-100">Chapter 2</span>
                    <h3 class="font-bold text-slate-900 text-lg">Motion</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Vectors, Describing Motion, Equations of Motion, and Motion Graphs.</p>
                </div>
                <div class="bg-white p-7 rounded-[28px] border border-[#CEB5EF]/40 shadow-sm space-y-3">
                    <span class="text-xs font-mono font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg border border-indigo-100">Chapter 3</span>
                    <h3 class="font-bold text-slate-900 text-lg">Forces</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Newton's Laws of Motion, Gravitational Force & Law of Gravitation, Different Kinds of Forces, Mass and Weight, Freely Falling Bodies, Momentum, and Law of Conservation of Momentum.</p>
                </div>
                <div class="bg-white p-7 rounded-[28px] border border-[#CEB5EF]/40 shadow-sm space-y-3">
                    <span class="text-xs font-mono font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg border border-indigo-100">Chapter 4</span>
                    <h3 class="font-bold text-slate-900 text-lg">Pressure</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Pressure, Density, Relative Density (or Specific Gravity), and Hydrometer.</p>
                </div>
            </div>
        </section>

        <!-- Grade 11 Mechanics -->
        <section class="space-y-6 pt-4">
            <div class="flex items-center justify-between border-b border-violet-100 pb-4">
                <div class="flex items-center gap-3">
                    <span class="bg-violet-600 text-white font-extrabold text-xs px-3.5 py-1.5 rounded-xl uppercase tracking-wider shadow-sm">Grade 11</span>
                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Mechanics Curriculum Overview</h2>
                </div>
                <span class="text-xs font-mono font-bold text-slate-500">Chapters 1–3</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-7 rounded-[28px] border border-[#CEB5EF]/40 shadow-sm space-y-3">
                    <span class="text-xs font-mono font-bold text-violet-600 bg-violet-50 px-2.5 py-1 rounded-lg border border-violet-100">Chapter 1</span>
                    <h3 class="font-bold text-slate-900 text-lg">Motion in a Plane</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Two-Dimensional Motion, Projectile Motion, and Circular Motion.</p>
                </div>
                <div class="bg-white p-7 rounded-[28px] border border-[#CEB5EF]/40 shadow-sm space-y-3">
                    <span class="text-xs font-mono font-bold text-violet-600 bg-violet-50 px-2.5 py-1 rounded-lg border border-violet-100">Chapter 2</span>
                    <h3 class="font-bold text-slate-900 text-lg">Rotational Dynamics</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Scalar Product and Vector Product, Turning Effect of Force, Relation Between Torque and Moment of Inertia, Equilibrium, Angular Momentum and Law of Conservation of Angular Momentum.</p>
                </div>
                <div class="bg-white p-7 rounded-[28px] border border-[#CEB5EF]/40 shadow-sm space-y-3">
                    <span class="text-xs font-mono font-bold text-violet-600 bg-violet-50 px-2.5 py-1 rounded-lg border border-violet-100">Chapter 3</span>
                    <h3 class="font-bold text-slate-900 text-lg">Pressure</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Atmospheric Pressure, Barometer, Pressure in a Liquid, Manometer, Archimedes' Principle, and Pascal's Law.</p>
                </div>
            </div>
        </section>

        <!-- Grade 12 Mechanics -->
        <section class="space-y-6 pt-4">
            <div class="flex items-center justify-between border-b border-purple-100 pb-4">
                <div class="flex items-center gap-3">
                    <span class="bg-purple-600 text-white font-extrabold text-xs px-3.5 py-1.5 rounded-xl uppercase tracking-wider shadow-sm">Grade 12</span>
                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Mechanics Curriculum Overview</h2>
                </div>
                <span class="text-xs font-mono font-bold text-slate-500">Chapters 1–3</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-7 rounded-[28px] border border-[#CEB5EF]/40 shadow-sm space-y-3">
                    <span class="text-xs font-mono font-bold text-purple-600 bg-purple-50 px-2.5 py-1 rounded-lg border border-purple-100">Chapter 1</span>
                    <h3 class="font-bold text-slate-900 text-lg">Rotational Motion</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Rotational Motion Under Constant Angular Acceleration, Relations Between Linear and Angular Quantities, and Centripetal Acceleration.</p>
                </div>
                <div class="bg-white p-7 rounded-[28px] border border-[#CEB5EF]/40 shadow-sm space-y-3">
                    <span class="text-xs font-mono font-bold text-purple-600 bg-purple-50 px-2.5 py-1 rounded-lg border border-purple-100">Chapter 2</span>
                    <h3 class="font-bold text-slate-900 text-lg">Forces in Circular Motion</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Forces Causing Centripetal Acceleration, Centripetal and Centrifugal Forces.</p>
                </div>
                <div class="bg-white p-7 rounded-[28px] border border-[#CEB5EF]/40 shadow-sm space-y-3">
                    <span class="text-xs font-mono font-bold text-purple-600 bg-purple-50 px-2.5 py-1 rounded-lg border border-purple-100">Chapter 3</span>
                    <h3 class="font-bold text-slate-900 text-lg">Fluid Dynamics</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Laminar and Turbulent Flow, Equation of Continuity for Fluids, Bernoulli's Equation, Manifestations of Bernoulli's Theorem, Viscosity (Fluid Friction), Surface Tension and Capillarity.</p>
                </div>
            </div>
        </section>

    </div>

    <footer class="w-full px-6 py-8 border-t border-[#CEB5EF]/40 text-center bg-white/70 backdrop-blur-md text-slate-400 text-xs font-medium">
        &copy; 2026 BurmaLab. Built for Myanmar high school student exploration.
    </footer>
</body>
</html>