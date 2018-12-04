<?php

namespace kosov\fnscheck\request;

use kosov\fnscheck\FnsCheckRequest;
use kosov\fnscheck\response\SignupResponse;

/**
 * Class SignupRequest
 *
 * Класс запроса регистрации.
 *
 * @package kosov\fnscheck\request
 * @author kosov <akosov@yandex.ru>
 */
class SignupRequest extends FnsCheckRequest
{
    /**
     * Email пользователя.
     *
     * @var string
     */
    public $email;

    /**
     * Имя пользователя.
     *
     * @var string
     */
    public $name;

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
        return '/mobile/users/signup/';
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
            'email' => $this->email,
            'name'  => $this->name,
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
        return SignupResponse::class;
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
