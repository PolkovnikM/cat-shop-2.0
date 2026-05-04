<?php
// config/database.php - единый файл для всех

define('DATA_DIR', __DIR__ . '/../data/');
define('USERS_FILE', DATA_DIR . 'users.json');
define('LOGS_DIR', __DIR__ . '/../logs/');
define('LOG_FILE', LOGS_DIR . 'auth.log');

// Функция логирования (ПР-5)
function writeLog($login, $action, $message = '') {
    if (!is_dir(LOGS_DIR)) mkdir(LOGS_DIR, 0755, true);
    
    $line = "[" . date('Y-m-d H:i:s') . "] | IP: " . $_SERVER['REMOTE_ADDR'] . " | Логин: $login | Действие: $action" . ($message ? " | $message" : "") . PHP_EOL;
    file_put_contents(LOG_FILE, $line, FILE_APPEND);
}

// Работа с пользователями
function getUsers() {
    if (!file_exists(USERS_FILE)) {
        file_put_contents(USERS_FILE, json_encode([]));
    }
    return json_decode(file_get_contents(USERS_FILE), true);
}

function saveUsers($users) {
    file_put_contents(USERS_FILE, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function findUserByEmail($email) {
    foreach (getUsers() as $user) {
        if ($user['email'] === $email) return $user;
    }
    return null;
}

function findUserById($id) {
    foreach (getUsers() as $user) {
        if ($user['id'] == $id) return $user;
    }
    return null;
}

// Создание пользователя
function createUser($name, $email, $password) {
    if (findUserByEmail($email)) {
        return ['status' => 'error', 'message' => 'Email уже существует'];
    }
    
    $users = getUsers();
    $newId = count($users) > 0 ? max(array_column($users, 'id')) + 1 : 1;
    
    $newUser = [
        'id' => $newId,
        'name' => $name,
        'email' => $email,
        'password_hash' => password_hash($password, PASSWORD_DEFAULT),
        'cart' => [],
        'created_at' => date('Y-m-d H:i:s')
    ];
    
    $users[] = $newUser;
    saveUsers($users);
    
    return ['status' => 'success', 'message' => 'Регистрация успешна', 'user' => ['id' => $newId, 'name' => $name, 'email' => $email]];
}

// Обновление пароля
function updateUserPassword($id, $newPassword) {
    $users = getUsers();
    foreach ($users as &$user) {
        if ($user['id'] == $id) {
            $user['password_hash'] = password_hash($newPassword, PASSWORD_DEFAULT);
            saveUsers($users);
            return ['status' => 'success', 'message' => 'Пароль изменён'];
        }
    }
    return ['status' => 'error', 'message' => 'Пользователь не найден'];
}

// Удаление пользователя
function deleteUser($id) {
    $users = getUsers();
    foreach ($users as $i => $user) {
        if ($user['id'] == $id) {
            array_splice($users, $i, 1);
            saveUsers($users);
            return ['status' => 'success', 'message' => 'Пользователь удалён'];
        }
    }
    return ['status' => 'error', 'message' => 'Пользователь не найден'];
}
?>