<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Enum\BankCode;
use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Vbank;

$iamport = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');
$request = Vbank::view(BankCode::SC, '35016182520575');
$result  = $iamport->callApi($request);

if ($result->isSuccess()) {
    $escrowLogis = $result->getData();
    $bank_holder = $escrowLogis->bank_holder;
} else {
    $error = $result->getError();
    echo "아임포트 API 에러코드 : $error->code";
    echo "아임포트 API 에러메시지 : $error->message";
    // previous에는 에러 추적을 위해 아임포트 API 서버에서 응답하는 에러정보가 아닌 원본 Exception 객체가 담겨있습니다.
    dump($error->previous);
}
