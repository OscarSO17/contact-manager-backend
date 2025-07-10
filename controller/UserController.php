<?php
    require_once __DIR__ . '/../dao/UserDAO.php';
    require_once __DIR__ . '/../model/User.php';    
    require_once __DIR__ . '/../conf/database.php';

    /**
     * Controlador para gestionar operaciones sobre usuarios.
     * Incluye registro y login con manejo seguro de contraseñas.
     */
    class UserController {
        private $userDAO;

        /**
         * Constructor que inicializa el DAO de usuarios.
         * Utiliza la conexión a la base de datos configurada en Database.
         */
        public function __construct() {
            $connection = Database::getInstance()->getConnection();
            $this->userDAO = new UserDAO($connection);
        }

        /**
         * Registra un nuevo usuario.
         *
         * @param array $data Datos del usuario (username y password)
         * @return array Resultado de la operación
         */
        public function registerUser($data) {
            try {
                // Validación básica
                if (empty($data['username']) || empty($data['password'])) {
                    return [
                        'success' => false,
                        'message' => '⚠️ Nombre de usuario y contraseña son obligatorios.'
                    ];
                }

                // Verificar si el usuario ya existe
                if ($this->userDAO->existsByUsername($data['username'])) {
                    return [
                        'success' => false,
                        'message' => '⚠️ El nombre de usuario ya está en uso.'
                    ];
                }

                // Hashear la contraseña
                $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

                // Crear el objeto Usuario
                $user = new User(null, $data['username'], $hashedPassword);

                // Guardar en la base de datos
                $id = $this->userDAO->registerUser($user);

                return [
                    'success' => true,
                    'message' => '✅ Usuario registrado correctamente.',
                    'user_id' => $id
                ];
            } catch (Exception $e) {
                error_log("Error en registerUser: " . $e->getMessage());
                return [
                    'success' => false,
                    'message' => '❌ Error al registrar el usuario. Inténtelo más tarde.'
                ];
            }
        }

        /**
         * Inicia sesión de un usuario.
         *
         * @param array $data Datos del usuario (username y password)
         * @return array Resultado de la operación
         */
        public function login($data) {
            try {
                // Validación básica
                if (empty($data['username']) || empty($data['password'])) {
                    return [
                        'success' => false,
                        'message' => '⚠️ Nombre de usuario y contraseña son obligatorios.'
                    ];
                }

                // Buscar usuario en la base de datos
                $user = $this->userDAO->getUserByUsername($data['username']);

                if (!$user) {
                    return [
                        'success' => false,
                        'message' => '⚠️ Credenciales incorrectas.'
                    ];
                }

                // Verificar contraseña con hash
                if (password_verify($data['password'], $user->getPasswordHash())) {
                    return [
                        'success' => true,
                        'message' => '✅ Inicio de sesión exitoso.',
                        'user' => $user->toArray()
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => '⚠️ Credenciales incorrectas.'
                    ];
                }
            } catch (Exception $e) {
                error_log("Error en login: " . $e->getMessage());
                return [
                    'success' => false,
                    'message' => '❌ Error al iniciar sesión. Inténtelo más tarde.'
                ];
            }
        }
    }
