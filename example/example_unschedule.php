<?php
require_once(dirname(__DIR__).'/src/iamport.php');

$iamport = new Iamport('YOUR_IMP_REST_API_KEY', 'YOUR_IMP_REST_API_SECRET');

$result = $iamport->subscribeUnschedule(array(
	'customer_uid' => 'UNIQUE_KEY_FOR_EACH_CARD'
));

if ( $result->success ) {
	$unscheduled = $result->data;

	echo "## 등록된 예약정보 ##" . "\n";
	var_dump($unscheduled);
} else { 
	echo "## 오류코드 : " . $result->error['code'] . "\n";
	echo "## 오류내용 : " . $result->error['message'] . "\n";
}