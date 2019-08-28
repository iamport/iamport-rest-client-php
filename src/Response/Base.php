<?php

namespace Iamport\RestClient\Response;

class Base
{
    protected $responseBody = null;

    public function __construct($responseBody)
    {
        $this->responseBody = $responseBody;
    }
}
