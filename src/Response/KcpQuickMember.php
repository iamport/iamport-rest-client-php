<?php

namespace Iamport\RestClient\Response;

/**
 * Class KcpQuickMember.
 */
class KcpQuickMember
{
    use ResponseTrait;

    /**
     * @var string
     */
    protected $member_id;

    /**
     * @var string
     */
    protected $pg_provider;

    /**
     * @var string
     */
    protected $pg_id;

    /**
     * @var int
     */
    protected $inserted;

    /**
     * @var int
     */
    protected $updated;

    /**
     * KcpQuickMember constructor.
     */
    public function __construct(array $response)
    {
        $this->member_id   = $response['member_id'];
        $this->pg_provider = $response['pg_provider'];
        $this->pg_id       = $response['pg_id'] ?? null;
        $this->inserted    = $response['inserted'];
        $this->updated     = $response['updated'];
    }

    public function getMemberId(): string
    {
        return $this->member_id;
    }

    public function getPgProvider(): string
    {
        return $this->pg_provider;
    }

    /**
     * @return string|null
     */
    public function getPgId()
    {
        return $this->pg_id;
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function getInserted()
    {
        return $this->timestampToDate($this->inserted);
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function getUpdated()
    {
        return $this->timestampToDate($this->updated);
    }
}
