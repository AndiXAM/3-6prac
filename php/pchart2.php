<?php
require_once '/var/www/vendor/autoload.php'; 

use CpChart\Data;
use CpChart\Image; 


$jsonData = file_get_contents('fixtures.json');
$products = json_decode($jsonData, true); 


if ($products === null) {
    die('Ошибка при загрузке данных из fixtures.json');
}


$productNames = [];
$prices = [];

foreach ($products as $product) {
    $productNames[] = $product['product_name'];
    $prices[] = $product['price'];
}


$data = new Data();
$data->addPoints($prices, "Prices"); // Добавляем цены как серию данных
$data->addPoints($productNames, "Labels"); // Добавляем имена продуктов как метки
$data->setAbscissa("Labels"); // Устанавливаем метки по оси X


$image = new Image(700, 230, $data);


$image->setGraphArea(60, 40, 680, 200); 
$image->drawScale(); // шкала
$image->drawLineChart(); // линейный график


$image->render("image2.png");
header("Content-Type: image/png");
readfile("image2.png");
?>