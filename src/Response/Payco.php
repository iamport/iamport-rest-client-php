<?php

namespace Iamport\RestClient\Response;

use Iamport\RestClient\Enum\PaycoStatus;

/**
 * Class Payco.
 */
class Payco
{
    use ResponseTrait;

    /**
     * @var string PAYCO주문변경된 상태
     */
    protected $status;

    /**
     * Payco constructor.
     *
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->status = $response['status'];
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return PaycoStatus::getDescription($this->status);
    }
}
