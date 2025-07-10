<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../dao/ContactDAO.php';    
require_once __DIR__ . '/../model/Contact.php';

/**
 * Controlador para gestionar operaciones sobre contactos.
 * Encapsula lógica de negocio y maneja respuestas amigables para la API.
 */
class ContactController {
    private $contactDAO;

    /**
     * Constructor que inicializa el DAO de contactos.
     * Utiliza la conexión a la base de datos configurada en Database.
     */
    public function __construct() {
        $connection = Database::getInstance()->getConnection();
        $this->contactDAO = new ContactDAO($connection);
    }

    /**
     * Obtener todos los contactos
     *
     * @return array
     */
    public function getAllContacts() {
        try {
            $contacts = $this->contactDAO->getAllContacts();
            return [
                'success' => true,
                'message' => '✅ Lista de contactos obtenida exitosamente.',
                'data' => array_map(function($contact) {
                    return $contact->toArray();
                }, $contacts)
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => '❌ Error al obtener los contactos: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Obtener un contacto por ID
     *
     * @param int $id
     * @return array
     */
    public function getContactById($id) {
        try {
            $contact = $this->contactDAO->getContactById($id);
            return [
                'success' => true,
                'message' => '✅ Contacto obtenido exitosamente.',
                'data' => $contact->toArray()
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => '❌ Error al obtener el contacto: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Crear un nuevo contacto
     *
     * @param array $data
     * @return array
     */
    public function createContact($data) {
        try {
            $contact = new Contact(null, $data['name'], $data['email'], $data['phone'], $data['notes']);
            $id = $this->contactDAO->addContact($contact);
            return [
                'success' => true,
                'message' => '✅ Contacto creado con éxito.',
                'id' => $id
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => '❌ Error al crear el contacto: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Actualizar un contacto existente
     *
     * @param int $id
     * @param array $data
     * @return array
     */
    public function updateContact($id, $data) {
        try {
            $contact = new Contact($id, $data['name'], $data['email'], $data['phone'], $data['notes']);
            if ($this->contactDAO->updateContact($contact)) {
                return [
                    'success' => true,
                    'message' => '✅ Contacto actualizado con éxito.'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => '⚠️ No se pudo actualizar el contacto.'
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => '❌ Error al actualizar el contacto: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Eliminar un contacto por ID
     *
     * @param int $id
     * @return array
     */
    public function deleteContact($id) {
        try {
            if ($this->contactDAO->deleteContact($id)) {
                return [
                    'success' => true,
                    'message' => '✅ Contacto eliminado con éxito.'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => '⚠️ No se pudo eliminar el contacto.'
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => '❌ Error al eliminar el contacto: ' . $e->getMessage()
            ];
        }
    }
}
