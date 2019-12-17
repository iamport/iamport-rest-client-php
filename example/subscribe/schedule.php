<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\CardInfo;
use Iamport\RestClient\Request\Subscribe\Schedule;
use Iamport\RestClient\Request\Subscribe\SubscribeSchedule;

$iamport = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');

// 클라이언트로부터 전달받은 카드 정보와 구매자 고유번호
$card_number   = filter_input(INPUT_POST, 'card_number', FILTER_SANITIZE_STRING);
$expiry        = filter_input(INPUT_POST, 'expiry', FILTER_SANITIZE_STRING);
$birth         = filter_input(INPUT_POST, 'birth', FILTER_SANITIZE_STRING);
$pwd_2digit    = filter_input(INPUT_POST, 'pwd_2digit', FILTER_SANITIZE_STRING);
$amount        = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_NUMBER_FLOAT);
// $customer_uid값에 대한 자세한 설명은 아임포트 docs(https://docs.iamport.kr/implementation/subscription)의 customer_uid 속성을 참조합니다.
$customerUid  = filter_input(INPUT_POST, 'customer_uid', FILTER_SANITIZE_STRING);

// 저장된 빌링키로 정기 예약 결제.
$request = new SubscribeSchedule($customerUid);

// 파라메터 목록 참조 :  https://api.iamport.kr/#!/subscribe/schedule
$request->checking_amount = 0;
$request->pg              = '';

// 1. 기존에 빌링키가 등록된 customer_uid가 존재하는 경우 해당 customer_uid와 해당되는 빌링키로 schedule정보가 예약됩니다.(카드정보 선택사항)
// 2. 등록된 customer_uid가 없는 경우 빌링키 신규 발급을 먼저 진행한 후 schedule정보를 예약합니다.(카드정보 필수사항)
// 카드정보 셋팅
$cardInfo = new CardInfo($card_number, $expiry, $birth, $pwd_2digit);
$request->setCardInfo($cardInfo);

// 정기 예약 스케쥴 정보 셋팅
// Schedule의 두번째 인자인 schedule_at의 값은 unix timestamp와 DateTime 클래스(권장), 문자열형태의 date 모두 가능합니다.
$schedule                 = new Schedule('order_book_' . time(), new DateTime('2019-12-25'), $amount);
$schedule->tax_free       = 0;
$schedule->name           = '월간 이용권 정기결제 A';
$schedule->buyer_name     = '예약자A';
$schedule->buyer_email    = 'buyer@iamport.kr';
$schedule->buyer_tel      = '01012341234';
$schedule->buyer_addr     = '서울 강남구 신사동';
$schedule->buyer_postcode = '123456';
$schedule->notice_url     = '';
$request->addSchedules($schedule);

$result = $iamport->callApi($request);

if ($result->isSuccess()) {
    /**
     *  Response\Schedule 를 가리킵니다. __get을 통해 API의 Item Model의 값들을 모두 property처럼 접근할 수 있습니다.
     *  참고 : https://api.iamport.kr/#!/subscribe/schedule 의 Response Class Model.
     */
    $schedules = $result->getData();
    dump($schedules);

// TODO: 예약한 시간에 결제가 완료되면 지정하신 콜백 URL로 아임포트가 값을 전달하게 됩니다.
    // 자세한 사항은 아임포트 docs(https://docs.iamport.kr/implementation/subscription#request-payment)의 결제 결과 동기화하기를 참조해주세요.
} else {
    $error = $result->getError();
    dump("아임포트 API 에러코드 : $error->code");
    dump("아임포트 API 에러메시지 : $error->message");
    // previous에는 에러 추적을 위해 아임포트 API 서버에서 응답하는 에러정보가 아닌 원본 Exception 객체가 담겨있습니다.
    dump('원본 Exception :', $error->previous);
}
