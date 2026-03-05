<?php

namespace Iamport\RestClient\Test;

use Iamport\RestClient\Request\Cvs;
use PHPUnit\Framework\TestCase;

class CvsTest extends TestCase
{
    use IamportTestTrait;

    /** @test */
    public function cvs_issue()
    {
        $request = Cvs::issue('channel_key_123', 'merchant_1234', 1000);
        $request->name           = '테스트 주문';
        $request->buyer_name     = '홍길동';
        $request->buyer_email    = 'test@example.com';
        $request->buyer_tel      = '01012341234';

        $this->assertEquals('/cvs', $request->path());
        $this->assertEquals('POST', $request->verb());
        $this->assertArrayHasKey('body', $request->attributes());

        $body = json_decode($request->attributes()['body']);
        $this->assertEquals('channel_key_123', $body->channel_key);
        $this->assertEquals('merchant_1234', $body->merchant_uid);
        $this->assertEquals(1000, $body->amount);

        $response = $this->iamport->callApi($request);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function cvs_revoke()
    {
        $request = Cvs::revoke(self::$impUid);

        $this->assertEquals('/cvs/' . self::$impUid, $request->path());
        $this->assertEquals('DELETE', $request->verb());
        $this->assertEmpty($request->attributes());

        $response = $this->iamport->callApi($request);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }
}
