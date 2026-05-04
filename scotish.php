<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Шотландская вислоухая - описание породы</title>
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
        Шотландская вислоухая
    </h1>
    <a href="images/scotish-big.jpg" target="_blank">
        <img src="images/scotish.jpg" alt="Шотландская вислоухая" width="300" height="250">
    </a>
    <h2>Краткое описание</h2>
    <p>
    Очаровательные совята с плюшевой шерстью.Главная особенность шотландской 
    вислоухой — загнутые вперед и вниз ушки, которые придают мордочке трогательное 
    выражение.
    </p>
    <h2>Описание</h2>
    <p>
        Шотландская вислоухая — это порода кошек, которую легко узнать 
       по загнутым вперед и вниз ушкам. Из-за этого они выглядят как совята или плюшевые 
       игрушки. Это очень милые, спокойные и дружелюбные кошки с тихим и мягким голосом. 
       Они сильно привязываются к хозяевам и любят сидеть на руках.
    </p>
    <h2>Характеристики</h2>
    <ul class="characteristics-list">
        <li><b>Страна происхождения:</b> Шотландия</li>
        <li><b>Вес:</b> 4-7 кг (коты), 3-5 кг (кошки)</li>
        <li><b>Шерсть:</b> Короткая, густая, плюшевая</li>
        <li><b>Характер:</b> Спокойный, ласковый, преданный</li>
        <li><b>Продолжительность жизни:</b> 12-15 лет</li>
        <li><b>Особенности:</b> Загнутые уши, большие круглые глаза</li>
        <li><b>Окрас:</b> Любой (самые популярные - серый и рыжий)</li>
    </ul>
    <hr>
    <footer>
        <p>
            &copy; Все права защищены.
        </p>
    </footer>

</body>