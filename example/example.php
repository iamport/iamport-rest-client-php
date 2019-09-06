<?php

require_once '../vendor/autoload.php';

use Iamport\RestClient\Iamport;

$imp = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');

// imp_uid 로 주문정보 찾기(아임포트에서 생성된 거래고유번호)
$paymentImpUID =  $imp->paymentImpUid('imps_168056340072');

// merchant_uid 로 주문정보 찾기(가맹점의 주문번호)
$paymentMerchantUID = $imp->paymentMerchantUid('20180816a12');

// merchant_uid 로 주문정보 모두 찾기(가맹점의 주문번호)
$paymentsMerchantUID = $imp->paymentsMerchantUid('20180816a12');

//주문취소
$cancelData = [
    'imp_uid'        => 'imps_168056340072',
    'merchant_uid'   => 'asdf',
    'amount'         => 1004,
    'tax_free'       => 0,
    'checksum'       => 0,
    'reason'         => '취소테스트',
    'refund_holder'  => '환불될 가상계좌 예금주',
    'refund_bank'    => '환불될 가상계좌 은행코드',
    'refund_account' => '환불될 가상계좌 번호',
];
$paymentCancel = $imp->paymentCancel($cancelData);

// 발행된 현금영수증 조회
$receipt = $imp->receipt('imps_168056340072');

// 현금영수증 발행
$receiptData = [
    'identifier'      => '01012341234',
    'identifier_type' => 'phone',
    'type'            => 'person',
    'buyer_name'      => '구매자 이름',
    'buyer_email'     => '구매자 이메일',
    'buyer_tel'       => '구매자 전화번호',
    'tax_free'        => '현금영수증 발행금액 중 면세금액',
];
$issueReceipt = $imp->issueReceipt('imps_168056340072', $receiptData);

// 비인증결제 빌링키 등록(수정)
$billingKeyData = [
    'customer_uid'     => 'customer_1234',
    'pg'               => '',
    'card_number'      => '1234-1234-1234-1234',
    'expiry'           => '2023-12',
    'birth'            => '880223',
    'pwd_2digit'       => '10',
    'customer_name'    => '',
    'customer_tel'     => '',
    'customer_email'   => '',
    'customer_addr'    => '',
    'customer_postcode'=> '',
];
$addBillingKey = $imp->addBillingKey($billingKeyData);

// 비인증결제 빌링키 조회
$billingKey    = $imp->billingKey('duplicate-cuid1');

// 비인증결제 빌링키 삭제
$delBillingKey = $imp->delBillingKey('duplicate-cuid1');

// 빌링키 발급과 결제 요청을 동시에 처리.
$onetimeData = [
    //필수
    'merchant_uid'  => '가맹점 거래 고유번호',
    'amount'        => 1000,
    'card_number'   => '1234-1234-1234-1234',
    'expiry'        => '2020-01',
    'birth'         => '801231',

    //생략가능
    'tax_free'            => 100,
    'pwd_2digit'          => '00',
    'customer_uid'        => 'customer_12345',
    'pg'                  => 'pg사',
    'name'                => '주문명',
    'buyer_name'          => '주문자명',
    'buyer_email'         => '주문자 E-mail주소',
    'buyer_tel'           => '주문자 전화번호',
    'buyer_addr'          => '주문자 주소',
    'buyer_postcode'      => '주문자 우편번호',
    'card_quota'          => '카드 할부개월 수',
    'custom_data'         => '',
    'notice_url'          => '',
];
$subscribeOnetime = $imp->subscribeOnetime($onetimeData);

// 저장된 빌링키로 재결제.
$againData = [
    //필수
    'customer_uid'    => 'duplicate-cuid2',
    'merchant_uid'    => 'merchant_1411448514391',
    'amount'          => 1004,
    'name'            => '주문명',

    //생략가능
    'tax_free'        => 100,
    'buyer_name'      => '주문자명',
    'buyer_email'     => '주문자 E-mail주소',
    'buyer_tel'       => '주문자 전화번호',
    'buyer_addr'      => '주문자 주소',
    'buyer_postcode'  => '주문자 우편번호',
    'card_quota'      => '카드 할부개월 수',
    'custom_data'     => '',
    'notice_url'      => '',
];
$subscribeAgain = $imp->subscribeAgain($againData);

// 저장된 빌링키로 정기 예약 결제.
$scheduleData   = [
    'customer_uid'    => 'duplicate-cuid1',
    'checking_amount' => 100,
    'card_number'     => '1234-1234-1234-1234',
    'expiry'          => '2020-01',
    'birth'           => '000000',
    'pwd_2digit'      => '00',
    'pg'              => '',
    'schedules'       => [
        [
            'merchant_uid'   => 'order_'.time(),
            'schedule_at'    => time() + 100,
            'amount'         => 1100,
            'tax_free'       => 0,
            'name'           => 'composer 예약결제 ',
            'buyer_name'     => 'composer 예약자A',
            'buyer_email'    => 'buyer@iamport.kr',
            'buyer_tel'      => '01012341234',
            'buyer_addr'     => '서울 강남구 신사동',
            'buyer_postcode' => '123456',
            'notice_url'     => '',
        ],
        [
            'merchant_uid' => 'order_'.(time() + 1),
            'amount'       => 1200,
            'schedule_at'  => time() + 200,
        ],
    ],
];
$subscribeSchedule   = $imp->subscribeSchedule($scheduleData);

// 비인증 결제요청예약 취소
$unscheduleData      = [
    'customer_uid' => 'duplicate-cuid1',
    'merchant_uid' => '20181008k',
];
$subscribeUnschedule = $imp->subscribeUnschedule($unscheduleData);

if ($result->success) {
    dump($result->data);
} else {
    dump('## 오류코드 : '.$result->error['code']);
    dump('## 오류내용 : '.$result->error['message']);
}
