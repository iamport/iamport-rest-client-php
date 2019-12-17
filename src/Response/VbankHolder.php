<?php

namespace Iamport\RestClient\Response;

/**
 * Class VbankHolder.
 */
class VbankHolder
{
    use ResponseTrait;

    /**
     * @var string 예금주명
     */
    protected $bank_holder;

    /**
     * VbankHolder constructor.
     */
    public function __construct(array $response)
    {
        $this->bank_holder = $response['bank_holder'];
    }

    public function getBankHolder(): string
    {
        return $this->bank_holder;
    }
}
