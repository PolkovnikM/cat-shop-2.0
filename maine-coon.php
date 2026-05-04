<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мейн-кун - описание породы</title>
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
        Мейн-кун
    </h1>
    <a href="images/maine-coon-big.jpg" target="_blank">
        <img src="images/maine-coon.jpg" alt="Мейн-кун" width="300" height="250">
    </a>
    <h2>Краткое описание</h2>
    <p>
    Мягкий гигант с кисточками на ушах.Мейн-куны — самые крупные домашние 
    кошки, настоящие "енисейские рыси".
    </p>

    <h2>Описание</h2>
    <p>
        Мейн-кун — это аборигенная порода кошек, которая появилась в США (штат Мэн).
       Это одна из самых крупных пород домашних кошек. Они очень умные, добрые и 
       преданные. Несмотря на внушительные размеры, это очень ласковые и игривые кошки.
       Их часто называют "мягкими гигантами" за их огромное сердце и любовь к людям.
    </p>
    <h2>Характеристики</h2>
    <ul class="characteristics-list">
        <li><b>Страна происхождения:</b> США</li>
        <li><b>Вес:</b> 6-11 кг (коты), 4-6 кг (кошки)</li>
        <li><b>Шерсть:</b> Полудлинная, густая, водоотталкивающая</li>
        <li><b>Характер:</b> Дружелюбный, спокойный, игривый</li>
        <li><b>Продолжительность жизни:</b> 12-15 лет</li>
        <li><b>Особенности:</b> Кисточки на ушах, пушистый хвост</li>
        <li><b>Линька:</b> Умеренная (нуждаются в расчесывании)</li>
    </ul>
    <hr>
    <footer>
        <p>
            &copy; Все права защищены.
        </p>
    </footer>

</body>
</html>
