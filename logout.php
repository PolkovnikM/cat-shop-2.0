<?php
session_start();
require_once 'config/database.php';

if (isset($_SESSION['user_login'])) {
    writeLog($_SESSION['user_login'], 'LOGOUT', 'Выход из системы');
}

session_destroy();
header('Location: login.php?message=logout');
exit;
?>