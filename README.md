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

## Quick start

### Iamport

- `callApi(Request)` - 성공/실패 여부와 무관하게 일관된 결과를 제공합니다.
- `callApiPromise(Request)` - 성공시 promise객체를 반환합니다. 
- `request(method, uri, attributes, authenticated, $client)` - api 호출 응답을 반환합니다.
- `requestPromise(method, uri, attributes, authenticated, $client)` - 비동기 호출을 통해 promise 객체를 반환합니다. 
- `requestAccessToken()` - 액세스 토큰을 발급합니다.
- `getCustomHttpClient(HandlerStack)` - guzzle 클라이언트의 handler를 직접 생성하고 싶을 경우 호출합니다.


### Requset 
Request 객체는 `API Endpoint`, `Http verb`, `request(form_data, query_string)` 데이터들이 미리 정의되어 있으며,

필수값을 인자로 넘겨 객체를 생성하면 자동으로 `API` 통신을 위한 데이터들을 설정해 주며,

IDE를 사용할 경우 **타입 체크**, **값의 존재 여부**, **자동완성** 등의 지원을 받을 수 있습니다.


#### 제공되는 Request 객체 목록
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

### Result

`callApi()`를 사용할 경우 최종적으로 통신의 성공/실패 유무와 무관하게 아래와 같이 일관된 구조의 `Result` 객체를 반환합니다.

```javascript
Result {
    success: 성공/실패유무 (boolean)
    data : 응답 데이터 (Requset 객체)
    error : 에러정보
}
```
`getSuccess()`, `getData()`, `getError()` 메소드를 통해 각각의 값에 접근 가능하며,
data에는 `Response`객체가 담기고 error에는 Rest Api 서버가 제공하는 에러 정보및 추적을 위한 원본 Exception 객체를 반환합니다.  

```php
// 성공 예시
Result {
  success: true
  data : Payment {
    imp_uid: "imp_1234567"
    merchant_uid : "merchant_1234"
    // .. 생략
  }
  error : null
}

// 에러 예시
Result {
  success: false
  data : null
  error : {
    "code": -1
    "message": "존재하지 않는 결제정보입니다."
    "previous": IamportException {
      request : Request {}
      response: Response {}
      handlerContext: {}
      message: "존재하지 않는 결제 정보입니다."
      code: 404,
      // .. 생략         
    }
  } 
}
``` 

### Usage

#### `callApi()`

내부적으로 직접 호출 방식인 `request()`메소드를 호출하며,
편의를 위해 request 객체만 인자로 넘기면 일관된 결과물을 제공합니다. 

```php
$iamport = new Iamport('YOUR_IMP_REST_API_KEY', 'YOUR_IMP_REST_API_SECRET');

$payment = Payment::getImpUid('imps_410064014595');

$result = $iamport->callApi($payment);

if ($result->getSuccess()) {

    // 조회한 결제 정보
    $payment_data = $result->getData();

    // __get을 통해 API의 Response Model의 값들을 모두 property처럼 접근할 수 있습니다.
    // https://api.iamport.kr/#!/payments/getPaymentByImpUid 의 Response Model.
    $imp_uid = $payment_data->imp_uid;
    
    // Response 객체에서 편의를 위해 자체적으로 변환해주는 값들의 경우 ( ex: Unix timestamp -> Y-m-d H:is )
    // 변환값이 아닌 원본 property 접근은 getAttributes()를 사용합니다.
    $paid_at = $payment_data->paid_at;
    $original_paid_at = $payment->getAttributes('paid_at');

    if ( 결제검증 로직 ) {
        // 결제 성공 처리
    } else {
        // 결제 실패 처리
    }
} else {
    error_log($result->getError());
}
```

#### `callApiPromise()`
`ResponseInterface` 응답 유형이 아닌 [Promises/A+ spec](https://promisesaplus.com/)을 구현한 

[Guzzle promises library](https://github.com/guzzle/promises) 기반의 `promise` 객체도 지원합니다.

에러가 발생할 경우에는 Result 구조체를 반환하며, 성공시에는 promise 객체를 반환합니다.

```php
$iamport = new Iamport('YOUR_IMP_REST_API_KEY', 'YOUR_IMP_REST_API_SECRET');

try {

    $payment = Payment::getImpUid('imps_410064014595');
    
    $promise = $iamport->callApiPromise($payment);

    $promise->then(
        function (ResponseInterface $res) {
            // 성공시 로직
        },
        function (RequestException $e) {
            // 실패 로직
        }
    );

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

#### `request()`

`callApi()`를 사용하지 않고 `request()`를 통해 직접 요청을 생성할 수 있습니다.

단 `Exception`의 `catch`처리는 직접 구현해야 합니다.

세번째 인자인 request의 옵션은 [Guzzle 문서](http://docs.guzzlephp.org/en/stable/request-options.html)를 참고하여 규격에 맞게 전송해야 하며,

응답 유형은 `Psr\Http\Message\ResponseInterface` 입니다.

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

#### `getCustomHttpClient()`

`callApi()`, `callApiPromise()`, `request()`, `requestPromise()` 사용시 기본적으로 middleware를 통해
`Content-Type`, `Accept`, `Authorization` 등의 값을 자동으로 셋팅해 주지만 이를 사용자화 하거나 확장하고 싶을 경우  
guzzle clinet를 직접 생성하여 사용할 수 있습니다.

> 가령, 서버가 여러대일경우 access token을 현재 client 서버가 아닌 공통된 저장소(redis등)에 저장한다거나 할때 위와 같이 client를 직접생성 하여 사용합니다.

`handler`와 `middleware` 관한 자세한 내용은 [guzzle 공식문서](http://docs.guzzlephp.org/en/stable/handlers-and-middleware.html)를 참고하여 작성합니다.

```php
$stack = HandlerStack::create();

// client stack에 추가할 기능들 구현
$stack->push(new CustomMiddleware());
$stack->push(new CustomTokenMiddleware());

$client = $iamport->getCustomHttpClient($stack);

// Request에 client 설정
$payment = Payment::getImpUid(imp_uid);
$payment->setClient($client);
$result = $iamport->callApi($payment);

// 직접호출시 client 설정
$result = $iamport->request(
    'GET',
    'https://https://api.iamport.kr/{API_URI}',
    [
        'body' => [
            // form data
        ],
        'query' => [
            // Query String
        ]
    ],
    true,
    $client
);

```


## Detail

보다 자세한 예제는 [테스트 코드 - tests/IamportTest.php](tests/IamportTest.php) 혹은 [샘플코드 - example/example.php](tests/IamportTest.php)를 참조해주세요

## Links
- [아임포트 API](https://api.iamport.kr)
- [아임포트 Docs](https://docs.iamport.kr/)
- [Guzzle Docs](http://docs.guzzlephp.org/en/stable/index.html)

## Changelog

변경사항에 대한 자세한 내용은 [CHANGELOG](CHANGELOG.md)를 참조하십시오.

## License

[MIT License](LICENSE)







