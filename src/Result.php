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
     * @var mixed
     */
    protected $error;

    /**
     * Result constructor.
     *
     * @param bool   $success
     * @param mixed  $data
     * @param object $error
     */
    public function __construct(bool $success = false, $data = null, $error = null)
    {
        $this->success = $success;
        $this->data    = $data;
        $this->error   = is_null($error) ? null : $error;
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
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }
}
