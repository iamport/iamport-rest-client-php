<?php

namespace Iamport\RestClient\Response;

/**
 * Class PaymentCancel.
 */
class PaymentCancel
{
    use ResponseTrait;

    /**
     * @var string PG사 승인취소번호
     */
    protected $pg_tid;

    /**
     * @var int 취소 금액
     */
    protected $amount;

    /**
     * @var int 결제취소된 시각 UNIX timestamp
     */
    protected $cancelled_at;

    /**
     * @var string 결제취소 사유
     */
    protected $reason;

    /**
     * @var string 취소에 대한 매출전표 확인 URL. PG사에 따라 제공되지 않는 경우도 있음
     */
    protected $receipt_url;

    /**
     * PaymentCancel constructor.
     */
    public function __construct(array $response)
    {
        $this->pg_tid       = $response['pg_tid'];
        $this->amount       = $response['amount'];
        $this->cancelled_at = $response['cancelled_at'];
        $this->reason       = $response['reason'];
        $this->receipt_url  = $response['receipt_url'];
    }

    public function getPgTid(): string
    {
        return $this->pg_tid;
    }

    public function getAmount(): int
    {
        return $this->amount;
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

    public function getReason(): string
    {
        return $this->reason;
    }

    public function getReceiptUrl(): string
    {
        return $this->receipt_url;
    }
}
