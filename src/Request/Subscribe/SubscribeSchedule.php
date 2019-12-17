<?php

namespace Iamport\RestClient\Request\Subscribe;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Request\CardInfo;
use Iamport\RestClient\Request\RequestBase;
use Iamport\RestClient\Request\RequestTrait;
use Iamport\RestClient\Response;

/**
 * Class SubscribeSchedule.
 *
 * @property string $customer_uid
 * @property int    $checking_amount
 * @property string $card_number
 * @property string $expiry
 * @property string $birth
 * @property string $pwd_2digit
 * @property string $pg
 * @property array  $schedules
 */
class SubscribeSchedule extends RequestBase
{
    use RequestTrait;

    /**
     * @var string 고객 고유번호
     */
    protected $customer_uid;

    /**
     * @var int 카드정상결제여부 체크용 금액
     */
    protected $checking_amount;

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
     * @var string API 방식 비인증 PG설정이 2개 이상인 경우 지정
     */
    protected $pg;

    /**
     * @var array 결제예약 스케쥴
     */
    protected $schedules = [];

    /**
     * SubscribeSchedule constructor.
     */
    public function __construct(string $customer_uid)
    {
        $this->customer_uid  = $customer_uid;
        $this->responseClass = Response\Schedule::class;
        $this->isCollection  = true;
    }

    /**
     * Schedule 객체를 array 형태로 변환하여 추가
     */
    public function addSchedules(Schedule $schedule)
    {
        array_push($this->schedules, $schedule->toArray());
    }

    public function setCardInfo(CardInfo $cardInfo)
    {
        $this->card_number = $cardInfo->card_number;
        $this->expiry      = $cardInfo->expiry;
        $this->birth       = $cardInfo->birth;
        $this->pwd_2digit  = $cardInfo->pwd_2digit;
    }

    public function setCustomerUid(string $customer_uid): void
    {
        $this->customer_uid = $customer_uid;
    }

    public function setCheckingAmount(int $checking_amount): void
    {
        $this->checking_amount = $checking_amount;
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

    public function setPg(string $pg): void
    {
        $this->pg = $pg;
    }

    /**
     * 저장된 빌링키로 정기 예약 결제.
     * [POST] /subscribe/payments/schedule.
     */
    public function path(): string
    {
        return Endpoint::SBCR_PAYMENTS_SCHEDULE;
    }

    public function attributes(): array
    {
        return [
            'body' => json_encode($this->toArray()),
        ];
    }

    public function verb(): string
    {
        return 'POST';
    }
}
