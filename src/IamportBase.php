<?php

namespace Iamport\RestClient;

use GuzzleHttp\Client;
use Iamport\RestClient\Request\RequestBase;

abstract class IamportBase
{
    protected const EXPIRE_BUFFER = 30;

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
     */
    public function __construct(string $impKey, string $impSecret)
    {
        $this->impKey    = $impKey;
        $this->impSecret = $impSecret;
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    abstract public function requestAccessToken(bool $force = false): ?string;

    abstract public function callApi(RequestBase $request): Result;

    abstract public function request(string $method, string $uri, array $attributes = [], Client $customClient = null);

    abstract protected function getHttpClient(bool $authenticated): Client;

    abstract protected function isTokenExpired(): bool;
}
