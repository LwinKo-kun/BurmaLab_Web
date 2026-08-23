const canvas = document.getElementById('simCanvas');
const ctx = canvas.getContext('2d');

let isRunning = false;
const g = 9.81;
const restLength = 160; // pixels
const scale = 100; // 1 meter = 100 pixels

// System A State (Left)
let kA = 50, massA = 2.0;
let yA = restLength, velocityA = 0;
const originXA = canvas.width / 4; // 175px

// System B State (Right)
let kB = 100, massB = 4.0;
let yB = restLength, velocityB = 0;
const originXB = (3 * canvas.width) / 4; // 525px

// Control Bindings - System A
document.getElementById('kInputA').addEventListener('input', e => { kA = parseFloat(e.target.value); document.getElementById('kValA').textContent = kA + " N/m"; });
document.getElementById('mInputA').addEventListener('input', e => { massA = parseFloat(e.target.value); document.getElementById('mValA').textContent = massA.toFixed(1) + " kg"; });

// Control Bindings - System B
document.getElementById('kInputB').addEventListener('input', e => { kB = parseFloat(e.target.value); document.getElementById('kValB').textContent = kB + " N/m"; });
document.getElementById('mInputB').addEventListener('input', e => { massB = parseFloat(e.target.value); document.getElementById('mValB').textContent = massB.toFixed(1) + " kg"; });

document.getElementById('releaseBtn').addEventListener('click', () => { isRunning = true; velocityA = 0; velocityB = 0; });
document.getElementById('resetBtn').addEventListener('click', () => { 
    isRunning = false; 
    yA = restLength; velocityA = 0; 
    yB = restLength; velocityB = 0; 
});

function computePhysics(dt) {
    if (isRunning) {
        // System A Physics
        const dispA = (yA - restLength) / scale;
        const forceA = -kA * dispA;
        const netA = forceA + (massA * g) - (1.0 * velocityA);
        velocityA += (netA / massA) * dt;
        yA += velocityA * scale * dt;

        document.getElementById('statDispointA').textContent = dispA.toFixed(3) + " m";
        document.getElementById('statForceA').textContent = Math.abs(forceA).toFixed(1) + " N";
        document.getElementById('statEpA').textContent = (0.5 * kA * dispA * dispA).toFixed(2) + " J";

        // System B Physics
        const dispB = (yB - restLength) / scale;
        const forceB = -kB * dispB;
        const netB = forceB + (massB * g) - (1.0 * velocityB);
        velocityB += (netB / massB) * dt;
        yB += velocityB * scale * dt;

        document.getElementById('statDispointB').textContent = dispB.toFixed(3) + " m";
        document.getElementById('statForceB').textContent = Math.abs(forceB).toFixed(1) + " N";
        document.getElementById('statEpB').textContent = (0.5 * kB * dispB * dispB).toFixed(2) + " J";
    } else {
        document.getElementById('statDispointA').textContent = "0.00 m";
        document.getElementById('statForceA').textContent = "0.0 N";
        document.getElementById('statEpA').textContent = "0.00 J";

        document.getElementById('statDispointB').textContent = "0.00 m";
        document.getElementById('statForceB').textContent = "0.0 N";
        document.getElementById('statEpB').textContent = "0.00 J";
    }
}

function drawSpring(xPos, currentY, stiffness) {
    // Spring wire thickness varies based on stiffness 'k'
    const wireThickness = Math.max(1.5, Math.min(5, stiffness / 30));
    
    ctx.strokeStyle = '#0284c7';
    ctx.lineWidth = wireThickness;
    ctx.beginPath();
    ctx.moveTo(xPos, 16);
    
    const coils = 14;
    const coilHeight = (currentY - 16) / coils;
    
    for (let i = 1; i <= coils; i++) {
        const cx = xPos + (i % 2 === 0 ? 14 : -14);
        const cy = 16 + i * coilHeight;
        ctx.lineTo(cx, cy);
    }
    ctx.lineTo(xPos, currentY);
    ctx.stroke();
}

function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    // Ceiling Anchor Mount Bar
    ctx.fillStyle = '#475569';
    ctx.fillRect(40, 0, canvas.width - 80, 16);

    // Equilibrium Marker Dashed Line across both sides
    ctx.strokeStyle = '#cbd5e1';
    ctx.setLineDash([6, 6]);
    ctx.beginPath();
    ctx.moveTo(40, restLength);
    ctx.lineTo(canvas.width - 40, restLength);
    ctx.stroke();
    ctx.setLineDash([]);
    ctx.fillStyle = '#64748b';
    ctx.font = '11px Plus Jakarta Sans, sans-serif';
    ctx.fillText('Equilibrium (x = 0)', 50, restLength - 8);

    const currentYA = isRunning ? yA : restLength;
    const currentYB = isRunning ? yB : restLength;

    // Draw System A (Left Spring & Mass)
    drawSpring(originXA, currentYA, kA);
    ctx.fillStyle = '#4f46e5';
    ctx.fillRect(originXA - 35, currentYA, 70, 45);
    ctx.strokeStyle = '#3730a3'; ctx.lineWidth = 2;
    ctx.strokeRect(originXA - 35, currentYA, 70, 45);
    ctx.fillStyle = '#fff'; ctx.textAlign = 'center'; ctx.font = 'bold 11px JetBrains Mono, monospace';
    ctx.fillText(massA.toFixed(1) + ' kg', originXA, currentYA + 27);

    // Draw System B (Right Spring & Mass)
    drawSpring(originXB, currentYB, kB);
    ctx.fillStyle = '#10b981';
    ctx.fillRect(originXB - 35, currentYB, 70, 45);
    ctx.strokeStyle = '#047857'; ctx.lineWidth = 2;
    ctx.strokeRect(originXB - 35, currentYB, 70, 45);
    ctx.fillStyle = '#fff'; ctx.textAlign = 'center'; ctx.font = 'bold 11px JetBrains Mono, monospace';
    ctx.fillText(massB.toFixed(1) + ' kg', originXB, currentYB + 27);
}

let lastTime = performance.now();
function loop(time) {
    const dt = Math.min((time - lastTime) / 1000, 0.1);
    lastTime = time;
    computePhysics(dt);
    draw();
    requestAnimationFrame(loop);
}
requestAnimationFrame(loop);