<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Enum\Naver\DeliveryCompany;
use Iamport\RestClient\Enum\Naver\DeliveryMethod;
use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Naver\NaverOrder;

$iamport = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');
// DeliveryMethod, DeliveryCompany Enum 클래스는 getAll() 메소드로 사용가능한 값들을 조회할 수 있습니다.
$request                   = NaverOrder::ship('imp_589568085643', DeliveryMethod::NOTHING, '2019-09-04 00:00:00');
$request->delivery_company = DeliveryCompany::CJGLS;
$request->tracking_number  = '123456789';

// delivery_method에 따른 필수값 유무를 체크 합니다.
if ($request->valid()) {
    $result = $iamport->callApi($request);

    if ($result->isSuccess()) {
        $data          = $result->getData();
        $productOrders = $data->getItems();
        foreach ($productOrders as $productOrder) {
            // TODO: 발송처리 성공건 데이터 조회 및 로직 수행
        }
        // 상품주문 발송처리 실패건의 product_order_id
        $failed = $data->getFailed();
    } else {
        dump($result->getError());
    }
}
