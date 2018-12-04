<?php

namespace kosov\fnscheck\request;

use kosov\fnscheck\FnsCheckRequest;
use kosov\fnscheck\response\LoginResponse;

/**
 * Class LoginRequest
 *
 * Класс запроса авторизации.
 *
 * @package kosov\fnscheck\request
 * @author kosov <akosov@yandex.ru>
 */
class LoginRequest extends FnsCheckRequest
{
    /**
     * {@inheritdoc}
     */
    public function getUrlPath()
    {
        return '/mobile/users/login/';
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
        return [];
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
        return LoginResponse::class;
    }
}
