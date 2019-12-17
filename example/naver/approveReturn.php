<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Naver\NaverReturn;

$iamport                   = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');
$request                   = NaverReturn::approve('imp_589568085643');
$request->product_order_id = ['2019083013231750'];
$request->memo             = '기타 사유로 인해 반품을 승인합니다.';
$request->extra_charge     = 0;
$result                    = $iamport->callApi($request);

if ($result->isSuccess()) {
    $data          = $result->getData();
    $productOrders = $data->getItems();
    foreach ($productOrders as $productOrder) {
        // TODO: 반품승인처리 성공건 데이터 조회 및 로직 수행
    }
    // 반품승인 실패건의 product_order_id
    $failed = $data->getFailed();
} else {
    dump($result->getError());
}
