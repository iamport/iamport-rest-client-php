<?php

namespace Iamport\RestClient\Test;

use Iamport\RestClient\Request\Receipt;
use PHPUnit\Framework\TestCase;

class ReceiptTest extends TestCase
{
    use IamportTestTrait;

    /** @test */
    public function view_receipt()
    {
        $receipt  = Receipt::view(self::$impUid);

        $this->assertEquals('/receipts/' . self::$impUid, $receipt->path());
        $this->assertEquals('GET', $receipt->verb());
        $this->assertEmpty($receipt->attributes());

        $response = $this->iamport->callApi($receipt);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
        $this->assertTrue($response->isSuccess());
        $this->assertNull($response->getError());
        $this->assertInstanceOf('Iamport\RestClient\Response\Receipt', $response->getData());
    }

    /** @test */
    public function cancel_receipt()
    {
        $receipt  = Receipt::cancel(self::$impUid);

        $this->assertEquals('/receipts/' . self::$impUid, $receipt->path());
        $this->assertEquals('DELETE', $receipt->verb());
        $this->assertEmpty($receipt->attributes());

        $response = $this->iamport->callApi($receipt);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function issue_receipt()
    {
        $receipt              = Receipt::issue(self::$impUid, '01012341234');
        $receipt->type        = 'person';
        $receipt->buyer_name  = '구매자 이름';
        $receipt->buyer_email = '구매자 이메일';
        $receipt->buyer_tel   = '구매자 전화번호';
        $receipt->tax_free    = 0;

        $this->assertEquals('/receipts/' . self::$impUid, $receipt->path());
        $this->assertEquals('POST', $receipt->verb());
        $this->assertArrayHasKey('body', $receipt->attributes());

        $response = $this->iamport->callApi($receipt);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }
}
