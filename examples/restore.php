<?php

require '../vendor/autoload.php';

use kosov\fnscheck\FnsCheckApi;
use kosov\fnscheck\request\RestoreRequest;
use kosov\fnscheck\FnsCheckApiException;

// Данные для восстановления пароля пользователя
$restoreData = [
    'phone' => '+79999999999',
];

$fnsCheckApi = new FnsCheckApi();

try {
    $fnsCheckApi->call(new RestoreRequest($restoreData));

    // Еще один метод вызова того же API метода
    // $fnsCheckApi->restore($restoreData);
    echo 'Вам отправлена SMS с новым паролем.';
} catch (FnsCheckApiException $exception) {
    echo "Error: {$exception->getMessage()}";
}
