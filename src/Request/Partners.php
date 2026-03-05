<?php

namespace Iamport\RestClient\Request;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Response;

/**
 * Class Partners.
 *
 * @property string $imp_uid
 * @property array  $data
 */
class Partners extends RequestBase
{
    use RequestTrait;

    /**
     * @var string 아임포트 고유번호
     */
    protected $imp_uid;

    /**
     * @var array 하위 상점 거래 데이터
     */
    protected $data = [];

    /**
     * Partners constructor.
     */
    public function __construct()
    {
    }

    /**
     * 영수증 내 하위 상점 거래 등록.
     *
     * @return Partners
     */
    public static function receipt(string $impUid, array $data)
    {
        $instance                = new self();
        $instance->imp_uid       = $impUid;
        $instance->data          = $data;
        $instance->responseClass = Response\PartnerReceipt::class;
        $instance->instanceType  = 'receipt';

        return $instance;
    }

    public function setImpUid(string $imp_uid): void
    {
        $this->imp_uid = $imp_uid;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * 영수증 내 하위 상점 거래 등록
     * [POST] /partners/receipts/{imp_uid}.
     */
    public function path(): string
    {
        return Endpoint::PARTNERS_RECEIPTS . $this->imp_uid;
    }

    public function attributes(): array
    {
        return [
            'body' => json_encode(['data' => $this->data]),
        ];
    }

    public function verb(): string
    {
        return 'POST';
    }
}
