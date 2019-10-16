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
     *
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->page                 =  $response['page'];
        $this->payment_request_date =  $response['payment_request_date'];
        $this->cid                  =  $response['cid'];
        $this->orders               =  $response['orders'];
    }

    /**
     * @return array
     */
    public function getPage(): array
    {
        return $this->page;
    }

    /**
     * @return string
     */
    public function getPaymentRequestDate(): string
    {
        return $this->payment_request_date;
    }

    /**
     * @return string
     */
    public function getCid(): string
    {
        return $this->cid;
    }

    /**
     * @return array
     */
    public function getOrders(): array
    {
        return $this->orders;
    }

}
