<?php

namespace kosov\fnscheck;

use Http\Message\Authentication\BasicAuth;

/**
 * Class FnsCheckAuth
 *
 * Класс аутентификации пользователя.
 *
 * @package kosov\fnscheck
 * @author kosov <akosov@yandex.ru>
 */
class FnsCheckAuth
{
    /**
     * Логин пользователя.
     * В качестве логина пользователя выступает
     * его телефон в формате +7XXXXXXXXXX.
     *
     * @var string
     */
    private $username;

    /**
     * Пароль пользователя.
     * Пароль пользователя приходит в SMS,
     * отправляемой при регистрации или восстановлении пароля.
     *
     * @var string
     */
    private $password;

    /**
     * FnsCheckAuth конструктор.
     *
     * @param string $username Логин пользователя
     * @param string $password Пароль пользователя
     */
    public function __construct($username, $password)
    {
        $this->setUsername($username);
        $this->setPassword($password);
    }

    /**
     * Устанавливает логин пользователя.
     *
     * @param string $username Логин пользователя
     */
    public function setUsername($username)
    {
        $this->username = (string) $username;
    }

    /**
     * Возвращает логин пользователя.
     *
     * @return string Логин пользователя
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Устанавливает пароль пользователя.
     *
     * @param string $password Пароль пользователя
     */
    public function setPassword($password)
    {
        $this->password = (string) $password;
    }

    /**
     * Возвращает пароль пользователя.
     *
     * @return string Пароль пользователя
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Возвращает объект HTTP-Basic аутентификаци пользователя.
     *
     * @return BasicAuth Объект HTTP-Basic аутентификаци
     */
    public function getHttpAuthentication()
    {
        return new BasicAuth($this->username, $this->password);
    }
}
