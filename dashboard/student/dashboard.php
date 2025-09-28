<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'student') {
    header('Location: /AprendePlus/frontend/login.html');
    exit;
}
// Simulación de usuario logueado
if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = 'Estudiante';
}
$username = $_SESSION['username'];
// Simulación de datos para el dashboard del estudiante
$courses = [
    ["id" => 1, "titulo" => "Programación en PHP", "progreso" => 60],
    ["id" => 2, "titulo" => "Introducción a Python", "progreso" => 100],
    ["id" => 3, "titulo" => "Diseño Web", "progreso" => 35],
];
$total_cursos = count($courses);
$cursos_completados = count(array_filter($courses, fn($c) => $c["progreso"] >= 100));
$promedio_progreso = $total_cursos ? round(array_sum(array_column($courses, "progreso")) / $total_cursos) : 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Estudiante | Aprende+</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
      :root {
        --primary: #1dd1a1;
        --secondary: #54a0ff;
        --bg: #f7fafc;
        --white: #fff;
        --text: #222;
        --muted: #888;
        --shadow: 0 4px 24px rgba(44,62,80,0.08);
        --radius: 16px;
      }
      html, body {
        margin: 0;
        padding: 0;
        font-family: 'Poppins', Arial, sans-serif;
        background: linear-gradient(120deg, var(--primary) 0%, var(--secondary) 100%);
        min-height: 100vh;
        color: var(--text);
        background-repeat: no-repeat;
        background-attachment: fixed;
      }
      .student-panel {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        background: transparent;
      }
      .student-menu {
        width: 100%;
        background: var(--white);
        box-shadow: var(--shadow);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.5rem 2.5vw;
        position: sticky;
        top: 0;
        z-index: 100;
      }
      .student-menu .logo {
        display: flex;
        align-items: center;
        gap: 0.7rem;
        font-weight: 700;
        font-size: 1.2rem;
        color: var(--primary);
        cursor: pointer;
        user-select: none;
        margin-bottom: 0;
        margin-right: 0;
      }
      .student-menu .logo img {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        box-shadow: 0 2px 8px rgba(84,160,255,0.10);
        margin-right: 0.7rem;
      }
      .student-menu nav {
        display: flex;
        gap: 1.2rem;
        align-items: center;
        flex-direction: row;
      }
      .menu-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1.1rem;
        border-radius: 22px;
        font-size: 1.05rem;
        font-weight: 600;
        color: var(--text);
        background: none;
        border: none;
        transition: background 0.18s, color 0.18s;
        text-decoration: none;
      }

      .menu-item.active, .menu-item:hover {
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        color: var(--white);
        box-shadow: 0 2px 8px rgba(84,160,255,0.10);
      }
      .student-content {
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 1.5rem 2.5rem 1.5rem;
        width: 100%;
        border-radius: 0;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
      }
      .welcome-message h1 {
        font-size: 2.3rem;
        color: var(--primary);
        font-weight: 800;
        margin-bottom: 0.7rem;
        letter-spacing: 0.5px;
        text-shadow: 0 2px 12px rgba(84,160,255,0.08);
        display: flex;
        align-items: center;
        gap: 0.7rem;
      }
      .welcome-message p {
        font-size: 1.1rem;
        color: #555;
        margin-bottom: 2.2rem;
      }
      .stats {
        display: flex;
        gap: 2.2rem;
        justify-content: center;
        margin-bottom: 2.5rem;
        flex-wrap: wrap;
      }
      .stat-card {
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding: 2.1rem 1.3rem 1.3rem 1.3rem;
        text-align: center;
        min-width: 210px;
        position: relative;
        overflow: hidden;
        transition: box-shadow 0.18s, background 0.18s;
      }
      .stat-card:hover {
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.13);
        background: #f7fafc;
      }
      .stat-card h2 {
        color: var(--secondary);
        font-size: 2.1rem;
        margin: 0 0 0.3rem 0;
      }
      .stat-card span {
        color: var(--muted);
        font-size: 1.01rem;
        font-weight: 500;
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
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        color: var(--white);
        padding: 0.7rem 1.3rem;
        border-radius: 30px;
        font-weight: 700;
        text-decoration: none;
        font-size: 1rem;
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
      .dashboard-bubble {
        background: rgba(255,255,255,0.82);
        border-radius: 32px;
        box-shadow: 0 8px 40px 0 rgba(44,62,80,0.13);
        padding: 2.5rem 2.5rem 2.2rem 2.5rem;
        max-width: 700px;
        margin: 0 auto;
        position: relative;
        z-index: 2;
        min-width: 320px;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        display: flex;
        flex-direction: column;
        align-items: center;
      }
      .bubble-background {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        z-index: 0;
        overflow: hidden;
        background: linear-gradient(120deg, #e0eafc 0%, #cfdef3 100%);
      }
      .bubble {
        position: absolute;
        border-radius: 50%;
        opacity: 0.35;
        background: radial-gradient(circle at 30% 30%, #aee1f9 60%, #fff0 100%);
        animation: floatBubble 38s linear infinite;
        pointer-events: none;
        filter: blur(2px);
      }
      .bubble:nth-child(1) { width: 120px; height: 120px; left: 10vw; top: 70vh; background: radial-gradient(circle at 30% 30%, #aee1f9 60%, #fff0 100%); animation-duration: 48s; animation-delay: 0s; }
      .bubble:nth-child(2) { width: 80px; height: 80px; left: 60vw; top: 80vh; background: radial-gradient(circle at 70% 70%, #f7d9e3 60%, #fff0 100%); animation-duration: 60s; animation-delay: 5s; }
      .bubble:nth-child(3) { width: 200px; height: 200px; left: 80vw; top: 60vh; background: radial-gradient(circle at 50% 50%, #b6f7e3 60%, #fff0 100%); animation-duration: 70s; animation-delay: 10s; }
      .bubble:nth-child(4) { width: 100px; height: 100px; left: 30vw; top: 10vh; background: radial-gradient(circle at 60% 60%, #f9e7ae 60%, #fff0 100%); animation-duration: 55s; animation-delay: 2s; }
      .bubble:nth-child(5) { width: 150px; height: 150px; left: 70vw; top: 20vh; background: radial-gradient(circle at 40% 40%, #e1b6f7 60%, #fff0 100%); animation-duration: 65s; animation-delay: 7s; }
      .bubble:nth-child(6) { width: 60px; height: 60px; left: 50vw; top: 50vh; background: radial-gradient(circle at 60% 60%, #f7b6b6 60%, #fff0 100%); animation-duration: 50s; animation-delay: 3s; }
      .bubble:nth-child(7) { width: 90px; height: 90px; left: 20vw; top: 40vh; background: radial-gradient(circle at 40% 40%, #b6f7e3 60%, #fff0 100%); animation-duration: 58s; animation-delay: 8s; }
      .bubble:nth-child(8) { width: 110px; height: 110px; left: 80vw; top: 10vh; background: radial-gradient(circle at 60% 60%, #f7e1b6 60%, #fff0 100%); animation-duration: 62s; animation-delay: 4s; }
      .bubble:nth-child(9) { width: 70px; height: 70px; left: 40vw; top: 80vh; background: radial-gradient(circle at 50% 50%, #b6d6f7 60%, #fff0 100%); animation-duration: 54s; animation-delay: 6s; }
      .bubble:nth-child(10) { width: 130px; height: 130px; left: 60vw; top: 30vh; background: radial-gradient(circle at 30% 30%, #f7b6e1 60%, #fff0 100%); animation-duration: 68s; animation-delay: 9s; }
      @keyframes floatBubble {
        0% { transform: translateY(0) scale(1); opacity: 0.35; }
        50% { transform: translateY(-60vh) scale(1.1); opacity: 0.5; }
        100% { transform: translateY(0) scale(1); opacity: 0.35; }
      }
      @media (max-width: 900px) {
        .dashboard-bubble {
          padding: 1.2rem 0.7rem 1.2rem 0.7rem;
          margin: 0 auto;
          max-width: 98vw;
        }
        .student-content {
          padding: 1rem 0.5rem;
        }
      }
      @media (max-width: 700px) {
        .student-content { padding: 0.5rem 0.1rem; }
        .welcome-message h1 { font-size: 1.3rem; }
        .stat-card { padding: 1.1rem 0.7rem; min-width: 120px; }
        .student-menu { padding: 0.5rem 0.5rem; }
        .student-menu .logo img { width: 32px; height: 32px; }
      }
      .student-menu, .student-content { position: relative; z-index: 2; }
      @media (max-width: 900px) {
        .student-menu nav {
          flex-direction: column;
          gap: 0.5rem;
        }
        .student-menu .logo {
          margin: 0 0 1rem 0;
        }
        .student-content { padding: 1rem 0.5rem; }
        .stats { gap: 1.5rem; }
      }
    </style>
</head>
<body>
<div class="bubble-background">
  <div class="bubble"></div>
  <div class="bubble"></div>
  <div class="bubble"></div>
  <div class="bubble"></div>
  <div class="bubble"></div>
  <div class="bubble"></div>
  <div class="bubble"></div>
  <div class="bubble"></div>
  <div class="bubble"></div>
  <div class="bubble"></div>
</div>
<div class="student-panel">
  <header class="student-menu">
    <div class="logo" onclick="window.history.back()" title="Volver">
      <img src="/AprendePlus/frontend/assets/img/APRENDEMASLOGO.png" alt="Logo Aprende+" style="width: 50px; height: auto;">
      <span>Aprende+</span>
    </div>
    <nav>
      <a href="/AprendePlus/dashboard/student/courses.php" class="menu-item active"><i class="fas fa-book-open"></i><span>Mis Cursos</span></a>
      <a href="/AprendePlus/dashboard/student/progress.php" class="menu-item"><i class="fas fa-chart-bar"></i><span>Mi Progreso</span></a>
      <a href="/AprendePlus/dashboard/student/certificates.php" class="menu-item"><i class="fas fa-medal"></i><span>Certificados</span></a>
    </nav>
  </header>
  <main class="student-content">
    <div class="dashboard-bubble">
      <div class="welcome-message">
        <h1>¡Bienvenido, <?= htmlspecialchars($username) ?>!</h1>
        <p>Este es tu panel de estudiante. Aquí puedes ver tus cursos, tu progreso y descargar tus certificados.</p>
      </div>
      <div class="stats">
        <div class="stat-card">
          <h2><?= $total_cursos ?></h2>
          <span>Cursos inscritos</span>
        </div>
        <div class="stat-card">
          <h2><?= $cursos_completados ?></h2>
          <span>Cursos completados</span>
        </div>
        <div class="stat-card">
          <h2><?= $promedio_progreso ?>%</h2>
          <span>Progreso promedio</span>
        </div>
      </div>
      <div class="quick-links">
        <a href="/AprendePlus/dashboard/student/courses.php" class="quick-link"><i class="fas fa-book"></i> Mis Cursos</a>
        <a href="/AprendePlus/dashboard/student/progress.php" class="quick-link"><i class="fas fa-chart-line"></i> Mi Progreso</a>
        <a href="/AprendePlus/dashboard/student/certificates.php" class="quick-link"><i class="fas fa-certificate"></i> Certificados</a>
      </div>
    </div>
  </main>
</div>
<script>
// JS para menú desplegable en mobile
const menuNav = document.querySelector('.student-menu nav');
const menuToggle = document.createElement('button');
menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
menuToggle.className = 'menu-toggle';
menuToggle.setAttribute('aria-label', 'Menú de navegación');
menuToggle.setAttribute('type', 'button');
menuToggle.style.display = 'none';
menuToggle.style.background = 'none';
menuToggle.style.border = 'none';
menuToggle.style.fontSize = '1.7rem';
menuToggle.style.marginLeft = '1rem';
menuToggle.style.cursor = 'pointer';
document.querySelector('.student-menu').insertBefore(menuToggle, menuNav);
function toggleMenu() {
  menuNav.style.display = menuNav.style.display === 'flex' ? 'none' : 'flex';
}
menuToggle.addEventListener('click', toggleMenu);
function handleResize() {
  if(window.innerWidth <= 900) {
    menuToggle.style.display = 'block';
    menuNav.style.display = 'none';
  } else {
    menuToggle.style.display = 'none';
    menuNav.style.display = 'flex';
  }
}
window.addEventListener('resize', handleResize);
document.addEventListener('DOMContentLoaded', handleResize);
</script>
</body>
</html>
