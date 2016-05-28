<?php

namespace UlozenkaLib\APIv3\Model\Tracking\TransportService\DestinationBranch;

/**
 * Class Gps
 * @package UlozenkaLib\APIv3\Model\Tracking
 */
class Gps
{

    /** @var float */
    protected $latitude;

    /** @var float */
    protected $longitude;

    /**
     *
     * @param float $latitude
     * @param float $longitude
     */
    public function __construct($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
}
