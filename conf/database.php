<?php
/**
 * Clase para gestionar la conexión a la base de datos usando el patrón Singleton.
 */
    class Database {
        private static $instance;
        private $connection;

        /**
         * Constructor: inicializa las variables de entorno desde .env
         */
        private function __construct() {
            $db_host = getenv('DB_HOST');
            $db_port = getenv('DB_PORT');
            $db_name = getenv('DB_NAME');
            $db_user = getenv('DB_USER');
            $db_password = getenv('DB_PASSWORD');

            try {
                $this->connection = new PDO(
                    "mysql:host=$db_host;port=$db_port;dbname=$db_name;charset=utf8mb4",$db_user,$db_password
                );
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                // Mensaje genérico al usuario
                echo "❌ No se pudo establecer conexión a la base de datos. Por favor, inténtelo más tarde.";

                // Log detallado para depuración
                error_log("Error de conexión a la base de datos: " . $e->getMessage());
                exit;
            }
        }

        /**
        * Devuelve la instancia única de Database
        *
        * @return Database
        */
        public static function getInstance() {
            if (self::$instance === null) {
                self::$instance = new Database();
            }
            return self::$instance;
        }

         /**
        * Devuelve la conexión PDO
        *
        * @return PDO
        */
        public function getConnection() {
            return $this->connection;
        }

        /**
        * Cierra la conexión PDO
        */
        public function closeConnection() {
            $this->connection = null;
        }
    }
