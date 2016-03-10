<?php

namespace UlozenkaLib\APIv3\Model\Tracking;

/**
 * Class TransportServiceBranches
 * @package UlozenkaLib\APIv3\Model
 */
class Tracking
{

    /** @var Consignment */
    protected $consignment;

    /** @var  Status[] */
    protected $statuses;

    /**
     * @param Consignment $consignment
     * @param Status[] $statuses
     */
    public function __construct($consignment, $statuses)
    {
        $this->consignment = $consignment;
        $this->statuses = $statuses;
    }

    /**
     *
     * @return Consignment
     */
    public function getConsignment()
    {
        return $this->consignment;
    }

    /**
     * @return Status[]
     */
    public function getStatuses()
    {
        return $this->statuses;
    }

}
