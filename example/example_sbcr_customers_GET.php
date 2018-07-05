<?php
require_once(dirname(__DIR__).'/src/iamport.php');

$iamport = new Iamport('YOUR_IMP_REST_API_KEY', 'YOUR_IMP_REST_API_SECRET');

#7. 비인증결제 빌링키 조회
$result = $iamport->subscribeCustomerGet('your_customer_uid');   // 구매자 고유 번호
if ( $result->success ) {
    /**
     *	IamportResult 를 가리킵니다. again API나 cancel API와는 다르게 response에 custom_data가 존재하지 않아
     *	IamportPayment로 return하면 에러발생.
     */
    $customers_data = $result->data;

    echo '## 빌링키 정보 출력 ##';
    echo '구매자 고유번호 : ' . $customers_data->customer_uid;
    echo '빌링키 등록 UNIX timestamp' 	. $customers_data->inserted;
    echo '빌링키 수정 UNIX timestamp' 	. $customers_data->updated;
    echo '카드의 카드사 : ' 	. $customers_data->card_name;    // ex) BC카드
} else {
    echo $result->error['code'];
    echo $result->error['message'];
}