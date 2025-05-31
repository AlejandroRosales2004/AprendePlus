// dashboard/assets/js/admin_session.js
// Checks if admin session is active, redirects to login if not
function checkAdminSession() {
    fetch('../../backend/auth/check_admin_session.php')
        .then(response => response.json())
        .then(data => {
            if (!data.logged_in || !data.is_admin) {
                window.location.href = '../../frontend/login.html';
            } else {
                // Show logout button if present
                const logoutBtn = document.getElementById('logoutBtn');
                if (logoutBtn) logoutBtn.style.display = 'inline-block';
            }
        })
        .catch(() => {
            window.location.href = '../../frontend/login.html';
        });
}

document.addEventListener('DOMContentLoaded', checkAdminSession);
