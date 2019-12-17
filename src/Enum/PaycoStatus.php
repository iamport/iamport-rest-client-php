<?php

namespace Iamport\RestClient\Enum;

/**
 * Class PaycoStatus.
 */
class PaycoStatus extends Enum
{
    public const DELIVERY_START    = 'DELIVERY_START';
    public const PURCHASE_DECISION = 'PURCHASE_DECISION';
    public const CANCELED          = 'CANCELED';

    /**
     * Enum의 설명을 가져옵니다.
     */
    public static function getDescription(string $value): string
    {
        switch ($value) {
            case self::DELIVERY_START:
                return '배송시작-출고지시';
            case self::PURCHASE_DECISION:
                return '구매확정';
            case self::CANCELED:
                return '취소';
            default:
                return '';
        }
    }
}
