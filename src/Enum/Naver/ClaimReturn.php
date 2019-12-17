<?php

namespace Iamport\RestClient\Enum\Naver;

use Iamport\RestClient\Enum\Enum;

/**
 * Class Endpoint.
 */
class ClaimReturn extends Enum
{
    public const RETURN_REQUEST = 'RETURN_REQUEST';
    public const COLLECTING     = 'COLLECTING';
    public const COLLECT_DONE   = 'COLLECT_DONE';
    public const RETURN_DONE    = 'RETURN_DONE';
    public const RETURN_REJECT  = 'RETURN_REJECT';

    /**
     * Enum의 설명을 가져옵니다.
     *
     * @param string $value
     */
    public static function getDescription($value): ?string
    {
        switch ($value) {
            case self::RETURN_REQUEST:
                return '반품 요청';
            case self::COLLECTING:
                return '수거 처리 중';
            case self::COLLECT_DONE:
                return '수거 완료';
            case self::RETURN_DONE:
                return '반품 완료';
            case self::RETURN_REJECT:
                return '반품 철회';
            default:
                return null;
        }
    }
}
