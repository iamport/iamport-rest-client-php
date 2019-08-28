<?php

namespace Iamport\RestClient\Response;

class Auth extends Base
{
    public function getAccessToken()
    {
        return $this->responseBody->access_token;
    }

    public function getRemaindSeconds()
    {
        return $this->responseBody->expired_at - $this->responseBody->now;
    }
}
