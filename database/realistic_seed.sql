-- Datos realistas para Aprende+

-- Usuarios
INSERT INTO usuarios (username, email, password, nombre_completo, created_at, role, avatar) VALUES
('ximena', 'ximena@example.com', '$2y$10$80QTGO1F.xp3ucmKWvFd5eVbcG74UHULHfvJ0w/ck4SZTWVBSH/m6', 'Ximena López', '2025-08-01 09:00:00', 'student', 'ximena.png'),
('alejandro', 'alejandro.rosales@example.com', '$2y$10$G32DI0D7f3cINAQ1u5u89uf.9umarrHPmazvLZYjj0p51MVLfQGZm', 'Alejandro Rosales', '2025-08-01 09:10:00', 'admin', 'alejandro.png'),
('maria', 'maria.garcia@example.com', '$2y$10$QWERTYUIOPLKJHGFDSAZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm', 'María García', '2025-08-01 09:20:00', 'student', 'maria.png'),
('juan', 'juan.perez@example.com', '$2y$10$asdfghjklqwertyuiopzxcvbnm1234567890ASDFGHJKLQWERTYUIOPZXCVBNM', 'Juan Pérez', '2025-08-01 09:30:00', 'instructor', 'juan.png'),
('sofia', 'sofia.martinez@example.com', '$2y$10$zxcvbnmasdfghjklqwertyuiop1234567890ZXCVBNMASDFGHJKLQWERTYUIOP', 'Sofía Martínez', '2025-08-01 09:40:00', 'student', 'sofia.png');

-- Cursos
INSERT INTO cursos (titulo, descripcion, instructor_id, creado_en, imagen_portada, categoria, estado, nivel, duracion, requisitos) VALUES
('Matemáticas Básicas', 'Curso introductorio a las matemáticas para estudiantes de secundaria.', 4, '2025-08-01 10:00:00', 'matematicas.jpg', 'Matemáticas', 'publicado', 'Básico', '20 horas', 'Ninguno'),
('Programación en Python', 'Aprende a programar desde cero con Python, uno de los lenguajes más populares.', 4, '2025-08-01 10:30:00', 'python.jpg', 'Tecnología', 'publicado', 'Intermedio', '30 horas', 'Conocimientos básicos de computación'),
('Historia Universal', 'Explora los eventos más importantes de la historia mundial.', 4, '2025-08-01 11:00:00', 'historia.jpg', 'Humanidades', 'publicado', 'Básico', '15 horas', 'Interés en historia');

-- Lecciones
INSERT INTO lecciones (curso_id, titulo, contenido, orden) VALUES
(1, 'Números y Operaciones', 'Introducción a los números naturales, enteros y operaciones básicas.', 1),
(1, 'Fracciones y Decimales', 'Conceptos y ejercicios sobre fracciones y decimales.', 2),
(2, 'Variables y Tipos de Datos', 'Cómo declarar variables y usar tipos de datos en Python.', 1),
(2, 'Estructuras de Control', 'Condicionales y bucles en Python.', 2),
(3, 'Antigüedad', 'Civilizaciones antiguas y sus aportes.', 1),
(3, 'Edad Media', 'Principales eventos y personajes de la Edad Media.', 2);

-- Inscripciones
INSERT INTO inscripciones (usuario_id, curso_id, fecha_inscripcion, porcentaje_completado) VALUES
(1, 1, '2025-08-02 08:00:00', 100.00),
(3, 2, '2025-08-02 08:10:00', 60.00),
(5, 3, '2025-08-02 08:20:00', 80.00);

-- Progreso
INSERT INTO progreso (usuario_id, curso_id, porcentaje_completado, ultima_actualizacion) VALUES
(1, 1, 100.00, '2025-08-10 12:00:00'),
(3, 2, 60.00, '2025-08-10 12:10:00'),
(5, 3, 80.00, '2025-08-10 12:20:00');

-- Certificados
INSERT INTO certificados (usuario_id, curso_id, fecha_emision) VALUES
(1, 1, '2025-08-15 09:00:00'),
(5, 3, '2025-08-15 09:10:00');
