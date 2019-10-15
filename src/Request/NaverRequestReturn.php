<?php

namespace Iamport\RestClient\Request;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Response;
use InvalidArgumentException;

/**
 * Class NaverRequestReturn.
 *
 * @property string $imp_uid
 * @property array $product_order_id
 * @property string $reason
 * @property string $delivery_method
 * @property string $delivery_company
 * @property string $tracking_number
 */
class NaverRequestReturn extends RequestBase
{
    use RequestTrait;

    /**
     * @var string 아임포트 고유번호
     */
    protected $imp_uid;

    /**
     * @var array 네이버페이 상품주문번호
     */
    protected $product_order_id = [];

    /**
     * @var string 반품사유코드
     */
    protected $reason = 'INTENT_CHANGED';

    /**
     * @var string 반품 배송방법 코드
     */
    protected $delivery_method;

    /**
     * @var string 택배사 코드
     */
    protected $delivery_company;

    /**
     * @var string 송장번호
     */
    protected $tracking_number;

    /**
     * NaverRequestReturn constructor.
     * @param string $imp_uid
     * @param string $delivery_method
     */
    public function __construct(string $imp_uid, string $delivery_method)
    {
        $this->imp_uid = $imp_uid;
        if( !in_array($delivery_method, ['RETURN_DESIGNATED', 'RETURN_DELIVERY', 'RETURN_INDIVIDUAL'])){
            throw new InvalidArgumentException('허용되지 않는 delivery_method 값 입니다. (RETURN_DESIGNATED, RETURN_DELIVERY, RETURN_INDIVIDUAL)');
        }
        $this->delivery_method = $delivery_method;
        $this->responseClass = Response\NaverProductOrder::class;
        $this->instanceType  = 'request';
    }

    /**
     * @param array $product_order_id
     */
    public function setProductOrderId(array $product_order_id): void
    {
        $this->product_order_id = $product_order_id;
    }

    /**
     * @param string $reason
     */
    public function setReason(string $reason): void
    {
        $this->reason = $reason;
    }

    /**
     * @param string $delivery_company
     */
    public function setDeliveryCompany(string $delivery_company): void
    {
        $this->delivery_company = $delivery_company;
    }

    /**
     * @param string $tracking_number
     */
    public function setTrackingNumber(string $tracking_number): void
    {
        $this->tracking_number = $tracking_number;
    }

    /**
     * 주문형-네이버페이 상품주문들을 반품요청합니다
     * [POST] /payments/{imp_uid}/naver/request-return
     *
     * @return string
     */
    public function path(): string
    {
        return Endpoint::PAYMENTS . $this->imp_uid . Endpoint::NAVER_REQUEST_RETURN;
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
