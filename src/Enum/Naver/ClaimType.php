<?php

namespace Iamport\RestClient\Enum\Naver;

use Iamport\RestClient\Enum\Enum;

/**
 * Class Endpoint.
 */
class ClaimType extends Enum
{
    public const CANCEL                     = 'CANCEL';
    public const RETURN                     = 'RETURN';
    public const EXCHANGE                   = 'EXCHANGE';
    public const PURCHASE_DECISION_HOLDBACK = 'PURCHASE_DECISION_HOLDBACK';
    public const ADMIN_CANCEL               = 'ADMIN_CANCEL';

    /**
     * Enum의 설명을 가져옵니다.
     *
     * @param string $value
     */
    public static function getDescription($value): ?string
    {
        switch ($value) {
            case self::CANCEL:
                return '취소';
            case self::RETURN:
                return '반품';
            case self::EXCHANGE:
                return '교환';
            case self::PURCHASE_DECISION_HOLDBACK:
                return '구매 확정 보류';
            case self::ADMIN_CANCEL:
                return '직권 취소';
            default:
                return null;
        }
    }
}
