<?php
// models/User.php

require_once __DIR__ . '/../config/database.php';

class User {
    
    // Получить всех пользователей
    public static function getAll() {
        return getUsers();
    }
    
    // Получить пользователя по ID
    public static function getById($id) {
        return findUserById($id);
    }
    
    // Создать нового пользователя
    public static function create($name, $email, $password) {
        $users = getUsers();
        
        // Проверка на существующего пользователя
        if (findUserByEmail($email)) {
            return ['status' => 'error', 'message' => 'Пользователь с таким email уже существует'];
        }
        
        // Генерация нового ID
        $newId = count($users) > 0 ? max(array_column($users, 'id')) + 1 : 1;
        
        $newUser = [
            'id' => $newId,
            'name' => $name,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $users[] = $newUser;
        saveUsers($users);
        
        return ['status' => 'success', 'message' => 'Пользователь зарегистрирован', 'user' => ['id' => $newId, 'name' => $name, 'email' => $email]];
    }
    
    // Авторизация пользователя
    public static function login($email, $password) {
        $user = findUserByEmail($email);
        
        if (!$user) {
            return ['status' => 'error', 'message' => 'Пользователь не найден'];
        }
        
        if (!password_verify($password, $user['password_hash'])) {
            return ['status' => 'error', 'message' => 'Неверный пароль'];
        }
        
        return ['status' => 'success', 'message' => 'Вход выполнен успешно', 'user' => ['id' => $user['id'], 'name' => $user['name'], 'email' => $user['email']]];
    }
    
    // Обновить пароль
    public static function updatePassword($id, $newPassword) {
        $users = getUsers();
        $userIndex = -1;
        
        foreach ($users as $index => $user) {
            if ($user['id'] == $id) {
                $userIndex = $index;
                break;
            }
        }
        
        if ($userIndex === -1) {
            return ['status' => 'error', 'message' => 'Пользователь не найден'];
        }
        
        $users[$userIndex]['password_hash'] = password_hash($newPassword, PASSWORD_DEFAULT);
        $users[$userIndex]['updated_at'] = date('Y-m-d H:i:s');
        saveUsers($users);
        
        return ['status' => 'success', 'message' => 'Пароль успешно изменен'];
    }
    
    // Удалить пользователя
    public static function delete($id) {
        $users = getUsers();
        $userIndex = -1;
        
        foreach ($users as $index => $user) {
            if ($user['id'] == $id) {
                $userIndex = $index;
                break;
            }
        }
        
        if ($userIndex === -1) {
            return ['status' => 'error', 'message' => 'Пользователь не найден'];
        }
        
        array_splice($users, $userIndex, 1);
        saveUsers($users);
        
        return ['status' => 'success', 'message' => 'Пользователь удален'];
    }
}
?>