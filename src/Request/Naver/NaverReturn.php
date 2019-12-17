<?php

namespace Iamport\RestClient\Request\Naver;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Enum\Naver\DeliveryCompany;
use Iamport\RestClient\Enum\Naver\RejectHoldReason;
use Iamport\RestClient\Enum\Naver\ReturnDeliveryMethod;
use Iamport\RestClient\Enum\Naver\ReturnReason;
use Iamport\RestClient\Request\RequestBase;
use Iamport\RestClient\Request\RequestTrait;
use Iamport\RestClient\Response\Naver\NaverProductOrder;
use InvalidArgumentException;

/**
 * Class NaverReturn.
 *
 * @property string $imp_uid
 * @property array  $product_order_id
 * @property string $reason
 * @property string $delivery_method
 * @property string $delivery_company
 * @property string $tracking_number
 * @property int    $extra_charge
 * @property string $memo
 */
class NaverReturn extends RequestBase
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
    protected $reason;

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
     * @var int 기타 비용 청구액(기본값 : 0원)
     */
    protected $extra_charge = 0;

    /**
     * @var string 반품승인 후 구매자에게 전달하는 메모
     */
    protected $memo;

    /**
     * 주문형-네이버페이 상품주문들을 반품요청.
     *
     * @return NaverReturn
     */
    public static function request(string $impUid, string $deliveryMethod)
    {
        $instance          = new self();
        $instance->imp_uid = $impUid;
        if (ReturnDeliveryMethod::validation($deliveryMethod)) {
            throw new InvalidArgumentException('허용되지 않는 delivery_method 값 입니다. ( ReturnDeliveryMethod::getAll()로 허용 가능한 값을 확인해주세요. )');
        }
        $instance->delivery_method = $deliveryMethod;
        $instance->reason          = ReturnReason::INTENT_CHANGED;
        $instance->isCollection    = true;
        $instance->responseClass   = NaverProductOrder::class;
        $instance->instanceType    = 'request';
        $instance->unsetArray(['extra_charge', 'memo']);

        return $instance;
    }

    /**
     * 주문형-네이버페이 상품주문들을 반품승인처리.
     *
     * @return NaverReturn
     */
    public static function approve(string $impUid)
    {
        $instance                  = new self();
        $instance->imp_uid         = $impUid;
        $instance->extra_charge    = 0;
        $instance->isCollection    = true;
        $instance->responseClass   = NaverProductOrder::class;
        $instance->instanceType    = 'approve';
        $instance->unsetArray(['reason', 'delivery_method', 'delivery_company', 'tracking_number']);

        return $instance;
    }

    /**
     * 주문형-네이버페이 반품요청 상품주문들을 반품거절처리.
     *
     * @return NaverReturn
     */
    public static function reject(string $impUid, string $memo)
    {
        $instance                  = new self();
        $instance->imp_uid         = $impUid;
        $instance->memo            = $memo;
        $instance->isCollection    = true;
        $instance->responseClass   = NaverProductOrder::class;
        $instance->instanceType    = 'reject';
        $instance->unsetArray(['reason', 'delivery_method', 'delivery_company', 'tracking_number', 'extra_charge']);

        return $instance;
    }

    /**
     * 주문형-네이버페이 반품요청 상품주문들을 반품보류처리.
     *
     * @return NaverReturn
     */
    public static function withhold(string $impUid, string $memo)
    {
        $instance                  = new self();
        $instance->imp_uid         = $impUid;
        $instance->memo            = $memo;
        $instance->reason          = RejectHoldReason::ETC;
        $instance->extra_charge    = 0;
        $instance->isCollection    = true;
        $instance->responseClass   = NaverProductOrder::class;
        $instance->instanceType    = 'withhold';
        $instance->unsetArray(['delivery_method', 'delivery_company', 'tracking_number']);

        return $instance;
    }

    /**
     * 주문형-네이버페이 반품보류 상품주문들을 반품보류해제처리.
     *
     * @return NaverReturn
     */
    public static function resolve(string $impUid)
    {
        $instance                  = new self();
        $instance->imp_uid         = $impUid;
        $instance->isCollection    = true;
        $instance->responseClass   = NaverProductOrder::class;
        $instance->instanceType    = 'resolve';
        $instance->unsetArray([
            'reason', 'delivery_method', 'delivery_company', 'tracking_number', 'extra_charge', 'memo',
        ]);

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

    public function setDeliveryCompany(string $delivery_company): void
    {
        $this->delivery_company = $delivery_company;
    }

    public function setTrackingNumber(string $tracking_number): void
    {
        $this->tracking_number = $tracking_number;
    }

    public function setExtraCharge(int $extra_charge): void
    {
        $this->extra_charge = $extra_charge;
    }

    public function setMemo(string $memo): void
    {
        $this->memo = $memo;
    }

    public function valid(): bool
    {
        switch ($this->instanceType) {
            case 'request':
                if ($this->delivery_method === ReturnDeliveryMethod::RETURN_DELIVERY) {
                    if (is_null($this->delivery_company) || $this->delivery_company === '') {
                        return false;
                    } else {
                        if (DeliveryCompany::validation($this->delivery_company)) {
                            return false;
                        }
                    }
                    if (is_null($this->tracking_number) || $this->tracking_number === '') {
                        return false;
                    }

                    return true;
                }
                if (ReturnReason::validation($this->reason)) {
                    return false;
                }

                return true;
                break;
            case 'withhold':
                if (RejectHoldReason::validation($this->reason)) {
                    return false;
                }
                break;
            case 'approve':
            case 'reject':
            case 'resolve':
                return true;
                break;
            default:
                return false;
        }
    }

    /**
     * 주문형-네이버페이 상품주문들을 반품요청
     * [POST] /payments/{imp_uid}/naver/request-return.
     *
     * 주문형-네이버페이 상품주문들을 반품승인처리
     * [POST] /payments/{imp_uid}/naver/approve-return
     *
     * 주문형-네이버페이 반품요청상품 반품거절 처리
     * [POST] /payments/{imp_uid}/naver/reject-return
     *
     * 주문형-네이버페이 반품요청상품 반품보류 처리
     * [POST] /payments/{imp_uid}/naver/withhold-return
     *
     * 주문형-네이버페이 반품보류상품 반품보류해제 처리
     * [POST] /payments/{imp_uid}/naver/resolve-return
     */
    public function path(): string
    {
        $endPoint = '';
        switch ($this->instanceType) {
            case 'request':
                $endPoint = Endpoint::NAVER_REQUEST_RETURN;
                break;
            case 'approve':
                $endPoint = Endpoint::NAVER_APPROVE_RETURN;
                break;
            case 'reject':
                $endPoint = Endpoint::NAVER_REJECT_RETURN;
                break;
            case 'withhold':
                $endPoint = Endpoint::NAVER_WITHHOLD_RETURN;
                break;
            case 'resolve':
                $endPoint = Endpoint::NAVER_RESOLVE_RETURN;
                break;
        }

        return Endpoint::PAYMENTS . $this->imp_uid . $endPoint;
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
