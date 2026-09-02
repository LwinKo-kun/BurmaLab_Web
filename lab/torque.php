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
    <title>Torque Lab - Physics Simulations Lab</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8F9FA; } .font-mono { font-family: 'JetBrains Mono', monospace; } input[type=range] { accent-color: #4f46e5; }</style>
</head>
<body class="min-h-screen flex flex-col text-slate-800">
    <nav class="bg-white"><div class="max-w-[1100px] mx-auto px-6 h-16 flex items-center justify-between"><a href="/" class="text-indigo-600 font-black text-xl tracking-tight">Physics Simulations Lab</a><div class="flex items-center gap-4"><span class="bg-indigo-50 text-indigo-600 border border-indigo-100 font-bold text-[10px] px-2 py-1 rounded-md uppercase tracking-wide">Grade 11 Ch.2</span><a href="/lab" class="text-indigo-600 font-semibold text-sm hover:text-indigo-800">&larr; All Labs</a></div></div></nav>
    <main class="flex-grow w-full max-w-[1100px] mx-auto px-6 py-8">
        <h1 class="text-[22px] font-bold text-slate-900 tracking-tight mb-8">Torque & Equilibrium</h1>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            <div class="lg:col-span-2 bg-white p-8 rounded-[24px] shadow-sm flex flex-col items-center">
                <canvas id="simCanvas" width="600" height="300" class="w-full max-w-[600px] rounded-xl bg-slate-50 border border-slate-100"></canvas>
                <div class="flex gap-4 mt-8 w-full justify-center">
                    <button id="releaseBtn" class="bg-indigo-500 hover:bg-indigo-600 text-white font-medium text-sm py-2.5 px-6 rounded-xl">Release Pivot</button>
                    <button id="resetBtn" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium text-sm py-2.5 px-6 rounded-xl">Lock & Reset</button>
                </div>
            </div>
            <div class="space-y-6">
                <div class="bg-[#1a1f2e] p-6 rounded-[24px] shadow-sm text-white">
                    <h2 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-5">System Telemetry</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between"><span class="text-sm text-slate-300">Left Torque (τ₁):</span><div class="font-mono text-sm"><span id="statTorqueL" class="text-sky-400">0.0</span> N·m</div></div>
                        <div class="flex justify-between"><span class="text-sm text-slate-300">Right Torque (τ₂):</span><div class="font-mono text-sm"><span id="statTorqueR" class="text-rose-400">0.0</span> N·m</div></div>
                        <div class="flex justify-between pt-2 border-t border-slate-700/50 mt-2"><span class="text-sm text-slate-300">Status:</span><div class="font-mono text-sm"><span id="statStatus" class="text-amber-400 font-bold">LOCKED</span></div></div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-[24px] shadow-sm space-y-4">
                    <h2 class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest">Left Side</h2>
                    <div><div class="flex justify-between text-sm mb-1"><label class="text-slate-500">Mass (m₁):</label><span id="mLVal" class="text-sky-500 font-medium">10 kg</span></div><input type="range" id="mLInput" min="5" max="50" step="5" value="10" class="w-full h-1.5 bg-slate-200 rounded-lg appearance-none"></div>
                    <div><div class="flex justify-between text-sm mb-1"><label class="text-slate-500">Distance (r₁):</label><span id="rLVal" class="text-sky-500 font-medium">2.0 m</span></div><input type="range" id="rLInput" min="0.5" max="5.0" step="0.5" value="2.0" class="w-full h-1.5 bg-slate-200 rounded-lg appearance-none"></div>
                    <hr class="border-slate-100 my-2">
                    <h2 class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest">Right Side</h2>
                    <div><div class="flex justify-between text-sm mb-1"><label class="text-slate-500">Mass (m₂):</label><span id="mRVal" class="text-rose-500 font-medium">10 kg</span></div><input type="range" id="mRInput" min="5" max="50" step="5" value="10" class="w-full h-1.5 bg-slate-200 rounded-lg appearance-none"></div>
                    <div><div class="flex justify-between text-sm mb-1"><label class="text-slate-500">Distance (r₂):</label><span id="rRVal" class="text-rose-500 font-medium">2.0 m</span></div><input type="range" id="rRInput" min="0.5" max="5.0" step="0.5" value="2.0" class="w-full h-1.5 bg-slate-200 rounded-lg appearance-none"></div>
                </div>
            </div>
        </div>
    </main>
    <script src="/js/torque.js"></script>
</body>
</html>