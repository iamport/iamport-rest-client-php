<?php

namespace Iamport\RestClient\Request;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Response;

/**
 * Class PaymentTransformer.
 *
 * @property string $merchant_uid
 * @property float  $amount
 */
class PaymentPrepare extends RequestBase
{
    use RequestTrait;

    /**
     * @var string 가맹점 거래 고유번호
     */
    protected $merchant_uid;

    /**
     * @var float 결제예정금액
     */
    protected $amount;

    /**
     * PaymentPrepare constructor.
     */
    public function __construct()
    {
    }

    /**
     * 인증방식의 결제를 진행할 때 결제금액 위변조시 결제진행자체를 block하기 위해 결제예정금액을 사전등록.
     *
     * @param string $merchantUid
     * @param float  $amount
     *
     * @return PaymentPrepare
     */
    public static function store(string $merchantUid, float $amount)
    {
        $instance                 = new self();
        $instance->merchant_uid   = $merchantUid;
        $instance->amount         = $amount;
        $instance->responseClass  = Response\PaymentPrepare::class;
        $instance->instanceType   = 'store';

        return $instance;
    }

    /**
     * 등록되어있는 사전등록 결제정보를 조회.
     *
     * @param string $merchantUid
     *
     * @return PaymentPrepare
     */
    public static function view(string $merchantUid)
    {
        $instance                 = new self();
        $instance->merchant_uid   = $merchantUid;
        $instance->responseClass  = Response\PaymentPrepare::class;
        $instance->instanceType   = 'view';

        unset($instance->amount);

        return $instance;
    }

    public function path(): string
    {
        if ($this->instanceType === 'store') {
            return Endpoint::PAYMENTS_PREPARE;
        } elseif ($this->instanceType === 'view') {
            return Endpoint::PAYMENTS_PREPARE . '/' . $this->merchant_uid;
        }
    }

    public function attributes(): array
    {
        if ($this->instanceType === 'store') {
            return [
                'body' => json_encode($this->toArray()),
            ];
        } else {
            return [];
        }
    }

    public function verb(): string
    {
        switch ($this->instanceType) {
            case 'store':
                return 'POST';
                break;
            case 'view':
                return 'GET';
                break;
            default:
                return '';
        }
    }
}
