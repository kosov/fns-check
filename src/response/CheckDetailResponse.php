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
     * Код ошибки существования чека.
     * Рекомендуется использовать при обработке загрузки чеков:
     * если исклюение имеет соответствующий код,
     * то необходимо повторить процедуру запроса чека.
     */
    const ERROR_CODE_REGISTERED_CHECK = 1;

    /**
     * {@inheritdoc}
     */
    public function processHttpResponse()
    {
        $httpStatusCode = $this->httpResponse->getStatusCode();

        if ($httpStatusCode === 200) {
            return;
        }

        if ($httpStatusCode !== 202) {
            throw new FnsCheckApiException($this->httpResponse->getBody()->getContents());
        } else {
            throw new FnsCheckApiException(
                'Check was registered. Try this call again.',
                self::ERROR_CODE_REGISTERED_CHECK
            );
        }
    }
}
