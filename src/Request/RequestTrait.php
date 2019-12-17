<?php

namespace Iamport\RestClient\Request;

/**
 * Trait RequestTrait.
 */
trait RequestTrait
{
    /**
     * PHP 7.4 이전버전에서 property 타입체크를 위해 magic method를 통해 setter 호출.
     *
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $setter = 'set' . $this->toCamel($name);
        if (method_exists($this, $setter)) {
            $this->$setter($value);
        }
    }

    /**
     * private property에 접근하기 위한 magic method.
     *
     * @example $property->{$name}
     *
     * @param $name
     *
     * @return string|null
     */
    public function __get($name)
    {
        if (!isset($this->{$name})) {
            return null;
        }

        return $this->{$name};
    }

    /**
     * @return string
     */
    public function toCamel(string $string)
    {
        return str_replace('_', '', ucwords($string, '_'));
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $vars  = get_object_vars($this);
        $array = [];
        foreach ($vars as $key => $value) {
            // formdata에 불필표한 데이터 제외하고 배열로 전환
            if (
                !in_array($key, [
                    'instanceType', 'verb', 'responseType', 'authenticated',
                    'isCollection', 'responseClass', 'isPaged', 'client',
                ])
            ) {
                $array[ltrim($key, '_')] = $value;
            }
        }

        return $array;
    }

    /**
     * @param $date
     * @param string $timezone
     */
    public function dateToTimestamp($date, $timezone = 'Asia/Seoul'): int
    {
        date_default_timezone_set($timezone);
        switch (gettype($date)) {
            case 'integer':
                return $date;
                break;
            case 'object':
                return $date->getTimestamp();
                break;
            case 'string':
                return strtotime(date($date));
                break;
            default:
                return $date;
        }
    }

    /**
     * 배열에 넘겨진 property unset.
     */
    private function unsetArray(array $array): void
    {
        for ($i = 0; $i < count($array); ++$i) {
            unset($this->{$array[$i]});
        }
    }
}
