<?php

namespace Iamport\RestClient\Response\Naver;

use Iamport\RestClient\Enum\Naver\NaverClaimAdminCancel;
use Iamport\RestClient\Enum\Naver\NaverClaimCancel;
use Iamport\RestClient\Enum\Naver\NaverClaimExchange;
use Iamport\RestClient\Enum\Naver\NaverClaimPurchaseDecisionHoldback;
use Iamport\RestClient\Enum\Naver\NaverClaimReturn;
use Iamport\RestClient\Enum\Naver\NaverClaimType;
use Iamport\RestClient\Enum\Naver\NaverOrderStatus;
use Iamport\RestClient\Response\ResponseTrait;

/**
 * Class NaverInquiry.
 */
class NaverProductOrder
{
    use ResponseTrait;

    /**
     * @var string 네이버페이 상품주문번호
     */
    protected $product_order_id;

    /**
     * @var string 네이버페이 상품주문상태
     */
    protected $product_order_status;

    /**
     * @var string 네이버페이 상품주문관련 클레임 타입(취소/교환/환불 등 클레임에 대한 유형)
     */
    protected $claim_type;

    /**
     * @var string 네이버페이 상품주문관련 클레임에 대한 처리 상태(취소/교환/환불 등 클레임에 대해 처리 진행 상태)
     */
    protected $claim_status;

    /**
     * @var string 네이버페이 상품주문의 상품 고유번호
     */
    protected $product_id;

    /**
     * @var string 네이버페이 상품주문의 상품명
     */
    protected $product_name;

    /**
     * @var string 네이버페이 상품주문의 상품옵션 고유번호
     */
    protected $product_option_id;

    /**
     * @var string 네이버페이 상품주문의 상품옵션명
     */
    protected $product_option_name;

    /**
     * @var int 네이버페이 개별상품 주문금액
     */
    protected $product_amount;

    /**
     * @var int 네이버페이 개별상품 배송비
     */
    protected $delivery_amount;

    /**
     * @var int 네이버페이 상품주문의 상품 수량
     */
    protected $quantity;

    /**
     * @var NaverOrderer 네이버페이 상품주문의 주문자 정보
     */
    protected $orderer;

    /**
     * @var NaverAddress 네이버페이 상품주문별 배송주소 정보
     */
    protected $shipping_address;

    /**
     * @var string 네이버페이 상품주문별 배송메모
     */
    protected $shipping_memo;

    /**
     * @var int 네이버페이 상품주문별 배송기한 Unix Timestamp
     */
    protected $shipping_due;

    /**
     * @var string 네이버페이 주문자의 개인통고유부
     */
    protected $individual_code;

    /**
     * NaverInquiry constructor.
     *
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->product_order_id     =  $response['product_order_id'];
        $this->product_order_status =  $response['product_order_status'];
        $this->claim_type           =  $response['claim_type'];
        $this->claim_status         =  $response['claim_status'];
        $this->product_id           =  $response['product_id'];
        $this->product_name         =  $response['product_name'];
        $this->product_option_id    =  $response['product_option_id'];
        $this->product_option_name  =  $response['product_option_name'];
        $this->product_amount       =  $response['product_amount'];
        $this->delivery_amount      =  $response['delivery_amount'];
        $this->quantity             =  $response['quantity'];
        $this->orderer              =  new NaverOrderer($response['orderer']);
        $this->shipping_address     =  new NaverAddress($response['shipping_address']);
        $this->shipping_memo        =  $response['shipping_memo'];
        $this->shipping_due         =  $response['shipping_due'];
        $this->individual_code      =  $response['individual_code'];
    }

    /**
     * @return string
     */
    public function getProductOrderId(): string
    {
        return $this->product_order_id;
    }

    /**
     * @return string
     */
    public function getProductOrderStatus(): string
    {
        return NaverOrderStatus::getDescription($this->product_order_status);
    }

    /**
     * @return string
     */
    public function getClaimType(): string
    {
        return NaverClaimType::getDescription($this->claim_type);
    }

    /**
     * @return string
     */
    public function getClaimStatus(): string
    {
        switch ($this->claim_type) {
            case NaverClaimType::CANCEL:
                return NaverClaimCancel::getDescription($this->claim_status);
            case NaverClaimType::RETURN:
                return NaverClaimReturn::getDescription($this->claim_status);
            case NaverClaimType::EXCHANGE:
                return NaverClaimExchange::getDescription($this->claim_status);
            case NaverClaimType::PURCHASE_DECISION_HOLDBACK:
                return NaverClaimPurchaseDecisionHoldback::getDescription($this->claim_status);
            case NaverClaimType::ADMIN_CANCEL:
                return NaverClaimAdminCancel::getDescription($this->claim_status);
            default:
                return null;
        }
    }

    /**
     * @return string
     */
    public function getProductId(): string
    {
        return $this->product_id;
    }

    /**
     * @return string
     */
    public function getProductName(): string
    {
        return $this->product_name;
    }

    /**
     * @return string
     */
    public function getProductOptionId(): string
    {
        return $this->product_option_id;
    }

    /**
     * @return string
     */
    public function getProductOptionName(): string
    {
        return $this->product_option_name;
    }

    /**
     * @return int
     */
    public function getProductAmount(): int
    {
        return $this->product_amount;
    }

    /**
     * @return int
     */
    public function getDeliveryAmount(): int
    {
        return $this->delivery_amount;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return NaverOrderer
     */
    public function getOrderer(): NaverOrderer
    {
        return $this->orderer;
    }

    /**
     * @return NaverAddress
     */
    public function getShippingAddress(): NaverAddress
    {
        return $this->shipping_address;
    }

    /**
     * @return string
     */
    public function getShippingMemo(): string
    {
        return $this->shipping_memo;
    }

    /**
     * @return mixed
     */
    public function getShippingDue()
    {
        return $this->timestampToDate($this->shipping_due);
    }

    /**
     * @return string
     */
    public function getIndividualCode(): string
    {
        return $this->individual_code;
    }
}
