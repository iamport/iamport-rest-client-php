<?php

namespace Iamport\RestClient\Request;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Response;

/**
 * Class NaverPlace.
 *  TODO: 207 response 처리 작업 필요.
 *
 * @property string $imp_uid
 * @property array  $product_order_id
 */
class NaverPlace extends RequestBase
{
    use RequestTrait;

    /**
     * @var string 아임포트 고유번호
     */
    protected $imp_uid;

    /**
     * @var array 환불할 거래건의 네이버페이 상품주문번호
     */
    protected $product_order_id = [];

    /**
     * NaverCancel constructor.
     *
     * @param string $imp_uid
     */
    public function __construct(string $imp_uid)
    {
        $this->imp_uid       = $imp_uid;
        $this->responseClass = Response\NaverProductOrder::class;
    }

    /**
     * @param array $product_order_id
     */
    public function setProductOrderId(array $product_order_id): void
    {
        $this->product_order_id = $product_order_id;
    }

    /**
     * 주문형-네이버페이 상품주문들을 발주처리합니다
     * [POST] /payments/{imp_uid}/naver/place.
     *
     * @return string
     */
    public function path(): string
    {
        return Endpoint::PAYMENTS . $this->imp_uid . Endpoint::NAVER_PLACE;
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
