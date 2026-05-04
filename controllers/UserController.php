<?php
require_once __DIR__ . '/../models/User.php';

class UserController {
    
    // GET /api/users - получить всех пользователей
    public static function getAllUsers() {
        $users = User::getAll();
        foreach ($users as &$user) {
            unset($user['password_hash']);
        }
        echo json_encode(['status' => 'success', 'data' => $users]);
    }
    
    // GET /api/users/{id} - получить одного пользователя
    public static function getUserById($id) {
        $user = User::getById($id);
        
        if (!$user) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Пользователь не найден']);
            return;
        }
        
        unset($user['password_hash']);
        echo json_encode(['status' => 'success', 'data' => $user]);
    }
    
    // POST /api/register - регистрация
    public static function register($data) {
        // Валидация
        if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Все поля обязательны']);
            return;
        }
        
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Некорректный email']);
            return;
        }
        
        if (strlen($data['password']) < 6) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Пароль должен быть не менее 6 символов']);
            return;
        }
        
        $result = User::create($data['name'], $data['email'], $data['password']);
        
        if ($result['status'] === 'error') {
            http_response_code(409);
        } else {
            http_response_code(201);
        }
        
        echo json_encode($result);
    }
    
    // POST /api/login - авторизация
    public static function login($data) {
        if (empty($data['email']) || empty($data['password'])) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Email и пароль обязательны']);
            return;
        }
        
        $result = User::login($data['email'], $data['password']);
        
        if ($result['status'] === 'error') {
            http_response_code(401);
        }
        
        echo json_encode($result);
    }
    
    // PUT /api/users/{id} - изменение пароля
    public static function updatePassword($id, $data) {
        if (empty($data['password'])) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Новый пароль обязателен']);
            return;
        }
        
        if (strlen($data['password']) < 6) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Пароль должен быть не менее 6 символов']);
            return;
        }
        
        $result = User::updatePassword($id, $data['password']);
        
        if ($result['status'] === 'error') {
            http_response_code(404);
        }
        
        echo json_encode($result);
    }
    
    // DELETE /api/users/{id} - удаление пользователя
    public static function deleteUser($id) {
        $result = User::delete($id);
        
        if ($result['status'] === 'error') {
            http_response_code(404);
        }
        
        echo json_encode($result);
    }
}
?>