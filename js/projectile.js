const canvas = document.getElementById('simCanvas');
const ctx = canvas.getContext('2d');

let running = false;
let t = 0;
let v0 = 18, angleDeg = 45, targetX = 320;
const g = 9.81;
const startX = 60, startY = 260;
let targetHit = false;

const v0Input = document.getElementById('v0Input');
const angleInput = document.getElementById('angleInput');
const targetPosInput = document.getElementById('targetPosInput');

function updateLabels() {
    document.getElementById('v0Val').textContent = v0 + " m/s";
    document.getElementById('angleVal').textContent = angleDeg + "°";
    document.getElementById('targetPosVal').textContent = targetX + " m";
}

v0Input.addEventListener('input', (e) => { v0 = parseFloat(e.target.value); updateLabels(); });
angleInput.addEventListener('input', (e) => { angleDeg = parseFloat(e.target.value); updateLabels(); });
targetPosInput.addEventListener('input', (e) => { targetX = parseInt(e.target.value); updateLabels(); });

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
});

function computePhysics(dt) {
    if (running) {
        t += dt;
        const rad = angleDeg * Math.PI / 180;
        const currentX = startX + v0 * Math.cos(rad) * t * 12;
        const currentY = startY - (v0 * Math.sin(rad) * t - 0.5 * g * t * t) * 12;

        // Target collision check (Target located at targetX, ground height startY)
        if (!targetHit && Math.abs(currentX - targetX) < 15 && currentY >= startY - 15) {
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

    // Ground plane
    ctx.strokeStyle = '#cbd5e1';
    ctx.lineWidth = 4;
    ctx.beginPath();
    ctx.moveTo(30, startY);
    ctx.lineTo(470, startY);
    ctx.stroke();

    // Draw Predictive Targeting Route (Dotted Parabola Curve)
    ctx.strokeStyle = '#cbd5e1';
    ctx.lineWidth = 2;
    ctx.setLineDash([4, 4]);
    ctx.beginPath();
    const rad = angleDeg * Math.PI / 180;
    for (let pt = 0; pt <= 4; pt += 0.1) {
        const px = startX + v0 * Math.cos(rad) * pt * 12;
        const py = startY - (v0 * Math.sin(rad) * pt - 0.5 * g * pt * pt) * 12;
        if (py <= startY) {
            if (pt === 0) ctx.moveTo(px, py);
            else ctx.lineTo(px, py);
        }
    }
    ctx.stroke();
    ctx.setLineDash([]); // Reset line dash

    // Draw Target Box
    ctx.fillStyle = '#dc2626';
    ctx.fillRect(targetX - 8, startY - 24, 16, 24);

    // Live Projectile Ball
    const currentX = startX + v0 * Math.cos(rad) * t * 12;
    const currentY = Math.min(startY, startY - (v0 * Math.sin(rad) * t - 0.5 * g * t * t) * 12);

    ctx.fillStyle = '#059669';
    ctx.beginPath();
    ctx.arc(currentX, currentY, 8, 0, 2 * Math.PI);
    ctx.fill();

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
requestAnimationFrame(loop);