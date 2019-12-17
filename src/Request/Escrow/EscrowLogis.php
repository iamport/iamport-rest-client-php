<?php

namespace Iamport\RestClient\Request\Escrow;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Request\RequestBase;
use Iamport\RestClient\Request\RequestTrait;

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
        $this->responseClass = EscrowLogis::class;
    }

    /**
     * EscrowLogis POST constructor.
     * 에스크로 결제 건에 대한 배송정보 등록.
     * [POST] /escrows/logis/{imp_uid}.
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

    public function setImpUid(string $imp_uid): void
    {
        $this->imp_uid = $imp_uid;
    }

    public function setSender(EscrowLogisPerson $sender): void
    {
        $this->sender = $sender;
    }

    public function setReceiver(EscrowLogisPerson $receiver): void
    {
        $this->receiver = $receiver;
    }

    public function setLogis(EscrowLogisInvoice $logis): void
    {
        $this->logis = $logis;
    }

    /**
     * 에스크로 결제 건에 대한 배송정보 등록
     * [POST] /escrows/logis/{imp_uid}.
     *
     * 에스크로 결제 건에 대해서 POST /escrows/logis/{imp_uid} 로 등록된 배송정보를 수정
     * [PUT] /escrows/logis/{imp_uid}
     */
    public function path(): string
    {
        return Endpoint::ESCROW . $this->imp_uid;
    }

    public function attributes(): array
    {
        return [
            'body'  => json_encode($this->toArray()),
        ];
    }

    public function verb(): string
    {
        return $this->verb;
    }
}
