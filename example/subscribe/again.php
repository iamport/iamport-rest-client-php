<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Subscribe\SubscribeAgain;

$iamport = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');

// 클라이언트로부터 전달받은 카드 정보와 구매자 고유번호
$customerUid = filter_input(INPUT_POST, 'customer_uid', FILTER_SANITIZE_STRING);
$amount      = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_NUMBER_FLOAT);

// 새로 생성한 결제(재결제)용 주문 번호
$merchantUid = 'order_monthly_0001';
$request     = new SubscribeAgain($customerUid, $merchantUid, $amount, '주문명');
// 파라메터 목록 참조 :  https://api.iamport.kr/#!/subscribe/again
$request->tax_free       = 100;
$request->buyer_name     = '주문자명';
$request->buyer_email    = '주문자 E-mail주소';
$request->buyer_tel      = '주문자 전화번호';
$request->buyer_addr     = '주문자 주소';
$request->buyer_postcode = '주문자 우편번호';
$request->card_quota     = 6; //카드 할부개월 수
$request->custom_data    = '';
$request->notice_url     = '';
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
