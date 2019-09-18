# iamport-rest-client-php

PHP사용자를 위한 아임포트 REST API 연동 모듈입니다

- [guzzle](http://docs.guzzlephp.org/en/stable/)을 기반으로 만들어진 버전
- composer 패키지 형태로 제공

## Required
- PHP 7.1 버전 이상을 요구합니다.


## Install
```bash
composer require iamport/rest-client
```

## Usage - Request 객체 방식
Request 객체 방식은 `API Endpoint`, `Http verb`, `request` 데이터들이 미리 정의되어 있으며,

만약 IDE를 사용할 경우 **타입 체크**와 **값의 존재 여부** 등을 알 수 있습니다.

또한 통신에 성공/실패 유무와 무관하게 아래와 같이 일관된 구조의 최종 결과물을 제공합니다.

```javascript
{
    success: 성공/실패유무
    data : 응답 데이터
    error : 에러정보
}
```

### 제공되는 Request 객체 목록
**본인인증 API**
- Certification
    - [Certification::view()](https://api.iamport.kr/#!/certifications/getCertification)
    - [Certification::delete()](https://api.iamport.kr/#!/certifications/deleteCertification)
    
**에스크로 API**
- EscrowLogis
    - [EscrowLogis::register()](https://api.iamport.kr/#!/escrow.logis/escrow_logis_save)
    - [EscrowLogis::update()](https://api.iamport.kr/#!/escrow.logis/escrow_logis_save_0)
        
**결제관련 기본 API**
- Payment
    - [Payment::getImpUid()](https://api.iamport.kr/#!/payments/getPaymentByImpUid)
    - [Payment::getMerchantUid()](https://api.iamport.kr/#!/payments/getPaymentByMerchantUid)
    - [Payment::listMerchantUid()](https://api.iamport.kr/#!/payments/getAllPaymentsByMerchantUid)
- CancelPayment
    - [CancelPayment::withImpUid()](https://api.iamport.kr/#!/payments/cancelPayment)
    - [CancelPayment::withMerchantUid()](https://api.iamport.kr/#!/payments/cancelPayment)
- SubscribeOnetime
    - [SubscribeOnetime()](https://api.iamport.kr/#!/subscribe/onetime)
- SubscribeAgain
    - [SubscribeAgain()](https://api.iamport.kr/#!/subscribe/again)
- SubscribeSchedule
    - [SubscribeSchedule()](https://api.iamport.kr/#!/subscribe/schedule)
- SubscribeUnschedule
    - [SubscribeUnschedule()](https://api.iamport.kr/#!/subscribe/unschedule)

**비인증 결제 빌링키 관리 API**
- SubscribeCustomer
    - [SubscribeCustomer::view()](https://api.iamport.kr/#!/subscribe.customer/customer_view)
    - [SubscribeCustomer::issue()](https://api.iamport.kr/#!/subscribe.customer/customer_save)
    - [SubscribeCustomer::delete()](https://api.iamport.kr/#!/subscribe.customer/customer_delete)

**현금영수증 발급/관리 API**
- Receipt
    - [Receipt::view()](https://api.iamport.kr/#!/receipts/getReceipt)
    - [Receipt::issue()](https://api.iamport.kr/#!/receipts/issueReceipt)
    - [Receipt::cancel()](https://api.iamport.kr/#!/receipts/revokeReceipt)

### Request 객체 방식 예제

```php
$iamport = new Iamport('YOUR_IMP_REST_API_KEY', 'YOUR_IMP_REST_API_SECRET');

$payment = Payment::getImpUid('imps_410064014595');

$result = $iamport->callApi($payment);

if ($result->success) {

    // 조회한 결제 정보
    $payment_data = $result->data;

    // __get을 통해 API의 Response Model의 값들을 모두 property처럼 접근할 수 있습니다.
    // https://api.iamport.kr/#!/payments/getPaymentByImpUid 의 Response Model.
    $imp_uid = $payment_data->imp_uid;

    if ( 결제검증 로직 ) {
        // 결제 성공 처리
    } else {
        // 결제 실패 처리
    }
} else {
    error_log($result->error);
}
```

## Usage - 직접호출


하기 메소드로 직접 request 요청을 생성할 수 있습니다.

```php
iamport->request('Method', 'URI', 'Request Options');
```

이때 request 옵션은 [Guzzle 문서](http://docs.guzzlephp.org/en/stable/request-options.html)를 참고하여 규격에 맞게 전송해야 하며,

응답 유형은 `Psr\Http\Message\ResponseInterface` 입니다.


### 예제
```php
$iamport = new Iamport('YOUR_IMP_REST_API_KEY', 'YOUR_IMP_REST_API_SECRET');

try {

    // 조회한 결제 정보
    $result = $iamport->request('GET', 'http://api.iamport.kr/API_URI', [
        'body' => [
            // form data
        ],
        'query' => [
            // Query String
        ]
    ]);

} catch (Exception $e) {
    // 예외처리
}
```
응답 유형은 `ResponseInterface` 뿐만 아니라 [Promises/A+ spec](https://promisesaplus.com/)을 구현한 [Guzzle promises library](https://github.com/guzzle/promises) 기반의 `promise` 객체도 지원합니다.

### 비동기 방식 예제
```php
$iamport = new Iamport('YOUR_IMP_REST_API_KEY', 'YOUR_IMP_REST_API_SECRET');

try {

    $promise = $iamport->requestPromise('GET', 'http://api.iamport.kr/API_URI', [
        'body' => [
            // form data
        ]
    ]);

    // ... 비동기 처리

    // 강제완료
    $response = $promise->wait();

    // response Parsing
    $parsedResponse = json_decode($response->getBody());

    // 조회한 결제 정보
    $result = $parsedResponse->response

} catch (Exception $e) {
    // 예외처리
}
```


## Detail

보다 자세한 예제는 [tests/IamportTest.php](tests/IamportTest.php) 를 참조해주세요

## Links
- [아임포트 API](https://api.iamport.kr)
- [아임포트 Docs](https://docs.iamport.kr/)
- [Guzzle Docs](http://docs.guzzlephp.org/en/stable/index.html)

## Changelog

변경사항에 대한 자세한 내용은 [CHANGELOG](CHANGELOG.md)를 참조하십시오.

## License

[MIT License](LICENSE)







