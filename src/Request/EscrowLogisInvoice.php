<?php

namespace Iamport\RestClient\Request;

/**
 * Class EscrowLogisInvoice.
 *
 * @property string $company
 * @property string $invoice
 * @property int    $sent_at
 */
class EscrowLogisInvoice
{
    use RequestTrait;

    /**
     * @var string 택배사 코드
     */
    protected $company;

    /**
     * @var string 송장번호
     */
    protected $invoice;

    /**
     * @var int 발송일시 UNIX TIMESTAMP
     */
    protected $sent_at;

    /**
     * EscrowLogisInvoice constructor.
     *
     * @param string $company
     * @param string $invoice
     * @param int    $sent_at
     */
    public function __construct(string $company, string $invoice, int $sent_at)
    {
        $this->company = $company;
        $this->invoice = $invoice;
        $this->sent_at = $sent_at;
    }

    /**
     * @param string $company
     */
    public function setCompany(string $company): void
    {
        $this->company = $company;
    }

    /**
     * @param string $invoice
     */
    public function setInvoice(string $invoice): void
    {
        $this->invoice = $invoice;
    }

    /**
     * @param int $sent_at
     */
    public function setSentAt(int $sent_at): void
    {
        $this->sent_at = $sent_at;
    }
}
