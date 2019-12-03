<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Subscribe\SubscribeInquiry;

$iamport = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');
// from, to는 unix timestamp 와 string 형태의 date 모두 가능합니다.
$request = SubscribeInquiry::withCustomerUid('cuid_1_1566960465326', '2019-12-20 08:00:00', 1576803600);
$result = $iamport->callApi($request);

if ($result->hasData()) {
    $schedules = $result->getData();
    dump($schedules);
} else {
    dump($result->getError());
}