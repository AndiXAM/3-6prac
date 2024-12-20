<?php
require_once '/var/www/vendor/autoload.php'; 

use CpChart\Data;
use CpChart\Image;
use CpChart\Chart\Pie;


$jsonData = file_get_contents('fixtures.json');
$products = json_decode($jsonData, true);


if ($products === null) {
    die('Ошибка загрузки данных из fixtures.json');
}


$values = [];
$labels = [];

// Собираем данные для графика
foreach ($products as $product) {
    $values[] = $product['stock']; // Используем stock как значение
    $labels[] = $product['product_name']; // Используем product_name как метку
}

// Создаем и заполняем данные
$data = new Data();
$data->addPoints($values, "Values");
$data->setSerieDescription("Values", "Количество на складе");

// Определяем абсциссу (хвала гайдам)
$data->addPoints($labels, "Labels");
$data->setAbscissa("Labels");

// размеры
$image = new Image(700, 230, $data);

// Устанавливаем фон
$backgroundSettings = [
    "R" => 173, 
    "G" => 152, 
    "B" => 217,
    "Dash" => 1,
    "DashR" => 193,
    "DashG" => 172,
    "DashB" => 237
];
$image->drawFilledRectangle(0, 0, 700, 230, $backgroundSettings);

//градиент фона
$gradientSettings = [
    "StartR" => 209, 
    "StartG" => 150, 
    "StartB" => 231, 
    "EndR" => 111, 
    "EndG" => 3, 
    "EndB" => 138, 
    "Alpha" => 50
];
$image->drawGradientArea(0, 0, 700, 230, DIRECTION_VERTICAL, $gradientSettings);

// оно не работает, надо проетисть на английсокм
$image->setFontProperties(["FontName" => "Silkscreen.ttf", "FontSize" => 6]);
$image->drawText(10, 13, "Пироговая диаграмма запасов продуктов", ["R" => 255, "G" => 255, "B" => 255]);

// Создаем и рисуем диаграмму
$pieChart = new Pie($image, $data);
$pieChart->draw2DPie(350, 115, ["DrawLabels" => true]);

// Выводим изображение на экран
$image->render("image1.png");
$image->autoOutput("image1.png");
?>