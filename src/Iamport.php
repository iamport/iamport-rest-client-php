<?php

namespace Iamport\RestClient;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Iamport\RestClient\Enum\ApiType;
use Iamport\RestClient\Exception\Handler;
use Iamport\RestClient\Response\Payment;
use Iamport\RestClient\Response\PaymentsPaged;
use Iamport\RestClient\Result;

/**
 * Class Iamport.
 */
class Iamport extends IamportBase
{
    /**
     * imp_uid 로 주문정보 찾기(아임포트에서 생성된 거래고유번호).
     * [GET] /payments/{$impUid}
     *
     * @param $impUid
     *
     * @return Result
     *
     * @throws GuzzleException
     */
    public function paymentImpUID($impUid)
    {
        try {
            $response = $this->request('GET', ApiType::GET_PAYMENT.$impUid, [], true);
            $payment  = new Payment($response);

            return new Result(true, $payment);
        } catch (Exception $e) {
            return Handler::render($e);
        }
    }

    /**
     * merchant_uid 로 주문정보 찾기(가맹점의 주문번호).
     * [GET] /payments/find/{$merchantUid}/{$paymentStatus}
     *
     * @param $merchantUid
     * @param null $paymentStatus
     *
     * @return Result
     *
     * @throws GuzzleException
     */
    public function paymentMerchantUID($merchantUid, $paymentStatus=null)
    {
        try {
            $endPoint = ApiType::FIND_PAYMENT.$merchantUid;
            if (in_array($paymentStatus, ['ready', 'paid', 'cancelled', 'failed'])) {
                $endPoint = $endPoint.'/'.$paymentStatus;
            }

            $response = $this->request('GET', $endPoint, [], true);
            $payment  = new Payment($response);

            return new Result(true, $payment);
        } catch (Exception $e) {
            return Handler::render($e);
        }
    }

    /**
     * merchant_uid 로 주문정보 모두 찾기(가맹점의 주문번호).
     * [GET] /payments/findAll/{$merchantUid}/{$paymentStatus}
     *
     * @param $merchantUid
     * @param null $paymentStatus
     *
     * @return Result
     *
     * @throws GuzzleException
     */
    public function paymentsMerchantUID($merchantUid, $paymentStatus=null)
    {
        try {
            $endPoint = ApiType::FIND_ALL_PAYMENT.$merchantUid;
            if (in_array($paymentStatus, ['ready', 'paid', 'cancelled', 'failed'])) {
                $endPoint = $endPoint.'/'.$paymentStatus;
            }

            $response      = $this->request('GET', $endPoint, [], true);
            $pagedPayments = new PaymentsPaged($response);

            return new Result(true, $pagedPayments);
        } catch (Exception $e) {
            return Handler::render($e);
        }
    }

    /**
     * 주문취소.
     * [POST] /payments/cancel
     *
     * @param $request
     *
     * @return Result
     *
     * @throws GuzzleException
     */
    public function paymentCancel($request)
    {
        try {
            $keys        = array_flip(['amount', 'reason', 'refund_holder', 'refund_bank', 'refund_account']);
            $cancelData  = array_intersect_key($request, $keys);

            if ($request['imp_uid']) {
                $cancelData['imp_uid'] = $request['imp_uid'];
            } elseif ($request['merchant_uid']) {
                $cancelData['merchant_uid'] = $request['merchant_uid'];
            } else {
                return Handler::renderString('취소하실 imp_uid 또는 merchant_uid 중 하나를 지정하셔야 합니다.', '');
            }

            $attributes = ['body' => json_encode($cancelData)];
            $response   = $this->request('POST', ApiType::CANCEL_PAYMENT, $attributes, true);

            $payment = new Payment($response);

            return new Result(true, $payment);
        } catch (Exception $e) {
            return Handler::render($e);
        }
    }

    /**
     * 발행된 현금영수증 조회.
     * [GET] /receipts/{$impUid}
     *
     * @param $impUid
     *
     * @return Result
     *
     * @throws GuzzleException
     */
    public function receipt($impUid)
    {
        try {
            $response = $this->request('GET', ApiType::RECEIPT.$impUid, [], true);

            return new Result(true, $response);
        } catch (Exception $e) {
            return Handler::render($e);
        }
    }

    /**
     * 현금영수증 발행.
     * [POST] /receipts/{$impUid}
     *
     * @param $impUid
     * @param $request
     *
     * @return Result
     *
     * @throws GuzzleException
     */
    public function issueReceipt($impUid, $request)
    {
        try {
            $keys       = array_flip(['identifier', 'identifier_type', 'type', 'buyer_name', 'buyer_email', 'buyer_tel', 'vat']);
            $postData   = array_intersect_key($request, $keys);
            $attributes = ['body' => json_encode($postData)];

            $response   = $this->request('POST', ApiType::RECEIPT.$impUid, $attributes, true);

            $payment = new Payment($response);

            return new Result(true, $payment);
        } catch (Exception $e) {
            return Handler::render($e);
        }
    }

    /**
     * 비인증결제 빌링키 등록(수정).
     * [POST] /subscribe/customers/{customer_uid}
     *
     * @param $request
     *
     * @return Result
     *
     * @throws GuzzleException
     */
    public function subscribeCustomerPost($request)
    {
        try {
            $keys          = array_flip(['customer_uid', 'card_number', 'expiry', 'birth', 'pwd_2digit', 'customer_name', 'customer_tel', 'customer_email', 'customer_addr', 'customer_postcode']);
            $customersData = array_intersect_key($request, $keys);
            $attributes    = ['body' => json_encode($customersData)];

            $response   = $this->request('POST', ApiType::SBCR_CUSTOMERS.$customersData['customer_uid'], $attributes, true);

            return new Result(true, $response);
        } catch (Exception $e) {
            return Handler::render($e);
        }
    }

    /**
     * 비인증결제 빌링키 조회.
     * [GET] /subscribe/customers/{$customerUid}
     *
     * @param $customerUid
     *
     * @return Result
     *
     * @throws GuzzleException
     */
    public function subscribeCustomerGet($customerUid)
    {
        try {
            $response = $this->request('GET', ApiType::SBCR_CUSTOMERS.$customerUid, [], true);

            return new Result(true, $response);
        } catch (Exception $e) {
            return Handler::render($e);
        }
    }

    /**
     * 비인증결제 빌링키 삭제.
     * [DELETE] /subscribe/customers/{$customerUid}
     *
     * @param $customerUid
     *
     * @return Result
     *
     * @throws GuzzleException
     */
    public function subscribeCustomerDelete($customerUid)
    {
        try {
            $response = $this->request('DELETE', ApiType::SBCR_CUSTOMERS.$customerUid, [], true);

            return new Result(true, $response);
        } catch (Exception $e) {
            return Handler::render($e);
        }
    }

    /**
     * 빌링키 발급과 결제 요청을 동시에 처리.
     * [POST] /subscribe/payments/onetime
     *
     * @param $request
     *
     * @return Result
     *
     * @throws GuzzleException
     */
    public function subscribeOnetime($request)
    {
        try {
            $keys          = array_flip(['token', 'merchant_uid', 'amount', 'vat', 'card_number', 'expiry', 'birth', 'pwd_2digit', 'customer_uid', 'name', 'buyer_name', 'buyer_email', 'buyer_tel', 'buyer_addr', 'buyer_postcode']);
            $onetimeData   = array_intersect_key($request, $keys);
            $attributes    = ['body' => json_encode($onetimeData)];

            $response = $this->request('POST', ApiType::SBCR_ONETIME_PAYMENT, $attributes, true);
            $payment  = new Payment($response);

            return new Result(true, $payment);
        } catch (Exception $e) {
            return Handler::render($e);
        }
    }

    /**
     * 저장된 빌링키로 재결제.
     * [POST] /subscribe/payments/again
     *
     * @param $request
     *
     * @return Result
     *
     * @throws GuzzleException
     */
    public function subscribeAgain($request)
    {
        try {
            $keys          = array_flip(['token', 'customer_uid', 'merchant_uid', 'amount', 'vat', 'name', 'buyer_name', 'buyer_email', 'buyer_tel', 'buyer_addr', 'buyer_postcode']);
            $onetimeData   = array_intersect_key($request, $keys);
            $attributes    = ['body' => json_encode($onetimeData)];

            $response = $this->request('POST', ApiType::SBCR_AGAIN_PAYMENT, $attributes, true);
            $payment  = new Payment($response);

            return new Result(true, $payment);
        } catch (Exception $e) {
            return Handler::render($e);
        }
    }


    /**
     * 저장된 빌링키로 정기 예약 결제.
     * [POST] /subscribe/payments/schedule
     *
     * @param $request
     * @return Result
     * @throws GuzzleException
     */
    public function subscribeSchedule($request)
    {
        try {
            $keys          = array_flip(['customer_uid', 'checking_amount', 'card_number', 'expiry', 'birth', 'pwd_2digit', 'schedules']);
            $scheduleData  = array_intersect_key($request, $keys);
            $attributes    = ['body' => json_encode($scheduleData)];

            $response = $this->request('POST', ApiType::SBCR_SCHEDULE_PAYMENT, $attributes, true);

            return new Result(true, $response);
        } catch (Exception $e) {
            return Handler::render($e);
        }
    }

    /**
     * 비인증 결제요청예약 취소
     * [POST] /subscribe/payments/unschedule
     *
     * @param $request
     * @return Result
     * @throws GuzzleException
     */
    public function subscribeUnschedule($request)
    {
        try {
            $keys = array_flip(array('customer_uid', 'merchant_uid'));
            $scheduledData = array_intersect_key($request, $keys);
            $attributes    = ['body' => json_encode($scheduledData)];

            $response = $this->request('POST', ApiType::SBCR_UNSCHEDULE_PAYMENT, $attributes, true);

            return new Result(true, $response);
        } catch (Exception $e) {
            return Handler::render($e);
        }
    }
}
