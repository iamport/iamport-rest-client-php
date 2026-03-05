<?php

namespace Iamport\RestClient\Request\Subscribe;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Request\RequestBase;
use Iamport\RestClient\Request\RequestTrait;
use Iamport\RestClient\Response;
use InvalidArgumentException;

/**
 * Class SubscribeInquiry.
 *
 * @property string $merchant_uid
 * @property string $customer_uid
 * @property string $page
 * @property mixed  $from
 * @property mixed  $to
 * @property string $schedule_status
 * @property int    $schedule_at
 */
class SubscribeInquiry extends RequestBase
{
    use RequestTrait;

    /**
     * @var string 결제예약에 사용된 가맹점 거래 고유번호
     */
    protected $merchant_uid;

    /**
     * @var array 결제예약에 사용된 가맹점 거래 고유번호
     */
    public $customer_uid;

    /**
     * @var int 페이지
     */
    protected $page = 1;

    /**
     * @var mixed 조회 시작시각
     */
    protected $from;

    /**
     * @var mixed 조회 시작시각
     */
    protected $to;

    /**
     * @var string 예약상태. 누락되면 모든 상태의 예약내역 조회
     */
    protected $schedule_status;

    /**
     * @var int 결제예약 시각 UNIX TIMESTAMP
     */
    protected $schedule_at;

    /**
     * @var string HTTP verb
     */
    private $verb = 'GET';

    /**
     * SubscribeCustomer constructor.
     */
    public function __construct()
    {
    }

    /**
     * 예약 거래주문번호(merchant_uid)로 결제예약정보를 조회.
     *
     * @return SubscribeInquiry
     */
    public static function withMerchantUid(string $merchant_uid)
    {
        $instance                = new self();
        $instance->merchant_uid  = $merchant_uid;
        $instance->responseClass = Response\Schedule::class;
        $instance->instanceType  = 'withMerchantUid';
        $instance->unsetArray([
            'customer_uid', 'page', 'from', 'to', 'schedule-status',
        ]);

        return $instance;
    }

    /**
     * customer_uid별 결제예약목록을 조회.
     *
     * @param mixed $from
     * @param mixed $to
     *
     * @return SubscribeInquiry
     */
    public static function withCustomerUid(string $customer_uid, $from, $to)
    {
        $instance                 = new self();
        $instance->customer_uid   = $customer_uid;
        $instance->from           = $instance->dateToTimestamp($from);
        $instance->to             = $instance->dateToTimestamp($to);
        $instance->responseClass  = Response\Schedule::class;
        $instance->isCollection   = true;
        $instance->isPaged        = true;
        $instance->instanceType   = 'withCustomerUid';
        unset($instance->merchant_uid);

        return $instance;
    }

    /**
     * 결제요청 예약시각 수정.
     *
     * @param mixed $schedule_at
     *
     * @return SubscribeInquiry
     */
    public static function updateSchedule(string $merchant_uid, $schedule_at)
    {
        $instance                = new self();
        $instance->merchant_uid  = $merchant_uid;
        $instance->schedule_at   = $instance->dateToTimestamp($schedule_at);
        $instance->responseClass = Response\Schedule::class;
        $instance->instanceType  = 'updateSchedule';
        $instance->verb          = 'PUT';
        $instance->unsetArray([
            'customer_uid', 'page', 'from', 'to', 'schedule_status',
        ]);

        return $instance;
    }

    /**
     * 결제 실패 재시도.
     *
     * @return SubscribeInquiry
     */
    public static function retry(string $merchant_uid)
    {
        $instance                = new self();
        $instance->merchant_uid  = $merchant_uid;
        $instance->responseClass = Response\Payment::class;
        $instance->instanceType  = 'retry';
        $instance->verb          = 'POST';
        $instance->unsetArray([
            'customer_uid', 'page', 'from', 'to', 'schedule_status', 'schedule_at',
        ]);

        return $instance;
    }

    /**
     * 결제 실패 재예약.
     *
     * @param mixed $schedule_at
     *
     * @return SubscribeInquiry
     */
    public static function reschedule(string $merchant_uid, $schedule_at)
    {
        $instance                = new self();
        $instance->merchant_uid  = $merchant_uid;
        $instance->schedule_at   = $instance->dateToTimestamp($schedule_at);
        $instance->responseClass = Response\Schedule::class;
        $instance->instanceType  = 'reschedule';
        $instance->verb          = 'POST';
        $instance->unsetArray([
            'customer_uid', 'page', 'from', 'to', 'schedule_status',
        ]);

        return $instance;
    }

    public function setPage(string $page): void
    {
        $this->page = $page;
    }

    public function setScheduleStatus(string $schedule_status): void
    {
        if (!in_array($schedule_status, ['scheduled', 'executed', 'revoked'])) {
            throw new InvalidArgumentException('허용되지 않는 schedule_status 값 입니다. [ 가능한 값은 scheduled, executed, revoked 입니다. ]');
        }
        $this->schedule_status = $schedule_status;
    }

    /**
     * @param mixed $schedule_at
     */
    public function setScheduleAt($schedule_at): void
    {
        $this->schedule_at = $this->dateToTimestamp($schedule_at);
    }

    /**
     * 예약 거래주문번호(merchant_uid)로 결제예약정보를 조회
     * [GET] /subscribe/payments/schedule/{merchant_uid}.
     *
     * customer_uid별 결제예약목록을 조회
     * [GET] /subscribe/payments/schedule/customers/{customer_uid}
     *
     * 결제요청 예약시각 수정
     * [PUT] /subscribe/payments/schedule/{merchant_uid}
     *
     * 결제 실패 재시도
     * [POST] /subscribe/payments/schedule/{merchant_uid}/retry
     *
     * 결제 실패 재예약
     * [POST] /subscribe/payments/schedule/{merchant_uid}/reschedule
     */
    public function path(): string
    {
        switch ($this->instanceType) {
            case 'withMerchantUid':
            case 'updateSchedule':
                return Endpoint::SBCR_PAYMENTS_SCHEDULE . $this->merchant_uid;
                break;
            case 'withCustomerUid':
                return Endpoint::SBCR_PAYMENTS_SCHEDULE . 'customers/' . $this->customer_uid;
                break;
            case 'retry':
                return Endpoint::SBCR_PAYMENTS_SCHEDULE . $this->merchant_uid . '/retry';
                break;
            case 'reschedule':
                return Endpoint::SBCR_PAYMENTS_SCHEDULE . $this->merchant_uid . '/reschedule';
                break;
            default:
                return '';
        }
    }

    public function attributes(): array
    {
        switch ($this->instanceType) {
            case 'withMerchantUid':
                return  [];
                break;
            case 'withCustomerUid':
                return [
                    'query' => [
                        'page'            => $this->page,
                        'from'            => $this->from,
                        'to'              => $this->to,
                        'schedule-status' => $this->schedule_status,
                    ],
                ];
                break;
            case 'updateSchedule':
            case 'reschedule':
                return [
                    'body' => json_encode($this->toArray()),
                ];
                break;
            case 'retry':
                return [];
                break;
            default:
                return [];
        }
    }

    public function verb(): string
    {
        return $this->verb;
    }
}
