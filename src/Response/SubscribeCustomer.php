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
     * @var int
     */
    protected $inserted;

    /**
     * @var int
     */
    protected $updated;

    /**
     * Certification constructor.
     *
     * @param array $response
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

    /**
     * @return string
     */
    public function getCustomerUid(): string
    {
        return $this->customer_uid;
    }

    /**
     * @return string
     */
    public function getCardName(): string
    {
        return $this->card_name;
    }

    /**
     * @return string
     */
    public function getCardCode(): string
    {
        return $this->card_code;
    }

    /**
     * @return string
     */
    public function getCardNumber(): string
    {
        return $this->card_number;
    }

    /**
     * @return string
     */
    public function getCustomerName(): string
    {
        return $this->customer_name;
    }

    /**
     * @return string
     */
    public function getCustomerTel(): string
    {
        return $this->customer_tel;
    }

    /**
     * @return string
     */
    public function getCustomerEmail(): string
    {
        return $this->customer_email;
    }

    /**
     * @return string
     */
    public function getCustomerAddr(): string
    {
        return $this->customer_addr;
    }

    /**
     * @return string
     */
    public function getCustomerPostcode(): string
    {
        return $this->customer_postcode;
    }

    /**
     * @return int
     */
    public function getInserted(): int
    {
        return $this->inserted;
    }

    /**
     * @return int
     */
    public function getUpdated(): int
    {
        return $this->updated;
    }
}
