<?php

namespace Iamport\RestClient\Request;

/**
 * Class CardInfo.
 *
 * @property string $card_number
 * @property string $expiry
 * @property string $birth
 * @property string $pwd_2digit
 */
class CardInfo
{
    use RequestTrait;

    /**
     * @var string 카드번호(dddd-dddd-dddd-dddd).
     */
    private $card_number;

    /**
     * @var string 카드 유효기간(YYYY-MM).
     */
    private $expiry;

    /**
     * @var string 생년월일6자리(법인카드의 경우 사업자등록번호10자리).
     */
    private $birth;

    /**
     * @var string 카드비밀번호 앞 2자리.
     */
    private $pwd_2digit;

    /**
     * CardInfo constructor.
     *
     * @param string $card_number
     * @param string $expiry
     * @param string $birth
     * @param string|null $pwd_2digit
     */
    public function __construct(string $card_number, string $expiry, string $birth, string $pwd_2digit = '')
    {
        $this->card_number = $card_number;
        $this->expiry      = $expiry;
        $this->birth       = $birth;

        if(!is_null( $pwd_2digit)) {
            $this->pwd_2digit = $pwd_2digit;
        }
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
}
