<?php

namespace Iamport\RestClient\Request\Subscribe;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Request\CardInfo;
use Iamport\RestClient\Request\RequestBase;
use Iamport\RestClient\Request\RequestTrait;
use Iamport\RestClient\Response;

/**
 * Class SubscribeOnetime.
 *
 * @property string $merchant_uid
 * @property float  $amount
 * @property float  $tax_free
 * @property string $card_number
 * @property string $expiry
 * @property string $birth
 * @property string $pwd_2digit
 * @property string $customer_uid
 * @property string $pg
 * @property string $name
 * @property string $buyer_name
 * @property string $buyer_email
 * @property string $buyer_tel
 * @property string $buyer_addr
 * @property string $buyer_postcode
 * @property int    $card_quota
 * @property string $custom_data
 * @property string $notice_url
 */
class SubscribeOnetime extends RequestBase
{
    use RequestTrait;

    /**
     * @var string 가맹점 거래 고유번호
     */
    protected $merchant_uid;

    /**
     * @var float 결제금액
     */
    protected $amount;

    /**
     * @var float amount 중 면세공급가액
     */
    protected $tax_free;

    /**
     * @var string 카드번호(dddd-dddd-dddd-dddd)
     */
    protected $card_number;

    /**
     * @var string 카드 유효기간(YYYY-MM)
     */
    protected $expiry;

    /**
     * @var string 생년월일6자리(법인카드의 경우 사업자등록번호10자리)
     */
    protected $birth;

    /**
     * @var string 카드비밀번호 앞 2자리
     */
    protected $pwd_2digit;

    /**
     * @var string 구매자 고유 번호
     */
    protected $customer_uid;

    /**
     * @var string API 방식 비인증 PG설정이 2개 이상인 경우 지정
     */
    protected $pg;

    /**
     * @var string 주문명
     */
    protected $name;

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
     * SubscribeOnetime constructor.
     */
    public function __construct(string $merchant_uid, float $amount, CardInfo $cardInfo)
    {
        $this->merchant_uid = $merchant_uid;
        $this->amount       = $amount;

        $this->card_number = $cardInfo->card_number;
        $this->expiry      = $cardInfo->expiry;
        $this->birth       = $cardInfo->birth;

        if (!is_null($cardInfo->pwd_2digit)) {
            $this->pwd_2digit = $cardInfo->pwd_2digit;
        }

        $this->responseClass  = Response\Payment::class;
        $this->extraCondition = function ($data) {
            return ($data->status === 'paid') ? true : false;
        };
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

    public function setCardNumber(string $card_number): void
    {
        $this->card_number = $card_number;
    }

    public function setExpiry(string $expiry): void
    {
        $this->expiry = $expiry;
    }

    public function setBirth(string $birth): void
    {
        $this->birth = $birth;
    }

    public function setPwd2digit(string $pwd_2digit): void
    {
        $this->pwd_2digit = $pwd_2digit;
    }

    public function setCustomerUid(string $customer_uid): void
    {
        $this->customer_uid = $customer_uid;
    }

    public function setPg(string $pg): void
    {
        $this->pg = $pg;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
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
     * 빌링키 발급과 결제 요청을 동시에 처리.
     * [POST] /subscribe/payments/onetime.
     */
    public function path(): string
    {
        return Endpoint::SBCR_PAYMENTS_ONETIME;
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
