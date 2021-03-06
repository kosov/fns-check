<?php

require '../vendor/autoload.php';

use kosov\fnscheck\FnsCheckApi;
use kosov\fnscheck\request\SignupRequest;
use kosov\fnscheck\FnsCheckApiException;

// Данные нового пользователя
$signupData = [
    'email' => 'youremail@address.com',
    'name'  => 'YourName',
    'phone' => '+79999999999',
];

$fnsCheckApi = new FnsCheckApi();

try {
    $fnsCheckApi->call(new SignupRequest($signupData));

    // Еще один метод вызова того же API метода
    // $fnsCheckApi->signup($signupData);
    echo 'Вам отправлена SMS с паролем.';
} catch (FnsCheckApiException $exception) {
    echo "Error: {$exception->getMessage()}";
}
