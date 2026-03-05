<?php

namespace Iamport\RestClient\Test;

use Iamport\RestClient\Request\Partners;
use PHPUnit\Framework\TestCase;

class PartnersTest extends TestCase
{
    use IamportTestTrait;

    /** @test */
    public function partners_receipt()
    {
        $data = [
            [
                'partner_id'   => 'partner_001',
                'merchant_uid' => 'merchant_001',
                'amount'       => 5000,
            ],
        ];

        $request = Partners::receipt(self::$impUid, $data);

        $this->assertEquals('/partners/receipts/' . self::$impUid, $request->path());
        $this->assertEquals('POST', $request->verb());
        $this->assertArrayHasKey('body', $request->attributes());

        $body = json_decode($request->attributes()['body'], true);
        $this->assertArrayHasKey('data', $body);
        $this->assertCount(1, $body['data']);

        $response = $this->iamport->callApi($request);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }
}
