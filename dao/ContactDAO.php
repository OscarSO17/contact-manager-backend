<?php
    require_once __DIR__ . '/../model/Contact.php';
    /**
    * DAO para operaciones CRUD sobre la tabla de contactos
    */
    class ContactDAO {
        private $connection; 

        /**
        * Constructor inyecta la conexión PDO
        */
        public function __construct(PDO $connection) {
            $this->connection = $connection;
        }

       /**
        * Obtiene todos los contactos
        *
        * @return Contact[] Lista de objetos Contact
        * @throws Exception Si ocurre un error de base de datos
        */
        public function getAllContacts() {
            try {
                $stmt = $this->connection->prepare("SELECT * FROM contacts");
                $stmt->execute();
                
                $results = [];
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $contact = new Contact(
                        $row['id'],
                        $row['name'],
                        $row['email'],
                        $row['phone'],
                        $row['notes']
                    );
                }
                return $results;
            } catch (PDOException $e) {
                error_log("Error en getAll: " . $e->getMessage());
                throw new Exception("❌ Error al obtener los contactos. Inténtelo más tarde.");
            }
        }

        /**
        * Obtiene un contacto por su ID
        *
        * @param int $id
        * @return Contact
        * @throws Exception Si el ID no existe o ocurre un error
        */
        public function getContactById($id) {
            try {
                $stmt = $this->connection->prepare("SELECT * FROM contacts WHERE id = ?");
                $stmt->execute([$id]);
                $row->$stmt->fetch(PDO::FETCH_ASSOC);

                if (!$row) {
                    throw new Exception(" ⚠️ No se encontró el contacto con ID: $id");
                }

                return new Contact(
                    $row['id'],
                    $row['name'],
                    $row['email'],
                    $row['phone'],
                    $row['notes']
                );
            } catch (PDOException $e) {
                error_log("Error en getContactById: " . $e->getMessage());
                throw new Exception("❌ Error al buscar el contacto. Inténtelo más tarde.");
            }
        }

        /**
        * Crea un nuevo contacto
        *
        * @param Contact $contact
        * @return int ID insertado
        * @throws Exception Si falla la creación
        */
        public function addContact(Contact $contact) {
            try {
                $stmt = $this->connection->prepare("INSERT INTO contacts (name, email, phone, notes) VALUES (?, ?, ?, ?)");
                $stmt->execute([
                    $contact->name,
                    $contact->email,
                    $contact->phone,
                    $contact->notes
                ]);

                return $this->connection->lastInsertId();
            } catch (PDOException $e) {
                error_log("Error en addContact: " . $e->getMessage());
                throw new Exception("❌ No se pudo crear el contacto. Inténtelo más tarde.");
            }
        }

        /**
        * Actualiza un contacto existente
        *
        * @param Contact $contact
        * @return bool
        * @throws Exception Si el ID no existe o ocurre un error
        */
        public function updateContact(Contact $contact) {
            try {
                if (!$this->exists($contact->id)) {
                    throw new Exception("❌ El contacto con ID: {$contact->id} no existe.");
                }
                $stmt = $this->connection->prepare("UPDATE contacts SET name = ?, email = ?, phone = ?, notes = ? WHERE id = ?");

                return $stmt->execute([
                    $contact->name,
                    $contact->email,
                    $contact->phone,
                    $contact->notes,
                    $contact->id
                ]);
            } catch (PDOException $e) {
                error_log("Error en updateContact: " . $e->getMessage());
                throw new Exception("❌ No se pudo actualizar el contacto. Inténtelo más tarde.");
            }
        }

        /**
        * Elimina un contacto por ID
        *
        * @param int $id
        * @return bool
        * @throws Exception Si el ID no existe o falla la eliminación
        */
        public function deleteContact($id) {
            try {
                if (!$this->exists($id)) {
                    throw new Exception("❌ El contacto con ID: $id no existe.");
                }
                $stmt = $this->connection->prepare("DELETE FROM contacts WHERE id = ?");
                return $stmt->execute([$id]);
            } catch (PDOException $e) {
                error_log("Error en deleteContact: " . $e->getMessage());
                throw new Exception("❌ No se pudo eliminar el contacto. Inténtelo más tarde.");
            }
        }

        /**
        * Verifica si un contacto existe por ID
        *
        * @param int $id
        * @return bool
        */
        private function exists($id) {
            $stmt = $this->connection->prepare("SELECT 1 FROM contacts WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetchColumn() !== false;
        }
    }