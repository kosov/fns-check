<?php

namespace kosov\fnscheck\response;

use kosov\fnscheck\FnsCheckApiException;
use kosov\fnscheck\FnsCheckResponse;

/**
 * Class LoginResponse
 *
 * Класс ответа API авторизации пользователя.
 *
 * Если результат выполнения запроса на авторизацию был успешен,
 * то сервер возвращает данные пользователя в формате JSON.
 *
 * Более подробно о вариантах ответа сервера написано [здесь](https://habr.com/post/358966/).
 *
 * @package kosov\fnscheck\response
 * @author kosov <akosov@yandex.ru>
 */
class LoginResponse extends FnsCheckResponse
{
    /**
     * {@inheritdoc}
     */
    public function processHttpResponse()
    {
        if ($this->httpResponse->getStatusCode() === 200) {
            return;
        }

        throw new FnsCheckApiException($this->httpResponse->getBody()->getContents());
    }
}
