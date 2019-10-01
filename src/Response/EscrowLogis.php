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
     * @var mixed
     */
    protected $sent_at;

    /**
     * @var mixed
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

    /**
     * @return string
     */
    public function getCompany(): string
    {
        return $this->company;
    }

    /**
     * @return string
     */
    public function getInvoice(): string
    {
        return $this->invoice;
    }

    /**
     * @return mixed
     */
    public function getSentAt()
    {
        return $this->timestampToDate($this->sent_at);
    }

    /**
     * @return mixed
     */
    public function getAppliedAt()
    {
        return $this->timestampToDate($this->applied_at);
    }
}
