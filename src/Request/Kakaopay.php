<?php

namespace Iamport\RestClient\Request;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Response;

/**
 * Class Kakao.
 *
 * @property string $payment_request_date
 * @property string $cid
 * @property int    $page
 */
class Kakaopay extends RequestBase
{
    use RequestTrait;

    /**
     * @var string YYYYMMDD 형식의 날짜
     */
    protected $payment_request_date;

    /**
     * @var string 아임포트 내 설정된 카카오페이 CID
     */
    protected $cid;

    /**
     * @var int 페이지
     */
    protected $page = 1;

    /**
     * 카카오페이 주문내조회 API를 래핑한 API.
     *
     * Kakao constructor.
     */
    public function __construct(string $payment_request_date)
    {
        $this->payment_request_date = $payment_request_date;
        $this->responseClass        = Response\Kakaopay::class;
    }

    public function setCid(string $cid): void
    {
        $this->cid = $cid;
    }

    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    /**
     * 카카오페이 주문내역조회 API
     * [GET] /kakao/payment/orders.
     */
    public function path(): string
    {
        return Endpoint::KAKAO;
    }

    public function attributes(): array
    {
        $result =  [
            'query' => [
                'payment_request_date' => $this->payment_request_date,
                'page'                 => $this->page,
            ],
        ];

        if ($this->cid !== null) {
            $result['query']['cid'] = $this->cid;
        }

        return $result;
    }

    public function verb(): string
    {
        return 'GET';
    }
}
