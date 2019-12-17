<?php

namespace Iamport\RestClient\Response;

/**
 * Class Payment.
 */
class Payment
{
    use ResponseTrait;

    /**
     * @var string
     */
    protected $imp_uid;

    /**
     * @var string
     */
    protected $merchant_uid;

    /**
     * @var string
     */
    protected $pay_method;

    /**
     * @var string
     */
    protected $channel;

    /**
     * @var string
     */
    protected $pg_provider;

    /**
     * @var string
     */
    protected $pg_tid;

    /**
     * @var string
     */
    protected $pg_id;

    /**
     * @var bool
     */
    protected $escrow;

    /**
     * @var string
     */
    protected $apply_num;

    /**
     * @var string
     */
    protected $bank_code;

    /**
     * @var string
     */
    protected $bank_name;

    /**
     * @var string
     */
    protected $card_code;

    /**
     * @var string
     */
    protected $card_name;

    /**
     * @var int
     */
    protected $card_quota;

    /**
     * @var string|null
     */
    protected $card_number;

    /**
     * @var int|null
     */
    protected $card_type;

    /**
     * @var string
     */
    protected $vbank_code;

    /**
     * @var string
     */
    protected $vbank_name;

    /**
     * @var string
     */
    protected $vbank_num;

    /**
     * @var string
     */
    protected $vbank_holder;

    /**
     * @var int
     */
    protected $vbank_date;

    /**
     * @var int
     */
    protected $vbank_issued_at;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $amount;

    /**
     * @var int
     */
    protected $cancel_amount;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @var string
     */
    protected $buyer_name;

    /**
     * @var string
     */
    protected $buyer_email;

    /**
     * @var string
     */
    protected $buyer_tel;

    /**
     * @var string
     */
    protected $buyer_addr;

    /**
     * @var string
     */
    protected $buyer_postcode;

    /**
     * @var string
     */
    protected $custom_data;

    /**
     * @var string
     */
    protected $user_agent;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var int
     */
    protected $paid_at;

    /**
     * @var int
     */
    protected $failed_at;

    /**
     * @var int
     */
    protected $cancelled_at;

    /**
     * @var string
     */
    protected $fail_reason;

    /**
     * @var string
     */
    protected $cancel_reason;

    /**
     * @var string
     */
    protected $receipt_url;

    /**
     * @var array
     */
    protected $cancel_history;

    /**
     * @var array
     */
    protected $cancel_receipt_urls;

    /**
     * @var bool
     */
    protected $cash_receipt_issued;

    /**
     * Payment constructor.
     */
    public function __construct(array $response)
    {
        $this->imp_uid                  = $response['imp_uid'];
        $this->merchant_uid             = $response['merchant_uid'];
        $this->pay_method               = $response['pay_method'];
        $this->channel                  = $response['channel'];
        $this->pg_provider              = $response['pg_provider'];
        $this->pg_tid                   = $response['pg_tid'];
        $this->pg_id                    = $response['pg_id'];
        $this->escrow                   = $response['escrow'];
        $this->apply_num                = $response['apply_num'];
        $this->bank_code                = $response['bank_code'];
        $this->bank_name                = $response['bank_name'];
        $this->card_code                = $response['card_code'];
        $this->card_name                = $response['card_name'];
        $this->card_quota               = $response['card_quota'];
        $this->card_number              = $response['card_number'] ?? null;
        $this->card_type                = $response['card_type'] ?? null;
        $this->vbank_code               = $response['vbank_code'];
        $this->vbank_name               = $response['vbank_name'];
        $this->vbank_num                = $response['vbank_num'];
        $this->vbank_holder             = $response['vbank_holder'];
        $this->vbank_date               = $response['vbank_date'];
        $this->vbank_issued_at          = $response['vbank_issued_at'];
        $this->name                     = $response['name'];
        $this->amount                   = $response['amount'];
        $this->cancel_amount            = $response['cancel_amount'];
        $this->currency                 = $response['currency'];
        $this->buyer_name               = $response['buyer_name'];
        $this->buyer_email              = $response['buyer_email'];
        $this->buyer_tel                = $response['buyer_tel'];
        $this->buyer_addr               = $response['buyer_addr'];
        $this->buyer_postcode           = $response['buyer_postcode'];
        $this->custom_data              = $response['custom_data'];
        $this->user_agent               = $response['user_agent'];
        $this->status                   = $response['status'];
        $this->paid_at                  = $response['paid_at'];
        $this->failed_at                = $response['failed_at'];
        $this->cancelled_at             = $response['cancelled_at'];
        $this->fail_reason              = $response['fail_reason'];
        $this->cancel_reason            = $response['cancel_reason'];
        $this->receipt_url              = $response['receipt_url'];
        $this->cash_receipt_issued      = $response['cash_receipt_issued'];

        if (!is_null($response['cancel_history'])) {
            foreach ($response['cancel_history'] as $item) {
                $this->cancel_history[] = new PaymentCancel($item);
            }
        } else {
            $this->cancel_history = [];
        }

        if (!is_null($response['cancel_receipt_urls'])) {
            foreach ($response['cancel_receipt_urls'] as $item) {
                $this->cancel_receipt_urls[] = $item;
            }
        } else {
            $this->cancel_receipt_urls = [];
        }
    }

    /**
     * @return mixed
     */
    public function getImpUid()
    {
        return $this->imp_uid;
    }

    /**
     * @return mixed
     */
    public function getMerchantUid()
    {
        return $this->merchant_uid;
    }

    /**
     * @return mixed
     */
    public function getPayMethod()
    {
        return $this->pay_method;
    }

    /**
     * @return mixed
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @return mixed
     */
    public function getPgProvider()
    {
        return $this->pg_provider;
    }

    /**
     * @return mixed
     */
    public function getPgTid()
    {
        return $this->pg_tid;
    }

    /**
     * @return mixed
     */
    public function getPgId()
    {
        return $this->pg_id;
    }

    /**
     * @return mixed
     */
    public function getEscrow()
    {
        return $this->escrow;
    }

    /**
     * @return mixed
     */
    public function getApplyNum()
    {
        return $this->apply_num;
    }

    /**
     * @return mixed
     */
    public function getBankCode()
    {
        return $this->bank_code;
    }

    /**
     * @return mixed
     */
    public function getBankName()
    {
        return $this->bank_name;
    }

    /**
     * @return mixed
     */
    public function getCardCode()
    {
        return $this->card_code;
    }

    /**
     * @return mixed
     */
    public function getCardName()
    {
        return $this->card_name;
    }

    /**
     * @return mixed
     */
    public function getCardQuota()
    {
        return $this->card_quota;
    }

    /**
     * @return mixed|null
     */
    public function getCardNumber()
    {
        return $this->card_number;
    }

    /**
     * @return mixed|null
     */
    public function getCardType()
    {
        return $this->card_type;
    }

    /**
     * @return mixed
     */
    public function getVbankCode()
    {
        return $this->vbank_code;
    }

    /**
     * @return mixed
     */
    public function getVbankName()
    {
        return $this->vbank_name;
    }

    /**
     * @return mixed
     */
    public function getVbankNum()
    {
        return $this->vbank_num;
    }

    /**
     * @return mixed
     */
    public function getVbankHolder()
    {
        return $this->vbank_holder;
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function getVbankDate()
    {
        return $this->timestampToDate($this->vbank_date);
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function getVbankIssuedAt()
    {
        return $this->timestampToDate($this->vbank_issued_at);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return mixed
     */
    public function getCancelAmount()
    {
        return $this->cancel_amount;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return mixed
     */
    public function getBuyerName()
    {
        return $this->buyer_name;
    }

    /**
     * @return mixed
     */
    public function getBuyerEmail()
    {
        return $this->buyer_email;
    }

    /**
     * @return mixed
     */
    public function getBuyerTel()
    {
        return $this->buyer_tel;
    }

    /**
     * @return mixed
     */
    public function getBuyerAddr()
    {
        return $this->buyer_addr;
    }

    /**
     * @return mixed
     */
    public function getBuyerPostcode()
    {
        return $this->buyer_postcode;
    }

    /**
     * @return mixed
     */
    public function getCustomData()
    {
        return json_decode($this->custom_data);
    }

    /**
     * @return mixed
     */
    public function getUserAgent()
    {
        return $this->user_agent;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function getPaidAt()
    {
        return $this->timestampToDate($this->paid_at);
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function getFailedAt()
    {
        return $this->timestampToDate($this->failed_at);
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function getCancelledAt()
    {
        return $this->timestampToDate($this->cancelled_at);
    }

    /**
     * @return mixed
     */
    public function getFailReason()
    {
        return $this->fail_reason;
    }

    /**
     * @return mixed
     */
    public function getCancelReason()
    {
        return $this->cancel_reason;
    }

    /**
     * @return mixed
     */
    public function getReceiptUrl()
    {
        return $this->receipt_url;
    }

    /**
     * @return mixed
     */
    public function getCancelHistory()
    {
        return $this->cancel_history;
    }

    /**
     * @return mixed
     */
    public function getCancelReceiptUrls()
    {
        return $this->cancel_receipt_urls;
    }

    /**
     * @return mixed
     */
    public function getCashReceiptIssued()
    {
        return $this->cash_receipt_issued;
    }

    /**
     * @return mixed
     */
    public function isPaid(): bool
    {
        return ($this->status === 'paid') ? true : false;
    }
}
