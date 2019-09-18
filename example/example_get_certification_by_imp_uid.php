<?php
require_once(dirname(__DIR__).'/src/iamport.php');

date_default_timezone_set('Asia/Seoul');

$iamport = new Iamport('YOUR_IMP_REST_API_KEY', 'YOUR_IMP_REST_API_SECRET');

#1. imp_uid 로 주문정보 찾기(아임포트에서 생성된 거래고유번호)
$result = $iamport->findCertificationByImpUID('your_imp_uid'); //IamportResult 를 반환(success, data, error)

if ( $result->success ) {
	/**
	*	IamportPayment 를 가리킵니다. __get을 통해 API의 Payment Model의 값들을 모두 property처럼 접근할 수 있습니다.
	*	참고 : https://api.iamport.kr/#!/payments/getPaymentByImpUid 의 Response Model
	*/
	$certification = $result->data;

	echo '## 본인인증정보 출력 ##';
	echo "\n";

	# certified 필드를 통해 인증여부를 판단합니다.
	if ( $certification->certified ) {
		//TODO : 본인인증 완료 시 처리
        echo '이름 : ' 	. $certification->name;
        echo "\n";
        echo '성별 : ' 	. $certification->gender; //male or female
        echo "\n";
        echo '생년월일 : ' 	. date('Y-m-d', $certification->birth); //Seoul Timezone기준으로 Date Format
        echo "\n";
        echo 'UniqueKey(KISA) : ' 	. $certification->unique_key;
        echo "\n";
	}
} else {
	error_log($result->error['code']);
	error_log($result->error['message']);
}