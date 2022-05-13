<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Enum\Naver\CancelPaymentRequester;
use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\CancelPayment;
use Iamport\RestClient\Request\CancelPaymentExtra;

$iamport = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');

// 클라이언트로부터 전달받은 주문번호, 환불사유, 환불금액
$merchant_uid        = filter_input(INPUT_POST, 'merchant_uid', FILTER_SANITIZE_STRING);
$reason              = filter_input(INPUT_POST, 'reason', FILTER_SANITIZE_STRING);
$cancelRequestAmount = filter_input(INPUT_POST, 'cancel_request_amount', FILTER_SANITIZE_STRING);
$extra_requester     = filter_input(INPUT_POST, 'extra_requester', FILTER_SANITIZE_STRING);

// TODO : 아래 가맹점 DB 접근 코드는 예시를 돕고자 작성된 샘플코드로 실제 가맹점의 환경에 맞게 직접 작성하셔야 됩니다.
// 가맹점 DB에서 환불할 결제 정보 조회
$pdo          = new PDO('dsn', 'db username', 'db password');
$pdoStatement = $pdo->prepare('SELECT imp_uid, amount, cancel_amount FROM payments WHERE merchant_uid = :merchant_uid');
$pdoStatement->bindValue(':merchant_uid', $merchant_uid);
$pdoStatement->execute();
$data = $pdoStatement->fetch(PDO::FETCH_ASSOC);

// 환불 가능 금액( 결제금액 - 환불 된 총 금액 )
$cancelableAmount = $data['amount'] - $data['cancel_amount'];
if ($cancelableAmount <= 0) {
    // TODO: 가맹점 환경에 따라 환불 프로세스 취소 처리
    // 이미 전액환불된 주문이므로 하기 아임포트 REST API로 결제환불 처리를 실행할 필요가 없습니다.
}

// 환불 고유번호(imp_uid 혹은 merchant_uid)로 승인된 결제를 취소 (환불고유번호는 imp_uid가 merchant_uid보다 우선시 됩니다)
$request = CancelPayment::withImpUid($data['imp_uid']);
// merchant_uid로 승인된 결제를 취소
$request = CancelPayment::withMerchantUid($merchant_uid);

$request->amount         = $cancelRequestAmount;  // 가맹점 클라이언트로부터 받은 환불금액
$request->tax_free       = $data['tax_free'];
$request->checksum       = $cancelableAmount;     // [권장] 환불 가능 금액 입력
$request->reason         = $data['reason'];
$request->refund_holder  = '환불될 가상계좌 예금주';
$request->refund_bank    = '환불될 가상계좌 은행코드';
$request->refund_account = '환불될 가상계좌 번호';

$extra = new CancelPaymentExtra();
// 취소 요청자, API를 호출하는 출처 (optional)
if ($extra_requester === 'admin') {
    $extra->requester = CancelPaymentRequester::ADMIN;
} else if ($extra_requester === 'customer'){
    $extra->requester = CancelPaymentRequester::CUSTOMER;
}

$request->extra          = $extra;
$result                  = $iamport->callApi($request);

if ($result->isSuccess()) {
    $payment = $result->getData();
} else {
    $error = $result->getError();
    dump('아임포트 API 에러코드 : ', $error->code);
    dump('아임포트 API 에러메시지 : ', $error->message);
    // previous에는 에러 추적을 위해 아임포트 API 서버에서 응답하는 에러정보가 아닌 원본 Exception 객체가 담겨있습니다.
    dump($error->previous);
}
