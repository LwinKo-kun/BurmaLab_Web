const canvas = document.getElementById('simCanvas');
const ctx = canvas.getContext('2d');

let running = false;
let t = 0;
let v0 = 18, angleDeg = 45, targetX = 320;
const g = 9.81;
const startX = 60, startY = 240; // Adjusted for 600x300 canvas
let targetHit = false;

const v0Input = document.getElementById('v0Input');
const angleInput = document.getElementById('angleInput');
const targetPosInput = document.getElementById('targetPosInput');

function updateLabels() {
    document.getElementById('v0Val').textContent = v0 + " m/s";
    document.getElementById('angleVal').textContent = angleDeg + "°";
    document.getElementById('targetPosVal').textContent = targetX + " m";
}

v0Input.addEventListener('input', (e) => { v0 = parseFloat(e.target.value); updateLabels(); draw(); });
angleInput.addEventListener('input', (e) => { angleDeg = parseFloat(e.target.value); updateLabels(); draw(); });
targetPosInput.addEventListener('input', (e) => { targetX = parseInt(e.target.value); updateLabels(); draw(); });

document.getElementById('fireBtn').addEventListener('click', () => { 
    t = 0; 
    running = true; 
    targetHit = false;
    document.getElementById('statHit').textContent = "In Flight";
    document.getElementById('statHit').className = "text-sky-400 font-bold";
});

document.getElementById('resetBtn').addEventListener('click', () => { 
    running = false; 
    t = 0; 
    targetHit = false;
    document.getElementById('statHit').textContent = "Pending";
    document.getElementById('statHit').className = "text-amber-400 font-bold";
    draw();
});

function computePhysics(dt) {
    if (running) {
        t += dt;
        const rad = angleDeg * Math.PI / 180;
        const currentX = startX + v0 * Math.cos(rad) * t * 14; // Scaled for 600px width
        const currentY = startY - (v0 * Math.sin(rad) * t - 0.5 * g * t * t) * 14;

        // Target collision check
        if (!targetHit && Math.abs(currentX - targetX) < 18 && currentY >= startY - 25) {
            targetHit = true;
            document.getElementById('statHit').textContent = "TARGET HIT! 🎯";
            document.getElementById('statHit').className = "text-emerald-400 font-bold";
        }

        if (currentY >= startY) {
            running = false;
            if (!targetHit) {
                document.getElementById('statHit').textContent = "Missed";
                document.getElementById('statHit').className = "text-rose-400 font-bold";
            }
        }
    }
}

function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Grid Background Lines
    ctx.strokeStyle = '#f1f5f9';
    ctx.lineWidth = 1;
    for (let i = 0; i < canvas.width; i += 50) {
        ctx.beginPath(); ctx.moveTo(i, 0); ctx.lineTo(i, canvas.height); ctx.stroke();
    }

    // Ground plane
    ctx.strokeStyle = '#94a3b8';
    ctx.lineWidth = 4;
    ctx.beginPath();
    ctx.moveTo(30, startY);
    ctx.lineTo(canvas.width - 30, startY);
    ctx.stroke();

    // Draw Predictive Targeting Route (Dotted Parabola Curve)
    ctx.strokeStyle = '#cbd5e1';
    ctx.lineWidth = 2;
    ctx.setLineDash([4, 4]);
    ctx.beginPath();
    const rad = angleDeg * Math.PI / 180;
    for (let pt = 0; pt <= 6; pt += 0.1) {
        const px = startX + v0 * Math.cos(rad) * pt * 14;
        const py = startY - (v0 * Math.sin(rad) * pt - 0.5 * g * pt * pt) * 14;
        if (py <= startY) {
            if (pt === 0) ctx.moveTo(px, py);
            else ctx.lineTo(px, py);
        }
    }
    ctx.stroke();
    ctx.setLineDash([]); 

    // Draw Target Box
    ctx.fillStyle = '#f43f5e';
    ctx.fillRect(targetX - 8, startY - 24, 16, 24);
    ctx.strokeStyle = '#be123c';
    ctx.lineWidth = 2;
    ctx.strokeRect(targetX - 8, startY - 24, 16, 24);

    // Live Projectile Ball position
    const currentX = startX + v0 * Math.cos(rad) * t * 14;
    const currentY = Math.min(startY, startY - (v0 * Math.sin(rad) * t - 0.5 * g * t * t) * 14);

    ctx.fillStyle = '#059669';
    ctx.beginPath();
    ctx.arc(currentX, currentY, 8, 0, 2 * Math.PI);
    ctx.fill();
    ctx.strokeStyle = '#047857';
    ctx.stroke();

    const maxHeight = Math.max(0, (Math.pow(v0 * Math.sin(rad), 2) / (2 * g)));
    const range = (Math.pow(v0, 2) * Math.sin(2 * rad)) / g;

    document.getElementById('statHeight').textContent = maxHeight.toFixed(1);
    document.getElementById('statRange').textContent = (running || t > 0 ? range : 0).toFixed(1);
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

updateLabels();
draw();
requestAnimationFrame(loop);