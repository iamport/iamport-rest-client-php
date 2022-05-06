<?php

namespace Iamport\RestClient\Request\Subscribe;

use Iamport\RestClient\Request\RequestTrait;

/**
 * Class SubscribeCustomerExtra.
 *
 * @property string $requester
 */
class SubscribeCustomerExtra
{
    use RequestTrait;

    /**
     * @var string
     */
    protected $requester;

    /**
     * SubscribeCustomerExtra constructor.
     */
    public function __construct()
    {
    }

    public function setRequester(string $requester): void
    {
        $this->requester = $requester;
    }
}
