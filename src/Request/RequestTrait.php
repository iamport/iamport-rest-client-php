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
        $setter = 'set'.$this->toCamel($name);
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
     * @param string $string
     *
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
            $array[ltrim($key, '_')] = $value;
        }

        return $array;
    }
}
