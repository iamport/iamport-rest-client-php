<?php

namespace Iamport\RestClient\Response\Naver;

use Iamport\RestClient\Response\ResponseTrait;

/**
 * Class NaverReview.
 */
class NaverReview
{
    use ResponseTrait;

    /**
     * @var string 네이버페이 구매평 고유 ID ,
     */
    protected $review_id;

    /**
     * @var string 네이버페이 구매만족도. 1, 2, 3, 4, 5 (점) ,
     */
    protected $score;

    /**
     * @var string 네이버페이 일반 구매평 내용 또는 프리미엄 구매평 제목 ,
     */
    protected $title;

    /**
     * @var string 네이버페이 프리미엄 구매평 내용(일반 구매평인 경우 없음) ,
     */
    protected $content;

    /**
     * @var string 네이버페이 상품주문번호 ,
     */
    protected $product_order_id;

    /**
     * @var string 네이버페이 상품주문의 상품 고유번호 ,
     */
    protected $product_id;

    /**
     * @var string 네이버페이 상품주문의 상품명 ,
     */
    protected $product_name;

    /**
     * @var string 네이버페이 상품주문의 상품옵션명 ,
     */
    protected $product_option_name;

    /**
     * @var string 네이버페이 구매평 작성자 아이디 ,
     */
    protected $writer;

    /**
     * @var mixed 네이버페이 구매평 작성시각 unix timestamp ,
     */
    protected $created_at;

    /**
     * @var mixed 네이버페이 구매평 수정시각 unix timestamp
     */
    protected $modified_at;

    /**
     * NaverReview constructor.
     */
    public function __construct(array $response)
    {
        $this->review_id           = $response['review_id'];
        $this->score               = $response['score'];
        $this->title               = $response['title'];
        $this->content             = $response['content'];
        $this->product_order_id    = $response['product_order_id'];
        $this->product_id          = $response['product_id'];
        $this->product_name        = $response['product_name'];
        $this->product_option_name = $response['product_option_name'];
        $this->writer              = $response['writer'];
        $this->created_at          = $response['created_at'];
        $this->modified_at         = $response['modified_at'];
    }

    public function getReviewId(): string
    {
        return $this->review_id;
    }

    public function getScore(): string
    {
        return $this->score;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getProductOrderId(): string
    {
        return $this->product_order_id;
    }

    public function getProductId(): string
    {
        return $this->product_id;
    }

    public function getProductName(): string
    {
        return $this->product_name;
    }

    public function getProductOptionName(): string
    {
        return $this->product_option_name;
    }

    public function getWriter(): string
    {
        return $this->writer;
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function getCreatedAt()
    {
        return $this->timestampToDate($this->created_at);
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function getModifiedAt()
    {
        return $this->timestampToDate($this->modified_at);
    }
}
