<?php

namespace Iamport\RestClient\Response;

/**
 * Class ExternalReceipt.
 */
class ExternalReceipt
{
    use ResponseTrait;

    /**
     * @var string
     */
    protected $merchant_uid;

    /**
     * @var string
     */
    protected $receipt_tid;

    /**
     * @var string
     */
    protected $apply_num;

    /**
     * @var string [person, company]
     */
    protected $type;

    /**
     * @var int
     */
    protected $amount;

    /**
     * @var int
     */
    protected $vat;

    /**
     * @var string
     */
    protected $receipt_url;

    /**
     * @var mixed
     */
    protected $applied_at;

    /**
     * @var mixed
     */
    protected $cancelled_at;

    /**
     * Receipt constructor.
     *
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->merchant_uid      = $response['merchant_uid'];
        $this->receipt_tid       = $response['receipt_tid'];
        $this->apply_num         = $response['apply_num'];
        $this->type              = $response['type'];
        $this->amount            = $response['amount'];
        $this->vat               = $response['vat'];
        $this->receipt_url       = $response['receipt_url'];
        $this->applied_at        = $response['applied_at'];
        $this->cancelled_at      = $response['cancelled_at'];
    }

    /**
     * @return string
     */
    public function getMerchantUid(): string
    {
        return $this->merchant_uid;
    }

    /**
     * @return string
     */
    public function getReceiptTid(): string
    {
        return $this->receipt_tid;
    }

    /**
     * @return string
     */
    public function getApplyNum(): string
    {
        return $this->apply_num;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function getVat(): int
    {
        return $this->vat;
    }

    /**
     * @return string
     */
    public function getReceiptUrl(): string
    {
        return $this->receipt_url;
    }

    /**
     * @return mixed
     */
    public function getAppliedAt()
    {
        return $this->timestampToDate($this->applied_at);
    }

    /**
     * @return mixed
     */
    public function getCancelledAt()
    {
        return $this->timestampToDate($this->cancelled_at);
    }
}