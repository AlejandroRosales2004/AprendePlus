<?php
header('Content-Type: application/json');

// Permitir acceso desde localhost y Live Server para pruebas locales
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if ($origin === "http://localhost" || $origin === "http://127.0.0.1:5500") {
    header("Access-Control-Allow-Origin: $origin");
} else {
    header("Access-Control-Allow-Origin: http://localhost");
}
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once __DIR__ . '/../db/db.php';

$response = [
    'success' => false,
    'message' => '',
    'error' => ''
];

// Limpia cualquier salida previa antes del JSON
if (ob_get_length()) ob_end_clean();

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    if (ob_get_length()) ob_end_clean();
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

try {
    // Permitir recibir datos tanto por JSON como por x-www-form-urlencoded
    $data = [];
    if (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        if (!is_array($data)) {
            $data = $_POST;
        }
    } else {
        $data = $_POST;
    }

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
    // Guardar toda la información relevante en la sesión para compatibilidad con todos los scripts
    $_SESSION['user'] = [
        'id' => $user['id'],
        'username' => $user['username'],
        'role' => $user['role'],
        'email' => $user['email']
    ];
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['username'] = $user['username'];

    $response = [
        'success' => true,
        'message' => 'Inicio de sesión exitoso',
        'user' => [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role'],
            'email' => $user['email']
        ]
    ];

    if (ob_get_length()) ob_end_clean();
    echo json_encode($response);
    exit;
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
    http_response_code(401);
    if (ob_get_length()) ob_end_clean();
    echo json_encode($response);
    exit;
}
?>
