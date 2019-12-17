<?php

namespace Iamport\RestClient\Request;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Enum\PaymentSort;
use Iamport\RestClient\Response;
use Iamport\RestClient\Response\BalanceWrap;
use InvalidArgumentException;

/**
 * Class PaymentTransformer.
 *
 * @property string $imp_uid
 * @property array  $imp_uids
 * @property string $merchant_uid
 * @property string $payment_status
 * @property string $sorting
 * @property int    $page
 * @property int    $limit
 * @property mixed  $from
 * @property mixed  $to
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
     * @var int 한 번에 조회할 결제건수
     */
    protected $limit = 20;

    /**
     * @var mixed 시간별 검색 시작 시각
     */
    protected $from;

    /**
     * @var mixed 시간별 검색 종료 시각
     */
    protected $to;

    /**
     * Payment constructor.
     */
    public function __construct()
    {
    }

    /**
     * 아임포트 고유번호로 결제내역을 조회.
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
     * 가맹점지정 고유번호로 결제내역을 단건 조회 ( 정렬 기준에 따라 가장 첫 번째 건 반환 ).
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
     * 가맹점지정 고유번호로 결제내역을 조회.
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
     * 아임포트 고유번호 배열로 결제내역을 한 번에 조회.
     *
     * @return Payment
     */
    public static function listImpUid(array $imp_uids)
    {
        $instance                = new self();
        $instance->imp_uids      = $imp_uids;
        $instance->isCollection  = true;
        $instance->responseClass = Response\Payment::class;
        $instance->instanceType  = 'listImpUid';
        $instance->unsetArray(['merchant_uid', 'payment_status', 'sorting', 'page', 'limit', 'from', 'to']);

        return $instance;
    }

    /**
     * 아임포트 고유번호로 결제수단별 금액 상세정보를 확인합.
     *
     * @return Payment
     */
    public static function balance(string $imp_uid)
    {
        $instance                = new self();
        $instance->imp_uid       = $imp_uid;
        $instance->responseClass = BalanceWrap::class;
        $instance->instanceType  = 'balance';

        return $instance;
    }

    public static function listStatus(string $payment_status)
    {
        $instance                = new self();
        if (!in_array($payment_status, ['all', 'ready', 'paid', 'cancelled', 'failed'])) {
            throw new InvalidArgumentException('$payment_status로 가능한 값은 all, ready, paid, cancelled, failed 입니다. ');
        }
        $instance->payment_status = $payment_status;
        $instance->isCollection   = true;
        $instance->isPaged        = true;
        $instance->responseClass  = Response\Payment::class;
        $instance->instanceType   = 'listStatus';
        $instance->unsetArray(['imp_uids', 'imp_uid', 'merchant_uid']);

        return $instance;
    }

    public function setImpUid(string $imp_uid): void
    {
        $this->imp_uid = $imp_uid;
    }

    public function setMerchantUid(string $merchant_uid): void
    {
        $this->merchant_uid = $merchant_uid;
    }

    public function setPaymentStatus(string $payment_status): void
    {
        $this->payment_status = $payment_status;
    }

    public function setSorting(string $sorting): void
    {
        $this->sorting = $sorting;
    }

    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * @param mixed $from
     */
    public function setFrom($from): void
    {
        $this->from = $this->dateToTimestamp($from);
    }

    /**
     * @param mixed $to
     */
    public function setTo($to): void
    {
        $this->to = $this->dateToTimestamp($to);
    }

    public function valid(): bool
    {
        switch ($this->instanceType) {
            case 'listStatus':
                if (PaymentSort::validation($this->sorting)) {
                    throw new InvalidArgumentException('허용되지 않는 sorting 입니다. ( PaymentSort::getAll()로 허용 가능한 값을 확인해주세요. )');
                }
                break;
            default:
                return true;
        }
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
     */
    public function path(): string
    {
        if ($this->instanceType === 'withImpUid') {
            return Endpoint::PAYMENTS . $this->imp_uid;
        } elseif ($this->instanceType === 'listImpUid') {
            return Endpoint::PAYMENTS;
        } elseif ($this->instanceType === 'listStatus') {
            return Endpoint::PAYMENTS_STATUS . $this->payment_status;
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
            case 'listImpUid':
                return [
                    'query' => [
                        'imp_uid' => $this->imp_uids,
                    ],
                ];
                break;
            case 'listStatus':
                $result =  [
                    'query' => [
                        'sorting' => $this->sorting,
                        'page'    => $this->page,
                        'limit'   => $this->limit,
                    ],
                ];
                if ($this->from !== null) {
                    $result['query']['from'] = $this->from;
                }

                if ($this->to !== null) {
                    $result['query']['to'] = $this->to;
                }

                return $result;
                break;
            default:
                return [];
        }
    }

    public function verb(): string
    {
        return 'GET';
    }
}
