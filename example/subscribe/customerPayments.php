<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Subscribe\SubscribeCustomer;

$iamport = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');
$request = SubscribeCustomer::payments('customer_uid');
$result  = $iamport->callApi($request);

if ($result->isSuccess()) {
    $data = $result->getData();
    dump($data);
    $nextData = $data->next($iamport);
    foreach ($data->getItems() as $payment) {
        dump($payment->imp_uid);
    }
} else {
    dump($result->getError());
}
