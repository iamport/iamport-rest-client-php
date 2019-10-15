<?php

namespace Iamport\RestClient\Request;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Enum\NaverCancelReason;
use Iamport\RestClient\Enum\NaverDeliveryCompany;
use Iamport\RestClient\Enum\NaverDeliveryMethod;
use Iamport\RestClient\Response;

/**
 * Class NaverRequestReturn.
 *
 * @property string $imp_uid
 * @property array  $product_order_id
 * @property string $reason
 * @property string $delivery_method
 * @property string $dispatched_at
 * @property string $delivery_company
 * @property string $tracking_number
 */
class NaverOrder extends RequestBase
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
     * @var string 취소 사유 코드
     */
    protected $reason = NaverCancelReason::PRODUCT_UNSATISFIED;

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
     * 주문형-네이버페이 상품주문들을 환불처리합니다.
     *
     * @param string $impUid
     *
     * @return NaverOrder
     */
    public static function cancel(string $impUid)
    {
        $instance                = new self();
        $instance->imp_uid       = $impUid;
        $instance->responseClass = Response\NaverProductOrder::class;
        $instance->instanceType  = 'cancel';

        unset($instance->delivery_method);
        unset($instance->dispatched_at);
        unset($instance->delivery_company);
        unset($instance->tracking_number);

        return $instance;
    }

    /**
     * 네이버페이 상품주문들을 발송처리.
     *
     * @param string $imp_uid
     * @param string $delivery_method
     * @param string $dispatched_at
     *
     * @return NaverOrder
     */
    public static function ship(string $imp_uid, string $delivery_method, string $dispatched_at)
    {
        $instance                   = new self();
        $instance->imp_uid          = $imp_uid;
        $instance->delivery_method  = $delivery_method;
        $instance->dispatched_at    = strtotime(date($dispatched_at));
        $instance->responseClass    = Response\NaverProductOrder::class;
        $instance->instanceType  = 'ship';

        unset($instance->reason);

        return $instance;
    }

    /**
     * 네이버페이 상품주문들을 발송처리.
     *
     * @param string $imp_uid
     * @param string $delivery_method
     *
     * @return NaverOrder
     */
    public static function exchange(string $imp_uid, string $delivery_method)
    {
        $instance                   = new self();
        $instance->imp_uid          = $imp_uid;
        $instance->delivery_method  = $delivery_method;
        $instance->responseClass    = Response\NaverProductOrder::class;
        $instance->instanceType  = 'exchange';

        unset($instance->reason);
        unset($instance->dispatched_at);

        return $instance;
    }

    public static function place(string $imp_uid)
    {
        $instance                   = new self();
        $instance->imp_uid          = $imp_uid;
        $instance->responseClass    = Response\NaverProductOrder::class;
        $instance->instanceType  = 'place';

        unset($instance->reason);
        unset($instance->delivery_method);
        unset($instance->dispatched_at);
        unset($instance->delivery_company);
        unset($instance->tracking_number);

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
     * @param string $reason
     */
    public function setReason(string $reason): void
    {
        $this->reason = $reason;
    }

    /**
     * @param string $delivery_method
     */
    public function setDeliveryMethod(string $delivery_method): void
    {
        $this->delivery_method = $delivery_method;
    }

    /**
     * @param string $dispatched_at
     */
    public function setDispatchedAt(string $dispatched_at): void
    {
        $this->dispatched_at = $dispatched_at;
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

    public function valid(): bool
    {
        switch ($this->instanceType){
            case 'ship':
            case 'exchange':
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
                break;
            default:
                return true;
        }
    }

    /**
     * 주문형-네이버페이 상품주문들을 환불처리합니다.
     * [POST] /payments/{imp_uid}/naver/cancel.
     *
     * 주문형-네이버페이 상품주문들을 발송처리합니다.
     * [POST] /payments/{imp_uid}/naver/ship.
     *
     * 주문형-네이버페이 교환승인된 상품주문들을 재발송처리합니다.
     * [POST] /payments/{imp_uid}/naver/ship-exchanged.
     *
     * 주문형-네이버페이 상품주문들을 발주처리합니다
     * [POST] /payments/{imp_uid}/naver/place.
     *
     * @return string
     */
    public function path(): string
    {
        switch ($this->instanceType){
            case 'cancel':
                return Endpoint::PAYMENTS . $this->imp_uid . Endpoint::NAVER_CANCEL;
                break;
            case 'ship':
                return Endpoint::PAYMENTS . $this->imp_uid . Endpoint::NAVER_SHIP;
                break;
            case 'exchange':
                return Endpoint::PAYMENTS . $this->imp_uid . Endpoint::NAVER_SHIP_EXCHANGED;
                break;
            case 'place':
                return Endpoint::PAYMENTS . $this->imp_uid . Endpoint::NAVER_PLACE;
                break;
            default:
                return '';
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
