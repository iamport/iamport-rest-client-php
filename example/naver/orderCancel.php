<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Enum\Naver\CancelReason;
use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Naver\NaverOrder;

$iamport                   = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');
$request                   = NaverOrder::cancel('imp_589568085643');
$request->product_order_id = ['2019083013231750'];
$request->reason           = CancelReason::PRODUCT_UNSATISFIED;
$result                    = $iamport->callApi($request);

if ($result->isSuccess()) {
    $data          = $result->getData();
    $productOrders = $data->getItems();
    foreach ($productOrders as $productOrder) {
        // TODO: 환불성공건 데이터 조회 및 로직 수행
    }
    // 환불 실패건의 product_order_id
    $failed = $data->getFailed();
} else {
    dump($result->getError());
}
