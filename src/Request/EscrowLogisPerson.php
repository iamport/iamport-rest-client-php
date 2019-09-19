<?php

namespace Iamport\RestClient\Request;

/**
 * Class EscrowLogisPerson.
 *
 * @property string $name
 * @property string $tel
 * @property string $addr
 * @property string $postcode
 */
class EscrowLogisPerson
{
    use RequestTrait;

    /**
     * @var string 이름
     */
    protected $name;

    /**
     * @var string 전화번호
     */
    protected $tel;

    /**
     * @var string 주소
     */
    protected $addr;

    /**
     * @var string 우편번호
     */
    protected $postcode;

    /**
     * EscrowLogisPerson constructor.
     *
     * @param string $name
     * @param string $tel
     * @param string $addr
     * @param string $postcode
     */
    public function __construct(string $name, string $tel, string $addr, string $postcode)
    {
        $this->name     = $name;
        $this->tel      = $tel;
        $this->addr     = $addr;
        $this->postcode = $postcode;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $tel
     */
    public function setTel(string $tel): void
    {
        $this->tel = $tel;
    }

    /**
     * @param string $addr
     */
    public function setAddr(string $addr): void
    {
        $this->addr = $addr;
    }

    /**
     * @param string $postcode
     */
    public function setPostcode(string $postcode): void
    {
        $this->postcode = $postcode;
    }
}
