<?php

namespace Iamport\RestClient\Request;

/**
 * Class AgainPayment.
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
class AgainPayment
{
    use RequestTrait;

    /**
     * @var string 고객 고유번호
     */
    private $customer_uid;

    /**
     * @var string 가맹점 거래 고유번호
     */
    private $merchant_uid;

    /**
     * @var string 결제금액
     */
    private $amount;

    /**
     * @var string 주문명
     */
    private $name;

    /**
     * @var string amount 중 면세공급가액
     */
    private $tax_free;

    /**
     * @var string 주문자명
     */
    private $buyer_name;

    /**
     * @var string 주문자 E-mail주소
     */
    private $buyer_email;

    /**
     * @var string 주문자 전화번호
     */
    private $buyer_tel;

    /**
     * @var string 주문자 주소
     */
    private $buyer_addr;

    /**
     * @var string 주문자 우편번호
     */
    private $buyer_postcode;

    /**
     * @var string 카드할부개월수. 2 이상의 integer 할부개월수 적용(결제금액 50,000원 이상 한정).
     */
    private $card_quota;

    /**
     * @var string 거래정보와 함께 저장할 추가 정보
     */
    private $custom_data;

    /**
     * @var string 결제성공 시 통지될 Notification URL(Webhook URL)
     */
    private $notice_url;

    /**
     * AgainPayment constructor.
     *
     * @param string $customer_uid
     * @param string $merchant_uid
     * @param string $amount
     * @param string $name
     */
    public function __construct(string $customer_uid, string $merchant_uid, string $amount, string $name)
    {
        $this->customer_uid = $customer_uid;
        $this->merchant_uid = $merchant_uid;
        $this->amount       = $amount;
        $this->name         = $name;
    }

    /**
     * @param string $customer_uid
     */
    public function setCustomerUid(string $customer_uid): void
    {
        $this->customer_uid = $customer_uid;
    }

    /**
     * @param string $merchant_uid
     */
    public function setMerchantUid(string $merchant_uid): void
    {
        $this->merchant_uid = $merchant_uid;
    }

    /**
     * @param string $amount
     */
    public function setAmount(string $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $tax_free
     */
    public function setTaxFree(string $tax_free): void
    {
        $this->tax_free = $tax_free;
    }

    /**
     * @param string $buyer_name
     */
    public function setBuyerName(string $buyer_name): void
    {
        $this->buyer_name = $buyer_name;
    }

    /**
     * @param string $buyer_email
     */
    public function setBuyerEmail(string $buyer_email): void
    {
        $this->buyer_email = $buyer_email;
    }

    /**
     * @param string $buyer_tel
     */
    public function setBuyerTel(string $buyer_tel): void
    {
        $this->buyer_tel = $buyer_tel;
    }

    /**
     * @param string $buyer_addr
     */
    public function setBuyerAddr(string $buyer_addr): void
    {
        $this->buyer_addr = $buyer_addr;
    }

    /**
     * @param string $buyer_postcode
     */
    public function setBuyerPostcode(string $buyer_postcode): void
    {
        $this->buyer_postcode = $buyer_postcode;
    }

    /**
     * @param string $card_quota
     */
    public function setCardQuota(string $card_quota): void
    {
        $this->card_quota = $card_quota;
    }

    /**
     * @param string $custom_data
     */
    public function setCustomData(string $custom_data): void
    {
        $this->custom_data = $custom_data;
    }

    /**
     * @param string $notice_url
     */
    public function setNoticeUrl(string $notice_url): void
    {
        $this->notice_url = $notice_url;
    }
}
