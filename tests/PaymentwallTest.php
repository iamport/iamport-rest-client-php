<?php

namespace Iamport\RestClient\Test;

use Iamport\RestClient\Request\Paymentwall;
use PHPUnit\Framework\TestCase;

class PaymentwallTest extends TestCase
{
    use IamportTestTrait;

    /** @test */
    public function paymentwall_delivery()
    {
        $request = Paymentwall::delivery(
            self::$impUid,
            self::$merchantUid,
            'physical',
            'delivering',
            time() + 86400,
            time(),
            'yes',
            'buyer@example.com'
        );
        $request->carrier_tracking_id       = 'TRACK123456';
        $request->carrier_type              = 'fedex';
        $request->shipping_address_country  = 'KR';
        $request->shipping_address_city     = 'Seoul';
        $request->shipping_address_zip      = '06000';

        $this->assertEquals('/paymentwall/delivery', $request->path());
        $this->assertEquals('POST', $request->verb());
        $this->assertArrayHasKey('body', $request->attributes());

        $body = json_decode($request->attributes()['body']);
        $this->assertEquals(self::$impUid, $body->imp_uid);
        $this->assertEquals(self::$merchantUid, $body->merchant_uid);
        $this->assertEquals('physical', $body->type);
        $this->assertEquals('delivering', $body->status);
        $this->assertEquals('buyer@example.com', $body->shipping_address_email);

        $response = $this->iamport->callApi($request);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }
}
