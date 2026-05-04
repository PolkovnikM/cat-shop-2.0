<?php
// api/index.php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Обработка preflight-запросов для CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../controllers/UserController.php';

$method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];

// Убираем параметры запроса
$request_uri = strtok($request_uri, '?');

// Разбираем URL: /api/users/123
$path = explode('/', trim($request_uri, '/'));
$resource = isset($path[1]) ? $path[1] : '';
$id = isset($path[2]) ? $path[2] : null;

// Получаем тело запроса (для POST, PUT)
$input = json_decode(file_get_contents('php://input'), true);

// Маршрутизация
switch ($method) {
    case 'GET':
        if ($resource === 'users') {
            if ($id) {
                UserController::getUserById($id);
            } else {
                UserController::getAllUsers();
            }
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Endpoint не найден']);
        }
        break;
        
    case 'POST':
        if ($resource === 'register') {
            UserController::register($input);
        } elseif ($resource === 'login') {
            UserController::login($input);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Endpoint не найден']);
        }
        break;
        
    case 'PUT':
        if ($resource === 'users' && $id) {
            UserController::updatePassword($id, $input);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Endpoint не найден']);
        }
        break;
        
    case 'DELETE':
        if ($resource === 'users' && $id) {
            UserController::deleteUser($id);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Endpoint не найден']);
        }
        break;
        
    default:
        http_response_code(405);
        echo json_encode(['status' => 'error', 'message' => 'Метод не разрешен']);
        break;
}
?>