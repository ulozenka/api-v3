<?php

namespace UlozenkaLib\APIv3\Model\Branch;

/**
 * Class Navigation
 * @package UlozenkaLib\APIv3\Model
 */
class Navigation
{

    /** @var string */
    protected $general;

    /** @var string */
    protected $car;

    /** @var string */
    protected $publicTransport;

    /**
     *
     * @param string $general
     * @param string $car
     * @param string $publicTransport
     */
    public function __construct($general = null, $car = null, $publicTransport = null)
    {
        $this->general = $general;
        $this->car = $car;
        $this->publicTransport = $publicTransport;
    }

    /**
     *
     * @return string|null
     */
    public function getGeneral()
    {
        return $this->general;
    }

    /**
     *
     * @return string|null
     */
    public function getCar()
    {
        return $this->car;
    }

    /**
     *
     * @return string|null
     */
    public function getPublicTransport()
    {
        return $this->publicTransport;
    }

    /**
     *
     * @param string $general
     * @return Navigation
     */
    public function setGeneral($general)
    {
        $this->general = $general;
        return $this;
    }

    /**
     *
     * @param string $car
     * @return Navigation
     */
    public function setCar($car)
    {
        $this->car = $car;
        return $this;
    }

    /**
     *
     * @param string $publicTransport
     * @return Navigation
     */
    public function setPublicTransport($publicTransport)
    {
        $this->publicTransport = $publicTransport;
        return $this;
    }
}
