<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сиамская - описание породы</title>
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
        Сиамская
    </h1>
    <a href="images/siamese-big.jpg" target="_blank">
        <img src="images/siamese.jpg" alt="Сиамская" width="300" height="250">
    </a>
    <h2>Краткое описание</h2>
    <p>
        Изящная, голубоглазая и очень разговорчивая.Это не те питомцы, 
        которые будут сидеть на полке: они хотят участвовать во всем, что делает их 
        хозяин.
    </p>

    <h2>Описание</h2>
    <p>
        Сиамская кошка — одна из самых узнаваемых пород в мире. У них изящное тело, 
       голубые глаза и характерный окрас (темные мордочка, уши, лапы и хвост). 
       Это очень умные, активные и разговорчивые кошки. Они сильно привязываются к 
       человеку и требуют много внимания. Сиамцев называют "кошками-собаками" за их 
       преданность хозяину.
    </p>
    <h2>Характеристики</h2>
    <ul class="characteristics-list">
        <li><b>Страна происхождения:</b> Таиланд (бывш. Сиам)</li>
        <li><b>Вес:</b> 4-6 кг (коты), 2.5-4 кг (кошки)</li>
        <li><b>Шерсть:</b> Короткая, тонкая, без подшерстка</li>
        <li><b>Характер:</b> Активный, любопытный, общительный</li>
        <li><b>Продолжительность жизни:</b> 14-16 лет (до 20 лет)</li>
        <li><b>Цвет глаз:</b> Ярко-голубой</li>
        <li><b>Особенности:</b> Контрастный окрас (поинты)</li>
    </ul>
    <hr>
    <footer>
        <p>
            &copy; Все права защищены.
        </p>
    </footer>

</body>