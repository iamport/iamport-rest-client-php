<?php

namespace Iamport\RestClient\Response;

/**
 * Class SubscribeCustomer.
 */
class SubscribeCustomer
{
    use ResponseTrait;

    /**
     * @var string
     */
    protected $customer_uid;

    /**
     * @var string
     */
    protected $card_name;

    /**
     * @var string
     */
    protected $card_code;

    /**
     * @var string
     */
    protected $card_number;

    /**
     * @var string
     */
    protected $customer_name;

    /**
     * @var string
     */
    protected $customer_tel;

    /**
     * @var string
     */
    protected $customer_email;

    /**
     * @var string
     */
    protected $customer_addr;

    /**
     * @var string
     */
    protected $customer_postcode;

    /**
     * @var mixed
     */
    protected $inserted;

    /**
     * @var mixed
     */
    protected $updated;

    /**
     * Certification constructor.
     */
    public function __construct(array $response)
    {
        $this->customer_uid      = $response['customer_uid'];
        $this->card_name         = $response['card_name'];
        $this->card_code         = $response['card_code'];
        $this->card_number       = $response['card_number'];
        $this->customer_name     = $response['customer_name'];
        $this->customer_tel      = $response['customer_tel'];
        $this->customer_email    = $response['customer_email'];
        $this->customer_addr     = $response['customer_addr'];
        $this->customer_postcode = $response['customer_postcode'];
        $this->inserted          = $response['inserted'];
        $this->updated           = $response['updated'];
    }

    public function getCustomerUid(): string
    {
        return $this->customer_uid;
    }

    public function getCardName(): string
    {
        return $this->card_name;
    }

    public function getCardCode(): string
    {
        return $this->card_code;
    }

    public function getCardNumber(): string
    {
        return $this->card_number;
    }

    public function getCustomerName(): string
    {
        return $this->customer_name;
    }

    public function getCustomerTel(): string
    {
        return $this->customer_tel;
    }

    public function getCustomerEmail(): string
    {
        return $this->customer_email;
    }

    public function getCustomerAddr(): string
    {
        return $this->customer_addr;
    }

    public function getCustomerPostcode(): string
    {
        return $this->customer_postcode;
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function getInserted()
    {
        return $this->timestampToDate($this->inserted);
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function getUpdated()
    {
        return $this->timestampToDate($this->updated);
    }
}
