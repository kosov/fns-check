<?php

require '../vendor/autoload.php';

use FnsCheck\FnsCheckHelper;

// Строка данных, полученных из QR-кода
$qrCodeString = 't=20180812T2008&s=76.40&fn=8710000101375795&i=4901&fp=3307350167&n=1';

// Преобразование данных из формата ФНС в формат данных запроса
$normalizedData = FnsCheckHelper::fromQRCode($qrCodeString);

foreach ($normalizedData as $key => $value) {
    echo "{$key}: {$value}<br/>";
}
