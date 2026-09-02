<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_auth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hooke's Law Comparison - Physics Simulations Lab</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8F9FA; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        input[type=range] { accent-color: #4f46e5; }
    </style>
</head>
<body class="min-h-screen flex flex-col text-slate-800">
    <nav class="bg-white border-b border-slate-100">
        <div class="max-w-[1100px] mx-auto px-6 h-16 flex items-center justify-between">
            <a href="/" class="text-indigo-600 font-black text-xl tracking-tight">Physics Simulations Lab</a>
            <div class="flex items-center gap-4">
                <span class="bg-indigo-50 text-indigo-600 border border-indigo-100 font-bold text-[10px] px-2.5 py-1 rounded-md uppercase tracking-wide">Grade 11 Ch.4</span>
                <a href="/lab" class="text-indigo-600 font-semibold text-sm hover:text-indigo-800">&larr; All Labs</a>
            </div>
        </div>
    </nav>

    <main class="flex-grow w-full max-w-[1100px] mx-auto px-6 py-8">
        <h1 class="text-[24px] font-extrabold text-slate-900 tracking-tight mb-2">Hooke's Law: Spring & Mass Comparison</h1>
        <p class="text-sm text-slate-500 mb-8">Compare two independent spring systems side-by-side with different stiffness and loads.</p>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            <!-- Canvas Simulation Area -->
            <div class="lg:col-span-2 bg-white p-6 sm:p-8 rounded-[24px] shadow-sm border border-slate-100 flex flex-col items-center">
                <canvas id="simCanvas" width="700" height="420" class="w-full h-auto rounded-xl bg-slate-50 border border-slate-200 shadow-sm"></canvas>
                <div class="flex gap-4 mt-6 w-full justify-center">
                    <button id="releaseBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm py-2.5 px-6 rounded-xl shadow-lg shadow-indigo-100 transition">Release Both</button>
                    <button id="resetBtn" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-sm py-2.5 px-6 rounded-xl transition">Reset</button>
                </div>
            </div>
            
            <!-- Controls & Telemetry Side Panel -->
            <div class="space-y-6">
                <!-- System A Telemetry -->
                <div class="bg-[#1a1f2e] p-5 rounded-[24px] shadow-sm text-white">
                    <h2 class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest mb-3">System A (Left)</h2>
                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between"><span class="text-slate-300">Displacement:</span><span id="statDispointA" class="font-mono text-sky-400">0.00 m</span></div>
                        <div class="flex justify-between"><span class="text-slate-300">Force:</span><span id="statForceA" class="font-mono text-rose-400">0.0 N</span></div>
                        <div class="flex justify-between"><span class="text-slate-300">Energy (Ep):</span><span id="statEpA" class="font-mono text-amber-400">0.00 J</span></div>
                    </div>
                </div>

                <!-- System B Telemetry -->
                <div class="bg-[#1a1f2e] p-5 rounded-[24px] shadow-sm text-white">
                    <h2 class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest mb-3">System B (Right)</h2>
                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between"><span class="text-slate-300">Displacement:</span><span id="statDispointB" class="font-mono text-sky-400">0.00 m</span></div>
                        <div class="flex justify-between"><span class="text-slate-300">Force:</span><span id="statForceB" class="font-mono text-rose-400">0.0 N</span></div>
                        <div class="flex justify-between"><span class="text-slate-300">Energy (Ep):</span><span id="statEpB" class="font-mono text-amber-400">0.00 J</span></div>
                    </div>
                </div>

                <!-- Independent Controls -->
                <div class="bg-white p-6 rounded-[24px] shadow-sm border border-slate-100 space-y-6">
                    <div>
                        <h3 class="text-xs font-bold text-indigo-600 uppercase tracking-wide mb-3">System A Controls</h3>
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-xs mb-1"><label class="text-slate-500">Spring Constant (kA):</label><span id="kValA" class="font-medium text-indigo-600">50 N/m</span></div>
                                <input type="range" id="kInputA" min="10" max="150" step="5" value="50" class="w-full h-1.5 bg-slate-200 rounded-lg appearance-none">
                            </div>
                            <div>
                                <div class="flex justify-between text-xs mb-1"><label class="text-slate-500">Mass (mA):</label><span id="mValA" class="font-medium text-indigo-600">2.0 kg</span></div>
                                <input type="range" id="mInputA" min="0.5" max="10" step="0.5" value="2.0" class="w-full h-1.5 bg-slate-200 rounded-lg appearance-none">
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 pt-4">
                        <h3 class="text-xs font-bold text-emerald-600 uppercase tracking-wide mb-3">System B Controls</h3>
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-xs mb-1"><label class="text-slate-500">Spring Constant (kB):</label><span id="kValB" class="font-medium text-emerald-600">100 N/m</span></div>
                                <input type="range" id="kInputB" min="10" max="150" step="5" value="100" class="w-full h-1.5 bg-slate-200 rounded-lg appearance-none">
                            </div>
                            <div>
                                <div class="flex justify-between text-xs mb-1"><label class="text-slate-500">Mass (mB):</label><span id="mValB" class="font-medium text-emerald-600">4.0 kg</span></div>
                                <input type="range" id="mInputB" min="0.5" max="10" step="0.5" value="4.0" class="w-full h-1.5 bg-slate-200 rounded-lg appearance-none">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="/js/springs.js"></script>
</body>
</html>