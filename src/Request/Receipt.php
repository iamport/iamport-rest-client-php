<?php

namespace Iamport\RestClient\Request;

use Iamport\RestClient\Enum\Endpoint;

/**
 * Class Receipt.
 *
 * @property string $imp_uid
 * @property string $identifier
 * @property string $identifier_type
 * @property string $type
 * @property string $buyer_name
 * @property string $buyer_email
 * @property string $buyer_tel
 * @property int    $tax_free
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
    private $imp_uid;

    /**
     * @var string 현금영수증 발행대상 식별정보 국세청현금영수증카드, 휴대폰번호, 주민등록번호, 사업자등록번호
     */
    private $identifier;

    /**
     * @var string 현금영수증 발행대상 식별정보 유형. [ person, business, phone, taxcard ].
     */
    private $identifier_type;

    /**
     * @var string 현금영수증 발행 타입(대상). [ person, company ].
     */
    private $type;

    /**
     * @var string 구매자 이름 (현금영수증 발행건 사후 추적을 위해 입력을 강력히 권장합니다)
     */
    private $buyer_name;

    /**
     * @var string 구매자 Email
     */
    private $buyer_email;

    /**
     * @var string 구매자 전화번호 (현금영수증 발행건 사후 추적을 위해 입력을 강력히 권장합니다
     */
    private $buyer_tel;

    /**
     * @var int 현금영수증 발행금액 중 면세금액 지정하지 않으면 0원으로 적용
     */
    private $tax_free;

    /**
     * Receipt GET constructor.
     * 발행된 현금영수증 조회.
     * [GET] /receipts/{$impUid}.
     *
     * @param string $impUid
     *
     * @return Receipt
     */
    public static function view(string $impUid)
    {
        $instance = new self();
        $instance->setImpUid($impUid);
        $instance->verb = 'GET';

        return $instance;
    }

    /**
     * Receipt POST constructor.
     * 현금영수증 발행.
     * [POST] /receipts/{$impUid}.
     *
     * @param string $impUid
     * @param string $identifier
     *
     * @return Receipt
     */
    public static function issue(string $impUid, string $identifier)
    {
        $instance = new self();
        $instance->setImpUid($impUid);
        $instance->setIdentifier($identifier);
        $instance->verb = 'POST';

        return $instance;
    }

    /**
     * Receipt DELETE constructor.
     * 현금영수증 발급 취소.
     * [DELETE] /receipts/{$impUid}.
     *
     * @param string $impUid
     *
     * @return Receipt
     */
    public static function cancel(string $impUid)
    {
        $instance = new self();
        $instance->setImpUid($impUid);
        $instance->verb = 'DELETE';

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
     * @param string $identifier
     */
    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }

    /**
     * @param string $identifier_type
     */
    public function setIdentifierType(string $identifier_type): void
    {
        $this->identifier_type = $identifier_type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
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
     * @param int $tax_free
     */
    public function setTaxFree(int $tax_free): void
    {
        $this->tax_free = $tax_free;
    }

    /**
     * @return string
     */
    public function path(): string
    {
        return Endpoint::RECEIPT.$this->imp_uid;
    }

    /**
     * @return array
     */
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

    /**
     * @return string
     */
    public function verb(): string
    {
        return $this->verb;
    }
}
