<?php
require_once('src/iamport.php');

$iamport = new Iamport('YOUR_IMP_REST_API_KEY', 'YOUR_IMP_REST_API_SECRET');

#4. 저장된 빌링키로 재결제
$result = $iamport->sbcr_again(array(
	//필수
	'customer_uid'  => '구매자 고유 번호', 			
	'merchant_uid'	=> '가맹점 거래 고유번호', 		// PG사 영수증에 '주문번호'로 찍힘
	'amount' 		=> 1000,					
	//필수 or 생략가능
	'vat'			=> 100, 					// 1. 부가세 관련 PG사 인증을 안받은경우(기본): 기본으로 10%로 VAT가 찍힘(생략가능)
												// 2. 부가세 관련 PG사 인증을 받은경우: VAT를 생략할 경우 결제실패(생략불가)
	//생략가능
	'name'			=> '주문명',					// PG사 이메일 영수증의 상품명
	'buyer_name'	=> '주문자명',					// PG사 이메일 영수증의 구매자명
	'buyer_email'	=> '주문자 E-mail주소',		// PG사 이메일 영수증을 수신할 이메일주소 (생략시 이메일 영수증 발송 X)
	'buyer_tel'		=> '주문자 전화번호',
	'buyer_addr'	=> '주문자 주소',
	'buyer_postcode'=> '주문자 우편번호',
	'card_quota'	=> '카드 할부개월 수'			// 2 이상의 integer에 대해 적용(최소 amount 50,000원)
));
if ( $result->success ) {
	/**
	*	IamportPayment 를 가리킵니다. __get을 통해 API의 Payment Model의 값들을 모두 property처럼 접근할 수 있습니다.
	*	참고 : https://api.iamport.kr/#!/subscribe/payments/again 의 Response Model
	*/
	$payment_data = $result->data;

	echo '## 결제정보 출력 ##';
	echo '결제상태 : ' 				. $payment_data->status;
	echo '결제금액 : ' 				. $payment_data->amount;
	echo '결제수단 : ' 				. $payment_data->pay_method;		//ex) "card"
	echo '결제된 카드사명 : ' 			. $payment_data->card_name;
	echo '결제(실패) 매출전표 링크 : '	. $payment_data->receipt_url;

	if ($payment_data->status == 'paid') {
		// 결제성공

	}

	else {
		// 결제실패
		echo '결제실패 사유 : ' 		. $payment_data->fail_reason;	
	}
	//등등 __get을 선언해 놓고 있어 API의 Payment Model의 값들을 모두 property처럼 접근할 수 있습니다.
} else {
	error_log($result->error['code']);
	error_log($result->error['message']);
}