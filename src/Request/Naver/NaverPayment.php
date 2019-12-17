<?php

namespace Iamport\RestClient\Request\Naver;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Request\RequestBase;
use Iamport\RestClient\Request\RequestTrait;

/**
 * Class NaverPayment.
 * TODO: 유일하게 리턴타입이 객체가 아니라 단순 문자열인데 post 전송 데이터 확인해야함.
 *
 * @property string $imp_uid
 */
class NaverPayment extends RequestBase
{
    use RequestTrait;

    /**
     * @var string 아임포트 고유번호
     */
    protected $imp_uid;

    /**
     * 결제형-네이버페이 포인트 적립 API.
     *
     * @return NaverPayment
     */
    public static function point(string $impUid)
    {
        $instance                = new self();
        $instance->imp_uid       = $impUid;
        $instance->responseClass = 'string';
        $instance->instanceType  = 'point';

        return $instance;
    }

    /**
     * 결제형-네이버페이 에스크로 주문 확정.
     *
     * @return NaverPayment
     */
    public static function confirm(string $impUid)
    {
        $instance                = new self();
        $instance->imp_uid       = $impUid;
        $instance->responseClass = 'string';
        $instance->instanceType  = 'confirm';

        return $instance;
    }

    /**
     * 결제형-네이버페이 포인트 적립 API
     * [POST] /payments/{imp_uid}/naver/point.
     *
     * 결제형-네이버페이 에스크로 주문 확정
     * [POST] /payments/{imp_uid}/naver/confirm
     */
    public function path(): string
    {
        if ($this->instanceType === 'point') {
            return Endpoint::PAYMENTS . $this->imp_uid . Endpoint::NAVER_POINT;
        } elseif ($this->instanceType === 'confirm') {
            return Endpoint::PAYMENTS . $this->imp_uid . Endpoint::NAVER_CONFIRM;
        }
    }

    public function attributes(): array
    {
        return [];
    }

    public function verb(): string
    {
        return 'POST';
    }
}
