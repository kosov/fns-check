<?php

namespace kosov\fnscheck\response;

use kosov\fnscheck\FnsCheckApiException;
use kosov\fnscheck\FnsCheckResponse;

/**
 * Class CheckDetailResponse
 *
 * Класс ответа API с детальной информации по чеку.
 *
 * Если чек не найден, то возвращается "406 Not Acceptable".
 * Если перед вызовом метода не происходила проверка существования чека,
 * то вернется "202 Accepted" (без сообщений и любого содержимого).
 * При повторном вызове информация по чеку вернется.
 *
 * Более подробно о вариантах ответа сервера написано [здесь](https://habr.com/post/358966/).
 *
 * @package kosov\fnscheck\response
 * @author kosov <akosov@yandex.ru>
 */
class CheckDetailResponse extends FnsCheckResponse
{
    /**
     * {@inheritdoc}
     */
    public function processHttpResponse()
    {
        $httpStatusCode = $this->httpResponse->getStatusCode();

        if ($httpStatusCode === 200) {
            return;
        }

        $message = $httpStatusCode !== 202 ?
            $this->httpResponse->getBody()->getContents() :
            'Check was registered. Try this call again.';

        throw new FnsCheckApiException($message);
    }
}
