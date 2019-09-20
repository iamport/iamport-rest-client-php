<?php

namespace Iamport\RestClient\Request;

use Iamport\RestClient\Enum\Endpoint;

/**
 * Class EscrowLogis.
 *
 * @property string $imp_uid
 * @property string $sender
 * @property string $receiver
 * @property string $logis
 */
class EscrowLogis extends RequestBase
{
    use RequestTrait;

    /**
     * @var string HTTP verb
     */
    private $verb;

    /**
     * @var string 아임포트 거래 고유번호
     */
    protected $imp_uid;

    /**
     * @var array 발신자 정보
     */
    protected $sender;

    /**
     * @var array 수신자 정보
     */
    protected $receiver;

    /**
     * @var array 배송정보
     */
    protected $logis;

    /**
     * EscrowLogis constructor.
     */
    public function __construct()
    {
        $this->responseType = 'EscrowLogis';
    }

    /**
     * EscrowLogis POST constructor.
     * 에스크로 결제 건에 대한 배송정보 등록.
     * [POST] /escrows/logis/{imp_uid}.
     *
     * @param string             $imp_uid
     * @param EscrowLogisPerson  $sender
     * @param EscrowLogisPerson  $receiver
     * @param EscrowLogisInvoice $invoice
     *
     * @return EscrowLogis
     */
    public static function register(string $imp_uid, EscrowLogisPerson $sender, EscrowLogisPerson $receiver, EscrowLogisInvoice $invoice)
    {
        $instance           = new self();
        $instance->imp_uid  = $imp_uid;
        $instance->sender   = $sender->toArray();
        $instance->receiver = $receiver->toArray();
        $instance->logis    = $invoice->toArray();
        $instance->verb     = 'POST';

        return $instance;
    }

    /**
     * EscrowLogis POST constructor.
     * 에스크로 결제 건에 대한 배송정보 수정.
     * [PUT] /escrows/logis/{imp_uid}.
     *
     * @param string             $imp_uid
     * @param EscrowLogisPerson  $sender
     * @param EscrowLogisPerson  $receiver
     * @param EscrowLogisInvoice $invoice
     *
     * @return EscrowLogis
     */
    public static function update(string $imp_uid, EscrowLogisPerson $sender, EscrowLogisPerson $receiver, EscrowLogisInvoice $invoice)
    {
        $instance           = new self();
        $instance->imp_uid  = $imp_uid;
        $instance->sender   = $sender->toArray();
        $instance->receiver = $receiver->toArray();
        $instance->logis    = $invoice->toArray();
        $instance->verb     = 'PUT';

        return $instance;
    }

    /**
     * @param string $imp_uid
     */
    public function setImpUid(string $imp_uid): void
    {
        $this->imp_uid = $imp_uid;
    }

    /**
     * @param EscrowLogisPerson $sender
     */
    public function setSender(EscrowLogisPerson $sender): void
    {
        $this->sender = $sender;
    }

    /**
     * @param EscrowLogisPerson $receiver
     */
    public function setReceiver(EscrowLogisPerson $receiver): void
    {
        $this->receiver = $receiver;
    }

    /**
     * @param EscrowLogisInvoice $logis
     */
    public function setLogis(EscrowLogisInvoice $logis): void
    {
        $this->logis = $logis;
    }

    /**
     * @return string
     */
    public function path(): string
    {
        return Endpoint::ESCROW.$this->imp_uid;
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'body'  => json_encode($this->toArray()),
        ];
    }

    /**
     * @return string
     */
    public function verb(): string
    {
        return $this->verb;
    }
}
