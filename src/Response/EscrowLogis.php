<?php

namespace Iamport\RestClient\Response;

class EscrowLogis
{
    use ResponseTrait;

    /**
     * @var string
     */
    protected $company;

    /**
     * @var string
     */
    protected $invoice;

    /**
     * @var int
     */
    protected $sent_at;

    /**
     * @var int
     */
    protected $applied_at;

    /**
     * EscrowLogis constructor.
     *
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->company     = $response['company'];
        $this->invoice     = $response['invoice'];
        $this->sent_at     = $response['sent_at'];
        $this->applied_at  = $response['applied_at'];
    }
}
