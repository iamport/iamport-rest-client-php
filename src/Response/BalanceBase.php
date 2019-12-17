<?php

namespace Iamport\RestClient\Response;

/**
 * Class BalanceBase.
 */
class BalanceBase
{
    use ResponseTrait;

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
     * @var mixed Balance정보가 등록된 시각 UNIX timestamp
     */
    protected $created;

    /**
     * BalanceBase constructor.
     */
    public function __construct(array $response)
    {
        $this->cash_receipt = new Balance($response['cash_receipt']);
        $this->primary      = new Balance($response['primary']);
        $this->secondary    = new Balance($response['secondary']);
        $this->discount     = new Balance($response['discount']);
        $this->created      = $response['created'];
    }

    public function getCashReceipt(): Balance
    {
        return $this->cash_receipt;
    }

    public function getPrimary(): Balance
    {
        return $this->primary;
    }

    public function getSecondary(): Balance
    {
        return $this->secondary;
    }

    public function getDiscount(): Balance
    {
        return $this->discount;
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function getCreated()
    {
        return $this->timestampToDate($this->created);
    }
}
