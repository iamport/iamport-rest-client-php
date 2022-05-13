<?php

namespace Iamport\RestClient\Enum\Naver;

use Iamport\RestClient\Enum\Enum;

/**
 * Class CancelPaymentRequester.
 */
class CancelPaymentRequester extends Enum
{
    public const CUSTOMER = 'customer';
    public const ADMIN    = 'admin';


    /**
     * Enum의 설명을 가져옵니다.
     *
     * @param string $value
     */
    public static function getDescription($value): ?string
    {
        switch ($value) {
            case self::CUSTOMER:
                return '구매자';
            case self::ADMIN:
                return '가맹점 관리자';
            default:
                return null;
        }
    }
}
