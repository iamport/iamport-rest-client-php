<?php

namespace Iamport\RestClient\Response;

/**
 * Class Kakaopay.
 */
class Kakaopay
{
    use ResponseTrait;

    /**
     * @var array
     */
    protected $page;

    /**
     * @var string
     */
    protected $payment_request_date;

    /**
     * @var string
     */
    protected $cid;

    /**
     * @var array
     */
    protected $orders = [];

    /**
     * Kakaopay constructor.
     */
    public function __construct(array $response)
    {
        $this->page                 =  $response['page'];
        $this->payment_request_date =  $response['payment_request_date'];
        $this->cid                  =  $response['cid'];
        $this->orders               =  $response['orders'];
    }

    public function getPage(): array
    {
        return $this->page;
    }

    public function getPaymentRequestDate(): string
    {
        return $this->payment_request_date;
    }

    public function getCid(): string
    {
        return $this->cid;
    }

    public function getOrders(): array
    {
        return $this->orders;
    }
}
