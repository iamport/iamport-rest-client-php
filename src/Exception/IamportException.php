<?php

namespace Iamport\RestClient\Exception;

use Exception;

/**
 * Class IamportException.
 */
final class IamportException extends Exception
{
    /**
     * @var
     */
    private $iamportResponse;

    /**
     * IamportException constructor.
     *
     * @param $response
     */
    public function __construct($response)
    {
        parent::__construct($response->getMessage(), $response->getCode());

        $this->iamportResponse = $response;
    }

    /**
     * @return mixed
     */
    public function getIamportResponse()
    {
        return $this->iamportResponse;
    }
}
