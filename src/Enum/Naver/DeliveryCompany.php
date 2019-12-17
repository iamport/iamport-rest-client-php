<?php

namespace Iamport\RestClient\Enum\Naver;

use Iamport\RestClient\Enum\Enum;

/**
 * Class DeliveryCompany.
 */
class DeliveryCompany extends Enum
{
    public const CJGLS      = 'CJGLS';
    public const KGB        = 'KGB';
    public const DONGBU     = 'DONGBU';
    public const EPOST      = 'EPOST';
    public const REGISTPOST = 'REGISTPOST';
    public const HANJIN     = 'HANJIN';
    public const HYUNDAI    = 'HYUNDAI';
    public const KGBLS      = 'KGBLS';
    public const INNOGIS    = 'INNOGIS';
    public const DAESIN     = 'DAESIN';
    public const ILYANG     = 'ILYANG';
    public const KDEXP      = 'KDEXP';
    public const CHUNIL     = 'CHUNIL';
    public const CH1        = 'CH1';
    public const HDEXP      = 'HDEXP';
    public const CVSNET     = 'CVSNET';
    public const DHL        = 'DHL';
    public const FEDEX      = 'FEDEX';
    public const GSMNTON    = 'GSMNTON';
    public const WARPEX     = 'WARPEX';
    public const WIZWA      = 'WIZWA';
    public const EMS        = 'EMS';
    public const DHLDE      = 'DHLDE';
    public const ACIEXPRESS = 'ACIEXPRESS';
    public const EZUSA      = 'EZUSA';
    public const PANTOS     = 'PANTOS';
    public const UPS        = 'UPS';
    public const HLCGLOBAL  = 'HLCGLOBAL';
    public const KOREXG     = 'KOREXG';
    public const TNT        = 'TNT';
    public const SWGEXP     = 'SWGEXP';
    public const DAEWOON    = 'DAEWOON';
    public const USPS       = 'USPS';
    public const IPARCEL    = 'IPARCEL';
    public const KUNYOUNG   = 'KUNYOUNG';
    public const HPL        = 'HPL';
    public const DADREAM    = 'DADREAM';
    public const SLX        = 'SLX';
    public const SFEXPRESS  = 'SFEXPRESS';
    public const HONAM      = 'HONAM';

    /**
     * Enum의 설명을 가져옵니다.
     *
     * @param string $value
     */
    public static function getDescription($value): ?string
    {
        switch ($value) {
            case self::CJGLS:
                return 'CJ 대한통운';
            case self::KGB:
                return '로젠택배';
            case self::DONGBU:
                return 'KG 로지스';
            case self::EPOST:
                return '우체국택배';
            case self::REGISTPOST:
                return '우편등기';
            case self::HANJIN:
                return '한진택배';
            case self::HYUNDAI:
                return '현대택배';
            case self::KGBLS:
                return 'KGB 택배';
            case self::INNOGIS:
                return 'GTX 로지스';
            case self::DAESIN:
                return '대신택배';
            case self::ILYANG:
                return '일양로지스';
            case self::KDEXP:
                return '경동택배';
            case self::CHUNIL:
                return '천일택배';
            case self::CH1:
                return '기타 택배';
            case self::HDEXP:
                return '합동택배';
            case self::CVSNET:
                return '편의점택배';
            case self::DHL:
                return 'DHL';
            case self::FEDEX:
                return 'FEDEX';
            case self::GSMNTON:
                return 'GSMNTON';
            case self::WARPEX:
                return 'WarpEx';
            case self::WIZWA:
                return 'WIZWA';
            case self::EMS:
                return 'EMS';
            case self::DHLDE:
                return 'DHL(독일)';
            case self::ACIEXPRESS:
                return 'ACI';
            case self::EZUSA:
                return 'EZUSA';
            case self::PANTOS:
                return '범한판토스';
            case self::UPS:
                return 'UPS';
            case self::HLCGLOBAL:
                return '현대택배(국제택배)';
            case self::KOREXG:
                return 'CJ 대한통운(국제택배)';
            case self::TNT:
                return 'TNT';
            case self::SWGEXP:
                return '성원글로벌';
            case self::DAEWOON:
                return '대운글로벌';
            case self::USPS:
                return 'USPS';
            case self::IPARCEL:
                return 'i-parcel';
            case self::KUNYOUNG:
                return '건영택배';
            case self::HPL:
                return '한의사랑택배';
            case self::DADREAM:
                return '다드림';
            case self::SLX:
                return 'SLX 택배';
            case self::SFEXPRESS:
                return '순풍택배';
            case self::HONAM:
                return '호남택배';
            default:
                return null;
        }
    }
}
