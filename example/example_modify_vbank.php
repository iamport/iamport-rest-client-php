<?php
require_once(dirname(__DIR__).'/src/iamport.php');

date_default_timezone_set("Asia/Seoul");
$iamport = new Iamport('YOUR_IMP_REST_API_KEY', 'YOUR_IMP_REST_API_SECRET');

$impUid = 'imp_679285972069'; //기존에 발급된 가상계좌 거래건의 아임포트 거래고유번호
$modifyData = array(
  "amount"            => 3300,           //변경할 가상계좌 입금금액
  "vbank_due"         => strtotime("+7 day"),   //변경할 가상계좌의 입금기한 Unix Timestamp
);

# 가상계좌 수정요청
$result = $iamport->modifyVbank($impUid, $modifyData);

if ( $result->success ) {
  $payment = $result->data;

  echo "## 가상계좌 수정 성공 ##" . "\n";
  echo "수정된 가상계좌 입금금액 : " . $payment->amount . "\n";
  echo "수정된 가상계좌 입금기한 : " . date("Y-m-d H:i:s", $payment->vbank_date) . "\n";
} else {
  echo "## 가상계좌 수정 실패 ##" . "\n";
  echo "오류 내용 : " . $result->error['message'] . "\n";
}
