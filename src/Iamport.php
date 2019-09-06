<?php

namespace Iamport\RestClient;

use GuzzleHttp\Exception\GuzzleException;
use Iamport\RestClient\Enum\Endpoint;

/**
 * Class Iamport.
 */
class Iamport extends IamportBase
{
    /**
     * imp_uid 로 주문정보 찾기(아임포트에서 생성된 거래고유번호).
     * [GET] /payments/{$impUid}.
     *
     * @param string $impUid
     *
     * @return Result
     *
     * @throws GuzzleException
     */
    public function paymentImpUid(string $impUid): Result
    {
        return $this->callApi('GET', Endpoint::PAYMENTS.$impUid);
    }

    /**
     * merchant_uid 로 주문정보 찾기(가맹점의 주문번호).
     * [GET] /payments/find/{$merchantUid}/{$paymentStatus}.
     *
     * @param string      $merchantUid
     * @param string|null $paymentStatus
     * @param string      $sorting
     *
     * @return Result
     *
     * @throws GuzzleException
     */
    public function paymentMerchantUid(string $merchantUid, string $paymentStatus = null, string $sorting = '-started'): Result
    {
        $endPoint = Endpoint::PAYMENTS_FIND.$merchantUid;
        if (in_array($paymentStatus, ['ready', 'paid', 'cancelled', 'failed'])) {
            $endPoint = $endPoint.'/'.$paymentStatus;
        }

        $attributes = [
            'query' => [
                'sorting' => $sorting,
            ],
        ];

        return $this->callApi('GET', $endPoint, $attributes);
    }

    /**
     * merchant_uid 로 주문정보 모두 찾기(가맹점의 주문번호).
     * [GET] /payments/findAll/{$merchantUid}/{$paymentStatus}.
     *
     * @param string $merchantUid
     * @param string $paymentStatus
     * @param int    $page
     * @param string $sorting
     *
     * @return Result
     *
     * @throws GuzzleException
     */
    public function paymentsMerchantUid(string $merchantUid, string $paymentStatus = null, int $page = 1, string $sorting = '-started'): Result
    {
        $endPoint = Endpoint::PAYMENTS_FIND_ALL.$merchantUid;
        if (in_array($paymentStatus, ['ready', 'paid', 'cancelled', 'failed'])) {
            $endPoint = $endPoint.'/'.$paymentStatus;
        }

        $attributes = [
            'query' => [
                'sorting' => $sorting,
                'page'    => $page,
            ],
        ];

        return $this->callApi('GET', $endPoint, $attributes, 'paged');
    }

    /**
     * 주문취소.
     * [POST] /payments/cancel.
     *
     * @param array $request
     *
     * @return Result
     *
     * @throws GuzzleException
     */
    public function paymentCancel(array $request): Result
    {
        $keys        = array_flip(['imp_uid', 'merchant_uid', 'amount', 'tax_free', 'checksum', 'reason', 'refund_holder', 'refund_bank', 'refund_account']);
        $formData    = array_intersect_key($request, $keys);

        $attributes = ['body' => $formData];

        return $this->callApi('POST', Endpoint::PAYMENTS_CANCEL, $attributes);
    }

    /**
     * 발행된 현금영수증 조회.
     * [GET] /receipts/{$impUid}.
     *
     * @param string $impUid
     *
     * @return Result
     *
     * @throws GuzzleException
     */
    public function receipt(string $impUid): Result
    {
        return $this->callApi('GET', Endpoint::RECEIPT.$impUid);
    }

    /**
     * 현금영수증 발행.
     * [POST] /receipts/{$impUid}.
     *
     * @param string $impUid
     * @param array  $request
     *
     * @return Result
     *
     * @throws GuzzleException
     */
    public function issueReceipt(string $impUid, array $request): Result
    {
        $keys       = array_flip(['identifier', 'identifier_type', 'type', 'buyer_name', 'buyer_email', 'buyer_tel', 'vat']);
        $formData   = array_intersect_key($request, $keys);
        $attributes = ['body' => $formData];

        return $this->callApi('POST', Endpoint::RECEIPT.$impUid, $attributes);
    }

    /**
     * 비인증결제 빌링키 등록(수정).
     * [POST] /subscribe/customers/{customer_uid}.
     *
     * @param string $customerUid
     * @param array  $request
     *
     * @return Result
     *
     * @throws GuzzleException
     */
    public function addBillingKey(string $customerUid, array $request): Result
    {
        $keys          = array_flip(['card_number', 'expiry', 'birth', 'pwd_2digit', 'customer_name', 'customer_tel', 'customer_email', 'customer_addr', 'customer_postcode']);
        $formData      = array_intersect_key($request, $keys);
        $attributes    = ['body' => $formData];

        return $this->callApi('POST', Endpoint::SBCR_CUSTOMERS.$customerUid, $attributes);
    }

    /**
     * 비인증결제 빌링키 조회.
     * [GET] /subscribe/customers/{$customerUid}.
     *
     * @param string $customerUid
     *
     * @return Result
     *
     * @throws GuzzleException
     */
    public function billingKey(string $customerUid): Result
    {
        return $this->callApi('GET', Endpoint::SBCR_CUSTOMERS.$customerUid);
    }

    /**
     * 비인증결제 빌링키 삭제.
     * [DELETE] /subscribe/customers/{$customerUid}.
     *
     * @param string $customerUid
     *
     * @return Result
     *
     * @throws GuzzleException
     */
    public function delBillingKey(string $customerUid): Result
    {
        return $this->callApi('DELETE', Endpoint::SBCR_CUSTOMERS.$customerUid);
    }

    /**
     * 빌링키 발급과 결제 요청을 동시에 처리.
     * [POST] /subscribe/payments/onetime.
     *
     * @param array $request
     *
     * @return Result
     *
     * @throws GuzzleException
     */
    public function subscribeOnetime(array $request): Result
    {
        $keys          = array_flip(['token', 'merchant_uid', 'amount', 'vat', 'card_number', 'expiry', 'birth', 'pwd_2digit', 'customer_uid', 'name', 'buyer_name', 'buyer_email', 'buyer_tel', 'buyer_addr', 'buyer_postcode']);
        $formData      = array_intersect_key($request, $keys);
        $attributes    = ['body' => $formData];

        return $this->callApi('POST', Endpoint::SBCR_PAYMENTS_ONETIME, $attributes);
    }

    /**
     * 저장된 빌링키로 재결제.
     * [POST] /subscribe/payments/again.
     *
     * @param array $request
     *
     * @return Result
     *
     * @throws GuzzleException
     */
    public function subscribeAgain(array $request): Result
    {
        $keys          = array_flip(['token', 'customer_uid', 'merchant_uid', 'amount', 'vat', 'name', 'buyer_name', 'buyer_email', 'buyer_tel', 'buyer_addr', 'buyer_postcode']);
        $formData      = array_intersect_key($request, $keys);
        $attributes    = ['body' => $formData];

        return $this->callApi('POST', Endpoint::SBCR_PAYMENTS_AGAIN, $attributes);
    }

    /**
     * 저장된 빌링키로 정기 예약 결제.
     * [POST] /subscribe/payments/schedule.
     *
     * @param array $request
     *
     * @return Result
     *
     * @throws GuzzleException
     */
    public function subscribeSchedule(array $request): Result
    {
        $keys          = array_flip(['customer_uid', 'checking_amount', 'card_number', 'expiry', 'birth', 'pwd_2digit', 'schedules']);
        $formData      = array_intersect_key($request, $keys);
        $attributes    = ['body' => $formData];

        return $this->callApi('POST', Endpoint::SBCR_PAYMENTS_SCHEDULE, $attributes);
    }

    /**
     * 비인증 결제요청예약 취소
     * [POST] /subscribe/payments/unschedule.
     *
     * @param array $request
     *
     * @return Result
     *
     * @throws GuzzleException
     */
    public function subscribeUnschedule(array $request): Result
    {
        $keys          = array_flip(['customer_uid', 'merchant_uid']);
        $formData      = array_intersect_key($request, $keys);
        $attributes    = ['body' => $formData];

        return $this->callApi('POST', Endpoint::SBCR_PAYMENTS_UNSCHEDULE, $attributes);
    }
}
