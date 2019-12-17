<?php

namespace Iamport\RestClient\Enum\Naver;

use Iamport\RestClient\Enum\Enum;

/**
 * Class OrderStatus.
 */
class OrderStatus extends Enum
{
    public const PAYMENT_WAITING       = 'PAYMENT_WAITING';
    public const PAYED                 = 'PAYED';
    public const DELIVERING            = 'DELIVERING';
    public const DELIVERED             = 'DELIVERED';
    public const PURCHASE_DECIDED      = 'PURCHASE_DECIDED';
    public const EXCHANGED             = 'EXCHANGED';
    public const CANCELED              = 'CANCELED';
    public const RETURNED              = 'RETURNED';
    public const CANCELED_BY_NOPAYMENT = 'CANCELED_BY_NOPAYMENT';

    /**
     * Enum의 설명을 가져옵니다.
     *
     * @param string $value
     */
    public static function getDescription($value): ?string
    {
        switch ($value) {
            case self::PAYMENT_WAITING:
                return '입금 대기';
            case self::PAYED:
                return '결제 완료';
            case self::DELIVERING:
                return '배송 중';
            case self::DELIVERED:
                return '배송 완료';
            case self::PURCHASE_DECIDED:
                return '구매 확정';
            case self::EXCHANGED:
                return '교환 완료';
            case self::CANCELED:
                return '취소 완료';
            case self::RETURNED:
                return '반품 완료';
            case self::CANCELED_BY_NOPAYMENT:
                return '미입금 취소';
            default:
                return null;
        }
    }
}
