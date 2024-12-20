<?php
require __DIR__ . '/vendor/autoload.php';
// если оно перестанет работать то попробуй require_once '/var/www/vendor/autoload.php'; 
// а оно работает потому что скопировал vendor, но проверять это я не хочу
use Faker\Factory;

$faker = Factory::create();

// Генерация 
$fixtures = [];
for ($i = 0; $i < 50; $i++) {
    $fixtures[] = [
        'product_name' => $faker->word . ' ' . $faker->word, // Название 
        'price' => $faker->randomFloat(2, 1, 100), // Цена 
        'category' => $faker->word, // Категория
        'stock' => $faker->numberBetween(0, 100), // Количество на складе
        'description' => $faker->sentence(10), // Описание
    ];
}


file_put_contents('fixtures.json', json_encode($fixtures, JSON_PRETTY_PRINT));

echo "Фикстуры успешно сгенерированы!";

//  docker-compose run php php /var/www/html/generate_fixtures.php 