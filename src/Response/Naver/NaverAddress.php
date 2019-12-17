<?php

namespace Iamport\RestClient\Response\Naver;

class NaverAddress
{
    /**
     * @var string 기본 주소
     */
    protected $base;

    /**
     * @var string 상세 주소
     */
    protected $detail;

    /**
     * @var string 우편번호
     */
    protected $postcode;

    /**
     * @var string 연락처1
     */
    protected $tel1;

    /**
     * @var string 연락처2
     */
    protected $tel2;

    /**
     * @var string 대상 이름
     */
    protected $name;

    /**
     * NaverAddress constructor.
     */
    public function __construct(array $response)
    {
        $this->base     = $response['base'];
        $this->detail   = $response['detail'];
        $this->postcode = $response['postcode'];
        $this->tel1     = $response['tel1'];
        $this->tel2     = $response['tel2'];
        $this->name     = $response['name'];
    }
}
