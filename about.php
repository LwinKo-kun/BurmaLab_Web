<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - BurmaLab | Advanced Virtual Science & Physics Suite</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F6F6FF] text-slate-800 antialiased selection:bg-[#5580E9] selection:text-white min-h-screen flex flex-col justify-between overflow-x-hidden">

    <!-- Ambient Background Gradients -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1200px] h-[600px] bg-gradient-to-br from-[#CEB5FF]/30 via-[#8da9ff]/20 to-transparent rounded-full blur-[160px] pointer-events-none -z-10"></div>

    <!-- Header -->
    <header class="sticky top-0 z-50 w-full backdrop-blur-xl bg-[#F6F6FF]/80 border-b border-[#CEB5FF]/30">
        <div class="max-w-[1440px] mx-auto px-6 sm:px-10 lg:px-16">
            <?php include 'includes/nav.php'; ?>
        </div>
    </header>

    <!-- Main Content -->
    <main class="w-full flex-grow space-y-32 pb-24">
        
        <!-- About Hero -->
        <section class="w-full max-w-5xl mx-auto px-6 pt-20 text-center space-y-6">
            <span class="text-xs font-extrabold text-[#5580E9] uppercase tracking-widest bg-[#EBF0FF] px-4 py-1.5 rounded-full border border-[#CEB5FF]/50">Our Mission & Vision</span>
            <h1 class="text-4xl sm:text-7xl font-black text-slate-900 tracking-tight">Empowering Student Experimentation Worldwide</h1>
            <p class="text-lg sm:text-xl text-slate-500 max-w-3xl mx-auto leading-relaxed">
                BurmaLab is built by students, for students. We bridge the gap between static textbook problem sets and interactive, real-time computational physics and chemistry laboratories.
            </p>
        </section>

        <!-- Visual Storytelling Section utilizing 4.jpg -->
        <section class="w-full max-w-[1440px] mx-auto px-6 sm:px-10 lg:px-16">
            <div class="bg-white rounded-[36px] p-8 sm:p-16 border border-[#CEB5FF]/40 shadow-xl shadow-[#CEB5FF]/10 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <span class="text-xs font-mono font-bold text-[#5580E9] uppercase tracking-wider">Hands-On Discovery</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Designed for Deep Conceptual Immersion</h2>
                    <p class="text-slate-500 text-base leading-relaxed">
                        Whether analyzing liquid solutions with precision glassware or executing vector calculations via high-performance web kernels, BurmaLab provides an accessible, friction-free environment for computer science and STEM learners across campuses.
                    </p>
                    <div class="grid grid-cols-2 gap-6 pt-4">
                        <div class="space-y-1 border-l-2 border-[#5580E9] pl-4">
                            <p class="text-2xl font-black text-slate-900">Open Access</p>
                            <p class="text-xs text-slate-500">Free for student guilds everywhere.</p>
                        </div>
                        <div class="space-y-1 border-l-2 border-[#5580E9] pl-4">
                            <p class="text-2xl font-black text-slate-900">60 FPS Render</p>
                            <p class="text-xs text-slate-500">Smooth browser-based physics simulation.</p>
                        </div>
                    </div>
                </div>
                <div class="rounded-[28px] overflow-hidden border border-[#CEB5FF]/30 bg-[#F8F7FF] aspect-[4/3] shadow-inner">
                    <img src="assets/4.jpg" alt="Student in Lab" class="w-full h-full object-cover">
                </div>
            </div>
        </section>

        <!-- Project Goals / Pillars -->
        <section class="w-full max-w-[1440px] mx-auto px-6 sm:px-10 lg:px-16 space-y-12">
            <div class="text-center max-w-2xl mx-auto space-y-3">
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900">What Drives The DevGuild</h2>
                <p class="text-slate-500 text-sm">Core architectural goals behind the BurmaLab simulation ecosystem.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-[28px] border border-[#CEB5FF]/40 shadow-lg shadow-[#CEB5FF]/5 space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-[#F8F7FF] border border-[#D3D3FF] flex items-center justify-center text-[#5580E9] font-bold text-xl">🚀</div>
                    <h3 class="text-xl font-bold text-slate-900">Cross-Campus Collaboration</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Built to let computer science students collaborate on code repositories, simulation modules, and study tools together.</p>
                </div>
                <div class="bg-white p-8 rounded-[28px] border border-[#CEB5FF]/40 shadow-lg shadow-[#CEB5FF]/5 space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-[#F8F7FF] border border-[#D3D3FF] flex items-center justify-center text-[#5580E9] font-bold text-xl">⚡</div>
                    <h3 class="text-xl font-bold text-slate-900">Instant Performance</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Utilizing lightweight client-side scripts and robust PHP backends to guarantee fast load times across all mobile and desktop devices.</p>
                </div>
                <div class="bg-white p-8 rounded-[28px] border border-[#CEB5FF]/40 shadow-lg shadow-[#CEB5FF]/5 space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-[#F8F7FF] border border-[#D3D3FF] flex items-center justify-center text-[#5580E9] font-bold text-xl">🔬</div>
                    <h3 class="text-xl font-bold text-slate-900">Visual Intuition</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Turning hard physics and chemistry formulas into manipulable visual objects that reinforce genuine scientific intuition.</p>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="w-full border-t border-[#CEB5FF]/40 bg-white/70 backdrop-blur-xl py-12 px-6 sm:px-10 lg:px-16">
        <div class="max-w-[1440px] mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center space-x-3">
                <span class="bg-[#5580E9] text-white p-2.5 rounded-xl text-xs font-bold shadow-md shadow-[#5580E9]/20">⚛</span>
                <span class="font-black text-slate-900 text-base">BurmaLab Suite</span>
            </div>
            <p class="text-slate-500 text-sm font-medium text-center">
                &copy; 2026 BurmaLab. Built for student exploration.
            </p>
            <div class="flex items-center space-x-6 text-sm text-slate-500 font-semibold">
                <a href="landing.php" class="hover:text-[#5580E9] transition-colors">Home</a>
                <a href="theory.php" class="hover:text-[#5580E9] transition-colors">Documentation</a>
                <a href="login.php" class="hover:text-[#5580E9] transition-colors">Sign In</a>
            </div>
        </div>
    </footer>

</body>
</html>