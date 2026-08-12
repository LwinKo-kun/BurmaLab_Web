document.addEventListener("DOMContentLoaded", () => {
    const canvas = document.getElementById('simCanvas');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');

    const massInput = document.getElementById('massInput') || { value: 10 };
    const forceInput = document.getElementById('forceInput') || { value: 50 };
    const massVal = document.getElementById('massVal');
    const forceVal = document.getElementById('forceVal');
    const statAcc = document.getElementById('statAcc');
    const statTension = document.getElementById('statTension');

    const startBtn = document.getElementById('startBtn');
    const resetBtn = document.getElementById('resetBtn');

    let mass = parseFloat(massInput.value);
    let appliedForce = parseFloat(forceInput.value);
    const g = 9.81;

    let posY = 150;
    let velocity = 0;
    let isRunning = false;
    let animId;

    function resize() {
        canvas.width = canvas.parentElement.clientWidth;
        canvas.height = canvas.width * 0.5625;
        draw();
    }
    window.addEventListener('resize', resize);

    function updatePhysics() {
        // Ideal double pulley gives 2x mechanical advantage
        const weight = mass * g;
        const netForce = (2 * appliedForce) - weight;
        const acceleration = netForce / mass;

        if (statAcc) statAcc.textContent = `${acceleration.toFixed(2)} m/s²`;
        if (statTension) statTension.textContent = `${appliedForce.toFixed(1)} N`;

        return acceleration;
    }

    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        const centerX = canvas.width / 2;

        // Anchor Ceiling
        ctx.fillStyle = '#334155';
        ctx.fillRect(centerX - 100, 20, 200, 10);

        // Fixed Upper Pulley
        ctx.beginPath();
        ctx.arc(centerX, 60, 25, 0, Math.PI * 2);
        ctx.fillStyle = '#475569';
        ctx.fill();
        ctx.strokeStyle = '#94A3B8';
        ctx.lineWidth = 4;
        ctx.stroke();

        // Moving Lower Pulley
        const lowerPulleyY = Math.min(canvas.height - 80, Math.max(100, posY));
        ctx.beginPath();
        ctx.arc(centerX, lowerPulleyY, 20, 0, Math.PI * 2);
        ctx.fillStyle = '#64748B';
        ctx.fill();
        ctx.stroke();

        // Ropes
        ctx.strokeStyle = '#CBD5E1';
        ctx.lineWidth = 2;
        ctx.beginPath();
        ctx.moveTo(centerX - 25, 20);
        ctx.lineTo(centerX - 25, lowerPulleyY);
        ctx.moveTo(centerX + 25, 60);
        ctx.lineTo(centerX + 25, lowerPulleyY);
        ctx.stroke();

        // Suspended Load
        ctx.fillStyle = '#6366F1';
        ctx.fillRect(centerX - 30, lowerPulleyY + 20, 60, 50);
        ctx.fillStyle = '#FFFFFF';
        ctx.font = 'bold 12px sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText(`${mass} kg`, centerX, lowerPulleyY + 50);
    }

    function loop() {
        const acc = updatePhysics();
        if (isRunning) {
            velocity += acc * 0.016;
            posY -= velocity * 0.5;

            if (posY <= 100 || posY >= canvas.height - 80) {
                isRunning = false;
            }
        }
        draw();
        if (isRunning) animId = requestAnimationFrame(loop);
    }

    if (massInput) massInput.addEventListener('input', (e) => {
        mass = parseFloat(e.target.value);
        if (massVal) massVal.textContent = `${mass} kg`;
        updatePhysics();
        draw();
    });

    if (forceInput) forceInput.addEventListener('input', (e) => {
        appliedForce = parseFloat(e.target.value);
        if (forceVal) forceVal.textContent = `${appliedForce} N`;
        updatePhysics();
        draw();
    });

    if (startBtn) startBtn.addEventListener('click', () => {
        if (!isRunning) {
            isRunning = true;
            loop();
        }
    });

    if (resetBtn) resetBtn.addEventListener('click', () => {
        isRunning = false;
        cancelAnimationFrame(animId);
        posY = 150;
        velocity = 0;
        updatePhysics();
        draw();
    });

    resize();
});