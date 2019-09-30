<?php

require_once '../vendor/autoload.php';

use Iamport\RestClient\Iamport;

$iamport = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');

$result = $iamport->subscribeUnschedule([
	'customer_uid' => 'duplicate-cuid1'
]);
dd($result);
if ( $result->success ) {
	$unscheduled = $result->data;

	echo "## 등록된 예약정보 ##" . "\n";
	var_dump($unscheduled);
} else { 
	echo "## 오류코드 : " . $result->error['code'] . "\n";
	echo "## 오류내용 : " . $result->error['message'] . "\n";
}