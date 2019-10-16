<?php


namespace Iamport\RestClient\Request;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Response;

/**
 * Class Payco.
 *
 * @property string imp_uid
 * @property string status
 */
class Payco extends RequestBase
{
    use RequestTrait;

    /**
     * @var string 아임포트 고유번호
     */
    protected $imp_uid;

    /**
     * @var string 주문상품 변경될 상태
     */
    protected $status;

    /**
     * 페이코 주문상품의 상태를 변경
     *
     * Payco constructor.
     * @param string $impUid
     * @param string $status
     */
    public function __construct(string $impUid, string $status)
    {
        $this->imp_uid = $impUid;
        $this->status = $status;
        $this->responseClass = Response\Payco::class;
    }

    /**
     * 페이코 주문상품의 상태를 변경
     * [POST] /payco/orders/status/{imp_uid}
     *
     * @return string
     */
    public function path(): string
    {
        return Endpoint::PAYCO . $this->imp_uid;
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'body' => json_encode($this->toArray()),
        ];
    }

    /**
     * @return string
     */
    public function verb(): string
    {
        return 'POST';
    }
}