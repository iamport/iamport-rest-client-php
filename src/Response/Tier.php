<?php

namespace Iamport\RestClient\Response;

/**
 * Class Tier.
 */
class Tier
{
    use ResponseTrait;

    /**
     * @var string
     */
    protected $tier_code;

    /**
     * @var string
     */
    protected $tier_name;

    /**
     * Tier constructor.
     */
    public function __construct(array $response)
    {
        $this->tier_code = $response['tier_code'];
        $this->tier_name = $response['tier_name'];
    }

    public function getTierCode(): string
    {
        return $this->tier_code;
    }

    public function getTierName(): string
    {
        return $this->tier_name;
    }
}
