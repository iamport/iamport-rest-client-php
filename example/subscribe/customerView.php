<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Subscribe\SubscribeCustomer;

$iamport = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');

// 비인증결제 빌링키 조회
$request = SubscribeCustomer::view('cuid_1_1566960465326');
$result  = $iamport->callApi($request);

if ($result->isSuccess()) {
    /**
     *	Response\SubscribeCustomer 를 가리킵니다. __get을 통해 API의 Item Model의 값들을 모두 property처럼 접근할 수 있습니다.
     *	참고 : https://api.iamport.kr/#!/subscribe.customer/customer_view 의 Response Class Model.
     */
    $customer = $result->getData();
    dump($customer);
    echo "빌키가 등록된 시각 (변환된 값) : $customer->inserted <br>";
    echo '빌키가 등록된 시각 (원본) : ' . $customer->getAttributes('inserted');
} else {
    $error = $result->getError();
    dump("아임포트 API 에러코드 : $error->code");
    dump("아임포트 API 에러메시지 : $error->message");
    // previous에는 에러 추적을 위해 아임포트 API 서버에서 응답하는 에러정보가 아닌 원본 Exception 객체가 담겨있습니다.
    dump('원본 Exception :', $error->previous);
}
