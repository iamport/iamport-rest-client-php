# iamport-rest-client-php

PHP사용자를 위한 아임포트 REST API 연동 모듈입니다

- [guzzle](http://docs.guzzlephp.org/en/stable/)을 기반으로 만들어진 버전
- composer 패키지 형태로 제공

기존의 PHP 5.X 버전의 연동모듈은 [1.0 branch](https://github.com/iamport/iamport-rest-client-php/tree/1.0)를 참고해주세요.

## Required
- PHP 7.1 버전 이상을 요구합니다.

## Quick start

### Iamport

- `callApi(Request)` - 성공/실패 일관된 결과를 제공합니다.
- `callApiPromise(Request)` - 성공시 promise객체를 반환합니다. 
- `request(method, uri, attributes, $client)` - api 호출 응답을 반환합니다.
- `requestPromise(method, uri, attributes, $client)` - 비동기 호출을 통해 promise 객체를 반환합니다. 
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
    - [Payment::withImpUid()](https://api.iamport.kr/#!/payments/getPaymentByImpUid)
    - [Payment::withMerchantUid()](https://api.iamport.kr/#!/payments/getPaymentByMerchantUid)
    - [Payment::listMerchantUid()](https://api.iamport.kr/#!/payments/getAllPaymentsByMerchantUid)
    - [Payment::listImpUid()](https://api.iamport.kr/#!/payments/getPaymentListByImpUid)
    - [Payment::balance()](https://api.iamport.kr/#!/payments/balanceByImpUid)
    - [Payment::listStatus()](https://api.iamport.kr/#!/payments/getPaymentsByStatus)
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
- SubscribeInquiry
    - [SubscribeInquiry::withMerchantUid()](https://api.iamport.kr/#!/subscribe/getScheduleByMid)    
    - [SubscribeInquiry::withCustomerUid()](https://api.iamport.kr/#!/subscribe/findSchedulesByCustomer)    

**결제 사전정보 등록&검증 API**
- PaymentPrepare
    - [PaymentPrepare::view()](https://api.iamport.kr/#!/payments.validation/getPaymentPrepareByMerchantUid)
    - [PaymentPrepare::store()](https://api.iamport.kr/#!/payments.validation/preparePayment)

**비인증 결제 빌링키 관리 API**
- SubscribeCustomer
    - [SubscribeCustomer::view()](https://api.iamport.kr/#!/subscribe.customer/customer_view)
    - [SubscribeCustomer::issue()](https://api.iamport.kr/#!/subscribe.customer/customer_save)
    - [SubscribeCustomer::delete()](https://api.iamport.kr/#!/subscribe.customer/customer_delete)
    - [SubscribeCustomer::list()](https://api.iamport.kr/#!/subscribe.customer/customer_view_multiple)
    - [SubscribeCustomer::payments()](https://api.iamport.kr/#!/subscribe.customer/customer_payments)
    - [SubscribeCustomer::schedules()](https://api.iamport.kr/#!/subscribe.customer/findSchedulesByCustomer)

**카카오페이 전용 API**
- Kakaopay
    - [Kakaopay()](https://api.iamport.kr/#!/kakao/getOrders)

**PAYCO 전용 API**
- Payco
    - [Payco()](https://api.iamport.kr/#!/payco/changeOrderStatus)    
    
**네이버페이 전용 API**
- NaverInquiry
    - [NaverInquiry::single()](https://api.iamport.kr/#!/naver/getProductOrderSingle)
    - [NaverInquiry::list()](https://api.iamport.kr/#!/naver/getProductOrders)
    - [NaverInquiry::reviews()](https://api.iamport.kr/#!/naver/getReviews)
    - [NaverInquiry::cashAmount()](https://api.iamport.kr/#!/naver/queryCashAmount)
    
- NaverOrder
    - [NaverOrder::cancel()](https://api.iamport.kr/#!/naver/naverCancelProductOrder)
    - [NaverOrder::ship()](https://api.iamport.kr/#!/naver/naverShipProductOrder)
    - [NaverOrder::shipExchange()](https://api.iamport.kr/#!/naver/naverShipProductOrder_0)
    - [NaverOrder::place()](https://api.iamport.kr/#!/naver/naverPlaceProductOrder)

- NaverPayment
    - [NaverPayment::point()](https://api.iamport.kr/#!/naver/naverDepositPoint)
    - [NaverPayment::confirm()](https://api.iamport.kr/#!/naver/naverConfirmPayment)

- NaverReturn
    - [NaverPayment::request()](https://api.iamport.kr/#!/naver/naverRequestReturnProductOrder)
    - [NaverPayment::approve()](https://api.iamport.kr/#!/naver/naverApproveReturnProductOrder)
    - [NaverPayment::reject()](https://api.iamport.kr/#!/naver/naverRejectReturnProductOrder)
    - [NaverPayment::withhold()](https://api.iamport.kr/#!/naver/naverWithholdReturnProductOrder)
    - [NaverPayment::resolve()](https://api.iamport.kr/#!/naver/naverResolveReturnProductOrder)

**현금영수증 발급/관리 API**
- Receipt
    - [Receipt::view()](https://api.iamport.kr/#!/receipts/getReceipt)
    - [Receipt::issue()](https://api.iamport.kr/#!/receipts/issueReceipt)
    - [Receipt::cancel()](https://api.iamport.kr/#!/receipts/revokeReceipt)
    - [Receipt::viewExternal()](https://api.iamport.kr/#!/receipts/getExternalReceipt)
    - [Receipt::issueExternal()](https://api.iamport.kr/#!/receipts/issueExternalReceipt)
    - [Receipt::cancelExternal()](https://api.iamport.kr/#!/receipts/revokeExternalReceipt)
    
**가상계좌 관리 API**
- Vbank
    - [Vbank::view()](https://api.iamport.kr/#!/vbanks/queryBankHolder)
    - [Vbank::store()](https://api.iamport.kr/#!/vbanks/createVbank)
    - [Vbank::delete()](https://api.iamport.kr/#!/vbanks/revokeVbank)
    - [Vbank::edit()](https://api.iamport.kr/#!/vbanks/modifyVbank)
    
**카드사/은행정보 API**
- Code
    - [Code::cards()](https://api.iamport.kr/#!/codes/allCardCodes)    
    - [Code::card()](https://api.iamport.kr/#!/codes/cardCodes)    
    - [Code::banks()](https://api.iamport.kr/#!/codes/allBankCodes)    
    - [Code::bank()](https://api.iamport.kr/#!/codes/bankCodes)    

### Result

`callApi()`를 사용할 경우 최종적으로 통신의 성공/실패 유무와 무관하게 아래와 같이 일관된 구조의 `Result` 객체를 반환합니다.

```html
Result {
    data : 응답 데이터 (Requset 객체)
    error : 에러정보
}
```
`isSuccess()`메소드르로애 API 호출 성공여부를 알 수 있으며, `getData()`, `getError()` 메소드를 통해 각각의 값에 접근 가능합니다.
data에는 `Response`객체가 담기고 error에는 Rest Api 서버가 제공하는 에러 정보및 추적을 위한 원본 Exception 객체를 반환합니다.  

```php
// 성공 예시
Result {
  data : Payment {
    imp_uid: "imp_1234567"
    merchant_uid : "merchant_1234"
    // .. 생략
  }
  error : null
}

// 에러 예시
Result {
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

if ($result->isSuccess()) {

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

### Enum
배송방법코드, 택배사코드, 은행코드 등의 값들을 위한 `Enum` 클래스를 제공합니다.

#### Enum 클래스에서 제공하는 메소드
| method | 설명 |
|--------|------|
| `getAll()` | Enum에 정의된 모든 상수의 키와 값을 반환합니다.  |
| `getValues()` | Enum에 정의된 모든 상수의 값을 반환합니다.   |
| `getValue($key)` | Enum에 정의된 상수의 값을 키로 조회합니다. |
| `getKey($value)` | Enum에 정의된 상수의 키를 값으로 조회합니다.  |
| `getDescription($value)` | Enum에 정의된 값의 설명을 반환합니다.  |
| `validation($value)` | Enum에 속한 값인지 체크합니다.  |

#### 제공하는 Enum 클래스 목록
- `BankCode` - 가상계좌 조회시 은행코드(금융결제원 표준코드3자리)
- `VbankCode` - 가상계좌 발급시 허용가능한 은행코드(금융결제원 표준코드3자리)
- `PaycoStatus` - Payco 주문상품의 상태 변경시 사용하는 상태
- `PaymentSort` - 결제내역 조회시 정렬
- `Naver` - 네이버페이 관련
    - `CancelReason` - 상품주문들을 환불처리할때 취소사유코드
    - `OrderStatus` - 상품 주문 상태
    - `ClaimType` - 상품주문관련 클레임 유형
    - `ClaimCancel` - 클레임 유형이 **취소**일때의 상태
    - `ClaimReturn` - 클레임 유형이 **반품**일때의 상태
    - `ClaimExchange` - 클레임 유형이 **교환**일때의 상태
    - `ClaimPurchaseDecisionHoldback` - 클레임 유형이 **구매 확정 보류**일때의 상태
    - `ClaimAdminCancel` - 클레임 유형이 **직권 취소**일때의 상태
    - `DeliveryMethod` - 배송방법 코드
    - `DeliveryCompany` - 배송방법코드가 **택배,등기,소포**일때 사용하는 택배사코드
    - `ReturnDeliveryMethod` - 반품요청시 반품 사유 코드
    - `ReturnReason` - 반품요청시 반품 배송방법 코드
    - `RejectHoldReason` - 반품보류처리시 반품 보류 사유 코드

### Mutator & Accessor 
`Requset`와 `Response`객체를 사용할경우 인스턴스 변수에 직접 접근하지 않고
`Accessor`, `Mutator` 메소드를 통해 값을 가져오거나 설정합니다. 
이 중 날짜와 배송방법코드, 은행코드 등의 변환이 필요한 값들은 자동으로 변환하여 가져오거나 설정합니다.

#### Mutator
보통 `Setter`라고도 불리며 `Requset`객체에 값을 설정합니다.

예를 들어 `Payment::list()`의 `from`, `to` 값은 `unix timestamp`로 전달해야 하지만 아래와 같이 `DateTime` 객체로
 전달하면 `Payment Requset` 객체의 `Mutator`가 해당값을 `timestamp`로 변환하여 값을 전달합니다.
```php
$requset = Payment::list('paid');
$request->to = new DateTime('2019-12-01 09:25:00');
```
이러한 변경과정을 커스터마이징 하고 싶다면 Requset 객체의 Mutator 메소드를 오버라이드 하여 사용합니다.

#### Accessor
보통 `Getter`라고도 불리며 `Response` 객체의 값을 가져옵니다.
`$response->{변수명}`처럼 일반적인 방법으로 값에 접근할 경우 변환된 값이 출력되며,
원본 값이 필요한 경우에는 `$response->getAttributes({변수명})` 메소드를 사용하면 변환되지 않은 값에 접근 가능합니다.  

```php
$request = NaverInquiry::single('201901');
$response = $iamport->callApi($request);
$data = $response->getData();

# 변환된 값 출력
echo $data->product_order_status;   // 취소 완료
echo $data->shipping_due;           // 2018-08-23 23:59:59

# 원본 값 출력   
echo $data->getAttributes('product_order_status');  // CANCELED_BY_NOPAYMENT
echo $data->getAttributes('shipping_due');          // 1535036399
```

### 207 Response
몇몇 API들은 여러개의 응답결과중 일부만 실패하는 경우 오류가 아닌 207 응답이 발생합니다.

예를 들어 아래와 같이 3건의 결제내역을 요청했을때 1개의 imp_uid 결제내역만 조회에 실패했을 경우
4xx, 5xx 등의 에러코드가 아닌 성공한 2건의 결제내역만 응답받기 때문에 실패건을 감지하지 못하고 후속처리 과정에서
실수가 발생할 여지가 있습니다.
 
```php
Payment:listImpUid([
    'imp_uid1',     
    'imp_uid2', 
    'wrong_imp_uid', // 잘못된 imp_uid
]);

// API 호출 과정 생략..

// 응답결과
Collection {
  items: array:2 [
    0 => Payment {
      imp_uid: "imp_uid1"
      .. 생략
    }
    1 => Payment {
      imp_uid: "imp_uid2"  
    }
  ]
}

```

특히 단순 조회가 아닌 네이버페이의 상품 발송처리와 같은 로직을 실행할경우에 가맹점은 
실패한건에 대해 재시도를 해야하는 등의 추가처리가 필요합니다.

이러한 과정의 편의를 돕기 위해 `Collection` 객체는 207 응답이 발생하는경우 아래와 같이 실패건에 관한 데이터를 전달하며,
`Collection`의 `getFailed()` 메소드를 통해 얻을 수 있습니다. 

```php
Collection {
  items: array:2 [
    0 => Payment {
      imp_uid: "imp_uid1"
      .. 생략
    }
    1 => Payment {
      imp_uid: "imp_uid2"
      .. 생략
    }
  ],
  failed: array:1 [
    0 => "wrong_imp_uid"
  ]
}

$data = $response->getData();

// 성공한 응답데이터 출력
echo $data->getItems());

// 실패한 건의 고유 ID 목록
echo $data->getFailed());
```

> 207 응답을 지원하는 Response 목록과 실패시 돌려주는 고유값은 다음과 같습니다.

- Payment : imp_uid
- SubscribeCustomer : customer_uid
- NaverProductOrder : product_order_id
 

### next() & previous()

Paged 형태로 제공되는 `Collection`인 경우 limit값이 존재하여 다른 page를 조회하려면
page 변수를 새로 할당하여 다시 API 통신을 해야 합니다.

이러한 번거로움을 해결하기 위해 이전, 다음 데이터를 손쉽게 가져올 수 있는 `next()`, `previous()`메소드를 제공합니다.
이전, 다음 데이터가 존재하지 않을 경우엔 `null`을 반환합니다.

```php
$iamport = new Iamport($impKey, $impSecret);

$request = Payment::listMerchantUid('merchant_uid');
$response = $iamport->callApi($request);
$data = $response->getData();

// 다른 page 데이터 조회
$request->page = 2
$response = $iamport->callApi($request);
$nextData = $response->getData();

// next(), previous()를 이용한 조회
$previousData = $data->previous($iamport);
$nextData = $data->next($iamport);
```

## Example

보다 자세한 예제는 [테스트 코드 - tests](tests/) 혹은 [샘플코드](example)를 참조해주세요

## Testing

```bash
composer test
```
![composer test](./tests/composer-test.gif)

## Links
- [아임포트 API](https://api.iamport.kr)
- [아임포트 Docs](https://docs.iamport.kr/)
- [Guzzle Docs](http://docs.guzzlephp.org/en/stable/index.html)
- [구버전 Link](https://github.com/iamport/iamport-rest-client-php/tree/1.0)

## Changelog

변경사항에 대한 자세한 내용은 [CHANGELOG](CHANGELOG.md)를 참조하십시오.

## License

[MIT License](LICENSE)





