<?php

namespace Iamport\RestClient\Exception;

use Exception;

class IamportRequestException extends Exception
{
    protected $response;

    public function __construct($response)
    {
        $this->response = $response;

        parent::__construct($response->message, $response->code);
    }
}
