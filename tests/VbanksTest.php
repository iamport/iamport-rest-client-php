<?php

namespace Iamport\RestClient\Test;

use DateTime;
use Iamport\RestClient\Enum\BankCode;
use Iamport\RestClient\Request\Vbank;
use PHPUnit\Framework\TestCase;

class VbanksTest extends TestCase
{
    use IamportTestTrait;

    /** @test */
    public function vbanks_view()
    {
        $request = Vbank::view(BankCode::SC, '35016182520575');

        $this->assertEquals('/vbanks/holder', $request->path());
        $this->assertEquals('GET', $request->verb());
        $this->assertArrayHasKey('query', $request->attributes());
        $this->assertArrayHasKey('bank_code', $request->attributes()['query']);
        $this->assertArrayHasKey('bank_num', $request->attributes()['query']);

        $response = $this->iamport->callApi($request);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function vbanks_store()
    {
        $request = Vbank::store(self::$merchantUid, 1000, BankCode::SC, '2019-12-25 : 08:00:00', '홍길동');

        $this->assertEquals('/vbanks', $request->path());
        $this->assertEquals('POST', $request->verb());
        $this->assertArrayHasKey('body', $request->attributes());
        $this->assertObjectHasAttribute('merchant_uid', json_decode($request->attributes()['body']));
        $this->assertObjectHasAttribute('amount', json_decode($request->attributes()['body']));
        $this->assertObjectHasAttribute('vbank_code', json_decode($request->attributes()['body']));
        $this->assertObjectHasAttribute('vbank_due', json_decode($request->attributes()['body']));
        $this->assertObjectHasAttribute('vbank_holder', json_decode($request->attributes()['body']));

        $response = $this->iamport->callApi($request);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function vbanks_edit()
    {
        $request            = Vbank::edit(self::$impUid);
        $request->amount    = '1001';
        $request->vbank_due = new DateTime('2019-12-26 08:00:00');

        $this->assertEquals('/vbanks/' . self::$impUid, $request->path());
        $this->assertEquals('PUT', $request->verb());
        $this->assertArrayHasKey('body', $request->attributes());
        $this->assertObjectHasAttribute('amount', json_decode($request->attributes()['body']));
        $this->assertObjectHasAttribute('vbank_due', json_decode($request->attributes()['body']));

        $response = $this->iamport->callApi($request);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }
}
