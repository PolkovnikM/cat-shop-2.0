<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../config/database.php';

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Не авторизован']);
    exit;
}

$users = getUsers();
$userIndex = -1;
foreach ($users as $i => $u) {
    if ($u['id'] == $userId) {
        $userIndex = $i;
        break;
    }
}

if ($userIndex === -1) {
    http_response_code(404);
    echo json_encode(['status' => 'error', 'message' => 'Пользователь не найден']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $cart = $users[$userIndex]['cart'] ?? [];
        echo json_encode(['status' => 'success', 'data' => $cart]);
        break;
        
    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $product = $input['product'] ?? null;
        
        if (!$product) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Нет товара']);
            exit;
        }
        
        $cart = $users[$userIndex]['cart'] ?? [];
        $found = false;
        
        foreach ($cart as &$item) {
            if ($item['id'] == $product['id']) {
                $item['quantity']++;
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            $product['quantity'] = 1;
            $cart[] = $product;
        }
        
        $users[$userIndex]['cart'] = $cart;
        saveUsers($users);
        
        echo json_encode(['status' => 'success', 'message' => 'Товар добавлен']);
        break;
        
    case 'PUT':
        $input = json_decode(file_get_contents('php://input'), true);
        $users[$userIndex]['cart'] = $input['cart'] ?? [];
        saveUsers($users);
        echo json_encode(['status' => 'success', 'message' => 'Корзина сохранена']);
        break;
        
    case 'DELETE':
        $users[$userIndex]['cart'] = [];
        saveUsers($users);
        echo json_encode(['status' => 'success', 'message' => 'Корзина очищена']);
        break;
        
    default:
        http_response_code(405);
        echo json_encode(['status' => 'error', 'message' => 'Метод не разрешён']);
        break;
}
?>