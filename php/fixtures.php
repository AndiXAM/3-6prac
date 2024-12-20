<?php
// Загрузка фикстур из файла
$fixtures = json_decode(file_get_contents('fixtures.json'), true);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Фикстуры продуктов</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Сгенерированные фикстуры продуктов</h1>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Название продукта</th>
                <th>Цена</th>
                <th>Категория</th>
                <th>Количество на складе</th>
                <th>Описание</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fixtures as $fixture): ?>
                <tr>
                    <td><?php echo htmlspecialchars($fixture['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($fixture['price']); ?></td>
                    <td><?php echo htmlspecialchars($fixture['category']); ?></td>
                    <td><?php echo htmlspecialchars($fixture['stock']); ?></td>
                    <td><?php echo htmlspecialchars($fixture['description']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
