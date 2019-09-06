<?php

namespace Iamport\RestClient\Enum;

class Endpoint extends Enum
{
    //const API_BASE_URL                = 'https://api.iamport.kr';
    const API_BASE_URL                 = 'http://cake.test:81';
    const TOKEN                        = '/users/getToken';
    const PAYMENTS                     = '/payments/';
    const PAYMENTS_FIND                = '/payments/find/';
    const PAYMENTS_FIND_ALL            = '/payments/findAll/';
    const PAYMENTS_CANCEL              = '/payments/cancel/';
    const SBCR_PAYMENTS_ONETIME        = '/subscribe/payments/onetime/';
    const SBCR_PAYMENTS_AGAIN          = '/subscribe/payments/again/';
    const SBCR_PAYMENTS_SCHEDULE       = '/subscribe/payments/schedule/';
    const SBCR_PAYMENTS_UNSCHEDULE     = '/subscribe/payments/unschedule/';
    const SBCR_CUSTOMERS               = '/subscribe/customers/';
    const RECEIPT                      = '/receipts/';

}
