<?php

namespace Iamport\RestClient\Response;

/**
 * Class Balance.
 */
class Balance
{
    use ResponseTrait;

    /**
     * @var int 면세 공급가액 (환불시 마이너스 차감된 최종 금액 반환)
     */
    protected $tax_free;

    /**
     * @var int 과세 공급가액 (환불시 마이너스 차감된 최종 금액 반환)
     */
    protected $supply;

    /**
     * @var int 부가세액 (환불시 마이너스 차감된 최종 금액 반환)
     */
    protected $vat;

    /**
     * @var int 봉사료 (환불시 마이너스 차감된 최종 금액 반환)
     */
    protected $service;

    /**
     * Balance constructor.
     */
    public function __construct(array $response)
    {
        $this->tax_free = $response['tax_free'];
        $this->supply   = $response['supply'];
        $this->vat      = $response['vat'];
        $this->service  = $response['service'];
    }

    public function getTaxFree(): int
    {
        return $this->tax_free;
    }

    public function getSupply(): int
    {
        return $this->supply;
    }

    public function getVat(): int
    {
        return $this->vat;
    }

    public function getService(): int
    {
        return $this->service;
    }
}
