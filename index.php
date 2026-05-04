<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="ru">  
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Породы кошек - Главная</title>
    <link rel="stylesheet" type ="text/css" href="css/style.css">
</head>
<body>
    <header>
        <ul>
            <li><a href="index.php">Главная</a></li>
            <li><a href="catalog.php">Каталог</a></li>
            <?php if ($isLoggedIn): ?>
                <li><a href="dashboard.php">Личный кабинет</a></li>
                <li><a href="logout.php">Выход</a></li>
            <?php else: ?>
                <li><a href="login.php">Вход</a></li>
            <?php endif; ?>
        </ul>
    </header>
    <hr>
    <h1> 
        Всё о породах кошек 
    </h1>
    <p>
        Добро пожаловать на сайт для будущий обладателей прекрасного животного! 
        Здесь вы найдете информацию о самых популярных породах кошек.
    </p>
    <hr>
    <footer>
        <p>
            &copy; Все права защищены.
        </p>
    </footer>

</body>
</html>
