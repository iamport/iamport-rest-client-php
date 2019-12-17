<?php

namespace Iamport\RestClient\Response\Naver;

use Iamport\RestClient\Response\ResponseTrait;

/**
 * Class NaverCashAmount.
 */
class NaverCashAmount
{
    use ResponseTrait;

    /**
     * @var int 현금영수증 발급가능 총액 ,
     */
    protected $amount_total;

    /**
     * @var int 현금영수증 발급가능 총액 중 Npoint 에 의한 금액 ,
     */
    protected $amount_by_npoint;

    /**
     * @var int 현금영수증 발급가능 총액 중 메인 결제수단(신용카드, 계좌이체 등)에 의한 금액 ,
     */
    protected $amount_by_primary;

    /**
     * @var int 현금영수증 발급가능 총액 중 공급가액 ,
     */
    protected $amount_supply;

    /**
     * @var int 현금영수증 발급가능 총액 중 부가세
     */
    protected $amount_vat;

    /**
     * NaverCashAmount constructor.
     */
    public function __construct(array $response)
    {
        $this->amount_total      = $response['amount_total'];
        $this->amount_by_npoint  = $response['amount_by_npoint'];
        $this->amount_by_primary = $response['amount_by_primary'];
        $this->amount_supply     = $response['amount_supply'];
        $this->amount_vat        = $response['amount_vat'];
    }

    public function getAmountTotal(): int
    {
        return $this->amount_total;
    }

    public function getAmountByNpoint(): int
    {
        return $this->amount_by_npoint;
    }

    public function getAmountByPrimary(): int
    {
        return $this->amount_by_primary;
    }

    public function getAmountSupply(): int
    {
        return $this->amount_supply;
    }

    public function getAmountVat(): int
    {
        return $this->amount_vat;
    }
}
