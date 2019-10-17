<?php

namespace Iamport\RestClient\Request\Naver;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Request\RequestBase;
use Iamport\RestClient\Request\RequestTrait;
use Iamport\RestClient\Response\Naver\NaverCashAmount;
use Iamport\RestClient\Response\Naver\NaverProductOrder;
use Iamport\RestClient\Response\Naver\NaverReview;

/**
 * Class NaverInquiry.
 *
 * @property string $imp_uid
 * @property string $product_order_id
 * @property string $from
 * @property string $to
 * @property string $review_type general, premium
 */
class NaverInquiry extends RequestBase
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
     * @var string 네이버페이 구매평 조회기간 시작
     */
    protected $from;

    /**
     * @var string 네이버페이 구매평 조회기간 시작
     */
    protected $to;

    /**
     * @var string 네이버페이 구매평 유형 ( 일반: general, 프리미엄:premium )
     */
    protected $review_type;

    /**
     * 아임포트 거래 고유번호로 네이버페이 상품주문 목록을 조회.
     *
     * @param string $impUid
     *
     * @return NaverInquiry
     */
    public static function list(string $impUid)
    {
        $instance                = new self();
        $instance->imp_uid       = $impUid;
        $instance->isCollection  = true;
        $instance->responseClass = NaverProductOrder::class;

        return $instance;
    }

    /**
     * 네이버페이 상품주문번호로 단 건 조회.
     *
     * @param string $productOrderId
     *
     * @return NaverInquiry
     */
    public static function single(string $productOrderId)
    {
        $instance                   = new self();
        $instance->product_order_id = $productOrderId;
        $instance->responseClass    = NaverProductOrder::class;

        return $instance;
    }

    /**
     * 네이버페이 현금영수증 발급가능 금액 조회 API
     *
     * @param string $impUid
     *
     * @return NaverInquiry
     */
    public static function cashReceipt(string $impUid)
    {
        $instance                = new self();
        $instance->imp_uid       = $impUid;
        $instance->responseClass = NaverCashAmount::class;

        return $instance;
    }

    /**
     * 네이버페이 구매평 조회 API
     * TODO: 로컬 api 서버에서 Internal Server Error 던져주는데 실제 api.iamport.kr 혹은fake 데이터 생기면 테스트 요망
     *
     * @param string $from
     * @param string $to
     * @param string $reviewType
     *
     * @return NaverInquiry
     */
    public static function reviews(string $from, string $to, string $reviewType)
    {
        $instance                = new self();
        $instance->from          = strtotime(date($from));
        $instance->to            = strtotime(date($to));
        $instance->review_type   = $reviewType;
        $instance->responseClass = NaverReview::class;

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
     * [GET] /payments/{$imp_uid}/naver/product-orders.
     *
     * 네이버페이 상품주문번호 기준 네이버페이 상품주문을 조회합니다. (단건 반환)
     * [GET] /naver/product-orders/{$product_order_id}
     *
     * 주문형-네이버페이 구매평 조회 API
     * [GET] /naver/reviews
     *
     * 결제형-네이버페이 현금영수증 발급가능 금액 조회 API
     * [GET] /payments/{imp_uid}/naver/cash-amount
     *
     * @return string
     */
    public function path(): string
    {
        if ($this->responseClass === NaverProductOrder::class) {
            if ($this->isCollection) {
                return Endpoint::PAYMENTS . $this->imp_uid . Endpoint::NAVER_PRODUCT_ORDERS;
            } else {
                return Endpoint::NAVER_PRODUCT_ORDERS . '/' . $this->product_order_id;
            }
        } elseif ($this->responseClass === NaverReview::class) {
            return Endpoint::NAVER_REVIEWS;
        } elseif ($this->responseClass === NaverCashAmount::class) {
            return Endpoint::PAYMENTS . $this->imp_uid . Endpoint::NAVER_CASH_AMOUNT;
        }
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        if ($this->responseClass === NaverReview::class) {
            return [
                'query' => [
                    'from'        => $this->from,
                    'to'          => $this->to,
                    'review_type' => $this->review_type,
                ],
            ];
        }

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
