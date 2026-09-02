<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Keep DB and Auth checks to protect the page
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_auth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inclined Plane - Physics Simulations Lab</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Fonts matching your UI -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #F8F9FA; 
        }
        .font-mono { 
            font-family: 'JetBrains Mono', monospace; 
        }
        input[type=range] {
            accent-color: #4f46e5;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col text-slate-800">
    
    <nav class="bg-white">
        <div class="max-w-[1100px] mx-auto px-6 h-16 flex items-center justify-between">
            <a href="/" class="text-indigo-600 font-black text-xl tracking-tight">Physics Simulations Lab</a>
            <div class="flex items-center gap-4">
                <span class="bg-emerald-50 text-emerald-600 border border-emerald-100 font-bold text-[10px] px-2 py-1 rounded-md uppercase tracking-wide">Grade 10 Ch.3</span>
                <a href="/lab" class="text-indigo-600 font-semibold text-sm hover:text-indigo-800 transition-colors">&larr; All Labs</a>
            </div>
        </div>
    </nav>

    <main class="flex-grow w-full max-w-[1100px] mx-auto px-6 py-8">
        <h1 class="text-[22px] font-bold text-slate-900 tracking-tight mb-8">Inclined Plane & Force Resolution</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            <!-- Left Column: Canvas & Buttons -->
            <div class="lg:col-span-2 bg-white p-8 rounded-[24px] shadow-sm flex flex-col items-center">
                <canvas id="simCanvas" width="600" height="350" class="w-full max-w-[600px] rounded-xl border border-slate-100 bg-slate-50"></canvas>
                
                <div class="flex gap-4 mt-8 w-full justify-center">
                    <button id="runBtn" class="bg-indigo-500 hover:bg-indigo-600 text-white font-medium text-sm py-2.5 px-6 rounded-xl transition-colors">Release Block</button>
                    <button id="resetBtn" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium text-sm py-2.5 px-6 rounded-xl transition-colors">Reset Position</button>
                </div>
            </div>
            
            <!-- Right Column: Telemetry & Controls -->
            <div class="space-y-6">
                
                <!-- Telemetry Card (Dark Theme) -->
                <div class="bg-[#1a1f2e] p-6 rounded-[24px] shadow-sm text-white">
                    <h2 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-5">Force Components</h2>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center border-b border-slate-700/50 pb-2">
                            <span class="text-sm text-slate-300">Gravity (mg):</span>
                            <div class="font-mono text-sm"><span id="statGravity" class="text-slate-100 font-semibold">0.0</span> N</div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-300">Parallel (mg·sinθ):</span>
                            <div class="font-mono text-sm"><span id="statParallel" class="text-sky-400 font-semibold">0.0</span> N</div>
                        </div>
                        <div class="flex justify-between items-center border-b border-slate-700/50 pb-2">
                            <span class="text-sm text-slate-300">Normal (mg·cosθ):</span>
                            <div class="font-mono text-sm"><span id="statNormal" class="text-emerald-400 font-semibold">0.0</span> N</div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-300">Friction (f):</span>
                            <div class="font-mono text-sm"><span id="statFriction" class="text-amber-400 font-semibold">0.0</span> N</div>
                        </div>
                        <div class="flex justify-between items-center pt-2 border-t border-slate-700/50 mt-2">
                            <span class="text-sm text-slate-300">Net Acceleration:</span>
                            <div class="font-mono text-sm"><span id="statAcc" class="text-rose-400 font-bold text-base">0.00</span> m/s²</div>
                        </div>
                    </div>
                </div>

                <!-- Controls Card (Light Theme) -->
                <div class="bg-white p-6 rounded-[24px] shadow-sm">
                    <h2 class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest mb-5">Parameters</h2>
                    
                    <div class="space-y-6">
                        <div>
                            <div class="flex justify-between text-sm mb-3">
                                <label class="text-slate-500">Angle (θ):</label>
                                <span id="angleVal" class="text-indigo-600 font-medium">30°</span>
                            </div>
                            <input type="range" id="angleInput" min="0" max="60" step="1" value="30" class="w-full h-1.5 bg-slate-200 rounded-lg appearance-none cursor-pointer">
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-3">
                                <label class="text-slate-500">Mass (m):</label>
                                <span id="massVal" class="text-indigo-600 font-medium">5.0 kg</span>
                            </div>
                            <input type="range" id="massInput" min="1" max="20" step="1" value="5" class="w-full h-1.5 bg-slate-200 rounded-lg appearance-none cursor-pointer">
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-3">
                                <label class="text-slate-500">Friction (μ):</label>
                                <span id="muVal" class="text-indigo-600 font-medium">0.30</span>
                            </div>
                            <input type="range" id="muInput" min="0.0" max="0.8" step="0.05" value="0.30" class="w-full h-1.5 bg-slate-200 rounded-lg appearance-none cursor-pointer">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
    
    <script src="/js/incline.js"></script>
</body>
</html>