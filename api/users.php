<?php
    /**
     * Endpoint para gestión de usuarios: registro y login.
     * Recibe y devuelve datos en formato JSON.
     */

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit;
    }

    require_once __DIR__ . '/../controller/UserController.php';

    // Crear instancia del controlador
    $controller = new UserController();

    // Detectar método HTTP
    $method = $_SERVER['REQUEST_METHOD'];
    $path = $_GET['path'] ?? '';

    switch ($method) {
        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);

            if ($path === 'register') {
                echo json_encode($controller->registerUser($data));
            } elseif ($path === 'login') {
                echo json_encode($controller->login($data));
            } else {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Ruta POST no encontrada']);
            }
            break;

        default:
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            break;
    }
