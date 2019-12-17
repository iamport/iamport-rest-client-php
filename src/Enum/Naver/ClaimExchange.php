<?php

namespace Iamport\RestClient\Enum\Naver;

use Iamport\RestClient\Enum\Enum;

/**
 * Class Endpoint.
 */
class ClaimExchange extends Enum
{
    public const EXCHANGE_REQUEST      = 'EXCHANGE_REQUEST';
    public const COLLECTING            = 'COLLECTING';
    public const COLLECT_DONE          = 'COLLECT_DONE';
    public const EXCHANGE_REDELIVERING = 'EXCHANGE_REDELIVERING';
    public const EXCHANGE_DONE         = 'EXCHANGE_DONE';
    public const EXCHANGE_REJECT       = 'EXCHANGE_REJECT';

    /**
     * Enum의 설명을 가져옵니다.
     *
     * @param string $value
     */
    public static function getDescription($value): ?string
    {
        switch ($value) {
            case self::EXCHANGE_REQUEST:
                return '교환 요청';
            case self::COLLECTING:
                return '수거 처리 중';
            case self::COLLECT_DONE:
                return '수거 완료(교환)';
            case self::EXCHANGE_REDELIVERING:
                return '교환 재배송 중';
            case self::EXCHANGE_DONE:
                return '교환 완료';
            case self::EXCHANGE_REJECT:
                return '교환 거부';
            default:
                return null;
        }
    }
}
