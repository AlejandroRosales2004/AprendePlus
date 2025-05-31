// Toggle sidebar en móviles
document.addEventListener('DOMContentLoaded', function() {
    // Verificar si el elemento existe antes de intentar usarlo
    const dashboardContent = document.querySelector('.dashboard-content');
    if (dashboardContent) {
        const sidebarToggle = document.createElement('button');
        sidebarToggle.className = 'sidebar-toggle btn btn-primary d-md-none';
        sidebarToggle.innerHTML = '<i class="fas fa-bars"></i>';
        dashboardContent.prepend(sidebarToggle);

        sidebarToggle.addEventListener('click', function() {
            document.querySelector('.dashboard-sidebar').classList.toggle('active');
        });

        // Cerrar sidebar al hacer clic fuera en móviles
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 768 && 
                !e.target.closest('.dashboard-sidebar') && 
                !e.target.closest('.sidebar-toggle') &&
                document.querySelector('.dashboard-sidebar').classList.contains('active')) {
                document.querySelector('.dashboard-sidebar').classList.remove('active');
            }
        });
    }
});