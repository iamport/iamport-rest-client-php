<?php

namespace Iamport\RestClient\Response;

/**
 * Class Receipt.
 */
class Receipt
{
    use ResponseTrait;

    /**
     * @var string
     */
    protected $imp_uid;

    /**
     * @var string
     */
    protected $receipt_tid;

    /**
     * @var string
     */
    protected $apply_num;

    /**
     * @var string
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
     */
    public function __construct(array $response)
    {
        $this->imp_uid      = $response['imp_uid'];
        $this->receipt_tid  = $response['receipt_tid'];
        $this->apply_num    = $response['apply_num'];
        $this->type         = $response['type'];
        $this->amount       = $response['amount'];
        $this->vat          = $response['vat'];
        $this->receipt_url  = $response['receipt_url'];
        $this->applied_at   = $response['applied_at'];
        $this->cancelled_at = $response['cancelled_at'];
    }

    public function getImpUid(): string
    {
        return $this->imp_uid;
    }

    public function getReceiptTid(): string
    {
        return $this->receipt_tid;
    }

    public function getApplyNum(): string
    {
        return $this->apply_num;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getVat(): int
    {
        return $this->vat;
    }

    public function getReceiptUrl(): string
    {
        return $this->receipt_url;
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function getAppliedAt()
    {
        return $this->timestampToDate($this->applied_at);
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function getCancelledAt()
    {
        return $this->timestampToDate($this->cancelled_at);
    }
}
