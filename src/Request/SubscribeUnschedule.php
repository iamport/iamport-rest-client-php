<?php

namespace Iamport\RestClient\Request;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Response;

/**
 * Class SubscribeUnschedule.
 *
 * @property string $customer_uid
 * @property array  $merchant_uid
 */
class SubscribeUnschedule extends RequestBase
{
    use RequestTrait;

    /**
     * @var string 고객 고유번호
     */
    protected $customer_uid;

    /**
     * @var array 구매자 고유 번호
     */
    protected $merchant_uid;

    /**
     * SubscribeUnschedule constructor.
     *
     * @param string $customer_uid
     */
    public function __construct(string $customer_uid)
    {
        $this->customer_uid = $customer_uid;
        $this->responseClass = Response\Schedule::class;
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

    /**
     * 비인증 결제요청예약 취소
     * [POST] /subscribe/payments/unschedule.
     *
     * @return string
     */
    public function path(): string
    {
        return Endpoint::SBCR_PAYMENTS_UNSCHEDULE;
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'body' => json_encode($this->toArray()),
        ];
    }

    /**
     * @return string
     */
    public function verb(): string
    {
        return 'POST';
    }
}
