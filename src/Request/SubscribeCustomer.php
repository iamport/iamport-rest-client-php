<?php

namespace Iamport\RestClient\Request;

use Iamport\RestClient\Enum\Endpoint;

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
    private $customer_uid;

    /**
     * @var string API 방식 비인증 PG설정이 2개 이상인 경우 지정
     */
    private $pg;

    /**
     * @var string 카드번호(dddd-dddd-dddd-dddd)
     */
    private $card_number;

    /**
     * @var string 카드 유효기간(YYYY-MM)
     */
    private $expiry;

    /**
     * @var string 생년월일6자리(법인카드의 경우 사업자등록번호10자리)
     */
    private $birth;

    /**
     * @var string 카드비밀번호 앞 2자리
     */
    private $pwd_2digit;

    /**
     * @var string 카드 고객(카드소지자) 관리용 성함
     */
    private $customer_name;

    /**
     * @var string 고객(카드소지자) 전화번호
     */
    private $customer_tel;

    /**
     * @var string 고객(카드소지자) Email
     */
    private $customer_email;

    /**
     * @var string 고객(카드소지자) 주소
     */
    private $customer_addr;

    /**
     * @var string 고객(카드소지자) 우편번호
     */
    private $customer_postcode;

    /**
     * SubscribeCustomer GET constructor.
     * 비인증결제 빌링키 조회.
     * [GET] /subscribe/customers/{$customerUid}.
     *
     * @param string $customer_uid
     *
     * @return SubscribeCustomer
     */
    public static function view(string $customer_uid)
    {
        $instance = new self();
        $instance->setCustomerUid($customer_uid);
        $instance->verb = 'GET';

        return $instance;
    }

    /**
     * SubscribeCustomer POST constructor.
     * 비인증결제 빌링키 등록(수정).
     * [POST] /subscribe/customers/{customer_uid}.
     *
     * @param string $customer_uid
     * @param CardInfo $cardInfo
     *
     * @return SubscribeCustomer
     */
    public static function issue(string $customer_uid, CardInfo $cardInfo)
    {
        $instance = new self();
        $instance->setCustomerUid($customer_uid);
        $instance->setCardNumber($cardInfo->card_number);
        $instance->setExpiry($cardInfo->expiry);
        $instance->setBirth($cardInfo->birth);

        if (!is_null($cardInfo->pwd_2digit)) {
            $instance->setPwd2digit($cardInfo->pwd_2digit);
        }
        $instance->verb = 'POST';

        return $instance;
    }

    /**
     * SubscribeCustomer DELETE constructor.
     * 비인증결제 빌링키 삭제.
     * [DELETE] /subscribe/customers/{$customerUid}.
     *
     * @param string $customer_uid
     *
     * @return SubscribeCustomer
     */
    public static function delete(string $customer_uid)
    {
        $instance = new self();
        $instance->setCustomerUid($customer_uid);
        $instance->verb = 'DELETE';

        return $instance;
    }

    /**
     * @param string $customer_uid
     */
    public function setCustomerUid(string $customer_uid): void
    {
        $this->customer_uid = $customer_uid;
    }

    /**
     * @param string $pg
     */
    public function setPg(string $pg): void
    {
        $this->pg = $pg;
    }

    /**
     * @param string $card_number
     */
    public function setCardNumber(string $card_number): void
    {
        $this->card_number = $card_number;
    }

    /**
     * @param string $expiry
     */
    public function setExpiry(string $expiry): void
    {
        $this->expiry = $expiry;
    }

    /**
     * @param string $birth
     */
    public function setBirth(string $birth): void
    {
        $this->birth = $birth;
    }

    /**
     * @param string $pwd_2digit
     */
    public function setPwd2digit(string $pwd_2digit): void
    {
        $this->pwd_2digit = $pwd_2digit;
    }

    /**
     * @param string $customer_name
     */
    public function setCustomerName(string $customer_name): void
    {
        $this->customer_name = $customer_name;
    }

    /**
     * @param string $customer_tel
     */
    public function setCustomerTel(string $customer_tel): void
    {
        $this->customer_tel = $customer_tel;
    }

    /**
     * @param string $customer_email
     */
    public function setCustomerEmail(string $customer_email): void
    {
        $this->customer_email = $customer_email;
    }

    /**
     * @param string $customer_addr
     */
    public function setCustomerAddr(string $customer_addr): void
    {
        $this->customer_addr = $customer_addr;
    }

    /**
     * @param string $customer_postcode
     */
    public function setCustomerPostcode(string $customer_postcode): void
    {
        $this->customer_postcode = $customer_postcode;
    }

    /**
     * 구매자의 빌링키 정보 조회
     * [GET] /subscribe/customers/{customer_uid}
     *
     * 구매자에 대해 빌링키 발급 및 저장
     * [POST] /subscribe/customers/{customer_uid}
     *
     * 구매자의 빌링키 정보 삭제(DB에서 빌링키를 삭제[delete] 합니다)
     * [DELETE] /subscribe/customers/{customer_uid}
     *
     * @return string
     */
    public function path(): string
    {
        return Endpoint::SBCR_CUSTOMERS.$this->customer_uid;
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        if($this->verb === 'POST') {
            return [
                'body' => json_encode($this->toArray()),
            ];
        } else {
            return [];
        }
    }

    /**
     * @return string
     */
    public function verb(): string
    {
        return $this->verb;
    }
}
