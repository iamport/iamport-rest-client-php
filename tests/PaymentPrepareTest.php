<?php

namespace Iamport\RestClient\Test;

use Iamport\RestClient\Request\PaymentPrepare;
use PHPUnit\Framework\TestCase;

class PaymentPrepareTest extends TestCase
{
    use IamportTestTrait;

    /** @test */
    public function prepare_view()
    {
        $request = PaymentPrepare::view(self::$merchantUid);

        $this->assertEquals('/payments/prepare/' . self::$merchantUid, $request->path());
        $this->assertEquals('GET', $request->verb());

        $response    = $this->iamport->callApi($request);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function prepare_store()
    {
        $request = PaymentPrepare::store(self::$merchantUid, 1000);

        $this->assertEquals('/payments/prepare', $request->path());
        $this->assertEquals('POST', $request->verb());
        $this->assertArrayHasKey('body', $request->attributes());
        $this->assertObjectHasAttribute('amount', json_decode($request->attributes()['body']));

        $response    = $this->iamport->callApi($request);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }
}
