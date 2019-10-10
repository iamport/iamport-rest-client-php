<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Payment;

$iamport = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');

// merchant_uid 로 주문정보 모두 찾기(가맹점의 주문번호)
$request = Payment::listMerchantUid('검색할 주문 번호(merchant_uid)');
// 검색옵션 참조 :  https://api.iamport.kr/#!/payments/getAllPaymentsByMerchantUid
$request->payment_status = 'paid';
$request->sorting        = '-started';
$request->page           = 1;
$result                  = $iamport->callApi($request);

if ($result->getSuccess()) {
    /**
     *	Response\Payment를 포함한 Collection을 가리킵니다.
     *	참고 : https://api.iamport.kr/#!/payments/getAllPaymentsByMerchantUid 의 Response Class Model.
     */
    $payments = $result->getData();

    dump('검색된 전체 결제 건수 : '.$payments->getTotal());
    dump('Next Pagination 번호 (0이면 Next Page가 존재하지 않음) : '.$payments->getNext());
    dump('Previous Pagination 번호 (0이면 Previous Page가 존재하지 않음) : '.$payments->getPrevious());

    // items배열은 Response\Payment item Model을 담고 있습니다.
    foreach ($payments->getItems() as $payment) {
        // TODO: $payment->{property} 로 결제 데이터 접근
        //       $payment->getAttributes({property}) 로 원본 데이터 접근
    }
} else {
    $error = $result->getError();
    dump("아임포트 API 에러코드 : $error->code");
    dump("아임포트 API 에러메시지 : $error->message");
    // previous에는 에러 추적을 위해 아임포트 API 서버에서 응답하는 에러정보가 아닌 원본 Exception 객체가 담겨있습니다.
    dump('원본 Exception :', $error->previous);
}
