<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Enum\PaycoStatus;
use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Payco;

$iamport = new Iamport('imp_apikey_payco', 'DsiyA7fpCYzecdevDriz/V44/UP+rgymkJq72OdjPtIfVz/Tm2DgsRTLuaVUZRdl9+u3LTTfGNJ8lZAdQn9y8A==');
// PaycoStatus::getAll() 으로 status 목록 확인
$request = new Payco('imp_499680236986', PaycoStatus::CANCELED);
$result  = $iamport->callApi($request);

if ($result->isSuccess()) {
    // 원본값 조회는 getAttributes({property name})를 사용합니다.
    $paycoStatus = $result->getData()->status;
    dump($paycoStatus);
    dump($result->getData()->getAttributes('status'));
} else {
    dump($result->getError());
}
