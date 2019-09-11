<?php

namespace Iamport\RestClient\Response;

/**
 * Class Response.
 */
class Response extends ResponseBase
{
    /**
     * @var mixed|null
     */
    protected $customData = null;

    /**
     * Response constructor.
     *
     * @param $response
     */
    public function __construct($response)
    {
        if (isset($response->custom_data)) {
            $this->customData = json_decode($response->custom_data);
        }
        parent::__construct($response);
    }

    /**
     * @param $name
     *
     * @return |null
     */
    public function __get($name)
    {
        if (!isset($this->responseBody->{$name})) {
            return null;
        }

        return $this->responseBody->{$name};
    }

    /**
     * @param $name
     *
     * @return |null
     */
    public function getCustomData($name)
    {
        $data = $this->customData;
        if (!isset($data->{$name})) {
            return null;
        }

        return $data->{$name};
    }
}
