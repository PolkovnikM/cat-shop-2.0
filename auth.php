<?php
session_start();
require_once 'config/database.php';

$login = trim($_POST['login'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($login) || empty($password)) {
    header('Location: login.php?error=empty_fields');
    exit;
}

$user = findUserByEmail($login);

if (!$user || !password_verify($password, $user['password_hash'])) {
    writeLog($login, 'FAIL_LOGIN', 'Неверный логин или пароль');
    header('Location: login.php?error=invalid_credentials');
    exit;
}

$_SESSION['user_id'] = $user['id'];
$_SESSION['user_login'] = $user['name'];

writeLog($login, 'SUCCESS_LOGIN', 'Вход выполнен успешно');
header('Location: dashboard.php');
exit;
?>