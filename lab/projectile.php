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
    <title>Projectile Motion - Physics Simulations Lab</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8F9FA; } .font-mono { font-family: 'JetBrains Mono', monospace; } input[type=range] { accent-color: #4f46e5; }</style>
</head>
<body class="min-h-screen flex flex-col text-slate-800">
    <nav class="bg-white"><div class="max-w-[1100px] mx-auto px-6 h-16 flex items-center justify-between"><a href="/" class="text-indigo-600 font-black text-xl tracking-tight">Physics Simulations Lab</a><div class="flex items-center gap-4"><span class="bg-indigo-50 text-indigo-600 border border-indigo-100 font-bold text-[10px] px-2 py-1 rounded-md uppercase tracking-wide">Grade 11 Ch.1</span><a href="/lab" class="text-indigo-600 font-semibold text-sm hover:text-indigo-800">&larr; All Labs</a></div></div></nav>
    <main class="flex-grow w-full max-w-[1100px] mx-auto px-6 py-8">
        <h1 class="text-[22px] font-bold text-slate-900 tracking-tight mb-8">Projectile Motion Lab</h1>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            <div class="lg:col-span-2 bg-white p-8 rounded-[24px] shadow-sm flex flex-col items-center">
                <canvas id="simCanvas" width="600" height="300" class="w-full max-w-[600px] rounded-xl bg-slate-50 border border-slate-100"></canvas>
                <div class="flex gap-4 mt-8 w-full justify-center">
                    <button id="fireBtn" class="bg-indigo-500 hover:bg-indigo-600 text-white font-medium text-sm py-2.5 px-6 rounded-xl">Fire Projectile</button>
                    <button id="resetBtn" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium text-sm py-2.5 px-6 rounded-xl">Reset</button>
                </div>
            </div>
            <div class="space-y-6">
                <div class="bg-[#1a1f2e] p-6 rounded-[24px] shadow-sm text-white">
                    <h2 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-5">Flight Status</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between"><span class="text-sm text-slate-300">Max Height:</span><div class="font-mono text-sm"><span id="statHeight" class="text-amber-400">0.0</span> m</div></div>
                        <div class="flex justify-between"><span class="text-sm text-slate-300">Range:</span><div class="font-mono text-sm"><span id="statRange" class="text-sky-400">0.0</span> m</div></div>
                        <div class="flex justify-between pt-2 border-t border-slate-700/50 mt-2"><span class="text-sm text-slate-300">Hit Status:</span><div class="font-mono text-sm"><span id="statHit" class="text-amber-400 font-bold">Pending</span></div></div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-[24px] shadow-sm">
                    <h2 class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest mb-5">Controls</h2>
                    <div class="space-y-5">
                        <div><div class="flex justify-between text-sm mb-2"><label class="text-slate-500">Initial Speed:</label><span id="v0Val" class="text-indigo-600 font-medium">18 m/s</span></div><input type="range" id="v0Input" min="5" max="30" step="1" value="18" class="w-full h-1.5 bg-slate-200 rounded-lg appearance-none"></div>
                        <div><div class="flex justify-between text-sm mb-2"><label class="text-slate-500">Launch Angle:</label><span id="angleVal" class="text-indigo-600 font-medium">45°</span></div><input type="range" id="angleInput" min="15" max="75" step="1" value="45" class="w-full h-1.5 bg-slate-200 rounded-lg appearance-none"></div>
                        <div><div class="flex justify-between text-sm mb-2"><label class="text-slate-500">Target Distance:</label><span id="targetPosVal" class="text-indigo-600 font-medium">320 m</span></div><input type="range" id="targetPosInput" min="200" max="420" step="10" value="320" class="w-full h-1.5 bg-slate-200 rounded-lg appearance-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="/js/projectile.js"></script>
</body>
</html>