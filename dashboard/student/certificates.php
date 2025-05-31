<?php
// Simulación de cursos completados con certificado
$courses = [
    ["id" => 2, "titulo" => "Introducción a Python", "progreso" => 100],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificados | Aprende+</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
      body {
        margin: 0;
        font-family: 'Poppins', Arial, sans-serif;
        background: linear-gradient(120deg, #1dd1a1 0%, #54a0ff 100%);
        min-height: 100vh;
      }
      .student-panel {
        display: flex;
        min-height: 100vh;
      }
      .student-menu {
        width: 220px;
        background: #e6f9f3;
        display: flex;
        flex-direction: column;
        align-items: stretch;
        padding: 2rem 0 2rem 0;
        box-shadow: 2px 0 12px rgba(44,62,80,0.07);
        z-index: 10;
      }
      .student-menu .logo {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 2.5rem;
        cursor: pointer;
      }
      .student-menu .logo img {
        width: 54px;
        border-radius: 50%;
        margin-bottom: 0.5rem;
      }
      .student-menu .logo span {
        font-weight: 700;
        color: #1dd1a1;
        font-size: 1.2rem;
      }
      .student-menu nav {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
      }
      .menu-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.5rem;
        color: #19795a;
        font-weight: 600;
        border-left: 4px solid transparent;
        border-radius: 0 16px 16px 0;
        background: transparent;
        text-decoration: none;
        transition: background 0.2s, border-color 0.2s, color 0.2s;
      }
      .menu-item i {
        font-size: 1.3rem;
      }
      .menu-item.active {
        background: #c6f3e6;
        border-left: 4px solid #1dd1a1;
        color: #0e5e47;
      }
      .menu-item:hover:not(.active) {
        background: #d2f7ec;
        color: #1dd1a1;
      }
      .student-content {
        flex: 1;
        padding: 3.2rem 2.2rem 2.2rem 2.2rem;
        border-radius: 0 0 0 38px;
        min-height: 100vh;
        z-index: 1;
        background: none;
        box-shadow: none;
        position: relative;
      }
      h1 {
        color: #1dd1a1;
        text-align: center;
        margin-bottom: 2.2rem;
        font-size: 2.2rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        text-shadow: 0 2px 12px rgba(84,160,255,0.08);
      }
      .certificate-card {
        background: #e8f5e9;
        color: #388e3c;
        border-left: 4px solid #388e3c;
        padding: 1.3rem 1.7rem;
        border-radius: 10px;
        margin-bottom: 1.7rem;
        box-shadow: 0 2px 12px rgba(100,181,246,0.10);
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: box-shadow 0.18s, transform 0.18s;
      }
      .certificate-card:hover {
        box-shadow: 0 8px 32px 0 rgba(56,142,60,0.13);
        transform: translateY(-4px) scale(1.02);
      }
      .certificate-card .info {
        flex: 1;
      }
      .certificate-card .info h3 {
        margin: 0 0 0.3rem 0;
        font-size: 1.13rem;
        color: #19795a;
        font-weight: 700;
      }
      .certificate-card .info span {
        font-size: 1.01rem;
        color: #555;
      }
      .btn-descargar {
        background: linear-gradient(90deg, #1dd1a1, #54a0ff);
        color: #fff;
        padding: 0.6rem 1.4rem;
        border-radius: 22px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.22s;
        margin-left: 1.2rem;
        border: none;
        cursor: pointer;
        font-size: 1.01rem;
        box-shadow: 0 2px 8px rgba(84,160,255,0.08);
      }
      .btn-descargar:hover {
        background: linear-gradient(90deg, #54a0ff, #1dd1a1);
        color: #fff;
        transform: scale(1.06) translateY(-2px);
        box-shadow: 0 6px 24px rgba(84,160,255,0.13);
      }
      @media (max-width: 900px) {
        .student-panel { flex-direction: column; }
        .student-menu { width: 100%; flex-direction: row; justify-content: center; padding: 1.2rem 0; border-radius: 0; }
        .student-menu nav { flex-direction: row; gap: 1.2rem; }
        .student-content { border-radius: 0; padding: 1.5rem 0.5rem; }
      }
      @media (max-width: 700px) {
        .student-content { padding: 1rem 0.3rem; }
        .student-menu .logo { display: none; }
        .certificate-card { flex-direction: column; align-items: flex-start; gap: 0.7rem; }
      }
      #bouncing-balls-bg {
        position: fixed;
        top: 0; left: 0;
        width: 100vw; height: 100vh;
        z-index: 0;
        pointer-events: none;
        overflow: hidden;
        background: rgba(255,255,255,0.03);
      }
      .bouncing-ball {
        position: absolute;
        border-radius: 50%;
        opacity: 0.5;
        filter: blur(1px);
        pointer-events: none;
        transform: translate3d(0,0,0);
        will-change: transform;
        box-shadow: 0 0 15px 2px rgba(255,255,255,0.3);
      }
      .student-menu, .student-content { position: relative; z-index: 2; }
    </style>
</head>
<body>
<div id="bouncing-balls-bg"></div>
<div class="student-panel">
  <aside class="student-menu">
    <div class="logo" style="cursor:pointer;" onclick="window.history.back()" title="Volver">
      <img src="../../frontend/assets/img/APRENDEMASLOGO.png" alt="Logo Aprende+">
      <span>Aprende+</span>
    </div>
    <nav>
      <a href="courses.php" class="menu-item"><i class="fas fa-book-open"></i><span>Mis Cursos</span></a>
      <a href="progress.php" class="menu-item"><i class="fas fa-chart-bar"></i><span>Mi Progreso</span></a>
      <a href="certificates.php" class="menu-item active"><i class="fas fa-medal"></i><span>Certificados</span></a>
    </nav>
  </aside>
  <main class="student-content">
    <h1><i class="fas fa-certificate"></i> Mis Certificados</h1>
    <?php if (empty($courses)): ?>
      <p>No tienes certificados disponibles aún.</p>
    <?php else: ?>
      <?php foreach ($courses as $curso): ?>
      <div class="certificate-card">
        <div class="info">
          <h3><?= htmlspecialchars($curso['titulo']) ?></h3>
          <span>Curso completado al 100%</span>
        </div>
        <a href="#" class="btn-descargar"><i class="fas fa-download"></i> Descargar</a>
      </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </main>
</div>
<script>
// Pelotitas rebotando
const ballConfig = {
  colors: ['rgba(29, 209, 161, 0.7)', 'rgba(84, 160, 255, 0.7)', 'rgba(254, 202, 87, 0.7)'],
  count: 15,
  minSize: 30,
  maxSize: 80,
  speed: 2
};
const balls = [];
const bg = document.getElementById('bouncing-balls-bg');
function createBalls() {
  bg.innerHTML = '';
  balls.length = 0;
  for (let i = 0; i < ballConfig.count; i++) {
    const size = Math.random() * (ballConfig.maxSize - ballConfig.minSize) + ballConfig.minSize;
    const ball = document.createElement('div');
    ball.className = 'bouncing-ball';
    ball.style.width = ball.style.height = `${size}px`;
    ball.style.background = ballConfig.colors[Math.floor(Math.random() * ballConfig.colors.length)];
    const ballObj = {
      element: ball,
      x: Math.random() * (window.innerWidth - size),
      y: Math.random() * (window.innerHeight - size),
      vx: (Math.random() - 0.5) * ballConfig.speed,
      vy: (Math.random() - 0.5) * ballConfig.speed,
      size: size
    };
    bg.appendChild(ball);
    balls.push(ballObj);
  }
}
function animate() {
  const width = window.innerWidth;
  const height = window.innerHeight;
  balls.forEach(ball => {
    ball.x += ball.vx;
    ball.y += ball.vy;
    if (ball.x <= 0 || ball.x >= width - ball.size) ball.vx *= -1;
    if (ball.y <= 0 || ball.y >= height - ball.size) ball.vy *= -1;
    ball.element.style.transform = `translate3d(${ball.x}px, ${ball.y}px, 0)`;
  });
  requestAnimationFrame(animate);
}
function initBalls() {
  createBalls();
  animate();
  let resizeTimeout;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(createBalls, 100);
  });
}
document.addEventListener('DOMContentLoaded', initBalls);

// Redirección profesional si no hay sesión activa (verificación real con backend)
document.addEventListener('DOMContentLoaded', function() {
    fetch('../../backend/auth/check_session.php')
        .then(res => res.json())
        .then(data => {
            if (!data.logged_in) {
                window.location.href = '../../frontend/login.html';
            } else {
                // Mostrar botón cerrar sesión solo si hay sesión
                document.querySelectorAll('a.btn[href*="logout"]').forEach(btn => btn.style.display = 'inline-block');
            }
        })
        .catch(() => {
            window.location.href = '../../frontend/login.html';
        });
});
</script>
</body>
</html>
