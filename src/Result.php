<?php

namespace Iamport\RestClient;

/**
 * Class Result.
 */
class Result
{
    public $success = false;
    public $data;
    public $error;

    /**
     * Result constructor.
     *
     * @param bool $success
     * @param null $data
     * @param null $error
     */
    public function __construct($success = false, $data = null, $error = null)
    {
        $this->success = $success;
        $this->data    = $data;
        $this->error   = is_null($error) ? null : [
            'code'    => $error['code'],
            'message' => $error['message'],
        ];
    }
}
