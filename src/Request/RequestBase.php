<?php

namespace Iamport\RestClient\Request;

use GuzzleHttp\Client;

/**
 * Class RequestBase.
 */
abstract class RequestBase
{
    /**
     * response 유형
     *
     * @var string
     */
    public $responseClass = '';

    /**
     * @var bool
     */
    public $isCollection = false;

    /**
     * @var bool
     */
    public $isPaged = false;

    /**
     * 토큰 포함 여부
     *
     * @var bool
     */
    public $authenticated = true;

    /**
     * @var Client
     */
    public $client = null;

    /**
     * @param string $responseClass
     */
    public function setResponseClass(string $responseClass): void
    {
        $this->responseClass = $responseClass;
    }

    /**
     * @param bool $authenticated
     */
    public function setAuthenticated(bool $authenticated): void
    {
        $this->authenticated = $authenticated;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return true;
    }

    /**
     * @return string
     */
    abstract public function path(): string;

    /**
     * @return array
     */
    abstract public function attributes(): array;

    /**
     * @return string
     */
    abstract public function verb(): string;
}
