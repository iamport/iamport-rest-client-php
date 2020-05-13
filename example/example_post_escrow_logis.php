<?php
require_once(dirname(__DIR__).'/src/iamport.php');

date_default_timezone_set("Asia/Seoul");
$iamport = new Iamport('YOUR_IMP_REST_API_KEY', 'YOUR_IMP_REST_API_SECRET');

$impUid = 'imp_679285972069'; //배송정보 등록할 에스크로 거래건의 아임포트 거래고유번호

# 배송정보 신규 등록
$sender = array(
    'name' => '업체명',
    'tel' => '1670-5176',
    'addr' => '서울 강남구 선릉로161길 24',
    'postcode' => '06018',
);

$receiver = array(
    'name' => '고객명',
    'tel' => '010-1234-1234',
    'addr' => '서울 송파고 송파대로111',
    'postcode' => '05837',
);

$logis = array(
    'company' => 'LOGEN',
    'invoice' => '1234-1234-1234',
    'sent_at' => strtotime('2020-05-11'),
);

$result = $iamport->registerEscrowLogis($impUid, $sender, $receiver, $logis);

if ( $result->success ) {
    echo "## 배송정보 등록 성공 ##";
} else {
    echo "## 배송정보 등록 실패 ##" . "\n";
    echo "오류 내용 : " . $result->error['message'] . "\n";
}
