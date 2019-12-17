<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Naver\NaverInquiry;

$iamport = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');
$request = NaverInquiry::reviews('2019-08-30 00:00:00', '2019-08-31 00:00:00');
$result  = $iamport->callApi($request);
dump($result);
if ($result->isSuccess()) {
    $reviews = $result->getData()->getItems();
    foreach ($reviews as $review) {
        // TODO: 구매평 데이터 조회
        dump($title = $review->title);
    }
} else {
    dump($result->getError());
}
