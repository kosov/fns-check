<?php

namespace FnsCheck\request;

use FnsCheck\FnsCheckRequest;
use FnsCheck\response\LoginResponse;

/**
 * Class LoginRequest
 *
 * Класс запроса авторизации.
 *
 * @package FnsCheck\request
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
