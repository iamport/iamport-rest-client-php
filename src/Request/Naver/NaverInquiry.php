<?php

namespace Iamport\RestClient\Request\Naver;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Request\RequestBase;
use Iamport\RestClient\Request\RequestTrait;
use Iamport\RestClient\Response\Naver\NaverCashAmount;
use Iamport\RestClient\Response\Naver\NaverProductOrder;
use Iamport\RestClient\Response\Naver\NaverReview;
use InvalidArgumentException;

/**
 * Class NaverInquiry.
 *
 * @property string $imp_uid
 * @property string $product_order_id
 * @property mixed  $from
 * @property mixed  $to
 * @property string $review_type      [general, premium]
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
     * @var mixed 네이버페이 구매평 조회기간 시작
     */
    protected $from;

    /**
     * @var mixed 네이버페이 구매평 조회기간 시작
     */
    protected $to;

    /**
     * @var string 네이버페이 구매평 유형 ( 일반: general, 프리미엄:premium )
     */
    protected $review_type;

    /**
     * 아임포트 거래 고유번호로 네이버페이 상품주문 목록을 조회.
     *
     * @return NaverInquiry
     */
    public static function list(string $impUid)
    {
        $instance                = new self();
        $instance->imp_uid       = $impUid;
        $instance->isCollection  = true;
        $instance->responseClass = NaverProductOrder::class;
        $instance->instanceType  = 'list';
        $instance->unsetArray(['project_order_id', 'from', 'to', 'review_type']);

        return $instance;
    }

    /**
     * 네이버페이 상품주문번호로 단 건 조회.
     *
     * @return NaverInquiry
     */
    public static function single(string $productOrderId)
    {
        $instance                   = new self();
        $instance->product_order_id = $productOrderId;
        $instance->responseClass    = NaverProductOrder::class;
        $instance->instanceType     = 'single';
        $instance->unsetArray(['imp_uid', 'from', 'to', 'review_type']);

        return $instance;
    }

    /**
     * 네이버페이 구매평 조회 API
     * TODO: 로컬 테스트 서버에서 Internal Server Error 던져주는데 실제 api.iamport.kr 혹은fake 데이터 생기면 테스트 요망.
     *
     * @param mixed $from
     * @param mixed $to
     *
     * @return NaverInquiry
     */
    public static function reviews($from, $to, string $reviewType = 'general')
    {
        $instance                = new self();
        $instance->from          = $instance->dateToTimestamp($from);
        $instance->to            = $instance->dateToTimestamp($to);
        $instance->review_type   = $reviewType;
        $instance->isCollection  = true;
        $instance->responseClass = NaverReview::class;
        $instance->instanceType  = 'reviews';
        $instance->unsetArray(['imp_uid', 'product_order_id']);

        return $instance;
    }

    /**
     * 네이버페이 현금영수증 발급가능 금액 조회 API.
     *
     * @return NaverInquiry
     */
    public static function cashAmount(string $impUid)
    {
        $instance                = new self();
        $instance->imp_uid       = $impUid;
        $instance->responseClass = NaverCashAmount::class;
        $instance->instanceType  = 'cashAmount';
        $instance->unsetArray(['product_order_id', 'from', 'to', 'review_type']);

        return $instance;
    }

    public function setImpUid(string $imp_uid): void
    {
        $this->imp_uid = $imp_uid;
    }

    public function setProductOrderId(string $product_order_id): void
    {
        $this->product_order_id = $product_order_id;
    }

    public function setReviewType(string $reviewType): void
    {
        if (!in_array($reviewType, ['general', 'premium'])) {
            throw new InvalidArgumentException('허용되지 않는 reviewType 값 입니다. [ general(일반구매평) 혹은 premium(프리미엄 구매평)만 가능합니다. ]');
        }
        $this->review_type = $reviewType;
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
     */
    public function path(): string
    {
        switch ($this->instanceType) {
            case 'list':
                return Endpoint::PAYMENTS . $this->imp_uid . Endpoint::NAVER_PRODUCT_ORDERS;
                break;
            case 'single':
                return Endpoint::NAVER_PRODUCT_ORDERS . '/' . $this->product_order_id;
                break;
            case 'reviews':
                return Endpoint::NAVER_REVIEWS;
                break;
            case 'cashAmount':
                return Endpoint::PAYMENTS . $this->imp_uid . Endpoint::NAVER_CASH_AMOUNT;
                break;
        }
    }

    public function attributes(): array
    {
        if ($this->instanceType === 'reviews') {
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

    public function verb(): string
    {
        return 'GET';
    }
}
