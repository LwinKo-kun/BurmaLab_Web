<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Momentum & Collisions - BurmaLab</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/lab.css">
</head>
<body class="lab-page">
    <nav class="lab-nav">
        <a href="/" class="brand">BurmaLab</a>
        <div class="flex items-center gap-3">
            <span class="lab-badge">Grade 10 Ch.3</span>
            <a href="/lab" class="back">&larr; All Labs</a>
        </div>
    </nav>
    <div class="lab-shell space-y-6">
        <h1 class="lab-title">Momentum & Collisions Lab</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
            <div class="md:col-span-2 lab-card lab-canvas-wrap flex flex-col items-center">
                <canvas id="simCanvas" width="500" height="300"></canvas>
                <div class="flex gap-4 mt-4 w-full justify-center">
                    <button id="runBtn" class="lab-btn-primary">Trigger Impact</button>
                    <button id="resetBtn" class="lab-btn-secondary">Reset</button>
                </div>
            </div>
            <div class="space-y-6">
                <div class="lab-telemetry">
                    <h2>System Momentum</h2>
                    <div class="stat-row"><span>Total P:</span> <span id="statMom" class="stat-val">0.00</span> kg·m/s</div>
                </div>
                <div class="lab-card lab-controls space-y-4">
                    <h2 class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Controls</h2>
                    <div>
                        <div class="flex justify-between text-sm mb-1"><label for="m1Input">Mass 1 (m₁):</label><span id="m1Val" class="font-semibold text-indigo-600">2.0 kg</span></div>
                        <input type="range" id="m1Input" min="0.5" max="10" step="0.5" value="2" class="lab-range">
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1"><label for="v1Input">Velocity 1 (v₁):</label><span id="v1Val" class="font-semibold text-indigo-600">4.0 m/s</span></div>
                        <input type="range" id="v1Input" min="1" max="10" step="0.5" value="4" class="lab-range">
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1"><label for="m2Input">Mass 2 (m₂):</label><span id="m2Val" class="font-semibold text-indigo-600">3.0 kg</span></div>
                        <input type="range" id="m2Input" min="0.5" max="10" step="0.5" value="3" class="lab-range">
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1"><label for="eInput">Elasticity (e):</label><span id="eVal" class="font-semibold text-indigo-600">1.0</span></div>
                        <input type="range" id="eInput" min="0.0" max="1.0" step="0.1" value="1.0" class="lab-range">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/collisions.js"></script>
</body>
</html>
