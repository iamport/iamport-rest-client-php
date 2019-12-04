<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Certification;

$iamport = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');

// imp_uid 로 SMS본인인증된 결과를 아임포트에서 삭제
$request = Certification::delete('삭제할 거래 고유번호(imp_uid)');
$result  = $iamport->callApi($request);

if ($result->isSuccess()) {
    /**
     *	삭제된 데이터로 Response\Certification 를 가리킵니다. __get을 통해 API의 Item Model의 값들을 모두 property처럼 접근할 수 있습니다.
     *	참고 : https://api.iamport.kr/#!/certifications/getCertification 의 Response Class Model.
     */
    $certification = $result->getData();
} else {
    $error = $result->getError();
    dump("아임포트 API 에러코드 : $error->code");
    dump("아임포트 API 에러메시지 : $error->message");
    // previous에는 에러 추적을 위해 아임포트 API 서버에서 응답하는 에러정보가 아닌 원본 Exception 객체가 담겨있습니다.
    dump('원본 Exception :', $error->previous);
}
