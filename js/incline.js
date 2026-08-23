const canvas = document.getElementById('simCanvas');
const ctx = canvas.getContext('2d');

let running = false;
let thetaDeg = 30;
let mass = 5.0;
let mu = 0.30;
let posX = 400; // Starting position (distance up the ramp)
let velocity = 0;

const g = 9.81;
const scale = 20; // pixels per meter

const angleInput = document.getElementById('angleInput');
const massInput = document.getElementById('massInput');
const muInput = document.getElementById('muInput');

function updateLabels() {
    document.getElementById('angleVal').textContent = thetaDeg + "°";
    document.getElementById('massVal').textContent = mass.toFixed(1) + " kg";
    document.getElementById('muVal').textContent = mu.toFixed(2);
    
    // Physics calculations for telemetry
    const theta = thetaDeg * Math.PI / 180;
    const Fg = mass * g;
    const F_parallel = Fg * Math.sin(theta);
    const F_normal = Fg * Math.cos(theta);
    const f_max = mu * F_normal;
    
    let friction = 0;
    let netForce = 0;
    let acc = 0;

    if (F_parallel <= f_max && velocity === 0) {
        friction = F_parallel; // Static friction holds it
        acc = 0;
    } else {
        friction = f_max; // Kinetic friction (assuming mu_k = mu_s for simplicity)
        netForce = F_parallel - friction;
        acc = netForce / mass;
    }

    document.getElementById('statGravity').textContent = Fg.toFixed(1);
    document.getElementById('statParallel').textContent = F_parallel.toFixed(1);
    document.getElementById('statNormal').textContent = F_normal.toFixed(1);
    document.getElementById('statFriction').textContent = friction.toFixed(1);
    document.getElementById('statAcc').textContent = acc.toFixed(2);
}

[angleInput, massInput, muInput].forEach(el => {
    el.addEventListener('input', (e) => {
        if (el === angleInput) thetaDeg = parseFloat(e.target.value);
        if (el === massInput) mass = parseFloat(e.target.value);
        if (el === muInput) mu = parseFloat(e.target.value);
        
        updateLabels();
        if (!running) draw();
    });
});

document.getElementById('runBtn').addEventListener('click', () => { running = true; });
document.getElementById('resetBtn').addEventListener('click', () => {
    running = false;
    posX = 400; 
    velocity = 0;
    updateLabels();
    draw();
});

function computePhysics(dt) {
    if (running) {
        const theta = thetaDeg * Math.PI / 180;
        const Fg = mass * g;
        const F_parallel = Fg * Math.sin(theta);
        const F_normal = Fg * Math.cos(theta);
        const f_max = mu * F_normal;

        let acc = 0;
        if (F_parallel > f_max || velocity > 0) {
            acc = (F_parallel - f_max) / mass;
        }

        velocity += acc * dt;
        posX -= velocity * scale * dt; // Subtracting because origin (0,0) is at bottom of ramp

        // Stop at the bottom
        if (posX <= 30) {
            posX = 30;
            velocity = 0;
            running = false;
        }
    }
}

function drawArrow(fx, fy, tx, ty, color, label) {
    const headlen = 8;
    const angle = Math.atan2(ty - fy, tx - fx);
    
    ctx.strokeStyle = color;
    ctx.fillStyle = color;
    ctx.lineWidth = 2;
    
    ctx.beginPath(); ctx.moveTo(fx, fy); ctx.lineTo(tx, ty); ctx.stroke();
    
    ctx.beginPath();
    ctx.moveTo(tx, ty);
    ctx.lineTo(tx - headlen * Math.cos(angle - Math.PI / 6), ty - headlen * Math.sin(angle - Math.PI / 6));
    ctx.lineTo(tx - headlen * Math.cos(angle + Math.PI / 6), ty - headlen * Math.sin(angle + Math.PI / 6));
    ctx.fill();

    ctx.font = 'bold 11px Plus Jakarta Sans';
    ctx.fillText(label, tx + 5, ty + 5);
}

function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    const theta = thetaDeg * Math.PI / 180;
    const pivotX = 100;
    const pivotY = 280;
    const rampLength = 450;

    // Draw Ground
    ctx.strokeStyle = '#cbd5e1';
    ctx.lineWidth = 3;
    ctx.beginPath(); ctx.moveTo(0, pivotY); ctx.lineTo(canvas.width, pivotY); ctx.stroke();

    // Draw Ramp Triangle
    const topX = pivotX + rampLength * Math.cos(theta);
    const topY = pivotY - rampLength * Math.sin(theta);
    
    ctx.fillStyle = '#e2e8f0';
    ctx.beginPath();
    ctx.moveTo(pivotX, pivotY);
    ctx.lineTo(topX, topY);
    ctx.lineTo(topX, pivotY);
    ctx.closePath();
    ctx.fill();
    ctx.strokeStyle = '#94a3b8';
    ctx.stroke();

    // Context Transform for the Block (Rotated to match ramp)
    ctx.save();
    ctx.translate(pivotX, pivotY);
    ctx.rotate(-theta);

    const bw = 50;
    const bh = 50;
    
    // Draw Block
    ctx.fillStyle = '#0ea5e9';
    ctx.fillRect(posX - bw/2, -bh, bw, bh);
    ctx.strokeStyle = '#0284c7';
    ctx.lineWidth = 2;
    ctx.strokeRect(posX - bw/2, -bh, bw, bh);

    // Center of block for vectors
    const cx = posX;
    const cy = -bh/2;
    
    // Calculate Forces for Vectors
    const Fg = mass * g;
    const F_parallel = Fg * Math.sin(theta);
    const F_normal = Fg * Math.cos(theta);
    const friction = (F_parallel <= mu * F_normal && velocity === 0) ? F_parallel : mu * F_normal;

    // Vector Scaling (Visual only)
    const vScale = 1.5;

    // F_parallel (Down ramp)
    drawArrow(cx, cy, cx - (F_parallel * vScale), cy, '#38bdf8', 'mg sinθ');
    
    // F_normal (Perpendicular to ramp)
    drawArrow(cx, cy, cx, cy - (F_normal * vScale), '#10b981', 'F_N');
    
    // Friction (Up ramp)
    if (friction > 0) {
        drawArrow(cx, cy, cx + (friction * vScale), cy, '#f59e0b', 'f');
    }
    
    // Gravity (Requires undoing rotation to point straight down on screen)
    ctx.save();
    ctx.translate(cx, cy);
    ctx.rotate(theta);
    drawArrow(0, 0, 0, Fg * vScale, '#94a3b8', 'mg');
    ctx.restore();

    ctx.restore();
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

// Init
updateLabels();
draw();
requestAnimationFrame(loop);