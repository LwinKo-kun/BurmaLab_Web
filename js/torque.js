const canvas = document.getElementById('simCanvas');
const ctx = canvas.getContext('2d');

let isLocked = true;
let boardAngle = 0;
let angularVel = 0;
const g = 9.81;

// Variables
let mL = 10, rL = 2.0; // Left side
let mR = 10, rR = 2.0; // Right side

const scale = 40; // 1 meter = 40 pixels
const originX = canvas.width / 2;
const originY = 220; // Fulcrum position

const mLInput = document.getElementById('mLInput');
const rLInput = document.getElementById('rLInput');
const mRInput = document.getElementById('mRInput');
const rRInput = document.getElementById('rRInput');
const statStatus = document.getElementById('statStatus');

function updateLabels() {
    document.getElementById('mLVal').textContent = mL + " kg";
    document.getElementById('rLVal').textContent = rL.toFixed(1) + " m";
    document.getElementById('mRVal').textContent = mR + " kg";
    document.getElementById('rRVal').textContent = rR.toFixed(1) + " m";
    
    // Torque calcs (tau = r * F)
    const tL = rL * (mL * g);
    const tR = rR * (mR * g);
    
    document.getElementById('statTorqueL').textContent = tL.toFixed(1);
    document.getElementById('statTorqueR').textContent = tR.toFixed(1);

    if (isLocked) {
        statStatus.textContent = "LOCKED";
        statStatus.className = "font-mono font-bold text-slate-400 text-sm";
    }
}

function attachListeners() {
    const inputs = [
        { el: mLInput, set: v => mL = v },
        { el: rLInput, set: v => rL = v },
        { el: mRInput, set: v => mR = v },
        { el: rRInput, set: v => rR = v }
    ];
    inputs.forEach(input => {
        input.el.addEventListener('input', (e) => {
            input.set(parseFloat(e.target.value));
            updateLabels();
            if(isLocked) draw();
        });
    });
}
attachListeners();

document.getElementById('releaseBtn').addEventListener('click', () => { 
    isLocked = false; 
});
document.getElementById('resetBtn').addEventListener('click', () => { 
    isLocked = true; 
    boardAngle = 0; 
    angularVel = 0; 
    updateLabels();
    draw(); 
});

function computePhysics(dt) {
    if (!isLocked) {
        // Net torque: counter-clockwise (Left) is positive, clockwise (Right) is negative
        const netTorque = (rL * mL * g * Math.cos(boardAngle)) - (rR * mR * g * Math.cos(boardAngle));
        
        // Moment of Inertia (I = mr^2). Ignore board mass for simplicity.
        const I = (mL * rL * rL) + (mR * rR * rR) + 1; // +1 to prevent div by 0
        
        const angularAcc = netTorque / I;
        
        angularVel += angularAcc * dt;
        // Dampening to prevent infinite swinging
        angularVel *= 0.98; 
        boardAngle += angularVel * dt;

        // Ground collision (assuming max angle is around 0.5 radians before hitting ground)
        if (boardAngle > 0.4) { boardAngle = 0.4; angularVel = -angularVel * 0.3; }
        if (boardAngle < -0.4) { boardAngle = -0.4; angularVel = -angularVel * 0.3; }

        if (Math.abs(netTorque) < 0.1 && Math.abs(angularVel) < 0.01) {
            statStatus.textContent = "BALANCED";
            statStatus.className = "font-mono font-bold text-emerald-400 text-sm";
        } else if (boardAngle > 0.39) {
            statStatus.textContent = "TILTED LEFT";
            statStatus.className = "font-mono font-bold text-sky-400 text-sm";
        } else if (boardAngle < -0.39) {
            statStatus.textContent = "TILTED RIGHT";
            statStatus.className = "font-mono font-bold text-rose-400 text-sm";
        } else {
            statStatus.textContent = "IN MOTION";
            statStatus.className = "font-mono font-bold text-amber-400 text-sm";
        }
    }
}

function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Draw Fulcrum (Triangle)
    ctx.fillStyle = '#64748b';
    ctx.beginPath();
    ctx.moveTo(originX, originY);
    ctx.lineTo(originX - 25, originY + 40);
    ctx.lineTo(originX + 25, originY + 40);
    ctx.closePath();
    ctx.fill();

    // Context transform for rotating the board
    ctx.save();
    ctx.translate(originX, originY);
    ctx.rotate(-boardAngle); // Negate because canvas Y is down

    // Draw Board (Total length 10m -> 400px)
    ctx.fillStyle = '#e2e8f0';
    ctx.fillRect(-220, -4, 440, 8);
    ctx.strokeStyle = '#94a3b8';
    ctx.lineWidth = 2;
    ctx.strokeRect(-220, -4, 440, 8);

    // Draw Left Mass
    const lX = -rL * scale;
    const lSize = 10 + (mL * 0.5); // Visual size based on mass
    ctx.fillStyle = '#0ea5e9'; // Sky
    ctx.fillRect(lX - lSize/2, -4 - lSize, lSize, lSize);
    ctx.strokeStyle = '#0284c7';
    ctx.strokeRect(lX - lSize/2, -4 - lSize, lSize, lSize);

    // Draw Right Mass
    const rX = rR * scale;
    const rSize = 10 + (mR * 0.5);
    ctx.fillStyle = '#f43f5e'; // Rose
    ctx.fillRect(rX - rSize/2, -4 - rSize, rSize, rSize);
    ctx.strokeStyle = '#e11d48';
    ctx.strokeRect(rX - rSize/2, -4 - rSize, rSize, rSize);

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

updateLabels();
draw();
requestAnimationFrame(loop);