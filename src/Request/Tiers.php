<?php

namespace Iamport\RestClient\Request;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Response;

/**
 * Class Tiers.
 *
 * @property string $tier_code
 */
class Tiers extends RequestBase
{
    use RequestTrait;

    /**
     * @var string 하위 상점(Tier) 고유코드
     */
    protected $tier_code;

    /**
     * Tiers constructor.
     */
    public function __construct()
    {
    }

    /**
     * 하위 상점 정보 조회.
     *
     * @return Tiers
     */
    public static function view(string $tierCode)
    {
        $instance                = new self();
        $instance->tier_code     = $tierCode;
        $instance->responseClass = Response\Tier::class;
        $instance->instanceType  = 'view';

        return $instance;
    }

    public function setTierCode(string $tier_code): void
    {
        $this->tier_code = $tier_code;
    }

    /**
     * 하위 상점 정보 조회
     * [GET] /tiers/{tier_code}.
     */
    public function path(): string
    {
        return Endpoint::TIERS . $this->tier_code;
    }

    public function attributes(): array
    {
        return [];
    }

    public function verb(): string
    {
        return 'GET';
    }
}
