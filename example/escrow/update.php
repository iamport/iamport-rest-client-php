<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Escrow\EscrowLogis;
use Iamport\RestClient\Request\Escrow\EscrowLogisInvoice;
use Iamport\RestClient\Request\Escrow\EscrowLogisPerson;

$iamport  = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');
$sender   = new EscrowLogisPerson('시옷', '1670-5176', '신사동 661-16', '06018');
$receiver = new EscrowLogisPerson('시옷', '1670-5176', '신사동 661-16', '06018');
$invoice  = new EscrowLogisInvoice('EPOST', '1110301285808', '2019-09-03 00:00:00');
$request  = EscrowLogis::update('imp_12345678912', $sender, $receiver, $invoice);
$result   = $iamport->callApi($request);

if ($result->isSuccess()) {
    $escrowLogis = $result->getData();
// TODO: 배송정보 수정 이후 처리
} else {
    $error = $result->getError();
    echo "아임포트 API 에러코드 : $error->code";
    echo "아임포트 API 에러메시지 : $error->message";
    // previous에는 에러 추적을 위해 아임포트 API 서버에서 응답하는 에러정보가 아닌 원본 Exception 객체가 담겨있습니다.
    print_r($error->previous);
}
