<?php
    /**
     * Modelo Contact
     * Representa la entidad "contacto" del sistema
     */
    class Contact {
        /** @var int|ID único del contacto */
        public $id;

        /** @var string Nombre del contacto */
        public $name;

        /** @var string|null Email del contacto */
        public $email;

        /** @var string|null Teléfono del contacto */
        public $phone;

        /** @var string|null Notas adicionales */
        public $notes;

        /**
         * Constructor de la clase Contact
         *
         * @param int|null $id ID del contacto (opcional para nuevos)
         * @param string $name Nombre del contacto
         * @param string|null $email Email del contacto
         * @param string|null $phone Teléfono del contacto
         * @param string|null $notes Notas adicionales
         */
        public function __construct($id, $name, $email, $phone, $notes) {
            $this->id = $id;
            $this->name = $name;
            $this->email = $email;
            $this->phone = $phone;
            $this->notes = $notes;
        }

        /**
         * Convierte el objeto a un array asociativo
         *
         * @return array
         */
        public function toArray() {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'notes' => $this->notes
            ];
        }
    }
