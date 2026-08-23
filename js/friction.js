const canvas = document.getElementById('simCanvas');
const ctx = canvas.getContext('2d');

let running = false;
let x = 50; // Starting position
let v = 0, a = 0;
let mass = 5.0, appliedForce = 15, mu = 0.2;
const g = 9.81;
const scale = 15; // px per meter

const forceInput = document.getElementById('forceInput');
const massInput = document.getElementById('massInput');
const muInput = document.getElementById('muInput');

function updateLabels() {
    document.getElementById('forceVal').textContent = appliedForce + " N";
    document.getElementById('massVal').textContent = mass.toFixed(1) + " kg";
    document.getElementById('muVal').textContent = mu.toFixed(2);
}

forceInput.addEventListener('input', (e) => { appliedForce = parseFloat(e.target.value); updateLabels(); draw(); });
massInput.addEventListener('input', (e) => { mass = parseFloat(e.target.value); updateLabels(); draw(); });
muInput.addEventListener('input', (e) => { mu = parseFloat(e.target.value); updateLabels(); draw(); });

document.getElementById('runBtn').addEventListener('click', () => { running = !running; });
document.getElementById('resetBtn').addEventListener('click', () => {
    running = false;
    x = 50; 
    v = 0; 
    a = 0;
    document.getElementById('statVel').textContent = "0.00";
    document.getElementById('statAcc').textContent = "0.00";
    draw();
});

function computePhysics(dt) {
    const normalForce = mass * g;
    const maxStaticFriction = mu * normalForce;
    let frictionForce = 0;

    // Check if stationary
    if (Math.abs(v) < 0.001) {
        if (appliedForce <= maxStaticFriction) {
            // Not enough force to overcome static friction
            a = 0;
            frictionForce = appliedForce; 
        } else {
            // Overcame static friction, now moving (using same mu for simplicity)
            frictionForce = mu * normalForce;
            a = (appliedForce - frictionForce) / mass;
        }
    } else {
        // Already in motion
        frictionForce = mu * normalForce;
        a = (appliedForce - frictionForce) / mass;
    }

    if (running) {
        v += a * dt;
        // Prevent floating point drift backwards if applied force drops while stationary
        if (v < 0 && a <= 0) v = 0; 

        x += v * scale * dt;
        
        // Canvas Boundaries
        if (x > canvas.width - 90) { 
            x = canvas.width - 90; 
            v = 0; 
            running = false; 
        }
    }

    document.getElementById('statVel').textContent = v.toFixed(2);
    document.getElementById('statAcc').textContent = a.toFixed(2);
    document.getElementById('statFriction').textContent = frictionForce.toFixed(1);
    
    return frictionForce;
}

function drawArrow(fromX, fromY, toX, toY, color, label) {
    const headlen = 10;
    const dx = toX - fromX;
    const dy = toY - fromY;
    const angle = Math.atan2(dy, dx);
    
    ctx.strokeStyle = color;
    ctx.fillStyle = color;
    ctx.lineWidth = 3;
    
    // Line
    ctx.beginPath();
    ctx.moveTo(fromX, fromY);
    ctx.lineTo(toX, toY);
    ctx.stroke();
    
    // Arrowhead
    ctx.beginPath();
    ctx.moveTo(toX, toY);
    ctx.lineTo(toX - headlen * Math.cos(angle - Math.PI / 6), toY - headlen * Math.sin(angle - Math.PI / 6));
    ctx.lineTo(toX - headlen * Math.cos(angle + Math.PI / 6), toY - headlen * Math.sin(angle + Math.PI / 6));
    ctx.fill();

    // Label
    ctx.font = 'bold 12px Plus Jakarta Sans';
    ctx.fillText(label, fromX + dx/2 - 10, fromY - 10);
}

function draw(frictionForce = 0) {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    const groundY = 220;

    // Draw Ground
    ctx.fillStyle = '#f1f5f9';
    ctx.fillRect(0, groundY, canvas.width, canvas.height - groundY);
    ctx.strokeStyle = '#cbd5e1';
    ctx.lineWidth = 4;
    ctx.beginPath();
    ctx.moveTo(0, groundY);
    ctx.lineTo(canvas.width, groundY);
    ctx.stroke();

    // Draw Distance Markers
    ctx.fillStyle = '#94a3b8';
    ctx.font = '10px JetBrains Mono';
    for(let i = 50; i < canvas.width; i += 150) {
        ctx.beginPath(); ctx.moveTo(i, groundY); ctx.lineTo(i, groundY + 10); ctx.stroke();
        ctx.fillText(`${(i-50)/scale}m`, i - 10, groundY + 22);
    }

    // Draw Block
    const blockW = 60, blockH = 40;
    ctx.fillStyle = '#0ea5e9'; // Sky
    ctx.fillRect(x, groundY - blockH, blockW, blockH);
    ctx.strokeStyle = '#0284c7';
    ctx.lineWidth = 2;
    ctx.strokeRect(x, groundY - blockH, blockW, blockH);
    
    // Mass Label
    ctx.fillStyle = '#ffffff';
    ctx.textAlign = 'center';
    ctx.font = 'bold 14px Plus Jakarta Sans';
    ctx.fillText(`${mass} kg`, x + blockW / 2, groundY - blockH + 25);

    // Vector Force Arrows
    const cy = groundY - blockH / 2;
    
    // Applied Force (Red, Right)
    if (appliedForce > 0) {
        const forceLen = Math.min(120, appliedForce * 2);
        drawArrow(x + blockW, cy, x + blockW + forceLen, cy, '#f43f5e', `F = ${appliedForce}N`);
    }

    // Friction Force (Amber, Left)
    if (frictionForce > 0) {
        // If stationary, calculate friction visually before running
        const renderFriction = running ? frictionForce : (appliedForce <= mu * mass * g ? appliedForce : mu * mass * g);
        const fricLen = Math.min(120, renderFriction * 2);
        drawArrow(x, cy, x - fricLen, cy, '#f59e0b', `f = ${renderFriction.toFixed(1)}N`);
    }
}

let lastTime = performance.now();
function loop(time) {
    const dt = (time - lastTime) / 1000;
    lastTime = time;
    
    let currentFriction = 0;
    if (dt < 0.1) {
        currentFriction = computePhysics(dt);
        draw(currentFriction);
    }
    requestAnimationFrame(loop);
}

// Initial draw state
updateLabels();
const initialFriction = appliedForce <= (mu * mass * g) ? appliedForce : (mu * mass * g);
draw(initialFriction);
document.getElementById('statFriction').textContent = initialFriction.toFixed(1);

requestAnimationFrame(loop);