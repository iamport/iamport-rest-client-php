<?php

namespace Iamport\RestClient\Response;

class NaverOrderer
{
    /**
     * @var string 주문자 이름
     */
    protected $name;

    /**
     * @var string 주문자 마스킹된 네이버 아이디
     */
    protected $id;

    /**
     * @var string 주문자 연락처
     */
    protected $tel;

    /**
     * Payment constructor.
     *
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->name = $response['name'];
        $this->id   = $response['id'];
        $this->tel  = $response['tel'];
    }
}
