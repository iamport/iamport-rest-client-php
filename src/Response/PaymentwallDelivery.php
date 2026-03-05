<?php

namespace Iamport\RestClient\Response;

/**
 * Class PaymentwallDelivery.
 */
class PaymentwallDelivery
{
    use ResponseTrait;

    /**
     * @var int|null
     */
    protected $error_code;

    /**
     * @var string|null
     */
    protected $error;

    /**
     * @var array|null
     */
    protected $notices;

    /**
     * PaymentwallDelivery constructor.
     */
    public function __construct(array $response)
    {
        $this->error_code = $response['error_code'] ?? null;
        $this->error      = $response['error'] ?? null;
        $this->notices    = $response['notices'] ?? null;
    }

    /**
     * @return int|null
     */
    public function getErrorCode()
    {
        return $this->error_code;
    }

    /**
     * @return string|null
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return array|null
     */
    public function getNotices()
    {
        return $this->notices;
    }
}
