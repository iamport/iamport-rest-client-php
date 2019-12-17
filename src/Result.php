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
     * @var mixed
     */
    protected $extraCondition;

    /**
     * Result constructor.
     *
     * @param mixed  $data
     * @param object $error
     * @param mixed  $extraCondition
     */
    public function __construct($data = null, $error = null, $extraCondition = null)
    {
        $this->data           = $data;
        $this->error          = is_null($error) ? null : $error;
        $this->extraCondition = $extraCondition;
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

    /**
     * code == 0이고 데이터도 정상응답 받았지만 그 안에서 추가적인 검증로직이 필요할 경우 수행.
     *
     * @return bool
     */
    public function isSuccess()
    {
        if ($this->hasData()) {
            if ($this->extraCondition === null) {
                return true;
            } else {
                if (($this->extraCondition)($this->getData()) === true) {
                    return true;
                }

                return false;
            }
        } else {
            return false;
        }
    }

    private function hasData(): bool
    {
        return ($this->getData() === null) ? false : true;
    }
}
