<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Payment;

$iamport                 = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');
$request                 = Payment::listMerchantUid('검색할 주문 번호(merchant_uid)');
$request->payment_status = 'paid';
$request->sorting        = '-started';
$request->page           = 1;
$result                  = $iamport->callApi($request);

if ($result->isSuccess()) {
    $data         = $result->getData();
    $total        = $data->getTotal();
    $nextPage     = $data->getNext();
    $previousPage = $data->getPrevious();
    $payments     = $data->getItems();

    foreach ($payments as $payment) {
        $paid_at          = $payment->paid_at;
        $original_paid_at = $payment->getAttributes('paid_at');
    }

    // 이전, 다음 페이지 Collection 데이터를 가져옵니다.
    $previousData = $data->previous($iamport);
    $nextData     = $data->next($iamport);
} else {
    $error = $result->getError();
    dump('아임포트 API 에러코드 : ', $error->code);
    dump('아임포트 API 에러메시지 : ', $error->message);
    // previous에는 에러 추적을 위해 아임포트 API 서버에서 응답하는 에러정보가 아닌 원본 Exception 객체가 담겨있습니다.
    dump($error->previous);
}
