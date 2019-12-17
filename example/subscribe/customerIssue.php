<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\CardInfo;
use Iamport\RestClient\Request\Subscribe\SubscribeCustomer;

$iamport = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');

// 클라이언트로부터 전달받은 카드 정보와 구매자 고유번호
$card_number   = filter_input(INPUT_POST, 'card_number', FILTER_SANITIZE_STRING);
$expiry        = filter_input(INPUT_POST, 'expiry', FILTER_SANITIZE_STRING);
$birth         = filter_input(INPUT_POST, 'birth', FILTER_SANITIZE_STRING);
$pwd_2digit    = filter_input(INPUT_POST, 'pwd_2digit', FILTER_SANITIZE_STRING);
// $customer_uid값에 대한 자세한 설명은 아임포트 docs(https://docs.iamport.kr/implementation/subscription)의 customer_uid 속성을 참조합니다.
$customer_uid  = filter_input(INPUT_POST, 'customer_uid', FILTER_SANITIZE_STRING);

// 비인증결제 빌링키 발급(수정)

// 카드정보 객체 생성
$cardInfo = new CardInfo($card_number, $expiry, $birth, $pwd_2digit);

$request                    = SubscribeCustomer::issue($customer_uid, $cardInfo);
// 파라메터 목록 참조 :  https://api.iamport.kr/#!/subscribe.customer/customer_save
$request->customer_name     = '고객(카드소지자) 이름';
$request->customer_tel      = '고객(카드소지자) 전화번호';
$request->customer_email    = '고객(카드소지자) 이메일';
$request->customer_addr     = '고객(카드소지자) 주소';
$request->customer_postcode = '고객(카드소지자) 우편번호';
$result                     = $iamport->callApi($request);

if ($result->isSuccess()) {
    /**
     *	Response\SubscribeCustomer 를 가리킵니다. __get을 통해 API의 Item Model의 값들을 모두 property처럼 접근할 수 있습니다.
     *	참고 : https://api.iamport.kr/#!/subscribe.customer/customer_save 의 Response Class Model.
     */
    $customer = $result->getData();
    dump($customer);

// TODO: 각 가맹점 환경에 맞게 빌링키 발급(수정) 성공 이후의 로직을 작성합니다.
} else {
    $error = $result->getError();
    dump("아임포트 API 에러코드 : $error->code");
    dump("아임포트 API 에러메시지 : $error->message");
    // previous에는 에러 추적을 위해 아임포트 API 서버에서 응답하는 에러정보가 아닌 원본 Exception 객체가 담겨있습니다.
    dump('원본 Exception :', $error->previous);
}
