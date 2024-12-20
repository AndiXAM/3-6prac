<?php
$conn = new mysqli('db', 'user', 'password', 'shop_db');

if ($conn->connect_error) {
    die('Ошибка подключения: ' . $conn->connect_error);
}

// Определяем количество товаров на странице
$itemsPerPage = 3;

// Получаем текущую страницу из параметров URL (по умолчанию 1)
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($currentPage - 1) * $itemsPerPage;

// Получаем общее количество товаров
$totalResult = $conn->query('SELECT COUNT(*) as count FROM products');
$totalRow = $totalResult->fetch_assoc();
$totalItems = $totalRow['count'];
$totalPages = ceil($totalItems / $itemsPerPage);

// Получаем товары для текущей страницы
$sql = "SELECT product_name, price FROM products LIMIT $itemsPerPage OFFSET $offset";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["postman"])) {
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo '<!DOCTYPE html>';
    echo '<html lang="ru">';
    echo '<head>';
    echo '    <meta charset="UTF-8">';
    echo '    <title>Товары</title>';
    echo '</head>';
    
    echo '<body>';
    
    // Заголовок страницы
    echo '<h1>Список товаров</h1>';
    
    // Список товаров
    if ($result->num_rows > 0) {
        echo '<ul>';
        while($row = $result->fetch_assoc()) {
            $productName = htmlspecialchars($row['product_name']);
            $price = htmlspecialchars($row['price']);
            echo "<li>$productName - <strong>$price</strong> руб.</li>";
        }
        echo '</ul>';

        // Пагинация
        if ($totalPages > 1) {
            echo '<div class="pagination">';
            for ($i = 1; $i <= $totalPages; $i++) {
                if ($i == $currentPage) {
                    echo "<strong>$i</strong> ";
                } else {
                    echo "<a href=\"?page=$i\">$i</a> ";
                }
            }
            echo '</div>';
        }
        
    } else {
        // Если нет доступных товаров
        echo '<div>Нет доступных товаров.</div>';
    }
    
    // Закрываем соединение с базой данных
    $conn->close();
    
    // Закрываем тело документа и HTML
    echo '</body></html>';
}
?>
