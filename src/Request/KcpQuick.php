<?php

namespace Iamport\RestClient\Request;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Response;

/**
 * Class KcpQuick.
 *
 * @property string $member_id
 * @property string $site_code
 * @property string $partner_type
 * @property string $partner_subtype
 * @property string $channel_key
 * @property string $merchant_uid
 * @property string $name
 * @property int    $amount
 * @property string $notice_url
 */
class KcpQuick extends RequestBase
{
    use RequestTrait;

    /**
     * @var string 고객 고유번호
     */
    protected $member_id;

    /**
     * @var string KCP 사이트코드
     */
    protected $site_code;

    /**
     * @var string 파트너 타입
     */
    protected $partner_type;

    /**
     * @var string 파트너 서브타입
     */
    protected $partner_subtype;

    /**
     * @var string 채널키
     */
    protected $channel_key;

    /**
     * @var string 가맹점 거래 고유번호
     */
    protected $merchant_uid;

    /**
     * @var string 주문명
     */
    protected $name;

    /**
     * @var int 결제금액
     */
    protected $amount;

    /**
     * @var string 결제통지 URL
     */
    protected $notice_url;

    /**
     * @var string HTTP verb
     */
    private $verb;

    /**
     * KcpQuick constructor.
     */
    public function __construct()
    {
    }

    /**
     * KCP 퀵페이 구매자 정보 삭제.
     *
     * @return KcpQuick
     */
    public static function deleteMember(string $memberId, string $siteCode, string $partnerType, string $partnerSubtype)
    {
        $instance                   = new self();
        $instance->member_id        = $memberId;
        $instance->site_code        = $siteCode;
        $instance->partner_type     = $partnerType;
        $instance->partner_subtype  = $partnerSubtype;
        $instance->responseClass    = Response\KcpQuickMember::class;
        $instance->instanceType     = 'deleteMember';
        $instance->verb             = 'DELETE';
        $instance->unsetArray(['channel_key', 'merchant_uid', 'name', 'amount', 'notice_url']);

        return $instance;
    }

    /**
     * KCP 선불머니 결제.
     *
     * @return KcpQuick
     */
    public static function payMoney(string $memberId, string $channelKey, string $merchantUid, string $name, int $amount)
    {
        $instance                = new self();
        $instance->member_id     = $memberId;
        $instance->channel_key   = $channelKey;
        $instance->merchant_uid  = $merchantUid;
        $instance->name          = $name;
        $instance->amount        = $amount;
        $instance->responseClass = Response\Payment::class;
        $instance->instanceType  = 'payMoney';
        $instance->verb          = 'POST';
        $instance->unsetArray(['site_code', 'partner_type', 'partner_subtype']);

        return $instance;
    }

    public function setMemberId(string $member_id): void
    {
        $this->member_id = $member_id;
    }

    public function setSiteCode(string $site_code): void
    {
        $this->site_code = $site_code;
    }

    public function setPartnerType(string $partner_type): void
    {
        $this->partner_type = $partner_type;
    }

    public function setPartnerSubtype(string $partner_subtype): void
    {
        $this->partner_subtype = $partner_subtype;
    }

    public function setChannelKey(string $channel_key): void
    {
        $this->channel_key = $channel_key;
    }

    public function setMerchantUid(string $merchant_uid): void
    {
        $this->merchant_uid = $merchant_uid;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function setNoticeUrl(string $notice_url): void
    {
        $this->notice_url = $notice_url;
    }

    /**
     * KCP 퀵페이 구매자 정보 삭제
     * [DELETE] /kcpquick/members/{member_id}.
     *
     * KCP 선불머니 결제
     * [POST] /kcpquick/payment/money
     */
    public function path(): string
    {
        switch ($this->instanceType) {
            case 'deleteMember':
                return Endpoint::KCPQUICK_MEMBERS . $this->member_id;
                break;
            case 'payMoney':
                return Endpoint::KCPQUICK_PAYMENT_MONEY;
                break;
            default:
                return '';
        }
    }

    public function attributes(): array
    {
        switch ($this->instanceType) {
            case 'deleteMember':
                return [
                    'query' => [
                        'site_code'       => $this->site_code,
                        'partner_type'    => $this->partner_type,
                        'partner_subtype' => $this->partner_subtype,
                    ],
                ];
                break;
            case 'payMoney':
                return [
                    'body' => json_encode($this->toArray()),
                ];
                break;
            default:
                return [];
        }
    }

    public function verb(): string
    {
        return $this->verb;
    }
}
