<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pageTitle = 'About - Physics Simulations Lab';
$htmlClass = 'scroll-smooth';
$bodyClass = 'bg-[#F6F6FF] text-slate-800 antialiased selection:bg-indigo-500 selection:text-white min-h-screen flex flex-col justify-between overflow-x-hidden';
include 'includes/head.php';
?>

<div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1200px] h-[600px] bg-gradient-to-br from-indigo-300/30 via-violet-300/20 to-transparent rounded-full blur-[160px] pointer-events-none -z-10"></div>

<?php include 'includes/nav.php'; ?>

<main class="w-full flex-grow space-y-32 pb-24">

    <section class="w-full max-w-5xl mx-auto px-6 pt-16 text-center space-y-6">
        <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-4 py-1.5 rounded-full border border-indigo-200">Our Mission</span>
        <h1 class="text-4xl sm:text-6xl font-black text-slate-900 tracking-tight">Physics Education for Myanmar Students</h1>
        <p class="text-lg sm:text-xl text-slate-500 max-w-3xl mx-auto leading-relaxed">
            Physics Simulations Lab bridges the gap between static textbook problem sets and interactive, real-time mechanics simulations — built for Grades 10–12 across Myanmar's high school curriculum.
        </p>
    </section>

    <section class="w-full max-w-[1440px] mx-auto px-6 sm:px-10 lg:px-16">
        <div class="bg-white rounded-[36px] p-8 sm:p-16 border border-[#CEB5EF]/40 shadow-xl shadow-indigo-100/30 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <span class="text-xs font-mono font-bold text-indigo-600 uppercase tracking-wider">Hands-On Discovery</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Designed for Deep Conceptual Learning</h2>
                <p class="text-slate-500 text-base leading-relaxed">
                    From Newton's laws to Bernoulli's equation, Physics Simulations Lab turns abstract formulas into manipulable simulations. Students adjust parameters, observe live telemetry, and build genuine spatial intuition for mechanics.
                </p>
                <div class="grid grid-cols-2 gap-6 pt-4">
                    <div class="space-y-1 border-l-2 border-indigo-600 pl-4">
                        <p class="text-2xl font-black text-slate-900">Open Access</p>
                        <p class="text-xs text-slate-500">Free for all Myanmar students.</p>
                    </div>
                    <div class="space-y-1 border-l-2 border-indigo-600 pl-4">
                        <p class="text-2xl font-black text-slate-900">7 Labs</p>
                        <p class="text-xs text-slate-500">Matter.js-powered simulations.</p>
                    </div>
                </div>
            </div>
            <div class="rounded-[28px] overflow-hidden border border-[#CEB5EF]/30 bg-slate-50 aspect-[4/3] shadow-inner">
                <img src="assets/4.jpg" alt="Student learning physics" class="w-full h-full object-cover">
            </div>
        </div>
    </section>

    <section class="w-full max-w-[1440px] mx-auto px-6 sm:px-10 lg:px-16 space-y-12">
        <div class="text-center max-w-2xl mx-auto space-y-3">
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900">What Powers Physics Simulations Lab</h2>
            <p class="text-slate-500 text-sm">Core goals behind the simulation platform.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-[28px] border border-[#CEB5EF]/40 shadow-lg shadow-indigo-100/20 space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 text-xl font-bold">📖</div>
                <h3 class="text-xl font-bold text-slate-900">Curriculum Aligned</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Every lab and theory note maps directly to Myanmar's Grades 10–12 mechanics syllabus.</p>
            </div>
            <div class="bg-white p-8 rounded-[28px] border border-[#CEB5EF]/40 shadow-lg shadow-indigo-100/20 space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 text-xl font-bold">⚡</div>
                <h3 class="text-xl font-bold text-slate-900">Instant Performance</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Client-side Matter.js simulations with a secure PHP and MySQL backend for student accounts.</p>
            </div>
            <div class="bg-white p-8 rounded-[28px] border border-[#CEB5EF]/40 shadow-lg shadow-indigo-100/20 space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 text-xl font-bold">🔬</div>
                <h3 class="text-xl font-bold text-slate-900">Visual Intuition</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Transform equations like F = ma and p = mv into interactive experiments students can explore.</p>
            </div>
        </div>
    </section>

</main>

<?php include 'includes/footer.php'; ?>
