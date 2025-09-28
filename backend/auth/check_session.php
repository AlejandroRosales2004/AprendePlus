<?php
session_start();
header('Content-Type: application/json');

$response = [
    'logged_in' => false,
    'user' => null
];

if (isset($_SESSION['user']) && is_array($_SESSION['user'])) {
    $response['logged_in'] = true;
    $response['user'] = $_SESSION['user'];
}

if (ob_get_length()) ob_end_clean();
echo json_encode($response);
exit;
