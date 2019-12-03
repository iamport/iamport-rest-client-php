<?php

namespace Iamport\RestClient;

/**
 * Class Result.
 */
class Result
{

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
     * @param mixed  $data
     * @param object $error
     */
    public function __construct($data = null, $error = null)
    {
        $this->data    = $data;
        $this->error   = is_null($error) ? null : $error;
    }

    /**
     * @return bool
     */
    public function hasData(): bool
    {
        return ($this->getData() === null) ? false : true;
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
