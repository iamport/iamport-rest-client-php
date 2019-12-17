<?php

namespace Iamport\RestClient\Response;

/**
 * Class PaymentPrepare.
 */
class PaymentPrepare
{
    use ResponseTrait;

    /**
     * @var string
     */
    protected $merchant_uid;

    /**
     * @var float
     */
    protected $amount;

    /**
     * PaymentPrepare constructor.
     */
    public function __construct(array $response)
    {
        $this->merchant_uid = $response['merchant_uid'];
        $this->amount       = $response['amount'];
    }

    public function setMerchantUid(string $merchant_uid): void
    {
        $this->merchant_uid = $merchant_uid;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }
}
