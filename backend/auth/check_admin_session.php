<?php
// backend/auth/check_admin_session.php
session_start();
header('Content-Type: application/json');
$response = ['logged_in' => false, 'is_admin' => false];
if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    $response['logged_in'] = true;
    $response['is_admin'] = true;
}
echo json_encode($response);
