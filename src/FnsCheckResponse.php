<?php

namespace kosov\fnscheck;

use Psr\Http\Message\ResponseInterface;

/**
 * Class FnsCheckResponse
 *
 * Базовый класс ответа сервера API ФНС по работе с электронными чеками.
 *
 * @package kosov\fnscheck
 * @author kosov <akosov@yandex.ru>
 */
abstract class FnsCheckResponse
{
    /**
     * Объект HTTP ответа сервера API.
     *
     * @var ResponseInterface
     */
    protected $httpResponse;

    /**
     * Обрабатывает HTTP ответ сервера API.
     *
     * @throws FnsCheckApiException Исключение обработки запроса к API
     */
    abstract public function processHttpResponse();

    /**
     * FnsCheckResponse конструктор.
     *
     * @param ResponseInterface $response Объект HTTP ответа сервера API
     */
    public function __construct(ResponseInterface $response)
    {
        $this->httpResponse = $response;
    }

    /**
     * Возвращает объект HTTP ответа сервера API.
     *
     * @return ResponseInterface Объект HTTP ответа сервера API
     */
    public function getHttpResponse()
    {
        return $this->httpResponse;
    }

    /**
     * Возвращает тело ответа сервера API.
     *
     * @return string
     */
    public function getContents()
    {
        return $this->httpResponse->getBody()->getContents();
    }
}
