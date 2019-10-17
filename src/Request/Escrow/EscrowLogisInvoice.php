<?php

namespace Iamport\RestClient\Request\Escrow;

use Iamport\RestClient\Request\RequestTrait;

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
     * @var string 발송일시
     */
    protected $sent_at;

    /**
     * EscrowLogisInvoice constructor.
     *
     * @param string $company
     * @param string $invoice
     * @param string $sent_at Y-m-d H:i:s 형태의 문자열
     */
    public function __construct(string $company, string $invoice, string $sent_at)
    {
        date_default_timezone_set('Asia/Seoul');
        $this->company = $company;
        $this->invoice = $invoice;
        $this->setSentAt($sent_at);
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
     * @param string $sent_at
     */
    public function setSentAt(string $sent_at): void
    {
        $this->sent_at = strtotime($sent_at);
    }
}
