const canvas = document.getElementById('simCanvas');
const ctx = canvas.getContext('2d');

let running = false;
let posY = 80;
let velocity = 0;
let mass = 2.0, objDensity = 600;
const waterDensity = 1000; // kg/m^3
const g = 9.81;
const waterLevelY = 160;
const containerBottomY = 300;
const startX = 350;
const objectSize = 50;

const massInput = document.getElementById('massInput');
const densityInput = document.getElementById('densityInput');
const materialSelect = document.getElementById('materialSelect');

const materials = {
    wood: { mass: 2.0, density: 600 },
    ice: { mass: 1.8, density: 917 },
    aluminum: { mass: 5.4, density: 2700 },
    iron: { mass: 15.7, density: 7870 }
};

function updateLabels() {
    massInput.value = mass;
    densityInput.value = objDensity;
    document.getElementById('massVal').textContent = mass.toFixed(1) + " kg";
    document.getElementById('densityVal').textContent = objDensity + " kg/m³";
}

materialSelect.addEventListener('change', (e) => {
    const val = e.target.value;
    if (materials[val]) {
        mass = materials[val].mass;
        objDensity = materials[val].density;
        updateLabels();
    }
});

massInput.addEventListener('input', (e) => { 
    mass = parseFloat(e.target.value); 
    materialSelect.value = 'custom';
    updateLabels(); 
});

densityInput.addEventListener('input', (e) => { 
    objDensity = parseInt(e.target.value); 
    materialSelect.value = 'custom';
    updateLabels(); 
});

document.getElementById('submergeBtn').addEventListener('click', () => {
    running = true;
    document.getElementById('statStatus').textContent = "Simulating...";
    document.getElementById('statStatus').className = "text-sky-600 font-bold";
});

document.getElementById('resetBtn').addEventListener('click', () => {
    running = false;
    posY = 80;
    velocity = 0;
    document.getElementById('statStatus').textContent = "Ready";
    document.getElementById('statStatus').className = "text-emerald-600 font-bold";
    document.getElementById('statBuoyant').textContent = "0.0";
    document.getElementById('statApparent').textContent = "0.0";
});

function computePhysics(dt) {
    const volume = mass / objDensity; // m^3
    const realWeight = mass * g;
    
    let objectTop = posY - objectSize / 2;
    let objectBottom = posY + objectSize / 2;

    let submergedHeight = 0;
    if (objectBottom > waterLevelY) {
        submergedHeight = Math.min(objectSize, objectBottom - waterLevelY);
        if (objectTop < waterLevelY) {
            submergedHeight = objectBottom - waterLevelY;
        } else {
            submergedHeight = objectSize;
        }
    }
    
    const submergedFraction = Math.max(0, Math.min(1, submergedHeight / objectSize));
    const buoyantForce = submergedFraction * volume * waterDensity * g;
    const apparentWeight = Math.max(0, realWeight - buoyantForce);

    if (running) {
        const netForce = realWeight - buoyantForce;
        const acceleration = (netForce / mass) * 3 - velocity * 2.0;
        
        velocity += acceleration * dt;
        posY += velocity * dt * 50;

        const maxPosY = containerBottomY - objectSize / 2;
        if (posY > maxPosY) {
            posY = maxPosY;
            velocity = -velocity * 0.15;
        }
    }

    document.getElementById('statBuoyant').textContent = buoyantForce.toFixed(2);
    document.getElementById('statApparent').textContent = apparentWeight.toFixed(2);

    if (running) {
        if (objDensity < waterDensity && Math.abs(velocity) < 0.2 && objectBottom >= waterLevelY) {
            document.getElementById('statStatus').textContent = "Floating (Equilibrium)";
            document.getElementById('statStatus').className = "text-emerald-600 font-bold";
        } else if (Math.abs(posY - (containerBottomY - objectSize / 2)) < 1 && objDensity >= waterDensity) {
            document.getElementById('statStatus').textContent = "Sunk to Bottom";
            document.getElementById('statStatus').className = "text-rose-600 font-bold";
        }
    }
}

function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Realistic Water Body with Light Mode Gradient
    const waterGrad = ctx.createLinearGradient(0, waterLevelY, 0, containerBottomY);
    waterGrad.addColorStop(0, 'rgba(56, 189, 248, 0.35)');
    waterGrad.addColorStop(1, 'rgba(2, 132, 199, 0.65)');

    ctx.fillStyle = waterGrad;
    ctx.fillRect(150, waterLevelY, 400, containerBottomY - waterLevelY);
    
    // Glass Beaker Container Outline
    ctx.strokeStyle = '#0284c7';
    ctx.lineWidth = 2.5;
    ctx.strokeRect(150, waterLevelY, 400, containerBottomY - waterLevelY);

    // Water Surface Wave Highlights
    ctx.strokeStyle = '#38bdf8';
    ctx.lineWidth = 2;
    ctx.beginPath();
    ctx.moveTo(150, waterLevelY);
    for (let x = 150; x <= 550; x += 20) {
        ctx.lineTo(x, waterLevelY + Math.sin(Date.now() / 200 + x / 20) * 3);
    }
    ctx.stroke();

    // Object Box Render
    ctx.fillStyle = '#4f46e5';
    ctx.fillRect(startX - objectSize/2, posY - objectSize/2, objectSize, objectSize);
    ctx.strokeStyle = '#312e81';
    ctx.lineWidth = 2;
    ctx.strokeRect(startX - objectSize/2, posY - objectSize/2, objectSize, objectSize);

    // Object Text Label
    ctx.fillStyle = '#ffffff';
    ctx.font = 'bold 11px JetBrains Mono, monospace';
    ctx.textAlign = 'center';
    ctx.fillText(mass + 'kg', startX, posY + 4);
}

let lastTime = performance.now();
function loop(time) {
    const dt = Math.min((time - lastTime) / 1000, 0.1);
    lastTime = time;
    computePhysics(dt);
    draw();
    requestAnimationFrame(loop);
}
requestAnimationFrame(loop);