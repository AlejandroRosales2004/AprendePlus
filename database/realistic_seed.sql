-- CREAR BASE DE DATOS
CREATE DATABASE IF NOT EXISTS aprendeplus;
USE aprendeplus;

-- CREAR TABLA USUARIOS
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nombre_completo VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    role ENUM('student', 'instructor', 'admin') DEFAULT 'student',
    avatar VARCHAR(255) DEFAULT 'default.png'
);

-- CREAR TABLA CURSOS
CREATE TABLE cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    instructor_id INT NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    imagen_portada VARCHAR(255),
    categoria VARCHAR(50),
    estado ENUM('borrador', 'publicado', 'archivado') DEFAULT 'borrador',
    nivel VARCHAR(30),
    duracion VARCHAR(30),
    requisitos TEXT,
    FOREIGN KEY (instructor_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- CREAR TABLA LECCIONES
CREATE TABLE lecciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    curso_id INT NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    contenido TEXT NOT NULL,
    orden INT DEFAULT 1,
    FOREIGN KEY (curso_id) REFERENCES cursos(id) ON DELETE CASCADE
);

-- CREAR TABLA INSCRIPCIONES
CREATE TABLE inscripciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    curso_id INT NOT NULL,
    fecha_inscripcion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    porcentaje_completado DECIMAL(5,2) DEFAULT 0.00,
    ultima_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (curso_id) REFERENCES cursos(id) ON DELETE CASCADE
);

-- CREAR TABLA PROGRESO
CREATE TABLE progreso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    curso_id INT NOT NULL,
    porcentaje_completado DECIMAL(5,2) DEFAULT 0.00,
    ultima_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (curso_id) REFERENCES cursos(id) ON DELETE CASCADE
);

-- CREAR TABLA CERTIFICADOS
CREATE TABLE certificados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    curso_id INT NOT NULL,
    fecha_emision TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (curso_id) REFERENCES cursos(id) ON DELETE CASCADE
);

-- =============================================
-- INSERTAR DATOS REALES
-- =============================================

-- USUARIOS
INSERT INTO usuarios (username, email, password, nombre_completo, role) VALUES
('admin', 'admin@aprendeplus.com', '$2y$10$G32DI0D7f3cINAQ1u5u89uf.9umarrHPmazvLZYjj0p51MVLfQGZm', 'Administrador Principal', 'admin'),
('maria.gonzalez', 'maria.gonzalez@aprendeplus.com', '$2y$10$G32DI0D7f3cINAQ1u5u89uf.9umarrHPmazvLZYjj0p51MVLfQGZm', 'María González', 'instructor'),
('carlos.rodriguez', 'carlos.rodriguez@aprendeplus.com', '$2y$10$G32DI0D7f3cINAQ1u5u89uf.9umarrHPmazvLZYjj0p51MVLfQGZm', 'Carlos Rodríguez', 'instructor'),
('ana.lopez', 'ana.lopez@estudiante.com', '$2y$10$G32DI0D7f3cINAQ1u5u89uf.9umarrHPmazvLZYjj0p51MVLfQGZm', 'Ana López', 'student'),
('david.garcia', 'david.garcia@estudiante.com', '$2y$10$G32DI0D7f3cINAQ1u5u89uf.9umarrHPmazvLZYjj0p51MVLfQGZm', 'David García', 'student');

-- CURSOS
INSERT INTO cursos (titulo, descripcion, instructor_id, categoria, estado, nivel, duracion, requisitos) VALUES
('Desarrollo Web con HTML5, CSS3 y JavaScript', 'Aprende a crear sitios web modernos y responsivos desde cero. Domina las tecnologías fundamentales del desarrollo frontend.', 2, 'Programación', 'publicado', 'Principiante', '40 horas', 'Conocimientos básicos de computación'),
('Python para Ciencia de Datos', 'Domina Python, Pandas, NumPy y Matplotlib para análisis de datos. Ideal para aspirantes a Data Scientist.', 2, 'Ciencia de Datos', 'publicado', 'Intermedio', '50 horas', 'Conocimientos básicos de programación'),
('Marketing Digital', 'Estrategias efectivas de marketing digital, SEO y redes sociales para empresas.', 3, 'Marketing', 'publicado', 'Principiante', '30 horas', 'Ninguno');

-- LECCIONES
INSERT INTO lecciones (curso_id, titulo, contenido, orden) VALUES
(1, 'Introducción a HTML5', '<h2>Fundamentos de HTML5</h2><p>Aprende la estructura básica de una página web.</p>', 1),
(1, 'Etiquetas Semánticas', '<h2>HTML5 Semántico</h2><p>Mejora la accesibilidad y SEO con etiquetas semánticas.</p>', 2),
(2, 'Fundamentos de Python', '<h2>Python Básico</h2><p>Variables, tipos de datos y estructuras de control.</p>', 1);

-- INSCRIPCIONES
INSERT INTO inscripciones (usuario_id, curso_id, porcentaje_completado) VALUES
(4, 1, 75.00),
(5, 1, 100.00),
(4, 2, 25.00);

-- PROGRESO
INSERT INTO progreso (usuario_id, curso_id, porcentaje_completado) VALUES
(4, 1, 75.00),
(5, 1, 100.00),
(4, 2, 25.00);

-- CERTIFICADOS
INSERT INTO certificados (usuario_id, curso_id) VALUES
(5, 1);