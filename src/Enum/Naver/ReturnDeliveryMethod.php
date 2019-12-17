<?php

namespace Iamport\RestClient\Enum\Naver;

use Iamport\RestClient\Enum\Enum;

/**
 * Class ReturnDeliveryMethod.
 */
class ReturnDeliveryMethod extends Enum
{
    public const RETURN_DESIGNATED   = 'RETURN_DESIGNATED';
    public const RETURN_DELIVERY     = 'RETURN_DELIVERY';
    public const RETURN_INDIVIDUAL   = 'RETURN_INDIVIDUAL';

    /**
     * Enum의 설명을 가져옵니다.
     *
     * @param string $value
     */
    public static function getDescription($value): ?string
    {
        switch ($value) {
            case self::RETURN_DESIGNATED:
                return '지정 반품 택배';
            case self::RETURN_DELIVERY:
                return '일반 반품 택배';
            case self::RETURN_INDIVIDUAL:
                return '직접 반송';
            default:
                return null;
        }
    }
}
