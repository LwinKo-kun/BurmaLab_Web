const canvas = document.getElementById('simCanvas');
const ctx = canvas.getContext('2d');

let isRunning = false;
let mass = 5;
let force = 20;
let posX = 50;
let velocity = 0;
const scale = 10; // 1 meter = 10 pixels for visual rendering

const massInput = document.getElementById('massInput');
const forceInput = document.getElementById('forceInput');

function updateLabels() {
    document.getElementById('massVal').textContent = mass + " kg";
    document.getElementById('forceVal').textContent = force + " N";
    
    document.getElementById('statMass').textContent = mass.toFixed(1);
    document.getElementById('statForce').textContent = force.toFixed(1);
    
    // Update theoretical acceleration immediately when sliders move
    const acc = force / mass;
    document.getElementById('statAcc').textContent = acc.toFixed(2);
}

massInput.addEventListener('input', (e) => { mass = parseFloat(e.target.value); updateLabels(); draw(); });
forceInput.addEventListener('input', (e) => { force = parseFloat(e.target.value); updateLabels(); draw(); });

document.getElementById('startBtn').addEventListener('click', () => { 
    if (posX < canvas.width - 100) isRunning = true; 
});

document.getElementById('resetBtn').addEventListener('click', () => {
    isRunning = false;
    posX = 50;
    velocity = 0;
    document.getElementById('statVel').textContent = "0.00";
    draw();
});

function computePhysics(dt) {
    if (isRunning) {
        const acceleration = force / mass;
        
        velocity += acceleration * dt;
        posX += velocity * scale * dt;

        document.getElementById('statVel').textContent = velocity.toFixed(2);
        document.getElementById('statAcc').textContent = acceleration.toFixed(2);

        // Stop at the edge of the canvas
        if (posX >= canvas.width - 90) {
            isRunning = false;
            posX = canvas.width - 90;
        }
    }
}

function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    const groundY = 240;

    // Draw Ground Track
    ctx.fillStyle = '#f1f5f9';
    ctx.fillRect(0, groundY, canvas.width, canvas.height - groundY);
    ctx.strokeStyle = '#cbd5e1';
    ctx.lineWidth = 4;
    ctx.beginPath();
    ctx.moveTo(0, groundY);
    ctx.lineTo(canvas.width, groundY);
    ctx.stroke();

    // Draw Distance Markers
    ctx.fillStyle = '#94a3b8';
    ctx.font = '10px JetBrains Mono';
    for(let i = 50; i < canvas.width; i += 100) {
        ctx.beginPath();
        ctx.moveTo(i, groundY);
        ctx.lineTo(i, groundY + 10);
        ctx.stroke();
        ctx.fillText(`${(i-50)/scale}m`, i - 10, groundY + 22);
    }

    // Draw Sliding Block
    const blockWidth = 70;
    const blockHeight = 50;
    const blockY = groundY - blockHeight;

    ctx.fillStyle = '#0ea5e9'; // Sky Blue
    ctx.fillRect(posX, blockY, blockWidth, blockHeight);
    ctx.strokeStyle = '#0284c7';
    ctx.lineWidth = 2;
    ctx.strokeRect(posX, blockY, blockWidth, blockHeight);

    // Block Label (Mass)
    ctx.fillStyle = '#ffffff';
    ctx.font = 'bold 14px Plus Jakarta Sans';
    ctx.textAlign = 'center';
    ctx.fillText(`${mass} kg`, posX + blockWidth / 2, blockY + 30);

    // Draw Force Vector Arrow
    if (force > 0 && isRunning) {
        const arrowStartX = posX + blockWidth;
        const arrowStartY = blockY + blockHeight / 2;
        // Cap arrow length visually so it doesn't break UI
        const arrowLength = Math.min(150, 40 + force * 1.5);

        ctx.strokeStyle = '#f43f5e'; // Rose
        ctx.lineWidth = 4;
        ctx.beginPath();
        ctx.moveTo(arrowStartX, arrowStartY);
        ctx.lineTo(arrowStartX + arrowLength, arrowStartY);
        ctx.stroke();

        // Arrowhead
        ctx.fillStyle = '#f43f5e';
        ctx.beginPath();
        ctx.moveTo(arrowStartX + arrowLength, arrowStartY - 8);
        ctx.lineTo(arrowStartX + arrowLength + 12, arrowStartY);
        ctx.lineTo(arrowStartX + arrowLength, arrowStartY + 8);
        ctx.fill();

        // Force Label
        ctx.fillStyle = '#e11d48';
        ctx.font = 'bold 12px Plus Jakarta Sans';
        ctx.fillText(`F = ${force} N`, arrowStartX + arrowLength / 2, arrowStartY - 10);
    }
}

let lastTime = performance.now();
function loop(time) {
    const dt = (time - lastTime) / 1000;
    lastTime = time;
    
    // Cap dt to prevent physics jumps if tab is inactive
    if (dt < 0.1) {
        computePhysics(dt);
        draw();
    }
    requestAnimationFrame(loop);
}

// Initial Setup
updateLabels();
draw();
requestAnimationFrame(loop);