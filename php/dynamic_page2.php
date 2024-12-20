<?php
$conn = new mysqli('db', 'user', 'password', 'shop_db');

if ($conn->connect_error) {
    die('Ошибка подключения: ' . $conn->connect_error);
}

$sql = 'SELECT * FROM orders';
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["postman"])) {
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
}
else {
    echo '<!DOCTYPE html>';
    echo '<html lang="ru">';
    echo '<head>';
    echo '    <meta charset="UTF-8">';
    echo '    <meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '    <title>Заказы</title>';
    echo '</head>';
    
    echo '<body>';
    echo '    <h1>Список заказов</h1>';
    
    if ($result && $result->num_rows > 0) {
        echo '<table>';
        echo '<tr><th>ID</th><th>Товар</th><th>Количество</th></tr>';
        while($row = $result->fetch_assoc()) {
            echo '<tr><td>' . $row['id'] . '</td><td>' . $row['product_id'] . '</td><td>' . $row['quantity'] . '</td></tr>';
        }
        echo '</table>'; 
    } else {
        echo 'Нет заказов.';
    }
    
    $conn->close();
    
    echo '</body>';
    echo '</html>';
}

?>