<?php

namespace Iamport\RestClient\Enum\Naver;

use Iamport\RestClient\Enum\Enum;

/**
 * Class CancelReason.
 */
class CancelReason extends Enum
{
    public const PRODUCT_UNSATISFIED = 'PRODUCT_UNSATISFIED';
    public const DELAYED_DELIVERY    = 'DELAYED_DELIVERY';
    public const SOLD_OUT            = 'SOLD_OUT';

    /**
     * Enum의 설명을 가져옵니다.
     *
     * @param string $value
     */
    public static function getDescription($value): ?string
    {
        switch ($value) {
            case self::PRODUCT_UNSATISFIED:
                return '서비스 및 상품 불만족';
            case self::DELAYED_DELIVERY:
                return '배송 지연';
            case self::SOLD_OUT:
                return '상품 품절';
            default:
                return null;
        }
    }
}
