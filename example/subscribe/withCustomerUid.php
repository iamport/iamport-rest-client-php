<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Subscribe\SubscribeInquiry;

$iamport = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');
$request = SubscribeInquiry::withCustomerUid('cuid_1_1566960465326', '2019-10-10 09:00:00', '2019-10-10 10:00:00');
$result = $iamport->callApi($request);

if ($result->getSuccess()) {
    $schedules = $result->getData();
} else {
    dump($result->getError());
}