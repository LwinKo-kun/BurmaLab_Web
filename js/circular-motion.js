const canvas = document.getElementById('simCanvas');
const ctx = canvas.getContext('2d');

let isRunning = false;
let showVectors = true;
let angle = 0;
let mass = 2.0;
let radius = 2.0; // in meters
let velocity = 3.0; // in m/s

const scale = 45; // 1 meter = 45 pixels for 600px width canvas
const originX = canvas.width / 2;
const originY = canvas.height / 2;

const massInput = document.getElementById('massInput');
const radiusInput = document.getElementById('radiusInput');
const velInput = document.getElementById('velInput');

function updateLabels() {
    document.getElementById('massVal').textContent = mass.toFixed(1) + " kg";
    document.getElementById('radiusVal').textContent = radius.toFixed(1) + " m";
    document.getElementById('velVal').textContent = velocity.toFixed(1) + " m/s";
    
    // Physics Calculations
    const ac = (velocity * velocity) / radius;
    const fc = mass * ac;
    const period = (2 * Math.PI * radius) / velocity;

    document.getElementById('statAcc').textContent = ac.toFixed(2);
    document.getElementById('statForce').textContent = fc.toFixed(1);
    document.getElementById('statPeriod').textContent = period.toFixed(2);
}

massInput.addEventListener('input', (e) => { mass = parseFloat(e.target.value); updateLabels(); draw(); });
radiusInput.addEventListener('input', (e) => { radius = parseFloat(e.target.value); updateLabels(); draw(); });
velInput.addEventListener('input', (e) => { velocity = parseFloat(e.target.value); updateLabels(); draw(); });

document.getElementById('toggleBtn').addEventListener('click', () => { isRunning = !isRunning; });
document.getElementById('vectorsBtn').addEventListener('click', () => { showVectors = !showVectors; draw(); });

function computePhysics(dt) {
    if (isRunning) {
        const angularVelocity = velocity / radius; // rad/s
        angle += angularVelocity * dt;
        if (angle > 2 * Math.PI) angle -= 2 * Math.PI;
    }
}

function drawArrow(fromX, fromY, toX, toY, color) {
    const headlen = 10;
    const dx = toX - fromX;
    const dy = toY - fromY;
    const ang = Math.atan2(dy, dx);
    ctx.strokeStyle = color;
    ctx.fillStyle = color;
    ctx.lineWidth = 3;
    ctx.beginPath();
    ctx.moveTo(fromX, fromY);
    ctx.lineTo(toX, toY);
    ctx.stroke();
    ctx.beginPath();
    ctx.moveTo(toX, toY);
    ctx.lineTo(toX - headlen * Math.cos(ang - Math.PI / 6), toY - headlen * Math.sin(ang - Math.PI / 6));
    ctx.lineTo(toX - headlen * Math.cos(ang + Math.PI / 6), toY - headlen * Math.sin(ang + Math.PI / 6));
    ctx.fill();
}

function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Draw center point pivot
    ctx.fillStyle = '#475569';
    ctx.beginPath();
    ctx.arc(originX, originY, 6, 0, Math.PI * 2);
    ctx.fill();

    // Draw orbital path circle
    ctx.strokeStyle = '#cbd5e1';
    ctx.lineWidth = 2;
    ctx.setLineDash([6, 6]);
    ctx.beginPath();
    ctx.arc(originX, originY, radius * scale, 0, Math.PI * 2);
    ctx.stroke();
    ctx.setLineDash([]);

    // Calculate object position on circle
    const objX = originX + radius * scale * Math.cos(angle);
    const objY = originY + radius * scale * Math.sin(angle);

    if (showVectors) {
        // Draw Radius Line
        ctx.strokeStyle = '#94a3b8';
        ctx.lineWidth = 1.5;
        ctx.beginPath();
        ctx.moveTo(originX, originY);
        ctx.lineTo(objX, objY);
        ctx.stroke();

        // Draw Velocity Vector (Tangent - Emerald Green)
        const vScale = velocity * 12;
        const vX = objX - vScale * Math.sin(angle);
        const vY = objY + vScale * Math.cos(angle);
        drawArrow(objX, objY, vX, vY, '#10b981'); 

        // Draw Centripetal Force Vector (Inward - Rose Red)
        const fScale = ((velocity * velocity) / radius) * 4;
        const fX = objX - fScale * Math.cos(angle);
        const fY = objY - fScale * Math.sin(angle);
        drawArrow(objX, objY, fX, fY, '#f43f5e'); 
    }

    // Draw Mass Object
    const objRadius = 10 + (mass * 2);
    ctx.fillStyle = '#0ea5e9';
    ctx.beginPath();
    ctx.arc(objX, objY, objRadius, 0, Math.PI * 2);
    ctx.fill();
    ctx.strokeStyle = '#0284c7';
    ctx.lineWidth = 2;
    ctx.stroke();
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