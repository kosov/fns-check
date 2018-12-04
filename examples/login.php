<?php

require '../vendor/autoload.php';

use kosov\fnscheck\FnsCheckAuth;
use kosov\fnscheck\FnsCheckApi;
use kosov\fnscheck\request\LoginRequest;
use kosov\fnscheck\FnsCheckApiException;

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
