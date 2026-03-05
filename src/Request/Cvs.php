<?php

namespace Iamport\RestClient\Request;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Response;

/**
 * Class Cvs.
 *
 * @property string $imp_uid
 * @property string $channel_key
 * @property string $merchant_uid
 * @property float  $amount
 * @property string $barcode
 * @property int    $expired_at
 * @property string $name
 * @property string $buyer_name
 * @property string $buyer_email
 * @property string $buyer_tel
 * @property string $buyer_addr
 * @property string $buyer_postcode
 * @property string $confirm_url
 * @property array  $notice_url
 * @property string $custom_data
 */
class Cvs extends RequestBase
{
    use RequestTrait;

    /**
     * @var string 아임포트 고유번호
     */
    protected $imp_uid;

    /**
     * @var string 채널키
     */
    protected $channel_key;

    /**
     * @var string 가맹점 거래 고유번호
     */
    protected $merchant_uid;

    /**
     * @var float 결제금액
     */
    protected $amount;

    /**
     * @var string 바코드 번호
     */
    protected $barcode;

    /**
     * @var int 수납 만료시각 UNIX TIMESTAMP
     */
    protected $expired_at;

    /**
     * @var string 주문명
     */
    protected $name;

    /**
     * @var string 구매자 이름
     */
    protected $buyer_name;

    /**
     * @var string 구매자 Email
     */
    protected $buyer_email;

    /**
     * @var string 구매자 전화번호
     */
    protected $buyer_tel;

    /**
     * @var string 구매자 주소
     */
    protected $buyer_addr;

    /**
     * @var string 구매자 우편번호
     */
    protected $buyer_postcode;

    /**
     * @var string 수납 확인 URL
     */
    protected $confirm_url;

    /**
     * @var array 수납 통지 URL
     */
    protected $notice_url;

    /**
     * @var string 결제정보와 함께 저장할 custom_data
     */
    protected $custom_data;

    /**
     * @var string HTTP verb
     */
    private $verb;

    /**
     * Cvs constructor.
     */
    public function __construct()
    {
    }

    /**
     * 수납번호 발급.
     *
     * @return Cvs
     */
    public static function issue(string $channelKey, string $merchantUid, float $amount)
    {
        $instance                = new self();
        $instance->channel_key   = $channelKey;
        $instance->merchant_uid  = $merchantUid;
        $instance->amount        = $amount;
        $instance->responseClass = Response\Payment::class;
        $instance->instanceType  = 'issue';
        $instance->verb          = 'POST';
        $instance->unsetArray(['imp_uid']);

        return $instance;
    }

    /**
     * 수납취소.
     *
     * @return Cvs
     */
    public static function revoke(string $impUid)
    {
        $instance                = new self();
        $instance->imp_uid       = $impUid;
        $instance->responseClass = Response\Payment::class;
        $instance->instanceType  = 'revoke';
        $instance->verb          = 'DELETE';
        $instance->unsetArray([
            'channel_key', 'merchant_uid', 'amount', 'barcode', 'expired_at',
            'name', 'buyer_name', 'buyer_email', 'buyer_tel', 'buyer_addr',
            'buyer_postcode', 'confirm_url', 'notice_url', 'custom_data',
        ]);

        return $instance;
    }

    public function setChannelKey(string $channel_key): void
    {
        $this->channel_key = $channel_key;
    }

    public function setMerchantUid(string $merchant_uid): void
    {
        $this->merchant_uid = $merchant_uid;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function setBarcode(string $barcode): void
    {
        $this->barcode = $barcode;
    }

    /**
     * @param mixed $expired_at
     */
    public function setExpiredAt($expired_at): void
    {
        $this->expired_at = $this->dateToTimestamp($expired_at);
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

    public function setConfirmUrl(string $confirm_url): void
    {
        $this->confirm_url = $confirm_url;
    }

    public function setNoticeUrl(array $notice_url): void
    {
        $this->notice_url = $notice_url;
    }

    public function setCustomData(string $custom_data): void
    {
        $this->custom_data = $custom_data;
    }

    /**
     * 수납번호 발급
     * [POST] /cvs.
     *
     * 수납취소
     * [DELETE] /cvs/{imp_uid}
     */
    public function path(): string
    {
        switch ($this->instanceType) {
            case 'issue':
                return Endpoint::CVS;
                break;
            case 'revoke':
                return Endpoint::CVS . '/' . $this->imp_uid;
                break;
            default:
                return '';
        }
    }

    public function attributes(): array
    {
        if ($this->instanceType === 'issue') {
            return [
                'body' => json_encode($this->toArray()),
            ];
        } else {
            return [];
        }
    }

    public function verb(): string
    {
        return $this->verb;
    }
}
