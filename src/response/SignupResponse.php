<?php

namespace FnsCheck\response;

use FnsCheck\FnsCheckApiException;
use FnsCheck\FnsCheckResponse;

/**
 * Class SignupResponse
 *
 * Класс ответа API регистрации пользователя.
 *
 * Если результат выполнения запроса на регистрацию был успешен,
 * то пользователь получает SMS с паролем для входа
 * на указанный номер, а в ответе сервера возвращается "204 No content".
 *
 * Более подробно о вариантах ответа сервера написано [здесь](https://habr.com/post/358966/).
 *
 * @package FnsCheck\response
 * @author kosov <akosov@yandex.ru>
 */
class SignupResponse extends FnsCheckResponse
{
    /**
     * {@inheritdoc}
     */
    public function processHttpResponse()
    {
        if ($this->httpResponse->getStatusCode() === 204) {
            return;
        }

        throw new FnsCheckApiException($this->httpResponse->getBody()->getContents());
    }
}
