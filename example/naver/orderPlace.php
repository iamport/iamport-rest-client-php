<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Naver\NaverOrder;

$iamport                   = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');
$request                   = NaverOrder::place('imp_589568085643');
$request->product_order_id = ['2019083013231750'];
$result                    = $iamport->callApi($request);

if ($result->isSuccess()) {
    $data          = $result->getData();
    $productOrders = $data->getItems();
    foreach ($productOrders as $productOrder) {
        // TODO: 발주처리 성공건 데이터 조회 및 로직 수행
    }
    // 상품주 발주처리 실패건의 product_order_id
    $failed = $data->getFailed();
} else {
    dump($result->getError());
}
