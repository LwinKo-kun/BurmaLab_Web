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
    <title>Kinematic Motion & Graphs - BurmaLab</title>
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
    
    <!-- Top Navigation -->
    <nav class="bg-white">
        <div class="max-w-[1100px] mx-auto px-6 h-16 flex items-center justify-between">
            <a href="/" class="text-indigo-600 font-black text-xl tracking-tight">BurmaLab</a>
            <div class="flex items-center gap-4">
                <span class="bg-indigo-50 text-indigo-600 border border-indigo-100 font-bold text-[10px] px-2 py-1 rounded-md uppercase tracking-wide">Grade 10 Ch.2</span>
                <a href="/lab" class="text-indigo-600 font-semibold text-sm hover:text-indigo-800 transition-colors">&larr; All Labs</a>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="flex-grow w-full max-w-[1100px] mx-auto px-6 py-8">
        <h1 class="text-[22px] font-bold text-slate-900 tracking-tight mb-8">Kinematics & Motion Graphs</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            <!-- Left Column: Canvas & Buttons -->
            <div class="lg:col-span-2 bg-white p-8 rounded-[24px] shadow-sm flex flex-col items-center">
                <canvas id="simCanvas" width="600" height="350" class="w-full max-w-[600px] rounded-xl"></canvas>
                
                <div class="flex gap-4 mt-8 w-full justify-center">
                    <button id="startBtn" class="bg-indigo-500 hover:bg-indigo-600 text-white font-medium text-sm py-2.5 px-6 rounded-xl transition-colors">Start Run</button>
                    <button id="resetBtn" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium text-sm py-2.5 px-6 rounded-xl transition-colors">Reset</button>
                </div>
            </div>
            
            <!-- Right Column: Telemetry & Controls -->
            <div class="space-y-6">
                
                <!-- Telemetry Card (Dark Theme) -->
                <div class="bg-[#1a1f2e] p-6 rounded-[24px] shadow-sm text-white">
                    <h2 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-5">Live Motion Status</h2>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-300">Time (t):</span>
                            <div class="font-mono text-sm">
                                <span id="statTime" class="text-emerald-400 font-semibold">0.00</span> <span class="text-slate-500 ml-2">s</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-300">Displacement (s):</span>
                            <div class="font-mono text-sm">
                                <span id="statDisp" class="text-amber-400 font-semibold">0.0</span> <span class="text-slate-500 ml-2">m</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-300">Velocity (v):</span>
                            <div class="font-mono text-sm">
                                <span id="statVel" class="text-sky-400 font-semibold">0.0</span> <span class="text-slate-500 ml-2">m/s</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Controls Card (Light Theme) -->
                <div class="bg-white p-6 rounded-[24px] shadow-sm">
                    <h2 class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest mb-5">Parameters</h2>
                    
                    <div class="space-y-6">
                        <div>
                            <div class="flex justify-between text-sm mb-3">
                                <label class="text-slate-500" for="uInput">Initial Velocity (u):</label>
                                <span id="uVal" class="text-indigo-600 font-medium">2.0 m/s</span>
                            </div>
                            <input type="range" id="uInput" min="0" max="15" step="0.5" value="2.0" class="w-full h-1.5 bg-slate-200 rounded-lg appearance-none cursor-pointer">
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-3">
                                <label class="text-slate-500" for="aInput">Acceleration (a):</label>
                                <span id="aVal" class="text-indigo-600 font-medium">1.5 m/s²</span>
                            </div>
                            <input type="range" id="aInput" min="-5" max="5" step="0.5" value="1.5" class="w-full h-1.5 bg-slate-200 rounded-lg appearance-none cursor-pointer">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
    
    <script src="/js/kinematics.js"></script>
</body>
</html>