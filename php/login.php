<?php
// Подключение к базе данных
$conn = new mysqli('db', 'user', 'password', 'shop_db');

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Инициализация переменных
$message = "";

// Обработка формы входа
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $userName = $_POST['username'];
    $userPassword = $_POST['password'];

    // Проверка пользователя в базе данных
    $stmt = $conn->prepare("SELECT userPassword FROM users WHERE userName = ?");
    $stmt->bind_param("s", $userName);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();

        // Проверка пароля (предполагается, что пароли хранятся в виде хешей)
        if (password_verify($userPassword, $hashedPassword)) {
            // Успешный вход
            header("Location: index2.php");
            exit();
        } else {
            $message = "Неверный пароль.";
        }
    } else {
        $message = "Пользователь не найден.";
    }
    $stmt->close();
}

// Обработка формы регистрации
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $userName = $_POST['username'];
    $userPassword = password_hash($_POST['password'], PASSWORD_DEFAULT); // Хеширование пароля

    // Вставка нового пользователя в базу данных
    $stmt = $conn->prepare("INSERT INTO users (userName, userPassword) VALUES (?, ?)");
    $stmt->bind_param("ss", $userName, $userPassword);

    if ($stmt->execute()) {
        $message = "Регистрация успешна! Вы можете войти.";
    } else {
        $message = "Ошибка регистрации: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход / Регистрация</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #333;
            text-align: center;
        }

        .container {
            max-width: 400px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        p {
            text-align: center;
            color: red; /* Цвет сообщения об ошибках */
        }
        
        .form-section {
            margin-bottom: 30px; /* Отступ между секциями формы */
        }
        
        .form-section:last-child {
            margin-bottom: 0; /* Убираем отступ у последней секции */
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-section">
        <h2>Вход</h2>
        <?php if ($message != ""): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Имя пользователя" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <button type="submit" name="login">Войти</button>
        </form>
    </div>

    <div class="form-section">
        <h2>Регистрация</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Имя пользователя" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <button type="submit" name="register">Зарегистрироваться</button>
        </form>
    </div>
</div>

</body>
</html>