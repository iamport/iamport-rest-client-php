<?php
require_once(dirname(__DIR__).'/src/iamport.php');

date_default_timezone_set("Asia/Seoul");
$iamport = new Iamport('YOUR_IMP_REST_API_KEY', 'YOUR_IMP_REST_API_SECRET');

$impUid = "거래 건의 imp_uid";

$issueData = array(
  "identifier"      => "01012341234", //현금영수증 신청자의 전화번호, 주민등록번호 등
  "type"            => "person",      //소득공제용(개인) : person, 지출증빙용(법인) : company
  "buyer_name"      => "구매자 이름", 
  "buyer_email"     => "구매자 이메일", 
  "buyer_tel"       => "구매자 전화번호",
);

# 이용 중인 PG사가 세틀뱅크인 경우에만 필수 파라메터
//person : 주민등록번호, business : 사업자등록번호, phone : 휴대폰번호, taxcard : 국세청현금영수증카드
$issueData["identifier_type"] = "phone"; // identifier 파라메터의 유형을 지정해야 합니다. 

# 현금영수증 발행
$result = $iamport->issueReceipt($impUid, $issueData);

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