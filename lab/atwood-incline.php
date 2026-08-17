<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incline & Pulley Simulation</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans p-6">
    <div class="max-w-4xl mx-auto space-y-6">
        <nav class="flex items-center justify-between">
            <a href="/lab" class="text-sm font-semibold text-blue-600 hover:underline">&larr; Back to Modules</a>
            <h1 class="text-xl font-bold text-slate-900">Incline & Pulley System Lab</h1>
        </nav>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
            <div class="md:col-span-2 bg-white p-4 rounded-xl shadow-sm border border-slate-200 flex flex-col items-center">
                <canvas id="simCanvas" width="500" height="300" class="border border-slate-100 rounded-lg bg-white"></canvas>
                <div class="flex gap-4 mt-4 w-full justify-center">
                    <button id="runBtn" class="px-5 py-2 bg-indigo-600 text-white font-medium rounded-lg shadow hover:bg-indigo-700 transition">Start / Pause</button>
                    <button id="resetBtn" class="px-5 py-2 bg-slate-200 text-slate-700 font-medium rounded-lg hover:bg-slate-300 transition">Reset</button>
                </div>
            </div>
            <div class="space-y-6">
                <div class="bg-slate-900 text-white p-4 rounded-xl shadow-sm">
                    <h2 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Live Telemetry</h2>
                    <div class="space-y-2 text-sm font-mono">
                        <div class="flex justify-between"><span>System Vel:</span> <span id="statVel" class="text-sky-400 font-bold">0.00</span> m/s</div>
                        <div class="flex justify-between"><span>Acceleration:</span> <span id="statAcc" class="text-sky-400 font-bold">0.00</span> m/s²</div>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200 space-y-4">
                    <h2 class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Controls</h2>
                    <div>
                        <div class="flex justify-between text-sm mb-1"><label for="m1Input">Mass 1 (Hanging):</label><span id="m1Val" class="font-semibold text-indigo-600">3.0 kg</span></div>
                        <input type="range" id="m1Input" min="1" max="15" step="0.5" value="3" class="w-full accent-indigo-600 cursor-pointer">
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1"><label for="m2Input">Mass 2 (Ramp):</label><span id="m2InputVal" class="font-semibold text-indigo-600">4.0 kg</span></div>
                        <input type="range" id="m2Input" min="1" max="15" step="0.5" value="4" class="w-full accent-indigo-600 cursor-pointer">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/atwood-incline.js"></script>
</body>
</html>