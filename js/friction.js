const canvas = document.getElementById('simCanvas');
const ctx = canvas.getContext('2d');

let running = false;
let x = 100, v = 0, a = 0;
let mass = 5.0, appliedForce = 15, mu = 0.2;
const g = 9.81;

const forceInput = document.getElementById('forceInput');
const massInput = document.getElementById('massInput');
const muInput = document.getElementById('muInput');

function updateLabels() {
    document.getElementById('forceVal').textContent = appliedForce + " N";
    document.getElementById('massVal').textContent = mass.toFixed(1) + " kg";
    document.getElementById('muVal').textContent = mu.toFixed(2);
}

forceInput.addEventListener('input', (e) => { appliedForce = parseFloat(e.target.value); updateLabels(); });
massInput.addEventListener('input', (e) => { mass = parseFloat(e.target.value); updateLabels(); });
muInput.addEventListener('input', (e) => { mu = parseFloat(e.target.value); updateLabels(); });

document.getElementById('runBtn').addEventListener('click', () => { running = !running; });
document.getElementById('resetBtn').addEventListener('click', () => {
    running = false;
    x = 100; v = 0; a = 0;
});

function computePhysics(dt) {
    const normalForce = mass * g;
    const maxStaticFriction = mu * normalForce;
    let frictionForce = 0;

    if (Math.abs(v) < 0.001) {
        if (appliedForce <= maxStaticFriction) {
            a = 0;
            frictionForce = appliedForce;
        } else {
            frictionForce = mu * normalForce;
            a = (appliedForce - frictionForce) / mass;
        }
    } else {
        frictionForce = mu * normalForce;
        a = (appliedForce - frictionForce) / mass;
    }

    if (running) {
        v += a * dt;
        x += v * dt * 20;
        if (x > 420) x = 420;
        if (x < 100) { x = 100; v = 0; }
    }

    document.getElementById('statVel').textContent = v.toFixed(2);
    document.getElementById('statAcc').textContent = a.toFixed(2);
    document.getElementById('statFriction').textContent = frictionForce.toFixed(1);
}

function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    ctx.strokeStyle = '#94a3b8';
    ctx.lineWidth = 4;
    ctx.beginPath();
    ctx.moveTo(50, 240);
    ctx.lineTo(450, 240);
    ctx.stroke();

    ctx.fillStyle = '#2563eb';
    ctx.fillRect(x, 200, 40, 40);

    if (appliedForce > 0) {
        ctx.strokeStyle = '#dc2626';
        ctx.lineWidth = 2;
        ctx.beginPath();
        ctx.moveTo(x + 40, 220);
        ctx.lineTo(x + 40 + appliedForce * 1.5, 220);
        ctx.stroke();
    }
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