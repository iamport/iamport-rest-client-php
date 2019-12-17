<?php

namespace Iamport\RestClient\Enum;

/**
 * Class BankCode.
 */
class BankCode extends Enum
{
    public const KB             = '004';
    public const SC             = '023';
    public const KYUNGNAM       = '039';
    public const GWANGJU        = '034';
    public const IBK            = '003';
    public const NH             = '011';
    public const DAEGU          = '031';
    public const BUSAN          = '032';
    public const KDB            = '002';
    public const SUHYUP         = '007';
    public const SHINHAN        = '088';
    public const CU             = '048';
    public const EXCHANGE       = '005';
    public const WOORI          = '020';
    public const POST           = '071';
    public const JEONBUK        = '037';
    public const JEJU           = '035';
    public const CH             = '012';
    public const KEB            = '081';
    public const CITY           = '027';
    public const K              = '089';
    public const KAKAO          = '090';
    public const YUANTA         = '209';
    public const HYUNDAI        = '218';
    public const MIRAEASSET     = '230';
    public const DAEWOO         = '238';
    public const SAMSUNG        = '240';
    public const KOREA_STOCK    = '243';
    public const WOORI_STOCK    = '247';
    public const KYOBO_STOCK    = '261';
    public const HI_STOCK       = '262';
    public const HMC_STOCK      = '263';
    public const KIWOOM         = '264';
    public const EBEST_STOCK    = '265';
    public const SK_STOCK       = '266';
    public const DAISHIN_STOCK  = '267';
    public const SOLOMON_STOCK  = '268';
    public const HANWHAW_STOCK  = '269';
    public const HANA_FI        = '270';
    public const SHINHAN_INVEST = '278';
    public const DB_FI          = '279';
    public const EUGENE_STOCK   = '280';
    public const MERITZ_STOCK   = '287';
    public const NH_STOCK       = '289';
    public const BOOKOOK_STOCK  = '290';

    /**
     * Enum의 설명을 가져옵니다.
     *
     * @param string $value
     */
    public static function getDescription($value): ?string
    {
        switch ($value) {
            case self::KB:
                return 'KB국민은행';
                break;
            case self::SC:
                return 'SC제일은행';
                break;
            case self::KYUNGNAM:
                return '경남은행';
                break;
            case self::GWANGJU:
                return '광주은행';
                break;
            case self::IBK:
                return '기업은행';
                break;
            case self::NH:
                return '농협';
                break;
            case self::DAEGU:
                return '대구은행';
                break;
            case self::BUSAN:
                return '부산은행';
                break;
            case self::KDB:
                return '산업은행';
                break;
            case self::SUHYUP:
                return '수협';
                break;
            case self::SHINHAN:
                return '신한은행';
                break;
            case self::CU:
                return '신협';
                break;
            case self::EXCHANGE:
                return '외환은행';
                break;
            case self::WOORI:
                return '우리은행';
                break;
            case self::POST:
                return '우체국';
                break;
            case self::JEONBUK:
                return '전북은행';
                break;
            case self::JEJU:
                return '제주은행';
                break;
            case self::CH:
                return '축협';
                break;
            case self::KEB:
                return '하나은행';
                break;
            case self::CITY:
                return '한국씨티은행';
                break;
            case self::K:
                return 'K뱅크';
                break;
            case self::KAKAO:
                return '카카오뱅크';
                break;
            case self::YUANTA:
                return '유안타증권';
                break;
            case self::HYUNDAI:
                return '현대증권';
                break;
            case self::MIRAEASSET:
                return '미래에셋증권';
                break;
            case self::DAEWOO:
                return '대우증권';
                break;
            case self::SAMSUNG:
                return '삼성증권';
                break;
            case self::KOREA_STOCK:
                return '한국투자증권';
                break;
            case self::WOORI_STOCK:
                return '우리투자증권';
                break;
            case self::KYOBO_STOCK:
                return '교보증권';
                break;
            case self::HI_STOCK:
                return '하이투자증권';
                break;
            case self::HMC_STOCK:
                return '에이치엠씨투자증권';
                break;
            case self::KIWOOM:
                return '키움증권';
                break;
            case self::EBEST_STOCK:
                return '이트레이드증권';
                break;
            case self::SK_STOCK:
                return '에스케이증권';
                break;
            case self::DAISHIN_STOCK:
                return '대신증권';
                break;
            case self::SOLOMON_STOCK:
                return '솔로몬투자증권';
                break;
            case self::HANWHAW_STOCK:
                return '한화증권';
                break;
            case self::HANA_FI:
                return '하나대투증권';
                break;
            case self::SHINHAN_INVEST:
                return '굿모닝신한증권';
                break;
            case self::DB_FI:
                return '동부증권';
                break;
            case self::EUGENE_STOCK:
                return '유진투자증권';
                break;
            case self::MERITZ_STOCK:
                return '메리츠증권';
                break;
            case self::NH_STOCK:
                return '엔에이치투자증권';
                break;
            case self::BOOKOOK_STOCK:
                return '부국증권';
                break;
            default:
                return null;
        }
    }
}
