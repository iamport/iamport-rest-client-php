<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Subscribe\SubscribeInquiry;

$iamport = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');
$request = SubscribeInquiry::withMerchantUid('merchant_1448280088556');
$result  = $iamport->callApi($request);

if ($result->isSuccess()) {
    $schedules = $result->getData();
    dump($schedules);
} else {
    dump($result->getError());
}
