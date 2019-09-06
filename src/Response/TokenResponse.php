<?php

namespace Iamport\RestClient\Response;

class TokenResponse
{
    private $internalResponse = null;
    private $resultCode       = -1;
    private $resultMessage    = null;
    private $resultBody       = null;

    public function __construct($httpResponse = null)
    {
        $this->internalResponse = $httpResponse;
        $res                    = json_decode($httpResponse->getBody());

        if ($res) {
            $this->resultCode    = $res->code;
            $this->resultMessage = $res->message;
            $this->resultBody    = $res->response;
        }
    }

    public function isValid()
    {
        $statusCode = $this->internalResponse->getStatusCode();

        return $statusCode >= 200 && $statusCode < 300 && 0 === $this->resultCode;
    }

    public function getCode()
    {
        return $this->resultCode;
    }

    public function getMessage()
    {
        return $this->resultMessage;
    }

    public function getResponseAs($clazz)
    {
        if (empty($this->resultBody)) {
            return null;
        }

        return new $clazz($this->resultBody);
    }
}
