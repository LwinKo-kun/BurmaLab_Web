const canvas = document.getElementById('simCanvas');
const ctx = canvas.getContext('2d');

let running = true;
let t = 0;
let n = 1;              // Harmonic mode (1, 2, 3...)
let f = 10;             // Frequency in Hz
let A = 40;             // Amplitude in pixels
let L = 2.0;            // String length in meters
let showEnvelope = true;

const leftX = 50;
const rightX = 550;
const baselineY = 150;
const stringPixelWidth = rightX - leftX;

// DOM Elements
const harmonicInput = document.getElementById('harmonicInput');
const freqInput = document.getElementById('freqInput');
const ampInput = document.getElementById('ampInput');
const lengthInput = document.getElementById('lengthInput');

const harmonicVal = document.getElementById('harmonicVal');
const freqVal = document.getElementById('freqVal');
const ampVal = document.getElementById('ampVal');
const lengthVal = document.getElementById('lengthVal');

const statLambda = document.getElementById('statLambda');
const statSpeed = document.getElementById('statSpeed');
const statNodes = document.getElementById('statNodes');
const statState = document.getElementById('statState');

const toggleBtn = document.getElementById('toggleBtn');
const envelopeBtn = document.getElementById('envelopeBtn');

const ordinalLabels = ["1st (Fundamental)", "2nd Harmonic", "3rd Harmonic", "4th Harmonic", "5th Harmonic", "6th Harmonic"];

function updateLabels() {
    harmonicVal.textContent = ordinalLabels[n - 1] || `${n}th Harmonic`;
    freqVal.textContent = f.toFixed(1) + " Hz";
    ampVal.textContent = A + " px";
    lengthVal.textContent = L.toFixed(1) + " m";

    // Physics calculations
    // λ = 2L / n
    const lambda = (2 * L) / n;
    // v = f * λ
    const v = f * lambda;
    const numNodes = n + 1;
    const numAntinodes = n;

    statLambda.textContent = lambda.toFixed(2);
    statSpeed.textContent = v.toFixed(1);
    statNodes.textContent = `${numNodes} / ${numAntinodes}`;
    statState.textContent = `Resonant (n = ${n})`;
}

// Event Listeners
harmonicInput.addEventListener('input', (e) => {
    n = parseInt(e.target.value);
    updateLabels();
});

freqInput.addEventListener('input', (e) => {
    f = parseFloat(e.target.value);
    updateLabels();
});

ampInput.addEventListener('input', (e) => {
    A = parseFloat(e.target.value);
    updateLabels();
});

lengthInput.addEventListener('input', (e) => {
    L = parseFloat(e.target.value);
    updateLabels();
});

toggleBtn.addEventListener('click', () => {
    running = !running;
    toggleBtn.textContent = running ? "Pause / Play" : "Resume";
});

envelopeBtn.addEventListener('click', () => {
    showEnvelope = !showEnvelope;
});

function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Grid lines
    ctx.strokeStyle = '#f1f5f9';
    ctx.lineWidth = 1;
    for (let x = 0; x < canvas.width; x += 50) {
        ctx.beginPath(); ctx.moveTo(x, 0); ctx.lineTo(x, canvas.height); ctx.stroke();
    }
    for (let y = 0; y < canvas.height; y += 50) {
        ctx.beginPath(); ctx.moveTo(0, y); ctx.lineTo(canvas.width, y); ctx.stroke();
    }

    // Center Reference Line
    ctx.strokeStyle = '#e2e8f0';
    ctx.lineWidth = 1;
    ctx.setLineDash([4, 4]);
    ctx.beginPath();
    ctx.moveTo(leftX, baselineY);
    ctx.lineTo(rightX, baselineY);
    ctx.stroke();
    ctx.setLineDash([]);

    // Draw End Supports
    ctx.fillStyle = '#64748b';
    ctx.fillRect(leftX - 8, baselineY - 45, 8, 90);
    ctx.fillRect(rightX, baselineY - 45, 8, 90);

    const omega = 2 * Math.PI * f;
    const k = (n * Math.PI) / stringPixelWidth;
    const timeFactor = Math.cos(omega * t);

    // Draw Amplitude Envelope (Dotted boundary limits)
    if (showEnvelope) {
        ctx.strokeStyle = '#cbd5e1';
        ctx.lineWidth = 1.5;
        ctx.setLineDash([3, 3]);

        // Top Envelope
        ctx.beginPath();
        for (let px = 0; px <= stringPixelWidth; px += 2) {
            const y = baselineY - A * Math.sin(k * px);
            if (px === 0) ctx.moveTo(leftX + px, y);
            else ctx.lineTo(leftX + px, y);
        }
        ctx.stroke();

        // Bottom Envelope
        ctx.beginPath();
        for (let px = 0; px <= stringPixelWidth; px += 2) {
            const y = baselineY + A * Math.sin(k * px);
            if (px === 0) ctx.moveTo(leftX + px, y);
            else ctx.lineTo(leftX + px, y);
        }
        ctx.stroke();
        ctx.setLineDash([]);
    }

    // Draw Main Oscillating String: y(x, t) = 2A * sin(kx) * cos(wt)
    ctx.strokeStyle = '#4f46e5';
    ctx.lineWidth = 3.5;
    ctx.lineCap = 'round';
    ctx.beginPath();
    for (let px = 0; px <= stringPixelWidth; px += 2) {
        const y = baselineY - A * Math.sin(k * px) * timeFactor;
        if (px === 0) ctx.moveTo(leftX + px, y);
        else ctx.lineTo(leftX + px, y);
    }
    ctx.stroke();

    // Mark Nodes (N) and Antinodes (A)
    for (let i = 0; i <= n; i++) {
        // Node Position
        const nodeX = leftX + (i * stringPixelWidth) / n;
        ctx.fillStyle = '#dc2626'; // Red for Nodes
        ctx.beginPath();
        ctx.arc(nodeX, baselineY, 4, 0, 2 * Math.PI);
        ctx.fill();

        ctx.fillStyle = '#991b1b';
        ctx.font = '10px JetBrains Mono, monospace';
        ctx.fillText('N', nodeX - 3, baselineY + 18);

        // Antinode Position (Midpoint between nodes)
        if (i < n) {
            const antinodeX = nodeX + stringPixelWidth / (2 * n);
            const antinodeY = baselineY - A * Math.sin(k * (antinodeX - leftX)) * timeFactor;

            ctx.fillStyle = '#059669'; // Green for Antinodes
            ctx.beginPath();
            ctx.arc(antinodeX, antinodeY, 4, 0, 2 * Math.PI);
            ctx.fill();

            ctx.fillStyle = '#047857';
            ctx.font = '10px JetBrains Mono, monospace';
            ctx.fillText('A', antinodeX - 3, baselineY - A - 8);
        }
    }
}

let lastTime = performance.now();
function loop(time) {
    const dt = (time - lastTime) / 1000;
    lastTime = time;

    if (running && dt < 0.1) {
        t += dt;
    }

    draw();
    requestAnimationFrame(loop);
}

updateLabels();
requestAnimationFrame(loop);