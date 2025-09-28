<?php
session_start();
require_once __DIR__ . '/../backend/db/db.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header('Location: /AprendePlus/frontend/login.html');
    exit;
}

// Obtener información del usuario
$user_id = $_SESSION['user_id'];

// Asegurarse de que $conn es una instancia de mysqli
if (!($conn instanceof mysqli)) {
    die("Error: La conexión a la base de datos no es válida.");
}

$stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result === false) {
    die("Error al obtener el resultado: " . $stmt->error);
}
$user = $result->fetch_assoc();
$stmt->close();

// Determinar el rol del usuario
$role = $user['role'] ?? 'student'; // Por defecto student si no está definido
$username = $user['username'] ?? 'Estudiante';

// Incluir el header
include 'header.php';
?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Aprende+ | <?= htmlspecialchars(ucfirst($role)) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/AprendePlus/dashboard/assets/css/dashboard.css">
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
        position: fixed;
        top: 0; left: 0; bottom: 0;
        width: 220px;
        background: #e6f9f3;
        display: flex;
        flex-direction: column;
        align-items: stretch;
        padding: 2rem 0 2rem 0;
        box-shadow: 2px 0 12px rgba(44,62,80,0.07);
        z-index: 10;
        height: 100vh;
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
        margin-left: 220px;
        flex: 1;
        padding: 3rem 2rem;
        border-radius: 0 0 0 32px;
        min-height: 100vh;
        z-index: 1;
      }
      .welcome-message h1 {
        font-size: 2.2rem;
        color: #1dd1a1;
        font-weight: 700;
        margin-bottom: 0.7rem;
      }
      .welcome-message p {
        font-size: 1.1rem;
        color: #555;
        margin-bottom: 2.2rem;
      }
      .stats {
        display: flex;
        gap: 2rem;
        justify-content: center;
        margin-bottom: 2.5rem;
        flex-wrap: wrap;
      }
      .stat-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 1.5px 8px rgba(100,181,246,0.07);
        padding: 1.2rem 1.5rem;
        text-align: center;
        min-width: 150px;
        position: relative;
        overflow: hidden;
        transition: box-shadow 0.18s, background 0.18s;
      }
      .stat-card:hover {
        box-shadow: 0 4px 16px 0 rgba(31, 38, 135, 0.10);
        background: #f7fafc;
      }
      .stat-card h2 {
        color: #1dd1a1;
        font-size: 2rem;
        margin: 0 0 0.3rem 0;
      }
      .stat-card span {
        color: #555;
        font-size: 1rem;
      }
      .quick-links {
        display: flex;
        gap: 1.5rem;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 2rem;
      }
      .quick-link {
        display: flex;
        align-items: center;
        gap: 0.7rem;
        background: linear-gradient(90deg, #1dd1a1, #54a0ff);
        color: #fff;
        padding: 1.1rem 2.2rem;
        border-radius: 30px;
        font-weight: 700;
        text-decoration: none;
        font-size: 1.2rem;
        box-shadow: 0 2px 12px rgba(100,181,246,0.10);
        transition: all 0.22s;
        letter-spacing: 0.5px;
        position: relative;
        overflow: hidden;
        border: none;
        cursor: pointer;
      }
      .quick-link i {
        font-size: 1.5rem;
      }
      .quick-link:hover {
        background: #10ac84;
        color: #fff;
      }
      @media (max-width: 900px) {
        .student-panel { flex-direction: column; }
        .student-menu { position: static; width: 100%; height: auto; flex-direction: row; justify-content: center; padding: 1rem 0; border-radius: 0; }
        .student-menu nav { flex-direction: row; gap: 1rem; }
        .student-content { border-radius: 0; padding: 1.5rem 0.5rem; margin-left: 0; }
      }
      @media (max-width: 700px) {
        .student-content { padding: 1rem 0.3rem; }
        .student-menu .logo { display: none; }
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
    <div class="logo" onclick="window.history.back()" title="Volver">
      <img src="/AprendePlus/frontend/assets/img/APRENDEMASLOGO.png" alt="Logo Aprende+">
      <span>Aprende+</span>
    </div>
    <nav>
      <?php if ($role === 'admin'): ?>
        <a href="?view=all_courses" class="menu-item<?= (!isset($_GET['view']) || $_GET['view'] === 'all_courses') ? ' active' : '' ?>"><i class="fas fa-book"></i><span>Todos los Cursos</span></a>
        <a href="?view=users" class="menu-item<?= (isset($_GET['view']) && $_GET['view'] === 'users') ? ' active' : '' ?>"><i class="fas fa-users"></i><span>Usuarios</span></a>
        <a href="?view=settings" class="menu-item<?= (isset($_GET['view']) && $_GET['view'] === 'settings') ? ' active' : '' ?>"><i class="fas fa-cog"></i><span>Configuración</span></a>
      <?php else: ?>
        <a href="?view=courses" class="menu-item<?= (!isset($_GET['view']) || $_GET['view'] === 'courses') ? ' active' : '' ?>"><i class="fas fa-book-open"></i><span>Mis Cursos</span></a>
        <a href="?view=progress" class="menu-item<?= (isset($_GET['view']) && $_GET['view'] === 'progress') ? ' active' : '' ?>"><i class="fas fa-chart-bar"></i><span>Mi Progreso</span></a>
        <a href="?view=certificates" class="menu-item<?= (isset($_GET['view']) && $_GET['view'] === 'certificates') ? ' active' : '' ?>"><i class="fas fa-medal"></i><span>Certificados</span></a>
      <?php endif; ?>
    </nav>
  </aside>
  <main class="student-content">
    <div class="welcome-message">
      <h1>¡Bienvenido, <?= htmlspecialchars($username) ?>!</h1>
      <p>Este es tu panel principal. Aquí puedes ver tus cursos, progreso y certificados si eres estudiante, o gestionar la plataforma si eres administrador.</p>
    </div>
    <?php if ($role === 'admin'): ?>
      <div class="quick-links">
        <a href="?view=all_courses" class="quick-link"><i class="fas fa-book"></i> Todos los Cursos</a>
        <a href="?view=users" class="quick-link"><i class="fas fa-users"></i> Usuarios</a>
        <a href="?view=settings" class="quick-link"><i class="fas fa-cog"></i> Configuración</a>
      </div>
      <div style="margin-top:2.5rem;">
        <?php
        $view = $_GET['view'] ?? 'all_courses';
        switch ($view) {
          case 'users':
            require_once __DIR__ . '/admin/users.php';
            break;
          case 'settings':
            require_once __DIR__ . '/admin/settings.php';
            break;
          case 'create_course':
            require_once __DIR__ . '/admin/create_course.php';
            break;
          case 'edit_course':
            require_once __DIR__ . '/admin/edit_course.php';
            break;
          case 'delete_course':
            require_once __DIR__ . '/admin/delete_course.php';
            break;
          case 'dashboard':
            require_once __DIR__ . '/admin/dashboard.php';
            break;
          default:
            require_once __DIR__ . '/admin/all_courses.php';
        }
        ?>
      </div>
    <?php else: ?>
      <div class="quick-links">
        <a href="?view=courses" class="quick-link"><i class="fas fa-book"></i> Mis Cursos</a>
        <a href="?view=progress" class="quick-link"><i class="fas fa-chart-line"></i> Mi Progreso</a>
        <a href="?view=certificates" class="quick-link"><i class="fas fa-certificate"></i> Certificados</a>
      </div>
      <div style="margin-top:2.5rem;">
        <?php
        $view = $_GET['view'] ?? 'courses';
        switch ($view) {
          case 'progress':
            require_once __DIR__ . '/student/progress.php';
            break;
          case 'certificates':
            require_once __DIR__ . '/student/certificates.php';
            break;
          case 'course_detail':
            require_once __DIR__ . '/student/course_detail.php';
            break;
          case 'dashboard':
            require_once __DIR__ . '/student/dashboard.php';
            break;
          default:
            require_once __DIR__ . '/student/courses.php';
        }
        ?>
      </div>
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
</script>
</body>
</html>