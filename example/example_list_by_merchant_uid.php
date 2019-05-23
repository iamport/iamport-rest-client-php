<?php
require_once(dirname(__DIR__).'/src/iamport.php');

$iamport = new Iamport('YOUR_IMP_REST_API_KEY', 'YOUR_IMP_REST_API_SECRET');

#2. merchant_uid 로 주문정보 모두 찾기(가맹점의 주문번호)
$result = $iamport->findAllByMerchantUID('your_merchant_uid'); //IamportResult 를 반환(success, data, error)
if ( $result->success ) {
	/**
	*	IamportPayment 배열을 포함한 IamportPaymentsPaged 를 가리킵니다.
	*	참고 : https://api.iamport.kr/#!/payments/getAllPaymentsByMerchantUid 의 Response Model
	*/
	$pagedPayments = $result->data;

	echo '## 결제정보 출력 ##' . "\n\n";
	echo '검색된 전체 결제 건수 : ' . $pagedPayments->getTotal() . "\n";

	echo 'Next Pagination 번호 (0이면 Next Page가 존재하지 않음) : ' . $pagedPayments->getNext() . "\n";
	echo 'Previous Pagination 번호 (0이면 Previous Page가 존재하지 않음) : ' . $pagedPayments->getPrevious() . "\n\n";

    foreach ($pagedPayments->getPayments() as $index=>$payment) {
        echo sprintf("## %s 번째 결제정보 출력 ##\n", $index+1);

        echo '아임포트 고유번호 : ' 	. $payment->imp_uid . "\n";
        echo '결제상태 : ' 		. $payment->status . "\n";
        echo '결제금액 : ' 		. $payment->amount . "\n";
        echo '결제수단 : ' 		. $payment->pay_method . "\n";
        echo '결제된 카드사명 : ' 	. $payment->card_name . "\n";
        echo '결제 매출전표 링크 : '	. $payment->receipt_url . "\n";

        /**
         *	IMP.request_pay({
         *		custom_data : {my_key : value}
         *	});
         *	와 같이 custom_data를 결제 건에 대해서 지정하였을 때 정보를 추출할 수 있습니다.(서버에는 json encoded형태로 저장합니다)
         */
        echo 'Custom Data :'	. $payment->getCustomData('my_key') . "\n";
	}
} else {
	error_log($result->error['code']);
	error_log($result->error['message']);
}