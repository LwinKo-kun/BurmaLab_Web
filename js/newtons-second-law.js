document.addEventListener("DOMContentLoaded", () => {
    const canvas = document.getElementById('simCanvas');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');

    const massInput = document.getElementById('massInput') || { value: 5 };
    const forceInput = document.getElementById('forceInput') || { value: 20 };
    const massVal = document.getElementById('massVal');
    const forceVal = document.getElementById('forceVal');
    const statAcc = document.getElementById('statAcc');
    const statVel = document.getElementById('statVel');

    const startBtn = document.getElementById('startBtn');
    const resetBtn = document.getElementById('resetBtn');

    let mass = parseFloat(massInput.value);
    let force = parseFloat(forceInput.value);

    let posX = 50;
    let velocity = 0;
    let isRunning = false;
    let animId;

    function resize() {
        canvas.width = canvas.parentElement.clientWidth;
        canvas.height = canvas.width * 0.5625;
        draw();
    }
    window.addEventListener('resize', resize);

    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        const groundY = canvas.height - 40;

        // Ground Track
        ctx.fillStyle = '#1E293B';
        ctx.fillRect(0, groundY, canvas.width, 40);
        ctx.strokeStyle = '#334155';
        ctx.lineWidth = 2;
        ctx.beginPath();
        ctx.moveTo(0, groundY);
        ctx.lineTo(canvas.width, groundY);
        ctx.stroke();

        // Sliding Block
        const blockWidth = 70;
        const blockHeight = 50;
        const blockY = groundY - blockHeight;

        ctx.fillStyle = '#38BDF8';
        ctx.fillRect(posX, blockY, blockWidth, blockHeight);
        ctx.strokeStyle = '#0284C7';
        ctx.lineWidth = 2;
        ctx.strokeRect(posX, blockY, blockWidth, blockHeight);

        // Label
        ctx.fillStyle = '#0F172A';
        ctx.font = 'bold 14px sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText(`${mass} kg`, posX + blockWidth / 2, blockY + 30);

        // Force Vector Arrow
        if (force > 0) {
            const arrowStartX = posX + blockWidth;
            const arrowStartY = blockY + blockHeight / 2;
            const arrowLength = Math.min(150, force * 3);

            ctx.strokeStyle = '#F43F5E';
            ctx.lineWidth = 4;
            ctx.beginPath();
            ctx.moveTo(arrowStartX, arrowStartY);
            ctx.lineTo(arrowStartX + arrowLength, arrowStartY);
            ctx.stroke();

            // Arrowhead
            ctx.fillStyle = '#F43F5E';
            ctx.beginPath();
            ctx.moveTo(arrowStartX + arrowLength, arrowStartY - 8);
            ctx.lineTo(arrowStartX + arrowLength + 12, arrowStartY);
            ctx.lineTo(arrowStartX + arrowLength, arrowStartY + 8);
            ctx.fill();

            // Force text
            ctx.fillStyle = '#FB7185';
            ctx.font = 'bold 12px sans-serif';
            ctx.fillText(`F = ${force} N`, arrowStartX + arrowLength / 2, arrowStartY - 10);
        }
    }

    function animate() {
        const acceleration = force / mass;
        if (statAcc) statAcc.textContent = `${acceleration.toFixed(2)} m/s²`;

        if (isRunning) {
            velocity += acceleration * 0.016;
            posX += velocity * 2;

            if (statVel) statVel.textContent = `${velocity.toFixed(2)} m/s`;

            if (posX >= canvas.width - 120) {
                isRunning = false;
            }
        }

        draw();
        if (isRunning) animId = requestAnimationFrame(animate);
    }

    if (massInput) massInput.addEventListener('input', (e) => {
        mass = parseFloat(e.target.value);
        if (massVal) massVal.textContent = `${mass} kg`;
        draw();
    });

    if (forceInput) forceInput.addEventListener('input', (e) => {
        force = parseFloat(e.target.value);
        if (forceVal) forceVal.textContent = `${force} N`;
        draw();
    });

    if (startBtn) startBtn.addEventListener('click', () => {
        if (!isRunning) {
            isRunning = true;
            animate();
        }
    });

    if (resetBtn) resetBtn.addEventListener('click', () => {
        isRunning = false;
        cancelAnimationFrame(animId);
        posX = 50;
        velocity = 0;
        if (statVel) statVel.textContent = '0.00 m/s';
        draw();
    });

    resize();
});