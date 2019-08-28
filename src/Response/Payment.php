<?php

namespace Iamport\RestClient\Response;

class Payment extends Base
{
    public function getData($name)
    {
        if (!isset($this->responseBody->{$name})) {
            return null;
        }

        return $this->responseBody->{$name};
    }

    public function getCustomData($name)
    {
        $data = $this->getData('custom_data');
        if (!isset($data->{$name})) {
            return null;
        }

        return $data->{$name};
    }
}
