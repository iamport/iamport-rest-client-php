<?php

require_once '../vendor/autoload.php';

use GuzzleHttp\HandlerStack;
use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\CancelPayment;
use Iamport\RestClient\Request\CardInfo;
use Iamport\RestClient\Request\Certification;
use Iamport\RestClient\Request\Escrow\EscrowLogis;
use Iamport\RestClient\Request\Escrow\EscrowLogisInvoice;
use Iamport\RestClient\Request\Escrow\EscrowLogisPerson;
use Iamport\RestClient\Request\Payment;
use Iamport\RestClient\Request\Receipt;
use Iamport\RestClient\Request\Subscribe\Schedule;
use Iamport\RestClient\Request\Subscribe\SubscribeAgain;
use Iamport\RestClient\Request\Subscribe\SubscribeCustomer;
use Iamport\RestClient\Request\Subscribe\SubscribeOnetime;
use Iamport\RestClient\Request\Subscribe\SubscribeSchedule;
use Iamport\RestClient\Request\Subscribe\SubscribeUnschedule;

$impKey      = 'imp_apikey';
$impSecret   = 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f';
$impUid      = 'imp_448280090638';
$merchantUid = 'merchant_1448280088556';
$customerUid = 'customer_1234';

$iamport = new Iamport($impKey, $impSecret);

$request          = Payment::listStatus('all');
$request->limit   = 10;
$request->from    = '2018-08-16 09:21:32';
$request->to      = '2018-10-08 14:04:44';
$request->sorting = 'started';

$rs   = $iamport->callApi($request);
$data = $rs->getData();
dump($data);
foreach ($data->getItems() as $payment) {
}

die();

// guzzle client 생성
$stack   = HandlerStack::create();
$client  = $iamport->getCustomHttpClient($stack);

// imp_uid 로 SMS본인인증된 결과를 조회
$certifications    = Certification::view($impUid);
$getCertifications = $iamport->callApi($certifications);

// imp_uid 로 SMS본인인증된 결과를 아임포트에서 삭제
$certifications       = Certification::delete($impUid);
$deleteCertifications = $iamport->callApi($certifications);

// imp_uid 로 주문정보 찾기(아임포트에서 생성된 거래고유번호)
$payment     = Payment::withImpUid($impUid);
$getByImpUid = $iamport->callApi($payment);

// merchant_uid 로 주문정보 찾기(가맹점의 주문번호)
$payment                 = Payment::withMerchantUid($merchantUid);
$payment->payment_status = '';
$payment->sorting        = '-started';
$getByMerchantUid        = $iamport->callApi($payment);

// merchant_uid 로 주문정보 모두 찾기(가맹점의 주문번호)
$payments                 = Payment::listMerchantUid($merchantUid);
$payments->payment_status = '';
$payments->page           = 1;
$payments->sorting        = '-started';
$paymentsMerchantUid      = $iamport->callApi($payments);

// 주문취소 ( imp_uid  or merchant_uid)
$cancelRequest                 = CancelPayment::withImpUid($impUid);
$cancelRequest2                = CancelPayment::withMerchantUid($merchantUid);
$cancelRequest->merchant_uid   = '20170314230610000000';
$cancelRequest->amount         = 10009;
$cancelRequest->tax_free       = 0;
$cancelRequest->checksum       = 0;
$cancelRequest->reason         = '취소테스트';
$cancelRequest->refund_holder  = '환불될 가상계좌 예금주';
$cancelRequest->refund_bank    = '환불될 가상계좌 은행코드';
$cancelRequest->refund_account = '환불될 가상계좌 번호';
$paymentCancel                 = $iamport->callApi($cancelRequest);

// 현금영수증 조회
$receipt     = Receipt::view('imp_020492442816');
$receiptView = $iamport->callApi($receipt);

// 현금영수증 취소
$receipt       = Receipt::cancel($impUid);
$receiptCancel = $iamport->callApi($receipt);

// 현금영수증 발행
$issueReceiptRequest              = Receipt::issue($impUid, '01012341234');
$issueReceiptRequest->type        = 'person';
$issueReceiptRequest->buyer_name  = '구매자 이름';
$issueReceiptRequest->buyer_email = '구매자 이메일';
$issueReceiptRequest->buyer_tel   = '구매자 전화번호';
$issueReceiptRequest->tax_free    = 0;
$issueReceipt                     = $iamport->callApi($issueReceiptRequest);

// 비인증결제 빌링키 등록(수정)
$cardInfo                          = new CardInfo('1234-1234-1234-1234', '2023-12', '880223', '01');
$billingKeyData                    = SubscribeCustomer::issue($customerUid, $cardInfo);
$billingKeyData->customer_name     = '고객(카드소지자) 이름';
$billingKeyData->customer_tel      = '고객(카드소지자) 전화번호';
$billingKeyData->customer_email    = '고객(카드소지자) 이메일';
$billingKeyData->customer_addr     = '고객(카드소지자) 주소';
$billingKeyData->customer_postcode = '고객(카드소지자) 우편번호';
$addBillingKey                     = $iamport->callApi($billingKeyData);

// 비인증결제 빌링키 조회
$billingKeyData   = SubscribeCustomer::view($customerUid);
$getBillingKey    = $iamport->callApi($billingKeyData);

// 비인증결제 빌링키 삭제
$billingKeyData = SubscribeCustomer::delete($customerUid);
$delBillingKey  = $iamport->callApi($billingKeyData);

// 빌링키 발급과 결제 요청을 동시에 처리.
$cardInfo                    = new CardInfo('1234-1234-1234-1234', '2023-12', '880223', '01');
$onetimeData                 = new SubscribeOnetime($merchantUid, 1000, $cardInfo);
$onetimeData->tax_free       = 0;
$onetimeData->customer_uid   = 'duplicate-cuid2';
$onetimeData->pg             = 'pg 사';
$onetimeData->name           = '주문명';
$onetimeData->buyer_name     = '주문자명';
$onetimeData->buyer_email    = '주문자 E-mail주소';
$onetimeData->buyer_tel      = '주문자 전화번호';
$onetimeData->buyer_addr     = '주문자 주소';
$onetimeData->buyer_postcode = '주문자 우편번호';
$onetimeData->card_quota     = '카드 할부개월 수';
$onetimeData->custom_data    = '';
$onetimeData->notice_url     = 'http://notice.example.com';
$subscribeOnetime            = $iamport->callApi($onetimeData);

// 저장된 빌링키로 재결제.
$againData                 = new SubscribeAgain($customerUid, $merchantUid, 1004, '주문명');
$againData->tax_free       = 100;
$againData->buyer_name     = '주문자명';
$againData->buyer_email    = '주문자 E-mail주소';
$againData->buyer_tel      = '주문자 전화번호';
$againData->buyer_addr     = '주문자 주소';
$againData->buyer_postcode = '주문자 우편번호';
$againData->card_quota     = '카드 할부개월 수';
$againData->custom_data    = '';
$againData->notice_url     = '';
$subscribeAgain            = $iamport->callApi($againData);

// 저장된 빌링키로 정기 예약 결제.
// 정기 예약 결제 객체 생성 ( required )
$scheduleData = new SubscribeSchedule($customerUid);

// 정기 예약 결제 정보 셋팅 ( optional )
$scheduleData->checking_amount = 0;
$scheduleData->pg              = '';

// 정기 예약 결제 정보 셋팅 - 카드정보
// 1. 객체형태로 삽입 ( optional )
$cardInfo = new CardInfo('1234-1234-1234-1234', '2020-01', '000000', '00');
$scheduleData->setCardInfo($cardInfo);

// 정기 예약 결제 정보 셋팅 - 카드정보
// 2. 직접삽입 ( optional )
$scheduleData->card_number = '1234-1234-1234-1234';
$scheduleData->expiry      = '2020-01';
$scheduleData->birth       = '000000';
$scheduleData->pwd_2digit  = '00';

// 정기 예약 결제 정보 셋팅 - schedule
// schedule 객체 생성 ( required )
$schedule1 = new Schedule('1order_' . time(), time() + 100, 1100);
$schedule2 = new Schedule('2order_' . time(), time() + 100, 1200);

// 정기 예약 결제 정보 셋팅 - schedule
// schedule 정보 셋팅 ( optional )
$schedule1->tax_free       = 0;
$schedule1->name           = '예약결제 1';
$schedule1->buyer_name     = '예약자A';
$schedule1->buyer_email    = 'buyer@iamport.kr';
$schedule1->buyer_tel      = '01012341234';
$schedule1->buyer_addr     = '서울 강남구 신사동';
$schedule1->buyer_postcode = '123456';
$schedule1->notice_url     = '';

// 정기예약할 schedule 추가
$scheduleData->addSchedules($schedule1);
$scheduleData->addSchedules($schedule2);
$subscribeSchedule   = $iamport->callApi($scheduleData);

// 비인증 결제요청예약 취소
$unscheduleData               = new SubscribeUnschedule($customerUid);
$unscheduleData->merchant_uid = ['1order_1568016126'];
$subscribeUnschedule          = $iamport->callApi($unscheduleData);

// 에스크로 결제건에 대한 배송정보 등록/수정
$sender   = new EscrowLogisPerson('홍길동', '010-1234-5678', '서울시 강남구 삼성동', '15411');
$receiver = new EscrowLogisPerson('김길동', '010-1234-5678', '서울시 마포구 연희동', '16211');
$invoice  = new EscrowLogisInvoice('시옷', '123456', '1568785782');

$escrow         = EscrowLogis::register($impUid, $sender, $receiver, $invoice);
$registerEscrow = $iamport->callApi($escrow);

$escrow       = EscrowLogis::update($impUid, $sender, $receiver, $invoice);
$updateEscrow = $iamport->callApi($escrow);
