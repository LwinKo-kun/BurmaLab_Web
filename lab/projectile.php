<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projectile Motion - BurmaLab</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/lab.css">
</head>
<body class="lab-page">
    <nav class="lab-nav">
        <a href="/" class="brand">BurmaLab</a>
        <div class="flex items-center gap-3">
            <span class="lab-badge">Grade 11 Ch.1</span>
            <a href="/lab" class="back">&larr; All Labs</a>
        </div>
    </nav>
    <div class="lab-shell space-y-6">
        <h1 class="lab-title">Projectile Motion Lab</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
            <div class="md:col-span-2 lab-card lab-canvas-wrap flex flex-col items-center">
                <canvas id="simCanvas" width="500" height="300"></canvas>
                <div class="flex gap-4 mt-4 w-full justify-center">
                    <button id="fireBtn" class="lab-btn-primary">Fire Projectile</button>
                    <button id="resetBtn" class="lab-btn-secondary">Reset</button>
                </div>
            </div>
            <div class="space-y-6">
                <div class="lab-telemetry">
                    <h2>Flight & Target Status</h2>
                    <div class="stat-row"><span>Max Height:</span> <span id="statHeight" class="stat-val">0.0</span> m</div>
                    <div class="stat-row"><span>Range:</span> <span id="statRange" class="stat-val">0.0</span> m</div>
                    <div class="stat-row"><span>Hit Status:</span> <span id="statHit" class="stat-val">Pending</span></div>
                </div>
                <div class="lab-card lab-controls space-y-4">
                    <h2 class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Controls</h2>
                    <div>
                        <div class="flex justify-between text-sm mb-1"><label for="v0Input">Initial Speed:</label><span id="v0Val" class="font-semibold text-indigo-600">18 m/s</span></div>
                        <input type="range" id="v0Input" min="5" max="30" step="1" value="18" class="lab-range">
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1"><label for="angleInput">Launch Angle:</label><span id="angleVal" class="font-semibold text-indigo-600">45°</span></div>
                        <input type="range" id="angleInput" min="15" max="75" step="1" value="45" class="lab-range">
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1"><label for="targetPosInput">Target Distance:</label><span id="targetPosVal" class="font-semibold text-indigo-600">320 m</span></div>
                        <input type="range" id="targetPosInput" min="200" max="420" step="10" value="320" class="lab-range">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/projectile.js"></script>
</body>
</html>
