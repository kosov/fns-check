<?php

namespace kosov\fnscheck\response;

use kosov\fnscheck\FnsCheckApiException;
use kosov\fnscheck\FnsCheckResponse;

/**
 * Class CheckExistResponse
 *
 * Класс ответа API проверки существования чека.
 *
 * "204 No Content" возвращается в случае существования чека.
 * В случае несуществования чека или в случае несовпадения даты/суммы возвращается "406 Not Acceptable".
 * Если параметры даты и суммы не указаны, то возвращается "400 Bad Request" с соответствующим текстом ошибки.
 *
 * Более подробно о вариантах ответа сервера написано [здесь](https://habr.com/post/358966/).
 *
 * @package kosov\fnscheck\response
 * @author kosov <akosov@yandex.ru>
 */
class CheckExistResponse extends FnsCheckResponse
{
    /**
     * {@inheritdoc}
     */
    public function processHttpResponse()
    {
        $httpStatusCode = $this->httpResponse->getStatusCode();

        if ($httpStatusCode === 204) {
            return;
        }

        throw new FnsCheckApiException($this->httpResponse->getBody()->getContents());
    }
}
