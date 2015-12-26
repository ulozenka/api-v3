<?php

namespace UlozenkaLib\APIv3\Model\TransportService\Branch;

/**
 * Class TransportServiceBranches
 * @package UlozenkaLib\APIv3\Model
 */
class TransportServiceBranches
{

    /** @var RegisterBranch[] */
    protected $register;

    /** @var DestinationBranch[] */
    protected $destination;

    /**
     *
     * @param RegisterBranch[] $register
     * @param DestinationBranch[] $destination
     */
    public function __construct($register, $destination)
    {
        $this->register = $register;
        $this->destination = $destination;
    }

    /**
     *
     * @return RegisterBranch[]
     */
    public function getRegister()
    {
        return $this->register;
    }

    /**
     *
     * @return DestinationBranch[]
     */
    public function getDestination()
    {
        return $this->destination;
    }
}
