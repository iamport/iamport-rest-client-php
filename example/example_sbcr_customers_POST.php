<?php
// Created by saltylight 2016. 11. 17
require_once(dirname(__DIR__).'/src/iamport.php');

$iamport = new Iamport('YOUR_IMP_REST_API_KEY', 'YOUR_IMP_REST_API_SECRET');

#5. 비인증결제 빌링키 등록(수정)
$result = $iamport->subscribeCustomerPost(array(
	'customer_uid'  => '구매자 고유 번호',
	'card_number'	=> '카드 번호', 					//(dddd-dddd-dddd-dddd) 양식
	'expiry'		=> '유효기간 YYYY-MM', 			
	'birth' 		=> '생년월일 6자리',				//법인카드의 경우에는 사업자등록번호 10자리
	'pwd_2digit'	=> '카드비밀번호 앞 2자리',			//법인카드는 생략가능
));
if ( $result->success ) {
	/**
	*	IamportResult 를 가리킵니다. again API나 cancel API와는 다르게 response에 custom_data가 존재하지 않아
	*	IamportPayment로 return하면 에러발생. 
	*/
	$customers_data = $result->data;

	echo '## 등록(수정)한 빌링키 정보 출력 ##';
	echo '등록(수정)한 구매자 고유번호 : ' . $customers_data->customer_uid;
	echo '빌링키 등록 UNIX timestamp' 	. $customers_data->inserted;
	echo '빌링키 수정 UNIX timestamp' 	. $customers_data->updated;
	echo '등록(수정)한 카드의 카드사 : ' 	. $customers_data->card_name;    // ex) BC카드
} else {
	echo $result->error['code'];
	echo $result->error['message'];
}