<?php

namespace Iamport\RestClient\Enum;

/**
 * Class Endpoint.
 */
class Endpoint extends Enum
{
    public const API_BASE_URL             = 'https://api.iamport.kr';
    public const TOKEN                    = '/users/getToken';
    public const PAYMENTS                 = '/payments/';
    public const BALANCE                  = '/balance';
    public const PAYMENTS_PREPARE         = '/payments/prepare';
    public const PAYMENTS_STATUS          = '/payments/status/';
    public const PAYMENTS_FIND            = '/payments/find/';
    public const PAYMENTS_FIND_ALL        = '/payments/findAll/';
    public const PAYMENTS_CANCEL          = '/payments/cancel/';
    public const CERTIFICATIONS           = '/certifications/';
    public const CARDS                    = '/cards';
    public const BANKS                    = '/banks';
    public const ESCROW                   = '/escrows/logis/';
    public const KAKAO                    = '/kakao/payment/orders';
    public const PAYCO                    = '/payco/orders/status/';
    public const SBCR_PAYMENTS_ONETIME    = '/subscribe/payments/onetime/';
    public const SBCR_PAYMENTS_AGAIN      = '/subscribe/payments/again/';
    public const SBCR_PAYMENTS_SCHEDULE   = '/subscribe/payments/schedule/';
    public const SBCR_PAYMENTS_UNSCHEDULE = '/subscribe/payments/unschedule/';
    public const SCHEDULES                = '/schedules';
    public const SBCR_CUSTOMERS           = '/subscribe/customers';
    public const RECEIPT                  = '/receipts/';
    public const RECEIPT_EXTERNAL         = '/receipts/external/';
    public const VBANKS                   = '/vbanks';
    public const VBANKS_HOLDER            = '/vbanks/holder';
    public const NAVER_PRODUCT_ORDERS     = '/naver/product-orders';
    public const NAVER_CASH_AMOUNT        = '/naver/cash-amount';
    public const NAVER_REVIEWS            = '/naver/reviews';
    public const NAVER_CANCEL             = '/naver/cancel';
    public const NAVER_SHIP               = '/naver/ship';
    public const NAVER_SHIP_EXCHANGED     = '/naver/ship-exchanged';
    public const NAVER_PLACE              = '/naver/place';
    public const NAVER_REQUEST_RETURN     = '/naver/request-return';
    public const NAVER_APPROVE_RETURN     = '/naver/approve-return';
    public const NAVER_REJECT_RETURN      = '/naver/reject-return';
    public const NAVER_WITHHOLD_RETURN    = '/naver/withhold-return';
    public const NAVER_RESOLVE_RETURN     = '/naver/resolve-return';
    public const NAVER_POINT              = '/naver/point';
    public const NAVER_CONFIRM            = '/naver/confirm';
}
