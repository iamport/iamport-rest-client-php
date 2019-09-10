<?php

namespace Iamport\RestClient\Request;

use Iamport\RestClient\Enum\Endpoint;

/**
 * Class CancelPayment.
 *
 * @property string $imp_uid
 * @property string $merchant_uid
 * @property float  $amount
 * @property float  $tax_free
 * @property float  $checksum
 * @property string $reason
 * @property string $refund_holder
 * @property string $refund_bank
 * @property string $refund_account
 */
class CancelPayment extends RequestBase
{
    use RequestTrait;

    /**
     * @var string 취소할 거래의 아임포트 고유번호
     */
    private $imp_uid;

    /**
     * @var string 가맹점에서 전달한 거래 고유번호
     */
    private $merchant_uid;

    /**
     * @var float (부분)취소요청금액(누락이면 전액취소)
     */
    private $amount;

    /**
     * @var float (부분)취소요청금액 중 면세금액(누락되면 0원처리)
     */
    private $tax_free;

    /**
     * @var float 취소 트랜잭션 수행 전, 현재시점의 취소 가능한 잔액
     */
    private $checksum;

    /**
     * @var string 취소 사유
     */
    private $reason;

    /**
     * @var string 환불계좌 예금주(가상계좌취소시 필수)
     */
    private $refund_holder;

    /**
     * @var string 환불계좌 은행코드(하단 은행코드표 참조, 가상계좌취소시 필수)
     */
    private $refund_bank;

    /**
     * @var string 환불계좌 계좌번호(가상계좌취소시 필수)
     */
    private $refund_account;

    /**
     * 아임포트 고유번호로 인스턴스 생성
     *
     * @param string $impUid
     *
     * @return CancelPayment
     */
    public static function withImpUid(string $impUid)
    {
        $instance = new self();
        $instance->setImpUid($impUid);

        return $instance;
    }

    /**
     * 거래 고유번호로 인스턴스 생성
     *
     * @param string $merchant_uid
     *
     * @return CancelPayment
     */
    public static function withMerchantUid(string $merchant_uid)
    {
        $instance = new self();
        $instance->setMerchantUid($merchant_uid);

        return $instance;
    }

    /**
     * @param string $imp_uid
     */
    public function setImpUid(string $imp_uid): void
    {
        $this->imp_uid = $imp_uid;
    }

    /**
     * @param string $merchant_uid
     */
    public function setMerchantUid(string $merchant_uid): void
    {
        $this->merchant_uid = $merchant_uid;
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
     * @param float $checksum
     */
    public function setChecksum(float $checksum): void
    {
        $this->checksum = $checksum;
    }

    /**
     * @param string $reason
     */
    public function setReason(string $reason): void
    {
        $this->reason = $reason;
    }

    /**
     * @param string $refund_holder
     */
    public function setRefundHolder(string $refund_holder): void
    {
        $this->refund_holder = $refund_holder;
    }

    /**
     * @param string $refund_bank
     */
    public function setRefundBank(string $refund_bank): void
    {
        $this->refund_bank = $refund_bank;
    }

    /**
     * @param string $refund_account
     */
    public function setRefundAccount(string $refund_account): void
    {
        $this->refund_account = $refund_account;
    }

    /**
     * 주문취소.
     * [POST] /payments/cancel.
     *
     * @return string
     */
    public function path(): string
    {
        return Endpoint::PAYMENTS_CANCEL;
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'body' => json_encode($this->toArray()),
        ];
    }

    /**
     * @return string
     */
    public function verb(): string
    {
        return 'POST';
    }
}
