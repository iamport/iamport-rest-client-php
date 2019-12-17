<?php

namespace Iamport\RestClient\Enum\Naver;

use Iamport\RestClient\Enum\Enum;

/**
 * Class DeliveryMethod.
 */
class DeliveryMethod extends Enum
{
    public const DELIVERY        = 'DELIVERY';
    public const GDFW_ISSUE_SVC  = 'GDFW_ISSUE_SVC';
    public const VISIT_RECEIPT   = 'VISIT_RECEIPT';
    public const DIRECT_DELIVERY = 'DIRECT_DELIVERY';
    public const QUICK_SVC       = 'QUICK_SVC';
    public const NOTHING         = 'NOTHING';

    /**
     * Enum의 설명을 가져옵니다.
     *
     * @param string $value
     */
    public static function getDescription($value): ?string
    {
        switch ($value) {
            case self::DELIVERY:
                return '택배, 등기, 소포';
            case self::GDFW_ISSUE_SVC:
                return '굿스플로 송장 출력';
            case self::VISIT_RECEIPT:
                return '방문 수령';
            case self::DIRECT_DELIVERY:
                return '직접 전달';
            case self::QUICK_SVC:
                return '퀵서비스';
            case self::NOTHING:
                return '배송 없음';
            default:
                return null;
        }
    }
}
