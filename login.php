<?php
session_start();

// Если пользователь уже авторизован, перенаправляем в личный кабинет
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в систему - Кошачий рай</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn-login {
            width: 100%;
            padding: 12px;
            background-color: rgb(80, 40, 120);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .btn-login:hover {
            background-color: rgb(120, 0, 120);
        }
        .error-message {
            background-color: #ffebee;
            color: #c62828;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }
        .success-message {
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <ul>
            <li><a href="index.php">Главная</a></li>
            <li><a href="catalog.php">Каталог</a></li>
            <li><a href="login.php">Вход</a></li>
        </ul>
    </header>

    <div class="login-container">
        <h2>Авторизация</h2>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="error-message">
                <?php
                switch($_GET['error']) {
                    case 'empty_fields':
                        echo 'Заполните все поля!';
                        break;
                    case 'invalid_credentials':
                        echo 'Неверный логин или пароль!';
                        break;
                    case 'auth_required':
                        echo 'Требуется авторизация!';
                        break;
                    default:
                        echo 'Произошла ошибка!';
                }
                ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['message']) && $_GET['message'] == 'logout'): ?>
            <div class="success-message">
                Вы успешно вышли из системы.
            </div>
        <?php endif; ?>

        <form action="auth.php" method="POST">
            <div class="form-group">
                <label for="login">Email:</label>
                <input type="text" id="login" name="login" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn-login">Войти</button>
        </form>
        <p>Нет аккаунта? <a href="register.php">Зарегистрироваться</a></p>
    </div>

    <footer>
        <p>&copy; Все права защищены.</p>
    </footer>
</body>
</html>