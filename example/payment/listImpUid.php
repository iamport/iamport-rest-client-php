<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Payment;

$iamport = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');
$request = Payment::listImpUid(['imps_313576348178']);
$result  = $iamport->callApi($request);

if ($result->isSuccess()) {
    $payments = $result->getData()->getItems();
    foreach ($payments as $payment) {
        $paid_at          = $payment->paid_at;
        $original_paid_at = $payment->getAttributes('paid_at');
    }
    //조회에 실패한 결제내역이 존재할 경우 getfailed()를 통해 실패한 건의 imp_uid를 얻을 수 있습니다.
    $failed = $result->getData()->getFailed();
} else {
    $error = $result->getError();
    dump('아임포트 API 에러코드 : ', $error->code);
    dump('아임포트 API 에러메시지 : ', $error->message);
    // previous에는 에러 추적을 위해 아임포트 API 서버에서 응답하는 에러정보가 아닌 원본 Exception 객체가 담겨있습니다.
    dump($error->previous);
}
