<?php

namespace Iamport\RestClient\Request;

/**
 * Class Schedule.
 *
 * @property string $merchant_uid
 * @property int    $schedule_at
 * @property float  $amount
 * @property float  $tax_free
 * @property string $name
 * @property string $buyer_name
 * @property string $buyer_email
 * @property string $buyer_tel
 * @property string $buyer_addr
 * @property string $buyer_postcode
 * @property string $notice_url
 */
class Schedule
{
    use RequestTrait;

    /**
     * @var string
     */
    private $merchant_uid;

    /**
     * @var int
     */
    private $schedule_at;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var float
     */
    private $tax_free;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $buyer_name;

    /**
     * @var string
     */
    private $buyer_email;

    /**
     * @var string
     */
    private $buyer_tel;

    /**
     * @var string
     */
    private $buyer_addr;

    /**
     * @var string
     */
    private $buyer_postcode;

    /**
     * @var string
     */
    private $notice_url;

    /**
     * Schedule constructor.
     *
     * @param string $merchant_uid
     * @param int    $schedule_at
     * @param float  $amount
     */
    public function __construct(string $merchant_uid, int $schedule_at, float $amount)
    {
        $this->merchant_uid = $merchant_uid;
        $this->schedule_at  = $schedule_at;
        $this->amount       = $amount;
    }

    /**
     * @param string $merchant_uid
     */
    public function setMerchantUid(string $merchant_uid): void
    {
        $this->merchant_uid = $merchant_uid;
    }

    /**
     * @param int $schedule_at
     */
    public function setScheduleAt(int $schedule_at): void
    {
        $this->schedule_at = $schedule_at;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @param float $tax_free
     */
    public function setTaxFree(float $tax_free): void
    {
        $this->tax_free = $tax_free;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $buyer_name
     */
    public function setBuyerName(string $buyer_name): void
    {
        $this->buyer_name = $buyer_name;
    }

    /**
     * @param string $buyer_email
     */
    public function setBuyerEmail(string $buyer_email): void
    {
        $this->buyer_email = $buyer_email;
    }

    /**
     * @param string $buyer_tel
     */
    public function setBuyerTel(string $buyer_tel): void
    {
        $this->buyer_tel = $buyer_tel;
    }

    /**
     * @param string $buyer_addr
     */
    public function setBuyerAddr(string $buyer_addr): void
    {
        $this->buyer_addr = $buyer_addr;
    }

    /**
     * @param string $buyer_postcode
     */
    public function setBuyerPostcode(string $buyer_postcode): void
    {
        $this->buyer_postcode = $buyer_postcode;
    }

    /**
     * @param string $notice_url
     */
    public function setNoticeUrl(string $notice_url): void
    {
        $this->notice_url = $notice_url;
    }
}
