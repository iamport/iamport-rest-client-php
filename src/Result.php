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
    protected $success = false;

    /**
     * @var mixed
     */
    protected $data;

    /**
     * @var array|null
     */
    protected $error;

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

    /**
     * @return bool
     */
    public function getSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array|null
     */
    public function getError(): ?array
    {
        return $this->error;
    }
}
