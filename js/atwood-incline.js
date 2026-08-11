const canvas = document.getElementById('simCanvas');
const ctx = canvas.getContext('2d');

let running = false;
let s = 40, v = 0, a = 0;
let m1 = 3.0, m2 = 4.0;
const g = 9.81;

const m1Input = document.getElementById('m1Input');
const m2Input = document.getElementById('m2Input');

function updateLabels() {
    document.getElementById('m1Val').textContent = m1.toFixed(1) + " kg";
    document.getElementById('m2InputVal').textContent = m2.toFixed(1) + " kg";
}

m1Input.addEventListener('input', (e) => { m1 = parseFloat(e.target.value); updateLabels(); });
m2Input.addEventListener('input', (e) => { m2 = parseFloat(e.target.value); updateLabels(); });

document.getElementById('runBtn').addEventListener('click', () => { running = !running; });
document.getElementById('resetBtn').addEventListener('click', () => {
    running = false;
    s = 40; v = 0; a = 0;
});

function computePhysics(dt) {
    const angleRad = 30 * Math.PI / 180;
    a = (m1 * g - m2 * g * Math.sin(angleRad)) / (m1 + m2);

    if (running) {
        v += a * dt;
        s += v * dt * 18;
        if (s > 180) s = 180;
        if (s < 20) { s = 20; v = 0; }
    }

    document.getElementById('statVel').textContent = v.toFixed(2);
    document.getElementById('statAcc').textContent = a.toFixed(2);
}

function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    const px = 360, py = 80;
    ctx.fillStyle = '#334155';
    ctx.beginPath();
    ctx.arc(px, py, 12, 0, 2 * Math.PI);
    ctx.fill();

    ctx.strokeStyle = '#94a3b8';
    ctx.lineWidth = 4;
    ctx.beginPath();
    ctx.moveTo(80, 220);
    ctx.lineTo(px, py);
    ctx.stroke();

    const rampX = 120 + s * 0.866;
    const rampY = 200 - s * 0.5;
    
    ctx.fillStyle = '#4f46e5';
    ctx.fillRect(rampX - 15, rampY - 15, 30, 30);

    const hangX = px + 30;
    const hangY = py + 60 + s;
    ctx.fillStyle = '#6366f1';
    ctx.fillRect(hangX - 15, hangY - 15, 30, 30);

    ctx.strokeStyle = '#cbd5e1';
    ctx.lineWidth = 2;
    ctx.beginPath();
    ctx.moveTo(rampX, rampY);
    ctx.lineTo(px, py);
    ctx.lineTo(hangX, hangY);
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
requestAnimationFrame(loop);