<?php

namespace Iamport\RestClient\Request;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Response;

/**
 * Class Paymentwall.
 *
 * @property string $imp_uid
 * @property string $merchant_uid
 * @property string $type
 * @property string $status
 * @property string $carrier_tracking_id
 * @property string $carrier_type
 * @property int    $estimated_delivery_datetime
 * @property int    $estimated_update_datetime
 * @property string $reason
 * @property string $refundable
 * @property string $details
 * @property string $shipping_address_email
 * @property string $shipping_address_country
 * @property string $shipping_address_city
 * @property string $shipping_address_zip
 * @property string $shipping_address_state
 * @property string $shipping_address_street
 * @property string $shipping_address_phone
 * @property string $shipping_address_firstname
 * @property string $shipping_address_lastname
 */
class Paymentwall extends RequestBase
{
    use RequestTrait;

    /**
     * @var string 아임포트 고유번호
     */
    protected $imp_uid;

    /**
     * @var string 가맹점 거래 고유번호
     */
    protected $merchant_uid;

    /**
     * @var string 배송 타입
     */
    protected $type;

    /**
     * @var string 배송 상태
     */
    protected $status;

    /**
     * @var string 운송장 번호
     */
    protected $carrier_tracking_id;

    /**
     * @var string 택배사 코드
     */
    protected $carrier_type;

    /**
     * @var int 예상 배송일시 UNIX TIMESTAMP
     */
    protected $estimated_delivery_datetime;

    /**
     * @var int 예상 업데이트 일시 UNIX TIMESTAMP
     */
    protected $estimated_update_datetime;

    /**
     * @var string 사유
     */
    protected $reason;

    /**
     * @var string 환불 가능 여부
     */
    protected $refundable;

    /**
     * @var string 상세 정보
     */
    protected $details;

    /**
     * @var string 배송지 이메일
     */
    protected $shipping_address_email;

    /**
     * @var string 배송지 국가
     */
    protected $shipping_address_country;

    /**
     * @var string 배송지 도시
     */
    protected $shipping_address_city;

    /**
     * @var string 배송지 우편번호
     */
    protected $shipping_address_zip;

    /**
     * @var string 배송지 주/도
     */
    protected $shipping_address_state;

    /**
     * @var string 배송지 거리
     */
    protected $shipping_address_street;

    /**
     * @var string 배송지 전화번호
     */
    protected $shipping_address_phone;

    /**
     * @var string 배송지 이름(성)
     */
    protected $shipping_address_firstname;

    /**
     * @var string 배송지 이름(이름)
     */
    protected $shipping_address_lastname;

    /**
     * Paymentwall constructor.
     */
    public function __construct()
    {
    }

    /**
     * 페이먼트월 배송등록.
     *
     * @return Paymentwall
     */
    public static function delivery(
        string $impUid,
        string $merchantUid,
        string $type,
        string $status,
        int $estimatedDeliveryDatetime,
        int $estimatedUpdateDatetime,
        string $refundable,
        string $shippingAddressEmail
    ) {
        $instance                              = new self();
        $instance->imp_uid                     = $impUid;
        $instance->merchant_uid                = $merchantUid;
        $instance->type                        = $type;
        $instance->status                      = $status;
        $instance->estimated_delivery_datetime = $estimatedDeliveryDatetime;
        $instance->estimated_update_datetime   = $estimatedUpdateDatetime;
        $instance->refundable                  = $refundable;
        $instance->shipping_address_email      = $shippingAddressEmail;
        $instance->responseClass               = Response\PaymentwallDelivery::class;
        $instance->instanceType                = 'delivery';

        return $instance;
    }

    public function setImpUid(string $imp_uid): void
    {
        $this->imp_uid = $imp_uid;
    }

    public function setMerchantUid(string $merchant_uid): void
    {
        $this->merchant_uid = $merchant_uid;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function setCarrierTrackingId(string $carrier_tracking_id): void
    {
        $this->carrier_tracking_id = $carrier_tracking_id;
    }

    public function setCarrierType(string $carrier_type): void
    {
        $this->carrier_type = $carrier_type;
    }

    public function setEstimatedDeliveryDatetime(int $estimated_delivery_datetime): void
    {
        $this->estimated_delivery_datetime = $estimated_delivery_datetime;
    }

    public function setEstimatedUpdateDatetime(int $estimated_update_datetime): void
    {
        $this->estimated_update_datetime = $estimated_update_datetime;
    }

    public function setReason(string $reason): void
    {
        $this->reason = $reason;
    }

    public function setRefundable(string $refundable): void
    {
        $this->refundable = $refundable;
    }

    public function setDetails(string $details): void
    {
        $this->details = $details;
    }

    public function setShippingAddressEmail(string $shipping_address_email): void
    {
        $this->shipping_address_email = $shipping_address_email;
    }

    public function setShippingAddressCountry(string $shipping_address_country): void
    {
        $this->shipping_address_country = $shipping_address_country;
    }

    public function setShippingAddressCity(string $shipping_address_city): void
    {
        $this->shipping_address_city = $shipping_address_city;
    }

    public function setShippingAddressZip(string $shipping_address_zip): void
    {
        $this->shipping_address_zip = $shipping_address_zip;
    }

    public function setShippingAddressState(string $shipping_address_state): void
    {
        $this->shipping_address_state = $shipping_address_state;
    }

    public function setShippingAddressStreet(string $shipping_address_street): void
    {
        $this->shipping_address_street = $shipping_address_street;
    }

    public function setShippingAddressPhone(string $shipping_address_phone): void
    {
        $this->shipping_address_phone = $shipping_address_phone;
    }

    public function setShippingAddressFirstname(string $shipping_address_firstname): void
    {
        $this->shipping_address_firstname = $shipping_address_firstname;
    }

    public function setShippingAddressLastname(string $shipping_address_lastname): void
    {
        $this->shipping_address_lastname = $shipping_address_lastname;
    }

    /**
     * 페이먼트월 배송등록
     * [POST] /paymentwall/delivery.
     */
    public function path(): string
    {
        return Endpoint::PAYMENTWALL_DELIVERY;
    }

    public function attributes(): array
    {
        return [
            'body' => json_encode($this->toArray()),
        ];
    }

    public function verb(): string
    {
        return 'POST';
    }
}
