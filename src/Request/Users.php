<?php

namespace Iamport\RestClient\Request;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Response;

/**
 * Class Users.
 */
class Users extends RequestBase
{
    use RequestTrait;

    /**
     * Users constructor.
     */
    public function __construct()
    {
    }

    /**
     * PG MID 복수조회.
     *
     * @return Users
     */
    public static function pgSettings()
    {
        $instance                = new self();
        $instance->isCollection  = true;
        $instance->responseClass = Response\PgSetting::class;
        $instance->instanceType  = 'pgSettings';

        return $instance;
    }

    /**
     * PG MID 복수조회
     * [GET] /users/pg.
     */
    public function path(): string
    {
        return Endpoint::USERS_PG;
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
