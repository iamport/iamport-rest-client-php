<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Enum\Naver\RejectHoldReason;
use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Naver\NaverReturn;

$iamport                   = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');
$request                   = NaverReturn::withhold('imp_589568085643', '기타 사유로 인해 반품을 보류합니다');
$request->product_order_id = ['2019083013231750'];
$request->reason           = RejectHoldReason::ETC;
$request->extra_charge     = 0;

// $request가 올바른 값으로 셋팅 되어있는지 체크합니다.
if ($request->valid()) {
    $result = $iamport->callApi($request);

    if ($result->isSuccess()) {
        $data          = $result->getData();
        $productOrders = $data->getItems();
        foreach ($productOrders as $productOrder) {
            // TODO: 반품보류 처리 성공건 데이터 조회 및 로직 수행
        }
        //  반품보류 실패건의 product_order_id
        $failed = $data->getFailed();
    } else {
        dump($result->getError());
    }
}
