<?php

namespace Iamport\RestClient\Request;

use GuzzleHttp\Client;

/**
 * Class RequestBase.
 */
abstract class RequestBase
{
    /**
     * 하나의 Requset에서 여러개의 instance를 생성할 경우 구분값
     *
     * @var string
     */
    public $instanceType;

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
     * @var mixed  api 추가 성공 조건 (optional)
     */
    public $extraCondition = null;

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
     * @param mixed $extraCondition
     */
    public function setExtraCondition($extraCondition): void
    {
        $this->extraCondition = $extraCondition;
    }

    /**
     * @return bool request 객체 입력값 validate (optional)
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
