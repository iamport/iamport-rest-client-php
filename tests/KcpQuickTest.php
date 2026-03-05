<?php

namespace Iamport\RestClient\Test;

use Iamport\RestClient\Request\KcpQuick;
use PHPUnit\Framework\TestCase;

class KcpQuickTest extends TestCase
{
    use IamportTestTrait;

    /** @test */
    public function kcpquick_delete_member()
    {
        $request = KcpQuick::deleteMember('member_123', 'site_code_123', 'partner', 'subtype');

        $this->assertEquals('/kcpquick/members/member_123', $request->path());
        $this->assertEquals('DELETE', $request->verb());
        $this->assertArrayHasKey('query', $request->attributes());
        $this->assertEquals('site_code_123', $request->attributes()['query']['site_code']);
        $this->assertEquals('partner', $request->attributes()['query']['partner_type']);
        $this->assertEquals('subtype', $request->attributes()['query']['partner_subtype']);

        $response = $this->iamport->callApi($request);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function kcpquick_pay_money()
    {
        $request = KcpQuick::payMoney('member_123', 'channel_key_123', 'merchant_1234', '테스트 주문', 1000);
        $request->notice_url = 'http://notice.example.com';

        $this->assertEquals('/kcpquick/payment/money', $request->path());
        $this->assertEquals('POST', $request->verb());
        $this->assertArrayHasKey('body', $request->attributes());

        $body = json_decode($request->attributes()['body']);
        $this->assertEquals('member_123', $body->member_id);
        $this->assertEquals('channel_key_123', $body->channel_key);
        $this->assertEquals('merchant_1234', $body->merchant_uid);
        $this->assertEquals(1000, $body->amount);

        $response = $this->iamport->callApi($request);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }
}
