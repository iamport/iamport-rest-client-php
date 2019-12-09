<?php

namespace Iamport\RestClient\Test;

use Iamport\RestClient\Request\Escrow\EscrowLogis;
use Iamport\RestClient\Request\Escrow\EscrowLogisInvoice;
use Iamport\RestClient\Request\Escrow\EscrowLogisPerson;
use PHPUnit\Framework\TestCase;

class EscrowTest extends TestCase
{
    use IamportTestTrait;

    /** @test */
    public function register_escrow()
    {
        $sender   = new EscrowLogisPerson('홍길동', '010-1234-5678', '서울시 강남구 삼성동', '15411');
        $receiver = new EscrowLogisPerson('김길동', '010-1234-5678', '서울시 마포구 연희동', '16211');
        $invoice  = new EscrowLogisInvoice('시옷', '123456', '1568785782');

        $escrow = EscrowLogis::register(self::$impUid, $sender, $receiver, $invoice);

        $this->assertEquals('/escrows/logis/' . self::$impUid, $escrow->path());
        $this->assertEquals('POST', $escrow->verb());
        $this->assertArrayHasKey('body', $escrow->attributes());

        $response = $this->iamport->callApi($escrow);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function update_escrow()
    {
        $sender   = new EscrowLogisPerson('홍길동', '010-1234-5678', '서울시 강남구 삼성동', '15411');
        $receiver = new EscrowLogisPerson('김길동', '010-1234-5678', '서울시 마포구 연희동', '16211');
        $invoice  = new EscrowLogisInvoice('시옷', '123456', '1568785782');

        $escrow = EscrowLogis::update(self::$impUid, $sender, $receiver, $invoice);

        $this->assertEquals('/escrows/logis/' . self::$impUid, $escrow->path());
        $this->assertEquals('PUT', $escrow->verb());
        $this->assertArrayHasKey('body', $escrow->attributes());

        $response  = $this->iamport->callApi($escrow);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }
}
