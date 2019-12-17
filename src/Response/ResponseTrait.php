<?php

namespace Iamport\RestClient\Response;

use DateTime;

/**
 * Trait ResponseTrait.
 */
trait ResponseTrait
{
    /**
     * @param $name
     *
     * @return mixed|null
     */
    public function __get($name)
    {
        $getter = 'get' . str_replace('_', '', ucwords($name, '_'));
        if (method_exists($this, $getter)) {
            return $this->$getter();
        }
    }

    /**
     * 변환되지 않은 원본 프로퍼티에 접근할 경우 사용.
     *
     * @param $key
     *
     * @return mixed|null
     */
    public function getAttributes($key)
    {
        return $this->{$key};
    }

    /**
     * @return false|int|string
     *
     * @throws \Exception
     */
    public function timestampToDate(int $timestamp, string $format = null)
    {
        $format = $format ?? 'Y-m-d H:i:s';

        return ($timestamp === 0) ? 0 : (new DateTime())->setTimestamp($timestamp)->format($format);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }

    /**
     * @return false|string
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
