<?php
require_once(dirname(__DIR__).'/src/iamport.php');

date_default_timezone_set("Asia/Seoul");
$iamport = new Iamport('YOUR_IMP_REST_API_KEY', 'YOUR_IMP_REST_API_SECRET');

$impUid = 'imp_679285972069'; //기존에 발급된 가상계좌 거래건의 아임포트 거래고유번호

# 가상계좌 말소(더이상 입금불가)요청
$result = $iamport->revokeVbank($impUid);

if ( $result->success ) {
  $payment = $result->data;

  echo "## 가상계좌 말소 완료 ##" . "\n";
} else {
  echo "## 가상계좌 말소 실패 ##" . "\n";
  echo "오류 내용 : " . $result->error['message'] . "\n";
}
