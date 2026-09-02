<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_auth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incline & Pulley Simulation - Physics Simulations Lab</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8F9FA; } .font-mono { font-family: 'JetBrains Mono', monospace; } input[type=range] { accent-color: #4f46e5; }</style>
</head>
<body class="min-h-screen flex flex-col text-slate-800">
    <nav class="bg-white">
        <div class="max-w-[1100px] mx-auto px-6 h-16 flex items-center justify-between">
            <a href="/" class="text-indigo-600 font-black text-xl tracking-tight">Physics Simulations Lab</a>
            <div class="flex items-center gap-4">
                <span class="bg-indigo-50 text-indigo-600 border border-indigo-100 font-bold text-[10px] px-2 py-1 rounded-md uppercase tracking-wide">Grade 11 Ch.2</span>
                <a href="/lab" class="text-indigo-600 font-semibold text-sm hover:text-indigo-800">&larr; All Labs</a>
            </div>
        </div>
    </nav>

    <main class="flex-grow w-full max-w-[1100px] mx-auto px-6 py-8">
        <h1 class="text-[22px] font-bold text-slate-900 tracking-tight mb-8">Incline & Pulley System Lab</h1>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            <div class="lg:col-span-2 bg-white p-8 rounded-[24px] shadow-sm flex flex-col items-center">
                <canvas id="simCanvas" width="500" height="300" class="w-full max-w-[500px] rounded-xl border border-slate-100 bg-white"></canvas>
                <div class="flex gap-4 mt-8 w-full justify-center">
                    <button id="runBtn" class="bg-indigo-500 hover:bg-indigo-600 text-white font-medium text-sm py-2.5 px-6 rounded-xl transition-colors">Start / Pause</button>
                    <button id="resetBtn" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium text-sm py-2.5 px-6 rounded-xl transition-colors">Reset</button>
                </div>
            </div>
            
            <div class="space-y-6">
                <div class="bg-[#1a1f2e] p-6 rounded-[24px] shadow-sm text-white">
                    <h2 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-5">Live Telemetry</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center"><span class="text-sm text-slate-300">System Vel:</span> <span id="statVel" class="font-mono text-sky-400 font-bold">0.00</span> <span class="text-slate-500 text-xs">m/s</span></div>
                        <div class="flex justify-between items-center"><span class="text-sm text-slate-300">Acceleration:</span> <span id="statAcc" class="font-mono text-sky-400 font-bold">0.00</span> <span class="text-slate-500 text-xs">m/s²</span></div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-[24px] shadow-sm">
                    <h2 class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest mb-5">Controls</h2>
                    <div class="space-y-5">
                        <div>
                            <div class="flex justify-between text-sm mb-2"><label class="text-slate-500">Mass 1 (Hanging):</label><span id="m1Val" class="text-indigo-600 font-medium">3.0 kg</span></div>
                            <input type="range" id="m1Input" min="1" max="15" step="0.5" value="3" class="w-full h-1.5 bg-slate-200 rounded-lg appearance-none cursor-pointer">
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-2"><label class="text-slate-500">Mass 2 (Ramp):</label><span id="m2InputVal" class="text-indigo-600 font-medium">4.0 kg</span></div>
                            <input type="range" id="m2Input" min="1" max="15" step="0.5" value="4" class="w-full h-1.5 bg-slate-200 rounded-lg appearance-none cursor-pointer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="/js/atwood-incline.js"></script>
</body>
</html>