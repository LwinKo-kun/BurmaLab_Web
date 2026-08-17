<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friction Dynamics - BurmaLab</title>
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
        <h1 class="lab-title">Horizontal Friction Lab</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
            <div class="md:col-span-2 lab-card lab-canvas-wrap flex flex-col items-center">
                <canvas id="simCanvas" width="500" height="300"></canvas>
                <div class="flex gap-4 mt-4 w-full justify-center">
                    <button id="runBtn" class="lab-btn-primary">Start / Pause</button>
                    <button id="resetBtn" class="lab-btn-secondary">Reset</button>
                </div>
            </div>
            <div class="space-y-6">
                <div class="lab-telemetry">
                    <h2>Live Telemetry</h2>
                    <div class="stat-row"><span>Velocity:</span> <span id="statVel" class="stat-val">0.00</span> m/s</div>
                    <div class="stat-row"><span>Acceleration:</span> <span id="statAcc" class="stat-val">0.00</span> m/s²</div>
                    <div class="stat-row"><span>Friction:</span> <span id="statFriction" class="stat-val">0.0</span> N</div>
                </div>
                <div class="lab-card lab-controls space-y-4">
                    <h2 class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Controls</h2>
                    <div>
                        <div class="flex justify-between text-sm mb-1"><label for="forceInput">Applied Force:</label><span id="forceVal" class="font-semibold text-indigo-600">15 N</span></div>
                        <input type="range" id="forceInput" min="0" max="60" step="1" value="15" class="lab-range">
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1"><label for="massInput">Mass:</label><span id="massVal" class="font-semibold text-indigo-600">5.0 kg</span></div>
                        <input type="range" id="massInput" min="1" max="25" step="0.5" value="5" class="lab-range">
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1"><label for="muInput">Friction (μ):</label><span id="muVal" class="font-semibold text-indigo-600">0.20</span></div>
                        <input type="range" id="muInput" min="0.0" max="0.8" step="0.05" value="0.2" class="lab-range">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/friction.js"></script>
</body>
</html>
