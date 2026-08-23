const canvas = document.getElementById('simCanvas');
const ctx = canvas.getContext('2d');

let jawPos = 35; // Start fully open
let targetJawPos = 35;
let objectWidth = getRandomWidth();
const scaleFactor = 8; // 1 mm = 8 pixels
const originX = 120; 
const originY = 160;

// Drag state variables
let isDragging = false;
let dragOffsetX = 0;

function getRandomWidth() {
    // Generate a random width between 5.0 mm and 30.0 mm
    return Math.round((Math.random() * 25 + 5) * 10) / 10;
}

function updateTelemetry() {
    const msr = Math.floor(jawPos);
    const vsrFraction = jawPos - msr;
    const vsrLine = Math.round(vsrFraction * 10);
    const calculatedTotal = (msr + vsrLine * 0.1).toFixed(2);

    document.getElementById('statMSR').textContent = msr.toFixed(1);
    document.getElementById('statVSR').textContent = (vsrLine * 0.1).toFixed(2);
    document.getElementById('statTotal').textContent = calculatedTotal;
}

// Button Listeners
document.getElementById('clampBtn').addEventListener('click', () => { targetJawPos = objectWidth; });
document.getElementById('resetBtn').addEventListener('click', () => { targetJawPos = 35; });
document.getElementById('randomObjBtn').addEventListener('click', () => {
    objectWidth = getRandomWidth();
    // If the new object is bigger than the current gap, push the jaw open
    if (targetJawPos < objectWidth) {
        targetJawPos = objectWidth;
        jawPos = objectWidth;
    }
    updateTelemetry();
});

// --- Mouse & Touch Interaction Logic ---

function getPointerPos(evt) {
    const rect = canvas.getBoundingClientRect();
    const clientX = evt.touches ? evt.touches[0].clientX : evt.clientX;
    const clientY = evt.touches ? evt.touches[0].clientY : evt.clientY;
    return {
        x: (clientX - rect.left) * (canvas.width / rect.width),
        y: (clientY - rect.top) * (canvas.height / rect.height)
    };
}

function handlePointerDown(e) {
    const pos = getPointerPos(e);
    const slideX = originX + jawPos * scaleFactor;
    
    // Check if click is inside the sliding blue jaw bounding box
    if (pos.x >= slideX && pos.x <= slideX + 90 && pos.y >= originY - 45 && pos.y <= originY + 90) {
        isDragging = true;
        dragOffsetX = pos.x - slideX;
        canvas.style.cursor = 'grabbing';
        e.preventDefault(); // Prevent scrolling on touch devices
    }
}

function handlePointerMove(e) {
    const pos = getPointerPos(e);
    const slideX = originX + jawPos * scaleFactor;

    if (!isDragging) {
        // Hover effect
        if (pos.x >= slideX && pos.x <= slideX + 90 && pos.y >= originY - 45 && pos.y <= originY + 90) {
            canvas.style.cursor = 'grab';
        } else {
            canvas.style.cursor = 'default';
        }
    } else {
        // Dragging effect
        let newSlideX = pos.x - dragOffsetX;
        let newJawPos = (newSlideX - originX) / scaleFactor;

        // Collision constraints
        if (newJawPos < objectWidth) newJawPos = objectWidth; // Stop at object
        if (newJawPos > 35) newJawPos = 35; // Max open position

        jawPos = newJawPos;
        targetJawPos = newJawPos; // Sync target so animation loop doesn't fight the drag
        updateTelemetry();
        e.preventDefault();
    }
}

function handlePointerUp() {
    if (isDragging) {
        isDragging = false;
        canvas.style.cursor = 'default';
    }
}

// Attach event listeners for mouse
canvas.addEventListener('mousedown', handlePointerDown);
canvas.addEventListener('mousemove', handlePointerMove);
window.addEventListener('mouseup', handlePointerUp);

// Attach event listeners for touch (iPad/Mobile)
canvas.addEventListener('touchstart', handlePointerDown, { passive: false });
canvas.addEventListener('touchmove', handlePointerMove, { passive: false });
window.addEventListener('touchend', handlePointerUp);

// --- Render Loop ---

function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Main Beam
    ctx.fillStyle = '#e2e8f0';
    ctx.fillRect(originX, originY - 40, 380, 40);
    ctx.strokeStyle = '#94a3b8';
    ctx.strokeRect(originX, originY - 40, 380, 40);

    // Main Fixed Jaw (Left)
    ctx.fillStyle = '#cbd5e1';
    ctx.beginPath();
    ctx.moveTo(originX, originY - 40);
    ctx.lineTo(originX - 30, originY - 40);
    ctx.lineTo(originX - 30, originY + 90);
    ctx.lineTo(originX, originY + 50);
    ctx.closePath();
    ctx.fill();
    ctx.stroke();

    // Main Scale Markings (mm)
    ctx.fillStyle = '#0f172a';
    ctx.font = '9px JetBrains Mono';
    for (let i = 0; i <= 45; i++) {
        const x = originX + i * scaleFactor;
        const isCm = i % 10 === 0;
        const tickHeight = isCm ? 18 : (i % 5 === 0 ? 12 : 7);
        ctx.beginPath();
        ctx.moveTo(x, originY);
        ctx.lineTo(x, originY - tickHeight);
        ctx.stroke();
        if (isCm) {
            ctx.fillText(i / 10, x - 3, originY - 22);
        }
    }

    // Sample Object
    const objPx = objectWidth * scaleFactor;
    ctx.fillStyle = '#f59e0b';
    ctx.fillRect(originX, originY, objPx, 50);
    ctx.strokeStyle = '#b45309';
    ctx.strokeRect(originX, originY, objPx, 50);

    // Sliding Vernier Jaw
    const slideX = originX + jawPos * scaleFactor;
    ctx.fillStyle = 'rgba(99, 102, 241, 0.25)';
    ctx.fillRect(slideX, originY - 45, 90, 50);
    ctx.strokeStyle = '#4f46e5';
    ctx.strokeRect(slideX, originY - 45, 90, 50);

    // Sliding Bottom Jaw
    ctx.fillStyle = '#818cf8';
    ctx.beginPath();
    ctx.moveTo(slideX, originY + 5);
    ctx.lineTo(slideX, originY + 90);
    ctx.lineTo(slideX + 25, originY + 50);
    ctx.lineTo(slideX + 25, originY + 5);
    ctx.closePath();
    ctx.fill();
    ctx.stroke();

    // Vernier Scale Markings (10 divisions spanning 9mm)
    ctx.strokeStyle = '#312e81';
    for (let v = 0; v <= 10; v++) {
        const vx = slideX + v * (scaleFactor * 0.9);
        ctx.beginPath();
        ctx.moveTo(vx, originY - 45);
        ctx.lineTo(vx, originY - 35);
        ctx.stroke();
    }
}

let lastTime = performance.now();
function loop(time) {
    const dt = (time - lastTime) / 1000;
    lastTime = time;

    // Smooth transition for Auto-Clamp and Reset buttons
    if (!isDragging && Math.abs(jawPos - targetJawPos) > 0.05) {
        jawPos += (targetJawPos - jawPos) * 10 * dt;
        updateTelemetry();
    }

    draw();
    requestAnimationFrame(loop);
}

updateTelemetry();
requestAnimationFrame(loop);