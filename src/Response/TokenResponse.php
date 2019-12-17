<?php

namespace Iamport\RestClient\Response;

/**
 * Class TokenResponse.
 */
class TokenResponse
{
    /**
     * @var null
     */
    private $internalResponse = null;

    /**
     * @var int
     */
    private $resultCode       = -1;

    /**
     * @var string|null
     */
    private $resultMessage    = null;

    /**
     * @var |null
     */
    private $resultBody       = null;

    /**
     * TokenResponse constructor.
     *
     * @param null $httpResponse
     */
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

    /**
     * @return bool
     */
    public function isValid()
    {
        $statusCode = $this->internalResponse->getStatusCode();

        return $statusCode >= 200 && $statusCode < 300 && 0 === $this->resultCode;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->resultCode;
    }

    /**
     * @return string|null
     */
    public function getMessage()
    {
        return $this->resultMessage;
    }

    /**
     * @param $clazz
     *
     * @return object
     */
    public function getResponseAs($clazz)
    {
        if (!$this->resultBody) {
            return null;
        }

        return new $clazz($this->resultBody);
    }
}
