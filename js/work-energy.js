const canvas = document.getElementById('simCanvas');
const ctx = canvas.getContext('2d');

let running = false;
let angle = Math.PI / 3;
let initialAngle = Math.PI / 3;
let angleVel = 0;
const g = 9.81;

// Scaled for 600x350 canvas
const length = 200; 
const originX = 300; 
const originY = 50;

let mass = 2.0;
let initialHeight = 5.0; // Conceptual max height scale

const massSlider = document.getElementById('massSlider');
const heightSlider = document.getElementById('heightSlider');

function updateLabels() {
    document.getElementById('massVal').textContent = mass.toFixed(1) + " kg";
    document.getElementById('heightVal').textContent = initialHeight.toFixed(1) + " m";
}

massSlider.addEventListener('input', (e) => { 
    mass = parseFloat(e.target.value); 
    updateLabels(); 
    computePhysics(0); // Update energy stats while paused
});

heightSlider.addEventListener('input', (e) => {
    initialHeight = parseFloat(e.target.value);
    initialAngle = (initialHeight / 10) * (Math.PI / 2.2); // Adjust starting angle swing visually
    angle = initialAngle;
    angleVel = 0;
    updateLabels();
    computePhysics(0); 
});

document.getElementById('releaseBtn').addEventListener('click', () => { running = true; });
document.getElementById('resetBtn').addEventListener('click', () => {
    running = false;
    angle = initialAngle;
    angleVel = 0;
    computePhysics(0); 
});

function computePhysics(dt) {
    if (running) {
        // Pendulum angular acceleration equation: α = -(g/L) * sin(θ)
        const angularAcc = (-g / (length / 20)) * Math.sin(angle);
        angleVel += angularAcc * dt;
        angle += angleVel * dt;
    }

    // Calculate dynamic height ratio based on angle
    const currentH = initialHeight * (1 - Math.cos(angle)) / (1 - Math.cos(initialAngle || 0.01));
    
    const Ep = mass * g * Math.max(0, currentH);
    const totalE = mass * g * initialHeight;
    const Ek = Math.max(0, totalE - Ep);

    document.getElementById('statEp').textContent = Ep.toFixed(1);
    document.getElementById('statEk').textContent = Ek.toFixed(1);
    document.getElementById('statTotalE').textContent = totalE.toFixed(1);

    // Update the visual HTML bars
    const EpRatio = (Ep / totalE) * 100;
    const EkRatio = (Ek / totalE) * 100;
    document.getElementById('barEp').style.width = `${Math.min(100, Math.max(0, EpRatio))}%`;
    document.getElementById('barEk').style.width = `${Math.min(100, Math.max(0, EkRatio))}%`;
}

function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Grid background
    ctx.strokeStyle = '#e2e8f0';
    ctx.lineWidth = 1;
    for(let i = 0; i < canvas.width; i+=40) { ctx.beginPath(); ctx.moveTo(i, 0); ctx.lineTo(i, canvas.height); ctx.stroke(); }
    for(let i = 0; i < canvas.height; i+=40) { ctx.beginPath(); ctx.moveTo(0, i); ctx.lineTo(canvas.width, i); ctx.stroke(); }

    // Pivot support block
    ctx.fillStyle = '#475569';
    ctx.fillRect(originX - 30, originY - 10, 60, 10);
    ctx.fillStyle = '#64748b';
    ctx.beginPath(); ctx.arc(originX, originY, 4, 0, Math.PI * 2); ctx.fill();

    // Pendulum String & Bob Positions
    const bobX = originX + length * Math.sin(angle);
    const bobY = originY + length * Math.cos(angle);

    // Draw string
    ctx.strokeStyle = '#94a3b8';
    ctx.lineWidth = 3;
    ctx.beginPath();
    ctx.moveTo(originX, originY);
    ctx.lineTo(bobX, bobY);
    ctx.stroke();

    // Draw Bob
    const bobRadius = 15 + (mass * 1.5);
    ctx.fillStyle = '#6366f1'; // Indigo
    ctx.beginPath();
    ctx.arc(bobX, bobY, bobRadius, 0, Math.PI * 2);
    ctx.fill();
    ctx.strokeStyle = '#4338ca';
    ctx.lineWidth = 2;
    ctx.stroke();
    
    // Label on Bob
    ctx.fillStyle = '#ffffff';
    ctx.font = 'bold 12px Plus Jakarta Sans';
    ctx.textAlign = 'center';
    ctx.fillText(`${mass.toFixed(1)}kg`, bobX, bobY + 4);
}

let lastTime = performance.now();
function loop(time) {
    const dt = (time - lastTime) / 1000;
    lastTime = time;
    if (dt < 0.1) { // Prevents physics exploding if tab is inactive
        computePhysics(dt);
        draw();
    }
    requestAnimationFrame(loop);
}

// Initial Setup
updateLabels();
computePhysics(0);
draw();
requestAnimationFrame(loop);