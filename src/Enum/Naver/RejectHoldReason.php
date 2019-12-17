<?php

namespace Iamport\RestClient\Enum\Naver;

use Iamport\RestClient\Enum\Enum;

/**
 * Class ReturnReason.
 */
class RejectHoldReason extends Enum
{
    public const RETURN_DELIVERYFEE                       = 'RETURN_DELIVERYFEE';
    public const EXTRAFEEE                                = 'EXTRAFEEE';
    public const RETURN_DELIVERYFEE_AND_EXTRAFEEE         = 'RETURN_DELIVERYFEE_AND_EXTRAFEEE';
    public const RETURN_PRODUCT_NOT_DELIVERED             = 'RETURN_PRODUCT_NOT_DELIVERED';
    public const ETC                                      = 'ETC';

    /**
     * Enum의 설명을 가져옵니다.
     *
     * @param string $value
     */
    public static function getDescription($value): ?string
    {
        switch ($value) {
            case self::RETURN_DELIVERYFEE:
                return '반품 배송비 청구';
            case self::EXTRAFEEE:
                return '기타 반품 비용 청구';
            case self::RETURN_DELIVERYFEE_AND_EXTRAFEEE:
                return '반품 배송비 및 기타 반품 비용 청구';
            case self::RETURN_PRODUCT_NOT_DELIVERED:
                return '반품 상품 미입고';
            case self::ETC:
                return '기타 사유';
            default:
                return null;
        }
    }
}
