<?php

namespace Iamport\RestClient\Test;

use Iamport\RestClient\Request\Benepia;
use PHPUnit\Framework\TestCase;

class BenepiaTest extends TestCase
{
    use IamportTestTrait;

    /** @test */
    public function benepia_point()
    {
        $request = Benepia::point('test_user', 'test_password', 'channel_key_123');

        $this->assertEquals('/benepia/point', $request->path());
        $this->assertEquals('POST', $request->verb());
        $this->assertArrayHasKey('body', $request->attributes());

        $body = json_decode($request->attributes()['body']);
        $this->assertEquals('test_user', $body->benepia_user);
        $this->assertEquals('test_password', $body->benepia_password);
        $this->assertEquals('channel_key_123', $body->channel_key);

        $response = $this->iamport->callApi($request);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function benepia_payment()
    {
        $request = Benepia::payment('test_user', 'test_password', 'channel_key_123', 'merchant_1234', 1000, '테스트 주문');
        $request->buyer_name     = '홍길동';
        $request->buyer_email    = 'test@example.com';
        $request->buyer_tel      = '01012341234';
        $request->buyer_addr     = '서울시 강남구';
        $request->buyer_postcode = '06000';

        $this->assertEquals('/benepia/payment', $request->path());
        $this->assertEquals('POST', $request->verb());
        $this->assertArrayHasKey('body', $request->attributes());

        $body = json_decode($request->attributes()['body']);
        $this->assertEquals('test_user', $body->benepia_user);
        $this->assertEquals('merchant_1234', $body->merchant_uid);
        $this->assertEquals(1000, $body->amount);

        $response = $this->iamport->callApi($request);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }
}
