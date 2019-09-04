<?php

namespace Iamport\RestClient\Enum;

use Iamport\RestClient\Libraries\Enum;

class ApiType extends Enum
{
    //const API_BASE_URL                = 'https://api.iamport.kr';
    const API_BASE_URL                = 'http://cake.test:81';
    const GET_TOKEN                   = '/users/getToken';
    const GET_PAYMENT                 = '/payments/';
    const FIND_PAYMENT                = '/payments/find/';
    const FIND_ALL_PAYMENT            = '/payments/findAll/';
    const CANCEL_PAYMENT              = '/payments/cancel/';
    const SBCR_ONETIME_PAYMENT        = '/subscribe/payments/onetime/';
    const SBCR_AGAIN_PAYMENT          = '/subscribe/payments/again/';
    const SBCR_SCHEDULE_PAYMENT       = '/subscribe/payments/schedule/';
    const SBCR_UNSCHEDULE_PAYMENT     = '/subscribe/payments/unschedule/';
    const SBCR_CUSTOMERS              = '/subscribe/customers/';
    const RECEIPT                     = '/receipts/';

    /**
     * Enum의 설명을 가져옵니다.
     *
     * @param int $value
     *
     * @return string
     */
    public static function getDescription($value)
    {
        switch ($value) {
            case self::API_BASE_URL:
                return 'API Base URL';
            case self::GET_TOKEN:
                return 'REST API사용을 위한 Access token 발급';
            case self::GET_PAYMENT:
                return '여러 개의 아임포트 고유번호로 결제내역을 한 번에 조회합니다';
            case self::FIND_PAYMENT:
                return 'GET /payments/find/{merchant_uid}/{payment_status} 가맹점지정 고유번호로 결제내역을 확인합니다';
            case self::FIND_ALL_PAYMENT:
                return '가맹점지정 고유번호로 결제내역을 확인합니다';
            case self::CANCEL_PAYMENT:
                return '승인된 결제를 취소합니다.';
            case self::SBCR_ONETIME_PAYMENT:
                return '저장된 빌링키로 비인증 결제를 수행합니다.';
            case self::SBCR_AGAIN_PAYMENT:
                return '저장된 빌링키로 비인증 재결제를 수행합니다.';
            case self::SBCR_SCHEDULE_PAYMENT:
                return '비인증 결체요청을 예약합니다.';
            case self::SBCR_UNSCHEDULE_PAYMENT:
                return '비인증 결체요청 예약을 취소합니다.';
            case self::SBCR_CUSTOMERS:
                return 'Subscribe 확장기능. 구매자 빌링키 관리';
            case self::RECEIPT:
                return '현금영수증 발급/관리';
            default:
                return null;
        }
    }
}
