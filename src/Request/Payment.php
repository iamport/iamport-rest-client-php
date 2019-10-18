<?php

namespace Iamport\RestClient\Request;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Response;

/**
 * Class PaymentTransformer.
 *
 * @property string $imp_uid
 * @property array  $array_imp_uid
 * @property string $merchant_uid
 * @property string $payment_status
 * @property string $sorting
 * @property int    $page
 */
class Payment extends RequestBase
{
    use RequestTrait;

    /**
     * @var array 아임포트 고유번호 (배열)
     */
    public $imp_uids = [];

    /**
     * @var string 아임포트 고유번호
     */
    protected $imp_uid;

    /**
     * @var string 가맹점에서 전달한 거래 고유번호
     */
    protected $merchant_uid;

    /**
     * @var string status 상태 [ ready, paid, failed, cancelled ]
     */
    protected $payment_status = '';

    /**
     * @var string 정렬기준. [ -started, started, -paid, paid, -updated, updated ]
     */
    protected $sorting = '-started';

    /**
     * @var int 페이지번호
     */
    protected $page = 1;

    /**
     * Payment constructor.
     */
    public function __construct()
    {
    }

    /**
     * 아임포트 고유번호로 인스턴스 생성.
     *
     * @param string $impUid
     *
     * @return Payment
     */
    public static function withImpUid(string $impUid)
    {
        $instance                = new self();
        $instance->imp_uid       = $impUid;
        $instance->responseClass = Response\Payment::class;
        $instance->instanceType  = 'withImpUid';

        return $instance;
    }

    /**
     * 아임포트 고유번호로 인스턴스 생성.
     *
     * @param string $merchant_uid
     *
     * @return Payment
     */
    public static function withMerchantUid(string $merchant_uid)
    {
        $instance                = new self();
        $instance->merchant_uid  = $merchant_uid;
        $instance->responseClass = Response\Payment::class;
        $instance->instanceType  = 'withMerchantUid';

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
        $instance                = new self();
        $instance->merchant_uid  = $merchant_uid;
        $instance->isCollection  = true;
        $instance->isPaged       = true;
        $instance->responseClass = Response\Payment::class;
        $instance->instanceType  = 'listMerchantUid';

        return $instance;
    }

    /**
     * 아임포트 고유번호 배열로 결제내역을 한 번에 조.
     *
     * @param array $imp_uids
     *
     * @return Payment
     */
    public static function list(array $imp_uids)
    {
        $instance                = new self();
        $instance->imp_uids      = $imp_uids;
        $instance->isCollection  = true;
        $instance->responseClass = Response\Payment::class;
        $instance->instanceType  = 'list';

        return $instance;
    }

    /**
     * 아임포트 고유번호로 결제수단별 금액 상세정보를 확인합.
     *
     * @param string $imp_uid
     *
     * @return Payment
     */
    public static function balance(string $imp_uid)
    {
        $instance                = new self();
        $instance->imp_uid       = $imp_uid;
        $instance->responseClass = Response\BalanceWrap::class;
        $instance->instanceType  = 'balance';

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
     * 여러 개의 아임포트 고유번호로 결제내역을 한 번에 조회
     * [GET] /payments
     *
     * @return string
     */
    public function path(): string
    {
        if ($this->instanceType === 'withImpUid') {
            return Endpoint::PAYMENTS . $this->imp_uid;
        } elseif ($this->instanceType === 'list') {
            return Endpoint::PAYMENTS;
        } elseif ($this->instanceType === 'balance') {
            return Endpoint::PAYMENTS . $this->imp_uid . EndPoint::BALANCE;
        } else {
            $endPoint = '';
            if ($this->instanceType === 'withMerchantUid') {
                $endPoint = Endpoint::PAYMENTS_FIND . $this->merchant_uid;
            } elseif ($this->instanceType === 'listMerchantUid') {
                $endPoint = Endpoint::PAYMENTS_FIND_ALL . $this->merchant_uid;
            }
            if (in_array($this->payment_status, ['ready', 'paid', 'cancelled', 'failed'])) {
                $endPoint .= '/' . $this->payment_status;
            }

            return $endPoint;
        }
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        switch ($this->instanceType) {
            case 'withMerchantUid':
                return [
                    'query' => [
                        'sorting' => $this->sorting,
                    ],
                ];
                break;
            case 'listMerchantUid':
                return [
                    'query' => [
                        'sorting' => $this->sorting,
                        'page'    => $this->page,
                    ],
                ];
                break;
            case 'list':
                return [
                    'query' => [
                        'imp_uid' => $this->imp_uids,
                    ],
                ];
                break;
            default:
                return [];
        }
    }

    /**
     * @return string
     */
    public function verb(): string
    {
        return 'GET';
    }
}
