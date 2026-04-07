<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>PT ESHA Farmasi - 3D Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html { margin: 0; padding: 0; height: 100%; overflow: hidden; font-family: 'Poppins', sans-serif; }
        #canvas3d { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; background: #050505; }
        .glass-main {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 30px;
            padding: 50px;
            color: white;
            box-shadow: 0 25px 50px rgba(0,0,0,0.5);
        }
        .btn-modern {
            border-radius: 50px;
            padding: 15px 30px;
            transition: 0.3s;
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

<canvas id="canvas3d"></canvas>

<div class="container h-100 d-flex align-items-center justify-content-center">
    <div class="glass-main text-center shadow-lg">
        <h1 class="display-3 fw-bold mb-3">PT ESHA FARMASI</h1>
        <p class="fs-5 mb-5 opacity-75">Advanced Pharmacy Information System v2.0</p>
        <div class="d-flex gap-3 justify-content-center">
            <a href="penjualan.php" class="btn btn-primary btn-modern px-5">Kasir</a>
            <a href="barang.php" class="btn btn-outline-light btn-modern px-5">Gudang</a>
            <a href="laporanbulanan.php" class="btn btn-info btn-modern px-5">Laporan</a>
        </div>
    </div>
</div>

<script>
    const canvas = document.getElementById('canvas3d');
    const ctx = canvas.getContext('2d');
    let particles = [];
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    class Particle {
        constructor() {
            this.x = Math.random() * canvas.width;
            this.y = Math.random() * canvas.height;
            this.size = Math.random() * 2 + 1;
            this.speedX = Math.random() * 1 - 0.5;
            this.speedY = Math.random() * 1 - 0.5;
        }
        update() {
            this.x += this.speedX;
            this.y += this.speedY;
            if (this.x > canvas.width) this.x = 0;
            if (this.x < 0) this.x = canvas.width;
            if (this.y > canvas.height) this.y = 0;
            if (this.y < 0) this.y = canvas.height;
        }
        draw() {
            ctx.fillStyle = 'rgba(0, 150, 255, 0.8)';
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.fill();
        }
    }

    function init() {
        for (let i = 0; i < 100; i++) particles.push(new Particle());
    }

    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        for (let i = 0; i < particles.length; i++) {
            particles[i].update();
            particles[i].draw();
            for (let j = i; j < particles.length; j++) {
                const dx = particles[i].x - particles[j].x;
                const dy = particles[i].y - particles[j].y;
                const distance = Math.sqrt(dx * dx + dy * dy);
                if (distance < 100) {
                    ctx.strokeStyle = 'rgba(0, 150, 255,' + (1 - distance/100) + ')';
                    ctx.lineWidth = 0.5;
                    ctx.beginPath();
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y);
                    ctx.stroke();
                }
            }
        }
        requestAnimationFrame(animate);
    }
    init(); animate();
</script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>PT ESHA Farmasi - 3D System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html { margin: 0; padding: 0; height: 100%; overflow: hidden; background: #000; font-family: 'Segoe UI', sans-serif; }
        #bg3d { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; }
        .glass-container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            padding: 60px;
            color: white;
            text-align: center;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.8);
        }
        .btn-custom { border-radius: 30px; padding: 12px 30px; font-weight: 600; transition: 0.4s; }
        .btn-custom:hover { transform: scale(1.1); box-shadow: 0 0 20px rgba(0, 123, 255, 0.5); }
    </style>
</head>
<body>
    <canvas id="bg3d"></canvas>
    <div class="container h-100 d-flex align-items-center justify-content-center">
        <div class="glass-container shadow-lg">
            <h1 class="display-3 fw-bold mb-2">PT ESHA FARMASI</h1>
            <p class="lead mb-5">Sistem Informasi Farmasi Terpadu & Futuristik</p>
            <div class="d-flex gap-3 justify-content-center">
                <a href="penjualan.php" class="btn btn-primary btn-custom">KASIR</a>
                <a href="barang.php" class="btn btn-outline-light btn-custom">STOK BARANG</a>
                <a href="laporanbulanan.php" class="btn btn-info btn-custom">LAPORAN</a>
            </div>
        </div>
    </div>

    <script>
        const canvas = document.getElementById('bg3d');
        const ctx = canvas.getContext('2d');
        let particles = [];
        canvas.width = window.innerWidth; canvas.height = window.innerHeight;

        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.size = 2;
                this.speedX = Math.random() * 2 - 1;
                this.speedY = Math.random() * 2 - 1;
            }
            update() {
                this.x += this.speedX; this.y += this.speedY;
                if (this.x > canvas.width || this.x < 0) this.speedX *= -1;
                if (this.y > canvas.height || this.y < 0) this.speedY *= -1;
            }
            draw() {
                ctx.fillStyle = '#00d4ff';
                ctx.beginPath(); ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2); ctx.fill();
            }
        }

        for (let i = 0; i < 80; i++) particles.push(new Particle());

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            particles.forEach((p, i) => {
                p.update(); p.draw();
                for (let j = i; j < particles.length; j++) {
                    const dx = p.x - particles[j].x;
                    const dy = p.y - particles[j].y;
                    const dist = Math.sqrt(dx*dx + dy*dy);
                    if (dist < 120) {
                        ctx.strokeStyle = `rgba(0, 212, 255, ${1 - dist/120})`;
                        ctx.lineWidth = 0.5;
                        ctx.beginPath(); ctx.moveTo(p.x, p.y); ctx.lineTo(particles[j].x, particles[j].y); ctx.stroke();
                    }
                }
            });
            requestAnimationFrame(animate);
        }
        animate();
    </script>
</body>
</html>