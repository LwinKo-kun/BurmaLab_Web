const canvas = document.getElementById('simCanvas');
const ctx = canvas.getContext('2d');

let v1 = 2.0, a1 = 10, a2 = 5;
const rho = 1000; // Density of water (kg/m^3)
let particles = [];

for (let i = 0; i < 150; i++) {
    particles.push({ 
        x: Math.random() * canvas.width, 
        yOffset: (Math.random() * 2 - 1), // Relative offset within pipe radius (-1 to 1)
        speedMult: Math.random() * 0.5 + 0.8 
    });
}

function updatePhysics() {
    document.getElementById('v1Val').textContent = v1.toFixed(1) + " m/s";
    document.getElementById('a1Val').textContent = a1 + " m²";
    document.getElementById('a2Val').textContent = a2 + " m²";

    // Continuity equation: A1 * v1 = A2 * v2
    const flowRate = a1 * v1; 
    const v2 = flowRate / a2; 
    
    // Bernoulli pressure drop: P1 - P2 = 0.5 * rho * (v2^2 - v1^2)
    const pressureDrop = 0.5 * rho * (v2 * v2 - v1 * v1);

    document.getElementById('statFlow').textContent = flowRate.toFixed(1);
    document.getElementById('statV2').textContent = v2.toFixed(1);
    document.getElementById('statPressure').textContent = Math.round(pressureDrop);
    
    return { flowRate, v2 };
}

document.getElementById('v1Input').addEventListener('input', e => { v1 = parseFloat(e.target.value); });
document.getElementById('a1Input').addEventListener('input', e => { a1 = parseFloat(e.target.value); });
document.getElementById('a2Input').addEventListener('input', e => { a2 = parseFloat(e.target.value); });

function draw(dt) {
    const { v2 } = updatePhysics();
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Pipe boundaries (using radius proportional to area, e.g., sqrt or scaled factor)
    const pipeYCenter = canvas.height / 2;
    const rad1 = Math.sqrt(a1) * 15; 
    const rad2 = Math.sqrt(a2) * 15;
    
    const startX = 0;
    const midX1 = 200;
    const midX2 = 400;
    const endX = canvas.width;

    // Draw Pipe Interior
    ctx.fillStyle = '#e0f2fe';
    ctx.beginPath();
    ctx.moveTo(startX, pipeYCenter - rad1);
    ctx.lineTo(midX1, pipeYCenter - rad1);
    ctx.bezierCurveTo(midX1 + 100, pipeYCenter - rad1, midX2 - 100, pipeYCenter - rad2, midX2, pipeYCenter - rad2);
    ctx.lineTo(endX, pipeYCenter - rad2);
    ctx.lineTo(endX, pipeYCenter + rad2);
    ctx.lineTo(midX2, pipeYCenter + rad2);
    ctx.bezierCurveTo(midX2 - 100, pipeYCenter + rad2, midX1 + 100, pipeYCenter + rad1, midX1, pipeYCenter + rad1);
    ctx.lineTo(startX, pipeYCenter + rad1);
    ctx.fill();

    // Draw Pipe Outlines
    ctx.strokeStyle = '#94a3b8'; 
    ctx.lineWidth = 4;
    
    // Top border
    ctx.beginPath(); 
    ctx.moveTo(startX, pipeYCenter - rad1); 
    ctx.lineTo(midX1, pipeYCenter - rad1);
    ctx.bezierCurveTo(midX1 + 100, pipeYCenter - rad1, midX2 - 100, pipeYCenter - rad2, midX2, pipeYCenter - rad2);
    ctx.lineTo(endX, pipeYCenter - rad2); 
    ctx.stroke();
    
    // Bottom border
    ctx.beginPath(); 
    ctx.moveTo(startX, pipeYCenter + rad1); 
    ctx.lineTo(midX1, pipeYCenter + rad1);
    ctx.bezierCurveTo(midX1 + 100, pipeYCenter + rad1, midX2 - 100, pipeYCenter + rad2, midX2, pipeYCenter + rad2);
    ctx.lineTo(endX, pipeYCenter + rad2); 
    ctx.stroke();

    // Particles Flow
    ctx.fillStyle = '#0284c7';
    particles.forEach(p => {
        let currentV = v1;
        let currentRad = rad1;
        
        if (p.x > midX2) { 
            currentV = v2; 
            currentRad = rad2; 
        } else if (p.x > midX1) {
            const ratio = (p.x - midX1) / (midX2 - midX1);
            currentV = v1 + (v2 - v1) * ratio;
            currentRad = rad1 + (rad2 - rad1) * ratio;
        }

        // Update position based on velocity and delta time
        p.x += currentV * p.speedMult * 20 * dt;
        
        // Reset particle when it goes off screen
        if (p.x > canvas.width) {
            p.x = 0;
            p.yOffset = (Math.random() * 2 - 1); 
        }

        const renderY = pipeYCenter + (p.yOffset * currentRad * 0.9);
        ctx.beginPath();
        ctx.arc(p.x, renderY, 3, 0, Math.PI * 2);
        ctx.fill();
    });
}

let lastTime = performance.now();
function loop(time) {
    const dt = Math.min((time - lastTime) / 1000, 0.1);
    lastTime = time;
    draw(dt);
    requestAnimationFrame(loop);
}
requestAnimationFrame(loop);