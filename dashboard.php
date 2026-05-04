<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?error=auth_required');
    exit;
}

$user_login = $_SESSION['user_login'];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет - Кошачий рай</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        .dashboard-container {
            max-width: 800px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .user-info {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .btn-logout {
            background-color: #c71376;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-logout:hover {
            background-color: #a00d5e;
        }
        .nav-links {
            margin-top: 20px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        .nav-links a {
            background-color: rgb(80, 40, 120);
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .nav-links a:hover {
            background-color: rgb(120, 0, 120);
        }
    </style>
</head>
<body>
    <header>
        <ul>
            <li><a href="index.php">Главная</a></li>
            <li><a href="catalog.php">Каталог</a></li>           <!-- ← ИСПРАВЛЕНО -->
            <li><a href="dashboard.php">Личный кабинет</a></li>
            <li><a href="logout.php">Выход</a></li>
        </ul>
    </header>

    <div class="dashboard-container">
        <h2>Личный кабинет</h2>
        
        <div class="user-info">
            <p><strong>Добро пожаловать!</strong></p>
            <p>Вы вошли как: <strong><?php echo htmlspecialchars($user_login); ?></strong></p>
        </div>
        
        <p>Это защищенная страница, доступная только авторизованным пользователям.</p>
        
        <div class="nav-links">
            <a href="catalog.php">Перейти в каталог</a>        <!-- ← ИСПРАВЛЕНО -->
            <a href="logout.php" class="btn-logout">Выйти из системы</a>
        </div>
    </div>

    <footer>
        <p>&copy; Все права защищены.</p>
    </footer>
</body>
</html>