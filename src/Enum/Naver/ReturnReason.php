<?php

namespace Iamport\RestClient\Enum\Naver;

use Iamport\RestClient\Enum\Enum;

/**
 * Class ReturnReason.
 */
class ReturnReason extends Enum
{
    public const INTENT_CHANGED      = 'INTENT_CHANGED';
    public const COLOR_AND_SIZE      = 'COLOR_AND_SIZE';
    public const WRONG_ORDER         = 'WRONG_ORDER';
    public const PRODUCT_UNSATISFIED = 'PRODUCT_UNSATISFIED';
    public const DELAYED_DELIVERY    = 'DELAYED_DELIVERY';
    public const SOLD_OUT            = 'SOLD_OUT';
    public const DROPPED_DELIVERY    = 'DROPPED_DELIVERY';
    public const BROKEN              = 'BROKEN';
    public const INCORRECT_INFO      = 'INCORRECT_INFO';
    public const WRONG_DELIVERY      = 'WRONG_DELIVERY';
    public const WRONG_OPTION        = 'WRONG_OPTION';

    /**
     * Enum의 설명을 가져옵니다.
     *
     * @param string $value
     */
    public static function getDescription($value): ?string
    {
        switch ($value) {
            case self::INTENT_CHANGED:
                return '구매 의사 취소';
            case self::COLOR_AND_SIZE:
                return '색상 및 사이즈 변경';
            case self::WRONG_ORDER:
                return '다른 상품 잘못 주문';
            case self::PRODUCT_UNSATISFIED:
                return '서비스 및 상품 불만족';
            case self::DELAYED_DELIVERY:
                return '배송 지연';
            case self::SOLD_OUT:
                return '상품 품절';
            case self::DROPPED_DELIVERY:
                return '배송 누락';
            case self::BROKEN:
                return '상품 파';
            case self::INCORRECT_INFO:
                return '상품정보상이';
            case self::WRONG_DELIVERY:
                return '오배송';
            case self::WRONG_OPTION:
                return '색상 등이 다른 상품을 잘못 배송';
            default:
                return null;
        }
    }
}
