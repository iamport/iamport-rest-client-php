<?php
require_once(dirname(__DIR__).'/src/iamport.php');

date_default_timezone_set("Asia/Seoul");
$iamport = new Iamport('YOUR_IMP_REST_API_KEY', 'YOUR_IMP_REST_API_SECRET');

$impUid = "거래 건의 imp_uid";

# 발행된 현금영수증 조회
$result = $iamport->getReceipt($impUid);

if ( $result->success ) {
  $receipt = $result->data;

  echo "## 현금영수증 발행 성공 ##" . "\n";
  echo "국세청 현금영수증 번호 : " . $receipt->apply_num . "\n";
  echo "현금영수증 전표 URL : " . $receipt->receipt_url . "\n";
  echo "현금영수증 발행 시각 : " . date("Y-m-d H:i:s", $receipt->applied_at) . "\n";
} else {
  echo "## 현금영수증 발행 실패 ##" . "\n";
  echo "오류 내용 : " . $result->error['message'] . "\n";
}