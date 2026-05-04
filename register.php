<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="css/style.css">
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

    <div class="login-container">
        <h2>Регистрация</h2>
        
        <div id="message" class="error-message" style="display: none;"></div>
        
        <form id="registerForm">
            <div class="form-group">
                <label for="name">Имя:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn-login">Зарегистрироваться</button>
        </form>
        
        <p style="text-align: center; margin-top: 15px;">
            Уже есть аккаунт? <a href="login.php">Войти</a>
        </p>
    </div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            const response = await fetch('/api/register', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ name, email, password })
            });
            
            const data = await response.json();
            const messageDiv = document.getElementById('message');
            
            if (data.status === 'success') {
                messageDiv.style.backgroundColor = '#e8f5e9';
                messageDiv.style.color = '#2e7d32';
                messageDiv.textContent = 'Регистрация успешна! Теперь войдите.';
                messageDiv.style.display = 'block';
                setTimeout(() => {
                    window.location.href = 'login.php';
                }, 2000);
            } else {
                messageDiv.style.backgroundColor = '#ffebee';
                messageDiv.style.color = '#c62828';
                messageDiv.textContent = data.message;
                messageDiv.style.display = 'block';
            }
        });
    </script>

    <footer>
        <p>&copy; Все права защищены.</p>
    </footer>
</body>
</html>