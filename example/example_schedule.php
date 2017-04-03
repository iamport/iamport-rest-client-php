<?php
require_once(dirname(__DIR__).'/src/iamport.php');

$iamport = new Iamport('YOUR_IMP_REST_API_KEY', 'YOUR_IMP_REST_API_SECRET');

$result = $iamport->subscribeSchedule(
	array(
		'customer_uid' => 'UNIQUE_KEY_FOR_EACH_CARD',
		'checking_amount' => 100, 
		'card_number' => '1234-1234-1234-1234', 
		'expiry' => '2020-01', 
		'birth' => '000000',
		'pwd_2digit' => '00', 
		'schedules' => array(
			array(
				'merchant_uid' => 'order_'.time(),
				'amount' => 1100,
				'schedule_at' => time() + 100,
				'name' => '예약결제 1',
				'buyer_name' => '예약자A',
				'buyer_email' => 'buyer@iamport.kr',
				'buyer_tel' => '01012341234',
				'buyer_addr' => '서울 강남구 신사동',
				'buyer_postcode' => '123456',
			),
			array(
				'merchant_uid' => 'order_'.(time()+1),
				'amount' => 1200,
				'schedule_at' => time() + 200
			)
		)
	)
);

if ( $result->success ) {
	$schedules = $result->data;

	echo "## 등록된 예약정보 ##" . "\n";
	var_dump($schedules);
} else {
	echo "## 오류코드 : " . $result->error['code'] . "\n";
	echo "## 오류내용 : " . $result->error['message'] . "\n";
}