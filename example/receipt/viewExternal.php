<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Receipt;

$iamport = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');

// 아임포트 API를 통해 현금영수증만 발행된 건의 상세정보를 조회하는 API입니다. (아임포트와 별개로 결제된 현금거래건)
$request = Receipt::viewExternal('조회할 현금영수증 발행 주문명(merchant_uid)');
$result  = $iamport->callApi($request);

if ($result->isSuccess()) {
    /**
     *  Response\ExternalReceipt 를 가리킵니다. __get을 통해 API의 Item Model의 값들을 모두 property처럼 접근할 수 있습니다.
     *  참고 : https://api.iamport.kr/#!/receipts/getExternalReceipt 의 Response Class Model.
     */
    $receipt = $result->getData();

// TODO: $receipt->{property} 로 결제 데이터 접근
    //       $receipt->getAttributes({property}) 로 원본 데이터 접근
} else {
    $error = $result->getError();
    dump("아임포트 API 에러코드 : $error->code");
    dump("아임포트 API 에러메시지 : $error->message");
    // previous에는 에러 추적을 위해 아임포트 API 서버에서 응답하는 에러정보가 아닌 원본 Exception 객체가 담겨있습니다.
    dump('원본 Exception :', $error->previous);
}
