<?php

namespace Iamport\RestClient;

use Exception;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\PromiseInterface;
use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Exception\Handler;
use Iamport\RestClient\Exception\IamportAuthException;
use Iamport\RestClient\Exception\IamportRequestException;
use Iamport\RestClient\Response\Auth;
use Iamport\RestClient\Response\PagedResponse;
use Iamport\RestClient\Response\Response;
use Iamport\RestClient\Response\TokenResponse;
use Iamport\RestClient\Middleware\TokenMiddleware;
use Iamport\RestClient\Middleware\DefaultRequestMiddleware;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\ResponseInterface;

/**
 * Class IamportBase.
 */
class IamportBase
{
    const EXPIRE_BUFFER = 30;

    /** @var string $impKey define here what this variable is for, do this for every instance variable */
    private $impKey          = null;
    private $impSecret       = null;
    private $accessToken     = null;
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
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @return bool
     */
    public function isTokenExpired()
    {
        $now = time();

        return null == $this->accessToken || ($this->expireTimestamp - self::EXPIRE_BUFFER) < $now;
    }

    /**
     * @param bool $force
     *
     * @return string|null
     *
     * @throws IamportAuthException
     * @throws Exception
     */
    public function requestAccessToken(bool $force)
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

            $auth = $response->getResponseAs(Auth::class);

            $this->accessToken = $auth->getAccessToken();
            //호출하는 서버의 시간이 동기화되어있지 않을 가능성 고려 ( 로컬 서버 타임기준 계산 )
            $this->expireTimestamp = time() + $auth->getRemaindSeconds();

            return $this->accessToken;
        } catch (ConnectException $e) {
            throw new Exception('Request Error(HTTP STATUS : '.$e->getcode().')', $e->getHandlerContext()['errno']);
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
    protected function getHttpClient(bool $authenticated)
    {
        $stack = HandlerStack::create();
        $stack->push(new DefaultRequestMiddleware());

        if ($authenticated) {
            $token = $this->requestAccessToken(false);
            $stack->push(new TokenMiddleware($token));
        }

        $client = new Client([
            'handler'  => $stack,
            'base_uri' => Endpoint::API_BASE_URL,
        ]);

        return $client;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array  $attributes
     * @param bool   $authenticated
     *
     * @return object
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
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
            if (empty($parseResponse->response)) {
                throw new Exception('API서버로부터 응답이 올바르지 않습니다. '.$parseResponse, 1);
            }

            return (object) $parseResponse->response;
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
                function (ResponseInterface $response) use (&$promise) {
                    $parseResponse = json_decode($response->getBody());
                    if (0 !== $parseResponse->code) {
                        throw new IamportRequestException($parseResponse);
                    }
                    if (empty($parseResponse->response)) {
                        throw new Exception('API서버로부터 응답이 올바르지 않습니다. '.$parseResponse, 1);
                    }
                },
                function (RequestException $e) {
                    throw new IamportRequestException($e);
                }
            );

            $response = $promise->wait();

            return json_decode($response->getBody())->response;
        } catch (Exception $e) {
            Handler::report($e);
        }
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array  $attributes
     * @param string $responseType
     * @param bool   $authenticated
     *
     * @return Result
     *
     * @throws GuzzleException
     */
    public function callApi(string $method, string $uri, array $attributes = [], string $responseType = 'default', bool $authenticated = true)
    {
        try {
            if(isset($attributes['query'])) {
                $attributes['query'] = json_encode($attributes['query']);
            }

            if(isset($attributes['body'])) {
                $attributes['body'] = json_encode($attributes['body']);
            }

            $response = $this->request($method, $uri, $attributes, $authenticated);

            switch ($responseType) {
                case 'paged':
                    $result = new PagedResponse($response);
                    break;
                default:
                    $result  = new Response($response);
                    break;
            }
            return new Result(true, $result);

        } catch (Exception $e) {
            return Handler::render($e);
        }
    }
}
