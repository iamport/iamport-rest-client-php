<?php

namespace Iamport\RestClient\Test;

use Iamport\RestClient\Request\Code;
use PHPUnit\Framework\TestCase;

class CodesTest extends TestCase
{
    use IamportTestTrait;

    /** @test */
    public function banks()
    {
        $banks = Code::banks();

        $this->assertEquals('/banks', $banks->path());
        $this->assertEquals('GET', $banks->verb());
        $this->assertEmpty($banks->attributes());

        $response = $this->iamport->callApi($banks);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
        $this->assertTrue($response->isSuccess());
        $this->assertNull($response->getError());
        $this->assertInstanceOf('Iamport\RestClient\Response\Collection', $response->getData());
        $this->assertInstanceOf('Iamport\RestClient\Response\StandardCode', $response->getData()->getItems()[0]);
    }

    /** @test */
    public function bank()
    {
        $bankCode = '023';

        $bank = Code::bank($bankCode);

        $this->assertEquals('/banks/' . $bankCode, $bank->path());
        $this->assertEquals('GET', $bank->verb());
        $this->assertEmpty($bank->attributes());

        $response = $this->iamport->callApi($bank);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
        $this->assertTrue($response->isSuccess());
        $this->assertNull($response->getError());
        $this->assertInstanceOf('Iamport\RestClient\Response\StandardCode', $response->getData());
    }

    /** @test */
    public function cards()
    {
        $banks = Code::cards();

        $this->assertEquals('/cards', $banks->path());
        $this->assertEquals('GET', $banks->verb());
        $this->assertEmpty($banks->attributes());

        $response = $this->iamport->callApi($banks);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
        $this->assertTrue($response->isSuccess());
        $this->assertNull($response->getError());
        $this->assertInstanceOf('Iamport\RestClient\Response\Collection', $response->getData());
        $this->assertInstanceOf('Iamport\RestClient\Response\StandardCode', $response->getData()->getItems()[0]);
    }

    /** @test */
    public function card()
    {
        $cardCode = '361';

        $card = Code::card($cardCode);

        $this->assertEquals('/cards/' . $cardCode, $card->path());
        $this->assertEquals('GET', $card->verb());
        $this->assertEmpty($card->attributes());

        $response = $this->iamport->callApi($card);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
        $this->assertTrue($response->isSuccess());
        $this->assertNull($response->getError());
        $this->assertInstanceOf('Iamport\RestClient\Response\StandardCode', $response->getData());
    }
}
