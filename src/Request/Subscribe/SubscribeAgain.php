<?php

namespace Iamport\RestClient\Request\Subscribe;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Request\RequestBase;
use Iamport\RestClient\Request\RequestTrait;
use Iamport\RestClient\Response;

/**
 * Class SubscribeAgain.
 *
 * @property string $customer_uid
 * @property string $merchant_uid
 * @property float  $amount
 * @property string $name
 * @property float  $tax_free
 * @property string $buyer_name
 * @property string $buyer_email
 * @property string $buyer_tel
 * @property string $buyer_addr
 * @property string $buyer_postcode
 * @property int    $card_quota
 * @property string $custom_data
 * @property string $notice_url
 */
class SubscribeAgain extends RequestBase
{
    use RequestTrait;

    /**
     * @var string 고객 고유번호
     */
    protected $customer_uid;

    /**
     * @var string 가맹점 거래 고유번호
     */
    protected $merchant_uid;

    /**
     * @var float 결제금액
     */
    protected $amount;

    /**
     * @var string 주문명
     */
    protected $name;

    /**
     * @var float amount 중 면세공급가액
     */
    protected $tax_free;

    /**
     * @var string 주문자명
     */
    protected $buyer_name;

    /**
     * @var string 주문자 E-mail주소
     */
    protected $buyer_email;

    /**
     * @var string 주문자 전화번호
     */
    protected $buyer_tel;

    /**
     * @var string 주문자 주소
     */
    protected $buyer_addr;

    /**
     * @var string 주문자 우편번호
     */
    protected $buyer_postcode;

    /**
     * @var int 카드할부개월수. 2 이상의 integer 할부개월수 적용(결제금액 50,000원 이상 한정).
     */
    protected $card_quota;

    /**
     * @var string 거래정보와 함께 저장할 추가 정보
     */
    protected $custom_data;

    /**
     * @var string 결제성공 시 통지될 Notification URL(Webhook URL)
     */
    protected $notice_url;

    /**
     * SubscribeAgain constructor.
     */
    public function __construct(string $customer_uid, string $merchant_uid, float $amount, string $name)
    {
        $this->customer_uid   = $customer_uid;
        $this->merchant_uid   = $merchant_uid;
        $this->amount         = $amount;
        $this->name           = $name;
        $this->responseClass  = Response\Payment::class;
        $this->extraCondition = function ($data) {
            return ($data->status === 'paid') ? true : false;
        };
    }

    public function setCustomerUid(string $customer_uid): void
    {
        $this->customer_uid = $customer_uid;
    }

    public function setMerchantUid(string $merchant_uid): void
    {
        $this->merchant_uid = $merchant_uid;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setTaxFree(float $tax_free): void
    {
        $this->tax_free = $tax_free;
    }

    public function setBuyerName(string $buyer_name): void
    {
        $this->buyer_name = $buyer_name;
    }

    public function setBuyerEmail(string $buyer_email): void
    {
        $this->buyer_email = $buyer_email;
    }

    public function setBuyerTel(string $buyer_tel): void
    {
        $this->buyer_tel = $buyer_tel;
    }

    public function setBuyerAddr(string $buyer_addr): void
    {
        $this->buyer_addr = $buyer_addr;
    }

    public function setBuyerPostcode(string $buyer_postcode): void
    {
        $this->buyer_postcode = $buyer_postcode;
    }

    public function setCardQuota(int $card_quota): void
    {
        $this->card_quota = $card_quota;
    }

    public function setCustomData(string $custom_data): void
    {
        $this->custom_data = $custom_data;
    }

    public function setNoticeUrl(string $notice_url): void
    {
        $this->notice_url = $notice_url;
    }

    /**
     * 저장된 빌링키로 재결제.
     * [POST] /subscribe/payments/again.
     */
    public function path(): string
    {
        return Endpoint::SBCR_PAYMENTS_AGAIN;
    }

    public function attributes(): array
    {
        return [
            'body' => json_encode($this->toArray()),
        ];
    }

    public function verb(): string
    {
        return 'POST';
    }
}
