<?php

namespace Iamport\RestClient\Enum;

class Endpoint extends Enum
{
    const API_BASE_URL                = 'https://api.iamport.kr';
    const TOKEN                       = '/users/getToken';
    const PAYMENTS                    = '/payments/';
    const PAYMENTS_PREPARE            = '/payments/prepare';
    const PAYMENTS_STATUS             = '/payments/status/';
    const PAYMENTS_FIND               = '/payments/find/';
    const PAYMENTS_FIND_ALL           = '/payments/findAll/';
    const PAYMENTS_CANCEL             = '/payments/cancel/';
    const CERTIFICATIONS              = '/certifications';
    const CARDS                       = '/cards';
    const BANKS                       = '/banks';
    const ESCROW                      = '/escrows/logis/';
    const KAKAO                       = '/kakao/payment/orders';
    const PAYCO                       = '/payco/orders/status/';
    const SBCR_PAYMENTS_ONETIME       = '/subscribe/payments/onetime/';
    const SBCR_PAYMENTS_AGAIN         = '/subscribe/payments/again/';
    const SBCR_PAYMENTS_SCHEDULE      = '/subscribe/payments/schedule/';
    const SBCR_PAYMENTS_UNSCHEDULE    = '/subscribe/payments/unschedule/';
    const SBCR_CUSTOMERS              = '/subscribe/customers/';
    const RECEIPT                     = '/receipts/';
    const RECEIPT_EXTERNAL            = '/receipts/external/';
    const VBANKS                      = '/vbanks/';
    const VBANKS_HOLDER               = '/vbanks/holder';
}
