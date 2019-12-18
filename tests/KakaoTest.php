<?php

namespace Iamport\RestClient\Test;

use Iamport\RestClient\Request\Kakaopay;
use PHPUnit\Framework\TestCase;

class KakaoTest extends TestCase
{
    use IamportTestTrait;

    /** @test */
    public function kakao_wrap()
    {
        $request = new Kakaopay('20190902');

        $this->assertEquals('/kakao/payment/orders', $request->path());
        $this->assertEquals('GET', $request->verb());
        $this->assertArrayHasKey('query', $request->attributes());
        $this->assertArrayHasKey('payment_request_date', $request->attributes()['query']);

        $response = $this->iamport->callApi($request);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }
}
