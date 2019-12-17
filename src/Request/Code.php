<?php

namespace Iamport\RestClient\Request;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Response;

/**
 * Class Code.
 *
 * @property string $card_standard_code
 * @property string $bank_standard_code
 */
class Code extends RequestBase
{
    use RequestTrait;

    /**
     * @var string 카드사 표준코드
     */
    protected $card_standard_code;

    /**
     * @var array 은행사 표준코드
     */
    protected $bank_standard_code = [];

    /**
     * 카드사표준코드, 카드사명을 모두 조회(금융결제원표준코드 기준).
     *
     * @return Code
     */
    public static function cards()
    {
        $instance                = new self();
        $instance->responseClass = Response\StandardCode::class;
        $instance->isCollection  = true;
        $instance->instanceType  = 'cards';

        return $instance;
    }

    /**
     * 카드사표준코드, 카드사명을 조회(금융결제원표준코드 기준).
     *
     * @return Code
     */
    public static function card(string $cardStandardCode)
    {
        $instance                     = new self();
        $instance->card_standard_code = $cardStandardCode;
        $instance->responseClass      = Response\StandardCode::class;
        $instance->instanceType       = 'card';

        return $instance;
    }

    /**
     * 은행표준코드, 은행명을 모두 조회(금융결제원표준코드 기준).
     *
     * @return Code
     */
    public static function banks()
    {
        $instance                = new self();
        $instance->responseClass = Response\StandardCode::class;
        $instance->isCollection  = true;
        $instance->instanceType  = 'banks';

        return $instance;
    }

    /**
     * 은행표준코드, 은행명을 조회(금융결제원표준코드 기준).
     *
     * @return Code
     */
    public static function bank(string $bankStandardCode)
    {
        $instance                     = new self();
        $instance->bank_standard_code = $bankStandardCode;
        $instance->responseClass      = Response\StandardCode::class;
        $instance->instanceType       = 'bank';

        return $instance;
    }

    /**
     * 카드사정보 리스트를 조회
     * [GET] /cards.
     *
     * 카드사정보를 조회
     * [GET] /cards/{card_standard_code}
     *
     * 은행정보 리스트를 조회합
     * [GET] /banks
     *
     * 은행정보를 조회
     * [GET] /banks/{bank_standard_code}
     */
    public function path(): string
    {
        switch ($this->instanceType) {
            case 'cards':
                return Endpoint::CARDS;
                break;
            case 'card':
                return Endpoint::CARDS . '/' . $this->card_standard_code;
                break;
            case 'banks':
                return Endpoint::BANKS;
                break;
            case 'bank':
                return Endpoint::BANKS . '/' . $this->bank_standard_code;
                break;
            default:
                return null;
        }
    }

    public function attributes(): array
    {
        return [];
    }

    public function verb(): string
    {
        return 'GET';
    }
}
