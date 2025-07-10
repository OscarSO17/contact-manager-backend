<?php
    /**
    * Modelo que representa a un usuario del sistema.
    */
    class User {
        private $id;
        private $username;
        private $password_hash;

        /**
        * Constructor de la clase User.
        * @param int $id ID del usuario.
        * @param string $username Nombre de usuario.    
        * @param string $password_hash Contraseña del usuario.
        */
        public function __construct($id, $username, $password_hash) {
            $this->id = $id;
            $this->username = $username;
            $this->password_hash = $password_hash;
        }

        /**
        * Obtiene un array sin exponer la contraseña.
        * 
        * @return array
        */
        public function toArray() {
            return [
                'id' => $this->id,
                'username' => $this->username
            ];
        }

        /**
        * Obtiene el hash de la contraseña (para DB).
        *
        * @return string
        */
        public function getPasswordHash() {
            return $this->password_hash;
        }

        /**
        * Obtiene el ID del usuario.
        * @return int
        */
        public function getUserId() {
            return $this->id;
        }

        /**
        * Obtiene el nombre de usuario.
        * @return string
        */
        public function getUsername() {
            return $this->username;
        }
    }