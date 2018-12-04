<?php

namespace kosov\fnscheck;

use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\RequestFactory;
use Http\Client\Exception as HttpException;
use Exception;
use ReflectionClass;

/**
 * Class FnsCheckApi
 *
 * Класс генерации и выполнения запросов к API ФНС
 * по работе с электронными чеками.
 *
 * @package kosov\fnscheck
 * @author kosov <akosov@yandex.ru>
 *
 * @method \kosov\fnscheck\response\SignupResponse signup(array $config = [], FnsCheckAuth $auth = null)
 * @method \kosov\fnscheck\response\RestoreResponse restore(array $config = [], FnsCheckAuth $auth = null)
 * @method \kosov\fnscheck\response\LoginResponse login(array $config = [], FnsCheckAuth $auth = null)
 * @method \kosov\fnscheck\response\CheckExistResponse checkExist(array $config = [], FnsCheckAuth $auth = null)
 * @method \kosov\fnscheck\response\CheckDetailResponse checkDetail(array $config = [], FnsCheckAuth $auth = null)
 */
class FnsCheckApi
{
    /**
     * HTTP клиент для работы с API.
     *
     * @var HttpClient
     */
    private $httpClient;

    /**
     * Объект фабрики PSR-7 запросов.
     *
     * @var RequestFactory
     */
    private $requestFactory;

    /**
     * FnsCheckApi constructor.
     *
     * Если HTTP клиент для работы с API не был установлен самостоятельно,
     * HttpClientDiscovery::find() пытается сам найти подходящий.
     *
     * @see http://docs.php-http.org/en/latest/discovery.html#http-client-discovery
     *
     * @param HttpClient|null $httpClient HTTP клиент для работы с API
     */
    public function __construct(HttpClient $httpClient = null)
    {
        $this->setHttpClient($httpClient ?: HttpClientDiscovery::find());
    }

    /**
     * Отправляет указанный запрос к API ФНС по работе с электронными чеками.
     *
     * @param FnsCheckRequest $request Объект запроса к API
     *
     * @return FnsCheckResponse Объект ответа API
     *
     * @throws FnsCheckApiException Исключение обработки запроса к API
     */
    public function call(FnsCheckRequest $request)
    {
        $requestBody = $request->getHttpMethod() !== FnsCheckRequest::HTTP_METHOD_GET ?
            $request->getPayloadString() : null;

        $httpRequest = $this->getRequestFactory()->createRequest(
            $request->getHttpMethod(),
            $request->getUrl(),
            $request->getHeaders(),
            $requestBody
        );

        if ($request->getAuth() instanceof FnsCheckAuth) {
            $httpRequest = $request->getAuth()->getHttpAuthentication()->authenticate($httpRequest);
        }

        try {
            $httpResponse = $this->getHttpClient()->sendRequest($httpRequest);
        } catch (HttpException $httpException) {
            throw new FnsCheckApiException("HTTP Exception: {$httpException->getMessage()}");
        } catch (Exception $exception) {
            throw new FnsCheckApiException($exception->getMessage());
        }

        $response = $request->getResponse($httpResponse);
        $response->processHttpResponse();

        return $response;
    }

    /**
     * Устанавливает объект HTTP клиента для работы с API.
     *
     * @param HttpClient $httpClient HTTP клиент
     */
    public function setHttpClient(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Возвращает объект HTTP клиента для работы с API.
     *
     * @return HttpClient HTTP клиент
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * Устанавливает объект фабрики для генерации PSR-7 запросов.
     *
     * @param RequestFactory $requestFactory Объект фабрики PSR-7 запросов
     */
    public function setRequestFactory(RequestFactory $requestFactory)
    {
        $this->requestFactory = $requestFactory;
    }

    /**
     * Возвращает объект фабрики для генерации PSR-7 запросов.
     * Если объект фабрики запросов не был установлен самостоятельно,
     * MessageFactoryDiscovery::find() пытается сам найти подходящий.
     *
     * @see http://docs.php-http.org/en/latest/discovery.html#psr-7-message-factory-discovery
     *
     * @return RequestFactory Объект фабрики PSR-7 запросов
     */
    public function getRequestFactory()
    {
        if (!$this->requestFactory) {
            $this->requestFactory = MessageFactoryDiscovery::find();
        }

        return $this->requestFactory;
    }

    /**
     * Выполняет запрос к API ФНС по работе с электронными чеками.
     * Вызов метода отправки запроса через магический метод __call().
     *
     * @param string $name Название метода API
     * @param array $arguments Список аргументов метода
     *
     * @return FnsCheckResponse Объект ответа API
     *
     * @throws Exception Выбрасывается при отсутствии вызываемого метода в API
     */
    public function __call($name, $arguments)
    {
        $requestClass = __NAMESPACE__ . '\\request\\' . ucfirst($name) . 'Request';

        if (!class_exists($requestClass)) {
            throw new Exception("Undefined API method '{$name}'.");
        }

        /** @var FnsCheckRequest $request */
        if (count($arguments) === 0) {
            $request = new $requestClass;
        } else {
            $reflection = new ReflectionClass($requestClass);
            $request    = $reflection->newInstanceArgs($arguments);
        }

        return $this->call($request);
    }
}
