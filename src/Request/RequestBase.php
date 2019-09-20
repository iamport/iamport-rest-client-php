<?php

namespace Iamport\RestClient\Request;

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
    public $responseType = '';

    /**
     * @var bool
     */
    public $isCollection = false;

    /**
     * 토큰 포함 여부
     *
     * @var bool
     */
    public $authenticated = true;

    /**
     * @param string $responseType
     */
    public function setResponseType(string $responseType): void
    {
        $this->responseType = $responseType;
    }

    /**
     * @param bool $authenticated
     */
    public function setAuthenticated(bool $authenticated): void
    {
        $this->authenticated = $authenticated;
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
