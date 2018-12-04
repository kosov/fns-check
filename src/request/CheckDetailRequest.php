<?php

namespace kosov\fnscheck\request;

use kosov\fnscheck\FnsCheckRequest;
use kosov\fnscheck\response\CheckDetailResponse;

/**
 * Class CheckDetailRequest
 *
 * Класс запроса на получение детальной информации по чеку.
 *
 * @package kosov\fnscheck\request
 * @author kosov <akosov@yandex.ru>
 */
class CheckDetailRequest extends FnsCheckRequest
{
    /**
     * Фискальный номер.
     *
     * @var string
     */
    public $fiscalNumber;

    /**
     * Фискальный признак документа.
     *
     * @var string
     */
    public $fiscalSign;

    /**
     * Фискальный документ.
     *
     * @var string
     */
    public $fiscalDocument;

    /**
     * Признак отправки чека на Email-адрес.
     *
     * @var string
     */
    public $sendToEmail = 'no';

    /**
     * {@inheritdoc}
     */
    public function getUrlPath()
    {
        return "/inns/*/kkts/*/fss/{$this->fiscalNumber}/tickets/{$this->fiscalDocument}";
    }

    /**
     * {@inheritdoc}
     */
    public function getHttpMethod()
    {
        return self::HTTP_METHOD_GET;
    }

    /**
     * {@inheritdoc}
     */
    public function getPayload()
    {
        return [
            'fiscalSign'  => $this->fiscalSign,
            'sendToEmail' => $this->sendToEmail,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getPayloadString()
    {
        return http_build_query($this->getPayload());
    }

    /**
     * {@inheritdoc}
     */
    public function getResponseClass()
    {
        return CheckDetailResponse::class;
    }
}
