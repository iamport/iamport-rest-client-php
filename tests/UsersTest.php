<?php

namespace Iamport\RestClient\Test;

use Iamport\RestClient\Request\Users;
use PHPUnit\Framework\TestCase;

class UsersTest extends TestCase
{
    use IamportTestTrait;

    /** @test */
    public function users_pg_settings()
    {
        $request = Users::pgSettings();

        $this->assertEquals('/users/pg', $request->path());
        $this->assertEquals('GET', $request->verb());
        $this->assertEmpty($request->attributes());

        $response = $this->iamport->callApi($request);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }
}
