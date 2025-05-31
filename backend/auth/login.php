<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
require_once __DIR__ . '/../db/db.php';

$response = [
    'success' => false,
    'message' => '',
    'error' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

try {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (empty($data['email']) || empty($data['password'])) {
        throw new Exception('Email y contraseña son requeridos');
    }

    $stmt = $conn->prepare("SELECT id, username, email, password, role FROM usuarios WHERE email = ?");
    $stmt->execute([$data['email']]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        throw new Exception('Usuario no encontrado');
    }

    if (!isset($user['role'])) {
        throw new Exception('El rol del usuario no está definido');
    }

    if (!password_verify($data['password'], $user['password'])) {
        throw new Exception('Credenciales incorrectas');
    }

    session_start();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    $response = [
        'success' => true,
        'message' => 'Inicio de sesión exitoso',
        'user' => [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role']
        ]
    ];

    echo json_encode($response);
    exit;
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
    http_response_code(401);
    echo json_encode($response);
    exit;
}
?>
