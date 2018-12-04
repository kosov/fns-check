<?php

namespace kosov\fnscheck\request;

use kosov\fnscheck\FnsCheckRequest;
use kosov\fnscheck\response\RestoreResponse;

/**
 * Class RestoreRequest
 *
 * Класс запроса восстановления пароля.
 *
 * @package kosov\fnscheck\request
 * @author kosov <akosov@yandex.ru>
 */
class RestoreRequest extends FnsCheckRequest
{
    /**
     * Телефон пользователя.
     *
     * @var string
     */
    public $phone;

    /**
     * {@inheritdoc}
     */
    public function getUrlPath()
    {
        return '/mobile/users/restore/';
    }

    /**
     * {@inheritdoc}
     */
    public function getHttpMethod()
    {
        return self::HTTP_METHOD_POST;
    }

    /**
     * {@inheritdoc}
     */
    public function getPayload()
    {
        return [
            'phone' => $this->phone,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getPayloadString()
    {
        return json_encode($this->getPayload());
    }

    /**
     * {@inheritdoc}
     */
    public function getResponseClass()
    {
        return RestoreResponse::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaders()
    {
        return array_merge(parent::getHeaders(), [
            'Content-Type' => 'application/json; charset=UTF-8',
        ]);
    }
}
