const canvas = document.getElementById('simCanvas');
const ctx = canvas.getContext('2d');

let loadMass = 10;
let pullDistance = 0.0; // pixels (0 to 160)
let targetPull = 0.0;
let pullVelocity = 0.0;
let isDragging = false;
let startY = 0;

const g = 9.81;
const scale = 50; // pixels per meter

function updateLabels() {
    if (isNaN(loadMass) || loadMass <= 0) loadMass = 10;
    document.getElementById('mVal').textContent = loadMass + " kg";
    
    const weight = loadMass * g;
    document.getElementById('statLoad').textContent = weight.toFixed(1);
    document.getElementById('statEffort').textContent = (weight / 2).toFixed(1);
    
    const height = pullDistance / 2 / scale;
    document.getElementById('statHeight').textContent = (isNaN(height) ? 0 : height).toFixed(2);
}

document.getElementById('mInput').addEventListener('input', e => { 
    loadMass = parseFloat(e.target.value) || 10; 
    updateLabels(); 
});

document.getElementById('resetBtn').addEventListener('click', () => { 
    pullDistance = 0.0;
    targetPull = 0.0;
    pullVelocity = 0.0;
    isDragging = false;
    updateLabels();
});

// --- Robust Mouse & Touch Dragging ---

canvas.addEventListener('mousedown', (e) => {
    const rect = canvas.getBoundingClientRect();
    const mouseX = e.clientX - rect.left;
    const mouseY = e.clientY - rect.top;
    
    const handleX = 350;
    const handleY = 90 + pullDistance;

    if (Math.hypot(mouseX - handleX, mouseY - handleY) < 40) {
        isDragging = true;
        startY = mouseY - targetPull;
    }
});

window.addEventListener('mousemove', (e) => {
    if (!isDragging) return;
    const rect = canvas.getBoundingClientRect();
    const mouseY = e.clientY - rect.top;
    
    targetPull = mouseY - startY;
    if (targetPull < 0) targetPull = 0;
    if (targetPull > 160) targetPull = 160;
});

window.addEventListener('mouseup', () => { isDragging = false; });

// Touch Support
canvas.addEventListener('touchstart', (e) => {
    const rect = canvas.getBoundingClientRect();
    const touchX = e.touches[0].clientX - rect.left;
    const touchY = e.touches[0].clientY - rect.top;
    
    const handleX = 350;
    const handleY = 90 + pullDistance;

    if (Math.hypot(touchX - handleX, touchY - handleY) < 50) {
        isDragging = true;
        startY = touchY - targetPull;
        e.preventDefault();
    }
}, { passive: false });

window.addEventListener('touchmove', (e) => {
    if (!isDragging) return;
    const rect = canvas.getBoundingClientRect();
    const touchY = e.touches[0].clientY - rect.top;
    
    targetPull = touchY - startY;
    if (targetPull < 0) targetPull = 0;
    if (targetPull > 160) targetPull = 160;
    e.preventDefault();
}, { passive: false });

window.addEventListener('touchend', () => { isDragging = false; });


// --- Physics & Gravity Drop Engine ---

function computePhysics(dt) {
    if (!isDragging) {
        targetPull = 0.0; // Return to top when released
    }

    const stiffness = 160;
    const damping = 12 + (loadMass * 0.3);
    
    const force = (targetPull - pullDistance) * stiffness;
    const acceleration = force / (loadMass * 0.5);

    pullVelocity += acceleration * dt;
    pullVelocity -= pullVelocity * damping * dt;
    pullDistance += pullVelocity * dt;

    if (isNaN(pullDistance)) pullDistance = 0;
    if (isNaN(pullVelocity)) pullVelocity = 0;

    if (pullDistance < 0) { pullDistance = 0; pullVelocity = 0; }
    if (pullDistance > 160) { pullDistance = 160; pullVelocity = 0; }

    updateLabels();
}


// --- Render Loop ---

function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    const ceilingY = 55;
    const fixedPulleyX = 260;
    const fixedPulleyY = 90;
    const r = 18;

    // Movable pulley moves up by half of pullDistance (MA = 2)
    const loadRestY = 270;
    const movablePulleyY = loadRestY - (pullDistance / 2);
    const movablePulleyX = 260;

    // 1. Support Beam Ceiling
    ctx.fillStyle = '#64748b';
    ctx.fillRect(160, ceilingY, 280, 14);
    ctx.strokeStyle = '#475569';
    ctx.lineWidth = 2;
    ctx.strokeRect(160, ceilingY, 280, 14);

    // 2. Fixed Upper Pulley
    ctx.fillStyle = '#475569';
    ctx.beginPath(); ctx.arc(fixedPulleyX, fixedPulleyY, r, 0, Math.PI * 2); ctx.fill();
    ctx.strokeStyle = '#334155'; ctx.lineWidth = 2; ctx.stroke();
    ctx.fillStyle = '#e2e8f0';
    ctx.beginPath(); ctx.arc(fixedPulleyX, fixedPulleyY, 4, 0, Math.PI * 2); ctx.fill();

    // 3. Movable Lower Pulley
    ctx.fillStyle = '#475569';
    ctx.beginPath(); ctx.arc(movablePulleyX, movablePulleyY, r, 0, Math.PI * 2); ctx.fill();
    ctx.strokeStyle = '#334155'; ctx.lineWidth = 2; ctx.stroke();
    ctx.fillStyle = '#e2e8f0';
    ctx.beginPath(); ctx.arc(movablePulleyX, movablePulleyY, 4, 0, Math.PI * 2); ctx.fill();

    // 4. Draw Clean Ropes (Mathematically Tangent)
    ctx.strokeStyle = '#94a3b8';
    ctx.lineWidth = 4;
    ctx.lineCap = 'round';
    ctx.beginPath();
    
    // Dead end from ceiling anchor (X=200) to movable pulley left side
    ctx.moveTo(200, ceilingY + 14);
    ctx.lineTo(movablePulleyX - r, ceilingY + 14);
    ctx.lineTo(movablePulleyX - r, movablePulleyY);
    
    // Under movable pulley (left to right)
    ctx.arc(movablePulleyX, movablePulleyY, r, Math.PI, 0, false);
    
    // Up to fixed pulley right side
    ctx.lineTo(fixedPulleyX + r, fixedPulleyY);
    
    // Over fixed pulley (right over top to left) and down to effort handle
    ctx.arc(fixedPulleyX, fixedPulleyY, r, 0, Math.PI, true);
    ctx.lineTo(350, fixedPulleyY + pullDistance);
    ctx.stroke();

    // 5. Effort Handle
    const handleX = 350;
    const handleY = fixedPulleyY + pullDistance;
    ctx.fillStyle = '#4f46e5';
    ctx.beginPath(); ctx.arc(handleX, handleY, 13, 0, Math.PI * 2); ctx.fill();
    ctx.strokeStyle = '#312e81'; ctx.lineWidth = 2; ctx.stroke();

    // 6. Load Box Hook & Box
    const boxY = movablePulleyY + r;
    ctx.strokeStyle = '#64748b'; ctx.lineWidth = 3;
    ctx.beginPath(); ctx.moveTo(movablePulleyX, boxY); ctx.lineTo(movablePulleyX, boxY + 25); ctx.stroke();

    const boxW = 75, boxH = 65;
    const boxX = movablePulleyX - boxW / 2;
    const boxTopY = boxY + 25;

    ctx.fillStyle = '#0ea5e9';
    ctx.fillRect(boxX, boxTopY, boxW, boxH);
    ctx.strokeStyle = '#0284c7'; ctx.lineWidth = 2;
    ctx.strokeRect(boxX, boxTopY, boxW, boxH);

    ctx.fillStyle = '#ffffff';
    ctx.font = 'bold 14px Plus Jakarta Sans';
    ctx.textAlign = 'center';
    ctx.fillText(loadMass + ' kg', movablePulleyX, boxTopY + 38);
}

let lastTime = performance.now();
function loop(time) {
    if (!time) time = performance.now();
    const dt = Math.min((time - lastTime) / 1000, 0.1);
    lastTime = time;
    computePhysics(dt);
    draw();
    requestAnimationFrame(loop);
}

updateLabels();
requestAnimationFrame(loop);