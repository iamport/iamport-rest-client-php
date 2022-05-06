<?php

namespace Iamport\RestClient\Test;

use DateTime;
use Iamport\RestClient\Request\CardInfo;
use Iamport\RestClient\Request\Subscribe\Schedule;
use Iamport\RestClient\Request\Subscribe\SubscribeAgain;
use Iamport\RestClient\Request\Subscribe\SubscribeCustomer;
use Iamport\RestClient\Request\Subscribe\SubscribeCustomerExtra;
use Iamport\RestClient\Request\Subscribe\SubscribeInquiry;
use Iamport\RestClient\Request\Subscribe\SubscribeOnetime;
use Iamport\RestClient\Request\Subscribe\SubscribeSchedule;
use Iamport\RestClient\Request\Subscribe\SubscribeUnschedule;
use PHPUnit\Framework\TestCase;

class SubscribeTest extends TestCase
{
    use IamportTestTrait;

    /** @test */
    public function issue_subscribe_customer()
    {
        $cardInfo                             = new CardInfo('1234-1234-1234-1234', '2023-12', '800102', '01');
        $subscribeCustomer                    = SubscribeCustomer::issue(self::$customerUid, $cardInfo);
        $subscribeCustomer->customer_name     = '고객(카드소지자) 이름';
        $subscribeCustomer->customer_tel      = '고객(카드소지자) 전화번호';
        $subscribeCustomer->customer_email    = '고객(카드소지자) 이메일';
        $subscribeCustomer->customer_addr     = '고객(카드소지자) 주소';
        $subscribeCustomer->customer_postcode = '고객(카드소지자) 우편번호';

        $this->assertEquals('/subscribe/customers/' . self::$customerUid, $subscribeCustomer->path());
        $this->assertEquals('POST', $subscribeCustomer->verb());
        $this->assertArrayHasKey('body', $subscribeCustomer->attributes());

        $response = $this->iamport->callApi($subscribeCustomer);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function view_subscribe_customer()
    {
        $subscribeCustomer = SubscribeCustomer::view(self::$customerUid);

        $this->assertEquals('/subscribe/customers/' . self::$customerUid, $subscribeCustomer->path());
        $this->assertEquals('GET', $subscribeCustomer->verb());
        $this->assertEmpty($subscribeCustomer->attributes());

        $response = $this->iamport->callApi($subscribeCustomer);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function list_subscribe_customer()
    {
        $subscribeCustomer = SubscribeCustomer::list([
            self::$customerUid,
        ]);

        $this->assertEquals('/subscribe/customers', $subscribeCustomer->path());
        $this->assertEquals('GET', $subscribeCustomer->verb());
        $this->assertArrayHasKey('query', $subscribeCustomer->attributes());

        $response = $this->iamport->callApi($subscribeCustomer);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function delete_subscribe_customer()
    {
        $subscribeCustomer = SubscribeCustomer::delete(self::$customerUid);

        $this->assertEquals('/subscribe/customers/' . self::$customerUid, $subscribeCustomer->path());
        $this->assertEquals('DELETE', $subscribeCustomer->verb());
        $this->assertArrayHasKey('query', $subscribeCustomer->attributes());

        $response = $this->iamport->callApi($subscribeCustomer);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function delete_subscribe_customer_with_optional_parameters()
    {
        $extra = new SubscribeCustomerExtra();
        $extra->requester = '삭제 요청자';
        $subscribeCustomer = SubscribeCustomer::delete(self::$customerUid, '삭제 사유', $extra);

        $this->assertEquals('/subscribe/customers/' . self::$customerUid, $subscribeCustomer->path());
        $this->assertEquals('DELETE', $subscribeCustomer->verb());
        $this->assertArrayHasKey('query', $subscribeCustomer->attributes());

        $response = $this->iamport->callApi($subscribeCustomer);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function subscribe_customer_by_payments()
    {
        $subscribeCustomer = SubscribeCustomer::payments(self::$customerUid);

        $this->assertEquals('/subscribe/customers/' . self::$customerUid . '/payments', $subscribeCustomer->path());
        $this->assertEquals('GET', $subscribeCustomer->verb());
        $this->assertArrayHasKey('query', $subscribeCustomer->attributes());

        $response = $this->iamport->callApi($subscribeCustomer);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function subscribe_customer_by_schedules()
    {
        $subscribeCustomer       = SubscribeCustomer::schedules(self::$customerUid, new DateTime('2019-12-25'), new DateTime('2019-12-30'));
        $subscribeCustomer->page = 1;

        $this->assertEquals('/subscribe/customers/' . self::$customerUid . '/schedules', $subscribeCustomer->path());
        $this->assertEquals('GET', $subscribeCustomer->verb());
        $this->assertArrayHasKey('query', $subscribeCustomer->attributes());

        $response = $this->iamport->callApi($subscribeCustomer);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function subscribe_onetime()
    {
        $cardInfo                         = new CardInfo('1234-1234-1234-1234', '2023-12', '800102', '01');
        $subscribeOnetime                 = new SubscribeOnetime(self::$merchantUid, 1000, $cardInfo);
        $subscribeOnetime->tax_free       = 0;
        $subscribeOnetime->customer_uid   = 'duplicate-cuid2';
        $subscribeOnetime->pg             = 'pg 사';
        $subscribeOnetime->name           = '주문명';
        $subscribeOnetime->buyer_name     = '주문자명';
        $subscribeOnetime->buyer_email    = '주문자 E-mail주소';
        $subscribeOnetime->buyer_tel      = '주문자 전화번호';
        $subscribeOnetime->buyer_addr     = '주문자 주소';
        $subscribeOnetime->buyer_postcode = '주문자 우편번호';
        $subscribeOnetime->card_quota     = 6;
        $subscribeOnetime->custom_data    = '';
        $subscribeOnetime->notice_url     = 'http://notice.example.com';

        $this->assertEquals('/subscribe/payments/onetime/', $subscribeOnetime->path());
        $this->assertEquals('POST', $subscribeOnetime->verb());
        $this->assertArrayHasKey('body', $subscribeOnetime->attributes());

        $response = $this->iamport->callApi($subscribeOnetime);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function subscribe_again()
    {
        $subscribeAgain                 = new SubscribeAgain(self::$customerUid, self::$merchantUid, 1004, '주문명');
        $subscribeAgain->tax_free       = 100;
        $subscribeAgain->buyer_name     = '주문자명';
        $subscribeAgain->buyer_email    = '주문자 E-mail주소';
        $subscribeAgain->buyer_tel      = '주문자 전화번호';
        $subscribeAgain->buyer_addr     = '주문자 주소';
        $subscribeAgain->buyer_postcode = '주문자 우편번호';
        $subscribeAgain->card_quota     = 3;
        $subscribeAgain->custom_data    = '';
        $subscribeAgain->notice_url     = '';

        $this->assertEquals('/subscribe/payments/again/', $subscribeAgain->path());
        $this->assertEquals('POST', $subscribeAgain->verb());
        $this->assertArrayHasKey('body', $subscribeAgain->attributes());

        $response = $this->iamport->callApi($subscribeAgain);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function subscribe_schedule()
    {
        $subscribeSchedule                  = new SubscribeSchedule(self::$customerUid);
        $subscribeSchedule->checking_amount = 0;
        $subscribeSchedule->pg              = '';

        $cardInfo  = new CardInfo('1234-1234-1234-1234', '2020-01', '000000', '00');
        $subscribeSchedule->setCardInfo($cardInfo);

        $schedule1                 = new Schedule('order1_' . time(), time() + 100, 1100);
        $schedule2                 = new Schedule('order2_' . time(), time() + 100, 1200);
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

        $response = $this->iamport->callApi($subscribeSchedule);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function subscribe_unschedule()
    {
        $subscribeUnschedule               = new SubscribeUnschedule(self::$customerUid);
        $subscribeUnschedule->merchant_uid = ['order_1568016126'];

        $this->assertEquals('/subscribe/payments/unschedule/', $subscribeUnschedule->path());
        $this->assertEquals('POST', $subscribeUnschedule->verb());
        $this->assertArrayHasKey('body', $subscribeUnschedule->attributes());

        $response = $this->iamport->callApi($subscribeUnschedule);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function subscribe_schedule_by_merchant_uid()
    {
        $request = SubscribeInquiry::withMerchantUid(self::$merchantUid);

        $this->assertEquals('/subscribe/payments/schedule/' . self::$merchantUid, $request->path());
        $this->assertEquals('GET', $request->verb());
        $this->assertEmpty($request->attributes());

        $response = $this->iamport->callApi($request);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function subscribe_schedule_by_customer_uid()
    {
        $request = SubscribeInquiry::withCustomerUid(self::$customerUid, new DateTime('2019-12-20 08:00:00'), new DateTime('2019-12-29'));

        $this->assertEquals('/subscribe/payments/schedule/customers/' . self::$customerUid, $request->path());
        $this->assertEquals('GET', $request->verb());
        $this->assertArrayHasKey('query', $request->attributes());

        $response = $this->iamport->callApi($request);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }
}
