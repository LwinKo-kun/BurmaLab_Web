<?php
session_start();
$pageTitle = "BurmaLab | Advanced Virtual Physics & Science Suite";
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#F6F6FF] text-slate-800 antialiased selection:bg-indigo-500 selection:text-white min-h-screen flex flex-col justify-between overflow-x-hidden">

    <!-- Ambient Background Gradients -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1200px] h-[600px] bg-gradient-to-br from-indigo-300/30 via-violet-300/20 to-transparent rounded-full blur-[160px] pointer-events-none -z-10"></div>

    <!-- Global Navigation Header (Unified via nav.php) -->
    <?php include 'includes/nav.php'; ?>

    <!-- Main Content Layout -->
    <main class="w-full flex-grow space-y-36 pb-24">
        
        <!-- Hero Section -->
        <section class="w-full min-h-[85vh] flex flex-col items-center justify-center text-center px-6 sm:px-10 lg:px-16 pt-8 relative">
            <div class="max-w-5xl mx-auto space-y-8">
                
                <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-white border border-indigo-200 text-xs font-bold text-indigo-600 shadow-sm tracking-wide uppercase">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Matter.js Simulation & Analysis Kernel v2.4 Active
                </div>

                <h1 class="text-5xl sm:text-7xl lg:text-8xl font-black tracking-tight text-slate-900 leading-[1.05]">
                    Master Science Through <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-600">Virtual Experimentation</span>
                </h1>
                
                <p class="text-lg sm:text-2xl text-slate-500 max-w-3xl mx-auto font-normal leading-relaxed">
                    An advanced web-based STEM sandbox engineered for computer science and physics students. Simulate vector dynamics and precise scientific observations in real time.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4 w-full">
                    <a href="signup.php" class="w-full sm:w-auto inline-flex justify-center items-center px-10 py-5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-base transition-all shadow-xl shadow-indigo-200 active:scale-95">
                        Get Started Free &rarr;
                    </a>
                    <a href="theory.php" class="w-full sm:w-auto inline-flex justify-center items-center px-10 py-5 rounded-2xl bg-white hover:bg-slate-50 border border-indigo-200 text-slate-700 font-bold text-base transition-all shadow-sm active:scale-95">
                        Explore Theory Notes &rarr;
                    </a>
                </div>
            </div>

            <!-- Immersive Preview Deck -->
            <div class="w-full max-w-[1300px] mt-20 mx-auto rounded-[32px] p-3.5 bg-white/80 border border-indigo-100 backdrop-blur-2xl shadow-2xl shadow-indigo-100 relative group">
                <div class="rounded-[24px] overflow-hidden border border-indigo-100 bg-slate-50 aspect-[16/9] relative flex items-center justify-center">
                    <img src="assets/1.jpg" alt="Lab Rack Preview" class="w-full h-full object-cover transform scale-100 group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent flex items-end p-8 sm:p-12 text-left">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center w-full gap-6">
                            <div>
                                <span class="text-xs font-mono tracking-widest text-indigo-300 uppercase bg-white/10 px-3.5 py-1.5 rounded-lg border border-white/20">Live Workspace Canvas</span>
                                <h3 class="text-xl sm:text-3xl font-extrabold text-white mt-2">Quantitative Chemical Analysis & Test Tube Kinetics</h3>
                            </div>
                            <a href="index.php" class="px-6 py-3.5 rounded-xl bg-white hover:bg-slate-100 text-slate-900 text-sm font-bold shadow-lg transition-all flex-shrink-0">Launch Engine &rarr;</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Statistics Counter Bar -->
        <section class="w-full bg-white border-y border-[#CEB5EF]/40 py-16">
            <div class="max-w-[1440px] mx-auto px-6 sm:px-10 lg:px-16 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="space-y-1 border-r last:border-r-0 border-indigo-100">
                    <p class="text-4xl sm:text-5xl font-black text-indigo-600">7+</p>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Virtual Labs & Tools</p>
                </div>
                <div class="space-y-1 border-r last:border-r-0 border-indigo-100">
                    <p class="text-4xl sm:text-5xl font-black text-indigo-600">60 FPS</p>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Matter.js Engine</p>
                </div>
                <div class="space-y-1 border-r last:border-r-0 border-indigo-100">
                    <p class="text-4xl sm:text-5xl font-black text-indigo-600">100%</p>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Web Responsive</p>
                </div>
                <div class="space-y-1">
                    <p class="text-4xl sm:text-5xl font-black text-indigo-600">Free</p>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">For Student Guilds</p>
                </div>
            </div>
        </section>

        <!-- Visual Showcase Section -->
        <section class="w-full max-w-[1440px] mx-auto px-6 sm:px-10 lg:px-16 space-y-16">
            <div class="text-center max-w-3xl mx-auto space-y-3">
                <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-4 py-1.5 rounded-full border border-indigo-200">Precision Equipment</span>
                <h2 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight">From Macro Reactions to Micro Analysis</h2>
                <p class="text-slate-500 text-base">Bridging physical apparatus setups with digital precision to enhance student comprehension.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div class="bg-white p-8 sm:p-10 rounded-[32px] border border-[#CEB5EF]/40 shadow-xl shadow-indigo-100/30 space-y-6 flex flex-col justify-between">
                    <div class="rounded-2xl overflow-hidden border border-indigo-100 bg-slate-50 aspect-[16/10] relative">
                        <img src="assets/2.jpg" alt="Flask and Test Tube Rack" class="w-full h-full object-cover">
                    </div>
                    <div class="space-y-3">
                        <span class="text-xs font-mono font-bold text-indigo-600 uppercase tracking-wider">Module // Solution Prep</span>
                        <h3 class="text-2xl font-extrabold text-slate-900">Volumetric Glassware & Titration Racks</h3>
                        <p class="text-slate-500 text-base leading-relaxed">Simulate liquid volume measurements and multi-test-tube colorimetric reaction sequences seamlessly inside your browser.</p>
                    </div>
                </div>

                <div class="bg-white p-8 sm:p-10 rounded-[32px] border border-[#CEB5EF]/40 shadow-xl shadow-indigo-100/30 space-y-6 flex flex-col justify-between">
                    <div class="rounded-2xl overflow-hidden border border-indigo-100 bg-slate-50 aspect-[16/10] relative">
                        <img src="assets/3.jpg" alt="Microscope Analysis" class="w-full h-full object-cover">
                    </div>
                    <div class="space-y-3">
                        <span class="text-xs font-mono font-bold text-indigo-600 uppercase tracking-wider">Module // Microscopic Vision</span>
                        <h3 class="text-2xl font-extrabold text-slate-900">High-Magnification Optical Inspection</h3>
                        <p class="text-slate-500 text-base leading-relaxed">Examine cellular structures, crystal formations, and specimen slides through dual optical ocular lenses with interactive focal adjustments.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Bento Grid -->
        <section class="w-full max-w-[1440px] mx-auto px-6 sm:px-10 lg:px-16 space-y-12">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                <div class="space-y-3">
                    <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-4 py-1.5 rounded-full border border-indigo-200">Engineered for Precision</span>
                    <h2 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight">Everything you need to master STEM</h2>
                </div>
                <p class="text-slate-500 text-base max-w-md leading-relaxed">Remove friction between abstract mathematical formulas and intuitive spatial visualization.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-10 rounded-[32px] border border-[#CEB5EF]/40 shadow-xl shadow-indigo-100/30 space-y-6 hover:border-indigo-500 transition-all duration-300 group flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-2xl group-hover:scale-110 transition-transform shadow-sm">⚡</div>
                        <h3 class="text-2xl font-extrabold text-slate-900">Real-Time Calculus</h3>
                        <p class="text-slate-500 leading-relaxed text-base">Instant visual calculation of kinetic energy, vector momentum, and surface friction coefficients as you manipulate interactive objects.</p>
                    </div>
                    <div class="pt-6 border-t border-slate-100 font-mono text-xs font-semibold text-slate-400">MODULE // 01</div>
                </div>

                <div class="bg-white p-10 rounded-[32px] border border-[#CEB5EF]/40 shadow-xl shadow-indigo-100/30 space-y-6 hover:border-indigo-500 transition-all duration-300 group flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-2xl group-hover:scale-110 transition-transform shadow-sm">🎯</div>
                        <h3 class="text-2xl font-extrabold text-slate-900">Interactive Laboratories</h3>
                        <p class="text-slate-500 leading-relaxed text-base">Covering Projectile Motion, Atwood Machines, Chemical Titration, Optical Microscopy, and 2D Elastic Collisions.</p>
                    </div>
                    <div class="pt-6 border-t border-slate-100 font-mono text-xs font-semibold text-slate-400">MODULE // 02</div>
                </div>

                <div class="bg-white p-10 rounded-[32px] border border-[#CEB5EF]/40 shadow-xl shadow-indigo-100/30 space-y-6 hover:border-indigo-500 transition-all duration-300 group flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-2xl group-hover:scale-110 transition-transform shadow-sm">📚</div>
                        <h3 class="text-2xl font-extrabold text-slate-900">Theory Note Integration</h3>
                        <p class="text-slate-500 leading-relaxed text-base">Quickly reference core formulas like Newton's Second Law ($F = ma$) directly alongside your active workspace simulations.</p>
                    </div>
                    <div class="pt-6 border-t border-slate-100 font-mono text-xs font-semibold text-slate-400">MODULE // 03</div>
                </div>
            </div>
        </section>

        <!-- Call to Action Banner -->
        <section class="w-full max-w-[1440px] mx-auto px-6 sm:px-10 lg:px-16">
            <div class="bg-gradient-to-br from-indigo-600 via-violet-600 to-purple-700 rounded-[36px] p-10 sm:p-20 text-center text-white space-y-8 shadow-2xl shadow-indigo-500/20 relative overflow-hidden">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.15),transparent_50%)] pointer-events-none"></div>
                <h2 class="text-3xl sm:text-6xl font-black tracking-tight max-w-4xl mx-auto leading-tight">Ready to transform how you study science?</h2>
                <p class="text-slate-100 text-base sm:text-xl max-w-2xl mx-auto opacity-90 leading-relaxed">Join computer science and STEM students building better spatial intuition with BurmaLab today.</p>
                <div class="pt-4 flex flex-wrap justify-center gap-4">
                    <a href="signup.php" class="inline-flex justify-center items-center px-10 py-5 rounded-2xl bg-white text-indigo-600 hover:bg-slate-50 font-extrabold text-base transition-all shadow-xl active:scale-95">
                        Create Free Account &rarr;
                    </a>
                    <a href="theory.php" class="inline-flex justify-center items-center px-10 py-5 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-extrabold text-base transition-all border border-white/30 active:scale-95">
                        Explore Documentation &rarr;
                    </a>
                </div>
            </div>
        </section>

    </main>

    <!-- Professional Footer -->
    <footer class="w-full border-t border-[#CEB5EF]/40 bg-white/70 backdrop-blur-xl py-12 px-6 sm:px-10 lg:px-16">
        <div class="max-w-[1440px] mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center space-x-3">
                <span class="bg-indigo-600 text-white p-2.5 rounded-xl text-xs font-bold shadow-md shadow-indigo-200">⚛</span>
                <span class="font-black text-slate-900 text-base">BurmaLab Suite</span>
            </div>
            <p class="text-slate-500 text-sm font-medium text-center">
                &copy; 2026 BurmaLab. High-performance virtual science laboratories for next-generation students.
            </p>
            <div class="flex items-center space-x-6 text-sm text-slate-500 font-semibold">
                <a href="landing.php" class="hover:text-indigo-600 transition-colors">Home</a>
                <a href="theory.php" class="hover:text-indigo-600 transition-colors">Theory Notes</a>
                <a href="settings.php" class="hover:text-indigo-600 transition-colors">Settings</a>
                <a href="login.php" class="hover:text-indigo-600 transition-colors">Sign In</a>
            </div>
        </div>
    </footer>

</body>
</html>