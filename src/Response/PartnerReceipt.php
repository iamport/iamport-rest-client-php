<?php

namespace Iamport\RestClient\Response;

/**
 * Class PartnerReceipt.
 */
class PartnerReceipt
{
    use ResponseTrait;

    /**
     * @var string
     */
    protected $receipt_url;

    /**
     * PartnerReceipt constructor.
     */
    public function __construct(array $response)
    {
        $this->receipt_url = $response['receipt_url'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getReceiptUrl()
    {
        return $this->receipt_url;
    }
}
