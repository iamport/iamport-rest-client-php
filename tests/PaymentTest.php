<?php

use Iamport\RestClient\Enum\Naver\CancelPaymentRequester;
use Iamport\RestClient\Request\CancelPayment;
use Iamport\RestClient\Request\CancelPaymentExtra;
use Iamport\RestClient\Request\Payment;
use Iamport\RestClient\Test\IamportTestTrait;
use PHPUnit\Framework\TestCase;

class PaymentTest extends TestCase
{
    use IamportTestTrait;

    /** @test */
    public function payment_with_imp_uid()
    {
        $payment     = Payment::withImpUid(self::$impUid);

        $this->assertEquals('/payments/' . self::$impUid, $payment->path());
        $this->assertEquals('GET', $payment->verb());
        $this->assertEmpty($payment->attributes());

        $response    = $this->iamport->callApi($payment);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
        $this->assertTrue($response->isSuccess());
        $this->assertNull($response->getError());
        $this->assertInstanceOf('Iamport\RestClient\Response\Payment', $response->getData());
    }

    /** @test */
    public function payment_with_merchant_uid()
    {
        $payment                 = Payment::withMerchantUid(self::$merchantUid);
        $payment->payment_status = '';
        $payment->sorting        = '-started';

        $this->assertEquals('/payments/find/' . self::$merchantUid, $payment->path());
        $this->assertEquals('GET', $payment->verb());
        $this->assertArrayHasKey('query', $payment->attributes());

        $response  = $this->iamport->callApi($payment);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
        $this->assertTrue($response->isSuccess());
        $this->assertNull($response->getError());
        $this->assertInstanceOf('Iamport\RestClient\Response\Payment', $response->getData());
    }

    /** @test */
    public function payments_list_merchant_uid()
    {
        $payments                 = Payment::listMerchantUid(self::$merchantUid);
        $payments->payment_status = '';
        $payments->page           = 1;
        $payments->sorting        = '-started';

        $this->assertEquals('/payments/findAll/' . self::$merchantUid, $payments->path());
        $this->assertEquals('GET', $payments->verb());
        $this->assertArrayHasKey('sorting', $payments->attributes()['query']);
        $this->assertArrayHasKey('page', $payments->attributes()['query']);

        $response = $this->iamport->callApi($payments);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
        $this->assertTrue($response->isSuccess());
        $this->assertNull($response->getError());
        $this->assertInstanceOf('Iamport\RestClient\Response\Collection', $response->getData());
        $this->assertIsInt($response->getData()->getTotal());
        $this->assertIsInt($response->getData()->getPrevious());
        $this->assertIsInt($response->getData()->getNext());
        $this->assertInstanceOf('Iamport\RestClient\Response\Payment', $response->getData()->getItems()[0]);
    }

    /** @test */
    public function payment_cancel_by_imp_uid()
    {
        $cancelPayment                 = CancelPayment::withImpUid(self::$impUid);
        $cancelPayment->amount         = 1000;
        $cancelPayment->tax_free       = 0;
        $cancelPayment->checksum       = 0;
        $cancelPayment->reason         = '취소테스트';
        $cancelPayment->refund_holder  = '환불될 가상계좌 예금주';
        $cancelPayment->refund_bank    = '환불될 가상계좌 은행코드';
        $cancelPayment->refund_account = '환불될 가상계좌 번호';
        $cancelPayment->refund_tel     = "01012341234";
        $extra                         = new CancelPaymentExtra();
        $extra->requester              = CancelPaymentRequester::ADMIN;
        $cancelPayment->setExtra($extra);

        $this->assertSame($cancelPayment->imp_uid, self::$impUid);
        $this->assertEquals('/payments/cancel/', $cancelPayment->path());
        $this->assertEquals('POST', $cancelPayment->verb());
        $this->assertArrayHasKey('body', $cancelPayment->attributes());

        $response = $this->iamport->callApi($cancelPayment);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function payment_cancel_by_merchant_uid()
    {
        $cancelPayment                 = CancelPayment::withMerchantUid(self::$merchantUid);
        $cancelPayment->amount         = 1000;
        $cancelPayment->tax_free       = 0;
        $cancelPayment->checksum       = 0;
        $cancelPayment->reason         = '취소테스트';
        $cancelPayment->refund_holder  = '환불될 가상계좌 예금주';
        $cancelPayment->refund_bank    = '환불될 가상계좌 은행코드';
        $cancelPayment->refund_account = '환불될 가상계좌 번호';
        $cancelPayment->refund_tel     = "01012341234";
        $extra                         = new CancelPaymentExtra();
        $extra->requester              = CancelPaymentRequester::ADMIN;
        $cancelPayment->setExtra($extra);

        $this->assertSame($cancelPayment->merchant_uid, self::$merchantUid);
        $this->assertEquals('/payments/cancel/', $cancelPayment->path());
        $this->assertEquals('POST', $cancelPayment->verb());
        $this->assertArrayHasKey('body', $cancelPayment->attributes());

        $response = $this->iamport->callApi($cancelPayment);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }
}
