<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Каталог пород кошек</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <header>
        <ul>
        <li><a href="index.php">Главная</a></li>
        <li><a href="catalog.php">Каталог</a></li>
        <?php if ($isLoggedIn): ?>
            <li><a href="dashboard.php">Личный кабинет</a></li>
            <li><a href ="react-page.php">React приложение</a></li>
            <li><a href="logout.php">Выход</a></li>
        <?php else: ?>
            <li><a href="login.php">Вход</a></li>
        <?php endif; ?>
        </ul>
    </header>
    
    <h1>Каталог пород кошек</h1>
    
    <div class="kittens-section">
        <h2>Породы кошек</h2>
        <div class="kittens-grid">
            <div class="kitten-card">
                <img src="images/maine-coon.jpg" width="250" height="180">
                <h3>Мейн-кун</h3>
                <p class="price kitten-price">80 000 ₽</p>
                <button class="add-kitten" data-id="101" data-name="Мейн-кун" data-price="80000" data-image="images/maine-coon.jpg">Добавить в корзину</button>
                <p><a href="maine-coon.php">Подробнее о породе </a></p>
            </div>
            <div class="kitten-card">
                <img src="images/siamese.jpg" width="250" height="180">
                <h3>Сиамская</h3>
                <p class="price kitten-price">15 000 ₽</p>
                <button class="add-kitten" data-id="102" data-name="Сиамская" data-price="15000" data-image="images/siamese.jpg">Добавить в корзину</button>
                <p><a href="siamese.php">Подробнее о породе </a></p>
            </div>
            <div class="kitten-card">
                <img src="images/scotish.jpg" width="250" height="180">
                <h3>Шотландская вислоухая</h3>
                <p class="price kitten-price">30 000 ₽</p>
                <button class="add-kitten" data-id="103" data-name="Шотландская вислоухая" data-price="30000" data-image="images/scotish.jpg">Добавить в корзину</button>
                <p><a href="scotish.php">Подробнее о породе </a></p>
            </div>
        </div>    
    </div>
    <h1>Каталог продуктов для кошек</h1>
    <hr>
    <div class="products-section">
        <h2>Товары для кошек</h2>
        <div class="filters">
            <button class="filter-btn active" data-category="all">Все товары</button>
            <button class="filter-btn" data-category="food">Корм</button>
            <button class="filter-btn" data-category="toys">Игрушки</button>
            <button class="filter-btn" data-category="accessories">Аксессуары</button>
            <button class="filter-btn" data-category="care">Уход</button>
        </div>
        <div class="catalog-grid"></div>
    </div>
    
    <hr>
    <div class="cart-section">
        <h2> Корзина</h2>
        <div class="cart-items"></div>
        <div class="cart-summary">
            <p class="cart-total">Итого: 0 ₽</p>
            <div class="cart-buttons">
                <button class="clear-cart-btn">Очистить корзину</button>
                <button class="checkout-btn">Оплатить</button>
            </div>
        </div>
    </div>
    
    <footer>
        <p>&copy; Все права защищены.</p>
    </footer>
    
    <script src="js/script.js"></script>
</body>
</html>