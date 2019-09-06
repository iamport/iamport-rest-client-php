<?php

namespace Iamport\RestClient\Response;

class Response extends Base
{
    protected $customData = null;

    /**
     * Response constructor.
     *
     * @param $response
     */
    public function __construct($response)
    {
        if(isset($response->custom_data)){
            $this->customData = json_decode($response->custom_data);
        }
        parent::__construct($response);
    }

    public function __get($name)
    {
        if (!isset($this->responseBody->{$name})) {
            return null;
        }

        return $this->responseBody->{$name};
    }

    public function getCustomData($name)
    {
        $data = $this->customData;
        if (!isset($data->{$name})) {
            return null;
        }

        return $data->{$name};
    }
}
