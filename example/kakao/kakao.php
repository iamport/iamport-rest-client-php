<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Kakaopay;

$iamport = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');
$request = new Kakaopay('20190902');
$result  = $iamport->callApi($request);

if ($result->isSuccess()) {
    $data               = $result->getData();
    $page               = $data->page;
    $paymentRequestDate = $data->payment_request_date;
    $cid                = $data->cid;
    foreach ($data->orders as $order) {
        // TODO kakaopay 주문데이터 조회
        $itemName = $order->item_name;
    }
} else {
    dump($result->getError());
}
