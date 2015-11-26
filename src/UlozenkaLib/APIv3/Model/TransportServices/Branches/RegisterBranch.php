<?php

namespace UlozenkaLib\APIv3\Model\TransportServices\Branches;

use UlozenkaLib\APIv3\Model\TransportServices\Branches\RegisterBranch\Destination;

/**
 * Class RegisterBranch
 * @package UlozenkaLib\APIv3\Model
 */
class RegisterBranch extends Branch
{

    /** @var Destination[] */
    protected $destinations;

    /**
     *
     * @param Destination[] $destinations
     */
    public function __construct($destinations)
    {
        $this->destinations = $destinations;
    }

    /**
     *
     * @return Destination[]
     */
    public function getDestinations()
    {
        return $this->destinations;
    }
}
