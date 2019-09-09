<?php

namespace Iamport\RestClient\Request;

/**
 * Class SubscribeUnschedule.
 *
 * @property string $customer_uid
 * @property array  $merchant_uid
 */
class SubscribeUnschedule
{
    use RequestTrait;

    /**
     * @var string 고객 고유번호
     */
    private $customer_uid;

    /**
     * @var array 구매자 고유 번호
     */
    private $merchant_uid;

    /**
     * SubscribeUnschedule constructor.
     *
     * @param string $customer_uid
     */
    public function __construct(string $customer_uid)
    {
        $this->customer_uid = $customer_uid;
    }

    /**
     * @param string $customer_uid
     */
    public function setCustomerUid(string $customer_uid): void
    {
        $this->customer_uid = $customer_uid;
    }

    /**
     * @param array $merchant_uid
     */
    public function setMerchantUid(array $merchant_uid): void
    {
        $this->merchant_uid = $merchant_uid;
    }
}
