<?php

namespace Iamport\RestClient\Request;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Enum\NaverDeliveryCompany;
use Iamport\RestClient\Enum\NaverDeliveryMethod;
use Iamport\RestClient\Response;

/**
 * Class NaverShip.
 *  TODO: 207 response 처리 작업 필요.
 *
 * @property string $imp_uid
 * @property array  $product_order_id
 * @property string $delivery_method
 * @property string $dispatched_at
 * @property string $delivery_company
 * @property string $tracking_number
 */
class NaverShip extends RequestBase
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
     * @var string 배송방법 코드
     */
    protected $delivery_method = NaverDeliveryMethod::DELIVERY;

    /**
     * @var string 발송일 unix timestamp
     */
    protected $dispatched_at;

    /**
     * @var string 택배사 코드
     */
    protected $delivery_company;

    /**
     * @var string 송장번호
     */
    protected $tracking_number;

    /**
     * 네이버페이 상품주문들을 발송처리.
     *
     * @param string $imp_uid
     * @param string $delivery_method
     * @param string $dispatched_at
     *
     * @return NaverShip
     */
    public static function ship(string $imp_uid, string $delivery_method, string $dispatched_at)
    {
        $instance                   = new self();
        $instance->imp_uid          = $imp_uid;
        $instance->delivery_method  = $delivery_method;
        $instance->dispatched_at    = strtotime(date($dispatched_at));
        $instance->responseClass    = Response\NaverProductOrder::class;

        return $instance;
    }

    /**
     * 네이버페이 상품주문들을 발송처리.
     *
     * @param string $imp_uid
     * @param string $delivery_method
     *
     * @return NaverShip
     */
    public static function exchange(string $imp_uid, string $delivery_method)
    {
        $instance                   = new self();
        $instance->imp_uid          = $imp_uid;
        $instance->delivery_method  = $delivery_method;
        $instance->responseClass    = Response\NaverProductOrder::class;
        unset($instance->dispatched_at);

        return $instance;
    }

    /**
     * @param array $product_order_id
     */
    public function setProductOrderId(array $product_order_id): void
    {
        $this->product_order_id = $product_order_id;
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
     * @return bool
     */
    public function valid(): bool
    {
        if (!NaverDeliveryMethod::validation($this->delivery_method)) {
            return false;
        }

        if ($this->delivery_method === NaverDeliveryMethod::DELIVERY) {
            if (is_null($this->delivery_company) || is_null($this->tracking_number)) {
                return false;
            }

            if (!NaverDeliveryCompany::validation($this->delivery_company)) {
                return false;
            }

            return true;
        } else {
            return true;
        }
    }

    /**
     * 주문형-네이버페이 상품주문들을 발송처리합니다.
     * [POST] /payments/{imp_uid}/naver/ship.
     *
     * 주문형-네이버페이 교환승인된 상품주문들을 재발송처리합니다.
     * [POST] /payments/{imp_uid}/naver/ship-exchanged.
     *
     * @return string
     */
    public function path(): string
    {
        if(isset($this->dispatched_at)){
            return Endpoint::PAYMENTS . $this->imp_uid . Endpoint::NAVER_SHIP;
        } else {
            return Endpoint::PAYMENTS . $this->imp_uid . Endpoint::NAVER_SHIP_EXCHANGED;
        }
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
