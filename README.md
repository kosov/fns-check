# Клиент для работы с API ФНС по проверке онлайн-чеков

## Возможности

Данная библиотека предоставляет возможности, аналогичные функционалу официального мобильного приложения ФНС по проверке онлайн-чеков, а именно:

- Регистрация нового пользователя;
- Авторизация пользователя;
- Восстановление пароля пользователя;
- Проверка существования чека;
- Получение детальной информации по чеку.

## Установка

Установка даннной библиотеки возможна только через [Composer](https://getcomposer.org/).

Так как библиотека использует HTTP клиент по стандарту [PSR-7](https://www.php-fig.org/psr/psr-7/), то вместе с библиотекой необходимо установить любой из доступных HTTP клиентов или адаптеров. Список поддерживаемых HTTP клиентов – http://docs.php-http.org/en/latest/clients.html. Подробнее об использовании можно почитать [здесь](http://docs.php-http.org/en/latest/httplug/users.html).

Выполните следующую команду (если вы хотите использовать php-http/curl-client в качестве HTTP клиента)
```
composer require php-http/curl-client guzzlehttp/psr7 php-http/message kosov/fns-check
```
в директории своего проекта или добавьте
```
"kosov/fns-check": "^1.1"
```
в секцию `require` файла `composer.json` вашего проекта.

## Быстрый старт

Ниже рассмотрен пример получения детальной информации по чеку. Все остальные примеры возможностей данной библиотеки рассмотрены [здесь](https://github.com/kosov/fns-check/tree/master/examples).

```php
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

// Авторизация пользователя по номеру телефона и паролю из SMS
$auth = new FnsCheckAuth('+79999999999', '111111');

$fnsCheckApi = new FnsCheckApi();

try {
    // Выполнение запроса к API ФНС
    $response = $fnsCheckApi->call(new CheckDetailRequest($checkData, $auth));

    // Еще один метод вызова того же API метода
    // $response = $fnsCheckApi->checkDetail($checkData, $auth);
    echo $response->getContents();
} catch (FnsCheckApiException $exception) {
    echo "Error: {$exception->getMessage()}";
}
```

Если вы работаете с данными QR-кода чека, то для формирования массива данных запроса можете использовать `FnsCheckHelper::fromQRCode`:

```php
<?php

require '../vendor/autoload.php';

use kosov\fnscheck\FnsCheckHelper;

// Строка данных, полученных из QR-кода
$qrCodeString = 't=20180812T2008&s=76.40&fn=8710000101375795&i=4901&fp=3307350167&n=1';

// Преобразование данных из формата ФНС в формат данных запроса
$normalizedData = FnsCheckHelper::fromQRCode($qrCodeString);

// $normalizedData может быть сохранена для дальнейшего использования в качестве аргумента функций запросов
var_dump($normalizedData);
```

## Возможные проблемы и их решения

При получении детальной информации по чеку вы можете получить ошибку `illegal public api usage`. Чтобы этого не происходило, необходимо выполнять запросы в следующем порядке:
1. Отправляем запрос на проверку существования чека. Если все хорошо, то получим код ответа сервера 204.
2. Отправляем запрос на получение детальной информации по чеку. Если все хорошо, то получим код ответа сервера 202.
3. Отправляем еще один запрос на получение детальной информации по чеку. Вместе с кодом ответа сервера 200 вы получите json с данными чека.

## Лицензия

Библиотека доступна на условиях лицензии [MIT](http://www.opensource.org/licenses/mit-license.php).
