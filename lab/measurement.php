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
    <title>Measurement & Calipers - Physics Simulations Lab</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8F9FA; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
    </style>
</head>
<body class="min-h-screen flex flex-col text-slate-800">
    
    <nav class="bg-white">
        <div class="max-w-[1100px] mx-auto px-6 h-16 flex items-center justify-between">
            <a href="/" class="text-indigo-600 font-black text-xl tracking-tight">Physics Simulations Lab</a>
            <div class="flex items-center gap-4">
                <span class="bg-indigo-50 text-indigo-600 border border-indigo-100 font-bold text-[10px] px-2 py-1 rounded-md uppercase tracking-wide">Grade 10 Ch.1</span>
                <a href="/lab" class="text-indigo-600 font-semibold text-sm hover:text-indigo-800 transition-colors">&larr; All Labs</a>
            </div>
        </div>
    </nav>

    <main class="flex-grow w-full max-w-[1100px] mx-auto px-6 py-8">
        <h1 class="text-[22px] font-bold text-slate-900 tracking-tight mb-8">Vernier Caliper Measurement Lab</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            <!-- Left Column: Canvas & Buttons -->
            <div class="lg:col-span-2 bg-white p-8 rounded-[24px] shadow-sm flex flex-col items-center">
                <canvas id="simCanvas" width="600" height="300" class="w-full max-w-[600px] rounded-xl cursor-default touch-none"></canvas>
                
                <div class="flex gap-4 mt-8 w-full justify-center">
                    <button id="clampBtn" class="bg-indigo-500 hover:bg-indigo-600 text-white font-medium text-sm py-2.5 px-6 rounded-xl transition-colors">Auto-Clamp</button>
                    <button id="randomObjBtn" class="bg-amber-500 hover:bg-amber-600 text-white font-medium text-sm py-2.5 px-6 rounded-xl transition-colors">New Random Object</button>
                    <button id="resetBtn" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium text-sm py-2.5 px-6 rounded-xl transition-colors">Open Jaw</button>
                </div>
            </div>
            
            <!-- Right Column: Telemetry & Controls -->
            <div class="space-y-6">
                
                <div class="bg-[#1a1f2e] p-6 rounded-[24px] shadow-sm text-white">
                    <h2 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-5">Measurement Telemetry</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-300">Main Scale (MSR):</span>
                            <div class="font-mono text-sm"><span id="statMSR" class="text-emerald-400 font-semibold">0.0</span> <span class="text-slate-500 ml-2">mm</span></div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-300">Vernier Scale (VSR):</span>
                            <div class="font-mono text-sm"><span id="statVSR" class="text-emerald-400 font-semibold">0.00</span> <span class="text-slate-500 ml-2">mm</span></div>
                        </div>
                        <div class="flex justify-between items-center pt-2 border-t border-slate-700/50 mt-2">
                            <span class="text-sm text-slate-300">Total Length:</span>
                            <div class="font-mono text-sm"><span id="statTotal" class="text-emerald-400 font-bold text-base">0.00</span> <span class="text-slate-500 ml-2">mm</span></div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-[24px] shadow-sm">
                    <h2 class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest mb-5">Interactive Controls</h2>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center flex-shrink-0 text-indigo-600">👆</div>
                            <p class="text-sm text-slate-600 leading-relaxed"><strong>Drag the blue sliding jaw</strong> with your mouse or finger to manually measure the orange object.</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-amber-50 flex items-center justify-center flex-shrink-0 text-amber-600">🎲</div>
                            <p class="text-sm text-slate-600 leading-relaxed">Click <strong>New Random Object</strong> to spawn a new block and practice reading the scale.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
    
    <script src="/js/measurement.js"></script>
</body>
</html>