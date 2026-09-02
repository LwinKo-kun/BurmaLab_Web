<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_auth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work & Energy - Physics Simulations Lab</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8F9FA; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        input[type=range] { accent-color: #4f46e5; }
    </style>
</head>
<body class="min-h-screen flex flex-col text-slate-800">
    
    <nav class="bg-white">
        <div class="max-w-[1100px] mx-auto px-6 h-16 flex items-center justify-between">
            <a href="/" class="text-indigo-600 font-black text-xl tracking-tight">Physics Simulations Lab</a>
            <div class="flex items-center gap-4">
                <span class="bg-emerald-50 text-emerald-600 border border-emerald-100 font-bold text-[10px] px-2 py-1 rounded-md uppercase tracking-wide">Grade 10 Ch.5</span>
                <a href="/lab" class="text-indigo-600 font-semibold text-sm hover:text-indigo-800 transition-colors">&larr; All Labs</a>
            </div>
        </div>
    </nav>

    <main class="flex-grow w-full max-w-[1100px] mx-auto px-6 py-8">
        <h1 class="text-[22px] font-bold text-slate-900 tracking-tight mb-8">Conservation of Energy Lab</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            <div class="lg:col-span-2 bg-white p-8 rounded-[24px] shadow-sm flex flex-col items-center">
                <canvas id="simCanvas" width="600" height="350" class="w-full max-w-[600px] rounded-xl bg-slate-50 border border-slate-100"></canvas>
                <div class="flex gap-4 mt-8 w-full justify-center">
                    <button id="releaseBtn" class="bg-indigo-500 hover:bg-indigo-600 text-white font-medium text-sm py-2.5 px-6 rounded-xl transition-colors">Release Pendulum</button>
                    <button id="resetBtn" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium text-sm py-2.5 px-6 rounded-xl transition-colors">Reset</button>
                </div>
            </div>
            
            <div class="space-y-6">
                
                <div class="bg-[#1a1f2e] p-6 rounded-[24px] shadow-sm text-white">
                    <h2 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-5">Energy Distribution (J)</h2>
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm text-slate-300">Potential Energy (Ep):</span>
                                <div class="font-mono text-sm"><span id="statEp" class="text-amber-400 font-semibold">0.0</span> <span class="text-slate-500 ml-1">J</span></div>
                            </div>
                            <div class="w-full bg-slate-800 rounded-full h-2"><div id="barEp" class="bg-amber-400 h-2 rounded-full" style="width: 100%;"></div></div>
                        </div>
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm text-slate-300">Kinetic Energy (Ek):</span>
                                <div class="font-mono text-sm"><span id="statEk" class="text-sky-400 font-semibold">0.0</span> <span class="text-slate-500 ml-1">J</span></div>
                            </div>
                            <div class="w-full bg-slate-800 rounded-full h-2"><div id="barEk" class="bg-sky-400 h-2 rounded-full" style="width: 0%;"></div></div>
                        </div>
                        <div class="flex justify-between items-center pt-3 border-t border-slate-700/50 mt-2">
                            <span class="text-sm text-slate-300">Total Mechanical Energy:</span>
                            <div class="font-mono text-sm"><span id="statTotalE" class="text-emerald-400 font-bold text-base">0.0</span> <span class="text-slate-500 ml-1">J</span></div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-[24px] shadow-sm">
                    <h2 class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest mb-5">Controls</h2>
                    <div class="space-y-5">
                        <div>
                            <div class="flex justify-between text-sm mb-2"><label class="text-slate-500" for="massSlider">Pendulum Mass (m):</label><span id="massVal" class="text-indigo-600 font-medium">2.0 kg</span></div>
                            <input type="range" id="massSlider" min="0.5" max="10" step="0.5" value="2.0" class="w-full h-1.5 bg-slate-200 rounded-lg appearance-none cursor-pointer">
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-2"><label class="text-slate-500" for="heightSlider">Release Height (h):</label><span id="heightVal" class="text-indigo-600 font-medium">5.0 m</span></div>
                            <input type="range" id="heightSlider" min="1.0" max="10.0" step="0.5" value="5.0" class="w-full h-1.5 bg-slate-200 rounded-lg appearance-none cursor-pointer">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
    <script src="/js/work-energy.js"></script>
</body>
</html>