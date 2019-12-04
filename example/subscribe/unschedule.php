<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Subscribe\SubscribeUnschedule;

$iamport = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');

// 클라이언트로부터 전달받은 카드 정보와 구매자 고유번호
$customerUid  = filter_input(INPUT_POST, 'customer_uid', FILTER_SANITIZE_STRING);

// 비인증 결제요청예약 취소.
$request = new SubscribeUnschedule($customerUid);

// 파라메터 목록 참조 :  https://api.iamport.kr/#!/subscribe/unschedule
$request->merchant_uid = ['order_book_1568016126'];
$result                = $iamport->callApi($request);

if ($result->isSuccess()) {
    /**
     *	Response\Schedule 를 가리킵니다. __get을 통해 API의 Item Model의 값들을 모두 property처럼 접근할 수 있습니다.
     *	참고 : https://api.iamport.kr/#!/subscribe/unschedule 의 Response Class Model.
     */
    $schedules = $result->getData();
    dump($schedules);
} else {
    $error = $result->getError();
    dump("아임포트 API 에러코드 : $error->code");
    dump("아임포트 API 에러메시지 : $error->message");
    // previous에는 에러 추적을 위해 아임포트 API 서버에서 응답하는 에러정보가 아닌 원본 Exception 객체가 담겨있습니다.
    dump('원본 Exception :', $error->previous);
}
