<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Enum\VbankCode;
use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Vbank;

$iamport = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');
$request = Vbank::store('mid_1567151116054', 1000, VbankCode::SC, '2019-10-10 00:00:00', '홍길동');
$result  = $iamport->callApi($request);

if ($result->isSuccess()) {
    $escrowLogis = $result->getData();
// TODO: 가상계좌 생성 이후 처리
} else {
    $error = $result->getError();
    echo "아임포트 API 에러코드 : $error->code";
    echo "아임포트 API 에러메시지 : $error->message";
    // previous에는 에러 추적을 위해 아임포트 API 서버에서 응답하는 에러정보가 아닌 원본 Exception 객체가 담겨있습니다.
    dump($error->previous);
}
