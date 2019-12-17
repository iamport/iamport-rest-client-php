<?php

namespace Iamport\RestClient\Response;

class Schedule
{
    use ResponseTrait;

    /**
     * @var string
     */
    protected $customer_uid;

    /**
     * @var int
     */
    protected $merchant_uid;

    /**
     * @var mixed
     */
    protected $schedule_at;

    /**
     * @var string
     */
    protected $amount;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $buyer_name;

    /**
     * @var string
     */
    protected $buyer_email;

    /**
     * @var string
     */
    protected $buyer_tel;

    /**
     * @var string
     */
    protected $buyer_addr;

    /**
     * @var string
     */
    protected $buyer_postcode;

    /**
     * @var string
     */
    protected $schedule_status;

    /**
     * Schedule constructor.
     */
    public function __construct(array $response)
    {
        $this->customer_uid    = $response['customer_uid'];
        $this->merchant_uid    = $response['merchant_uid'];
        $this->schedule_at     = $response['schedule_at'];
        $this->amount          = $response['amount'];
        $this->name            = $response['name'] ?? null;
        $this->buyer_name      = $response['buyer_name'] ?? null;
        $this->buyer_email     = $response['buyer_email'] ?? null;
        $this->buyer_tel       = $response['buyer_tel'] ?? null;
        $this->buyer_addr      = $response['buyer_addr'] ?? null;
        $this->buyer_postcode  = $response['buyer_postcode'] ?? null;
        $this->schedule_status = $response['schedule_status'] ?? null;
    }

    public function getCustomerUid(): string
    {
        return $this->customer_uid;
    }

    public function getMerchantUid(): int
    {
        return $this->merchant_uid;
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function getScheduleAt()
    {
        return $this->timestampToDate($this->schedule_at);
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBuyerName(): string
    {
        return $this->buyer_name;
    }

    public function getBuyerEmail(): string
    {
        return $this->buyer_email;
    }

    public function getBuyerTel(): string
    {
        return $this->buyer_tel;
    }

    public function getBuyerAddr(): string
    {
        return $this->buyer_addr;
    }

    public function getBuyerPostcode(): string
    {
        return $this->buyer_postcode;
    }

    public function getScheduleStatus(): string
    {
        return $this->schedule_status;
    }
}
