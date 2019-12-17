<?php

namespace Iamport\RestClient\Request;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Enum\VbankCode;
use Iamport\RestClient\Response;
use InvalidArgumentException;

/**
 * Class Vbank.
 *
 * @property string $imp_uid
 * @property string $merchant_uid
 * @property float  $amount
 * @property string $vbank_code
 * @property mixed  $vbank_due
 * @property string $vbank_holder
 * @property string $name
 * @property string $buyer_name
 * @property string $buyer_email
 * @property string $buyer_tel
 * @property string $buyer_addr
 * @property string $buyer_postcode
 * @property string $pg
 * @property string $notice_url
 * @property string $custom_data
 * @property string $bank_code
 * @property string $bank_num
 */
class Vbank extends RequestBase
{
    use RequestTrait;

    /**
     * @var string 아임포트 고유번호
     */
    protected $imp_uid;

    /**
     * @var string 가맹점 거래 고유번호
     */
    protected $merchant_uid;

    /**
     * @var float 결제금액
     */
    protected $amount;

    /**
     * @var string 은행구분코드
     */
    protected $vbank_code;

    /**
     * @var mixed 가상계좌 입금기한 (UNIX TIMESTAMP | Y-m-d H:i:s 포맷의 문자열 date)
     */
    protected $vbank_due;

    /**
     * @var string 가상계좌 예금주명
     */
    protected $vbank_holder;

    /**
     * @var string 주문명
     */
    protected $name;

    /**
     * @var string 주문자명
     */
    protected $buyer_name;

    /**
     * @var string 주문자 E-mail주소
     */
    protected $buyer_email;

    /**
     * @var string 주문자 전화번호
     */
    protected $buyer_tel;

    /**
     * @var string 주문자 주소
     */
    protected $buyer_addr;

    /**
     * @var string 주문자 우편번호
     */
    protected $buyer_postcode;

    /**
     * @var string PG사 구분자
     */
    protected $pg;

    /**
     * @var array 가상계좌 입금시 입금통지받을 URL
     */
    protected $notice_url;

    /**
     * @var string 결제정보와 함께 저장할 custom_data
     */
    protected $custom_data;

    /**
     * @var string 은행코드(금융결제원 표준코드3자리)
     */
    protected $bank_code;

    /**
     * @var string 계좌번호(숫자외 기호 포함 가능)
     */
    protected $bank_num;

    /**
     * @var string HTTP verb
     */
    private $verb;

    /**
     * @param mixed $vbankDue
     *
     * @return Vbank
     */
    public static function store(string $merchantUid, float $amount, string $vbankCode, $vbankDue, string $vbankHolder)
    {
        $instance                 = new self();
        $instance->merchant_uid   = $merchantUid;
        $instance->amount         = $amount;
        if (!VbankCode::validation($vbankCode)) {
            throw new InvalidArgumentException('허용되지 않는 은행코드 입니다. ( VbankCode::getAll()로 허용 가능한 값을 확인해주세요. )');
        }
        $instance->vbank_code     = $vbankCode;
        $instance->vbank_due      = $instance->dateToTimestamp($vbankDue);
        $instance->vbank_holder   = $vbankHolder;
        $instance->responseClass  = Response\Payment::class;
        $instance->instanceType   = 'store';
        $instance->verb           = 'POST';
        $instance->unsetArray(['imp_uid', 'bank_code', 'bank_num']);

        return $instance;
    }

    /**
     * @return Vbank
     */
    public static function delete(string $impUid)
    {
        $instance                 = new self();
        $instance->imp_uid        = $impUid;
        $instance->responseClass  = Response\Payment::class;
        $instance->instanceType   = 'delete';
        $instance->verb           = 'DELETE';
        $instance->unsetArray(
            [
                'merchant_uid', 'amount', 'vbank_code', 'vbank_due', 'vbank_holder',
                'name', 'buyer_name', 'buyer_email', 'buyer_tel', 'buyer_addr',
                'buyer_postcode', 'pg', 'notice_url', 'custom_data', 'bank_code', 'bank_num',
            ]
        );

        return $instance;
    }

    /**
     * @return Vbank
     */
    public static function edit(string $impUid)
    {
        $instance                   = new self();
        $instance->imp_uid          = $impUid;
        $instance->responseClass    = Response\Payment::class;
        $instance->instanceType     = 'edit';
        $instance->verb             = 'PUT';
        $instance->unsetArray(
            [
                'merchant_uid', 'vbank_code', 'vbank_holder', 'name', 'buyer_name',
                'buyer_email', 'buyer_tel', 'buyer_addr', 'buyer_postcode', 'pg',
                'notice_url', 'custom_data', 'bank_code', 'bank_num',
            ]
        );

        return $instance;
    }

    /**
     * @return Vbank
     */
    public static function view(string $bankCode, string $bankNum)
    {
        $instance                     = new self();
        $instance->bank_code          = $bankCode;
        $instance->bank_num           = $bankNum;
        $instance->responseClass      = Response\VbankHolder::class;
        $instance->instanceType       = 'view';
        $instance->verb               = 'GET';
        $instance->unsetArray(
            [
                'imp_uid', 'amount', 'merchant_uid', 'vbank_code', 'vbank_due',
                'vbank_holder', 'name', 'buyer_name', 'buyer_email', 'buyer_tel',
                'buyer_addr', 'buyer_postcode', 'pg', 'notice_url', 'custom_data',
            ]
        );

        return $instance;
    }

    public function setMerchantUid(string $merchant_uid): void
    {
        $this->merchant_uid = $merchant_uid;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function setVbankCode(string $vbank_code): void
    {
        $this->vbank_code = $vbank_code;
    }

    /**
     * @param mixed $vbank_due
     */
    public function setVbankDue($vbank_due): void
    {
        $this->vbank_due = $this->dateToTimestamp($vbank_due);
    }

    public function setVbankHolder(string $vbank_holder): void
    {
        $this->vbank_holder = $vbank_holder;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setBuyerName(string $buyer_name): void
    {
        $this->buyer_name = $buyer_name;
    }

    public function setBuyerEmail(string $buyer_email): void
    {
        $this->buyer_email = $buyer_email;
    }

    public function setBuyerTel(string $buyer_tel): void
    {
        $this->buyer_tel = $buyer_tel;
    }

    public function setBuyerAddr(string $buyer_addr): void
    {
        $this->buyer_addr = $buyer_addr;
    }

    public function setBuyerPostcode(string $buyer_postcode): void
    {
        $this->buyer_postcode = $buyer_postcode;
    }

    public function setPg(string $pg): void
    {
        $this->pg = $pg;
    }

    public function setNoticeUrl(array $notice_url): void
    {
        $this->notice_url = $notice_url;
    }

    public function setCustomData(string $custom_data): void
    {
        $this->custom_data = $custom_data;
    }

    /**
     * API 요청만으로 가상계좌를 생성
     * [POST] /vbanks.
     *
     * API요청으로 발급된 가상계좌(입금이 되기 전)를 말소
     * [DELETE] /vbanks/{imp_uid}
     *
     * API요청으로 발급된 가상계좌(입금이 되기 전)의 정보를 수정
     * [PUT] /vbanks/{imp_uid}
     *
     * 가상계좌 환불 전, 확인차원에서 예금주를 조회
     * [GET] /vbanks/holder
     */
    public function path(): string
    {
        switch ($this->instanceType) {
            case 'store':
                return Endpoint::VBANKS;
                break;
            case 'delete':
            case 'edit':
                return Endpoint::VBANKS . '/' . $this->imp_uid;
                break;
            case 'view':
                return Endpoint::VBANKS_HOLDER;
                break;
        }
    }

    public function attributes(): array
    {
        switch ($this->instanceType) {
            case 'store':
            case 'edit':
                return [
                    'body' => json_encode($this->toArray()),
                ];
                break;
            case 'delete':
                return [];
                break;
            case 'view':
                return [
                    'query' => [
                        'bank_code' => $this->bank_code,
                        'bank_num'  => $this->bank_num,
                    ],
                ];
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
