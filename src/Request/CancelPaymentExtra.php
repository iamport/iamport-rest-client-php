<?php

namespace Iamport\RestClient\Request;

use Iamport\RestClient\Request\RequestTrait;

/**
 * Class CancelPaymentExtra
 *
 * @property string $requester
 */
class CancelPaymentExtra
{
    use RequestTrait;

    /**
     * @var string API를 호출하는 출처 [ customer, admin ]
     */
    protected $requester;

    /**
     * CustomerExtra constructor.
     */
    public function __construct()
    {
    }

    public function setRequester(string $requester): void
    {
        $this->requester = $requester;
    }
}