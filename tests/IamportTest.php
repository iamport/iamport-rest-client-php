<?php

use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\CancelPayment;
use Iamport\RestClient\Request\CardInfo;
use Iamport\RestClient\Request\Certification;
use Iamport\RestClient\Request\EscrowLogis;
use Iamport\RestClient\Request\EscrowLogisInvoice;
use Iamport\RestClient\Request\EscrowLogisPerson;
use Iamport\RestClient\Request\Payment;
use Iamport\RestClient\Request\Receipt;
use Iamport\RestClient\Request\Schedule;
use Iamport\RestClient\Request\SubscribeAgain;
use Iamport\RestClient\Request\SubscribeCustomer;
use Iamport\RestClient\Request\SubscribeOnetime;
use Iamport\RestClient\Request\SubscribeSchedule;
use Iamport\RestClient\Request\SubscribeUnschedule;
use PHPUnit\Framework\TestCase;

class IamportTest extends TestCase
{
    const TEST_IMP_KEY = 'imp_apikey';
    const TEST_IMP_SEC = 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f';

    const IMP_UID      = 'imp_448280090638';
    const MERCHANT_UID = 'merchant_1448280088556';
    const CUSTOMER_UID = 'customer_1234';

    private $iamport;

    /**
     * This method is called before each test.
     */
    protected function setUp()
    {
        $this->iamport = new Iamport(self::TEST_IMP_KEY, self::TEST_IMP_SEC);
    }

    protected function tearDown()
    {
        $this->iamport  = null;
    }

    /** @test */
    public function view_certification()
    {
        $certification     = Certification::view(self::IMP_UID);

        $this->assertEquals('/certifications/'.self::IMP_UID, $certification->path());
        $this->assertEquals('GET', $certification->verb());
        $this->assertEmpty($certification->attributes());

        $response    = $this->iamport->callApi($certification);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function delete_certification()
    {
        $certification     = Certification::delete(self::IMP_UID);

        $this->assertEquals('/certifications/'.self::IMP_UID, $certification->path());
        $this->assertEquals('DELETE', $certification->verb());
        $this->assertEmpty($certification->attributes());

        $response    = $this->iamport->callApi($certification);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function payment_by_imp_uid()
    {
        $payment     = Payment::withImpUid(self::IMP_UID);

        $this->assertEquals('/payments/'.self::IMP_UID, $payment->path());
        $this->assertEquals('GET', $payment->verb());
        $this->assertEmpty($payment->attributes());

        $response    = $this->iamport->callApi($payment);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
        $this->assertTrue($response->success);
        $this->assertNull($response->error);
        $this->assertObjectHasAttribute('customData', $response->data);
        $this->assertInstanceOf('Iamport\RestClient\Response\Item', $response->data);
    }

    /** @test */
    public function payment_by_merchant_uid()
    {
        $payment                 = Payment::withMerchantUid(self::MERCHANT_UID);
        $payment->payment_status = '';
        $payment->sorting        = '-started';

        $this->assertEquals('/payments/find/'.self::MERCHANT_UID, $payment->path());
        $this->assertEquals('GET', $payment->verb());
        $this->assertArrayHasKey('query', $payment->attributes());

        $response                = $this->iamport->callApi($payment);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
        $this->assertTrue($response->success);
        $this->assertNull($response->error);
        $this->assertObjectHasAttribute('customData', $response->data);
        $this->assertInstanceOf('Iamport\RestClient\Response\Item', $response->data);
    }

    /** @test */
    public function payments_by_merchant_uid()
    {
        $payments                 = Payment::listMerchantUid(self::MERCHANT_UID);
        $payments->payment_status = '';
        $payments->page           = 1;
        $payments->sorting        = '-started';

        $this->assertEquals('/payments/findAll/'.self::MERCHANT_UID, $payments->path());
        $this->assertEquals('GET', $payments->verb());
        $this->assertArrayHasKey('sorting', $payments->attributes()['query']);
        $this->assertArrayHasKey('page', $payments->attributes()['query']);

        $response                 = $this->iamport->callApi($payments);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
        $this->assertTrue($response->success);
        $this->assertNull($response->error);
        $this->assertInstanceOf('Iamport\RestClient\Response\Collection', $response->data);
        $this->assertIsInt($response->data->getTotal());
        $this->assertIsInt($response->data->getPrevious());
        $this->assertIsInt($response->data->getNext());
        $this->assertInstanceOf('Iamport\RestClient\Response\Item', $response->data->getPayments()[0]);
    }

    /** @test */
    public function payment_cancel_by_imp_uid()
    {
        $cancelPayment                 = CancelPayment::withImpUid(self::IMP_UID);
        $cancelPayment->amount         = 1000;
        $cancelPayment->tax_free       = 0;
        $cancelPayment->checksum       = 0;
        $cancelPayment->reason         = '취소테스트';
        $cancelPayment->refund_holder  = '환불될 가상계좌 예금주';
        $cancelPayment->refund_bank    = '환불될 가상계좌 은행코드';
        $cancelPayment->refund_account = '환불될 가상계좌 번호';

        $this->assertSame($cancelPayment->imp_uid, self::IMP_UID);
        $this->assertEquals('/payments/cancel/', $cancelPayment->path());
        $this->assertEquals('POST', $cancelPayment->verb());
        $this->assertArrayHasKey('body', $cancelPayment->attributes());

        $response                      = $this->iamport->callApi($cancelPayment);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function payment_cancel_by_merchant_uid()
    {
        $cancelPayment                 = CancelPayment::withMerchantUid(self::MERCHANT_UID);
        $cancelPayment->amount         = 1000;
        $cancelPayment->tax_free       = 0;
        $cancelPayment->checksum       = 0;
        $cancelPayment->reason         = '취소테스트';
        $cancelPayment->refund_holder  = '환불될 가상계좌 예금주';
        $cancelPayment->refund_bank    = '환불될 가상계좌 은행코드';
        $cancelPayment->refund_account = '환불될 가상계좌 번호';

        $this->assertSame($cancelPayment->merchant_uid, self::MERCHANT_UID);
        $this->assertEquals('/payments/cancel/', $cancelPayment->path());
        $this->assertEquals('POST', $cancelPayment->verb());
        $this->assertArrayHasKey('body', $cancelPayment->attributes());

        $response                      = $this->iamport->callApi($cancelPayment);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function view_receipt()
    {
        $receipt  = Receipt::view(self::IMP_UID);

        $this->assertEquals('/receipts/'.self::IMP_UID, $receipt->path());
        $this->assertEquals('GET', $receipt->verb());
        $this->assertEmpty($receipt->attributes());

        $response = $this->iamport->callApi($receipt);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
        $this->assertTrue($response->success);
        $this->assertNull($response->error);
        $this->assertObjectHasAttribute('customData', $response->data);
        $this->assertInstanceOf('Iamport\RestClient\Response\Item', $response->data);
    }

    /** @test */
    public function cancel_receipt()
    {
        $receipt  = Receipt::cancel(self::IMP_UID);

        $this->assertEquals('/receipts/'.self::IMP_UID, $receipt->path());
        $this->assertEquals('DELETE', $receipt->verb());
        $this->assertEmpty($receipt->attributes());

        $response = $this->iamport->callApi($receipt);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function issue_receipt()
    {
        $receipt              = Receipt::issue(self::IMP_UID, '01012341234');
        $receipt->type        = 'person';
        $receipt->buyer_name  = '구매자 이름';
        $receipt->buyer_email = '구매자 이메일';
        $receipt->buyer_tel   = '구매자 전화번호';
        $receipt->tax_free    = 0;

        $this->assertEquals('/receipts/'.self::IMP_UID, $receipt->path());
        $this->assertEquals('POST', $receipt->verb());
        $this->assertArrayHasKey('body', $receipt->attributes());

        $response = $this->iamport->callApi($receipt);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function issue_subscribe_billing_key()
    {
        $cardInfo                             = new CardInfo('1234-1234-1234-1234', '2023-12', '800102', '01');
        $subscribeCustomer                    = SubscribeCustomer::issue(self::CUSTOMER_UID, $cardInfo);
        $subscribeCustomer->customer_name     = '고객(카드소지자) 이름';
        $subscribeCustomer->customer_tel      = '고객(카드소지자) 전화번호';
        $subscribeCustomer->customer_email    = '고객(카드소지자) 이메일';
        $subscribeCustomer->customer_addr     = '고객(카드소지자) 주소';
        $subscribeCustomer->customer_postcode = '고객(카드소지자) 우편번호';

        $this->assertEquals('/subscribe/customers/'.self::CUSTOMER_UID, $subscribeCustomer->path());
        $this->assertEquals('POST', $subscribeCustomer->verb());
        $this->assertArrayHasKey('body', $subscribeCustomer->attributes());

        $response                             = $this->iamport->callApi($subscribeCustomer);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function view_subscribe_billing_key()
    {
        $subscribeCustomer = SubscribeCustomer::view(self::CUSTOMER_UID);

        $this->assertEquals('/subscribe/customers/'.self::CUSTOMER_UID, $subscribeCustomer->path());
        $this->assertEquals('GET', $subscribeCustomer->verb());
        $this->assertEmpty($subscribeCustomer->attributes());

        $response          = $this->iamport->callApi($subscribeCustomer);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function delete_subscribe_billing_key()
    {
        $subscribeCustomer = SubscribeCustomer::delete(self::CUSTOMER_UID);

        $this->assertEquals('/subscribe/customers/'.self::CUSTOMER_UID, $subscribeCustomer->path());
        $this->assertEquals('DELETE', $subscribeCustomer->verb());
        $this->assertEmpty($subscribeCustomer->attributes());

        $response          = $this->iamport->callApi($subscribeCustomer);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function subscribe_onetime()
    {
        $cardInfo                         = new CardInfo('1234-1234-1234-1234', '2023-12', '800102', '01');
        $subscribeOnetime                 = new SubscribeOnetime(self::MERCHANT_UID, 1000, $cardInfo);
        $subscribeOnetime->tax_free       = 0;
        $subscribeOnetime->customer_uid   = 'duplicate-cuid2';
        $subscribeOnetime->pg             = 'pg 사';
        $subscribeOnetime->name           = '주문명';
        $subscribeOnetime->buyer_name     = '주문자명';
        $subscribeOnetime->buyer_email    = '주문자 E-mail주소';
        $subscribeOnetime->buyer_tel      = '주문자 전화번호';
        $subscribeOnetime->buyer_addr     = '주문자 주소';
        $subscribeOnetime->buyer_postcode = '주문자 우편번호';
        $subscribeOnetime->card_quota     = '카드 할부개월 수';
        $subscribeOnetime->custom_data    = '';
        $subscribeOnetime->notice_url     = 'http://notice.example.com';

        $this->assertEquals('/subscribe/payments/onetime/', $subscribeOnetime->path());
        $this->assertEquals('POST', $subscribeOnetime->verb());
        $this->assertArrayHasKey('body', $subscribeOnetime->attributes());

        $response                         = $this->iamport->callApi($subscribeOnetime);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function subscribe_again()
    {
        $subscribeAgain                 = new SubscribeAgain(self::CUSTOMER_UID, self::MERCHANT_UID, 1004, '주문명');
        $subscribeAgain->tax_free       = 100;
        $subscribeAgain->buyer_name     = '주문자명';
        $subscribeAgain->buyer_email    = '주문자 E-mail주소';
        $subscribeAgain->buyer_tel      = '주문자 전화번호';
        $subscribeAgain->buyer_addr     = '주문자 주소';
        $subscribeAgain->buyer_postcode = '주문자 우편번호';
        $subscribeAgain->card_quota     = '카드 할부개월 수';
        $subscribeAgain->custom_data    = '';
        $subscribeAgain->notice_url     = '';

        $this->assertEquals('/subscribe/payments/again/', $subscribeAgain->path());
        $this->assertEquals('POST', $subscribeAgain->verb());
        $this->assertArrayHasKey('body', $subscribeAgain->attributes());

        $response                       = $this->iamport->callApi($subscribeAgain);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function subscribe_schedule()
    {
        $subscribeSchedule                  = new SubscribeSchedule(self::CUSTOMER_UID);
        $subscribeSchedule->checking_amount = 0;
        $subscribeSchedule->pg              = '';

        $cardInfo  = new CardInfo('1234-1234-1234-1234', '2020-01', '000000', '00');
        $subscribeSchedule->setCardInfo($cardInfo);

        $schedule1                 = new Schedule('order1_'.time(), time() + 100, 1100);
        $schedule2                 = new Schedule('order2_'.time(), time() + 100, 1200);
        $schedule1->tax_free       = 0;
        $schedule1->name           = '예약결제 1';
        $schedule1->buyer_name     = '예약자A';
        $schedule1->buyer_email    = 'buyer@iamport.kr';
        $schedule1->buyer_tel      = '01012341234';
        $schedule1->buyer_addr     = '서울 강남구 신사동';
        $schedule1->buyer_postcode = '123456';
        $schedule1->notice_url     = '';
        $subscribeSchedule->addSchedules($schedule1);
        $subscribeSchedule->addSchedules($schedule2);

        $this->assertEquals('/subscribe/payments/schedule/', $subscribeSchedule->path());
        $this->assertEquals('POST', $subscribeSchedule->verb());
        $this->assertArrayHasKey('body', $subscribeSchedule->attributes());

        $response   = $this->iamport->callApi($subscribeSchedule);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function subscribe_unschedule()
    {
        $subscribeUnschedule               = new SubscribeUnschedule(self::CUSTOMER_UID);
        $subscribeUnschedule->merchant_uid = ['order_1568016126'];

        $this->assertEquals('/subscribe/payments/unschedule/', $subscribeUnschedule->path());
        $this->assertEquals('POST', $subscribeUnschedule->verb());
        $this->assertArrayHasKey('body', $subscribeUnschedule->attributes());

        $response                          = $this->iamport->callApi($subscribeUnschedule);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function register_escrow()
    {
        $sender   = new EscrowLogisPerson('홍길동', '010-1234-5678', '서울시 강남구 삼성동', '15411');
        $receiver = new EscrowLogisPerson('김길동', '010-1234-5678', '서울시 마포구 연희동', '16211');
        $invoice  = new EscrowLogisInvoice('시옷', '123456', '1568785782');

        $escrow               = EscrowLogis::register(self::IMP_UID, $sender, $receiver, $invoice);

        $this->assertEquals('/escrows/logis/'.self::IMP_UID, $escrow->path());
        $this->assertEquals('POST', $escrow->verb());
        $this->assertArrayHasKey('body', $escrow->attributes());

        $response                          = $this->iamport->callApi($escrow);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function update_escrow()
    {
        $sender   = new EscrowLogisPerson('홍길동', '010-1234-5678', '서울시 강남구 삼성동', '15411');
        $receiver = new EscrowLogisPerson('김길동', '010-1234-5678', '서울시 마포구 연희동', '16211');
        $invoice  = new EscrowLogisInvoice('시옷', '123456', '1568785782');

        $escrow               = EscrowLogis::update(self::IMP_UID, $sender, $receiver, $invoice);

        $this->assertEquals('/escrows/logis/'.self::IMP_UID, $escrow->path());
        $this->assertEquals('PUT', $escrow->verb());
        $this->assertArrayHasKey('body', $escrow->attributes());

        $response                          = $this->iamport->callApi($escrow);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }
}
