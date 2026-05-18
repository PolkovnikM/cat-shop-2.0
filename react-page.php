<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>React приложение - Кошачий рай</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <header>
        <ul>
            <li><a href="index.php">Главная</a></li>
            <li><a href="catalog.php">Каталог</a></li>
            <?php if ($isLoggedIn): ?>
                <li><a href="dashboard.php">Личный кабинет</a></li>
                <li><a href="react-page.php">React приложение</a></li>
                <li><a href="logout.php">Выход</a></li>
            <?php else: ?>
                <li><a href="login.php">Вход</a></li>
            <?php endif; ?>
        </ul>
    </header>
    <div id="root"></div>
    <script type="module" crossorigin src="/assets/index-BC09zypA.js"></script>
    <link rel="stylesheet" crossorigin href="/assets/index-6SIGh_Ao.css">
    <footer>
        <p>&copy; Все права защищены.</p>
    </footer>
</body>
</html>