<?php


namespace Iamport\RestClient\Response;


class Response
{
    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if (!isset($this->{$name})) {
            return null;
        }

        return $this->{$name};
    }
}