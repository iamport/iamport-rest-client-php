<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\EscrowLogis;
use Iamport\RestClient\Request\EscrowLogisInvoice;
use Iamport\RestClient\Request\EscrowLogisPerson;

$iamport = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');

// 에스크로 결제 건에 대한 배송정보 등록
// 파라메터 목록 참조 :  https://api.iamport.kr/#!/escrow.logis/escrow_logis_save
$sender   = new EscrowLogisPerson('홍길동', '010-1234-5678', '서울시 강남구 삼성동', '15411');
$receiver = new EscrowLogisPerson('김길동', '010-1234-5678', '서울시 마포구 연희동', '16211');
$invoice  = new EscrowLogisInvoice('시옷', '123456', '1568785782');

$escrow = EscrowLogis::register($impUid, $sender, $receiver, $invoice);
$result = $iamport->callApi($request);

if ($result->getSuccess()) {
    /**
     *	Response\EscrowLogis 를 가리킵니다. __get을 통해 API의 Item Model의 값들을 모두 property처럼 접근할 수 있습니다.
     *	참고 : https://api.iamport.kr/#!/escrow.logis/escrow_logis_save 의 Response Class Model.
     */
    $escrowLogis = $result->getData();
// TODO: 배송정보 등록 이후 처리
} else {
    $error = $result->getError();
    dump("아임포트 API 에러코드 : $error->code");
    dump("아임포트 API 에러메시지 : $error->message");
    // previous에는 에러 추적을 위해 아임포트 API 서버에서 응답하는 에러정보가 아닌 원본 Exception 객체가 담겨있습니다.
    dump('원본 Exception :', $error->previous);
}
