<?php

namespace Iamport\RestClient\Response;

/**
 * Class EscrowLogis.
 */
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
     */
    public function __construct(array $response)
    {
        $this->company     = $response['company'];
        $this->invoice     = $response['invoice'];
        $this->sent_at     = $response['sent_at'];
        $this->applied_at  = $response['applied_at'];
    }

    public function getCompany(): string
    {
        return $this->company;
    }

    public function getInvoice(): string
    {
        return $this->invoice;
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function getSentAt()
    {
        return $this->timestampToDate($this->sent_at);
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function getAppliedAt()
    {
        return $this->timestampToDate($this->applied_at);
    }
}
