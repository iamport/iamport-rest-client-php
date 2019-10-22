<?php

namespace Iamport\RestClient\Enum;

/**
 * Class PaymentSort.
 */
class PaymentSort extends Enum
{
    public const STARTED_DESC =  'STARTED_DESC';
    public const STARTED_ASC  =  'STARTED_ASC';
    public const PAID_DESC    =  'PAID_DESC';
    public const PAID_ASC     =  'PAID_ASC';
    public const UPDATED_DESC =  'UPDATED_DESC';
    public const UPDATED_ASC  =  'UPDATED_ASC';

    /**
     * Enum의 설명을 가져옵니다.
     *
     * @param int $value
     *
     * @return string
     */
    public static function getDescription($value): string
    {
        switch ($value) {
            case self::STARTED_DESC:
                return '결제시작시각(결제창오픈시각) 기준 내림차순(DESC) 정렬';
            case self::STARTED_ASC:
                return '결제시작시각(결제창오픈시각) 기준 오름차순(ASC) 정렬';
            case self::PAID_DESC:
                return '결제완료시각 기준 내림차순(DESC) 정렬';
            case self::PAID_ASC:
                return '결제완료시각 기준 오름차순(ASC) 정렬';
            case self::UPDATED_DESC:
                return '최종수정시각(결제건 상태변화마다 수정시각 변경됨) 기준 내림차순(DESC) 정렬';
            case self::UPDATED_ASC:
                return '최종수정시각(결제건 상태변화마다 수정시각 변경됨) 기준 오름차순(ASC) 정렬';
            default:
                return null;
        }
    }
}
