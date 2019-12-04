<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Certification;

$iamport = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');

// imp_uid 로 SMS본인인증된 결과를 조회
$request = Certification::view('조회할 거래 고유번호(imp_uid)');
$result  = $iamport->callApi($request);

if ($result->isSuccess()) {
    /**
     *	Response\Certification 를 가리킵니다. __get을 통해 API의 Item Model의 값들을 모두 property처럼 접근할 수 있습니다.
     *	참고 : https://api.iamport.kr/#!/certifications/getCertification 의 Response Class Model.
     */
    $certification = $result->getData();

    // TODO: 조회한 인증정보에서 고객정보를 추출하여 가맹점 서비스에 필요한 로직을 작성합니다.

    // 연령 제한 로직
    if (date('Y', $certification->getAttributes('birth')) <= 1999) {
        // 연령 만족
    } else {
        // 연령 미달
    }

    // 1인 1계정 허용 로직
    // TODO: 가맹점 DB에서 unique_key 조회 후 가입여부 검사 ( 아래 코드는 예시를 돕고자 작성된 샘플코드로 실제 가맹점의 환경에 맞게 직접 작성하셔야 됩니다. )
    $pdoStatement = $pdo->prepare('SELECT * FROM users WHERE unique_key = :unique_key');
    $pdoStatement->bindValue(':unique_key', $certification->unique_key);
    $pdoStatement->execute();
    $user = $pdoStatement->fetch(PDO::FETCH_ASSOC);

    if (!user) {
        // 신규 고객
    } else {
        // 이미 가입된 고객
    }
} else {
    $error = $result->getError();
    dump("아임포트 API 에러코드 : $error->code");
    dump("아임포트 API 에러메시지 : $error->message");
    // previous에는 에러 추적을 위해 아임포트 API 서버에서 응답하는 에러정보가 아닌 원본 Exception 객체가 담겨있습니다.
    dump('원본 Exception :', $error->previous);
}
