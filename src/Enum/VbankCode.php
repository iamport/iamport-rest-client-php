<?php

namespace Iamport\RestClient\Enum;

/**
 * Class VbankCode.
 */
class VbankCode extends Enum
{
    public const IBK      = '003';
    public const KB       = '004';
    public const KEB      = '005';
    public const NH       = '011';
    public const WOORI    = '020';
    public const SC       = '023';
    public const CITY     = '027';
    public const DAEGU    = '031';
    public const KYUNGNAM = '039';
    public const BUSAN    = '032';
    public const GWANGJU  = '034';
    public const POST     = '071';
    public const SHINHAN  = '088';

    /**
     * Enum의 설명을 가져옵니다.
     *
     * @param string $value
     */
    public static function getDescription($value): ?string
    {
        switch ($value) {
            case self::IBK:
                return '기업은행';
            case self::KB:
                return '국민은행';
            case self::KEB:
                return 'KEB 하나은행';
            case self::NH:
                return '농협중앙회';
            case self::WOORI:
                return '우리은행';
            case self::SC:
                return 'SC 제일은행';
            case self::CITY:
                return '한국씨티은행';
            case self::DAEGU:
                return '대구은행';
            case self::KYUNGNAM:
                return '경남은행';
            case self::BUSAN:
                return '부산은행';
            case self::GWANGJU:
                return '광주은행';
            case self::POST:
                return '정보통신부 우체국';
            case self::SHINHAN:
                return '신한은행';
            default:
                return null;
        }
    }
}
