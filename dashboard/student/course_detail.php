<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /AprendePlus/frontend/login.html');
    exit;
}
require_once __DIR__ . '/../../backend/db/db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id = $_SESSION['user_id'];

// Obtener datos del curso
$stmt = $conn->prepare('SELECT id, titulo, descripcion FROM cursos WHERE id = ?');
$stmt->bindValue(1, $id, PDO::PARAM_INT);
$stmt->execute();
$curso = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = null;
if (!$curso) {
    echo '<h2>Curso no encontrado</h2>';
    exit;
}

// Obtener progreso del usuario en este curso
$stmt = $conn->prepare('SELECT IFNULL(porcentaje_completado,0) as progreso, IFNULL(ultima_actualizacion,NOW()) as ultima_actualizacion FROM progreso WHERE usuario_id = ? AND curso_id = ?');
$stmt->bindValue(1, $user_id, PDO::PARAM_INT);
$stmt->bindValue(2, $id, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$progreso = $row ? round((float)$row['progreso'],2) : 0;
$ultima_actualizacion = $row ? $row['ultima_actualizacion'] : '';
$tiene_certificado = $progreso >= 100;
$stmt = null;

// Obtener lecciones (si existe tabla lecciones)
$lecciones = [];
$q = $conn->query("SHOW TABLES LIKE 'lecciones'");
if ($q && $q->rowCount()) {
    $stmt = $conn->prepare('SELECT id, titulo FROM lecciones WHERE curso_id = ?');
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();
    $lecciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt = null;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($curso['titulo']) ?> | Aprende+</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --verde-suave: #a8e6cf;
            --azul-claro: #dcedc1;
            --azul-oscuro: #64b5f6;
            --blanco: #ffffff;
            --sombra: 0 10px 20px rgba(0,0,0,0.1);
        }
        body {
            background: linear-gradient(135deg, var(--verde-suave), var(--azul-claro));
            min-height: 100vh;
            color: #333;
            font-family: 'Poppins', sans-serif;
            margin: 0;
        }
        .course-detail-container {
            max-width: 700px;
            margin: 3rem auto;
            background: var(--blanco);
            border-radius: 15px;
            box-shadow: var(--sombra);
            padding: 2.5rem 2rem;
        }
        h1 {
            color: var(--azul-oscuro);
            margin-bottom: 1rem;
            font-size: 2rem;
        }
        .descripcion {
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
        }
        .contenido {
            margin-bottom: 2rem;
        }
        .progreso {
            margin-bottom: 1.5rem;
        }
        .progress-bar {
            background: #f0f0f0;
            border-radius: 10px;
            overflow: hidden;
            height: 16px;
            margin-bottom: 0.5rem;
        }
        .progress-bar-inner {
            background: var(--azul-oscuro);
            height: 100%;
            width: 0%;
            transition: width 0.3s;
        }
        .certificado {
            background: #e8f5e9;
            color: #388e3c;
            border-left: 4px solid #388e3c;
            padding: 10px 14px;
            border-radius: 4px;
            font-size: 1rem;
            margin-bottom: 1rem;
        }
        @media (max-width: 600px) {
            .course-detail-container {
                padding: 1rem 0.3rem;
            }
            h1 {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>
    <div class="course-detail-container">
        <h1><i class="fas fa-book"></i> <?= htmlspecialchars($curso['titulo']) ?></h1>
        <div class="descripcion">
            <strong>Descripción:</strong> <?= htmlspecialchars($curso['descripcion']) ?>
        </div>
        <div class="contenido">
            <strong>Contenido del Curso:</strong>
            <div style="margin-top:0.5rem;">
                <?= nl2br(htmlspecialchars($curso['contenido'])) ?>
            </div>
        </div>
        <div class="progreso">
            <strong>Progreso del Curso:</strong>
            <div class="progress-bar">
                <div class="progress-bar-inner" style="width: <?= $progreso ?>%"></div>
            </div>
            <span><?= $progreso ?>% completado</span>
            <?php if ($ultima_actualizacion): ?>
                <br><span style="font-size:0.95em;color:#888;">Última actualización: <?= date('d M Y H:i', strtotime($ultima_actualizacion)) ?></span>
            <?php endif; ?>
        </div>
        <?php if ($tiene_certificado): ?>
            <div class="certificado">
                <i class="fas fa-certificate"></i> ¡Felicidades! Has completado el curso y puedes descargar tu certificado.
            </div>
        <?php endif; ?>
        <?php if (!empty($lecciones)): ?>
        <div class="lecciones">
            <strong>Lecciones:</strong>
            <ul>
                <?php foreach ($lecciones as $l): ?>
                    <li><?= htmlspecialchars($l['titulo']) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        <a href="/AprendePlus/dashboard/student/courses.php" style="display:inline-block;margin-top:1rem;color:var(--azul-oscuro);text-decoration:none;font-weight:600;">&larr; Volver a mis cursos</a>
    </div>
</body>
</html>
