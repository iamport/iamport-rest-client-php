<?php

namespace Iamport\RestClient\Request;

use Iamport\RestClient\Enum\Endpoint;

/**
 * Class Certification.
 *
 * @property string $imp_uid
 */
class Certification extends RequestBase
{
    use RequestTrait;

    /**
     * @var string HTTP verb
     */
    private $verb;

    /**
     * @var string 아임포트 거래 고유번호
     */
    protected $imp_uid;

    /**
     * Certification constructor.
     */
    public function __construct()
    {
        $this->responseType = 'Certification';
    }

    /**
     * Certification GET constructor.
     * SMS본인인증된 결과를 조회.
     * [GET] /certifications/{imp_uid}.
     *
     * @param string $impUid
     *
     * @return Certification
     */
    public static function view(string $impUid)
    {
        $instance          = new self();
        $instance->imp_uid = $impUid;
        $instance->verb    = 'GET';

        return $instance;
    }

    /**
     * Certification GET constructor.
     * SMS본인인증 결과정보를 아임포트에서 완전히 삭제
     * [DELETE] /certifications/{imp_uid}.
     *
     * @param string $impUid
     *
     * @return Certification
     */
    public static function delete(string $impUid)
    {
        $instance          = new self();
        $instance->imp_uid = $impUid;
        $instance->verb    = 'DELETE';

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
     * @return string
     */
    public function path(): string
    {
        return Endpoint::CERTIFICATIONS.$this->imp_uid;
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [];
    }

    /**
     * @return string
     */
    public function verb(): string
    {
        return $this->verb;
    }
}
