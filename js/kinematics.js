const canvas = document.getElementById('simCanvas');
const ctx = canvas.getContext('2d');

let running = false;
let t = 0;
let u = 2.0, a = 1.5;
let history = []; // stores {t, s, v}

const uInput = document.getElementById('uInput');
const aInput = document.getElementById('aInput');

function updateLabels() {
    document.getElementById('uVal').textContent = u.toFixed(1) + " m/s";
    document.getElementById('aVal').textContent = a.toFixed(1) + " m/s²";
}

uInput.addEventListener('input', (e) => { u = parseFloat(e.target.value); updateLabels(); });
aInput.addEventListener('input', (e) => { a = parseFloat(e.target.value); updateLabels(); });

document.getElementById('startBtn').addEventListener('click', () => { running = true; });
document.getElementById('resetBtn').addEventListener('click', () => {
    running = false;
    t = 0;
    history = [];
    document.getElementById('statTime').textContent = "0.00";
    document.getElementById('statDisp').textContent = "0.0";
    document.getElementById('statVel').textContent = "0.0";
    
    // Draw initial state
    draw();
});

function computePhysics(dt) {
    if (running && t < 6) {
        t += dt;
        
        // Kinematic equations
        const currentS = u * t + 0.5 * a * t * t;
        const currentV = u + a * t;

        history.push({ t, s: Math.max(0, currentS), v: currentV });

        document.getElementById('statTime').textContent = t.toFixed(2);
        document.getElementById('statDisp').textContent = Math.max(0, currentS).toFixed(1);
        document.getElementById('statVel').textContent = currentV.toFixed(1);

        if (t >= 6 || currentS < 0) {
            running = false;
        }
    }
}

function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // 1. Top Section: Track & Moving Body
    const trackY = 80;
    ctx.strokeStyle = '#cbd5e1';
    ctx.lineWidth = 4;
    ctx.beginPath();
    ctx.moveTo(30, trackY);
    ctx.lineTo(570, trackY); // Extended for 600px canvas
    ctx.stroke();

    // Calculate Cart Position
    const currentS = u * t + 0.5 * a * t * t;
    const clampedS = Math.max(0, Math.min(60, currentS));
    
    // Map max displacement (60m) to max track width (540px)
    const pxPerMeter = 540 / 60; 
    const cartX = 35 + clampedS * pxPerMeter;

    // Draw Cart
    ctx.fillStyle = '#6366f1';
    ctx.fillRect(cartX - 15, trackY - 20, 30, 20);
    ctx.fillStyle = '#1e1b4b';
    ctx.beginPath();
    ctx.arc(cartX - 8, trackY, 4, 0, Math.PI * 2);
    ctx.arc(cartX + 8, trackY, 4, 0, Math.PI * 2);
    ctx.fill();

    // 2. Bottom Section: Real-time s-t & v-t Graphs
    const graphBoxY = 140;
    const graphBoxH = 180;
    const graphBoxW = 500; // Expanded width
    const graphOriginX = 50;

    // Graph Grid Frame
    ctx.strokeStyle = '#94a3b8';
    ctx.lineWidth = 1;
    ctx.strokeRect(graphOriginX, graphBoxY, graphBoxW, graphBoxH);

    // Legend
    ctx.font = '10px JetBrains Mono';
    ctx.fillStyle = '#64748b';
    ctx.fillText('v-t curve (sky) & s-t curve (amber)', graphOriginX + 10, graphBoxY + 15);

    if (history.length > 1) {
        // Draw s-t Path (Amber - Displacement vs Time)
        ctx.strokeStyle = '#f59e0b';
        ctx.lineWidth = 2;
        ctx.beginPath();
        history.forEach((pt, idx) => {
            const gx = graphOriginX + (pt.t / 6) * graphBoxW;
            const gy = (graphBoxY + graphBoxH) - (pt.s / 60) * (graphBoxH - 25);
            if (idx === 0) ctx.moveTo(gx, gy);
            else ctx.lineTo(gx, gy);
        });
        ctx.stroke();

        // Draw v-t Path (Sky - Velocity vs Time)
        ctx.strokeStyle = '#0284c7';
        ctx.lineWidth = 2;
        ctx.beginPath();
        history.forEach((pt, idx) => {
            const gx = graphOriginX + (pt.t / 6) * graphBoxW;
            // Center the v=0 axis vertically in case velocity goes negative
            const gy = (graphBoxY + graphBoxH / 2) - (pt.v / 25) * (graphBoxH / 2 - 10);
            if (idx === 0) ctx.moveTo(gx, gy);
            else ctx.lineTo(gx, gy);
        });
        ctx.stroke();
    }
}

let lastTime = performance.now();
function loop(time) {
    const dt = (time - lastTime) / 1000;
    lastTime = time;
    if (dt < 0.1) {
        computePhysics(dt);
        draw();
    }
    requestAnimationFrame(loop);
}

// Initial draw
draw();
requestAnimationFrame(loop);