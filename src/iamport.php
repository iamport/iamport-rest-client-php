<?php
if (!class_exists('IamportAuthException')) {
    class IamportAuthException extends Exception
    {
        public function __construct($message, $code)
        {
            parent::__construct($message, $code);
        }
    }
}

if (!class_exists('IamportRequestException')) {
    class IamportRequestException extends Exception
    {

        protected $response;

        public function __construct($response)
        {
            $this->response = $response;

            parent::__construct($response->message, $response->code);
        }

    }
}

if (!class_exists('IamportResult')) {
    class IamportResult
    {

        public $success = false;
        public $data;
        public $error;

        public function __construct($success = false, $data = null, $error = null)
        {
            $this->success = $success;
            $this->data = $data;
            $this->error = $error;
        }

    }
}

if (!class_exists('IamportPayment')) {
    class IamportPayment
    {

        protected $response;
        protected $custom_data;

        public function __construct($response)
        {
            $this->response = $response;

            $this->custom_data = json_decode($response->custom_data);
        }

        public function __get($name)
        {
            if (isset($this->response->{$name})) {
                return $this->response->{$name};
            }
        }

        public function getCustomData($name = null)
        {
            if (is_null($name)) {
                return $this->custom_data;
            }

            if (isset($this->custom_data->{$name})) {
                return $this->custom_data->{$name};
            }

            return null;
        }

    }
}

if (!class_exists('IamportPaymentsPaged')) {
    class IamportPaymentsPaged
    {
        protected $total;
        protected $previous;
        protected $next;
        protected $payments;

        public function __construct($response)
        {
            $this->total = $response->total;
            $this->previous = $response->previous;
            $this->next = $response->next;

            $this->payments = array();
            foreach ($response->list as $row) {
                $this->payments[] = new IamportPayment($row);
            }
        }

        /**
         * @return integer
         */
        public function getTotal()
        {
            return $this->total;
        }

        /**
         * @return integer
         */
        public function getPrevious()
        {
            return $this->previous;
        }

        /**
         * @return integer
         */
        public function getNext()
        {
            return $this->next;
        }

        /**
         * @return array
         */
        public function getPayments()
        {
            return $this->payments;
        }
    }
}

if (!class_exists('Iamport')) {
    class Iamport
    {

        const GET_TOKEN_URL = 'https://api.iamport.kr/users/getToken';
        const GET_PAYMENT_URL = 'https://api.iamport.kr/payments/';
        const GET_CERTIFICATION_URL = 'https://api.iamport.kr/certifications/';
        const FIND_PAYMENT_URL = 'https://api.iamport.kr/payments/find/';
        const FIND_ALL_PAYMENT_URL = 'https://api.iamport.kr/payments/findAll/';
        const CANCEL_PAYMENT_URL = 'https://api.iamport.kr/payments/cancel/';
        const SBCR_ONETIME_PAYMENT_URL = 'https://api.iamport.kr/subscribe/payments/onetime/';
        const SBCR_AGAIN_PAYMENT_URL = 'https://api.iamport.kr/subscribe/payments/again/';
        const SBCR_SCHEDULE_PAYMENT_URL = 'https://api.iamport.kr/subscribe/payments/schedule/';
        const SBCR_UNSCHEDULE_PAYMENT_URL = 'https://api.iamport.kr/subscribe/payments/unschedule/';
        const SBCR_CUSTOMERS_URL = 'https://api.iamport.kr/subscribe/customers/';
        const RECEIPT_URL = 'https://api.iamport.kr/receipts/';
        const VBANK_BASE_URL = 'https://api.iamport.kr/vbanks/';

        const TOKEN_HEADER = 'Authorization';

        private $imp_key = null;
        private $imp_secret = null;

        protected $access_token = null;
        protected $expired_at = null;
        protected $now = null;

        public function __construct($imp_key, $imp_secret)
        {
            $this->imp_key = $imp_key;
            $this->imp_secret = $imp_secret;
        }

        public function findByImpUID($imp_uid)
        {
            try {
                $response = $this->getResponse(self::GET_PAYMENT_URL . $imp_uid);

                $payment_data = new IamportPayment($response);
                return new IamportResult(true, $payment_data);
            } catch (IamportAuthException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (IamportRequestException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (Exception $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            }
        }

        public function findByMerchantUID($merchantUid, $statusFilter=null)
        {
            try {
                $endpoint = self::FIND_PAYMENT_URL . $merchantUid;
                if (in_array($statusFilter, array('ready', 'paid', 'cancelled', 'failed'))) {
                    $endpoint = $endpoint . '/' . $statusFilter;
                }

                $response = $this->getResponse($endpoint);

                $payment_data = new IamportPayment($response);
                return new IamportResult(true, $payment_data);
            } catch (IamportAuthException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (IamportRequestException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (Exception $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            }
        }

        public function findAllByMerchantUID($merchantUid, $statusFilter=null)
        {
            try {
                $endpoint = self::FIND_ALL_PAYMENT_URL . $merchantUid;
                if (in_array($statusFilter, array('ready', 'paid', 'cancelled', 'failed'))) {
                    $endpoint = $endpoint . '/' . $statusFilter;
                }

                $response = $this->getResponse($endpoint);

                $pagedPayments = new IamportPaymentsPaged($response);
                return new IamportResult(true, $pagedPayments);
            } catch (IamportAuthException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (IamportRequestException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (Exception $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            }
        }

        public function findCertificationByImpUID($impUid)
        {
            try {
                $response = $this->getResponse(self::GET_CERTIFICATION_URL . $impUid);

                return new IamportResult(true, $response);
            } catch (IamportAuthException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (IamportRequestException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (Exception $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            }
        }

        public function cancel($data)
        {
            try {
                $access_token = $this->getAccessCode();

                $keys = array_flip(array('amount', 'reason', 'refund_holder', 'refund_bank', 'refund_account'));
                $cancel_data = array_intersect_key($data, $keys);
                if ($data['imp_uid']) {
                    $cancel_data['imp_uid'] = $data['imp_uid'];
                } else if ($data['merchant_uid']) {
                    $cancel_data['merchant_uid'] = $data['merchant_uid'];
                } else {
                    return new IamportResult(false, null, array('code' => '', 'message' => '취소하실 imp_uid 또는 merchant_uid 중 하나를 지정하셔야 합니다.'));
                }

                $response = $this->postResponse(
                    self::CANCEL_PAYMENT_URL,
                    $cancel_data,
                    array(self::TOKEN_HEADER . ': ' . $access_token)
                );

                $payment_data = new IamportPayment($response);
                return new IamportResult(true, $payment_data);
            } catch (IamportAuthException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (IamportRequestException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (Exception $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            }
        }

        /**
         * @deprecated Renamed. Use subscribeOnetime($data)
         */
        public function sbcr_onetime($data)
        {
            try {
                $access_token = $this->getAccessCode();

                $keys = array_flip(array('token', 'merchant_uid', 'amount', 'vat', 'card_number', 'expiry', 'birth', 'pwd_2digit', 'customer_uid', 'name', 'buyer_name', 'buyer_email', 'buyer_tel', 'buyer_addr', 'buyer_postcode', 'card_quota', 'custom_data', 'notice_url'));
                $onetime_data = array_intersect_key($data, $keys);

                $response = $this->postResponse(
                    self::SBCR_ONETIME_PAYMENT_URL,
                    $onetime_data,
                    array(self::TOKEN_HEADER . ': ' . $access_token)
                );

                $payment_data = new IamportPayment($response);
                return new IamportResult(true, $payment_data);
            } catch (IamportAuthException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (IamportRequestException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (Exception $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            }
        }

        /**
         * @deprecated Renamed. Use subscribeAgain($data)
         */
        public function sbcr_again($data)
        {
            try {
                $access_token = $this->getAccessCode();

                $keys = array_flip(array('token', 'customer_uid', 'merchant_uid', 'amount', 'vat', 'name', 'buyer_name', 'buyer_email', 'buyer_tel', 'buyer_addr', 'buyer_postcode'));
                $onetime_data = array_intersect_key($data, $keys);

                $response = $this->postResponse(
                    self::SBCR_AGAIN_PAYMENT_URL,
                    $onetime_data,
                    array(self::TOKEN_HEADER . ': ' . $access_token)
                );

                $payment_data = new IamportPayment($response);
                return new IamportResult(true, $payment_data);
            } catch (IamportAuthException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (IamportRequestException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (Exception $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            }
        }

        public function subscribeOnetime($data)
        {
            return $this->sbcr_onetime($data);
        }

        public function subscribeAgain($data)
        {
            return $this->sbcr_again($data);
        }

        public function subscribeSchedule($data)
        {
            try {
                $access_token = $this->getAccessCode();

                $keys = array_flip(array('customer_uid', 'checking_amount', 'card_number', 'expiry', 'birth', 'pwd_2digit', 'schedules'));
                $schedule_data = array_intersect_key($data, $keys);

                $response = $this->postResponse(
                    self::SBCR_SCHEDULE_PAYMENT_URL,
                    $schedule_data,
                    array(self::TOKEN_HEADER . ': ' . $access_token)
                );

                return new IamportResult(true, $response);
            } catch (IamportAuthException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (IamportRequestException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (Exception $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            }
        }

        public function subscribeUnschedule($data)
        {
            try {
                $access_token = $this->getAccessCode();

                $keys = array_flip(array('customer_uid', 'merchant_uid'));
                $scheduled_data = array_intersect_key($data, $keys);

                $response = $this->postResponse(
                    self::SBCR_UNSCHEDULE_PAYMENT_URL,
                    $scheduled_data,
                    array(self::TOKEN_HEADER . ': ' . $access_token)
                );

                return new IamportResult(true, $response);
            } catch (IamportAuthException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (IamportRequestException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (Exception $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            }
        }

        // /subscribe/customers/{customer_uid} POST function

        /**
         * @deprecated Renamed. Use subscribeCustomerPost($data)
         */
        public function sbcr_customers_POST($data)
        {
            try {
                $access_token = $this->getAccessCode();

                $keys = array_flip(array('customer_uid', 'card_number', 'expiry', 'birth', 'pwd_2digit', 'customer_name', 'customer_tel', 'customer_email', 'customer_addr', 'customer_postcode'));
                $customers_data = array_intersect_key($data, $keys);

                $response = $this->postResponse(
                    self::SBCR_CUSTOMERS_URL . $customers_data['customer_uid'],
                    $customers_data,
                    array(self::TOKEN_HEADER . ': ' . $access_token)
                );

                return new IamportResult(true, $response);
            } catch (IamportAuthException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (IamportRequestException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (Exception $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            }
        }

        public function subscribeCustomerPost($data)
        {
            return $this->sbcr_customers_POST($data);
        }

        public function subscribeCustomerDelete($customer_uid)
        {
            try {
                $access_token = $this->getAccessCode();

                $response = $this->deleteResponse(
                    self::SBCR_CUSTOMERS_URL . $customer_uid,
                    array(self::TOKEN_HEADER . ': ' . $access_token)
                );

                return new IamportResult(true, $response);
            } catch (IamportAuthException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (IamportRequestException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (Exception $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            }
        }

        public function subscribeCustomerGet($customer_uid)
        {
            try {
                $response = $this->getResponse(self::SBCR_CUSTOMERS_URL . $customer_uid);

                return new IamportResult(true, $response);
            } catch (IamportAuthException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (IamportRequestException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (Exception $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            }
        }

        public function issueReceipt($impUid, $requestData)
        {
            try {
                $accessToken = $this->getAccessCode();

                $keys = array_flip(array("identifier", "identifier_type", "type", "buyer_name", "buyer_email", "buyer_tel", "vat"));
                $postData = array_intersect_key($requestData, $keys);

                $response = $this->postResponse(
                    self::RECEIPT_URL . $impUid,
                    $postData,
                    array(self::TOKEN_HEADER . ': ' . $accessToken)
                );

                return new IamportResult(true, $response);
            } catch (IamportAuthException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (IamportRequestException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (Exception $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            }
        }

        public function getReceipt($impUid)
        {
            try {
                $response = $this->getResponse(self::RECEIPT_URL . $impUid);

                return new IamportResult(true, $response);
            } catch (IamportAuthException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (IamportRequestException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (Exception $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            }
        }

        public function issueVbank($requestData)
        {
            try {
                $accessToken = $this->getAccessCode();

                $keys = array_flip(array(
                    "merchant_uid",
                    "amount",
                    "vbank_code",
                    "vbank_due",
                    "vbank_holder",
                    "name",
                    "buyer_name",
                    "buyer_email",
                    "buyer_tel",
                    "buyer_addr",
                    "buyer_postcode",
                    "pg",
                    "notice_url",
                    "custom_data",));
                $postData = array_intersect_key($requestData, $keys);

                $response = $this->postResponse(
                    self::VBANK_BASE_URL,
                    $postData,
                    array(self::TOKEN_HEADER . ': ' . $accessToken)
                );

                return new IamportResult(true, $response);
            } catch (IamportAuthException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (IamportRequestException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (Exception $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            }
        }

        public function modifyVbank($impUid, $requestData)
        {
            try {
                $accessToken = $this->getAccessCode();

                $keys = array_flip(array(
                    "amount",
                    "vbank_due",
                    ));
                $postData = array_intersect_key($requestData, $keys);

                $response = $this->postResponse(
                    self::VBANK_BASE_URL . $impUid,
                    $postData,
                    array(self::TOKEN_HEADER . ': ' . $accessToken),
                    true
                );

                return new IamportResult(true, $response);
            } catch (IamportAuthException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (IamportRequestException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (Exception $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            }
        }

        public function revokeVbank($impUid)
        {
            try {
                $accessToken = $this->getAccessCode();

                $response = $this->deleteResponse(
                    self::VBANK_BASE_URL . $impUid,
                    array(self::TOKEN_HEADER . ': ' . $accessToken)
                );

                return new IamportResult(true, $response);
            } catch (IamportAuthException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (IamportRequestException $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            } catch (Exception $e) {
                return new IamportResult(false, null, array('code' => $e->getCode(), 'message' => $e->getMessage()));
            }
        }

        protected function getResponse($request_url, $request_data = null)
        {
            $access_token = $this->getAccessCode();
            $headers = array(self::TOKEN_HEADER . ': ' . $access_token, 'Content-Type: application/json');

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $request_url);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            //execute get
            $body = curl_exec($ch);
            $error_code = curl_errno($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $r = json_decode(trim($body));
            curl_close($ch);

            if ($error_code > 0) throw new Exception("Request Error(HTTP STATUS : " . $status_code . ")", $error_code);
            if (empty($r)) throw new Exception("API서버로부터 응답이 올바르지 않습니다. " . $body, 1);
            if ($r->code !== 0) throw new IamportRequestException($r);

            return $r->response;
        }

        protected function postResponse($request_url, $post_data = array(), $headers = array(), $put = false)
        {
            $post_data_str = json_encode($post_data);
            $default_header = array('Content-Type: application/json', 'Content-Length: ' . strlen($post_data_str));
            $headers = array_merge($default_header, $headers);

            $ch = curl_init();

            if ($put) {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            } else {
                curl_setopt($ch, CURLOPT_POST, true);
            }

            curl_setopt($ch, CURLOPT_URL, $request_url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data_str);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            //execute post
            $body = curl_exec($ch);
            $error_code = curl_errno($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            $r = json_decode(trim($body));
            curl_close($ch);

            if ($error_code > 0) throw new Exception("AccessCode Error(HTTP STATUS : " . $status_code . ")", $error_code);
            if (empty($r)) throw new Exception("API서버로부터 응답이 올바르지 않습니다. " . $body, 1);
            if ($r->code !== 0) throw new IamportRequestException($r);

            return $r->response;
        }

        protected function deleteResponse($request_url, $headers = array())
        {
            $default_header = array('Content-Type: application/json');
            $headers = array_merge($default_header, $headers);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $request_url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            //execute delete
            $body = curl_exec($ch);
            $error_code = curl_errno($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            $r = json_decode(trim($body));
            curl_close($ch);

            if ($error_code > 0) throw new Exception("Request Error(HTTP STATUS : " . $status_code . ")", $error_code);
            if (empty($r)) throw new Exception("API서버로부터 응답이 올바르지 않습니다. " . $body, 1);
            if ($r->code !== 0) throw new IamportRequestException($r);

            return $r->response;
        }

        protected function getAccessCode()
        {
            try {
                $now = time();
                if ($now < $this->expired_at && !empty($this->access_token)) return $this->access_token;

                $this->expired_at = null;
                $this->access_token = null;
                $response = $this->postResponse(
                    self::GET_TOKEN_URL,
                    array(
                        'imp_key' => $this->imp_key,
                        'imp_secret' => $this->imp_secret
                    )
                );

                $offset = $response->expired_at - $response->now;

                $this->expired_at = time() + $offset;
                $this->access_token = $response->access_token;

                return $response->access_token;
            } catch (Exception $e) {
                throw new IamportAuthException('[API인증오류] ' . $e->getMessage(), $e->getCode());
            }
        }
    }
}
