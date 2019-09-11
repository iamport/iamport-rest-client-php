<?php

namespace Iamport\RestClient\Exception;

use Exception;

/**
 * Class IamportRequestException.
 */
final class IamportRequestException extends Exception
{
    /**
     * @var
     */
    protected $response;

    /**
     * IamportRequestException constructor.
     *
     * @param $response
     */
    public function __construct($response)
    {
        $this->response = $response;

        parent::__construct($response->message, $response->code);
    }
}
