-- -----------------------------------------------------
-- Base de Datos: contact_manager
-- -----------------------------------------------------

-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS contact_manager;
USE contact_manager;

-- -----------------------------------------------------
-- Tabla: users
-- Descripción: Almacena usuarios registrados del sistema
-- Campos:
--   id            - Identificador único autoincremental
--   username      - Nombre de usuario único
--   password_hash - Contraseña hasheada de forma segura
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);

-- -----------------------------------------------------
-- Tabla: contacts
-- Descripción: Almacena la información de los contactos
-- Asociados a un usuario específico
-- Campos:
--   id       - Identificador único autoincremental
--   user_id  - Referencia al usuario dueño del contacto
--   name     - Nombre del contacto (obligatorio)
--   email    - Correo electrónico del contacto
--   phone    - Teléfono del contacto
--   notes    - Notas adicionales
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150),
    phone VARCHAR(30),
    notes VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);