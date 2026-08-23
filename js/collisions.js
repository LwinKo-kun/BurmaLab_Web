const canvas = document.getElementById('simCanvas');
const ctx = canvas.getContext('2d');

let m1 = 2, v1 = 4, m2 = 3, v2 = 0, e = 1.0;
let x1 = 100, x2 = 450;
let running = false;

const m1Input = document.getElementById('m1Input');
const v1Input = document.getElementById('v1Input');
const m2Input = document.getElementById('m2Input');
const eInput = document.getElementById('eInput');

function updateLabels() {
    document.getElementById('m1Val').textContent = m1.toFixed(1) + ' kg';
    document.getElementById('v1Val').textContent = v1.toFixed(1) + ' m/s';
    document.getElementById('m2Val').textContent = m2.toFixed(1) + ' kg';
    document.getElementById('eVal').textContent = e.toFixed(1);
    
    document.getElementById('statV1').textContent = v1.toFixed(2);
    document.getElementById('statV2').textContent = v2.toFixed(2);
}

[m1Input, v1Input, m2Input, eInput].forEach((el) => {
    el.addEventListener('input', () => {
        m1 = parseFloat(m1Input.value);
        if (!running) v1 = parseFloat(v1Input.value); 
        m2 = parseFloat(m2Input.value);
        e = parseFloat(eInput.value);
        updateLabels();
        if (!running) resetPositions();
    });
});

function resetPositions() {
    running = false;
    x1 = 100;
    x2 = 450;
    v1 = parseFloat(v1Input.value);
    v2 = 0;
    updateLabels();
    updateMomentum();
}

function updateMomentum() {
    const p = (m1 * v1) + (m2 * v2);
    document.getElementById('statMom').textContent = p.toFixed(2);
}

document.getElementById('runBtn').addEventListener('click', () => {
    if (!running) {
        resetPositions();
        running = true;
    }
});
document.getElementById('resetBtn').addEventListener('click', resetPositions);

function drawBlock(x, mass, color, strokeColor) {
    const w = 40 + mass * 3;
    const h = 40 + mass * 2;
    ctx.fillStyle = color;
    ctx.fillRect(x - w / 2, 240 - h, w, h);
    ctx.strokeStyle = strokeColor;
    ctx.lineWidth = 2;
    ctx.strokeRect(x - w / 2, 240 - h, w, h);
    
    ctx.fillStyle = '#ffffff';
    ctx.font = 'bold 12px Plus Jakarta Sans, sans-serif';
    ctx.textAlign = 'center';
    ctx.fillText(`${mass.toFixed(1)}kg`, x, 240 - h + 25);
}

function loop() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    // Track
    ctx.fillStyle = '#f1f5f9';
    ctx.fillRect(0, 240, canvas.width, 60);
    ctx.strokeStyle = '#cbd5e1';
    ctx.lineWidth = 4;
    ctx.beginPath();
    ctx.moveTo(0, 240);
    ctx.lineTo(canvas.width, 240);
    ctx.stroke();

    if (running) {
        // Move blocks
        x1 += v1 * 1.5;
        x2 += v2 * 1.5;
        
        const r1 = (40 + m1 * 3) / 2;
        const r2 = (40 + m2 * 3) / 2;
        
        // Block-to-Block Collision Check
        if (Math.abs(x1 - x2) <= r1 + r2) {
            // Check Relative Velocity (Are they moving towards each other?)
            let approaching = false;
            if (x1 < x2 && v1 > v2) approaching = true;
            if (x2 < x1 && v2 > v1) approaching = true;

            if (approaching) {
                // Resolve 1D Collision Physics
                const v1f = ((m1 - e * m2) * v1 + (1 + e) * m2 * v2) / (m1 + m2);
                const v2f = ((m2 - e * m1) * v2 + (1 + e) * m1 * v1) / (m1 + m2);
                v1 = v1f;
                v2 = v2f;
                updateLabels();
            }
        }
        
        // Wall boundaries (Perfect elastic bounce off the walls)
        if (x1 < r1) { x1 = r1; v1 = Math.abs(v1); updateLabels(); }
        if (x1 > canvas.width - r1) { x1 = canvas.width - r1; v1 = -Math.abs(v1); updateLabels(); }
        
        if (x2 < r2) { x2 = r2; v2 = Math.abs(v2); updateLabels(); }
        if (x2 > canvas.width - r2) { x2 = canvas.width - r2; v2 = -Math.abs(v2); updateLabels(); }
    }

    drawBlock(x1, m1, '#f43f5e', '#be123c'); // Rose block
    drawBlock(x2, m2, '#0ea5e9', '#0369a1'); // Sky block
    
    updateMomentum();
    requestAnimationFrame(loop);
}

updateLabels();
resetPositions();
loop();