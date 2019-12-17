<?php

namespace Iamport\RestClient\Request;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Response;

/**
 * Class Receipt.
 *
 * @property string $imp_uid
 * @property string $merchant_uid
 * @property string $name
 * @property int    $amount
 * @property string $identifier
 * @property string $identifier_type
 * @property string $type
 * @property string $buyer_name
 * @property string $buyer_email
 * @property string $buyer_tel
 * @property int    $tax_free
 * @property string $pg
 */
class Receipt extends RequestBase
{
    use RequestTrait;

    /**
     * @var string HTTP verb
     */
    private $verb;

    /**
     * @var string 아임포트 거래 고유번호
     */
    protected $imp_uid;

    /**
     * @var string 현금영수증 발행 주문번호
     */
    protected $merchant_uid;

    /**
     * @var int 현금영수증 발행 주문명
     */
    protected $name;

    /**
     * @var int 현금영수증 발행 금액
     */
    protected $amount;

    /**
     * @var string 현금영수증 발행대상 식별정보 국세청현금영수증카드, 휴대폰번호, 주민등록번호, 사업자등록번호
     */
    protected $identifier;

    /**
     * @var string 현금영수증 발행대상 식별정보 유형. [ person, business, phone, taxcard ].
     */
    protected $identifier_type;

    /**
     * @var string 현금영수증 발행 타입(대상). [ person, company ].
     */
    protected $type = 'person';

    /**
     * @var string 구매자 이름 (현금영수증 발행건 사후 추적을 위해 입력을 강력히 권장합니다)
     */
    protected $buyer_name;

    /**
     * @var string 구매자 Email
     */
    protected $buyer_email;

    /**
     * @var string 구매자 전화번호 (현금영수증 발행건 사후 추적을 위해 입력을 강력히 권장합니다
     */
    protected $buyer_tel;

    /**
     * @var int 현금영수증 발행금액 중 면세금액 지정하지 않으면 0원으로 적용
     */
    protected $tax_free;

    /**
     * @var string PG설정이 2개 이상인 경우, 현금영수증 발행처리를 원하는 PG사를 지정
     */
    protected $pg;

    /**
     * Receipt constructor.
     */
    public function __construct()
    {
    }

    /**
     * Receipt GET constructor.
     * 발행된 현금영수증 조회.
     *
     * @return Receipt
     */
    public static function view(string $impUid)
    {
        $instance                = new self();
        $instance->imp_uid       = $impUid;
        $instance->responseClass = Response\Receipt::class;
        $instance->verb          = 'GET';
        $instance->instanceType  = 'view';
        $instance->unsetArray([
            'merchant_uid', 'name', 'amount', 'identifier', 'identifier_type',
            'type', 'buyer_name', 'buyer_email', 'buyer_tel', 'tax_free', 'pg',
        ]);

        return $instance;
    }

    /**
     * 현금영수증 발행.
     *
     * @return Receipt
     */
    public static function issue(string $impUid, string $identifier)
    {
        $instance                     = new self();
        $instance->imp_uid            = $impUid;
        $instance->identifier         = $identifier;
        $instance->responseClass      = Response\Receipt::class;
        $instance->verb               = 'POST';
        $instance->instanceType       = 'issue';
        $instance->unsetArray(['merchant_uid', 'name', 'amount', 'pg']);

        return $instance;
    }

    /**
     * 현금영수증 발급 취소.
     *
     * @return Receipt
     */
    public static function cancel(string $impUid)
    {
        $instance                     = new self();
        $instance->imp_uid            = $impUid;
        $instance->responseClass      = Response\Receipt::class;
        $instance->verb               = 'DELETE';
        $instance->instanceType       = 'issue';
        $instance->unsetArray(['merchant_uid', 'name', 'amount']);

        return $instance;
    }

    /**
     * 아임포트와 별개로 결제된 현금거래건의 현금영수증 조회.
     *
     * @return Receipt
     */
    public static function viewExternal(string $merchantUid)
    {
        $instance                     = new self();
        $instance->merchant_uid       = $merchantUid;
        $instance->responseClass      = Response\ExternalReceipt::class;
        $instance->verb               = 'GET';
        $instance->instanceType       = 'viewExternal';
        $instance->unsetArray([
            'imp_uid', 'name', 'amount', 'identifier', 'identifier_type', 'type',
            'buyer_name', 'buyer_email', 'buyer_tel', 'tax_free', 'pg',
        ]);

        return $instance;
    }

    /**
     * 아임포트와 별개로 결제된 현금거래건의 현금영수증 발행.
     *
     * @return Receipt
     */
    public static function issueExternal(string $merchantUid, string $name, int $amount, string $identifier)
    {
        $instance                     = new self();
        $instance->merchant_uid       = $merchantUid;
        $instance->name               = $name;
        $instance->amount             = $amount;
        $instance->identifier         = $identifier;
        $instance->responseClass      = Response\ExternalReceipt::class;
        $instance->verb               = 'POST';
        $instance->instanceType       = 'issueExternal';
        $instance->unsetArray([
            'imp_uid', 'name', 'amount', 'identifier', 'identifier_type',
            'type', 'buyer_name', 'buyer_email', 'buyer_tel', 'tax_free', 'pg',
        ]);

        return $instance;
    }

    /**
     * 아임포트와 별개로 결제된 현금거래건의 현금영수증 발급 취소.
     *
     * @return Receipt
     */
    public static function cancelExternal(string $merchantUid)
    {
        $instance                = new self();
        $instance->merchant_uid  = $merchantUid;
        $instance->responseClass = Response\ExternalReceipt::class;
        $instance->verb          = 'DELETE';
        $instance->instanceType  = 'cancelExternal';
        $instance->unsetArray([
            'imp_uid', 'name', 'amount', 'identifier', 'identifier_type', 'type',
            'buyer_name', 'buyer_email', 'buyer_tel', 'tax_free', 'pg',
        ]);

        return $instance;
    }

    public function setImpUid(string $imp_uid): void
    {
        $this->imp_uid = $imp_uid;
    }

    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }

    public function setIdentifierType(string $identifier_type): void
    {
        $this->identifier_type = $identifier_type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
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

    public function setTaxFree(int $tax_free): void
    {
        $this->tax_free = $tax_free;
    }

    public function setMerchantUid(string $merchant_uid): void
    {
        $this->merchant_uid = $merchant_uid;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setAmount(string $amount): void
    {
        $this->amount = $amount;
    }

    public function setPg(string $pg): void
    {
        $this->pg = $pg;
    }

    public function valid(): bool
    {
        switch ($this->instanceType) {
            case 'view':
            case 'viewExternal':
            case 'cancel':
            case 'cancelExternal':
                return true;
                break;
            case 'issue':
            case 'issueExternal':
                if (!in_array($this->type, ['person', 'company'])) {
                    return false;
                }
                break;
            default:
                return true;
        }
    }

    public function path(): string
    {
        switch ($this->instanceType) {
            case 'view':
            case 'issue':
            case 'cancel':
                return Endpoint::RECEIPT . $this->imp_uid;
                break;
            case 'viewExternal':
            case 'issueExternal':
            case 'cancelExternal':
                return Endpoint::RECEIPT_EXTERNAL . $this->merchant_uid;
                break;
            default:
                return true;
        }
    }

    public function attributes(): array
    {
        if ($this->verb === 'POST') {
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
