-- -----------------------------------------------------
-- Base de Datos: contact_manager
-- -----------------------------------------------------

-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS contact_manager;
USE contact_manager;

-- -----------------------------------------------------
-- Tabla: contacts
-- Descripción: Almacena la información de los contactos
-- Campos:
--   id     - Identificador único autoincremental
--   name   - Nombre del contacto (obligatorio)
--   email  - Correo electrónico del contacto
--   phone  - Teléfono del contacto
--   notes  - Notas adicionales
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150),
    phone VARCHAR(30),
    notes VARCHAR(255)
);