<?php

namespace Iamport\RestClient\Request;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Response;

/**
 * Class Benepia.
 *
 * @property string $benepia_user
 * @property string $benepia_password
 * @property string $benepia_member_code
 * @property string $channel_key
 * @property string $merchant_uid
 * @property float  $amount
 * @property string $name
 * @property string $buyer_name
 * @property string $buyer_email
 * @property string $buyer_tel
 * @property string $buyer_addr
 * @property string $buyer_postcode
 * @property array  $notice_url
 * @property string $custom_data
 */
class Benepia extends RequestBase
{
    use RequestTrait;

    /**
     * @var string 베네피아 계정 아이디
     */
    protected $benepia_user;

    /**
     * @var string 베네피아 계정 비밀번호
     */
    protected $benepia_password;

    /**
     * @var string 베네피아 기관에서 부여한 회원사 코드
     */
    protected $benepia_member_code;

    /**
     * @var string 베네피아 포인트 조회 시 사용할 채널의 채널키
     */
    protected $channel_key;

    /**
     * @var string 가맹점 거래 고유번호
     */
    protected $merchant_uid;

    /**
     * @var float 결제요청금액
     */
    protected $amount;

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
     * @var array 가상계좌 입금시 입금통지받을 URL
     */
    protected $notice_url;

    /**
     * @var string 결제정보와 함께 저장할 custom_data
     */
    protected $custom_data;

    /**
     * Benepia constructor.
     */
    public function __construct()
    {
    }

    /**
     * 베네피아 포인트 조회.
     *
     * @return Benepia
     */
    public static function point(string $benepiaUser, string $benepiaPassword, string $channelKey)
    {
        $instance                    = new self();
        $instance->benepia_user      = $benepiaUser;
        $instance->benepia_password  = $benepiaPassword;
        $instance->channel_key       = $channelKey;
        $instance->responseClass     = Response\BenepiaPoint::class;
        $instance->instanceType      = 'point';
        $instance->unsetArray([
            'benepia_member_code', 'merchant_uid', 'amount', 'name',
            'buyer_name', 'buyer_email', 'buyer_tel', 'buyer_addr',
            'buyer_postcode', 'notice_url', 'custom_data',
        ]);

        return $instance;
    }

    /**
     * 베네피아 포인트 결제 요청.
     *
     * @return Benepia
     */
    public static function payment(string $benepiaUser, string $benepiaPassword, string $channelKey, string $merchantUid, float $amount, string $name)
    {
        $instance                    = new self();
        $instance->benepia_user      = $benepiaUser;
        $instance->benepia_password  = $benepiaPassword;
        $instance->channel_key       = $channelKey;
        $instance->merchant_uid      = $merchantUid;
        $instance->amount            = $amount;
        $instance->name              = $name;
        $instance->responseClass     = Response\Payment::class;
        $instance->instanceType      = 'payment';

        return $instance;
    }

    public function setBenepiaUser(string $benepia_user): void
    {
        $this->benepia_user = $benepia_user;
    }

    public function setBenepiaPassword(string $benepia_password): void
    {
        $this->benepia_password = $benepia_password;
    }

    public function setBenepiaMemberCode(string $benepia_member_code): void
    {
        $this->benepia_member_code = $benepia_member_code;
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

    public function setNoticeUrl(array $notice_url): void
    {
        $this->notice_url = $notice_url;
    }

    public function setCustomData(string $custom_data): void
    {
        $this->custom_data = $custom_data;
    }

    /**
     * 베네피아 포인트 조회
     * [POST] /benepia/point.
     *
     * 베네피아 포인트 결제 요청
     * [POST] /benepia/payment
     */
    public function path(): string
    {
        switch ($this->instanceType) {
            case 'point':
                return Endpoint::BENEPIA_POINT;
                break;
            case 'payment':
                return Endpoint::BENEPIA_PAYMENT;
                break;
            default:
                return '';
        }
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
