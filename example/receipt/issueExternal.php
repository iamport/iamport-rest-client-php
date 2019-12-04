<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Receipt;

$iamport = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');

// 아임포트와 별개로 거래된 일반 현금결제에 대해서 현금영수증을 발행하는 API입니다
$request = Receipt::issueExternal(
    '가맹점 주문번호(merchant_uid)',
    '현금영수증 발행대상 주문명',
    1000,
    '현금영수증 발행대상 식별정보 (국세청현금영수증카드, 휴대폰버호, 주민등록번호, 사업자등록번호)'
);
// 파라메터 목록 참조 :  https://api.iamport.kr/#!/receipts/issueExternalReceipt
$request->identifier_type = 'phone';  // 이용 중인 PG사가 KICC, 세틀뱅크인 경우에만 필수입니다.
$request->type            = 'person'; // 소득공제용(개인) : person, 지출증빙용(법인) : company
$request->buyer_name      = '구매자 이름';
$request->buyer_email     = '구매자 이메일';
$request->buyer_tel       = '구매자 전화번호';
$request->tax_free        = 0;
$result                   = $iamport->callApi($request);

if ($result->isSuccess()) {
    /**
     *	Response\ExternalReceipt 를 가리킵니다. __get을 통해 API의 Item Model의 값들을 모두 property처럼 접근할 수 있습니다.
     *	참고 : https://api.iamport.kr/#!/receipts/issueExternalReceipt 의 Response Class Model.
     */
    $receipt = $result->getData();
} else {
    // TODO: 현금영수증 발행 실패리 처리

    $error = $result->getError();
    dump("아임포트 API 에러코드 : $error->code");
    dump("아임포트 API 에러메시지 : $error->message");
    // previous에는 에러 추적을 위해 아임포트 API 서버에서 응답하는 에러정보가 아닌 원본 Exception 객체가 담겨있습니다.
    dump('원본 Exception :', $error->previous);
}
