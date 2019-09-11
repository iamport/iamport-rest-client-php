<?php

namespace Iamport\RestClient\Request;

use Iamport\RestClient\Enum\Endpoint;

/**
 * Class Payment.
 *
 * @property string $imp_uid
 * @property string $merchant_uid
 * @property string $payment_status
 * @property string $sorting
 * @property int $page
 */
class Payment extends RequestBase
{
    use RequestTrait;

    /**
     * @var string 아임포트 고유번호
     */
    private $imp_uid;

    /**
     * @var string 가맹점에서 전달한 거래 고유번호
     */
    private $merchant_uid;

    /**
     * @var string status 상태 [ ready, paid, failed, cancelled ]
     */
    private $payment_status = '';

    /**
     * @var string 정렬기준. [ -started, started, -paid, paid, -updated, updated ]
     */
    private $sorting = '-started';

    /**
     * @var int 페이지번호
     */
    private $page = 1;


    /**
     * 아임포트 고유번호로 인스턴스 생성.
     *
     * @param string $impUid
     *
     * @return Payment
     */
    public static function getImpUid(string $impUid)
    {
        $instance = new self();
        $instance->setImpUid($impUid);

        return $instance;
    }

    /**
     * 거래 고유번호로 인스턴스 생성.
     *
     * @param string $merchant_uid
     *
     * @return Payment
     */
    public static function getMerchantUid(string $merchant_uid)
    {
        $instance = new self();
        $instance->setMerchantUid($merchant_uid);

        return $instance;
    }

    /**
     * 거래 고유번호로 인스턴스 생성.
     *
     * @param string $merchant_uid
     *
     * @return Payment
     */
    public static function listMerchantUid(string $merchant_uid)
    {
        $instance = new self();
        $instance->setMerchantUid($merchant_uid);
        $instance->setResponseType('paged');

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
     * @param string $merchant_uid
     */
    public function setMerchantUid(string $merchant_uid): void
    {
        $this->merchant_uid = $merchant_uid;
    }

    /**
     * @param string $payment_status
     */
    public function setPaymentStatus(string $payment_status): void
    {
        $this->payment_status = $payment_status;
    }

    /**
     * @param string $sorting
     */
    public function setSorting(string $sorting): void
    {
        $this->sorting = $sorting;
    }

    /**
     * @param int $page
     */
    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    /**
     * imp_uid 로 주문정보 찾기(아임포트에서 생성된 거래고유번호).
     * [GET] /payments/{$impUid}.
     *
     * merchant_uid 로 주문정보 찾기(가맹점의 주문번호).
     * [GET] /payments/find/{$merchantUid}/{$paymentStatus}.
     *
     * merchant_uid 로 주문정보 모두 찾기(가맹점의 주문번호).
     * [GET] /payments/findAll/{$merchantUid}/{$paymentStatus}.
     *
     * @return string
     */
    public function path(): string
    {
        if (!is_null($this->imp_uid)) {
            return Endpoint::PAYMENTS.$this->imp_uid;
        } elseif (!is_null($this->merchant_uid)) {

            if( $this->responseType === 'paged' ) {
                $endPoint = Endpoint::PAYMENTS_FIND_ALL.$this->merchant_uid;
            } else {
                $endPoint = Endpoint::PAYMENTS_FIND.$this->merchant_uid;
            }

            if (in_array($this->payment_status, ['ready', 'paid', 'cancelled', 'failed'])) {
                $endPoint .= '/'.$this->payment_status;
            }

            return $endPoint;
        }
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        if (!is_null($this->merchant_uid)) {
            $result =  [
                'query' => [
                    'sorting' => $this->sorting,
                ],
            ];
            if( $this->responseType === 'paged' ) {
                $result['query']['page'] = $this->page;
            }
        } else {
            $result = [];
        }

        return $result;
    }

    /**
     * @return string
     */
    public function verb(): string
    {
        return 'GET';
    }
}
