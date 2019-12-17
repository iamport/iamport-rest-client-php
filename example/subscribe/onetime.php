<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\CardInfo;
use Iamport\RestClient\Request\Subscribe\SubscribeOnetime;

$iamport = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');

// 클라이언트로부터 전달받은 카드 정보와 결제요청 금액
$card_number = filter_input(INPUT_POST, 'card_number', FILTER_SANITIZE_STRING);
$expiry      = filter_input(INPUT_POST, 'expiry', FILTER_SANITIZE_STRING);
$birth       = filter_input(INPUT_POST, 'birth', FILTER_SANITIZE_STRING);
$pwd_2digit  = filter_input(INPUT_POST, 'pwd_2digit', FILTER_SANITIZE_STRING);
$amount      = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_NUMBER_FLOAT);

// 새로 생성한 주문번호
$merchantUid = 'order_monthly_0001';
// 카드정보 객체 생성
$cardInfo = new CardInfo($card_number, $expiry, $birth, $pwd_2digit);
$request  = new SubscribeOnetime($merchantUid, $amount, $cardInfo);

// 파라메터 목록 참조 :  https://api.iamport.kr/#!/subscribe/onetime
$request->tax_free       = 0;
$request->customer_uid   = 'customer-uid'; // customer_uid 값을 전달시 다음 번 결제를 위해 성공된 결제에 사용된 빌링키를 저장합니다.
$request->pg             = 'pg 사';
$request->name           = '주문명';
$request->buyer_name     = '주문자명';
$request->buyer_email    = '주문자 E-mail주소';
$request->buyer_tel      = '주문자 전화번호';
$request->buyer_addr     = '주문자 주소';
$request->buyer_postcode = '주문자 우편번호';
$request->card_quota     = 6; //카드 할부개월 수
$request->custom_data    = '';
$request->notice_url     = 'http://notice.example.com';
$result                  = $iamport->callApi($request);

if ($result->isSuccess()) {
    /*
     *  Response\Payment 를 가리킵니다. __get을 통해 API의 Item Model의 값들을 모두 property처럼 접근할 수 있습니다.
     *  참고 : https://api.iamport.kr/#!/subscribe/again 의 Response Class Model.
     */
    // TODO: 각 가맹점 환경에 맞게 결제 성공 이후의 로직을 작성합니다.
    dump($result->getData());
} else {
    // error가 있는지 먼저 확인합니다.
    $error = $result->getError();
    if ($error !== null) {
        dump("아임포트 API 에러코드 : $error->code");
        dump("아임포트 API 에러메시지 : $error->message");
        // previous에는 에러 추적을 위해 아임포트 API 서버에서 응답하는 에러정보가 아닌 원본 Exception 객체가 담겨있습니다.
        dump('원본 Exception :', $error->previous);
    } else {
        // api 요청은 성공적으로 이루어졌지만 실패했을경우 실패사유를 체크합니다.
        dump('결제실패 사유 : ' . $result->getData()->fail_reason);
    }
}
