<?php

require '../vendor/autoload.php';

use FnsCheck\FnsCheckAuth;
use FnsCheck\FnsCheckApi;
use FnsCheck\request\CheckExistRequest;
use FnsCheck\FnsCheckApiException;

// Атрибуты чека
$checkData = [
    'fiscalNumber'   => '9289000100087727', // "ФН" в чеке
    'fiscalSign'     => '3385572166',       // "ФП" в чеке
    'fiscalDocument' => '5276',             // "ФД" в чеке
    'date'           => '17.08.2018 09:26', // Дата создания чека
    'operation'      => 1,                  // Тип операции "Приход"
    'sum'            => 26500,              // Сумма чека в копейках
];

// Авторизация пользователя
$auth = new FnsCheckAuth('+79999999999', '111111');

$fnsCheckApi = new FnsCheckApi();

try {
    $response = $fnsCheckApi->call(new CheckExistRequest($checkData, $auth));

    // Еще один метод вызова того же API метода
    // $response = $fnsCheckApi->checkExist($checkData, $auth);
    echo 'Чек найден.';
} catch (FnsCheckApiException $exception) {
    echo "Error: {$exception->getMessage()}";
}
