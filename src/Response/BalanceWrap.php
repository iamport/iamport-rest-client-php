<?php

namespace Iamport\RestClient\Response;

/**
 * Class BalanceWrap.
 */
class BalanceWrap
{
    use ResponseTrait;

    /**
     * @var int 최초 총 결제금액 ,
     */
    protected $amount;

    /**
     * @var Balance 현금영수증 발급된 금액 상세 ,
     */
    protected $cash_receipt;

    /**
     * @var Balance 1차 결제수단(신용카드, 계좌이체, 가상계좌, 휴대폰소액결제) 금액 상세 ,
     */
    protected $primary;

    /**
     * @var Balance 2차 결제수단(PG사포인트, 카드사포인트) 금액 상세 ,
     */
    protected $secondary;

    /**
     * @var Balance PG사/카드사 자체 할인 금액 상세 ,
     */
    protected $discount;

    /**
     * @var array[BalanceBase] PaymentBalance 이력
     */
    protected $histories = [];

    /**
     * NaverInquiry constructor.
     *
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->amount         = $response['amount'];
        $this->cash_receipt   = new Balance($response['cash_receipt']);
        $this->primary        = new Balance($response['primary']);
        $this->secondary      = new Balance($response['secondary']);
        $this->discount       = new Balance($response['discount']);

        foreach ($response['histories'] as $item) {
            $this->histories[] = new BalanceBase($item);
        };
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return Balance
     */
    public function getCashReceipt(): Balance
    {
        return $this->cash_receipt;
    }

    /**
     * @return Balance
     */
    public function getPrimary(): Balance
    {
        return $this->primary;
    }

    /**
     * @return Balance
     */
    public function getSecondary(): Balance
    {
        return $this->secondary;
    }

    /**
     * @return Balance
     */
    public function getDiscount(): Balance
    {
        return $this->discount;
    }

    /**
     * @return array
     */
    public function getHistories(): array
    {
        return $this->histories;
    }

}
