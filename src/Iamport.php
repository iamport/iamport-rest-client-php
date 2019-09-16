<?php

namespace Iamport\RestClient;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\RequestOptions;
use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Exception\Handler;
use Iamport\RestClient\Exception\IamportAuthException;
use Iamport\RestClient\Exception\IamportRequestException;
use Iamport\RestClient\Middleware\DefaultRequestMiddleware;
use Iamport\RestClient\Middleware\TokenMiddleware;
use Iamport\RestClient\Request\RequestBase;
use Iamport\RestClient\Response\AuthResponse;
use Iamport\RestClient\Response\PagedResponse;
use Iamport\RestClient\Response\Response;
use Iamport\RestClient\Response\TokenResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Iamport.
 */
class Iamport
{
    const EXPIRE_BUFFER = 30;

    /**
     * @var string
     */
    private $impKey          = null;

    /**
     * @var string
     */
    private $impSecret       = null;
    /**
     * @var string|null
     */
    private $accessToken     = null;
    /**
     * @var int
     */
    private $expireTimestamp = 0;

    /**
     * Iamport constructor.
     *
     * @param string $impKey
     * @param string $impSecret
     */
    public function __construct(string $impKey, string $impSecret)
    {
        $this->impKey    = $impKey;
        $this->impSecret = $impSecret;
    }

    /**
     * @return string|null
     */
    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    /**
     * @return bool
     */
    public function isTokenExpired(): bool
    {
        $now = time();

        return null === $this->accessToken || ($this->expireTimestamp - self::EXPIRE_BUFFER) < $now;
    }

    /**
     * @param bool $force
     *
     * @return string|null
     *
     * @throws IamportAuthException
     * @throws Exception
     */
    public function requestAccessToken(bool $force): ?string
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
        } catch (ConnectException $e) {
            throw new Exception('RequestTrait Error(HTTP STATUS : '.$e->getcode().')', $e->getHandlerContext()['errno']);
        } catch (Exception $e) {
            $errorResponse = json_decode($e->getResponse()->getBody());
            throw new IamportAuthException('[API인증오류] '.$errorResponse->message, $errorResponse->code);
        }
    }

    /**
     * @param bool $authenticated
     *
     * @return Client
     *
     * @throws IamportAuthException
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
     * @param string $method
     * @param string $uri
     * @param array  $attributes
     * @param bool   $authenticated
     *
     * @return object|array
     *
     * @throws Exception
     */
    public function request(string $method, string $uri, array $attributes = [], bool $authenticated = true)
    {
        try {
            $client   = $this->getHttpClient($authenticated);
            $response = $client->request($method, $uri, $attributes);

            $parseResponse = (object) json_decode($response->getBody(), true);
            if (0 !== $parseResponse->code) {
                throw new IamportRequestException($parseResponse);
            }
            if (!$parseResponse->response) {
                throw new Exception('API서버로부터 응답이 올바르지 않습니다. '.$parseResponse, 1);
            }

            return $parseResponse->response;
        } catch (GuzzleException $e) {
            Handler::report($e);
        } catch (Exception $e) {
            Handler::report($e);
        }
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array  $attributes
     * @param bool   $authenticated
     *
     * @return PromiseInterface
     *
     * @throws IamportAuthException
     * @throws IamportRequestException
     */
    public function requestPromise(string $method, string $uri, array $attributes = [], bool $authenticated = true): PromiseInterface
    {
        try {
            $client   = $this->getHttpClient($authenticated);
            $promise  = $client->requestAsync($method, $uri, $attributes);

            $promise->then(
                function (ResponseInterface $response) {
                    $parseResponse = json_decode($response->getBody());
                    if (0 !== $parseResponse->code) {
                        throw new IamportRequestException($parseResponse);
                    }
                    if (!$parseResponse->response) {
                        throw new Exception('API서버로부터 응답이 올바르지 않습니다. '.$parseResponse, 1);
                    }
                },
                function (RequestException $e) {
                    throw new IamportRequestException($e);
                }
            );

            return $promise;
        } catch (Exception $e) {
            Handler::report($e);
        }
    }

    /**
     * @param RequestBase $request
     *
     * @return Result
     */
    public function callApi(RequestBase $request): Result
    {
        try {
            $method        = $request->verb();
            $uri           = $request->path();
            $attributes    = $request->attributes();
            $responseType  = $request->responseType;
            $authenticated = $request->authenticated;

            $response = $this->request($method, $uri, $attributes, $authenticated);

            switch ($responseType) {
                case 'paged':
                    $result = new PagedResponse((object) $response);
                    break;
                default:
                    $result  = new Response((object) $response);
                    break;
            }

            return new Result(true, $result);
        } catch (Exception $e) {
            return Handler::render($e);
        }
    }

    /**
     * @param RequestBase $request
     *
     * @return PromiseInterface|Result
     */
    public function callApiPromise(RequestBase $request)
    {
        try {
            $method        = $request->verb();
            $uri           = $request->path();
            $attributes    = $request->attributes();
            $authenticated = $request->authenticated;

            return $this->requestPromise($method, $uri, $attributes, $authenticated);
        } catch (Exception $e) {
            return Handler::render($e);
        }
    }
}
