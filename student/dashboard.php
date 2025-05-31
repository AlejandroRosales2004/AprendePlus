<?php
// dashboard.php for students
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Aprende+</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        /* Estilos adicionales para la nueva navegación */
        .sidebar {
            width: 250px;
            background: #2c3e50;
            color: white;
            position: fixed;
            height: 100vh;
            padding: 20px 0;
            transition: all 0.3s;
            z-index: 1000;
        }
        
        .sidebar.collapsed {
            width: 80px;
        }
        
        .sidebar-header {
            padding: 0 20px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .sidebar-menu {
            padding: 0;
            list-style: none;
        }
        
        .sidebar-menu li {
            padding: 10px 20px;
            border-left: 3px solid transparent;
            transition: all 0.3s;
        }
        
        .sidebar-menu li:hover {
            background: #34495e;
            border-left: 3px solid #3498db;
        }
        
        .sidebar-menu li.active {
            background: #34495e;
            border-left: 3px solid #3498db;
        }
        
        .sidebar-menu a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        
        .sidebar-menu i {
            margin-right: 15px;
            font-size: 1.2rem;
            min-width: 25px;
        }
        
        .sidebar-menu span {
            transition: opacity 0.3s;
        }
        
        .sidebar.collapsed .sidebar-menu span {
            opacity: 0;
            width: 0;
            display: none;
        }
        
        .sidebar.collapsed .sidebar-menu i {
            margin-right: 0;
            font-size: 1.5rem;
        }
        
        .main-content {
            margin-left: 250px;
            transition: all 0.3s;
        }
        
        .sidebar.collapsed + .main-content {
            margin-left: 80px;
        }
        
        .toggle-sidebar {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-top: auto;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }
        
        .user-info {
            transition: opacity 0.3s;
        }
        
        .sidebar.collapsed .user-info {
            opacity: 0;
            width: 0;
            display: none;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 80px;
            }
            
            .sidebar .sidebar-menu span {
                display: none;
            }
            
            .main-content {
                margin-left: 80px;
            }
        }
    </style>
</head>
<body class="dashboard-student">
    <!-- Barra lateral de navegación -->
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="../assets/img/APRENDEMASLOGO.png" alt="Logo Aprende+" style="width: 40px; height: 40px;">
            <button class="toggle-sidebar"><i class="fas fa-bars"></i></button>
        </div>
        
        <ul class="sidebar-menu">
            <li class="active">
                <a href="#">
                    <i class="fas fa-home"></i>
                    <span>Inicio</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-book-open"></i>
                    <span>Mis Cursos</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-tasks"></i>
                    <span>Progreso</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-certificate"></i>
                    <span>Certificados</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Calendario</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-comments"></i>
                    <span>Mensajes</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-cog"></i>
                    <span>Ajustes</span>
                </a>
            </li>
        </ul>
        
        <div class="user-profile">
            <img src="../assets/img/default-avatar.png" alt="Usuario" class="user-avatar">
            <div class="user-info">
                <strong>Estudiante</strong>
                <small>usuario@ejemplo.com</small>
            </div>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="main-content">
        <header class="dashboard-header">
            <div class="header-actions">
                <h1>Bienvenido, Estudiante</h1>
                <div class="search-bar">
                    <input type="text" placeholder="Buscar cursos...">
                    <button><i class="fas fa-search"></i></button>
                </div>
                <div class="notifications">
                    <button><i class="fas fa-bell"></i></button>
                    <span class="badge">3</span>
                </div>
            </div>
        </header>

        <main class="dashboard-content">
            <section class="welcome-message">
                <h2>Mis Cursos en Progreso</h2>
                <p>Continúa donde lo dejaste o explora nuevos cursos.</p>
            </section>

            <section class="courses-grid">
                <div class="course-card">
                    <img src="../assets/img/course1.jpg" alt="Curso 1">
                    <div class="course-info">
                        <h3>Curso de Programación</h3>
                        <p>Aprende los fundamentos de la programación.</p>
                        <div class="progress-container">
                            <div class="progress-info">
                                <span>Progreso: 50%</span>
                                <span>Lección 5/10</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" style="width: 50%;"></div>
                            </div>
                        </div>
                        <div class="course-actions">
                            <a href="#" class="btn-continue">Continuar</a>
                            <a href="#" class="btn-details"><i class="fas fa-info-circle"></i></a>
                        </div>
                    </div>
                </div>

                <div class="course-card">
                    <img src="../assets/img/course2.jpg" alt="Curso 2">
                    <div class="course-info">
                        <h3>Curso de Diseño</h3>
                        <p>Domina las herramientas de diseño gráfico.</p>
                        <div class="progress-container">
                            <div class="progress-info">
                                <span>Progreso: 75%</span>
                                <span>Lección 8/10</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" style="width: 75%;"></div>
                            </div>
                        </div>
                        <div class="course-actions">
                            <a href="#" class="btn-continue">Continuar</a>
                            <a href="#" class="btn-details"><i class="fas fa-info-circle"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="course-card add-course">
                    <div class="add-course-content">
                        <i class="fas fa-plus-circle"></i>
                        <h3>Explorar nuevos cursos</h3>
                    </div>
                </div>
            </section>
            
            <section class="quick-access">
                <h2>Acceso Rápido</h2>
                <div class="quick-links">
                    <a href="#" class="quick-link">
                        <i class="fas fa-book"></i>
                        <span>Biblioteca</span>
                    </a>
                    <a href="#" class="quick-link">
                        <i class="fas fa-question-circle"></i>
                        <span>Soporte</span>
                    </a>
                    <a href="#" class="quick-link">
                        <i class="fas fa-chart-line"></i>
                        <span>Estadísticas</span>
                    </a>
                    <a href="#" class="quick-link">
                        <i class="fas fa-users"></i>
                        <span>Comunidad</span>
                    </a>
                </div>
            </section>
        </main>

        <footer>
            <p>&copy; 2025 Aprende+. Todos los derechos reservados.</p>
        </footer>
    </div>

    <script>
        // Toggle sidebar
        document.querySelector('.toggle-sidebar').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('collapsed');
        });
        
        // Simular notificaciones
        document.querySelector('.notifications button').addEventListener('click', function() {
            alert('Tienes 3 notificaciones nuevas');
            document.querySelector('.notifications .badge').style.display = 'none';
        });
    </script>
</body>
</html>