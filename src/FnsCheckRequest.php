<?php

namespace kosov\fnscheck;

use Psr\Http\Message\ResponseInterface;

/**
 * Class FnsCheckRequest
 *
 * Базовый класс запроса к API ФНС по работе с электронными чеками.
 *
 * @package kosov\fnscheck
 * @author kosov <akosov@yandex.ru>
 */
abstract class FnsCheckRequest
{
    /**
     * Базовый URL API ФНС по работе с электронными чеками.
     */
    const BASE_FNS_URL = 'https://proverkacheka.nalog.ru:9999/v1';

    /**
     * HTTP метод запроса "GET".
     */
    const HTTP_METHOD_GET = 'GET';

    /**
     * HTTP метод запроса "POST".
     */
    const HTTP_METHOD_POST = 'POST';

    /**
     * ID устройства.
     *
     * @var string
     */
    private $deviceId;

    /**
     * Версия операционной системы устройства.
     *
     * @var string
     */
    private $deviceOs;

    /**
     * Объект аутентификации пользователя.
     *
     * @var FnsCheckAuth
     */
    private $auth;

    /**
     * Возвращает URL адреса запроса.
     *
     * @return string
     */
    abstract public function getUrlPath();

    /**
     * Возвращает название HTTP метода запроса.
     *
     * @return string
     */
    abstract public function getHttpMethod();

    /**
     * Возвращает массив параметров запроса.
     *
     * @return array
     */
    abstract public function getPayload();

    /**
     * Возвращает параметры запроса в виде строки.
     *
     * @return string Параметры запроса
     */
    abstract public function getPayloadString();

    /**
     * Возвращает название класса ответа сервера API.
     *
     * @return string Название класса ответа сервера API
     */
    abstract public function getResponseClass();

    /**
     * FnsCheckRequest конструктор.
     *
     * @param array $config Параметры запроса
     * @param FnsCheckAuth $auth Объект аутентификации пользователя
     */
    public function __construct(array $config = [], FnsCheckAuth $auth = null)
    {
        $this->configure($config);
        $this->setAuth($auth);
    }

    /**
     * Устанавливает объект аутентификации пользователя.
     *
     * @param FnsCheckAuth $auth Объект аутентификации пользователя
     */
    public function setAuth(FnsCheckAuth $auth = null)
    {
        $this->auth = $auth;
    }

    /**
     * Возвращает объект аутентификации пользователя.
     *
     * @return FnsCheckAuth Объект аутентификации пользователя
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * Возвращает полный URL адреса запроса.
     *
     * @return string
     */
    public function getUrl()
    {
        $url = self::BASE_FNS_URL . $this->getUrlPath();

        if ($this->getHttpMethod() === self::HTTP_METHOD_GET) {
            $url .= '?' . http_build_query($this->getPayload());
        }

        return $url;
    }

    /**
     * Возвращает объект ответа сервера API.
     *
     * @param ResponseInterface $httpResponse Объект HTTP ответа сервера API
     *
     * @return FnsCheckResponse Объект ответа сервера API
     */
    public function getResponse(ResponseInterface $httpResponse)
    {
        $responseClass = $this->getResponseClass();

        return new $responseClass($httpResponse);
    }

    /**
     * Устанавливает ID устройства.
     *
     * @param string $deviceId ID устройства
     */
    public function setDeviceId($deviceId)
    {
        $this->deviceId = (string) $deviceId;
    }

    /**
     * Возвращает ID устройства.
     * Если ID устройства не был установлен,
     * то возвращается случайно сгенерированная строка.
     * Рекомендуется указывать корректный ID устройства.
     *
     * @return string ID устройства
     */
    public function getDeviceId()
    {
        return $this->deviceId ?: md5(mt_rand());
    }

    /**
     * Устанавливает версию операционной системы устройства.
     *
     * @param string $deviceOs Версия операционной системы устройства.
     */
    public function setDeviceOs($deviceOs)
    {
        $this->deviceOs = (string) $deviceOs;
    }

    /**
     * Возвращает версию операционной системы устройства.
     * Если версию операционной системы устройства не была установлена,
     * то возвращается случайно сгенерированная строка.
     * Рекомендуется указывать корректную
     * версию операционной системы устройства.
     *
     * @return string Версия операционной системы устройства
     */
    public function getDeviceOs()
    {
        return $this->deviceOs ?: md5(mt_rand());
    }

    /**
     * Возвращает массив заголовков запроса.
     *
     * @return array Массив заголовков запроса
     */
    public function getHeaders()
    {
        return [
            'device-id' => $this->getDeviceId(),
            'device-os' => $this->getDeviceOs(),
        ];
    }

    /**
     * Выполняет конфигурацию запроса.
     *
     * @param array $config Параметры запроса
     */
    private function configure(array $config = [])
    {
        foreach ($config as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }
}
