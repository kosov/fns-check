<?php

namespace kosov\fnscheck\request;

use kosov\fnscheck\FnsCheckRequest;
use kosov\fnscheck\response\CheckExistResponse;

/**
 * Class CheckExistRequest
 *
 * Класс запроса проверки существования чека.
 *
 * @package kosov\fnscheck\request
 * @author kosov <akosov@yandex.ru>
 */
class CheckExistRequest extends FnsCheckRequest
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
     * Дата создания чека.
     *
     * @var string
     */
    public $date;

    /**
     * Сумма чека в копейках.
     *
     * @var int
     */
    public $sum;

    /**
     * Тип операции "приход/расход".
     * "Приход" = 1
     * "Расход" = 0
     *
     * @var int
     */
    public $operation;

    /**
     * {@inheritdoc}
     */
    public function getUrlPath()
    {
        return "/ofds/*/inns/*/fss/{$this->fiscalNumber}/operations/1/tickets/{$this->fiscalDocument}";
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
            'fiscalSign' => $this->fiscalSign,
            'date'       => date(DATE_ATOM, strtotime($this->date)),
            'sum'        => $this->sum,
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
        return CheckExistResponse::class;
    }
}
