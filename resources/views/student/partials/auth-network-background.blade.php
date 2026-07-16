<div class="pointer-events-none fixed inset-0 z-0 overflow-hidden bg-[#020d1c]" aria-hidden="true">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_85%_85%,rgba(6,182,212,0.12),transparent_42%)]"></div>
    <canvas id="authNetworkCanvas" class="absolute inset-0 h-full w-full"></canvas>
</div>

<script>
    (() => {
        const canvas = document.getElementById('authNetworkCanvas');
        if (!canvas) return;

        const context = canvas.getContext('2d');
        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        let width = 0;
        let height = 0;
        let nodes = [];
        let animationFrame;

        const randomBetween = (minimum, maximum) => minimum + Math.random() * (maximum - minimum);
        const randomVelocity = () => randomBetween(0.22, 0.48) * (Math.random() < 0.5 ? -1 : 1);

        const buildNodes = () => {
            const nodeCount = Math.min(125, Math.max(55, Math.floor((width * height) / 11000)));

            nodes = Array.from({ length: nodeCount }, (_, index) => {
                return {
                    x: randomBetween(0, width),
                    y: randomBetween(0, height),
                    vx: reduceMotion ? 0 : randomVelocity(),
                    vy: reduceMotion ? 0 : randomVelocity(),
                    radius: index % 13 === 0 ? randomBetween(2.1, 3.2) : randomBetween(0.8, 1.8),
                    glow: index % 13 === 0,
                };
            });
        };

        const resize = () => {
            const pixelRatio = Math.min(window.devicePixelRatio || 1, 2);
            width = window.innerWidth;
            height = window.innerHeight;
            canvas.width = Math.floor(width * pixelRatio);
            canvas.height = Math.floor(height * pixelRatio);
            canvas.style.width = `${width}px`;
            canvas.style.height = `${height}px`;
            context.setTransform(pixelRatio, 0, 0, pixelRatio, 0, 0);
            buildNodes();
        };

        const moveNodes = () => {
            nodes.forEach((node) => {
                node.x += node.vx;
                node.y += node.vy;

                if (node.x < -8 || node.x > width + 8) node.vx *= -1;
                if (node.y < -8 || node.y > height + 8) node.vy *= -1;
            });
        };

        const draw = () => {
            context.clearRect(0, 0, width, height);
            const connectionDistance = width < 640 ? 105 : 145;

            for (let first = 0; first < nodes.length; first += 1) {
                for (let second = first + 1; second < nodes.length; second += 1) {
                    const deltaX = nodes[first].x - nodes[second].x;
                    const deltaY = nodes[first].y - nodes[second].y;
                    const distance = Math.hypot(deltaX, deltaY);

                    if (distance > connectionDistance) continue;

                    const opacity = (1 - distance / connectionDistance) * 0.58;
                    context.beginPath();
                    context.moveTo(nodes[first].x, nodes[first].y);
                    context.lineTo(nodes[second].x, nodes[second].y);
                    context.strokeStyle = `rgba(6, 220, 238, ${opacity})`;
                    context.lineWidth = 0.65;
                    context.stroke();
                }
            }

            nodes.forEach((node) => {
                if (node.glow) {
                    const glow = context.createRadialGradient(node.x, node.y, 0, node.x, node.y, 14);
                    glow.addColorStop(0, 'rgba(103, 232, 249, 0.85)');
                    glow.addColorStop(0.22, 'rgba(6, 182, 212, 0.35)');
                    glow.addColorStop(1, 'rgba(6, 182, 212, 0)');
                    context.fillStyle = glow;
                    context.beginPath();
                    context.arc(node.x, node.y, 14, 0, Math.PI * 2);
                    context.fill();
                }

                context.fillStyle = node.glow ? '#a5f3fc' : 'rgba(34, 211, 238, 0.92)';
                context.beginPath();
                context.arc(node.x, node.y, node.radius, 0, Math.PI * 2);
                context.fill();
            });

            if (!reduceMotion) {
                moveNodes();
                animationFrame = window.requestAnimationFrame(draw);
            }
        };

        resize();
        draw();

        let resizeTimer;
        window.addEventListener('resize', () => {
            window.clearTimeout(resizeTimer);
            resizeTimer = window.setTimeout(() => {
                window.cancelAnimationFrame(animationFrame);
                resize();
                draw();
            }, 120);
        });

        document.addEventListener('visibilitychange', () => {
            window.cancelAnimationFrame(animationFrame);
            if (!document.hidden && !reduceMotion) draw();
        });
    })();
</script>
