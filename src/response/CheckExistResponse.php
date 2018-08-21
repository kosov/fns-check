<?php

namespace FnsCheck\response;

use FnsCheck\FnsCheckApiException;
use FnsCheck\FnsCheckResponse;

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
 * @package FnsCheck\response
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
