<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Subscribe\SubscribeCustomer;

$iamport       = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');
$request       = SubscribeCustomer::schedules('cuid_1_1566960465326', '2019-10-01 00:00:00', '2019-10-01 01:00:00');
$request->page = 1;
$result        = $iamport->callApi($request);

if ($result->getSuccess()) {
    $data     = $result->getData();
    $nextData = $data->next($iamport);
    dump($data);
    foreach ($data->getItems() as $payment) {
        // TODO: 결제데이터 조회
    }
} else {
    dump($result->getError());
}
