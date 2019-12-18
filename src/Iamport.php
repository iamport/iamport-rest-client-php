<?php

namespace Iamport\RestClient;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Exception\ExceptionHandler;
use Iamport\RestClient\Exception\IamportException;
use Iamport\RestClient\Middleware\DefaultRequestMiddleware;
use Iamport\RestClient\Middleware\TokenMiddleware;
use Iamport\RestClient\Request\RequestBase;
use Iamport\RestClient\Response\AuthResponse;
use Iamport\RestClient\Response\Collection;
use Iamport\RestClient\Response\Item;
use Iamport\RestClient\Response\TokenResponse;

/**
 * Class Iamport.
 */
class Iamport extends IamportBase
{
    /**
     * Iamport constructor.
     */
    public function __construct(string $impKey, string $impSecret)
    {
        parent::__construct($impKey, $impSecret);
    }

    protected function isTokenExpired(): bool
    {
        $now = time();

        return null === $this->accessToken || ($this->expireTimestamp - self::EXPIRE_BUFFER) < $now;
    }

    public function callApi(RequestBase $request): Result
    {
        try {
            $method         = $request->verb();
            $uri            = $request->path();
            $attributes     = $request->attributes();
            $responseClass  = $request->responseClass;
            $client         = $request->client ?? null;
            $isCollection   = $request->isCollection;

            $parseResponse = $this->request($method, $uri, $attributes, $client);
            $response      = $parseResponse->response;

            // TODO: NaverPayment::point, NaverPayment::confirm 테스트 필요
            if ($responseClass === 'string') {
                $result = $parseResponse->message;
            } else {
                if ($isCollection) {
                    $result = (new Collection($response, $request, $parseResponse->isMultiStatus));
                } else {
                    $result = (new Item($response, $responseClass))->getClassAs();
                }
            }

            return new Result($result, null, $request->extraCondition);
        } catch (GuzzleException $e) {
            return ExceptionHandler::render($e);
        } catch (Exception $e) {
            return ExceptionHandler::render($e);
        }
    }

    /**
     * @return PromiseInterface|Result
     */
    public function callApiPromise(RequestBase $request)
    {
        try {
            $method        = $request->verb();
            $uri           = $request->path();
            $attributes    = $request->attributes();
            $client        = $request->client ?? null;

            return $this->requestPromise($method, $uri, $attributes, $client);
        } catch (GuzzleException $e) {
            return ExceptionHandler::render($e);
        } catch (Exception $e) {
            return ExceptionHandler::render($e);
        }
    }

    /**
     * @return mixed
     *
     * @throws GuzzleException
     */
    public function request(string $method, string $uri, array $attributes = [], Client $customClient = null)
    {
        try {
            $client     = $customClient ?? $this->getHttpClient(true);
            $response   = $client->request($method, $uri, $attributes);
            $statusCode = $response->getStatusCode();

            $parseResponse = (object) json_decode($response->getBody(), true);

            if (0 !== $parseResponse->code || is_null($parseResponse->response)) {
                throw new IamportException($parseResponse, new Request($method, $uri), null);
            }

            /* @var bool $isMultiStatus */
            $parseResponse->isMultiStatus = false;
            if ($statusCode === 207) {
                $parseResponse->isMultiStatus = true;
            }

            return $parseResponse;
        } catch (Exception $e) {
            ExceptionHandler::report($e);
        }
    }

    public function requestPromise(string $method, string $uri, array $attributes = [], Client $customClient = null): PromiseInterface
    {
        try {
            $client   = $customClient ?? $this->getHttpClient(true);

            return $client->requestAsync($method, $uri, $attributes);
        } catch (Exception $e) {
            ExceptionHandler::report($e);
        }
    }

    public function getCustomHttpClient(HandlerStack $handlerStack): Client
    {
        $handlerStack->push(new DefaultRequestMiddleware());

        return new Client([
            'handler'  => $handlerStack,
            'base_uri' => Endpoint::API_BASE_URL,
        ]);
    }

    /**
     * @throws \Exception
     */
    protected function getHttpClient(bool $authenticated): Client
    {
        $stack = HandlerStack::create();
        $stack->push(new DefaultRequestMiddleware());

        if ($authenticated) {
            $token = $this->requestAccessToken(false);
            $stack->push(new TokenMiddleware($token));
        }

        return new Client([
            'handler'  => $stack,
            'base_uri' => Endpoint::API_BASE_URL,
        ]);
    }

    /**
     * @throws Exception
     */
    public function requestAccessToken(bool $force = false): ?string
    {
        if (!$this->isTokenExpired() && !$force) {
            return $this->accessToken;
        }

        try {
            $httpClient = $this->getHttpClient(false);

            $authUrl  = Endpoint::TOKEN;
            $response = new TokenResponse($httpClient->post($authUrl, [
                RequestOptions::JSON => [
                    'imp_key'    => $this->impKey,
                    'imp_secret' => $this->impSecret,
                ],
            ]));

            $auth = $response->getResponseAs(AuthResponse::class);

            $this->accessToken = $auth->getAccessToken();
            //호출하는 서버의 시간이 동기화되어있지 않을 가능성 고려 ( 로컬 서버 타임기준 계산 )
            $this->expireTimestamp = time() + $auth->getRemaindSeconds();

            return $this->accessToken;
        } catch (GuzzleException $e) {
            ExceptionHandler::report($e);
        }
    }
}
