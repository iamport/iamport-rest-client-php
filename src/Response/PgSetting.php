<?php

namespace Iamport\RestClient\Response;

/**
 * Class PgSetting.
 */
class PgSetting
{
    use ResponseTrait;

    /**
     * @var string
     */
    protected $pg_provider;

    /**
     * @var string
     */
    protected $pg_id;

    /**
     * @var bool
     */
    protected $sandbox;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string|null
     */
    protected $channel_name;

    /**
     * @var string|null
     */
    protected $channel_key;

    /**
     * PgSetting constructor.
     */
    public function __construct(array $response)
    {
        $this->pg_provider  = $response['pg_provider'];
        $this->pg_id        = $response['pg_id'];
        $this->sandbox      = $response['sandbox'];
        $this->type         = $response['type'];
        $this->channel_name = $response['channel_name'] ?? null;
        $this->channel_key  = $response['channel_key'] ?? null;
    }

    public function getPgProvider(): string
    {
        return $this->pg_provider;
    }

    public function getPgId(): string
    {
        return $this->pg_id;
    }

    public function getSandbox(): bool
    {
        return $this->sandbox;
    }

    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getChannelName()
    {
        return $this->channel_name;
    }

    /**
     * @return string|null
     */
    public function getChannelKey()
    {
        return $this->channel_key;
    }
}
