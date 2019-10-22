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
     *
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->customer_uid    = $response['customer_uid'];
        $this->merchant_uid    = $response['merchant_uid'];
        $this->schedule_at     = $response['schedule_at'];
        $this->amount          = $response['amount'];
        $this->name            = $response['name'];
        $this->buyer_name      = $response['buyer_name'];
        $this->buyer_email     = $response['buyer_email'];
        $this->buyer_tel       = $response['buyer_tel'];
        $this->buyer_addr      = $response['buyer_addr'];
        $this->buyer_postcode  = $response['buyer_postcode'];
        $this->schedule_status = $response['schedule_status'];
    }

    /**
     * @return string
     */
    public function getCustomerUid(): string
    {
        return $this->customer_uid;
    }

    /**
     * @return int
     */
    public function getMerchantUid(): int
    {
        return $this->merchant_uid;
    }

    /**
     * @return mixed
     */
    public function getScheduleAt()
    {
        return $this->timestampToDate($this->schedule_at);
    }

    /**
     * @return string
     */
    public function getAmount(): string
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getBuyerName(): string
    {
        return $this->buyer_name;
    }

    /**
     * @return string
     */
    public function getBuyerEmail(): string
    {
        return $this->buyer_email;
    }

    /**
     * @return string
     */
    public function getBuyerTel(): string
    {
        return $this->buyer_tel;
    }

    /**
     * @return string
     */
    public function getBuyerAddr(): string
    {
        return $this->buyer_addr;
    }

    /**
     * @return string
     */
    public function getBuyerPostcode(): string
    {
        return $this->buyer_postcode;
    }

    /**
     * @return string
     */
    public function getScheduleStatus(): string
    {
        return $this->schedule_status;
    }
}
