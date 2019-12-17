<?php

namespace Iamport\RestClient\Enum\Naver;

use Iamport\RestClient\Enum\Enum;

/**
 * Class Endpoint.
 */
class ClaimPurchaseDecisionHoldback extends Enum
{
    public const PURCHASE_DECISION_HOLDBACK              = 'PURCHASE_DECISION_HOLDBACK';
    public const PURCHASE_DECISION_HOLDBACK_REDELIVERING = 'PURCHASE_DECISION_HOLDBACK_REDELIVERING';
    public const PURCHASE_DECISION_REQUEST               = 'PURCHASE_DECISION_REQUEST';
    public const PURCHASE_DECISION_HOLDBACK_RELEASE      = 'PURCHASE_DECISION_HOLDBACK_RELEASE';

    /**
     * Enum의 설명을 가져옵니다.
     *
     * @param string $value
     */
    public static function getDescription($value): ?string
    {
        switch ($value) {
            case self::PURCHASE_DECISION_HOLDBACK:
                return '구매 확정 보류';
            case self::PURCHASE_DECISION_HOLDBACK_REDELIVERING:
                return '구매 확정 보류 재배송 중';
            case self::PURCHASE_DECISION_REQUEST:
                return '구매 확정 요청';
            case self::PURCHASE_DECISION_HOLDBACK_RELEASE:
                return '구매 확정 보류 해제';
            default:
                return null;
        }
    }
}
