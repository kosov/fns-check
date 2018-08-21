<?php

require '../vendor/autoload.php';

use FnsCheck\FnsCheckAuth;
use FnsCheck\FnsCheckApi;
use FnsCheck\request\LoginRequest;
use FnsCheck\FnsCheckApiException;

// Данные пользователя
$auth = new FnsCheckAuth('+79999999999', '111111');

$fnsCheckApi = new FnsCheckApi();

try {
    $response = $fnsCheckApi->call(new LoginRequest([], $auth));

    // Еще один метод вызова того же API метода
    // $response = $fnsCheckApi->login([], $auth);
    echo $response->getContents();
} catch (FnsCheckApiException $exception) {
    echo "Error: {$exception->getMessage()}";
}
