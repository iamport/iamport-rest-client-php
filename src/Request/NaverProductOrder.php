<?php

namespace Iamport\RestClient\Request;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Response;

/**
 * Class NaverProductOrder.
 *
 * @property string $imp_uid
 */
class NaverProductOrder extends RequestBase
{
    use RequestTrait;

    /**
     * @var string 아임포트 고유번호
     */
    protected $imp_uid;

    /**
     * @var string 네이버페이 상품주문번호
     */
    protected $product_order_id;

    /**
     * Payment constructor.
     */
    public function __construct()
    {
        $this->responseClass = Response\NaverProductOrder::class;
    }

    /**
     * 아임포트 고유번호로 인스턴스 생성.
     *
     * @param string $impUid
     *
     * @return NaverProductOrder
     */
    public static function list(string $impUid)
    {
        $instance          = new self();
        $instance->imp_uid = $impUid;
        $instance->isCollection = true;

        return $instance;
    }

    /**
     * 네이버페이 상품주문번호로 단건 조회
     *
     * @param string $productOrderId
     *
     * @return NaverProductOrder
     */
    public static function single(string $productOrderId)
    {
        $instance               = new self();
        $instance->product_order_id = $productOrderId;

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
     * @param string $product_order_id
     */
    public function setProductOrderId(string $product_order_id): void
    {
        $this->product_order_id = $product_order_id;
    }

    /**
     * 아임포트 거래번호 기준으로 네이버페이 상품주문 목록을 조회합니다 (배열 반환)
     * [GET] /payments/{$imp_uid}/naver/product-orders
     *
     * 네이버페이 상품주문번호 기준 네이버페이 상품주문을 조회합니다. (단건 반환)
     * [GET] /naver/product-orders/{$product_order_id}
     *
     * @return string
     */
    public function path(): string
    {
        if ($this->isCollection) {
            return Endpoint::PAYMENTS.$this->imp_uid .Endpoint::NAVER_PRODUCT_ORDERS;
        } else {
            return Endpoint::NAVER_PRODUCT_ORDERS . '/' . $this->product_order_id;
        }
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [];
    }

    /**
     * @return string
     */
    public function verb(): string
    {
        return 'GET';
    }
}
