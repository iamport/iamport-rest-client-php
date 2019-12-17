<?php

namespace Iamport\RestClient\Response;

/**
 * Class AuthResponse.
 */
class AuthResponse
{
    /**
     * @var string
     */
    protected $access_token;

    /**
     * @var int
     */
    protected $now;

    /**
     * @var int
     */
    protected $expired_at;

    /**
     * ResponseBase constructor.
     *
     * @param $resultBody
     */
    public function __construct($resultBody)
    {
        $this->access_token = $resultBody->access_token;
        $this->now          = $resultBody->now;
        $this->expired_at   = $resultBody->expired_at;
    }

    public function getAccessToken(): string
    {
        return $this->access_token;
    }

    public function getNow(): int
    {
        return $this->now;
    }

    public function getExpiredAt(): int
    {
        return $this->expired_at;
    }

    /**
     * @return mixed
     */
    public function getRemaindSeconds()
    {
        return $this->expired_at - $this->now;
    }
}
