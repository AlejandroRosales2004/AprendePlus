<?php
// Simulación de cursos completados con certificado
$courses = [
    ["id" => 2, "titulo" => "Introducción a Python", "progreso" => 100],
];
require_once __DIR__ . '/../includes/bubble_background.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificados | Aprende+</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/AprendePlus/assets/css/bubble-background.css">
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
        background: transparent;
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
      h1 {
        color: var(--primary);
        text-align: left;
        margin-bottom: 2.2rem;
        font-size: 2.3rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        text-shadow: 0 2px 12px rgba(84,160,255,0.08);
        display: flex;
        align-items: center;
        gap: 0.7rem;
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
      .certificates-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 2.2rem;
        width: 100%;
      }
      .certificate-card {
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding: 2.1rem 1.3rem 1.3rem 1.3rem;
        text-align: left;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        transition: box-shadow 0.18s, transform 0.18s;
        position: relative;
        min-height: 120px;
      }
      .certificate-card:hover {
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.13);
        transform: translateY(-4px) scale(1.02);
      }
      .certificate-card h3 {
        font-size: 1.18rem;
        margin-bottom: 0.7rem;
        color: var(--secondary);
        font-weight: 700;
      }
      .certificate-card span {
        font-size: 1.01rem;
        color: var(--muted);
        font-weight: 500;
      }
      .btn-descargar {
        display: inline-block;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        color: var(--white);
        padding: 0.5rem 1.3rem;
        border-radius: 22px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.22s;
        margin-top: 1.1rem;
        border: none;
        cursor: pointer;
        font-size: 1.01rem;
        box-shadow: 0 2px 8px rgba(84,160,255,0.08);
      }
      .btn-descargar:hover {
        background: linear-gradient(90deg, var(--secondary), var(--primary));
        color: var(--white);
        transform: scale(1.06) translateY(-2px);
        box-shadow: 0 6px 24px rgba(84,160,255,0.13);
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
        .certificates-grid { grid-template-columns: 1fr; gap: 1.5rem; }
        .student-menu { flex-direction: column; align-items: flex-start; padding: 0.7rem 1rem; }
        .student-menu nav { flex-direction: column; gap: 0.5rem; width: 100%; }
        .student-menu .logo { margin-bottom: 0.7rem; }
      }
      @media (max-width: 700px) {
        .student-content { padding: 0.5rem 0.1rem; }
        h1 { font-size: 1.3rem; }
        .certificate-card { padding: 1.1rem 0.7rem; min-height: 100px; }
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
        .certificates-grid { gap: 1.5rem; }
      }
    </style>
</head>
<body>
<?php renderBubbleBackground(); ?>
<div class="student-panel">
  <header class="student-menu">
    <div class="logo" onclick="window.history.back()" title="Volver">
      <img src="/AprendePlus/frontend/assets/img/APRENDEMASLOGO.png" alt="Logo Aprende+" style="width: 50px; height: auto;">
      <span>Aprende+</span>
    </div>
    <nav>
      <a href="/AprendePlus/dashboard/student/courses.php" class="menu-item"><i class="fas fa-book-open"></i><span>Mis Cursos</span></a>
      <a href="/AprendePlus/dashboard/student/progress.php" class="menu-item"><i class="fas fa-chart-bar"></i><span>Mi Progreso</span></a>
      <a href="/AprendePlus/dashboard/student/certificates.php" class="menu-item active"><i class="fas fa-medal"></i><span>Certificados</span></a>
    </nav>
  </header>
  <main class="student-content">
    <div class="dashboard-bubble">
      <h1><i class="fas fa-certificate"></i> Mis Certificados</h1>
      <?php if (empty($courses)): ?>
        <p>No tienes certificados disponibles aún.</p>
      <?php else: ?>
        <div class="certificates-grid">
        <?php foreach ($courses as $curso): ?>
        <div class="certificate-card">
          <h3><?= htmlspecialchars($curso['titulo']) ?></h3>
          <span>Curso completado al 100%</span>
          <a href="#" class="btn-descargar"><i class="fas fa-download"></i> Descargar</a>
        </div>
        <?php endforeach; ?>
        </div>
      <?php endif; ?>
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
