<?php

namespace Iamport\RestClient\Response;

/**
 * Class Certification.
 */
class Certification
{
    use ResponseTrait;

    /**
     * @var string
     */
    protected $imp_uid;

    /**
     * @var string
     */
    protected $merchant_uid;

    /**
     * @var string
     */
    protected $pg_tid;

    /**
     * @var string
     */
    protected $pg_provider;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $gender;

    /**
     * @var int
     */
    protected $birth;

    /**
     * @var bool
     */
    protected $foreigner;

    /**
     * @var bool
     */
    protected $certified;

    /**
     * @var mixed
     */
    protected $certified_at;

    /**
     * @var mixed
     */
    protected $unique_key;

    /**
     * @var string
     */
    protected $unique_in_site;

    /**
     * @var string
     */
    protected $origin;

    /**
     * Certification constructor.
     */
    public function __construct(array $response)
    {
        $this->imp_uid          = $response['imp_uid'];
        $this->merchant_uid     = $response['merchant_uid'];
        $this->pg_tid           = $response['pg_tid'];
        $this->pg_provider      = $response['pg_provider'];
        $this->name             = $response['name'];
        $this->gender           = $response['gender'];
        $this->birth            = $response['birth'];
        $this->foreigner        = $response['foreigner'];
        $this->certified        = $response['certified'];
        $this->certified_at     = $response['certified_at'];
        $this->unique_key       = $response['unique_key'];
        $this->unique_in_site   = $response['unique_in_site'];
        $this->origin           = $response['origin'];
    }

    public function getImpUid(): string
    {
        return $this->imp_uid;
    }

    public function getMerchantUid(): string
    {
        return $this->merchant_uid;
    }

    public function getPgTid(): string
    {
        return $this->pg_tid;
    }

    public function getPgProvider(): string
    {
        return $this->pg_provider;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function getBirth()
    {
        return $this->timestampToDate($this->birth, 'Y-m-d');
    }

    public function isForeigner(): bool
    {
        return $this->foreigner;
    }

    public function isCertified(): bool
    {
        return $this->certified;
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function getCertifiedAt()
    {
        return $this->timestampToDate($this->certified_at);
    }

    /**
     * @return mixed
     */
    public function getUniqueKey()
    {
        return $this->unique_key;
    }

    public function getUniqueInSite(): string
    {
        return $this->unique_in_site;
    }

    public function getOrigin(): string
    {
        return $this->origin;
    }
}
