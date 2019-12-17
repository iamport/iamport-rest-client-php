<?php

namespace Iamport\RestClient\Response;

/**
 * Class StandardCode.
 */
class StandardCode
{
    use ResponseTrait;

    /**
     * @var string 기관코드(금융결제원표준코드) ,
     */
    protected $code;

    /**
     * @var string 기관 (금융결제원기재명)
     */
    protected $name;

    /**
     * StandardCode constructor.
     */
    public function __construct(array $response)
    {
        $this->code = $response['code'];
        $this->name = $response['name'];
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
