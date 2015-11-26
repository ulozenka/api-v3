<?php

namespace UlozenkaLib\APIv3\Model;

/**
 * Class Error
 * @package UlozenkaLib\APIv3\Model
 */
class Error
{

    /** @var string */
    protected $code;

    /** @var string */
    protected $description;

    /**
     *
     * @param string $code
     * @param string $description
     */
    public function __construct($code, $description)
    {
        $this->code = $code;
        $this->description = $description;
    }

    /**
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
