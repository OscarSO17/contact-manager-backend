<?php
    /**
     * Archivo de enrutamiento principal de la API.
     * Maneja solicitudes REST (GET, POST, PUT, DELETE) y responde en formato JSON.
     */

    // ==============================
    // Cabeceras CORS y JSON
    // ==============================
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');

    // Manejo de solicitudes preflight (OPTIONS)
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit;
    }

    // ==============================
    // Requerir controlador
    // ==============================
    require_once __DIR__ . '/../controller/ContactController.php';

    // Instanciar el controlador
    $controller = new ContactsController();

    // ==============================
    // Obtener método y ruta solicitada
    // ==============================
    $method = $_SERVER['REQUEST_METHOD'];
    $path = $_GET['path'] ?? '';

    // ==============================
    // Enrutamiento básico REST
    // ==============================
    switch ($method) {
        // ------------------------------
        // GET: Obtener datos
        // ------------------------------
        case 'GET':
            if ($path === 'contacts') {
                // Obtener todos los contactos
                echo json_encode($controller->getAllContacts());
            } elseif ($path === 'contact' && isset($_GET['id'])) {
                // Obtener un contacto específico
                echo json_encode($controller->getContactById((int)$_GET['id']));
            } else {
                http_response_code(404);
                echo json_encode(['success' => false , 'message' => 'Ruta GET no encontrada']);
            }
            break;

        // ------------------------------
        // POST: Crear nuevo contacto
        // ------------------------------
        case 'POST':
            if ($path === 'contact') {
                $data = json_decode(file_get_contents('php://input'), true);
                echo json_encode($controller->createContact($data));
            } else {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Ruta POST no encontrada']);
            }
            break;

        // ------------------------------
        // PUT: Actualizar contacto existente
        // ------------------------------
        case 'PUT':
            if ($path === 'contact' && isset($_GET['id'])) {
                $data = json_decode(file_get_contents('php://input'), true);
                echo json_encode($controller->updateContact($_GET['id'], $data));
            } else {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Ruta PUT no encontrada']);
            }
            break;

        // ------------------------------
        // DELETE: Eliminar contacto
        // ------------------------------
        case 'DELETE':
            if ($path === 'contact' && isset($_GET['id'])) {
                echo json_encode($controller->deleteContact($_GET['id']));
            } else {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Ruta DELETE no encontrada']);
            }
            break;

        // ------------------------------
        // Método no permitido
        // ------------------------------
        default:
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            break;
    }
