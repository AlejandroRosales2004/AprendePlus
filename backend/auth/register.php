<?php
// Permitir CORS para localhost y Live Server
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if ($origin === "http://localhost" || $origin === "http://127.0.0.1:5500") {
    header("Access-Control-Allow-Origin: $origin");
} else {
    header("Access-Control-Allow-Origin: http://localhost");
}
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../db/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    $username = trim($data['name'] ?? '');
    $email = trim($data['email'] ?? '');
    $password = trim($data['password'] ?? '');

    if (empty($username) || empty($email) || empty($password)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'El correo electrónico no es válido.']);
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    try {
        $checkStmt = $conn->prepare('SELECT id FROM usuarios WHERE email = ?');
        $checkStmt->execute([$email]);
        if ($checkStmt->rowCount() > 0) {
            http_response_code(409);
            echo json_encode(['success' => false, 'message' => 'El usuario ya existe.']);
            exit;
        }

        $stmt = $conn->prepare('INSERT INTO usuarios (username, email, password) VALUES (?, ?, ?)');
        $stmt->execute([$username, $email, $hashedPassword]);

        http_response_code(201);
        echo json_encode(['success' => true, 'message' => 'Usuario registrado exitosamente.']);
    } catch (PDOException $e) {
        error_log("Error en registro: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Error al registrar el usuario.', 'error' => 'Error interno del servidor.']);
    }
    exit;
}
?>