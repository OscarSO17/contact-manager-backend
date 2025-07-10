<?php
/**
 * DAO para operaciones CRUD sobre la tabla de usuarios
 * Maneja todas las interacciones con la tabla "users".
 */
require_once __DIR__ . '/../model/User.php';

class UserDAO {
    private $connection; 

    /**
     * Constructor: inyecta la conexión PDO.
     *
     * @param PDO $connection
     */
    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }

    /**
     * Registra un nuevo usuario en la base de datos.
     *
     * @param User $user Objeto User con los datos del usuario.
     * @return int ID del usuario insertado.
     * @throws Exception Si ocurre un error de base de datos.
     */
    public function registerUser(User $user) {
        try {
            $stmt = $this->connection->prepare(
                "INSERT INTO users (username, password_hash) VALUES (?, ?)"
            );
            $stmt->execute([
                $user->getUsername(),
                $user->getPasswordHash()
            ]);
            return $this->connection->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error en registerUser: " . $e->getMessage());
            throw new Exception("❌ Error al registrar el usuario. Inténtelo más tarde.");
        }
    }

    /**
     * Obtiene un usuario por nombre de usuario.
     * NO verifica contraseña (eso se hace en el controlador).
     *
     * @param string $username
     * @return User|null
     * @throws Exception Si ocurre un error de base de datos.
     */
    public function getUserByUsername($username) {
        try {
            $stmt = $this->connection->prepare(
                "SELECT * FROM users WHERE username = ?"
            );
            $stmt->execute([$username]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return new User($row['id'], $row['username'], $row['password_hash']);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            error_log("Error en getUserByUsername: " . $e->getMessage());
            throw new Exception("❌ Error al buscar usuario. Inténtelo más tarde.");
        }
    }

    /**
     * Verifica si un nombre de usuario ya existe.
     *
     * @param string $username
     * @return bool
     */
    public function existsByUsername($username) {
        $stmt = $this->connection->prepare(
            "SELECT 1 FROM users WHERE username = ?"
        );
        $stmt->execute([$username]);
        return $stmt->fetchColumn() !== false;
    }

    /**
     * Obtiene un usuario por su ID.
     *
     * @param int $id
     * @return User|null
     */
    public function getUserById($id) {
        $stmt = $this->connection->prepare(
            "SELECT * FROM users WHERE id = ?"
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new User($row['id'], $row['username'], $row['password_hash']);
        } else {
            return null;
        }
    }
}
