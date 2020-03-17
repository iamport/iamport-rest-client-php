<?php
require_once(dirname(__DIR__).'/src/iamport.php');

date_default_timezone_set("Asia/Seoul");
$iamport = new Iamport('YOUR_IMP_REST_API_KEY', 'YOUR_IMP_REST_API_SECRET');

$issueData = array(
  "merchant_uid"      => "order_" . date('YmdHis'), //가맹점 주문번호
  "amount"            => 1200,           //입금해야할 가상계좌 금액
  "vbank_code"        => "020",             //발급할 가상계좌 은행
  "vbank_due"         => strtotime("+1 day"),   //가상계좌의 입금기한 Unix Timestamp
  "vbank_holder"      => "아임포트-홍길동",  //가상계좌의 예금주. 고객이 입금할 때 예금주로 표시될 문구. 통상적으로 회사이름 + 구매자명 또는 구매자명으로 설정
);

# 가상계좌 발급요청
$result = $iamport->issueVbank($issueData);

if ( $result->success ) {
  $payment = $result->data;

  echo "## 가상계좌 발급 성공 ##" . "\n";
  echo "입금해야할 금액 : " . $payment->amount . "\n";
  echo "발급된 가상계좌번호 : " . $payment->vbank_num . "\n";
  echo "발급된 가상계좌 은행코드 : " . $payment->vbank_code . "\n";
  echo "발급된 가상계좌 예금주 : " . $payment->vbank_holder . "\n";
  echo "발급된 가상계좌 입금기한 : " . date("Y-m-d H:i:s", $payment->vbank_date) . "\n";
} else {
  echo "## 가상계좌 발급 실패 ##" . "\n";
  echo "오류 내용 : " . $result->error['message'] . "\n";
}
