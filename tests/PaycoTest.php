<?php

namespace Iamport\RestClient\Test;

use Iamport\RestClient\Enum\PaycoStatus;
use Iamport\RestClient\Request\Payco;
use PHPUnit\Framework\TestCase;

class PaycoTest extends TestCase
{
    use IamportTestTrait;

    /** @test */
    public function payco()
    {
        $request = new Payco(self::$impUid, PaycoStatus::CANCELED);

        $this->assertEquals('/payco/orders/status/' . self::$impUid, $request->path());
        $this->assertEquals('POST', $request->verb());
        $this->assertArrayHasKey('body', $request->attributes());
        $this->assertObjectHasAttribute('imp_uid', json_decode($request->attributes()['body']));
        $this->assertObjectHasAttribute('status', json_decode($request->attributes()['body']));

        $response    = $this->iamport->callApi($request);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }
}
