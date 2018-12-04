<?php

namespace kosov\fnscheck\response;

use kosov\fnscheck\FnsCheckApiException;
use kosov\fnscheck\FnsCheckResponse;

/**
 * Class RestoreResponse
 *
 * Класс ответа API восстановления пароля пользователя.
 *
 * Если результат выполнения запроса на восстановление пароля был успешен,
 * то пользователь получает SMS с новым паролем для входа
 * на указанный номер, а в ответе сервера возвращается "204 No content".
 *
 * Более подробно о вариантах ответа сервера написано [здесь](https://habr.com/post/358966/).
 *
 * @package kosov\fnscheck\response
 * @author kosov <akosov@yandex.ru>
 */
class RestoreResponse extends FnsCheckResponse
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
