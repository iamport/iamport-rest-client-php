<?php

namespace Iamport\RestClient\Exception;

use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class IamportException.
 */
class IamportException extends RequestException
{
    /**
     * @var array
     */
    private $iamportResponse;

    /**
     * IamportException constructor.
     *
     * @param $iamportResponse
     */
    public function __construct(
        $iamportResponse,
        RequestInterface $request,
        ResponseInterface $response = null,
        \Exception $previous = null,
        array $handlerContext = []
    ) {
        $this->iamportResponse = $iamportResponse;

        parent::__construct($iamportResponse->message, $request, $response, $previous, $handlerContext);
    }

    /**
     * @return mixed
     */
    public function getIamportResponse()
    {
        return $this->iamportResponse;
    }

    /**
     * Check if a iamportResponse was received.
     *
     * @return bool
     */
    public function hasIamportResponse()
    {
        return $this->iamportResponse !== null;
    }

    /**
     *  iamportResponse delete.
     */
    public function deleteResponse()
    {
        unset($this->iamportResponse);
    }
}
