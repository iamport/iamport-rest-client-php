<?php

namespace Iamport\RestClient;

/**
 * Class Result.
 */
class Result
{
    /**
     * @var bool
     */
    public $success = false;

    /**
     * @var mixed
     */
    public $data;

    /**
     * @var array|null
     */
    public $error;

    /**
     * Result constructor.
     *
     * @param bool  $success
     * @param mixed $data
     * @param array $error
     */
    public function __construct(bool $success = false, $data = null, array $error = null)
    {
        $this->success = $success;
        $this->data    = $data;
        $this->error   = is_null($error) ? null : [
            'code'    => $error['code'],
            'message' => $error['message'],
        ];
    }
}
