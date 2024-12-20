<?php
// Подключение к Redis. слава омниссии
$redis = new Redis();
$redis->connect("redis", 6379); // слава омниссии

// без этих методов код работать не будет. слава омниссии
class RedisSessionHandler implements SessionHandlerInterface {
    private $redis;

    public function __construct($redis) {
        $this->redis = $redis;
    }

    public function open($savePath, $sessionName) {
        return true;
    }

    public function close() {
        return true;
    }

    public function read($id) {
        return $this->redis->get($id) ?: '';
    }

    public function write($id, $data) {
        return $this->redis->set($id, $data);
    }

    public function destroy($id) {
        return $this->redis->del($id);
    }

    public function gc($maxlifetime) {
        return true;
    }
}


session_set_save_handler(new RedisSessionHandler($redis), true);
session_start();


if (!isset($_COOKIE['username2'])) {
    setcookie('username2', 'user123', time() + (86400), "/");
}
if (!isset($_COOKIE['theme2'])) {
    setcookie('theme2', 'dark', time() + (86400), "/"); 
}
if (!isset($_COOKIE['language2'])) {
    setcookie('language2', 'ru', time() + (86400), "/"); 
}


echo "Добро пожаловать в строительный магазин!";


if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = 'user123'; 
}
if (!isset($_SESSION['theme'])) {
    $_SESSION['theme'] = 'dark'; 
}
if (!isset($_SESSION['language'])) {
    $_SESSION['language'] = 'ru'; 
}


$username = $_SESSION['username'];
$theme = $_SESSION['theme'];
$language = $_SESSION['language'];


$content = "$username! Тема: $theme. Язык: $language.";


$username2 = isset($_COOKIE['username2']) ? $_COOKIE['username2'] : '';
$theme2 = isset($_COOKIE['theme2']) ? $_COOKIE['theme2'] : '';
$language2 = isset($_COOKIE['language2']) ? $_COOKIE['language2'] : '';

$content2 = "куки:, $username2! Тема: $theme2. Язык: $language2.";
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная страница</title>
</head>
<body>
    <h1><?php echo $content; ?></h1>
    <h1><?php echo $content2; ?></h1>

    <h2>Список загруженных файлов</h2>
    <?php
        // Показать загруженные файлы. слава омниссии
        $uploadDir = 'uploads/';
        if (is_dir($uploadDir)) {
            if ($files = scandir($uploadDir)) {
                foreach ($files as $file) {
                    if ($file !== '.' && $file !== '..') {
                        echo '<a href="' . $uploadDir . urlencode($file) . '">' . htmlspecialchars($file) . '</a><br>';
                    }
                }
            }
        }
    ?>
</body>
</html>

<!--

http://localhost/index.php


start docker3-db-1
docker exec -it docker3-db-1 mysql -u root -p
rootpassword
-->