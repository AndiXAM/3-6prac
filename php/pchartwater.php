<?php

$originalImages = ['image1.png', 'image2.png', 'image3.png'];
$watermarkImagePath = 'watermark3.png'; 
$outputImages = ['image1waterrr.png', 'image2waterrr.png', 'image3waterrr.png']; 

foreach ($originalImages as $index => $originalImagePath) {
    
    $originalImage = imagecreatefrompng($originalImagePath);
    $watermarkImage = imagecreatefrompng($watermarkImagePath);

    // размеры изображений
    $originalWidth = imagesx($originalImage);
    $originalHeight = imagesy($originalImage);
    $watermarkWidth = imagesx($watermarkImage);
    $watermarkHeight = imagesy($watermarkImage);

    $xPosition = ($originalWidth - $watermarkWidth) / 2; // Центр по горизонтали
    $yPosition = ($originalHeight - $watermarkHeight) / 2; // Центр по вертикали

    $transparentWatermark = imagecreatetruecolor($watermarkWidth, $watermarkHeight);

    // Устанавливаем прозрачный фон
    imagealphablending($transparentWatermark, false);
    imagesavealpha($transparentWatermark, true);
    $transparentColor = imagecolorallocatealpha($transparentWatermark, 255, 255, 255, 127); // Полностью прозрачный цвет
    imagefill($transparentWatermark, 0, 0, $transparentColor);

    // Копируем водяной знак на новое изображение с заданной прозрачностью
    imagealphablending($watermarkImage, true);
    imagesavealpha($watermarkImage, true);
    imagecopyresampled($transparentWatermark, $watermarkImage, 0, 0, 0, 0, $watermarkWidth, $watermarkHeight, $watermarkWidth, $watermarkHeight);

    // Устанавливаем режим смешивания для полупрозрачности
    imagealphablending($transparentWatermark, true);

    // Накладываем водяной знак на оригинальное изображение с учетом полупрозрачности (господи помоги)
    imagecopy($originalImage, $transparentWatermark, $xPosition, $yPosition, 0, 0, $watermarkWidth, $watermarkHeight);

    imagepng($originalImage, $outputImages[$index]);

    // вот это мы освобождаем память (привет с++)
    imagedestroy($originalImage);
    imagedestroy($watermarkImage);
    imagedestroy($transparentWatermark);
}
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Изображения с Водяными Знаками</title>
</head>
<body>
    <h1>Изображения с Водяными Знаками</h1>
    
    <?php foreach ($outputImages as $outputImagePath): ?>
        <img src="<?php echo $outputImagePath; ?>" alt="Изображение с водяным знаком" style="display: block; margin: 20px auto;">
    <?php endforeach; ?>
</body>
</html>