<?php

namespace Iamport\RestClient\Request;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Response;

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
 * @property string $refund_tel
 * @property CancelPaymentExtra $extra
 */
class CancelPayment extends RequestBase
{
    use RequestTrait;

    /**
     * @var string 취소할 거래의 아임포트 고유번호
     */
    protected $imp_uid;

    /**
     * @var string 가맹점에서 전달한 거래 고유번호
     */
    protected $merchant_uid;

    /**
     * @var float (부분)취소요청금액(누락이면 전액취소)
     */
    protected $amount;

    /**
     * @var float (부분)취소요청금액 중 면세금액(누락되면 0원처리)
     */
    protected $tax_free;

    /**
     * @var float 취소 트랜잭션 수행 전, 현재시점의 취소 가능한 잔액
     */
    protected $checksum;

    /**
     * @var string 취소 사유
     */
    protected $reason;

    /**
     * @var string 환불계좌 예금주(가상계좌취소시 필수)
     */
    protected $refund_holder;

    /**
     * @var string 환불계좌 은행코드(하단 은행코드표 참조, 가상계좌취소시 필수)
     */
    protected $refund_bank;

    /**
     * @var string 환불계좌 계좌번호(가상계좌취소시 필수)
     */
    protected $refund_account;

    /**
     * @var string 환불계좌 예금주 연락처(가상계좌취소,스마트로 PG사 인경우 필수 )
     */
    protected $refund_tel;

    /**
     * @var CancelPaymentExtra
     */
    protected $extra;

    /**
     * CancelPayment constructor.
     */
    public function __construct()
    {
        $this->responseClass = Response\Payment::class;
    }

    /**
     * 아임포트 고유번호로 인스턴스 생성.
     *
     * @return CancelPayment
     */
    public static function withImpUid(string $imp_uid)
    {
        $instance          = new self();
        $instance->imp_uid = $imp_uid;

        return $instance;
    }

    /**
     * 거래 고유번호로 인스턴스 생성.
     *
     * @return CancelPayment
     */
    public static function withMerchantUid(string $merchant_uid)
    {
        $instance               = new self();
        $instance->merchant_uid = $merchant_uid;

        return $instance;
    }

    public function setImpUid(string $imp_uid): void
    {
        $this->imp_uid = $imp_uid;
    }

    public function setMerchantUid(string $merchant_uid): void
    {
        $this->merchant_uid = $merchant_uid;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function setTaxFree(float $tax_free): void
    {
        $this->tax_free = $tax_free;
    }

    public function setChecksum(float $checksum): void
    {
        $this->checksum = $checksum;
    }

    public function setReason(string $reason): void
    {
        $this->reason = $reason;
    }

    public function setRefundHolder(string $refund_holder): void
    {
        $this->refund_holder = $refund_holder;
    }

    public function setRefundBank(string $refund_bank): void
    {
        $this->refund_bank = $refund_bank;
    }

    public function setRefundAccount(string $refund_account): void
    {
        $this->refund_account = $refund_account;
    }

    public function setRefundTel(string $refund_tel): void
    {
        $this->refund_tel = $refund_tel;
    }

    public function setExtra(CancelPaymentExtra $extra): void
    {
        $this->extra = $extra;
    }

    /**
     * 주문취소.
     * [POST] /payments/cancel.
     */
    public function path(): string
    {
        return Endpoint::PAYMENTS_CANCEL;
    }

    public function attributes(): array
    {
        $result = $this->toArray();

        if ($this->extra instanceof CancelPaymentExtra) {
            $result['extra'] = $this->extra->toArray();
        }

        return [
            'body' => json_encode($result),
        ];
    }

    public function verb(): string
    {
        return 'POST';
    }
}