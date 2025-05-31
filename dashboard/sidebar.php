<aside class="dashboard-sidebar">
    <div class="sidebar-header">
        <img src="../../frontend/assets/img/APRENDEMASLOGO.png" alt="Logo" class="sidebar-logo" style="width: 80px; height: auto;">
        <h3>Aprende+</h3>
    </div>
    
    <nav class="sidebar-nav">
        <?php if ($role === 'student'): ?>
            <a href="?view=courses" class="<?= (!isset($_GET['view']) || $_GET['view'] === 'courses') ? 'active' : '' ?>">
                <i class="fas fa-book"></i> Mis Cursos
            </a>
            <a href="?view=progress" class="<?= isset($_GET['view']) && $_GET['view'] === 'progress' ? 'active' : '' ?>">
                <i class="fas fa-chart-line"></i> Mi Progreso
            </a>
            <a href="?view=certificates" class="<?= isset($_GET['view']) && $_GET['view'] === 'certificates' ? 'active' : '' ?>">
                <i class="fas fa-certificate"></i> Certificados
            </a>
            
                    
        <?php elseif ($role === 'admin'): ?>
            <a href="?view=users" class="<?= (!isset($_GET['view']) || $_GET['view'] === 'users') ? 'active' : '' ?>">
                <i class="fas fa-users"></i> Usuarios
            </a>
            <a href="?view=all_courses" class="<?= isset($_GET['view']) && $_GET['view'] === 'all_courses' ? 'active' : '' ?>">
                <i class="fas fa-book"></i> Todos los Cursos
            </a>
            <a href="?view=settings" class="<?= isset($_GET['view']) && $_GET['view'] === 'settings' ? 'active' : '' ?>">
                <i class="fas fa-cog"></i> Configuración
            </a>
        <?php endif; ?>
    </nav>
    
    <div class="sidebar-footer">
        <div class="user-profile">
            <img src="<?= !empty($user['avatar']) ? $user['avatar'] : 'assets/img/default-avatar.png' ?>" alt="User Avatar">
            <span><?= htmlspecialchars($user['username']) ?></span>
        </div>
        <a href="../backend/logout.php" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
        </a>
    </div>
</aside>