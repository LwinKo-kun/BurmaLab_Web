<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/curriculum.php';
$pageTitle = 'BurmaLab | Virtual Physics Laboratory for Myanmar Students';
$htmlClass = 'scroll-smooth';
$bodyClass = 'bg-[#F6F6FF] text-slate-800 antialiased selection:bg-indigo-500 selection:text-white min-h-screen flex flex-col justify-between overflow-x-hidden';
include 'includes/head.php';
?>

<div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1200px] h-[600px] bg-gradient-to-br from-indigo-300/30 via-violet-300/20 to-transparent rounded-full blur-[160px] pointer-events-none -z-10"></div>

<?php include 'includes/nav.php'; ?>

<main class="w-full flex-grow space-y-32 pb-24">

    <section class="w-full min-h-[85vh] flex flex-col items-center justify-center text-center px-6 sm:px-10 lg:px-16 pt-8 relative">
        <div class="max-w-5xl mx-auto space-y-8">
            <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-white border border-indigo-200 text-xs font-bold text-indigo-600 shadow-sm tracking-wide uppercase">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                Myanmar High School Mechanics · Grades 10–12
            </div>

            <h1 class="text-5xl sm:text-7xl lg:text-8xl font-black tracking-tight text-slate-900 leading-[1.05]">
                Master Physics Through <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-600">Virtual Labs</span>
            </h1>

            <p class="text-lg sm:text-2xl text-slate-500 max-w-3xl mx-auto font-normal leading-relaxed">
                BurmaLab connects Myanmar's mechanics curriculum to interactive Matter.js simulations — forces, motion, projectiles, and collisions in real time.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4 w-full">
                <a href="signup.php" class="w-full sm:w-auto inline-flex justify-center items-center px-10 py-5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-base transition-all shadow-xl shadow-indigo-200 active:scale-95">
                    Get Started Free &rarr;
                </a>
                <a href="lab.php" class="w-full sm:w-auto inline-flex justify-center items-center px-10 py-5 rounded-2xl bg-white hover:bg-slate-50 border border-indigo-200 text-slate-700 font-bold text-base transition-all shadow-sm active:scale-95">
                    Browse Labs &rarr;
                </a>
            </div>
        </div>

        <div class="w-full max-w-[1300px] mt-20 mx-auto rounded-[32px] p-3.5 bg-white/80 border border-indigo-100 backdrop-blur-2xl shadow-2xl shadow-indigo-100 relative group">
            <div class="rounded-[24px] overflow-hidden border border-indigo-100 bg-slate-50 aspect-[16/9] relative">
                <img src="assets/1.jpg" alt="Physics simulation workspace" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent flex items-end p-8 sm:p-12 text-left">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center w-full gap-6">
                        <div>
                            <span class="text-xs font-mono tracking-widest text-indigo-300 uppercase bg-white/10 px-3.5 py-1.5 rounded-lg border border-white/20">Live Simulation Canvas</span>
                            <h3 class="text-xl sm:text-3xl font-extrabold text-white mt-2">Newton's Laws, Projectiles & Collisions</h3>
                        </div>
                        <a href="lab.php" class="px-6 py-3.5 rounded-xl bg-white hover:bg-slate-100 text-slate-900 text-sm font-bold shadow-lg transition-all flex-shrink-0">Launch Labs &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="w-full bg-white border-y border-[#CEB5EF]/40 py-16">
        <div class="max-w-[1440px] mx-auto px-6 sm:px-10 lg:px-16 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="space-y-1 border-r border-indigo-100">
                <p class="text-4xl sm:text-5xl font-black text-indigo-600"><?php echo count($activeLabs); ?></p>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Physics Simulations</p>
            </div>
            <div class="space-y-1 border-r border-indigo-100">
                <p class="text-4xl sm:text-5xl font-black text-indigo-600">10</p>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Curriculum Chapters</p>
            </div>
            <div class="space-y-1 border-r border-indigo-100">
                <p class="text-4xl sm:text-5xl font-black text-indigo-600">60 FPS</p>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Matter.js Engine</p>
            </div>
            <div class="space-y-1">
                <p class="text-4xl sm:text-5xl font-black text-indigo-600">Free</p>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">For All Students</p>
            </div>
        </div>
    </section>

    <section class="w-full max-w-[1440px] mx-auto px-6 sm:px-10 lg:px-16 space-y-16">
        <div class="text-center max-w-3xl mx-auto space-y-3">
            <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-4 py-1.5 rounded-full border border-indigo-200">Curriculum Aligned</span>
            <h2 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight">From Forces to Fluid Dynamics</h2>
            <p class="text-slate-500 text-base">Every module maps to Myanmar high school mechanics chapters across Grades 10, 11, and 12.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white p-8 sm:p-10 rounded-[32px] border border-[#CEB5EF]/40 shadow-xl shadow-indigo-100/30 space-y-6">
                <div class="rounded-2xl overflow-hidden border border-indigo-100 aspect-[16/10]">
                    <img src="assets/2.jpg" alt="Force and motion simulation" class="w-full h-full object-cover">
                </div>
                <div class="space-y-3">
                    <span class="text-xs font-mono font-bold text-indigo-600 uppercase tracking-wider">Grade 10 · Forces & Motion</span>
                    <h3 class="text-2xl font-extrabold text-slate-900">Newton's Laws & Momentum Labs</h3>
                    <p class="text-slate-500 text-base leading-relaxed">Explore F = ma, friction coefficients, and conservation of momentum through hands-on collision simulations.</p>
                </div>
            </div>
            <div class="bg-white p-8 sm:p-10 rounded-[32px] border border-[#CEB5EF]/40 shadow-xl shadow-indigo-100/30 space-y-6">
                <div class="rounded-2xl overflow-hidden border border-indigo-100 aspect-[16/10]">
                    <img src="assets/3.jpg" alt="Projectile motion simulation" class="w-full h-full object-cover">
                </div>
                <div class="space-y-3">
                    <span class="text-xs font-mono font-bold text-indigo-600 uppercase tracking-wider">Grade 11 · Motion in a Plane</span>
                    <h3 class="text-2xl font-extrabold text-slate-900">Projectile & Rotational Dynamics</h3>
                    <p class="text-slate-500 text-base leading-relaxed">Adjust launch angles, study trajectories, and investigate pulley systems tied to torque and mechanical advantage.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="w-full max-w-[1440px] mx-auto px-6 sm:px-10 lg:px-16 space-y-12">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
            <div class="space-y-3">
                <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-4 py-1.5 rounded-full border border-indigo-200">Built for Learning</span>
                <h2 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight">Everything you need for mechanics</h2>
            </div>
            <p class="text-slate-500 text-base max-w-md leading-relaxed">Bridge textbook formulas with spatial intuition using live telemetry and adjustable parameters.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-10 rounded-[32px] border border-[#CEB5EF]/40 shadow-xl shadow-indigo-100/30 space-y-6 hover:border-indigo-500 transition-all group">
                <div class="w-14 h-14 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 text-2xl font-bold group-hover:scale-110 transition-transform">⚡</div>
                <h3 class="text-2xl font-extrabold text-slate-900">Live Telemetry</h3>
                <p class="text-slate-500 leading-relaxed">Watch velocity, acceleration, tension, and friction update in real time as you change simulation parameters.</p>
            </div>
            <div class="bg-white p-10 rounded-[32px] border border-[#CEB5EF]/40 shadow-xl shadow-indigo-100/30 space-y-6 hover:border-indigo-500 transition-all group">
                <div class="w-14 h-14 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 text-2xl font-bold group-hover:scale-110 transition-transform">🎯</div>
                <h3 class="text-2xl font-extrabold text-slate-900">7 Interactive Labs</h3>
                <p class="text-slate-500 leading-relaxed">Projectile motion, Atwood machines, incline planes, double pulleys, collisions, friction, and Newton's second law.</p>
            </div>
            <div class="bg-white p-10 rounded-[32px] border border-[#CEB5EF]/40 shadow-xl shadow-indigo-100/30 space-y-6 hover:border-indigo-500 transition-all group">
                <div class="w-14 h-14 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 text-2xl font-bold group-hover:scale-110 transition-transform">📚</div>
                <h3 class="text-2xl font-extrabold text-slate-900">Theory Reference</h3>
                <p class="text-slate-500 leading-relaxed">Quick-access formula sheets aligned to each grade — from kinematics to Bernoulli's equation.</p>
            </div>
        </div>
    </section>

    <section class="w-full max-w-[1440px] mx-auto px-6 sm:px-10 lg:px-16">
        <div class="bg-gradient-to-br from-indigo-600 via-violet-600 to-purple-700 rounded-[36px] p-10 sm:p-20 text-center text-white space-y-8 shadow-2xl shadow-indigo-500/20 relative overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.15),transparent_50%)] pointer-events-none"></div>
            <h2 class="text-3xl sm:text-6xl font-black tracking-tight max-w-4xl mx-auto leading-tight">Ready to explore mechanics interactively?</h2>
            <p class="text-slate-100 text-base sm:text-xl max-w-2xl mx-auto opacity-90 leading-relaxed">Join Myanmar high school students building stronger physics intuition with BurmaLab.</p>
            <div class="pt-4 flex flex-wrap justify-center gap-4">
                <a href="signup.php" class="inline-flex justify-center items-center px-10 py-5 rounded-2xl bg-white text-indigo-600 hover:bg-slate-50 font-extrabold text-base transition-all shadow-xl active:scale-95">Create Free Account &rarr;</a>
                <a href="theory.php" class="inline-flex justify-center items-center px-10 py-5 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-extrabold text-base transition-all border border-white/30 active:scale-95">View Theory Notes &rarr;</a>
            </div>
        </div>
    </section>

</main>

<?php include 'includes/footer.php'; ?>
