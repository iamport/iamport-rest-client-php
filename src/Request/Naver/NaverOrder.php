<?php

namespace Iamport\RestClient\Request\Naver;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Enum\Naver\CancelReason;
use Iamport\RestClient\Enum\Naver\DeliveryCompany;
use Iamport\RestClient\Enum\Naver\DeliveryMethod;
use Iamport\RestClient\Request\RequestBase;
use Iamport\RestClient\Request\RequestTrait;
use Iamport\RestClient\Response\Naver\NaverProductOrder;

/**
 * Class NaverOrder.
 *
 * @property string $imp_uid
 * @property array  $product_order_id
 * @property string $reason
 * @property string $delivery_method
 * @property mixed  $dispatched_at
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
    protected $reason = CancelReason::PRODUCT_UNSATISFIED;

    /**
     * @var string 배송방법 코드
     */
    protected $delivery_method = DeliveryMethod::DELIVERY;

    /**
     * @var mixed 발송일
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
     * @return NaverOrder
     */
    public static function cancel(string $impUid)
    {
        $instance                = new self();
        $instance->imp_uid       = $impUid;
        $instance->isCollection  = true;
        $instance->responseClass = NaverProductOrder::class;
        $instance->instanceType  = 'cancel';
        $instance->unsetArray(['delivery_method', 'dispatched_at', 'delivery_company', 'tracking_number']);

        return $instance;
    }

    /**
     * 네이버페이 상품주문들을 발송처리.
     *
     * @param mixed $dispatched_at
     *
     * @return NaverOrder
     */
    public static function ship(string $imp_uid, string $delivery_method, $dispatched_at)
    {
        $instance                   = new self();
        $instance->imp_uid          = $imp_uid;
        $instance->delivery_method  = $delivery_method;
        $instance->dispatched_at    = $instance->dateToTimestamp($dispatched_at);
        $instance->isCollection     = true;
        $instance->responseClass    = NaverProductOrder::class;
        $instance->instanceType     = 'ship';
        unset($instance->reason);

        return $instance;
    }

    /**
     * 네이버페이 상품주문들을 발송처리.
     *
     * @return NaverOrder
     */
    public static function shipExchange(string $imp_uid, string $delivery_method)
    {
        $instance                   = new self();
        $instance->imp_uid          = $imp_uid;
        $instance->delivery_method  = $delivery_method;
        $instance->isCollection     = true;
        $instance->responseClass    = NaverProductOrder::class;
        $instance->instanceType     = 'shipExchange';
        unset($instance->reason, $instance->dispatched_at);

        return $instance;
    }

    public static function place(string $imp_uid)
    {
        $instance                   = new self();
        $instance->imp_uid          = $imp_uid;
        $instance->isCollection     = true;
        $instance->responseClass    = NaverProductOrder::class;
        $instance->instanceType     = 'place';
        $instance->unsetArray(['reason', 'delivery_method', 'dispatched_at', 'delivery_company', 'tracking_number']);

        return $instance;
    }

    public function setProductOrderId(array $product_order_id): void
    {
        $this->product_order_id = $product_order_id;
    }

    public function setReason(string $reason): void
    {
        $this->reason = $reason;
    }

    public function setDeliveryMethod(string $delivery_method): void
    {
        $this->delivery_method = $delivery_method;
    }

    public function setDispatchedAt(string $dispatched_at): void
    {
        $this->dispatched_at = $dispatched_at;
    }

    public function setDeliveryCompany(string $delivery_company): void
    {
        $this->delivery_company = $delivery_company;
    }

    public function setTrackingNumber(string $tracking_number): void
    {
        $this->tracking_number = $tracking_number;
    }

    public function valid(): bool
    {
        switch ($this->instanceType) {
            case 'ship':
            case 'shipExchange':
                if (!DeliveryMethod::validation($this->delivery_method)) {
                    return false;
                }

                if ($this->delivery_method === DeliveryMethod::DELIVERY) {
                    if (is_null($this->delivery_company) || is_null($this->tracking_number)) {
                        return false;
                    }

                    if (!DeliveryCompany::validation($this->delivery_company)) {
                        return false;
                    }

                    return true;
                } else {
                    return true;
                }
                break;
            case 'cancel':
                if (!CancelReason::validation($this->reason)) {
                    return false;
                }

                return true;
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
     */
    public function path(): string
    {
        switch ($this->instanceType) {
            case 'cancel':
                return Endpoint::PAYMENTS . $this->imp_uid . Endpoint::NAVER_CANCEL;
                break;
            case 'ship':
                return Endpoint::PAYMENTS . $this->imp_uid . Endpoint::NAVER_SHIP;
                break;
            case 'shipExchange':
                return Endpoint::PAYMENTS . $this->imp_uid . Endpoint::NAVER_SHIP_EXCHANGED;
                break;
            case 'place':
                return Endpoint::PAYMENTS . $this->imp_uid . Endpoint::NAVER_PLACE;
                break;
            default:
                return '';
        }
    }

    public function attributes(): array
    {
        return [
            'body' => json_encode($this->toArray()),
        ];
    }

    public function verb(): string
    {
        return 'POST';
    }
}
