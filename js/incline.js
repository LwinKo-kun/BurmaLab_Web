const canvas = document.getElementById('simCanvas');
const ctx = canvas.getContext('2d');

let running = false;
let distance = 20, v = 0, a = 0;
let angleDeg = 30, mu = 0.15, mass = 4.0;
const g = 9.81;

const angleInput = document.getElementById('angleInput');
const muInput = document.getElementById('muInput');
const massInput = document.getElementById('massInput');

function updateLabels() {
    document.getElementById('angleVal').textContent = angleDeg + "°";
    document.getElementById('muVal').textContent = mu.toFixed(2);
    document.getElementById('massVal').textContent = mass.toFixed(1) + " kg";
}

angleInput.addEventListener('input', (e) => { angleDeg = parseFloat(e.target.value); updateLabels(); });
muInput.addEventListener('input', (e) => { mu = parseFloat(e.target.value); updateLabels(); });
massInput.addEventListener('input', (e) => { mass = parseFloat(e.target.value); updateLabels(); });

document.getElementById('runBtn').addEventListener('click', () => { running = !running; });
document.getElementById('resetBtn').addEventListener('click', () => {
    running = false;
    distance = 20; v = 0; a = 0;
});

function computePhysics(dt) {
    const rad = angleDeg * Math.PI / 180;
    a = g * (Math.sin(rad) - mu * Math.cos(rad));
    if (a < 0) a = 0;

    if (running) {
        v += a * dt;
        distance += v * dt * 15;
        if (distance > 250) distance = 250;
    }

    document.getElementById('statVel').textContent = v.toFixed(2);
    document.getElementById('statAcc').textContent = a.toFixed(2);
}

function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    const rad = angleDeg * Math.PI / 180;

    const startX = 60, startY = 240;
    const rampLength = 320;
    const endX = startX + rampLength * Math.cos(rad);
    const endY = startY - rampLength * Math.sin(rad);

    ctx.strokeStyle = '#64748b';
    ctx.lineWidth = 4;
    ctx.beginPath();
    ctx.moveTo(startX, startY);
    ctx.lineTo(endX, endY);
    ctx.lineTo(endX, startY);
    ctx.closePath();
    ctx.stroke();

    const boxX = startX + distance * Math.cos(rad);
    const boxY = startY - distance * Math.sin(rad);

    ctx.save();
    ctx.translate(boxX, boxY);
    ctx.rotate(-rad);
    ctx.fillStyle = '#0284c7';
    ctx.fillRect(-15, -30, 30, 30);
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
requestAnimationFrame(loop);