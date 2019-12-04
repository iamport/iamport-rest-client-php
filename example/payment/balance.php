<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Payment;

$iamport = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');
$request = Payment::balance('imp_151056657689');
$result  = $iamport->callApi($request);

if ($result->isSuccess()) {
    $payment = $result->getData();
    // 최초 결제승인된 금액의 총합
    $amount = $payment->amount;
    // 현금영수증 발급된 금액 상세
    $cash_receipt = $payment->cash_receipt;
    // 1차 결제수단(신용카드, 계좌이체, 가상계좌, 휴대폰소액결제) 금액 상세
    $primary = $payment->primary;
    // 2차 결제수단(구매자가 보유한 PG사포인트, 카드사포인트) 금액 상세
    $secondary = $payment->secondary;
    // PG사/카드사 자체 할인 금액 상세
    $discount = $payment->discount;
    // PaymentBalance 이력
    $histories = $payment->histories;

    foreach ($histories as $history) {
        // TODO: $history->{property} 로 데이터 접근
    }
} else {
    $error = $result->getError();
    dump('아임포트 API 에러코드 : ', $error->code);
    dump('아임포트 API 에러메시지 : ', $error->message);
    // previous에는 에러 추적을 위해 아임포트 API 서버에서 응답하는 에러정보가 아닌 원본 Exception 객체가 담겨있습니다.
    dump($error->previous);
}
