const canvas = document.getElementById('simCanvas');
const ctx = canvas.getContext('2d');

let v = 15, thetaDeg = 20, mu = 0.5, r = 50;
let slideAnimOffset = 0; // Dynamic animation offset when sliding up/down
const m = 1000; 
const g = 9.81;

function updatePhysics() {
    document.getElementById('vVal').textContent = v + " m/s";
    document.getElementById('thetaVal').textContent = thetaDeg + "°";
    document.getElementById('muVal').textContent = mu.toFixed(1);
    document.getElementById('rVal').textContent = r + " m";

    const theta = thetaDeg * Math.PI / 180;
    const tanTheta = Math.tan(theta);
    
    const Fc_req = (m * v * v) / r;
    
    const denomMax = 1 - mu * tanTheta;
    const vMax = denomMax > 0 ? Math.sqrt(Math.max(0, r * g * (tanTheta + mu) / denomMax)) : 40;
    
    const denomMin = 1 + mu * tanTheta;
    const vMinSq = r * g * (tanTheta - mu) / denomMin;
    const vMin = vMinSq > 0 ? Math.sqrt(vMinSq) : 0;

    document.getElementById('statVMax').textContent = `Max: ${vMax.toFixed(1)} m/s`;
    document.getElementById('statVMin').textContent = `Min: ${vMin.toFixed(1)} m/s`;

    const statusAlert = document.getElementById('statusAlert');
    if (v > vMax) {
        statusAlert.textContent = "SLIDING UP THE BANK (Too Fast)";
        statusAlert.className = "mt-3 text-center text-xs font-bold py-2 rounded-lg bg-rose-500/20 text-rose-400";
    } else if (v < vMin) {
        statusAlert.textContent = "SLIDING DOWN THE BANK (Too Slow)";
        statusAlert.className = "mt-3 text-center text-xs font-bold py-2 rounded-lg bg-rose-500/20 text-rose-400";
    } else {
        statusAlert.textContent = "VEHICLE STABLE";
        statusAlert.className = "mt-3 text-center text-xs font-bold py-2 rounded-lg bg-emerald-500/20 text-emerald-400";
    }

    const Fn = m * g * Math.cos(theta) + Fc_req * Math.sin(theta);
    const F_ideal = m * g * tanTheta; 
    let Ff = 0;
    
    if (Fc_req > F_ideal) {
        Ff = Math.abs(Fc_req * Math.cos(theta) - m * g * Math.sin(theta)); 
    } else {
        Ff = Math.abs(m * g * Math.sin(theta) - Fc_req * Math.cos(theta)); 
    }

    document.getElementById('statFriction').textContent = Math.round(Ff);
    document.getElementById('statNormal').textContent = Math.round(Fn);
    document.getElementById('statCentripetal').textContent = Math.round(Fc_req);
}

document.getElementById('vInput').addEventListener('input', e => { v = parseFloat(e.target.value); updatePhysics(); });
document.getElementById('thetaInput').addEventListener('input', e => { thetaDeg = parseFloat(e.target.value); updatePhysics(); });
document.getElementById('muInput').addEventListener('input', e => { mu = parseFloat(e.target.value); updatePhysics(); });
document.getElementById('rInput').addEventListener('input', e => { r = parseFloat(e.target.value); updatePhysics(); });

function drawArrow(fx, fy, tx, ty, color, label) {
    const headlen = 8;
    const angle = Math.atan2(ty - fy, tx - fx);
    ctx.strokeStyle = color; 
    ctx.fillStyle = color; 
    ctx.lineWidth = 2.5;
    
    ctx.beginPath(); 
    ctx.moveTo(fx, fy); 
    ctx.lineTo(tx, ty); 
    ctx.stroke();
    
    ctx.beginPath();
    ctx.moveTo(tx, ty);
    ctx.lineTo(tx - headlen * Math.cos(angle - Math.PI / 6), ty - headlen * Math.sin(angle - Math.PI / 6));
    ctx.lineTo(tx - headlen * Math.cos(angle + Math.PI / 6), ty - headlen * Math.sin(angle + Math.PI / 6));
    ctx.fill();
    
    ctx.font = 'bold 11px JetBrains Mono, monospace';
    ctx.fillText(label, tx + 6, ty + 4);
}

function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    const originX = 150, originY = 320;
    const theta = thetaDeg * Math.PI / 180;
    const tanTheta = Math.tan(theta);
    const Fc_req = (m * v * v) / r;
    const denomMax = 1 - mu * tanTheta;
    const vMax = denomMax > 0 ? Math.sqrt(Math.max(0, r * g * (tanTheta + mu) / denomMax)) : 40;
    const denomMin = 1 + mu * tanTheta;
    const vMinSq = r * g * (tanTheta - mu) / denomMin;
    const vMin = vMinSq > 0 ? Math.sqrt(vMinSq) : 0;

    // Animate sliding offset based on stability status
    if (v > vMax) {
        slideAnimOffset = Math.min(45, slideAnimOffset + 0.8); // slide up slope
    } else if (v < vMin) {
        slideAnimOffset = Math.max(-45, slideAnimOffset - 0.8); // slide down slope
    } else {
        slideAnimOffset *= 0.92; // return smoothly to center position
    }
    
    // Draw Ground and Track Surface
    ctx.strokeStyle = '#cbd5e1'; 
    ctx.lineWidth = 2;
    ctx.beginPath(); 
    ctx.moveTo(50, originY); 
    ctx.lineTo(originX, originY); 
    ctx.stroke();

    ctx.strokeStyle = '#475569'; 
    ctx.lineWidth = 6;
    const bankLength = 340;
    const endX = originX + bankLength * Math.cos(-theta);
    const endY = originY + bankLength * Math.sin(-theta);
    ctx.beginPath(); 
    ctx.moveTo(originX, originY); 
    ctx.lineTo(endX, endY); 
    ctx.stroke();

    // Car transform along bank with dynamic slide offset animation
    ctx.save();
    ctx.translate(originX + (170 + slideAnimOffset) * Math.cos(-theta), originY + (170 + slideAnimOffset) * Math.sin(-theta));
    
    ctx.rotate(-theta);
    ctx.fillStyle = '#0ea5e9';
    ctx.fillRect(-25, -35, 50, 35);
    ctx.strokeStyle = '#0284c7'; 
    ctx.lineWidth = 2;
    ctx.strokeRect(-25, -35, 50, 35);

    // Gravity Vector
    ctx.rotate(theta); 
    drawArrow(0, 0, 0, 75, '#f59e0b', 'Fg');
    ctx.rotate(-theta); 

    // Normal Force Vector
    drawArrow(0, -15, 0, -85, '#38bdf8', 'Fn');

    // Friction Vector
    const F_ideal = m * g * tanTheta;
    if (Fc_req > F_ideal) {
        drawArrow(0, -15, -55, -15, '#f43f5e', 'Ff (down)');
    } else {
        drawArrow(0, -15, 55, -15, '#10b981', 'Ff (up)');
    }

    ctx.restore();
}

// Continuous animation loop for smooth rendering & sliding visual feedback
function loop() {
    draw();
    requestAnimationFrame(loop);
}

updatePhysics();
requestAnimationFrame(loop);