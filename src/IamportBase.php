<?php

namespace Iamport\RestClient;

use GuzzleHttp\Client;
use Iamport\RestClient\Request\RequestBase;

abstract class IamportBase
{
    const EXPIRE_BUFFER = 30;

    /**
     * @var string
     */
    protected $impKey          = null;

    /**
     * @var string
     */
    protected $impSecret       = null;

    /**
     * @var string|null
     */
    protected $accessToken     = null;

    /**
     * @var int
     */
    protected $expireTimestamp = 0;

    /**
     * IamportBase constructor.
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

    public abstract function requestAccessToken(bool $force = false): ?string;

    public abstract function callApi(RequestBase $request): Result;

    public abstract function request(string $method, string $uri, array $attributes = [], bool $authenticated = true, Client $customClient = null);

    protected abstract function getHttpClient(bool $authenticated): Client;

    protected abstract function isTokenExpired(): bool;
}
