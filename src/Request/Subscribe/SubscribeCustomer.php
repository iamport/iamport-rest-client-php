<?php

namespace Iamport\RestClient\Request\Subscribe;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Request\CardInfo;
use Iamport\RestClient\Request\RequestBase;
use Iamport\RestClient\Request\RequestTrait;
use Iamport\RestClient\Response;
use InvalidArgumentException;

/**
 * Class SubscribeCustomer.
 *
 * @property string $customer_uid
 * @property string $pg
 * @property string $card_number
 * @property string $expiry
 * @property string $birth
 * @property string $pwd_2digit
 * @property string $customer_name
 * @property string $customer_tel
 * @property string $customer_email
 * @property string $customer_addr
 * @property string $customer_postcode
 * @property int    $page
 * @property mixed  $from
 * @property mixed  $to
 * @property string $schedule_status
 * @property string $reason
 * @property SubscribeCustomerExtra $extra
 */
class SubscribeCustomer extends RequestBase
{
    use RequestTrait;

    /**
     * @var string HTTP verb
     */
    private $verb;

    /**
     * @var string 구매자 고유 번호
     */
    protected $customer_uid;

    /**
     * @var array 구매자 고유 번호목록
     */
    public $customer_uids = [];

    /**
     * @var string API 방식 비인증 PG설정이 2개 이상인 경우 지정
     */
    protected $pg;

    /**
     * @var string 카드번호(dddd-dddd-dddd-dddd)
     */
    protected $card_number;

    /**
     * @var string 카드 유효기간(YYYY-MM)
     */
    protected $expiry;

    /**
     * @var string 생년월일6자리(법인카드의 경우 사업자등록번호10자리)
     */
    protected $birth;

    /**
     * @var string 카드비밀번호 앞 2자리
     */
    protected $pwd_2digit;

    /**
     * @var string 카드 고객(카드소지자) 관리용 성함
     */
    protected $customer_name;

    /**
     * @var string 고객(카드소지자) 전화번호
     */
    protected $customer_tel;

    /**
     * @var string 고객(카드소지자) Email
     */
    protected $customer_email;

    /**
     * @var string 고객(카드소지자) 주소
     */
    protected $customer_addr;

    /**
     * @var string 고객(카드소지자) 우편번호
     */
    protected $customer_postcode;

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
     * @var string 삭제 사유
     */
    protected $reason;

    /**
     * @var SubscribeCustomerExtra
     */
    protected $extra;

    /**
     * SubscribeCustomer constructor.
     */
    public function __construct()
    {
    }

    /**
     * 비인증결제 빌링키 조회.
     *
     * @return SubscribeCustomer
     */
    public static function view(string $customer_uid)
    {
        $instance                = new self();
        $instance->customer_uid  = $customer_uid;
        $instance->responseClass = Response\SubscribeCustomer::class;
        $instance->instanceType  = 'view';
        $instance->verb          = 'GET';
        $instance->unsetArray([
            'customer_uids', 'pg', 'card_number', 'expiry', 'birth', 'pwd_2digit', 'customer_name', 'customer_tel',
            'customer_email', 'customer_addr', 'customer_postcode', 'page', 'from', 'to', 'schedule-status', 'reason',
            'extra',
        ]);

        return $instance;
    }

    /**
     * 비인증결제 빌링키 등록(수정).
     *
     * @return SubscribeCustomer
     */
    public static function issue(string $customer_uid, CardInfo $cardInfo)
    {
        $instance               = new self();
        $instance->customer_uid = $customer_uid;
        $instance->card_number  = $cardInfo->card_number;
        $instance->expiry       = $cardInfo->expiry;
        $instance->birth        = $cardInfo->birth;

        if (!is_null($cardInfo->pwd_2digit)) {
            $instance->setPwd2digit($cardInfo->pwd_2digit);
        }
        $instance->responseClass = Response\SubscribeCustomer::class;
        $instance->instanceType  = 'issue';
        $instance->verb          = 'POST';
        $instance->unsetArray(['customer_uids', 'page', 'from', 'to', 'schedule-status', 'reason', 'extra']);

        return $instance;
    }

    /**
     * 비인증결제 빌링키 삭제.
     *
     * @return SubscribeCustomer
     */
    public static function delete(string $customer_uid, string $reason=null, SubscribeCustomerExtra $extra=null)
    {
        $instance                = new self();
        $instance->customer_uid  = $customer_uid;
        $instance->reason        = $reason;
        $instance->extra         = $extra;
        $instance->responseClass = Response\SubscribeCustomer::class;
        $instance->instanceType  = 'delete';
        $instance->verb          = 'DELETE';
        $instance->unsetArray([
            'customer_uids', 'pg', 'card_number', 'expiry', 'birth', 'pwd_2digit', 'customer_name', 'customer_tel',
            'customer_email', 'customer_addr', 'customer_postcode', 'page', 'from', 'to', 'schedule-status',
        ]);

        return $instance;
    }

    /**
     * 비인증결제 빌링키 목록조회.
     *
     * @return SubscribeCustomer
     */
    public static function list(array $customer_uids)
    {
        $instance                 = new self();
        $instance->customer_uids  = $customer_uids;
        $instance->isCollection   = true;
        $instance->responseClass  = Response\SubscribeCustomer::class;
        $instance->instanceType   = 'list';
        $instance->verb           = 'GET';
        $instance->unsetArray([
            'pg', 'card_number', 'expiry', 'birth', 'pwd_2digit', 'customer_name', 'customer_tel',
            'customer_email', 'customer_addr', 'customer_postcode', 'page', 'from', 'to', 'schedule-status', 'reason',
            'extra',
        ]);

        return $instance;
    }

    /**
     * 구매자의 빌링키로 결제된 결제목록 조회.
     *
     * @return SubscribeCustomer
     */
    public static function payments(string $customerUid)
    {
        $instance                 = new self();
        $instance->customer_uid   = $customerUid;
        $instance->isCollection   = true;
        $instance->isPaged        = true;
        $instance->responseClass  = Response\Payment::class;
        $instance->instanceType   = 'payments';
        $instance->verb           = 'GET';
        $instance->unsetArray([
            'customer_uids', 'pg', 'card_number', 'expiry', 'birth', 'pwd_2digit', 'customer_name', 'customer_tel',
            'customer_email', 'customer_addr', 'customer_postcode', 'from', 'to', 'schedule-status', 'reason',
            'extra',
        ]);

        return $instance;
    }

    /**
     * customer_uid별 결제예약목록을 조회.
     *
     * @param mixed $from
     * @param mixed $to
     *
     * @return SubscribeCustomer
     */
    public static function schedules(string $customerUid, $from, $to)
    {
        $instance                 = new self();
        $instance->customer_uid   = $customerUid;
        $instance->from           = $instance->dateToTimestamp($from);
        $instance->to             = $instance->dateToTimestamp($to);
        $instance->isCollection   = true;
        $instance->isPaged        = true;
        $instance->responseClass  = Response\Schedule::class;
        $instance->instanceType   = 'schedules';
        $instance->verb           = 'GET';
        $instance->unsetArray([
            'customer_uids', 'pg', 'card_number', 'expiry', 'birth', 'pwd_2digit', 'customer_name',
            'customer_tel', 'customer_email', 'customer_addr', 'customer_postcode', 'reason', 'extra',
        ]);

        return $instance;
    }

    public function setCustomerUid(string $customer_uid): void
    {
        $this->customer_uid = $customer_uid;
    }

    public function setPg(string $pg): void
    {
        $this->pg = $pg;
    }

    public function setCardNumber(string $card_number): void
    {
        $this->card_number = $card_number;
    }

    public function setExpiry(string $expiry): void
    {
        $this->expiry = $expiry;
    }

    public function setBirth(string $birth): void
    {
        $this->birth = $birth;
    }

    public function setPwd2digit(string $pwd_2digit): void
    {
        $this->pwd_2digit = $pwd_2digit;
    }

    public function setCustomerName(string $customer_name): void
    {
        $this->customer_name = $customer_name;
    }

    public function setCustomerTel(string $customer_tel): void
    {
        $this->customer_tel = $customer_tel;
    }

    public function setCustomerEmail(string $customer_email): void
    {
        $this->customer_email = $customer_email;
    }

    public function setCustomerAddr(string $customer_addr): void
    {
        $this->customer_addr = $customer_addr;
    }

    public function setCustomerPostcode(string $customer_postcode): void
    {
        $this->customer_postcode = $customer_postcode;
    }

    public function setPage(int $page): void
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

    public function setReason(string $reason): void
    {
        $this->reason = $reason;
    }

    public function setExtra(SubscribeCustomerExtra $extra): void
    {
        $this->extra = $extra;
    }

    /**
     * 구매자의 빌링키 정보 조회
     * [GET] /subscribe/customers/{customer_uid}.
     *
     * 구매자에 대해 빌링키 발급 및 저장
     * [POST] /subscribe/customers/{customer_uid}
     *
     * 구매자의 빌링키 정보 삭제(DB에서 빌링키를 삭제[delete] 합니다)
     * [DELETE] /subscribe/customers/{customer_uid}
     *
     * 여러 개의 빌링키를 한 번에 조회.
     * [GET] /subscribe/customers
     *
     * 구매자의 빌링키로 결제된 결제목록 조회
     * [GET] /subscribe/customers/{customer_uid}/payments
     *
     * customer_uid별 결제예약목록을 조회
     * [GET] /subscribe/customers/{customer_uid}/schedules
     */
    public function path(): string
    {
        if ($this->instanceType === 'list') {
            return Endpoint::SBCR_CUSTOMERS;
        } elseif ($this->instanceType === 'payments') {
            return Endpoint::SBCR_CUSTOMERS . '/' . $this->customer_uid . '/payments';
        } elseif ($this->instanceType === 'schedules') {
            return Endpoint::SBCR_CUSTOMERS . '/' . $this->customer_uid . Endpoint::SCHEDULES;
        } else {
            return Endpoint::SBCR_CUSTOMERS . '/' . $this->customer_uid;
        }
    }

    public function attributes(): array
    {
        switch ($this->instanceType) {
            case 'view':
                return [];
                break;
            case 'delete':
                $result = ['query' => []];

                if (!empty($this->reason)) {
                    $result['query']['reason'] = $this->reason;
                }

                if (!empty($this->extra)) {
                    $extra_requester = $this->extra->requester;
                    if (!empty($extra_requester)) {
                        $result['query']['extra[requester]'] = $extra_requester;
                    }
                }

                return $result;
                break;
            case 'issue':
                return [
                    'body' => json_encode($this->toArray()),
                ];
                break;
            case 'list':
                return [
                    'query' => [
                        'customer_uid' => $this->customer_uids,
                    ],
                ];
                break;
            case 'payments':
                return [
                    'query' => [
                        'page' => $this->page,
                    ],
                ];
                break;
            case 'schedules':
                $result =  [
                    'query' => [
                        'page'            => $this->page,
                        'from'            => $this->from,
                        'to'              => $this->to,
                    ],
                ];
                if ($this->schedule_status !== null) {
                    $result['query']['schedule-status'] = $this->schedule_status;
                }

                return $result;
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
