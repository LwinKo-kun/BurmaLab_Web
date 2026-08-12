const canvas = document.getElementById('simCanvas');
const ctx = canvas.getContext('2d');

let m1 = 2, v1 = 4, m2 = 3, v2 = 0, e = 1.0;
let x1 = 120, x2 = 320;
let running = false;
let collided = false;

const m1Input = document.getElementById('m1Input');
const v1Input = document.getElementById('v1Input');
const m2Input = document.getElementById('m2Input');
const eInput = document.getElementById('eInput');

function updateLabels() {
    document.getElementById('m1Val').textContent = m1.toFixed(1) + ' kg';
    document.getElementById('v1Val').textContent = v1.toFixed(1) + ' m/s';
    document.getElementById('m2Val').textContent = m2.toFixed(1) + ' kg';
    document.getElementById('eVal').textContent = e.toFixed(1);
}

[m1Input, v1Input, m2Input, eInput].forEach((el) => {
    el.addEventListener('input', () => {
        m1 = parseFloat(m1Input.value);
        v1 = parseFloat(v1Input.value);
        m2 = parseFloat(m2Input.value);
        e = parseFloat(eInput.value);
        updateLabels();
        if (!running) resetPositions();
    });
});

function resetPositions() {
    running = false;
    collided = false;
    x1 = 120;
    x2 = 320;
    v2 = 0;
    updateMomentum();
}

function updateMomentum() {
    const p = m1 * v1 + m2 * v2;
    document.getElementById('statMom').textContent = p.toFixed(2);
}

document.getElementById('runBtn').addEventListener('click', () => {
    if (!running) {
        resetPositions();
        running = true;
    }
});

document.getElementById('resetBtn').addEventListener('click', resetPositions);

function resolveCollision() {
    const v1f = ((m1 - e * m2) * v1 + (1 + e) * m2 * v2) / (m1 + m2);
    const v2f = ((m2 - e * m1) * v2 + (1 + e) * m1 * v1) / (m1 + m2);
    v1 = v1f;
    v2 = v2f;
    collided = true;
}

function drawBlock(x, mass, color) {
    const w = 30 + mass * 4;
    const h = 40;
    ctx.fillStyle = color;
    ctx.fillRect(x - w / 2, 200 - h, w, h);
    ctx.fillStyle = '#334155';
    ctx.font = '11px JetBrains Mono, monospace';
    ctx.fillText(mass.toFixed(1) + ' kg', x - w / 2 + 4, 195);
}

function loop() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.strokeStyle = '#cbd5e1';
    ctx.beginPath();
    ctx.moveTo(0, 240);
    ctx.lineTo(canvas.width, 240);
    ctx.stroke();

    if (running) {
        x1 += v1 * 2;
        x2 += v2 * 2;
        const r1 = 15 + m1 * 2;
        const r2 = 15 + m2 * 2;
        if (!collided && x1 + r1 >= x2 - r2) {
            resolveCollision();
            x1 = x2 - r1 - r2 - 1;
        }
        if (x1 < 40 || x1 > canvas.width - 40) v1 *= -0.5;
        if (x2 < 40 || x2 > canvas.width - 40) v2 *= -0.5;
    }

    drawBlock(x1, m1, '#f43f5e');
    drawBlock(x2, m2, '#fb7185');
    updateMomentum();
    requestAnimationFrame(loop);
}

updateLabels();
resetPositions();
loop();
