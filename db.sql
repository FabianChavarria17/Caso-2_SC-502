-- Base de datos: Caso de Estudio #2
CREATE DATABASE IF NOT EXISTS caso2;
USE caso2;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    rol ENUM('usuario','admin') NOT NULL DEFAULT 'usuario'
);

CREATE TABLE talleres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    cupo INT NOT NULL DEFAULT 0
);

CREATE TABLE solicitudes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    taller_id INT NOT NULL,
    estado ENUM('pendiente','aprobada','rechazada') NOT NULL DEFAULT 'pendiente',
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (taller_id) REFERENCES talleres(id)
);

-- Usuarios de prueba (password para ambos: 1234)
INSERT INTO usuarios (nombre, correo, contrasena, rol) VALUES
('Administrador', 'admin@correo.com','admin','admin'),
('Usuario Demo', 'user@correo.com', 'pass', 'usuario');

INSERT INTO talleres (nombre, cupo) VALUES
('Angular', 3),
('PHP', 2),
('Laravel', 1);