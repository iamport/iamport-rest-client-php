<?php

namespace Iamport\RestClient\Response;

/**
 * Class ResponseBase.
 */
class ResponseBase
{
    /**
     * @var null
     */
    protected $responseBody = null;

    /**
     * ResponseBase constructor.
     *
     * @param $responseBody
     */
    public function __construct($responseBody)
    {
        $this->responseBody = $responseBody;
    }
}
