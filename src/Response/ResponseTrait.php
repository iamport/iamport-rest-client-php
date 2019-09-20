<?php


namespace Iamport\RestClient\Response;


trait ResponseTrait
{
    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        $getter = 'get'.str_replace('_', '', ucwords($name, '_'));
        if (method_exists($this, $getter)) {
            return $this->$getter();
        }
    }
}