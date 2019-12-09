<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Subscribe\SubscribeCustomer;

$iamport       = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');
// from, to는 unix timestamp 와 DateTime 클래스(권장), string 형태의 date 모두 가능합니다.
$request       = SubscribeCustomer::schedules('cuid_1_1566960465326', new DateTime('2019-12-25'), 1577664000);
$request->page = 1;
$result        = $iamport->callApi($request);

if ($result->isSuccess()) {
    $data     = $result->getData();
    $nextData = $data->next($iamport);
    dump($data);
    foreach ($data->getItems() as $payment) {
        // TODO: 결제데이터 조회
    }
} else {
    dump($result->getError());
}
