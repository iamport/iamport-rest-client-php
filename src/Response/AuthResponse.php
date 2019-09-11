<?php

namespace Iamport\RestClient\Response;

/**
 * Class AuthResponse.
 */
class AuthResponse extends ResponseBase
{
    /**
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->responseBody->access_token;
    }

    /**
     * @return mixed
     */
    public function getRemaindSeconds()
    {
        return $this->responseBody->expired_at - $this->responseBody->now;
    }
}
