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
    <title>Archimedes' Principle - Physics Simulations Lab</title>
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
                <span class="bg-indigo-50 text-indigo-600 border border-indigo-100 font-bold text-[10px] px-2.5 py-1 rounded-md uppercase tracking-wide">Grade 11 Ch.3</span>
                <a href="/lab" class="text-indigo-600 font-semibold text-sm hover:text-indigo-800">&larr; All Labs</a>
            </div>
        </div>
    </nav>
    <main class="flex-grow w-full max-w-[1100px] mx-auto px-6 py-8">
        <h1 class="text-[24px] font-extrabold text-slate-900 tracking-tight mb-2">Archimedes' Principle Lab</h1>
        <p class="text-sm text-slate-500 mb-8">Explore buoyant force, apparent weight, and object flotation dynamics.</p>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            <div class="lg:col-span-2 bg-white p-6 sm:p-8 rounded-[24px] shadow-sm border border-slate-100 flex flex-col items-center">
                <!-- Normal White/Light Canvas Background -->
                <canvas id="simCanvas" width="700" height="350" class="w-full h-auto rounded-xl bg-slate-50 border border-slate-200 shadow-sm"></canvas>
                <div class="flex gap-4 mt-6 w-full justify-center">
                    <button id="submergeBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm py-2.5 px-6 rounded-xl shadow-lg shadow-indigo-100 transition">Release Object</button>
                    <button id="resetBtn" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-sm py-2.5 px-6 rounded-xl transition">Reset</button>
                </div>
            </div>
            
            <div class="space-y-6">
                <div class="bg-[#1a1f2e] p-6 rounded-[24px] shadow-sm text-white">
                    <h2 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-5">Telemetry</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between"><span class="text-sm text-slate-300">Buoyant Force:</span><div class="font-mono text-sm"><span id="statBuoyant" class="text-sky-400">0.0</span> N</div></div>
                        <div class="flex justify-between"><span class="text-sm text-slate-300">Apparent Weight:</span><div class="font-mono text-sm"><span id="statApparent" class="text-amber-400">0.0</span> N</div></div>
                        <div class="flex justify-between pt-2 border-t border-slate-700/50 mt-2"><span class="text-sm text-slate-300">Status:</span><div class="font-mono text-sm"><span id="statStatus" class="text-emerald-400 font-bold">Ready</span></div></div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-[24px] shadow-sm border border-slate-100">
                    <h2 class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest mb-5">Controls & Materials</h2>
                    <div class="space-y-5">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-2 uppercase tracking-wide">Example Materials</label>
                            <select id="materialSelect" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:outline-none focus:border-indigo-600">
                                <option value="custom">Custom Object</option>
                                <option value="wood" selected>Wood (Density: 600)</option>
                                <option value="ice">Ice (Density: 917)</option>
                                <option value="aluminum">Aluminum (Density: 2700)</option>
                                <option value="iron">Iron (Density: 7870)</option>
                            </select>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-2"><label class="text-slate-500">Object Mass:</label><span id="massVal" class="text-indigo-600 font-medium">2.0 kg</span></div>
                            <input type="range" id="massInput" min="0.5" max="10.0" step="0.5" value="2.0" class="w-full h-1.5 bg-slate-200 rounded-lg appearance-none">
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-2"><label class="text-slate-500">Object Density:</label><span id="densityVal" class="text-indigo-600 font-medium">600 kg/m³</span></div>
                            <input type="range" id="densityInput" min="200" max="8000" step="100" value="600" class="w-full h-1.5 bg-slate-200 rounded-lg appearance-none">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="/js/buoyancy.js"></script>
</body>
</html>