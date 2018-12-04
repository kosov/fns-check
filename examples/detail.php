<?php

require '../vendor/autoload.php';

use kosov\fnscheck\FnsCheckAuth;
use kosov\fnscheck\FnsCheckApi;
use kosov\fnscheck\request\CheckDetailRequest;
use kosov\fnscheck\FnsCheckApiException;

// Атрибуты чека
$checkData = [
    'fiscalNumber'   => '8710000101606774', // "ФН" в чеке
    'fiscalSign'     => '0211560320',       // "ФП" в чеке
    'fiscalDocument' => '0000136962',       // "ФД" в чеке
];

// Авторизация пользователя
$auth = new FnsCheckAuth('+79999999999', '111111');

$fnsCheckApi = new FnsCheckApi();

try {
    $response = $fnsCheckApi->call(new CheckDetailRequest($checkData, $auth));

    // Еще один метод вызова того же API метода
    // $response = $fnsCheckApi->checkDetail($checkData, $auth);
    echo $response->getContents();
} catch (FnsCheckApiException $exception) {
    echo "Error: {$exception->getMessage()}";
}
